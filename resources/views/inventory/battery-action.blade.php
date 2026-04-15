@extends('layouts.app')

@section('css')
<link href="{{ asset('css/Inventory/battery-wizard.css?v=1.2') }}" rel="stylesheet">
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
                    <li class="breadcrumb-item"><a href="{{ route('inventory.battery-dashboard') }}">Battery Dashboard</a></li>
                    <li class="breadcrumb-item active" id="bact-breadcrumb">Battery Action</li>
                </ol>
            </nav>

            {{-- Page Header --}}
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="d-flex align-items-center gap-3">
                    <a href="{{ route('inventory.battery-dashboard') }}" class="bdet-back-btn">
                        <i class="uil uil-arrow-left"></i>
                    </a>
                    <div>
                        <h5 class="mb-0" id="bact-page-title">
                            <i class="uil uil-bolt-alt me-2" style="color:#032671;"></i>Battery Action
                        </h5>
                        <span class="text-muted" style="font-size:12px;" id="bact-page-subtitle">Choose an action to perform on battery inventory</span>
                    </div>
                </div>
            </div>

            {{-- ═══════════════════════════════════════════
                 MODE SELECTOR
            ════════════════════════════════════════════════ --}}
            <div class="bact-mode-wrap mb-4" id="bactModeWrap">
                <div class="bact-mode-hint mb-2">What would you like to do?</div>
                <div class="bact-mode-grid bact-mode-grid-3">

                    {{-- Fit Battery --}}
                    <label class="bact-mode-card" for="bactModeFit">
                        <input type="radio" name="bactMode" id="bactModeFit" value="fit" class="d-none">
                        <div class="bact-mode-icon bact-icon-fit"><i class="uil uil-car-sideview"></i></div>
                        <div class="bact-mode-info">
                            <div class="bact-mode-title">Fit Battery</div>
                            <div class="bact-mode-desc">Install a battery from stock onto a fleet vehicle. Records fitting, technician and odometer.</div>
                        </div>
                        <div class="bact-mode-radio"></div>
                    </label>

                    {{-- Replace Battery --}}
                    <label class="bact-mode-card" for="bactModeReplace">
                        <input type="radio" name="bactMode" id="bactModeReplace" value="replace" class="d-none">
                        <div class="bact-mode-icon bact-icon-replace"><i class="uil uil-exchange"></i></div>
                        <div class="bact-mode-info">
                            <div class="bact-mode-title">Replace Battery</div>
                            <div class="bact-mode-desc">Remove the current battery from a vehicle and fit a new one from inventory or another vehicle.</div>
                        </div>
                        <div class="bact-mode-radio"></div>
                    </label>

                    {{-- Rotate Battery --}}
                    <label class="bact-mode-card" for="bactModeRotate">
                        <input type="radio" name="bactMode" id="bactModeRotate" value="rotate" class="d-none">
                        <div class="bact-mode-icon bact-icon-rotate"><i class="uil uil-sync"></i></div>
                        <div class="bact-mode-info">
                            <div class="bact-mode-title">Rotate Battery</div>
                            <div class="bact-mode-desc">Swap a battery between positions on the same vehicle or move it to another vehicle to equalize wear.</div>
                        </div>
                        <div class="bact-mode-radio"></div>
                    </label>

                </div>
            </div>

            {{-- ═══════════════════════════════════════════
                 WIZARD BODY — visible after mode selected
            ════════════════════════════════════════════════ --}}
            <div id="bactWizardBody" style="display:none;">

                {{-- Stepper --}}
                <div class="sc-stepper mb-4" id="bactStepper">
                    <div class="sc-step active" data-step="1"><span class="sc-step-num">1</span><span class="sc-step-label bact-sl-1">Battery Check</span></div>
                    <div class="sc-step-line"></div>
                    <div class="sc-step" data-step="2"><span class="sc-step-num">2</span><span class="sc-step-label bact-sl-2">Select Vehicle</span></div>
                    <div class="sc-step-line"></div>
                    <div class="sc-step" data-step="3"><span class="sc-step-num">3</span><span class="sc-step-label bact-sl-3">Fitting Details</span></div>
                    <div class="sc-step-line"></div>
                    <div class="sc-step" data-step="4"><span class="sc-step-num">4</span><span class="sc-step-label bact-sl-4">Confirm & Log</span></div>
                </div>

                {{-- ═══════════════════════════════════════════
                     FIT MODE STEPS
                ════════════════════════════════════════════════ --}}
                <div id="bactFitSteps">

                    {{-- FIT S1 — Battery Check --}}
                    <div class="bwiz-step" id="bactFitS1">
                        <div class="sc-card">
                            <div class="sc-card-head"><span class="sc-card-title"><i class="uil uil-bolt-alt me-2"></i>Step 1 — Battery Check</span></div>
                            <div class="p-3 p-md-4">
                                <div class="row g-3 mb-3">
                                    <div class="col-12 col-md-6">
                                        <label class="bwiz-label">Battery Serial / ID <span class="text-danger">*</span></label>
                                        <select class="form-select" id="bactFitBatSelect" style="width:100%;">
                                            <option value="">Search battery by serial...</option>
                                            <option value="BAT-2026-00081">BAT-2026-00081 — Amaron Pro Truck 150Ah</option>
                                            <option value="BAT-2025-00043">BAT-2025-00043 — Exide Drive 120Ah</option>
                                            <option value="BAT-2024-00019">BAT-2024-00019 — Amaron Pro 150Ah</option>
                                        </select>
                                        <div class="form-text text-muted">Only batteries with status: Warehouse / Reuse</div>
                                    </div>
                                </div>
                                <div class="bwiz-bat-card" id="bactFitBatCard">
                                    <div class="bwiz-bat-header">
                                        <div class="bwiz-bat-serial">BAT-2026-00081</div>
                                        <span class="btd-st-warehouse ms-auto">Warehouse</span>
                                    </div>
                                    <div class="row g-0">
                                        <div class="col-6 col-md-3"><div class="bwiz-bat-field"><span class="bwiz-bat-fl">Brand</span><span class="bwiz-bat-fv">Amaron</span></div></div>
                                        <div class="col-6 col-md-3"><div class="bwiz-bat-field"><span class="bwiz-bat-fl">Model</span><span class="bwiz-bat-fv">Pro Truck 150</span></div></div>
                                        <div class="col-6 col-md-3"><div class="bwiz-bat-field"><span class="bwiz-bat-fl">Capacity</span><span class="bwiz-bat-fv fw-semibold">150 Ah · 12V</span></div></div>
                                        <div class="col-6 col-md-3"><div class="bwiz-bat-field"><span class="bwiz-bat-fl">Condition</span><span class="bwiz-bat-fv"><span class="btd-cond-new">New</span></span></div></div>
                                        <div class="col-6 col-md-3"><div class="bwiz-bat-field"><span class="bwiz-bat-fl">Location</span><span class="bwiz-bat-fv">WH-HYD · Shelf B-12</span></div></div>
                                        <div class="col-6 col-md-3"><div class="bwiz-bat-field"><span class="bwiz-bat-fl">Purchased</span><span class="bwiz-bat-fv">15 Feb 2024</span></div></div>
                                        <div class="col-6 col-md-3"><div class="bwiz-bat-field"><span class="bwiz-bat-fl">Warranty</span><span class="bwiz-bat-fv">36 months (Feb 2027)</span></div></div>
                                        <div class="col-6 col-md-3"><div class="bwiz-bat-field"><span class="bwiz-bat-fl">Type</span><span class="bwiz-bat-fv">Lead-Acid</span></div></div>
                                    </div>
                                </div>
                                <div class="row g-3 mt-2">
                                    <div class="col-12 col-md-5">
                                        <label class="bwiz-label">Confirm Condition Before Fit <span class="text-danger">*</span></label>
                                        <select class="form-select" id="bactFitCondition">
                                            <option value="New">New</option>
                                            <option value="Used">Used</option>
                                            <option value="Weak">Weak (proceed with caution)</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label class="bwiz-label">Pre-Fit Odometer (KM)</label>
                                        <input type="number" class="form-control" id="bactFitOdo1" placeholder="e.g. 112500">
                                    </div>
                                </div>
                                <div class="bwiz-step-nav mt-4">
                                    <div></div>
                                    <button class="btn sc-btn-navy btn-sm bact-fit-next" data-step="2">Next <i class="uil uil-arrow-right ms-1"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- FIT S2 — Select Vehicle --}}
                    <div class="bwiz-step" id="bactFitS2" style="display:none;">
                        <div class="sc-card">
                            <div class="sc-card-head"><span class="sc-card-title"><i class="uil uil-truck me-2"></i>Step 2 — Select Vehicle</span></div>
                            <div class="p-3 p-md-4">
                                <div class="row g-3 mb-3">
                                    <div class="col-12 col-md-6">
                                        <label class="bwiz-label">Vehicle Registration <span class="text-danger">*</span></label>
                                        <select class="form-select" id="bactFitVehicle" style="width:100%;">
                                            <option value="">Search vehicle by reg no...</option>
                                            <option value="KA-05-AB-1234">KA-05-AB-1234 — Tata Prima</option>
                                            <option value="MH-04-CD-5678">MH-04-CD-5678 — Tata 407</option>
                                            <option value="TN-01-EF-9012">TN-01-EF-9012 — Ashok Leyland</option>
                                            <option value="AP-09-GH-3456">AP-09-GH-3456 — Eicher Pro</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label class="bwiz-label">Battery Position <span class="text-danger">*</span></label>
                                        <select class="form-select" id="bactFitPosition">
                                            <option value="Primary">Primary Battery</option>
                                            <option value="Auxiliary">Auxiliary Battery</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="bwiz-veh-card" id="bactFitVehCard" style="display:none;">
                                    <div class="bwiz-veh-header">
                                        <span class="bwiz-veh-reg">KA-05-AB-1234</span>
                                        <span class="bwiz-veh-model ms-2">Tata Prima 4928 LCV</span>
                                    </div>
                                    <div class="row g-0">
                                        <div class="col-6 col-md-3"><div class="bwiz-bat-field"><span class="bwiz-bat-fl">Fleet No.</span><span class="bwiz-bat-fv">FL-047</span></div></div>
                                        <div class="col-6 col-md-3"><div class="bwiz-bat-field"><span class="bwiz-bat-fl">Current Battery</span><span class="bwiz-bat-fv bwiz-veh-cur-bat">None</span></div></div>
                                        <div class="col-6 col-md-3"><div class="bwiz-bat-field"><span class="bwiz-bat-fl">Last Service</span><span class="bwiz-bat-fv">10 Apr 2026</span></div></div>
                                    </div>
                                </div>
                                <div class="bwiz-step-nav mt-4">
                                    <button class="btn btn-outline-secondary btn-sm bact-fit-back" data-step="1"><i class="uil uil-arrow-left me-1"></i> Back</button>
                                    <button class="btn sc-btn-navy btn-sm bact-fit-next" data-step="3">Next <i class="uil uil-arrow-right ms-1"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- FIT S3 — Fitting Details --}}
                    <div class="bwiz-step" id="bactFitS3" style="display:none;">
                        <div class="sc-card">
                            <div class="sc-card-head"><span class="sc-card-title"><i class="uil uil-wrench me-2"></i>Step 3 — Fitting Details</span></div>
                            <div class="p-3 p-md-4">
                                <div class="row g-3">
                                    <div class="col-12 col-md-4">
                                        <label class="bwiz-label">Fitting Date <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" id="bactFitDate" value="{{ date('Y-m-d') }}">
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label class="bwiz-label">Fitting Time</label>
                                        <input type="time" class="form-control" id="bactFitTime" value="{{ date('H:i') }}">
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label class="bwiz-label">Technician <span class="text-danger">*</span></label>
                                        <select class="form-select" id="bactFitTech">
                                            <option value="">Select technician...</option>
                                            <option>Rajesh Kumar</option><option>Suresh M</option><option>Arjun S</option><option>Murugan P</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="bwiz-label">Workshop / Location <span class="text-danger">*</span></label>
                                        <select class="form-select" id="bactFitWorkshop">
                                            <option value="">Select workshop...</option>
                                            <option>WS-BLR — Workshop Bangalore</option>
                                            <option>WS-HYD — Workshop Hyderabad</option>
                                            <option>WS-PNE — Workshop Pune</option>
                                            <option>Roadside / Field</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="bwiz-label">Odometer at Fitting (KM)</label>
                                        <input type="number" class="form-control" id="bactFitOdo2" placeholder="e.g. 112500">
                                    </div>
                                    <div class="col-12">
                                        <label class="bwiz-label">Notes / Remarks</label>
                                        <textarea class="form-control" rows="3" id="bactFitNotes" placeholder="Any observations during fitting..."></textarea>
                                    </div>
                                    <div class="col-12">
                                        <label class="bwiz-label">Photo / Attachment (optional)</label>
                                        <div class="bwiz-upload-zone" id="bactFitUploadZone">
                                            <i class="uil uil-image-upload bwiz-upload-icon"></i>
                                            <div>Drag &amp; drop or <span class="bwiz-upload-link">browse</span></div>
                                            <div class="text-muted" style="font-size:11px;">JPG, PNG, PDF — max 5MB</div>
                                            <input type="file" class="d-none" id="bactFitFile">
                                        </div>
                                    </div>
                                </div>
                                <div class="bwiz-step-nav mt-4">
                                    <button class="btn btn-outline-secondary btn-sm bact-fit-back" data-step="2"><i class="uil uil-arrow-left me-1"></i> Back</button>
                                    <button class="btn sc-btn-navy btn-sm bact-fit-next" data-step="4">Next <i class="uil uil-arrow-right ms-1"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- FIT S4 — Confirm & Log --}}
                    <div class="bwiz-step" id="bactFitS4" style="display:none;">
                        <div class="sc-card">
                            <div class="sc-card-head"><span class="sc-card-title"><i class="uil uil-check-circle me-2"></i>Step 4 — Confirm & Log</span></div>
                            <div class="p-3 p-md-4">
                                <div class="bwiz-confirm-summary mb-3">
                                    <h6 class="bwiz-confirm-section-title">Battery</h6>
                                    <div class="row g-2 mb-3">
                                        <div class="col-6 col-md-3"><div class="bwiz-conf-field"><span class="bwiz-conf-l">Serial</span><span class="bwiz-conf-v" id="bact-conf-serial">—</span></div></div>
                                        <div class="col-6 col-md-3"><div class="bwiz-conf-field"><span class="bwiz-conf-l">Condition</span><span class="bwiz-conf-v" id="bact-conf-cond">—</span></div></div>
                                    </div>
                                    <h6 class="bwiz-confirm-section-title">Vehicle</h6>
                                    <div class="row g-2 mb-3">
                                        <div class="col-6 col-md-3"><div class="bwiz-conf-field"><span class="bwiz-conf-l">Reg No.</span><span class="bwiz-conf-v" id="bact-conf-veh">—</span></div></div>
                                        <div class="col-6 col-md-3"><div class="bwiz-conf-field"><span class="bwiz-conf-l">Position</span><span class="bwiz-conf-v" id="bact-conf-pos">—</span></div></div>
                                    </div>
                                    <h6 class="bwiz-confirm-section-title">Fitting</h6>
                                    <div class="row g-2">
                                        <div class="col-6 col-md-3"><div class="bwiz-conf-field"><span class="bwiz-conf-l">Date</span><span class="bwiz-conf-v" id="bact-conf-date">—</span></div></div>
                                        <div class="col-6 col-md-3"><div class="bwiz-conf-field"><span class="bwiz-conf-l">Technician</span><span class="bwiz-conf-v" id="bact-conf-tech">—</span></div></div>
                                        <div class="col-6 col-md-3"><div class="bwiz-conf-field"><span class="bwiz-conf-l">Workshop</span><span class="bwiz-conf-v" id="bact-conf-ws">—</span></div></div>
                                        <div class="col-6 col-md-3"><div class="bwiz-conf-field"><span class="bwiz-conf-l">Odometer</span><span class="bwiz-conf-v" id="bact-conf-odo">—</span></div></div>
                                    </div>
                                </div>
                                <div class="bwiz-confirm-check mt-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="bactFitConfirmChk">
                                        <label class="form-check-label" for="bactFitConfirmChk">
                                            I confirm the battery has been physically fitted. This will update status to <strong>Active</strong> and log the event.
                                        </label>
                                    </div>
                                </div>
                                <div class="bwiz-step-nav mt-3">
                                    <button class="btn btn-outline-secondary btn-sm bact-fit-back" data-step="3"><i class="uil uil-arrow-left me-1"></i> Back</button>
                                    <button class="btn sc-btn-green btn-sm" id="bactFitSubmitBtn" disabled><i class="uil uil-check me-1"></i> Confirm Fitting &amp; Log</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>{{-- /bactFitSteps --}}

                {{-- ═══════════════════════════════════════════
                     REPLACE MODE STEPS
                ════════════════════════════════════════════════ --}}
                <div id="bactRepSteps" style="display:none;">

                    {{-- REP S1 — Identify Vehicle & Current Battery --}}
                    <div class="bwiz-step" id="bactRepS1">
                        <div class="sc-card">
                            <div class="sc-card-head"><span class="sc-card-title"><i class="uil uil-search-alt me-2"></i>Step 1 — Identify Vehicle &amp; Current Battery</span></div>
                            <div class="p-3 p-md-4">
                                <div class="row g-3 mb-3">
                                    <div class="col-12 col-md-6">
                                        <label class="bwiz-label">Vehicle Registration <span class="text-danger">*</span></label>
                                        <select class="form-select" id="bactRepVehicle" style="width:100%;">
                                            <option value="">Search vehicle by reg no...</option>
                                            <option value="KA-05-AB-1234">KA-05-AB-1234 — Tata Prima</option>
                                            <option value="MH-04-CD-5678">MH-04-CD-5678 — Tata 407</option>
                                            <option value="TN-01-EF-9012">TN-01-EF-9012 — Ashok Leyland</option>
                                            <option value="AP-09-GH-3456">AP-09-GH-3456 — Eicher Pro</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <label class="bwiz-label">Battery Position</label>
                                        <select class="form-select" id="bactRepPosition">
                                            <option value="Primary">Primary Battery</option>
                                            <option value="Auxiliary">Auxiliary Battery</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="bwiz-bat-card" id="bactRepCurCard" style="display:none;">
                                    <div class="bwiz-bat-header" style="background:#ea0027;">
                                        <div>
                                            <div class="bwiz-bat-serial">BAT-2022-00019 — Current Battery</div>
                                            <div style="font-size:11px;opacity:0.8;">Fitted: 08 Mar 2022 · 26 months in service</div>
                                        </div>
                                        <span class="btd-cond-dead ms-auto">Dead</span>
                                    </div>
                                    <div class="row g-0">
                                        <div class="col-6 col-md-3"><div class="bwiz-bat-field"><span class="bwiz-bat-fl">Brand</span><span class="bwiz-bat-fv">Amaron</span></div></div>
                                        <div class="col-6 col-md-3"><div class="bwiz-bat-field"><span class="bwiz-bat-fl">Model</span><span class="bwiz-bat-fv">Hi-Life 150</span></div></div>
                                        <div class="col-6 col-md-3"><div class="bwiz-bat-field"><span class="bwiz-bat-fl">Capacity</span><span class="bwiz-bat-fv">150 Ah · 12V</span></div></div>
                                        <div class="col-6 col-md-3"><div class="bwiz-bat-field"><span class="bwiz-bat-fl">Warranty</span><span class="bwiz-bat-fv text-danger">Expired (Mar 2025)</span></div></div>
                                    </div>
                                    <div class="p-3 border-top">
                                        <div class="d-flex justify-content-between mb-1">
                                            <span style="font-size:12px;color:#8898aa;">Battery Health (SOH)</span>
                                            <span style="font-size:12px;font-weight:700;color:#ea0027;">12% — Replace Immediately</span>
                                        </div>
                                        <div class="progress" style="height:7px;background:#f0f3f9;">
                                            <div class="progress-bar bg-danger" style="width:12%"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="bwiz-step-nav mt-4">
                                    <div></div>
                                    <button class="btn sc-btn-navy btn-sm bact-rep-next" data-step="2">Next <i class="uil uil-arrow-right ms-1"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- REP S2 — Removal Details --}}
                    <div class="bwiz-step" id="bactRepS2" style="display:none;">
                        <div class="sc-card">
                            <div class="sc-card-head"><span class="sc-card-title"><i class="uil uil-minus-circle me-2"></i>Step 2 — Removal Details</span></div>
                            <div class="p-3 p-md-4">
                                <div class="row g-3">
                                    <div class="col-12 col-md-6">
                                        <label class="bwiz-label">Removal Reason <span class="text-danger">*</span></label>
                                        <select class="form-select" id="bactRepReason">
                                            <option value="">Select reason...</option>
                                            <option value="Warranty Expired">Warranty Expired</option>
                                            <option value="Faulty / Dead">Faulty / Dead</option>
                                            <option value="Scheduled Replacement">Scheduled Replacement</option>
                                            <option value="Upgrade">Upgrade (Higher Capacity)</option>
                                            <option value="Breakdown">Emergency / Breakdown</option>
                                            <option value="Preventive Maintenance">Preventive Maintenance</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <label class="bwiz-label">Removal Date <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" id="bactRepDate" value="{{ date('Y-m-d') }}">
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <label class="bwiz-label">Odometer at Removal (KM)</label>
                                        <input type="number" class="form-control" id="bactRepOdo" placeholder="e.g. 124856">
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="bwiz-label">Removed By (Technician) <span class="text-danger">*</span></label>
                                        <select class="form-select" id="bactRepTech">
                                            <option value="">Select technician...</option>
                                            <option>Rajesh Kumar</option><option>Suresh M</option><option>Arjun S</option><option>Murugan P</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="bwiz-label">Workshop</label>
                                        <select class="form-select" id="bactRepWorkshop">
                                            <option value="">Select workshop...</option>
                                            <option>WS-BLR — Workshop Bangalore</option>
                                            <option>WS-HYD — Workshop Hyderabad</option>
                                            <option>WS-PNE — Workshop Pune</option>
                                            <option>Roadside / Field</option>
                                        </select>
                                    </div>

                                    {{-- Disposal cards --}}
                                    <div class="col-12">
                                        <label class="bwiz-label">What to do with the removed battery? <span class="text-danger">*</span></label>
                                        <div class="row g-2 mt-1" id="bactRepDisposalGroup">
                                            <div class="col-12 col-md-4">
                                                <label class="bwiz-disposal-card" for="bactDisposal_workshop">
                                                    <input type="radio" name="bactRepDisposal" id="bactDisposal_workshop" value="workshop" class="d-none">
                                                    <div class="bwiz-disp-icon" style="background:#e3ecff;color:#032671;"><i class="uil uil-wrench"></i></div>
                                                    <div><div class="bwiz-disp-title">Send to Workshop</div><div class="bwiz-disp-desc">Repair and reuse later</div></div>
                                                </label>
                                            </div>
                                            <div class="col-12 col-md-4">
                                                <label class="bwiz-disposal-card" for="bactDisposal_scrap">
                                                    <input type="radio" name="bactRepDisposal" id="bactDisposal_scrap" value="scrap" class="d-none">
                                                    <div class="bwiz-disp-icon" style="background:#fdecea;color:#ea0027;"><i class="uil uil-trash-alt"></i></div>
                                                    <div><div class="bwiz-disp-title">Scrap / Discard</div><div class="bwiz-disp-desc">Battery is beyond repair</div></div>
                                                </label>
                                            </div>
                                            <div class="col-12 col-md-4">
                                                <label class="bwiz-disposal-card" for="bactDisposal_stock">
                                                    <input type="radio" name="bactRepDisposal" id="bactDisposal_stock" value="stock" class="d-none">
                                                    <div class="bwiz-disp-icon" style="background:#e6f4ea;color:#10863f;"><i class="uil uil-warehouse"></i></div>
                                                    <div><div class="bwiz-disp-title">Return to Stock</div><div class="bwiz-disp-desc">Usable — back to warehouse</div></div>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label class="bwiz-label">Removal Notes</label>
                                        <textarea class="form-control" rows="2" id="bactRepNotes" placeholder="Condition when removed, any damage or observations..."></textarea>
                                    </div>
                                </div>
                                <div class="bwiz-step-nav mt-4">
                                    <button class="btn btn-outline-secondary btn-sm bact-rep-back" data-step="1"><i class="uil uil-arrow-left me-1"></i> Back</button>
                                    <button class="btn sc-btn-navy btn-sm bact-rep-next" data-step="3">Next <i class="uil uil-arrow-right ms-1"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- REP S3 — Select Replacement Battery --}}
                    <div class="bwiz-step" id="bactRepS3" style="display:none;">
                        <div class="sc-card">
                            <div class="sc-card-head d-flex align-items-center justify-content-between">
                                <span class="sc-card-title"><i class="uil uil-bolt-alt me-2"></i>Step 3 — Select Replacement Battery</span>
                                <a href="{{ route('inventory.battery.add') }}" class="btn btn-outline-secondary btn-sm" target="_blank">
                                    <i class="uil uil-plus me-1"></i>Add Battery
                                </a>
                            </div>
                            <div class="p-3 p-md-4">

                                {{-- Source Toggle --}}
                                <div class="bact-source-toggle mb-4">
                                    <div class="bact-source-hint mb-2">Where is the replacement battery coming from?</div>
                                    <div class="bact-source-grid">
                                        <label class="bact-source-card active" for="bactRepSrcInventory">
                                            <input type="radio" name="bactRepSource" id="bactRepSrcInventory" value="inventory" class="d-none" checked>
                                            <div class="bact-src-icon" style="background:#e3ecff;color:#032671;"><i class="uil uil-warehouse"></i></div>
                                            <div>
                                                <div class="bact-src-title">From Inventory</div>
                                                <div class="bact-src-desc">Select from warehouse stock</div>
                                            </div>
                                            <div class="bact-src-radio active"></div>
                                        </label>
                                        <label class="bact-source-card" for="bactRepSrcVehicle">
                                            <input type="radio" name="bactRepSource" id="bactRepSrcVehicle" value="vehicle" class="d-none">
                                            <div class="bact-src-icon" style="background:#e6f4ea;color:#10863f;"><i class="uil uil-truck"></i></div>
                                            <div>
                                                <div class="bact-src-title">From Another Vehicle</div>
                                                <div class="bact-src-desc">Transfer battery from another vehicle position</div>
                                            </div>
                                            <div class="bact-src-radio"></div>
                                        </label>
                                    </div>
                                </div>

                                {{-- Inventory Source --}}
                                <div id="bactRepSrcInventoryPanel">
                                    <div class="d-flex gap-2 flex-wrap mb-3">
                                        <select class="form-select form-select-sm" style="width:130px;">
                                            <option value="">All Capacity</option>
                                            <option value="120">120 Ah</option>
                                            <option value="150" selected>150 Ah</option>
                                            <option value="180">180 Ah</option>
                                        </select>
                                        <select class="form-select form-select-sm" style="width:110px;">
                                            <option value="">All Voltage</option>
                                            <option value="12V" selected>12V</option>
                                            <option value="24V">24V</option>
                                        </select>
                                        <select class="form-select form-select-sm" style="width:130px;">
                                            <option value="">All Types</option>
                                            <option>Lead Acid</option>
                                            <option>Lithium-ion</option>
                                            <option>AGM</option>
                                        </select>
                                        <select class="form-select form-select-sm" style="width:130px;">
                                            <option value="">All Locations</option>
                                            <option>WH-BLR</option><option>WH-HYD</option><option>WH-PNE</option>
                                        </select>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table bwiz-stock-table mb-0" id="bactRepStockTable">
                                            <thead>
                                                <tr>
                                                    <th style="width:36px;"></th>
                                                    <th>Serial No.</th>
                                                    <th>Brand</th>
                                                    <th>Model</th>
                                                    <th>Capacity</th>
                                                    <th>Voltage</th>
                                                    <th>Condition</th>
                                                    <th>Location</th>
                                                    <th>Warranty Exp.</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $stockBats = [
                                                    ['BAT-2026-00081','Amaron','Pro Truck 150','150 Ah','12V','New','WH-HYD','Feb 2027'],
                                                    ['BAT-2026-00082','Amaron','Pro Truck 150','150 Ah','12V','New','WH-BLR','Feb 2027'],
                                                    ['BAT-2025-00053','Exide','Drive 150','150 Ah','12V','Used','WH-HYD','Jun 2026'],
                                                    ['BAT-2025-00060','Luminous','Red Charge 150','150 Ah','12V','New','WH-PNE','Aug 2027'],
                                                    ['BAT-2024-00033','Exide','Drive 120','120 Ah','12V','Used','WH-BLR','Jan 2026'],
                                                ]; @endphp
                                                @foreach($stockBats as $i => $b)
                                                <tr class="bactRepStockRow" data-serial="{{ $b[0] }}" data-brand="{{ $b[1] }}" data-model="{{ $b[2] }}" data-cap="{{ $b[3] }}" data-volt="{{ $b[4] }}" data-cond="{{ $b[6] }}" data-loc="{{ $b[6] }}">
                                                    <td><input type="radio" name="bactNewBattery" class="form-check-input bactRepRadio" value="{{ $b[0] }}" id="bactNB{{ $i }}"></td>
                                                    <td><label for="bactNB{{ $i }}" class="btd-serial-link mb-0" style="cursor:pointer;">{{ $b[0] }}</label></td>
                                                    <td>{{ $b[1] }}</td><td>{{ $b[2] }}</td>
                                                    <td class="text-center fw-semibold">{{ $b[3] }}</td>
                                                    <td class="text-center">{{ $b[4] }}</td>
                                                    <td><span class="btd-cond btd-cond-{{ strtolower($b[5]) }}">{{ $b[5] }}</span></td>
                                                    <td><i class="uil uil-warehouse me-1 text-muted"></i>{{ $b[6] }}</td>
                                                    <td>{{ $b[7] }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                {{-- Another Vehicle Source --}}
                                <div id="bactRepSrcVehiclePanel" style="display:none;">
                                    <div class="row g-3 mb-3">
                                        <div class="col-12 col-md-6">
                                            <label class="bwiz-label">Source Vehicle Registration <span class="text-danger">*</span></label>
                                            <select class="form-select" id="bactRepSrcVehSelect" style="width:100%;">
                                                <option value="">Search vehicle by reg no...</option>
                                                <option value="KA-05-AB-1234">KA-05-AB-1234 — Tata Prima</option>
                                                <option value="MH-04-CD-5678">MH-04-CD-5678 — Tata 407</option>
                                                <option value="TN-01-EF-9012">TN-01-EF-9012 — Ashok Leyland</option>
                                                <option value="AP-09-GH-3456">AP-09-GH-3456 — Eicher Pro</option>
                                            </select>
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <label class="bwiz-label">Battery Position on Source Vehicle <span class="text-danger">*</span></label>
                                            <select class="form-select" id="bactRepSrcVehPos">
                                                <option value="Primary">Primary Battery</option>
                                                <option value="Auxiliary">Auxiliary Battery</option>
                                            </select>
                                        </div>
                                    </div>
                                    {{-- Battery info from source vehicle --}}
                                    <div class="bwiz-bat-card" id="bactRepSrcVehBatCard" style="display:none;">
                                        <div class="bwiz-bat-header" style="background:#10863f;">
                                            <div class="bwiz-bat-serial">BAT-2024-00055 — From Vehicle MH-04-CD-5678</div>
                                        </div>
                                        <div class="row g-0">
                                            <div class="col-6 col-md-3"><div class="bwiz-bat-field"><span class="bwiz-bat-fl">Brand</span><span class="bwiz-bat-fv">Exide</span></div></div>
                                            <div class="col-6 col-md-3"><div class="bwiz-bat-field"><span class="bwiz-bat-fl">Model</span><span class="bwiz-bat-fv">Drive 150</span></div></div>
                                            <div class="col-6 col-md-3"><div class="bwiz-bat-field"><span class="bwiz-bat-fl">Capacity</span><span class="bwiz-bat-fv">150 Ah · 12V</span></div></div>
                                            <div class="col-6 col-md-3"><div class="bwiz-bat-field"><span class="bwiz-bat-fl">Condition</span><span class="bwiz-bat-fv">Used (Good)</span></div></div>
                                        </div>
                                        <div class="bwiz-veh-alert">
                                            <i class="uil uil-info-circle me-1"></i>
                                            This battery will be removed from its current vehicle. Ensure the source vehicle has a spare or is taken out of service.
                                        </div>
                                    </div>
                                </div>

                                <div class="bwiz-step-nav mt-4">
                                    <button class="btn btn-outline-secondary btn-sm bact-rep-back" data-step="2"><i class="uil uil-arrow-left me-1"></i> Back</button>
                                    <button class="btn sc-btn-navy btn-sm bact-rep-next" data-step="4" id="bactRepNextS4" disabled>Next <i class="uil uil-arrow-right ms-1"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- REP S4 — Confirm Battery Swap --}}
                    <div class="bwiz-step" id="bactRepS4" style="display:none;">
                        <div class="sc-card">
                            <div class="sc-card-head"><span class="sc-card-title"><i class="uil uil-check-circle me-2"></i>Step 4 — Confirm Battery Swap</span></div>
                            <div class="p-3 p-md-4">
                                {{-- Side-by-side swap --}}
                                <div class="bwiz-swap-wrap mb-4">
                                    <div class="bwiz-swap-card bwiz-swap-out">
                                        <div class="bwiz-swap-header"><i class="uil uil-arrow-up me-2"></i>Battery OUT — Being Removed</div>
                                        <div class="bwiz-swap-body">
                                            <div class="bwiz-conf-field"><span class="bwiz-conf-l">Vehicle</span><span class="bwiz-conf-v" id="bact-conf-rep-veh-out">—</span></div>
                                            <div class="bwiz-conf-field"><span class="bwiz-conf-l">Position</span><span class="bwiz-conf-v" id="bact-conf-rep-pos-out">—</span></div>
                                            <div class="bwiz-conf-field"><span class="bwiz-conf-l">After Removal</span><span class="bwiz-conf-v" id="bact-conf-rep-disposal">—</span></div>
                                            <div class="bwiz-conf-field"><span class="bwiz-conf-l">Reason</span><span class="bwiz-conf-v" id="bact-conf-rep-reason">—</span></div>
                                        </div>
                                    </div>
                                    <div class="bwiz-swap-arrow"><i class="uil uil-exchange"></i></div>
                                    <div class="bwiz-swap-card bwiz-swap-in">
                                        <div class="bwiz-swap-header"><i class="uil uil-arrow-down me-2"></i>Battery IN — Being Fitted</div>
                                        <div class="bwiz-swap-body">
                                            <div class="bwiz-conf-field"><span class="bwiz-conf-l">Serial</span><span class="bwiz-conf-v" id="bact-conf-new-serial">—</span></div>
                                            <div class="bwiz-conf-field"><span class="bwiz-conf-l">Brand / Model</span><span class="bwiz-conf-v" id="bact-conf-new-model">—</span></div>
                                            <div class="bwiz-conf-field"><span class="bwiz-conf-l">Capacity · Voltage</span><span class="bwiz-conf-v" id="bact-conf-new-spec">—</span></div>
                                            <div class="bwiz-conf-field"><span class="bwiz-conf-l">Source</span><span class="bwiz-conf-v" id="bact-conf-new-src">—</span></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="bwiz-confirm-summary mb-3">
                                    <h6 class="bwiz-confirm-section-title">Technician &amp; Date</h6>
                                    <div class="row g-2">
                                        <div class="col-6 col-md-3"><div class="bwiz-conf-field"><span class="bwiz-conf-l">Date</span><span class="bwiz-conf-v" id="bact-conf-rep-date">—</span></div></div>
                                        <div class="col-6 col-md-3"><div class="bwiz-conf-field"><span class="bwiz-conf-l">Technician</span><span class="bwiz-conf-v" id="bact-conf-rep-tech">—</span></div></div>
                                        <div class="col-6 col-md-3"><div class="bwiz-conf-field"><span class="bwiz-conf-l">Workshop</span><span class="bwiz-conf-v" id="bact-conf-rep-ws">—</span></div></div>
                                    </div>
                                </div>
                                <div class="bwiz-confirm-check mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="bactRepConfirmChk">
                                        <label class="form-check-label" for="bactRepConfirmChk">
                                            I confirm the old battery has been physically removed and the new battery has been fitted. Both events will be logged in movement history.
                                        </label>
                                    </div>
                                </div>
                                <div class="bwiz-step-nav">
                                    <button class="btn btn-outline-secondary btn-sm bact-rep-back" data-step="3"><i class="uil uil-arrow-left me-1"></i> Back</button>
                                    <button class="btn sc-btn-green btn-sm" id="bactRepSubmitBtn" disabled><i class="uil uil-exchange me-1"></i> Confirm Battery Swap</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>{{-- /bactRepSteps --}}

                {{-- ═══════════════════════════════════════════
                     ROTATE MODE STEPS
                ════════════════════════════════════════════════ --}}
                <div id="bactRotSteps" style="display:none;">

                    {{-- ROT S1 — Source Battery --}}
                    <div class="bwiz-step" id="bactRotS1">
                        <div class="sc-card">
                            <div class="sc-card-head"><span class="sc-card-title"><i class="uil uil-truck me-2"></i>Step 1 — Source Vehicle &amp; Battery</span></div>
                            <div class="p-3 p-md-4">
                                <p class="text-muted" style="font-size:12px;margin-bottom:16px;">
                                    Select the vehicle and position from which the battery will be moved.
                                </p>
                                <div class="row g-3 mb-3">
                                    <div class="col-12 col-md-6">
                                        <label class="bwiz-label">Source Vehicle Registration <span class="text-danger">*</span></label>
                                        <select class="form-select" id="bactRotSrcVeh" style="width:100%;">
                                            <option value="">Search vehicle by reg no...</option>
                                            <option value="KA-05-AB-1234">KA-05-AB-1234 — Tata Prima</option>
                                            <option value="MH-04-CD-5678">MH-04-CD-5678 — Tata 407</option>
                                            <option value="TN-01-EF-9012">TN-01-EF-9012 — Ashok Leyland</option>
                                            <option value="AP-09-GH-3456">AP-09-GH-3456 — Eicher Pro</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label class="bwiz-label">Battery Position <span class="text-danger">*</span></label>
                                        <select class="form-select" id="bactRotSrcPos">
                                            <option value="Primary">Primary Battery</option>
                                            <option value="Auxiliary">Auxiliary Battery</option>
                                        </select>
                                    </div>
                                </div>
                                {{-- Source battery card --}}
                                <div class="bwiz-bat-card" id="bactRotSrcCard" style="display:none;">
                                    <div class="bwiz-bat-header">
                                        <div class="bwiz-bat-serial">BAT-2023-00047</div>
                                        <span class="btd-st-active ms-auto">Active</span>
                                    </div>
                                    <div class="row g-0">
                                        <div class="col-6 col-md-3"><div class="bwiz-bat-field"><span class="bwiz-bat-fl">Brand</span><span class="bwiz-bat-fv">Exide</span></div></div>
                                        <div class="col-6 col-md-3"><div class="bwiz-bat-field"><span class="bwiz-bat-fl">Model</span><span class="bwiz-bat-fv">Drive 150</span></div></div>
                                        <div class="col-6 col-md-3"><div class="bwiz-bat-field"><span class="bwiz-bat-fl">Capacity</span><span class="bwiz-bat-fv">150 Ah · 12V</span></div></div>
                                        <div class="col-6 col-md-3"><div class="bwiz-bat-field"><span class="bwiz-bat-fl">Months in Service</span><span class="bwiz-bat-fv">18 months</span></div></div>
                                        <div class="col-6 col-md-3"><div class="bwiz-bat-field"><span class="bwiz-bat-fl">KM Run</span><span class="bwiz-bat-fv">48,220 KM</span></div></div>
                                        <div class="col-6 col-md-3"><div class="bwiz-bat-field"><span class="bwiz-bat-fl">KM Balance</span><span class="bwiz-bat-fv" style="color:#10863f;font-weight:600;">51,780 KM</span></div></div>
                                    </div>
                                </div>
                                <div class="bwiz-step-nav mt-4">
                                    <div></div>
                                    <button class="btn sc-btn-navy btn-sm bact-rot-next" data-step="2">Next <i class="uil uil-arrow-right ms-1"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ROT S2 — Destination --}}
                    <div class="bwiz-step" id="bactRotS2" style="display:none;">
                        <div class="sc-card">
                            <div class="sc-card-head"><span class="sc-card-title"><i class="uil uil-map-marker me-2"></i>Step 2 — Select Destination</span></div>
                            <div class="p-3 p-md-4">

                                {{-- Same vs different vehicle toggle --}}
                                <div class="bact-source-toggle mb-4">
                                    <div class="bact-source-hint mb-2">Where is this battery going?</div>
                                    <div class="bact-source-grid">
                                        <label class="bact-source-card active" for="bactRotDestSame">
                                            <input type="radio" name="bactRotDest" id="bactRotDestSame" value="same" class="d-none" checked>
                                            <div class="bact-src-icon" style="background:#e3ecff;color:#032671;"><i class="uil uil-refresh"></i></div>
                                            <div>
                                                <div class="bact-src-title">Same Vehicle — Different Position</div>
                                                <div class="bact-src-desc">Move between Primary and Auxiliary on the same vehicle</div>
                                            </div>
                                            <div class="bact-src-radio active"></div>
                                        </label>
                                        <label class="bact-source-card" for="bactRotDestOther">
                                            <input type="radio" name="bactRotDest" id="bactRotDestOther" value="other" class="d-none">
                                            <div class="bact-src-icon" style="background:#e6f4ea;color:#10863f;"><i class="uil uil-truck"></i></div>
                                            <div>
                                                <div class="bact-src-title">Different Vehicle</div>
                                                <div class="bact-src-desc">Transfer to another fleet vehicle to equalize wear</div>
                                            </div>
                                            <div class="bact-src-radio"></div>
                                        </label>
                                    </div>
                                </div>

                                {{-- Same vehicle, different position --}}
                                <div id="bactRotDestSamePanel">
                                    <div class="row g-3">
                                        <div class="col-12 col-md-5">
                                            <label class="bwiz-label">Target Position <span class="text-danger">*</span></label>
                                            <select class="form-select" id="bactRotTargetPos">
                                                <option value="Primary">Primary Battery</option>
                                                <option value="Auxiliary">Auxiliary Battery</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="bwiz-veh-alert mt-3">
                                        <i class="uil uil-info-circle me-1"></i>
                                        The battery will be moved to the target position on the same vehicle. Any battery currently at the target position will be moved to stock.
                                    </div>
                                </div>

                                {{-- Different vehicle --}}
                                <div id="bactRotDestOtherPanel" style="display:none;">
                                    <div class="row g-3">
                                        <div class="col-12 col-md-6">
                                            <label class="bwiz-label">Target Vehicle Registration <span class="text-danger">*</span></label>
                                            <select class="form-select" id="bactRotTargetVeh" style="width:100%;">
                                                <option value="">Search vehicle by reg no...</option>
                                                <option value="KA-05-AB-1234">KA-05-AB-1234 — Tata Prima</option>
                                                <option value="MH-04-CD-5678">MH-04-CD-5678 — Tata 407</option>
                                                <option value="TN-01-EF-9012">TN-01-EF-9012 — Ashok Leyland</option>
                                                <option value="AP-09-GH-3456">AP-09-GH-3456 — Eicher Pro</option>
                                            </select>
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <label class="bwiz-label">Target Position <span class="text-danger">*</span></label>
                                            <select class="form-select" id="bactRotTargetOtherPos">
                                                <option value="Primary">Primary Battery</option>
                                                <option value="Auxiliary">Auxiliary Battery</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="bwiz-step-nav mt-4">
                                    <button class="btn btn-outline-secondary btn-sm bact-rot-back" data-step="1"><i class="uil uil-arrow-left me-1"></i> Back</button>
                                    <button class="btn sc-btn-navy btn-sm bact-rot-next" data-step="3">Next <i class="uil uil-arrow-right ms-1"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ROT S3 — Rotation Details --}}
                    <div class="bwiz-step" id="bactRotS3" style="display:none;">
                        <div class="sc-card">
                            <div class="sc-card-head"><span class="sc-card-title"><i class="uil uil-wrench me-2"></i>Step 3 — Rotation Details</span></div>
                            <div class="p-3 p-md-4">
                                <div class="row g-3">
                                    <div class="col-12 col-md-4">
                                        <label class="bwiz-label">Rotation Date <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" id="bactRotDate" value="{{ date('Y-m-d') }}">
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label class="bwiz-label">Technician <span class="text-danger">*</span></label>
                                        <select class="form-select" id="bactRotTech">
                                            <option value="">Select technician...</option>
                                            <option>Rajesh Kumar</option><option>Suresh M</option><option>Arjun S</option><option>Murugan P</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label class="bwiz-label">Workshop</label>
                                        <select class="form-select" id="bactRotWorkshop">
                                            <option value="">Select workshop...</option>
                                            <option>WS-BLR — Workshop Bangalore</option>
                                            <option>WS-HYD — Workshop Hyderabad</option>
                                            <option>WS-PNE — Workshop Pune</option>
                                            <option>Roadside / Field</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-5">
                                        <label class="bwiz-label">Reason for Rotation</label>
                                        <select class="form-select" id="bactRotReason">
                                            <option value="">Select reason...</option>
                                            <option value="Wear Equalization">Wear Equalization</option>
                                            <option value="Vehicle Redeployment">Vehicle Redeployment</option>
                                            <option value="Performance Issue">Performance Issue on Current Vehicle</option>
                                            <option value="Preventive Maintenance">Preventive Maintenance Schedule</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label class="bwiz-label">Odometer at Rotation (KM)</label>
                                        <input type="number" class="form-control" id="bactRotOdo" placeholder="e.g. 95600">
                                    </div>
                                    <div class="col-12">
                                        <label class="bwiz-label">Notes</label>
                                        <textarea class="form-control" rows="2" id="bactRotNotes" placeholder="Any observations or remarks about this rotation..."></textarea>
                                    </div>
                                </div>
                                <div class="bwiz-step-nav mt-4">
                                    <button class="btn btn-outline-secondary btn-sm bact-rot-back" data-step="2"><i class="uil uil-arrow-left me-1"></i> Back</button>
                                    <button class="btn sc-btn-navy btn-sm bact-rot-next" data-step="4">Next <i class="uil uil-arrow-right ms-1"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ROT S4 — Confirm Rotation --}}
                    <div class="bwiz-step" id="bactRotS4" style="display:none;">
                        <div class="sc-card">
                            <div class="sc-card-head"><span class="sc-card-title"><i class="uil uil-check-circle me-2"></i>Step 4 — Confirm Battery Rotation</span></div>
                            <div class="p-3 p-md-4">
                                <div class="bwiz-swap-wrap mb-4">
                                    <div class="bwiz-swap-card bwiz-swap-out">
                                        <div class="bwiz-swap-header"><i class="uil uil-location-arrow me-2"></i>FROM</div>
                                        <div class="bwiz-swap-body">
                                            <div class="bwiz-conf-field"><span class="bwiz-conf-l">Vehicle</span><span class="bwiz-conf-v" id="bact-rot-from-veh">—</span></div>
                                            <div class="bwiz-conf-field"><span class="bwiz-conf-l">Position</span><span class="bwiz-conf-v" id="bact-rot-from-pos">—</span></div>
                                            <div class="bwiz-conf-field"><span class="bwiz-conf-l">Battery Serial</span><span class="bwiz-conf-v" id="bact-rot-battery">—</span></div>
                                        </div>
                                    </div>
                                    <div class="bwiz-swap-arrow"><i class="uil uil-arrow-right"></i></div>
                                    <div class="bwiz-swap-card bwiz-swap-in">
                                        <div class="bwiz-swap-header"><i class="uil uil-map-marker me-2"></i>TO</div>
                                        <div class="bwiz-swap-body">
                                            <div class="bwiz-conf-field"><span class="bwiz-conf-l">Vehicle</span><span class="bwiz-conf-v" id="bact-rot-to-veh">—</span></div>
                                            <div class="bwiz-conf-field"><span class="bwiz-conf-l">Position</span><span class="bwiz-conf-v" id="bact-rot-to-pos">—</span></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="bwiz-confirm-summary mb-3">
                                    <h6 class="bwiz-confirm-section-title">Details</h6>
                                    <div class="row g-2">
                                        <div class="col-6 col-md-3"><div class="bwiz-conf-field"><span class="bwiz-conf-l">Date</span><span class="bwiz-conf-v" id="bact-rot-date">—</span></div></div>
                                        <div class="col-6 col-md-3"><div class="bwiz-conf-field"><span class="bwiz-conf-l">Technician</span><span class="bwiz-conf-v" id="bact-rot-tech">—</span></div></div>
                                        <div class="col-6 col-md-3"><div class="bwiz-conf-field"><span class="bwiz-conf-l">Reason</span><span class="bwiz-conf-v" id="bact-rot-reason">—</span></div></div>
                                        <div class="col-6 col-md-3"><div class="bwiz-conf-field"><span class="bwiz-conf-l">Odometer</span><span class="bwiz-conf-v" id="bact-rot-odo">—</span></div></div>
                                    </div>
                                </div>
                                <div class="bwiz-confirm-check mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="bactRotConfirmChk">
                                        <label class="form-check-label" for="bactRotConfirmChk">
                                            I confirm the battery has been physically moved to the new position. This rotation will be logged in the battery movement history.
                                        </label>
                                    </div>
                                </div>
                                <div class="bwiz-step-nav">
                                    <button class="btn btn-outline-secondary btn-sm bact-rot-back" data-step="3"><i class="uil uil-arrow-left me-1"></i> Back</button>
                                    <button class="btn sc-btn-green btn-sm" id="bactRotSubmitBtn" disabled><i class="uil uil-sync me-1"></i> Confirm Rotation &amp; Log</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>{{-- /bactRotSteps --}}

            </div>{{-- /bactWizardBody --}}

        </div>
    </div>
</div>
@endsection

@section('js')
<script>
$(document).ready(function () {

    /* ─────────────────────────────────────────────────
       MODE CONFIG
    ──────────────────────────────────────────────────*/
    var modeConfig = {
        fit: {
            title: '<i class="uil uil-car-sideview me-2" style="color:#10863f;"></i>Fit Battery to Vehicle',
            subtitle: 'Install a battery from stock onto a fleet vehicle',
            breadcrumb: 'Fit Battery to Vehicle',
            steps: ['Battery Check','Select Vehicle','Fitting Details','Confirm & Log']
        },
        replace: {
            title: '<i class="uil uil-exchange me-2" style="color:#ea0027;"></i>Battery Replacement',
            subtitle: 'Remove the current battery and fit a replacement',
            breadcrumb: 'Battery Replacement',
            steps: ['Identify Vehicle','Removal Details','Select Replacement','Confirm Swap']
        },
        rotate: {
            title: '<i class="uil uil-sync me-2" style="color:#7b2ff7;"></i>Battery Rotation',
            subtitle: 'Move a battery between positions or vehicles to equalize wear',
            breadcrumb: 'Battery Rotation',
            steps: ['Source Battery','Destination','Rotation Details','Confirm Rotation']
        }
    };

    /* ─────────────────────────────────────────────────
       MODE SELECTION
    ──────────────────────────────────────────────────*/
    $('.bact-mode-card').on('click', function () {
        $('.bact-mode-card').removeClass('active');
        $(this).addClass('active');
        var mode = $(this).find('input[type="radio"]').val();
        $(this).find('input[type="radio"]').prop('checked', true);
        activateMode(mode);
    });

    function activateMode(mode) {
        var cfg = modeConfig[mode];
        $('#bact-page-title').html(cfg.title);
        $('#bact-page-subtitle').text(cfg.subtitle);
        $('#bact-breadcrumb').text(cfg.breadcrumb);
        $.each(cfg.steps, function(i, lbl) { $('.bact-sl-' + (i+1)).text(lbl); });
        updateStepper(1);
        $('#bactFitSteps, #bactRepSteps, #bactRotSteps').hide();
        if (mode === 'fit') {
            $('#bactFitSteps').show();
            $('#bactFitSteps .bwiz-step').hide(); $('#bactFitS1').show();
        } else if (mode === 'replace') {
            $('#bactRepSteps').show();
            $('#bactRepSteps .bwiz-step').hide(); $('#bactRepS1').show();
        } else {
            $('#bactRotSteps').show();
            $('#bactRotSteps .bwiz-step').hide(); $('#bactRotS1').show();
        }
        $('#bactWizardBody').slideDown(220);
        $('html,body').animate({ scrollTop: $('#bactWizardBody').offset().top - 80 }, 300);
    }

    /* ─────────────────────────────────────────────────
       STEPPER
    ──────────────────────────────────────────────────*/
    function updateStepper(n) {
        $('#bactStepper .sc-step').each(function() {
            var s = parseInt($(this).data('step'));
            $(this).removeClass('active done');
            if (s < n) $(this).addClass('done');
            if (s === n) $(this).addClass('active');
        });
        $('#bactStepper .sc-step-line').each(function(i) {
            $(this).toggleClass('done', i < n - 1);
        });
    }

    /* ─────────────────────────────────────────────────
       FIT NAVIGATION
    ──────────────────────────────────────────────────*/
    $('.bact-fit-next').on('click', function() {
        var n = parseInt($(this).data('step'));
        $('#bactFitSteps .bwiz-step').hide(); $('#bactFitS' + n).show();
        updateStepper(n);
        if (n === 4) bactFitPopulateConfirm();
    });
    $('.bact-fit-back').on('click', function() {
        var n = parseInt($(this).data('step'));
        $('#bactFitSteps .bwiz-step').hide(); $('#bactFitS' + n).show();
        updateStepper(n);
    });
    $('#bactFitVehicle').on('change', function() { $('#bactFitVehCard').toggle(!!$(this).val()); });
    $('#bactFitUploadZone').on('click', function() { $('#bactFitFile').click(); });
    $('#bactFitConfirmChk').on('change', function() { $('#bactFitSubmitBtn').prop('disabled', !$(this).is(':checked')); });
    function bactFitPopulateConfirm() {
        $('#bact-conf-serial').text($('#bactFitBatSelect').val() || '—');
        $('#bact-conf-cond').text($('#bactFitCondition').val() || '—');
        $('#bact-conf-veh').text($('#bactFitVehicle').val() || '—');
        $('#bact-conf-pos').text($('#bactFitPosition').val() || '—');
        $('#bact-conf-date').text($('#bactFitDate').val() || '—');
        $('#bact-conf-tech').text($('#bactFitTech').val() || '—');
        $('#bact-conf-ws').text($('#bactFitWorkshop').val() || '—');
        var odo = $('#bactFitOdo2').val() || $('#bactFitOdo1').val();
        $('#bact-conf-odo').text(odo ? odo + ' KM' : '—');
    }
    $('#bactFitSubmitBtn').on('click', function() {
        var $b = $(this).prop('disabled', true).html('<i class="uil uil-spinner-alt spin me-1"></i>Logging...');
        setTimeout(function() {
            $b.html('<i class="uil uil-check me-1"></i>Logged!');
            toastr.success('Battery fitting logged successfully.');
            setTimeout(function() { window.location.href = '{{ route("inventory.battery-dashboard") }}'; }, 1200);
        }, 900);
    });

    /* ─────────────────────────────────────────────────
       REPLACE NAVIGATION
    ──────────────────────────────────────────────────*/
    $('.bact-rep-next').on('click', function() {
        var n = parseInt($(this).data('step'));
        $('#bactRepSteps .bwiz-step').hide(); $('#bactRepS' + n).show();
        updateStepper(n);
        if (n === 4) bactRepPopulateConfirm();
    });
    $('.bact-rep-back').on('click', function() {
        var n = parseInt($(this).data('step'));
        $('#bactRepSteps .bwiz-step').hide(); $('#bactRepS' + n).show();
        updateStepper(n);
    });

    // Current battery card
    $('#bactRepVehicle').on('change', function() { $('#bactRepCurCard').toggle(!!$(this).val()); });

    // Disposal cards
    $('#bactRepDisposalGroup').on('click', '.bwiz-disposal-card', function() {
        $('#bactRepDisposalGroup .bwiz-disposal-card').removeClass('active');
        $(this).addClass('active');
        $(this).find('input[type="radio"]').prop('checked', true);
    });

    // Source toggle (Inventory vs Another Vehicle)
    $('input[name="bactRepSource"]').on('change', function() {
        $('.bact-source-card').removeClass('active');
        $(this).closest('.bact-source-card').addClass('active');
        $('.bact-src-radio').removeClass('active');
        $(this).closest('.bact-source-card').find('.bact-src-radio').addClass('active');
        if ($(this).val() === 'inventory') {
            $('#bactRepSrcInventoryPanel').show();
            $('#bactRepSrcVehiclePanel').hide();
            $('#bactRepNextS4').prop('disabled', $('.bactRepStockRow.selected').length === 0);
        } else {
            $('#bactRepSrcInventoryPanel').hide();
            $('#bactRepSrcVehiclePanel').show();
            $('#bactRepNextS4').prop('disabled', !$('#bactRepSrcVehSelect').val());
        }
    });

    // Source vehicle selection
    $('#bactRepSrcVehSelect').on('change', function() {
        if ($(this).val()) {
            $('#bactRepSrcVehBatCard').show();
            if ($('input[name="bactRepSource"]:checked').val() === 'vehicle') {
                $('#bactRepNextS4').prop('disabled', false);
            }
        } else {
            $('#bactRepSrcVehBatCard').hide();
            $('#bactRepNextS4').prop('disabled', true);
        }
    });

    // Stock row selection
    $('#bactRepStockTable').on('click', '.bactRepStockRow', function() {
        $('.bactRepStockRow').removeClass('selected');
        $(this).addClass('selected').find('.bactRepRadio').prop('checked', true);
        $('#bactRepNextS4').prop('disabled', false);
    });

    // Confirm checkbox
    $('#bactRepConfirmChk').on('change', function() { $('#bactRepSubmitBtn').prop('disabled', !$(this).is(':checked')); });

    function bactRepPopulateConfirm() {
        var src = $('input[name="bactRepSource"]:checked').val() || 'inventory';
        // OUT battery
        $('#bact-conf-rep-veh-out').text($('#bactRepVehicle').val() || '—');
        $('#bact-conf-rep-pos-out').text($('#bactRepPosition').val() || '—');
        var dispMap = { workshop:'Send to Workshop', scrap:'Scrap / Discard', stock:'Return to Stock' };
        $('#bact-conf-rep-disposal').text(dispMap[$('input[name="bactRepDisposal"]:checked').val()] || '—');
        $('#bact-conf-rep-reason').text($('#bactRepReason').val() || '—');
        // IN battery
        if (src === 'inventory') {
            var $row = $('.bactRepStockRow.selected');
            if ($row.length) {
                $('#bact-conf-new-serial').text($row.data('serial') || '—');
                $('#bact-conf-new-model').text(($row.data('brand') || '') + ' ' + ($row.data('model') || ''));
                $('#bact-conf-new-spec').text(($row.data('cap') || '') + ' · ' + ($row.data('volt') || ''));
            }
            $('#bact-conf-new-src').text('Warehouse Inventory');
        } else {
            $('#bact-conf-new-serial').text('BAT-2024-00055');
            $('#bact-conf-new-model').text('Exide Drive 150');
            $('#bact-conf-new-spec').text('150 Ah · 12V');
            $('#bact-conf-new-src').text('From Vehicle: ' + ($('#bactRepSrcVehSelect').val() || '—'));
        }
        // Dates
        $('#bact-conf-rep-date').text($('#bactRepDate').val() || '—');
        $('#bact-conf-rep-tech').text($('#bactRepTech').val() || '—');
        $('#bact-conf-rep-ws').text($('#bactRepWorkshop').val() || '—');
    }

    $('#bactRepSubmitBtn').on('click', function() {
        var $b = $(this).prop('disabled', true).html('<i class="uil uil-spinner-alt spin me-1"></i>Processing...');
        setTimeout(function() {
            $b.html('<i class="uil uil-exchange me-1"></i>Swap Logged!');
            toastr.success('Battery replacement logged successfully.');
            setTimeout(function() { window.location.href = '{{ route("inventory.battery-dashboard") }}'; }, 1200);
        }, 900);
    });

    /* ─────────────────────────────────────────────────
       ROTATE NAVIGATION
    ──────────────────────────────────────────────────*/
    $('.bact-rot-next').on('click', function() {
        var n = parseInt($(this).data('step'));
        $('#bactRotSteps .bwiz-step').hide(); $('#bactRotS' + n).show();
        updateStepper(n);
        if (n === 4) bactRotPopulateConfirm();
    });
    $('.bact-rot-back').on('click', function() {
        var n = parseInt($(this).data('step'));
        $('#bactRotSteps .bwiz-step').hide(); $('#bactRotS' + n).show();
        updateStepper(n);
    });

    $('#bactRotSrcVeh').on('change', function() { $('#bactRotSrcCard').toggle(!!$(this).val()); });

    // Destination toggle
    $('input[name="bactRotDest"]').on('change', function() {
        $('.bact-source-card').removeClass('active');
        $(this).closest('.bact-source-card').addClass('active');
        $('.bact-src-radio').removeClass('active');
        $(this).closest('.bact-source-card').find('.bact-src-radio').addClass('active');
        if ($(this).val() === 'same') {
            $('#bactRotDestSamePanel').show();
            $('#bactRotDestOtherPanel').hide();
        } else {
            $('#bactRotDestSamePanel').hide();
            $('#bactRotDestOtherPanel').show();
        }
    });

    $('#bactRotConfirmChk').on('change', function() { $('#bactRotSubmitBtn').prop('disabled', !$(this).is(':checked')); });

    function bactRotPopulateConfirm() {
        $('#bact-rot-from-veh').text($('#bactRotSrcVeh').val() || '—');
        $('#bact-rot-from-pos').text($('#bactRotSrcPos').val() || '—');
        $('#bact-rot-battery').text('BAT-2023-00047');
        var destType = $('input[name="bactRotDest"]:checked').val() || 'same';
        if (destType === 'same') {
            $('#bact-rot-to-veh').text($('#bactRotSrcVeh').val() + ' (same)');
            $('#bact-rot-to-pos').text($('#bactRotTargetPos').val() || '—');
        } else {
            $('#bact-rot-to-veh').text($('#bactRotTargetVeh').val() || '—');
            $('#bact-rot-to-pos').text($('#bactRotTargetOtherPos').val() || '—');
        }
        $('#bact-rot-date').text($('#bactRotDate').val() || '—');
        $('#bact-rot-tech').text($('#bactRotTech').val() || '—');
        $('#bact-rot-reason').text($('#bactRotReason').val() || '—');
        var odo = $('#bactRotOdo').val();
        $('#bact-rot-odo').text(odo ? odo + ' KM' : '—');
    }

    $('#bactRotSubmitBtn').on('click', function() {
        var $b = $(this).prop('disabled', true).html('<i class="uil uil-spinner-alt spin me-1"></i>Processing...');
        setTimeout(function() {
            $b.html('<i class="uil uil-check me-1"></i>Rotation Logged!');
            toastr.success('Battery rotation logged successfully.');
            setTimeout(function() { window.location.href = '{{ route("inventory.battery-dashboard") }}'; }, 1200);
        }, 900);
    });

    /* ─────────────────────────────────────────────────
       SELECT2 INITS
    ──────────────────────────────────────────────────*/
    $('#bactFitBatSelect, #bactFitVehicle, #bactRepVehicle, #bactRepSrcVehSelect, #bactRotSrcVeh, #bactRotTargetVeh').select2({ width: '100%' });

});
</script>
@endsection
