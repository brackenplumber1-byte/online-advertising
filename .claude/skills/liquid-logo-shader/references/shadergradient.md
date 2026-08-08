# ShaderGradient — the animated liquid gradient layer

[`shadergradient`](https://www.npmjs.com/package/shadergradient) is the
core mesh/shader library; [`@shadergradient/react`](https://www.npmjs.com/package/@shadergradient/react)
is the React wrapper built on React Three Fiber that exposes it as JSX
components. Install both — the React package doesn't bundle the core.

```bash
npm install shadergradient @shadergradient/react three @react-three/fiber @react-three/drei
```

## Two components you need

- `ShaderGradientCanvas` — thin wrapper around R3F's `Canvas`, sized to
  fill its parent by default. This is the client-only boundary (see
  `references/react-three-fiber.md` for the SSR handling it needs).
- `ShaderGradient` — the actual mesh + shader material, rendered inside
  `ShaderGradientCanvas`. All the visual tuning props live here.

```tsx
'use client'

import { ShaderGradientCanvas, ShaderGradient } from '@shadergradient/react'

export function BasicLiquidBackground() {
  return (
    <ShaderGradientCanvas style={{ width: '100%', height: '100%' }}>
      <ShaderGradient
        type="waterPlane"
        animate="on"
        color1="#ff5941"
        color2="#8c6fff"
        color3="#0a84ff"
        uSpeed={0.3}
        uStrength={4}
        uDensity={1.5}
        cAzimuthAngle={180}
        cPolarAngle={80}
        cDistance={3.6}
        cameraZoom={1}
        reflection={0.1}
        grain="on"
      />
    </ShaderGradientCanvas>
  )
}
```

## Prop groups worth knowing

**Shape** — `type`: `"waterPlane"` (rippling liquid surface — what most
people mean by "liquid" look), `"plane"` (flatter, more subtle gradient
motion), `"sphere"` (orb/blob shape, good for a badge/icon-style logo).

**Motion** — `animate`: `"on" | "off"`. `uSpeed` (overall animation
speed), `uStrength`/`uDensity`/`uFrequency` (how pronounced/dense the
liquid noise pattern is — push these up for a more "turbulent" look,
down for something calmer and more brand-safe).

**Color** — `color1`/`color2`/`color3` (hex strings — use brand colors
here), `brightness`, `grain` (`"on"`/`"off"`, adds a subtle noise/grain
texture that helps hide gradient banding, especially useful when a logo
mask crops the gradient to a small area where banding is more visible).

**Camera** — `cAzimuthAngle`, `cPolarAngle`, `cDistance`, `cameraZoom`,
`cameraSpeed` (if using `zoomOut` type). These control framing, not
motion of the liquid itself — get them wrong and the "interesting" part
of the gradient sits outside the visible/masked area.

**Reflection/lighting** — `reflection`, `envPreset`, `lightType` — subtle
by default; increasing `reflection` gives more of a wet/glassy sheen,
which pairs well when this layer sits behind a liquid-glass panel (see
`references/liquid-glass.md`) since the two effects read as one coherent
"wet glass" material rather than two unrelated layers.

## Fastest way to dial in prop values

Don't hand-tune all of these blind. [shadergradient.co](https://www.shadergradient.co)
has a live visual editor — build the look there, then it has an "export
as React code" option that gives you the exact prop values to paste in.
Point the user at it if they want to art-direct the exact colors/motion
rather than accepting a first-pass guess, and mention it proactively —
it's much faster than iterating prop-by-prop in code.

## Static fallback frame (for `prefers-reduced-motion` / low-power mode)

Setting `animate="off"` freezes the shader on its first frame instead of
looping — cheap to render (no continuous frame updates) and still shows
the gradient's shape/color, just not the motion. This is the fallback to
reach for per the SKILL.md non-negotiable on respecting reduced-motion,
rather than removing the shader entirely:

```tsx
import { useReducedMotion } from 'framer-motion' // or any equivalent hook

function LiquidLogo() {
  const reduceMotion = useReducedMotion()
  return (
    <ShaderGradientCanvas style={{ width: '100%', height: '100%' }}>
      <ShaderGradient
        type="waterPlane"
        animate={reduceMotion ? 'off' : 'on'}
        // ...rest of props
      />
    </ShaderGradientCanvas>
  )
}
```

If `framer-motion` isn't already a dependency, use the plain media-query
hook instead of adding it just for this:

```tsx
function usePrefersReducedMotion() {
  const [reduced, setReduced] = useState(false)
  useEffect(() => {
    const mql = window.matchMedia('(prefers-reduced-motion: reduce)')
    setReduced(mql.matches)
    const handler = (e: MediaQueryListEvent) => setReduced(e.matches)
    mql.addEventListener('change', handler)
    return () => mql.removeEventListener('change', handler)
  }, [])
  return reduced
}
```

## Masking to a logo shape

ShaderGradient renders a full rectangle — the logo shape comes from CSS
masking the canvas's wrapper, not from anything ShaderGradient itself
knows about. See `templates/LiquidLogo.tsx` for the working version; the
short version:

```tsx
<div
  style={{
    width: 240,
    height: 80,
    WebkitMaskImage: `url(${logoMaskSvgUrl})`,
    maskImage: `url(${logoMaskSvgUrl})`,
    WebkitMaskSize: 'contain',
    maskSize: 'contain',
    WebkitMaskRepeat: 'no-repeat',
    maskRepeat: 'no-repeat',
    WebkitMaskPosition: 'center',
    maskPosition: 'center',
  }}
>
  <ShaderGradientCanvas style={{ width: '100%', height: '100%' }}>
    <ShaderGradient type="waterPlane" animate="on" /* ...props */ />
  </ShaderGradientCanvas>
</div>
```

The mask source SVG/PNG needs an **opaque fill** where the logo should
show the shader through (mask alpha = visibility), not just an outline
stroke — a stroke-only logo mark will mask down to a thin sliver of
visible gradient.
