# 247PlumbersGP — Gauteng Email Campaign

Outreach campaign for **247PlumbersGP** (`marketing@247plumbersgp.co.za`), targeting two
segments in the Gauteng region:

1. **Construction companies** → construction/contract plumbing (rough-in, final fix, snagging,
   compliance certs).
2. **Estate agents & property managers** → maintenance/emergency plumbing (call-outs, geysers,
   drains, agency accounts).

## What's in this repo

```
leads/
  gauteng_construction_leads.csv      8 verified construction-side contacts
  gauteng_estate_agents_leads.csv     14 verified estate-agent-side contacts
  README.md                           sourcing notes + POPIA compliance guidance — read first
email-templates/
  construction-plumbing-email.html    HTML email for construction companies (mail-merge ready)
  construction-plumbing-email.txt     plain-text fallback of the same email
  estate-agent-maintenance-email.html HTML email for estate agents / property managers
  estate-agent-maintenance-email.txt  plain-text fallback of the same email
posters/
  construction-plumbing-poster.html   printable A4 flyer — industrial spec-sheet style
  estate-agent-maintenance-poster.html printable A4 flyer — property-brochure style
```

## Before you send anything

Every template has three placeholders you need to fill in — search for them across
`email-templates/` and `posters/`:

- `[YOUR PHONE NUMBER]`
- `[YOUR WEBSITE]`
- `[YOUR BUSINESS PHYSICAL ADDRESS]` (email templates only — POPIA requires this on marketing
  email)

The emails also use two mail-merge fields, `{{contact_first_name}}` and `{{company_name}}`, and
an `{{unsubscribe_link}}` that needs to point at something that actually suppresses future
sends. Read `leads/README.md` for what POPIA requires here — the short version is: real
opt-out, your real address, and don't re-mail anyone who's opted out.

## Using the posters

Open either `.html` file in a browser — they're built as a fixed A4 sheet, so:
- **Print / PDF**: browser print dialog → *Save as PDF*, paper size A4 (the page is already
  sized for it).
- **Digital/social use**: full-page screenshot, or open it as a Claude Artifact to share a link.

## Using the email templates + leads list

The HTML files are inline-styled on purpose so they survive being pasted into Gmail/Outlook or
run through a mail-merge tool. A simple way to send in batches:
1. Fill in the placeholders above.
2. Match each `leads/*.csv` row to the matching template (construction list → construction
   email, estate agent list → estate agent email).
3. Merge `{{contact_first_name}}` / `{{company_name}}` per row, either by hand for this small a
   list, or with a mail-merge tool (Gmail's own mail-merge add-ons, or any CSV-driven sender)
   once the list grows.

## Automating sending

If you'd like this connected to your actual inbox so drafts (or sends) happen automatically,
say so and share which mailbox to use (`marketing@247plumbersgp.co.za` or another) — the
recommended setup is generating personalized **drafts** for your review first, rather than
fully automated blind sending, both so you can catch mistakes and because POPIA compliance
(consent basis, opt-outs) is easier to get right with a human check before each batch goes out.

## Growing the leads list

22 verified contacts is a starting point, not the full campaign. `leads/README.md` covers where
to legitimately source more — the MBA North member directory, Property24/PrivateProperty agency
listings, REBOSA/SAPOA partnerships, or a licensed B2B data provider for real volume.
