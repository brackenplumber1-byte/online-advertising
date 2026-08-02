---
name: off-page-seo
description: |
  Build local citations (consistent NAP listings on business
  directories) and pursue general backlink outreach (non-journalist
  sites — local blogs, suppliers, community/industry sites) to improve
  local search rankings and domain authority. Manages multiple
  businesses via per-site tracking (see ../SITES.md). Use this whenever
  the user asks for "citation building", "directory listings", "get us
  listed on [directory]", "backlinks" outside of a journalist/PR
  context, "local SEO", or "link building" that isn't about pitching
  journalists (for that, use the existing qwoted-seo-backlinks skill
  instead).
---

# Off-Page SEO: Citations & Outreach Link Building

This skill manages **multiple businesses** — see `../SITES.md` for the
full list and slugs. All tracking files below live under a per-business
subdirectory (`sites/<slug>/`) — confirm which business before reading
or writing one if it isn't already obvious from context. NAP details
(name/address/phone) are different per business and must never be
mixed up between them.

Two related but distinct workflows live here:

1. **Citation building** — getting the business listed consistently on
   business directories (NAP: Name, Address, Phone). This is mostly
   about *consistency and coverage*, not persuasion.
2. **Outreach link building** — asking real sites (local blogs,
   suppliers, community organizations, industry sites) for a genuine
   link or mention. This is about *relevance and a real reason to
   link*, not volume.

For pitching **journalists** specifically (HARO-style PR requests),
use the existing `qwoted-seo-backlinks` skill instead — it already
covers that whole flow including the sourced-statistics-page tactic,
which is also a great asset to reference in outreach emails from this
skill.

---

## Operating rules — read first

1. **NAP must be byte-for-byte identical everywhere.** Pick one
   canonical form of the business name, address, and phone number
   (matching Google Business Profile exactly) and use that exact
   string on every directory. Inconsistency (e.g. "Bracken Downs
   Plumber" vs "Bracken Downs Plumbing Services", "Bracken Downs" vs
   "Bracken Dale") actively hurts local rank — it's not a cosmetic
   detail.
2. **Quality and relevance over volume.** 15-20 real, relevant
   citations beat 100 low-quality/irrelevant ones. For outreach links,
   one link from a genuinely relevant local site is worth more than
   ten from generic "add your link here" pages — those often carry
   `nofollow` or no SEO value at all and can look spammy in aggregate.
3. **Never use link schemes, PBNs, paid link networks, or reciprocal
   link-exchange schemes.** These violate Google's webmaster
   guidelines and risk a manual action against the whole domain — the
   downside (losing rankings entirely) far outweighs any upside from a
   few extra links. If a "SEO backlink package" or directory looks like
   this, skip it and say why.
4. **Every outreach email is written for one specific recipient.** No
   mail-merge-obvious templates ("Dear Sir/Madam, I noticed your
   website..."). Read the actual site/page you're asking to be linked
   from and reference something specific about it.
5. **Track everything** — which directories are done, which outreach
   emails went out and to whom, and what came back. Without a log,
   this work is invisible and easy to let lapse or accidentally
   duplicate.
6. **Never fabricate reviews, testimonials, or claims** to include in
   a directory listing or outreach email.

---

## Part 1 — Citation building

### Canonical NAP

Before starting, confirm the exact canonical form with the user (name,
full address, phone number, website URL, business category, and a
2-3 sentence description) — write it down once and reuse it verbatim.

### Directories to prioritize (South Africa)

| Directory | Notes |
|---|---|
| Google Business Profile | Foundation — should already exist and be verified before anything else |
| Bing Places for Business | Free, quick, often overlooked |
| Brabys | Long-standing SA business directory |
| Yalwa South Africa | |
| Hotfrog South Africa | |
| Cylex South Africa | |
| Yellosa (SA Yellow Pages) | |
| HelloPeter | Primarily a review platform, but functions as a trust/citation signal too — worth claiming the listing even before actively soliciting reviews |
| Facebook Page | Counts as a citation source in addition to being a social channel |

This list covers the well-established general SA directories. Search
for plumbing/trade-specific and hyperlocal directories too (e.g.
"plumber directory South Africa", "[nearby suburb/town] business
directory") — verify each one is a real, active site with actual
traffic before spending time on it, not an abandoned/spammy listing
farm.

### Tracking

Keep `./sites/<slug>/citations.csv`:

```
directory,url,status,date_submitted,listing_url,notes
Google Business Profile,https://business.google.com,live,2026-01-15,https://g.page/...,already existed
Brabys,https://www.brabys.com,submitted,2026-08-01,,awaiting approval
```

`status`: `planned` → `submitted` → `live` (or `rejected`/`duplicate`
with notes).

### Workflow

1. Confirm canonical NAP + description with the user once.
2. Work through the directory list, submitting each with the exact
   canonical NAP. Many require manual form-fill (no API) — this is
   inherently a slower, more manual workflow than social posting.
3. Log each submission immediately, including the listing URL once
   live so it can be checked/updated later.
4. Periodically re-check `submitted` entries for approval and update
   status.

---

## Part 2 — Outreach link building

### Finding real link targets

Look for sites with a genuine, specific reason to link — not just
"has a website":

- Local blogs/news sites covering Bracken Downs / the broader service
  area
- Hardware/plumbing suppliers who list installer/contractor partners
- Local community organizations, HOAs, or neighborhood associations
  with a "local services" or "recommended providers" page
- Industry associations (e.g. plumbing trade bodies) with a member
  directory
- Home-improvement or property-management blogs that might want a
  guest post or expert-quote contribution
- Any site that already links to a *competitor* in a similar
  "recommended local services" context — a strong signal they'll link
  to a similar business too

Use web search for things like `"recommended plumbers" Bracken Downs`,
`"local services" site:*.co.za`, `plumbing suppliers Bracken Downs
"our installers"` to surface these.

### Drafting the outreach

Keep it short (3-6 sentences), specific to the recipient, and honest
about the ask:

```
Subject: Bracken Downs plumbing services — quick question

Hi [Name],

I came across your [specific page/post] on [Site] — [one genuine,
specific observation about it]. We're Bracken Downs Plumber, based
right in the area, and wondered whether you'd be open to adding us to
[the specific page/list you found] — happy to reciprocate with a
mention if that's useful for you too.

Either way, thanks for putting together a useful resource for the
area.

[Name]
Bracken Downs Plumber
brackendownsplumber.co.za
```

If a sourced statistics page exists (see `qwoted-seo-backlinks` skill's
Stage 3), it's a strong thing to offer instead of/alongside a plain ask
— "we put together a page on [local plumbing/home-maintenance topic]
with real data, happy to have you link to that if it's useful" is a
much stronger pitch than a bare request.

### Tracking

Keep `./sites/<slug>/outreach_log.csv`:

```
date,site,contact,topic,status,notes
2026-08-01,localnews.co.za,editor@...,recommended-services-page,sent,
2026-08-10,localnews.co.za,editor@...,recommended-services-page,linked,added to their list on 2026-08-09
```

`status`: `planned` → `sent` → `linked` / `declined` / `no-response`.

---

## Reporting

When asked for a status update, summarize from both CSVs: citations
live vs. pending, outreach sent vs. resulted in a link, and a short
recommendation for what to prioritize next (e.g. "3 directories still
pending approval, worth a follow-up on the 2 outreach emails from 3+
weeks ago with no response").
