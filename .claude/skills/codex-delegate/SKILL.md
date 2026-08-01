---
name: codex-delegate
description: |
  Delegate a coding task to the OpenAI Codex CLI (`codex exec`) instead of
  doing it yourself — run it as a non-interactive subprocess, choose the
  right sandbox/approval mode, and review its diff before accepting the
  result. Use this whenever the user explicitly asks to "use Codex",
  "delegate to Codex", "hand this off to Codex", "run codex on this",
  "get a second opinion from Codex", "have Codex build/fix/refactor X",
  or wants two independent implementations (one from you, one from Codex)
  to compare. Also use it when the user wants a coding task run in an
  isolated, sandboxed subprocess they can audit afterwards rather than
  edited live in this session.
---

# Codex Delegate

Your job is to hand a well-scoped coding task to the **Codex CLI**
(`codex`, from `@openai/codex`) running as a subprocess, then review and
report back on what it did. Codex is a separate coding agent with its
own model and its own context — it does not see this conversation unless
you put the relevant parts into the prompt you give it.

---

## Operating rules — read first

1. **Codex has no memory of this conversation.** Brief it like you'd
   brief a subagent: state the goal, the relevant file paths, any
   constraints, and what "done" looks like. A one-line prompt like `"fix
   the bug"` produces poor results — Codex can't see what you and the
   user already discussed.
2. **Flags drift between CLI versions — verify, don't assume.** Before
   relying on a flag you're not 100% sure is currently correct, run
   `codex exec --help` (and `codex --help`) once per session and read
   the output. The flags below are the well-established ones, but treat
   anything more obscure as "check first."
3. **Never use a full sandbox/approval bypass without the user explicitly
   asking for it.** `--dangerously-bypass-approvals-and-sandbox` (alias
   `--yolo`) disables both the sandbox AND all approval prompts — Codex
   can then run arbitrary shell commands and edit anything with no
   safety net. Only use it if the user says something like "let it run
   fully unsandboxed" — never reach for it by default, even to "save
   time."
4. **Always review the diff before telling the user the task is done.**
   Codex edits files directly on disk. After it exits, run `git status`
   and `git diff` (or `git diff --stat` for a big change) yourself and
   actually read it — don't just relay Codex's own summary of what it
   did.
5. **Treat Codex like an external contributor, not an extension of
   yourself.** If its diff looks wrong, incomplete, or does something
   the prompt didn't ask for, say so to the user rather than presenting
   it as finished work.

---

## Before you start: check availability

```bash
command -v codex && codex --version
```

- Not installed → tell the user and offer to install it if they want:
  `npm install -g @openai/codex` (needs Node 18+) or `brew install --cask codex`.
- Installed but not authenticated → running it will fail or prompt for
  login. Tell the user to run `codex login` themselves (it opens a
  browser-based ChatGPT/API login flow) — don't try to shell out
  credentials on their behalf.

---

## Choosing sandbox + approval mode

Codex's behavior is controlled by two independent settings. Pick them
based on what the task actually needs — don't default to the most
permissive option.

| Flag | Values | What it controls |
|---|---|---|
| `-s, --sandbox` | `read-only` (default), `workspace-write`, `danger-full-access` | Whether Codex can write files / run commands with network access |
| `-a, --ask-for-approval` | `untrusted`, `on-failure`, `on-request`, `never` | Whether Codex pauses to ask before risky actions |

Since `codex exec` is non-interactive, there's no TTY to answer an
approval prompt — `on-request` is automatically downgraded to `never`,
and anything needing approval it can't get will simply fail with a
message in stderr rather than hang. Keep that in mind when reading
output: a failed step often means "this needed permission it didn't
have," not a crash.

**Practical defaults:**

| Task | Recommended flags |
|---|---|
| Read/analyze only ("what does this function do", "find the bug") | `-s read-only` (the default — you can omit the flag) |
| Let it edit files in the repo, run the test suite, etc. | `-s workspace-write -a on-failure` |
| The historical shorthand for the row above | `--full-auto` — **deprecated**, prefer the explicit flags |
| Needs network access (installing a package, hitting an API) or full system access | `-s danger-full-access` — only with explicit user sign-off, and prefer running it in a disposable/CI environment |
| User explicitly wants zero prompts and zero sandboxing | `--dangerously-bypass-approvals-and-sandbox` — confirm with the user first, every time |

Other useful flags:

- `-C, --cd <dir>` — scope Codex to a specific directory instead of cwd.
- `-m, --model <model>` — override the default model if the user asks for a specific one.
- `--skip-git-repo-check` — only needed if the target directory isn't a git repo (rare; prefer working inside a repo so the diff review step works).
- `-o, --output-last-message <file>` — write just Codex's final summary message to a file, useful when you need to hand that text to something else.
- `--json` — stream structured JSONL events instead of plain text, useful if you need to parse progress programmatically rather than just reading the final message.

By default (no `--json`), Codex prints progress to **stderr** and only
its final response to **stdout** — so `stdout` alone is a decent summary,
but check `stderr`/exit code when something seems to have failed.

---

## Running it

```bash
codex exec -s workspace-write -a on-failure -C /path/to/repo \
  "Implement input validation for the signup form in src/forms/Signup.tsx: \
   reject empty email/password, show inline error text, add a unit test \
   in src/forms/Signup.test.tsx. Don't touch unrelated files."
```

Write multi-line prompts to a temp file first if they're long or contain
characters that are awkward to quote in shell:

```bash
cat > /tmp/codex_task.txt <<'EOF'
<the full prompt, as many paragraphs as needed>
EOF
codex exec -s workspace-write -a on-failure "$(cat /tmp/codex_task.txt)"
```

### Writing a good prompt

Include, in order:
1. **The goal** — one sentence, concrete and checkable.
2. **Relevant context** — file paths, function/class names, existing
   conventions to follow, anything from this conversation Codex needs
   but can't see.
3. **Constraints** — what NOT to touch, style/lint rules, whether tests
   must pass.
4. **Definition of done** — how you (and Codex) will know it worked,
   e.g. "the new test passes" or "`npm run build` succeeds."

### After it exits

1. Check the exit code and skim stderr for errors/approval-denials.
2. `git status` then `git diff` — read the actual changes.
3. If there's a test suite and the task plausibly affects it, run it.
4. Summarize for the user: what changed, whether it matches the ask,
   anything you'd flag or want their sign-off on before it's considered
   final. Don't rubber-stamp Codex's own claimed summary.

---

## When to prefer this over just doing the task yourself

Use Codex delegation when the user asks for it explicitly, or when it's
genuinely useful to get an independent second implementation to diff
against your own. It is **not** a way to offload work you'd rather not
do yourself, or a shortcut around actually reviewing the result — you're
still responsible for what lands in the user's repo.

## Quick reference

```bash
codex --version                                            # sanity check install
codex login                                                # user runs this themselves if not authenticated
codex exec "read-only prompt"                              # default: read-only sandbox
codex exec -s workspace-write -a on-failure "edit prompt"   # let it write files, ask only if a step fails
codex exec -s danger-full-access "prompt needing network"  # explicit user sign-off required
codex exec --dangerously-bypass-approvals-and-sandbox "..."# no sandbox, no prompts — confirm with user first
codex exec -o /tmp/last_message.txt "prompt"                # capture just the final message
codex exec --json "prompt"                                  # structured JSONL event stream
```
