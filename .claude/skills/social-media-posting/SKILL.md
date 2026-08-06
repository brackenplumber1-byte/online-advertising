---
name: social-media-posting
description: |
  Post directly to Facebook, Instagram, LinkedIn, and Google Business
  Profile via their official APIs — or produce publish-ready drafts
  when API credentials aren't set up yet. Supports multiple businesses
  via --site <slug> (see ../SITES.md). Use this whenever the user asks
  to "post this to Facebook/Instagram/LinkedIn", "put up a Google
  Business Profile post", "share this on our socials", or wants the
  drafted content from the content-calendar skill actually published
  (or prepared for manual posting) across these platforms.
---

# Social Media Posting Skill

Publish to social platforms via their real APIs where credentials
exist; fall back to a clean hand-off draft where they don't. Each
platform has its own access process — read the relevant reference file
before acting on that platform for the first time.

This skill manages **multiple businesses** — see `../SITES.md` for the
full list. Always pass `--site <slug>` explicitly once more than one
business has credentials configured, so a post never lands on the
wrong business's channels.

---

## Operating rules — read first

1. **Confirm which business before doing anything**, if it isn't
   already obvious from context — check `../SITES.md` rather than
   guessing or defaulting to whichever one was used last.
2. **Check credentials before promising to post.** Each platform below
   needs its own API app + tokens, obtained by the business owner
   directly (Meta/LinkedIn/Google won't let a third party like Claude
   request access on the account owner's behalf). If the relevant
   `sites/<slug>.env` vars aren't set for this business, say so plainly
   and produce a draft instead — don't imply you posted something you
   didn't.
3. **Always show the exact post text/image plan before publishing**,
   the same as you would before sending an email on someone's behalf.
   Social posts are public and instant — there's no "unsend" once
   they're live and seen.
4. **Never fabricate reviews, statistics, certifications, or customer
   details** in a post. If content from `content-calendar` includes a
   placeholder, fill it with real info from the user or leave it out —
   don't invent something plausible-sounding.
5. **One platform's API failing doesn't block the others.** If Meta
   works but LinkedIn's token expired, publish to Meta and clearly
   report the LinkedIn failure rather than treating the whole batch as
   failed.
6. **Respect each platform's real constraints** — Instagram requires an
   image/video (no text-only feed posts via API), GBP posts want a CTA
   button, LinkedIn posting to a Company Page needs org-level access
   (personal profile posting is a different, easier scope — confirm
   which the user means).

---

## Platform status at a glance

| Platform | Setup difficulty | Typical approval time | Reference |
|---|---|---|---|
| Facebook Page | Moderate — Meta developer app + Page token | Basic Page posting can work in Development Mode without full App Review if you're an admin of the Page; broader use needs App Review | `references/meta.md` |
| Instagram (Business/Creator account) | Moderate-high — needs `instagram_content_publish` permission via App Review, plus a Professional account linked to a Facebook Page | App Review: days-weeks | `references/meta.md` |
| LinkedIn (Company Page) | High — Marketing/Community Management API access requires a registered company, verified Page, and a two-tier LinkedIn review | Weeks | `references/linkedin.md` |
| LinkedIn (personal profile) | Lower — `w_member_social` scope, no special product access needed | Fast (self-serve OAuth) | `references/linkedin.md` |
| Google Business Profile posts | High — Business Profile API access request to Google, needs a 60+ day verified profile and a stated use case | Days-weeks, sometimes longer | `references/gbp.md` |

Set expectations with the user accordingly — GBP and LinkedIn Company
Page access are the slowest to obtain. In the meantime, use draft-only
mode (below) so the cadence doesn't stall waiting on approvals.

---

## Draft-only mode (use this until credentials exist)

For any platform without configured credentials, don't block — produce
the exact post copy (and describe the image/video needed if
applicable) formatted per that platform's conventions, and tell the
user to post it manually. Log it in the content-calendar as
`published` with a note "posted manually by user" once they confirm.
This keeps the daily/weekly/monthly cadence moving without waiting on
API approvals.

---

## Quick reference

All scripts take `--site <slug>` right after the script name (see
`../SITES.md` for valid slugs) — omit only for quick single-business
testing via the fallback `./.env`.

```bash
# Facebook Page post (text/link)
python3 scripts/meta_post.py --site <slug> facebook --message "..."

# Instagram post (requires an image or video URL)
python3 scripts/meta_post.py --site <slug> instagram --image-url "https://.../photo.jpg" --caption "..."

# LinkedIn post (personal profile or organization, depending on configured URN)
python3 scripts/linkedin_post.py --site <slug> --text "..." [--image path/to/image.jpg]

# Google Business Profile local post
python3 scripts/gbp_post.py --site <slug> --summary "..." --cta-type CALL --cta-url "tel:+27..."

# One-time: discover GBP_ACCOUNT_ID / GBP_LOCATION_ID once OAuth is set up
python3 scripts/gbp_discover.py --site <slug>
```

Every script prints one `RESULT: {...}` JSON line. Read the matching
reference file (`references/meta.md`, `references/linkedin.md`,
`references/gbp.md`) before the first use on each platform — they cover
exactly how to obtain the tokens the scripts need, since that setup is
the part only the account owner can actually do. Credentials live in
`sites/<slug>.env` — see `../SITES.md` for the business registry and
onboarding steps for a new one.

**These docs describe the APIs as of mid-2026 research; platform
policies and scopes change without much notice — if a call fails with
a permissions or deprecation error, check the platform's current
developer docs rather than assuming the script is wrong.**
