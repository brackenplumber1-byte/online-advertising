#!/usr/bin/env python3
"""
instagram_post.py — publish to an Instagram Business/Creator account
via the Instagram Graph API (a Facebook Page must already be linked to
the Instagram account — see `facebook_login.py --action instagram`).

Unlike Facebook, Instagram has no text-only posts and no "unpublished
draft" state on Instagram's side. Publishing is always a two-step dance:

  1. Create a media container (upload the image/video + caption) —
     this returns a `container_id` but does NOT go live yet.
  2. Publish that container — THIS is the step that makes it live.

This script mirrors that: `--action create` only creates the container
(the safe, reviewable step); `--action publish` makes it live. Treat
step 2 exactly like `facebook_post.py`'s draft-then-publish flow — show
the user the container details before publishing.

Actions
-------
  --action create    Upload an image (local file or public URL) + caption,
                      creating a container. Does NOT go live.
  --action publish   Publish a previously created container. THIS goes live.
  --action list      List recent media on the account.
  --action get       Fetch one media item's details/insights.
  --action delete    Permanently delete a published media item.

Every command prints exactly one `RESULT: {...}` JSON line on stdout.
"""

from __future__ import annotations

import argparse
import time

from facebook_common import (
    default_page_id,
    fail,
    get_saved_instagram_account,
    graph_request,
    resolve_access_token,
    result_line,
)


def _ig_user_id(args: argparse.Namespace) -> str:
    if args.ig_user_id:
        return args.ig_user_id
    page_id = args.page_id or default_page_id()
    if page_id:
        entry = get_saved_instagram_account(page_id)
        if entry:
            return entry["id"]
    fail(
        "No Instagram Business account id found. Pass --ig-user-id directly, or run "
        "`python3 facebook_login.py --action instagram` first to discover and save it "
        "for your Page (requires the Instagram account to be a Business/Creator account "
        "linked to that Facebook Page)."
    )


def _token(args: argparse.Namespace) -> str:
    # Instagram Graph API calls are authorized with the linked Page's access token.
    page_id = args.page_id or default_page_id()
    return resolve_access_token(args.access_token, page_id)


def cmd_create(args: argparse.Namespace) -> None:
    if not args.image and not args.video:
        fail("Provide --image (photo URL) or --video (video/reels URL). Instagram requires media for every post.")
    if args.image and args.video:
        fail("Pass either --image or --video, not both.")

    data: dict = {}
    if args.caption:
        data["caption"] = args.caption
    if args.image:
        if args.image.startswith("http://") or args.image.startswith("https://"):
            data["image_url"] = args.image
        else:
            fail("--image must be a public URL for Instagram (local file upload isn't supported by this "
                 "endpoint) — host the image somewhere reachable, e.g. your website, then pass its URL.")
    elif args.video:
        if not (args.video.startswith("http://") or args.video.startswith("https://")):
            fail("--video must be a public URL.")
        data["video_url"] = args.video
        data["media_type"] = "REELS" if args.reels else "VIDEO"

    ig_id = _ig_user_id(args)
    token = _token(args)
    body = graph_request("POST", f"{ig_id}/media", token, data=data)
    container_id = body.get("id")

    result_line({
        "status": "ok",
        "state": "container_created",
        "container_id": container_id,
        "ig_user_id": ig_id,
        "note": f"Not live yet. Show this to the user, then run `--action publish --container-id {container_id}` "
                f"to make it live. Video containers can take a while to process — check "
                f"`--action status --container-id {container_id}` if publish fails with 'media not ready'.",
    })


def cmd_status(args: argparse.Namespace) -> None:
    if not args.container_id:
        fail("--container-id is required.")
    token = _token(args)
    body = graph_request("GET", args.container_id, token, params={"fields": "status_code,status"})
    result_line({"status": "ok", "container_id": args.container_id, "container_status": body.get("status_code"), "raw": body})


def cmd_publish(args: argparse.Namespace) -> None:
    if not args.container_id:
        fail("--container-id is required (from `--action create`).")
    ig_id = _ig_user_id(args)
    token = _token(args)

    # Video containers process asynchronously; poll briefly for FINISHED before publishing.
    if args.wait_ready:
        deadline = time.time() + args.wait_ready
        while time.time() < deadline:
            st = graph_request("GET", args.container_id, token, params={"fields": "status_code"})
            code = st.get("status_code")
            if code == "FINISHED":
                break
            if code == "ERROR":
                fail(f"Container {args.container_id} failed processing (status_code=ERROR).")
            time.sleep(3)

    body = graph_request("POST", f"{ig_id}/media_publish", token, data={"creation_id": args.container_id})
    result_line({"status": "ok", "state": "published", "media_id": body.get("id"), "container_id": args.container_id})


def cmd_list(args: argparse.Namespace) -> None:
    ig_id = _ig_user_id(args)
    token = _token(args)
    fields = "id,caption,media_type,media_url,permalink,timestamp,like_count,comments_count"
    body = graph_request("GET", f"{ig_id}/media", token, params={"fields": fields, "limit": args.limit})
    result_line({"status": "ok", "count": len(body.get("data", [])), "media": body.get("data", []), "paging": body.get("paging", {})})


def cmd_get(args: argparse.Namespace) -> None:
    if not args.media_id:
        fail("--media-id is required.")
    token = _token(args)
    fields = "id,caption,media_type,media_url,permalink,timestamp,like_count,comments_count"
    body = graph_request("GET", args.media_id, token, params={"fields": fields})
    result_line({"status": "ok", "media": body})


def cmd_delete(args: argparse.Namespace) -> None:
    if not args.media_id:
        fail("--media-id is required.")
    token = _token(args)
    body = graph_request("DELETE", args.media_id, token)
    result_line({"status": "ok", "deleted": bool(body.get("success", True)), "media_id": args.media_id})


def main() -> None:
    parser = argparse.ArgumentParser(description="Publish to Instagram via the Instagram Graph API.")
    parser.add_argument("--action", required=True, choices=["create", "status", "publish", "list", "get", "delete"])
    parser.add_argument("--page-id", default=None, help="Facebook Page this Instagram account is linked to. Defaults to FB_PAGE_ID from .env.")
    parser.add_argument("--ig-user-id", default=None, help="Instagram Business account id, overriding the saved lookup by --page-id.")
    parser.add_argument("--access-token", default=None, help="Overrides the saved/env Page access token.")
    parser.add_argument("--caption", default=None, help="Post caption.")
    parser.add_argument("--image", default=None, help="Public image URL to post as a photo.")
    parser.add_argument("--video", default=None, help="Public video URL to post as a video/Reel.")
    parser.add_argument("--reels", action="store_true", help="Post --video as a Reel instead of a feed video.")
    parser.add_argument("--container-id", default=None, help="Container id from --action create, used by publish/status.")
    parser.add_argument("--wait-ready", type=int, default=0, help="For --action publish: seconds to poll for video processing to finish before publishing (0 = don't wait).")
    parser.add_argument("--media-id", default=None, help="Published media id, for get/delete.")
    parser.add_argument("--limit", type=int, default=25)
    args = parser.parse_args()

    try:
        {
            "create": cmd_create,
            "status": cmd_status,
            "publish": cmd_publish,
            "list": cmd_list,
            "get": cmd_get,
            "delete": cmd_delete,
        }[args.action](args)
    except Exception as e:  # noqa: BLE001
        fail(str(e))


if __name__ == "__main__":
    main()
