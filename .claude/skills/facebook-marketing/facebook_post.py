#!/usr/bin/env python3
"""
facebook_post.py — create, list, publish and delete Facebook Page posts.

Safety model (mirrors the rest of this skill): creating a post does
NOT go live by default. Every `--action create` call produces an
**unpublished draft** unless you explicitly pass `--publish-now` or
`--scheduled-time`. Show the draft to the user, then call
`--action publish --post-id <id>` when they approve it.

Actions
-------
  --action create    Create a post (text, link, and/or photo). Draft
                      by default; use --publish-now or --scheduled-time
                      to go live/schedule instead.
  --action publish   Flip an existing draft (is_published=false) live.
  --action list      List recent posts (drafts + scheduled + published).
  --action get       Fetch one post plus basic engagement counts.
  --action delete    Permanently delete a post.

Every command prints exactly one `RESULT: {...}` JSON line on stdout.
"""

from __future__ import annotations

import argparse
import os

from facebook_common import (
    default_page_id,
    epoch_from_iso,
    fail,
    graph_request,
    now_epoch,
    resolve_access_token,
    result_line,
)


def _page_id(args: argparse.Namespace) -> str:
    pid = args.page_id or default_page_id()
    if not pid:
        fail("No Page ID given. Pass --page-id or set FB_PAGE_ID in .env.")
    return pid


def cmd_create(args: argparse.Namespace) -> None:
    page_id = _page_id(args)
    token = resolve_access_token(args.access_token, page_id)

    if not args.message and not args.image and not args.link:
        fail("Provide at least one of --message, --link, or --image.")

    if args.scheduled_time and args.publish_now:
        fail("Pass either --scheduled-time or --publish-now, not both.")

    scheduled_epoch = None
    if args.scheduled_time:
        scheduled_epoch = epoch_from_iso(args.scheduled_time)
        min_epoch = now_epoch() + 10 * 60
        max_epoch = now_epoch() + 180 * 24 * 60 * 60  # ~6 months, Meta's outer bound
        if not (min_epoch <= scheduled_epoch <= max_epoch):
            fail(
                f"--scheduled-time must be between 10 minutes and ~6 months from now "
                f"(got epoch {scheduled_epoch}, now {now_epoch()})."
            )

    # A photo post (with or without caption) goes through /photos so the
    # image actually renders as the post's media, not just a shared link.
    if args.image:
        endpoint = f"{page_id}/photos"
        data: dict = {}
        files = None
        if args.message:
            data["caption"] = args.message
        if args.image.startswith("http://") or args.image.startswith("https://"):
            data["url"] = args.image
        else:
            if not os.path.isfile(args.image):
                fail(f"--image path does not exist: {args.image}")
            files = {"source": open(args.image, "rb")}

        if scheduled_epoch:
            data["published"] = "false"
            data["scheduled_publish_time"] = str(scheduled_epoch)
        elif args.publish_now:
            data["published"] = "true"
        else:
            data["published"] = "false"  # draft

        body = graph_request("POST", endpoint, token, data=data, files=files)
    else:
        endpoint = f"{page_id}/feed"
        data = {}
        if args.message:
            data["message"] = args.message
        if args.link:
            data["link"] = args.link

        if scheduled_epoch:
            data["published"] = "false"
            data["scheduled_publish_time"] = str(scheduled_epoch)
        elif args.publish_now:
            data["published"] = "true"
        else:
            data["published"] = "false"  # draft

        body = graph_request("POST", endpoint, token, data=data)

    post_id = body.get("post_id") or body.get("id")
    if scheduled_epoch:
        state = "scheduled"
    elif args.publish_now:
        state = "published"
    else:
        state = "draft"

    result_line({
        "status": "ok",
        "state": state,
        "post_id": post_id,
        "page_id": page_id,
        "scheduled_publish_time": scheduled_epoch,
        "raw": body,
        "note": None if state != "draft" else "This is an unpublished draft. Show it to the user, then run "
                                               f"`--action publish --post-id {post_id}` to go live.",
    })


def cmd_publish(args: argparse.Namespace) -> None:
    if not args.post_id:
        fail("--post-id is required.")
    page_id = args.page_id or default_page_id()
    token = resolve_access_token(args.access_token, page_id)
    body = graph_request("POST", args.post_id, token, data={"is_published": "true"})
    result_line({"status": "ok", "state": "published", "post_id": args.post_id, "raw": body})


def cmd_list(args: argparse.Namespace) -> None:
    page_id = _page_id(args)
    token = resolve_access_token(args.access_token, page_id)
    # promotable_posts includes unpublished drafts + scheduled posts, not just live ones.
    endpoint = f"{page_id}/promotable_posts" if args.include_drafts else f"{page_id}/posts"
    fields = "id,message,created_time,permalink_url,is_published,scheduled_publish_time,is_expired"
    body = graph_request("GET", endpoint, token, params={"fields": fields, "limit": args.limit})
    result_line({"status": "ok", "count": len(body.get("data", [])), "posts": body.get("data", []), "paging": body.get("paging", {})})


def cmd_get(args: argparse.Namespace) -> None:
    if not args.post_id:
        fail("--post-id is required.")
    page_id = args.page_id or default_page_id()
    token = resolve_access_token(args.access_token, page_id)
    fields = (
        "id,message,created_time,permalink_url,is_published,scheduled_publish_time,"
        "likes.summary(true),comments.summary(true),shares"
    )
    body = graph_request("GET", args.post_id, token, params={"fields": fields})
    result_line({"status": "ok", "post": body})


def cmd_delete(args: argparse.Namespace) -> None:
    if not args.post_id:
        fail("--post-id is required.")
    page_id = args.page_id or default_page_id()
    token = resolve_access_token(args.access_token, page_id)
    body = graph_request("DELETE", args.post_id, token)
    result_line({"status": "ok", "deleted": bool(body.get("success", True)), "post_id": args.post_id})


def main() -> None:
    parser = argparse.ArgumentParser(description="Create and manage Facebook Page posts.")
    parser.add_argument("--action", required=True, choices=["create", "publish", "list", "get", "delete"])
    parser.add_argument("--page-id", default=None, help="Defaults to FB_PAGE_ID from .env.")
    parser.add_argument("--access-token", default=None, help="Overrides the saved/env Page access token.")
    parser.add_argument("--message", default=None, help="Post text.")
    parser.add_argument("--link", default=None, help="URL to share (feed posts only).")
    parser.add_argument("--image", default=None, help="Local file path or public image URL to post as a photo.")
    parser.add_argument("--scheduled-time", default=None, help="ISO-8601 time to schedule publish (e.g. 2026-09-01T15:00:00). 10min-6mo out.")
    parser.add_argument("--publish-now", action="store_true", help="Go live immediately instead of creating a draft.")
    parser.add_argument("--post-id", default=None, help="Target post id for publish/get/delete.")
    parser.add_argument("--include-drafts", action="store_true", help="For --action list: include unpublished/scheduled posts.")
    parser.add_argument("--limit", type=int, default=25)
    args = parser.parse_args()

    try:
        if args.action == "create":
            cmd_create(args)
        elif args.action == "publish":
            cmd_publish(args)
        elif args.action == "list":
            cmd_list(args)
        elif args.action == "get":
            cmd_get(args)
        elif args.action == "delete":
            cmd_delete(args)
    except Exception as e:  # noqa: BLE001
        fail(str(e))


if __name__ == "__main__":
    main()
