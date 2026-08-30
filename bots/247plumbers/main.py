"""CLI for the 247plumbers social bot.

  Content posting:
    python main.py generate --topic "..." --platforms facebook instagram [--image-url URL]
    python main.py list [--status draft]
    python main.py show <draft-id>
    python main.py publish <draft-id> [--platforms facebook instagram]
    python main.py discard <draft-id>

  Comment/DM auto-reply + lead capture (see webhook_server.py):
    python main.py run-server [--port 8080]
    python main.py leads

  Setup verification:
    python main.py doctor
"""
from __future__ import annotations

import argparse
import sys

import leads as leads_module
from config import config
from content_generator import generate_caption
from drafts import list_drafts, load_draft, new_draft
from meta_client import MetaClient, MetaAPIError


def cmd_generate(args: argparse.Namespace) -> None:
    platforms_data = {}
    for platform in args.platforms:
        caption = generate_caption(args.topic, platform, extra_instructions=args.instructions or "")
        entry = {"caption": caption}
        if platform == "instagram":
            entry["image_url"] = args.image_url or ""
        platforms_data[platform] = entry

    draft = new_draft(kind="post", data={"topic": args.topic, "platforms": platforms_data})
    print(f"Created draft {draft.id}\n")
    for platform, entry in platforms_data.items():
        print(f"── {platform} ──────────────────────────")
        print(entry["caption"])
        if platform == "instagram" and not entry["image_url"]:
            print("\n  (!) no --image-url given - required before this can be published to Instagram)")
        print()
    print(f"Review, then run: python main.py publish {draft.id}")


def cmd_list(args: argparse.Namespace) -> None:
    drafts = list_drafts(status=args.status)
    if not drafts:
        print("No drafts.")
        return
    for d in drafts:
        label = d.data.get("topic") or d.data.get("channel", "")
        print(f"{d.id}  [{d.kind:5s}] [{d.status:9s}] {d.created_at}  {label}")


def cmd_show(args: argparse.Namespace) -> None:
    draft = load_draft(args.draft_id)
    print(f"id: {draft.id}  kind: {draft.kind}  status: {draft.status}  created: {draft.created_at}")
    print()
    if draft.kind == "post":
        for platform, entry in draft.data.get("platforms", {}).items():
            print(f"── {platform} ──")
            print(entry["caption"])
            if entry.get("image_url"):
                print(f"[image: {entry['image_url']}]")
            print()
    else:
        print(f"channel: {draft.data.get('channel')}")
        print(f"from: {draft.data.get('author_name') or draft.data.get('item_id')}")
        print(f"inbound: {draft.data.get('inbound_text')}")
        print(f"reply: {draft.data.get('reply')}")
    if draft.published:
        print(f"published: {draft.published}")


def cmd_publish(args: argparse.Namespace) -> None:
    draft = load_draft(args.draft_id)
    if draft.status == "published":
        print(f"Draft {draft.id} is already published.")
        return

    client = MetaClient()

    if draft.kind == "post":
        platforms = args.platforms or list(draft.data.get("platforms", {}).keys())
        results = {}
        for platform in platforms:
            entry = draft.data["platforms"].get(platform)
            if not entry:
                print(f"  skip {platform}: not part of this draft")
                continue
            try:
                if platform == "facebook":
                    post_id = client.post_facebook(entry["caption"])
                elif platform == "instagram":
                    if not entry.get("image_url"):
                        print("  skip instagram: no image_url set on this draft")
                        continue
                    post_id = client.post_instagram(entry["caption"], entry["image_url"])
                else:
                    print(f"  skip {platform}: unsupported platform")
                    continue
                results[platform] = {"id": post_id}
                print(f"  published to {platform}: {post_id}")
            except MetaAPIError as exc:
                print(f"  FAILED to publish to {platform}: {exc}")
        draft.published.update(results)
        if results:
            draft.status = "published"
        draft.save()

    elif draft.kind == "reply":
        data = draft.data
        try:
            if data["channel"] == "facebook_comment":
                result_id = client.reply_to_facebook_comment(data["item_id"], data["reply"])
            elif data["channel"] == "instagram_comment":
                result_id = client.reply_to_instagram_comment(data["item_id"], data["reply"])
            elif data["channel"] == "direct_message":
                result_id = client.send_dm(data["item_id"], data["reply"])
            else:
                print(f"Unknown reply channel: {data['channel']}")
                return
            draft.published = {"result": result_id}
            draft.status = "published"
            draft.save()
            print(f"Sent reply on {data['channel']}.")
        except MetaAPIError as exc:
            print(f"FAILED to send reply: {exc}")


def cmd_discard(args: argparse.Namespace) -> None:
    draft = load_draft(args.draft_id)
    draft.status = "discarded"
    draft.save()
    print(f"Discarded {draft.id}")


def cmd_leads(args: argparse.Namespace) -> None:
    all_leads = leads_module.list_leads()
    if not all_leads:
        print("No leads recorded yet.")
        return
    for lead in all_leads:
        flag = "🚨 EMERGENCY " if lead.is_emergency else ""
        print(f"{lead.created_at}  {flag}[{lead.channel}] {lead.author_name or lead.author_id}")
        print(f"   {lead.summary}")


def cmd_run_server(args: argparse.Namespace) -> None:
    from webhook_server import app
    app.run(host="0.0.0.0", port=args.port)


def cmd_doctor(args: argparse.Namespace) -> None:
    ok = True

    def check(label, fn):
        nonlocal ok
        try:
            result = fn()
            print(f"  OK   {label}: {result}")
        except Exception as exc:  # noqa: BLE001
            ok = False
            print(f"  FAIL {label}: {exc}")

    print("Config:")
    for name in ["anthropic_api_key", "page_access_token", "page_id", "ig_user_id", "app_secret"]:
        val = getattr(config, name)
        print(f"  {'set' if val else 'MISSING':7s} {name}")
        ok = ok and bool(val)

    print("\nAPI checks:")
    client = MetaClient()
    check("Facebook page token", client.whoami_page)
    check("Instagram business account", client.whoami_instagram)

    print(f"\nAUTO_SEND_REPLIES = {config.auto_send_replies}  "
          f"({'replies post live automatically' if config.auto_send_replies else 'replies are queued as drafts for review'})")

    sys.exit(0 if ok else 1)


def main() -> None:
    parser = argparse.ArgumentParser(description="247plumbers social bot")
    sub = parser.add_subparsers(dest="command", required=True)

    p = sub.add_parser("generate", help="Generate a new post draft")
    p.add_argument("--topic", required=True)
    p.add_argument("--platforms", nargs="+", choices=["facebook", "instagram"], default=["facebook", "instagram"])
    p.add_argument("--image-url", help="Required for Instagram")
    p.add_argument("--instructions", help="Extra guidance for Claude")
    p.set_defaults(func=cmd_generate)

    p = sub.add_parser("list", help="List drafts")
    p.add_argument("--status", choices=["draft", "published", "discarded"])
    p.set_defaults(func=cmd_list)

    p = sub.add_parser("show", help="Show a draft")
    p.add_argument("draft_id")
    p.set_defaults(func=cmd_show)

    p = sub.add_parser("publish", help="Publish a draft (post or queued reply)")
    p.add_argument("draft_id")
    p.add_argument("--platforms", nargs="+", choices=["facebook", "instagram"])
    p.set_defaults(func=cmd_publish)

    p = sub.add_parser("discard", help="Discard a draft without publishing")
    p.add_argument("draft_id")
    p.set_defaults(func=cmd_discard)

    p = sub.add_parser("leads", help="List captured leads")
    p.set_defaults(func=cmd_leads)

    p = sub.add_parser("run-server", help="Start the webhook receiver for comments/DMs")
    p.add_argument("--port", type=int, default=8080)
    p.set_defaults(func=cmd_run_server)

    p = sub.add_parser("doctor", help="Validate config and API credentials")
    p.set_defaults(func=cmd_doctor)

    args = parser.parse_args()
    args.func(args)


if __name__ == "__main__":
    main()
