@extends('layouts.app')

@section('css')
<link href="{{ asset('css/Home/dashboard.css?v=1.3') }}" rel="stylesheet">
@endsection

@section('content')

@php
    /* Static design — links are resolved defensively so a missing route never breaks the page. */
    $hrefOr = function ($name, $params = []) {
        return \Illuminate\Support\Facades\Route::has($name) ? route($name, $params) : '#';
    };

    $rVehicles   = $hrefOr('vehiclemanagement.index');
    $rVehicleNew = $hrefOr('vehiclemanagement.create');
    $rTrips      = $hrefOr('trip.index');
    $rTripNew    = $hrefOr('trip.create');
    $rDrivers    = \Illuminate\Support\Facades\Route::has('driver.index')
                        ? route('driver.index')
                        : $hrefOr('fleetdashboard.drivers');
    $rDriverNew  = $hrefOr('driver.create');
    $rLrNew      = $hrefOr('trip.lr.create');
    $rTyre       = $hrefOr('tyre.dashboard');
    $rService    = $hrefOr('service-request.index');
    $rWorkshop   = $hrefOr('workshop.tech-dashboard');
    $rWarehouse  = $hrefOr('warehouse.master.index');
    $rFleetDash  = $hrefOr('fleetdashboard.index');
    $rDriverDash = $hrefOr('fleetdashboard.drivers');
    $rDocExpiry  = $hrefOr('fleet.compliance.document-expiry');
    $rClaims     = $hrefOr('fleet.insurance.index');
@endphp

<div class="layout-wrapper">

    @include('includes.header')

    <div class="wrapper srlog-bdwrapper">

        {{-- ===================== WELCOME BANNER ===================== --}}
        <div class="bg-dashboard">
            <div class="container">
                <div class="welcome-banner text-center">
                    @php
                        $now  = \Carbon\Carbon::now('Asia/Kolkata');
                        $hour = $now->format('H');
                        if ($hour < 12)      { $greeting = "Good Morning"; }
                        elseif ($hour < 17)  { $greeting = "Good Afternoon"; }
                        elseif ($hour < 21)  { $greeting = "Good Evening"; }
                        else                 { $greeting = "Good Night"; }
                    @endphp

                    <p>{{ $now->format('l, F j') }}</p>
                    <h4>{{ $greeting }}, {{ auth()->check() ? auth()->user()->name : '' }}</h4>

                    <div class="welcome-filter mt-4">
                        <div class="row">
                            <div class="col-12 col-md-4">
                                <select class="selectpicker borderless-select">
                                    <option>My Week</option>
                                    <option>My Month</option>
                                    <option>2 Months ago</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="mid-sec">
                                    <span class="me-1"><i class="uil uil-truck"></i></span>
                                    <span class="me-1">34</span>
                                    <span class="text">Active Trips</span>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="mid-sec">
                                    <span class="me-1"><i class="uil uil-user"></i></span>
                                    <span class="me-1">27</span>
                                    <span class="text">Drivers On Duty</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===================== DASHBOARD BODY ===================== --}}
        <div class="container-fluid dash-wrap">

            {{-- ---------- KPI STAT CARDS ---------- --}}
            <div class="row g-2">
                <div class="col-6 col-md-4 col-xl-2">
                    <a href="{{ $rVehicles }}" class="dash-kpi">
                        <span class="dash-kpi-icon dash-ic-navy"><i class="uil uil-truck"></i></span>
                        <div class="dash-kpi-body">
                            <div class="dash-kpi-value">128 <span class="dash-kpi-trend dash-trend-up">+4</span></div>
                            <p class="dash-kpi-label">Total Vehicles</p>
                        </div>
                    </a>
                </div>
                <div class="col-6 col-md-4 col-xl-2">
                    <a href="{{ $rTrips }}" class="dash-kpi">
                        <span class="dash-kpi-icon dash-ic-teal"><i class="uil uil-map-marker"></i></span>
                        <div class="dash-kpi-body">
                            <div class="dash-kpi-value">34 <span class="dash-kpi-trend dash-trend-up">+6</span></div>
                            <p class="dash-kpi-label">Active Trips</p>
                        </div>
                    </a>
                </div>
                <div class="col-6 col-md-4 col-xl-2">
                    <a href="{{ $rDrivers }}" class="dash-kpi">
                        <span class="dash-kpi-icon dash-ic-blue"><i class="uil uil-user"></i></span>
                        <div class="dash-kpi-body">
                            <div class="dash-kpi-value">27 <span class="dash-kpi-trend dash-trend-flat">0</span></div>
                            <p class="dash-kpi-label">Available Drivers</p>
                        </div>
                    </a>
                </div>
                <div class="col-6 col-md-4 col-xl-2">
                    <a href="{{ $rWorkshop }}" class="dash-kpi">
                        <span class="dash-kpi-icon dash-ic-amber"><i class="uil uil-wrench"></i></span>
                        <div class="dash-kpi-body">
                            <div class="dash-kpi-value">9 <span class="dash-kpi-trend dash-trend-down">-2</span></div>
                            <p class="dash-kpi-label">In Workshop</p>
                        </div>
                    </a>
                </div>
                <div class="col-6 col-md-4 col-xl-2">
                    <a href="{{ $rDocExpiry }}" class="dash-kpi">
                        <span class="dash-kpi-icon dash-ic-red"><i class="uil uil-file-exclamation-alt"></i></span>
                        <div class="dash-kpi-body">
                            <div class="dash-kpi-value">12 <span class="dash-kpi-trend dash-trend-down">!</span></div>
                            <p class="dash-kpi-label">Docs Expiring (30d)</p>
                        </div>
                    </a>
                </div>
                <div class="col-6 col-md-4 col-xl-2">
                    <a href="{{ $rClaims }}" class="dash-kpi">
                        <span class="dash-kpi-icon dash-ic-green"><i class="uil uil-shield-check"></i></span>
                        <div class="dash-kpi-body">
                            <div class="dash-kpi-value">4 <span class="dash-kpi-trend dash-trend-flat">0</span></div>
                            <p class="dash-kpi-label">Open Claims</p>
                        </div>
                    </a>
                </div>
            </div>

            {{-- ---------- QUICK ACTIONS ---------- --}}
            <div class="dash-section-head">
                <h5>Quick Actions</h5>
            </div>
            <div class="dash-actions">
                <a href="{{ $rTripNew }}" class="dash-action">
                    <span class="dash-action-ic"><i class="uil uil-plus-circle"></i></span>
                    <span class="dash-action-txt">Create Trip</span>
                </a>
                <a href="{{ $rVehicleNew }}" class="dash-action">
                    <span class="dash-action-ic"><i class="uil uil-truck"></i></span>
                    <span class="dash-action-txt">Add Vehicle</span>
                </a>
                <a href="{{ $rDriverNew }}" class="dash-action">
                    <span class="dash-action-ic"><i class="uil uil-user-plus"></i></span>
                    <span class="dash-action-txt">Add Driver</span>
                </a>
                <a href="{{ $rLrNew }}" class="dash-action">
                    <span class="dash-action-ic"><i class="uil uil-file-alt"></i></span>
                    <span class="dash-action-txt">Create LR</span>
                </a>
                <a href="{{ $rTyre }}" class="dash-action">
                    <span class="dash-action-ic"><i class="uil uil-record-audio"></i></span>
                    <span class="dash-action-txt">Tyre Dashboard</span>
                </a>
                <a href="{{ $rService }}" class="dash-action">
                    <span class="dash-action-ic"><i class="uil uil-wrench"></i></span>
                    <span class="dash-action-txt">Service Request</span>
                </a>
            </div>

            {{-- ---------- MAIN GRID ---------- --}}
            <div class="row mt-2">

                {{-- LEFT COLUMN --}}
                <div class="col-12 col-xl-8">

                    {{-- Fleet status overview --}}
                    <div class="dash-section-head">
                        <h5>Fleet Status Overview</h5>
                        <a href="{{ $rVehicles }}" class="dash-link">View fleet</a>
                    </div>
                    <div class="dash-panel">
                        <div class="dash-fleet-row">
                            <div class="dash-donut">
                                <div class="dash-donut-hole">
                                    <span class="dash-donut-num">128</span>
                                    <span class="dash-donut-cap">Total Fleet</span>
                                </div>
                            </div>
                            <div class="dash-legend">
                                <div class="dash-legend-item">
                                    <span class="dash-legend-label"><span class="dash-dot dash-dot-navy"></span> On Trip</span>
                                    <span class="dash-legend-val">58</span>
                                </div>
                                <div class="dash-legend-item">
                                    <span class="dash-legend-label"><span class="dash-dot dash-dot-teal"></span> Idle / Available</span>
                                    <span class="dash-legend-val">41</span>
                                </div>
                                <div class="dash-legend-item">
                                    <span class="dash-legend-label"><span class="dash-dot dash-dot-amber"></span> Under Maintenance</span>
                                    <span class="dash-legend-val">18</span>
                                </div>
                                <div class="dash-legend-item">
                                    <span class="dash-legend-label"><span class="dash-dot dash-dot-red"></span> In Workshop</span>
                                    <span class="dash-legend-val">9</span>
                                </div>
                                <div class="dash-legend-item">
                                    <span class="dash-legend-label"><span class="dash-dot dash-dot-grey"></span> Inactive</span>
                                    <span class="dash-legend-val">2</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Active trips --}}
                    <div class="dash-section-head">
                        <h5>Active Trips</h5>
                        <a href="{{ $rTrips }}" class="dash-link">View all</a>
                    </div>
                    <div class="dash-panel">
                        <div class="table-responsive">
                            <table class="dash-table">
                                <thead>
                                    <tr>
                                        <th>Trip No.</th>
                                        <th>Route</th>
                                        <th>Vehicle</th>
                                        <th>Driver</th>
                                        <th>ETA</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="dash-td-strong">TRP-2041</td>
                                        <td>Kolkata &rarr; Ranchi</td>
                                        <td>WB 23 F 4512</td>
                                        <td>Suresh Yadav</td>
                                        <td>Today, 6:30 PM</td>
                                        <td><span class="dash-badge dash-badge-running">Running</span></td>
                                    </tr>
                                    <tr>
                                        <td class="dash-td-strong">TRP-2040</td>
                                        <td>Haldia &rarr; Patna</td>
                                        <td>WB 11 G 8830</td>
                                        <td>Imran Khan</td>
                                        <td>Tomorrow, 9:00 AM</td>
                                        <td><span class="dash-badge dash-badge-loading">Loading</span></td>
                                    </tr>
                                    <tr>
                                        <td class="dash-td-strong">TRP-2039</td>
                                        <td>Durgapur &rarr; Cuttack</td>
                                        <td>WB 39 C 1207</td>
                                        <td>Rakesh Singh</td>
                                        <td>Today, 11:45 PM</td>
                                        <td><span class="dash-badge dash-badge-delayed">Delayed</span></td>
                                    </tr>
                                    <tr>
                                        <td class="dash-td-strong">TRP-2038</td>
                                        <td>Asansol &rarr; Dhanbad</td>
                                        <td>WB 38 A 5566</td>
                                        <td>Mohan Das</td>
                                        <td>Today, 4:15 PM</td>
                                        <td><span class="dash-badge dash-badge-running">Running</span></td>
                                    </tr>
                                    <tr>
                                        <td class="dash-td-strong">TRP-2037</td>
                                        <td>Kharagpur &rarr; Bhubaneswar</td>
                                        <td>WB 33 B 9041</td>
                                        <td>Arjun Mahato</td>
                                        <td>Jun 11, 7:30 AM</td>
                                        <td><span class="dash-badge dash-badge-scheduled">Scheduled</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Document & compliance expiry --}}
                    <div class="dash-section-head">
                        <h5>Document &amp; Compliance Expiry</h5>
                        <a href="{{ $rDocExpiry }}" class="dash-link">View tracker</a>
                    </div>
                    <div class="dash-panel">
                        <div class="table-responsive">
                            <table class="dash-table">
                                <thead>
                                    <tr>
                                        <th>Vehicle</th>
                                        <th>Document</th>
                                        <th>Expiry Date</th>
                                        <th>Days Left</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="dash-td-strong">WB 23 F 4512</td>
                                        <td>Insurance Policy</td>
                                        <td>Jun 14, 2026</td>
                                        <td>5 days</td>
                                        <td><span class="dash-badge dash-badge-warn">Expiring</span></td>
                                    </tr>
                                    <tr>
                                        <td class="dash-td-strong">WB 11 G 8830</td>
                                        <td>Fitness Certificate</td>
                                        <td>Jun 02, 2026</td>
                                        <td>Expired</td>
                                        <td><span class="dash-badge dash-badge-expired">Expired</span></td>
                                    </tr>
                                    <tr>
                                        <td class="dash-td-strong">WB 39 C 1207</td>
                                        <td>National Permit</td>
                                        <td>Jun 28, 2026</td>
                                        <td>19 days</td>
                                        <td><span class="dash-badge dash-badge-warn">Expiring</span></td>
                                    </tr>
                                    <tr>
                                        <td class="dash-td-strong">WB 38 A 5566</td>
                                        <td>Pollution (PUC)</td>
                                        <td>Jul 09, 2026</td>
                                        <td>30 days</td>
                                        <td><span class="dash-badge dash-badge-ok">Valid</span></td>
                                    </tr>
                                    <tr>
                                        <td class="dash-td-strong">WB 33 B 9041</td>
                                        <td>Road Tax</td>
                                        <td>Jun 20, 2026</td>
                                        <td>11 days</td>
                                        <td><span class="dash-badge dash-badge-warn">Expiring</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

                {{-- RIGHT COLUMN --}}
                <div class="col-12 col-xl-4">

                    {{-- Module shortcuts --}}
                    <div class="dash-section-head">
                        <h5>Dashboards</h5>
                    </div>
                    <a href="{{ $rFleetDash }}" class="dash-shortcut dash-sc-1"><i class="uil uil-dashboard"></i> Vehicle Dashboard</a>
                    <a href="{{ $rTrips }}" class="dash-shortcut dash-sc-2"><i class="uil uil-map-marker"></i> Trips</a>
                    <a href="{{ $rTyre }}" class="dash-shortcut dash-sc-3"><i class="uil uil-record-audio"></i> Tyre Dashboard</a>
                    <a href="{{ $rDriverDash }}" class="dash-shortcut dash-sc-4"><i class="uil uil-user"></i> Driver Dashboard</a>
                    <a href="{{ $rWorkshop }}" class="dash-shortcut dash-sc-5"><i class="uil uil-wrench"></i> Workshop</a>
                    <a href="{{ $rWarehouse }}" class="dash-shortcut dash-sc-6"><i class="uil uil-archive"></i> Warehouse</a>

                    {{-- Tyre & battery health --}}
                    <div class="dash-section-head">
                        <h5>Tyre &amp; Battery Health</h5>
                    </div>
                    <div class="dash-panel">
                        <div class="dash-health-item">
                            <div class="dash-health-top">
                                <span class="dash-health-label">Tyres in good condition</span>
                                <span class="dash-health-val">82%</span>
                            </div>
                            <div class="dash-health-bar"><div class="dash-health-fill dash-fill-teal" style="width:82%;"></div></div>
                        </div>
                        <div class="dash-health-item">
                            <div class="dash-health-top">
                                <span class="dash-health-label">Tyres due for rotation</span>
                                <span class="dash-health-val">11%</span>
                            </div>
                            <div class="dash-health-bar"><div class="dash-health-fill dash-fill-amber" style="width:11%;"></div></div>
                        </div>
                        <div class="dash-health-item">
                            <div class="dash-health-top">
                                <span class="dash-health-label">Tyres flagged for replacement</span>
                                <span class="dash-health-val">7%</span>
                            </div>
                            <div class="dash-health-bar"><div class="dash-health-fill dash-fill-red" style="width:7%;"></div></div>
                        </div>
                        <div class="dash-health-item">
                            <div class="dash-health-top">
                                <span class="dash-health-label">Batteries healthy</span>
                                <span class="dash-health-val">90%</span>
                            </div>
                            <div class="dash-health-bar"><div class="dash-health-fill dash-fill-blue" style="width:90%;"></div></div>
                        </div>
                    </div>

                    {{-- Recent activity --}}
                    <div class="dash-section-head">
                        <h5>Recent Activity</h5>
                    </div>
                    <div class="dash-panel">
                        <div class="dash-feed">
                            <div class="dash-feed-item">
                                <div class="dash-feed-text"><b>Trip TRP-2041</b> started &mdash; Kolkata to Ranchi.</div>
                                <div class="dash-feed-time">12 minutes ago</div>
                            </div>
                            <div class="dash-feed-item dash-feed-teal">
                                <div class="dash-feed-text">Driver <b>Imran Khan</b> assigned to WB 11 G 8830.</div>
                                <div class="dash-feed-time">48 minutes ago</div>
                            </div>
                            <div class="dash-feed-item dash-feed-amber">
                                <div class="dash-feed-text">Fitness certificate for <b>WB 11 G 8830</b> has expired.</div>
                                <div class="dash-feed-time">2 hours ago</div>
                            </div>
                            <div class="dash-feed-item dash-feed-red">
                                <div class="dash-feed-text">Vehicle <b>WB 39 C 1207</b> reported a breakdown en route.</div>
                                <div class="dash-feed-time">3 hours ago</div>
                            </div>
                            <div class="dash-feed-item">
                                <div class="dash-feed-text">LR <b>LR-7789</b> generated for trip TRP-2038.</div>
                                <div class="dash-feed-time">5 hours ago</div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

</div>

@endsection

@section('js')
@endsection
