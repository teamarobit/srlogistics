@extends('layouts.app')

@section('css')
<link href="{{ asset('css/Fleet/driver-details.css?v=1.0') }}" rel="stylesheet">
@endsection

@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="vehicledtl-bd srlog-bdwrapper">

        {{-- ── Breadcrumb ─────────────────────────────── --}}
        <div class="drv-breadcrumb">
            <a href="{{ route('fleetdashboard.index') }}">Fleet</a>
            <i class="uil uil-angle-right"></i>
            <a href="{{ route('fleetdashboard.drivers') }}">Drivers</a>
            <i class="uil uil-angle-right"></i>
            <span>{{ $contact->contact_name ?? 'Driver Details' }}</span>
        </div>

        @php
            /* ── Driver data helpers ── */
            $driverinfo  = $contact->driverinfo;
            $name        = $contact->contact_name ?? 'Driver';
            $phone       = '+' . ($contact->ph_prefix ?? '91') . ' ' . ($contact->phone ?? '');
            $photo       = $contact->photo ?? null;
            $nameParts   = explode(' ', $name);
            $initials    = strtoupper(substr($nameParts[0],0,1) . (isset($nameParts[1]) ? substr($nameParts[1],0,1) : ''));

            /* ── Current vehicle ── */
            $currentAlloc = $contact->currentVehicleAllocation;
            $currentVehicle = $currentAlloc?->vehicle;

            /* ── Licence expiry ── */
            $licExp  = $driverinfo?->licence_expiry_date;
            $licDays = $licExp ? (int) now()->diffInDays(\Carbon\Carbon::parse($licExp), false) : null;
            $licLabel = $licExp
                ? ($licDays < 0 ? 'Expired' : ($licDays <= 30 ? 'Expiring' : 'Valid'))
                : 'Not Set';

            /* ── RAG ── */
            $rag = $contact->rag_status ?? '';
            $ragBadgeClass = match($rag) { 'Red' => 'rag red', 'Yellow' => 'rag yellow', default => 'rag' };

            /* ── Driver status ── */
            $drvStatus = $contact->status ?? 'Unknown';
            $statusBadgeClass = match($drvStatus) {
                'Active'      => 'status',
                'Inactive'    => 'status inactive',
                'Blacklisted' => 'status blacklisted',
                default       => 'status inactive',
            };

            /* ── Allocation history ── */
            $allAllocations = $contact->vehicleallocations ?? collect();
        @endphp

        {{-- ── Identity Bar ─────────────────────────── --}}
        <div class="drv-id-bar">

            {{-- Avatar --}}
            <div class="drv-id-avatar">
                @if($photo)
                    <img src="{{ asset('medias/contacts/' . $photo) }}" alt="{{ $name }}">
                @else
                    {{ $initials }}
                @endif
            </div>

            {{-- Name + phone + vehicle chip --}}
            <div class="drv-id-main">
                <div class="drv-id-name">{{ $name }}</div>
                <div class="drv-id-sub">{{ $phone }}</div>
                @if($currentVehicle)
                <div class="drv-id-vehicle">
                    <i class="uil uil-truck" style="font-size:14px;color:#032671;"></i>
                    <div>
                        <span>Current Vehicle</span>
                        <p>
                            <a href="{{ route('fleetdashboard.getVehicleDetailsV2', $currentVehicle->id) }}"
                               style="color:#032671;font-family:monospace;text-decoration:none;font-size:13px;font-weight:700;">
                                {{ $currentVehicle->vehicle_no }}
                            </a>
                        </p>
                    </div>
                </div>
                @else
                <div class="drv-id-vehicle" style="border-color:#94a3b8;background:#f8fafc;">
                    <i class="uil uil-truck" style="font-size:14px;color:#94a3b8;"></i>
                    <div>
                        <span style="color:#94a3b8;">Current Vehicle</span>
                        <p style="color:#94a3b8;font-size:12px;">Not Allocated</p>
                    </div>
                </div>
                @endif
            </div>

            {{-- Status badges --}}
            <div class="drv-id-badges">
                {{-- Licence --}}
                <div class="drv-badge lic">
                    <div class="dbadge-icon"><i class="uil uil-id-card" style="color:#DEBE0B;font-size:15px;"></i></div>
                    <div>
                        <span class="dbadge-lbl">Driving Licence</span>
                        <p class="dbadge-val">{{ $licLabel }}</p>
                    </div>
                </div>

                {{-- RAG --}}
                <div class="drv-badge {{ $ragBadgeClass }}">
                    <div class="dbadge-icon">
                        @php
                            $ragIcon = match($rag) { 'Red' => 'uil-times-circle', 'Yellow' => 'uil-exclamation-triangle', default => 'uil-check-circle' };
                            $ragIconClr = match($rag) { 'Red' => '#E5393F', 'Yellow' => '#E59E04', default => '#52D713' };
                        @endphp
                        <i class="uil {{ $ragIcon }}" style="color:{{ $ragIconClr }};font-size:15px;"></i>
                    </div>
                    <div>
                        <span class="dbadge-lbl">RAG Status</span>
                        <p class="dbadge-val">{{ $rag ?: '—' }}</p>
                    </div>
                </div>

                {{-- Driver status --}}
                <div class="drv-badge {{ $statusBadgeClass }}">
                    <div class="dbadge-icon"><i class="uil uil-user-check" style="color:#3355FF;font-size:15px;"></i></div>
                    <div>
                        <span class="dbadge-lbl">Driver Status</span>
                        <p class="dbadge-val">{{ $drvStatus }}</p>
                    </div>
                </div>

                {{-- Action buttons --}}
                <div style="display:flex;flex-direction:column;gap:6px;margin-left:8px;">
                    <a href="{{ route('contact.driver.edit', $contact->id) }}"
                       class="btn btn-sm"
                       style="font-size:11px;background:#f1f5f9;color:#475569;border:1px solid #e2e8f0;padding:4px 12px;border-radius:6px;">
                        <i class="uil uil-pen me-1"></i>Edit
                    </a>
                    <a href="{{ route('contact.driver.joining.letter', $contact->id) }}" target="_blank"
                       class="btn btn-sm"
                       style="font-size:11px;background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;padding:4px 12px;border-radius:6px;">
                        <i class="uil uil-file-check-alt me-1"></i>Joining Letter
                    </a>
                </div>
            </div>
        </div>

        <div class="vehicleinfo-wrap">

            {{-- ── Driver Information ────────────────── --}}
            <div class="vehicleinfo-sec">
                <div class="container-fluid">

                    <div class="item_info">
                        <span class="titletext">Driver Information</span>
                        <div>
                            <a href="{{ route('contact.driver.edit', $contact->id) }}" class="me-2" title="Edit">
                                <i class="uil uil-pen"></i>
                            </a>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>
                                        <p>Address</p>
                                        <span class="text-secondary d-block">{{ $contact->address ?? '—' }}</span>
                                    </td>
                                    <td>
                                        <p>Emergency Contact</p>
                                        @php $emer = $contact->relcontacts->first() ?? null; @endphp
                                        <span class="text-secondary d-block">
                                            @if($emer)
                                                {{ $emer->name ?? '' }}
                                                @if($emer->relationship) ({{ $emer->relationship }}) @endif<br>
                                                {{ $emer->phone ?? '' }}
                                                @if($emer->blood_group) · {{ $emer->blood_group }} @endif
                                            @else
                                                —
                                            @endif
                                        </span>
                                    </td>
                                    <td>
                                        <p>Guarantor Name</p>
                                        <span class="text-secondary d-block">{{ $driverinfo?->guarantor_name ?? '—' }}</span>
                                    </td>
                                    <td>
                                        <p>Guarantor Number</p>
                                        <span class="text-secondary d-block">
                                            @if($driverinfo?->guarantor_phone)
                                                +{{ $driverinfo->guarantor_phone_code ?? '91' }} {{ $driverinfo->guarantor_phone }}
                                            @else
                                                —
                                            @endif
                                        </span>
                                    </td>
                                    <td>
                                        <p>Hisab Category</p>
                                        <span class="text-secondary d-block">{{ $driverinfo?->hisab_category ?? '—' }}</span>
                                    </td>
                                    <td>
                                        <p>Driver Code</p>
                                        <span class="text-secondary d-block" style="font-family:monospace;">
                                            {{ $contact->driver_code ?? 'DR-' . $contact->id }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p>Blood Group</p>
                                        <span class="text-secondary d-block">{{ $contact->blood_group ?? '—' }}</span>
                                    </td>
                                    <td>
                                        <p>Licence Issue Date</p>
                                        <span class="text-secondary d-block">
                                            {{ $driverinfo?->licence_issue_date
                                                ? \Carbon\Carbon::parse($driverinfo->licence_issue_date)->format('d-m-Y')
                                                : '—' }}
                                        </span>
                                    </td>
                                    <td>
                                        <p>Licence Expiry Date</p>
                                        <span class="{{ $licDays !== null && $licDays <= 30 ? 'text-danger' : 'text-secondary' }} d-block">
                                            {{ $driverinfo?->licence_expiry_date
                                                ? \Carbon\Carbon::parse($driverinfo->licence_expiry_date)->format('d-m-Y')
                                                : '—' }}
                                            @if($licDays !== null && $licDays <= 30 && $licDays >= 0)
                                                <small>({{ $licDays }} days)</small>
                                            @elseif($licDays !== null && $licDays < 0)
                                                <small>(Expired {{ abs($licDays) }}d ago)</small>
                                            @endif
                                        </span>
                                    </td>
                                    <td>
                                        <p>Original Licence Location</p>
                                        <span class="text-secondary d-block">{{ $driverinfo?->original_licence_location ?? '—' }}</span>
                                    </td>
                                    <td>
                                        <p>Religion</p>
                                        <span class="text-secondary d-block">—</span>
                                    </td>
                                    <td>
                                        <p>Opening Balance</p>
                                        <span class="text-secondary d-block">
                                            @if($driverinfo?->opening_balance)
                                                ₹{{ number_format($driverinfo->opening_balance) }}
                                            @else
                                                —
                                            @endif
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    {{-- Opening Balance Type --}}
                                    <td>
                                        <p>Opening Balance Type</p>
                                        <span class="text-secondary d-block">{{ $driverinfo?->opening_balance_type ?? '—' }}</span>
                                    </td>
                                    {{-- Date of Birth --}}
                                    <td>
                                        <p>Date of Birth</p>
                                        <span class="text-secondary d-block">
                                            {{ $contact->dob
                                                ? \Carbon\Carbon::parse($contact->dob)->format('d-m-Y')
                                                : '—' }}
                                        </span>
                                    </td>
                                    {{-- Age --}}
                                    <td>
                                        <p>Age</p>
                                        <span class="text-secondary d-block">
                                            {{ $contact->dob
                                                ? \Carbon\Carbon::parse($contact->dob)->age . ' Yrs'
                                                : '—' }}
                                        </span>
                                    </td>
                                    {{-- Date of Joining --}}
                                    <td>
                                        <p>Date of Joining</p>
                                        <span class="text-secondary d-block">
                                            {{ $contact->doj
                                                ? \Carbon\Carbon::parse($contact->doj)->format('d-m-Y')
                                                : '—' }}
                                        </span>
                                    </td>
                                    {{-- Experience (tenure with company from DOJ) --}}
                                    <td>
                                        <p>Experience</p>
                                        <span class="text-secondary d-block">
                                            @if($contact->doj)
                                                @php
                                                    $dojC = new DateTime($contact->doj);
                                                    $diffC = (new DateTime())->diff($dojC);
                                                @endphp
                                                {{ $diffC->y }} Yrs {{ $diffC->m }} Month
                                            @else
                                                —
                                            @endif
                                        </span>
                                    </td>
                                    {{-- Previous Working (most recent work experience) --}}
                                    <td>
                                        <p>Previous Working</p>
                                        @php
                                            $prevWork = $contact->workExperiences
                                                ->sortByDesc('employment_end_date')
                                                ->first();
                                        @endphp
                                        <span class="text-secondary d-block">
                                            {{ $prevWork?->previous_company_name ?? '—' }}
                                        </span>
                                    </td>
                                </tr>
                                {{-- Row 4: Exit Reason (only if set) --}}
                                @if($driverinfo?->exit_reason)
                                <tr>
                                    <td>
                                        <p>Exit Reason</p>
                                        <span class="text-secondary d-block">{{ $driverinfo->exit_reason }}</span>
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    {{-- Proof of Identity --}}
                    <div class="important_df">
                        <span class="sec_title">Proof Of Identity</span>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>
                                        <p>Driving Licence No.</p>
                                        <span class="text-secondary d-block" style="font-family:monospace;">
                                            {{ $driverinfo?->driving_licence_no ?? '—' }}
                                        </span>
                                    </td>
                                    <td>
                                        <p>Driving Licence Proof</p>
                                        <span class="text-secondary d-block">
                                            @if($driverinfo?->driving_license_proof_file)
                                                <a href="{{ asset('medias/contact/' . $driverinfo->driving_license_proof_file) }}"
                                                   target="_blank" style="color:#032671;">
                                                    <i class="uil uil-paperclip me-1"></i>View
                                                </a>
                                            @else
                                                —
                                            @endif
                                        </span>
                                    </td>
                                    <td>
                                        <p>Signed Driver Form</p>
                                        <span class="text-secondary d-block">
                                            @if($driverinfo?->signed_driver_form_file)
                                                <a href="{{ asset('medias/contact/' . $driverinfo->signed_driver_form_file) }}"
                                                   target="_blank" style="color:#032671;">
                                                    <i class="uil uil-paperclip me-1"></i>View
                                                </a>
                                            @else
                                                —
                                            @endif
                                        </span>
                                    </td>
                                    <td>
                                        <p>Aadhaar Number</p>
                                        <span class="text-secondary d-block" style="font-family:monospace;">
                                            @if($driverinfo?->aadhaar_no)
                                                {{ substr($driverinfo->aadhaar_no, 0, 4) }}-****-{{ substr($driverinfo->aadhaar_no, -4) }}
                                            @else
                                                —
                                            @endif
                                        </span>
                                    </td>
                                    <td>
                                        <p>Aadhaar Card Proof</p>
                                        <span class="text-secondary d-block">
                                            @if($driverinfo?->aadhaar_card_proof_file)
                                                <a href="{{ asset('medias/contact/' . $driverinfo->aadhaar_card_proof_file) }}"
                                                   target="_blank" style="color:#032671;">
                                                    <i class="uil uil-paperclip me-1"></i>View
                                                </a>
                                            @else
                                                —
                                            @endif
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

            {{-- ── Tabs ─────────────────────────────── --}}
            <div class="vehicle-itemtab" style="margin: 12px 0 0 0; padding: 0;">
                <div class="container-fluid">

                    <ul class="nav nav-tabs item-box">
                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#drvTrip">
                                <span class="icon"><img src="{{ asset('images/icons/trip-bookicon.png') }}" alt=""></span>
                                Trip Book
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#drvHisab">
                                <span class="icon"><img src="{{ asset('images/icons/documents-icon.png') }}" alt=""></span>
                                Hisab Book
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#drvAllotment">
                                <span class="icon"><img src="{{ asset('images/icons/fuel-bookicon.png') }}" alt=""></span>
                                Allotment
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#drvEscalation">
                                <span class="icon"><img src="{{ asset('images/icons/allotment-icon.png') }}" alt=""></span>
                                Escalation
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content mt-3">

                        {{-- ── TAB 1: Trip Book ────────────────────── --}}
                        <div class="tab-pane fade show active" id="drvTrip">

                            {{-- Revenue stats --}}
                            <div class="totalrevenue mt-3">
                                <div class="item-row">
                                    <div class="itemcol">
                                        <p>Total Revenue</p>
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <h6 style="font-size:12px;">Own Booking</h6>
                                                <span class="number c-01">₹0</span>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <h6 style="font-size:12px;">Memo Booking</h6>
                                                <span class="number c-01">₹0</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="itemcol">
                                        <p>Total Deductions</p>
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <h6 style="font-size:12px;">Own Booking</h6>
                                                <span class="number c-02">₹0</span>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <h6 style="font-size:12px;">Memo Booking</h6>
                                                <span class="number c-02">₹0</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="itemcol">
                                        <p>Total Received</p>
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <h6 style="font-size:12px;">Own Booking</h6>
                                                <span class="number c-03">₹0</span>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <h6 style="font-size:12px;">Memo Booking</h6>
                                                <span class="number c-03">₹0</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="itemcol">
                                        <p>Total Balance</p>
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <h6 style="font-size:12px;">Own Booking</h6>
                                                <span class="number c-04">₹0</span>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <h6 style="font-size:12px;">Memo Booking</h6>
                                                <span class="number c-04">₹0</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="itemcol">
                                        <p>Total Expenses</p>
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <h6 style="font-size:12px;">Own Booking</h6>
                                                <span class="number c-05">₹0</span>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <h6 style="font-size:12px;">Memo Booking</h6>
                                                <span class="number c-05">₹0</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="itemcol">
                                        <p>Total Profit/Loss</p>
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <h6 style="font-size:12px;">Own Booking</h6>
                                                <span class="number c-06">₹0</span>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <h6 style="font-size:12px;">Memo Booking</h6>
                                                <span class="number c-06">₹0</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Filter Accordion --}}
                            <div class="accordion mt-4" id="drvTripFilterAccordion">
                                <div class="accordion-item" style="border:1px solid #e2e8f0;border-radius:8px;overflow:hidden;">
                                    <h2 class="accordion-header" id="drvTripFilterHeading">
                                        <button class="accordion-button filter-options collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#drvTripFilterBody"
                                                aria-expanded="false" aria-controls="drvTripFilterBody"
                                                style="background:#f8f9fc;font-size:12px;font-weight:700;color:#475569;padding:10px 16px;">
                                            <div class="item-filter" style="display:flex;align-items:center;gap:8px;">
                                                <span class="filter-icon">
                                                    <img src="{{ asset('images/icons/filter-01icon.png') }}" alt="icon" style="width:18px;" onerror="this.style.display='none'">
                                                    <i class="uil uil-filter" style="font-size:15px;color:#032671;"></i>
                                                </span>
                                                <p style="margin:0;">Filter Options</p>
                                            </div>
                                        </button>
                                    </h2>
                                    <div id="drvTripFilterBody" class="accordion-collapse collapse"
                                         aria-labelledby="drvTripFilterHeading"
                                         data-bs-parent="#drvTripFilterAccordion">
                                        <div class="accordion-body" style="padding:16px;">
                                            <form class="driver_filterbd">

                                                {{-- Row 1: selects --}}
                                                <div class="item-row01 filtersearch-bd justify-content-between" style="display:flex;flex-wrap:wrap;gap:8px;align-items:flex-end;">

                                                    <div class="vehicletype" style="min-width:130px;flex:1;">
                                                        <label style="font-size:11px;font-weight:600;color:#64748b;display:block;margin-bottom:4px;">Vehicle Type</label>
                                                        <select class="form-select form-select-sm">
                                                            <option>Choose..</option>
                                                            <option>Large Truck</option>
                                                            <option>Medium Truck</option>
                                                            <option>Small Truck</option>
                                                        </select>
                                                    </div>

                                                    <div class="vehicletype ms-1" style="min-width:130px;flex:1;">
                                                        <label style="font-size:11px;font-weight:600;color:#64748b;display:block;margin-bottom:4px;">Route</label>
                                                        <select class="form-select form-select-sm">
                                                            <option>Choose..</option>
                                                        </select>
                                                    </div>

                                                    <div class="vehicletype ms-1" style="min-width:140px;flex:1;">
                                                        <label style="font-size:11px;font-weight:600;color:#64748b;display:block;margin-bottom:4px;">Start Date</label>
                                                        <input type="date" class="form-control form-control-sm">
                                                    </div>

                                                    <div class="vehicletype ms-1" style="min-width:140px;flex:1;">
                                                        <label style="font-size:11px;font-weight:600;color:#64748b;display:block;margin-bottom:4px;">End Date</label>
                                                        <input type="date" class="form-control form-control-sm">
                                                    </div>

                                                    <div class="vehicletype ms-1" style="min-width:150px;flex:1;">
                                                        <label style="font-size:11px;font-weight:600;color:#64748b;display:block;margin-bottom:4px;">Customer</label>
                                                        <select class="form-select form-select-sm">
                                                            <option>Choose..</option>
                                                        </select>
                                                    </div>

                                                    <div class="vehicletype ms-1" style="min-width:130px;flex:1;">
                                                        <label style="font-size:11px;font-weight:600;color:#64748b;display:block;margin-bottom:4px;">LR Number</label>
                                                        <select class="form-select form-select-sm">
                                                            <option>Choose..</option>
                                                        </select>
                                                    </div>

                                                    <div class="vehicletype ms-1" style="min-width:130px;flex:1;">
                                                        <label style="font-size:11px;font-weight:600;color:#64748b;display:block;margin-bottom:4px;">Trip Status</label>
                                                        <select class="form-select form-select-sm">
                                                            <option>Choose..</option>
                                                            <option>Trip Initiated</option>
                                                            <option>On the Way</option>
                                                            <option>Connected</option>
                                                            <option>Inactive</option>
                                                            <option>Completed</option>
                                                        </select>
                                                    </div>

                                                </div>

                                                {{-- Row 2: search fields + buttons --}}
                                                <div class="item-row02 filtersearch-bd searchfield justify-content-start mt-3"
                                                     style="display:flex;flex-wrap:wrap;gap:8px;align-items:center;">

                                                    <div style="width:260px;">
                                                        <div class="input-group input-group-sm">
                                                            <input type="text" class="form-control" placeholder="Search by Trip Number">
                                                            <span class="input-group-text"><i class="uil uil-search"></i></span>
                                                        </div>
                                                    </div>

                                                    <div style="width:260px;">
                                                        <div class="input-group input-group-sm">
                                                            <input type="text" class="form-control" placeholder="Search by Vehicle Number">
                                                            <span class="input-group-text"><i class="uil uil-search"></i></span>
                                                        </div>
                                                    </div>

                                                    <div style="width:260px;">
                                                        <div class="input-group input-group-sm">
                                                            <input type="text" class="form-control" placeholder="Search by Customer Name">
                                                            <span class="input-group-text"><i class="uil uil-search"></i></span>
                                                        </div>
                                                    </div>

                                                    <button class="btn btn-sm btn-secondary" type="button" style="font-size:12px;">
                                                        <i class="uil uil-sync me-1"></i>Reset
                                                    </button>

                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-primary dropdown-toggle" type="button"
                                                                data-bs-toggle="dropdown" style="font-size:12px;">
                                                            Export <i class="uil uil-upload ms-1"></i>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li><a class="dropdown-item" href="javascript:void(0)"><i class="uil uil-file-alt me-1"></i>Excel</a></li>
                                                            <li><a class="dropdown-item" href="javascript:void(0)"><i class="uil uil-file-pdf-alt me-1"></i>PDF</a></li>
                                                        </ul>
                                                    </div>

                                                </div>

                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Trip list --}}
                            <div style="margin-top:16px;background:#fff;border:1px solid #e2e8f0;border-radius:8px;overflow:hidden;">
                                <div style="background:#f8f9fc;padding:10px 14px;border-bottom:1px solid #e2e8f0;font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.5px;">
                                    <i class="uil uil-map-marker-alt me-1"></i>Trip History
                                </div>
                                <div style="text-align:center;padding:28px;color:#94a3b8;">
                                    <i class="uil uil-truck" style="font-size:28px;display:block;margin-bottom:6px;opacity:.4;"></i>
                                    <p style="font-size:12px;font-weight:600;margin:0;">No trips recorded yet</p>
                                    <p style="font-size:11px;margin:4px 0 0;">Trip data will populate once LR/trips are linked to this driver.</p>
                                </div>
                            </div>
                        </div>

                        {{-- ── TAB 2: Hisab Book ───────────────────── --}}
                        <div class="tab-pane fade" id="drvHisab">
                            <div style="background:#fff;border:1px solid #e2e8f0;border-radius:8px;overflow:hidden;">
                                <div style="background:#f8f9fc;padding:10px 14px;border-bottom:1px solid #e2e8f0;display:flex;align-items:center;justify-content:space-between;">
                                    <span style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.5px;">
                                        <i class="uil uil-book-open me-1"></i>Driver Hisab Ledger
                                    </span>
                                    <span style="font-size:11px;color:#94a3b8;">
                                        Opening Balance:
                                        <strong style="color:#032671;">
                                            {{ $driverinfo?->opening_balance
                                                ? '₹' . number_format($driverinfo->opening_balance) . ' (' . ($driverinfo->opening_balance_type ?? '') . ')'
                                                : '—' }}
                                        </strong>
                                    </span>
                                </div>
                                <div style="text-align:center;padding:28px;color:#94a3b8;">
                                    <i class="uil uil-receipt-alt" style="font-size:28px;display:block;margin-bottom:6px;opacity:.4;"></i>
                                    <p style="font-size:12px;font-weight:600;margin:0;">Hisab book is empty</p>
                                    <p style="font-size:11px;margin:4px 0 0;">Salary, advances, and deductions will appear here once the Hisab module is active.</p>
                                </div>
                            </div>
                        </div>

                        {{-- ── TAB 3: Allotment ────────────────────── --}}
                        <div class="tab-pane fade" id="drvAllotment">
                            <div style="background:#fff;border:1px solid #e2e8f0;border-radius:8px;overflow:hidden;">
                                <div style="background:#f8f9fc;padding:10px 14px;border-bottom:1px solid #e2e8f0;font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.5px;">
                                    <i class="uil uil-truck me-1"></i>Vehicle Allocation History
                                </div>
                                @if($allAllocations->count())
                                <div class="table-responsive">
                                    <table class="drv-alloc-table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Vehicle No.</th>
                                                <th>Allocated On</th>
                                                <th>Removed On</th>
                                                <th>Duration</th>
                                                <th>Assigned By</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($allAllocations->sortByDesc('created_at') as $i => $alloc)
                                            @php
                                                $allocFrom = $alloc->created_at;
                                                $allocTo   = $alloc->deleted_at;
                                                $duration  = $allocTo
                                                    ? $allocFrom->diff($allocTo)->days . 'd'
                                                    : 'Current';
                                            @endphp
                                            <tr>
                                                <td style="color:#94a3b8;">{{ $i + 1 }}</td>
                                                <td>
                                                    @if($alloc->vehicle)
                                                    <a href="{{ route('fleetdashboard.getVehicleDetailsV2', $alloc->vehicle->id) }}"
                                                       style="font-family:monospace;color:#032671;font-weight:700;font-size:12px;text-decoration:none;">
                                                        {{ $alloc->vehicle->vehicle_no }}
                                                    </a>
                                                    @else
                                                        <span style="color:#94a3b8;">—</span>
                                                    @endif
                                                </td>
                                                <td style="color:#475569;">{{ $allocFrom->format('d M Y') }}</td>
                                                <td style="color:#475569;">{{ $allocTo ? $allocTo->format('d M Y') : '—' }}</td>
                                                <td>
                                                    @if(!$allocTo)
                                                        <span style="background:#dcfce7;color:#15803d;font-size:10px;font-weight:700;padding:2px 8px;border-radius:10px;">Current</span>
                                                    @else
                                                        <span style="color:#64748b;">{{ $duration }}</span>
                                                    @endif
                                                </td>
                                                <td style="color:#64748b;">{{ $alloc->createdBy?->name ?? '—' }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @else
                                <div style="text-align:center;padding:28px;color:#94a3b8;">
                                    <i class="uil uil-truck" style="font-size:28px;display:block;margin-bottom:6px;opacity:.4;"></i>
                                    <p style="font-size:12px;font-weight:600;margin:0;">No vehicle allocations found</p>
                                    <p style="font-size:11px;margin:4px 0 0;">Assign this driver to a vehicle from the vehicle details page.</p>
                                </div>
                                @endif
                            </div>
                        </div>

                        {{-- ── TAB 4: Escalation ───────────────────── --}}
                        <div class="tab-pane fade" id="drvEscalation">
                            <div style="background:#fff;border:1px solid #e2e8f0;border-radius:8px;overflow:hidden;">
                                <div style="background:#f8f9fc;padding:10px 14px;border-bottom:1px solid #e2e8f0;display:flex;align-items:center;justify-content:space-between;">
                                    <span style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.5px;">
                                        <i class="uil uil-exclamation-triangle me-1"></i>Driver Escalations
                                    </span>
                                    <button class="btn btn-sm"
                                        style="font-size:11px;background:#fff8e1;color:#92400e;border:1px solid #fde68a;padding:3px 10px;border-radius:6px;">
                                        <i class="uil uil-plus me-1"></i>Log Escalation
                                    </button>
                                </div>
                                <div style="text-align:center;padding:28px;color:#94a3b8;">
                                    <i class="uil uil-clipboard-alt" style="font-size:28px;display:block;margin-bottom:6px;opacity:.4;"></i>
                                    <p style="font-size:12px;font-weight:600;margin:0;">No escalations on record</p>
                                    <p style="font-size:11px;margin:4px 0 0;">Complaints, violations, or incidents logged against this driver will appear here.</p>
                                </div>
                            </div>
                        </div>

                    </div>{{-- end tab-content --}}
                </div>
            </div>{{-- end vehicle-itemtab --}}

        </div>{{-- end vehicleinfo-wrap --}}

    </div>{{-- end vehicledtl-bd --}}
</div>
@endsection

@section('js')
<script>
/* Driver Details page — no additional JS needed;
   Bootstrap tab handling is automatic via data-bs-toggle="tab" */
</script>
@endsection
