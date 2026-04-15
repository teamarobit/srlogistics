@extends('layouts.app')

@section('css')
<link href="{{ asset('css/Workshop/alerts.css?v=1.0') }}" rel="stylesheet">
@endsection

@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="wrapper srlog-bdwrapper">
        <div class="main-wrap sc-no-sidebar">

            <nav aria-label="breadcrumb" class="mb-2">
                <ol class="breadcrumb sc-breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ws.dashboard') }}">Workshop</a></li>
                    <li class="breadcrumb-item active">Alerts</li>
                </ol>
            </nav>

            <div class="sc-page-head d-flex align-items-center justify-content-between mb-3">
                <div>
                    <h5 class="mb-0">SC Alerts Centre</h5>
                    <span class="text-muted" style="font-size:12px;">All active alerts across Workshop, Maintenance, Inventory, and Insurance</span>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-secondary btn-sm"><i class="uil uil-check-circle me-1"></i> Dismiss All Read</button>
                </div>
            </div>

            {{-- Summary Chips --}}
            <div class="d-flex flex-wrap gap-2 mb-3">
                <span class="badge" style="background:#fdecea;color:#EA0027;font-size:12px;padding:6px 14px;">🔴 Critical: 9</span>
                <span class="badge" style="background:#fff3e0;color:#E65100;font-size:12px;padding:6px 14px;">🟠 Warning: 14</span>
                <span class="badge" style="background:#e3ecff;color:#032671;font-size:12px;padding:6px 14px;">🔵 Info: 7</span>
            </div>

            <div class="row g-3">
                <div class="col-lg-6">

                    {{-- Overdue Jobs --}}
                    <div class="sc-card mb-3">
                        <div class="sc-alert-section-head mb-3">
                            <span><i class="uil uil-wrench me-2"></i>Overdue Job Cards</span>
                            <span class="sc-alert-count sc-alert-count-red">4</span>
                        </div>
                        @php $overdueJobs = [
                            ['JC-2026-0046','DL-01-CD-4567','Bharat Benz 2523','1 day overdue','Est. delivery was 10-Apr'],
                            ['JC-2026-0041','TN01-AB-1234','Tata Prima','3 days overdue','Est. delivery was 08-Apr'],
                            ['JC-2026-0039','MH-08-PQ-3456','Ashok Leyland 1916','5 days overdue','Est. delivery was 06-Apr'],
                            ['JC-2026-0036','RJ-14-GA-1111','Eicher Pro 3015','7 days overdue','Est. delivery was 04-Apr'],
                        ]; @endphp
                        @foreach($overdueJobs as $j)
                        <div class="sc-alert-row">
                            <div class="sc-alert-dot sc-alert-critical"></div>
                            <div class="sc-alert-body">
                                <div class="sc-alert-title"><a href="{{ route('ws.workshop.job-details', 1) }}" class="text-decoration-none text-dark">{{ $j[0] }}</a> — <span class="sc-reg-badge" style="font-size:11px;">{{ $j[1] }}</span></div>
                                <div class="sc-alert-sub">{{ $j[2] }} &nbsp;·&nbsp; <span class="text-danger">{{ $j[3] }}</span> &nbsp;·&nbsp; {{ $j[4] }}</div>
                            </div>
                            <div class="sc-alert-action">
                                <span class="sc-sev-critical">Critical</span>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    {{-- PM Due --}}
                    <div class="sc-card mb-3">
                        <div class="sc-alert-section-head mb-3">
                            <span><i class="uil uil-calendar-alt me-2"></i>PM Due / Overdue</span>
                            <span class="sc-alert-count sc-alert-count-amber">7</span>
                        </div>
                        @php $pmAlerts = [
                            ['KA-05-AB-1234','Tata Prima 4928','Engine Oil Change','Overdue by 4,080 KM','Last done at 1,10,500 KM'],
                            ['UP-32-BT-5544','Volvo FH 400','Wheel Alignment','Overdue by 5,100 KM','Last done at 2,05,200 KM'],
                            ['MH-12-XY-9876','Ashok Leyland 1916','Brake Inspection','Due in 3 days','Due date: 14 Apr 2026'],
                            ['RJ-14-GA-1111','Eicher Pro 3015','Filter Change','Due in 3 days','Due date: 14 Apr 2026'],
                        ]; @endphp
                        @foreach($pmAlerts as $pm)
                        <div class="sc-alert-row">
                            <div class="sc-alert-dot {{ str_contains($pm[3],'Overdue') ? 'sc-alert-critical' : 'sc-alert-warning' }}"></div>
                            <div class="sc-alert-body">
                                <div class="sc-alert-title"><span class="sc-reg-badge" style="font-size:11px;">{{ $pm[0] }}</span> — {{ $pm[2] }}</div>
                                <div class="sc-alert-sub">{{ $pm[1] }} &nbsp;·&nbsp; <span class="{{ str_contains($pm[3],'Overdue') ? 'text-danger' : 'text-warning' }}">{{ $pm[3] }}</span> &nbsp;·&nbsp; {{ $pm[4] }}</div>
                            </div>
                            <div class="sc-alert-action">
                                <span class="{{ str_contains($pm[3],'Overdue') ? 'sc-sev-critical' : 'sc-sev-warning' }}">{{ str_contains($pm[3],'Overdue') ? 'Overdue' : 'Due Soon' }}</span>
                            </div>
                        </div>
                        @endforeach
                        <div class="text-center mt-2"><a href="{{ route('ws.maintenance.pm-calendar') }}" class="btn btn-sm btn-outline-secondary" style="font-size:11px;">View PM Calendar →</a></div>
                    </div>

                </div>

                <div class="col-lg-6">

                    {{-- Insurance Expiry --}}
                    <div class="sc-card mb-3">
                        <div class="sc-alert-section-head mb-3">
                            <span><i class="uil uil-shield me-2"></i>Insurance Expiry</span>
                            <span class="sc-alert-count sc-alert-count-red">3</span>
                        </div>
                        @php $insAlerts = [
                            ['KA-05-AB-1234','Tata Prima','Expired 11 days ago','31-Mar-2026','ICICI Lombard'],
                            ['MH-12-XY-9876','Ashok Leyland','Expires in 3 days','14-Apr-2026','New India'],
                            ['RJ-14-GA-1111','Eicher Pro 3015','Expires in 3 days','14-Apr-2026','ICICI Lombard'],
                        ]; @endphp
                        @foreach($insAlerts as $ins)
                        <div class="sc-alert-row">
                            <div class="sc-alert-dot {{ str_contains($ins[2],'Expired ') ? 'sc-alert-critical' : 'sc-alert-warning' }}"></div>
                            <div class="sc-alert-body">
                                <div class="sc-alert-title"><span class="sc-reg-badge" style="font-size:11px;">{{ $ins[0] }}</span> — {{ $ins[1] }}</div>
                                <div class="sc-alert-sub"><span class="{{ str_contains($ins[2],'Expired ') ? 'text-danger' : 'text-warning' }}">{{ $ins[2] }}</span> &nbsp;·&nbsp; Expiry: {{ $ins[3] }} &nbsp;·&nbsp; {{ $ins[4] }}</div>
                            </div>
                            <div class="sc-alert-action">
                                <span class="{{ str_contains($ins[2],'Expired ') ? 'sc-sev-critical' : 'sc-sev-warning' }}">{{ str_contains($ins[2],'Expired ') ? 'Expired' : 'Expiring' }}</span>
                            </div>
                        </div>
                        @endforeach
                        <div class="text-center mt-2"><a href="{{ route('ws.maintenance.insurance') }}" class="btn btn-sm btn-outline-secondary" style="font-size:11px;">View Insurance Tracker →</a></div>
                    </div>

                    {{-- Low Stock --}}
                    <div class="sc-card mb-3">
                        <div class="sc-alert-section-head mb-3">
                            <span><i class="uil uil-box me-2"></i>Low / Out of Stock</span>
                            <span class="sc-alert-count">5</span>
                        </div>
                        @php $stockAlerts = [
                            ['Engine Oil 15W-40 (5L)','Lubricants','Current: 2 units','Reorder level: 10','critical'],
                            ['Air Filter — MH Bharat Benz','Filters','Current: 1 unit','Reorder level: 5','critical'],
                            ['Brake Pads Front — Bosch','Brakes','Current: 3 sets','Reorder level: 8','warning'],
                            ['Battery 12V 88Ah','Batteries','Current: 3 units','Reorder level: 6','warning'],
                        ]; @endphp
                        @foreach($stockAlerts as $st)
                        <div class="sc-alert-row">
                            <div class="sc-alert-dot {{ $st[4]==='critical' ? 'sc-alert-critical' : 'sc-alert-warning' }}"></div>
                            <div class="sc-alert-body">
                                <div class="sc-alert-title">{{ $st[0] }} <span class="text-muted fw-normal" style="font-size:11px;">— {{ $st[1] }}</span></div>
                                <div class="sc-alert-sub">{{ $st[2] }} &nbsp;·&nbsp; {{ $st[3] }}</div>
                            </div>
                            <div class="sc-alert-action">
                                <span class="{{ $st[4]==='critical' ? 'sc-sev-critical' : 'sc-sev-warning' }}">{{ ucfirst($st[4]) }}</span>
                            </div>
                        </div>
                        @endforeach
                        <div class="text-center mt-2"><a href="{{ route('inventory.spare-parts') }}" class="btn btn-sm btn-outline-secondary" style="font-size:11px;">View Inventory →</a></div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
