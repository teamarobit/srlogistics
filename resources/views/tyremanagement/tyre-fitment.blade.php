@extends('layouts.app')

@section('css')
<link href="{{ asset('css/Inventory/battery-wizard.css?v=1.2') }}" rel="stylesheet">
<link href="{{ asset('css/Tyre/tyre-fitment.css?v=1.0') }}" rel="stylesheet">
@endsection

@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="wrapper srlog-bdwrapper">
        <div class="main-wrap sc-no-sidebar">

            {{-- Breadcrumb --}}
            <nav aria-label="breadcrumb" class="mb-2">
                <ol class="breadcrumb sc-breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('tyremanage.vehicle.tyre.tagging', $vehicle->id ?? 1) }}">Tyre Management</a>
                    </li>
                    <li class="breadcrumb-item active" id="tact-breadcrumb">Tyre Fitment / Replacement</li>
                </ol>
            </nav>

            {{-- Page Header --}}
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="d-flex align-items-center gap-3">
                    <a href="{{ route('tyremanage.vehicle.tyre.tagging', $vehicle->id ?? 1) }}" class="tact-back-btn">
                        <i class="uil uil-arrow-left"></i>
                    </a>
                    <div>
                        <h5 class="mb-0" id="tact-page-title">
                            <i class="uil uil-circle me-2" style="color:#032671;"></i>Tyre Fitment / Replacement
                        </h5>
                        <span class="text-muted" style="font-size:12px;" id="tact-page-subtitle">Choose an action to perform on this vehicle's tyres</span>
                    </div>
                </div>
            </div>

            {{-- ═══════════════════════════════════════════
                 MODE SELECTOR
            ════════════════════════════════════════════════ --}}
            <div class="mb-4" id="tactModeWrap">
                <div class="tact-mode-hint mb-2">What would you like to do?</div>
                <div class="tact-mode-grid">

                    {{-- Fit Tyre --}}
                    <label class="tact-mode-card" for="tactModeFit">
                        <input type="radio" name="tactMode" id="tactModeFit" value="fit" class="d-none">
                        <div class="tact-mode-icon tact-icon-fit"><i class="uil uil-plus-circle"></i></div>
                        <div class="tact-mode-info">
                            <div class="tact-mode-title">Fit Tyre</div>
                            <div class="tact-mode-desc">Install a tyre from inventory onto an empty position on this vehicle. Records position, fitment date, and odometer.</div>
                        </div>
                        <div class="tact-mode-radio"></div>
                    </label>

                    {{-- Replace Tyre --}}
                    <label class="tact-mode-card" for="tactModeReplace">
                        <input type="radio" name="tactMode" id="tactModeReplace" value="replace" class="d-none">
                        <div class="tact-mode-icon tact-icon-replace"><i class="uil uil-exchange"></i></div>
                        <div class="tact-mode-info">
                            <div class="tact-mode-title">Replace Tyre</div>
                            <div class="tact-mode-desc">Remove the current tyre from a position and fit a new one from inventory or another vehicle.</div>
                        </div>
                        <div class="tact-mode-radio"></div>
                    </label>

                </div>
            </div>

            {{-- ═══════════════════════════════════════════
                 WIZARD BODY — shown after mode selected
            ════════════════════════════════════════════════ --}}
            <div id="tactWizardBody" style="display:none;">

                {{-- Stepper --}}
                <div class="sc-stepper mb-4" id="tactStepper">
                    <div class="sc-step active" data-step="1"><span class="sc-step-num">1</span><span class="sc-step-label tact-sl-1">Select Position</span></div>
                    <div class="sc-step-line"></div>
                    <div class="sc-step" data-step="2"><span class="sc-step-num">2</span><span class="sc-step-label tact-sl-2">Tyre Selection</span></div>
                    <div class="sc-step-line"></div>
                    <div class="sc-step" data-step="3"><span class="sc-step-num">3</span><span class="sc-step-label tact-sl-3">Fitment Details</span></div>
                    <div class="sc-step-line"></div>
                    <div class="sc-step" data-step="4"><span class="sc-step-num">4</span><span class="sc-step-label tact-sl-4">Confirm & Log</span></div>
                </div>

                {{-- ═══════════════════════════════════════
                     FIT MODE STEPS
                ════════════════════════════════════════════ --}}
                <div id="tactFitSteps">

                    {{-- FIT S1 — Select Position --}}
                    <div class="bwiz-step" id="tactFitS1">
                        <div class="sc-card">
                            <div class="sc-card-head"><span class="sc-card-title"><i class="uil uil-map-marker me-2"></i>Step 1 — Select Position</span></div>
                            <div class="p-3 p-md-4">

                                {{-- Vehicle card --}}
                                <div class="bwiz-veh-card mb-3">
                                    <div class="bwiz-veh-header">
                                        <i class="uil uil-truck me-2"></i>
                                        <div>
                                            <div class="bwiz-veh-reg">{{ $vehicle->registration_number ?? 'T00-RAB-1234' }}</div>
                                            <div class="bwiz-veh-model">{{ ($vehicle->vehiclemanagement->make ?? 'Tata') }} {{ ($vehicle->vehiclemanagement->model ?? 'Prima 4928.S') }} — {{ ($vehicle->vehiclemanagement->body_type ?? '12 Wheeler') }}</div>
                                        </div>
                                    </div>
                                </div>

                                <label class="bwiz-label">Select the position where you want to fit the tyre <span class="text-danger">*</span></label>
                                <div class="tact-pos-grid" id="tactFitPosGrid">
                                    <div class="tact-pos-card" data-code="C1">
                                        <span class="tact-pos-code">C1</span>
                                        <span class="tact-pos-lbl">Front Left</span>
                                        <span class="tact-pos-chip tact-pos-chip-free">Free</span>
                                    </div>
                                    <div class="tact-pos-card" data-code="D1">
                                        <span class="tact-pos-code">D1</span>
                                        <span class="tact-pos-lbl">Front Right</span>
                                        <span class="tact-pos-chip tact-pos-chip-free">Free</span>
                                    </div>
                                    <div class="tact-pos-card occupied" data-code="Co3">
                                        <span class="tact-pos-code">Co3</span>
                                        <span class="tact-pos-lbl">R1 L Outer</span>
                                        <span class="tact-pos-chip tact-pos-chip-occ">Occupied</span>
                                    </div>
                                    <div class="tact-pos-card occupied" data-code="Ci2">
                                        <span class="tact-pos-code">Ci2</span>
                                        <span class="tact-pos-lbl">R1 L Inner</span>
                                        <span class="tact-pos-chip tact-pos-chip-occ">Occupied</span>
                                    </div>
                                    <div class="tact-pos-card occupied" data-code="Di2">
                                        <span class="tact-pos-code">Di2</span>
                                        <span class="tact-pos-lbl">R1 R Inner</span>
                                        <span class="tact-pos-chip tact-pos-chip-occ">Occupied</span>
                                    </div>
                                    <div class="tact-pos-card occupied" data-code="Do3">
                                        <span class="tact-pos-code">Do3</span>
                                        <span class="tact-pos-lbl">R1 R Outer</span>
                                        <span class="tact-pos-chip tact-pos-chip-occ">Occupied</span>
                                    </div>
                                    <div class="tact-pos-card occupied" data-code="Ci4">
                                        <span class="tact-pos-code">Ci4</span>
                                        <span class="tact-pos-lbl">R2 L Inner</span>
                                        <span class="tact-pos-chip tact-pos-chip-occ">Occupied</span>
                                    </div>
                                    <div class="tact-pos-card occupied" data-code="Co5">
                                        <span class="tact-pos-code">Co5</span>
                                        <span class="tact-pos-lbl">R2 L Outer</span>
                                        <span class="tact-pos-chip tact-pos-chip-occ">Occupied</span>
                                    </div>
                                    <div class="tact-pos-card occupied" data-code="Di4">
                                        <span class="tact-pos-code">Di4</span>
                                        <span class="tact-pos-lbl">R2 R Inner</span>
                                        <span class="tact-pos-chip tact-pos-chip-occ">Occupied</span>
                                    </div>
                                    <div class="tact-pos-card occupied" data-code="Do5">
                                        <span class="tact-pos-code">Do5</span>
                                        <span class="tact-pos-lbl">R2 R Outer</span>
                                        <span class="tact-pos-chip tact-pos-chip-occ">Occupied</span>
                                    </div>
                                    <div class="tact-pos-card" data-code="S1">
                                        <span class="tact-pos-code">S1</span>
                                        <span class="tact-pos-lbl">Spare</span>
                                        <span class="tact-pos-chip tact-pos-chip-free">Free</span>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end gap-2 mt-4">
                                    <button class="btn btn-primary" id="tactFitNextS2" disabled>
                                        Next <i class="uil uil-arrow-right ms-1"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- FIT S2 — Tyre Selection --}}
                    <div class="bwiz-step" id="tactFitS2" style="display:none;">
                        <div class="sc-card">
                            <div class="sc-card-head">
                                <div class="bwiz-step-nav">
                                    <span class="sc-card-title"><i class="uil uil-circle me-2"></i>Step 2 — Select Tyre from Inventory</span>
                                </div>
                            </div>
                            <div class="p-3 p-md-4">

                                {{-- Selected position info --}}
                                <div class="d-flex align-items-center gap-2 mb-3">
                                    <span class="bwiz-label mb-0">Selected Position:</span>
                                    <span class="tact-pos-badge"><i class="uil uil-map-marker me-1"></i><span id="tactFitPosDisplay">—</span></span>
                                </div>

                                <label class="bwiz-label">Search Tyre by Serial / Brand <span class="text-danger">*</span></label>
                                <div class="row g-3 mb-3">
                                    <div class="col-12 col-md-5">
                                        <select class="form-select" id="tactFitTyreSelect" style="width:100%;">
                                            <option value="">Search tyre from inventory...</option>
                                            <option value="TYR-2026-00041">TYR-2026-00041 — Bridgestone R150 (New)</option>
                                            <option value="TYR-2025-00088">TYR-2025-00088 — MRF Zvts (New)</option>
                                            <option value="TYR-2024-00033">TYR-2024-00033 — Ceat Milaze (Reuse)</option>
                                            <option value="TYR-2023-00009">TYR-2023-00009 — Apollo Endurace (Used)</option>
                                        </select>
                                        <div class="form-text text-muted">Only tyres with status: Warehouse / Reuse are shown</div>
                                    </div>
                                </div>

                                {{-- Selected tyre card --}}
                                <div class="tact-tyre-card mb-3" id="tactFitTyreCard">
                                    <div class="tact-tyre-header">
                                        <i class="uil uil-circle"></i>
                                        <div class="tact-tyre-serial">TYR-2026-00041</div>
                                    </div>
                                    <div class="row g-0">
                                        <div class="col-6 col-md-3 bwiz-bat-field">
                                            <span class="bwiz-bat-fl">Brand</span>
                                            <span class="bwiz-bat-fv">Bridgestone</span>
                                        </div>
                                        <div class="col-6 col-md-3 bwiz-bat-field">
                                            <span class="bwiz-bat-fl">Model</span>
                                            <span class="bwiz-bat-fv">R150</span>
                                        </div>
                                        <div class="col-6 col-md-3 bwiz-bat-field">
                                            <span class="bwiz-bat-fl">Size</span>
                                            <span class="bwiz-bat-fv">10.00 R20</span>
                                        </div>
                                        <div class="col-6 col-md-3 bwiz-bat-field">
                                            <span class="bwiz-bat-fl">Condition</span>
                                            <span class="bwiz-bat-fv">New</span>
                                        </div>
                                        <div class="col-6 col-md-3 bwiz-bat-field">
                                            <span class="bwiz-bat-fl">Type</span>
                                            <span class="bwiz-bat-fv">Radial</span>
                                        </div>
                                        <div class="col-6 col-md-3 bwiz-bat-field">
                                            <span class="bwiz-bat-fl">Rated KM Life</span>
                                            <span class="bwiz-bat-fv">80,000 KM</span>
                                        </div>
                                        <div class="col-6 col-md-3 bwiz-bat-field">
                                            <span class="bwiz-bat-fl">Purchase Date</span>
                                            <span class="bwiz-bat-fv">12 Jan 2026</span>
                                        </div>
                                        <div class="col-6 col-md-3 bwiz-bat-field">
                                            <span class="bwiz-bat-fl">Status</span>
                                            <span class="bwiz-bat-fv" style="color:#10863f;font-weight:700;">Warehouse</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between gap-2 mt-4">
                                    <button class="btn btn-outline-secondary" id="tactFitBackS1"><i class="uil uil-arrow-left me-1"></i>Back</button>
                                    <button class="btn btn-primary" id="tactFitNextS3">Next <i class="uil uil-arrow-right ms-1"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- FIT S3 — Fitment Details --}}
                    <div class="bwiz-step" id="tactFitS3" style="display:none;">
                        <div class="sc-card">
                            <div class="sc-card-head"><span class="sc-card-title"><i class="uil uil-clipboard-alt me-2"></i>Step 3 — Fitment Details</span></div>
                            <div class="p-3 p-md-4">
                                <div class="row g-3">
                                    <div class="col-12 col-md-4">
                                        <label class="bwiz-label">Fitment Date <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" id="tactFitDate" value="{{ date('Y-m-d') }}">
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label class="bwiz-label">Odometer at Fitting (KM) <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" placeholder="e.g. 145000">
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label class="bwiz-label">Technician / Fitter Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" placeholder="e.g. Ravi Kumar">
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label class="bwiz-label">Tyre Pressure at Fitment (PSI)</label>
                                        <input type="number" class="form-control" placeholder="e.g. 100">
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label class="bwiz-label">Workshop / Service Centre</label>
                                        <select class="form-select">
                                            <option value="">Select workshop...</option>
                                            <option>Main Depot — Kolkata HQ</option>
                                            <option>Regional Service Centre — Delhi</option>
                                            <option>External — Patel Tyre Works</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label class="bwiz-label">Fitment Cost (₹)</label>
                                        <input type="number" class="form-control" placeholder="e.g. 500">
                                    </div>
                                    <div class="col-12">
                                        <label class="bwiz-label">Remarks</label>
                                        <textarea class="form-control" rows="2" placeholder="Any notes about this fitment..."></textarea>
                                    </div>
                                    <div class="col-12">
                                        <label class="bwiz-label">Upload Photo (optional)</label>
                                        <div class="bwiz-upload-zone" onclick="document.getElementById('tactFitPhoto').click()">
                                            <i class="bwiz-upload-icon uil uil-image-upload"></i>
                                            <div>Drag & drop or <span class="bwiz-upload-link">browse</span> to upload</div>
                                            <div class="text-muted" style="font-size:11px;margin-top:4px;">JPG, PNG, PDF · Max 5MB</div>
                                        </div>
                                        <input type="file" id="tactFitPhoto" class="d-none" accept="image/*,.pdf">
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between gap-2 mt-4">
                                    <button class="btn btn-outline-secondary" id="tactFitBackS2"><i class="uil uil-arrow-left me-1"></i>Back</button>
                                    <button class="btn btn-primary" id="tactFitNextS4">Review &amp; Confirm <i class="uil uil-arrow-right ms-1"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- FIT S4 — Confirm & Log --}}
                    <div class="bwiz-step" id="tactFitS4" style="display:none;">
                        <div class="sc-card">
                            <div class="sc-card-head"><span class="sc-card-title"><i class="uil uil-check-circle me-2"></i>Step 4 — Confirm & Log</span></div>
                            <div class="p-3 p-md-4">
                                <div class="bwiz-confirm-summary mb-3">
                                    <div class="bwiz-confirm-section-title">Vehicle</div>
                                    <div class="row g-0">
                                        <div class="col-6 col-md-3 bwiz-conf-field"><span class="bwiz-conf-l">Registration</span><span class="bwiz-conf-v" id="tactFitConfVeh">—</span></div>
                                        <div class="col-6 col-md-3 bwiz-conf-field"><span class="bwiz-conf-l">Position</span><span class="bwiz-conf-v" id="tactFitConfPos">—</span></div>
                                    </div>
                                    <div class="bwiz-confirm-section-title mt-3">Tyre Being Fitted</div>
                                    <div class="row g-0">
                                        <div class="col-6 col-md-3 bwiz-conf-field"><span class="bwiz-conf-l">Serial</span><span class="bwiz-conf-v" id="tactFitConfSerial">—</span></div>
                                        <div class="col-6 col-md-3 bwiz-conf-field"><span class="bwiz-conf-l">Brand</span><span class="bwiz-conf-v" id="tactFitConfBrand">—</span></div>
                                        <div class="col-6 col-md-3 bwiz-conf-field"><span class="bwiz-conf-l">Condition</span><span class="bwiz-conf-v" id="tactFitConfCond">—</span></div>
                                        <div class="col-6 col-md-3 bwiz-conf-field"><span class="bwiz-conf-l">KM Life</span><span class="bwiz-conf-v" id="tactFitConfKm">—</span></div>
                                    </div>
                                    <div class="bwiz-confirm-section-title mt-3">Fitment Details</div>
                                    <div class="row g-0">
                                        <div class="col-6 col-md-3 bwiz-conf-field"><span class="bwiz-conf-l">Date</span><span class="bwiz-conf-v" id="tactFitConfDate">—</span></div>
                                        <div class="col-6 col-md-3 bwiz-conf-field"><span class="bwiz-conf-l">Odometer</span><span class="bwiz-conf-v" id="tactFitConfOdo">—</span></div>
                                        <div class="col-6 col-md-3 bwiz-conf-field"><span class="bwiz-conf-l">Technician</span><span class="bwiz-conf-v" id="tactFitConfTech">—</span></div>
                                    </div>
                                </div>

                                <div class="bwiz-confirm-check mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="tactFitConfirmChk">
                                        <label class="form-check-label" for="tactFitConfirmChk">
                                            I confirm that the above tyre has been physically fitted to the specified position on the vehicle. All details are accurate and I authorise this log entry.
                                        </label>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between gap-2">
                                    <button class="btn btn-outline-secondary" id="tactFitBackS3"><i class="uil uil-arrow-left me-1"></i>Back</button>
                                    <button class="btn btn-success" id="tactFitSubmit" disabled>
                                        <i class="uil uil-check me-1"></i>Confirm Fitment
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>{{-- /tactFitSteps --}}

                {{-- ═══════════════════════════════════════
                     REPLACE MODE STEPS
                ════════════════════════════════════════════ --}}
                <div id="tactRepSteps" style="display:none;">

                    {{-- REPLACE S1 — Identify Position --}}
                    <div class="bwiz-step" id="tactRepS1">
                        <div class="sc-card">
                            <div class="sc-card-head"><span class="sc-card-title"><i class="uil uil-map-marker me-2"></i>Step 1 — Identify Position to Replace</span></div>
                            <div class="p-3 p-md-4">

                                {{-- Vehicle card --}}
                                <div class="bwiz-veh-card mb-3">
                                    <div class="bwiz-veh-header">
                                        <i class="uil uil-truck me-2"></i>
                                        <div>
                                            <div class="bwiz-veh-reg">{{ $vehicle->registration_number ?? 'T00-RAB-1234' }}</div>
                                            <div class="bwiz-veh-model">{{ ($vehicle->vehiclemanagement->make ?? 'Tata') }} {{ ($vehicle->vehiclemanagement->model ?? 'Prima 4928.S') }}</div>
                                        </div>
                                    </div>
                                </div>

                                <label class="bwiz-label">Select the position whose tyre you want to replace <span class="text-danger">*</span></label>
                                <div class="tact-pos-grid" id="tactRepPosGrid">
                                    <div class="tact-pos-card" data-code="C1">
                                        <span class="tact-pos-code">C1</span>
                                        <span class="tact-pos-lbl">Front Left</span>
                                        <span class="tact-pos-chip tact-pos-chip-free">Free</span>
                                    </div>
                                    <div class="tact-pos-card occupied" data-code="Co3">
                                        <span class="tact-pos-code">Co3</span>
                                        <span class="tact-pos-lbl">R1 L Outer</span>
                                        <span class="tact-pos-chip tact-pos-chip-occ">TYR-00041</span>
                                    </div>
                                    <div class="tact-pos-card occupied" data-code="Ci2">
                                        <span class="tact-pos-code">Ci2</span>
                                        <span class="tact-pos-lbl">R1 L Inner</span>
                                        <span class="tact-pos-chip tact-pos-chip-occ">TYR-00088</span>
                                    </div>
                                    <div class="tact-pos-card occupied" data-code="Di2">
                                        <span class="tact-pos-code">Di2</span>
                                        <span class="tact-pos-lbl">R1 R Inner</span>
                                        <span class="tact-pos-chip tact-pos-chip-occ">TYR-00033</span>
                                    </div>
                                    <div class="tact-pos-card occupied" data-code="Do3">
                                        <span class="tact-pos-code">Do3</span>
                                        <span class="tact-pos-lbl">R1 R Outer</span>
                                        <span class="tact-pos-chip tact-pos-chip-occ">TYR-00009</span>
                                    </div>
                                    <div class="tact-pos-card occupied" data-code="D1">
                                        <span class="tact-pos-code">D1</span>
                                        <span class="tact-pos-lbl">Front Right</span>
                                        <span class="tact-pos-chip tact-pos-chip-occ">TYR-00055</span>
                                    </div>
                                    <div class="tact-pos-card occupied" data-code="S1">
                                        <span class="tact-pos-code">S1</span>
                                        <span class="tact-pos-lbl">Spare</span>
                                        <span class="tact-pos-chip tact-pos-chip-occ">TYR-00066</span>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end gap-2 mt-4">
                                    <button class="btn btn-primary" id="tactRepNextS2" disabled>
                                        Next <i class="uil uil-arrow-right ms-1"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- REPLACE S2 — Removal Details + Disposal --}}
                    <div class="bwiz-step" id="tactRepS2" style="display:none;">
                        <div class="sc-card">
                            <div class="sc-card-head"><span class="sc-card-title"><i class="uil uil-circle me-2"></i>Step 2 — Removal Details & Disposal</span></div>
                            <div class="p-3 p-md-4">

                                {{-- Current tyre being removed --}}
                                <div class="bwiz-label mb-1">Current Tyre at Position <span class="tact-pos-badge ms-1"><span id="tactRepPosDisplay">—</span></span></div>
                                <div class="tact-tyre-card mb-3" id="tactRepOldTyreCard">
                                    <div class="tact-tyre-header">
                                        <i class="uil uil-circle"></i>
                                        <div class="tact-tyre-serial">TYR-2024-00041</div>
                                    </div>
                                    <div class="row g-0">
                                        <div class="col-6 col-md-3 bwiz-bat-field"><span class="bwiz-bat-fl">Brand</span><span class="bwiz-bat-fv">Ceat</span></div>
                                        <div class="col-6 col-md-3 bwiz-bat-field"><span class="bwiz-bat-fl">Model</span><span class="bwiz-bat-fv">Milaze</span></div>
                                        <div class="col-6 col-md-3 bwiz-bat-field"><span class="bwiz-bat-fl">Fitted On</span><span class="bwiz-bat-fv">15 Mar 2024</span></div>
                                        <div class="col-6 col-md-3 bwiz-bat-field"><span class="bwiz-bat-fl">KM Run</span><span class="bwiz-bat-fv bwiz-veh-cur-bat">68,400 KM</span></div>
                                        <div class="col-6 col-md-3 bwiz-bat-field"><span class="bwiz-bat-fl">Condition</span><span class="bwiz-bat-fv">Worn</span></div>
                                        <div class="col-6 col-md-3 bwiz-bat-field"><span class="bwiz-bat-fl">KM Balance</span><span class="bwiz-bat-fv" style="color:#ea0027;font-weight:700;">Overdue</span></div>
                                    </div>
                                </div>

                                {{-- Removal Details --}}
                                <div class="row g-3 mb-4">
                                    <div class="col-12 col-md-4">
                                        <label class="bwiz-label">Removal Date <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" value="{{ date('Y-m-d') }}">
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label class="bwiz-label">Odometer at Removal (KM) <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" placeholder="e.g. 213400">
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label class="bwiz-label">Reason for Removal <span class="text-danger">*</span></label>
                                        <select class="form-select">
                                            <option value="">Select reason...</option>
                                            <option>Worn Out / KM Life Exhausted</option>
                                            <option>Puncture / Damage</option>
                                            <option>Bulge / Sidewall Damage</option>
                                            <option>Uneven Wear</option>
                                            <option>Scheduled Replacement</option>
                                            <option>Rotation</option>
                                            <option>Other</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label class="bwiz-label">Technician / Workshop</label>
                                        <input type="text" class="form-control" placeholder="e.g. Ravi Kumar / Main Depot">
                                    </div>
                                    <div class="col-12">
                                        <label class="bwiz-label">Upload Removal Photo (optional)</label>
                                        <div class="bwiz-upload-zone" onclick="document.getElementById('tactRepPhoto').click()">
                                            <i class="bwiz-upload-icon uil uil-image-upload"></i>
                                            <div>Drag & drop or <span class="bwiz-upload-link">browse</span> to upload</div>
                                            <div class="text-muted" style="font-size:11px;margin-top:4px;">JPG, PNG, PDF · Max 5MB</div>
                                        </div>
                                        <input type="file" id="tactRepPhoto" class="d-none" accept="image/*,.pdf">
                                    </div>
                                </div>

                                {{-- Disposal --}}
                                <label class="bwiz-label mb-2">What to do with the removed tyre? <span class="text-danger">*</span></label>
                                <div class="tact-disposal-grid" id="tactRepDisposalGroup">
                                    <label class="tact-disposal-card" for="tactRepDispWorkshop">
                                        <input type="radio" name="tactRepDisposal" id="tactRepDispWorkshop" value="workshop" class="d-none">
                                        <div class="tact-disp-icon" style="background:#e8f0ff;color:#032671;"><i class="uil uil-wrench"></i></div>
                                        <div>
                                            <div class="tact-disp-title">Send to Workshop</div>
                                            <div style="font-size:11px;color:#8898aa;">Repair / Retread</div>
                                        </div>
                                    </label>
                                    <label class="tact-disposal-card" for="tactRepDispScrap">
                                        <input type="radio" name="tactRepDisposal" id="tactRepDispScrap" value="scrap" class="d-none">
                                        <div class="tact-disp-icon" style="background:#fdecea;color:#ea0027;"><i class="uil uil-trash-alt"></i></div>
                                        <div>
                                            <div class="tact-disp-title">Scrap / Dispose</div>
                                            <div style="font-size:11px;color:#8898aa;">Write off from records</div>
                                        </div>
                                    </label>
                                    <label class="tact-disposal-card" for="tactRepDispStock">
                                        <input type="radio" name="tactRepDisposal" id="tactRepDispStock" value="stock" class="d-none">
                                        <div class="tact-disp-icon" style="background:#e6f4ea;color:#10863f;"><i class="uil uil-box"></i></div>
                                        <div>
                                            <div class="tact-disp-title">Return to Stock</div>
                                            <div style="font-size:11px;color:#8898aa;">Keep in warehouse</div>
                                        </div>
                                    </label>
                                    <label class="tact-disposal-card" for="tactRepDispRetread">
                                        <input type="radio" name="tactRepDisposal" id="tactRepDispRetread" value="retread" class="d-none">
                                        <div class="tact-disp-icon" style="background:#fff3e0;color:#d97706;"><i class="uil uil-redo"></i></div>
                                        <div>
                                            <div class="tact-disp-title">Send for Retread</div>
                                            <div style="font-size:11px;color:#8898aa;">Retread &amp; reuse</div>
                                        </div>
                                    </label>
                                </div>

                                <div class="d-flex justify-content-between gap-2 mt-4">
                                    <button class="btn btn-outline-secondary" id="tactRepBackS1"><i class="uil uil-arrow-left me-1"></i>Back</button>
                                    <button class="btn btn-primary" id="tactRepNextS3">Next <i class="uil uil-arrow-right ms-1"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- REPLACE S3 — Select Replacement Tyre --}}
                    <div class="bwiz-step" id="tactRepS3" style="display:none;">
                        <div class="sc-card">
                            <div class="sc-card-head"><span class="sc-card-title"><i class="uil uil-circle me-2"></i>Step 3 — Select Replacement Tyre</span></div>
                            <div class="p-3 p-md-4">

                                {{-- Source toggle --}}
                                <label class="bwiz-label mb-2">Where is the replacement tyre coming from? <span class="text-danger">*</span></label>
                                <div class="tact-source-grid mb-3" id="tactRepSrcGroup">
                                    <label class="tact-source-card" for="tactRepSrcInventory">
                                        <input type="radio" name="tactRepSrc" id="tactRepSrcInventory" value="inventory" class="d-none">
                                        <div class="tact-src-icon"><i class="uil uil-box"></i></div>
                                        <div>
                                            <div class="tact-src-title">From Inventory</div>
                                            <div class="tact-src-desc">Select from tyres available in the warehouse stock</div>
                                        </div>
                                        <div class="tact-src-radio"></div>
                                    </label>
                                    <label class="tact-source-card" for="tactRepSrcVehicle">
                                        <input type="radio" name="tactRepSrc" id="tactRepSrcVehicle" value="vehicle" class="d-none">
                                        <div class="tact-src-icon"><i class="uil uil-truck"></i></div>
                                        <div>
                                            <div class="tact-src-title">From Another Vehicle</div>
                                            <div class="tact-src-desc">Transfer a tyre from a different vehicle position</div>
                                        </div>
                                        <div class="tact-src-radio"></div>
                                    </label>
                                </div>

                                {{-- Inventory panel --}}
                                <div id="tactRepSrcInventoryPanel" style="display:none;">
                                    <label class="bwiz-label">Search Tyre by Serial / Brand <span class="text-danger">*</span></label>
                                    <div class="row g-3 mb-3">
                                        <div class="col-12 col-md-5">
                                            <select class="form-select" id="tactRepTyreSelect" style="width:100%;">
                                                <option value="">Search tyre from inventory...</option>
                                                <option value="TYR-2026-00041">TYR-2026-00041 — Bridgestone R150 (New)</option>
                                                <option value="TYR-2025-00088">TYR-2025-00088 — MRF Zvts (New)</option>
                                                <option value="TYR-2024-00033">TYR-2024-00033 — Ceat Milaze (Reuse)</option>
                                            </select>
                                            <div class="form-text text-muted">Only stock tyres: Warehouse / Reuse</div>
                                        </div>
                                    </div>
                                    <div class="tact-tyre-card mb-3" id="tactRepNewTyreCard" style="display:none;">
                                        <div class="tact-tyre-header">
                                            <i class="uil uil-circle"></i>
                                            <div class="tact-tyre-serial" id="tactRepNewTyreSerial">—</div>
                                        </div>
                                        <div class="row g-0">
                                            <div class="col-6 col-md-3 bwiz-bat-field"><span class="bwiz-bat-fl">Brand</span><span class="bwiz-bat-fv" id="tactRepNewBrand">—</span></div>
                                            <div class="col-6 col-md-3 bwiz-bat-field"><span class="bwiz-bat-fl">Model</span><span class="bwiz-bat-fv" id="tactRepNewModel">—</span></div>
                                            <div class="col-6 col-md-3 bwiz-bat-field"><span class="bwiz-bat-fl">Condition</span><span class="bwiz-bat-fv" id="tactRepNewCond">—</span></div>
                                            <div class="col-6 col-md-3 bwiz-bat-field"><span class="bwiz-bat-fl">KM Life</span><span class="bwiz-bat-fv" id="tactRepNewKm">—</span></div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Another vehicle panel --}}
                                <div id="tactRepSrcVehiclePanel" style="display:none;">
                                    <div class="row g-3 mb-3">
                                        <div class="col-12 col-md-5">
                                            <label class="bwiz-label">Select Source Vehicle <span class="text-danger">*</span></label>
                                            <select class="form-select" id="tactRepSrcVehSelect" style="width:100%;">
                                                <option value="">Search vehicle by registration...</option>
                                                <option value="KA01AB1234">KA01AB1234 — Tata Prima 4928.S</option>
                                                <option value="MH12CD5678">MH12CD5678 — Ashok Leyland 4923</option>
                                                <option value="DL4CAF9090">DL4CAF9090 — Eicher Pro 6016</option>
                                            </select>
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <label class="bwiz-label">Select Position on Source Vehicle <span class="text-danger">*</span></label>
                                            <select class="form-select" id="tactRepSrcPosSelect">
                                                <option value="">— select vehicle first —</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="tact-tyre-card mb-3" id="tactRepSrcVehTyreCard" style="display:none;">
                                        <div class="tact-tyre-header">
                                            <i class="uil uil-circle"></i>
                                            <div class="tact-tyre-serial">TYR-2025-00088 — MRF Zvts</div>
                                        </div>
                                        <div class="row g-0">
                                            <div class="col-6 col-md-3 bwiz-bat-field"><span class="bwiz-bat-fl">Condition</span><span class="bwiz-bat-fv">Used</span></div>
                                            <div class="col-6 col-md-3 bwiz-bat-field"><span class="bwiz-bat-fl">KM Run</span><span class="bwiz-bat-fv">22,100 KM</span></div>
                                            <div class="col-6 col-md-3 bwiz-bat-field"><span class="bwiz-bat-fl">KM Remaining</span><span class="bwiz-bat-fv" style="color:#10863f;">57,900 KM</span></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between gap-2 mt-4">
                                    <button class="btn btn-outline-secondary" id="tactRepBackS2"><i class="uil uil-arrow-left me-1"></i>Back</button>
                                    <button class="btn btn-primary" id="tactRepNextS4" disabled>Review &amp; Confirm <i class="uil uil-arrow-right ms-1"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- REPLACE S4 — Confirm Swap --}}
                    <div class="bwiz-step" id="tactRepS4" style="display:none;">
                        <div class="sc-card">
                            <div class="sc-card-head"><span class="sc-card-title"><i class="uil uil-check-circle me-2"></i>Step 4 — Confirm Replacement</span></div>
                            <div class="p-3 p-md-4">

                                {{-- Swap summary cards --}}
                                <div class="tact-swap-wrap mb-3">
                                    <div class="tact-swap-card tact-swap-out">
                                        <div class="tact-swap-header"><i class="uil uil-arrow-up me-1"></i>Tyre Being Removed</div>
                                        <div class="tact-swap-body">
                                            <div class="bwiz-conf-field"><span class="bwiz-conf-l">Serial</span><span class="bwiz-conf-v" id="tactRepConfOutSerial">—</span></div>
                                            <div class="bwiz-conf-field"><span class="bwiz-conf-l">Brand</span><span class="bwiz-conf-v" id="tactRepConfOutBrand">—</span></div>
                                            <div class="bwiz-conf-field"><span class="bwiz-conf-l">Position</span><span class="bwiz-conf-v" id="tactRepConfOutPos">—</span></div>
                                            <div class="bwiz-conf-field"><span class="bwiz-conf-l">Disposal</span><span class="bwiz-conf-v" id="tactRepConfOutDisposal">—</span></div>
                                        </div>
                                    </div>
                                    <div class="tact-swap-arrow"><i class="uil uil-exchange-alt"></i></div>
                                    <div class="tact-swap-card tact-swap-in">
                                        <div class="tact-swap-header"><i class="uil uil-arrow-down me-1"></i>Tyre Being Fitted</div>
                                        <div class="tact-swap-body">
                                            <div class="bwiz-conf-field"><span class="bwiz-conf-l">Serial</span><span class="bwiz-conf-v" id="tactRepConfInSerial">—</span></div>
                                            <div class="bwiz-conf-field"><span class="bwiz-conf-l">Brand</span><span class="bwiz-conf-v" id="tactRepConfInBrand">—</span></div>
                                            <div class="bwiz-conf-field"><span class="bwiz-conf-l">Condition</span><span class="bwiz-conf-v" id="tactRepConfInCond">—</span></div>
                                            <div class="bwiz-conf-field"><span class="bwiz-conf-l">Source</span><span class="bwiz-conf-v" id="tactRepConfInSource">—</span></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="bwiz-confirm-check mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="tactRepConfirmChk">
                                        <label class="form-check-label" for="tactRepConfirmChk">
                                            I confirm that the tyre replacement described above has been physically carried out. The removed tyre has been appropriately handled per the selected disposal method. All details are accurate.
                                        </label>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between gap-2">
                                    <button class="btn btn-outline-secondary" id="tactRepBackS3"><i class="uil uil-arrow-left me-1"></i>Back</button>
                                    <button class="btn btn-danger" id="tactRepSubmit" disabled>
                                        <i class="uil uil-exchange-alt me-1"></i>Confirm Replacement
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>{{-- /tactRepSteps --}}

            </div>{{-- /tactWizardBody --}}

        </div>
    </div>
</div>
@endsection

@section('js')
<script>
$(function () {

    /* ── Mode selection ─────────────────────────── */
    var currentMode = null;
    var fitPos = null, repPos = null;

    $('.tact-mode-card').on('click', function () {
        $('.tact-mode-card').removeClass('active');
        $(this).addClass('active');
        var mode = $(this).find('input[type=radio]').val();
        currentMode = mode;
        activateMode(mode);
    });

    function activateMode(mode) {
        $('#tactModeWrap').find('.tact-mode-hint').text('Selected:');
        $('#tactWizardBody').show();
        $('#tactFitSteps').hide();
        $('#tactRepSteps').hide();
        resetStepper();

        if (mode === 'fit') {
            $('#tactFitSteps').show();
            setStepLabels('Select Position', 'Tyre Selection', 'Fitment Details', 'Confirm & Log');
            $('#tact-page-title').html('<i class="uil uil-plus-circle me-2" style="color:#10863f;"></i>Tyre Fitment');
            $('#tact-page-subtitle').text('Install a tyre from inventory onto this vehicle');
        } else {
            $('#tactRepSteps').show();
            setStepLabels('Select Position', 'Removal Details', 'Select Replacement', 'Confirm Swap');
            $('#tact-page-title').html('<i class="uil uil-exchange me-2" style="color:#ea0027;"></i>Tyre Replacement');
            $('#tact-page-subtitle').text('Remove current tyre and fit replacement');
        }
        goToStep(1);
    }

    function setStepLabels(l1, l2, l3, l4) {
        $('.tact-sl-1').text(l1);
        $('.tact-sl-2').text(l2);
        $('.tact-sl-3').text(l3);
        $('.tact-sl-4').text(l4);
    }

    /* ── Stepper helpers ────────────────────────── */
    function resetStepper() {
        $('#tactStepper .sc-step').removeClass('active done');
        $('#tactStepper .sc-step-line').removeClass('done');
        $('#tactStepper .sc-step[data-step="1"]').addClass('active');
    }

    function goToStep(n) {
        var $steps = $('#tactStepper .sc-step');
        var $lines = $('#tactStepper .sc-step-line');
        $steps.removeClass('active done');
        $lines.removeClass('done');
        $steps.each(function () {
            var s = parseInt($(this).data('step'));
            if (s < n) { $(this).addClass('done'); }
            else if (s === n) { $(this).addClass('active'); }
        });
        $lines.each(function (i) { if (i < n - 1) $(this).addClass('done'); });
    }

    /* ── FIT: Position selection ────────────────── */
    $('#tactFitPosGrid').on('click', '.tact-pos-card:not(.occupied)', function () {
        $('#tactFitPosGrid .tact-pos-card').removeClass('active');
        $(this).addClass('active');
        fitPos = $(this).data('code');
        $('#tactFitNextS2').prop('disabled', false);
    });

    $('#tactFitNextS2').on('click', function () {
        var lbl = $('#tactFitPosGrid .tact-pos-card.active .tact-pos-code').text()
                + ' — '
                + $('#tactFitPosGrid .tact-pos-card.active .tact-pos-lbl').text();
        $('#tactFitPosDisplay').text(lbl);
        tactShowFitStep('S2'); goToStep(2);
    });
    $('#tactFitBackS1').on('click', function () { tactShowFitStep('S1'); goToStep(1); });
    $('#tactFitNextS3').on('click', function () { tactShowFitStep('S3'); goToStep(3); });
    $('#tactFitBackS2').on('click', function () { tactShowFitStep('S2'); goToStep(2); });
    $('#tactFitNextS4').on('click', function () {
        populateFitConfirm();
        tactShowFitStep('S4'); goToStep(4);
    });
    $('#tactFitBackS3').on('click', function () { tactShowFitStep('S3'); goToStep(3); });

    function tactShowFitStep(s) {
        $('#tactFitS1,#tactFitS2,#tactFitS3,#tactFitS4').hide();
        $('#tactFitS'+s.replace('S','')).show();
    }

    function populateFitConfirm() {
        $('#tactFitConfVeh').text('{{ $vehicle->registration_number ?? "T00-RAB-1234" }}');
        $('#tactFitConfPos').text(fitPos || '—');
        $('#tactFitConfSerial').text('TYR-2026-00041');
        $('#tactFitConfBrand').text('Bridgestone R150');
        $('#tactFitConfCond').text('New');
        $('#tactFitConfKm').text('80,000 KM');
        $('#tactFitConfDate').text($('#tactFitDate').val());
    }

    $('#tactFitConfirmChk').on('change', function () {
        $('#tactFitSubmit').prop('disabled', !$(this).is(':checked'));
    });

    /* ── REPLACE: Position selection ───────────── */
    $('#tactRepPosGrid').on('click', '.tact-pos-card', function () {
        $('#tactRepPosGrid .tact-pos-card').removeClass('active');
        $(this).addClass('active');
        repPos = $(this).data('code');
        $('#tactRepNextS2').prop('disabled', false);
    });

    $('#tactRepNextS2').on('click', function () {
        $('#tactRepPosDisplay').text(repPos || '—');
        tactShowRepStep(2); goToStep(2);
    });
    $('#tactRepBackS1').on('click', function () { tactShowRepStep(1); goToStep(1); });
    $('#tactRepNextS3').on('click', function () { tactShowRepStep(3); goToStep(3); });
    $('#tactRepBackS2').on('click', function () { tactShowRepStep(2); goToStep(2); });
    $('#tactRepNextS4').on('click', function () {
        populateRepConfirm();
        tactShowRepStep(4); goToStep(4);
    });
    $('#tactRepBackS3').on('click', function () { tactShowRepStep(3); goToStep(3); });

    function tactShowRepStep(n) {
        $('#tactRepS1,#tactRepS2,#tactRepS3,#tactRepS4').hide();
        $('#tactRepS'+n).show();
    }

    /* ── Disposal card toggle ───────────────────── */
    $('#tactRepDisposalGroup').on('click', '.tact-disposal-card', function () {
        $('#tactRepDisposalGroup .tact-disposal-card').removeClass('active');
        $(this).addClass('active');
    });

    /* ── Replace source toggle ──────────────────── */
    $('#tactRepSrcGroup').on('click', '.tact-source-card', function () {
        $('#tactRepSrcGroup .tact-source-card').removeClass('active');
        $(this).addClass('active');
        var src = $(this).find('input').val();
        $('#tactRepSrcInventoryPanel').toggle(src === 'inventory');
        $('#tactRepSrcVehiclePanel').toggle(src === 'vehicle');
        $('#tactRepNextS4').prop('disabled', false);
    });

    /* ── Source vehicle position dropdown ───────── */
    $('#tactRepSrcVehSelect').on('change', function () {
        var $pos = $('#tactRepSrcPosSelect');
        $pos.html('<option value="">— select position —</option>');
        if ($(this).val()) {
            var positions = ['C1 — Front Left','D1 — Front Right','Co3 — R1 L Outer','Ci2 — R1 L Inner','Di2 — R1 R Inner','Do3 — R1 R Outer','S1 — Spare'];
            $.each(positions, function (i, p) {
                $pos.append('<option>' + p + '</option>');
            });
            $('#tactRepSrcVehTyreCard').show();
        }
    });

    function populateRepConfirm() {
        $('#tactRepConfOutSerial').text('TYR-2024-00041');
        $('#tactRepConfOutBrand').text('Ceat Milaze');
        $('#tactRepConfOutPos').text(repPos || '—');
        $('#tactRepConfOutDisposal').text($('#tactRepDisposalGroup .tact-disposal-card.active .tact-disp-title').text() || '—');
        var src = $('#tactRepSrcGroup .tact-source-card.active input').val();
        if (src === 'inventory') {
            var v = $('#tactRepTyreSelect').val();
            $('#tactRepConfInSerial').text(v || '—');
            $('#tactRepConfInBrand').text(v ? 'Bridgestone R150' : '—');
            $('#tactRepConfInCond').text('New');
            $('#tactRepConfInSource').text('Warehouse Inventory');
        } else {
            $('#tactRepConfInSerial').text('TYR-2025-00088');
            $('#tactRepConfInBrand').text('MRF Zvts');
            $('#tactRepConfInCond').text('Used');
            $('#tactRepConfInSource').text($('#tactRepSrcVehSelect').find(':selected').text() || '—');
        }
    }

    $('#tactRepConfirmChk').on('change', function () {
        $('#tactRepSubmit').prop('disabled', !$(this).is(':checked'));
    });

});
</script>
@endsection
