"""
Shared helpers for the Facebook Marketing skill.

What lives here
----------------
* `facebook_home()` — the per-user state directory (`~/.facebook` by
  default, overridable via the `FACEBOOK_HOME` env var). OAuth tokens
  and page-token caches are stored under this folder so a user can
  wipe one directory to reset everything.
* Token store helpers — `load_tokens()`, `save_tokens()`.
* `graph_request()` — a thin wrapper around the Graph API that raises
  a readable error when Meta returns `{"error": {...}}`.
* `resolve_access_token()` — picks the right token for a call, in
  priority order: explicit CLI flag > env var > saved token store.
* `log()` / `result_line()` — consistent stdout for AI agents to parse.

Open-source friendly
---------------------
Everything in this module is local-only. No telemetry, no third-party
calls other than to graph.facebook.com, no hardcoded credentials.
Bring your own Meta App + Page + Ad Account.
"""

from __future__ import annotations

import json
import os
import sys
import time
from datetime import datetime, timezone
from pathlib import Path
from typing import Any

import requests

try:
    from dotenv import load_dotenv

    load_dotenv()
except ImportError:  # pragma: no cover - dotenv is a listed dependency, but degrade gracefully
    pass

# ---------------------------------------------------------------------------
# Constants
# ---------------------------------------------------------------------------
# Meta ships a few new Graph API versions a year. This default is a
# reasonably current stable version — if calls start failing with a
# deprecation error, bump FB_API_VERSION in your .env (see the changelog
# at https://developers.facebook.com/docs/graph-api/changelog).
DEFAULT_API_VERSION = "v21.0"

GRAPH_BASE = "https://graph.facebook.com"

USER_AGENT = "facebook-marketing-skill/1.0 (+https://github.com/)"

TOKENS_FILENAME = "tokens.json"


# ---------------------------------------------------------------------------
# State directory
# ---------------------------------------------------------------------------
def facebook_home() -> Path:
    """Return the directory where this skill stores its state.

    Default: `~/.facebook`. Override with the `FACEBOOK_HOME` env var.
    """
    override = os.environ.get("FACEBOOK_HOME")
    if override:
        p = Path(override).expanduser().resolve()
    else:
        p = Path.home() / ".facebook"
    p.mkdir(parents=True, exist_ok=True)
    return p


def tokens_file() -> Path:
    return facebook_home() / TOKENS_FILENAME


# ---------------------------------------------------------------------------
# Logging helpers
# ---------------------------------------------------------------------------
def log(msg: str, **extra: Any) -> None:
    """Human-readable timestamped log line on stderr (so stdout stays
    clean for `RESULT:` lines that AI agents parse)."""
    ts = datetime.now(timezone.utc).strftime("%Y-%m-%d %H:%M:%S")
    if extra:
        msg = f"{msg} | {json.dumps(extra, default=str)}"
    print(f"[{ts}] {msg}", flush=True, file=sys.stderr)


def result_line(payload: dict[str, Any]) -> None:
    """Single-line `RESULT: {...}` JSON on stdout — the canonical
    channel for AI agents and shell scripts to parse the outcome of
    any command."""
    print(f"RESULT: {json.dumps(payload, default=str)}", flush=True)


def fail(error: str, **extra: Any) -> None:
    """Emit a RESULT with status=error and exit non-zero."""
    result_line({"status": "error", "error": error, **extra})
    sys.exit(1)


# ---------------------------------------------------------------------------
# Token store (~/.facebook/tokens.json)
# ---------------------------------------------------------------------------
def load_tokens() -> dict[str, Any]:
    fp = tokens_file()
    if not fp.exists():
        return {}
    try:
        return json.loads(fp.read_text())
    except Exception as e:
        log(f"WARNING: could not parse token store at {fp}: {e}")
        return {}


def save_tokens(data: dict[str, Any]) -> None:
    fp = tokens_file()
    fp.write_text(json.dumps(data, indent=2, default=str))
    try:
        fp.chmod(0o600)
    except OSError:
        pass


def save_page_token(page_id: str, name: str, access_token: str, category: str | None = None) -> None:
    data = load_tokens()
    pages = data.setdefault("pages", {})
    pages[page_id] = {
        "name": name,
        "access_token": access_token,
        "category": category,
        "saved_at": datetime.now(timezone.utc).isoformat(),
    }
    save_tokens(data)


def get_saved_page_token(page_id: str) -> str | None:
    pages = load_tokens().get("pages", {})
    entry = pages.get(page_id)
    return entry.get("access_token") if entry else None


# ---------------------------------------------------------------------------
# Config
# ---------------------------------------------------------------------------
def api_version() -> str:
    return os.environ.get("FB_API_VERSION", DEFAULT_API_VERSION)


def app_id() -> str | None:
    return os.environ.get("FB_APP_ID")


def app_secret() -> str | None:
    return os.environ.get("FB_APP_SECRET")


def default_page_id() -> str | None:
    return os.environ.get("FB_PAGE_ID")


def default_ad_account_id() -> str | None:
    """Returns the ad account id WITHOUT the `act_` prefix, if configured."""
    val = os.environ.get("FB_AD_ACCOUNT_ID")
    if val and val.startswith("act_"):
        val = val[len("act_"):]
    return val


def resolve_access_token(cli_token: str | None, page_id: str | None = None) -> str:
    """Pick an access token in priority order:

    1. Explicit `--access-token` CLI flag.
    2. Saved page token for `page_id` (from `facebook_login.py --action pages`).
    3. `FB_PAGE_ACCESS_TOKEN` env var.
    4. `FB_USER_ACCESS_TOKEN` / saved user token (from login).
    5. `FB_ACCESS_TOKEN` generic env var.

    Raises RuntimeError with an actionable message if nothing is found.
    """
    if cli_token:
        return cli_token

    if page_id:
        saved = get_saved_page_token(page_id)
        if saved:
            return saved

    env_page_token = os.environ.get("FB_PAGE_ACCESS_TOKEN")
    if env_page_token:
        return env_page_token

    user_token = os.environ.get("FB_USER_ACCESS_TOKEN")
    if not user_token:
        user_token = load_tokens().get("user_access_token")
    if user_token:
        return user_token

    generic = os.environ.get("FB_ACCESS_TOKEN")
    if generic:
        return generic

    raise RuntimeError(
        "No Facebook access token found. Run: python3 facebook_login.py --action login\n"
        "(or set FB_PAGE_ACCESS_TOKEN / FB_ACCESS_TOKEN in your .env)."
    )


# ---------------------------------------------------------------------------
# Graph API request wrapper
# ---------------------------------------------------------------------------
class GraphAPIError(RuntimeError):
    def __init__(self, message: str, payload: dict[str, Any] | None = None, status_code: int | None = None):
        super().__init__(message)
        self.payload = payload or {}
        self.status_code = status_code


def graph_request(
    method: str,
    path: str,
    access_token: str,
    params: dict[str, Any] | None = None,
    data: dict[str, Any] | None = None,
    files: dict[str, Any] | None = None,
    timeout: int = 60,
) -> dict[str, Any]:
    """Call `https://graph.facebook.com/{version}/{path}`.

    `path` should NOT include a leading slash or the version prefix —
    e.g. `"me/accounts"` or `"act_123/campaigns"`.

    Returns the parsed JSON body on success. Raises `GraphAPIError` on
    any non-2xx response or a body containing an `error` object.
    """
    url = f"{GRAPH_BASE}/{api_version()}/{path.lstrip('/')}"
    params = dict(params or {})
    if access_token:
        params.setdefault("access_token", access_token)
    headers = {"User-Agent": USER_AGENT}

    method = method.upper()
    if method == "GET":
        resp = requests.get(url, params=params, headers=headers, timeout=timeout)
    elif method == "POST":
        resp = requests.post(url, params=params, data=data, files=files, headers=headers, timeout=timeout)
    elif method == "DELETE":
        resp = requests.delete(url, params=params, headers=headers, timeout=timeout)
    else:
        raise ValueError(f"Unsupported method: {method}")

    try:
        body = resp.json()
    except ValueError:
        body = {"raw": resp.text}

    if isinstance(body, dict) and "error" in body:
        err = body["error"]
        msg = err.get("message", "Unknown Graph API error")
        code = err.get("code")
        subcode = err.get("error_subcode")
        etype = err.get("type")
        fbtrace = err.get("fbtrace_id")
        raise GraphAPIError(
            f"Graph API error ({etype} {code}/{subcode}): {msg} [fbtrace_id={fbtrace}]",
            payload=body,
            status_code=resp.status_code,
        )

    if not resp.ok:
        raise GraphAPIError(f"HTTP {resp.status_code} from Graph API: {resp.text[:500]}", payload=body, status_code=resp.status_code)

    return body


def epoch_from_iso(iso_str: str) -> int:
    """Parse an ISO-8601 timestamp (e.g. '2026-09-01T15:00:00' or with a
    trailing 'Z'/offset) into a unix epoch int, as Graph API scheduling
    fields expect."""
    s = iso_str.strip()
    if s.endswith("Z"):
        s = s[:-1] + "+00:00"
    dt = datetime.fromisoformat(s)
    if dt.tzinfo is None:
        dt = dt.replace(tzinfo=timezone.utc)
    return int(dt.timestamp())


def now_epoch() -> int:
    return int(time.time())
