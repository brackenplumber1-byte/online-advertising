"""Draft management for scheduled/generated posts.

Posts are never published straight from `generate` - they're written as a
JSON draft file that a human (or `main.py publish`) reviews and pushes live.
Pending reply drafts (comment/DM replies not auto-sent because
AUTO_SEND_REPLIES=false) are stored the same way, under kind="reply".
"""
from __future__ import annotations

import json
import uuid
from dataclasses import asdict, dataclass, field
from datetime import datetime, timezone

from config import DRAFTS_DIR


@dataclass
class Draft:
    id: str
    kind: str  # "post" or "reply"
    created_at: str
    status: str = "draft"  # draft | published | discarded
    data: dict = field(default_factory=dict)
    published: dict = field(default_factory=dict)

    def path(self):
        return DRAFTS_DIR / f"{self.id}.json"

    def save(self) -> None:
        self.path().write_text(json.dumps(asdict(self), indent=2))


def new_draft(kind: str, data: dict) -> Draft:
    draft = Draft(
        id=uuid.uuid4().hex[:10],
        kind=kind,
        created_at=datetime.now(timezone.utc).isoformat(),
        data=data,
    )
    draft.save()
    return draft


def load_draft(draft_id: str) -> Draft:
    path = DRAFTS_DIR / f"{draft_id}.json"
    if not path.exists():
        raise FileNotFoundError(f"No draft with id {draft_id!r}")
    return Draft(**json.loads(path.read_text()))


def list_drafts(status: str | None = None) -> list[Draft]:
    drafts = [Draft(**json.loads(p.read_text())) for p in sorted(DRAFTS_DIR.glob("*.json"))]
    if status:
        drafts = [d for d in drafts if d.status == status]
    return drafts
