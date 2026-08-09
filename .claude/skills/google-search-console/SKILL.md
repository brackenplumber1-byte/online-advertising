---
name: google-search-console
description: |
  Query Google Search Console performance data (clicks, impressions,
  CTR, position by query/page/date/device), list and submit sitemaps,
  and run the URL Inspection tool via the Search Console API using an
  OAuth 2.0 refresh token. Supports multiple businesses/sites via
  --site <slug> (see ../SITES.md). Use this whenever the user asks
  "how is our SEO doing", "what are people searching to find us",
  "check our search rankings/impressions", "submit our sitemap to
  Google", or "check if this page is indexed".
---

# Google Search Console Skill

Read Search Console data and manage sitemaps via Google's official
API, authenticated with an OAuth 2.0 refresh token (no manual
copy-paste into the Search Console web UI needed).

This skill manages **multiple businesses**, not just one — see
`../SITES.md` for the full list. Always pass `--site <slug>` explicitly
once more than one business has credentials configured.

---

## Operating rules — read first

1. **Confirm which business before doing anything**, if it isn't
   already obvious from context — check `../SITES.md` for the slug
   list rather than guessing.
2. **Never invent credentials.** If a business's `sites/<slug>.env`
   isn't set up yet, walk the user through the one-time setup below.
   Don't ask for the client secret or refresh token to be pasted in
   chat if it can be avoided — but if that's the only channel
   available, write it straight into the env file and don't echo it
   back.
3. **This skill is read-mostly.** The only state-changing action is
   `submit-sitemap` (harmless and idempotent — Google just re-crawls
   it). Everything else (`query`, `list-sitemaps`, `inspect-url`) is
   read-only, so there's no "draft first" concern like with publishing
   skills.
4. **`RESULT:` lines are the canonical channel.** Every `gsc_client.py`
   command prints one `RESULT: {...}` JSON line — parse that, not your
   own assumptions about whether something worked.
5. **Don't over-interpret small numbers.** Search Console data has a
   2-3 day reporting delay and can be noisy for low-traffic local
   sites — a handful of clicks moving up or down week to week isn't
   necessarily meaningful. Look at trends over weeks/months, not
   single-day swings.

---

## One-time setup (per business)

Search Console access does **not** require Google's manual API-access
approval process (unlike Google Business Profile) — it's a standard
Cloud API any Google Cloud project can enable immediately. The account
used for OAuth just needs to be listed as a user (Owner or Full user)
on the Search Console property already.

1. **Confirm the property is verified**: the Google account you'll
   authenticate with must already appear under **Settings → Users and
   permissions** on [search.google.com/search-console](https://search.google.com/search-console)
   for this site, as Owner or Full user.
2. **Create (or reuse) a Google Cloud project** at
   [console.cloud.google.com](https://console.cloud.google.com):
   - Enable the **Search Console API** (APIs & Services → Library →
     search "Search Console API" → Enable). If this project already
     has OAuth credentials set up for the `google-business-profile`
     skill, the same project/client can be reused — just enable this
     additional API on it.
3. **Create an OAuth 2.0 Client ID** (APIs & Services → Credentials →
   Create Credentials → OAuth client ID → Desktop app type is
   simplest for a one-time consent flow). Note the Client ID and
   Client Secret.
4. **Run the one-time OAuth consent flow** to get a refresh token.
   Simplest path: use Google's [OAuth 2.0 Playground](https://developers.google.com/oauthplayground):
   - Click the gear icon → check "Use your own OAuth credentials" →
     enter your Client ID/Secret.
   - In Step 1, find and select the scope
     `https://www.googleapis.com/auth/webmasters.readonly` (or
     `.../auth/webmasters` for read-write, needed for
     `submit-sitemap`).
   - Authorize, exchange the auth code for tokens, and copy the
     **refresh token** shown in Step 2.
5. **Install dependencies** (once, shared across all businesses):
   ```bash
   pip install -r requirements.txt
   ```
6. **Configure credentials for this business**: copy
   `sites/<slug>.env.example` to `sites/<slug>.env` and fill in
   `GOOGLE_CLIENT_ID`, `GOOGLE_CLIENT_SECRET`, `GOOGLE_REFRESH_TOKEN`,
   and `GSC_SITE_URL` (the exact property as it appears in Search
   Console — either a URL-prefix property like
   `https://www.example.com/` **including the trailing slash**, or a
   domain property like `sc-domain:example.com`). Never commit
   `sites/*.env`.
7. **Verify**:
   ```bash
   python3 scripts/gsc_client.py --site <slug> whoami
   ```
   A `RESULT` with `"verified_and_accessible": true` means you're
   connected. If it's `false`, double-check `GSC_SITE_URL` matches
   exactly one of the entries in `all_accessible_sites` from the same
   response.

---

## Common tasks

### Check recent search performance

```bash
python3 scripts/gsc_client.py --site brackendownsplumber query \
  --start-date 2026-07-01 --end-date 2026-07-31 \
  --dimensions query --row-limit 20
```

Useful dimension combos: `query` (what people searched), `page` (which
URL got the click), `date` (trend over time), `device`
(mobile/desktop/tablet split), or comma-combine e.g.
`query,page` to see the top query per landing page.

### Check indexing status of a specific page

```bash
python3 scripts/gsc_client.py --site brackendownsplumber inspect-url \
  --url https://www.brackendownsplumber.co.za/geyser-repair/
```

### Resubmit the sitemap after publishing new content

```bash
python3 scripts/gsc_client.py --site brackendownsplumber submit-sitemap \
  --sitemap-url https://www.brackendownsplumber.co.za/sitemap.xml
```

### List submitted sitemaps and their status

```bash
python3 scripts/gsc_client.py --site brackendownsplumber list-sitemaps
```

---

## Quick reference

```bash
python3 scripts/gsc_client.py --site <slug> whoami
python3 scripts/gsc_client.py --site <slug> query --start-date YYYY-MM-DD --end-date YYYY-MM-DD --dimensions query,page --row-limit 25
python3 scripts/gsc_client.py --site <slug> list-sitemaps
python3 scripts/gsc_client.py --site <slug> submit-sitemap --sitemap-url https://example.com/sitemap.xml
python3 scripts/gsc_client.py --site <slug> inspect-url --url https://example.com/some-page/
```

Credentials: `sites/<slug>.env` in this skill's directory
(`GOOGLE_CLIENT_ID`, `GOOGLE_CLIENT_SECRET`, `GOOGLE_REFRESH_TOKEN`,
`GSC_SITE_URL`) — never commit it. See `../SITES.md` for the full
business registry.

## Common errors

| Error | Meaning | Fix |
|---|---|---|
| `verified_and_accessible: false` | `GSC_SITE_URL` doesn't match a property the OAuth account can access | Check `all_accessible_sites` in the same response and copy the exact string |
| `403` / `insufficientPermissions` | OAuth account isn't a Full user or Owner on this property | Have an existing Owner add it under Settings → Users and permissions |
| `invalid_grant` on token refresh | Refresh token revoked or expired (rare, but happens if the OAuth consent screen is in "Testing" mode and the 7-day testing-token expiry passed) | Re-run the OAuth consent flow; consider publishing the consent screen (even as "External" + unverified is fine for single-user internal tools) to avoid the 7-day testing limit |
| `submit-sitemap` succeeds but sitemap shows errors in `list-sitemaps` | The sitemap itself has issues (bad URLs, wrong format) | Fix the sitemap file, not the API call |
