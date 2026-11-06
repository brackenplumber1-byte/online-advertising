# tysonsplumbersroodepoort — Rank/Indexing Tracking

**GSC-based only — no Ubersuggest project** (explicit user decision,
2026-10-07, to avoid using up the account's limited Ubersuggest project
slots on a site this early in recovery).

## The 2026-10-07 fix this tracker exists to measure

Found and fixed the primary cause of this site's near-total lack of
organic presence (DA 2, ~0 search traffic for months, only a handful of
keywords ranking at position 24+): the SiteSEO plugin's sitemap was
**only including the homepage and 1 blog post** — the `tp_area` (75
suburb pages) and `tp_service` (16 service pages) custom post types were
never toggled on in SiteSEO → Sitemaps → Post Types. Confirmed live in
Search Console itself: `/sitemap.xml` had been fetched successfully for
months but only ever found 3 pages total.

Fixed 2026-10-07: enabled both post types in SiteSEO, confirmed
`tp_area-sitemap1.xml` (76 URLs) and `tp_service-sitemap1.xml` (16 URLs)
now exist and are listed in the sitemap index, and resubmitted
`sitemaps.xml` in Search Console under the correct property.

This is a crawl-discovery fix, not a content fix — the 75 area pages
were already live and had already been through a separate round of
fixes (fake-review removal, crc32 phrase-rotation de-duplication, 6
redirect fixes via .htaccess) in an earlier session. The content should
already be reasonable; it just was never being told to Google.

## Update, 2026-11-06: indexing is already recovered

The 2026-11-06 GSC Coverage export showed indexed count had jumped from
2 to 81 on **2026-09-05** — a full month before the sitemap fix above —
and had climbed to 84 and held flat there since 2026-09-22 (17
not-indexed, matching the Critical issues breakdown exactly). So the
2026-10-07 sitemap fix documented above is NOT what caused this jump;
something else (an earlier partial fix, or Google crawling via internal
links independent of the sitemap) already got the site indexed by early
September. Indexing is no longer the open question for this site — it's
recovered and stable at 84/101 known pages.

## What "success" looks like here, now

The indexing signal is resolved (see above) — the open question now is
**ranking and traffic**, not indexing. Despite 84 pages being indexed,
Ubersuggest's ad-hoc `domain_overview` still shows DA 2, ~5/mo traffic,
and no tracked keywords above position ~24. Watch whether
`domainTraffic`/organic traffic starts moving off near-zero, and whether
any keyword breaks into the top 20-30 — that's the real next milestone,
not the indexed-page count.

## Monthly check process

1. Ask the user for a fresh Search Console Coverage export for
   tysonsplumbersroodepoort.co.za (Indexing → Pages → Export), same as
   done for the other sites' Coverage audits.
2. Compare the Indexed vs Not-indexed counts against the previous
   monthly-log.csv row.
3. Optionally, run an ad-hoc `mcp__Ubersuggest__domain_overview` lookup
   (NOT `create_project` — do not create a tracked project for this
   site) to check whether traffic/organicKeywords have moved off zero.
4. Append a row to monthly-log.csv, commit, push.
5. Give an honest, calibrated read. Indexing recovered already (see
   above) — the thing to watch now is whether traffic/rankings move off
   their still-near-zero baseline, not the indexed-page count.

## monthly-log.csv columns

| Column | Meaning |
|---|---|
| `date` | Date of the check |
| `indexed_pages` | Indexed count from GSC Coverage (manual export) |
| `not_indexed_pages` | Not-indexed count from GSC Coverage |
| `organic_traffic` | Ad-hoc Ubersuggest domain_overview traffic figure, if checked |
| `notes` | Context — what changed, any new issues found |
