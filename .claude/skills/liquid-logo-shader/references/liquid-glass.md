# Liquid glass — the frosted/refractive panel effect

"Liquid glass" is the Apple-Vision-Pro / visionOS-style material: a
frosted panel that also looks like it's *bending* light through an
uneven, liquid-like surface, rather than a flat frosted-glass blur
(plain "glassmorphism"). It's pure CSS + SVG — no WebGL, no new npm
package — which makes it cheap to add even to a page that has no
React Three Fiber anywhere else.

Two layers stack to produce it:

1. **The glass base** — `backdrop-filter: blur() saturate()` on a
   semi-transparent panel. This alone is plain glassmorphism (flat,
   uniform blur).
2. **The liquid distortion** — an SVG `<filter>` combining
   `feTurbulence` (procedural noise, the "liquid" part) with
   `feDisplacementMap` (uses that noise to warp/refract whatever's
   behind the panel). Applying this filter is what turns a flat frosted
   pane into something that reads as uneven glass.

## The SVG filter

Put this once per page (it can be visually hidden — `<svg>` with
`width="0" height="0"` — since it's referenced by `id`, not rendered
directly):

```html
<svg width="0" height="0" style={{ position: 'absolute' }}>
  <filter id="liquid-glass-distortion" x="-20%" y="-20%" width="140%" height="140%">
    <feTurbulence
      type="fractalNoise"
      baseFrequency="0.008 0.012"
      numOctaves="2"
      seed="7"
      result="noise"
    />
    <feGaussianBlur in="noise" stdDeviation="2" result="blurredNoise" />
    <feDisplacementMap
      in="SourceGraphic"
      in2="blurredNoise"
      scale="28"
      xChannelSelector="R"
      yChannelSelector="G"
    />
  </filter>
</svg>
```

Tuning knobs:

- `baseFrequency` — lower = larger, slower-feeling liquid ripples;
  higher = tighter, more turbulent texture. Start around `0.008–0.02`.
- `scale` on `feDisplacementMap` — how strongly the noise warps the
  content. Too high and text/content behind the glass becomes
  unreadable; keep it modest (20-40) for a panel with real content
  behind it, and reserve higher values for a purely decorative badge
  with no legibility requirement behind it.
- `seed` — change it to get a different-looking (but equally valid)
  noise pattern; doesn't need to be animated for a static "liquid glass
  look", only if you want the surface itself to visibly writhe (see
  animation section below).

## Applying it to a panel

```css
.liquid-glass-panel {
  position: relative;
  backdrop-filter: blur(16px) saturate(160%);
  -webkit-backdrop-filter: blur(16px) saturate(160%);
  background: rgba(255, 255, 255, 0.12);
  border: 1px solid rgba(255, 255, 255, 0.25);
  border-radius: 20px;
  /* the liquid warp */
  filter: url(#liquid-glass-distortion);
}
```

Order matters: `backdrop-filter` samples what's *behind* the element;
`filter` (with the SVG reference) distorts the element's *own* rendered
output, including its blurred backdrop. Applying both on the same
element is what gives the "warped frosted glass" look rather than a
crisp blur with an unrelated distortion floating on top.

## Browser support caveat and fallback

Chromium and Safari render `feDisplacementMap`-based `filter` on an
element with `backdrop-filter` reliably. Firefox's support here is
inconsistent — the safe pattern is a `@supports` (or JS feature-detect)
fallback to a plain blurred panel, no distortion, rather than a broken
or invisible panel:

```css
.liquid-glass-panel {
  backdrop-filter: blur(16px) saturate(160%);
  -webkit-backdrop-filter: blur(16px) saturate(160%);
  background: rgba(255, 255, 255, 0.12);
  border: 1px solid rgba(255, 255, 255, 0.25);
  border-radius: 20px;
}

@supports (filter: url(#liquid-glass-distortion)) {
  .liquid-glass-panel {
    filter: url(#liquid-glass-distortion);
  }
}
```

`@supports` here checks the browser will apply *some* `filter: url()`
reference at all — it can't verify the specific SVG resolves, but in
practice this is enough to skip the distortion on the browsers known to
mishandle it while keeping the base frosted-glass look everywhere.

## Optional: animating the liquid surface

For a panel that visibly writhes rather than holding a static warp,
animate the turbulence's seed or the displacement scale over time via a
`requestAnimationFrame` loop setting the SVG filter's attributes
directly (CSS can't animate `feTurbulence`'s `baseFrequency` smoothly
across browsers):

```tsx
useEffect(() => {
  const turbulence = document.querySelector('#liquid-glass-distortion feDisplacementMap')
  if (!turbulence) return
  let raf: number
  const start = performance.now()
  const animate = (now: number) => {
    const t = (now - start) / 1000
    turbulence.setAttribute('scale', String(28 + Math.sin(t * 0.6) * 8))
    raf = requestAnimationFrame(animate)
  }
  raf = requestAnimationFrame(animate)
  return () => cancelAnimationFrame(raf)
}, [])
```

This is a real per-frame DOM write — respect `prefers-reduced-motion`
the same way as the ShaderGradient layer (see `references/shadergradient.md`),
and skip the animation loop entirely rather than just slowing it down.

See `templates/LiquidGlass.tsx` for a complete component wiring the SVG
filter, the panel, and the reduced-motion check together.
