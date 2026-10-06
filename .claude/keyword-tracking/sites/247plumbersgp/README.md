# 247plumbersgp — Keyword Rank Tracking

**Different situation from brackendownsplumber — read this before assuming
the same 50+ page-1 goal applies here.**

## Why this site is tracked differently

As of 2026-10-06: domain shows DA 55 / 520 backlinks / 253 ref domains
(Ubersuggest) but only ~37 real monthly organic visits and *zero*
keywords in the top 10 outside branded searches ("247 plumbers",
"247 plumbers gp"). Investigated and found the backlink profile is
~246 fake Google Custom-Search-redirect "backlinks" (a 2022-2023
manipulation campaign, now dormant) inflating the DA number — disavow
file generated and sent to the user 2026-10-06, submission in GSC is a
manual step on their end.

The nearest real, organic, non-branded keywords are "plumber midrand"
and "plumbers midrand" at position ~27.7 (page 3). There is currently
no realistic striking-distance cluster (position 11-30) the way
brackendownsplumber has — almost everything sits at position 50-90.

**Standing goal for this site is NOT "50+ page 1 keywords"** — that's
not realistic short-term. The goal here is tracking genuine progress
from a much weaker real starting point: movement of the handful of
real keywords, new keywords entering the top 50, and overall organic
traffic trend (currently declining, 193→~25-37/mo over the past year
per Ubersuggest's domainTraffic history — first priority is reversing
that decline, not hitting an arbitrary page-1 count).

## Source of truth

Ubersuggest project `81e2628622627a82ccab3ce577bf3cdb542116591dfcd45486b60de7be94f50d`
(domain: 247plumbersgp.co.za), ~33 keywords tracked at loc_id 2710 and
1028673 (Midrand-specific). Refreshes weekly.

## Monthly check process

1. Call `project_position_info` for the project above, last 30 days.
2. Report: how many tracked keywords are in the top 10, top 30, and
   not ranking. Note specific movement since last check (both
   directions).
3. Pull `domain_overview` for 247plumbersgp.co.za and note the latest
   `domainTraffic` monthly search-traffic figure — is the year-long
   decline still happening or has it stabilized/reversed?
4. Append a row to `monthly-log.csv`.
5. Give an honest, calibrated read. Don't manufacture a "50+ page 1"
   narrative that doesn't fit this site's real situation.

## monthly-log.csv columns

| Column | Meaning |
|---|---|
| `date` | Date of the check |
| `top10_count` | Tracked keywords at position 1-10 |
| `top30_count` | Tracked keywords at position 1-30 |
| `tracked_total` | Total keywords tracked that month |
| `monthly_organic_traffic` | Latest `domainTraffic` search-traffic figure from Ubersuggest domain_overview |
| `notes` | Movement, new content published, disavow status, anything relevant |
