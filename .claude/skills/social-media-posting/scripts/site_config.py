"""Shared helper for loading a named business's credentials.

Each platform script (meta_post.py, linkedin_post.py, gbp_post.py) calls
load_site_env(args.site) right after parsing args, before touching any
platform-specific env vars. With --site omitted, falls back to the plain
./.env file for single-business use.
"""
import sys
from pathlib import Path

try:
    from dotenv import load_dotenv
except ImportError:
    load_dotenv = None

SITES_DIR = Path(__file__).resolve().parent.parent / "sites"


def available_sites():
    if not SITES_DIR.is_dir():
        return []
    return sorted(p.stem for p in SITES_DIR.glob("*.env"))


def load_site_env(site, result_fn):
    if load_dotenv is None:
        return
    if site:
        env_path = SITES_DIR / f"{site}.env"
        if not env_path.is_file():
            result_fn({
                "error": f"No config found for site '{site}' at {env_path}.",
                "available_sites": available_sites(),
            })
            sys.exit(1)
        load_dotenv(env_path, override=True)
    else:
        load_dotenv(override=True)


def add_site_arg(parser):
    parser.add_argument("--site", default=None,
                         help="Named business config to use (sites/<site>.env). "
                              "Omit to use the plain ./.env file (single-site mode).")
