@extends('layouts.app')

@section('css')
<link href="{{ asset('css/Escalation/escalation-dashboard.css?v=1.0') }}" rel="stylesheet">
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
                    <li class="breadcrumb-item active">Escalation Dashboard</li>
                </ol>
            </nav>

            {{-- Page Header --}}
            <div class="sc-page-head d-flex align-items-center justify-content-between mb-3">
                <div>
                    <h5 class="mb-0">Escalation Dashboard</h5>
                    <span class="text-muted" style="font-size:12px;">Exception management &middot; RAG &amp; priority tracking &middot; Ownership</span>
                </div>
                <div class="esd-head-badge">
                    <i class="uil uil-calendar-alt"></i> 01 Jul 2026 &ndash; 08 Jul 2026
                </div>
            </div>

            {{-- ══════════════════════════════════════════════════
                 SECTION 1 — Mini Dashboard
            ══════════════════════════════════════════════════ --}}
            <div class="esd-kpi-wrap">

                <div class="esd-kpi-card card-total">
                    <div class="esd-kpi-label"><i class="uil uil-exclamation-octagon"></i> Total Escalation</div>
                    <div class="esd-kpi-val">142</div>
                    <div class="esd-kpi-divider"></div>
                    <div class="esd-kpi-sub"><span>142</span> escalations raised in period</div>
                </div>

                <div class="esd-kpi-card card-open">
                    <div class="esd-kpi-label"><i class="uil uil-exclamation-circle"></i> Open Escalation</div>
                    <div class="esd-kpi-val">38</div>
                    <div class="esd-kpi-divider"></div>
                    <div class="esd-kpi-sub"><span>26.8%</span> of total &middot; pending closure</div>
                </div>

                <div class="esd-kpi-card card-closed">
                    <div class="esd-kpi-label"><i class="uil uil-check-circle"></i> Closed Escalation</div>
                    <div class="esd-kpi-val">104</div>
                    <div class="esd-kpi-divider"></div>
                    <div class="esd-kpi-sub"><span>73.2%</span> of total &middot; resolved</div>
                </div>

            </div>{{-- /esd-kpi-wrap --}}

            {{-- ══════════════════════════════════════════════════
                 SECTION 2 — Filter Card
            ══════════════════════════════════════════════════ --}}
            <div class="esd-filter-card">
                <div class="esd-filter-header">
                    <div class="esd-filter-title">
                        <i class="uil uil-filter"></i> Filters
                    </div>
                </div>
                <div class="esd-filter-body">
                <form id="esdFilterForm" method="GET" action="{{ route('escalation.dashboard') }}">

                    <div class="row g-2 align-items-end mb-2">

                        {{-- Escalation For --}}
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="esd-filter-group">
                                <label class="esd-filter-label" for="esdFor"><i class="uil uil-apps"></i> Escalation For</label>
                                <select id="esdFor" name="escalation_for" class="form-select">
                                    <option value="">All Types</option>
                                    <option value="Vehicle">Vehicle</option>
                                    <option value="Driver">Driver</option>
                                    <option value="Trip">Trip</option>
                                    <option value="Customer">Customer</option>
                                    <option value="Vendor">Vendor</option>
                                </select>
                            </div>
                        </div>

                        {{-- Name --}}
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="esd-filter-group">
                                <label class="esd-filter-label" for="esdName"><i class="uil uil-search"></i> Name</label>
                                <div class="input-group" style="flex-wrap:nowrap;">
                                    <span class="input-group-text" style="padding:0 10px;">
                                        <i class="uil uil-search" style="font-size:13px;color:#4b6cb7;"></i>
                                    </span>
                                    <input type="text" id="esdName" name="name" class="form-control"
                                        placeholder="Vehicle no. / driver / trip / customer"
                                        value="{{ request('name') }}">
                                </div>
                            </div>
                        </div>

                        {{-- RAG Status --}}
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="esd-filter-group">
                                <label class="esd-filter-label" for="esdRag"><i class="uil uil-traffic-light"></i> RAG Status</label>
                                <select id="esdRag" name="rag_status" class="form-select">
                                    <option value="">All RAG</option>
                                    <option value="Red">Red</option>
                                    <option value="Amber">Amber</option>
                                    <option value="Green">Green</option>
                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="row g-2 align-items-end">

                        {{-- Priority --}}
                        <div class="col-lg-3 col-md-6 col-12">
                            <div class="esd-filter-group">
                                <label class="esd-filter-label" for="esdPriority"><i class="uil uil-signal-alt-3"></i> Priority</label>
                                <select id="esdPriority" name="priority" class="form-select">
                                    <option value="">All Priority</option>
                                    <option value="High">High</option>
                                    <option value="Medium">Medium</option>
                                    <option value="Low">Low</option>
                                </select>
                            </div>
                        </div>

                        {{-- Allocated To --}}
                        <div class="col-lg-3 col-md-6 col-12">
                            <div class="esd-filter-group">
                                <label class="esd-filter-label" for="esdAllocated"><i class="uil uil-user-check"></i> Allocated To</label>
                                <select id="esdAllocated" name="allocated_to" class="form-select">
                                    <option value="">All Members</option>
                                    <option value="Ramesh Kumar">Ramesh Kumar</option>
                                    <option value="Priya Sharma">Priya Sharma</option>
                                    <option value="Anil Verma">Anil Verma</option>
                                    <option value="Sunita Nair">Sunita Nair</option>
                                    <option value="Mohit Bansal">Mohit Bansal</option>
                                    <option value="Unassigned">Unassigned</option>
                                </select>
                            </div>
                        </div>

                        {{-- Open or Closed --}}
                        <div class="col-lg-3 col-md-6 col-12">
                            <div class="esd-filter-group">
                                <label class="esd-filter-label" for="esdStatus"><i class="uil uil-check-square"></i> Open or Closed</label>
                                <select id="esdStatus" name="status" class="form-select">
                                    <option value="">Open &amp; Closed</option>
                                    <option value="Open">Open</option>
                                    <option value="Closed">Closed</option>
                                </select>
                            </div>
                        </div>

                        {{-- Reset --}}
                        <div class="col-lg-3 col-md-6 col-12 d-flex align-items-end">
                            <a href="{{ route('escalation.dashboard') }}" class="esd-reset-link">
                                <i class="uil uil-redo"></i> Reset Filters
                            </a>
                        </div>

                    </div>

                </form>
                </div>{{-- /esd-filter-body --}}
            </div>

            {{-- ══════════════════════════════════════════════════
                 SECTION 3 — Table List
            ══════════════════════════════════════════════════ --}}
            <div class="esd-table-card">

                <div class="esd-table-head">
                    <div>
                        <div class="esd-table-head-title">
                            <i class="uil uil-list-ul"></i> All Escalations
                        </div>
                        <div class="esd-table-head-sub">10 escalations &middot; 01 Jul 2026 &ndash; 08 Jul 2026</div>
                    </div>
                    <div class="esd-head-actions">
                        <button type="button" class="esd-btn-add" id="esdAddEscalation">
                            <i class="uil uil-plus"></i> Add Escalation
                        </button>
                    </div>
                </div>

                <div class="esd-table">
                    <table class="table mb-0" id="esdTable">
                        <thead>
                            <tr>
                                <th style="width:48px;">#</th>
                                <th>Escalation For</th>
                                <th class="esd-sortable" data-sort-key="name" data-sort-type="str">
                                    Name <i class="uil uil-sort esd-sort-icon"></i>
                                </th>
                                <th class="esd-sortable" data-sort-key="rag" data-sort-type="num" style="text-align:center;">
                                    RAG Status <i class="uil uil-sort esd-sort-icon"></i>
                                </th>
                                <th class="esd-sortable" data-sort-key="priority" data-sort-type="num" style="text-align:center;">
                                    Priority <i class="uil uil-sort esd-sort-icon"></i>
                                </th>
                                <th>Allocated To</th>
                                <th style="text-align:center;">Open or Closed</th>
                            </tr>
                        </thead>
                        <tbody id="esdTableBody">

                            {{-- Row 1 --}}
                            <tr data-name="MH12AB1234" data-rag="3" data-priority="3">
                                <td class="esd-sl">1</td>
                                <td><span class="esd-for esd-for-vehicle"><i class="uil uil-truck"></i> Vehicle</span></td>
                                <td>
                                    <div class="esd-name">MH12AB1234</div>
                                    <div class="esd-name-sub">Tata Signa 4923.T</div>
                                </td>
                                <td style="text-align:center;">
                                    <span class="esd-rag esd-rag-red"><span class="esd-rag-dot"></span> Red</span>
                                </td>
                                <td style="text-align:center;"><span class="esd-badge esd-badge-high">High</span></td>
                                <td>
                                    <div class="esd-alloc">
                                        <span class="esd-avatar">RK</span>
                                        <div>
                                            <div class="esd-alloc-name">Ramesh Kumar</div>
                                            <div class="esd-alloc-role">Fleet Supervisor</div>
                                        </div>
                                    </div>
                                </td>
                                <td style="text-align:center;"><span class="esd-badge esd-badge-openst">Open</span></td>
                            </tr>

                            {{-- Row 2 --}}
                            <tr data-name="Suresh Patil" data-rag="2" data-priority="2">
                                <td class="esd-sl">2</td>
                                <td><span class="esd-for esd-for-driver"><i class="uil uil-user"></i> Driver</span></td>
                                <td>
                                    <div class="esd-name">Suresh Patil</div>
                                    <div class="esd-name-sub">D004</div>
                                </td>
                                <td style="text-align:center;">
                                    <span class="esd-rag esd-rag-amber"><span class="esd-rag-dot"></span> Amber</span>
                                </td>
                                <td style="text-align:center;"><span class="esd-badge esd-badge-medium">Medium</span></td>
                                <td>
                                    <div class="esd-alloc">
                                        <span class="esd-avatar">PS</span>
                                        <div>
                                            <div class="esd-alloc-name">Priya Sharma</div>
                                            <div class="esd-alloc-role">HR Manager</div>
                                        </div>
                                    </div>
                                </td>
                                <td style="text-align:center;"><span class="esd-badge esd-badge-openst">Open</span></td>
                            </tr>

                            {{-- Row 3 --}}
                            <tr data-name="TRP-2026-0418" data-rag="3" data-priority="3">
                                <td class="esd-sl">3</td>
                                <td><span class="esd-for esd-for-trip"><i class="uil uil-map-marker"></i> Trip</span></td>
                                <td>
                                    <div class="esd-name">TRP-2026-0418</div>
                                    <div class="esd-name-sub">Pune &rarr; Indore</div>
                                </td>
                                <td style="text-align:center;">
                                    <span class="esd-rag esd-rag-red"><span class="esd-rag-dot"></span> Red</span>
                                </td>
                                <td style="text-align:center;"><span class="esd-badge esd-badge-high">High</span></td>
                                <td>
                                    <div class="esd-alloc">
                                        <span class="esd-avatar">AV</span>
                                        <div>
                                            <div class="esd-alloc-name">Anil Verma</div>
                                            <div class="esd-alloc-role">Operations Head</div>
                                        </div>
                                    </div>
                                </td>
                                <td style="text-align:center;"><span class="esd-badge esd-badge-openst">Open</span></td>
                            </tr>

                            {{-- Row 4 --}}
                            <tr data-name="Bharat Steel Traders" data-rag="1" data-priority="1">
                                <td class="esd-sl">4</td>
                                <td><span class="esd-for esd-for-customer"><i class="uil uil-building"></i> Customer</span></td>
                                <td>
                                    <div class="esd-name">Bharat Steel Traders</div>
                                    <div class="esd-name-sub">CUST-0112</div>
                                </td>
                                <td style="text-align:center;">
                                    <span class="esd-rag esd-rag-green"><span class="esd-rag-dot"></span> Green</span>
                                </td>
                                <td style="text-align:center;"><span class="esd-badge esd-badge-low">Low</span></td>
                                <td>
                                    <div class="esd-alloc">
                                        <span class="esd-avatar">SN</span>
                                        <div>
                                            <div class="esd-alloc-name">Sunita Nair</div>
                                            <div class="esd-alloc-role">Key Account Manager</div>
                                        </div>
                                    </div>
                                </td>
                                <td style="text-align:center;"><span class="esd-badge esd-badge-closed">Closed</span></td>
                            </tr>

                            {{-- Row 5 --}}
                            <tr data-name="Shakti Tyre Works" data-rag="2" data-priority="2">
                                <td class="esd-sl">5</td>
                                <td><span class="esd-for esd-for-vendor"><i class="uil uil-store"></i> Vendor</span></td>
                                <td>
                                    <div class="esd-name">Shakti Tyre Works</div>
                                    <div class="esd-name-sub">VEN-0037</div>
                                </td>
                                <td style="text-align:center;">
                                    <span class="esd-rag esd-rag-amber"><span class="esd-rag-dot"></span> Amber</span>
                                </td>
                                <td style="text-align:center;"><span class="esd-badge esd-badge-medium">Medium</span></td>
                                <td>
                                    <div class="esd-alloc">
                                        <span class="esd-avatar">MB</span>
                                        <div>
                                            <div class="esd-alloc-name">Mohit Bansal</div>
                                            <div class="esd-alloc-role">Procurement Lead</div>
                                        </div>
                                    </div>
                                </td>
                                <td style="text-align:center;"><span class="esd-badge esd-badge-openst">Open</span></td>
                            </tr>

                            {{-- Row 6 --}}
                            <tr data-name="GJ01CD5678" data-rag="1" data-priority="1">
                                <td class="esd-sl">6</td>
                                <td><span class="esd-for esd-for-vehicle"><i class="uil uil-truck"></i> Vehicle</span></td>
                                <td>
                                    <div class="esd-name">GJ01CD5678</div>
                                    <div class="esd-name-sub">Ashok Leyland 3520</div>
                                </td>
                                <td style="text-align:center;">
                                    <span class="esd-rag esd-rag-green"><span class="esd-rag-dot"></span> Green</span>
                                </td>
                                <td style="text-align:center;"><span class="esd-badge esd-badge-low">Low</span></td>
                                <td>
                                    <div class="esd-alloc">
                                        <span class="esd-avatar">RK</span>
                                        <div>
                                            <div class="esd-alloc-name">Ramesh Kumar</div>
                                            <div class="esd-alloc-role">Fleet Supervisor</div>
                                        </div>
                                    </div>
                                </td>
                                <td style="text-align:center;"><span class="esd-badge esd-badge-closed">Closed</span></td>
                            </tr>

                            {{-- Row 7 --}}
                            <tr data-name="TRP-2026-0392" data-rag="2" data-priority="3">
                                <td class="esd-sl">7</td>
                                <td><span class="esd-for esd-for-trip"><i class="uil uil-map-marker"></i> Trip</span></td>
                                <td>
                                    <div class="esd-name">TRP-2026-0392</div>
                                    <div class="esd-name-sub">Nagpur &rarr; Raipur</div>
                                </td>
                                <td style="text-align:center;">
                                    <span class="esd-rag esd-rag-amber"><span class="esd-rag-dot"></span> Amber</span>
                                </td>
                                <td style="text-align:center;"><span class="esd-badge esd-badge-high">High</span></td>
                                <td>
                                    <div class="esd-alloc">
                                        <span class="esd-avatar">AV</span>
                                        <div>
                                            <div class="esd-alloc-name">Anil Verma</div>
                                            <div class="esd-alloc-role">Operations Head</div>
                                        </div>
                                    </div>
                                </td>
                                <td style="text-align:center;"><span class="esd-badge esd-badge-openst">Open</span></td>
                            </tr>

                            {{-- Row 8 — unassigned --}}
                            <tr data-name="Dinesh Yadav" data-rag="3" data-priority="2">
                                <td class="esd-sl">8</td>
                                <td><span class="esd-for esd-for-driver"><i class="uil uil-user"></i> Driver</span></td>
                                <td>
                                    <div class="esd-name">Dinesh Yadav</div>
                                    <div class="esd-name-sub">D019</div>
                                </td>
                                <td style="text-align:center;">
                                    <span class="esd-rag esd-rag-red"><span class="esd-rag-dot"></span> Red</span>
                                </td>
                                <td style="text-align:center;"><span class="esd-badge esd-badge-medium">Medium</span></td>
                                <td><span class="esd-muted">&mdash; Unassigned</span></td>
                                <td style="text-align:center;"><span class="esd-badge esd-badge-openst">Open</span></td>
                            </tr>

                            {{-- Row 9 --}}
                            <tr data-name="Konark Cement Ltd." data-rag="1" data-priority="2">
                                <td class="esd-sl">9</td>
                                <td><span class="esd-for esd-for-customer"><i class="uil uil-building"></i> Customer</span></td>
                                <td>
                                    <div class="esd-name">Konark Cement Ltd.</div>
                                    <div class="esd-name-sub">CUST-0245</div>
                                </td>
                                <td style="text-align:center;">
                                    <span class="esd-rag esd-rag-green"><span class="esd-rag-dot"></span> Green</span>
                                </td>
                                <td style="text-align:center;"><span class="esd-badge esd-badge-medium">Medium</span></td>
                                <td>
                                    <div class="esd-alloc">
                                        <span class="esd-avatar">SN</span>
                                        <div>
                                            <div class="esd-alloc-name">Sunita Nair</div>
                                            <div class="esd-alloc-role">Key Account Manager</div>
                                        </div>
                                    </div>
                                </td>
                                <td style="text-align:center;"><span class="esd-badge esd-badge-closed">Closed</span></td>
                            </tr>

                            {{-- Row 10 --}}
                            <tr data-name="Apex Diesel Services" data-rag="1" data-priority="1">
                                <td class="esd-sl">10</td>
                                <td><span class="esd-for esd-for-vendor"><i class="uil uil-store"></i> Vendor</span></td>
                                <td>
                                    <div class="esd-name">Apex Diesel Services</div>
                                    <div class="esd-name-sub">VEN-0081</div>
                                </td>
                                <td style="text-align:center;">
                                    <span class="esd-rag esd-rag-green"><span class="esd-rag-dot"></span> Green</span>
                                </td>
                                <td style="text-align:center;"><span class="esd-badge esd-badge-low">Low</span></td>
                                <td>
                                    <div class="esd-alloc">
                                        <span class="esd-avatar">MB</span>
                                        <div>
                                            <div class="esd-alloc-name">Mohit Bansal</div>
                                            <div class="esd-alloc-role">Procurement Lead</div>
                                        </div>
                                    </div>
                                </td>
                                <td style="text-align:center;"><span class="esd-badge esd-badge-closed">Closed</span></td>
                            </tr>

                        </tbody>
                    </table>
                </div>

                <div class="esd-table-foot">
                    <div>Showing <b>10</b> of <b>142</b> escalations</div>
                    <div>Open <b>6</b> &middot; Closed <b>4</b> &middot; Red <b>3</b> &middot; Amber <b>3</b> &middot; Green <b>4</b></div>
                </div>

            </div>
            {{-- /table card --}}

        </div>{{-- /sc-no-sidebar --}}
    </div>{{-- /wrapper --}}
</div>{{-- /layout-wrapper --}}
@endsection

@section('js')
<script src="{{ asset('js/Escalation/escalation-dashboard.js?v=1.0') }}"></script>
@endsection
