@extends('layouts.app')

@section('css')
{{-- Reuse Battery-Add design system (same as create-new) --}}
<link href="{{ asset('css/Inventory/battery-add.css?v=1.1') }}" rel="stylesheet">
{{-- Tyre design tokens (radio chips, toggle switches, dropzone, sticky footer) --}}
<link href="{{ asset('css/tyre/create-new.css?v=2.0') }}" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css" rel="stylesheet">
@endsection

@section('content')

@php
    /* ── Pre-compute initial_condition from whichever column has data ── */
    $initCond = $tyre->initial_condition;
    if (! $initCond) {
        $condMap  = ['New' => 'New', 'Re-thread' => 'Retreaded', 'Retread' => 'Retreaded',
                     'Used Good' => 'Used Good', 'Used' => 'Used Good',
                     'Scrap' => 'Scrap', 'Discard' => 'Scrap'];
        $initCond = $condMap[$tyre->tyre_condition] ?? 'New';
    }

    /* ── Pre-compute stock location radio value ── */
    $selectedLoc = '';
    if ($tyre->warehouse_id) {
        $selectedLoc = 'wh:' . $tyre->warehouse_id;
    } elseif ($tyre->workshop_id) {
        $selectedLoc = 'ws:' . $tyre->workshop_id;
    }
@endphp

<div class="layout-wrapper">
    @include('includes.header')
    <div class="wrapper srlog-bdwrapper">
        <div class="main-wrap sc-no-sidebar">

            {{-- Breadcrumb --}}
            <nav aria-label="breadcrumb" class="mb-2">
                <ol class="breadcrumb sc-breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('tyre.dashboard') }}">Tyre Dashboard</a></li>
                    <li class="breadcrumb-item active">Edit Tyre</li>
                </ol>
            </nav>

            {{-- Page Header --}}
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div class="d-flex align-items-center gap-3">
                    <a href="{{ route('tyre.dashboard') }}" class="bdet-back-btn" aria-label="Back">
                        <i class="uil uil-arrow-left"></i>
                    </a>
                    <div>
                        <h5 class="mb-0"><i class="uil uil-edit-alt me-2" style="color:#032671;"></i>Edit Tyre</h5>
                        <span class="text-muted" style="font-size:12px;">
                            Serial: <strong>{{ $tyre->tyre_serial_number }}</strong>
                            &nbsp;·&nbsp; Update tyre details, lifecycle &amp; maintenance data
                        </span>
                    </div>
                </div>
            </div>

            <form id="tyrEditForm"
                  action="{{ route('tyre.update', $tyre->id) }}"
                  method="POST"
                  enctype="multipart/form-data"
                  data-dashboard-url="{{ route('tyre.dashboard') }}"
                  data-tyre-price="{{ $tyre->tyre_price ?? 0 }}"
                  novalidate>
                @csrf

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

                                    {{-- Tyre Condition (4-option radio chips) --}}
                                    <div class="col-12">
                                        <label class="badd-label">Tyre Condition <span class="text-danger">*</span></label>
                                        <div class="tcn-radio-row">
                                            <label class="tcn-radio-chip {{ $initCond === 'New' ? 'active' : '' }}">
                                                <input type="radio" name="initial_condition" value="New" {{ $initCond === 'New' ? 'checked' : '' }}>
                                                <span>New</span>
                                            </label>
                                            <label class="tcn-radio-chip {{ $initCond === 'Retreaded' ? 'active' : '' }}">
                                                <input type="radio" name="initial_condition" value="Retreaded" {{ $initCond === 'Retreaded' ? 'checked' : '' }}>
                                                <span>Retreaded</span>
                                            </label>
                                            <label class="tcn-radio-chip {{ $initCond === 'Used Good' ? 'active' : '' }}">
                                                <input type="radio" name="initial_condition" value="Used Good" {{ $initCond === 'Used Good' ? 'checked' : '' }}>
                                                <span>Used (Good)</span>
                                            </label>
                                            <label class="tcn-radio-chip {{ $initCond === 'Scrap' ? 'active' : '' }}">
                                                <input type="radio" name="initial_condition" value="Scrap" {{ $initCond === 'Scrap' ? 'checked' : '' }}>
                                                <span>Scrap</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <label class="badd-label" for="tceSerial">Tyre Serial Number <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control badd-input" name="tyre_serial_number" id="tceSerial"
                                               value="{{ $tyre->tyre_serial_number }}" placeholder="e.g. TYR-2026-00095" maxlength="100">
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label class="badd-label" for="tceBrand">Tyre Brand <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control badd-input" name="tyre_brand" id="tceBrand"
                                               value="{{ $tyre->tyre_brand }}" placeholder="e.g. MRF, Apollo, JK" maxlength="100">
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label class="badd-label" for="tceModel">Tyre Model <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control badd-input" name="tyre_model_name" id="tceModel"
                                               value="{{ $tyre->tyre_model }}" placeholder="e.g. Steel Muscle" maxlength="100">
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label class="badd-label" for="tceSize">Tyre Size</label>
                                        <input type="text" class="form-control badd-input" name="tyre_size" id="tceSize"
                                               value="{{ $tyre->tyre_size }}" placeholder="e.g. 295/90 R20" maxlength="50">
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label class="badd-label" for="tceCategory">Tyre Category</label>
                                        <select class="form-select badd-input" name="tyre_category" id="tceCategory">
                                            <option value="">— Select —</option>
                                            <option value="Drive"   {{ $tyre->tyre_category === 'Drive'   ? 'selected' : '' }}>Drive Tyre</option>
                                            <option value="Steer"   {{ $tyre->tyre_category === 'Steer'   ? 'selected' : '' }}>Steer Tyre</option>
                                            <option value="Trailer" {{ $tyre->tyre_category === 'Trailer' ? 'selected' : '' }}>Trailer Tyre</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="badd-label">Tyre Type <span class="text-danger">*</span></label>
                                        <div class="tcn-radio-row">
                                            <label class="tcn-radio-chip {{ $tyre->tyre_type === 'Radial' ? 'active' : '' }}">
                                                <input type="radio" name="tyre_type" value="Radial" {{ $tyre->tyre_type === 'Radial' ? 'checked' : '' }}>
                                                <span>Radial</span>
                                            </label>
                                            <label class="tcn-radio-chip {{ $tyre->tyre_type === 'Nylon' ? 'active' : '' }}">
                                                <input type="radio" name="tyre_type" value="Nylon" {{ $tyre->tyre_type === 'Nylon' ? 'checked' : '' }}>
                                                <span>Nylon</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="badd-label">Tube Type</label>
                                        <div class="tcn-radio-row">
                                            <label class="tcn-radio-chip {{ $tyre->tube_type === 'Tubeless' ? 'active' : '' }}">
                                                <input type="radio" name="tube_type" value="Tubeless" {{ $tyre->tube_type === 'Tubeless' ? 'checked' : '' }}>
                                                <span>Tubeless</span>
                                            </label>
                                            <label class="tcn-radio-chip {{ $tyre->tube_type === 'Tube' ? 'active' : '' }}">
                                                <input type="radio" name="tube_type" value="Tube" {{ $tyre->tube_type === 'Tube' ? 'checked' : '' }}>
                                                <span>Tube</span>
                                            </label>
                                        </div>
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
                                        <label class="badd-label" for="tceVendor">Vendor <span class="text-danger">*</span></label>
                                        <select class="form-select tce-select2 badd-input" name="vendor" id="tceVendor" style="width:100%;">
                                            <option value="">Select vendor...</option>
                                            @foreach($tyrevendors as $v)
                                                <option value="{{ $v->id }}" {{ $tyre->contact_id == $v->id ? 'selected' : '' }}>
                                                    {{ $v->contact_name }} ({{ $v->company_name }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="badd-label" for="tceInvoiceRef">Invoice / PO Reference</label>
                                        <input type="text" class="form-control badd-input" name="invoice_reference" id="tceInvoiceRef"
                                               value="{{ $tyre->invoice_reference }}" maxlength="100"
                                               placeholder="e.g. AMR-INV-0298734 or PO-2026-00041">
                                    </div>

                                    {{-- Price breakdown --}}
                                    <div class="col-12">
                                        <div class="tcn-price-section-heading">
                                            <span>Tyre Price</span>
                                            <small class="text-muted">All amounts in ₹ &nbsp;·&nbsp; GST @ 28%</small>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label class="badd-label" for="tceTaxable">Taxable Amount <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text badd-unit">₹</span>
                                            <input type="number" class="form-control badd-input" name="tyre_taxable_amount" id="tceTaxable"
                                                   placeholder="0.00" min="0" step="0.01"
                                                   value="{{ $tyre->tyre_price ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label class="badd-label" for="tceGst">GST <small class="text-muted fw-normal">(28%)</small></label>
                                        <div class="input-group">
                                            <span class="input-group-text badd-unit">₹</span>
                                            <input type="number" class="form-control badd-input" name="tyre_gst_amount" id="tceGst"
                                                   placeholder="0.00" min="0" step="0.01" readonly tabindex="-1">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label class="badd-label" for="tceTotal">Total Amount</label>
                                        <div class="input-group">
                                            <span class="input-group-text badd-unit">₹</span>
                                            <input type="number" class="form-control badd-input" name="tyre_total_amount" id="tceTotal"
                                                   placeholder="0.00" min="0" step="0.01" readonly tabindex="-1">
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-4">
                                        <label class="badd-label" for="tcePurchaseDate">Tyre Purchase Date <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control badd-input" name="tyre_purchase_date" id="tcePurchaseDate"
                                               value="{{ $tyre->tyre_purchase_date ? date('Y-m-d', strtotime($tyre->tyre_purchase_date)) : '' }}">
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label class="badd-label" for="tceWarrantyMonths">Warranty Period (Months) <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="number" class="form-control badd-input" name="tyre_warranty_months" id="tceWarrantyMonths"
                                                   value="{{ $tyre->tyre_warranty_months ?? 12 }}" min="0" max="120">
                                            <span class="input-group-text badd-unit">mo.</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label class="badd-label" for="tceWarrantyExpiry">Warranty Expiry Date</label>
                                        <input type="date" class="form-control badd-input" id="tceWarrantyExpiry"
                                               value="{{ $tyre->tyre_warrenty_end_date ? date('Y-m-d', strtotime($tyre->tyre_warrenty_end_date)) : '' }}"
                                               readonly tabindex="-1">
                                        <div class="form-text text-muted">Auto: Purchase Date + Warranty Months</div>
                                    </div>

                                    {{-- Flap / Tube --}}
                                    <div class="col-12">
                                        <label class="badd-label">Flap / Tube</label>
                                        <div class="tcn-radio-row" id="tceFlapTubeRow">
                                            <label class="tcn-radio-chip {{ $tyre->flap_tube_type === 'Flap' ? 'active' : '' }}" id="tceFlapChip">
                                                <input type="radio" name="flap_tube_type" value="Flap" id="tceFlapRadio"
                                                       {{ $tyre->flap_tube_type === 'Flap' ? 'checked' : '' }}>
                                                <span>Flap</span>
                                            </label>
                                            <label class="tcn-radio-chip {{ $tyre->flap_tube_type === 'Tube' ? 'active' : '' }}" id="tceTubeChip">
                                                <input type="radio" name="flap_tube_type" value="Tube" id="tceTubeRadio"
                                                       {{ $tyre->flap_tube_type === 'Tube' ? 'checked' : '' }}>
                                                <span>Tube</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-12 {{ $tyre->flap_tube_type ? '' : 'd-none' }}" id="tceFlapTubePriceSection">
                                        <div class="tcn-price-section-heading tcn-price-section-heading--sub">
                                            <span id="tceFlapTubePriceLabel">{{ $tyre->flap_tube_type ? $tyre->flap_tube_type . ' Price' : 'Accessory Price' }}</span>
                                            <small class="text-muted">All amounts in &#8377; &nbsp;&middot;&nbsp; GST @ 28%</small>
                                        </div>
                                        <div class="row g-3 mt-0">
                                            <div class="col-12 col-md-4">
                                                <label class="badd-label" for="tceFTTaxable">Taxable Amount</label>
                                                <div class="input-group">
                                                    <span class="input-group-text badd-unit">&#8377;</span>
                                                    <input type="number" class="form-control badd-input" name="flap_tube_taxable_amount" id="tceFTTaxable"
                                                           placeholder="0.00" min="0" step="0.01"
                                                           value="{{ $tyre->flap_tube_taxable_amount ?? '' }}">
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4">
                                                <label class="badd-label" for="tceFTGst">GST <small class="text-muted fw-normal">(28%)</small></label>
                                                <div class="input-group">
                                                    <span class="input-group-text badd-unit">&#8377;</span>
                                                    <input type="number" class="form-control badd-input" name="flap_tube_gst_amount" id="tceFTGst"
                                                           placeholder="0.00" min="0" step="0.01" readonly tabindex="-1"
                                                           value="{{ $tyre->flap_tube_gst_amount ?? '' }}">
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4">
                                                <label class="badd-label" for="tceFTTotal">Total Amount</label>
                                                <div class="input-group">
                                                    <span class="input-group-text badd-unit">&#8377;</span>
                                                    <input type="number" class="form-control badd-input" name="flap_tube_total_amount" id="tceFTTotal"
                                                           placeholder="0.00" min="0" step="0.01" readonly tabindex="-1"
                                                           value="{{ $tyre->flap_tube_total_amount ?? '' }}">
                                                </div>
                                            </div>
                                        </div>
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
                                        <label class="badd-label" for="tceIssueDate">Tyre Issue Date</label>
                                        <input type="date" class="form-control badd-input" name="tyre_issue_date" id="tceIssueDate"
                                               value="{{ $tyre->tyre_issue_date ? date('Y-m-d', strtotime($tyre->tyre_issue_date)) : '' }}">
                                        <div class="form-text text-muted">Optional — when assigned to a vehicle</div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label class="badd-label" for="tceFixedRunKm">Fixed Run KM <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="number" class="form-control badd-input" name="fixed_run_km" id="tceFixedRunKm"
                                                   value="{{ $tyre->fixed_run_km ?? 80000 }}" min="0">
                                            <span class="input-group-text badd-unit">km</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label class="badd-label" for="tceFixedLife">Fixed Life (Months) <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="number" class="form-control badd-input" name="fixed_life_months" id="tceFixedLife"
                                                   value="{{ $tyre->fixed_life_months ?? 36 }}" min="0" max="240">
                                            <span class="input-group-text badd-unit">mo.</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="badd-label" for="tceActualRunKm">Actual Run KM</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control badd-input" name="actual_run_km" id="tceActualRunKm"
                                                   value="{{ $tyre->actual_run_km ?? 0 }}" min="0">
                                            <span class="input-group-text badd-unit">km</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="badd-label" for="tceActualRunMonth">Actual Run Months</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control badd-input" name="actual_run_month" id="tceActualRunMonth"
                                                   value="{{ $tyre->actual_run_month ?? 0 }}" min="0">
                                            <span class="input-group-text badd-unit">mo.</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="badd-label" for="tceEndOfLife">End of Life Date</label>
                                        <input type="date" class="form-control badd-input" id="tceEndOfLife"
                                               value="{{ $tyre->end_of_life_date ? date('Y-m-d', strtotime($tyre->end_of_life_date)) : '' }}"
                                               readonly tabindex="-1">
                                        <div class="form-text text-muted">Auto: Purchase Date + Fixed Life Months</div>
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
                                        <label class="badd-label" for="tceLastAlignment">Last Wheel Alignment KM</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control badd-input" name="last_alignment_km" id="tceLastAlignment"
                                                   value="{{ $tyre->last_alignment_km }}" min="0">
                                            <span class="input-group-text badd-unit">km</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="badd-label" for="tceLastRotation">Last Wheel Rotation KM</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control badd-input" name="last_rotation_km" id="tceLastRotation"
                                                   value="{{ $tyre->last_rotation_km }}" min="0">
                                            <span class="input-group-text badd-unit">km</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="badd-label" for="tceAlignIntervalKm">Alignment Interval KM</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control badd-input" name="alignment_interval_km" id="tceAlignIntervalKm"
                                                   value="{{ $tyre->alignment_interval_km ?? 10000 }}" min="1">
                                            <span class="input-group-text badd-unit">km</span>
                                        </div>
                                        <div class="tcn-reminder-row mt-2">
                                            <label class="tcn-switch">
                                                <input type="checkbox" name="set_reminder_for_alignment" id="tceReminderAlign"
                                                       value="1" {{ $tyre->set_reminder_for_alignment === 'Yes' ? 'checked' : '' }}>
                                                <span class="tcn-slider"></span>
                                            </label>
                                            <span class="tcn-switch-label">Set reminder for alignment</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="badd-label" for="tceRotIntervalKm">Rotation Interval KM</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control badd-input" name="rotation_interval_km" id="tceRotIntervalKm"
                                                   value="{{ $tyre->rotation_interval_km ?? 10000 }}" min="1">
                                            <span class="input-group-text badd-unit">km</span>
                                        </div>
                                        <div class="tcn-reminder-row mt-2">
                                            <label class="tcn-switch">
                                                <input type="checkbox" name="set_reminder_for_rotation" id="tceReminderRot"
                                                       value="1" {{ $tyre->set_reminder_for_rotation === 'Yes' ? 'checked' : '' }}>
                                                <span class="tcn-slider"></span>
                                            </label>
                                            <span class="tcn-switch-label">Set reminder for rotation</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Tyre Images --}}
                        <div class="sc-card mb-3">
                            <div class="sc-card-head">
                                <span class="sc-card-title"><i class="uil uil-image me-2"></i>Tyre Images</span>
                            </div>
                            <div class="p-3 p-md-4">
                                @php
                                    $existingImages = array_filter([
                                        $tyre->tyre_image1 ?? null,
                                        $tyre->tyre_image2 ?? null,
                                        $tyre->tyre_image3 ?? null,
                                        $tyre->tyre_image4 ?? null,
                                    ]);
                                @endphp
                                @if(count($existingImages) > 0)
                                    <div class="row g-2 mb-3">
                                        @foreach($existingImages as $img)
                                            <div class="col-6 col-md-3">
                                                <img src="{{ asset('medias/tyres/' . $img) }}"
                                                     class="img-fluid rounded border" style="height:100px;object-fit:cover;width:100%;"
                                                     alt="Tyre image">
                                            </div>
                                        @endforeach
                                    </div>
                                    <p class="form-text text-muted mb-2">Existing images above. Upload below to replace or add new ones.</p>
                                @endif
                                <div class="dropzone tcn-dropzone" id="tceDropzone">
                                    <div class="dz-message needsclick">
                                        <i class="uil uil-upload me-2"></i>
                                        Drop files here or click to upload (Max 4 images &middot; 2 MB each)
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Notes --}}
                        <div class="sc-card mb-3">
                            <div class="sc-card-head">
                                <span class="sc-card-title"><i class="uil uil-notes me-2"></i>Notes</span>
                            </div>
                            <div class="p-3 p-md-4">
                                <textarea class="form-control badd-input" name="notes" id="tceNotes" rows="3" maxlength="2000"
                                          placeholder="Inspection remarks, defects, intended vehicle, or any free-text observations...">{{ $tyre->notes }}</textarea>
                            </div>
                        </div>

                    </div>
                    {{-- END LEFT COLUMN --}}

                    {{-- RIGHT COLUMN --}}
                    <div class="col-12 col-xl-4">

                        {{-- Stock Location (read-only on edit — changed via Transfer flow) --}}
                        <div class="sc-card mb-3">
                            <div class="sc-card-head">
                                <span class="sc-card-title"><i class="uil uil-map-marker me-2"></i>Stock Location</span>
                            </div>
                            <div class="p-3">
                                @php
                                    if ($tyre->warehouse_id) {
                                        $locLabel = $warehouses->find($tyre->warehouse_id)?->name ?? 'Warehouse';
                                        $locCode  = 'WH';
                                        $locClass = 'badd-loc-wh';
                                    } elseif ($tyre->workshop_id) {
                                        $locLabel = $workshops->find($tyre->workshop_id)?->name ?? 'Workshop';
                                        $locCode  = 'WS';
                                        $locClass = 'badd-loc-ws';
                                    } else {
                                        $locLabel = 'Not assigned';
                                        $locCode  = '—';
                                        $locClass = '';
                                    }
                                @endphp
                                <div class="badd-loc-group">
                                    <div class="badd-loc-option active" style="pointer-events:none; opacity:1;">
                                        <span class="badd-loc-radio" style="background:#032671;border-color:#032671;"></span>
                                        @if($locClass)
                                            <span class="badd-loc-code {{ $locClass }}">{{ $locCode }}</span>
                                        @endif
                                        <span class="badd-loc-name">{{ $locLabel }}</span>
                                    </div>
                                </div>
                                <p class="form-text text-muted mt-2">
                                    <i class="uil uil-info-circle me-1"></i>
                                    Location is managed through the Transfer / Fitment flow and cannot be changed here.
                                </p>
                            </div>
                        </div>

                        {{-- Allocation Details (read-only) --}}
                        <div class="sc-card mb-3">
                            <div class="sc-card-head">
                                <span class="sc-card-title"><i class="uil uil-truck me-2"></i>Allocation Details</span>
                            </div>
                            <div class="p-3">
                                <label class="badd-label">Current Status</label>
                                <div class="tcn-readonly-pill">
                                    <i class="uil uil-box me-1"></i>
                                    {{ $tyre->current_status ?? ($tyre->stock_status ?? 'Warehouse') }}
                                </div>

                                <label class="badd-label mt-3">Allocated Vehicle</label>
                                <input type="text" class="form-control badd-input"
                                       value="{{ $tyre->vehicle_id ? 'Vehicle #' . $tyre->vehicle_id : '—' }}"
                                       disabled readonly>
                                <div class="form-text text-muted">Managed via the Allocate flow</div>

                                @if($tyre->tyre_issue_date)
                                    <label class="badd-label mt-3">Issue Date</label>
                                    <input type="text" class="form-control badd-input"
                                           value="{{ date('d M Y', strtotime($tyre->tyre_issue_date)) }}"
                                           disabled readonly>
                                @endif
                            </div>
                        </div>

                    </div>
                    {{-- END RIGHT COLUMN --}}

                </div>

                {{-- Sticky Footer --}}
                <div class="badd-sticky-footer">
                    <div class="badd-footer-inner">
                        <a href="{{ route('tyre.dashboard') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="uil uil-times me-1"></i>Cancel
                        </a>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn sc-btn-navy btn-sm" id="tceSubmit">
                                <span id="tceSubmitText"><i class="uil uil-check me-1"></i>Update Tyre</span>
                                <span id="tceSubmitSpinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
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
<script src="{{ asset('customjs/tyre/edit.js?v=2.0') }}"></script>
@endsection
