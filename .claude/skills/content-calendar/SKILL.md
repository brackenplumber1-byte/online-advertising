---
name: content-calendar
description: |
  Plan, draft, and track a recurring daily/weekly/monthly content
  cadence across WordPress, Facebook, Instagram, LinkedIn, and Google
  Business Profile — one content pipeline instead of five disconnected
  ones. Manages multiple businesses via a per-site calendar (see
  ../SITES.md). Use this whenever the user asks "what should I post
  today/this week", "plan out this month's content", "we need more
  social posts", "keep up our posting schedule", or wants a consistent,
  ongoing presence across the website and socials rather than a one-off
  post. Hands off actual publishing to the wordpress-publishing and
  social-media-posting skills.
---

# Content Calendar Skill

You're running the content *pipeline* for the business: deciding what
should go out where and when, drafting it in the right format per
channel, and tracking what's been done — not just writing one post when
asked. Actual publishing is handled by other skills
(`wordpress-publishing`, `social-media-posting`); this skill is the
planning and drafting layer that feeds them.

This skill manages **multiple businesses** — see `../SITES.md` for the
full list and slugs. Every calendar file lives under a per-business
subdirectory (`sites/<slug>/calendar.csv`) — confirm which business
before reading or writing one if it isn't already obvious from context.

---

## Operating rules — read first

1. **Check the calendar before drafting anything.** Read
   `./sites/<slug>/calendar.csv` for the business in question (create
   it from `templates/calendar_template.csv` if it doesn't exist yet)
   to see what's already planned, drafted, or published recently. Don't
   re-suggest something posted two weeks ago, and don't duplicate a
   slot that's already filled.
2. **One piece of source material, many formats.** The efficient way to
   run this is: pick one underlying idea/topic per week, then adapt it
   per channel — a long-form WordPress article, a short FB/IG caption
   pulling out one tip, a more professional LinkedIn framing, and a GBP
   post with a clear CTA. Don't treat each channel as needing entirely
   separate ideation every time; that's how posting cadences die from
   burnout.
3. **Show drafts before marking anything "published."** Until the user
   tells you otherwise, draft content and get a quick sign-off before
   handing off to the publishing skills — especially for anything
   public-facing on social/GBP where there's no "unpublish and nobody
   noticed" safety net the way there is with a WordPress draft.
4. **Never fabricate specifics.** No invented customer names, review
   quotes, before/after job details, or statistics. If a post wants a
   real detail (a recent job, a review, a seasonal fact) and you don't
   have it, ask the user for it or write around it generically.
5. **Log everything, including what you decided NOT to post and why**
   — a thin calendar that only shows successes makes it hard to see
   whether the cadence is actually being kept up.

---

## Content pillars for a local plumbing business

Rotate through these rather than defaulting to "generic tip" every
time — variety is both more engaging and covers more search/AI-citation
surface area:

| Pillar | Example | Best channels |
|---|---|---|
| Educational / how-to | "3 signs your geyser is about to fail" | WordPress article, FB/IG carousel, LinkedIn (B2B angle: property managers) |
| Seasonal reminders | Pre-winter geyser servicing, summer garden tap/irrigation checks (remember: Southern Hemisphere seasons) | GBP post, FB/IG, timed WordPress article |
| Behind-the-scenes / job showcase | Before/after photos of a completed job (with customer permission) | Instagram, FB |
| Local community | Sponsorships, local events, service-area shoutouts | FB, GBP |
| Reviews / trust signals | Sharing a real customer review (never fabricated) | GBP, FB, LinkedIn |
| Promotions / availability | Callout availability, seasonal specials | GBP (has a built-in CTA button), FB |
| FAQ | Answering one real recurring customer question per post | WordPress (great for AI/search citation), FB/IG |

---

## Platform formatting cheat sheet

| Channel | Length | Notes |
|---|---|---|
| WordPress article | 500-1200 words | SEO-structured: H2/H3 subheadings, one clear question answered, local service area mentioned, CTA near top and bottom. See `wordpress-publishing` skill. |
| Facebook | 1-3 short paragraphs, or a few punchy lines | Native video/photos outperform links; keep the link (if any) in the first comment rather than the post body if engagement is the goal — but ask the user's preference. |
| Instagram | Caption front-loads the hook in the first line (gets cut off), 3-8 relevant hashtags at the end, not mid-caption | Needs an image/video — flag if none is available yet rather than posting text-only. |
| LinkedIn | More professional register — frame plumbing expertise for property managers, letting agents, small business owners, not just homeowners | Slightly longer is fine (100-200 words); avoid heavy hashtag stuffing (2-3 max). |
| Google Business Profile post | ~1500 char max, front-load the key info in the first 1-2 lines (truncated in search results) | Every GBP post should have a CTA button (Call, Book, Learn more) — check the `social-media-posting` skill's GBP section for the exact API fields. GBP posts are most valuable posted on a steady weekly-ish cadence, not just monthly, since Google favors "freshness." |

---

## The calendar file

Keep state in `./sites/<slug>/calendar.csv`, one per business (create
from `templates/calendar_template.csv` on first use):

```
date,channel,pillar,topic,status,link,notes
2026-08-04,wordpress,educational,"Why your geyser makes a knocking noise",drafted,,awaiting user approval
2026-08-04,facebook,educational,"Same topic - short version",planned,,
2026-08-05,gbp,seasonal,"Book your pre-winter geyser check",planned,,
```

`status` progresses: `planned` → `drafted` → `approved` → `published`
(or `skipped` with a reason in `notes`). Update this file every time you
plan, draft, or hand off content — it's the single source of truth for
"have we actually kept up the cadence."

---

## Workflow

### 1. Check what's due

Read the calendar. Figure out: what's due today/this week that's still
`planned`, what's been sitting `drafted` too long without approval, and
whether the last few weeks show real gaps (missed cadence) worth
flagging to the user.

### 2. Pick a topic (weekly cadence-setting)

Once a week (or when asked to "plan the month"), pick 1-2 core topics
for the week from the content pillars table, checking they haven't
been used recently. Add rows to the calendar for each channel this
topic will feed, status `planned`.

### 3. Draft per channel

Write the channel-specific version of each planned item using the
formatting cheat sheet above. Update `status` to `drafted`.

### 4. Get approval

Show the user the drafts (batched — don't ping them one at a time
throughout the day). Update to `approved` once they sign off.

### 5. Hand off to publish

- WordPress content → invoke the `wordpress-publishing` skill.
- Facebook/Instagram/LinkedIn/GBP → invoke the `social-media-posting`
  skill. If credentials for a given platform aren't configured yet,
  that skill runs in draft-only mode — output the finished copy/image
  plan for the user to post by hand, and still mark it `published`
  (with a note "posted manually by user") once they confirm they did.
- Update the calendar row's `status` to `published` and fill in the
  `link` column once you have a URL (WordPress permalink, GBP post
  isn't linkable the same way — note "posted" instead).

### 6. Automating the cadence itself

If the user wants this to run on a schedule without them having to ask
each day/week (true "daily/weekly/monthly automatic" cadence), this
needs a scheduled trigger set up at the harness level (not something
this skill file can do on its own) — offer to set one up if the
environment supports it, pointing it at a prompt like "run the
content-calendar skill's weekly planning step." Confirm the exact
cadence and channels with the user before creating any recurring
schedule, since it will act without a human prompting it each time.

---

## Monthly rollup

Once a month, summarize for the user: how many pieces went out per
channel vs. planned, which pillars got used, and a short recommendation
for the coming month (e.g. "we haven't posted a customer review in 6
weeks — worth asking a recent happy customer for a quote"). Keep this
short — a paragraph and a small table, not a full report (that's what
the `lead-generation` skill's reporting workflow is for, if the user
wants performance numbers rather than a content-ops summary).
