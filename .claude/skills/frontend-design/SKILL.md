---
name: frontend-design
description: |
  Front-end architecture and implementation guidance for building a
  React/web UI codebase: component structure and composition, styling
  strategy (Tailwind vs CSS Modules vs CSS-in-JS), design tokens, state
  management boundaries, file/folder organization, and performance and
  accessibility implementation patterns. Use this skill whenever the
  user asks to set up a new front-end project or page, wants a
  "component library" or "design system" built out, asks how to
  structure/organize UI code, asks about styling approach, or is about
  to build a non-trivial UI feature — even without an explicit
  architecture question, e.g. before scaffolding a new page or feature
  area. This is about code structure and engineering decisions; for
  visual/UX quality, use the `web-design-guidelines` skill, and for
  installing shadcn/ui components specifically, use `shadcn-mcp`.
---

# Front-End Design (architecture & implementation)

Guidance for structuring a front-end codebase so it stays easy to
extend rather than accreting one-off components and ad-hoc styling.
Pairs with `web-design-guidelines` (what good looks like) and
`shadcn-mcp` (concrete component source) — this skill is about the
engineering decisions in between: how components are organized, how
styling is applied consistently, and where state should live.

## Component architecture

- **Three rough layers, not a rigid framework**: *primitives*
  (Button, Input, Card — usually from a library like shadcn/ui, rarely
  hand-rolled), *composed components* (a `SearchableSelect` built from
  primitives, a `PricingCard` built from `Card` + `Badge` + `Button`),
  and *feature/page components* (a specific page or feature area that
  assembles composed components with real data). Don't over-formalize
  this into a folder-per-layer if the project is small — the point is
  the mental model, not a mandatory directory structure.
- **Single responsibility per component.** If a component both fetches
  data and renders three unrelated visual sections, split it — the
  usual seam is data-fetching/orchestration vs. presentation.
- **Composition over configuration.** A component with `showHeader`,
  `showFooter`, `headerVariant`, `footerAlign`, `hideOnMobile` boolean
  props is fighting against composition — prefer `children`/named slots
  (`<Card><Card.Header>...</Card.Header></Card>` or a `header` prop
  accepting a node) so callers assemble what they need instead of the
  component trying to anticipate every combination.
- **Avoid boolean-prop explosion generally.** More than 2-3 booleans
  controlling a component's rendering is usually a sign it should be a
  `variant` enum (`variant: 'default' | 'compact' | 'featured'`) instead
  — enums are exhaustively checkable and self-documenting in a way a
  pile of booleans isn't.
- **Controlled vs uncontrolled**: default to controlled (state lives in
  the parent, component takes `value`/`onChange`) for anything whose
  state the surrounding app plausibly needs to read or drive — form
  fields, filters, tabs with deep-linking. Reach for uncontrolled
  (internal state) for genuinely self-contained UI (a tooltip's open
  state, a disclosure with no external dependency).

## Styling strategy — pick one primary approach per project

| Approach | Reach for it when... | Watch out for |
|---|---|---|
| **Tailwind (utility-first)** | Default choice for most new projects, especially alongside shadcn/ui (which is built on it) — fast iteration, consistent spacing/color via the theme config, no naming-things tax. | Long class strings on complex components — extract with `cn()`/`cva()` variant helpers rather than sprinkling conditional classes inline everywhere. |
| **CSS Modules** | A handful of genuinely complex, one-off visual components (a custom canvas-driven widget, an unusual layout) where utility classes get unreadable, or a team with strong existing CSS conventions. | Don't mix this in as a second styling system alongside Tailwind for ordinary components — pick one default and treat the other as the exception. |
| **CSS-in-JS (styled-components, vanilla-extract, etc.)** | Genuine runtime dynamic theming needs (per-tenant themes computed at runtime), or an existing codebase already standardized on it. | Runtime CSS-in-JS has a real performance cost (style recalculation, bundle size) — don't default to it for static styling that Tailwind or CSS Modules would cover for free. |

Whichever is chosen, **design tokens are non-negotiable**: colors,
spacing, radii, font sizes/weights, and shadows live in one place
(Tailwind theme config / CSS custom properties), never hardcoded per
component. A component styled with `#3B82F6` instead of `bg-primary`
silently breaks the next time the brand color or dark mode changes.

## State management boundaries

- **Local component state is the default.** Reach for anything broader
  only when two or more components genuinely need to share it.
- **Lift state to the nearest common ancestor**, not to a global store,
  when the sharing need is localized (a filter panel and its results
  list on the same page).
- **Separate server state from client state.** Data fetched from an API
  (lists, records, anything with its own freshness/caching semantics)
  belongs in a server-state library (React Query, SWR, or the
  framework's built-in data layer) — not copied into `useState` or a
  global store by hand, which reinvents cache invalidation badly.
  Client-only state (UI open/closed, form draft values, selected tab)
  is what actually belongs in `useState`/`useReducer`/Context/Zustand.
- **Context is for rarely-changing, broadly-needed values** (theme,
  auth user, locale) — not a general substitute for prop drilling on
  frequently-changing state, which causes wide re-render blast radius.

## File & folder organization

Feature-based organization scales better than type-based
(`components/`, `hooks/`, `utils/` as flat top-level buckets) once a
project passes a few dozen components — colocate a feature's
components, hooks, and types together, and keep only genuinely
cross-feature primitives in a shared top-level location:

```
src/
├── components/ui/          # cross-cutting primitives (shadcn/ui output lives here)
├── features/
│   ├── pricing/
│   │   ├── components/     # PricingCard, PricingToggle — used only within this feature
│   │   ├── hooks/
│   │   └── types.ts
│   └── campaign-builder/
│       ├── components/
│       ├── hooks/
│       └── types.ts
└── lib/                     # framework-agnostic utilities, api client, cn()
```

A small project doesn't need this up front — flat is fine until the
flat structure is actually causing friction. Don't pre-build the
feature-folder scaffolding for a five-component app.

## Performance

- **Code-split by route by default**; lazy-load heavy, rarely-visited
  features (a rich text editor, a charting library) rather than
  bundling them into the main chunk.
- **Size and serve images for their actual display size**, with a
  modern format (WebP/AVIF) and explicit `width`/`height` (or an
  aspect-ratio box) to avoid layout shift.
- **Don't reach for memoization preemptively.** `useMemo`/`useCallback`
  /`React.memo` are for measured re-render problems, not applied by
  default to every component — premature memoization adds real
  complexity and can itself hurt performance (comparing props costs
  something too).
- **Virtualize long lists** (hundreds+ of rows/cards) rather than
  rendering everything and hoping — this is one of the few performance
  patterns worth applying proactively, since the failure mode (a
  100-item list rendering 100 complex cards) is easy to hit by accident.

## Accessibility implementation

(See `web-design-guidelines` for the *why*; this is the *how* at the
code level.)

- Reach for real semantic elements (`<button>`, `<nav>`, `<dialog>`)
  before ARIA roles — ARIA is for filling gaps HTML can't express, not
  a default layer on top of `<div>`s.
- Modals/drawers/menus need focus trapping and Escape-to-close — this
  is exactly the kind of thing worth getting from a library (shadcn/ui's
  Dialog, built on Radix) rather than hand-rolling, because it's easy to
  get subtly wrong (focus escaping the trap, Tab order not restored on
  close).
- Custom interactive widgets (a combobox, a custom dropdown) need real
  keyboard support (arrow keys, Home/End, typeahead) — again, prefer an
  existing accessible primitive over a hand-rolled `<div>`-based version.

## Testing approach

- Test component **behavior**, not implementation details — assert on
  what the user can see/do ("clicking submit shows a success message"),
  not on internal state shape or CSS class names, so tests survive
  refactors.
- Accessibility checks (e.g. `axe`/`jest-axe` or a Playwright a11y scan)
  are cheap to add to component tests and catch real regressions
  (missing labels, contrast) that visual review alone can miss.
- Visual regression testing is worth it for a component library with
  many consumers; usually not worth the setup cost for a handful of
  one-off feature pages.

## Related skills in this repo

- `web-design-guidelines` — the visual/UX checklist this architecture
  should be serving; consult it when judging whether the *result* looks
  right, not just whether the code is well-organized.
- `shadcn-mcp` — the concrete way to pull in accessible, pre-built
  primitives (Button, Dialog, Form, etc.) rather than hand-rolling the
  primitives layer described above.
- `liquid-logo-shader` — a specialized example of composed +
  feature-layer components (ShaderGradient/React Three Fiber) built on
  top of these same architecture principles.
