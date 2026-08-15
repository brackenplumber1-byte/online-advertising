"""
Qwoted Export Session — fallback for when qwoted_login.py's URL-based
login detection doesn't work (e.g. an SSO/popup sign-in flow that never
actually changes the main tab's URL away from /users/sign_in).

You've already signed in successfully at least once via
`python3 qwoted_login.py` — Playwright's persistent Chromium profile at
`~/.qwoted/chromium-profile/` already has the real session cookies on
disk, even though the login script's own detection never noticed and
timed out. This script just re-opens that same profile, exports
whatever cookies are sitting in it to storage_state.json, and verifies
they actually work against the Qwoted API. No new sign-in needed.

Usage:
    python3 qwoted_export_session.py
"""
from __future__ import annotations

import sys
from pathlib import Path

from qwoted_common import qwoted_home, session_file, log, result_line, fetch_session_context


def _import_playwright():
    try:
        from playwright.sync_api import sync_playwright
    except ImportError:
        print(
            "Playwright not installed. Run: pip install -r requirements.txt",
            file=sys.stderr,
        )
        sys.exit(1)
    return sync_playwright


def main() -> int:
    profile_dir = qwoted_home() / "chromium-profile"
    if not profile_dir.exists():
        print(
            f"No Chromium profile found at {profile_dir}. "
            "Run qwoted_login.py first and sign in at least once before using this script.",
            file=sys.stderr,
        )
        return 1

    sync_playwright = _import_playwright()

    preinstalled_chromium = Path("/opt/pw-browsers/chromium")
    launch_kwargs = dict(
        user_data_dir=str(profile_dir),
        headless=True,
        args=["--no-first-run", "--no-default-browser-check"],
    )
    if preinstalled_chromium.exists():
        launch_kwargs["executable_path"] = str(preinstalled_chromium)

    log(f"opening existing profile at {profile_dir} (headless, just exporting cookies)")
    with sync_playwright() as pw:
        ctx = pw.chromium.launch_persistent_context(**launch_kwargs)
        out_path = session_file()
        out_path.parent.mkdir(parents=True, exist_ok=True)
        ctx.storage_state(path=str(out_path))
        ctx.close()

    log(f"exported cookies to {out_path} — verifying against the Qwoted API...")

    try:
        ctxinfo = fetch_session_context()
    except PermissionError as e:
        print(
            f"ERROR: exported cookies but they don't work: {e}\n"
            "This means the browser profile itself doesn't have a valid session either — "
            "you'll need to run qwoted_login.py again and actually complete sign-in "
            "(check you're not stuck on an MFA/captcha step).",
            file=sys.stderr,
        )
        return 1

    result_line({
        "status": "logged_in",
        "cookie_jar": str(out_path),
        "user_id": ctxinfo.get("user_id"),
        "user_slug": ctxinfo.get("user_slug"),
    })
    return 0


if __name__ == "__main__":
    sys.exit(main())
