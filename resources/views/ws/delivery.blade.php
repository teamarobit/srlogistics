@extends('layouts.app')

@section('css')
<link href="{{ asset('css/Workshop/delivery.css?v=1.0') }}" rel="stylesheet">
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
                    <li class="breadcrumb-item"><a href="{{ route('ws.dashboard') }}">Workshop</a></li>
                    <li class="breadcrumb-item active">Vehicle Delivery</li>
                </ol>
            </nav>

            {{-- Page Header --}}
            <div class="sc-page-head d-flex align-items-center justify-content-between mb-3">
                <div>
                    <h5 class="mb-0">Vehicle Delivery</h5>
                    <span class="text-muted" style="font-size:12px;">Issue out-tokens and complete vehicle handover</span>
                </div>
                <button class="btn sc-btn-navy btn-sm" data-bs-toggle="modal" data-bs-target="#outTokenModal">
                    <i class="uil uil-plus me-1"></i> New Out-Token
                </button>
            </div>

            {{-- Ready for Delivery List --}}
            <div class="row g-3 mb-3">
                <div class="col-lg-3 col-md-6">
                    <div class="sc-stat-card sc-stat-green">
                        <div class="sc-stat-icon"><i class="uil uil-check-circle"></i></div>
                        <div class="sc-stat-body"><div class="sc-stat-val">5</div><div class="sc-stat-label">Ready for Delivery</div></div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="sc-stat-card sc-stat-navy">
                        <div class="sc-stat-icon"><i class="uil uil-car"></i></div>
                        <div class="sc-stat-body"><div class="sc-stat-val">2</div><div class="sc-stat-label">Delivered Today</div></div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="sc-stat-card sc-stat-amber">
                        <div class="sc-stat-icon"><i class="uil uil-clock"></i></div>
                        <div class="sc-stat-body"><div class="sc-stat-val">3</div><div class="sc-stat-label">Awaiting Customer</div></div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="sc-stat-card sc-stat-grey">
                        <div class="sc-stat-icon"><i class="uil uil-receipt-alt"></i></div>
                        <div class="sc-stat-body"><div class="sc-stat-val">₹ 41,800</div><div class="sc-stat-label">Collected on Delivery</div></div>
                    </div>
                </div>
            </div>

            {{-- Delivery Queue --}}
            <div class="sc-table-card">
                <div class="sc-table-head d-flex align-items-center justify-content-between px-3 py-2 border-bottom">
                    <span class="fw-semibold" style="font-size:13px;">Ready for Delivery</span>
                    <div class="d-flex gap-2">
                        <input type="text" class="form-control form-control-sm" placeholder="Search vehicle or JC#..." style="width:220px;">
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table sc-table mb-0">
                        <thead>
                            <tr>
                                <th>JC Number</th>
                                <th>Vehicle</th>
                                <th>Completed At</th>
                                <th>KM In</th>
                                <th class="text-end">Invoice Amount (₹)</th>
                                <th>Invoice Status</th>
                                <th>Out-Token</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><a href="{{ route('ws.workshop.job-details', 5) }}" class="sc-jc-link">JC-2026-0044</a></td>
                                <td><div class="sc-veh-cell"><span class="sc-reg-badge">RJ-14-GA-1111</span><span class="sc-veh-model">Eicher Pro 3015</span></div></td>
                                <td class="text-nowrap">10-Apr-2026 14:30</td>
                                <td>98,450 KM</td>
                                <td class="text-end fw-bold">₹ 6,903</td>
                                <td><span class="badge sc-bill-generated">Generated</span></td>
                                <td><span class="text-muted fst-italic">Not issued</span></td>
                                <td class="text-center">
                                    <button class="btn sc-btn-navy btn-sm" data-bs-toggle="modal" data-bs-target="#outTokenModal">
                                        <i class="uil uil-file-plus-alt me-1"></i> Issue Token
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td><a href="{{ route('ws.workshop.job-details', 4) }}" class="sc-jc-link">JC-2026-0045</a></td>
                                <td><div class="sc-veh-cell"><span class="sc-reg-badge">GJ-03-ZZ-7890</span><span class="sc-veh-model">Tata 407 LPT</span></div></td>
                                <td class="text-nowrap">11-Apr-2026 09:45</td>
                                <td>52,100 KM</td>
                                <td class="text-end fw-bold">₹ 3,280</td>
                                <td><span class="badge sc-bill-draft">Draft</span></td>
                                <td><span class="text-muted fst-italic">Not issued</span></td>
                                <td class="text-center">
                                    <button class="btn sc-btn-navy btn-sm" disabled>
                                        <i class="uil uil-lock me-1"></i> Bill First
                                    </button>
                                </td>
                            </tr>
                            <tr class="sc-row-delivered">
                                <td><a href="{{ route('ws.workshop.job-details', 6) }}" class="sc-jc-link">JC-2026-0043</a></td>
                                <td><div class="sc-veh-cell"><span class="sc-reg-badge">UP-32-BT-5544</span><span class="sc-veh-model">Volvo FH 400</span></div></td>
                                <td class="text-nowrap">08-Apr-2026 16:00</td>
                                <td>2,10,300 KM</td>
                                <td class="text-end fw-bold">₹ 20,904</td>
                                <td><span class="badge sc-bill-paid">Paid</span></td>
                                <td><span class="badge sc-out-token-issued">OT-2026-0012</span></td>
                                <td class="text-center">
                                    <div class="sc-row-actions">
                                        <button class="sc-action-btn" title="View Out-Token"><i class="uil uil-eye"></i></button>
                                        <button class="sc-action-btn" title="Print Token"><i class="uil uil-print"></i></button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>{{-- /.main-wrap --}}
    </div>{{-- /.wrapper --}}

</div>{{-- /.layout-wrapper --}}

{{-- Out-Token Wizard Modal --}}
<div class="modal fade" id="outTokenModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title"><i class="uil uil-file-plus-alt me-2 text-navy"></i>Issue Out-Token</h6>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">

                {{-- Stepper --}}
                <div class="sc-stepper mb-4" id="otStepper">
                    <div class="sc-step sc-step-active" data-step="1">
                        <div class="sc-step-num" id="sn1">1</div>
                        <div class="sc-step-label">Vehicle & JC</div>
                    </div>
                    <div class="sc-step-line" id="sl1"></div>
                    <div class="sc-step" data-step="2">
                        <div class="sc-step-num" id="sn2">2</div>
                        <div class="sc-step-label">Out Inspection</div>
                    </div>
                    <div class="sc-step-line" id="sl2"></div>
                    <div class="sc-step" data-step="3">
                        <div class="sc-step-num" id="sn3">3</div>
                        <div class="sc-step-label">KM & Receiver</div>
                    </div>
                    <div class="sc-step-line" id="sl3"></div>
                    <div class="sc-step" data-step="4">
                        <div class="sc-step-num" id="sn4">4</div>
                        <div class="sc-step-label">Acknowledge</div>
                    </div>
                </div>

                {{-- ── STEP 1: Vehicle & JC ── --}}
                <div class="ot-panel" id="ot-step-1">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="sc-form-label">Job Card <span class="text-danger">*</span></label>
                            <select class="form-select form-select-sm select2-jc-ot" id="otJcSelect">
                                <option value="">— Select Job Card —</option>
                                <option value="1" data-vehicle="RJ-14-GA-1111" data-model="Eicher Pro 3015" data-inv="₹ 6,903" data-status="Generated" data-km="98,450">JC-2026-0044 — RJ-14-GA-1111 (Eicher Pro 3015) — ₹ 6,903</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="sc-form-label">Vehicle Reg</label>
                            <input type="text" class="form-control form-control-sm bg-light" id="otVehicle" readonly placeholder="Auto-filled">
                        </div>
                        <div class="col-md-4">
                            <label class="sc-form-label">Invoice Amount</label>
                            <input type="text" class="form-control form-control-sm bg-light" id="otInvAmt" readonly placeholder="Auto-filled">
                        </div>
                        <div class="col-md-4">
                            <label class="sc-form-label">Invoice Status</label>
                            <input type="text" class="form-control form-control-sm bg-light" id="otInvStatus" readonly placeholder="Auto-filled">
                        </div>
                        <div class="col-12">
                            <div class="alert alert-info py-2 mb-0" style="font-size:12px;">
                                <i class="uil uil-info-circle me-1"></i> Only job cards with invoice status <strong>Generated</strong> or <strong>Paid</strong> can be issued an out-token.
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ── STEP 2: Out Inspection ── --}}
                <div class="ot-panel d-none" id="ot-step-2">
                    <p class="text-muted mb-3" style="font-size:12px;">Verify the vehicle's condition before handover. Mark each item as OK, Damaged, or N/A.</p>
                    <div class="table-responsive">
                        <table class="table table-sm sc-insp-table mb-3">
                            <thead>
                                <tr>
                                    <th style="width:35%;">Item</th>
                                    <th style="width:35%;">Condition</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $inspItems = [
                                    'Body & Paint', 'Windscreen', 'Wipers', 'Head Lights',
                                    'Tail Lights', 'Tyres (All)', 'Spare Tyre', 'Fuel Level',
                                    'Tools / Jack', 'Interior / Cabin', 'Documents in Vehicle'
                                ];
                                @endphp
                                @foreach($inspItems as $i => $item)
                                <tr>
                                    <td>{{ $item }}</td>
                                    <td>
                                        <div class="sc-insp-toggles">
                                            <button type="button" class="sc-insp-btn active-ok insp-toggle" data-state="ok" data-row="{{ $i }}">OK</button>
                                            <button type="button" class="sc-insp-btn insp-toggle" data-state="dmg" data-row="{{ $i }}">Damage</button>
                                            <button type="button" class="sc-insp-btn insp-toggle" data-state="na" data-row="{{ $i }}">N/A</button>
                                        </div>
                                    </td>
                                    <td><input type="text" class="form-control form-control-sm" placeholder="Optional remarks"></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <label class="sc-form-label">Overall Out-Inspection Notes</label>
                        <textarea class="form-control form-control-sm" rows="2" placeholder="Any general observations before handover..."></textarea>
                    </div>
                </div>

                {{-- ── STEP 3: KM & Receiver ── --}}
                <div class="ot-panel d-none" id="ot-step-3">
                    <div class="row g-3">
                        <div class="col-12"><h6 class="sc-section-title mb-0">Odometer Reading</h6></div>
                        <div class="col-md-4">
                            <label class="sc-form-label">KM In (at arrival)</label>
                            <input type="text" class="form-control form-control-sm bg-light" id="otKmIn" readonly value="98,450 KM">
                        </div>
                        <div class="col-md-4">
                            <label class="sc-form-label">KM Out (now) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control form-control-sm" id="otKmOut" placeholder="e.g. 98,460" min="0">
                        </div>
                        <div class="col-md-4">
                            <label class="sc-form-label">KM During Service</label>
                            <input type="text" class="form-control form-control-sm bg-light" id="otKmDiff" readonly placeholder="Auto-calculated">
                        </div>

                        <div class="col-12 mt-2"><h6 class="sc-section-title mb-0">Received By</h6></div>
                        <div class="col-md-4">
                            <label class="sc-form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" placeholder="Name of person collecting vehicle">
                        </div>
                        <div class="col-md-4">
                            <label class="sc-form-label">Phone Number</label>
                            <input type="tel" class="form-control form-control-sm" placeholder="10-digit mobile">
                        </div>
                        <div class="col-md-4">
                            <label class="sc-form-label">Relation to Vehicle</label>
                            <select class="form-select form-select-sm">
                                <option value="">— Select —</option>
                                <option>Owner</option>
                                <option>Driver</option>
                                <option>Authorised Representative</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="sc-form-label">ID Proof Type</label>
                            <select class="form-select form-select-sm">
                                <option value="">— Select —</option>
                                <option>Aadhaar</option>
                                <option>PAN</option>
                                <option>Driving Licence</option>
                                <option>Passport</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="sc-form-label">ID Number</label>
                            <input type="text" class="form-control form-control-sm" placeholder="ID document number">
                        </div>
                        <div class="col-md-4">
                            <label class="sc-form-label">Handover Date & Time</label>
                            <input type="datetime-local" class="form-control form-control-sm" id="otHandoverDt">
                        </div>
                    </div>
                </div>

                {{-- ── STEP 4: Acknowledge ── --}}
                <div class="ot-panel d-none" id="ot-step-4">
                    <h6 class="sc-section-title mb-3">Summary</h6>
                    <div class="sc-ot-summary mb-4">
                        <div class="sc-ot-summary-row">
                            <span class="sc-ot-summary-label">Job Card</span>
                            <span class="sc-ot-summary-val" id="sumJc">JC-2026-0044</span>
                        </div>
                        <div class="sc-ot-summary-row">
                            <span class="sc-ot-summary-label">Vehicle</span>
                            <span class="sc-ot-summary-val" id="sumVehicle">RJ-14-GA-1111 — Eicher Pro 3015</span>
                        </div>
                        <div class="sc-ot-summary-row">
                            <span class="sc-ot-summary-label">Invoice Amount</span>
                            <span class="sc-ot-summary-val" id="sumInv">₹ 6,903</span>
                        </div>
                        <div class="sc-ot-summary-row">
                            <span class="sc-ot-summary-label">KM In → KM Out</span>
                            <span class="sc-ot-summary-val" id="sumKm">98,450 → <span id="sumKmOut">—</span></span>
                        </div>
                        <div class="sc-ot-summary-row">
                            <span class="sc-ot-summary-label">Out-Inspection</span>
                            <span class="sc-ot-summary-val text-success"><i class="uil uil-check-circle me-1"></i>Completed</span>
                        </div>
                        <div class="sc-ot-summary-row">
                            <span class="sc-ot-summary-label">Handover Date & Time</span>
                            <span class="sc-ot-summary-val" id="sumHandover">—</span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="ackInspection">
                            <label class="form-check-label" for="ackInspection" style="font-size:13px;">
                                I confirm the vehicle has been physically inspected and the out-inspection checklist is complete.
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="ackPayment">
                            <label class="form-check-label" for="ackPayment" style="font-size:13px;">
                                Invoice payment has been settled / confirmed by the receiver.
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="ackHandover">
                            <label class="form-check-label" for="ackHandover" style="font-size:13px;">
                                The vehicle keys and documents have been handed over to the receiver.
                            </label>
                        </div>
                    </div>

                    <div class="alert alert-warning py-2 mb-0" style="font-size:12px;" id="ackWarning" style="display:none;">
                        <i class="uil uil-exclamation-triangle me-1"></i> Please tick all acknowledgement checkboxes before issuing the token.
                    </div>
                </div>

            </div>{{-- /.modal-body --}}

            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-outline-secondary btn-sm" id="otPrev" disabled>← Previous</button>
                    <button type="button" class="btn sc-btn-navy btn-sm" id="otNext">Next →</button>
                    <button type="button" class="sc-btn-issue-token d-none" id="otIssue">
                        <i class="uil uil-check-circle me-1"></i> Issue Out-Token
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
$(function() {

    /* ── Select2 init ── */
    $('.select2-jc-ot').select2({ width: '100%', dropdownParent: $('#outTokenModal') });

    /* ── Auto-fill step 1 fields from selected JC ── */
    $('#otJcSelect').on('change', function() {
        var opt = $(this).find(':selected');
        $('#otVehicle').val(opt.data('vehicle') || '');
        $('#otInvAmt').val(opt.data('inv') || '');
        $('#otInvStatus').val(opt.data('status') || '');
        $('#otKmIn').val(opt.data('km') ? opt.data('km') + ' KM' : '');
    });

    /* ── KM Out live diff ── */
    $('#otKmOut').on('input', function() {
        var kmIn  = parseInt($('#otKmIn').val().replace(/[^0-9]/g, '')) || 0;
        var kmOut = parseInt($(this).val().replace(/[^0-9]/g, '')) || 0;
        if (kmOut && kmOut >= kmIn) {
            $('#otKmDiff').val((kmOut - kmIn) + ' KM');
            $('#sumKmOut').text(kmOut.toLocaleString('en-IN'));
        } else {
            $('#otKmDiff').val('');
            $('#sumKmOut').text('—');
        }
    });

    /* ── Inspection toggle buttons ── */
    $(document).on('click', '.insp-toggle', function() {
        var row   = $(this).data('row');
        var state = $(this).data('state');
        // Remove all active classes from same row's buttons
        $('[data-row="' + row + '"]').removeClass('active-ok active-dmg active-na');
        // Apply the right active class
        var cls = state === 'ok' ? 'active-ok' : (state === 'dmg' ? 'active-dmg' : 'active-na');
        $(this).addClass(cls);
    });

    /* ── Default handover datetime to now on modal open ── */
    $('#outTokenModal').on('show.bs.modal', function() {
        resetWizard();
        var now = new Date();
        var pad = n => String(n).padStart(2, '0');
        var dtStr = now.getFullYear() + '-' + pad(now.getMonth()+1) + '-' + pad(now.getDate())
                  + 'T' + pad(now.getHours()) + ':' + pad(now.getMinutes());
        $('#otHandoverDt').val(dtStr);
    });

    /* ── Stepper navigation ── */
    var currentStep = 1;
    var totalSteps  = 4;

    function resetWizard() {
        currentStep = 1;
        $('.ot-panel').addClass('d-none');
        $('#ot-step-1').removeClass('d-none');
        updateStepper();
        $('#otJcSelect').val('').trigger('change');
        $('#otVehicle, #otInvAmt, #otInvStatus, #otKmDiff').val('');
        $('#ackInspection, #ackPayment, #ackHandover').prop('checked', false);
        $('#ackWarning').hide();
    }

    function updateStepper() {
        // Update step circles and lines
        for (var i = 1; i <= totalSteps; i++) {
            var $step = $('[data-step="' + i + '"]');
            $step.removeClass('sc-step-active sc-step-done');
            if (i < currentStep)       $step.addClass('sc-step-done');
            else if (i === currentStep) $step.addClass('sc-step-active');

            // Step number: show checkmark icon for done steps
            if (i < currentStep) {
                $('#sn' + i).html('<i class="uil uil-check" style="font-size:16px;"></i>');
            } else {
                $('#sn' + i).text(i);
            }
        }

        // Update connector lines
        for (var j = 1; j <= totalSteps - 1; j++) {
            if (j < currentStep) $('#sl' + j).addClass('sc-line-done');
            else                  $('#sl' + j).removeClass('sc-line-done');
        }

        // Prev button
        $('#otPrev').prop('disabled', currentStep === 1);

        // Next / Issue Token buttons
        if (currentStep === totalSteps) {
            $('#otNext').addClass('d-none');
            $('#otIssue').removeClass('d-none');
        } else {
            $('#otNext').removeClass('d-none').text('Next →');
            $('#otIssue').addClass('d-none');
        }
    }

    function goToStep(step) {
        $('.ot-panel').addClass('d-none');
        $('#ot-step-' + step).removeClass('d-none');
        currentStep = step;
        updateStepper();

        // Populate summary on step 4
        if (step === 4) {
            var opt = $('#otJcSelect').find(':selected');
            $('#sumJc').text($('#otJcSelect').val() ? 'JC-2026-0044' : '—');
            $('#sumVehicle').text((opt.data('vehicle') || '—') + ' — ' + (opt.data('model') || ''));
            $('#sumInv').text(opt.data('inv') || '—');
            var kmOut = $('#otKmOut').val();
            $('#sumKmOut').text(kmOut ? parseInt(kmOut).toLocaleString('en-IN') : '—');
            var dtVal = $('#otHandoverDt').val();
            if (dtVal) {
                var d = new Date(dtVal);
                $('#sumHandover').text(d.toLocaleString('en-IN', { dateStyle: 'medium', timeStyle: 'short' }));
            }
        }
    }

    function validateStep(step) {
        if (step === 1) {
            if (!$('#otJcSelect').val()) {
                Swal.fire({ icon: 'warning', title: 'Select a Job Card', text: 'Please select a job card to proceed.', confirmButtonColor: '#032671' });
                return false;
            }
        }
        if (step === 3) {
            if (!$('#otKmOut').val()) {
                Swal.fire({ icon: 'warning', title: 'KM Out Required', text: 'Please enter the current odometer reading.', confirmButtonColor: '#032671' });
                return false;
            }
        }
        return true;
    }

    $('#otNext').on('click', function() {
        if (!validateStep(currentStep)) return;
        if (currentStep < totalSteps) goToStep(currentStep + 1);
    });

    $('#otPrev').on('click', function() {
        if (currentStep > 1) goToStep(currentStep - 1);
    });

    /* ── Issue Token ── */
    $('#otIssue').on('click', function() {
        var allChecked = $('#ackInspection').is(':checked') &&
                         $('#ackPayment').is(':checked') &&
                         $('#ackHandover').is(':checked');
        if (!allChecked) {
            $('#ackWarning').show();
            return;
        }
        $('#ackWarning').hide();
        $('#outTokenModal').modal('hide');
        Swal.fire({
            icon: 'success',
            title: 'Out-Token Issued',
            html: 'Token <strong>OT-2026-0013</strong> has been generated for <strong>RJ-14-GA-1111</strong>.',
            confirmButtonColor: '#10863f',
            confirmButtonText: 'OK'
        });
    });

    /* Init */
    resetWizard();

});
</script>
@endsection
