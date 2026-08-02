# Managed businesses

Shared registry of every business these skills operate on. Referenced by
`wordpress-publishing`, `social-media-posting`, `google-search-console`,
`content-calendar`, `off-page-seo`, and `lead-generation` — when a task
doesn't specify which business, ask; don't assume it's the first one in
this list.

| Slug | Business name | Domain | WordPress config | Social config | Search Console config |
|---|---|---|---|---|---|
| `brackendownsplumber` | Bracken Downs Plumber | brackendownsplumber.co.za | ✅ live (Application Password configured) | not yet configured | not yet configured |
| `247plumbersgp` | 247 Plumbers GP | 247plumbersgp.co.za | template only, needs Application Password | not yet configured | not yet configured |
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

## Content/tracking file conventions

`content-calendar`, `off-page-seo`, and `lead-generation` keep their
tracking CSVs per business under a `sites/<slug>/` subdirectory (e.g.
`content-calendar/sites/247plumbersgp/calendar.csv`) rather than one
shared file — five businesses' content plans and lead pipelines should
never be mixed into a single tracker.
