# brackendownsplumber — Content Calendar

Tracks every blog post published to `brackendownsplumber.co.za`, so future
publishing runs never duplicate a topic already covered.

## Cadence

**2 posts/week, Tuesday and Friday**, via a recurring Routine (trigger)
that fires into a fresh Claude session with standalone instructions. See
the trigger's stored prompt (`list_triggers`/`claude mcp` won't show it —
ask the user or check `mcp__Claude_Code_Remote__list_triggers` from any
session) for the exact publishing process.

## Before writing a new post

1. Read `calendar.csv` — do not write about a topic already covered
   (check `topic_tags`, not just the exact title; e.g. don't write a 3rd
   generic "geyser noise" post just because the exact phrasing differs).
2. Pick from the **topic backlog** below, or a genuinely new angle not
   listed here (log it with a new tag either way).
3. Append a row to `calendar.csv` the moment the post is published —
   don't batch this at the end of a session.

## Topic backlog (untapped as of 2026-08-10)

Pull from this list roughly in order, skipping anything that's since been
covered (check `calendar.csv` first):

- Geyser installation cost & process breakdown (Alberton/East Rand pricing)
- Gas geysers & gas plumbing safety
- Tankless / instant geyser pros and cons
- Water tank (JoJo tank) installation and backup water systems
- Borehole water — pros, cons, and plumbing considerations
- Water pressure booster pumps — when you need one
- Backflow prevention — what it is and why it matters
- Pipe relining vs. full pipe replacement — cost/benefit
- Copper vs. PVC vs. PEX piping — which lasts longer in SA conditions
- Bathroom renovation plumbing checklist (what to sort out before tiling)
- Kitchen plumbing: dishwasher & washing machine installation guide
- Sewer line problems: tree root intrusion signs and fixes
- Water meter reading — how to spot a leak from your bill
- Rainwater harvesting systems — legality, setup, and plumbing tie-in
- Mould from hidden leaks — health risks and what to do
- Insurance claims for water damage — what South African insurers require
  from a plumber's report (ties into geyser/burst-pipe claims content)
- Emergency plumber call-out pricing — what's reasonable vs. a rip-off
- Summer plumbing tips (existing content skews heavily winter/load
  shedding — summer angle is under-covered: pool plumbing, irrigation,
  increased water usage)
- Commercial plumbing beyond grease traps — restaurant/office compliance
- Sectional title / body corporate plumbing responsibilities (who pays
  for what between owner and body corporate)
- New suburb-specific "common problems" posts for any served area not
  yet covered by `functions.php`'s area list (check against existing
  `common-plumbing-problems-in-alberton-homes` post — only one area has
  a dedicated post so far)

## CSV columns

| Column | Meaning |
|---|---|
| `date_published` | Date the post went live |
| `title` | Post title |
| `url` | Live URL |
| `post_id` | WordPress post ID |
| `topic_tags` | Comma-free single tag/category for quick duplicate-checking |
| `status` | `published` (add `draft` if ever queued but not yet live) |
