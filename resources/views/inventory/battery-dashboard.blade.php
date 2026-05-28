@extends('layouts.app')

@section('css')
<link href="{{ asset('css/Inventory/battery-dashboard.css?v=3.6') }}" rel="stylesheet">
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
                    <li class="breadcrumb-item active">Battery Dashboard</li>
                </ol>
            </nav>

            {{-- Location Context Bar --}}
            <div class="btd-loc-bar">
                <div class="btd-loc-bar-left">
                    <i class="uil uil-map-marker btd-loc-icon"></i>
                    <span class="btd-loc-label">Location</span>
                    <span class="btd-loc-divider"></span>
                    <div class="btd-loc-pills" id="batLocPills">
                        <button class="btd-loc-pill active" data-loc="">All</button>
                        <button class="btd-loc-pill" data-loc="WH-BLR">
                            <span class="btd-loc-pill-type">WH</span> Bangalore
                        </button>
                        <button class="btd-loc-pill" data-loc="WH-HYD">
                            <span class="btd-loc-pill-type">WH</span> Hyderabad
                        </button>
                        <button class="btd-loc-pill" data-loc="WH-PNE">
                            <span class="btd-loc-pill-type">WH</span> Pune
                        </button>
                        <button class="btd-loc-pill" data-loc="WS-BLR">
                            <span class="btd-loc-pill-type btd-loc-ws">WS</span> Bangalore
                        </button>
                        <button class="btd-loc-pill" data-loc="WS-HYD">
                            <span class="btd-loc-pill-type btd-loc-ws">WS</span> Hyderabad
                        </button>
                    </div>
                </div>
                <div class="btd-loc-bar-right">
                    <i class="uil uil-sync btd-loc-sync-icon"></i>
                    <span>Live across all locations</span>
                </div>
            </div>

            {{-- Page Header --}}
            <div class="sc-page-head d-flex align-items-center justify-content-between mb-3">
                <div>
                    <h5 class="mb-0"><i class="uil uil-bolt-alt me-2" style="color:#032671;"></i>Battery Dashboard</h5>
                    <span class="text-muted" style="font-size:12px;">Track every battery from purchase to discard — lifecycle, location, condition &amp; history</span>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('inventory.batteries') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="uil uil-list-ul me-1"></i>Battery Inventory
                    </a>
                    <a href="{{ route('inventory.purchase-orders') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="uil uil-shopping-cart me-1"></i>Raise PO
                    </a>
                    <a href="{{ route('inventory.battery.add') }}" class="btn sc-btn-navy btn-sm">
                        <i class="uil uil-plus me-1"></i>Add Battery
                    </a>
                </div>
            </div>

            {{-- Lifecycle Flow Strip --}}
            {{--
            <div class="btd-lifecycle mb-3">
                <div class="btd-lc-step">
                    <div class="btd-lc-icon"><i class="uil uil-shopping-cart"></i></div>
                    <span class="btd-lc-label">Purchased</span>
                </div>
                <i class="uil uil-angle-right btd-lc-arrow"></i>
                <div class="btd-lc-step">
                    <div class="btd-lc-icon"><i class="uil uil-bolt-alt"></i></div>
                    <span class="btd-lc-label">Install</span>
                </div>
                <i class="uil uil-angle-right btd-lc-arrow"></i>
                <div class="btd-lc-step">
                    <div class="btd-lc-icon"><i class="uil uil-truck"></i></div>
                    <span class="btd-lc-label">In Use</span>
                </div>
                <i class="uil uil-angle-right btd-lc-arrow"></i>
                <div class="btd-lc-step">
                    <div class="btd-lc-icon"><i class="uil uil-arrow-down"></i></div>
                    <span class="btd-lc-label">Removed</span>
                </div>
                <i class="uil uil-angle-right btd-lc-arrow"></i>
                <div class="btd-lc-step">
                    <div class="btd-lc-icon"><i class="uil uil-wrench"></i></div>
                    <span class="btd-lc-label">Repair</span>
                </div>
                <i class="uil uil-angle-right btd-lc-arrow"></i>
                <div class="btd-lc-step">
                    <div class="btd-lc-icon"><i class="uil uil-sync"></i></div>
                    <span class="btd-lc-label">Reuse</span>
                </div>
                <i class="uil uil-angle-right btd-lc-arrow"></i>
                <div class="btd-lc-step">
                    <div class="btd-lc-icon"><i class="uil uil-trash-alt"></i></div>
                    <span class="btd-lc-label">Discarded</span>
                </div>
            </div>
            --}}

            {{-- Summary Stat Cards — two-row layout matching Tyre Dashboard --}}
            <div class="tyre-counters-wrap mb-3">

                @php
                    $pct = fn($n) => $all_count > 0 ? round($n * 100 / $all_count) : 0;

                    $row1 = [
                        ['count' => $all_count,            'label' => 'All Batteries',            'pct' => 100,                      'color' => 'tc-blue'],
                        ['count' => $allocated_count,      'label' => 'Allocated Batteries',      'pct' => $pct($allocated_count),   'color' => 'tc-indigo'],
                        ['count' => $direct_fitment_count, 'label' => 'Direct Fitment Batteries', 'pct' => $pct($direct_fitment_count), 'color' => 'tc-purple'],
                        ['count' => $yet_to_decide_count,  'label' => 'Yet to Decide Batteries',  'pct' => $pct($yet_to_decide_count),  'color' => 'tc-amber'],
                    ];

                    $row2 = [
                        ['count' => $ready_to_use_count,   'label' => 'Ready to Use',              'pct' => $pct($ready_to_use_count),   'color' => 'tc-green'],
                        ['count' => $warranty_claim_count, 'label' => 'Warranty Claim Batteries',  'pct' => $pct($warranty_claim_count), 'color' => 'tc-orange'],
                        ['count' => $repair_count,         'label' => 'Repair Batteries',          'pct' => $pct($repair_count),         'color' => 'tc-cyan'],
                        ['count' => $scrap_count,          'label' => 'Scrap Batteries',           'pct' => $pct($scrap_count),          'color' => 'tc-red'],
                    ];
                @endphp

                {{-- Row 1: 4 primary fleet counters --}}
                <div class="tyre-counters-row">
                    @foreach($row1 as $card)
                    <div class="tyre-counter-card {{ $card['color'] }}">
                        <div class="tc-body">
                            <div class="tc-count">{{ $card['count'] }}</div>
                            <div class="tc-label">{{ $card['label'] }}</div>
                        </div>
                        <div class="tc-footer">
                            <span class="tc-pct"><i class="uil uil-arrow-up-right"></i> {{ $card['pct'] }}%</span>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Row 2: SR Garage counters with section label --}}
                <div class="tyre-counters-section">
                    <div class="tc-section-header">
                        <span class="tc-section-badge"><i class="uil uil-building"></i> SR Garage</span>
                        <div class="tc-section-line"></div>
                    </div>
                    <div class="tyre-counters-row tyre-counters-row--garage">
                        @foreach($row2 as $card)
                        <div class="tyre-counter-card {{ $card['color'] }}">
                            <div class="tc-body">
                                <div class="tc-count">{{ $card['count'] }}</div>
                                <div class="tc-label">{{ $card['label'] }}</div>
                            </div>
                            <div class="tc-footer">
                                <span class="tc-pct"><i class="uil uil-arrow-up-right"></i> {{ $card['pct'] }}%</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>{{-- /tyre-counters-wrap --}}

            {{-- Secondary Metrics --}}
            <div class="btd-metrics">
                <span class="btd-metric-chip btd-metric-expiry">
                    <i class="uil uil-clock-three"></i>
                    Batteries Near Expiry
                    <span class="btd-metric-count">6</span>
                </span>
                <span class="btd-metric-chip btd-metric-warranty">
                    <i class="uil uil-shield-check"></i>
                    Under Warranty
                    <span class="btd-metric-count">18</span>
                </span>
                <span class="btd-metric-chip btd-metric-charging">
                    <i class="uil uil-bolt"></i>
                    Charging
                    <span class="btd-metric-count">3</span>
                </span>
                <span class="btd-metric-chip btd-metric-faulty">
                    <i class="uil uil-exclamation-triangle"></i>
                    Faulty
                    <span class="btd-metric-count">4</span>
                </span>
            </div>

            {{-- ══════════════════════════════════════════════════
                 8-TAB DASHBOARD — All Batteries, Ready, Warranty, Repair,
                 Scrap, Allocated, Direct Fitment, Yet to Decide
            ══════════════════════════════════════════════════ --}}
            <div class="right-side-wrap mt-0">
                <ul class="nav nav-pills mb-3 bat-tab-nav" id="bat-pills-tab" role="tablist">
                    @php
                        $batTabs = [
                            ['id' => 'bat-tab-all',      'label' => 'All Batteries',       'count' => $all_count],
                            ['id' => 'bat-tab-ready',    'label' => 'Ready to Use',         'count' => $ready_to_use_count],
                            ['id' => 'bat-tab-warranty', 'label' => 'Warranty Claim',       'count' => $warranty_claim_count],
                            ['id' => 'bat-tab-repair',   'label' => 'Repair Batteries',     'count' => $repair_count],
                            ['id' => 'bat-tab-scrap',    'label' => 'Scrap Batteries',      'count' => $scrap_count],
                            ['id' => 'bat-tab-allocated','label' => 'Allocated Batteries',  'count' => $allocated_count],
                            ['id' => 'bat-tab-direct',   'label' => 'Direct Fitment',       'count' => $direct_fitment_count],
                            ['id' => 'bat-tab-ytd',      'label' => 'Yet to Decide',        'count' => $yet_to_decide_count],
                        ];
                        $activeTab = $active_tab ?? 'bat-tab-all';
                    @endphp
                    @foreach($batTabs as $i => $tab)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link nav_click fleetTab {{ $tab['id'] === $activeTab ? 'active' : '' }}"
                                id="{{ $tab['id'] }}-tab"
                                data-bs-toggle="pill"
                                data-bs-target="#{{ $tab['id'] }}"
                                type="button" role="tab"
                                aria-controls="{{ $tab['id'] }}"
                                aria-selected="{{ $tab['id'] === $activeTab ? 'true' : 'false' }}">
                            {{ $tab['label'] }}
                        </button>
                    </li>
                    @endforeach
                </ul>

                <div class="tab-content" id="bat-pills-tabContent">

                    {{-- ══ TAB 1: ALL BATTERIES ══ --}}
                    <div class="tab-pane fade {{ $activeTab === 'bat-tab-all' ? 'show active' : '' }}" id="bat-tab-all" role="tabpanel">
                        <div class="accordion mt-2" id="acc-bat-tab1">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button filter-options" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-bat-tab1">
                                        <div class="item-filter"><div class="filter"><span class="filter-icon"><img src="{{ asset('images/icons/filter-01icon.png') }}" alt="icon"></span></div><p class="mb-0">Filter Options</p></div>
                                    </button>
                                </h2>
                                <div id="collapse-bat-tab1" class="accordion-collapse collapse show">
                                    <div class="accordion-body">
                                        <form method="GET" action="{{ route('inventory.battery-dashboard') }}" id="bat-filter-form-1" class="bat-filter-form">
                                            <input type="hidden" name="active_tab" value="bat-tab-all">
                                            <input type="hidden" name="sort" value="{{ $sort }}">
                                            <input type="hidden" name="direction" value="{{ $direction }}">
                                            <div class="filtersearch-bd flex-wrap">
                                                <div class="vehicletype ms-1">
                                                    <label>Battery Location</label>
                                                    <select class="form-select bat-filter-onchange" name="f1_location">
                                                        <option value="">All</option>
                                                        <option value="SR Garage" {{ request('f1_location') == 'SR Garage' ? 'selected' : '' }}>SR Garage</option>
                                                        <option value="Vehicle"   {{ request('f1_location') == 'Vehicle'   ? 'selected' : '' }}>Vehicle</option>
                                                    </select>
                                                </div>
                                                <div class="vehicletype ms-1">
                                                    <label>Battery Status</label>
                                                    <select class="form-select bat-filter-onchange" name="f1_status">
                                                        <option value="">All</option>
                                                        @foreach(['Ready to Use','Warranty Claim','Repair','Scrap','Allocated','Direct Fitment','Yet to Decide'] as $s)
                                                            <option value="{{ $s }}" {{ request('f1_status') == $s ? 'selected' : '' }}>{{ $s }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="vehicletype ms-1">
                                                    <label>Battery Capacity</label>
                                                    <select class="form-select bat-filter-onchange" name="f1_capacity">
                                                        <option value="">All</option>
                                                        @foreach($batteryCapacities as $cap)
                                                            <option value="{{ $cap }}" {{ request('f1_capacity') == $cap ? 'selected' : '' }}>{{ number_format($cap, 0) }} Ah</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="vehicletype ms-1">
                                                    <label>Battery Voltage</label>
                                                    <select class="form-select bat-filter-onchange" name="f1_voltage">
                                                        <option value="">All</option>
                                                        @foreach($batteryVoltages as $v)
                                                            <option value="{{ $v }}" {{ request('f1_voltage') == $v ? 'selected' : '' }}>{{ $v }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="vehicletype ms-1">
                                                    <label>Battery Condition</label>
                                                    <select class="form-select bat-filter-onchange" name="f1_condition">
                                                        <option value="">All</option>
                                                        <option value="New"                      {{ request('f1_condition') == 'New'                      ? 'selected' : '' }}>New</option>
                                                        <option value="Used"                     {{ request('f1_condition') == 'Used'                     ? 'selected' : '' }}>Used</option>
                                                        <option value="Replaced Under Warranty"  {{ request('f1_condition') == 'Replaced Under Warranty'  ? 'selected' : '' }}>Replaced Under Warranty</option>
                                                    </select>
                                                </div>
                                                <div class="vehicletype ms-1">
                                                    <label>RAG Status</label>
                                                    <select class="form-select bat-filter-onchange" name="f1_rag">
                                                        <option value="">All</option>
                                                        <option value="Green"  {{ request('f1_rag') == 'Green'  ? 'selected' : '' }}>🟢 Green</option>
                                                        <option value="Yellow" {{ request('f1_rag') == 'Yellow' ? 'selected' : '' }}>🟡 Yellow</option>
                                                        <option value="Red"    {{ request('f1_rag') == 'Red'    ? 'selected' : '' }}>🔴 Red</option>
                                                    </select>
                                                </div>
                                                <div class="vehicletype ms-1">
                                                    <label>Brand</label>
                                                    <select class="form-select bat-filter-onchange" name="f1_brand">
                                                        <option value="">All</option>
                                                        @foreach($batteryBrands as $brand)
                                                            <option value="{{ $brand }}" {{ request('f1_brand') == $brand ? 'selected' : '' }}>{{ $brand }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="vehicletype ms-1">
                                                    <label>Tracking Group</label>
                                                    <select class="form-select bat-filter-onchange" name="f1_tracking_group">
                                                        <option value="">All</option>
                                                        @foreach($vehicleGroups as $grp)
                                                            <option value="{{ $grp->id }}" {{ request('f1_tracking_group') == $grp->id ? 'selected' : '' }}>{{ $grp->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="vehicletype ms-1">
                                                    <label>Vendor</label>
                                                    <select class="form-select bat-filter-onchange" name="f1_vendor">
                                                        <option value="">All</option>
                                                        @foreach($batteryVendors as $v)
                                                            <option value="{{ $v->id }}" {{ request('f1_vendor') == $v->id ? 'selected' : '' }}>{{ $v->contact_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="filtersearch-bd justify-content-start mt-2">
                                                <div class="ms-1" style="width:230px;">
                                                    <div class="input-group">
                                                        <input type="text" name="f1_serial" class="form-control" placeholder="Search Serial Number" value="{{ request('f1_serial') }}">
                                                        <span class="input-group-text"><i class="uil uil-search"></i></span>
                                                    </div>
                                                </div>
                                                <div class="ms-1" style="width:230px;">
                                                    <div class="input-group">
                                                        <input type="text" name="f1_vehicle" class="form-control" placeholder="Search Vehicle Number" value="{{ request('f1_vehicle') }}">
                                                        <span class="input-group-text"><i class="uil uil-truck"></i></span>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-primary ms-1"><i class="uil uil-filter me-1"></i>Filter</button>
                                                <a href="{{ route('inventory.battery-dashboard') }}" class="btn btn-primary ms-1"><i class="uil uil-sync me-1"></i>Reset</a>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="sr_dashboard0_table mt-2">
                            @include('inventory.partials.battery-tab-all')
                        </div>
                    </div>

                    {{-- ══ TAB 2: READY TO USE ══ --}}
                    <div class="tab-pane fade {{ $activeTab === 'bat-tab-ready' ? 'show active' : '' }}" id="bat-tab-ready" role="tabpanel">
                        <div class="accordion mt-2" id="acc-bat-tab2">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button filter-options" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-bat-tab2">
                                        <div class="item-filter"><div class="filter"><span class="filter-icon"><img src="{{ asset('images/icons/filter-01icon.png') }}" alt="icon"></span></div><p class="mb-0">Filter Options</p></div>
                                    </button>
                                </h2>
                                <div id="collapse-bat-tab2" class="accordion-collapse collapse show">
                                    <div class="accordion-body">
                                        <form method="GET" action="{{ route('inventory.battery-dashboard') }}" id="bat-filter-form-2" class="bat-filter-form">
                                            <input type="hidden" name="active_tab" value="bat-tab-ready">
                                            <input type="hidden" name="sort" value="{{ $sort }}">
                                            <input type="hidden" name="direction" value="{{ $direction }}">
                                            <div class="filtersearch-bd flex-wrap">
                                                <div class="vehicletype ms-1">
                                                    <label>Battery Capacity</label>
                                                    <select class="form-select bat-filter-onchange" name="f2_capacity">
                                                        <option value="">All</option>
                                                        @foreach($batteryCapacities as $cap)
                                                            <option value="{{ $cap }}" {{ request('f2_capacity') == $cap ? 'selected' : '' }}>{{ number_format($cap, 0) }} Ah</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="vehicletype ms-1">
                                                    <label>Battery Voltage</label>
                                                    <select class="form-select bat-filter-onchange" name="f2_voltage">
                                                        <option value="">All</option>
                                                        @foreach($batteryVoltages as $v)
                                                            <option value="{{ $v }}" {{ request('f2_voltage') == $v ? 'selected' : '' }}>{{ $v }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="vehicletype ms-1">
                                                    <label>Battery Condition</label>
                                                    <select class="form-select bat-filter-onchange" name="f2_condition">
                                                        <option value="">All</option>
                                                        <option value="New"                     {{ request('f2_condition') == 'New'                     ? 'selected' : '' }}>New</option>
                                                        <option value="Used"                    {{ request('f2_condition') == 'Used'                    ? 'selected' : '' }}>Used</option>
                                                        <option value="Replaced Under Warranty" {{ request('f2_condition') == 'Replaced Under Warranty' ? 'selected' : '' }}>Replaced Under Warranty</option>
                                                    </select>
                                                </div>
                                                <div class="vehicletype ms-1">
                                                    <label>RAG Status</label>
                                                    <select class="form-select bat-filter-onchange" name="f2_rag">
                                                        <option value="">All</option>
                                                        <option value="Green"  {{ request('f2_rag') == 'Green'  ? 'selected' : '' }}>🟢 Green</option>
                                                        <option value="Yellow" {{ request('f2_rag') == 'Yellow' ? 'selected' : '' }}>🟡 Yellow</option>
                                                        <option value="Red"    {{ request('f2_rag') == 'Red'    ? 'selected' : '' }}>🔴 Red</option>
                                                    </select>
                                                </div>
                                                <div class="vehicletype ms-1">
                                                    <label>Warranty</label>
                                                    <select class="form-select bat-filter-onchange" name="f2_warranty">
                                                        <option value="">All</option>
                                                        <option value="In Warranty"      {{ request('f2_warranty') == 'In Warranty'      ? 'selected' : '' }}>In Warranty</option>
                                                        <option value="Out of Warranty"  {{ request('f2_warranty') == 'Out of Warranty'  ? 'selected' : '' }}>Out of Warranty</option>
                                                    </select>
                                                </div>
                                                <div class="vehicletype ms-1">
                                                    <label>Brand</label>
                                                    <select class="form-select bat-filter-onchange" name="f2_brand">
                                                        <option value="">All</option>
                                                        @foreach($batteryBrands as $brand)
                                                            <option value="{{ $brand }}" {{ request('f2_brand') == $brand ? 'selected' : '' }}>{{ $brand }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="vehicletype ms-1">
                                                    <label>Vendor</label>
                                                    <select class="form-select bat-filter-onchange" name="f2_vendor">
                                                        <option value="">All</option>
                                                        @foreach($batteryVendors as $v)
                                                            <option value="{{ $v->id }}" {{ request('f2_vendor') == $v->id ? 'selected' : '' }}>{{ $v->contact_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="filtersearch-bd justify-content-start mt-2">
                                                <div class="ms-1" style="width:230px;">
                                                    <div class="input-group">
                                                        <input type="text" name="f2_serial" class="form-control" placeholder="Search Serial Number" value="{{ request('f2_serial') }}">
                                                        <span class="input-group-text"><i class="uil uil-search"></i></span>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-primary ms-1"><i class="uil uil-filter me-1"></i>Filter</button>
                                                <a href="{{ route('inventory.battery-dashboard') }}?active_tab=bat-tab-ready" class="btn btn-primary ms-1"><i class="uil uil-sync me-1"></i>Reset</a>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="sr_dashboard0_table mt-2">
                            @include('inventory.partials.battery-tab-ready')
                        </div>
                    </div>

                    {{-- ══ TAB 3: WARRANTY CLAIM ══ --}}
                    <div class="tab-pane fade {{ $activeTab === 'bat-tab-warranty' ? 'show active' : '' }}" id="bat-tab-warranty" role="tabpanel">
                        <div class="accordion mt-2" id="acc-bat-tab3">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button filter-options" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-bat-tab3">
                                        <div class="item-filter"><div class="filter"><span class="filter-icon"><img src="{{ asset('images/icons/filter-01icon.png') }}" alt="icon"></span></div><p class="mb-0">Filter Options</p></div>
                                    </button>
                                </h2>
                                <div id="collapse-bat-tab3" class="accordion-collapse collapse show">
                                    <div class="accordion-body">
                                        <form method="GET" action="{{ route('inventory.battery-dashboard') }}" id="bat-filter-form-3" class="bat-filter-form">
                                            <input type="hidden" name="active_tab" value="bat-tab-warranty">
                                            <input type="hidden" name="sort" value="{{ $sort }}">
                                            <input type="hidden" name="direction" value="{{ $direction }}">
                                            <div class="filtersearch-bd flex-wrap">
                                                <div class="vehicletype ms-1">
                                                    <label>Battery Capacity</label>
                                                    <select class="form-select bat-filter-onchange" name="f3_capacity">
                                                        <option value="">All</option>
                                                        @foreach($batteryCapacities as $cap)
                                                            <option value="{{ $cap }}" {{ request('f3_capacity') == $cap ? 'selected' : '' }}>{{ number_format($cap, 0) }} Ah</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="vehicletype ms-1">
                                                    <label>Battery Voltage</label>
                                                    <select class="form-select bat-filter-onchange" name="f3_voltage">
                                                        <option value="">All</option>
                                                        @foreach($batteryVoltages as $v)
                                                            <option value="{{ $v }}" {{ request('f3_voltage') == $v ? 'selected' : '' }}>{{ $v }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="vehicletype ms-1">
                                                    <label>Battery Location</label>
                                                    <select class="form-select bat-filter-onchange" name="f3_location">
                                                        <option value="">All</option>
                                                        <option value="SR Garage"        {{ request('f3_location') == 'SR Garage'        ? 'selected' : '' }}>SR Garage</option>
                                                        <option value="Sent for Warranty" {{ request('f3_location') == 'Sent for Warranty' ? 'selected' : '' }}>Sent for Warranty</option>
                                                    </select>
                                                </div>
                                                <div class="vehicletype ms-1">
                                                    <label>RAG Status</label>
                                                    <select class="form-select bat-filter-onchange" name="f3_rag">
                                                        <option value="">All</option>
                                                        <option value="Green"  {{ request('f3_rag') == 'Green'  ? 'selected' : '' }}>🟢 Green</option>
                                                        <option value="Yellow" {{ request('f3_rag') == 'Yellow' ? 'selected' : '' }}>🟡 Yellow</option>
                                                        <option value="Red"    {{ request('f3_rag') == 'Red'    ? 'selected' : '' }}>🔴 Red</option>
                                                    </select>
                                                </div>
                                                <div class="vehicletype ms-1">
                                                    <label>Brand</label>
                                                    <select class="form-select bat-filter-onchange" name="f3_brand">
                                                        <option value="">All</option>
                                                        @foreach($batteryBrands as $brand)
                                                            <option value="{{ $brand }}" {{ request('f3_brand') == $brand ? 'selected' : '' }}>{{ $brand }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="vehicletype ms-1">
                                                    <label>Vendor</label>
                                                    <select class="form-select bat-filter-onchange" name="f3_vendor">
                                                        <option value="">All</option>
                                                        @foreach($batteryVendors as $v)
                                                            <option value="{{ $v->id }}" {{ request('f3_vendor') == $v->id ? 'selected' : '' }}>{{ $v->contact_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="filtersearch-bd justify-content-start mt-2">
                                                <div class="ms-1" style="width:230px;">
                                                    <div class="input-group">
                                                        <input type="text" name="f3_serial" class="form-control" placeholder="Search Serial Number" value="{{ request('f3_serial') }}">
                                                        <span class="input-group-text"><i class="uil uil-search"></i></span>
                                                    </div>
                                                </div>
                                                <div class="ms-1" style="width:230px;">
                                                    <div class="input-group">
                                                        <input type="text" name="f3_new_serial" class="form-control" placeholder="New Replaced Battery Serial" value="{{ request('f3_new_serial') }}">
                                                        <span class="input-group-text"><i class="uil uil-search"></i></span>
                                                    </div>
                                                </div>
                                                <div class="ms-1" style="width:200px;">
                                                    <input type="text" name="f3_claim_reason" class="form-control" placeholder="Claim Reason" value="{{ request('f3_claim_reason') }}">
                                                </div>
                                                <button type="submit" class="btn btn-primary ms-1"><i class="uil uil-filter me-1"></i>Filter</button>
                                                <a href="{{ route('inventory.battery-dashboard') }}?active_tab=bat-tab-warranty" class="btn btn-primary ms-1"><i class="uil uil-sync me-1"></i>Reset</a>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="sr_dashboard0_table mt-2">
                            @include('inventory.partials.battery-tab-warranty')
                        </div>
                    </div>

                    {{-- ══ TAB 4: REPAIR BATTERIES ══ --}}
                    <div class="tab-pane fade {{ $activeTab === 'bat-tab-repair' ? 'show active' : '' }}" id="bat-tab-repair" role="tabpanel">
                        <div class="accordion mt-2" id="acc-bat-tab4">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button filter-options" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-bat-tab4">
                                        <div class="item-filter"><div class="filter"><span class="filter-icon"><img src="{{ asset('images/icons/filter-01icon.png') }}" alt="icon"></span></div><p class="mb-0">Filter Options</p></div>
                                    </button>
                                </h2>
                                <div id="collapse-bat-tab4" class="accordion-collapse collapse show">
                                    <div class="accordion-body">
                                        <form method="GET" action="{{ route('inventory.battery-dashboard') }}" id="bat-filter-form-4" class="bat-filter-form">
                                            <input type="hidden" name="active_tab" value="bat-tab-repair">
                                            <input type="hidden" name="sort" value="{{ $sort }}">
                                            <input type="hidden" name="direction" value="{{ $direction }}">
                                            <div class="filtersearch-bd flex-wrap">
                                                <div class="vehicletype ms-1">
                                                    <label>Battery Capacity</label>
                                                    <select class="form-select bat-filter-onchange" name="f4_capacity">
                                                        <option value="">All</option>
                                                        @foreach($batteryCapacities as $cap)
                                                            <option value="{{ $cap }}" {{ request('f4_capacity') == $cap ? 'selected' : '' }}>{{ number_format($cap, 0) }} Ah</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="vehicletype ms-1">
                                                    <label>Battery Voltage</label>
                                                    <select class="form-select bat-filter-onchange" name="f4_voltage">
                                                        <option value="">All</option>
                                                        @foreach($batteryVoltages as $v)
                                                            <option value="{{ $v }}" {{ request('f4_voltage') == $v ? 'selected' : '' }}>{{ $v }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="vehicletype ms-1">
                                                    <label>Battery Location</label>
                                                    <select class="form-select bat-filter-onchange" name="f4_location">
                                                        <option value="">All</option>
                                                        <option value="SR Garage"      {{ request('f4_location') == 'SR Garage'      ? 'selected' : '' }}>SR Garage</option>
                                                        <option value="Sent for Repair" {{ request('f4_location') == 'Sent for Repair' ? 'selected' : '' }}>Sent for Repair</option>
                                                    </select>
                                                </div>
                                                <div class="vehicletype ms-1">
                                                    <label>RAG Status</label>
                                                    <select class="form-select bat-filter-onchange" name="f4_rag">
                                                        <option value="">All</option>
                                                        <option value="Green"  {{ request('f4_rag') == 'Green'  ? 'selected' : '' }}>🟢 Green</option>
                                                        <option value="Yellow" {{ request('f4_rag') == 'Yellow' ? 'selected' : '' }}>🟡 Yellow</option>
                                                        <option value="Red"    {{ request('f4_rag') == 'Red'    ? 'selected' : '' }}>🔴 Red</option>
                                                    </select>
                                                </div>
                                                <div class="vehicletype ms-1">
                                                    <label>Brand</label>
                                                    <select class="form-select bat-filter-onchange" name="f4_brand">
                                                        <option value="">All</option>
                                                        @foreach($batteryBrands as $brand)
                                                            <option value="{{ $brand }}" {{ request('f4_brand') == $brand ? 'selected' : '' }}>{{ $brand }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="vehicletype ms-1">
                                                    <label>Repair Vendor</label>
                                                    <select class="form-select bat-filter-onchange" name="f4_repair_vendor">
                                                        <option value="">All</option>
                                                        @foreach($batteryVendors as $v)
                                                            <option value="{{ $v->id }}" {{ request('f4_repair_vendor') == $v->id ? 'selected' : '' }}>{{ $v->contact_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="filtersearch-bd justify-content-start mt-2">
                                                <div class="ms-1" style="width:230px;">
                                                    <div class="input-group">
                                                        <input type="text" name="f4_serial" class="form-control" placeholder="Search Serial Number" value="{{ request('f4_serial') }}">
                                                        <span class="input-group-text"><i class="uil uil-search"></i></span>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-primary ms-1"><i class="uil uil-filter me-1"></i>Filter</button>
                                                <a href="{{ route('inventory.battery-dashboard') }}?active_tab=bat-tab-repair" class="btn btn-primary ms-1"><i class="uil uil-sync me-1"></i>Reset</a>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="sr_dashboard0_table mt-2">
                            @include('inventory.partials.battery-tab-repair')
                        </div>
                    </div>

                    {{-- ══ TAB 5: SCRAP BATTERIES ══ --}}
                    <div class="tab-pane fade {{ $activeTab === 'bat-tab-scrap' ? 'show active' : '' }}" id="bat-tab-scrap" role="tabpanel">
                        <div class="accordion mt-2" id="acc-bat-tab5">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button filter-options" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-bat-tab5">
                                        <div class="item-filter"><div class="filter"><span class="filter-icon"><img src="{{ asset('images/icons/filter-01icon.png') }}" alt="icon"></span></div><p class="mb-0">Filter Options</p></div>
                                    </button>
                                </h2>
                                <div id="collapse-bat-tab5" class="accordion-collapse collapse show">
                                    <div class="accordion-body">
                                        <form method="GET" action="{{ route('inventory.battery-dashboard') }}" id="bat-filter-form-5" class="bat-filter-form">
                                            <input type="hidden" name="active_tab" value="bat-tab-scrap">
                                            <input type="hidden" name="sort" value="{{ $sort }}">
                                            <input type="hidden" name="direction" value="{{ $direction }}">
                                            <div class="filtersearch-bd flex-wrap">
                                                <div class="vehicletype ms-1">
                                                    <label>Battery Capacity</label>
                                                    <select class="form-select bat-filter-onchange" name="f5_capacity">
                                                        <option value="">All</option>
                                                        @foreach($batteryCapacities as $cap)
                                                            <option value="{{ $cap }}" {{ request('f5_capacity') == $cap ? 'selected' : '' }}>{{ number_format($cap, 0) }} Ah</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="vehicletype ms-1">
                                                    <label>Battery Voltage</label>
                                                    <select class="form-select bat-filter-onchange" name="f5_voltage">
                                                        <option value="">All</option>
                                                        @foreach($batteryVoltages as $v)
                                                            <option value="{{ $v }}" {{ request('f5_voltage') == $v ? 'selected' : '' }}>{{ $v }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="vehicletype ms-1">
                                                    <label>Battery Location</label>
                                                    <select class="form-select bat-filter-onchange" name="f5_location">
                                                        <option value="">All</option>
                                                        <option value="SR Garage"      {{ request('f5_location') == 'SR Garage'      ? 'selected' : '' }}>SR Garage</option>
                                                        <option value="Sent for Scrap" {{ request('f5_location') == 'Sent for Scrap' ? 'selected' : '' }}>Sent for Scrap</option>
                                                    </select>
                                                </div>
                                                <div class="vehicletype ms-1">
                                                    <label>RAG Status</label>
                                                    <select class="form-select bat-filter-onchange" name="f5_rag">
                                                        <option value="">All</option>
                                                        <option value="Green"  {{ request('f5_rag') == 'Green'  ? 'selected' : '' }}>🟢 Green</option>
                                                        <option value="Yellow" {{ request('f5_rag') == 'Yellow' ? 'selected' : '' }}>🟡 Yellow</option>
                                                        <option value="Red"    {{ request('f5_rag') == 'Red'    ? 'selected' : '' }}>🔴 Red</option>
                                                    </select>
                                                </div>
                                                <div class="vehicletype ms-1">
                                                    <label>Scrap Reason</label>
                                                    <select class="form-select bat-filter-onchange" name="f5_scrap_reason">
                                                        <option value="">All</option>
                                                        @foreach(['Dead Cell','Swollen','Physical Damage','Beyond Repair','End of Life'] as $r)
                                                            <option value="{{ $r }}" {{ request('f5_scrap_reason') == $r ? 'selected' : '' }}>{{ $r }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="vehicletype ms-1">
                                                    <label>Scrap Income Received</label>
                                                    <select class="form-select bat-filter-onchange" name="f5_income_received">
                                                        <option value="">All</option>
                                                        <option value="Yes" {{ request('f5_income_received') == 'Yes' ? 'selected' : '' }}>Yes</option>
                                                        <option value="No"  {{ request('f5_income_received') == 'No'  ? 'selected' : '' }}>No</option>
                                                    </select>
                                                </div>
                                                <div class="vehicletype ms-1">
                                                    <label>Brand</label>
                                                    <select class="form-select bat-filter-onchange" name="f5_brand">
                                                        <option value="">All</option>
                                                        @foreach($batteryBrands as $brand)
                                                            <option value="{{ $brand }}" {{ request('f5_brand') == $brand ? 'selected' : '' }}>{{ $brand }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="vehicletype ms-1">
                                                    <label>Scrap Vendor</label>
                                                    <select class="form-select bat-filter-onchange" name="f5_vendor">
                                                        <option value="">All</option>
                                                        @foreach($batteryVendors as $v)
                                                            <option value="{{ $v->id }}" {{ request('f5_vendor') == $v->id ? 'selected' : '' }}>{{ $v->contact_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="filtersearch-bd justify-content-start mt-2">
                                                <div class="ms-1" style="width:220px;">
                                                    <div class="input-group">
                                                        <input type="text" name="f5_serial" class="form-control" placeholder="Search Serial Number" value="{{ request('f5_serial') }}">
                                                        <span class="input-group-text"><i class="uil uil-search"></i></span>
                                                    </div>
                                                </div>
                                                <div class="ms-1" style="width:220px;">
                                                    <div class="input-group">
                                                        <input type="text" name="f5_vehicle" class="form-control" placeholder="Search Vehicle Number" value="{{ request('f5_vehicle') }}">
                                                        <span class="input-group-text"><i class="uil uil-truck"></i></span>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-primary ms-1"><i class="uil uil-filter me-1"></i>Filter</button>
                                                <a href="{{ route('inventory.battery-dashboard') }}?active_tab=bat-tab-scrap" class="btn btn-primary ms-1"><i class="uil uil-sync me-1"></i>Reset</a>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="sr_dashboard0_table mt-2">
                            @include('inventory.partials.battery-tab-scrap')
                        </div>
                    </div>

                    {{-- ══ TAB 6: ALLOCATED BATTERIES ══ --}}
                    <div class="tab-pane fade {{ $activeTab === 'bat-tab-allocated' ? 'show active' : '' }}" id="bat-tab-allocated" role="tabpanel">
                        <div class="accordion mt-2" id="acc-bat-tab6">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button filter-options" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-bat-tab6">
                                        <div class="item-filter"><div class="filter"><span class="filter-icon"><img src="{{ asset('images/icons/filter-01icon.png') }}" alt="icon"></span></div><p class="mb-0">Filter Options</p></div>
                                    </button>
                                </h2>
                                <div id="collapse-bat-tab6" class="accordion-collapse collapse show">
                                    <div class="accordion-body">
                                        <form method="GET" action="{{ route('inventory.battery-dashboard') }}" id="bat-filter-form-6" class="bat-filter-form">
                                            <input type="hidden" name="active_tab" value="bat-tab-allocated">
                                            <input type="hidden" name="sort" value="{{ $sort }}">
                                            <input type="hidden" name="direction" value="{{ $direction }}">
                                            <div class="filtersearch-bd flex-wrap">
                                                <div class="vehicletype ms-1">
                                                    <label>Battery Capacity</label>
                                                    <select class="form-select bat-filter-onchange" name="f6_capacity">
                                                        <option value="">All</option>
                                                        @foreach($batteryCapacities as $cap)
                                                            <option value="{{ $cap }}" {{ request('f6_capacity') == $cap ? 'selected' : '' }}>{{ number_format($cap, 0) }} Ah</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="vehicletype ms-1">
                                                    <label>Battery Voltage</label>
                                                    <select class="form-select bat-filter-onchange" name="f6_voltage">
                                                        <option value="">All</option>
                                                        @foreach($batteryVoltages as $v)
                                                            <option value="{{ $v }}" {{ request('f6_voltage') == $v ? 'selected' : '' }}>{{ $v }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="vehicletype ms-1">
                                                    <label>Battery Condition</label>
                                                    <select class="form-select bat-filter-onchange" name="f6_condition">
                                                        <option value="">All</option>
                                                        <option value="New"                     {{ request('f6_condition') == 'New'                     ? 'selected' : '' }}>New</option>
                                                        <option value="Used"                    {{ request('f6_condition') == 'Used'                    ? 'selected' : '' }}>Used</option>
                                                        <option value="Replaced Under Warranty" {{ request('f6_condition') == 'Replaced Under Warranty' ? 'selected' : '' }}>Replaced Under Warranty</option>
                                                    </select>
                                                </div>
                                                <div class="vehicletype ms-1">
                                                    <label>RAG Status</label>
                                                    <select class="form-select bat-filter-onchange" name="f6_rag">
                                                        <option value="">All</option>
                                                        <option value="Green"  {{ request('f6_rag') == 'Green'  ? 'selected' : '' }}>🟢 Green</option>
                                                        <option value="Yellow" {{ request('f6_rag') == 'Yellow' ? 'selected' : '' }}>🟡 Yellow</option>
                                                        <option value="Red"    {{ request('f6_rag') == 'Red'    ? 'selected' : '' }}>🔴 Red</option>
                                                    </select>
                                                </div>
                                                <div class="vehicletype ms-1">
                                                    <label>Warranty</label>
                                                    <select class="form-select bat-filter-onchange" name="f6_warranty">
                                                        <option value="">All</option>
                                                        <option value="Active"  {{ request('f6_warranty') == 'Active'  ? 'selected' : '' }}>Active</option>
                                                        <option value="Expired" {{ request('f6_warranty') == 'Expired' ? 'selected' : '' }}>Expired</option>
                                                    </select>
                                                </div>
                                                <div class="vehicletype ms-1">
                                                    <label>Brand</label>
                                                    <select class="form-select bat-filter-onchange" name="f6_brand">
                                                        <option value="">All</option>
                                                        @foreach($batteryBrands as $brand)
                                                            <option value="{{ $brand }}" {{ request('f6_brand') == $brand ? 'selected' : '' }}>{{ $brand }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="vehicletype ms-1">
                                                    <label>Vendor</label>
                                                    <select class="form-select bat-filter-onchange" name="f6_vendor">
                                                        <option value="">All</option>
                                                        @foreach($batteryVendors as $v)
                                                            <option value="{{ $v->id }}" {{ request('f6_vendor') == $v->id ? 'selected' : '' }}>{{ $v->contact_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="filtersearch-bd justify-content-start mt-2">
                                                <div class="ms-1" style="width:220px;">
                                                    <div class="input-group">
                                                        <input type="text" name="f6_serial" class="form-control" placeholder="Search Serial Number" value="{{ request('f6_serial') }}">
                                                        <span class="input-group-text"><i class="uil uil-search"></i></span>
                                                    </div>
                                                </div>
                                                <div class="ms-1" style="width:220px;">
                                                    <div class="input-group">
                                                        <input type="text" name="f6_vehicle" class="form-control" placeholder="Search Vehicle Number" value="{{ request('f6_vehicle') }}">
                                                        <span class="input-group-text"><i class="uil uil-truck"></i></span>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-primary ms-1"><i class="uil uil-filter me-1"></i>Filter</button>
                                                <a href="{{ route('inventory.battery-dashboard') }}?active_tab=bat-tab-allocated" class="btn btn-primary ms-1"><i class="uil uil-sync me-1"></i>Reset</a>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="sr_dashboard0_table mt-2">
                            @include('inventory.partials.battery-tab-allocated')
                        </div>
                    </div>

                    {{-- ══ TAB 7: DIRECT FITMENT ══ --}}
                    <div class="tab-pane fade {{ $activeTab === 'bat-tab-direct' ? 'show active' : '' }}" id="bat-tab-direct" role="tabpanel">
                        <div class="accordion mt-2" id="acc-bat-tab7">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button filter-options" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-bat-tab7">
                                        <div class="item-filter"><div class="filter"><span class="filter-icon"><img src="{{ asset('images/icons/filter-01icon.png') }}" alt="icon"></span></div><p class="mb-0">Filter Options</p></div>
                                    </button>
                                </h2>
                                <div id="collapse-bat-tab7" class="accordion-collapse collapse show">
                                    <div class="accordion-body">
                                        <form method="GET" action="{{ route('inventory.battery-dashboard') }}" id="bat-filter-form-7" class="bat-filter-form">
                                            <input type="hidden" name="active_tab" value="bat-tab-direct">
                                            <input type="hidden" name="sort" value="{{ $sort }}">
                                            <input type="hidden" name="direction" value="{{ $direction }}">
                                            <div class="filtersearch-bd flex-wrap">
                                                <div class="vehicletype ms-1">
                                                    <label>Battery Capacity</label>
                                                    <select class="form-select bat-filter-onchange" name="f7_capacity">
                                                        <option value="">All</option>
                                                        @foreach($batteryCapacities as $cap)
                                                            <option value="{{ $cap }}" {{ request('f7_capacity') == $cap ? 'selected' : '' }}>{{ number_format($cap, 0) }} Ah</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="vehicletype ms-1">
                                                    <label>Battery Voltage</label>
                                                    <select class="form-select bat-filter-onchange" name="f7_voltage">
                                                        <option value="">All</option>
                                                        @foreach($batteryVoltages as $v)
                                                            <option value="{{ $v }}" {{ request('f7_voltage') == $v ? 'selected' : '' }}>{{ $v }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="vehicletype ms-1">
                                                    <label>Battery Condition</label>
                                                    <select class="form-select bat-filter-onchange" name="f7_condition">
                                                        <option value="">All</option>
                                                        <option value="New"                     {{ request('f7_condition') == 'New'                     ? 'selected' : '' }}>New</option>
                                                        <option value="Used"                    {{ request('f7_condition') == 'Used'                    ? 'selected' : '' }}>Used</option>
                                                        <option value="Replaced Under Warranty" {{ request('f7_condition') == 'Replaced Under Warranty' ? 'selected' : '' }}>Replaced Under Warranty</option>
                                                    </select>
                                                </div>
                                                <div class="vehicletype ms-1">
                                                    <label>RAG Status</label>
                                                    <select class="form-select bat-filter-onchange" name="f7_rag">
                                                        <option value="">All</option>
                                                        <option value="Green"  {{ request('f7_rag') == 'Green'  ? 'selected' : '' }}>🟢 Green</option>
                                                        <option value="Yellow" {{ request('f7_rag') == 'Yellow' ? 'selected' : '' }}>🟡 Yellow</option>
                                                        <option value="Red"    {{ request('f7_rag') == 'Red'    ? 'selected' : '' }}>🔴 Red</option>
                                                    </select>
                                                </div>
                                                <div class="vehicletype ms-1">
                                                    <label>Brand</label>
                                                    <select class="form-select bat-filter-onchange" name="f7_brand">
                                                        <option value="">All</option>
                                                        @foreach($batteryBrands as $brand)
                                                            <option value="{{ $brand }}" {{ request('f7_brand') == $brand ? 'selected' : '' }}>{{ $brand }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="vehicletype ms-1">
                                                    <label>Vendor</label>
                                                    <select class="form-select bat-filter-onchange" name="f7_vendor">
                                                        <option value="">All</option>
                                                        @foreach($batteryVendors as $v)
                                                            <option value="{{ $v->id }}" {{ request('f7_vendor') == $v->id ? 'selected' : '' }}>{{ $v->contact_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="filtersearch-bd justify-content-start mt-2">
                                                <div class="ms-1" style="width:220px;">
                                                    <div class="input-group">
                                                        <input type="text" name="f7_serial" class="form-control" placeholder="Search Serial Number" value="{{ request('f7_serial') }}">
                                                        <span class="input-group-text"><i class="uil uil-search"></i></span>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-primary ms-1"><i class="uil uil-filter me-1"></i>Filter</button>
                                                <a href="{{ route('inventory.battery-dashboard') }}?active_tab=bat-tab-direct" class="btn btn-primary ms-1"><i class="uil uil-sync me-1"></i>Reset</a>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="sr_dashboard0_table mt-2">
                            @include('inventory.partials.battery-tab-direct-fitment')
                        </div>
                    </div>

                    {{-- ══ TAB 8: YET TO DECIDE ══ --}}
                    <div class="tab-pane fade {{ $activeTab === 'bat-tab-ytd' ? 'show active' : '' }}" id="bat-tab-ytd" role="tabpanel">
                        <div class="accordion mt-2" id="acc-bat-tab8">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button filter-options" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-bat-tab8">
                                        <div class="item-filter"><div class="filter"><span class="filter-icon"><img src="{{ asset('images/icons/filter-01icon.png') }}" alt="icon"></span></div><p class="mb-0">Filter Options</p></div>
                                    </button>
                                </h2>
                                <div id="collapse-bat-tab8" class="accordion-collapse collapse show">
                                    <div class="accordion-body">
                                        <form method="GET" action="{{ route('inventory.battery-dashboard') }}" id="bat-filter-form-8" class="bat-filter-form">
                                            <input type="hidden" name="active_tab" value="bat-tab-ytd">
                                            <input type="hidden" name="sort" value="{{ $sort }}">
                                            <input type="hidden" name="direction" value="{{ $direction }}">
                                            <div class="filtersearch-bd flex-wrap">
                                                <div class="vehicletype ms-1">
                                                    <label>Battery Capacity</label>
                                                    <select class="form-select bat-filter-onchange" name="f8_capacity">
                                                        <option value="">All</option>
                                                        @foreach($batteryCapacities as $cap)
                                                            <option value="{{ $cap }}" {{ request('f8_capacity') == $cap ? 'selected' : '' }}>{{ number_format($cap, 0) }} Ah</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="vehicletype ms-1">
                                                    <label>Battery Voltage</label>
                                                    <select class="form-select bat-filter-onchange" name="f8_voltage">
                                                        <option value="">All</option>
                                                        @foreach($batteryVoltages as $v)
                                                            <option value="{{ $v }}" {{ request('f8_voltage') == $v ? 'selected' : '' }}>{{ $v }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="vehicletype ms-1">
                                                    <label>Battery Condition</label>
                                                    <select class="form-select bat-filter-onchange" name="f8_condition">
                                                        <option value="">All</option>
                                                        <option value="New"                     {{ request('f8_condition') == 'New'                     ? 'selected' : '' }}>New</option>
                                                        <option value="Used"                    {{ request('f8_condition') == 'Used'                    ? 'selected' : '' }}>Used</option>
                                                        <option value="Replaced Under Warranty" {{ request('f8_condition') == 'Replaced Under Warranty' ? 'selected' : '' }}>Replaced Under Warranty</option>
                                                    </select>
                                                </div>
                                                <div class="vehicletype ms-1">
                                                    <label>RAG Status</label>
                                                    <select class="form-select bat-filter-onchange" name="f8_rag">
                                                        <option value="">All</option>
                                                        <option value="Green"  {{ request('f8_rag') == 'Green'  ? 'selected' : '' }}>🟢 Green</option>
                                                        <option value="Yellow" {{ request('f8_rag') == 'Yellow' ? 'selected' : '' }}>🟡 Yellow</option>
                                                        <option value="Red"    {{ request('f8_rag') == 'Red'    ? 'selected' : '' }}>🔴 Red</option>
                                                    </select>
                                                </div>
                                                <div class="vehicletype ms-1">
                                                    <label>Battery Location</label>
                                                    <select class="form-select bat-filter-onchange" name="f8_location">
                                                        <option value="">All</option>
                                                        <option value="SR Garage" {{ request('f8_location') == 'SR Garage' ? 'selected' : '' }}>SR Garage</option>
                                                        <option value="Vehicle"   {{ request('f8_location') == 'Vehicle'   ? 'selected' : '' }}>Vehicle</option>
                                                    </select>
                                                </div>
                                                <div class="vehicletype ms-1">
                                                    <label>Damage Reason</label>
                                                    <select class="form-select bat-filter-onchange" name="f8_damage_reason">
                                                        <option value="">All</option>
                                                        @foreach(['Dead Cell','Swollen','Physical Damage','Leaking','Corroded Terminal','Unknown'] as $r)
                                                            <option value="{{ $r }}" {{ request('f8_damage_reason') == $r ? 'selected' : '' }}>{{ $r }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="vehicletype ms-1">
                                                    <label>Brand</label>
                                                    <select class="form-select bat-filter-onchange" name="f8_brand">
                                                        <option value="">All</option>
                                                        @foreach($batteryBrands as $brand)
                                                            <option value="{{ $brand }}" {{ request('f8_brand') == $brand ? 'selected' : '' }}>{{ $brand }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="vehicletype ms-1">
                                                    <label>Vendor</label>
                                                    <select class="form-select bat-filter-onchange" name="f8_vendor">
                                                        <option value="">All</option>
                                                        @foreach($batteryVendors as $v)
                                                            <option value="{{ $v->id }}" {{ request('f8_vendor') == $v->id ? 'selected' : '' }}>{{ $v->contact_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="filtersearch-bd justify-content-start mt-2">
                                                <div class="ms-1" style="width:220px;">
                                                    <div class="input-group">
                                                        <input type="text" name="f8_serial" class="form-control" placeholder="Search Serial Number" value="{{ request('f8_serial') }}">
                                                        <span class="input-group-text"><i class="uil uil-search"></i></span>
                                                    </div>
                                                </div>
                                                <div class="ms-1" style="width:220px;">
                                                    <div class="input-group">
                                                        <input type="text" name="f8_last_vehicle" class="form-control" placeholder="Search Last Vehicle Number" value="{{ request('f8_last_vehicle') }}">
                                                        <span class="input-group-text"><i class="uil uil-truck"></i></span>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-primary ms-1"><i class="uil uil-filter me-1"></i>Filter</button>
                                                <a href="{{ route('inventory.battery-dashboard') }}?active_tab=bat-tab-ytd" class="btn btn-primary ms-1"><i class="uil uil-sync me-1"></i>Reset</a>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="sr_dashboard0_table mt-2">
                            @include('inventory.partials.battery-tab-ytd')
                        </div>
                    </div>

                </div>{{-- /tab-content --}}
            </div>{{-- /right-side-wrap --}}

        </div>{{-- /main-wrap --}}
    </div>{{-- /wrapper --}}
</div>{{-- /layout-wrapper --}}

{{-- ══ CHANGE STATUS MODAL (Yet to Decide → Warranty / Repair / Scrap) ══ --}}
<div class="modal fade" id="batChangeStatusModal" tabindex="-1" aria-labelledby="batChangeStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="batChangeStatusModalLabel">
                    <i class="uil uil-exchange me-2"></i>Move Battery
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-1 text-muted" style="font-size:13px;">Serial: <strong id="batChangeSerial">—</strong></p>
                <p class="mb-3" style="font-size:13px;">Select the new status for this battery:</p>
                <div class="d-flex gap-2 flex-wrap">
                    <button class="btn bat-btn-change-status-opt" data-new-status="Warranty Claim">
                        <i class="uil uil-shield-check me-1"></i>Warranty Claim
                    </button>
                    <button class="btn bat-btn-change-status-opt" data-new-status="Repair">
                        <i class="uil uil-wrench me-1"></i>Repair
                    </button>
                    <button class="btn bat-btn-change-status-opt" data-new-status="Scrap">
                        <i class="uil uil-trash me-1"></i>Scrap
                    </button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script src="{{ asset('js/inventory/battery-dashboard.js?v=3.1') }}"></script>
@endsection
