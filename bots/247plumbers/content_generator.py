"""Claude-powered caption writer for scheduled/ad-hoc posts."""
from __future__ import annotations

from anthropic import Anthropic

from config import config

_client: Anthropic | None = None


def _anthropic() -> Anthropic:
    global _client
    if _client is None:
        config.require("anthropic_api_key")
        _client = Anthropic(api_key=config.anthropic_api_key)
    return _client


PLATFORM_RULES = {
    "facebook": (
        "Facebook post. Up to ~2-3 short paragraphs is fine. Friendly, helpful, "
        "locally-focused tone. End with a clear call to action (call the number "
        "or visit the website). 2-5 relevant hashtags at most, or none at all."
    ),
    "instagram": (
        "Instagram caption. Punchy opening line (shows before 'more'), casual "
        "but professional tone, short paragraphs or line breaks, end with a "
        "call to action and 5-10 relevant hashtags on their own line at the end."
    ),
}


def generate_caption(topic: str, platform: str, extra_instructions: str = "") -> str:
    """Generates a single-platform caption for the given topic.

    `topic` is a short brief, e.g. "reminder to flush water heaters before
    winter" or "promo: $50 off drain cleaning this week".
    """
    if platform not in PLATFORM_RULES:
        raise ValueError(f"Unknown platform {platform!r}; expected one of {list(PLATFORM_RULES)}")

    system = (
        "You are the social media copywriter for a local plumbing company. "
        "Write copy that sounds like a real, trustworthy local business — "
        "never generic corporate marketing speak, never over-the-top salesy. "
        "Only state facts you are given below; never invent a phone number, "
        "price, address, or promotion that wasn't provided.\n\n"
        f"Business facts:\n{config.brand.facts_block()}\n\n"
        f"Platform requirements:\n{PLATFORM_RULES[platform]}"
    )
    user = f"Write a {platform} post about: {topic}"
    if extra_instructions:
        user += f"\n\nAdditional instructions: {extra_instructions}"

    resp = _anthropic().messages.create(
        model=config.claude_model,
        max_tokens=600,
        system=system,
        messages=[{"role": "user", "content": user}],
    )
    return "".join(block.text for block in resp.content if block.type == "text").strip()
