@extends('layouts.app')

@section('css')
<link href="{{ asset('css/Inventory/battery-dashboard.css?v=2.0') }}" rel="stylesheet">
<link href="{{ asset('css/Inventory/battery-details.css?v=1.1') }}" rel="stylesheet">
@endsection

@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="wrapper srlog-bdwrapper">
        <div class="main-wrap sc-no-sidebar">

            {{-- Breadcrumb --}}
            <nav aria-label="breadcrumb" class="mb-2">
                <ol class="breadcrumb sc-breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('inventory.dashboard') }}">Inventory</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('inventory.battery-dashboard') }}">Battery Dashboard</a></li>
                    <li class="breadcrumb-item active" id="bdet-breadcrumb-serial">BAT-2026-00081</li>
                </ol>
            </nav>

            {{-- Page Header --}}
            <div class="bdet-page-header d-flex align-items-start justify-content-between mb-3">
                <div class="d-flex align-items-center gap-3">
                    <a href="{{ route('inventory.battery-dashboard') }}" class="bdet-back-btn">
                        <i class="uil uil-arrow-left"></i>
                    </a>
                    <div>
                        <div class="d-flex align-items-center gap-2 flex-wrap">
                            <h5 class="mb-0 bdet-title" id="bdet-serial-title">BAT-2026-00081</h5>
                            <span class="btd-st-active" id="bdet-status-badge">Active</span>
                            <span class="bdet-type-chip" id="bdet-type-chip">Lead-Acid · 12V · 150Ah</span>
                        </div>
                        <span class="text-muted" style="font-size:12px;" id="bdet-brand-subtitle">Amaron · Pro Truck 150 · Purchased Feb 2024</span>
                    </div>
                </div>
                <div class="d-flex gap-2 flex-wrap">
                    <a href="{{ route('inventory.battery.action') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="uil uil-bolt-alt me-1"></i>Fit / Replace
                    </a>
                    <button class="btn btn-outline-secondary btn-sm" id="bdet-btn-workshop">
                        <i class="uil uil-wrench me-1"></i>Send to Workshop
                    </button>
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="uil uil-ellipsis-h"></i> More
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item text-warning" href="#"><i class="uil uil-exclamation-triangle me-2"></i>Mark as Weak</a></li>
                            <li><a class="dropdown-item text-danger" href="#"><i class="uil uil-times-circle me-2"></i>Mark as Discarded</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#"><i class="uil uil-print me-2"></i>Print Summary</a></li>
                            <li><a class="dropdown-item" href="#"><i class="uil uil-file-download me-2"></i>Export PDF</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Stat Cards --}}
            <div class="row g-3 mb-3">
                <div class="col-6 col-md-3">
                    <div class="bdet-stat-card bdet-stat-green">
                        <div class="bdet-stat-icon"><i class="uil uil-check-circle"></i></div>
                        <div class="bdet-stat-body">
                            <div class="bdet-stat-val" id="bdet-s-condition">New</div>
                            <div class="bdet-stat-lbl">Condition</div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="bdet-stat-card bdet-stat-navy">
                        <div class="bdet-stat-icon"><i class="uil uil-bolt-alt"></i></div>
                        <div class="bdet-stat-body">
                            <div class="bdet-stat-val" id="bdet-s-status">Active</div>
                            <div class="bdet-stat-lbl">Status</div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="bdet-stat-card bdet-stat-amber">
                        <div class="bdet-stat-icon"><i class="uil uil-map-marker"></i></div>
                        <div class="bdet-stat-body">
                            <div class="bdet-stat-val" id="bdet-s-location">On Vehicle</div>
                            <div class="bdet-stat-lbl">Location</div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="bdet-stat-card bdet-stat-grey">
                        <div class="bdet-stat-icon"><i class="uil uil-truck"></i></div>
                        <div class="bdet-stat-body">
                            <div class="bdet-stat-val" id="bdet-s-vehicle">KA-05-AB-1234</div>
                            <div class="bdet-stat-lbl">Allocated Vehicle</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Lifecycle Strip --}}
            <div class="bdet-lifecycle mb-3">
                <div class="btd-lifecycle">
                    @php
                    $lcSteps = [
                        ['purchase','uil-shopping-cart','Purchase','Feb 2024'],
                        ['install','uil-car-sideview','Install','Mar 2024'],
                        ['use','uil-bolt-alt','In Use','Mar 2024'],
                        ['remove','uil-minus-circle','Remove','—'],
                        ['workshop','uil-wrench','Workshop','—'],
                        ['reuse','uil-redo','Reuse','—'],
                        ['discard','uil-trash-alt','Discard','—'],
                    ];
                    @endphp
                    @foreach($lcSteps as $i => $lc)
                    <div class="btd-lc-step {{ in_array($i,[0,1,2]) ? 'btd-lc-done' : '' }} {{ $i===2 ? 'btd-lc-current' : '' }}">
                        <div class="btd-lc-icon {{ $lc[0] }}"><i class="uil {{ $lc[1] }}"></i></div>
                        <div class="btd-lc-label">{{ $lc[2] }}</div>
                        <div class="btd-lc-date">{{ $lc[3] }}</div>
                    </div>
                    @if($i < count($lcSteps)-1)
                    <div class="btd-lc-arrow {{ $i < 2 ? 'btd-lc-arrow-done' : '' }}"><i class="uil uil-arrow-right"></i></div>
                    @endif
                    @endforeach
                </div>
            </div>

            {{-- Tab Bar --}}
            <div class="sc-tab-bar mb-3">
                <button class="sc-tab active" data-tab="bdet-tab-overview">Overview</button>
                <button class="sc-tab" data-tab="bdet-tab-log">Movement Log</button>
                <button class="sc-tab" data-tab="bdet-tab-docs">Documents</button>
                <button class="sc-tab" data-tab="bdet-tab-notes">Notes</button>
            </div>

            {{-- ══════════════ TAB: OVERVIEW ══════════════ --}}
            <div id="bdet-tab-overview" class="bdet-tab-panel">
                <div class="row g-3">
                    {{-- Identification --}}
                    <div class="col-12 col-lg-6">
                        <div class="sc-card h-100">
                            <div class="sc-card-head">
                                <span class="sc-card-title"><i class="uil uil-tag-alt me-2"></i>Battery Identification</span>
                            </div>
                            <div class="bdet-specs-grid p-3">
                                @php
                                $idFields = [
                                    ['Serial Number','BAT-2026-00081','fw-semibold text-navy'],
                                    ['Brand','Amaron',''],
                                    ['Model','Pro Truck 150',''],
                                    ['Battery Type','Lead-Acid',''],
                                    ['Capacity','150 Ah','fw-semibold'],
                                    ['Voltage','12V','fw-semibold'],
                                    ['Cold Cranking Amps','900 CCA',''],
                                    ['Battery Position','Primary',''],
                                ];
                                @endphp
                                @foreach($idFields as $f)
                                <div class="bdet-spec-row">
                                    <span class="bdet-spec-lbl">{{ $f[0] }}</span>
                                    <span class="bdet-spec-val {{ $f[2] }}">{{ $f[1] }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Purchase & Warranty --}}
                    <div class="col-12 col-lg-6">
                        <div class="sc-card h-100">
                            <div class="sc-card-head">
                                <span class="sc-card-title"><i class="uil uil-shield-check me-2"></i>Purchase & Warranty</span>
                            </div>
                            <div class="bdet-specs-grid p-3">
                                @php
                                $wFields = [
                                    ['Purchase Date','15 Feb 2024',''],
                                    ['Purchase Price','₹ 12,500','fw-semibold'],
                                    ['Vendor','Amaron Battery Pvt. Ltd.',''],
                                    ['Warranty Months','36 months',''],
                                    ['Warranty Expires','15 Feb 2027','bdet-val-warn'],
                                    ['Expected Life','60 months',''],
                                    ['End of Life Est.','15 Feb 2029',''],
                                    ['Months in Service','14 months','fw-semibold'],
                                ];
                                @endphp
                                @foreach($wFields as $f)
                                <div class="bdet-spec-row">
                                    <span class="bdet-spec-lbl">{{ $f[0] }}</span>
                                    <span class="bdet-spec-val {{ $f[2] }}">{{ $f[1] }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Current Allocation --}}
                    <div class="col-12 col-lg-6">
                        <div class="sc-card h-100">
                            <div class="sc-card-head">
                                <span class="sc-card-title"><i class="uil uil-truck me-2"></i>Current Allocation</span>
                            </div>
                            <div class="bdet-specs-grid p-3">
                                @php
                                $alFields = [
                                    ['Vehicle Reg No.','KA-05-AB-1234','fw-semibold text-navy'],
                                    ['Vehicle Model','Tata Prima 4928 LCV',''],
                                    ['Install Date','08 Mar 2024',''],
                                    ['Duration on Vehicle','14 months','fw-semibold'],
                                    ['Current Odometer','1,10,230 KM',''],
                                    ['Installed By','Rajesh Kumar (Tech)',''],
                                    ['Workshop','WS-HYD — Hyderabad',''],
                                ];
                                @endphp
                                @foreach($alFields as $f)
                                <div class="bdet-spec-row">
                                    <span class="bdet-spec-lbl">{{ $f[0] }}</span>
                                    <span class="bdet-spec-val {{ $f[2] }}">{{ $f[1] }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Health Indicators --}}
                    <div class="col-12 col-lg-6">
                        <div class="sc-card h-100">
                            <div class="sc-card-head d-flex align-items-center justify-content-between">
                                <span class="sc-card-title"><i class="uil uil-heartbeat me-2"></i>Health Indicators</span>
                                <span class="bdet-health-updated">Last checked: 10 Apr 2026</span>
                            </div>
                            <div class="p-3">
                                <div class="bdet-health-bar-wrap mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="bdet-spec-lbl">State of Health (SOH)</span>
                                        <span class="bdet-health-pct bdet-hp-good">86%</span>
                                    </div>
                                    <div class="progress bdet-progress">
                                        <div class="progress-bar bdet-pb-green" style="width:86%"></div>
                                    </div>
                                </div>
                                <div class="bdet-health-bar-wrap mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="bdet-spec-lbl">Life Used</span>
                                        <span class="bdet-health-pct bdet-hp-warn">23% (14/60 mo)</span>
                                    </div>
                                    <div class="progress bdet-progress">
                                        <div class="progress-bar bdet-pb-amber" style="width:23%"></div>
                                    </div>
                                </div>
                                <div class="bdet-health-bar-wrap mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="bdet-spec-lbl">Warranty Used</span>
                                        <span class="bdet-health-pct bdet-hp-warn">39% (14/36 mo)</span>
                                    </div>
                                    <div class="progress bdet-progress">
                                        <div class="progress-bar bdet-pb-amber" style="width:39%"></div>
                                    </div>
                                </div>
                                <div class="bdet-health-chips mt-2">
                                    <span class="bdet-hchip bdet-hchip-good"><i class="uil uil-check-circle me-1"></i>Voltage OK</span>
                                    <span class="bdet-hchip bdet-hchip-good"><i class="uil uil-check-circle me-1"></i>Charge OK</span>
                                    <span class="bdet-hchip bdet-hchip-warn"><i class="uil uil-exclamation-triangle me-1"></i>Check at 18 mo.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ══════════════ TAB: MOVEMENT LOG ══════════════ --}}
            <div id="bdet-tab-log" class="bdet-tab-panel" style="display:none;">
                <div class="sc-card">
                    <div class="sc-card-head d-flex align-items-center justify-content-between">
                        <span class="sc-card-title"><i class="uil uil-history me-2"></i>Movement Log</span>
                        <div class="d-flex gap-2 align-items-center">
                            <select class="form-select form-select-sm bdet-log-filter" id="bdet-log-type-filter" style="width:150px;">
                                <option value="">All Events</option>
                                <option value="purchase">Purchase / Received</option>
                                <option value="install">Installation</option>
                                <option value="remove">Removal</option>
                                <option value="workshop">Workshop</option>
                                <option value="reuse">Reuse</option>
                                <option value="discard">Discard</option>
                            </select>
                            <button class="btn btn-outline-secondary btn-sm" onclick="window.print()">
                                <i class="uil uil-export me-1"></i>Export
                            </button>
                        </div>
                    </div>

                    {{-- Log Summary Strip --}}
                    <div class="bdet-log-summary">
                        <div class="bdet-log-sum-item">
                            <span class="bdet-log-sum-val">4</span>
                            <span class="bdet-log-sum-lbl">Total Events</span>
                        </div>
                        <div class="bdet-log-sum-item">
                            <span class="bdet-log-sum-val">14 mo</span>
                            <span class="bdet-log-sum-lbl">On Current Vehicle</span>
                        </div>
                        <div class="bdet-log-sum-item">
                            <span class="bdet-log-sum-val">1</span>
                            <span class="bdet-log-sum-lbl">Vehicles Used On</span>
                        </div>
                        <div class="bdet-log-sum-item">
                            <span class="bdet-log-sum-val">0</span>
                            <span class="bdet-log-sum-lbl">Workshop Visits</span>
                        </div>
                    </div>

                    {{-- Timeline --}}
                    <div class="bdet-timeline p-3 p-md-4" id="bdet-log-timeline">

                        {{-- Event 1 — Most Recent --}}
                        <div class="bdet-tl-event bdet-tl-install" data-event-type="install">
                            <div class="bdet-tl-dot-wrap">
                                <div class="bdet-tl-dot bdet-dot-install"><i class="uil uil-car-sideview"></i></div>
                                <div class="bdet-tl-connector"></div>
                            </div>
                            <div class="bdet-tl-card">
                                <div class="bdet-tl-card-header">
                                    <div>
                                        <span class="bdet-tl-event-badge bdet-badge-install">Installation</span>
                                        <span class="bdet-tl-event-title">Fitted to KA-05-AB-1234</span>
                                    </div>
                                    <span class="bdet-tl-date">08 Mar 2024 · 11:45 AM</span>
                                </div>
                                <div class="bdet-tl-card-body">
                                    <div class="row g-2">
                                        <div class="col-12 col-md-6">
                                            <div class="bdet-tl-detail-row"><span class="bdet-tl-dl">Vehicle</span><span class="bdet-tl-dv">KA-05-AB-1234 (Tata Prima 4928)</span></div>
                                            <div class="bdet-tl-detail-row"><span class="bdet-tl-dl">Position</span><span class="bdet-tl-dv">Primary Battery</span></div>
                                            <div class="bdet-tl-detail-row"><span class="bdet-tl-dl">Odometer</span><span class="bdet-tl-dv">1,10,230 KM</span></div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="bdet-tl-detail-row"><span class="bdet-tl-dl">Workshop</span><span class="bdet-tl-dv">WS-HYD — Hyderabad</span></div>
                                            <div class="bdet-tl-detail-row"><span class="bdet-tl-dl">Technician</span><span class="bdet-tl-dv">Rajesh Kumar</span></div>
                                            <div class="bdet-tl-detail-row"><span class="bdet-tl-dl">Condition</span><span class="bdet-tl-dv"><span class="btd-cond-new">New</span></span></div>
                                        </div>
                                    </div>
                                    <div class="bdet-tl-notes"><i class="uil uil-notes me-1"></i>Installed as primary battery. OEM replacement for old Exide unit.</div>
                                </div>
                            </div>
                        </div>

                        {{-- Event 2 --}}
                        <div class="bdet-tl-event bdet-tl-purchase" data-event-type="purchase">
                            <div class="bdet-tl-dot-wrap">
                                <div class="bdet-tl-dot bdet-dot-purchase"><i class="uil uil-shopping-cart"></i></div>
                                <div class="bdet-tl-connector"></div>
                            </div>
                            <div class="bdet-tl-card">
                                <div class="bdet-tl-card-header">
                                    <div>
                                        <span class="bdet-tl-event-badge bdet-badge-purchase">Received</span>
                                        <span class="bdet-tl-event-title">Battery received — WH-HYD Warehouse</span>
                                    </div>
                                    <span class="bdet-tl-date">22 Feb 2024 · 03:15 PM</span>
                                </div>
                                <div class="bdet-tl-card-body">
                                    <div class="row g-2">
                                        <div class="col-12 col-md-6">
                                            <div class="bdet-tl-detail-row"><span class="bdet-tl-dl">Location</span><span class="bdet-tl-dv">WH-HYD — Warehouse, Shelf B-12</span></div>
                                            <div class="bdet-tl-detail-row"><span class="bdet-tl-dl">Status Changed</span><span class="bdet-tl-dv">— → Warehouse</span></div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="bdet-tl-detail-row"><span class="bdet-tl-dl">Received By</span><span class="bdet-tl-dv">Suresh M (Store Manager)</span></div>
                                            <div class="bdet-tl-detail-row"><span class="bdet-tl-dl">PO Reference</span><span class="bdet-tl-dv">PO-2024-00041</span></div>
                                        </div>
                                    </div>
                                    <div class="bdet-tl-notes"><i class="uil uil-notes me-1"></i>New battery received from Amaron supplier. Inspected, tagged BAT-2026-00081.</div>
                                </div>
                            </div>
                        </div>

                        {{-- Event 3 --}}
                        <div class="bdet-tl-event bdet-tl-purchase" data-event-type="purchase">
                            <div class="bdet-tl-dot-wrap">
                                <div class="bdet-tl-dot bdet-dot-purchase"><i class="uil uil-file-check-alt"></i></div>
                                {{-- No connector on last event --}}
                            </div>
                            <div class="bdet-tl-card">
                                <div class="bdet-tl-card-header">
                                    <div>
                                        <span class="bdet-tl-event-badge bdet-badge-purchase">Purchase</span>
                                        <span class="bdet-tl-event-title">Battery purchased from vendor</span>
                                    </div>
                                    <span class="bdet-tl-date">15 Feb 2024 · 10:00 AM</span>
                                </div>
                                <div class="bdet-tl-card-body">
                                    <div class="row g-2">
                                        <div class="col-12 col-md-6">
                                            <div class="bdet-tl-detail-row"><span class="bdet-tl-dl">Vendor</span><span class="bdet-tl-dv">Amaron Battery Pvt. Ltd.</span></div>
                                            <div class="bdet-tl-detail-row"><span class="bdet-tl-dl">Invoice No.</span><span class="bdet-tl-dv">AMR-INV-0298734</span></div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="bdet-tl-detail-row"><span class="bdet-tl-dl">Price</span><span class="bdet-tl-dv fw-semibold">₹ 12,500</span></div>
                                            <div class="bdet-tl-detail-row"><span class="bdet-tl-dl">Warranty</span><span class="bdet-tl-dv">36 months (exp. Feb 2027)</span></div>
                                        </div>
                                    </div>
                                    <div class="bdet-tl-notes"><i class="uil uil-notes me-1"></i>PO raised by Amit (SC Manager). Standard procurement for fleet replenishment.</div>
                                </div>
                            </div>
                        </div>

                        {{-- Empty state (shown when filter returns no results) --}}
                        <div class="bdet-log-empty" id="bdet-log-empty" style="display:none;">
                            <i class="uil uil-history bdet-log-empty-icon"></i>
                            <p>No events for this filter</p>
                        </div>

                    </div>{{-- end bdet-timeline --}}

                    {{-- Load More --}}
                    <div class="bdet-log-loadmore" id="bdet-log-loadmore">
                        <button class="btn btn-outline-secondary btn-sm" id="bdet-btn-loadmore">
                            <i class="uil uil-angle-down me-1"></i>Load older events
                        </button>
                        <span class="bdet-log-count">Showing 3 of 3 events</span>
                    </div>

                </div>{{-- end sc-card --}}
            </div>

            {{-- ══════════════ TAB: DOCUMENTS ══════════════ --}}
            <div id="bdet-tab-docs" class="bdet-tab-panel" style="display:none;">
                <div class="sc-card">
                    <div class="sc-card-head d-flex align-items-center justify-content-between">
                        <span class="sc-card-title"><i class="uil uil-paperclip me-2"></i>Documents</span>
                        <button class="btn sc-btn-navy btn-sm"><i class="uil uil-upload me-1"></i>Upload</button>
                    </div>
                    <div class="p-4 text-center text-muted">
                        <i class="uil uil-file-blank" style="font-size:36px;opacity:0.3;"></i>
                        <p class="mt-2 mb-0">Purchase invoice, warranty card, test reports</p>
                        <p class="mb-0" style="font-size:12px;">No documents uploaded yet</p>
                    </div>
                </div>
            </div>

            {{-- ══════════════ TAB: NOTES ══════════════ --}}
            <div id="bdet-tab-notes" class="bdet-tab-panel" style="display:none;">
                <div class="sc-card">
                    <div class="sc-card-head d-flex align-items-center justify-content-between">
                        <span class="sc-card-title"><i class="uil uil-notes me-2"></i>Notes</span>
                        <button class="btn sc-btn-navy btn-sm"><i class="uil uil-plus me-1"></i>Add Note</button>
                    </div>
                    <div class="p-3">
                        <div class="bdet-note-item">
                            <div class="bdet-note-meta">Rajesh Kumar · 10 Apr 2026 · 09:15 AM</div>
                            <div class="bdet-note-text">Battery performing well. Voltage steady at 12.6V under load. No issues flagged. Recommend check at 18 months mark (Sep 2025).</div>
                        </div>
                        <div class="bdet-note-item">
                            <div class="bdet-note-meta">Amit (SC Manager) · 08 Mar 2024 · 12:00 PM</div>
                            <div class="bdet-note-text">Installed on KA-05-AB-1234 as OEM replacement. Previous Exide battery was 42 months old. New Amaron Pro Truck 150Ah fitted as primary.</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>{{-- end main-wrap --}}
    </div>
</div>
@endsection

@section('js')
<script>
$(document).ready(function () {

    // ── Tab switching ────────────────────────────────────────────────────
    $('.sc-tab').on('click', function () {
        var target = $(this).data('tab');
        $('.sc-tab').removeClass('active');
        $(this).addClass('active');
        $('.bdet-tab-panel').hide();
        $('#' + target).show();
    });

    // ── Movement log filter ──────────────────────────────────────────────
    $('#bdet-log-type-filter').on('change', function () {
        var val = $(this).val();
        var events = $('.bdet-tl-event');
        if (!val) {
            events.show();
            $('#bdet-log-empty').hide();
            return;
        }
        var visible = 0;
        events.each(function () {
            if ($(this).data('event-type') === val) {
                $(this).show();
                visible++;
            } else {
                $(this).hide();
            }
        });
        $('#bdet-log-empty').toggle(visible === 0);
    });

    // Fit to Vehicle button is now a proper route() link in the blade — no JS needed

});
</script>
@endsection
