#!/usr/bin/env python3
"""Create a Google Business Profile local post.

Prints one `RESULT: {...}` JSON line. Requires GBP_ACCOUNT_ID,
GBP_LOCATION_ID, GOOGLE_CLIENT_ID, GOOGLE_CLIENT_SECRET, and
GOOGLE_REFRESH_TOKEN in the environment or a .env file — see
references/gbp.md for how to obtain them (including the API access
approval step, which only the business owner can request).
"""
import argparse
import json
import os
import sys

import requests

from site_config import add_site_arg, load_site_env

TOKEN_URL = "https://oauth2.googleapis.com/token"
API_BASE = "https://mybusiness.googleapis.com/v4"


def result(obj):
    print("RESULT: " + json.dumps(obj))


def require_env(*names):
    missing = [n for n in names if not os.environ.get(n)]
    if missing:
        result({"error": f"Missing required env vars: {', '.join(missing)}. See references/gbp.md."})
        sys.exit(1)


def get_access_token():
    require_env("GOOGLE_CLIENT_ID", "GOOGLE_CLIENT_SECRET", "GOOGLE_REFRESH_TOKEN")
    resp = requests.post(TOKEN_URL, data={
        "client_id": os.environ["GOOGLE_CLIENT_ID"],
        "client_secret": os.environ["GOOGLE_CLIENT_SECRET"],
        "refresh_token": os.environ["GOOGLE_REFRESH_TOKEN"],
        "grant_type": "refresh_token",
    }, timeout=30)
    if resp.status_code >= 400:
        result({"error": "failed to refresh Google OAuth token", "detail": resp.json()})
        sys.exit(1)
    return resp.json()["access_token"]


def main():
    parser = argparse.ArgumentParser(description="Create a Google Business Profile local post")
    add_site_arg(parser)
    parser.add_argument("--summary", required=True, help="Post text, ~1500 char max")
    parser.add_argument("--cta-type", default=None,
                         choices=["CALL", "BOOK", "ORDER", "SHOP", "LEARN_MORE", "SIGN_UP"])
    parser.add_argument("--cta-url", default=None, help="Required for all CTA types except CALL")
    parser.add_argument("--image-url", default=None, help="Publicly reachable image URL")
    parser.add_argument("--language", default="en-ZA")
    args = parser.parse_args()
    load_site_env(args.site, result)

    require_env("GBP_ACCOUNT_ID", "GBP_LOCATION_ID")
    account_id = os.environ["GBP_ACCOUNT_ID"]
    location_id = os.environ["GBP_LOCATION_ID"]

    if args.cta_type and args.cta_type != "CALL" and not args.cta_url:
        result({"error": f"--cta-url is required for CTA type {args.cta_type}"})
        sys.exit(1)

    token = get_access_token()

    payload = {"languageCode": args.language, "summary": args.summary, "topicType": "STANDARD"}
    if args.cta_type:
        cta = {"actionType": args.cta_type}
        if args.cta_url:
            cta["url"] = args.cta_url
        payload["callToAction"] = cta
    if args.image_url:
        payload["media"] = [{"mediaFormat": "PHOTO", "sourceUrl": args.image_url}]

    url = f"{API_BASE}/accounts/{account_id}/locations/{location_id}/localPosts"
    resp = requests.post(url, headers={"Authorization": f"Bearer {token}"}, json=payload, timeout=30)
    if resp.status_code >= 400:
        try:
            detail = resp.json()
        except ValueError:
            detail = resp.text[:500]
        result({"error": "gbp post failed", "detail": detail})
        sys.exit(1)

    data = resp.json()
    result({"status": "ok", "platform": "gbp", "name": data.get("name"), "state": data.get("state")})


if __name__ == "__main__":
    main()
