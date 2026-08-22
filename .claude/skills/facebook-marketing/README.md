# Facebook Marketing Skill

> **Let Claude Code create Facebook posts and run Facebook/Instagram ad
> campaigns for you**, via the official Meta Graph API and Marketing
> API — real OAuth login, drafts you approve before they go live, and
> ad objects that are always created paused so nothing spends money
> without your explicit go-ahead.

This skill teaches Claude Code (or any AI agent that can shell out) how
to:

- Log in to Facebook via a real OAuth consent screen (no scraping, no
  stored passwords) and cache a Page access token per Page you manage.
- Create, schedule, publish, list and delete Facebook Page posts —
  text, links, and photos.
- Build a full ad funnel — campaign → ad set → creative → ad — with
  budgets, targeting and objectives, always starting `PAUSED`.
- Turn campaigns on/off and pull performance insights (spend,
  impressions, clicks, CTR, CPC).

So you can say things like:

- *"Post 'Our fall sale starts today!' to my Page with a link to the
  sale page."*
- *"Schedule that post for 9am next Tuesday."*
- *"Set up a $20/day traffic campaign targeting US adults 25-45
  interested in outdoor gear, using this product photo."*
- *"How did last week's campaign perform?"*
- *"Pause campaign 12345."*

…and have it actually happen — with real spend always gated behind an
explicit confirmation step.

---

## Install

```bash
cd .claude/skills/facebook-marketing
pip install -r requirements.txt
cp .env.example .env
```

## One-time setup in the Meta dashboard

1. Go to [developers.facebook.com/apps](https://developers.facebook.com/apps)
   and create an app (type: **Business**).
2. Add the **Facebook Login** and **Marketing API** products.
3. Under *Facebook Login → Settings*, add this **Valid OAuth Redirect URI**:
   ```
   http://localhost:8765/callback
   ```
4. Copy the **App ID** and **App Secret** from *Settings → Basic* into
   your `.env` as `FB_APP_ID` / `FB_APP_SECRET`.
5. Make sure the Facebook account you'll log in with is an admin of
   both the app and the Page you want to post to.
6. If you want ads help too, find your **Ad Account ID** in
   [Meta Ads Manager](https://adsmanager.facebook.com) (Settings — it
   looks like `act_1234567890`) and put it in `.env` as
   `FB_AD_ACCOUNT_ID`.

> While the app is in Development mode, only accounts added as
> admins/developers/testers on the app can log in and manage the Page.
> Meta App Review is only needed if you want *other people's* Pages to
> connect — for using this on your own Page it's not required.

## Log in

```bash
python3 facebook_login.py --action login
```

This opens Facebook's real consent screen in your browser. Approve
the requested permissions (posting, ads management, insights) and the
script captures a long-lived (~60 day) user token plus a Page token
per Page you manage — Page tokens don't expire while the underlying
grant is valid. Everything is saved to `~/.facebook/tokens.json`
(override the location with `FACEBOOK_HOME`). Re-running the command
later is instant if the saved token is still valid — no browser opens.

## Use it with Claude Code

Once installed, just talk to Claude naturally in this repo/session —
e.g. *"post this to my Facebook Page"* or *"set up a Facebook ad
campaign for our new product"* — and Claude will follow the playbook
in `SKILL.md`, which includes hard safety rails (draft-before-publish
for posts, paused-until-approved for anything that spends money).

You can also call the scripts directly:

```bash
python3 facebook_post.py --action create --message "Hello world!" --publish-now
python3 facebook_ads.py --action list --of campaigns
```

Every script prints one `RESULT: {...}` JSON line — that's the
machine-readable output; everything else on stderr is just logging.

---

## Files

```
facebook_common.py   # shared config, token store, Graph API request wrapper
facebook_login.py    # OAuth login (idempotent), token check, Page-token listing
facebook_post.py      # create/list/get/publish/delete Page posts
facebook_ads.py        # campaigns/ad sets/creatives/ads/insights/status changes
SKILL.md               # the playbook Claude follows — safety rules + decision tree
.env.example            # copy to .env and fill in
```

## Security notes

- `~/.facebook/tokens.json` holds live access tokens — treat it like a
  password file. It's gitignored by default; never commit it.
- Ad objects (campaigns, ad sets, ads) are **always created `PAUSED`**.
  The scripts refuse to create them any other way. Only
  `--action update-status --status ACTIVE --confirm-spend` turns
  spend on, and that's meant to be run only after you've reviewed the
  budget and targeting.
- Posts are created as **unpublished drafts by default** — nothing
  goes live until you (or Claude, after you approve) calls
  `--action publish` or passes `--publish-now`.
- This skill only talks to `graph.facebook.com`. No third-party
  telemetry, no other network calls.
