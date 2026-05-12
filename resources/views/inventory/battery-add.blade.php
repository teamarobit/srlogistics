@extends('layouts.app')

@section('css')
<link href="{{ asset('css/Inventory/battery-add.css?v=3.0') }}" rel="stylesheet">
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
                    <li class="breadcrumb-item"><a href="{{ route('inventory.dashboard') }}">Inventory</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('inventory.battery-dashboard') }}">Battery Dashboard</a></li>
                    <li class="breadcrumb-item active">Add Battery</li>
                </ol>
            </nav>

            {{-- Page Header --}}
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div class="d-flex align-items-center gap-3">
                    <a href="{{ route('inventory.battery-dashboard') }}" class="bdet-back-btn" aria-label="Back">
                        <i class="uil uil-arrow-left"></i>
                    </a>
                    <div>
                        <h5 class="mb-0"><i class="uil uil-plus-circle me-2" style="color:#032671;"></i>Add Battery to Inventory</h5>
                        <span class="text-muted" style="font-size:12px;">Record a newly purchased or received battery unit into stock</span>
                    </div>
                </div>
            </div>

            <form id="banAddForm"
                  action="{{ route('inventory.battery.save') }}"
                  method="POST"
                  enctype="multipart/form-data"
                  data-dashboard-url="{{ route('inventory.battery-dashboard') }}"
                  novalidate>
                @csrf

                {{-- ── Source Toggle ── --}}
                <div class="badd-source-toggle-wrap mb-4">
                    <div class="badd-source-toggle" id="banSourceToggle">

                        <label class="badd-source-option active" for="banSrcExisting">
                            <input type="radio" name="battery_source_mode" id="banSrcExisting" value="Existing" class="d-none" checked>
                            <div class="d-flex align-items-center gap-3">
                                <div class="badd-src-icon badd-src-icon-existing"><i class="uil uil-box"></i></div>
                                <div>
                                    <div class="badd-source-label">Existing Battery</div>
                                    <div class="badd-source-desc">Transferred, replaced, or purchased outside system</div>
                                </div>
                                <span class="badd-source-radio ms-auto flex-shrink-0"></span>
                            </div>
                        </label>

                        <label class="badd-source-option" for="banSrcNewPO">
                            <input type="radio" name="battery_source_mode" id="banSrcNewPO" value="New PO" class="d-none">
                            <div class="d-flex align-items-center gap-3">
                                <div class="badd-src-icon badd-src-icon-new"><i class="uil uil-receipt-alt"></i></div>
                                <div>
                                    <div class="badd-source-label">New Battery (from PO / GRN)</div>
                                    <div class="badd-source-desc">Received via system PO or GRN reference</div>
                                </div>
                                <span class="badd-source-radio ms-auto flex-shrink-0"></span>
                            </div>
                        </label>

                        <label class="badd-source-option" for="banSrcFitment">
                            <input type="radio" name="battery_source_mode" id="banSrcFitment" value="Fitment" class="d-none">
                            <div class="d-flex align-items-center gap-3">
                                <div class="badd-src-icon badd-src-icon-fitment"><i class="uil uil-wrench"></i></div>
                                <div>
                                    <div class="badd-source-label">Direct Fitment</div>
                                    <div class="badd-source-desc">Battery purchased and fitted directly to vehicle without coming to SR Garage</div>
                                </div>
                                <span class="badd-source-radio ms-auto flex-shrink-0"></span>
                            </div>
                        </label>

                    </div>

                    {{-- Mode: Existing Battery --}}
                    <div class="badd-mode-section active" id="banModeExisting">
                        <div class="sc-card mb-0">
                            <div class="sc-card-head">
                                <span class="sc-card-title"><i class="uil uil-notes me-2"></i>Source Information</span>
                            </div>
                            <div class="p-3">
                                <div class="row g-3">
                                    <div class="col-12 col-md-8">
                                        <label class="badd-label" for="banSourceNote">Battery Source / Origin Note <span class="text-danger">*</span></label>
                                        <textarea class="form-control badd-input" name="source_origin_note" id="banSourceNote" rows="3"
                                                  placeholder="e.g. Received from vendor, replaced under warranty, transferred from another depot..."></textarea>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label class="badd-label">Invoice / Bill (optional)</label>
                                        <div class="badd-file-zone" id="banFileZone">
                                            <input type="file" name="invoice_file" id="banInvoiceFile" class="d-none" accept=".pdf,.jpg,.jpeg,.png">
                                            <i class="uil uil-file-upload-alt badd-file-icon"></i>
                                            <span class="badd-file-text">Click to attach or drop file</span>
                                            <span class="badd-file-hint">PDF, JPG, PNG · max 10MB</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Mode: New Battery from PO/GRN --}}
                    <div class="badd-mode-section" id="banModeNewPO">
                        <div class="sc-card mb-0">
                            <div class="sc-card-head">
                                <span class="sc-card-title"><i class="uil uil-receipt-alt me-2"></i>Select PO / GRN</span>
                            </div>
                            <div class="p-3">
                                <div class="row g-3">
                                    <div class="col-12 col-md-7">
                                        <label class="badd-label" for="banPoGrnSelect">PO / GRN Reference <span class="text-danger">*</span></label>
                                        <select class="form-select ban-select2 badd-input" name="purchase_order_reference" id="banPoGrnSelect" style="width:100%;">
                                            <option value="">Search PO or GRN number...</option>
                                        </select>
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

                    {{-- Mode: Direct Fitment --}}
                    <div class="badd-mode-section" id="banModeFitment">
                        <div class="sc-card mb-0">
                            <div class="sc-card-head">
                                <span class="sc-card-title"><i class="uil uil-notes me-2"></i>Source Information</span>
                            </div>
                            <div class="p-3">
                                <div class="row g-3">
                                    <div class="col-12 col-md-8">
                                        <label class="badd-label" for="banFitmentSourceNote">Battery Source / Origin Note <span class="text-danger">*</span></label>
                                        <textarea class="form-control badd-input" name="fitment_source_origin_note" id="banFitmentSourceNote" rows="3"
                                                  placeholder="e.g. Received from vendor, replaced under warranty, transferred from another depot..."></textarea>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label class="badd-label">Invoice / Bill (optional)</label>
                                        <div class="badd-file-zone" id="banFitmentFileZone">
                                            <input type="file" name="fitment_invoice_file" id="banFitmentInvoiceFile" class="d-none" accept=".pdf,.jpg,.jpeg,.png">
                                            <i class="uil uil-file-upload-alt badd-file-icon"></i>
                                            <span class="badd-file-text">Click to attach or drop file</span>
                                            <span class="badd-file-hint">PDF, JPG, PNG · max 10MB</span>
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

                        {{-- Battery Identity --}}
                        <div class="sc-card mb-3">
                            <div class="sc-card-head">
                                <span class="sc-card-title"><i class="uil uil-tag-alt me-2"></i>Battery Identity</span>
                            </div>
                            <div class="p-3 p-md-4">
                                <div class="row g-3">

                                    {{-- Battery Condition segmented --}}
                                    <div class="col-12">
                                        <label class="badd-label">Battery Condition <span class="text-danger">*</span></label>
                                        <div class="ban-radio-row">
                                            <label class="ban-radio-chip active" id="banCondChipNew">
                                                <input type="radio" name="battery_condition" value="New" checked>
                                                <span>New</span>
                                            </label>
                                            <label class="ban-radio-chip" id="banCondChipUsed">
                                                <input type="radio" name="battery_condition" value="Used">
                                                <span>Used</span>
                                            </label>
                                            <label class="ban-radio-chip" id="banCondChipWarranty">
                                                <input type="radio" name="battery_condition" value="Replaced Under Warranty">
                                                <span>Replaced Under Warranty</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <label class="badd-label" for="banSerial">Battery Serial Number <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control badd-input" name="battery_serial" id="banSerial"
                                               placeholder="e.g. BAT-2026-00095" maxlength="100">
                                        <div class="form-text text-muted">Must be unique — use format BAT-YYYY-NNNNN</div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <label class="badd-label" for="banBrand">Battery Brand <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control badd-input" name="battery_brand" id="banBrand"
                                               placeholder="e.g. Amaron, Exide, Luminous" maxlength="100">
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <label class="badd-label" for="banModel">Battery Model</label>
                                        <input type="text" class="form-control badd-input" name="battery_model" id="banModel"
                                               placeholder="e.g. Pro Truck 150, Matrix 180" maxlength="100">
                                    </div>

                                    <div class="col-12 col-md-3">
                                        <label class="badd-label" for="banCapacity">Battery Capacity <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="number" class="form-control badd-input" name="battery_capacity" id="banCapacity"
                                                   placeholder="e.g. 150" min="1" max="9999">
                                            <span class="input-group-text badd-unit">Ah</span>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-3">
                                        <label class="badd-label" for="banVoltage">Battery Voltage <span class="text-danger">*</span></label>
                                        <select class="form-select badd-input" name="battery_voltage" id="banVoltage">
                                            <option value="">Select...</option>
                                            <option value="6V">6V</option>
                                            <option value="12V" selected>12V</option>
                                            <option value="24V">24V</option>
                                            <option value="48V">48V</option>
                                        </select>
                                    </div>

                                </div>
                            </div>
                        </div>

                        {{-- Purchase Details --}}
                        <div class="sc-card mb-3">
                            <div class="sc-card-head">
                                <span class="sc-card-title"><i class="uil uil-receipt me-2"></i>Purchase Details</span>
                            </div>
                            <div class="p-3 p-md-4">
                                <div class="row g-3">

                                    <div class="col-12 col-md-6">
                                        <label class="badd-label" for="banVendor">Vendor</label>
                                        <select class="form-select ban-select2 badd-input" name="vendor_id" id="banVendor" style="width:100%;">
                                            <option value="">Select vendor...</option>
                                            @foreach($batteryvendors as $v)
                                                <option value="{{ $v->id }}">{{ $v->contact_name }}{{ $v->company_name ? ' (' . $v->company_name . ')' : '' }}</option>
                                            @endforeach
                                        </select>
                                        <div class="mt-1">
                                            <a href="{{ route('contact.batteryvendor.create') }}" class="badd-add-link" target="_blank">
                                                <i class="uil uil-plus me-1"></i>Add New Vendor
                                            </a>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <label class="badd-label" for="banInvoiceRef">Invoice / PO Reference</label>
                                        <input type="text" class="form-control badd-input" name="battery_invoice_ref" id="banInvoiceRef"
                                               placeholder="e.g. AMR-INV-0298734 or PO-2026-00041" maxlength="100">
                                    </div>

                                    <div class="col-12 col-md-4">
                                        <label class="badd-label" for="banPrice">Battery Price</label>
                                        <div class="input-group">
                                            <span class="input-group-text badd-unit">₹</span>
                                            <input type="number" class="form-control badd-input" name="battery_purchase_cost" id="banPrice"
                                                   placeholder="0.00" min="0" step="0.01">
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-4">
                                        <label class="badd-label" for="banPurchaseDate">Purchase Date</label>
                                        <input type="date" class="form-control badd-input" name="battery_purchase_date" id="banPurchaseDate">
                                    </div>

                                    <div class="col-12 col-md-4">
                                        <label class="badd-label" for="banWarrantyMonths">Warranty Period (Months)</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control badd-input" name="battery_warranty_months" id="banWarrantyMonths"
                                                   placeholder="e.g. 36" min="0" max="120" value="0">
                                            <span class="input-group-text badd-unit">mo.</span>
                                        </div>
                                        <div class="form-text text-muted">If battery is not under warranty, enter 0</div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <label class="badd-label" for="banWarrantyExpiry">Warranty Expiry Date</label>
                                        <input type="date" class="form-control badd-input" id="banWarrantyExpiry" readonly tabindex="-1">
                                        <div class="form-text text-muted">Auto calculated from purchase date and warranty period</div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        {{-- Lifecycle & Usage Tracking --}}
                        <div class="sc-card mb-3">
                            <div class="sc-card-head">
                                <span class="sc-card-title"><i class="uil uil-clock-three me-2"></i>Lifecycle &amp; Usage Tracking</span>
                            </div>
                            <div class="p-3 p-md-4">
                                <div class="row g-3">

                                    <div class="col-12 col-md-4">
                                        <label class="badd-label" for="banIssueDate">Battery Issue Date</label>
                                        <input type="date" class="form-control badd-input" name="battery_issue_date" id="banIssueDate">
                                    </div>

                                    <div class="col-12 col-md-4">
                                        <label class="badd-label" for="banFixedLifeMonths">Battery Fixed Life (Months) <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="number" class="form-control badd-input" name="battery_fixed_life_months" id="banFixedLifeMonths"
                                                   value="36" min="1" max="240">
                                            <span class="input-group-text badd-unit">mo.</span>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-4">
                                        <label class="badd-label" for="banActualUsageMonths">Actual Usage Months</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control badd-input" name="battery_actual_usage_months" id="banActualUsageMonths"
                                                   value="0" min="0">
                                            <span class="input-group-text badd-unit">mo.</span>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <label class="badd-label" for="banEndOfLife">Expected End of Life Date</label>
                                        <input type="date" class="form-control badd-input" id="banEndOfLife" readonly tabindex="-1">
                                        <div class="form-text text-muted">Auto calculated using issue date + fixed life</div>
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
                                        <label class="badd-label" for="banLastVoltageCheck">Last Voltage Check Date</label>
                                        <input type="date" class="form-control badd-input" name="last_voltage_check_date" id="banLastVoltageCheck">
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <label class="badd-label" for="banLastChargingCheck">Last Charging Check Date</label>
                                        <input type="date" class="form-control badd-input" name="last_charging_check_date" id="banLastChargingCheck">
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <label class="badd-label" for="banHealthPct">Battery Health %</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control badd-input" name="battery_health_pct" id="banHealthPct"
                                                   placeholder="e.g. 85" min="0" max="100">
                                            <span class="input-group-text badd-unit">%</span>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <label class="badd-label" for="banNextInspection">Next Inspection Due</label>
                                        <input type="date" class="form-control badd-input" name="next_inspection_due_date" id="banNextInspection">
                                    </div>

                                    <div class="col-12">
                                        <div class="ban-reminder-row">
                                            <label class="ban-switch">
                                                <input type="checkbox" name="maintenance_reminder_enabled" id="banMaintenanceReminder" value="1" checked>
                                                <span class="ban-slider"></span>
                                            </label>
                                            <span class="ban-switch-label">Enable maintenance reminders</span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        {{-- Battery Attachments --}}
                        <div class="sc-card mb-3">
                            <div class="sc-card-head">
                                <span class="sc-card-title"><i class="uil uil-paperclip me-2"></i>Battery Attachments</span>
                            </div>
                            <div class="p-3 p-md-4">
                                <div class="dropzone ban-dropzone" id="banDropzone">
                                    <div class="dz-message needsclick">
                                        <i class="uil uil-upload me-2"></i>
                                        Drop files here or click to upload &nbsp;&middot;&nbsp; Max 4 files · 3 MB each
                                    </div>
                                </div>
                                <div class="form-text text-muted mt-2">
                                    Upload types: Battery Serial No. Photo &middot; Battery Invoice &middot; Warranty Card &middot; Battery Condition Image
                                </div>
                            </div>
                        </div>

                        {{-- Comments --}}
                        <div class="sc-card mb-3">
                            <div class="sc-card-head">
                                <span class="sc-card-title"><i class="uil uil-comment-alt-notes me-2"></i>Comments</span>
                            </div>
                            <div class="p-3 p-md-4">
                                <textarea class="form-control badd-input" name="battery_notes" id="banNotes" rows="3" maxlength="2000"
                                          placeholder="Inspection remarks, replacement reason, battery performance notes, or operational observations..."></textarea>
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
                                <p class="badd-loc-hint ban-loc-standard">Where is this battery being stored?</p>
                                <div class="badd-loc-group" id="banLocGroup">

                                    {{-- Direct Fitment option (Fitment mode only) --}}
                                    <label class="badd-loc-option badd-loc-fitment-only" for="banLocFitment">
                                        <input type="radio" name="stock_location" id="banLocFitment" value="fitment" class="d-none">
                                        <span class="badd-loc-radio"></span>
                                        <span class="badd-loc-code" style="background:#fff3e0;color:#e65100;">DF</span>
                                        <span class="badd-loc-name">Direct Fitment</span>
                                    </label>

                                    {{-- Standard options --}}
                                    <label class="badd-loc-option ban-loc-standard active" for="banLocNone">
                                        <input type="radio" name="stock_location" id="banLocNone" value="" class="d-none" checked>
                                        <span class="badd-loc-radio"></span>
                                        <span class="badd-loc-name">Not Assigned Yet</span>
                                    </label>

                                    @if($warehouses->count())
                                        <div class="badd-loc-section-label ban-loc-standard">Warehouses</div>
                                        @foreach($warehouses as $w)
                                            <label class="badd-loc-option ban-loc-standard" for="banLocWh{{ $w->id }}">
                                                <input type="radio" name="stock_location" id="banLocWh{{ $w->id }}" value="wh:{{ $w->id }}" class="d-none">
                                                <span class="badd-loc-radio"></span>
                                                <span class="badd-loc-code badd-loc-wh">WH</span>
                                                <span class="badd-loc-name">{{ $w->name }}</span>
                                            </label>
                                        @endforeach
                                    @endif

                                    @if($workshops->count())
                                        <div class="badd-loc-section-label ban-loc-standard">Garages / Workshops</div>
                                        @foreach($workshops as $s)
                                            <label class="badd-loc-option ban-loc-standard" for="banLocWs{{ $s->id }}">
                                                <input type="radio" name="stock_location" id="banLocWs{{ $s->id }}" value="ws:{{ $s->id }}" class="d-none">
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

                                {{-- Warranty alert (shown when "Replaced Under Warranty" selected) --}}
                                <div class="ban-warranty-alert d-none" id="banWarrantyAlert">
                                    <i class="uil uil-exclamation-triangle ban-warranty-alert-icon"></i>
                                    <div>
                                        <div class="ban-warranty-alert-title">Warranty Remaining Detected</div>
                                        <div class="ban-warranty-alert-body">This battery still has active warranty coverage.</div>
                                    </div>
                                </div>

                                <label class="badd-label">Current Status</label>
                                <div class="ban-readonly-pill mb-3">
                                    <i class="uil uil-box me-1"></i> In Warehouse
                                </div>

                                <label class="badd-label mt-2" for="banAllocVehicle">Allocated Vehicle</label>
                                <input type="text" class="form-control badd-input mb-1" name="allocated_vehicle_id" id="banAllocVehicle"
                                       placeholder="Vehicle ID (optional)" disabled>
                                <div class="form-text text-muted mb-3">Normally set via the Allocate flow</div>

                                <label class="badd-label" for="banInstallDate">Installation Date</label>
                                <input type="date" class="form-control badd-input mb-3" name="installation_date" id="banInstallDate" disabled>

                                <label class="badd-label" for="banOdometer">Current Odometer</label>
                                <div class="input-group">
                                    <input type="number" class="form-control badd-input" name="current_odometer_km" id="banOdometer"
                                           placeholder="e.g. 125000" min="0" disabled>
                                    <span class="input-group-text badd-unit">KM</span>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>{{-- end .row --}}

                {{-- Sticky Footer --}}
                <div class="badd-sticky-footer">
                    <div class="badd-footer-inner">
                        <a href="{{ route('inventory.battery-dashboard') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="uil uil-times me-1"></i>Cancel
                        </a>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn sc-btn-navy btn-sm" id="banSubmit">
                                <span id="banSubmitText"><i class="uil uil-check me-1"></i>Add to Inventory</span>
                                <span id="banSubmitSpinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
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
<script src="{{ asset('customjs/inventory/battery-add.js?v=2.0') }}"></script>
@endsection
