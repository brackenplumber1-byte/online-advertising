#!/usr/bin/env python3
"""
facebook_ads.py — create and manage Facebook/Instagram ad campaigns via
the Meta Marketing API.

Safety model — READ THIS FIRST
-------------------------------
Ads spend real money the moment they're ACTIVE. Every object this
script creates (campaign, ad set, ad) is forced to `status=PAUSED` at
creation time, no matter what — there is no flag to create something
already live. Turning something on is a separate, explicit step:

    python3 facebook_ads.py --action update-status --id <id> --status ACTIVE

Only run that after the user has explicitly confirmed the budget,
targeting and creative. This mirrors "never send without approval"
elsewhere in this skill, but the stakes here are real dollars, not
just an unwanted message.

Object hierarchy: Campaign -> Ad Set -> Ad (+ Ad Creative)
  1. create-campaign   → objective + budget strategy live here (or per-adset)
  2. create-adset      → budget, schedule, targeting, optimization goal
  3. upload-image       → (optional) get an image_hash for a creative
  4. create-creative    → the actual post/image/link users will see
  5. create-ad          → links an ad set + a creative together
  6. insights            → performance: spend, impressions, clicks, ctr, cpc
  7. update-status       → PAUSED <-> ACTIVE, or ARCHIVED
  8. delete               → permanently remove an object

Every command prints exactly one `RESULT: {...}` JSON line on stdout.
"""

from __future__ import annotations

import argparse
import json
import os

from facebook_common import (
    default_ad_account_id,
    fail,
    graph_request,
    resolve_access_token,
    result_line,
)


def _ad_account(args: argparse.Namespace) -> str:
    acct = args.ad_account_id or default_ad_account_id()
    if not acct:
        fail("No ad account id given. Pass --ad-account-id or set FB_AD_ACCOUNT_ID in .env (without 'act_' prefix, either is fine).")
    if acct.startswith("act_"):
        acct = acct[len("act_"):]
    return acct


def _token(args: argparse.Namespace) -> str:
    # Ads API calls use the user access token (with ads_management scope),
    # not a Page token — Page tokens can't manage ad accounts.
    return resolve_access_token(args.access_token)


def cmd_create_campaign(args: argparse.Namespace) -> None:
    acct = _ad_account(args)
    token = _token(args)
    if not args.name or not args.objective:
        fail("--name and --objective are required (e.g. --objective OUTCOME_TRAFFIC).")

    special_ad_categories = args.special_ad_categories.split(",") if args.special_ad_categories else ["NONE"]

    data = {
        "name": args.name,
        "objective": args.objective,
        "status": "PAUSED",  # always — see module docstring
        "special_ad_categories": json.dumps(special_ad_categories),
    }
    if args.buying_type:
        data["buying_type"] = args.buying_type

    body = graph_request("POST", f"act_{acct}/campaigns", token, data=data)
    result_line({
        "status": "ok",
        "campaign_id": body.get("id"),
        "campaign_status": "PAUSED",
        "note": "Created PAUSED. It will not spend until you run --action update-status --status ACTIVE.",
    })


def cmd_create_adset(args: argparse.Namespace) -> None:
    acct = _ad_account(args)
    token = _token(args)
    if not args.campaign_id or not args.name or not args.optimization_goal or not args.billing_event:
        fail("--campaign-id, --name, --optimization-goal and --billing-event are required.")
    if not args.daily_budget and not args.lifetime_budget:
        fail("Provide --daily-budget or --lifetime-budget (in the account's smallest currency unit, e.g. cents).")
    if args.lifetime_budget and not args.end_time:
        fail("--end-time is required when using --lifetime-budget.")

    targeting = {"geo_locations": {"countries": ["US"]}}
    if args.targeting:
        try:
            targeting = json.loads(args.targeting)
        except json.JSONDecodeError as e:
            fail(f"--targeting must be valid JSON: {e}")
    elif not args.targeting_default_ack:
        fail(
            "No --targeting given. Refusing to silently target the default (US, broad, 18-65) — "
            "pass --targeting '<json>' explicitly, or --targeting-default-ack to confirm the default is intended."
        )

    data = {
        "name": args.name,
        "campaign_id": args.campaign_id,
        "status": "PAUSED",  # always — see module docstring
        "billing_event": args.billing_event,
        "optimization_goal": args.optimization_goal,
        "targeting": json.dumps(targeting),
    }
    if args.daily_budget:
        data["daily_budget"] = str(args.daily_budget)
    if args.lifetime_budget:
        data["lifetime_budget"] = str(args.lifetime_budget)
    if args.bid_amount:
        data["bid_amount"] = str(args.bid_amount)
    if args.start_time:
        data["start_time"] = args.start_time
    if args.end_time:
        data["end_time"] = args.end_time

    body = graph_request("POST", f"act_{acct}/adsets", token, data=data)
    result_line({
        "status": "ok",
        "adset_id": body.get("id"),
        "adset_status": "PAUSED",
        "targeting_used": targeting,
        "note": "Created PAUSED. It will not spend until you run --action update-status --status ACTIVE.",
    })


def cmd_upload_image(args: argparse.Namespace) -> None:
    acct = _ad_account(args)
    token = _token(args)
    if not args.file:
        fail("--file is required (local path to an image).")
    if not os.path.isfile(args.file):
        fail(f"File not found: {args.file}")

    with open(args.file, "rb") as fh:
        body = graph_request("POST", f"act_{acct}/adimages", token, files={"source": fh})

    images = body.get("images", {})
    # Response is keyed by the original filename or field name.
    first = next(iter(images.values()), {})
    result_line({"status": "ok", "image_hash": first.get("hash"), "url": first.get("url"), "raw": body})


def cmd_create_creative(args: argparse.Namespace) -> None:
    acct = _ad_account(args)
    token = _token(args)
    if not args.page_id or not args.name:
        fail("--page-id and --name are required.")
    if not (args.message or args.link or args.image_hash or args.picture):
        fail("Provide at least one of --message, --link, --image-hash, or --picture.")

    link_data: dict = {}
    if args.message:
        link_data["message"] = args.message
    if args.link:
        link_data["link"] = args.link
    if args.image_hash:
        link_data["image_hash"] = args.image_hash
    elif args.picture:
        link_data["picture"] = args.picture
    if args.call_to_action:
        link_data["call_to_action"] = {"type": args.call_to_action}

    object_story_spec = {"page_id": args.page_id, "link_data": link_data}

    data = {
        "name": args.name,
        "object_story_spec": json.dumps(object_story_spec),
    }
    body = graph_request("POST", f"act_{acct}/adcreatives", token, data=data)
    result_line({"status": "ok", "creative_id": body.get("id"), "object_story_spec": object_story_spec})


def cmd_create_ad(args: argparse.Namespace) -> None:
    acct = _ad_account(args)
    token = _token(args)
    if not args.adset_id or not args.creative_id or not args.name:
        fail("--adset-id, --creative-id and --name are required.")

    data = {
        "name": args.name,
        "adset_id": args.adset_id,
        "creative": json.dumps({"creative_id": args.creative_id}),
        "status": "PAUSED",  # always — see module docstring
    }
    body = graph_request("POST", f"act_{acct}/ads", token, data=data)
    result_line({
        "status": "ok",
        "ad_id": body.get("id"),
        "ad_status": "PAUSED",
        "note": "Created PAUSED. It will not spend until you run --action update-status --status ACTIVE.",
    })


def cmd_list(args: argparse.Namespace) -> None:
    acct = _ad_account(args)
    token = _token(args)
    endpoint_map = {
        "campaigns": (f"act_{acct}/campaigns", "id,name,objective,status,effective_status,created_time"),
        "adsets": (f"act_{acct}/adsets", "id,name,campaign_id,status,effective_status,daily_budget,lifetime_budget"),
        "ads": (f"act_{acct}/ads", "id,name,adset_id,status,effective_status,creative"),
    }
    if args.of not in endpoint_map:
        fail(f"--of must be one of {list(endpoint_map)}")
    endpoint, fields = endpoint_map[args.of]
    body = graph_request("GET", endpoint, token, params={"fields": fields, "limit": args.limit})
    result_line({"status": "ok", "of": args.of, "count": len(body.get("data", [])), "items": body.get("data", []), "paging": body.get("paging", {})})


def cmd_update_status(args: argparse.Namespace) -> None:
    token = _token(args)
    if not args.id or not args.status:
        fail("--id and --status are required.")
    if args.status not in {"ACTIVE", "PAUSED", "ARCHIVED", "DELETED"}:
        fail("--status must be one of ACTIVE, PAUSED, ARCHIVED, DELETED.")
    if args.status == "ACTIVE" and not args.confirm_spend:
        fail(
            "Setting status=ACTIVE will start real ad spend. Re-run with --confirm-spend once the "
            "user has explicitly approved the budget and targeting for this object."
        )
    body = graph_request("POST", args.id, token, data={"status": args.status})
    result_line({"status": "ok", "id": args.id, "new_status": args.status, "raw": body})


def cmd_insights(args: argparse.Namespace) -> None:
    token = _token(args)
    target = args.id or (f"act_{_ad_account(args)}" if args.level == "account" else None)
    if not target:
        fail("--id is required unless --level account (which uses --ad-account-id/FB_AD_ACCOUNT_ID).")

    fields = args.fields or "spend,impressions,clicks,ctr,cpc,cpm,reach,actions"
    params = {"fields": fields}
    if args.date_preset:
        params["date_preset"] = args.date_preset
    elif args.since and args.until:
        params["time_range"] = json.dumps({"since": args.since, "until": args.until})
    else:
        params["date_preset"] = "last_7d"

    body = graph_request("GET", f"{target}/insights", token, params=params)
    result_line({"status": "ok", "id": target, "insights": body.get("data", [])})


def cmd_delete(args: argparse.Namespace) -> None:
    token = _token(args)
    if not args.id:
        fail("--id is required.")
    body = graph_request("DELETE", args.id, token)
    result_line({"status": "ok", "deleted": bool(body.get("success", True)), "id": args.id})


def main() -> None:
    parser = argparse.ArgumentParser(description="Create and manage Facebook/Instagram ads via the Marketing API.")
    parser.add_argument("--action", required=True, choices=[
        "create-campaign", "create-adset", "upload-image", "create-creative",
        "create-ad", "list", "update-status", "insights", "delete",
    ])
    parser.add_argument("--ad-account-id", default=None, help="Defaults to FB_AD_ACCOUNT_ID from .env. With or without 'act_' prefix.")
    parser.add_argument("--access-token", default=None, help="Overrides the saved/env user access token.")

    # campaign
    parser.add_argument("--name", default=None)
    parser.add_argument("--objective", default=None, help="e.g. OUTCOME_TRAFFIC, OUTCOME_ENGAGEMENT, OUTCOME_LEADS, OUTCOME_SALES, OUTCOME_AWARENESS")
    parser.add_argument("--special-ad-categories", default=None, help="Comma-separated, e.g. CREDIT,EMPLOYMENT,HOUSING. Defaults to NONE.")
    parser.add_argument("--buying-type", default=None)

    # ad set
    parser.add_argument("--campaign-id", default=None)
    parser.add_argument("--daily-budget", type=int, default=None, help="Smallest currency unit (e.g. cents).")
    parser.add_argument("--lifetime-budget", type=int, default=None, help="Smallest currency unit (e.g. cents).")
    parser.add_argument("--bid-amount", type=int, default=None)
    parser.add_argument("--billing-event", default=None, help="e.g. IMPRESSIONS")
    parser.add_argument("--optimization-goal", default=None, help="e.g. LINK_CLICKS, REACH, POST_ENGAGEMENT")
    parser.add_argument("--targeting", default=None, help="JSON object, e.g. '{\"geo_locations\":{\"countries\":[\"US\"]},\"age_min\":18,\"age_max\":65}'")
    parser.add_argument("--targeting-default-ack", action="store_true", help="Confirm using the built-in default targeting (broad US 18-65) instead of passing --targeting.")
    parser.add_argument("--start-time", default=None, help="ISO-8601.")
    parser.add_argument("--end-time", default=None, help="ISO-8601. Required with --lifetime-budget.")

    # creative
    parser.add_argument("--page-id", default=None)
    parser.add_argument("--message", default=None)
    parser.add_argument("--link", default=None)
    parser.add_argument("--picture", default=None, help="Public image URL for the creative.")
    parser.add_argument("--image-hash", default=None, help="From --action upload-image.")
    parser.add_argument("--call-to-action", default=None, help="e.g. LEARN_MORE, SHOP_NOW, SIGN_UP")

    # ad
    parser.add_argument("--adset-id", default=None)
    parser.add_argument("--creative-id", default=None)

    # upload-image
    parser.add_argument("--file", default=None, help="Local image path for --action upload-image.")

    # list / insights / update-status / delete
    parser.add_argument("--of", default=None, choices=["campaigns", "adsets", "ads"], help="For --action list.")
    parser.add_argument("--limit", type=int, default=25)
    parser.add_argument("--id", default=None, help="Target object id for update-status / insights / delete.")
    parser.add_argument("--status", default=None, help="ACTIVE, PAUSED, ARCHIVED, or DELETED (for --action update-status).")
    parser.add_argument("--confirm-spend", action="store_true", help="Required to set --status ACTIVE. Only pass this after explicit user approval.")
    parser.add_argument("--level", default="campaign", choices=["account", "campaign", "adset", "ad"], help="For --action insights.")
    parser.add_argument("--fields", default=None, help="For --action insights. Comma-separated Graph API insight fields.")
    parser.add_argument("--date-preset", default=None, help="e.g. today, yesterday, last_7d, last_30d, lifetime.")
    parser.add_argument("--since", default=None, help="YYYY-MM-DD, used with --until instead of --date-preset.")
    parser.add_argument("--until", default=None, help="YYYY-MM-DD, used with --since instead of --date-preset.")

    args = parser.parse_args()

    try:
        {
            "create-campaign": cmd_create_campaign,
            "create-adset": cmd_create_adset,
            "upload-image": cmd_upload_image,
            "create-creative": cmd_create_creative,
            "create-ad": cmd_create_ad,
            "list": cmd_list,
            "update-status": cmd_update_status,
            "insights": cmd_insights,
            "delete": cmd_delete,
        }[args.action](args)
    except Exception as e:  # noqa: BLE001
        fail(str(e))


if __name__ == "__main__":
    main()
