"""Thin wrapper around the Meta Graph API for the pieces this bot needs:
publishing posts, replying to comments, and sending DMs on Facebook Page
and Instagram Business accounts.

Endpoints used (verify against https://developers.facebook.com/docs when
Meta ships breaking changes to the Graph API — these are correct as of
API v21.0):

  Publish Facebook photo post   POST /{page-id}/photos
  Publish Facebook text post    POST /{page-id}/feed
  Reply to a Facebook comment   POST /{comment-id}/comments
  Create IG media container     POST /{ig-user-id}/media
  Publish IG media container    POST /{ig-user-id}/media_publish
  Reply to an IG comment        POST /{ig-comment-id}/replies
  Send a DM (Messenger + IG)    POST /me/messages   (unified Send API)
"""
from __future__ import annotations

import json

import requests

from config import config


class MetaAPIError(RuntimeError):
    def __init__(self, response: requests.Response):
        try:
            detail = response.json()
        except ValueError:
            detail = response.text
        super().__init__(f"Graph API error {response.status_code}: {detail}")
        self.status_code = response.status_code
        self.detail = detail


class MetaClient:
    def __init__(self, page_access_token: str | None = None, page_id: str | None = None,
                 ig_user_id: str | None = None):
        self.token = page_access_token or config.page_access_token
        self.page_id = page_id or config.page_id
        self.ig_user_id = ig_user_id or config.ig_user_id
        self.base = config.graph_base

    def _post(self, path: str, **params) -> dict:
        params["access_token"] = self.token
        resp = requests.post(f"{self.base}/{path}", data=params, timeout=30)
        if not resp.ok:
            raise MetaAPIError(resp)
        return resp.json()

    def _get(self, path: str, **params) -> dict:
        params["access_token"] = self.token
        resp = requests.get(f"{self.base}/{path}", params=params, timeout=30)
        if not resp.ok:
            raise MetaAPIError(resp)
        return resp.json()

    # ── Verification / setup sanity checks ──────────────────────────────

    def whoami_page(self) -> dict:
        """Confirms the page token is valid and returns the page name."""
        return self._get("me", fields="id,name")

    def whoami_instagram(self) -> dict:
        return self._get(self.ig_user_id, fields="id,username")

    # ── Publishing ───────────────────────────────────────────────────────

    def post_facebook(self, message: str, image_url: str | None = None) -> str:
        """Publishes to the Page feed. Returns the new post id."""
        if image_url:
            result = self._post(f"{self.page_id}/photos", url=image_url, caption=message)
            return result.get("post_id") or result["id"]
        result = self._post(f"{self.page_id}/feed", message=message)
        return result["id"]

    def post_instagram(self, caption: str, image_url: str) -> str:
        """Instagram requires a hosted media container before it can be
        published; text-only posts are not supported. Returns the media id."""
        container = self._post(f"{self.ig_user_id}/media", image_url=image_url, caption=caption)
        creation_id = container["id"]
        published = self._post(f"{self.ig_user_id}/media_publish", creation_id=creation_id)
        return published["id"]

    # ── Comment replies ──────────────────────────────────────────────────

    def reply_to_facebook_comment(self, comment_id: str, message: str) -> str:
        result = self._post(f"{comment_id}/comments", message=message)
        return result["id"]

    def reply_to_instagram_comment(self, comment_id: str, message: str) -> str:
        result = self._post(f"{comment_id}/replies", message=message)
        return result["id"]

    # ── DMs (unified Send API for Messenger + Instagram Direct) ─────────

    def send_dm(self, recipient_id: str, text: str) -> dict:
        return self._post(
            "me/messages",
            recipient=json.dumps({"id": recipient_id}),
            message=json.dumps({"text": text}),
            messaging_type="RESPONSE",
        )
