@extends('layouts.app')

@section('css')
    
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css" />
<link rel="stylesheet" href="{{ asset('css/tyre/show.css') }}">

@endsection
    

@section('content')

    
<div class="layout-wrapper">
    
    @include('includes.header')
    @php
        $tyreLifeInfo = getTyreLifeInfo($tyre->id);
    @endphp
    <!--bottom header-->
    <div class="vehicledtl-bd srlog-bdwrapper">
        <div class="topbar-bd">
            <div class="item1">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <h1>Tyre Details</h1>
                        </div>
                        <div class="col-12 col-md-6 text-end">
                            <a href="{{ route('tyre.edit', $tyre->id) }}" class="btn btn-theme mt-1"><i class="uil uil-pen me-1"></i>Edit Tyre</a>
                        </div>
                    </div>
                    
                </div>
            </div>

            <div class="item2">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <div class="ltblock">
                                <div class="icon_car {{ $tyreLifeInfo['life_border_class'] }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Registration Active">
                                    <img src="{{ asset('images/icons/tyre-default.png') }}" height="25" />
                                </div>

                                <div class="text">
                                    <div class="topsec">
                                        <p>{{ $tyre->tyre_serial_number }}</p>
                                        <!--<span class="addbtn">Add TAG <i class="uil uil-plus"></i></span>-->
                                    </div>

                                    <span class="cartype">{{ $tyre->tyre_type }}</span>
                                    <span class="cartype">
                                        Condition: {{ $tyre->tyre_condition }}
                                        <!--<a class="edit-driver-btn" href="{{ route('tyre.edit', $tyre->id) }}"><i class="uil uil-pen"></i></a>-->
                                    </span>
                                </div>

                                <!--<div class="liveloc_sec">-->
                                <!--    <span>Live Location</span>-->
                                <!--    <p>Delhi</p>-->
                                <!--</div>-->
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="rtblock">
                                <!--<div class="item-btn c_green">-->
                                <!--    <span class="icon"><i class="uil uil-shield-check text-primary"></i></span>-->
                                <!--    <div class="text">-->
                                <!--        <p>RC Verified</p>-->
                                <!--    </div>-->
                                <!--</div>-->

                                <!--<div class="item-btn c_blue">-->
                                <!--    <span class="icon"><i class="uil uil-shield-check text-primary"></i></span>-->
                                <!--    <div class="text">-->
                                <!--        <span>Trip Fleet Status</span>-->
                                <!--        <p>Maintenance</p>-->
                                <!--    </div>-->
                                <!--</div>-->

                                <div class="item-btn c_green">
                                    <span class="icon"><i class="uil uil-shield-check text-primary"></i></span>
                                    <div class="text">
                                        <span>Location</span>
                                        <p>{{ $tyre->location }}</p>
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
                                        <span class="titletext">Tyre Basic Information</span>
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
                                                        <p>Serial Number</p>
                                                        <span class="text-secondary d-block">{{ $tyre->tyre_serial_number }}</span>
                                                    </td>
                                                    <!--<td>-->
                                                    <!--    <p>Tyre Condition</p>-->
                                                    <!--    <span class="text-secondary d-block">{{ $tyre->tyre_condition }}</span>-->
                                                    <!--</td>-->
                                                    <td>
                                                        <p>Brand</p>
                                                        <span class="text-secondary d-block">{{ $tyre->tyre_brand }}</span>
                                                    </td>
                                                    <td>
                                                        <p>Vendor</p>
                                                        <span class="text-secondary d-block">{{ $tyre->tyrevendor?->contact_name ?? '-' }}</span>
                                                    </td>
                                                    <td>
                                                        <p>Model</p>
                                                        <span class="text-secondary d-block">{{ $tyre->tyre_model }}</span>
                                                    </td>
                                                    <!--<td>-->
                                                    <!--    <p>Type</p>-->
                                                    <!--    <span class="text-secondary d-block">{{ $tyre->tyre_type }}</span>-->
                                                    <!--</td>-->
                                                    <td>
                                                        <p>Price</p>
                                                        <span class="text-secondary d-block">₹{{ number_format($tyre->tyre_price, 2) }}</span>
                                                    </td>
                                                    <td>
                                                        <p>Purchase Date</p>
                                                        <span class="text-secondary d-block">{{ date('d/m/Y', strtotime($tyre->tyre_purchase_date)) }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <p>Issue Date</p>
                                                        <span class="text-secondary d-block">{{ $tyre->tyre_issue_date ? date('d/m/Y', strtotime($tyre->tyre_issue_date)) : '-' }}</span>
                                                    </td>
                                                    <td>
                                                        <p>Warrenty Expriry Date</p>
                                                        <span class="text-secondary d-block">{{ date('d/m/Y', strtotime('+' . $tyre->tyre_warranty_months .' months ' . $tyre->issue_date)) }}</span>
                                                    </td>
                                                    <td>
                                                        <p>Fixed Run KM</p>
                                                        <span class="text-secondary d-block">{{ $tyre->fixed_run_km ?? '-' }}</span>
                                                    </td>
                                                    <td>
                                                        <p>Fixed Run Month</p>
                                                        <span class="text-secondary d-block">{{ $tyre->fixed_life_months ?? '-' }}</span>
                                                    </td>
                                                    <td>
                                                        <p>Actual Run KM</p> 
                                                        <span class="text-secondary d-block">{{ $tyre->actual_run_km ?? '-' }}</span>
                                                    </td>
                                                    <td>
                                                        <p>Actual Run Month</p>
                                                        <span class="text-secondary d-block">{{ $tyre->actual_run_month ?? '-' }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <p>Alignment Interval KM</p>
                                                        <span class="text-secondary d-block">{{ $tyre->alignment_interval_km ?? '-' }}</span>
                                                    </td>
                                                    <td>
                                                        <p>Set Reminder For Alignment Interval KM</p>
                                                        <span class="text-secondary d-block">{{ $tyre->set_reminder_for_alignment }}</span>
                                                    </td>
                                                    <td>
                                                        <p>Rotation Interval KM</p>
                                                        <span class="text-secondary d-block">{{ $tyre->rotation_interval_km ?? '-' }}</span>
                                                    </td>
                                                    <td>
                                                        <p>Set Reminder For Rotation</p>
                                                        <span class="text-secondary d-block">{{ $tyre->set_reminder_for_rotation }}</span>
                                                    </td>
                                                    <td>
                                                        <p>Last Alignment KM</p>
                                                        <span class="text-secondary d-block">{{ $tyre->last_alignment_km ?? '-' }}</span>
                                                    </td>
                                                    <td>
                                                        <p>Last Rotation KM</p>
                                                        <span class="text-secondary d-block">{{ $tyre->last_rotation_km ?? '-' }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <p>Tyre Remaining Run KM</p>
                                                        <span class="text-secondary d-block">
                                                            @if($tyre->fixed_run_km && $tyre->actual_run_km)
                                                                {{ ($tyre->fixed_run_km - $tyre->actual_run_km) }}
                                                            @else
                                                                -
                                                            @endif
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <p>Tyre Remaining Life (Month)</p>
                                                        <span class="text-secondary d-block">
                                                            @if($tyre->fixed_life_months && $tyre->actual_run_month)
                                                                {{ ($tyre->fixed_life_months - $tyre->actual_run_month) }}
                                                            @else
                                                                -
                                                            @endif
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <p>Discard Note</p>
                                                        <span class="text-secondary d-block">{{ $tyre->discard_note ?? '-' }}</span>
                                                    </td>
                                                    <td>
                                                        <p>Discard Date</p>
                                                        <span class="text-secondary d-block">{{ $tyre->discard_date ? date('d/m/Y', strtotime($tyre->discard_date)) : '-' }}</span>
                                                    </td>
                                                    <td>
                                                        <p>Tyre Life (%)</p>
                                                        <span class="text-secondary d-block">
                                                            {{ $tyreLifeInfo['life_percent'] }} ({{ $tyreLifeInfo['life_text'] }})
                                                        </span>
                                                    </td>
                                                </tr>
                                                
                                            </tbody>
                                        </table>
                                    </div>
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
        
    </div>
   
</div>
    
    
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
<script>
    const PDF_LOGO = "{{ asset('images/pdf_file.png') }}";
    const OTHER_LOGO = "{{ asset('images/other_file.svg') }}";
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>
<script type="text/javascript" src="{{ asset('customjs/tyre/show.js') }}?v={{ uniqid() }}"></script>

@endsection


