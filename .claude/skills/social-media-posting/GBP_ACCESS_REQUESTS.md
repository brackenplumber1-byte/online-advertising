# Google Business Profile API access — pending requests

Submitted 2026-08-26/27 via the Business Profile API allowlist flow
(support.google.com/business/contact/api_default), one per business since
each listing is managed under a different Google account. Shared Google
Cloud project ("My First Project") and OAuth client (Client ID/Secret
already saved in each business's `sites/<slug>.env`) — only the per-account
allowlist step needed repeating.

| Business | Case ID | Submitted | Status |
|---|---|---|---|
| brackendownsplumber | `8-9447000041546` | 2026-08-26 | Pending review (~7-10 business days) |
| 247plumbersgp | `2-2574000042213` | 2026-08-27 | Pending review (~7-10 business days) |
| mondeorplumbingservices | `9-5304000041498` | 2026-08-27 | Pending review (~7-10 business days) |

## Next steps once approved (per business)

1. Confirm approval — Google notifies via the account used to submit the
   request.
2. Run the one-time OAuth consent flow (Google OAuth Playground, same
   pattern as `google-search-console`) using the **same account that owns
   that specific listing** and the shared Client ID/Secret, requesting the
   `https://www.googleapis.com/auth/business.manage` scope.
3. Look up Account ID and Location ID:
   ```
   GET https://mybusinessaccountmanagement.googleapis.com/v1/accounts
   GET https://mybusinessbusinessinformation.googleapis.com/v1/accounts/{accountId}/locations
   ```
4. Fill in `GBP_ACCOUNT_ID`, `GBP_LOCATION_ID`, and `GOOGLE_REFRESH_TOKEN`
   in that business's `social-media-posting/sites/<slug>.env`.
5. Verify with a test post via `scripts/gbp_post.py`.

See `references/gbp.md` for the full reference.
