{{-- Document Dashboard — 5 Year Permit tab (static; no dynamic data) --}}
@php
    // Static demo data — no dynamic source yet.
    // Each row: vehicle, owner, group, rto_agent, rto_location, cost, start, expiry, days
    $p5Rows = [
        ['OD02AB1234','Sanjay Rout','East Zone','Ramesh Traders','Bhubaneswar RTO','42500','09-07-2021','09-07-2026',0],
        ['OD05CD4501','Manoj Behera','East Zone','Sundar Agency','Cuttack RTO','39800','09-07-2021','09-07-2026',0],
        ['WB23EF7788','Rakesh Ghosh','East Zone','Metro RTO Services','Kolkata RTO','45200','09-07-2021','09-07-2026',0],
        ['MH12GH0099','Prakash Jadhav','West Zone','QuickRTO','Pune RTO','41100','09-07-2021','09-07-2026',0],
        ['JH10IJ3321','Vikas Mahato','North Zone','Ramesh Traders','Ranchi RTO','38500','09-07-2021','09-07-2026',0],
        ['OD07KL9010','Bijay Sahoo','East Zone','Sundar Agency','Bhubaneswar RTO','43800','09-07-2021','09-07-2026',0],
        ['CG04MN5566','Ramesh Sahu','North Zone','Metro RTO Services','Raipur RTO','39900','09-07-2021','09-07-2026',0],
        ['AP16OP2244','Srinivas Reddy','South Zone','QuickRTO','Vijayawada RTO','46600','09-07-2021','09-07-2026',0],
        ['KA51QR8833','Naveen Gowda','South Zone','Ramesh Traders','Bangalore RTO','41300','09-07-2021','09-07-2026',0],
        ['GJ01ST6677','Hitesh Patel','West Zone','Sundar Agency','Ahmedabad RTO','42600','09-07-2021','09-07-2026',0],

        ['OD33UV1122','Sanjay Rout','East Zone','Metro RTO Services','Bhubaneswar RTO','40000','10-07-2021','10-07-2026',1],
        ['MH14WX4455','Prakash Jadhav','West Zone','QuickRTO','Nashik RTO','41400','10-07-2021','10-07-2026',1],
        ['JH05YZ7799','Vikas Mahato','North Zone','Ramesh Traders','Ranchi RTO','38600','10-07-2021','10-07-2026',1],
        ['TN09AB3366','Karthik Rajan','South Zone','Sundar Agency','Chennai RTO','44100','10-07-2021','10-07-2026',1],
        ['RJ14CD5599','Mahendra Singh','North Zone','Metro RTO Services','Jaipur RTO','41200','10-07-2021','10-07-2026',1],

        ['OD09EF2200','Bijay Sahoo','East Zone','QuickRTO','Cuttack RTO','43700','11-07-2021','11-07-2026',2],
        ['WB19GH8811','Rakesh Ghosh','East Zone','Ramesh Traders','Kolkata RTO','38700','11-07-2021','11-07-2026',2],
        ['MH04IJ7744','Hitesh Patel','West Zone','Sundar Agency','Pune RTO','45300','11-07-2021','11-07-2026',2],
        ['KL07KL1199','Anoop Menon','South Zone','Metro RTO Services','Bangalore RTO','40050','11-07-2021','11-07-2026',2],
        ['UP32MN6600','Devendra Yadav','North Zone','QuickRTO','Lucknow RTO','41450','11-07-2021','11-07-2026',2],
    ];

    // Sort by expiry soonest first (ascending days) — default sort.
    $p5Rows = collect($p5Rows)->sortBy(8)->values()->all();

    $p5Today = collect($p5Rows)->where(8, 0)->count();
    $p5Day1  = collect($p5Rows)->where(8, 1)->count();
    $p5Day2  = collect($p5Rows)->where(8, 2)->count();

    $p5Agents    = collect($p5Rows)->pluck(3)->unique()->sort()->values();
    $p5Locations = collect($p5Rows)->pluck(4)->unique()->sort()->values();
@endphp

<div class="docd-tab-body">

    {{-- ── Mini Dashboard ─────────────────────────────────────── --}}
    <div class="docd-kpi-row docd-kpi-row-3">
        <div class="docd-kpi-card kpi-red">
            <div class="docd-kpi-label"><i class="uil uil-exclamation-octagon"></i> Expiry Today</div>
            <div class="docd-kpi-num">{{ $p5Today }}</div>
            <div class="docd-kpi-divider"></div>
            <div class="docd-kpi-sub">Vehicle</div>
        </div>
        <div class="docd-kpi-card kpi-orange">
            <div class="docd-kpi-label"><i class="uil uil-clock-three"></i> Expiry in 1 Days</div>
            <div class="docd-kpi-num">{{ $p5Day1 }}</div>
            <div class="docd-kpi-divider"></div>
            <div class="docd-kpi-sub">Vehicle</div>
        </div>
        <div class="docd-kpi-card kpi-amber">
            <div class="docd-kpi-label"><i class="uil uil-history"></i> Expiry in 2 Days</div>
            <div class="docd-kpi-num">{{ $p5Day2 }}</div>
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
            <form id="docdP5FilterForm" onsubmit="return false;">
                <div class="row g-2 align-items-end">

                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="docd-filter-group">
                            <label class="docd-filter-label" for="docdP5Vehicle"><i class="uil uil-truck"></i> Vehicle Number</label>
                            <div class="input-group" style="flex-wrap:nowrap;">
                                <span class="input-group-text"><i class="uil uil-search docd-filter-icon"></i></span>
                                <input type="text" id="docdP5Vehicle" name="vehicle_number" class="form-control" placeholder="e.g. OD02AB1234">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="docd-filter-group">
                            <label class="docd-filter-label" for="docdP5Owner"><i class="uil uil-user"></i> Owner Name</label>
                            <div class="input-group" style="flex-wrap:nowrap;">
                                <span class="input-group-text"><i class="uil uil-search docd-filter-icon"></i></span>
                                <input type="text" id="docdP5Owner" name="owner_name" class="form-control" placeholder="Enter owner name">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-6 col-12">
                        <div class="docd-filter-group">
                            <label class="docd-filter-label" for="docdP5Group"><i class="uil uil-layer-group"></i> Tracking Group</label>
                            <select id="docdP5Group" name="tracking_group" class="form-select">
                                <option value="">All Groups</option>
                                <option value="North Zone">North Zone</option>
                                <option value="South Zone">South Zone</option>
                                <option value="East Zone">East Zone</option>
                                <option value="West Zone">West Zone</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-6 col-12">
                        <div class="docd-filter-group">
                            <label class="docd-filter-label" for="docdP5Agent"><i class="uil uil-user-check"></i> RTO Agent</label>
                            <select id="docdP5Agent" name="rto_agent" class="form-select">
                                <option value="">All Agents</option>
                                @foreach($p5Agents as $agent)
                                <option value="{{ $agent }}">{{ $agent }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-6 col-12">
                        <div class="docd-filter-group">
                            <label class="docd-filter-label" for="docdP5Location"><i class="uil uil-map-marker"></i> RTO Location</label>
                            <select id="docdP5Location" name="rto_location" class="form-select">
                                <option value="">All Locations</option>
                                @foreach($p5Locations as $loc)
                                <option value="{{ $loc }}">{{ $loc }}</option>
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
                <div class="docd-table-head-title"><i class="uil uil-list-ul"></i> 5 Year Permit</div>
                <div class="docd-table-head-sub">{{ count($p5Rows) }} vehicles · sorted by expiry (soonest first)</div>
            </div>
            <div class="docd-sort">
                <label for="docdP5Sort">Sort by</label>
                <select id="docdP5Sort" class="form-select">
                    <option value="expiry_asc" selected>Expiry · Soonest first</option>
                    <option value="expiry_desc">Expiry · Latest first</option>
                </select>
            </div>
        </div>

        <div class="docd-table table-responsive">
            <table class="table mb-0" id="docdP5Table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Vehicle Number</th>
                        <th>Owner Name</th>
                        <th>Tracking Group</th>
                        <th>RTO Agent</th>
                        <th>RTO Location</th>
                        <th>5 Year Permit Cost</th>
                        <th>Start Date</th>
                        <th>Expiry Date</th>
                        <th>Expires In</th>
                        <th>Attachment</th>
                        <th>View Details</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($p5Rows as $i => $r)
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
                            <a href="javascript:void(0)" class="docd-view-details" data-bs-toggle="modal" data-bs-target="#docdP5Dtl{{ $i }}"><i class="uil uil-eye"></i> View Details</a>
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

        <div class="docd-table-foot">Showing {{ count($p5Rows) }} of {{ count($p5Rows) }} vehicles</div>
    </div>

    {{-- View Details modals (document history) --}}
    @foreach($p5Rows as $i => $r)
        @include('documentdashboard.tabs._details-modal', [
            'modalId'  => 'docdP5Dtl' . $i,
            'docLabel' => '5 Year Permit',
            'vehicle'  => $r[0],
            'owner'    => $r[1],
            'agent'    => $r[3],
            'curStart' => $r[6],
            'curEnd'   => $r[7],
        ])
    @endforeach

</div>
