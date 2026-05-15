@extends('layouts.app')

@section('css')
<link href="{{ asset('css/Inventory/battery-dashboard.css?v=2.0') }}" rel="stylesheet">
<link href="{{ asset('css/Inventory/battery-details.css?v=2.8') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css" />
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
                    <li class="breadcrumb-item active" id="bdet-breadcrumb-serial">{{ $battery->battery_serial }}</li>
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
                            <h5 class="mb-0 bdet-title" id="bdet-serial-title">{{ $battery->battery_serial }}</h5>
                            <span class="btd-st-active" id="bdet-status-badge">{{ $battery->current_status ?? 'Active' }}</span>
                            <span class="bdet-type-chip" id="bdet-type-chip">{{ $battery->battery_condition ?? '' }}{{ $battery->battery_voltage ? ' · ' . $battery->battery_voltage : '' }}{{ $battery->battery_capacity ? ' · ' . $battery->battery_capacity . 'Ah' : '' }}</span>
                        </div>
                        <span class="text-muted" style="font-size:12px;" id="bdet-brand-subtitle">{{ $battery->battery_brand }}{{ $battery->battery_model ? ' · ' . $battery->battery_model : '' }}{{ $battery->battery_purchase_date ? ' · Purchased ' . $battery->battery_purchase_date->format('M Y') : '' }}</span>
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
            {{--
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
            --}}

            {{-- Tab Bar --}}
            <div class="vehicle-itemtab pt-3">
                <div class="container-fluid">
                    <ul class="nav nav-tabs item-box">
                        <li class="nav-item">
                            <button class="nav-link nav_click active" data-bs-toggle="tab" data-bs-target="#bdet-tab-overview">
                                <span class="icon"><i class="uil uil-info-circle" style="font-size:16px;vertical-align:middle;"></i></span>
                                Overview
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link nav_click" data-bs-toggle="tab" data-bs-target="#bdet-tab-vehicles">
                                <span class="icon"><i class="uil uil-car" style="font-size:16px;vertical-align:middle;"></i></span>
                                Allocated Vehicles
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link nav_click" data-bs-toggle="tab" data-bs-target="#bdet-tab-log">
                                <span class="icon"><i class="uil uil-history" style="font-size:16px;vertical-align:middle;"></i></span>
                                Movement Log
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link nav_click" data-bs-toggle="tab" data-bs-target="#bdet-tab-maintenance">
                                <span class="icon"><img src="{{ asset('images/icons/maintenance-icon.png') }}" alt="" style="width:16px;vertical-align:middle;" /></span>
                                Maintenance
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link nav_click" data-bs-toggle="tab" data-bs-target="#bdet-tab-docs">
                                <span class="icon"><i class="uil uil-paperclip" style="font-size:16px;vertical-align:middle;"></i></span>
                                Documents
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link nav_click" data-bs-toggle="tab" data-bs-target="#bdet-tab-comments">
                                <span class="icon"><img src="{{ asset('images/icons/comments-0123.png') }}" alt="" style="width:16px;vertical-align:middle;" /></span>
                                Comments
                            </button>
                        </li>
                    </ul>

                    {{-- Tab Content --}}
                    <div class="tab-content mt-3">

            {{-- ══════════════ TAB: OVERVIEW ══════════════ --}}
            <div class="tab-pane fade show active" id="bdet-tab-overview">
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

            {{-- ══════════════ TAB: ALLOCATED VEHICLES ══════════════ --}}
            <div class="tab-pane fade" id="bdet-tab-vehicles">

                {{-- Filter --}}
                <div class="accordion mt-3" id="bdet-accord-vehicle">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="bdet-head-vehicle">
                            <button class="accordion-button filter-options" type="button"
                                data-bs-toggle="collapse" data-bs-target="#bdet-collapse-vehicle"
                                aria-expanded="true" aria-controls="bdet-collapse-vehicle">
                                <div class="item-filter">
                                    <span class="filter-icon">
                                        <img src="{{ asset('images/icons/filter-01icon.png') }}" alt="icon" />
                                    </span>
                                    <p>Filter Options</p>
                                </div>
                            </button>
                        </h2>
                        <div id="bdet-collapse-vehicle" class="accordion-collapse collapse show"
                             aria-labelledby="bdet-head-vehicle" data-bs-parent="#bdet-accord-vehicle">
                            <div class="accordion-body">
                                <div class="row g-3 align-items-end">
                                    <div class="col-4">
                                        <label class="form-label mb-1" style="font-size:13px;font-weight:500;color:#495057;">Date Range</label>
                                        <input type="text" class="form-control" id="bdet-veh-daterange"
                                               placeholder="Select date range..." />
                                    </div>
                                    <div class="col-4">
                                        <label class="form-label mb-1" style="font-size:13px;font-weight:500;color:#495057;">Vehicle Number</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="bdet-veh-search"
                                                   placeholder="Search vehicle number..." />
                                            <span class="input-group-text"><i class="uil uil-search"></i></span>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <button class="btn btn-primary" type="button" id="bdet-veh-reset">
                                            <i class="uil uil-sync me-1"></i>Reset
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Allocated Vehicle List --}}
                <div class="vehiclestable mt-3">
                    <div class="itemtop">
                        <span class="sec-title">Allocated Vehicle List</span>
                    </div>
                    <div class="table-responsive">
                        <table class="table custom-driver-table" id="bdet-alloc-table">
                            <thead>
                                <tr>
                                    <th>Vehicle Number</th>
                                    <th>Battery Position</th>
                                    <th>Driver Name &amp; Code</th>
                                    <th>Start &amp; End Date</th>
                                    <th>Allocated Period</th>
                                    <th>Allocated KM Driven</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($vehicleAllocations as $va)
                                @php
                                    $vehNo       = $va->vehicle->basicinfo->vehicle_number ?? '—';
                                    $battPos     = $va->battery_position ?? '—';
                                    $driver      = $va->vehicle->driverAllocation->contact ?? null;
                                    $driverName  = $driver ? $driver->contact_name : '—';
                                    $driverCode  = $driver ? ($driver->contact_code ?? '') : '';

                                    $start = $va->fitment_date ? \Carbon\Carbon::parse($va->fitment_date) : null;
                                    $end   = $va->deleted_at   ? \Carbon\Carbon::parse($va->deleted_at)   : null;

                                    if ($start) {
                                        $endRef    = $end ?? \Carbon\Carbon::today();
                                        $days      = $start->diffInDays($endRef);
                                        $months    = (int) $start->diffInMonths($endRef);
                                        $years     = (int) $start->diffInYears($endRef);
                                        $periodStr = $days . ' Days';
                                        if ($months >= 1) $periodStr .= ' / ' . $months . ' Months';
                                        if ($years  >= 1) $periodStr .= ' / ' . $years  . ' Years';
                                    } else {
                                        $periodStr = '—';
                                    }

                                    // Allocated KM Driven
                                    if ($va->km_at_fitment !== null && $va->km_at_removal !== null) {
                                        $kmDriven = number_format($va->km_at_removal - $va->km_at_fitment) . ' KM';
                                    } elseif ($va->km_at_fitment !== null && is_null($va->deleted_at)) {
                                        $kmDriven = 'Active (from ' . number_format($va->km_at_fitment) . ' KM)';
                                    } else {
                                        $kmDriven = '—';
                                    }

                                    $startStr = $start ? $start->format('d-m-Y') : '—';
                                    $endStr   = $end   ? $end->format('d-m-Y')   : 'Active';
                                @endphp
                                <tr data-vehicle="{{ strtolower($vehNo) }}"
                                    data-fitment="{{ $start ? $start->format('Y-m-d') : '' }}"
                                    data-removal="{{ $end   ? $end->format('Y-m-d')   : '' }}">
                                    <td><span class="fw-semibold">{{ $vehNo }}</span></td>
                                    <td>{{ $battPos }}</td>
                                    <td>
                                        <span class="d-block">{{ $driverName }}</span>
                                        @if($driverCode)
                                            <small class="text-muted">{{ $driverCode }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="d-block">{{ $startStr }}</span>
                                        <small class="text-muted">to {{ $endStr }}</small>
                                    </td>
                                    <td>{{ $periodStr }}</td>
                                    <td>{{ $kmDriven }}</td>
                                </tr>
                                @empty
                                <tr id="bdet-veh-empty-row">
                                    <td colspan="6" class="text-center text-muted py-4">
                                        <i class="uil uil-truck fs-4 d-block mb-1"></i>
                                        No vehicle allocation history found for this battery.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            {{-- ══════════════ END TAB: ALLOCATED VEHICLES ══════════════ --}}

            {{-- ══════════════ TAB: MOVEMENT LOG ══════════════ --}}
            <div class="tab-pane fade" id="bdet-tab-log">
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
            {{-- ══════════════ END TAB: MOVEMENT LOG ══════════════ --}}

            {{-- ══════════════ TAB: MAINTENANCE ══════════════ --}}
            <div class="tab-pane fade" id="bdet-tab-maintenance">

                {{-- Summary strip --}}
                <div class="totalrevenue mt-3">
                    <div class="item-row">
                        <div class="itemcol">
                            <p>Total Scheduled</p>
                            <span class="number c-01">{{ $maintenanceSchedules->count() }}</span>
                        </div>
                        <div class="itemcol">
                            <p>Overdue</p>
                            <span class="number c-02">{{ $maintenanceSchedules->whereIn('status', ['Overdue', 'Missed'])->count() }}</span>
                        </div>
                        <div class="itemcol">
                            <p>Due Next Month</p>
                            @php
                                $dueNextMonth = $maintenanceSchedules->filter(function($ms) {
                                    return $ms->next_due_date &&
                                           $ms->next_due_date->greaterThanOrEqualTo(\Carbon\Carbon::today()) &&
                                           $ms->next_due_date->lessThanOrEqualTo(\Carbon\Carbon::today()->addMonth());
                                })->sum('cost');
                            @endphp
                            <span class="number c-03">₹{{ number_format($dueNextMonth, 0) }}</span>
                        </div>
                        <div class="itemcol">
                            <p>Up to Date</p>
                            @php
                                $upToDate = $maintenanceSchedules->whereIn('status', ['Done', 'Completed'])->sum('cost');
                            @endphp
                            <span class="number c-04">₹{{ number_format($upToDate, 0) }}</span>
                        </div>
                    </div>
                </div>

                {{-- Sub-tab nav + action button --}}
                <div class="row mt-4">
                    <div class="col-12 col-md-8">
                        <ul class="nav nav-pills" id="bdet-maint-pills" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active mb-0" id="bdet-pills-maint-tab"
                                        data-bs-toggle="pill" data-bs-target="#bdet-pills-maint"
                                        type="button" role="tab"
                                        aria-controls="bdet-pills-maint" aria-selected="true">
                                    Scheduled Maintenance
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link mb-0" id="bdet-pills-repair-tab"
                                        data-bs-toggle="pill" data-bs-target="#bdet-pills-repair"
                                        type="button" role="tab"
                                        aria-controls="bdet-pills-repair" aria-selected="false">
                                    Repair
                                </button>
                            </li>
                        </ul>
                    </div>
                    <div class="col-12 col-md-4 text-end">
                        {{-- Button label swaps with active sub-tab (SD-1: done via JS) --}}
                        <a href="javascript:void(0)" class="btn btn-primary" id="bdet-maint-action-btn"
                           data-bs-toggle="modal" data-bs-target="#bdet-add-maintenance">
                            <i class="uil uil-plus me-1"></i>Schedule Maintenance
                        </a>
                    </div>
                </div>

                <div class="tab-content" id="bdet-maint-pillsContent">

                    {{-- ── Sub-tab: Scheduled Maintenance ── --}}
                    <div class="tab-pane fade show active" id="bdet-pills-maint" role="tabpanel" aria-labelledby="bdet-pills-maint-tab">

                        {{-- Filter --}}
                        <div class="accordion mt-3" id="bdet-accord-maint">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="bdet-head-maint">
                                    <button class="accordion-button filter-options" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#bdet-collapse-maint"
                                            aria-expanded="true" aria-controls="bdet-collapse-maint">
                                        <div class="item-filter">
                                            <span class="filter-icon">
                                                <img src="{{ asset('images/icons/filter-01icon.png') }}" alt="icon" />
                                            </span>
                                            <p>Filter Options</p>
                                        </div>
                                    </button>
                                </h2>
                                <div id="bdet-collapse-maint" class="accordion-collapse collapse show"
                                     aria-labelledby="bdet-head-maint" data-bs-parent="#bdet-accord-maint">
                                    <div class="accordion-body">
                                        <form id="bdet-maint-filter-form">
                                            <div class="filtersearch-bd justify-content-between flex-wrap gap-2">
                                                <div class="vehicletype">
                                                    <label>Date Range</label>
                                                    <input type="text" class="form-control" id="bdet-maint-filter-daterange" placeholder="Select date range..." />
                                                </div>
                                                <div class="vehicletype ms-1">
                                                    <label>Maintenance Type</label>
                                                    <select class="form-select" id="bdet-maint-filter-type">
                                                        <option value="">All Types</option>
                                                        <option value="Inspection">Inspection</option>
                                                        <option value="Charging">Charging</option>
                                                        <option value="Replacement">Replacement</option>
                                                        <option value="Other">Other</option>
                                                    </select>
                                                </div>
                                                <div class="vehicletype ms-1">
                                                    <label>Status</label>
                                                    <select class="form-select" id="bdet-maint-filter-status">
                                                        <option value="">All Status</option>
                                                        <option value="Completed">Completed</option>
                                                        <option value="Done">Done</option>
                                                        <option value="Missed">Missed</option>
                                                        <option value="Overdue">Overdue</option>
                                                        <option value="Pending">Pending</option>
                                                        <option value="Scheduled">Scheduled</option>
                                                        <option value="Upcoming">Upcoming</option>
                                                    </select>
                                                </div>
                                                <div class="vehicletype ms-1" style="width:200px;">
                                                    <label>Vehicle Number</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" id="bdet-maint-filter-vehicle" placeholder="Vehicle number..." />
                                                        <span class="input-group-text"><i class="uil uil-search"></i></span>
                                                    </div>
                                                </div>
                                                <div class="vehicletype ms-1 d-flex align-items-end">
                                                    <button class="btn btn-primary" type="button" id="bdet-maint-filter-reset">
                                                        <i class="uil uil-sync me-1"></i>Reset
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Scheduled Maintenance List --}}
                        <div class="vehiclestable">
                            <div class="itemtop">
                                <span class="sec-title">Scheduled Maintenance List</span>
                            </div>
                            <div class="table-responsive">
                                <table class="table custom-driver-table" id="bdet-maint-table">
                                    <thead>
                                        <tr>
                                            <th>Vehicle Number &amp; Driver</th>
                                            <th>Maintenance Type</th>
                                            <th>Scheduled KM &amp; Date</th>
                                            <th>Status</th>
                                            <th>Actual KM &amp; Date</th>
                                            <th>Cost</th>
                                            <th>Attachments</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="bdet-maint-tbody">
                                        @forelse($maintenanceSchedules as $ms)
                                        @php
                                            $msVehNo  = $ms->vehicle->basicinfo->vehicle_number ?? '—';
                                            $msDriver = $ms->vehicle->driverAllocation->contact->contact_name ?? '—';
                                            $msBadgeMap = [
                                                'Completed' => 'badge-success',
                                                'Done'      => 'badge-success',
                                                'Missed'    => 'badge-danger',
                                                'Overdue'   => 'badge-danger',
                                                'Pending'   => 'badge-warning',
                                                'Upcoming'  => 'badge-info',
                                                'Scheduled' => 'badge-primary',
                                            ];
                                        @endphp
                                        <tr id="bdet-maint-row-{{ $ms->id }}"
                                            data-vehicle="{{ strtolower($msVehNo) }}"
                                            data-type="{{ strtolower($ms->maintenance_type ?? '') }}"
                                            data-status="{{ strtolower($ms->status) }}"
                                            data-date="{{ $ms->next_due_date ? $ms->next_due_date->format('Y-m-d') : '' }}">
                                            <td>
                                                <span class="fw-semibold d-block">{{ $msVehNo }}</span>
                                                <small class="text-muted">{{ $msDriver }}</small>
                                            </td>
                                            <td>
                                                @if($ms->maintenance_type)
                                                    <span class="badge badge-secondary">{{ $ms->maintenance_type }}</span>
                                                @else
                                                    <span class="text-muted">{{ $ms->maintenance_item ?? '—' }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="d-block">{{ $ms->scheduled_km ? number_format($ms->scheduled_km) . ' KM' : '—' }}</span>
                                                <small class="text-muted">{{ $ms->next_due_date ? $ms->next_due_date->format('d-m-Y') : '—' }}</small>
                                            </td>
                                            <td>
                                                <span class="badge {{ $msBadgeMap[$ms->status] ?? 'badge-secondary' }}">{{ $ms->status }}</span>
                                            </td>
                                            <td>
                                                <span class="d-block">{{ $ms->actual_km ? number_format($ms->actual_km) . ' KM' : '—' }}</span>
                                                <small class="text-muted">{{ $ms->last_done_date ? $ms->last_done_date->format('d-m-Y') : '—' }}</small>
                                            </td>
                                            <td>{{ $ms->cost ? '₹' . number_format($ms->cost, 2) : '—' }}</td>
                                            <td><span class="text-muted small">—</span></td>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="text-success bdet-maint-edit"
                                                   data-id="{{ $ms->id }}"
                                                   data-item="{{ $ms->maintenance_item }}"
                                                   data-type="{{ $ms->maintenance_type }}"
                                                   data-vehicle="{{ $ms->vehicle_id }}"
                                                   data-last-done="{{ $ms->last_done_date ? $ms->last_done_date->format('d/m/Y') : '' }}"
                                                   data-next-due="{{ $ms->next_due_date ? $ms->next_due_date->format('d/m/Y') : '' }}"
                                                   data-odometer="{{ $ms->odometer_km }}"
                                                   data-scheduled-km="{{ $ms->scheduled_km }}"
                                                   data-actual-km="{{ $ms->actual_km }}"
                                                   data-cost="{{ $ms->cost }}"
                                                   data-status="{{ $ms->status }}"
                                                   data-notes="{{ $ms->notes }}"
                                                   data-update-url="{{ route('inventory.battery.maintenance.update', $ms->id) }}"
                                                   data-bs-toggle="modal" data-bs-target="#bdet-edit-maintenance">
                                                    <i class="uil uil-pen me-2"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr id="bdet-maint-empty-row">
                                            <td colspan="8" class="text-center text-muted py-4">
                                                <i class="uil uil-calendar-slash fs-4 d-block mb-1"></i>
                                                No maintenance schedules yet. Click <strong>Schedule Maintenance</strong> to add one.
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>{{-- end #bdet-pills-maint --}}

                    {{-- ── Sub-tab: Repair ── --}}
                    <div class="tab-pane fade" id="bdet-pills-repair" role="tabpanel" aria-labelledby="bdet-pills-repair-tab">

                        {{-- Filter --}}
                        <div class="accordion mt-3" id="bdet-accord-repair">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="bdet-head-repair">
                                    <button class="accordion-button filter-options" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#bdet-collapse-repair"
                                            aria-expanded="true" aria-controls="bdet-collapse-repair">
                                        <div class="item-filter">
                                            <span class="filter-icon">
                                                <img src="{{ asset('images/icons/filter-01icon.png') }}" alt="icon" />
                                            </span>
                                            <p>Filter Options</p>
                                        </div>
                                    </button>
                                </h2>
                                <div id="bdet-collapse-repair" class="accordion-collapse collapse show"
                                     aria-labelledby="bdet-head-repair" data-bs-parent="#bdet-accord-repair">
                                    <div class="accordion-body">
                                        <form id="bdet-repair-filter-form">
                                            <div class="filtersearch-bd justify-content-between flex-wrap gap-2">
                                                <div class="vehicletype">
                                                    <label>Date Range</label>
                                                    <input type="text" class="form-control" id="bdet-rep-filter-daterange" placeholder="Select date range..." />
                                                </div>
                                                <div class="vehicletype ms-1">
                                                    <label>Repair Category</label>
                                                    <select class="form-select" id="bdet-rep-filter-category">
                                                        <option value="">All</option>
                                                        <option value="Major">Major</option>
                                                        <option value="Minor">Minor</option>
                                                    </select>
                                                </div>
                                                <div class="vehicletype ms-1 d-flex align-items-end">
                                                    <button class="btn btn-primary" type="button" id="bdet-rep-filter-reset">
                                                        <i class="uil uil-sync me-1"></i>Reset
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Repair List --}}
                        <div class="vehiclestable">
                            <div class="itemtop">
                                <span class="sec-title">Repair List</span>
                            </div>
                            <div class="table-responsive">
                                <table class="table custom-driver-table" id="bdet-repair-table">
                                    <thead>
                                        <tr>
                                            <th>Vehicle</th>
                                            <th>Repair Category</th>
                                            <th>Repair Type</th>
                                            <th>Cost</th>
                                            <th>Vendor</th>
                                            <th>Repair Date</th>
                                            <th>Repair KM</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="bdet-repair-tbody">
                                        @forelse($batteryRepairs as $rep)
                                        @php
                                            $repVehNo  = $rep->vehicle->basicinfo->vehicle_number ?? '—';
                                            $repVendor = $rep->vendor->contact_name ?? '—';
                                            $repCatBadge = $rep->repair_category === 'Major' ? 'badge-danger' : 'badge-warning';
                                        @endphp
                                        <tr id="bdet-repair-row-{{ $rep->id }}"
                                            data-category="{{ strtolower($rep->repair_category) }}"
                                            data-date="{{ $rep->repair_date ? $rep->repair_date->format('Y-m-d') : '' }}">
                                            <td><span class="fw-semibold">{{ $repVehNo }}</span></td>
                                            <td><span class="badge {{ $repCatBadge }}">{{ $rep->repair_category }}</span></td>
                                            <td>{{ $rep->repair_type }}</td>
                                            <td>{{ $rep->cost ? '₹ ' . number_format($rep->cost, 2) : '—' }}</td>
                                            <td>{{ $repVendor }}</td>
                                            <td>{{ $rep->repair_date ? $rep->repair_date->format('d-m-Y') : '—' }}</td>
                                            <td>{{ $rep->repair_km ? number_format($rep->repair_km) . ' KM' : '—' }}</td>
                                            <td class="text-center">
                                                <a href="javascript:void(0)"
                                                   class="text-success bdet-repair-edit-btn"
                                                   data-id="{{ $rep->id }}"
                                                   data-vehicle="{{ $rep->vehicle_id }}"
                                                   data-category="{{ $rep->repair_category }}"
                                                   data-type="{{ $rep->repair_type }}"
                                                   data-cost="{{ $rep->cost }}"
                                                   data-vendor="{{ $rep->vendor_id }}"
                                                   data-date="{{ $rep->repair_date ? $rep->repair_date->format('Y-m-d') : '' }}"
                                                   data-km="{{ $rep->repair_km }}"
                                                   data-notes="{{ $rep->notes }}"
                                                   data-update-url="{{ route('inventory.battery.repair.update', $rep->id) }}"
                                                   data-bs-toggle="modal" data-bs-target="#bdet-edit-repair">
                                                    <i class="uil uil-pen me-2"></i>
                                                </a>
                                                <a href="javascript:void(0)"
                                                   class="text-danger bdet-repair-delete-btn"
                                                   data-id="{{ $rep->id }}"
                                                   data-delete-url="{{ route('inventory.battery.repair.destroy', $rep->id) }}">
                                                    <i class="uil uil-trash-alt"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr id="bdet-repair-empty-row">
                                            <td colspan="8" class="text-center text-muted py-4">
                                                <i class="uil uil-wrench fs-4 d-block mb-1"></i>
                                                No repair records found. Click <strong>Add Repair</strong> to add one.
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>{{-- end #bdet-pills-repair --}}

                </div>{{-- end tab-content --}}

            </div>
            {{-- ══════════════ END TAB: MAINTENANCE ══════════════ --}}

            {{-- ══════════════ TAB: DOCUMENTS ══════════════ --}}
            <div class="tab-pane fade" id="bdet-tab-docs">

                {{-- Stat Cards --}}
                <div class="totalrevenue mt-3">
                    <div class="item-row">
                        <div class="itemcol">
                            <p>Total Document</p>
                            <span class="number c-01">{{ $total_doc_count }}</span>
                        </div>
                        <div class="itemcol">
                            <p>Expired</p>
                            <span class="number c-02">{{ $expired_doc_count }}</span>
                        </div>
                        <div class="itemcol">
                            <p>Expiring Soon</p>
                            <span class="number c-03">{{ $expiring_doc_count }}</span>
                        </div>
                        <div class="itemcol">
                            <p>Valid</p>
                            <span class="number c-04">{{ $total_doc_count - $expired_doc_count }}</span>
                        </div>
                    </div>
                </div>

                {{-- Document Table --}}
                <div class="vehiclestable">
                    <div class="itemtop">
                        <span class="sec-title">Battery Documents</span>
                        <a href="#" class="addtripbtn" data-bs-toggle="modal" data-bs-target="#bdet-add-document">
                            <i class="uil uil-plus me-1"></i>Documents
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table custom-driver-table">
                            <thead>
                                <tr>
                                    <th style="min-width:120px">Document Type</th>
                                    <th style="min-width:120px">Document Number</th>
                                    <th>Issue Date</th>
                                    <th>Expiry Date</th>
                                    <th>Status</th>
                                    <th>Notes</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($mediadocuments as $mediadocument)
                                    @php
                                        $medias = $mediadocument->medias;
                                        $files  = $medias->map(function ($media) {
                                            $media->url        = asset('medias/' . $media->file_path);
                                            $media->delete_url = route('inventory.battery.document.destroy', $media->id);
                                            return $media;
                                        });
                                    @endphp
                                    <tr>
                                        <td><span class="value">{{ $mediadocument->attachmenttype->name }}</span></td>
                                        <td><span class="value">{{ $mediadocument->document_number }}</span></td>
                                        <td><span class="value">{{ date('d/m/Y', strtotime($mediadocument->issue_date)) }}</span></td>
                                        <td><span class="value">{{ $mediadocument->expiry_date ? date('d/m/Y', strtotime($mediadocument->expiry_date)) : '-' }}</span></td>
                                        <td>
                                            @if($mediadocument->expiry_date)
                                                @if(date('Y-m-d', strtotime($mediadocument->expiry_date)) > date('Y-m-d', strtotime('+10days')))
                                                    <span class="badge badge-success">Active</span>
                                                @elseif(date('Y-m-d', strtotime($mediadocument->expiry_date)) >= date('Y-m-d'))
                                                    <span class="badge badge-warning">Expiring Soon</span>
                                                @else
                                                    <span class="badge badge-danger">Expired</span>
                                                @endif
                                            @else
                                                <span class="badge badge-secondary">N/A</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="value">
                                                @if(!empty($mediadocument->notes))
                                                    {{ \Illuminate\Support\Str::limit($mediadocument->notes, 20, '...') }}
                                                    @if(strlen($mediadocument->notes) > 20)
                                                        <a href="javascript:void(0)" class="showMore"
                                                           data-bs-toggle="modal" data-bs-target="#bdet-modal-notes"
                                                           data-notes="{{ $mediadocument->notes }}">
                                                            <i class="uil uil-eye"></i>
                                                        </a>
                                                    @endif
                                                @else
                                                    N/A
                                                @endif
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <a href="javascript:void(0)" class="text-info view-files"
                                               data-files='@json($files)'><i class="uil uil-document-info"></i></a>
                                            <a href="javascript:void(0)" class="item-edit text-success"
                                               data-url="{{ route('inventory.battery.document.update', $mediadocument->id) }}"
                                               data-attachment_type="{{ $mediadocument->attachmenttype->name }}"
                                               data-document_number="{{ $mediadocument->document_number }}"
                                               data-issue_date="{{ \Carbon\Carbon::parse($mediadocument->issue_date)->format('d/m/Y') }}"
                                               data-expiry_date="{{ $mediadocument->expiry_date ? \Carbon\Carbon::parse($mediadocument->expiry_date)->format('d/m/Y') : '' }}"
                                               data-notes="{{ $mediadocument->notes }}"
                                               data-reminder_days="{{ $mediadocument->reminder_days ?? '' }}"
                                               data-has_reminder="{{ $mediadocument->set_reminder }}"
                                               data-bs-toggle="modal" data-bs-target="#bdet-edit-document">
                                                <i class="uil uil-pen me-2"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-3">No documents found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>{{-- end table-responsive --}}
                </div>{{-- end vehiclestable --}}

            </div>{{-- end #bdet-tab-docs --}}

            {{-- ══════════════ TAB: COMMENTS ══════════════ --}}
            <div class="tab-pane fade vdtl_comment1sec" id="bdet-tab-comments">
                <div class="note-box">
                    <label for="bdet-noteInput" class="form-label">Comments<i class="bi bi-info-circle"></i></label>

                    <form action="{{ route('inventory.battery.comment.store', $battery->id) }}" id="bdet-commentForm">
                        <div class="note-input-wrapper">
                            @csrf
                            <div class="note-avatar">{{ strtoupper(Auth::user()->name[0]) }}</div>
                            <div class="note-input-area">
                                <input type="text" id="bdet-noteInput" class="form-control" placeholder="Comments" name="comment" />
                                <span class="text-danger error" id="bdet-comment_error"></span>
                            </div>
                            <button type="submit" class="note-send-btn submitBtn"><i class="bi bi-send"></i></button>
                        </div>
                    </form>

                    <div class="text_bdwrapper">
                        @forelse($comments as $comment)
                            <div class="item_row">
                                <div class="name_fw">{{ strtoupper($comment->createdBy->name[0]) }}</div>
                                <div class="text_bd">
                                    <span>{{ $comment->createdBy->name }}</span>
                                    <p>{{ $comment->comment }}</p>
                                </div>
                                <div class="time_sec">{{ $comment->created_at->diffForHumans() }}</div>
                            </div>
                        @empty
                        @endforelse
                    </div>
                </div>
            </div>
            {{-- ══════════════ END TAB: COMMENTS ══════════════ --}}

                    </div>{{-- end tab-content --}}
                </div>{{-- end container-fluid --}}
            </div>{{-- end vehicle-itemtab --}}

        </div>{{-- end main-wrap --}}
    </div>{{-- end wrapper --}}
</div>{{-- end layout-wrapper --}}
@endsection

{{-- ══════════════════════════════════════════════════════════════════════
     ADD DOCUMENT MODAL  #bdet-add-document
     ══════════════════════════════════════════════════════════════════════ --}}
<div class="modal fade expenses_wrapperModal" id="bdet-add-document" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="uil uil-file-plus me-2"></i>Add Document</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="uil uil-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('inventory.battery.document.store', $battery->id) }}" id="documentForm">
                    @csrf
                    <div class="row">

                        <div class="col-12 col-md-6 form-group">
                            <label>Battery<span class="text-danger ms-1">*</span></label>
                            <input type="text" class="form-control bg-light" readonly value="{{ $battery->battery_serial }}" />
                        </div>

                        <div class="col-12 col-md-6 form-group">
                            <label>Document Type<span class="text-danger ms-1">*</span></label>
                            <select name="attachment_type" class="form-select" id="attachmenttype_dd">
                                <option value="">Search Document Type...</option>
                                @forelse($attachmenttypes as $attachmenttype)
                                    <option value="{{ $attachmenttype->name }}">{{ $attachmenttype->name }}</option>
                                @empty
                                @endforelse
                            </select>
                            <div class="error text-danger" id="document_attachment_type_error"></div>
                        </div>

                        <div class="col-12 col-md-6 form-group">
                            <label>Document Number</label>
                            <input type="text" class="form-control" name="document_number" placeholder="" />
                            <div class="error text-danger" id="document_document_number_error"></div>
                        </div>

                        <div class="col-12 col-md-6 form-group">
                            <label>Issue Date</label>
                            <div class="input-group">
                                <input class="date form-control" type="text" id="doc_issue_date" name="issue_date" readonly />
                                <span class="input-group-text"><i class="uil uil-calendar-alt"></i></span>
                            </div>
                            <div class="error text-danger" id="document_issue_date_error"></div>
                        </div>

                        <div class="col-12 col-md-6 form-group">
                            <label>Expiry Date</label>
                            <div class="input-group">
                                <input class="date form-control" type="text" id="doc_expiry_date" name="expiry_date" readonly />
                                <span class="input-group-text"><i class="uil uil-calendar-alt"></i></span>
                            </div>
                            <div class="error text-danger" id="document_expiry_date_error"></div>
                        </div>

                        <div class="col-12 col-md-6 form-group">
                            <label>Upload File(s)<span class="text-danger ms-1">*</span></label>
                            <div class="dropzone" id="myDropzone">
                                <div class="dz-message needsclick">
                                    <i class="uil uil-upload me-2"></i>
                                    Drop files here or click to upload (Max 2 files)
                                </div>
                            </div>
                            <div class="error text-danger" id="document_files_error"></div>
                        </div>

                        <div class="col-12 form-group">
                            <div class="d-flex align-items-center gap-2">
                                <input class="form-check-input clickto-adclass" name="set_reminder" type="checkbox" id="setReminder" />
                                <label class="mb-0">Set Reminder</label>
                            </div>
                            <div class="days-beforeexpiry mt-2" style="display:none;">
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <label>Remind Before Days <span class="text-danger">*</span></label>
                                        <select class="form-select" name="reminder_days">
                                            <option value="">Choose...</option>
                                            <option value="7">7 Days</option>
                                            <option value="10">10 Days</option>
                                            <option value="20">20 Days</option>
                                        </select>
                                        <div class="error text-danger" id="document_reminder_days_error"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 form-group">
                            <label>Notes</label>
                            <textarea class="form-control" rows="3" name="notes"></textarea>
                            <div class="error text-danger" id="document_notes_error"></div>
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary docSubmitForm">Save</button>
            </div>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════════════════════
     EDIT DOCUMENT MODAL  #bdet-edit-document
     ══════════════════════════════════════════════════════════════════════ --}}
<div class="modal fade expenses_wrapperModal" id="bdet-edit-document" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="uil uil-file-edit-alt me-2"></i>Edit Document</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="uil uil-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="" id="editDocumentForm">
                    @csrf
                    <div class="row">

                        <div class="col-12 col-md-6 form-group">
                            <label>Battery<span class="text-danger ms-1">*</span></label>
                            <input type="text" class="form-control bg-light" readonly value="{{ $battery->battery_serial }}" />
                        </div>

                        <div class="col-12 col-md-6 form-group">
                            <label>Document Type<span class="text-danger ms-1">*</span></label>
                            <select name="attachment_type" class="form-select" id="edit_attachmenttype_dd">
                                <option value="">Search Document Type...</option>
                                @forelse($attachmenttypes as $attachmenttype)
                                    <option value="{{ $attachmenttype->name }}">{{ $attachmenttype->name }}</option>
                                @empty
                                @endforelse
                            </select>
                            <div class="error text-danger" id="edit_document_attachment_type_error"></div>
                        </div>

                        <div class="col-12 col-md-6 form-group">
                            <label>Document Number</label>
                            <input type="text" class="form-control" name="document_number" placeholder="" />
                            <div class="error text-danger" id="edit_document_document_number_error"></div>
                        </div>

                        <div class="col-12 col-md-6 form-group">
                            <label>Issue Date</label>
                            <div class="input-group">
                                <input class="date form-control" type="text" id="edit_doc_issue_date" name="issue_date" readonly />
                                <span class="input-group-text"><i class="uil uil-calendar-alt"></i></span>
                            </div>
                            <div class="error text-danger" id="edit_document_issue_date_error"></div>
                        </div>

                        <div class="col-12 col-md-6 form-group">
                            <label>Expiry Date</label>
                            <div class="input-group">
                                <input class="date form-control" type="text" id="edit_doc_expiry_date" name="expiry_date" readonly />
                                <span class="input-group-text"><i class="uil uil-calendar-alt"></i></span>
                            </div>
                            <div class="error text-danger" id="edit_document_expiry_date_error"></div>
                        </div>

                        <div class="col-12 col-md-6 form-group">
                            <label>Upload File(s) <span class="text-muted small">(optional — add more files)</span></label>
                            <div class="dropzone" id="edit_myDropzone">
                                <div class="dz-message needsclick">
                                    <i class="uil uil-upload me-2"></i>
                                    Drop files here or click to upload (Max 2 files)
                                </div>
                            </div>
                            <div class="error text-danger" id="edit_document_files_error"></div>
                        </div>

                        <div class="col-12 form-group">
                            <div class="d-flex align-items-center gap-2">
                                <input class="form-check-input" name="set_reminder" type="checkbox" id="edit_setReminder" />
                                <label class="mb-0">Set Reminder</label>
                            </div>
                            <div class="days-beforeexpiry mt-2" id="edit_reminder_wrap" style="display:none;">
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <label>Remind Before Days <span class="text-danger">*</span></label>
                                        <select class="form-select" id="edit_reminder_days" name="reminder_days">
                                            <option value="">Choose...</option>
                                            <option value="7">7 Days</option>
                                            <option value="10">10 Days</option>
                                            <option value="20">20 Days</option>
                                        </select>
                                        <div class="error text-danger" id="edit_document_reminder_days_error"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 form-group">
                            <label>Notes</label>
                            <textarea class="form-control" rows="3" name="notes" id="edit_document_notes"></textarea>
                            <div class="error text-danger" id="edit_document_notes_error"></div>
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary editDocSubmitForm">Save</button>
            </div>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════════════════════
     ADD MAINTENANCE MODAL  #bdet-add-maintenance
     ══════════════════════════════════════════════════════════════════════ --}}
<div class="modal fade expenses_wrapperModal" id="bdet-add-maintenance" tabindex="-1" aria-labelledby="bdetMaintModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bdetMaintModalLabel">
                    <i class="uil uil-wrench me-2"></i>Schedule Maintenance &mdash;
                    <span class="text-muted fw-normal fs-6">{{ $battery->battery_serial }}</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="uil uil-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="bdet-maint-form" action="{{ route('inventory.battery.maintenance.store', $battery->id) }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-12 col-md-6 form-group">
                            <label class="form-label">Maintenance Item <span class="text-danger">*</span></label>
                            <input type="text" id="maint_item" name="maintenance_item" class="form-control"
                                   placeholder="e.g. Voltage Check, Charging, Terminal Cleaning" />
                            <span class="text-danger small d-block mt-1" id="maint_item_err"></span>
                        </div>
                        <div class="col-12 col-md-6 form-group">
                            <label class="form-label">Maintenance Type</label>
                            <select class="form-select" id="maint_type" name="maintenance_type">
                                <option value="">Select Type...</option>
                                <option value="Inspection">Inspection</option>
                                <option value="Charging">Charging</option>
                                <option value="Replacement">Replacement</option>
                                <option value="Other">Other</option>
                            </select>
                            <span class="text-danger small d-block mt-1" id="maint_type_err"></span>
                        </div>
                        <div class="col-12 col-md-6 form-group">
                            <label class="form-label">Last Done Date</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="maint_last_done" name="last_done_date" readonly placeholder="DD/MM/YYYY" />
                                <span class="input-group-text"><i class="uil uil-calendar-alt"></i></span>
                            </div>
                            <span class="text-danger small d-block mt-1" id="maint_last_done_err"></span>
                        </div>
                        <div class="col-12 col-md-6 form-group">
                            <label class="form-label">Next Due Date</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="maint_next_due" name="next_due_date" readonly placeholder="DD/MM/YYYY" />
                                <span class="input-group-text"><i class="uil uil-calendar-alt"></i></span>
                            </div>
                            <span class="text-danger small d-block mt-1" id="maint_next_due_err"></span>
                        </div>
                        <div class="col-12 col-md-4 form-group">
                            <label class="form-label">Odometer (KM)</label>
                            <input type="number" class="form-control" name="odometer_km" placeholder="e.g. 50000" min="0" />
                        </div>
                        <div class="col-12 col-md-4 form-group">
                            <label class="form-label">Scheduled KM</label>
                            <input type="number" class="form-control" name="scheduled_km" placeholder="e.g. 60000" min="0" />
                        </div>
                        <div class="col-12 col-md-4 form-group">
                            <label class="form-label">Cost (₹)</label>
                            <input type="number" class="form-control" name="cost" placeholder="e.g. 500" min="0" step="0.01" />
                        </div>
                        <div class="col-12 col-md-6 form-group">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select" id="maint_status" name="status">
                                <option value="">Select Status...</option>
                                <option value="Scheduled">Scheduled</option>
                                <option value="Upcoming">Upcoming</option>
                                <option value="Pending">Pending</option>
                                <option value="Done">Done</option>
                                <option value="Completed">Completed</option>
                                <option value="Overdue">Overdue</option>
                                <option value="Missed">Missed</option>
                            </select>
                            <span class="text-danger small d-block mt-1" id="maint_status_err"></span>
                        </div>
                        <div class="col-12 form-group">
                            <label class="form-label">Notes</label>
                            <textarea class="form-control" name="notes" rows="3" placeholder="Optional notes..."></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="bdet-maint-save-btn">
                    <span id="bdet-maint-save-txt">Save Schedule</span>
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════════════════════
     EDIT MAINTENANCE MODAL  #bdet-edit-maintenance
     ══════════════════════════════════════════════════════════════════════ --}}
<div class="modal fade expenses_wrapperModal" id="bdet-edit-maintenance" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="uil uil-pen me-2"></i>Edit Maintenance &mdash;
                    <span class="text-muted fw-normal fs-6">{{ $battery->battery_serial }}</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="uil uil-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="bdet-maint-edit-form" action="">
                    @csrf
                    <div class="row g-3">
                        <div class="col-12 col-md-6 form-group">
                            <label class="form-label">Maintenance Item <span class="text-danger">*</span></label>
                            <input type="text" id="edit_maint_item" name="maintenance_item" class="form-control"
                                   placeholder="e.g. Voltage Check, Charging, Terminal Cleaning" />
                            <span class="text-danger small d-block mt-1" id="edit_maint_item_err"></span>
                        </div>
                        <div class="col-12 col-md-6 form-group">
                            <label class="form-label">Maintenance Type</label>
                            <select class="form-select" id="edit_maint_type" name="maintenance_type">
                                <option value="">Select Type...</option>
                                <option value="Inspection">Inspection</option>
                                <option value="Charging">Charging</option>
                                <option value="Replacement">Replacement</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-6 form-group">
                            <label class="form-label">Last Done Date</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="edit_maint_last_done" name="last_done_date" readonly placeholder="DD/MM/YYYY" />
                                <span class="input-group-text"><i class="uil uil-calendar-alt"></i></span>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 form-group">
                            <label class="form-label">Next Due Date</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="edit_maint_next_due" name="next_due_date" readonly placeholder="DD/MM/YYYY" />
                                <span class="input-group-text"><i class="uil uil-calendar-alt"></i></span>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 form-group">
                            <label class="form-label">Odometer (KM)</label>
                            <input type="number" class="form-control" id="edit_maint_odometer" name="odometer_km" min="0" />
                        </div>
                        <div class="col-12 col-md-4 form-group">
                            <label class="form-label">Scheduled KM</label>
                            <input type="number" class="form-control" id="edit_maint_scheduled_km" name="scheduled_km" min="0" />
                        </div>
                        <div class="col-12 col-md-4 form-group">
                            <label class="form-label">Cost (₹)</label>
                            <input type="number" class="form-control" id="edit_maint_cost" name="cost" min="0" step="0.01" />
                        </div>
                        <div class="col-12 col-md-6 form-group">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select" id="edit_maint_status" name="status">
                                <option value="">Select Status...</option>
                                <option value="Scheduled">Scheduled</option>
                                <option value="Upcoming">Upcoming</option>
                                <option value="Pending">Pending</option>
                                <option value="Done">Done</option>
                                <option value="Completed">Completed</option>
                                <option value="Overdue">Overdue</option>
                                <option value="Missed">Missed</option>
                            </select>
                            <span class="text-danger small d-block mt-1" id="edit_maint_status_err"></span>
                        </div>
                        <div class="col-12 form-group">
                            <label class="form-label">Notes</label>
                            <textarea class="form-control" id="edit_maint_notes" name="notes" rows="3"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="bdet-maint-update-btn">
                    <span id="bdet-maint-update-txt">Update Schedule</span>
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════════════════════
     ADD REPAIR MODAL  #bdet-add-repair
     ══════════════════════════════════════════════════════════════════════ --}}
<div class="modal fade expenses_wrapperModal" id="bdet-add-repair" tabindex="-1" aria-labelledby="bdetRepairModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bdetRepairModalLabel">
                    <i class="uil uil-wrench me-2"></i>Add Repair &mdash;
                    <span class="text-muted fw-normal fs-6">{{ $battery->battery_serial }}</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="uil uil-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="bdet-repair-form" action="{{ route('inventory.battery.repair.store', $battery->id) }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-12 col-md-6 form-group">
                            <label class="form-label">Repair Category <span class="text-danger">*</span></label>
                            <select class="form-select" id="rep_category" name="repair_category">
                                <option value="">Select Category...</option>
                                <option value="Major">Major</option>
                                <option value="Minor">Minor</option>
                            </select>
                            <span class="text-danger small d-block mt-1" id="rep_category_err"></span>
                        </div>
                        <div class="col-12 col-md-6 form-group">
                            <label class="form-label">Repair Type <span class="text-danger">*</span></label>
                            <select class="form-select" id="rep_type" name="repair_type">
                                <option value="">Select Type...</option>
                                <option value="Terminal Cleaning">Terminal Cleaning</option>
                                <option value="Electrolyte Top-up">Electrolyte Top-up</option>
                                <option value="Cell Replacement">Cell Replacement</option>
                                <option value="Reconditioning">Reconditioning</option>
                                <option value="Other">Other</option>
                            </select>
                            <span class="text-danger small d-block mt-1" id="rep_type_err"></span>
                        </div>
                        <div class="col-12 col-md-6 form-group">
                            <label class="form-label">Repair Date</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="rep_date" name="repair_date" readonly placeholder="DD/MM/YYYY" />
                                <span class="input-group-text"><i class="uil uil-calendar-alt"></i></span>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 form-group">
                            <label class="form-label">Repair KM</label>
                            <input type="number" class="form-control" name="repair_km" placeholder="e.g. 50000" min="0" />
                        </div>
                        <div class="col-12 col-md-6 form-group">
                            <label class="form-label">Cost (₹)</label>
                            <input type="number" class="form-control" name="cost" placeholder="e.g. 500" min="0" step="0.01" />
                        </div>
                        <div class="col-12 form-group">
                            <label class="form-label">Notes</label>
                            <textarea class="form-control" name="notes" rows="3" placeholder="Optional notes..."></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="bdet-repair-save-btn">
                    <span id="bdet-repair-save-txt">Save Repair</span>
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════════════════════
     EDIT REPAIR MODAL  #bdet-edit-repair
     ══════════════════════════════════════════════════════════════════════ --}}
<div class="modal fade expenses_wrapperModal" id="bdet-edit-repair" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="uil uil-pen me-2"></i>Edit Repair &mdash;
                    <span class="text-muted fw-normal fs-6">{{ $battery->battery_serial }}</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="uil uil-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="bdet-repair-edit-form" action="">
                    @csrf
                    <div class="row g-3">
                        <div class="col-12 col-md-6 form-group">
                            <label class="form-label">Repair Category <span class="text-danger">*</span></label>
                            <select class="form-select" id="edit_rep_category" name="repair_category">
                                <option value="">Select Category...</option>
                                <option value="Major">Major</option>
                                <option value="Minor">Minor</option>
                            </select>
                            <span class="text-danger small d-block mt-1" id="edit_rep_category_err"></span>
                        </div>
                        <div class="col-12 col-md-6 form-group">
                            <label class="form-label">Repair Type <span class="text-danger">*</span></label>
                            <select class="form-select" id="edit_rep_type" name="repair_type">
                                <option value="">Select Type...</option>
                                <option value="Terminal Cleaning">Terminal Cleaning</option>
                                <option value="Electrolyte Top-up">Electrolyte Top-up</option>
                                <option value="Cell Replacement">Cell Replacement</option>
                                <option value="Reconditioning">Reconditioning</option>
                                <option value="Other">Other</option>
                            </select>
                            <span class="text-danger small d-block mt-1" id="edit_rep_type_err"></span>
                        </div>
                        <div class="col-12 col-md-6 form-group">
                            <label class="form-label">Repair Date</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="edit_rep_date" name="repair_date" readonly placeholder="DD/MM/YYYY" />
                                <span class="input-group-text"><i class="uil uil-calendar-alt"></i></span>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 form-group">
                            <label class="form-label">Repair KM</label>
                            <input type="number" class="form-control" id="edit_rep_km" name="repair_km" min="0" />
                        </div>
                        <div class="col-12 col-md-6 form-group">
                            <label class="form-label">Cost (₹)</label>
                            <input type="number" class="form-control" id="edit_rep_cost" name="cost" min="0" step="0.01" />
                        </div>
                        <div class="col-12 form-group">
                            <label class="form-label">Notes</label>
                            <textarea class="form-control" id="edit_rep_notes" name="notes" rows="3"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="bdet-repair-update-btn">
                    <span id="bdet-repair-update-txt">Update Repair</span>
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Notes modal --}}
<div class="modal fade" id="bdet-modal-notes" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Notes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p id="bdet-modal-notes-content"></p>
            </div>
        </div>
    </div>
</div>

{{-- File preview modal --}}
<div class="modal fade" id="filePreviewModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Uploaded Documents</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row mt-2 attachment-container" id="filePreviewContainer1"></div>
            </div>
        </div>
    </div>
</div>

@section('js')
{{-- Config injected via data-* (SD-1 compliant) --}}
<div id="batteryDetailsConfig"
     data-pdf-logo="{{ asset('images/pdf_file.png') }}"
     data-other-logo="{{ asset('images/other_file.svg') }}"
     data-csrf="{{ csrf_token() }}"
     data-maint-store-url="{{ route('inventory.battery.maintenance.store', $battery->id) }}"
     data-repair-store-url="{{ route('inventory.battery.repair.store', $battery->id) }}"
     style="display:none;"></div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>
<script src="{{ asset('js/inventory/battery-details.js?v=4.1') }}"></script>
@endsection
                                 