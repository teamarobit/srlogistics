@extends('layouts.app')

@section('css')
<link href="{{ asset('css/Workshop/service-request.css?v=1.0') }}" rel="stylesheet">
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
                    <li class="breadcrumb-item active">New Service Request</li>
                </ol>
            </nav>

            {{-- Page Header --}}
            <div class="sc-page-head d-flex align-items-center justify-content-between mb-3">
                <div>
                    <h5 class="mb-0">New Service Request</h5>
                    <span class="text-muted" style="font-size:12px;">Log a service request for a vehicle</span>
                </div>
                <a href="{{ route('ws.dashboard') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="uil uil-arrow-left me-1"></i>Back
                </a>
            </div>

            {{-- Stepper --}}
            <div class="sc-stepper mb-4" id="srStepper">
                <div class="sc-step active" data-step="1">
                    <span class="sc-step-num">1</span>
                    <span class="sc-step-label">Vehicle</span>
                </div>
                <div class="sc-step-line"></div>
                <div class="sc-step" data-step="2">
                    <span class="sc-step-num">2</span>
                    <span class="sc-step-label">Service Type</span>
                </div>
                <div class="sc-step-line"></div>
                <div class="sc-step" data-step="3">
                    <span class="sc-step-num">3</span>
                    <span class="sc-step-label">Details</span>
                </div>
                <div class="sc-step-line"></div>
                <div class="sc-step" data-step="4">
                    <span class="sc-step-num">4</span>
                    <span class="sc-step-label">Confirm</span>
                </div>
            </div>

            <div class="row g-3">

                {{-- Main form area --}}
                <div class="col-12 col-lg-8">

                    {{-- STEP 1 — Vehicle Selection --}}
                    <div class="sc-card sr-step-panel" id="step1">
                        <div class="sc-card-head">
                            <span class="sc-card-title">Step 1 — Select Vehicle</span>
                        </div>
                        <div class="p-3">
                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <label>Vehicle Number <span class="text-danger">*</span></label>
                                    <select class="form-select select2-vehicle" id="vehicleSelect" style="width:100%;">
                                        <option value="">Search vehicle number...</option>
                                        <option value="v1" data-reg="TN01 AB1234" data-make="Tata" data-model="LPT 3118" data-km="84320" data-driver="Ramesh Kumar" data-mobile="9876543210">TN01 AB1234</option>
                                        <option value="v2" data-reg="TN02 CD5678" data-make="Ashok Leyland" data-model="U3318" data-km="61200" data-driver="Selvam P" data-mobile="9812345678">TN02 CD5678</option>
                                        <option value="v3" data-reg="TN03 EF9012" data-make="Mahindra" data-model="Blazo X 28" data-km="102500" data-driver="Vijay R" data-mobile="9988776655">TN03 EF9012</option>
                                        <option value="v4" data-reg="TN04 GH3456" data-make="Eicher" data-model="Pro 2095" data-km="47800" data-driver="Anand K" data-mobile="9090909090">TN04 GH3456</option>
                                        <option value="v5" data-reg="TN05 IJ7890" data-make="BharatBenz" data-model="4228" data-km="73600" data-driver="Murugan S" data-mobile="8877665544">TN05 IJ7890</option>
                                    </select>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label>Current KM Reading</label>
                                    <div class="sc-vehicle-box" id="kmBox" style="min-height:35px; display:flex; align-items:center; color:#485D6B;">
                                        <span id="kmText">Select vehicle first</span>
                                    </div>
                                </div>
                            </div>

                            {{-- Vehicle info box --}}
                            <div id="vehicleInfoBox" class="sc-vehicle-box mt-3" style="display:none;">
                                <div class="row g-2">
                                    <div class="col-6 col-md-3">
                                        <div style="font-size:10px;color:#485D6B;">REGISTRATION</div>
                                        <div class="fw-bold" id="vReg" style="font-size:14px;color:#032671;letter-spacing:1px;"></div>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <div style="font-size:10px;color:#485D6B;">MAKE / MODEL</div>
                                        <div class="fw-semibold" id="vMakeModel" style="font-size:12px;"></div>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <div style="font-size:10px;color:#485D6B;">DRIVER</div>
                                        <div class="fw-semibold" id="vDriver" style="font-size:12px;"></div>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <div style="font-size:10px;color:#485D6B;">MOBILE</div>
                                        <div class="fw-semibold" id="vMobile" style="font-size:12px;"></div>
                                    </div>
                                </div>
                            </div>

                            {{-- System checks --}}
                            <div id="systemChecks" class="sc-check-panel mt-3" style="display:none;">
                                <div style="font-size:11px;font-weight:700;color:#485D6B;margin-bottom:6px;">SYSTEM CHECKS</div>
                                <div class="row g-2">
                                    <div class="col-12 col-md-4">
                                        <div class="check-item ok"><i class="uil uil-check-circle me-1"></i>Insurance Valid – Apr 2027</div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <div class="check-item due"><i class="uil uil-exclamation-octagon me-1"></i>FC Due – May 2026</div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <div class="check-item ov"><i class="uil uil-times-circle me-1"></i>Oil Change Overdue 300 KM</div>
                                    </div>
                                </div>
                            </div>

                            <div class="text-end mt-3">
                                <button class="btn sc-btn-navy btn-sm" id="btnStep1Next">Next: Service Type <i class="uil uil-arrow-right ms-1"></i></button>
                            </div>
                        </div>
                    </div>

                    {{-- STEP 2 — Service Type --}}
                    <div class="sc-card sr-step-panel" id="step2" style="display:none;">
                        <div class="sc-card-head">
                            <span class="sc-card-title">Step 2 — Select Service Type</span>
                        </div>
                        <div class="p-3">
                            <div class="row g-2 mb-3">
                                @php
                                $serviceTypes = [
                                    ['type','routine','🔧','Routine Maintenance'],
                                    ['type','breakdown','🚨','Breakdown'],
                                    ['type','tyre','🛞','Tyre Service'],
                                    ['type','battery','🔋','Battery Service'],
                                    ['type','accident','🚗','Accident / Body Work'],
                                    ['type','insurance','📋','Insurance Claim'],
                                ];
                                @endphp
                                @foreach($serviceTypes as $st)
                                <div class="col-6 col-md-4 col-lg-2">
                                    <div class="sr-type-card sr-type-sel" data-type="{{ $st[1] }}">
                                        <span class="st-icon">{{ $st[2] }}</span>
                                        <span class="st-lbl">{{ $st[3] }}</span>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            {{-- Tyre position panel --}}
                            <div id="tyrePosPanel" style="display:none;">
                                <label class="mb-2">Select Tyre Positions (click to toggle worn)</label>
                                <div class="tyre-grid mb-3">
                                    @foreach(['FL','FR','RL1','RL2','RR1','RR2','Spare'] as $pos)
                                    <div class="tyre-pos-btn" data-pos="{{ $pos }}">{{ $pos }}</div>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Battery panel --}}
                            <div id="batteryPanel" style="display:none;">
                                <div class="row g-2">
                                    <div class="col-12 col-md-6">
                                        <label>Battery Issue Type</label>
                                        <select class="form-select">
                                            <option>Select issue...</option>
                                            <option>Dead / No Start</option>
                                            <option>Weak / Slow Crank</option>
                                            <option>Swollen / Leaking</option>
                                            <option>Routine Replacement</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label>Current Battery Brand</label>
                                        <input type="text" class="form-control" placeholder="e.g. Exide, Amaron">
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-3">
                                <button class="btn btn-outline-secondary btn-sm sr-back-btn" data-target="step1"><i class="uil uil-arrow-left me-1"></i>Back</button>
                                <button class="btn sc-btn-navy btn-sm" id="btnStep2Next">Next: Details <i class="uil uil-arrow-right ms-1"></i></button>
                            </div>
                        </div>
                    </div>

                    {{-- STEP 3 — Details --}}
                    <div class="sc-card sr-step-panel" id="step3" style="display:none;">
                        <div class="sc-card-head">
                            <span class="sc-card-title">Step 3 — Request Details</span>
                        </div>
                        <div class="p-3">
                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <label>Request Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" value="{{ date('Y-m-d') }}">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label>Priority <span class="text-danger">*</span></label>
                                    <div class="d-flex gap-2 mt-1 flex-wrap">
                                        <div class="priority-chip" data-priority="normal">🟢 Normal</div>
                                        <div class="priority-chip" data-priority="high">🟡 High</div>
                                        <div class="priority-chip" data-priority="urgent">🔴 Urgent</div>
                                    </div>
                                    <input type="hidden" id="selectedPriority" name="priority" value="">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label>Requested By</label>
                                    <input type="text" class="form-control" placeholder="Name of requester">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label>Contact Number</label>
                                    <input type="text" class="form-control" placeholder="Mobile number">
                                </div>
                                <div class="col-12">
                                    <label>Problem Description <span class="text-danger">*</span></label>
                                    <textarea class="form-control" rows="3" placeholder="Describe the issue or service needed..."></textarea>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label>Preferred Service Location</label>
                                    <select class="form-select">
                                        <option value="">Select location...</option>
                                        <option>Main Workshop – Chennai</option>
                                        <option>Branch SC – Madurai</option>
                                        <option>On-Road / Breakdown</option>
                                    </select>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label>Estimated Budget (₹)</label>
                                    <input type="number" class="form-control" placeholder="Optional">
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-3">
                                <button class="btn btn-outline-secondary btn-sm sr-back-btn" data-target="step2"><i class="uil uil-arrow-left me-1"></i>Back</button>
                                <button class="btn sc-btn-navy btn-sm" id="btnStep3Next">Review & Confirm <i class="uil uil-arrow-right ms-1"></i></button>
                            </div>
                        </div>
                    </div>

                    {{-- STEP 4 — Confirm --}}
                    <div class="sc-card sr-step-panel" id="step4" style="display:none;">
                        <div class="sc-card-head">
                            <span class="sc-card-title">Step 4 — Review & Confirm</span>
                        </div>
                        <div class="p-3">
                            <div class="sr-summary-card mb-3">
                                <div class="sum-row"><span class="sum-key">Vehicle</span><span class="sum-val" id="sum-vehicle">—</span></div>
                                <div class="sum-row"><span class="sum-key">Service Type</span><span class="sum-val" id="sum-type">—</span></div>
                                <div class="sum-row"><span class="sum-key">Priority</span><span class="sum-val" id="sum-priority">—</span></div>
                                <div class="sum-row"><span class="sum-key">Location</span><span class="sum-val">Main Workshop – Chennai</span></div>
                                <div class="sum-row"><span class="sum-key">Request Date</span><span class="sum-val">{{ date('d M Y') }}</span></div>
                            </div>

                            <div class="d-flex justify-content-between mt-3">
                                <button class="btn btn-outline-secondary btn-sm sr-back-btn" data-target="step3"><i class="uil uil-arrow-left me-1"></i>Back</button>
                                <button class="btn sc-btn-green btn-sm" id="btnSubmitSR">
                                    <i class="uil uil-check me-1"></i>Submit Service Request
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Success --}}
                    <div class="sr-step-panel" id="stepDone" style="display:none;">
                        <div class="sr-success-box">
                            <div class="sr-sub mb-1">Service Request Created</div>
                            <div class="sr-ref-num">SR-2401</div>
                            <div class="sr-sub mt-2">TN01 AB1234 · Routine Maintenance · Normal Priority</div>
                            <div class="d-flex gap-2 justify-content-center mt-4">
                                <a href="{{ route('ws.service-request.index') }}" class="btn btn-light btn-sm">New Request</a>
                                <button class="btn btn-light btn-sm" onclick="window.print()"><i class="uil uil-print me-1"></i>Print PRN</button>
                                <a href="{{ route('ws.dashboard') }}" class="btn btn-light btn-sm">Dashboard</a>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Right sidebar --}}
                <div class="col-12 col-lg-4">

                    {{-- Recent SRs --}}
                    <div class="sc-card mb-3">
                        <div class="sc-card-head">
                            <span class="sc-card-title">Recent Service Requests</span>
                        </div>
                        @php
                        $recent = [
                            ['SR-2398','TN02 CD5678','Engine Oil','Normal','done'],
                            ['SR-2397','TN07 MN6789','Tyre','Urgent','wip'],
                            ['SR-2396','TN01 AB1234','Battery','High','open'],
                            ['SR-2395','TN09 QR4567','PM Service','Normal','done'],
                        ];
                        @endphp
                        @foreach($recent as $r)
                        <div style="display:flex;align-items:center;justify-content:space-between;padding:9px 14px;border-bottom:1px solid #f0f0f0;font-size:12px;">
                            <div>
                                <div class="fw-semibold">{{ $r[0] }} · {{ $r[1] }}</div>
                                <div class="text-muted">{{ $r[2] }} · {{ $r[3] }}</div>
                            </div>
                            <span class="sc-badge-{{ $r[4] }}">{{ strtoupper($r[4]) }}</span>
                        </div>
                        @endforeach
                    </div>

                    {{-- Help tips --}}
                    <div class="sc-card">
                        <div class="sc-card-head">
                            <span class="sc-card-title">Tips</span>
                        </div>
                        <div class="p-3" style="font-size:12px;color:#485D6B;">
                            <p class="mb-2"><i class="uil uil-info-circle text-primary me-1"></i>Select the vehicle first — system checks will auto-populate.</p>
                            <p class="mb-2"><i class="uil uil-info-circle text-primary me-1"></i>For breakdown requests, use <strong>Urgent</strong> priority.</p>
                            <p class="mb-0"><i class="uil uil-info-circle text-primary me-1"></i>After submission, a Job Card can be created from the SR.</p>
                        </div>
                    </div>

                </div>

            </div>{{-- end row --}}

        </div>{{-- end main-wrap --}}
    </div>{{-- end wrapper --}}
</div>{{-- end layout-wrapper --}}

{{-- PRN Template (hidden, for print) --}}
<div class="print-only" id="prnTemplate">
    <div class="sc-prn-head">
        <div><strong>SR Logistics</strong><br><small>Service Request Note</small></div>
        <div class="text-end"><strong>SR-2401</strong><br><small>{{ date('d M Y') }}</small></div>
    </div>
    <table style="width:100%;font-size:12px;border-collapse:collapse;">
        <tr><td style="padding:4px 8px;border:1px solid #ddd;width:40%;">Vehicle</td><td style="padding:4px 8px;border:1px solid #ddd;">TN01 AB1234</td></tr>
        <tr><td style="padding:4px 8px;border:1px solid #ddd;">Service Type</td><td style="padding:4px 8px;border:1px solid #ddd;">Routine Maintenance</td></tr>
        <tr><td style="padding:4px 8px;border:1px solid #ddd;">Priority</td><td style="padding:4px 8px;border:1px solid #ddd;">Normal</td></tr>
        <tr><td style="padding:4px 8px;border:1px solid #ddd;">Location</td><td style="padding:4px 8px;border:1px solid #ddd;">Main Workshop – Chennai</td></tr>
        <tr><td style="padding:4px 8px;border:1px solid #ddd;">Date</td><td style="padding:4px 8px;border:1px solid #ddd;">{{ date('d M Y') }}</td></tr>
    </table>
</div>
@endsection

@section('js')
<script>
$(function () {

    // ── Select2 init ──────────────────────────────────────────────
    $('.select2-vehicle').select2({
        placeholder: 'Search vehicle number...',
        allowClear: true,
        width: '100%'
    });

    // Vehicle change → populate info
    $('#vehicleSelect').on('change', function () {
        const opt = $(this).find(':selected');
        const val = $(this).val();
        if (!val) {
            $('#vehicleInfoBox').hide();
            $('#systemChecks').hide();
            $('#kmText').text('Select vehicle first');
            return;
        }
        $('#kmText').text(parseInt(opt.data('km')).toLocaleString('en-IN') + ' KM');
        $('#vReg').text(opt.data('reg'));
        $('#vMakeModel').text(opt.data('make') + ' ' + opt.data('model'));
        $('#vDriver').text(opt.data('driver'));
        $('#vMobile').text(opt.data('mobile'));
        $('#vehicleInfoBox').show();
        $('#systemChecks').show();
    });

    // ── Stepper navigation ────────────────────────────────────────
    function goToStep(n) {
        $('.sr-step-panel').hide();
        $('#step' + n).show();
        $('#srStepper .sc-step').each(function () {
            const s = parseInt($(this).data('step'));
            $(this).removeClass('active done');
            if (s < n)  $(this).addClass('done');
            if (s === n) $(this).addClass('active');
        });
        $('#srStepper .sc-step-line').each(function (i) {
            $(this).removeClass('done');
            if (i < n - 1) $(this).addClass('done');
        });
    }

    // Back buttons
    $(document).on('click', '.sr-back-btn', function () {
        const target = $(this).data('target');
        goToStep(parseInt(target.replace('step', '')));
    });

    // Step 1 → 2
    $('#btnStep1Next').click(function () {
        if (!$('#vehicleSelect').val()) {
            Swal.fire({ icon: 'warning', title: 'Select Vehicle', text: 'Please select a vehicle to continue.', confirmButtonColor: '#032671' });
            return;
        }
        goToStep(2);
    });

    // Step 2 → 3
    $('#btnStep2Next').click(function () {
        if (!$('.sr-type-sel.selected').length) {
            Swal.fire({ icon: 'warning', title: 'Select Service Type', text: 'Please select a service type.', confirmButtonColor: '#032671' });
            return;
        }
        goToStep(3);
    });

    // Step 3 → 4
    $('#btnStep3Next').click(function () {
        if (!$('#selectedPriority').val()) {
            Swal.fire({ icon: 'warning', title: 'Select Priority', text: 'Please select a priority level.', confirmButtonColor: '#032671' });
            return;
        }
        // Populate summary
        const veh = $('#vehicleSelect option:selected').data('reg') || 'N/A';
        const typ = $('.sr-type-sel.selected').find('.st-lbl').text() || 'N/A';
        const pri = $('#selectedPriority').val();
        $('#sum-vehicle').text(veh);
        $('#sum-type').text(typ);
        $('#sum-priority').text(pri.charAt(0).toUpperCase() + pri.slice(1));
        goToStep(4);
    });

    // Submit
    $('#btnSubmitSR').click(function () {
        Swal.fire({
            title: 'Submit Service Request?',
            text: 'This will create SR and notify the workshop.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#10863f',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, Submit'
        }).then((result) => {
            if (result.isConfirmed) {
                $('.sr-step-panel').hide();
                $('#stepDone').show();
                // reset stepper visual
                $('#srStepper .sc-step').addClass('done').removeClass('active');
                $('#srStepper .sc-step-line').addClass('done');
            }
        });
    });

    // ── Service type card selection ───────────────────────────────
    $(document).on('click', '.sr-type-sel', function () {
        $('.sr-type-sel').removeClass('selected');
        $(this).addClass('selected');
        const t = $(this).data('type');
        $('#tyrePosPanel').toggle(t === 'tyre');
        $('#batteryPanel').toggle(t === 'battery');
    });

    // ── Tyre position toggle ──────────────────────────────────────
    $(document).on('click', '.tyre-pos-btn', function () {
        $(this).toggleClass('worn');
    });

    // ── Priority chip selection ───────────────────────────────────
    $(document).on('click', '.priority-chip', function () {
        $('.priority-chip').removeClass('selected-normal selected-urgent selected-high');
        const p = $(this).data('priority');
        $(this).addClass('selected-' + p);
        $('#selectedPriority').val(p);
    });

});
</script>
@endsection
