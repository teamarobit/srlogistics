{{-- Document Dashboard — Invoice – Chassis & Body tab (static; no dynamic data) --}}
@php
    // Static demo data — no dynamic source yet.
    // [ vehicle, owner, tracking group, chassis invoice location, body invoice location, chassis uploaded?, body uploaded? ]
    $invRows = [
        ['OD02AB1234', 'Sanjay Rout',    'East Zone',  'Head Office · Cabinet A-12', 'Head Office · Cabinet A-12', true,  true],
        ['OD05CD4501', 'Manoj Behera',   'East Zone',  'Bhubaneswar Branch · File 07', 'Bhubaneswar Branch · File 07', true,  false],
        ['WB23EF7788', 'Rakesh Ghosh',   'East Zone',  'Kolkata RTO File Room',        'Kolkata RTO File Room',        true,  true],
        ['MH12GH0099', 'Prakash Jadhav', 'West Zone',  'Pune Depot · Rack 3',          'Pune Depot · Rack 3',          false, false],
        ['JH10IJ3321', 'Vikas Mahato',   'North Zone', 'Ranchi Office · Drawer B',     'Ranchi Office · Drawer B',     true,  true],
        ['OD07KL9010', 'Bijay Sahoo',    'East Zone',  'Head Office · Cabinet A-15',   'Head Office · Cabinet A-15',   true,  false],
        ['CG04MN5566', 'Ramesh Sahu',    'North Zone', 'Raipur Branch · File 22',      'Raipur Branch · File 22',      false, true],
        ['AP16OP2244', 'Srinivas Reddy', 'South Zone', 'Vijayawada Depot · Rack 1',    'Vijayawada Depot · Rack 1',    true,  true],
        ['KA51QR8833', 'Naveen Gowda',   'South Zone', 'Bangalore RTO File Room',      'Bangalore RTO File Room',      true,  true],
        ['GJ01ST6677', 'Hitesh Patel',   'West Zone',  'Ahmedabad Office · Drawer C',  'Ahmedabad Office · Drawer C',  true,  false],
        ['MH14WX4455', 'Prakash Jadhav', 'West Zone',  'Nashik Branch · File 09',      'Nashik Branch · File 09',      false, false],
        ['UP32MN6600', 'Devendra Yadav', 'North Zone', 'Lucknow Depot · Rack 5',       'Lucknow Depot · Rack 5',       true,  true],
        ['TN09AB3366', 'Karthik Rajan',  'South Zone', 'Chennai Office · Cabinet D-3', 'Chennai Office · Cabinet D-3', true,  false],
        ['RJ14CD5599', 'Mahendra Singh', 'North Zone', 'Jaipur RTO File Room',         'Jaipur RTO File Room',         true,  true],
    ];

    $invTotal   = count($invRows);
    $invChassis = collect($invRows)->where(5, true)->count();
    $invBody    = collect($invRows)->where(6, true)->count();
    $invPending = collect($invRows)->filter(fn ($r) => ! $r[5] || ! $r[6])->count();
@endphp

<div class="docd-tab-body">

    {{-- ── Mini Dashboard ─────────────────────────────────────── --}}
    <div class="docd-kpi-row">
        <div class="docd-kpi-card kpi-blue">
            <div class="docd-kpi-label"><i class="uil uil-truck"></i> Total Vehicles</div>
            <div class="docd-kpi-num">{{ $invTotal }}</div>
            <div class="docd-kpi-divider"></div>
            <div class="docd-kpi-sub">In this list</div>
        </div>
        <div class="docd-kpi-card kpi-green">
            <div class="docd-kpi-label"><i class="uil uil-file-check-alt"></i> Chassis Invoice Uploaded</div>
            <div class="docd-kpi-num">{{ $invChassis }}</div>
            <div class="docd-kpi-divider"></div>
            <div class="docd-kpi-sub">of {{ $invTotal }} vehicles</div>
        </div>
        <div class="docd-kpi-card kpi-teal">
            <div class="docd-kpi-label"><i class="uil uil-file-check-alt"></i> Body Invoice Uploaded</div>
            <div class="docd-kpi-num">{{ $invBody }}</div>
            <div class="docd-kpi-divider"></div>
            <div class="docd-kpi-sub">of {{ $invTotal }} vehicles</div>
        </div>
        <div class="docd-kpi-card kpi-amber">
            <div class="docd-kpi-label"><i class="uil uil-file-exclamation-alt"></i> Pending Upload</div>
            <div class="docd-kpi-num">{{ $invPending }}</div>
            <div class="docd-kpi-divider"></div>
            <div class="docd-kpi-sub">Missing chassis / body</div>
        </div>
    </div>

    {{-- ── Filter Bar ─────────────────────────────────────────── --}}
    <div class="docd-filter-card">
        <div class="docd-filter-header">
            <div class="docd-filter-title"><i class="uil uil-filter"></i> Filters</div>
        </div>
        <div class="docd-filter-body">
            <form id="docdInvoiceFilterForm" onsubmit="return false;">
                <div class="row g-2 align-items-end">

                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="docd-filter-group">
                            <label class="docd-filter-label" for="docdInvVehicle"><i class="uil uil-truck"></i> Vehicle Number</label>
                            <div class="input-group" style="flex-wrap:nowrap;">
                                <span class="input-group-text"><i class="uil uil-search docd-filter-icon"></i></span>
                                <input type="text" id="docdInvVehicle" name="vehicle_number" class="form-control" placeholder="e.g. OD02AB1234">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="docd-filter-group">
                            <label class="docd-filter-label" for="docdInvOwner"><i class="uil uil-user"></i> Owner Name</label>
                            <div class="input-group" style="flex-wrap:nowrap;">
                                <span class="input-group-text"><i class="uil uil-search docd-filter-icon"></i></span>
                                <input type="text" id="docdInvOwner" name="owner_name" class="form-control" placeholder="Enter owner name">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-6 col-12">
                        <div class="docd-filter-group">
                            <label class="docd-filter-label" for="docdInvGroup"><i class="uil uil-layer-group"></i> Tracking Group</label>
                            <select id="docdInvGroup" name="tracking_group" class="form-select">
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
                            <label class="docd-filter-label" for="docdInvStatus"><i class="uil uil-file-alt"></i> Invoice Status</label>
                            <select id="docdInvStatus" name="invoice_status" class="form-select">
                                <option value="">All</option>
                                <option value="Both Uploaded">Both Uploaded</option>
                                <option value="Chassis Pending">Chassis Pending</option>
                                <option value="Body Pending">Body Pending</option>
                                <option value="Both Pending">Both Pending</option>
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
                <div class="docd-table-head-title"><i class="uil uil-list-ul"></i> Invoice – Chassis &amp; Body</div>
                <div class="docd-table-head-sub">{{ $invTotal }} vehicles</div>
            </div>
        </div>

        <div class="docd-table table-responsive">
            <table class="table mb-0" id="docdInvoiceTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Vehicle Number</th>
                        <th>Owner Name</th>
                        <th>Tracking Group</th>
                        <th>Original Chassis Invoice Location</th>
                        <th>Original Body Invoice Location</th>
                        <th>Chassis Invoice Attachment</th>
                        <th>Body Invoice Attachment</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($invRows as $i => $r)
                    <tr>
                        <td class="docd-sl">{{ $i + 1 }}</td>
                        <td><span class="docd-reg">{{ $r[0] }}</span></td>
                        <td><span class="docd-owner">{{ $r[1] }}</span></td>
                        <td><span class="docd-group-badge">{{ $r[2] }}</span></td>
                        <td><span class="docd-loc">{{ $r[3] }}</span></td>
                        <td><span class="docd-loc">{{ $r[4] }}</span></td>
                        <td>
                            @if($r[5])
                                <a href="javascript:void(0)" class="docd-attach docd-attach-view"><i class="uil uil-file-check-alt"></i> View</a>
                            @else
                                <span class="docd-attach docd-attach-missing"><i class="uil uil-file-slash"></i> Not Uploaded</span>
                            @endif
                        </td>
                        <td>
                            @if($r[6])
                                <a href="javascript:void(0)" class="docd-attach docd-attach-view"><i class="uil uil-file-check-alt"></i> View</a>
                            @else
                                <span class="docd-attach docd-attach-missing"><i class="uil uil-file-slash"></i> Not Uploaded</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8">
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

        <div class="docd-table-foot">Showing {{ $invTotal }} of {{ $invTotal }} vehicles</div>
    </div>

</div>
