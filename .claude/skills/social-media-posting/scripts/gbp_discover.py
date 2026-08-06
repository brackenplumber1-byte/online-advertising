#!/usr/bin/env python3
"""One-time discovery helper: given working GBP OAuth credentials
(GOOGLE_CLIENT_ID/SECRET + a business.manage-scoped GOOGLE_REFRESH_TOKEN),
list the Account IDs and Location IDs available to that account so they
can be dropped into sites/<slug>.env as GBP_ACCOUNT_ID / GBP_LOCATION_ID.

Run this once after completing the OAuth consent flow, before trying to
post anything. See ../references/gbp.md for how to get here.
"""
import json
import os
import sys

import requests

from site_config import add_site_arg, load_site_env

TOKEN_URL = "https://oauth2.googleapis.com/token"
ACCOUNTS_URL = "https://mybusinessaccountmanagement.googleapis.com/v1/accounts"
LOCATIONS_URL_TMPL = (
    "https://mybusinessbusinessinformation.googleapis.com/v1/{account}/locations"
    "?readMask=name,title,storefrontAddress"
)


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
    import argparse
    parser = argparse.ArgumentParser(description="Discover GBP account/location IDs")
    add_site_arg(parser)
    args = parser.parse_args()
    load_site_env(args.site, result)

    token = get_access_token()
    headers = {"Authorization": f"Bearer {token}"}

    acct_resp = requests.get(ACCOUNTS_URL, headers=headers, timeout=30)
    if acct_resp.status_code >= 400:
        result({"error": "failed to list accounts", "detail": acct_resp.text[:800]})
        sys.exit(1)
    accounts = acct_resp.json().get("accounts", [])
    if not accounts:
        result({"error": "No accounts returned. This Google account may not manage any Business Profile, or the OAuth scope was wrong (need https://www.googleapis.com/auth/business.manage)."})
        sys.exit(1)

    out = []
    for acct in accounts:
        acct_name = acct["name"]  # "accounts/123456789"
        acct_id = acct_name.split("/")[-1]
        entry = {"account_name": acct.get("accountName"), "account_id": acct_id, "locations": []}
        loc_resp = requests.get(LOCATIONS_URL_TMPL.format(account=acct_name), headers=headers, timeout=30)
        if loc_resp.status_code >= 400:
            entry["locations_error"] = loc_resp.text[:500]
        else:
            for loc in loc_resp.json().get("locations", []):
                loc_id = loc["name"].split("/")[-1]
                entry["locations"].append({
                    "location_id": loc_id,
                    "title": loc.get("title"),
                    "address": loc.get("storefrontAddress"),
                })
        out.append(entry)

    result({"status": "ok", "accounts": out})


if __name__ == "__main__":
    main()
