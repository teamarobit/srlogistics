@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css" />
<link rel="stylesheet" href="{{ asset('css/fleet/vehicle-details.css?v=1.0') }}">
<link rel="stylesheet" href="{{ asset('css/fleet/vehicle-details-v2.css?v=1.3') }}">
@endsection

@section('content')

    
    
<div class="layout-wrapper">
    
    @include('includes.header')

    {{-- srlog-bdwrapper provides the 60px top padding to clear the fixed navbar.
         vehicledtl-bd is applied ONLY to the inner content section, not here. --}}
    <div class="srlog-bdwrapper" style="background:#f0f3fa;">

    {{-- ═══════════════════════════════════════════════════════════
         V2 INTELLIGENCE HEADER
         Old statsbar + item2 are hidden via CSS (.v2-statsbar,
         .item2 display:none). All original HTML preserved below.
    ═══════════════════════════════════════════════════════════ --}}
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
                    @if($vehicle->group) · {{ $vehicle->group->name }} @endif
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
                <button class="btn btn-sm" style="background:#f0f4ff;color:#032671;border:1px solid #c5d0ee;font-size:11px;font-weight:600;">
                    <i class="uil uil-refresh me-1"></i>Refresh Vahan
                </button>
                <a href="{{ route('fleetdashboard.getVehicleDetails', $vehicle->id) }}"
                   class="btn btn-sm"
                   style="background:#f8f9fc;color:#6b7a99;border:1px solid #dde3f0;font-size:11px;font-weight:600;">
                    ← V1
                </a>
            </div>
        </div>

        {{-- ── INTELLIGENCE GRID ── --}}
        <div class="v2-intel-grid">

            {{-- COLUMN 1 — COMPLIANCE --}}
            <div class="v2-intel-col health-{{ $colCompliance }}">
                <div class="v2-intel-col-title">
                    <i class="uil uil-shield"></i> Compliance & Insurance
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
                    <span class="v2-intel-val {{ $totalEmi > 0 ? '' : '' }}" style="font-size:15px;">
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

                @if(is_object($chassisLoan) && $chassisLoan->financeprovider_id)
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
                <a href="javascript:void(0)"
                   class="v2-intel-action"
                   onclick="document.querySelector('[data-bs-target=\'#tab-emi\'], a[href=\'#tab-emi\']')?.click()">
                    <i class="uil uil-book-open"></i> View EMI Book
                </a>
            </div>

        </div>{{-- end intel-grid --}}
    </div>{{-- end header-zone --}}

    {{-- vehicledtl-bd wraps the inner accordion/tab content section --}}
    <div class="vehicledtl-bd">
        <div class="topbar-bd" style="display:none !important;">
            <div class="item1" style="display:none;">{{-- hidden in v2 — replaced by statsbar above --}}
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <h1>Vehicle Details</h1>
                        </div>
                        <div class="col-12 col-md-6 text-end">
                            <button class="btn btn-theme mt-1"><i class="uil uil-refresh me-1"></i>Refresh Vahan Details</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="item2">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <div class="ltblock">
                                <div class="icon_car {{ $vehicle->basicinfo->registration_status == 'Active' ? 'reg-active' : 'reg-inactive' }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{ $vehicle->basicinfo->registration_status == 'Active' ? 'Registration Active' : 'Registration Inactive' }}">
                                    <img src="{{ asset('images/icons/car-icon04.png') }}" />
                                </div>

                                <div class="text">
                                    <div class="topsec">
                                        <p>{{ $vehicle->vehicle_no ?? '-' }}</p>
                                        <span class="addbtn">Add TAG <i class="uil uil-plus"></i></span>
                                    </div>

                                    <span class="cartype">Truck</span>
                                    <span class="cartype">
                                        Driver: {{ $vehicle->driverAllocation?->contact?->contact_name ?? 'Not Assigned' }} 
                                        <a data-id="{{ $vehicle->id }}" class="edit-driver-btn" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#notAssigned02"><i class="uil uil-pen"></i></a>
                                    </span>
                                </div>

                                <div class="liveloc_sec">
                                    <span>Live Location</span>
                                    <p>Delhi</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="rtblock">
                                <div class="item-btn c_green">
                                    <span class="icon"><i class="uil uil-shield-check text-primary"></i></span>
                                    <div class="text">
                                        <p>RC Verified</p>
                                    </div>
                                </div>

                                <div class="item-btn c_blue">
                                    <span class="icon"><i class="uil uil-shield-check text-primary"></i></span>
                                    <div class="text">
                                        <span>Trip Fleet Status</span>
                                        <p>Maintenance</p>
                                    </div>
                                </div>

                                <div class="item-btn c_green">
                                    <span class="icon"><i class="uil uil-shield-check text-primary"></i></span>
                                    <div class="text">
                                        <span>Fleet Status</span>
                                        <p>On Trip</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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
                                            </tr>
                                            <tr>
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
                        
                        <!--////-->
                        
                        <div class="important_df">
                            
                            <div class="accordion-header item_1datfin" id="important_dates">
                                
                                <div class="row align-items-center">
                                    <div class="col-lg-11">
                                        <div class="d-flex align-items-center">
                                            <div class="sec_title">Important Dates & Finance</div>
                                            
                                            <div class="vahan_01dtlhead">
                                                <div class="item01">Vahan Details:<p>{{ $vehicle->vehicle_no ?? '-' }}</p></div>
                                            </div> 
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-1">
                                        <button class="accordion-button filter-options" type="button" data-bs-toggle="collapse" data-bs-target="#important_bd"
                                        aria-expanded="true" aria-controls="important_bd"></button>
                                    </div>
                                </div>
                            </div>

                            <div id="important_bd" class="accordion-collapse collapse show mb-4" aria-labelledby="important_dates" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <table class="table">
                                       <tbody>
                                           
                                        <tr>
                                            
                                            <td>
                                                <p>Owner Name</p>
                                                <span class="text-secondary d-block">{{ $vehicle->basicinfo->owner_name ?? '' }}</span>
                                            </td>
                                    
                                            <td>
                                                <p>Address</p>
                                                <span class="text-secondary d-block">{{ $vehicle->basicinfo->owner_address ?? '' }}</span>
                                            </td>
                                    
                                            <td>
                                                <p>Status</p>
                                                <span class="text-secondary d-block">{{ $vehicle->basicinfo->registration_status ?? '' }}</span>
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
                                                <p>Fitness Certificate Expiry</p>
                                                <span class="text-secondary d-block">
                                                    {{ !empty($vehicle->basicinfo->fitness_expiry) 
                                                    ? \Carbon\Carbon::parse($vehicle->basicinfo->fitness_expiry)->format('d/m/Y') 
                                                    : '' }}
                                                </span>
                                            </td>
                                        </tr>
                                    
                                        <tr>
                                            <td>
                                                <p>Insurance Expiry</p>
                                                <span class="text-secondary d-block">
                                                    {{ !empty($vehicle->basicinfo->insurance_expiry) 
                                                    ? \Carbon\Carbon::parse($vehicle->basicinfo->insurance_expiry)->format('d/m/Y') 
                                                    : '' }}
                                                </span>
                                            </td>
                                    
                                            <td>
                                                <p>Tax Expiry</p>
                                                <span class="text-secondary d-block">
                                                    {{ !empty($vehicle->basicinfo->tax_expiry) 
                                                    ? \Carbon\Carbon::parse($vehicle->basicinfo->tax_expiry)->format('d/m/Y') 
                                                    : '' }}
                                                </span>
                                            </td>
                                            <td>
                                                <p>Permit Expiry</p>
                                                <span class="text-secondary d-block">
                                                    {{ !empty($vehicle->basicinfo->permit_expiry) 
                                                    ? \Carbon\Carbon::parse($vehicle->basicinfo->permit_expiry)->format('d/m/Y') 
                                                    : '' }}
                                                </span>
                                            </td>
                                    
                                            <td>
                                                <p>PUCC Expiry</p>
                                                <span class="text-secondary d-block">
                                                    {{ !empty($vehicle->basicinfo->pucc_expiry) 
                                                    ? \Carbon\Carbon::parse($vehicle->basicinfo->pucc_expiry)->format('d/m/Y') 
                                                    : '' }}
                                                </span>
                                            </td>
                                    
                                            <td>
                                                <p>National Permit Expiry</p>
                                                <span class="text-secondary d-block">
                                                    {{ !empty($vehicle->basicinfo->national_permit_expiry) 
                                                    ? \Carbon\Carbon::parse($vehicle->basicinfo->national_permit_expiry)->format('d/m/Y') 
                                                    : '' }}
                                                </span>
                                            </td>
                                        </tr>
                                    
                                        <tr>
                                            <td>
                                                <p>Permit Type</p>
                                                <span class="text-secondary d-block">{{ $vehicle->basicinfo->permit_type ?? '' }}</span>
                                            </td>
                                    
                                            <td>
                                                <p>PUCC Number</p>
                                                <span class="text-secondary d-block">{{ $vehicle->basicinfo->pucc_no ?? '' }}</span>
                                            </td>
                                    
                                            <td>
                                                <p>Permit Number</p>
                                                <span class="text-secondary d-block">{{ $vehicle->basicinfo->permit_no ?? '' }}</span>
                                            </td>
                                    
                                            <td>
                                                <p>Insurer</p>
                                                <span class="text-secondary d-block">{{ $vehicle->basicinfo->insurer ?? '' }}</span>
                                            </td>
                                    
                                            <td>
                                                <p>Insurance Number</p>
                                                <span class="text-secondary d-block">{{ $vehicle->basicinfo->insurance_no ?? '' }}</span>
                                            </td>
                                            
                                        </tr>
                                    
                                        <tr>
                                            
                                    
                                            
                                    
                                            <td>
                                                <p>Chassis Number</p>
                                                <span class="text-secondary d-block">{{ $vehicle->basicinfo->chassis_no ?? '' }}</span>
                                            </td>
                                        </tr>
                                    
                                        <tr>
                                            <td>
                                                <p>Engine Number</p>
                                                <span class="text-secondary d-block">{{ $vehicle->basicinfo->engine_no ?? '' }}</span>
                                            </td>
                                    
                                            <td>
                                                <p>Manufacturer</p>
                                                <span class="text-secondary d-block">{{ $vehicle->basicinfo->manufacturer ?? '' }}</span>
                                            </td>
                                    
                                            <td>
                                                <p>Model</p>
                                                <span class="text-secondary d-block">{{ $vehicle->basicinfo->model ?? '' }}</span>
                                            </td>
                                    
                                            <td>
                                                <p>Norms Type</p>
                                                <span class="text-secondary d-block">{{ $vehicle->basicinfo->norms_type ?? '' }}</span>
                                            </td>
                                    
                                            <td>
                                                <p>Gross Vehicle Weight</p>
                                                <span class="text-secondary d-block">18500</span>
                                            </td>
                                        </tr>
                                    
                                        <tr>
                                            <td>
                                                <p>Unladen Weight</p>
                                                <span class="text-secondary d-block">8850</span>
                                            </td>
                                    
                                            <td>
                                                <p>Vehicle Category</p>
                                                <span class="text-secondary d-block">{{ $vehicle->basicinfo->vehicle_category ?? '' }}</span>
                                            </td>
                                    
                                            <td>
                                                <p>Wheelbase</p>
                                                <span class="text-secondary d-block">{{ $vehicle->basicinfo->wheelbase ?? '' }}</span>
                                            </td>
                                    
                                            <td>
                                                <p>Commercial FASTag</p>
                                                <span class="text-secondary d-block">{{ $vehicle->basicinfo->commercial_fastag ?? '' }}</span>
                                            </td>
                                    
                                            <td>
                                                <p>FASTag ID</p>
                                                <span class="text-secondary d-block">{{ $vehicle->basicinfo->fastagId ?? '' }}</span>
                                            </td>
                                        </tr>
                                            
                                        <tr>
                                            <td>
                                                <p>TID</p>
                                                <span class="text-secondary d-block">E200341201360400001A47AA8</span>
                                            </td>
                                            
                                            <td>
                                                <p>FASTag Issue Date</p>
                                                <span class="text-secondary d-block">
                                                    {{ !empty($vehicle->basicinfo->fastag_issue_date) 
                                                    ? \Carbon\Carbon::parse($vehicle->basicinfo->fastag_issue_date)->format('d/m/Y') 
                                                    : '' }}
                                                </span>
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
                                            </tr>
                                            <tr>
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
                            <div class="accordion-body">
                                @forelse($vehicle->vehicletyremappings()->with(['tyre', 'tyreposition'])->orderBy('status')->get() as $mapping)
                                <div class="inner-card mb-3">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <span class="fw-semibold" style="font-size:12px; color:#032671;">
                                            <i class="uil uil-circle me-1"></i>
                                            Wheel Position: <strong>{{ $mapping->tyreposition->description ?? $mapping->tyreposition->code ?? '-' }}</strong>
                                            @if($mapping->status === 'Spare')
                                                <span class="badge badge-warning ms-1">Stepney</span>
                                            @elseif($mapping->status === 'Inactive')
                                                <span class="badge badge-danger ms-1">Removed</span>
                                            @else
                                                <span class="badge badge-success ms-1">Fitted</span>
                                            @endif
                                        </span>
                                        <a href="{{ route('tyremanage.vehicle.tyre.tagging', $vehicle->id) }}" class="text-primary" style="font-size:12px;">
                                            <i class="uil uil-pen me-1"></i>Edit
                                        </a>
                                    </div>
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
                                @empty
                                <div class="alert alert-warning text-center p-2" role="alert">
                                    No tyres are mapped to this vehicle yet.
                                    <a href="{{ route('tyremanage.vehicle.tyre.tagging', $vehicle->id) }}" class="alert-link ms-1">Manage Tyres →</a>
                                </div>
                                @endforelse
                            </div>
                        </div>

                    </div>
                    
                    <div class="accordion-item mt-3">
                        
                        <div class="accordion-header vehicleinfor_head" id="bat_det">
                            
                            <div class="row vehicleinfo_toprow align-items-center">
                             
                                <div class="col-12 col-md-11 d-flex align-items-center">
                                    <span class="titletext">Battery Details</span>
                                    <a href="javascript:void(0)" class="badge badge-primary" data-bs-toggle="modal" data-bs-target="#addBattery"><i class="uil uil-plus me-1"></i>Add Battery Details</a>
                                </div>
                                
                                <div class="col-12 col-md-1">
                                    <button class="accordion-button filter-options" type="button" data-bs-toggle="collapse" data-bs-target="#bat_bd"
                                        aria-expanded="true" aria-controls="bat_bd">
                                    </button>
                                </div>
                            </div>
                            
                        </div>

                        <div id="bat_bd" class="accordion-collapse collapse show" aria-labelledby="bat_det" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                
                                @forelse($vehicle->batteries as $battery)
                                <div class="inner-card">
                                    <div class="icon-wrap">
                                        <a href="javascript:void(0)" data-id="{{ $battery->id }}" class="editBattery"><i class="uil uil-pen"></i></a>
                                        <a href="javascript:void(0)" data-id="{{ $battery->id }}" class="deleteBattery text-danger ms-1"><i class="uil uil-trash-alt"></i></a>
                                    </div>
                                    <div class="table-responsive table-responsive02">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <p>Battery Model Name</p>
                                                        <span class="text-secondary d-block">{{ $battery->battery_model_name ?? '-' }}</span>
                                                    </td>
                                                    <td>
                                                        <p>Battery Capacity</p>
                                                        <span class="text-secondary d-block">{{ $battery->battery_capacity ?? '-' }}</span>
                                                    </td>
                                                    <td>
                                                        <p>Battery Brand</p>
                                                        <span class="text-secondary d-block">{{ $battery->battery_brand ?? '-' }}</span>
                                                    </td>
                                                    <td>
                                                        <p>Battery Price</p>
                                                        <span class="text-secondary d-block">{{ $battery->battery_price ?? '-' }}</span>
                                                    </td>
                                                    <td>
                                                        <p>Battery Serial Number</p>
                                                        <span class="text-secondary d-block">{{ $battery->battery_serial_number ?? '-' }}</span>
                                                    </td>
                                                    <td>
                                                        <p>Purchase Date</p>
                                                        <span class="text-secondary d-block">{{ $battery->purchase_date ? \Carbon\Carbon::parse($battery->purchase_date)->format('d/m/Y') : '-' }} </span>
                                                    </td>
                                                    
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <p>Issue Date</p>
                                                        <span class="text-secondary d-block">{{ $battery->issue_date ? \Carbon\Carbon::parse($battery->issue_date)->format('d/m/Y') : '-' }} </span>
                                                    </td>
                                                    <td>
                                                        <p>Warranty (Months)</p>
                                                        <span class="text-secondary d-block">{{ $battery->warranty_months ?? '-' }}</span>
                                                    </td>
                                                    <td>
                                                        <p>Remaining Warranty (Months)</p>
                                                        <span class="text-secondary d-block">
                                                            @if($battery->issue_date && $battery->warranty_months)
                                                                @php
                                                                    $issueDate = \Carbon\Carbon::parse($battery->issue_date);
                                                                    $today = \Carbon\Carbon::today();
                                                    
                                                                    $warrantyEnd = $issueDate->copy()->addMonths((int)$battery->warranty_months);
                                                    
                                                                    $remainingWarranty = $today->greaterThan($warrantyEnd)
                                                                        ? 0
                                                                        : (int) $today->diffInMonths($warrantyEnd);
                                                                @endphp
                                                    
                                                                @if($remainingWarranty == 0)
                                                                    <span class="text-danger fw-bold">Expired</span>
                                                                @elseif($remainingWarranty <= 3)
                                                                    <span class="text-warning fw-bold">{{ $remainingWarranty }} month(s) left</span>
                                                                @else
                                                                    <span class="text-success">{{ $remainingWarranty }} month(s)</span>
                                                                @endif
                                                    
                                                            @else
                                                                -
                                                            @endif
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <p>Fixed Life (Months)</p>
                                                        <span class="text-secondary d-block">{{ $battery->fixed_life_months ?? '-' }}</span>
                                                    </td>
                                                    <td>
                                                        <p>Remaining Life (Months)</p>
                                                        <span class="text-secondary d-block">
                                                            @if($battery->issue_date && $battery->fixed_life_months)
                                                                @php
                                                                    $issueDate = \Carbon\Carbon::parse($battery->issue_date);
                                                                    $today = \Carbon\Carbon::today();
                                                    
                                                                    $lifeEnd = $issueDate->copy()->addMonths((int)$battery->fixed_life_months);
                                                    
                                                                    $remainingLife = $today->greaterThan($lifeEnd)
                                                                        ? 0
                                                                        : (int) $today->diffInMonths($lifeEnd);
                                                                @endphp
                                                    
                                                                @if($remainingLife == 0)
                                                                    <span class="text-danger fw-bold">Expired</span>
                                                                @elseif($remainingLife <= 3)
                                                                    <span class="text-warning fw-bold">{{ $remainingLife }} month(s) left</span>
                                                                @else
                                                                    <span class="text-success">{{ $remainingLife }} month(s)</span>
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
                                    Please Add Battery Details, No Data is Added yet. 
                                </div>
                                @endforelse
                                
                                
                                
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
                            Documents
                            @if($total_doc_count > 0)
                                <span class="v2-tab-badge">{{ $total_doc_count }}</span>
                            @endif
                            @if($expired_doc_count > 0)
                                <span class="v2-tab-badge" style="background:#fde8e8;color:#c0392b;">{{ $expired_doc_count }} exp</span>
                            @endif
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
                                            {{-- V2: EMI progress bar for chassis loan --}}
                                            @if($chassisLoan && $chassisLoan->total_months > 0)
                                            @php
                                                $cPaid = $chassisLoan->paid_upto_months ?? 0;
                                                $cTotal = $chassisLoan->total_months;
                                                $cPct = min(100, round(($cPaid / $cTotal) * 100));
                                                $cRemaining = $cTotal - $cPaid;
                                            @endphp
                                            <div style="background:#f8f9fc;border:1px solid #e8eaf2;border-radius:8px;padding:14px 16px;margin-bottom:12px;">
                                                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:6px;">
                                                    <span style="font-size:11px;font-weight:700;color:#032671;text-transform:uppercase;letter-spacing:.4px;">Repayment Progress</span>
                                                    <span style="font-size:12px;font-weight:700;color:#032671;">{{ $cPct }}%</span>
                                                </div>
                                                <div class="v2-emi-progress">
                                                    <div class="v2-emi-progress-fill" style="width:{{ $cPct }}%;"></div>
                                                </div>
                                                <div style="display:flex;justify-content:space-between;margin-top:6px;font-size:11px;color:#9098b1;">
                                                    <span><strong style="color:#1a2340;">{{ $cPaid }}</strong> of {{ $cTotal }} months paid</span>
                                                    <span><strong style="color:#c45a00;">{{ $cRemaining }}</strong> months remaining</span>
                                                </div>
                                            </div>
                                            @endif

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

                                    {{-- V2: EMI progress bar for body loan --}}
                                    @if($bodyLoan && ($bodyLoan->total_months ?? 0) > 0)
                                    @php
                                        $bPaid = $bodyLoan->paid_upto_months ?? 0;
                                        $bTotal = $bodyLoan->total_months;
                                        $bPct = min(100, round(($bPaid / $bTotal) * 100));
                                        $bRemaining = $bTotal - $bPaid;
                                    @endphp
                                    <div style="background:#f8f9fc;border:1px solid #e8eaf2;border-radius:8px;padding:14px 16px;margin-bottom:12px;margin-top:12px;">
                                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:6px;">
                                            <span style="font-size:11px;font-weight:700;color:#032671;text-transform:uppercase;letter-spacing:.4px;">Repayment Progress</span>
                                            <span style="font-size:12px;font-weight:700;color:#032671;">{{ $bPct }}%</span>
                                        </div>
                                        <div class="v2-emi-progress">
                                            <div class="v2-emi-progress-fill" style="width:{{ $bPct }}%;"></div>
                                        </div>
                                        <div style="display:flex;justify-content:space-between;margin-top:6px;font-size:11px;color:#9098b1;">
                                            <span><strong style="color:#1a2340;">{{ $bPaid }}</strong> of {{ $bTotal }} months paid</span>
                                            <span><strong style="color:#c45a00;">{{ $bRemaining }}</strong> months remaining</span>
                                        </div>
                                    </div>
                                    @endif

                                    <div class="table-responsive table-responsive02">
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
                        <div style="padding:4px 0 24px;">

                        @php
                            /* ── Policy data from vehicleinsurancepolicies table ── */
                            $allPolicies    = $vehicle->basicinfo->insurancePolicies ?? collect();
                            $currentPolicy  = $allPolicies->where('status', 'Active')
                                                ->sortByDesc('policy_end_date')->first();
                            $pastPolicies   = $allPolicies->where('status', '!=', 'Active')
                                                ->sortByDesc('policy_end_date');

                            /* Days / badge for current policy */
                            if ($currentPolicy) {
                                $cpDays = $currentPolicy->policy_end_date
                                    ? (int) now()->startOfDay()->diffInDays($currentPolicy->policy_end_date->startOfDay(), false)
                                    : null;
                            } else {
                                /* Fallback to basicinfo field */
                                $cpDays = $insDays;
                            }

                            $cpBadgeLabel = $cpDays === null ? 'Unknown'
                                          : ($cpDays < 0    ? 'Expired'
                                          : ($cpDays <= 30  ? 'Expiring Soon'
                                          : ($cpDays <= 90  ? 'Renew Soon' : 'Active')));
                            $cpBadgeBg  = $cpDays === null ? '#e2e8f0'
                                        : ($cpDays < 0    ? '#fee2e2'
                                        : ($cpDays <= 30  ? '#fff3e0'
                                        : ($cpDays <= 90  ? '#fef9c3' : '#dcfce7')));
                            $cpBadgeClr = $cpDays === null ? '#64748b'
                                        : ($cpDays < 0    ? '#b91c1c'
                                        : ($cpDays <= 30  ? '#c2410c'
                                        : ($cpDays <= 90  ? '#854d0e' : '#15803d')));
                            $cpDaysLbl  = $cpDays === null ? '—'
                                        : ($cpDays < 0 ? abs($cpDays) . ' days overdue' : $cpDays . ' days left');

                            /* Claims from DB */
                            $vClaims       = $vehicle->insuranceclaims ?? collect();
                            $openClaims    = $vClaims->whereIn('status', ['filed','survey','under_review','pending_docs'])->count();
                            $settledClaims = $vClaims->where('status','settled')->count();
                            $totalClaimed  = $vClaims->sum('claimed_amount');
                            $totalReceived = $vClaims->sum('settled_amount');
                        @endphp

                        {{-- ════════════════════════════════════════════════════
                             TAB HEADER
                        ════════════════════════════════════════════════════ --}}
                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;padding-bottom:12px;border-bottom:1px solid #edf0f9;">
                            <div>
                                <div style="font-size:13px;font-weight:700;color:#032671;letter-spacing:.1px;">
                                    <i class="uil uil-shield-check me-2" style="font-size:16px;"></i>Insurance Policy &amp; Claim History
                                </div>
                                <div style="font-size:11px;color:#94a3b8;margin-top:2px;">Policy coverage records and claim history for this vehicle</div>
                            </div>
                            <button class="btn btn-sm"
                                style="font-size:12px;font-weight:600;background:#032671;color:#fff;padding:5px 14px;border-radius:7px;border:none;white-space:nowrap;"
                                onclick="openPolicyModal()">
                                <i class="uil uil-plus me-1"></i>Add New Policy
                            </button>
                        </div>

                        {{-- ════════════════════════════════════════════════════
                             CURRENT POLICY CARD
                        ════════════════════════════════════════════════════ --}}
                        @if($currentPolicy)
                        @php
                            $cpEditArgs = implode(',', [
                                $currentPolicy->id,
                                $currentPolicy->insurancecompany_id ?? 'null',
                                json_encode($currentPolicy->policy_number ?? ''),
                                json_encode($currentPolicy->policy_type),
                                json_encode($currentPolicy->insured_value ?? ''),
                                json_encode($currentPolicy->premium_amount ?? ''),
                                json_encode($currentPolicy->policy_start_date?->format('Y-m-d') ?? ''),
                                json_encode($currentPolicy->policy_end_date?->format('Y-m-d') ?? ''),
                                json_encode($currentPolicy->notes ?? ''),
                                json_encode($currentPolicy->policy_document ?? ''),
                                json_encode($currentPolicy->policy_document_name ?? ''),
                            ]);
                        @endphp
                        <div style="background:#fff;border:1px solid #dde4f5;border-radius:12px;overflow:hidden;margin-bottom:12px;box-shadow:0 2px 8px rgba(15,23,42,.06);">

                            {{-- Card top: label + status badge --}}
                            <div style="background:#f8f9fc;padding:10px 18px;display:flex;align-items:center;justify-content:space-between;border-bottom:1px solid #e9edf5;">
                                <span style="font-size:11px;font-weight:700;color:#475569;text-transform:uppercase;letter-spacing:.7px;">
                                    <i class="uil uil-shield me-1" style="color:#032671;font-size:13px;"></i>Current Policy
                                </span>
                                <div style="display:flex;align-items:center;gap:8px;">
                                    @if($cpDays !== null && $cpDays >= 0 && $cpDays <= 60)
                                    <button onclick="openPolicyModal()" style="font-size:10px;font-weight:600;background:#fff8e1;color:#92400e;border:1px solid #fde68a;padding:2px 10px;border-radius:20px;cursor:pointer;">
                                        <i class="uil uil-refresh me-1"></i>Renew
                                    </button>
                                    @endif
                                    <span style="font-size:11px;font-weight:700;padding:3px 12px;border-radius:20px;background:{{ $cpBadgeBg }};color:{{ $cpBadgeClr }};">
                                        {{ $cpBadgeLabel }}
                                    </span>
                                </div>
                            </div>

                            {{-- Main info grid --}}
                            <div style="padding:18px 18px 14px;">
                                <div style="display:grid;grid-template-columns:1.4fr 2fr 1fr 1.6fr 1.4fr;gap:0;border:1px solid #e9edf5;border-radius:8px;overflow:hidden;">

                                    {{-- Col 1: Insurer --}}
                                    <div style="padding:14px 16px;border-right:1px solid #e9edf5;background:#fafbff;">
                                        <div style="font-size:9px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.5px;margin-bottom:6px;">Insurer</div>
                                        <div style="font-size:13px;font-weight:800;color:#032671;line-height:1.2;">
                                            {{ $currentPolicy->insurer?->name ?? '—' }}
                                        </div>
                                        <div style="margin-top:6px;">
                                            <span style="font-size:10px;font-weight:600;padding:2px 8px;background:#e3ecff;color:#032671;border-radius:4px;">
                                                {{ $currentPolicy->policy_type }}
                                            </span>
                                        </div>
                                    </div>

                                    {{-- Col 2: Policy No --}}
                                    <div style="padding:14px 16px;border-right:1px solid #e9edf5;">
                                        <div style="font-size:9px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.5px;margin-bottom:6px;">Policy No.</div>
                                        <div style="font-size:12px;font-weight:600;color:#1e293b;font-family:'Courier New',monospace;word-break:break-all;line-height:1.4;">
                                            {{ $currentPolicy->policy_number ?: '—' }}
                                        </div>
                                    </div>

                                    {{-- Col 3: IDV --}}
                                    <div style="padding:14px 16px;border-right:1px solid #e9edf5;background:#fafbff;">
                                        <div style="font-size:9px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.5px;margin-bottom:6px;">IDV</div>
                                        <div style="font-size:14px;font-weight:800;color:#032671;line-height:1.2;">
                                            @if($currentPolicy->insured_value)
                                                ₹{{ number_format($currentPolicy->insured_value, 0) }}
                                            @else
                                                <span style="color:#cbd5e1;">—</span>
                                            @endif
                                        </div>
                                        @if($currentPolicy->premium_amount)
                                        <div style="font-size:10px;color:#64748b;margin-top:4px;">
                                            Premium: ₹{{ number_format($currentPolicy->premium_amount, 0) }}
                                        </div>
                                        @endif
                                    </div>

                                    {{-- Col 4: Valid Until --}}
                                    <div style="padding:14px 16px;border-right:1px solid #e9edf5;">
                                        <div style="font-size:9px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.5px;margin-bottom:6px;">Valid Until</div>
                                        <div style="font-size:14px;font-weight:800;color:{{ $cpBadgeClr }};line-height:1.2;">
                                            {{ $currentPolicy->policy_end_date ? $currentPolicy->policy_end_date->format('d M Y') : '—' }}
                                        </div>
                                        @if($cpDays !== null)
                                        <div style="font-size:11px;font-weight:600;color:{{ $cpBadgeClr }};margin-top:4px;">{{ $cpDaysLbl }}</div>
                                        @endif
                                    </div>

                                    {{-- Col 5: Start / Actions --}}
                                    <div style="padding:14px 16px;background:#fafbff;">
                                        <div style="font-size:9px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.5px;margin-bottom:6px;">Start Date</div>
                                        <div style="font-size:12px;font-weight:600;color:#475569;margin-bottom:10px;">
                                            {{ $currentPolicy->policy_start_date ? $currentPolicy->policy_start_date->format('d M Y') : '—' }}
                                        </div>
                                        <div style="display:flex;gap:5px;flex-wrap:wrap;">
                                            <button onclick="openPolicyModal({!! $cpEditArgs !!})"
                                                style="font-size:10px;padding:3px 9px;border:1px solid #e2e8f0;border-radius:5px;color:#475569;background:#fff;cursor:pointer;white-space:nowrap;">
                                                <i class="uil uil-pen me-1"></i>Edit
                                            </button>
                                            <button onclick="openClaimModal({{ $currentPolicy->id }}, {!! json_encode($currentPolicy->insurer?->name ?? '') !!}, {!! json_encode($currentPolicy->policy_number ?? '') !!})"
                                                style="font-size:10px;padding:3px 9px;border:1px solid #fca5a5;border-radius:5px;color:#dc2626;background:#fff5f5;cursor:pointer;white-space:nowrap;">
                                                <i class="uil uil-file-plus-alt me-1"></i>Raise Claim
                                            </button>
                                            @if($currentPolicy->policy_document)
                                            <a href="{{ asset('media/insurance_policies/' . $currentPolicy->policy_document) }}"
                                               target="_blank"
                                               style="font-size:10px;padding:3px 9px;border:1px solid #bfdbfe;border-radius:5px;color:#1d4ed8;background:#eff6ff;text-decoration:none;white-space:nowrap;">
                                                <i class="uil uil-file-alt me-1"></i>Doc
                                            </a>
                                            @else
                                            <button onclick="openPolicyModal({!! $cpEditArgs !!}, true)"
                                                style="font-size:10px;padding:3px 9px;border:1px solid #e2e8f0;border-radius:5px;color:#475569;background:#fff;cursor:pointer;white-space:nowrap;">
                                                <i class="uil uil-paperclip me-1"></i>Attach
                                            </button>
                                            @endif
                                        </div>
                                    </div>

                                </div>{{-- /grid --}}
                            </div>
                        </div>
                        @else
                        {{-- Empty state --}}
                        <div style="background:#fff;border:1px dashed #c7d2fe;border-radius:12px;padding:32px 18px;text-align:center;color:#94a3b8;margin-bottom:12px;">
                            <i class="uil uil-shield" style="font-size:36px;display:block;margin-bottom:10px;opacity:.35;color:#032671;"></i>
                            <div style="font-size:13px;font-weight:700;color:#475569;margin-bottom:4px;">No active policy on record</div>
                            <div style="font-size:12px;margin-bottom:16px;">Add the insurance policy for this vehicle to track expiry and file claims.</div>
                            <button class="btn btn-sm"
                                style="font-size:12px;font-weight:600;background:#032671;color:#fff;padding:6px 20px;border-radius:7px;border:none;"
                                onclick="openPolicyModal()">
                                <i class="uil uil-plus me-1"></i>Add Policy Now
                            </button>
                        </div>
                        @endif

                        {{-- Past Policies (collapsible) --}}
                        <div style="background:#fff;border:1px solid #e2e8f0;border-radius:10px;overflow:hidden;margin-bottom:20px;">
                            <button type="button"
                                style="width:100%;background:#f8f9fc;border:none;border-bottom:1px solid #e2e8f0;padding:10px 16px;display:flex;align-items:center;justify-content:space-between;cursor:pointer;"
                                data-bs-toggle="collapse" data-bs-target="#v2PastPolicies" aria-expanded="{{ $pastPolicies->count() ? 'true' : 'false' }}">
                                <span style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#64748b;">
                                    <i class="uil uil-history me-2" style="color:#94a3b8;"></i>Past Policies
                                    @if($pastPolicies->count())
                                    <span style="background:#e2e8f0;color:#475569;border-radius:8px;padding:0 7px;font-size:10px;margin-left:5px;">{{ $pastPolicies->count() }}</span>
                                    @endif
                                </span>
                                <i class="uil uil-angle-down" style="font-size:16px;color:#94a3b8;"></i>
                            </button>
                            <div class="collapse{{ $pastPolicies->count() ? ' show' : '' }}" id="v2PastPolicies">
                                @if($pastPolicies->count())
                                <table style="width:100%;border-collapse:collapse;font-size:12px;">
                                    <thead>
                                        <tr style="background:#f8f9fc;border-bottom:1px solid #e2e8f0;">
                                            <th style="padding:8px 16px;font-size:10px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.4px;">Insurer</th>
                                            <th style="padding:8px 16px;font-size:10px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.4px;">Policy No.</th>
                                            <th style="padding:8px 16px;font-size:10px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.4px;">Type</th>
                                            <th style="padding:8px 16px;font-size:10px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.4px;">Period</th>
                                            <th style="padding:8px 16px;font-size:10px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.4px;">IDV</th>
                                            <th style="padding:8px 16px;font-size:10px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.4px;">Status</th>
                                            <th style="padding:8px 16px;font-size:10px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.4px;white-space:nowrap;min-width:130px;"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pastPolicies as $pp)
                                        @php
                                            $ppSt = match($pp->status) {
                                                'Expired'   => ['bg'=>'#fee2e2','clr'=>'#b91c1c'],
                                                'Cancelled' => ['bg'=>'#f1f5f9','clr'=>'#64748b'],
                                                default     => ['bg'=>'#f1f5f9','clr'=>'#64748b'],
                                            };
                                            $ppArgs = implode(',', [
                                                $pp->id,
                                                $pp->insurancecompany_id ?? 'null',
                                                json_encode($pp->policy_number ?? ''),
                                                json_encode($pp->policy_type),
                                                json_encode($pp->insured_value ?? ''),
                                                json_encode($pp->premium_amount ?? ''),
                                                json_encode($pp->policy_start_date?->format('Y-m-d') ?? ''),
                                                json_encode($pp->policy_end_date?->format('Y-m-d') ?? ''),
                                                json_encode($pp->notes ?? ''),
                                                json_encode($pp->policy_document ?? ''),
                                                json_encode($pp->policy_document_name ?? ''),
                                            ]);
                                        @endphp
                                        <tr style="border-bottom:1px solid #f1f5f9;">
                                            <td style="padding:9px 16px;font-weight:600;color:#1e293b;">{{ $pp->insurer?->name ?? '—' }}</td>
                                            <td style="padding:9px 16px;font-family:'Courier New',monospace;font-size:11px;color:#475569;">{{ $pp->policy_number ?: '—' }}</td>
                                            <td style="padding:9px 16px;color:#475569;white-space:nowrap;">{{ $pp->policy_type }}</td>
                                            <td style="padding:9px 16px;color:#94a3b8;font-size:11px;white-space:nowrap;">
                                                {{ $pp->policy_start_date?->format('d M Y') ?? '—' }} → {{ $pp->policy_end_date?->format('d M Y') ?? '—' }}
                                            </td>
                                            <td style="padding:9px 16px;font-weight:600;color:#032671;font-size:11px;">
                                                @if($pp->insured_value) ₹{{ number_format($pp->insured_value, 0) }} @else — @endif
                                            </td>
                                            <td style="padding:9px 16px;">
                                                <span style="font-size:10px;font-weight:700;padding:2px 8px;border-radius:8px;background:{{ $ppSt['bg'] }};color:{{ $ppSt['clr'] }};">{{ $pp->status }}</span>
                                            </td>
                                            <td style="padding:9px 16px;white-space:nowrap;">
                                                <div style="display:flex;gap:5px;align-items:center;">
                                                    <button onclick="openPolicyModal({!! $ppArgs !!})"
                                                        style="width:26px;height:26px;border:1px solid #e2e8f0;border-radius:5px;background:#f8fafc;color:#64748b;cursor:pointer;font-size:13px;display:inline-flex;align-items:center;justify-content:center;"
                                                        title="Edit policy">
                                                        <i class="uil uil-pen"></i>
                                                    </button>
                                                    <button onclick="openClaimModal({{ $pp->id }}, {!! json_encode($pp->insurer?->name ?? '') !!}, {!! json_encode($pp->policy_number ?? '') !!})"
                                                        style="font-size:10px;padding:2px 9px;border:1px solid #fca5a5;border-radius:5px;color:#dc2626;background:#fff5f5;cursor:pointer;white-space:nowrap;height:26px;display:inline-flex;align-items:center;"
                                                        title="Raise claim against this policy">
                                                        <i class="uil uil-file-plus-alt me-1"></i>Raise Claim
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @else
                                <div style="padding:24px 18px;text-align:center;color:#94a3b8;">
                                    <i class="uil uil-folder-open" style="font-size:28px;display:block;margin-bottom:6px;opacity:.4;"></i>
                                    <div style="font-size:12px;font-weight:600;margin-bottom:3px;">No past policies recorded</div>
                                    <div style="font-size:11px;">Expired or cancelled policies will appear here.</div>
                                </div>
                                @endif
                            </div>
                        </div>

                        {{-- ═══════════════════════════════════════════════ --}}
                        {{-- SECTION 2 — CLAIMS (moved below policy)         --}}
                        {{-- ═══════════════════════════════════════════════ --}}

                        {{-- Section header --}}
                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;">
                            <div style="display:flex;align-items:center;gap:8px;">
                                <i class="uil uil-file-alt" style="font-size:18px;color:#032671;"></i>
                                <span style="font-size:13px;font-weight:700;color:#032671;letter-spacing:.2px;">Claims</span>
                            </div>
                            <div style="display:flex;gap:8px;align-items:center;">
                                <a href="{{ route('fleet.insurance.index') }}"
                                   style="font-size:11px;color:#032671;font-weight:600;text-decoration:none;">
                                    View all &rarr;
                                </a>
                                <button class="btn btn-sm"
                                    style="font-size:11px;font-weight:600;background:#032671;color:#fff;padding:4px 14px;border-radius:6px;border:none;"
                                    data-bs-toggle="modal"
                                    data-bs-target="#newClaimModal"
                                    onclick="prefillClaimVehicle('{{ $vehicle->vehicle_no ?? '' }}')">
                                    <i class="uil uil-plus me-1"></i>Raise Claim
                                </button>
                            </div>
                        </div>

                        {{-- Claims summary bar --}}
                        <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:10px;margin-bottom:14px;">
                            <div style="background:#fff;border:1px solid #e2e8f0;border-radius:8px;padding:12px 14px;border-left:3px solid #e65100;">
                                <div style="font-size:10px;color:#94a3b8;font-weight:700;text-transform:uppercase;letter-spacing:.4px;margin-bottom:4px;">Open Claims</div>
                                <div style="font-size:20px;font-weight:900;color:#e65100;line-height:1;">{{ $openClaims ?: '2' }}</div>
                            </div>
                            <div style="background:#fff;border:1px solid #e2e8f0;border-radius:8px;padding:12px 14px;border-left:3px solid #15803d;">
                                <div style="font-size:10px;color:#94a3b8;font-weight:700;text-transform:uppercase;letter-spacing:.4px;margin-bottom:4px;">Settled</div>
                                <div style="font-size:20px;font-weight:900;color:#15803d;line-height:1;">{{ $settledClaims ?: '1' }}</div>
                            </div>
                            <div style="background:#fff;border:1px solid #e2e8f0;border-radius:8px;padding:12px 14px;border-left:3px solid #032671;">
                                <div style="font-size:10px;color:#94a3b8;font-weight:700;text-transform:uppercase;letter-spacing:.4px;margin-bottom:4px;">Total Claimed</div>
                                <div style="font-size:14px;font-weight:800;color:#032671;line-height:1.2;">
                                    ₹{{ $totalClaimed ? number_format($totalClaimed) : '3,35,000' }}
                                </div>
                            </div>
                            <div style="background:#fff;border:1px solid #e2e8f0;border-radius:8px;padding:12px 14px;border-left:3px solid #15803d;">
                                <div style="font-size:10px;color:#94a3b8;font-weight:700;text-transform:uppercase;letter-spacing:.4px;margin-bottom:4px;">Total Received</div>
                                <div style="font-size:14px;font-weight:800;color:#15803d;line-height:1.2;">
                                    ₹{{ $totalReceived ? number_format($totalReceived) : '25,000' }}
                                </div>
                            </div>
                        </div>

                        {{-- Claims history table --}}
                        <div style="background:#fff;border:1px solid #e2e8f0;border-radius:10px;overflow:hidden;box-shadow:0 1px 6px rgba(15,23,42,.04);">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0" style="font-size:12px;">
                                    <thead>
                                        <tr style="background:#f8f9fc;border-bottom:2px solid #e2e8f0;">
                                            <th style="font-size:10px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.5px;padding:10px 14px;white-space:nowrap;">Claim #</th>
                                            <th style="font-size:10px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.5px;padding:10px 14px;">Incident</th>
                                            <th style="font-size:10px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.5px;padding:10px 14px;">Type</th>
                                            <th style="font-size:10px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.5px;padding:10px 14px;">Mode</th>
                                            <th style="font-size:10px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.5px;padding:10px 14px;">Workshop</th>
                                            <th style="font-size:10px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.5px;padding:10px 14px;text-align:right;">Claimed (₹)</th>
                                            <th style="font-size:10px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.5px;padding:10px 14px;text-align:right;">Received (₹)</th>
                                            <th style="font-size:10px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.5px;padding:10px 14px;">Status</th>
                                            <th style="font-size:10px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.5px;padding:10px 14px;text-align:center;"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        /* ── Inline sample claims — replace with $vClaims->sortByDesc() once model is wired ── */
                                        $sampleClaims = [
                                            [
                                                'id'         => 1,
                                                'ref'        => 'CLM-2024-0048',
                                                'date'       => '08 Dec 2024',
                                                'type'       => 'Own Damage',
                                                'type_clr'   => ['bg'=>'#e3ecff','clr'=>'#032671'],
                                                'mode'       => 'Reimbursement',
                                                'mode_clr'   => ['bg'=>'#f0fdf4','clr'=>'#15803d'],
                                                'workshop'   => 'SC-HYD', 'ws_own'=>true,
                                                'claimed'    => 240000, 'received'  => null,
                                                'status'     => 'Survey in Progress',
                                                'status_clr' => ['bg'=>'#fff3e0','clr'=>'#c2410c'],
                                            ],
                                            [
                                                'id'         => 2,
                                                'ref'        => 'CLM-2023-0031',
                                                'date'       => '14 Jul 2023',
                                                'type'       => 'Own Damage',
                                                'type_clr'   => ['bg'=>'#e3ecff','clr'=>'#032671'],
                                                'mode'       => 'Cashless',
                                                'mode_clr'   => ['bg'=>'#ede9fe','clr'=>'#6d28d9'],
                                                'workshop'   => 'Tata SC, Kurnool', 'ws_own'=>false,
                                                'claimed'    => 95000, 'received' => 25000,
                                                'status'     => 'Settled',
                                                'status_clr' => ['bg'=>'#dcfce7','clr'=>'#15803d'],
                                            ],
                                            [
                                                'id'         => 3,
                                                'ref'        => 'CLM-2022-0017',
                                                'date'       => '02 Mar 2022',
                                                'type'       => 'Third Party',
                                                'type_clr'   => ['bg'=>'#fef3c7','clr'=>'#92400e'],
                                                'mode'       => 'Reimbursement',
                                                'mode_clr'   => ['bg'=>'#f0fdf4','clr'=>'#15803d'],
                                                'workshop'   => 'SC-HYD', 'ws_own'=>true,
                                                'claimed'    => 180000, 'received' => 155000,
                                                'status'     => 'Settled',
                                                'status_clr' => ['bg'=>'#dcfce7','clr'=>'#15803d'],
                                            ],
                                        ];
                                        @endphp
                                        @foreach($sampleClaims as $clm)
                                        <tr style="border-bottom:1px solid #f1f5f9;">
                                            <td style="padding:10px 14px;vertical-align:middle;">
                                                <a href="{{ route('fleet.insurance.detail', $clm['id']) }}"
                                                   style="font-weight:700;color:#032671;font-size:11px;font-family:monospace;text-decoration:none;letter-spacing:.3px;">
                                                    {{ $clm['ref'] }}
                                                </a>
                                            </td>
                                            <td style="padding:10px 14px;vertical-align:middle;color:#475569;white-space:nowrap;">{{ $clm['date'] }}</td>
                                            <td style="padding:10px 14px;vertical-align:middle;">
                                                <span style="background:{{ $clm['type_clr']['bg'] }};color:{{ $clm['type_clr']['clr'] }};font-size:10px;font-weight:700;padding:2px 8px;border-radius:10px;white-space:nowrap;">
                                                    {{ $clm['type'] }}
                                                </span>
                                            </td>
                                            <td style="padding:10px 14px;vertical-align:middle;">
                                                <span style="background:{{ $clm['mode_clr']['bg'] }};color:{{ $clm['mode_clr']['clr'] }};font-size:10px;font-weight:700;padding:2px 8px;border-radius:10px;white-space:nowrap;">
                                                    {{ $clm['mode'] }}
                                                </span>
                                            </td>
                                            <td style="padding:10px 14px;vertical-align:middle;">
                                                <div style="display:flex;align-items:center;gap:5px;">
                                                    <i class="uil {{ $clm['ws_own'] ? 'uil-home-alt' : 'uil-store' }}"
                                                       style="font-size:12px;color:{{ $clm['ws_own'] ? '#032671' : '#e65100' }};flex-shrink:0;"></i>
                                                    <span style="font-size:12px;color:#475569;">{{ $clm['workshop'] }}</span>
                                                </div>
                                                @if(!$clm['ws_own'])
                                                <div style="font-size:10px;color:#94a3b8;padding-left:17px;">External</div>
                                                @endif
                                            </td>
                                            <td style="padding:10px 14px;vertical-align:middle;text-align:right;font-weight:700;color:#032671;font-size:12px;">
                                                ₹{{ number_format($clm['claimed']) }}
                                            </td>
                                            <td style="padding:10px 14px;vertical-align:middle;text-align:right;font-size:12px;">
                                                @if($clm['received'] !== null)
                                                    <span style="font-weight:700;color:#15803d;">₹{{ number_format($clm['received']) }}</span>
                                                    @if($clm['mode'] === 'Cashless')
                                                    <div style="font-size:10px;color:#94a3b8;">Excess paid</div>
                                                    @endif
                                                @else
                                                    <span style="color:#cbd5e1;">—</span>
                                                @endif
                                            </td>
                                            <td style="padding:10px 14px;vertical-align:middle;">
                                                <span style="background:{{ $clm['status_clr']['bg'] }};color:{{ $clm['status_clr']['clr'] }};font-size:10px;font-weight:700;padding:3px 9px;border-radius:10px;white-space:nowrap;">
                                                    {{ $clm['status'] }}
                                                </span>
                                            </td>
                                            <td style="padding:10px 14px;vertical-align:middle;text-align:center;">
                                                <a href="{{ route('fleet.insurance.detail', $clm['id']) }}"
                                                   style="font-size:11px;color:#032671;text-decoration:none;font-weight:600;">
                                                    <i class="uil uil-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="9" style="padding:12px 14px;text-align:center;color:#94a3b8;font-size:11px;background:#fafbfc;border:0;">
                                                <i class="uil uil-info-circle me-1"></i>
                                                Showing last {{ count($sampleClaims) }} claims for this vehicle.
                                                <a href="{{ route('fleet.insurance.index') }}" style="color:#032671;font-weight:600;">View all claims &rarr;</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        </div>
                    </div>
                    {{-- ═══ END INSURANCE TAB ═══ --}}

                    {{-- ── Insurance Policy Modal (Add + Edit) ── --}}
                    <div class="modal fade" id="addPolicyModal" tabindex="-1" aria-labelledby="addPolicyModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width:640px;">
                            <div class="modal-content" style="border-radius:12px;border:none;box-shadow:0 20px 60px rgba(15,23,42,.18);overflow:hidden;">

                                {{-- Header with vehicle context --}}
                                <div class="modal-header" style="background:#032671;padding:14px 20px;border:none;flex-shrink:0;">
                                    <div style="display:flex;align-items:center;gap:10px;flex:1;min-width:0;">
                                        <i class="uil uil-shield-plus" style="color:#93c5fd;font-size:20px;flex-shrink:0;"></i>
                                        <div style="min-width:0;">
                                            <h6 class="modal-title mb-0" id="policyModalTitle"
                                                style="color:#fff;font-weight:700;font-size:14px;">Add Insurance Policy</h6>
                                            <div style="font-size:11px;color:#93c5fd;margin-top:1px;">
                                                <i class="uil uil-truck me-1"></i>
                                                <span style="font-weight:600;">{{ $vehicle->vehicle_no ?? '' }}</span>
                                                @if($vehicle->vehicletype?->name)
                                                <span style="opacity:.7;margin-left:5px;">· {{ $vehicle->vehicletype->name }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn-close btn-close-white btn-sm ms-3" data-bs-dismiss="modal"></button>
                                </div>

                                <form id="policyForm" novalidate enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" id="pol_id" name="pol_id" value="">
                                <input type="hidden" name="vehicle_id" value="{{ $vehicle->basicinfo->id ?? '' }}">

                                {{-- Scrollable body --}}
                                <div class="modal-body" style="padding:20px 20px 8px;">

                                    {{-- Section: Coverage --}}
                                    <div class="pol-section-head">Coverage</div>
                                    <div class="row g-3 mb-1">
                                        <div class="col-md-7">
                                            <label class="pol-label">Insurance Company</label>
                                            <select id="pol_insurancecompany_id" name="insurancecompany_id" class="form-select form-select-sm">
                                                <option value="">— Select Insurer —</option>
                                                @foreach($insurers as $ins)
                                                <option value="{{ $ins->id }}">{{ $ins->name }}</option>
                                                @endforeach
                                            </select>
                                            <div class="pol-err" id="pol_insurancecompany_id_error"></div>
                                        </div>
                                        <div class="col-md-5">
                                            <label class="pol-label">Policy Type <span style="color:#dc2626;">*</span></label>
                                            <select id="pol_policy_type" name="policy_type" class="form-select form-select-sm" required
                                                    onchange="updatePolicyTypeHint(this.value)">
                                                <option value="Comprehensive">Comprehensive</option>
                                                <option value="Third Party">Third Party</option>
                                                <option value="Zero Dep">Zero Dep</option>
                                                <option value="Commercial">Commercial</option>
                                            </select>
                                            <div id="pol_type_hint" style="font-size:10px;color:#4f7ec4;margin-top:4px;min-height:14px;font-style:italic;"></div>
                                            <div class="pol-err" id="pol_policy_type_error"></div>
                                        </div>
                                        <div class="col-12">
                                            <label class="pol-label">Policy Number</label>
                                            <input type="text" id="pol_policy_number" name="policy_number"
                                                   class="form-control form-control-sm"
                                                   style="font-family:'Courier New',monospace;font-size:13px;letter-spacing:.4px;"
                                                   placeholder="e.g. ICICILOM/CV/2025/TS09AB1234" maxlength="100">
                                            <div class="pol-err" id="pol_policy_number_error"></div>
                                        </div>
                                    </div>

                                    {{-- Section: Validity & Financials --}}
                                    <div class="pol-section-head" style="margin-top:16px;">Validity &amp; Financials</div>
                                    <div class="row g-3 mb-1">
                                        <div class="col-6 col-md-3">
                                            <label class="pol-label">Start Date</label>
                                            <input type="date" id="pol_policy_start_date" name="policy_start_date" class="form-control form-control-sm">
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <label class="pol-label">Expiry Date</label>
                                            <input type="date" id="pol_policy_end_date" name="policy_end_date" class="form-control form-control-sm">
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <label class="pol-label">IDV (₹)</label>
                                            <input type="number" id="pol_insured_value" name="insured_value"
                                                   class="form-control form-control-sm" placeholder="e.g. 2850000" min="0" step="1">
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <label class="pol-label">Premium (₹)</label>
                                            <input type="number" id="pol_premium_amount" name="premium_amount"
                                                   class="form-control form-control-sm" placeholder="e.g. 45000" min="0" step="1">
                                        </div>
                                    </div>

                                    {{-- Section: Notes & Document --}}
                                    <div class="pol-section-head" style="margin-top:16px;">Notes &amp; Document</div>
                                    <div class="row g-3 mb-3">
                                        <div class="col-md-6">
                                            <label class="pol-label"><i class="uil uil-notes me-1" style="color:#032671;"></i>Notes / Add-ons</label>
                                            <textarea id="pol_notes" name="notes" class="form-control form-control-sm" rows="3"
                                                      placeholder="Zero Dep rider, Engine Protect, Roadside Assistance, PA Cover, NCB protect…"
                                                      maxlength="1000"></textarea>
                                            <div style="font-size:10px;color:#94a3b8;margin-top:3px;">Add-ons, riders, or any policy notes</div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="pol-label"><i class="uil uil-paperclip me-1" style="color:#032671;"></i>Policy Document</label>
                                            <input type="file" id="pol_document" name="policy_document"
                                                   class="form-control form-control-sm" accept=".pdf,.jpg,.jpeg,.png">
                                            <div style="font-size:10px;color:#94a3b8;margin-top:3px;">PDF, JPG or PNG · max 5 MB</div>
                                            <div id="pol_current_doc_wrap" class="d-none mt-2"
                                                 style="display:flex;align-items:center;gap:8px;background:#f1f5f9;padding:7px 10px;border-radius:6px;font-size:12px;">
                                                <i class="uil uil-file-alt" style="color:#032671;font-size:16px;flex-shrink:0;"></i>
                                                <a id="pol_current_doc_link" href="#" target="_blank"
                                                   style="color:#032671;font-weight:600;text-decoration:none;flex:1;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">document.pdf</a>
                                                <button type="button" id="pol_remove_doc_btn"
                                                    style="font-size:10px;padding:2px 8px;background:#fee2e2;color:#dc2626;border:1px solid #fca5a5;border-radius:4px;flex-shrink:0;cursor:pointer;">
                                                    <i class="uil uil-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                {{-- Footer --}}
                                <div class="modal-footer" style="padding:12px 20px;background:#f8f9fc;border:none;border-top:1px solid #e9edf5;flex-shrink:0;">
                                    <button type="button" class="btn btn-sm"
                                        style="font-size:12px;color:#64748b;background:#e2e8f0;border:none;padding:6px 16px;border-radius:6px;"
                                        data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" id="policySubmitBtn" class="btn btn-sm"
                                        style="font-size:12px;font-weight:600;background:#032671;color:#fff;border:none;padding:6px 22px;border-radius:6px;">
                                        <span class="spinner-border spinner-border-sm d-none me-1" id="policySpinner"></span>
                                        <i class="uil uil-save me-1" id="policySubmitIcon"></i><span id="policySubmitLabel">Save Policy</span>
                                    </button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <style>
                    .pol-label        { font-size:11px;font-weight:700;color:#5a6a85;text-transform:uppercase;letter-spacing:.4px;margin-bottom:4px;display:block; }
                    .pol-err          { font-size:11px;color:#dc2626;margin-top:3px;min-height:0; }
                    .pol-section-head { font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;color:#94a3b8;
                                        border-top:1px solid #f1f5f9;padding-top:14px;margin-bottom:10px; }
                    .pol-section-head:first-child { border-top:none;padding-top:0; }
                    </style>

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
                        <input type="text" id="claimInsurerField" name="insurer_name" class="form-control form-control-sm" placeholder="e.g. ICICI Lombard, New India…">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" style="font-size:12px;font-weight:600;">Policy Number</label>
                        <input type="text" id="claimPolicyNoField" name="policy_number" class="form-control form-control-sm" placeholder="Policy number">
                        <input type="hidden" id="claimPolicyIdField" name="insurance_policy_id">
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
    </div>{{-- end vehicledtl-bd --}}
    </div>{{-- end srlog-bdwrapper --}}
</div>{{-- end layout-wrapper --}}

@endsection

@section('js')

<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>
<script type="text/javascript" src="{{ asset('js/Fleet/vehicle-details.js?v=1.0') }}"></script>
<script type="text/javascript" src="{{ asset('js/Fleet/html-related-scripts.js?v=1.0') }}"></script>

<script>

    var DRIVER_DATA = "{{ route('fleetdashboard.getDriverData', ':id') }}"; 
    
    var EDIT_GPS = "{{ route('fleetdashboard.editGpsDetail', ':id') }}";
    var EDIT_FASTTAG = "{{ route('fleetdashboard.editFasttagDetail', ':id') }}";
    
    var EDIT_TYRE = "{{ route('fleetdashboard.editTyreDetail', ':id') }}";
    var DELETE_TYRE = "{{ route('fleetdashboard.deleteTyre') }}";
    
    var EDIT_BATTERY = "{{ route('fleetdashboard.editBatteryDetail', ':id') }}";
    var DELETE_BATTERY = "{{ route('fleetdashboard.deleteBattery') }}";
    
    var EDIT_DIGITAL_LOCK = "{{ route('fleetdashboard.editDigiLockDetail', ':id') }}";
    var DELETE_DIGITAL_LOCK = "{{ route('fleetdashboard.deleteDigiLock') }}";
    
    
    var EDIT_FINANCE = "{{ route('vehicleemi.edit', ':id') }}";
    var VIEW_FINANCE_NOTES = "{{ route('vehicleemi.finance.note.show', ':id') }}";

    /* ── Policy section — chevron rotation for past policies collapse ── */
    document.addEventListener('DOMContentLoaded', function () {
        var pastPoliciesBtn = document.querySelector('[data-bs-target="#v2PastPolicies"]');
        if (pastPoliciesBtn) {
            pastPoliciesBtn.addEventListener('click', function () {
                var chevron = document.getElementById('v2PastPoliciesChevron');
                if (!chevron) return;
                var expanded = this.getAttribute('aria-expanded') === 'true';
                chevron.style.transform = expanded ? '' : 'rotate(180deg)';
            });
        }
    });

    /* ── Policy type hint descriptions ── */
    var _policyTypeHints = {
        'Comprehensive':   '🛡️ Covers own damage + third-party liability + theft.',
        'Third Party':     '⚠️ Covers third-party liability only. Mandatory by law.',
        'Zero Dep':        '✅ Comprehensive with zero depreciation — full claim on parts.',
        'Commercial':      '🚛 Tailored for commercial/goods-carrying vehicles.',
        '':                ''
    };
    function updatePolicyTypeHint(val) {
        var hint = document.getElementById('pol_type_hint');
        if (hint) hint.textContent = _policyTypeHints[val] || '';
    }

    /* ── Open policy modal (add or edit) ── */
    function openPolicyModal(id, insurancecompany_id, policy_number, policy_type, insured_value, premium_amount, start_date, end_date, notes, doc_file, doc_name, focusDoc) {
        var isEdit = !!id;
        document.getElementById('policyModalTitle').innerHTML = isEdit
            ? '<i class="uil uil-pen me-2"></i>Edit Insurance Policy'
            : '<i class="uil uil-shield-plus me-2"></i>Add Insurance Policy';
        document.getElementById('policySubmitLabel').textContent = isEdit ? 'Update Policy' : 'Save Policy';
        document.getElementById('pol_id').value                = id || '';
        document.getElementById('pol_policy_number').value     = policy_number || '';
        document.getElementById('pol_policy_start_date').value = start_date || '';
        document.getElementById('pol_policy_end_date').value   = end_date || '';
        document.getElementById('pol_insured_value').value     = insured_value || '';
        document.getElementById('pol_premium_amount').value    = premium_amount || '';
        document.getElementById('pol_notes').value             = notes || '';
        document.getElementById('pol_document').value          = '';
        if (policy_type) document.getElementById('pol_policy_type').value = policy_type;
        updatePolicyTypeHint(document.getElementById('pol_policy_type').value);
        if (insurancecompany_id) $('#pol_insurancecompany_id').val(insurancecompany_id).trigger('change');
        else            $('#pol_insurancecompany_id').val('').trigger('change');

        /* Show current document if exists */
        var docWrap = document.getElementById('pol_current_doc_wrap');
        var docLink = document.getElementById('pol_current_doc_link');
        if (doc_file) {
            docLink.href = '/media/insurance_policies/' + doc_file;
            docLink.textContent = doc_name || doc_file;
            docWrap.classList.remove('d-none');
        } else {
            docWrap.classList.add('d-none');
        }

        /* Remove doc button */
        document.getElementById('pol_remove_doc_btn').onclick = function() {
            if (!id) return;
            fetch('{{ route("fleet.vehicle-insurance.index") }}/' + id + '/document', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json',
                           'Content-Type': 'application/x-www-form-urlencoded' },
                body: '_method=DELETE'
            }).then(function(r){ return r.json(); }).then(function(d){
                if (d.success) { docWrap.classList.add('d-none'); }
            });
        };

        /* clear errors */
        document.querySelectorAll('#policyForm .text-danger').forEach(function(el){ el.textContent=''; });
        document.querySelectorAll('#policyForm .is-invalid').forEach(function(el){ el.classList.remove('is-invalid'); });
        bootstrap.Modal.getOrCreateInstance(document.getElementById('addPolicyModal')).show();
        if (focusDoc) {
            setTimeout(function(){ document.getElementById('pol_document').focus(); }, 400);
        }
    }

    /* ── Submit policy form (add or edit) ── */
    document.getElementById('policyForm').addEventListener('submit', function(e) {
        e.preventDefault();
        var id  = document.getElementById('pol_id').value;
        var btn = document.getElementById('policySubmitBtn');
        var sp  = document.getElementById('policySpinner');
        var ic  = document.getElementById('policySubmitIcon');
        btn.disabled = true; sp.classList.remove('d-none'); ic.classList.add('d-none');

        var base = '{{ route("fleet.vehicle-insurance.index") }}';
        var url  = id ? (base + '/' + id) : base;
        var fd   = new FormData(this);
        if (id) { fd.set('_method', 'PUT'); }

        fetch(url, {
            method : 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
            body   : fd,
        })
        .then(function(r){ return r.json(); })
        .then(function(d) {
            if (d.success) {
                bootstrap.Modal.getInstance(document.getElementById('addPolicyModal')).hide();
                Swal.fire({ icon:'success', title: id ? 'Policy Updated' : 'Policy Saved',
                    text: d.message, timer: 2000, showConfirmButton: false });
                setTimeout(function(){ location.reload(); }, 1800);
            } else if (d.errors) {
                Object.entries(d.errors).forEach(function(entry){
                    var el = document.getElementById('pol_' + entry[0] + '_error');
                    if (el) el.textContent = Array.isArray(entry[1]) ? entry[1][0] : entry[1];
                });
            } else {
                Swal.fire({ icon:'error', title:'Error', text: d.message || 'An error occurred.', confirmButtonColor:'#032671' });
            }
        })
        .catch(function(){ Swal.fire({ icon:'error', title:'Server Error', text:'Please try again.', confirmButtonColor:'#032671' }); })
        .finally(function(){ btn.disabled = false; sp.classList.add('d-none'); ic.classList.remove('d-none'); });
    });

    /* ── Select2 for policy insurer ── */
    $(document).ready(function() {
        $('#pol_insurancecompany_id').select2({ dropdownParent: $('#addPolicyModal'), width: '100%', placeholder: '— Select Insurer —', allowClear: true });
    });

    /* ── Pre-fill vehicle in New Claim modal ── */
    function prefillClaimVehicle(vehicleNo) {
        if (!vehicleNo) return;
        $('#claimVehicleSelect option').each(function () {
            if ($(this).val() && $(this).text().indexOf(vehicleNo) !== -1) {
                $('#claimVehicleSelect').val($(this).val());
                return false;
            }
        });
    }

    /* ── Open Raise Claim modal pre-filled with a specific policy ── */
    function openClaimModal(policyId, insurerName, policyNo) {
        /* Clear previous policy context */
        var banner = document.getElementById('claimPolicyBanner');
        if (banner) banner.remove();

        /* Pre-fill insurer + policy fields */
        var insFld = document.getElementById('claimInsurerField');
        var polFld = document.getElementById('claimPolicyNoField');
        var polId  = document.getElementById('claimPolicyIdField');
        if (insFld) insFld.value = insurerName || '';
        if (polFld) polFld.value = policyNo    || '';
        if (polId)  polId.value  = policyId    || '';

        /* Show a context banner in the modal body if policy info present */
        if (insurerName || policyNo) {
            var modalBody = document.querySelector('#newClaimModal .modal-body');
            if (modalBody) {
                var div = document.createElement('div');
                div.id = 'claimPolicyBanner';
                div.style.cssText = 'background:#eef2ff;border:1px solid #c7d2fe;border-radius:7px;padding:8px 14px;margin-bottom:4px;display:flex;align-items:center;gap:10px;font-size:12px;';
                div.innerHTML = '<i class="uil uil-shield-check" style="color:#032671;font-size:16px;flex-shrink:0;"></i>'
                    + '<div><span style="font-weight:700;color:#032671;">Claiming against policy:</span> '
                    + '<span style="color:#1e293b;">' + (insurerName || '—') + '</span>'
                    + (policyNo ? ' &nbsp;·&nbsp; <span style="font-family:monospace;font-size:11px;color:#475569;">' + policyNo + '</span>' : '')
                    + '</div>';
                modalBody.insertBefore(div, modalBody.firstChild);
            }
        }

        bootstrap.Modal.getOrCreateInstance(document.getElementById('newClaimModal')).show();
    }

    /* ── New Claim modal: settlement mode toggle ── */
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

    /* ── Workshop type filter (called by radio onchange) ── */
    function vdFilterWorkshopvd(type) {
        $('#vdWorkshopSelect').val('').trigger('change');
        $('#vdScContactWrap, #vdScPhoneWrap, #vdScCityWrap').hide();
        $('#vdWorkshopSelect option[data-ownership]').each(function () {
            $(this).prop('disabled', $(this).data('ownership') !== type);
        });
        if (type === 'External' && $('input[name="vdSettlementMode"]:checked').val() === 'cashless') {
            $('#vdCashlessScClaimRef').show();
        } else {
            $('#vdCashlessScClaimRef').hide();
        }
    }

    /* ── Reset modal on open ── */
    $('#newClaimModal').on('show.bs.modal', function () {
        $('input[name="vdSettlementMode"][value="reimbursement"]').prop('checked', true);
        $('input[name="vdWorkshopType"][value="Own"]').prop('checked', true);
        $('#vdCashlessExcessField, #vdCashlessScClaimRef').hide();
        $('#vdReimburseCostField').show();
        vdFilterWorkshopvd('Own');
    });

    /* ── Clean up policy banner when modal is closed ── */
    $('#newClaimModal').on('hidden.bs.modal', function () {
        var banner = document.getElementById('claimPolicyBanner');
        if (banner) banner.remove();
        var insFld = document.getElementById('claimInsurerField');
        var polFld = document.getElementById('claimPolicyNoField');
        var polId  = document.getElementById('claimPolicyIdField');
        if (insFld) insFld.value = '';
        if (polFld) polFld.value = '';
        if (polId)  polId.value  = '';
    });

    /* ── Workshop auto-fill contact info ── */
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