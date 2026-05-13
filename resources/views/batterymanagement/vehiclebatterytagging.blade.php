@extends('layouts.app')

@section('css')
    <link href="{{ asset('css/Battery/battery-tagging.css?v=2.9') }}" rel="stylesheet">
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

                                {{-- History button — commented out
                                <button type="button"
                                        class="btn-vbt-logs btn-vbt-view-logs"
                                        data-logs-url="{{ route('batterymanage.vehicle.battery.logs', [$vehicle->id, $battery->id]) }}"
                                        data-serial="{{ $battery->battery_serial_number ?? 'Battery '.$battery->id }}">
                                    <i class="uil uil-history me-1"></i>History
                                </button>
                                --}}

                                {{-- Take Action button --}}
                                <button type="button"
                                        class="btn-vbt-take-action"
                                        data-bs-toggle="modal"
                                        data-bs-target="#batteryTakeActionModal"
                                        data-battery-id="{{ $battery->id }}"
                                        data-vehicle-id="{{ $vehicle->id }}"
                                        data-slot="{{ $batteryLabel }}"
                                        data-serial="{{ $battery->battery_serial_number ?? '' }}"
                                        data-brand="{{ $battery->battery_brand ?? '' }}"
                                        data-rag="{{ $rag }}"
                                        data-life-pct="{{ $battery->life_remaining_pct ?? '' }}"
                                        data-actual-km="{{ $battery->battery_actual_km ?? '' }}"
                                        data-available-url="{{ route('batterymanage.batteries.available') }}"
                                        data-replace-url="{{ route('batterymanage.vehicle.battery.tag.replace', [$vehicle->id, $battery->id]) }}">
                                    <i class="uil uil-setting me-1"></i>Take Action
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
                                <div class="vbt-attachment-log">
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

{{-- ══════════════════════════════════════════════════════════════
     TAKE ACTION MODAL — Replace Battery
════════════════════════════════════════════════════════════════ --}}
<div class="modal fade" id="batteryTakeActionModal" tabindex="-1"
     aria-labelledby="batteryTakeActionModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
    <div class="modal-content">

      {{-- Modal Header --}}
      <div class="modal-header py-2 px-3" style="border-bottom:1px solid #e9ecef;">
        <div style="flex:1; min-width:0;">
            <h6 class="modal-title fw-bold mb-0" id="batteryTakeActionModalLabel">
                <i class="uil uil-setting me-1 text-primary"></i>Take Action — Replace Battery
            </h6>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      {{-- Modal Body --}}
      <div class="modal-body" style="padding:14px 18px;">

          {{-- Battery Info Bar --}}
          <div class="bam-header-info">
              <span class="bam-slot-label" id="bamSlotLabel">—</span>
              <div class="bam-battery-detail">
                  <span class="bam-battery-serial-text" id="bamSerialText">—</span>
                  <span class="bam-battery-brand-text"  id="bamBrandText"></span>
              </div>
              <span class="bam-rag-mini rag-grey" id="bamRagBadge">⚫ Not Set</span>
              <span class="text-white ms-auto" id="bamLifeText" style="font-size:11px; opacity:0.8;"></span>
          </div>

          {{-- Replace Battery Form --}}
          <form id="bamReplaceForm" autocomplete="off" enctype="multipart/form-data">
              @csrf
              <input type="hidden" id="bamBatteryId"   name="battery_id">
              <input type="hidden" id="bamVehicleIdHid" name="vehicle_id">

              {{-- SECTION 1: Replacement Reason --}}
              <div class="bam-section">
                  <div class="bam-section-title">
                      <span class="bam-section-num">1</span>
                      Replacement Reason
                  </div>
                  <div class="row g-2">
                      <div class="col-md-6">
                          <label class="form-label fw-semibold" style="font-size:12px;">
                              Reason for Replacement <span class="text-danger">*</span>
                          </label>
                          <select class="form-select form-select-sm" id="bamRplReason" name="replacement_reason">
                              <option value="">— Select Reason —</option>
                              <option value="Battery Dead">Battery Dead</option>
                              <option value="Battery Damaged">Battery Damaged</option>
                              <option value="Performance Drop">Performance Drop</option>
                              <option value="Life Expired">Life Expired</option>
                              <option value="Warranty Claim">Warranty Claim</option>
                              <option value="Other">Other</option>
                          </select>
                          <span class="bam-field-error" id="bamErrReason"></span>
                      </div>
                  </div>
              </div>


              {{-- SECTION 2: Battery Condition --}}
              <div class="bam-section">
                  <div class="bam-section-title">
                      <span class="bam-section-num">2</span>
                      New Battery Condition
                  </div>
                  <div class="row g-2">
                      <div class="col-md-6">
                          <label class="form-label fw-semibold" style="font-size:12px;">
                              Battery Condition <span class="text-danger">*</span>
                          </label>
                          <select class="form-select form-select-sm" id="bamConditionSelect" name="battery_condition">
                              <option value="">— Select Condition —</option>
                              <option value="New">New</option>
                              <option value="Used">Used</option>
                              <option value="Replaced Under Warranty">Replaced Under Warranty</option>
                          </select>
                          <span class="bam-field-error" id="bamErrCondition"></span>
                      </div>
                  </div>
              </div>

              {{-- SECTION 3: Replacement Battery Source --}}
              <div class="bam-section">
                  <div class="bam-section-title">
                      <span class="bam-section-num">3</span>
                      Replacement Battery Source
                  </div>

                  <div class="bam-source-grid" id="bamSourceGrid">
                      <label class="bam-source-card" for="bamSrcWarehouse">
                          <input type="radio" name="battery_source" id="bamSrcWarehouse"
                                 value="SR Warehouse" class="d-none">
                          <span class="bam-source-icon"><i class="uil uil-archive"></i></span>
                          <div class="bam-source-info">
                              <div class="bam-source-title">SR Warehouse</div>
                              <div class="bam-source-desc">From in-house inventory</div>
                          </div>
                          <span class="bam-source-check"><i class="uil uil-check-circle"></i></span>
                      </label>
                      <label class="bam-source-card" for="bamSrcDirect">
                          <input type="radio" name="battery_source" id="bamSrcDirect"
                                 value="Direct Fitment" class="d-none">
                          <span class="bam-source-icon"><i class="uil uil-truck"></i></span>
                          <div class="bam-source-info">
                              <div class="bam-source-title">Direct Fitment</div>
                              <div class="bam-source-desc">New battery from vendor</div>
                          </div>
                          <span class="bam-source-check"><i class="uil uil-check-circle"></i></span>
                      </label>
                  </div>
                  <span class="bam-field-error" id="bamErrSource"></span>

                  {{-- SR Warehouse sub-panel --}}
                  <div class="bam-src-panel" id="bamPanelWarehouse">
                      <div class="bam-src-panel-inner">
                          <div class="mb-2">
                              <div id="bamBatteryDropdownState" class="text-muted small mb-1">
                                  Select a Condition above to load available stock.
                              </div>
                              <label class="form-label fw-semibold" style="font-size:12px;">
                                  Select Battery from Warehouse <span class="text-danger">*</span>
                              </label>
                              <select class="form-select form-select-sm" id="bamWarehouseBatterySelect"
                                      name="warehouse_battery_id" disabled>
                                  <option value="">— Select condition first —</option>
                              </select>
                              <span class="bam-field-error" id="bamErrWarehouseBattery"></span>
                          </div>
                          <div class="row g-2">
                              <div class="col-md-6">
                                  <label class="form-label fw-semibold small text-muted">
                                      Battery Brand
                                      <span class="badge bg-light text-secondary border ms-1" style="font-size:10px;">Auto-filled</span>
                                  </label>
                                  <input type="text" class="form-control form-control-sm bg-light"
                                         id="bamWhBrand" readonly placeholder="Auto-filled on selection">
                              </div>
                              <div class="col-md-6">
                                  <label class="form-label fw-semibold small text-muted">
                                      Serial Number
                                      <span class="badge bg-light text-secondary border ms-1" style="font-size:10px;">Auto-filled</span>
                                  </label>
                                  <input type="text" class="form-control form-control-sm bg-light"
                                         id="bamWhSerial" readonly placeholder="Auto-filled on selection">
                              </div>
                          </div>
                      </div>
                  </div>

                  {{-- Direct Fitment sub-panel --}}
                  <div class="bam-src-panel" id="bamPanelDirect">
                      <div class="bam-src-panel-inner">
                          <div class="row g-2">
                              <div class="col-md-6">
                                  <label class="form-label fw-semibold" style="font-size:12px;">
                                      Battery Brand <span class="text-danger">*</span>
                                  </label>
                                  <input type="text" class="form-control form-control-sm"
                                         name="battery_brand" id="bamDirBrand"
                                         placeholder="e.g. Exide, Amara Raja" maxlength="100">
                                  <span class="bam-field-error" id="bamErrDirBrand"></span>
                              </div>
                              <div class="col-md-6">
                                  <label class="form-label fw-semibold" style="font-size:12px;">
                                      Battery Serial Number <span class="text-danger">*</span>
                                  </label>
                                  <input type="text" class="form-control form-control-sm"
                                         name="battery_serial_number" id="bamDirSerial"
                                         placeholder="e.g. BT-2024-0001" maxlength="100">
                                  <span class="bam-field-error" id="bamErrDirSerial"></span>
                              </div>
                              <div class="col-md-6">
                                  <label class="form-label fw-semibold" style="font-size:12px;">Battery Model</label>
                                  <input type="text" class="form-control form-control-sm"
                                         name="battery_model" placeholder="e.g. FEO-TBTZ0" maxlength="100">
                              </div>
                              <div class="col-md-6">
                                  <label class="form-label fw-semibold" style="font-size:12px;">Capacity (Ah)</label>
                                  <input type="text" class="form-control form-control-sm"
                                         name="battery_capacity" placeholder="e.g. 88" maxlength="50">
                              </div>
                              <div class="col-md-6">
                                  <label class="form-label fw-semibold" style="font-size:12px;">Voltage</label>
                                  <select class="form-select form-select-sm" name="battery_voltage">
                                      <option value="">— Select Voltage —</option>
                                      <option value="6V">6V</option>
                                      <option value="12V" selected>12V</option>
                                      <option value="24V">24V</option>
                                      <option value="48V">48V</option>
                                  </select>
                              </div>
                              <div class="col-md-6">
                                  <label class="form-label fw-semibold" style="font-size:12px;">Purchase Date</label>
                                  <input type="date" class="form-control form-control-sm" name="purchase_date">
                              </div>
                              <div class="col-md-6">
                                  <label class="form-label fw-semibold" style="font-size:12px;">Warranty (Months)</label>
                                  <input type="number" class="form-control form-control-sm"
                                         name="warranty_months" min="0" placeholder="e.g. 12">
                              </div>
                          </div>
                      </div>
                  </div>
              </div>

              {{-- SECTION 4: Replacement Details --}}
              <div class="bam-section">
                  <div class="bam-section-title">
                      <span class="bam-section-num">4</span>
                      Replacement Details
                  </div>
                  <div class="row g-2">
                      <div class="col-md-6">
                          <label class="form-label fw-semibold" style="font-size:12px;">
                              Replacement Date <span class="text-danger">*</span>
                          </label>
                          <input type="date" class="form-control form-control-sm"
                                 name="replacement_date" id="bamRplDate">
                          <span class="bam-field-error" id="bamErrRplDate"></span>
                      </div>
                      <div class="col-md-6">
                          <label class="form-label fw-semibold" style="font-size:12px;">KM at Replacement</label>
                          <div class="input-group input-group-sm">
                              <input type="number" class="form-control" name="replacement_km"
                                     id="bamRplKm" min="0" placeholder="0">
                              <span class="input-group-text">KM</span>
                          </div>
                      </div>
                  </div>
              </div>

              {{-- SECTION 5: Attachments --}}
              <div class="bam-section">
                  <div class="bam-section-title">
                      <span class="bam-section-num">5</span>
                      Attachments
                      <span class="text-muted fw-normal small ms-1">(JPG/PNG/WEBP · max 5 MB)</span>
                  </div>
                  <div class="bam-photo-grid">
                      <div class="bam-photo-slot">
                          <span class="bam-photo-slot-label">Damaged Battery</span>
                          <input type="file" class="form-control form-control-sm"
                                 name="photo_damage" id="bamPhotoDamage"
                                 accept="image/jpeg,image/png,image/webp">
                          <img class="bam-photo-thumb" id="bamThumbDamage" alt="Preview">
                      </div>
                      <div class="bam-photo-slot">
                          <span class="bam-photo-slot-label">New Battery Serial</span>
                          <input type="file" class="form-control form-control-sm"
                                 name="photo_serial" id="bamPhotoSerial"
                                 accept="image/jpeg,image/png,image/webp">
                          <img class="bam-photo-thumb" id="bamThumbSerial" alt="Preview">
                      </div>
                      <div class="bam-photo-slot">
                          <span class="bam-photo-slot-label">Odometer</span>
                          <input type="file" class="form-control form-control-sm"
                                 name="photo_odometer" id="bamPhotoOdometer"
                                 accept="image/jpeg,image/png,image/webp">
                          <img class="bam-photo-thumb" id="bamThumbOdometer" alt="Preview">
                      </div>
                  </div>
              </div>

              {{-- SECTION 6: Old Battery Destination --}}
              <div class="bam-section">
                  <div class="bam-section-title">
                      <span class="bam-section-num">6</span>
                      Old Battery Destination
                  </div>
                  <div class="row g-2">
                      <div class="col-12">
                          <label class="form-label fw-semibold" style="font-size:12px;">
                              Where should the removed battery go? <span class="text-danger">*</span>
                          </label>
                          <div class="bam-old-dest-grid" id="bamOldDestGrid">
                              <label class="bam-old-dest-pill" for="bamOldDestWarehouse">
                                  <input type="radio" name="old_battery_destination"
                                         id="bamOldDestWarehouse" value="SR Garage" class="d-none">
                                  🏭 SR Garage
                              </label>
                              <label class="bam-old-dest-pill" for="bamOldDestWorkshop">
                                  <input type="radio" name="old_battery_destination"
                                         id="bamOldDestWorkshop" value="Workshop" class="d-none">
                                  🔧 Workshop
                              </label>
                              <label class="bam-old-dest-pill" for="bamOldDestScrap">
                                  <input type="radio" name="old_battery_destination"
                                         id="bamOldDestScrap" value="Scrap" class="d-none">
                                  🗑️ Scrap
                              </label>
                              <label class="bam-old-dest-pill" for="bamOldDestDecide">
                                  <input type="radio" name="old_battery_destination"
                                         id="bamOldDestDecide" value="Yet to Decide" class="d-none">
                                  ⏳ Yet to Decide
                              </label>
                          </div>
                          <span class="bam-field-error" id="bamErrOldDest"></span>

                          {{-- Sub-panel: SR Warehouse --}}
                          <div class="mt-2 d-none" id="bamOldDestWarehouseWrap">
                              <label class="form-label fw-semibold" style="font-size:12px;">
                                  Select Warehouse <span class="text-danger">*</span>
                              </label>
                              <select class="form-select form-select-sm"
                                      name="old_dest_warehouse_id" id="bamOldDestWarehouseId">
                                  <option value="">— Select Warehouse —</option>
                              </select>
                              <span class="bam-field-error" id="bamErrOldDestWarehouse"></span>
                          </div>

                          {{-- Sub-panel: Workshop --}}
                          <div class="mt-2 d-none" id="bamOldDestWorkshopWrap">
                              <label class="form-label fw-semibold" style="font-size:12px;">
                                  Select Workshop <span class="text-danger">*</span>
                              </label>
                              <select class="form-select form-select-sm"
                                      name="old_dest_workshop_id" id="bamOldDestWorkshopId">
                                  <option value="">— Select Workshop —</option>
                              </select>
                              <span class="bam-field-error" id="bamErrOldDestWorkshop"></span>
                          </div>
                      </div>
                  </div>
              </div>

              {{-- SECTION 7: Notes --}}
              <div class="bam-section">
                  <div class="bam-section-title">
                      <span class="bam-section-num">7</span>
                      Notes
                      <span class="bam-notes-scrap-hint text-danger fw-normal d-none ms-1" id="bamNotesScrapHint"
                            style="font-size:10px; text-transform:none; letter-spacing:0;">(Required for Scrap)</span>
                  </div>
                  <div class="row g-2">
                      <div class="col-12">
                          <textarea class="form-control form-control-sm" id="bamNotes" name="notes"
                                    rows="2" placeholder="Add any notes or remarks…"
                                    style="resize:vertical; font-size:12px;"></textarea>
                          <span class="bam-field-error" id="bamErrNotes"></span>
                      </div>
                  </div>
              </div>

          </form>

          {{-- Data store: warehouses + workshops for JS (data only — no inline logic per SD-1) --}}
          <div id="bamDataStore" class="d-none"
               data-warehouses="{{ json_encode($warehouses->map(fn($w) => ['id' => $w->id, 'name' => $w->name, 'type' => $w->warehouse_type ?? ''])) }}"
               data-workshops="{{ json_encode($workshops->map(fn($w) => ['id' => $w->id, 'name' => $w->name])) }}">
          </div>

      </div>{{-- /modal-body --}}

      {{-- Modal Footer --}}
      <div class="modal-footer py-2 px-3">
          <button type="button" class="btn btn-sm btn-secondary"
                  data-bs-dismiss="modal">Cancel</button>
          <button type="button" id="bamRplSubmitBtn" class="btn btn-sm btn-primary">
              <span id="bamRplSubmitText">
                  <i class="uil uil-exchange me-1"></i>Replace Battery
              </span>
              <span id="bamRplSubmitSpinner"
                    class="spinner-border spinner-border-sm d-none ms-1" role="status"></span>
          </button>
      </div>

    </div>
  </div>
</div>{{-- /batteryTakeActionModal --}}

@endsection

@section('js')
<script src="{{ asset('js/Battery/battery-tagging.js?v=2.6') }}"></script>
@endsection
