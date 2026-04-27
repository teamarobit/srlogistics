@php
/*─────────────────────────────────────────────────────────────────────────────
 | resources/views/svg/truck.blade.php
 | Dynamic Truck SVG — adapts to vehicle's mounted_tyre_count (6 / 10 / 12).
 |
 | Required variables:
 |   int     $mountedTyreCount   — e.g. 6, 10, 12
 |   string  $mode               — 'tagging'  or  'details'
 |
 | Optional variables:
 |   string  $svgId              — id attr on <svg>  (default: 'truckSvg')
 |
 | Details-mode only (pass when $mode === 'details'):
 |   Collection|array  $byCode          — tyre mappings keyed by position code
 |   Closure           $getTyreColor    — fn($mapping): 'good'|'warn'|'critical'|'empty'
 |   array             $colorHex        — ['good'=>'#…', 'warn'=>'#…', …]
 |   array             $posLabels       — ['C1'=>'Front Left', …]
 |
 | Layout configs:
 |   6-wheel  → 1 front single axle + 1 rear dual axle
 |   10-wheel → 1 front single axle + 2 rear dual axles        (default / fallback)
 |   12-wheel → 1 front single axle + 2 rear dual axles + 1 rear trailing single axle (C6, D6)
 *─────────────────────────────────────────────────────────────────────────────*/

$tyreCount = (int)($mountedTyreCount ?? 10);
$svgId     = $svgId ?? 'truckSvg';
$isDetails = (($mode ?? 'tagging') === 'details');
$svgClass  = $isDetails ? 'vtd-truck-svg' : '';
$svgStyle  = $isDetails ? '' : 'width:100%;max-width:220px;margin:0 auto;display:block;';

/* ── Layout config ──────────────────────────────────────────────────────────── */
if ($tyreCount <= 6) {
    $viewBox    = '0 0 220 330';
    $bodyH      = 254;   // outer shadow height
    $mainH      = 250;   // main body height
    $cargoH     = 136;   // cargo section height (y=182 → y=318)
    $showAxle2  = false;
    $showAxle3  = false;
    $cargoLines = [228];
} elseif ($tyreCount <= 10) {
    $viewBox    = '0 0 220 430';
    $bodyH      = 354;
    $mainH      = 350;
    $cargoH     = 236;   // y=182 → y=418
    $showAxle2  = true;
    $showAxle3  = false;
    $cargoLines = [228, 310, 392];
} else {
    // 12-wheel — adds C6 / D6 trailing single axle at y≈460
    $viewBox    = '0 0 220 520';
    $bodyH      = 444;
    $mainH      = 440;
    $cargoH     = 326;   // y=182 → y=508
    $showAxle2  = true;
    $showAxle3  = true;
    $cargoLines = [228, 310, 392, 480];
}

/* ── Details-mode helpers ────────────────────────────────────────────────────── */
$byCode       = $byCode       ?? [];
$getTyreColor = $getTyreColor ?? fn($m) => 'empty';
$colorHex     = $colorHex     ?? [
    'good'     => '#10863f',
    'warn'     => '#d97706',
    'critical' => '#ea0027',
    'empty'    => '#dee2e6',
];
$posLabels = $posLabels ?? [];
$defFill   = '#adb5bd';

/* Returns the fill hex for a tyre position */
$fill = fn(string $code): string => $isDetails
    ? ($colorHex[$getTyreColor($byCode[$code] ?? null)] ?? $defFill)
    : $defFill;

/* Builds the data-* attribute string for details mode (empty string in tagging mode) */
$dataAttrs = function(string $code) use ($isDetails, $byCode, $getTyreColor, $posLabels): string {
    if (!$isDetails) {
        return '';
    }
    $tm      = $byCode[$code] ?? null;
    $label   = htmlspecialchars($posLabels[$code] ?? $code, ENT_QUOTES);
    $serial  = htmlspecialchars($tm?->tyre?->tyre_serial_number ?? '', ENT_QUOTES);
    $brand   = htmlspecialchars($tm?->tyre?->tyre_brand ?? '', ENT_QUOTES);
    $model   = htmlspecialchars($tm?->tyre?->tyre_model ?? '', ENT_QUOTES);
    $cond    = htmlspecialchars($tm?->tyre?->tyre_condition ?? '', ENT_QUOTES);
    $status  = $getTyreColor($tm);
    $fitted  = ($tm && $tm->fitment_date)
               ? \Carbon\Carbon::parse($tm->fitment_date)->format('d M Y')
               : '';
    $kmlife  = $tm?->tyre?->fixed_run_km  ?? '';
    $kmrun   = $tm?->tyre?->actual_run_km ?? '';
    $hasTyre = ($tm && $tm->tyre) ? '1' : '0';

    return ' id="svg-' . $code . '"'
         . ' class="vtd-svg-tyre"'
         . ' data-pos="'       . $code     . '"'
         . ' data-label="'     . $label    . '"'
         . ' data-has-tyre="'  . $hasTyre  . '"'
         . ' data-serial="'    . $serial   . '"'
         . ' data-brand="'     . $brand    . '"'
         . ' data-model="'     . $model    . '"'
         . ' data-condition="' . $cond     . '"'
         . ' data-status="'    . $status   . '"'
         . ' data-fitted="'    . $fitted   . '"'
         . ' data-kmlife="'    . $kmlife   . '"'
         . ' data-kmrun="'     . $kmrun    . '"';
};
@endphp

<svg id="{{ $svgId }}"
     viewBox="{{ $viewBox }}"
     xmlns="http://www.w3.org/2000/svg"
     @if($svgClass) class="{{ $svgClass }}" @endif
     @if($svgStyle) style="{{ $svgStyle }}" @endif>

    {{-- ▲ FRONT direction label --}}
    <text x="110" y="48" text-anchor="middle" font-size="9" fill="#94a3b8" font-weight="700" letter-spacing="1">▲ FRONT</text>

    {{-- ── TRUCK OUTER BODY (shadow + frame) ──────────────────────────────────── --}}
    <rect x="57" y="70" width="106" height="{{ $bodyH }}" rx="16" fill="#e2e8f0" stroke="none"/>
    <rect x="59" y="72" width="102" height="{{ $mainH }}" rx="14" fill="#f0f3f9" stroke="#c8d4e8" stroke-width="1.5"/>

    {{-- ── CAB SECTION ─────────────────────────────────────────────────────────── --}}
    {{-- Cab background --}}
    <rect x="59" y="72" width="102" height="108" rx="14" fill="#dce7ff" stroke="#b0c4f0" stroke-width="1.5"/>
    {{-- Windshield --}}
    <rect x="71" y="80" width="78" height="34" rx="6" fill="#b8d0f5" opacity="0.85"/>
    {{-- Windshield glare lines --}}
    <line x1="77" y1="83" x2="77" y2="111" stroke="#fff" stroke-width="1.5" stroke-linecap="round" opacity="0.5"/>
    <line x1="83" y1="81" x2="83" y2="113" stroke="#fff" stroke-width="0.7" stroke-linecap="round" opacity="0.25"/>
    {{-- Hood / front bonnet --}}
    <rect x="71" y="116" width="78" height="14" rx="3" fill="#c8d8f0" stroke="#b0c4e8" stroke-width="1"/>
    {{-- Side mirrors --}}
    <rect x="45" y="84" width="14" height="9" rx="2.5" fill="#b0c4e8" stroke="#9ab0d8" stroke-width="1"/>
    <rect x="161" y="84" width="14" height="9" rx="2.5" fill="#b0c4e8" stroke="#9ab0d8" stroke-width="1"/>
    {{-- Mirror stems --}}
    <line x1="59" y1="88" x2="65" y2="88" stroke="#a0b4d0" stroke-width="1.5"/>
    <line x1="155" y1="88" x2="161" y2="88" stroke="#a0b4d0" stroke-width="1.5"/>
    {{-- Cab label --}}
    <text x="110" y="160" text-anchor="middle" font-size="7" fill="#7b93c4" font-weight="600" letter-spacing="1.5">CAB</text>
    {{-- Cab / cargo separator --}}
    <line x1="64" y1="180" x2="156" y2="180" stroke="#c8d4e8" stroke-width="1.5" stroke-dasharray="3,2"/>

    {{-- ── CARGO BODY ───────────────────────────────────────────────────────────── --}}
    <rect x="63" y="182" width="94" height="{{ $cargoH }}" rx="4" fill="#f5f7fb" stroke="#dce3f0" stroke-width="1"/>
    {{-- Cargo panel section lines (count depends on layout) --}}
    @foreach($cargoLines as $_ly)
        <line x1="63" y1="{{ $_ly }}" x2="157" y2="{{ $_ly }}" stroke="#e0e8f4" stroke-width="1"/>
    @endforeach
    {{-- Cargo label --}}
    <text x="110" y="266" text-anchor="middle" font-size="7" fill="#b0bcce" letter-spacing="2">CARGO</text>

    {{-- ── SPARE LABEL ─────────────────────────────────────────────────────────── --}}
    <text x="110" y="226" text-anchor="middle" font-size="5.5" fill="#adb5bd" letter-spacing="0.5">SPARE</text>

    {{-- ── FRONT AXLE ───────────────────────────────────────────────────────────── --}}
    <text x="110" y="119" text-anchor="middle" font-size="6.5" fill="#adb5bd" letter-spacing="0.5">FRONT AXLE</text>
    <rect x="30" y="124" width="160" height="4" rx="2" fill="#c0ccde"/>
    <circle cx="42"  cy="126" r="4" fill="#9ab0cc" stroke="#8098b8" stroke-width="1"/>
    <circle cx="178" cy="126" r="4" fill="#9ab0cc" stroke="#8098b8" stroke-width="1"/>

    {{-- C1 — Front Left Steer --}}
    @if(!$isDetails)<g class="tyre-group" data-code="C1">@endif
    <rect{!! $dataAttrs('C1') !!} x="30" y="109" width="24" height="34" rx="5" fill="{{ $fill('C1') }}" stroke="#fff" stroke-width="1.5"/>
    <text x="42" y="131" text-anchor="middle" font-size="8" fill="#fff" font-weight="700">C1</text>
    @if(!$isDetails)</g>@endif

    {{-- D1 — Front Right Steer --}}
    @if(!$isDetails)<g class="tyre-group" data-code="D1">@endif
    <rect{!! $dataAttrs('D1') !!} x="166" y="109" width="24" height="34" rx="5" fill="{{ $fill('D1') }}" stroke="#fff" stroke-width="1.5"/>
    <text x="178" y="131" text-anchor="middle" font-size="8" fill="#fff" font-weight="700">D1</text>
    @if(!$isDetails)</g>@endif

    {{-- ── SPARE TYRES (always shown — position fixed in cargo section) ─────────── --}}
    {{-- S1 — Spare / Stepney --}}
    @if(!$isDetails)<g class="tyre-group" data-code="S1">@endif
    <rect{!! $dataAttrs('S1') !!} x="87" y="230" width="21" height="26" rx="4" fill="{{ $fill('S1') }}" stroke="#fff" stroke-width="1.5"/>
    <text x="97" y="246" text-anchor="middle" font-size="6" fill="#fff" font-weight="700">S1</text>
    @if(!$isDetails)</g>@endif

    {{-- S2 — Spare 2 --}}
    @if(!$isDetails)<g class="tyre-group" data-code="S2">@endif
    <rect{!! $dataAttrs('S2') !!} x="112" y="230" width="21" height="26" rx="4" fill="{{ $fill('S2') }}" stroke="#fff" stroke-width="1.5"/>
    <text x="122" y="246" text-anchor="middle" font-size="6" fill="#fff" font-weight="700">S2</text>
    @if(!$isDetails)</g>@endif

    {{-- ── REAR AXLE 1 (all configs) ────────────────────────────────────────────── --}}
    <text x="110" y="276" text-anchor="middle" font-size="6.5" fill="#adb5bd" letter-spacing="0.5">REAR AXLE 1</text>
    <rect x="16" y="280" width="188" height="4" rx="2" fill="#c0ccde"/>
    <circle cx="29"  cy="282" r="3.5" fill="#9ab0cc" stroke="#8098b8" stroke-width="1"/>
    <circle cx="50"  cy="282" r="3.5" fill="#9ab0cc" stroke="#8098b8" stroke-width="1"/>
    <circle cx="170" cy="282" r="3.5" fill="#9ab0cc" stroke="#8098b8" stroke-width="1"/>
    <circle cx="191" cy="282" r="3.5" fill="#9ab0cc" stroke="#8098b8" stroke-width="1"/>

    {{-- Co3 — Rear Axle 1, Left Outer --}}
    @if(!$isDetails)<g class="tyre-group" data-code="Co3">@endif
    <rect{!! $dataAttrs('Co3') !!} x="20" y="267" width="19" height="30" rx="4" fill="{{ $fill('Co3') }}" stroke="#fff" stroke-width="1.5"/>
    <text x="29" y="286" text-anchor="middle" font-size="6" fill="#fff" font-weight="700">Co3</text>
    @if(!$isDetails)</g>@endif

    {{-- Ci2 — Rear Axle 1, Left Inner --}}
    @if(!$isDetails)<g class="tyre-group" data-code="Ci2">@endif
    <rect{!! $dataAttrs('Ci2') !!} x="41" y="267" width="19" height="30" rx="4" fill="{{ $fill('Ci2') }}" stroke="#fff" stroke-width="1.5"/>
    <text x="50" y="286" text-anchor="middle" font-size="6" fill="#fff" font-weight="700">Ci2</text>
    @if(!$isDetails)</g>@endif

    {{-- Di2 — Rear Axle 1, Right Inner --}}
    @if(!$isDetails)<g class="tyre-group" data-code="Di2">@endif
    <rect{!! $dataAttrs('Di2') !!} x="160" y="267" width="19" height="30" rx="4" fill="{{ $fill('Di2') }}" stroke="#fff" stroke-width="1.5"/>
    <text x="169" y="286" text-anchor="middle" font-size="6" fill="#fff" font-weight="700">Di2</text>
    @if(!$isDetails)</g>@endif

    {{-- Do3 — Rear Axle 1, Right Outer --}}
    @if(!$isDetails)<g class="tyre-group" data-code="Do3">@endif
    <rect{!! $dataAttrs('Do3') !!} x="181" y="267" width="19" height="30" rx="4" fill="{{ $fill('Do3') }}" stroke="#fff" stroke-width="1.5"/>
    <text x="190" y="286" text-anchor="middle" font-size="6" fill="#fff" font-weight="700">Do3</text>
    @if(!$isDetails)</g>@endif

    {{-- ── REAR AXLE 2 (10-wheel and 12-wheel only) ────────────────────────────── --}}
    @if($showAxle2)
    <text x="110" y="366" text-anchor="middle" font-size="6.5" fill="#adb5bd" letter-spacing="0.5">REAR AXLE 2</text>
    <rect x="16" y="370" width="188" height="4" rx="2" fill="#c0ccde"/>
    <circle cx="29"  cy="372" r="3.5" fill="#9ab0cc" stroke="#8098b8" stroke-width="1"/>
    <circle cx="50"  cy="372" r="3.5" fill="#9ab0cc" stroke="#8098b8" stroke-width="1"/>
    <circle cx="170" cy="372" r="3.5" fill="#9ab0cc" stroke="#8098b8" stroke-width="1"/>
    <circle cx="191" cy="372" r="3.5" fill="#9ab0cc" stroke="#8098b8" stroke-width="1"/>

    {{-- Co5 — Rear Axle 2, Left Outer --}}
    @if(!$isDetails)<g class="tyre-group" data-code="Co5">@endif
    <rect{!! $dataAttrs('Co5') !!} x="20" y="357" width="19" height="30" rx="4" fill="{{ $fill('Co5') }}" stroke="#fff" stroke-width="1.5"/>
    <text x="29" y="376" text-anchor="middle" font-size="6" fill="#fff" font-weight="700">Co5</text>
    @if(!$isDetails)</g>@endif

    {{-- Ci4 — Rear Axle 2, Left Inner --}}
    @if(!$isDetails)<g class="tyre-group" data-code="Ci4">@endif
    <rect{!! $dataAttrs('Ci4') !!} x="41" y="357" width="19" height="30" rx="4" fill="{{ $fill('Ci4') }}" stroke="#fff" stroke-width="1.5"/>
    <text x="50" y="376" text-anchor="middle" font-size="6" fill="#fff" font-weight="700">Ci4</text>
    @if(!$isDetails)</g>@endif

    {{-- Di4 — Rear Axle 2, Right Inner --}}
    @if(!$isDetails)<g class="tyre-group" data-code="Di4">@endif
    <rect{!! $dataAttrs('Di4') !!} x="160" y="357" width="19" height="30" rx="4" fill="{{ $fill('Di4') }}" stroke="#fff" stroke-width="1.5"/>
    <text x="169" y="376" text-anchor="middle" font-size="6" fill="#fff" font-weight="700">Di4</text>
    @if(!$isDetails)</g>@endif

    {{-- Do5 — Rear Axle 2, Right Outer --}}
    @if(!$isDetails)<g class="tyre-group" data-code="Do5">@endif
    <rect{!! $dataAttrs('Do5') !!} x="181" y="357" width="19" height="30" rx="4" fill="{{ $fill('Do5') }}" stroke="#fff" stroke-width="1.5"/>
    <text x="190" y="376" text-anchor="middle" font-size="6" fill="#fff" font-weight="700">Do5</text>
    @if(!$isDetails)</g>@endif
    @endif {{-- /showAxle2 --}}

    {{-- ── REAR AXLE 3 — 12-wheel only — single trailing/tag axle (C6, D6) ──────── --}}
    @if($showAxle3)
    <text x="110" y="443" text-anchor="middle" font-size="6.5" fill="#adb5bd" letter-spacing="0.5">REAR AXLE 3</text>
    {{-- Single-tyre axle rod (same width as front axle rod) --}}
    <rect x="30" y="460" width="160" height="4" rx="2" fill="#c0ccde"/>
    <circle cx="42"  cy="462" r="4" fill="#9ab0cc" stroke="#8098b8" stroke-width="1"/>
    <circle cx="178" cy="462" r="4" fill="#9ab0cc" stroke="#8098b8" stroke-width="1"/>

    {{-- C6 — Rear Axle 3, Left (single trailing) --}}
    @if(!$isDetails)<g class="tyre-group" data-code="C6">@endif
    <rect{!! $dataAttrs('C6') !!} x="30" y="447" width="24" height="34" rx="5" fill="{{ $fill('C6') }}" stroke="#fff" stroke-width="1.5"/>
    <text x="42" y="469" text-anchor="middle" font-size="8" fill="#fff" font-weight="700">C6</text>
    @if(!$isDetails)</g>@endif

    {{-- D6 — Rear Axle 3, Right (single trailing) --}}
    @if(!$isDetails)<g class="tyre-group" data-code="D6">@endif
    <rect{!! $dataAttrs('D6') !!} x="166" y="447" width="24" height="34" rx="5" fill="{{ $fill('D6') }}" stroke="#fff" stroke-width="1.5"/>
    <text x="178" y="469" text-anchor="middle" font-size="8" fill="#fff" font-weight="700">D6</text>
    @if(!$isDetails)</g>@endif
    @endif {{-- /showAxle3 --}}

</svg>
