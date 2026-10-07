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

## What "success" looks like here

Since there's no automated position tracking for this site, the signal
to watch is simple: **does the indexed-page count in GSC's Coverage
report start climbing from near-zero?** That's the whole story. A
secondary signal: does `domainTraffic`/organic traffic in an ad-hoc
Ubersuggest `domain_overview` lookup (not a tracked project — a one-off
query doesn't cost a project slot) start moving off zero?

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
5. Give an honest, calibrated read — this is a slow recovery situation,
   not a quick-win one. A jump from 3 indexed pages to 20-30 over the
   first month would already be a strong result; don't expect the full
   92 pages to index immediately.

## monthly-log.csv columns

| Column | Meaning |
|---|---|
| `date` | Date of the check |
| `indexed_pages` | Indexed count from GSC Coverage (manual export) |
| `not_indexed_pages` | Not-indexed count from GSC Coverage |
| `organic_traffic` | Ad-hoc Ubersuggest domain_overview traffic figure, if checked |
| `notes` | Context — what changed, any new issues found |
