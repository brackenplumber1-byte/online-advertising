'use client'

/**
 * LiquidGlass — a standalone frosted/refractive "liquid glass" panel.
 * No WebGL, no ShaderGradient dependency — pure CSS backdrop-filter +
 * an SVG feTurbulence/feDisplacementMap filter. Use this on its own for
 * nav bars, cards, or badges that need the glassy-liquid look without an
 * animated gradient behind them.
 *
 * See .claude/skills/liquid-logo-shader/references/liquid-glass.md for
 * the full breakdown of what each filter primitive does and the
 * Firefox fallback rationale.
 */

import { useEffect, useRef, useState, type CSSProperties, type ReactNode } from 'react'

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

export interface LiquidGlassProps {
  children?: ReactNode
  /** Animate the liquid surface (subtle continuous warp) instead of a static distortion. */
  animated?: boolean
  borderRadius?: number
  blur?: number
  style?: CSSProperties
  className?: string
}

let instanceCount = 0

export default function LiquidGlass({
  children,
  animated = false,
  borderRadius = 20,
  blur = 16,
  style,
  className,
}: LiquidGlassProps) {
  const reduceMotion = usePrefersReducedMotion()
  const [filterId] = useState(() => `liquid-glass-${++instanceCount}`)
  const displacementRef = useRef<SVGFEDisplacementMapElement>(null)

  useEffect(() => {
    if (!animated || reduceMotion) return
    const node = displacementRef.current
    if (!node) return

    let raf: number
    const start = performance.now()
    const tick = (now: number) => {
      const t = (now - start) / 1000
      node.setAttribute('scale', String(24 + Math.sin(t * 0.6) * 8))
      raf = requestAnimationFrame(tick)
    }
    raf = requestAnimationFrame(tick)
    return () => cancelAnimationFrame(raf)
  }, [animated, reduceMotion])

  return (
    <div style={{ position: 'relative', ...style }} className={className}>
      <svg width="0" height="0" style={{ position: 'absolute' }} aria-hidden>
        <filter id={filterId} x="-20%" y="-20%" width="140%" height="140%">
          <feTurbulence type="fractalNoise" baseFrequency="0.008 0.012" numOctaves={2} seed={7} result="noise" />
          <feGaussianBlur in="noise" stdDeviation="2" result="blurredNoise" />
          <feDisplacementMap
            ref={displacementRef}
            in="SourceGraphic"
            in2="blurredNoise"
            scale={reduceMotion ? 0 : 28}
            xChannelSelector="R"
            yChannelSelector="G"
          />
        </filter>
      </svg>

      <div
        style={{
          position: 'relative',
          backdropFilter: `blur(${blur}px) saturate(160%)`,
          WebkitBackdropFilter: `blur(${blur}px) saturate(160%)`,
          background: 'rgba(255, 255, 255, 0.12)',
          border: '1px solid rgba(255, 255, 255, 0.25)',
          borderRadius,
          // @supports fallback: browsers that mishandle filter:url() on a
          // backdrop-filter element just keep the plain frosted look.
          filter: `url(#${filterId})`,
        }}
      >
        {children}
      </div>
    </div>
  )
}
