---
name: lead-generation
description: |
  Improve how many leads the website actually captures, research new
  prospects worth reaching out to, and roll up lead numbers from
  existing channels into a regular report. Use this whenever the user
  asks about "getting more leads", "quote requests", "who should we
  reach out to", "leads report", "how many leads did we get", or wants
  to improve conversion on the website/socials/Google Business Profile
  rather than just publish content on them.
---

# Lead Generation Skill

Three workflows live here — pick based on what the user is actually
asking for:

1. **Capture** — making sure the channels that already exist
   (website, GBP, WhatsApp) convert visitors into actual leads, not
   just traffic.
2. **Prospecting** — finding new potential customers/partners worth a
   direct approach, rather than waiting for inbound.
3. **Reporting** — rolling up what's already coming in so the business
   can see whether marketing effort is translating into leads.

---

## Operating rules — read first

1. **Don't conflate traffic/engagement with leads.** A like or a page
   view is not a lead. A lead is a named, contactable person who took
   an action indicating buying intent (submitted a quote form, called,
   messaged, requested a callout). Keep the distinction sharp in
   anything you report or recommend.
2. **For a local trade business, B2B prospecting usually beats cold
   residential outreach.** Cold-calling homeowners is low-yield and can
   read as spammy; the higher-value prospecting targets are
   organizations with recurring plumbing needs: property management
   companies, letting/estate agents, body corporates/HOAs, guest
   houses/B&Bs, restaurants, and small commercial premises. Confirm
   this framing with the user rather than assuming residential
   door-to-door style outreach is wanted.
3. **WhatsApp is a first-class lead channel in South Africa** — many
   customers will message rather than call or fill in a form. If
   there's no WhatsApp Business presence linked from the site/GBP/
   socials, that's a high-leverage capture gap worth flagging early.
4. **Never fabricate lead numbers, conversion rates, or ROI figures.**
   If real data isn't available for a metric, say so explicitly in the
   report rather than estimating and presenting it as measured.
5. **Respect people's time in outreach** — B2B prospecting messages
   should be short, specific to the recipient's business, and offer a
   real reason to talk (not a generic sales blast to a scraped list).

---

## Part 1 — Website/channel lead capture

### Audit checklist

Work through these with (or via) the `wordpress-publishing` skill for
anything living on the site itself:

- **Quote-request form**: How many fields? Every non-essential
  required field is a drop-off point — name, phone/WhatsApp, service
  needed, and suburb is usually enough to start; address/photos can
  come after first contact.
- **Response-time promise**: Does the form/page set an expectation
  ("we respond within X hours")? This measurably increases completion
  rates — people fill in forms they expect to actually get a reply
  from.
- **Multiple contact paths, not just one**: phone number, WhatsApp
  link (`https://wa.me/27XXXXXXXXX`), and a form should all be visible
  from any page, not buried on a single Contact page.
- **Where do submissions go?** Check which form plugin is in use
  (Contact Form 7, WPForms, Gravity Forms, etc.) — Contact Form 7 by
  default only emails submissions and doesn't store them anywhere
  queryable; if the user wants a leads log/report later, flag this and
  suggest either enabling an entries-storage add-on or at minimum
  ensuring submission emails land somewhere reliably searchable.
- **UTM-tag every outbound link** from social posts, GBP posts, and
  citation listings back to the site (`?utm_source=facebook&utm_
  medium=social&utm_campaign=...`) so leads can eventually be traced to
  the channel that produced them. Coordinate with the
  `content-calendar` and `off-page-seo` skills so links they hand off
  already carry these tags.
- **Google Business Profile lead paths**: the "Call", "Message", and
  "Website" buttons on the listing, plus the Q&A section (answer
  questions proactively — they're public and get seen by future
  searchers, not just the asker).

### Making a recommendation

After the audit, give a short prioritized list (not everything at
once) — e.g. "1) add a WhatsApp link to the homepage header, 2) cut the
quote form from 8 fields to 4, 3) add a response-time line above the
form." Concrete and small beats a long audit report nobody acts on.

---

## Part 2 — Prospecting

### Target categories for a plumbing business

| Category | Why | How to find them |
|---|---|---|
| Property management companies | Recurring maintenance contracts across many units | Web search `"property management" Bracken Downs OR [region]`, local property management association directories |
| Letting/estate agents | Refer tenants/landlords needing repairs, or maintain rental stock directly | Search local agency websites, property portals |
| Body corporates / HOAs (sectional title schemes, complexes) | Ongoing communal plumbing maintenance | Local complex names, managing agent websites |
| Guest houses / B&Bs / small hotels | Need reliable, fast-response plumbing for guest-facing issues | Booking-platform listings for the area, local tourism association |
| Restaurants / small commercial kitchens | Recurring grease-trap/drain/geyser needs | Local business directories, foot-traffic knowledge |
| New-build/renovation contractors | Subcontracting opportunities | Local building/renovation company websites |

### Workflow

1. Pick a category, research 10-20 real, named organizations in the
   service area (real websites/contact info — don't invent names).
2. For each, note a specific reason plumbing services would matter to
   them (number of units, guest volume, etc. if discoverable).
3. Draft a short, specific introduction message per organization (or
   per small batch if genuinely similar) — offering a maintenance-
   contract conversation, not a hard sell. Distinct from the
   `off-page-seo` outreach emails (those ask for a link; these ask for
   a business relationship).
4. Track in `./lead-generation/prospects.csv`:
   ```
   date,organization,category,contact,status,notes
   2026-08-01,Example Property Mgmt,property-management,info@example.co.za,contacted,sent intro email
   ```
   `status`: `researched` → `contacted` → `responded` / `no-response` →
   `converted` (became a client).

---

## Part 3 — Reporting

### What to pull together (only what's actually available — see rule above)

- **Website**: form submissions this period (from whatever storage
  exists per the capture audit), and page-level traffic if analytics
  are set up.
- **Google Business Profile**: calls, direction requests, website
  clicks, and messages — from the Business Profile dashboard directly,
  or the Performance API if the same GBP API access from
  `social-media-posting`'s GBP setup has been granted.
- **Social**: engagement on posts from `content-calendar`'s tracking,
  and any DMs/comments that turned into an actual inquiry.
- **WhatsApp**: rough count if the user can share it (WhatsApp
  Business App shows basic message stats; the Business Platform/API
  has proper analytics if that's ever set up).

### Report structure

Keep it short and business-focused, not a data dump:

```markdown
# Lead report — [period]

## Headline
X leads this period (Y website form, Z GBP calls/messages, W WhatsApp,
V referral/other) — [up/down] vs last period, [known reason if any].

## By channel
Table: channel | leads | notable change

## What's working / what's not
1-2 sentences each, grounded in the numbers above — not speculation.

## Recommendation for next period
1-3 concrete, prioritized actions.
```

If a metric genuinely isn't trackable yet (e.g. no analytics
installed), say so in the report as a gap to close, rather than
omitting it silently.
