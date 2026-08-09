---
name: web-design-guidelines
description: |
  Practical, checklist-driven web design guidelines for evaluating or
  improving the visual and UX quality of a page, component, or landing
  site — typography, color/contrast, spacing, layout hierarchy,
  responsive behavior, motion, and accessibility. Use this skill
  whenever the user asks to "review the design", "make this look more
  professional/polished", "critique this page", do a "design pass" or
  "UX review", asks about color contrast/accessibility, or when you are
  about to design or judge the visual quality of any web UI yourself —
  even without an explicit design request, e.g. before shipping a new
  page, form, or marketing section. This is about visual/UX quality;
  for component architecture and styling implementation strategy, use
  the `frontend-design` skill instead.
---

# Web Design Guidelines

A working checklist for judging and improving web UI quality. Use it in
two modes: **reviewing** existing UI (walk the checklist, report
specific violations with concrete fixes) and **designing** new UI
(apply it as you build, don't retrofit at the end). Framework-agnostic —
applies whether the UI is React, plain HTML, or an Artifact.

Every rule below exists to solve a real failure mode, not as decoration
— when in doubt, ask "does breaking this rule here actually hurt the
user," and if genuinely not, it's fine to deviate.

## Visual hierarchy & layout

- **One clear primary action per screen/section.** If everything is
  emphasized (bold, colored, bordered), nothing is — competing CTAs are
  the most common hierarchy failure on marketing/landing pages.
- **Group by proximity, separate with whitespace**, not borders/dividers
  as the default tool. A border around every card is a symptom of
  under-using whitespace to communicate grouping.
- **Align to a grid.** Elements whose edges don't line up with anything
  else on the page read as sloppy even when nothing else is wrong —
  check this visually, it's easy to miss element-by-element.
- **F-pattern / Z-pattern scanning**: put the value proposition and
  primary CTA where eyes actually land first (top-left through top,
  down the left edge) — don't bury the point below decorative content.

## Typography

- **Type scale, not ad-hoc sizes.** Use a consistent ratio (e.g. 1.25 or
  1.333) between heading levels rather than picking sizes by eye —
  inconsistent jumps (16px → 22px → 23px → 34px) read as unpolished even
  when each size in isolation looks fine.
- **Body line length 45–75 characters.** Full-width body text on a wide
  viewport is a very common miss — constrain the measure with
  `max-width`, don't let text run edge-to-edge on desktop.
- **Line-height 1.4–1.6 for body text**, tighter (1.1–1.3) for large
  headings — headings at body line-height look loose; body at heading
  line-height is hard to read.
- **Max 2 typefaces** (one for display/headings, one for body is
  usually enough) — a third typeface needs a specific reason.
- **Establish hierarchy with weight and size together**, not size alone
  — two headings at the same weight but different size can still look
  like they're competing rather than nested.

## Color

- **Contrast is not optional.** Body text needs ≥4.5:1 contrast against
  its background; large text (≥24px, or ≥19px bold) and UI component
  boundaries need ≥3:1 (WCAG AA). Check actual computed colors, don't
  eyeball it — light-gray-on-white body text is the single most common
  accessibility violation in real designs.
- **Don't encode meaning in color alone.** An error state that's "just
  red text" fails for colorblind users — pair color with an icon, label,
  or shape change.
- **Use semantic tokens, not raw hex values**, when the project has a
  design system/theme (`--color-danger`, `bg-primary`, etc.) — hardcoded
  hex scattered through components is what breaks on the next theme or
  dark-mode pass.
- **Roughly 60/30/10** — a dominant neutral, a secondary, and an accent
  used sparingly for emphasis/CTAs — is a reasonable starting ratio when
  a page has no established palette yet. An accent color used
  everywhere stops functioning as emphasis.

## Spacing

- **Use a spacing scale** (commonly a 4px or 8px base unit: 4, 8, 12,
  16, 24, 32, 48, 64…), not arbitrary pixel values per element. Random
  margins (`13px`, `17px`, `22px`) are a strong tell that spacing wasn't
  systematized, and they accumulate into visual noise across a page.
- **Related elements sit closer than unrelated ones.** If the gap
  between a label and its input equals the gap between that input and
  the *next* field's label, the grouping reads as ambiguous.

## Responsive behavior

- **Mobile-first, not "shrink the desktop layout."** Design/verify the
  narrow viewport first — desktop layouts that just compress rather
  than re-flow produce cramped mobile UI.
- **Touch targets ≥44×44px** on anything tappable — undersized mobile
  buttons/links are a frequent, easy-to-miss failure.
- **Fluid type for large display text** (`clamp()` in CSS) instead of a
  fixed size that's either too small on mobile or absurdly large on
  desktop.
- **Test real breakpoints**, not just "does it not visibly break" —
  check that content re-flows sensibly at common widths (~375, ~768,
  ~1024, ~1440px), not just that nothing overlaps.

## Motion

- **200–400ms for most UI transitions.** Faster feels abrupt; slower
  feels sluggish and makes the UI feel unresponsive to input.
- **Ease-out for things entering, ease-in for things leaving** — linear
  easing on UI motion is a common subtle "off" feeling.
- **Always respect `prefers-reduced-motion`.** Any non-trivial animation
  (parallax, auto-playing background motion, large transform
  animations) needs a static/reduced fallback — this is an accessibility
  requirement, not a nice-to-have, and it's cheap to add.
- **Motion should communicate something** (state change, spatial
  relationship, direction of navigation) — animation with no
  informational purpose is the first thing to cut under a performance
  or complexity budget.

## Accessibility (do this even when nobody asked)

- **Semantic HTML first.** A `<div onclick>` styled as a button is not
  a button to a screen reader or keyboard user — use real `<button>`,
  `<a>`, `<nav>`, `<main>`, `<label>` elements before reaching for ARIA.
- **Visible focus states on everything interactive.** `outline: none`
  without a replacement focus style is a hard accessibility failure —
  keyboard users need to see where they are.
- **Heading levels don't skip** (`h1` → `h2` → `h3`, never `h1` → `h3`)
  and there's exactly one `h1` per page.
- **Every form input has a real, associated `<label>`** (not just a
  placeholder — placeholders disappear on input and aren't reliably
  read by assistive tech).
- **Every meaningful image has real `alt` text**; decorative images get
  `alt=""` so screen readers skip them instead of reading a filename.
- **Full keyboard operability** — anything a mouse user can do, a
  keyboard-only user must be able to do too (open menus, close modals
  with Escape, navigate a custom dropdown with arrow keys).

## Imagery & content

- **Consistent aspect ratios** within a repeating grid (cards, avatars,
  thumbnails) — mixed ratios in a grid is a common source of visual
  noise even when each image individually looks fine.
- **Compress and size images for their actual display size** — shipping
  a 4000px source image into a 300px card is a real, common performance
  bug, not just a nitpick.
- **Button/link labels are verbs describing the outcome** ("Start free
  trial", not "Submit" or "Click here") — vague labels measurably hurt
  conversion and accessibility both (screen reader users navigating by
  link list get a page full of "Click here").
- **Error messages say what's wrong and how to fix it** ("Email must
  include an @" beats "Invalid input").

## Marketing/landing-page specifics (relevant to an advertising-focused repo)

- **Value proposition visible above the fold**, in the first
  screen-height, without scrolling — don't bury what the product/offer
  actually is beneath a hero animation or slideshow.
- **One primary CTA repeated, not many different CTAs competing** ("Get
  started" in the nav, hero, and footer beats "Get started" / "Try free"
  / "Learn more" / "Contact us" all fighting for attention).
- **Social proof (logos, testimonials, numbers) placed near the decision
  point**, not isolated in a section nobody scrolls to.
- **Load-bearing claims need to be scannable in 3 seconds** — if a
  visitor can't tell what the page is offering within a few seconds of
  landing, the hierarchy has failed regardless of how polished the
  visuals are.

## How to run a review

When asked to review or critique a page/component:

1. If you can render it (Artifact, running dev server, or a screenshot
   via the `run` skill), actually look at it first — don't review
   markup blind when a visual check is possible.
2. Walk the sections above relevant to what's being reviewed (a form
   doesn't need the "marketing/landing" section; a landing page needs
   all of it).
3. Report **specific, located issues with concrete fixes**, not general
   impressions — "the CTA button (`#hero button`) is 3.2:1 contrast
   against its background, below the 4.5:1 minimum for text this size —
   darken to `#1a56db` or similar" beats "the colors could be better."
4. Prioritize accessibility and hierarchy violations above stylistic
   preference — a contrast failure or missing label is a real defect;
   "I'd use a different font" is a taste call, flag it as optional.

## Related skills in this repo

- `frontend-design` — for how to actually implement fixes: component
  structure, styling approach, design tokens.
- `shadcn-mcp` — for pulling in accessible, pre-built primitives (Dialog
  focus-trapping, Form field/label wiring, etc.) instead of hand-rolling
  interactive components that are easy to get wrong on this checklist.
