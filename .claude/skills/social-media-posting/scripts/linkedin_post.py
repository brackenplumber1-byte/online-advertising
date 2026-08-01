#!/usr/bin/env python3
"""Post to LinkedIn (personal profile or organization) via the Posts API.

Prints one `RESULT: {...}` JSON line. Requires LINKEDIN_ACCESS_TOKEN and
LINKEDIN_AUTHOR_URN in the environment or a .env file — see
references/linkedin.md for how to obtain them.
"""
import argparse
import json
import mimetypes
import os
import sys

import requests

try:
    from dotenv import load_dotenv
    load_dotenv()
except ImportError:
    pass

API_BASE = "https://api.linkedin.com/rest"
LINKEDIN_VERSION = os.environ.get("LINKEDIN_API_VERSION", "202601")


def result(obj):
    print("RESULT: " + json.dumps(obj))


def require_env(*names):
    missing = [n for n in names if not os.environ.get(n)]
    if missing:
        result({"error": f"Missing required env vars: {', '.join(missing)}. See references/linkedin.md."})
        sys.exit(1)


def headers(token):
    return {
        "Authorization": f"Bearer {token}",
        "LinkedIn-Version": LINKEDIN_VERSION,
        "X-Restli-Protocol-Version": "2.0.0",
        "Content-Type": "application/json",
    }


def upload_image(author_urn, token, image_path):
    init_resp = requests.post(
        f"{API_BASE}/images?action=initializeUpload",
        headers=headers(token),
        json={"initializeUploadRequest": {"owner": author_urn}},
        timeout=30,
    )
    if init_resp.status_code >= 400:
        result({"error": "linkedin image init failed", "detail": init_resp.json()})
        sys.exit(1)
    init_data = init_resp.json()["value"]
    upload_url = init_data["uploadUrl"]
    image_urn = init_data["image"]

    content_type = mimetypes.guess_type(image_path)[0] or "application/octet-stream"
    with open(image_path, "rb") as f:
        upload_resp = requests.put(upload_url, data=f.read(), headers={"Content-Type": content_type}, timeout=60)
    if upload_resp.status_code >= 400:
        result({"error": "linkedin image upload failed", "detail": upload_resp.text[:500]})
        sys.exit(1)
    return image_urn


def main():
    parser = argparse.ArgumentParser(description="Post to LinkedIn via the Posts API")
    parser.add_argument("--text", required=True)
    parser.add_argument("--image", default=None, help="Local path to an image to attach")
    parser.add_argument("--visibility", default="PUBLIC", choices=["PUBLIC", "CONNECTIONS"])
    args = parser.parse_args()

    require_env("LINKEDIN_ACCESS_TOKEN", "LINKEDIN_AUTHOR_URN")
    token = os.environ["LINKEDIN_ACCESS_TOKEN"]
    author = os.environ["LINKEDIN_AUTHOR_URN"]

    payload = {
        "author": author,
        "commentary": args.text,
        "visibility": args.visibility,
        "distribution": {"feedDistribution": "MAIN_FEED"},
        "lifecycleState": "PUBLISHED",
    }

    if args.image:
        image_urn = upload_image(author, token, args.image)
        payload["content"] = {"media": {"id": image_urn}}

    resp = requests.post(f"{API_BASE}/posts", headers=headers(token), json=payload, timeout=30)
    if resp.status_code >= 400:
        try:
            detail = resp.json()
        except ValueError:
            detail = resp.text[:500]
        result({"error": "linkedin post failed", "detail": detail})
        sys.exit(1)

    post_id = resp.headers.get("x-restli-id") or resp.headers.get("X-RestLi-Id")
    result({"status": "ok", "platform": "linkedin", "post_id": post_id})


if __name__ == "__main__":
    main()
