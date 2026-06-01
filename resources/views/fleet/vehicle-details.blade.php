@extends('layouts.app')
{{-- v4.6 battery recompile --}}
@section('css')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css" />
<link rel="stylesheet" href="{{ asset('css/fleet/vehicle-details.css?v=1.1') }}">
<link rel="stylesheet" href="{{ asset('css/vehicle-details.css?v=1.0') }}">
<link rel="stylesheet" href="{{ asset('css/fleet/vehicle-details-v2.css?v=7.1') }}">

@endsection

@section('content')

    
<div class="layout-wrapper">
<!-- DEBUG-RECOMPILE-CHECK-V46 -->
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
                </div>
                <div class="v2-id-sub">
                    {{ $vehicle->vehicletype->name ?? 'Vehicle' }}
                    @if($vehicle->group) &middot; {{ $vehicle->group->name }} @endif
                </div>
            </div>

            <div class="v2-id-sep"></div>

            {{-- Driver --}}
            <div>
                <div class="v2-id-field-label">Driver</div>
                <div class="v2-id-field-value">
                    {{ $vehicle->driverAllocation->contact->contact_name ?? 'Unassigned' }}
                    <a class="v2-id-edit-link edit-driver-btn" href="javascript:void(0)"
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
                <button class="btn btn-sm" data-action="refresh-vahan" style="background:#f0f4ff;color:#032671;border:1px solid #c5d0ee;font-size:11px;font-weight:600;">
                    <i class="uil uil-refresh me-1"></i>Refresh Vahan
                </button>
                <a href="{{ route('vehiclemanagement.edit', $vehicle->id) }}"
                   class="btn btn-sm"
                   style="background:#f0f4ff;color:#032671;border:1px solid #c5d0ee;font-size:11px;font-weight:600;">
                    <i class="uil uil-cog me-1"></i>Manage
                </a>
                {{-- <a href="{{ route('fleetdashboard.getVehicleDetailsV2', $vehicle->id) }}"
                   class="btn btn-sm"
                   style="background:#032671;color:#fff;border:1px solid #032671;font-size:11px;font-weight:600;">
                    View V2 →
                </a> --}}
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
                <a href="javascript:void(0)" class="v2-intel-action" data-action="track-live">
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
                <a href="javascript:void(0)" class="v2-intel-action" data-action="view-emi-book">
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
                                    <a href="{{ route('tyremanage.vehicle.tyre.tagging.v2', $vehicle->id) }}" class="badge badge-primary ms-2">
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
                                    <a href="{{ route('tyremanage.vehicle.tyre.tagging.v2', $vehicle->id) }}" class="btn btn-outline-primary btn-sm mt-2">
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
                                            data-manage-url="{{ route('tyremanage.vehicle.tyre.tagging.v2', $vehicle->id) }}"
                                            data-tyre-id="{{ ($m && $m->tyre) ? $m->tyre->id : '' }}"
                                            data-logs-url="{{ ($m && $m->tyre) ? route('fleetdashboard.getPositionMappingLogs', [$vehicle->id, $m->tyreposition_id]) : '' }}">
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
                                                <div class="vtd-field"><span class="vtd-fl">Remaining Life</span>
                                                    <span class="vtd-fv vtd-life-wrap">
                                                        @if($remLifePct !== null)
                                                        <span class="vtd-life-track"><span class="vtd-life-fill" style="width:{{ $remLifePct }}%;background:{{ $kmBalColor }};"></span></span>
                                                        <span style="color:{{ $kmBalColor }};font-weight:700;">{{ $remLifePct }}%</span>
                                                        @else<span class="vtd-na">—</span>@endif
                                                    </span>
                                                </div>
                                                <div class="vtd-field"><span class="vtd-fl">Actual Run KM</span><span class="vtd-fv">{{ $kmRun > 0 ? number_format($kmRun).' KM' : '—' }}</span></div>
                                                <div class="vtd-field"><span class="vtd-fl">Remaining Run</span><span class="vtd-fv" style="color:{{ $kmBalColor }};font-weight:600;">{{ $kmBal!==null ? ($kmBal<=0?'Overdue':number_format($kmBal).' KM') : '—' }}</span></div>
                                                <div class="vtd-field"><span class="vtd-fl">Remaining Warranty</span><span class="vtd-fv">@if($remWarranty!==null)<span style="color:{{ $remWarranty==0?'#ea0027':($remWarranty<=3?'#d97706':'#10863f') }};font-weight:600;">{{ $remWarranty==0?'Expired':$remWarranty.' mo.' }}</span>@else<span class="vtd-na">—</span>@endif</span></div>
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
                                            data-manage-url="{{ route('tyremanage.vehicle.tyre.tagging.v2', $vehicle->id) }}"
                                            data-tyre-id="{{ ($m && $m->tyre) ? $m->tyre->id : '' }}"
                                            data-logs-url="{{ ($m && $m->tyre) ? route('fleetdashboard.getPositionMappingLogs', [$vehicle->id, $m->tyreposition_id]) : '' }}">
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
                                                <div class="vtd-field"><span class="vtd-fl">Remaining Life</span>
                                                    <span class="vtd-fv vtd-life-wrap">
                                                        @if($remLifePct !== null)
                                                        <span class="vtd-life-track"><span class="vtd-life-fill" style="width:{{ $remLifePct }}%;background:{{ $kmBalColor }};"></span></span>
                                                        <span style="color:{{ $kmBalColor }};font-weight:700;">{{ $remLifePct }}%</span>
                                                        @else<span class="vtd-na">—</span>@endif
                                                    </span>
                                                </div>
                                                <div class="vtd-field"><span class="vtd-fl">Actual Run KM</span><span class="vtd-fv">{{ $kmRun > 0 ? number_format($kmRun).' KM' : '—' }}</span></div>
                                                <div class="vtd-field"><span class="vtd-fl">Remaining Run</span><span class="vtd-fv" style="color:{{ $kmBalColor }};font-weight:600;">{{ $kmBal!==null ? ($kmBal<=0?'Overdue':number_format($kmBal).' KM') : '—' }}</span></div>
                                                <div class="vtd-field"><span class="vtd-fl">Remaining Warranty</span><span class="vtd-fv">@if($remWarranty!==null)<span style="color:{{ $remWarranty==0?'#ea0027':($remWarranty<=3?'#d97706':'#10863f') }};font-weight:600;">{{ $remWarranty==0?'Expired':$remWarranty.' mo.' }}</span>@else<span class="vtd-na">—</span>@endif</span></div>
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

                                    {{-- CENTER TRUCK SVG — dynamic via svg.truck partial --}}
                                    <div class="vtd-center">
                                        <div class="vtd-svg-wrap">
                                            @include('svg.truck', [
                                                'mountedTyreCount' => $vehicle->mounted_tyre_count,
                                                'mode'             => 'details',
                                                'svgId'            => 'vtdTruckSvg',
                                                'byCode'           => $byCode,
                                                'getTyreColor'     => $getTyreColor,
                                                'colorHex'         => $colorHex,
                                                'posLabels'        => $posLabels,
                                            ])

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
                                            data-manage-url="{{ route('tyremanage.vehicle.tyre.tagging.v2', $vehicle->id) }}"
                                            data-tyre-id="{{ ($m && $m->tyre) ? $m->tyre->id : '' }}"
                                            data-logs-url="{{ ($m && $m->tyre) ? route('fleetdashboard.getPositionMappingLogs', [$vehicle->id, $m->tyreposition_id]) : '' }}">
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
                                                <div class="vtd-field"><span class="vtd-fl">Remaining Life</span>
                                                    <span class="vtd-fv vtd-life-wrap">
                                                        @if($remLifePct !== null)
                                                        <span class="vtd-life-track"><span class="vtd-life-fill" style="width:{{ $remLifePct }}%;background:{{ $kmBalColor }};"></span></span>
                                                        <span style="color:{{ $kmBalColor }};font-weight:700;">{{ $remLifePct }}%</span>
                                                        @else<span class="vtd-na">—</span>@endif
                                                    </span>
                                                </div>
                                                <div class="vtd-field"><span class="vtd-fl">Actual Run KM</span><span class="vtd-fv">{{ $kmRun > 0 ? number_format($kmRun).' KM' : '—' }}</span></div>
                                                <div class="vtd-field"><span class="vtd-fl">Remaining Run</span><span class="vtd-fv" style="color:{{ $kmBalColor }};font-weight:600;">{{ $kmBal!==null ? ($kmBal<=0?'Overdue':number_format($kmBal).' KM') : '—' }}</span></div>
                                                <div class="vtd-field"><span class="vtd-fl">Remaining Warranty</span><span class="vtd-fv">@if($remWarranty!==null)<span style="color:{{ $remWarranty==0?'#ea0027':($remWarranty<=3?'#d97706':'#10863f') }};font-weight:600;">{{ $remWarranty==0?'Expired':$remWarranty.' mo.' }}</span>@else<span class="vtd-na">—</span>@endif</span></div>
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
                                            data-manage-url="{{ route('tyremanage.vehicle.tyre.tagging.v2', $vehicle->id) }}"
                                            data-tyre-id="{{ ($m && $m->tyre) ? $m->tyre->id : '' }}"
                                            data-logs-url="{{ ($m && $m->tyre) ? route('fleetdashboard.getPositionMappingLogs', [$vehicle->id, $m->tyreposition_id]) : '' }}">
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
                                                <div class="vtd-field"><span class="vtd-fl">Remaining Life</span>
                                                    <span class="vtd-fv vtd-life-wrap">
                                                        @if($remLifePct !== null)
                                                        <span class="vtd-life-track"><span class="vtd-life-fill" style="width:{{ $remLifePct }}%;background:{{ $kmBalColor }};"></span></span>
                                                        <span style="color:{{ $kmBalColor }};font-weight:700;">{{ $remLifePct }}%</span>
                                                        @else<span class="vtd-na">—</span>@endif
                                                    </span>
                                                </div>
                                                <div class="vtd-field"><span class="vtd-fl">Actual Run KM</span><span class="vtd-fv">{{ $kmRun > 0 ? number_format($kmRun).' KM' : '—' }}</span></div>
                                                <div class="vtd-field"><span class="vtd-fl">Remaining Run</span><span class="vtd-fv" style="color:{{ $kmBalColor }};font-weight:600;">{{ $kmBal!==null ? ($kmBal<=0?'Overdue':number_format($kmBal).' KM') : '—' }}</span></div>
                                                <div class="vtd-field"><span class="vtd-fl">Remaining Warranty</span><span class="vtd-fv">@if($remWarranty!==null)<span style="color:{{ $remWarranty==0?'#ea0027':($remWarranty<=3?'#d97706':'#10863f') }};font-weight:600;">{{ $remWarranty==0?'Expired':$remWarranty.' mo.' }}</span>@else<span class="vtd-na">—</span>@endif</span></div>
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

                                @if(false)
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
                                                        <p>Actual Run KM</p>
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
                                @endif
                            </div>
                        </div>
                    
                    <div class="accordion-item mt-3">
                        
                        <div class="accordion-header vehicleinfor_head" id="bat_det">

                            <div class="row vehicleinfo_toprow align-items-center">

                                <div class="col-12 col-md-11 d-flex align-items-center">
                                    <span class="titletext">Battery Details</span>
                                    <a href="{{ route('batterymanage.vehicle.battery.tagging', $vehicle->id) }}" class="badge badge-primary ms-2">
                                        <i class="uil uil-plus me-1"></i>Manage Batteries
                                    </a>
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
                                            $batWarrantyRemaining = $battery->warranty_remaining_months;
                                            $batLifeRemaining     = $battery->life_remaining_months;
                                            $batCondition  = $battery->battery_condition ?? 'New';
                                            $batCondClass  = match($batCondition) {
                                                'New'                     => 'bat-cond-new',
                                                'Used'                    => 'bat-cond-used',
                                                'Replaced Under Warranty' => 'bat-cond-replaced',
                                                default                   => 'bat-cond-new',
                                            };
                                            $batRag      = $battery->rag_status ?? 'Green';
                                            $batRagClass = match($batRag) {
                                                'Green'  => 'bat-rag-green',
                                                'Yellow' => 'bat-rag-yellow',
                                                'Red'    => 'bat-rag-red',
                                                default  => 'bat-rag-green',
                                            };
                                        @endphp
                                        <div class="bat-card">
                                            <div class="bat-card-header">
                                                <span class="bat-card-label"><i class="uil uil-bolt-alt me-1"></i>Battery #{{ $batIdx }}</span>
                                                <div class="bat-card-actions">
                                                    <span class="bat-condition-badge {{ $batCondClass }}">{{ $batCondition }}</span>
                                                    <span class="bat-rag-dot {{ $batRagClass }}" title="RAG: {{ $batRag }}"></span>
                                                    <a href="javascript:void(0)" data-id="{{ $battery->id }}" class="viewBatteryAttachment bat-eye-icon" title="View Attachments"><i class="uil uil-eye"></i></a>
                                                </div>
                                            </div>
                                            <div class="bat-card-grid">
                                                <div class="bat-field"><p>Serial Number</p><span>{{ $battery->battery_serial_number ?? '-' }}</span></div>
                                                <div class="bat-field"><p>Brand</p><span>{{ $battery->battery_brand ?? '-' }}</span></div>
                                                <div class="bat-field"><p>Model</p><span>{{ $battery->battery_model_name ?? '-' }}</span></div>
                                                <div class="bat-field"><p>Battery Capacity</p><span>{{ $battery->battery_capacity ?? '-' }}</span></div>
                                                <div class="bat-field"><p>Battery Voltage</p><span>{{ $battery->battery_voltage ?? '-' }}</span></div>
                                                <div class="bat-field"><p>Battery Condition</p><span>{{ $battery->battery_condition ?? '-' }}</span></div>
                                                <div class="bat-field"><p>Purchase Date</p><span>{{ $battery->purchase_date ? \Carbon\Carbon::parse($battery->purchase_date)->format('d/m/Y') : '-' }}</span></div>
                                                <div class="bat-field"><p>Battery Warranty</p><span>{{ $battery->warranty_months ? $battery->warranty_months.' mo' : '-' }}</span></div>
                                                <div class="bat-field"><p>Warranty Remaining</p>
                                                    <span>@if($batWarrantyRemaining === null)-@elseif($batWarrantyRemaining == 0)<span class="text-danger fw-bold">Expired</span>@elseif($batWarrantyRemaining <= 3)<span class="text-warning fw-bold">{{ $batWarrantyRemaining }} mo left</span>@else<span class="text-success">{{ $batWarrantyRemaining }} mo</span>@endif</span>
                                                </div>
                                                <div class="bat-field"><p>Fitment Date</p><span>{{ $battery->fitment_date ? \Carbon\Carbon::parse($battery->fitment_date)->format('d/m/Y') : '-' }}</span></div>
                                                <div class="bat-field"><p>Battery Life Fixed</p><span>{{ $battery->battery_life_fixed ? $battery->battery_life_fixed.' mo' : '-' }}</span></div>
                                                <div class="bat-field"><p>Battery Life Remaining</p>
                                                    <span>@if($batLifeRemaining === null)-@elseif($batLifeRemaining == 0)<span class="text-danger fw-bold">Expired</span>@elseif($batLifeRemaining <= 3)<span class="text-warning fw-bold">{{ $batLifeRemaining }} mo left</span>@else<span class="text-success">{{ $batLifeRemaining }} mo</span>@endif</span>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>

                                    {{-- CENTER: Truck SVG --}}
                                    <div class="bat-col-center">
                                        <div class="bat-truck-wrap">
                                            @include('svg.battery-truck', [
                                                'b1Fill'   => '#22c55e',
                                                'b1Stroke' => '#16a34a',
                                                'b2Fill'   => '#3b82f6',
                                                'b2Stroke' => '#2563eb',
                                                'svgClass' => 'bat-truck-svg',
                                            ])
                                            <div class="bat-truck-legend">
                                                <span class="bat-legend-dot" style="background:#22c55e;"></span><span>B1 — Battery #1</span>
                                                <span class="bat-legend-dot ms-2" style="background:#3b82f6;"></span><span>B2 — Battery #2</span>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- RIGHT COLUMN: odd-indexed batteries — v4.6 --}}
                                    <div class="bat-col-side bat-col-right">
                                        @foreach($rightBatteries as $battery)
                                        @php
                                            $batIdx = $batteryCollection->search(fn($b) => $b->id === $battery->id) + 1;
                                            $batWarrantyRemaining = $battery->warranty_remaining_months;
                                            $batLifeRemaining     = $battery->life_remaining_months;
                                            $batCondition  = $battery->battery_condition ?? 'New';
                                            $batCondClass  = match($batCondition) {
                                                'New'                     => 'bat-cond-new',
                                                'Used'                    => 'bat-cond-used',
                                                'Replaced Under Warranty' => 'bat-cond-replaced',
                                                default                   => 'bat-cond-new',
                                            };
                                            $batRag      = $battery->rag_status ?? 'Green';
                                            $batRagClass = match($batRag) {
                                                'Green'  => 'bat-rag-green',
                                                'Yellow' => 'bat-rag-yellow',
                                                'Red'    => 'bat-rag-red',
                                                default  => 'bat-rag-green',
                                            };
                                        @endphp
                                        <div class="bat-card bat-card-right">
                                            <div class="bat-card-header">
                                                <span class="bat-card-label bat-card-label-blue"><i class="uil uil-bolt-alt me-1"></i>Battery #{{ $batIdx }}</span>
                                                <div class="bat-card-actions">
                                                    <span class="bat-condition-badge {{ $batCondClass }}">{{ $batCondition }}</span>
                                                    <span class="bat-rag-dot {{ $batRagClass }}" title="RAG: {{ $batRag }}"></span>
                                                    <a href="javascript:void(0)" data-id="{{ $battery->id }}" class="viewBatteryAttachment bat-eye-icon" title="View Attachments"><i class="uil uil-eye"></i></a>
                                                </div>
                                            </div>
                                            <div class="bat-card-grid">
                                                <div class="bat-field"><p>Serial Number</p><span>{{ $battery->battery_serial_number ?? '-' }}</span></div>
                                                <div class="bat-field"><p>Brand</p><span>{{ $battery->battery_brand ?? '-' }}</span></div>
                                                <div class="bat-field"><p>Model</p><span>{{ $battery->battery_model_name ?? '-' }}</span></div>
                                                <div class="bat-field"><p>Battery Capacity</p><span>{{ $battery->battery_capacity ?? '-' }}</span></div>
                                                <div class="bat-field"><p>Battery Voltage</p><span>{{ $battery->battery_voltage ?? '-' }}</span></div>
                                                <div class="bat-field"><p>Battery Condition</p><span>{{ $battery->battery_condition ?? '-' }}</span></div>
                                                <div class="bat-field"><p>Purchase Date</p><span>{{ $battery->purchase_date ? \Carbon\Carbon::parse($battery->purchase_date)->format('d/m/Y') : '-' }}</span></div>
                                                <div class="bat-field"><p>Battery Warranty</p><span>{{ $battery->warranty_months ? $battery->warranty_months.' mo' : '-' }}</span></div>
                                                <div class="bat-field"><p>Warranty Remaining</p>
                                                    <span>@if($batWarrantyRemaining === null)-@elseif($batWarrantyRemaining == 0)<span class="text-danger fw-bold">Expired</span>@elseif($batWarrantyRemaining <= 3)<span class="text-warning fw-bold">{{ $batWarrantyRemaining }} mo left</span>@else<span class="text-success">{{ $batWarrantyRemaining }} mo</span>@endif</span>
                                                </div>
                                                <div class="bat-field"><p>Fitment Date</p><span>{{ $battery->fitment_date ? \Carbon\Carbon::parse($battery->fitment_date)->format('d/m/Y') : '-' }}</span></div>
                                                <div class="bat-field"><p>Battery Life Fixed</p><span>{{ $battery->battery_life_fixed ? $battery->battery_life_fixed.' mo' : '-' }}</span></div>
                                                <div class="bat-field"><p>Battery Life Remaining</p>
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

                <div class="item-box-scroll-wrap">
                    <button type="button" class="item-box-scroll-btn item-box-scroll-prev" aria-label="Scroll tabs left">
                        <i class="uil uil-angle-left-b"></i>
                    </button>
                    <button type="button" class="item-box-scroll-btn item-box-scroll-next" aria-label="Scroll tabs right">
                        <i class="uil uil-angle-right-b"></i>
                    </button>
                <ul class="nav nav-tabs item-box">
                    <li class="nav-item">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#pl_book">
                            <span class="icon pb-0"><i class="uil uil-chart-line" style="font-size:18px;color:#6c757d;"></i></span>
                            P&amp;L Book
                        </button>
                    </li>

                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#trip">
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
                            Expense Book
                        </button>
                    </li>

                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#toll_charges">
                            <span class="icon pb-0"><i class="uil uil-money-bill" style="font-size:24px;color:#6c757d;"></i></span>
                            Toll Charges Book
                        </button>
                    </li>

                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#maintenance">
                            <span class="icon"><img src="{{ asset('images/icons/maintenance-icon.png') }}" alt="" /></span>
                            Maintenance Book
                        </button>
                    </li>

                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#challan">
                            <span class="icon pb-0"><i class="uil uil-file-alt" style="font-size:18px;color:#6c757d;"></i></span>
                            Challan Book
                        </button>
                    </li>

                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#documents">
                            <span class="icon pb-0"><img src="{{ asset('images/icons/documents-icon.png') }}" alt="" /></span>
                            Document Book
                        </button>
                    </li>

                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#insurance">
                            <span class="icon pb-0"><i class="uil uil-shield-check" style="font-size:18px;color:#6c757d;"></i></span>
                            Insurance Book
                        </button>
                    </li>

                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#emi_book">
                            <span class="icon"><img src="{{ asset('images/icons/emi-bookicon.png') }}" alt="" /></span>
                            EMI Book
                        </button>
                    </li>

                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#driver_history">
                            <span class="icon pb-0"><i class="uil uil-history" style="font-size:18px;color:#6c757d;"></i></span>
                            Driver History Book
                        </button>
                    </li>

                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tyre_book">
                            <span class="icon pb-0"><i class="uil uil-dashboard" style="font-size:18px;color:#6c757d;"></i></span>
                            Tyre Book
                        </button>
                    </li>

                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#comment">
                            <span class="icon"><img src="{{ asset('images/icons/comments-0123.png') }}" alt="" /></span>
                            Comments
                        </button>
                    </li>
                </ul>
                </div>

                <!-- Tab Content -->
                <div class="tab-content mt-3">

                    {{-- P&L Book (Static design as per attachment, theme-aligned) --}}
                    <div class="tab-pane fade show active" id="pl_book">

                        {{-- Filter strip + RAG indicator --}}
                        <div class="plb-filter-strip">
                            <div class="plb-filter-left">
                                <span class="plb-filter-icon">
                                    <img src="{{ asset('images/icons/filter-01icon.png') }}" alt="filter" />
                                </span>
                                <div class="plb-filter-fields">
                                    <div class="plb-field">
                                        <label>Date Range</label>
                                        <div class="plb-input-wrap">
                                            <i class="uil uil-calendar-alt"></i>
                                            <input type="text"
                                                   class="daterange plb-daterange"
                                                   id="pl_daterange"
                                                   name="pl_daterange"
                                                   placeholder="Select date range...">
                                        </div>
                                    </div>
                                    <div class="plb-field">
                                        <label>Driver Name</label>
                                        <div class="plb-input-wrap plb-select-wrap">
                                            <i class="uil uil-user"></i>
                                            <select class="form-select plb-driver-select" id="pl_driver" name="pl_driver">
                                                <option value="">All Drivers</option>
                                                @isset($plDrivers)
                                                    @foreach($plDrivers as $drv)
                                                        <option value="{{ $drv->id }}">
                                                            {{ $drv->contact_name }}@if($drv->contact_code) ({{ $drv->contact_code }})@endif
                                                        </option>
                                                    @endforeach
                                                @endisset
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="plb-filter-right">
                                <span class="plb-rag-label">RAG Status</span>
                                <div class="plb-rag-pills">
                                    <span class="plb-rag plb-rag-red"><span class="dot"></span>Red</span>
                                    <span class="plb-rag plb-rag-yellow"><span class="dot"></span>Yellow</span>
                                    <span class="plb-rag plb-rag-green is-active"><span class="dot"></span>Green</span>
                                </div>
                            </div>
                        </div>

                        {{-- KPI strip — Trip Summary --}}
                        <div class="plb-kpi-grid">
                            <div class="plb-kpi">
                                <div class="plb-kpi-icon"><i class="uil uil-route"></i></div>
                                <div class="plb-kpi-body">
                                    <p>Total Trips</p>
                                    <h4>15</h4>
                                </div>
                            </div>
                            <div class="plb-kpi">
                                <div class="plb-kpi-icon kpi-c2"><i class="uil uil-map-marker"></i></div>
                                <div class="plb-kpi-body">
                                    <p>Local Trips</p>
                                    <h4>10</h4>
                                </div>
                            </div>
                            <div class="plb-kpi">
                                <div class="plb-kpi-icon kpi-c3"><i class="uil uil-arrows-h"></i></div>
                                <div class="plb-kpi-body">
                                    <p>Line Trips</p>
                                    <h4>5</h4>
                                </div>
                            </div>
                            <div class="plb-kpi">
                                <div class="plb-kpi-icon kpi-c4"><i class="uil uil-clock-three"></i></div>
                                <div class="plb-kpi-body">
                                    <p>Delay Trips</p>
                                    <h4>2</h4>
                                </div>
                            </div>
                            <div class="plb-kpi">
                                <div class="plb-kpi-icon kpi-c5"><i class="uil uil-calendar-slash"></i></div>
                                <div class="plb-kpi-body">
                                    <p>Empty Days</p>
                                    <h4>2</h4>
                                </div>
                            </div>
                            <div class="plb-kpi">
                                <div class="plb-kpi-icon kpi-c6"><i class="uil uil-tachometer-fast"></i></div>
                                <div class="plb-kpi-body">
                                    <p>KM Driven</p>
                                    <h4>8,000</h4>
                                </div>
                            </div>
                        </div>

                        {{-- Main row: Revenue & Expense + Notes panel --}}
                        <div class="plb-main-row">

                            <div class="plb-main-col">

                                {{-- Revenue + Expense side-by-side --}}
                                <div class="plb-finance-grid">
                                    {{-- Revenue --}}
                                    <div class="plb-panel plb-panel-rev">
                                        <div class="plb-panel-head">
                                            <div class="head-l">
                                                <span class="panel-icon"><i class="uil uil-money-stack"></i></span>
                                                <div>
                                                    <p class="panel-title">Total Revenue</p>
                                                    <h4 class="panel-amount">₹2,00,000</h4>
                                                </div>
                                            </div>
                                            <span class="panel-trend up"><i class="uil uil-arrow-up"></i></span>
                                        </div>
                                        <ul class="plb-panel-list">
                                            <li>
                                                <span class="lbl"><span class="bullet rev"></span>Own Booking</span>
                                                <span class="val">₹1,50,000</span>
                                            </li>
                                            <li>
                                                <span class="lbl"><span class="bullet rev"></span>Outside Booking</span>
                                                <span class="val">₹50,000</span>
                                            </li>
                                        </ul>
                                    </div>

                                    {{-- Expense --}}
                                    <div class="plb-panel plb-panel-exp">
                                        <div class="plb-panel-head">
                                            <div class="head-l">
                                                <span class="panel-icon"><i class="uil uil-receipt"></i></span>
                                                <div>
                                                    <p class="panel-title">Total Expense</p>
                                                    <h4 class="panel-amount">₹1,77,500</h4>
                                                </div>
                                            </div>
                                            <span class="panel-trend down"><i class="uil uil-arrow-down"></i></span>
                                        </div>
                                        <ul class="plb-panel-list scroll">
                                            <li><span class="lbl"><span class="bullet exp"></span>Diesel</span><span class="val">₹75,000</span></li>
                                            <li><span class="lbl"><span class="bullet exp"></span>Driver</span><span class="val">₹35,000</span></li>
                                            <li><span class="lbl"><span class="bullet exp"></span>Fasttag</span><span class="val">₹25,000</span></li>
                                            <li>
                                                <span class="lbl">
                                                    <span class="bullet exp"></span>Repair &amp; Maintenance
                                                    <small class="hint">Repairs, Urea, Schedule service</small>
                                                </span>
                                                <span class="val">₹10,000</span>
                                            </li>
                                            <li>
                                                <span class="lbl">
                                                    <span class="bullet exp"></span>Tyre
                                                    <small class="hint">Purchase, repair, rotation</small>
                                                </span>
                                                <span class="val">₹2,500</span>
                                            </li>
                                            <li><span class="lbl"><span class="bullet exp"></span>Battery</span><span class="val">₹1,000</span></li>
                                            <li><span class="lbl"><span class="bullet exp"></span>RTO Document</span><span class="val">₹4,500</span></li>
                                            <li><span class="lbl"><span class="bullet exp"></span>Challan</span><span class="val">₹1,000</span></li>
                                            <li>
                                                <span class="lbl">
                                                    <span class="bullet exp"></span>Loading
                                                    <small class="hint">No Reimbursement only</small>
                                                </span>
                                                <span class="val">₹4,800</span>
                                            </li>
                                            <li>
                                                <span class="lbl">
                                                    <span class="bullet exp"></span>Unloading
                                                    <small class="hint">No Reimbursement only</small>
                                                </span>
                                                <span class="val">₹3,000</span>
                                            </li>
                                            <li><span class="lbl"><span class="bullet exp"></span>Parking</span><span class="val">₹700</span></li>
                                            <li><span class="lbl"><span class="bullet exp"></span>Accident Charges</span><span class="val">₹5,000</span></li>
                                            <li><span class="lbl"><span class="bullet exp"></span>Border Expense</span><span class="val">₹3,000</span></li>
                                            <li><span class="lbl"><span class="bullet exp"></span>Customer Deductions</span><span class="val">₹7,000</span></li>
                                        </ul>
                                    </div>
                                </div>

                                {{-- Bottom summary: Profit/Loss + EMI + Final --}}
                                <div class="plb-summary-grid">
                                    <div class="plb-summary-card sc-profit">
                                        <span class="sc-ico"><i class="uil uil-chart-growth"></i></span>
                                        <div class="sc-body">
                                            <p>Profit or Loss</p>
                                            <h3>₹22,500</h3>
                                            <span class="sc-tag tag-up"><i class="uil uil-arrow-up"></i>Operating Profit</span>
                                        </div>
                                    </div>

                                    <div class="plb-summary-card sc-emi">
                                        <span class="sc-ico"><i class="uil uil-bill"></i></span>
                                        <div class="sc-body">
                                            <p>EMI</p>
                                            <h3>₹70,000</h3>
                                            <span class="sc-tag tag-neutral">Monthly Installment</span>
                                        </div>
                                    </div>

                                    <div class="plb-summary-card sc-final">
                                        <span class="sc-ico"><i class="uil uil-chart-down"></i></span>
                                        <div class="sc-body">
                                            <p>Profit / Loss After EMI</p>
                                            <h3>-₹47,500</h3>
                                            <span class="sc-tag tag-down"><i class="uil uil-arrow-down"></i>Net Loss</span>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            {{-- Side info panel --}}
                            <aside class="plb-side">
                                <div class="plb-side-card">
                                    <div class="plb-side-head">
                                        <span class="head-ico"><i class="uil uil-info-circle"></i></span>
                                        <h6>Amortisation Rule</h6>
                                    </div>
                                    <div class="plb-side-body">
                                        <p>
                                            Document cost is <strong>divided equally</strong> across the months covered by the policy,
                                            based on <strong>start &amp; expiry date</strong>.
                                        </p>
                                        <div class="plb-callout">
                                            <span class="callout-tag">Example</span>
                                            <p>
                                                <strong>Insurance</strong> — 12 months × <strong>₹60,000</strong>
                                                = <strong>₹5,000 / month</strong>
                                                <br><small>(not the full ₹60,000 in one month)</small>
                                            </p>
                                        </div>
                                    </div>

                                    <div class="plb-side-head">
                                        <span class="head-ico"><i class="uil uil-file-shield-alt"></i></span>
                                        <h6>Amortised Documents</h6>
                                    </div>
                                    <div class="plb-doc-grid">
                                        <div class="plb-doc"><i class="uil uil-shield-check"></i><span>Insurance</span></div>
                                        <div class="plb-doc"><i class="uil uil-file-check-alt"></i><span>1 Year Permit</span></div>
                                        <div class="plb-doc"><i class="uil uil-file-check-alt"></i><span>5 Year Permit</span></div>
                                        <div class="plb-doc"><i class="uil uil-receipt-alt"></i><span>Tax</span></div>
                                        <div class="plb-doc"><i class="uil uil-clipboard-notes"></i><span>Fitness</span></div>
                                        <div class="plb-doc"><i class="uil uil-smile"></i><span>PUCC</span></div>
                                    </div>
                                </div>
                            </aside>

                        </div>
                    </div>

                    {{-- Toll Charges Book (NEW - static placeholder) --}}
                    <div class="tab-pane fade" id="toll_charges">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4">
                                <h5 class="mb-3"><i class="uil uil-road me-2"></i>Toll Charges Book</h5>

                                {{-- Mini Dashboard (static, month-wise; supports up to 12 months) --}}
                                <div class="toll-mini-dashboard mb-4">
                                    <div class="toll-month-grid">
                                        <div class="toll-month-card">
                                            <div class="toll-month-head">
                                                <span class="toll-month-name">Jan 2026</span>
                                                <span class="toll-month-dot"></span>
                                            </div>
                                            <div class="toll-month-metrics">
                                                <div class="toll-metric">
                                                    <i class="uil uil-rupee-sign"></i>
                                                    <span class="toll-metric-val">&#8377;9,840</span>
                                                </div>
                                                <div class="toll-metric toll-metric-sub">
                                                    <i class="uil uil-receipt"></i>
                                                    <span class="toll-metric-val">14 tolls</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="toll-month-card">
                                            <div class="toll-month-head">
                                                <span class="toll-month-name">Feb 2026</span>
                                                <span class="toll-month-dot"></span>
                                            </div>
                                            <div class="toll-month-metrics">
                                                <div class="toll-metric">
                                                    <i class="uil uil-rupee-sign"></i>
                                                    <span class="toll-metric-val">&#8377;11,260</span>
                                                </div>
                                                <div class="toll-metric toll-metric-sub">
                                                    <i class="uil uil-receipt"></i>
                                                    <span class="toll-metric-val">16 tolls</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="toll-month-card">
                                            <div class="toll-month-head">
                                                <span class="toll-month-name">Mar 2026</span>
                                                <span class="toll-month-dot"></span>
                                            </div>
                                            <div class="toll-month-metrics">
                                                <div class="toll-metric">
                                                    <i class="uil uil-rupee-sign"></i>
                                                    <span class="toll-metric-val">&#8377;13,720</span>
                                                </div>
                                                <div class="toll-metric toll-metric-sub">
                                                    <i class="uil uil-receipt"></i>
                                                    <span class="toll-metric-val">19 tolls</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="toll-month-card">
                                            <div class="toll-month-head">
                                                <span class="toll-month-name">Apr 2026</span>
                                                <span class="toll-month-dot"></span>
                                            </div>
                                            <div class="toll-month-metrics">
                                                <div class="toll-metric">
                                                    <i class="uil uil-rupee-sign"></i>
                                                    <span class="toll-metric-val">&#8377;12,450</span>
                                                </div>
                                                <div class="toll-metric toll-metric-sub">
                                                    <i class="uil uil-receipt"></i>
                                                    <span class="toll-metric-val">18 tolls</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="toll-month-card">
                                            <div class="toll-month-head">
                                                <span class="toll-month-name">May 2026</span>
                                                <span class="toll-month-dot"></span>
                                            </div>
                                            <div class="toll-month-metrics">
                                                <div class="toll-metric">
                                                    <i class="uil uil-rupee-sign"></i>
                                                    <span class="toll-metric-val">&#8377;14,820</span>
                                                </div>
                                                <div class="toll-metric toll-metric-sub">
                                                    <i class="uil uil-receipt"></i>
                                                    <span class="toll-metric-val">22 tolls</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="toll-month-card">
                                            <div class="toll-month-head">
                                                <span class="toll-month-name">Jun 2026</span>
                                                <span class="toll-month-dot"></span>
                                            </div>
                                            <div class="toll-month-metrics">
                                                <div class="toll-metric">
                                                    <i class="uil uil-rupee-sign"></i>
                                                    <span class="toll-metric-val">&#8377;15,340</span>
                                                </div>
                                                <div class="toll-metric toll-metric-sub">
                                                    <i class="uil uil-receipt"></i>
                                                    <span class="toll-metric-val">23 tolls</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="toll-month-card">
                                            <div class="toll-month-head">
                                                <span class="toll-month-name">Jul 2026</span>
                                                <span class="toll-month-dot"></span>
                                            </div>
                                            <div class="toll-month-metrics">
                                                <div class="toll-metric">
                                                    <i class="uil uil-rupee-sign"></i>
                                                    <span class="toll-metric-val">&#8377;13,980</span>
                                                </div>
                                                <div class="toll-metric toll-metric-sub">
                                                    <i class="uil uil-receipt"></i>
                                                    <span class="toll-metric-val">20 tolls</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="toll-month-card">
                                            <div class="toll-month-head">
                                                <span class="toll-month-name">Aug 2026</span>
                                                <span class="toll-month-dot"></span>
                                            </div>
                                            <div class="toll-month-metrics">
                                                <div class="toll-metric">
                                                    <i class="uil uil-rupee-sign"></i>
                                                    <span class="toll-metric-val">&#8377;16,210</span>
                                                </div>
                                                <div class="toll-metric toll-metric-sub">
                                                    <i class="uil uil-receipt"></i>
                                                    <span class="toll-metric-val">24 tolls</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="toll-month-card">
                                            <div class="toll-month-head">
                                                <span class="toll-month-name">Sep 2026</span>
                                                <span class="toll-month-dot"></span>
                                            </div>
                                            <div class="toll-month-metrics">
                                                <div class="toll-metric">
                                                    <i class="uil uil-rupee-sign"></i>
                                                    <span class="toll-metric-val">&#8377;14,560</span>
                                                </div>
                                                <div class="toll-metric toll-metric-sub">
                                                    <i class="uil uil-receipt"></i>
                                                    <span class="toll-metric-val">21 tolls</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="toll-month-card">
                                            <div class="toll-month-head">
                                                <span class="toll-month-name">Oct 2026</span>
                                                <span class="toll-month-dot"></span>
                                            </div>
                                            <div class="toll-month-metrics">
                                                <div class="toll-metric">
                                                    <i class="uil uil-rupee-sign"></i>
                                                    <span class="toll-metric-val">&#8377;17,430</span>
                                                </div>
                                                <div class="toll-metric toll-metric-sub">
                                                    <i class="uil uil-receipt"></i>
                                                    <span class="toll-metric-val">26 tolls</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="toll-month-card">
                                            <div class="toll-month-head">
                                                <span class="toll-month-name">Nov 2026</span>
                                                <span class="toll-month-dot"></span>
                                            </div>
                                            <div class="toll-month-metrics">
                                                <div class="toll-metric">
                                                    <i class="uil uil-rupee-sign"></i>
                                                    <span class="toll-metric-val">&#8377;15,890</span>
                                                </div>
                                                <div class="toll-metric toll-metric-sub">
                                                    <i class="uil uil-receipt"></i>
                                                    <span class="toll-metric-val">23 tolls</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="toll-month-card">
                                            <div class="toll-month-head">
                                                <span class="toll-month-name">Dec 2026</span>
                                                <span class="toll-month-dot"></span>
                                            </div>
                                            <div class="toll-month-metrics">
                                                <div class="toll-metric">
                                                    <i class="uil uil-rupee-sign"></i>
                                                    <span class="toll-metric-val">&#8377;18,250</span>
                                                </div>
                                                <div class="toll-metric toll-metric-sub">
                                                    <i class="uil uil-receipt"></i>
                                                    <span class="toll-metric-val">27 tolls</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Filter Card (static) --}}
                                <div class="accordion mt-3" id="accordionTollChargesBook">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="toll_charges_filter">
                                            <button
                                                class="accordion-button filter-options"
                                                type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#collapseTollChargesBook"
                                                aria-expanded="true"
                                                aria-controls="collapseTollChargesBook"
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
                                            id="collapseTollChargesBook"
                                            class="accordion-collapse collapse show"
                                            aria-labelledby="toll_charges_filter"
                                            data-bs-parent="#accordionTollChargesBook">
                                            <div class="accordion-body">
                                                <form class="vehicle_dform p-4">
                                                    <div class="filtersearch-bd justify-content-between">

                                                        <div class="vehicletype">
                                                            <label>Toll Date Range</label>
                                                            <input
                                                                type="text"
                                                                class="form-control daterange"
                                                                id="tollbook_daterange"
                                                                name="toll_daterange"
                                                                autocomplete="off"
                                                                placeholder="Select date range..."
                                                            />
                                                        </div>

                                                        <div class="vehicletype ms-1">
                                                            <label>Fast-tag ID</label>
                                                            <select class="form-select select2">
                                                                <option>Choose..</option>
                                                                <option>FT-1001</option>
                                                                <option>FT-1002</option>
                                                                <option>FT-1003</option>
                                                            </select>
                                                        </div>

                                                        <div class="vehicletype ms-1">
                                                            <label>Fast-tag Bank Name</label>
                                                            <select class="form-select select2">
                                                                <option>Choose..</option>
                                                                <option>ICICI Bank</option>
                                                                <option>HDFC Bank</option>
                                                                <option>SBI</option>
                                                                <option>Axis Bank</option>
                                                                <option>Paytm Payments Bank</option>
                                                                <option>Kotak Mahindra Bank</option>
                                                                <option>IDFC First Bank</option>
                                                            </select>
                                                        </div>

                                                        <div class="vehicletype ms-1">
                                                            <label>Driver Name &amp; Code</label>
                                                            <select class="form-select select2">
                                                                <option>Choose..</option>
                                                                <option>Sujit Paul (DRV-001)</option>
                                                                <option>Ramesh Kumar (DRV-002)</option>
                                                                <option>Mohan Singh (DRV-003)</option>
                                                            </select>
                                                        </div>

                                                        <div class="vehicletype ms-1">
                                                            <label>Location</label>
                                                            <select class="form-select select2">
                                                                <option>Choose..</option>
                                                                <option>Hyderabad</option>
                                                                <option>Kolkata</option>
                                                                <option>Mumbai</option>
                                                                <option>Delhi</option>
                                                                <option>Bengaluru</option>
                                                                <option>Chennai</option>
                                                                <option>Pune</option>
                                                            </select>
                                                        </div>

                                                    </div>

                                                    <div class="filtersearch-bd searchfield justify-content-start mt-3">
                                                        <button class="btn btn-primary ms-1" type="button">
                                                            <i class="uil uil-sync me-1"></i>Reset
                                                        </button>

                                                        <div class="dropdown ms-1">
                                                            <button
                                                                class="btn btn-primary dropdown-toggle d-flex"
                                                                type="button"
                                                                id="exportBtnTollChargesBook"
                                                                data-bs-toggle="dropdown"
                                                                aria-expanded="false"
                                                            >
                                                                Export <i class="uil uil-upload ms-1"></i>
                                                            </button>
                                                            <ul class="dropdown-menu" aria-labelledby="exportBtnTollChargesBook">
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:void(0)">Excel</a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:void(0)">PDF</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Toll Charges Book Table (static design) --}}
                                <div class="table-responsive mt-3">
                                    <table class="table custom-driver-table trip-table toll-charges-table">
                                        <thead>
                                            <tr>
                                                <th>S. No</th>
                                                <th>Fast-tag ID</th>
                                                <th>Fast-tag Bank Name</th>
                                                <th>Driver Name &amp; Code</th>
                                                <th>Trip ID</th>
                                                <th>LR / Memo Number</th>
                                                <th>Date &amp; Time</th>
                                                <th>Toll Name</th>
                                                <th>Location</th>
                                                <th>Pin Code</th>
                                                <th>State</th>
                                                <th>Amount</th>
                                                <th>Price Hike</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            {{-- Row 1: Vehicle on trip --}}
                                            <tr>
                                                <td>1</td>
                                                <td>FT-1001</td>
                                                <td>ICICI Bank</td>
                                                <td>Sujit Paul <br><small class="text-muted">DRV-001</small></td>
                                                <td>
                                                    <a href="javascript:void(0)" class="text-primary fw-semibold">TRP-56667</a>
                                                    <br><small class="text-muted">LR#2897</small>
                                                </td>
                                                <td>LR#2897</td>
                                                <td>15-05-2026 <br><small class="text-muted">09:42 AM</small></td>
                                                <td>Kothur Toll Plaza</td>
                                                <td>Kothur</td>
                                                <td>509228</td>
                                                <td>Telangana</td>
                                                <td>&#8377;185</td>
                                                <td><span class="text-success">&#8377;0</span></td>
                                            </tr>

                                            {{-- Row 2: Vehicle on trip - price hike --}}
                                            <tr>
                                                <td>2</td>
                                                <td>FT-1001</td>
                                                <td>ICICI Bank</td>
                                                <td>Sujit Paul <br><small class="text-muted">DRV-001</small></td>
                                                <td>
                                                    <a href="javascript:void(0)" class="text-primary fw-semibold">TRP-56667</a>
                                                    <br><small class="text-muted">LR#2897</small>
                                                </td>
                                                <td>LR#2897</td>
                                                <td>15-05-2026 <br><small class="text-muted">02:18 PM</small></td>
                                                <td>Pune-Mumbai Expressway Toll</td>
                                                <td>Khalapur</td>
                                                <td>410202</td>
                                                <td>Maharashtra</td>
                                                <td>&#8377;320</td>
                                                <td><span class="text-danger">+&#8377;30</span></td>
                                            </tr>

                                            {{-- Row 3: Vehicle empty (no trip) --}}
                                            <tr>
                                                <td>3</td>
                                                <td>FT-1001</td>
                                                <td>ICICI Bank</td>
                                                <td>Ramesh Kumar <br><small class="text-muted">DRV-002</small></td>
                                                <td><span class="text-muted">—</span></td>
                                                <td><span class="text-muted">—</span></td>
                                                <td>16-05-2026 <br><small class="text-muted">07:05 AM</small></td>
                                                <td>Shadnagar Toll Plaza</td>
                                                <td>Shadnagar</td>
                                                <td>509216</td>
                                                <td>Telangana</td>
                                                <td>&#8377;155</td>
                                                <td><span class="text-success">&#8377;0</span></td>
                                            </tr>

                                            {{-- Row 4: New trip started --}}
                                            <tr>
                                                <td>4</td>
                                                <td>FT-1001</td>
                                                <td>ICICI Bank</td>
                                                <td>Ramesh Kumar <br><small class="text-muted">DRV-002</small></td>
                                                <td>
                                                    <a href="javascript:void(0)" class="text-primary fw-semibold">TRP-56670</a>
                                                    <br><small class="text-muted">LR#2901</small>
                                                </td>
                                                <td>LR#2901</td>
                                                <td>17-05-2026 <br><small class="text-muted">11:30 AM</small></td>
                                                <td>Bengaluru-Hosur Toll</td>
                                                <td>Attibele</td>
                                                <td>562107</td>
                                                <td>Karnataka</td>
                                                <td>&#8377;145</td>
                                                <td><span class="text-success">&#8377;0</span></td>
                                            </tr>

                                            {{-- Row 5: Price hike --}}
                                            <tr>
                                                <td>5</td>
                                                <td>FT-1001</td>
                                                <td>ICICI Bank</td>
                                                <td>Ramesh Kumar <br><small class="text-muted">DRV-002</small></td>
                                                <td>
                                                    <a href="javascript:void(0)" class="text-primary fw-semibold">TRP-56670</a>
                                                    <br><small class="text-muted">LR#2901</small>
                                                </td>
                                                <td>Memo#MO-1124</td>
                                                <td>18-05-2026 <br><small class="text-muted">05:54 PM</small></td>
                                                <td>Krishnagiri Toll Plaza</td>
                                                <td>Krishnagiri</td>
                                                <td>635001</td>
                                                <td>Tamil Nadu</td>
                                                <td>&#8377;210</td>
                                                <td><span class="text-danger">+&#8377;15</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Challan Book (NEW - static design only) --}}
                    <div class="tab-pane fade" id="challan">

                        {{-- Filter Card (static) --}}
                        <div class="accordion mt-3" id="accordionChallanBook">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="challan_filter">
                                    <button
                                        class="accordion-button filter-options"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#collapseChallanBook"
                                        aria-expanded="true"
                                        aria-controls="collapseChallanBook"
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
                                    id="collapseChallanBook"
                                    class="accordion-collapse collapse show"
                                    aria-labelledby="challan_filter"
                                    data-bs-parent="#accordionChallanBook">
                                    <div class="accordion-body">
                                        <form class="vehicle_dform p-4">
                                            <div class="filtersearch-bd justify-content-between">

                                                <div class="vehicletype">
                                                    <label>State</label>
                                                    <select class="form-select select2" id="challan_state">
                                                        <option value="">Choose..</option>
                                                        @foreach($states as $state)
                                                            <option value="{{ $state->id }}">{{ $state->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="vehicletype ms-1">
                                                    <label>Driver Name &amp; Code</label>
                                                    <select class="form-select select2" id="challan_driver">
                                                        <option value="">Choose..</option>
                                                        @foreach($plDrivers as $drv)
                                                            <option value="{{ $drv->id }}">{{ $drv->contact_name }}{{ $drv->contact_code ? ' (' . $drv->contact_code . ')' : '' }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="vehicletype ms-1">
                                                    <label>Challan RAG Status</label>
                                                    <select class="form-select select2" id="challan_rag">
                                                        <option value="">Choose..</option>
                                                        <option value="Green">Green (Below &#8377;2,000)</option>
                                                        <option value="Yellow">Yellow (&#8377;2,000 - &#8377;5,000)</option>
                                                        <option value="Red">Red (Above &#8377;5,000)</option>
                                                    </select>
                                                </div>

                                                <div class="vehicletype ms-1">
                                                    <label>Challan Status</label>
                                                    <select class="form-select select2" id="challan_status">
                                                        <option value="">Choose..</option>
                                                        <option value="Paid">Paid</option>
                                                        <option value="Unpaid">Unpaid</option>
                                                    </select>
                                                </div>

                                                <div class="vehicletype ms-1">
                                                    <label>Sent to Court</label>
                                                    <select class="form-select select2" id="challan_court">
                                                        <option value="">Choose..</option>
                                                        <option value="Yes">Yes</option>
                                                        <option value="No">No</option>
                                                    </select>
                                                </div>

                                                <div class="vehicletype ms-1">
                                                    <label>Borne By</label>
                                                    <select class="form-select select2" id="challan_borne">
                                                        <option value="">Choose..</option>
                                                        <option value="Driver">Driver</option>
                                                        <option value="SR">SR</option>
                                                        <option value="Both">Both 50/50</option>
                                                    </select>
                                                </div>

                                            </div>

                                            <div class="filtersearch-bd searchfield justify-content-start mt-3">
                                                <button class="btn btn-primary ms-1" type="button">
                                                    <i class="uil uil-sync me-1"></i>Reset
                                                </button>

                                                <div class="dropdown ms-1">
                                                    <button
                                                        class="btn btn-primary dropdown-toggle d-flex"
                                                        type="button"
                                                        id="exportBtnChallanBook"
                                                        data-bs-toggle="dropdown"
                                                        aria-expanded="false"
                                                    >
                                                        Export <i class="uil uil-upload ms-1"></i>
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="exportBtnChallanBook">
                                                        <li>
                                                            <a class="dropdown-item" href="javascript:void(0)">Excel</a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="javascript:void(0)">PDF</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm mt-3">
                            <div class="card-body p-4">
                                <h5 class="mb-3"><i class="uil uil-file-alt me-2"></i>Challan Book</h5>

                                {{-- Challan Book Table (static design) --}}
                                <div class="table-responsive mt-3">
                                    <table class="table custom-driver-table trip-table challan-book-table">
                                        <thead>
                                            <tr>
                                                <th>S. No</th>
                                                <th>Driver Name &amp; Code</th>
                                                <th>Driver License</th>
                                                <th>Challan Number</th>
                                                <th>Challan Amount</th>
                                                <th>Challan Reason</th>
                                                <th>Borne By</th>
                                                <th>Challan Date</th>
                                                <th>Challan Place</th>
                                                <th>Challan State</th>
                                                <th>State Code</th>
                                                <th>Trip Number</th>
                                                <th>Challan Status</th>
                                                <th>Offence Details</th>
                                                <th>Sent to Reg. Court</th>
                                                <th>Sent to Court On</th>
                                                <th>Court Name</th>
                                                <th>Court Address</th>
                                                <th>Date of Proceeding</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            {{-- Row 1: Borne by Driver, on a trip, paid --}}
                                            <tr>
                                                <td>1</td>
                                                <td>Sujit Paul <br><small class="text-muted">DRV-001</small></td>
                                                <td>WB-2020-0001234</td>
                                                <td>CH-23045678</td>
                                                <td>&#8377;1,500</td>
                                                <td>Over-speeding</td>
                                                <td><span class="ch-pill ch-pill-driver p-2">Driver</span></td>
                                                <td>12-04-2026 <br><small class="text-muted">11:24 AM</small></td>
                                                <td>NH-44, Kothur</td>
                                                <td>Telangana</td>
                                                <td>TS</td>
                                                <td>
                                                    <a href="javascript:void(0)" class="text-primary fw-semibold">TRP-56667</a>
                                                    <br><small class="text-muted">LR#2897</small>
                                                </td>
                                                <td><span class="ch-pill ch-pill-paid p-2">Paid</span></td>
                                                <td>Vehicle exceeded 80 km/h on highway stretch.</td>
                                                <td><span class="text-muted">—</span></td>
                                                <td><span class="text-muted">—</span></td>
                                                <td><span class="text-muted">—</span></td>
                                                <td><span class="text-muted">—</span></td>
                                                <td><span class="text-muted">—</span></td>
                                            </tr>

                                            {{-- Row 2: Borne by SR, on a trip, pending --}}
                                            <tr>
                                                <td>2</td>
                                                <td>Ramesh Kumar <br><small class="text-muted">DRV-002</small></td>
                                                <td>MH-2019-0005678</td>
                                                <td>CH-23045912</td>
                                                <td>&#8377;2,000</td>
                                                <td>Overloading</td>
                                                <td><span class="ch-pill ch-pill-sr p-2">SR</span></td>
                                                <td>22-04-2026 <br><small class="text-muted">03:45 PM</small></td>
                                                <td>Khalapur Toll</td>
                                                <td>Maharashtra</td>
                                                <td>MH</td>
                                                <td>
                                                    <a href="javascript:void(0)" class="text-primary fw-semibold">TRP-56670</a>
                                                    <br><small class="text-muted">LR#2901</small>
                                                </td>
                                                <td><span class="ch-pill ch-pill-pending p-2">Pending</span></td>
                                                <td>Gross vehicle weight exceeded permissible limit by 1.2 T.</td>
                                                <td><span class="text-muted">—</span></td>
                                                <td><span class="text-muted">—</span></td>
                                                <td><span class="text-muted">—</span></td>
                                                <td><span class="text-muted">—</span></td>
                                                <td><span class="text-muted">—</span></td>
                                            </tr>

                                            {{-- Row 3: Borne 50/50, no trip (empty), pending --}}
                                            <tr>
                                                <td>3</td>
                                                <td>Mohan Singh <br><small class="text-muted">DRV-003</small></td>
                                                <td>KA-2021-0009012</td>
                                                <td>CH-23046204</td>
                                                <td>&#8377;500</td>
                                                <td>Signal Jump</td>
                                                <td><span class="ch-pill ch-pill-split p-2">Both 50/50</span></td>
                                                <td>02-05-2026 <br><small class="text-muted">08:10 AM</small></td>
                                                <td>Attibele Junction</td>
                                                <td>Karnataka</td>
                                                <td>KA</td>
                                                <td><span class="text-muted">—</span></td>
                                                <td><span class="ch-pill ch-pill-pending p-2">Pending</span></td>
                                                <td>Crossed signal during red phase at junction CCTV-014.</td>
                                                <td><span class="text-muted">—</span></td>
                                                <td><span class="text-muted">—</span></td>
                                                <td><span class="text-muted">—</span></td>
                                                <td><span class="text-muted">—</span></td>
                                                <td><span class="text-muted">—</span></td>
                                            </tr>

                                            {{-- Row 4: Sent to Regional Court (Yes) - all court fields filled --}}
                                            <tr>
                                                <td>4</td>
                                                <td>Sujit Paul <br><small class="text-muted">DRV-001</small></td>
                                                <td>WB-2020-0001234</td>
                                                <td>CH-23046890</td>
                                                <td>&#8377;10,000</td>
                                                <td>Driving without valid permit</td>
                                                <td><span class="ch-pill ch-pill-driver p-2">Driver</span></td>
                                                <td>14-05-2026 <br><small class="text-muted">06:30 PM</small></td>
                                                <td>Krishnagiri Check Post</td>
                                                <td>Tamil Nadu</td>
                                                <td>TN</td>
                                                <td>
                                                    <a href="javascript:void(0)" class="text-primary fw-semibold">TRP-56672</a>
                                                    <br><small class="text-muted">LR#2905</small>
                                                </td>
                                                <td><span class="ch-pill ch-pill-court p-2">Sent to Court</span></td>
                                                <td>Inter-state permit not produced at check post; vehicle detained.</td>
                                                <td><span class="ch-pill ch-pill-yes p-2">Yes</span></td>
                                                <td>18-05-2026</td>
                                                <td>JMFC Court, Krishnagiri</td>
                                                <td>Court Complex, Collectorate Rd, Krishnagiri, TN — 635001</td>
                                                <td>05-06-2026 <br><small class="text-muted">10:30 AM</small></td>
                                            </tr>

                                            {{-- Row 5: Sent to Court (Yes) - 50/50 split --}}
                                            <tr>
                                                <td>5</td>
                                                <td>Ramesh Kumar <br><small class="text-muted">DRV-002</small></td>
                                                <td>MH-2019-0005678</td>
                                                <td>CH-23047155</td>
                                                <td>&#8377;5,000</td>
                                                <td>Dangerous driving</td>
                                                <td><span class="ch-pill ch-pill-split p-2">Both 50/50</span></td>
                                                <td>20-05-2026 <br><small class="text-muted">09:15 PM</small></td>
                                                <td>Shadnagar</td>
                                                <td>Telangana</td>
                                                <td>TS</td>
                                                <td><span class="text-muted">—</span></td>
                                                <td><span class="ch-pill ch-pill-court p-2">Sent to Court</span></td>
                                                <td>Lane cutting and rash overtake reported by traffic police.</td>
                                                <td><span class="ch-pill ch-pill-yes p-2">Yes</span></td>
                                                <td>25-05-2026</td>
                                                <td>Traffic Court, Shadnagar</td>
                                                <td>RTA Bhavan, Old Hyd Rd, Shadnagar, TS — 509216</td>
                                                <td>12-06-2026 <br><small class="text-muted">11:00 AM</small></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Driver History Book (NEW - static placeholder) --}}
                    <div class="tab-pane fade" id="driver_history">

                        <div class="accordion mt-3" id="accordionDriverHistoryBook">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="driver_history_filter">
                                    <button
                                        class="accordion-button filter-options"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#collapseDriverHistoryBook"
                                        aria-expanded="true"
                                        aria-controls="collapseDriverHistoryBook"
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
                                    id="collapseDriverHistoryBook"
                                    class="accordion-collapse collapse show"
                                    aria-labelledby="driver_history_filter"
                                    data-bs-parent="#accordionDriverHistoryBook">
                                    <div class="accordion-body">
                                        <form class="vehicle_dform p-4">
                                            <div class="filtersearch-bd justify-content-between">

                                                <div class="vehicletype">
                                                    <label>Date Range</label>
                                                    <input
                                                        type="text"
                                                        class="form-control daterange"
                                                        id="driverhistory_daterange"
                                                        name="driverhistory_daterange"
                                                        autocomplete="off"
                                                        placeholder="Select date range..."
                                                    />
                                                </div>

                                                <div class="vehicletype ms-1">
                                                    <label>Driver Name &amp; Code</label>
                                                    <select class="form-select select2" id="driverhistory_driver">
                                                        <option value="">Choose..</option>
                                                        <option value="DRV-0001">Rakesh Das (DRV-0001)</option>
                                                        <option value="DRV-0002">Suman Pal (DRV-0002)</option>
                                                        <option value="DRV-0003">Sovan Pal (DRV-0003)</option>
                                                        <option value="DRV-0004">Sujit Paul (DRV-0004)</option>
                                                        <option value="DRV-0005">Ramesh Kumar (DRV-0005)</option>
                                                        <option value="DRV-0006">Mohan Singh (DRV-0006)</option>
                                                    </select>
                                                </div>

                                                <div class="vehicletype ms-1">
                                                    <label>Driver RAG Status</label>
                                                    <select class="form-select select2" id="driverhistory_rag">
                                                        <option value="">Choose..</option>
                                                        <option value="Green">Green</option>
                                                        <option value="Amber">Amber</option>
                                                        <option value="Red">Red</option>
                                                    </select>
                                                </div>

                                            </div>

                                            <div class="filtersearch-bd searchfield justify-content-start mt-3">
                                                <button class="btn btn-primary ms-1" type="button">
                                                    <i class="uil uil-sync me-1"></i>Reset
                                                </button>

                                                <div class="dropdown ms-1">
                                                    <button
                                                        class="btn btn-primary dropdown-toggle d-flex"
                                                        type="button"
                                                        id="exportBtnDriverHistory"
                                                        data-bs-toggle="dropdown"
                                                        aria-expanded="false"
                                                    >
                                                        Export <i class="uil uil-upload ms-1"></i>
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="exportBtnDriverHistory">
                                                        <li>
                                                            <a class="dropdown-item" href="javascript:void(0)">Excel</a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="javascript:void(0)">PDF</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="vehiclestable">
                            <div class="table-responsive">
                                <table class="table custom-driver-table">
                                    <thead>
                                        <tr>
                                            <th style="width: 60px;">S.No</th>
                                            <th>Driver Name & Code</th>
                                            <th>Driver RAG Status</th>
                                            <th>No. of Trips</th>
                                            <th>No. of Days Assigned</th>
                                            <th>Issue Date</th>
                                            <th>Revoke Date</th>
                                            <th>Revoke Reason</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <!-- Row 1 -->
                                        <tr>
                                            <td>1</td>
                                            <td>Rakesh Das <br><small class="text-muted">DRV-0001</small></td>
                                            <td><span class="rag-pill rag-green"><i class="uil uil-circle"></i> Green</span></td>
                                            <td>20</td>
                                            <td>15</td>
                                            <td>08-09-2025 | FN</td>
                                            <td>08-01-2025 | AN</td>
                                            <td>Engine parts messing</td>
                                        </tr>

                                        <!-- Row 2 -->
                                        <tr>
                                            <td>2</td>
                                            <td>Suman Pal <br><small class="text-muted">DRV-0002</small></td>
                                            <td><span class="rag-pill rag-amber"><i class="uil uil-circle"></i> Amber</span></td>
                                            <td>20</td>
                                            <td>12</td>
                                            <td>08-09-2025 | FN</td>
                                            <td>08-12-2025 | AN</td>
                                            <td>Engine parts messing</td>
                                        </tr>

                                        <!-- Row 3 -->
                                        <tr>
                                            <td>3</td>
                                            <td>Sovan Pal <br><small class="text-muted">DRV-0003</small></td>
                                            <td><span class="rag-pill rag-red"><i class="uil uil-circle"></i> Red</span></td>
                                            <td>20</td>
                                            <td>10</td>
                                            <td>07-11-2025 | FN</td>
                                            <td>08-01-2025 | AN</td>
                                            <td>Engine parts messing</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>

                    {{-- Tyre Book (NEW - static placeholder) --}}
                    <div class="tab-pane fade" id="tyre_book">

                        {{-- Mini Dashboard — Maintenance & Repair Cost (Static) --}}
                        <div class="tbm-dashboard mt-3 mb-3">
                            <div class="tbm-group">
                                <div class="tbm-group-head">
                                    <span class="tbm-badge tbm-badge-own"><i class="uil uil-wrench"></i></span>
                                    <h5>Maintenance &amp; Repair Cost</h5>
                                </div>
                                <div class="tbm-kpi-grid">
                                    <div class="tbm-kpi">
                                        <div class="tbm-kpi-icon tbm-c3"><i class="uil uil-calendar-alt"></i></div>
                                        <div class="tbm-kpi-body">
                                            <p>Scheduled Maintenance Cost</p>
                                            <h4>₹0</h4>
                                        </div>
                                    </div>
                                    <div class="tbm-kpi">
                                        <div class="tbm-kpi-icon tbm-c4"><i class="uil uil-setting"></i></div>
                                        <div class="tbm-kpi-body">
                                            <p>Repair Cost</p>
                                            <h4>₹0</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4">
                                <h5 class="mb-3"><i class="uil uil-dashboard me-2"></i>Tyre Book</h5>
                                <p class="text-muted mb-0">Tyre history and mapping for this vehicle will appear here.</p>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="trip">

                        {{-- Mini Dashboard — Own Booking vs Outside Booking (Static) --}}
                        <div class="tbm-dashboard mt-3">
                            <div class="tbm-group">
                                <div class="tbm-group-head">
                                    <span class="tbm-badge tbm-badge-own"><i class="uil uil-truck"></i></span>
                                    <h5>Own Booking</h5>
                                </div>
                                <div class="tbm-kpi-grid">
                                    <div class="tbm-kpi">
                                        <div class="tbm-kpi-icon tbm-c1"><i class="uil uil-map-marker"></i></div>
                                        <div class="tbm-kpi-body">
                                            <p>No. of Trips</p>
                                            <h4>24</h4>
                                        </div>
                                    </div>
                                    <div class="tbm-kpi">
                                        <div class="tbm-kpi-icon tbm-c2"><i class="uil uil-money-bill"></i></div>
                                        <div class="tbm-kpi-body">
                                            <p>Revenue</p>
                                            <h4>₹8,45,000</h4>
                                        </div>
                                    </div>
                                    <div class="tbm-kpi">
                                        <div class="tbm-kpi-icon tbm-c3"><i class="uil uil-receipt"></i></div>
                                        <div class="tbm-kpi-body">
                                            <p>Expense</p>
                                            <h4>₹3,20,500</h4>
                                        </div>
                                    </div>
                                    <div class="tbm-kpi">
                                        <div class="tbm-kpi-icon tbm-c4"><i class="uil uil-minus-circle"></i></div>
                                        <div class="tbm-kpi-body">
                                            <p>Deduction</p>
                                            <h4>₹18,750</h4>
                                        </div>
                                    </div>
                                    <div class="tbm-kpi">
                                        <div class="tbm-kpi-icon tbm-c5"><i class="uil uil-chart-line"></i></div>
                                        <div class="tbm-kpi-body">
                                            <p>Profit / Loss</p>
                                            <h4 class="tbm-profit">₹5,05,750</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tbm-group">
                                <div class="tbm-group-head">
                                    <span class="tbm-badge tbm-badge-out"><i class="uil uil-exchange"></i></span>
                                    <h5>Outside Booking</h5>
                                </div>
                                <div class="tbm-kpi-grid">
                                    <div class="tbm-kpi">
                                        <div class="tbm-kpi-icon tbm-c1"><i class="uil uil-map-marker"></i></div>
                                        <div class="tbm-kpi-body">
                                            <p>No. of Trips</p>
                                            <h4>9</h4>
                                        </div>
                                    </div>
                                    <div class="tbm-kpi">
                                        <div class="tbm-kpi-icon tbm-c2"><i class="uil uil-money-bill"></i></div>
                                        <div class="tbm-kpi-body">
                                            <p>Revenue</p>
                                            <h4>₹2,75,000</h4>
                                        </div>
                                    </div>
                                    <div class="tbm-kpi">
                                        <div class="tbm-kpi-icon tbm-c3"><i class="uil uil-receipt"></i></div>
                                        <div class="tbm-kpi-body">
                                            <p>Expense</p>
                                            <h4>₹1,42,000</h4>
                                        </div>
                                    </div>
                                    <div class="tbm-kpi">
                                        <div class="tbm-kpi-icon tbm-c4"><i class="uil uil-minus-circle"></i></div>
                                        <div class="tbm-kpi-body">
                                            <p>Deduction</p>
                                            <h4>₹6,500</h4>
                                        </div>
                                    </div>
                                    <div class="tbm-kpi">
                                        <div class="tbm-kpi-icon tbm-c5"><i class="uil uil-chart-line"></i></div>
                                        <div class="tbm-kpi-body">
                                            <p>Profit / Loss</p>
                                            <h4 class="tbm-loss">-₹12,500</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

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
                                        <form class="vehicle_dform p-4">
                                            <div class="filtersearch-bd justify-content-between">
                                                <div class="vehicletype">
                                                    <label>LR Date Range</label>
                                                    <input
                                                        type="text"
                                                        class="form-control daterange"
                                                        id="tripbook_lr_daterange"
                                                        name="lr_daterange"
                                                        autocomplete="off"
                                                        placeholder="Select date range..."
                                                    />
                                                </div>

                                                <div class="vehicletype ms-1">
                                                    <label>Trip Type</label>
                                                    <select class="form-select">
                                                        <option>Choose..</option>
                                                        <option>Own Booking</option>
                                                        <option>Outside Booking</option>
                                                    </select>
                                                </div>

                                                <div class="vehicletype ms-1">
                                                    <label>Customer / Load Vendor</label>
                                                    <select class="form-select select2">
                                                        <option>Choose..</option>
                                                        <option>John Doe (Customer)</option>
                                                        <option>Acme Logistics (Customer)</option>
                                                        <option>Bharat Carriers (Load Vendor)</option>
                                                        <option>Speed Movers (Load Vendor)</option>
                                                    </select>
                                                </div>

                                                <div class="vehicletype ms-1">
                                                    <label>Route</label>
                                                    <select class="form-select select2">
                                                        <option>Choose..</option>
                                                        <option>HYD - KOL</option>
                                                        <option>DEL - PUN</option>
                                                        <option>MUM - HYD</option>
                                                        <option>BLR - CHN</option>
                                                    </select>
                                                </div>

                                                <div class="vehicletype ms-1">
                                                    <label>Driver Name &amp; Code</label>
                                                    <select class="form-select select2">
                                                        <option>Choose..</option>
                                                        <option>Sujit Paul (DRV-001)</option>
                                                        <option>Ramesh Kumar (DRV-002)</option>
                                                        <option>Mohan Singh (DRV-003)</option>
                                                    </select>
                                                </div>

                                                <div class="vehicletype ms-1">
                                                    <label>Trip RAG Status</label>
                                                    <select class="form-select">
                                                        <option>Choose..</option>
                                                        <option>On Time (Green)</option>
                                                        <option>Delayed (Amber)</option>
                                                        <option>Critical (Red)</option>
                                                    </select>
                                                </div>

                                                <div class="vehicletype ms-1">
                                                    <label>POD Deduction Trips</label>
                                                    <select class="form-select">
                                                        <option>Choose..</option>
                                                        <option>With POD Deduction</option>
                                                        <option>Without POD Deduction</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="filtersearch-bd searchfield justify-content-start mt-3">
                                                <div class="ms-1" style="width: 220px">
                                                    <div class="input-group">
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            placeholder="Search by Trip ID"
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
                                                            placeholder="Search by LR #"
                                                        />
                                                        <span class="input-group-text"
                                                            ><i class="uil uil-search"></i
                                                        ></span>
                                                    </div>
                                                </div>

                                                <button class="btn btn-primary ms-1" type="button">
                                                    <i class="uil uil-sync me-1"></i>Reset
                                                </button>

                                                <div class="dropdown ms-1">
                                                    <button
                                                        class="btn btn-primary dropdown-toggle d-flex"
                                                        type="button"
                                                        id="exportBtnTripBook"
                                                        data-bs-toggle="dropdown"
                                                        aria-expanded="false"
                                                    >
                                                        Export <i class="uil uil-upload ms-1"></i>
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="exportBtnTripBook">
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
                                <a href="{{ route('trip.index') }}?open=create" class="addtripbtn">
                                    <i class="uil uil-plus me-1"></i>Add Trip</a>
                            </div>
                            
                            <div class="table-responsive">
                                <table class="table custom-driver-table trip-table">
                                    <thead>
                                        <tr>
                                            <th>S. No</th>
                                            <th>Trip ID</th>
                                            <th>LR / Memo Number & Date</th>
                                            <th>Trip Type</th>
                                            <th>Customer / Load Vendor</th>
                                            <th>Route</th>
                                            <th>Loading Point & Unloading Point</th>
                                            <th>Trip Start Date & Time</th>
                                            <th>Trip End Date & Time</th>
                                            <th>Driver Name & Code</th>
                                            <th>Trip Status</th>
                                            <th>Trip RAG Status</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <!-- Row 1 -->
                                        <tr>
                                            <td>1</td>
                                            <td><a href="{{ route('trip.details', 1) }}" class="text-primary fw-semibold">TRP-56667</a></td>
                                            <td>LR#2897 <br><small class="text-muted">13/11/2025</small></td>
                                            <td><span class="badge badge-secondary">Outside Booking</span></td>
                                            <td>John Doe <br><small class="text-muted">Load Vendor</small></td>
                                            <td>HYD - KOL</td>
                                            <td>Kolkata <br><small class="text-muted">→ Mumbai</small></td>
                                            <td>19-09-2025 <br><small class="text-muted">12:00 PM</small></td>
                                            <td>25-09-2025 <br><small class="text-muted">12:00 PM</small></td>
                                            <td>Sujit Paul <br><small class="text-muted">DRV-001</small></td>
                                            <td>
                                                <span class="badge badge-warning d-inline-flex align-items-center gap-1 px-2 py-1">
                                                    <i class="uil uil-clock"></i> Initiated
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-light text-dark border d-inline-flex align-items-center gap-2 px-2 py-1"
                                                      data-bs-toggle="tooltip" data-bs-placement="top"
                                                      title="On Time Delivery & No POD Deductions">
                                                    <span style="width:8px;height:8px;border-radius:50%;background:#28a745;display:inline-block;"></span>
                                                    On Time
                                                </span>
                                            </td>
                                        </tr>

                                        <!-- Row 2 -->
                                        <tr>
                                            <td>2</td>
                                            <td><a href="{{ route('trip.details', 1) }}" class="text-primary fw-semibold">TRP-56668</a></td>
                                            <td>LR#2898 <br><small class="text-muted">13/11/2025</small></td>
                                            <td><span class="badge badge-primary">Own Booking</span></td>
                                            <td>John Doe <br><small class="text-muted">Customer</small></td>
                                            <td>HYD - KOL</td>
                                            <td>Mumbai <br><small class="text-muted">→ Hyderabad</small></td>
                                            <td>19-09-2025 <br><small class="text-muted">12:00 PM</small></td>
                                            <td>25-09-2025 <br><small class="text-muted">12:00 PM</small></td>
                                            <td>Sujit Paul <br><small class="text-muted">DRV-001</small></td>
                                            <td>
                                                <span class="badge badge-info d-inline-flex align-items-center gap-1 px-2 py-1">
                                                    <i class="uil uil-truck"></i> On Going
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-light text-dark border d-inline-flex align-items-center gap-2 px-2 py-1"
                                                      data-bs-toggle="tooltip" data-bs-placement="top"
                                                      title="Delayed trip as per SR transit time">
                                                    <span style="width:8px;height:8px;border-radius:50%;background:#ffc107;display:inline-block;"></span>
                                                    Delayed
                                                </span>
                                            </td>
                                        </tr>

                                        <!-- Row 3 -->
                                        <tr>
                                            <td>3</td>
                                            <td><a href="{{ route('trip.details', 1) }}" class="text-primary fw-semibold">TRP-56669</a></td>
                                            <td>LR#2899 <br><small class="text-muted">13/11/2025</small></td>
                                            <td><span class="badge badge-primary">Own Booking</span></td>
                                            <td>John Doe <br><small class="text-muted">Customer</small></td>
                                            <td>HYD - KOL</td>
                                            <td>Mumbai <br><small class="text-muted">→ Hyderabad</small></td>
                                            <td>19-09-2025 <br><small class="text-muted">12:00 PM</small></td>
                                            <td>25-09-2025 <br><small class="text-muted">12:00 PM</small></td>
                                            <td>Sujit Paul <br><small class="text-muted">DRV-001</small></td>
                                            <td>
                                                <span class="badge badge-success d-inline-flex align-items-center gap-1 px-2 py-1">
                                                    <i class="uil uil-check-circle"></i> Completed
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-light text-dark border d-inline-flex align-items-center gap-2 px-2 py-1"
                                                      data-bs-toggle="tooltip" data-bs-placement="top"
                                                      title="Customer delay / POD deductions / Accident / Driver escalation / Vehicle challan / Diesel theft">
                                                    <span style="width:8px;height:8px;border-radius:50%;background:#dc3545;display:inline-block;"></span>
                                                    Critical
                                                </span>
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

                        {{-- Fuel Expenses & Consumption KPI Row --}}
                        {{-- <div class="totalrevenue mt-3">
                            <div class="item-row">

                                <div class="itemcol">
                                    <p>Total Fuel Expenses</p>
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <h6 style="font-size: 12px;">Cash</h6>
                                            <span class="number c-01">₹20,000</span>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <h6 style="font-size: 12px;">Credit</h6>
                                            <span class="number c-01">₹25,000</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="itemcol">
                                    <p>Total Fuel Consumption</p>
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <h6 style="font-size: 12px;">Quantity</h6>
                                            <span class="number c-02">1,000 L</span>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <h6 style="font-size: 12px;">Avg. Rate</h6>
                                            <span class="number c-02">₹100 / L</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="itemcol">
                                    <p>Total Refuels</p>
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <h6 style="font-size: 12px;">Count</h6>
                                            <span class="number c-03">24</span>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <h6 style="font-size: 12px;">Avg. Qty</h6>
                                            <span class="number c-03">42 L</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="itemcol">
                                    <p>Mileage (KMPL)</p>
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <h6 style="font-size: 12px;">This Month</h6>
                                            <span class="number c-04">4.8</span>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <h6 style="font-size: 12px;">Last Month</h6>
                                            <span class="number c-04">4.6</span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div> --}}

                        {{-- ============================================================
                             FUEL BOOK — MINI DASHBOARD (static)
                             Isolated component (fmd-* namespace). Does NOT reuse
                             .totalrevenue / .item-row / .itemcol — those carry a
                             20% fixed width from style.css that broke the grid.
                             ============================================================ --}}
                        <div class="fmd mt-3">

                            {{-- Hero KPI strip --}}
                            <div class="fmd-hero">
                                <div class="fmd-hero-card fmd-hero--pri">
                                    <span class="fmd-hero-label">Total Fuel — Amount</span>
                                    <span class="fmd-hero-value">₹4,50,000</span>
                                    <span class="fmd-hero-sub">across 4,500 L</span>
                                </div>
                                <div class="fmd-hero-card fmd-hero--succ">
                                    <span class="fmd-hero-label">Total Fuel — Quantity</span>
                                    <span class="fmd-hero-value">4,500 <span class="fmd-hero-unit">L</span></span>
                                    <span class="fmd-hero-sub">across 24 refuels</span>
                                </div>
                                <div class="fmd-hero-card fmd-hero--warn">
                                    <span class="fmd-hero-label">Average Fuel Rate</span>
                                    <span class="fmd-hero-value">₹100.00 <span class="fmd-hero-unit">/ L</span></span>
                                    <span class="fmd-hero-sub">Total Amount / Total Qty</span>
                                </div>
                            </div>

                            {{-- Section: By Payment Method --}}
                            <div class="fmd-panel mt-3">
                                <div class="fmd-panel-head">
                                    <div class="fmd-panel-title">
                                        <span class="fmd-panel-bullet"></span>
                                        By Payment Method
                                    </div>
                                    <div class="fmd-panel-sub">Split of amount &amp; quantity across payment modes</div>
                                </div>
                                <div class="fmd-panel-body">
                                    <div class="fmd-grid fmd-grid--4">

                                        <div class="fmd-card fmd-card--pri">
                                            <div class="fmd-card-name">OTP</div>
                                            <div class="fmd-card-stats">
                                                <div class="fmd-stat">
                                                    <span class="fmd-stat-label">Amount</span>
                                                    <span class="fmd-stat-value">₹1,20,000</span>
                                                </div>
                                                <div class="fmd-stat">
                                                    <span class="fmd-stat-label">Qty</span>
                                                    <span class="fmd-stat-value">1,200 L</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="fmd-card fmd-card--succ">
                                            <div class="fmd-card-name">Market-pe</div>
                                            <div class="fmd-card-stats">
                                                <div class="fmd-stat">
                                                    <span class="fmd-stat-label">Amount</span>
                                                    <span class="fmd-stat-value">₹95,000</span>
                                                </div>
                                                <div class="fmd-stat">
                                                    <span class="fmd-stat-label">Qty</span>
                                                    <span class="fmd-stat-value">950 L</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="fmd-card fmd-card--warn">
                                            <div class="fmd-card-name">UPI</div>
                                            <div class="fmd-card-stats">
                                                <div class="fmd-stat">
                                                    <span class="fmd-stat-label">Amount</span>
                                                    <span class="fmd-stat-value">₹85,000</span>
                                                </div>
                                                <div class="fmd-stat">
                                                    <span class="fmd-stat-label">Qty</span>
                                                    <span class="fmd-stat-value">850 L</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="fmd-card fmd-card--danger">
                                            <div class="fmd-card-name">On Credit</div>
                                            <div class="fmd-card-stats">
                                                <div class="fmd-stat">
                                                    <span class="fmd-stat-label">Amount</span>
                                                    <span class="fmd-stat-value">₹1,50,000</span>
                                                </div>
                                                <div class="fmd-stat">
                                                    <span class="fmd-stat-label">Qty</span>
                                                    <span class="fmd-stat-value">1,500 L</span>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            {{-- Section: By Fuel Company --}}
                            <div class="fmd-panel mt-3">
                                <div class="fmd-panel-head">
                                    <div class="fmd-panel-title">
                                        <span class="fmd-panel-bullet"></span>
                                        By Fuel Company
                                    </div>
                                    <div class="fmd-panel-sub">Spend &amp; quantity per OMC / retail outlet</div>
                                </div>
                                <div class="fmd-panel-body">
                                    <div class="fmd-grid fmd-grid--3">

                                        <div class="fmd-card fmd-card--pri">
                                            <div class="fmd-card-name">Jio</div>
                                            <div class="fmd-card-stats">
                                                <div class="fmd-stat">
                                                    <span class="fmd-stat-label">Amount</span>
                                                    <span class="fmd-stat-value">₹75,000</span>
                                                </div>
                                                <div class="fmd-stat">
                                                    <span class="fmd-stat-label">Qty</span>
                                                    <span class="fmd-stat-value">750 L</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="fmd-card fmd-card--warn">
                                            <div class="fmd-card-name">Nyara</div>
                                            <div class="fmd-card-stats">
                                                <div class="fmd-stat">
                                                    <span class="fmd-stat-label">Amount</span>
                                                    <span class="fmd-stat-value">₹68,000</span>
                                                </div>
                                                <div class="fmd-stat">
                                                    <span class="fmd-stat-label">Qty</span>
                                                    <span class="fmd-stat-value">680 L</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="fmd-card fmd-card--purp">
                                            <div class="fmd-card-name">Indian Oil</div>
                                            <div class="fmd-card-stats">
                                                <div class="fmd-stat">
                                                    <span class="fmd-stat-label">Amount</span>
                                                    <span class="fmd-stat-value">₹1,10,000</span>
                                                </div>
                                                <div class="fmd-stat">
                                                    <span class="fmd-stat-label">Qty</span>
                                                    <span class="fmd-stat-value">1,100 L</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="fmd-card fmd-card--danger">
                                            <div class="fmd-card-name">Bharat Petroleum</div>
                                            <div class="fmd-card-stats">
                                                <div class="fmd-stat">
                                                    <span class="fmd-stat-label">Amount</span>
                                                    <span class="fmd-stat-value">₹82,000</span>
                                                </div>
                                                <div class="fmd-stat">
                                                    <span class="fmd-stat-label">Qty</span>
                                                    <span class="fmd-stat-value">820 L</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="fmd-card fmd-card--succ">
                                            <div class="fmd-card-name">HP</div>
                                            <div class="fmd-card-stats">
                                                <div class="fmd-stat">
                                                    <span class="fmd-stat-label">Amount</span>
                                                    <span class="fmd-stat-value">₹70,000</span>
                                                </div>
                                                <div class="fmd-stat">
                                                    <span class="fmd-stat-label">Qty</span>
                                                    <span class="fmd-stat-value">700 L</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="fmd-card fmd-card--info">
                                            <div class="fmd-card-name">Kalpataru Fuel Station</div>
                                            <div class="fmd-card-stats">
                                                <div class="fmd-stat">
                                                    <span class="fmd-stat-label">Amount</span>
                                                    <span class="fmd-stat-value">₹45,000</span>
                                                </div>
                                                <div class="fmd-stat">
                                                    <span class="fmd-stat-label">Qty</span>
                                                    <span class="fmd-stat-value">450 L</span>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                        {{-- /Fuel Book Mini Dashboard --}}

                        <div class="accordion mt-3" id="accordionFuelBook">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="fuel_book">
                                    <button
                                        class="accordion-button filter-options"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#collapse02"
                                        aria-expanded="true"
                                        aria-controls="collapse02"
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
                                    data-bs-parent="#accordionFuelBook">
                                    <div class="accordion-body">
                                        <form class="vehicle_dform p-4">
                                            <div class="filtersearch-bd justify-content-between">

                                                <div class="vehicletype">
                                                    <label>Fuel Date Range</label>
                                                    <input
                                                        type="text"
                                                        class="form-control daterange"
                                                        id="fuelbook_daterange"
                                                        name="fuel_daterange"
                                                        autocomplete="off"
                                                        placeholder="Select date range..."
                                                    />
                                                </div>

                                                <div class="vehicletype ms-1">
                                                    <label>Driver Name &amp; Code</label>
                                                    <select class="form-select select2">
                                                        <option>Choose..</option>
                                                        <option>Sujit Paul (DRV-001)</option>
                                                        <option>Ramesh Kumar (DRV-002)</option>
                                                        <option>Mohan Singh (DRV-003)</option>
                                                    </select>
                                                </div>

                                                <div class="vehicletype ms-1">
                                                    <label>Fuel Company</label>
                                                    <select class="form-select select2">
                                                        <option>Choose..</option>
                                                        <option>Indian Oil (IOCL)</option>
                                                        <option>Hindustan Petroleum (HPCL)</option>
                                                        <option>Bharat Petroleum (BPCL)</option>
                                                        <option>Reliance Petroleum</option>
                                                        <option>Nayara Energy</option>
                                                        <option>Shell</option>
                                                    </select>
                                                </div>

                                                <div class="vehicletype ms-1">
                                                    <label>Location</label>
                                                    <select class="form-select select2">
                                                        <option>Choose..</option>
                                                        <option>Hyderabad</option>
                                                        <option>Kolkata</option>
                                                        <option>Mumbai</option>
                                                        <option>Delhi</option>
                                                        <option>Bengaluru</option>
                                                        <option>Chennai</option>
                                                        <option>Pune</option>
                                                    </select>
                                                </div>

                                                <div class="vehicletype ms-1">
                                                    <label>Payment Method</label>
                                                    <select class="form-select">
                                                        <option>Choose..</option>
                                                        <option>OTP</option>
                                                        <option>Market-pe</option>
                                                        <option>UPI</option>
                                                        <option>On Credit</option>
                                                    </select>
                                                </div>

                                            </div>

                                            <div class="filtersearch-bd searchfield justify-content-start mt-3">
                                                <div class="ms-1" style="width: 220px">
                                                    <div class="input-group">
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            placeholder="Search by Trip ID"
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
                                                            placeholder="Search by LR Number"
                                                        />
                                                        <span class="input-group-text"
                                                            ><i class="uil uil-search"></i
                                                        ></span>
                                                    </div>
                                                </div>

                                                <button class="btn btn-primary ms-1" type="button">
                                                    <i class="uil uil-sync me-1"></i>Reset
                                                </button>

                                                <div class="dropdown ms-1">
                                                    <button
                                                        class="btn btn-primary dropdown-toggle d-flex"
                                                        type="button"
                                                        id="exportBtnFuelBook"
                                                        data-bs-toggle="dropdown"
                                                        aria-expanded="false"
                                                    >
                                                        Export <i class="uil uil-upload ms-1"></i>
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="exportBtnFuelBook">
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


                        <div class="sr_dashboard0_table">
                            <div class="container-fluid">
                                <div class="itemtop mb-3">
                                    <span class="sec-title">Fuel Book List</span>
                                </div>

                                <div class="table-responsive">
                                    <table class="table custom-driver-table">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th style="min-width: 110px">Trip ID</th>
                                                <th style="min-width: 160px">LR Number &amp; Date</th>
                                                <th style="min-width: 180px">Route</th>
                                                <th style="min-width: 180px">Driver Name &amp; Code</th>
                                                <th style="min-width: 110px">Fuel Date</th>
                                                <th>Fuel Qty (L)</th>
                                                <th>Fuel Amount</th>
                                                <th style="min-width: 130px">Fuel Per L Rate</th>
                                                <th style="min-width: 160px">Fuel Company</th>
                                                <th style="min-width: 130px">Location</th>
                                                <th style="min-width: 130px">Payment Method</th>
                                                <th style="min-width: 140px">Odo-Meter Reading</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <tr>
                                                <td>1</td>
                                                <td>TRP-1001</td>
                                                <td>
                                                    <span class="value">LR-2025-0451</span><br>
                                                    <small>05/09/2025</small>
                                                </td>
                                                <td>Hyderabad → Kolkata</td>
                                                <td>
                                                    <span class="value">Sujit Paul</span><br>
                                                    <small>DRV-001</small>
                                                </td>
                                                <td>08/09/2025</td>
                                                <td>85</td>
                                                <td>₹ 8,500</td>
                                                <td>₹ 100.00</td>
                                                <td>Hindustan Petroleum</td>
                                                <td>Hyderabad</td>
                                                <td><span class="value">UPI</span></td>
                                                <td>1,25,200</td>
                                            </tr>

                                            <tr>
                                                <td>2</td>
                                                <td>TRP-1002</td>
                                                <td>
                                                    <span class="value">LR-2025-0478</span><br>
                                                    <small>12/09/2025</small>
                                                </td>
                                                <td>Kolkata → Mumbai</td>
                                                <td>
                                                    <span class="value">Ramesh Kumar</span><br>
                                                    <small>DRV-002</small>
                                                </td>
                                                <td>14/09/2025</td>
                                                <td>120</td>
                                                <td>₹ 12,240</td>
                                                <td>₹ 102.00</td>
                                                <td>Indian Oil (IOCL)</td>
                                                <td>Nagpur</td>
                                                <td><span class="value">OTP</span></td>
                                                <td>1,26,540</td>
                                            </tr>

                                            <tr>
                                                <td>3</td>
                                                <td>—</td>
                                                <td>—</td>
                                                <td><span class="upcoming-trip-pill p-2">Upcoming trip</span></td>
                                                <td>
                                                    <span class="value">Mohan Singh</span><br>
                                                    <small>DRV-003</small>
                                                </td>
                                                <td>20/09/2025</td>
                                                <td>60</td>
                                                <td>₹ 6,120</td>
                                                <td>₹ 102.00</td>
                                                <td>Bharat Petroleum (BPCL)</td>
                                                <td>Pune</td>
                                                <td><span class="value">Market-pe</span></td>
                                                <td>1,27,180</td>
                                            </tr>

                                            <tr>
                                                <td>4</td>
                                                <td>TRP-1003</td>
                                                <td>
                                                    <span class="value">LR-2025-0502</span><br>
                                                    <small>22/09/2025</small>
                                                </td>
                                                <td>Mumbai → Delhi</td>
                                                <td>
                                                    <span class="value">Sujit Paul</span><br>
                                                    <small>DRV-001</small>
                                                </td>
                                                <td>24/09/2025</td>
                                                <td>95</td>
                                                <td>₹ 9,690</td>
                                                <td>₹ 102.00</td>
                                                <td>Reliance Petroleum</td>
                                                <td>Vadodara</td>
                                                <td><span class="value">On Credit</span></td>
                                                <td>1,28,420</td>
                                            </tr>

                                            <tr>
                                                <td>5</td>
                                                <td>TRP-1004</td>
                                                <td>
                                                    <span class="value">LR-2025-0531</span><br>
                                                    <small>28/09/2025</small>
                                                </td>
                                                <td>Delhi → Bengaluru</td>
                                                <td>
                                                    <span class="value">Ramesh Kumar</span><br>
                                                    <small>DRV-002</small>
                                                </td>
                                                <td>30/09/2025</td>
                                                <td>110</td>
                                                <td>₹ 11,330</td>
                                                <td>₹ 103.00</td>
                                                <td>Shell</td>
                                                <td>Jaipur</td>
                                                <td><span class="value">UPI</span></td>
                                                <td>1,29,860</td>
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

                        {{-- Mini-Dashboard — Total + Expense Type Wise (Static) --}}
                        <div class="exp-mini-dashboard">
                            <div class="exp-mini-head">
                                <span class="exp-mini-title">
                                    <i class="uil uil-chart-pie"></i> Expense Mini-Dashboard
                                </span>
                                <span class="exp-mini-sub">Snapshot of expenses for this vehicle</span>
                            </div>

                            <div class="exp-kpi-grid">
                                {{-- Total Expense (highlight card) --}}
                                <div class="exp-kpi exp-kpi-total">
                                    <div class="exp-kpi-icon"><i class="uil uil-usd-circle"></i></div>
                                    <div class="exp-kpi-body">
                                        <p>Total Expense</p>
                                        <h4><i class="fa fa-inr"></i> 1,25,000</h4>
                                    </div>
                                </div>

                                {{-- Expense Type Wise — dynamic from Expense model (amounts remain static) --}}
                                @forelse($expenseTypes as $i => $type)
                                    <div class="exp-kpi">
                                        <div class="exp-kpi-icon exp-c{{ ($i % 8) + 1 }}"><i class="uil uil-tag-alt"></i></div>
                                        <div class="exp-kpi-body">
                                            <p>{{ $type->name }}</p>
                                            <h4><i class="fa fa-inr"></i> 0</h4>
                                        </div>
                                    </div>
                                @empty
                                    <div class="exp-kpi-empty">
                                        <i class="uil uil-info-circle"></i>
                                        No active expense types configured.
                                    </div>
                                @endforelse
                            </div>
                        </div>
                        {{-- End Mini-Dashboard --}}

                        <div class="accordion mt-3" id="accordionExpenseBook">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="expense_book_filter">
                                    <button
                                        class="accordion-button filter-options"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#collapseExpenseBook"
                                        aria-expanded="true"
                                        aria-controls="collapseExpenseBook"
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
                                    id="collapseExpenseBook"
                                    class="accordion-collapse collapse show"
                                    aria-labelledby="expense_book_filter"
                                    data-bs-parent="#accordionExpenseBook">
                                    <div class="accordion-body">
                                        <form class="vehicle_dform p-4">
                                            <div class="filtersearch-bd justify-content-between">

                                                <div class="vehicletype">
                                                    <label>Expense Date Range</label>
                                                    <input
                                                        type="text"
                                                        class="form-control daterange"
                                                        id="expensebook_daterange"
                                                        name="expense_daterange"
                                                        autocomplete="off"
                                                        placeholder="Select date range..."
                                                    />
                                                </div>

                                                <div class="vehicletype ms-1">
                                                    <label>Driver Name &amp; Code</label>
                                                    <select class="form-select select2">
                                                        <option>Choose..</option>
                                                        <option>Sujit Paul (DRV-001)</option>
                                                        <option>Ramesh Kumar (DRV-002)</option>
                                                        <option>Mohan Singh (DRV-003)</option>
                                                    </select>
                                                </div>

                                                <div class="vehicletype ms-1">
                                                    <label>Expense Type</label>
                                                    <select class="form-select select2">
                                                        <option>Choose..</option>
                                                        <option>Maintenance</option>
                                                        <option>Repair</option>
                                                        <option>Tyre</option>
                                                        <option>Battery</option>
                                                        <option>RTO Document</option>
                                                        <option>Challan</option>
                                                        <option>Police</option>
                                                        <option>Loading</option>
                                                        <option>Unloading</option>
                                                        <option>Parking</option>
                                                        <option>Border Expense</option>
                                                        <option>Accident Charges</option>
                                                        <option>Driver Allowance</option>
                                                        <option>Miscellaneous</option>
                                                    </select>
                                                </div>

                                                <div class="vehicletype ms-1">
                                                    <label>Payment Method</label>
                                                    <select class="form-select">
                                                        <option>Choose..</option>
                                                        <option>Cash</option>
                                                        <option>UPI</option>
                                                        <option>Bank Transfer</option>
                                                        <option>Cheque</option>
                                                        <option>Credit Card</option>
                                                        <option>Debit Card</option>
                                                        <option>On Credit</option>
                                                    </select>
                                                </div>

                                            </div>

                                            <div class="filtersearch-bd searchfield justify-content-start mt-3">
                                                <div class="ms-1" style="width: 220px">
                                                    <div class="input-group">
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            placeholder="Search by Trip ID"
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
                                                            placeholder="Search by LR Number"
                                                        />
                                                        <span class="input-group-text"
                                                            ><i class="uil uil-search"></i
                                                        ></span>
                                                    </div>
                                                </div>

                                                <button class="btn btn-primary ms-1" type="button">
                                                    <i class="uil uil-sync me-1"></i>Reset
                                                </button>

                                                <div class="dropdown ms-1">
                                                    <button
                                                        class="btn btn-primary dropdown-toggle d-flex"
                                                        type="button"
                                                        id="exportBtnExpenseBook"
                                                        data-bs-toggle="dropdown"
                                                        aria-expanded="false"
                                                    >
                                                        Export <i class="uil uil-upload ms-1"></i>
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="exportBtnExpenseBook">
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
                                            <th>S.No</th>
                                            <th>Trip ID</th>
                                            <th>LR Number &amp; Date</th>
                                            <th>Driver Name &amp; Code</th>
                                            <th>Route</th>
                                            <th>Date</th>
                                            <th>Expense Type</th>
                                            <th>Expense Amount</th>
                                            <th>Payment Method</th>
                                            <th>Comment</th>
                                            <th>Attachment</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <!-- Row 1 -->
                                        <tr>
                                            <td>1</td>
                                            <td>TRP-56667</td>
                                            <td>
                                                LR-10234
                                                <span class="text-secondary d-block">08-09-2025</span>
                                            </td>
                                            <td>
                                                Ramesh Kumar
                                                <span class="text-secondary d-block">DRV-001</span>
                                            </td>
                                            <td>Chennai &rarr; Bangalore</td>
                                            <td>08-09-2025</td>
                                            <td>Maintenance</td>
                                            <td>&#8377; 4,500</td>
                                            <td>Cash</td>
                                            <td>Paid on call request</td>
                                            <td>
                                                <a href="#" class="text-primary">
                                                    <i class="uil uil-paperclip"></i>
                                                </a>
                                            </td>
                                        </tr>

                                        <!-- Row 2 -->
                                        <tr>
                                            <td>2</td>
                                            <td>TRP-56867</td>
                                            <td>
                                                LR-10298
                                                <span class="text-secondary d-block">08-10-2025</span>
                                            </td>
                                            <td>
                                                Suresh Babu
                                                <span class="text-secondary d-block">DRV-014</span>
                                            </td>
                                            <td>Hyderabad &rarr; Pune</td>
                                            <td>08-10-2025</td>
                                            <td>Repair</td>
                                            <td>&#8377; 1,000</td>
                                            <td>Cash</td>
                                            <td>Paid on call request</td>
                                            <td>
                                                <a href="#" class="text-primary">
                                                    <i class="uil uil-paperclip"></i>
                                                </a>
                                            </td>
                                        </tr>

                                        <!-- Row 3 — Diesel without trip → Route shows Empty -->
                                        <tr>
                                            <td>3</td>
                                            <td>&mdash;</td>
                                            <td>&mdash;</td>
                                            <td>
                                                Mahesh Singh
                                                <span class="text-secondary d-block">DRV-022</span>
                                            </td>
                                            <td><span class="text-muted">Empty</span></td>
                                            <td>09-10-2025</td>
                                            <td>Diesel</td>
                                            <td>&#8377; 3,200</td>
                                            <td>UPI</td>
                                            <td>Top-up at depot</td>
                                            <td>
                                                <a href="#" class="text-primary">
                                                    <i class="uil uil-paperclip"></i>
                                                </a>
                                            </td>
                                        </tr>

                                        <!-- Row 4 — Driver advance -->
                                        <tr>
                                            <td>4</td>
                                            <td>TRP-57012</td>
                                            <td>
                                                LR-10355
                                                <span class="text-secondary d-block">12-10-2025</span>
                                            </td>
                                            <td>
                                                Ramesh Kumar
                                                <span class="text-secondary d-block">DRV-001</span>
                                            </td>
                                            <td>Chennai &rarr; Coimbatore</td>
                                            <td>12-10-2025</td>
                                            <td>Driver Advance</td>
                                            <td>&#8377; 5,000</td>
                                            <td>Bank Transfer</td>
                                            <td>Advance for trip expenses</td>
                                            <td>
                                                <a href="#" class="text-primary">
                                                    <i class="uil uil-paperclip"></i>
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
                            <small class="error text-danger" id="add_gps_plan_start_date_error"></small>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>GPS Plan Validity (No. of Months) <span class="text-danger">*</span></label>
                            <input type="text" name="gps_plan_validity" id="gps_plan_validity" class="form-control">
                            <small class="error text-danger" id="add_gps_plan_validity_error"></small>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>Renew Date <span class="text-danger">*</span></label>
                            <input type="date" name="gps_plan_renew_date" id="gps_plan_renew_date" class="form-control" readonly>
                            <small class="error text-danger" id="add_gps_plan_renew_date_error"></small>
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
{{-- <div class="modal fade" id="addTrip" tabindex="-1">
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
</div> --}}
    
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
     BATTERY LOG MODAL — bat-detail-modal
     Populated via vehicle-details.js
═══════════════════════════════════════════════════════ --}}
<div class="modal fade" id="batDetailModal" tabindex="-1" aria-labelledby="batDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:480px;">
        <div class="modal-content vtd-modal-content">
            <div class="modal-header vtd-modal-header" id="batModalHeader">
                <div class="d-flex align-items-center gap-2">
                    <span class="vtd-modal-pos-dot" id="batModalDot"></span>
                    <div>
                        <div class="vtd-modal-title" id="batDetailModalLabel">Battery Logs</div>
                        <div class="vtd-modal-subtitle" id="batModalSubtitle"></div>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body vtd-modal-body vtd-modal-body-scroll" id="batModalBody">
                {{-- Populated by JS --}}
            </div>
            <div class="modal-footer vtd-modal-footer">
                <a href="{{ route('batterymanage.vehicle.battery.tagging', $vehicle->id) }}" class="btn btn-sm vtd-modal-manage-btn">
                    <i class="uil uil-plus me-1"></i>Manage Batteries
                </a>
                <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════
     TYRE DETAIL MODAL — vtd-detail-modal
     Populated via vehicle-details-tyre.js
═══════════════════════════════════════════════════════ --}}
<div class="modal fade" id="vtdTyreDetailModal" tabindex="-1" aria-labelledby="vtdTyreDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:480px;">
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
            <div class="modal-body vtd-modal-body vtd-modal-body-scroll" id="vtdModalBody">
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
<script type="text/javascript" src="{{ asset('customjs/fleet/vehicle-details.js?v=2.5') }}"></script>
<script type="text/javascript" src="{{ asset('customjs/fleet/html-related-scripts.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/Fleet/vehicle-details-tyre.js?v=3.6') }}"></script>
<script type="text/javascript" src="{{ asset('js/fleet/pl-book.js?v=1.0') }}"></script>
<script type="text/javascript" src="{{ asset('js/fleet/vehicle-tabs-scroll.js?v=1.1') }}"></script>

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
    var BATTERY_LOGS_URL = "{{ route('batterymanage.vehicle.battery.logs', [$vehicle->id, ':battery']) }}";

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
