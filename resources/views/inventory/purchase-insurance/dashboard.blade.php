@extends('layouts.app')

@section('css')
<link href="{{ asset('css/Inventory/purchase-insurance-dashboard.css?v=2.4') }}" rel="stylesheet">
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
                    <li class="breadcrumb-item active">Purchase Insurance Dashboard</li>
                </ol>
            </nav>

            {{-- Page Header --}}
            <div class="sc-page-head d-flex align-items-center justify-content-between mb-3">
                <div>
                    <h5 class="mb-0">Purchase Insurance Dashboard</h5>
                    <span class="text-muted" style="font-size:12px;">Claims tracking · Settlement monitoring · Driver accountability</span>
                </div>
                <div class="pid-sort-badge">
                    <i class="uil uil-sort-amount-down"></i> Sorted: High → Low (Actual Paid)
                </div>
            </div>

            {{-- ══════════════════════════════════════════════════
                 SECTION 1 — Claim Financials
            ══════════════════════════════════════════════════ --}}
            <div class="pid-group-head"><span class="pid-group-title">Claim Financials</span></div>
            <div class="pid-cards">

                {{-- Total Actual Paid --}}
                <div class="pid-card">
                    <div class="pid-card-top">
                        <span class="pid-card-ico ico-navy"><i class="uil uil-money-bill"></i></span>
                        <span class="pid-card-label">Total Actual Paid</span>
                    </div>
                    <div class="pid-card-val">₹ 28,46,500</div>
                    <div class="pid-card-sub">Amount paid to workshops</div>
                    <div class="pid-card-foot"><span>42</span> Claims</div>
                </div>

                {{-- Total Claimed --}}
                <div class="pid-card">
                    <div class="pid-card-top">
                        <span class="pid-card-ico ico-navy"><i class="uil uil-file-alt"></i></span>
                        <span class="pid-card-label">Total Claimed</span>
                    </div>
                    <div class="pid-card-val">₹ 31,20,000</div>
                    <div class="pid-card-sub">Filed with insurer</div>
                    <div class="pid-card-foot"><span>42</span> Claims</div>
                </div>

                {{-- Total Settled --}}
                <div class="pid-card">
                    <div class="pid-card-top">
                        <span class="pid-card-ico ico-green"><i class="uil uil-check-circle"></i></span>
                        <span class="pid-card-label">Total Settled</span>
                    </div>
                    <div class="pid-card-val">₹ 24,85,000</div>
                    <div class="pid-card-sub">Received from insurer</div>
                    <div class="pid-card-foot"><span>28</span> Claims</div>
                </div>

                {{-- Excess / Short (Actual Paid − Settled) --}}
                <div class="pid-card">
                    <div class="pid-card-top">
                        <span class="pid-card-ico ico-amber"><i class="uil uil-exclamation-triangle"></i></span>
                        <span class="pid-card-label">Excess / Short (vs Settled)</span>
                    </div>
                    <div class="pid-card-val">₹ 3,61,500</div>
                    <div class="pid-card-sub">Paid − Settled (net borne)</div>
                    <div class="pid-card-foot"><span>14</span> Open &amp; Unsettled</div>
                </div>

                {{-- Excess / Short (Actual Paid − Claim Approved) --}}
                <div class="pid-card">
                    <div class="pid-card-top">
                        <span class="pid-card-ico ico-amber"><i class="uil uil-balance-scale"></i></span>
                        <span class="pid-card-label">Excess / Short (vs Approved)</span>
                    </div>
                    <div class="pid-card-val">₹ 2,56,500</div>
                    <div class="pid-card-sub">Paid − Claim Approved</div>
                    <div class="pid-card-foot"><span>36</span> Approved Claims</div>
                </div>

            </div>

            {{-- ══════════════════════════════════════════════════
                 SECTION 1B — Claim Status Breakdown
            ══════════════════════════════════════════════════ --}}
            <div class="pid-group-head"><span class="pid-group-title">Claim Status Breakdown</span></div>
            <div class="pid-cards">

                <div class="pid-card pid-card-sm">
                    <div class="pid-card-top">
                        <span class="pid-card-ico ico-navy"><i class="uil uil-file-plus-alt"></i></span>
                        <span class="pid-card-label">Claim Initiated</span>
                    </div>
                    <div class="pid-card-val">8</div>
                </div>

                <div class="pid-card pid-card-sm">
                    <div class="pid-card-top">
                        <span class="pid-card-ico ico-navy"><i class="uil uil-clipboard-notes"></i></span>
                        <span class="pid-card-label">Survey Completed</span>
                    </div>
                    <div class="pid-card-val">6</div>
                </div>

                <div class="pid-card pid-card-sm">
                    <div class="pid-card-top">
                        <span class="pid-card-ico ico-amber"><i class="uil uil-wrench"></i></span>
                        <span class="pid-card-label">Repair in Progress</span>
                    </div>
                    <div class="pid-card-val">9</div>
                </div>

                <div class="pid-card pid-card-sm">
                    <div class="pid-card-top">
                        <span class="pid-card-ico ico-amber"><i class="uil uil-hourglass"></i></span>
                        <span class="pid-card-label">Awaiting Claim Settlement</span>
                    </div>
                    <div class="pid-card-val">5</div>
                </div>

                <div class="pid-card pid-card-sm">
                    <div class="pid-card-top">
                        <span class="pid-card-ico ico-green"><i class="uil uil-check-circle"></i></span>
                        <span class="pid-card-label">Claim Settled</span>
                    </div>
                    <div class="pid-card-val">14</div>
                </div>

            </div>

            {{-- ══════════════════════════════════════════════════
                 SECTION 2 — Filter Card
            ══════════════════════════════════════════════════ --}}
            <div class="pid-filter-card">
                <div class="pid-filter-header">
                    <div class="pid-filter-title">
                        <i class="uil uil-filter"></i> Filters
                    </div>
                </div>
                <div class="pid-filter-body">
                <form id="pidFilterForm" method="GET" action="{{ route('inventory.purchase-insurance.dashboard') }}">

                    {{-- Row 1 --}}
                    <div class="row g-2 align-items-end mb-2">

                        {{-- Date Range --}}
                        <div class="col-lg-2 col-md-4 col-12">
                            <div class="pid-filter-group">
                                <label class="pid-filter-label"><i class="uil uil-calendar-alt"></i> Date Range</label>
                                <div class="input-group" style="flex-wrap:nowrap;">
                                    <span class="input-group-text" style="padding:0 8px;">
                                        <i class="uil uil-calendar-alt" style="font-size:13px;color:#4b6cb7;"></i>
                                    </span>
                                    <input type="text" id="pidDateRange" name="date_range"
                                        class="form-control daterange"
                                        placeholder="DD-MM-YYYY – DD-MM-YYYY"
                                        value="{{ request('date_range') }}"
                                        readonly style="cursor:pointer;">
                                </div>
                            </div>
                        </div>

                        {{-- Vehicle Number --}}
                        <div class="col-lg-2 col-md-3 col-6">
                            <div class="pid-filter-group">
                                <label class="pid-filter-label"><i class="uil uil-truck"></i> Vehicle Number</label>
                                <input type="text" id="pidVehicle" name="vehicle" class="form-control"
                                    placeholder="e.g. MH12AB1234"
                                    value="{{ request('vehicle') }}">
                            </div>
                        </div>

                        {{-- Driver Name & Code --}}
                        <div class="col-lg-2 col-md-3 col-6">
                            <div class="pid-filter-group">
                                <label class="pid-filter-label"><i class="uil uil-user"></i> Driver Name / Code</label>
                                <input type="text" id="pidDriver" name="driver" class="form-control"
                                    placeholder="Name or code"
                                    value="{{ request('driver') }}">
                            </div>
                        </div>

                        {{-- Tracking Group --}}
                        <div class="col-lg-2 col-md-3 col-6">
                            <div class="pid-filter-group">
                                <label class="pid-filter-label"><i class="uil uil-layer-group"></i> Tracking Group</label>
                                <select id="pidTrackingGroup" name="tracking_group" class="form-select">
                                    <option value="">All Groups</option>
                                    <option value="north">North Zone</option>
                                    <option value="south">South Zone</option>
                                    <option value="west">West Zone</option>
                                    <option value="east">East Zone</option>
                                </select>
                            </div>
                        </div>

                        {{-- State --}}
                        <div class="col-lg-2 col-md-3 col-6">
                            <div class="pid-filter-group">
                                <label class="pid-filter-label"><i class="uil uil-map-marker"></i> Location (State)</label>
                                <select id="pidState" name="state" class="form-select">
                                    <option value="">All States</option>
                                    <option value="MH">Maharashtra</option>
                                    <option value="GJ">Gujarat</option>
                                    <option value="RJ">Rajasthan</option>
                                    <option value="DL">Delhi</option>
                                    <option value="UP">Uttar Pradesh</option>
                                    <option value="MP">Madhya Pradesh</option>
                                </select>
                            </div>
                        </div>

                        {{-- Status --}}
                        <div class="col-lg-2 col-md-3 col-6">
                            <div class="pid-filter-group">
                                <label class="pid-filter-label"><i class="uil uil-tag-alt"></i> Status</label>
                                <select id="pidStatus" name="status" class="form-select">
                                    <option value="">All Statuses</option>
                                    <option value="Claim Initiated">Claim Initiated</option>
                                    <option value="Survey Completed">Survey Completed</option>
                                    <option value="Repair in Progress">Repair in Progress</option>
                                    <option value="Awaiting Claim Settlement">Awaiting Claim Settlement</option>
                                    <option value="Claim Settled">Claim Settled</option>
                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="pid-filter-divider"></div>

                    {{-- Row 2 --}}
                    <div class="row g-2 align-items-end">

                        {{-- Driver Mistake --}}
                        <div class="col-lg-2 col-md-3 col-6">
                            <div class="pid-filter-group">
                                <label class="pid-filter-label"><i class="uil uil-exclamation-triangle"></i> Driver Mistake</label>
                                <select id="pidDriverMistake" name="driver_mistake" class="form-select">
                                    <option value="">All</option>
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                </select>
                            </div>
                        </div>

                        {{-- FIR --}}
                        <div class="col-lg-2 col-md-3 col-6">
                            <div class="pid-filter-group">
                                <label class="pid-filter-label"><i class="uil uil-file-shield-alt"></i> FIR</label>
                                <select id="pidFir" name="fir" class="form-select">
                                    <option value="">All</option>
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                </select>
                            </div>
                        </div>

                        {{-- Reset --}}
                        <div class="col-auto d-flex align-items-end">
                            <a href="{{ route('inventory.purchase-insurance.dashboard') }}" class="pid-reset-link">
                                <i class="uil uil-redo"></i> Reset Filters
                            </a>
                        </div>

                    </div>

                </form>
                </div>{{-- /pid-filter-body --}}
            </div>

            {{-- ══════════════════════════════════════════════════
                 SECTION 3 — Table List
            ══════════════════════════════════════════════════ --}}
            <div class="pid-table-card">
                <div class="pid-table-head">
                    <div class="pid-table-head-title">
                        <i class="uil uil-list-ul"></i> Insurance Claims
                    </div>
                    <span class="text-muted" style="font-size:11px;">42 records · Sorted: Actual Paid ↓</span>
                </div>

                <div class="pid-table table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Vehicle No.</th>
                                <th>Driver</th>
                                <th>RAG</th>
                                <th>Tracking Group</th>
                                <th>Claim No.</th>
                                <th>Incident Date</th>
                                <th>Location (State)</th>
                                <th>Incident Type</th>
                                <th>Driver Mistake</th>
                                <th>FIR No.</th>
                                <th>Workshop Name</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>

                            {{-- Row 1 --}}
                            <tr>
                                <td><span class="pid-reg">MH12AB1234</span></td>
                                <td>
                                    <div class="pid-driver-name">Ramesh Kumar</div>
                                    <div class="pid-driver-code">D001</div>
                                </td>
                                <td>
                                    <span class="pid-rag pid-rag-r"></span>
                                    <span class="pid-rag-label" style="color:#dc2626;">Red</span>
                                </td>
                                <td style="font-size:12px;">North Zone</td>
                                <td style="font-family:monospace;font-size:11px;font-weight:700;color:#032671;">CLM-2026-0001</td>
                                <td style="font-size:12px;white-space:nowrap;">14 Jan 2026</td>
                                <td style="font-size:12px;">Maharashtra</td>
                                <td>
                                    <span style="background:#e3ecff;color:#032671;font-size:10px;font-weight:700;padding:2px 8px;border-radius:10px;">Own Damage</span>
                                </td>
                                <td><span class="pid-yes">Yes</span></td>
                                <td style="font-size:12px;font-weight:600;">FIR/2026/MH/001</td>
                                <td>
                                    <div class="pid-ws-item">
                                        <span class="pid-ws-badge pid-ws-badge-mech">Mechanical Workshop</span>
                                        <span class="pid-ws-name">SR Workshop — Pune</span>
                                    </div>
                                    <div class="pid-ws-item">
                                        <span class="pid-ws-badge pid-ws-badge-body">Body Workshop</span>
                                        <span class="pid-ws-name">Shine Auto Body Works</span>
                                    </div>
                                </td>
                                <td><a href="#" class="pid-view-btn"><i class="uil uil-eye"></i> View</a></td>
                            </tr>

                            {{-- Row 2 --}}
                            <tr>
                                <td><span class="pid-reg">GJ01CD5678</span></td>
                                <td>
                                    <div class="pid-driver-name">Suresh Singh</div>
                                    <div class="pid-driver-code">D002</div>
                                </td>
                                <td>
                                    <span class="pid-rag pid-rag-a"></span>
                                    <span class="pid-rag-label" style="color:#f59e0b;">Amber</span>
                                </td>
                                <td style="font-size:12px;">West Zone</td>
                                <td style="font-family:monospace;font-size:11px;font-weight:700;color:#032671;">CLM-2026-0002</td>
                                <td style="font-size:12px;white-space:nowrap;">02 Feb 2026</td>
                                <td style="font-size:12px;">Gujarat</td>
                                <td>
                                    <span style="background:#fff3e0;color:#c45a00;font-size:10px;font-weight:700;padding:2px 8px;border-radius:10px;">Third Party</span>
                                </td>
                                <td><span class="pid-no">No</span></td>
                                <td style="font-size:12px;color:#9ca3af;">NO</td>
                                <td>
                                    <div class="pid-ws-item">
                                        <span class="pid-ws-badge pid-ws-badge-mech">Mechanical Workshop</span>
                                        <span class="pid-ws-name">National Auto Garage</span>
                                    </div>
                                    <div class="pid-ws-item">
                                        <span class="pid-ws-badge pid-ws-badge-body">Body Workshop</span>
                                        <span class="pid-ws-name">—</span>
                                    </div>
                                </td>
                                <td><a href="#" class="pid-view-btn"><i class="uil uil-eye"></i> View</a></td>
                            </tr>

                            {{-- Row 3 --}}
                            <tr>
                                <td><span class="pid-reg">RJ14EF9012</span></td>
                                <td>
                                    <div class="pid-driver-name">Mahesh Yadav</div>
                                    <div class="pid-driver-code">D003</div>
                                </td>
                                <td>
                                    <span class="pid-rag pid-rag-g"></span>
                                    <span class="pid-rag-label" style="color:#16a34a;">Green</span>
                                </td>
                                <td style="font-size:12px;">North Zone</td>
                                <td style="font-family:monospace;font-size:11px;font-weight:700;color:#032671;">CLM-2026-0003</td>
                                <td style="font-size:12px;white-space:nowrap;">18 Feb 2026</td>
                                <td style="font-size:12px;">Rajasthan</td>
                                <td>
                                    <span style="background:#fdecea;color:#ea0027;font-size:10px;font-weight:700;padding:2px 8px;border-radius:10px;">Theft</span>
                                </td>
                                <td><span class="pid-no">No</span></td>
                                <td style="font-size:12px;font-weight:600;">FIR/2026/RJ/004</td>
                                <td>
                                    <div class="pid-ws-item">
                                        <span class="pid-ws-badge pid-ws-badge-mech">Mechanical Workshop</span>
                                        <span class="pid-ws-name">—</span>
                                    </div>
                                    <div class="pid-ws-item">
                                        <span class="pid-ws-badge pid-ws-badge-body">Body Workshop</span>
                                        <span class="pid-ws-name">—</span>
                                    </div>
                                </td>
                                <td><a href="#" class="pid-view-btn"><i class="uil uil-eye"></i> View</a></td>
                            </tr>

                            {{-- Row 4 --}}
                            <tr>
                                <td><span class="pid-reg">DL3CBA3456</span></td>
                                <td>
                                    <div class="pid-driver-name">Dinesh Patel</div>
                                    <div class="pid-driver-code">D004</div>
                                </td>
                                <td>
                                    <span class="pid-rag pid-rag-r"></span>
                                    <span class="pid-rag-label" style="color:#dc2626;">Red</span>
                                </td>
                                <td style="font-size:12px;">South Zone</td>
                                <td style="font-family:monospace;font-size:11px;font-weight:700;color:#032671;">CLM-2026-0004</td>
                                <td style="font-size:12px;white-space:nowrap;">05 Mar 2026</td>
                                <td style="font-size:12px;">Delhi</td>
                                <td>
                                    <span style="background:#e3ecff;color:#032671;font-size:10px;font-weight:700;padding:2px 8px;border-radius:10px;">Own Damage</span>
                                </td>
                                <td><span class="pid-yes">Yes</span></td>
                                <td style="font-size:12px;font-weight:600;">FIR/2026/DL/007</td>
                                <td>
                                    <div class="pid-ws-item">
                                        <span class="pid-ws-badge pid-ws-badge-mech">Mechanical Workshop</span>
                                        <span class="pid-ws-name">Singh Auto Repairs</span>
                                    </div>
                                    <div class="pid-ws-item">
                                        <span class="pid-ws-badge pid-ws-badge-body">Body Workshop</span>
                                        <span class="pid-ws-name">Capital Body Works</span>
                                    </div>
                                </td>
                                <td><a href="#" class="pid-view-btn"><i class="uil uil-eye"></i> View</a></td>
                            </tr>

                            {{-- Row 5 --}}
                            <tr>
                                <td><span class="pid-reg">UP32GH7890</span></td>
                                <td>
                                    <div class="pid-driver-name">Vijay Sharma</div>
                                    <div class="pid-driver-code">D005</div>
                                </td>
                                <td>
                                    <span class="pid-rag pid-rag-a"></span>
                                    <span class="pid-rag-label" style="color:#f59e0b;">Amber</span>
                                </td>
                                <td style="font-size:12px;">East Zone</td>
                                <td style="font-family:monospace;font-size:11px;font-weight:700;color:#032671;">CLM-2026-0005</td>
                                <td style="font-size:12px;white-space:nowrap;">22 Mar 2026</td>
                                <td style="font-size:12px;">Uttar Pradesh</td>
                                <td>
                                    <span style="background:#f3e5f5;color:#7b1fa2;font-size:10px;font-weight:700;padding:2px 8px;border-radius:10px;">Fire</span>
                                </td>
                                <td><span class="pid-no">No</span></td>
                                <td style="font-size:12px;font-weight:600;">FIR/2026/UP/011</td>
                                <td>
                                    <div class="pid-ws-item">
                                        <span class="pid-ws-badge pid-ws-badge-mech">Mechanical Workshop</span>
                                        <span class="pid-ws-name">Lucknow Auto Centre</span>
                                    </div>
                                    <div class="pid-ws-item">
                                        <span class="pid-ws-badge pid-ws-badge-body">Body Workshop</span>
                                        <span class="pid-ws-name">Perfect Dent & Paint</span>
                                    </div>
                                </td>
                                <td><a href="#" class="pid-view-btn"><i class="uil uil-eye"></i> View</a></td>
                            </tr>

                            {{-- Row 6 --}}
                            <tr>
                                <td><span class="pid-reg">MP09IJ2345</span></td>
                                <td>
                                    <div class="pid-driver-name">Arjun Tiwari</div>
                                    <div class="pid-driver-code">D006</div>
                                </td>
                                <td>
                                    <span class="pid-rag pid-rag-g"></span>
                                    <span class="pid-rag-label" style="color:#16a34a;">Green</span>
                                </td>
                                <td style="font-size:12px;">West Zone</td>
                                <td style="font-family:monospace;font-size:11px;font-weight:700;color:#032671;">CLM-2026-0006</td>
                                <td style="font-size:12px;white-space:nowrap;">10 Apr 2026</td>
                                <td style="font-size:12px;">Madhya Pradesh</td>
                                <td>
                                    <span style="background:#e3ecff;color:#032671;font-size:10px;font-weight:700;padding:2px 8px;border-radius:10px;">Own Damage</span>
                                </td>
                                <td><span class="pid-yes">Yes</span></td>
                                <td style="font-size:12px;color:#9ca3af;">NO</td>
                                <td>
                                    <div class="pid-ws-item">
                                        <span class="pid-ws-badge pid-ws-badge-mech">Mechanical Workshop</span>
                                        <span class="pid-ws-name">Bhopal Motors</span>
                                    </div>
                                    <div class="pid-ws-item">
                                        <span class="pid-ws-badge pid-ws-badge-body">Body Workshop</span>
                                        <span class="pid-ws-name">—</span>
                                    </div>
                                </td>
                                <td><a href="#" class="pid-view-btn"><i class="uil uil-eye"></i> View</a></td>
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
     Maintenance & Scheduled Service — Modal (opened from row View button)
══════════════════════════════════════════════════ --}}
<div class="modal fade" id="pidMaintenanceModal" tabindex="-1" aria-labelledby="pidMaintenanceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content pid-modal-content">
            <div class="modal-header pid-modal-header">
                <div class="pid-modal-head-left">
                    <span class="pid-modal-ico"><i class="uil uil-wrench"></i></span>
                    <div>
                        <h5 class="modal-title" id="pidMaintenanceModalLabel">Maintenance &amp; Scheduled Service</h5>
                        <span class="pid-modal-sub" id="pidMaintenanceModalMeta">Vehicle overview</span>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pid-modal-body">

                <div class="pid-modal-section">
                    <span class="pid-modal-section-title">Service Overview</span>
                </div>

                <div class="pid-cards pid-modal-cards">

                    {{-- Maintenance Cost — Qty & Amount --}}
                    <div class="pid-card">
                        <div class="pid-card-top">
                            <span class="pid-card-ico ico-navy"><i class="uil uil-constructor"></i></span>
                            <span class="pid-card-label">Maintenance Cost</span>
                        </div>
                        <div class="pid-card-val">₹ 8,74,200</div>
                        <div class="pid-card-sub">Total maintenance spend</div>
                        <div class="pid-card-foot"><span>156</span> Jobs</div>
                    </div>

                    {{-- Total Scheduled Service --}}
                    <div class="pid-card">
                        <div class="pid-card-top">
                            <span class="pid-card-ico ico-navy"><i class="uil uil-calendar-alt"></i></span>
                            <span class="pid-card-label">Total Scheduled Service</span>
                        </div>
                        <div class="pid-card-val">120</div>
                        <div class="pid-card-sub">Services in range</div>
                        <div class="pid-card-foot"><span>120</span> Qty</div>
                    </div>

                    {{-- Completed Scheduled Service --}}
                    <div class="pid-card">
                        <div class="pid-card-top">
                            <span class="pid-card-ico ico-green"><i class="uil uil-check-circle"></i></span>
                            <span class="pid-card-label">Completed Scheduled Service</span>
                        </div>
                        <div class="pid-card-val">86</div>
                        <div class="pid-card-sub">Services done</div>
                        <div class="pid-card-foot"><span>86</span> Qty</div>
                    </div>

                    {{-- Missed Scheduled Service --}}
                    <div class="pid-card">
                        <div class="pid-card-top">
                            <span class="pid-card-ico ico-red"><i class="uil uil-times-circle"></i></span>
                            <span class="pid-card-label">Missed Scheduled Service</span>
                        </div>
                        <div class="pid-card-val">12</div>
                        <div class="pid-card-sub">Overdue / not done</div>
                        <div class="pid-card-foot"><span>12</span> Qty</div>
                    </div>

                    {{-- Pending Scheduled Service --}}
                    <div class="pid-card">
                        <div class="pid-card-top">
                            <span class="pid-card-ico ico-amber"><i class="uil uil-clock"></i></span>
                            <span class="pid-card-label">Pending Scheduled Service</span>
                        </div>
                        <div class="pid-card-val">22</div>
                        <div class="pid-card-sub">Upcoming / not yet due</div>
                        <div class="pid-card-foot"><span>22</span> Qty</div>
                    </div>

                </div>

                <div class="pid-modal-section">
                    <span class="pid-modal-section-title">Recent Service History</span>
                </div>

                <div class="table-responsive pid-modal-table">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Service</th>
                                <th>Type</th>
                                <th>Date</th>
                                <th style="text-align:right;">Odometer</th>
                                <th style="text-align:right;">Cost</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Engine Oil &amp; Filter Change</td>
                                <td>Scheduled</td>
                                <td>12 Jun 2026</td>
                                <td style="text-align:right;">1,42,300 km</td>
                                <td style="text-align:right;">₹ 18,500</td>
                                <td><span class="pid-status pid-status-settled">Completed</span></td>
                            </tr>
                            <tr>
                                <td>Brake Pad Replacement</td>
                                <td>Repair</td>
                                <td>28 May 2026</td>
                                <td style="text-align:right;">1,39,850 km</td>
                                <td style="text-align:right;">₹ 12,200</td>
                                <td><span class="pid-status pid-status-settled">Completed</span></td>
                            </tr>
                            <tr>
                                <td>Tyre Rotation &amp; Alignment</td>
                                <td>Scheduled</td>
                                <td>10 Jul 2026</td>
                                <td style="text-align:right;">1,45,000 km</td>
                                <td style="text-align:right;">₹ 4,800</td>
                                <td><span class="pid-status pid-status-repair">Due</span></td>
                            </tr>
                            <tr>
                                <td>Clutch Assembly Inspection</td>
                                <td>Scheduled</td>
                                <td>02 May 2026</td>
                                <td style="text-align:right;">1,37,400 km</td>
                                <td style="text-align:right;">₹ 0</td>
                                <td><span class="pid-status pid-status-initiated">Missed</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="modal-footer pid-modal-footer">
                <button type="button" class="btn pid-modal-close-btn" data-bs-dismiss="modal">
                    <i class="uil uil-times"></i> Close
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('js/Inventory/purchase-insurance-dashboard.js?v=1.4') }}"></script>
@endsection
