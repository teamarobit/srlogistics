@extends('layouts.app')

@section('css')
<link href="{{ asset('css/Toll/toll-dashboard.css?v=1.0') }}" rel="stylesheet">
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
                    <li class="breadcrumb-item"><a href="{{ route('trip.index') }}">Freight</a></li>
                    <li class="breadcrumb-item active">Toll Dashboard</li>
                </ol>
            </nav>

            {{-- Page Header --}}
            <div class="sc-page-head d-flex align-items-center justify-content-between mb-3">
                <div>
                    <h5 class="mb-0">Toll Dashboard</h5>
                    <span class="text-muted" style="font-size:12px;">FASTag summary · Toll spend tracking · Dispute monitoring</span>
                </div>
                <div class="tld-sort-badge">
                    <i class="uil uil-calendar-alt"></i> 01 Feb 2026 – 28 Feb 2026
                </div>
            </div>

            {{-- ══════════════════════════════════════════════════
                 SECTION 1 — Mini KPI Cards
            ══════════════════════════════════════════════════ --}}
            <div class="tld-kpi-row">

                {{-- Total Toll Amount --}}
                <div class="tld-kpi-card card-amount">
                    <div class="tld-kpi-label"><i class="uil uil-money-bill"></i> Total Toll Amount</div>
                    <div class="tld-kpi-amt">₹ 8,74,320</div>
                    <div class="tld-kpi-sub">Selected date range</div>
                    <div class="tld-kpi-divider"></div>
                    <div class="tld-kpi-qty"><span>1,284</span> Transactions</div>
                </div>

                {{-- Active FASTags --}}
                <div class="tld-kpi-card card-fastag">
                    <div class="tld-kpi-label"><i class="uil uil-tag-alt"></i> Active FASTags</div>
                    <div class="tld-kpi-amt">42</div>
                    <div class="tld-kpi-sub">Vehicles with live tags</div>
                    <div class="tld-kpi-divider"></div>
                    <div class="tld-kpi-qty"><span>42</span> Vehicles</div>
                </div>

                {{-- Avg. Toll / Vehicle --}}
                <div class="tld-kpi-card card-avg">
                    <div class="tld-kpi-label"><i class="uil uil-chart-line"></i> Avg. Toll / Vehicle</div>
                    <div class="tld-kpi-amt">₹ 20,817</div>
                    <div class="tld-kpi-sub">Across active vehicles</div>
                    <div class="tld-kpi-divider"></div>
                    <div class="tld-kpi-qty"><span>28</span> Days</div>
                </div>

                {{-- Disputes Raised --}}
                <div class="tld-kpi-card card-dispute">
                    <div class="tld-kpi-label"><i class="uil uil-exclamation-triangle"></i> Disputes Raised</div>
                    <div class="tld-kpi-amt">17</div>
                    <div class="tld-kpi-sub">₹ 12,640 under dispute</div>
                    <div class="tld-kpi-divider"></div>
                    <div class="tld-kpi-qty"><span>6</span> Vehicles affected</div>
                </div>

            </div>

            {{-- ══════════════════════════════════════════════════
                 SECTION 2 — Filter Card
            ══════════════════════════════════════════════════ --}}
            <div class="tld-filter-card">
                <div class="tld-filter-header">
                    <div class="tld-filter-title">
                        <i class="uil uil-filter"></i> Filters
                    </div>
                </div>
                <div class="tld-filter-body">
                <form id="tldFilterForm" method="GET" action="{{ route('toll.dashboard') }}">

                    {{-- Search bar --}}
                    <div class="row g-2 align-items-end mb-2">
                        <div class="col-lg-12 col-12">
                            <div class="tld-filter-group">
                                <label class="tld-filter-label"><i class="uil uil-search"></i> Search by Trip ID / LR Number / Memo Number</label>
                                <div class="input-group" style="flex-wrap:nowrap;">
                                    <span class="input-group-text" style="padding:0 10px;">
                                        <i class="uil uil-search" style="font-size:13px;color:#4b6cb7;"></i>
                                    </span>
                                    <input type="text" id="tldSearch" name="search" class="form-control"
                                        placeholder="Enter Trip ID, LR Number or Memo Number"
                                        value="{{ request('search') }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tld-filter-divider"></div>

                    {{-- Row 1 --}}
                    <div class="row g-2 align-items-end mb-2">

                        {{-- Date Range --}}
                        <div class="col-lg-3 col-md-4 col-12">
                            <div class="tld-filter-group">
                                <label class="tld-filter-label"><i class="uil uil-calendar-alt"></i> Date Range</label>
                                <div class="input-group" style="flex-wrap:nowrap;">
                                    <span class="input-group-text" style="padding:0 8px;">
                                        <i class="uil uil-calendar-alt" style="font-size:13px;color:#4b6cb7;"></i>
                                    </span>
                                    <input type="text" id="tldDateRange" name="date_range"
                                        class="form-control daterange"
                                        placeholder="DD-MM-YYYY – DD-MM-YYYY"
                                        value="{{ request('date_range', '01-02-2026 – 28-02-2026') }}"
                                        readonly style="cursor:pointer;">
                                </div>
                            </div>
                        </div>

                        {{-- FASTag ID --}}
                        <div class="col-lg-3 col-md-4 col-6">
                            <div class="tld-filter-group">
                                <label class="tld-filter-label"><i class="uil uil-tag-alt"></i> FASTag ID</label>
                                <input type="text" id="tldFastagId" name="fastag_id" class="form-control"
                                    placeholder="e.g. 3405xxxx1234"
                                    value="{{ request('fastag_id') }}">
                            </div>
                        </div>

                        {{-- FASTag Bank Name --}}
                        <div class="col-lg-3 col-md-4 col-6">
                            <div class="tld-filter-group">
                                <label class="tld-filter-label"><i class="uil uil-university"></i> FASTag Bank Name</label>
                                <select id="tldBank" name="bank" class="form-select">
                                    <option value="">All Banks</option>
                                    <option value="ICICI">ICICI Bank</option>
                                    <option value="HDFC">HDFC Bank</option>
                                    <option value="SBI">State Bank of India</option>
                                    <option value="Axis">Axis Bank</option>
                                    <option value="Paytm">Paytm Payments Bank</option>
                                    <option value="IDFC">IDFC First Bank</option>
                                </select>
                            </div>
                        </div>

                        {{-- Vehicle Number --}}
                        <div class="col-lg-3 col-md-4 col-6">
                            <div class="tld-filter-group">
                                <label class="tld-filter-label"><i class="uil uil-truck"></i> Vehicle Number</label>
                                <input type="text" id="tldVehicle" name="vehicle" class="form-control"
                                    placeholder="e.g. MH12AB1234"
                                    value="{{ request('vehicle') }}">
                            </div>
                        </div>

                    </div>

                    {{-- Row 2 --}}
                    <div class="row g-2 align-items-end">

                        {{-- Route Name --}}
                        <div class="col-lg-3 col-md-4 col-6">
                            <div class="tld-filter-group">
                                <label class="tld-filter-label"><i class="uil uil-map-marker"></i> Route Name</label>
                                <select id="tldRoute" name="route" class="form-select">
                                    <option value="">All Routes</option>
                                    <option value="pune-mumbai">Pune – Mumbai</option>
                                    <option value="mumbai-surat">Mumbai – Surat</option>
                                    <option value="delhi-jaipur">Delhi – Jaipur</option>
                                    <option value="ahmedabad-indore">Ahmedabad – Indore</option>
                                    <option value="nagpur-hyderabad">Nagpur – Hyderabad</option>
                                </select>
                            </div>
                        </div>

                        {{-- Driver Name & Code --}}
                        <div class="col-lg-3 col-md-4 col-6">
                            <div class="tld-filter-group">
                                <label class="tld-filter-label"><i class="uil uil-user"></i> Driver Name / Code</label>
                                <input type="text" id="tldDriver" name="driver" class="form-control"
                                    placeholder="Name or code"
                                    value="{{ request('driver') }}">
                            </div>
                        </div>

                        {{-- Dispute --}}
                        <div class="col-lg-3 col-md-4 col-6">
                            <div class="tld-filter-group">
                                <label class="tld-filter-label"><i class="uil uil-exclamation-triangle"></i> Dispute</label>
                                <select id="tldDispute" name="dispute" class="form-select">
                                    <option value="">All</option>
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                </select>
                            </div>
                        </div>

                        {{-- Reset --}}
                        <div class="col-lg-3 col-md-4 col-6 d-flex align-items-end">
                            <a href="{{ route('toll.dashboard') }}" class="tld-reset-link">
                                <i class="uil uil-redo"></i> Reset Filters
                            </a>
                        </div>

                    </div>

                </form>
                </div>{{-- /tld-filter-body --}}
            </div>

            {{-- ══════════════════════════════════════════════════
                 SECTION 3 — List Card (Vehicle Wise Tab)
            ══════════════════════════════════════════════════ --}}
            <div class="tld-table-card">

                {{-- Tabs --}}
                <div class="tld-tabs">
                    <button type="button" class="tld-tab active">
                        <i class="uil uil-truck"></i> Vehicle Wise <span class="tld-tab-sub">(FASTag Summary)</span>
                    </button>
                </div>

                <div class="tld-table-head">
                    <div class="tld-table-head-title">
                        <i class="uil uil-list-ul"></i> FASTag Summary — Vehicle Wise
                    </div>
                    <span class="text-muted" style="font-size:11px;">6 vehicles · 01 Feb 2026 – 28 Feb 2026</span>
                </div>

                <div class="tld-table table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Vehicle No.</th>
                                <th>FASTag ID</th>
                                <th>Bank Name</th>
                                <th>Current Driver</th>
                                <th>Tracking Group</th>
                                <th>Date Range</th>
                                <th style="text-align:right;">Total Amount</th>
                                <th style="text-align:center;">Disputes</th>
                                <th style="text-align:center;">Details</th>
                            </tr>
                        </thead>
                        <tbody>

                            {{-- Row 1 --}}
                            <tr>
                                <td><span class="tld-reg">MH12AB1234</span></td>
                                <td style="font-family:monospace;font-size:11px;font-weight:700;color:#032671;">3405 6789 1234</td>
                                <td style="font-size:12px;">ICICI Bank</td>
                                <td>
                                    <div class="tld-driver-name">Ramesh Kumar</div>
                                    <div class="tld-driver-code">D001</div>
                                </td>
                                <td style="font-size:12px;">North Zone</td>
                                <td style="font-size:11px;white-space:nowrap;">01/02/2026 – 28/02/2026</td>
                                <td style="text-align:right;font-size:12px;font-weight:700;">₹ 42,180</td>
                                <td style="text-align:center;"><span class="tld-dispute-badge tld-dispute-has">3</span></td>
                                <td style="text-align:center;">
                                    <button type="button" class="tld-view-btn" data-bs-toggle="modal" data-bs-target="#tldDetailModal"
                                        data-vehicle="MH12AB1234" data-fastag="3405 6789 1234" data-bank="ICICI Bank">
                                        <i class="uil uil-eye"></i> View
                                    </button>
                                </td>
                            </tr>

                            {{-- Row 2 --}}
                            <tr>
                                <td><span class="tld-reg">GJ01CD5678</span></td>
                                <td style="font-family:monospace;font-size:11px;font-weight:700;color:#032671;">3405 7712 5678</td>
                                <td style="font-size:12px;">HDFC Bank</td>
                                <td>
                                    <div class="tld-driver-name">Suresh Singh</div>
                                    <div class="tld-driver-code">D002</div>
                                </td>
                                <td style="font-size:12px;">West Zone</td>
                                <td style="font-size:11px;white-space:nowrap;">01/02/2026 – 28/02/2026</td>
                                <td style="text-align:right;font-size:12px;font-weight:700;">₹ 38,940</td>
                                <td style="text-align:center;"><span class="tld-dispute-badge tld-dispute-none">0</span></td>
                                <td style="text-align:center;">
                                    <button type="button" class="tld-view-btn" data-bs-toggle="modal" data-bs-target="#tldDetailModal"
                                        data-vehicle="GJ01CD5678" data-fastag="3405 7712 5678" data-bank="HDFC Bank">
                                        <i class="uil uil-eye"></i> View
                                    </button>
                                </td>
                            </tr>

                            {{-- Row 3 --}}
                            <tr>
                                <td><span class="tld-reg">RJ14EF9012</span></td>
                                <td style="font-family:monospace;font-size:11px;font-weight:700;color:#032671;">3405 8890 9012</td>
                                <td style="font-size:12px;">State Bank of India</td>
                                <td>
                                    <div class="tld-driver-name">Mahesh Yadav</div>
                                    <div class="tld-driver-code">D003</div>
                                </td>
                                <td style="font-size:12px;">North Zone</td>
                                <td style="font-size:11px;white-space:nowrap;">01/02/2026 – 28/02/2026</td>
                                <td style="text-align:right;font-size:12px;font-weight:700;">₹ 51,260</td>
                                <td style="text-align:center;"><span class="tld-dispute-badge tld-dispute-has">2</span></td>
                                <td style="text-align:center;">
                                    <button type="button" class="tld-view-btn" data-bs-toggle="modal" data-bs-target="#tldDetailModal"
                                        data-vehicle="RJ14EF9012" data-fastag="3405 8890 9012" data-bank="State Bank of India">
                                        <i class="uil uil-eye"></i> View
                                    </button>
                                </td>
                            </tr>

                            {{-- Row 4 --}}
                            <tr>
                                <td><span class="tld-reg">DL3CBA3456</span></td>
                                <td style="font-family:monospace;font-size:11px;font-weight:700;color:#032671;">3405 2245 3456</td>
                                <td style="font-size:12px;">Axis Bank</td>
                                <td>
                                    <div class="tld-driver-name">Dinesh Patel</div>
                                    <div class="tld-driver-code">D004</div>
                                </td>
                                <td style="font-size:12px;">South Zone</td>
                                <td style="font-size:11px;white-space:nowrap;">01/02/2026 – 28/02/2026</td>
                                <td style="text-align:right;font-size:12px;font-weight:700;">₹ 29,750</td>
                                <td style="text-align:center;"><span class="tld-dispute-badge tld-dispute-has">1</span></td>
                                <td style="text-align:center;">
                                    <button type="button" class="tld-view-btn" data-bs-toggle="modal" data-bs-target="#tldDetailModal"
                                        data-vehicle="DL3CBA3456" data-fastag="3405 2245 3456" data-bank="Axis Bank">
                                        <i class="uil uil-eye"></i> View
                                    </button>
                                </td>
                            </tr>

                            {{-- Row 5 --}}
                            <tr>
                                <td><span class="tld-reg">UP32GH7890</span></td>
                                <td style="font-family:monospace;font-size:11px;font-weight:700;color:#032671;">3405 6634 7890</td>
                                <td style="font-size:12px;">Paytm Payments Bank</td>
                                <td>
                                    <div class="tld-driver-name">Vijay Sharma</div>
                                    <div class="tld-driver-code">D005</div>
                                </td>
                                <td style="font-size:12px;">East Zone</td>
                                <td style="font-size:11px;white-space:nowrap;">01/02/2026 – 28/02/2026</td>
                                <td style="text-align:right;font-size:12px;font-weight:700;">₹ 45,610</td>
                                <td style="text-align:center;"><span class="tld-dispute-badge tld-dispute-has">4</span></td>
                                <td style="text-align:center;">
                                    <button type="button" class="tld-view-btn" data-bs-toggle="modal" data-bs-target="#tldDetailModal"
                                        data-vehicle="UP32GH7890" data-fastag="3405 6634 7890" data-bank="Paytm Payments Bank">
                                        <i class="uil uil-eye"></i> View
                                    </button>
                                </td>
                            </tr>

                            {{-- Row 6 --}}
                            <tr>
                                <td><span class="tld-reg">MP09IJ2345</span></td>
                                <td style="font-family:monospace;font-size:11px;font-weight:700;color:#032671;">3405 5521 2345</td>
                                <td style="font-size:12px;">IDFC First Bank</td>
                                <td>
                                    <div class="tld-driver-name">Arjun Tiwari</div>
                                    <div class="tld-driver-code">D006</div>
                                </td>
                                <td style="font-size:12px;">West Zone</td>
                                <td style="font-size:11px;white-space:nowrap;">01/02/2026 – 28/02/2026</td>
                                <td style="text-align:right;font-size:12px;font-weight:700;">₹ 33,420</td>
                                <td style="text-align:center;"><span class="tld-dispute-badge tld-dispute-none">0</span></td>
                                <td style="text-align:center;">
                                    <button type="button" class="tld-view-btn" data-bs-toggle="modal" data-bs-target="#tldDetailModal"
                                        data-vehicle="MP09IJ2345" data-fastag="3405 5521 2345" data-bank="IDFC First Bank">
                                        <i class="uil uil-eye"></i> View
                                    </button>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
            {{-- /table --}}

        </div>{{-- /sc-no-sidebar --}}
    </div>{{-- /wrapper --}}
</div>{{-- /layout-wrapper --}}

{{-- ══════════════════════════════════════════════════
     View Full Details Modal (static)
══════════════════════════════════════════════════ --}}
<div class="modal fade" id="tldDetailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content tld-modal">
            <div class="modal-header">
                <div>
                    <h6 class="modal-title mb-0" id="tldModalVehicle">Toll Transactions</h6>
                    <span class="tld-modal-sub" id="tldModalMeta">FASTag details</span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                {{-- Summary strip --}}
                <div class="tld-modal-summary">
                    <div class="tld-modal-stat">
                        <div class="tld-modal-stat-label">Total Transactions</div>
                        <div class="tld-modal-stat-val">8</div>
                    </div>
                    <div class="tld-modal-stat">
                        <div class="tld-modal-stat-label">Total Amount</div>
                        <div class="tld-modal-stat-val">₹ 3,120</div>
                    </div>
                    <div class="tld-modal-stat">
                        <div class="tld-modal-stat-label">Disputed</div>
                        <div class="tld-modal-stat-val" style="color:#dc2626;">₹ 420</div>
                    </div>
                </div>

                <div class="tld-modal-table table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Date &amp; Time</th>
                                <th>Toll Plaza / Name</th>
                                <th>Route</th>
                                <th style="text-align:right;">Amount</th>
                                <th style="text-align:center;">Dispute</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="white-space:nowrap;">02 Feb 2026, 06:42 AM</td>
                                <td>Khed Shivapur Toll Plaza</td>
                                <td style="font-size:11px;color:#6b7280;">Pune – Mumbai</td>
                                <td style="text-align:right;font-weight:700;">₹ 340</td>
                                <td style="text-align:center;"><span class="tld-no">No</span></td>
                            </tr>
                            <tr>
                                <td style="white-space:nowrap;">05 Feb 2026, 11:18 AM</td>
                                <td>Talegaon Toll Plaza</td>
                                <td style="font-size:11px;color:#6b7280;">Pune – Mumbai</td>
                                <td style="text-align:right;font-weight:700;">₹ 210</td>
                                <td style="text-align:center;"><span class="tld-yes">Yes</span></td>
                            </tr>
                            <tr>
                                <td style="white-space:nowrap;">09 Feb 2026, 03:55 PM</td>
                                <td>Kharghar Toll Plaza</td>
                                <td style="font-size:11px;color:#6b7280;">Mumbai – Surat</td>
                                <td style="text-align:right;font-weight:700;">₹ 385</td>
                                <td style="text-align:center;"><span class="tld-no">No</span></td>
                            </tr>
                            <tr>
                                <td style="white-space:nowrap;">13 Feb 2026, 09:07 AM</td>
                                <td>Charoti Toll Plaza</td>
                                <td style="font-size:11px;color:#6b7280;">Mumbai – Surat</td>
                                <td style="text-align:right;font-weight:700;">₹ 420</td>
                                <td style="text-align:center;"><span class="tld-yes">Yes</span></td>
                            </tr>
                            <tr>
                                <td style="white-space:nowrap;">17 Feb 2026, 07:30 PM</td>
                                <td>Bhilad Toll Plaza</td>
                                <td style="font-size:11px;color:#6b7280;">Mumbai – Surat</td>
                                <td style="text-align:right;font-weight:700;">₹ 365</td>
                                <td style="text-align:center;"><span class="tld-no">No</span></td>
                            </tr>
                            <tr>
                                <td style="white-space:nowrap;">21 Feb 2026, 01:12 PM</td>
                                <td>Kamothe Toll Plaza</td>
                                <td style="font-size:11px;color:#6b7280;">Pune – Mumbai</td>
                                <td style="text-align:right;font-weight:700;">₹ 290</td>
                                <td style="text-align:center;"><span class="tld-no">No</span></td>
                            </tr>
                            <tr>
                                <td style="white-space:nowrap;">24 Feb 2026, 10:48 AM</td>
                                <td>Khalapur Toll Plaza</td>
                                <td style="font-size:11px;color:#6b7280;">Pune – Mumbai</td>
                                <td style="text-align:right;font-weight:700;">₹ 700</td>
                                <td style="text-align:center;"><span class="tld-no">No</span></td>
                            </tr>
                            <tr>
                                <td style="white-space:nowrap;">27 Feb 2026, 05:20 AM</td>
                                <td>Talegaon Toll Plaza</td>
                                <td style="font-size:11px;color:#6b7280;">Pune – Mumbai</td>
                                <td style="text-align:right;font-weight:700;">₹ 410</td>
                                <td style="text-align:center;"><span class="tld-no">No</span></td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" style="text-align:right;font-weight:700;">Total</td>
                                <td style="text-align:right;font-weight:800;color:#032671;">₹ 3,120</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="tld-modal-close" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('js/Toll/toll-dashboard.js?v=1.0') }}"></script>
@endsection
