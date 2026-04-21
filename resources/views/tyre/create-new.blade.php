@extends('layouts.app')

@section('css')
{{-- Reuse Battery-Add design system for identical patterns --}}
<link href="{{ asset('css/Inventory/battery-add.css?v=1.1') }}" rel="stylesheet">
{{-- Tyre-specific additions (reminder toggles, maintenance grid, tube-type picker) --}}
<link href="{{ asset('css/Tyre/create-new.css?v=1.0') }}" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css" rel="stylesheet">
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
                    <li class="breadcrumb-item"><a href="{{ route('tyre.dashboard') }}">Tyre Dashboard</a></li>
                    <li class="breadcrumb-item active">Add Tyre</li>
                </ol>
            </nav>

            {{-- Page Header --}}
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div class="d-flex align-items-center gap-3">
                    <a href="{{ route('tyre.dashboard') }}" class="bdet-back-btn" aria-label="Back">
                        <i class="uil uil-arrow-left"></i>
                    </a>
                    <div>
                        <h5 class="mb-0"><i class="uil uil-plus-circle me-2" style="color:#032671;"></i>Add Tyre to Inventory</h5>
                        <span class="text-muted" style="font-size:12px;">Register a new, used, or retreaded tyre — capture identity, lifecycle &amp; maintenance data</span>
                    </div>
                </div>
            </div>

            <form id="tcnAddForm"
                  action="{{ route('tyre.saveNew') }}"
                  method="POST"
                  enctype="multipart/form-data"
                  data-dashboard-url="{{ route('tyre.dashboard') }}"
                  novalidate>
                @csrf

                {{-- ── Source Toggle ── --}}
                <div class="badd-source-toggle-wrap mb-4">
                    <div class="badd-source-toggle" id="tcnSourceToggle">
                        <label class="badd-source-option active" for="tcnSrcExisting">
                            <input type="radio" name="tyre_source_mode" id="tcnSrcExisting" value="Existing" class="d-none" checked>
                            <div class="d-flex align-items-center gap-3">
                                <div class="badd-src-icon badd-src-icon-existing">
                                    <i class="uil uil-box"></i>
                                </div>
                                <div>
                                    <div class="badd-source-label">Existing Tyre</div>
                                    <div class="badd-source-desc">Transferred, retreaded, or purchased outside system</div>
                                </div>
                                <span class="badd-source-radio ms-auto flex-shrink-0"></span>
                            </div>
                        </label>
                        <label class="badd-source-option" for="tcnSrcNewPO">
                            <input type="radio" name="tyre_source_mode" id="tcnSrcNewPO" value="New PO" class="d-none">
                            <div class="d-flex align-items-center gap-3">
                                <div class="badd-src-icon badd-src-icon-new">
                                    <i class="uil uil-receipt-alt"></i>
                                </div>
                                <div>
                                    <div class="badd-source-label">New Tyre (from PO / GRN)</div>
                                    <div class="badd-source-desc">Received via system PO or GRN — reference the document</div>
                                </div>
                                <span class="badd-source-radio ms-auto flex-shrink-0"></span>
                            </div>
                        </label>
                    </div>

                    {{-- Mode: Existing Tyre —— note + bill only --}}
                    <div class="badd-mode-section active" id="tcnModeExisting">
                        <div class="sc-card mb-0">
                            <div class="sc-card-head">
                                <span class="sc-card-title"><i class="uil uil-notes me-2"></i>Source Information</span>
                            </div>
                            <div class="p-3">
                                <div class="row g-3">
                                    <div class="col-12 col-md-8">
                                        <label class="badd-label" for="tcnSourceNote">Source / Origin Note <span class="text-danger">*</span></label>
                                        <textarea class="form-control badd-input" name="source_origin_note" id="tcnSourceNote" rows="2"
                                                  placeholder="e.g. Received from MRF dealer outside system, repurposed from retired vehicle, transferred from another depot..."></textarea>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label class="badd-label">Invoice / Bill (optional)</label>
                                        <div class="badd-file-zone" id="tcnFileZone">
                                            <input type="file" name="invoice_file" id="tcnInvoiceFile" class="d-none" accept=".pdf,.jpg,.jpeg,.png">
                                            <i class="uil uil-file-upload-alt badd-file-icon"></i>
                                            <span class="badd-file-text">Click to attach or drop file</span>
                                            <span class="badd-file-hint">PDF, JPG, PNG · max 10MB</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Mode: New Tyre from PO/GRN --}}
                    <div class="badd-mode-section" id="tcnModeNewPO">
                        <div class="sc-card mb-0">
                            <div class="sc-card-head">
                                <span class="sc-card-title"><i class="uil uil-receipt-alt me-2"></i>Select PO / GRN</span>
                            </div>
                            <div class="p-3">
                                <div class="row g-3">
                                    <div class="col-12 col-md-7">
                                        <label class="badd-label" for="tcnPoGrnSelect">PO / GRN Reference <span class="text-danger">*</span></label>
                                        <select class="form-select select2-po-grn badd-input" name="purchase_order_reference" id="tcnPoGrnSelect" style="width:100%;">
                                            <option value="">Search PO or GRN number...</option>
                                            <option value="PO-2026-00041">PO-2026-00041 — MRF (50 units · 12 available)</option>
                                            <option value="GRN-2026-01003">GRN-2026-01003 — Apollo (25 received · 25 available)</option>
                                            <option value="PO-2026-00038">PO-2026-00038 — JK Tyre (100 units · 78 available)</option>
                                            <option value="GRN-2026-01001">GRN-2026-01001 — CEAT (15 received · 15 available)</option>
                                        </select>
                                        {{-- TODO: AJAX → on select, populate Brand/Model/Serial fields below --}}
                                    </div>
                                    <div class="col-12 col-md-5 d-flex align-items-end">
                                        <div class="badd-grn-hint">
                                            <i class="uil uil-info-circle me-1"></i>
                                            Selecting a PO/GRN will auto-fill brand, model, and serial number below once connected to backend.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>{{-- end source toggle wrap --}}

                <div class="row g-4">

                    {{-- ── LEFT COLUMN ── --}}
                    <div class="col-12 col-xl-8">

                        {{-- Tyre Identity --}}
                        <div class="sc-card mb-3">
                            <div class="sc-card-head">
                                <span class="sc-card-title"><i class="uil uil-tag-alt me-2"></i>Tyre Identity</span>
                            </div>
                            <div class="p-3 p-md-4">
                                <div class="row g-3">
                                    <div class="col-12 col-md-6">
                                        <label class="badd-label" for="tcnSerial">Tyre Serial Number <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control badd-input" name="tyre_serial_number" id="tcnSerial" placeholder="e.g. TYR-2026-00095" maxlength="100">
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="badd-label" for="tcnVendor">Vendor <span class="text-danger">*</span></label>
                                        <select class="form-select tcn-select2 badd-input" name="vendor" id="tcnVendor" style="width:100%;">
                                            <option value="">Select vendor...</option>
                                            @foreach($tyrevendors as $v)
                                                <option value="{{ $v->id }}">{{ $v->contact_name }} ({{ $v->company_name }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label class="badd-label" for="tcnBrand">Tyre Brand <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control badd-input" name="tyre_brand" id="tcnBrand" placeholder="e.g. MRF, Apollo, JK" maxlength="100">
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label class="badd-label" for="tcnModel">Tyre Model <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control badd-input" name="tyre_model_name" id="tcnModel" placeholder="e.g. Steel Muscle" maxlength="100">
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label class="badd-label" for="tcnSize">Tyre Size <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control badd-input" name="tyre_size" id="tcnSize" placeholder="e.g. 295/90 R20" maxlength="50">
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="badd-label">Tyre Type <span class="text-danger">*</span></label>
                                        <div class="tcn-radio-row">
                                            <label class="tcn-radio-chip">
                                                <input type="radio" name="tyre_type" value="Radial" checked>
                                                <span>Radial</span>
                                            </label>
                                            <label class="tcn-radio-chip">
                                                <input type="radio" name="tyre_type" value="Nylon">
                                                <span>Nylon</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="badd-label" for="tcnCategory">Tyre Category <span class="text-danger">*</span></label>
                                        <select class="form-select badd-input" name="tyre_category" id="tcnCategory">
                                            <option value="Drive" selected>Drive Tyre</option>
                                            <option value="Steer">Steer Tyre</option>
                                            <option value="Trailer">Trailer Tyre</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Tyre Classification --}}
                        <div class="sc-card mb-3">
                            <div class="sc-card-head">
                                <span class="sc-card-title"><i class="uil uil-layer-group me-2"></i>Tyre Classification</span>
                            </div>
                            <div class="p-3 p-md-4">
                                <label class="badd-label">Tyre Condition <span class="text-danger">*</span></label>
                                <div class="tcn-radio-row">
                                    <label class="tcn-radio-chip">
                                        <input type="radio" name="condition" value="New" checked>
                                        <span>New</span>
                                    </label>
                                    <label class="tcn-radio-chip">
                                        <input type="radio" name="condition" value="Used">
                                        <span>Used</span>
                                    </label>
                                    <label class="tcn-radio-chip">
                                        <input type="radio" name="condition" value="Retread">
                                        <span>Retread</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        {{-- Purchase & Cost Details --}}
                        <div class="sc-card mb-3">
                            <div class="sc-card-head">
                                <span class="sc-card-title"><i class="uil uil-receipt me-2"></i>Purchase &amp; Cost Details</span>
                            </div>
                            <div class="p-3 p-md-4">
                                <div class="row g-3">
                                    <div class="col-12 col-md-4">
                                        <label class="badd-label" for="tcnPrice">Tyre Price (₹) <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text badd-unit">₹</span>
                                            <input type="number" class="form-control badd-input" name="tyre_price" id="tcnPrice" placeholder="0.00" min="0" step="0.01">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label class="badd-label" for="tcnPurchaseDate">Tyre Purchase Date <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control badd-input" name="tyre_purchase_date" id="tcnPurchaseDate" value="{{ date('Y-m-d') }}">
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label class="badd-label" for="tcnWarrantyMonths">Warranty Period (Months) <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="number" class="form-control badd-input" name="tyre_warranty_months" id="tcnWarrantyMonths" value="12" min="0" max="120">
                                            <span class="input-group-text badd-unit">mo.</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="badd-label" for="tcnWarrantyExpiry">Warranty Expiry Date</label>
                                        <input type="date" class="form-control badd-input" id="tcnWarrantyExpiry" readonly>
                                        <div class="form-text text-muted">Auto: Purchase Date + Warranty Months</div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="badd-label" for="tcnEndOfLife">End of Life Date</label>
                                        <input type="date" class="form-control badd-input" id="tcnEndOfLife" readonly>
                                        <div class="form-text text-muted">Auto: Purchase Date + Fixed Life Months</div>
                                    </div>
                                    <div class="col-12">
                                        <label class="badd-label" for="tcnInvoiceRef">Invoice / PO Reference</label>
                                        <input type="text" class="form-control badd-input" name="invoice_reference" id="tcnInvoiceRef" maxlength="100" placeholder="e.g. AMR-INV-0298734 or PO-2026-00041">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Lifecycle & Usage --}}
                        <div class="sc-card mb-3">
                            <div class="sc-card-head">
                                <span class="sc-card-title"><i class="uil uil-clock-three me-2"></i>Lifecycle &amp; Usage Tracking</span>
                            </div>
                            <div class="p-3 p-md-4">
                                <div class="row g-3">
                                    <div class="col-12 col-md-4">
                                        <label class="badd-label" for="tcnIssueDate">Tyre Issue Date</label>
                                        <input type="date" class="form-control badd-input" name="tyre_issue_date" id="tcnIssueDate">
                                        <div class="form-text text-muted">Optional — when assigned to a vehicle</div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label class="badd-label" for="tcnFixedRunKm">Fixed Run KM <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="number" class="form-control badd-input" name="fixed_run_km" id="tcnFixedRunKm" value="80000" min="0">
                                            <span class="input-group-text badd-unit">km</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label class="badd-label" for="tcnFixedLife">Fixed Life (Months) <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="number" class="form-control badd-input" name="fixed_life_months" id="tcnFixedLife" value="36" min="0" max="240">
                                            <span class="input-group-text badd-unit">mo.</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="badd-label" for="tcnActualRunKm">Actual Run KM</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control badd-input" name="actual_run_km" id="tcnActualRunKm" value="0" min="0">
                                            <span class="input-group-text badd-unit">km</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="badd-label" for="tcnActualRunMonth">Actual Run Months</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control badd-input" name="actual_run_month" id="tcnActualRunMonth" value="0" min="0">
                                            <span class="input-group-text badd-unit">mo.</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Maintenance Tracking --}}
                        <div class="sc-card mb-3">
                            <div class="sc-card-head">
                                <span class="sc-card-title"><i class="uil uil-wrench me-2"></i>Maintenance Tracking</span>
                            </div>
                            <div class="p-3 p-md-4">
                                <div class="row g-3">
                                    <div class="col-12 col-md-6">
                                        <label class="badd-label" for="tcnLastAlignment">Last Wheel Alignment KM</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control badd-input" name="last_alignment_km" id="tcnLastAlignment" min="0">
                                            <span class="input-group-text badd-unit">km</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="badd-label" for="tcnLastRotation">Last Wheel Rotation KM</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control badd-input" name="last_rotation_km" id="tcnLastRotation" min="0">
                                            <span class="input-group-text badd-unit">km</span>
                                        </div>
                                    </div>

                                    {{-- Alignment reminder row --}}
                                    <div class="col-12 col-md-6">
                                        <label class="badd-label" for="tcnAlignIntervalKm">Alignment Interval KM</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control badd-input" name="alignment_interval_km" id="tcnAlignIntervalKm" value="10000" min="1">
                                            <span class="input-group-text badd-unit">km</span>
                                        </div>
                                        <div class="tcn-reminder-row mt-2">
                                            <label class="tcn-switch">
                                                <input type="checkbox" name="set_reminder_for_alignment" id="tcnReminderAlign" value="1" checked>
                                                <span class="tcn-slider"></span>
                                            </label>
                                            <span class="tcn-switch-label">Set reminder for alignment</span>
                                        </div>
                                    </div>

                                    {{-- Rotation reminder row --}}
                                    <div class="col-12 col-md-6">
                                        <label class="badd-label" for="tcnRotIntervalKm">Rotation Interval KM</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control badd-input" name="rotation_interval_km" id="tcnRotIntervalKm" value="10000" min="1">
                                            <span class="input-group-text badd-unit">km</span>
                                        </div>
                                        <div class="tcn-reminder-row mt-2">
                                            <label class="tcn-switch">
                                                <input type="checkbox" name="set_reminder_for_rotation" id="tcnReminderRot" value="1" checked>
                                                <span class="tcn-slider"></span>
                                            </label>
                                            <span class="tcn-switch-label">Set reminder for rotation</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Technical Specifications --}}
                        <div class="sc-card mb-3">
                            <div class="sc-card-head">
                                <span class="sc-card-title"><i class="uil uil-bolt-alt me-2"></i>Technical Specifications</span>
                            </div>
                            <div class="p-3 p-md-4">
                                <div class="row g-3">
                                    <div class="col-12 col-md-3">
                                        <label class="badd-label" for="tcnPlyRating">Ply Rating <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control badd-input" name="ply_rating" id="tcnPlyRating" value="16" min="4" max="24">
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <label class="badd-label" for="tcnLoadIndex">Load Index</label>
                                        <input type="number" class="form-control badd-input" name="load_index" id="tcnLoadIndex" min="0" max="300" placeholder="e.g. 152">
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <label class="badd-label" for="tcnSpeedRating">Speed Rating</label>
                                        <input type="text" class="form-control badd-input" name="speed_rating" id="tcnSpeedRating" maxlength="2" placeholder="e.g. L">
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <label class="badd-label" for="tcnTreadDepth">Tread Depth</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control badd-input" name="tread_depth_mm" id="tcnTreadDepth" step="0.1" min="0" max="50" placeholder="e.g. 15.5">
                                            <span class="input-group-text badd-unit">mm</span>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label class="badd-label">Tube Type <span class="text-danger">*</span></label>
                                        <div class="tcn-radio-row">
                                            <label class="tcn-radio-chip">
                                                <input type="radio" name="tube_type" value="Tubeless" checked>
                                                <span>Tubeless</span>
                                            </label>
                                            <label class="tcn-radio-chip">
                                                <input type="radio" name="tube_type" value="Tube">
                                                <span>Tube</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Tyre Images --}}
                        <div class="sc-card mb-3">
                            <div class="sc-card-head">
                                <span class="sc-card-title"><i class="uil uil-image me-2"></i>Tyre Images <span class="text-danger">*</span></span>
                            </div>
                            <div class="p-3 p-md-4">
                                <div class="dropzone tcn-dropzone" id="tcnDropzone">
                                    <div class="dz-message needsclick">
                                        <i class="uil uil-upload me-2"></i>
                                        Drop files here or click to upload (Max 4 images · 3 MB each)
                                    </div>
                                </div>
                                <div class="form-text text-muted mt-2">
                                    Suggested: new tyre image, serial number close-up, condition image
                                </div>
                            </div>
                        </div>

                        {{-- Notes --}}
                        <div class="sc-card mb-3">
                            <div class="sc-card-head">
                                <span class="sc-card-title"><i class="uil uil-notes me-2"></i>Notes</span>
                            </div>
                            <div class="p-3 p-md-4">
                                <textarea class="form-control badd-input" name="notes" id="tcnNotes" rows="3" maxlength="2000"
                                          placeholder="Inspection remarks, defects, intended vehicle, or any free-text observations..."></textarea>
                            </div>
                        </div>

                    </div>

                    {{-- ── RIGHT COLUMN ── --}}
                    <div class="col-12 col-xl-4">

                        {{-- Stock Location --}}
                        <div class="sc-card mb-3">
                            <div class="sc-card-head">
                                <span class="sc-card-title"><i class="uil uil-map-marker me-2"></i>Stock Location <span class="text-danger">*</span></span>
                            </div>
                            <div class="p-3">
                                <p class="badd-loc-hint">Where is this tyre being stored?</p>
                                <div class="badd-loc-group" id="tcnLocGroup">
                                    <label class="badd-loc-option active" for="tcnLocNone">
                                        <input type="radio" name="stock_location" id="tcnLocNone" value="" class="d-none" checked>
                                        <span class="badd-loc-radio"></span>
                                        <span class="badd-loc-name">Not assigned yet</span>
                                    </label>

                                    @if($warehouses->count())
                                        <div class="badd-loc-section-label">Warehouses</div>
                                        @foreach($warehouses as $w)
                                            <label class="badd-loc-option" for="tcnLocWh{{ $w->id }}">
                                                <input type="radio" name="stock_location" id="tcnLocWh{{ $w->id }}" value="wh:{{ $w->id }}" class="d-none">
                                                <span class="badd-loc-radio"></span>
                                                <span class="badd-loc-code badd-loc-wh">WH</span>
                                                <span class="badd-loc-name">{{ $w->name }}</span>
                                            </label>
                                        @endforeach
                                    @endif

                                    @if($workshops->count())
                                        <div class="badd-loc-section-label">Workshops</div>
                                        @foreach($workshops as $s)
                                            <label class="badd-loc-option" for="tcnLocWs{{ $s->id }}">
                                                <input type="radio" name="stock_location" id="tcnLocWs{{ $s->id }}" value="ws:{{ $s->id }}" class="d-none">
                                                <span class="badd-loc-radio"></span>
                                                <span class="badd-loc-code badd-loc-ws">WS</span>
                                                <span class="badd-loc-name">{{ $s->name }}</span>
                                            </label>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Allocation Details --}}
                        <div class="sc-card mb-3">
                            <div class="sc-card-head">
                                <span class="sc-card-title"><i class="uil uil-truck me-2"></i>Allocation Details</span>
                            </div>
                            <div class="p-3">
                                <label class="badd-label">Current Status</label>
                                <div class="tcn-readonly-pill">
                                    <i class="uil uil-box me-1"></i> Warehouse
                                </div>

                                <label class="badd-label mt-3" for="tcnAllocatedVehicle">Allocated Vehicle</label>
                                <input type="text" class="form-control badd-input" name="allocated_vehicle_id" id="tcnAllocatedVehicle" placeholder="Vehicle ID (optional)" disabled>
                                <div class="form-text text-muted">Normally set via the Allocate flow</div>

                                <label class="badd-label mt-3" for="tcnInstallDate">Installation Date</label>
                                <input type="date" class="form-control badd-input" name="installation_date" id="tcnInstallDate" disabled>
                            </div>
                        </div>

                        {{-- Initial Condition --}}
                        <div class="sc-card mb-3">
                            <div class="sc-card-head">
                                <span class="sc-card-title"><i class="uil uil-check-circle me-2"></i>Initial Condition <span class="text-danger">*</span></span>
                            </div>
                            <div class="p-3">
                                <div class="badd-cond-group" id="tcnInitCondGroup">
                                    <label class="badd-cond-opt active" for="tcnIcNew">
                                        <input type="radio" name="initial_condition" id="tcnIcNew" value="New" class="d-none" checked>
                                        <span class="btd-cond-new">New</span>
                                        <span class="badd-cond-desc">Fresh, unused</span>
                                    </label>
                                    <label class="badd-cond-opt" for="tcnIcRetread">
                                        <input type="radio" name="initial_condition" id="tcnIcRetread" value="Retreaded" class="d-none">
                                        <span class="btd-cond-used">Retreaded</span>
                                        <span class="badd-cond-desc">Treaded & restored</span>
                                    </label>
                                    <label class="badd-cond-opt" for="tcnIcUsed">
                                        <input type="radio" name="initial_condition" id="tcnIcUsed" value="Used Good" class="d-none">
                                        <span class="btd-cond-used">Used (Good)</span>
                                        <span class="badd-cond-desc">Previously used, still good</span>
                                    </label>
                                    <label class="badd-cond-opt" for="tcnIcScrap">
                                        <input type="radio" name="initial_condition" id="tcnIcScrap" value="Scrap" class="d-none">
                                        <span class="btd-cond-weak">Scrap</span>
                                        <span class="badd-cond-desc">End of life / for disposal</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- Sticky Footer --}}
                <div class="badd-sticky-footer">
                    <div class="badd-footer-inner">
                        <a href="{{ route('tyre.dashboard') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="uil uil-times me-1"></i>Cancel
                        </a>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn sc-btn-navy btn-sm" id="tcnSubmit">
                                <span id="tcnSubmitText"><i class="uil uil-check me-1"></i>Add to Inventory</span>
                                <span id="tcnSubmitSpinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                            </button>
                        </div>
                    </div>
                </div>

            </form>

        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>
<script src="{{ asset('customjs/tyre/create-new.js?v=1.3') }}"></script>
@endsection
