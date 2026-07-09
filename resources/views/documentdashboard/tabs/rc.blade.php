{{-- Document Dashboard — RC tab (static; no dynamic data) --}}
@php
    // Static demo data — no dynamic source yet.
    // [ vehicle, owner, tracking group, original RC location, RC uploaded? ]
    $rcRows = [
        ['OD02AB1234', 'Sanjay Rout',    'East Zone',  'Head Office · RC Folder 01',   true],
        ['OD05CD4501', 'Manoj Behera',   'East Zone',  'Bhubaneswar Branch · File 07', true],
        ['WB23EF7788', 'Rakesh Ghosh',   'East Zone',  'Kolkata RTO File Room',        true],
        ['MH12GH0099', 'Prakash Jadhav', 'West Zone',  'Pune Depot · Rack 3',          false],
        ['JH10IJ3321', 'Vikas Mahato',   'North Zone', 'Ranchi Office · Drawer B',     true],
        ['OD07KL9010', 'Bijay Sahoo',    'East Zone',  'Head Office · RC Folder 04',   false],
        ['CG04MN5566', 'Ramesh Sahu',    'North Zone', 'Raipur Branch · File 22',      true],
        ['AP16OP2244', 'Srinivas Reddy', 'South Zone', 'Vijayawada Depot · Rack 1',    true],
        ['KA51QR8833', 'Naveen Gowda',   'South Zone', 'Bangalore RTO File Room',      true],
        ['GJ01ST6677', 'Hitesh Patel',   'West Zone',  'Ahmedabad Office · Drawer C',  false],
        ['MH14WX4455', 'Prakash Jadhav', 'West Zone',  'Nashik Branch · File 09',      true],
        ['UP32MN6600', 'Devendra Yadav', 'North Zone', 'Lucknow Depot · Rack 5',       true],
        ['TN09AB3366', 'Karthik Rajan',  'South Zone', 'Chennai Office · Cabinet D-3', false],
        ['RJ14CD5599', 'Mahendra Singh', 'North Zone', 'Jaipur RTO File Room',         true],
    ];

    $rcTotal    = count($rcRows);
    $rcUploaded = collect($rcRows)->where(4, true)->count();
    $rcPending  = $rcTotal - $rcUploaded;
    $rcOnFile   = collect($rcRows)->filter(fn ($r) => ! empty($r[3]))->count();
@endphp

<div class="docd-tab-body">

    {{-- ── Mini Dashboard ─────────────────────────────────────── --}}
    <div class="docd-kpi-row">
        <div class="docd-kpi-card kpi-blue">
            <div class="docd-kpi-label"><i class="uil uil-truck"></i> Total Vehicles</div>
            <div class="docd-kpi-num">{{ $rcTotal }}</div>
            <div class="docd-kpi-divider"></div>
            <div class="docd-kpi-sub">In this list</div>
        </div>
        <div class="docd-kpi-card kpi-green">
            <div class="docd-kpi-label"><i class="uil uil-file-check-alt"></i> RC Uploaded</div>
            <div class="docd-kpi-num">{{ $rcUploaded }}</div>
            <div class="docd-kpi-divider"></div>
            <div class="docd-kpi-sub">of {{ $rcTotal }} vehicles</div>
        </div>
        <div class="docd-kpi-card kpi-amber">
            <div class="docd-kpi-label"><i class="uil uil-file-exclamation-alt"></i> Pending Upload</div>
            <div class="docd-kpi-num">{{ $rcPending }}</div>
            <div class="docd-kpi-divider"></div>
            <div class="docd-kpi-sub">RC not attached</div>
        </div>
        <div class="docd-kpi-card kpi-teal">
            <div class="docd-kpi-label"><i class="uil uil-archive"></i> Original RC on File</div>
            <div class="docd-kpi-num">{{ $rcOnFile }}</div>
            <div class="docd-kpi-divider"></div>
            <div class="docd-kpi-sub">Physical location recorded</div>
        </div>
    </div>

    {{-- ── Filter Bar ─────────────────────────────────────────── --}}
    <div class="docd-filter-card">
        <div class="docd-filter-header">
            <div class="docd-filter-title"><i class="uil uil-filter"></i> Filters</div>
        </div>
        <div class="docd-filter-body">
            <form id="docdRcFilterForm" onsubmit="return false;">
                <div class="row g-2 align-items-end">

                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="docd-filter-group">
                            <label class="docd-filter-label" for="docdRcVehicle"><i class="uil uil-truck"></i> Vehicle Number</label>
                            <div class="input-group" style="flex-wrap:nowrap;">
                                <span class="input-group-text"><i class="uil uil-search docd-filter-icon"></i></span>
                                <input type="text" id="docdRcVehicle" name="vehicle_number" class="form-control" placeholder="e.g. OD02AB1234">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="docd-filter-group">
                            <label class="docd-filter-label" for="docdRcOwner"><i class="uil uil-user"></i> Owner Name</label>
                            <div class="input-group" style="flex-wrap:nowrap;">
                                <span class="input-group-text"><i class="uil uil-search docd-filter-icon"></i></span>
                                <input type="text" id="docdRcOwner" name="owner_name" class="form-control" placeholder="Enter owner name">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-6 col-12">
                        <div class="docd-filter-group">
                            <label class="docd-filter-label" for="docdRcGroup"><i class="uil uil-layer-group"></i> Tracking Group</label>
                            <select id="docdRcGroup" name="tracking_group" class="form-select">
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
                            <label class="docd-filter-label" for="docdRcStatus"><i class="uil uil-file-alt"></i> RC Status</label>
                            <select id="docdRcStatus" name="rc_status" class="form-select">
                                <option value="">All</option>
                                <option value="Uploaded">Uploaded</option>
                                <option value="Pending">Pending</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-6 col-12 d-flex align-items-end">
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
                <div class="docd-table-head-title"><i class="uil uil-list-ul"></i> RC</div>
                <div class="docd-table-head-sub">{{ $rcTotal }} vehicles</div>
            </div>
        </div>

        <div class="docd-table table-responsive">
            <table class="table mb-0" id="docdRcTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Vehicle Number</th>
                        <th>Owner Name</th>
                        <th>Tracking Group</th>
                        <th>Original RC Location</th>
                        <th>RC Attachment</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rcRows as $i => $r)
                    <tr>
                        <td class="docd-sl">{{ $i + 1 }}</td>
                        <td><span class="docd-reg">{{ $r[0] }}</span></td>
                        <td><span class="docd-owner">{{ $r[1] }}</span></td>
                        <td><span class="docd-group-badge">{{ $r[2] }}</span></td>
                        <td><span class="docd-loc">{{ $r[3] }}</span></td>
                        <td>
                            @if($r[4])
                                <a href="javascript:void(0)" class="docd-attach docd-attach-view"><i class="uil uil-file-check-alt"></i> View</a>
                            @else
                                <span class="docd-attach docd-attach-missing"><i class="uil uil-file-slash"></i> Not Uploaded</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
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

        <div class="docd-table-foot">Showing {{ $rcTotal }} of {{ $rcTotal }} vehicles</div>
    </div>

</div>
