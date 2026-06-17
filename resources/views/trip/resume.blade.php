@extends('layouts.app')

@section('css')
{{-- Reuses td2-resume-* / td2-veh-card / td2-alloc styles from show-v2.css --}}
<link href="{{ asset('css/trip/show-v2.css?v=9.5') }}" rel="stylesheet">
<link href="{{ asset('css/trip/resume.css?v=3.7') }}" rel="stylesheet">
@endsection

@section('content')
<div class="layout-wrapper">

    @include('includes.header')

    @php
        /* Prototype trip context (client-side prototype — parity with the rest of this page). */
        $rsSummary = [
            'route'        => 'Kolkata → Mumbai',
            'vehicle'      => 'WB-20-GH-3456',
            'driver'       => 'Suresh Patel · +91 90000 11111',
            'paused_since' => '17 Jun 2026, 09:42',
            'pause_reason' => 'Breakdown reported via SOS',
        ];
    @endphp

    <div class="srlog-bdwrapper td2-resume-page">

        {{-- Page Header --}}
        <div class="top-text">
            <div class="container-fluid">
                <div class="rs-head">
                    <div class="rs-head-left">
                        <div class="rs-head-titlewrap">
                            <h1>Resume Trip</h1>
                            <span class="rs-status-badge"><span class="rs-status-dot"></span>Paused</span>
                        </div>
                        <div class="td2-resume-breadcrumb">Freight &rsaquo; Trips &rsaquo; Trip #{{ $trip }} &rsaquo; Resume</div>
                    </div>
                    <a href="{{ route('trip.details', $trip) }}" class="btn btn-sm btn-outline-secondary">
                        <i class="uil uil-arrow-left me-1"></i>Back to Trip
                    </a>
                </div>
            </div>
        </div>

        <div class="container-fluid rs-shell">

            <form id="resumeTripForm" class="td2-resume-form" data-details-url="{{ route('trip.details', $trip) }}">
                <div class="row g-4">

                    {{-- ───────────── MAIN COLUMN ───────────── --}}
                    <div class="col-lg-8 rs-main">

                        {{-- Section 1: Resume details + further action --}}
                        <div class="rs-section-card mb-4">
                            <div class="rs-section-header">
                                <div class="rs-section-icon"><i class="uil uil-play-circle"></i></div>
                                <div>
                                    <h6 class="rs-section-title">Resume Details</h6>
                                    <p class="rs-section-sub">
                                        Confirm when the trip resumes, then choose whether to continue as-is or re-allocate.
                                    </p>
                                </div>
                            </div>

                            <div class="rs-section-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Resume Date</label>
                                        <input type="date" class="form-control" id="td2ResumeDate" name="resume_date">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Resume Time</label>
                                        <input type="time" class="form-control" id="td2ResumeTime" name="resume_time">
                                    </div>

                                    {{-- Further action --}}
                                    <div class="col-12">
                                        <label class="form-label d-block">Further action</label>
                                        <div class="td2-resume-action-grid" id="td2ResumeActionGrid">
                                            <label class="td2-resume-action">
                                                <input type="radio" name="resume_action" value="resume_only" checked>
                                                <span><i class="uil uil-play"></i> Resume only</span>
                                            </label>
                                            <label class="td2-resume-action">
                                                <input type="radio" name="resume_action" value="change_vehicle">
                                                <span><i class="uil uil-truck"></i> Resume + change vehicle</span>
                                            </label>
                                            <label class="td2-resume-action">
                                                <input type="radio" name="resume_action" value="change_driver">
                                                <span><i class="uil uil-user"></i> Resume + change driver</span>
                                            </label>
                                            <label class="td2-resume-action">
                                                <input type="radio" name="resume_action" value="change_both">
                                                <span><i class="uil uil-exchange"></i> Resume + change both</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Section 2: Allocate Vehicle (change_vehicle / change_both) --}}
                        <div class="rs-section-card mb-4 d-none" id="td2ResumeVehicleWrap">
                            <div class="rs-section-header">
                                <div class="rs-section-icon"><i class="uil uil-truck"></i></div>
                                <div>
                                    <h6 class="rs-section-title">Allocate Vehicle</h6>
                                    <p class="rs-section-sub">
                                        Only vehicles not currently assigned to another ongoing trip are listed.
                                    </p>
                                </div>
                            </div>

                            <div class="rs-section-body">

                                {{-- Note: effect of changing the vehicle (top of card) --}}
                                <div class="td2-resume-note td2-resume-note-amber mb-3">
                                    <i class="uil uil-info-circle"></i>
                                    <span>Selecting the vehicle will unassign the vehicle's driver and assign the current driver to selected vehicle.</span>
                                </div>

                                {{-- Part A: Suggested Vehicles --}}
                                <div class="td2-section">
                                    <div class="accordion td2-veh-accordion" id="td2ResumeSuggestedVeh">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header mb-2">
                                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#td2ResumeVehCollapse">
                                                    <i class="uil uil-bolt-alt td2-veh-acc-icon"></i>
                                                    <span class="td2-veh-acc-title">Select from Suggested Vehicles</span>
                                                    <span class="td2-veh-acc-count">3</span>
                                                    <span class="td2-veh-acc-pill">Recommended</span>
                                                </button>
                                            </h2>
                                            <div id="td2ResumeVehCollapse" class="accordion-collapse collapse show">
                                                <div class="accordion-body p-0">
                                                    @php
                                                        $resumeSuggested = [
                                                            ['WB-12-AB-1237','green','Ashok Ray','+91 8879402641','green','10 Mo','empty','Empty ✓','Yes','Kolkata','5th','10 Years 5 Months'],
                                                            ['WB-34-CD-5678','red','Ranjit Das','+91 9432101234','yellow','4 Mo','onway','Not Empty ✗','On the Way (2 days)','Mumbai','3rd','7 Years 2 Months'],
                                                            ['WB-56-EF-9012','yellow','Manoj Kumar','+91 7654321098','green','14 Mo','empty','Empty ✓','Yes','Durgapur','8th','4 Years 9 Months'],
                                                        ];
                                                    @endphp
                                                    @foreach ($resumeSuggested as $i => $rv)
                                                    <div class="td2-veh-card-wrap">
                                                        <input type="radio" name="td2ResumeVehSelect" id="td2ResumeVeh{{ $i }}" class="td2-veh-radio td2-resume-veh-pick" value="{{ $rv[0] }}">
                                                        <label for="td2ResumeVeh{{ $i }}" class="td2-veh-card td2-veh-card-{{ $rv[1] }}">
                                                            <div class="td2-vc-header">
                                                                <div class="td2-vc-num">{{ $rv[0] }}</div>
                                                            </div>
                                                            <div class="td2-vc-grid">
                                                                <div class="td2-vc-item"><span class="td2-vc-label">Driver Name</span><span class="td2-vc-val">{{ $rv[2] }}</span></div>
                                                                <div class="td2-vc-item"><span class="td2-vc-label">Driver Number</span><span class="td2-vc-val">{{ $rv[3] }}</span></div>
                                                                <div class="td2-vc-item"><span class="td2-vc-label">About Driver</span><span class="td2-vc-val"><span class="td2-bhv-wrap"><span class="td2-bhv-dot td2-bhv-{{ $rv[4] }}"></span><span class="td2-bhv-label">Behaviour</span><span class="td2-bhv-exp">{{ $rv[5] }}</span></span></span></div>
                                                                <div class="td2-vc-item"><span class="td2-vc-label">Status</span><span class="td2-vc-val"><span class="td2-veh-status-{{ $rv[6] }}">{{ $rv[7] }}</span></span></div>
                                                                <div class="td2-vc-item"><span class="td2-vc-label">Availability</span><span class="td2-vc-val">{{ $rv[8] }}</span></div>
                                                                <div class="td2-vc-item"><span class="td2-vc-label">Live Location</span><span class="td2-vc-val">{{ $rv[9] }}</span></div>
                                                                <div class="td2-vc-item"><span class="td2-vc-label">Vehicle Rank</span><span class="td2-vc-val">{{ $rv[10] }}</span></div>
                                                                <div class="td2-vc-item"><span class="td2-vc-label">Associated Since</span><span class="td2-vc-val">{{ $rv[11] }}</span></div>
                                                            </div>
                                                        </label>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- OR Divider --}}
                                <div class="td2-or-divider"><span>OR</span></div>

                                {{-- Part C: Add / Allocate Vehicle --}}
                                <div class="td2-section td2-alloc-section">
                                    <div class="td2-alloc-head">
                                        <span class="td2-alloc-head-icon"><i class="uil uil-truck"></i></span>
                                        <div class="td2-alloc-head-text">
                                            <p class="td2-alloc-head-title">Add / Allocate Vehicle</p>
                                            <p class="td2-alloc-head-sub">Pick a vehicle from your own fleet or assign an external vendor vehicle to this trip.</p>
                                        </div>
                                    </div>

                                    <div class="td2-alloc-source mb-3">
                                        <span class="td2-alloc-source-label">Select any of these below</span>
                                        <div class="td2-veh-type-toggle">
                                            <input type="radio" name="td2ResumeVehType" id="td2ResumeOwnVeh" value="Own" class="td2-vtype-radio td2-resume-own-veh" checked>
                                            <label for="td2ResumeOwnVeh" class="td2-vtype-label">Own Vehicle</label>
                                            <input type="radio" name="td2ResumeVehType" id="td2ResumeExtVeh" value="External" class="td2-vtype-radio td2-resume-ext-veh">
                                            <label for="td2ResumeExtVeh" class="td2-vtype-label">External / Vendor</label>
                                        </div>
                                    </div>

                                    @php
                                        /* Prototype vehicle meta — drives the detail card shown after a vehicle is picked. */
                                        $resumeVehMeta = [
                                            'WB-12-AB-1237' => ['driver'=>'Ashok Ray','phone'=>'+91 8879402641','rag'=>'green','bhv'=>'green','bhvExp'=>'10 Mo','status'=>'empty','statusLabel'=>'Empty ✓','avail'=>'Yes','loc'=>'Kolkata','rank'=>'5th','since'=>'10 Years 5 Months'],
                                            'WB-34-CD-5678' => ['driver'=>'Ranjit Das','phone'=>'+91 9432101234','rag'=>'red','bhv'=>'yellow','bhvExp'=>'4 Mo','status'=>'onway','statusLabel'=>'Not Empty ✗','avail'=>'On the Way (2 days)','loc'=>'Mumbai','rank'=>'3rd','since'=>'7 Years 2 Months'],
                                            'WB-56-EF-9012' => ['driver'=>'Manoj Kumar','phone'=>'+91 7654321098','rag'=>'yellow','bhv'=>'green','bhvExp'=>'14 Mo','status'=>'empty','statusLabel'=>'Empty ✓','avail'=>'Yes','loc'=>'Durgapur','rank'=>'8th','since'=>'4 Years 9 Months'],
                                            'WB-99-ZZ-0001' => ['driver'=>'Bikash Mondal','phone'=>'+91 9000012345','rag'=>'green','bhv'=>'green','bhvExp'=>'8 Mo','status'=>'empty','statusLabel'=>'Empty ✓','avail'=>'Yes','loc'=>'Nagpur','rank'=>'—','since'=>'Vendor · ABC Logistics'],
                                            'DL-01-XX-5050' => ['driver'=>'Sandeep Yadav','phone'=>'+91 9000054321','rag'=>'yellow','bhv'=>'yellow','bhvExp'=>'5 Mo','status'=>'onway','statusLabel'=>'On the Way (1 day)','avail'=>'On the Way (1 day)','loc'=>'Delhi','rank'=>'—','since'=>'Vendor · XYZ Transport'],
                                        ];
                                    @endphp

                                    {{-- If Own Vehicle --}}
                                    <div class="td2-resume-if-own td2-alloc-body">
                                        <div class="mb-1">
                                            <label class="form-label">Select Vehicle</label>
                                            <select class="form-select td2-resume-veh-pick" id="td2ResumeOwnVehSelect">
                                                <option value="">Select vehicle...</option>
                                                @foreach (['WB-12-AB-1237','WB-34-CD-5678','WB-56-EF-9012'] as $reg)
                                                    @php $m = $resumeVehMeta[$reg]; @endphp
                                                    <option value="{{ $reg }}"
                                                        data-driver="{{ $m['driver'] }}" data-phone="{{ $m['phone'] }}"
                                                        data-rag="{{ $m['rag'] }}" data-bhv="{{ $m['bhv'] }}" data-bhv-exp="{{ $m['bhvExp'] }}"
                                                        data-status="{{ $m['status'] }}" data-status-label="{{ $m['statusLabel'] }}"
                                                        data-avail="{{ $m['avail'] }}" data-loc="{{ $m['loc'] }}"
                                                        data-rank="{{ $m['rank'] }}" data-since="{{ $m['since'] }}">{{ $reg }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    {{-- If External Vehicle --}}
                                    <div class="td2-resume-if-ext td2-alloc-body" style="display:none;">
                                        <div class="mb-2">
                                            <label class="form-label">Vendor</label>
                                            <div class="d-flex gap-2 align-items-center">
                                                <select class="form-select" id="td2ResumeExtVendorSelect">
                                                    <option value="">Select vendor...</option>
                                                    <option>ABC Logistics</option>
                                                    <option>XYZ Transport</option>
                                                    <option>MNC Logistics</option>
                                                </select>
                                                <a href="{{ route('contact.vehiclevendor.create') }}" target="_blank" rel="noopener" class="text-nowrap small">+ Add Vendor</a>
                                            </div>
                                        </div>
                                        <div class="mb-1">
                                            <label class="form-label">Vehicle</label>
                                            <div class="d-flex gap-2 align-items-center">
                                                <select class="form-select td2-resume-veh-pick" id="td2ResumeExtVehicleSelect">
                                                    <option value="">Select vehicle...</option>
                                                    @foreach (['WB-99-ZZ-0001','DL-01-XX-5050'] as $reg)
                                                        @php $m = $resumeVehMeta[$reg]; @endphp
                                                        <option value="{{ $reg }}"
                                                            data-driver="{{ $m['driver'] }}" data-phone="{{ $m['phone'] }}"
                                                            data-rag="{{ $m['rag'] }}" data-bhv="{{ $m['bhv'] }}" data-bhv-exp="{{ $m['bhvExp'] }}"
                                                            data-status="{{ $m['status'] }}" data-status-label="{{ $m['statusLabel'] }}"
                                                            data-avail="{{ $m['avail'] }}" data-loc="{{ $m['loc'] }}"
                                                            data-rank="{{ $m['rank'] }}" data-since="{{ $m['since'] }}">{{ $reg }}</option>
                                                    @endforeach
                                                </select>
                                                <a href="{{ route('vehiclemanagement.create') }}" target="_blank" rel="noopener" class="btn btn-outline-secondary btn-sm text-nowrap">+ Add Vehicle</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Selected vehicle detail card (Own / External) --}}
                                <div class="td2-resume-alloc-veh d-none" id="td2ResumeAllocVehWrap">
                                    <p class="td2-resume-driver-veh-title">Selected vehicle</p>
                                    <div id="td2ResumeAllocVehCard"></div>
                                </div>

                                {{-- Selection confirmation — appears once a vehicle is picked (selection IS the assignment, no separate Assign step) --}}
                                <div class="td2-resume-assign-wrap d-none" id="td2ResumeAssignWrap">
                                    <div class="td2-resume-assign-pick" id="td2ResumeAssignPick"></div>
                                </div>

                                <input type="hidden" id="td2ResumeAssignedVehicle" name="new_vehicle">
                                <span class="text-danger small d-block mt-1 td2-resume-err" data-for="vehicle"></span>
                            </div>
                        </div>

                        {{-- Section 3: Allocate Driver (change_driver / change_both) --}}
                        <div class="rs-section-card mb-4 d-none" id="td2ResumeDriverWrap">
                            <div class="rs-section-header">
                                <div class="rs-section-icon"><i class="uil uil-user"></i></div>
                                <div>
                                    <h6 class="rs-section-title">Allocate Driver</h6>
                                    <p class="rs-section-sub">
                                        Only drivers not currently assigned to another ongoing trip are listed.
                                    </p>
                                </div>
                            </div>

                            <div class="rs-section-body">
                                @php
                                    $resumeDrivers = [
                                        ['key' => 'd1', 'name' => 'Ashok Ray',    'phone' => '+91 88794 02641',
                                         'veh' => 'WB-12-AB-1237', 'rag' => 'green',  'bhv' => 'green',  'bhvExp' => '10 Mo',
                                         'status' => 'empty', 'statusLabel' => 'Empty ✓', 'avail' => 'Yes',
                                         'loc' => 'Kolkata',  'rank' => '5th', 'since' => '10 Years 5 Months'],
                                        ['key' => 'd2', 'name' => 'Ramesh Sahu',  'phone' => '+91 90381 11220',
                                         'veh' => 'WB-45-KL-2210', 'rag' => 'yellow', 'bhv' => 'yellow', 'bhvExp' => '6 Mo',
                                         'status' => 'onway', 'statusLabel' => 'On the Way (1 day)', 'avail' => 'On the Way (1 day)',
                                         'loc' => 'Ranchi',   'rank' => '3rd', 'since' => '6 Years 2 Months'],
                                        ['key' => 'd3', 'name' => 'Iqbal Khan',   'phone' => '+91 99320 44518',
                                         'veh' => 'WB-67-MN-8899', 'rag' => 'green',  'bhv' => 'green',  'bhvExp' => '14 Mo',
                                         'status' => 'empty', 'statusLabel' => 'Empty ✓', 'avail' => 'Yes',
                                         'loc' => 'Asansol',  'rank' => '7th', 'since' => '4 Years 1 Month'],
                                    ];
                                @endphp

                                {{-- Note: effect of changing the driver (above dropdown) --}}
                                <div class="td2-resume-note td2-resume-note-amber mb-3">
                                    <i class="uil uil-info-circle"></i>
                                    <span>Selecting driver will unassign the driver from the assigned vehicle and assign to the current (trip) vehicle.</span>
                                </div>

                                <select class="form-select select2-modal" id="td2ResumeDriverSelect" name="new_driver">
                                    <option value="">Select driver…</option>
                                    @foreach ($resumeDrivers as $rd)
                                    <option value="{{ $rd['name'] }} · {{ $rd['phone'] }}" data-driver-key="{{ $rd['key'] }}">{{ $rd['name'] }} · {{ $rd['phone'] }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger small d-block mt-1 td2-resume-err" data-for="driver"></span>

                                {{-- Selected driver's currently-assigned vehicle --}}
                                <div class="td2-resume-driver-veh d-none" id="td2ResumeDriverVehWrap">
                                    <p class="td2-resume-driver-veh-title">Driver's currently assigned vehicle</p>
                                    @foreach ($resumeDrivers as $rd)
                                    <div class="td2-veh-card td2-veh-card-{{ $rd['rag'] }} td2-resume-driver-veh-card d-none" data-driver-key="{{ $rd['key'] }}">
                                        <div class="td2-vc-header">
                                            <div class="td2-vc-num">{{ $rd['veh'] }}</div>
                                        </div>
                                        <div class="td2-vc-grid">
                                            <div class="td2-vc-item"><span class="td2-vc-label">Driver Name</span><span class="td2-vc-val">{{ $rd['name'] }}</span></div>
                                            <div class="td2-vc-item"><span class="td2-vc-label">Driver Number</span><span class="td2-vc-val">{{ $rd['phone'] }}</span></div>
                                            <div class="td2-vc-item"><span class="td2-vc-label">About Driver</span><span class="td2-vc-val"><span class="td2-bhv-wrap"><span class="td2-bhv-dot td2-bhv-{{ $rd['bhv'] }}"></span><span class="td2-bhv-label">Behaviour</span><span class="td2-bhv-exp">{{ $rd['bhvExp'] }}</span></span></span></div>
                                            <div class="td2-vc-item"><span class="td2-vc-label">Status</span><span class="td2-vc-val"><span class="td2-veh-status-{{ $rd['status'] }}">{{ $rd['statusLabel'] }}</span></span></div>
                                            <div class="td2-vc-item"><span class="td2-vc-label">Availability</span><span class="td2-vc-val">{{ $rd['avail'] }}</span></div>
                                            <div class="td2-vc-item"><span class="td2-vc-label">Live Location</span><span class="td2-vc-val">{{ $rd['loc'] }}</span></div>
                                            <div class="td2-vc-item"><span class="td2-vc-label">Vehicle Rank</span><span class="td2-vc-val">{{ $rd['rank'] }}</span></div>
                                            <div class="td2-vc-item"><span class="td2-vc-label">Associated Since</span><span class="td2-vc-val">{{ $rd['since'] }}</span></div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        {{-- Section 4: Reason & Note --}}
                        <div class="rs-section-card mb-4">
                            <div class="rs-section-header">
                                <div class="rs-section-icon"><i class="uil uil-comment-alt-notes"></i></div>
                                <div>
                                    <h6 class="rs-section-title">Reason &amp; Note</h6>
                                    <p class="rs-section-sub">Record why the trip is being resumed or re-allocated.</p>
                                </div>
                            </div>

                            <div class="rs-section-body">
                                <div class="row g-3">
                                    {{-- Reason (required) --}}
                                    <div class="col-12">
                                        <label class="form-label">Reason <span class="text-danger">*</span></label>
                                        <textarea class="form-control" id="td2ResumeReason" name="resume_reason"
                                                  rows="2" placeholder="Why is the trip being resumed / re-allocated?"></textarea>
                                        <span class="text-danger small d-block mt-1 td2-resume-err" data-for="reason"></span>
                                    </div>

                                    {{-- Note (optional) --}}
                                    <div class="col-12">
                                        <label class="form-label">Note <span class="text-muted small">(optional)</span></label>
                                        <input type="text" class="form-control" id="td2ResumeNote" name="resume_note"
                                               placeholder="Optional note">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>{{-- /.col-lg-8 --}}

                    {{-- ───────────── CONTEXT SIDEBAR ───────────── --}}
                    <div class="col-lg-4 rs-aside">
                        <div class="rs-aside-sticky">

                            {{-- Trip Summary --}}
                            <div class="rs-aside-card mb-4">
                                <div class="rs-aside-head">
                                    <i class="uil uil-newspaper"></i>
                                    <span>Trip Summary</span>
                                </div>
                                <div class="rs-aside-body">
                                    <div class="rs-summary-row">
                                        <span class="rs-summary-label">Status</span>
                                        <span class="rs-summary-val"><span class="rs-status-badge rs-status-badge-sm"><span class="rs-status-dot"></span>Paused</span></span>
                                    </div>
                                    <div class="rs-summary-row">
                                        <span class="rs-summary-label">Trip</span>
                                        <span class="rs-summary-val">#{{ $trip }}</span>
                                    </div>
                                    <div class="rs-summary-row">
                                        <span class="rs-summary-label">Route</span>
                                        <span class="rs-summary-val">{{ $rsSummary['route'] }}</span>
                                    </div>
                                    <div class="rs-summary-row">
                                        <span class="rs-summary-label">Current Vehicle</span>
                                        <span class="rs-summary-val">{{ $rsSummary['vehicle'] }}</span>
                                    </div>
                                    <div class="rs-summary-row">
                                        <span class="rs-summary-label">Current Driver</span>
                                        <span class="rs-summary-val">{{ $rsSummary['driver'] }}</span>
                                    </div>
                                    <div class="rs-summary-row">
                                        <span class="rs-summary-label">Paused Since</span>
                                        <span class="rs-summary-val">{{ $rsSummary['paused_since'] }}</span>
                                    </div>
                                    <div class="rs-summary-row rs-summary-row-block">
                                        <span class="rs-summary-label">Pause Reason</span>
                                        <span class="rs-summary-val">{{ $rsSummary['pause_reason'] }}</span>
                                    </div>
                                </div>
                            </div>

                            {{-- What happens on resume --}}
                            <div class="rs-aside-card rs-aside-help">
                                <div class="rs-aside-head">
                                    <i class="uil uil-info-circle"></i>
                                    <span>What happens on resume</span>
                                </div>
                                <div class="rs-aside-body">
                                    <ul class="rs-help-list">
                                        <li>The trip moves from <strong>Paused</strong> back to <strong>Ongoing</strong>.</li>
                                        <li>Status updates unlock for the route stages.</li>
                                        <li>If you re-allocate, the new vehicle / driver applies to the rest of the trip.</li>
                                        <li>A resume entry is added to the trip timeline with your reason.</li>
                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>{{-- /.col-lg-4 --}}

                </div>{{-- /.row --}}

                {{-- Sticky page action bar --}}
                <div class="td2-resume-actions">
                    <a href="{{ route('trip.details', $trip) }}" class="btn btn-secondary">Cancel</a>
                    <button type="button" class="btn btn-dark td2-resume-confirm-btn" id="td2ResumeConfirmBtn">
                        <i class="uil uil-play-circle me-1"></i> Resume Trip
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('js/Trip/resume.js?v=1.5') }}"></script>
@endsection
