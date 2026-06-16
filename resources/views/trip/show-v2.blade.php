@extends('layouts.app')

@section('css')
{{-- Leaflet (interactive map for SOS location capture) --}}
<link href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" rel="stylesheet"
      integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="">
<link href="{{ asset('css/fleet/vehicle-details-v2.css?v=5.6') }}" rel="stylesheet">
<link href="{{ asset('css/trip/show-v2.css?v=9.4') }}" rel="stylesheet">
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
                        {{-- Lifecycle status. Dimmed while paused so the Paused pill leads. --}}
                        <span class="v2-id-status td2-in-transit" id="td2LifecycleBadge">In Transit</span>
                        {{-- Paused pill — shown only while body.td2-trip-paused (SOS pause). --}}
                        <span class="v2-id-status td2-paused-badge" id="td2PausedBadge">
                            <i class="uil uil-pause-circle"></i> Paused
                        </span>
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

                {{-- Paused flag on the horizontal status row — visible only while
                     body.td2-trip-paused. Lets the operator read the trip state
                     straight from the header without opening any tab. --}}
                <span class="td2-stepper-paused-flag" id="td2StepperPausedFlag">
                    <span class="td2-stepper-paused-dot"></span>
                    <i class="uil uil-pause-circle"></i> Trip Paused
                    <span class="td2-stepper-paused-sub">awaiting resume</span>
                </span>
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
                        <button class="nav-link td2-tab" id="td2-ewayLr-tab"
                                data-bs-toggle="pill" data-bs-target="#td2-ewayLr"
                                type="button" role="tab">Eway + LR</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link td2-tab" id="td2-vehStatus-tab"
                                data-bs-toggle="pill" data-bs-target="#td2-vehStatus"
                                type="button" role="tab">Vehicle Status</button>
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

                            {{-- ─── TAB 1: Trip Initiation (lazy — auto-fetched on DOM ready) ─── --}}
                            <div class="tab-pane fade show active" id="td2-tripInit"
                                 role="tabpanel" aria-labelledby="td2-tripInit-tab"
                                 data-tab-key="tripInit" data-tab-url="{{ route('trip.tab', [$trip, 'tripInit']) }}">
                                @include('trip.tabs._loading')
                            </div>

                            {{-- ─── TABS 2–10: lazy-loaded on first activation — see public/js/Trip/tab-loader.js ─── --}}

                            {{-- TAB 2: Vehicle Allocation --}}
                            <div class="tab-pane fade" id="td2-vehAlloc" role="tabpanel" aria-labelledby="td2-vehAlloc-tab"
                                 data-tab-key="vehAlloc" data-tab-url="{{ route('trip.tab', [$trip, 'vehAlloc']) }}">
                                @include('trip.tabs._loading')
                            </div>

                            {{-- TAB 3: Vehicle Status --}}
                            <div class="tab-pane fade" id="td2-vehStatus" role="tabpanel" aria-labelledby="td2-vehStatus-tab"
                                 data-tab-key="vehStatus" data-tab-url="{{ route('trip.tab', [$trip, 'vehStatus']) }}">
                                @include('trip.tabs._loading')
                            </div>

                            {{-- TAB 4: Eway + LR --}}
                            <div class="tab-pane fade" id="td2-ewayLr" role="tabpanel" aria-labelledby="td2-ewayLr-tab"
                                 data-tab-key="ewayLr" data-tab-url="{{ route('trip.tab', [$trip, 'ewayLr']) }}">
                                @include('trip.tabs._loading')
                            </div>

                            {{-- TAB 5: POD --}}
                            <div class="tab-pane fade" id="td2-pod" role="tabpanel" aria-labelledby="td2-pod-tab"
                                 data-tab-key="pod" data-tab-url="{{ route('trip.tab', [$trip, 'pod']) }}">
                                @include('trip.tabs._loading')
                            </div>

                            {{-- TAB 6: Trip Payout --}}
                            <div class="tab-pane fade" id="td2-tripPayout" role="tabpanel" aria-labelledby="td2-tripPayout-tab"
                                 data-tab-key="tripPayout" data-tab-url="{{ route('trip.tab', [$trip, 'tripPayout']) }}">
                                @include('trip.tabs._loading')
                            </div>

                            {{-- TAB 7: Expenses --}}
                            <div class="tab-pane fade" id="td2-expenses" role="tabpanel" aria-labelledby="td2-expenses-tab"
                                 data-tab-key="expenses" data-tab-url="{{ route('trip.tab', [$trip, 'expenses']) }}">
                                @include('trip.tabs._loading')
                            </div>

                            {{-- TAB 8: Profit or Loss --}}
                            <div class="tab-pane fade" id="td2-profitLoss" role="tabpanel" aria-labelledby="td2-profitLoss-tab"
                                 data-tab-key="profitLoss" data-tab-url="{{ route('trip.tab', [$trip, 'profitLoss']) }}">
                                @include('trip.tabs._loading')
                            </div>

                            {{-- TAB 9: Memo --}}
                            <div class="tab-pane fade" id="td2-memo" role="tabpanel" aria-labelledby="td2-memo-tab"
                                 data-tab-key="memo" data-tab-url="{{ route('trip.tab', [$trip, 'memo']) }}">
                                @include('trip.tabs._loading')
                            </div>

                            {{-- TAB 10: Broker Payment --}}
                            <div class="tab-pane fade" id="td2-brokerPayment" role="tabpanel" aria-labelledby="td2-brokerPayment-tab"
                                 data-tab-key="brokerPayment" data-tab-url="{{ route('trip.tab', [$trip, 'brokerPayment']) }}">
                                @include('trip.tabs._loading')
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

                {{-- VAHAN Details — shown instead of the map for External/Vendor vehicles (JS toggles via data-vd-view) --}}
                <div class="td2-vd-vahan-view d-none">
                    <p class="td2-vd-vahan-title"><i class="uil uil-file-info-alt"></i> VAHAN Details</p>
                    <div class="td2-vd-vahan-grid">
                        @php
                            $vdVahan = [
                                ['Owner Name', 'Rajesh Kumar', 'ok'],
                                ['Address', '12, Park Street, Kolkata - 700016', 'ok'],
                                ['Status', 'Active', 'ok'],
                                ['Registration Date', '15/03/2018', 'ok'],
                                ['Fitness Certificate Expiry', '14/03/2026', 'alert'],
                                ['Insurance Expiry', '22/07/2026', 'ok'],
                                ['Tax Expiry', '31/03/2026', 'alert'],
                                ['Permit Expiry', '20/11/2025', 'alert'],
                                ['PUCC Expiry', '10/06/2026', 'ok'],
                                ['National Permit Expiry', '20/11/2025', 'alert'],
                                ['Permit Type', 'National', 'ok'],
                                ['PUCC Number', 'PUC2024WB1237', 'ok'],
                                ['Permit Number', 'WB/NP/2022/001237', 'ok'],
                                ['Insurer', 'New India Assurance', 'ok'],
                                ['Insurance Number', 'NIA/2024/098765', 'ok'],
                                ['Financier', 'SBI Bank', 'ok'],
                                ['Class', 'Medium Goods Vehicle', 'ok'],
                                ['Body Type', 'Closed Body', 'ok'],
                                ['Fuel Type', 'Diesel', 'ok'],
                                ['Chassis Number', 'MAT451351MDE12345', 'ok'],
                                ['Engine Number', '4HK1-WB12345', 'ok'],
                                ['Manufacturer', 'Tata Motors', 'ok'],
                                ['Norms Type', 'BS-VI', 'ok'],
                                ['Model', 'LPT 1618', 'ok'],
                                ['GVW', '16180 KG', 'ok'],
                                ['Wheelbase', '4200 MM', 'ok'],
                                ['FASTag ID', 'WB12AB1237FT', 'ok'],
                                ['TID', 'TID20240012370', 'ok'],
                            ];
                        @endphp
                        @foreach ($vdVahan as $vf)
                        <div class="td2-vd-vahan-row">
                            @if ($vf[2] === 'alert')
                                <i class="uil uil-exclamation-circle td2-vd-vahan-ico-alert"></i>
                            @else
                                <i class="uil uil-check-circle td2-vd-vahan-ico-ok"></i>
                            @endif
                            <span class="td2-vd-vahan-key">{{ $vf[0] }}</span>
                            <span class="td2-vd-vahan-val">{{ $vf[1] }}</span>
                        </div>
                        @endforeach
                    </div>
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

{{-- Unassigned E-Ways — pick existing unassigned e-ways and attach them to this trip --}}
<div class="modal fade" id="addEwayTable" tabindex="-1" aria-labelledby="addEwayTableLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addEwayTableLabel">Unassigned E-Ways</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                {{-- Toolbar: status filter + Add Eway --}}
                <div class="td2-eway-toolbar">
                    <div class="td2-eway-filter">
                        <label class="form-label td2-eway-filter-label" for="td2EwayStatusFilter">Search By Status</label>
                        <select class="form-select form-select-sm" id="td2EwayStatusFilter" name="eway_status_filter">
                            <option value="">All</option>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                    <button class="btn btn-primary btn-sm" type="button"
                            data-bs-toggle="modal" data-bs-target="#addEwayForm">
                        <i class="uil uil-plus me-1"></i>Add Eway
                    </button>
                </div>

                {{-- Unassigned E-Ways table --}}
                <div class="table-responsive">
                    <table class="td2-table td2-eway-table" id="td2EwayTable">
                        <thead>
                            <tr>
                                <th class="td2-eway-check-col">
                                    <input type="checkbox" class="form-check-input" id="td2EwayCheckAll">
                                </th>
                                <th>Eway Bill Number</th>
                                <th>Eway Date</th>
                                <th>Vehicle Number</th>
                                <th>Status</th>
                                <th>Quantity</th>
                                <th>Quantity Units</th>
                                <th>Consigner</th>
                                <th>Source</th>
                                <th>Consignee</th>
                                <th>Destination</th>
                                <th>GSTIN</th>
                                <th>Valid Upto</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr data-status="Active">
                                <td><input type="checkbox" class="form-check-input td2-eway-row-check" value="EWB001" data-qty="441"></td>
                                <td>#001</td>
                                <td>05/11/2025</td>
                                <td>WB-12-AB-1237</td>
                                <td><span class="td2-eway-status td2-eway-status-active">Active</span></td>
                                <td>441</td>
                                <td>KG</td>
                                <td>Britania Kolkata</td>
                                <td>Chennai</td>
                                <td>Kolkata-Gen</td>
                                <td>Kolkata</td>
                                <td>GST00912267g6</td>
                                <td>30/11/2025</td>
                            </tr>
                            <tr data-status="Active">
                                <td><input type="checkbox" class="form-check-input td2-eway-row-check" value="EWB002" data-qty="441"></td>
                                <td>#002</td>
                                <td>05/11/2025</td>
                                <td>WB-12-AB-1237</td>
                                <td><span class="td2-eway-status td2-eway-status-active">Active</span></td>
                                <td>441</td>
                                <td>KG</td>
                                <td>Britania Kolkata</td>
                                <td>Chennai</td>
                                <td>Kolkata-Gen</td>
                                <td>Kolkata</td>
                                <td>GST00912267g6</td>
                                <td>30/11/2025</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer td2-eway-foot">
                <div class="td2-eway-summary">
                    <span>Total: <strong id="td2EwayTotal">2</strong></span>
                    <span>Selected: <strong id="td2EwaySelected">0</strong></span>
                    <span>Selected Quantity: <strong id="td2EwaySelQty">0.00</strong></span>
                </div>
                <div class="td2-eway-foot-actions">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="td2EwayAddToTrip">Add to Trip</button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Add Eway — create a new e-way by GSTIN + bill number(s) --}}
<div class="modal fade" id="addEwayForm" tabindex="-1" aria-labelledby="addEwayFormLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addEwayFormLabel">Add Eway</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addEwayFormEl">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label" for="td2EwayGstin">GSTIN <span class="text-danger">*</span></label>
                            <select class="form-select select2-modal" id="td2EwayGstin" name="gstin">
                                <option value="">Choose...</option>
                                <option value="GST00912267g6">GST00912267g6 — Britania Kolkata</option>
                                <option value="GST22AAAAA0000A1Z5">GST22AAAAA0000A1Z5 — Samsung Hydrabad</option>
                                <option value="GST29BBBBB1111B2Z6">GST29BBBBB1111B2Z6 — Nestle Mumbai</option>
                            </select>
                            <span class="text-danger small d-block mt-1 td2-eway-err" data-for="gstin"></span>
                        </div>
                        <div class="col-12">
                            <label class="form-label" for="td2EwayBillNos">Eway Bill Number (s) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="td2EwayBillNos" name="eway_bill_numbers"
                                   placeholder="Enter one or more e-way bill numbers, comma separated">
                            <span class="text-danger small d-block mt-1 td2-eway-err" data-for="eway_bill_numbers"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
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
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="assignModalLabel">Assign Vehicle to This Trip</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="assignVehicleForm">

                    {{-- Expected start --}}
                    <div class="row g-3 mb-4">
                        <div class="col-12 col-md-6">
                            <label class="form-label td2-assign-label">Expected Start Date</label>
                            <input type="date" class="form-control" name="assign_start_date">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label td2-assign-label">Expected Start Time</label>
                            <input type="time" class="form-control" name="assign_start_time">
                        </div>
                    </div>

                    {{-- Route stops — Source first, Destination last, with 0..n Mid Points between --}}
                    <div class="td2-assign-section-head">
                        <span class="td2-assign-section-title">Route Stops</span>
                        <span class="td2-assign-section-sub">Select the location at each point along the route</span>
                    </div>

                    {{--
                        Flex container adapts to any number of stops:
                        Source + Destination always present and highlighted; Mid Points (.td2-assign-stop-mid)
                        are repeatable 0..n — add or remove a mid block and the layout reflows automatically.
                    --}}
                    <div class="td2-assign-stops">

                        {{-- Source (endpoint — highlighted) — Kolkata (Loading) --}}
                        <div class="td2-assign-stop td2-assign-stop-source">
                            <div class="td2-assign-stop-head">
                                <span class="td2-route-dot td2-route-dot-source"></span>
                                <span class="td2-assign-stage">Source</span>
                            </div>
                            <div class="td2-assign-city">Kolkata</div>
                            <span class="td2-route-type td2-route-type-load">Loading Point</span>
                            <div class="td2-assign-field">
                                <label class="form-label td2-assign-loc-label">Location</label>
                                <select class="form-select select2-modal" name="assign_loc_kolkata">
                                    <option value="">Choose location…</option>
                                    <option>Webel Gate</option>
                                    <option>SDF Building</option>
                                    <option>DLF 1</option>
                                    <option>DLF 2</option>
                                    <option>Laketown Depot</option>
                                </select>
                            </div>
                        </div>

                        {{-- Mid Point (repeatable 0..n) — Kolaghat (Loading & Unloading) --}}
                        <div class="td2-assign-stop td2-assign-stop-mid">
                            <div class="td2-assign-stop-head">
                                <span class="td2-route-dot td2-route-dot-mid"></span>
                                <span class="td2-assign-stage">Mid Point</span>
                            </div>
                            <div class="td2-assign-city">Kolaghat</div>
                            <span class="td2-route-type td2-route-type-both">Loading &amp; Unloading</span>
                            <div class="td2-assign-field">
                                <label class="form-label td2-assign-loc-label">Location</label>
                                <select class="form-select select2-modal" name="assign_loc_kolaghat">
                                    <option value="">Choose location…</option>
                                    <option>Kolaghat Mecheda Yard</option>
                                    <option>NH-16 Truck Bay</option>
                                    <option>Kolaghat Town Godown</option>
                                    <option>Denan Warehouse</option>
                                </select>
                            </div>
                        </div>

                        {{-- Mid Point (repeatable 0..n) — Patna (Loading) --}}
                        <div class="td2-assign-stop td2-assign-stop-mid">
                            <div class="td2-assign-stop-head">
                                <span class="td2-route-dot td2-route-dot-mid"></span>
                                <span class="td2-assign-stage">Mid Point</span>
                            </div>
                            <div class="td2-assign-city">Patna</div>
                            <span class="td2-route-type td2-route-type-load">Loading Point</span>
                            <div class="td2-assign-field">
                                <label class="form-label td2-assign-loc-label">Location</label>
                                <select class="form-select select2-modal" name="assign_loc_patna">
                                    <option value="">Choose location…</option>
                                    <option>Patliputra Industrial Area</option>
                                    <option>Bihta Logistics Park</option>
                                    <option>Fatuha Godown</option>
                                    <option>Bypass Truck Stand</option>
                                </select>
                            </div>
                        </div>

                        {{-- Destination (endpoint — highlighted) — Mumbai (Unloading) --}}
                        <div class="td2-assign-stop td2-assign-stop-dest">
                            <div class="td2-assign-stop-head">
                                <span class="td2-route-dot td2-route-dot-dest"></span>
                                <span class="td2-assign-stage">Destination</span>
                            </div>
                            <div class="td2-assign-city">Mumbai</div>
                            <span class="td2-route-type td2-route-type-unload">Unloading Point</span>
                            <div class="td2-assign-field">
                                <label class="form-label td2-assign-loc-label">Location</label>
                                <select class="form-select select2-modal" name="assign_loc_mumbai">
                                    <option value="">Choose location…</option>
                                    <option>JNPT Nhava Sheva</option>
                                    <option>Bhiwandi Warehouse Hub</option>
                                    <option>Vashi APMC Yard</option>
                                    <option>Kalamboli Truck Terminal</option>
                                </select>
                            </div>
                        </div>

                    </div>

                    {{-- Actions --}}
                    <div class="text-end mt-4">
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
                            <label class="form-label">Status</label>
                            {{-- Route-stage progression only. Disruptions (Halt, Breakdown,
                                 Accident, etc.) have moved to the SOS panel — report them there. --}}
                            <select class="form-select" id="td2StatusSelect" name="vehicle_stage">
                                <option value="">Select status…</option>
                                <option>Kolkata — Loading Point</option>
                                <option>Kolaghat — Load &amp; Unload Point</option>
                                <option>Patna — Loading Point</option>
                                <option>Mumbai — Unloading Point (Destination)</option>
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

{{-- Resume Trip (shown only while the trip is Paused) --}}
<div class="modal fade" id="resumeTripModal" tabindex="-1" aria-labelledby="resumeTripLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header" style="background:#ecfdf5;border-bottom:2px solid #bbf7d0;">
                <h5 class="modal-title" id="resumeTripLabel" style="color:#166534;">
                    <i class="uil uil-play-circle"></i> Resume Trip
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="td2-resume-intro">
                    This trip is paused. Choose how to resume — continue as-is, or re-allocate the
                    vehicle / driver before the trip continues.
                </p>
                <form id="resumeTripForm">
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

                        {{-- Conditional: new vehicle (change_vehicle / change_both) —
                             mirrors the Vehicle Allocation tab: suggested cards + OR + Add/Allocate.
                             Selecting a card or a vehicle reveals the Assign button (no nested modal). --}}
                        <div class="col-12 d-none" id="td2ResumeVehicleWrap">
                            <div class="td2-resume-card">
                            <label class="form-label d-block td2-resume-card-title">Allocate Vehicle</label>
                            <p class="td2-resume-cond-note">
                                <i class="uil uil-filter"></i>
                                Only vehicles not currently assigned to another ongoing trip are listed.
                            </p>

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

                            {{-- Note: effect of changing the vehicle (change_vehicle / change_both) --}}
                            <div class="td2-resume-note td2-resume-note-amber">
                                <i class="uil uil-info-circle"></i>
                                <span>Selecting the vehicle will unassign the vehicle's driver and assign the current driver to selected vehicle.</span>
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

                                {{-- If Own Vehicle --}}
                                <div class="td2-resume-if-own td2-alloc-body">
                                    <div class="mb-1">
                                        <label class="form-label">Select Vehicle</label>
                                        <select class="form-select td2-resume-veh-pick" id="td2ResumeOwnVehSelect">
                                            <option value="">Select vehicle...</option>
                                            <option>WB-12-AB-1237</option>
                                            <option>WB-34-CD-5678</option>
                                            <option>WB-56-EF-9012</option>
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
                                                <option>WB-99-ZZ-0001</option>
                                                <option>DL-01-XX-5050</option>
                                            </select>
                                            <a href="{{ route('vehiclemanagement.create') }}" target="_blank" rel="noopener" class="btn btn-outline-secondary btn-sm text-nowrap">+ Add Vehicle</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Assign button — appears once a vehicle is picked (no nested modal opens) --}}
                            <div class="td2-resume-assign-wrap d-none" id="td2ResumeAssignWrap">
                                <div class="td2-resume-assign-pick" id="td2ResumeAssignPick"></div>
                                <button type="button" class="btn btn-success td2-resume-assign-btn" id="td2ResumeAssignBtn">
                                    <i class="uil uil-check me-1"></i> Assign Vehicle
                                </button>
                            </div>

                            <input type="hidden" id="td2ResumeAssignedVehicle" name="new_vehicle">
                            <span class="text-danger small d-block mt-1 td2-resume-err" data-for="vehicle"></span>
                            </div>{{-- /.td2-resume-card --}}
                        </div>

                        {{-- Conditional: new driver (change_driver / change_both) —
                             on selecting a driver, the driver's currently-assigned vehicle is shown
                             (mirrors the Vehicle Allocation tab's selected-vehicle summary card). --}}
                        <div class="col-12 d-none" id="td2ResumeDriverWrap">
                            <div class="td2-resume-card">
                            <label class="form-label d-block td2-resume-card-title">Allocate Driver</label>
                            <p class="td2-resume-cond-note">
                                <i class="uil uil-filter"></i>
                                Only drivers not currently assigned to another ongoing trip are listed.
                            </p>

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

                            <select class="form-select select2-modal" id="td2ResumeDriverSelect" name="new_driver">
                                <option value="">Select driver…</option>
                                @foreach ($resumeDrivers as $rd)
                                <option value="{{ $rd['name'] }} · {{ $rd['phone'] }}" data-driver-key="{{ $rd['key'] }}">{{ $rd['name'] }} · {{ $rd['phone'] }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger small d-block mt-1 td2-resume-err" data-for="driver"></span>

                            {{-- Note: effect of changing the driver (change_driver / change_both) --}}
                            <div class="td2-resume-note td2-resume-note-amber mt-2">
                                <i class="uil uil-info-circle"></i>
                                <span>Selecting driver will unassign the driver from the assigned vehicle and assign to the current (trip) vehicle.</span>
                            </div>

                            {{-- Selected driver's currently-assigned vehicle (one card per driver, shown on select) --}}
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
                            </div>{{-- /.td2-resume-card --}}
                        </div>

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
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success td2-resume-confirm-btn" id="td2ResumeConfirmBtn">
                    <i class="uil uil-play-circle me-1"></i> Resume Trip
                </button>
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
        {{-- Resume Trip — only visible while the trip is Paused (body.td2-trip-paused) --}}
        <button class="btn btn-sm td2-sos-resume-btn" type="button" id="td2SosResumeBtn"
                data-bs-toggle="modal" data-bs-target="#resumeTripModal">
            <i class="uil uil-play-circle"></i> Resume Trip
        </button>
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

        {{-- ═══════════════════════════════════════════════════════════
             INCIDENT LOCATION — auto-captured GPS + editable map.
             Leaflet map (#td2SosMap) initialised in show-v2.js. The
             marker is locked by default; "Edit" makes it draggable and
             lets the operator tap the map to correct the pin. Captured
             lat/lng/address ride along in the SOS submit event. --}}
        <div class="td2-sos-loc" id="td2SosLoc">

            <div class="td2-sos-loc-head">
                <span class="td2-sos-loc-title">
                    <i class="uil uil-location-point"></i> Incident Location
                </span>
                <span class="td2-sos-loc-status" id="td2SosLocStatus">
                    <span class="td2-sos-loc-dot"></span>
                    <span class="td2-sos-loc-status-txt">Locating…</span>
                </span>
            </div>

            <div class="td2-sos-map-shell">
                <div class="td2-sos-map" id="td2SosMap"></div>

                {{-- Edit-mode hint ribbon (shown only while editing) --}}
                <div class="td2-sos-map-hint d-none" id="td2SosMapHint">
                    <i class="uil uil-info-circle"></i>
                    Drag the pin or tap the map to adjust the location
                </div>

                {{-- Map action buttons (overlay, top-right) --}}
                <div class="td2-sos-map-tools">
                    <button type="button" class="td2-sos-map-btn" id="td2SosEditLocBtn"
                            title="Edit location">
                        <i class="uil uil-edit"></i> <span class="td2-sos-map-btn-lbl">Edit</span>
                    </button>
                    <button type="button" class="td2-sos-map-btn td2-sos-map-btn-gps" id="td2SosGpsBtn"
                            title="Use my current location">
                        <i class="uil uil-crosshair"></i>
                    </button>
                </div>
            </div>

            {{-- Resolved address + coordinates --}}
            <div class="td2-sos-loc-meta">
                <i class="uil uil-map-marker td2-sos-loc-meta-ico"></i>
                <div class="td2-sos-loc-meta-text">
                    <span class="td2-sos-loc-addr" id="td2SosLocAddr">Fetching address…</span>
                    <span class="td2-sos-loc-coords" id="td2SosLocCoords">—</span>
                </div>
            </div>

            {{-- Hidden inputs — captured values for the SOS submission --}}
            <input type="hidden" id="td2SosLat" value="">
            <input type="hidden" id="td2SosLng" value="">
            <input type="hidden" id="td2SosAddress" value="">
        </div>

        <p class="td2-sos-instr">Select all that apply — multiple incidents can be reported together</p>

        {{-- Incident type multi-select (hashtag format per PDF §5).
             Merged list: disruptions previously under Update Status → "Other"
             now live here as incidents (Halt, Detained, Diversion, Weather, etc.). --}}
        <div class="td2-sos-grid" id="td2SosCheckboxes">
            <label class="td2-sos-chip">
                <input type="checkbox" value="Breakdown">
                <span><i class="uil uil-car-sideview"></i> #Breakdown</span>
            </label>
            <label class="td2-sos-chip">
                <input type="checkbox" value="Accident">
                <span><i class="uil uil-ambulance"></i> #Accident</span>
            </label>
            <label class="td2-sos-chip">
                <input type="checkbox" value="Halt">
                <span><i class="uil uil-clock"></i> #Halt</span>
            </label>
            <label class="td2-sos-chip">
                <input type="checkbox" value="Detained">
                <span><i class="uil uil-exclamation-octagon"></i> #Detained</span>
            </label>
            <label class="td2-sos-chip">
                <input type="checkbox" value="Maintenance">
                <span><i class="uil uil-wrench"></i> #Maintenance</span>
            </label>
            <label class="td2-sos-chip">
                <input type="checkbox" value="Diversion">
                <span><i class="uil uil-directions"></i> #Diversion</span>
            </label>
            <label class="td2-sos-chip">
                <input type="checkbox" value="Weather">
                <span><i class="uil uil-cloud"></i> #Weather</span>
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
                <input type="checkbox" value="Driver Run">
                <span><i class="uil uil-user-times"></i> #DriverRun</span>
            </label>
            {{-- Add a custom incident if not listed; custom incidents share a common icon --}}
            <button type="button" class="td2-sos-chip-add" id="td2SosAddIncidentBtn">
                <i class="uil uil-plus-circle"></i> Add Incident
            </button>
        </div>

        {{-- Pause this trip? — operator decides per submission (default ON).
             ON  → trip moves to Paused, Resume Trip affordance appears.
             OFF → incident is logged only; trip keeps running. --}}
        <div class="td2-sos-pause-row">
            <div class="form-check form-switch td2-sos-pause-switch">
                <input class="form-check-input" type="checkbox" role="switch"
                       id="td2SosPauseToggle" checked>
                <label class="form-check-label" for="td2SosPauseToggle">Pause this trip</label>
            </div>
            <span class="td2-sos-pause-hint">Stops the trip until you resume it</span>
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
{{-- Leaflet (interactive map for SOS location capture) --}}
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script src="{{ asset('customjs/trip/show-v2.js?v=5.2') }}"></script>
<script src="{{ asset('js/Trip/tab-loader.js?v=1.2') }}"></script>
@endsection
