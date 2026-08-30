"""Claude-powered responder for inbound comments and DMs.

Given an inbound message, this produces both a reply draft and a lead
classification in one call, so `webhook_server.py` can decide whether to
route it to leads.py without a second round-trip.
"""
from __future__ import annotations

import json
from dataclasses import dataclass

from anthropic import Anthropic

from config import config

_client: Anthropic | None = None


def _anthropic() -> Anthropic:
    global _client
    if _client is None:
        config.require("anthropic_api_key")
        _client = Anthropic(api_key=config.anthropic_api_key)
    return _client


@dataclass
class ReplyResult:
    reply: str
    is_lead: bool
    lead_summary: str
    is_emergency: bool


SYSTEM_PROMPT = """\
You are the social media assistant for a local plumbing company, replying to \
public comments and direct messages on Facebook and Instagram. You reply as \
the business, in a friendly, professional, concise tone (1-3 sentences, no \
corporate boilerplate, no emoji spam - a single emoji is fine if it fits).

Rules:
- Only state facts given to you below. Never invent prices, appointment \
times, technician names, or promises about availability.
- Never diagnose a plumbing problem or give DIY repair instructions that \
could be unsafe (gas lines, electrical, active flooding) - just direct \
urgent/dangerous issues to call the phone number immediately.
- If the message sounds like a genuine service request (someone wants a \
quote, has a plumbing problem, asks about availability, pricing, or booking) \
mark it as a lead.
- If the message sounds like an active emergency (flooding, burst pipe, gas \
smell, no heat in freezing weather, sewage backup) mark it as an emergency \
AND as a lead, and the reply must tell them to call the phone number right \
away rather than wait for a DM/comment reply.
- Spam, bots, unrelated comments, or simple compliments are not leads - \
reply briefly and warmly, or leave reply empty ("") if no reply is warranted \
(e.g. pure spam/emoji comment with no real content).

Business facts:
{facts}

Respond with ONLY a JSON object, no markdown fences, matching exactly:
{{"reply": string, "is_lead": boolean, "is_emergency": boolean, "lead_summary": string}}
`lead_summary` should be empty string if is_lead is false, otherwise a one \
sentence summary of what the person needs, for a human to act on.
"""


def generate_reply(message_text: str, channel: str, author_name: str = "") -> ReplyResult:
    """`channel` is one of "facebook_comment", "instagram_comment",
    "facebook_dm", "instagram_dm" - used only to note context to Claude."""
    system = SYSTEM_PROMPT.format(facts=config.brand.facts_block())
    who = f" from {author_name}" if author_name else ""
    user = f"Inbound {channel}{who}:\n\"\"\"\n{message_text}\n\"\"\""

    resp = _anthropic().messages.create(
        model=config.claude_model,
        max_tokens=500,
        system=system,
        messages=[{"role": "user", "content": user}],
    )
    raw = "".join(block.text for block in resp.content if block.type == "text").strip()
    try:
        data = json.loads(raw)
    except json.JSONDecodeError:
        # Fall back to a safe no-op rather than crash the webhook handler on
        # a malformed model response.
        return ReplyResult(reply="", is_lead=False, lead_summary="", is_emergency=False)

    return ReplyResult(
        reply=data.get("reply", "") or "",
        is_lead=bool(data.get("is_lead", False)),
        lead_summary=data.get("lead_summary", "") or "",
        is_emergency=bool(data.get("is_emergency", False)),
    )
