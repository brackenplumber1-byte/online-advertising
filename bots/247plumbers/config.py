"""Central configuration for the 247plumbers social bot.

Everything is loaded from environment variables (see .env.example). Import
`config` from this module rather than reading os.environ directly elsewhere,
so there is exactly one place that defines defaults and required fields.
"""
from __future__ import annotations

import os
from dataclasses import dataclass, field
from pathlib import Path

from dotenv import load_dotenv

BASE_DIR = Path(__file__).resolve().parent
load_dotenv(BASE_DIR / ".env")


def _bool(name: str, default: bool = False) -> bool:
    return os.getenv(name, str(default)).strip().lower() in {"1", "true", "yes", "on"}


@dataclass(frozen=True)
class Brand:
    name: str = field(default_factory=lambda: os.getenv("BUSINESS_NAME", "247 Plumbers"))
    phone: str = field(default_factory=lambda: os.getenv("BUSINESS_PHONE", ""))
    website: str = field(default_factory=lambda: os.getenv("BUSINESS_WEBSITE", ""))
    service_area: str = field(default_factory=lambda: os.getenv("SERVICE_AREA", ""))
    hours: str = field(default_factory=lambda: os.getenv("BUSINESS_HOURS", "24/7 emergency service"))

    def facts_block(self) -> str:
        """Ground-truth facts to inject into every prompt, so Claude never
        invents a phone number, URL, or service area."""
        lines = [f"Business name: {self.name}"]
        if self.phone:
            lines.append(f"Phone: {self.phone}")
        if self.website:
            lines.append(f"Website: {self.website}")
        if self.service_area:
            lines.append(f"Service area: {self.service_area}")
        if self.hours:
            lines.append(f"Hours: {self.hours}")
        return "\n".join(lines)


@dataclass(frozen=True)
class Config:
    anthropic_api_key: str = field(default_factory=lambda: os.getenv("ANTHROPIC_API_KEY", ""))
    claude_model: str = field(default_factory=lambda: os.getenv("CLAUDE_MODEL", "claude-sonnet-5"))

    graph_api_version: str = field(default_factory=lambda: os.getenv("GRAPH_API_VERSION", "v21.0"))
    page_access_token: str = field(default_factory=lambda: os.getenv("PAGE_ACCESS_TOKEN", ""))
    page_id: str = field(default_factory=lambda: os.getenv("PAGE_ID", ""))
    ig_user_id: str = field(default_factory=lambda: os.getenv("IG_USER_ID", ""))
    app_secret: str = field(default_factory=lambda: os.getenv("APP_SECRET", ""))
    webhook_verify_token: str = field(default_factory=lambda: os.getenv("WEBHOOK_VERIFY_TOKEN", "change-me"))

    auto_send_replies: bool = field(default_factory=lambda: _bool("AUTO_SEND_REPLIES", False))

    leads_notify_to: str = field(default_factory=lambda: os.getenv("LEADS_NOTIFY_TO", ""))
    smtp_host: str = field(default_factory=lambda: os.getenv("SMTP_HOST", ""))
    smtp_port: int = field(default_factory=lambda: int(os.getenv("SMTP_PORT", "587")))
    smtp_user: str = field(default_factory=lambda: os.getenv("SMTP_USER", ""))
    smtp_pass: str = field(default_factory=lambda: os.getenv("SMTP_PASS", ""))
    smtp_from: str = field(default_factory=lambda: os.getenv("SMTP_FROM", ""))

    brand: Brand = field(default_factory=Brand)

    @property
    def graph_base(self) -> str:
        return f"https://graph.facebook.com/{self.graph_api_version}"

    def require(self, *names: str) -> None:
        missing = [n for n in names if not getattr(self, n)]
        if missing:
            raise RuntimeError(
                "Missing required config: " + ", ".join(missing) +
                ". Set these in bots/247plumbers/.env (see .env.example)."
            )


config = Config()

DRAFTS_DIR = BASE_DIR / "drafts"
LEADS_DIR = BASE_DIR / "leads"
DRAFTS_DIR.mkdir(exist_ok=True)
LEADS_DIR.mkdir(exist_ok=True)
