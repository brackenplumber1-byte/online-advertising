---
name: wordpress-publishing
description: |
  Create, update, and manage posts/pages/media on a WordPress site via
  its REST API using an Application Password — no plugin, no manual
  copy-paste into wp-admin needed. Supports multiple businesses/sites
  via --site <slug> (see ../SITES.md). Use this whenever the user asks
  to "post this to the website", "update the WordPress site", "publish
  a blog post/article", "add a page", "upload this image to the site",
  or wants a scheduled/regular cadence of website content published to
  WordPress (daily/weekly/monthly posts, service pages, blog articles).
---

# WordPress Publishing Skill

Publish directly to a WordPress site's REST API using an Application
Password — a per-user, revocable credential built into WordPress core
(no plugin required, works on any self-hosted or Business-plan WP.com
site).

This skill manages **multiple businesses**, not just one — see
`../SITES.md` for the full list. Always pass `--site <slug>` explicitly
once more than one business has credentials configured, so a post never
lands on the wrong business's site.

---

## Operating rules — read first

1. **Confirm which business before doing anything**, if it isn't
   already obvious from context — check `../SITES.md` for the slug list
   rather than guessing or defaulting to whichever one was used last.
2. **Never invent credentials or guess a site URL.** If a business's
   `sites/<slug>.env` isn't set up yet, walk the user through the
   one-time setup below. Don't ask for the actual password to be pasted
   in chat if you can avoid it — prefer they create the file
   themselves, or paste it directly into a file you write (not into a
   message that becomes part of a shared transcript) if that's the only
   option available.
3. **Default new posts to `draft` status, not `publish`.** Only pass
   `--status publish` when the user explicitly says to publish
   immediately. Otherwise create a draft and give them the edit link so
   they can review in wp-admin first — this is especially important
   the first several times you use this skill, until trust is
   established.
4. **Read before you write.** Before updating an existing post/page,
   run `get-post` first and show the user what's there now if the
   change is substantive (not just a typo fix) — don't silently
   overwrite content you haven't looked at.
5. **Match the site's existing voice and structure.** Before drafting
   new content, pull 2-3 recent posts (`list-posts`) and skim them —
   tone, typical length, how services/pricing are described, any
   recurring calls-to-action (phone number, quote form). New content
   should read like it came from the same business, not a generic
   AI-written article.
6. **`RESULT:` lines are the canonical channel.** Every `wp_client.py`
   command prints one `RESULT: {...}` JSON line — parse that, not your
   own assumptions about whether something worked.

---

## One-time setup (per business)

1. **Generate an Application Password**: in that business's wp-admin,
   go to **Users → Profile** (or **Users → All Users → [user] → Edit**),
   scroll to **Application Passwords**, enter a name like "Claude
   publishing", click **Add New Application Password**. WordPress shows
   the password **once** — copy it immediately.
2. **Install dependencies** (once, shared across all businesses):
   ```bash
   pip install -r requirements.txt
   ```
3. **Configure credentials for this business**: copy
   `sites/<slug>.env.example` to `sites/<slug>.env` (using the slug from
   `../SITES.md`) and fill in `WP_SITE_URL`, `WP_USERNAME`, and
   `WP_APP_PASSWORD` (the space-separated password WordPress showed you
   — keep the spaces, they're part of it). Never commit `sites/*.env`.
4. **Verify**:
   ```bash
   python3 scripts/wp_client.py --site <slug> whoami
   ```
   A `RESULT` with your user info and capabilities means you're
   connected. If it 401s, double check the Application Password wasn't
   revoked and that the site doesn't sit behind an extra layer (some
   hosts block the REST API by default via security plugins — Wordfence
   and similar plugins have a setting to allow Application Password
   auth, or to allow the specific `/wp-json/` route).

---

## Common tasks

### Publish a new blog post/article

```bash
cat > /tmp/post_content.html <<'EOF'
<p>Opening paragraph...</p>
<h2>A subheading</h2>
<p>More content...</p>
EOF

python3 scripts/wp_client.py --site brackendownsplumber create-post \
  --title "5 Signs Your Geyser Needs Replacing" \
  --content-file /tmp/post_content.html \
  --status draft \
  --categories 3 \
  --tags 7,12
```

Use `list-categories` first if you don't know the category IDs. Content
is raw HTML (WordPress's editor stores/renders HTML) — use `<p>`,
`<h2>`/`<h3>`, `<ul>/<li>`, etc. Don't hand-roll Gutenberg block markup
unless the user specifically wants blocks; plain HTML renders fine in
the classic content pipeline and displays correctly either way for
paragraphs, headings and lists.

### Add a featured image

```bash
python3 scripts/wp_client.py upload-media --file /path/to/image.jpg --alt-text "Descriptive alt text"
# note the returned "id", then:
python3 scripts/wp_client.py create-post --title "..." --content-file ... --featured-media <id>
```

Always set `--alt-text` — it's both an accessibility requirement and
feeds image search/AI answer engines.

### Update an existing page (e.g. a service page)

```bash
python3 scripts/wp_client.py get-post --id 42          # read current content first
python3 scripts/wp_client.py update-post --id 42 --content-file /tmp/new_content.html
```

### List recent posts (to check cadence / match style)

```bash
python3 scripts/wp_client.py list-posts --limit 5 --status publish
```

---

## Writing content that actually helps SEO/AI-visibility

Since this feeds the same site covered by the agentic-website discussion
elsewhere in this conversation, keep new content aligned with that:

- **Answer a real, specific question** in the title and opening
  paragraph (matches how people actually search: "why is my geyser
  leaking" beats "Geyser Maintenance Tips").
- **Mention service area explicitly** (Bracken Downs, and nearby
  suburbs/towns you actually serve) — local relevance is a major
  ranking and AI-citation signal for a local trade business.
- **Include a clear call to action** — phone number or quote-request
  link — near the top and bottom of every post.
- **Don't fabricate statistics, certifications, or reviews.** If you
  don't have a real number, don't invent one — write it qualitatively
  instead or ask the user for the real figure.

---

## Quick reference

All commands take `--site <slug>` right after `wp_client.py` (see
`../SITES.md` for valid slugs) — omit only for quick single-site testing
via the fallback `./.env`.

```bash
python3 scripts/wp_client.py --site <slug> whoami
python3 scripts/wp_client.py --site <slug> list-posts --status draft --limit 10
python3 scripts/wp_client.py --site <slug> get-post --id 42
python3 scripts/wp_client.py --site <slug> create-post --title "..." --content-file /tmp/x.html --status draft
python3 scripts/wp_client.py --site <slug> update-post --id 42 --status publish
python3 scripts/wp_client.py --site <slug> upload-media --file image.jpg --alt-text "..."
python3 scripts/wp_client.py --site <slug> list-categories
```

Credentials: `sites/<slug>.env` in this skill's directory (`WP_SITE_URL`,
`WP_USERNAME`, `WP_APP_PASSWORD`) — never commit it. See `../SITES.md`
for the full business registry and onboarding steps for a new site.
