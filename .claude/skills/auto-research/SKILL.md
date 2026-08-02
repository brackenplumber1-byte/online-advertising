---
name: auto-research
description: |
  Research a topic or question across the web and produce a structured,
  cited written report — not just a quick answer. Use this whenever the
  user asks to "research X", "look into X for me", "write me a report on
  X", "do a deep dive on X", "compile everything on X", "what's the
  current state of X", or wants a written summary of a topic backed by
  sources rather than a single conversational reply. Best for questions
  that need multiple searches, several sources, and synthesis — not for
  a single fact lookup that one search already answers.
---

# Auto Research

Your job is to turn a topic or question into a structured report: search
the web from several angles, read enough of what you find to actually
understand it, and write up findings with every non-obvious claim traced
back to a source. The output is a document the user can hand to someone
else, not a chat reply that evaporates.

---

## Operating rules — read first

1. **Scope it before searching.** If the request is broad or ambiguous
   ("research AI in advertising"), spend one turn clarifying: what's the
   angle (market sizing? competitor landscape? technical how-it-works?),
   who's it for, how deep, any time bound (e.g. "last 12 months only").
   Skip this only when the request is already specific and well-scoped.
2. **Search from multiple angles, not one query repeated.** A single
   topic usually needs several distinct searches — the general overview,
   specific sub-questions, counter-evidence/skeptical takes, and recent-
   news framing all surface different sources. Reusing one query with
   minor rewording just re-fetches the same top results.
3. **Every non-obvious claim needs a traceable source.** If you can't
   point to a specific search result or fetched page for a number, a
   quote, or a specific claim, either don't include it or flag it
   explicitly as unverified. Never fabricate a statistic or a citation —
   a single invented number caught by the user destroys trust in the
   entire report.
4. **Note recency and disagreement.** If sources conflict, say so and
   give both, rather than silently picking one. If a source is old
   relative to a fast-moving topic, flag that its numbers may be stale.
5. **Read enough to synthesize, not just enough to skim titles.** Search
   results alone (title + snippet) are rarely enough to write a good
   section — fetch the pages that matter and actually read them before
   writing about them.
6. **For genuinely large topics, parallelize with subagents** (if
   available) — split into sub-questions, spawn one research agent per
   sub-question, then synthesize their findings yourself rather than
   duplicating their searches inline. Don't do this for a scoped,
   single-angle question; it's overhead there.

---

## Workflow

### 1. Scope

Confirm (briefly, don't over-ask): the core question, intended audience/
use, desired depth (quick brief vs. thorough report), and any constraints
(date range, geography, must include/exclude certain sources).

### 2. Search

Run several searches covering different facets of the topic. A rough
pattern that works for most topics:

- Broad orientation query (what is this, who are the players)
- 2-4 specific sub-question queries (the parts that actually matter for
  the user's stated angle)
- A skeptical/counter-evidence query (`"X" criticism`, `"X" problems`,
  `"X" limitations`) — reports that only surface the positive case are
  less useful and less trustworthy
- A recency query if the topic moves fast (`"X" 2026`, `"X" latest`)

### 3. Read

Fetch the pages that actually look substantive (not just aggregator
listicles) and read them properly. Prefer primary sources (the company's
own numbers, the original study, the official docs) over secondary
summaries when both are available.

### 4. Synthesize and write

Use this structure by default (adapt headings to the topic, but keep the
shape — skip sections that don't apply rather than padding them):

```markdown
# <Topic>

## Summary
2-4 sentences: the headline answer, up front.

## Key findings
Bulleted or numbered — the substantive points, each with an inline
citation, e.g.: "Ad spend on retail media grew 24% YoY in 2025
([source](https://...))."

## <Thematic sections as needed>
Organized by sub-topic, not by which search produced them. Prose or
tables as fits the content.

## Points of disagreement / uncertainty
Anywhere sources conflicted, or a claim you couldn't fully verify.

## Sources
Numbered list of every URL cited above, with the publisher/title.
```

Cite inline as `[Title or Publisher](URL)` so the source is visible
without a footnote round-trip. Every URL that appears in "Sources" must
have been actually fetched or returned by a search — never list a source
you didn't really consult.

### 5. Deliver

For a short brief, the chat reply itself is often enough. For a longer
report, or if the user will want to share/reread it, write it to a file
(markdown) or offer to render it as an artifact — ask if unsure which
the user wants.

---

## Calibrating depth

| Signal | Depth |
|---|---|
| "quick", "just tell me", single specific fact | Skip this skill — answer directly with 1 search if needed |
| "research", "look into", "report", "deep dive", no qualifier | Standard: ~5-8 searches, 3-6 pages actually read, full structure above |
| "comprehensive", "everything on", "thorough", explicit long report | Extended: subagent fan-out per sub-topic, more sources, longer synthesis |

---

## Things to avoid

- Don't present a single source's framing as settled fact when other
  sources disagree.
- Don't pad the report with restated search snippets — synthesize in
  your own words; copy exact quotes only when the wording itself
  matters (a definition, a direct quote from a named person).
- Don't cite a source for a claim it doesn't actually support — re-check
  before citing, don't attach citations by vibes.
- Don't let the report balloon past what the user's stated depth calls
  for — a "quick brief" bloated into a 3000-word report is not a better
  answer, it's a slower one.
