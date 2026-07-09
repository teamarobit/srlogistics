{{-- Document Dashboard — PUCC tab (static; no dynamic data) --}}
@php
    // Static demo data — no dynamic source yet.
    // Each row: vehicle, owner, group, pucc_agent, cost, start, expiry, days
    $puRows = [
        ['OD02AB1234','Sanjay Rout','East Zone','Ramesh Traders','300','09-01-2026','09-07-2026',0],
        ['OD05CD4501','Manoj Behera','East Zone','Sundar Agency','280','09-01-2026','09-07-2026',0],
        ['WB23EF7788','Rakesh Ghosh','East Zone','Metro Emission Center','320','09-01-2026','09-07-2026',0],
        ['MH12GH0099','Prakash Jadhav','West Zone','QuickCheck PUC','300','09-01-2026','09-07-2026',0],
        ['JH10IJ3321','Vikas Mahato','North Zone','Ramesh Traders','260','09-01-2026','09-07-2026',0],
        ['OD07KL9010','Bijay Sahoo','East Zone','Sundar Agency','310','09-01-2026','09-07-2026',0],
        ['CG04MN5566','Ramesh Sahu','North Zone','Metro Emission Center','270','09-01-2026','09-07-2026',0],
        ['AP16OP2244','Srinivas Reddy','South Zone','QuickCheck PUC','330','09-01-2026','09-07-2026',0],
        ['KA51QR8833','Naveen Gowda','South Zone','Ramesh Traders','290','09-01-2026','09-07-2026',0],
        ['GJ01ST6677','Hitesh Patel','West Zone','Sundar Agency','300','09-01-2026','09-07-2026',0],

        ['OD33UV1122','Sanjay Rout','East Zone','Metro Emission Center','285','10-01-2026','10-07-2026',1],
        ['MH14WX4455','Prakash Jadhav','West Zone','QuickCheck PUC','305','10-01-2026','10-07-2026',1],
        ['JH05YZ7799','Vikas Mahato','North Zone','Ramesh Traders','265','10-01-2026','10-07-2026',1],
        ['TN09AB3366','Karthik Rajan','South Zone','Sundar Agency','315','10-01-2026','10-07-2026',1],
        ['RJ14CD5599','Mahendra Singh','North Zone','Metro Emission Center','295','10-01-2026','10-07-2026',1],

        ['OD09EF2200','Bijay Sahoo','East Zone','QuickCheck PUC','300','11-01-2026','11-07-2026',2],
        ['WB19GH8811','Rakesh Ghosh','East Zone','Ramesh Traders','275','11-01-2026','11-07-2026',2],
        ['MH04IJ7744','Hitesh Patel','West Zone','Sundar Agency','325','11-01-2026','11-07-2026',2],
        ['KL07KL1199','Anoop Menon','South Zone','Metro Emission Center','290','11-01-2026','11-07-2026',2],
        ['UP32MN6600','Devendra Yadav','North Zone','QuickCheck PUC','310','11-01-2026','11-07-2026',2],
    ];

    // Sort by expiry soonest first (ascending days) — default sort.
    $puRows = collect($puRows)->sortBy(7)->values()->all();

    $puToday = collect($puRows)->where(7, 0)->count();
    $puDay1  = collect($puRows)->where(7, 1)->count();
    $puDay2  = collect($puRows)->where(7, 2)->count();

    $puAgents = collect($puRows)->pluck(3)->unique()->sort()->values();
@endphp

<div class="docd-tab-body">

    {{-- ── Mini Dashboard ─────────────────────────────────────── --}}
    <div class="docd-kpi-row docd-kpi-row-3">
        <div class="docd-kpi-card kpi-red">
            <div class="docd-kpi-label"><i class="uil uil-exclamation-octagon"></i> Expiry Today</div>
            <div class="docd-kpi-num">{{ $puToday }}</div>
            <div class="docd-kpi-divider"></div>
            <div class="docd-kpi-sub">Vehicle</div>
        </div>
        <div class="docd-kpi-card kpi-orange">
            <div class="docd-kpi-label"><i class="uil uil-clock-three"></i> Expiry in 1 Days</div>
            <div class="docd-kpi-num">{{ $puDay1 }}</div>
            <div class="docd-kpi-divider"></div>
            <div class="docd-kpi-sub">Vehicle</div>
        </div>
        <div class="docd-kpi-card kpi-amber">
            <div class="docd-kpi-label"><i class="uil uil-history"></i> Expiry in 2 Days</div>
            <div class="docd-kpi-num">{{ $puDay2 }}</div>
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
            <form id="docdPuFilterForm" onsubmit="return false;">
                <div class="row g-2 align-items-end">

                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="docd-filter-group">
                            <label class="docd-filter-label" for="docdPuVehicle"><i class="uil uil-truck"></i> Vehicle Number</label>
                            <div class="input-group" style="flex-wrap:nowrap;">
                                <span class="input-group-text"><i class="uil uil-search docd-filter-icon"></i></span>
                                <input type="text" id="docdPuVehicle" name="vehicle_number" class="form-control" placeholder="e.g. OD02AB1234">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="docd-filter-group">
                            <label class="docd-filter-label" for="docdPuOwner"><i class="uil uil-user"></i> Owner Name</label>
                            <div class="input-group" style="flex-wrap:nowrap;">
                                <span class="input-group-text"><i class="uil uil-search docd-filter-icon"></i></span>
                                <input type="text" id="docdPuOwner" name="owner_name" class="form-control" placeholder="Enter owner name">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="docd-filter-group">
                            <label class="docd-filter-label" for="docdPuGroup"><i class="uil uil-layer-group"></i> Tracking Group</label>
                            <select id="docdPuGroup" name="tracking_group" class="form-select">
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
                            <label class="docd-filter-label" for="docdPuAgent"><i class="uil uil-user-check"></i> PUCC Agent</label>
                            <select id="docdPuAgent" name="pucc_agent" class="form-select">
                                <option value="">All Agents</option>
                                @foreach($puAgents as $agent)
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
                <div class="docd-table-head-title"><i class="uil uil-list-ul"></i> PUCC</div>
                <div class="docd-table-head-sub">{{ count($puRows) }} vehicles · sorted by expiry (soonest first)</div>
            </div>
            <div class="docd-sort">
                <label for="docdPuSort">Sort by</label>
                <select id="docdPuSort" class="form-select">
                    <option value="expiry_asc" selected>Expiry · Soonest first</option>
                    <option value="expiry_desc">Expiry · Latest first</option>
                </select>
            </div>
        </div>

        <div class="docd-table table-responsive">
            <table class="table mb-0" id="docdPuTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Vehicle Number</th>
                        <th>Owner Name</th>
                        <th>Tracking Group</th>
                        <th>PUCC Agent</th>
                        <th>PUCC Cost</th>
                        <th>Start Date</th>
                        <th>Expiry Date</th>
                        <th>Expires In</th>
                        <th>Attachment</th>
                        <th>View Details</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($puRows as $i => $r)
                    <tr>
                        <td class="docd-sl">{{ $i + 1 }}</td>
                        <td><span class="docd-reg">{{ $r[0] }}</span></td>
                        <td><span class="docd-owner">{{ $r[1] }}</span></td>
                        <td><span class="docd-group-badge">{{ $r[2] }}</span></td>
                        <td>{{ $r[3] }}</td>
                        <td class="docd-money">
                            &#8377;{{ number_format($r[4]) }}<br>
                            <a href="javascript:void(0)" class="docd-breakup-link"><i class="uil uil-receipt-alt"></i> View breakup</a>
                        </td>
                        <td class="docd-date">{{ $r[5] }}</td>
                        <td class="docd-date">{{ $r[6] }}</td>
                        <td>
                            @if($r[7] === 0)
                                <span class="docd-exp docd-exp-today">Today</span>
                            @elseif($r[7] === 1)
                                <span class="docd-exp docd-exp-urgent">1 Day</span>
                            @elseif($r[7] <= 7)
                                <span class="docd-exp docd-exp-soon">{{ $r[7] }} Days</span>
                            @else
                                <span class="docd-exp docd-exp-ok">{{ $r[7] }} Days</span>
                            @endif
                        </td>
                        <td>
                            <a href="javascript:void(0)" class="docd-attach docd-attach-view"><i class="uil uil-file-check-alt"></i> View</a>
                        </td>
                        <td>
                            <a href="javascript:void(0)" class="docd-view-details" data-bs-toggle="modal" data-bs-target="#docdPuDtl{{ $i }}"><i class="uil uil-eye"></i> View Details</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="11">
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

        <div class="docd-table-foot">Showing {{ count($puRows) }} of {{ count($puRows) }} vehicles</div>
    </div>

    {{-- View Details modals (document history) --}}
    @foreach($puRows as $i => $r)
        @include('documentdashboard.tabs._details-modal', [
            'modalId'  => 'docdPuDtl' . $i,
            'docLabel' => 'PUCC',
            'vehicle'  => $r[0],
            'owner'    => $r[1],
            'agent'    => $r[3],
            'curStart' => $r[5],
            'curEnd'   => $r[6],
        ])
    @endforeach

</div>
