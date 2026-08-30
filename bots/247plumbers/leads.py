"""Lead storage and optional email notification.

Every lead detected in a comment or DM is appended to leads/leads.jsonl
(so nothing is ever lost even if email delivery fails), and — if SMTP is
configured — emailed to LEADS_NOTIFY_TO immediately.
"""
from __future__ import annotations

import json
import smtplib
import uuid
from dataclasses import asdict, dataclass
from datetime import datetime, timezone
from email.message import EmailMessage

from config import LEADS_DIR, config

LEADS_FILE = LEADS_DIR / "leads.jsonl"


@dataclass
class Lead:
    id: str
    created_at: str
    channel: str  # facebook_comment | instagram_comment | facebook_dm | instagram_dm
    author_name: str
    author_id: str
    message: str
    summary: str
    is_emergency: bool
    permalink: str = ""


def record_lead(channel: str, author_name: str, author_id: str, message: str,
                 summary: str, is_emergency: bool, permalink: str = "") -> Lead:
    lead = Lead(
        id=uuid.uuid4().hex[:12],
        created_at=datetime.now(timezone.utc).isoformat(),
        channel=channel,
        author_name=author_name,
        author_id=author_id,
        message=message,
        summary=summary,
        is_emergency=is_emergency,
        permalink=permalink,
    )
    with LEADS_FILE.open("a") as f:
        f.write(json.dumps(asdict(lead)) + "\n")
    _notify(lead)
    return lead


def list_leads() -> list[Lead]:
    if not LEADS_FILE.exists():
        return []
    leads = []
    with LEADS_FILE.open() as f:
        for line in f:
            line = line.strip()
            if line:
                leads.append(Lead(**json.loads(line)))
    return leads


def _notify(lead: Lead) -> None:
    if not (config.leads_notify_to and config.smtp_host and config.smtp_user):
        return
    subject = f"[{'EMERGENCY ' if lead.is_emergency else ''}Lead] {config.brand.name} - {lead.channel}"
    body = (
        f"Channel: {lead.channel}\n"
        f"From: {lead.author_name or lead.author_id}\n"
        f"Emergency: {lead.is_emergency}\n"
        f"Summary: {lead.summary}\n\n"
        f"Original message:\n{lead.message}\n"
        + (f"\nLink: {lead.permalink}\n" if lead.permalink else "")
    )
    msg = EmailMessage()
    msg["Subject"] = subject
    msg["From"] = config.smtp_from or config.smtp_user
    msg["To"] = config.leads_notify_to
    msg.set_content(body)

    try:
        with smtplib.SMTP(config.smtp_host, config.smtp_port, timeout=15) as smtp:
            smtp.starttls()
            smtp.login(config.smtp_user, config.smtp_pass)
            smtp.send_message(msg)
    except Exception as exc:  # noqa: BLE001 - notification failure must not break the webhook
        print(f"[leads] WARNING: failed to email lead notification: {exc}")
