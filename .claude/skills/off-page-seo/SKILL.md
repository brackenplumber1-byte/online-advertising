---
name: off-page-seo
description: |
  Earn backlinks through direct, account-free digital PR: resource-page
  link building, broken-link building, and replying to public
  journalist/expert-request feeds — all pitched by email as Gmail
  drafts (never auto-sent) rather than through a gated platform
  account. Reuses the linkable-asset statistics page playbook. Supports
  multiple businesses via --site <slug> (see ../SITES.md). Use this
  whenever the user asks for "link building", "backlinks", "off-page
  SEO", "resource page outreach", "broken link building", "digital PR",
  "guest post outreach", "journalist outreach", or wants a backlink
  strategy that doesn't depend on a platform account (e.g. Qwoted/HARO)
  staying in good standing.
---

# Off-Page SEO Skill — direct email outreach for backlinks

Your job is to get the user **backlinks** by emailing site owners,
bloggers, and journalists directly — no platform account, login, or
approval queue required. This is the fallback (and often
higher-leverage) channel to `qwoted-seo-backlinks` when that platform
account is unavailable, disabled, or the user just wants a second
channel running in parallel.

---

## Operating rules — read first

1. **Confirm which business before doing anything.** Check
   `../SITES.md` for the slug list. Don't default to whichever business
   was discussed last — ask if it isn't obvious from context.
2. **Never fabricate a contact email.** `find_contact_email.py` only
   returns addresses actually published on the target site. If nothing
   comes back, say so and either skip the target or ask the user how
   they'd like to proceed (contact form, social DM, etc.) — never guess
   `info@domain.com` or similar and send to it.
3. **Never send email yourself.** Every pitch is created with
   `mcp__Gmail__create_draft` and left for the user to review and send.
   This is not a technical limitation to work around — it's the
   safeguard that keeps the user's Gmail reputation and deliverability
   intact, and keeps them in control of what goes out under their name.
   Check `mcp__Gmail__list_drafts` first so you don't create a
   duplicate draft to the same contact.
4. **Reuse the linkable asset, don't rebuild it.** If the user already
   has (or is building) a sourced statistics page for their topic via
   the Qwoted skill, that's the same asset to pitch here — follow
   `../qwoted-seo-backlinks/STATISTICS_PAGE_PLAYBOOK.md` to build one if
   none exists yet. One stats page supports dozens of pitches across
   both channels.
5. **Every pitch must be genuinely personalized.** Reference something
   concrete and specific to the target — the exact broken link found,
   the exact wording of their resource-page listing, or the exact
   journalist request. Never send the same boilerplate paragraph to
   multiple targets; that's what gets domains blocklisted and accounts
   flagged, which is exactly the failure mode we're avoiding.
6. **Log every opportunity found and every pitch sent** to
   `sites/<slug>/outreach.csv` (schema below) as you go, not in a batch
   at the end — if the session ends early, the tracker should still
   reflect real state.
7. **Respect volume and cadence.** A handful of highly personalized
   pitches outperforms — and is far safer than — a large batch of
   similar-looking emails sent in one sitting. Don't email the same
   domain more than once in a short window, and don't draft more than
   ~10-15 pitches in a single session without checking in with the
   user.

---

## Stage 1 — Find opportunities

Three tactics, in rough order of typical ROI for a local home-services
business. Use `WebSearch` (you already have this tool — no script
needed for discovery, since none of this requires an authenticated
API).

### A. Resource-page link building

Find existing pages that curate links on the user's topic and ask to
be added.

Search patterns (swap in the actual niche/location):
- `"resources" OR "useful links" OR "helpful links" <niche>`
- `intitle:resources <niche> -site:pinterest.com`
- `"add your link" OR "suggest a resource" <niche>`
- For local relevance: add the city/region (e.g. `"plumbing resources" Gauteng`)

For each candidate page, confirm it's actually a curated list (not a
blog post) and that it's still maintained (check for recent dates or
recently-added entries) before pitching.

### B. Broken-link building

The highest-conversion tactic: find a dead link on a resource page and
offer the user's page as the replacement.

1. Use the same searches as (A) to find resource/links pages in the
   niche.
2. Run `scripts/check_broken_links.py <page-url> --niche "<topic>"` on
   each candidate. It fetches the page, checks every outbound link, and
   reports which are dead (with the anchor text and surrounding context
   for each) — this is far faster and more reliable than checking links
   by eye.
3. Any result with `"matches_niche": true` and `"confidence": "high"`
   is a strong pitch: "I noticed the link to X on your resources page
   returns a 404 — here's an updated resource covering the same topic."
   Results marked `"confidence": "low_verify_manually"` (403/429/5xx)
   are often anti-bot blocking, not a real dead link — open the URL
   yourself before claiming it's broken in a pitch.

### C. Public journalist / expert-request feeds

Some HARO-style request feeds are publicly browsable without an
account (unlike Qwoted, which requires login):
- X/Twitter search for `#journorequest`, `#PRrequest`, `#HARO` (public
  tweets, no login needed for basic search)
- Featured.com's public "Questions" page, if browsable without sign-in
- SourceBottle's public callout listings, if browsable without sign-in

Treat these as lower-volume and best-effort — verify each one is still
open (not expired) before pitching, since public feeds lag behind the
authenticated version.

---

## Stage 2 — Find the contact

Run `scripts/find_contact_email.py <domain>` against the target site.
It checks the homepage plus `/contact`, `/contact-us`, `/about`,
`/about-us`, `/write-for-us` for `mailto:` links and email-shaped
strings, and returns only what it actually finds.

- If it returns one or more emails, pick the most specific one (an
  editor/named contact beats a generic `hello@`).
- If it returns nothing, check the site's contact form or social
  profiles yourself via `WebFetch`, or tell the user this target has no
  discoverable email and ask whether to skip it.
- For journalist-request tactic (C), the contact is usually given
  directly in the request itself — use that, don't go looking for
  another address.

---

## Stage 3 — Draft the pitch

Create every pitch with `mcp__Gmail__create_draft`. Subject lines and
bodies should be short — journalists and site owners skim. Rough
shapes per tactic:

**Resource-page addition:**
> Subject: Suggestion for your [topic] resources page
>
> Hi [name], I came across your [resources page name] and thought
> [specific detail about the page]. I run [business], and put together
> [stats page title] — [one-line description of what makes it useful].
> Would it be a fit to add alongside your other [topic] links?
> [URL]. Either way, thanks for keeping that page up to date.

**Broken-link replacement:**
> Subject: Small fix for your [topic] resources page
>
> Hi [name], noticed the link to [dead link anchor text] on
> [page URL] currently 404s. I put together [stats page title], which
> covers the same ground — happy to have it stand in as the updated
> link if useful: [URL]. Either way, wanted to flag the broken one.

**Journalist/expert-request reply:**
> Subject: Re: [their request topic]
>
> Hi [name], saw your request on [platform] for [topic]. [1-2 sentence
> genuinely useful quote/data point directly answering the ask, pulled
> from the stats page or the user's own expertise]. Full sourced
> breakdown here if useful for background: [URL]. Happy to expand on
> anything above deadline permitting.

Always fill in real specifics — never leave a bracketed placeholder in
a drafted email.

---

## Stage 4 — Track

Keep `sites/<slug>/outreach.csv` (create with this header if it
doesn't exist yet):

```
date_found,tactic,target_url,contact_name,contact_email,pitch_angle,gmail_draft_id,status,notes
```

- `tactic`: `resource_page` | `broken_link` | `journo_request`
- `status`: `found` → `drafted` → `sent` → `replied` → `linked` (or
  `rejected` / `no_contact_found` / `dead`)

Append a row the moment an opportunity is found, and update its status
as it moves through the pipeline — don't wait until a batch is fully
done to log it.

---

## Stage 5 — Follow-up

If a drafted pitch was sent (user confirms) and there's no reply after
about a week, draft one short, polite follow-up — same rule applies,
draft only, never auto-send. After a second follow-up with no
response, mark the row `dead` and move on; don't send a third.
