# React Three Fiber ("react 3") — the engine underneath everything

React Three Fiber (`@react-three/fiber`, often shortened to "R3F" or,
colloquially, "react 3" since it's React-for-three.js) is the renderer
that both ShaderGradient and any hand-rolled liquid shader sit on top of.
You rarely write raw R3F code for a simple liquid logo — ShaderGradient
already wraps it — but you need to understand the two pieces it forces
into your tree: `Canvas` and the client/server boundary.

## Packages

```bash
npm install three @react-three/fiber @react-three/drei
```

- `three` — the actual WebGL engine (Three.js). Peer dependency of fiber.
- `@react-three/fiber` — the React renderer/reconciler for Three.js
  scenes. Gives you `<Canvas>` and lets you write Three.js objects as
  JSX (`<mesh>`, `<meshStandardMaterial>`, etc.).
- `@react-three/drei` — a grab-bag of ready-made helpers (camera
  controls, loaders, post-processing). ShaderGradient depends on a
  handful of these internally; install it even if you don't call it
  directly, because ShaderGradient's peer deps expect it present.

## The `Canvas` is a client-only boundary

`Canvas` mounts a real `<canvas>` DOM element and initializes a WebGL
context. Neither exists during server-side rendering. If your framework
does SSR (Next.js App/Pages Router, Remix, etc.), importing a component
that renders `Canvas` — directly, or indirectly through
`ShaderGradientCanvas` — into a server-rendered tree will either throw
(`document is not defined`, `HTMLCanvasElement is not defined`) or
silently produce a hydration mismatch.

**Next.js fix** — wrap the component in `next/dynamic` with `ssr: false`:

```tsx
// components/LiquidLogo.tsx — the actual R3F/ShaderGradient component,
// written as a normal component, no special SSR handling inside it.

// wherever it's used:
import dynamic from 'next/dynamic'

const LiquidLogo = dynamic(() => import('./LiquidLogo'), { ssr: false })
```

If the whole page/section is client-only anyway, a `'use client'`
directive at the top of the file is necessary but **not sufficient** on
its own for the App Router — `'use client'` stops the component from
running server logic, but the component can still be *server-rendered*
into HTML on first load unless it's also excluded via `dynamic(..., {
ssr: false })` or gated behind a mount-check (`useEffect` flipping a
`mounted` state before rendering `Canvas`). Use the `dynamic` import; it's
the simpler, less error-prone option.

**Vite/CRA/plain SPA:** no special handling needed — there's no server
render pass, so `Canvas` mounts on the client like any other component.

## Minimal raw R3F scene (for when ShaderGradient isn't enough)

Use this only if the user wants a genuinely custom 3D scene rather than
a flat animated gradient plane — e.g. the logo is an extruded 3D mark
with a liquid material, not just a 2D gradient mask.

```tsx
import { Canvas, useFrame } from '@react-three/fiber'
import { useRef } from 'react'
import * as THREE from 'three'

function LiquidMesh() {
  const meshRef = useRef<THREE.Mesh>(null)

  useFrame((state) => {
    if (!meshRef.current) return
    const material = meshRef.current.material as THREE.ShaderMaterial
    material.uniforms.uTime.value = state.clock.elapsedTime
  })

  return (
    <mesh ref={meshRef}>
      <planeGeometry args={[2, 2, 64, 64]} />
      <shaderMaterial
        uniforms={{ uTime: { value: 0 } }}
        vertexShader={/* glsl */ `
          uniform float uTime;
          varying vec2 vUv;
          void main() {
            vUv = uv;
            vec3 pos = position;
            pos.z += sin(pos.x * 4.0 + uTime) * 0.05;
            gl_Position = projectionMatrix * modelViewMatrix * vec4(pos, 1.0);
          }
        `}
        fragmentShader={/* glsl */ `
          varying vec2 vUv;
          void main() {
            gl_FragColor = vec4(vUv, 1.0, 1.0);
          }
        `}
      />
    </mesh>
  )
}

export function CustomLiquidLogo() {
  return (
    <Canvas camera={{ position: [0, 0, 2] }}>
      <LiquidMesh />
    </Canvas>
  )
}
```

Prefer ShaderGradient over hand-rolling this unless the user specifically
needs geometry/material control ShaderGradient doesn't expose — reinventing
a fluid-noise fragment shader from scratch is a lot of surface area for
what's usually a background effect.

## Performance basics that matter for a logo use case

- Set `dpr` on the `Canvas` (`dpr={[1, 2]}`) rather than leaving it
  uncapped — an uncapped `devicePixelRatio` on a high-DPI display can
  quietly triple the fragment shader's per-frame cost for a UI element
  that's often quite small on screen.
- `frameloop="demand"` on `Canvas` stops the render loop when nothing is
  changing — not appropriate for a continuously animating liquid shader,
  but worth knowing about if a static/paused fallback state ever needs to
  stop burning frames.
- Unmount or pause off-screen canvases (`IntersectionObserver`) rather
  than letting them render at full rate below the fold.
