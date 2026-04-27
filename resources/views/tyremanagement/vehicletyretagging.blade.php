@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/tyre/tagging.css') }}?v={{ filemtime(public_path('css/tyre/tagging.css')) }}">
@endsection

@section('content')
<div class="layout-wrapper">

    @include('includes.header')

    <div class="vehicledtl-bd srlog-bdwrapper">

        {{-- ── TOP BAR ─────────────────────────────────────────────────────── --}}
        <div class="topbar-bd">
            <div class="item1">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <div class="col-12 col-md-6">
                            <h1>Tyre Management Details</h1>
                        </div>
                        <div class="col-12 col-md-6 text-end">
                            <span class="badge bg-light text-dark border me-2">
                                <i class="uil uil-truck me-1"></i>{{ $vehicle->vehicle_registration_number ?? 'Vehicle #'.$vehicle->vehicle_no }}
                            </span>
                            <a href="{{ route('fleetdashboard.getVehicleDetails', $vehicle->id) }}" class="btn btn-sm btn-outline-secondary">
                                <i class="uil uil-arrow-left me-1"></i>Back
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── PASS RAG DATA + ROUTE URLS TO JS ──────────────────────────────── --}}
        <script>
            const tyreRagData = {
                @foreach($vehicle->vehicletyremappings as $m)
                    @if($m->tyreposition)
                    "{{ $m->tyreposition->code }}": "{{ $m->rag_status }}",
                    @endif
                @endforeach
            };
            const sixWheelTruckPath   = "{{ asset('arobittyre_management/6-wheel-new.svg') }}";
            const tenWheelTruckPath   = "{{ asset('arobittyre_management/10-wheel-new.svg') }}";
            const getTyreListUrl      = "{{ route('tyremanage.get.tyre.list') }}";
            const addTyreBaseUrl      = "{{ url('tyremanage/vehicle/'.$vehicle->id.'/mapping') }}"; // append /{mappingId}/add-tyre
            const addSpareUrl         = "{{ route('tyremanage.vehicle.add.spare', $vehicle->id) }}";
            const csrfToken           = "{{ csrf_token() }}";
            const lastKnownKm         = {{ $lastKnownKm ?? 'null' }};
            const lastKnownDate       = "{{ $lastKnownDate ?? '' }}";
        </script>

        {{-- ── MAIN LAYOUT ─────────────────────────────────────────────────── --}}
        <div class="container-fluid pt-3 pb-5">
            <div class="row gx-3">

                {{-- ── LEFT: TRUCK SVG ──────────────────────────────────────── --}}
                <div class="col-12 col-md-3">
                    <div class="card tyre-svg-panel">
                        <div class="svg-panel-header">
                            <i class="uil uil-truck me-1"></i>
                            <span id="svgPanelTitle">Truck Tyre Layout</span>
                        </div>

                        {{-- Hidden input the JS reads to show/hide mounted cards --}}
                        <input hidden id="type" value="{{ $vehicle->mounted_tyre_count }}" />

                        {{-- ── INLINE TRUCK SVG (matches vehicle-details-v2 design) ── --}}
                        <div id="container-img" class="svg-container">
                            <svg id="taggingTruckSvg" viewBox="0 0 220 430" xmlns="http://www.w3.org/2000/svg" style="width:100%;max-width:220px;margin:0 auto;display:block;">

                                {{-- ▲ Direction --}}
                                <text x="110" y="48" text-anchor="middle" font-size="9" fill="#94a3b8" font-weight="700" letter-spacing="1">▲ FRONT</text>

                                {{-- Truck outer body shadow/frame --}}
                                <rect x="57" y="70" width="106" height="354" rx="16" fill="#e2e8f0" stroke="none"/>

                                {{-- Truck main body --}}
                                <rect x="59" y="72" width="102" height="350" rx="14" fill="#f0f3f9" stroke="#c8d4e8" stroke-width="1.5"/>

                                {{-- Cab section background --}}
                                <rect x="59" y="72" width="102" height="108" rx="14" fill="#dce7ff" stroke="#b0c4f0" stroke-width="1.5"/>

                                {{-- Windshield --}}
                                <rect x="71" y="80" width="78" height="34" rx="6" fill="#b8d0f5" opacity="0.85"/>
                                {{-- Windshield glare --}}
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
                                {{-- Cab/cargo separator --}}
                                <line x1="64" y1="180" x2="156" y2="180" stroke="#c8d4e8" stroke-width="1.5" stroke-dasharray="3,2"/>

                                {{-- Cargo body --}}
                                <rect x="63" y="182" width="94" height="236" rx="4" fill="#f5f7fb" stroke="#dce3f0" stroke-width="1"/>
                                {{-- Cargo panel lines --}}
                                <line x1="63" y1="228" x2="157" y2="228" stroke="#e0e8f4" stroke-width="1"/>
                                <line x1="63" y1="310" x2="157" y2="310" stroke="#e0e8f4" stroke-width="1"/>
                                <line x1="63" y1="392" x2="157" y2="392" stroke="#e0e8f4" stroke-width="1"/>
                                {{-- Cargo label --}}
                                <text x="110" y="266" text-anchor="middle" font-size="7" fill="#b0bcce" letter-spacing="2">CARGO</text>

                                {{-- ─── AXLE RODS ─── --}}
                                {{-- Front axle rod --}}
                                <rect x="30" y="124" width="160" height="4" rx="2" fill="#c0ccde"/>
                                <circle cx="42" cy="126" r="4" fill="#9ab0cc" stroke="#8098b8" stroke-width="1"/>
                                <circle cx="178" cy="126" r="4" fill="#9ab0cc" stroke="#8098b8" stroke-width="1"/>

                                {{-- Rear axle 1 rod --}}
                                <rect x="16" y="280" width="188" height="4" rx="2" fill="#c0ccde"/>
                                <circle cx="29" cy="282" r="3.5" fill="#9ab0cc" stroke="#8098b8" stroke-width="1"/>
                                <circle cx="50" cy="282" r="3.5" fill="#9ab0cc" stroke="#8098b8" stroke-width="1"/>
                                <circle cx="170" cy="282" r="3.5" fill="#9ab0cc" stroke="#8098b8" stroke-width="1"/>
                                <circle cx="191" cy="282" r="3.5" fill="#9ab0cc" stroke="#8098b8" stroke-width="1"/>

                                {{-- Rear axle 2 rod --}}
                                <rect x="16" y="370" width="188" height="4" rx="2" fill="#c0ccde"/>
                                <circle cx="29" cy="372" r="3.5" fill="#9ab0cc" stroke="#8098b8" stroke-width="1"/>
                                <circle cx="50" cy="372" r="3.5" fill="#9ab0cc" stroke="#8098b8" stroke-width="1"/>
                                <circle cx="170" cy="372" r="3.5" fill="#9ab0cc" stroke="#8098b8" stroke-width="1"/>
                                <circle cx="191" cy="372" r="3.5" fill="#9ab0cc" stroke="#8098b8" stroke-width="1"/>

                                {{-- Axle labels --}}
                                <text x="110" y="119" text-anchor="middle" font-size="6.5" fill="#adb5bd" letter-spacing="0.5">FRONT AXLE</text>
                                <text x="110" y="276" text-anchor="middle" font-size="6.5" fill="#adb5bd" letter-spacing="0.5">REAR AXLE 1</text>
                                <text x="110" y="366" text-anchor="middle" font-size="6.5" fill="#adb5bd" letter-spacing="0.5">REAR AXLE 2</text>

                                {{-- SPARE label --}}
                                <text x="110" y="226" text-anchor="middle" font-size="5.5" fill="#adb5bd" letter-spacing="0.5">SPARE</text>

                                {{-- ── TYRE POSITIONS (each wrapped in .tyre-group for JS RAG + hover) ── --}}

                                {{-- C1 — Front Left Steer --}}
                                <g class="tyre-group" data-code="C1">
                                    <rect x="30" y="109" width="24" height="34" rx="5" fill="#adb5bd" stroke="#fff" stroke-width="1.5"/>
                                    <text x="42" y="131" text-anchor="middle" font-size="8" fill="#fff" font-weight="700">C1</text>
                                </g>

                                {{-- D1 — Front Right Steer --}}
                                <g class="tyre-group" data-code="D1">
                                    <rect x="166" y="109" width="24" height="34" rx="5" fill="#adb5bd" stroke="#fff" stroke-width="1.5"/>
                                    <text x="178" y="131" text-anchor="middle" font-size="8" fill="#fff" font-weight="700">D1</text>
                                </g>

                                {{-- Co3 — Rear Axle 1, Left Outer --}}
                                <g class="tyre-group" data-code="Co3">
                                    <rect x="20" y="267" width="19" height="30" rx="4" fill="#adb5bd" stroke="#fff" stroke-width="1.5"/>
                                    <text x="29" y="286" text-anchor="middle" font-size="6" fill="#fff" font-weight="700">Co3</text>
                                </g>

                                {{-- Ci2 — Rear Axle 1, Left Inner --}}
                                <g class="tyre-group" data-code="Ci2">
                                    <rect x="41" y="267" width="19" height="30" rx="4" fill="#adb5bd" stroke="#fff" stroke-width="1.5"/>
                                    <text x="50" y="286" text-anchor="middle" font-size="6" fill="#fff" font-weight="700">Ci2</text>
                                </g>

                                {{-- Di2 — Rear Axle 1, Right Inner --}}
                                <g class="tyre-group" data-code="Di2">
                                    <rect x="160" y="267" width="19" height="30" rx="4" fill="#adb5bd" stroke="#fff" stroke-width="1.5"/>
                                    <text x="169" y="286" text-anchor="middle" font-size="6" fill="#fff" font-weight="700">Di2</text>
                                </g>

                                {{-- Do3 — Rear Axle 1, Right Outer --}}
                                <g class="tyre-group" data-code="Do3">
                                    <rect x="181" y="267" width="19" height="30" rx="4" fill="#adb5bd" stroke="#fff" stroke-width="1.5"/>
                                    <text x="190" y="286" text-anchor="middle" font-size="6" fill="#fff" font-weight="700">Do3</text>
                                </g>

                                {{-- Co5 — Rear Axle 2, Left Outer --}}
                                <g class="tyre-group" data-code="Co5">
                                    <rect x="20" y="357" width="19" height="30" rx="4" fill="#adb5bd" stroke="#fff" stroke-width="1.5"/>
                                    <text x="29" y="376" text-anchor="middle" font-size="6" fill="#fff" font-weight="700">Co5</text>
                                </g>

                                {{-- Ci4 — Rear Axle 2, Left Inner --}}
                                <g class="tyre-group" data-code="Ci4">
                                    <rect x="41" y="357" width="19" height="30" rx="4" fill="#adb5bd" stroke="#fff" stroke-width="1.5"/>
                                    <text x="50" y="376" text-anchor="middle" font-size="6" fill="#fff" font-weight="700">Ci4</text>
                                </g>

                                {{-- Di4 — Rear Axle 2, Right Inner --}}
                                <g class="tyre-group" data-code="Di4">
                                    <rect x="160" y="357" width="19" height="30" rx="4" fill="#adb5bd" stroke="#fff" stroke-width="1.5"/>
                                    <text x="169" y="376" text-anchor="middle" font-size="6" fill="#fff" font-weight="700">Di4</text>
                                </g>

                                {{-- Do5 — Rear Axle 2, Right Outer --}}
                                <g class="tyre-group" data-code="Do5">
                                    <rect x="181" y="357" width="19" height="30" rx="4" fill="#adb5bd" stroke="#fff" stroke-width="1.5"/>
                                    <text x="190" y="376" text-anchor="middle" font-size="6" fill="#fff" font-weight="700">Do5</text>
                                </g>

                                {{-- S1 — Spare 1 --}}
                                <g class="tyre-group" data-code="S1">
                                    <rect x="87" y="230" width="21" height="26" rx="4" fill="#adb5bd" stroke="#fff" stroke-width="1.5"/>
                                    <text x="97" y="246" text-anchor="middle" font-size="6" fill="#fff" font-weight="700">S1</text>
                                </g>

                                {{-- S2 — Spare 2 --}}
                                <g class="tyre-group" data-code="S2">
                                    <rect x="112" y="230" width="21" height="26" rx="4" fill="#adb5bd" stroke="#fff" stroke-width="1.5"/>
                                    <text x="122" y="246" text-anchor="middle" font-size="6" fill="#fff" font-weight="700">S2</text>
                                </g>

                            </svg>
                        </div>

                        {{-- RAG legend --}}
                        <div class="rag-legend mt-3">
                            <div class="rag-legend-item"><span class="rag-dot green"></span><span>Good (&ge;50%)</span></div>
                            <div class="rag-legend-item"><span class="rag-dot amber"></span><span>Moderate (20–49%)</span></div>
                            <div class="rag-legend-item"><span class="rag-dot red"></span><span>Critical (&lt;20%)</span></div>
                            <div class="rag-legend-item"><span class="rag-dot grey"></span><span>Untagged</span></div>
                        </div>
                    </div>
                </div>

                {{-- ── RIGHT: TYRE CARDS ────────────────────────────────────── --}}
                <div class="col-12 col-md-9">

                    {{-- ── MOUNTED TYRES ──────────────────────────── --}}
                    <div class="section-label mb-2">
                        <i class="uil uil-circle me-1"></i>Mounted Tyres
                    </div>

                    @forelse($vehicle->vehicletyremappings->where('status', '!=', 'Spare') as $mapping)
                        @if(!$mapping->tyreposition) @continue @endif

                        @php
                            $pos      = $mapping->tyreposition->code;
                            $tyre     = $mapping->tyre;
                            $isTagged = $mapping->status === 'Active' && $tyre;
                            $rag      = $mapping->rag_status ?? 'grey';
                            $lifePct  = $mapping->life_remaining_pct;
                        @endphp

                        <div id="card-{{ $pos }}"
                             class="tyre-card mandtory_tyre_positions rag-border-{{ $rag }} mb-3"
                             data-position="{{ $pos }}">

                            {{-- Card Header --}}
                            <div class="tyre-card-header">
                                <div class="d-flex align-items-center gap-2 flex-wrap">
                                    <span class="position-badge">{{ $pos }}</span>
                                    <span class="rag-badge rag-{{ $rag }}">
                                        @if($rag === 'green') 🟢 Good
                                        @elseif($rag === 'amber') 🟡 Moderate
                                        @elseif($rag === 'red') 🔴 Critical
                                        @else ⚫ Untagged
                                        @endif
                                    </span>
                                    <div class="ms-auto d-flex align-items-center gap-2">
                                        @if($isTagged && $lifePct !== null)
                                            <div class="life-bar-wrap">
                                                <div class="life-bar-track">
                                                    <div class="life-bar-fill rag-bg-{{ $rag }}" style="width: {{ $lifePct }}%"></div>
                                                </div>
                                                <span class="life-pct-label">{{ $lifePct }}% Life</span>
                                            </div>
                                        @endif
                                        @if($isTagged && $tyre && $tyre->medias && $tyre->medias->count())
                                            <button type="button" class="btn-attach-icon"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#attachModal-{{ $pos }}"
                                                    title="{{ $tyre->medias->count() }} Attachment(s)">
                                                <i class="uil uil-paperclip"></i>
                                                <span class="attach-count-badge">{{ $tyre->medias->count() }}</span>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            @if($isTagged)
                            {{-- ── TAGGED: FULL CARD ──────────────────────────── --}}
                            <div class="tyre-card-body">

                                {{-- Section 1: Basic Details --}}
                                <div class="info-section">
                                    <div class="info-section-title">
                                        <i class="uil uil-info-circle"></i> Basic Details
                                    </div>
                                    <div class="info-grid">
                                        <div class="info-item">
                                            <span class="info-label">Serial No.</span>
                                            <span class="info-value">{{ $tyre->tyre_serial_number ?? '—' }}</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="info-label">Type</span>
                                            <span class="info-value">{{ $tyre->tyre_type ?? '—' }}</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="info-label">Condition</span>
                                            <span class="info-value">
                                                <span class="cond-badge cond-{{ strtolower(str_replace([' ', '-', "'"], '', $tyre->tyre_condition ?? '')) }}">
                                                    {{ $tyre->tyre_condition ?? '—' }}
                                                </span>
                                            </span>
                                        </div>
                                        <div class="info-item">
                                            <span class="info-label">Brand</span>
                                            <span class="info-value">{{ $tyre->tyre_brand ?? '—' }}</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="info-label">Model</span>
                                            <span class="info-value">{{ $tyre->tyre_model ?? '—' }}</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="info-label">Size</span>
                                            <span class="info-value">{{ $tyre->tyre_size ?? '—' }}</span>
                                        </div>
                                    </div>
                                </div>

                                {{-- Section 2: Purchase & Fitment --}}
                                <div class="info-section">
                                    <div class="info-section-title">
                                        <i class="uil uil-receipt"></i> Purchase & Fitment
                                    </div>
                                    <div class="info-grid">
                                        <div class="info-item">
                                            <span class="info-label">Price</span>
                                            <span class="info-value">
                                                ₹{{ $tyre->tyre_price ? number_format($tyre->tyre_price, 2) : '—' }}
                                            </span>
                                        </div>
                                        <div class="info-item">
                                            <span class="info-label">Purchase Date</span>
                                            <span class="info-value">
                                                {{ $tyre->tyre_purchase_date ? \Carbon\Carbon::parse($tyre->tyre_purchase_date)->format('d M Y') : '—' }}
                                            </span>
                                        </div>
                                        <div class="info-item">
                                            <span class="info-label">Fitment Date</span>
                                            <span class="info-value">
                                                {{ $mapping->fitment_date ? \Carbon\Carbon::parse($mapping->fitment_date)->format('d M Y') : '—' }}
                                            </span>
                                        </div>
                                        <div class="info-item">
                                            <span class="info-label">Warranty Period</span>
                                            <span class="info-value">{{ $tyre->tyre_warranty_months ? $tyre->tyre_warranty_months.' Months' : '—' }}</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="info-label">Warranty End</span>
                                            <span class="info-value">
                                                {{ $tyre->tyre_warrenty_end_date ? \Carbon\Carbon::parse($tyre->tyre_warrenty_end_date)->format('d M Y') : '—' }}
                                            </span>
                                        </div>
                                        <div class="info-item">
                                            <span class="info-label">Warranty Left</span>
                                            <span class="info-value @if(($mapping->warranty_remaining_months ?? 99) <= 2) text-danger fw-semibold @endif">
                                                {{ $mapping->warranty_remaining_months !== null ? $mapping->warranty_remaining_months.' Mo' : '—' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                {{-- Sections 3 & 4: Performance (KM) + Lifecycle (Months) — side by side --}}
                                <div class="info-section-pair">

                                    {{-- Section 3: Performance (KM) --}}
                                    <div class="info-section">
                                        <div class="info-section-title">
                                            <i class="uil uil-tachometer-fast"></i> Performance (KM)
                                        </div>
                                        <div class="info-grid">
                                            <div class="info-item">
                                                <span class="info-label">Fixed Run</span>
                                                <span class="info-value">{{ $tyre->fixed_run_km ? number_format($tyre->fixed_run_km).' KM' : '—' }}</span>
                                            </div>
                                            <div class="info-item">
                                                <span class="info-label">Actual Run</span>
                                                <span class="info-value">{{ $tyre->actual_run_km ? number_format($tyre->actual_run_km).' KM' : '—' }}</span>
                                            </div>
                                            <div class="info-item">
                                                <span class="info-label">Remaining Run</span>
                                                <span class="info-value @if(($mapping->remaining_run_km ?? PHP_INT_MAX) < 5000) text-danger fw-semibold @endif">
                                                    {{ $mapping->remaining_run_km !== null ? number_format($mapping->remaining_run_km).' KM' : '—' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Section 4: Lifecycle (Months) --}}
                                    <div class="info-section">
                                        <div class="info-section-title">
                                            <i class="uil uil-calendar-alt"></i> Lifecycle (Months)
                                        </div>
                                        <div class="info-grid">
                                            <div class="info-item">
                                                <span class="info-label">Fixed Life</span>
                                                <span class="info-value">{{ $tyre->fixed_life_months ? $tyre->fixed_life_months.' Mo' : '—' }}</span>
                                            </div>
                                            <div class="info-item">
                                                <span class="info-label">Actual Run</span>
                                                <span class="info-value">{{ $tyre->actual_run_month ? $tyre->actual_run_month.' Mo' : '—' }}</span>
                                            </div>
                                            <div class="info-item">
                                                <span class="info-label">Remaining Life</span>
                                                <span class="info-value @if(($mapping->remaining_life_months ?? 99) <= 2) text-danger fw-semibold @endif">
                                                    {{ $mapping->remaining_life_months !== null ? $mapping->remaining_life_months.' Mo' : '—' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                </div>{{-- /info-section-pair --}}

                                {{-- Section 5: Maintenance --}}
                                <div class="info-section">
                                    <div class="info-section-title">
                                        <i class="uil uil-wrench"></i> Maintenance Tracking
                                    </div>
                                    <div class="info-grid">
                                        <div class="info-item">
                                            <span class="info-label">Alignment Interval</span>
                                            <span class="info-value">
                                                {{ $tyre->alignment_interval_km ? number_format($tyre->alignment_interval_km).' KM' : '—' }}
                                                @if($tyre->set_reminder_for_alignment === 'Yes')
                                                    <span class="reminder-badge" title="Reminder set">🔔</span>
                                                @endif
                                            </span>
                                        </div>
                                        <div class="info-item">
                                            <span class="info-label">Last Alignment</span>
                                            <span class="info-value">{{ $tyre->last_alignment_km ? number_format($tyre->last_alignment_km).' KM' : '—' }}</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="info-label">Rotation Interval</span>
                                            <span class="info-value">
                                                {{ $tyre->rotation_interval_km ? number_format($tyre->rotation_interval_km).' KM' : '—' }}
                                                @if($tyre->set_reminder_for_rotation === 'Yes')
                                                    <span class="reminder-badge" title="Reminder set">🔔</span>
                                                @endif
                                            </span>
                                        </div>
                                        <div class="info-item">
                                            <span class="info-label">Last Rotation</span>
                                            <span class="info-value">{{ $tyre->last_rotation_km ? number_format($tyre->last_rotation_km).' KM' : '—' }}</span>
                                        </div>
                                    </div>
                                </div>

                            </div>{{-- /tyre-card-body --}}

                            {{-- Card Footer: Action Buttons --}}
                            <div class="tyre-card-footer">
                                <a href="{{ route('tyremanage.vehicle.tyre.fitment', $vehicle->id) }}"
                                   class="btn btn-sm btn-take-action">
                                    <i class="uil uil-setting me-1"></i>Take Action
                                </a>
                                <button type="button" class="btn btn-sm btn-replace ms-2"
                                        data-position="{{ $pos }}"
                                        data-mapping-id="{{ $mapping->id }}">
                                    <i class="uil uil-exchange me-1"></i>Replace
                                </button>
                            </div>

                            @else
                            {{-- ── UNTAGGED: EMPTY STATE ───────────────────────── --}}
                            <div class="tyre-card-empty">
                                <div class="empty-icon"><i class="uil uil-circle-layer"></i></div>
                                <p class="empty-label">No Tyre Tagged</p>
                                <p class="empty-hint">Assign a tyre to position <strong>{{ $pos }}</strong> to begin tracking.</p>
                                <button type="button"
                                        class="btn btn-sm btn-add-tyre"
                                        data-position="{{ $pos }}"
                                        data-mapping-id="{{ $mapping->id }}"
                                        data-bs-toggle="modal"
                                        data-bs-target="#addTyre">
                                    <i class="uil uil-plus-circle me-1"></i>Allocate Tyre
                                </button>
                            </div>
                            @endif

                        </div>{{-- /tyre-card --}}

                        {{-- ── ATTACHMENT MODAL for position {{ $pos }} ─── --}}
                        @if($isTagged && $tyre && $tyre->medias && $tyre->medias->count())
                        <div class="modal fade" id="attachModal-{{ $pos }}" tabindex="-1" aria-labelledby="attachModalLabel-{{ $pos }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" style="max-width:420px;">
                                <div class="modal-content">
                                    <div class="modal-header py-2 px-3">
                                        <h6 class="modal-title fw-bold mb-0" id="attachModalLabel-{{ $pos }}">
                                            <i class="uil uil-paperclip me-1 text-primary"></i>
                                            Attachments
                                            <span class="badge bg-secondary ms-1" style="font-size:10px;">{{ $tyre->medias->count() }}</span>
                                            <span class="text-muted fw-normal ms-1" style="font-size:11px;">— Position {{ $pos }}</span>
                                        </h6>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body p-2">
                                        <div class="attachment-log" style="max-height:320px; overflow-y:auto;">
                                            @foreach($tyre->medias as $media)
                                            <div class="attachment-item">
                                                @if($media->type === 'Image')
                                                    <i class="uil uil-image attachment-icon img-icon"></i>
                                                @else
                                                    <i class="uil uil-file-alt attachment-icon doc-icon"></i>
                                                @endif
                                                <div class="attachment-meta">
                                                    <span class="attachment-name">{{ $media->file_name ?? 'Attachment' }}</span>
                                                    <span class="attachment-date">{{ $media->created_at ? \Carbon\Carbon::parse($media->created_at)->format('d M Y, h:i A') : '' }}</span>
                                                </div>
                                                <a href="{{ asset('medias/'.$media->file_path) }}" target="_blank" class="btn-attachment-view" title="View">
                                                    <i class="uil uil-eye"></i>
                                                </a>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                    @empty
                        <div class="alert alert-info">No tyre positions configured for this vehicle.</div>
                    @endforelse

                    {{-- ── SPARE TYRES ──────────────────────────── --}}
                    @php
                        $spares = $vehicle->vehicletyremappings->where('status', 'Spare');
                    @endphp

                    <div class="section-label mb-2 mt-4">
                        <i class="uil uil-archive me-1"></i>Spare Tyres
                    </div>

                    @foreach($spares as $mapping)
                        @php
                            $pos      = $mapping->tyreposition ? $mapping->tyreposition->code : 'S?';
                            $tyre     = $mapping->tyre;
                            $isTagged = $tyre !== null;
                            $rag      = $mapping->rag_status ?? 'grey';
                            $lifePct  = $mapping->life_remaining_pct;
                        @endphp

                        <div id="card-{{ $pos }}" class="tyre-card spare-card rag-border-{{ $rag }} mb-3" data-position="{{ $pos }}">
                            <div class="tyre-card-header">
                                <div class="d-flex align-items-center gap-2 flex-wrap">
                                    <span class="position-badge spare">{{ $pos }}</span>
                                    <span class="rag-badge rag-{{ $rag }}">
                                        @if($rag === 'green') 🟢 Good
                                        @elseif($rag === 'amber') 🟡 Moderate
                                        @elseif($rag === 'red') 🔴 Critical
                                        @else ⚫ Untagged
                                        @endif
                                    </span>
                                    <div class="ms-auto d-flex align-items-center gap-2">
                                        @if($isTagged && $lifePct !== null)
                                            <div class="life-bar-wrap">
                                                <div class="life-bar-track">
                                                    <div class="life-bar-fill rag-bg-{{ $rag }}" style="width: {{ $lifePct }}%"></div>
                                                </div>
                                                <span class="life-pct-label">{{ $lifePct }}% Life</span>
                                            </div>
                                        @endif
                                        @if($isTagged && $tyre && $tyre->medias && $tyre->medias->count())
                                            <button type="button" class="btn-attach-icon"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#attachModal-{{ $pos }}"
                                                    title="{{ $tyre->medias->count() }} Attachment(s)">
                                                <i class="uil uil-paperclip"></i>
                                                <span class="attach-count-badge">{{ $tyre->medias->count() }}</span>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            @if($isTagged)
                            <div class="tyre-card-body">
                                <div class="info-section">
                                    <div class="info-grid">
                                        <div class="info-item">
                                            <span class="info-label">Serial No.</span>
                                            <span class="info-value">{{ $tyre->tyre_serial_number ?? '—' }}</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="info-label">Condition</span>
                                            <span class="info-value">{{ $tyre->tyre_condition ?? '—' }}</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="info-label">Remaining Run</span>
                                            <span class="info-value">{{ $mapping->remaining_run_km !== null ? number_format($mapping->remaining_run_km).' KM' : '—' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tyre-card-footer">
                                <a href="{{ route('tyremanage.vehicle.tyre.fitment', $vehicle->id) }}" class="btn btn-sm btn-take-action">
                                    <i class="uil uil-setting me-1"></i>Take Action
                                </a>
                            </div>
                            @else
                            <div class="tyre-card-empty">
                                <div class="empty-icon"><i class="uil uil-circle-layer"></i></div>
                                <p class="empty-label">No Spare Tyre Tagged</p>
                                <button type="button" class="btn btn-sm btn-add-tyre"
                                        data-position="{{ $pos }}"
                                        data-mapping-id="{{ $mapping->id }}"
                                        data-bs-toggle="modal"
                                        data-bs-target="#addTyre">
                                    <i class="uil uil-plus-circle me-1"></i>Add Spare Tyre
                                </button>
                            </div>
                            @endif
                        </div>
                    @endforeach

                    {{-- Add new spare slot button --}}
                    <button type="button"
                            class="btn btn-outline-secondary btn-sm btn-add-spare-slot mt-2"
                            data-bs-toggle="modal"
                            data-bs-target="#addSpare">
                        <i class="uil uil-plus-circle me-1"></i>Add Spare Tyre Slot
                    </button>

                </div>{{-- /col right --}}
            </div>{{-- /row --}}
        </div>{{-- /container --}}

    </div>{{-- /vehicledtl-bd --}}
</div>{{-- /layout-wrapper --}}

{{-- ── ALLOCATE TYRE MODAL ──────────────────────────────────────────────── --}}
<div class="modal fade" id="addTyre" tabindex="-1" aria-labelledby="addTyreText" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="addTyreText">
            <i class="uil uil-tag-alt me-1"></i>Allocate Tyre —&nbsp;<span id="modalPositionLabel"></span>
        </h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="addTyreInlineForm" autocomplete="off" enctype="multipart/form-data">
            <input type="hidden" id="addTyrePositionCode" name="position_code" />
            <input type="hidden" id="addTyreMappingId"    name="mapping_id" />

            {{-- ── FIELD 1: Tyre Source ──────────────────────────────────── --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Tyre Source <span class="text-danger">*</span></label>
                <div class="d-flex gap-2 flex-wrap" id="tyreSourceBtns">
                    <input type="radio" class="btn-check" name="tyre_source" id="srcWarehouse" value="SR Warehouse" checked>
                    <label class="btn btn-outline-primary btn-sm px-3" for="srcWarehouse">
                        <i class="uil uil-archive me-1"></i>SR Warehouse
                    </label>
                    <input type="radio" class="btn-check" name="tyre_source" id="srcDirect" value="Direct Fitment">
                    <label class="btn btn-outline-secondary btn-sm px-3" for="srcDirect">
                        <i class="uil uil-truck me-1"></i>Direct Fitment
                    </label>
                </div>
                <div class="invalid-feedback d-block" id="err_tyre_source"></div>
            </div>

            {{-- ── FIELDS 2 & 3: Condition + Type ───────────────────────── --}}
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Tyre Condition <span class="text-danger">*</span></label>
                    <select class="form-select" name="tyre_condition" id="tyreConditionSelect">
                        <option value="">Select Condition</option>
                        <option value="New">New</option>
                        <option value="Used">Used</option>
                        <option value="Re-thread">Re-thread</option>
                    </select>
                    <div class="invalid-feedback" id="err_tyre_condition"></div>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Tyre Type <span class="text-danger">*</span></label>
                    <select class="form-select" name="tyre_type" id="tyreTypeSelect">
                        <option value="">Select Type</option>
                        <option value="Radial">Radial</option>
                        <option value="Nylon">Nylon</option>
                    </select>
                    <div class="invalid-feedback" id="err_tyre_type"></div>
                </div>
            </div>

            {{-- ── SR WAREHOUSE SECTION ──────────────────────────────────── --}}
            <div id="srcWarehouseSection">
                {{-- AJAX Tyre Dropdown --}}
                <div class="mb-2" id="tyreSelectorWrap">
                    <label class="form-label fw-semibold">Select Tyre from Warehouse <span class="text-danger">*</span></label>
                    <div id="tyreDropdownState" class="text-muted small mb-1">
                        — Select condition &amp; type to load available tyres —
                    </div>
                    <select class="form-select" name="tyre_id" id="tyreIdSelect" disabled>
                        <option value="">— Select condition &amp; type first —</option>
                    </select>
                    <div class="invalid-feedback" id="err_tyre_id"></div>

                    {{-- Health preview --}}
                    <div id="tyreHealthPreview" class="tyre-health-preview d-none mt-2">
                        <span class="health-label">Health:</span>
                        <div class="health-bar-track">
                            <div class="health-bar-fill" id="healthBarFill"></div>
                        </div>
                        <span class="health-pct-text" id="healthPctText"></span>
                        <span class="health-rag-badge ms-2" id="healthRagBadge"></span>
                    </div>
                </div>

                {{-- Auto-filled Brand + Serial (readonly) --}}
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-muted">Tyre Brand <span class="badge bg-light text-secondary border ms-1" style="font-size:10px;">Auto-filled</span></label>
                        <input type="text" class="form-control bg-light" id="wh_tyreBrand" readonly placeholder="Auto-filled on tyre selection" />
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-muted">Tyre Serial Number <span class="badge bg-light text-secondary border ms-1" style="font-size:10px;">Auto-filled</span></label>
                        <input type="text" class="form-control bg-light" id="wh_tyreSerial" readonly placeholder="Auto-filled on tyre selection" />
                    </div>
                </div>
            </div>

            {{-- ── DIRECT FITMENT SECTION (hidden by default) ───────────── --}}
            <div id="srcDirectSection" class="d-none">
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Tyre Brand <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="tyre_brand" id="directTyreBrand" placeholder="e.g. Apollo, MRF, Bridgestone" maxlength="100" />
                        <div class="invalid-feedback" id="err_tyre_brand"></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Tyre Serial Number <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="tyre_serial_number" id="directTyreSerial" placeholder="e.g. SN-12345" maxlength="100" />
                        <div class="invalid-feedback" id="err_tyre_serial_number"></div>
                    </div>
                </div>
            </div>

            {{-- ── FIELDS 6 & 7: Fitment Date + KM at Fitment ──────────── --}}
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Fitment Date <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" name="fitment_date" id="fitmentDateInput" />
                    <div class="invalid-feedback" id="err_fitment_date"></div>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">KM at Fitment</label>
                    <div class="input-group">
                        <input type="number" class="form-control" name="km_at_fitment" id="kmAtFitmentInput" min="0" placeholder="0" />
                        <span class="input-group-text">KM</span>
                    </div>
                    <div class="invalid-feedback" id="err_km_at_fitment"></div>
                    {{-- Odometer reference hint (populated by JS when lastKnownKm exists) --}}
                    <div id="kmOdoHint" class="d-none mt-1">
                        <small class="text-muted">
                            <i class="uil uil-info-circle me-1"></i>Last recorded:
                            <strong id="kmHintKm"></strong> KM on <strong id="kmHintDate"></strong>
                        </small>
                    </div>
                    <div id="kmOdoWarning" class="d-none mt-1">
                        <small class="text-danger fw-semibold">
                            <i class="uil uil-exclamation-triangle me-1"></i>
                            <span id="kmOdoWarningText"></span>
                        </small>
                    </div>
                </div>
            </div>

            {{-- ── FIELD 8: Attachments ─────────────────────────────────── --}}
            <div class="mb-1">
                <label class="form-label fw-semibold">
                    <i class="uil uil-paperclip me-1"></i>Attachments
                    <span class="text-muted fw-normal small ms-1">(JPG / PNG / WEBP, max 5 MB each)</span>
                </label>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label small text-muted mb-1">Tyre Serial Number Photo</label>
                        <input type="file" class="form-control form-control-sm" name="photo_serial" id="photoSerial" accept="image/jpeg,image/png,image/webp" />
                        <div class="invalid-feedback" id="err_photo_serial"></div>
                        <div id="previewSerial" class="mt-1 d-none">
                            <img class="at-thumb" alt="Serial preview" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small text-muted mb-1">Tyre on Truck Fitment Photo</label>
                        <input type="file" class="form-control form-control-sm" name="photo_fitment" id="photoFitment" accept="image/jpeg,image/png,image/webp" />
                        <div class="invalid-feedback" id="err_photo_fitment"></div>
                        <div id="previewFitment" class="mt-1 d-none">
                            <img class="at-thumb" alt="Fitment preview" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small text-muted mb-1">Odometer Photo</label>
                        <input type="file" class="form-control form-control-sm" name="photo_odometer" id="photoOdometer" accept="image/jpeg,image/png,image/webp" />
                        <div class="invalid-feedback" id="err_photo_odometer"></div>
                        <div id="previewOdometer" class="mt-1 d-none">
                            <img class="at-thumb" alt="Odometer preview" />
                        </div>
                    </div>
                </div>
            </div>

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="uil uil-times me-1"></i>Cancel
        </button>
        <button type="button" class="btn btn-primary" id="saveAddTyre">
            <i class="uil uil-tag-alt me-1"></i>Save &amp; Allocate Tyre
        </button>
      </div>
    </div>
  </div>
</div>
{{-- ── ADD SPARE TYRE MODAL ─────────────────────────────────────────────── --}}
<div class="modal fade" id="addSpare" tabindex="-1" aria-labelledby="addSpareText" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="addSpareText">
            <i class="uil uil-plus-circle me-1"></i>Add Spare Tyre
        </h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="addSpareInlineForm" autocomplete="off">

            {{-- Row 1: Condition + Type --}}
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Tyre Condition <span class="text-danger">*</span></label>
                    <select class="form-select" name="condition" id="spareTyreConditionSelect">
                        <option value="">Select Condition</option>
                        <option value="New">New</option>
                        <option value="Re-thread">Rethread</option>
                        <option value="Used">Used</option>
                        <option value="Retread">Retread</option>
                        <option value="Used Good">Used Good</option>
                    </select>
                    <div class="invalid-feedback" id="spare_err_condition"></div>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Tyre Type <span class="text-danger">*</span></label>
                    <select class="form-select" name="tyre_type" id="spareTyreTypeSelect">
                        <option value="">Select Type</option>
                        <option value="Radial">Radial</option>
                        <option value="Nylon">Nylon</option>
                    </select>
                    <div class="invalid-feedback" id="spare_err_tyre_type"></div>
                </div>
            </div>

            {{-- Row 2: Tyre dropdown (AJAX-loaded) --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Select Tyre <span class="text-danger">*</span></label>
                <div id="spareTyreDropdownState" class="text-muted small mb-1">
                    — Select condition &amp; type to load available tyres —
                </div>
                <select class="form-select" name="tyre_id" id="spareTyreIdSelect" disabled>
                    <option value="">— Select condition &amp; type first —</option>
                </select>
                <div class="invalid-feedback" id="spare_err_tyre_id"></div>

                {{-- Spare tyre health preview --}}
                <div id="spareTyreHealthPreview" class="tyre-health-preview d-none mt-2">
                    <span class="health-label">Health:</span>
                    <div class="health-bar-track">
                        <div class="health-bar-fill" id="spareHealthBarFill"></div>
                    </div>
                    <span class="health-pct-text" id="spareHealthPctText"></span>
                    <span class="health-rag-badge ms-2" id="spareHealthRagBadge"></span>
                </div>
            </div>

            {{-- Row 3: Fitment Date + KM --}}
            <div class="row g-3 mb-2">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Fitment Date <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" name="fitment_date" id="spareFitmentDateInput" />
                    <div class="invalid-feedback" id="spare_err_fitment_date"></div>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">KM at Fitment</label>
                    <div class="input-group">
                        <input type="number" class="form-control" name="km_at_fitment" id="spareKmAtFitmentInput" min="0" placeholder="0" />
                        <span class="input-group-text">KM</span>
                    </div>
                    <div class="invalid-feedback" id="spare_err_km_at_fitment"></div>
                </div>
            </div>

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="uil uil-times me-1"></i>Cancel
        </button>
        <button type="button" class="btn btn-primary" id="saveAddSpare">
            <i class="uil uil-save me-1"></i>Save &amp; Add Spare
        </button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('js')
<script type="text/javascript" src="{{ asset('arobittyre_management/fleet-tyre.js') }}"></script>
<script type="text/javascript" src="{{ asset('customjs/tyremanagement/vehicletyretagging.js') }}?v={{ time() }}"></script>
@endsection
