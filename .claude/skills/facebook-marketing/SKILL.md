---
name: facebook-marketing
description: |
  Connect to a Facebook Page, a linked Instagram Business account, and
  an Ad Account via the Meta Graph & Marketing APIs so Claude can help
  create/schedule Facebook posts, publish to Instagram, and build/
  manage Facebook & Instagram ad campaigns (campaigns, ad sets,
  creatives, ads, budgets, targeting, insights). Use this skill
  whenever the user asks to "post to Facebook", "post to Instagram",
  "schedule a post", "create a Facebook ad", "run Facebook ads",
  "check ad performance/insights", "pause my ads", or similar for
  Facebook/Instagram/Meta.
---

# Facebook Marketing Skill — playbook for Claude

Your job is to help the user **publish Facebook Page content**,
**publish to a linked Instagram account**, and **run Facebook/
Instagram ad campaigns** through the Meta Graph API, the Instagram
Graph API, and the Marketing API, on their behalf.

---

## Operating rules — READ THIS FIRST, THEN FOLLOW IT EVERY TURN

1. **Two very different risk levels live in this one skill.** Posting
   content is reversible (you can delete a post) and mostly cost-free.
   Running ads spends **real money** the moment an object goes
   `ACTIVE`. Treat them differently:
   - Posts: draft first, show the user, then publish. Low ceremony.
   - Ads: PAUSED is the only state anything is ever created in. Never
     set `--status ACTIVE` (or pass `--confirm-spend`) without the
     user explicitly approving the specific budget, schedule and
     targeting you're about to activate, in this conversation, for
     this object. "Set up a campaign for me" is not approval to
     activate it — it's approval to build it PAUSED and show you.

2. **`RESULT:` lines are the canonical channel.** Every script emits
   one JSON line prefixed with `RESULT: `. Parse it; ignore stderr
   logs (those are for the human). Never invent post IDs, campaign
   IDs, ad set IDs, ad IDs, image hashes, or insight numbers — if you
   didn't see it in a `RESULT:` line, you don't know it.

3. **Login is idempotent and mostly browser-free.** Run
   `python3 facebook_login.py --action login`. If a saved user token
   still validates, it skips the browser entirely and just refreshes
   Page tokens. A browser only opens the first time, or after
   `--force`, or once the ~60-day token expires.
   **If you're in an agent environment without a visible GUI** and a
   browser does need to open: STOP and tell the user to run
   `python3 facebook_login.py --action login` in their own terminal
   on their own machine once. After that, the saved tokens under
   `~/.facebook/` work from anywhere (copy the folder, or set
   `FACEBOOK_HOME` to point at it) — but don't ask the user to hand
   you tokens over chat; have them run the script locally.

4. **Never guess a Page ID or Ad Account ID.** If `FB_PAGE_ID` /
   `FB_AD_ACCOUNT_ID` aren't set and the user hasn't named one, run
   `facebook_login.py --action pages` to list the Pages available and
   ask the user which one, and ask for the ad account id (visible in
   Meta Ads Manager's URL / account settings) before proceeding.

5. **Ads targeting must be explicit.** `facebook_ads.py create-adset`
   refuses to run without either a `--targeting` JSON blob or
   `--targeting-default-ack` (an explicit opt-in to the broad "US,
   18-65" fallback). Always ask the user who they're trying to reach
   (locations, age range, interests) rather than defaulting silently.

6. **Special ad categories are a real legal requirement.** If the ad
   is about credit, employment, housing, or social issues/elections,
   pass `--special-ad-categories CREDIT|EMPLOYMENT|HOUSING|...` — Meta
   enforces restricted targeting for these and mis-declaring them can
   get the ad account restricted. Ask the user if you're not sure the
   product/service falls outside these categories.

---

## Tooling overview

```
facebook_login.py   # OAuth login (idempotent), token check, list/refresh Page tokens
facebook_post.py     # create (draft/schedule/publish), list, get, delete Page posts
instagram_post.py     # create (container/publish), list, get, delete Instagram media
facebook_ads.py         # campaigns, ad sets, creatives, ads, insights, status changes
```

All tokens live under `~/.facebook/tokens.json` (override with
`FACEBOOK_HOME`). Never print or commit this file's contents — it
holds live access tokens.

---

## Setup (once per user)

1. **Meta App** — the user needs an app at
   [developers.facebook.com/apps](https://developers.facebook.com/apps)
   with the "Facebook Login" and "Marketing API" products added, and
   `http://localhost:8765/callback` set as a Valid OAuth Redirect URI.
   This is a one-time thing only a human can do (it requires clicking
   through Meta's dashboard). If the user doesn't have one yet, walk
   them through creating it before running anything.
2. Copy `.env.example` to `.env` and fill in `FB_APP_ID` /
   `FB_APP_SECRET` from that app.
3. `pip install -r requirements.txt`
4. `python3 facebook_login.py --action login` — opens a consent
   screen in the user's browser, then saves a long-lived user token
   plus a non-expiring token per Page they manage.
5. `python3 facebook_login.py --action pages` any time you need to
   confirm which Page IDs are available, or to re-list them without a
   full re-login.
6. Ask the user for their Ad Account ID (from Meta Ads Manager) if
   they want ads help, and optionally save `FB_PAGE_ID` /
   `FB_AD_ACCOUNT_ID` in `.env` so you don't have to pass them every
   command.
7. **For Instagram**, the user needs an Instagram **Business or
   Creator** account (not personal) linked to the Facebook Page —
   done in the Instagram app under Settings and privacy → Account
   type and tools → Business, then linking it to the Page from that
   same menu. Once linked, run
   `python3 facebook_login.py --action instagram` to discover and
   save the linked account. If it reports no linked account, walk the
   user through linking it before trying `instagram_post.py`.

---

## Decision tree — what to do based on what the user asks

| User intent | What to run |
|---|---|
| "Connect my Facebook" / first time | Setup steps above |
| "Post X to my Page" | `facebook_post.py --action create --message "..."` (draft by default) → show the user → `--action publish --post-id <id>` on approval |
| "Schedule a post for [time]" | `create --message "..." --scheduled-time 2026-09-01T15:00:00` |
| "Post this image with caption X" | `create --message "X" --image /path/or/url` |
| "What have I posted recently?" | `facebook_post.py --action list --include-drafts` |
| "How did that post do?" | `facebook_post.py --action get --post-id <id>` (likes/comments/shares) |
| "Delete that post" | `facebook_post.py --action delete --post-id <id>` — confirm with the user first, this is permanent |
| "Post X to Instagram" / "post this photo to Instagram" | `instagram_post.py --action create --image <public-url> --caption "..."` (creates a container, doesn't go live) → show the user → `--action publish --container-id <id>` on approval |
| "Post a reel" | `create --video <public-url> --reels --caption "..."` then publish once approved |
| "What have I posted on Instagram?" | `instagram_post.py --action list` |
| "Set up a Facebook ad campaign for X" | Walk the full ad build (below) — ends PAUSED, ask before activating |
| "How are my ads doing?" / "check performance" | `facebook_ads.py --action insights --level campaign --id <id>` (or `--level account`) |
| "Pause/resume campaign N" | `facebook_ads.py --action update-status --id <id> --status PAUSED` (resume needs `--status ACTIVE --confirm-spend` + explicit approval) |
| "Delete that campaign/ad" | `facebook_ads.py --action delete --id <id>` — confirm first, this is permanent |

---

## Publishing a post

```bash
# Draft (default) — nothing goes live yet
python3 facebook_post.py --action create --message "Announcing our fall sale!" --link https://example.com/sale

# Photo post
python3 facebook_post.py --action create --message "New arrivals 🎉" --image ./photo.jpg

# Scheduled (10 min to ~6 months out)
python3 facebook_post.py --action create --message "See you at the expo!" --scheduled-time 2026-09-10T09:00:00

# Publish a draft once the user approves it
python3 facebook_post.py --action publish --post-id <id>

# Or skip the draft step entirely once the user has explicitly said "post it now"
python3 facebook_post.py --action create --message "..." --publish-now
```

Always show the user the exact `message`/`link`/`image` and, for
scheduled posts, the resolved local time, before calling `publish` or
using `--publish-now`.

---

## Publishing to Instagram

Instagram has no text-only posts and no native "draft" — publishing is
inherently two steps: create a media container (safe, not live), then
publish it (goes live). Treat `create` like a draft and always confirm
with the user before `publish`.

**Image/video must be a public URL** — Instagram's API can't accept a
local file upload directly the way `facebook_post.py --image` can. If
the user only has a local file, ask them to host it somewhere public
first (their website, a public S3/Cloudinary link, etc.) — do not
invent or guess a URL.

```bash
# 1. Create the container (not live yet)
python3 instagram_post.py --action create --image https://example.com/job-photo.jpg --caption "New arrivals 🎉"

# 2. Show the caption + image to the user, then publish on approval
python3 instagram_post.py --action publish --container-id <container_id>

# Reels / video (processing can take a while — poll before publishing)
python3 instagram_post.py --action create --video https://example.com/clip.mp4 --reels --caption "..."
python3 instagram_post.py --action publish --container-id <container_id> --wait-ready 60

# List / inspect
python3 instagram_post.py --action list
python3 instagram_post.py --action get --media-id <id>
python3 instagram_post.py --action delete --media-id <id>   # confirm with the user first, permanent
```

---

## Building an ad campaign (full flow)

Walk these steps in order. Confirm budget + targeting with the user
before step 7 (activation) — everything up to and including step 6
only creates PAUSED objects that cost nothing.

```bash
# 1. Campaign — the objective drives what optimization goals are valid later
python3 facebook_ads.py --action create-campaign \
  --name "Fall Sale 2026" --objective OUTCOME_TRAFFIC

# 2. Ad set — budget, schedule, targeting, optimization goal
python3 facebook_ads.py --action create-adset \
  --campaign-id <campaign_id> --name "US 25-45 interest: outdoor gear" \
  --daily-budget 2000 --billing-event IMPRESSIONS --optimization-goal LINK_CLICKS \
  --targeting '{"geo_locations":{"countries":["US"]},"age_min":25,"age_max":45,"interests":[{"id":"6003139266461","name":"Outdoor recreation"}]}' \
  --start-time 2026-09-01T00:00:00

# 3. (Optional) Upload a local image for the creative
python3 facebook_ads.py --action upload-image --file ./ad-photo.jpg
# -> use the returned image_hash below

# 4. Creative — what the ad actually looks like
python3 facebook_ads.py --action create-creative \
  --page-id <page_id> --name "Fall Sale Creative A" \
  --message "Our biggest sale of the year is here." --link https://example.com/sale \
  --image-hash <hash_from_step_3> --call-to-action SHOP_NOW

# 5. Ad — links the ad set + creative
python3 facebook_ads.py --action create-ad \
  --adset-id <adset_id> --creative-id <creative_id> --name "Fall Sale Ad A"

# 6. Show the user everything: campaign/adset/ad IDs, budget, targeting, creative text/image.
#    Ask: "Ready to make this live? It will start spending up to $20/day."

# 7. ONLY after explicit approval:
python3 facebook_ads.py --action update-status --id <campaign_id> --status ACTIVE --confirm-spend
python3 facebook_ads.py --action update-status --id <adset_id> --status ACTIVE --confirm-spend
```

Note: `--daily-budget`/`--lifetime-budget` are in the ad account's
**smallest currency unit** (cents for USD) — `2000` means $20.00/day.
Always state the real-world amount back to the user in their currency
before they approve.

---

## Checking performance

```bash
python3 facebook_ads.py --action insights --level campaign --id <campaign_id> --date-preset last_7d
python3 facebook_ads.py --action insights --level account --date-preset last_30d
python3 facebook_ads.py --action list --of campaigns   # or adsets / ads, to find IDs + effective_status
```

Summarize spend, impressions, clicks, CTR and CPC in plain language —
don't just dump the JSON on the user.

---

## Common error patterns and how to handle them

| `RESULT.error` contains... | Meaning | Action |
|---|---|---|
| `No Facebook access token found` | Never logged in / token expired | Run `facebook_login.py --action login` |
| `No Page ID given` | `FB_PAGE_ID` unset, no `--page-id` | Run `facebook_login.py --action pages`, ask the user which Page |
| `No ad account id given` | `FB_AD_ACCOUNT_ID` unset | Ask the user for their Ad Account ID from Ads Manager |
| `Setting status=ACTIVE will start real ad spend` | You forgot `--confirm-spend` or, more likely, you forgot to actually get user approval first | Get explicit approval, then pass `--confirm-spend` |
| `No --targeting given` | You tried to create an ad set without specifying who to target | Ask the user, build a `--targeting` JSON blob, or get an explicit "yes, use the broad default" |
| `state mismatch (possible CSRF)` | OAuth redirect didn't match what was sent | Re-run `facebook_login.py --action login` |
| Graph API error `OAuthException` | Token expired/invalid/missing a permission | Re-run login; check `--action check` for granted scopes |
| Graph API error mentioning `special_ad_categories` | Ad content likely falls under Housing/Employment/Credit/Social Issues rules | Ask the user, set `--special-ad-categories` accordingly |
| `No Instagram Business account id found` | Instagram not linked, or not yet discovered | Run `facebook_login.py --action instagram`; if it reports none linked, walk the user through switching to Business/Creator and linking the Page |
| `--image must be a public URL` (Instagram) | You passed a local file path | Ask the user for a public URL, or have them upload the image somewhere reachable first |
| `media not ready` / container `status_code=IN_PROGRESS` (Instagram) | Video/Reel still processing | Retry `--action publish` shortly, or use `--wait-ready N` |

---

## Things you should NEVER do

* **Never set an ad object to `ACTIVE` without the user explicitly
  approving that specific budget/targeting/creative in this
  conversation.** "Build me a campaign" ≠ "spend my money."
* **Never invent Page IDs, Ad Account IDs, post IDs, campaign/ad
  set/ad/creative IDs, image hashes, or insight numbers.** Only use
  values that came back in a `RESULT:` line.
* **Never publish a post immediately without showing the draft text
  (and image/link) to the user first**, unless they've already told
  you explicitly to post it live. This applies to Instagram containers
  too — never `--action publish` without showing the caption/media
  first.
* **Never invent or guess a public URL for an Instagram image/video.**
  If the user only has a local file, ask them to host it and give you
  the real URL.
* **Never commit or paste `~/.facebook/tokens.json` contents** — it's
  a live credential, equivalent to a password.
* **Never silently default ad targeting.** Ask, or require the
  explicit `--targeting-default-ack` opt-in.
* **Never delete a post or ad object without confirming with the user
  first** — deletion is permanent.

---

## Quick reference — every command

```bash
# Login / tokens
python3 facebook_login.py --action login                 # idempotent; skips browser if token still valid
python3 facebook_login.py --action login --force         # force a fresh browser login
python3 facebook_login.py --action check                 # debug the current token (validity, scopes, expiry)
python3 facebook_login.py --action pages                 # list Pages + (re)save their Page tokens
python3 facebook_login.py --action instagram              # discover + save Instagram accounts linked to each Page

# Posts (Facebook)
python3 facebook_post.py --action create --message "..." [--link URL] [--image PATH_OR_URL] [--scheduled-time ISO] [--publish-now]
python3 facebook_post.py --action publish --post-id ID
python3 facebook_post.py --action list [--include-drafts] [--limit N]
python3 facebook_post.py --action get --post-id ID
python3 facebook_post.py --action delete --post-id ID

# Posts (Instagram)
python3 instagram_post.py --action create --image PUBLIC_URL --caption "..."      # or --video URL [--reels]
python3 instagram_post.py --action publish --container-id ID [--wait-ready SECONDS]
python3 instagram_post.py --action status --container-id ID
python3 instagram_post.py --action list [--limit N]
python3 instagram_post.py --action get --media-id ID
python3 instagram_post.py --action delete --media-id ID

# Ads
python3 facebook_ads.py --action create-campaign --name "..." --objective OUTCOME_TRAFFIC
python3 facebook_ads.py --action create-adset --campaign-id ID --name "..." \
    --daily-budget 2000 --billing-event IMPRESSIONS --optimization-goal LINK_CLICKS \
    --targeting '{"geo_locations":{"countries":["US"]}}'
python3 facebook_ads.py --action upload-image --file ./photo.jpg
python3 facebook_ads.py --action create-creative --page-id ID --name "..." --message "..." --link URL --image-hash HASH
python3 facebook_ads.py --action create-ad --adset-id ID --creative-id ID --name "..."
python3 facebook_ads.py --action list --of campaigns|adsets|ads
python3 facebook_ads.py --action insights --level account|campaign|adset|ad --id ID --date-preset last_7d
python3 facebook_ads.py --action update-status --id ID --status ACTIVE|PAUSED|ARCHIVED --confirm-spend  # confirm-spend only needed for ACTIVE
python3 facebook_ads.py --action delete --id ID
```

State directory: `~/.facebook/` (override with `FACEBOOK_HOME` env var).
