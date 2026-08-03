"""
Contact Email Finder — best-effort discovery of a public contact email
for a target domain, without guessing or fabricating anything.

Usage
-----
    python3 find_contact_email.py <domain-or-url>

What it does
------------
Fetches the homepage plus a handful of common contact-style paths
(/contact, /contact-us, /about, /about-us, /write-for-us), and pulls
out every `mailto:` link and email-shaped string found in the raw HTML.
Only returns what's actually published on the site — if nothing is
found, it says so. Never invents an address like `info@domain.com`
that wasn't actually seen on the page.

Output: one JSON object to stdout:
    {"domain": ..., "emails": [...], "source_pages": [...]}
"""

from __future__ import annotations

import argparse
import json
import re
import sys
from urllib.parse import urljoin, urlparse

import requests

TIMEOUT_S = 10
USER_AGENT = (
    "Mozilla/5.0 (compatible; off-page-seo-contact-finder/1.0; "
    "+https://github.com/brackenplumber1-byte/online-advertising)"
)

CANDIDATE_PATHS = [
    "",
    "/contact",
    "/contact-us",
    "/about",
    "/about-us",
    "/write-for-us",
]

EMAIL_RE = re.compile(r"[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}")
IGNORE_DOMAINS = {"sentry.io", "example.com", "domain.com", "yourdomain.com", "wixpress.com"}


def _normalize(domain_or_url: str) -> str:
    if not domain_or_url.startswith(("http://", "https://")):
        return f"https://{domain_or_url}"
    return domain_or_url


def find_contact_emails(domain_or_url: str) -> dict:
    base = _normalize(domain_or_url).rstrip("/")
    headers = {"User-Agent": USER_AGENT}

    emails: set[str] = set()
    source_pages: list[str] = []

    for path in CANDIDATE_PATHS:
        url = urljoin(base + "/", path.lstrip("/"))
        try:
            r = requests.get(url, headers=headers, timeout=TIMEOUT_S)
        except requests.exceptions.RequestException:
            continue
        if r.status_code != 200:
            continue

        found_here = set()
        for m in re.finditer(r'mailto:([^"\'?&\s]+)', r.text, re.IGNORECASE):
            found_here.add(m.group(1).strip())
        for m in EMAIL_RE.finditer(r.text):
            found_here.add(m.group(0))

        found_here = {
            e for e in found_here if urlparse(f"mailto:{e}").path.split("@")[-1].lower() not in IGNORE_DOMAINS
        }

        if found_here:
            emails |= found_here
            source_pages.append(url)

    return {
        "domain": base,
        "emails": sorted(emails),
        "source_pages": source_pages,
    }


def main() -> int:
    parser = argparse.ArgumentParser(description=__doc__)
    parser.add_argument("domain_or_url", help="Target domain or URL, e.g. example.com")
    args = parser.parse_args()

    result = find_contact_emails(args.domain_or_url)
    print(json.dumps(result, indent=2))
    if not result["emails"]:
        print(
            "No published email found — do not guess one. Check the site's "
            "contact form, social profiles, or skip this target.",
            file=sys.stderr,
        )
    return 0


if __name__ == "__main__":
    raise SystemExit(main())
