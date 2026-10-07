# mondeorplumbingservices — Keyword Rank Tracking

## Status: Ubersuggest project not yet created

The account's Ubersuggest plan caps at 2 tracked projects, both already in
use (247plumbersgp, brackendownsplumber). User is upgrading the plan to
add a 3rd slot (as of 2026-10-07). **Once the project exists**, create it
with `mcp__Ubersuggest__create_project`, domain `mondeorplumbingservices.co.za`,
loc_id 2710, lang en, seeded with the ~38 real/striking-distance keywords
already identified from the domain_overview organicKeywords pull on
2026-10-07 (plumbing services near me, plumber near me, plumbing near me,
plumber johannesburg, plumbing business near me, plumbing in johannesburg,
plumbers in johannesburg, plus suburb-specific: plumber mondeor, plumber
kibler park, plumber ormonde, plumber bassonia, geyser repair johannesburg
south, and the rest of the "near me"/emergency variant cluster — see the
create_project call attempted 2026-10-07 for the exact full list). Then
set up the monthly check-in trigger the same way as the other two sites
(cron `0 7 3 * *`, reading this README + monthly-log.csv, calling
project_position_info, appending a row, committing/pushing).

## Context (as of 2026-10-07 baseline)

Real Ubersuggest organic data (not yet a tracked "project", just the
domain_overview snapshot) showed genuinely strong, recovering performance:
- Domain Authority 9, 94 backlinks, 75 ref domains — clean, believable
  profile, no sign of spam inflation.
- Organic traffic jumped from single digits (Jul-Aug 2026) to **442** in
  September 2026 — a real, sharp recovery, not a gradual trend.
- Real rankings, concentrated almost entirely on the homepage: "plumber
  near me" #10 (14,800/mo), "plumbing near me" #10 (14,800/mo),
  "plumbing services near me" #6 (480/mo).

GSC Coverage report (2026-10-07) showed only 15 of ~88 known pages
indexed, 73 not indexed (57 historical 404s, 3 redirects, 13 "crawled —
not indexed"). Of those 13, only 2 were real live pages needing
attention: `/areas/village-main/` and `/services/geyser-repair/` — both
expanded with genuine unique content same day. Also found and fixed:
**all 17 service pages had empty post_content**, relying only on shared
template boilerplate — all 17 rewritten with unique body content
2026-10-07.

## Monthly check process (once the Ubersuggest project exists)

Same process as brackendownsplumber/247plumbersgp — see those READMEs.
Given this site's traffic is still homepage-concentrated, also track
whether the area/service pages start pulling their own weight (check
Performance Pages data periodically, not just keyword positions).

## monthly-log.csv columns

| Column | Meaning |
|---|---|
| `date` | Date of the check |
| `top10_count` | Tracked keywords at position 1-10 |
| `top30_count` | Tracked keywords at position 1-30 |
| `tracked_total` | Total keywords tracked that month |
| `notes` | Movement, new content indexed, traffic trend |
