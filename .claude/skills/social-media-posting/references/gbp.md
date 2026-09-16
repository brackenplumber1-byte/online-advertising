# Google Business Profile setup and usage

## What you (the account owner) need to do first

This is the slowest of the three to set up — start it early and use
draft-only mode for GBP posts in the meantime.

1. **Verify your Business Profile is in good standing**: claimed,
   verified, and (per Google's stated prerequisites) generally
   expected to have been verified for a meaningful period — a brand
   new/unverified listing will not qualify for API access.
2. **Create a Google Cloud project**, enable the **Business Profile
   APIs** (Business Information API + the Business Profile Performance
   API; Local Posts live under the Business Information API's
   `localPosts` resource).
3. **Request API access**: Google gates this behind a manual approval
   — submit the request through Google's Business Profile API access
   request form, describing the use case plainly ("publish our own
   business's posts to our own verified profile"), expected call
   volume (low — a few posts a week), and confirm you have a valid
   business website. Approval can take anywhere from days to several
   weeks; there's no way to expedite it from this end.
4. Once approved, set up OAuth 2.0 credentials (Client ID/Secret) in
   the Cloud project and complete a one-time OAuth consent flow to get
   a refresh token for the Google account that manages the listing.
5. Find your **Account ID** and **Location ID**:
   ```
   GET https://mybusinessaccountmanagement.googleapis.com/v1/accounts
   GET https://mybusinessbusinessinformation.googleapis.com/v1/accounts/{accountId}/locations
   ```

## Configure

Add to `.env`:

```
GBP_ACCOUNT_ID=123456789
GBP_LOCATION_ID=987654321
GOOGLE_CLIENT_ID=...
GOOGLE_CLIENT_SECRET=...
GOOGLE_REFRESH_TOKEN=...
```

The script exchanges the refresh token for a short-lived access token
on each run — no need to manage access token expiry manually.

## How posting works

Local Posts live at:
```
POST https://mybusiness.googleapis.com/v4/accounts/{accountId}/locations/{locationId}/localPosts
{
  "languageCode": "en-ZA",
  "summary": "post text, ~1500 char max",
  "callToAction": {
    "actionType": "CALL",          // or BOOK, ORDER, SHOP, LEARN_MORE, SIGN_UP
    "url": "tel:+27XXXXXXXXX"      // required for all types except CALL, which uses the profile's listed phone number
  },
  "media": [{"mediaFormat": "PHOTO", "sourceUrl": "https://.../photo.jpg"}]
}
```

Front-load the key information in the first line or two — GBP truncates
long posts in the search-result card view. Always include a
`callToAction`; a post without one is a missed conversion opportunity
on a channel people are actively searching with intent.

## Running it

```bash
python3 scripts/gbp_post.py \
  --summary "Book your pre-winter geyser service now — avoid the cold-snap rush. Bracken Downs Plumber, on call 7 days." \
  --cta-type CALL \
  --image-url "https://brackendownsplumber.co.za/wp-content/uploads/2026/08/team-photo.jpg"
```

## Cadence note

GBP rewards steady posting more than a big monthly dump — aim for
roughly weekly, and treat this as a natural weekly slot in the
`content-calendar` skill's plan rather than saving it for a
once-a-month batch.

## Common errors

| Error | Meaning | Fix |
|---|---|---|
| `PERMISSION_DENIED` | API access not yet approved for this project, or the authenticated account doesn't manage this location | Confirm access request status; confirm the OAuth account is an actual manager/owner of the listing |
| `401` / refresh token invalid | Refresh token revoked or project's OAuth consent screen changed | Re-run the OAuth consent flow |
| Post accepted but not visible in Search quickly | Normal propagation delay | Check the Business Profile dashboard directly; give it some time before assuming failure |
