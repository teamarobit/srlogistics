{{--
    Reusable Battery Truck SVG
    ──────────────────────────────────────────────────────────────
    Variables (all optional — sensible defaults apply):

    $b1Fill    string  fill colour for B1 battery indicator    default: '#94a3b8' (grey/untagged)
    $b1Stroke  string  stroke colour for B1                    default: '#64748b'
    $b2Fill    string  fill colour for B2 battery indicator    default: '#94a3b8'
    $b2Stroke  string  stroke colour for B2                    default: '#64748b'
    $svgClass  string  extra CSS class(es) on the <svg>        default: 'bat-truck-svg'
    $ariaLabel string  aria-label for screen readers           default: 'Truck battery position diagram'

    Usage examples:
        — Battery tagging page (RAG-driven colours):
          @include('svg.battery-truck', [
              'b1Fill'   => $b1Fill,   'b1Stroke' => $b1Stroke,
              'b2Fill'   => $b2Fill,   'b2Stroke' => $b2Stroke,
              'svgClass' => 'bat-truck-svg w-100',
          ])

        — Fleet dashboard vehicle details (fixed colours):
          @include('svg.battery-truck', [
              'b1Fill'   => '#22c55e', 'b1Stroke' => '#16a34a',
              'b2Fill'   => '#3b82f6', 'b2Stroke' => '#2563eb',
              'svgClass' => 'bat-truck-svg',
          ])
--}}
@php
    $b1Fill    = $b1Fill    ?? '#94a3b8';
    $b1Stroke  = $b1Stroke  ?? '#64748b';
    $b2Fill    = $b2Fill    ?? '#94a3b8';
    $b2Stroke  = $b2Stroke  ?? '#64748b';
    $svgClass  = $svgClass  ?? 'bat-truck-svg';
    $ariaLabel = $ariaLabel ?? 'Truck battery position diagram';
@endphp

<svg viewBox="0 0 300 170" xmlns="http://www.w3.org/2000/svg"
     class="{{ $svgClass }}" aria-label="{{ $ariaLabel }}">

    <!-- ── Cargo body ─────────────────────────────────────────────── -->
    <rect x="8" y="35" width="180" height="100" rx="5"
          fill="#e8edf5" stroke="#b0bdd4" stroke-width="2"/>

    <!-- Cargo ribs -->
    <line x1="48"  y1="35" x2="48"  y2="135" stroke="#c8d3e8" stroke-width="1"/>
    <line x1="88"  y1="35" x2="88"  y2="135" stroke="#c8d3e8" stroke-width="1"/>
    <line x1="128" y1="35" x2="128" y2="135" stroke="#c8d3e8" stroke-width="1"/>
    <line x1="168" y1="35" x2="168" y2="135" stroke="#c8d3e8" stroke-width="1"/>

    <!-- ── Cab ────────────────────────────────────────────────────── -->
    <rect x="188" y="52" width="100" height="83" rx="7"
          fill="#d1daf0" stroke="#b0bdd4" stroke-width="2"/>

    <!-- Windshield -->
    <path d="M192 57 L283 57 L283 95 L192 95 Z"
          fill="#bfdbfe" opacity="0.75" stroke="#93c5fd" stroke-width="1"/>

    <!-- Cab door line -->
    <line x1="230" y1="95" x2="230" y2="134"
          stroke="#b0bdd4" stroke-width="1.5" stroke-dasharray="3,3"/>

    <!-- Hood / engine area -->
    <rect x="188" y="100" width="100" height="35"
          fill="#c4cfe8" stroke="#b0bdd4" stroke-width="1"/>

    <!-- ── Exhaust stack ───────────────────────────────────────────── -->
    <rect x="275" y="30" width="8" height="25" rx="3"
          fill="#94a3b8" stroke="#64748b" stroke-width="1"/>
    <ellipse cx="279" cy="28" rx="6" ry="3" fill="#64748b"/>

    <!-- ── Battery B1 indicator ───────────────────────────────────── -->
    <rect x="196" y="106" width="32" height="20" rx="4"
          fill="{{ $b1Fill }}" stroke="{{ $b1Stroke }}" stroke-width="1.5"/>
    <text x="212" y="120" font-size="9" fill="white"
          text-anchor="middle" font-weight="700" font-family="sans-serif">B1</text>

    <!-- ── Battery B2 indicator ───────────────────────────────────── -->
    <rect x="234" y="106" width="32" height="20" rx="4"
          fill="{{ $b2Fill }}" stroke="{{ $b2Stroke }}" stroke-width="1.5"/>
    <text x="250" y="120" font-size="9" fill="white"
          text-anchor="middle" font-weight="700" font-family="sans-serif">B2</text>

    <!-- ── Wheels ─────────────────────────────────────────────────── -->
    <!-- Front -->
    <circle cx="240" cy="150" r="16" fill="#334155" stroke="#1e293b" stroke-width="2"/>
    <circle cx="240" cy="150" r="7"  fill="#94a3b8"/>
    <!-- Rear dual -->
    <circle cx="64"  cy="150" r="16" fill="#334155" stroke="#1e293b" stroke-width="2"/>
    <circle cx="64"  cy="150" r="7"  fill="#94a3b8"/>
    <circle cx="100" cy="150" r="16" fill="#334155" stroke="#1e293b" stroke-width="2"/>
    <circle cx="100" cy="150" r="7"  fill="#94a3b8"/>

    <!-- ── Mudguards ──────────────────────────────────────────────── -->
    <path d="M220 134 Q240 134 260 134" stroke="#b0bdd4" stroke-width="2" fill="none"/>
    <path d="M40 134 Q64 134 88 134 Q100 134 120 134" stroke="#b0bdd4" stroke-width="2" fill="none"/>

    <!-- ── Ground line ────────────────────────────────────────────── -->
    <line x1="5" y1="167" x2="295" y2="167" stroke="#e2e8f0" stroke-width="2"/>
</svg>
