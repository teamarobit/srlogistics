{{-- Document Dashboard — Insurance tab (static; no dynamic data) --}}
@php
    // Static demo data — no dynamic source yet.
    // Each row: vehicle, owner, group, agent, company, ins_no, premium, cashback, cashback_pct, idv, start, expiry, days
    $insRows = [
        ['OD02AB1234','Sanjay Rout','East Zone','Ramesh Traders','ICICI Lombard','ICL-9920011','32500','2600','8','1250000','09-07-2025','09-07-2026',0],
        ['OD05CD4501','Manoj Behera','East Zone','Sundar Agency','Bajaj Allianz','BA-4471200','28900','1734','6','1080000','09-07-2025','09-07-2026',0],
        ['WB23EF7788','Rakesh Ghosh','East Zone','Metro Insure','HDFC Ergo','HE-7781023','41200','4120','10','1620000','09-07-2025','09-07-2026',0],
        ['MH12GH0099','Prakash Jadhav','West Zone','QuickCover','New India Assurance','NIA-5567781','35750','2145','6','1400000','09-07-2025','09-07-2026',0],
        ['JH10IJ3321','Vikas Mahato','North Zone','Ramesh Traders','TATA AIG','TA-3390122','29800','2384','8','1150000','09-07-2025','09-07-2026',0],
        ['OD07KL9010','Bijay Sahoo','East Zone','Sundar Agency','ICICI Lombard','ICL-9920145','33400','2004','6','1300000','09-07-2025','09-07-2026',0],
        ['CG04MN5566','Ramesh Sahu','North Zone','Metro Insure','Bajaj Allianz','BA-4471566','27600','2208','8','1020000','09-07-2025','09-07-2026',0],
        ['AP16OP2244','Srinivas Reddy','South Zone','QuickCover','HDFC Ergo','HE-7781290','44900','3592','8','1750000','09-07-2025','09-07-2026',0],
        ['KA51QR8833','Naveen Gowda','South Zone','Ramesh Traders','New India Assurance','NIA-5567902','31200','1872','6','1210000','09-07-2025','09-07-2026',0],
        ['GJ01ST6677','Hitesh Patel','West Zone','Sundar Agency','TATA AIG','TA-3390455','36100','2888','8','1420000','09-07-2025','09-07-2026',0],

        ['OD33UV1122','Sanjay Rout','East Zone','Metro Insure','ICICI Lombard','ICL-9921201','30500','1830','6','1180000','10-07-2025','10-07-2026',1],
        ['MH14WX4455','Prakash Jadhav','West Zone','QuickCover','Bajaj Allianz','BA-4472011','34800','2784','8','1360000','10-07-2025','10-07-2026',1],
        ['JH05YZ7799','Vikas Mahato','North Zone','Ramesh Traders','HDFC Ergo','HE-7781455','28200','1692','6','1090000','10-07-2025','10-07-2026',1],
        ['TN09AB3366','Karthik Rajan','South Zone','Sundar Agency','New India Assurance','NIA-5568120','39900','3990','10','1560000','10-07-2025','10-07-2026',1],
        ['RJ14CD5599','Mahendra Singh','North Zone','Metro Insure','TATA AIG','TA-3390788','32100','1926','6','1250000','10-07-2025','10-07-2026',1],

        ['OD09EF2200','Bijay Sahoo','East Zone','QuickCover','ICICI Lombard','ICL-9921567','33900','2712','8','1330000','11-07-2025','11-07-2026',2],
        ['WB19GH8811','Rakesh Ghosh','East Zone','Ramesh Traders','Bajaj Allianz','BA-4472456','29500','1770','6','1140000','11-07-2025','11-07-2026',2],
        ['MH04IJ7744','Hitesh Patel','West Zone','Sundar Agency','HDFC Ergo','HE-7781788','43100','3448','8','1690000','11-07-2025','11-07-2026',2],
        ['KL07KL1199','Anoop Menon','South Zone','Metro Insure','New India Assurance','NIA-5568345','30800','2464','8','1200000','11-07-2025','11-07-2026',2],
        ['UP32MN6600','Devendra Yadav','North Zone','QuickCover','TATA AIG','TA-3391012','35300','2118','6','1380000','11-07-2025','11-07-2026',2],
    ];

    // Sort by expiry soonest first (ascending days) — default sort.
    $insRows = collect($insRows)->sortBy(12)->values()->all();

    $insToday = collect($insRows)->where(12, 0)->count();
    $insDay1  = collect($insRows)->where(12, 1)->count();
    $insDay2  = collect($insRows)->where(12, 2)->count();

    $insAgents    = collect($insRows)->pluck(3)->unique()->sort()->values();
    $insCompanies = collect($insRows)->pluck(4)->unique()->sort()->values();
@endphp

<div class="docd-tab-body">

    {{-- ── Mini Dashboard ─────────────────────────────────────── --}}
    <div class="docd-kpi-row docd-kpi-row-3">
        <div class="docd-kpi-card kpi-red">
            <div class="docd-kpi-label"><i class="uil uil-exclamation-octagon"></i> Expiry Today</div>
            <div class="docd-kpi-num">{{ $insToday }}</div>
            <div class="docd-kpi-divider"></div>
            <div class="docd-kpi-sub">Vehicle</div>
        </div>
        <div class="docd-kpi-card kpi-orange">
            <div class="docd-kpi-label"><i class="uil uil-clock-three"></i> Expiry in 1 Days</div>
            <div class="docd-kpi-num">{{ $insDay1 }}</div>
            <div class="docd-kpi-divider"></div>
            <div class="docd-kpi-sub">Vehicle</div>
        </div>
        <div class="docd-kpi-card kpi-amber">
            <div class="docd-kpi-label"><i class="uil uil-history"></i> Expiry in 2 Days</div>
            <div class="docd-kpi-num">{{ $insDay2 }}</div>
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
            <form id="docdInsFilterForm" onsubmit="return false;">
                <div class="row g-2 align-items-end">

                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="docd-filter-group">
                            <label class="docd-filter-label" for="docdInsVehicle"><i class="uil uil-truck"></i> Vehicle Number</label>
                            <div class="input-group" style="flex-wrap:nowrap;">
                                <span class="input-group-text"><i class="uil uil-search docd-filter-icon"></i></span>
                                <input type="text" id="docdInsVehicle" name="vehicle_number" class="form-control" placeholder="e.g. OD02AB1234">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="docd-filter-group">
                            <label class="docd-filter-label" for="docdInsOwner"><i class="uil uil-user"></i> Owner Name</label>
                            <div class="input-group" style="flex-wrap:nowrap;">
                                <span class="input-group-text"><i class="uil uil-search docd-filter-icon"></i></span>
                                <input type="text" id="docdInsOwner" name="owner_name" class="form-control" placeholder="Enter owner name">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-6 col-12">
                        <div class="docd-filter-group">
                            <label class="docd-filter-label" for="docdInsGroup"><i class="uil uil-layer-group"></i> Tracking Group</label>
                            <select id="docdInsGroup" name="tracking_group" class="form-select">
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
                            <label class="docd-filter-label" for="docdInsAgent"><i class="uil uil-user-check"></i> Insurance Agent</label>
                            <select id="docdInsAgent" name="insurance_agent" class="form-select">
                                <option value="">All Agents</option>
                                @foreach($insAgents as $agent)
                                <option value="{{ $agent }}">{{ $agent }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-6 col-12">
                        <div class="docd-filter-group">
                            <label class="docd-filter-label" for="docdInsCompany"><i class="uil uil-building"></i> Insurance Company</label>
                            <select id="docdInsCompany" name="insurance_company" class="form-select">
                                <option value="">All Companies</option>
                                @foreach($insCompanies as $company)
                                <option value="{{ $company }}">{{ $company }}</option>
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
                <div class="docd-table-head-title"><i class="uil uil-list-ul"></i> Insurance</div>
                <div class="docd-table-head-sub">{{ count($insRows) }} vehicles · sorted by expiry (soonest first)</div>
            </div>
            <div class="docd-sort">
                <label for="docdInsSort">Sort by</label>
                <select id="docdInsSort" class="form-select">
                    <option value="expiry_asc" selected>Expiry · Soonest first</option>
                    <option value="expiry_desc">Expiry · Latest first</option>
                </select>
            </div>
        </div>

        <div class="docd-table table-responsive">
            <table class="table mb-0" id="docdInsTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Vehicle Number</th>
                        <th>Owner Name</th>
                        <th>Tracking Group</th>
                        <th>Insurance Agent</th>
                        <th>Insurance Company</th>
                        <th>Insurance Number</th>
                        <th>Insurance Premium</th>
                        <th>Cashback &amp; %</th>
                        <th>IDV Value</th>
                        <th>Start Date</th>
                        <th>Expiry Date</th>
                        <th>Expires In</th>
                        <th>Attachment</th>
                        <th>View Details</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($insRows as $i => $r)
                    <tr>
                        <td class="docd-sl">{{ $i + 1 }}</td>
                        <td><span class="docd-reg">{{ $r[0] }}</span></td>
                        <td><span class="docd-owner">{{ $r[1] }}</span></td>
                        <td><span class="docd-group-badge">{{ $r[2] }}</span></td>
                        <td>{{ $r[3] }}</td>
                        <td>{{ $r[4] }}</td>
                        <td class="docd-loc">{{ $r[5] }}</td>
                        <td class="docd-money">&#8377;{{ number_format($r[6]) }}</td>
                        <td class="docd-cashback">&#8377;{{ number_format($r[7]) }} <small>({{ $r[8] }}%)</small></td>
                        <td class="docd-money">&#8377;{{ number_format($r[9]) }}</td>
                        <td class="docd-date">{{ $r[10] }}</td>
                        <td class="docd-date">{{ $r[11] }}</td>
                        <td>
                            @if($r[12] === 0)
                                <span class="docd-exp docd-exp-today">Today</span>
                            @elseif($r[12] === 1)
                                <span class="docd-exp docd-exp-urgent">1 Day</span>
                            @elseif($r[12] <= 7)
                                <span class="docd-exp docd-exp-soon">{{ $r[12] }} Days</span>
                            @else
                                <span class="docd-exp docd-exp-ok">{{ $r[12] }} Days</span>
                            @endif
                        </td>
                        <td>
                            <a href="javascript:void(0)" class="docd-attach docd-attach-view"><i class="uil uil-file-check-alt"></i> View</a>
                        </td>
                        <td>
                            <a href="javascript:void(0)" class="docd-view-details" data-bs-toggle="modal" data-bs-target="#docdInsDtl{{ $i }}"><i class="uil uil-eye"></i> View Details</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="15">
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

        <div class="docd-table-foot">Showing {{ count($insRows) }} of {{ count($insRows) }} vehicles</div>
    </div>

    {{-- View Details modals (document history) --}}
    @foreach($insRows as $i => $r)
        @include('documentdashboard.tabs._details-modal', [
            'modalId'  => 'docdInsDtl' . $i,
            'docLabel' => 'Insurance',
            'vehicle'  => $r[0],
            'owner'    => $r[1],
            'agent'    => $r[3],
            'curStart' => $r[10],
            'curEnd'   => $r[11],
        ])
    @endforeach

</div>
