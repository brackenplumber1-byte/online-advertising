# liquid-logo-shader

Claude Code skill for building an animated "liquid logo" in a React app:
a shader-driven fluid gradient (ShaderGradient, running on React Three
Fiber) masked to a logo's shape, optionally combined with a "liquid
glass" frosted/refractive panel effect.

See `SKILL.md` for the full playbook Claude follows. This README is a
quick orientation for a human browsing the repo.

## What's in here

```
liquid-logo-shader/
├── SKILL.md                          # the playbook Claude reads when the skill triggers
├── README.md                         # this file
├── references/
│   ├── react-three-fiber.md          # Canvas/SSR setup, the R3F layer under everything
│   ├── shadergradient.md             # the animated liquid gradient layer + props
│   └── liquid-glass.md               # the frosted/refractive CSS+SVG panel effect
└── templates/
    ├── LiquidLogo.tsx                # working component: shader masked to a logo, "plain" or "glass" variant
    └── LiquidGlass.tsx               # working component: standalone liquid-glass panel, no WebGL
```

## Packages this skill installs

```bash
npm install three @react-three/fiber @react-three/drei @shadergradient/react shadergradient
```

The liquid-glass panel effect (`LiquidGlass.tsx`) needs no extra
package — it's native CSS `backdrop-filter` + an inline SVG filter.

## Quick start

Copy `templates/LiquidLogo.tsx` into the target project's components
folder, then:

```tsx
import dynamic from 'next/dynamic' // Next.js only — plain Vite/CRA apps can import directly

const LiquidLogo = dynamic(() => import('@/components/LiquidLogo'), { ssr: false })

<LiquidLogo
  maskSrc="/logo-mask.svg"
  color1="#ff5941"
  color2="#8c6fff"
  color3="#0a84ff"
  width={240}
  height={80}
/>
```

`maskSrc` must be an SVG or PNG with an **opaque fill** where the shader
should show through — see `references/shadergradient.md` for how to
build one from an existing logo asset.
