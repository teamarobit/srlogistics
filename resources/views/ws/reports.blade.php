@extends('layouts.app')

@section('css')
<link href="{{ asset('css/Workshop/reports.css?v=1.0') }}" rel="stylesheet">
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
                    <li class="breadcrumb-item active">Reports</li>
                </ol>
            </nav>

            <div class="sc-page-head d-flex align-items-center justify-content-between mb-3">
                <div>
                    <h5 class="mb-0">SC Reports</h5>
                    <span class="text-muted" style="font-size:12px;">Generate and export service centre reports</span>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <label class="sc-form-label mb-0 me-1" style="font-size:12px;">Period</label>
                    <select class="form-select form-select-sm" style="width:160px;">
                        <option>This Month (Apr 2026)</option>
                        <option>Last Month (Mar 2026)</option>
                        <option>Last 3 Months</option>
                        <option>This Financial Year</option>
                        <option>Custom Range</option>
                    </select>
                </div>
            </div>

            @php
            $reportGroups = [
                [
                    'label' => 'Workshop Reports',
                    'color' => '#032671',
                    'bg'    => '#e3ecff',
                    'icon'  => 'uil-wrench',
                    'reports' => [
                        ['Job Card Summary','Overview of all job cards — status breakdown, completion rate, avg turnaround time','Last generated: 10-Apr-2026'],
                        ['Labour Cost Report','Labour hours logged, technician-wise cost, total labour billing','Last generated: 10-Apr-2026'],
                        ['Parts Usage Report','Parts consumed, quantity, cost, inventory deductions by vehicle','Last generated: 09-Apr-2026'],
                        ['Technician Performance','Jobs completed, hours logged, efficiency, SLA adherence per technician','Last generated: 07-Apr-2026'],
                    ],
                ],
                [
                    'label' => 'Maintenance Reports',
                    'color' => '#10863f',
                    'bg'    => '#e6f4ea',
                    'icon'  => 'uil-calendar-alt',
                    'reports' => [
                        ['PM Compliance Report','Vehicles with PM done on time vs overdue, compliance percentage by fleet','Last generated: 08-Apr-2026'],
                        ['Vehicle Downtime Report','Days each vehicle was in workshop or off-road, downtime cost estimate','Last generated: 08-Apr-2026'],
                        ['Insurance Expiry Report','Policies expiring in next 30/60/90 days, renewal action list','Last generated: 05-Apr-2026'],
                    ],
                ],
                [
                    'label' => 'Inventory Reports',
                    'color' => '#E65100',
                    'bg'    => '#fff3e0',
                    'icon'  => 'uil-box',
                    'reports' => [
                        ['Stock Valuation Report','Current inventory value by category (parts, tyres, batteries)','Last generated: 10-Apr-2026'],
                        ['Low Stock Report','Items below reorder level with recommended order quantities','Last generated: 10-Apr-2026'],
                        ['Purchase Order Summary','PO status, vendor-wise spend, GRN reconciliation','Last generated: 07-Apr-2026'],
                        ['Parts Movement Report','Inward (GRN) vs outward (issued to job cards) movement per item','Last generated: 05-Apr-2026'],
                    ],
                ],
                [
                    'label' => 'External Workshop Reports',
                    'color' => '#7b1fa2',
                    'bg'    => '#f3e5f5',
                    'icon'  => 'uil-store',
                    'reports' => [
                        ['External Dispatch Summary','Vehicles sent to external workshops — count, cost, TAT, warranty claims','Last generated: 07-Apr-2026'],
                        ['Warranty Claims Report','Jobs done under warranty at brand AWS — vehicles, amounts saved','Last generated: 01-Apr-2026'],
                    ],
                ],
            ];
            @endphp

            @foreach($reportGroups as $group)
            <div class="sc-report-section-label">{{ $group['label'] }}</div>
            <div class="row g-3 mb-4">
                @foreach($group['reports'] as $r)
                <div class="col-lg-3 col-md-6">
                    <div class="sc-report-card">
                        <div class="sc-report-icon" style="background:{{ $group['bg'] }};">
                            <i class="uil {{ $group['icon'] }}" style="color:{{ $group['color'] }};"></i>
                        </div>
                        <div class="sc-report-title">{{ $r[0] }}</div>
                        <div class="sc-report-desc">{{ $r[1] }}</div>
                        <div class="sc-report-meta">{{ $r[2] }}</div>
                        <div class="d-flex gap-2 mt-3">
                            <button class="btn sc-btn-navy btn-sm flex-grow-1" style="font-size:11px;"><i class="uil uil-eye me-1"></i>View</button>
                            <button class="btn btn-outline-secondary btn-sm" style="font-size:11px;" title="Export Excel"><i class="uil uil-file-alt"></i></button>
                            <button class="btn btn-outline-secondary btn-sm" style="font-size:11px;" title="Export PDF"><i class="uil uil-file-pdf-alt"></i></button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endforeach

        </div>
    </div>
</div>
@endsection
