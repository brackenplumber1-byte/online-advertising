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

## Contact details already filled in

- Phone: 072 280 7602
- Website: [247plumbersgp.co.za](https://247plumbersgp.co.za)
- Address (POPIA-required footer): 38 San Souci Street, Johannesburg
- Opt-out: reply-based ("Reply UNSUBSCRIBE") — see **Sending manually** below for why, and keep
  a suppression list per `leads/README.md`.

The emails still have two mail-merge fields to fill per recipient: `{{contact_first_name}}` and
`{{company_name}}`.

## Using the posters

Open either `.html` file in a browser — they're built as a fixed A4 sheet, so:
- **Print / PDF**: browser print dialog → *Save as PDF*, paper size A4 (the page is already
  sized for it).
- **Digital/social use**: full-page screenshot, or open it as a Claude Artifact to share a link.

## Sending manually

`marketing@247plumbersgp.co.za` is hosted with your domain provider, not Gmail/Microsoft, so
there's no direct inbox connector for it yet — for this list size (22 contacts), sending by
hand is genuinely the fastest option:

1. Match each `leads/*.csv` row to the matching template (construction list → construction
   email, estate agent list → estate agent email).
2. Open the `.html` file, copy the rendered email (open it in a browser, select all, copy) into
   your webmail's compose window — or use the `.txt` version for a plain-text send.
3. Swap in `{{contact_first_name}}` / `{{company_name}}` for that recipient.
4. Send from `marketing@247plumbersgp.co.za`, in a couple of batches rather than all 22 at once.
5. Track opt-outs (anyone who replies "UNSUBSCRIBE") in a simple list and check it before any
   future send — that's your POPIA suppression list.

## Automating sending later

Once the list outgrows manual sending, two paths:
- **A marketing-email platform** (e.g. Brevo) built for bulk outreach with unsubscribe/
  suppression handled automatically — needs `247plumbersgp.co.za` verified via SPF/DKIM records
  with your domain provider, then connected to Claude from claude.ai's connector settings.
- **Connect the mailbox directly** — if `marketing@247plumbersgp.co.za` is ever set up as a
  Gmail/Google Workspace "send mail as" alias, the Gmail connector already available in this
  session could draft (or send) directly.

Either way, generating **drafts** for your review first is the safer default over fully
automated blind sending, at least until the messaging is proven.

## Growing the leads list

22 verified contacts is a starting point, not the full campaign. `leads/README.md` covers where
to legitimately source more — the MBA North member directory, Property24/PrivateProperty agency
listings, REBOSA/SAPOA partnerships, or a licensed B2B data provider for real volume.
