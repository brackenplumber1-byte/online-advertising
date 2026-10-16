# LinkedIn setup and usage

## Two very different scopes — figure out which one you need

- **Posting as yourself (personal profile)**: needs only the
  `w_member_social` scope via standard OAuth 2.0 self-serve developer
  access. No special product approval needed. Fast to set up.
- **Posting as the business (Company Page)**: needs
  `w_organization_social`, which requires LinkedIn's **Community
  Management API** (formerly reached via the Marketing Developer
  Platform) — this requires a registered company, a verified Company
  Page, and LinkedIn's own review process (can take a couple of weeks,
  sometimes longer, and LinkedIn evaluates the use case). This is the
  one most businesses actually want, but it's the slower path.

Confirm with the user which one they mean — "post on LinkedIn" often
means the Company Page, which is the harder setup.

## What you (the account owner) need to do first

1. Create a LinkedIn developer app at
   [linkedin.com/developers](https://www.linkedin.com/developers/apps).
2. For personal posting: request the `w_member_social` scope, run the
   OAuth 2.0 3-legged flow (LinkedIn does not support simple API
   keys), get an access token.
3. For Company Page posting: apply for Community Management API
   access from the app's Products tab, associate the app with your
   verified Company Page, and complete LinkedIn's review (they'll ask
   about your use case — "publishing our own business's marketing
   content to our own Company Page" is a normal, approvable case, but
   budget for the wait).
4. Find your author URN: for personal, `urn:li:person:{id}` (from
   `GET /v2/userinfo` with `openid` scope, or the legacy `/v2/me`);
   for organization, `urn:li:organization:{id}` (Page admin view shows
   the numeric ID in the URL, or via `GET /v2/organizationAcls`).

## Configure

Add to `.env`:

```
LINKEDIN_ACCESS_TOKEN=your-oauth-access-token
LINKEDIN_AUTHOR_URN=urn:li:organization:12345678
```

(Swap to `urn:li:person:...` for personal-profile posting instead.)

## How posting works

LinkedIn's current **Posts API** (`/rest/posts`) replaced the older
UGC/Shares APIs. A basic text post:

```
POST https://api.linkedin.com/rest/posts
Headers:
  Authorization: Bearer <token>
  LinkedIn-Version: 202601          # use the current version string from LinkedIn's docs
  X-Restli-Protocol-Version: 2.0.0
Body:
{
  "author": "urn:li:organization:12345678",
  "commentary": "post text here",
  "visibility": "PUBLIC",
  "distribution": {"feedDistribution": "MAIN_FEED"},
  "lifecycleState": "PUBLISHED"
}
```

For an image post, first register and upload the image via the Images
API (`POST /rest/images?action=initializeUpload`, then PUT the binary
to the returned upload URL), then reference the returned image URN in
`content.media.id`.

## Running it

```bash
python3 scripts/linkedin_post.py --text "Winter is coming — now's the time to get your geyser serviced before the cold snap hits. Bracken Downs Plumber, on call for emergencies too."

python3 scripts/linkedin_post.py --text "Job of the week: full geyser replacement in Bracken Downs." --image /path/to/job-photo.jpg
```

## Common errors

| Error | Meaning | Fix |
|---|---|---|
| `ACCESS_DENIED` on `/rest/posts` for an organization URN | App doesn't have Community Management API product access yet | Check application status in the LinkedIn developer portal; use draft-only mode meanwhile |
| `401 Unauthorized` | Token expired (LinkedIn tokens are typically valid ~60 days) | Re-run the OAuth flow to get a fresh token |
| `LinkedIn-Version` header rejected/outdated | LinkedIn versions its API by date string | Check LinkedIn's current API version docs and update the header |
