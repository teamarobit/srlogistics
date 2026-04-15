@extends('layouts.app')

@section('css')
<link href="{{ asset('css/Inventory/battery-wizard.css?v=1.0') }}" rel="stylesheet">
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
                    <li class="breadcrumb-item active">Fit Battery to Vehicle</li>
                </ol>
            </nav>

            {{-- Page Header --}}
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="d-flex align-items-center gap-3">
                    <a href="{{ route('inventory.battery-dashboard') }}" class="bdet-back-btn">
                        <i class="uil uil-arrow-left"></i>
                    </a>
                    <div>
                        <h5 class="mb-0"><i class="uil uil-car-sideview me-2" style="color:#10863f;"></i>Fit Battery to Vehicle</h5>
                        <span class="text-muted" style="font-size:12px;">Record a battery installation on a fleet vehicle</span>
                    </div>
                </div>
            </div>

            {{-- Stepper --}}
            <div class="sc-stepper mb-4" id="batFitStepper">
                <div class="sc-step active" data-step="1">
                    <span class="sc-step-num">1</span>
                    <span class="sc-step-label">Battery Check</span>
                </div>
                <div class="sc-step-line"></div>
                <div class="sc-step" data-step="2">
                    <span class="sc-step-num">2</span>
                    <span class="sc-step-label">Select Vehicle</span>
                </div>
                <div class="sc-step-line"></div>
                <div class="sc-step" data-step="3">
                    <span class="sc-step-num">3</span>
                    <span class="sc-step-label">Fitting Details</span>
                </div>
                <div class="sc-step-line"></div>
                <div class="sc-step" data-step="4">
                    <span class="sc-step-num">4</span>
                    <span class="sc-step-label">Confirm & Log</span>
                </div>
            </div>

            {{-- ══════════════ STEP 1 — Battery Check ══════════════ --}}
            <div class="bwiz-step" id="batFitStep1">
                <div class="row g-3">
                    <div class="col-12">
                        <div class="sc-card">
                            <div class="sc-card-head">
                                <span class="sc-card-title"><i class="uil uil-bolt-alt me-2"></i>Step 1 — Battery Check</span>
                            </div>
                            <div class="p-3 p-md-4">

                                {{-- Battery Search --}}
                                <div class="row g-3 mb-3">
                                    <div class="col-12 col-md-6">
                                        <label class="form-label bwiz-label">Battery Serial / ID <span class="text-danger">*</span></label>
                                        <select class="form-select select2-battery-search" id="batFitSerialSelect" style="width:100%;">
                                            <option value="">Search battery by serial...</option>
                                            <option value="BAT-2026-00081" selected>BAT-2026-00081 — Amaron Pro Truck 150Ah</option>
                                            <option value="BAT-2025-00043">BAT-2025-00043 — Exide Drive 120Ah</option>
                                            <option value="BAT-2024-00019">BAT-2024-00019 — Amaron Pro 150Ah</option>
                                        </select>
                                        <div class="form-text text-muted">Only batteries with status: Warehouse/Reuse</div>
                                    </div>
                                </div>

                                {{-- Battery Info Card (read-only) --}}
                                <div class="bwiz-bat-card" id="batFitBatCard">
                                    <div class="bwiz-bat-header">
                                        <div class="bwiz-bat-serial">BAT-2026-00081</div>
                                        <span class="btd-st-warehouse">Warehouse</span>
                                    </div>
                                    <div class="row g-0">
                                        <div class="col-6 col-md-3">
                                            <div class="bwiz-bat-field">
                                                <span class="bwiz-bat-fl">Brand</span>
                                                <span class="bwiz-bat-fv">Amaron</span>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <div class="bwiz-bat-field">
                                                <span class="bwiz-bat-fl">Model</span>
                                                <span class="bwiz-bat-fv">Pro Truck 150</span>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <div class="bwiz-bat-field">
                                                <span class="bwiz-bat-fl">Capacity</span>
                                                <span class="bwiz-bat-fv fw-semibold">150 Ah · 12V</span>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <div class="bwiz-bat-field">
                                                <span class="bwiz-bat-fl">Condition</span>
                                                <span class="bwiz-bat-fv"><span class="btd-cond-new">New</span></span>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <div class="bwiz-bat-field">
                                                <span class="bwiz-bat-fl">Location</span>
                                                <span class="bwiz-bat-fv">WH-HYD · Shelf B-12</span>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <div class="bwiz-bat-field">
                                                <span class="bwiz-bat-fl">Purchased</span>
                                                <span class="bwiz-bat-fv">15 Feb 2024</span>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <div class="bwiz-bat-field">
                                                <span class="bwiz-bat-fl">Warranty</span>
                                                <span class="bwiz-bat-fv">36 months (exp. Feb 2027)</span>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <div class="bwiz-bat-field">
                                                <span class="bwiz-bat-fl">Type</span>
                                                <span class="bwiz-bat-fv">Lead-Acid</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Confirm condition before fit --}}
                                <div class="row g-3 mt-2">
                                    <div class="col-12 col-md-5">
                                        <label class="form-label bwiz-label">Confirm Condition Before Fit <span class="text-danger">*</span></label>
                                        <select class="form-select" id="batFitCondition">
                                            <option value="New">New</option>
                                            <option value="Used">Used</option>
                                            <option value="Weak">Weak (proceed with caution)</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label class="form-label bwiz-label">Pre-Fit Odometer Reading (KM)</label>
                                        <input type="number" class="form-control" id="batFitOdometer" placeholder="e.g. 112500">
                                    </div>
                                </div>

                                <div class="bwiz-step-nav mt-4">
                                    <div></div>
                                    <button class="btn sc-btn-navy btn-sm bwiz-next" data-step="2">
                                        Next <i class="uil uil-arrow-right ms-1"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ══════════════ STEP 2 — Select Vehicle ══════════════ --}}
            <div class="bwiz-step" id="batFitStep2" style="display:none;">
                <div class="sc-card">
                    <div class="sc-card-head">
                        <span class="sc-card-title"><i class="uil uil-truck me-2"></i>Step 2 — Select Vehicle</span>
                    </div>
                    <div class="p-3 p-md-4">

                        <div class="row g-3 mb-3">
                            <div class="col-12 col-md-6">
                                <label class="form-label bwiz-label">Vehicle Registration <span class="text-danger">*</span></label>
                                <select class="form-select select2-vehicle-fit" id="batFitVehicleSelect" style="width:100%;">
                                    <option value="">Search vehicle by reg no...</option>
                                    <option value="KA-05-AB-1234">KA-05-AB-1234</option>
                                    <option value="MH-04-CD-5678">MH-04-CD-5678</option>
                                    <option value="TN-01-EF-9012">TN-01-EF-9012</option>
                                    <option value="AP-09-GH-3456">AP-09-GH-3456</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label bwiz-label">Battery Position <span class="text-danger">*</span></label>
                                <select class="form-select" id="batFitPosition">
                                    <option value="Primary">Primary</option>
                                    <option value="Auxiliary">Auxiliary</option>
                                </select>
                            </div>
                        </div>

                        {{-- Vehicle Card --}}
                        <div class="bwiz-veh-card" id="batFitVehCard" style="display:none;">
                            <div class="bwiz-veh-header">
                                <span class="bwiz-veh-reg">KA-05-AB-1234</span>
                                <span class="bwiz-veh-model">Tata Prima 4928 LCV</span>
                            </div>
                            <div class="row g-0">
                                <div class="col-6 col-md-3">
                                    <div class="bwiz-bat-field">
                                        <span class="bwiz-bat-fl">Chassis No.</span>
                                        <span class="bwiz-bat-fv">MAT123456789</span>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="bwiz-bat-field">
                                        <span class="bwiz-bat-fl">Fleet No.</span>
                                        <span class="bwiz-bat-fv">FL-047</span>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="bwiz-bat-field">
                                        <span class="bwiz-bat-fl">Current Primary</span>
                                        <span class="bwiz-bat-fv bwiz-veh-cur-bat">BAT-2022-00019 (In Use)</span>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="bwiz-bat-field">
                                        <span class="bwiz-bat-fl">Last Service</span>
                                        <span class="bwiz-bat-fv">10 Apr 2026</span>
                                    </div>
                                </div>
                            </div>
                            <div class="bwiz-veh-alert" id="batFitVehAlert">
                                <i class="uil uil-exclamation-triangle me-2"></i>
                                This vehicle already has a battery. If you proceed, the existing battery must be removed first. Use the <strong>Battery Replacement</strong> flow instead.
                            </div>
                        </div>

                        <div class="bwiz-step-nav mt-4">
                            <button class="btn btn-outline-secondary btn-sm bwiz-back" data-step="1">
                                <i class="uil uil-arrow-left me-1"></i> Back
                            </button>
                            <button class="btn sc-btn-navy btn-sm bwiz-next" data-step="3">
                                Next <i class="uil uil-arrow-right ms-1"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ══════════════ STEP 3 — Fitting Details ══════════════ --}}
            <div class="bwiz-step" id="batFitStep3" style="display:none;">
                <div class="sc-card">
                    <div class="sc-card-head">
                        <span class="sc-card-title"><i class="uil uil-wrench me-2"></i>Step 3 — Fitting Details</span>
                    </div>
                    <div class="p-3 p-md-4">
                        <div class="row g-3">
                            <div class="col-12 col-md-4">
                                <label class="form-label bwiz-label">Fitting Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="batFitDate" value="{{ date('Y-m-d') }}">
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label bwiz-label">Fitting Time</label>
                                <input type="time" class="form-control" id="batFitTime" value="{{ date('H:i') }}">
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label bwiz-label">Technician Name <span class="text-danger">*</span></label>
                                <select class="form-select" id="batFitTech">
                                    <option value="">Select technician...</option>
                                    <option>Rajesh Kumar</option>
                                    <option>Suresh M</option>
                                    <option>Arjun S</option>
                                    <option>Murugan P</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label bwiz-label">Workshop / Location <span class="text-danger">*</span></label>
                                <select class="form-select" id="batFitWorkshop">
                                    <option value="">Select workshop...</option>
                                    <option>WS-BLR — Workshop Bangalore</option>
                                    <option>WS-HYD — Workshop Hyderabad</option>
                                    <option>WS-PNE — Workshop Pune</option>
                                    <option>Roadside / Field</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label bwiz-label">Odometer at Fitting (KM)</label>
                                <input type="number" class="form-control" id="batFitOdo2" placeholder="e.g. 112500">
                            </div>
                            <div class="col-12">
                                <label class="form-label bwiz-label">Notes / Remarks</label>
                                <textarea class="form-control" rows="3" id="batFitNotes" placeholder="Any observations during fitting, e.g. old battery condition, terminal condition..."></textarea>
                            </div>
                            <div class="col-12">
                                <label class="form-label bwiz-label">Photo / Attachment (optional)</label>
                                <div class="bwiz-upload-zone">
                                    <i class="uil uil-image-upload bwiz-upload-icon"></i>
                                    <div>Drag &amp; drop or <span class="bwiz-upload-link">browse</span></div>
                                    <div class="text-muted" style="font-size:11px;">JPG, PNG, PDF — max 5MB</div>
                                    <input type="file" class="d-none" id="batFitFile">
                                </div>
                            </div>
                        </div>
                        <div class="bwiz-step-nav mt-4">
                            <button class="btn btn-outline-secondary btn-sm bwiz-back" data-step="2">
                                <i class="uil uil-arrow-left me-1"></i> Back
                            </button>
                            <button class="btn sc-btn-navy btn-sm bwiz-next" data-step="4">
                                Next <i class="uil uil-arrow-right ms-1"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ══════════════ STEP 4 — Confirm & Log ══════════════ --}}
            <div class="bwiz-step" id="batFitStep4" style="display:none;">
                <div class="sc-card">
                    <div class="sc-card-head">
                        <span class="sc-card-title"><i class="uil uil-check-circle me-2"></i>Step 4 — Confirm & Log</span>
                    </div>
                    <div class="p-3 p-md-4">

                        {{-- Summary --}}
                        <div class="bwiz-confirm-summary">
                            <h6 class="bwiz-confirm-section-title">Battery</h6>
                            <div class="row g-2 mb-3">
                                <div class="col-6 col-md-3">
                                    <div class="bwiz-conf-field">
                                        <span class="bwiz-conf-l">Serial</span>
                                        <span class="bwiz-conf-v" id="conf-serial">BAT-2026-00081</span>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="bwiz-conf-field">
                                        <span class="bwiz-conf-l">Brand / Model</span>
                                        <span class="bwiz-conf-v" id="conf-bat-model">Amaron Pro Truck 150</span>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="bwiz-conf-field">
                                        <span class="bwiz-conf-l">Capacity</span>
                                        <span class="bwiz-conf-v" id="conf-bat-cap">150 Ah · 12V</span>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="bwiz-conf-field">
                                        <span class="bwiz-conf-l">Condition</span>
                                        <span class="bwiz-conf-v" id="conf-bat-cond">New</span>
                                    </div>
                                </div>
                            </div>
                            <h6 class="bwiz-confirm-section-title">Vehicle</h6>
                            <div class="row g-2 mb-3">
                                <div class="col-6 col-md-3">
                                    <div class="bwiz-conf-field">
                                        <span class="bwiz-conf-l">Vehicle Reg</span>
                                        <span class="bwiz-conf-v" id="conf-veh-reg">KA-05-AB-1234</span>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="bwiz-conf-field">
                                        <span class="bwiz-conf-l">Position</span>
                                        <span class="bwiz-conf-v" id="conf-position">Primary</span>
                                    </div>
                                </div>
                            </div>
                            <h6 class="bwiz-confirm-section-title">Fitting</h6>
                            <div class="row g-2">
                                <div class="col-6 col-md-3">
                                    <div class="bwiz-conf-field">
                                        <span class="bwiz-conf-l">Date</span>
                                        <span class="bwiz-conf-v" id="conf-fit-date">{{ date('d M Y') }}</span>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="bwiz-conf-field">
                                        <span class="bwiz-conf-l">Technician</span>
                                        <span class="bwiz-conf-v" id="conf-tech">—</span>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="bwiz-conf-field">
                                        <span class="bwiz-conf-l">Workshop</span>
                                        <span class="bwiz-conf-v" id="conf-workshop">—</span>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="bwiz-conf-field">
                                        <span class="bwiz-conf-l">Odometer</span>
                                        <span class="bwiz-conf-v" id="conf-odo">—</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Confirm checkbox --}}
                        <div class="bwiz-confirm-check mt-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="batFitConfirmChk">
                                <label class="form-check-label" for="batFitConfirmChk">
                                    I confirm that the above battery has been physically fitted to the vehicle and all details are accurate. This action will update battery status to <strong>Active</strong> and log the event.
                                </label>
                            </div>
                        </div>

                        <div class="bwiz-step-nav mt-4">
                            <button class="btn btn-outline-secondary btn-sm bwiz-back" data-step="3">
                                <i class="uil uil-arrow-left me-1"></i> Back
                            </button>
                            <button class="btn sc-btn-green btn-sm" id="batFitSubmitBtn" disabled>
                                <i class="uil uil-check me-1"></i> Confirm Fitting &amp; Log
                            </button>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section('js')
<script>
$(document).ready(function () {

    // Select2 inits
    $('.select2-battery-search').select2({ width: '100%', placeholder: 'Search battery...' });
    $('.select2-vehicle-fit').select2({ width: '100%', placeholder: 'Search vehicle...' });

    // Stepper update
    function updateBatFitStepper(n) {
        $('#batFitStepper .sc-step').each(function () {
            var s = parseInt($(this).data('step'));
            $(this).removeClass('active done');
            if (s < n) $(this).addClass('done');
            if (s === n) $(this).addClass('active');
        });
        $('#batFitStepper .sc-step-line').each(function (i) {
            $(this).removeClass('done');
            if (i < n - 1) $(this).addClass('done');
        });
    }

    // Next step
    $('.bwiz-next').on('click', function () {
        var nextStep = parseInt($(this).data('step'));
        $('.bwiz-step').hide();
        $('#batFitStep' + nextStep).show();
        updateBatFitStepper(nextStep);
        if (nextStep === 4) batFitPopulateConfirm();
    });

    // Back step
    $('.bwiz-back').on('click', function () {
        var backStep = parseInt($(this).data('step'));
        $('.bwiz-step').hide();
        $('#batFitStep' + backStep).show();
        updateBatFitStepper(backStep);
    });

    // Show vehicle card on selection
    $('#batFitVehicleSelect').on('change', function () {
        if ($(this).val()) {
            $('#batFitVehCard').show();
        } else {
            $('#batFitVehCard').hide();
        }
    });

    // Upload zone click
    $('.bwiz-upload-zone').on('click', function () { $('#batFitFile').click(); });

    // Confirm checkbox enables submit
    $('#batFitConfirmChk').on('change', function () {
        $('#batFitSubmitBtn').prop('disabled', !$(this).is(':checked'));
    });

    // Populate confirm step
    function batFitPopulateConfirm() {
        $('#conf-serial').text($('#batFitSerialSelect').val() || 'BAT-2026-00081');
        $('#conf-bat-cond').text($('#batFitCondition').val() || '—');
        $('#conf-veh-reg').text($('#batFitVehicleSelect').val() || '—');
        $('#conf-position').text($('#batFitPosition').val() || '—');
        var dateVal = $('#batFitDate').val();
        $('#conf-fit-date').text(dateVal || '—');
        $('#conf-tech').text($('#batFitTech').val() || '—');
        $('#conf-workshop').text($('#batFitWorkshop').val() || '—');
        var odo = $('#batFitOdo2').val() || $('#batFitOdometer').val();
        $('#conf-odo').text(odo ? odo + ' KM' : '—');
    }

    // Submit (frontend only — no AJAX)
    $('#batFitSubmitBtn').on('click', function () {
        var $btn = $(this);
        $btn.prop('disabled', true).html('<i class="uil uil-spinner-alt spin me-1"></i>Logging...');
        setTimeout(function () {
            $btn.html('<i class="uil uil-check me-1"></i>Logged!').addClass('btn-success').removeClass('sc-btn-green');
            toastr.success('Battery fitting logged successfully.');
            setTimeout(function () {
                window.location.href = '{{ route("inventory.battery-dashboard") }}';
            }, 1200);
        }, 900);
    });

});
</script>
@endsection
