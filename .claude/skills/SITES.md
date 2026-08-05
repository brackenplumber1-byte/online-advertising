# Managed businesses

Shared registry of every business these skills operate on. Referenced by
`wordpress-publishing`, `social-media-posting`, `google-search-console`,
`content-calendar`, `off-page-seo`, and `lead-generation` — when a task
doesn't specify which business, ask; don't assume it's the first one in
this list.

| Slug | Business name | Domain | WordPress config | Social config | Search Console config |
|---|---|---|---|---|---|
| `brackendownsplumber` | Bracken Downs Plumber | brackendownsplumber.co.za | ✅ live (Application Password configured) | not yet configured | ✅ live (siteOwner) |
| `247plumbersgp` | 247 Plumbers GP | 247plumbersgp.co.za | ✅ live (Application Password configured) | not yet configured | ✅ live (siteOwner, via Site Kit) |
| `mondeorplumbingservices` | Mondeor Plumbing Services | mondeorplumbingservices.co.za | template only, needs Application Password | not yet configured | not yet configured |
| `tysonsplumbersroodepoort` | Tysons Plumbers Roodepoort | tysonsplumbersroodepoort.co.za | template only, needs Application Password | not yet configured | not yet configured |
| `247renovations` | 247 Renovations | 247renovations.co.za | template only, needs Application Password | not yet configured | not yet configured |

## How the slug is used

Every script in `wordpress-publishing/scripts/` and
`social-media-posting/scripts/` accepts `--site <slug>` (before the
subcommand), which loads that business's credentials from
`sites/<slug>.env` in the relevant skill's folder instead of a single
shared `.env`. Example:

```bash
python3 scripts/wp_client.py --site 247plumbersgp whoami
python3 scripts/meta_post.py --site mondeorplumbingservices facebook --message "..."
```

Omitting `--site` falls back to a plain `./.env` in that skill's
directory — fine for quick one-off testing, but for anything involving
more than one business, always pass `--site` explicitly so work never
accidentally lands on the wrong business's channels.

## Onboarding a new business's WordPress access

1. Add a row to the table above.
2. Copy `wordpress-publishing/sites/<slug>.env.example` to
   `wordpress-publishing/sites/<slug>.env` (git-ignored).
3. Get an Application Password from that site's wp-admin (Users →
   Profile → Application Passwords) and fill in the three values.
4. Verify: `python3 scripts/wp_client.py --site <slug> whoami`

## Onboarding a new business's social channels

Same pattern under `social-media-posting/sites/<slug>.env` — copy from
the matching `.env.example`, fill in only the platforms already set up
for that business (see `social-media-posting/references/*.md` for how
to obtain each platform's credentials), leave the rest blank to keep
that platform in draft-only mode for that business.

## Onboarding a new business's Search Console access

Same pattern under `google-search-console/sites/<slug>.env` — copy from
the matching `.env.example`, fill in the OAuth client + refresh token
(see `google-search-console/SKILL.md` for how to obtain them — no
lengthy Google approval process required, unlike Google Business
Profile), and `GSC_SITE_URL` set to the exact verified property.

## ⚠️ Shared theme bug risk (gp_area / gp_service post types)

247plumbersgp's theme (and presumably brackendownsplumber's, since it was
built from "the 247gp architecture") auto-creates any missing area/service
page via `gp_create_all_pages()`. In the pre-fix version of this theme,
that function ran on **every single request** (hooked to `init`) and only
checked for a post in `'publish'` status when deciding whether a page
already existed. The moment any one of those posts was set to draft/
private/trash, every subsequent request (page views, REST calls, even
Googlebot crawling) treated it as missing and inserted a brand new
duplicate — compounding into hundreds of duplicate posts within minutes.

This was hit and fixed on 247plumbersgp on 2026-08-02 (see
`websites/247plumbersgp/247gp/functions.php`: existence check now matches
`post_status=>'any'`, and the `init` hook was removed entirely — page
creation only needs to run once, on theme activation). Fixed theme was
uploaded to the live site and verified safe (drafted all 9 overlapping
suburb pages with no recurrence of the duplication bug).

All 29 remaining published area pages on 247plumbersgp now have unique,
locally-specific content (doorway-page cleanup complete as of 2026-08-02).

**AIOSEO score note (2026-08-04):** all 29 area pages + 9 service pages
now have a real focus keyphrase set and expanded post_content (services
list + CTA) via the `/aioseo/v1/post` REST route. AIOSEO's displayed
score badge (e.g. "53/100") does NOT auto-recompute via the API — it's
calculated by AIOSEO's client-side JS analyzer and only updates when a
human opens the post in the wp-admin editor. No REST route exists to
force a bulk recalculation (checked — no such endpoint). The underlying
content/keyphrase fixes are real; only the visible number needs a manual
editor visit per page to refresh. Also note: the theme's own PHP
generates the real `<title>`/meta tags directly and does not use
AIOSEO's title/description fields at all on the live site — those
AIOSEO fields only affect the internal score display, not real SEO.

**brackendownsplumber (2026-08-04):** same content/AIOSEO pass applied —
all 30 area pages (already had unique content) got a services list + CTA
appended, and all 16 service pages (previously empty post_content) got
real written content, all with focus keyphrases set. Confirmed no
duplicate-post bug fired (checked before and after — exact 30/16 counts
both times) and reviews here were already genuine (no fake-testimonial
issue to fix). Same AIOSEO score-badge caveat applies: real content/
keyphrase fixes are live, but the visible score number needs a manual
wp-admin editor visit per page to refresh.

**Keyword-alignment pass (2026-08-04), from uploaded 939-keyword
spreadsheet:** AIOSEO title field was synced to match the theme's real
rendered `<title>`/description on all 84 area+service pages across both
sites (previously only tested on one page, never applied system-wide —
this is what was causing AIOSEO to show "Germiston" instead of "Plumber
in Germiston" as the headline). Service+Area (480 keywords) was already
fully covered by existing internal linking ("{Service} in {Area}" anchor
text present on every area page for every relevant service — verified
on both sites, no changes needed). Service+Modifier (128) and most of
Cost/Comparison (24, minus a mapping bug in the source spreadsheet that
pointed all cost keywords at one page — corrected) covered by a new FAQ
block (near me / cost / same-day / affordable) appended to all 25
service pages across both sites. Brand/Broad (29) mostly pre-covered by
existing homepage trust signals; added one more homepage section
covering "residential/commercial/trusted/contractor" to
brackendownsplumber (needed the theme zip, which was provided and is
now in the repo at websites/brackendownsplumber/ — same runaway-
duplication bug was present in this zip too and has been fixed the same
way as 247plumbersgp's). Informational/Blog (38) — brackendownsplumber
had only 1 existing blog post; wrote and published all 38 topics as new
posts with focus keyphrases set (post IDs 124-161).

**247plumbersgp (2026-08-04):** same keyword-alignment pass applied.
AIOSEO title-sync and service-page FAQ blocks had already run for this
site in the same batch as brackendownsplumber's (verified live — no
extra work needed there). Added the same homepage "Residential &
Commercial" trust item (theme zip re-sent to user for upload). For the
blog gap: 247plumbersgp already had 6 of the 38 spreadsheet topics
covered; published the remaining 25 as new posts (post IDs 427-451),
reusing brackendownsplumber's content directly where generic (23 posts)
and rewriting the 2 Alberton-specific ones for Midrand/Gauteng branding.
Deliberately skipped 6 topics referencing services 247plumbersgp doesn't
offer (heat pumps, water filtration, gutters, grease trap cleaning,
drain camera inspections, maintenance contracts) to avoid implying
services that aren't actually available.

**AIOSEO "Basics" polish pass (2026-08-04):** after a page hit 81/100
once keyphrase+content fixes were live and the editor was opened (score
badge does refresh on manual editor visit, confirmed), 3 remaining
AIOSEO flags were addressed across all 84 area+service pages on both
sites: (1) added one relevant `<img>` tag per page, reusing existing
theme image assets in rotation — no new images fetched; (2) added one
outbound link per page to https://www.pirb.co.za/ (verified live,
official PIRB site) in a natural compliance-certificate context; (3)
expanded every page to 300+ words via a genuine area-specific or
service-specific FAQ block, with a follow-up top-up pass for the ~49
pages still under 300 after the first pass. Verified 0 pages remain
under 300 words / missing an image / missing the outbound link, on
both sites.

**New Midrand suburbs (2026-08-05):** replaced the 9 unpublished
East Rand slots on 247plumbersgp with 9 genuinely relevant Midrand-area
suburbs instead — Vorna Valley, Carlswald, Noordwyk, Halfway Gardens,
Halfway House, Kyalami, Blue Hills, Erand Gardens, Randjiespark (post
IDs 454-462). Confirmed real existing search demand for several of
these via GSC before building (kyalami, carlswald, noordwyk, blue
hills already showing impressions with no dedicated page). Built to
the same quality bar as every other area page: unique local paragraph,
services list, image, PIRB outbound link, FAQ block, 300+ words.
Added to GP_AREAS and the region map (grouped under 'midrand') in
functions.php for cross-linking — theme zip re-sent to user for
upload; cross-linking won't show these until that's live.

Added a 10th: **Waterfall City** (post ID 465, slug `waterfall`),
naming the real named estates within it — Polo Fields, Munyaka,
Kikuyu — verified accurate via web search before writing (all three
are genuine Waterfall City precincts) rather than assumed.

**searchfit-seo audit fixes (2026-08-05, brackendownsplumber):** user
ran the searchfit-seo plugin against brackendownsplumber (not
247plumbersgp — plugin only loads in a fresh session, wasn't available
in this one). All 4 critical/high findings verified independently
before fixing, then fixed: (1) duplicate/conflicting Organization
schema — AIOSEO's `organizationName` had a redundant hardcoded
"Brackendowns Plumber" suffix appended to `#site_title`, doubling the
name; `sameUsername.username` had a stray leading "@" double-prefixing
TikTok and breaking the LinkedIn URL shape — both fixed via
`/aioseo/v1/options`. Also fixed the WP tagline (was the thin
"Plumbers Alberton", now "24/7 Emergency Plumbers in Alberton & the
East Rand") and removed the same redundant-suffix bug from AIOSEO's
global meta description template. (2) jQuery core/migrate were the
only render-blocking scripts left in `<head>` — added `defer` via a
`script_loader_tag` filter. (3) 4 homepage JPEGs (1200x1600,
270-315KB) were served at 74-76% larger than needed for their actual
~200px-tall display size — resized to 600x800 WebP (~70-80KB each),
added explicit width/height + `loading="lazy"`. (4) All 16 service
page titles were 71-72 chars ("$name Alberton & East Rand |
Brackendowns Plumber", clipped by Google ~60 chars) — shortened the
theme's title template and re-synced all 16 AIOSEO title fields to
match (all now 33-59 chars). Theme zip re-sent to user for upload.
Two audit "notes" didn't need action: the 30 near-identical area pages
concern was already resolved by earlier work in this session (all 30
already have unique content), and Google Analytics being allow-listed
but not installed was flagged for the user's own confirmation, not
acted on unilaterally.

**Before changing any `gp_area`/`gp_service` post's status (draft, trash,
private) on brackendownsplumber or any future site sharing this theme
family, first confirm that site's `functions.php` has the same fix.** If
it doesn't, changing a post's status could trigger the same runaway
duplication there too.

## Content/tracking file conventions

`content-calendar`, `off-page-seo`, and `lead-generation` keep their
tracking CSVs per business under a `sites/<slug>/` subdirectory (e.g.
`content-calendar/sites/247plumbersgp/calendar.csv`) rather than one
shared file — five businesses' content plans and lead pipelines should
never be mixed into a single tracker.
