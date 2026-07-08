@extends('layouts.app')

@section('css')
<link href="{{ asset('css/Challan/challan-dashboard.css?v=1.2') }}" rel="stylesheet">
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
                    <li class="breadcrumb-item active">Challan Dashboard</li>
                </ol>
            </nav>

            {{-- Page Header --}}
            <div class="sc-page-head d-flex align-items-center justify-content-between mb-3">
                <div>
                    <h5 class="mb-0">Challan Dashboard</h5>
                    <span class="text-muted" style="font-size:12px;">Traffic challans · Court &amp; online tracking · Borne-by settlement</span>
                </div>
                <div class="chd-sort-badge">
                    <i class="uil uil-calendar-alt"></i> 01 Feb 2026 – 28 Feb 2026
                </div>
            </div>

            {{-- ══════════════════════════════════════════════════
                 SECTION 1 — Mini Dashboard (12 KPIs, 4 groups)
            ══════════════════════════════════════════════════ --}}
            <div class="chd-kpi-wrap">

                {{-- Group 1 — Overall Challan --}}
                <div class="chd-kpi-group">
                    <div class="chd-kpi-group-title"><i class="uil uil-file-alt"></i> Overall Challan</div>
                    <div class="chd-kpi-row">

                        <div class="chd-kpi-card card-total">
                            <div class="chd-kpi-label"><i class="uil uil-money-bill"></i> Total Challan</div>
                            <div class="chd-kpi-amt">₹ 4,86,500</div>
                            <div class="chd-kpi-divider"></div>
                            <div class="chd-kpi-qty"><span>248</span> Challans</div>
                        </div>

                        <div class="chd-kpi-card card-paid">
                            <div class="chd-kpi-label"><i class="uil uil-check-circle"></i> Paid Challan</div>
                            <div class="chd-kpi-amt">₹ 3,12,400</div>
                            <div class="chd-kpi-divider"></div>
                            <div class="chd-kpi-qty"><span>171</span> Challans</div>
                        </div>

                        <div class="chd-kpi-card card-unpaid">
                            <div class="chd-kpi-label"><i class="uil uil-exclamation-circle"></i> Unpaid Challan</div>
                            <div class="chd-kpi-amt">₹ 1,74,100</div>
                            <div class="chd-kpi-divider"></div>
                            <div class="chd-kpi-qty"><span>77</span> Challans</div>
                        </div>

                    </div>
                </div>

                {{-- Group 2 — Court Challan --}}
                <div class="chd-kpi-group">
                    <div class="chd-kpi-group-title"><i class="uil uil-balance-scale"></i> Court Challan</div>
                    <div class="chd-kpi-row">

                        <div class="chd-kpi-card card-total">
                            <div class="chd-kpi-label"><i class="uil uil-money-bill"></i> Total Court</div>
                            <div class="chd-kpi-amt">₹ 1,52,800</div>
                            <div class="chd-kpi-divider"></div>
                            <div class="chd-kpi-qty"><span>64</span> Challans</div>
                        </div>

                        <div class="chd-kpi-card card-paid">
                            <div class="chd-kpi-label"><i class="uil uil-check-circle"></i> Paid Court</div>
                            <div class="chd-kpi-amt">₹ 78,300</div>
                            <div class="chd-kpi-divider"></div>
                            <div class="chd-kpi-qty"><span>33</span> Challans</div>
                        </div>

                        <div class="chd-kpi-card card-unpaid">
                            <div class="chd-kpi-label"><i class="uil uil-exclamation-circle"></i> Unpaid Court</div>
                            <div class="chd-kpi-amt">₹ 74,500</div>
                            <div class="chd-kpi-divider"></div>
                            <div class="chd-kpi-qty"><span>31</span> Challans</div>
                        </div>

                    </div>
                </div>

                {{-- Group 3 — Online Challan --}}
                <div class="chd-kpi-group">
                    <div class="chd-kpi-group-title"><i class="uil uil-globe"></i> Online Challan</div>
                    <div class="chd-kpi-row">

                        <div class="chd-kpi-card card-total">
                            <div class="chd-kpi-label"><i class="uil uil-money-bill"></i> Total Online</div>
                            <div class="chd-kpi-amt">₹ 3,33,700</div>
                            <div class="chd-kpi-divider"></div>
                            <div class="chd-kpi-qty"><span>184</span> Challans</div>
                        </div>

                        <div class="chd-kpi-card card-paid">
                            <div class="chd-kpi-label"><i class="uil uil-check-circle"></i> Paid Online</div>
                            <div class="chd-kpi-amt">₹ 2,34,100</div>
                            <div class="chd-kpi-divider"></div>
                            <div class="chd-kpi-qty"><span>138</span> Challans</div>
                        </div>

                        <div class="chd-kpi-card card-unpaid">
                            <div class="chd-kpi-label"><i class="uil uil-exclamation-circle"></i> Unpaid Online</div>
                            <div class="chd-kpi-amt">₹ 99,600</div>
                            <div class="chd-kpi-divider"></div>
                            <div class="chd-kpi-qty"><span>46</span> Challans</div>
                        </div>

                    </div>
                </div>

                {{-- Group 4 — Borne By --}}
                <div class="chd-kpi-group">
                    <div class="chd-kpi-group-title"><i class="uil uil-users-alt"></i> Borne By</div>
                    <div class="chd-kpi-row">

                        <div class="chd-kpi-card card-sr">
                            <div class="chd-kpi-label"><i class="uil uil-building"></i> Borne by SR</div>
                            <div class="chd-kpi-amt">₹ 2,41,900</div>
                            <div class="chd-kpi-divider"></div>
                            <div class="chd-kpi-qty"><span>119</span> Challans</div>
                        </div>

                        <div class="chd-kpi-card card-driver">
                            <div class="chd-kpi-label"><i class="uil uil-user"></i> Borne by Driver</div>
                            <div class="chd-kpi-amt">₹ 1,58,300</div>
                            <div class="chd-kpi-divider"></div>
                            <div class="chd-kpi-qty"><span>82</span> Challans</div>
                        </div>

                        <div class="chd-kpi-card card-both">
                            <div class="chd-kpi-label"><i class="uil uil-share-alt"></i> Borne by Both</div>
                            <div class="chd-kpi-amt">₹ 86,300</div>
                            <div class="chd-kpi-divider"></div>
                            <div class="chd-kpi-qty"><span>47</span> Challans</div>
                        </div>

                    </div>
                </div>

            </div>{{-- /chd-kpi-wrap --}}

            {{-- ══════════════════════════════════════════════════
                 SECTION 2 — Filter Card
            ══════════════════════════════════════════════════ --}}
            <div class="chd-filter-card">
                <div class="chd-filter-header">
                    <div class="chd-filter-title">
                        <i class="uil uil-filter"></i> Filters
                    </div>
                </div>
                <div class="chd-filter-body">
                <form id="chdFilterForm" method="GET" action="{{ route('challan.dashboard') }}">

                    {{-- Search bar --}}
                    <div class="row g-2 align-items-end mb-2">
                        <div class="col-lg-12 col-12">
                            <div class="chd-filter-group">
                                <label class="chd-filter-label"><i class="uil uil-search"></i> Search by Challan Number</label>
                                <div class="input-group" style="flex-wrap:nowrap;">
                                    <span class="input-group-text" style="padding:0 10px;">
                                        <i class="uil uil-search" style="font-size:13px;color:#4b6cb7;"></i>
                                    </span>
                                    <input type="text" id="chdSearch" name="search" class="form-control"
                                        placeholder="Enter Challan Number"
                                        value="{{ request('search') }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="chd-filter-divider"></div>

                    {{-- Row 1 --}}
                    <div class="row g-2 align-items-end mb-2">

                        {{-- Vehicle Number --}}
                        <div class="col-lg-3 col-md-4 col-6">
                            <div class="chd-filter-group">
                                <label class="chd-filter-label"><i class="uil uil-truck"></i> Vehicle Number</label>
                                <input type="text" id="chdVehicle" name="vehicle" class="form-control"
                                    placeholder="e.g. MH12AB1234"
                                    value="{{ request('vehicle') }}">
                            </div>
                        </div>

                        {{-- Driver Name --}}
                        <div class="col-lg-3 col-md-4 col-6">
                            <div class="chd-filter-group">
                                <label class="chd-filter-label"><i class="uil uil-user"></i> Driver Name</label>
                                <input type="text" id="chdDriver" name="driver" class="form-control"
                                    placeholder="Name or code"
                                    value="{{ request('driver') }}">
                            </div>
                        </div>

                        {{-- Tracking Group --}}
                        <div class="col-lg-3 col-md-4 col-6">
                            <div class="chd-filter-group">
                                <label class="chd-filter-label"><i class="uil uil-layer-group"></i> Tracking Group</label>
                                <select id="chdTrackingGroup" name="tracking_group" class="form-select">
                                    <option value="">All Groups</option>
                                    <option value="north">North Zone</option>
                                    <option value="south">South Zone</option>
                                    <option value="east">East Zone</option>
                                    <option value="west">West Zone</option>
                                </select>
                            </div>
                        </div>

                        {{-- Date Range --}}
                        <div class="col-lg-3 col-md-4 col-6">
                            <div class="chd-filter-group">
                                <label class="chd-filter-label"><i class="uil uil-calendar-alt"></i> Date Range</label>
                                <div class="input-group" style="flex-wrap:nowrap;">
                                    <span class="input-group-text" style="padding:0 8px;">
                                        <i class="uil uil-calendar-alt" style="font-size:13px;color:#4b6cb7;"></i>
                                    </span>
                                    <input type="text" id="chdDateRange" name="date_range"
                                        class="form-control daterange"
                                        placeholder="DD-MM-YYYY – DD-MM-YYYY"
                                        value="{{ request('date_range', '01-02-2026 – 28-02-2026') }}"
                                        readonly style="cursor:pointer;">
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- Row 2 --}}
                    <div class="row g-2 align-items-end mb-2">

                        {{-- Challan RAG Status --}}
                        <div class="col-lg-3 col-md-4 col-6">
                            <div class="chd-filter-group">
                                <label class="chd-filter-label"><i class="uil uil-traffic-light"></i> Challan RAG Status</label>
                                <select id="chdRag" name="rag_status" class="form-select">
                                    <option value="">All RAG</option>
                                    <option value="Red">Red</option>
                                    <option value="Amber">Amber</option>
                                    <option value="Green">Green</option>
                                </select>
                            </div>
                        </div>

                        {{-- State --}}
                        <div class="col-lg-3 col-md-4 col-6">
                            <div class="chd-filter-group">
                                <label class="chd-filter-label"><i class="uil uil-map-marker"></i> State</label>
                                <select id="chdState" name="state" class="form-select">
                                    <option value="">All States</option>
                                    <option value="Maharashtra">Maharashtra</option>
                                    <option value="Gujarat">Gujarat</option>
                                    <option value="Rajasthan">Rajasthan</option>
                                    <option value="Delhi">Delhi</option>
                                    <option value="Uttar Pradesh">Uttar Pradesh</option>
                                    <option value="Madhya Pradesh">Madhya Pradesh</option>
                                </select>
                            </div>
                        </div>

                        {{-- Challan Status --}}
                        <div class="col-lg-3 col-md-4 col-6">
                            <div class="chd-filter-group">
                                <label class="chd-filter-label"><i class="uil uil-check-square"></i> Challan Status</label>
                                <select id="chdStatus" name="status" class="form-select">
                                    <option value="">All Status</option>
                                    <option value="Paid">Paid</option>
                                    <option value="Unpaid">Unpaid</option>
                                </select>
                            </div>
                        </div>

                        {{-- Challan Type --}}
                        <div class="col-lg-3 col-md-4 col-6">
                            <div class="chd-filter-group">
                                <label class="chd-filter-label"><i class="uil uil-bill"></i> Challan Type</label>
                                <select id="chdType" name="type" class="form-select">
                                    <option value="">Online &amp; Court</option>
                                    <option value="Online">Online</option>
                                    <option value="Court">Court</option>
                                </select>
                            </div>
                        </div>

                    </div>

                    {{-- Row 3 --}}
                    <div class="row g-2 align-items-end">

                        {{-- Borne By --}}
                        <div class="col-lg-3 col-md-4 col-6">
                            <div class="chd-filter-group">
                                <label class="chd-filter-label"><i class="uil uil-users-alt"></i> Borne By</label>
                                <select id="chdBorneBy" name="borne_by" class="form-select">
                                    <option value="">All</option>
                                    <option value="SR">SR</option>
                                    <option value="Driver">Driver</option>
                                    <option value="Both">Both</option>
                                    <option value="Not Assigned">Not Assigned</option>
                                </select>
                            </div>
                        </div>

                        {{-- Reset --}}
                        <div class="col-lg-3 col-md-4 col-6 d-flex align-items-end">
                            <a href="{{ route('challan.dashboard') }}" class="chd-reset-link">
                                <i class="uil uil-redo"></i> Reset Filters
                            </a>
                        </div>

                    </div>

                </form>
                </div>{{-- /chd-filter-body --}}
            </div>

            {{-- ══════════════════════════════════════════════════
                 SECTION 3 — Table Card
            ══════════════════════════════════════════════════ --}}
            <div class="chd-table-card">

                <div class="chd-table-head">
                    <div>
                        <div class="chd-table-head-title">
                            <i class="uil uil-list-ul"></i> All Challans
                        </div>
                        <div class="chd-table-head-sub">8 challans · 01 Feb 2026 – 28 Feb 2026 · auto-fetched from Parivahan / VAHAN</div>
                    </div>
                    <div class="chd-head-actions">
                        <button type="button" class="chd-btn-fetch" id="chdAutoFetch">
                            <i class="uil uil-sync"></i> Auto Fetch Challans
                        </button>
                        <button type="button" class="chd-btn-add" id="chdAddChallan">
                            <i class="uil uil-plus"></i> Add Challan
                        </button>
                    </div>
                </div>

                <div class="chd-table">
                    <table class="table mb-0" id="chdTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Vehicle Number</th>
                                <th>Owner Name</th>
                                <th>Tracking Group</th>
                                <th>Driver Name &amp; Code</th>
                                <th>Driver License</th>
                                <th class="chd-sortable" data-sort-key="amount" data-sort-type="num" style="text-align:right;">
                                    Challan Amount <i class="uil uil-sort chd-sort-icon"></i>
                                </th>
                                <th>Challan Reason</th>
                                <th>Borne By</th>
                                <th>Department</th>
                                <th class="chd-sortable" data-sort-key="date" data-sort-type="str">
                                    Challan Date <i class="uil uil-sort chd-sort-icon"></i>
                                </th>
                                <th>Challan Place</th>
                                <th>Challan State</th>
                                <th>State Code</th>
                                <th>RTO District</th>
                                <th>Trip Number</th>
                                <th>Challan Number</th>
                                <th style="text-align:center;">Challan Status</th>
                                <th style="text-align:center;">RAG</th>
                                <th style="text-align:center;">Online / Court</th>
                                <th>Offence Details</th>
                                <th class="chd-th-group">Sent to Reg. Court</th>
                                <th class="chd-th-group">Sent to Court On</th>
                                <th class="chd-th-group">Court Name</th>
                                <th class="chd-th-group">Court Address</th>
                                <th class="chd-th-group">Date of Proceeding</th>
                                <th class="chd-th-group">Sent to Virtual Court</th>
                                <th style="text-align:center;">Details</th>
                            </tr>
                        </thead>
                        <tbody id="chdTableBody">

                            {{-- Row 1 --}}
                            <tr data-amount="2000" data-date="2026-02-04">
                                <td class="chd-sl">1</td>
                                <td><span class="chd-reg">MH12AB1234</span></td>
                                <td>SR Logistics Pvt. Ltd.</td>
                                <td>North Zone</td>
                                <td>
                                    <div class="chd-driver-name">Ramesh Kumar</div>
                                    <div class="chd-driver-code">D001</div>
                                </td>
                                <td class="chd-mono">MH1420110012345</td>
                                <td class="chd-amt">₹ 2,000</td>
                                <td><span class="chd-truncate" title="Over-speeding beyond permissible limit">Over-speeding</span></td>
                                <td>
                                    <div class="chd-borne">
                                        <div class="chd-borne-line"><span class="chd-dot chd-dot-sr"></span> SR <b>₹ 2,000</b></div>
                                    </div>
                                </td>
                                <td>Traffic Police</td>
                                <td>04 Feb 2026</td>
                                <td>Khed Shivapur</td>
                                <td>Maharashtra</td>
                                <td class="chd-mono">MH</td>
                                <td>Pune</td>
                                <td class="chd-mono">TRP-20260204-018</td>
                                <td class="chd-mono">MH1220260204001</td>
                                <td style="text-align:center;"><span class="chd-badge chd-badge-paid">Paid</span></td>
                                <td style="text-align:center;"><span class="chd-rag chd-rag-green"><span class="chd-dot" style="background:#157347;"></span> Green</span></td>
                                <td style="text-align:center;"><span class="chd-badge chd-badge-online">Online</span></td>
                                <td><span class="chd-truncate" title="Sec 183 MVA — driving at 82 km/h in a 60 km/h zone, captured by ITMS camera.">Sec 183 MVA — 82 km/h in 60 zone</span></td>
                                <td class="chd-muted">No</td>
                                <td class="chd-muted">—</td>
                                <td class="chd-muted">—</td>
                                <td class="chd-muted">—</td>
                                <td class="chd-muted">—</td>
                                <td class="chd-muted">—</td>
                                <td style="text-align:center;">
                                    <button type="button" class="chd-view-btn" data-bs-toggle="modal" data-bs-target="#chdDetailModal"
                                        data-challan="MH1220260204001" data-vehicle="MH12AB1234" data-driver="Ramesh Kumar (D001)"
                                        data-amount="₹ 2,000" data-status="Paid" data-type="Online"
                                        data-offence="Sec 183 MVA — driving at 82 km/h in a 60 km/h zone, captured by ITMS camera at Khed Shivapur toll approach."
                                        data-court="No" data-courton="—" data-courtname="—" data-courtaddress="—"
                                        data-proceeding="—" data-virtual="—">
                                        <i class="uil uil-eye"></i> View
                                    </button>
                                </td>
                            </tr>

                            {{-- Row 2 --}}
                            <tr data-amount="5000" data-date="2026-02-07">
                                <td class="chd-sl">2</td>
                                <td><span class="chd-reg">GJ01CD5678</span></td>
                                <td>SR Logistics Pvt. Ltd.</td>
                                <td>West Zone</td>
                                <td>
                                    <div class="chd-driver-name">Suresh Singh</div>
                                    <div class="chd-driver-code">D002</div>
                                </td>
                                <td class="chd-mono">GJ0120150098765</td>
                                <td class="chd-amt">₹ 5,000</td>
                                <td><span class="chd-truncate" title="Overloading beyond permissible gross vehicle weight">Overloading</span></td>
                                <td>
                                    <div class="chd-borne">
                                        <div class="chd-borne-line"><span class="chd-dot chd-dot-sr"></span> SR <b>₹ 3,000</b></div>
                                        <div class="chd-borne-line"><span class="chd-dot chd-dot-driver"></span> Driver <b>₹ 2,000</b></div>
                                    </div>
                                </td>
                                <td>RTO Enforcement</td>
                                <td>07 Feb 2026</td>
                                <td>Vapi Check Post</td>
                                <td>Gujarat</td>
                                <td class="chd-mono">GJ</td>
                                <td>Valsad</td>
                                <td class="chd-mono">TRP-20260206-032</td>
                                <td class="chd-mono">GJ0120260207014</td>
                                <td style="text-align:center;"><span class="chd-badge chd-badge-unpaid">Unpaid</span></td>
                                <td style="text-align:center;"><span class="chd-rag chd-rag-red"><span class="chd-dot" style="background:#ea0027;"></span> Red</span></td>
                                <td style="text-align:center;"><span class="chd-badge chd-badge-court">Court</span></td>
                                <td><span class="chd-truncate" title="Sec 194(1) MVA — gross vehicle weight exceeded by 4.2 tonnes at Vapi check post weighbridge.">Sec 194(1) MVA — GVW exceeded 4.2 T</span></td>
                                <td><span class="chd-badge chd-badge-yes">Yes</span></td>
                                <td>12 Feb 2026</td>
                                <td>JMFC Court, Valsad</td>
                                <td><span class="chd-truncate" title="District Court Complex, Station Road, Valsad, Gujarat 396001">District Court Complex, Station Road, Valsad</span></td>
                                <td>18 Mar 2026</td>
                                <td><span class="chd-badge chd-badge-no">No</span></td>
                                <td style="text-align:center;">
                                    <button type="button" class="chd-view-btn" data-bs-toggle="modal" data-bs-target="#chdDetailModal"
                                        data-challan="GJ0120260207014" data-vehicle="GJ01CD5678" data-driver="Suresh Singh (D002)"
                                        data-amount="₹ 5,000" data-status="Unpaid" data-type="Court"
                                        data-offence="Sec 194(1) MVA — gross vehicle weight exceeded by 4.2 tonnes at Vapi check post weighbridge. Vehicle detained for 3 hours; load partially transferred."
                                        data-court="Yes" data-courton="12 Feb 2026" data-courtname="JMFC Court, Valsad"
                                        data-courtaddress="District Court Complex, Station Road, Valsad, Gujarat 396001"
                                        data-proceeding="18 Mar 2026" data-virtual="No">
                                        <i class="uil uil-eye"></i> View
                                    </button>
                                </td>
                            </tr>

                            {{-- Row 3 --}}
                            <tr data-amount="1000" data-date="2026-02-09">
                                <td class="chd-sl">3</td>
                                <td><span class="chd-reg">RJ14EF9012</span></td>
                                <td>SR Carriers LLP</td>
                                <td>North Zone</td>
                                <td>
                                    <div class="chd-driver-name">Mahesh Yadav</div>
                                    <div class="chd-driver-code">D003</div>
                                </td>
                                <td class="chd-mono">RJ1420130045678</td>
                                <td class="chd-amt">₹ 1,000</td>
                                <td><span class="chd-truncate" title="Driving without valid seat belt">No Seat Belt</span></td>
                                <td>
                                    <div class="chd-borne">
                                        <div class="chd-borne-line"><span class="chd-dot chd-dot-driver"></span> Driver <b>₹ 1,000</b></div>
                                    </div>
                                </td>
                                <td>Traffic Police</td>
                                <td>09 Feb 2026</td>
                                <td>Ajmer Road</td>
                                <td>Rajasthan</td>
                                <td class="chd-mono">RJ</td>
                                <td>Jaipur</td>
                                <td class="chd-muted">—</td>
                                <td class="chd-mono">RJ1420260209007</td>
                                <td style="text-align:center;"><span class="chd-badge chd-badge-paid">Paid</span></td>
                                <td style="text-align:center;"><span class="chd-rag chd-rag-green"><span class="chd-dot" style="background:#157347;"></span> Green</span></td>
                                <td style="text-align:center;"><span class="chd-badge chd-badge-online">Online</span></td>
                                <td><span class="chd-truncate" title="Sec 194B MVA — driver not wearing seat belt during moving vehicle inspection.">Sec 194B MVA — seat belt not worn</span></td>
                                <td class="chd-muted">No</td>
                                <td class="chd-muted">—</td>
                                <td class="chd-muted">—</td>
                                <td class="chd-muted">—</td>
                                <td class="chd-muted">—</td>
                                <td class="chd-muted">—</td>
                                <td style="text-align:center;">
                                    <button type="button" class="chd-view-btn" data-bs-toggle="modal" data-bs-target="#chdDetailModal"
                                        data-challan="RJ1420260209007" data-vehicle="RJ14EF9012" data-driver="Mahesh Yadav (D003)"
                                        data-amount="₹ 1,000" data-status="Paid" data-type="Online"
                                        data-offence="Sec 194B MVA — driver not wearing seat belt during moving vehicle inspection on Ajmer Road."
                                        data-court="No" data-courton="—" data-courtname="—" data-courtaddress="—"
                                        data-proceeding="—" data-virtual="—">
                                        <i class="uil uil-eye"></i> View
                                    </button>
                                </td>
                            </tr>

                            {{-- Row 4 --}}
                            <tr data-amount="10000" data-date="2026-02-13">
                                <td class="chd-sl">4</td>
                                <td><span class="chd-reg">DL3CBA3456</span></td>
                                <td>SR Logistics Pvt. Ltd.</td>
                                <td>South Zone</td>
                                <td>
                                    <div class="chd-driver-name">Dinesh Patel</div>
                                    <div class="chd-driver-code">D004</div>
                                </td>
                                <td class="chd-mono">DL0320160034512</td>
                                <td class="chd-amt">₹ 10,000</td>
                                <td><span class="chd-truncate" title="Driving under the influence of alcohol">Drunk Driving</span></td>
                                <td>
                                    <div class="chd-borne">
                                        <div class="chd-borne-line"><span class="chd-dot chd-dot-driver"></span> Driver <b>₹ 10,000</b></div>
                                    </div>
                                </td>
                                <td>Traffic Police</td>
                                <td>13 Feb 2026</td>
                                <td>Dhaula Kuan</td>
                                <td>Delhi</td>
                                <td class="chd-mono">DL</td>
                                <td>New Delhi</td>
                                <td class="chd-mono">TRP-20260213-041</td>
                                <td class="chd-mono">DL0320260213003</td>
                                <td style="text-align:center;"><span class="chd-badge chd-badge-unpaid">Unpaid</span></td>
                                <td style="text-align:center;"><span class="chd-rag chd-rag-red"><span class="chd-dot" style="background:#ea0027;"></span> Red</span></td>
                                <td style="text-align:center;"><span class="chd-badge chd-badge-court">Court</span></td>
                                <td><span class="chd-truncate" title="Sec 185 MVA — breath analyser reading 92 mg/100 ml, above the 30 mg permissible limit.">Sec 185 MVA — BAC 92 mg/100 ml</span></td>
                                <td><span class="chd-badge chd-badge-yes">Yes</span></td>
                                <td>15 Feb 2026</td>
                                <td>Patiala House Court</td>
                                <td><span class="chd-truncate" title="Patiala House Courts Complex, India Gate, New Delhi 110001">Patiala House Courts Complex, India Gate, New Delhi</span></td>
                                <td>02 Apr 2026</td>
                                <td><span class="chd-badge chd-badge-yes">Yes</span></td>
                                <td style="text-align:center;">
                                    <button type="button" class="chd-view-btn" data-bs-toggle="modal" data-bs-target="#chdDetailModal"
                                        data-challan="DL0320260213003" data-vehicle="DL3CBA3456" data-driver="Dinesh Patel (D004)"
                                        data-amount="₹ 10,000" data-status="Unpaid" data-type="Court"
                                        data-offence="Sec 185 MVA — breath analyser reading 92 mg/100 ml, above the 30 mg permissible limit. Driver licence impounded at the spot."
                                        data-court="Yes" data-courton="15 Feb 2026" data-courtname="Patiala House Court"
                                        data-courtaddress="Patiala House Courts Complex, India Gate, New Delhi 110001"
                                        data-proceeding="02 Apr 2026" data-virtual="Yes">
                                        <i class="uil uil-eye"></i> View
                                    </button>
                                </td>
                            </tr>

                            {{-- Row 5 --}}
                            <tr data-amount="3000" data-date="2026-02-16">
                                <td class="chd-sl">5</td>
                                <td><span class="chd-reg">UP32GH7890</span></td>
                                <td>SR Carriers LLP</td>
                                <td>East Zone</td>
                                <td>
                                    <div class="chd-driver-name">Vijay Sharma</div>
                                    <div class="chd-driver-code">D005</div>
                                </td>
                                <td class="chd-mono">UP3220140067890</td>
                                <td class="chd-amt">₹ 3,000</td>
                                <td><span class="chd-truncate" title="Expired national permit at inter-state border">Expired Permit</span></td>
                                <td>
                                    <div class="chd-borne">
                                        <div class="chd-borne-line"><span class="chd-dot chd-dot-sr"></span> SR <b>₹ 3,000</b></div>
                                    </div>
                                </td>
                                <td>RTO Enforcement</td>
                                <td>16 Feb 2026</td>
                                <td>Kanpur Bypass</td>
                                <td>Uttar Pradesh</td>
                                <td class="chd-mono">UP</td>
                                <td>Kanpur Nagar</td>
                                <td class="chd-mono">TRP-20260215-056</td>
                                <td class="chd-mono">UP3220260216022</td>
                                <td style="text-align:center;"><span class="chd-badge chd-badge-unpaid">Unpaid</span></td>
                                <td style="text-align:center;"><span class="chd-rag chd-rag-amber"><span class="chd-dot" style="background:#c2410c;"></span> Amber</span></td>
                                <td style="text-align:center;"><span class="chd-badge chd-badge-online">Online</span></td>
                                <td><span class="chd-truncate" title="Sec 192A MVA — national permit expired 11 days before the inspection date.">Sec 192A MVA — permit expired 11 days</span></td>
                                <td class="chd-muted">No</td>
                                <td class="chd-muted">—</td>
                                <td class="chd-muted">—</td>
                                <td class="chd-muted">—</td>
                                <td class="chd-muted">—</td>
                                <td class="chd-muted">—</td>
                                <td style="text-align:center;">
                                    <button type="button" class="chd-view-btn" data-bs-toggle="modal" data-bs-target="#chdDetailModal"
                                        data-challan="UP3220260216022" data-vehicle="UP32GH7890" data-driver="Vijay Sharma (D005)"
                                        data-amount="₹ 3,000" data-status="Unpaid" data-type="Online"
                                        data-offence="Sec 192A MVA — national permit expired 11 days before the inspection date at Kanpur Bypass RTO check post."
                                        data-court="No" data-courton="—" data-courtname="—" data-courtaddress="—"
                                        data-proceeding="—" data-virtual="—">
                                        <i class="uil uil-eye"></i> View
                                    </button>
                                </td>
                            </tr>

                            {{-- Row 6 --}}
                            <tr data-amount="4500" data-date="2026-02-19">
                                <td class="chd-sl">6</td>
                                <td><span class="chd-reg">MP09IJ2345</span></td>
                                <td>SR Logistics Pvt. Ltd.</td>
                                <td>West Zone</td>
                                <td>
                                    <div class="chd-driver-name">Arjun Tiwari</div>
                                    <div class="chd-driver-code">D006</div>
                                </td>
                                <td class="chd-mono">MP0920120023456</td>
                                <td class="chd-amt">₹ 4,500</td>
                                <td><span class="chd-truncate" title="Red light jump at signalised junction">Red Light Jump</span></td>
                                <td>
                                    <div class="chd-borne">
                                        <div class="chd-borne-line"><span class="chd-dot chd-dot-sr"></span> SR <b>₹ 2,250</b></div>
                                        <div class="chd-borne-line"><span class="chd-dot chd-dot-driver"></span> Driver <b>₹ 2,250</b></div>
                                    </div>
                                </td>
                                <td>Traffic Police</td>
                                <td>19 Feb 2026</td>
                                <td>Vijay Nagar Square</td>
                                <td>Madhya Pradesh</td>
                                <td class="chd-mono">MP</td>
                                <td>Indore</td>
                                <td class="chd-mono">TRP-20260219-063</td>
                                <td class="chd-mono">MP0920260219009</td>
                                <td style="text-align:center;"><span class="chd-badge chd-badge-paid">Paid</span></td>
                                <td style="text-align:center;"><span class="chd-rag chd-rag-amber"><span class="chd-dot" style="background:#c2410c;"></span> Amber</span></td>
                                <td style="text-align:center;"><span class="chd-badge chd-badge-online">Online</span></td>
                                <td><span class="chd-truncate" title="Sec 184 MVA — vehicle crossed stop line 2.4 seconds after signal turned red.">Sec 184 MVA — crossed stop line on red</span></td>
                                <td class="chd-muted">No</td>
                                <td class="chd-muted">—</td>
                                <td class="chd-muted">—</td>
                                <td class="chd-muted">—</td>
                                <td class="chd-muted">—</td>
                                <td class="chd-muted">—</td>
                                <td style="text-align:center;">
                                    <button type="button" class="chd-view-btn" data-bs-toggle="modal" data-bs-target="#chdDetailModal"
                                        data-challan="MP0920260219009" data-vehicle="MP09IJ2345" data-driver="Arjun Tiwari (D006)"
                                        data-amount="₹ 4,500" data-status="Paid" data-type="Online"
                                        data-offence="Sec 184 MVA — vehicle crossed stop line 2.4 seconds after signal turned red at Vijay Nagar Square, captured on ANPR."
                                        data-court="No" data-courton="—" data-courtname="—" data-courtaddress="—"
                                        data-proceeding="—" data-virtual="—">
                                        <i class="uil uil-eye"></i> View
                                    </button>
                                </td>
                            </tr>

                            {{-- Row 7 --}}
                            <tr data-amount="7500" data-date="2026-02-22">
                                <td class="chd-sl">7</td>
                                <td><span class="chd-reg">KA05KL6789</span></td>
                                <td>SR Carriers LLP</td>
                                <td>South Zone</td>
                                <td>
                                    <div class="chd-driver-name">Prakash Nair</div>
                                    <div class="chd-driver-code">D007</div>
                                </td>
                                <td class="chd-mono">KA0520170078901</td>
                                <td class="chd-amt">₹ 7,500</td>
                                <td><span class="chd-truncate" title="Dangerous driving in a no-entry zone">Dangerous Driving</span></td>
                                <td>
                                    <div class="chd-borne">
                                        <div class="chd-borne-line"><span class="chd-badge chd-badge-none">Not Assigned</span></div>
                                    </div>
                                </td>
                                <td>Traffic Police</td>
                                <td>22 Feb 2026</td>
                                <td>Hosur Road</td>
                                <td>Karnataka</td>
                                <td class="chd-mono">KA</td>
                                <td>Bengaluru Urban</td>
                                <td class="chd-muted">—</td>
                                <td class="chd-mono">KA0520260222011</td>
                                <td style="text-align:center;"><span class="chd-badge chd-badge-unpaid">Unpaid</span></td>
                                <td style="text-align:center;"><span class="chd-rag chd-rag-red"><span class="chd-dot" style="background:#ea0027;"></span> Red</span></td>
                                <td style="text-align:center;"><span class="chd-badge chd-badge-court">Court</span></td>
                                <td><span class="chd-truncate" title="Sec 184 MVA — goods vehicle entered a restricted no-entry corridor during peak hours.">Sec 184 MVA — no-entry corridor breach</span></td>
                                <td><span class="chd-badge chd-badge-yes">Yes</span></td>
                                <td>25 Feb 2026</td>
                                <td>Traffic Court, Bengaluru</td>
                                <td><span class="chd-truncate" title="City Civil Court Complex, Mayo Hall, Bengaluru, Karnataka 560001">City Civil Court Complex, Mayo Hall, Bengaluru</span></td>
                                <td>10 Apr 2026</td>
                                <td><span class="chd-badge chd-badge-yes">Yes</span></td>
                                <td style="text-align:center;">
                                    <button type="button" class="chd-view-btn" data-bs-toggle="modal" data-bs-target="#chdDetailModal"
                                        data-challan="KA0520260222011" data-vehicle="KA05KL6789" data-driver="Prakash Nair (D007)"
                                        data-amount="₹ 7,500" data-status="Unpaid" data-type="Court"
                                        data-offence="Sec 184 MVA — goods vehicle entered a restricted no-entry corridor during peak hours on Hosur Road."
                                        data-court="Yes" data-courton="25 Feb 2026" data-courtname="Traffic Court, Bengaluru"
                                        data-courtaddress="City Civil Court Complex, Mayo Hall, Bengaluru, Karnataka 560001"
                                        data-proceeding="10 Apr 2026" data-virtual="Yes">
                                        <i class="uil uil-eye"></i> View
                                    </button>
                                </td>
                            </tr>

                            {{-- Row 8 --}}
                            <tr data-amount="1500" data-date="2026-02-26">
                                <td class="chd-sl">8</td>
                                <td><span class="chd-reg">MH12AB1234</span></td>
                                <td>SR Logistics Pvt. Ltd.</td>
                                <td>North Zone</td>
                                <td>
                                    <div class="chd-driver-name">Ramesh Kumar</div>
                                    <div class="chd-driver-code">D001</div>
                                </td>
                                <td class="chd-mono">MH1420110012345</td>
                                <td class="chd-amt">₹ 1,500</td>
                                <td><span class="chd-truncate" title="Improper parking on national highway shoulder">Improper Parking</span></td>
                                <td>
                                    <div class="chd-borne">
                                        <div class="chd-borne-line"><span class="chd-dot chd-dot-sr"></span> SR <b>₹ 750</b></div>
                                        <div class="chd-borne-line"><span class="chd-dot chd-dot-driver"></span> Driver <b>₹ 750</b></div>
                                    </div>
                                </td>
                                <td>Highway Patrol</td>
                                <td>26 Feb 2026</td>
                                <td>NH-48, Talegaon</td>
                                <td>Maharashtra</td>
                                <td class="chd-mono">MH</td>
                                <td>Pune</td>
                                <td class="chd-mono">TRP-20260226-071</td>
                                <td class="chd-mono">MH1220260226019</td>
                                <td style="text-align:center;"><span class="chd-badge chd-badge-paid">Paid</span></td>
                                <td style="text-align:center;"><span class="chd-rag chd-rag-green"><span class="chd-dot" style="background:#157347;"></span> Green</span></td>
                                <td style="text-align:center;"><span class="chd-badge chd-badge-online">Online</span></td>
                                <td><span class="chd-truncate" title="Sec 122 MVA — vehicle parked on the highway shoulder obstructing the emergency lane.">Sec 122 MVA — obstructing emergency lane</span></td>
                                <td class="chd-muted">No</td>
                                <td class="chd-muted">—</td>
                                <td class="chd-muted">—</td>
                                <td class="chd-muted">—</td>
                                <td class="chd-muted">—</td>
                                <td class="chd-muted">—</td>
                                <td style="text-align:center;">
                                    <button type="button" class="chd-view-btn" data-bs-toggle="modal" data-bs-target="#chdDetailModal"
                                        data-challan="MH1220260226019" data-vehicle="MH12AB1234" data-driver="Ramesh Kumar (D001)"
                                        data-amount="₹ 1,500" data-status="Paid" data-type="Online"
                                        data-offence="Sec 122 MVA — vehicle parked on the highway shoulder obstructing the emergency lane on NH-48 near Talegaon."
                                        data-court="No" data-courton="—" data-courtname="—" data-courtaddress="—"
                                        data-proceeding="—" data-virtual="—">
                                        <i class="uil uil-eye"></i> View
                                    </button>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>

                <div class="chd-table-foot">
                    <span>Showing <b>8</b> of <b>248</b> challans</span>
                    <span>Total on this page: <b>₹ 34,500</b> · SR <b>₹ 11,000</b> · Driver <b>₹ 16,000</b> · Not Assigned <b>₹ 7,500</b></span>
                </div>

            </div>
            {{-- /table card --}}

        </div>{{-- /sc-no-sidebar --}}
    </div>{{-- /wrapper --}}
</div>{{-- /layout-wrapper --}}

{{-- ══════════════════════════════════════════════════
     Challan Details Modal (static)
══════════════════════════════════════════════════ --}}
<div class="modal fade" id="chdDetailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content chd-modal">
            <div class="modal-header">
                <div>
                    <h6 class="modal-title mb-0" id="chdModalChallan">Challan Details</h6>
                    <span class="chd-modal-sub" id="chdModalMeta">Vehicle &amp; driver details</span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                {{-- Summary strip --}}
                <div class="chd-modal-summary">
                    <div class="chd-modal-stat">
                        <div class="chd-modal-stat-label">Challan Amount</div>
                        <div class="chd-modal-stat-val" id="chdModalAmount">₹ 0</div>
                    </div>
                    <div class="chd-modal-stat">
                        <div class="chd-modal-stat-label">Challan Status</div>
                        <div class="chd-modal-stat-val" id="chdModalStatus">—</div>
                    </div>
                    <div class="chd-modal-stat">
                        <div class="chd-modal-stat-label">Challan Type</div>
                        <div class="chd-modal-stat-val" id="chdModalType">—</div>
                    </div>
                </div>

                {{-- Offence details --}}
                <div class="chd-modal-section-title"><i class="uil uil-exclamation-triangle"></i> Offence Details</div>
                <div class="chd-offence-box" id="chdModalOffence">—</div>

                {{-- Court details --}}
                <div class="chd-modal-section-title"><i class="uil uil-balance-scale"></i> Court Details</div>
                <div class="chd-def-grid">
                    <div>
                        <div class="chd-def-label">Sent to Reg. Court</div>
                        <div class="chd-def-val" id="chdModalCourt">—</div>
                    </div>
                    <div>
                        <div class="chd-def-label">Sent to Court On</div>
                        <div class="chd-def-val" id="chdModalCourtOn">—</div>
                    </div>
                    <div>
                        <div class="chd-def-label">Court Name</div>
                        <div class="chd-def-val" id="chdModalCourtName">—</div>
                    </div>
                    <div>
                        <div class="chd-def-label">Court Address</div>
                        <div class="chd-def-val" id="chdModalCourtAddress">—</div>
                    </div>
                    <div>
                         <div class="chd-def-label">Date of Proceeding</div>
                        <div class="chd-def-val" id="chdModalProceeding">—</div>
                    </div>
                    <div>
                        <div class="chd-def-label">Sent to Virtual Court</div>
                        <div class="chd-def-val" id="chdModalVirtual">—</div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="chd-modal-close" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('js/Challan/challan-dashboard.js?v=1.2') }}"></script>
@endsection