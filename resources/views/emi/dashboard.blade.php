@extends('layouts.app')

@section('css')
<link href="{{ asset('css/Emi/emi-dashboard.css?v=1.0') }}" rel="stylesheet">
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
                    <li class="breadcrumb-item"><a href="{{ route('fleetdashboard.index') }}">Finance</a></li>
                    <li class="breadcrumb-item active">EMI Dashboard</li>
                </ol>
            </nav>

            {{-- Page Header --}}
            <div class="sc-page-head d-flex align-items-center justify-content-between mb-3">
                <div>
                    <h5 class="mb-0">EMI Dashboard</h5>
                    <span class="text-muted" style="font-size:12px;">Vehicle loan EMIs &middot; On-time vs late &middot; EMI date &amp; bank split</span>
                </div>
                <div class="emid-period-badge">
                    <i class="uil uil-calendar-alt"></i> 01 Feb 2026 – 28 Feb 2026
                </div>
            </div>

            {{-- ══════════════════════════════════════════════════
                 SECTION 1 — Mini Dashboard
            ══════════════════════════════════════════════════ --}}
            <div class="emid-kpi-wrap">

                {{-- Group 1 — Overall --}}
                <div class="emid-kpi-group emid-span-12">
                    <div class="emid-kpi-group-title"><i class="uil uil-chart-pie"></i> Overall</div>
                    <div class="emid-kpi-row emid-cols-4">

                        <div class="emid-kpi-card card-total">
                            <div class="emid-kpi-label"><i class="uil uil-usd-circle"></i> Total EMI</div>
                            <div class="emid-kpi-amt">₹ 48,72,000</div>
                            <div class="emid-kpi-divider"></div>
                            <div class="emid-kpi-qty"><span>96</span> EMIs</div>
                        </div>

                        <div class="emid-kpi-card card-ontime">
                            <div class="emid-kpi-label"><i class="uil uil-check-circle"></i> On Time Paid EMI</div>
                            <div class="emid-kpi-amt">₹ 41,15,000</div>
                            <div class="emid-kpi-divider"></div>
                            <div class="emid-kpi-qty"><span>81</span> EMIs</div>
                        </div>

                        <div class="emid-kpi-card card-late">
                            <div class="emid-kpi-label"><i class="uil uil-clock-eight"></i> Late Paid EMI</div>
                            <div class="emid-kpi-amt">₹ 7,57,000</div>
                            <div class="emid-kpi-divider"></div>
                            <div class="emid-kpi-qty"><span>15</span> EMIs</div>
                        </div>

                        <div class="emid-kpi-card card-charges">
                            <div class="emid-kpi-label"><i class="uil uil-exclamation-triangle"></i> Late EMI Charges</div>
                            <div class="emid-kpi-amt">₹ 46,500</div>
                            <div class="emid-kpi-divider"></div>
                            <div class="emid-kpi-qty"><span>15</span> Charges</div>
                        </div>

                    </div>
                </div>

                {{-- Group 2 — EMI Date Wise --}}
                <div class="emid-kpi-group emid-span-5">
                    <div class="emid-kpi-group-title"><i class="uil uil-calendar-alt"></i> EMI Date Wise</div>
                    <div class="emid-kpi-row emid-cols-3">

                        <div class="emid-kpi-card card-d1">
                            <div class="emid-kpi-label"><i class="uil uil-calender"></i> 1st</div>
                            <div class="emid-kpi-amt">₹ 19,84,000</div>
                            <div class="emid-kpi-divider"></div>
                            <div class="emid-kpi-qty"><span>39</span> EMIs</div>
                        </div>

                        <div class="emid-kpi-card card-d5">
                            <div class="emid-kpi-label"><i class="uil uil-calender"></i> 5th</div>
                            <div class="emid-kpi-amt">₹ 16,42,000</div>
                            <div class="emid-kpi-divider"></div>
                            <div class="emid-kpi-qty"><span>33</span> EMIs</div>
                        </div>

                        <div class="emid-kpi-card card-d10">
                            <div class="emid-kpi-label"><i class="uil uil-calender"></i> 10th</div>
                            <div class="emid-kpi-amt">₹ 12,46,000</div>
                            <div class="emid-kpi-divider"></div>
                            <div class="emid-kpi-qty"><span>24</span> EMIs</div>
                        </div>

                    </div>
                </div>

                {{-- Group 3 — Bank Wise --}}
                <div class="emid-kpi-group emid-span-7">
                    <div class="emid-kpi-group-title"><i class="uil uil-university"></i> Bank Wise</div>
                    <div class="emid-kpi-row emid-cols-4">

                        <div class="emid-kpi-card card-hdfc">
                            <div class="emid-kpi-label"><i class="uil uil-university"></i> HDFC</div>
                            <div class="emid-kpi-amt">₹ 15,26,000</div>
                            <div class="emid-kpi-divider"></div>
                            <div class="emid-kpi-qty"><span>30</span> EMIs</div>
                        </div>

                        <div class="emid-kpi-card card-kotak">
                            <div class="emid-kpi-label"><i class="uil uil-university"></i> Kotak</div>
                            <div class="emid-kpi-amt">₹ 11,84,000</div>
                            <div class="emid-kpi-divider"></div>
                            <div class="emid-kpi-qty"><span>24</span> EMIs</div>
                        </div>

                        <div class="emid-kpi-card card-idfc">
                            <div class="emid-kpi-label"><i class="uil uil-university"></i> IDFC</div>
                            <div class="emid-kpi-amt">₹ 10,38,000</div>
                            <div class="emid-kpi-divider"></div>
                            <div class="emid-kpi-qty"><span>21</span> EMIs</div>
                        </div>

                        <div class="emid-kpi-card card-icici">
                            <div class="emid-kpi-label"><i class="uil uil-university"></i> ICICI</div>
                            <div class="emid-kpi-amt">₹ 11,24,000</div>
                            <div class="emid-kpi-divider"></div>
                            <div class="emid-kpi-qty"><span>21</span> EMIs</div>
                        </div>

                    </div>
                </div>

            </div>{{-- /emid-kpi-wrap --}}

            {{-- ══════════════════════════════════════════════════
                 SECTION 2 — Filter Card
            ══════════════════════════════════════════════════ --}}
            <div class="emid-filter-card">
                <div class="emid-filter-header">
                    <div class="emid-filter-title">
                        <i class="uil uil-filter"></i> Filters
                    </div>
                </div>
                <div class="emid-filter-body">
                <form id="emidFilterForm" method="GET" action="{{ route('emi.dashboard') }}">

                    <div class="row g-2 align-items-end">

                        {{-- EMI Status --}}
                        <div class="col-lg-2 col-md-4 col-6">
                            <div class="emid-filter-group">
                                <label class="emid-filter-label"><i class="uil uil-toggle-on"></i> EMI Status</label>
                                <select id="emidStatus" name="emi_status" class="form-select">
                                    <option value="">All Status</option>
                                    <option value="Active">Active</option>
                                    <option value="Completed">Completed</option>
                                </select>
                            </div>
                        </div>

                        {{-- Financer Name --}}
                        <div class="col-lg-2 col-md-4 col-6">
                            <div class="emid-filter-group">
                                <label class="emid-filter-label"><i class="uil uil-university"></i> Financer Name</label>
                                <select id="emidFinancer" name="financer" class="form-select">
                                    <option value="">All Financers</option>
                                    <option value="HDFC">HDFC</option>
                                    <option value="Kotak">Kotak</option>
                                    <option value="IDFC">IDFC</option>
                                    <option value="ICICI">ICICI</option>
                                </select>
                            </div>
                        </div>

                        {{-- EMI Date --}}
                        <div class="col-lg-2 col-md-4 col-6">
                            <div class="emid-filter-group">
                                <label class="emid-filter-label"><i class="uil uil-calendar-alt"></i> EMI Date</label>
                                <select id="emidDate" name="emi_date" class="form-select">
                                    <option value="">All Dates</option>
                                    <option value="1">1st</option>
                                    <option value="5">5th</option>
                                    <option value="10">10th</option>
                                </select>
                            </div>
                        </div>

                        {{-- Vehicle Number --}}
                        <div class="col-lg-2 col-md-4 col-6">
                            <div class="emid-filter-group">
                                <label class="emid-filter-label"><i class="uil uil-truck"></i> Vehicle Number</label>
                                <div class="input-group" style="flex-wrap:nowrap;">
                                    <span class="input-group-text" style="padding:0 8px;">
                                        <i class="uil uil-search" style="font-size:13px;color:#4b6cb7;"></i>
                                    </span>
                                    <input type="text" id="emidVehicle" name="vehicle" class="form-control"
                                        placeholder="e.g. MH12AB1234"
                                        value="{{ request('vehicle') }}">
                                </div>
                            </div>
                        </div>

                        {{-- Loan Type --}}
                        <div class="col-lg-2 col-md-4 col-6">
                            <div class="emid-filter-group">
                                <label class="emid-filter-label"><i class="uil uil-file-contract-dollar"></i> Loan Type</label>
                                <select id="emidLoanType" name="loan_type" class="form-select">
                                    <option value="">All Loan Types</option>
                                    <option value="Chassis">Chassis</option>
                                    <option value="Body">Body</option>
                                    <option value="Re-finance">Re-finance</option>
                                </select>
                            </div>
                        </div>

                        {{-- Reset --}}
                        <div class="col-lg-2 col-md-4 col-6 d-flex align-items-end">
                            <a href="{{ route('emi.dashboard') }}" class="emid-reset-link">
                                <i class="uil uil-redo"></i> Reset Filters
                            </a>
                        </div>

                    </div>

                </form>
                </div>{{-- /emid-filter-body --}}
            </div>

            {{-- ══════════════════════════════════════════════════
                 SECTION 3 — Table Card
            ══════════════════════════════════════════════════ --}}
            <div class="emid-table-card">

                <div class="emid-table-head">
                    <div>
                        <div class="emid-table-head-title">
                            <i class="uil uil-list-ul"></i> All EMI Records
                        </div>
                        <div class="emid-table-head-sub">8 loan accounts &middot; 01 Feb 2026 – 28 Feb 2026</div>
                    </div>
                    <div class="emid-head-actions">
                        <button type="button" class="emid-btn-export" id="emidExport">
                            <i class="uil uil-import"></i> Export
                        </button>
                        <button type="button" class="emid-btn-add" id="emidAddEmi">
                            <i class="uil uil-plus"></i> Add EMI
                        </button>
                    </div>
                </div>

                <div class="emid-table">
                    <table class="table mb-0" id="emidTable">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Vehicle Number</th>
                                <th>Tracking Group</th>
                                <th style="text-align:center;">EMI Status</th>
                                <th class="emid-sortable" data-sort-key="emidate" data-sort-type="num">
                                    EMI Date <i class="uil uil-sort emid-sort-icon"></i>
                                </th>
                                <th class="emid-sortable emid-th-num emid-th-group" data-sort-key="emiamt" data-sort-type="num">
                                    EMI Amount <i class="uil uil-sort emid-sort-icon"></i>
                                </th>
                                <th>Financer / Bank Name</th>
                                <th>Loan Account Number</th>
                                <th style="text-align:center;">Loan Type</th>
                                <th>EMI Start &amp; End Date</th>
                                <th class="emid-th-num">Total EMI&rsquo;s</th>
                                <th class="emid-sortable" data-sort-key="progress" data-sort-type="num">
                                    EMI Progress <i class="uil uil-sort emid-sort-icon"></i>
                                </th>
                                <th class="emid-sortable emid-th-num" data-sort-key="roi" data-sort-type="num">
                                    Rate of Interest <i class="uil uil-sort emid-sort-icon"></i>
                                </th>
                                <th class="emid-sortable emid-th-num" data-sort-key="loanamt" data-sort-type="num">
                                    Total Loan Amount <i class="uil uil-sort emid-sort-icon"></i>
                                </th>
                                <th class="emid-th-num">Total Loan Repayment</th>
                                <th class="emid-th-num">Principal Repayment</th>
                                <th class="emid-th-num">Interest Repayment</th>
                                <th style="text-align:center;">Attachment</th>
                            </tr>
                        </thead>
                        <tbody id="emidTableBody">

                            {{-- Row 1 --}}
                            <tr data-emidate="1" data-emiamt="58400" data-progress="27.78" data-roi="9.25" data-loanamt="1650000">
                                <td class="emid-sl">1</td>
                                <td><span class="emid-reg">MH12AB1234</span></td>
                                <td>North Zone</td>
                                <td style="text-align:center;"><span class="emid-badge emid-badge-active">Active</span></td>
                                <td><span class="emid-day">1st</span></td>
                                <td class="emid-num emid-emi">₹ 58,400</td>
                                <td><span class="emid-bank">HDFC</span></td>
                                <td class="emid-mono">50200087654321</td>
                                <td style="text-align:center;"><span class="emid-badge emid-badge-chassis">Chassis</span></td>
                                <td>
                                    <div>01 Apr 2024</div>
                                    <div class="emid-sub">01 Mar 2027</div>
                                </td>
                                <td class="emid-num">36</td>
                                <td>
                                    <div class="emid-progress-wrap">
                                        <div class="emid-progress-txt">10 / 36</div>
                                        <div class="emid-progress-bar"><div class="emid-progress-fill" style="width:27.78%;"></div></div>
                                    </div>
                                </td>
                                <td class="emid-num emid-roi">9.25%</td>
                                <td class="emid-num emid-amt">₹ 16,50,000</td>
                                <td class="emid-num emid-amt">₹ 21,02,400</td>
                                <td class="emid-num">₹ 16,50,000</td>
                                <td class="emid-num">₹ 4,52,400</td>
                                <td style="text-align:center;">
                                    <a href="javascript:void(0)" class="emid-attach"><i class="uil uil-file-download-alt"></i> Schedule</a>
                                </td>
                            </tr>

                            {{-- Row 2 --}}
                            <tr data-emidate="5" data-emiamt="42150" data-progress="50.00" data-roi="10.10" data-loanamt="980000">
                                <td class="emid-sl">2</td>
                                <td><span class="emid-reg">GJ01CD5678</span></td>
                                <td>West Zone</td>
                                <td style="text-align:center;"><span class="emid-badge emid-badge-active">Active</span></td>
                                <td><span class="emid-day">5th</span></td>
                                <td class="emid-num emid-emi">₹ 42,150</td>
                                <td><span class="emid-bank">Kotak</span></td>
                                <td class="emid-mono">KTK0091234455</td>
                                <td style="text-align:center;"><span class="emid-badge emid-badge-body">Body</span></td>
                                <td>
                                    <div>05 Sep 2024</div>
                                    <div class="emid-sub">05 Aug 2026</div>
                                </td>
                                <td class="emid-num">24</td>
                                <td>
                                    <div class="emid-progress-wrap">
                                        <div class="emid-progress-txt">12 / 24</div>
                                        <div class="emid-progress-bar"><div class="emid-progress-fill" style="width:50%;"></div></div>
                                    </div>
                                </td>
                                <td class="emid-num emid-roi">10.10%</td>
                                <td class="emid-num emid-amt">₹ 9,80,000</td>
                                <td class="emid-num emid-amt">₹ 10,11,600</td>
                                <td class="emid-num">₹ 9,80,000</td>
                                <td class="emid-num">₹ 1,31,600</td>
                                <td style="text-align:center;">
                                    <a href="javascript:void(0)" class="emid-attach"><i class="uil uil-file-download-alt"></i> Schedule</a>
                                </td>
                            </tr>

                            {{-- Row 3 --}}
                            <tr data-emidate="10" data-emiamt="65900" data-progress="100.00" data-roi="8.75" data-loanamt="2200000">
                                <td class="emid-sl">3</td>
                                <td><span class="emid-reg">RJ14EF9012</span></td>
                                <td>North Zone</td>
                                <td style="text-align:center;"><span class="emid-badge emid-badge-completed">Completed</span></td>
                                <td><span class="emid-day">10th</span></td>
                                <td class="emid-num emid-emi">₹ 65,900</td>
                                <td><span class="emid-bank">IDFC</span></td>
                                <td class="emid-mono">IDFC7788990011</td>
                                <td style="text-align:center;"><span class="emid-badge emid-badge-chassis">Chassis</span></td>
                                <td>
                                    <div>10 Jan 2022</div>
                                    <div class="emid-sub">10 Dec 2025</div>
                                </td>
                                <td class="emid-num">48</td>
                                <td>
                                    <div class="emid-progress-wrap">
                                        <div class="emid-progress-txt">48 / 48</div>
                                        <div class="emid-progress-bar"><div class="emid-progress-fill is-done" style="width:100%;"></div></div>
                                    </div>
                                </td>
                                <td class="emid-num emid-roi">8.75%</td>
                                <td class="emid-num emid-amt">₹ 22,00,000</td>
                                <td class="emid-num emid-amt">₹ 31,63,200</td>
                                <td class="emid-num">₹ 22,00,000</td>
                                <td class="emid-num">₹ 9,63,200</td>
                                <td style="text-align:center;">
                                    <a href="javascript:void(0)" class="emid-attach"><i class="uil uil-file-download-alt"></i> Schedule</a>
                                </td>
                            </tr>

                            {{-- Row 4 --}}
                            <tr data-emidate="1" data-emiamt="37800" data-progress="41.67" data-roi="11.40" data-loanamt="1150000">
                                <td class="emid-sl">4</td>
                                <td><span class="emid-reg">DL3CBA3456</span></td>
                                <td>South Zone</td>
                                <td style="text-align:center;"><span class="emid-badge emid-badge-active">Active</span></td>
                                <td><span class="emid-day">1st</span></td>
                                <td class="emid-num emid-emi">₹ 37,800</td>
                                <td><span class="emid-bank">ICICI</span></td>
                                <td class="emid-mono">ICI0045612378</td>
                                <td style="text-align:center;"><span class="emid-badge emid-badge-refinance">Re-finance</span></td>
                                <td>
                                    <div>01 Jul 2024</div>
                                    <div class="emid-sub">01 Jun 2027</div>
                                </td>
                                <td class="emid-num">36</td>
                                <td>
                                    <div class="emid-progress-wrap">
                                        <div class="emid-progress-txt">15 / 36</div>
                                        <div class="emid-progress-bar"><div class="emid-progress-fill" style="width:41.67%;"></div></div>
                                    </div>
                                </td>
                                <td class="emid-num emid-roi">11.40%</td>
                                <td class="emid-num emid-amt">₹ 11,50,000</td>
                                <td class="emid-num emid-amt">₹ 13,60,800</td>
                                <td class="emid-num">₹ 11,50,000</td>
                                <td class="emid-num">₹ 2,10,800</td>
                                <td style="text-align:center;">
                                    <a href="javascript:void(0)" class="emid-attach"><i class="uil uil-file-download-alt"></i> Schedule</a>
                                </td>
                            </tr>

                            {{-- Row 5 --}}
                            <tr data-emidate="5" data-emiamt="51250" data-progress="16.67" data-roi="9.90" data-loanamt="1480000">
                                <td class="emid-sl">5</td>
                                <td><span class="emid-reg">UP32GH7890</span></td>
                                <td>East Zone</td>
                                <td style="text-align:center;"><span class="emid-badge emid-badge-active">Active</span></td>
                                <td><span class="emid-day">5th</span></td>
                                <td class="emid-num emid-emi">₹ 51,250</td>
                                <td><span class="emid-bank">HDFC</span></td>
                                <td class="emid-mono">50200099887766</td>
                                <td style="text-align:center;"><span class="emid-badge emid-badge-chassis">Chassis</span></td>
                                <td>
                                    <div>05 Sep 2025</div>
                                    <div class="emid-sub">05 Aug 2028</div>
                                </td>
                                <td class="emid-num">36</td>
                                <td>
                                    <div class="emid-progress-wrap">
                                        <div class="emid-progress-txt">6 / 36</div>
                                        <div class="emid-progress-bar"><div class="emid-progress-fill" style="width:16.67%;"></div></div>
                                    </div>
                                </td>
                                <td class="emid-num emid-roi">9.90%</td>
                                <td class="emid-num emid-amt">₹ 14,80,000</td>
                                <td class="emid-num emid-amt">₹ 18,45,000</td>
                                <td class="emid-num">₹ 14,80,000</td>
                                <td class="emid-num">₹ 3,65,000</td>
                                <td style="text-align:center;">
                                    <a href="javascript:void(0)" class="emid-attach"><i class="uil uil-file-download-alt"></i> Schedule</a>
                                </td>
                            </tr>

                            {{-- Row 6 --}}
                            <tr data-emidate="10" data-emiamt="29600" data-progress="75.00" data-roi="12.25" data-loanamt="640000">
                                <td class="emid-sl">6</td>
                                <td><span class="emid-reg">MP09IJ2345</span></td>
                                <td>West Zone</td>
                                <td style="text-align:center;"><span class="emid-badge emid-badge-active">Active</span></td>
                                <td><span class="emid-day">10th</span></td>
                                <td class="emid-num emid-emi">₹ 29,600</td>
                                <td><span class="emid-bank">Kotak</span></td>
                                <td class="emid-mono">KTK0033445566</td>
                                <td style="text-align:center;"><span class="emid-badge emid-badge-body">Body</span></td>
                                <td>
                                    <div>10 Mar 2024</div>
                                    <div class="emid-sub">10 Feb 2026</div>
                                </td>
                                <td class="emid-num">24</td>
                                <td>
                                    <div class="emid-progress-wrap">
                                        <div class="emid-progress-txt">18 / 24</div>
                                        <div class="emid-progress-bar"><div class="emid-progress-fill" style="width:75%;"></div></div>
                                    </div>
                                </td>
                                <td class="emid-num emid-roi">12.25%</td>
                                <td class="emid-num emid-amt">₹ 6,40,000</td>
                                <td class="emid-num emid-amt">₹ 7,10,400</td>
                                <td class="emid-num">₹ 6,40,000</td>
                                <td class="emid-num">₹ 70,400</td>
                                <td style="text-align:center;">
                                    <a href="javascript:void(0)" class="emid-attach"><i class="uil uil-file-download-alt"></i> Schedule</a>
                                </td>
                            </tr>

                            {{-- Row 7 --}}
                            <tr data-emidate="1" data-emiamt="47300" data-progress="61.11" data-roi="10.60" data-loanamt="1320000">
                                <td class="emid-sl">7</td>
                                <td><span class="emid-reg">KA05KL6789</span></td>
                                <td>South Zone</td>
                                <td style="text-align:center;"><span class="emid-badge emid-badge-active">Active</span></td>
                                <td><span class="emid-day">1st</span></td>
                                <td class="emid-num emid-emi">₹ 47,300</td>
                                <td><span class="emid-bank">IDFC</span></td>
                                <td class="emid-mono">IDFC5566778899</td>
                                <td style="text-align:center;"><span class="emid-badge emid-badge-refinance">Re-finance</span></td>
                                <td>
                                    <div>01 Nov 2023</div>
                                    <div class="emid-sub">01 Oct 2026</div>
                                </td>
                                <td class="emid-num">36</td>
                                <td>
                                    <div class="emid-progress-wrap">
                                        <div class="emid-progress-txt">22 / 36</div>
                                        <div class="emid-progress-bar"><div class="emid-progress-fill" style="width:61.11%;"></div></div>
                                    </div>
                                </td>
                                <td class="emid-num emid-roi">10.60%</td>
                                <td class="emid-num emid-amt">₹ 13,20,000</td>
                                <td class="emid-num emid-amt">₹ 17,02,800</td>
                                <td class="emid-num">₹ 13,20,000</td>
                                <td class="emid-num">₹ 3,82,800</td>
                                <td style="text-align:center;">
                                    <a href="javascript:void(0)" class="emid-attach"><i class="uil uil-file-download-alt"></i> Schedule</a>
                                </td>
                            </tr>

                            {{-- Row 8 --}}
                            <tr data-emidate="5" data-emiamt="33450" data-progress="100.00" data-roi="11.80" data-loanamt="720000">
                                <td class="emid-sl">8</td>
                                <td><span class="emid-reg">MH12AB1234</span></td>
                                <td>North Zone</td>
                                <td style="text-align:center;"><span class="emid-badge emid-badge-completed">Completed</span></td>
                                <td><span class="emid-day">5th</span></td>
                                <td class="emid-num emid-emi">₹ 33,450</td>
                                <td><span class="emid-bank">ICICI</span></td>
                                <td class="emid-mono">ICI0077889900</td>
                                <td style="text-align:center;"><span class="emid-badge emid-badge-body">Body</span></td>
                                <td>
                                    <div>05 Jan 2024</div>
                                    <div class="emid-sub">05 Dec 2025</div>
                                </td>
                                <td class="emid-num">24</td>
                                <td>
                                    <div class="emid-progress-wrap">
                                        <div class="emid-progress-txt">24 / 24</div>
                                        <div class="emid-progress-bar"><div class="emid-progress-fill is-done" style="width:100%;"></div></div>
                                    </div>
                                </td>
                                <td class="emid-num emid-roi">11.80%</td>
                                <td class="emid-num emid-amt">₹ 7,20,000</td>
                                <td class="emid-num emid-amt">₹ 8,02,800</td>
                                <td class="emid-num">₹ 7,20,000</td>
                                <td class="emid-num">₹ 82,800</td>
                                <td style="text-align:center;">
                                    <a href="javascript:void(0)" class="emid-attach"><i class="uil uil-file-download-alt"></i> Schedule</a>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>

                <div class="emid-table-foot">
                    <span>Showing <b>8</b> of <b>96</b> EMI records</span>
                    <span>EMI on this page: <b>₹ 3,65,850</b> &middot; Loan Amount <b>₹ 87,40,000</b> &middot; Repayment <b>₹ 1,26,99,000</b></span>
                </div>

            </div>
            {{-- /table card --}}

        </div>{{-- /sc-no-sidebar --}}
    </div>{{-- /wrapper --}}
</div>{{-- /layout-wrapper --}}
@endsection

@section('js')
<script src="{{ asset('js/Emi/emi-dashboard.js?v=1.0') }}"></script>
@endsection
