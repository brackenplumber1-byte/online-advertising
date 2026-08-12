"""
Broken Link Checker — find dead outbound links on a resource/links page.

Usage
-----
    python3 check_broken_links.py <page-url> [--niche "keyword phrase"]

What it does
------------
1. Fetches <page-url> and parses every outbound <a href> link.
2. Sends a HEAD request to each one (falling back to GET if HEAD isn't
   allowed) and records which ones are dead (404/410/timeout/DNS
   failure/connection refused).
3. If --niche is given, flags dead links whose anchor text or
   surrounding paragraph mentions that keyword — these are the ones
   worth pitching a replacement resource for.

Output is one JSON object per line (JSONL) to stdout, one per broken
link found, so results can be piped into other tools or read back by
Claude a chunk at a time.

Why HEAD-first?  Fetching full bodies for every link on a page with 50+
links is slow and wasteful; HEAD is enough to see the status code, and
we only fall back to GET when a server rejects HEAD outright.
"""

from __future__ import annotations

import argparse
import json
import sys
from concurrent.futures import ThreadPoolExecutor, as_completed
from urllib.parse import urljoin, urlparse

import requests
from bs4 import BeautifulSoup

TIMEOUT_S = 10
MAX_WORKERS = 20
USER_AGENT = (
    "Mozilla/5.0 (compatible; off-page-seo-link-checker/1.0; "
    "+https://github.com/brackenplumber1-byte/online-advertising)"
)


def _check_one(url: str) -> tuple[int | None, str]:
    """Return (status_code, error) for a single URL. status_code is None on failure."""
    headers = {"User-Agent": USER_AGENT}
    try:
        r = requests.head(url, headers=headers, timeout=TIMEOUT_S, allow_redirects=True)
        if r.status_code == 405:  # method not allowed — some servers reject HEAD
            r = requests.get(url, headers=headers, timeout=TIMEOUT_S, allow_redirects=True, stream=True)
        return r.status_code, ""
    except requests.exceptions.RequestException as e:
        return None, str(e)


def find_broken_links(page_url: str, niche: str | None = None, max_links: int = 300) -> list[dict]:
    headers = {"User-Agent": USER_AGENT}
    resp = requests.get(page_url, headers=headers, timeout=TIMEOUT_S)
    resp.raise_for_status()
    soup = BeautifulSoup(resp.text, "html.parser")

    page_host = urlparse(page_url).netloc
    seen: set[str] = set()
    candidates: dict[str, dict] = {}

    for a in soup.find_all("a", href=True):
        if len(candidates) >= max_links:
            break
        href = a["href"].strip()
        if not href or href.startswith(("#", "mailto:", "tel:", "javascript:")):
            continue
        target = urljoin(page_url, href)
        if urlparse(target).netloc == page_host:
            continue  # only care about outbound links — that's what gets replaced
        if target in seen:
            continue
        seen.add(target)

        anchor_text = a.get_text(strip=True)
        context = ""
        parent = a.find_parent(["li", "p", "td"])
        if parent is not None:
            context = parent.get_text(" ", strip=True)[:300]

        candidates[target] = {"anchor_text": anchor_text, "context": context}

    results = []
    with ThreadPoolExecutor(max_workers=MAX_WORKERS) as pool:
        future_to_url = {pool.submit(_check_one, url): url for url in candidates}
        for future in as_completed(future_to_url):
            target = future_to_url[future]
            status, error = future.result()
            is_broken = status is None or status >= 400
            if not is_broken:
                continue

            anchor_text = candidates[target]["anchor_text"]
            context = candidates[target]["context"]

            matches_niche = True
            if niche:
                haystack = f"{anchor_text} {context}".lower()
                matches_niche = niche.lower() in haystack

            # 404/410/DNS-failure/timeout mean the resource is actually gone.
            # Other 4xx/5xx (403, 429, 5xx) are frequently anti-bot blocking or
            # rate-limiting rather than a real dead link — flag as low
            # confidence so a pitch never claims "your link is broken" based
            # on a false positive.
            high_confidence = status is None or status in (404, 410)

            results.append(
                {
                    "source_page": page_url,
                    "broken_url": target,
                    "anchor_text": anchor_text,
                    "context": context,
                    "status_code": status,
                    "error": error,
                    "matches_niche": matches_niche,
                    "confidence": "high" if high_confidence else "low_verify_manually",
                }
            )

    return results


def main() -> int:
    parser = argparse.ArgumentParser(description=__doc__)
    parser.add_argument("page_url", help="URL of the resource/links page to scan")
    parser.add_argument(
        "--niche",
        default=None,
        help="Optional keyword to flag broken links relevant to your topic",
    )
    args = parser.parse_args()

    try:
        results = find_broken_links(args.page_url, args.niche)
    except requests.exceptions.RequestException as e:
        print(json.dumps({"status": "error", "error": f"could not fetch page: {e}"}))
        return 1

    if not results:
        print(json.dumps({"status": "ok", "broken_links_found": 0}))
        return 0

    for row in results:
        print(json.dumps(row))
    print(json.dumps({"status": "ok", "broken_links_found": len(results)}), file=sys.stderr)
    return 0


if __name__ == "__main__":
    raise SystemExit(main())
