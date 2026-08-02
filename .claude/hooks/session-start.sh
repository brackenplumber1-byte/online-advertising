#!/bin/bash
set -euo pipefail

# Install dependencies for the qwoted-seo-backlinks skill so its scripts
# (and playwright-driven browser automation) are ready to run in the session.
QWOTED_SKILL_DIR="$CLAUDE_PROJECT_DIR/.claude/skills/qwoted-seo-backlinks"

if [ -f "$QWOTED_SKILL_DIR/requirements.txt" ]; then
  pip3 install --quiet -r "$QWOTED_SKILL_DIR/requirements.txt"
  # Best-effort: a Chromium build may already be provided by the
  # environment (e.g. via PLAYWRIGHT_BROWSERS_PATH). Don't fail session
  # start if the download is unavailable (e.g. restricted network).
  python3 -m playwright install chromium || true
fi
