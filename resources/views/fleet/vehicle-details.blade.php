@extends('layouts.app')

@section('css')
    
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<link rel="stylesheet" href="{{ asset('css/vehicle-details.css?v=0.02') }}">
    
@endsection

@section('content')

    
    
<div class="layout-wrapper">
    
    @include('includes.header')
    
    <!--bottom header-->
    <div class="vehicledtl-bd srlog-bdwrapper">
        <div class="topbar-bd">
            <div class="item1">
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
                                    <span class="titletext">Tyres Details</span>
                                    <a href="{{ route('tyremanage.vehicle.tyre.tagging', $vehicle->id) }}" class="badge badge-primary"><i class="uil uil-plus me-1"></i>Add Tyre Details</a>
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
                                {{--
                                @forelse($vehicle->tyres as $tyre)
                                <div class="inner-card">
                                    <div class="icon-wrap">
                                        <a href="javascript:void(0)" data-id="{{ $tyre->id }}" class="editTyre"><i class="uil uil-pen"></i></a>
                                        <a href="javascript:void(0)" data-id="{{ $tyre->id }}" class="deleteTyre text-danger ms-1"><i class="uil uil-trash-alt"></i></a>
                                    </div>
                                    <div class="table-responsive table-responsive02">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <p>Tyre Model</p>
                                                        <span class="text-secondary d-block">{{ $tyre->tyre_model ?? '-' }}</span>
                                                    </td>
                                                    <td>
                                                        <p>Tyre Type</p>
                                                        <span class="text-secondary d-block">{{ $tyre->tyre_type ?? '-' }}</span>
                                                    </td>
                                                    <td>
                                                        <p>Tyre Brand</p>
                                                        <span class="text-secondary d-block">{{ $tyre->tyre_brand ?? '-' }}</span>
                                                    </td>
                                                    <td>
                                                        <p>Tyre Price</p>
                                                        <span class="text-secondary d-block">{{ $tyre->tyre_price ?? '-' }}</span>
                                                    </td>
                                                    <td>
                                                        <p>Tyre Serial Numbers</p>
                                                        <span class="text-secondary d-block">{{ $tyre->tyre_serial_number ?? '-' }}</span>
                                                    </td>
                                                    <td>
                                                        <p>Tyre Position</p>
                                                        <span class="text-secondary d-block">{{ $tyre->tyre_position ?? '-' }}</span>
                                                    </td>
                                                    <td>
                                                        <p>Warranty (Months)</p>
                                                        <span class="text-secondary d-block">{{ $tyre->tyre_warranty_months ?? '-' }}</span>
                                                    </td>
                                                    
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <p>Purchase Date</p>
                                                        <span class="text-secondary d-block">{{ $tyre->tyre_purchase_date ?? '-' }}</span>
                                                    </td>
                                                    <td>
                                                        <p>Issue Date</p>
                                                        <span class="text-secondary d-block">{{ $tyre->tyre_issue_date ?? '-' }}</span>
                                                    </td>
                                                    <td>
                                                        <p>Fixed Run KM</p>
                                                        <span class="text-secondary d-block">{{ $tyre->fixed_run_km ?? '-' }}</span>
                                                    </td>
                                                    <td>
                                                        <p>Fixed Life (Months)</p>
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
                                                    <td>
                                                        <p>Remaining Run KM</p>
                                                        <span class="text-secondary d-block">{{ $tyre->remaining_run_km ?? '-' }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <p>Remaining Life (Months)</p>
                                                        <span class="text-secondary d-block">{{ $tyre->remaining_life_month ?? '-' }}</span>
                                                    </td>
                                                    <td>
                                                        <p>Alignment Every KM</p>
                                                        <span class="text-secondary d-block">{{ $tyre->alignment_interval_km ?? '-' }}</span>
                                                    </td>
                                                    <td>
                                                        <p>Rotation Every KM</p>
                                                        <span class="text-secondary d-block">{{ $tyre->rotation_interval_km ?? '-' }}</span>
                                                    </td>
                                                    <td>
                                                        <p>Last Alignment KM</p>
                                                        <span class="text-secondary d-block">{{ $tyre->last_alignment_km ?? '-' }}</span>
                                                    </td>
                                                    <td>
                                                        <p>Last Rotation KM</p>
                                                        <span class="text-secondary d-block">{{ $tyre->last_rotation_km ?? '-' }}</span>
                                                    </td>
                                                    <td></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                @empty
                                @endforelse
                                --}}
                                <div class="alert alert-warning text-center p-2" role="alert">
                                    Please Add Tyre Details, No Data is Added yet. 
                                </div>
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
                                            <th>Expiary Date</th>
                                            <th>Status</th>
                                            <th>Notes</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <span class="value">Insurance</span>
                                            </td>
                                            
                                            <td><span class="value">MH01ABG056</span></td>
                                            
                                            <td><span class="value">14/10/2025</span></td>
                                            
                                            <td><span class="value">14/10/2026</span></td>
                                            
                                            <td><span class="badge badge-success">Active</span></td>
                                            
                                            <td><span class="value">Lorem ipsum doller <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modalNotes">...</a></span></td>
    
                                            <td class="text-center">
                                                <a class="item-edit text-success" data-bs-toggle="modal" data-bs-target="#add06_documents"><i class="uil uil-pen me-2"></i></a>
                                                <a class="item-delete text-danger"><i class="uil uil-trash-alt"></i></a>
                                            </td>
                                        </tr>
                                        
                                        <tr>
                                            <td>
                                                <span class="value">Fitness</span>
                                            </td>
                                            
                                            <td><span class="value">MH01ABG056</span></td>
                                            
                                            <td><span class="value">14/10/2025</span></td>
                                            
                                            <td><span class="value">14/10/2026</span></td>
                                            
                                            <td><span class="badge badge-danger">Inctive</span></td>
                                            
                                            <td><span class="value">Lorem ipsum doller <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modalNotes">...</a></span></td>
    
                                            <td class="text-center">
                                                <a class="item-edit text-success" data-bs-toggle="modal" data-bs-target="#add06_documents"><i class="uil uil-pen me-2"></i></a>
                                                <a class="item-delete text-danger"><i class="uil uil-trash-alt"></i></a>
                                            </td>
                                        </tr>
                                        
                                        <tr>
                                            <td>
                                                <span class="value">PUCC</span>
                                            </td>
                                            
                                            <td><span class="value">MH01ABG056</span></td>
                                            
                                            <td><span class="value">14/10/2025</span></td>
                                            
                                            <td><span class="value">14/10/2026</span></td>
                                            
                                            <td><span class="badge badge-success">Active</span></td>
                                            
                                            <td><span class="value">Lorem ipsum doller <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modalNotes">...</a></span></td>
    
                                            <td class="text-center">
                                                <a class="item-edit text-success" data-bs-toggle="modal" data-bs-target="#add06_documents"><i class="uil uil-pen me-2"></i></a>
                                                <a class="item-delete text-danger"><i class="uil uil-trash-alt"></i></a>
                                            </td>
                                        </tr>
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
                <form>
                    <div class="row">
                        <div class="col-12 col-md-6 form-group">
                            <label>Vehicle<span class="text-danger ms-1">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control bg-light" readonly value="MH-01-AB-1234" />
                            </div>
                        </div>

                        <div class="col-12 col-md-6 form-group">
                            <label>Document Type<span class="text-danger ms-1">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search Document Type..." />
                                <!--<span class="input-group-text">-->
                                <!--  <i class="uil uil-file-alt"></i>-->
                                <!--</span>-->
                            </div>
                        </div>

                        <div class="col-12 col-md-6 form-group">
                            <label>Document Number</label>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="" />
                            </div>
                        </div>

                        <div class="col-12 col-md-6 form-group">
                            <label>Issue Date</label>
                            <div class="input-group">
                                <input class="date form-control" type="text" name="maintenance-date" />

                                <span class="input-group-text">
                                    <i class="uil uil-calendar-alt"></i>
                                </span>
                            </div>
                        </div>

                        <div class="col-12 col-md-6 form-group">
                            <label>Expiry Date<span class="text-danger ms-1">*</span></label>
                            <div class="input-group">
                                <input class="date form-control" type="text" name="maintenance-date" />
                                <span class="input-group-text">
                                    <i class="uil uil-calendar-alt"></i>
                                </span>
                            </div>
                        </div>

                        <div class="col-12 col-md-6 form-group">
                            <div class="file_0attachment">
                                <!--<label for="formFile" class="form-label">File Attachment</label>-->

                                <div class="upload__box">
                                    <div class="upload__btn-box">
                                        <label class="upload__btn">
                                            <p class="btn btn-theme mb-0">
                                                <i class="uil uil-plus me-1"></i>File Attachment
                                            </p>
                                            <input
                                                type="file"
                                                multiple=""
                                                data-max_length="20"
                                                class="upload__inputfile"
                                            />
                                        </label>
                                    </div>
                                    <div class="upload__img-wrap"></div>
                                </div>

                                <p class="allow-fsize">Allow file type PDF, JPG, JPEG, PNG</p>
                            </div>
                        </div>
                        <!--////-->

                        <div class="col-12 col-md-12 form-group">
                            <div class="d-flex">
                                <input class="form-check-input clickto-adclass" type="checkbox" id="setReminder" />

                                <label class="me-1">Set Reminder </label>
                            </div>

                            <div class="days-beforeexpiry" style="display: none">
                                <div class="row form-group">
                                    <div class="col-12 col-md-3">
                                        <label>Remind Before Days <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <select class="form-select">
                                            <option>Choose..</option>
                                            <option>7 Days</option>
                                            <option>10 Days</option>
                                            <option>20 Days</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-12 col-md-12 form-group">
                            <label>Notes</label>
                            <textarea class="form-control" rows="4"></textarea>
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






@endsection

@section('js')


<script type="text/javascript" src="{{ asset('customjs/fleet/vehicle-details.js') }}"></script>

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
    
    
    
    
    $(document).ready(function() {
      $(".changedriver_bd").hide();
      $(".open_01driver").on("click", function() {
        $(".changedriver_bd").slideToggle(300); 
        $(this).toggleClass("active");   
      });
    });
</script>

<script>
    $(function() {
      $('input[name="datetime"]').daterangepicker({
        singleDatePicker: true,   
        timePicker: true,         
        startDate: moment(),      
        locale: {
          format: 'MM/DD/YYYY hh:mm A' 
        }
      });
    });
</script>

<script>
$(function() {
  $('input[name="datet01"]').daterangepicker({
    singleDatePicker: true,   
    timePicker: false,        
    locale: {
      format: 'MM/DD/YYYY',   
    }
  });
});
</script>

<script>
$(function() {
  $('input[name="maintenance-date"]').daterangepicker({
    singleDatePicker: true,   
    timePicker: false,        
    locale: {
      format: 'MM/DD/YYYY',   
    }
  });
});
</script>

<script>
  const noteInput = document.getElementById('noteInput');
  noteInput.addEventListener('input', function () {
    this.style.height = 'auto'; // reset height
    this.style.height = (this.scrollHeight) + 'px'; // set new height
  });
</script>

<script>
    $(document).ready(function() {
        $('.modal').on('shown.bs.modal', function () {
            $(this).find('.select2').select2({
                dropdownParent: $(this)
            });
        });
    });
</script>

<script>
    $(document).ready(function(){
        $('.add-stop-btn').click(function(){
            $('.add-stop').show();
        });
        
        $('.removeStop').click(function(){
        $('.add-stop').hide();
        });
        
    });
</script>

<script>
  document.querySelectorAll('input[name="providentFund"]').forEach((radio) => {
    radio.addEventListener("change", function () {
      const pfField = document.getElementById("pf_number_field");
      if (this.value === "yes") {
        pfField.style.display = "flex"; // show
      } else {
        pfField.style.display = "none"; // hide
      }
    });
  });
  
   // image upload
    ImgUpload();
    // --
  
  function ImgUpload() {
      var imgWrap = "";
      var imgArray = [];
    
      $('.upload__inputfile').each(function () {
        $(this).on('change', function (e) {
          imgWrap = $(this).closest('.upload__box').find('.upload__img-wrap');
          var maxLength = $(this).attr('data-max_length');
    
          var files = e.target.files;
          var filesArr = Array.prototype.slice.call(files);
          var iterator = 0;
          filesArr.forEach(function (f, index) {
    
            if (!f.type.match('image.*')) {
              return;
            }
    
            if (imgArray.length > maxLength) {
              return false
            } else {
              var len = 0;
              for (var i = 0; i < imgArray.length; i++) {
                if (imgArray[i] !== undefined) {
                  len++;
                }
              }
              if (len > maxLength) {
                return false;
              } else {
                imgArray.push(f);
    
                var reader = new FileReader();
                reader.onload = function (e) {
                  var html = "<div class='upload__img-box'><div style='background-image: url(" + e.target.result + ")' data-number='" + $(".upload__img-close").length + "' data-file='" + f.name + "' class='img-bg'><div class='upload__img-close'></div></div></div>";
                  imgWrap.append(html);
                  iterator++;
                }
                reader.readAsDataURL(f);
              }
            }
          });
        });
      });
    
      $('body').on('click', ".upload__img-close", function (e) {
        var file = $(this).parent().data("file");
        for (var i = 0; i < imgArray.length; i++) {
          if (imgArray[i].name === file) {
            imgArray.splice(i, 1);
            break;
          }
        }
        $(this).parent().parent().remove();
      });
    }
</script>

<script>
 $(document).ready(function(){
    $('.clickto-adclass').change(function(){
        if ($(this).is(':checked')) {
            $('.days-beforeexpiry').addClass('active');
        } else {
            $('.days-beforeexpiry').removeClass('active');
        }
    });
    
    $('.if-main').click(function(){
        $('.maintanance-wrap').show();
        $('.repair-wrap').hide();
    })
    $('.if-rep').click(function(){
        $('.maintanance-wrap').hide();
        $('.repair-wrap').show();
    })
});
</script>

@endsection