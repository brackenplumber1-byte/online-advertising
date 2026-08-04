# Gauteng Leads — Sourcing Notes

## What's in here

- `gauteng_construction_leads.csv` — 8 entries: building/construction companies and the
  region's main construction industry bodies.
- `gauteng_estate_agents_leads.csv` — 14 entries: estate agency branches, property groups,
  and the region's main real-estate industry bodies.

Every row was pulled from that organization's own website, an official contact/branch page, or
a business directory listing, and the `source_url` column links to where it came from. Nothing
here was guessed or auto-generated — where a search didn't turn up a confirmed email or phone
for a branch, the field is left blank with a note to use the website's contact form instead of
inventing one.

**This is a starter list, not a comprehensive one.** 22 verified contacts is enough to start a
campaign and test your messaging, but not enough to run a real volume campaign. Before you mail
anything: open each source URL and confirm the details are still current — branch contacts,
especially at the big franchise groups, change often.

## How to grow this list properly

Scraping personal/individual emails at scale is both against most sites' terms of service and
legally risky under POPIA (below). The legitimate ways to scale a B2B list like this:

1. **MBA North's member directory** (`mbanorth.co.za/find-a-builder/member-list/`) lists
   hundreds of vetted Gauteng builders — this is the single best next source for the
   construction side.
2. **Property24 / PrivateProperty estate agency listings** (`property24.com/estate-agencies`,
   `privateproperty.co.za/estate-agents-in-south-africa`) let you filter by Gauteng suburb.
3. **REBOSA and SAPOA** (both listed here) are industry associations — a partnership or
   sponsored-content conversation with them can reach their whole membership at once, which is
   both more efficient and more consent-friendly than cold-emailing every member individually.
4. **A licensed B2B data provider** (e.g. a company that sells verified, opt-in business
   contact data) is the right tool if you want hundreds of leads with confirmed emails — it
   shifts the compliance burden of sourcing the data onto a provider whose job that is.

## POPIA — what you need to know before sending

South Africa's Protection of Personal Information Act (POPIA) governs unsolicited direct
marketing by email. In short:

- **Consent or existing relationship**: direct marketing to a person by email generally
  requires either their prior consent, or an existing customer relationship. B2B outreach to a
  generic company inbox (`info@`, `sales@`, a named work role) for services relevant to that
  business is lower-risk than mailing a private individual, but it's not risk-free — a strict
  reading of POPIA covers a named individual's work email too.
- **Every marketing email needs**: your business's identity and physical address, and a
  working, honored opt-out. Both templates in `/email-templates` already have these fields
  built in — fill in `[YOUR BUSINESS PHYSICAL ADDRESS]` and wire up `{{unsubscribe_link}}` to
  something that actually suppresses future sends before you use them.
- **Honor opt-outs immediately** and keep a suppression list — resending to someone who opted
  out is the single biggest complaint/legal risk in a campaign like this.
- This is general guidance, not legal advice — for a campaign at real volume, a quick check with
  someone who knows POPIA direct-marketing rules is worth it.

## CSV columns

| Column | Meaning |
|---|---|
| `organization` | Company / branch / body name |
| `type` | Construction company, estate agency, industry body, etc. |
| `contact_name_role` | Named contact or department where known |
| `email` | Verified public email, blank if none was found |
| `phone` | Verified public phone number |
| `address` | Physical/branch address |
| `source_url` | Where this was confirmed — check before mailing |
| `notes` | Anything worth knowing before you reach out |
