# 247plumbersgp — Content Calendar

Tracks every blog post published to `247plumbersgp.co.za`, so future
publishing runs never duplicate a topic already covered. Mirrors the same
setup used for `brackendownsplumber` — see that site's README for the
general conventions; this file just tracks 247plumbersgp-specific state.

## Cadence

**2 posts/week, Tuesday and Friday**, via a recurring Routine bound to
this same Claude session (same mechanism as brackendownsplumber's — see
that trigger for the pattern; a matching one exists for this site too).

## Before writing a new post

1. Read `calendar.csv` — do not write about a topic already covered
   (check `topic_tags`, not just exact title wording).
2. Pick from the **topic backlog** below, or a genuinely new angle.
3. Append a row to `calendar.csv` the moment the post is published.

## Topic backlog (untapped as of 2026-08-12)

247plumbersgp serves Midrand/Johannesburg/Pretoria (Gauteng) — keep local
references to that area, not Alberton/East Rand (that's
brackendownsplumber's territory; don't mix the two brands' local copy).

**Gaps versus brackendownsplumber's more mature content set** — these
topics exist on that site but not this one yet, worth porting over with
Midrand/Joburg/Pretoria framing:
- Gutters: "Why Are My Gutters Overflowing?" / "How Often Should Gutters
  Be Cleaned?"
- Grease trap cleaning frequency (commercial angle)
- How water filtration works
- Benefits of a plumbing maintenance contract

**Shared backlog** (same untapped topics as brackendownsplumber, adapt
framing to Midrand/Johannesburg/Pretoria):
- Geyser installation cost & process breakdown
- Gas geysers & gas plumbing safety
- Tankless / instant geyser pros and cons
- Water tank (JoJo tank) installation and backup water systems
- Borehole water — pros, cons, and plumbing considerations
- Water pressure booster pumps — when you need one
- Backflow prevention — what it is and why it matters
- Pipe relining vs. full pipe replacement — cost/benefit
- Copper vs. PVC vs. PEX piping — which lasts longer in SA conditions
- Bathroom renovation plumbing checklist
- Kitchen plumbing: dishwasher & washing machine installation guide
- Sewer line problems: tree root intrusion signs and fixes
- Water meter reading — how to spot a leak from your bill
- Rainwater harvesting systems — legality, setup, plumbing tie-in
- Mould from hidden leaks — health risks and what to do
- Insurance claims for water damage — what SA insurers require from a
  plumber's report (ties into 247plumbersgp's existing stats page —
  https://www.247plumbersgp.co.za/2026/08/09/household-plumbing-emergency-statistics-2026/
  — worth linking internally from new posts where relevant)
- Emergency plumber call-out pricing — what's reasonable vs. a rip-off
- Summer plumbing tips (existing content skews heavily winter/load
  shedding)
- Commercial plumbing beyond grease traps
- Sectional title / body corporate plumbing responsibilities
- New suburb-specific "common problems" posts for other served
  areas beyond Midrand (check functions.php's area list for this theme)
- Johannesburg/Pretoria water crisis angle — non-revenue water, tariff
  hikes (reuse research already compiled for the stats page's audit
  trail at
  .claude/skills/qwoted-seo-backlinks/statistics_pages/household-plumbing-emergency-statistics-2026.research.json
  — same underlying DWS/Johannesburg Water sources apply)

## CSV columns

Same schema as brackendownsplumber/calendar.csv:
`date_published,title,url,post_id,topic_tags,status`
