@extends('layouts.app')

@section('css')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css" />
<link rel="stylesheet" href="{{ asset('css/fleet/vehicle-details.css?v=1.0') }}">
<link rel="stylesheet" href="{{ asset('css/vehicle-details.css?v=1.0') }}">
<link rel="stylesheet" href="{{ asset('css/fleet/vehicle-details-v2.css?v=3.8') }}">

@endsection

@section('content')

    

<div class="layout-wrapper">

    @include('includes.header')

    @php
        /* ── Compliance health calculations ── */
        $rcOk      = ($vehicle->basicinfo->registration_status ?? '') === 'Active';

        $insExpiry = $vehicle->basicinfo->insurance_expiry ?? null;
        $insExp    = $insExpiry ? \Carbon\Carbon::parse($insExpiry) : null;
        $insDays   = $insExp ? (int) now()->diffInDays($insExp, false) : null;
        $insHealth = !$insExp ? 'grey'
                   : ($insDays < 0   ? 'red'
                   : ($insDays <= 30  ? 'red'
                   : ($insDays <= 90  ? 'amber' : 'green')));

        $permitExpiry = $vehicle->basicinfo->permit_expiry ?? null;
        $permitExp    = $permitExpiry ? \Carbon\Carbon::parse($permitExpiry) : null;
        $permitDays   = $permitExp ? (int) now()->diffInDays($permitExp, false) : null;
        $permitHealth = !$permitExp ? 'grey'
                      : ($permitDays < 0   ? 'red'
                      : ($permitDays <= 30  ? 'red'
                      : ($permitDays <= 90  ? 'amber' : 'green')));

        $fitnessExpiry = $vehicle->basicinfo->fitness_expiry ?? null;
        $fitnessExp    = $fitnessExpiry ? \Carbon\Carbon::parse($fitnessExpiry) : null;
        $fitnessDays   = $fitnessExp ? (int) now()->diffInDays($fitnessExp, false) : null;
        $fitnessHealth = !$fitnessExp ? 'grey'
                       : ($fitnessDays < 0   ? 'red'
                       : ($fitnessDays <= 30  ? 'red'
                       : ($fitnessDays <= 90  ? 'amber' : 'green')));

        $puccExpiry = $vehicle->basicinfo->pucc_expiry ?? null;
        $puccExp    = $puccExpiry ? \Carbon\Carbon::parse($puccExpiry) : null;
        $puccDays   = $puccExp ? (int) now()->diffInDays($puccExp, false) : null;
        $puccHealth = !$puccExp ? 'grey' : ($puccDays < 0 ? 'red' : ($puccDays <= 30 ? 'red' : ($puccDays <= 90 ? 'amber' : 'green')));

        $taxExpiry = $vehicle->basicinfo->tax_expiry ?? null;
        $taxExp    = $taxExpiry ? \Carbon\Carbon::parse($taxExpiry) : null;
        $taxDays   = $taxExp ? (int) now()->diffInDays($taxExp, false) : null;
        $taxHealth = !$taxExp ? 'grey' : ($taxDays < 0 ? 'red' : ($taxDays <= 30 ? 'red' : ($taxDays <= 90 ? 'amber' : 'green')));

        /* Worst compliance health wins the column border */
        $complianceScores = array_map(fn($h) => match($h) { 'red'=>3, 'amber'=>2, 'green'=>1, default=>0 },
            [$rcOk ? 'green' : 'red', $insHealth, $permitHealth, $fitnessHealth, $puccHealth, $taxHealth]);
        $colCompliance = match(max($complianceScores)) { 3=>'red', 2=>'amber', 1=>'green', default=>'grey' };

        /* ── Finance ── */
        $chassisEmi = is_object($chassisLoan) && isset($chassisLoan->emi_amount) ? $chassisLoan->emi_amount : 0;
        $bodyEmi    = is_object($bodyLoan)    && isset($bodyLoan->emi_amount)    ? $bodyLoan->emi_amount    : 0;
        $colFinance = $totalEmi > 0 ? 'green' : 'grey';
    @endphp

    <div class="srlog-bdwrapper" style="background:#f0f3fa;">

    {{-- ═══ V2 INTELLIGENCE HEADER ═══ --}}
    <div class="v2-header-zone">

        {{-- ── IDENTITY BAR ── --}}
        <div class="v2-id-bar">

            {{-- Vehicle icon with RC status dot --}}
            <div class="v2-id-icon-wrap">
                <img src="{{ asset('images/icons/car-icon04.png') }}" alt="">
                <span class="v2-id-rc-dot {{ $rcOk ? 'ok' : 'bad' }}"
                      title="{{ $rcOk ? 'RC Active' : 'RC Inactive' }}"></span>
            </div>

            {{-- Vehicle number + type --}}
            <div>
                <div class="v2-id-vno">
                    {{ $vehicle->vehicle_no ?? '—' }}
                    <span class="v2-id-status {{ strtolower($vehicle->status ?? 'active') === 'active' ? 'active' : 'inactive' }}">
                        {{ $vehicle->status ?? 'Active' }}
                    </span>
                    {{-- V1 status badges integrated into header --}}
                    @if($rcOk)
                    <span class="v2-id-badge-rc"><i class="uil uil-shield-check"></i> RC Verified</span>
                    @endif
                    <span class="v2-id-badge-fleet"><i class="uil uil-truck"></i> Fleet: On Trip</span>
                </div>
                <div class="v2-id-sub">
                    {{ $vehicle->vehicletype->name ?? 'HCV' }} &middot; Truck
                    @if($vehicle->group) &middot; {{ $vehicle->group->name }} @endif
                </div>
            </div>

            <div class="v2-id-sep"></div>

            {{-- Driver --}}
            <div>
                <div class="v2-id-field-label">Driver</div>
                <div class="v2-id-field-value">
                    {{ $vehicle->driverAllocation->contact->contact_name ?? 'Unassigned' }}
                    <a class="v2-id-edit-link" href="javascript:void(0)"
                       data-id="{{ $vehicle->id }}" data-bs-toggle="modal" data-bs-target="#notAssigned02">
                        <i class="uil uil-pen"></i>
                    </a>
                </div>
                <div class="v2-id-field-sub">{{ $vehicle->driverAllocation->contact->phone ?? '—' }}</div>
            </div>

            <div class="v2-id-sep"></div>

            {{-- Live location --}}
            <div>
                <div class="v2-id-field-label">Live Location</div>
                <div class="v2-id-field-value">Delhi</div>
                <div class="v2-id-field-sub">Last updated: just now</div>
            </div>

            {{-- Actions flush right --}}
            <div class="v2-id-actions">
                <span class="v2-id-tag-btn">Add TAG <i class="uil uil-plus"></i></span>
                <button class="btn btn-sm" onclick="$('[data-bs-target=\'#vahanModal\']').click()" style="background:#f0f4ff;color:#032671;border:1px solid #c5d0ee;font-size:11px;font-weight:600;">
                    <i class="uil uil-refresh me-1"></i>Refresh Vahan
                </button>
                <a href="{{ route('fleetdashboard.getVehicleDetailsV2', $vehicle->id) }}"
                   class="btn btn-sm"
                   style="background:#032671;color:#fff;border:1px solid #032671;font-size:11px;font-weight:600;">
                    View V2 →
                </a>
            </div>
        </div>

        {{-- ── INTELLIGENCE GRID ── --}}
        <div class="v2-intel-grid">

            {{-- COLUMN 1 — COMPLIANCE --}}
            <div class="v2-intel-col health-{{ $colCompliance }}">
                <div class="v2-intel-col-title">
                    <i class="uil uil-shield"></i> Compliance &amp; Insurance
                </div>

                {{-- RC --}}
                <div class="v2-intel-row">
                    <span class="v2-intel-lbl">RC / Registration</span>
                    <span class="v2-intel-val {{ $rcOk ? 'ok' : 'danger' }}">
                        {{ $rcOk ? '✓ Verified' : '✗ Inactive' }}
                    </span>
                </div>

                {{-- Insurance --}}
                <div class="v2-intel-row">
                    <span class="v2-intel-lbl">Insurance</span>
                    @if($insExp)
                        <span class="v2-intel-val {{ $insHealth === 'red' ? 'danger' : ($insHealth === 'amber' ? 'warn' : 'ok') }}">
                            {{ $insExp->format('d M Y') }}
                            <span class="v2-intel-val-sub">
                                @if($insDays < 0) Expired {{ abs($insDays) }}d ago
                                @else {{ $insDays }}d left @endif
                            </span>
                        </span>
                    @else
                        <span class="v2-intel-val" style="color:#9098b1;">—</span>
                    @endif
                </div>

                {{-- Permit --}}
                <div class="v2-intel-row">
                    <span class="v2-intel-lbl">Permit</span>
                    @if($permitExp)
                        <span class="v2-intel-val {{ $permitHealth === 'red' ? 'danger' : ($permitHealth === 'amber' ? 'warn' : 'ok') }}">
                            {{ $permitExp->format('d M Y') }}
                            <span class="v2-intel-val-sub">
                                @if($permitDays < 0) Expired @else {{ $permitDays }}d left @endif
                            </span>
                        </span>
                    @else
                        <span class="v2-intel-val" style="color:#9098b1;">—</span>
                    @endif
                </div>

                {{-- Fitness --}}
                <div class="v2-intel-row">
                    <span class="v2-intel-lbl">Fitness</span>
                    @if($fitnessExp)
                        <span class="v2-intel-val {{ $fitnessHealth === 'red' ? 'danger' : ($fitnessHealth === 'amber' ? 'warn' : 'ok') }}">
                            {{ $fitnessExp->format('d M Y') }}
                            <span class="v2-intel-val-sub">
                                @if($fitnessDays < 0) Expired @else {{ $fitnessDays }}d left @endif
                            </span>
                        </span>
                    @else
                        <span class="v2-intel-val" style="color:#9098b1;">—</span>
                    @endif
                </div>

                {{-- PUC --}}
                <div class="v2-intel-row">
                    <span class="v2-intel-lbl">PUC</span>
                    @if($puccExp)
                        <span class="v2-intel-val {{ $puccHealth === 'red' ? 'danger' : ($puccHealth === 'amber' ? 'warn' : 'ok') }}">
                            {{ $puccExp->format('d M Y') }}
                            <span class="v2-intel-val-sub">
                                @if($puccDays < 0) Expired @else {{ $puccDays }}d left @endif
                            </span>
                        </span>
                    @else
                        <span class="v2-intel-val" style="color:#9098b1;">—</span>
                    @endif
                </div>

                {{-- Road Tax --}}
                <div class="v2-intel-row">
                    <span class="v2-intel-lbl">Road Tax</span>
                    @if($taxExp)
                        <span class="v2-intel-val {{ $taxHealth === 'red' ? 'danger' : ($taxHealth === 'amber' ? 'warn' : 'ok') }}">
                            {{ $taxExp->format('d M Y') }}
                            <span class="v2-intel-val-sub">
                                @if($taxDays < 0) Expired @else {{ $taxDays }}d left @endif
                            </span>
                        </span>
                    @else
                        <span class="v2-intel-val" style="color:#9098b1;">—</span>
                    @endif
                </div>

                <hr class="v2-intel-divider">
                <a href="javascript:void(0)"
                   class="v2-intel-action"
                   data-bs-toggle="modal" data-bs-target="#newClaimModal">
                    <i class="uil uil-file-plus-alt"></i> Raise Insurance Claim
                </a>
            </div>

            {{-- COLUMN 2 — OPERATIONS --}}
            <div class="v2-intel-col health-green">
                <div class="v2-intel-col-title">
                    <i class="uil uil-truck"></i> Operations
                </div>

                <div class="v2-intel-row">
                    <span class="v2-intel-lbl">Trip Status</span>
                    <span class="v2-intel-val ok">On Trip</span>
                </div>
                <div class="v2-intel-row">
                    <span class="v2-intel-lbl">Fleet Status</span>
                    <span class="v2-intel-val warn">Maintenance</span>
                </div>
                <div class="v2-intel-row">
                    <span class="v2-intel-lbl">Tyres Mounted</span>
                    <span class="v2-intel-val">{{ $vehicle->mounted_tyre_count ?? '—' }}</span>
                </div>
                <div class="v2-intel-row">
                    <span class="v2-intel-lbl">Documents</span>
                    <span class="v2-intel-val {{ ($expired_doc_count ?? 0) > 0 ? 'danger' : (($expiring_doc_count ?? 0) > 0 ? 'warn' : 'ok') }}">
                        {{ $total_doc_count ?? 0 }} total
                        <span class="v2-intel-val-sub">
                            @if(($expired_doc_count ?? 0) > 0)
                                {{ $expired_doc_count }} expired
                            @elseif(($expiring_doc_count ?? 0) > 0)
                                {{ $expiring_doc_count }} expiring soon
                            @else
                                All valid
                            @endif
                        </span>
                    </span>
                </div>
                <div class="v2-intel-row">
                    <span class="v2-intel-lbl">Ownership</span>
                    <span class="v2-intel-val">{{ $vehicle->ownership_type ?? '—' }}</span>
                </div>

                <hr class="v2-intel-divider">
                <a href="javascript:void(0)" class="v2-intel-action">
                    <i class="uil uil-map-marker"></i> Track Live
                </a>
            </div>

            {{-- COLUMN 3 — FINANCE --}}
            <div class="v2-intel-col health-{{ $colFinance }}">
                <div class="v2-intel-col-title">
                    <i class="uil uil-bill"></i> Finance
                </div>

                <div class="v2-intel-row">
                    <span class="v2-intel-lbl">Total Monthly EMI</span>
                    <span class="v2-intel-val" style="font-size:15px;">
                        @if($totalEmi > 0) ₹{{ number_format($totalEmi) }}
                        @else <span style="color:#9098b1;">—</span>
                        @endif
                    </span>
                </div>

                @if($chassisEmi > 0)
                <div class="v2-intel-row">
                    <span class="v2-intel-lbl">Chassis EMI</span>
                    <span class="v2-intel-val">₹{{ number_format($chassisEmi) }}</span>
                </div>
                @endif

                @if($bodyEmi > 0)
                <div class="v2-intel-row">
                    <span class="v2-intel-lbl">Body EMI</span>
                    <span class="v2-intel-val">₹{{ number_format($bodyEmi) }}</span>
                </div>
                @endif

                @if(is_object($chassisLoan) && isset($chassisLoan->financeprovider_id))
                <div class="v2-intel-row">
                    <span class="v2-intel-lbl">Financer</span>
                    <span class="v2-intel-val">{{ optional($chassisLoan->financeprovider)->name ?? '—' }}</span>
                </div>
                @endif

                <div class="v2-intel-row">
                    <span class="v2-intel-lbl">Ownership Type</span>
                    <span class="v2-intel-val">{{ $vehicle->ownership_type ?? '—' }}</span>
                </div>

                <hr class="v2-intel-divider">
                <a href="javascript:void(0)" class="v2-intel-action"
                   onclick="var btn=document.querySelector('[data-bs-target=\'#emi_book\']'); if(btn) btn.click();">
                    <i class="uil uil-book-open"></i> View EMI Book
                </a>
            </div>

        </div>{{-- end intel-grid --}}
    </div>{{-- end header-zone --}}

    {{-- vehicledtl-bd wraps the inner accordion/tab content section --}}
    <div class="vehicledtl-bd">

        <div class="vehicleinfo-wrap align-items-center">
        <div class="vehicleinfo-sec">
            <div class="container-fluid">
                
                <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
                        
                        <div class="accordion-header vehicleinfor_head" id="vinfo_table">
                            
                            <div class="row vehicleinfo_toprow align-items-center">
                             
                                <div class="col-12 col-md-11 d-flex align-items-center">
                                    <span class="titletext">Vehicle Basic Information</span>
                                </div>
                                
                                <div class="col-12 col-md-1">
                                    <button class="accordion-button filter-options" type="button" data-bs-toggle="collapse" data-bs-target="#vinfo_bd"
                                        aria-expanded="true" aria-controls="vinfo_bd">
                                    </button>
                                </div>
                            </div>
                            
                        </div>

                        <div id="vinfo_bd" class="accordion-collapse collapse show" aria-labelledby="vinfo_table" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="table-responsive table-responsive02">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <p>Owner Name</p>
                                                    <span class="text-secondary d-block">{{ $vehicle->basicinfo->owner_name ?? '' }}</span>
                                                </td>
                                                <td>
                                                    <p>Financier</p>
                                                    <span class="text-secondary d-block">{{ $vehicle->basicinfo->financer ?? '' }}</span>
                                                </td>
                                                <td>
                                                    <p>Brand</p>
                                                    <span class="text-secondary d-block">-</span>
                                                </td>
                                                <td>
                                                    <p>Model</p>
                                                    <span class="text-secondary d-block">{{ $vehicle->basicinfo->model ?? '' }}</span>
                                                </td>
                                                <td>
                                                    <p>Emission Norm</p>
                                                    <span class="text-secondary d-block">{{ $vehicle->basicinfo->emission_norms ?? '' }}</span>
                                                </td>
                                                <td>
                                                    <p>Fuel Type</p>
                                                    <span class="text-secondary d-block">{{ $vehicle->basicinfo->fuel_type ?? '' }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <p>Class</p>
                                                    <span class="text-secondary d-block">Goods Carrier (HGV)</span>
                                                </td>
                                                <td>
                                                    <p>Body Type</p>
                                                    <span class="text-secondary d-block">{{ $vehicle->basicinfo->body_type ?? '' }}</span>
                                                </td>
                                                <td>
                                                    <p>No. of Axle</p>
                                                    <span class="text-secondary d-block">2 Axles</span>
                                                </td>
                                                <td>
                                                    <p>No. of Cylinder</p>
                                                    <span class="text-secondary d-block">4</span>
                                                </td>
                                                <td>
                                                    <p>Torque</p>
                                                    <span class="text-secondary d-block">F1</span>
                                                </td>
                                                <td>
                                                    <p>Horsepower</p>
                                                    <span class="text-secondary d-block">200</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <p>Wheelbase</p> 
                                                    <span class="text-secondary d-block">{{ $vehicle->basicinfo->wheelbase ?? '' }}</span>
                                                </td>
                                                <td>
                                                    <p>Laden Weight (kg)</p>
                                                    <span class="text-secondary d-block">N/A</span>
                                                </td>
                                                <td>
                                                    <p>Unladen Weight (kg)</p>
                                                    <span class="text-secondary d-block">{{ $vehicle->basicinfo->unladen_weight ?? '' }}</span>
                                                </td>
                                                <td>
                                                    <p>Gross Weight (kg)</p>
                                                    <span class="text-secondary d-block">{{ $vehicle->basicinfo->gross_vehicle_weight ?? '' }}</span>
                                                </td>
                                                <td>
                                                    <p>Warranty Issue Date</p>
                                                    <span class="text-secondary d-block">12-12-2020</span>
                                                </td>
                                                <td>
                                                    <p>Warranty Expiry Date</p>
                                                    <span class="text-secondary d-block">12-12-2036</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <p>Purchase Date</p>
                                                    <span class="text-secondary d-block">08-06-2028</span>
                                                </td>
                                                <td>
                                                    <p>Fuel Tank Capacity (Litre)</p>
                                                    <span class="text-secondary d-block">40</span>
                                                </td>
                                                <td>
                                                    <p>Urea Tank Capacity (Litre)</p>
                                                    <span class="text-secondary d-block">20</span>
                                                </td>
                                                <td>
                                                    <p>Body Dimensions (Centimeter)</p>
                                                    <span class="text-secondary d-block">H 1000 - W 800 - L 1200</span>
                                                </td>
                                                <td>
                                                    <p>Chassis Number</p>
                                                    <span class="text-secondary d-block">{{ $vehicle->basicinfo->chassis_no ?? '' }}</span>
                                                </td>
                                                <td>
                                                    <p>Engine Number</p>
                                                    <span class="text-secondary d-block">{{ $vehicle->basicinfo->engine_no ?? '' }}</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    
                    <div class="accordion-item mt-3">
                        
                        <div class="accordion-header vehicleinfor_head" id="reg_det">
                            
                            <div class="row vehicleinfo_toprow align-items-center">
                             
                                <div class="col-12 col-md-11 d-flex align-items-center">
                                    <span class="titletext">Registration (RTO) Details</span>
                                </div>
                                
                                <div class="col-12 col-md-1">
                                    <button class="accordion-button filter-options" type="button" data-bs-toggle="collapse" data-bs-target="#rg_bd"
                                        aria-expanded="true" aria-controls="rg_bd">
                                    </button>
                                </div>
                            </div>
                            
                        </div>

                        <div id="rg_bd" class="accordion-collapse collapse show" aria-labelledby="reg_det" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="table-responsive table-responsive02">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <p>Registration Place</p>
                                                    <span class="text-secondary d-block">Kolkata, WB</span>
                                                </td>
                                                <td>
                                                    <p>Registration Date</p>
                                                    <span class="text-secondary d-block">
                                                        {{ !empty($vehicle->basicinfo->registration_date) 
                                                            ? \Carbon\Carbon::parse($vehicle->basicinfo->registration_date)->format('d/m/Y') 
                                                            : '' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <p>Registration Expiry</p>
                                                    <span class="text-secondary d-block">14-05-2039</span>
                                                </td>
                                                <td>
                                                    <p>Tax Expiry Date</p>
                                                    <span class="text-secondary d-block">
                                                        {{ !empty($vehicle->basicinfo->tax_expiry) 
                                                            ? \Carbon\Carbon::parse($vehicle->basicinfo->tax_expiry)->format('d/m/Y') 
                                                            : '' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <p>Fitness Expiry</p>
                                                    <span class="text-secondary d-block">
                                                        {{ !empty($vehicle->basicinfo->fitness_expiry) 
                                                            ? \Carbon\Carbon::parse($vehicle->basicinfo->fitness_expiry)->format('d/m/Y') 
                                                            : '' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <p>Insurance Expiry</p>
                                                    <span class="text-secondary d-block">
                                                        {{ !empty($vehicle->basicinfo->insurance_expiry) 
                                                            ? \Carbon\Carbon::parse($vehicle->basicinfo->insurance_expiry)->format('d/m/Y') 
                                                            : '' }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <p>PUCC No.</p>
                                                    <span class="text-secondary d-block">WB0211005678</span>
                                                </td>
                                                <td>
                                                    <p>PUCC Issue Date</p>
                                                    <span class="text-secondary d-block">01-01-2026</span>
                                                </td>
                                                <td>
                                                    <p>PUCC Expiry Date</p>
                                                    <span class="text-secondary d-block">
                                                        {{ !empty($vehicle->basicinfo->pucc_expiry) 
                                                            ? \Carbon\Carbon::parse($vehicle->basicinfo->pucc_expiry)->format('d/m/Y') 
                                                            : '' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <p>Permit Type</p>
                                                    <span class="text-secondary d-block">National Permit</span>
                                                </td>
                                                <td colspan="2">
                                                    <p>Registration Address</p>
                                                    <span class="text-secondary d-block">12/A Park Street, Kolkata, 700016</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <p>1 Yr Permit No.</p>
                                                    <span class="text-secondary d-block">P-99823/2026</span>
                                                </td>
                                                <td>
                                                    <p>1 Yr Issue Date</p>
                                                    <span class="text-secondary d-block">01-02-2026</span>
                                                </td>
                                                <td>
                                                    <p>1 Yr Expiry Date</p>
                                                    <span class="text-secondary d-block">31-01-2027</span>
                                                </td>
                                                <td>
                                                    <p>5 Yr Permit No.</p>
                                                    <span class="text-secondary d-block">NP-55412/2026</span>
                                                </td>
                                                <td>
                                                    <p>5 Yr Issue Date</p>
                                                    <span class="text-secondary d-block">01-02-2026</span>
                                                </td>
                                                <td>
                                                    <p>5 Yr Expiry Date</p>
                                                    <span class="text-secondary d-block">31-01-2031</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    
                    <div class="accordion-item mt-3">
                        
                        <div class="accordion-header vehicleinfor_head" id="ins_det">
                            
                            <div class="row vehicleinfo_toprow align-items-center">
                             
                                <div class="col-12 col-md-11 d-flex align-items-center">
                                    <span class="titletext">Insurance Details</span>
                                </div>
                                
                                <div class="col-12 col-md-1">
                                    <button class="accordion-button filter-options" type="button" data-bs-toggle="collapse" data-bs-target="#ins_bd"
                                        aria-expanded="true" aria-controls="ins_bd">
                                    </button>
                                </div>
                            </div>
                            
                        </div>

                        <div id="ins_bd" class="accordion-collapse collapse show" aria-labelledby="ins_det" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="table-responsive table-responsive02">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <p>Insurance Company</p>
                                                    <span class="text-secondary d-block">N/A</span>
                                                </td>
                                                <td>
                                                    <p>Insurance Agent</p>
                                                    <span class="text-secondary d-block">N/A</span>
                                                </td>
                                                <td>
                                                    <p>Insurance Policy No.</p>
                                                    <span class="text-secondary d-block">{{ $vehicle->basicinfo->insurance_no ?? '' }}</span>
                                                </td>
                                                <td>
                                                    <p>Insurance Issue Date</p>
                                                    <span class="text-secondary d-block">N/A</span>
                                                </td>
                                                <td>
                                                    <p>Insurance Expiry Date</p>
                                                    <span class="text-secondary d-block">
                                                        {{ !empty($vehicle->basicinfo->insurance_expiry)
                                                            ? \Carbon\Carbon::parse($vehicle->basicinfo->insurance_expiry)->format('d/m/Y')
                                                            : '' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <p>Insurance IDV Value</p>
                                                    <span class="text-secondary d-block">N/A</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    
                    <div class="accordion-item mt-3">
                        
                        <div class="accordion-header vehicleinfor_head" id="fastag_det">
                            
                            <div class="row vehicleinfo_toprow align-items-center">
                             
                                <div class="col-12 col-md-11 d-flex align-items-center">
                                    <span class="titletext">Fasttag  Details</span>
                                    <div class="ms-auto">
                                        
                                        @if($vehicle->fasttag)
                                        <a href="javascript:void(0)" class="editFasttag" data-id="{{ $vehicle->fasttag->id }}"><i class="uil uil-pen"></i></a>
                                        @else
                                        <a href="javascript:void(0)" class="badge badge-primary" data-bs-toggle="modal" data-bs-target="#addFasttag"><i class="uil uil-plus me-1"></i>Add Fasttag Details</a>
                                        @endif
                                        
                                    </div>
                                    
                                    <!--<div class="dropdown ms-1">
                                        <button class="btn btn-primary dropdown-toggle" type="button" id="importBtn" data-bs-toggle="dropdown" aria-expanded="false">
                                            Import <i class="uil uil-upload ms-1"></i>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="importBtn">
                                            <li><a class="dropdown-item" href="javascript:void(0)">Excel</a></li>
                                            <li><a class="dropdown-item" href="javascript:void(0)">PDF</a></li>
                                        </ul>
                                    </div>-->
                                    
                                </div>
                                
                                <div class="col-12 col-md-1">
                                    <button class="accordion-button filter-options" type="button" data-bs-toggle="collapse" data-bs-target="#fst_bd"
                                        aria-expanded="true" aria-controls="fst_bd">
                                    </button>
                                </div>
                            </div>
                            
                        </div>

                        <div id="fst_bd" class="accordion-collapse collapse show" aria-labelledby="fastag_det" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="table-responsive table-responsive02">
                                    <table class="table table-bordered">
                                        <tbody>
                                            @if($vehicle->fasttag)
                                            <tr>
                                                <td colspan="2">
                                                    <p>FASTag Provider</p>
                                                    <span class="text-secondary d-block">{{ $vehicle->fasttag->fasttagprovider->name ?? 'N/A' }}</span>
                                                </td>
                                                <td colspan="2">
                                                    <p>FASTag Bank Name</p>
                                                    <span class="text-secondary d-block">{{ $vehicle->fasttag->fasttag_bank_name ?? '' }}</span>
                                                </td>
                                                <td colspan="2">
                                                    <p>FASTag ID</p>
                                                    <span class="text-secondary d-block">{{ $vehicle->fasttag->fasttagId ?? '' }}</span>
                                                </td>
                                                <td colspan="2">
                                                    <p>FASTag Issue Date</p>
                                                    <span class="text-secondary d-block">
                                                        {{ $vehicle->fasttag->fasttag_issue_date 
                                                            ? \Carbon\Carbon::parse($vehicle->fasttag->fasttag_issue_date)->format('d/m/Y') 
                                                            : '' 
                                                        }}
                                                    </span>
                                                </td>
                                            </tr>
                                            @else
                                            <div class="alert alert-warning text-center p-2" role="alert">
                                                Please Add Fasttag Details, No Data is Added yet. 
                                            </div>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    
                    <div class="accordion-item mt-3">
                        
                        <div class="accordion-header vehicleinfor_head" id="gps_det">
                            
                            <div class="row vehicleinfo_toprow align-items-center">
                             
                                <div class="col-12 col-md-11 d-flex align-items-center">
                                    <span class="titletext">GPS  Details</span>
                                    <div class="ms-auto">
                                        <a href="javascript:void(0)" class="badge badge-primary" data-bs-toggle="modal" data-bs-target="#addGPS"><i class="uil uil-plus me-1"></i>Add GPS Details</a>
                                    </div>
                                </div>
                                
                                <div class="col-12 col-md-1">
                                    <button class="accordion-button filter-options" type="button" data-bs-toggle="collapse" data-bs-target="#gps_bd"
                                        aria-expanded="true" aria-controls="gps_bd">
                                    </button>
                                </div>
                            </div>
                            
                        </div>

                        <div id="gps_bd" class="accordion-collapse collapse show" aria-labelledby="gps_det" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                
                                @forelse($vehicle->gps as $gps)
                                <div class="inner-card">
                                    <div class="icon-wrap">
                                        <a href="javascript:void(0)" data-id="{{ $gps->id }}" class="editGPSClass"><i class="uil uil-pen"></i></a>
                                        {{--<a href="javascript:void(0)" data-id="{{ $gps->id }}" class="deleteGps text-danger ms-1"><i class="uil uil-trash-alt"></i></a>--}}
                                    </div>
                                    <div class="table-responsive table-responsive02">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <td colspan="2">
                                                        <p>GPS Provider</p>
                                                        <span class="text-secondary d-block">{{ $gps->gpsprovider->name ?? 'N/A' }}</span>
                                                    </td>
                                                    <td colspan="2">
                                                        <p>GPS Type</p>
                                                        <span class="text-secondary d-block">{{ $gps->gps_type ?? 'N/A' }}</span>
                                                    </td>
                                                    <td>
                                                        <p>GPS Plan Cost</p>
                                                        <span class="text-secondary d-block">{{ $gps->gps_plan_cost ?? '' }}</span>
                                                    </td>
                                                    <td>
                                                        <p>GPS Device Cost</p>
                                                        <span class="text-secondary d-block">{{ $gps->gps_device_cost ?? '' }}</span>
                                                    </td>
                                                    <td>
                                                        <p>Device Issue Date</p>
                                                        <span class="text-secondary d-block">
                                                            {{ $gps->device_issue_date ? \Carbon\Carbon::parse($gps->device_issue_date)->format('d/m/Y') : '-' }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <p>GPS Device Warranty (Months)</p>
                                                        <span class="text-secondary d-block">{{ $gps->device_warranty ?? '' }}</span>
                                                    </td>
                                                </tr>
                                                
                                                <tr>
                                                    <td colspan="2">
                                                        <p>Device Remaining Warranty</p>
                                                        <span class="text-secondary d-block">{{ $gps->device_remaining_warranty ?? 'N/A' }}</span>
                                                    </td>
                                                    <td colspan="2">
                                                        <p>GPS Plan Validity</p>
                                                        <span class="text-secondary d-block">{{ $gps->gps_plan_validity ?? 'N/A' }}</span>
                                                    </td>
                                                    <td>
                                                        <p>GPS Plan Start Date</p>
                                                        <span class="text-secondary d-block">{{ $gps->gps_plan_start_date ? \Carbon\Carbon::parse($gps->gps_plan_start_date)->format('d/m/Y') : '-' }}</span>
                                                    </td>
                                                    <td>
                                                        <p>GPS Plan Renew Date</p>
                                                        <span class="text-secondary d-block">{{ $gps->gps_plan_renew_date ? \Carbon\Carbon::parse($gps->gps_plan_renew_date)->format('d/m/Y') : '-' }}</span>
                                                    </td>
                                                    {{--<td>
                                                        <p>Status</p>
                                                        <span class="text-secondary d-block">{{ $gps->status ? $gps->status : '-' }}</span>
                                                    </td>--}}
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                </div>
                                @empty
                                <div class="alert alert-warning text-center p-2" role="alert">
                                    Please Add GPS Details, No Data is Added yet. 
                                </div>
                                @endforelse
                            </div>
                        </div>
                        
                    </div>
                    
                    <div class="accordion-item mt-3">

                        <div class="accordion-header vehicleinfor_head" id="tyre_det">
                            <div class="row vehicleinfo_toprow align-items-center">
                                <div class="col-12 col-md-11 d-flex align-items-center">
                                    <span class="titletext">Tyre Details</span>
                                    <span class="badge ms-2" style="background:#10863f;font-size:9px;letter-spacing:.5px;padding:3px 8px;border-radius:4px;color:#fff;font-weight:700;">✦ UPDATED</span>
                                    <a href="{{ route('tyremanage.vehicle.tyre.tagging', $vehicle->id) }}" class="badge badge-primary ms-2">
                                        <i class="uil uil-plus me-1"></i>Manage Tyres
                                    </a>
                                </div>
                                <div class="col-12 col-md-1">
                                    <button class="accordion-button filter-options" type="button" data-bs-toggle="collapse" data-bs-target="#tyre_bd"
                                        aria-expanded="true" aria-controls="tyre_bd">
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div id="tyre_bd" class="accordion-collapse collapse show" aria-labelledby="tyre_det" data-bs-parent="#accordionExample">
                            <div class="accordion-body p-0">
                                @php
                                    $tyreMappings = $vehicle->vehicletyremappings()->with(['tyre.tyrePhotos', 'tyreposition'])->get();
                                    $byCode = $tyreMappings->keyBy(fn($m) => $m->tyreposition->code ?? '__unknown__');
                                    $getTyreColor = function($m) {
                                        if (!$m || !$m->tyre) return 'empty';
                                        $cond = strtolower($m->tyre->tyre_condition ?? '');
                                        $kmLife = (int)($m->tyre->fixed_run_km ?? 0);
                                        $kmRun  = (int)($m->tyre->actual_run_km ?? 0);
                                        $kmBal  = $kmLife > 0 ? ($kmLife - $kmRun) : null;
                                        if (in_array($cond, ['replace','worn','bad','dead','scrap'])) return 'critical';
                                        if ($kmBal !== null && $kmBal <= 0) return 'critical';
                                        if ($kmBal !== null && $kmBal <= 10000) return 'warn';
                                        if (in_array($cond, ['used','old','moderate','average'])) return 'warn';
                                        return 'good';
                                    };
                                    $colorHex = ['good'=>'#10863f','warn'=>'#d97706','critical'=>'#ea0027','empty'=>'#dee2e6'];
                                    $posLabels = [
                                        'C1'=>'Front Left','D1'=>'Front Right',
                                        'Ci2'=>'Rear L1 Inner','Co3'=>'Rear L1 Outer',
                                        'Di2'=>'Rear R1 Inner','Do3'=>'Rear R1 Outer',
                                        'Ci4'=>'Rear L2 Inner','Co5'=>'Rear L2 Outer',
                                        'Di4'=>'Rear R2 Inner','Do5'=>'Rear R2 Outer',
                                        'S1'=>'Spare / Stepney',
                                        'S2'=>'Spare 2',
                                    ];
                                    $totalTyres = $tyreMappings->count();
                                    $goodCount = 0; $warnCount = 0; $criticalCount = 0;
                                    foreach($tyreMappings as $_m) {
                                        $c = $getTyreColor($_m);
                                        if($c==='good') $goodCount++;
                                        elseif($c==='warn') $warnCount++;
                                        elseif($c==='critical') $criticalCount++;
                                    }
                                    $leftCodes  = ['C1','Co3','Ci2','Co5','Ci4'];
                                    $rightCodes = ['D1','Di2','Do3','Di4','Do5'];

                                    // Build tyre image data map for JS modal (keyed by position code)
                                    // Uses tyrePhotos: type='Image' AND mediadocument_id IS NULL
                                    $tyreImagesMap = [];
                                    foreach($tyreMappings as $_tm) {
                                        if($_tm->tyre && $_tm->tyre->tyrePhotos && $_tm->tyre->tyrePhotos->count() > 0) {
                                            $_posCode = $_tm->tyreposition->code ?? '__unknown__';
                                            $tyreImagesMap[$_posCode] = $_tm->tyre->tyrePhotos->map(fn($img) => [
                                                'url'  => asset('medias/' . ltrim($img->file_path, '/')),
                                                'name' => $img->file_name,
                                                'date' => $img->created_at ? \Carbon\Carbon::parse($img->created_at)->format('d M Y') : '—',
                                                'time' => $img->created_at ? \Carbon\Carbon::parse($img->created_at)->format('h:i A') : '',
                                            ])->values()->toArray();
                                        }
                                    }

                                    // Warranty remaining helper (returns months remaining or null)
                                    $getWarrantyRemaining = function($tyre) {
                                        if(!$tyre) return null;
                                        $wm = (int)($tyre->tyre_warranty_months ?? 0);
                                        if($wm <= 0) return null;
                                        $issueDate = $tyre->tyre_issue_date ?? $tyre->tyre_purchase_date;
                                        if(!$issueDate) return null;
                                        $wEnd = \Carbon\Carbon::parse($issueDate)->addMonths($wm);
                                        return max(0, (int)\Carbon\Carbon::today()->diffInMonths($wEnd, false));
                                    };
                                @endphp

                                @if($totalTyres === 0)
                                {{-- Empty State --}}
                                <div class="vtd-empty">
                                    <i class="uil uil-circle vtd-empty-icon"></i>
                                    <div class="vtd-empty-text">No tyres are mapped to this vehicle yet.</div>
                                    <a href="{{ route('tyremanage.vehicle.tyre.tagging', $vehicle->id) }}" class="btn btn-outline-primary btn-sm mt-2">
                                        <i class="uil uil-plus me-1"></i>Manage Tyres
                                    </a>
                                </div>
                                @else

                                {{-- NEW LAYOUT MARKER — visible tag for identifying this redesigned block --}}
                                <div style="background:#e8f5e9;border-left:4px solid #10863f;padding:6px 14px;font-size:11px;font-weight:700;color:#10863f;letter-spacing:.4px;display:flex;align-items:center;gap:8px;">
                                    <i class="uil uil-check-circle"></i> ✦ NEW TYRE LAYOUT — Redesigned with truck diagram, card highlights &amp; modal view
                                </div>

                                {{-- Summary Strip --}}
                                <div class="vtd-summary-strip">
                                    <div class="vtd-sum-item">
                                        <span class="vtd-sum-val">{{ $totalTyres }}</span>
                                        <span class="vtd-sum-lbl">Total</span>
                                    </div>
                                    <div class="vtd-sum-item vtd-sum-good">
                                        <span class="vtd-sum-dot" style="background:#10863f;"></span>
                                        <span class="vtd-sum-val">{{ $goodCount }}</span>
                                        <span class="vtd-sum-lbl">Good</span>
                                    </div>
                                    <div class="vtd-sum-item vtd-sum-warn">
                                        <span class="vtd-sum-dot" style="background:#d97706;"></span>
                                        <span class="vtd-sum-val">{{ $warnCount }}</span>
                                        <span class="vtd-sum-lbl">Attention</span>
                                    </div>
                                    <div class="vtd-sum-item vtd-sum-crit">
                                        <span class="vtd-sum-dot" style="background:#ea0027;"></span>
                                        <span class="vtd-sum-val">{{ $criticalCount }}</span>
                                        <span class="vtd-sum-lbl">Critical</span>
                                    </div>
                                    <div class="vtd-legend ms-auto">
                                        <span class="vtd-leg-item"><span class="vtd-leg-dot" style="background:#10863f;"></span>Good</span>
                                        <span class="vtd-leg-item"><span class="vtd-leg-dot" style="background:#d97706;"></span>Attention</span>
                                        <span class="vtd-leg-item"><span class="vtd-leg-dot" style="background:#ea0027;"></span>Critical</span>
                                        <span class="vtd-leg-item"><span class="vtd-leg-dot" style="background:#dee2e6;border:1px solid #c0c8d8;"></span>Not Assigned</span>
                                    </div>
                                </div>

                                {{-- 3-Column Layout --}}
                                <div class="vtd-layout">

                                    {{-- LEFT CARDS --}}
                                    <div class="vtd-side vtd-side-left">
                                        <div class="vtd-side-title"><i class="uil uil-arrow-left me-1"></i>Left Side Tyres</div>
                                        @foreach($leftCodes as $code)
                                        @php
                                            $m        = $byCode[$code] ?? null;
                                            $color    = $getTyreColor($m);
                                            $hex      = $colorHex[$color];
                                            $lbl      = $posLabels[$code] ?? $code;
                                            $kmLife   = $m ? (int)($m->tyre->fixed_run_km  ?? 0) : 0;
                                            $kmRun    = $m ? (int)($m->tyre->actual_run_km ?? 0) : 0;
                                            $kmBal    = ($m && $kmLife > 0) ? ($kmLife - $kmRun) : null;
                                            $remLifePct = ($m && $kmLife > 0) ? max(0, min(100, round(($kmBal / $kmLife) * 100))) : null;
                                            $remWarranty = $m ? $getWarrantyRemaining($m->tyre) : null;
                                            $tyreType    = $m?->tyre?->tyre_type ?? null;
                                            $imgCount    = ($m && $m->tyre) ? ($m->tyre->tyrePhotos ? $m->tyre->tyrePhotos->count() : 0) : 0;
                                            $kmBalColor  = ($kmBal !== null) ? ($kmBal<=0 ? '#ea0027' : ($kmBal<=10000 ? '#d97706' : '#10863f')) : '#8898aa';
                                        @endphp
                                        <div class="vtd-tyre-card" data-pos="{{ $code }}"
                                            data-label="{{ $lbl }}"
                                            data-has-tyre="{{ $m && $m->tyre ? '1' : '0' }}"
                                            data-serial="{{ $m?->tyre?->tyre_serial_number ?? '' }}"
                                            data-brand="{{ $m?->tyre?->tyre_brand ?? '' }}"
                                            data-model="{{ $m?->tyre?->tyre_model ?? '' }}"
                                            data-condition="{{ $m?->tyre?->tyre_condition ?? '' }}"
                                            data-type="{{ $tyreType ?? '' }}"
                                            data-status="{{ $color }}"
                                            data-fitted="{{ $m && $m->fitment_date ? \Carbon\Carbon::parse($m->fitment_date)->format('d M Y') : '' }}"
                                            data-kmlife="{{ $kmLife ?: '' }}"
                                            data-kmrun="{{ $kmRun ?: '' }}"
                                            data-kmbal="{{ $kmBal ?? '' }}"
                                            data-remlifepct="{{ $remLifePct ?? '' }}"
                                            data-warrantyremaining="{{ $remWarranty ?? '' }}"
                                            data-imgcount="{{ $imgCount }}"
                                            data-manage-url="{{ route('tyremanage.vehicle.tyre.tagging', $vehicle->id) }}">
                                            <div class="vtd-card-head">
                                                <span class="vtd-pos-dot" style="background:{{ $hex }};"></span>
                                                <span class="vtd-pos-label">{{ $lbl }}</span>
                                                @if($m && $m->tyre)
                                                <span class="vtd-status-chip vtd-chip-{{ $color }}">{{ $color==='good'?'New':($color==='warn'?'Attn':($color==='critical'?'Critical':'—')) }}</span>
                                                <a href="#" class="vtd-eye-btn vtd-open-modal" data-pos="{{ $code }}" title="View Photos"><i class="uil uil-eye"></i></a>
                                                @endif
                                            </div>
                                            @if($m && $m->tyre)
                                            <div class="vtd-card-body">
                                                <div class="vtd-field"><span class="vtd-fl">Serial No.</span><span class="vtd-fv vtd-fv-mono">{{ $m->tyre->tyre_serial_number ?? '—' }}</span></div>
                                                <div class="vtd-field"><span class="vtd-fl">Type</span><span class="vtd-fv">@if($tyreType)<span class="vtd-type-badge">{{ $tyreType }}</span>@else<span class="vtd-na">—</span>@endif</span></div>
                                                <div class="vtd-field"><span class="vtd-fl">Rem. Life</span>
                                                    <span class="vtd-fv vtd-life-wrap">
                                                        @if($remLifePct !== null)
                                                        <span class="vtd-life-track"><span class="vtd-life-fill" style="width:{{ $remLifePct }}%;background:{{ $kmBalColor }};"></span></span>
                                                        <span style="color:{{ $kmBalColor }};font-weight:700;">{{ $remLifePct }}%</span>
                                                        @else<span class="vtd-na">—</span>@endif
                                                    </span>
                                                </div>
                                                <div class="vtd-field"><span class="vtd-fl">KM Run</span><span class="vtd-fv">{{ $kmRun > 0 ? number_format($kmRun).' KM' : '—' }}</span></div>
                                                <div class="vtd-field"><span class="vtd-fl">Rem. Run</span><span class="vtd-fv" style="color:{{ $kmBalColor }};font-weight:600;">{{ $kmBal!==null ? ($kmBal<=0?'Overdue':number_format($kmBal).' KM') : '—' }}</span></div>
                                                <div class="vtd-field"><span class="vtd-fl">Warranty</span><span class="vtd-fv">@if($remWarranty!==null)<span style="color:{{ $remWarranty==0?'#ea0027':($remWarranty<=3?'#d97706':'#10863f') }};font-weight:600;">{{ $remWarranty==0?'Expired':$remWarranty.' mo.' }}</span>@else<span class="vtd-na">—</span>@endif</span></div>
                                            </div>
                                            @if($imgCount > 0)
                                            <div class="vtd-card-foot">
                                                <a href="#" class="vtd-view-btn vtd-open-gallery" data-pos="{{ $code }}"><i class="uil uil-image me-1"></i>{{ $imgCount }} Photo{{ $imgCount>1?'s':'' }}</a>
                                            </div>
                                            @endif
                                            @else
                                            <div class="vtd-card-empty-body"><i class="uil uil-circle"></i> <span>No tyre assigned</span></div>
                                            @endif
                                        </div>
                                        @endforeach

                                        {{-- ── SPARE TYRE CARD S1 at bottom of left column ── --}}
                                        <div class="vtd-spare-divider"><i class="uil uil-tire me-1"></i>Spare Tyre</div>
                                        @foreach(['S1'] as $sCode)
                                        @php
                                            $m        = $byCode[$sCode] ?? null;
                                            $color    = $getTyreColor($m);
                                            $hex      = $colorHex[$color];
                                            $lbl      = $posLabels[$sCode] ?? $sCode;
                                            $kmLife   = $m ? (int)($m->tyre->fixed_run_km  ?? 0) : 0;
                                            $kmRun    = $m ? (int)($m->tyre->actual_run_km ?? 0) : 0;
                                            $kmBal    = ($m && $kmLife > 0) ? ($kmLife - $kmRun) : null;
                                            $remLifePct = ($m && $kmLife > 0) ? max(0, min(100, round(($kmBal / $kmLife) * 100))) : null;
                                            $remWarranty = $m ? $getWarrantyRemaining($m->tyre) : null;
                                            $tyreType    = $m?->tyre?->tyre_type ?? null;
                                            $imgCount    = ($m && $m->tyre) ? ($m->tyre->tyrePhotos ? $m->tyre->tyrePhotos->count() : 0) : 0;
                                            $kmBalColor  = ($kmBal !== null) ? ($kmBal<=0 ? '#ea0027' : ($kmBal<=10000 ? '#d97706' : '#10863f')) : '#8898aa';
                                        @endphp
                                        <div class="vtd-tyre-card" data-pos="{{ $sCode }}"
                                            data-label="{{ $lbl }}"
                                            data-has-tyre="{{ $m && $m->tyre ? '1' : '0' }}"
                                            data-serial="{{ $m?->tyre?->tyre_serial_number ?? '' }}"
                                            data-brand="{{ $m?->tyre?->tyre_brand ?? '' }}"
                                            data-model="{{ $m?->tyre?->tyre_model ?? '' }}"
                                            data-condition="{{ $m?->tyre?->tyre_condition ?? '' }}"
                                            data-type="{{ $tyreType ?? '' }}"
                                            data-status="{{ $color }}"
                                            data-fitted="{{ $m && $m->fitment_date ? \Carbon\Carbon::parse($m->fitment_date)->format('d M Y') : '' }}"
                                            data-kmlife="{{ $kmLife ?: '' }}"
                                            data-kmrun="{{ $kmRun ?: '' }}"
                                            data-kmbal="{{ $kmBal ?? '' }}"
                                            data-remlifepct="{{ $remLifePct ?? '' }}"
                                            data-warrantyremaining="{{ $remWarranty ?? '' }}"
                                            data-imgcount="{{ $imgCount }}"
                                            data-manage-url="{{ route('tyremanage.vehicle.tyre.tagging', $vehicle->id) }}">
                                            <div class="vtd-card-head">
                                                <span class="vtd-pos-dot" style="background:{{ $hex }};"></span>
                                                <span class="vtd-pos-label">{{ $lbl }}</span>
                                                @if($m && $m->tyre)
                                                <span class="vtd-status-chip vtd-chip-{{ $color }}">{{ $color==='good'?'New':($color==='warn'?'Attn':($color==='critical'?'Critical':'—')) }}</span>
                                                <a href="#" class="vtd-eye-btn vtd-open-modal" data-pos="{{ $sCode }}" title="View Photos"><i class="uil uil-eye"></i></a>
                                                @endif
                                            </div>
                                            @if($m && $m->tyre)
                                            <div class="vtd-card-body">
                                                <div class="vtd-field"><span class="vtd-fl">Serial No.</span><span class="vtd-fv vtd-fv-mono">{{ $m->tyre->tyre_serial_number ?? '—' }}</span></div>
                                                <div class="vtd-field"><span class="vtd-fl">Type</span><span class="vtd-fv">@if($tyreType)<span class="vtd-type-badge">{{ $tyreType }}</span>@else<span class="vtd-na">—</span>@endif</span></div>
                                                <div class="vtd-field"><span class="vtd-fl">Rem. Life</span>
                                                    <span class="vtd-fv vtd-life-wrap">
                                                        @if($remLifePct !== null)
                                                        <span class="vtd-life-track"><span class="vtd-life-fill" style="width:{{ $remLifePct }}%;background:{{ $kmBalColor }};"></span></span>
                                                        <span style="color:{{ $kmBalColor }};font-weight:700;">{{ $remLifePct }}%</span>
                                                        @else<span class="vtd-na">—</span>@endif
                                                    </span>
                                                </div>
                                                <div class="vtd-field"><span class="vtd-fl">KM Run</span><span class="vtd-fv">{{ $kmRun > 0 ? number_format($kmRun).' KM' : '—' }}</span></div>
                                                <div class="vtd-field"><span class="vtd-fl">Rem. Run</span><span class="vtd-fv" style="color:{{ $kmBalColor }};font-weight:600;">{{ $kmBal!==null ? ($kmBal<=0?'Overdue':number_format($kmBal).' KM') : '—' }}</span></div>
                                                <div class="vtd-field"><span class="vtd-fl">Warranty</span><span class="vtd-fv">@if($remWarranty!==null)<span style="color:{{ $remWarranty==0?'#ea0027':($remWarranty<=3?'#d97706':'#10863f') }};font-weight:600;">{{ $remWarranty==0?'Expired':$remWarranty.' mo.' }}</span>@else<span class="vtd-na">—</span>@endif</span></div>
                                            </div>
                                            @if($imgCount > 0)
                                            <div class="vtd-card-foot">
                                                <a href="#" class="vtd-view-btn vtd-open-gallery" data-pos="{{ $sCode }}"><i class="uil uil-image me-1"></i>{{ $imgCount }} Photo{{ $imgCount>1?'s':'' }}</a>
                                            </div>
                                            @endif
                                            @else
                                            <div class="vtd-card-empty-body"><i class="uil uil-circle"></i> <span>No tyre assigned</span></div>
                                            @endif
                                        </div>
                                        @endforeach
                                    </div>

                                    {{-- CENTER TRUCK SVG --}}
                                    <div class="vtd-center">
                                        <div class="vtd-svg-wrap">
                                            <svg id="vtdTruckSvg" viewBox="0 0 220 430" xmlns="http://www.w3.org/2000/svg" class="vtd-truck-svg">
                                                {{-- ▲ Direction --}}
                                                <text x="110" y="48" text-anchor="middle" font-size="9" fill="#94a3b8" font-weight="700" letter-spacing="1">▲ FRONT</text>

                                                {{-- Truck outer body shadow/frame --}}
                                                <rect x="57" y="70" width="106" height="354" rx="16" fill="#e2e8f0" stroke="none"/>

                                                {{-- Truck main body --}}
                                                <rect x="59" y="72" width="102" height="350" rx="14" fill="#f0f3f9" stroke="#c8d4e8" stroke-width="1.5"/>

                                                {{-- Cab section background --}}
                                                <rect x="59" y="72" width="102" height="108" rx="14" fill="#dce7ff" stroke="#b0c4f0" stroke-width="1.5"/>

                                                {{-- Windshield --}}
                                                <rect x="71" y="80" width="78" height="34" rx="6" fill="#b8d0f5" opacity="0.85"/>
                                                {{-- Windshield glare --}}
                                                <line x1="77" y1="83" x2="77" y2="111" stroke="#fff" stroke-width="1.5" stroke-linecap="round" opacity="0.5"/>
                                                <line x1="83" y1="81" x2="83" y2="113" stroke="#fff" stroke-width="0.7" stroke-linecap="round" opacity="0.25"/>

                                                {{-- Hood / front bonnet --}}
                                                <rect x="71" y="116" width="78" height="14" rx="3" fill="#c8d8f0" stroke="#b0c4e8" stroke-width="1"/>

                                                {{-- Side mirrors --}}
                                                <rect x="45" y="84" width="14" height="9" rx="2.5" fill="#b0c4e8" stroke="#9ab0d8" stroke-width="1"/>
                                                <rect x="161" y="84" width="14" height="9" rx="2.5" fill="#b0c4e8" stroke="#9ab0d8" stroke-width="1"/>
                                                {{-- Mirror stems --}}
                                                <line x1="59" y1="88" x2="65" y2="88" stroke="#a0b4d0" stroke-width="1.5"/>
                                                <line x1="155" y1="88" x2="161" y2="88" stroke="#a0b4d0" stroke-width="1.5"/>

                                                {{-- Cab label --}}
                                                <text x="110" y="160" text-anchor="middle" font-size="7" fill="#7b93c4" font-weight="600" letter-spacing="1.5">CAB</text>
                                                {{-- Cab/cargo separator --}}
                                                <line x1="64" y1="180" x2="156" y2="180" stroke="#c8d4e8" stroke-width="1.5" stroke-dasharray="3,2"/>

                                                {{-- Cargo body --}}
                                                <rect x="63" y="182" width="94" height="236" rx="4" fill="#f5f7fb" stroke="#dce3f0" stroke-width="1"/>
                                                {{-- Cargo panel lines --}}
                                                <line x1="63" y1="228" x2="157" y2="228" stroke="#e0e8f4" stroke-width="1"/>
                                                <line x1="63" y1="310" x2="157" y2="310" stroke="#e0e8f4" stroke-width="1"/>
                                                <line x1="63" y1="392" x2="157" y2="392" stroke="#e0e8f4" stroke-width="1"/>
                                                {{-- Cargo label --}}
                                                <text x="110" y="266" text-anchor="middle" font-size="7" fill="#b0bcce" letter-spacing="2">CARGO</text>

                                                {{-- ─── AXLE RODS ─── --}}
                                                {{-- Front axle rod --}}
                                                <rect x="30" y="124" width="160" height="4" rx="2" fill="#c0ccde"/>
                                                {{-- Front hub centres --}}
                                                <circle cx="42" cy="126" r="4" fill="#9ab0cc" stroke="#8098b8" stroke-width="1"/>
                                                <circle cx="178" cy="126" r="4" fill="#9ab0cc" stroke="#8098b8" stroke-width="1"/>

                                                {{-- Rear axle 1 rod --}}
                                                <rect x="16" y="280" width="188" height="4" rx="2" fill="#c0ccde"/>
                                                {{-- Rear 1 hub centres (outer & inner each side) --}}
                                                <circle cx="29" cy="282" r="3.5" fill="#9ab0cc" stroke="#8098b8" stroke-width="1"/>
                                                <circle cx="50" cy="282" r="3.5" fill="#9ab0cc" stroke="#8098b8" stroke-width="1"/>
                                                <circle cx="170" cy="282" r="3.5" fill="#9ab0cc" stroke="#8098b8" stroke-width="1"/>
                                                <circle cx="191" cy="282" r="3.5" fill="#9ab0cc" stroke="#8098b8" stroke-width="1"/>

                                                {{-- Rear axle 2 rod --}}
                                                <rect x="16" y="370" width="188" height="4" rx="2" fill="#c0ccde"/>
                                                {{-- Rear 2 hub centres --}}
                                                <circle cx="29" cy="372" r="3.5" fill="#9ab0cc" stroke="#8098b8" stroke-width="1"/>
                                                <circle cx="50" cy="372" r="3.5" fill="#9ab0cc" stroke="#8098b8" stroke-width="1"/>
                                                <circle cx="170" cy="372" r="3.5" fill="#9ab0cc" stroke="#8098b8" stroke-width="1"/>
                                                <circle cx="191" cy="372" r="3.5" fill="#9ab0cc" stroke="#8098b8" stroke-width="1"/>

                                                {{-- Axle labels --}}
                                                <text x="110" y="119" text-anchor="middle" font-size="6.5" fill="#adb5bd" letter-spacing="0.5">FRONT AXLE</text>
                                                <text x="110" y="276" text-anchor="middle" font-size="6.5" fill="#adb5bd" letter-spacing="0.5">REAR AXLE 1</text>
                                                <text x="110" y="366" text-anchor="middle" font-size="6.5" fill="#adb5bd" letter-spacing="0.5">REAR AXLE 2</text>

                                                {{-- C1 — Front Left --}}
                                                @php $c=$getTyreColor($byCode['C1']??null); $tm=$byCode['C1']??null; @endphp
                                                <rect id="svg-C1" class="vtd-svg-tyre" data-pos="C1"
                                                    data-label="{{ $posLabels['C1'] ?? 'C1' }}"
                                                    data-has-tyre="{{ $tm && $tm->tyre ? '1' : '0' }}"
                                                    data-serial="{{ $tm?->tyre?->tyre_serial_number ?? '' }}"
                                                    data-brand="{{ $tm?->tyre?->tyre_brand ?? '' }}"
                                                    data-model="{{ $tm?->tyre?->tyre_model ?? '' }}"
                                                    data-condition="{{ $tm?->tyre?->tyre_condition ?? '' }}"
                                                    data-status="{{ $c }}"
                                                    data-fitted="{{ $tm && $tm->fitment_date ? \Carbon\Carbon::parse($tm->fitment_date)->format('d M Y') : '' }}"
                                                    data-kmlife="{{ $tm?->tyre?->fixed_run_km ?? '' }}"
                                                    data-kmrun="{{ $tm?->tyre?->actual_run_km ?? '' }}"
                                                    x="30" y="109" width="24" height="34" rx="5" fill="{{ $colorHex[$c] }}" stroke="#fff" stroke-width="1.5"/>
                                                <text x="42" y="131" text-anchor="middle" font-size="8" fill="#fff" font-weight="700">C1</text>

                                                {{-- D1 — Front Right --}}
                                                @php $c=$getTyreColor($byCode['D1']??null); $tm=$byCode['D1']??null; @endphp
                                                <rect id="svg-D1" class="vtd-svg-tyre" data-pos="D1"
                                                    data-label="{{ $posLabels['D1'] ?? 'D1' }}"
                                                    data-has-tyre="{{ $tm && $tm->tyre ? '1' : '0' }}"
                                                    data-serial="{{ $tm?->tyre?->tyre_serial_number ?? '' }}"
                                                    data-brand="{{ $tm?->tyre?->tyre_brand ?? '' }}"
                                                    data-model="{{ $tm?->tyre?->tyre_model ?? '' }}"
                                                    data-condition="{{ $tm?->tyre?->tyre_condition ?? '' }}"
                                                    data-status="{{ $c }}"
                                                    data-fitted="{{ $tm && $tm->fitment_date ? \Carbon\Carbon::parse($tm->fitment_date)->format('d M Y') : '' }}"
                                                    data-kmlife="{{ $tm?->tyre?->fixed_run_km ?? '' }}"
                                                    data-kmrun="{{ $tm?->tyre?->actual_run_km ?? '' }}"
                                                    x="166" y="109" width="24" height="34" rx="5" fill="{{ $colorHex[$c] }}" stroke="#fff" stroke-width="1.5"/>
                                                <text x="178" y="131" text-anchor="middle" font-size="8" fill="#fff" font-weight="700">D1</text>

                                                {{-- Co3 — Rear Axle 1, Left Outer --}}
                                                @php $c=$getTyreColor($byCode['Co3']??null); $tm=$byCode['Co3']??null; @endphp
                                                <rect id="svg-Co3" class="vtd-svg-tyre" data-pos="Co3"
                                                    data-label="{{ $posLabels['Co3'] ?? 'Co3' }}"
                                                    data-has-tyre="{{ $tm && $tm->tyre ? '1' : '0' }}"
                                                    data-serial="{{ $tm?->tyre?->tyre_serial_number ?? '' }}"
                                                    data-brand="{{ $tm?->tyre?->tyre_brand ?? '' }}"
                                                    data-model="{{ $tm?->tyre?->tyre_model ?? '' }}"
                                                    data-condition="{{ $tm?->tyre?->tyre_condition ?? '' }}"
                                                    data-status="{{ $c }}"
                                                    data-fitted="{{ $tm && $tm->fitment_date ? \Carbon\Carbon::parse($tm->fitment_date)->format('d M Y') : '' }}"
                                                    data-kmlife="{{ $tm?->tyre?->fixed_run_km ?? '' }}"
                                                    data-kmrun="{{ $tm?->tyre?->actual_run_km ?? '' }}"
                                                    x="20" y="267" width="19" height="30" rx="4" fill="{{ $colorHex[$c] }}" stroke="#fff" stroke-width="1.5"/>
                                                <text x="29" y="286" text-anchor="middle" font-size="6" fill="#fff" font-weight="700">Co3</text>

                                                {{-- Ci2 — Rear Axle 1, Left Inner --}}
                                                @php $c=$getTyreColor($byCode['Ci2']??null); $tm=$byCode['Ci2']??null; @endphp
                                                <rect id="svg-Ci2" class="vtd-svg-tyre" data-pos="Ci2"
                                                    data-label="{{ $posLabels['Ci2'] ?? 'Ci2' }}"
                                                    data-has-tyre="{{ $tm && $tm->tyre ? '1' : '0' }}"
                                                    data-serial="{{ $tm?->tyre?->tyre_serial_number ?? '' }}"
                                                    data-brand="{{ $tm?->tyre?->tyre_brand ?? '' }}"
                                                    data-model="{{ $tm?->tyre?->tyre_model ?? '' }}"
                                                    data-condition="{{ $tm?->tyre?->tyre_condition ?? '' }}"
                                                    data-status="{{ $c }}"
                                                    data-fitted="{{ $tm && $tm->fitment_date ? \Carbon\Carbon::parse($tm->fitment_date)->format('d M Y') : '' }}"
                                                    data-kmlife="{{ $tm?->tyre?->fixed_run_km ?? '' }}"
                                                    data-kmrun="{{ $tm?->tyre?->actual_run_km ?? '' }}"
                                                    x="41" y="267" width="19" height="30" rx="4" fill="{{ $colorHex[$c] }}" stroke="#fff" stroke-width="1.5"/>
                                                <text x="50" y="286" text-anchor="middle" font-size="6" fill="#fff" font-weight="700">Ci2</text>

                                                {{-- Di2 — Rear Axle 1, Right Inner --}}
                                                @php $c=$getTyreColor($byCode['Di2']??null); $tm=$byCode['Di2']??null; @endphp
                                                <rect id="svg-Di2" class="vtd-svg-tyre" data-pos="Di2"
                                                    data-label="{{ $posLabels['Di2'] ?? 'Di2' }}"
                                                    data-has-tyre="{{ $tm && $tm->tyre ? '1' : '0' }}"
                                                    data-serial="{{ $tm?->tyre?->tyre_serial_number ?? '' }}"
                                                    data-brand="{{ $tm?->tyre?->tyre_brand ?? '' }}"
                                                    data-model="{{ $tm?->tyre?->tyre_model ?? '' }}"
                                                    data-condition="{{ $tm?->tyre?->tyre_condition ?? '' }}"
                                                    data-status="{{ $c }}"
                                                    data-fitted="{{ $tm && $tm->fitment_date ? \Carbon\Carbon::parse($tm->fitment_date)->format('d M Y') : '' }}"
                                                    data-kmlife="{{ $tm?->tyre?->fixed_run_km ?? '' }}"
                                                    data-kmrun="{{ $tm?->tyre?->actual_run_km ?? '' }}"
                                                    x="160" y="267" width="19" height="30" rx="4" fill="{{ $colorHex[$c] }}" stroke="#fff" stroke-width="1.5"/>
                                                <text x="169" y="286" text-anchor="middle" font-size="6" fill="#fff" font-weight="700">Di2</text>

                                                {{-- Do3 — Rear Axle 1, Right Outer --}}
                                                @php $c=$getTyreColor($byCode['Do3']??null); $tm=$byCode['Do3']??null; @endphp
                                                <rect id="svg-Do3" class="vtd-svg-tyre" data-pos="Do3"
                                                    data-label="{{ $posLabels['Do3'] ?? 'Do3' }}"
                                                    data-has-tyre="{{ $tm && $tm->tyre ? '1' : '0' }}"
                                                    data-serial="{{ $tm?->tyre?->tyre_serial_number ?? '' }}"
                                                    data-brand="{{ $tm?->tyre?->tyre_brand ?? '' }}"
                                                    data-model="{{ $tm?->tyre?->tyre_model ?? '' }}"
                                                    data-condition="{{ $tm?->tyre?->tyre_condition ?? '' }}"
                                                    data-status="{{ $c }}"
                                                    data-fitted="{{ $tm && $tm->fitment_date ? \Carbon\Carbon::parse($tm->fitment_date)->format('d M Y') : '' }}"
                                                    data-kmlife="{{ $tm?->tyre?->fixed_run_km ?? '' }}"
                                                    data-kmrun="{{ $tm?->tyre?->actual_run_km ?? '' }}"
                                                    x="181" y="267" width="19" height="30" rx="4" fill="{{ $colorHex[$c] }}" stroke="#fff" stroke-width="1.5"/>
                                                <text x="190" y="286" text-anchor="middle" font-size="6" fill="#fff" font-weight="700">Do3</text>

                                                {{-- Co5 — Rear Axle 2, Left Outer --}}
                                                @php $c=$getTyreColor($byCode['Co5']??null); $tm=$byCode['Co5']??null; @endphp
                                                <rect id="svg-Co5" class="vtd-svg-tyre" data-pos="Co5"
                                                    data-label="{{ $posLabels['Co5'] ?? 'Co5' }}"
                                                    data-has-tyre="{{ $tm && $tm->tyre ? '1' : '0' }}"
                                                    data-serial="{{ $tm?->tyre?->tyre_serial_number ?? '' }}"
                                                    data-brand="{{ $tm?->tyre?->tyre_brand ?? '' }}"
                                                    data-model="{{ $tm?->tyre?->tyre_model ?? '' }}"
                                                    data-condition="{{ $tm?->tyre?->tyre_condition ?? '' }}"
                                                    data-status="{{ $c }}"
                                                    data-fitted="{{ $tm && $tm->fitment_date ? \Carbon\Carbon::parse($tm->fitment_date)->format('d M Y') : '' }}"
                                                    data-kmlife="{{ $tm?->tyre?->fixed_run_km ?? '' }}"
                                                    data-kmrun="{{ $tm?->tyre?->actual_run_km ?? '' }}"
                                                    x="20" y="357" width="19" height="30" rx="4" fill="{{ $colorHex[$c] }}" stroke="#fff" stroke-width="1.5"/>
                                                <text x="29" y="376" text-anchor="middle" font-size="6" fill="#fff" font-weight="700">Co5</text>

                                                {{-- Ci4 — Rear Axle 2, Left Inner --}}
                                                @php $c=$getTyreColor($byCode['Ci4']??null); $tm=$byCode['Ci4']??null; @endphp
                                                <rect id="svg-Ci4" class="vtd-svg-tyre" data-pos="Ci4"
                                                    data-label="{{ $posLabels['Ci4'] ?? 'Ci4' }}"
                                                    data-has-tyre="{{ $tm && $tm->tyre ? '1' : '0' }}"
                                                    data-serial="{{ $tm?->tyre?->tyre_serial_number ?? '' }}"
                                                    data-brand="{{ $tm?->tyre?->tyre_brand ?? '' }}"
                                                    data-model="{{ $tm?->tyre?->tyre_model ?? '' }}"
                                                    data-condition="{{ $tm?->tyre?->tyre_condition ?? '' }}"
                                                    data-status="{{ $c }}"
                                                    data-fitted="{{ $tm && $tm->fitment_date ? \Carbon\Carbon::parse($tm->fitment_date)->format('d M Y') : '' }}"
                                                    data-kmlife="{{ $tm?->tyre?->fixed_run_km ?? '' }}"
                                                    data-kmrun="{{ $tm?->tyre?->actual_run_km ?? '' }}"
                                                    x="41" y="357" width="19" height="30" rx="4" fill="{{ $colorHex[$c] }}" stroke="#fff" stroke-width="1.5"/>
                                                <text x="50" y="376" text-anchor="middle" font-size="6" fill="#fff" font-weight="700">Ci4</text>

                                                {{-- Di4 — Rear Axle 2, Right Inner --}}
                                                @php $c=$getTyreColor($byCode['Di4']??null); $tm=$byCode['Di4']??null; @endphp
                                                <rect id="svg-Di4" class="vtd-svg-tyre" data-pos="Di4"
                                                    data-label="{{ $posLabels['Di4'] ?? 'Di4' }}"
                                                    data-has-tyre="{{ $tm && $tm->tyre ? '1' : '0' }}"
                                                    data-serial="{{ $tm?->tyre?->tyre_serial_number ?? '' }}"
                                                    data-brand="{{ $tm?->tyre?->tyre_brand ?? '' }}"
                                                    data-model="{{ $tm?->tyre?->tyre_model ?? '' }}"
                                                    data-condition="{{ $tm?->tyre?->tyre_condition ?? '' }}"
                                                    data-status="{{ $c }}"
                                                    data-fitted="{{ $tm && $tm->fitment_date ? \Carbon\Carbon::parse($tm->fitment_date)->format('d M Y') : '' }}"
                                                    data-kmlife="{{ $tm?->tyre?->fixed_run_km ?? '' }}"
                                                    data-kmrun="{{ $tm?->tyre?->actual_run_km ?? '' }}"
                                                    x="160" y="357" width="19" height="30" rx="4" fill="{{ $colorHex[$c] }}" stroke="#fff" stroke-width="1.5"/>
                                                <text x="169" y="376" text-anchor="middle" font-size="6" fill="#fff" font-weight="700">Di4</text>

                                                {{-- Do5 — Rear Axle 2, Right Outer --}}
                                                @php $c=$getTyreColor($byCode['Do5']??null); $tm=$byCode['Do5']??null; @endphp
                                                <rect id="svg-Do5" class="vtd-svg-tyre" data-pos="Do5"
                                                    data-label="{{ $posLabels['Do5'] ?? 'Do5' }}"
                                                    data-has-tyre="{{ $tm && $tm->tyre ? '1' : '0' }}"
                                                    data-serial="{{ $tm?->tyre?->tyre_serial_number ?? '' }}"
                                                    data-brand="{{ $tm?->tyre?->tyre_brand ?? '' }}"
                                                    data-model="{{ $tm?->tyre?->tyre_model ?? '' }}"
                                                    data-condition="{{ $tm?->tyre?->tyre_condition ?? '' }}"
                                                    data-status="{{ $c }}"
                                                    data-fitted="{{ $tm && $tm->fitment_date ? \Carbon\Carbon::parse($tm->fitment_date)->format('d M Y') : '' }}"
                                                    data-kmlife="{{ $tm?->tyre?->fixed_run_km ?? '' }}"
                                                    data-kmrun="{{ $tm?->tyre?->actual_run_km ?? '' }}"
                                                    x="181" y="357" width="19" height="30" rx="4" fill="{{ $colorHex[$c] }}" stroke="#fff" stroke-width="1.5"/>
                                                <text x="190" y="376" text-anchor="middle" font-size="6" fill="#fff" font-weight="700">Do5</text>

                                                {{-- S1 + S2 — Spare Tyres (vertically centred in truck body: y mid≈247) --}}
                                                <text x="110" y="226" text-anchor="middle" font-size="5.5" fill="#adb5bd" letter-spacing="0.5">SPARE</text>

                                                @php $c=$getTyreColor($byCode['S1']??null); $tm=$byCode['S1']??null; @endphp
                                                <rect id="svg-S1" class="vtd-svg-tyre" data-pos="S1"
                                                    data-label="{{ $posLabels['S1'] ?? 'Spare / Stepney' }}"
                                                    data-has-tyre="{{ $tm && $tm->tyre ? '1' : '0' }}"
                                                    data-serial="{{ $tm?->tyre?->tyre_serial_number ?? '' }}"
                                                    data-brand="{{ $tm?->tyre?->tyre_brand ?? '' }}"
                                                    data-model="{{ $tm?->tyre?->tyre_model ?? '' }}"
                                                    data-condition="{{ $tm?->tyre?->tyre_condition ?? '' }}"
                                                    data-status="{{ $c }}"
                                                    data-fitted="{{ $tm && $tm->fitment_date ? \Carbon\Carbon::parse($tm->fitment_date)->format('d M Y') : '' }}"
                                                    data-kmlife="{{ $tm?->tyre?->fixed_run_km ?? '' }}"
                                                    data-kmrun="{{ $tm?->tyre?->actual_run_km ?? '' }}"
                                                    x="87" y="230" width="21" height="26" rx="4" fill="{{ $colorHex[$c] }}" stroke="#fff" stroke-width="1.5"/>
                                                <text x="97" y="246" text-anchor="middle" font-size="6" fill="#fff" font-weight="700">S1</text>

                                                @php $c=$getTyreColor($byCode['S2']??null); $tm=$byCode['S2']??null; @endphp
                                                <rect id="svg-S2" class="vtd-svg-tyre" data-pos="S2"
                                                    data-label="{{ $posLabels['S2'] ?? 'Spare 2' }}"
                                                    data-has-tyre="{{ $tm && $tm->tyre ? '1' : '0' }}"
                                                    data-serial="{{ $tm?->tyre?->tyre_serial_number ?? '' }}"
                                                    data-brand="{{ $tm?->tyre?->tyre_brand ?? '' }}"
                                                    data-model="{{ $tm?->tyre?->tyre_model ?? '' }}"
                                                    data-condition="{{ $tm?->tyre?->tyre_condition ?? '' }}"
                                                    data-status="{{ $c }}"
                                                    data-fitted="{{ $tm && $tm->fitment_date ? \Carbon\Carbon::parse($tm->fitment_date)->format('d M Y') : '' }}"
                                                    data-kmlife="{{ $tm?->tyre?->fixed_run_km ?? '' }}"
                                                    data-kmrun="{{ $tm?->tyre?->actual_run_km ?? '' }}"
                                                    x="112" y="230" width="21" height="26" rx="4" fill="{{ $colorHex[$c] }}" stroke="#fff" stroke-width="1.5"/>
                                                <text x="122" y="246" text-anchor="middle" font-size="6" fill="#fff" font-weight="700">S2</text>
                                            </svg>

                                            <div class="vtd-svg-note">Hover on tyre or card to highlight</div>
                                        </div>
                                    </div>

                                    {{-- RIGHT CARDS --}}
                                    <div class="vtd-side vtd-side-right">
                                        <div class="vtd-side-title">Right Side Tyres <i class="uil uil-arrow-right ms-1"></i></div>
                                        @foreach($rightCodes as $code)
                                        @php
                                            $m        = $byCode[$code] ?? null;
                                            $color    = $getTyreColor($m);
                                            $hex      = $colorHex[$color];
                                            $lbl      = $posLabels[$code] ?? $code;
                                            $kmLife   = $m ? (int)($m->tyre->fixed_run_km  ?? 0) : 0;
                                            $kmRun    = $m ? (int)($m->tyre->actual_run_km ?? 0) : 0;
                                            $kmBal    = ($m && $kmLife > 0) ? ($kmLife - $kmRun) : null;
                                            $remLifePct = ($m && $kmLife > 0) ? max(0, min(100, round(($kmBal / $kmLife) * 100))) : null;
                                            $remWarranty = $m ? $getWarrantyRemaining($m->tyre) : null;
                                            $tyreType    = $m?->tyre?->tyre_type ?? null;
                                            $imgCount    = ($m && $m->tyre) ? ($m->tyre->tyrePhotos ? $m->tyre->tyrePhotos->count() : 0) : 0;
                                            $kmBalColor  = ($kmBal !== null) ? ($kmBal<=0 ? '#ea0027' : ($kmBal<=10000 ? '#d97706' : '#10863f')) : '#8898aa';
                                        @endphp
                                        <div class="vtd-tyre-card" data-pos="{{ $code }}"
                                            data-label="{{ $lbl }}"
                                            data-has-tyre="{{ $m && $m->tyre ? '1' : '0' }}"
                                            data-serial="{{ $m?->tyre?->tyre_serial_number ?? '' }}"
                                            data-brand="{{ $m?->tyre?->tyre_brand ?? '' }}"
                                            data-model="{{ $m?->tyre?->tyre_model ?? '' }}"
                                            data-condition="{{ $m?->tyre?->tyre_condition ?? '' }}"
                                            data-type="{{ $tyreType ?? '' }}"
                                            data-status="{{ $color }}"
                                            data-fitted="{{ $m && $m->fitment_date ? \Carbon\Carbon::parse($m->fitment_date)->format('d M Y') : '' }}"
                                            data-kmlife="{{ $kmLife ?: '' }}"
                                            data-kmrun="{{ $kmRun ?: '' }}"
                                            data-kmbal="{{ $kmBal ?? '' }}"
                                            data-remlifepct="{{ $remLifePct ?? '' }}"
                                            data-warrantyremaining="{{ $remWarranty ?? '' }}"
                                            data-imgcount="{{ $imgCount }}"
                                            data-manage-url="{{ route('tyremanage.vehicle.tyre.tagging', $vehicle->id) }}">
                                            <div class="vtd-card-head">
                                                <span class="vtd-pos-dot" style="background:{{ $hex }};"></span>
                                                <span class="vtd-pos-label">{{ $lbl }}</span>
                                                @if($m && $m->tyre)
                                                <span class="vtd-status-chip vtd-chip-{{ $color }}">{{ $color==='good'?'New':($color==='warn'?'Attn':($color==='critical'?'Critical':'—')) }}</span>
                                                <a href="#" class="vtd-eye-btn vtd-open-modal" data-pos="{{ $code }}" title="View Photos"><i class="uil uil-eye"></i></a>
                                                @endif
                                            </div>
                                            @if($m && $m->tyre)
                                            <div class="vtd-card-body">
                                                <div class="vtd-field"><span class="vtd-fl">Serial No.</span><span class="vtd-fv vtd-fv-mono">{{ $m->tyre->tyre_serial_number ?? '—' }}</span></div>
                                                <div class="vtd-field"><span class="vtd-fl">Type</span><span class="vtd-fv">@if($tyreType)<span class="vtd-type-badge">{{ $tyreType }}</span>@else<span class="vtd-na">—</span>@endif</span></div>
                                                <div class="vtd-field"><span class="vtd-fl">Rem. Life</span>
                                                    <span class="vtd-fv vtd-life-wrap">
                                                        @if($remLifePct !== null)
                                                        <span class="vtd-life-track"><span class="vtd-life-fill" style="width:{{ $remLifePct }}%;background:{{ $kmBalColor }};"></span></span>
                                                        <span style="color:{{ $kmBalColor }};font-weight:700;">{{ $remLifePct }}%</span>
                                                        @else<span class="vtd-na">—</span>@endif
                                                    </span>
                                                </div>
                                                <div class="vtd-field"><span class="vtd-fl">KM Run</span><span class="vtd-fv">{{ $kmRun > 0 ? number_format($kmRun).' KM' : '—' }}</span></div>
                                                <div class="vtd-field"><span class="vtd-fl">Rem. Run</span><span class="vtd-fv" style="color:{{ $kmBalColor }};font-weight:600;">{{ $kmBal!==null ? ($kmBal<=0?'Overdue':number_format($kmBal).' KM') : '—' }}</span></div>
                                                <div class="vtd-field"><span class="vtd-fl">Warranty</span><span class="vtd-fv">@if($remWarranty!==null)<span style="color:{{ $remWarranty==0?'#ea0027':($remWarranty<=3?'#d97706':'#10863f') }};font-weight:600;">{{ $remWarranty==0?'Expired':$remWarranty.' mo.' }}</span>@else<span class="vtd-na">—</span>@endif</span></div>
                                            </div>
                                            @if($imgCount > 0)
                                            <div class="vtd-card-foot">
                                                <a href="#" class="vtd-view-btn vtd-open-gallery" data-pos="{{ $code }}"><i class="uil uil-image me-1"></i>{{ $imgCount }} Photo{{ $imgCount>1?'s':'' }}</a>
                                            </div>
                                            @endif
                                            @else
                                            <div class="vtd-card-empty-body"><i class="uil uil-circle"></i> <span>No tyre assigned</span></div>
                                            @endif
                                        </div>
                                        @endforeach

                                        {{-- ── SPARE TYRE CARD S2 at bottom of right column ── --}}
                                        @php
                                            $m        = $byCode['S2'] ?? null;
                                            $color    = $getTyreColor($m);
                                            $hex      = $colorHex[$color];
                                            $lbl      = $posLabels['S2'] ?? 'Spare 2';
                                            $kmLife   = $m ? (int)($m->tyre->fixed_run_km  ?? 0) : 0;
                                            $kmRun    = $m ? (int)($m->tyre->actual_run_km ?? 0) : 0;
                                            $kmBal    = ($m && $kmLife > 0) ? ($kmLife - $kmRun) : null;
                                            $remLifePct = ($m && $kmLife > 0) ? max(0, min(100, round(($kmBal / $kmLife) * 100))) : null;
                                            $remWarranty = $m ? $getWarrantyRemaining($m->tyre) : null;
                                            $tyreType    = $m?->tyre?->tyre_type ?? null;
                                            $imgCount    = ($m && $m->tyre) ? ($m->tyre->tyrePhotos ? $m->tyre->tyrePhotos->count() : 0) : 0;
                                            $kmBalColor  = ($kmBal !== null) ? ($kmBal<=0 ? '#ea0027' : ($kmBal<=10000 ? '#d97706' : '#10863f')) : '#8898aa';
                                        @endphp
                                        <div class="vtd-spare-divider"><i class="uil uil-tire me-1"></i>Spare Tyre</div>
                                        <div class="vtd-tyre-card" data-pos="S2"
                                            data-label="{{ $lbl }}"
                                            data-has-tyre="{{ $m && $m->tyre ? '1' : '0' }}"
                                            data-serial="{{ $m?->tyre?->tyre_serial_number ?? '' }}"
                                            data-brand="{{ $m?->tyre?->tyre_brand ?? '' }}"
                                            data-model="{{ $m?->tyre?->tyre_model ?? '' }}"
                                            data-condition="{{ $m?->tyre?->tyre_condition ?? '' }}"
                                            data-type="{{ $tyreType ?? '' }}"
                                            data-status="{{ $color }}"
                                            data-fitted="{{ $m && $m->fitment_date ? \Carbon\Carbon::parse($m->fitment_date)->format('d M Y') : '' }}"
                                            data-kmlife="{{ $kmLife ?: '' }}"
                                            data-kmrun="{{ $kmRun ?: '' }}"
                                            data-kmbal="{{ $kmBal ?? '' }}"
                                            data-remlifepct="{{ $remLifePct ?? '' }}"
                                            data-warrantyremaining="{{ $remWarranty ?? '' }}"
                                            data-imgcount="{{ $imgCount }}"
                                            data-manage-url="{{ route('tyremanage.vehicle.tyre.tagging', $vehicle->id) }}">
                                            <div class="vtd-card-head">
                                                <span class="vtd-pos-dot" style="background:{{ $hex }};"></span>
                                                <span class="vtd-pos-label">{{ $lbl }}</span>
                                                @if($m && $m->tyre)
                                                <span class="vtd-status-chip vtd-chip-{{ $color }}">{{ $color==='good'?'New':($color==='warn'?'Attn':($color==='critical'?'Critical':'—')) }}</span>
                                                <a href="#" class="vtd-eye-btn vtd-open-modal" data-pos="S2" title="View Photos"><i class="uil uil-eye"></i></a>
                                                @endif
                                            </div>
                                            @if($m && $m->tyre)
                                            <div class="vtd-card-body">
                                                <div class="vtd-field"><span class="vtd-fl">Serial No.</span><span class="vtd-fv vtd-fv-mono">{{ $m->tyre->tyre_serial_number ?? '—' }}</span></div>
                                                <div class="vtd-field"><span class="vtd-fl">Type</span><span class="vtd-fv">@if($tyreType)<span class="vtd-type-badge">{{ $tyreType }}</span>@else<span class="vtd-na">—</span>@endif</span></div>
                                                <div class="vtd-field"><span class="vtd-fl">Rem. Life</span>
                                                    <span class="vtd-fv vtd-life-wrap">
                                                        @if($remLifePct !== null)
                                                        <span class="vtd-life-track"><span class="vtd-life-fill" style="width:{{ $remLifePct }}%;background:{{ $kmBalColor }};"></span></span>
                                                        <span style="color:{{ $kmBalColor }};font-weight:700;">{{ $remLifePct }}%</span>
                                                        @else<span class="vtd-na">—</span>@endif
                                                    </span>
                                                </div>
                                                <div class="vtd-field"><span class="vtd-fl">KM Run</span><span class="vtd-fv">{{ $kmRun > 0 ? number_format($kmRun).' KM' : '—' }}</span></div>
                                                <div class="vtd-field"><span class="vtd-fl">Rem. Run</span><span class="vtd-fv" style="color:{{ $kmBalColor }};font-weight:600;">{{ $kmBal!==null ? ($kmBal<=0?'Overdue':number_format($kmBal).' KM') : '—' }}</span></div>
                                                <div class="vtd-field"><span class="vtd-fl">Warranty</span><span class="vtd-fv">@if($remWarranty!==null)<span style="color:{{ $remWarranty==0?'#ea0027':($remWarranty<=3?'#d97706':'#10863f') }};font-weight:600;">{{ $remWarranty==0?'Expired':$remWarranty.' mo.' }}</span>@else<span class="vtd-na">—</span>@endif</span></div>
                                            </div>
                                            @if($imgCount > 0)
                                            <div class="vtd-card-foot">
                                                <a href="#" class="vtd-view-btn vtd-open-gallery" data-pos="S2"><i class="uil uil-image me-1"></i>{{ $imgCount }} Photo{{ $imgCount>1?'s':'' }}</a>
                                            </div>
                                            @endif
                                            @else
                                            <div class="vtd-card-empty-body"><i class="uil uil-circle"></i> <span>No tyre assigned</span></div>
                                            @endif
                                        </div>
                                    </div>

                                </div>{{-- /vtd-layout --}}

                                @endif {{-- /if($totalTyres === 0) --}}

                                @if(false) {{-- Dead code block removed --}}
                                    <div class="table-responsive table-responsive02">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <p>Make</p>
                                                        <span class="text-secondary d-block">{{ $mapping->tyre->tyre_brand ?? '-' }}</span>
                                                    </td>
                                                    <td>
                                                        <p>Model</p>
                                                        <span class="text-secondary d-block">{{ $mapping->tyre->tyre_model ?? '-' }}</span>
                                                    </td>
                                                    <td>
                                                        <p>Type</p>
                                                        <span class="text-secondary d-block">{{ $mapping->tyre->tyre_type ?? '-' }}</span>
                                                    </td>
                                                    <td>
                                                        <p>Condition</p>
                                                        <span class="text-secondary d-block">{{ $mapping->tyre->tyre_condition ?? '-' }}</span>
                                                    </td>
                                                    <td>
                                                        <p>Serial No.</p>
                                                        <span class="text-secondary d-block">{{ $mapping->tyre->tyre_serial_number ?? '-' }}</span>
                                                    </td>
                                                    <td>
                                                        <p>Purchase Price (₹)</p>
                                                        <span class="text-secondary d-block">
                                                            {{ $mapping->tyre->tyre_price ? '₹'.number_format($mapping->tyre->tyre_price, 2) : '-' }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <p>Warranty (Months)</p>
                                                        <span class="text-secondary d-block">{{ $mapping->tyre->tyre_warranty_months ?? '-' }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <p>Purchase Date</p>
                                                        <span class="text-secondary d-block">
                                                            {{ $mapping->tyre->tyre_purchase_date ? \Carbon\Carbon::parse($mapping->tyre->tyre_purchase_date)->format('d/m/Y') : '-' }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <p>Fitment Date</p>
                                                        <span class="text-secondary d-block">
                                                            {{ $mapping->fitment_date ? \Carbon\Carbon::parse($mapping->fitment_date)->format('d/m/Y') : '-' }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <p>KM at Fitment</p>
                                                        <span class="text-secondary d-block">
                                                            {{ $mapping->km_at_fitment ? number_format($mapping->km_at_fitment).' KM' : '-' }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <p>KM Life</p>
                                                        <span class="text-secondary d-block">{{ $mapping->tyre->fixed_run_km ? number_format($mapping->tyre->fixed_run_km).' KM' : '-' }}</span>
                                                    </td>
                                                    <td>
                                                        <p>Month Life</p>
                                                        <span class="text-secondary d-block">{{ $mapping->tyre->fixed_life_months ? $mapping->tyre->fixed_life_months.' Months' : '-' }}</span>
                                                    </td>
                                                    <td>
                                                        <p>KM Run</p>
                                                        <span class="text-secondary d-block">{{ $mapping->tyre->actual_run_km ? number_format($mapping->tyre->actual_run_km).' KM' : '-' }}</span>
                                                    </td>
                                                    <td>
                                                        <p>Months Run</p>
                                                        <span class="text-secondary d-block">{{ $mapping->tyre->actual_run_month ? $mapping->tyre->actual_run_month.' Months' : '-' }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <p>KM Balance</p>
                                                        <span class="d-block">
                                                            @php
                                                                $kmLife    = $mapping->tyre->fixed_run_km ?? 0;
                                                                $kmRun     = $mapping->tyre->actual_run_km ?? 0;
                                                                $kmBalance = $kmLife - $kmRun;
                                                            @endphp
                                                            @if($kmLife > 0)
                                                                @if($kmBalance <= 0)
                                                                    <span class="text-danger fw-bold">Overdue</span>
                                                                @elseif($kmBalance <= 10000)
                                                                    <span class="text-warning fw-bold">{{ number_format($kmBalance) }} KM</span>
                                                                @else
                                                                    <span class="text-success">{{ number_format($kmBalance) }} KM</span>
                                                                @endif
                                                            @else
                                                                <span class="text-secondary">-</span>
                                                            @endif
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <p>Alignment Interval (KM)</p>
                                                        <span class="text-secondary d-block">{{ $mapping->tyre->alignment_interval_km ? number_format($mapping->tyre->alignment_interval_km).' KM' : '-' }}</span>
                                                    </td>
                                                    <td>
                                                        <p>Last Alignment at KM</p>
                                                        <span class="text-secondary d-block">{{ $mapping->tyre->last_alignment_km ? number_format($mapping->tyre->last_alignment_km).' KM' : '-' }}</span>
                                                    </td>
                                                    <td>
                                                        <p>Rotation Interval (KM)</p>
                                                        <span class="text-secondary d-block">{{ $mapping->tyre->rotation_interval_km ? number_format($mapping->tyre->rotation_interval_km).' KM' : '-' }}</span>
                                                    </td>
                                                    <td>
                                                        <p>Last Rotation at KM</p>
                                                        <span class="text-secondary d-block">{{ $mapping->tyre->last_rotation_km ? number_format($mapping->tyre->last_rotation_km).' KM' : '-' }}</span>
                                                    </td>
                                                    <td colspan="2"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                @endif {{-- /Dead code block --}}
                            </div>
                        </div>
                    
                    <div class="accordion-item mt-3">
                        
                        <div class="accordion-header vehicleinfor_head" id="bat_det">

                            <div class="row vehicleinfo_toprow align-items-center">

                                <div class="col-12 col-md-11 d-flex align-items-center">
                                    <span class="titletext">Battery Details</span>
                                    <div class="ms-auto d-flex align-items-center gap-2">
                                        <a href="{{ route('inventory.battery-dashboard') }}" class="alert-link small fw-semibold">Manage Battery →</a>
                                        <a href="javascript:void(0)" class="badge badge-primary" data-bs-toggle="modal" data-bs-target="#addBattery"><i class="uil uil-plus me-1"></i>Add Battery Details</a>
                                    </div>
                                </div>

                                <div class="col-12 col-md-1">
                                    <button class="accordion-button filter-options" type="button" data-bs-toggle="collapse" data-bs-target="#bat_bd"
                                        aria-expanded="true" aria-controls="bat_bd">
                                    </button>
                                </div>
                            </div>

                        </div>

                        <div id="bat_bd" class="accordion-collapse collapse show" aria-labelledby="bat_det" data-bs-parent="#accordionExample">
                            <div class="accordion-body p-3">

                                @php
                                    $batteryCollection = $vehicle->batteries ?? collect();
                                    $leftBatteries  = $batteryCollection->values()->filter(fn($b, $k) => $k % 2 === 0);
                                    $rightBatteries = $batteryCollection->values()->filter(fn($b, $k) => $k % 2 !== 0);
                                @endphp

                                @if($batteryCollection->isEmpty())
                                <div class="alert alert-warning text-center p-2" role="alert">
                                    Please Add Battery Details, No Data is Added yet.
                                </div>
                                @else
                                <div class="bat-visual-layout">

                                    {{-- LEFT COLUMN: even-indexed batteries --}}
                                    <div class="bat-col-side bat-col-left">
                                        @foreach($leftBatteries as $battery)
                                        @php
                                            $batIdx = $batteryCollection->search(fn($b) => $b->id === $battery->id) + 1;
                                            // Warranty calc
                                            $batWarrantyRemaining = null;
                                            if ($battery->issue_date && $battery->warranty_months) {
                                                $batIssue = \Carbon\Carbon::parse($battery->issue_date);
                                                $batWarrantyEnd = $batIssue->copy()->addMonths((int)$battery->warranty_months);
                                                $batWarrantyRemaining = \Carbon\Carbon::today()->greaterThan($batWarrantyEnd)
                                                    ? 0 : (int)\Carbon\Carbon::today()->diffInMonths($batWarrantyEnd);
                                            }
                                            // Life calc
                                            $batLifeRemaining = null;
                                            if ($battery->issue_date && $battery->fixed_life_months) {
                                                $batIssue2 = \Carbon\Carbon::parse($battery->issue_date);
                                                $batLifeEnd = $batIssue2->copy()->addMonths((int)$battery->fixed_life_months);
                                                $batLifeRemaining = \Carbon\Carbon::today()->greaterThan($batLifeEnd)
                                                    ? 0 : (int)\Carbon\Carbon::today()->diffInMonths($batLifeEnd);
                                            }
                                        @endphp
                                        <div class="bat-card">
                                            <div class="bat-card-header">
                                                <span class="bat-card-label"><i class="uil uil-bolt-alt me-1"></i>Battery #{{ $batIdx }}</span>
                                                <div class="bat-card-actions">
                                                    <a href="javascript:void(0)" data-id="{{ $battery->id }}" class="editBattery" title="Edit"><i class="uil uil-pen"></i></a>
                                                    <a href="javascript:void(0)" data-id="{{ $battery->id }}" class="deleteBattery text-danger" title="Delete"><i class="uil uil-trash-alt"></i></a>
                                                </div>
                                            </div>
                                            <div class="bat-card-grid">
                                                <div class="bat-field"><p>Model</p><span>{{ $battery->battery_model_name ?? '-' }}</span></div>
                                                <div class="bat-field"><p>Capacity</p><span>{{ $battery->battery_capacity ?? '-' }}</span></div>
                                                <div class="bat-field"><p>Brand</p><span>{{ $battery->battery_brand ?? '-' }}</span></div>
                                                <div class="bat-field"><p>Price</p><span>{{ $battery->battery_price ?? '-' }}</span></div>
                                                <div class="bat-field"><p>Serial No.</p><span>{{ $battery->battery_serial_number ?? '-' }}</span></div>
                                                <div class="bat-field"><p>Purchase Date</p><span>{{ $battery->purchase_date ? \Carbon\Carbon::parse($battery->purchase_date)->format('d/m/Y') : '-' }}</span></div>
                                                <div class="bat-field"><p>Issue Date</p><span>{{ $battery->issue_date ? \Carbon\Carbon::parse($battery->issue_date)->format('d/m/Y') : '-' }}</span></div>
                                                <div class="bat-field"><p>Warranty</p><span>{{ $battery->warranty_months ? $battery->warranty_months.' mo' : '-' }}</span></div>
                                                <div class="bat-field"><p>Warranty Left</p>
                                                    <span>@if($batWarrantyRemaining === null)-@elseif($batWarrantyRemaining == 0)<span class="text-danger fw-bold">Expired</span>@elseif($batWarrantyRemaining <= 3)<span class="text-warning fw-bold">{{ $batWarrantyRemaining }} mo left</span>@else<span class="text-success">{{ $batWarrantyRemaining }} mo</span>@endif</span>
                                                </div>
                                                <div class="bat-field"><p>Fixed Life</p><span>{{ $battery->fixed_life_months ? $battery->fixed_life_months.' mo' : '-' }}</span></div>
                                                <div class="bat-field"><p>Life Left</p>
                                                    <span>@if($batLifeRemaining === null)-@elseif($batLifeRemaining == 0)<span class="text-danger fw-bold">Expired</span>@elseif($batLifeRemaining <= 3)<span class="text-warning fw-bold">{{ $batLifeRemaining }} mo left</span>@else<span class="text-success">{{ $batLifeRemaining }} mo</span>@endif</span>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>

                                    {{-- CENTER: Truck SVG --}}
                                    <div class="bat-col-center">
                                        <div class="bat-truck-wrap">
                                            <svg viewBox="0 0 300 170" xmlns="http://www.w3.org/2000/svg" class="bat-truck-svg" aria-label="Truck battery position diagram">
                                                <!-- Cargo body -->
                                                <rect x="8" y="35" width="180" height="100" rx="5" fill="#e8edf5" stroke="#b0bdd4" stroke-width="2"/>
                                                <!-- Cargo ribs -->
                                                <line x1="48" y1="35" x2="48" y2="135" stroke="#c8d3e8" stroke-width="1"/>
                                                <line x1="88" y1="35" x2="88" y2="135" stroke="#c8d3e8" stroke-width="1"/>
                                                <line x1="128" y1="35" x2="128" y2="135" stroke="#c8d3e8" stroke-width="1"/>
                                                <line x1="168" y1="35" x2="168" y2="135" stroke="#c8d3e8" stroke-width="1"/>
                                                <!-- Cab -->
                                                <rect x="188" y="52" width="100" height="83" rx="7" fill="#d1daf0" stroke="#b0bdd4" stroke-width="2"/>
                                                <!-- Windshield -->
                                                <path d="M192 57 L283 57 L283 95 L192 95 Z" rx="3" fill="#bfdbfe" opacity="0.75" stroke="#93c5fd" stroke-width="1"/>
                                                <!-- Cab door line -->
                                                <line x1="230" y1="95" x2="230" y2="134" stroke="#b0bdd4" stroke-width="1.5" stroke-dasharray="3,3"/>
                                                <!-- Hood/engine area -->
                                                <rect x="188" y="100" width="100" height="35" rx="0" fill="#c4cfe8" stroke="#b0bdd4" stroke-width="1"/>
                                                <!-- Exhaust stack -->
                                                <rect x="275" y="30" width="8" height="25" rx="3" fill="#94a3b8" stroke="#64748b" stroke-width="1"/>
                                                <ellipse cx="279" cy="28" rx="6" ry="3" fill="#64748b"/>
                                                <!-- Battery B1 indicator -->
                                                <rect x="196" y="106" width="32" height="20" rx="4" fill="#22c55e" stroke="#16a34a" stroke-width="1.5"/>
                                                <text x="212" y="120" font-size="9" fill="white" text-anchor="middle" font-weight="700" font-family="sans-serif">B1</text>
                                                <!-- Battery B2 indicator -->
                                                <rect x="234" y="106" width="32" height="20" rx="4" fill="#3b82f6" stroke="#2563eb" stroke-width="1.5"/>
                                                <text x="250" y="120" font-size="9" fill="white" text-anchor="middle" font-weight="700" font-family="sans-serif">B2</text>
                                                <!-- Front wheels -->
                                                <circle cx="240" cy="150" r="16" fill="#334155" stroke="#1e293b" stroke-width="2"/>
                                                <circle cx="240" cy="150" r="7" fill="#94a3b8"/>
                                                <!-- Rear wheels (dual) -->
                                                <circle cx="64" cy="150" r="16" fill="#334155" stroke="#1e293b" stroke-width="2"/>
                                                <circle cx="64" cy="150" r="7" fill="#94a3b8"/>
                                                <circle cx="100" cy="150" r="16" fill="#334155" stroke="#1e293b" stroke-width="2"/>
                                                <circle cx="100" cy="150" r="7" fill="#94a3b8"/>
                                                <!-- Mudguard -->
                                                <path d="M220 134 Q240 134 260 134" stroke="#b0bdd4" stroke-width="2" fill="none"/>
                                                <path d="M40 134 Q64 134 88 134 Q100 134 120 134" stroke="#b0bdd4" stroke-width="2" fill="none"/>
                                                <!-- Ground line -->
                                                <line x1="5" y1="167" x2="295" y2="167" stroke="#e2e8f0" stroke-width="2"/>
                                            </svg>
                                            <div class="bat-truck-legend">
                                                <span class="bat-legend-dot" style="background:#22c55e;"></span><span>B1 — Battery #1</span>
                                                <span class="bat-legend-dot ms-2" style="background:#3b82f6;"></span><span>B2 — Battery #2</span>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- RIGHT COLUMN: odd-indexed batteries --}}
                                    <div class="bat-col-side bat-col-right">
                                        @foreach($rightBatteries as $battery)
                                        @php
                                            $batIdx = $batteryCollection->search(fn($b) => $b->id === $battery->id) + 1;
                                            $batWarrantyRemaining = null;
                                            if ($battery->issue_date && $battery->warranty_months) {
                                                $batIssue = \Carbon\Carbon::parse($battery->issue_date);
                                                $batWarrantyEnd = $batIssue->copy()->addMonths((int)$battery->warranty_months);
                                                $batWarrantyRemaining = \Carbon\Carbon::today()->greaterThan($batWarrantyEnd)
                                                    ? 0 : (int)\Carbon\Carbon::today()->diffInMonths($batWarrantyEnd);
                                            }
                                            $batLifeRemaining = null;
                                            if ($battery->issue_date && $battery->fixed_life_months) {
                                                $batIssue2 = \Carbon\Carbon::parse($battery->issue_date);
                                                $batLifeEnd = $batIssue2->copy()->addMonths((int)$battery->fixed_life_months);
                                                $batLifeRemaining = \Carbon\Carbon::today()->greaterThan($batLifeEnd)
                                                    ? 0 : (int)\Carbon\Carbon::today()->diffInMonths($batLifeEnd);
                                            }
                                        @endphp
                                        <div class="bat-card bat-card-right">
                                            <div class="bat-card-header">
                                                <span class="bat-card-label bat-card-label-blue"><i class="uil uil-bolt-alt me-1"></i>Battery #{{ $batIdx }}</span>
                                                <div class="bat-card-actions">
                                                    <a href="javascript:void(0)" data-id="{{ $battery->id }}" class="editBattery" title="Edit"><i class="uil uil-pen"></i></a>
                                                    <a href="javascript:void(0)" data-id="{{ $battery->id }}" class="deleteBattery text-danger" title="Delete"><i class="uil uil-trash-alt"></i></a>
                                                </div>
                                            </div>
                                            <div class="bat-card-grid">
                                                <div class="bat-field"><p>Model</p><span>{{ $battery->battery_model_name ?? '-' }}</span></div>
                                                <div class="bat-field"><p>Capacity</p><span>{{ $battery->battery_capacity ?? '-' }}</span></div>
                                                <div class="bat-field"><p>Brand</p><span>{{ $battery->battery_brand ?? '-' }}</span></div>
                                                <div class="bat-field"><p>Price</p><span>{{ $battery->battery_price ?? '-' }}</span></div>
                                                <div class="bat-field"><p>Serial No.</p><span>{{ $battery->battery_serial_number ?? '-' }}</span></div>
                                                <div class="bat-field"><p>Purchase Date</p><span>{{ $battery->purchase_date ? \Carbon\Carbon::parse($battery->purchase_date)->format('d/m/Y') : '-' }}</span></div>
                                                <div class="bat-field"><p>Issue Date</p><span>{{ $battery->issue_date ? \Carbon\Carbon::parse($battery->issue_date)->format('d/m/Y') : '-' }}</span></div>
                                                <div class="bat-field"><p>Warranty</p><span>{{ $battery->warranty_months ? $battery->warranty_months.' mo' : '-' }}</span></div>
                                                <div class="bat-field"><p>Warranty Left</p>
                                                    <span>@if($batWarrantyRemaining === null)-@elseif($batWarrantyRemaining == 0)<span class="text-danger fw-bold">Expired</span>@elseif($batWarrantyRemaining <= 3)<span class="text-warning fw-bold">{{ $batWarrantyRemaining }} mo left</span>@else<span class="text-success">{{ $batWarrantyRemaining }} mo</span>@endif</span>
                                                </div>
                                                <div class="bat-field"><p>Fixed Life</p><span>{{ $battery->fixed_life_months ? $battery->fixed_life_months.' mo' : '-' }}</span></div>
                                                <div class="bat-field"><p>Life Left</p>
                                                    <span>@if($batLifeRemaining === null)-@elseif($batLifeRemaining == 0)<span class="text-danger fw-bold">Expired</span>@elseif($batLifeRemaining <= 3)<span class="text-warning fw-bold">{{ $batLifeRemaining }} mo left</span>@else<span class="text-success">{{ $batLifeRemaining }} mo</span>@endif</span>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>

                                </div>
                                @endif

                            </div>
                        </div>
                        
                    </div>
                    
                    <div class="accordion-item mt-3">
                        
                        <div class="accordion-header vehicleinfor_head" id="digiLoc_det">
                            
                            <div class="row vehicleinfo_toprow align-items-center">
                             
                                <div class="col-12 col-md-11 d-flex align-items-center">
                                    <span class="titletext">Digital Lock Details</span>
                                    <a href="javascript:void(0)" class="badge badge-primary" data-bs-toggle="modal" data-bs-target="#addDigitalLock"><i class="uil uil-plus me-1"></i>Add Digital Lock Details</a>
                                </div>
                                
                                <div class="col-12 col-md-1">
                                    <button class="accordion-button filter-options" type="button" data-bs-toggle="collapse" data-bs-target="#bat_bd"
                                        aria-expanded="true" aria-controls="bat_bd">
                                    </button>
                                </div>
                            </div>
                            
                        </div>

                        <div id="bat_bd" class="accordion-collapse collapse show" aria-labelledby="digiLoc_det" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                
                                @forelse($vehicle->digitalLocks as $digitalLock)
                                <div class="inner-card">
                                    <div class="icon-wrap">
                                        <a href="javascript:void(0)" data-id="{{ $digitalLock->id }}" class="editDigitalLock"><i class="uil uil-pen"></i></a>
                                        <a href="javascript:void(0)" data-id="{{ $digitalLock->id }}" class="deleteDigitalLock text-danger ms-1"><i class="uil uil-trash-alt"></i></a>
                                    </div>
                                    <div class="table-responsive table-responsive02">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <p>Provider Name</p>
                                                        <span class="text-secondary d-block">{{ $digitalLock->digitallockprovider->name ?? 'N/A' }}</span>
                                                    </td>
                                                    <td>
                                                        <p>Lock Id</p>
                                                        <span class="text-secondary d-block">{{ $digitalLock->lockId ?? '-' }}</span>
                                                    </td>
                                                    <td>
                                                        <p>Lock Issue Date</p>
                                                        <span class="text-secondary d-block">
                                                            {{ $digitalLock->lock_issue_date 
                                                                ? \Carbon\Carbon::parse($digitalLock->lock_issue_date)->format('d/m/Y') 
                                                                : '-' 
                                                            }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <p>Lock Warranty Months</p>
                                                        <span class="text-secondary d-block">{{ $digitalLock->lock_warranty_months ?? '-' }}</span>
                                                    </td>
                                                    <td>
                                                        <p>Lock Remaining Warranty (Months)</p>
                                                        <span class="text-secondary d-block">
                                                            @if($digitalLock->lock_issue_date && $digitalLock->lock_warranty_months)
                                                                @php
                                                                    $issueDate = \Carbon\Carbon::parse($digitalLock->lock_issue_date);
                                                                    $endDate = $issueDate->copy()->addMonths((int)$digitalLock->lock_warranty_months);
                                                                    $today = \Carbon\Carbon::today();
                                                        
                                                                    $remaining = $today->greaterThan($endDate) 
                                                                        ? 0 
                                                                        : (int) floor($today->diffInMonths($endDate));
                                                                @endphp
                                                        
                                                                @if($remaining == 0)
                                                                    <span class="text-danger fw-bold">Expired</span>
                                                                @elseif($remaining <= 3)
                                                                    <span class="text-warning fw-bold">{{ $remaining }} month(s) left</span>
                                                                @else
                                                                    <span class="text-success">{{ $remaining }} month(s)</span>
                                                                @endif
                                                        
                                                            @else
                                                                -
                                                            @endif
                                                        </span>
                                                    </td>
                                                    
                                                    
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                @empty
                                <div class="alert alert-warning text-center p-2" role="alert">
                                    Please Add Digital Lock Details, No Data is Added yet. 
                                </div>
                                @endforelse
                                
                                
                                
                            </div>
                        </div>
                        
                    </div>
                    
                    
                </div>
                
            </div>
        </div>

        <div class="vehicle-itemtab pt-4">
            <div class="container-fluid">
                
                <ul class="nav nav-tabs item-box">
                    <li class="nav-item">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#trip">
                            <span class="icon"><img src="{{ asset('images/icons/trip-bookicon.png') }}" alt="" /></span>
                            Trip Book
                        </button>
                    </li>

                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#fuel">
                            <span class="icon"><img src="{{ asset('images/icons/fuel-bookicon.png') }}" alt="" /></span>
                            Fuel Book
                        </button>
                    </li>

                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#expenses">
                            <span class="icon"><img src="{{ asset('images/icons/expenses-icon.png') }}" alt="" /></span>
                            Expenses Book
                        </button>
                    </li>
                    
                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#maintenance">
                            <span class="icon"><img src="{{ asset('images/icons/maintenance-icon.png') }}" alt="" /></span>
                            Maintenance
                        </button>
                    </li>

                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#documents">
                            <span class="icon"><img src="{{ asset('images/icons/documents-icon.png') }}" alt="" /></span>
                            Document
                        </button>
                    </li>

                    <li class="nav-item">
                      <button class="nav-link" data-bs-toggle="tab" data-bs-target="#allotment">
                        <span class="icon"><img src="{{ asset('images/icons/allotment-icon.png') }}" alt=""></span>
                        Allotment 
                      </button>
                    </li>
                    
                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#emi_book">
                            <span class="icon"><img src="{{ asset('images/icons/emi-bookicon.png') }}" alt="" /></span>
                            EMI Book
                        </button>
                    </li>

                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#insurance">
                            <span class="icon"><i class="uil uil-shield-check" style="font-size:18px;color:#6c757d;"></i></span>
                            Insurance
                        </button>
                    </li>

                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#comment">
                            <span class="icon"><img src="{{ asset('images/icons/comments-0123.png') }}" alt="" /></span>
                            Comments
                        </button>
                    </li>
                </ul>

                <!-- Tab Content -->
                <div class="tab-content mt-3">
                    
                    <div class="tab-pane fade show active" id="trip">
                        <div class="totalrevenue mt-3">
                               <div class="item-row">

                                   <div class="itemcol">
                                       <p>Total Revenue</p>
                                       <div class="row">
                                           <div class="col-12 col-md-6">
                                               <h6 style="font-size: 12px;">Own Booking</h6>
                                               <span class="number c-01">₹0</span>
                                           </div>
                                           <div class="col-12 col-md-6">
                                               <h6 style="font-size: 12px;">Memo Booking</h6>
                                               <span class="number c-01">₹0</span>
                                           </div>
                                       </div>
                                   </div>

                                   <div class="itemcol">
                                       <p>Total Deductions</p>
                                       <div class="row">
                                           <div class="col-12 col-md-6">
                                               <h6 style="font-size: 12px;">Own Booking</h6>
                                               <span class="number c-02">₹0</span>
                                           </div>
                                           <div class="col-12 col-md-6">
                                               <h6 style="font-size: 12px;">Memo Booking</h6>
                                               <span class="number c-02">₹0</span>
                                           </div>
                                       </div>
                                   </div>

                                   <div class="itemcol">
                                       <p>Total Received</p>
                                       <div class="row">
                                           <div class="col-12 col-md-6">
                                               <h6 style="font-size: 12px;">Own Booking</h6>
                                               <span class="number c-03">₹0</span>
                                           </div>
                                           <div class="col-12 col-md-6">
                                               <h6 style="font-size: 12px;">Memo Booking</h6>
                                               <span class="number c-03">₹0</span>
                                           </div>
                                       </div>
                                   </div>

                                   <div class="itemcol">
                                       <p>Total Balance</p>
                                       <div class="row">
                                           <div class="col-12 col-md-6">
                                               <h6 style="font-size: 12px;">Own Booking</h6>
                                               <span class="number c-04">₹0</span>
                                           </div>
                                           <div class="col-12 col-md-6">
                                               <h6 style="font-size: 12px;">Memo Booking</h6>
                                               <span class="number c-04">₹0</span>
                                           </div>
                                       </div>
                                       
                                   </div>

                                   <div class="itemcol">
                                       <p>Total Expenses</p>
                                       <div class="row">
                                           <div class="col-12 col-md-6">
                                               <h6 style="font-size: 12px;">Own Booking</h6>
                                               <span class="number c-05">₹0</span>
                                           </div>
                                           <div class="col-12 col-md-6">
                                               <h6 style="font-size: 12px;">Memo Booking</h6>
                                               <span class="number c-05">₹0</span>
                                           </div>
                                       </div>
                                   </div>

                                   <div class="itemcol">
                                       <p>Total Profit/Loss</p>
                                       <div class="row">
                                           <div class="col-12 col-md-6">
                                               <h6 style="font-size: 12px;">Own Booking</h6>
                                               <span class="number c-06">₹0</span>
                                           </div>
                                           <div class="col-12 col-md-6">
                                               <h6 style="font-size: 12px;">Memo Booking</h6>
                                               <span class="number c-06">₹0</span>
                                           </div>
                                       </div>
                                   </div>

                               </div>
                           </div>

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
                                                    <label>Start Date</label>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        name="daterange"
                                                        placeholder="Select date range..."
                                                    />
                                                </div>

                                                <div class="vehicletype ms-1">
                                                    <label>End Date</label>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        name="daterange"
                                                        placeholder="Select date range..."
                                                    />
                                                </div>

                                                <div class="vehicletype ms-1">
                                                    <label>Route</label>
                                                    <select class="form-select select2">
                                                        <option>Choose..</option>
                                                        <option>HYD - KOL</option>
                                                        <option>DEL - PUN</option>
                                                    </select>
                                                </div>

                                                <div class="vehicletype ms-1">
                                                    <label>Trip Status</label>
                                                    <select class="form-select">
                                                        <option>Choose..</option>
                                                        <option>Initiated</option>
                                                        <option>On Going</option>
                                                        <option>Completed</option>
                                                    </select>
                                                </div>

                                                <div class="vehicletype ms-1">
                                                    <label>Filter By Booking Type</label>
                                                    <select class="form-select">
                                                        <option>Choose..</option>
                                                        <option>Own Booking</option>
                                                        <option>External Booking</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="filtersearch-bd searchfield justify-content-start mt-3">
                                                <div class="ms-1" style="width: 220px">
                                                    <div class="input-group">
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            placeholder="Search by Trip Number"
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
                                                            placeholder="Search by Customer"
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
                                                
                                                <div class="ms-1" style="width: 220px">
                                                    <div class="input-group">
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            placeholder="Search by LR #"
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

                                                <div class="dropdown ms-1">
                                                    <button
                                                        class="btn btn-primary dropdown-toggle d-flex"
                                                        type="button"
                                                        id="exportBtn"
                                                        data-bs-toggle="dropdown"
                                                        aria-expanded="false"
                                                    >
                                                        Export <i class="uil uil-upload ms-1"></i>
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="exportBtn">
                                                        <li>
                                                            <a class="dropdown-item" href="javascript:void(0)"
                                                                >Excel</a
                                                            >
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="javascript:void(0)"
                                                                >PDF</a
                                                            >
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!---->
                        <div class="vehiclestable">
                            <div class="itemtop">
                                <span class="sec-title">Trips List</span>
                                <a href="#" class="addtripbtn" data-bs-toggle="modal" data-bs-target="#addTrip">
                                    <i class="uil uil-plus me-1"></i>Add Trip</a>
                            </div>
                            
                            <div class="table-responsive">
                                <table class="table custom-driver-table trip-table">
                                    <thead>
                                        <tr>
                                            <th>Trip Number</th>
                                            <th>Start Date & Time</th>
                                            <th>End Date & Time</th>
                                            <th>Driver</th>
                                            <th>Trip Type</th>
                                            <th>Customer</th>
                                            <th>LR# / LR Date</th>
                                            <th>Route</th>
                                            <th>Source</th>
                                            <th>Destination</th>
                                            <th>Status</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                            
                                    <tbody>
                                        <!-- Row 1 -->
                                        <tr>
                                            <td>56667</td>
                                            <td>19-09-2025 | 12:00 PM</td>
                                            <td>25-09-2025 | 12:00 PM</td>
                                            <td>Sujit Paul</td>
                                            <td>External</td>
                                            <td>John Doe</td>
                                            <td>LR#2897 | 13/11/2025</td>
                                            <td>HYD - KOL</td>
                                            <td>Kolkata</td>
                                            <td>Mumbai</td>
                                            <td><span class="badge badge-warning">Initiated</span></td>
                                            <td class="text-center">
                                                <a class="item-edit text-success" data-bs-toggle="modal" data-bs-target="#addTrip"><i class="uil uil-pen me-2"></i></a>
                                                <a class="item-delete text-danger"><i class="uil uil-trash-alt"></i></a>
                                            </td>
                                        </tr>
                            
                                        <!-- Row 2 -->
                                        <tr>
                                            <td>56667</td>
                                            <td>19-09-2025 | 12:00 PM</td>
                                            <td>25-09-2025 | 12:00 PM</td>
                                            <td>Sujit Paul</td>
                                            <td>Own</td>
                                            <td>John Doe</td>
                                            <td>LR#2897 | 13/11/2025</td>
                                            <td>HYD - KOL</td>
                                            <td>Mumbai</td>
                                            <td>Hyderabad</td>
                                            <td><span class="badge badge-info">On Going</span></td>
                                            <td class="text-center">
                                                <a class="item-edit text-success" data-bs-toggle="modal" data-bs-target="#addTrip"><i class="uil uil-pen me-2"></i></a>
                                                <a class="item-delete text-danger"><i class="uil uil-trash-alt"></i></a>
                                            </td>
                                        </tr>
                            
                                        <!-- Row 3 -->
                                        <tr>
                                            <td>56667</td>
                                            <td>19-09-2025 | 12:00 PM</td>
                                            <td>25-09-2025 | 12:00 PM</td>
                                            <td>Sujit Paul</td>
                                            <td>Own</td>
                                            <td>John Doe</td>
                                            <td>LR#2897 | 13/11/2025</td>
                                            <td>HYD - KOL</td>
                                            <td>Mumbai</td>
                                            <td>Hyderabad</td>
                                            <td><span class="badge badge-success">Completed</span></td>
                                            <td class="text-center">
                                                <a class="item-edit text-success" data-bs-toggle="modal" data-bs-target="#addTrip"><i class="uil uil-pen me-2"></i></a>
                                                <a class="item-delete text-danger"><i class="uil uil-trash-alt"></i></a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!---->
                        
                    </div>
                    <!--Trip-Book-content-here-END-->

                    <!--Fuel-Book-content-here-start-->
                    <div class="tab-pane fade" id="fuel">
                        <div class="accordion mt-3" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="fuel_book">
                                    <button
                                        class="accordion-button filter-options"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#collapse02"
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
                                    id="collapse02"
                                    class="accordion-collapse collapse show"
                                    aria-labelledby="fuel_book"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="row">
                                            
                                            <div class="col-lg-6">
                                                <form class="filterbd fualbook_form">
                                                    <div class="filtersearch-bd align-items-end justify-content-start">

                                                         <div class="vehicletype">
                                                            <label>Filter by Date Range</label>
                                                            <input type="text" class="form-control" name="daterange"  placeholder="Filter by date range" />
                                                        </div>
                                                        <button class="btn btn-primary ms-1 d-flex" type="button"><i class="uil uil-sync me-1"></i>Reset</button>
                                                        <div class="dropdown export_wrap ms-1">
                                                          <button class="btn btn-primary dropdown-toggle d-flex" type="button" id="exportBtn" data-bs-toggle="dropdown" aria-expanded="false">
                                                            Export <i class="uil uil-upload ms-1"></i>
                                                          </button>
                                                          
                                                          <ul class="dropdown-menu " aria-labelledby="exportBtn">
                                                            <li><a class="dropdown-item" href="javascript:void(0)">Excel</a></li>
                                                            <li><a class="dropdown-item" href="javascript:void(0)">PDF</a></li>
                                                          </ul>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>


                                            <div class="col-lg-6">
                                                <div class="expenses_and_quantity">
                                                    <div class="row item_row">
                                                        <div class="col-lg-6 col-md-6 item_col">
                                                            <div class="item_box card">
                                                                
                                                                <p>Total Fuel Expenses</p>
                                                                
                                                                <div class="amount_sec">
                                                                  <i class="fa fa-inr"></i>10000
                                                                </div>
                                                                
                                                                <div class="botom_sec">
                                                                    <span class="bor_pa0"><i class="bi bi-cash"></i>Cash:<i class="fa fa-inr"></i>20000</span>
                                                                    <span><i class="bi bi-credit-card "></i>Credit:<i class="fa fa-inr"></i>25000</span>
                                                                </div>
                                                                
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-6 col-md-6 item_col">
                                                            <div class="item_box card">
                                                                <p>Total Fuel Consumption</p>
                                                                <div class="amount_sec">
                                                                    <i class="bi bi-fuel-pump"></i>1000 L
                                                                </div>
                                                                <div class="botom_sec">
                                                                    <span class="p-0"><i class="bi bi-graph-up "></i>Average Rate: <i class="fa fa-inr"></i>100 / L</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>                                                
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                        <div class="sr_dashboard0_table">
                            <div class="container-fluid">
                                <!--<div class="itemtop mb-4">-->
                                <!--    <span class="sec-title">Driver List</span>-->
                                <!--</div>-->
                        
                                <div class="table-responsive">
                                    <table class="table custom-driver-table">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th style="min-width: 120px">Expenses Type</th>
                                                <th style="min-width: 120px">Quantity (L)</th>
                                                <th>Rate(₹/L)</th>
                                                <th>Payment</th>
                                                <th>Payment Mode</th>
                                                <th>Charged To</th>
                                                <th>Odometer(KM)</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                            <tr>
                                                <td>08/09/-2025</td>
                                                <td>
                                                    Fuel Expenses
                                                </td>
                                                
                                                <td>85</td>
                                                
                                                <td>15000</td>
                                                
                                                <td>₹ 30000</td>
                                                
                                                <td><span class="value">Online</span></td>
                                                
                                                <td><span class="value">Hindustan Petroleum</span></td>
                                                
                                                <td>200</td>
        
                                                <td class="text-center">
                                                    <span class="badge bg-success" data-bs-toggle="modal" data-bs-target="#fuelbook1remarks">Remarks</span>
                                                </td>
                                            </tr>
                                            
                                            <tr>
                                                <td>08/09/-2025</td>
                                                <td>
                                                    Fuel Expenses
                                                </td>
                                                
                                                <td>85</td>
                                                
                                                <td>15000</td>
                                                
                                                <td>₹ 30000</td>
                                                
                                                <td><span class="value">Online</span></td>
                                                
                                                <td><span class="value">Hindustan Petroleum</span></td>
                                                
                                                <td>200</td>
        
                                                <td class="text-center">
                                                    <span class="badge bg-success" data-bs-toggle="modal" data-bs-target="#fuelbook1remarks">Remarks</span>
                                                </td>
                                            </tr>
                                            
        
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Fuel-Book-content-here-start-->

                    <!--Expenses content-start-->
                    <div class="tab-pane fade" id="expenses">
                        <div class="accordion mt-3" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="fuel_book">
                                    <button
                                        class="accordion-button filter-options"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#collapse02"
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
                                    id="collapse02"
                                    class="accordion-collapse collapse show"
                                    aria-labelledby="fuel_book"
                                    data-bs-parent="#accordionExample"
                                >
                                    <div class="accordion-body">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                
                                                <form class="filterbd fualbook_form">
                                                    <div class="filtersearch-bd align-items-end justify-content-start">
                                                        
                                                        <div class="vehicletype ms-1">
                                                            <label>Month</label>
                                                            <select class="form-select">
                                                                <option>Choose..</option>
                                                                <option>January 2025</option>
                                                                <option>February 2024</option>
                                                                <option>March 2025</option>
                                                                <option>April 2025</option>
                                                                <option>May 2025</option>
                                                                <option>June 2025</option>
                                                                <option>July 2025</option>
                                                                <option>August 2024</option>
                                                                <option>September 2023</option>
                                                                <option>October 2023</option>
                                                                <option>November 2024</option>
                                                                <option>December 2024</option>
                                                            </select>
                                                        </div>
                                                        
                                                        <div class="vehicletype ms-1">
                                                            <label>Day</label>
                                                            <select class="form-select">
                                                                <option>Choose..</option>
                                                                <option>Day-1</option>
                                                                <option>Day-2</option>
                                                                <option>Day-3</option>
                                                                <option>Day-4</option>
                                                                <option>Day-5</option>
                                                                <option>Day-6</option>
                                                                <option>Day-7</option>
                                                                <option>Day-8</option>
                                                            </select>
                                                        </div>
                                                        
                                                        <button class="btn btn-primary ms-1 d-flex" type="button"><i class="uil uil-sync me-1"></i>Reset</button>
                                                        <div class="dropdown export_wrap ms-1">
                                                          <button class="btn btn-primary dropdown-toggle d-flex" type="button" id="exportBtn" data-bs-toggle="dropdown" aria-expanded="false">
                                                            Export <i class="uil uil-upload ms-1"></i>
                                                          </button>
                                                          
                                                          <ul class="dropdown-menu " aria-labelledby="exportBtn">
                                                            <li><a class="dropdown-item" href="javascript:void(0)">Excel</a></li>
                                                            <li><a class="dropdown-item" href="javascript:void(0)">PDF</a></li>
                                                          </ul>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            
                                            <div class="col-lg-6">
                                                <div class="expenses_and_quantity">
                                                    <div class="row item_row">
                                                        <div class="col-lg-6 col-md-6 item_col">
                                                            <div class="item_box card">
                                                                
                                                                <p>Total Expenses</p>
                                                                
                                                                <div class="amount_sec">
                                                                  <i class="fa fa-inr"></i>100000
                                                                </div>
                                                                
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-6 col-md-6 item_col">
                                                            <div class="item_box card">
                                                                <p>Fuel Expenses</p>
                                                                <div class="amount_sec">
                                                                    <i class="fa fa-inr"></i>10000
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="vehiclestable">
                            <div class="itemtop">
                                <span class="sec-title">Expenses List</span>
                                <a
                                    href="#"
                                    class="addtripbtn"
                                    data-bs-toggle="modal"
                                    data-bs-target="#add04_expenses"
                                    ><i class="uil uil-plus me-1"></i>Add Expenses</a
                                >
                            </div>
                            
                            <div class="table-responsive">
                                <table class="table custom-driver-table">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Expense Type</th>
                                            <th>Payment Mode</th>
                                            <th>Trip</th>
                                            <th>Remark</th>
                                            <th>Amount</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                            
                                    <tbody>
                                        <!-- Row 1 -->
                                        <tr>
                                            <td>08-09-2025</td>
                                            <td>Maintenance</td>
                                            <td>Cash</td>
                                            <td>56667</td>
                                            <td>Paid on call request</td>
                                            <td>₹ 4500</td>
                                            <td class="text-center">
                                                <a class="item-edit text-success">
                                                    <i class="uil uil-pen me-2"></i>
                                                </a>
                                                <a class="item-delete text-danger">
                                                    <i class="uil uil-trash-alt"></i>
                                                </a>
                                            </td>
                                        </tr>
                            
                                        <!-- Row 2 -->
                                        <tr>
                                            <td>08-10-2025</td>
                                            <td>Police</td>
                                            <td>Cash</td>
                                            <td>56867</td>
                                            <td>Paid on call request</td>
                                            <td>₹ 1000</td>
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
                    <!--Expenses content-start-->

                    <!--Emi-book-start-->
                    <div class="tab-pane fade" id="emi_book">
                        <div class="totalrevenue mt-3">
                            <div class="item-row">
                                <div class="itemcol">
                                    <p>Total EMIs</p>
                                    <span class="number c-01">₹{{$totalEmi}}</span>
                                </div>

                                <!--<div class="itemcol">-->
                                <!--    <p>Overdue EMIs</p>-->
                                <!--    <span class="number c-02">₹0</span>-->
                                <!--</div>-->

                                <div class="itemcol">
                                    <p>EMIs Paid</p>
                                    <span class="number c-03">₹0</span>
                                </div>

                                <div class="itemcol">
                                    <p>EMIs Remaining</p>
                                    <span class="number c-04">₹0</span>
                                </div>
                            </div>
                        </div>
                        
                        <ul class="nav nav-pills mt-3" id="pills-tab" role="tablist">
                          <li class="nav-item" role="presentation">
                            <button class="nav-link active mb-0" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Chassis</button>
                          </li>
                          <li class="nav-item" role="presentation">
                            <button class="nav-link mb-0" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Body</button>
                          </li>
                        </ul>
                        
                        <div class="tab-content" id="pills-tabContent">
                          <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                              <div class="vehiclestable pt-0">
                                <div class="itemtop mb-0 pb-0">
                                    <div class="inner-card p-0 mt-3 mb-0">
                                        <div class="table-responsive table-responsive02">
                                                <table class="table table-bordered mb-0">
                                                    <tbody>
                                                        @if($chassisLoan)
                                                        <tr>
                                                            <td>
                                                                <p>Financer</p>
                                                                <span class="text-secondary d-block">{{ $chassisLoan->financeprovider?->name ?? '-' }}</span>
                                                            </td>
                                                            <td>
                                                                <p>EMI Amount</p>
                                                                <span class="text-secondary d-block">{{ $chassisLoan->emi_amount ?? '-' }}</span>
                                                            </td>
                                                            {{--<td>
                                                                <p>EMI Amount With Interest</p>
                                                                <span class="text-secondary d-block">{{ $chassisLoan->total_amt_with_interest ?? '-' }}</span>
                                                            </td>--}}
                                                            <td>
                                                                <p>Start Date</p>
                                                                <span class="text-secondary d-block">
                                                                    {{ $chassisLoan->emi_start_date 
                                                                        ? \Carbon\Carbon::parse($chassisLoan->emi_start_date)->format('d/m/Y') 
                                                                        : '-' 
                                                                    }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <p>End Date</p>
                                                                <span class="text-secondary d-block">
                                                                    {{ $chassisLoan->emi_end_date 
                                                                        ? \Carbon\Carbon::parse($chassisLoan->emi_end_date)->format('d/m/Y') 
                                                                        : '-' 
                                                                    }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <p>Loan Account Number</p>
                                                                <span class="text-secondary d-block">{{ $chassisLoan->loan_account_no ?? '-' }}</span>
                                                            </td>
                                                            <td>
                                                                <p>Loan Status</p>
                                                                @php
                                                                    $status = $chassisLoan->status ?? 'Ongoing';
                                                                @endphp
                                                                
                                                                <span class="badge
                                                                    @if($status == 'Closed') badge-danger
                                                                    @elseif($status == 'Overdue') badge-warning
                                                                    @elseif($status == 'Due Today') badge-info
                                                                    @else badge-success
                                                                    @endif">
                                                                    
                                                                    {{ $status }}
                                                                </span>
                                                            </td>
                                                        </tr>
                                                        @else
                                                        <tr>
                                                            <td colspan="6" class="text-center text-muted">
                                                                No Chassis Loan Available!
                                                            </td>
                                                        </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                    </div>

                                    <div>
                                    <a
                                        href="javascript:void(0)"
                                        class="addtripbtn AddNewFinance"
                                        data-FinanceType="Chassis"
                                        data-bs-toggle="modal"
                                        data-bs-target="#add_finance"><i class="uil uil-plus me-1"></i>Add Finance</a>
                                    <a
                                        href="javascript:void(0)"
                                        class="addtripbtn ViewFinance"
                                        data-id="{{ $chassisLoan->id ?? '' }}"
                                        data-bs-toggle="modal"
                                        ><i class="uil uil-eye me-1"></i>View Finance</a
                                    >
                                    </div>
                                </div>
                            
                            <div class="table-responsive">
                                <table class="table custom-driver-table">
                                    <thead>
                                        <tr>
                                            <th>Finance Amount</th>
                                            <th>EMI Date</th>
                                            <th>Payment Status</th>
                                            <th>Notes</th>
                                        </tr>
                                    </thead>
                            
                                    <tbody>
                                        
                                        @forelse($chassisEmis as $emi)
                                            <tr>
                                                <td>{{ number_format($emi->emi_amount, 2) ?? '-' }}</td>
                                                <td>
                                                    {{ $emi->emi_date ? \Carbon\Carbon::parse($emi->emi_date)->format('d/m/Y') : '-' }}
                                                </td>
                                                @php
                                                    $status = $emi->status;
                                                    $badgeClass = match($status) {
                                                        'Paid' => 'badge-success',
                                                        'Pending' => 'badge-warning',
                                                        'Overdue' => 'badge-danger',
                                                        default => 'badge-secondary',
                                                    };
                                                @endphp
                                                
                                                <td>
                                                    <span class="badge {{ $badgeClass }}">
                                                        {{ $status ?? 'N/A' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="javascript:void(0)" data-emiId="{{ $emi->id }}" data-loanaccountId="{{ $emi->loanaccount_id }}" class="text-success addFinanceNotes" data-bs-toggle="modal" data-bs-target="#addNotes">+</a>
                                                    <a href="javascript:void(0)" data-emiId="{{ $emi->id }}" data-loanaccountId="{{ $emi->loanaccount_id }}" class="text-primary viewFinanceNotes" data-bs-toggle="modal" data-bs-target="#viewNotes"><i class="uil uil-eye"></i></a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center">No Chassis EMI records found!</td>
                                            </tr>
                                        @endforelse
        
        
                                        
                                        <!--<tr>
                                            <td>25000</td>
                                            <td>18/05/2024</td>
                                            <td><span class="badge badge-success">Paid</span></td>
                                            <td>
                                                <a href="javascript:void(0)" class="text-success" data-bs-toggle="modal" data-bs-target="#addNotes">+</a>
                                                <a href="javascript:void(0)" class="text-primary" data-bs-toggle="modal" data-bs-target="#viewNotes"><i class="uil uil-eye"></i></a>
                                            </td>
                                        </tr>
                            
                                        <tr>
                                            <td>25000</td>
                                            <td>18/05/2024</td>
                                            <td><span class="badge badge-success">Paid</span></td>
                                            <td>
                                                <a href="javascript:void(0)" class="text-success" data-bs-toggle="modal" data-bs-target="#addNotes">+</a>
                                                <a href="javascript:void(0)" class="text-primary" data-bs-toggle="modal" data-bs-target="#viewNotes"><i class="uil uil-eye"></i></a>
                                            </td>
                                        </tr>-->
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                          </div>
                          
                          <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                              <div class="vehiclestable pt-0">
                            <div class="itemtop pb-0">
                                <div class="inner-card p-0 mt-3 mb-0">
                                    <div class="table-responsive table-responsive02">
                                            <table class="table table-bordered mb-0">
                                                <tbody>
                                                    @if($bodyLoan)
                                                    <tr>
                                                        <td>
                                                            <p>Financer</p>
                                                            <span class="text-secondary d-block">{{ $bodyLoan->financeprovider?->name ?? '-' }}</span>
                                                        </td>
                                                        <td>
                                                            <p>EMI Amount</p>
                                                            <span class="text-secondary d-block">{{ $bodyLoan->emi_amount ?? '-' }}</span>
                                                        </td>
                                                        {{--<td>
                                                            <p>EMI Amount With Interest</p>
                                                            <span class="text-secondary d-block">{{ $bodyLoan->total_amt_with_interest ?? '-' }}</span>
                                                        </td>--}}
                                                        <td>
                                                            <p>Start Date</p>
                                                            <span class="text-secondary d-block">
                                                                {{ $bodyLoan->emi_start_date 
                                                                    ? \Carbon\Carbon::parse($bodyLoan->emi_start_date)->format('d/m/Y') 
                                                                    : '-' 
                                                                }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <p>End Date</p>
                                                            <span class="text-secondary d-block">
                                                                {{ $bodyLoan->emi_end_date 
                                                                    ? \Carbon\Carbon::parse($bodyLoan->emi_end_date)->format('d/m/Y') 
                                                                    : '-' 
                                                                }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <p>Loan Account Number</p>
                                                            <span class="text-secondary d-block">{{ $bodyLoan->loan_account_no ?? '-' }}</span>
                                                        </td>
                                                        <td>
                                                            <p>Loan Status</p>
                                                            @php
                                                                $status = $bodyLoan->status ?? 'Ongoing';
                                                            @endphp
                                                            
                                                            <span class="badge
                                                                @if($status == 'Closed') badge-danger
                                                                @elseif($status == 'Overdue') badge-warning
                                                                @elseif($status == 'Due Today') badge-info
                                                                @else badge-success
                                                                @endif">
                                                                
                                                                {{ $status }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    @else
                                                    <tr>
                                                        <td colspan="6" class="text-center text-muted">
                                                            No Body Loan Available!
                                                        </td>
                                                    </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                    </div>
                                </div>

                                <div>
                                <a
                                    href="javascript:void(0)"
                                    class="addtripbtn AddNewFinance"
                                    data-FinanceType="Body"
                                    data-bs-toggle="modal"
                                    data-bs-target="#add_finance"><i class="uil uil-plus me-1"></i>Add Finance</a>
                                <a
                                    href="javascript:void(0)"
                                    class="addtripbtn ViewFinance"
                                    data-id="{{ $bodyLoan->id ?? '' }}"
                                    data-bs-toggle="modal"
                                    ><i class="uil uil-eye me-1"></i>View Finance</a
                                >
                                </div>
                                
                                </div>
                                
                                
                            
                            <div class="table-responsive">
                                <table class="table custom-driver-table">
                                    <thead>
                                        <tr>
                                            <th>Finance Amount</th>
                                            <th>EMI Date</th>
                                            <th>Payment Status</th>
                                            <th>Notes</th>
                                        </tr>
                                    </thead>
                            
                                    <tbody>
                                        @forelse($bodyEmis as $emi)
                                            <tr>
                                                <td>{{ number_format($emi->emi_amount, 2) ?? '-' }}</td>
                                                <td>
                                                    {{ $emi->emi_date ? \Carbon\Carbon::parse($emi->emi_date)->format('d/m/Y') : '-' }}
                                                </td>
                                                @php
                                                    $status = $emi->status;
                                                    $badgeClass = match($status) {
                                                        'Paid' => 'badge-success',
                                                        'Pending' => 'badge-warning',
                                                        'Overdue' => 'badge-danger',
                                                        default => 'badge-secondary',
                                                    };
                                                @endphp
                                                
                                                <td>
                                                    <span class="badge {{ $badgeClass }}">
                                                        {{ $status ?? 'N/A' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="javascript:void(0)" data-emiId="{{ $emi->id }}" data-loanaccountId="{{ $emi->loanaccount_id }}" class="text-success" data-bs-toggle="modal" data-bs-target="#addNotes">+</a>
                                                    <a href="javascript:void(0)" data-emiId="{{ $emi->id }}" data-loanaccountId="{{ $emi->loanaccount_id }}" class="text-primary" data-bs-toggle="modal" data-bs-target="#viewNotes"><i class="uil uil-eye"></i></a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center">No Body EMI records found!</td>
                                            </tr>
                                        @endforelse
                            
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                          </div>
                        </div>
                        
                    </div>
                    <!--Emi-book-start-->

                    <!--Documents-content-here-Start-->
                    <div class="tab-pane fade" id="documents">
                        <div class="totalrevenue mt-3">
                            <div class="item-row">
                                <div class="itemcol">
                                    <p>Total Document</p>
                                    <span class="number c-01">3</span>
                                </div>

                                <div class="itemcol">
                                    <p>Expired</p>
                                    <span class="number c-02">2</span>
                                </div>

                                <div class="itemcol">
                                    <p>Expiring Soon</p>
                                    <span class="number c-03">0</span>
                                </div>

                                <div class="itemcol">
                                    <p>Valid</p>
                                    <span class="number c-04">1</span>
                                </div>
                            </div>
                        </div>

                        <div class="vehiclestable">
                            <div class="itemtop">
                                <span class="sec-title">Vehicle Documents</span>
                                <a
                                    href="#"
                                    class="addtripbtn"
                                    data-bs-toggle="modal"
                                    data-bs-target="#add_v_documents"
                                    data-bs-target="#add_v_documents"
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
                                            <th>Expiary Date</th>
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
                                                <!-- Row 1 -->
                                                <tr>
                                                    <td>Hub Greasing</td>
                                                    <td>27-08-2025</td>
                                                    <td>₹56420</td>
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
                                    
                                                <!-- Row 2 -->
                                                <tr>
                                                    <td>Painting</td>
                                                    <td>27-08-2025</td>
                                                    <td>₹56420</td>
                                                    <td>350</td>
                                                    <td><span class="badge badge-success">Up to Date</span></td>
                                                    <td class="text-center">
                                                        <a class="item-edit text-success">
                                                            <i class="uil uil-pen me-2"></i>
                                                        </a>
                                                        <a class="item-delete text-danger">
                                                            <i class="uil uil-trash-alt"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                    
                                                <!-- Row 3 -->
                                                <tr>
                                                    <td>Electric</td>
                                                    <td>27-08-2025</td>
                                                    <td>₹56420</td>
                                                    <td>140</td>
                                                    <td><span class="badge badge-success">Up to Date</span></td>
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

                    <!--allotment-->
                    <div class="tab-pane fade" id="allotment">
                        
                        <div class="filter-options">
                            <div class="item-filter">
                                <span class="filter-icon">
                                    <img src="{{ asset('images/icons/filter-01icon.png') }}" alt="icon" />
                                </span>
                                <p>Filter Options</p>
                            </div>

                            <form class="filterbd">
                                <div class="row item-row02 mt-3">
                                    <div class="col-lg-3 form-group">
                                        <label for="vehicleType">Bill Status</label>
                                        <div class="input-wrapper">
                                            <select class="form-select">
                                                <option>Choose</option>
                                                <option>Paid</option>
                                                <option>Pending</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 form-group">
                                        <label for="vehicleType">Bill Number</label>
                                        <div class="input-wrapper">
                                            <input
                                                type="text"
                                                class="form-control itemtext"
                                            />
                                            <button type="button" class="clear-btn">
                                                <i class="uil uil-times-circle"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 form-group d-flex">
                                        <div class="input-wrapper">
                                            
                                            <div class="search_rcnumber">
                                                <div class="input-lt">
                                                    <input
                                                        class="input_search"
                                                        type="text"
                                                        placeholder="Search by LR Number, Ref LR Number, route, material.."
                                                    />
                                                </div>

                                                <div class="input-reset">
                                                    <button class="btn refresh-btn"><i class="uil uil-search"></i></button>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        
                                        <!--<button class="btn fxportbtn" type="button">Export <i class="uil uil-export me-1"></i> </button>-->
                                        <!--<button class="btn btn-primary d-flex ms-1" type="button"><i class="uil uil-sync me-1"></i>Reset</button>-->
                                        <!--////-->

                                        <div class="dropdown fxportbtn ms-1">
                                            <button
                                                class="btn btn-primary dropdown-toggle d-flex"
                                                type="button"
                                                id="exportBtn"
                                                data-bs-toggle="dropdown"
                                                aria-expanded="false"
                                            >
                                                Export <i class="uil uil-upload ms-1"></i>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="exportBtn">
                                                <li>
                                                    <a class="dropdown-item" href="javascript:void(0)">Excel</a>
                                                </li>
                                                <li><a class="dropdown-item" href="javascript:void(0)">PDF</a></li>
                                            </ul>
                                        </div>

                                        <!--////-->
                                        
                                    </div>

                                    <!--<div class="col-lg-1 form-group">-->
                                    <!--  <button class="btn fxportbtn" type="button">Export <i class="uil uil-export me-1"></i> </button>-->
                                    <!--</div>-->
                                </div>
                            </form>
                        </div>

                        
                        <div class="vehiclestable">
                            <div class="table-responsive">
                                <table class="table custom-driver-table">
                                    <thead>
                                        <tr>
                                            <th>Vehicle Number</th>
                                            <th>Issue Date & Time</th>
                                            <th>Revoke Date & Time</th>
                                            <th>Number of Trips</th>
                                            <th>Assigned Driver</th>
                                            <th>Reason</th>
                                            <th>Remarks</th>
                                            <th class="text-center" style="width: 210px;">Actions</th>
                                        </tr>
                                    </thead>
                            
                                    <tbody>
                                        <!-- Row 1 -->
                                        <tr>
                                            <td>MH-10-AB-1834</td>
                                            <td>08-09-2025 | FN</td>
                                            <td>08-01-2025 | AN</td>
                                            <td>20</td>
                                            <td>Rakesh Das</td>
                                            <td>Engine parts messing</td>
                                            <td>No Malpractice</td>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="badge bg-success">Remarks</a>
                                                <a href="javascript:void(0)" class="badge bg-info">View Details</a>
                                            </td>
                                        </tr>
                            
                                        <!-- Row 2 -->
                                        <tr>
                                            <td>MH-10-AB-1834</td>
                                            <td>08-09-2025 | FN</td>
                                            <td>08-12-2025 | AN</td>
                                            <td>20</td>
                                            <td>Suman Pal</td>
                                            <td>Engine parts messing</td>
                                            <td>No Malpractice</td>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="badge bg-info">View Details</a>
                                            </td>
                                        </tr>
                            
                                        <!-- Row 3 -->
                                        <tr>
                                            <td>MH-10-AB-1834</td>
                                            <td>07-11-2025 | FN</td>
                                            <td>08-01-2025 | AN</td>
                                            <td>20</td>
                                            <td>Sovan Pal</td>
                                            <td>Engine parts messing</td>
                                            <td>No Malpractice</td>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="badge bg-info">View Details</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                    </div>
                    <!--Allotment-End-->

                    <!--comment-->
                    {{-- ═══ INSURANCE TAB ═══ --}}
                    <div class="tab-pane fade" id="insurance">
                        <div style="padding:4px 0 20px;">

                            {{-- Tab header with Raise Claim action --}}
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div>
                                    <span style="font-size:14px;font-weight:700;color:#032671;">Insurance</span>
                                    <span style="font-size:12px;color:#888;margin-left:8px;">Policy details &amp; claim history for this vehicle</span>
                                </div>
                                <button class="btn btn-theme btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#newClaimModal"
                                    onclick="prefillClaimVehicle('{{ $vehicle->vehicle_no ?? '' }}')">
                                    <i class="uil uil-plus me-1"></i>Raise Claim
                                </button>
                            </div>

                            {{-- Active Policy Card --}}
                            <div style="background:#fff;border:1px solid #e4e7ef;border-radius:8px;padding:16px 18px;margin-bottom:14px;">
                                <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#032671;margin-bottom:12px;">
                                    <i class="uil uil-shield-check me-1"></i>Current Policy
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-3 col-6">
                                        <div style="font-size:11px;color:#888;font-weight:600;text-transform:uppercase;letter-spacing:.3px;margin-bottom:3px;">Insurer</div>
                                        <div style="font-size:13px;font-weight:600;color:#2d2d2d;">ICICI Lombard</div>
                                    </div>
                                    <div class="col-md-3 col-6">
                                        <div style="font-size:11px;color:#888;font-weight:600;text-transform:uppercase;letter-spacing:.3px;margin-bottom:3px;">Policy No.</div>
                                        <div style="font-size:12px;font-weight:600;color:#2d2d2d;font-family:monospace;">ICICILOM/CV/2025/{{ $vehicle->vehicle_no ?? 'TS09AB1234' }}</div>
                                    </div>
                                    <div class="col-md-2 col-6">
                                        <div style="font-size:11px;color:#888;font-weight:600;text-transform:uppercase;letter-spacing:.3px;margin-bottom:3px;">Type</div>
                                        <div style="font-size:13px;color:#2d2d2d;">Comprehensive</div>
                                    </div>
                                    <div class="col-md-2 col-6">
                                        <div style="font-size:11px;color:#888;font-weight:600;text-transform:uppercase;letter-spacing:.3px;margin-bottom:3px;">Valid Until</div>
                                        <div style="font-size:13px;font-weight:700;color:#10863f;">14 Apr 2027</div>
                                        <div style="font-size:10px;color:#10863f;">367 days left</div>
                                    </div>
                                    <div class="col-md-2 col-6">
                                        <div style="font-size:11px;color:#888;font-weight:600;text-transform:uppercase;letter-spacing:.3px;margin-bottom:3px;">IDV</div>
                                        <div style="font-size:13px;font-weight:700;color:#032671;">₹28,50,000</div>
                                    </div>
                                </div>
                            </div>

                            {{-- Claims for this vehicle --}}
                            <div style="background:#fff;border:1px solid #e4e7ef;border-radius:8px;overflow:hidden;">
                                <div style="background:#f8f9fc;border-bottom:1px solid #e4e7ef;padding:10px 16px;display:flex;align-items:center;justify-content:space-between;">
                                    <span style="font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#032671;">
                                        <i class="uil uil-file-alt me-1"></i>Claims History
                                    </span>
                                    <a href="{{ route('fleet.insurance.index') }}" style="font-size:11px;color:#032671;">View all claims →</a>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0" style="font-size:12px;">
                                        <thead>
                                            <tr style="background:#f8f9fc;">
                                                <th style="font-size:11px;font-weight:700;color:#6c757d;text-transform:uppercase;letter-spacing:.4px;padding:8px 14px;border-bottom:2px solid #e4e7ef;white-space:nowrap;">Claim #</th>
                                                <th style="font-size:11px;font-weight:700;color:#6c757d;text-transform:uppercase;letter-spacing:.4px;padding:8px 14px;border-bottom:2px solid #e4e7ef;">Incident Date</th>
                                                <th style="font-size:11px;font-weight:700;color:#6c757d;text-transform:uppercase;letter-spacing:.4px;padding:8px 14px;border-bottom:2px solid #e4e7ef;">Type</th>
                                                <th style="font-size:11px;font-weight:700;color:#6c757d;text-transform:uppercase;letter-spacing:.4px;padding:8px 14px;border-bottom:2px solid #e4e7ef;">Workshop</th>
                                                <th style="font-size:11px;font-weight:700;color:#6c757d;text-transform:uppercase;letter-spacing:.4px;padding:8px 14px;border-bottom:2px solid #e4e7ef;text-align:right;">Claimed</th>
                                                <th style="font-size:11px;font-weight:700;color:#6c757d;text-transform:uppercase;letter-spacing:.4px;padding:8px 14px;border-bottom:2px solid #e4e7ef;text-align:right;">Received</th>
                                                <th style="font-size:11px;font-weight:700;color:#6c757d;text-transform:uppercase;letter-spacing:.4px;padding:8px 14px;border-bottom:2px solid #e4e7ef;">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td style="padding:9px 14px;border-bottom:1px solid #f0f2f7;vertical-align:middle;">
                                                    <a href="{{ route('fleet.insurance.detail', 1) }}" style="font-weight:700;color:#032671;font-size:11px;text-decoration:none;">CLM-2024-0048</a>
                                                </td>
                                                <td style="padding:9px 14px;border-bottom:1px solid #f0f2f7;vertical-align:middle;color:#555;">08 Dec 2024</td>
                                                <td style="padding:9px 14px;border-bottom:1px solid #f0f2f7;vertical-align:middle;">
                                                    <span style="background:#e3ecff;color:#032671;font-size:10px;font-weight:700;padding:2px 8px;border-radius:10px;">Own Damage</span>
                                                </td>
                                                <td style="padding:9px 14px;border-bottom:1px solid #f0f2f7;vertical-align:middle;color:#555;">
                                                    <i class="uil uil-home-alt" style="color:#032671;font-size:12px;"></i> SC-HYD (Own)
                                                </td>
                                                <td style="padding:9px 14px;border-bottom:1px solid #f0f2f7;vertical-align:middle;text-align:right;font-weight:600;color:#032671;">₹2,40,000</td>
                                                <td style="padding:9px 14px;border-bottom:1px solid #f0f2f7;vertical-align:middle;text-align:right;color:#adb5bd;">—</td>
                                                <td style="padding:9px 14px;border-bottom:1px solid #f0f2f7;vertical-align:middle;">
                                                    <span style="background:#fff3e0;color:#e65100;font-size:10px;font-weight:700;padding:2px 8px;border-radius:10px;white-space:nowrap;">Survey in Progress</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding:9px 14px;border-bottom:1px solid #f0f2f7;vertical-align:middle;">
                                                    <a href="{{ route('fleet.insurance.detail', 2) }}" style="font-weight:700;color:#032671;font-size:11px;text-decoration:none;">CLM-2023-0031</a>
                                                </td>
                                                <td style="padding:9px 14px;border-bottom:1px solid #f0f2f7;vertical-align:middle;color:#555;">14 Jul 2023</td>
                                                <td style="padding:9px 14px;border-bottom:1px solid #f0f2f7;vertical-align:middle;">
                                                    <span style="background:#e3ecff;color:#032671;font-size:10px;font-weight:700;padding:2px 8px;border-radius:10px;">Own Damage</span>
                                                </td>
                                                <td style="padding:9px 14px;border-bottom:1px solid #f0f2f7;vertical-align:middle;color:#555;">
                                                    <i class="uil uil-store" style="color:#e65100;font-size:12px;"></i> Tata SC, Kurnool
                                                    <span style="display:block;font-size:10px;color:#adb5bd;">External · Cashless</span>
                                                </td>
                                                <td style="padding:9px 14px;border-bottom:1px solid #f0f2f7;vertical-align:middle;text-align:right;font-weight:600;color:#032671;">₹95,000</td>
                                                <td style="padding:9px 14px;border-bottom:1px solid #f0f2f7;vertical-align:middle;text-align:right;font-size:11px;">
                                                    <span style="color:#adb5bd;font-size:10px;display:block;">Excess paid</span>
                                                    <span style="font-weight:700;color:#10863f;">₹25,000</span>
                                                </td>
                                                <td style="padding:9px 14px;border-bottom:1px solid #f0f2f7;vertical-align:middle;">
                                                    <span style="background:#e6f4ea;color:#10863f;font-size:10px;font-weight:700;padding:2px 8px;border-radius:10px;">Settled</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="7" style="padding:16px 14px;text-align:center;color:#adb5bd;font-size:12px;border:0;">
                                                    <i class="uil uil-info-circle me-1"></i>
                                                    Showing last 2 claims for this vehicle.
                                                    <a href="{{ route('fleet.insurance.index') }}" style="color:#032671;">View all →</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                    {{-- ═══ END INSURANCE TAB ═══ --}}

                    <div class="tab-pane fade vdtl_comment1sec" id="comment">
                        <!--comment content here...-->
                        <div class="note-box">
                            <label for="noteInput" class="form-label"
                                >Comments<i class="bi bi-info-circle"></i
                            ></label>
                            
                            <form action="{{ route('fleetdashboard.vehicle.comment.store', $vehicle->id) }}" id="commentForm">
                                @csrf
                                <div class="note-input-wrapper">
                                    <div class="note-avatar">{{ Auth::user()->name[0] }}</div>
    
                                    <div class="note-input-area">
                                        <input type="text" name="comment" id="noteInput" class="form-control" placeholder="Comments" />
                                        <span class="text-danger error" id="comment_error"></span>
                                    </div>
    
                                    <button type="submit" class="note-send-btn submitBtn">
                                        <i class="bi bi-send"></i>
                                    </button>
                                </div>
                            </form>

                            <div class="text_bdwrapper">
                                @forelse($vehicle->comments as $comment)
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
                                    
                                <!--<div class="item_row">
                                    <div class="name_fw">R</div>
                                    <div class="text_bd">
                                        <span>Rahul Das</span>
                                        <p>
                                            Vivamus cursus tempus ornare. Vestibulum vel est et tellus rhoncus
                                            pellentesque vel bibendum erat.
                                        </p>
                                    </div>
                                    <div class="time_sec">Just Now</div>
                                </div>

                                <div class="item_row">
                                    <div class="name_fw">T</div>
                                    <div class="text_bd">
                                        <span>Tapon Sarkar</span>
                                        <p>
                                            Etiam pharetra tempor feugiat. Sed nec posuere urna. Integer blandit dui
                                            ut blandit dapibus. Curabitur at rhoncus ipsum. Vivamus congue mauris
                                            non varius condimentum. Vestibulum quis eros et velit facilisis
                                            suscipit. Praesent gravida eleifend lorem interdum tincidunt. Proin sit
                                            amet tempor arcu.
                                        </p>
                                    </div>
                                    <div class="time_sec">2 Minutes Ago</div>
                                </div>

                                <div class="item_row">
                                    <div class="name_fw">A</div>
                                    <div class="text_bd">
                                        <span>Akash Dey</span>
                                        <p>
                                            Praesent gravida eleifend lorem interdum tincidunt. Proin sit amet
                                            tempor arcu.
                                        </p>
                                    </div>
                                    <div class="time_sec">30 Minutes Ago</div>
                                </div>-->
                                
                                
                            </div>
                        </div>
                    </div>
                    <!--comment-End-->
                </div>
            </div>
        </div>
        <!--/////-->
    </div>
        
        
        
        
    </div>
   
</div>
    


    
    
<!-- Modal -->
<div class="modal fade" id="notAssigned02" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modify Driver</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="uil uil-times"></i>
                </button>
            </div>

            <div class="modal-body">
                
                <form action="{{route('fleetdashboard.updateDriver')}}" class="notassigned_bd" method="POST" id="modifyDriverForm">
                    @csrf
                    
                    <input type="hidden" name="modal_vehicle_id" id="modal_vehicle_id" value="" /> 
                    <input type="hidden" name="modal_current_driver_id" id="modal_current_driver_id" value="" />
                    
                    <div class="top_block">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>
                                        <p>Vehicle</p>
                                    </td>
                                    <td>
                                        <span class="text-secondary d-block" id="modal_vehicle_no"></span>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <p>Driver Name</p>
                                    </td>
                                    <td>
                                        <span class="text-secondary d-block" id="modal_driver_name"></span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="select_driver">
                        <span class="open_01driver">Select Driver</span>
                    </div>

                    <div class="input_bd changedriver_bd">
                        <div class="row">
                            <div class="col-12 col-md-6 form-group">
                                <label>Change Driver</label>
                                <select name="driver_id" id="driver_select" class="form-control select2">
                                    <option value="">Select</option>
                                </select>
                                <small class="error text-danger" id="add_driver_id_error"></small>
                            </div>

                            <div class="col-12 col-md-6 form-group">
                                <label>Assigned From</label>
                                <input class="datetime form-control" type="text" name="assign_date" readonly />
                                <small class="error text-danger" id="add_assign_date_error"></small>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <a href="{{ route('contact.driver.create') }}" target="_blank" class="btn btn-secondary">Add New Driver</a>
                
                <button class="btn btn-primary" id="modifyDriverBtn">Save</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addGPS" tabindex="-1" aria-labelledby="gps_det" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header p-3">
                <h5 class="modal-title" id="gps_det">Add GPS Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="uil uil-times"></i>
                </button>
            </div>

            <div class="modal-body p-3 pt-0">
                <form action="{{ route('fleetdashboard.saveGpsDetails', $vehicle->id) }}" method="POST" id="addGPSForm">
                    @csrf
                    <div class="row">
                        <div class="form-group col-12 col-md-6">
                            <label>GPS Provider <span class="text-danger">*</span></label>
                            <select name="gps_provider_id" class="form-select select2">
                                <option value="">Choose</option>
                                @foreach($gpsproviders as $provider)
                                <option value="{{ $provider->id }}">{{ $provider->name }}</option>
                                @endforeach
                            </select>
                            <small class="error text-danger" id="add_gps_provider_id_error"></small>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>GPS Type <span class="text-danger">*</span></label>
                            <select name="gps_type" class="form-select">
                                <option value="">Choose</option>
                                <option value="New">New</option>
                                <option value="Renewal">Renewal</option>
                                <option value="Replacement">Replacement</option>
                            </select>
                            <small class="error text-danger" id="add_gps_type_error"></small>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>GPS Device Issue Date <span class="text-danger">*</span></label>
                            <input type="date" name="device_issue_date" class="form-control general_date">
                            <small class="error text-danger" id="add_device_issue_date_error"></small>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>GPS Device Warranty <span class="text-danger">*</span></label>
                            <input type="number" name="device_warranty" class="form-control">
                            <small class="error text-danger" id="add_device_warranty_error"></small>
                        </div>
                        <!--<div class="form-group col-12 col-md-6">-->
                        <!--    <label>GPS Device Remaining Warranty <span class="text-danger">*</span></label>-->
                        <!--    <input type="number" name="device_remaining_warranty" class="form-control">-->
                        <!--    <small class="error text-danger" id="add_device_remaining_warranty_error"></small>-->
                        <!--</div>-->
                        <div class="form-group col-12 col-md-6">
                            <label>GPS Plan Start Date <span class="text-danger">*</span></label>
                            <input type="date" name="gps_plan_start_date" id="gps_plan_start_date" class="form-control general_date">
                            <small class="error text-danger" id="add_plan_start_date_error"></small>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>GPS Plan Validity (No. of Months) <span class="text-danger">*</span></label>
                            <input type="text" name="gps_plan_validity" id="gps_plan_validity" class="form-control">
                            <small class="error text-danger" id="add_gps_plan_validity_error"></small>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>Renew Date <span class="text-danger">*</span></label>
                            <input type="date" name="gps_plan_renew_date" id="gps_plan_renew_date" class="form-control" readonly>
                            <small class="error text-danger" id="add_plan_renew_date_error"></small>
                        </div>
                        
                        <div class="form-group col-12 col-md-6">
                            <label>GPS Device Cost <span class="text-danger">*</span></label>
                            <input type="text" name="gps_device_cost" class="form-control">
                            <small class="error text-danger" id="add_gps_device_cost_error"></small>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>GPS Plan Charges <span class="text-danger">*</span></label>
                            <input type="text" name="gps_plan_cost" class="form-control">
                            <small class="error text-danger" id="add_gps_plan_cost_error"></small>
                        </div>
                        
                        <div class="col-12 text-end mt-4">
                            <button type="button" id="addGPSBtn" class="btn btn-primary">Save</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editGPS" tabindex="-1" aria-labelledby="gps_det" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header p-3">
                <h5 class="modal-title" id="gps_det">Edit GPS Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="uil uil-times"></i>
                </button>
            </div>

            <div class="modal-body p-3 pt-0">
                <form action="{{ route('fleetdashboard.updateGpsDetail', $vehicle->id) }}" method="POST" id="editGPSForm">
                    @csrf
                    
                    <input type="hidden" name="id" id="edit_id_input">
                    
                    <div class="row">
                        <div class="form-group col-12 col-md-6">
                            <label>GPS Provider <span class="text-danger">*</span></label>
                            <select name="gps_provider_id" id="edit_gps_provider_id" class="form-select select2">
                                <option value="">Choose</option>
                                @foreach($gpsproviders as $provider)
                                <option value="{{ $provider->id }}">{{ $provider->name }}</option>
                                @endforeach
                            </select>
                            <small class="error text-danger" id="edit_gps_provider_id_error"></small>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>GPS Type <span class="text-danger">*</span></label>
                            <select name="gps_type" id="edit_gps_type" class="form-select">
                                <option value="">Choose</option>
                                <option value="New">New</option>
                                <option value="Renewal">Renewal</option>
                                <option value="Replacement">Replacement</option>
                            </select>
                            <small class="error text-danger" id="edit_gps_type_error"></small>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>GPS Device Issue Date <span class="text-danger">*</span></label>
                            <input type="date" name="device_issue_date" id="edit_device_issue_date" class="form-control general_date">
                            <small class="error text-danger" id="edit_device_issue_date_error"></small>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>GPS Device Warranty <span class="text-danger">*</span></label>
                            <input type="number" name="device_warranty" id="edit_device_warranty" class="form-control">
                            <small class="error text-danger" id="edit_device_warranty_error"></small>
                        </div>
                        
                        <!--<div class="form-group col-12 col-md-6">-->
                        <!--    <label>GPS Device Remaining Warranty <span class="text-danger">*</span></label>-->
                        <!--    <input type="number" name="device_remaining_warranty" id="edit_device_remaining_warranty" class="form-control">-->
                        <!--    <small class="error text-danger" id="edit_device_remaining_warranty_error"></small>-->
                        <!--</div>-->
                        
                        <div class="form-group col-12 col-md-6">
                            <label>GPS Plan Start Date <span class="text-danger">*</span></label>
                            <input type="date" name="gps_plan_start_date" id="edit_gps_plan_start_date" class="form-control general_date">
                            <small class="error text-danger" id="edit_plan_start_date_error"></small>
                        </div>
                        
                        <div class="form-group col-12 col-md-6">
                            <label>GPS Plan Validity (No. of Months) <span class="text-danger">*</span></label>
                            <input type="text" name="gps_plan_validity" id="edit_gps_plan_validity" class="form-control">
                            <small class="error text-danger" id="edit_gps_plan_validity_error"></small>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>Renew Date <span class="text-danger">*</span></label>
                            <input type="date" name="gps_plan_renew_date" id="edit_gps_plan_renew_date" class="form-control" readonly>
                            <small class="error text-danger" id="edit_plan_renew_date_error"></small>
                        </div>
                        
                        <div class="form-group col-12 col-md-6">
                            <label>GPS Device Cost <span class="text-danger">*</span></label>
                            <input type="text" name="gps_device_cost" id="edit_gps_device_cost" class="form-control">
                            <small class="error text-danger" id="edit_gps_device_cost_error"></small>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>GPS Plan Charges <span class="text-danger">*</span></label>
                            <input type="text" name="gps_plan_cost" id="edit_gps_plan_cost" class="form-control">
                            <small class="error text-danger" id="edit_gps_plan_cost_error"></small>
                        </div>
                        
                        
                        <div class="col-12 text-end mt-4">
                            <button type="button" id="editGPSBtn" class="btn btn-primary">Save</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addFasttag" tabindex="-1" aria-labelledby="gps_det" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header p-3">
                <h5 class="modal-title" id="gps_det">Add Fasttag Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="uil uil-times"></i>
                </button>
            </div>

            <div class="modal-body p-3 pt-0">
                <form action="{{ route('fleetdashboard.saveFasttagDetails', $vehicle->id) }}" method="POST" id="addFasttagForm">
                    @csrf
                    <div class="row">
                        <div class="form-group col-12 col-md-6">
                            <label>Fasttag Provider <span class="text-danger">*</span></label>
                            <select name="fasttag_provider_id" id="" class="form-select select2">
                                <option value="">Choose</option>
                                @foreach($fasttagproviders as $provider)
                                <option value="{{ $provider->id }}">{{ $provider->name }}</option>
                                @endforeach
                            </select>
                            <small class="error text-danger" id="add_fasttag_provider_id_error"></small>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>Fasttag Bank Name <span class="text-danger">*</span></label>
                            <input type="text" name="fasttag_bank_name" class="form-control">
                            <small class="error text-danger" id="add_fasttag_bank_name_error"></small>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>Fasttag ID <span class="text-danger">*</span></label>
                            <input type="text" name="fasttag_id" class="form-control">
                            <small class="error text-danger" id="add_fasttag_id_error"></small>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>Fasttag Issue Date <span class="text-danger">*</span></label>
                            <input type="date" name="fasttag_issue_date" class="form-control general_date">
                            <small class="error text-danger" id="add_fasttag_issue_date_error"></small>
                        </div>
                        <div class="col-12 text-end mt-4">
                            <button type="button" id="addFasttagBtn" class="btn btn-primary">Save</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editFasttag" tabindex="-1" aria-labelledby="gps_det" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header p-3">
                <h5 class="modal-title" id="gps_det">Edit Fasttag Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="uil uil-times"></i>
                </button>
            </div>

            <div class="modal-body p-3 pt-0">
                <form action="{{ route('fleetdashboard.updateFasttagDetail', $vehicle->id) }}" method="POST" id="editFasttagForm">
                    @csrf
                    
                    <input type="hidden" name="id" id="edit_fasttagid_input">
                    <div class="row">
                        <div class="form-group col-12 col-md-6">
                            <label>Fasttag Provider <span class="text-danger">*</span></label>
                            <select name="fasttag_provider_id" id="edit_fasttag_provider_id" class="form-select select2">
                                <option value="">Choose</option>
                                @foreach($fasttagproviders as $provider)
                                <option value="{{ $provider->id }}">{{ $provider->name }}</option>
                                @endforeach
                            </select>
                            <small class="error text-danger" id="edit_fasttag_provider_id_error"></small>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>Fasttag Bank Name <span class="text-danger">*</span></label>
                            <input type="text" name="fasttag_bank_name" id="edit_fasttag_bank_name" class="form-control">
                            <small class="error text-danger" id="edit_fasttag_bank_name_error"></small>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>Fasttag ID <span class="text-danger">*</span></label>
                            <input type="text" name="fasttag_id" id="edit_fasttag_id" class="form-control">
                            <small class="error text-danger" id="edit_fasttag_id_error"></small>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>Fasttag Issue Date <span class="text-danger">*</span></label>
                            <input type="date" name="fasttag_issue_date" id="edit_fasttag_issue_date" class="form-control general_date">
                            <small class="error text-danger" id="edit_fasttag_issue_date_error"></small>
                        </div>
                        <div class="col-12 text-end mt-4">
                            <button type="button" id="editFasttagBtn" class="btn btn-primary">Save</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addTyre" tabindex="-1" aria-labelledby="tyre_det" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header p-3">
                <h5 class="modal-title" id="tyre_det">Add Tyre Details</h5> 
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="uil uil-times"></i>
                </button>
            </div>

            <div class="modal-body p-3 pt-0">
                <form action="{{ route('fleetdashboard.saveTyreDetails', $vehicle->id) }}" method="POST" id="addTyreForm">
                    @csrf
                    <div class="row">
                        <div class="form-group col-12 col-md-6">
                            <label>Tyre Model Name<span class="text-danger">*</span></label>
                            <input type="text" name="tyre_model_name" class="form-control">
                            <small class="error text-danger" id="add_tyre_model_name_error"></small>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>Tyre Type<span class="text-danger">*</span></label>
                            <select name="tyre_type" class="form-control">
                                <!--<option name="">Choose</option>-->
                                <option name="Radial">Radial</option>
                                <option name="Nylon">Nylon</option>
                            </select>
                            <small class="error text-danger" id="add_tyre_type_error"></small>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>Tyre Brand <span class="text-danger">*</span></label>
                            <input type="text" name="tyre_brand" class="form-control">
                            <small class="error text-danger" id="add_tyre_brand_error"></small>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>Tyre Price <span class="text-danger">*</span></label>
                            <input type="text" name="tyre_price" class="form-control">
                            <small class="error text-danger" id="add_tyre_price_error"></small>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>Tyre Serial Number <span class="text-danger">*</span></label>
                            <input type="text" name="tyre_serial_number" class="form-control">
                            <small class="error text-danger" id="add_tyre_serial_number_error"></small>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>Tyre Position <span class="text-danger">*</span></label>
                            <input type="text" name="tyre_position" class="form-control">
                            <small class="error text-danger" id="add_tyre_position_error"></small>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>Purchase Date <span class="text-danger">*</span></label>
                            <input type="date" name="tyre_purchase_date" class="form-control general_date">
                            <small class="error text-danger" id="add_tyre_purchase_date_error"></small>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>Issue Date <span class="text-danger">*</span></label>
                            <input type="date" name="tyre_issue_date" class="form-control general_date">
                            <small class="error text-danger" id="add_tyre_issue_date_error"></small>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>Warranty (Months) <span class="text-danger">*</span></label>
                            <input type="text" name="tyre_warranty_months" class="form-control">
                            <small class="error text-danger" id="add_tyre_warranty_error"></small>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>Fixed Run KM</label>
                            <input type="text" name="fixed_run_km" class="form-control">
                            <small class="error text-danger" id="add_fixed_run_km_error"></small>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>Fixed Life (Months)</label>
                            <input type="text" name="fixed_life_months" class="form-control">
                            <small class="error text-danger" id="add_fixed_life_month_error"></small>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>Actual Run KM</label>
                            <input type="text" name="actual_run_km" class="form-control">
                            <small class="error text-danger" id="add_actual_run_km_error"></small>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>Actual Run Month</label>
                            <input type="text" name="actual_run_month" class="form-control">
                            <small class="error text-danger" id="add_actual_run_month_error"></small>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>Remaining Run KM</label>
                            <input type="text" name="remaining_run_km" class="form-control">
                            <small class="error text-danger" id="add_remaining_run_km_error"></small>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>Remaining Life (Months)</label>
                            <input type="text" name="remaining_life_month" class="form-control">
                            <small class="error text-danger" id="add_remaining_life_month_error"></small>
                        </div>
                        <div class="form-group col-12 col-md-6"></div>
                        <div class="form-group col-12 col-md-6">
                            <label>Alignment Interval KM</label>
                            <input type="text" name="alignment_interval_km" class="form-control">
                            <small class="error text-danger" id="add_alignment_interval_km_error"></small>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>Set Reminder For Alignment?</label>
                            <input type="checkbox" name="set_reminder_for_alignment" >
                            <small class="error text-danger" id="add_set_reminder_for_alignment_error"></small>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>Rotation Interval KM</label>
                            <input type="text" name="rotation_interval_km" class="form-control">
                            <small class="error text-danger" id="add_rotation_interval_km_error"></small>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>Set Reminder For Rotation?</label>
                            <input type="checkbox" name="set_reminder_for_rotation" >
                            <small class="error text-danger" id="add_set_reminder_for_rotation_error"></small>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>Last Alignment KM</label>
                            <input type="text" name="last_alignment_km" class="form-control">
                            <small class="error text-danger" id="add_last_alignment_km_error"></small>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>Last Rotation KM</label>
                            <input type="text" name="last_rotation_km" class="form-control">
                            <small class="error text-danger" id="add_last_rotation_km_error"></small>
                        </div>
                        <div class="col-12 text-end mt-4">
                            <button type="button" id="addTyreBtn" class="btn btn-primary">Save</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editTyre" tabindex="-1" aria-labelledby="tyre_det" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header p-3">
                <h5 class="modal-title" id="tyre_det">Edit Tyre Details</h5> 
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="uil uil-times"></i>
                </button>
            </div>

            <div class="modal-body p-3 pt-0">
                <form action="{{ route('fleetdashboard.updateTyreDetail', $vehicle->id) }}" method="POST" id="editTyreForm">
                    @csrf
                    
                    <input type="hidden" name="id" id="edit_tyreid_input">
                    
                    <div class="row">
                        <div class="form-group col-12 col-md-6">
                            <label>Tyre Model Name<span class="text-danger">*</span></label>
                            <input type="text" name="tyre_model_name" id="edit_tyre_model_name" value="" class="form-control">
                            <small class="error text-danger" id="edit_tyre_model_name_error"></small>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>Tyre Type<span class="text-danger">*</span></label>
                            <select name="tyre_type" id="edit_tyre_type" class="form-control">
                                <!--<option name="">Choose</option>-->
                                <option name="Radial">Radial</option>
                                <option name="Nylon">Nylon</option>
                            </select>
                            <small class="error text-danger" id="edit_tyre_type_error"></small>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>Tyre Brand <span class="text-danger">*</span></label>
                            <input type="text" name="tyre_brand" id="edit_tyre_brand" class="form-control">
                            <small class="error text-danger" id="edit_tyre_brand_error"></small>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>Tyre Price <span class="text-danger">*</span></label>
                            <input type="text" name="tyre_price" id="edit_tyre_price" class="form-control">
                            <small class="error text-danger" id="edit_tyre_price_error"></small>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>Tyre Serial Number <span class="text-danger">*</span></label>
                            <input type="text" name="tyre_serial_number" id="edit_tyre_serial_number" class="form-control">
                            <small class="error text-danger" id="edit_tyre_serial_number_error"></small>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>Tyre Position <span class="text-danger">*</span></label>
                            <input type="text" name="tyre_position" id="edit_tyre_position" class="form-control">
                            <small class="error text-danger" id="edit_tyre_position_error"></small>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>Purchase Date <span class="text-danger">*</span></label>
                            <input type="date" name="tyre_purchase_date" id="edit_tyre_purchase_date" class="form-control general_date">
                            <small class="error text-danger" id="edit_tyre_purchase_date_error"></small>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>Issue Date <span class="text-danger">*</span></label>
                            <input type="date" name="tyre_issue_date" id="edit_tyre_issue_date" class="form-control">
                            <small class="error text-danger" id="edit_tyre_issue_date_error"></small>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>Warranty (Months) <span class="text-danger">*</span></label>
                            <input type="text" name="tyre_warranty_months" id="edit_tyre_warranty_months" class="form-control">
                            <small class="error text-danger" id="edit_tyre_warranty_error"></small>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>Fixed Run KM</label>
                            <input type="text" name="fixed_run_km" id="edit_fixed_run_km" class="form-control">
                            <small class="error text-danger" id="edit_fixed_run_km_error"></small>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>Fixed Life (Months)</label>
                            <input type="text" name="fixed_life_months" id="edit_fixed_life_months" class="form-control">
                            <small class="error text-danger" id="edit_fixed_life_month_error"></small>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>Actual Run KM</label>
                            <input type="text" name="actual_run_km" id="edit_actual_run_km" class="form-control">
                            <small class="error text-danger" id="edit_actual_run_km_error"></small>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>Actual Run Month</label>
                            <input type="text" name="actual_run_month" id="edit_actual_run_month" class="form-control">
                            <small class="error text-danger" id="edit_actual_run_month_error"></small>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>Remaining Run KM</label>
                            <input type="text" name="remaining_run_km" id="edit_remaining_run_km" class="form-control">
                            <small class="error text-danger" id="edit_remaining_run_km_error"></small>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>Remaining Life (Months)</label>
                            <input type="text" name="remaining_life_month" id="edit_remaining_life_month" class="form-control">
                            <small class="error text-danger" id="edit_remaining_life_month_error"></small>
                        </div>
                        <div class="form-group col-12 col-md-6"></div>
                        <div class="form-group col-12 col-md-6">
                            <label>Alignment Interval KM</label>
                            <input type="text" name="alignment_interval_km" id="edit_alignment_interval_km" class="form-control">
                            <small class="error text-danger" id="edit_alignment_interval_km_error"></small>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>Set Reminder For Alignment?</label>
                            <input type="checkbox" name="set_reminder_for_alignment" id="edit_set_reminder_for_alignment" >
                            <small class="error text-danger" id="edit_set_reminder_for_alignment_error"></small>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>Rotation Interval KM</label>
                            <input type="text" name="rotation_interval_km" id="edit_rotation_interval_km" class="form-control">
                            <small class="error text-danger" id="edit_rotation_interval_km_error"></small>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>Set Reminder For Rotation?</label>
                            <input type="checkbox" name="set_reminder_for_rotation" id="edit_set_reminder_for_rotation" >
                            <small class="error text-danger" id="edit_set_reminder_for_rotation_error"></small>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>Last Alignment KM</label>
                            <input type="text" name="last_alignment_km" id="edit_last_alignment_km" class="form-control">
                            <small class="error text-danger" id="edit_last_alignment_km_error"></small>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>Last Rotation KM</label>
                            <input type="text" name="last_rotation_km" id="edit_last_rotation_km" class="form-control">
                            <small class="error text-danger" id="edit_last_rotation_km_error"></small>
                        </div>
                        <div class="col-12 text-end mt-4">
                            <button type="button" id="editTyreBtn" class="btn btn-primary">Save</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addBattery" tabindex="-1" aria-labelledby="battery_det" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header p-3">
                <h5 class="modal-title" id="battery_det">Add Battery Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="uil uil-times"></i>
                </button>
            </div>

            <div class="modal-body p-3 pt-0">
                <form action="{{ route('fleetdashboard.saveBatteryDetails', $vehicle->id) }}" method="POST" id="addBatteryForm"> 
                    @csrf
                    <div class="row">
                        <div class="form-group col-12 col-md-6">
                            <label>Battery Model Name <span class="text-danger">*</span></label>
                            <input type="text" name="battery_model_name" class="form-control">
                            <small class="error text-danger" id="add_battery_model_name_error"></small>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>Battery Capacity <span class="text-danger">*</span></label>
                            <input type="text" name="battery_capacity" class="form-control">
                            <small class="error text-danger" id="add_battery_capacity_error"></small>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>Battery Brand <span class="text-danger">*</span></label>
                            <input type="text" name="battery_brand" class="form-control">
                            <small class="error text-danger" id="add_battery_brand_error"></small>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>Battery Price <span class="text-danger">*</span></label>
                            <input type="text" name="battery_price" class="form-control">
                            <small class="error text-danger" id="add_battery_price_error"></small>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>Battery Serial Number <span class="text-danger">*</span></label>
                            <input type="text" name="battery_serial_number" class="form-control">
                            <small class="error text-danger" id="add_battery_serial_number_error"></small>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>Purchase Date <span class="text-danger">*</span></label>
                            <input type="date" name="battery_purchase_date" class="form-control general_date">
                            <small class="error text-danger" id="add_battery_purchase_date_error"></small>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>Issue Date <span class="text-danger">*</span></label>
                            <input type="date" name="battery_issue_date" class="form-control general_date">
                            <small class="error text-danger" id="add_battery_issue_date_error"></small>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>Warranty (Months) <span class="text-danger">*</span></label>
                            <input type="text" name="battery_warranty_months" class="form-control">
                            <small class="error text-danger" id="add_battery_warranty_months_error"></small>
                        </div>
                        <!--<div class="form-group col-12 col-md-6">-->
                        <!--    <label>Remaining Warranty (Months) <span class="text-danger">*</span></label>-->
                        <!--    <input type="text" name="battery_remaining_warranty_months" class="form-control">-->
                        <!--    <small class="error text-danger" id="add_battery_remaining_warranty_months_error"></small>-->
                        <!--</div>-->
                        <div class="form-group col-12 col-md-6">
                            <label>Fixed Life (Months) <span class="text-danger">*</span></label>
                            <input type="text" name="battery_fixed_life_months" class="form-control">
                            <small class="error text-danger" id="add_battery_fixed_life_months_error"></small>
                        </div>
                        <!--<div class="form-group col-12 col-md-6">-->
                        <!--    <label>Remaining Life (Months) <span class="text-danger">*</span></label>-->
                        <!--    <input type="text" name="battery_remaining_life_months" class="form-control">-->
                        <!--    <small class="error text-danger" id="add_battery_remaining_life_months_error"></small>-->
                        <!--</div>-->
                        <div class="col-12 text-end mt-4">
                            <button type="button" id="addBatteryBtn" class="btn btn-primary">Save</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editBattery" tabindex="-1" aria-labelledby="battery_det" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header p-3">
                <h5 class="modal-title" id="battery_det">Edit Battery Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="uil uil-times"></i>
                </button>
            </div>

            <div class="modal-body p-3 pt-0">
                <form action="{{ route('fleetdashboard.updateBatteryDetail', $vehicle->id) }}" method="POST" id="editBatteryForm"> 
                    @csrf
                    
                    <input type="hidden" name="id" id="edit_batteryid_input">
                    
                    <div class="row">
                        <div class="form-group col-12 col-md-6">
                            <label>Battery Model Name <span class="text-danger">*</span></label>
                            <input type="text" name="battery_model_name" id="edit_battery_model_name" class="form-control">
                            <small class="error text-danger" id="edit_battery_model_name_error"></small>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>Battery Capacity <span class="text-danger">*</span></label>
                            <input type="text" name="battery_capacity" id="edit_battery_capacity" class="form-control">
                            <small class="error text-danger" id="edit_battery_capacity_error"></small>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>Battery Brand <span class="text-danger">*</span></label>
                            <input type="text" name="battery_brand" id="edit_battery_brand" class="form-control">
                            <small class="error text-danger" id="edit_battery_brand_error"></small>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>Battery Price <span class="text-danger">*</span></label>
                            <input type="text" name="battery_price" id="edit_battery_price" class="form-control">
                            <small class="error text-danger" id="edit_battery_price_error"></small>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>Battery Serial Number <span class="text-danger">*</span></label>
                            <input type="text" name="battery_serial_number" id="edit_battery_serial_number" class="form-control">
                            <small class="error text-danger" id="edit_battery_serial_number_error"></small>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>Purchase Date <span class="text-danger">*</span></label>
                            <input type="date" name="battery_purchase_date" id="edit_battery_purchase_date" class="form-control general_date">
                            <small class="error text-danger" id="edit_battery_purchase_date_error"></small>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>Issue Date <span class="text-danger">*</span></label>
                            <input type="date" name="battery_issue_date" id="edit_battery_issue_date" class="form-control general_date">
                            <small class="error text-danger" id="edit_battery_issue_date_error"></small>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>Warranty (Months) <span class="text-danger">*</span></label>
                            <input type="text" name="battery_warranty_months" id="edit_battery_warranty_months" class="form-control">
                            <small class="error text-danger" id="edit_battery_warranty_months_error"></small>
                        </div>
                        <!--<div class="form-group col-12 col-md-6">-->
                        <!--    <label>Remaining Warranty (Months) <span class="text-danger">*</span></label>-->
                        <!--    <input type="text" name="battery_remaining_warranty_months" id="edit_battery_remaining_warranty_months" class="form-control">-->
                        <!--    <small class="error text-danger" id="edit_battery_remaining_warranty_months_error"></small>-->
                        <!--</div>-->
                        <div class="form-group col-12 col-md-6">
                            <label>Fixed Life (Months) <span class="text-danger">*</span></label>
                            <input type="text" name="battery_fixed_life_months" id="edit_battery_fixed_life_months" class="form-control">
                            <small class="error text-danger" id="edit_battery_fixed_life_months_error"></small>
                        </div>
                        <!--<div class="form-group col-12 col-md-6">-->
                        <!--    <label>Remaining Life (Months) <span class="text-danger">*</span></label>-->
                        <!--    <input type="text" name="battery_remaining_life_months" id="edit_battery_remaining_life_months" class="form-control">-->
                        <!--    <small class="error text-danger" id="edit_battery_remaining_life_months_error"></small>-->
                        <!--</div>-->
                        <div class="col-12 text-end mt-4">
                            <button type="button" id="editBatteryBtn" class="btn btn-primary">Save</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addDigitalLock" tabindex="-1" aria-labelledby="digiLoc_det" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header p-3">
                <h5 class="modal-title" id="digiLoc_det">Add Digital Lock Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="uil uil-times"></i>
                </button>
            </div>

            <div class="modal-body p-3 pt-0">
                <form action="{{ route('fleetdashboard.saveDigiLockDetails', $vehicle->id) }}" method="POST" id="addDigitalLockForm"> 
                    @csrf
                    <div class="row">
                        <div class="form-group col-12 col-md-6">
                            <label>Digital Lock Provider <span class="text-danger">*</span></label>
                            <select name="digitallock_provider_id" class="form-select select2">
                                <option value="">Choose</option>
                                @foreach($digitallockproviders as $provider)
                                <option value="{{ $provider->id }}">{{ $provider->name }}</option>
                                @endforeach
                            </select>
                            <small class="error text-danger" id="add_digitallock_provider_id_error"></small>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>Lock Id <span class="text-danger">*</span></label>
                            <input type="text" name="lock_id" class="form-control">
                            <small class="error text-danger" id="add_lock_id_error"></small>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>Lock Issue Date <span class="text-danger">*</span></label>
                            <input type="date" name="lock_issue_date" class="form-control general_date">
                            <small class="error text-danger" id="add_lock_issue_date_error"></small>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label> Lock Warranty Period (Months) <span class="text-danger">*</span></label>
                            <input type="text" name="lock_warranty_months" class="form-control">
                            <small class="error text-danger" id="add_lock_warranty_months_error"></small>
                        </div>
                        <!--<div class="form-group col-12 col-md-6">-->
                        <!--    <label>Lock Remaining Warranty (Months) <span class="text-danger">*</span></label>-->
                        <!--    <input type="text" name="lock_remaining_warranty_months" class="form-control">-->
                        <!--    <small class="error text-danger" id="add_lock_remaining_warranty_months_error"></small>-->
                        <!--</div>-->
                        
                        <div class="col-12 text-end mt-4">
                            <button type="button" id="addDigitalLockBtn" class="btn btn-primary">Save</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editDigitalLock" tabindex="-1" aria-labelledby="digiLoc_det" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header p-3">
                <h5 class="modal-title" id="digiLoc_det">Edit Digital Lock Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="uil uil-times"></i>
                </button>
            </div>

            <div class="modal-body p-3 pt-0">
                <form action="{{ route('fleetdashboard.updateDigiLockDetail', $vehicle->id) }}" method="POST" id="editDigitalLockForm"> 
                    @csrf
                    
                    <input type="hidden" name="id" id="edit_digiLockid_input">
                    
                    <div class="row">
                        <div class="form-group col-12 col-md-6">
                            <label>Digital Lock Provider <span class="text-danger">*</span></label>
                            <select name="digitallock_provider_id" id="edit_digitallock_provider_id" class="form-select select2">
                                <option value="">Choose</option>
                                @foreach($digitallockproviders as $provider)
                                <option value="{{ $provider->id }}">{{ $provider->name }}</option>
                                @endforeach
                            </select>
                            <small class="error text-danger" id="edit_digitallock_provider_id_error"></small>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>Lock Id <span class="text-danger">*</span></label>
                            <input type="text" name="lock_id" id="edit_lock_id" class="form-control">
                            <small class="error text-danger" id="edit_lock_id_error"></small>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>Lock Issue Date <span class="text-danger">*</span></label>
                            <input type="date" name="lock_issue_date" id="edit_lock_issue_date" class="form-control general_date">
                            <small class="error text-danger" id="edit_lock_issue_date_error"></small>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label> Lock Warranty Period (Months) <span class="text-danger">*</span></label>
                            <input type="text" name="lock_warranty_months" id="edit_lock_warranty_months" class="form-control">
                            <small class="error text-danger" id="edit_lock_warranty_months_error"></small>
                        </div>
                        
                        <div class="col-12 text-end mt-4">
                            <button type="button" id="editDigitalLockBtn" class="btn btn-primary">Save</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="add_finance" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add New Finance <span class="showfinancetype"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="uil uil-times"></i>
                </button>
            </div>

            <div class="modal-body">
                <form action="{{route('vehicleemi.save', $vehicle->id)}}" method="POST" id="addVehicleEmiForm">
                    @csrf
                    
                    <div class="row">
                        
                        <input type="hidden" name="finance_type_input" id="finance_type_input" class="form-control bg-light" value="" readonly />
                        
                        <div class="col-12 col-md-6 form-group">
                            <label>Financer <span class="text-danger">*</span></label>
                            <select name="finance_provider_id" id="add_finance_provider_id" class="form-select select2">
                                <option value="">Choose</option>
                                @foreach($financeproviders as $provider)
                                <option value="{{ $provider->id }}">{{ $provider->name }}</option>
                                @endforeach
                            </select>
                            <small class="error text-danger" id="add_finance_provider_id_error"></small>
                        </div>

                        <div class="col-12 col-md-6 form-group">
                            <label>Loan Account Number <span class="text-danger">*</span></label>
                            <input type="text" name="loan_account_number" id="add_loan_account_number" class="form-control" value="" />
                            <small class="error text-danger" id="add_loan_account_number_error"></small>
                        </div>

                        <div class="col-12 col-md-6 form-group">
                            <label>Total Financer Amount <span class="text-danger">*</span></label>
                            <input type="text" name="total_financer_amount" id="total_financer_amount" class="form-control emi-principal" value="" />
                            <small class="error text-danger" id="add_total_financer_amount_error"></small>
                        </div>

                        <div class="col-12 col-md-4 form-group">
                            <label>Total Amount With Interest <span class="text-danger">*</span></label>
                            <input type="text" name="total_amount_with_interest" id="total_amount_with_interest" class="form-control emi-total-amount" value="" />
                            <small class="error text-danger" id="add_total_amount_with_interest_error"></small>
                        </div>
                        
                        <div class="col-12 col-md-4 form-group">
                            <label>EMI Amount <span class="text-danger">*</span></label>
                            <input type="text" name="emi_amount" id="emi_amount" class="form-control emi-amount" value="" readonly />
                            <small class="error text-danger" id="add_emi_amount_error"></small>
                        </div>

                        <div class="col-12 col-md-4 form-group">
                            <label>Interest Amount <span class="text-danger">*</span></label>
                            <input type="text" name="interest_amount" id="interest_amount" class="form-control emi-interest" value="" readonly />
                            <small class="error text-danger" id="add_interest_amount_error"></small>
                        </div>

                        <div class="col-12 col-md-4 form-group">
                            <label>Total Months <span class="text-danger">*</span></label>
                            <input type="text" name="emi_total_months" id="emi_total_months" class="form-control emi-months" value="" />
                            <small class="error text-danger" id="add_emi_total_months_error"></small>
                        </div>

                        <div class="col-12 col-md-4 form-group">
                            <label>Paid Up To Months</label>
                            <input type="text" name="emi_paid_upto_months" id="emi_paid_upto_months" class="form-control emi-paid-months" value="" />
                            <small class="error text-danger" id="add_emi_paid_upto_months_error"></small>
                        </div>

                        <div class="col-12 col-md-4 form-group">
                            <label>Left Months <span class="text-danger">*</span></label>
                            <input type="text" name="emi_left_months" id="emi_left_months" class="form-control emi-left-months" value="" readonly />
                            <small class="error text-danger" id="add_emi_left_months_error"></small>
                        </div>

                        <div class="col-12 col-md-4 form-group">
                            <label>EMI Start Date <span class="text-danger">*</span></label>
                            <input type="date" name="emi_start_date" id="emi_start_date" class="form-control emi-start-date" value="" />
                            <small class="error text-danger" id="add_emi_start_date_error"></small>
                        </div>

                        <div class="col-12 col-md-4 form-group">
                            <label>EMI End Date <span class="text-danger">*</span></label>
                            <input type="date" name="emi_end_date" id="emi_end_date" class="form-control emi-end-date" value="" />
                            <small class="error text-danger" id="add_emi_end_date_error"></small>
                        </div>

                        <div class="col-12 col-md-4 form-group">
                            <label>EMI Date Every Month <span class="text-danger">*</span></label>
                            <select name="emi_date_of_every_month" id="emi_date_of_every_month" class="form-select">
                                <option value="">Choose</option>
                                @for($i = 1; $i <= 28; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                            <small class="error text-danger" id="add_emi_date_of_every_month_error"></small>
                        </div>

                        <div class="col-12 col-md-12 form-group">
                            <div class="d-flex">
                                <label class="me-1">Set Reminder </label>
                                <input name="set_emi_reminder" class="form-check-input clickto-adclass" type="checkbox" id="setReminder" />
                                <small class="error text-danger" id="add_set_emi_reminder_error"></small>
                            </div>

                            <div class="days-beforeexpiry" style="display: none">
                                <div class="row form-group">
                                    <div class="col-12 col-md-3">
                                        <label>Remind Before Days <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <select name="emi_reminder_before_days" id="emi_reminder_before_days" class="form-select emi-date-month">
                                            <option value="">Choose..</option>
                                            <option value="7">7 Days</option>
                                            <option value="10">10 Days</option>
                                            <option value="20">20 Days</option>
                                        </select>
                                        <small class="error text-danger" id="add_emi_reminder_before_days_error"></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-12 form-group">
                            <label>Notes</label>
                            <textarea name="emi_notes" id="emi_notes" class="form-control" rows="4"></textarea>
                            <small class="error text-danger" id="add_emi_notes_error"></small>
                        </div>
                    </div>

                </form>
            </div>

            <div class="modal-footer">
                <button type="button" id="addVehicleEmiBtn" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="edit_finance" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Finance <span class="showfinancetype"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="uil uil-times"></i>
                </button>
            </div>

            <div class="modal-body">
                <form action="{{ route('vehicleemi.update', $vehicle->id) }}" method="POST" id="editVehicleEmiForm"> 
                    @csrf
                    
                    <input type="hidden" name="id" id="edit_emi_id_input">
                    
                    <div class="row">
                        
                        <input type="hidden" name="finance_type_input" id="edit_finance_type_input" class="form-control bg-light" value="" readonly />
                        
                        <div class="col-12 col-md-6 form-group">
                            <label>Financer <span class="text-danger">*</span></label>
                            <select name="finance_provider_id" id="edit_finance_provider_id" class="form-select select2">
                                <option value="">Choose</option>
                                @foreach($financeproviders as $provider)
                                <option value="{{ $provider->id }}">{{ $provider->name }}</option>
                                @endforeach
                            </select>
                            <small class="error text-danger" id="edit_finance_provider_id_error"></small>
                        </div>

                        <div class="col-12 col-md-6 form-group">
                            <label>Loan Account Number <span class="text-danger">*</span></label>
                            <input type="text" name="loan_account_number" id="edit_loan_account_number" class="form-control" value="" />
                            <small class="error text-danger" id="edit_loan_account_number_error"></small>
                        </div>

                        <div class="col-12 col-md-6 form-group">
                            <label>Total Financer Amount <span class="text-danger">*</span></label>
                            <input type="text" name="total_financer_amount" id="edit_total_financer_amount" class="form-control emi-principal" value="" />
                            <small class="error text-danger" id="edit_total_financer_amount_error"></small>
                        </div>

                        <div class="col-12 col-md-4 form-group">
                            <label>Total Amount With Interest <span class="text-danger">*</span></label>
                            <input type="text" name="total_amount_with_interest" id="edit_total_amount_with_interest" class="form-control emi-total-amount" value="" />
                            <small class="error text-danger" id="edit_total_amount_with_interest_error"></small>
                        </div>
                        
                        <div class="col-12 col-md-4 form-group">
                            <label>EMI Amount <span class="text-danger">*</span></label>
                            <input type="text" name="emi_amount" id="edit_emi_amount" class="form-control emi-amount" value="" readonly />
                            <small class="error text-danger" id="edit_emi_amount_error"></small>
                        </div>

                        <div class="col-12 col-md-4 form-group">
                            <label>Interest Amount <span class="text-danger">*</span></label>
                            <input type="text" name="interest_amount" id="edit_interest_amount" class="form-control emi-interest" value="" readonly />
                            <small class="error text-danger" id="edit_interest_amount_error"></small>
                        </div>

                        <div class="col-12 col-md-4 form-group">
                            <label>Total Months <span class="text-danger">*</span></label>
                            <input type="text" name="emi_total_months" id="edit_emi_total_months" class="form-control emi-months" value="" />
                            <small class="error text-danger" id="edit_emi_total_months_error"></small>
                        </div>

                        <div class="col-12 col-md-4 form-group">
                            <label>Paid Up To Months</label>
                            <input type="text" name="emi_paid_upto_months" id="edit_emi_paid_upto_months" class="form-control emi-paid-months" value="" />
                            <small class="error text-danger" id="edit_emi_paid_upto_months_error"></small>
                        </div>

                        <div class="col-12 col-md-4 form-group">
                            <label>Left Months <span class="text-danger">*</span></label>
                            <input type="text" name="emi_left_months" id="edit_emi_left_months" class="form-control emi-left-months" value="" readonly />
                            <small class="error text-danger" id="edit_emi_left_months_error"></small>
                        </div>

                        <div class="col-12 col-md-4 form-group">
                            <label>EMI Start Date <span class="text-danger">*</span></label>
                            <input type="date" name="emi_start_date" id="edit_emi_start_date" class="form-control emi-start-date" value="" />
                            <small class="error text-danger" id="edit_emi_start_date_error"></small>
                        </div>

                        <div class="col-12 col-md-4 form-group">
                            <label>EMI End Date <span class="text-danger">*</span></label>
                            <input type="date" name="emi_end_date" id="edit_emi_end_date" class="form-control emi-end-date" value="" />
                            <small class="error text-danger" id="edit_emi_end_date_error"></small>
                        </div>

                        <div class="col-12 col-md-4 form-group">
                            <label>EMI Date Every Month <span class="text-danger">*</span></label>
                            <select name="emi_date_of_every_month" id="edit_emi_date_of_every_month" class="form-select emi-date-month">
                                <option value="">Choose</option>
                                @for($i = 1; $i <= 28; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                            <small class="error text-danger" id="edit_emi_date_of_every_month_error"></small>
                        </div>

                        <div class="col-12 col-md-12 form-group">
                            <div class="d-flex">
                                <label class="me-1">Set Reminder </label>
                                <input name="set_emi_reminder" id="edit_set_emi_reminder" class="form-check-input clickto-adclass" type="checkbox"  />
                                <small class="error text-danger" id="edit_set_emi_reminder_error"></small>
                            </div>

                            <div class="days-beforeexpiry" style="display: none">
                                <div class="row form-group">
                                    <div class="col-12 col-md-3">
                                        <label>Remind Before Days <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <select name="emi_reminder_before_days" id="edit_emi_reminder_before_days" class="form-select">
                                            <option value="">Choose..</option>
                                            <option value="7">7 Days</option>
                                            <option value="10">10 Days</option>
                                            <option value="20">20 Days</option>
                                        </select>
                                        <small class="error text-danger" id="add_emi_reminder_before_days_error"></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-12 form-group">
                            <label>Notes</label>
                            <textarea name="emi_notes" id="edit_emi_notes" class="form-control" rows="4"></textarea>
                            <small class="error text-danger" id="edit_emi_notes_error"></small>
                        </div>
                    </div>

                </form>
            </div>

            <div class="modal-footer">
                <button type="button" id="editVehicleEmiBtn" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="addNotes" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Notes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="uil uil-times"></i>
                </button>
            </div>

            <div class="modal-body">
                <form action="{{route('vehicleemi.finance.note.save', $vehicle->id)}}" method="POST" id="addRecordNotesForm">
                    @csrf
                    
                    <input type="hidden" name="loanaccount_cron_given_emi_id" id="loanaccount_cron_given_emi_id" value=""/>
                    
                    <div class="row">
                        <div class="col-12 form-group d-flex">
                            <label>Type</label>
                            <input type="radio" name="payment_record_type" value="Note" class="form-check-input paymentRecordType" />Note
                            <input type="radio" name="payment_record_type" value="Extra Charge" class="form-check-input paymentRecordType" />Extra Charge
                        </div>
                        <small class="error text-danger" id="add_payment_record_type_error"></small>
                    </div>
                    
                    <div class="row ExtraChargeDiv" style="display: none;">
                        <div class="col-12 form-group">
                            <label>Extra Charge</label>
                            <input type="text" name="extra_charge" class="form-control" />
                            <small class="error text-danger" id="add_extra_charge_error"></small>
                        </div>
                    </div>
                    
                    <div class="row NotesDiv" style="display: none;">
                        <div class="col-12 form-group">
                            <label>Notes</label>
                            <textarea name="record_notes" class="form-control" rows="4"></textarea>
                            <small class="error text-danger" id="add_record_notes_error"></small>
                        </div>
                    </div>

                </form>
            </div>

            <div class="modal-footer">
                <button type="button" id="addRecordNotesBtn" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="viewNotes" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Show Notes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="uil uil-times"></i>
                </button>
            </div>

            <div class="modal-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <!--<th>Type</th>-->
                            <th>Extra Charge</th>
                            <th>Note</th>
                        </tr>
                    </thead>
                    <tbody id="financeNotesTable"></tbody>
                </table>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade expenses_wrapperModal" id="add_v_documents" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Document</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="uil uil-times"></i>
                </button>
            </div>

            <div class="modal-body">
                <form action="{{ route('fleetdashboard.document.store', $vehicle->id) }}" id="documentForm">
                    @csrf
                    <div class="row">
                        <div class="col-12 col-md-6 form-group">
                            <label>Vehicle No<span class="text-danger ms-1">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control bg-light" readonly value="{{ $vehicle->vehicle_no }}" />
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
                            
                        </div>
                        

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
                <button type="button" class="btn btn-primary docSubmitForm">Save</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

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
                            <label>Vehicle No<span class="text-danger ms-1">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control bg-light" readonly value="{{ $vehicle->vehicle_no }}" />
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
                            
                        </div>
                        

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
                <button type="button" class="btn btn-primary editDocSubmitForm">Save</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="filePreviewModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Uploaded Documents</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="uil uil-times"></i>
                </button>
            </div>
            <div class="modal-body" >
                <div class="row mt-4  attachment-container" id="filePreviewContainer1">
                    <!-- Dynamic content -->
                </div>
            </div>
        </div>
    </div>
</div>

    
    
    
<!-- HTML Modal -->
<div class="modal fade" id="addTrip" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Trip</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="uil uil-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row form-group">
                        <div class="col-12 col-md-3">
                            <label>Trip ID</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input
                                type="text"
                                class="form-control bg-light"
                                readonly
                                placeholder="Will be auto generated"
                            />
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-12 col-md-3">
                            <label>Trip Type</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <select class="form-select">
                                <option>Choose..</option>
                                <option>Own Booking</option>
                                <option>External Booking</option>
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-12 col-md-3">
                            <label>Internal Trip ID</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text" class="form-control" />
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-12 col-md-3">
                            <label>Trip Date</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="date" class="form-control" />
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-12 col-md-3">
                            <label>Route</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <select class="form-select select2-modal">
                                <option>Choose..</option>
                                <option>Chennai - Kolkata</option>
                                <option>Chennai - Hydrabad</option>
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-12 col-md-3">
                            <label>Source</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text" class="form-control bg-light" value="Chennai" />
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-12">
                            <div class="add-stop">
                                <div class="row form-group">
                                    <div class="col-12 col-md-3">
                                        <label>Stop 1</label>
                                    </div>
                                    <div class="col-10 col-md-8">
                                        <input type="text" class="form-control" />
                                    </div>
                                    <div class="col-2 col-md-1">
                                        <i class="uil uil-trash-alt text-danger removeStop"></i>
                                    </div>
                                </div>
                            </div>
                            <a href="javascript:void(0)" class="btn btn-secondary add-stop-btn"
                                ><i class="uil uil-plus me-1"></i>Stop</a
                            >
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-12 col-md-3">
                            <label>Destination</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text" class="form-control bg-light" readonly value="Kolkata" />
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-12 col-md-3">
                            <label>Consigner</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <select class="form-select select2-modal">
                                <option>Choose..</option>
                                <option>Samsung India Hydrabad</option>
                                <option>Britania Kolkata</option>
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-12 col-md-3">
                            <label>Consignee</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <select class="form-select select2-modal">
                                <option>Choose..</option>
                                <option>Samsung India Hydrabad</option>
                                <option>Britania Kolkata</option>
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-12 col-md-3">
                            <label>Distance</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text" class="form-control bg-light" readonly value="10KM." />
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-12 col-md-3">
                            <label>Comment</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <textarea class="form-control" rows="4"></textarea>
                        </div>
                    </div>

                    <div class="text-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
    
<div class="modal fade" id="editVehicle" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Vehicle Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="uil uil-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-12 col-md-3 form-group">
                            <label>Brand</label>
                            <input type="text" class="form-control" value="Tata Motors" />
                        </div>
                        <div class="col-12 col-md-3 form-group">
                            <label>Purchase Date</label>
                            <input type="date" class="form-control" />
                        </div>
                        <div class="col-12 col-md-3 form-group">
                            <label>Owner Name</label>
                            <input type="text" class="form-control" value="SR Lofistics" />
                        </div>
                        <div class="col-12 col-md-3 form-group">
                            <label>Insurance Agent</label>
                            <input type="text" class="form-control" value="Ramesh Yadhav" />
                        </div>
                        <!------>
                        <div class="col-12 col-md-3 form-group">
                            <label>Permit No.</label>
                            <input type="text" class="form-control" value="HR0470196" />
                        </div>
                        <div class="col-12 col-md-3 form-group">
                            <label>No. of Tire</label>
                            <input type="text" class="form-control" value="16" />
                        </div>
                        <div class="col-12 col-md-3 form-group">
                            <label>Model</label>
                            <input type="text" class="form-control" value="TATA SIGNA 2821.T" />
                        </div>
                        <div class="col-12 col-md-3 form-group">
                            <label>Warranty Issue Date</label>
                            <input type="date" class="form-control" />
                        </div>
                        <!------>
                        <div class="col-12 col-md-3 form-group">
                            <label>Vehicle Status</label>
                            <input type="text" class="form-control" value="In-Trip" />
                        </div>
                        <div class="col-12 col-md-3 form-group">
                            <label>Insurance Policy</label>
                            <input type="text" class="form-control" value="Bajaj Allianz General" />
                        </div>
                        <div class="col-12 col-md-3 form-group">
                            <label>Permit Issue Date</label>
                            <input type="date" class="form-control" />
                        </div>
                        <div class="col-12 col-md-3 form-group">
                            <label>Number of Battery</label>
                            <input type="text" class="form-control" value="20" />
                        </div>
                        <!------>
                        <div class="col-12 col-md-3 form-group">
                            <label>Make</label>
                            <input type="text" class="form-control" value="Tata Motors" />
                        </div>
                        <div class="col-12 col-md-3 form-group">
                            <label>Warranty Expiry Date</label>
                            <input type="date" class="form-control" />
                        </div>
                        <div class="col-12 col-md-3 form-group">
                            <label>Registration Place</label>
                            <input type="text" class="form-control" value="RTO Mumbai" />
                        </div>
                        <div class="col-12 col-md-3 form-group">
                            <label>Insurance Policy No.</label>
                            <input type="text" class="form-control" value="OG-1803-1803" />
                        </div>
                        <!------>
                        <div class="col-12 col-md-3 form-group">
                            <label>Permit Expiry Date</label>
                            <input type="date" class="form-control" />
                        </div>
                        <div class="col-12 col-md-3 form-group">
                            <label>Fuel Tank Capacity (Litre)</label>
                            <input type="text" class="form-control" value="40" />
                        </div>
                        <div class="col-12 col-md-3 form-group">
                            <label>Engine No.</label>
                            <input type="text" class="form-control" value="JF08E8792828" />
                        </div>
                        <div class="col-12 col-md-3 form-group">
                            <label>Emission Norm</label>
                            <input type="text" class="form-control" value="Emission BS 4" />
                        </div>
                        <!------>
                        <div class="col-12 col-md-3 form-group">
                            <label>Registration Issue Date</label>
                            <input type="date" class="form-control" />
                        </div>
                        <div class="col-12 col-md-3 form-group">
                            <label>Insurance Issue Date</label>
                            <input type="date" class="form-control" />
                        </div>
                        <div class="col-12 col-md-3 form-group">
                            <label>Tax Expiry Date</label>
                            <input type="date" class="form-control" />
                        </div>
                        <div class="col-12 col-md-3 form-group">
                            <label>Urea Tank Capacity (Litre)</label>
                            <input type="text" class="form-control" value="20" />
                        </div>
                        <!------->
                        <div class="col-12 col-md-3 form-group">
                            <label>Chassis No.</label>
                            <input type="text" class="form-control" value="ME4JF082D78613982" />
                        </div>
                        <div class="col-12 col-md-3 form-group">
                            <label>Tare Weight (kg)</label>
                            <input type="text" class="form-control" value="70" />
                        </div>
                        <div class="col-12 col-md-3 form-group">
                            <label>Registration Expiry Date</label>
                            <input type="date" class="form-control" />
                        </div>
                        <div class="col-12 col-md-3 form-group">
                            <label>Insurance Expiry Date</label>
                            <input type="date" class="form-control" />
                        </div>
                        <!------->
                        <div class="col-12 col-md-3 form-group">
                            <label>PUCC No.</label>
                            <input type="text" class="form-control" value="HR0470196000" />
                        </div>
                        <div class="col-12 col-md-3 form-group">
                            <label>Body Dimensions (Centimeter)</label>
                            <input type="text" class="form-control" value="Height 1000 - Width 800 - Length 1200" />
                        </div>
                        <div class="col-12 col-md-3 form-group">
                            <label>Vehicle Type</label>
                            <select class="form-select">
                                <option>Choose</option>
                                <option>Mini Truck</option>
                                <option selected>Large Truck</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-3 form-group">
                            <label>Gross Weight (kg)</label>
                            <input type="text" class="form-control" value="400" />
                        </div>
                        <div class="col-12 col-md-3 form-group">
                            <label>Insurance Company</label>
                            <input type="text" class="form-control" value="BAJAJ ALLIANZ" />
                        </div>
                        <div class="col-12 col-md-3 form-group">
                            <label>Permit Type</label>
                            <input type="text" class="form-control" value="HGV" />
                        </div>
                        <div class="col-12 col-md-3 form-group">
                            <label>PUCC Issue Date</label>
                            <input type="date" class="form-control" />
                        </div>
                        <div class="col-12 col-md-3 form-group">
                            <label>PUCC Expiry Date</label>
                            <input type="date" class="form-control" />
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Update</button>
            </div>
        </div>
    </div>
</div>
    
<div class="modal fade expenses_wrapperModal" id="add04_expenses" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Vehicle Expences</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="uil uil-times"></i>
                </button>
            </div>

            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-12 col-md-6 form-group">
                            <label>Expences Head</label>
                            <select class="form-select select2">
                                <option>Search expences head</option>
                                <option>Advance Fixed</option>
                                <option>Fuel Fixed</option>
                                <!--<option>Backbone Frames</option>-->
                            </select>
                        </div>

                        <div class="col-12 col-md-6 form-group">
                            <label>Amount</label>
                            <input type="text" class="form-control" value="" />
                        </div>

                        <div class="col-12 col-md-6 form-group">
                            <label>Date</label>
                            <div class="input-group">
                                <input class="date form-control" type="text" name="datet01" />

                                <span class="input-group-text">
                                    <i class="uil uil-calendar-alt"></i>
                                </span>
                            </div>
                        </div>

                        <div class="col-12 col-md-6 form-group">
                            <label>Payment Mode</label>
                            <select class="form-select">
                                <option>Select Payment Mode</option>
                                <option>Online</option>
                                <option>Offline</option>
                            </select>
                        </div>

                        <div class="col-12 col-md-12 form-group">
                            <label>Vehicle</label>
                            <select class="form-select">
                                <option>Select Number</option>
                                <option selected>WB-12-AB-1234</option>
                                <option>WB-12-AB-1236</option>
                            </select>
                        </div>

                        <div class="col-12 col-md-12 form-group">
                            <label>Remarks</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>
    
<div class="modal fade expenses_wrapperModal" id="add05_maintenance" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Schedule Maintenance</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="uil uil-times"></i>
                </button>
            </div>

            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-12 col-md-6 form-group">
                            <label>Vehicle</label>
                            <input type="text" class="form-control bg-light" readonly value="MH-01-AB-1234" />
                        </div>
                        
                        <div class="col-12 col-md-6 form-group">
                            <label>Work Type</label>
                            <div class="form-check form-check-inline if-main">
                              <input class="form-check-input" type="radio" name="workType" id="maintenance_2" value="Maintenance">
                              <label class="form-check-label" for="maintenance_2">Maintenance</label>
                            </div>
                            <div class="form-check form-check-inline if-rep">
                              <input class="form-check-input" type="radio" name="workType" id="repair" value="Repair">
                              <label class="form-check-label" for="repair">Repair</label>
                            </div>
                        </div>
                    </div>
                        
                    <div class="maintanance-wrap">
                        <div class="row">
                            <div class="col-12 col-md-6 form-group">
                                <label>Maintenance Item</label>
                                <input type="text" class="form-control" />
                            </div>

                            <div class="col-12 col-md-6 form-group">
                                <label>Maintenance Date</label>
                                <input class="form-control" type="date" />
                            </div>

                            <div class="col-12 col-md-6 form-group">
                                <label>Odometer Reading</label>
                                <input type="text" class="form-control" value="" />
                            </div>

                            <div class="col-12 col-md-6 form-group">
                                <label>Next Reminder Date</label>
                                <input class="form-control" type="date" />
                            </div>
                            
                            <div class="col-12 col-md-6 form-group">
                                <label>Contact Name</label>
                                <input type="text" class="form-control" value="" />
                            </div>

                            <div class="col-12 col-md-6 form-group">
                                <label>Contact Number</label>
                                <input class="form-control" type="text" />
                            </div>
                            
                            <div class="col-12 col-md-6 form-group">
                                <label>Driver Name</label>
                                <input class="form-control" type="text" />
                            </div>
                            
                            <div class="col-12 col-md-6 form-group">
                                <label>Managed By</label>
                                <input class="form-control" type="text" />
                            </div>
                        </div>
                    </div>
                        
                    <div class="repair-wrap">
                        <div class="row">
                            <div class="col-12 col-md-6 form-group">
                                <label>Repair Type</label>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="repairType" id="major" value="Major">
                                  <label class="form-check-label" for="major">Major</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="repairType" id="minor" value="Minor">
                                  <label class="form-check-label" for="minor">Minor</label>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 form-group">
                                <label>Repair Start Date</label>
                                <input class="form-control" type="date" />
                            </div>
                            
                            <div class="col-12 col-md-6 form-group">
                                <label>Expected Closure Date</label>
                                <input class="form-control" type="date" />
                            </div>
                            
                            <div class="col-12 col-md-6 form-group">
                                <label>Workshop Name</label>
                                <input class="form-control" type="text" />
                            </div>
                            
                            <div class="col-12 col-md-6 form-group">
                                <label>Workshop Location</label>
                                <input class="form-control" type="text" />
                            </div>

                            <div class="col-12 col-md-6 form-group">
                                <label>Odometer Reading (KM)</label>
                                <input type="text" class="form-control" />
                            </div>
                            
                            <div class="col-12 col-md-6 form-group">
                                <label>Contact Name</label>
                                <input type="text" class="form-control" value="" />
                            </div>

                            <div class="col-12 col-md-6 form-group">
                                <label>Contact Number</label>
                                <input class="form-control" type="text" />
                            </div>
                            
                            <div class="col-12 col-md-6 form-group">
                                <label>Driver Name</label>
                                <input class="form-control" type="text" />
                            </div>
                            
                            <div class="col-12 col-md-6 form-group">
                                <label>Managed By</label>
                                <input class="form-control" type="text" />
                            </div>
                            
                            <div class="col-12 form-group">
                                <label>Description</label>
                                <textarea type="text" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>
    
<div class="modal fade remarks_wrapperModal" id="fuelbook1remarks" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Remarks</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="uil uil-times"></i>
                </button>
            </div>

            <div class="modal-body">
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin vehicula, sapien a cursus
                    fermentum, ante enim blandit quam, vel lobortis augue sem sit amet dui. Nulla facilisi.
                </p>
            </div>
        </div>
    </div>
</div>

<div class="modal fade remarks_wrapperModal" id="modalNotes" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Notes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="uil uil-times"></i>
                </button>
            </div>

            <div class="modal-body">
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin vehicula, sapien a cursus
                    fermentum, ante enim blandit quam, vel lobortis augue sem sit amet dui. Nulla facilisi.
                </p>
            </div>
        </div>
    </div>
</div>
    
<div class="modal fade vahan_01modal" id="vahan_01modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Vahan Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="uil uil-times"></i>
                </button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-md-12">
                        <div class="gst-wrapper">
                            <label>Vahan Number <span class="text-danger">*</span></label>
                            <div class="row align-items-center">
                                <div class="col-11 pe-0">                       
                                    <div class="gst-inputbd" id="gstForm">
                                        <input type="text" placeholder="UP2BN1470" class="gstinput form-control" id="gstNumber">
                                        <button class="submit-btn" type="submit">
                                            <i class="uil uil-search"></i>Fetch Info
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="col-1">
                                    <div class="sec-tooltip">
                                        <i class="uil uil-info-circle"></i>
                                        <p>We Are Fetching Vahan Details From the Entered Value</p>
                                        <!--<p>We will be fetching details from Vahan Number.</p>-->
                                    </div>
                                </div>
                            </div>
                            <span class="gst-format">Format: UP2BN1470</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="viewFinance" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">View Finance</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="uil uil-times"></i>
                </button>
            </div>

            <div class="modal-body">
                <form>
                    <div class="row">

                        <div class="col-12 col-md-4 form-group">
                            <label>Finance Part </label>
                            <p style="font-size: 14px;">Body</p>
                        </div>

                        <div class="col-12 col-md-4 form-group">
                            <label>Financer</label>
                            <p style="font-size: 14px;">Bajaj Finance</p>
                        </div>

                        <div class="col-12 col-md-4 form-group">
                            <label>Loan Account Number</label>
                            <p style="font-size: 14px;">45690ACQ435</p>
                        </div>

                        <div class="col-12 col-md-4 form-group">
                            <label>Total Financer Amount</label>
                            <p style="font-size: 14px;">5000</p>
                        </div>

                        <div class="col-12 col-md-4 form-group">
                            <label>Total Amount With Interest</label>
                            <p style="font-size: 14px;">25000</p>
                        </div>
                        
                        <div class="col-12 col-md-4 form-group">
                            <label>EMI Amount</label>
                            <p style="font-size: 14px;">1500</p>
                        </div>

                        <div class="col-12 col-md-4 form-group">
                            <label>Interest Amount</label>
                            <p style="font-size: 14px;">5000</p>
                        </div>

                        <div class="col-12 col-md-4 form-group">
                            <label>Total Months</label>
                            <p style="font-size: 14px;">12</p>
                        </div>

                        <div class="col-12 col-md-4 form-group">
                            <label>Paid Up To Months</label>
                            <p style="font-size: 14px;">5</p>
                        </div>

                        <div class="col-12 col-md-4 form-group">
                            <label>Left Months</label>
                            <p style="font-size: 14px;">7</p>
                        </div>

                        <div class="col-12 col-md-4 form-group">
                            <label>EMI Start Date</label>
                            <p style="font-size: 14px;">04/03/2026</p>
                        </div>

                        <div class="col-12 col-md-4 form-group">
                            <label>EMI End Date</label>
                            <p style="font-size: 14px;">04/03/2027</p>
                        </div>

                        <div class="col-12 col-md-4 form-group">
                            <label>EMI Date Every Month</label>
                            <p style="font-size: 14px;">5th</p>
                        </div>

                        <div class="col-12 col-md-4 form-group">
                            <div>
                                <label class="me-1">Set Reminder </label>
                                <p style="font-size: 14px;">Yes</p>
                            </div>
                        </div>
                        
                        <div class="col-12 col-md-4 form-group">
                            <div>
                                <label>Remind Before Days</label>
                                <p style="font-size: 14px;">7 Days</p>
                            </div>
                        </div>
                        
                        <div class="col-12 form-group">
                            <label>Notes</label>
                            <p style="font-size: 14px;">lorem ipsum doller sit amet</p>
                        </div>
                    </div>

                    <!--///////////////////////////////////////////////////////////////////////////////////////////////-->
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>






{{-- ══════════════════════════════════════════════════════════════════════
     NEW CLAIM MODAL  (shared with fleet.insurance.index)
     Raise Claim button in Insurance tab triggers this
═══════════════════════════════════════════════════════════════════════ --}}
<div class="modal fade" id="newClaimModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title"><i class="uil uil-file-plus-alt me-2"></i>File New Insurance Claim</h6>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-12">
                        <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#032671;border-bottom:1px solid #e4e7ef;padding-bottom:5px;margin-bottom:2px;">Incident</div>
                    </div>
                    <div class="col-12">
                        <label class="form-label" style="font-size:12px;font-weight:600;">Vehicle</label>
                        <input type="text" class="form-control form-control-sm bg-light" readonly
                               value="{{ $vehicle->vehicle_no }}">
                        <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" style="font-size:12px;font-weight:600;">Incident Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" style="font-size:12px;font-weight:600;">Incident Location</label>
                        <input type="text" class="form-control form-control-sm" placeholder="City / Highway / NH number…">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" style="font-size:12px;font-weight:600;">Damage Type <span class="text-danger">*</span></label>
                        <select class="form-select form-select-sm">
                            <option value="">— Select —</option>
                            <option>Own Damage — Road Accident</option>
                            <option>Own Damage — Fire</option>
                            <option>Own Damage — Flood / Natural Calamity</option>
                            <option>Theft / Partial Theft</option>
                            <option>Third Party Property Damage</option>
                            <option>Third Party Injury / Death</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" style="font-size:12px;font-weight:600;">FIR / Police Report #</label>
                        <input type="text" class="form-control form-control-sm" placeholder="If applicable">
                    </div>
                    <div class="col-12">
                        <label class="form-label" style="font-size:12px;font-weight:600;">Incident Description <span class="text-danger">*</span></label>
                        <textarea class="form-control form-control-sm" rows="2" style="resize:none;" placeholder="Brief description of what happened, damage observed…"></textarea>
                    </div>
                    <div class="col-12 mt-1">
                        <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#032671;border-bottom:1px solid #e4e7ef;padding-bottom:5px;margin-bottom:2px;">Repair & Settlement</div>
                    </div>
                    <div class="col-12">
                        <label class="form-label" style="font-size:12px;font-weight:600;">Settlement Mode <span class="text-danger">*</span></label>
                        <div class="d-flex gap-3 mt-1">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="vdSettlementMode" id="vdModeReimburse" value="reimbursement" checked onchange="vdToggleSettlementMode(this.value)">
                                <label class="form-check-label" for="vdModeReimburse" style="font-size:13px;font-weight:600;">
                                    Reimbursement
                                    <span style="font-size:11px;color:#888;font-weight:400;display:block;">We pay repair → insurer pays us back</span>
                                </label>
                            </div>
                            <div class="form-check ms-4">
                                <input class="form-check-input" type="radio" name="vdSettlementMode" id="vdModeCashless" value="cashless" onchange="vdToggleSettlementMode(this.value)">
                                <label class="form-check-label" for="vdModeCashless" style="font-size:13px;font-weight:600;">
                                    Cashless
                                    <span style="font-size:11px;color:#888;font-weight:400;display:block;">Workshop files with insurer → we pay excess only</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    @include('includes.workshop-claim-section', ['prefix' => 'vd', 'workshops' => $workshops ?? collect()])
                    <div id="vdReimburseCostField" class="col-md-6">
                        <label class="form-label" style="font-size:12px;font-weight:600;">Estimated Repair Cost (₹) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control form-control-sm" placeholder="Workshop estimate">
                    </div>
                    <div id="vdCashlessExcessField" class="col-md-6" style="display:none;">
                        <label class="form-label" style="font-size:12px;font-weight:600;">Excess Payable (₹)</label>
                        <input type="number" class="form-control form-control-sm" placeholder="Amount we pay">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" style="font-size:12px;font-weight:600;">Linked Job Card</label>
                        <input type="text" class="form-control form-control-sm" placeholder="JC number if repair started">
                    </div>
                    <div class="col-12 mt-1">
                        <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#032671;border-bottom:1px solid #e4e7ef;padding-bottom:5px;margin-bottom:2px;">Insurer & Policy</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" style="font-size:12px;font-weight:600;">Insurer <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm" placeholder="e.g. ICICI Lombard, New India…">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" style="font-size:12px;font-weight:600;">Policy Number</label>
                        <input type="text" class="form-control form-control-sm" placeholder="Auto-filled from vehicle (when backend ready)">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" style="font-size:12px;font-weight:600;">Insurer Claim Ref #</label>
                        <input type="text" class="form-control form-control-sm" placeholder="Ref given by insurer at filing">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" style="font-size:12px;font-weight:600;">Claim Filed Date</label>
                        <input type="date" class="form-control form-control-sm">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary btn-sm"
                    onclick="Swal.fire({icon:'success',title:'Claim Recorded',text:'Claim has been filed and added to the tracker.',timer:2000,showConfirmButton:false});$('#newClaimModal').modal('hide');">
                    <i class="uil uil-save me-1"></i>Save Claim
                </button>
            </div>
        </div>
    </div>
</div>

</div>{{-- end srlog-bdwrapper --}}

{{-- ═══════════════════════════════════════════════════════
     TYRE IMAGE GALLERY MODAL — vtd-gallery-modal
     Populated via vehicle-details-tyre.js
═══════════════════════════════════════════════════════ --}}
<div class="modal fade" id="vtdGalleryModal" tabindex="-1" aria-labelledby="vtdGalleryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered vtd-gallery-dialog">
        <div class="modal-content vtd-gallery-content">
            <div class="modal-header vtd-gallery-header">
                <div class="d-flex align-items-center gap-2">
                    <i class="uil uil-image vtd-gallery-icon"></i>
                    <div>
                        <div class="vtd-gallery-title" id="vtdGalleryModalLabel">Tyre Photos</div>
                        <div class="vtd-gallery-subtitle" id="vtdGallerySubtitle"></div>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body vtd-gallery-body" id="vtdGalleryBody">
                {{-- Populated by JS --}}
            </div>
            <div class="modal-footer vtd-gallery-footer">
                <button type="button" class="btn btn-sm vtd-gallery-nav" id="vtdGalleryPrev" disabled>
                    <i class="uil uil-angle-left"></i> Prev
                </button>
                <span class="vtd-gallery-counter" id="vtdGalleryCounter">1 / 1</span>
                <button type="button" class="btn btn-sm vtd-gallery-nav" id="vtdGalleryNext" disabled>
                    Next <i class="uil uil-angle-right"></i>
                </button>
                <button type="button" class="btn btn-sm btn-outline-secondary ms-auto" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════
     TYRE DETAIL MODAL — vtd-detail-modal
     Populated via vehicle-details-tyre.js
═══════════════════════════════════════════════════════ --}}
<div class="modal fade" id="vtdTyreDetailModal" tabindex="-1" aria-labelledby="vtdTyreDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:440px;">
        <div class="modal-content vtd-modal-content">
            <div class="modal-header vtd-modal-header" id="vtdModalHeader">
                <div class="d-flex align-items-center gap-2">
                    <span class="vtd-modal-pos-dot" id="vtdModalPosDot"></span>
                    <div>
                        <div class="vtd-modal-title" id="vtdTyreDetailModalLabel">Tyre Details</div>
                        <div class="vtd-modal-subtitle" id="vtdModalSubtitle"></div>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body vtd-modal-body" id="vtdModalBody">
                {{-- Populated by JS --}}
            </div>
            <div class="modal-footer vtd-modal-footer">
                <a href="#" class="btn btn-sm vtd-modal-manage-btn" id="vtdModalManageBtn" target="_blank">
                    <i class="uil uil-cog me-1"></i>Manage Tyres
                </a>
                <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

{{-- SVG Hover Tooltip --}}
<div id="vtdSvgTooltip" class="vtd-svg-tooltip" style="display:none;"></div>

@endsection

@section('js')

<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>
<script type="text/javascript" src="{{ asset('customjs/fleet/vehicle-details.js') }}"></script>
<script type="text/javascript" src="{{ asset('customjs/fleet/html-related-scripts.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/Fleet/vehicle-details-tyre.js?v=2.1') }}"></script>

<script>

    var DRIVER_DATA = "{{ route('fleetdashboard.getDriverData', ':id') }}";

    var EDIT_GPS = "{{ route('fleetdashboard.editGpsDetail', ':id') }}";
    var EDIT_FASTTAG = "{{ route('fleetdashboard.editFasttagDetail', ':id') }}";

    var EDIT_TYRE = "{{ route('fleetdashboard.editTyreDetail', ':id') }}";
    var DELETE_TYRE = "{{ route('fleetdashboard.deleteTyre') }}";

    /* Tyre image gallery data — keyed by position code (e.g. 'C1', 'D1') */
    var VTD_TYRE_IMAGES = @json($tyreImagesMap ?? []);

    var EDIT_BATTERY = "{{ route('fleetdashboard.editBatteryDetail', ':id') }}";
    var DELETE_BATTERY = "{{ route('fleetdashboard.deleteBattery') }}";

    var EDIT_DIGITAL_LOCK = "{{ route('fleetdashboard.editDigiLockDetail', ':id') }}";
    var DELETE_DIGITAL_LOCK = "{{ route('fleetdashboard.deleteDigiLock') }}";


    var EDIT_FINANCE = "{{ route('vehicleemi.edit', ':id') }}";
    var VIEW_FINANCE_NOTES = "{{ route('vehicleemi.finance.note.show', ':id') }}";

    /* —— Pre-fill vehicle in New Claim modal —— */
    function prefillClaimVehicle(vehicleNo) {
        if (!vehicleNo) return;
        $('#claimVehicleSelect option').each(function () {
            if ($(this).val() && $(this).text().indexOf(vehicleNo) !== -1) {
                $('#claimVehicleSelect').val($(this).val());
                return false;
            }
        });
    }

    /* —— New Claim modal: settlement mode toggle —— */
    function vdToggleSettlementMode(mode) {
        if (mode === 'cashless') {
            $('#vdCashlessExcessField').show();
            $('#vdReimburseCostField').hide();
            if ($('input[name="vdWorkshopType"]:checked').val() === 'external') {
                $('#vdCashlessScClaimRef').show();
            }
        } else {
            $('#vdReimburseCostField').show();
            $('#vdCashlessExcessField').hide();
            $('#vdCashlessScClaimRef').hide();
        }
    }

    /* —— Workshop type filter (called by radio onchange) —— */
    function vdFilterWorkshopvd(type) {
        $('#vdWorkshopSelect').val('').trigger('change');
        $('#vdScContactWrap, #vdScPhoneWrap, #vdScCityWrap').hide();
        // Disable options not matching the selected type
        $('#vdWorkshopSelect option[data-ownership]').each(function () {
            $(this).prop('disabled', $(this).data('ownership') !== type);
        });
        // Show cashless claim-ref only for External + Cashless
        if (type === 'External' && $('input[name="vdSettlementMode"]:checked').val() === 'cashless') {
            $('#vdCashlessScClaimRef').show();
        } else {
            $('#vdCashlessScClaimRef').hide();
        }
    }

    /* —— Reset modal on open —— */
    $('#newClaimModal').on('show.bs.modal', function () {
        $('input[name="vdSettlementMode"][value="reimbursement"]').prop('checked', true);
        $('input[name="vdWorkshopType"][value="Own"]').prop('checked', true);
        $('#vdCashlessExcessField, #vdCashlessScClaimRef').hide();
        $('#vdReimburseCostField').show();
        vdFilterWorkshopvd('Own');
    });

    /* —— Workshop auto-fill contact info —— */
    $('#vdWorkshopSelect').on('change', function () {
        var sel = $(this).find(':selected');
        if ($(this).val()) {
            $('#vdScContactPerson').val(sel.data('contact') || '');
            $('#vdScPhone').val(sel.data('phone') || '');
            $('#vdScCity').val(sel.data('city') || '');
            $('#vdScContactWrap, #vdScPhoneWrap, #vdScCityWrap').show();
        } else {
            $('#vdScContactWrap, #vdScPhoneWrap, #vdScCityWrap').hide();
        }
    });

</script>

@endsection
