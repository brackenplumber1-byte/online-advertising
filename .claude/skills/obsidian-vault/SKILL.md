---
name: obsidian-vault
description: |
  Read, create, and edit notes directly on disk in a local Obsidian
  vault — markdown notes with YAML frontmatter, `[[wikilinks]]`,
  `#tags`, embeds, and daily notes — without needing the Obsidian app
  or any plugin API. Use this whenever the user mentions "my Obsidian
  vault", "my notes", "my second brain", "my PKM", "zettelkasten",
  "daily note", asks to create/update/find/link notes in a folder that
  looks like an Obsidian vault (contains a `.obsidian/` folder), or
  wants help organizing, tagging, or linking their notes.
---

# Obsidian Vault Skill

An Obsidian vault is just a folder of plain markdown files — `.obsidian/`
holds app config, not vault content. You can read and edit vault notes
directly with normal file tools; you don't need Obsidian running or any
plugin. The job here is to do that *without breaking the conventions
Obsidian and the user rely on* — links, frontmatter schema, and folder
structure.

---

## Operating rules — read first

1. **Find and confirm the vault before doing anything else.** If the
   user hasn't given you a path, ask. Confirm it's really a vault by
   checking for a `.obsidian/` folder at its root — if it's missing,
   you're probably in the wrong directory (or a subfolder of the vault,
   not its root).
2. **Read a few existing notes before writing a new one.** Look at 3-5
   notes similar to what you're about to create. Match their frontmatter
   schema (which keys they use, tag style, date format), heading style,
   and folder placement. A new note that doesn't match the vault's
   existing conventions sticks out and breaks the user's system.
3. **Never rename or move a note without fixing every link to it.**
   Obsidian's app auto-updates `[[links]]` on rename; raw filesystem
   edits do NOT. If you rename `Old Name.md` → `New Name.md`, you must
   grep the whole vault for `[[Old Name]]` (and `[[Old Name|...]]`,
   `[[Old Name#...]]`, `![[Old Name]]`) and update every occurrence
   yourself, or you leave the user with broken links.
4. **Don't touch `.obsidian/` internals** (`workspace.json`, plugin
   configs, themes) unless the user specifically asks you to change a
   setting. That folder holds transient UI/app state, not vault content.
5. **Assume the user might have the vault open in Obsidian right now.**
   Obsidian will detect external file changes and either reload
   silently or prompt about a conflict. This is normally fine for
   ordinary edits, but for a large bulk rewrite across many files,
   mention it to the user and suggest they close the vault first (or at
   least save open notes) to avoid losing unsaved edits.
6. **Never invent facts to fill in a note.** If the user asks you to
   write content you don't actually know, say so or ask — don't
   fabricate journal entries, meeting notes, or "facts" about the
   user's life just to make a note look complete.

---

## Note anatomy

```markdown
---
title: Example Note
tags: [project/website, status/active]
aliases: [Example, Ex Note]
created: 2026-08-01
---

# Example Note

Body content, in normal markdown. Link to another note with
[[Other Note]] or [[Other Note|custom display text]], link to a
specific heading with [[Other Note#Some Heading]], and embed another
note or an image inline with ![[Other Note]] or ![[diagram.png]].

Inline tags look like #project/website or #status/active.
```

- **Frontmatter** is YAML between the first two `---` lines. Obsidian's
  "Properties" feature reads/writes this same block — text, list,
  number, checkbox, and date/datetime are all just YAML underneath.
- **Wikilinks** (`[[Note Name]]`) resolve by filename (without `.md`),
  matched vault-wide regardless of folder. If two notes share a
  basename in different folders, links to that name are ambiguous —
  watch for this before creating a note whose name already exists
  elsewhere in the vault.
- **Tags** can live in frontmatter (`tags: [a, b]`) or inline in the
  body (`#a`). Nested tags use `/` (`#project/website`). Match whichever
  style the vault already uses predominantly — check a few notes first.
- **Filenames** become the note title by default; avoid characters
  invalid across filesystems: `/ \ : * ? " < > |`.

---

## Common tasks

### Find a note before creating a new one

Always search for an existing note on the topic first — duplicate notes
with slightly different names are the most common way vaults get messy.

```bash
grep -ril "keyword" "$VAULT/**/*.md"          # case-insensitive content search
find "$VAULT" -iname "*keyword*.md"           # filename search
```

### Create a note

1. Pick the folder that matches where similar notes live (don't
   default to vault root if the vault clearly organizes by topic).
2. Match the frontmatter schema you saw in step "read a few existing
   notes" above.
3. Link it from wherever makes sense (an index/MOC note, a related
   note, the daily note) — an orphaned note with no inbound links is
   easy to lose track of.

### Find backlinks to a note (what links to X)

```bash
grep -rn "\[\[Note Name" "$VAULT" --include="*.md"
```

Remember to also check for the pipe and heading-anchor forms
(`[[Note Name|`, `[[Note Name#`) and the embed form (`![[Note Name`).

### Rename/move a note safely

```bash
OLD="Old Name"; NEW="New Name"
grep -rl "\[\[$OLD" "$VAULT" --include="*.md"   # see what will need updating
# update each match: [[Old Name]] -> [[New Name]], [[Old Name|x]] -> [[New Name|x]], etc.
# then:
git mv "$VAULT/path/to/Old Name.md" "$VAULT/path/to/New Name.md"   # if the vault is a git repo
```

If the vault isn't under git, back it up first (`cp -r`) before a bulk
rename — there's no undo for a raw filesystem move across many files.

### Daily notes

Look for a `daily-notes.json` or `periodic-notes.json` under
`.obsidian/plugins/` (or core plugin config) to find the configured
folder and filename format (commonly `YYYY-MM-DD.md`); if you can't find
it, ask the user where their daily notes live rather than guessing a
folder. Append to today's note rather than creating a duplicate if one
already exists for the date.

### Tagging consistently

Before adding a new tag, check whether a similar one already exists
(`grep -rho '#[A-Za-z0-9/_-]\+' "$VAULT" --include="*.md" | sort -u`) —
reusing `#project/website` instead of inventing `#projects/site` keeps
the tag pane usable.

---

## Things to avoid

- Don't reorganize folder structure or rename multiple notes as a
  "cleanup" unless the user asked for that specifically — it's their
  filing system, not yours to redesign.
- Don't strip or reformat frontmatter you don't understand (e.g. plugin-
  specific keys like `cssclass`, `banner`, `dg-publish`) — leave unknown
  keys as-is when editing a note for an unrelated reason.
- Don't create `.canvas` files (JSON canvas format) unless the user
  specifically wants a canvas — default to plain markdown notes.
- Don't assume the vault is a git repo — check before suggesting `git`
  commands, and offer a plain `cp -r` backup instead if it isn't.
