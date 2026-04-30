@php
/*─────────────────────────────────────────────────────────────────────────────
 | resources/views/svg/truck.blade.php
 | Dynamic Truck SVG — adapts to any mounted_tyre_count (6, 10, 12, 14, 16, 18, 20, 22 …).
 |
 | Required variables:
 |   int     $mountedTyreCount   — e.g. 6, 10, 12, 14, 16 …
 |   string  $mode               — 'tagging'  or  'details'
 |
 | Optional variables:
 |   string  $svgId              — id attr on <svg>  (default: 'truckSvg')
 |
 | Details-mode only (pass when $mode === 'details'):
 |   Collection|array  $byCode       — tyre mappings keyed by position code
 |   Closure           $getTyreColor — fn($mapping): 'good'|'warn'|'critical'|'empty'
 |   array             $colorHex     — ['good'=>'#…', 'warn'=>'#…', …]
 |   array             $posLabels    — ['C1'=>'Front Left', …]
 |
 | Position-code scheme (auto-generated per axle count):
 |   Front steer axle:  C1, D1
 |   Rear dual axle k:  Ci(2k), Co(2k+1), Di(2k), Do(2k+1)
 |     k=1 → Ci2, Co3, Di2, Do3
 |     k=2 → Ci4, Co5, Di4, Do5
 |     k=3 → Ci6, Co7, Di6, Do7   (14 / 16-wheel)
 |     k=4 → Ci8, Co9, Di8, Do9   (18 / 20-wheel)
 |     k=5 → Ci10,Co11,Di10,Do11  (22-wheel)
 |   Trailing single:   C(2n+2), D(2n+2)  where n = rearDualAxles
 |     n=2 → C6,  D6   (12-wheel)
 |     n=3 → C8,  D8   (16-wheel)
 |     n=4 → C10, D10  (20-wheel)
 *─────────────────────────────────────────────────────────────────────────────*/

$tyreCount = (int)($mountedTyreCount ?? 10);
$svgId     = $svgId ?? 'truckSvg';
$isDetails = (($mode ?? 'tagging') === 'details');
$svgClass  = $isDetails ? 'vtd-truck-svg' : '';
$svgStyle  = $isDetails ? '' : 'width:100%;max-width:220px;margin:0 auto;display:block;';

/* ── Axle decomposition ─────────────────────────────────────────────────────
 |  tyreCount = 2 (front) + 4 × rearDualAxles + 2 × hasTrailingSingle
 *──────────────────────────────────────────────────────────────────────────── */
$rem           = max(0, $tyreCount - 2);
$rearDualAxles = max(1, (int) floor($rem / 4));
$hasTrailing   = ($rem % 4 === 2);

/* ── Build rear dual axle data array ───────────────────────────────────────
 |  Rod centre Y for axle k: 282 + (k-1)*90
 *──────────────────────────────────────────────────────────────────────────── */
$rearAxles = [];
for ($k = 1; $k <= $rearDualAxles; $k++) {
    $cy = 282 + ($k - 1) * 90;
    $rearAxles[] = [
        'label'  => 'REAR AXLE ' . $k,
        'lblY'   => $cy - 6,        // label text Y
        'rodY'   => $cy - 2,        // axle rod rect top
        'rodCy'  => $cy,            // hub circle centre Y
        'tyreY'  => $cy - 15,       // dual tyre rect top  (h=30)
        'co'     => 'Co' . (2 * $k + 1),   // Conductor Outer
        'ci'     => 'Ci' . (2 * $k),       // Conductor Inner
        'di'     => 'Di' . (2 * $k),       // Driver Inner
        'do'     => 'Do' . (2 * $k + 1),   // Driver Outer
    ];
}

/* ── Build trailing single axle data (if present) ──────────────────────────
 |  Rod centre Y: last dual-axle rod Y + 90
 *──────────────────────────────────────────────────────────────────────────── */
$trailingAxle = null;
if ($hasTrailing) {
    $lastCy = 282 + ($rearDualAxles - 1) * 90;
    $trCy   = $lastCy + 90;
    $trNum  = 2 * $rearDualAxles + 2;   // 6, 8, 10 …
    $trailingAxle = [
        'label'  => 'REAR AXLE ' . ($rearDualAxles + 1),
        'lblY'   => $trCy - 19,        // label text Y
        'rodY'   => $trCy - 2,         // rod rect top
        'rodCy'  => $trCy,
        'tyreY'  => $trCy - 15,        // single tyre rect top (h=34)
        'cCode'  => 'C'  . $trNum,
        'dCode'  => 'D'  . $trNum,
    ];
}

/* ── Layout dimensions ──────────────────────────────────────────────────────
 |  For 6 / 10 / 12-wheel keep the proven hardcoded values.
 |  For 14-wheel and above, calculate dynamically.
 *──────────────────────────────────────────────────────────────────────────── */
if ($hasTrailing && $trailingAxle) {
    $lastBottom = $trailingAxle['tyreY'] + 34;   // single tyre height
} else {
    $lastAxle   = end($rearAxles); reset($rearAxles);
    $lastBottom = $lastAxle['tyreY'] + 30;        // dual tyre height
}

if ($tyreCount <= 6) {
    $viewBoxH = 330; $bodyH = 254; $mainH = 250; $cargoH = 136;
    $cargoLines = [228];
} elseif ($tyreCount <= 10) {
    $viewBoxH = 430; $bodyH = 354; $mainH = 350; $cargoH = 236;
    $cargoLines = [228, 310, 392];
} elseif ($tyreCount <= 12) {
    $viewBoxH = 520; $bodyH = 444; $mainH = 440; $cargoH = 326;
    $cargoLines = [228, 310, 392, 480];
} else {
    // 14-wheel and above — calculate dynamically
    $viewBoxH = $lastBottom + 43;
    $bodyH    = $viewBoxH - 76;
    $mainH    = $bodyH - 2;
    $cargoH   = $lastBottom + 8 - 182;
    // One cargo divider line per axle zone (90 px apart)
    $cargoLines = [];
    $lineCount  = $rearDualAxles + ($hasTrailing ? 1 : 0);
    for ($i = 0; $i < $lineCount; $i++) {
        $cargoLines[] = 228 + 90 * $i;
    }
}
$viewBox = "0 0 220 {$viewBoxH}";

/* ── Details-mode helpers ───────────────────────────────────────────────────── */
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

/* Builds the data-* attribute string for details mode */
$dataAttrs = function(string $code) use ($isDetails, $byCode, $getTyreColor, $posLabels): string {
    if (!$isDetails) return '';
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
         . ' data-pos="'       . $code    . '"'
         . ' data-label="'     . $label   . '"'
         . ' data-has-tyre="'  . $hasTyre . '"'
         . ' data-serial="'    . $serial  . '"'
         . ' data-brand="'     . $brand   . '"'
         . ' data-model="'     . $model   . '"'
         . ' data-condition="' . $cond    . '"'
         . ' data-status="'    . $status  . '"'
         . ' data-fitted="'    . $fitted  . '"'
         . ' data-kmlife="'    . $kmlife  . '"'
         . ' data-kmrun="'     . $kmrun   . '"';
};
@endphp

<svg id="{{ $svgId }}"
     viewBox="{{ $viewBox }}"
     xmlns="http://www.w3.org/2000/svg"
     @if($svgClass) class="{{ $svgClass }}" @endif
     @if($svgStyle) style="{{ $svgStyle }}" @endif>

    {{-- ▲ FRONT direction label --}}
    <text x="110" y="48" text-anchor="middle" font-size="9" fill="#94a3b8" font-weight="700" letter-spacing="1">▲ FRONT</text>

    {{-- ── TRUCK OUTER BODY ─────────────────────────────────────────────────── --}}
    <rect x="57" y="70" width="106" height="{{ $bodyH }}" rx="16" fill="#e2e8f0" stroke="none"/>
    <rect x="59" y="72" width="102" height="{{ $mainH }}" rx="14" fill="#f0f3f9" stroke="#c8d4e8" stroke-width="1.5"/>

    {{-- ── CAB SECTION ──────────────────────────────────────────────────────── --}}
    <rect x="59" y="72" width="102" height="108" rx="14" fill="#dce7ff" stroke="#b0c4f0" stroke-width="1.5"/>
    <rect x="71" y="80" width="78"  height="34"  rx="6"  fill="#b8d0f5" opacity="0.85"/>
    <line x1="77" y1="83"  x2="77"  y2="111" stroke="#fff" stroke-width="1.5" stroke-linecap="round" opacity="0.5"/>
    <line x1="83" y1="81"  x2="83"  y2="113" stroke="#fff" stroke-width="0.7" stroke-linecap="round" opacity="0.25"/>
    <rect x="71"  y="116" width="78"  height="14" rx="3" fill="#c8d8f0" stroke="#b0c4e8" stroke-width="1"/>
    <rect x="45"  y="84"  width="14"  height="9"  rx="2.5" fill="#b0c4e8" stroke="#9ab0d8" stroke-width="1"/>
    <rect x="161" y="84"  width="14"  height="9"  rx="2.5" fill="#b0c4e8" stroke="#9ab0d8" stroke-width="1"/>
    <line x1="59"  y1="88" x2="65"  y2="88" stroke="#a0b4d0" stroke-width="1.5"/>
    <line x1="155" y1="88" x2="161" y2="88" stroke="#a0b4d0" stroke-width="1.5"/>
    <text x="110" y="160" text-anchor="middle" font-size="7" fill="#7b93c4" font-weight="600" letter-spacing="1.5">CAB</text>
    <line x1="64" y1="180" x2="156" y2="180" stroke="#c8d4e8" stroke-width="1.5" stroke-dasharray="3,2"/>

    {{-- ── CARGO BODY ───────────────────────────────────────────────────────── --}}
    <rect x="63" y="182" width="94" height="{{ $cargoH }}" rx="4" fill="#f5f7fb" stroke="#dce3f0" stroke-width="1"/>
    @foreach($cargoLines as $_ly)
        <line x1="63" y1="{{ $_ly }}" x2="157" y2="{{ $_ly }}" stroke="#e0e8f4" stroke-width="1"/>
    @endforeach
    <text x="110" y="266" text-anchor="middle" font-size="7" fill="#b0bcce" letter-spacing="2">CARGO</text>

    {{-- ── SPARE TYRES (fixed in upper cargo section) ──────────────────────── --}}
    <text x="110" y="226" text-anchor="middle" font-size="5.5" fill="#adb5bd" letter-spacing="0.5">SPARE</text>

    @if(!$isDetails)<g class="tyre-group" data-code="S1">@endif
    <rect{!! $dataAttrs('S1') !!} x="87" y="230" width="21" height="26" rx="4" fill="{{ $fill('S1') }}" stroke="#fff" stroke-width="1.5"/>
    <text x="97" y="246" text-anchor="middle" font-size="6" fill="#fff" font-weight="700">S1</text>
    @if(!$isDetails)</g>@endif

    @if(!$isDetails)<g class="tyre-group" data-code="S2">@endif
    <rect{!! $dataAttrs('S2') !!} x="112" y="230" width="21" height="26" rx="4" fill="{{ $fill('S2') }}" stroke="#fff" stroke-width="1.5"/>
    <text x="122" y="246" text-anchor="middle" font-size="6" fill="#fff" font-weight="700">S2</text>
    @if(!$isDetails)</g>@endif

    {{-- ── FRONT AXLE (always present — C1, D1) ───────────────────────────── --}}
    <text x="110" y="119" text-anchor="middle" font-size="6.5" fill="#adb5bd" letter-spacing="0.5">FRONT AXLE</text>
    <rect x="30" y="124" width="160" height="4" rx="2" fill="#c0ccde"/>
    <circle cx="42"  cy="126" r="4" fill="#9ab0cc" stroke="#8098b8" stroke-width="1"/>
    <circle cx="178" cy="126" r="4" fill="#9ab0cc" stroke="#8098b8" stroke-width="1"/>

    @if(!$isDetails)<g class="tyre-group" data-code="C1">@endif
    <rect{!! $dataAttrs('C1') !!} x="30" y="109" width="24" height="34" rx="5" fill="{{ $fill('C1') }}" stroke="#fff" stroke-width="1.5"/>
    <text x="42" y="131" text-anchor="middle" font-size="8" fill="#fff" font-weight="700">C1</text>
    @if(!$isDetails)</g>@endif

    @if(!$isDetails)<g class="tyre-group" data-code="D1">@endif
    <rect{!! $dataAttrs('D1') !!} x="166" y="109" width="24" height="34" rx="5" fill="{{ $fill('D1') }}" stroke="#fff" stroke-width="1.5"/>
    <text x="178" y="131" text-anchor="middle" font-size="8" fill="#fff" font-weight="700">D1</text>
    @if(!$isDetails)</g>@endif

    {{-- ── REAR DUAL AXLES (dynamic loop — 1 to N) ────────────────────────── --}}
    @foreach($rearAxles as $axle)
    @php $_ty = $axle['tyreY'] + 19; @endphp

    <text x="110" y="{{ $axle['lblY'] }}" text-anchor="middle" font-size="6.5" fill="#adb5bd" letter-spacing="0.5">{{ $axle['label'] }}</text>
    <rect x="16" y="{{ $axle['rodY'] }}" width="188" height="4" rx="2" fill="#c0ccde"/>
    <circle cx="29"  cy="{{ $axle['rodCy'] }}" r="3.5" fill="#9ab0cc" stroke="#8098b8" stroke-width="1"/>
    <circle cx="50"  cy="{{ $axle['rodCy'] }}" r="3.5" fill="#9ab0cc" stroke="#8098b8" stroke-width="1"/>
    <circle cx="170" cy="{{ $axle['rodCy'] }}" r="3.5" fill="#9ab0cc" stroke="#8098b8" stroke-width="1"/>
    <circle cx="191" cy="{{ $axle['rodCy'] }}" r="3.5" fill="#9ab0cc" stroke="#8098b8" stroke-width="1"/>

    @if(!$isDetails)<g class="tyre-group" data-code="{{ $axle['co'] }}">@endif
    <rect{!! $dataAttrs($axle['co']) !!} x="20" y="{{ $axle['tyreY'] }}" width="19" height="30" rx="4" fill="{{ $fill($axle['co']) }}" stroke="#fff" stroke-width="1.5"/>
    <text x="29" y="{{ $_ty }}" text-anchor="middle" font-size="6" fill="#fff" font-weight="700">{{ $axle['co'] }}</text>
    @if(!$isDetails)</g>@endif

    @if(!$isDetails)<g class="tyre-group" data-code="{{ $axle['ci'] }}">@endif
    <rect{!! $dataAttrs($axle['ci']) !!} x="41" y="{{ $axle['tyreY'] }}" width="19" height="30" rx="4" fill="{{ $fill($axle['ci']) }}" stroke="#fff" stroke-width="1.5"/>
    <text x="50" y="{{ $_ty }}" text-anchor="middle" font-size="6" fill="#fff" font-weight="700">{{ $axle['ci'] }}</text>
    @if(!$isDetails)</g>@endif

    @if(!$isDetails)<g class="tyre-group" data-code="{{ $axle['di'] }}">@endif
    <rect{!! $dataAttrs($axle['di']) !!} x="160" y="{{ $axle['tyreY'] }}" width="19" height="30" rx="4" fill="{{ $fill($axle['di']) }}" stroke="#fff" stroke-width="1.5"/>
    <text x="169" y="{{ $_ty }}" text-anchor="middle" font-size="6" fill="#fff" font-weight="700">{{ $axle['di'] }}</text>
    @if(!$isDetails)</g>@endif

    @if(!$isDetails)<g class="tyre-group" data-code="{{ $axle['do'] }}">@endif
    <rect{!! $dataAttrs($axle['do']) !!} x="181" y="{{ $axle['tyreY'] }}" width="19" height="30" rx="4" fill="{{ $fill($axle['do']) }}" stroke="#fff" stroke-width="1.5"/>
    <text x="190" y="{{ $_ty }}" text-anchor="middle" font-size="6" fill="#fff" font-weight="700">{{ $axle['do'] }}</text>
    @if(!$isDetails)</g>@endif

    @endforeach

    {{-- ── TRAILING SINGLE AXLE (C6/D6 for 12-wheel, C8/D8 for 16-wheel, etc.) ── --}}
    @if($trailingAxle)
    @php $_trTy = $trailingAxle['tyreY'] + 22; @endphp

    <text x="110" y="{{ $trailingAxle['lblY'] }}" text-anchor="middle" font-size="6.5" fill="#adb5bd" letter-spacing="0.5">{{ $trailingAxle['label'] }}</text>
    <rect x="30" y="{{ $trailingAxle['rodY'] }}" width="160" height="4" rx="2" fill="#c0ccde"/>
    <circle cx="42"  cy="{{ $trailingAxle['rodCy'] }}" r="4" fill="#9ab0cc" stroke="#8098b8" stroke-width="1"/>
    <circle cx="178" cy="{{ $trailingAxle['rodCy'] }}" r="4" fill="#9ab0cc" stroke="#8098b8" stroke-width="1"/>

    @if(!$isDetails)<g class="tyre-group" data-code="{{ $trailingAxle['cCode'] }}">@endif
    <rect{!! $dataAttrs($trailingAxle['cCode']) !!} x="30" y="{{ $trailingAxle['tyreY'] }}" width="24" height="34" rx="5" fill="{{ $fill($trailingAxle['cCode']) }}" stroke="#fff" stroke-width="1.5"/>
    <text x="42" y="{{ $_trTy }}" text-anchor="middle" font-size="8" fill="#fff" font-weight="700">{{ $trailingAxle['cCode'] }}</text>
    @if(!$isDetails)</g>@endif

    @if(!$isDetails)<g class="tyre-group" data-code="{{ $trailingAxle['dCode'] }}">@endif
    <rect{!! $dataAttrs($trailingAxle['dCode']) !!} x="166" y="{{ $trailingAxle['tyreY'] }}" width="24" height="34" rx="5" fill="{{ $fill($trailingAxle['dCode']) }}" stroke="#fff" stroke-width="1.5"/>
    <text x="178" y="{{ $_trTy }}" text-anchor="middle" font-size="8" fill="#fff" font-weight="700">{{ $trailingAxle['dCode'] }}</text>
    @if(!$isDetails)</g>@endif

    @endif {{-- /trailingAxle --}}

</svg>
