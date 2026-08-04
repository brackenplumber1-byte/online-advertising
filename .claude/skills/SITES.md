# Managed businesses

Shared registry of every business these skills operate on. Referenced by
`wordpress-publishing`, `social-media-posting`, `google-search-console`,
`content-calendar`, `off-page-seo`, and `lead-generation` — when a task
doesn't specify which business, ask; don't assume it's the first one in
this list.

| Slug | Business name | Domain | WordPress config | Social config | Search Console config |
|---|---|---|---|---|---|
| `brackendownsplumber` | Bracken Downs Plumber | brackendownsplumber.co.za | ✅ live (Application Password configured) | not yet configured | not yet configured |
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
