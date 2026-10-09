#!/usr/bin/env python3
"""Post to a Facebook Page or Instagram Business account via the Meta Graph API.

Prints one `RESULT: {...}` JSON line. Requires META_PAGE_ID,
META_PAGE_ACCESS_TOKEN, and (for Instagram) META_IG_USER_ID in the
environment or a .env file — see references/meta.md for how to obtain
them.
"""
import argparse
import json
import os
import sys
import time

import requests

from site_config import add_site_arg, load_site_env

GRAPH_VERSION = "v21.0"
GRAPH_BASE = f"https://graph.facebook.com/{GRAPH_VERSION}"


def result(obj):
    print("RESULT: " + json.dumps(obj))


def log(msg):
    print(msg, file=sys.stderr)


def require_env(*names):
    missing = [n for n in names if not os.environ.get(n)]
    if missing:
        result({"error": f"Missing required env vars: {', '.join(missing)}. See references/meta.md."})
        sys.exit(1)


def post_facebook(args):
    require_env("META_PAGE_ID", "META_PAGE_ACCESS_TOKEN")
    page_id = os.environ["META_PAGE_ID"]
    token = os.environ["META_PAGE_ACCESS_TOKEN"]
    payload = {"message": args.message, "access_token": token}
    if args.link:
        payload["link"] = args.link
    resp = requests.post(f"{GRAPH_BASE}/{page_id}/feed", data=payload, timeout=30)
    data = resp.json()
    if resp.status_code >= 400:
        result({"error": "facebook post failed", "detail": data})
        sys.exit(1)
    result({"status": "ok", "platform": "facebook", "post_id": data.get("id")})


def post_instagram(args):
    require_env("META_IG_USER_ID", "META_PAGE_ACCESS_TOKEN")
    ig_id = os.environ["META_IG_USER_ID"]
    token = os.environ["META_PAGE_ACCESS_TOKEN"]

    if not args.image_url and not args.video_url:
        result({"error": "Instagram requires --image-url or --video-url (a publicly reachable URL, not a local path)."})
        sys.exit(1)

    create_payload = {"caption": args.caption or "", "access_token": token}
    if args.video_url:
        create_payload["video_url"] = args.video_url
        create_payload["media_type"] = "REELS"
    else:
        create_payload["image_url"] = args.image_url

    resp = requests.post(f"{GRAPH_BASE}/{ig_id}/media", data=create_payload, timeout=60)
    data = resp.json()
    if resp.status_code >= 400:
        result({"error": "instagram media container failed", "detail": data})
        sys.exit(1)
    creation_id = data["id"]

    # Video containers need processing time; poll status before publishing.
    if args.video_url:
        for _ in range(10):
            status_resp = requests.get(
                f"{GRAPH_BASE}/{creation_id}",
                params={"fields": "status_code", "access_token": token},
                timeout=30,
            )
            status = status_resp.json().get("status_code")
            if status == "FINISHED":
                break
            if status == "ERROR":
                result({"error": "instagram media processing failed", "detail": status_resp.json()})
                sys.exit(1)
            time.sleep(5)

    publish_resp = requests.post(
        f"{GRAPH_BASE}/{ig_id}/media_publish",
        data={"creation_id": creation_id, "access_token": token},
        timeout=30,
    )
    publish_data = publish_resp.json()
    if publish_resp.status_code >= 400:
        result({"error": "instagram publish failed", "detail": publish_data})
        sys.exit(1)
    result({"status": "ok", "platform": "instagram", "post_id": publish_data.get("id")})


def main():
    parser = argparse.ArgumentParser(description="Post to Facebook or Instagram via Meta Graph API")
    add_site_arg(parser)
    sub = parser.add_subparsers(dest="platform", required=True)

    fb = sub.add_parser("facebook", help="Post to a Facebook Page")
    fb.add_argument("--message", required=True)
    fb.add_argument("--link", default=None)
    fb.set_defaults(func=post_facebook)

    ig = sub.add_parser("instagram", help="Post to an Instagram Business account")
    ig.add_argument("--caption", default="")
    ig.add_argument("--image-url", default=None)
    ig.add_argument("--video-url", default=None)
    ig.set_defaults(func=post_instagram)

    args = parser.parse_args()
    load_site_env(args.site, result)
    args.func(args)


if __name__ == "__main__":
    main()
