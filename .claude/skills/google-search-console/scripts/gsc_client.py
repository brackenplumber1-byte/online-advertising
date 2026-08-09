#!/usr/bin/env python3
"""Google Search Console API client using an OAuth 2.0 refresh token.

Every subcommand prints exactly one `RESULT: {...}` JSON line on stdout.
Human-readable logs go to stderr. Credentials come from environment
variables (see .env.example) — never pass the refresh token or client
secret on the command line where it could leak into shell history or
process listings.
"""
import argparse
import json
import os
import sys
from pathlib import Path
from urllib.parse import quote

import requests

try:
    from dotenv import load_dotenv
except ImportError:
    load_dotenv = None

SITES_DIR = Path(__file__).resolve().parent.parent / "sites"

TOKEN_URL = "https://oauth2.googleapis.com/token"
WEBMASTERS_BASE = "https://www.googleapis.com/webmasters/v3/"
SEARCHCONSOLE_BASE = "https://searchconsole.googleapis.com/v1/"


def log(msg):
    print(msg, file=sys.stderr)


def result(obj):
    print("RESULT: " + json.dumps(obj))


def available_sites():
    if not SITES_DIR.is_dir():
        return []
    return sorted(p.stem for p in SITES_DIR.glob("*.env"))


def load_site_env(site):
    """Load credentials for a named business (sites/<site>.env), or the
    plain ./.env in the current directory if no --site was given (single-
    business backward-compatible mode)."""
    if load_dotenv is None:
        return
    if site:
        env_path = SITES_DIR / f"{site}.env"
        if not env_path.is_file():
            result({
                "error": f"No config found for site '{site}' at {env_path}.",
                "available_sites": available_sites(),
            })
            sys.exit(1)
        load_dotenv(env_path, override=True)
    else:
        load_dotenv(override=True)


def get_config():
    client_id = os.environ.get("GOOGLE_CLIENT_ID")
    client_secret = os.environ.get("GOOGLE_CLIENT_SECRET")
    refresh_token = os.environ.get("GOOGLE_REFRESH_TOKEN")
    site_url = os.environ.get("GSC_SITE_URL")
    missing = [
        name for name, val in (
            ("GOOGLE_CLIENT_ID", client_id),
            ("GOOGLE_CLIENT_SECRET", client_secret),
            ("GOOGLE_REFRESH_TOKEN", refresh_token),
            ("GSC_SITE_URL", site_url),
        ) if not val
    ]
    if missing:
        result({
            "error": f"Missing {', '.join(missing)}. Use --site <name> to pick "
                     "a configured business (see sites/), or copy .env.example "
                     "to .env for single-site use. See SKILL.md for how to "
                     "obtain OAuth credentials and a refresh token.",
            "available_sites": available_sites(),
        })
        sys.exit(1)
    return client_id, client_secret, refresh_token, site_url


def get_access_token(client_id, client_secret, refresh_token):
    resp = requests.post(TOKEN_URL, data={
        "client_id": client_id,
        "client_secret": client_secret,
        "refresh_token": refresh_token,
        "grant_type": "refresh_token",
    }, timeout=30)
    if resp.status_code >= 400:
        try:
            detail = resp.json()
        except ValueError:
            detail = resp.text[:500]
        result({"error": f"Token refresh failed -> HTTP {resp.status_code}", "detail": detail})
        sys.exit(1)
    return resp.json()["access_token"]


def request(method, base, token, path, **kwargs):
    url = base + path
    headers = kwargs.pop("headers", {})
    headers["Authorization"] = f"Bearer {token}"
    resp = requests.request(method, url, headers=headers, timeout=30, **kwargs)
    if resp.status_code >= 400:
        try:
            detail = resp.json()
        except ValueError:
            detail = resp.text[:500]
        result({"error": f"GSC API {method} {path} -> HTTP {resp.status_code}", "detail": detail})
        sys.exit(1)
    if not resp.content:
        return {}
    return resp.json()


def cmd_whoami(args):
    client_id, client_secret, refresh_token, site_url = get_config()
    token = get_access_token(client_id, client_secret, refresh_token)
    sites = request("GET", WEBMASTERS_BASE, token, "sites")
    entries = sites.get("siteEntry", [])
    match = next((s for s in entries if s.get("siteUrl") == site_url), None)
    result({
        "status": "ok",
        "configured_site": site_url,
        "verified_and_accessible": match is not None,
        "permission_level": match.get("permissionLevel") if match else None,
        "all_accessible_sites": [
            {"siteUrl": s["siteUrl"], "permissionLevel": s.get("permissionLevel")}
            for s in entries
        ],
    })


def cmd_query(args):
    client_id, client_secret, refresh_token, site_url = get_config()
    token = get_access_token(client_id, client_secret, refresh_token)
    body = {
        "startDate": args.start_date,
        "endDate": args.end_date,
        "dimensions": args.dimensions.split(","),
        "rowLimit": args.row_limit,
        "type": args.search_type,
    }
    path = f"sites/{quote(site_url, safe='')}/searchAnalytics/query"
    data = request("POST", WEBMASTERS_BASE, token, path, json=body)
    result({
        "status": "ok",
        "row_count": len(data.get("rows", [])),
        "rows": data.get("rows", []),
    })


def cmd_list_sitemaps(args):
    client_id, client_secret, refresh_token, site_url = get_config()
    token = get_access_token(client_id, client_secret, refresh_token)
    path = f"sites/{quote(site_url, safe='')}/sitemaps"
    data = request("GET", WEBMASTERS_BASE, token, path)
    result({"status": "ok", "sitemaps": data.get("sitemap", [])})


def cmd_submit_sitemap(args):
    client_id, client_secret, refresh_token, site_url = get_config()
    token = get_access_token(client_id, client_secret, refresh_token)
    feedpath = quote(args.sitemap_url, safe="")
    path = f"sites/{quote(site_url, safe='')}/sitemaps/{feedpath}"
    request("PUT", WEBMASTERS_BASE, token, path)
    result({"status": "ok", "action": "submitted", "sitemap_url": args.sitemap_url})


def cmd_inspect_url(args):
    client_id, client_secret, refresh_token, site_url = get_config()
    token = get_access_token(client_id, client_secret, refresh_token)
    body = {"inspectionUrl": args.url, "siteUrl": site_url}
    data = request("POST", SEARCHCONSOLE_BASE, token, "urlInspection/index:inspect", json=body)
    result({"status": "ok", "inspection_result": data.get("inspectionResult", data)})


def main():
    parser = argparse.ArgumentParser(description="Google Search Console API client")
    parser.add_argument("--site", default=None,
                         help="Named business config to use (sites/<site>.env). "
                              "Omit to use the plain ./.env file (single-site mode). "
                              "Must come before the subcommand, e.g. "
                              "'gsc_client.py --site brackendownsplumber whoami'.")
    sub = parser.add_subparsers(dest="command", required=True)

    sub.add_parser("whoami", help="Verify credentials and confirm the configured site is accessible").set_defaults(func=cmd_whoami)

    p = sub.add_parser("query", help="Run a Search Analytics query (clicks/impressions/ctr/position)")
    p.add_argument("--start-date", required=True, help="YYYY-MM-DD")
    p.add_argument("--end-date", required=True, help="YYYY-MM-DD")
    p.add_argument("--dimensions", default="query", help="Comma-separated: query,page,date,country,device")
    p.add_argument("--row-limit", type=int, default=25)
    p.add_argument("--search-type", default="web", help="web|image|video|news")
    p.set_defaults(func=cmd_query)

    sub.add_parser("list-sitemaps", help="List submitted sitemaps").set_defaults(func=cmd_list_sitemaps)

    p = sub.add_parser("submit-sitemap", help="Submit/resubmit a sitemap URL")
    p.add_argument("--sitemap-url", required=True, help="Full URL to the sitemap, e.g. https://example.com/sitemap.xml")
    p.set_defaults(func=cmd_submit_sitemap)

    p = sub.add_parser("inspect-url", help="Run the URL Inspection tool on a specific page")
    p.add_argument("--url", required=True, help="Full URL of the page to inspect")
    p.set_defaults(func=cmd_inspect_url)

    args = parser.parse_args()
    load_site_env(args.site)
    args.func(args)


if __name__ == "__main__":
    main()
