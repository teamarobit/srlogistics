{{-- Document Dashboard — Tax tab (static; no dynamic data) --}}
@php
    // Static demo data — no dynamic source yet.
    // Each row: vehicle, owner, group, rto_agent, rto_location, cost, start, expiry, days
    $taxRows = [
        ['OD02AB1234','Sanjay Rout','East Zone','Ramesh Traders','Bhubaneswar RTO','12500','09-07-2025','09-07-2026',0],
        ['OD05CD4501','Manoj Behera','East Zone','Sundar Agency','Cuttack RTO','11800','09-07-2025','09-07-2026',0],
        ['WB23EF7788','Rakesh Ghosh','East Zone','Metro RTO Services','Kolkata RTO','13200','09-07-2025','09-07-2026',0],
        ['MH12GH0099','Prakash Jadhav','West Zone','QuickRTO','Pune RTO','12100','09-07-2025','09-07-2026',0],
        ['JH10IJ3321','Vikas Mahato','North Zone','Ramesh Traders','Ranchi RTO','11500','09-07-2025','09-07-2026',0],
        ['OD07KL9010','Bijay Sahoo','East Zone','Sundar Agency','Bhubaneswar RTO','12800','09-07-2025','09-07-2026',0],
        ['CG04MN5566','Ramesh Sahu','North Zone','Metro RTO Services','Raipur RTO','11900','09-07-2025','09-07-2026',0],
        ['AP16OP2244','Srinivas Reddy','South Zone','QuickRTO','Vijayawada RTO','13600','09-07-2025','09-07-2026',0],
        ['KA51QR8833','Naveen Gowda','South Zone','Ramesh Traders','Bangalore RTO','12300','09-07-2025','09-07-2026',0],
        ['GJ01ST6677','Hitesh Patel','West Zone','Sundar Agency','Ahmedabad RTO','12600','09-07-2025','09-07-2026',0],

        ['OD33UV1122','Sanjay Rout','East Zone','Metro RTO Services','Bhubaneswar RTO','12000','10-07-2025','10-07-2026',1],
        ['MH14WX4455','Prakash Jadhav','West Zone','QuickRTO','Nashik RTO','12400','10-07-2025','10-07-2026',1],
        ['JH05YZ7799','Vikas Mahato','North Zone','Ramesh Traders','Ranchi RTO','11600','10-07-2025','10-07-2026',1],
        ['TN09AB3366','Karthik Rajan','South Zone','Sundar Agency','Chennai RTO','13100','10-07-2025','10-07-2026',1],
        ['RJ14CD5599','Mahendra Singh','North Zone','Metro RTO Services','Jaipur RTO','12200','10-07-2025','10-07-2026',1],

        ['OD09EF2200','Bijay Sahoo','East Zone','QuickRTO','Cuttack RTO','12700','11-07-2025','11-07-2026',2],
        ['WB19GH8811','Rakesh Ghosh','East Zone','Ramesh Traders','Kolkata RTO','11700','11-07-2025','11-07-2026',2],
        ['MH04IJ7744','Hitesh Patel','West Zone','Sundar Agency','Pune RTO','13300','11-07-2025','11-07-2026',2],
        ['KL07KL1199','Anoop Menon','South Zone','Metro RTO Services','Bangalore RTO','12050','11-07-2025','11-07-2026',2],
        ['UP32MN6600','Devendra Yadav','North Zone','QuickRTO','Lucknow RTO','12450','11-07-2025','11-07-2026',2],
    ];

    // Sort by expiry soonest first (ascending days) — default sort.
    $taxRows = collect($taxRows)->sortBy(8)->values()->all();

    $taxToday = collect($taxRows)->where(8, 0)->count();
    $taxDay1  = collect($taxRows)->where(8, 1)->count();
    $taxDay2  = collect($taxRows)->where(8, 2)->count();

    $taxAgents    = collect($taxRows)->pluck(3)->unique()->sort()->values();
    $taxLocations = collect($taxRows)->pluck(4)->unique()->sort()->values();
@endphp

<div class="docd-tab-body">

    {{-- ── Mini Dashboard ─────────────────────────────────────── --}}
    <div class="docd-kpi-row docd-kpi-row-3">
        <div class="docd-kpi-card kpi-red">
            <div class="docd-kpi-label"><i class="uil uil-exclamation-octagon"></i> Expiry Today</div>
            <div class="docd-kpi-num">{{ $taxToday }}</div>
            <div class="docd-kpi-divider"></div>
            <div class="docd-kpi-sub">Vehicle</div>
        </div>
        <div class="docd-kpi-card kpi-orange">
            <div class="docd-kpi-label"><i class="uil uil-clock-three"></i> Expiry in 1 Days</div>
            <div class="docd-kpi-num">{{ $taxDay1 }}</div>
            <div class="docd-kpi-divider"></div>
            <div class="docd-kpi-sub">Vehicle</div>
        </div>
        <div class="docd-kpi-card kpi-amber">
            <div class="docd-kpi-label"><i class="uil uil-history"></i> Expiry in 2 Days</div>
            <div class="docd-kpi-num">{{ $taxDay2 }}</div>
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
            <form id="docdTaxFilterForm" onsubmit="return false;">
                <div class="row g-2 align-items-end">

                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="docd-filter-group">
                            <label class="docd-filter-label" for="docdTaxVehicle"><i class="uil uil-truck"></i> Vehicle Number</label>
                            <div class="input-group" style="flex-wrap:nowrap;">
                                <span class="input-group-text"><i class="uil uil-search docd-filter-icon"></i></span>
                                <input type="text" id="docdTaxVehicle" name="vehicle_number" class="form-control" placeholder="e.g. OD02AB1234">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="docd-filter-group">
                            <label class="docd-filter-label" for="docdTaxOwner"><i class="uil uil-user"></i> Owner Name</label>
                            <div class="input-group" style="flex-wrap:nowrap;">
                                <span class="input-group-text"><i class="uil uil-search docd-filter-icon"></i></span>
                                <input type="text" id="docdTaxOwner" name="owner_name" class="form-control" placeholder="Enter owner name">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-6 col-12">
                        <div class="docd-filter-group">
                            <label class="docd-filter-label" for="docdTaxGroup"><i class="uil uil-layer-group"></i> Tracking Group</label>
                            <select id="docdTaxGroup" name="tracking_group" class="form-select">
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
                            <label class="docd-filter-label" for="docdTaxAgent"><i class="uil uil-user-check"></i> RTO Agent</label>
                            <select id="docdTaxAgent" name="rto_agent" class="form-select">
                                <option value="">All Agents</option>
                                @foreach($taxAgents as $agent)
                                <option value="{{ $agent }}">{{ $agent }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-6 col-12">
                        <div class="docd-filter-group">
                            <label class="docd-filter-label" for="docdTaxLocation"><i class="uil uil-map-marker"></i> RTO Location</label>
                            <select id="docdTaxLocation" name="rto_location" class="form-select">
                                <option value="">All Locations</option>
                                @foreach($taxLocations as $loc)
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
                <div class="docd-table-head-title"><i class="uil uil-list-ul"></i> Tax</div>
                <div class="docd-table-head-sub">{{ count($taxRows) }} vehicles · sorted by expiry (soonest first)</div>
            </div>
            <div class="docd-sort">
                <label for="docdTaxSort">Sort by</label>
                <select id="docdTaxSort" class="form-select">
                    <option value="expiry_asc" selected>Expiry · Soonest first</option>
                    <option value="expiry_desc">Expiry · Latest first</option>
                </select>
            </div>
        </div>

        <div class="docd-table table-responsive">
            <table class="table mb-0" id="docdTaxTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Vehicle Number</th>
                        <th>Owner Name</th>
                        <th>Tracking Group</th>
                        <th>RTO Agent</th>
                        <th>RTO Location</th>
                        <th>Tax Cost</th>
                        <th>Start Date</th>
                        <th>Expiry Date</th>
                        <th>Expires In</th>
                        <th>Attachment</th>
                        <th>View Details</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($taxRows as $i => $r)
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
                            <a href="javascript:void(0)" class="docd-view-details" data-bs-toggle="modal" data-bs-target="#docdTaxDtl{{ $i }}"><i class="uil uil-eye"></i> View Details</a>
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

        <div class="docd-table-foot">Showing {{ count($taxRows) }} of {{ count($taxRows) }} vehicles</div>
    </div>

    {{-- View Details modals (document history) --}}
    @foreach($taxRows as $i => $r)
        @include('documentdashboard.tabs._details-modal', [
            'modalId'  => 'docdTaxDtl' . $i,
            'docLabel' => 'Tax',
            'vehicle'  => $r[0],
            'owner'    => $r[1],
            'agent'    => $r[3],
            'curStart' => $r[6],
            'curEnd'   => $r[7],
        ])
    @endforeach

</div>
