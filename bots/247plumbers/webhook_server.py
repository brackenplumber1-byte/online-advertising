"""Flask webhook receiver for Facebook Page + Instagram comments and DMs.

Run with `python main.py run-server` (see README.md for exposing this
publicly with a tunnel like ngrok/Cloudflare Tunnel during setup, and for
deploying it behind a real HTTPS endpoint in production).

Flow per inbound event:
  1. Verify the request signature (X-Hub-Signature-256) against APP_SECRET.
  2. Skip events the page itself generated (its own comments/replies) and
     events already processed (webhook retries are common).
  3. Ask Claude for a reply + lead classification (reply_generator.py).
  4. If it's a lead, record it (leads.py) - this always happens regardless
     of the auto-send setting below.
  5. If AUTO_SEND_REPLIES=true, send the reply immediately via the Graph
     API. Otherwise, save it as a "reply" draft for a human to approve
     with `python main.py publish <id>`.
"""
from __future__ import annotations

import hashlib
import hmac
import json

from flask import Flask, request

import leads
from config import BASE_DIR, config
from drafts import new_draft
from meta_client import MetaClient
from reply_generator import generate_reply

app = Flask(__name__)
client = MetaClient()

PROCESSED_EVENTS_FILE = BASE_DIR / "processed_events.json"
_MAX_PROCESSED = 5000


def _load_processed() -> set[str]:
    if PROCESSED_EVENTS_FILE.exists():
        return set(json.loads(PROCESSED_EVENTS_FILE.read_text()))
    return set()


def _save_processed(ids: set[str]) -> None:
    trimmed = list(ids)[-_MAX_PROCESSED:]
    PROCESSED_EVENTS_FILE.write_text(json.dumps(trimmed))


def _verify_signature(payload: bytes, signature_header: str | None) -> bool:
    if not config.app_secret:
        # No secret configured (e.g. local dev) - warn but don't block.
        print("[webhook] WARNING: APP_SECRET not set, skipping signature check")
        return True
    if not signature_header or not signature_header.startswith("sha256="):
        return False
    expected = hmac.new(config.app_secret.encode(), payload, hashlib.sha256).hexdigest()
    return hmac.compare_digest(expected, signature_header.removeprefix("sha256="))


@app.get("/webhook")
def verify():
    """Meta's one-time webhook subscription handshake."""
    if (
        request.args.get("hub.mode") == "subscribe"
        and request.args.get("hub.verify_token") == config.webhook_verify_token
    ):
        return request.args.get("hub.challenge", ""), 200
    return "verification failed", 403


@app.post("/webhook")
def receive():
    payload = request.get_data()
    if not _verify_signature(payload, request.headers.get("X-Hub-Signature-256")):
        return "invalid signature", 403

    body = request.get_json(force=True, silent=True) or {}
    processed = _load_processed()

    for entry in body.get("entry", []):
        for change in entry.get("changes", []):
            _handle_comment_change(change, processed)
        for message_event in entry.get("messaging", []):
            _handle_message_event(message_event, processed)

    _save_processed(processed)
    return "ok", 200


def _handle_comment_change(change: dict, processed: set[str]) -> None:
    field = change.get("field")
    value = change.get("value", {})

    if field == "feed" and value.get("item") == "comment" and value.get("verb") == "add":
        comment_id = value.get("comment_id")
        from_id = str(value.get("from", {}).get("id", ""))
        if not comment_id or comment_id in processed or from_id == config.page_id:
            return
        processed.add(comment_id)
        _reply_and_maybe_lead(
            channel="facebook_comment",
            item_id=comment_id,
            author_name=value.get("from", {}).get("name", ""),
            author_id=from_id,
            text=value.get("message", ""),
            permalink=f"https://facebook.com/{value.get('post_id', '')}",
        )

    elif field == "comments":
        comment_id = value.get("id")
        from_id = str(value.get("from", {}).get("id", ""))
        if not comment_id or comment_id in processed or from_id == config.ig_user_id:
            return
        processed.add(comment_id)
        _reply_and_maybe_lead(
            channel="instagram_comment",
            item_id=comment_id,
            author_name=value.get("from", {}).get("username", ""),
            author_id=from_id,
            text=value.get("text", ""),
        )


def _handle_message_event(event: dict, processed: set[str]) -> None:
    if event.get("message", {}).get("is_echo"):
        return  # sent by the page itself
    mid = event.get("message", {}).get("mid")
    sender_id = str(event.get("sender", {}).get("id", ""))
    text = event.get("message", {}).get("text", "")
    if not mid or mid in processed or not text:
        return
    processed.add(mid)
    # Meta doesn't distinguish FB vs IG DMs in the payload shape; both use
    # the unified Send API, so we just label it generically here.
    _reply_and_maybe_lead(
        channel="direct_message",
        item_id=sender_id,
        author_name="",
        author_id=sender_id,
        text=text,
    )


def _reply_and_maybe_lead(channel: str, item_id: str, author_name: str, author_id: str,
                           text: str, permalink: str = "") -> None:
    result = generate_reply(text, channel=channel, author_name=author_name)

    if result.is_lead:
        leads.record_lead(
            channel=channel,
            author_name=author_name,
            author_id=author_id,
            message=text,
            summary=result.lead_summary,
            is_emergency=result.is_emergency,
            permalink=permalink,
        )

    if not result.reply:
        return

    action = {
        "channel": channel,
        "item_id": item_id,
        "author_name": author_name,
        "inbound_text": text,
        "reply": result.reply,
    }

    if config.auto_send_replies:
        _send_reply(channel, item_id, result.reply)
    else:
        new_draft(kind="reply", data=action)


def _send_reply(channel: str, item_id: str, reply: str) -> None:
    if channel == "facebook_comment":
        client.reply_to_facebook_comment(item_id, reply)
    elif channel == "instagram_comment":
        client.reply_to_instagram_comment(item_id, reply)
    elif channel == "direct_message":
        client.send_dm(item_id, reply)


if __name__ == "__main__":
    app.run(host="0.0.0.0", port=8080)
