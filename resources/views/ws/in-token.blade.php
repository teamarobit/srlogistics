@extends('layouts.app')

@section('css')
<link href="{{ asset('css/Workshop/in-token.css?v=1.0') }}" rel="stylesheet">
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
                    <li class="breadcrumb-item active">Gate Entry — In-Token</li>
                </ol>
            </nav>

            {{-- Page Header --}}
            <div class="sc-page-head d-flex align-items-center justify-content-between mb-3">
                <div>
                    <h5 class="mb-0">Gate Entry — In-Token</h5>
                    <span class="text-muted" style="font-size:12px;">Record vehicle entry and pre-inspection at the gate</span>
                </div>
                <a href="{{ route('ws.appointment.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="uil uil-calendar-alt me-1"></i>Appointments
                </a>
            </div>

            {{-- Stepper --}}
            <div class="sc-stepper mb-4" id="tokenStepper">
                <div class="sc-step active" data-step="1"><span class="sc-step-num">1</span><span class="sc-step-label">Vehicle</span></div>
                <div class="sc-step-line"></div>
                <div class="sc-step" data-step="2"><span class="sc-step-num">2</span><span class="sc-step-label">KM & Driver</span></div>
                <div class="sc-step-line"></div>
                <div class="sc-step" data-step="3"><span class="sc-step-num">3</span><span class="sc-step-label">Pre-Inspection</span></div>
                <div class="sc-step-line"></div>
                <div class="sc-step" data-step="4"><span class="sc-step-num">4</span><span class="sc-step-label">Acknowledgement</span></div>
            </div>

            <div class="row g-3">

                {{-- Main form area --}}
                <div class="col-12 col-lg-8">

                    {{-- STEP 1 — Vehicle --}}
                    <div class="sc-card token-step-panel" id="tStep1">
                        <div class="sc-card-head">
                            <span class="sc-card-title">Step 1 — Identify Vehicle</span>
                        </div>
                        <div class="p-3">
                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <label>Vehicle Number <span class="text-danger">*</span></label>
                                    <select class="form-select select2-vehicle" id="tokenVehicleSelect" style="width:100%;">
                                        <option value="">Scan or search vehicle...</option>
                                        <option value="v1" data-reg="TN01 AB1234" data-sr="SR-2401" data-appt="APT-0401 (09:00)" data-driver="Ramesh Kumar" data-mobile="9876543210" data-km="84320">TN01 AB1234</option>
                                        <option value="v2" data-reg="TN02 CD5678" data-sr="SR-2402" data-appt="APT-0402 (09:30)" data-driver="Selvam P" data-mobile="9812345678" data-km="61200">TN02 CD5678</option>
                                        <option value="v3" data-reg="TN03 EF9012" data-sr="SR-2403" data-appt="APT-0403 (10:00)" data-driver="Vijay R" data-mobile="9988776655" data-km="102500">TN03 EF9012</option>
                                        <option value="v4" data-reg="TN04 GH3456" data-sr="SR-2404" data-appt="APT-0404 (10:30)" data-driver="Anand K" data-mobile="9090909090" data-km="47800">TN04 GH3456</option>
                                    </select>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label>Current KM Reading</label>
                                    <div class="sc-vehicle-box" id="tokenKmBox" style="min-height:35px;display:flex;align-items:center;color:#485D6B;">
                                        <span id="tokenKmText">Select vehicle first</span>
                                    </div>
                                </div>
                            </div>

                            {{-- SR & Appointment info --}}
                            <div id="tokenVehicleInfo" class="sc-vehicle-box mt-3" style="display:none;">
                                <div class="row g-2">
                                    <div class="col-6 col-md-3">
                                        <div style="font-size:10px;color:#485D6B;">REGISTRATION</div>
                                        <div class="fw-bold" id="tvReg" style="font-size:14px;color:#032671;letter-spacing:1px;"></div>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <div style="font-size:10px;color:#485D6B;">SR REF</div>
                                        <div class="fw-semibold" id="tvSr" style="font-size:12px;color:#10863f;"></div>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <div style="font-size:10px;color:#485D6B;">APPOINTMENT</div>
                                        <div class="fw-semibold" id="tvAppt" style="font-size:12px;"></div>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <div style="font-size:10px;color:#485D6B;">DRIVER</div>
                                        <div class="fw-semibold" id="tvDriver" style="font-size:12px;"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="text-end mt-3">
                                <button class="btn sc-btn-navy btn-sm" id="btnTStep1Next">Next: KM & Driver <i class="uil uil-arrow-right ms-1"></i></button>
                            </div>
                        </div>
                    </div>

                    {{-- STEP 2 — KM & Driver --}}
                    <div class="sc-card token-step-panel" id="tStep2" style="display:none;">
                        <div class="sc-card-head">
                            <span class="sc-card-title">Step 2 — KM Confirmation & Driver Details</span>
                        </div>
                        <div class="p-3">
                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <label>Odometer Reading (as seen at gate) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="actualKm" placeholder="Enter actual KM reading">
                                    <small class="text-muted">System KM: <span id="systemKmHint">—</span></small>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label>Entry Date & Time</label>
                                    <input type="text" class="form-control bg-light" readonly value="{{ now()->format('d M Y, H:i') }}">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label>Driver Name</label>
                                    <input type="text" class="form-control" id="driverName" placeholder="Driver name">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label>Driver Mobile</label>
                                    <input type="text" class="form-control" id="driverMobile" placeholder="Mobile number">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label>Gate Officer Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" placeholder="Officer recording entry">
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mt-3">
                                <button class="btn btn-outline-secondary btn-sm token-back-btn" data-target="1"><i class="uil uil-arrow-left me-1"></i>Back</button>
                                <button class="btn sc-btn-navy btn-sm" id="btnTStep2Next">Next: Pre-Inspection <i class="uil uil-arrow-right ms-1"></i></button>
                            </div>
                        </div>
                    </div>

                    {{-- STEP 3 — Pre-Inspection --}}
                    <div class="sc-card token-step-panel" id="tStep3" style="display:none;">
                        <div class="sc-card-head">
                            <span class="sc-card-title">Step 3 — Vehicle Pre-Inspection</span>
                        </div>
                        <div class="p-3">

                            {{-- Condition checklist --}}
                            <label class="mb-2">Vehicle Condition (tap to toggle: — / OK / Damaged)</label>
                            <div class="condition-grid mb-3">
                                @php
                                $conditions = [
                                    ['🪟','Front Windscreen','windscreen'],
                                    ['🔦','Headlights','headlights'],
                                    ['🔴','Tail Lights','taillights'],
                                    ['🚪','Body Panels','bodypanels'],
                                    ['🛞','Tyres (visible)','tyres'],
                                    ['🔋','Battery Terminals','battery'],
                                    ['💧','Oil / Fluid Leaks','oilleaks'],
                                    ['🔒','Door Locks','doorlocks'],
                                    ['🪑','Interior / Seats','interior'],
                                    ['📻','Dashboard / Gauges','dashboard'],
                                    ['🔊','Horn / Wipers','horn'],
                                    ['⛽','Fuel Cap','fuelcap'],
                                ];
                                @endphp
                                @foreach($conditions as $c)
                                <div class="condition-item" data-cond="{{ $c[2] }}">
                                    <span class="ci-icon">{{ $c[0] }}</span>
                                    <span>{{ $c[1] }}</span>
                                    <span class="ms-auto ci-status" style="font-size:10px;font-weight:700;opacity:.5;">—</span>
                                </div>
                                @endforeach
                            </div>

                            {{-- Fuel level --}}
                            <div class="row g-3 mb-3">
                                <div class="col-12">
                                    <label>Fuel Level: <strong id="fuelPct">50%</strong></label>
                                    <input type="range" class="form-range" id="fuelSlider" min="0" max="100" step="5" value="50">
                                    <div class="fuel-bar-wrap mt-1">
                                        <div class="fuel-bar" id="fuelBarFill" style="width:50%;background:#10863f;"></div>
                                    </div>
                                    <div class="fuel-labels"><span>Empty</span><span>1/4</span><span>1/2</span><span>3/4</span><span>Full</span></div>
                                </div>
                                <div class="col-12">
                                    <label>Damage / Remarks</label>
                                    <textarea class="form-control" rows="2" placeholder="Note any visible damage, missing parts, or special remarks..."></textarea>
                                </div>
                            </div>

                            {{-- Photo zones --}}
                            <label class="mb-2">Upload Vehicle Photos (optional)</label>
                            <div class="row g-2">
                                @foreach(['Front View','Rear View','Left Side','Right Side'] as $pv)
                                <div class="col-6 col-md-3">
                                    <div class="photo-zone">
                                        <i class="uil uil-camera" style="font-size:24px;color:#d4d6db;"></i>
                                        <div class="mt-1">{{ $pv }}</div>
                                        <div style="font-size:10px;color:#aaa;">Click to upload</div>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <div class="d-flex justify-content-between mt-3">
                                <button class="btn btn-outline-secondary btn-sm token-back-btn" data-target="2"><i class="uil uil-arrow-left me-1"></i>Back</button>
                                <button class="btn sc-btn-navy btn-sm" id="btnTStep3Next">Next: Acknowledgement <i class="uil uil-arrow-right ms-1"></i></button>
                            </div>
                        </div>
                    </div>

                    {{-- STEP 4 — Acknowledgement --}}
                    <div class="sc-card token-step-panel" id="tStep4" style="display:none;">
                        <div class="sc-card-head">
                            <span class="sc-card-title">Step 4 — Driver & Officer Acknowledgement</span>
                        </div>
                        <div class="p-3">
                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="chkDriver">
                                        <label class="form-check-label" for="chkDriver" style="font-size:12px;">
                                            I, the driver, confirm the above vehicle details and pre-inspection report are accurate.
                                        </label>
                                    </div>
                                    <div style="border:1px dashed #d4d6db;border-radius:8px;height:80px;display:flex;align-items:center;justify-content:center;font-size:11px;color:#aaa;">
                                        Driver Signature
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="chkOfficer">
                                        <label class="form-check-label" for="chkOfficer" style="font-size:12px;">
                                            I, the gate officer, have verified the vehicle and recorded the details correctly.
                                        </label>
                                    </div>
                                    <div style="border:1px dashed #d4d6db;border-radius:8px;height:80px;display:flex;align-items:center;justify-content:center;font-size:11px;color:#aaa;">
                                        Officer Signature
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mt-4">
                                <button class="btn btn-outline-secondary btn-sm token-back-btn" data-target="3"><i class="uil uil-arrow-left me-1"></i>Back</button>
                                <button class="btn sc-btn-green btn-sm" id="btnGenerateToken">
                                    <i class="uil uil-ticket me-1"></i>Generate In-Token
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- SUCCESS --}}
                    <div class="token-step-panel" id="tStepDone" style="display:none;">
                        <div class="token-success-card">
                            <div class="ts-sub">Gate Entry Token Generated</div>
                            <div class="ts-num">GT-0047</div>
                            <div class="ts-veh" id="doneVeh">TN01 AB1234</div>
                            <div class="ts-sub mt-2">{{ now()->format('d M Y, H:i') }}</div>
                            <div class="d-flex gap-2 justify-content-center mt-4">
                                <button class="btn btn-light btn-sm" id="btnPrintToken"><i class="uil uil-print me-1"></i>Print Token</button>
                                <a href="{{ route('ws.in-token.index') }}" class="btn btn-light btn-sm"><i class="uil uil-plus me-1"></i>New Entry</a>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Right sidebar --}}
                <div class="col-12 col-lg-4">

                    {{-- Token display --}}
                    <div class="sc-token-display mb-3">
                        <div>
                            <div class="sc-token-sub">NEXT TOKEN</div>
                            <div class="sc-token-num">GT-0047</div>
                        </div>
                        <div style="font-size:11px;opacity:.8;text-align:right;">
                            <div>{{ now()->format('d M Y') }}</div>
                            <div>{{ now()->format('H:i') }}</div>
                        </div>
                    </div>

                    {{-- Today's gate-in log --}}
                    <div class="sc-card">
                        <div class="sc-card-head">
                            <span class="sc-card-title">Today's Gate-In Log</span>
                        </div>
                        @php
                        $tokens = [
                            ['GT-0046','TN08 OP0123','08:52','Routine PM'],
                            ['GT-0045','TN06 KL2345','08:31','Tyre Service'],
                            ['GT-0044','TN04 GH3456','08:15','Battery'],
                            ['GT-0043','TN02 CD5678','07:55','Engine Oil'],
                            ['GT-0042','TN07 MN6789','07:30','Breakdown'],
                        ];
                        @endphp
                        @foreach($tokens as $t)
                        <div class="token-list-item">
                            <div>
                                <div class="fw-semibold">{{ $t[0] }} · {{ $t[1] }}</div>
                                <div class="text-muted">{{ $t[3] }}</div>
                            </div>
                            <div class="text-muted">{{ $t[2] }}</div>
                        </div>
                        @endforeach
                        <div class="p-2 text-center" style="font-size:11px;">
                            <span class="text-muted">5 vehicles entered today</span>
                        </div>
                    </div>

                </div>

            </div>{{-- end row --}}
        </div>{{-- end main-wrap --}}
    </div>{{-- end wrapper --}}
</div>{{-- end layout-wrapper --}}

{{-- Gate-In Token (compact print slip) --}}
<div class="prn-token-wrap" id="prnToken">
    <div class="prn-token-card">

        {{-- Header bar --}}
        <div class="prn-token-header">
            <div class="prn-th-company">SR LOGISTICS</div>
            <div class="prn-th-sub">SERVICE CENTRE — GATE ENTRY TOKEN</div>
        </div>

        {{-- Big token number --}}
        <div class="prn-token-num-block">
            <div class="prn-token-num" id="prnTokenNum">GT-0047</div>
        </div>

        {{-- Detail rows --}}
        <div class="prn-token-details">
            <div class="prn-td-row">
                <span class="prn-td-label">Vehicle</span>
                <span class="prn-td-val" id="prnTokenVeh">—</span>
            </div>
            <div class="prn-td-row">
                <span class="prn-td-label">SR Reference</span>
                <span class="prn-td-val" id="prnTokenSR">—</span>
            </div>
            <div class="prn-td-row">
                <span class="prn-td-label">Entry Date &amp; Time</span>
                <span class="prn-td-val" id="prnTokenDate">{{ now()->format('d M Y, H:i') }}</span>
            </div>
            <div class="prn-td-row">
                <span class="prn-td-label">KM at Entry</span>
                <span class="prn-td-val" id="prnTokenKm">—</span>
            </div>
            <div class="prn-td-row">
                <span class="prn-td-label">Driver</span>
                <span class="prn-td-val" id="prnTokenDriver">—</span>
            </div>
            <div class="prn-td-row">
                <span class="prn-td-label">Workshop</span>
                <span class="prn-td-val">WS-HYD — Bangalore</span>
            </div>
        </div>

        <div class="prn-token-divider"></div>

        {{-- Signature lines --}}
        <div class="prn-token-sigs">
            <div class="prn-sig-col">
                <div class="prn-sig-line"></div>
                <div class="prn-sig-lbl">Driver Signature</div>
            </div>
            <div class="prn-sig-col">
                <div class="prn-sig-line"></div>
                <div class="prn-sig-lbl">Officer Signature</div>
            </div>
        </div>

        {{-- Footer note --}}
        <div class="prn-token-footer">
            Printed: {{ now()->format('d M Y, H:i') }} &nbsp;·&nbsp; Valid for today only
        </div>

    </div>
</div>
@endsection

@section('js')
<script>
$(function () {

    // ── Select2 ──────────────────────────────────────────────────
    $('.select2-vehicle').select2({
        placeholder: 'Scan or search vehicle...',
        allowClear: true,
        width: '100%'
    });

    $('#tokenVehicleSelect').on('change', function () {
        const opt = $(this).find(':selected');
        const val = $(this).val();
        if (!val) {
            $('#tokenVehicleInfo').hide();
            $('#tokenKmText').text('Select vehicle first');
            return;
        }
        const km = parseInt(opt.data('km')).toLocaleString('en-IN') + ' KM';
        $('#tokenKmText').text(km);
        $('#systemKmHint').text(km);
        $('#tvReg').text(opt.data('reg'));
        $('#tvSr').text(opt.data('sr'));
        $('#tvAppt').text(opt.data('appt'));
        $('#tvDriver').text(opt.data('driver'));
        $('#driverName').val(opt.data('driver'));
        $('#driverMobile').val(opt.data('mobile'));
        $('#tokenVehicleInfo').show();
    });

    // ── Stepper nav ───────────────────────────────────────────────
    function goTokenStep(n) {
        $('.token-step-panel').hide();
        $('#tStep' + n).show();
        $('#tokenStepper .sc-step').each(function () {
            const s = parseInt($(this).data('step'));
            $(this).removeClass('active done');
            if (s < n)  $(this).addClass('done');
            if (s === n) $(this).addClass('active');
        });
        $('#tokenStepper .sc-step-line').each(function (i) {
            $(this).removeClass('done');
            if (i < n - 1) $(this).addClass('done');
        });
    }

    $(document).on('click', '.token-back-btn', function () { goTokenStep(parseInt($(this).data('target'))); });

    $('#btnTStep1Next').click(function () {
        if (!$('#tokenVehicleSelect').val()) {
            Swal.fire({ icon: 'warning', title: 'Select Vehicle', text: 'Please select or scan a vehicle.', confirmButtonColor: '#032671' });
            return;
        }
        goTokenStep(2);
    });
    $('#btnTStep2Next').click(function () {
        if (!$('#actualKm').val()) {
            Swal.fire({ icon: 'warning', title: 'KM Required', text: 'Please enter the actual KM reading.', confirmButtonColor: '#032671' });
            return;
        }
        goTokenStep(3);
    });
    $('#btnTStep3Next').click(function () { goTokenStep(4); });

    // ── Condition checklist 3-state toggle: default → ok → damaged ──
    $(document).on('click', '.condition-item', function () {
        const $item = $(this);
        const $status = $item.find('.ci-status');
        if ($item.hasClass('ok')) {
            $item.removeClass('ok').addClass('damaged');
            $status.text('DMG').css('opacity','1');
        } else if ($item.hasClass('damaged')) {
            $item.removeClass('damaged');
            $status.text('—').css('opacity','.5');
        } else {
            $item.addClass('ok');
            $status.text('OK').css('opacity','1');
        }
    });

    // ── Fuel slider ───────────────────────────────────────────────
    $('#fuelSlider').on('input', function () {
        const pct = $(this).val();
        $('#fuelPct').text(pct + '%');
        let color = pct < 25 ? '#ea0027' : pct < 50 ? '#e65100' : '#10863f';
        $('#fuelBarFill').css({ width: pct + '%', background: color });
    });

    // ── Generate token ────────────────────────────────────────────
    $('#btnGenerateToken').click(function () {
        if (!$('#chkDriver').is(':checked') || !$('#chkOfficer').is(':checked')) {
            Swal.fire({ icon: 'warning', title: 'Acknowledgement Required', text: 'Both driver and officer must acknowledge before generating the token.', confirmButtonColor: '#032671' });
            return;
        }
        Swal.fire({
            title: 'Generate Gate-In Token?',
            text: 'This will create token GT-0047 for the vehicle.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#10863f',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Generate Token'
        }).then((result) => {
            if (result.isConfirmed) {
                const opt    = $('#tokenVehicleSelect option:selected');
                const reg    = opt.data('reg')    || '—';
                const sr     = opt.data('sr')     || '—';
                const driver = $('#driverName').val() || opt.data('driver') || '—';
                const km     = $('#actualKm').val() ? parseInt($('#actualKm').val()).toLocaleString('en-IN') + ' KM' : '—';

                // Populate success card
                $('#doneVeh').text(reg);

                // Populate print slip
                $('#prnTokenVeh').text(reg);
                $('#prnTokenSR').text(sr);
                $('#prnTokenKm').text(km);
                $('#prnTokenDriver').text(driver);

                // Show done step
                $('.token-step-panel').hide();
                $('#tStepDone').show();
                $('#tokenStepper .sc-step').addClass('done').removeClass('active');
                $('#tokenStepper .sc-step-line').addClass('done');
            }
        });
    });

    // ── Print Token ───────────────────────────────────────────────
    $('#btnPrintToken').click(function () {
        window.print();
    });

});
</script>
@endsection
