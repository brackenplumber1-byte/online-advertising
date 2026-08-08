---
name: liquid-logo-shader
description: |
  Build an animated "liquid logo" for a React app: a shader-driven, fluid
  gradient background (via ShaderGradient / React Three Fiber) masked to a
  logo's shape, optionally combined with a "liquid glass" frosted/refractive
  panel effect. Use this skill whenever the user asks for a "liquid logo",
  "liquid glass", "glass morphism logo", "shader gradient background",
  "animated gradient logo", "WebGL logo animation", "Apple-style liquid
  glass UI", or mentions ShaderGradient, react-three-fiber, "react 3",
  drei, or three.js in the context of a logo/hero/nav/brand component —
  even if they just say "make our logo look liquid" or "give the header a
  glassy animated background" without naming the libraries.
---

# Liquid Logo / Shader Gradient / Liquid Glass

Three techniques stack together to make a "liquid logo": an animated
shader background, a shape mask that confines it to the logo, and an
optional frosted-glass panel on top. This skill is the playbook for
wiring all three into a React component, plus the exact packages to
install and the pitfalls (SSR, perf, reduced-motion) that trip people up.

## The stack, in one picture

```
┌─────────────────────────────────────────────┐
│ React Three Fiber (@react-three/fiber)       │  ← the WebGL/Three.js
│   + three  + @react-three/drei               │    engine everything
│                                               │    else renders inside
│  ┌─────────────────────────────────────────┐ │
│  │ ShaderGradient (@shadergradient/react)   │ │  ← the animated liquid
│  │   fluid, colorful, noise-driven mesh     │ │    gradient itself
│  └─────────────────────────────────────────┘ │
└───────────────────┬───────────────────────────┘
                     │ masked/clipped to the logo's shape
                     ▼
        ┌────────────────────────────┐
        │  "Liquid glass" panel       │  ← optional frosted/refractive
        │  (backdrop-filter blur +    │    overlay sitting on top,
        │   SVG displacement filter)  │    Apple-Vision-Pro style
        └────────────────────────────┘
```

You rarely need all three for a simple ask ("make the logo look
liquid"). Pick based on what the user wants:

| User wants... | Use |
|---|---|
| Logo fill/background that moves like colored liquid | ShaderGradient masked to the logo shape (below) |
| Frosted glass panel/nav bar with a wobble/refraction on hover | Liquid glass CSS+SVG effect (no WebGL needed) |
| Both — a glass logo badge with liquid color moving inside it | ShaderGradient canvas behind a liquid-glass panel, masked together |
| Full custom 3D scene (not just a flat gradient) | Drop ShaderGradient and hand-roll a shader material in raw React Three Fiber |

Read `references/react-three-fiber.md` first if the project has never
used R3F — it explains the Canvas/SSR setup every other piece depends on.
Then read `references/shadergradient.md` for the gradient layer, and
`references/liquid-glass.md` for the glass panel. Working component
templates are in `templates/`.

## 1. Install the exact packages

```bash
npm install three @react-three/fiber @react-three/drei @shadergradient/react shadergradient
```

Version-pin note: `@shadergradient/react` moves fast and tracks specific
`three` / `@react-three/fiber` major versions. Check the installed
`@shadergradient/react` version's peer deps (`npm info @shadergradient/react peerDependencies`)
before assuming the latest `three`/`fiber`/`drei` triad is compatible —
mismatches show up as a blank canvas with no console error, which is the
most common failure mode people hit with this stack.

Optional, only if animating non-shader properties (panel scale, opacity,
scroll-linked motion) alongside the shader:

```bash
npm install framer-motion
```

Liquid glass (section 3 / `references/liquid-glass.md`) needs **no new
package** — it's CSS `backdrop-filter` plus an inline SVG `<filter>`,
both native browser features.

## 2. ShaderGradient — the liquid background, masked to the logo

The gradient itself is just a `<Canvas>` with ShaderGradient's mesh
inside it, no different from any other R3F scene. The "logo" part comes
from **masking that canvas to the logo's silhouette** with CSS —
ShaderGradient has no idea a logo exists; you're clipping its output.

Two masking approaches, pick based on what the logo asset is:

- **Logo is (or can be) an SVG** → use it directly as a CSS `mask-image`
  on the canvas wrapper. Cleanest, scales perfectly, no extra assets.
- **Logo is a raster PNG/wordmark with soft edges** → generate a
  black/white/alpha mask PNG from it (design tool or `sharp` script) and
  use that as `mask-image` instead. SVG masks want crisp shapes; a wordmark
  with anti-aliased edges usually masks better as a matched-resolution PNG.

See `templates/LiquidLogo.tsx` for the full component — it wraps
`ShaderGradientCanvas` + `ShaderGradient` and applies the mask via a
wrapper `<div>` so the WebGL canvas itself stays a plain rectangle
(masking the canvas element directly is supported in modern browsers but
masking a wrapper div is more predictable across Safari/Firefox).

Key ShaderGradient props worth knowing (full list in
`references/shadergradient.md`):

- `type="waterPlane" | "plane" | "sphere"` — `waterPlane` is the classic
  "liquid" look most people mean by "liquid logo".
- `animate="on"` — required for motion; `"off"` gives a static frame
  (useful for a `prefers-reduced-motion` fallback, see below).
- `color1` / `color2` / `color3` — brand colors go here.
- `cAzimuthAngle` / `cPolarAngle` / `cDistance` / `cameraZoom` — camera
  framing; ShaderGradient's own visual editor at shadergradient.co is the
  fastest way to dial these in and copy out the prop values.

## 3. Liquid glass — the frosted/refractive panel

"Liquid glass" (the Apple-Vision-Pro-style effect) is two CSS layers, no
WebGL required:

1. `backdrop-filter: blur(...) saturate(...)` on a semi-transparent panel
   — the frosted-glass base.
2. An SVG `<filter>` with `feTurbulence` + `feDisplacementMap` applied via
   `filter:` (or `backdrop-filter: url(#id)` where supported) — this is
   what makes the blur look like it's refracting through uneven liquid
   glass instead of a flat frosted pane, and what makes it "liquid"
   instead of plain glassmorphism.

Full markup and the exact filter primitive values are in
`references/liquid-glass.md` and `templates/LiquidGlass.tsx`. Browser
support caveat: `feDisplacementMap`-through-`backdrop-filter` is Chromium/Safari-strong
but inconsistent on Firefox — the reference doc includes the
graceful-degradation fallback (plain blur, no displacement) to use behind
a `@supports` check.

## 4. Combining all three for a "glass logo badge"

When the ask is a logo badge that's both glassy *and* has liquid color
moving inside it: stack the ShaderGradient canvas (§2) as the bottom
layer, the liquid-glass panel (§3) directly on top with the same
mask/clip-path as the shader canvas, and the logo's linework (as a
static SVG, `currentColor` or brand color) as the top layer so it stays
crisp regardless of what's animating underneath. `templates/LiquidLogo.tsx`
includes this combined variant behind a `variant="glass"` prop — read the
comments there rather than re-deriving the layering order from scratch.

## Non-negotiables — read before shipping

1. **SSR: `Canvas` must be client-only.** In Next.js/Remix/any SSR
   framework, importing `@react-three/fiber`'s `Canvas` (directly or via
   `ShaderGradientCanvas`) into a server-rendered tree throws or produces
   a hydration mismatch, because `HTMLCanvasElement`/WebGL don't exist on
   the server. Wrap the component with `next/dynamic` (`{ ssr: false }`)
   or an equivalent client-only boundary — `references/react-three-fiber.md`
   has the exact snippet. This is the single most common bug report for
   this stack; check it first if something "doesn't render" only in prod.
2. **Respect `prefers-reduced-motion`.** A full-bleed animated shader is
   exactly the kind of motion that setting exists to suppress. Detect it
   and render a static gradient frame (`animate="off"`) or a pre-exported
   PNG/gradient CSS fallback instead of the live animation. Templates
   include this check — don't strip it out for a "cleaner" demo.
3. **Mobile/low-power fallback.** WebGL shader canvases are real GPU
   load, and stacking a second CSS displacement-filter panel on top adds
   more. On low-end/mobile, or when `navigator.hardwareConcurrency` /
   battery status signal a weak device, prefer a lighter static asset
   over silently tanking frame rate. Don't gold-plate this — a simple
   viewport-width or reduced-motion check usually covers the real cases;
   only add device-capability detection if the user asks for it.
4. **One canvas per logo instance, not one per repeat.** If the logo
   shows up in multiple places on a page (nav + footer + hero), don't
   instantiate a fresh `ShaderGradientCanvas` for each — that's N
   independent WebGL contexts fighting for the same GPU. Render one
   shader canvas positioned/masked for the primary instance and use a
   static exported frame (or plain brand-color SVG) for repeats. Say this
   to the user if you see them asking for the animated version in a
   place like a repeated nav logo.
5. **Don't fight the mask with `overflow: hidden` alone.** Clipping a
   WebGL canvas to a logo shape needs an actual mask
   (`mask-image`/`clip-path`), not just a container with `overflow:
   hidden` around a scaled canvas — that gives you a rectangle crop, not
   the logo's silhouette.

## Troubleshooting quick table

| Symptom | Likely cause | Fix |
|---|---|---|
| Blank/black canvas, no console error | `three`/`@react-three/fiber`/`@shadergradient/react` version mismatch | `npm info @shadergradient/react peerDependencies`, align versions |
| Hydration error / "document is not defined" in Next.js | `Canvas` imported into a server component | Client-only dynamic import, see `references/react-three-fiber.md` |
| Shader visible but logo shape not applied (full rectangle) | Mask applied to canvas element instead of wrapper, or mask SVG has no solid fill | Mask the wrapper `<div>`; ensure mask source has opaque fill, not just a stroke |
| Liquid-glass panel looks flat/no distortion | `feDisplacementMap` filter not applied, or Firefox (weaker support) | Check `references/liquid-glass.md` fallback section; verify filter is referenced by `filter:` not just defined and unused |
| Fans spin up / page janky on scroll | Multiple live `ShaderGradientCanvas` instances, or shader running off-screen | Pause/unmount canvases outside viewport (`IntersectionObserver`), enforce the one-canvas rule above |
| Looks great on desktop, chunky/pixelated on mobile | `pixelDensity`/`resolution` prop left at a low value, or DPR not set | Set `dpr` on `ShaderGradientCanvas` (e.g. `[1, 2]`) matching device pixel ratio, within the perf budget from item 3 above |
