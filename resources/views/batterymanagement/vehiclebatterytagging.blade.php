@extends('layouts.app')

@section('css')
    <link href="{{ asset('css/Battery/battery-tagging.css?v=2.3') }}" rel="stylesheet">
@endsection

@section('content')
<div class="layout-wrapper">

    @include('includes.header')

    <div class="vehicledtl-bd srlog-bdwrapper">

        {{-- ── TOP BAR ──────────────────────────────────────────────────── --}}
        <div class="topbar-bd">
            <div class="item1">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <div class="col-12 col-md-6">
                            <h1><i class="uil uil-battery-bolt me-2 text-primary"></i>Battery Management</h1>
                        </div>
                        <div class="col-12 col-md-6 text-end">
                            <span class="badge bg-light text-dark border me-2">
                                <i class="uil uil-truck me-1"></i>{{ $vehicle->vehicle_registration_number ?? 'Vehicle #'.$vehicle->vehicle_no }}
                            </span>
                            <a href="{{ route('fleetdashboard.getVehicleDetailsV2', $vehicle->id) }}"
                               class="btn btn-sm btn-outline-secondary">
                                <i class="uil uil-arrow-left me-1"></i>Back
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── MAIN CONTENT ─────────────────────────────────────────────── --}}
        <div class="container-fluid pt-3 pb-5">

            @php
                $activeBatteries = $vehicle->vehiclebatteries->where('status', 'Active')->values();
                $activeCount     = $activeBatteries->count();
                $slotsUsed       = $activeCount;
                $slotsTotal      = 2;

                // RAG colours for SVG B1 / B2 indicators
                $ragColourMap = ['Green' => '#22c55e', 'Yellow' => '#f59e0b', 'Red' => '#ef4444'];
                $ragStrokeMap = ['Green' => '#16a34a', 'Yellow' => '#d97706', 'Red' => '#b91c1c'];
                $b1 = $activeBatteries->get(0);
                $b2 = $activeBatteries->get(1);
                $b1Fill   = isset($b1) ? ($ragColourMap[$b1->rag_status]  ?? '#94a3b8') : '#94a3b8';
                $b1Stroke = isset($b1) ? ($ragStrokeMap[$b1->rag_status]  ?? '#64748b') : '#64748b';
                $b2Fill   = isset($b2) ? ($ragColourMap[$b2->rag_status]  ?? '#94a3b8') : '#94a3b8';
                $b2Stroke = isset($b2) ? ($ragStrokeMap[$b2->rag_status]  ?? '#64748b') : '#64748b';
            @endphp

            <div class="row gx-3">

            {{-- ── LEFT: Truck SVG Panel ─────────────────────────────────── --}}
            <div class="col-12 col-md-3">
                <div class="card vbt-svg-panel">
                    <div class="vbt-svg-panel-header">
                        <i class="uil uil-truck me-1"></i>
                        <span>Battery Layout</span>
                    </div>
                    <div class="vbt-svg-container">
                        @include('svg.battery-truck', [
                            'b1Fill'   => $b1Fill,
                            'b1Stroke' => $b1Stroke,
                            'b2Fill'   => $b2Fill,
                            'b2Stroke' => $b2Stroke,
                            'svgClass' => 'bat-truck-svg w-100',
                        ])
                    </div>
                    {{-- RAG legend --}}
                    <div class="vbt-rag-legend">
                        <div class="vbt-rag-legend-item"><span class="vbt-rag-dot" style="background:#22c55e;"></span><span>Green — Good</span></div>
                        <div class="vbt-rag-legend-item"><span class="vbt-rag-dot" style="background:#f59e0b;"></span><span>Yellow — Monitor</span></div>
                        <div class="vbt-rag-legend-item"><span class="vbt-rag-dot" style="background:#ef4444;"></span><span>Red — Critical</span></div>
                        <div class="vbt-rag-legend-item"><span class="vbt-rag-dot" style="background:#94a3b8;"></span><span>Grey — Untagged</span></div>
                    </div>
                    {{-- Battery slot status --}}
                    <div class="vbt-slot-status">
                        <span class="vbt-slot-pill {{ isset($b1) ? 'active' : 'empty' }}">
                            B1 — {{ isset($b1) ? ($b1->battery_serial_number ?? 'Tagged') : 'Empty' }}
                        </span>
                        <span class="vbt-slot-pill {{ isset($b2) ? 'active' : 'empty' }}">
                            B2 — {{ isset($b2) ? ($b2->battery_serial_number ?? 'Tagged') : 'Empty' }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- ── RIGHT: Battery cards ─────────────────────────────────────── --}}
            <div class="col-12 col-md-9">

            {{-- Max-limit notice --}}
            @if($activeCount >= 2)
            <div class="vbt-max-notice">
                <i class="uil uil-info-circle fs-5"></i>
                <span>Maximum of <strong>2 batteries</strong> are already tagged to this vehicle. Remove one to add a new battery.</span>
            </div>
            @endif

            {{-- ── TAGGED BATTERIES ──────────────────────────────────────── --}}
            <div class="vbt-section-label">
                <i class="uil uil-battery-bolt"></i>Tagged Batteries
                <span class="badge bg-secondary ms-2" style="font-size:10px;">{{ $activeCount }} / {{ $slotsTotal }}</span>
            </div>

            @forelse($activeBatteries as $index => $battery)
                @php
                    $rag          = strtolower($battery->rag_status ?? 'grey');
                    $lifePct      = $battery->life_remaining_pct;
                    $batteryLabel = 'Battery ' . ($index + 1);
                @endphp

                <div class="vbt-card vbt-rag-border-{{ $rag }} mb-3">

                    {{-- Card Header --}}
                    <div class="vbt-card-header">
                        <div class="d-flex align-items-center gap-2 flex-wrap">
                            <span class="vbt-battery-number">{{ $batteryLabel }}</span>
                            <span class="vbt-rag-badge vbt-rag-{{ $rag }}">
                                @if($rag === 'green')  🟢 Green
                                @elseif($rag === 'yellow') 🟡 Yellow
                                @elseif($rag === 'red')   🔴 Red
                                @else ⚫ Not Set
                                @endif
                            </span>

                            <div class="ms-auto d-flex align-items-center gap-2 flex-wrap">
                                {{-- Life bar --}}
                                @if($lifePct !== null)
                                <div class="vbt-life-bar-wrap">
                                    <div class="vbt-life-bar-track">
                                        <div class="vbt-life-bar-fill vbt-rag-bg-{{ $rag }}" style="width: {{ $lifePct }}%"></div>
                                    </div>
                                    <span class="vbt-life-pct-label">{{ $lifePct }}% Life</span>
                                </div>
                                @endif

                                {{-- Attachment button --}}
                                @if($battery->medias && $battery->medias->count())
                                <button type="button" class="btn-vbt-attach-icon"
                                        data-bs-toggle="modal"
                                        data-bs-target="#attachModal-{{ $battery->id }}"
                                        title="{{ $battery->medias->count() }} Attachment(s)">
                                    <i class="uil uil-paperclip"></i>
                                    <span class="vbt-attach-count-badge">{{ $battery->medias->count() }}</span>
                                </button>
                                @endif

                                <div class="vbt-header-action-divider"></div>

                                {{-- View logs button --}}
                                <button type="button"
                                        class="btn-vbt-logs btn-vbt-view-logs"
                                        data-logs-url="{{ route('batterymanage.vehicle.battery.logs', [$vehicle->id, $battery->id]) }}"
                                        data-serial="{{ $battery->battery_serial_number ?? 'Battery '.$battery->id }}">
                                    <i class="uil uil-history me-1"></i>History
                                </button>

                                {{-- Remove button --}}
                                <button type="button"
                                        class="btn-vbt-remove btn-vbt-remove-confirm"
                                        data-battery-id="{{ $battery->id }}"
                                        data-vehicle-id="{{ $vehicle->id }}"
                                        data-serial="{{ $battery->battery_serial_number ?? '' }}"
                                        data-remove-url="{{ route('batterymanage.vehicle.battery.tag.remove', [$vehicle->id, $battery->id]) }}">
                                    <i class="uil uil-times-circle me-1"></i>Remove
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Card Body --}}
                    <div class="vbt-card-body">

                        {{-- Section 1: Identity --}}
                        <div class="vbt-info-section">
                            <div class="vbt-info-section-title">
                                <i class="uil uil-info-circle"></i> Battery Details
                            </div>
                            <div class="vbt-info-grid">
                                <div class="vbt-info-item">
                                    <span class="vbt-info-label">Serial Number</span>
                                    <span class="vbt-info-value">{{ $battery->battery_serial_number ?? '—' }}</span>
                                </div>
                                <div class="vbt-info-item">
                                    <span class="vbt-info-label">Brand</span>
                                    <span class="vbt-info-value">{{ $battery->battery_brand ?? '—' }}</span>
                                </div>
                                <div class="vbt-info-item">
                                    <span class="vbt-info-label">Model</span>
                                    <span class="vbt-info-value">{{ $battery->battery_model ?? $battery->battery_model_name ?? '—' }}</span>
                                </div>
                                <div class="vbt-info-item">
                                    <span class="vbt-info-label">Capacity</span>
                                    <span class="vbt-info-value">{{ $battery->battery_capacity ? $battery->battery_capacity.' Ah' : '—' }}</span>
                                </div>
                                <div class="vbt-info-item">
                                    <span class="vbt-info-label">Voltage</span>
                                    <span class="vbt-info-value">{{ $battery->battery_voltage ?? '—' }}</span>
                                </div>
                                <div class="vbt-info-item">
                                    <span class="vbt-info-label">Condition</span>
                                    <span class="vbt-info-value">
                                        @php
                                            $condKey = strtolower(str_replace([' ', '-', "'", '/'], '', $battery->battery_condition ?? ''));
                                        @endphp
                                        <span class="vbt-cond-badge vbt-cond-{{ $condKey }}">
                                            {{ $battery->battery_condition ?? '—' }}
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Section 2: Purchase & Warranty --}}
                        <div class="vbt-info-section">
                            <div class="vbt-info-section-title">
                                <i class="uil uil-receipt"></i> Purchase & Warranty
                            </div>
                            <div class="vbt-info-grid">
                                <div class="vbt-info-item">
                                    <span class="vbt-info-label">Price</span>
                                    <span class="vbt-info-value">
                                        ₹{{ $battery->battery_price ? number_format($battery->battery_price, 2) : '—' }}
                                    </span>
                                </div>
                                <div class="vbt-info-item">
                                    <span class="vbt-info-label">Purchase Date</span>
                                    <span class="vbt-info-value">
                                        {{ $battery->purchase_date ? \Carbon\Carbon::parse($battery->purchase_date)->format('d M Y') : '—' }}
                                    </span>
                                </div>
                                <div class="vbt-info-item">
                                    <span class="vbt-info-label">Warranty Period</span>
                                    <span class="vbt-info-value">{{ $battery->warranty_months ? $battery->warranty_months.' Months' : '—' }}</span>
                                </div>
                                <div class="vbt-info-item">
                                    <span class="vbt-info-label">Warranty Remaining</span>
                                    <span class="vbt-info-value @if(($battery->warranty_remaining_months ?? 99) <= 2) text-danger fw-semibold @endif">
                                        {{ $battery->warranty_remaining_months !== null ? $battery->warranty_remaining_months.' Mo' : '—' }}
                                    </span>
                                </div>
                                <div class="vbt-info-item">
                                    <span class="vbt-info-label">Fitment Date</span>
                                    <span class="vbt-info-value">
                                        {{ $battery->fitment_date ? \Carbon\Carbon::parse($battery->fitment_date)->format('d M Y') : '—' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Section 3: Performance (KM) + Lifecycle (Months) side-by-side --}}
                        <div class="vbt-info-section-pair">

                            <div class="vbt-info-section">
                                <div class="vbt-info-section-title">
                                    <i class="uil uil-tachometer-fast"></i> Performance (KM)
                                </div>
                                <div class="vbt-info-grid">
                                    <div class="vbt-info-item">
                                        <span class="vbt-info-label">Actual KM</span>
                                        <span class="vbt-info-value">
                                            {{ $battery->battery_actual_km ? number_format($battery->battery_actual_km).' KM' : '—' }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="vbt-info-section">
                                <div class="vbt-info-section-title">
                                    <i class="uil uil-calendar-alt"></i> Lifecycle (Months)
                                </div>
                                <div class="vbt-info-grid">
                                    <div class="vbt-info-item">
                                        <span class="vbt-info-label">Life Fixed</span>
                                        <span class="vbt-info-value">{{ $battery->battery_life_fixed ? $battery->battery_life_fixed.' Mo' : '—' }}</span>
                                    </div>
                                    <div class="vbt-info-item">
                                        <span class="vbt-info-label">Actual Run</span>
                                        <span class="vbt-info-value">{{ $battery->battery_actual_run_months ? $battery->battery_actual_run_months.' Mo' : '—' }}</span>
                                    </div>
                                    <div class="vbt-info-item">
                                        <span class="vbt-info-label">Life Remaining</span>
                                        <span class="vbt-info-value @if(($battery->life_remaining_months ?? 99) <= 2) text-danger fw-semibold @endif">
                                            {{ $battery->life_remaining_months !== null ? $battery->life_remaining_months.' Mo' : '—' }}
                                        </span>
                                    </div>
                                    <div class="vbt-info-item">
                                        <span class="vbt-info-label">Life Remaining %</span>
                                        <span class="vbt-info-value @if(($battery->life_remaining_pct ?? 100) < 20) text-danger fw-semibold @endif">
                                            {{ $battery->life_remaining_pct !== null ? $battery->life_remaining_pct.'%' : '—' }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                        </div>{{-- /pair --}}

                    </div>{{-- /vbt-card-body --}}
                </div>{{-- /vbt-card --}}

                {{-- Attachment modal for this battery --}}
                @if($battery->medias && $battery->medias->count())
                <div class="modal fade" id="attachModal-{{ $battery->id }}" tabindex="-1"
                     aria-labelledby="attachLabel-{{ $battery->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" style="max-width:420px;">
                        <div class="modal-content">
                            <div class="modal-header py-2 px-3">
                                <h6 class="modal-title fw-bold mb-0" id="attachLabel-{{ $battery->id }}">
                                    <i class="uil uil-paperclip me-1 text-primary"></i>
                                    Attachments
                                    <span class="badge bg-secondary ms-1" style="font-size:10px;">{{ $battery->medias->count() }}</span>
                                    <span class="text-muted fw-normal ms-1" style="font-size:11px;">— {{ $battery->battery_serial_number ?? $batteryLabel }}</span>
                                </h6>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body p-2">
                                <div style="max-height:320px; overflow-y:auto;">
                                    @foreach($battery->medias as $media)
                                    <div class="vbt-attachment-item">
                                        @if($media->type === 'Image')
                                            <i class="uil uil-image vbt-attachment-icon vbt-img-icon"></i>
                                        @else
                                            <i class="uil uil-file-alt vbt-attachment-icon vbt-doc-icon"></i>
                                        @endif
                                        <div class="vbt-attachment-meta">
                                            <span class="vbt-attachment-name">{{ $media->file_name ?? 'Attachment' }}</span>
                                            <span class="vbt-attachment-date">
                                                {{ $media->created_at ? \Carbon\Carbon::parse($media->created_at)->format('d M Y, h:i A') : '' }}
                                            </span>
                                        </div>
                                        <a href="{{ asset('medias/'.$media->file_path) }}" target="_blank"
                                           class="btn-vbt-view-attach" title="View">
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
                {{-- No batteries tagged yet — show empty state via slot cards below --}}
            @endforelse

            {{-- ── EMPTY SLOTS (up to 2 batteries allowed) ───────────────── --}}
            @for($slot = $slotsUsed + 1; $slot <= $slotsTotal; $slot++)
            <div class="vbt-slot-card">
                <div class="vbt-slot-icon"><i class="uil uil-battery-bolt"></i></div>
                <p class="vbt-slot-label">Battery Slot {{ $slot }} — Empty</p>
                @if($activeCount < 2)
                <button type="button"
                        class="btn-vbt-add"
                        data-bs-toggle="modal"
                        data-bs-target="#tagBatteryModal">
                    <i class="uil uil-plus-circle"></i>Tag Battery
                </button>
                @endif
            </div>
            @endfor

            {{-- Always show "Add Battery" button when < 2 batteries --}}
            @if($activeCount < 2)
            <div class="mb-4">
                <button type="button"
                        class="btn-vbt-add"
                        data-bs-toggle="modal"
                        data-bs-target="#tagBatteryModal">
                    <i class="uil uil-plus-circle"></i>Tag New Battery
                </button>
            </div>
            @endif

            </div>{{-- /col-md-9 right --}}
            </div>{{-- /row --}}

        </div>{{-- /container-fluid --}}
    </div>{{-- /srlog-bdwrapper --}}
</div>{{-- /layout-wrapper --}}

{{-- ══════════════════════════════════════════════════════════════
     TAG BATTERY MODAL
════════════════════════════════════════════════════════════════ --}}
<div class="modal fade" id="tagBatteryModal" tabindex="-1"
     aria-labelledby="tagBatteryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tagBatteryModalLabel">
                    <i class="uil uil-battery-bolt me-1 text-primary"></i>
                    Tag Battery — {{ $vehicle->vehicle_registration_number ?? 'Vehicle #'.$vehicle->vehicle_no }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form id="tagBatteryForm"
                      action="{{ route('batterymanage.vehicle.battery.tag.store', $vehicle->id) }}"
                      method="POST"
                      enctype="multipart/form-data"
                      data-available-url="{{ route('batterymanage.batteries.available') }}">
                @csrf

                    {{-- ── SECTION: Battery Source ─────────────────────────── --}}
                    <div class="vbt-modal-section-title">
                        <i class="uil uil-archive"></i> Battery Source
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Battery Source <span class="text-danger">*</span></label>
                        <div class="d-flex gap-2 flex-wrap" id="batterySourceBtns">
                            <input type="radio" class="btn-check" name="battery_source"
                                   id="srcSRWarehouse" value="SR Warehouse" checked>
                            <label class="btn btn-outline-primary btn-sm px-3" for="srcSRWarehouse">
                                <i class="uil uil-archive me-1"></i>SR Warehouse
                            </label>
                            <input type="radio" class="btn-check" name="battery_source"
                                   id="srcDirectFitment" value="Direct Fitment">
                            <label class="btn btn-outline-secondary btn-sm px-3" for="srcDirectFitment">
                                <i class="uil uil-truck me-1"></i>Direct Fitment
                            </label>
                        </div>
                        <span class="text-danger small d-block mt-1 field-error" id="err_battery_source"></span>
                    </div>

                    {{-- ── SECTION: Battery Condition (common) ─────────────── --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Battery Condition <span class="text-danger">*</span></label>
                        <select name="battery_condition" id="batteryConditionSelect" class="form-select form-select-sm">
                            <option value="">— Select Condition —</option>
                            <option value="New">New</option>
                            <option value="Used">Used</option>
                            <option value="Replaced Under Warranty">Replaced Under Warranty</option>
                        </select>
                        <span class="text-danger small d-block mt-1 field-error" id="err_battery_condition"></span>
                    </div>

                    {{-- ══════════════════════════════════════════════════════
                         SR WAREHOUSE SECTION
                    ════════════════════════════════════════════════════════ --}}
                    <div id="srcWarehouseSection">
                        <div class="vbt-modal-section-title mt-1">
                            <i class="uil uil-archive"></i> Select from Warehouse
                        </div>
                        <div class="mb-2">
                            <label class="form-label fw-semibold small">
                                Select Battery from Warehouse <span class="text-danger">*</span>
                            </label>
                            <div id="batteryDropdownState" class="text-muted small mb-1">
                                Select a Battery Condition above to load available stock.
                            </div>
                            <select name="warehouse_battery_id" id="warehouseBatterySelect"
                                    class="form-select form-select-sm" disabled>
                                <option value="">— Select condition first —</option>
                            </select>
                            <span class="text-danger small d-block mt-1 field-error" id="err_warehouse_battery_id"></span>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold small text-muted">
                                    Battery Brand
                                    <span class="badge bg-light text-secondary border ms-1" style="font-size:10px;">Auto-filled</span>
                                </label>
                                <input type="text" class="form-control form-control-sm bg-light"
                                       id="wh_batteryBrand" readonly placeholder="Auto-filled on selection">
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold small text-muted">
                                    Battery Serial Number
                                    <span class="badge bg-light text-secondary border ms-1" style="font-size:10px;">Auto-filled</span>
                                </label>
                                <input type="text" class="form-control form-control-sm bg-light"
                                       id="wh_batterySerial" readonly placeholder="Auto-filled on selection">
                            </div>
                        </div>
                    </div>

                    {{-- ══════════════════════════════════════════════════════
                         DIRECT FITMENT SECTION
                    ════════════════════════════════════════════════════════ --}}
                    <div id="srcDirectSection" class="d-none">
                        <div class="vbt-modal-section-title mt-1">
                            <i class="uil uil-truck"></i> Battery Details
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold small">Battery Brand <span class="text-danger">*</span></label>
                                <input type="text" name="battery_brand" id="directBatteryBrand"
                                       class="form-control form-control-sm"
                                       placeholder="e.g. Exide, Amara Raja" maxlength="100">
                                <span class="text-danger small d-block mt-1 field-error" id="err_battery_brand"></span>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold small">Battery Serial Number <span class="text-danger">*</span></label>
                                <input type="text" name="battery_serial_number" id="directBatterySerial"
                                       class="form-control form-control-sm"
                                       placeholder="e.g. BT-2024-0001" maxlength="100">
                                <span class="text-danger small d-block mt-1 field-error" id="err_battery_serial_number"></span>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold small">Battery Model</label>
                                <input type="text" name="battery_model" class="form-control form-control-sm"
                                       placeholder="e.g. FEO-TBTZ0" maxlength="100">
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold small">Battery Capacity (Ah)</label>
                                <input type="text" name="battery_capacity" class="form-control form-control-sm"
                                       placeholder="e.g. 88" maxlength="50">
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold small">Battery Voltage</label>
                                <select name="battery_voltage" class="form-select form-select-sm">
                                    <option value="">— Select Voltage —</option>
                                    <option value="6V">6V</option>
                                    <option value="12V" selected>12V</option>
                                    <option value="24V">24V</option>
                                    <option value="48V">48V</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold small">Purchase Date</label>
                                <input type="date" name="purchase_date" class="form-control form-control-sm">
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold small">Warranty Period (Months)</label>
                                <input type="number" name="warranty_months" class="form-control form-control-sm"
                                       min="0" placeholder="e.g. 12">
                            </div>
                        </div>
                    </div>

                    {{-- ── SECTION: Fitment Info (common) ─────────────────── --}}
                    <div class="vbt-modal-section-title mt-2">
                        <i class="uil uil-tachometer-fast"></i> Fitment Details
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold small">Fitment Date <span class="text-danger">*</span></label>
                            <input type="date" name="fitment_date" id="fitmentDateInput"
                                   class="form-control form-control-sm">
                            <span class="text-danger small d-block mt-1 field-error" id="err_fitment_date"></span>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold small">KM at Fitment</label>
                            <div class="input-group input-group-sm">
                                <input type="number" name="km_at_fitment" id="kmAtFitmentInput"
                                       class="form-control form-control-sm" min="0" placeholder="0">
                                <span class="input-group-text">KM</span>
                            </div>
                            <span class="text-danger small d-block mt-1 field-error" id="err_km_at_fitment"></span>
                        </div>
                    </div>

                    {{-- ── SECTION: Attachments ────────────────────────────── --}}
                    <div class="vbt-modal-section-title mt-2">
                        <i class="uil uil-paperclip"></i> Attachments
                        <span class="text-muted fw-normal small ms-1">(JPG / PNG / WEBP · max 5 MB each)</span>
                    </div>
                    <div class="row g-2">
                        <div class="col-12 col-md-4">
                            <label class="form-label small text-muted mb-1">Battery Serial Number Photo</label>
                            <input type="file" class="form-control form-control-sm" name="photo_serial"
                                   id="photoSerial" accept="image/jpeg,image/png,image/webp">
                            <div id="previewSerial" class="mt-1 d-none">
                                <img class="vbt-at-thumb" alt="Serial preview">
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="form-label small text-muted mb-1">Battery on Truck Fitment Photo</label>
                            <input type="file" class="form-control form-control-sm" name="photo_fitment"
                                   id="photoFitment" accept="image/jpeg,image/png,image/webp">
                            <div id="previewFitment" class="mt-1 d-none">
                                <img class="vbt-at-thumb" alt="Fitment preview">
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="form-label small text-muted mb-1">Odometer Photo</label>
                            <input type="file" class="form-control form-control-sm" name="photo_odometer"
                                   id="photoOdometer" accept="image/jpeg,image/png,image/webp">
                            <div id="previewOdometer" class="mt-1 d-none">
                                <img class="vbt-at-thumb" alt="Odometer preview">
                            </div>
                        </div>
                    </div>

                </form>
            </div>{{-- /modal-body --}}

            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="tagBatteryForm" id="btnTagBattery" class="btn btn-sm btn-primary">
                    <span id="btnTagBatteryText"><i class="uil uil-battery-bolt me-1"></i>Tag Battery</span>
                    <span id="btnTagBatterySpinner" class="spinner-border spinner-border-sm d-none ms-1" role="status"></span>
                </button>
            </div>

        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════════════
     BATTERY LOGS MODAL
════════════════════════════════════════════════════════════════ --}}
<div class="modal fade" id="batteryLogsModal" tabindex="-1"
     aria-labelledby="batteryLogsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width:480px;">
        <div class="modal-content">
            <div class="modal-header py-2 px-3">
                <h6 class="modal-title fw-bold mb-0" id="batteryLogsModalLabel">
                    <i class="uil uil-history me-1 text-primary"></i>
                    <span id="batteryLogsTitle">Log History</span>
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-3" style="max-height:420px; overflow-y:auto;">
                <div id="batteryLogsBody">
                    <div class="text-center py-4 text-muted">
                        <div class="spinner-border spinner-border-sm"></div> Loading…
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script src="{{ asset('js/Battery/battery-tagging.js?v=2.3') }}"></script>
@endsection
