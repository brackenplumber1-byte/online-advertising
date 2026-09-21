# Google Business Profile API access — pending requests

Submitted 2026-08-26/27 via the Business Profile API allowlist flow
(support.google.com/business/contact/api_default), one per business since
each listing is managed under a different Google account. Shared Google
Cloud project ("My First Project") and OAuth client (Client ID/Secret
already saved in each business's `sites/<slug>.env`) — only the per-account
allowlist step needed repeating.

| Business | Case ID | Submitted | Status |
|---|---|---|---|
| brackendownsplumber | `8-9447000041546` | 2026-08-26 | Case approved 2026-09-20, but project not allowlisted (see note below) |
| 247plumbersgp | `2-2574000042213` | 2026-08-27 | Case approved 2026-09-20, but project not allowlisted (see note below) |
| mondeorplumbingservices | `9-5304000041498` | 2026-08-27 | Case approved 2026-09-20, but project not allowlisted — new "Application for Basic API Access" submitted 2026-09-21, pending |

## IMPORTANT correction (found 2026-09-21)

The original case approval and the actual Cloud **project allowlist are two
separate things**. New OAuth clients had to be created this session in
project **"My First Project" (project number `426535437421`)** — since
that project didn't exist with any OAuth clients at the time the original
3 cases were submitted/approved, it is NOT the project those approvals
allowlisted. Calling `mybusinessaccountmanagement.googleapis.com` from
this project returns `429 RESOURCE_EXHAUSTED` with `quota_limit_value: 0`,
and Google's own quota-increase form states: *"If your current quota is
now set at 0, you are not yet allowlisted and should instead select
'Application for Basic API Access'"* via
support.google.com/business/contact/api_default.

**Fix per business**: submit a fresh "Application for Basic API Access"
request through that same contact form, referencing the business's
already-approved case ID above AND explicitly stating Cloud **Project
Number `426535437421`** needs to be allowlisted. Submitted for
mondeorplumbingservices 2026-09-21 — still needed for brackendownsplumber
and 247plumbersgp.

## Next steps once a business's project allowlist request is approved

1. Confirm approval — Google notifies via the account used to submit the
   request.
2. Run the one-time OAuth consent flow (Google OAuth Playground, same
   pattern as `google-search-console`) using the **same account that owns
   that specific listing** and the shared Client ID/Secret (a **Web
   application** type OAuth client, with
   `https://developers.google.com/oauthplayground` added as an Authorized
   redirect URI — a Desktop app client does NOT work for this), requesting
   the `https://www.googleapis.com/auth/business.manage` scope. That
   Google account must also be added as a Test user under Audience on the
   OAuth consent screen (the app is in Testing mode).
3. Look up Account ID and Location ID:
   ```
   GET https://mybusinessaccountmanagement.googleapis.com/v1/accounts
   GET https://mybusinessbusinessinformation.googleapis.com/v1/accounts/{accountId}/locations
   ```
4. Fill in `GBP_ACCOUNT_ID`, `GBP_LOCATION_ID`, and `GOOGLE_REFRESH_TOKEN`
   in that business's `social-media-posting/sites/<slug>.env`.
5. Verify with a test post via `scripts/gbp_post.py`.

See `references/gbp.md` for the full reference.
