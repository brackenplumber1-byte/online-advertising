# 247plumbers social bot

Claude-powered bot for 247 Plumbers' Facebook Page and Instagram Business
account. It does four things:

1. **Content posting** — you give it a topic, Claude drafts a caption for
   Facebook and/or Instagram, you review it, then it publishes via the Meta
   Graph API.
2. **Comment auto-reply** — replies to comments on posts/ads with a
   Claude-drafted response.
3. **DM auto-reply** — same, for Facebook Messenger and Instagram Direct.
4. **Lead capture & routing** — any comment/DM that looks like a real
   service request (or an emergency) is logged to `leads/leads.jsonl` and,
   if SMTP is configured, emailed to you immediately.

**Safety default:** comment/DM replies are drafted but *not* auto-sent
until you set `AUTO_SEND_REPLIES=true` in `.env`. Until then they queue up
as drafts (`python main.py list`) for a human to approve and send with
`python main.py publish <id>`. Leads are always captured either way. Run
this way for a while first — a bot talking to real customers on a live
business page deserves a trial period.

## 1. Set up the Meta app

1. Make sure the Facebook Page is a **Page** (not a personal profile) and
   the Instagram account is a **Professional (Business/Creator) account**
   linked to that Page (Page Settings → Linked Accounts → Instagram).
2. Go to [developers.facebook.com/apps](https://developers.facebook.com/apps)
   → **Create App** → type **Business**.
3. Add these products to the app: **Webhooks**, **Messenger**,
   **Instagram Graph API**.
4. Under **App Settings → Basic**, copy the **App Secret** → `APP_SECRET`
   in `.env`.
5. Generate a **Page access token**:
   - Quickest for testing: Graph API Explorer → select the app → select
     the Page → generate a token with scopes `pages_show_list`,
     `pages_manage_posts`, `pages_read_engagement`, `pages_manage_engagement`,
     `pages_messaging`, `instagram_basic`, `instagram_manage_comments`,
     `instagram_manage_messages`, `instagram_content_publish`.
   - For production, create a **System User** in Business Manager, assign
     it the Page + Instagram account, generate a token there, then exchange
     it for a **long-lived token** (Meta's tokens otherwise expire in ~60
     days — see "Access Token Debugger" and "long-lived token" in Meta's
     docs to convert).
   - Put that token in `PAGE_ACCESS_TOKEN`.
6. Fill in `PAGE_ID` and `IG_USER_ID` in `.env`. You can get `IG_USER_ID`
   from `GET /{page-id}?fields=instagram_business_account` once you have a
   Page token — `python main.py doctor` will also try this for you.
7. The app will need **App Review** for these permissions before it can
   go live for real (non-admin) traffic — Meta's docs walk through what
   each permission requires (screencast, use-case description, etc.).
   Development mode works fine for testing with your own admin account.

## 2. Configure

```bash
cd bots/247plumbers
python3 -m venv .venv && source .venv/bin/activate
pip install -r requirements.txt
cp .env.example .env
# fill in .env: ANTHROPIC_API_KEY, PAGE_ACCESS_TOKEN, PAGE_ID, IG_USER_ID,
# APP_SECRET, WEBHOOK_VERIFY_TOKEN, and the BUSINESS_* facts.
python main.py doctor
```

`doctor` checks every required env var and pings the Graph API to confirm
the Page token and Instagram linkage actually work.

## 3. Content posting

```bash
python main.py generate --topic "reminder to flush water heaters before winter" \
  --platforms facebook instagram --image-url https://247plumbers.com/img/heater.jpg

python main.py show <draft-id>       # review the caption(s)
python main.py publish <draft-id>    # goes live
```

Instagram requires a publicly reachable image URL (the Graph API fetches
it server-side) — this bot doesn't generate or host images, so point
`--image-url` at something already hosted (your website, an S3/CDN URL,
etc). Facebook posts can be text-only.

## 4. Comment & DM auto-reply + lead capture

This needs a public HTTPS endpoint for Meta to send webhook events to.

```bash
python main.py run-server --port 8080
```

For local testing, expose it with a tunnel (`ngrok http 8080` or similar)
and use the `https://...ngrok...` URL below. For production, deploy this
behind a real domain with TLS (any small VM or container host works —
there's nothing Facebook-specific about the deployment).

In the Meta App Dashboard → **Webhooks**:
- Callback URL: `https://<your-domain>/webhook`
- Verify Token: whatever you set as `WEBHOOK_VERIFY_TOKEN` in `.env`
- Subscribe the **Page** object to: `feed`, `messages`
- Subscribe the **Instagram** object to: `comments`, `messages`
- Subscribe your Page to the app (Webhooks page → "Page Subscriptions")

Once subscribed, every new comment or DM triggers:
`webhook_server.py` → `reply_generator.py` (Claude drafts a reply +
classifies it as a lead/emergency) → `leads.py` (if it's a lead) →
either an auto-send via `meta_client.py` or a queued draft, depending on
`AUTO_SEND_REPLIES`.

```bash
python main.py list --status draft   # pending reply drafts awaiting approval
python main.py publish <draft-id>    # sends that one reply
python main.py leads                 # everything captured as a lead so far
```

## Files

| File | Purpose |
|---|---|
| `config.py` | Loads `.env`, exposes `config` + `config.brand` (business facts) |
| `meta_client.py` | Graph API calls: publish posts, reply to comments, send DMs |
| `content_generator.py` | Claude → post captions |
| `reply_generator.py` | Claude → comment/DM replies + lead/emergency classification |
| `leads.py` | Appends to `leads/leads.jsonl`, optional SMTP notification |
| `drafts.py` | JSON draft files under `drafts/` for posts and pending replies |
| `webhook_server.py` | Flask receiver for Meta webhook events |
| `main.py` | CLI wiring all of the above together |

## Notes / things to verify before going live

- The Graph API version and payload shapes here (`GRAPH_API_VERSION=v21.0`)
  match Meta's docs as of the time this was written — Meta does deprecate
  API versions on a schedule, so if `doctor` or a webhook call starts
  failing with a deprecation error, bump `GRAPH_API_VERSION` and check
  https://developers.facebook.com/docs/graph-api/changelog.
- `reply_generator.py` is instructed never to invent facts (pricing, ETA,
  technician names) and to push emergencies straight to the phone number
  rather than let the bot handle them — double check `BUSINESS_*` values in
  `.env` are accurate, since that's the bot's only source of truth.
- Nothing here auto-approves App Review permissions or exchanges a
  short-lived token for a long-lived one automatically — both are one-time
  manual steps in Meta's dashboard/docs linked above.
