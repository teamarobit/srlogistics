@extends('layouts.app')

@section('css')
<link href="{{ asset('css/Inventory/battery-dashboard.css?v=2.0') }}" rel="stylesheet">
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

            {{-- Summary Stat Cards --}}
            <div class="row g-3 mb-3">
                <div class="col-lg col-md-4 col-6">
                    <div class="btd-stat-card btd-navy">
                        <div class="btd-stat-icon"><i class="uil uil-bolt-alt"></i></div>
                        <div class="btd-stat-body">
                            <div class="btd-stat-val">52</div>
                            <div class="btd-stat-label">All Batteries</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg col-md-4 col-6">
                    <div class="btd-stat-card btd-green">
                        <div class="btd-stat-icon"><i class="uil uil-warehouse"></i></div>
                        <div class="btd-stat-body">
                            <div class="btd-stat-val">10</div>
                            <div class="btd-stat-label">In Warehouse</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg col-md-4 col-6">
                    <div class="btd-stat-card btd-amber" style="border-left-color:#7b1fa2;">
                        <div class="btd-stat-icon" style="background:#f3e5f5;color:#7b1fa2;"><i class="uil uil-tools"></i></div>
                        <div class="btd-stat-body">
                            <div class="btd-stat-val" style="color:#7b1fa2;">5</div>
                            <div class="btd-stat-label">In Workshop</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg col-md-4 col-6">
                    <div class="btd-stat-card btd-amber">
                        <div class="btd-stat-icon"><i class="uil uil-truck"></i></div>
                        <div class="btd-stat-body">
                            <div class="btd-stat-val">30</div>
                            <div class="btd-stat-label">Allocated to Vehicles</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg col-md-4 col-6">
                    <div class="btd-stat-card btd-grey">
                        <div class="btd-stat-icon"><i class="uil uil-trash-alt"></i></div>
                        <div class="btd-stat-body">
                            <div class="btd-stat-val">7</div>
                            <div class="btd-stat-label">Discarded</div>
                        </div>
                    </div>
                </div>
            </div>

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

            {{-- Tabs + Table Container --}}
            <div class="sc-tab-container">
                {{-- Tab Bar --}}
                <div class="sc-tab-bar" id="batTabBar">
                    <a href="javascript:void(0)" class="sc-tab active" data-tab="all">
                        All Batteries <span class="badge bg-secondary ms-1" style="font-size:10px;">52</span>
                    </a>
                    <a href="javascript:void(0)" class="sc-tab" data-tab="warehouse">
                        Warehouse <span class="badge bg-secondary ms-1" style="font-size:10px;">10</span>
                    </a>
                    <a href="javascript:void(0)" class="sc-tab" data-tab="workshop">
                        Workshop <span class="badge bg-secondary ms-1" style="font-size:10px;">5</span>
                    </a>
                    <a href="javascript:void(0)" class="sc-tab" data-tab="allocated">
                        Allocated Vehicle <span class="badge bg-secondary ms-1" style="font-size:10px;">30</span>
                    </a>
                    <a href="javascript:void(0)" class="sc-tab" data-tab="discarded">
                        Discarded <span class="badge bg-secondary ms-1" style="font-size:10px;">7</span>
                    </a>
                </div>

                <div class="sc-tab-panel-wrap p-3">

                    {{-- Filters --}}
                    <div class="btd-filter-card">
                        <div class="row g-2 align-items-end">
                            <div class="col-lg-2 col-md-4">
                                <label class="btd-filter-label">Start Date</label>
                                <input type="date" class="form-control form-control-sm" id="batFilterDateFrom">
                            </div>
                            <div class="col-lg-2 col-md-4">
                                <label class="btd-filter-label">End Date</label>
                                <input type="date" class="form-control form-control-sm" id="batFilterDateTo">
                            </div>
                            <div class="col-lg-2 col-md-4">
                                <label class="btd-filter-label">Battery Type</label>
                                <select class="form-select form-select-sm" id="batFilterType">
                                    <option value="">All Types</option>
                                    <option>Lead Acid</option>
                                    <option>Lithium-ion</option>
                                    <option>AGM</option>
                                </select>
                            </div>
                            <div class="col-lg-2 col-md-4">
                                <label class="btd-filter-label">Status</label>
                                <select class="form-select form-select-sm" id="batFilterStatus">
                                    <option value="">All Status</option>
                                    <option>Active</option>
                                    <option>In Use</option>
                                    <option>Faulty</option>
                                    <option>Discarded</option>
                                </select>
                            </div>
                            <div class="col-lg-2 col-md-4">
                                <label class="btd-filter-label">Warranty Expiry</label>
                                <input type="date" class="form-control form-control-sm" id="batFilterWarranty">
                            </div>
                            <div class="col-lg-2 col-md-4">
                                <label class="btd-filter-label">Search</label>
                                <input type="text" class="form-control form-control-sm" id="batSearch" placeholder="Serial No. / Battery No.">
                            </div>
                            <div class="col-12 d-flex gap-2 justify-content-end mt-1">
                                <button class="btn sc-btn-navy btn-sm" id="btnBatSearch">
                                    <i class="uil uil-search me-1"></i>Search
                                </button>
                                <button class="btn btn-outline-secondary btn-sm" id="btnBatReset">
                                    <i class="uil uil-times me-1"></i>Reset
                                </button>
                                <button class="btn btn-outline-secondary btn-sm" id="btnBatExport">
                                    <i class="uil uil-export me-1"></i>Export
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Battery Table --}}
                    <div class="sc-table-card">
                        <div class="table-responsive">
                            <table class="table mb-0" id="batDashTable">
                                <thead>
                                    <tr>
                                        <th style="width:32px;"></th>
                                        <th>Serial No.</th>
                                        <th>Brand</th>
                                        <th>Model</th>
                                        <th>Battery Type</th>
                                        <th>Capacity</th>
                                        <th>Voltage</th>
                                        <th>Vendor</th>
                                        <th>Condition</th>
                                        <th>Status</th>
                                        <th>Price</th>
                                        <th>Install Date</th>
                                        <th>Warranty Expiry</th>
                                        <th>Allocated Vehicle</th>
                                        <th>Created By</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    {{-- Row 1 — Warehouse / Good --}}
                                    <tr data-status="warehouse">
                                        <td><i class="uil uil-circle" style="color:#10863f;font-size:10px;"></i></td>
                                        <td><a href="{{ route('inventory.battery.details', 1) }}" class="btd-serial-link">BAT-2026-00081</a></td>
                                        <td>Amaron</td>
                                        <td>Hi-Life 150</td>
                                        <td>Lead Acid</td>
                                        <td class="text-center">150 AH</td>
                                        <td class="text-center">12V</td>
                                        <td><span class="loc-badge loc-badge-wh"><i class="uil uil-warehouse"></i> WH-BLR</span></td>
                                        <td><span class="btd-cond btd-cond-new">New</span></td>
                                        <td><span class="btd-st btd-st-warehouse">In Stock</span></td>
                                        <td>₹7,500</td>
                                        <td>—</td>
                                        <td>Jan-2028</td>
                                        <td>—</td>
                                        <td style="font-size:11px;">Admin</td>
                                        <td class="text-center">
                                            <div class="btd-row-actions">
                                                <button class="btd-action-btn btd-action-btn-history btn-bat-history"
                                                    title="View Movement History"
                                                    data-serial="BAT-2026-00081"
                                                    data-brand="Amaron Hi-Life 150"
                                                    data-spec="150 AH / 12V · Lead Acid"
                                                    data-bs-toggle="offcanvas"
                                                    data-bs-target="#batHistoryOffcanvas">
                                                    <i class="uil uil-history"></i>
                                                </button>
                                                <button class="btd-action-btn" title="Fit to Vehicle"
                                                    data-serial="BAT-2026-00081"
                                                    data-bs-toggle="modal" data-bs-target="#fitBatteryModal">
                                                    <i class="uil uil-truck"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    {{-- Row 2 — Workshop / Used --}}
                                    <tr data-status="workshop">
                                        <td><i class="uil uil-circle" style="color:#7b1fa2;font-size:10px;"></i></td>
                                        <td><a href="{{ route('inventory.battery.details', 2) }}" class="btd-serial-link">BAT-2024-00044</a></td>
                                        <td>Exide</td>
                                        <td>Matrix 180</td>
                                        <td>AGM</td>
                                        <td class="text-center">180 AH</td>
                                        <td class="text-center">12V</td>
                                        <td><span class="loc-badge loc-badge-sc"><i class="uil uil-wrench"></i> WS-HYD</span></td>
                                        <td><span class="btd-cond btd-cond-used">Used</span></td>
                                        <td><span class="btd-st btd-st-workshop">Workshop</span></td>
                                        <td>₹9,200</td>
                                        <td>Apr-2024</td>
                                        <td>Apr-2026 <span class="badge bg-warning text-dark ms-1" style="font-size:10px;">Expiring</span></td>
                                        <td>—</td>
                                        <td style="font-size:11px;">Ravi K.</td>
                                        <td class="text-center">
                                            <div class="btd-row-actions">
                                                <button class="btd-action-btn btd-action-btn-history btn-bat-history"
                                                    title="View Movement History"
                                                    data-serial="BAT-2024-00044"
                                                    data-brand="Exide Matrix 180"
                                                    data-spec="180 AH / 12V · AGM"
                                                    data-bs-toggle="offcanvas"
                                                    data-bs-target="#batHistoryOffcanvas">
                                                    <i class="uil uil-history"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    {{-- Row 3 — Allocated / Used --}}
                                    <tr data-status="allocated">
                                        <td><i class="uil uil-circle" style="color:#d97706;font-size:10px;"></i></td>
                                        <td><a href="{{ route('inventory.battery.details', 3) }}" class="btd-serial-link">BAT-2025-00063</a></td>
                                        <td>Exide</td>
                                        <td>Mileage 150</td>
                                        <td>Lead Acid</td>
                                        <td class="text-center">150 AH</td>
                                        <td class="text-center">12V</td>
                                        <td><a href="{{ route('inventory.purchase-orders') }}" class="btd-doc-link">PO-2025-0041</a></td>
                                        <td><span class="btd-cond btd-cond-used">Used</span></td>
                                        <td><span class="btd-st btd-st-allocated">Allocated</span></td>
                                        <td>₹8,000</td>
                                        <td>Jun-2025</td>
                                        <td>Jun-2027</td>
                                        <td><span class="loc-badge loc-badge-veh"><i class="uil uil-truck"></i> TN01 AB1234</span></td>
                                        <td style="font-size:11px;">Suresh P.</td>
                                        <td class="text-center">
                                            <div class="btd-row-actions">
                                                <button class="btd-action-btn btd-action-btn-history btn-bat-history"
                                                    title="View Movement History"
                                                    data-serial="BAT-2025-00063"
                                                    data-brand="Exide Mileage 150"
                                                    data-spec="150 AH / 12V · Lead Acid"
                                                    data-bs-toggle="offcanvas"
                                                    data-bs-target="#batHistoryOffcanvas">
                                                    <i class="uil uil-history"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    {{-- Row 4 — Faulty / Weak --}}
                                    <tr data-status="workshop">
                                        <td><i class="uil uil-circle" style="color:#ea0027;font-size:10px;"></i></td>
                                        <td><a href="{{ route('inventory.battery.details', 4) }}" class="btd-serial-link">BAT-2023-00027</a></td>
                                        <td>Amaron</td>
                                        <td>Pro 165</td>
                                        <td>Lithium-ion</td>
                                        <td class="text-center">165 AH</td>
                                        <td class="text-center">24V</td>
                                        <td>—</td>
                                        <td><span class="btd-cond btd-cond-weak">Weak</span></td>
                                        <td><span class="btd-st btd-st-faulty">Faulty</span></td>
                                        <td>₹14,500</td>
                                        <td>Mar-2023</td>
                                        <td>Mar-2025 <span class="badge bg-danger ms-1" style="font-size:10px;">Expired</span></td>
                                        <td>—</td>
                                        <td style="font-size:11px;">Admin</td>
                                        <td class="text-center">
                                            <div class="btd-row-actions">
                                                <button class="btd-action-btn btd-action-btn-history btn-bat-history"
                                                    title="View Movement History"
                                                    data-serial="BAT-2023-00027"
                                                    data-brand="Amaron Pro 165"
                                                    data-spec="165 AH / 24V · Lithium-ion"
                                                    data-bs-toggle="offcanvas"
                                                    data-bs-target="#batHistoryOffcanvas">
                                                    <i class="uil uil-history"></i>
                                                </button>
                                                <a href="{{ route('inventory.purchase-orders') }}" class="btd-action-btn" title="Raise Replacement PO">
                                                    <i class="uil uil-shopping-cart"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>

                                    {{-- Row 5 — Discarded / Dead --}}
                                    <tr data-status="discarded" class="btd-row-discarded">
                                        <td><i class="uil uil-circle" style="color:#adb5bd;font-size:10px;"></i></td>
                                        <td><a href="{{ route('inventory.battery.details', 5) }}" class="btd-serial-link">BAT-2022-00019</a></td>
                                        <td>Amaron</td>
                                        <td>Hi-Life 150</td>
                                        <td>Lead Acid</td>
                                        <td class="text-center">150 AH</td>
                                        <td class="text-center">12V</td>
                                        <td>—</td>
                                        <td><span class="btd-cond btd-cond-dead">Dead</span></td>
                                        <td><span class="btd-st btd-st-discarded">Discarded</span></td>
                                        <td>₹7,200</td>
                                        <td>Mar-2022</td>
                                        <td>Mar-2024 <span class="badge bg-danger ms-1" style="font-size:10px;">Expired</span></td>
                                        <td>—</td>
                                        <td style="font-size:11px;">Admin</td>
                                        <td class="text-center">
                                            <div class="btd-row-actions">
                                                <button class="btd-action-btn btd-action-btn-history btn-bat-history"
                                                    title="View Movement History"
                                                    data-serial="BAT-2022-00019"
                                                    data-brand="Amaron Hi-Life 150"
                                                    data-spec="150 AH / 12V · Lead Acid"
                                                    data-bs-toggle="offcanvas"
                                                    data-bs-target="#batHistoryOffcanvas">
                                                    <i class="uil uil-history"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex align-items-center justify-content-between px-3 py-2 border-top">
                            <small class="text-muted">Showing 5 of 52 batteries</small>
                            <nav><ul class="pagination pagination-sm mb-0">
                                <li class="page-item disabled"><a class="page-link" href="#">&laquo;</a></li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                            </ul></nav>
                        </div>
                    </div>{{-- /sc-table-card --}}

                </div>{{-- /sc-tab-panel-wrap --}}
            </div>{{-- /sc-tab-container --}}

        </div>{{-- /main-wrap --}}
    </div>
</div>

{{-- =====================================================================
     OFFCANVAS — Battery Movement History (Bootstrap 5 offcanvas)
     ===================================================================== --}}
<div class="offcanvas offcanvas-end" tabindex="-1" id="batHistoryOffcanvas" style="width:420px;">
    <div class="offcanvas-header border-bottom">
        <div>
            <h6 class="offcanvas-title mb-0"><i class="uil uil-history me-2 text-primary"></i>Battery Movement History</h6>
            <small class="text-muted">Complete lifecycle log for this battery</small>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">

        {{-- Battery info bar --}}
        <div class="btd-bat-info-bar">
            <div class="btd-bat-info-icon"><i class="uil uil-bolt-alt"></i></div>
            <div>
                <div class="btd-bat-serial" id="histBatSerial">—</div>
                <div class="btd-bat-desc" id="histBatDesc">—</div>
            </div>
        </div>

        {{-- Timeline — rendered by JS per battery (see @section('js')) --}}
        {{-- TODO (backend): replace batLoadHistory() dummy data with:       --}}
        {{--   $.get('/inventory/battery/' + serial + '/history', function(events) { batRenderTimeline(events); }); --}}
        <div id="batHistoryTimeline">
            <div class="text-center py-4 text-muted" id="batHistoryLoading" style="display:none;">
                <div class="spinner-border spinner-border-sm me-2"></div> Loading history…
            </div>
        </div>

    </div>{{-- /offcanvas-body --}}
</div>

{{-- =====================================================================
     MODAL — Add Battery (Two-Path: Manual Entry / PO GRN)
     ===================================================================== --}}
<div class="modal fade" id="addBatteryModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title"><i class="uil uil-bolt-alt me-2"></i>Add Battery</h6>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">

                {{-- Step 1 — Choose Path --}}
                <div id="batPathStep1">
                    <p class="text-muted mb-3" style="font-size:12px;">How are you adding this battery?</p>
                    <div class="btd-path-choose">
                        <div class="btd-path-card" id="batPathManual" onclick="batSelectPath('manual')">
                            <i class="uil uil-edit btd-path-icon"></i>
                            <div class="btd-path-title">Manual Entry</div>
                            <div class="btd-path-desc">Battery already purchased. Enter details manually.</div>
                        </div>
                        <div class="btd-path-card" id="batPathPO" onclick="batSelectPath('po')">
                            <i class="uil uil-file-check-alt btd-path-icon"></i>
                            <div class="btd-path-title">PO GRN Route</div>
                            <div class="btd-path-desc">Going through procurement. Select PO &amp; GRN to auto-fill specs.</div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        <button class="btn sc-btn-navy btn-sm" onclick="batNextStep()" id="btnBatPathNext" disabled>
                            Next <i class="uil uil-arrow-right ms-1"></i>
                        </button>
                    </div>
                </div>

                {{-- Step 2A — Manual Entry Form --}}
                <div id="batFormManual" style="display:none;">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <button class="btn btn-sm btn-outline-secondary" onclick="batBackToPath()"><i class="uil uil-arrow-left"></i></button>
                        <span style="font-size:12px;font-weight:600;color:#032671;"><i class="uil uil-edit me-1"></i>Manual Entry</span>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="btd-filter-label">Brand / Make <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" placeholder="e.g. Amaron, Exide">
                        </div>
                        <div class="col-md-6">
                            <label class="btd-filter-label">Model</label>
                            <input type="text" class="form-control form-control-sm" placeholder="e.g. Hi-Life 150">
                        </div>
                        <div class="col-md-6">
                            <label class="btd-filter-label">Serial No. <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" placeholder="BAT-2026-XXXXX">
                        </div>
                        <div class="col-md-6">
                            <label class="btd-filter-label">Battery Type <span class="text-danger">*</span></label>
                            <select class="form-select form-select-sm select2-bat-type-manual">
                                <option value="">— Select —</option>
                                <option>Lead Acid</option>
                                <option>Lithium-ion</option>
                                <option>AGM</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="btd-filter-label">Capacity (AH) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control form-control-sm" placeholder="150">
                        </div>
                        <div class="col-md-4">
                            <label class="btd-filter-label">Voltage <span class="text-danger">*</span></label>
                            <select class="form-select form-select-sm">
                                <option>12V</option>
                                <option>24V</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="btd-filter-label">Month Life</label>
                            <input type="number" class="form-control form-control-sm" placeholder="24">
                        </div>
                        <div class="col-md-6">
                            <label class="btd-filter-label">Purchase Date</label>
                            <input type="date" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-6">
                            <label class="btd-filter-label">Warranty Until</label>
                            <input type="date" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-6">
                            <label class="btd-filter-label">Purchase Cost (₹)</label>
                            <input type="number" class="form-control form-control-sm" min="0" step="0.01">
                        </div>
                        <div class="col-md-6">
                            <label class="btd-filter-label">Location <span class="text-danger">*</span></label>
                            <select class="form-select form-select-sm">
                                <option value="">— Select —</option>
                                <optgroup label="Warehouses">
                                    <option>WH-BLR</option><option>WH-HYD</option><option>WH-PNE</option>
                                </optgroup>
                                <optgroup label="Workshops">
                                    <option>WS-BLR</option><option>WS-HYD</option>
                                </optgroup>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="btd-filter-label">Vendor <span class="text-muted">(optional)</span></label>
                            <select class="form-select form-select-sm select2-bat-vendor">
                                <option value="">— Search vendor —</option>
                                <option>Amaron Dealer - Hyderabad</option>
                                <option>Exide Industries Ltd.</option>
                                <option>Bosch Auto Parts</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Step 2B — PO GRN Route --}}
                <div id="batFormPO" style="display:none;">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <button class="btn btn-sm btn-outline-secondary" onclick="batBackToPath()"><i class="uil uil-arrow-left"></i></button>
                        <span style="font-size:12px;font-weight:600;color:#032671;"><i class="uil uil-file-check-alt me-1"></i>PO GRN Route</span>
                    </div>
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="btd-filter-label">Select Purchase Order <span class="text-danger">*</span></label>
                            <select class="form-select form-select-sm select2-bat-po" id="batPOSelect">
                                <option value="">— Search PO —</option>
                                <option value="PO-2026-0016">PO-2026-0016 — Amaron Dealer (Battery)</option>
                                <option value="PO-2026-0018">PO-2026-0018 — Bosch Auto Parts</option>
                                <option value="PO-2026-0022">PO-2026-0022 — Exide Industries</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="btd-filter-label">Select GRN Line Item <span class="text-danger">*</span></label>
                            <select class="form-select form-select-sm select2-bat-grn" id="batGRNSelect">
                                <option value="">— Select PO first —</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <div class="alert alert-info py-2 mb-0" style="font-size:12px;" id="batGRNAutoFill" style="display:none;">
                                <i class="uil uil-info-circle me-1"></i>
                                Brand, Model, Battery Type, Capacity, Voltage and Warranty will be auto-filled from the selected GRN line item.
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="btd-filter-label">Serial No. <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" placeholder="BAT-2026-XXXXX">
                        </div>
                        <div class="col-md-6">
                            <label class="btd-filter-label">Quantity</label>
                            <input type="number" class="form-control form-control-sm" value="1" min="1">
                        </div>
                        <div class="col-12">
                            <label class="btd-filter-label">Location <span class="text-danger">*</span></label>
                            <select class="form-select form-select-sm">
                                <option value="">— Select —</option>
                                <optgroup label="Warehouses">
                                    <option>WH-BLR</option><option>WH-HYD</option><option>WH-PNE</option>
                                </optgroup>
                                <optgroup label="Workshops">
                                    <option>WS-BLR</option><option>WS-HYD</option>
                                </optgroup>
                            </select>
                        </div>
                    </div>
                </div>

            </div>{{-- /modal-body --}}
            <div class="modal-footer" id="batModalFooter" style="display:none;">
                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn sc-btn-navy btn-sm" id="btnAddBatteryConfirm">
                    <i class="uil uil-bolt-alt me-1"></i>Add Battery
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Fit Battery Modal --}}
<div class="modal fade" id="fitBatteryModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title"><i class="uil uil-truck me-2"></i>Fit Battery to Vehicle</h6>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="btd-bat-info-bar mb-3">
                    <div class="btd-bat-info-icon"><i class="uil uil-bolt-alt"></i></div>
                    <div>
                        <div class="btd-bat-serial" id="fitBatSerial">—</div>
                        <div class="btd-bat-desc" id="fitBatDesc">—</div>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-12">
                        <label class="btd-filter-label">Select Vehicle <span class="text-danger">*</span></label>
                        <select class="form-select form-select-sm select2-fit-vehicle" id="fitBatVeh">
                            <option value="">Search vehicle number…</option>
                            <option value="v1">TN01 AB1234 — Tata Prima 4928</option>
                            <option value="v2">TN02 CD5678 — Ashok Leyland 1916</option>
                            <option value="v3">TN03 EF9012 — Bharat Benz 2523</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="btd-filter-label">Battery Position</label>
                        <select class="form-select form-select-sm">
                            <option>Primary</option>
                            <option>Auxiliary</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="btd-filter-label">Fitting Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control form-control-sm" value="{{ now()->format('Y-m-d') }}">
                    </div>
                    <div class="col-12">
                        <label class="btd-filter-label">Fitted By (Technician)</label>
                        <input type="text" class="form-control form-control-sm" placeholder="Technician name">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn sc-btn-navy btn-sm" id="btnConfirmFit">
                    <i class="uil uil-check me-1"></i>Confirm Fitting
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script src="{{ asset('js/inventory/battery-dashboard.js') }}"></script>
<script>
/* ============================================================
   Battery Dashboard JS
   Movement history: Option A — dummy data per battery.
   When backend is ready, replace batLoadHistory() with:
     $.get('/inventory/battery/' + serial + '/history', batRenderTimeline);
   ============================================================ */

/* ---- Event type config — icon, CSS class, label ---- */
var BAT_EVENT_TYPES = {
    purchase  : { cls: 'btd-tl-purchase',  icon: 'uil-shopping-cart', label: 'Purchased'            },
    install   : { cls: 'btd-tl-install',   icon: 'uil-bolt-alt',      label: 'Installed'             },
    remove    : { cls: 'btd-tl-remove',    icon: 'uil-arrow-down',    label: 'Removed from Vehicle'  },
    workshop  : { cls: 'btd-tl-workshop',  icon: 'uil-wrench',        label: 'Sent to Workshop'      },
    reuse     : { cls: 'btd-tl-reuse',     icon: 'uil-sync',          label: 'Reinstalled'           },
    weak      : { cls: 'btd-tl-weak',      icon: 'uil-exclamation-triangle', label: 'Marked Weak / Faulty' },
    discard   : { cls: 'btd-tl-discard',   icon: 'uil-trash-alt',     label: 'Discarded'             }
};

/* ---- Dummy history data per battery serial ---- */
/* TODO (backend): replace this object lookup with an AJAX call:
   $.get('/inventory/battery/' + serial + '/history', batRenderTimeline); */
var BAT_DUMMY_HISTORY = {
    'BAT-2026-00081': [
        { type: 'purchase', detail: 'From Amaron Dealer · PO-2026-0016',          date: '15 Jan 2026' },
        { type: 'install',  detail: 'Fitted to TN01 AB1234 — Tata Prima (Primary)', date: '18 Jan 2026' }
        /* Battery still in warehouse — only 2 events so far */
    ],
    'BAT-2024-00044': [
        { type: 'purchase', detail: 'From Exide Dealer · Direct Purchase',           date: '02 Apr 2024' },
        { type: 'install',  detail: 'Fitted to TN03 EF9012 — Bharat Benz (Primary)', date: '05 Apr 2024' },
        { type: 'remove',   detail: 'Removed from TN03 EF9012 — Scheduled service',  date: '10 Feb 2026' },
        { type: 'workshop', detail: 'WS-HYD — Battery health check',                 date: '12 Feb 2026' }
        /* Currently in workshop */
    ],
    'BAT-2025-00063': [
        { type: 'purchase', detail: 'Via PO-2025-0041 — Exide Industries',           date: '14 Jun 2025' },
        { type: 'install',  detail: 'Fitted to TN01 AB1234 — Tata Prima (Auxiliary)',date: '17 Jun 2025' }
        /* Currently allocated */
    ],
    'BAT-2023-00027': [
        { type: 'purchase', detail: 'From Amaron Dealer · Direct',                   date: '08 Mar 2023' },
        { type: 'install',  detail: 'Fitted to TN04 GH3456 — Tata LPT (Primary)',    date: '10 Mar 2023' },
        { type: 'remove',   detail: 'Removed from TN04 GH3456 — Voltage drop issue', date: '20 Jan 2026' },
        { type: 'workshop', detail: 'WS-BLR — Fault diagnosis',                      date: '22 Jan 2026' },
        { type: 'weak',     detail: 'Marked Faulty — capacity below 60%',             date: '25 Jan 2026' }
        /* Currently faulty in workshop */
    ],
    'BAT-2022-00019': [
        { type: 'purchase', detail: 'From Amaron Dealer · Direct Purchase',           date: '05 Mar 2022' },
        { type: 'install',  detail: 'Fitted to TN02 CD5678 — Ashok Leyland (Primary)',date: '07 Mar 2022' },
        { type: 'remove',   detail: 'Removed from TN02 CD5678 — Warranty expired',    date: '10 Mar 2024' },
        { type: 'workshop', detail: 'WS-HYD — Sent for assessment',                   date: '12 Mar 2024' },
        { type: 'reuse',    detail: 'Fitted to TN05 IJ7890 — secondary use',          date: '18 Mar 2024' },
        { type: 'remove',   detail: 'Removed from TN05 IJ7890 — dead cell',           date: '02 Sep 2024' },
        { type: 'weak',     detail: 'Marked Dead — failed load test',                  date: '04 Sep 2024' },
        { type: 'discard',  detail: 'Scrapped at WH-BLR',                             date: '06 Sep 2024' }
        /* Full lifecycle — Discarded */
    ]
};

/* ---- Renderer: builds timeline HTML from event array ---- */
function batRenderTimeline(events) {
    if (!events || events.length === 0) {
        $('#batHistoryTimeline').html(
            '<div class="text-center py-4 text-muted" style="font-size:12px;">' +
            '<i class="uil uil-history" style="font-size:24px;display:block;margin-bottom:8px;"></i>' +
            'No movement history recorded yet.</div>'
        );
        return;
    }

    var html = '<div class="btd-timeline">';
    $.each(events, function (i, ev) {
        var cfg  = BAT_EVENT_TYPES[ev.type] || BAT_EVENT_TYPES['purchase'];
        var isLast = (i === events.length - 1);
        html += '<div class="btd-tl-item ' + cfg.cls + '">'
              +   '<div class="btd-tl-left">'
              +     '<div class="btd-tl-dot"><i class="uil ' + cfg.icon + '"></i></div>'
              +     (isLast ? '' : '<div class="btd-tl-line"></div>')
              +   '</div>'
              +   '<div class="btd-tl-content">'
              +     '<div class="btd-tl-event">' + cfg.label + '</div>'
              +     '<div class="btd-tl-detail">' + ev.detail + '</div>'
              +     '<div class="btd-tl-date">' + ev.date + '</div>'
              +   '</div>'
              + '</div>';
    });
    html += '</div>';

    $('#batHistoryTimeline').html(html);
}

/* ---- Load history for a given serial ---- */
function batLoadHistory(serial) {
    $('#batHistoryTimeline').html(
        '<div class="text-center py-3 text-muted" id="batHistoryLoading">' +
        '<div class="spinner-border spinner-border-sm me-2"></div> Loading…</div>'
    );

    /* ── OPTION A: dummy data (no backend) ──────────────────────────────
       Replace the two lines below with this AJAX call when backend ready:
       $.get('/inventory/battery/' + serial + '/history', batRenderTimeline)
         .fail(function(){ batRenderTimeline([]); });
       ─────────────────────────────────────────────────────────────────── */
    var events = BAT_DUMMY_HISTORY[serial] || [];
    setTimeout(function () { batRenderTimeline(events); }, 250); /* 250ms simulated load */
}

/* ============================================================ */

$(function () {

    /* ---- Tab Filter ---- */
    $('#batTabBar').on('click', '.sc-tab', function () {
        $('#batTabBar .sc-tab').removeClass('active');
        $(this).addClass('active');
        var tab = $(this).data('tab');
        if (tab === 'all') {
            $('#batDashTable tbody tr').show();
        } else {
            $('#batDashTable tbody tr').hide();
            $('#batDashTable tbody tr[data-status="' + tab + '"]').show();
        }
    });

    /* ---- Search/Reset ---- */
    $('#btnBatReset').on('click', function () {
        $('#batFilterDateFrom,#batFilterDateTo,#batFilterWarranty,#batSearch').val('');
        $('#batFilterType,#batFilterStatus').val('');
        $('#batDashTable tbody tr').show();
        $('#batTabBar .sc-tab').first().trigger('click');
    });

    /* ---- Movement History Offcanvas ---- */
    $(document).on('click', '.btn-bat-history', function () {
        var serial = $(this).data('serial');
        $('#histBatSerial').text(serial);
        $('#histBatDesc').text($(this).data('brand') + ' · ' + $(this).data('spec'));
        batLoadHistory(serial);
    });

    /* ---- Fit Battery Modal ---- */
    $(document).on('click', '[data-bs-target="#fitBatteryModal"]', function () {
        var $row = $(this).closest('tr');
        $('#fitBatSerial').text($row.find('.btd-serial').text());
        $('#fitBatDesc').text($row.find('td:eq(2)').text() + ' ' + $row.find('td:eq(3)').text()
            + ' · ' + $row.find('td:eq(5)').text() + ' / ' + $row.find('td:eq(6)').text());
    });

    $('#btnConfirmFit').on('click', function () {
        if (!$('#fitBatVeh').val()) {
            Swal.fire({ icon: 'warning', title: 'Select Vehicle', text: 'Please select a vehicle first.', confirmButtonColor: '#032671' });
            return;
        }
        Swal.fire({
            icon: 'question', title: 'Confirm Fitting?',
            text: 'Battery will be marked as Fitted and fleet record updated.',
            showCancelButton: true, confirmButtonColor: '#10863f', cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, Fit'
        }).then(function (r) {
            if (r.isConfirmed) {
                $('#fitBatteryModal').modal('hide');
                Swal.fire({ icon: 'success', title: 'Battery Fitted', confirmButtonColor: '#032671' });
            }
        });
    });

    /* ---- Add Battery Modal ---- */
    $('#addBatteryModal').on('hidden.bs.modal', function () { batResetModal(); });

    /* ---- Select2 init ---- */
    $('.select2-bat-type-manual, .select2-bat-vendor').select2({ width: '100%', dropdownParent: $('#addBatteryModal') });
    $('.select2-bat-po').select2({ width: '100%', dropdownParent: $('#addBatteryModal') });
    $('.select2-bat-grn').select2({ width: '100%', dropdownParent: $('#addBatteryModal') });
    $('.select2-fit-vehicle').select2({ width: '100%', dropdownParent: $('#fitBatteryModal') });

});

/* ---- Add Battery Path Chooser ---- */
var batChosenPath = null;

function batSelectPath(path) {
    batChosenPath = path;
    $('.btd-path-card').removeClass('selected');
    $('#batPath' + (path === 'manual' ? 'Manual' : 'PO')).addClass('selected');
    $('#btnBatPathNext').prop('disabled', false);
}

function batNextStep() {
    if (!batChosenPath) return;
    $('#batPathStep1').hide();
    $('#batFormManual, #batFormPO').hide();
    if (batChosenPath === 'manual') { $('#batFormManual').show(); }
    else                            { $('#batFormPO').show(); }
    $('#batModalFooter').show();
}

function batBackToPath() {
    $('#batFormManual, #batFormPO').hide();
    $('#batModalFooter').hide();
    $('#batPathStep1').show();
}

function batResetModal() {
    batChosenPath = null;
    $('#btnBatPathNext').prop('disabled', true);
    $('.btd-path-card').removeClass('selected');
    batBackToPath();
}
</script>
@endsection
