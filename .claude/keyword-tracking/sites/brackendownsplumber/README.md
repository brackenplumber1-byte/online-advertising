# brackendownsplumber — Keyword Rank Tracking

Tracks progress toward the standing goal: **50+ tracked keywords ranking
on page 1 (position ≤10) each month.**

## Source of truth

Ubersuggest project `e12d95e7f7f14f12371cf168c4a84d734018d398276f14fe15dd77908f8861f0`
(domain: brackendownsplumber.co.za), 75 keywords tracked at loc_id 2710
(East Rand / Gauteng), lang en. Ubersuggest refreshes positions weekly
(`update_freq: WEEKLY`) — pull via `mcp__Ubersuggest__project_position_info`.

GSC Performance exports (user-provided, manual — no API access configured
for this site yet) are used opportunistically as a real-world cross-check
against Ubersuggest's simulated positions, not required every month.

## Monthly check process

1. Call `project_position_info` for the project above, date range = last
   30 days.
2. Count keywords with `new_position.position` between 1 and 10 inclusive
   (null = not ranking, doesn't count).
3. Append a row to `monthly-log.csv` with the date, the count, and which
   specific keywords are newly on/off page 1 vs. the previous entry.
4. If count < 50, flag it clearly and suggest which striking-distance
   keywords (11-20) are closest to crossing over.
5. If count >= 50, confirm the goal is being held, don't over-celebrate —
   report the number plainly.

## monthly-log.csv columns

| Column | Meaning |
|---|---|
| `date` | Date of the check |
| `page1_count` | Keywords at position 1-10 out of 75 tracked |
| `pos1_count` | Of those, how many are at position 1 specifically |
| `tracked_total` | Total keywords tracked that month (grows over time) |
| `notes` | Notable movements — new entries to page 1, drops, new pages added |
