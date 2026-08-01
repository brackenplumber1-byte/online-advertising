---
name: social-media-posting
description: |
  Post directly to Facebook, Instagram, LinkedIn, and Google Business
  Profile via their official APIs — or produce publish-ready drafts
  when API credentials aren't set up yet. Use this whenever the user
  asks to "post this to Facebook/Instagram/LinkedIn", "put up a Google
  Business Profile post", "share this on our socials", or wants the
  drafted content from the content-calendar skill actually published
  (or prepared for manual posting) across these platforms.
---

# Social Media Posting Skill

Publish to social platforms via their real APIs where credentials
exist; fall back to a clean hand-off draft where they don't. Each
platform has its own access process — read the relevant reference file
before acting on that platform for the first time.

---

## Operating rules — read first

1. **Check credentials before promising to post.** Each platform below
   needs its own API app + tokens, obtained by the business owner
   directly (Meta/LinkedIn/Google won't let a third party like Claude
   request access on the account owner's behalf). If the relevant
   `.env` vars aren't set, say so plainly and produce a draft instead —
   don't imply you posted something you didn't.
2. **Always show the exact post text/image plan before publishing**,
   the same as you would before sending an email on someone's behalf.
   Social posts are public and instant — there's no "unsend" once
   they're live and seen.
3. **Never fabricate reviews, statistics, certifications, or customer
   details** in a post. If content from `content-calendar` includes a
   placeholder, fill it with real info from the user or leave it out —
   don't invent something plausible-sounding.
4. **One platform's API failing doesn't block the others.** If Meta
   works but LinkedIn's token expired, publish to Meta and clearly
   report the LinkedIn failure rather than treating the whole batch as
   failed.
5. **Respect each platform's real constraints** — Instagram requires an
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

```bash
# Facebook Page post (text/link)
python3 scripts/meta_post.py facebook --message "..." 

# Instagram post (requires an image or video URL)
python3 scripts/meta_post.py instagram --image-url "https://.../photo.jpg" --caption "..."

# LinkedIn post (personal profile or organization, depending on configured URN)
python3 scripts/linkedin_post.py --text "..." [--image path/to/image.jpg]

# Google Business Profile local post
python3 scripts/gbp_post.py --summary "..." --cta-type CALL --cta-url "tel:+27..."
```

Every script prints one `RESULT: {...}` JSON line. Read the matching
reference file (`references/meta.md`, `references/linkedin.md`,
`references/gbp.md`) before the first use on each platform — they cover
exactly how to obtain the tokens the scripts need, since that setup is
the part only the account owner can actually do.

**These docs describe the APIs as of mid-2026 research; platform
policies and scopes change without much notice — if a call fails with
a permissions or deprecation error, check the platform's current
developer docs rather than assuming the script is wrong.**
