# Backlink Spam Monitoring

Tracks confirmed spam/toxic backlinks across all 5 sites in this
portfolio and the disavow files sent to the user for each, so monthly
checks build on real history instead of re-discovering (or re-asking
the user to disavow) the same domains every time.

## Why this exists

247plumbersgp, brackendownsplumber, mondeorplumbingservices and
tysonsplumbersroodepoort have all been hit at different points by the
same disposable-domain PBN link-selling network: identical templated
pages (title "Boost your Google rankings with Premium PBN & Link
Building", anchor text literally reading "buy backlinks online
cheap") that embed a link to the target site as fake social proof of
the spam service's own reach. It is not a targeted attack on any one
business — it's an automated operation sweeping up many unrelated
sites, and a site's turn comes up at random. New domains appear
constantly as old ones get abandoned, so this needs an ongoing check,
not a one-time cleanup.

247renovations had zero backlinks at its 2026-10-11 baseline, so
nothing to check yet, but should be swept into the same monthly
process from here on.

## Sites

| Slug | Domain |
|---|---|
| `247plumbersgp` | 247plumbersgp.co.za |
| `brackendownsplumber` | brackendownsplumber.co.za |
| `mondeorplumbingservices` | mondeorplumbingservices.co.za |
| `tysonsplumbersroodepoort` | tysonsplumbersroodepoort.co.za |
| `247renovations` | 247renovations.co.za |

## Monthly check process

1. For each site, call `mcp__Ubersuggest__backlinks_overview` (quick
   sanity check of total/DA movement) then `mcp__Ubersuggest__backlinks`
   with `limit` ~40-60, paginating via `offset` if the first page is
   full, to pull the current backlink list. No Ubersuggest *project*
   is needed for this — `backlinks`/`backlinks_overview` work directly
   off the domain, so this works even for tysons/247renovations which
   don't have (and shouldn't get) a tracked project.
2. Read `sites/<slug>/disavowed-domains.txt` for that site's running
   list of already-disavowed domains.
3. For every backlink NOT already in that list, check whether it
   matches the known spam signature (title/anchor containing "PBN",
   "Premium... Link Building", "buy backlinks", or a near-identical
   templated page — the URL pattern is usually `/all/<n>/<n>.html`)
   or shows other clear spam signals (high `spam_score`, an unrelated-
   niche disposable-looking domain). Use judgment, not a mechanical
   rule — don't disavow a genuine, if low-quality, directory or
   citation link. If a new, different-looking spam pattern shows up,
   verify it independently (fetch the page) before treating it as
   confirmed, the same way the PBN network was first confirmed.
4. If new spam domains are found: write an updated disavow file (the
   full cumulative list — old + new — one `domain:` line per domain,
   with a short comment header), append the new domains to
   `disavowed-domains.txt`, send the file to the user via
   `SendUserFile`, and append a row to `monthly-log.csv`.
5. If nothing new is found: say so plainly in the summary and log a
   `new_spam_domains_found,0` row — don't manufacture findings to seem
   useful.
6. Commit and push the updated `disavowed-domains.txt` and
   `monthly-log.csv` for each site touched.
7. Give ONE consolidated, honest summary across all 5 sites in the
   reply — not five separate verbose reports. Calibrate: this spam
   pattern generally doesn't do real ranking damage (Google's own spam
   systems already discount it), disavowing is about profile
   cleanliness, not emergency response. Don't frame routine findings
   as a "crisis."

## monthly-log.csv columns

| Column | Meaning |
|---|---|
| `date` | Date of the check |
| `new_spam_domains_found` | Count of domains newly added to the disavow list this check |
| `total_disavowed` | Running total of domains ever disavowed for this site |
| `action` | `disavow_sent` (new file sent) or `no_action` (nothing new found) |
| `notes` | What was found, anything unusual, false positives avoided |

## disavowed-domains.txt format

One domain per line, no `domain:` prefix (that's added when building
the actual Search Console disavow file) — this is the plain running
list this project's own tooling reads back each month. Comment lines
(`#`) are fine for context but keep the domain lines clean for easy
diffing.
