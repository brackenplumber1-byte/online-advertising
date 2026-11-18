#!/usr/bin/env python3
"""
facebook_login.py — OAuth login for the Facebook Marketing skill.

Unlike a browser-cookie based login, Facebook uses a real OAuth
authorization-code flow: this script opens the Facebook consent
dialog in the user's own default browser, runs a short-lived local
HTTP server to catch the redirect, and exchanges the resulting code
for a long-lived user access token. It then fetches every Page the
user manages and stores per-Page access tokens (which do not expire
while the user token / grant is valid).

Prerequisites (one-time, done by the human in the Meta dashboard):
  1. Create an app at https://developers.facebook.com/apps
  2. Add the "Facebook Login" and "Marketing API" products.
  3. Under Facebook Login > Settings, add this Valid OAuth Redirect URI:
       http://localhost:8765/callback
     (or whatever --port you pass)
  4. Copy the App ID + App Secret into your .env as FB_APP_ID / FB_APP_SECRET.

Actions
-------
  --action login     Idempotent. If a saved user token still validates,
                      skips the browser entirely. Otherwise opens the
                      consent screen, then fetches + saves Page tokens.
  --action check      Debug the currently stored/given token: validity,
                      expiry, granted scopes.
  --action pages       List Pages the token can manage (and re-save their
                      Page tokens without a full re-login).

All state is stored under ~/.facebook/tokens.json (override with
FACEBOOK_HOME). Never commit this file — it contains live access tokens.
"""

from __future__ import annotations

import argparse
import secrets
import threading
import time
import urllib.parse
import webbrowser
from http.server import BaseHTTPRequestHandler, HTTPServer

import requests

from facebook_common import (
    api_version,
    app_id,
    app_secret,
    fail,
    graph_request,
    load_tokens,
    log,
    result_line,
    save_instagram_account,
    save_page_token,
    save_tokens,
)

DEFAULT_SCOPES = [
    "pages_show_list",
    "pages_read_engagement",
    "pages_manage_posts",
    "pages_manage_engagement",
    "pages_manage_metadata",
    "ads_management",
    "ads_read",
    "read_insights",
    "business_management",
    "instagram_basic",
    "instagram_content_publish",
]


class _CallbackState:
    code: str | None = None
    state: str | None = None
    error: str | None = None


def _make_handler(expected_state: str, captured: _CallbackState):
    class Handler(BaseHTTPRequestHandler):
        def do_GET(self):  # noqa: N802
            parsed = urllib.parse.urlparse(self.path)
            if parsed.path != "/callback":
                self.send_response(404)
                self.end_headers()
                return
            qs = urllib.parse.parse_qs(parsed.query)
            got_state = qs.get("state", [None])[0]
            if "error" in qs:
                captured.error = qs.get("error_description", qs.get("error"))[0]
            elif got_state != expected_state:
                captured.error = "state mismatch (possible CSRF) — aborting"
            else:
                captured.code = qs.get("code", [None])[0]
                captured.state = got_state

            self.send_response(200)
            self.send_header("Content-Type", "text/html")
            self.end_headers()
            if captured.code:
                body = "<html><body><h2>Facebook connected. You can close this tab.</h2></body></html>"
            else:
                body = f"<html><body><h2>Login failed: {captured.error}</h2></body></html>"
            self.wfile.write(body.encode())

        def log_message(self, fmt, *args):  # silence default HTTP logging
            pass

    return Handler


def _user_token_still_valid(token: str) -> bool:
    try:
        graph_request("GET", "me", token, params={"fields": "id,name"})
        return True
    except Exception:
        return False


def _fetch_and_save_pages(user_token: str) -> list[dict]:
    fields = "id,name,access_token,category,tasks,instagram_business_account{id,username}"
    body = graph_request("GET", "me/accounts", user_token, params={"fields": fields, "limit": 200})
    pages = body.get("data", [])
    for p in pages:
        save_page_token(p["id"], p.get("name", ""), p["access_token"], p.get("category"))
        ig = p.get("instagram_business_account")
        if ig:
            save_instagram_account(p["id"], ig["id"], ig.get("username"))
    return pages


def _page_summary(p: dict) -> dict:
    summary = {"id": p["id"], "name": p.get("name"), "category": p.get("category")}
    ig = p.get("instagram_business_account")
    if ig:
        summary["instagram"] = {"id": ig["id"], "username": ig.get("username")}
    return summary


def cmd_login(args: argparse.Namespace) -> None:
    aid, secret = app_id(), app_secret()
    if not aid or not secret:
        fail("FB_APP_ID and FB_APP_SECRET must be set (see .env.example) before logging in.")

    tokens = load_tokens()
    existing = tokens.get("user_access_token")
    if not args.force and existing and _user_token_still_valid(existing):
        log("Existing user access token is still valid — skipping browser login.")
        pages = _fetch_and_save_pages(existing)
        result_line({
            "status": "logged_in",
            "reused_existing_token": True,
            "pages": [_page_summary(p) for p in pages],
        })
        return

    redirect_uri = f"http://localhost:{args.port}/callback"
    state = secrets.token_urlsafe(24)
    scopes = args.scopes.split(",") if args.scopes else DEFAULT_SCOPES

    auth_url = (
        f"https://www.facebook.com/{api_version()}/dialog/oauth?"
        + urllib.parse.urlencode({
            "client_id": aid,
            "redirect_uri": redirect_uri,
            "state": state,
            "response_type": "code",
            "scope": ",".join(scopes),
        })
    )

    captured = _CallbackState()
    server = HTTPServer(("localhost", args.port), _make_handler(state, captured))
    server_thread = threading.Thread(target=server.serve_forever, daemon=True)
    server_thread.start()

    log(f"Opening consent screen in your browser: {auth_url}")
    log("If a browser window does not open (headless/agent environment), copy the URL above into"
        " a browser on a machine where you can sign in, then paste the redirected localhost URL's"
        " `code` param back — or simply run this script from a machine with a GUI.")
    opened = webbrowser.open(auth_url)
    if not opened:
        log("webbrowser.open() reported no browser was launched — see the URL logged above.")

    deadline = time.time() + args.timeout
    while captured.code is None and captured.error is None and time.time() < deadline:
        time.sleep(0.25)
    server.shutdown()

    if captured.error:
        fail(f"Facebook login failed: {captured.error}")
    if not captured.code:
        fail(f"Timed out after {args.timeout}s waiting for the OAuth redirect. Re-run and complete the "
             f"consent screen faster, or pass --timeout to allow more time.")

    # Exchange the authorization code for a short-lived user token.
    short = graph_request("GET", "oauth/access_token", "", params={
        "client_id": aid,
        "client_secret": secret,
        "redirect_uri": redirect_uri,
        "code": captured.code,
    })
    short_token = short["access_token"]

    # Immediately exchange for a long-lived (~60 day) user token.
    long = graph_request("GET", "oauth/access_token", "", params={
        "grant_type": "fb_exchange_token",
        "client_id": aid,
        "client_secret": secret,
        "fb_exchange_token": short_token,
    })
    long_token = long["access_token"]
    expires_in = long.get("expires_in")

    data = load_tokens()
    data["user_access_token"] = long_token
    data["user_access_token_saved_at"] = time.time()
    data["user_access_token_expires_in"] = expires_in
    save_tokens(data)

    pages = _fetch_and_save_pages(long_token)

    result_line({
        "status": "logged_in",
        "reused_existing_token": False,
        "expires_in_seconds": expires_in,
        "pages": [_page_summary(p) for p in pages],
        "note": "Page access tokens were saved and do not expire while the user grant is valid. "
                "Ad account access uses the user token directly (see facebook_ads.py). Any Page "
                "with a linked Instagram Business account shows an `instagram` field — use "
                "instagram_post.py to publish there.",
    })


def cmd_check(args: argparse.Namespace) -> None:
    token = args.access_token or load_tokens().get("user_access_token")
    if not token:
        fail("No token to check. Pass --access-token or run --action login first.")

    aid, secret = app_id(), app_secret()
    params = {"input_token": token}
    if aid and secret:
        params["access_token"] = f"{aid}|{secret}"
        body = graph_request("GET", "debug_token", "", params=params)
        info = body.get("data", {})
        result_line({
            "status": "ok",
            "is_valid": info.get("is_valid"),
            "app_id": info.get("app_id"),
            "user_id": info.get("user_id"),
            "expires_at": info.get("expires_at"),
            "scopes": info.get("scopes"),
        })
    else:
        me = graph_request("GET", "me", token, params={"fields": "id,name"})
        result_line({"status": "ok", "is_valid": True, "me": me, "note": "Set FB_APP_ID/FB_APP_SECRET for full debug_token details."})


def cmd_pages(args: argparse.Namespace) -> None:
    token = args.access_token or load_tokens().get("user_access_token")
    if not token:
        fail("No user token available. Run --action login first, or pass --access-token.")
    pages = _fetch_and_save_pages(token)
    result_line({
        "status": "ok",
        "count": len(pages),
        "pages": [_page_summary(p) for p in pages],
    })


def cmd_instagram(args: argparse.Namespace) -> None:
    """Re-fetch Pages and report which have a linked Instagram Business account."""
    token = args.access_token or load_tokens().get("user_access_token")
    if not token:
        fail("No user token available. Run --action login first, or pass --access-token.")
    pages = _fetch_and_save_pages(token)
    linked = [_page_summary(p) for p in pages if p.get("instagram_business_account")]
    unlinked = [p.get("name") for p in pages if not p.get("instagram_business_account")]
    result_line({
        "status": "ok",
        "linked": linked,
        "pages_without_instagram": unlinked,
        "note": None if linked else (
            "No Page has a linked Instagram Business account yet. In the Instagram app: "
            "Settings and privacy > Account type and tools > switch to a Business/Creator "
            "account, then link it to your Facebook Page from that same settings area."
        ),
    })


def main() -> None:
    parser = argparse.ArgumentParser(description="OAuth login + Page token management for Facebook.")
    parser.add_argument("--action", required=True, choices=["login", "check", "pages", "instagram"])
    parser.add_argument("--port", type=int, default=8765, help="Local port for the OAuth redirect (must match the app's Valid OAuth Redirect URI).")
    parser.add_argument("--timeout", type=int, default=180, help="Seconds to wait for the browser redirect before giving up.")
    parser.add_argument("--scopes", default=None, help="Comma-separated scopes to request. Defaults to a sensible posts+ads set.")
    parser.add_argument("--force", action="store_true", help="Re-run the browser flow even if a saved token still validates.")
    parser.add_argument("--access-token", default=None, help="Token to check/use instead of the saved one.")
    args = parser.parse_args()

    try:
        if args.action == "login":
            cmd_login(args)
        elif args.action == "check":
            cmd_check(args)
        elif args.action == "pages":
            cmd_pages(args)
        elif args.action == "instagram":
            cmd_instagram(args)
    except Exception as e:  # noqa: BLE001
        fail(str(e))


if __name__ == "__main__":
    main()
