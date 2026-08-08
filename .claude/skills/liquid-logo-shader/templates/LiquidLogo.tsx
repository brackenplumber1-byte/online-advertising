'use client'

/**
 * LiquidLogo — an animated liquid-shader gradient masked to a logo shape,
 * with an optional "glass" variant that layers a liquid-glass panel and
 * crisp logo linework on top.
 *
 * Requires: three @react-three/fiber @react-three/drei
 *           @shadergradient/react shadergradient
 *
 * SSR (Next.js): import this component via
 *   const LiquidLogo = dynamic(() => import('./LiquidLogo'), { ssr: false })
 * — Canvas/WebGL cannot render on the server. See
 * .claude/skills/liquid-logo-shader/references/react-three-fiber.md.
 */

import { useEffect, useState, type CSSProperties } from 'react'
import { ShaderGradientCanvas, ShaderGradient } from '@shadergradient/react'

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

export interface LiquidLogoProps {
  /** URL to an SVG or PNG mask: opaque where the shader should show through. */
  maskSrc: string
  /** Optional crisp logo linework rendered on top (only used by variant="glass"). */
  logoSrc?: string
  width?: number
  height?: number
  color1?: string
  color2?: string
  color3?: string
  /** "plain" = just the masked shader. "glass" = shader + liquid-glass panel + logo linework. */
  variant?: 'plain' | 'glass'
  className?: string
}

export default function LiquidLogo({
  maskSrc,
  logoSrc,
  width = 240,
  height = 80,
  color1 = '#ff5941',
  color2 = '#8c6fff',
  color3 = '#0a84ff',
  variant = 'plain',
  className,
}: LiquidLogoProps) {
  const reduceMotion = usePrefersReducedMotion()

  const maskStyle: CSSProperties = {
    width,
    height,
    WebkitMaskImage: `url(${maskSrc})`,
    maskImage: `url(${maskSrc})`,
    WebkitMaskSize: 'contain',
    maskSize: 'contain',
    WebkitMaskRepeat: 'no-repeat',
    maskRepeat: 'no-repeat',
    WebkitMaskPosition: 'center',
    maskPosition: 'center',
    position: 'relative',
    overflow: 'hidden',
  }

  const shaderCanvas = (
    <ShaderGradientCanvas style={{ width: '100%', height: '100%' }} pixelDensity={1} pointerEvents="none">
      <ShaderGradient
        type="waterPlane"
        animate={reduceMotion ? 'off' : 'on'}
        color1={color1}
        color2={color2}
        color3={color3}
        uSpeed={0.3}
        uStrength={4}
        uDensity={1.5}
        cAzimuthAngle={180}
        cPolarAngle={80}
        cDistance={3.6}
        cameraZoom={1}
        reflection={0.15}
        grain="on"
      />
    </ShaderGradientCanvas>
  )

  if (variant === 'plain') {
    return (
      <div className={className} style={maskStyle}>
        {shaderCanvas}
      </div>
    )
  }

  // variant === 'glass': shader behind a liquid-glass panel, logo linework on top.
  // Filter distortion is scoped to this instance's SVG id to avoid collisions
  // if multiple LiquidLogo(variant="glass") instances render on one page.
  const filterId = `liquid-logo-glass-${Math.random().toString(36).slice(2, 9)}`

  return (
    <div className={className} style={{ width, height, position: 'relative' }}>
      <svg width="0" height="0" style={{ position: 'absolute' }} aria-hidden>
        <filter id={filterId} x="-20%" y="-20%" width="140%" height="140%">
          <feTurbulence type="fractalNoise" baseFrequency="0.01 0.015" numOctaves={2} seed={7} result="noise" />
          <feGaussianBlur in="noise" stdDeviation="2" result="blurredNoise" />
          <feDisplacementMap
            in="SourceGraphic"
            in2="blurredNoise"
            scale={reduceMotion ? 0 : 24}
            xChannelSelector="R"
            yChannelSelector="G"
          />
        </filter>
      </svg>

      <div style={maskStyle}>{shaderCanvas}</div>

      <div
        style={{
          position: 'absolute',
          inset: 0,
          backdropFilter: 'blur(14px) saturate(160%)',
          WebkitBackdropFilter: 'blur(14px) saturate(160%)',
          background: 'rgba(255, 255, 255, 0.10)',
          border: '1px solid rgba(255, 255, 255, 0.25)',
          borderRadius: 16,
          filter: `url(#${filterId})`,
          ...maskStyle,
          width: '100%',
          height: '100%',
        }}
      />

      {logoSrc && (
        <img
          src={logoSrc}
          alt=""
          style={{
            position: 'absolute',
            inset: 0,
            width: '100%',
            height: '100%',
            objectFit: 'contain',
            pointerEvents: 'none',
          }}
        />
      )}
    </div>
  )
}
