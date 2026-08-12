#!/usr/bin/env python3
"""WordPress REST API client using an Application Password.

Every subcommand prints exactly one `RESULT: {...}` JSON line on stdout.
Human-readable logs go to stderr. Credentials come from environment
variables (see .env.example) — never pass the password on the command
line where it could leak into shell history or process listings.
"""
import argparse
import json
import os
import sys
from pathlib import Path
from urllib.parse import urljoin

import requests

try:
    from dotenv import load_dotenv
except ImportError:
    load_dotenv = None

SITES_DIR = Path(__file__).resolve().parent.parent / "sites"


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
    site_url = os.environ.get("WP_SITE_URL", "").rstrip("/")
    user = os.environ.get("WP_USERNAME")
    app_password = os.environ.get("WP_APP_PASSWORD")
    if not site_url or not user or not app_password:
        result({
            "error": "Missing WP_SITE_URL, WP_USERNAME, or WP_APP_PASSWORD. "
                     "Use --site <name> to pick a configured business (see "
                     "sites/), or copy .env.example to .env for single-site "
                     "use. Generate an Application Password at wp-admin -> "
                     "Users -> Profile -> Application Passwords.",
            "available_sites": available_sites(),
        })
        sys.exit(1)
    return site_url, (user, app_password)


def api_base(site):
    return urljoin(site + "/", "wp-json/wp/v2/")


def request(method, site, auth, path, **kwargs):
    url = urljoin(api_base(site), path)
    resp = requests.request(method, url, auth=auth, timeout=30, **kwargs)
    if resp.status_code >= 400:
        try:
            detail = resp.json()
        except ValueError:
            detail = resp.text[:500]
        result({"error": f"WP API {method} {path} -> HTTP {resp.status_code}", "detail": detail})
        sys.exit(1)
    return resp.json()


def cmd_whoami(args):
    site, auth = get_config()
    me = request("GET", site, auth, "users/me", params={"context": "edit"})
    result({
        "status": "ok",
        "site": site,
        "user_id": me.get("id"),
        "name": me.get("name"),
        "roles": me.get("roles"),
        "capabilities": [k for k, v in (me.get("capabilities") or {}).items() if v][:20],
    })


def cmd_list_posts(args):
    site, auth = get_config()
    params = {"per_page": args.limit, "context": "edit"}
    if args.status:
        params["status"] = args.status
    if args.search:
        params["search"] = args.search
    posts = request("GET", site, auth, args.post_type, params=params)
    result({
        "status": "ok",
        "count": len(posts),
        "posts": [
            {
                "id": p["id"],
                "title": p["title"]["rendered"] if isinstance(p.get("title"), dict) else p.get("title"),
                "status": p.get("status"),
                "link": p.get("link"),
                "date": p.get("date"),
                "modified": p.get("modified"),
            }
            for p in posts
        ],
    })


def cmd_get_post(args):
    site, auth = get_config()
    p = request("GET", site, auth, f"{args.post_type}/{args.id}", params={"context": "edit"})
    result({"status": "ok", "post": p})


def _read_content(args):
    if args.content_file:
        with open(args.content_file, "r", encoding="utf-8") as f:
            return f.read()
    return args.content or ""


def cmd_create_post(args):
    site, auth = get_config()
    payload = {
        "title": args.title,
        "content": _read_content(args),
        "status": args.status,
    }
    if args.excerpt:
        payload["excerpt"] = args.excerpt
    if args.categories:
        payload["categories"] = [int(c) for c in args.categories.split(",")]
    if args.tags:
        payload["tags"] = [int(t) for t in args.tags.split(",")]
    if args.featured_media:
        payload["featured_media"] = int(args.featured_media)
    if args.slug:
        payload["slug"] = args.slug
    post = request("POST", site, auth, args.post_type, json=payload)
    result({
        "status": "ok",
        "action": "created",
        "id": post["id"],
        "link": post.get("link"),
        "post_status": post.get("status"),
    })


def cmd_update_post(args):
    site, auth = get_config()
    payload = {}
    if args.title:
        payload["title"] = args.title
    if args.content_file or args.content:
        payload["content"] = _read_content(args)
    if args.status:
        payload["status"] = args.status
    if args.excerpt:
        payload["excerpt"] = args.excerpt
    if args.categories:
        payload["categories"] = [int(c) for c in args.categories.split(",")]
    if args.tags:
        payload["tags"] = [int(t) for t in args.tags.split(",")]
    if args.featured_media:
        payload["featured_media"] = int(args.featured_media)
    if args.slug:
        payload["slug"] = args.slug
    if not payload:
        result({"error": "Nothing to update — pass at least one of --title/--content/--content-file/--status/etc."})
        sys.exit(1)
    post = request("POST", site, auth, f"{args.post_type}/{args.id}", json=payload)
    result({
        "status": "ok",
        "action": "updated",
        "id": post["id"],
        "link": post.get("link"),
        "post_status": post.get("status"),
    })


def cmd_upload_media(args):
    site, auth = get_config()
    filename = os.path.basename(args.file)
    ext = filename.rsplit(".", 1)[-1].lower()
    content_type = {
        "jpg": "image/jpeg", "jpeg": "image/jpeg", "png": "image/png",
        "gif": "image/gif", "webp": "image/webp", "pdf": "application/pdf",
    }.get(ext, "application/octet-stream")
    with open(args.file, "rb") as f:
        data = f.read()
    url = urljoin(api_base(site), "media")
    resp = requests.post(
        url, auth=auth, data=data, timeout=60,
        headers={
            "Content-Disposition": f'attachment; filename="{filename}"',
            "Content-Type": content_type,
        },
    )
    if resp.status_code >= 400:
        result({"error": f"media upload -> HTTP {resp.status_code}", "detail": resp.text[:500]})
        sys.exit(1)
    media = resp.json()
    if args.alt_text:
        request("POST", site, auth, f"media/{media['id']}", json={"alt_text": args.alt_text})
    result({"status": "ok", "id": media["id"], "source_url": media.get("source_url")})


def cmd_list_categories(args):
    site, auth = get_config()
    cats = request("GET", site, auth, "categories", params={"per_page": 100})
    result({"status": "ok", "categories": [{"id": c["id"], "name": c["name"], "slug": c["slug"]} for c in cats]})


def main():
    parser = argparse.ArgumentParser(description="WordPress REST API client")
    parser.add_argument("--site", default=None,
                         help="Named business config to use (sites/<site>.env). "
                              "Omit to use the plain ./.env file (single-site mode). "
                              "Must come before the subcommand, e.g. "
                              "'wp_client.py --site 247plumbersgp whoami'.")
    sub = parser.add_subparsers(dest="command", required=True)

    sub.add_parser("whoami", help="Verify credentials and show capabilities").set_defaults(func=cmd_whoami)

    p = sub.add_parser("list-posts", help="List posts")
    p.add_argument("--status", default=None, help="publish|draft|future|pending|private")
    p.add_argument("--search", default=None)
    p.add_argument("--limit", type=int, default=10)
    p.add_argument("--post-type", default="posts", help="REST base, e.g. 'posts', 'pages', or a custom post type like 'gp_area' (default: posts)")
    p.set_defaults(func=cmd_list_posts)

    p = sub.add_parser("get-post", help="Get one post by ID")
    p.add_argument("--id", required=True)
    p.add_argument("--post-type", default="posts", help="REST base, e.g. 'posts', 'pages', or a custom post type like 'gp_area' (default: posts)")
    p.set_defaults(func=cmd_get_post)

    p = sub.add_parser("create-post", help="Create a new post")
    p.add_argument("--title", required=True)
    p.add_argument("--content", default=None, help="Raw HTML content (or use --content-file)")
    p.add_argument("--content-file", default=None, help="Path to a file with HTML content")
    p.add_argument("--status", default="draft", help="draft|publish|future|pending (default: draft)")
    p.add_argument("--excerpt", default=None)
    p.add_argument("--categories", default=None, help="Comma-separated category IDs")
    p.add_argument("--tags", default=None, help="Comma-separated tag IDs")
    p.add_argument("--featured-media", default=None, help="Media ID from upload-media")
    p.add_argument("--slug", default=None)
    p.add_argument("--post-type", default="posts", help="REST base, e.g. 'posts', 'pages', or a custom post type like 'gp_area' (default: posts)")
    p.set_defaults(func=cmd_create_post)

    p = sub.add_parser("update-post", help="Update an existing post")
    p.add_argument("--id", required=True)
    p.add_argument("--title", default=None)
    p.add_argument("--content", default=None)
    p.add_argument("--content-file", default=None)
    p.add_argument("--status", default=None)
    p.add_argument("--excerpt", default=None)
    p.add_argument("--categories", default=None)
    p.add_argument("--tags", default=None)
    p.add_argument("--featured-media", default=None)
    p.add_argument("--slug", default=None)
    p.add_argument("--post-type", default="posts", help="REST base, e.g. 'posts', 'pages', or a custom post type like 'gp_area' (default: posts)")
    p.set_defaults(func=cmd_update_post)

    p = sub.add_parser("upload-media", help="Upload an image/file to the media library")
    p.add_argument("--file", required=True)
    p.add_argument("--alt-text", default=None)
    p.set_defaults(func=cmd_upload_media)

    sub.add_parser("list-categories", help="List categories (to find IDs)").set_defaults(func=cmd_list_categories)

    args = parser.parse_args()
    load_site_env(args.site)
    args.func(args)


if __name__ == "__main__":
    main()
