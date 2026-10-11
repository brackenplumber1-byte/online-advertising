# 247renovations — Keyword Rank Tracking

## Source of truth

**GSC-based only — no Ubersuggest project.** Ubersuggest's own domain_overview
for this site is unreliable (shows DA 1, 0 backlinks, 0 traffic every month —
flatly contradicted by real GSC data showing thousands of monthly
impressions). Don't trust Ubersuggest's traffic/backlink numbers for this
site without cross-checking GSC; its own site-level crawl just hasn't caught
up. Monthly checks need a fresh GSC Performance export (last 3 months,
Queries + Pages tabs) from the user — no API credentials configured for this
site this session.

## Context (baseline, GSC export dated 2026-10-11, covering 2026-07-14 to
2026-10-11)

First real look at this site — it had never been audited or tracked before
this date. Found via WordPress REST + GSC export:

- **Technical setup is solid**: AIOSEO sitemap properly configured and
  submitted (42 `rn_area` pages, 13 `rn_service` pages), robots.txt correct,
  site reachable. Not a tysons-style sitemap bug.
- **Content quality is solid**: spot-checked the Roodepoort area page —
  232 words, specific and locally-framed (not templated boilerplate), reads
  comparably to the better pages on the other 4 sites.
- **Zero blog content**: 0 posts, 1 category (Uncategorized only). No
  content-calendar infrastructure exists yet for this site.
- **The real bottleneck is authority, not content**: Domain Authority 1,
  literally 0 backlinks / 0 referring domains per Ubersuggest — consistent
  with a young site (oldest area pages dated 2026-07-18, so ~3 months old
  as of this baseline) that hasn't built any off-page signal yet.
- **Real GSC numbers** (contradicts Ubersuggest's "0 traffic" picture):
  4,864 impressions and 55 clicks over the 3-month window, avg. position
  ~38.6 — real search demand reaching the site, but ranking too low on most
  queries to convert into clicks. Mobile outranks desktop significantly
  (avg. position 20.5 vs 42.6) on the same query set — worth re-checking in
  future exports to see if this is a persistent pattern or just low-sample
  noise.
  - Best-performing page: `/services/garage-conversions/` — 11 clicks, 347
    impressions, position 19.11 (closest to page 1).
  - Highest-volume page: homepage — 1,489 impressions but position 57 (page
    6), barely converts.
  - `/areas/renovations-roodepoort/` — 1,304 impressions, position 33.9.
  - `/areas/renovations-fourways/` — 399 impressions, position 21.9 (best
    positioned area page).
  - Top query "renovations" — 665 impressions, 0 clicks, position 65.3
    (essentially invisible despite real search volume).

## Recommendation (not yet actioned)

Given solid content + solid technical setup + zero backlinks, off-page SEO
(the `off-page-seo` or `qwoted-seo-backlinks` skills) is likely the
highest-leverage next step for this site specifically — more promising than
further content work. Flagged to the user 2026-10-11, not yet started.

## Monthly check process

Same process as the other sites — ask the user for a fresh 3-month GSC
Performance export (Queries + Pages tabs at minimum), compare against the
baseline above and the prior month's row, and give an honest read. Don't
inflate small movements this site's low absolute numbers make statistically
noisy (e.g. a handful of clicks moving a tracked page's position by 5-10
isn't necessarily meaningful yet).

## monthly-log.csv columns

| Column | Meaning |
|---|---|
| `date` | Date of the check |
| `impressions_3mo` | Total impressions, trailing 3-month window from the export |
| `clicks_3mo` | Total clicks, same window |
| `avg_position` | Site-wide average position, same window |
| `notes` | Movement, new content indexed, backlink/authority changes |
