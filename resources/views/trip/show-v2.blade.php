@extends('layouts.app')

@section('css')
<link href="{{ asset('css/fleet/vehicle-details-v2.css?v=5.6') }}" rel="stylesheet">
<link href="{{ asset('css/trip/show-v2.css?v=7.6') }}" rel="stylesheet">
@endsection

@section('content')
<div class="layout-wrapper">
    @include('includes.header')

    {{-- ═══════════════════════════════════════════════════════════════
         TRIP DETAILS v2
         #tripApp  — PROTO_CONFIG reads data-* attributes for all
         conditional visibility rules. See show-v2.js for details.
    ═══════════════════════════════════════════════════════════════ --}}
    <div class="srlog-bdwrapper v2-page td2-bdwrap" id="tripApp"
         data-trip-type="Own Booking"
         data-vehicle-type="Own"
         data-trip-status="In Transit"
         data-user-role="Admin"
         data-has-damage-pod="0">

        {{-- ═══════════════════════════════════════════════════════════
             V2 HEADER ZONE — matches system standard (tyre/fleet pages)
        ═══════════════════════════════════════════════════════════ --}}
        <div class="v2-header-zone">

            {{-- ── IDENTITY BAR ── --}}
            <div class="v2-id-bar">

                {{-- Trip icon --}}
                <div class="v2-id-icon-wrap">
                    <img src="{{ asset('images/icons/car-icon04.png') }}" alt="Trip">
                </div>

                {{-- Route + status --}}
                <div class="v2-id-main">
                    <div class="v2-id-vno">
                        Kolkata – Mumbai
                        <span class="v2-id-status td2-in-transit">In Transit</span>
                    </div>
                    <div class="v2-id-sub">
                        Created 25/10/2025 &nbsp;·&nbsp; Anmol Kaur &nbsp;·&nbsp;
                        <span style="background:#C8F3FF;border:1.5px dashed #4dc8f0;border-radius:5px;padding:1px 8px;font-size:10px;color:#2D2D2D;">
                            Vehicle Allocated: <strong style="color:#dc7a00;">Pending</strong>
                        </span>
                    </div>
                </div>

                <div class="v2-id-sep"></div>

                <div class="v2-id-field">
                    <span class="v2-id-field-label">Trip ID</span>
                    <span class="v2-id-field-value">#TRIP001</span>
                </div>

                <div class="v2-id-sep"></div>

                <div class="v2-id-field">
                    <span class="v2-id-field-label">Trip Date</span>
                    <span class="v2-id-field-value">25/10/2025</span>
                </div>

                <div class="v2-id-sep"></div>

                <div class="v2-id-field">
                    <span class="v2-id-field-label">Trip Type</span>
                    <span class="v2-id-field-value">Own Booking</span>
                </div>

                <div class="v2-id-sep"></div>

                <div class="v2-id-field">
                    <span class="v2-id-field-label">RAG Status</span>
                    <span class="v2-id-field-value"><span class="td2-rag td2-rag-red">Red</span></span>
                </div>

                {{-- Actions flush right --}}
                <div class="v2-id-actions">
                    <button class="v2-id-tag-btn" id="attachmentBtn" type="button">
                        <i class="uil uil-paperclip"></i> Attachments
                    </button>
                    {{-- Start Tracking: conditional — JS shows when trip_status = 'Vehicle Assigned' (dev-notes §5) --}}
                    <button class="v2-id-tag-btn" id="startTrackingBtn" type="button"
                            style="background:#e8f5e9;color:#198754;border-color:#86efac;">
                        <i class="uil uil-map-marker"></i> Start Tracking
                    </button>
                    <button class="v2-id-tag-btn" id="settleTripBtn" type="button"
                            data-bs-toggle="modal" data-bs-target="#closeTrip"
                            style="background:#d1fae5;color:#065f46;border-color:#6ee7b7;">
                        <i class="uil uil-check-circle"></i> Settle Trip
                    </button>
                    <button class="v2-id-tag-btn" id="cancelTripBtn" type="button"
                            data-bs-toggle="modal" data-bs-target="#cancelTrip"
                            style="background:#fee2e2;color:#991b1b;border-color:#fca5a5;">
                        <i class="uil uil-times-circle"></i> Cancel Trip
                    </button>
                </div>

            </div>{{-- /.v2-id-bar --}}

            {{-- ── TRIP LIFECYCLE STEPPER ── --}}
            <div class="td2-stepper-row">
                <div class="td2-stepper" id="td2Stepper">
                    <div class="td2-step td2-step-pending" data-status="Initiated">
                        <div class="td2-step-dot"></div>
                        <span class="td2-step-label">Initiated</span>
                    </div>
                    <div class="td2-step-line"></div>
                    <div class="td2-step td2-step-pending" data-status="Vehicle Assigned">
                        <div class="td2-step-dot"></div>
                        <span class="td2-step-label">Vehicle Assigned</span>
                    </div>
                    <div class="td2-step-line"></div>
                    <div class="td2-step td2-step-pending" data-status="Loading">
                        <div class="td2-step-dot"></div>
                        <span class="td2-step-label">Loading</span>
                    </div>
                    <div class="td2-step-line"></div>
                    <div class="td2-step td2-step-pending" data-status="In Transit">
                        <div class="td2-step-dot"></div>
                        <span class="td2-step-label">In Transit</span>
                    </div>
                    <div class="td2-step-line"></div>
                    <div class="td2-step td2-step-pending" data-status="Completed">
                        <div class="td2-step-dot"></div>
                        <span class="td2-step-label">Completed</span>
                    </div>
                </div>
            </div>

        </div>{{-- /.v2-header-zone --}}

        {{-- ───────────────────────────────────────────────────────────
             BODY — HORIZONTAL TABS + SIDEBAR
        ─────────────────────────────────────────────────────────── --}}
        <div class="td2-body">

            {{-- ── HORIZONTAL TAB NAV (sticky, below stepper) ── --}}
            <div class="td2-htab-wrap">
                <ul class="nav" id="td2Tab" role="tablist">

                    {{-- ── Operations group label ── --}}
                    <li class="td2-tab-group-label td2-group-ops mt-2" aria-hidden="true">
                        <i class="uil uil-truck"></i> Trip Status
                    </li>

                    {{-- ── Operations tabs ── --}}
                    <li class="nav-item">
                        <button class="nav-link td2-tab active" id="td2-tripInit-tab"
                                data-bs-toggle="pill" data-bs-target="#td2-tripInit"
                                type="button" role="tab">Trip Initiation</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link td2-tab" id="td2-vehAlloc-tab"
                                data-bs-toggle="pill" data-bs-target="#td2-vehAlloc"
                                type="button" role="tab">Vehicle Allocation</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link td2-tab" id="td2-vehStatus-tab"
                                data-bs-toggle="pill" data-bs-target="#td2-vehStatus"
                                type="button" role="tab">Vehicle Status</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link td2-tab" id="td2-ewayLr-tab"
                                data-bs-toggle="pill" data-bs-target="#td2-ewayLr"
                                type="button" role="tab">Eway + LR</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link td2-tab" id="td2-pod-tab"
                                data-bs-toggle="pill" data-bs-target="#td2-pod"
                                type="button" role="tab">POD</button>
                    </li>

                    {{-- ── Settlement group label ── --}}
                    <li class="td2-tab-group-label td2-group-fin mt-2" aria-hidden="true">
                        <i class="uil uil-bill"></i> Settlement
                    </li>

                    {{-- ── Financial / Settlement tabs (conditional visibility via JS) ── --}}
                    <li class="nav-item">
                        <button class="nav-link td2-tab td2-fin-tab" id="td2-tripPayout-tab"
                                data-bs-toggle="pill" data-bs-target="#td2-tripPayout"
                                type="button" role="tab"><i class="fa fa-money"></i> Trip Payout</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link td2-tab td2-fin-tab" id="td2-expenses-tab"
                                data-bs-toggle="pill" data-bs-target="#td2-expenses"
                                type="button" role="tab"><i class="fa fa-list-alt"></i> Expenses</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link td2-tab td2-fin-tab" id="td2-profitLoss-tab"
                                data-bs-toggle="pill" data-bs-target="#td2-profitLoss"
                                type="button" role="tab"><i class="fa fa-line-chart"></i> Profit or Loss</button>
                    </li>
                    {{-- Memo: Outside Booking only --}}
                    <li class="nav-item">
                        <button class="nav-link td2-tab td2-fin-tab" id="td2-memo-tab"
                                data-bs-toggle="pill" data-bs-target="#td2-memo"
                                type="button" role="tab"><i class="fa fa-sticky-note-o"></i> Memo</button>
                    </li>
                    {{-- Broker Payment: External vehicle only --}}
                    <li class="nav-item">
                        <button class="nav-link td2-tab td2-fin-tab" id="td2-brokerPayment-tab"
                                data-bs-toggle="pill" data-bs-target="#td2-brokerPayment"
                                type="button" role="tab"><i class="fa fa-handshake-o"></i> Broker Payment</button>
                    </li>

                </ul>
            </div>{{-- /.td2-htab-wrap --}}

            <div class="row g-0">

                {{-- LEFT: Tab content --}}
                <div class="col-md-9">
                    <div class="td2-hcontent">
                        <div class="tab-content" id="td2TabContent">

                            {{-- ─── TAB 1: Trip Initiation ─── --}}
                            <div class="tab-pane fade show active" id="td2-tripInit"
                                 role="tabpanel" aria-labelledby="td2-tripInit-tab">
                                <div class="td2-pane-header">
                                    <h5 class="td2-pane-title">Trip Initiations</h5>
                                    <a href="{{ route('trip.edit', 1) }}" class="td2-icon-btn" title="Edit Trip">
                                        <i class="uil uil-edit-alt"></i>
                                    </a>
                                </div>
                                <div class="td2-pane-body">

                                    {{-- Section 1: Info Grid --}}
                                    <div class="td2-section">
                                        <div class="row g-3">
                                            {{-- Row 1 --}}
                                            <div class="col-md-3 col-sm-6">
                                                <div class="td2-di">
                                                    <span class="td2-di-label">Trip ID</span>
                                                    <span class="td2-di-value">#001</span>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-6">
                                                <div class="td2-di">
                                                    <span class="td2-di-label">Trip Type</span>
                                                    <span class="td2-di-value">Own Booking</span>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-6">
                                                <div class="td2-di">
                                                    <span class="td2-di-label">Trip Category</span>
                                                    <span class="td2-di-value">Line</span>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-6">
                                                <div class="td2-di">
                                                    <span class="td2-di-label">Internal Trip ID</span>
                                                    <span class="td2-di-value">#001001765</span>
                                                </div>
                                            </div>

                                            {{-- Row 2 --}}
                                            <div class="col-md-3 col-sm-6">
                                                <div class="td2-di">
                                                    <span class="td2-di-label">Trip Date</span>
                                                    <span class="td2-di-value">25/10/2025</span>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-6">
                                                <div class="td2-di">
                                                    <span class="td2-di-label">RAG Status</span>
                                                    <span class="td2-di-value"><span class="td2-rag td2-rag-red">Red</span></span>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-6">
                                                <div class="td2-di">
                                                    <span class="td2-di-label">Load Vendor</span>
                                                    <span class="td2-di-value">Blue Dart</span>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-6">
                                                <div class="td2-di">
                                                    <span class="td2-di-label">Customer</span>
                                                    <span class="td2-di-value">Nestle</span>
                                                </div>
                                            </div>

                                            {{-- Row 3 --}}
                                            <div class="col-md-3 col-sm-6">
                                                <div class="td2-di">
                                                    <span class="td2-di-label">Vehicle Type</span>
                                                    <span class="td2-di-value">Large Truck</span>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-6">
                                                <div class="td2-di">
                                                    <span class="td2-di-label">Vehicle Size</span>
                                                    <span class="td2-di-value">14 FT – XXM 14M × 9M × 12M</span>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-6">
                                                <div class="td2-di">
                                                    <span class="td2-di-label">Consigner</span>
                                                    <span class="td2-di-value">Britania Kolkata</span>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-6">
                                                <div class="td2-di">
                                                    <span class="td2-di-label">Consignee</span>
                                                    <span class="td2-di-value">Samsung Hydrabad</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Section 2: Route Strip --}}
                                    <div class="td2-section td2-section-compact">
                                        <div class="td2-route-strip">
                                            <div class="td2-rs-stop">
                                                <span class="td2-rs-label">Source</span>
                                                <span class="td2-rs-dot td2-rs-dot-source"></span>
                                                <span class="td2-rs-name">Kolkata</span>
                                            </div>
                                            <span class="td2-rs-arrow">›</span>
                                            <div class="td2-rs-stop">
                                                <span class="td2-rs-label">Stop 1</span>
                                                <span class="td2-rs-dot td2-rs-dot-mid"></span>
                                                <span class="td2-rs-name">Kolaghat</span>
                                            </div>
                                            <span class="td2-rs-arrow">›</span>
                                            <div class="td2-rs-stop">
                                                <span class="td2-rs-label">Stop 2</span>
                                                <span class="td2-rs-dot td2-rs-dot-mid"></span>
                                                <span class="td2-rs-name">Patna</span>
                                            </div>
                                            <span class="td2-rs-arrow">›</span>
                                            <div class="td2-rs-stop">
                                                <span class="td2-rs-label">Destination</span>
                                                <span class="td2-rs-dot td2-rs-dot-dest"></span>
                                                <span class="td2-rs-name">Mumbai</span>
                                            </div>
                                        </div>
                                        <div class="row g-3">
                                            <div class="col-md-3 col-sm-6">
                                                <div class="td2-di">
                                                    <span class="td2-di-label">Route</span>
                                                    <span class="td2-di-value">Kolkata - Mumbai</span>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-6">
                                                <div class="td2-di">
                                                    <span class="td2-di-label">Distance</span>
                                                    <span class="td2-di-value">150 KM</span>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-6">
                                                <div class="td2-di">
                                                    <span class="td2-di-label">Priority</span>
                                                    <span class="td2-di-value"><span class="td2-priority td2-priority-urgent">Urgent</span></span>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-6">
                                                <div class="td2-di">
                                                    <span class="td2-di-label">Tarpaulin</span>
                                                    <span class="td2-di-value"><span class="td2-tarp-yes"><i class="uil uil-check-circle"></i> Yes</span></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Section 3: Comment --}}
                                    <div class="td2-section">
                                        <div class="td2-di">
                                            <span class="td2-di-label">Comment</span>
                                            <p class="td2-comment-text">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            {{-- ─── TAB 2: Vehicle Allocation ─── --}}
                            <div class="tab-pane fade" id="td2-vehAlloc"
                                 role="tabpanel" aria-labelledby="td2-vehAlloc-tab">
                                <div class="td2-pane-header">
                                    <h5 class="td2-pane-title">Vehicle Allocation</h5>
                                </div>
                                <div class="td2-pane-body">

                                    {{-- Part A: Suggested Vehicles Accordion --}}
                                    <div class="td2-section">
                                        <div class="accordion td2-veh-accordion" id="td2SuggestedVeh">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header mb-2">
                                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#td2VehCollapse">
                                                        <i class="uil uil-bolt-alt td2-veh-acc-icon"></i>
                                                        <span class="td2-veh-acc-title">Select from Suggested Vehicles</span>
                                                        <span class="td2-veh-acc-count">3</span>
                                                        <span class="td2-veh-acc-pill">Recommended</span>
                                                    </button>
                                                </h2>
                                                <div id="td2VehCollapse" class="accordion-collapse collapse show">
                                                    <div class="accordion-body p-0">

                                                        {{-- Vehicle Card 1 --}}
                                                        <div class="td2-veh-card-wrap">
                                                            <input type="radio" name="td2VehSelect" id="td2Veh1" class="td2-veh-radio">
                                                            <label for="td2Veh1" class="td2-veh-card td2-veh-card-green td2-open-map">
                                                                <div class="td2-vc-header">
                                                                    <div class="td2-vc-num">WB-12-AB-1237</div>                                                                </div>
                                                                <div class="td2-vc-grid">
                                                                    <div class="td2-vc-item">
                                                                        <span class="td2-vc-label">Driver Name</span>
                                                                        <span class="td2-vc-val">Ashok Ray</span>
                                                                    </div>
                                                                    <div class="td2-vc-item">
                                                                        <span class="td2-vc-label">Driver Number</span>
                                                                        <span class="td2-vc-val">+91 8879402641</span>
                                                                    </div>
                                                                    <div class="td2-vc-item">
                                                                        <span class="td2-vc-label">About Driver</span>
                                                                        <span class="td2-vc-val"><span class="td2-bhv-wrap"><span class="td2-bhv-dot td2-bhv-green"></span><span class="td2-bhv-label">Behaviour</span><span class="td2-bhv-exp">10 Mo</span></span></span>
                                                                    </div>
                                                                    <div class="td2-vc-item">
                                                                        <span class="td2-vc-label">Status</span>
                                                                        <span class="td2-vc-val"><span class="td2-veh-status-empty">Empty ✓</span></span>
                                                                    </div>
                                                                    <div class="td2-vc-item">
                                                                        <span class="td2-vc-label">Availability</span>
                                                                        <span class="td2-vc-val">Yes</span>
                                                                    </div>
                                                                    <div class="td2-vc-item">
                                                                        <span class="td2-vc-label">Live Location</span>
                                                                        <span class="td2-vc-val">Kolkata</span>
                                                                    </div>
                                                                    <div class="td2-vc-item">
                                                                        <span class="td2-vc-label">Vehicle Rank</span>
                                                                        <span class="td2-vc-val">5th <i class="uil uil-info-circle ms-1" style="cursor:pointer;font-size:1rem;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" data-bs-custom-class="rank-tooltip" data-bs-title="<div class='rtt-header'>Trip Breakdown</div><div class='rtt-row'><span class='rtt-label'>Total Trips</span><span class='rtt-val'>12</span></div><div class='rtt-row'><span class='rtt-label'>Line</span><span class='rtt-val'>5 Trips</span></div><div class='rtt-row'><span class='rtt-label'>Local</span><span class='rtt-val'>7 Trips</span></div>"></i></span>
                                                                    </div>
                                                                    <div class="td2-vc-item">
                                                                        <span class="td2-vc-label">Associated Since</span>
                                                                        <span class="td2-vc-val">10 Years 5 Months</span>
                                                                    </div>
                                                                </div>
                                                            </label>
                                                        </div>

                                                        {{-- Vehicle Card 2 --}}
                                                        <div class="td2-veh-card-wrap">
                                                            <input type="radio" name="td2VehSelect" id="td2Veh2" class="td2-veh-radio">
                                                            <label for="td2Veh2" class="td2-veh-card td2-veh-card-red td2-open-map">
                                                                <div class="td2-vc-header">
                                                                    <div class="td2-vc-num">WB-34-CD-5678</div>                                                                </div>
                                                                <div class="td2-vc-grid">
                                                                    <div class="td2-vc-item">
                                                                        <span class="td2-vc-label">Driver Name</span>
                                                                        <span class="td2-vc-val">Ranjit Das</span>
                                                                    </div>
                                                                    <div class="td2-vc-item">
                                                                        <span class="td2-vc-label">Driver Number</span>
                                                                        <span class="td2-vc-val">+91 9432101234</span>
                                                                    </div>
                                                                    <div class="td2-vc-item">
                                                                        <span class="td2-vc-label">About Driver</span>
                                                                        <span class="td2-vc-val"><span class="td2-bhv-wrap"><span class="td2-bhv-dot td2-bhv-yellow"></span><span class="td2-bhv-label">Behaviour</span><span class="td2-bhv-exp">4 Mo</span></span></span>
                                                                    </div>
                                                                    <div class="td2-vc-item">
                                                                        <span class="td2-vc-label">Status</span>
                                                                        <span class="td2-vc-val"><span class="td2-veh-status-onway">Not Empty ✗</span></span>
                                                                    </div>
                                                                    <div class="td2-vc-item">
                                                                        <span class="td2-vc-label">Availability</span>
                                                                        <span class="td2-vc-val">On the Way (2 days)</span>
                                                                    </div>
                                                                    <div class="td2-vc-item">
                                                                        <span class="td2-vc-label">Live Location</span>
                                                                        <span class="td2-vc-val">Mumbai</span>
                                                                    </div>
                                                                    <div class="td2-vc-item">
                                                                        <span class="td2-vc-label">Vehicle Rank</span>
                                                                        <span class="td2-vc-val">3rd <i class="uil uil-info-circle ms-1" style="cursor:pointer;font-size:1rem;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" data-bs-custom-class="rank-tooltip" data-bs-title="<div class='rtt-header'>Trip Breakdown</div><div class='rtt-row'><span class='rtt-label'>Total Trips</span><span class='rtt-val'>12</span></div><div class='rtt-row'><span class='rtt-label'>Line</span><span class='rtt-val'>8 Trips</span></div><div class='rtt-row'><span class='rtt-label'>Local</span><span class='rtt-val'>4 Trips</span></div>"></i></span>
                                                                    </div>
                                                                    <div class="td2-vc-item">
                                                                        <span class="td2-vc-label">Associated Since</span>
                                                                        <span class="td2-vc-val">7 Years 2 Months</span>
                                                                    </div>
                                                                </div>
                                                            </label>
                                                        </div>

                                                        {{-- Vehicle Card 3 --}}
                                                        <div class="td2-veh-card-wrap">
                                                            <input type="radio" name="td2VehSelect" id="td2Veh3" class="td2-veh-radio">
                                                            <label for="td2Veh3" class="td2-veh-card td2-veh-card-yellow td2-open-map">
                                                                <div class="td2-vc-header">
                                                                    <div class="td2-vc-num">WB-56-EF-9012</div>                                                                </div>
                                                                <div class="td2-vc-grid">
                                                                    <div class="td2-vc-item">
                                                                        <span class="td2-vc-label">Driver Name</span>
                                                                        <span class="td2-vc-val">Manoj Kumar</span>
                                                                    </div>
                                                                    <div class="td2-vc-item">
                                                                        <span class="td2-vc-label">Driver Number</span>
                                                                        <span class="td2-vc-val">+91 7654321098</span>
                                                                    </div>
                                                                    <div class="td2-vc-item">
                                                                        <span class="td2-vc-label">About Driver</span>
                                                                        <span class="td2-vc-val"><span class="td2-bhv-wrap"><span class="td2-bhv-dot td2-bhv-green"></span><span class="td2-bhv-label">Behaviour</span><span class="td2-bhv-exp">14 Mo</span></span></span>
                                                                    </div>
                                                                    <div class="td2-vc-item">
                                                                        <span class="td2-vc-label">Status</span>
                                                                        <span class="td2-vc-val"><span class="td2-veh-status-empty">Empty ✓</span></span>
                                                                    </div>
                                                                    <div class="td2-vc-item">
                                                                        <span class="td2-vc-label">Availability</span>
                                                                        <span class="td2-vc-val">Yes</span>
                                                                    </div>
                                                                    <div class="td2-vc-item">
                                                                        <span class="td2-vc-label">Live Location</span>
                                                                        <span class="td2-vc-val">Durgapur</span>
                                                                    </div>
                                                                    <div class="td2-vc-item">
                                                                        <span class="td2-vc-label">Vehicle Rank</span>
                                                                        <span class="td2-vc-val">8th <i class="uil uil-info-circle ms-1" style="cursor:pointer;font-size:1rem;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" data-bs-custom-class="rank-tooltip" data-bs-title="<div class='rtt-header'>Trip Breakdown</div><div class='rtt-row'><span class='rtt-label'>Total Trips</span><span class='rtt-val'>12</span></div><div class='rtt-row'><span class='rtt-label'>Line</span><span class='rtt-val'>3 Trips</span></div><div class='rtt-row'><span class='rtt-label'>Local</span><span class='rtt-val'>9 Trips</span></div>"></i></span>
                                                                    </div>
                                                                    <div class="td2-vc-item">
                                                                        <span class="td2-vc-label">Associated Since</span>
                                                                        <span class="td2-vc-val">4 Years 9 Months</span>
                                                                    </div>
                                                                </div>
                                                            </label>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- OR Divider --}}
                                    <div class="td2-or-divider"><span>OR</span></div>

                                    {{-- Part C: Add / Allocate Vehicle Form --}}
                                    <div class="td2-section td2-alloc-section">

                                        {{-- Section header --}}
                                        <div class="td2-alloc-head">
                                            <span class="td2-alloc-head-icon"><i class="uil uil-truck"></i></span>
                                            <div class="td2-alloc-head-text">
                                                <p class="td2-alloc-head-title">Add / Allocate Vehicle</p>
                                                <p class="td2-alloc-head-sub">Pick a vehicle from your own fleet or assign an external vendor vehicle to this trip.</p>
                                            </div>
                                        </div>

                                        {{-- Vehicle source toggle --}}
                                        <div class="td2-alloc-source mb-3">
                                            <span class="td2-alloc-source-label">Select any of these below</span>
                                            <div class="td2-veh-type-toggle">
                                                <input type="radio" name="td2VehType" id="td2OwnVeh" value="Own" class="td2-vtype-radio td2-own-veh" checked>
                                                <label for="td2OwnVeh" class="td2-vtype-label">Own Vehicle</label>
                                                <input type="radio" name="td2VehType" id="td2ExtVeh" value="External" class="td2-vtype-radio td2-ext-veh">
                                                <label for="td2ExtVeh" class="td2-vtype-label">External / Vendor</label>
                                            </div>
                                        </div>

                                        {{-- If Own Vehicle --}}
                                        <div class="td2-if-own td2-alloc-body">
                                            <div class="mb-3">
                                                <label class="form-label">Select Vehicle</label>
                                                <select class="form-select td2-own-veh-select" id="td2OwnVehSelect">
                                                    <option value="">Select vehicle...</option>
                                                    <option>WB-12-AB-1237</option>
                                                    <option>WB-34-CD-5678</option>
                                                    <option>WB-56-EF-9012</option>
                                                </select>
                                            </div>

                                            {{-- VAHAN Details collapsible --}}
                                            <div class="td2-vahan-wrap">
                                                <button class="td2-vahan-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#td2VahanDetails">
                                                    <i class="uil uil-file-info-alt"></i> VAHAN Details <i class="uil uil-angle-down ms-auto"></i>
                                                </button>
                                                <div id="td2VahanDetails" class="collapse">
                                                    <div class="td2-vahan-list">
                                                        <div class="td2-vahan-row">
                                                            <i class="uil uil-check-circle td2-vahan-stat td2-vahan-stat-ok"></i>
                                                            <span class="td2-vahan-key">Owner Name</span>
                                                            <span class="td2-vahan-val">Rajesh Kumar</span>
                                                        </div>
                                                        <div class="td2-vahan-row">
                                                            <i class="uil uil-check-circle td2-vahan-stat td2-vahan-stat-ok"></i>
                                                            <span class="td2-vahan-key">Address</span>
                                                            <span class="td2-vahan-val">12, Park Street, Kolkata - 700016</span>
                                                        </div>
                                                        <div class="td2-vahan-row">
                                                            <i class="uil uil-check-circle td2-vahan-stat td2-vahan-stat-ok"></i>
                                                            <span class="td2-vahan-key">Status</span>
                                                            <span class="td2-vahan-val">Active</span>
                                                        </div>
                                                        <div class="td2-vahan-row">
                                                            <i class="uil uil-check-circle td2-vahan-stat td2-vahan-stat-ok"></i>
                                                            <span class="td2-vahan-key">Registration Date</span>
                                                            <span class="td2-vahan-val">15/03/2018</span>
                                                        </div>
                                                        <div class="td2-vahan-row">
                                                            <i class="uil uil-exclamation-circle td2-vahan-stat td2-vahan-stat-alert"></i>
                                                            <span class="td2-vahan-key">Fitness Certificate Expiry</span>
                                                            <span class="td2-vahan-val">14/03/2026</span>
                                                        </div>
                                                        <div class="td2-vahan-row">
                                                            <i class="uil uil-check-circle td2-vahan-stat td2-vahan-stat-ok"></i>
                                                            <span class="td2-vahan-key">Insurance Expiry</span>
                                                            <span class="td2-vahan-val">22/07/2026</span>
                                                        </div>
                                                        <div class="td2-vahan-row">
                                                            <i class="uil uil-exclamation-circle td2-vahan-stat td2-vahan-stat-alert"></i>
                                                            <span class="td2-vahan-key">Tax Expiry</span>
                                                            <span class="td2-vahan-val">31/03/2026</span>
                                                        </div>
                                                        <div class="td2-vahan-row">
                                                            <i class="uil uil-exclamation-circle td2-vahan-stat td2-vahan-stat-alert"></i>
                                                            <span class="td2-vahan-key">Permit Expiry</span>
                                                            <span class="td2-vahan-val">20/11/2025</span>
                                                        </div>
                                                        <div class="td2-vahan-row">
                                                            <i class="uil uil-check-circle td2-vahan-stat td2-vahan-stat-ok"></i>
                                                            <span class="td2-vahan-key">PUCC Expiry</span>
                                                            <span class="td2-vahan-val">10/06/2026</span>
                                                        </div>
                                                        <div class="td2-vahan-row">
                                                            <i class="uil uil-exclamation-circle td2-vahan-stat td2-vahan-stat-alert"></i>
                                                            <span class="td2-vahan-key">National Permit Expiry</span>
                                                            <span class="td2-vahan-val">20/11/2025</span>
                                                        </div>
                                                        <div class="td2-vahan-row">
                                                            <i class="uil uil-check-circle td2-vahan-stat td2-vahan-stat-ok"></i>
                                                            <span class="td2-vahan-key">Permit Type</span>
                                                            <span class="td2-vahan-val">National</span>
                                                        </div>
                                                        <div class="td2-vahan-row">
                                                            <i class="uil uil-check-circle td2-vahan-stat td2-vahan-stat-ok"></i>
                                                            <span class="td2-vahan-key">PUCC Number</span>
                                                            <span class="td2-vahan-val">PUC2024WB1237</span>
                                                        </div>
                                                        <div class="td2-vahan-row">
                                                            <i class="uil uil-check-circle td2-vahan-stat td2-vahan-stat-ok"></i>
                                                            <span class="td2-vahan-key">Permit Number</span>
                                                            <span class="td2-vahan-val">WB/NP/2022/001237</span>
                                                        </div>
                                                        <div class="td2-vahan-row">
                                                            <i class="uil uil-check-circle td2-vahan-stat td2-vahan-stat-ok"></i>
                                                            <span class="td2-vahan-key">Insurer</span>
                                                            <span class="td2-vahan-val">New India Assurance</span>
                                                        </div>
                                                        <div class="td2-vahan-row">
                                                            <i class="uil uil-check-circle td2-vahan-stat td2-vahan-stat-ok"></i>
                                                            <span class="td2-vahan-key">Insurance Number</span>
                                                            <span class="td2-vahan-val">NIA/2024/098765</span>
                                                        </div>
                                                        <div class="td2-vahan-row">
                                                            <i class="uil uil-check-circle td2-vahan-stat td2-vahan-stat-ok"></i>
                                                            <span class="td2-vahan-key">Financier</span>
                                                            <span class="td2-vahan-val">SBI Bank</span>
                                                        </div>
                                                        <div class="td2-vahan-row">
                                                            <i class="uil uil-check-circle td2-vahan-stat td2-vahan-stat-ok"></i>
                                                            <span class="td2-vahan-key">Class</span>
                                                            <span class="td2-vahan-val">Medium Goods Vehicle</span>
                                                        </div>
                                                        <div class="td2-vahan-row">
                                                            <i class="uil uil-check-circle td2-vahan-stat td2-vahan-stat-ok"></i>
                                                            <span class="td2-vahan-key">Body Type</span>
                                                            <span class="td2-vahan-val">Closed Body</span>
                                                        </div>
                                                        <div class="td2-vahan-row">
                                                            <i class="uil uil-check-circle td2-vahan-stat td2-vahan-stat-ok"></i>
                                                            <span class="td2-vahan-key">Fuel Type</span>
                                                            <span class="td2-vahan-val">Diesel</span>
                                                        </div>
                                                        <div class="td2-vahan-row">
                                                            <i class="uil uil-check-circle td2-vahan-stat td2-vahan-stat-ok"></i>
                                                            <span class="td2-vahan-key">Chassis Number</span>
                                                            <span class="td2-vahan-val">MAT451351MDE12345</span>
                                                        </div>
                                                        <div class="td2-vahan-row">
                                                            <i class="uil uil-check-circle td2-vahan-stat td2-vahan-stat-ok"></i>
                                                            <span class="td2-vahan-key">Engine Number</span>
                                                            <span class="td2-vahan-val">4HK1-WB12345</span>
                                                        </div>
                                                        <div class="td2-vahan-row">
                                                            <i class="uil uil-check-circle td2-vahan-stat td2-vahan-stat-ok"></i>
                                                            <span class="td2-vahan-key">Manufacturer</span>
                                                            <span class="td2-vahan-val">Tata Motors</span>
                                                        </div>
                                                        <div class="td2-vahan-row">
                                                            <i class="uil uil-check-circle td2-vahan-stat td2-vahan-stat-ok"></i>
                                                            <span class="td2-vahan-key">Norms Type</span>
                                                            <span class="td2-vahan-val">BS-VI</span>
                                                        </div>
                                                        <div class="td2-vahan-row">
                                                            <i class="uil uil-check-circle td2-vahan-stat td2-vahan-stat-ok"></i>
                                                            <span class="td2-vahan-key">Model</span>
                                                            <span class="td2-vahan-val">LPT 1618</span>
                                                        </div>
                                                        <div class="td2-vahan-row">
                                                            <i class="uil uil-check-circle td2-vahan-stat td2-vahan-stat-ok"></i>
                                                            <span class="td2-vahan-key">GVW</span>
                                                            <span class="td2-vahan-val">16180 KG</span>
                                                        </div>
                                                        <div class="td2-vahan-row">
                                                            <i class="uil uil-check-circle td2-vahan-stat td2-vahan-stat-ok"></i>
                                                            <span class="td2-vahan-key">Wheelbase</span>
                                                            <span class="td2-vahan-val">4200 MM</span>
                                                        </div>
                                                        <div class="td2-vahan-row">
                                                            <i class="uil uil-check-circle td2-vahan-stat td2-vahan-stat-ok"></i>
                                                            <span class="td2-vahan-key">FASTag ID</span>
                                                            <span class="td2-vahan-val">WB12AB1237FT</span>
                                                        </div>
                                                        <div class="td2-vahan-row">
                                                            <i class="uil uil-check-circle td2-vahan-stat td2-vahan-stat-ok"></i>
                                                            <span class="td2-vahan-key">TID</span>
                                                            <span class="td2-vahan-val">TID20240012370</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Selected vehicle summary — same card style as Suggested Vehicles --}}
                                            <div class="td2-veh-card td2-veh-card-green td2-open-map mt-3">
                                                <div class="td2-vc-header">
                                                    <div class="td2-vc-num">WB-12-AB-1237</div>
                                                </div>
                                                <div class="td2-vc-grid">
                                                    <div class="td2-vc-item">
                                                        <span class="td2-vc-label">Driver Name</span>
                                                        <span class="td2-vc-val">Ashok Ray</span>
                                                    </div>
                                                    <div class="td2-vc-item">
                                                        <span class="td2-vc-label">Driver Number</span>
                                                        <span class="td2-vc-val">+91 8879402641</span>
                                                    </div>
                                                    <div class="td2-vc-item">
                                                        <span class="td2-vc-label">About Driver</span>
                                                        <span class="td2-vc-val"><span class="td2-bhv-wrap"><span class="td2-bhv-dot td2-bhv-green"></span><span class="td2-bhv-label">Behaviour</span><span class="td2-bhv-exp">10 Mo</span></span></span>
                                                    </div>
                                                    <div class="td2-vc-item">
                                                        <span class="td2-vc-label">Status</span>
                                                        <span class="td2-vc-val"><span class="td2-veh-status-empty">Empty ✓</span></span>
                                                    </div>
                                                    <div class="td2-vc-item">
                                                        <span class="td2-vc-label">Availability</span>
                                                        <span class="td2-vc-val">Yes</span>
                                                    </div>
                                                    <div class="td2-vc-item">
                                                        <span class="td2-vc-label">Live Location</span>
                                                        <span class="td2-vc-val">Kolkata</span>
                                                    </div>
                                                    <div class="td2-vc-item">
                                                        <span class="td2-vc-label">Vehicle Rank</span>
                                                        <span class="td2-vc-val">5th <i class="uil uil-info-circle ms-1" style="cursor:pointer;font-size:1rem;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" data-bs-custom-class="rank-tooltip" data-bs-title="<div class='rtt-header'>Trip Breakdown</div><div class='rtt-row'><span class='rtt-label'>Total Trips</span><span class='rtt-val'>12</span></div><div class='rtt-row'><span class='rtt-label'>Line</span><span class='rtt-val'>5 Trips</span></div><div class='rtt-row'><span class='rtt-label'>Local</span><span class='rtt-val'>7 Trips</span></div>"></i></span>
                                                    </div>
                                                    <div class="td2-vc-item">
                                                        <span class="td2-vc-label">Associated Since</span>
                                                        <span class="td2-vc-val">10 Years 5 Months</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- If External Vehicle --}}
                                        <div class="td2-if-ext td2-alloc-body">
                                            <div class="mb-3">
                                                <label class="form-label">Vendor</label>
                                                <div class="d-flex gap-2 align-items-center">
                                                    <select class="form-select" id="td2ExtVendorSelect">
                                                        <option value="">Select vendor...</option>
                                                        <option>ABC Logistics</option>
                                                        <option>XYZ Transport</option>
                                                        <option>MNC Logistics</option>
                                                    </select>
                                                    <a href="{{ route('contact.vehiclevendor.create') }}" target="_blank" rel="noopener" class="text-nowrap small">+ Add Vendor</a>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Vehicle</label>
                                                <div class="d-flex gap-2 align-items-center">
                                                    <select class="form-select" id="td2ExtVehicleSelect">
                                                        <option value="">Select vehicle...</option>
                                                        <option>WB-99-ZZ-0001</option>
                                                        <option>DL-01-XX-5050</option>
                                                    </select>
                                                    <a href="{{ route('vehiclemanagement.create') }}" target="_blank" rel="noopener" class="btn btn-outline-secondary btn-sm text-nowrap">+ Add Vehicle</a>
                                                </div>
                                            </div>

                                            {{-- VAHAN Details collapsible (external) --}}
                                            <div class="td2-vahan-wrap mb-3">
                                                <button class="td2-vahan-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#td2VahanDetailsExt">
                                                    <i class="uil uil-file-info-alt"></i> VAHAN Details <i class="uil uil-angle-down ms-auto"></i>
                                                </button>
                                                <div id="td2VahanDetailsExt" class="collapse">
                                                    <div class="td2-vahan-list">
                                                        @php
                                                            $extVahanFields = [
                                                                'Owner Name', 'Address', 'Status', 'Registration Date',
                                                                'Fitness Certificate Expiry', 'Insurance Expiry', 'Tax Expiry',
                                                                'Permit Expiry', 'PUCC Expiry', 'National Permit Expiry',
                                                                'Permit Type', 'PUCC Number', 'Permit Number', 'Insurer',
                                                                'Insurance Number', 'Financier', 'Class', 'Body Type',
                                                                'Fuel Type', 'Chassis Number', 'Engine Number', 'Manufacturer',
                                                                'Norms Type', 'Model', 'GVW', 'Wheelbase', 'FASTag ID', 'TID',
                                                            ];
                                                        @endphp
                                                        @foreach ($extVahanFields as $extVahanField)
                                                        <div class="td2-vahan-row">
                                                            <i class="uil uil-minus-circle td2-vahan-stat td2-vahan-stat-na"></i>
                                                            <span class="td2-vahan-key">{{ $extVahanField }}</span>
                                                            <span class="td2-vahan-val td2-vahan-val-empty">—</span>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Selected vehicle summary — same card style (RAG-coloured border); driver fields blank for external --}}
                                            <div class="td2-veh-card td2-veh-card-green td2-open-map mb-3">
                                                <div class="td2-vc-header">
                                                    <div class="td2-vc-num">WB-99-ZZ-0001</div>
                                                </div>
                                                <div class="td2-vc-grid">
                                                    <div class="td2-vc-item">
                                                        <span class="td2-vc-label">Driver Name</span>
                                                        <span class="td2-vc-val">—</span>
                                                    </div>
                                                    <div class="td2-vc-item">
                                                        <span class="td2-vc-label">Driver Number</span>
                                                        <span class="td2-vc-val">—</span>
                                                    </div>
                                                    <div class="td2-vc-item">
                                                        <span class="td2-vc-label">About Driver</span>
                                                        <span class="td2-vc-val">—</span>
                                                    </div>
                                                    <div class="td2-vc-item">
                                                        <span class="td2-vc-label">Status</span>
                                                        <span class="td2-vc-val"><span class="td2-veh-status-empty">Empty ✓</span></span>
                                                    </div>
                                                    <div class="td2-vc-item">
                                                        <span class="td2-vc-label">Availability</span>
                                                        <span class="td2-vc-val">Yes</span>
                                                    </div>
                                                    <div class="td2-vc-item">
                                                        <span class="td2-vc-label">Live Location</span>
                                                        <span class="td2-vc-val">Mumbai</span>
                                                    </div>
                                                    <div class="td2-vc-item">
                                                        <span class="td2-vc-label">Vehicle Rank</span>
                                                        <span class="td2-vc-val">5th <i class="uil uil-info-circle ms-1" style="cursor:pointer;font-size:1rem;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" data-bs-custom-class="rank-tooltip" data-bs-title="<div class='rtt-header'>Trip Breakdown</div><div class='rtt-row'><span class='rtt-label'>Total Trips</span><span class='rtt-val'>12</span></div><div class='rtt-row'><span class='rtt-label'>Line</span><span class='rtt-val'>5 Trips</span></div><div class='rtt-row'><span class='rtt-label'>Local</span><span class='rtt-val'>7 Trips</span></div>"></i></span>
                                                    </div>
                                                    <div class="td2-vc-item">
                                                        <span class="td2-vc-label">Associated Since</span>
                                                        <span class="td2-vc-val">10 Years 5 Months</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    </div>

                                </div>
                            </div>

                            {{-- ─── TAB 3: Vehicle Status ─── --}}
                            <div class="tab-pane fade" id="td2-vehStatus"
                                 role="tabpanel" aria-labelledby="td2-vehStatus-tab">
                                <div class="td2-pane-header">
                                    <h5 class="td2-pane-title">Vehicle Status</h5>
                                </div>
                                <div class="td2-pane-body">
                                <div class="td2-vstage-list">

                                    {{-- ─── Stage 1: Reported at Loading Point ─── --}}
                                    <div class="td2-vstage td2-vstage-done">
                                        <div class="td2-vstage-header">
                                            <i class="uil uil-check-circle td2-vstage-icon-done"></i>
                                            <span class="td2-vstage-name">Reported at Loading Point</span>
                                            <span class="td2-vstage-time">12/01/2026 12:00 PM</span>
                                            <a class="td2-vstage-change"
                                               data-bs-toggle="modal"
                                               data-bs-target="#changeStatus">Change</a>
                                        </div>
                                        <div class="td2-vstage-body">
                                            <div class="row g-3">
                                                <div class="col-md-3">
                                                    <label class="td2-doc-label">Halting</label>
                                                    <div class="input-group input-group-sm">
                                                        <input type="number" class="form-control" placeholder="0">
                                                        <span class="input-group-text">Day</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <label class="td2-doc-label">Manual Entry</label>
                                                    <input type="text" class="form-control form-control-sm" placeholder="Enter note">
                                                </div>
                                            </div>
                                            <p class="td2-vstage-gps-note"><i class="fa fa-map-marker"></i> Auto-fetched via GPS coordinates</p>
                                        </div>
                                        <div class="td2-map-embed">
                                            <div class="td2-map-proto-badge"><i class="fa fa-map-marker"></i> Loading Point — Kolkata</div>
                                            <iframe
                                                src="https://maps.google.com/maps?q=Kolkata,West+Bengal,India&z=13&output=embed"
                                                width="100%" height="220" frameborder="0"
                                                style="border:0;" allowfullscreen="" loading="lazy"
                                                title="Loading Point — Kolkata"></iframe>
                                        </div>
                                    </div>

                                    {{-- ─── Stage 2: On the Way ─── --}}
                                    <div class="td2-vstage td2-vstage-done">
                                        <div class="td2-vstage-header">
                                            <i class="uil uil-check-circle td2-vstage-icon-done"></i>
                                            <span class="td2-vstage-name">On the Way</span>
                                            <span class="td2-vstage-time">12/01/2026 02:00 PM</span>
                                        </div>
                                        <div class="td2-vstage-body">
                                            <div class="row g-3">
                                                <div class="col-md-3">
                                                    <label class="td2-doc-label">Halting</label>
                                                    <div class="input-group input-group-sm">
                                                        <input type="number" class="form-control" placeholder="0">
                                                        <span class="input-group-text">Day</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <label class="td2-doc-label">Manual Entry</label>
                                                    <input type="text" class="form-control form-control-sm" placeholder="Enter note">
                                                </div>
                                            </div>
                                            <p class="td2-vstage-gps-note"><i class="fa fa-map-marker"></i> Auto-fetched via GPS coordinates</p>
                                        </div>
                                        <div class="td2-map-embed">
                                            <div class="td2-map-proto-badge"><i class="fa fa-truck"></i> En Route — Patna (last known)</div>
                                            <iframe
                                                src="https://maps.google.com/maps?q=Patna,Bihar,India&z=12&output=embed"
                                                width="100%" height="220" frameborder="0"
                                                style="border:0;" allowfullscreen="" loading="lazy"
                                                title="En Route — Patna"></iframe>
                                        </div>
                                    </div>

                                    {{-- ─── Stage 3: Reported at Unloading Point ─── --}}
                                    <div class="td2-vstage td2-vstage-done">
                                        <div class="td2-vstage-header">
                                            <i class="uil uil-check-circle td2-vstage-icon-done"></i>
                                            <span class="td2-vstage-name">Reported at Unloading Point</span>
                                            <span class="td2-vstage-time">22/01/2026 08:00 AM</span>
                                        </div>
                                        <div class="td2-vstage-body">
                                            <div class="row g-3">
                                                <div class="col-md-3">
                                                    <label class="td2-doc-label">Halting</label>
                                                    <div class="input-group input-group-sm">
                                                        <input type="number" class="form-control" placeholder="0">
                                                        <span class="input-group-text">Day</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <label class="td2-doc-label">Manual Entry</label>
                                                    <input type="text" class="form-control form-control-sm" placeholder="Enter note">
                                                </div>
                                            </div>
                                            <p class="td2-vstage-gps-note"><i class="fa fa-map-marker"></i> Auto-fetched via GPS coordinates</p>
                                        </div>
                                        <div class="td2-map-embed">
                                            <div class="td2-map-proto-badge"><i class="fa fa-map-marker"></i> Unloading Point — Mumbai</div>
                                            <iframe
                                                src="https://maps.google.com/maps?q=Mumbai,Maharashtra,India&z=12&output=embed"
                                                width="100%" height="220" frameborder="0"
                                                style="border:0;" allowfullscreen="" loading="lazy"
                                                title="Unloading Point — Mumbai"></iframe>
                                        </div>
                                    </div>

                                    {{-- ─── Stage 4: Unloading (Manual Entry / Pending) ─── --}}
                                    <div class="td2-vstage td2-vstage-pending">
                                        <div class="td2-vstage-header">
                                            <i class="uil uil-circle td2-vstage-icon-pending"></i>
                                            <span class="td2-vstage-name">Unloading <small class="fw-normal text-muted">(Manual Entry)</small></span>
                                            <span class="td2-vstage-time">23/01/2026 10:00 AM</span>
                                        </div>
                                        <div class="td2-vstage-body">
                                            <div class="row g-3">
                                                <div class="col-md-3">
                                                    <label class="td2-doc-label">Halting</label>
                                                    <div class="input-group input-group-sm">
                                                        <input type="number" class="form-control" placeholder="0">
                                                        <span class="input-group-text">Day</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <label class="td2-doc-label">Manual Entry</label>
                                                    <input type="text" class="form-control form-control-sm" placeholder="Enter note">
                                                </div>
                                            </div>
                                            <p class="td2-vstage-gps-note"><i class="fa fa-map-marker"></i> Auto-fetched via GPS coordinates</p>
                                        </div>
                                        <div class="td2-map-embed">
                                            <div class="td2-map-proto-badge td2-map-proto-pending"><i class="fa fa-clock-o"></i> Unloading — Pending GPS fix</div>
                                            <iframe
                                                src="https://maps.google.com/maps?q=Mumbai,Maharashtra,India&z=12&output=embed"
                                                width="100%" height="220" frameborder="0"
                                                style="border:0;" allowfullscreen="" loading="lazy"
                                                title="Unloading — Mumbai"></iframe>
                                        </div>
                                    </div>

                                </div>{{-- /.td2-vstage-list --}}
                                </div>{{-- /.td2-pane-body --}}
                            </div>

                            {{-- ─── TAB 4: Eway + LR ─── --}}
                            <div class="tab-pane fade" id="td2-ewayLr"
                                 role="tabpanel" aria-labelledby="td2-ewayLr-tab">
                                <div class="td2-pane-header">
                                    <h5 class="td2-pane-title">Eway + LR</h5>
                                    <button class="btn btn-primary btn-sm" type="button"
                                            data-bs-toggle="modal" data-bs-target="#addEwayTable">
                                        + Add Eway
                                    </button>
                                </div>
                                <div class="td2-pane-body">

                                    {{-- ─── E-Way Bills ─── --}}
                                    <div class="td2-docs-section">
                                        <div class="td2-docs-header">
                                            <p class="td2-docs-title">E-Way Bills</p>
                                            <button class="btn btn-primary btn-sm" type="button"
                                                    data-bs-toggle="modal" data-bs-target="#addEwayTable">
                                                + Add Eway
                                            </button>
                                        </div>

                                        {{-- Eway Card 1 --}}
                                        <div class="td2-doc-card">
                                            <div class="td2-card-accent td2-card-accent-orange"></div>
                                            <div class="td2-doc-card-body">
                                                <div class="td2-dot-menu-wrap dropdown">
                                                    <button class="td2-dot-trigger dropdown-toggle" type="button"
                                                            data-bs-toggle="dropdown" aria-expanded="false">&#8942;</button>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li><a class="dropdown-item" href="{{ route('trip.lr.print') }}">View Details</a></li>
                                                        {{-- Print REMOVED per feedback.md §6/§19 --}}
                                                    </ul>
                                                </div>
                                                <div class="td2-doc-row td2-doc-row-2">
                                                    <div class="td2-doc-item">
                                                        <div class="td2-doc-label">Invoice Number</div>
                                                        <div class="td2-doc-val">#INV-2025-001</div>
                                                    </div>
                                                    <div class="td2-doc-item">
                                                        <div class="td2-doc-label">Invoice Date</div>
                                                        <div class="td2-doc-val">02/11/2025</div>
                                                    </div>
                                                </div>
                                                <div class="td2-doc-row td2-doc-row-2">
                                                    <div class="td2-doc-item">
                                                        <div class="td2-doc-label">LR Number</div>
                                                        <div class="td2-doc-val">#LR001</div>
                                                    </div>
                                                    <div class="td2-doc-item">
                                                        <div class="td2-doc-label">LR Date</div>
                                                        <div class="td2-doc-val">20/10/2025</div>
                                                    </div>
                                                </div>
                                                <div class="td2-doc-row">
                                                    <div class="td2-doc-item">
                                                        <div class="td2-doc-label">Quantity</div>
                                                        <div class="td2-doc-val">40 Units</div>
                                                    </div>
                                                    <div class="td2-doc-item">
                                                        <div class="td2-doc-label">Value with Tax</div>
                                                        <div class="td2-doc-val">&#8377;1,000</div>
                                                    </div>
                                                    <div class="td2-doc-item">
                                                        <div class="td2-doc-label">Gross Weight</div>
                                                        <div class="td2-doc-val">10 KG</div>
                                                    </div>
                                                    <div class="td2-doc-item">
                                                        <div class="td2-doc-label">Charged Weight</div>
                                                        <div class="td2-doc-val">20 KG</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Eway Card 2 --}}
                                        <div class="td2-doc-card">
                                            <div class="td2-card-accent td2-card-accent-blue"></div>
                                            <div class="td2-doc-card-body">
                                                <div class="td2-dot-menu-wrap dropdown">
                                                    <button class="td2-dot-trigger dropdown-toggle" type="button"
                                                            data-bs-toggle="dropdown" aria-expanded="false">&#8942;</button>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li><a class="dropdown-item" href="{{ route('trip.lr.print') }}">View Details</a></li>
                                                        {{-- Print REMOVED per feedback.md §6/§19 --}}
                                                    </ul>
                                                </div>
                                                <div class="td2-doc-row td2-doc-row-2">
                                                    <div class="td2-doc-item">
                                                        <div class="td2-doc-label">Invoice Number</div>
                                                        <div class="td2-doc-val">#INV-2025-001</div>
                                                    </div>
                                                    <div class="td2-doc-item">
                                                        <div class="td2-doc-label">Invoice Date</div>
                                                        <div class="td2-doc-val">02/11/2025</div>
                                                    </div>
                                                </div>
                                                <div class="td2-doc-row td2-doc-row-2">
                                                    <div class="td2-doc-item">
                                                        <div class="td2-doc-label">LR Number</div>
                                                        <div class="td2-doc-val">#LR001</div>
                                                    </div>
                                                    <div class="td2-doc-item">
                                                        <div class="td2-doc-label">LR Date</div>
                                                        <div class="td2-doc-val">20/10/2025</div>
                                                    </div>
                                                </div>
                                                <div class="td2-doc-row">
                                                    <div class="td2-doc-item">
                                                        <div class="td2-doc-label">Quantity</div>
                                                        <div class="td2-doc-val">40 Units</div>
                                                    </div>
                                                    <div class="td2-doc-item">
                                                        <div class="td2-doc-label">Value with Tax</div>
                                                        <div class="td2-doc-val">&#8377;1,000</div>
                                                    </div>
                                                    <div class="td2-doc-item">
                                                        <div class="td2-doc-label">Gross Weight</div>
                                                        <div class="td2-doc-val">10 KG</div>
                                                    </div>
                                                    <div class="td2-doc-item">
                                                        <div class="td2-doc-label">Charged Weight</div>
                                                        <div class="td2-doc-val">20 KG</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- ─── Lorry Receipts ─── --}}
                                    <div class="td2-docs-section">
                                        <div class="td2-docs-header">
                                            <p class="td2-docs-title">Lorry Receipts</p>
                                            <a href="{{ route('trip.lr.create') }}" class="btn btn-primary btn-sm">+ Add LR</a>
                                        </div>

                                        {{-- LR Card 1 --}}
                                        <div class="td2-doc-card">
                                            <div class="td2-card-accent td2-card-accent-green"></div>
                                            <div class="td2-doc-card-body">
                                                <div class="td2-dot-menu-wrap dropdown">
                                                    <button class="td2-dot-trigger dropdown-toggle" type="button"
                                                            data-bs-toggle="dropdown" aria-expanded="false">&#8942;</button>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li><a class="dropdown-item" href="{{ route('trip.lr.print') }}">View Details</a></li>
                                                        {{-- Print REMOVED per feedback.md §6/§19 --}}
                                                    </ul>
                                                </div>
                                                <div class="td2-doc-row td2-doc-row-2">
                                                    <div class="td2-doc-item">
                                                        <div class="td2-doc-label">Vehicle Number</div>
                                                        <div class="td2-doc-val">WB-12-AB-1237</div>
                                                    </div>
                                                    <div class="td2-doc-item">
                                                        <div class="td2-doc-label">Vehicle Size</div>
                                                        <div class="td2-doc-val">14 FT</div>
                                                    </div>
                                                </div>
                                                <div class="td2-doc-row td2-doc-row-3">
                                                    <div class="td2-doc-item">
                                                        <div class="td2-doc-label">LR Number</div>
                                                        <div class="td2-doc-val">#LR001</div>
                                                    </div>
                                                    <div class="td2-doc-item">
                                                        <div class="td2-doc-label">Party LR#</div>
                                                        <div class="td2-doc-val">PTY-20251020</div>
                                                    </div>
                                                    <div class="td2-doc-item">
                                                        <div class="td2-doc-label">LR Date</div>
                                                        <div class="td2-doc-val">20/10/2025</div>
                                                    </div>
                                                </div>
                                                <div class="td2-doc-row td2-doc-row-3">
                                                    <div class="td2-doc-item">
                                                        <div class="td2-doc-label">Seal Number</div>
                                                        <div class="td2-doc-val">SEAL-001</div>
                                                    </div>
                                                    <div class="td2-doc-item">
                                                        <div class="td2-doc-label">Transport Mode</div>
                                                        <div class="td2-doc-val">Road</div>
                                                    </div>
                                                    <div class="td2-doc-item">
                                                        <div class="td2-doc-label">Payment Terms</div>
                                                        <div class="td2-doc-val">To Pay</div>
                                                    </div>
                                                </div>
                                                <div class="td2-doc-row td2-doc-row-3">
                                                    <div class="td2-doc-item">
                                                        <div class="td2-doc-label">Consignor</div>
                                                        <div class="td2-doc-val">Britania Kolkata</div>
                                                    </div>
                                                    <div class="td2-doc-item">
                                                        <div class="td2-doc-label">Consignee</div>
                                                        <div class="td2-doc-val">Samsung Hydrabad</div>
                                                    </div>
                                                    <div class="td2-doc-item">
                                                        <div class="td2-doc-label">Billing Party</div>
                                                        <div class="td2-doc-val">Gitanjali LLP</div>
                                                    </div>
                                                </div>
                                                <div class="td2-doc-row">
                                                    <div class="td2-doc-item">
                                                        <div class="td2-doc-label">Gross Weight</div>
                                                        <div class="td2-doc-val">10 KG</div>
                                                    </div>
                                                    <div class="td2-doc-item">
                                                        <div class="td2-doc-label">Charged Weight</div>
                                                        <div class="td2-doc-val">20 KG</div>
                                                    </div>
                                                    <div class="td2-doc-item col-span-2">
                                                        <div class="td2-doc-label">Remarks</div>
                                                        <div class="td2-doc-val">Handle with care</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            {{-- ─── TAB 5: POD ─── --}}
                            <div class="tab-pane fade" id="td2-pod"
                                 role="tabpanel" aria-labelledby="td2-pod-tab">
                                <div class="td2-pane-header">
                                    <h5 class="td2-pane-title">LR-POD</h5>
                                    <button class="btn btn-primary btn-sm" type="button"
                                            data-bs-toggle="modal" data-bs-target="#addPOD">
                                        + Add POD
                                    </button>
                                </div>
                                <div class="td2-pane-body">

                                    {{-- ─── POD Card 1 ─── --}}
                                    <div class="td2-pod-card">
                                        <div class="td2-pod-grid">
                                            <div class="td2-pod-item">
                                                <div class="td2-doc-label">Material Description</div>
                                                <div class="td2-doc-val">Hydrabad - Kolkata</div>
                                            </div>
                                            <div class="td2-pod-item">
                                                <div class="td2-doc-label">Invoice Number &amp; Date</div>
                                                <div class="td2-doc-val">#INV001 | 02/11/2025</div>
                                            </div>
                                            <div class="td2-pod-item">
                                                <div class="td2-doc-label">LR Number &amp; Date</div>
                                                <div class="td2-doc-val">#LR001 | 20/10/2025</div>
                                            </div>
                                            <div class="td2-pod-item">
                                                <div class="td2-doc-label">Net Quantity</div>
                                                <div class="td2-doc-val">40</div>
                                            </div>
                                            <div class="td2-pod-item">
                                                <div class="td2-doc-label">Value with Tax</div>
                                                <div class="td2-doc-val">&#8377;1,000</div>
                                            </div>
                                            <div class="td2-pod-item">
                                                <div class="td2-doc-label">Gross Weight</div>
                                                <div class="td2-doc-val">10 KG</div>
                                            </div>
                                            <div class="td2-pod-item">
                                                <div class="td2-doc-label">Charged Weight</div>
                                                <div class="td2-doc-val">20 KG</div>
                                            </div>
                                            <div class="td2-pod-item">
                                                <div class="td2-doc-label">Billing Customer</div>
                                                <div class="td2-doc-val">Gitanjali LLP</div>
                                            </div>
                                            <div class="td2-pod-item">
                                                <div class="td2-doc-label">Source</div>
                                                <div class="td2-doc-val">Hydrabad</div>
                                            </div>
                                            <div class="td2-pod-item">
                                                <div class="td2-doc-label">Destination</div>
                                                <div class="td2-doc-val">Kolkata</div>
                                            </div>
                                            <div class="td2-pod-item">
                                                <div class="td2-doc-label">Product Type</div>
                                                <div class="td2-doc-val">Electronics</div>
                                            </div>
                                        </div>
                                        <div class="td2-party-row">
                                            <div class="td2-party-block">
                                                <div class="td2-party-label">Consignor</div>
                                                <div class="td2-party-name">Britania Kolkata</div>
                                                <div class="td2-party-addr">123 Park Street, Kolkata</div>
                                            </div>
                                            <div class="td2-party-block">
                                                <div class="td2-party-label">Consignee</div>
                                                <div class="td2-party-name">Samsung Hydrabad</div>
                                                <div class="td2-party-addr">45 Tech Hub, Hydrabad</div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            {{-- ─── TAB 6: Trip Payout ─── --}}
                            <div class="tab-pane fade" id="td2-tripPayout"
                                 role="tabpanel" aria-labelledby="td2-tripPayout-tab">
                                <div class="td2-pane-header">
                                    <h5 class="td2-pane-title">Trip Payout</h5>
                                </div>
                                <div class="td2-pane-body">
                                    <p class="td2-payout-subhead">Trip ID: #TRIP001 | Vehicle: XY-55-TY6788 | Driver: Ramesh Singh</p>

                                    {{-- Payout stat cards --}}
                                    <div class="td2-payout-stats row g-3 mb-2">
                                        {{-- Card 1: Diesel --}}
                                        <div class="col-md-4">
                                            <div class="td2-stat-card">
                                                <p class="td2-stat-card-title">Diesel</p>
                                                <div class="td2-stat-row">
                                                    <span class="td2-stat-label">Fixed Diesel</span>
                                                    <span class="td2-stat-val">200 L</span>
                                                </div>
                                                <div class="td2-stat-row">
                                                    <span class="td2-stat-label">Issued Diesel</span>
                                                    <span class="td2-stat-val">150 L</span>
                                                </div>
                                                <div class="td2-stat-row">
                                                    <span class="td2-stat-label">Pending Diesel</span>
                                                    <span class="td2-stat-val">50 L</span>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Card 2: Advance --}}
                                        <div class="col-md-4">
                                            <div class="td2-stat-card">
                                                <p class="td2-stat-card-title">Advance</p>
                                                <div class="td2-stat-row">
                                                    <span class="td2-stat-label">Fixed Advance</span>
                                                    <span class="td2-stat-val">₹10,000</span>
                                                </div>
                                                <div class="td2-stat-row">
                                                    <span class="td2-stat-label">Issued Advance</span>
                                                    <span class="td2-stat-val">₹6,000</span>
                                                </div>
                                                <div class="td2-stat-row">
                                                    <span class="td2-stat-label">Pending Advance</span>
                                                    <span class="td2-stat-val">₹4,000</span>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Card 3: Margin --}}
                                        <div class="col-md-4">
                                            <div class="td2-stat-card">
                                                <p class="td2-stat-card-title">Margin</p>
                                                <div class="td2-stat-row">
                                                    <span class="td2-stat-label">Fuel Rate</span>
                                                    <span class="td2-stat-val">₹90 / L</span>
                                                </div>
                                                <div class="td2-stat-row">
                                                    <span class="td2-stat-label">Diesel Margin</span>
                                                    <span class="td2-stat-val">70 L × ₹90 = ₹6,300</span>
                                                </div>
                                                <div class="td2-stat-row">
                                                    <span class="td2-stat-label">Advance Margin</span>
                                                    <span class="td2-stat-val">₹4,000</span>
                                                </div>
                                                <div class="td2-stat-row td2-stat-total">
                                                    <span class="td2-stat-label">Total</span>
                                                    <span class="td2-stat-val">₹10,300</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <p class="td2-payout-disclaimer">⚠ Trip Margin can apply across multiple trips. Figures shown are for this trip only.</p>

                                    {{-- Driver Transactions --}}
                                    <div class="td2-section">
                                        <div class="td2-section-header">
                                            <p class="td2-section-head-title">Driver Transactions</p>
                                            <button class="btn btn-primary btn-sm" type="button"
                                                    data-bs-toggle="modal" data-bs-target="#driverExpense">
                                                + Add Expense
                                            </button>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="td2-table w-100">
                                                <thead>
                                                    <tr>
                                                        <th>Expense Head</th>
                                                        <th>Expense Type</th>
                                                        <th>Debit (₹)</th>
                                                        <th>Credit (₹)</th>
                                                        <th>Notes</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Vehicle Challan</td>
                                                        <td>Credit</td>
                                                        <td>—</td>
                                                        <td>200</td>
                                                        <td>Traffic challan</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Material Shortage</td>
                                                        <td>Debit</td>
                                                        <td>100</td>
                                                        <td>—</td>
                                                        <td>Short delivery</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- ─── TAB 7: Expenses ─── --}}
                            <div class="tab-pane fade" id="td2-expenses"
                                 role="tabpanel" aria-labelledby="td2-expenses-tab">
                                <div class="td2-pane-header">
                                    <h5 class="td2-pane-title">Expenses</h5>
                                    <button class="btn btn-primary btn-sm" type="button"
                                            data-bs-toggle="modal" data-bs-target="#addExpense">
                                        + Add Expense
                                    </button>
                                </div>
                                <div class="td2-pane-body">
                                    {{-- Expense summary cards --}}
                                    <div class="td2-exp-summary row g-2 mb-3">
                                        <div class="col-md-4 col-6">
                                            <div class="td2-exp-card">
                                                <span class="td2-exp-head">Diesel</span>
                                                <span class="td2-exp-amt">₹15,000</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-6">
                                            <div class="td2-exp-card">
                                                <span class="td2-exp-head">Toll Charges</span>
                                                <span class="td2-exp-amt">₹10,000</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-6">
                                            <div class="td2-exp-card">
                                                <span class="td2-exp-head">Driver Advance</span>
                                                <span class="td2-exp-amt">₹50,000</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-6">
                                            <div class="td2-exp-card">
                                                <span class="td2-exp-head">Maintenance</span>
                                                <span class="td2-exp-amt">₹3,000</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-6">
                                            <div class="td2-exp-card">
                                                <span class="td2-exp-head">Fooding</span>
                                                <span class="td2-exp-amt">₹5,000</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-6">
                                            <div class="td2-exp-card">
                                                <span class="td2-exp-head">Misc. Exp</span>
                                                <span class="td2-exp-amt">₹2,000</span>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="td2-exp-total-card">
                                                <span class="td2-exp-total-label">Total</span>
                                                <span class="td2-exp-total-amt">₹85,000</span>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Expense detail table --}}
                                    <div class="td2-section">
                                        <div class="td2-section-header">
                                            <p class="td2-section-head-title">Expense Detail</p>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="td2-table w-100">
                                                <thead>
                                                    <tr>
                                                        <th>Expense Head</th>
                                                        <th>Date &amp; Time</th>
                                                        <th>Recorded By</th>
                                                        <th>Description</th>
                                                        <th>Type</th>
                                                        <th>Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Diesel</td>
                                                        <td>25/10/2025 10:00 AM</td>
                                                        <td>Ramesh Singh</td>
                                                        <td>Fuel fill-up Kolkata</td>
                                                        <td>Debit</td>
                                                        <td>₹5,000</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Toll Charges</td>
                                                        <td>25/10/2025 02:00 PM</td>
                                                        <td>Ramesh Singh</td>
                                                        <td>NH-6 toll</td>
                                                        <td>Debit</td>
                                                        <td>₹800</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Driver Advance</td>
                                                        <td>26/10/2025 09:00 AM</td>
                                                        <td>Admin</td>
                                                        <td>Pre-trip advance</td>
                                                        <td>Debit</td>
                                                        <td>₹6,000</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- ─── TAB 8: Profit or Loss ─── --}}
                            <div class="tab-pane fade" id="td2-profitLoss"
                                 role="tabpanel" aria-labelledby="td2-profitLoss-tab">
                                <div class="td2-pane-header">
                                    <h5 class="td2-pane-title">Profit or Loss</h5>
                                    <div class="td2-pane-actions">
                                        <button class="btn btn-outline-primary btn-sm td2-bill-click" type="button">
                                            Bill Entry
                                        </button>
                                        <a href="#" class="btn btn-success btn-sm">Finalise Bill</a>
                                    </div>
                                </div>
                                <div class="td2-pane-body">
                                    {{-- P&L Summary card --}}
                                    <div class="td2-pl-card">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p class="td2-pl-section-title">Total Income</p>
                                                <div class="td2-pl-row">
                                                    <span class="td2-pl-label">Freight</span>
                                                    <span class="td2-pl-val">₹35,000</span>
                                                </div>
                                                <div class="td2-pl-row">
                                                    <span class="td2-pl-label">Loading/Unloading</span>
                                                    <span class="td2-pl-val">₹2,000</span>
                                                </div>
                                                <div class="td2-pl-row">
                                                    <span class="td2-pl-label">Multi-Point</span>
                                                    <span class="td2-pl-val">₹1,500</span>
                                                </div>
                                                <div class="td2-pl-row">
                                                    <span class="td2-pl-label">Halting</span>
                                                    <span class="td2-pl-val">₹1,000</span>
                                                </div>
                                                <div class="td2-pl-subtotal">
                                                    <span>TOTAL INCOME</span>
                                                    <span>₹39,500</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="td2-pl-section-title">Total Expense</p>
                                                <div class="td2-pl-row">
                                                    <span class="td2-pl-label">Diesel</span>
                                                    <span class="td2-pl-val">₹15,000</span>
                                                </div>
                                                <div class="td2-pl-row">
                                                    <span class="td2-pl-label">Toll Charges</span>
                                                    <span class="td2-pl-val">₹10,000</span>
                                                </div>
                                                <div class="td2-pl-row">
                                                    <span class="td2-pl-label">Driver Advance</span>
                                                    <span class="td2-pl-val">₹50,000</span>
                                                </div>
                                                <div class="td2-pl-row">
                                                    <span class="td2-pl-label">Maintenance</span>
                                                    <span class="td2-pl-val">₹3,000</span>
                                                </div>
                                                <div class="td2-pl-row">
                                                    <span class="td2-pl-label">Fooding</span>
                                                    <span class="td2-pl-val">₹5,000</span>
                                                </div>
                                                <div class="td2-pl-row">
                                                    <span class="td2-pl-label">Misc. Exp</span>
                                                    <span class="td2-pl-val">₹2,000</span>
                                                </div>
                                                <div class="td2-pl-subtotal">
                                                    <span>TOTAL EXPENSE</span>
                                                    <span>₹85,000</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="td2-pl-result td2-pl-loss">
                                            <span>PROFIT / LOSS</span>
                                            <span>–₹45,500</span>
                                        </div>
                                    </div>

                                    {{-- Addition table --}}
                                    <div class="td2-section">
                                        <div class="td2-section-header">
                                            <p class="td2-section-head-title">Addition</p>
                                            <button class="btn btn-primary btn-sm" type="button"
                                                    data-bs-toggle="modal" data-bs-target="#addAddition">
                                                + Add Addition
                                            </button>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="td2-table w-100">
                                                <thead>
                                                    <tr>
                                                        <th>Addition Head</th>
                                                        <th>Amount</th>
                                                        <th>Recorded By</th>
                                                        <th>Date</th>
                                                        <th>Notes</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Fixed Fee</td>
                                                        <td>₹7,000</td>
                                                        <td>Vinay Goyel</td>
                                                        <td>12/11/2025</td>
                                                        <td>—</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Loading/Unloading Charge</td>
                                                        <td>₹1,000</td>
                                                        <td>Abhishek Nayak</td>
                                                        <td>13/11/2025</td>
                                                        <td>—</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    {{-- Deduction table --}}
                                    <div class="td2-section">
                                        <div class="td2-section-header">
                                            <p class="td2-section-head-title">Deduction</p>
                                            <button class="btn btn-primary btn-sm" type="button"
                                                    data-bs-toggle="modal" data-bs-target="#addDeduction">
                                                + Add Deduction
                                            </button>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="td2-table w-100">
                                                <thead>
                                                    <tr>
                                                        <th>Deduction Head</th>
                                                        <th>Amount</th>
                                                        <th>Recorded By</th>
                                                        <th>Date</th>
                                                        <th>Notes</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>TDS</td>
                                                        <td>₹7,000</td>
                                                        <td>Vinay Goyel</td>
                                                        <td>12/11/2025</td>
                                                        <td>—</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Mamul</td>
                                                        <td>₹3,000</td>
                                                        <td>Vinay Goyel</td>
                                                        <td>12/11/2025</td>
                                                        <td>—</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    {{-- Transaction table --}}
                                    <div class="td2-section">
                                        <div class="td2-section-header">
                                            <p class="td2-section-head-title">Transactions</p>
                                            <button class="btn btn-primary btn-sm" type="button"
                                                    data-bs-toggle="modal" data-bs-target="#addTransaction">
                                                + Add Transaction
                                            </button>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="td2-table w-100">
                                                <thead>
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>Type</th>
                                                        <th>Mode of Payment</th>
                                                        <th>Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>12/11/2025</td>
                                                        <td>Advance</td>
                                                        <td>Cash</td>
                                                        <td>₹3,000</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    {{-- Summary totals --}}
                                    <div class="td2-section td2-pl-totals">
                                        <div class="td2-section-header">
                                            <p class="td2-section-head-title">Summary</p>
                                        </div>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">
                                                <span>Total Addition</span>
                                                <span>5,000.00</span>
                                            </li>
                                            <li class="list-group-item">
                                                <span>Total Deduction</span>
                                                <span>10,000.00</span>
                                            </li>
                                            <li class="list-group-item">
                                                <span>Net Payable</span>
                                                <span>15,000.00</span>
                                            </li>
                                            <li class="list-group-item">
                                                <span>Net Amount Paid</span>
                                                <span>3,000.00</span>
                                            </li>
                                            <li class="list-group-item">
                                                <span class="td2-pl-due">Due Balance</span>
                                                <span class="td2-pl-due">9,000.00</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            {{-- ─── TAB 9: Memo (Outside Booking only) ─── --}}
                            <div class="tab-pane fade" id="td2-memo"
                                 role="tabpanel" aria-labelledby="td2-memo-tab">
                                <div class="td2-pane-header">
                                    <h5 class="td2-pane-title">Memo</h5>
                                </div>
                                <div class="td2-pane-body">
                                    <span class="td2-conditional-note">Outside Booking Only</span>

                                    {{-- Memo form --}}
                                    <form class="td2-memo-form" action="#">
                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <label class="form-label">Memo Number</label>
                                                <input type="text" class="form-control bg-light" name="memo_number"
                                                       value="Memo00120" readonly>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Load Vendor Name</label>
                                                <input type="text" class="form-control bg-light" name="vendor_name"
                                                       value="Samsung" readonly>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Date</label>
                                                <input type="date" class="form-control" name="memo_date"
                                                       value="2026-06-01">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Vehicle Num</label>
                                                <input type="text" class="form-control bg-light" name="vehicle_num"
                                                       value="WB-12-VH-1234" readonly>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Source</label>
                                                <select class="form-select" name="source">
                                                    <option value="">Choose...</option>
                                                    <option selected>Kolkata</option>
                                                    <option>Chennai</option>
                                                    <option>Delhi</option>
                                                    <option>Mumbai</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Destination</label>
                                                <select class="form-select" name="destination">
                                                    <option value="">Choose...</option>
                                                    <option>Kolkata</option>
                                                    <option>Chennai</option>
                                                    <option>Delhi</option>
                                                    <option>Mumbai</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Weight</label>
                                                <input type="text" class="form-control bg-light" name="weight"
                                                       value="7mt/9mt" readonly>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Freight</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">₹</span>
                                                    <input type="text" class="form-control" name="freight">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Advance</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">₹</span>
                                                    <input type="text" class="form-control" name="advance">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Balance</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">₹</span>
                                                    <input type="text" class="form-control" name="balance">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Halting</label>
                                                <input type="text" class="form-control" name="halting">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Multi Points</label>
                                                <input type="text" class="form-control" name="multi_points"
                                                       placeholder="Point 1, Point 2">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Loading Charges</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">₹</span>
                                                    <input type="text" class="form-control" name="loading_charges">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Unloading Charges</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">₹</span>
                                                    <input type="text" class="form-control" name="unloading_charges">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">Remarks</label>
                                                <textarea class="form-control" name="remarks" rows="3"></textarea>
                                            </div>
                                        </div>
                                    </form>

                                    {{-- Memo Transactions --}}
                                    <div class="td2-section mt-4">
                                        <div class="td2-section-header">
                                            <p class="td2-section-head-title">Transactions</p>
                                            <button class="btn btn-primary btn-sm" type="button"
                                                    data-bs-toggle="modal" data-bs-target="#addTransaction">
                                                + Add Transaction
                                            </button>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="td2-table w-100">
                                                <thead>
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>Type</th>
                                                        <th>Mode</th>
                                                        <th>Amount</th>
                                                        <th>Notes</th>
                                                        <th>Advance Received</th>
                                                        <th>Balance Received</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>12/11/2025</td>
                                                        <td>Advance</td>
                                                        <td>Cash</td>
                                                        <td>₹5,000</td>
                                                        <td>—</td>
                                                        <td>₹5,000</td>
                                                        <td>—</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-end mt-3">
                                        <button type="button" class="btn btn-primary td2-memo-save">Save Memo</button>
                                    </div>
                                </div>
                            </div>

                            {{-- ─── TAB 10: Broker Payment (External vehicle only) ─── --}}
                            <div class="tab-pane fade" id="td2-brokerPayment"
                                 role="tabpanel" aria-labelledby="td2-brokerPayment-tab">
                                <div class="td2-pane-header">
                                    <h5 class="td2-pane-title">Broker Payment</h5>
                                </div>
                                <div class="td2-pane-body">
                                    <span class="td2-conditional-note">External Vehicle Only</span>
                                    <div class="td2-lock-note">Vehicle number and freight amount cannot be changed after allocation. Contact Admin to modify.</div>

                                    {{-- Payment type radio --}}
                                    <div class="mb-3">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="brokerPaymentType"
                                                   id="bpAdvance" value="Advance Request" checked>
                                            <label class="form-check-label" for="bpAdvance">Advance Request</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="brokerPaymentType"
                                                   id="bpBalance" value="Balance Request">
                                            <label class="form-check-label" for="bpBalance">Balance Request</label>
                                        </div>
                                    </div>

                                    {{-- Addition (Credit) --}}
                                    <div class="td2-section">
                                        <div class="td2-section-header">
                                            <p class="td2-section-head-title">Addition (Credit)</p>
                                        </div>
                                        <div class="td2-broker-row">
                                            <span class="td2-broker-label">Freight</span>
                                            <div class="input-group td2-broker-input">
                                                <span class="input-group-text">₹</span>
                                                <input type="text" class="form-control td2-broker-locked"
                                                       value="35,000" readonly>
                                            </div>
                                        </div>
                                        <div class="td2-broker-row">
                                            <span class="td2-broker-label">Bonus</span>
                                            <div class="input-group td2-broker-input">
                                                <span class="input-group-text">₹</span>
                                                <input type="text" class="form-control" placeholder="—">
                                            </div>
                                        </div>
                                        <div class="td2-broker-row">
                                            <span class="td2-broker-label">Loading/Unloading Labour</span>
                                            <div class="input-group td2-broker-input">
                                                <span class="input-group-text">₹</span>
                                                <input type="text" class="form-control" value="2,000">
                                            </div>
                                        </div>
                                        <div class="td2-broker-row">
                                            <span class="td2-broker-label">Halting</span>
                                            <div class="input-group td2-broker-input">
                                                <span class="input-group-text">₹</span>
                                                <input type="text" class="form-control" value="1,000">
                                            </div>
                                        </div>
                                        <div class="td2-broker-row">
                                            <span class="td2-broker-label">Others</span>
                                            <div class="input-group td2-broker-input">
                                                <span class="input-group-text">₹</span>
                                                <input type="text" class="form-control" placeholder="—">
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Deduction (Debit) --}}
                                    <div class="td2-section">
                                        <div class="td2-section-header">
                                            <p class="td2-section-head-title">Deduction (Debit)</p>
                                        </div>
                                        <div class="td2-broker-row">
                                            <span class="td2-broker-label">TDS</span>
                                            <div class="input-group td2-broker-input">
                                                <span class="input-group-text">₹</span>
                                                <input type="text" class="form-control" value="3,500">
                                            </div>
                                        </div>
                                        <div class="td2-broker-row">
                                            <span class="td2-broker-label">Damage/Shortage Charges</span>
                                            <div class="input-group td2-broker-input">
                                                <span class="input-group-text">₹</span>
                                                <input type="text" class="form-control" placeholder="—">
                                            </div>
                                        </div>
                                        <div class="td2-broker-row">
                                            <span class="td2-broker-label">Mamul</span>
                                            <div class="input-group td2-broker-input">
                                                <span class="input-group-text">₹</span>
                                                <input type="text" class="form-control" value="500">
                                            </div>
                                        </div>
                                        <div class="td2-broker-row">
                                            <span class="td2-broker-label">Others</span>
                                            <div class="input-group td2-broker-input">
                                                <span class="input-group-text">₹</span>
                                                <input type="text" class="form-control" placeholder="—">
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Net Payable --}}
                                    <div class="td2-section td2-broker-net">
                                        <div class="td2-section-header">
                                            <p class="td2-section-head-title">Net Payable</p>
                                        </div>
                                        <div class="td2-broker-net-row">
                                            <span>Gross Addition</span>
                                            <span>₹38,000</span>
                                        </div>
                                        <div class="td2-broker-net-row">
                                            <span>Total Deduction</span>
                                            <span>₹4,000</span>
                                        </div>
                                        <div class="td2-broker-net-row">
                                            <span>Net Payable</span>
                                            <span>₹34,000</span>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-end mt-3">
                                        <button type="button" class="btn btn-primary td2-broker-submit">Submit Payment Request</button>
                                    </div>
                                </div>
                            </div>

                        </div>{{-- /.tab-content --}}
                    </div>{{-- /.td2-hcontent --}}
                </div>{{-- /.col-md-9 --}}

                {{-- ─── RIGHT SIDEBAR: col-md-3 ─── --}}
                <div class="col-md-3 td2-sidebar">

                    {{-- STATUS — Admin only: JS applyRoleRules() toggles via .status-sidebar-wrap (dev-notes §4) --}}
                    {{-- Commented out per request (2026-06-03)
                    <div class="td2-scard status-sidebar-wrap">
                        <p class="td2-scard-label">Status</p>
                        <select class="form-select form-select-sm">
                            <option value="">Choose...</option>
                            <option>New</option>
                            <option>Vehicle Not Assigned</option>
                            <option>Vehicle Assigned</option>
                            <option>Loading</option>
                            <option>In-transit</option>
                            <option>Reported</option>
                            <option>Delayed</option>
                            <option>Detained</option>
                            <option>Unloaded</option>
                            <option>Breakdown</option>
                            <option>In Repair</option>
                            <option>Accident</option>
                        </select>
                    </div>
                    --}}

                    {{-- SOS moved to floating FAB — see #td2SosFab below --}}

                    {{-- COMPLIANCE CHECK --}}
                    <div class="td2-scard td2-compliance-wrap">
                        <p class="td2-vd-section-title"><i class="uil uil-shield-check"></i> Compliance</p>
                        <div class="td2-vd-comp-grid">
                            <div class="td2-vd-comp-item td2-vd-ok">
                                <i class="uil uil-check-circle"></i>
                                <div><span class="td2-vd-comp-lbl">Broker PAN</span><span class="td2-vd-comp-val">Valid</span></div>
                            </div>
                            <div class="td2-vd-comp-item td2-vd-ok">
                                <i class="uil uil-check-circle"></i>
                                <div><span class="td2-vd-comp-lbl">Bank Account</span><span class="td2-vd-comp-val">Active</span></div>
                            </div>
                            <div class="td2-vd-comp-item td2-vd-ok">
                                <i class="uil uil-check-circle"></i>
                                <div><span class="td2-vd-comp-lbl">Name match PAN</span><span class="td2-vd-comp-val">High</span></div>
                            </div>
                            <div class="td2-vd-comp-item td2-vd-na">
                                <i class="uil uil-minus-circle"></i>
                                <div><span class="td2-vd-comp-lbl">Vehicle Valid</span><span class="td2-vd-comp-val">—</span></div>
                            </div>
                        </div>
                    </div>

                    {{-- HISTORY --}}
                    <div class="td2-scard td2-history-wrap">
                        <div class="td2-scard-header-row">
                            <p class="td2-scard-label">History</p>
                            <a href="#" class="td2-history-viewall"
                               data-bs-toggle="modal" data-bs-target="#viewHistory">
                                View Full History (10)
                            </a>
                        </div>
                        <div class="td2-history-list">
                            <div class="td2-history-item">
                                <div class="td2-history-av">AS</div>
                                <div class="td2-history-detail">
                                    <span class="td2-history-name">ASOKE</span>
                                    <span class="td2-history-date">25/10/2025 | 12:00 PM</span>
                                    <p class="td2-history-text">Lorem ipsum is a simply dummy text</p>
                                </div>
                            </div>
                            <div class="td2-history-item">
                                <div class="td2-history-av">AS</div>
                                <div class="td2-history-detail">
                                    <span class="td2-history-name">ASOKE</span>
                                    <span class="td2-history-date">25/10/2025 | 12:00 PM</span>
                                    <p class="td2-history-text">Lorem ipsum is a simply dummy text</p>
                                </div>
                            </div>
                            <div class="td2-history-item">
                                <div class="td2-history-av">AS</div>
                                <div class="td2-history-detail">
                                    <span class="td2-history-name">ASOKE</span>
                                    <span class="td2-history-date">25/10/2025 | 12:00 PM</span>
                                    <p class="td2-history-text">Lorem ipsum is a simply dummy text</p>
                                </div>
                            </div>
                        </div>

                        {{-- Add Comment --}}
                        <div class="td2-history-comment-wrap">
                            <textarea class="form-control form-control-sm td2-history-comment-input"
                                      id="td2HistoryComment"
                                      rows="2"
                                      placeholder="Add a comment…"></textarea>
                            <button class="td2-history-comment-btn" type="button" id="td2HistoryCommentBtn">
                                <i class="fa fa-paper-plane-o"></i> Post
                            </button>
                        </div>
                    </div>

                </div>{{-- end td2-sidebar --}}

            </div>{{-- /.row.g-0 --}}
        </div>{{-- /.td2-body --}}

        {{-- ───────────────────────────────────────────────────────────
             RIGHT OVERLAY PANELS
             (Full content Sprint 5 — structure + toggle wired now)
        ─────────────────────────────────────────────────────────── --}}

        {{-- Attachment Panel --}}
        <div class="td2-overlay attachment-popup">
            <div class="td2-overlay-header">
                <h6 class="td2-overlay-title">Attachments</h6>
                <button class="btn btn-sm btn-outline-secondary td2-dl-all-btn" type="button">
                    <i class="uil uil-download-alt"></i> Download All
                </button>
                <button class="td2-overlay-close close-overlay" type="button">
                    <i class="uil uil-angle-right-b"></i>
                </button>
            </div>
            <div class="td2-overlay-body">

                {{-- Upload zone --}}
                <div class="td2-upload-zone" id="td2UploadZone">
                    <i class="uil uil-cloud-upload td2-upload-icon"></i>
                    <p class="td2-upload-text">Drag &amp; drop files here, or</p>
                    <label class="btn btn-outline-primary btn-sm td2-upload-label">
                        Browse Files
                        <input type="file" class="d-none td2-file-input" multiple
                               accept=".pdf,.jpg,.jpeg,.png,.doc,.docx,.xls,.xlsx">
                    </label>
                    <p class="td2-upload-hint">PDF, JPG, PNG, DOC, XLS — max 10 MB each</p>
                </div>

                {{-- File list --}}
                <div class="td2-file-list" id="td2FileList">

                    {{-- File item 1 --}}
                    <div class="td2-file-item">
                        <div class="td2-file-icon td2-ficon-pdf">
                            <i class="uil uil-file-alt"></i>
                        </div>
                        <div class="td2-file-info">
                            <span class="td2-file-name">Trip_LR_001.pdf</span>
                            <span class="td2-file-meta">PDF · 1.2 MB · 25/10/2025</span>
                        </div>
                        <div class="td2-file-actions">
                            <button class="td2-file-btn" type="button" title="Download">
                                <i class="uil uil-download-alt"></i>
                            </button>
                            <button class="td2-file-btn td2-file-del" type="button" title="Delete">
                                <i class="uil uil-trash-alt"></i>
                            </button>
                        </div>
                    </div>

                    {{-- File item 2 --}}
                    <div class="td2-file-item">
                        <div class="td2-file-icon td2-ficon-img">
                            <i class="uil uil-image"></i>
                        </div>
                        <div class="td2-file-info">
                            <span class="td2-file-name">Loading_Photo.jpg</span>
                            <span class="td2-file-meta">JPG · 856 KB · 26/10/2025</span>
                        </div>
                        <div class="td2-file-actions">
                            <button class="td2-file-btn" type="button" title="Download">
                                <i class="uil uil-download-alt"></i>
                            </button>
                            <button class="td2-file-btn td2-file-del" type="button" title="Delete">
                                <i class="uil uil-trash-alt"></i>
                            </button>
                        </div>
                    </div>

                    {{-- File item 3 --}}
                    <div class="td2-file-item">
                        <div class="td2-file-icon td2-ficon-doc">
                            <i class="uil uil-file-alt"></i>
                        </div>
                        <div class="td2-file-info">
                            <span class="td2-file-name">Eway_Bill_2025_001.pdf</span>
                            <span class="td2-file-meta">PDF · 345 KB · 02/11/2025</span>
                        </div>
                        <div class="td2-file-actions">
                            <button class="td2-file-btn" type="button" title="Download">
                                <i class="uil uil-download-alt"></i>
                            </button>
                            <button class="td2-file-btn td2-file-del" type="button" title="Delete">
                                <i class="uil uil-trash-alt"></i>
                            </button>
                        </div>
                    </div>

                </div>{{-- end td2-file-list --}}
            </div>
        </div>

        {{-- Vehicle Detail / Map Panel --}}
        <div class="td2-overlay map-popup">
            <div class="td2-overlay-header">
                <h6 class="td2-overlay-title">Vehicle Details</h6>
                <button type="button" class="btn btn-primary btn-sm td2-vd-assign-btn"
                        data-bs-toggle="modal" data-bs-target="#assignModal">Assign</button>
                <button class="td2-overlay-close close-overlay close-map" type="button">
                    <i class="uil uil-angle-right-b"></i>
                </button>
            </div>
            <div class="td2-overlay-body" style="padding:0;">

                {{-- Vehicle identity --}}
                <div class="td2-vd-identity">
                    <div class="d-flex align-items-center gap-2">
                        <span class="td2-vd-live-dot"></span>
                        <div class="td2-vd-reg">WB-12-AB-1237</div>
                    </div>
                    <div class="td2-vd-chips">
                        <span class="td2-vd-chip td2-vd-chip-empty">Empty</span>
                        <span class="td2-vd-chip td2-vd-chip-loc"><i class="uil uil-map-marker"></i> Kolkata</span>
                    </div>
                </div>

                {{-- Live Location Map --}}
                <div class="td2-map-embed">
                    <div class="td2-map-proto-badge">
                        <i class="fa fa-map-marker"></i> Live Location — Kolkata
                        <span class="td2-map-proto-tag">GPS</span>
                    </div>
                    <iframe
                        src="https://maps.google.com/maps?q=Kolkata,West+Bengal,India&z=13&output=embed"
                        width="100%" height="155" frameborder="0"
                        style="border:0;" allowfullscreen="" loading="lazy"
                        title="Live Location — Kolkata"></iframe>
                </div>

                {{-- Vehicle Info --}}
                <div class="td2-vd-section">
                    <p class="td2-vd-section-title"><i class="uil uil-truck"></i> Vehicle Info</p>
                    <div class="td2-vd-field-grid">
                        <div class="td2-vd-field">
                            <span class="td2-vd-field-lbl">Vehicle Age</span>
                            <span class="td2-vd-field-val">10 Year 5 month</span>
                        </div>
                        <div class="td2-vd-field">
                            <span class="td2-vd-field-lbl">Vehicle Size</span>
                            <span class="td2-vd-field-val">32Ft</span>
                        </div>
                        <div class="td2-vd-field">
                            <span class="td2-vd-field-lbl">Vehicle Capacity</span>
                            <span class="td2-vd-field-val">1000 KG</span>
                        </div>
                        <div class="td2-vd-field">
                            <span class="td2-vd-field-lbl">Availability</span>
                            <span class="td2-vd-field-val">Free</span>
                        </div>
                        <div class="td2-vd-field">
                            <span class="td2-vd-field-lbl">Vehicle Rank</span>
                            <span class="td2-vd-field-val">5th</span>
                        </div>
                        <div class="td2-vd-field">
                            <span class="td2-vd-field-lbl">Total Trip</span>
                            <span class="td2-vd-field-val">12 <small class="fw-normal" style="color:#94a3b8;font-size:11px;">(Line: 5 / Local: 7)</small></span>
                        </div>
                    </div>
                </div>

                {{-- Estimated Time of Arrival --}}
                <div class="td2-vd-section">
                    <div class="td2-vd-eta-card">
                        <div class="td2-vd-eta-badge">
                            <i class="uil uil-clock-three"></i> Estimated Time of Arrival
                        </div>
                        <div class="td2-vd-eta-row">
                            <div class="td2-vd-eta-col">
                                <span class="td2-vd-eta-col-lbl">Arrival Date</span>
                                <span class="td2-vd-eta-col-val">12/11/2025</span>
                            </div>
                            <div class="td2-vd-eta-divider"></div>
                            <div class="td2-vd-eta-col">
                                <span class="td2-vd-eta-col-lbl">Arrival Time</span>
                                <span class="td2-vd-eta-col-val">12:00 PM</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Last Trip Details --}}
                <div class="td2-vd-section">
                    <p class="td2-vd-section-title"><i class="uil uil-history"></i> Last Trip Details</p>
                    <div class="td2-vd-field-grid">
                        <div class="td2-vd-field">
                            <span class="td2-vd-field-lbl">Trip Type</span>
                            <span class="td2-vd-field-val">Outside Booking</span>
                        </div>
                        <div class="td2-vd-field">
                            <span class="td2-vd-field-lbl">Customer</span>
                            <span class="td2-vd-field-val">John Doe</span>
                        </div>
                        <div class="td2-vd-field">
                            <span class="td2-vd-field-lbl">Source</span>
                            <span class="td2-vd-field-val">Kolkata</span>
                        </div>
                        <div class="td2-vd-field">
                            <span class="td2-vd-field-lbl">Destination</span>
                            <span class="td2-vd-field-val">Mumbai</span>
                        </div>
                        <div class="td2-vd-field">
                            <span class="td2-vd-field-lbl">Stop 1</span>
                            <span class="td2-vd-field-val">Kolaghat</span>
                        </div>
                        <div class="td2-vd-field">
                            <span class="td2-vd-field-lbl">Stop 2</span>
                            <span class="td2-vd-field-val">Patna</span>
                        </div>
                        <div class="td2-vd-field">
                            <span class="td2-vd-field-lbl">Stop 3</span>
                            <span class="td2-vd-field-val">Pune</span>
                        </div>
                        <div class="td2-vd-field">
                            <span class="td2-vd-field-lbl">Duration</span>
                            <span class="td2-vd-field-val">15 Hours</span>
                        </div>
                        <div class="td2-vd-field">
                            <span class="td2-vd-field-lbl">Delivery Status</span>
                            <span class="td2-vd-field-val" style="color:#16a34a;">On Time</span>
                        </div>
                        <div class="td2-vd-field">
                            <span class="td2-vd-field-lbl">Route</span>
                            <span class="td2-vd-field-val">Kolkata – Mumbai</span>
                        </div>
                        <div class="td2-vd-field td2-vd-field-full">
                            <span class="td2-vd-field-lbl">Trip Date &amp; Time</span>
                            <span class="td2-vd-field-val">12/11/2025 &nbsp;|&nbsp; 12:00 PM</span>
                        </div>
                    </div>
                </div>

                {{-- Assigned Driver Details --}}
                <div class="td2-vd-section">
                    <p class="td2-vd-section-title"><i class="uil uil-user-circle"></i> Assigned Driver Details</p>
                    <div class="td2-vd-field-grid">
                        <div class="td2-vd-field">
                            <span class="td2-vd-field-lbl">Driver Name</span>
                            <span class="td2-vd-field-val">Ashoke Pandey</span>
                        </div>
                        <div class="td2-vd-field">
                            <span class="td2-vd-field-lbl">Driver Number</span>
                            <span class="td2-vd-field-val">+91 9876543210</span>
                        </div>
                        <div class="td2-vd-field">
                            <span class="td2-vd-field-lbl">Associated Since</span>
                            <span class="td2-vd-field-val">10 Years 11 Months</span>
                        </div>
                        <div class="td2-vd-field">
                            <span class="td2-vd-field-lbl">Experience</span>
                            <span class="td2-vd-field-val">2 Years 4 Months</span>
                        </div>
                        <div class="td2-vd-field">
                            <span class="td2-vd-field-lbl">RAG Status</span>
                            <span class="td2-vd-field-val"><span class="td2-rag td2-rag-green">Green</span></span>
                        </div>
                        <div class="td2-vd-field">
                            <span class="td2-vd-field-lbl">Line / Local Trips</span>
                            <span class="td2-vd-field-val">5 &nbsp;/&nbsp; 7</span>
                        </div>
                    </div>
                </div>

                {{-- Driver History — timeline --}}
                <div class="td2-vd-section">
                    <p class="td2-vd-section-title"><i class="uil uil-clock-eight"></i> Driver History</p>
                    <div class="td2-vd-drv-hist">
                        <div class="td2-vd-drv-hist-item">
                            <span class="td2-vd-drv-hist-avatar">MS</span>
                            <div class="td2-vd-drv-hist-body">
                                <div class="td2-vd-drv-hist-name">Mohit Singh</div>
                                <div class="td2-vd-drv-hist-meta">25/10/2025 – 28/10/2025 &nbsp;·&nbsp; Kolkata – Durgapur</div>
                                <span class="td2-vd-drv-hist-exp"><i class="uil uil-briefcase"></i> 10 Years 2 Month 6 Days</span>
                            </div>
                        </div>
                        <div class="td2-vd-drv-hist-item">
                            <span class="td2-vd-drv-hist-avatar">LK</span>
                            <div class="td2-vd-drv-hist-body">
                                <div class="td2-vd-drv-hist-name">Litesh Kumar</div>
                                <div class="td2-vd-drv-hist-meta">25/10/2025 – 28/10/2025 &nbsp;·&nbsp; Durgapur – Katoya</div>
                                <span class="td2-vd-drv-hist-exp"><i class="uil uil-briefcase"></i> 12 Years 3 Month 4 Days</span>
                            </div>
                        </div>
                        <div class="td2-vd-drv-hist-item">
                            <span class="td2-vd-drv-hist-avatar">AM</span>
                            <div class="td2-vd-drv-hist-body">
                                <div class="td2-vd-drv-hist-name">Anjan Murthy</div>
                                <div class="td2-vd-drv-hist-meta">25/10/2025 – 28/10/2025 &nbsp;·&nbsp; Bardhaman – Murshidabad</div>
                                <span class="td2-vd-drv-hist-exp"><i class="uil uil-briefcase"></i> 8 Years 1 Month 25 Days</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Compliance --}}
                <div class="td2-vd-section">
                    <p class="td2-vd-section-title"><i class="uil uil-shield-check"></i> Compliance</p>
                    <div class="td2-vd-comp-grid">
                        <div class="td2-vd-comp-item td2-vd-ok">
                            <i class="uil uil-check-circle"></i>
                            <div><span class="td2-vd-comp-lbl">Insurance</span><span class="td2-vd-comp-val">22/07/2026</span></div>
                        </div>
                        <div class="td2-vd-comp-item td2-vd-ok">
                            <i class="uil uil-check-circle"></i>
                            <div><span class="td2-vd-comp-lbl">Fitness</span><span class="td2-vd-comp-val">14/03/2026</span></div>
                        </div>
                        <div class="td2-vd-comp-item td2-vd-warn">
                            <i class="uil uil-exclamation-circle"></i>
                            <div><span class="td2-vd-comp-lbl">Permit</span><span class="td2-vd-comp-val">20/11/2025</span></div>
                        </div>
                        <div class="td2-vd-comp-item td2-vd-ok">
                            <i class="uil uil-check-circle"></i>
                            <div><span class="td2-vd-comp-lbl">PUCC</span><span class="td2-vd-comp-val">10/06/2026</span></div>
                        </div>
                        <div class="td2-vd-comp-item td2-vd-ok">
                            <i class="uil uil-check-circle"></i>
                            <div><span class="td2-vd-comp-lbl">Tax</span><span class="td2-vd-comp-val">31/03/2026</span></div>
                        </div>
                        <div class="td2-vd-comp-item td2-vd-ok">
                            <i class="uil uil-check-circle"></i>
                            <div><span class="td2-vd-comp-lbl">FASTag</span><span class="td2-vd-comp-val">Active</span></div>
                        </div>
                    </div>
                </div>

                {{-- Trip History --}}
                <div class="td2-vd-section">
                    <p class="td2-vd-section-title"><i class="uil uil-list-ul"></i> Trip History (Last 5)</p>
                    <table class="td2-table w-100">
                        <thead>
                            <tr>
                                <th>Trip ID</th>
                                <th>Route</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td>TRIP0012</td><td>KOL–MUM</td><td><span class="td2-rag td2-rag-green">Done</span></td><td>10/10/2025</td></tr>
                            <tr><td>TRIP0009</td><td>KOL–DEL</td><td><span class="td2-rag td2-rag-green">Done</span></td><td>25/09/2025</td></tr>
                            <tr><td>TRIP0006</td><td>KOL–HYD</td><td><span class="td2-rag td2-rag-green">Done</span></td><td>02/09/2025</td></tr>
                        </tbody>
                    </table>
                </div>

                {{-- Bottom Assign Action --}}
                {{-- <div class="td2-vd-action-bar">
                    <button type="button" class="btn btn-primary"
                            data-bs-toggle="modal" data-bs-target="#assignModal">
                        <i class="uil uil-check me-1"></i> Assign This Vehicle
                    </button>
                </div> --}}

            </div>
        </div>

        {{-- Bill Entry Panel --}}
        <div class="td2-overlay bill-popup">
            <div class="td2-overlay-header">
                <h6 class="td2-overlay-title">Bill Entry</h6>
                <div class="ms-auto d-flex gap-2">
                    <button class="btn btn-success btn-sm td2-bill-save-btn" type="button">
                        <i class="uil uil-save"></i> Save Bill
                    </button>
                    <button class="td2-overlay-close close-overlay" type="button">
                        <i class="uil uil-angle-right-b"></i>
                    </button>
                </div>
            </div>
            <div class="td2-overlay-body">
                <form id="td2BillEntryForm">

                    {{-- Trip reference bar --}}
                    <div class="td2-bill-refbar">
                        <span><strong>Trip:</strong> #TRIP001</span>
                        <span><strong>Vehicle:</strong> WB-12-AB-1237</span>
                        <span><strong>Route:</strong> Kolkata – Mumbai</span>
                    </div>

                    {{-- Two-column layout: Income | Expense --}}
                    <div class="row g-3">

                        {{-- Income side --}}
                        <div class="col-md-6">
                            <p class="td2-bill-col-title td2-bill-income-title">Income</p>

                            <div class="td2-bill-row">
                                <label class="td2-bill-lbl">Freight</label>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text">₹</span>
                                    <input type="text" class="form-control" name="freight" value="35,000">
                                </div>
                            </div>
                            <div class="td2-bill-row">
                                <label class="td2-bill-lbl">Loading / Unloading</label>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text">₹</span>
                                    <input type="text" class="form-control" name="loading_charge" value="2,000">
                                </div>
                            </div>
                            <div class="td2-bill-row">
                                <label class="td2-bill-lbl">Halting</label>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text">₹</span>
                                    <input type="text" class="form-control" name="halting_income" value="1,000">
                                </div>
                            </div>
                            <div class="td2-bill-row">
                                <label class="td2-bill-lbl">Multi-Point</label>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text">₹</span>
                                    <input type="text" class="form-control" name="multipoint_income" value="1,500">
                                </div>
                            </div>
                            <div class="td2-bill-row">
                                <label class="td2-bill-lbl">Other</label>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text">₹</span>
                                    <input type="text" class="form-control" name="other_income" placeholder="0">
                                </div>
                            </div>
                            <div class="td2-bill-subtotal td2-bill-income-sub">
                                <span>Total Income</span>
                                <span id="td2BillIncomeTotal">₹39,500</span>
                            </div>
                        </div>

                        {{-- Expense side --}}
                        <div class="col-md-6">
                            <p class="td2-bill-col-title td2-bill-expense-title">Expense</p>

                            <div class="td2-bill-row">
                                <label class="td2-bill-lbl">Diesel</label>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text">₹</span>
                                    <input type="text" class="form-control" name="diesel_expense" value="15,000">
                                </div>
                            </div>
                            <div class="td2-bill-row">
                                <label class="td2-bill-lbl">Toll Charges</label>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text">₹</span>
                                    <input type="text" class="form-control" name="toll_expense" value="10,000">
                                </div>
                            </div>
                            <div class="td2-bill-row">
                                <label class="td2-bill-lbl">Driver Advance</label>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text">₹</span>
                                    <input type="text" class="form-control" name="driver_advance" value="50,000">
                                </div>
                            </div>
                            <div class="td2-bill-row">
                                <label class="td2-bill-lbl">Maintenance</label>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text">₹</span>
                                    <input type="text" class="form-control" name="maintenance_expense" value="3,000">
                                </div>
                            </div>
                            <div class="td2-bill-row">
                                <label class="td2-bill-lbl">Fooding</label>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text">₹</span>
                                    <input type="text" class="form-control" name="fooding_expense" value="5,000">
                                </div>
                            </div>
                            <div class="td2-bill-row">
                                <label class="td2-bill-lbl">Misc.</label>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text">₹</span>
                                    <input type="text" class="form-control" name="misc_expense" value="2,000">
                                </div>
                            </div>
                            <div class="td2-bill-subtotal td2-bill-expense-sub">
                                <span>Total Expense</span>
                                <span id="td2BillExpenseTotal">₹85,000</span>
                            </div>
                        </div>

                    </div>

                    {{-- P&L result --}}
                    <div class="td2-bill-result td2-bill-loss" id="td2BillResult">
                        <span>Profit / Loss</span>
                        <span id="td2BillPLAmt">– ₹45,500</span>
                    </div>

                    <div class="mt-3">
                        <label class="form-label small fw-semibold">Notes</label>
                        <textarea class="form-control form-control-sm" name="bill_notes" rows="2"
                                  placeholder="Any remarks for this bill entry…"></textarea>
                    </div>

                </form>
            </div>
        </div>

    </div>{{-- end #tripApp --}}
</div>{{-- end layout-wrapper --}}

{{-- ═══════════════════════════════════════════════════════════════
     MODALS — Sprint 5 (structure placeholders wired now)
═══════════════════════════════════════════════════════════════ --}}

{{-- Settle Trip --}}
<div class="modal fade" id="closeTrip" tabindex="-1" aria-labelledby="closeTripLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="closeTripLabel">Settle Trip</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to settle this trip?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">No</button>
                <button type="button" class="btn btn-success" data-bs-dismiss="modal">Yes, Settle</button>
            </div>
        </div>
    </div>
</div>

{{-- Cancel Trip --}}
<div class="modal fade" id="cancelTrip" tabindex="-1" aria-labelledby="cancelTripLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cancelTripLabel">Cancel Trip</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to cancel this trip?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">No</button>
                <button type="button" class="btn btn-success" data-bs-dismiss="modal">Yes, Cancel</button>
            </div>
        </div>
    </div>
</div>

{{-- Edit Trip — Sprint 2 (placeholder structure) --}}
<div class="modal fade" id="editTrip" tabindex="-1" aria-labelledby="editTripLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTripLabel">Edit Trip</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editTripForm">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Trip ID</label>
                            <input type="text" class="form-control" value="#001" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Trip Date</label>
                            <input type="text" class="form-control" id="td2EditDateRange" placeholder="DD/MM/YYYY">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Trip Type</label>
                            <select class="form-select" name="trip_type" id="td2EditTripType">
                                <option>Own Booking</option>
                                <option>Outside Booking</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Trip Category</label>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="editTripCategory" id="editCatLine" value="Line" checked>
                                    <label class="form-check-label" for="editCatLine">Line</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="editTripCategory" id="editCatLocal" value="Local">
                                    <label class="form-check-label" for="editCatLocal">Local</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label td2-edit-cust-label">Customer</label>
                            <select class="form-select select2-modal" name="customer_id">
                                <option>Nestle</option>
                                <option>Britania</option>
                                <option>Samsung</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Load Vendor</label>
                            <select class="form-select select2-modal" name="load_vendor_id">
                                <option>Blue Dart</option>
                                <option>DHL</option>
                                <option>FedEx</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Vehicle Type</label>
                            <select class="form-select" name="vehicletype_id">
                                <option>Large Container</option>
                                <option>Truck</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Vehicle Size</label>
                            <select class="form-select" name="vehicletypesize_id">
                                <option>14 FT</option>
                                <option>28 FT</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Internal Trip ID</label>
                            <input type="text" class="form-control" name="internal_trip_id" value="#001001765">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Route</label>
                            <select class="form-select select2-modal" name="route_id">
                                <option>Kolkata - Mumbai</option>
                                <option>Chennai - Kolkata</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Source</label>
                            <input type="text" class="form-control bg-light" value="Kolkata" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Destination</label>
                            <input type="text" class="form-control bg-light" value="Mumbai" readonly>
                        </div>
                        <div class="col-12">
                            <div class="td2-edit-stop td2-edit-stop-item">
                                <div class="row g-2 align-items-center">
                                    <div class="col-md-4">
                                        <label class="form-label">Midpoint</label>
                                        <select class="form-select select2-modal" name="midpoint[]">
                                            <option>Kolaghat</option>
                                            <option>Patna</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Type</label>
                                        <div class="d-flex gap-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="midpoint_type[]" value="Loading" checked>
                                                <label class="form-check-label">Loading</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="midpoint_type[]" value="Unloading">
                                                <label class="form-check-label">Unloading</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 d-flex align-items-end">
                                        <button type="button" class="btn btn-outline-danger btn-sm td2-remove-stop"><i class="uil uil-trash-alt"></i></button>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-outline-secondary btn-sm mt-2 td2-add-stop-btn"><i class="uil uil-plus"></i> Add Stop</button>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Distance</label>
                            <input type="text" class="form-control bg-light" value="150 KM" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Priority</label>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="editPriority" id="editPriorityNormal" value="Normal">
                                    <label class="form-check-label" for="editPriorityNormal">Normal</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="editPriority" id="editPriorityUrgent" value="Urgent" checked>
                                    <label class="form-check-label" for="editPriorityUrgent">Urgent</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Tarpaulin</label>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="editTirpal" id="editTirpalYes" value="Yes" checked>
                                    <label class="form-check-label" for="editTirpalYes">Yes</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="editTirpal" id="editTirpalNo" value="No">
                                    <label class="form-check-label" for="editTirpalNo">No</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Comment</label>
                            <textarea class="form-control" name="comment" rows="3">Lorem ipsum dummy text</textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>

{{-- Add Eway Table — Sprint 3 --}}
<div class="modal fade" id="addEwayTable" tabindex="-1" aria-labelledby="addEwayTableLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addEwayTableLabel">Unassigned E-Ways</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{-- ═══ SPRINT 3 ═══ --}}
                <div class="td2-sprint-note">
                    <i class="uil uil-clock-three"></i> Add Eway Table — Sprint 3
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Add POD — Sprint 3 --}}
<div class="modal fade" id="addPOD" tabindex="-1" aria-labelledby="addPODLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPODLabel">LR-POD</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{-- ═══ SPRINT 3 ═══ --}}
                <div class="td2-sprint-note">
                    <i class="uil uil-clock-three"></i> Add POD — Sprint 3
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>

{{-- Add Expense — Sprint 4 --}}
<div class="modal fade" id="addExpense" tabindex="-1" aria-labelledby="addExpenseLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addExpenseLabel">Add Expense</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Expense Head</label>
                        <input type="text" class="form-control" name="expense_head">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Expense Type</label>
                        <select class="form-select" name="expense_type">
                            <option value="">Choose...</option>
                            <option>Debit</option>
                            <option>Credit</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Amount (₹)</label>
                        <div class="input-group">
                            <span class="input-group-text">₹</span>
                            <input type="text" class="form-control" name="amount">
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Notes</label>
                        <textarea class="form-control" name="notes" rows="2"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>

{{-- Assign Vehicle to This Trip — opened from the Vehicle Details panel "Assign" button --}}
<div class="modal fade" id="assignModal" tabindex="-1" aria-labelledby="assignModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="assignModalLabel">Assign Vehicle to This Trip</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="assignVehicleForm">

                    {{-- Row 1: Expected Start Date / Time --}}
                    <div class="row mb-3">
                        <div class="col-12 col-md-6">
                            <label class="form-label">Expected Start Date</label>
                            <input type="date" class="form-control" name="assign_start_date">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label">Expected Start Time</label>
                            <input type="time" class="form-control" name="assign_start_time">
                        </div>
                    </div>

                    {{-- Row 2: Loading / Unloading Point --}}
                    <div class="row mb-3">
                        <div class="col-12 col-md-6">
                            <label class="form-label">Loading Point</label>
                            <select class="form-select select2-modal" name="assign_loading_point">
                                <option value="">Choose..</option>
                                <option>Webel Gate</option>
                                <option>SDF</option>
                                <option>DLF 1</option>
                                <option>DLF 2</option>
                                <option>Laketown</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label">Unloading Point</label>
                            <select class="form-select select2-modal" name="assign_unloading_point">
                                <option value="">Choose..</option>
                                <option>Webel Gate</option>
                                <option>SDF</option>
                                <option>DLF 1</option>
                                <option>DLF 2</option>
                                <option>Laketown</option>
                            </select>
                        </div>
                    </div>

                    {{-- Row 3: Midpoint 1 (Loading) --}}
                    <div class="row mb-3">
                        <div class="col-12 col-md-6">
                            <label class="form-label">Midpoint 1</label>
                            <input type="text" class="form-control bg-light" name="assign_midpoint_1" value="Bihar" readonly>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label">Midpoint 1 Type</label>
                            <div><span class="badge bg-success">Loading</span></div>
                        </div>
                        <div class="col-12 mt-2">
                            <label class="form-label">Loading Location</label>
                            <select class="form-select" name="assign_loading_location">
                                <option value="">Choose..</option>
                                <option>Webel Gate</option>
                                <option>SDF</option>
                                <option>DLF 1</option>
                                <option>DLF 2</option>
                                <option>Laketown</option>
                            </select>
                        </div>
                    </div>

                    {{-- Row 4: Midpoint 2 (Unloading) --}}
                    <div class="row mb-3">
                        <div class="col-12 col-md-6">
                            <label class="form-label">Midpoint 2</label>
                            <input type="text" class="form-control bg-light" name="assign_midpoint_2" value="Odisha" readonly>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label">Midpoint 2 Type</label>
                            <div><span class="badge bg-danger">Unloading</span></div>
                        </div>
                        <div class="col-12 mt-2">
                            <label class="form-label">Unloading Location</label>
                            <select class="form-select" name="assign_unloading_location">
                                <option value="">Choose..</option>
                                <option>Webel Gate</option>
                                <option>SDF</option>
                                <option>DLF 1</option>
                                <option>DLF 2</option>
                                <option>Laketown</option>
                            </select>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="text-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Assign</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

{{-- Add Review --}}
<div class="modal fade" id="addReview" tabindex="-1" aria-labelledby="addReviewLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addReviewLabel">Trip Review</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addReviewForm">
                    <div class="mb-3">
                        <label class="form-label">Driver Performance</label>
                        <div class="td2-star-row" data-field="driver_rating">
                            <i class="uil uil-star td2-star" data-val="1"></i>
                            <i class="uil uil-star td2-star" data-val="2"></i>
                            <i class="uil uil-star td2-star" data-val="3"></i>
                            <i class="uil uil-star td2-star" data-val="4"></i>
                            <i class="uil uil-star td2-star" data-val="5"></i>
                            <input type="hidden" name="driver_rating" value="">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Vehicle Condition</label>
                        <div class="td2-star-row" data-field="vehicle_rating">
                            <i class="uil uil-star td2-star" data-val="1"></i>
                            <i class="uil uil-star td2-star" data-val="2"></i>
                            <i class="uil uil-star td2-star" data-val="3"></i>
                            <i class="uil uil-star td2-star" data-val="4"></i>
                            <i class="uil uil-star td2-star" data-val="5"></i>
                            <input type="hidden" name="vehicle_rating" value="">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Timeliness</label>
                        <div class="td2-star-row" data-field="timeliness_rating">
                            <i class="uil uil-star td2-star" data-val="1"></i>
                            <i class="uil uil-star td2-star" data-val="2"></i>
                            <i class="uil uil-star td2-star" data-val="3"></i>
                            <i class="uil uil-star td2-star" data-val="4"></i>
                            <i class="uil uil-star td2-star" data-val="5"></i>
                            <input type="hidden" name="timeliness_rating" value="">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Notes</label>
                        <textarea class="form-control" name="review_notes" rows="3"
                                  placeholder="Write your review…"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary td2-review-save-btn">Save Review</button>
            </div>
        </div>
    </div>
</div>

{{-- View Full History --}}
<div class="modal fade" id="viewHistory" tabindex="-1" aria-labelledby="viewHistoryLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewHistoryLabel">Full Trip History</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="td2-history-full">
                    @php
                    $histItems = [
                        ['initials'=>'AS','name'=>'ASOKE','date'=>'25/10/2025 | 12:00 PM','text'=>'Trip created. Route: Kolkata – Mumbai. Priority: Urgent.'],
                        ['initials'=>'AK','name'=>'Anmol Kaur','date'=>'25/10/2025 | 02:15 PM','text'=>'Load vendor assigned: Blue Dart.'],
                        ['initials'=>'AS','name'=>'ASOKE','date'=>'26/10/2025 | 09:00 AM','text'=>'Vehicle allocation initiated.'],
                        ['initials'=>'AK','name'=>'Anmol Kaur','date'=>'26/10/2025 | 10:30 AM','text'=>'Vehicle WB-12-AB-1237 selected. Driver: Ashok Ray.'],
                        ['initials'=>'AS','name'=>'ASOKE','date'=>'27/10/2025 | 08:00 AM','text'=>'Eway bill #INV-2025-001 attached.'],
                        ['initials'=>'AK','name'=>'Anmol Kaur','date'=>'27/10/2025 | 11:00 AM','text'=>'LR #LR001 generated and attached.'],
                        ['initials'=>'AS','name'=>'ASOKE','date'=>'12/01/2026 | 12:00 PM','text'=>'Vehicle reported at loading point.'],
                        ['initials'=>'AS','name'=>'ASOKE','date'=>'12/01/2026 | 02:00 PM','text'=>'Trip marked On the Way.'],
                        ['initials'=>'AK','name'=>'Anmol Kaur','date'=>'22/01/2026 | 08:00 AM','text'=>'Vehicle reported at unloading point.'],
                        ['initials'=>'AS','name'=>'ASOKE','date'=>'23/01/2026 | 10:00 AM','text'=>'Unloading in progress. Manual entry updated.'],
                    ];
                    @endphp
                    @foreach($histItems as $h)
                    <div class="td2-hf-item">
                        <div class="td2-history-av">{{ $h['initials'] }}</div>
                        <div class="td2-history-detail">
                            <span class="td2-history-name">{{ $h['name'] }}</span>
                            <span class="td2-history-date">{{ $h['date'] }}</span>
                            <p class="td2-history-text">{{ $h['text'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Change Vehicle Status --}}
<div class="modal fade" id="changeStatus" tabindex="-1" aria-labelledby="changeStatusLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changeStatusLabel">Change Vehicle Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="changeStatusForm">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Stage</label>
                            <select class="form-select" name="vehicle_stage">
                                <option>Reported at Loading Point</option>
                                <option>On the Way</option>
                                <option>Reported at Unloading Point</option>
                                <option>Unloading</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Date</label>
                            <input type="date" class="form-control" name="stage_date">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Time</label>
                            <input type="time" class="form-control" name="stage_time">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Note</label>
                            <input type="text" class="form-control" name="stage_note" placeholder="Optional note">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary td2-status-save-btn">Save</button>
            </div>
        </div>
    </div>
</div>

{{-- Driver Expense (Trip Payout tab) --}}
<div class="modal fade" id="driverExpense" tabindex="-1" aria-labelledby="driverExpenseLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="driverExpenseLabel">Add Driver Transaction</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="driverExpenseForm">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Expense Head</label>
                            <select class="form-select" name="expense_head">
                                <option value="">Choose…</option>
                                <option>Vehicle Challan</option>
                                <option>Material Shortage</option>
                                <option>Material Damage</option>
                                <option>Bonus</option>
                                <option>Other</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Expense Type</label>
                            <select class="form-select" name="expense_type">
                                <option value="">Choose…</option>
                                <option>Debit</option>
                                <option>Credit</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Amount (₹)</label>
                            <div class="input-group">
                                <span class="input-group-text">₹</span>
                                <input type="text" class="form-control" name="amount">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Date</label>
                            <input type="date" class="form-control" name="txn_date">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Notes</label>
                            <textarea class="form-control" name="notes" rows="2"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary td2-driver-exp-save">Save</button>
            </div>
        </div>
    </div>
</div>

{{-- Add Vehicle (Vehicle Allocation — External) --}}
<div class="modal fade" id="addVeh" tabindex="-1" aria-labelledby="addVehLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addVehLabel">Add External Vehicle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addVehForm">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Vehicle Number</label>
                            <input type="text" class="form-control text-uppercase" name="vehicle_number"
                                   placeholder="WB-12-AB-1234">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Vehicle Type</label>
                            <select class="form-select" name="vehicle_type">
                                <option value="">Choose…</option>
                                <option>Large Truck</option>
                                <option>Medium Truck</option>
                                <option>Mini Truck</option>
                                <option>Container</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Driver Name</label>
                            <input type="text" class="form-control" name="driver_name">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Driver Contact</label>
                            <input type="tel" class="form-control" name="driver_contact" placeholder="+91 XXXXXXXXXX">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary td2-addveh-save">Add Vehicle</button>
            </div>
        </div>
    </div>
</div>

{{-- Add Addition (P&L tab) --}}
<div class="modal fade" id="addAddition" tabindex="-1" aria-labelledby="addAdditionLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addAdditionLabel">Add Addition</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addAdditionForm">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Addition Head</label>
                            <select class="form-select" name="addition_head">
                                <option value="">Choose…</option>
                                <option>Fixed Fee</option>
                                <option>Loading/Unloading Charge</option>
                                <option>Halting Charge</option>
                                <option>Penalty Recovery</option>
                                <option>Other</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Amount (₹)</label>
                            <div class="input-group">
                                <span class="input-group-text">₹</span>
                                <input type="text" class="form-control" name="amount">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Date</label>
                            <input type="date" class="form-control" name="addition_date">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Notes</label>
                            <textarea class="form-control" name="notes" rows="2"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary td2-addition-save">Save</button>
            </div>
        </div>
    </div>
</div>

{{-- Add Deduction (P&L tab) --}}
<div class="modal fade" id="addDeduction" tabindex="-1" aria-labelledby="addDeductionLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDeductionLabel">Add Deduction</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addDeductionForm">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Deduction Head</label>
                            <select class="form-select" name="deduction_head">
                                <option value="">Choose…</option>
                                <option>TDS</option>
                                <option>Mamul</option>
                                <option>Damage Recovery</option>
                                <option>Short Delivery</option>
                                <option>Other</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Amount (₹)</label>
                            <div class="input-group">
                                <span class="input-group-text">₹</span>
                                <input type="text" class="form-control" name="amount">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Date</label>
                            <input type="date" class="form-control" name="deduction_date">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Notes</label>
                            <textarea class="form-control" name="notes" rows="2"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary td2-deduction-save">Save</button>
            </div>
        </div>
    </div>
</div>

{{-- Add Transaction (P&L + Memo tabs) --}}
<div class="modal fade" id="addTransaction" tabindex="-1" aria-labelledby="addTransactionLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTransactionLabel">Add Transaction</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addTransactionForm">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Date</label>
                            <input type="date" class="form-control" name="txn_date">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Type</label>
                            <select class="form-select" name="txn_type">
                                <option value="">Choose…</option>
                                <option>Advance</option>
                                <option>Balance</option>
                                <option>Partial</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Mode of Payment</label>
                            <select class="form-select" name="payment_mode">
                                <option value="">Choose…</option>
                                <option>Cash</option>
                                <option>Bank Transfer</option>
                                <option>UPI</option>
                                <option>Cheque</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Amount (₹)</label>
                            <div class="input-group">
                                <span class="input-group-text">₹</span>
                                <input type="text" class="form-control" name="amount">
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Notes</label>
                            <textarea class="form-control" name="notes" rows="2"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary td2-txn-save">Save</button>
            </div>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════════════
     SOS — FLOATING ACTION BUTTON (fixed right side)
═══════════════════════════════════════════════════════════════ --}}
<div id="td2SosFab" class="td2-sos-fab">
    <button class="td2-sos-fab-btn" id="td2SosFabBtn" type="button"
            title="Report SOS Incident">
        <i class="uil uil-exclamation-triangle"></i>
        <span class="td2-sos-fab-label">SOS</span>
    </button>
    {{-- Active SOS badge count --}}
    <span class="td2-sos-fab-badge d-none" id="td2SosBadge">0</span>
</div>

{{-- SOS Slide Panel (right overlay — td2-overlay pattern) --}}
<div class="td2-overlay td2-sos-panel" id="td2SosPanel">
    <div class="td2-overlay-header" style="background:#fff1f2;border-bottom:2px solid #fecaca;">
        <div style="display:flex;align-items:center;gap:8px;flex:1;">
            <i class="uil uil-exclamation-triangle" style="font-size:20px;color:#dc2626;"></i>
            <h6 class="td2-overlay-title" style="color:#991b1b;">Report SOS Incident</h6>
        </div>
        <button class="btn btn-sm" type="button" id="td2SosHistoryBtn"
                style="background:#fee2e2;color:#991b1b;border:1px solid #fca5a5;font-size:11px;font-weight:600;">
            <i class="uil uil-history"></i> View History
        </button>
        <button class="td2-overlay-close" type="button" id="td2SosPanelClose">
            <i class="uil uil-angle-right-b"></i>
        </button>
    </div>
    <div class="td2-overlay-body">

        {{-- Active SOS alert (hidden until an SOS is active) --}}
        <div class="td2-sos-active-alert d-none" id="td2SosActiveAlert">
            <i class="uil uil-exclamation-circle"></i>
            <span id="td2SosActiveText">Active SOS on this trip</span>
        </div>

        {{-- Incident context --}}
        <div class="td2-sos-context">
            <div class="td2-sos-context-row">
                <span class="td2-sos-ctx-lbl">Trip</span>
                <span class="td2-sos-ctx-val">#TRIP001 &nbsp;·&nbsp; Kolkata – Mumbai</span>
            </div>
            <div class="td2-sos-context-row">
                <span class="td2-sos-ctx-lbl">Vehicle</span>
                <span class="td2-sos-ctx-val">WB-12-AB-1237</span>
            </div>
            <div class="td2-sos-context-row">
                <span class="td2-sos-ctx-lbl">Driver</span>
                <span class="td2-sos-ctx-val">Ashok Ray &nbsp;·&nbsp; +91 88794 02641</span>
            </div>
        </div>

        <p class="td2-sos-instr">Select all that apply — multiple incidents can be reported together</p>

        {{-- Incident type multi-select (hashtag format per PDF §5) --}}
        <div class="td2-sos-grid" id="td2SosCheckboxes">
            <label class="td2-sos-chip">
                <input type="checkbox" value="Maintenance">
                <span><i class="uil uil-wrench"></i> #Maintenance</span>
            </label>
            <label class="td2-sos-chip">
                <input type="checkbox" value="Breakdown">
                <span><i class="uil uil-car-sideview"></i> #Breakdown</span>
            </label>
            <label class="td2-sos-chip">
                <input type="checkbox" value="Driver Run">
                <span><i class="uil uil-user-times"></i> #DriverRun</span>
            </label>
            <label class="td2-sos-chip">
                <input type="checkbox" value="Diesel Theft">
                <span><i class="uil uil-tearing"></i> #DieselTheft</span>
            </label>
            <label class="td2-sos-chip">
                <input type="checkbox" value="Goods Theft">
                <span><i class="uil uil-package"></i> #GoodsTheft</span>
            </label>
            <label class="td2-sos-chip">
                <input type="checkbox" value="Accident">
                <span><i class="uil uil-ambulance"></i> #Accident</span>
            </label>
            {{-- Add a custom incident if not listed; custom incidents share a common icon --}}
            <button type="button" class="td2-sos-chip-add" id="td2SosAddIncidentBtn">
                <i class="uil uil-plus-circle"></i> Add Incident
            </button>
        </div>

        {{-- Note free text --}}
        <div class="td2-sos-manual-wrap">
            <label class="td2-sos-manual-lbl">
                <i class="uil uil-edit-alt"></i> Note
            </label>
            <textarea class="form-control form-control-sm td2-sos-manual-input" id="td2SosManual"
                      rows="3" placeholder="Enter incident details…"></textarea>
        </div>

        {{-- Submit --}}
        <button class="btn btn-danger w-100 td2-sos-submit" id="td2SosSubmitBtn" type="button">
            <i class="uil uil-exclamation-triangle me-1"></i> Report SOS
        </button>

    </div>
</div>

{{-- SOS History Modal --}}
<div class="modal fade" id="sosHistory" tabindex="-1" aria-labelledby="sosHistoryLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header" style="background:#fff1f2;border-bottom:2px solid #fecaca;">
                <div class="d-flex align-items-center gap-2">
                    <i class="uil uil-exclamation-triangle" style="font-size:18px;color:#dc2626;"></i>
                    <h5 class="modal-title" id="sosHistoryLabel" style="color:#991b1b;margin:0;">
                        SOS History — Trip #TRIP001
                    </h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">

                {{-- Stats bar --}}
                <div class="td2-sos-stats">
                    <div class="td2-sos-stat td2-sos-stat-active">
                        <span class="td2-sos-stat-num" id="td2SosStatActive">0</span>
                        <span class="td2-sos-stat-lbl">Active</span>
                    </div>
                    <div class="td2-sos-stat td2-sos-stat-resolved">
                        <span class="td2-sos-stat-num" id="td2SosStatResolved">0</span>
                        <span class="td2-sos-stat-lbl">Resolved</span>
                    </div>
                    <div class="td2-sos-stat">
                        <span class="td2-sos-stat-num" id="td2SosStatTotal">0</span>
                        <span class="td2-sos-stat-lbl">Total</span>
                    </div>
                </div>

                {{-- History timeline --}}
                <div class="td2-sos-history-list" id="td2SosHistoryList">
                    <div class="td2-sos-empty-state" id="td2SosEmptyState">
                        <i class="uil uil-shield-check"></i>
                        <p>No SOS incidents reported on this trip.</p>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script src="{{ asset('customjs/trip/show-v2.js?v=4.0') }}"></script>
@endsection
