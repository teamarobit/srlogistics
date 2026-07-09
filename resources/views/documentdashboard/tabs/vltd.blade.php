{{-- Document Dashboard — VLTD Certificate tab (static; no dynamic data) --}}
@php
    // Static demo data — no dynamic source yet.
    // Each row: vehicle, owner, group, vltd_agent, rto_location, cost, start, expiry, days
    $vlRows = [
        ['OD02AB1234','Sanjay Rout','East Zone','GPS Track Solutions','Bhubaneswar RTO','5500','09-07-2025','09-07-2026',0],
        ['OD05CD4501','Manoj Behera','East Zone','Metro VLTD','Cuttack RTO','5200','09-07-2025','09-07-2026',0],
        ['WB23EF7788','Rakesh Ghosh','East Zone','SecureFleet','Kolkata RTO','5800','09-07-2025','09-07-2026',0],
        ['MH12GH0099','Prakash Jadhav','West Zone','QuickTrack','Pune RTO','5400','09-07-2025','09-07-2026',0],
        ['JH10IJ3321','Vikas Mahato','North Zone','GPS Track Solutions','Ranchi RTO','5100','09-07-2025','09-07-2026',0],
        ['OD07KL9010','Bijay Sahoo','East Zone','Metro VLTD','Bhubaneswar RTO','5600','09-07-2025','09-07-2026',0],
        ['CG04MN5566','Ramesh Sahu','North Zone','SecureFleet','Raipur RTO','5250','09-07-2025','09-07-2026',0],
        ['AP16OP2244','Srinivas Reddy','South Zone','QuickTrack','Vijayawada RTO','5900','09-07-2025','09-07-2026',0],
        ['KA51QR8833','Naveen Gowda','South Zone','GPS Track Solutions','Bangalore RTO','5350','09-07-2025','09-07-2026',0],
        ['GJ01ST6677','Hitesh Patel','West Zone','Metro VLTD','Ahmedabad RTO','5550','09-07-2025','09-07-2026',0],

        ['OD33UV1122','Sanjay Rout','East Zone','SecureFleet','Bhubaneswar RTO','5300','10-07-2025','10-07-2026',1],
        ['MH14WX4455','Prakash Jadhav','West Zone','QuickTrack','Nashik RTO','5450','10-07-2025','10-07-2026',1],
        ['JH05YZ7799','Vikas Mahato','North Zone','GPS Track Solutions','Ranchi RTO','5150','10-07-2025','10-07-2026',1],
        ['TN09AB3366','Karthik Rajan','South Zone','Metro VLTD','Chennai RTO','5750','10-07-2025','10-07-2026',1],
        ['RJ14CD5599','Mahendra Singh','North Zone','SecureFleet','Jaipur RTO','5350','10-07-2025','10-07-2026',1],

        ['OD09EF2200','Bijay Sahoo','East Zone','QuickTrack','Cuttack RTO','5650','11-07-2025','11-07-2026',2],
        ['WB19GH8811','Rakesh Ghosh','East Zone','GPS Track Solutions','Kolkata RTO','5200','11-07-2025','11-07-2026',2],
        ['MH04IJ7744','Hitesh Patel','West Zone','Metro VLTD','Pune RTO','5850','11-07-2025','11-07-2026',2],
        ['KL07KL1199','Anoop Menon','South Zone','SecureFleet','Bangalore RTO','5300','11-07-2025','11-07-2026',2],
        ['UP32MN6600','Devendra Yadav','North Zone','QuickTrack','Lucknow RTO','5500','11-07-2025','11-07-2026',2],
    ];

    // Sort by expiry soonest first (ascending days) — default sort.
    $vlRows = collect($vlRows)->sortBy(8)->values()->all();

    $vlToday = collect($vlRows)->where(8, 0)->count();
    $vlDay1  = collect($vlRows)->where(8, 1)->count();
    $vlDay2  = collect($vlRows)->where(8, 2)->count();

    $vlAgents = collect($vlRows)->pluck(3)->unique()->sort()->values();
@endphp

<div class="docd-tab-body">

    {{-- ── Mini Dashboard ─────────────────────────────────────── --}}
    <div class="docd-kpi-row docd-kpi-row-3">
        <div class="docd-kpi-card kpi-red">
            <div class="docd-kpi-label"><i class="uil uil-exclamation-octagon"></i> Expiry Today</div>
            <div class="docd-kpi-num">{{ $vlToday }}</div>
            <div class="docd-kpi-divider"></div>
            <div class="docd-kpi-sub">Vehicle</div>
        </div>
        <div class="docd-kpi-card kpi-orange">
            <div class="docd-kpi-label"><i class="uil uil-clock-three"></i> Expiry in 1 Days</div>
            <div class="docd-kpi-num">{{ $vlDay1 }}</div>
            <div class="docd-kpi-divider"></div>
            <div class="docd-kpi-sub">Vehicle</div>
        </div>
        <div class="docd-kpi-card kpi-amber">
            <div class="docd-kpi-label"><i class="uil uil-history"></i> Expiry in 2 Days</div>
            <div class="docd-kpi-num">{{ $vlDay2 }}</div>
            <div class="docd-kpi-divider"></div>
            <div class="docd-kpi-sub">Vehicle</div>
        </div>
    </div>

    {{-- ── Filter Bar ─────────────────────────────────────────── --}}
    <div class="docd-filter-card">
        <div class="docd-filter-header">
            <div class="docd-filter-title"><i class="uil uil-filter"></i> Filters</div>
        </div>
        <div class="docd-filter-body">
            <form id="docdVlFilterForm" onsubmit="return false;">
                <div class="row g-2 align-items-end">

                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="docd-filter-group">
                            <label class="docd-filter-label" for="docdVlVehicle"><i class="uil uil-truck"></i> Vehicle Number</label>
                            <div class="input-group" style="flex-wrap:nowrap;">
                                <span class="input-group-text"><i class="uil uil-search docd-filter-icon"></i></span>
                                <input type="text" id="docdVlVehicle" name="vehicle_number" class="form-control" placeholder="e.g. OD02AB1234">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="docd-filter-group">
                            <label class="docd-filter-label" for="docdVlOwner"><i class="uil uil-user"></i> Owner Name</label>
                            <div class="input-group" style="flex-wrap:nowrap;">
                                <span class="input-group-text"><i class="uil uil-search docd-filter-icon"></i></span>
                                <input type="text" id="docdVlOwner" name="owner_name" class="form-control" placeholder="Enter owner name">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="docd-filter-group">
                            <label class="docd-filter-label" for="docdVlGroup"><i class="uil uil-layer-group"></i> Tracking Group</label>
                            <select id="docdVlGroup" name="tracking_group" class="form-select">
                                <option value="">All Groups</option>
                                <option value="North Zone">North Zone</option>
                                <option value="South Zone">South Zone</option>
                                <option value="East Zone">East Zone</option>
                                <option value="West Zone">West Zone</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="docd-filter-group">
                            <label class="docd-filter-label" for="docdVlAgent"><i class="uil uil-user-check"></i> VLTD Agent</label>
                            <select id="docdVlAgent" name="vltd_agent" class="form-select">
                                <option value="">All Agents</option>
                                @foreach($vlAgents as $agent)
                                <option value="{{ $agent }}">{{ $agent }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-12 d-flex justify-content-end">
                        <a href="{{ route('documentdashboard.dashboard') }}" class="docd-reset-link">
                            <i class="uil uil-redo"></i> Reset Filters
                        </a>
                    </div>

                </div>
            </form>
        </div>
    </div>

    {{-- ── Table List ─────────────────────────────────────────── --}}
    <div class="docd-table-card">
        <div class="docd-table-head">
            <div>
                <div class="docd-table-head-title"><i class="uil uil-list-ul"></i> VLTD Certificate</div>
                <div class="docd-table-head-sub">{{ count($vlRows) }} vehicles · sorted by expiry (soonest first)</div>
            </div>
            <div class="docd-sort">
                <label for="docdVlSort">Sort by</label>
                <select id="docdVlSort" class="form-select">
                    <option value="expiry_asc" selected>Expiry · Soonest first</option>
                    <option value="expiry_desc">Expiry · Latest first</option>
                </select>
            </div>
        </div>

        <div class="docd-table table-responsive">
            <table class="table mb-0" id="docdVlTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Vehicle Number</th>
                        <th>Owner Name</th>
                        <th>Tracking Group</th>
                        <th>VLTD Agent</th>
                        <th>RTO Location</th>
                        <th>VLTD Cost</th>
                        <th>Start Date</th>
                        <th>Expiry Date</th>
                        <th>Expires In</th>
                        <th>Attachment</th>
                        <th>View Details</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($vlRows as $i => $r)
                    <tr>
                        <td class="docd-sl">{{ $i + 1 }}</td>
                        <td><span class="docd-reg">{{ $r[0] }}</span></td>
                        <td><span class="docd-owner">{{ $r[1] }}</span></td>
                        <td><span class="docd-group-badge">{{ $r[2] }}</span></td>
                        <td>{{ $r[3] }}</td>
                        <td class="docd-loc">{{ $r[4] }}</td>
                        <td class="docd-money">
                            &#8377;{{ number_format($r[5]) }}<br>
                            <a href="javascript:void(0)" class="docd-breakup-link"><i class="uil uil-receipt-alt"></i> View breakup</a>
                        </td>
                        <td class="docd-date">{{ $r[6] }}</td>
                        <td class="docd-date">{{ $r[7] }}</td>
                        <td>
                            @if($r[8] === 0)
                                <span class="docd-exp docd-exp-today">Today</span>
                            @elseif($r[8] === 1)
                                <span class="docd-exp docd-exp-urgent">1 Day</span>
                            @elseif($r[8] <= 7)
                                <span class="docd-exp docd-exp-soon">{{ $r[8] }} Days</span>
                            @else
                                <span class="docd-exp docd-exp-ok">{{ $r[8] }} Days</span>
                            @endif
                        </td>
                        <td>
                            <a href="javascript:void(0)" class="docd-attach docd-attach-view"><i class="uil uil-file-check-alt"></i> View</a>
                        </td>
                        <td>
                            <a href="javascript:void(0)" class="docd-view-details" data-bs-toggle="modal" data-bs-target="#docdVlDtl{{ $i }}"><i class="uil uil-eye"></i> View Details</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="12">
                            <div class="docd-empty-state">
                                <i class="uil uil-file-search-alt"></i>
                                <p>No records match the current filters.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="docd-table-foot">Showing {{ count($vlRows) }} of {{ count($vlRows) }} vehicles</div>
    </div>

    {{-- View Details modals (document history) --}}
    @foreach($vlRows as $i => $r)
        @include('documentdashboard.tabs._details-modal', [
            'modalId'  => 'docdVlDtl' . $i,
            'docLabel' => 'VLTD Certificate',
            'vehicle'  => $r[0],
            'owner'    => $r[1],
            'agent'    => $r[3],
            'curStart' => $r[6],
            'curEnd'   => $r[7],
        ])
    @endforeach

</div>
