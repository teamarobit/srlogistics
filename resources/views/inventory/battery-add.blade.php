@extends('layouts.app')

@section('css')
<link href="{{ asset('css/Inventory/battery-add.css?v=1.1') }}" rel="stylesheet">
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
                    <a href="{{ route('inventory.battery-dashboard') }}" class="bdet-back-btn">
                        <i class="uil uil-arrow-left"></i>
                    </a>
                    <div>
                        <h5 class="mb-0"><i class="uil uil-plus-circle me-2" style="color:#032671;"></i>Add Battery to Inventory</h5>
                        <span class="text-muted" style="font-size:12px;">Record a newly purchased or received battery unit into stock</span>
                    </div>
                </div>
            </div>

            {{-- ── Battery Source Toggle ── --}}
            <div class="badd-source-toggle-wrap mb-4">

                {{-- Two-option selector --}}
                <div class="badd-source-toggle" id="batSourceToggle">
                    <label class="badd-source-option active" for="srcExisting">
                        <input type="radio" name="batterySource" id="srcExisting" value="existing" class="d-none" checked>
                        <div class="d-flex align-items-center gap-3">
                            <div class="badd-src-icon badd-src-icon-existing">
                                <i class="uil uil-box"></i>
                            </div>
                            <div>
                                <div class="badd-source-label">Existing Battery</div>
                                <div class="badd-source-desc">Not ordered via system — manual entry with note &amp; bill</div>
                            </div>
                            <span class="badd-source-radio ms-auto flex-shrink-0"></span>
                        </div>
                    </label>
                    <label class="badd-source-option" for="srcNewPO">
                        <input type="radio" name="batterySource" id="srcNewPO" value="new" class="d-none">
                        <div class="d-flex align-items-center gap-3">
                            <div class="badd-src-icon badd-src-icon-new">
                                <i class="uil uil-receipt-alt"></i>
                            </div>
                            <div>
                                <div class="badd-source-label">New Battery (from PO / GRN)</div>
                                <div class="badd-source-desc">Received via system PO or GRN — search &amp; auto-fill</div>
                            </div>
                            <span class="badd-source-radio ms-auto flex-shrink-0"></span>
                        </div>
                    </label>
                </div>

                {{-- Mode: Existing Battery —— note + bill only --}}
                <div class="badd-mode-section active" id="modeExisting">
                    <div class="sc-card mb-0">
                        <div class="sc-card-head">
                            <span class="sc-card-title"><i class="uil uil-notes me-2"></i>Source Information</span>
                        </div>
                        <div class="p-3">
                            <div class="row g-3">
                                <div class="col-12 col-md-8">
                                    <label class="badd-label" for="existingSourceNote">Source / Origin Note <span class="text-danger">*</span></label>
                                    <textarea class="form-control badd-input" id="existingSourceNote" rows="2"
                                        placeholder="e.g. Received from Amaron dealer outside system, repurposed from retired vehicle, transferred from another depot..."></textarea>
                                </div>
                                <div class="col-12 col-md-4">
                                    <label class="badd-label">Invoice / Bill (optional)</label>
                                    <div class="badd-file-zone" id="existingFileZone">
                                        <input type="file" id="existingInvoiceFile" class="d-none" accept=".pdf,.jpg,.jpeg,.png">
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
                <div class="badd-mode-section" id="modeNewPO">
                    <div class="sc-card mb-0">
                        <div class="sc-card-head">
                            <span class="sc-card-title"><i class="uil uil-receipt-alt me-2"></i>Select PO / GRN</span>
                        </div>
                        <div class="p-3">
                            <div class="row g-3">
                                <div class="col-12 col-md-7">
                                    <label class="badd-label" for="poGrnSelect">PO / GRN Reference <span class="text-danger">*</span></label>
                                    <select class="form-select select2-po-grn badd-input" id="poGrnSelect" style="width:100%;">
                                        <option value="">Search PO or GRN number...</option>
                                        <option value="PO-2026-00041">PO-2026-00041 — Amaron (50 units · 12 available)</option>
                                        <option value="GRN-2026-01003">GRN-2026-01003 — Exide (25 received · 25 available)</option>
                                        <option value="PO-2026-00038">PO-2026-00038 — Luminous (100 units · 78 available)</option>
                                        <option value="GRN-2026-01001">GRN-2026-01001 — Su-Kam (15 received · 15 available)</option>
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

            <form id="batAddForm" novalidate>
                <div class="row g-4">

                    {{-- LEFT COLUMN — Main Form --}}
                    <div class="col-12 col-xl-8">

                        {{-- Battery Identity --}}
                        <div class="sc-card mb-3">
                            <div class="sc-card-head">
                                <span class="sc-card-title"><i class="uil uil-tag-alt me-2"></i>Battery Identity</span>
                            </div>
                            <div class="p-3 p-md-4">
                                <div class="row g-3">
                                    <div class="col-12 col-md-6">
                                        <label class="badd-label" for="batBrand">Brand / Make <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control badd-input" id="batBrand" placeholder="e.g. Amaron, Exide, Luminous" maxlength="100" required>
                                        <div class="invalid-feedback">Brand is required</div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="badd-label" for="batModel">Model</label>
                                        <input type="text" class="form-control badd-input" id="batModel" placeholder="e.g. Pro Truck 150, Matrix 180" maxlength="100">
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="badd-label" for="batSerial">Serial Number <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control badd-input" id="batSerial" placeholder="e.g. BAT-2026-00095" maxlength="100" required>
                                        <div class="invalid-feedback">Serial number is required</div>
                                        <div class="form-text text-muted">Must be unique. Use format: BAT-YYYY-NNNNN</div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="badd-label" for="batType">Battery Type <span class="text-danger">*</span></label>
                                        <select class="form-select badd-input" id="batType" required>
                                            <option value="">Select type...</option>
                                            <option value="Lead Acid">Lead Acid</option>
                                            <option value="Lithium-ion">Lithium-ion</option>
                                            <option value="AGM">AGM (Absorbent Glass Mat)</option>
                                            <option value="VRLA">VRLA (Sealed)</option>
                                        </select>
                                        <div class="invalid-feedback">Type is required</div>
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
                                    <div class="col-12 col-md-4">
                                        <label class="badd-label" for="batCapacity">Capacity (Ah) <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="number" class="form-control badd-input" id="batCapacity" placeholder="e.g. 150" min="1" max="9999" required>
                                            <span class="input-group-text badd-unit">Ah</span>
                                        </div>
                                        <div class="invalid-feedback">Capacity is required</div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label class="badd-label" for="batVoltage">Voltage <span class="text-danger">*</span></label>
                                        <select class="form-select badd-input" id="batVoltage" required>
                                            <option value="">Select voltage...</option>
                                            <option value="12V">12V</option>
                                            <option value="24V">24V</option>
                                            <option value="48V">48V</option>
                                            <option value="6V">6V</option>
                                        </select>
                                        <div class="invalid-feedback">Voltage is required</div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label class="badd-label" for="batCCA">Cold Cranking Amps (CCA)</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control badd-input" id="batCCA" placeholder="e.g. 900" min="0">
                                            <span class="input-group-text badd-unit">CCA</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label class="badd-label" for="batLifeMonths">Expected Life (Months)</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control badd-input" id="batLifeMonths" placeholder="e.g. 60" min="1" max="120">
                                            <span class="input-group-text badd-unit">mo.</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label class="badd-label" for="batPosition">Intended Position</label>
                                        <select class="form-select badd-input" id="batPosition">
                                            <option value="">Not specified</option>
                                            <option value="Primary">Primary</option>
                                            <option value="Auxiliary">Auxiliary</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Purchase & Warranty --}}
                        <div class="sc-card mb-3">
                            <div class="sc-card-head">
                                <span class="sc-card-title"><i class="uil uil-receipt me-2"></i>Purchase & Warranty</span>
                            </div>
                            <div class="p-3 p-md-4">
                                <div class="row g-3">
                                    <div class="col-12 col-md-4">
                                        <label class="badd-label" for="batPurchaseDate">Purchase Date</label>
                                        <input type="date" class="form-control badd-input" id="batPurchaseDate">
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label class="badd-label" for="batWarrantyMonths">Warranty (Months)</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control badd-input" id="batWarrantyMonths" placeholder="e.g. 36" min="0" max="120">
                                            <span class="input-group-text badd-unit">mo.</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label class="badd-label" for="batPrice">Purchase Cost (₹)</label>
                                        <div class="input-group">
                                            <span class="input-group-text badd-unit">₹</span>
                                            <input type="number" class="form-control badd-input" id="batPrice" placeholder="0.00" min="0" step="0.01">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="badd-label" for="batInvoice">Invoice / PO Reference</label>
                                        <input type="text" class="form-control badd-input" id="batInvoice" placeholder="e.g. AMR-INV-0298734 or PO-2026-00041">
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="badd-label" for="batWarrantyExpiry">Warranty Expiry Date</label>
                                        <input type="date" class="form-control badd-input" id="batWarrantyExpiry" readonly>
                                        <div class="form-text text-muted">Auto-calculated from Purchase Date + Warranty Months</div>
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
                                <textarea class="form-control badd-input" id="batNotes" rows="3" placeholder="Any notes about this battery — inspection results, source, intended vehicle, etc."></textarea>
                            </div>
                        </div>

                    </div>

                    {{-- RIGHT COLUMN — Placement & Vendor --}}
                    <div class="col-12 col-xl-4">

                        {{-- Stock Location --}}
                        <div class="sc-card mb-3">
                            <div class="sc-card-head">
                                <span class="sc-card-title"><i class="uil uil-map-marker me-2"></i>Stock Location <span class="text-danger">*</span></span>
                            </div>
                            <div class="p-3">
                                <p class="badd-loc-hint">Where is this battery being stored?</p>
                                <div class="badd-loc-group" id="batLocGroup">
                                    <label class="badd-loc-option active" for="locAll">
                                        <input type="radio" name="batLocation" id="locAll" value="" class="d-none" checked>
                                        <span class="badd-loc-radio"></span>
                                        <span class="badd-loc-name">Not assigned yet</span>
                                    </label>
                                    <div class="badd-loc-section-label">Warehouses</div>
                                    <label class="badd-loc-option" for="locWhBLR">
                                        <input type="radio" name="batLocation" id="locWhBLR" value="WH-BLR" class="d-none">
                                        <span class="badd-loc-radio"></span>
                                        <span class="badd-loc-code badd-loc-wh">WH</span>
                                        <span class="badd-loc-name">Bangalore Warehouse</span>
                                    </label>
                                    <label class="badd-loc-option" for="locWhHYD">
                                        <input type="radio" name="batLocation" id="locWhHYD" value="WH-HYD" class="d-none">
                                        <span class="badd-loc-radio"></span>
                                        <span class="badd-loc-code badd-loc-wh">WH</span>
                                        <span class="badd-loc-name">Hyderabad Warehouse</span>
                                    </label>
                                    <label class="badd-loc-option" for="locWhPNE">
                                        <input type="radio" name="batLocation" id="locWhPNE" value="WH-PNE" class="d-none">
                                        <span class="badd-loc-radio"></span>
                                        <span class="badd-loc-code badd-loc-wh">WH</span>
                                        <span class="badd-loc-name">Pune Warehouse</span>
                                    </label>
                                    <div class="badd-loc-section-label">Workshops</div>
                                    <label class="badd-loc-option" for="locWsBLR">
                                        <input type="radio" name="batLocation" id="locWsBLR" value="WS-BLR" class="d-none">
                                        <span class="badd-loc-radio"></span>
                                        <span class="badd-loc-code badd-loc-ws">WS</span>
                                        <span class="badd-loc-name">Bangalore Workshop</span>
                                    </label>
                                    <label class="badd-loc-option" for="locWsHYD">
                                        <input type="radio" name="batLocation" id="locWsHYD" value="WS-HYD" class="d-none">
                                        <span class="badd-loc-radio"></span>
                                        <span class="badd-loc-code badd-loc-ws">WS</span>
                                        <span class="badd-loc-name">Hyderabad Workshop</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        {{-- Vendor --}}
                        <div class="sc-card mb-3">
                            <div class="sc-card-head">
                                <span class="sc-card-title"><i class="uil uil-store me-2"></i>Vendor</span>
                            </div>
                            <div class="p-3">
                                <label class="badd-label" for="batVendor">Battery Vendor</label>
                                <select class="form-select select2-bat-vendor badd-input" id="batVendor" style="width:100%;">
                                    <option value="">Select vendor (optional)...</option>
                                    <option value="1">Amaron Battery Pvt. Ltd.</option>
                                    <option value="2">Exide Industries Ltd.</option>
                                    <option value="3">Luminous Power Technologies</option>
                                    <option value="4">Su-Kam Power Systems</option>
                                </select>
                                <div class="mt-2">
                                    <a href="{{ route('contact.batteryvendor.create') }}" class="badd-add-link" target="_blank">
                                        <i class="uil uil-plus me-1"></i>Add New Vendor
                                    </a>
                                </div>
                            </div>
                        </div>

                        {{-- Initial Condition --}}
                        <div class="sc-card mb-3">
                            <div class="sc-card-head">
                                <span class="sc-card-title"><i class="uil uil-check-circle me-2"></i>Initial Condition</span>
                            </div>
                            <div class="p-3">
                                <div class="badd-cond-group" id="batCondGroup">
                                    <label class="badd-cond-opt active" for="condNew">
                                        <input type="radio" name="batCondition" id="condNew" value="New" class="d-none" checked>
                                        <span class="btd-cond-new">New</span>
                                        <span class="badd-cond-desc">Fresh from supplier, unused</span>
                                    </label>
                                    <label class="badd-cond-opt" for="condUsed">
                                        <input type="radio" name="batCondition" id="condUsed" value="Used" class="d-none">
                                        <span class="btd-cond-used">Used</span>
                                        <span class="badd-cond-desc">Previously used, still functional</span>
                                    </label>
                                    <label class="badd-cond-opt" for="condWeak">
                                        <input type="radio" name="batCondition" id="condWeak" value="Weak" class="d-none">
                                        <span class="btd-cond-weak">Weak</span>
                                        <span class="badd-cond-desc">Below capacity, needs monitoring</span>
                                    </label>
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
                            <button type="button" class="btn btn-outline-secondary btn-sm" id="batAddSaveAnother">
                                <i class="uil uil-redo me-1"></i>Save &amp; Add Another
                            </button>
                            <button type="submit" class="btn sc-btn-navy btn-sm" id="batAddSubmit">
                                <i class="uil uil-check me-1"></i>Add to Inventory
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
<script>
$(document).ready(function () {

    // ── Source toggle ────────────────────────────────────────
    $('#batSourceToggle').on('click', '.badd-source-option', function () {
        $('.badd-source-option').removeClass('active');
        $(this).addClass('active');
        var mode = $(this).find('input[type="radio"]').val();
        $(this).find('input[type="radio"]').prop('checked', true);
        if (mode === 'existing') {
            $('#modeExisting').addClass('active');
            $('#modeNewPO').removeClass('active');
            $('#existingSourceNote').prop('required', true);
            $('#poGrnSelect').prop('required', false);
        } else {
            $('#modeNewPO').addClass('active');
            $('#modeExisting').removeClass('active');
            $('#poGrnSelect').prop('required', true);
            $('#existingSourceNote').prop('required', false);
        }
        $('#existingSourceNote, #poGrnSelect').removeClass('is-invalid');
    });

    // File zone click
    $('#existingFileZone').on('click', function () { $('#existingInvoiceFile').click(); });
    $('#existingInvoiceFile').on('change', function () {
        if (this.files && this.files[0]) {
            $('#existingFileZone .badd-file-text').text(this.files[0].name);
            $('#existingFileZone').css('border-color', '#10863f');
        }
    });

    // Select2 PO/GRN
    $('.select2-po-grn').select2({ width: '100%', placeholder: 'Search PO or GRN...' });

    // Select2 vendor
    $('.select2-bat-vendor').select2({
        width: '100%',
        placeholder: 'Select vendor...'
    });

    // Location radio toggle (styled labels)
    $('#batLocGroup').on('click', '.badd-loc-option', function () {
        $('#batLocGroup .badd-loc-option').removeClass('active');
        $(this).addClass('active');
        $(this).find('input[type="radio"]').prop('checked', true);
    });

    // Condition toggle
    $('#batCondGroup').on('click', '.badd-cond-opt', function () {
        $('#batCondGroup .badd-cond-opt').removeClass('active');
        $(this).addClass('active');
        $(this).find('input[type="radio"]').prop('checked', true);
    });

    // Auto-calculate warranty expiry
    function calcWarrantyExpiry() {
        var pd = $('#batPurchaseDate').val();
        var wm = parseInt($('#batWarrantyMonths').val());
        if (pd && wm > 0) {
            var d = new Date(pd);
            d.setMonth(d.getMonth() + wm);
            var y = d.getFullYear();
            var mo = String(d.getMonth() + 1).padStart(2,'0');
            var dy = String(d.getDate()).padStart(2,'0');
            $('#batWarrantyExpiry').val(y + '-' + mo + '-' + dy);
        } else {
            $('#batWarrantyExpiry').val('');
        }
    }
    $('#batPurchaseDate, #batWarrantyMonths').on('change input', calcWarrantyExpiry);

    // Form validation + submit (frontend only)
    $('#batAddForm').on('submit', function (e) {
        e.preventDefault();
        var valid = true;
        $(this).find('[required]').each(function () {
            if (!$(this).val()) {
                $(this).addClass('is-invalid');
                valid = false;
            } else {
                $(this).removeClass('is-invalid');
            }
        });
        if (!valid) {
            toastr.warning('Please fill in all required fields.');
            return;
        }
        batAddSubmit(false);
    });

    $('#batAddSaveAnother').on('click', function () {
        var valid = true;
        $('#batAddForm [required]').each(function () {
            if (!$(this).val()) {
                $(this).addClass('is-invalid');
                valid = false;
            } else {
                $(this).removeClass('is-invalid');
            }
        });
        if (!valid) {
            toastr.warning('Please fill in all required fields.');
            return;
        }
        batAddSubmit(true);
    });

    function batAddSubmit(addAnother) {
        var $btn = addAnother ? $('#batAddSaveAnother') : $('#batAddSubmit');
        $btn.prop('disabled', true).html('<i class="uil uil-spinner-alt spin me-1"></i>Saving...');
        setTimeout(function () {
            toastr.success('Battery added to inventory successfully.');
            if (addAnother) {
                $btn.prop('disabled', false).html('<i class="uil uil-redo me-1"></i>Save & Add Another');
                $('#batAddForm')[0].reset();
                $('#batLocGroup .badd-loc-option').removeClass('active');
                $('#batLocGroup .badd-loc-option:first').addClass('active');
                $('#batCondGroup .badd-cond-opt').removeClass('active');
                $('#batCondGroup .badd-cond-opt:first').addClass('active');
                $('.select2-bat-vendor').val('').trigger('change');
            } else {
                window.location.href = '{{ route("inventory.battery-dashboard") }}';
            }
        }, 800);
    }

    // Clear invalid on change
    $('#batAddForm').on('change input', '[required]', function () {
        if ($(this).val()) $(this).removeClass('is-invalid');
    });

});
</script>
@endsection
