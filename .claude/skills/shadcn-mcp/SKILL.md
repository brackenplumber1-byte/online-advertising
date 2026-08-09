---
name: shadcn-mcp
description: |
  Add, find, or customize UI components from shadcn/ui (and any other
  configured component registry) using the shadcn MCP server instead of
  guessing at component APIs from memory. Use this skill whenever the
  user asks to "add a button/dialog/card/form/sidebar", build UI with
  shadcn, wants a "component library", asks about a "design system",
  mentions `components.json`, or says "shadcn mcp" / "shadcn registry" —
  even if they just describe a UI element ("I need a modal with a form
  in it") without naming shadcn explicitly, if the project already uses
  shadcn/ui.
---

# shadcn MCP — registry-backed component installs

shadcn/ui ships components as **source code you own**, not an npm
package — which means the exact props, variants, and file layout of
`Button` or `Dialog` differ per project (and drift as the project
customizes them). Guessing at a shadcn component's API from training
data is a common source of hallucinated props and broken imports. The
shadcn MCP server exists specifically to fix that: it lets you query the
project's actual registries — what's installed, what's available, real
source, real usage examples — instead of guessing.

**Prefer the MCP tools over hand-writing shadcn component source or
guessing CLI flags whenever they're available in this session.** Fall
back to the plain CLI (`npx shadcn@latest ...`) only if the MCP server
isn't connected.

## One-time setup (if not already configured)

Check whether shadcn's MCP server is already wired up before assuming
it isn't: look for an `.mcp.json` in the project root with a `shadcn`
entry, or check whether tools named `mcp__shadcn__*` are already
listed/loadable in this session (via ToolSearch if the harness defers
tool schemas). If neither is present:

```bash
npx shadcn@latest mcp init --client claude
# or: pnpm dlx shadcn@latest mcp init --client claude
# or: bunx --bun shadcn@latest mcp init --client claude
```

This writes the `.mcp.json` config Claude Code reads to connect to the
server. After running it, the MCP tools may need a fresh session/tool
search to appear — say so to the user rather than silently falling back
to guesswork.

The project also needs to be shadcn-initialized (a `components.json` at
the root) for any of this to resolve to real components. If
`components.json` doesn't exist yet:

```bash
npx shadcn@latest init
```

## The seven MCP tools, and when to reach for each

| Tool | Use it to... |
|---|---|
| `get_project_registries` | See which registries this project has configured (`components.json`) before assuming only the public `@shadcn` registry is in play — many projects add private or third-party registries. |
| `list_items_in_registries` | Browse everything available in a registry (or all of them) when the user wants options, not a specific named component. |
| `search_items_in_registries` | Fuzzy-find a component by name or purpose ("something like a combobox") — start here for a specific, named ask. |
| `view_items_in_registries` | Pull the **actual full source** of a component before customizing it or explaining its API — this is what replaces guessing at props. |
| `get_item_examples_from_registries` | Find real usage demos/snippets before writing code that consumes the component, so composition matches the library's intended patterns. |
| `get_add_command_for_items` | Get the exact, correct CLI install command — component and registry names can be namespaced (`@acme/data-table`), don't hand-construct `npx shadcn add <name>` from memory. |
| `get_audit_checklist` | After installing, verify imports resolved, dependencies installed, and lint/TypeScript are clean — run this before declaring the task done. |

## Workflow

1. **`get_project_registries`** — know what's actually available before
   recommending anything. If the user's ask is ambiguous between
   registries (a component exists in both `@shadcn` and a configured
   private registry), **ask which one** rather than picking silently.
2. **`search_items_in_registries`** (named ask) or
   **`list_items_in_registries`** (open-ended "what's available") to
   find the right component(s).
3. **`view_items_in_registries`** to read the real source — especially
   before telling the user what props/variants exist, or before writing
   code that customizes the component.
4. **`get_item_examples_from_registries`** to see how it's meant to be
   composed with other pieces (e.g. `Dialog` + `Form` + `FieldGroup`)
   before writing the consuming page/feature code.
5. **`get_add_command_for_items`** → run that exact command (Bash) to
   install. Don't hand-write the component file yourself — the CLI is
   what keeps it in sync with the registry and pulls its dependencies.
6. **`get_audit_checklist`** → run it, fix anything it flags, before
   telling the user the component is in place.

## Fallback — MCP server not connected

If the tools aren't available (server not yet configured, or this
particular session doesn't have it connected), use the plain CLI
directly rather than blocking on it:

```bash
npx shadcn@latest info                 # project context: aliases, tailwind version, icon library
npx shadcn@latest search -q "sidebar"  # fuzzy search
npx shadcn@latest docs button          # docs/usage for one component
npx shadcn@latest add button card dialog
```

Read the installed component's actual source file after adding it
(`Read` the file under the project's configured `ui` alias path) rather
than assuming its API from memory — the MCP tools exist to save that
step, but a direct file read accomplishes the same goal when they're
unavailable.

## Non-negotiables

- **Never hand-write a shadcn component's internals from memory.**
  Install via the CLI/MCP command and read the real result — component
  internals (Radix primitives used, `cva` variant definitions, class
  names) vary by project and by shadcn version.
- **Match the project's existing conventions**, read from
  `components.json` / `get_project_registries`: the configured path
  alias (never hardcode `@/components/ui`), `iconLibrary` (swap icon
  imports to match — don't introduce a second icon package), and
  Tailwind version (v4 projects use CSS-based theme config; v3 uses
  `tailwind.config.js` — don't write v3-style config into a v4 project).
- **Compose existing primitives before reaching for custom UI.** A
  request for "a modal with a form" is `Dialog` + `Form`/`FieldGroup` +
  existing form controls, not a hand-rolled overlay.
- **Use semantic tokens, not raw colors**, when styling around installed
  components (`bg-primary`, `text-muted-foreground`, etc.) so the result
  respects the project's theme instead of hardcoding hex values that
  break on theme changes.
- **Ask which registry** when a component name is ambiguous across more
  than one configured registry, rather than silently picking the public
  `@shadcn` one.

## Related skills in this repo

- `web-design-guidelines` — for whether the resulting UI actually looks
  and behaves well (contrast, spacing, hierarchy), independent of which
  component library built it.
- `frontend-design` — for how to structure the surrounding component
  architecture, styling strategy, and state once the shadcn pieces are
  installed.
