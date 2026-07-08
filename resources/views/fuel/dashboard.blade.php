@extends('layouts.app')

@section('css')
<link href="{{ asset('css/Fuel/fuel-dashboard.css?v=1.0') }}" rel="stylesheet">
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
                    <li class="breadcrumb-item"><a href="{{ route('fleetdashboard.index') }}">Fleet</a></li>
                    <li class="breadcrumb-item active">Fuel Dashboard</li>
                </ol>
            </nav>

            {{-- Page Header --}}
            <div class="sc-page-head d-flex align-items-center justify-content-between mb-3">
                <div>
                    <h5 class="mb-0">Fuel Dashboard</h5>
                    <span class="text-muted" style="font-size:12px;">Diesel consumption &middot; Payment method &amp; company split &middot; Per-litre rate</span>
                </div>
                <div class="fud-period-badge">
                    <i class="uil uil-calendar-alt"></i> 01 Feb 2026 – 28 Feb 2026
                </div>
            </div>

            {{-- ══════════════════════════════════════════════════
                 SECTION 1 — Mini Dashboard
            ══════════════════════════════════════════════════ --}}
            <div class="fud-kpi-wrap">

                {{-- Group 1 — Overall --}}
                <div class="fud-kpi-group fud-span-1">
                    <div class="fud-kpi-group-title"><i class="uil uil-chart-pie"></i> Overall</div>
                    <div class="fud-kpi-row fud-cols-2">

                        <div class="fud-kpi-card card-total">
                            <div class="fud-kpi-label"><i class="uil uil-gas-pump"></i> Total Fuel</div>
                            <div class="fud-kpi-amt">₹ 58,42,900</div>
                            <div class="fud-kpi-divider"></div>
                            <div class="fud-kpi-qty"><span>63,780.00</span> L</div>
                        </div>

                        <div class="fud-kpi-card card-rate">
                            <div class="fud-kpi-label"><i class="uil uil-calculator-alt"></i> Avg Fuel Rate</div>
                            <div class="fud-kpi-amt">₹ 91.61 <small>/ L</small></div>
                            <div class="fud-kpi-divider"></div>
                            <div class="fud-kpi-qty">Amount ÷ Qty &middot; <span>342</span> Entries</div>
                        </div>

                    </div>
                </div>

                {{-- Group 2 — By Payment Method --}}
                <div class="fud-kpi-group fud-span-2">
                    <div class="fud-kpi-group-title"><i class="uil uil-wallet"></i> By Payment Method</div>
                    <div class="fud-kpi-row fud-cols-4">

                        <div class="fud-kpi-card card-otp">
                            <div class="fud-kpi-label"><i class="uil uil-key-skeleton"></i> OTP</div>
                            <div class="fud-kpi-amt">₹ 21,46,500</div>
                            <div class="fud-kpi-divider"></div>
                            <div class="fud-kpi-qty"><span>23,420.00</span> L</div>
                        </div>

                        <div class="fud-kpi-card card-marketpe">
                            <div class="fud-kpi-label"><i class="uil uil-store"></i> Market-pe</div>
                            <div class="fud-kpi-amt">₹ 14,82,300</div>
                            <div class="fud-kpi-divider"></div>
                            <div class="fud-kpi-qty"><span>16,180.00</span> L</div>
                        </div>

                        <div class="fud-kpi-card card-upi">
                            <div class="fud-kpi-label"><i class="uil uil-mobile-android"></i> UPI</div>
                            <div class="fud-kpi-amt">₹ 9,63,700</div>
                            <div class="fud-kpi-divider"></div>
                            <div class="fud-kpi-qty"><span>10,520.00</span> L</div>
                        </div>

                        <div class="fud-kpi-card card-credit">
                            <div class="fud-kpi-label"><i class="uil uil-invoice"></i> On Credit</div>
                            <div class="fud-kpi-amt">₹ 12,50,400</div>
                            <div class="fud-kpi-divider"></div>
                            <div class="fud-kpi-qty"><span>13,660.00</span> L</div>
                        </div>

                    </div>
                </div>

                {{-- Group 3 — By Fuel Company --}}
                <div class="fud-kpi-group fud-span-3">
                    <div class="fud-kpi-group-title"><i class="uil uil-building"></i> By Fuel Company</div>
                    <div class="fud-kpi-row fud-cols-6">

                        <div class="fud-kpi-card card-jio">
                            <div class="fud-kpi-label"><i class="uil uil-gas-pump"></i> Jio</div>
                            <div class="fud-kpi-amt">₹ 8,76,400</div>
                            <div class="fud-kpi-divider"></div>
                            <div class="fud-kpi-qty"><span>9,570.00</span> L</div>
                        </div>

                        <div class="fud-kpi-card card-nyara">
                            <div class="fud-kpi-label"><i class="uil uil-gas-pump"></i> Nyara</div>
                            <div class="fud-kpi-amt">₹ 6,53,100</div>
                            <div class="fud-kpi-divider"></div>
                            <div class="fud-kpi-qty"><span>7,130.00</span> L</div>
                        </div>

                        <div class="fud-kpi-card card-ioc">
                            <div class="fud-kpi-label"><i class="uil uil-gas-pump"></i> Indian Oil</div>
                            <div class="fud-kpi-amt">₹ 16,84,200</div>
                            <div class="fud-kpi-divider"></div>
                            <div class="fud-kpi-qty"><span>18,390.00</span> L</div>
                        </div>

                        <div class="fud-kpi-card card-bpcl">
                            <div class="fud-kpi-label"><i class="uil uil-gas-pump"></i> Bharat Petroleum</div>
                            <div class="fud-kpi-amt">₹ 11,92,600</div>
                            <div class="fud-kpi-divider"></div>
                            <div class="fud-kpi-qty"><span>13,010.00</span> L</div>
                        </div>

                        <div class="fud-kpi-card card-hp">
                            <div class="fud-kpi-label"><i class="uil uil-gas-pump"></i> HP</div>
                            <div class="fud-kpi-amt">₹ 9,48,700</div>
                            <div class="fud-kpi-divider"></div>
                            <div class="fud-kpi-qty"><span>10,360.00</span> L</div>
                        </div>

                        <div class="fud-kpi-card card-kalpataru">
                            <div class="fud-kpi-label"><i class="uil uil-gas-pump"></i> Kalpataru Fuel Station</div>
                            <div class="fud-kpi-amt">₹ 4,87,900</div>
                            <div class="fud-kpi-divider"></div>
                            <div class="fud-kpi-qty"><span>5,320.00</span> L</div>
                        </div>

                    </div>
                </div>

            </div>{{-- /fud-kpi-wrap --}}

            {{-- ══════════════════════════════════════════════════
                 SECTION 2 — Filter Card
            ══════════════════════════════════════════════════ --}}
            <div class="fud-filter-card">
                <div class="fud-filter-header">
                    <div class="fud-filter-title">
                        <i class="uil uil-filter"></i> Filters
                    </div>
                </div>
                <div class="fud-filter-body">
                <form id="fudFilterForm" method="GET" action="{{ route('fuel.dashboard') }}">

                    {{-- Search bar --}}
                    <div class="row g-2 align-items-end mb-2">

                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="fud-filter-group">
                                <label class="fud-filter-label"><i class="uil uil-search"></i> Search by Trip ID</label>
                                <div class="input-group" style="flex-wrap:nowrap;">
                                    <span class="input-group-text" style="padding:0 10px;">
                                        <i class="uil uil-search" style="font-size:13px;color:#4b6cb7;"></i>
                                    </span>
                                    <input type="text" id="fudTripId" name="trip_id" class="form-control"
                                        placeholder="e.g. TRP-20260204-018"
                                        value="{{ request('trip_id') }}">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="fud-filter-group">
                                <label class="fud-filter-label"><i class="uil uil-search"></i> Search by LR Number</label>
                                <div class="input-group" style="flex-wrap:nowrap;">
                                    <span class="input-group-text" style="padding:0 10px;">
                                        <i class="uil uil-search" style="font-size:13px;color:#4b6cb7;"></i>
                                    </span>
                                    <input type="text" id="fudLrNumber" name="lr_number" class="form-control"
                                        placeholder="e.g. LR-2026-00341"
                                        value="{{ request('lr_number') }}">
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="fud-filter-divider"></div>

                    {{-- Row 1 --}}
                    <div class="row g-2 align-items-end mb-2">

                        {{-- Fuel Date Range --}}
                        <div class="col-lg-3 col-md-4 col-6">
                            <div class="fud-filter-group">
                                <label class="fud-filter-label"><i class="uil uil-calendar-alt"></i> Fuel Date Range</label>
                                <div class="input-group" style="flex-wrap:nowrap;">
                                    <span class="input-group-text" style="padding:0 8px;">
                                        <i class="uil uil-calendar-alt" style="font-size:13px;color:#4b6cb7;"></i>
                                    </span>
                                    <input type="text" id="fudDateRange" name="date_range"
                                        class="form-control daterange"
                                        placeholder="DD-MM-YYYY – DD-MM-YYYY"
                                        value="{{ request('date_range', '01-02-2026 – 28-02-2026') }}"
                                        readonly style="cursor:pointer;">
                                </div>
                            </div>
                        </div>

                        {{-- Vehicle Number --}}
                        <div class="col-lg-3 col-md-4 col-6">
                            <div class="fud-filter-group">
                                <label class="fud-filter-label"><i class="uil uil-truck"></i> Vehicle Number</label>
                                <input type="text" id="fudVehicle" name="vehicle" class="form-control"
                                    placeholder="e.g. MH12AB1234"
                                    value="{{ request('vehicle') }}">
                            </div>
                        </div>

                        {{-- Driver Name & Code --}}
                        <div class="col-lg-3 col-md-4 col-6">
                            <div class="fud-filter-group">
                                <label class="fud-filter-label"><i class="uil uil-user"></i> Driver Name &amp; Code</label>
                                <input type="text" id="fudDriver" name="driver" class="form-control"
                                    placeholder="Name or code"
                                    value="{{ request('driver') }}">
                            </div>
                        </div>

                        {{-- Fuel Company --}}
                        <div class="col-lg-3 col-md-4 col-6">
                            <div class="fud-filter-group">
                                <label class="fud-filter-label"><i class="uil uil-building"></i> Fuel Company</label>
                                <select id="fudCompany" name="company" class="form-select">
                                    <option value="">All Companies</option>
                                    <option value="Jio">Jio</option>
                                    <option value="Nyara">Nyara</option>
                                    <option value="Indian Oil">Indian Oil</option>
                                    <option value="Bharat Petroleum">Bharat Petroleum</option>
                                    <option value="HP">HP</option>
                                    <option value="Kalpataru Fuel Station">Kalpataru Fuel Station</option>
                                </select>
                            </div>
                        </div>

                    </div>

                    {{-- Row 2 --}}
                    <div class="row g-2 align-items-end">

                        {{-- Location --}}
                        <div class="col-lg-3 col-md-4 col-6">
                            <div class="fud-filter-group">
                                <label class="fud-filter-label"><i class="uil uil-map-marker"></i> Location</label>
                                <select id="fudLocation" name="location" class="form-select">
                                    <option value="">All Locations</option>
                                    <option value="Pune">Pune</option>
                                    <option value="Vapi">Vapi</option>
                                    <option value="Jaipur">Jaipur</option>
                                    <option value="New Delhi">New Delhi</option>
                                    <option value="Kanpur">Kanpur</option>
                                    <option value="Indore">Indore</option>
                                    <option value="Bengaluru">Bengaluru</option>
                                    <option value="Talegaon">Talegaon</option>
                                </select>
                            </div>
                        </div>

                        {{-- Payment Method --}}
                        <div class="col-lg-3 col-md-4 col-6">
                            <div class="fud-filter-group">
                                <label class="fud-filter-label"><i class="uil uil-wallet"></i> Payment Method</label>
                                <select id="fudPayment" name="payment_method" class="form-select">
                                    <option value="">All Methods</option>
                                    <option value="OTP">OTP</option>
                                    <option value="Market-pe">Market-pe</option>
                                    <option value="UPI">UPI</option>
                                    <option value="On Credit">On Credit</option>
                                </select>
                            </div>
                        </div>

                        {{-- Reset --}}
                        <div class="col-lg-3 col-md-4 col-6 d-flex align-items-end">
                            <a href="{{ route('fuel.dashboard') }}" class="fud-reset-link">
                                <i class="uil uil-redo"></i> Reset Filters
                            </a>
                        </div>

                    </div>

                </form>
                </div>{{-- /fud-filter-body --}}
            </div>

            {{-- ══════════════════════════════════════════════════
                 SECTION 3 — Table Card
            ══════════════════════════════════════════════════ --}}
            <div class="fud-table-card">

                <div class="fud-table-head">
                    <div>
                        <div class="fud-table-head-title">
                            <i class="uil uil-list-ul"></i> All Fuel Entries
                        </div>
                        <div class="fud-table-head-sub">8 entries &middot; 01 Feb 2026 – 28 Feb 2026 &middot; per-litre rate auto-calculated</div>
                    </div>
                    <div class="fud-head-actions">
                        <button type="button" class="fud-btn-export" id="fudExport">
                            <i class="uil uil-import"></i> Export
                        </button>
                        <button type="button" class="fud-btn-add" id="fudAddEntry">
                            <i class="uil uil-plus"></i> Add Fuel Entry
                        </button>
                    </div>
                </div>

                <div class="fud-table">
                    <table class="table mb-0" id="fudTable">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Vehicle Number</th>
                                <th>Tracking Group</th>
                                <th>Driver Name &amp; Code</th>
                                <th>Trip ID</th>
                                <th>LR Number &amp; Date</th>
                                <th>Route</th>
                                <th class="fud-sortable" data-sort-key="date" data-sort-type="str">
                                    Fuel Date <i class="uil uil-sort fud-sort-icon"></i>
                                </th>
                                <th class="fud-sortable fud-th-num" data-sort-key="qty" data-sort-type="num">
                                    Fuel Qty (L) <i class="uil uil-sort fud-sort-icon"></i>
                                </th>
                                <th class="fud-sortable fud-th-num" data-sort-key="amount" data-sort-type="num">
                                    Fuel Amount <i class="uil uil-sort fud-sort-icon"></i>
                                </th>
                                <th class="fud-sortable fud-th-num fud-th-group" data-sort-key="rate" data-sort-type="num">
                                    Fuel Per L Rate <i class="uil uil-sort fud-sort-icon"></i>
                                </th>
                                <th>Fuel Company</th>
                                <th>Location</th>
                                <th style="text-align:center;">Payment Method</th>
                                <th class="fud-th-num">Odo-Meter Reading</th>
                            </tr>
                        </thead>
                        <tbody id="fudTableBody">

                            {{-- Row 1 --}}
                            <tr data-date="2026-02-04" data-qty="220" data-amount="19800" data-rate="90.00">
                                <td class="fud-sl">1</td>
                                <td><span class="fud-reg">MH12AB1234</span></td>
                                <td>North Zone</td>
                                <td>
                                    <div class="fud-driver-name">Ramesh Kumar</div>
                                    <div class="fud-driver-code">D001</div>
                                </td>
                                <td class="fud-mono">TRP-20260204-018</td>
                                <td>
                                    <div class="fud-mono">LR-2026-00341</div>
                                    <div class="fud-sub">03 Feb 2026</div>
                                </td>
                                <td><span class="fud-route">Pune → Nagpur</span></td>
                                <td>04 Feb 2026</td>
                                <td class="fud-num">220.00</td>
                                <td class="fud-num fud-amt">₹ 19,800</td>
                                <td class="fud-num fud-rate">₹ 90.00</td>
                                <td><span class="fud-company">Indian Oil</span></td>
                                <td>Pune</td>
                                <td style="text-align:center;"><span class="fud-badge fud-badge-otp">OTP</span></td>
                                <td class="fud-num fud-odo">1,24,580</td>
                            </tr>

                            {{-- Row 2 — fuel taken while vehicle not on a trip --}}
                            <tr data-date="2026-02-07" data-qty="180.5" data-amount="16606" data-rate="92.00">
                                <td class="fud-sl">2</td>
                                <td><span class="fud-reg">GJ01CD5678</span></td>
                                <td>West Zone</td>
                                <td>
                                    <div class="fud-driver-name">Suresh Singh</div>
                                    <div class="fud-driver-code">D002</div>
                                </td>
                                <td class="fud-muted">—</td>
                                <td class="fud-muted">—</td>
                                <td><span class="fud-badge fud-badge-upcoming">Upcoming Trip</span></td>
                                <td>07 Feb 2026</td>
                                <td class="fud-num">180.50</td>
                                <td class="fud-num fud-amt">₹ 16,606</td>
                                <td class="fud-num fud-rate">₹ 92.00</td>
                                <td><span class="fud-company">Nyara</span></td>
                                <td>Vapi</td>
                                <td style="text-align:center;"><span class="fud-badge fud-badge-marketpe">Market-pe</span></td>
                                <td class="fud-num fud-odo">98,340</td>
                            </tr>

                            {{-- Row 3 --}}
                            <tr data-date="2026-02-09" data-qty="150" data-amount="13350" data-rate="89.00">
                                <td class="fud-sl">3</td>
                                <td><span class="fud-reg">RJ14EF9012</span></td>
                                <td>North Zone</td>
                                <td>
                                    <div class="fud-driver-name">Mahesh Yadav</div>
                                    <div class="fud-driver-code">D003</div>
                                </td>
                                <td class="fud-mono">TRP-20260209-024</td>
                                <td>
                                    <div class="fud-mono">LR-2026-00358</div>
                                    <div class="fud-sub">08 Feb 2026</div>
                                </td>
                                <td><span class="fud-route">Jaipur → Ajmer</span></td>
                                <td>09 Feb 2026</td>
                                <td class="fud-num">150.00</td>
                                <td class="fud-num fud-amt">₹ 13,350</td>
                                <td class="fud-num fud-rate">₹ 89.00</td>
                                <td><span class="fud-company">Jio</span></td>
                                <td>Jaipur</td>
                                <td style="text-align:center;"><span class="fud-badge fud-badge-upi">UPI</span></td>
                                <td class="fud-num fud-odo">87,210</td>
                            </tr>

                            {{-- Row 4 --}}
                            <tr data-date="2026-02-13" data-qty="260" data-amount="24700" data-rate="95.00">
                                <td class="fud-sl">4</td>
                                <td><span class="fud-reg">DL3CBA3456</span></td>
                                <td>South Zone</td>
                                <td>
                                    <div class="fud-driver-name">Dinesh Patel</div>
                                    <div class="fud-driver-code">D004</div>
                                </td>
                                <td class="fud-mono">TRP-20260213-041</td>
                                <td>
                                    <div class="fud-mono">LR-2026-00367</div>
                                    <div class="fud-sub">12 Feb 2026</div>
                                </td>
                                <td><span class="fud-route">Delhi → Agra</span></td>
                                <td>13 Feb 2026</td>
                                <td class="fud-num">260.00</td>
                                <td class="fud-num fud-amt">₹ 24,700</td>
                                <td class="fud-num fud-rate">₹ 95.00</td>
                                <td><span class="fud-company">Bharat Petroleum</span></td>
                                <td>New Delhi</td>
                                <td style="text-align:center;"><span class="fud-badge fud-badge-credit">On Credit</span></td>
                                <td class="fud-num fud-odo">1,45,900</td>
                            </tr>

                            {{-- Row 5 --}}
                            <tr data-date="2026-02-16" data-qty="195" data-amount="17745" data-rate="91.00">
                                <td class="fud-sl">5</td>
                                <td><span class="fud-reg">UP32GH7890</span></td>
                                <td>East Zone</td>
                                <td>
                                    <div class="fud-driver-name">Vijay Sharma</div>
                                    <div class="fud-driver-code">D005</div>
                                </td>
                                <td class="fud-mono">TRP-20260215-056</td>
                                <td>
                                    <div class="fud-mono">LR-2026-00374</div>
                                    <div class="fud-sub">15 Feb 2026</div>
                                </td>
                                <td><span class="fud-route">Kanpur → Lucknow</span></td>
                                <td>16 Feb 2026</td>
                                <td class="fud-num">195.00</td>
                                <td class="fud-num fud-amt">₹ 17,745</td>
                                <td class="fud-num fud-rate">₹ 91.00</td>
                                <td><span class="fud-company">HP</span></td>
                                <td>Kanpur</td>
                                <td style="text-align:center;"><span class="fud-badge fud-badge-otp">OTP</span></td>
                                <td class="fud-num fud-odo">76,480</td>
                            </tr>

                            {{-- Row 6 — fuel taken while vehicle not on a trip --}}
                            <tr data-date="2026-02-19" data-qty="140" data-amount="12880" data-rate="92.00">
                                <td class="fud-sl">6</td>
                                <td><span class="fud-reg">MP09IJ2345</span></td>
                                <td>West Zone</td>
                                <td>
                                    <div class="fud-driver-name">Arjun Tiwari</div>
                                    <div class="fud-driver-code">D006</div>
                                </td>
                                <td class="fud-muted">—</td>
                                <td class="fud-muted">—</td>
                                <td><span class="fud-badge fud-badge-upcoming">Upcoming Trip</span></td>
                                <td>19 Feb 2026</td>
                                <td class="fud-num">140.00</td>
                                <td class="fud-num fud-amt">₹ 12,880</td>
                                <td class="fud-num fud-rate">₹ 92.00</td>
                                <td><span class="fud-company">Kalpataru Fuel Station</span></td>
                                <td>Indore</td>
                                <td style="text-align:center;"><span class="fud-badge fud-badge-upi">UPI</span></td>
                                <td class="fud-num fud-odo">1,02,760</td>
                            </tr>

                            {{-- Row 7 --}}
                            <tr data-date="2026-02-22" data-qty="210" data-amount="19320" data-rate="92.00">
                                <td class="fud-sl">7</td>
                                <td><span class="fud-reg">KA05KL6789</span></td>
                                <td>South Zone</td>
                                <td>
                                    <div class="fud-driver-name">Prakash Nair</div>
                                    <div class="fud-driver-code">D007</div>
                                </td>
                                <td class="fud-mono">TRP-20260222-063</td>
                                <td>
                                    <div class="fud-mono">LR-2026-00389</div>
                                    <div class="fud-sub">21 Feb 2026</div>
                                </td>
                                <td><span class="fud-route">Bengaluru → Hosur</span></td>
                                <td>22 Feb 2026</td>
                                <td class="fud-num">210.00</td>
                                <td class="fud-num fud-amt">₹ 19,320</td>
                                <td class="fud-num fud-rate">₹ 92.00</td>
                                <td><span class="fud-company">Indian Oil</span></td>
                                <td>Bengaluru</td>
                                <td style="text-align:center;"><span class="fud-badge fud-badge-marketpe">Market-pe</span></td>
                                <td class="fud-num fud-odo">1,11,050</td>
                            </tr>

                            {{-- Row 8 --}}
                            <tr data-date="2026-02-26" data-qty="175" data-amount="15925" data-rate="91.00">
                                <td class="fud-sl">8</td>
                                <td><span class="fud-reg">MH12AB1234</span></td>
                                <td>North Zone</td>
                                <td>
                                    <div class="fud-driver-name">Ramesh Kumar</div>
                                    <div class="fud-driver-code">D001</div>
                                </td>
                                <td class="fud-mono">TRP-20260226-071</td>
                                <td>
                                    <div class="fud-mono">LR-2026-00396</div>
                                    <div class="fud-sub">25 Feb 2026</div>
                                </td>
                                <td><span class="fud-route">Nagpur → Pune</span></td>
                                <td>26 Feb 2026</td>
                                <td class="fud-num">175.00</td>
                                <td class="fud-num fud-amt">₹ 15,925</td>
                                <td class="fud-num fud-rate">₹ 91.00</td>
                                <td><span class="fud-company">Jio</span></td>
                                <td>Talegaon</td>
                                <td style="text-align:center;"><span class="fud-badge fud-badge-credit">On Credit</span></td>
                                <td class="fud-num fud-odo">1,26,340</td>
                            </tr>

                        </tbody>
                    </table>
                </div>

                <div class="fud-table-foot">
                    <span>Showing <b>8</b> of <b>342</b> fuel entries</span>
                    <span>Total on this page: <b>₹ 1,40,326</b> &middot; <b>1,530.50 L</b> &middot; Avg <b>₹ 91.69 / L</b></span>
                </div>

            </div>
            {{-- /table card --}}

        </div>{{-- /sc-no-sidebar --}}
    </div>{{-- /wrapper --}}
</div>{{-- /layout-wrapper --}}
@endsection

@section('js')
<script src="{{ asset('js/Fuel/fuel-dashboard.js?v=1.0') }}"></script>
@endsection
