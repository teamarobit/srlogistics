@extends('layouts.app')

@section('css')
<link href="{{ asset('css/Workshop/dashboard.css?v=1.0') }}" rel="stylesheet">
@endsection

@section('content')
<div class="layout-wrapper">

    @include('includes.header')

    <div class="wrapper srlog-bdwrapper">
        <div class="main-wrap sc-no-sidebar">

            {{-- Top Bar: SC Selector + Page Title + Actions --}}
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                <div class="d-flex align-items-center gap-3 flex-wrap">
                    <div>
                        <h5 class="mb-0">Workshop Dashboard</h5>
                        <span class="text-muted" style="font-size:11px;">WS-HYD — Hyderabad Workshop</span>
                    </div>
                    <div class="d-flex align-items-center gap-1" style="background:#f4f6fb;border:1px solid #e0e4ef;border-radius:6px;padding:5px 10px;">
                        <i class="uil uil-wrench" style="color:#032671;font-size:14px;"></i>
                        <select class="loc-ctx-select" id="scCtxSelector" style="border:0;background:transparent;font-size:12px;color:#032671;font-weight:600;outline:none;">
                            <option value="WS-HYD">WS-HYD — Hyderabad Workshop</option>
                        </select>
                    </div>
                </div>
                <div class="d-flex gap-2 flex-wrap">
                    <a href="{{ route('ws.in-token.index') }}" class="sc-quick-btn" style="background:#e3ecff;color:#032671;font-size:11px;padding:6px 12px;">
                        <i class="uil uil-sign-in-alt me-1"></i>Gate Entry
                    </a>
                    <a href="{{ route('ws.service-request.index') }}" class="sc-quick-btn" style="background:#e3ecff;color:#032671;font-size:11px;padding:6px 12px;">
                        <i class="uil uil-plus-circle me-1"></i>New SR
                    </a>
                    <a href="{{ route('ws.appointment.index') }}" class="sc-quick-btn" style="background:#e6f4ea;color:#10863f;font-size:11px;padding:6px 12px;">
                        <i class="uil uil-calendar-alt me-1"></i>Appointment
                    </a>
                    <a href="{{ route('ws.workshop.job-list') }}" class="sc-quick-btn" style="background:#fff3e0;color:#e65100;font-size:11px;padding:6px 12px;">
                        <i class="uil uil-wrench me-1"></i>Job Cards
                    </a>
                    <a href="{{ route('inventory.purchase-orders') }}" class="sc-quick-btn" style="background:#e0f7fa;color:#006064;font-size:11px;padding:6px 12px;">
                        <i class="uil uil-shopping-cart me-1"></i>Purchase Order
                    </a>
                    <a href="{{ route('ws.alerts') }}" class="sc-quick-btn" style="background:#fdecea;color:#ea0027;font-size:11px;padding:6px 12px;">
                        <i class="uil uil-bell me-1"></i>All Alerts
                    </a>
                </div>
            </div>

            {{-- Stat Cards — 4 key metrics in one compact row --}}
            <div class="row g-2 mb-3">
                <div class="col-6 col-md-3">
                    <div class="sc-stat-card" style="padding:10px 14px;">
                        <div class="sc-stat-icon" style="background:#e3ecff;width:34px;height:34px;min-width:34px;">
                            <i class="uil uil-clipboard-alt" style="color:#032671;font-size:15px;"></i>
                        </div>
                        <div>
                            <div class="sc-stat-num" style="font-size:20px;">24</div>
                            <div class="sc-stat-lbl">Open Service Requests</div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="sc-stat-card" style="padding:10px 14px;">
                        <div class="sc-stat-icon" style="background:#fff3e0;width:34px;height:34px;min-width:34px;">
                            <i class="uil uil-wrench" style="color:#e65100;font-size:15px;"></i>
                        </div>
                        <div>
                            <div class="sc-stat-num" style="font-size:20px;">11</div>
                            <div class="sc-stat-lbl">Active Job Cards (WIP)</div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="sc-stat-card" style="padding:10px 14px;">
                        <div class="sc-stat-icon" style="background:#e6f4ea;width:34px;height:34px;min-width:34px;">
                            <i class="uil uil-check-circle" style="color:#10863f;font-size:15px;"></i>
                        </div>
                        <div>
                            <div class="sc-stat-num" style="font-size:20px;">8</div>
                            <div class="sc-stat-lbl">Ready for Delivery</div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="sc-stat-card" style="padding:10px 14px;">
                        <div class="sc-stat-icon" style="background:#fdecea;width:34px;height:34px;min-width:34px;">
                            <i class="uil uil-exclamation-triangle" style="color:#ea0027;font-size:15px;"></i>
                        </div>
                        <div>
                            <div class="sc-stat-num" style="font-size:20px;">5</div>
                            <div class="sc-stat-lbl">Overdue / Pending</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Secondary stats: small inline chips --}}
            <div class="d-flex flex-wrap gap-2 mb-3">
                <div style="background:#f3e5f5;border-radius:6px;padding:6px 14px;display:flex;align-items:center;gap:8px;">
                    <i class="uil uil-calendar-alt" style="color:#7b1fa2;font-size:14px;"></i>
                    <span style="font-size:12px;color:#7b1fa2;font-weight:600;">7</span>
                    <span style="font-size:11px;color:#555;">Today's Appointments</span>
                </div>
                <div style="background:#e0f7fa;border-radius:6px;padding:6px 14px;display:flex;align-items:center;gap:8px;">
                    <i class="uil uil-user-nurse" style="color:#006064;font-size:14px;"></i>
                    <span style="font-size:12px;color:#006064;font-weight:600;">6</span>
                    <span style="font-size:11px;color:#555;">Technicians Active</span>
                </div>
                <div style="background:#fff8e1;border-radius:6px;padding:6px 14px;display:flex;align-items:center;gap:8px;">
                    <i class="uil uil-box" style="color:#f57f17;font-size:14px;"></i>
                    <span style="font-size:12px;color:#f57f17;font-weight:600;">3</span>
                    <span style="font-size:11px;color:#555;">Low Stock Items</span>
                </div>
                <div style="background:#e8f5e9;border-radius:6px;padding:6px 14px;display:flex;align-items:center;gap:8px;">
                    <i class="uil uil-money-bill" style="color:#2e7d32;font-size:14px;"></i>
                    <span style="font-size:12px;color:#2e7d32;font-weight:600;">₹1.4L</span>
                    <span style="font-size:11px;color:#555;">Revenue This Month</span>
                </div>
            </div>

            {{-- ROW 1: Job Cards | Appointments + Critical Alerts --}}
            <div class="row g-3 mb-3">

                {{-- Active Job Cards --}}
                <div class="col-12 col-lg-8">
                    <div class="sc-card h-100">
                        <div class="sc-card-head d-flex align-items-center justify-content-between">
                            <span class="sc-card-title">Active Job Cards</span>
                            <a href="{{ route('ws.workshop.job-list') }}" class="btn btn-sm sc-btn-navy">View All</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table sc-table mb-0">
                                <thead>
                                    <tr>
                                        <th>Job Card #</th>
                                        <th>Vehicle</th>
                                        <th>Service Type</th>
                                        <th>Technician</th>
                                        <th>Status</th>
                                        <th>ETA</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $jobs = [
                                        ['JC-2401','TS09 AB1234','Engine Oil Change','Ravi Kumar','WIP','10 Apr'],
                                        ['JC-2402','TS09 CD5678','Tyre Replacement','Suresh M','WIP','10 Apr'],
                                        ['JC-2403','TS09 EF9012','Battery Change','Arjun S','Hold','11 Apr'],
                                        ['JC-2404','TS09 GH3456','PM Service','Ravi Kumar','Ready','10 Apr'],
                                        ['JC-2405','TS09 IJ7890','Brake Service','Murugan P','WIP','12 Apr'],
                                    ];
                                    @endphp
                                    @foreach($jobs as $job)
                                    <tr>
                                        <td><a href="{{ route('ws.workshop.job-details', 1) }}" class="text-primary fw-semibold">{{ $job[0] }}</a></td>
                                        <td>{{ $job[1] }}</td>
                                        <td>{{ $job[2] }}</td>
                                        <td>{{ $job[3] }}</td>
                                        <td>
                                            @if($job[4] === 'WIP')
                                                <span class="sc-badge-wip">WIP</span>
                                            @elseif($job[4] === 'Hold')
                                                <span class="sc-badge-open">Hold</span>
                                            @else
                                                <span class="sc-badge-done">Ready</span>
                                            @endif
                                        </td>
                                        <td>{{ $job[5] }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Right col: Appointments + Overdue Alerts --}}
                <div class="col-12 col-lg-4">

                    {{-- Today's Appointments --}}
                    <div class="sc-card mb-3">
                        <div class="sc-card-head d-flex align-items-center justify-content-between">
                            <span class="sc-card-title">Today's Appointments</span>
                            <a href="{{ route('ws.appointment.index') }}" class="btn btn-sm sc-btn-navy">View All</a>
                        </div>
                        @php
                        $appts = [
                            ['09:00','TS09 AB1234','PM Service','Confirmed'],
                            ['10:30','TS09 KL2345','Tyre Change','Confirmed'],
                            ['11:00','TS09 MN6789','Battery','Pending'],
                            ['14:00','TS09 OP0123','Engine Oil','Confirmed'],
                        ];
                        @endphp
                        @foreach($appts as $a)
                        <div class="appt-mini-row">
                            <div>
                                <div class="fw-semibold" style="font-size:12px;">{{ $a[1] }}</div>
                                <div class="text-muted" style="font-size:11px;">{{ $a[2] }}</div>
                            </div>
                            <div class="text-end">
                                <div class="fw-semibold" style="font-size:12px;">{{ $a[0] }}</div>
                                <span class="sc-badge-{{ $a[3]==='Confirmed'?'done':'open' }}" style="font-size:10px;">{{ $a[3] }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    {{-- Overdue + Maintenance Alerts (combined) --}}
                    <div class="sc-card">
                        <div class="sc-card-head d-flex align-items-center justify-content-between">
                            <span class="sc-card-title">Alerts</span>
                            <a href="{{ route('ws.alerts') }}" class="btn btn-sm" style="background:#fdecea;color:#ea0027;font-size:10px;">View All</a>
                        </div>
                        @php
                        $alerts = [
                            ['JC-2026-0046','1 day overdue job','#ea0027','Critical'],
                            ['TS09 AB1234','Engine oil overdue 500 KM','#e65100','PM Due'],
                            ['TS09 EF9012','Tyre rotation due','#f57f17','PM Due'],
                            ['TS09 QR4567','Battery check pending','#7b1fa2','Info'],
                        ];
                        @endphp
                        @foreach($alerts as $al)
                        <div class="alert-flag-row" style="padding:7px 0;">
                            <span class="alert-dot" style="background:{{ $al[2] }};"></span>
                            <div style="flex:1;min-width:0;">
                                <div class="fw-semibold" style="font-size:12px;">{{ $al[0] }}</div>
                                <div class="text-muted" style="font-size:11px;">{{ $al[1] }}</div>
                            </div>
                            <span style="font-size:10px;padding:2px 7px;border-radius:3px;white-space:nowrap;background:{{ $al[2] }}22;color:{{ $al[2] }};">{{ $al[3] }}</span>
                        </div>
                        @endforeach
                    </div>

                </div>

            </div>{{-- end row 1 --}}

            {{-- ROW 2: Technician Workload | Low Stock | PM Due --}}
            <div class="row g-3">

                {{-- Technician workload --}}
                <div class="col-12 col-md-4">
                    <div class="sc-card h-100">
                        <div class="sc-card-head">
                            <span class="sc-card-title">Technician Workload</span>
                        </div>
                        @php
                        $techs = [
                            ['Ravi Kumar','3 jobs',75,'#032671'],
                            ['Suresh M','2 jobs',50,'#10863f'],
                            ['Arjun S','2 jobs',50,'#e65100'],
                            ['Murugan P','1 job',25,'#7b1fa2'],
                            ['Karthik B','1 job',25,'#006064'],
                        ];
                        @endphp
                        @foreach($techs as $t)
                        <div class="px-3 py-2 border-bottom">
                            <div class="d-flex justify-content-between mb-1" style="font-size:12px;">
                                <span class="fw-semibold">{{ $t[0] }}</span>
                                <span class="text-muted">{{ $t[1] }}</span>
                            </div>
                            <div class="tech-bar-wrap">
                                <div class="tech-bar" style="width:{{ $t[2] }}%;background:{{ $t[3] }};"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Low Stock --}}
                <div class="col-12 col-md-4">
                    <div class="sc-card h-100">
                        <div class="sc-card-head d-flex align-items-center justify-content-between">
                            <span class="sc-card-title">Low Stock Alerts</span>
                            <a href="{{ route('inventory.spare-parts') }}" class="btn btn-sm sc-btn-navy">Inventory</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table sc-table mb-0">
                                <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th>Qty</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $stock = [
                                        ['Engine Oil 15W40',2,'critical'],
                                        ['Air Filter – MH25',1,'critical'],
                                        ['Battery 12V 88Ah',3,'low'],
                                        ['Tyre 235/75 R17',4,'low'],
                                    ];
                                    @endphp
                                    @foreach($stock as $s)
                                    <tr>
                                        <td style="font-size:12px;">{{ $s[0] }}</td>
                                        <td class="fw-semibold">{{ $s[1] }}</td>
                                        <td><span class="stock-chip {{ $s[2] }}">{{ ucfirst($s[2]) }}</span></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- PM Due / Overdue --}}
                <div class="col-12 col-md-4">
                    <div class="sc-card h-100">
                        <div class="sc-card-head d-flex align-items-center justify-content-between">
                            <span class="sc-card-title">PM Due / Overdue</span>
                            <a href="{{ route('ws.maintenance.pm-calendar') }}" class="btn btn-sm sc-btn-navy">Calendar</a>
                        </div>
                        @php
                        $pmDue = [
                            ['TS09 AB1234','Engine Oil Change','Overdue 4,080 KM','#ea0027'],
                            ['UP32 BT5544','Wheel Alignment','Overdue 5,100 KM','#ea0027'],
                            ['MH12 XY9876','Brake Inspection','Due in 3 days','#e65100'],
                            ['RJ14 GA1111','Filter Change','Due in 3 days','#e65100'],
                        ];
                        @endphp
                        @foreach($pmDue as $pm)
                        <div class="alert-flag-row" style="padding:8px 12px;">
                            <span class="alert-dot" style="background:{{ $pm[3] }};"></span>
                            <div>
                                <div class="fw-semibold" style="font-size:12px;">{{ $pm[0] }}</div>
                                <div style="font-size:11px;color:#555;">{{ $pm[1] }} · <span style="color:{{ $pm[3] }};">{{ $pm[2] }}</span></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>{{-- end row 2 --}}

        </div>{{-- end main-wrap --}}
    </div>{{-- end wrapper --}}
</div>{{-- end layout-wrapper --}}
@endsection

@section('js')
<script src="{{ asset('js/Workshop/dashboard.js?v=1.0') }}"></script>

<script>
$(function () {
    // future chart hooks go here
});
</script>
@endsection
