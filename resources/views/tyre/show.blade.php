@extends('layouts.app')

@section('css')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css" />
<link rel="stylesheet" href="{{ asset('css/fleet/vehicle-details-v2.css?v=4.3') }}">
<link rel="stylesheet" href="{{ asset('css/tyre/show.css?v=2.7') }}">

@endsection
    

@section('content')

    
<div class="layout-wrapper">
    
    @include('includes.header')
    @php
        $tyreLifeInfo = getTyreLifeInfo($tyre->id);
    @endphp
    {{-- ══ PAGE WRAPPER — v2 background ══ --}}
    <div class="srlog-bdwrapper v2-page">

        {{-- ═══════════════════════════════════════════════════════════════
             V2 INTELLIGENCE HEADER
        ═══════════════════════════════════════════════════════════════ --}}
        @php
            /* ── Tyre health border colour ── */
            $lifeNum    = (float) str_replace('%', '', $tyreLifeInfo['life_percent'] ?? '0');
            $colHealth  = $lifeNum >= 50 ? 'green' : ($lifeNum >= 20 ? 'amber' : 'red');

            /* ── Allocation border colour ── */
            $colAlloc   = ($tyre->location === 'Vehicle') ? 'green' : 'grey';

            /* ── Warranty border colour ── */
            $colWarranty = 'grey';
            if ($remainingWarrantyMonths !== null) {
                $colWarranty = $remainingWarrantyMonths > 3 ? 'green'
                             : ($remainingWarrantyMonths > 0 ? 'amber' : 'red');
            }

            /* ── Status badge ── */
            $statusBadgeClass = match($tyre->tyre_status ?? '') {
                'Active', 'Ready to Use' => 'active',
                'Scrap', 'Yet to Decide' => 'inactive',
                default => 'active',
            };
        @endphp

        <div class="v2-header-zone">

            {{-- ── IDENTITY BAR ── --}}
            <div class="v2-id-bar">

                {{-- Tyre icon --}}
                <div class="v2-id-icon-wrap">
                    <img src="{{ asset('images/icons/tyre-default.png') }}" alt="Tyre">
                </div>

                {{-- Tyre serial number + type --}}
                <div>
                    <div class="v2-id-vno">
                        {{ $tyre->tyre_serial_number ?? '—' }}
                        <span class="v2-id-status {{ $statusBadgeClass }}">
                            {{ $tyre->tyre_status ?? 'Active' }}
                        </span>
                    </div>
                    <div class="v2-id-sub">
                        {{ $tyre->tyre_type ?? 'Tyre' }}
                        @if($tyre->tyre_condition) · Condition: {{ $tyre->tyre_condition }} @endif
                    </div>
                </div>

                <div class="v2-id-sep"></div>

                {{-- Brand / Model --}}
                <div>
                    <div class="v2-id-field-label">Brand / Model</div>
                    <div class="v2-id-field-value">
                        {{ $tyre->tyre_brand ?? '—' }}
                        @if($tyre->tyre_model) / {{ $tyre->tyre_model }} @endif
                    </div>
                    <div class="v2-id-field-sub">{{ $tyre->tyrevendor?->contact_name ?? 'No vendor' }}</div>
                </div>

                <div class="v2-id-sep"></div>

                {{-- Location --}}
                <div>
                    <div class="v2-id-field-label">Location</div>
                    <div class="v2-id-field-value">{{ $tyre->location ?? '—' }}</div>
                    <div class="v2-id-field-sub">
                        @if($tyre->location === 'Vehicle' && $tyre->allocatedVehicle?->basicinfo?->vehicle_number)
                            {{ $tyre->allocatedVehicle->basicinfo->vehicle_number }}
                        @else
                            Not fitted
                        @endif
                    </div>
                </div>

                {{-- Actions flush right --}}
                <div class="v2-id-actions">
                    <a href="{{ route('tyre.edit', $tyre->id) }}"
                       class="btn btn-sm"
                       style="background:#f0f4ff;color:#032671;border:1px solid #c5d0ee;font-size:11px;font-weight:600;">
                        <i class="uil uil-pen me-1"></i>Edit Tyre
                    </a>
                </div>

            </div>{{-- /.v2-id-bar --}}

            {{-- ── INTELLIGENCE GRID ── --}}
            <div class="v2-intel-grid">

                {{-- COLUMN 1 — TYRE HEALTH --}}
                <div class="v2-intel-col health-{{ $colHealth }}">
                    <div class="v2-intel-col-title">
                        <i class="uil uil-analytics"></i> Tyre Health
                    </div>

                    <div class="v2-intel-row">
                        <span class="v2-intel-lbl">RAG Status</span>
                        <span class="v2-intel-val {{ $colHealth === 'green' ? 'ok' : ($colHealth === 'amber' ? 'warn' : 'danger') }}">
                            {{ $ragStatus }}
                        </span>
                    </div>

                    <div class="v2-intel-row">
                        <span class="v2-intel-lbl">Life Remaining</span>
                        <span class="v2-intel-val {{ $colHealth === 'green' ? 'ok' : ($colHealth === 'amber' ? 'warn' : 'danger') }}">
                            {{ $tyreLifeInfo['life_percent'] ?? '—' }}
                            <span class="v2-intel-val-sub">{{ $tyreLifeInfo['life_text'] ?? '' }}</span>
                        </span>
                    </div>

                    <div class="v2-intel-row">
                        <span class="v2-intel-lbl">Fixed Run KM</span>
                        <span class="v2-intel-val">{{ $tyre->fixed_run_km ? number_format($tyre->fixed_run_km) : '—' }}</span>
                    </div>

                    <div class="v2-intel-row">
                        <span class="v2-intel-lbl">Actual Run KM</span>
                        <span class="v2-intel-val">{{ $tyre->actual_run_km !== null ? number_format($tyre->actual_run_km) : '—' }}</span>
                    </div>

                    <div class="v2-intel-row">
                        <span class="v2-intel-lbl">Remaining KM</span>
                        <span class="v2-intel-val">
                            @if($tyre->fixed_run_km && $tyre->actual_run_km !== null)
                                {{ number_format($tyre->fixed_run_km - $tyre->actual_run_km) }}
                            @else —
                            @endif
                        </span>
                    </div>
                </div>

                {{-- COLUMN 2 — ALLOCATION STATUS --}}
                <div class="v2-intel-col health-{{ $colAlloc }}">
                    <div class="v2-intel-col-title">
                        <i class="uil uil-truck"></i> Allocation Status
                    </div>

                    <div class="v2-intel-row">
                        <span class="v2-intel-lbl">Location</span>
                        <span class="v2-intel-val {{ $tyre->location === 'Vehicle' ? 'ok' : '' }}">
                            {{ $tyre->location ?? '—' }}
                        </span>
                    </div>

                    <div class="v2-intel-row">
                        <span class="v2-intel-lbl">Vehicle Number</span>
                        <span class="v2-intel-val">{{ $tyre->allocatedVehicle?->basicinfo?->vehicle_number ?? '—' }}</span>
                    </div>

                    <div class="v2-intel-row">
                        <span class="v2-intel-lbl">Tyre Position</span>
                        <span class="v2-intel-val">{{ $tyre->activeVehicleMapping?->tyreposition?->code ?? '—' }}</span>
                    </div>

                    <div class="v2-intel-row">
                        <span class="v2-intel-lbl">Fitment Date</span>
                        <span class="v2-intel-val">
                            {{ $tyre->installation_date ? \Carbon\Carbon::parse($tyre->installation_date)->format('d M Y') : '—' }}
                        </span>
                    </div>

                    <div class="v2-intel-row">
                        <span class="v2-intel-lbl">Source</span>
                        <span class="v2-intel-val">
                            @if($tyre->tyre_source_mode === 'Fitment') Direct Fitment
                            @elseif($tyre->tyre_source_mode) SR Garage
                            @else —
                            @endif
                        </span>
                    </div>
                </div>

                {{-- COLUMN 3 — WARRANTY & REMINDERS --}}
                <div class="v2-intel-col health-{{ $colWarranty }}">
                    <div class="v2-intel-col-title">
                        <i class="uil uil-shield-check"></i> Warranty &amp; Reminders
                    </div>

                    <div class="v2-intel-row">
                        <span class="v2-intel-lbl">Warranty Period</span>
                        <span class="v2-intel-val">
                            {{ $tyre->tyre_warranty_months ? $tyre->tyre_warranty_months . ' months' : '—' }}
                        </span>
                    </div>

                    <div class="v2-intel-row">
                        <span class="v2-intel-lbl">Remaining Warranty</span>
                        @if($remainingWarrantyMonths !== null)
                            <span class="v2-intel-val {{ $remainingWarrantyMonths > 0 ? 'ok' : 'danger' }}">
                                {{ $remainingWarrantyMonths > 0 ? round($remainingWarrantyMonths, 1) . ' months' : 'Expired' }}
                            </span>
                        @else
                            <span class="v2-intel-val" style="color:#9098b1;">—</span>
                        @endif
                    </div>

                    <div class="v2-intel-row">
                        <span class="v2-intel-lbl">Alignment Reminder</span>
                        <span class="v2-intel-val {{ $tyre->set_reminder_for_alignment === 'Yes' ? 'ok' : '' }}">
                            {{ $tyre->set_reminder_for_alignment === 'Yes' ? 'ON' : 'OFF' }}
                            @if($tyre->alignment_interval_km)
                                <span class="v2-intel-val-sub">Every {{ number_format($tyre->alignment_interval_km) }} KM</span>
                            @endif
                        </span>
                    </div>

                    <div class="v2-intel-row">
                        <span class="v2-intel-lbl">Rotation Reminder</span>
                        <span class="v2-intel-val {{ $tyre->set_reminder_for_rotation === 'Yes' ? 'ok' : '' }}">
                            {{ $tyre->set_reminder_for_rotation === 'Yes' ? 'ON' : 'OFF' }}
                            @if($tyre->rotation_interval_km)
                                <span class="v2-intel-val-sub">Every {{ number_format($tyre->rotation_interval_km) }} KM</span>
                            @endif
                        </span>
                    </div>

                    <div class="v2-intel-row">
                        <span class="v2-intel-lbl">Purchase Date</span>
                        <span class="v2-intel-val">
                            {{ $tyre->tyre_purchase_date ? \Carbon\Carbon::parse($tyre->tyre_purchase_date)->format('d M Y') : '—' }}
                        </span>
                    </div>
                </div>

            </div>{{-- /.v2-intel-grid --}}

        </div>{{-- /.v2-header-zone --}}

        <div class="vehicleinfo-wrap align-items-center">
            <div class="vehicleinfo-sec">
                <div class="container-fluid">

                    {{-- ═══════════════════════════════════════════════════════
                         7 STATUS ACCORDIONS
                    ═══════════════════════════════════════════════════════ --}}
                    <div class="accordion tyre-detail-accordion" id="tyreDetailAccordion">

                        {{-- ══════════════════════════════════════════
                             ACCORDION 1 — BASIC DETAILS
                        ══════════════════════════════════════════ --}}
                        <div class="accordion-item">
                            <div class="accordion-header vehicleinfor_head" id="acc_head_1">
                                <div class="row vehicleinfo_toprow align-items-center">
                                    <div class="col-12 col-md-11 d-flex align-items-center">
                                        <span class="titletext">Basic Details</span>
                                    </div>
                                    <div class="col-12 col-md-1">
                                        <button class="accordion-button filter-options collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#acc_body_1"
                                            aria-expanded="false" aria-controls="acc_body_1">
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div id="acc_body_1" class="accordion-collapse collapse show"
                                 aria-labelledby="acc_head_1">
                                <div class="accordion-body">
                                    <div class="table-responsive table-responsive02">
                                        <table class="table tyre-info-table">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <p>Tyre Serial Number</p>
                                                        <span class="text-secondary d-block">{{ $tyre->tyre_serial_number ?? '-' }}</span>
                                                    </td>
                                                    <td>
                                                        <p>Vehicle Number</p>
                                                        <span class="text-secondary d-block">{{ $tyre->allocatedVehicle?->basicinfo?->vehicle_number ?? '-' }}</span>
                                                    </td>
                                                    <td>
                                                        <p>Tyre Position</p>
                                                        <span class="text-secondary d-block">{{ $tyre->activeVehicleMapping?->tyreposition?->code ?? '-' }}</span>
                                                    </td>
                                                    <td>
                                                        <p>Tyre Fitment Date</p>
                                                        <span class="text-secondary d-block">{{ $tyre->installation_date ? \Carbon\Carbon::parse($tyre->installation_date)->format('d/m/Y') : '-' }}</span>
                                                    </td>
                                                    <td>
                                                        <p>Tyre Type</p>
                                                        <span class="text-secondary d-block">{{ $tyre->tyre_type ?? '-' }}</span>
                                                    </td>
                                                    <td>
                                                        <p>Tyre Condition</p>
                                                        <span class="text-secondary d-block">{{ $tyre->tyre_condition ?? '-' }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <p>Tyre Brand</p>
                                                        <span class="text-secondary d-block">{{ $tyre->tyre_brand ?? '-' }}</span>
                                                    </td>
                                                    <td>
                                                        <p>Tyre Model</p>
                                                        <span class="text-secondary d-block">{{ $tyre->tyre_model ?? '-' }}</span>
                                                    </td>
                                                    <td>
                                                        <p>Tyre Vendor</p>
                                                        <span class="text-secondary d-block">{{ $tyre->tyrevendor?->contact_name ?? '-' }}</span>
                                                    </td>
                                                    <td>
                                                        <p>Tyre Source</p>
                                                        <span class="text-secondary d-block">
                                                            @if($tyre->tyre_source_mode === 'Fitment') Direct Fitment
                                                            @elseif($tyre->tyre_source_mode) SR Garage
                                                            @else -
                                                            @endif
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <p>Tyre Price</p>
                                                        <span class="text-secondary d-block">{{ $tyre->tyre_price ? '₹' . number_format($tyre->tyre_price, 2) : '-' }}</span>
                                                    </td>
                                                    <td>
                                                        <p>Tyre Purchase Date</p>
                                                        <span class="text-secondary d-block">{{ $tyre->tyre_purchase_date ? \Carbon\Carbon::parse($tyre->tyre_purchase_date)->format('d/m/Y') : '-' }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <p>Warranty Period</p>
                                                        <span class="text-secondary d-block">{{ $tyre->tyre_warranty_months ? $tyre->tyre_warranty_months . ' months' : '-' }}</span>
                                                    </td>
                                                    <td>
                                                        <p>Remaining Warranty (months)</p>
                                                        <span class="text-secondary d-block">
                                                            @if($remainingWarrantyMonths !== null)
                                                                @if($remainingWarrantyMonths > 0)
                                                                    <span class="badge badge-success">{{ round($remainingWarrantyMonths, 1) }} months</span>
                                                                @else
                                                                    <span class="badge badge-danger">Expired</span>
                                                                @endif
                                                            @else
                                                                -
                                                            @endif
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <p>Tyre RAG Status</p>
                                                        <span class="text-secondary d-block">
                                                            <span class="badge {{ $ragClass }}">{{ $ragStatus }}</span>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <p>Tyre Life Remaining %</p>
                                                        <span class="text-secondary d-block">{{ $tyreLifeInfo['life_percent'] ?? '-' }} ({{ $tyreLifeInfo['life_text'] ?? '-' }})</span>
                                                    </td>
                                                    <td>
                                                        <p>Tyre Fixed Run KM</p>
                                                        <span class="text-secondary d-block">{{ $tyre->fixed_run_km ? number_format($tyre->fixed_run_km) : '-' }}</span>
                                                    </td>
                                                    <td>
                                                        <p>Tyre Actual Run KM</p>
                                                        <span class="text-secondary d-block">{{ $tyre->actual_run_km ? number_format($tyre->actual_run_km) : '-' }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <p>Tyre Remaining Run KM</p>
                                                        <span class="text-secondary d-block">
                                                            @if($tyre->fixed_run_km && $tyre->actual_run_km !== null)
                                                                {{ number_format($tyre->fixed_run_km - $tyre->actual_run_km) }}
                                                            @else
                                                                -
                                                            @endif
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <p>Tyre Fixed Life (months)</p>
                                                        <span class="text-secondary d-block">{{ $tyre->fixed_life_months ?? '-' }}</span>
                                                    </td>
                                                    <td>
                                                        <p>Tyre Actual Run (months)</p>
                                                        <span class="text-secondary d-block">{{ $tyre->actual_run_month ?? '-' }}</span>
                                                    </td>
                                                    <td>
                                                        <p>Tyre Remaining Life (months)</p>
                                                        <span class="text-secondary d-block">
                                                            @if($tyre->fixed_life_months && $tyre->actual_run_month !== null)
                                                                {{ $tyre->fixed_life_months - $tyre->actual_run_month }}
                                                            @else
                                                                -
                                                            @endif
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <p>Wheel Alignment Interval KM
                                                            @if($tyre->set_reminder_for_alignment === 'Yes')
                                                                <span class="tyre-reminder-badge"><i class="uil uil-bell"></i> Reminder ON</span>
                                                            @endif
                                                        </p>
                                                        <span class="text-secondary d-block">{{ $tyre->alignment_interval_km ? number_format($tyre->alignment_interval_km) : '-' }}</span>
                                                    </td>
                                                    <td>
                                                        <p>Tyre Rotation Interval KM
                                                            @if($tyre->set_reminder_for_rotation === 'Yes')
                                                                <span class="tyre-reminder-badge"><i class="uil uil-bell"></i> Reminder ON</span>
                                                            @endif
                                                        </p>
                                                        <span class="text-secondary d-block">{{ $tyre->rotation_interval_km ? number_format($tyre->rotation_interval_km) : '-' }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <p>Last Wheel Alignment KM</p>
                                                        <span class="text-secondary d-block">{{ $tyre->last_alignment_km ? number_format($tyre->last_alignment_km) : '-' }}</span>
                                                    </td>
                                                    <td>
                                                        <p>Last Tyre Rotation KM</p>
                                                        <span class="text-secondary d-block">{{ $tyre->last_rotation_km ? number_format($tyre->last_rotation_km) : '-' }}</span>
                                                    </td>
                                                    <td colspan="4"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- /ACCORDION 1 --}}

                        {{-- ══════════════════════════════════════════
                             ACCORDION 2 — READY TO USE
                        ══════════════════════════════════════════ --}}
                        <div class="accordion-item mt-2">
                            <div class="accordion-header vehicleinfor_head" id="acc_head_2">
                                <div class="row vehicleinfo_toprow align-items-center">
                                    <div class="col-12 col-md-11 d-flex align-items-center">
                                        <span class="titletext">Ready To Use</span>
                                        @if($tyre->tyre_status === 'Ready to Use')
                                            <span class="badge badge-success ms-2">Active</span>
                                        @endif
                                    </div>
                                    <div class="col-12 col-md-1">
                                        <button class="accordion-button filter-options collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#acc_body_2"
                                            aria-expanded="false" aria-controls="acc_body_2">
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div id="acc_body_2" class="accordion-collapse collapse" aria-labelledby="acc_head_2">
                                <div class="accordion-body">
                                    <div class="table-responsive table-responsive02">
                                        <table class="table tyre-info-table">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <p>Ready to Use Since</p>
                                                        <span class="text-secondary d-block">{{ $tyre->ready_to_use_since ? \Carbon\Carbon::parse($tyre->ready_to_use_since)->format('d/m/Y') : '-' }}</span>
                                                    </td>
                                                    <td colspan="5"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- /ACCORDION 2 --}}

                        {{-- ══════════════════════════════════════════
                             ACCORDION 3 — WARRANTY CLAIM TYRE
                        ══════════════════════════════════════════ --}}
                        <div class="accordion-item mt-2">
                            <div class="accordion-header vehicleinfor_head" id="acc_head_3">
                                <div class="row vehicleinfo_toprow align-items-center">
                                    <div class="col-12 col-md-11 d-flex align-items-center">
                                        <span class="titletext">Warranty Claim Tyre</span>
                                        @if($tyre->tyre_status === 'Warranty Claim')
                                            <span class="badge badge-warning ms-2">Active</span>
                                        @endif
                                    </div>
                                    <div class="col-12 col-md-1">
                                        <button class="accordion-button filter-options collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#acc_body_3"
                                            aria-expanded="false" aria-controls="acc_body_3">
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div id="acc_body_3" class="accordion-collapse collapse" aria-labelledby="acc_head_3">
                                <div class="accordion-body">
                                    @php
                                        $warrantyOverdue = $tyre->warranty_expected_closure_date
                                            && \Carbon\Carbon::parse($tyre->warranty_expected_closure_date)->isPast();
                                    @endphp
                                    @if($warrantyOverdue)
                                        <div class="alert alert-danger tyre-overdue-alert py-2 mb-3">
                                            <i class="uil uil-exclamation-triangle me-1"></i>
                                            <strong>Overdue!</strong> Expected closure date has passed
                                            ({{ \Carbon\Carbon::parse($tyre->warranty_expected_closure_date)->format('d/m/Y') }}).
                                        </div>
                                    @endif
                                    <div class="table-responsive table-responsive02">
                                        <table class="table tyre-info-table">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <p>Tyre Location</p>
                                                        <span class="text-secondary d-block">{{ $tyre->warranty_location ?? '-' }}</span>
                                                    </td>
                                                    <td>
                                                        <p>Warranty Claim Raised Date</p>
                                                        <span class="text-secondary d-block">{{ $tyre->warranty_claim_date ? \Carbon\Carbon::parse($tyre->warranty_claim_date)->format('d/m/Y') : '-' }}</span>
                                                    </td>
                                                    <td>
                                                        <p>Expected Closure Date</p>
                                                        <span class="text-secondary d-block">
                                                            @if($tyre->warranty_expected_closure_date)
                                                                {{ \Carbon\Carbon::parse($tyre->warranty_expected_closure_date)->format('d/m/Y') }}
                                                                @if($warrantyOverdue)
                                                                    <span class="badge badge-danger ms-1">Overdue</span>
                                                                @endif
                                                            @else
                                                                -
                                                            @endif
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <p>Warranty Claim Number</p>
                                                        <span class="text-secondary d-block">{{ $tyre->warranty_claim_number ?? '-' }}</span>
                                                    </td>
                                                    <td>
                                                        <p>Warranty Claim Reason</p>
                                                        <span class="text-secondary d-block">{{ $tyre->warranty_claim_reason ?? '-' }}</span>
                                                    </td>
                                                    <td>
                                                        <p>Warranty Claim Amount</p>
                                                        <span class="text-secondary d-block">{{ $tyre->warranty_claim_amount ? '₹' . number_format($tyre->warranty_claim_amount, 2) : '-' }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <p>Refund Payment UTR Number</p>
                                                        <span class="text-secondary d-block">{{ $tyre->warranty_utr ?? '-' }}</span>
                                                    </td>
                                                    <td colspan="5"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- /ACCORDION 3 --}}

                        {{-- ══════════════════════════════════════════
                             ACCORDION 4 — THREADING TYRE
                        ══════════════════════════════════════════ --}}
                        <div class="accordion-item mt-2">
                            <div class="accordion-header vehicleinfor_head" id="acc_head_4">
                                <div class="row vehicleinfo_toprow align-items-center">
                                    <div class="col-12 col-md-11 d-flex align-items-center">
                                        <span class="titletext">Threading Tyre</span>
                                        @if($tyre->tyre_status === 'Re-threading')
                                            <span class="badge badge-info ms-2">Active</span>
                                        @endif
                                    </div>
                                    <div class="col-12 col-md-1">
                                        <button class="accordion-button filter-options collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#acc_body_4"
                                            aria-expanded="false" aria-controls="acc_body_4">
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div id="acc_body_4" class="accordion-collapse collapse" aria-labelledby="acc_head_4">
                                <div class="accordion-body">
                                    <div class="table-responsive table-responsive02">
                                        <table class="table tyre-info-table">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <p>Tyre Location</p>
                                                        <span class="text-secondary d-block">{{ $tyre->rethreading_location ?? '-' }}</span>
                                                    </td>
                                                    <td>
                                                        <p>Re-threading Vendor</p>
                                                        <span class="text-secondary d-block">{{ $tyre->rethreadingVendor?->contact_name ?? '-' }}</span>
                                                    </td>
                                                    <td>
                                                        <p>Sent for Re-threading Date</p>
                                                        <span class="text-secondary d-block">{{ $tyre->rethreading_sent_date ? \Carbon\Carbon::parse($tyre->rethreading_sent_date)->format('d/m/Y') : '-' }}</span>
                                                    </td>
                                                    <td>
                                                        <p>Expected Closure Date</p>
                                                        <span class="text-secondary d-block">
                                                            @if($tyre->rethreading_expected_date)
                                                                {{ \Carbon\Carbon::parse($tyre->rethreading_expected_date)->format('d/m/Y') }}
                                                                @if(\Carbon\Carbon::parse($tyre->rethreading_expected_date)->isPast())
                                                                    <span class="badge badge-danger ms-1">Overdue</span>
                                                                @endif
                                                            @else
                                                                -
                                                            @endif
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <p>Re-threading Cost</p>
                                                        <span class="text-secondary d-block">{{ $tyre->rethreading_cost ? '₹' . number_format($tyre->rethreading_cost, 2) : '-' }}</span>
                                                    </td>
                                                    <td></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- /ACCORDION 4 --}}

                        {{-- ══════════════════════════════════════════
                             ACCORDION 5 — SCRAP TYRE
                        ══════════════════════════════════════════ --}}
                        <div class="accordion-item mt-2">
                            <div class="accordion-header vehicleinfor_head" id="acc_head_5">
                                <div class="row vehicleinfo_toprow align-items-center">
                                    <div class="col-12 col-md-11 d-flex align-items-center">
                                        <span class="titletext">Scrap Tyre</span>
                                        @if($tyre->tyre_status === 'Scrap')
                                            <span class="badge badge-danger ms-2">Active</span>
                                        @endif
                                    </div>
                                    <div class="col-12 col-md-1">
                                        <button class="accordion-button filter-options collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#acc_body_5"
                                            aria-expanded="false" aria-controls="acc_body_5">
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div id="acc_body_5" class="accordion-collapse collapse" aria-labelledby="acc_head_5">
                                <div class="accordion-body">
                                    <div class="table-responsive table-responsive02">
                                        <table class="table tyre-info-table">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <p>Tyre Location</p>
                                                        <span class="text-secondary d-block">{{ $tyre->scrap_location ?? '-' }}</span>
                                                    </td>
                                                    <td>
                                                        <p>Last Fitted Vehicle</p>
                                                        <span class="text-secondary d-block">{{ $tyre->lastFittedVehicle?->basicinfo?->vehicle_number ?? '-' }}</span>
                                                    </td>
                                                    <td>
                                                        <p>Scrap Sent Date</p>
                                                        <span class="text-secondary d-block">{{ $tyre->scrap_sent_date ? \Carbon\Carbon::parse($tyre->scrap_sent_date)->format('d/m/Y') : '-' }}</span>
                                                    </td>
                                                    <td>
                                                        <p>Scrap Reason</p>
                                                        <span class="text-secondary d-block">{{ $tyre->scrap_reason ?? '-' }}</span>
                                                    </td>
                                                    <td>
                                                        <p>Scrap Vendor</p>
                                                        <span class="text-secondary d-block">{{ $tyre->scrapVendor?->contact_name ?? '-' }}</span>
                                                    </td>
                                                    <td>
                                                        <p>Scrap Income</p>
                                                        <span class="text-secondary d-block">{{ $tyre->scrap_income ? '₹' . number_format($tyre->scrap_income, 2) : '-' }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <p>Income Received UTR</p>
                                                        <span class="text-secondary d-block">{{ $tyre->scrap_utr ?? '-' }}</span>
                                                    </td>
                                                    <td colspan="5"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- /ACCORDION 5 --}}

                        {{-- ══════════════════════════════════════════
                             ACCORDION 6 — ALLOCATE TYRE
                        ══════════════════════════════════════════ --}}
                        <div class="accordion-item mt-2">
                            <div class="accordion-header vehicleinfor_head" id="acc_head_6">
                                <div class="row vehicleinfo_toprow align-items-center">
                                    <div class="col-12 col-md-11 d-flex align-items-center">
                                        <span class="titletext">Allocate Tyre</span>
                                        @if($tyre->location === 'Vehicle')
                                            <span class="badge badge-success ms-2">On Vehicle</span>
                                        @endif
                                    </div>
                                    <div class="col-12 col-md-1">
                                        <button class="accordion-button filter-options collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#acc_body_6"
                                            aria-expanded="false" aria-controls="acc_body_6">
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div id="acc_body_6" class="accordion-collapse collapse" aria-labelledby="acc_head_6">
                                <div class="accordion-body">
                                    <div class="table-responsive table-responsive02">
                                        <table class="table tyre-info-table">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <p>Vehicle Number</p>
                                                        <span class="text-secondary d-block">{{ $tyre->allocatedVehicle?->basicinfo?->vehicle_number ?? '-' }}</span>
                                                    </td>
                                                    <td>
                                                        <p>Tyre Position</p>
                                                        <span class="text-secondary d-block">{{ $tyre->activeVehicleMapping?->tyreposition?->code ?? '-' }}</span>
                                                    </td>
                                                    <td>
                                                        <p>Tyre Fitment Date</p>
                                                        <span class="text-secondary d-block">{{ $tyre->installation_date ? \Carbon\Carbon::parse($tyre->installation_date)->format('d/m/Y') : '-' }}</span>
                                                    </td>
                                                    <td>
                                                        <p>Tyre Source</p>
                                                        <span class="text-secondary d-block">
                                                            @if($tyre->tyre_source_mode === 'Fitment') Direct Fitment
                                                            @elseif($tyre->tyre_source_mode) SR Garage
                                                            @else -
                                                            @endif
                                                        </span>
                                                    </td>
                                                    <td colspan="2"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- /ACCORDION 6 --}}

                        {{-- ══════════════════════════════════════════
                             ACCORDION 7 — YET TO DECIDE
                        ══════════════════════════════════════════ --}}
                        <div class="accordion-item mt-2">
                            <div class="accordion-header vehicleinfor_head" id="acc_head_7">
                                <div class="row vehicleinfo_toprow align-items-center">
                                    <div class="col-12 col-md-11 d-flex align-items-center">
                                        <span class="titletext">Yet To Decide</span>
                                        @if($tyre->tyre_status === 'Yet to Decide')
                                            <span class="badge badge-secondary ms-2">Pending Decision</span>
                                        @endif
                                    </div>
                                    <div class="col-12 col-md-1">
                                        <button class="accordion-button filter-options collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#acc_body_7"
                                            aria-expanded="false" aria-controls="acc_body_7">
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div id="acc_body_7" class="accordion-collapse collapse" aria-labelledby="acc_head_7">
                                <div class="accordion-body">
                                    <div class="table-responsive table-responsive02">
                                        <table class="table tyre-info-table">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <p>Tyre Location</p>
                                                        <span class="text-secondary d-block">{{ $tyre->location ?? '-' }}</span>
                                                    </td>
                                                    <td>
                                                        <p>Tyre Damage Reason</p>
                                                        <span class="text-secondary d-block">{{ $tyre->damage_reason ?? '-' }}</span>
                                                    </td>
                                                    <td>
                                                        <p>Change Status</p>
                                                        <span class="text-secondary d-block">
                                                            @if($tyre->tyre_status === 'Yet to Decide')
                                                                <select class="form-select form-select-sm ytd-change-status"
                                                                    style="max-width:200px;"
                                                                    data-tyre-id="{{ $tyre->id }}"
                                                                    data-url="{{ route('tyre.changeStatus', $tyre->id) }}">
                                                                    <option value="">-- Move To --</option>
                                                                    <option value="Warranty Claim">Warranty Claim</option>
                                                                    <option value="Re-threading">Re-threading (Threading)</option>
                                                                    <option value="Scrap">Scrap</option>
                                                                </select>
                                                            @else
                                                                <span class="text-muted">N/A — Tyre is not in Yet to Decide status</span>
                                                            @endif
                                                        </span>
                                                    </td>
                                                    <td colspan="3"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- /ACCORDION 7 --}}

                    </div>
                    {{-- /tyre-detail-accordion --}}

                </div>
            </div>
    
            <div class="vehicle-itemtab pt-4">
                <div class="container-fluid">
                    
                    <ul class="nav nav-tabs item-box">
                        <li class="nav-item">
                            <button class="nav-link nav_click active" data-bs-toggle="tab" data-bs-target="#vehicle">
                                <span class="icon"><img src="{{ asset('images/icons/car-icon04.png') }}" alt="" /></span>
                                Allocated Vehicle
                            </button>
                        </li>
                        
                        <li class="nav-item">
                            <button class="nav-link nav_click" data-bs-toggle="tab" data-bs-target="#maintenance">
                                <span class="icon"><img src="{{ asset('images/icons/maintenance-icon.png') }}" alt="" /></span>
                                Maintenance
                            </button>
                        </li>
    
                        <li class="nav-item">
                            <button class="nav-link nav_click" data-bs-toggle="tab" data-bs-target="#documents">
                                <span class="icon"><img src="{{ asset('images/icons/documents-icon.png') }}" alt="" /></span>
                                Document
                            </button>
                        </li>
    
                        <li class="nav-item">
                            <button class="nav-link nav_click" data-bs-toggle="tab" data-bs-target="#comment">
                                <span class="icon"><img src="{{ asset('images/icons/comments-0123.png') }}" alt="" /></span>
                                Comments
                            </button>
                        </li>
                    </ul>
    
                    <!-- Tab Content -->
                    <div class="tab-content mt-3">
                        
                        <div class="tab-pane fade show active" id="vehicle">
    
                            <div class="accordion mt-3" id="accordionExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button
                                            class="accordion-button filter-options"
                                            type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#collapseOne"
                                            aria-expanded="true"
                                            aria-controls="collapseOne"
                                        >
                                            <div class="item-filter">
                                                <span class="filter-icon">
                                                    <img src="{{ asset('images/icons/filter-01icon.png') }}" alt="icon" />
                                                </span>
                                                <p>Filter Options</p>
                                            </div>
                                        </button>
                                    </h2>
    
                                    <div
                                        id="collapseOne"
                                        class="accordion-collapse collapse show"
                                        aria-labelledby="headingOne"
                                        data-bs-parent="#accordionExample"
                                    >
                                        <div class="accordion-body">
                                            <form class="vehicle_dform">
                                                <div class="filtersearch-bd justify-content-between">
                                                    <div class="vehicletype">
                                                        <label>Start Date - End Date</label>
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            name="daterange"
                                                            placeholder="Select date range..."
                                                        />
                                                    </div>
    
                                                    <div class="vehicletype ms-1">
                                                        <label> Status</label>
                                                        <select class="form-select">
                                                            <option>Choose..</option>
                                                            <option>Initiated</option>
                                                            <option>On Going</option>
                                                            <option>Completed</option>
                                                        </select>
                                                    </div>
    
                                                </div>
    
                                                <div class="filtersearch-bd searchfield justify-content-start mt-3">
                                                    <div class="ms-1" style="width: 220px">
                                                        <div class="input-group">
                                                            <input
                                                                type="text"
                                                                class="form-control"
                                                                placeholder="Search by Vehicle Number"
                                                            />
                                                            <span class="input-group-text"
                                                                ><i class="uil uil-search"></i
                                                            ></span>
                                                        </div>
                                                    </div>
    
                                                    <div class="ms-1" style="width: 220px">
                                                        <div class="input-group">
                                                            <input
                                                                type="text"
                                                                class="form-control"
                                                                placeholder="Search by Driver"
                                                            />
                                                            <span class="input-group-text"
                                                                ><i class="uil uil-search"></i
                                                            ></span>
                                                            <!--<span class="input-group-text"><i class="uil uil-sync me-1"></i></span>-->
                                                        </div>
                                                    </div>
                                                    
                                                    <button class="btn btn-primary ms-1" type="button">
                                                        <i class="uil uil-sync me-1"></i>Reset
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
    
                            <!---->
                            <div class="vehiclestable">
                                <div class="itemtop">
                                    <span class="sec-title">Allocated Vehicle List</span>
                                    <!--<a href="#" class="addtripbtn" data-bs-toggle="modal" data-bs-target="#addTrip">-->
                                    <!--    <i class="uil uil-plus me-1"></i>Add Trip</a>-->
                                </div>
                                
                                <div class="table-responsive">
                                    <table class="table custom-driver-table trip-table">
                                        <thead>
                                            <tr>
                                                <th>Vehicle Number</th>
                                                <th>Start Date & Time</th>
                                                <th>End Date & Time</th>
                                                <th>Driver</th>
                                                <!--<th class="text-center">Actions</th>-->
                                            </tr>
                                        </thead>
                                
                                        <tbody>
                                            <!-- Row 1 -->
                                            <tr>
                                                <td>WB-23AB-3211</td>
                                                <td>19-09-2025 | 12:00 PM</td>
                                                <td>-</td>
                                                <td>Sujit Paul</td>
                                                <!--<td class="text-center">-->
                                                <!--    <a class="item-edit text-success" data-bs-toggle="modal" data-bs-target="#addTrip"><i class="uil uil-pen me-2"></i></a>-->
                                                <!--    <a class="item-delete text-danger"><i class="uil uil-trash-alt"></i></a>-->
                                                <!--</td>-->
                                            </tr>
                                            <tr>
                                                <td>WB-23AB-3222</td>
                                                <td>19-09-2025 | 12:00 PM</td>
                                                <td>25-09-2025 | 12:00 PM</td>
                                                <td>Sujit Paul</td>
                                                <!--<td class="text-center">-->
                                                <!--    <a class="item-edit text-success" data-bs-toggle="modal" data-bs-target="#addTrip"><i class="uil uil-pen me-2"></i></a>-->
                                                <!--    <a class="item-delete text-danger"><i class="uil uil-trash-alt"></i></a>-->
                                                <!--</td>-->
                                            </tr>
                                            <tr>
                                                <td>WB-23AB-3224</td>
                                                <td>19-09-2025 | 12:00 PM</td>
                                                <td>25-09-2025 | 12:00 PM</td>
                                                <td>Sujit Paul</td>
                                                <!--<td class="text-center">-->
                                                <!--    <a class="item-edit text-success" data-bs-toggle="modal" data-bs-target="#addTrip"><i class="uil uil-pen me-2"></i></a>-->
                                                <!--    <a class="item-delete text-danger"><i class="uil uil-trash-alt"></i></a>-->
                                                <!--</td>-->
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!---->
                            
                        </div>
                        <!--Trip-Book-content-here-END-->
                        
                        <!--Maintenance-content-here-->
                        <div class="tab-pane fade" id="maintenance">
                            <div class="totalrevenue mt-3">
                                <div class="item-row">
                                    <div class="itemcol">
                                        <p>Total Scheduled</p>
                                        <span class="number c-01">1</span>
                                    </div>
    
                                    <div class="itemcol">
                                        <p>Overdue</p>
                                        <span class="number c-02">0</span>
                                    </div>
    
                                    <div class="itemcol">
                                        <p>Due Next Month</p>
                                        <span class="number c-03">₹0</span>
                                    </div>
    
                                    <div class="itemcol">
                                        <p>Up to Date</p>
                                        <span class="number c-04">₹0</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mt-4">
                                <div class="col-12 col-md-8">
                                    <ul class="nav nav-pills" id="pills-tab" role="tablist">
                                      <li class="nav-item" role="presentation">
                                        <button class="nav-link active mb-0" id="pills-maint-tab" data-bs-toggle="pill" data-bs-target="#pills-maint" type="button" role="tab" aria-controls="pills-maint" aria-selected="true">Maintenance</button>
                                      </li>
                                      <li class="nav-item" role="presentation">
                                        <button class="nav-link mb-0" id="pills-repair-tab" data-bs-toggle="pill" data-bs-target="#pills-repair" type="button" role="tab" aria-controls="pills-repair" aria-selected="false">Repair</button>
                                      </li>
                                    </ul>
                                </div>
                                <div class="col-12 col-md-4 text-end">
                                    <a
                                        href="javascript:void(0)"
                                        class="btn btn-primary"
                                        data-bs-toggle="modal"
                                        data-bs-target="#add05_maintenance"
                                        ><i class="uil uil-plus me-1"></i> Schedule Maintenance</a
                                    >
                                </div>
                            </div>
                            
                            
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-maint" role="tabpanel" aria-labelledby="pills-maint-tab">
                                    <div class="vehiclestable">
                                        <div class="itemtop">
                                            <span class="sec-title">Scheduled Maintenance</span>
                                        </div>
                                        
                                        <div class="table-responsive">
                                            <table class="table custom-driver-table">
                                                <thead>
                                                    <tr>
                                                        <th>Maintenance Item</th>
                                                        <th>Last Date</th>
                                                        <th>Next Due</th>
                                                        <th>Odometer (KM)</th>
                                                        <th>Status</th>
                                                        <th class="text-center">Actions</th>
                                                    </tr>
                                                </thead>
                                        
                                                <tbody>
                                                    @forelse($maintenanceSchedules as $ms)
                                                    <tr id="maint-row-{{ $ms->id }}">
                                                        <td>{{ $ms->maintenance_item }}</td>
                                                        <td>{{ $ms->last_done_date ? $ms->last_done_date->format('d-m-Y') : '—' }}</td>
                                                        <td>{{ $ms->next_due_date ? $ms->next_due_date->format('d-m-Y') : '—' }}</td>
                                                        <td>{{ $ms->odometer_km ? number_format($ms->odometer_km) : '—' }}</td>
                                                        <td>
                                                            @php
                                                                $badgeMap = [
                                                                    'Scheduled' => 'badge-primary',
                                                                    'Pending'   => 'badge-warning',
                                                                    'Done'      => 'badge-success',
                                                                    'Overdue'   => 'badge-danger',
                                                                ];
                                                            @endphp
                                                            <span class="badge {{ $badgeMap[$ms->status] ?? 'badge-secondary' }}">
                                                                {{ $ms->status }}
                                                            </span>
                                                        </td>
                                                        <td class="text-center">
                                                            <a href="javascript:void(0)"
                                                               class="item-edit text-success maint-edit-btn"
                                                               title="Edit"
                                                               data-id="{{ $ms->id }}"
                                                               data-item="{{ $ms->maintenance_item }}"
                                                               data-last="{{ $ms->last_done_date ? $ms->last_done_date->format('Y-m-d') : '' }}"
                                                               data-next="{{ $ms->next_due_date ? $ms->next_due_date->format('Y-m-d') : '' }}"
                                                               data-odometer="{{ $ms->odometer_km }}"
                                                               data-status="{{ $ms->status }}"
                                                               data-notes="{{ $ms->notes }}"
                                                               data-update-url="{{ route('tyre.maintenance.update', [$tyre->id, $ms->id]) }}">
                                                                <i class="uil uil-pen me-2"></i>
                                                            </a>
                                                            <a href="javascript:void(0)"
                                                               class="item-delete text-danger maint-delete-btn"
                                                               title="Delete"
                                                               data-id="{{ $ms->id }}"
                                                               data-delete-url="{{ route('tyre.maintenance.destroy', [$tyre->id, $ms->id]) }}">
                                                                <i class="uil uil-trash-alt"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    @empty
                                                    <tr id="maint-empty-row">
                                                        <td colspan="6" class="text-center text-muted py-4">
                                                            <i class="uil uil-calendar-slash fs-4 d-block mb-1"></i>
                                                            No maintenance schedules yet. Click <strong>Schedule Maintenance</strong> to add one.
                                                        </td>
                                                    </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-repair" role="tabpanel" aria-labelledby="pills-repair-tab">
                                  <div class="vehiclestable">
                                        <div class="itemtop">
                                            <span class="sec-title">Scheduled Repair</span>
                                        </div>
                                        
                                        <div class="table-responsive">
                                            <table class="table custom-driver-table">
                                                <thead>
                                                    <tr>
                                                        <th>Repair Item</th>
                                                        <th>Repair Type</th>
                                                        <th>Repair Start Date</th>
                                                        <th>Expected Closure Date</th>
                                                        <th>Actual Closure Date</th>
                                                        <th>Workshop Name</th>
                                                        <th>Workshop Location</th>
                                                        <th>Odometer (KM)</th>
                                                        <th>Status</th>
                                                        <th class="text-center">Actions</th>
                                                    </tr>
                                                </thead>
                                        
                                                <tbody>
                                                    <tr>
                                                        <td>Hub Greasing</td>
                                                        <td>Major</td>
                                                        <td>27-08-2025</td>
                                                        <td>30-08-2025</td>
                                                        <td>02-09-2025</td>
                                                        <td>Joshan LLP</td>
                                                        <td>Hydrabad</td>
                                                        <td>420</td>
                                                        <td><span class="badge badge-warning">Pending</span></td>
                                                        <td class="text-center">
                                                            <a class="item-edit text-success">
                                                                <i class="uil uil-pen me-2"></i>
                                                            </a>
                                                            <a class="item-delete text-danger">
                                                                <i class="uil uil-trash-alt"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
    
                            
                        </div>
                        <!--Maintenance-content-here-->
    
                        <!--Documents-content-here-Start-->
                        <div class="tab-pane fade" id="documents">
                            <div class="totalrevenue mt-3">
                                <div class="item-row">
                                    <div class="itemcol">
                                        <p>Total Document</p>
                                        <span class="number c-01">{{ $total_doc_count }}</span>
                                    </div>
    
                                    <div class="itemcol">
                                        <p>Expired</p>
                                        <span class="number c-02">{{ $expired_doc_count }}</span>
                                    </div>
    
                                    <div class="itemcol">
                                        <p>Expiring Soon</p>
                                        <span class="number c-03">{{ $expiring_doc_count }}</span>
                                    </div>
    
                                    <div class="itemcol">
                                        <p>Valid</p>
                                        <span class="number c-04">{{ $total_doc_count - $expired_doc_count }}</span>
                                    </div>
                                </div>
                            </div>
    
                            <div class="vehiclestable">
                                <div class="itemtop">
                                    <span class="sec-title">Tyre Documents</span>
                                    <a
                                        href="#"
                                        class="addtripbtn"
                                        data-bs-toggle="modal"
                                        data-bs-target="#add06_documents"
                                    >
                                        <i class="uil uil-plus me-1"></i> Documents</a
                                    >
                                </div>
                                
                                <div class="table-responsive">
                                    <table class="table custom-driver-table">
                                        <thead>
                                            <tr>
                                                <th style="min-width: 120px">Documents Type</th>
                                                <th style="min-width: 120px">Documents Number</th>
                                                <th>Issue Date</th>
                                                <th>Expiry Date</th>
                                                <th>Status</th>
                                                <th>Notes</th>
                                                <th class="text-center">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($mediadocuments as $mediadocument)
                                                @php
                                                    $medias = $mediadocument->medias;
                                                    $files = $medias->map(function ($media) {
                                                                    $media->url = asset('medias/' . $media->file_path);
                                                                    $media->delete_url = route('tyre.document.destroy', $media->id);
                                                                    return $media;
                                                                });
                                                @endphp
                                                <tr>
                                                    <td>
                                                        <span class="value">{{ $mediadocument->attachmenttype->name }}</span>
                                                    </td>
                                                    
                                                    <td><span class="value">{{ $mediadocument->document_number }}</span></td>
                                                    
                                                    <td><span class="value">{{ date('d/m/Y', strtotime($mediadocument->issue_date)) }}</span></td>
                                                    
                                                    <td><span class="value">{{ $mediadocument->expiry_date ? date('d/m/Y', strtotime($mediadocument->expiry_date)) : '-' }}</span></td>
                                                    
                                                    <td>
                                                        @if($mediadocument->expiry_date)
                                                            @if(date('Y-m-d', strtotime($mediadocument->expiry_date)) > date('Y-m-d', strtotime('+10days')))
                                                                <span class="badge badge-success">Active</span>
                                                            @elseif(date('Y-m-d', strtotime($mediadocument->expiry_date)) >= date('Y-m-d'))
                                                                <span class="badge badge-warning">Expiring Soon</span>
                                                            @else
                                                                <span class="badge badge-danger">Expired</span>
                                                            @endif
                                                        @else
                                                            <span class="badge badge-secondary">N/A</span>
                                                        @endif
                                                    </td>
                                                    
                                                    <td>
                                                        <span class="value">
                                                            @if(!empty($mediadocument->notes))
                                                                {{ \Illuminate\Support\Str::limit($mediadocument->notes, 20, '...') }}
                                                        
                                                                @if(strlen($mediadocument->notes) > 20)
                                                                    <a href="javascript:void(0)" 
                                                                        class="showMore"
                                                                        data-bs-toggle="modal" 
                                                                        data-bs-target="#modalNotes"
                                                                        data-notes="{{ $mediadocument->notes }}">
                                                                       <i class="me-1 uil uil-eye"></i>
                                                                    </a>
                                                                @endif
                                                            @else
                                                                N/A
                                                            @endif
                                                        </span>
                                                    </td>
            
                                                    <td class="text-center">
                                                        <a class="text-info view-files" data-files='@json($files)'><i class="uil uil-document-info"></i></a>
                                                        <a class="item-edit text-success" 
                                                            data-url="{{ route('tyre.document.update', $mediadocument->id) }}" 
                                                            
                                                            data-attachment_type="{{ $mediadocument->attachmenttype->name }}"
                                                            data-document_number="{{ $mediadocument->document_number }}"
                                                            data-issue_date="{{ \Carbon\Carbon::parse($mediadocument->issue_date)->format('d/m/Y') }}"
                                                            data-expiry_date="{{ $mediadocument->expiry_date ? \Carbon\Carbon::parse($mediadocument->expiry_date)->format('d/m/Y') : '' }}"
                                                            data-notes="{{ $mediadocument->notes }}"
                                                            data-reminder_days="{{ $mediadocument->reminder_days ?? '' }}"
                                                            data-has_reminder="{{ $mediadocument->set_reminder }}"
    
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#edit_documents">
                                                            <i class="uil uil-pen me-2"></i>
                                                        </a>
                                                        <!--<a class="item-delete text-danger"><i class="uil uil-trash-alt"></i></a>-->
                                                    </td>
                                                </tr>
                                            @empty
                                            @endforelse
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                            
                        </div>
                        <!--Documents-content-here-End-->
    
                        <!--comment-->
                        <div class="tab-pane fade vdtl_comment1sec" id="comment">
                            <!--comment content here...-->
                            <div class="note-box">
                                <label for="noteInput" class="form-label"
                                    >Comments<i class="bi bi-info-circle"></i
                                ></label>
    
                                <form action="{{ route('tyre.comment.store', $tyre->id) }}" id="commentForm">
                                    <div class="note-input-wrapper">
                                        @csrf
                                        <div class="note-avatar">{{ Auth::user()->name[0] }}</div>
        
                                        <div class="note-input-area">
                                            <input type="text" id="noteInput" class="form-control" placeholder="Comments" name="comment" />
                                            <span class="text-danger error" id="comment_error"></span>
                                        </div>
        
                                        <button type="submit" class="note-send-btn submitBtn"><i class="bi bi-send"></i></button>
                                    </div>
                                </form>
    
                                <div class="text_bdwrapper">
                                    @forelse($comments as $comment)
                                        <div class="item_row">
                                            <div class="name_fw">{{ $comment->createdBy->name[0] }}</div>
                                            <div class="text_bd">
                                                <span>{{ $comment->createdBy->name }}</span>
                                                <p>{{ $comment->comment }}</p>
                                            </div>
                                            <div class="time_sec">
                                                {{ $comment->created_at->diffForHumans() }}
                                            </div>
                                        </div>
                                    @empty
                                    
                                    @endforelse
                                </div>
                            </div>
                        </div>
                        <!--comment-End-->
                    </div>
                </div>
            </div>
            <!--/////-->
        </div>

    </div>{{-- /.srlog-bdwrapper.v2-page --}}

</div>{{-- /.layout-wrapper --}}
    
    
<!-- ═══════════════════════════════════════════════════════════════════════
     Schedule Maintenance Modal  #add05_maintenance
     ═══════════════════════════════════════════════════════════════════════ -->
<div class="modal fade expenses_wrapperModal" id="add05_maintenance" tabindex="-1" aria-labelledby="maintModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">

            {{-- Header --}}
            <div class="modal-header">
                <h5 class="modal-title" id="maintModalLabel">
                    <i class="uil uil-wrench me-2"></i>
                    Schedule Maintenance &mdash;
                    <span class="text-muted fw-normal fs-6">{{ $tyre->tyre_serial_number }}</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="uil uil-times"></i>
                </button>
            </div>

            {{-- Body --}}
            <div class="modal-body">
                <form id="maintForm" method="POST"
                      action="{{ route('tyre.maintenance.store', $tyre->id) }}">
                    @csrf

                    {{-- Hidden: edit mode stores schedule id --}}
                    <input type="hidden" id="maint_schedule_id" value="">
                    <input type="hidden" id="maint_method_override" name="_method_override" value="store">

                    <div class="row g-3">

                        {{-- Maintenance Item --}}
                        <div class="col-12 col-md-6 form-group">
                            <label class="form-label">Maintenance Item <span class="text-danger">*</span></label>
                            <input type="text" id="maint_item" name="maintenance_item"
                                   class="form-control"
                                   placeholder="e.g. Hub Greasing, Rotation, Balancing"
                                   list="maint_item_suggestions">
                            <datalist id="maint_item_suggestions">
                                <option value="Hub Greasing">
                                <option value="Wheel Rotation">
                                <option value="Wheel Balancing">
                                <option value="Tyre Inflation Check">
                                <option value="Tread Depth Check">
                                <option value="Alignment Check">
                                <option value="Tyre Retreading">
                                <option value="Valve Replacement">
                                <option value="Visual Inspection">
                            </datalist>
                            <div class="text-danger small mt-1 d-none" id="maint_item_err"></div>
                        </div>

                        {{-- Status --}}
                        <div class="col-12 col-md-6 form-group">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select id="maint_status" name="status" class="form-select">
                                <option value="Scheduled" selected>Scheduled</option>
                                <option value="Pending">Pending</option>
                                <option value="Done">Done</option>
                                <option value="Overdue">Overdue</option>
                            </select>
                        </div>

                        {{-- Last Done Date --}}
                        <div class="col-12 col-md-4 form-group">
                            <label class="form-label">Last Done Date</label>
                            <input type="date" id="maint_last_done" name="last_done_date" class="form-control">
                        </div>

                        {{-- Next Due Date --}}
                        <div class="col-12 col-md-4 form-group">
                            <label class="form-label">Next Due Date</label>
                            <input type="date" id="maint_next_due" name="next_due_date" class="form-control">
                        </div>

                        {{-- Odometer --}}
                        <div class="col-12 col-md-4 form-group">
                            <label class="form-label">Odometer at Last Service (KM)</label>
                            <input type="number" id="maint_odometer" name="odometer_km"
                                   class="form-control" placeholder="e.g. 45000" min="0">
                        </div>

                        {{-- Notes --}}
                        <div class="col-12 form-group">
                            <label class="form-label">Notes</label>
                            <textarea id="maint_notes" name="notes" class="form-control"
                                      rows="3" placeholder="Any additional remarks..."></textarea>
                        </div>

                    </div>{{-- /row --}}

                </form>
            </div>{{-- /modal-body --}}

            {{-- Footer --}}
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="maintSaveBtn">
                    <span id="maintSaveBtnText">Save Schedule</span>
                    <span id="maintSaveBtnSpinner" class="spinner-border spinner-border-sm ms-1 d-none" role="status"></span>
                </button>
            </div>

        </div>
    </div>
</div>{{-- /#add05_maintenance --}}

<!-- Add Document Modal -->
<div class="modal fade expenses_wrapperModal" id="add06_documents" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Document</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="uil uil-times"></i>
                </button>
            </div>

            <div class="modal-body">
                <form action="{{ route('tyre.document.store', $tyre->id) }}" id="documentForm">
                    @csrf
                    <div class="row">
                        <div class="col-12 col-md-6 form-group">
                            <label>Tyre<span class="text-danger ms-1">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control bg-light" readonly value="{{ $tyre->tyre_serial_number }}" />
                            </div>
                        </div>

                        <div class="col-12 col-md-6 form-group">
                            <label>Document Type<span class="text-danger ms-1">*</span></label>
                            <select name="attachment_type" class="form-select" id="attachmenttype_dd">
                                <option value="">Search Document Type...</option>
                                @forelse($attachmenttypes as $attachmenttype)
                                    <option value="{{ $attachmenttype->name }}">{{ $attachmenttype->name }}</option>
                                @empty
                                @endforelse
                            </select>
                            <div class="error text-danger" id="document_attachment_type_error"></div>
                        </div>

                        <div class="col-12 col-md-6 form-group">
                            <label>Document Number</label>
                            <input type="text" class="form-control" name="document_number" placeholder="" />
                            <div class="error text-danger" id="document_document_number_error"></div>
                        </div>

                        <div class="col-12 col-md-6 form-group">
                            <label>Issue Date</label>
                            <div class="input-group">
                                <input class="date form-control" type="text" id="doc_issue_date" name="issue_date" readonly />

                                <span class="input-group-text">
                                    <i class="uil uil-calendar-alt"></i>
                                </span>
                            </div>
                            <div class="error text-danger" id="document_issue_date_error"></div>
                        </div>

                        <div class="col-12 col-md-6 form-group">
                            <label>Expiry Date<span class="text-danger ms-1"></span></label>
                            <div class="input-group">
                                <input class="date form-control" type="text" id="doc_expiry_date" name="expiry_date" readonly />
                                <span class="input-group-text">
                                    <i class="uil uil-calendar-alt"></i>
                                </span>
                            </div>
                            <div class="error text-danger" id="document_expiry_date_error"></div>
                        </div>

                        <div class="col-12 col-md-6 form-group">
                            <label>Upload File(s)<span class="text-danger ms-1">*</span></label>
                            <div class="dropzone" id="myDropzone">
                                <div class="dz-message needsclick">
                                    <i class="uil uil-upload me-2"></i>
                                    Drop files here or click to upload (Max 2 files)
                                </div>
                            </div>
                            <div class="error text-danger" id="document_files_error"></div>
                            <!--<div class="file_0attachment">-->
                                <!--<label for="formFile" class="form-label">File Attachment</label>-->

                            <!--    <div class="upload__box">-->
                            <!--        <div class="upload__btn-box">-->
                            <!--            <label class="upload__btn">-->
                            <!--                <p class="btn btn-theme mb-0">-->
                            <!--                    <i class="uil uil-plus me-1"></i>File Attachment-->
                            <!--                </p>-->
                            <!--                <input-->
                            <!--                    type="file"-->
                            <!--                    multiple=""-->
                            <!--                    data-max_length="20"-->
                            <!--                    class="upload__inputfile"-->
                            <!--                />-->
                            <!--            </label>-->
                            <!--        </div>-->
                            <!--        <div class="upload__img-wrap"></div>-->
                            <!--    </div>-->

                            <!--    <p class="allow-fsize">Allow file type PDF, JPG, JPEG, PNG</p>-->
                            <!--</div>-->
                        </div>
                        <!--////-->

                        <div class="col-12 col-md-12 form-group">
                            <div class="d-flex">
                                <input class="form-check-input clickto-adclass" name="set_reminder" type="checkbox" id="setReminder" />

                                <label class="me-1">Set Reminder </label>
                            </div>

                            <div class="days-beforeexpiry" style="display: none">
                                <div class="row form-group">
                                    <div class="col-12 col-md-3">
                                        <label>Remind Before Days <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <select class="form-select" name="reminder_days">
                                            <option value="">Choose..</option>
                                            <option value="7">7 Days</option>
                                            <option value="10">10 Days</option>
                                            <option value="20">20 Days</option>
                                        </select>
                                        <div class="error text-danger" id="document_reminder_days_error"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-12 col-md-12 form-group">
                            <label>Notes</label>
                            <textarea class="form-control" rows="4" name="notes"></textarea>
                            <div class="error text-danger" id="document_notes_error"></div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary docSubmitForm">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Document Modal -->
<div class="modal fade expenses_wrapperModal" id="edit_documents" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Document</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="uil uil-times"></i>
                </button>
            </div>

            <div class="modal-body">
                <form action="" id="editDocumentForm">
                    @csrf
                    <div class="row">
                        <div class="col-12 col-md-6 form-group">
                            <label>Tyre<span class="text-danger ms-1">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control bg-light" readonly value="{{ $tyre->tyre_serial_number }}" />
                            </div>
                        </div>

                        <div class="col-12 col-md-6 form-group">
                            <label>Document Type<span class="text-danger ms-1">*</span></label>
                            <select name="attachment_type" class="form-select" id="edit_attachmenttype_dd">
                                <option value="">Search Document Type...</option>
                                @forelse($attachmenttypes as $attachmenttype)
                                    <option value="{{ $attachmenttype->name }}">{{ $attachmenttype->name }}</option>
                                @empty
                                @endforelse
                            </select>
                            <div class="error text-danger" id="edit_document_attachment_type_error"></div>
                        </div>

                        <div class="col-12 col-md-6 form-group">
                            <label>Document Number</label>
                            <input type="text" class="form-control" name="document_number" placeholder="" />
                            <div class="error text-danger" id="edit_document_document_number_error"></div>
                        </div>

                        <div class="col-12 col-md-6 form-group">
                            <label>Issue Date</label>
                            <div class="input-group">
                                <input class="date form-control" type="text" id="edit_doc_issue_date" name="issue_date" readonly />

                                <span class="input-group-text">
                                    <i class="uil uil-calendar-alt"></i>
                                </span>
                            </div>
                            <div class="error text-danger" id="edit_document_issue_date_error"></div>
                        </div>

                        <div class="col-12 col-md-6 form-group">
                            <label>Expiry Date<span class="text-danger ms-1"></span></label>
                            <div class="input-group">
                                <input class="date form-control" type="text" id="edit_doc_expiry_date" name="expiry_date" readonly />
                                <span class="input-group-text">
                                    <i class="uil uil-calendar-alt"></i>
                                </span>
                            </div>
                            <div class="error text-danger" id="edit_document_expiry_date_error"></div>
                        </div>

                        <div class="col-12 col-md-6 form-group">
                            <label>Upload File(s)<span class="text-danger ms-1">*</span></label>
                            <div class="dropzone" id="edit_myDropzone">
                                <div class="dz-message needsclick">
                                    <i class="uil uil-upload me-2"></i>
                                    Drop files here or click to upload (Max 2 files)
                                </div>
                            </div>
                            <div class="error text-danger" id="document_files_error"></div>
                            <!--<div class="file_0attachment">-->
                                <!--<label for="formFile" class="form-label">File Attachment</label>-->

                            <!--    <div class="upload__box">-->
                            <!--        <div class="upload__btn-box">-->
                            <!--            <label class="upload__btn">-->
                            <!--                <p class="btn btn-theme mb-0">-->
                            <!--                    <i class="uil uil-plus me-1"></i>File Attachment-->
                            <!--                </p>-->
                            <!--                <input-->
                            <!--                    type="file"-->
                            <!--                    multiple=""-->
                            <!--                    data-max_length="20"-->
                            <!--                    class="upload__inputfile"-->
                            <!--                />-->
                            <!--            </label>-->
                            <!--        </div>-->
                            <!--        <div class="upload__img-wrap"></div>-->
                            <!--    </div>-->

                            <!--    <p class="allow-fsize">Allow file type PDF, JPG, JPEG, PNG</p>-->
                            <!--</div>-->
                        </div>
                        <!--////-->

                        <div class="col-12 col-md-12 form-group">
                            <div class="d-flex">
                                <input class="form-check-input clickto-adclass" name="set_reminder" type="checkbox" id="edit_setReminder" />

                                <label class="me-1">Set Reminder </label>
                            </div>

                            <div class="days-beforeexpiry" style="display: none">
                                <div class="row form-group">
                                    <div class="col-12 col-md-3">
                                        <label>Remind Before Days <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <select class="form-select" id="edit_reminder_days" name="reminder_days">
                                            <option value="">Choose..</option>
                                            <option value="7">7 Days</option>
                                            <option value="10">10 Days</option>
                                            <option value="20">20 Days</option>
                                        </select>
                                        <div class="error text-danger" id="edit_document_reminder_days_error"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-12 col-md-12 form-group">
                            <label>Notes</label>
                            <textarea class="form-control" rows="4" name="notes" id="edit_document_notes"></textarea>
                            <div class="error text-danger" id="edit_document_notes_error"></div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary editDocSubmitForm">Save</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalNotes" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Notes</h5>
            </div>
            <div class="modal-body">
                <p id="modalNotesContent"></p>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="filePreviewModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Uploaded Documents</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" >
                <div class="row mt-4  attachment-container" id="filePreviewContainer1">
                    <!-- Dynamic content -->
                </div>
            </div>
        </div>
    </div>
</div>

    


@endsection



@section('js')
{{-- Pass PHP config to external JS via data-* on body (SD-1 compliant) --}}
<div id="tyreShowConfig"
     data-pdf-logo="{{ asset('images/pdf_file.png') }}"
     data-other-logo="{{ asset('images/other_file.svg') }}"
     data-csrf="{{ csrf_token() }}"
     style="display:none;"></div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>
<script type="text/javascript" src="{{ asset('customjs/tyre/show.js?v=2.1') }}"></script>

<script>
// ═══════════════════════════════════════════════════════════════════════════
//  Schedule Maintenance Modal JS
// ═══════════════════════════════════════════════════════════════════════════
(function () {
    'use strict';

    const STORE_URL  = "{{ route('tyre.maintenance.store', $tyre->id) }}";
    const CSRF       = "{{ csrf_token() }}";

    const $modal     = $('#add05_maintenance');
    const $form      = $('#maintForm');
    const $saveBtn   = $('#maintSaveBtn');
    const $saveTxt   = $('#maintSaveBtnText');
    const $saveSpn   = $('#maintSaveBtnSpinner');

    // ── Badge helper ───────────────────────────────────────────────────────
    function badgeClass(status) {
        const map = { Scheduled: 'badge-primary', Pending: 'badge-warning', Done: 'badge-success', Overdue: 'badge-danger' };
        return map[status] || 'badge-secondary';
    }

    // ── Reset form to "Add" mode ───────────────────────────────────────────
    function resetModal() {
        $form[0].reset();
        $('#maint_schedule_id').val('');
        $('#maint_method_override').val('store');
        $form.attr('action', STORE_URL);
        $saveTxt.text('Save Schedule');
        $('#maintModalLabel').html('<i class="uil uil-wrench me-2"></i>Schedule Maintenance &mdash; <span class="text-muted fw-normal fs-6">{{ $tyre->tyre_serial_number }}</span>');
        clearErrors();
    }

    function clearErrors() {
        $('#maint_item_err').addClass('d-none').text('');
    }

    // ── Loading state ──────────────────────────────────────────────────────
    function setBusy(busy) {
        $saveBtn.prop('disabled', busy);
        $saveSpn.toggleClass('d-none', !busy);
    }

    // ── Reset on open (only when NOT triggered by edit btn) ───────────────
    $modal.on('show.bs.modal', function (e) {
        if (!$(e.relatedTarget).hasClass('maint-edit-btn')) {
            resetModal();
        }
    });

    // ── Edit button click: pre-fill form ──────────────────────────────────
    $(document).on('click', '.maint-edit-btn', function () {
        const d = $(this).data();
        resetModal();

        $('#maint_schedule_id').val(d.id);
        $('#maint_method_override').val('update');
        $form.attr('action', d.updateUrl);

        $('#maint_item').val(d.item);
        $('#maint_last_done').val(d.last);
        $('#maint_next_due').val(d.next);
        $('#maint_odometer').val(d.odometer);
        $('#maint_status').val(d.status);
        $('#maint_notes').val(d.notes);

        $saveTxt.text('Update Schedule');
        $('#maintModalLabel').html('<i class="uil uil-pen me-2"></i>Edit Maintenance &mdash; <span class="text-muted fw-normal fs-6">{{ $tyre->tyre_serial_number }}</span>');

        $modal.modal('show');
    });

    // ── Save / Update ──────────────────────────────────────────────────────
    $saveBtn.on('click', function () {
        clearErrors();

        const item = $('#maint_item').val().trim();
        if (!item) {
            $('#maint_item_err').removeClass('d-none').text('Maintenance item is required.');
            return;
        }

        const isUpdate   = $('#maint_method_override').val() === 'update';
        const actionUrl  = $form.attr('action');
        const scheduleId = $('#maint_schedule_id').val();

        const payload = {
            _token:           CSRF,
            maintenance_item: item,
            last_done_date:   $('#maint_last_done').val(),
            next_due_date:    $('#maint_next_due').val(),
            odometer_km:      $('#maint_odometer').val(),
            status:           $('#maint_status').val(),
            notes:            $('#maint_notes').val(),
        };

        setBusy(true);

        $.ajax({
            url:    actionUrl,
            method: 'POST',
            data:   payload,
            success: function (res) {
                setBusy(false);
                $modal.modal('hide');
                toastr.success(res.message || 'Saved successfully.');

                if (isUpdate) {
                    // Update the existing row in place
                    const $row = $('#maint-row-' + scheduleId);
                    $row.find('td:eq(0)').text(payload.maintenance_item);
                    $row.find('td:eq(1)').text(payload.last_done_date ? formatDateDMY(payload.last_done_date) : '—');
                    $row.find('td:eq(2)').text(payload.next_due_date  ? formatDateDMY(payload.next_due_date)  : '—');
                    $row.find('td:eq(3)').text(payload.odometer_km    ? Number(payload.odometer_km).toLocaleString() : '—');
                    $row.find('td:eq(4)').html('<span class="badge ' + badgeClass(payload.status) + '">' + payload.status + '</span>');
                    // Refresh data-* attrs on edit btn
                    $row.find('.maint-edit-btn')
                        .data('item',     payload.maintenance_item)
                        .data('last',     payload.last_done_date)
                        .data('next',     payload.next_due_date)
                        .data('odometer', payload.odometer_km)
                        .data('status',   payload.status)
                        .data('notes',    payload.notes)
                        .attr('data-item',     payload.maintenance_item)
                        .attr('data-last',     payload.last_done_date)
                        .attr('data-next',     payload.next_due_date)
                        .attr('data-odometer', payload.odometer_km)
                        .attr('data-status',   payload.status)
                        .attr('data-notes',    payload.notes);
                } else {
                    // Reload to get the new row with correct id
                    setTimeout(function () { location.reload(); }, 600);
                }
            },
            error: function (xhr) {
                setBusy(false);
                const msg = xhr.responseJSON?.message || 'Something went wrong.';
                toastr.error(msg);
            }
        });
    });

    // ── Delete ─────────────────────────────────────────────────────────────
    $(document).on('click', '.maint-delete-btn', function () {
        const scheduleId  = $(this).data('id');
        const deleteUrl   = $(this).data('deleteUrl');

        if (!confirm('Delete this maintenance schedule?')) return;

        $.ajax({
            url:    deleteUrl,
            method: 'POST',
            data:   { _token: CSRF },
            success: function (res) {
                toastr.success(res.message || 'Deleted.');
                $('#maint-row-' + scheduleId).fadeOut(300, function () {
                    $(this).remove();
                    // Show empty row if tbody is now empty
                    if ($('tbody .maint-edit-btn').length === 0) {
                        $('tbody').append(
                            '<tr id="maint-empty-row"><td colspan="6" class="text-center text-muted py-4">' +
                            '<i class="uil uil-calendar-slash fs-4 d-block mb-1"></i>' +
                            'No maintenance schedules yet. Click <strong>Schedule Maintenance</strong> to add one.</td></tr>'
                        );
                    }
                });
            },
            error: function (xhr) {
                toastr.error(xhr.responseJSON?.message || 'Could not delete.');
            }
        });
    });

    // ── Date format helper (YYYY-MM-DD → DD-MM-YYYY) ──────────────────────
    function formatDateDMY(ymd) {
        if (!ymd) return '—';
        const parts = ymd.split('-');
        return parts.length === 3 ? parts[2] + '-' + parts[1] + '-' + parts[0] : ymd;
    }

})();
</script>

@endsection


