@extends('layouts.app')

@section('css')
<link href="{{ asset('css/VehicleDocument/vehicle-document-dashboard.css?v=1.1') }}" rel="stylesheet">
@endsection

@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="wrapper srlog-bdwrapper">
        <div class="main-wrap vdd-no-sidebar">

            {{-- Breadcrumb --}}
            <nav aria-label="breadcrumb" class="mb-2">
                <ol class="breadcrumb vdd-breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('fleetdashboard.index') }}">Fleet</a></li>
                    <li class="breadcrumb-item active">All Vehicle Document Dashboard</li>
                </ol>
            </nav>

            {{-- Page Header --}}
            <div class="vdd-page-head d-flex align-items-center justify-content-between mb-3">
                <div>
                    <h5 class="mb-0">All Vehicle Document Dashboard</h5>
                    <span class="text-muted" style="font-size:12px;">
                        Insurance · Fitness · Permit · Tax · VLTD · PUCC — expiry tracking across the fleet
                    </span>
                </div>
                <div class="vdd-head-badge">
                    <i class="uil uil-calendar-alt"></i> As on 08 Jul 2026
                </div>
            </div>

            {{-- ══════════════════════════════════════════════════
                 SECTION 1 — Mini Dashboard
            ══════════════════════════════════════════════════ --}}
            <div class="vdd-kpi-row">

                <div class="vdd-kpi-card card-today">
                    <div class="vdd-kpi-label"><i class="uil uil-exclamation-octagon"></i> Expiry Today</div>
                    <div class="vdd-kpi-num">10</div>
                    <div class="vdd-kpi-divider"></div>
                    <div class="vdd-kpi-sub">Vehicle</div>
                </div>

                <div class="vdd-kpi-card card-day1">
                    <div class="vdd-kpi-label"><i class="uil uil-clock-three"></i> Expiry in 1 Days</div>
                    <div class="vdd-kpi-num">5</div>
                    <div class="vdd-kpi-divider"></div>
                    <div class="vdd-kpi-sub">Vehicle</div>
                </div>

                <div class="vdd-kpi-card card-day2">
                    <div class="vdd-kpi-label"><i class="uil uil-history"></i> Expiry in 2 Days</div>
                    <div class="vdd-kpi-num">5</div>
                    <div class="vdd-kpi-divider"></div>
                    <div class="vdd-kpi-sub">Vehicle</div>
                </div>

            </div>

            {{-- ══════════════════════════════════════════════════
                 SECTION 2 — Filter Card
            ══════════════════════════════════════════════════ --}}
            <div class="vdd-filter-card">
                <div class="vdd-filter-header">
                    <div class="vdd-filter-title">
                        <i class="uil uil-filter"></i> Filters
                    </div>
                </div>
                <div class="vdd-filter-body">
                    <form id="vddFilterForm" method="GET" action="{{ route('vehicledocument.dashboard') }}">
                        <div class="row g-2 align-items-end">

                            {{-- Vehicle Number --}}
                            <div class="col-lg-3 col-md-6 col-12">
                                <div class="vdd-filter-group">
                                    <label class="vdd-filter-label" for="vddVehicleNumber">
                                        <i class="uil uil-truck"></i> Vehicle Number
                                    </label>
                                    <div class="input-group" style="flex-wrap:nowrap;">
                                        <span class="input-group-text">
                                            <i class="uil uil-search vdd-filter-icon"></i>
                                        </span>
                                        <input type="text" id="vddVehicleNumber" name="vehicle_number"
                                            class="form-control" placeholder="e.g. OD02AB1234"
                                            value="{{ request('vehicle_number') }}">
                                    </div>
                                </div>
                            </div>

                            {{-- Owner Name --}}
                            <div class="col-lg-3 col-md-6 col-12">
                                <div class="vdd-filter-group">
                                    <label class="vdd-filter-label" for="vddOwnerName">
                                        <i class="uil uil-user"></i> Owner Name
                                    </label>
                                    <div class="input-group" style="flex-wrap:nowrap;">
                                        <span class="input-group-text">
                                            <i class="uil uil-search vdd-filter-icon"></i>
                                        </span>
                                        <input type="text" id="vddOwnerName" name="owner_name"
                                            class="form-control" placeholder="Enter owner name"
                                            value="{{ request('owner_name') }}">
                                    </div>
                                </div>
                            </div>

                            {{-- Tracking Group --}}
                            <div class="col-lg-2 col-md-6 col-12">
                                <div class="vdd-filter-group">
                                    <label class="vdd-filter-label" for="vddTrackingGroup">
                                        <i class="uil uil-layer-group"></i> Tracking Group
                                    </label>
                                    <select id="vddTrackingGroup" name="tracking_group" class="form-select">
                                        <option value="">All Groups</option>
                                        <option value="North Zone" {{ request('tracking_group')=='North Zone' ? 'selected':'' }}>North Zone</option>
                                        <option value="South Zone" {{ request('tracking_group')=='South Zone' ? 'selected':'' }}>South Zone</option>
                                        <option value="East Zone"  {{ request('tracking_group')=='East Zone'  ? 'selected':'' }}>East Zone</option>
                                        <option value="West Zone"  {{ request('tracking_group')=='West Zone'  ? 'selected':'' }}>West Zone</option>
                                    </select>
                                </div>
                            </div>

                            {{-- Document Type --}}
                            <div class="col-lg-2 col-md-6 col-12">
                                <div class="vdd-filter-group">
                                    <label class="vdd-filter-label" for="vddDocumentType">
                                        <i class="uil uil-file-alt"></i> Document Type
                                    </label>
                                    <select id="vddDocumentType" name="document_type" class="form-select">
                                        <option value="">All Documents</option>
                                        <option value="Insurance"     {{ request('document_type')=='Insurance'     ? 'selected':'' }}>Insurance</option>
                                        <option value="Fitness"       {{ request('document_type')=='Fitness'       ? 'selected':'' }}>Fitness</option>
                                        <option value="1 Year Permit" {{ request('document_type')=='1 Year Permit' ? 'selected':'' }}>1 Year Permit</option>
                                        <option value="5 Year Permit" {{ request('document_type')=='5 Year Permit' ? 'selected':'' }}>5 Year Permit</option>
                                        <option value="Tax"           {{ request('document_type')=='Tax'           ? 'selected':'' }}>Tax</option>
                                        <option value="VLTD"          {{ request('document_type')=='VLTD'          ? 'selected':'' }}>VLTD</option>
                                        <option value="PUCC"          {{ request('document_type')=='PUCC'          ? 'selected':'' }}>PUCC</option>
                                    </select>
                                </div>
                            </div>

                            {{-- Reset --}}
                            <div class="col-lg-2 col-md-6 col-12 d-flex align-items-end">
                                <a href="{{ route('vehicledocument.dashboard') }}" class="vdd-reset-link">
                                    <i class="uil uil-redo"></i> Reset Filters
                                </a>
                            </div>

                        </div>
                    </form>
                </div>{{-- /vdd-filter-body --}}
            </div>

            {{-- ══════════════════════════════════════════════════
                 SECTION 3 — Table List
            ══════════════════════════════════════════════════ --}}
            @php
                // Static demo data — no dynamic source yet.
                $vddRows = [
                    ['OD02AB1234', 'Sanjay Rout',      'East Zone',  'Insurance',     '09-07-2025', '08-07-2026', 0],
                    ['OD05CD4501', 'Manoj Behera',     'East Zone',  'Fitness',       '08-07-2024', '08-07-2026', 0],
                    ['WB23EF7788', 'Rakesh Ghosh',     'East Zone',  '1 Year Permit', '08-07-2025', '08-07-2026', 0],
                    ['MH12GH0099', 'Prakash Jadhav',   'West Zone',  'Tax',           '08-07-2025', '08-07-2026', 0],
                    ['JH10IJ3321', 'Vikas Mahato',     'North Zone', 'PUCC',          '08-01-2026', '08-07-2026', 0],
                    ['OD07KL9010', 'Bijay Sahoo',      'East Zone',  'VLTD',          '08-07-2021', '08-07-2026', 0],
                    ['CG04MN5566', 'Ramesh Sahu',      'North Zone', 'Insurance',     '09-07-2025', '08-07-2026', 0],
                    ['AP16OP2244', 'Srinivas Reddy',   'South Zone', '5 Year Permit', '08-07-2021', '08-07-2026', 0],
                    ['KA51QR8833', 'Naveen Gowda',     'South Zone', 'Fitness',       '08-07-2024', '08-07-2026', 0],
                    ['GJ01ST6677', 'Hitesh Patel',     'West Zone',  'Tax',           '08-07-2025', '08-07-2026', 0],

                    ['OD33UV1122', 'Sanjay Rout',      'East Zone',  'Insurance',     '10-07-2025', '09-07-2026', 1],
                    ['MH14WX4455', 'Prakash Jadhav',   'West Zone',  '1 Year Permit', '09-07-2025', '09-07-2026', 1],
                    ['JH05YZ7799', 'Vikas Mahato',     'North Zone', 'VLTD',          '09-07-2021', '09-07-2026', 1],
                    ['TN09AB3366', 'Karthik Rajan',    'South Zone', 'PUCC',          '09-01-2026', '09-07-2026', 1],
                    ['RJ14CD5599', 'Mahendra Singh',   'North Zone', 'Fitness',       '09-07-2024', '09-07-2026', 1],

                    ['OD09EF2200', 'Bijay Sahoo',      'East Zone',  'Tax',           '10-07-2025', '10-07-2026', 2],
                    ['WB19GH8811', 'Rakesh Ghosh',     'East Zone',  'Insurance',     '11-07-2025', '10-07-2026', 2],
                    ['MH04IJ7744', 'Hitesh Patel',     'West Zone',  '5 Year Permit', '10-07-2021', '10-07-2026', 2],
                    ['KL07KL1199', 'Anoop Menon',      'South Zone', 'Fitness',       '10-07-2024', '10-07-2026', 2],
                    ['UP32MN6600', 'Devendra Yadav',   'North Zone', '1 Year Permit', '10-07-2025', '10-07-2026', 2],
                ];

                $vddDocClass = [
                    'Insurance'     => 'vdd-doc-insurance',
                    'Fitness'       => 'vdd-doc-fitness',
                    '1 Year Permit' => 'vdd-doc-permit1',
                    '5 Year Permit' => 'vdd-doc-permit5',
                    'Tax'           => 'vdd-doc-tax',
                    'VLTD'          => 'vdd-doc-vltd',
                    'PUCC'          => 'vdd-doc-pucc',
                ];
            @endphp

            <div class="vdd-table-card">

                <div class="vdd-table-head">
                    <div>
                        <div class="vdd-table-head-title">
                            <i class="uil uil-list-ul"></i> All Vehicle Documents
                        </div>
                        <div class="vdd-table-head-sub">
                            {{ count($vddRows) }} documents expiring within the next 2 days
                        </div>
                    </div>
                </div>

                <div class="vdd-table table-responsive">
                    <table class="table mb-0" id="vddTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Vehicle Number</th>
                                <th>Owner Name</th>
                                <th>Tracking Group</th>
                                <th>Document Type</th>
                                <th>Start Date</th>
                                <th>Expiry Date</th>
                                <th>Expires in</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($vddRows as $i => $row)
                            <tr>
                                <td class="vdd-sl">{{ $i + 1 }}</td>
                                <td><span class="vdd-reg">{{ $row[0] }}</span></td>
                                <td><span class="vdd-owner">{{ $row[1] }}</span></td>
                                <td><span class="vdd-group-badge">{{ $row[2] }}</span></td>
                                <td>
                                    <span class="vdd-doc {{ $vddDocClass[$row[3]] ?? '' }}">{{ $row[3] }}</span>
                                </td>
                                <td class="vdd-date">{{ $row[4] }}</td>
                                <td class="vdd-date">{{ $row[5] }}</td>
                                <td>
                                    @if($row[6] === 0)
                                        <span class="vdd-exp vdd-exp-today">Today</span>
                                    @elseif($row[6] === 1)
                                        <span class="vdd-exp vdd-exp-urgent">1 Day</span>
                                    @elseif($row[6] <= 7)
                                        <span class="vdd-exp vdd-exp-soon">{{ $row[6] }} Days</span>
                                    @else
                                        <span class="vdd-exp vdd-exp-ok">{{ $row[6] }} Days</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8">
                                    <div class="vdd-empty-state">
                                        <i class="uil uil-file-search-alt"></i>
                                        <p>No vehicle documents match the current filters.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="vdd-table-foot">
                    Showing {{ count($vddRows) }} of {{ count($vddRows) }} documents
                </div>

            </div>

        </div>{{-- /main-wrap --}}
    </div>{{-- /wrapper --}}
</div>{{-- /layout-wrapper --}}
@endsection

@section('js')
<script src="{{ asset('js/VehicleDocument/vehicle-document-dashboard.js?v=1.0') }}"></script>
@endsection
