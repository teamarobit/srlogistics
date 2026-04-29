@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/tyre/tagging.css') }}?v={{ filemtime(public_path('css/tyre/tagging.css')) }}">
    <link rel="stylesheet" href="{{ asset('css/tyre/tagging-v2.css') }}?v={{ filemtime(public_path('css/tyre/tagging-v2.css')) }}">
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

        {{-- ── PASS RAG DATA + ROUTE URLS + V2 DATA TO JS ─────────────────── --}}
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
            const addTyreBaseUrl      = "{{ url('tyremanage/vehicle/'.$vehicle->id.'/mapping') }}";
            const addSpareUrl         = "{{ route('tyremanage.vehicle.add.spare', $vehicle->id) }}";
            const csrfToken           = "{{ csrf_token() }}";
            const lastKnownKm         = {{ $lastKnownKm ?? 'null' }};
            const lastKnownDate       = "{{ $lastKnownDate ?? '' }}";

            /* v2: vehicle context for Take Action modal */
            const vehicleId = {{ $vehicle->id }};
            @php
                $allMappingsJson = $vehicle->vehicletyremappings->map(function($m) {
                    return [
                        'id'      => $m->id,
                        'pos'     => $m->tyreposition?->code ?? '',
                        'status'  => $m->status,
                        'serial'  => $m->tyre?->tyre_serial_number ?? '',
                        'brand'   => $m->tyre?->tyre_brand ?? '',
                        'life'    => $m->life_remaining_pct,
                        'tyre_id' => $m->tyre?->id,
                        'rag'     => $m->rag_status ?? 'grey',
                    ];
                })->values();
                $spareTyresJson = $vehicle->vehicletyremappings->where('status', 'Spare')->map(function($m) {
                    return [
                        'id'      => $m->id,
                        'pos'     => $m->tyreposition?->code ?? '',
                        'serial'  => $m->tyre?->tyre_serial_number ?? 'N/A',
                        'brand'   => $m->tyre?->tyre_brand ?? '',
                        'tyre_id' => $m->tyre?->id,
                        'life'    => $m->life_remaining_pct,
                    ];
                })->values();
                $mountedPositionsJson = $vehicle->vehicletyremappings->where('status', '!=', 'Spare')->map(function($m) {
                    return ['pos' => $m->tyreposition?->code ?? '', 'id' => $m->id];
                })->values();
            @endphp
            const allMappings       = @json($allMappingsJson);
            const spareTyresList    = @json($spareTyresJson);
            const mountedPositions  = @json($mountedPositionsJson);
            const takeActionBaseUrl = "{{ url('tyremanage/vehicle/'.$vehicle->id) }}";
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

                        <input hidden id="type" value="{{ $vehicle->mounted_tyre_count }}" />

                        <div id="container-img" class="svg-container">
                            <svg id="taggingTruckSvg" viewBox="0 0 220 430" xmlns="http://www.w3.org/2000/svg" style="width:100%;max-width:220px;margin:0 auto;display:block;">

                                <text x="110" y="48" text-anchor="middle" font-size="9" fill="#94a3b8" font-weight="700" letter-spacing="1">▲ FRONT</text>
                                <rect x="57" y="70" width="106" height="354" rx="16" fill="#e2e8f0" stroke="none"/>
                                <rect x="59" y="72" width="102" height="350" rx="14" fill="#f0f3f9" stroke="#c8d4e8" stroke-width="1.5"/>
                                <rect x="59" y="72" width="102" height="108" rx="14" fill="#dce7ff" stroke="#b0c4f0" stroke-width="1.5"/>
                                <rect x="71" y="80" width="78" height="34" rx="6" fill="#b8d0f5" opacity="0.85"/>
                                <line x1="77" y1="83" x2="77" y2="111" stroke="#fff" stroke-width="1.5" stroke-linecap="round" opacity="0.5"/>
                                <line x1="83" y1="81" x2="83" y2="113" stroke="#fff" stroke-width="0.7" stroke-linecap="round" opacity="0.25"/>
                                <rect x="71" y="116" width="78" height="14" rx="3" fill="#c8d8f0" stroke="#b0c4e8" stroke-width="1"/>
                                <rect x="45" y="84" width="14" height="9" rx="2.5" fill="#b0c4e8" stroke="#9ab0d8" stroke-width="1"/>
                                <rect x="161" y="84" width="14" height="9" rx="2.5" fill="#b0c4e8" stroke="#9ab0d8" stroke-width="1"/>
                                <line x1="59" y1="88" x2="65" y2="88" stroke="#a0b4d0" stroke-width="1.5"/>
                                <line x1="155" y1="88" x2="161" y2="88" stroke="#a0b4d0" stroke-width="1.5"/>
                                <text x="110" y="160" text-anchor="middle" font-size="7" fill="#7b93c4" font-weight="600" letter-spacing="1.5">CAB</text>
                                <line x1="64" y1="180" x2="156" y2="180" stroke="#c8d4e8" stroke-width="1.5" stroke-dasharray="3,2"/>
                                <rect x="63" y="182" width="94" height="236" rx="4" fill="#f5f7fb" stroke="#dce3f0" stroke-width="1"/>
                                <line x1="63" y1="228" x2="157" y2="228" stroke="#e0e8f4" stroke-width="1"/>
                                <line x1="63" y1="310" x2="157" y2="310" stroke="#e0e8f4" stroke-width="1"/>
                                <line x1="63" y1="392" x2="157" y2="392" stroke="#e0e8f4" stroke-width="1"/>
                                <text x="110" y="266" text-anchor="middle" font-size="7" fill="#b0bcce" letter-spacing="2">CARGO</text>
                                <rect x="30" y="124" width="160" height="4" rx="2" fill="#c0ccde"/>
                                <circle cx="42" cy="126" r="4" fill="#9ab0cc" stroke="#8098b8" stroke-width="1"/>
                                <circle cx="178" cy="126" r="4" fill="#9ab0cc" stroke="#8098b8" stroke-width="1"/>
                                <rect x="16" y="280" width="188" height="4" rx="2" fill="#c0ccde"/>
                                <circle cx="29" cy="282" r="3.5" fill="#9ab0cc" stroke="#8098b8" stroke-width="1"/>
                                <circle cx="50" cy="282" r="3.5" fill="#9ab0cc" stroke="#8098b8" stroke-width="1"/>
                                <circle cx="170" cy="282" r="3.5" fill="#9ab0cc" stroke="#8098b8" stroke-width="1"/>
                                <circle cx="191" cy="282" r="3.5" fill="#9ab0cc" stroke="#8098b8" stroke-width="1"/>
                                <rect x="16" y="370" width="188" height="4" rx="2" fill="#c0ccde"/>
                                <circle cx="29" cy="372" r="3.5" fill="#9ab0cc" stroke="#8098b8" stroke-width="1"/>
                                <circle cx="50" cy="372" r="3.5" fill="#9ab0cc" stroke="#8098b8" stroke-width="1"/>
                                <circle cx="170" cy="372" r="3.5" fill="#9ab0cc" stroke="#8098b8" stroke-width="1"/>
                                <circle cx="191" cy="372" r="3.5" fill="#9ab0cc" stroke="#8098b8" stroke-width="1"/>
                                <text x="110" y="119" text-anchor="middle" font-size="6.5" fill="#adb5bd" letter-spacing="0.5">FRONT AXLE</text>
                                <text x="110" y="276" text-anchor="middle" font-size="6.5" fill="#adb5bd" letter-spacing="0.5">REAR AXLE 1</text>
                                <text x="110" y="366" text-anchor="middle" font-size="6.5" fill="#adb5bd" letter-spacing="0.5">REAR AXLE 2</text>
                                <text x="110" y="226" text-anchor="middle" font-size="5.5" fill="#adb5bd" letter-spacing="0.5">SPARE</text>

                                <g class="tyre-group" data-code="C1">
                                    <rect x="30" y="109" width="24" height="34" rx="5" fill="#adb5bd" stroke="#fff" stroke-width="1.5"/>
                                    <text x="42" y="131" text-anchor="middle" font-size="8" fill="#fff" font-weight="700">C1</text>
                                </g>
                                <g class="tyre-group" data-code="D1">
                                    <rect x="166" y="109" width="24" height="34" rx="5" fill="#adb5bd" stroke="#fff" stroke-width="1.5"/>
                                    <text x="178" y="131" text-anchor="middle" font-size="8" fill="#fff" font-weight="700">D1</text>
                                </g>
                                <g class="tyre-group" data-code="Co3">
                                    <rect x="20" y="267" width="19" height="30" rx="4" fill="#adb5bd" stroke="#fff" stroke-width="1.5"/>
                                    <text x="29" y="286" text-anchor="middle" font-size="6" fill="#fff" font-weight="700">Co3</text>
                                </g>
                                <g class="tyre-group" data-code="Ci2">
                                    <rect x="41" y="267" width="19" height="30" rx="4" fill="#adb5bd" stroke="#fff" stroke-width="1.5"/>
                                    <text x="50" y="286" text-anchor="middle" font-size="6" fill="#fff" font-weight="700">Ci2</text>
                                </g>
                                <g class="tyre-group" data-code="Di2">
                                    <rect x="160" y="267" width="19" height="30" rx="4" fill="#adb5bd" stroke="#fff" stroke-width="1.5"/>
                                    <text x="169" y="286" text-anchor="middle" font-size="6" fill="#fff" font-weight="700">Di2</text>
                                </g>
                                <g class="tyre-group" data-code="Do3">
                                    <rect x="181" y="267" width="19" height="30" rx="4" fill="#adb5bd" stroke="#fff" stroke-width="1.5"/>
                                    <text x="190" y="286" text-anchor="middle" font-size="6" fill="#fff" font-weight="700">Do3</text>
                                </g>
                                <g class="tyre-group" data-code="Co5">
                                    <rect x="20" y="357" width="19" height="30" rx="4" fill="#adb5bd" stroke="#fff" stroke-width="1.5"/>
                                    <text x="29" y="376" text-anchor="middle" font-size="6" fill="#fff" font-weight="700">Co5</text>
                                </g>
                                <g class="tyre-group" data-code="Ci4">
                                    <rect x="41" y="357" width="19" height="30" rx="4" fill="#adb5bd" stroke="#fff" stroke-width="1.5"/>
                                    <text x="50" y="376" text-anchor="middle" font-size="6" fill="#fff" font-weight="700">Ci4</text>
                                </g>
                                <g class="tyre-group" data-code="Di4">
                                    <rect x="160" y="357" width="19" height="30" rx="4" fill="#adb5bd" stroke="#fff" stroke-width="1.5"/>
                                    <text x="169" y="376" text-anchor="middle" font-size="6" fill="#fff" font-weight="700">Di4</text>
                                </g>
                                <g class="tyre-group" data-code="Do5">
                                    <rect x="181" y="357" width="19" height="30" rx="4" fill="#adb5bd" stroke="#fff" stroke-width="1.5"/>
                                    <text x="190" y="376" text-anchor="middle" font-size="6" fill="#fff" font-weight="700">Do5</text>
                                </g>
                                <g class="tyre-group" data-code="S1">
                                    <rect x="87" y="230" width="21" height="26" rx="4" fill="#adb5bd" stroke="#fff" stroke-width="1.5"/>
                                    <text x="97" y="246" text-anchor="middle" font-size="6" fill="#fff" font-weight="700">S1</text>
                                </g>
                                <g class="tyre-group" data-code="S2">
                                    <rect x="112" y="230" width="21" height="26" rx="4" fill="#adb5bd" stroke="#fff" stroke-width="1.5"/>
                                    <text x="122" y="246" text-anchor="middle" font-size="6" fill="#fff" font-weight="700">S2</text>
                                </g>

                            </svg>
                        </div>

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
                                        @if($isTagged)
                                            <div class="header-action-divider"></div>
                                            {{-- V2: Take Action opens modal (not redirect) --}}
                                            <button type="button"
                                                    class="btn btn-xs btn-take-action btn-open-take-action"
                                                    data-position="{{ $pos }}"
                                                    data-mapping-id="{{ $mapping->id }}"
                                                    data-tyre-serial="{{ $tyre->tyre_serial_number ?? '' }}"
                                                    data-tyre-brand="{{ $tyre->tyre_brand ?? '' }}"
                                                    data-tyre-condition="{{ $tyre->tyre_condition ?? '' }}"
                                                    data-remaining-km="{{ $mapping->remaining_run_km ?? '' }}"
                                                    data-life-pct="{{ $lifePct ?? '' }}"
                                                    data-rag="{{ $rag }}"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#takeActionModal">
                                                <i class="uil uil-setting me-1"></i>Take Action
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            @if($isTagged)
                            <div class="tyre-card-body">

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

                                <div class="info-section">
                                    <div class="info-section-title">
                                        <i class="uil uil-receipt"></i> Purchase & Fitment
                                    </div>
                                    <div class="info-grid">
                                        <div class="info-item">
                                            <span class="info-label">Price</span>
                                            <span class="info-value">₹{{ $tyre->tyre_price ? number_format($tyre->tyre_price, 2) : '—' }}</span>
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

                                <div class="info-section-pair">
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
                                </div>

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

                            @else
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

                        {{-- Attachment Modal --}}
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
                                        @if($isTagged)
                                            <div class="header-action-divider"></div>
                                            {{-- V2: Take Action opens modal --}}
                                            <button type="button"
                                                    class="btn btn-xs btn-take-action btn-open-take-action"
                                                    data-position="{{ $pos }}"
                                                    data-mapping-id="{{ $mapping->id }}"
                                                    data-tyre-serial="{{ $tyre->tyre_serial_number ?? '' }}"
                                                    data-tyre-brand="{{ $tyre->tyre_brand ?? '' }}"
                                                    data-tyre-condition="{{ $tyre->tyre_condition ?? '' }}"
                                                    data-remaining-km="{{ $mapping->remaining_run_km ?? '' }}"
                                                    data-life-pct="{{ $lifePct ?? '' }}"
                                                    data-rag="{{ $rag }}"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#takeActionModal">
                                                <i class="uil uil-setting me-1"></i>Take Action
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

{{-- ══════════════════════════════════════════════════════════════════════════
     ALLOCATE TYRE MODAL (unchanged from v1)
════════════════════════════════════════════════════════════════════════════ --}}
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
            <div id="srcWarehouseSection">
                <div class="mb-2" id="tyreSelectorWrap">
                    <label class="form-label fw-semibold">Select Tyre from Warehouse <span class="text-danger">*</span></label>
                    <div id="tyreDropdownState" class="text-muted small mb-1">
                        — Select condition &amp; type to load available tyres —
                    </div>
                    <select class="form-select" name="tyre_id" id="tyreIdSelect" disabled>
                        <option value="">— Select condition &amp; type first —</option>
                    </select>
                    <div class="invalid-feedback" id="err_tyre_id"></div>
                    <div id="tyreHealthPreview" class="tyre-health-preview d-none mt-2">
                        <span class="health-label">Health:</span>
                        <div class="health-bar-track">
                            <div class="health-bar-fill" id="healthBarFill"></div>
                        </div>
                        <span class="health-pct-text" id="healthPctText"></span>
                        <span class="health-rag-badge ms-2" id="healthRagBadge"></span>
                    </div>
                </div>
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
                        <div id="previewSerial" class="mt-1 d-none"><img class="at-thumb" alt="Serial preview" /></div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small text-muted mb-1">Tyre on Truck Fitment Photo</label>
                        <input type="file" class="form-control form-control-sm" name="photo_fitment" id="photoFitment" accept="image/jpeg,image/png,image/webp" />
                        <div class="invalid-feedback" id="err_photo_fitment"></div>
                        <div id="previewFitment" class="mt-1 d-none"><img class="at-thumb" alt="Fitment preview" /></div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small text-muted mb-1">Odometer Photo</label>
                        <input type="file" class="form-control form-control-sm" name="photo_odometer" id="photoOdometer" accept="image/jpeg,image/png,image/webp" />
                        <div class="invalid-feedback" id="err_photo_odometer"></div>
                        <div id="previewOdometer" class="mt-1 d-none"><img class="at-thumb" alt="Odometer preview" /></div>
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

{{-- ══════════════════════════════════════════════════════════════════════════
     ADD SPARE TYRE MODAL (unchanged from v1)
════════════════════════════════════════════════════════════════════════════ --}}
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
            <div class="mb-3">
                <label class="form-label fw-semibold">Select Tyre <span class="text-danger">*</span></label>
                <div id="spareTyreDropdownState" class="text-muted small mb-1">
                    — Select condition &amp; type to load available tyres —
                </div>
                <select class="form-select" name="tyre_id" id="spareTyreIdSelect" disabled>
                    <option value="">— Select condition &amp; type first —</option>
                </select>
                <div class="invalid-feedback" id="spare_err_tyre_id"></div>
                <div id="spareTyreHealthPreview" class="tyre-health-preview d-none mt-2">
                    <span class="health-label">Health:</span>
                    <div class="health-bar-track">
                        <div class="health-bar-fill" id="spareHealthBarFill"></div>
                    </div>
                    <span class="health-pct-text" id="spareHealthPctText"></span>
                    <span class="health-rag-badge ms-2" id="spareHealthRagBadge"></span>
                </div>
            </div>
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

{{-- ══════════════════════════════════════════════════════════════════════════
     ██████  TAKE ACTION MODAL (v2 — NEW) ██████
     Three tabs: Replace Tyre | Rotate Tyre | Alignment
════════════════════════════════════════════════════════════════════════════ --}}
<div class="modal fade" id="takeActionModal" tabindex="-1" aria-labelledby="takeActionModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
    <div class="modal-content">

      {{-- Modal Header --}}
      <div class="modal-header py-2 px-3" style="border-bottom:1px solid #e9ecef;">
        <div style="flex:1; min-width:0;">
            <h6 class="modal-title fw-bold mb-0" id="takeActionModalLabel">
                <i class="uil uil-setting me-1 text-primary"></i>Take Action
            </h6>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      {{-- Modal Body --}}
      <div class="modal-body" style="padding:14px 18px;">

          {{-- Tyre Info Bar --}}
          <div class="tam-header-info">
              <span class="tam-pos-label" id="tamPosLabel">—</span>
              <div class="tam-tyre-detail">
                  <span class="tam-tyre-serial-text" id="tamSerialText">—</span>
                  <span class="tam-tyre-brand-text" id="tamBrandText"></span>
              </div>
              <span class="tam-rag-mini rag-grey" id="tamRagBadge">⚫ Untagged</span>
              <span class="text-white" id="tamLifeText" style="font-size:11px; opacity:0.8;"></span>
          </div>

          {{-- Tab Navigation --}}
          <div class="tam-tabs" id="tamTabNav">
              <button type="button" class="tam-tab-btn active" data-tab="replace">
                  <i class="uil uil-exchange"></i> Replace Tyre
              </button>
              <button type="button" class="tam-tab-btn" data-tab="rotate">
                  <i class="uil uil-sync"></i> Rotate Tyre
              </button>
              <button type="button" class="tam-tab-btn" data-tab="alignment">
                  <i class="uil uil-ruler-combined"></i> Alignment
              </button>
          </div>

          {{-- ─────────────────────────────────────────────────────────────
               TAB 1: REPLACE TYRE
          ───────────────────────────────────────────────────────────────── --}}
          <div class="tam-tab-pane active" id="tamPaneReplace">
            <form id="tamReplaceForm" autocomplete="off" enctype="multipart/form-data">
                <input type="hidden" id="tamRplMappingId" name="mapping_id">
                <input type="hidden" id="tamRplPosition" name="position">

                {{-- SECTION 1: Replacement Reason --}}
                <div class="tam-section">
                    <div class="tam-section-title">
                        <span class="tam-section-num">1</span>
                        Replacement Reason
                    </div>
                    <div class="row g-2">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" style="font-size:12px;">Reason for Replacement <span class="text-danger">*</span></label>
                            <select class="form-select form-select-sm" id="tamRplReason" name="replacement_reason">
                                <option value="">— Select Reason —</option>
                                <option value="Tyre Burst">Tyre Burst</option>
                                <option value="Tyre Cut">Tyre Cut</option>
                                <option value="Tyre Bulge">Tyre Bulge</option>
                                <option value="Middle Worn Out">Middle Worn Out</option>
                                <option value="Edge Worn Out">Edge Worn Out</option>
                                <option value="Un-even Worn Out">Un-even Worn Out</option>
                                <option value="Fully Worn Out">Fully Worn Out</option>
                            </select>
                            <span class="tam-field-error" id="tamErrRplReason"></span>
                        </div>
                    </div>
                </div>

                {{-- SECTION 2: Damage Responsibility --}}
                <div class="tam-section">
                    <div class="tam-section-title">
                        <span class="tam-section-num">2</span>
                        Damage Responsibility
                    </div>
                    <div class="row g-2 align-items-start">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" style="font-size:12px;">Damage Reason <span class="text-danger">*</span></label>
                            <select class="form-select form-select-sm" id="tamRplDamageReason" name="damage_reason">
                                <option value="">— Select —</option>
                                <option value="Driver">Driver</option>
                                <option value="Tyre Brand">Tyre Brand</option>
                                <option value="Truck Brand">Truck Brand</option>
                                <option value="Tyre Vendor">Tyre Vendor</option>
                                <option value="Normal Wear & Tear">Normal Wear &amp; Tear</option>
                            </select>
                            <span class="tam-field-error" id="tamErrRplDamageReason"></span>
                        </div>
                        {{-- Driver Fine: shown only when Driver selected --}}
                        <div class="col-md-6 tam-conditional" id="tamDriverFineWrap">
                            <div class="tam-fine-box">
                                <div class="tam-fine-title">
                                    <i class="uil uil-exclamation-triangle"></i> Driver Fine
                                </div>
                                <label class="form-label fw-semibold" style="font-size:12px;">Fine Amount (₹) <span class="text-danger">*</span></label>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text">₹</span>
                                    <input type="number" class="form-control" id="tamDriverFineAmount" name="driver_fine_amount" min="0" placeholder="0.00" step="0.01">
                                </div>
                                <div class="tam-alert tam-alert-info mt-2" style="padding:6px 10px; font-size:11px;">
                                    <i class="uil uil-info-circle"></i>
                                    This fine will be sent to Driver Escalation and reflected in Driver Hisab.
                                </div>
                                <span class="tam-field-error" id="tamErrDriverFine"></span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- SECTION 3: Evidence Upload --}}
                <div class="tam-section">
                    <div class="tam-section-title">
                        <span class="tam-section-num">3</span>
                        Damage Evidence
                    </div>
                    <label class="form-label fw-semibold" style="font-size:12px;">
                        <i class="uil uil-image me-1"></i>Damaged Tyre Photos
                        <span class="text-muted fw-normal small">(JPG/PNG/WEBP, max 5 MB each)</span>
                    </label>
                    <div class="tam-photo-grid">
                        <div class="tam-photo-slot">
                            <span class="tam-photo-slot-label">Photo 1</span>
                            <input type="file" class="form-control form-control-sm" name="damage_photo_1" id="tamDmgPhoto1" accept="image/jpeg,image/png,image/webp">
                            <img class="tam-photo-thumb" id="tamDmgThumb1" alt="Preview">
                        </div>
                        <div class="tam-photo-slot">
                            <span class="tam-photo-slot-label">Photo 2</span>
                            <input type="file" class="form-control form-control-sm" name="damage_photo_2" id="tamDmgPhoto2" accept="image/jpeg,image/png,image/webp">
                            <img class="tam-photo-thumb" id="tamDmgThumb2" alt="Preview">
                        </div>
                        <div class="tam-photo-slot">
                            <span class="tam-photo-slot-label">Photo 3</span>
                            <input type="file" class="form-control form-control-sm" name="damage_photo_3" id="tamDmgPhoto3" accept="image/jpeg,image/png,image/webp">
                            <img class="tam-photo-thumb" id="tamDmgThumb3" alt="Preview">
                        </div>
                    </div>
                </div>

                {{-- SECTION 4: Replacement Tyre Source --}}
                <div class="tam-section">
                    <div class="tam-section-title">
                        <span class="tam-section-num">4</span>
                        Replacement Tyre Source
                    </div>
                    <div class="tam-source-grid" id="tamRplSourceGrid">

                        <label class="tam-source-card" for="tamSrcGarage">
                            <input type="radio" name="replacement_source" id="tamSrcGarage" value="SR Garage" class="d-none">
                            <span class="tam-source-icon"><i class="uil uil-building"></i></span>
                            <div class="tam-source-info">
                                <div class="tam-source-title">SR Garage</div>
                                <div class="tam-source-desc">From in-house inventory</div>
                            </div>
                            <span class="tam-source-check"><i class="uil uil-check-circle"></i></span>
                        </label>

                        <label class="tam-source-card" for="tamSrcDirect">
                            <input type="radio" name="replacement_source" id="tamSrcDirect" value="Direct Fitment" class="d-none">
                            <span class="tam-source-icon"><i class="uil uil-truck"></i></span>
                            <div class="tam-source-info">
                                <div class="tam-source-title">Direct Fitment</div>
                                <div class="tam-source-desc">New tyre from vendor</div>
                            </div>
                            <span class="tam-source-check"><i class="uil uil-check-circle"></i></span>
                        </label>

                        <label class="tam-source-card" for="tamSrcSpare">
                            <input type="radio" name="replacement_source" id="tamSrcSpare" value="Same Vehicle Spare" class="d-none">
                            <span class="tam-source-icon"><i class="uil uil-archive"></i></span>
                            <div class="tam-source-info">
                                <div class="tam-source-title">Same Vehicle Spare</div>
                                <div class="tam-source-desc">Use on-vehicle spare</div>
                            </div>
                            <span class="tam-source-check"><i class="uil uil-check-circle"></i></span>
                        </label>

                        <label class="tam-source-card" for="tamSrcOtherVehicle">
                            <input type="radio" name="replacement_source" id="tamSrcOtherVehicle" value="Another Vehicle" class="d-none">
                            <span class="tam-source-icon"><i class="uil uil-exchange"></i></span>
                            <div class="tam-source-info">
                                <div class="tam-source-title">Another Vehicle</div>
                                <div class="tam-source-desc">Transfer from another truck</div>
                            </div>
                            <span class="tam-source-check"><i class="uil uil-check-circle"></i></span>
                        </label>

                    </div>
                    <span class="tam-field-error" id="tamErrRplSource"></span>

                    {{-- ── SOURCE PANEL: SR Garage ── --}}
                    <div class="tam-src-panel" id="tamPanelGarage">
                        <div class="tam-section-title" style="margin-top:10px;">
                            <i class="uil uil-building me-1"></i>SR Garage — Tyre Details
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-md-4">
                                <label class="form-label fw-semibold" style="font-size:12px;">Tyre Condition <span class="text-danger">*</span></label>
                                <select class="form-select form-select-sm" name="new_tyre_condition_garage" id="tamGarCondition">
                                    <option value="">Select</option>
                                    <option value="New">New</option>
                                    <option value="Used">Used</option>
                                    <option value="Re-thread">Re-thread</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold" style="font-size:12px;">Tyre Type <span class="text-danger">*</span></label>
                                <select class="form-select form-select-sm" name="new_tyre_type_garage" id="tamGarType">
                                    <option value="">Select</option>
                                    <option value="Radial">Radial</option>
                                    <option value="Nylon">Nylon</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold" style="font-size:12px;">Tyre Brand <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" name="new_tyre_brand_garage" id="tamGarBrand" placeholder="e.g. Apollo">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold" style="font-size:12px;">Tyre Serial Number <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" name="new_tyre_serial_garage" id="tamGarSerial" placeholder="Serial No.">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold" style="font-size:12px;">Replacement Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control form-control-sm" name="replacement_date_garage" id="tamGarDate">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold" style="font-size:12px;">KM at Replacement</label>
                                <div class="input-group input-group-sm">
                                    <input type="number" class="form-control" name="replacement_km_garage" id="tamGarKm" min="0" placeholder="0">
                                    <span class="input-group-text">KM</span>
                                </div>
                            </div>
                        </div>
                        {{-- Attachments --}}
                        <label class="form-label fw-semibold" style="font-size:12px; margin-bottom:4px;">Attachments</label>
                        <div class="tam-photo-grid">
                            <div class="tam-photo-slot">
                                <span class="tam-photo-slot-label">Serial No. Photo</span>
                                <input type="file" class="form-control form-control-sm" name="garage_serial_photo" id="tamGarPhotoSerial" accept="image/jpeg,image/png,image/webp">
                                <img class="tam-photo-thumb" id="tamGarThumbSerial" alt="Preview">
                            </div>
                            <div class="tam-photo-slot">
                                <span class="tam-photo-slot-label">Fitment Photo</span>
                                <input type="file" class="form-control form-control-sm" name="garage_fitment_photo" id="tamGarPhotoFitment" accept="image/jpeg,image/png,image/webp">
                                <img class="tam-photo-thumb" id="tamGarThumbFitment" alt="Preview">
                            </div>
                            <div class="tam-photo-slot">
                                <span class="tam-photo-slot-label">Odometer Photo</span>
                                <input type="file" class="form-control form-control-sm" name="garage_odometer_photo" id="tamGarPhotoOdo" accept="image/jpeg,image/png,image/webp">
                                <img class="tam-photo-thumb" id="tamGarThumbOdo" alt="Preview">
                            </div>
                        </div>
                    </div>

                    {{-- ── SOURCE PANEL: Direct Fitment ── --}}
                    <div class="tam-src-panel" id="tamPanelDirect">
                        <div class="tam-section-title" style="margin-top:10px;">
                            <i class="uil uil-truck me-1"></i>Direct Fitment — Tyre Details
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-md-4">
                                <label class="form-label fw-semibold" style="font-size:12px;">Tyre Condition <span class="text-danger">*</span></label>
                                <select class="form-select form-select-sm" name="new_tyre_condition_direct" id="tamDirCondition">
                                    <option value="">Select</option>
                                    <option value="New">New</option>
                                    <option value="Used">Used</option>
                                    <option value="Re-thread">Re-thread</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold" style="font-size:12px;">Tyre Type <span class="text-danger">*</span></label>
                                <select class="form-select form-select-sm" name="new_tyre_type_direct" id="tamDirType">
                                    <option value="">Select</option>
                                    <option value="Radial">Radial</option>
                                    <option value="Nylon">Nylon</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold" style="font-size:12px;">Tyre Brand <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" name="new_tyre_brand_direct" id="tamDirBrand" placeholder="e.g. Apollo">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold" style="font-size:12px;">Tyre Serial Number <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" name="new_tyre_serial_direct" id="tamDirSerial" placeholder="Serial No.">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold" style="font-size:12px;">Replacement Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control form-control-sm" name="replacement_date_direct" id="tamDirDate">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold" style="font-size:12px;">KM at Replacement</label>
                                <div class="input-group input-group-sm">
                                    <input type="number" class="form-control" name="replacement_km_direct" id="tamDirKm" min="0" placeholder="0">
                                    <span class="input-group-text">KM</span>
                                </div>
                            </div>
                        </div>
                        <label class="form-label fw-semibold" style="font-size:12px; margin-bottom:4px;">Attachments</label>
                        <div class="tam-photo-grid">
                            <div class="tam-photo-slot">
                                <span class="tam-photo-slot-label">Serial No. Photo</span>
                                <input type="file" class="form-control form-control-sm" name="direct_serial_photo" id="tamDirPhotoSerial" accept="image/jpeg,image/png,image/webp">
                                <img class="tam-photo-thumb" id="tamDirThumbSerial" alt="Preview">
                            </div>
                            <div class="tam-photo-slot">
                                <span class="tam-photo-slot-label">Fitment Photo</span>
                                <input type="file" class="form-control form-control-sm" name="direct_fitment_photo" id="tamDirPhotoFitment" accept="image/jpeg,image/png,image/webp">
                                <img class="tam-photo-thumb" id="tamDirThumbFitment" alt="Preview">
                            </div>
                            <div class="tam-photo-slot">
                                <span class="tam-photo-slot-label">Odometer Photo</span>
                                <input type="file" class="form-control form-control-sm" name="direct_odometer_photo" id="tamDirPhotoOdo" accept="image/jpeg,image/png,image/webp">
                                <img class="tam-photo-thumb" id="tamDirThumbOdo" alt="Preview">
                            </div>
                        </div>
                    </div>

                    {{-- ── SOURCE PANEL: Same Vehicle Spare ── --}}
                    <div class="tam-src-panel" id="tamPanelSpare">
                        <div class="tam-section-title" style="margin-top:10px;">
                            <i class="uil uil-archive me-1"></i>Use On-Vehicle Spare Tyre
                        </div>
                        <div id="tamNoSpareAlert" class="tam-alert tam-alert-warning d-none">
                            <i class="uil uil-exclamation-triangle"></i>
                            <span>No spare tyres are available on this vehicle.</span>
                        </div>
                        <div class="row g-2 mb-2" id="tamSpareFieldsWrap">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold" style="font-size:12px;">Select Spare Tyre <span class="text-danger">*</span></label>
                                <select class="form-select form-select-sm" name="spare_tyre_mapping_id" id="tamSpareSelect">
                                    <option value="">— Select Spare Tyre —</option>
                                </select>
                                <span class="tam-field-error" id="tamErrSpareSelect"></span>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold" style="font-size:12px;">Replacement Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control form-control-sm" name="replacement_date_spare" id="tamSpareDate">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold" style="font-size:12px;">KM at Replacement</label>
                                <div class="input-group input-group-sm">
                                    <input type="number" class="form-control" name="replacement_km_spare" id="tamSpareKm" min="0" placeholder="0">
                                    <span class="input-group-text">KM</span>
                                </div>
                            </div>
                        </div>
                        <label class="form-label fw-semibold" style="font-size:12px; margin-bottom:4px;">Attachments</label>
                        <div class="tam-photo-grid">
                            <div class="tam-photo-slot">
                                <span class="tam-photo-slot-label">Serial No. Photo</span>
                                <input type="file" class="form-control form-control-sm" name="spare_serial_photo" id="tamSparePhotoSerial" accept="image/jpeg,image/png,image/webp">
                                <img class="tam-photo-thumb" id="tamSpareThumbSerial" alt="Preview">
                            </div>
                            <div class="tam-photo-slot">
                                <span class="tam-photo-slot-label">Fitment Photo</span>
                                <input type="file" class="form-control form-control-sm" name="spare_fitment_photo" id="tamSparePhotoFitment" accept="image/jpeg,image/png,image/webp">
                                <img class="tam-photo-thumb" id="tamSpareThumbFitment" alt="Preview">
                            </div>
                            <div class="tam-photo-slot">
                                <span class="tam-photo-slot-label">Odometer Photo</span>
                                <input type="file" class="form-control form-control-sm" name="spare_odometer_photo" id="tamSparePhotoOdo" accept="image/jpeg,image/png,image/webp">
                                <img class="tam-photo-thumb" id="tamSpareThumbOdo" alt="Preview">
                            </div>
                        </div>
                    </div>

                    {{-- ── SOURCE PANEL: Another Vehicle ── --}}
                    <div class="tam-src-panel" id="tamPanelOtherVehicle">
                        <div class="tam-section-title" style="margin-top:10px;">
                            <i class="uil uil-exchange me-1"></i>Transfer from Another Vehicle
                        </div>
                        <div class="tam-alert tam-alert-info">
                            <i class="uil uil-info-circle"></i>
                            <span>Only extra tyres (non-spare) from the donor vehicle can be selected. If the selected position is occupied, an alert will be shown.</span>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-md-5">
                                <label class="form-label fw-semibold" style="font-size:12px;">Vehicle Number (Donor) <span class="text-danger">*</span></label>
                                <div class="tam-vehicle-lookup">
                                    <input type="text" class="form-control form-control-sm" name="donor_vehicle_number" id="tamOtherVehicleNo" placeholder="e.g. MH12AB1234" maxlength="15">
                                    <button type="button" class="tam-btn-lookup" id="tamBtnLookupVehicle">
                                        <i class="uil uil-search me-1"></i>Lookup
                                    </button>
                                </div>
                                <span class="tam-field-error" id="tamErrOtherVehicle"></span>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold" style="font-size:12px;">Tyre Position <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" name="donor_position" id="tamOtherPosition" placeholder="e.g. D1, C1" maxlength="5">
                                <div class="tam-pos-note">
                                    <i class="uil uil-info-circle"></i>
                                    Enter position code
                                </div>
                                <span class="tam-field-error" id="tamErrOtherPosition"></span>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label fw-semibold" style="font-size:12px;">Replace Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control form-control-sm" name="replacement_date_other" id="tamOtherDate">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label fw-semibold" style="font-size:12px;">KM</label>
                                <div class="input-group input-group-sm">
                                    <input type="number" class="form-control" name="replacement_km_other" id="tamOtherKm" min="0" placeholder="0">
                                    <span class="input-group-text">KM</span>
                                </div>
                            </div>
                        </div>
                        {{-- Donor vehicle position alert --}}
                        <div class="tam-alert tam-alert-danger d-none" id="tamOtherPosAlert">
                            <i class="uil uil-exclamation-triangle"></i>
                            <span id="tamOtherPosAlertText">Selected position on donor vehicle is not empty.</span>
                        </div>
                        <label class="form-label fw-semibold" style="font-size:12px; margin-bottom:4px;">Attachments</label>
                        <div class="tam-photo-grid">
                            <div class="tam-photo-slot">
                                <span class="tam-photo-slot-label">Serial No. Photo</span>
                                <input type="file" class="form-control form-control-sm" name="other_serial_photo" id="tamOtherPhotoSerial" accept="image/jpeg,image/png,image/webp">
                                <img class="tam-photo-thumb" id="tamOtherThumbSerial" alt="Preview">
                            </div>
                            <div class="tam-photo-slot">
                                <span class="tam-photo-slot-label">Fitment Photo</span>
                                <input type="file" class="form-control form-control-sm" name="other_fitment_photo" id="tamOtherPhotoFitment" accept="image/jpeg,image/png,image/webp">
                                <img class="tam-photo-thumb" id="tamOtherThumbFitment" alt="Preview">
                            </div>
                            <div class="tam-photo-slot">
                                <span class="tam-photo-slot-label">Odometer Photo</span>
                                <input type="file" class="form-control form-control-sm" name="other_odometer_photo" id="tamOtherPhotoOdo" accept="image/jpeg,image/png,image/webp">
                                <img class="tam-photo-thumb" id="tamOtherThumbOdo" alt="Preview">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- SECTION 5: Old Tyre — What to do with the removed tyre --}}
                <div class="tam-src-panel active" id="tamOldTyreSection" style="display:none;">
                    <hr class="tam-hr">
                    <div class="tam-section">
                        <div class="tam-section-title">
                            <span class="tam-section-num">5</span>
                            Old Tyre Destination
                        </div>
                        <div class="row g-2">
                            <div class="col-12">
                                <label class="form-label fw-semibold" style="font-size:12px;">Where should the removed tyre go? <span class="text-danger">*</span></label>
                                <div class="tam-old-source-grid" id="tamOldSourceGrid">
                                    <label class="tam-old-source-pill" for="tamOldSrcGarage">
                                        <input type="radio" name="old_tyre_destination" id="tamOldSrcGarage" value="SR Garage" class="d-none">
                                        SR Garage
                                    </label>
                                    <label class="tam-old-source-pill" for="tamOldSrcVendor">
                                        <input type="radio" name="old_tyre_destination" id="tamOldSrcVendor" value="Tyre Vendor" class="d-none">
                                        Tyre Vendor
                                    </label>
                                    <label class="tam-old-source-pill" for="tamOldSrcOwnVehicle">
                                        <input type="radio" name="old_tyre_destination" id="tamOldSrcOwnVehicle" value="Own Vehicle" class="d-none">
                                        Own Vehicle (Spare)
                                    </label>
                                    <label class="tam-old-source-pill" for="tamOldSrcSpare">
                                        <input type="radio" name="old_tyre_destination" id="tamOldSrcSpare" value="Spare Tyre" class="d-none">
                                        Keep as Spare
                                    </label>
                                    <label class="tam-old-source-pill" for="tamOldSrcOtherVeh">
                                        <input type="radio" name="old_tyre_destination" id="tamOldSrcOtherVeh" value="Another Vehicle" class="d-none">
                                        Another Vehicle
                                    </label>
                                </div>
                                <span class="tam-field-error" id="tamErrOldDest"></span>
                                {{-- Own Vehicle over-limit alert --}}
                                <div class="tam-alert tam-alert-warning d-none mt-2" id="tamOwnVehicleOverLimitAlert">
                                    <i class="uil uil-exclamation-triangle"></i>
                                    <span>This vehicle already has the maximum number of spare tyres. Please choose a different destination.</span>
                                </div>
                                {{-- Another Vehicle destination: vehicle number input --}}
                                <div class="tam-conditional mt-2" id="tamOldOtherVehicleWrap">
                                    <label class="form-label fw-semibold" style="font-size:12px;">Destination Vehicle Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm" name="old_tyre_destination_vehicle" id="tamOldDestVehicleNo" placeholder="e.g. MH12AB5678" maxlength="15">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Old Tyre Action --}}
                    <div class="tam-section">
                        <div class="tam-section-title">
                            <span class="tam-section-num">6</span>
                            Old Tyre Action
                        </div>
                        <label class="form-label fw-semibold" style="font-size:12px;">What should be done with the old tyre? <span class="text-danger">*</span></label>
                        <div class="tam-old-action-grid" id="tamOldActionGrid">
                            <label class="tam-old-action-pill" for="tamActWarranty">
                                <input type="radio" name="old_tyre_action" id="tamActWarranty" value="Warranty Claim" class="d-none">
                                🔖 Warranty Claim
                            </label>
                            <label class="tam-old-action-pill" for="tamActRethread">
                                <input type="radio" name="old_tyre_action" id="tamActRethread" value="Re-thread" class="d-none">
                                🔄 Re-thread
                            </label>
                            <label class="tam-old-action-pill" for="tamActScrap">
                                <input type="radio" name="old_tyre_action" id="tamActScrap" value="Scrap" class="d-none">
                                🗑️ Scrap
                            </label>
                            <label class="tam-old-action-pill" for="tamActDecide">
                                <input type="radio" name="old_tyre_action" id="tamActDecide" value="Yet to Decide" class="d-none">
                                ⏳ Yet to Decide
                            </label>
                        </div>
                        <span class="tam-field-error" id="tamErrOldAction"></span>
                    </div>
                </div>

            </form>
          </div>{{-- /tamPaneReplace --}}

          {{-- ─────────────────────────────────────────────────────────────
               TAB 2: ROTATE TYRE
          ───────────────────────────────────────────────────────────────── --}}
          <div class="tam-tab-pane" id="tamPaneRotate">
            <form id="tamRotateForm" autocomplete="off" enctype="multipart/form-data">

                {{-- Tyre Life Alert for Weak Reason --}}
                <div class="tam-alert tam-alert-warning d-none" id="tamRotateWeakHealthAlert">
                    <i class="uil uil-exclamation-triangle"></i>
                    <strong>Healthy Tyre Alert:</strong>&nbsp;
                    <span id="tamRotateWeakHealthText">This tyre still has significant life remaining. Marking it as weak may indicate damage. Please verify before proceeding.</span>
                </div>

                {{-- SECTION 1: Rotation Reason --}}
                <div class="tam-section">
                    <div class="tam-section-title">
                        <span class="tam-section-num">1</span>
                        Rotation Reason
                    </div>
                    <div class="tam-reason-grid">
                        <label class="tam-reason-card" for="tamRotReasonScheduled">
                            <input type="radio" name="rotation_reason" id="tamRotReasonScheduled" value="Scheduled Maintenance Tyre Rotation" class="d-none">
                            <div class="tam-reason-icon"><i class="uil uil-calendar-alt"></i></div>
                            <div class="tam-reason-label">Scheduled Maintenance</div>
                        </label>
                        <label class="tam-reason-card" for="tamRotReasonWeak">
                            <input type="radio" name="rotation_reason" id="tamRotReasonWeak" value="Tyre Weak" class="d-none">
                            <div class="tam-reason-icon"><i class="uil uil-exclamation-triangle"></i></div>
                            <div class="tam-reason-label">Tyre Weak</div>
                        </label>
                    </div>
                    <span class="tam-field-error" id="tamErrRotReason"></span>

                    {{-- Scheduled: interval alert --}}
                    <div class="tam-alert tam-alert-warning d-none mt-2" id="tamRotIntervalAlert">
                        <i class="uil uil-clock"></i>
                        <span id="tamRotIntervalAlertText">Rotation interval has not been reached yet. Rotation is restricted for scheduled maintenance.</span>
                    </div>
                </div>

                {{-- SECTION 2: Rotation Details --}}
                <div class="tam-section">
                    <div class="tam-section-title">
                        <span class="tam-section-num">2</span>
                        Rotation Details
                    </div>
                    <div class="row g-2">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold" style="font-size:12px;">Rotation Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control form-control-sm" name="rotation_date" id="tamRotDate">
                            <span class="tam-field-error" id="tamErrRotDate"></span>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold" style="font-size:12px;">KM at Rotation <span class="text-danger">*</span></label>
                            <div class="input-group input-group-sm">
                                <input type="number" class="form-control" name="rotation_km" id="tamRotKm" min="0" placeholder="0">
                                <span class="input-group-text">KM</span>
                            </div>
                            <span class="tam-field-error" id="tamErrRotKm"></span>
                        </div>
                    </div>
                </div>

                {{-- SECTION 3: Tyre Mapping --}}
                <div class="tam-section">
                    <div class="tam-section-title">
                        <span class="tam-section-num">3</span>
                        Tyre Position Mapping
                        <span class="text-muted fw-normal ms-1" style="font-size:10px; text-transform:none; letter-spacing:0;">(From → To. Unmapped tyres go to spare)</span>
                    </div>
                    <div class="tam-mapping-wrap">
                        <div class="tam-mapping-header">
                            <span>From Position</span>
                            <span></span>
                            <span>To Position</span>
                            <span></span>
                        </div>
                        <div class="tam-mapping-rows" id="tamMappingRows">
                            <div class="tam-mapping-empty" id="tamMappingEmpty">
                                <i class="uil uil-info-circle me-1"></i>Click "Add Mapping" to define tyre rotation positions
                            </div>
                        </div>
                    </div>
                    <button type="button" class="tam-btn-add-row" id="tamBtnAddMapping">
                        <i class="uil uil-plus-circle me-1"></i>Add Mapping Row
                    </button>
                    <span class="tam-field-error" id="tamErrRotMapping"></span>
                </div>

                {{-- SECTION 4: Attachment --}}
                <div class="tam-section">
                    <div class="tam-section-title">
                        <span class="tam-section-num">4</span>
                        Rotation Invoice
                    </div>
                    <div class="tam-photo-grid" style="grid-template-columns: repeat(2, 1fr);">
                        <div class="tam-photo-slot">
                            <span class="tam-photo-slot-label">Rotation Invoice</span>
                            <input type="file" class="form-control form-control-sm" name="rotation_invoice" id="tamRotInvoice" accept="image/jpeg,image/png,image/webp,application/pdf">
                            <img class="tam-photo-thumb" id="tamRotInvoiceThumb" alt="Preview">
                        </div>
                    </div>
                </div>

            </form>
          </div>{{-- /tamPaneRotate --}}

          {{-- ─────────────────────────────────────────────────────────────
               TAB 3: ALIGNMENT
          ───────────────────────────────────────────────────────────────── --}}
          <div class="tam-tab-pane" id="tamPaneAlignment">
            <form id="tamAlignForm" autocomplete="off" enctype="multipart/form-data">
                <input type="hidden" id="tamAlnMappingId" name="mapping_id">

                {{-- Overdue alert (shown by JS if alignment is due) --}}
                <div class="tam-alert tam-alert-danger d-none" id="tamAlnOverdueAlert">
                    <i class="uil uil-exclamation-triangle"></i>
                    <strong>Alignment Overdue!</strong>&nbsp;
                    <span id="tamAlnOverdueText">Alignment was due. Please proceed immediately.</span>
                </div>

                {{-- Early override alert --}}
                <div class="tam-alert tam-alert-warning d-none" id="tamAlnEarlyAlert">
                    <i class="uil uil-clock"></i>
                    <span>Alignment interval has not been reached yet. Proceeding early may affect tyre health warranty.</span>
                </div>

                {{-- SECTION 1: Alignment Details --}}
                <div class="tam-section">
                    <div class="tam-section-title">
                        <span class="tam-section-num">1</span>
                        Alignment Details
                    </div>
                    <div class="row g-2">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold" style="font-size:12px;">Alignment Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control form-control-sm" name="alignment_date" id="tamAlnDate">
                            <span class="tam-field-error" id="tamErrAlnDate"></span>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold" style="font-size:12px;">KM at Alignment (Odometer) <span class="text-danger">*</span></label>
                            <div class="input-group input-group-sm">
                                <input type="number" class="form-control" name="alignment_km" id="tamAlnKm" min="0" placeholder="0">
                                <span class="input-group-text">KM</span>
                            </div>
                            <span class="tam-field-error" id="tamErrAlnKm"></span>
                        </div>
                    </div>
                </div>

                {{-- SECTION 2: Attachment --}}
                <div class="tam-section">
                    <div class="tam-section-title">
                        <span class="tam-section-num">2</span>
                        Alignment Invoice
                    </div>
                    <div class="tam-photo-grid" style="grid-template-columns: repeat(2, 1fr);">
                        <div class="tam-photo-slot">
                            <span class="tam-photo-slot-label">Alignment Invoice / Receipt</span>
                            <input type="file" class="form-control form-control-sm" name="alignment_invoice" id="tamAlnInvoice" accept="image/jpeg,image/png,image/webp,application/pdf">
                            <img class="tam-photo-thumb" id="tamAlnInvoiceThumb" alt="Preview">
                        </div>
                    </div>
                </div>

                {{-- SECTION 3: History --}}
                <div class="tam-section" id="tamAlnHistoryWrap">
                    <div class="tam-section-title">
                        <span class="tam-section-num">3</span>
                        Alignment History
                    </div>
                    <div class="tam-history-wrap">
                        <div class="tam-history-title">Past Alignment Records</div>
                        <div id="tamAlnHistoryRows">
                            <div class="tam-history-row">
                                <span class="tam-history-date text-muted" style="font-style:italic;">No alignment history recorded for this tyre.</span>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
          </div>{{-- /tamPaneAlignment --}}

      </div>{{-- /modal-body --}}

      {{-- Modal Footer --}}
      <div class="modal-footer py-2 px-3">
          <span class="tam-footer-info text-muted" id="tamFooterInfo" style="font-size:11px;">
              <i class="uil uil-info-circle me-1"></i>Select a tab and fill the required fields to proceed.
          </span>
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
              <i class="uil uil-times me-1"></i>Cancel
          </button>
          <button type="button" class="btn btn-primary btn-sm" id="tamSubmitBtn">
              <i class="uil uil-check me-1"></i><span id="tamSubmitLabel">Submit</span>
          </button>
      </div>

    </div>{{-- /modal-content --}}
  </div>{{-- /modal-dialog --}}
</div>{{-- /takeActionModal --}}

@endsection

@section('js')
<script type="text/javascript" src="{{ asset('arobittyre_management/fleet-tyre.js') }}"></script>
<script type="text/javascript" src="{{ asset('customjs/tyremanagement/vehicletyretagging-v2.js') }}?v={{ time() }}"></script>
@endsection
