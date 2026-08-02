# Meta (Facebook + Instagram) setup and usage

## What you (the account owner) need to do first

1. **Create a Meta developer app**: go to
   [developers.facebook.com](https://developers.facebook.com) → My Apps
   → Create App → choose "Business" type.
2. **Make sure your Instagram account is a Professional account**
   (Business or Creator) and is linked to a Facebook Page you admin.
   Personal Instagram accounts cannot use the publishing API at all —
   convert in the Instagram app under Settings → Account first.
3. **Get a Page Access Token** with `pages_show_list`,
   `pages_read_engagement`, and `pages_manage_posts` (for Facebook
   posting), plus `instagram_basic` and `instagram_content_publish`
   (for Instagram posting). In Meta's Graph API Explorer or via the
   Business Settings → System Users flow, generate a **long-lived**
   Page access token (short-lived ones expire in ~1 hour; exchange for
   a long-lived one, which lasts ~60 days and can be refreshed).
4. **App Review**: for anything beyond posting to Pages/IG accounts
   you personally admin (i.e. this is your own business's Page, which
   is the normal case here), Meta allows Development Mode testing with
   admins/testers on the app without full review. If you hit
   permission errors, you may need to submit the relevant permissions
   for App Review — Meta's dashboard tells you exactly which
   permission is missing when a call is rejected.
5. **Find your IDs**: your Page ID (Page → About → Page ID, or via
   `GET /me/accounts` with a User token) and your Instagram Business
   Account ID (`GET /{page-id}?fields=instagram_business_account` with
   the Page token).

## Configure

Add to `.env` (see `.env.example` in this skill's root):

```
META_PAGE_ID=your-facebook-page-id
META_PAGE_ACCESS_TOKEN=your-long-lived-page-token
META_IG_USER_ID=your-instagram-business-account-id
```

## How posting works

**Facebook Page post** — single call:
```
POST https://graph.facebook.com/v21.0/{page-id}/feed
  message=<text>
  access_token=<page token>
```

**Instagram post** — two-step (Instagram has no direct "post text+image
in one call"):
1. Create a media container:
   ```
   POST https://graph.facebook.com/v21.0/{ig-user-id}/media
     image_url=<publicly reachable image URL>
     caption=<text>
     access_token=<page token>
   ```
   (Use `video_url` instead of `image_url` for Reels/video, with
   `media_type=REELS`.)
2. Publish the container:
   ```
   POST https://graph.facebook.com/v21.0/{ig-user-id}/media_publish
     creation_id=<id from step 1>
     access_token=<page token>
   ```

The image must be reachable at a public URL Meta's servers can fetch —
a local file path won't work. If the image only exists locally (e.g. a
job photo), upload it somewhere reachable first (the WordPress media
library from the `wordpress-publishing` skill works well for this,
since `upload-media` returns a public `source_url`).

## Running it

```bash
python3 scripts/meta_post.py facebook --message "Winter's coming — book your geyser service before the cold snap. Call us on 0XX XXX XXXX."

python3 scripts/meta_post.py instagram --image-url "https://brackendownsplumber.co.za/wp-content/uploads/2026/08/job-photo.jpg" --caption "Before and after: full geyser replacement in Bracken Downs today. #plumbing #geyser #brackendowns"
```

## Common errors

| Error | Meaning | Fix |
|---|---|---|
| `(#200) requires ... permission` | Missing scope on the token | Regenerate the token including that permission |
| `OAuthException ... session has expired` | Page token expired | Generate a new long-lived token (they last ~60 days) |
| Instagram publish fails with "media not ready" | Container still processing (common for video) | Poll the container's status field before calling `media_publish`, or retry after a short delay |
| `instagram_content_publish` missing | App not yet reviewed for this permission | Submit for App Review, or use draft-only mode until approved |
