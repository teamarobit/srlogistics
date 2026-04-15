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
                    <li class="breadcrumb-item active">Battery Replacement</li>
                </ol>
            </nav>

            {{-- Page Header --}}
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="d-flex align-items-center gap-3">
                    <a href="{{ route('inventory.battery-dashboard') }}" class="bdet-back-btn">
                        <i class="uil uil-arrow-left"></i>
                    </a>
                    <div>
                        <h5 class="mb-0"><i class="uil uil-exchange me-2" style="color:#ea0027;"></i>Battery Replacement</h5>
                        <span class="text-muted" style="font-size:12px;">Remove an old battery from a vehicle and fit a new one</span>
                    </div>
                </div>
            </div>

            {{-- Stepper --}}
            <div class="sc-stepper mb-4" id="batRepStepper">
                <div class="sc-step active" data-step="1">
                    <span class="sc-step-num">1</span>
                    <span class="sc-step-label">Current Battery</span>
                </div>
                <div class="sc-step-line"></div>
                <div class="sc-step" data-step="2">
                    <span class="sc-step-num">2</span>
                    <span class="sc-step-label">Removal Details</span>
                </div>
                <div class="sc-step-line"></div>
                <div class="sc-step" data-step="3">
                    <span class="sc-step-num">3</span>
                    <span class="sc-step-label">Select New Battery</span>
                </div>
                <div class="sc-step-line"></div>
                <div class="sc-step" data-step="4">
                    <span class="sc-step-num">4</span>
                    <span class="sc-step-label">Confirm Swap</span>
                </div>
            </div>

            {{-- ══════════════ STEP 1 — Current Battery ══════════════ --}}
            <div class="bwiz-step" id="batRepStep1">
                <div class="sc-card">
                    <div class="sc-card-head">
                        <span class="sc-card-title"><i class="uil uil-search-alt me-2"></i>Step 1 — Identify Current Battery</span>
                    </div>
                    <div class="p-3 p-md-4">
                        <div class="row g-3 mb-3">
                            <div class="col-12 col-md-6">
                                <label class="bwiz-label">Vehicle Registration <span class="text-danger">*</span></label>
                                <select class="form-select select2-rep-vehicle" id="batRepVehicleSelect" style="width:100%;">
                                    <option value="">Search vehicle by reg no...</option>
                                    <option value="KA-05-AB-1234">KA-05-AB-1234 — Tata Prima</option>
                                    <option value="MH-04-CD-5678">MH-04-CD-5678 — Tata 407</option>
                                    <option value="TN-01-EF-9012">TN-01-EF-9012 — Ashok Leyland</option>
                                    <option value="AP-09-GH-3456">AP-09-GH-3456 — Eicher Pro</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="bwiz-label">Battery Position</label>
                                <select class="form-select" id="batRepPosition">
                                    <option value="Primary">Primary Battery</option>
                                    <option value="Auxiliary">Auxiliary Battery</option>
                                </select>
                            </div>
                        </div>

                        {{-- Current Battery Info --}}
                        <div class="bwiz-bat-card" id="batRepCurCard" style="display:none;">
                            <div class="bwiz-bat-header" style="background:#ea0027;">
                                <div>
                                    <div class="bwiz-bat-serial">BAT-2022-00019 — Current Battery</div>
                                    <div style="font-size:11px;opacity:0.8;">Fitted on: 08 Mar 2022 · 26 months in service</div>
                                </div>
                                <span class="btd-cond-dead ms-auto">Dead</span>
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
                                        <span class="bwiz-bat-fv">Hi-Life 150</span>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="bwiz-bat-field">
                                        <span class="bwiz-bat-fl">Capacity</span>
                                        <span class="bwiz-bat-fv">150 Ah · 12V</span>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="bwiz-bat-field">
                                        <span class="bwiz-bat-fl">Condition</span>
                                        <span class="bwiz-bat-fv"><span class="btd-cond-dead">Dead</span></span>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="bwiz-bat-field">
                                        <span class="bwiz-bat-fl">Life Used</span>
                                        <span class="bwiz-bat-fv" style="color:#ea0027;">26 / 60 months</span>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="bwiz-bat-field">
                                        <span class="bwiz-bat-fl">Warranty</span>
                                        <span class="bwiz-bat-fv text-danger">Expired (Mar 2025)</span>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="bwiz-bat-field">
                                        <span class="bwiz-bat-fl">Installed At</span>
                                        <span class="bwiz-bat-fv">WS-HYD · 1,10,230 KM</span>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="bwiz-bat-field">
                                        <span class="bwiz-bat-fl">Current Odometer</span>
                                        <span class="bwiz-bat-fv">—</span>
                                    </div>
                                </div>
                            </div>
                            {{-- Health indicator --}}
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
                            <button class="btn sc-btn-navy btn-sm bwiz-rep-next" data-step="2">
                                Next <i class="uil uil-arrow-right ms-1"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ══════════════ STEP 2 — Removal Details ══════════════ --}}
            <div class="bwiz-step" id="batRepStep2" style="display:none;">
                <div class="sc-card">
                    <div class="sc-card-head">
                        <span class="sc-card-title"><i class="uil uil-minus-circle me-2"></i>Step 2 — Removal Details</span>
                    </div>
                    <div class="p-3 p-md-4">
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label class="bwiz-label">Removal Reason <span class="text-danger">*</span></label>
                                <select class="form-select" id="batRepReason">
                                    <option value="">Select reason...</option>
                                    <option value="Warranty Expired">Warranty Expired</option>
                                    <option value="Faulty / Dead">Faulty / Dead</option>
                                    <option value="Scheduled Replacement">Scheduled Replacement</option>
                                    <option value="Upgrade">Upgrade (Higher Capacity)</option>
                                    <option value="Breakdown">Emergency / Breakdown</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="bwiz-label">Removal Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="batRepDate" value="{{ date('Y-m-d') }}">
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="bwiz-label">Odometer at Removal (KM)</label>
                                <input type="number" class="form-control" id="batRepOdo" placeholder="e.g. 124856">
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="bwiz-label">Removed By (Technician) <span class="text-danger">*</span></label>
                                <select class="form-select" id="batRepTech">
                                    <option value="">Select technician...</option>
                                    <option>Rajesh Kumar</option>
                                    <option>Suresh M</option>
                                    <option>Arjun S</option>
                                    <option>Murugan P</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="bwiz-label">Workshop</label>
                                <select class="form-select" id="batRepWorkshop">
                                    <option value="">Select workshop...</option>
                                    <option>WS-BLR — Workshop Bangalore</option>
                                    <option>WS-HYD — Workshop Hyderabad</option>
                                    <option>Roadside / Field</option>
                                </select>
                            </div>

                            {{-- What to do with removed battery --}}
                            <div class="col-12">
                                <label class="bwiz-label">What to do with the removed battery? <span class="text-danger">*</span></label>
                                <div class="row g-2 mt-1" id="batRepDisposalGroup">
                                    @php
                                    $disposals = [
                                        ['workshop','uil-wrench','Send to Workshop','Repair and reuse later','#032671','#e3ecff'],
                                        ['scrap','uil-trash-alt','Scrap / Discard','Battery is beyond repair','#ea0027','#fdecea'],
                                        ['stock','uil-warehouse','Return to Stock','Usable condition, back to warehouse','#10863f','#e6f4ea'],
                                    ];
                                    @endphp
                                    @foreach($disposals as $d)
                                    <div class="col-12 col-md-4">
                                        <label class="bwiz-disposal-card" for="disposal_{{ $d[0] }}">
                                            <input type="radio" name="batDisposal" id="disposal_{{ $d[0] }}" value="{{ $d[0] }}" class="d-none">
                                            <div class="bwiz-disp-icon" style="background:{{ $d[5] }};color:{{ $d[4] }};">
                                                <i class="uil {{ $d[1] }}"></i>
                                            </div>
                                            <div>
                                                <div class="bwiz-disp-title">{{ $d[2] }}</div>
                                                <div class="bwiz-disp-desc">{{ $d[3] }}</div>
                                            </div>
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="bwiz-label">Removal Notes</label>
                                <textarea class="form-control" rows="2" id="batRepNotes" placeholder="Condition when removed, any damage or observations..."></textarea>
                            </div>
                        </div>

                        <div class="bwiz-step-nav mt-4">
                            <button class="btn btn-outline-secondary btn-sm bwiz-rep-back" data-step="1">
                                <i class="uil uil-arrow-left me-1"></i> Back
                            </button>
                            <button class="btn sc-btn-navy btn-sm bwiz-rep-next" data-step="3">
                                Next <i class="uil uil-arrow-right ms-1"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ══════════════ STEP 3 — Select New Battery ══════════════ --}}
            <div class="bwiz-step" id="batRepStep3" style="display:none;">
                <div class="sc-card">
                    <div class="sc-card-head d-flex align-items-center justify-content-between">
                        <span class="sc-card-title"><i class="uil uil-bolt-alt me-2"></i>Step 3 — Select New Battery</span>
                        <a href="{{ route('inventory.battery.add') }}" class="btn btn-outline-secondary btn-sm" target="_blank">
                            <i class="uil uil-plus me-1"></i>Raise PO / Add Battery
                        </a>
                    </div>
                    <div class="p-3 p-md-4">
                        {{-- Quick filters --}}
                        <div class="d-flex gap-2 flex-wrap mb-3">
                            <select class="form-select form-select-sm" style="width:130px;" id="batRepFilterCap">
                                <option value="">All Capacity</option>
                                <option value="120">120 Ah</option>
                                <option value="150" selected>150 Ah</option>
                                <option value="180">180 Ah</option>
                            </select>
                            <select class="form-select form-select-sm" style="width:110px;" id="batRepFilterVolt">
                                <option value="">All Voltage</option>
                                <option value="12V" selected>12V</option>
                                <option value="24V">24V</option>
                            </select>
                            <select class="form-select form-select-sm" style="width:130px;" id="batRepFilterType">
                                <option value="">All Types</option>
                                <option>Lead Acid</option>
                                <option>Lithium-ion</option>
                                <option>AGM</option>
                            </select>
                            <select class="form-select form-select-sm" style="width:130px;" id="batRepFilterLoc">
                                <option value="">All Locations</option>
                                <option>WH-BLR</option>
                                <option>WH-HYD</option>
                                <option>WH-PNE</option>
                            </select>
                        </div>

                        {{-- Stock table --}}
                        <div class="table-responsive">
                            <table class="table bwiz-stock-table mb-0" id="batRepStockTable">
                                <thead>
                                    <tr>
                                        <th style="width:36px;"></th>
                                        <th>Serial No.</th>
                                        <th>Brand</th>
                                        <th>Model</th>
                                        <th>Type</th>
                                        <th>Capacity</th>
                                        <th>Voltage</th>
                                        <th>Condition</th>
                                        <th>Location</th>
                                        <th>Warranty Exp.</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $stockBats = [
                                        ['BAT-2026-00081','Amaron','Pro Truck 150','Lead Acid','150 Ah','12V','New','WH-HYD','Feb 2027'],
                                        ['BAT-2026-00082','Amaron','Pro Truck 150','Lead Acid','150 Ah','12V','New','WH-BLR','Feb 2027'],
                                        ['BAT-2025-00053','Exide','Drive 150','Lead Acid','150 Ah','12V','Used','WH-HYD','Jun 2026'],
                                        ['BAT-2025-00060','Luminous','Red Charge 150','Lead Acid','150 Ah','12V','New','WH-PNE','Aug 2027'],
                                        ['BAT-2024-00033','Exide','Drive 120','Lead Acid','120 Ah','12V','Used','WH-BLR','Jan 2026'],
                                    ];
                                    @endphp
                                    @foreach($stockBats as $i => $b)
                                    <tr class="batRepStockRow" data-serial="{{ $b[0] }}" data-brand="{{ $b[1] }}" data-model="{{ $b[2] }}" data-cap="{{ $b[4] }}" data-volt="{{ $b[5] }}" data-cond="{{ $b[7] }}" data-warranty="{{ $b[8] }}">
                                        <td>
                                            <input type="radio" name="newBattery" class="form-check-input batRepRadio" value="{{ $b[0] }}" id="newBat{{ $i }}">
                                        </td>
                                        <td><label for="newBat{{ $i }}" class="btd-serial-link mb-0 cursor-pointer">{{ $b[0] }}</label></td>
                                        <td>{{ $b[1] }}</td>
                                        <td>{{ $b[2] }}</td>
                                        <td>{{ $b[3] }}</td>
                                        <td class="text-center fw-semibold">{{ $b[4] }}</td>
                                        <td class="text-center">{{ $b[5] }}</td>
                                        <td><span class="btd-cond btd-cond-{{ strtolower($b[6]) }}">{{ $b[6] }}</span></td>
                                        <td><span class="loc-badge loc-badge-wh"><i class="uil uil-warehouse"></i> {{ $b[7] }}</span></td>
                                        <td>{{ $b[8] }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="bwiz-step-nav mt-4">
                            <button class="btn btn-outline-secondary btn-sm bwiz-rep-back" data-step="2">
                                <i class="uil uil-arrow-left me-1"></i> Back
                            </button>
                            <button class="btn sc-btn-navy btn-sm bwiz-rep-next" data-step="4" id="batRepNextStep4" disabled>
                                Next <i class="uil uil-arrow-right ms-1"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ══════════════ STEP 4 — Confirm Swap ══════════════ --}}
            <div class="bwiz-step" id="batRepStep4" style="display:none;">
                <div class="sc-card">
                    <div class="sc-card-head">
                        <span class="sc-card-title"><i class="uil uil-check-circle me-2"></i>Step 4 — Confirm Battery Swap</span>
                    </div>
                    <div class="p-3 p-md-4">

                        {{-- Side-by-side swap cards --}}
                        <div class="bwiz-swap-wrap mb-4">
                            <div class="bwiz-swap-card bwiz-swap-out">
                                <div class="bwiz-swap-header">
                                    <i class="uil uil-arrow-up me-2"></i> Battery OUT — Being Removed
                                </div>
                                <div class="bwiz-swap-body">
                                    <div class="bwiz-conf-field">
                                        <span class="bwiz-conf-l">Serial</span>
                                        <span class="bwiz-conf-v">BAT-2022-00019</span>
                                    </div>
                                    <div class="bwiz-conf-field">
                                        <span class="bwiz-conf-l">Brand / Model</span>
                                        <span class="bwiz-conf-v">Amaron Hi-Life 150</span>
                                    </div>
                                    <div class="bwiz-conf-field">
                                        <span class="bwiz-conf-l">Condition</span>
                                        <span class="bwiz-conf-v"><span class="btd-cond-dead">Dead</span></span>
                                    </div>
                                    <div class="bwiz-conf-field">
                                        <span class="bwiz-conf-l">After Removal</span>
                                        <span class="bwiz-conf-v" id="conf-rep-disposal">—</span>
                                    </div>
                                    <div class="bwiz-conf-field">
                                        <span class="bwiz-conf-l">Removal Reason</span>
                                        <span class="bwiz-conf-v" id="conf-rep-reason">—</span>
                                    </div>
                                </div>
                            </div>
                            <div class="bwiz-swap-arrow">
                                <i class="uil uil-exchange"></i>
                            </div>
                            <div class="bwiz-swap-card bwiz-swap-in">
                                <div class="bwiz-swap-header">
                                    <i class="uil uil-arrow-down me-2"></i> Battery IN — Being Fitted
                                </div>
                                <div class="bwiz-swap-body">
                                    <div class="bwiz-conf-field">
                                        <span class="bwiz-conf-l">Serial</span>
                                        <span class="bwiz-conf-v" id="conf-new-serial">—</span>
                                    </div>
                                    <div class="bwiz-conf-field">
                                        <span class="bwiz-conf-l">Brand / Model</span>
                                        <span class="bwiz-conf-v" id="conf-new-model">—</span>
                                    </div>
                                    <div class="bwiz-conf-field">
                                        <span class="bwiz-conf-l">Capacity / Voltage</span>
                                        <span class="bwiz-conf-v" id="conf-new-spec">—</span>
                                    </div>
                                    <div class="bwiz-conf-field">
                                        <span class="bwiz-conf-l">Condition</span>
                                        <span class="bwiz-conf-v" id="conf-new-cond">—</span>
                                    </div>
                                    <div class="bwiz-conf-field">
                                        <span class="bwiz-conf-l">Location</span>
                                        <span class="bwiz-conf-v" id="conf-new-loc">—</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Vehicle + Date --}}
                        <div class="bwiz-confirm-summary mb-3">
                            <h6 class="bwiz-confirm-section-title">Vehicle & Fitting</h6>
                            <div class="row g-2">
                                <div class="col-6 col-md-3">
                                    <div class="bwiz-conf-field">
                                        <span class="bwiz-conf-l">Vehicle</span>
                                        <span class="bwiz-conf-v" id="conf-rep-vehicle">—</span>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="bwiz-conf-field">
                                        <span class="bwiz-conf-l">Position</span>
                                        <span class="bwiz-conf-v" id="conf-rep-position">Primary</span>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="bwiz-conf-field">
                                        <span class="bwiz-conf-l">Date</span>
                                        <span class="bwiz-conf-v" id="conf-rep-date">{{ date('d M Y') }}</span>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="bwiz-conf-field">
                                        <span class="bwiz-conf-l">Technician</span>
                                        <span class="bwiz-conf-v" id="conf-rep-tech">—</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Confirm checkbox --}}
                        <div class="bwiz-confirm-check mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="batRepConfirmChk">
                                <label class="form-check-label" for="batRepConfirmChk">
                                    I confirm that the old battery has been physically removed and the new battery has been fitted. Both the removal and installation will be logged in the movement history.
                                </label>
                            </div>
                        </div>

                        <div class="bwiz-step-nav">
                            <button class="btn btn-outline-secondary btn-sm bwiz-rep-back" data-step="3">
                                <i class="uil uil-arrow-left me-1"></i> Back
                            </button>
                            <button class="btn sc-btn-green btn-sm" id="batRepSubmitBtn" disabled>
                                <i class="uil uil-exchange me-1"></i> Confirm Battery Swap
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

    // Select2
    $('.select2-rep-vehicle').select2({ width: '100%', placeholder: 'Search vehicle...' });

    // Stepper
    function updateBatRepStepper(n) {
        $('#batRepStepper .sc-step').each(function () {
            var s = parseInt($(this).data('step'));
            $(this).removeClass('active done');
            if (s < n) $(this).addClass('done');
            if (s === n) $(this).addClass('active');
        });
        $('#batRepStepper .sc-step-line').each(function (i) {
            $(this).removeClass('done');
            if (i < n - 1) $(this).addClass('done');
        });
    }

    // Next
    $('.bwiz-rep-next').on('click', function () {
        var nextStep = parseInt($(this).data('step'));
        $('.bwiz-step').hide();
        $('#batRepStep' + nextStep).show();
        updateBatRepStepper(nextStep);
        if (nextStep === 4) batRepPopulateConfirm();
    });

    // Back
    $('.bwiz-rep-back').on('click', function () {
        var backStep = parseInt($(this).data('step'));
        $('.bwiz-step').hide();
        $('#batRepStep' + backStep).show();
        updateBatRepStepper(backStep);
    });

    // Show current battery card
    $('#batRepVehicleSelect').on('change', function () {
        if ($(this).val()) {
            $('#batRepCurCard').show();
        } else {
            $('#batRepCurCard').hide();
        }
    });

    // Disposal card selection
    $('#batRepDisposalGroup').on('click', '.bwiz-disposal-card', function () {
        $('.bwiz-disposal-card').removeClass('active');
        $(this).addClass('active');
        $(this).find('input[type="radio"]').prop('checked', true);
    });

    // Stock row selection enables Next
    $('#batRepStockTable').on('click', '.batRepStockRow', function () {
        $('.batRepStockRow').removeClass('selected');
        $(this).addClass('selected');
        $(this).find('.batRepRadio').prop('checked', true);
        $('#batRepNextStep4').prop('disabled', false);
    });

    // Confirm checkbox
    $('#batRepConfirmChk').on('change', function () {
        $('#batRepSubmitBtn').prop('disabled', !$(this).is(':checked'));
    });

    // Populate confirm
    function batRepPopulateConfirm() {
        var $sel = $('.batRepStockRow.selected');
        if ($sel.length) {
            $('#conf-new-serial').text($sel.data('serial') || '—');
            $('#conf-new-model').text(($sel.data('brand') || '') + ' ' + ($sel.data('model') || ''));
            $('#conf-new-spec').text(($sel.data('cap') || '') + ' · ' + ($sel.data('volt') || ''));
            $('#conf-new-cond').text($sel.data('cond') || '—');
            $('#conf-new-loc').text($sel.find('.loc-badge').text().trim() || '—');
        }
        $('#conf-rep-vehicle').text($('#batRepVehicleSelect').val() || '—');
        $('#conf-rep-position').text($('#batRepPosition').val() || '—');
        var dr = $('#batRepDate').val();
        $('#conf-rep-date').text(dr || '—');
        $('#conf-rep-tech').text($('#batRepTech').val() || '—');
        var disposal = $('input[name="batDisposal"]:checked').val();
        var disposalMap = { workshop: 'Send to Workshop', scrap: 'Scrap / Discard', stock: 'Return to Stock' };
        $('#conf-rep-disposal').text(disposalMap[disposal] || '—');
        $('#conf-rep-reason').text($('#batRepReason').val() || '—');
    }

    // Submit
    $('#batRepSubmitBtn').on('click', function () {
        var $btn = $(this);
        $btn.prop('disabled', true).html('<i class="uil uil-spinner-alt spin me-1"></i>Processing...');
        setTimeout(function () {
            $btn.html('<i class="uil uil-check me-1"></i>Swap Logged!');
            toastr.success('Battery replacement logged successfully.');
            setTimeout(function () {
                window.location.href = '{{ route("inventory.battery-dashboard") }}';
            }, 1200);
        }, 900);
    });

});
</script>

<style>
/* Disposal card styles (inline — wizard-specific) */
.bwiz-disposal-card {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 14px;
    border: 1.5px solid #e8ecf4;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.15s;
    background: #fff;
    width: 100%;
    text-align: left;
}
.bwiz-disposal-card:hover { border-color: #032671; background: #f5f8ff; }
.bwiz-disposal-card.active { border-color: #032671; background: #eef2fb; }
.bwiz-disp-icon {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    flex-shrink: 0;
}
.bwiz-disp-title { font-size: 13px; font-weight: 600; color: #1a2533; }
.bwiz-disp-desc  { font-size: 11px; color: #8898aa; }
.cursor-pointer { cursor: pointer; }
.btd-serial-link { color: #032671; font-weight: 600; font-size: 12.5px; text-decoration: none; }
.btd-serial-link:hover { text-decoration: underline; }
</style>
@endsection
