@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/fleet/dashboard.css?v=1.0') }}">
<link rel="stylesheet" href="{{ asset('css/fleet/index.css?v=3.3') }}">
@endsection

@section('content')

<div class="layout-wrapper">
    
    @include('includes.header')
    <!--bottom header-->
   
    <div class="dashboard-bd srlog-bdwrapper">
       
        <div class="top-text">
           <div class="container-fluid">
               <div class="row">
                   <div class="col-12 col-md-6">
                       <h1>Fleet Dashboard</h1>
                   </div>
                   <div class="col-12 col-md-6 text-end">
                       <div class="dropdown mt-2 mb-2">
                           
                            <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#uploadBulk">
                                <i class="uil uil-upload me-1"></i>Bulk Upload
                            </button>               

                          <!--<button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">-->
                          <!--  <i class="uil uil-upload me-1"></i>Bulk Upload-->
                          <!--</button>-->
                          
                          <!--<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">-->
                          <!--  <li><a class="dropdown-item bulk-type" data-type="gps" data-bs-target="#uploadBulk" href="javascript:void(0)" data-bs-toggle="modal">GPS Info</a></li>-->
                          <!--  <li><a class="dropdown-item bulk-type" data-type="fastag" data-bs-target="#uploadBulk" href="javascript:void(0)" data-bs-toggle="modal">Fastag Info</a></li>-->
                          <!--  <li><a class="dropdown-item bulk-type" data-type="battery" data-bs-target="#uploadBulk" href="javascript:void(0)" data-bs-toggle="modal">Battery Info</a></li>-->
                          <!--</ul>-->
                          
                        </div>
                   </div>
               </div>
               
           </div>               
        </div>
       
        <div class="itemvehicles-bd">
            <div class="container-fluid">
                
                <div class="itemv-box">
                    <div class="itemrow justify-content-around">
                        
                        <div class="itemcol">
                            <div class="itembd">
                                <div class="top">
                                    <p class="number">{{ $vehicleCount }}</p>
                                    <p>All Vehicles</p>
                                </div>
                        
                                <div class="bottom">
                                    <div class="item1"><img src="{{ asset('images/up-right-arrow 1.png') }}" /> 99%</div>
                        
                                    <div class="item3">
                                        <img src="{{ asset('images/vehicles.png') }}" />
                                    </div>
                                </div>
                        
                                <div class="item-icon">
                                    <span>
                                        <img src="{{ asset('images/images01.png') }}" />
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="itemcol">
                            <div class="itembd">
                                <div class="top">
                                    <p class="number">80</p>
                                    <p>Empty Vehicles </p>
                                </div>
                        
                                <div class="bottom">
                                    <div class="item1"><img src="{{ asset('images/up-right-arrow 1.png') }}" /> 99%</div>
                        
                                    <div class="item3">
                                        <img src="{{ asset('images/vehicles.png') }}" />
                                    </div>
                                </div>
                        
                                <div class="item-icon">
                                    <span>
                                        <img src="{{ asset('images/images01.png') }}" />
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="itemcol">
                            <div class="itembd">
                                <div class="top">
                                    <p class="number">45</p>
                                    <p>Loading Vehicles</p>
                                </div>
                        
                                <div class="bottom">
                                    <div class="item1"><img src="{{ asset('images/up-right-arrow 1.png') }}" /> 99%</div>
                        
                                    <!--<div class="item2">Inactive Vehicles</div>-->
                        
                                    <div class="item3">
                                        <img src="{{ asset('images/vehicles.png') }}" />
                                    </div>
                                </div>
                        
                                <div class="item-icon">
                                    <span>
                                        <img src="{{ asset('images/images01.png') }}" />
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="itemcol">
                            <div class="itembd">
                                <div class="top">
                                    <p class="number">30</p>
                                    <p>Unloading Vehicles</p>
                                </div>
                        
                                <div class="bottom">
                                    <div class="item1"><img src="{{ asset('images/up-right-arrow 1.png') }}" /> 99%</div>
                        
                                    <!--<div class="item2">Without Driver</div>-->
                        
                                    <div class="item3">
                                        <img src="{{ asset('images/vehicles.png') }}" />
                                    </div>
                                </div>
                        
                                <div class="item-icon">
                                    <span>
                                        <img src="{{ asset('images/images01.png') }}" />
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="itemcol">
                            <div class="itembd">
                                <div class="top">
                                    <p class="number">40</p>
                                    <p>On The Way Vehicles</p>
                                </div>
                        
                                <div class="bottom">
                                    <div class="item1"><img src="{{ asset('images/up-right-arrow 1.png') }}" /> 99%</div>
                        
                                    <!--<div class="item2">On Trip Vehicles</div>-->
                        
                                    <div class="item3">
                                        <img src="{{ asset('images/vehicles.png') }}" />
                                    </div>
                                </div>
                        
                                <div class="item-icon">
                                    <span>
                                        <img src="{{ asset('images/images01.png') }}" />
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="itemcol">
                            <div class="itembd">
                                <div class="top">
                                    <p class="number">20</p>
                                    <p>Maintenance Vehicles</p>
                                </div>
                        
                                <div class="bottom">
                                    <div class="item1"><img src="{{ asset('images/up-right-arrow 1.png') }}" /> 99%</div>
                        
                                    <!--<div class="item2">Maintenance Vehicles</div>-->
                        
                                    <div class="item3">
                                        <img src="{{ asset('images/vehicles.png') }}" />
                                    </div>
                                </div>
                        
                                <div class="item-icon">
                                    <span>
                                        <img src="{{ asset('images/images01.png') }}" />
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!---->
                <div class="itemfuelfleet">
                    <div class="row">
                        <div class="col-12">
                            <div class="itemsec">
                                <p>Fleet Status</p>
                                <div class="sec-color">
                                    <ul>
                                        @foreach($fleetstatuses as $status)
                                            <li>
                                                <span class="color {{ $status->color_class }}"></span>
                                                {{ $status->name }}
                                            </li>
                                        @endforeach
                                       
                                    </ul>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-12 col-md-4 mt-3">
                            <div class="itemsec">
                                <p>Trip Status</p>
                                <div class="sec-color">
                                    <ul>
                                        <li><span class="color cng_c "></span> Initiated</li>
                                        <li><span class="color ev_c cng_c"></span> On Going </li>
                                        <li><span class="color petrol_c"></span> Completed</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-12 col-md-8 mt-3">
                            <span class="badge bg-danger">All Vehicles Added here are run by Diesel only</span>
                            <p style="font-size: 13px;"><strong>Note:</strong> This applies to our fleet's heavy-duty trucks and logistics vehicles, optimized for diesel efficiency in long-haul operations.</p>
                        </div>
                        
                        
                    </div>
                </div>
                <!---->
                
                <div class="right-side-wrap mt-0">
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                      <li class="nav-item" role="presentation">
                        <button class="nav-link fleetTab active" data-status="" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true"><span class="icon"><i class="uil uil-truck"></i></span>All Vehicles</button>
                      </li>
                      <li class="nav-item" role="presentation">
                        <button class="nav-link fleetTab" data-status="7" id="pills-empty-tab" data-bs-toggle="pill" data-bs-target="#pills-empty" type="button" role="tab" aria-controls="pills-empty" aria-selected="false"><span class="icon"><i class="uil uil-box"></i></span>Empty</button>
                      </li>
                      <li class="nav-item" role="presentation">
                        <button class="nav-link fleetTab" data-status="3" id="pills-loading-tab" data-bs-toggle="pill" data-bs-target="#pills-loading" type="button" role="tab" aria-controls="pills-loading" aria-selected="false"><span class="icon"><i class="uil uil-import"></i></span>Loading</button>
                      </li>
                      <li class="nav-item" role="presentation">
                        <button class="nav-link fleetTab" data-status="5" id="pills-unloading-tab" data-bs-toggle="pill" data-bs-target="#pills-unloading" type="button" role="tab" aria-controls="pills-unloading" aria-selected="false"><span class="icon"><i class="uil uil-export"></i></span>Unloading</button>
                      </li>
                      <li class="nav-item" role="presentation">
                        <button class="nav-link fleetTab" data-status="1" id="pills-on_the_way-tab" data-bs-toggle="pill" data-bs-target="#pills-on_the_way" type="button" role="tab" aria-controls="pills-on_the_way" aria-selected="false"><span class="icon"><i class="uil uil-location-arrow"></i></span>On The Way</button>
                      </li>
                      <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-attached_vehicle-tab" data-bs-toggle="pill" data-bs-target="#pills-attached_vehicle" type="button" role="tab" aria-controls="pills-attached_vehicle" aria-selected="false"><span class="icon"><i class="uil uil-link-alt"></i></span>Attached Vehicle</button>
                      </li>
                      <li class="nav-item" role="presentation">
                        <button class="nav-link fleetTab" data-status="6" id="pills-maintenance-tab" data-bs-toggle="pill" data-bs-target="#pills-maintenance" type="button" role="tab" aria-controls="pills-maintenance" aria-selected="false"><span class="icon"><i class="uil uil-wrench"></i></span>Maintenance</button>
                      </li>
                    </ul>
                    
                    <div class="tab-content" id="pills-tabContent">
                        
                      <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                          <div class="accordion mt-2" id="accordionExample">
                              <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                  <button class="accordion-button filter-options" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    <div class="item-filter">
                                        <div class="filter">
                                            <span class="filter-icon">
                                                <img src="{{ asset('images/icons/filter-01icon.png') }}" alt="icon">
                                            </span>
                                        </div>
                                        <p class="mb-0">Filter Options</p>
                                    </div>
                                  </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                  <div class="accordion-body">
                                    <form action="{{ route('fleetdashboard.index') }}" id="searchform">
                                        
                                        <input type="hidden" name="status" id="status">
                                        
                                        <div class="filtersearch-bd justify-content-between">
                                            
                                            <div class="vehicletype ms-1">
                                                <label>Fleet Status</label>
                                                <select class="form-select" name="v_fleet_status" id="v_fleet_status">
                                                    <option value="">Choose..</option>
                                                    @foreach($fleetstatuses as $status)
                                                    <option value="{{ $status->id }}">{{ $status->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            
                                            <div class="vehicletype ms-1">
                                                <label>Vehicle Group</label>
                                                <select class="form-select" name="v_vehiclegroup_id" id="v_vehiclegroup_id">
                                                    <option value="">Choose..</option>
                                                    @foreach($vehiclegroup as $value)
                                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            
                                            <div class="vehicletype ms-1">
                                                <label>Ownership</label>
                                                <select class="form-select" name="v_ownership" id="v_ownership_id">
                                                    <option value="">Choose..</option>
                                                    <option value="Own">Own</option>
                                                    <option value="Rental">Rental</option>
                                                </select>
                                            </div>
                                            
                                            <div class="vehicletype ms-1">
                                                <label>Trip Status</label>
                                                <select class="form-select" name="v_trip_status" id="v_trip_status">
                                                    <option value="">Choose..</option>
                                                    <option value="Initiated">Initiated</option>
                                                    <option value="On Going">On Going</option>
                                                    <option value="Completed">Completed</option>
                                                </select>
                                            </div>
                                            
                                            
                                            <div class="vehicletype ms-1">
                                                <label>Document Expiry Date</label>
                                                <div id="reportrange" class="form-control" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                                    <i class="fa fa-calendar"></i>&nbsp;
                                                    <span></span> <i class="fa fa-caret-down"></i>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="filtersearch-bd justify-content-start mt-3">
                                            
                                            <div class="ms-1" style="width: 200px;">
                                                <div class="input-group">
                                                  <input type="text" name="v_driver" id="v_driver" class="form-control" placeholder="Search by Driver">
                                                  <span class="input-group-text"><i class="uil uil-search"></i></span>
                                                  <!--<span class="input-group-text"><i class="uil uil-sync me-1"></i></span>-->
                                                </div>
                                            </div>
                                            
                                            <div class="ms-1" style="width: 225px;">
                                                <div class="input-group">
                                                  <input type="text" name="v_managed_by" id="v_managed_by" class="form-control" placeholder="Search by Manager">
                                                  <span class="input-group-text"><i class="uil uil-search"></i></span>
                                                  <!--<span class="input-group-text"><i class="uil uil-sync me-1"></i></span>-->
                                                </div>
                                            </div>
                                            
                                            <div class="ms-1" style="width: 220px;">
                                                <div class="input-group">
                                                  <input type="text" name="v_location" id="v_location" class="form-control" placeholder="Search by Location">
                                                  <span class="input-group-text"><i class="uil uil-search"></i></span>
                                                  <!--<span class="input-group-text"><i class="uil uil-sync me-1"></i></span>-->
                                                </div>
                                            </div>
                                            
                                            <div class="ms-1" style="width: 220px;">
                                                <div class="input-group">
                                                  <input type="text" name="v_vehicle_no" id="v_vehicle_no" class="form-control" placeholder="Search by Vehicle #">
                                                  <span class="input-group-text"><i class="uil uil-search"></i></span>
                                                  <!--<span class="input-group-text"><i class="uil uil-sync me-1"></i></span>-->
                                                </div>
                                            </div>
                                            
                                            
                                            <a href="{{ route('fleetdashboard.index') }}" class="btn btn-primary ms-1"><i class="uil uil-sync me-1"></i>Reset</a>
                                            
                                            <div class="dropdown ms-1">
                                                <button class="btn btn-primary dropdown-toggle" type="button" id="exportBtn" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Export <i class="uil uil-upload ms-1"></i>
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="exportBtn">
                                                    <li>
                                                        <a class="dropdown-item exportData" data-type="excel" href="javascript:void(0)">
                                                            Excel
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item exportData" data-type="pdf" href="javascript:void(0)">
                                                            PDF
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </form>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <!--sr_dashboard0_table-->
                            <div class="sr_dashboard0_table">
                                <div class="container-fluid">
                                    
                                    <div class="table-responsive">
                                        <table class="table custom-driver-table">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th style="min-width: 120px">Vehicle Number</th>
                                                    <th style="min-width: 120px">Current Driver</th>
                                                    <th>Vehicle Group</th>
                                                    <th>Vehicle Status</th>
                                                    <th>Last Location</th>
                                                    <th>Managed By</th>
                                                    <th class="text-center">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody id="fleetTableBody_all">
                                                @include('fleet.partials.vehicle_table_all')
                                            </tbody>
                                        </table>
                                    </div>
                                    


                                </div>
                            </div>
                            <!--sr_dashboard0_table-->
                      </div>
                      
                      <div class="tab-pane fade" id="pills-empty" role="tabpanel" aria-labelledby="pills-empty-tab">
                          <div class="accordion mt-2" id="accordionExample">
                              <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                  <button class="accordion-button filter-options" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    <div class="item-filter">
                                        <div class="filter">
                                            <span class="filter-icon">
                                                <img src="{{ asset('images/icons/filter-01icon.png') }}" alt="icon">
                                            </span>
                                        </div>
                                        <p class="mb-0">Filter Options</p>
                                    </div>
                                  </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                  <div class="accordion-body">
                                    <form>
                                        <input type="hidden" name="status" id="status">
                                        <div class="filtersearch-bd justify-content-between">
                                            
                                            <div class="vehicletype ms-1">
                                                <label>Fleet Status</label>
                                                <select class="form-select">
                                                    
                                                    <option value="">Choose..</option>
                                                    @foreach($fleetstatuses as $status)
                                                    <option value="{{ $status->id }}">{{ $status->name }}</option>
                                                    @endforeach
                                                    
                                                </select>
                                            </div>
                                            
                                            <div class="vehicletype ms-1">
                                                <label>Vehicle Group</label>
                                                <select class="form-select">
                                                    <option value="">Choose..</option>
                                                    @foreach($vehiclegroup as $value)
                                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            
                                            <div class="vehicletype ms-1">
                                                <label>Ownership</label>
                                                <select class="form-select">
                                                    <option value="">Choose..</option>
                                                    <option value="Own">Own</option>
                                                    <option value="Rental">Rental</option>
                                                </select>
                                            </div>
                                            
                                            <div class="vehicletype ms-1">
                                                <label>Last Trip</label>
                                                <select class="form-select select2">
                                                    <option value="">Choose..</option>
                                                    <option>HYD - PUNE</option>
                                                    <option>HYD - DEL</option>
                                                </select>
                                            </div>
                                            
                                            <div class="vehicletype ms-1">
                                                <label>Empty Since</label>
                                                <div id="reportrange" class="form-control" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                                    <i class="fa fa-calendar"></i>&nbsp;
                                                    <span></span> <i class="fa fa-caret-down"></i>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="filtersearch-bd justify-content-start mt-3">
                                            
                                            <div class="ms-1" style="width: 180px;">
                                                <div class="input-group">
                                                  <input type="text" class="form-control" placeholder="Search by Driver">
                                                  <span class="input-group-text"><i class="uil uil-search"></i></span>
                                                  <!--<span class="input-group-text"><i class="uil uil-sync me-1"></i></span>-->
                                                </div>
                                            </div>
                                            
                                            <div class="ms-1" style="width: 200px;">
                                                <div class="input-group">
                                                  <input type="text" class="form-control" placeholder="Search by Manager">
                                                  <span class="input-group-text"><i class="uil uil-search"></i></span>
                                                  <!--<span class="input-group-text"><i class="uil uil-sync me-1"></i></span>-->
                                                </div>
                                            </div>
                                            
                                            <div class="ms-1" style="width: 240px;">
                                                <div class="input-group">
                                                  <input type="text" class="form-control" placeholder="Search by Location">
                                                  <span class="input-group-text"><i class="uil uil-search"></i></span>
                                                  <!--<span class="input-group-text"><i class="uil uil-sync me-1"></i></span>-->
                                                </div>
                                            </div>
                                            
                                            <div class="ms-1" style="width: 220px;">
                                                <div class="input-group">
                                                  <input type="text" class="form-control" placeholder="Search by Vehicle #">
                                                  <span class="input-group-text"><i class="uil uil-search"></i></span>
                                                  <!--<span class="input-group-text"><i class="uil uil-sync me-1"></i></span>-->
                                                </div>
                                            </div>
                                            
                                            <a href="{{ route('fleetdashboard.index') }}" class="btn btn-primary ms-1"><i class="uil uil-sync me-1"></i>Reset</a>
                                            
                                            <div class="dropdown ms-1">
                                              <button class="btn btn-primary dropdown-toggle" type="button" id="exportBtn" data-bs-toggle="dropdown" aria-expanded="false">
                                                Export <i class="uil uil-upload ms-1"></i>
                                              </button>
                                              <ul class="dropdown-menu" aria-labelledby="exportBtn">
                                                <li><a class="dropdown-item" href="javascript:void(0)">Excel</a></li>
                                                <li><a class="dropdown-item" href="javascript:void(0)">PDF</a></li>
                                              </ul>
                                            </div>
                                            </div>
                                    </form>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <!--sr_dashboard0_table-->
                            <div class="sr_dashboard0_table">
                                <div class="container-fluid">
                                   
                                    <div class="table-responsive">
                                        <table class="table custom-driver-table">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th style="min-width: 120px">Vehicle Number</th>
                                                    <th style="min-width: 120px">Current Driver</th>
                                                    <th>Empty Since</th>
                                                    <th>Location</th>
                                                    <th>Last Trip</th>
                                                    <th>Managed By</th>
                                                    <th class="text-center">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody id="fleetTableBody_7">
                                                <tr>
                                                    <td><img src="{{ asset('images/icons/vehiche01.png') }}" alt="icon" class="driver-img-sm"></td>
                                                    <td>
                                                        <span class="value">WB-12-AB-1234</span>
                                                    </td>
                                                    <td><span class="value">Sujoy Ghosh</span><br/><span class="value">+91 9087654321</span></td>
                                                    
                                                    <td><span class="value">12/01/2026<br/>04:00 AM</span></td>
                                                    
                                                    <td><span class="value">Delhi</span></td>
                                                    
                                                    <td><span class="value">HYD - PUNE</span></td>
                                                    
                                                    <!--<td><span class="value">Tracking A</span></td>-->
                                                    
                                                    <td><span class="value">Anuj Maheta</span></td>
                                                    
                                                    <!--<td><span class="value">This vehicle is ready for operation</span></td>-->
            
                                                    <td class="text-center">
                                                        <a href="#" class="btn btn-sm-custom">View Details</a>
                                                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#remarks" class="ms-2 cmnt-icon"><i class="uil uil-info-circle"></i></a>
                                                    </td>
                                                </tr>
                                                
                                                <tr>
                                                    <td><img src="{{ asset('images/icons/vehiche03.png') }}" alt="icon" class="driver-img-sm"></td>
                                                    <td>
                                                        <span class="value">WB-12-AB-1235</span>
                                                    </td>
                                                    <td><span class="value">Ramen Singh</span><br/><span class="value">+91 9087654321</span></td>
                                                    
                                                    <td><span class="value">05/01/2026<br/>09:00 AM</span></td>
                                                    
                                                    <td><span class="value">Hydrabad</span></td>
                                                    
                                                    <td><span class="value">HYD - DEL</span></td>
                                                    
                                                    <!--<td><span class="value">Tracking B</span></td>-->
                                                    
                                                    <td><span class="value">Anuj Maheta</span></td>
                                                    
                                                    <!--<td><span class="value">This vehicle is ready for operation</span></td>-->
            
                                                    <td class="text-center">
                                                        <a href="#" class="btn btn-sm-custom">View Details</a>
                                                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#remarks" class="ms-2 cmnt-icon"><i class="uil uil-info-circle"></i></a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!--sr_dashboard0_table-->
                      </div>
                      
                      <div class="tab-pane fade" id="pills-loading" role="tabpanel" aria-labelledby="pills-loading-tab">
                          <div class="accordion mt-2" id="accordionExample">
                              <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                  <button class="accordion-button filter-options" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    <div class="item-filter">
                                        <div class="filter">
                                            <span class="filter-icon">
                                                <img src="{{ asset('images/icons/filter-01icon.png') }}" alt="icon">
                                            </span>
                                        </div>
                                        <p class="mb-0">Filter Options</p>
                                    </div>
                                  </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                  <div class="accordion-body">
                                    <form>
                                        <input type="hidden" name="status" id="status">
                                        <div class="filtersearch-bd justify-content-between">
                                            
                                            <div class="vehicletype ms-1">
                                                <label>Fleet Status</label>
                                                <select class="form-select">
                                                    <option value="">Choose..</option>
                                                    @foreach($fleetstatuses as $status)
                                                    <option value="{{ $status->id }}">{{ $status->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            
                                            <div class="vehicletype ms-1">
                                                <label>Vehicle Group</label>
                                                <select class="form-select">
                                                    <option value="">Choose..</option>
                                                    @foreach($vehiclegroup as $value)
                                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            
                                            <div class="vehicletype ms-1">
                                                <label>Ownership</label>
                                                <select class="form-select">
                                                    <option value="">Choose..</option>
                                                    <option value="Own">Own</option>
                                                    <option value="Rental">Rental</option>
                                                </select>
                                            </div>
                                            
                                            <div class="vehicletype ms-1">
                                                <label>Last Trip</label>
                                                <select class="form-select select2">
                                                    <option>Choose..</option>
                                                    <option>HYD - PUNE</option>
                                                    <option>HYD - DEL</option>
                                                </select>
                                            </div>
                                            
                                            <div class="vehicletype ms-1">
                                                <label>Loading Date</label>
                                                <div id="reportrange" class="form-control" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                                    <i class="fa fa-calendar"></i>&nbsp;
                                                    <span></span> <i class="fa fa-caret-down"></i>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="filtersearch-bd justify-content-start mt-3">
                                            
                                            <div class="ms-1" style="width: 180px;">
                                                <div class="input-group">
                                                  <input type="text" class="form-control" placeholder="Search by Driver">
                                                  <span class="input-group-text"><i class="uil uil-search"></i></span>
                                                  <!--<span class="input-group-text"><i class="uil uil-sync me-1"></i></span>-->
                                                </div>
                                            </div>
                                            
                                            <div class="ms-1" style="width: 200px;">
                                                <div class="input-group">
                                                  <input type="text" class="form-control" placeholder="Search by Manager">
                                                  <span class="input-group-text"><i class="uil uil-search"></i></span>
                                                  <!--<span class="input-group-text"><i class="uil uil-sync me-1"></i></span>-->
                                                </div>
                                            </div>
                                            
                                            <div class="ms-1" style="width: 240px;">
                                                <div class="input-group">
                                                  <input type="text" class="form-control" placeholder="Search by Location">
                                                  <span class="input-group-text"><i class="uil uil-search"></i></span>
                                                  <!--<span class="input-group-text"><i class="uil uil-sync me-1"></i></span>-->
                                                </div>
                                            </div>
                                            
                                            <div class="ms-1" style="width: 220px;">
                                                <div class="input-group">
                                                  <input type="text" class="form-control" placeholder="Search by Vehicle #">
                                                  <span class="input-group-text"><i class="uil uil-search"></i></span>
                                                  <!--<span class="input-group-text"><i class="uil uil-sync me-1"></i></span>-->
                                                </div>
                                            </div>
                                            
                                            <a href="{{ route('fleetdashboard.index') }}" class="btn btn-primary ms-1"><i class="uil uil-sync me-1"></i>Reset</a>
                                            
                                            <div class="dropdown ms-1">
                                              <button class="btn btn-primary dropdown-toggle" type="button" id="exportBtn" data-bs-toggle="dropdown" aria-expanded="false">
                                                Export <i class="uil uil-upload ms-1"></i>
                                              </button>
                                              <ul class="dropdown-menu" aria-labelledby="exportBtn">
                                                <li><a class="dropdown-item" href="javascript:void(0)">Excel</a></li>
                                                <li><a class="dropdown-item" href="javascript:void(0)">PDF</a></li>
                                              </ul>
                                            </div>
                                        </div>
                                    </form>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <!--sr_dashboard0_table-->
                            <div class="sr_dashboard0_table">
                                <div class="container-fluid">
                                    
                                    <div class="table-responsive">
                                        <table class="table custom-driver-table">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th style="min-width: 120px">Vehicle Number</th>
                                                    <th style="min-width: 120px">Current Driver</th>
                                                    <th>Loading Since</th>
                                                    <th>Customer</th>
                                                    <th>LR#<br/>Date</th>
                                                    <th>Last Trip</th>
                                                    <!--<th>Contact</th>-->
                                                    <th>Location<br/>Contact</th>
                                                    <th>Avg. Load Time</th>
                                                    <th>Managed By</th>
                                                    <th class="text-center">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody id="fleetTableBody_3">
                                                <tr>
                                                    <td><img src="{{ asset('images/icons/vehiche01.png') }}" alt="icon" class="driver-img-sm"></td>
                                                    <td>
                                                        <span class="value">WB-12-AB-1234</span>
                                                    </td>
                                                    <td><span class="value">Sujoy Ghosh</span><br/><span class="value">+91 9087654321</span></td>
                                                    
                                                    <td><span class="value">12/01/2026<br/>02:00 PM</span></td>
                                                    
                                                    <td><span class="value">Neelesh Maheta</span></td>
                                                    
                                                    <td><span class="value">#LR001123<br/>02/09/2025</span></td>
                                                    
                                                    <td><span class="value">DEL - HYD</span></td>
                                                    
                                                    <!--<td><span class="value">Anuj Maheta</span></td>-->
                                                    
                                                    <td><span class="value">Ashoke Nagar</span><br/><span class="value">+91 7890654321</span></td>
                                                    
                                                    <td><span class="value">10 Hr 12 Min</span></td>
                                                    
                                                    <td><span class="value">Anuj Maheta</span></td>
            
                                                    <td class="text-center">
                                                        <a href="#" class="btn btn-sm-custom">View Details</a>
                                                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#remarks" class="ms-2 cmnt-icon"><i class="uil uil-info-circle"></i></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><img src="{{ asset('images/icons/vehiche02.png') }}" alt="icon" class="driver-img-sm"></td>
                                                    <td>
                                                        <span class="value">WB-12-AB-7650</span>
                                                    </td>
                                                    <td><span class="value">Andrew Jackson</span><br/><span class="value">+91 9187654321</span></td>
                                                    
                                                    <td><span class="value">12/01/2026<br/>12.00 PM</span></td>
                                                    
                                                    <td><span class="value">Ambar Singh</span></td>
                                                    
                                                    <td><span class="value">#LR001100<br/>12/09/2025</span></td>
                                                    
                                                    <td><span class="value">DEL - HYD</span></td>
                                                    
                                                    <!--<td><span class="value">Ankur Maheta</span></td>-->
                                                    
                                                    <td><span class="value">CR Park</span><br/><span class="value">+91 9087654321</span></td>
                                                    
                                                    <td><span class="value">15 Hr 10 Min</span></td>
                                                    
                                                    <td><span class="value">Suresh Dhar</span></td>
            
                                                    <td class="text-center">
                                                        <a href="#" class="btn btn-sm-custom">View Details</a>
                                                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#remarks" class="ms-2 cmnt-icon"><i class="uil uil-info-circle"></i></a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!--sr_dashboard0_table-->
                      </div>
                      
                      <div class="tab-pane fade" id="pills-unloading" role="tabpanel" aria-labelledby="pills-unloading-tab">
                          <div class="accordion mt-2" id="accordionExample">
                              <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                  <button class="accordion-button filter-options" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    <div class="item-filter">
                                        <div class="filter">
                                            <span class="filter-icon">
                                                <img src="{{ asset('images/icons/filter-01icon.png') }}" alt="icon">
                                            </span>
                                        </div>
                                        <p class="mb-0">Filter Options</p>
                                    </div>
                                  </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                  <div class="accordion-body">
                                    <form>
                                        <input type="hidden" name="status" id="status">
                                        <div class="filtersearch-bd justify-content-between">
                                            
                                            <div class="vehicletype ms-1">
                                                <label>Fleet Status</label>
                                                <select class="form-select">
                                                    <option value="">Choose..</option>
                                                    @foreach($fleetstatuses as $status)
                                                    <option value="{{ $status->id }}">{{ $status->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            
                                            <div class="vehicletype ms-1">
                                                <label>Vehicle Group</label>
                                                <select class="form-select">
                                                    <option value="">Choose..</option>
                                                    @foreach($vehiclegroup as $value)
                                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            
                                            <div class="vehicletype ms-1">
                                                <label>Ownership</label>
                                                <select class="form-select">
                                                    <option value="">Choose..</option>
                                                    <option value="Own">Own</option>
                                                    <option value="Rental">Rental</option>
                                                </select>
                                            </div>
                                            
                                            <div class="vehicletype ms-1">
                                                <label>Last Trip</label>
                                                <select class="form-select select2">
                                                    <option>Choose..</option>
                                                    <option>HYD - PUNE</option>
                                                    <option>HYD - DEL</option>
                                                </select>
                                            </div>
                                            
                                            
                                            <div class="vehicletype ms-1">
                                                <label>Unloading Date</label>
                                                <div id="reportrange" class="form-control" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                                    <i class="fa fa-calendar"></i>&nbsp;
                                                    <span></span> <i class="fa fa-caret-down"></i>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="filtersearch-bd justify-content-start mt-3">
                                            
                                            <div class="ms-1" style="width: 180px;">
                                                <div class="input-group">
                                                  <input type="text" class="form-control" placeholder="Search by Driver">
                                                  <span class="input-group-text"><i class="uil uil-search"></i></span>
                                                  <!--<span class="input-group-text"><i class="uil uil-sync me-1"></i></span>-->
                                                </div>
                                            </div>
                                            
                                            <div class="ms-1" style="width: 200px;">
                                                <div class="input-group">
                                                  <input type="text" class="form-control" placeholder="Search by Manager">
                                                  <span class="input-group-text"><i class="uil uil-search"></i></span>
                                                  <!--<span class="input-group-text"><i class="uil uil-sync me-1"></i></span>-->
                                                </div>
                                            </div>
                                            
                                            <div class="ms-1" style="width: 240px;">
                                                <div class="input-group">
                                                  <input type="text" class="form-control" placeholder="Search by Location">
                                                  <span class="input-group-text"><i class="uil uil-search"></i></span>
                                                  <!--<span class="input-group-text"><i class="uil uil-sync me-1"></i></span>-->
                                                </div>
                                            </div>
                                            
                                            <div class="ms-1" style="width: 220px;">
                                                <div class="input-group">
                                                  <input type="text" class="form-control" placeholder="Search by Vehicle #">
                                                  <span class="input-group-text"><i class="uil uil-search"></i></span>
                                                  <!--<span class="input-group-text"><i class="uil uil-sync me-1"></i></span>-->
                                                </div>
                                            </div>
                                            
                                            <a href="{{ route('fleetdashboard.index') }}" class="btn btn-primary ms-1"><i class="uil uil-sync me-1"></i>Reset</a>
                                            
                                            <div class="dropdown ms-1">
                                              <button class="btn btn-primary dropdown-toggle" type="button" id="exportBtn" data-bs-toggle="dropdown" aria-expanded="false">
                                                Export <i class="uil uil-upload ms-1"></i>
                                              </button>
                                              <ul class="dropdown-menu" aria-labelledby="exportBtn">
                                                <li><a class="dropdown-item" href="javascript:void(0)">Excel</a></li>
                                                <li><a class="dropdown-item" href="javascript:void(0)">PDF</a></li>
                                              </ul>
                                            </div>
                                        </div>
                                    </form>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <!--sr_dashboard0_table-->
                            <div class="sr_dashboard0_table">
                                <div class="container-fluid">
                                    
                                    <div class="table-responsive">
                                        <table class="table custom-driver-table">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th style="min-width: 120px">Vehicle Number</th>
                                                    <th style="min-width: 120px">Current Driver</th>
                                                    <th>Unloading Since</th>
                                                    <th>Customer</th>
                                                    <th>LR#<br/>Date</th>
                                                    <th>Last Trip</th>
                                                    <!--<th>Contact</th>-->
                                                    <th>Location<br/>Contact</th>
                                                    <th>Avg. Unload Time</th>
                                                    <th>Managed By</th>
                                                    <th class="text-center">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody id="fleetTableBody_5">
                                                <tr>
                                                    <td><img src="{{ asset('images/icons/vehiche01.png') }}" alt="icon" class="driver-img-sm"></td>
                                                    <td>
                                                        <span class="value">WB-12-AB-1234</span>
                                                    </td>
                                                    <td><span class="value">Sujoy Ghosh</span><br/><span class="value">+91 9087654321</span></td>
                                                    
                                                    <td><span class="value">12/01/2026<br/>01:03 PM</span></td>
                                                    
                                                    <td><span class="value">Neelesh Maheta</span></td>
                                                    
                                                    <td><span class="value">#LR001123<br/>12/09/2025</span></td>
                                                    
                                                    <td><span class="value">DEL - PUN</span></td>
                                                    
                                                    <!--<td><span class="value">Anuj Maheta</span></td>-->
                                                    
                                                    <td><span class="value">Sarojini</span><br/><span class="value">+91 8097654322</span></td>
                                                    
                                                    <td><span class="value">10 Hr 12 Min</span></td>
                                                    
                                                    <td><span class="value">Anuj Maheta</span></td>
            
                                                    <td class="text-center">
                                                        <a href="#" class="btn btn-sm-custom">View Details</a>
                                                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#remarks" class="ms-2 cmnt-icon"><i class="uil uil-info-circle"></i></a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!--sr_dashboard0_table-->
                      </div>
                      
                      <div class="tab-pane fade" id="pills-on_the_way" role="tabpanel" aria-labelledby="pills-on_the_way-tab">
                          <div class="accordion mt-2" id="accordionExample">
                              <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                  <button class="accordion-button filter-options" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    <div class="item-filter">
                                        <div class="filter">
                                            <span class="filter-icon">
                                                <img src="{{ asset('images/icons/filter-01icon.png') }}" alt="icon">
                                            </span>
                                        </div>
                                        <p class="mb-0">Filter Options</p>
                                    </div>
                                  </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                  <div class="accordion-body">
                                    <form>
                                        <input type="hidden" name="status" id="status">
                                        <div class="filtersearch-bd justify-content-between">
                                            <div class="vehicletype ms-1">
                                                <label>Fleet Status</label>
                                                <select class="form-select">
                                                    <option value="">Choose..</option>
                                                    @foreach($fleetstatuses as $status)
                                                    <option value="{{ $status->id }}">{{ $status->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            
                                            <div class="vehicletype ms-1">
                                                <label>Vehicle Group</label>
                                                <select class="form-select">
                                                    @foreach($vehiclegroup as $value)
                                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            
                                            <div class="vehicletype ms-1">
                                                <label>Last Trip</label>
                                                <select class="form-select select2">
                                                    <option>Choose..</option>
                                                    <option>HYD - PUNE</option>
                                                    <option>HYD - DEL</option>
                                                </select>
                                            </div>
                                            
                                            <div class="vehicletype ms-1">
                                                <label>Actual Start Date</label>
                                                <div id="reportrange" class="form-control" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                                    <i class="fa fa-calendar"></i>&nbsp;
                                                    <span></span> <i class="fa fa-caret-down"></i>
                                                </div>
                                            </div>
                                            
                                            <div class="vehicletype ms-1">
                                                <label>Expected Delivery Date</label>
                                                <div id="reportrange" class="form-control" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                                    <i class="fa fa-calendar"></i>&nbsp;
                                                    <span></span> <i class="fa fa-caret-down"></i>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="filtersearch-bd justify-content-start mt-3">
                                            <div class="ms-1" style="width: 180px;">
                                                <div class="input-group">
                                                  <input type="text" class="form-control" placeholder="Search by Driver">
                                                  <span class="input-group-text"><i class="uil uil-search"></i></span>
                                                </div>
                                            </div>
                                            
                                            <div class="ms-1" style="width: 200px;">
                                                <div class="input-group">
                                                  <input type="text" class="form-control" placeholder="Search by Manager">
                                                  <span class="input-group-text"><i class="uil uil-search"></i></span>
                                                </div>
                                            </div>
                                            
                                            <div class="ms-1" style="width: 240px;">
                                                <div class="input-group">
                                                  <input type="text" class="form-control" placeholder="Search by Customer">
                                                  <span class="input-group-text"><i class="uil uil-search"></i></span>
                                                  <!--<span class="input-group-text"><i class="uil uil-sync me-1"></i></span>-->
                                                </div>
                                            </div>
                                            
                                            <div class="ms-1" style="width: 220px;">
                                                <div class="input-group">
                                                  <input type="text" class="form-control" placeholder="Search by Vehicle #">
                                                  <span class="input-group-text"><i class="uil uil-search"></i></span>
                                                  <!--<span class="input-group-text"><i class="uil uil-sync me-1"></i></span>-->
                                                </div>
                                            </div>
                                            
                                            <a href="{{ route('fleetdashboard.index') }}" class="btn btn-primary ms-1"><i class="uil uil-sync me-1"></i>Reset</a>
                                            
                                            <div class="dropdown ms-1">
                                              <button class="btn btn-primary dropdown-toggle" type="button" id="exportBtn" data-bs-toggle="dropdown" aria-expanded="false">
                                                Export <i class="uil uil-upload ms-1"></i>
                                              </button>
                                              <ul class="dropdown-menu" aria-labelledby="exportBtn">
                                                <li><a class="dropdown-item" href="javascript:void(0)">Excel</a></li>
                                                <li><a class="dropdown-item" href="javascript:void(0)">PDF</a></li>
                                              </ul>
                                            </div>
                                        </div>
                                    </form>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <!--sr_dashboard0_table-->
                            <div class="sr_dashboard0_table">
                                <div class="container-fluid">
                                    <div class="table-responsive">
                                        <table class="table custom-driver-table">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th style="min-width: 120px">Vehicle Number</th>
                                                    <th style="min-width: 120px">Current Driver</th>
                                                    <th>Actual Start</th>
                                                    <th>Expected Delivery</th>
                                                    <th>Trip Calculated</th>
                                                    <th>Status</th>
                                                    <th>Customer</th>
                                                    <th>LR#<br/>Date</th>
                                                    <th>Managed By</th>
                                                    <th class="text-center">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody id="fleetTableBody_1">
                                                <tr>
                                                    <td><img src="{{ asset('images/icons/vehiche01.png') }}" alt="icon" class="driver-img-sm"></td>
                                                    <td>
                                                        <span class="value">WB-12-AB-1234</span>
                                                    </td>
                                                    <td><span class="value">Sujoy Ghosh</span><br/><span class="value">+91 9087654321</span></td>
                                                    
                                                    <td><span class="value">02/01/2026<br/>01:00 PM</span></td>
                                                    
                                                    <td><span class="value">12/01/2026<br/>12:00 PM</span></td>
                                                    
                                                    <td>
                                                        <span class="tag">90%</span>
                                                    </td>
                                                    
                                                    <td>
                                                        <span class="badge bg-success">On Time</span>
                                                    </td>
                                                    
                                                    <td><span class="value">Neelesh Maheta</span></td>
                                                    
                                                    <td><span class="value">#LR001123<br/>12/09/2025</span></td>
                                                    
                                                    <td><span class="value">Anuj Maheta</span></td>
            
                                                    <td class="text-center">
                                                        <a href="#" class="btn btn-sm-custom">View Details</a>
                                                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#remarks" class="ms-2 cmnt-icon"><i class="uil uil-info-circle"></i></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><img src="{{ asset('images/icons/vehiche03.png') }}" alt="icon" class="driver-img-sm"></td>
                                                    <td>
                                                        <span class="value">WB-12-AB-1235</span>
                                                    </td>
                                                    <td><span class="value">Anit Ghosh</span><br/><span class="value">+91 9087654321</span></td>
                                                    
                                                    <td><span class="value">02/01/2026<br/>01:00 PM</span></td>
                                                    
                                                    <td><span class="value">12/01/2026<br/>12:00 PM</span></td>
                                                    
                                                    <td>
                                                        <span class="tag">90%</span>
                                                    </td>
                                                    
                                                    <td>
                                                        <span class="badge bg-warning">Delayed</span>
                                                    </td>
                                                    
                                                    <td><span class="value">Suresh Maheta</span></td>
                                                    
                                                    <td><span class="value">#LR001123<br/>12/09/2025</span></td>
                                                    
                                                    <td><span class="value">Mishin Maheta</span></td>
            
                                                    <td class="text-center">
                                                        <a href="#" class="btn btn-sm-custom">View Details</a>
                                                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#remarks" class="ms-2 cmnt-icon"><i class="uil uil-info-circle"></i></a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!--sr_dashboard0_table-->
                      </div>
                      
                      <div class="tab-pane fade" id="pills-attached_vehicle" role="tabpanel" aria-labelledby="pills-attached_vehicle-tab">
                          <div class="accordion mt-2" id="accordionExample">
                              <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                  <button class="accordion-button filter-options" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    <div class="item-filter">
                                        <div class="filter">
                                            <span class="filter-icon">
                                                <img src="{{ asset('images/icons/filter-01icon.png') }}" alt="icon">
                                            </span>
                                        </div>
                                        <p class="mb-0">Filter Options</p>
                                    </div>
                                  </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                  <div class="accordion-body">
                                    <form>
                                        <input type="hidden" name="status" id="status">
                                        <div class="filtersearch-bd justify-content-between">

                                            <div class="vehicletype ms-1">
                                                <label>Tracking Group</label>
                                                <select class="form-select select2">
                                                    <option value="">Choose..</option>
                                                    <option>Tracking A</option>
                                                    <option>Tracking B</option>
                                                </select>
                                            </div>

                                            <div class="vehicletype ms-1">
                                                <label>Remaining KM</label>
                                                <select class="form-select">
                                                    <option value="">Choose..</option>
                                                    <option>0 - 1000</option>
                                                    <option>1000 - 5000</option>
                                                    <option>5000+</option>
                                                </select>
                                            </div>

                                            <div class="vehicletype ms-1">
                                                <label>Extra Run Km</label>
                                                <select class="form-select">
                                                    <option value="">Choose..</option>
                                                    <option>0 - 500</option>
                                                    <option>500 - 2000</option>
                                                    <option>2000+</option>
                                                </select>
                                            </div>

                                            <div class="vehicletype ms-1">
                                                <label>End Date</label>
                                                <div id="reportrange" class="form-control" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                                    <i class="fa fa-calendar"></i>&nbsp;
                                                    <span></span> <i class="fa fa-caret-down"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="filtersearch-bd justify-content-start mt-3">

                                            <div class="ms-1" style="width: 240px;">
                                                <div class="input-group">
                                                  <input type="text" class="form-control" placeholder="Search by Customer">
                                                  <span class="input-group-text"><i class="uil uil-search"></i></span>
                                                </div>
                                            </div>

                                            <div class="ms-1" style="width: 220px;">
                                                <div class="input-group">
                                                  <input type="text" class="form-control" placeholder="Search by Vehicle #">
                                                  <span class="input-group-text"><i class="uil uil-search"></i></span>
                                                </div>
                                            </div>

                                            <a href="{{ route('fleetdashboard.index') }}" class="btn btn-primary ms-1"><i class="uil uil-sync me-1"></i>Reset</a>

                                            <div class="dropdown ms-1">
                                              <button class="btn btn-primary dropdown-toggle" type="button" id="exportBtn" data-bs-toggle="dropdown" aria-expanded="false">
                                                Export <i class="uil uil-upload ms-1"></i>
                                              </button>
                                              <ul class="dropdown-menu" aria-labelledby="exportBtn">
                                                <li><a class="dropdown-item" href="javascript:void(0)">Excel</a></li>
                                                <li><a class="dropdown-item" href="javascript:void(0)">PDF</a></li>
                                              </ul>
                                            </div>
                                        </div>
                                    </form>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <!--sr_dashboard0_table-->
                            <div class="sr_dashboard0_table">
                                <div class="container-fluid">
                                    <div class="table-responsive">
                                        <table class="table custom-driver-table">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th style="min-width: 120px">Vehicle Number</th>
                                                    <th style="min-width: 140px">Current Driver</th>
                                                    <th>Tracking Group</th>
                                                    <th>Current Status</th>
                                                    <th>Customer</th>
                                                    <th>Fixed KM</th>
                                                    <th>Remaining KM</th>
                                                    <th>Extra Run KM</th>
                                                    <th>Trips<br/>Completed</th>
                                                    <th>Fixed Amount</th>
                                                    <th>Fixed Amt/KM</th>
                                                    <th>Extra Run Amount</th>
                                                    <th>Extra Amt/KM</th>
                                                    <th>Start Date</th>
                                                    <th>End Date</th>
                                                    <th class="text-center">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody id="fleetTableBody_attached">
                                                <tr>
                                                    <td><img src="{{ asset('images/icons/vehiche01.png') }}" alt="icon" class="driver-img-sm"></td>
                                                    <td><span class="value">WB-12-AB-1234</span></td>
                                                    <td><span class="value">Sujoy Ghosh</span><br/><span class="value">DRV-1021</span></td>
                                                    <td><span class="value">Tracking A</span></td>
                                                    <td><span class="badge bg-success">On The Way</span></td>
                                                    <td><span class="value">Neelesh Maheta</span></td>
                                                    <td><span class="value">10,000</span></td>
                                                    <td><span class="value">3,500</span></td>
                                                    <td><span class="value">450</span></td>
                                                    <td><span class="value">12</span></td>
                                                    <td><span class="value">₹ 2,50,000</span></td>
                                                    <td><span class="value">₹ 25.00</span></td>
                                                    <td><span class="value">₹ 13,500</span></td>
                                                    <td><span class="value">₹ 30.00</span></td>
                                                    <td><span class="value">01/01/2026</span></td>
                                                    <td><span class="value">31/03/2026</span></td>
                                                    <td class="text-center">
                                                        <a href="#" class="btn btn-sm-custom">View Details</a>
                                                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#remarks" class="ms-2 cmnt-icon"><i class="uil uil-info-circle"></i></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><img src="{{ asset('images/icons/vehiche03.png') }}" alt="icon" class="driver-img-sm"></td>
                                                    <td><span class="value">WB-12-AB-1235</span></td>
                                                    <td><span class="value">Ramen Singh</span><br/><span class="value">DRV-1044</span></td>
                                                    <td><span class="value">Tracking B</span></td>
                                                    <td><span class="badge bg-secondary">Empty</span></td>
                                                    <td><span class="value">Ambar Singh</span></td>
                                                    <td><span class="value">8,000</span></td>
                                                    <td><span class="value">1,200</span></td>
                                                    <td><span class="value">0</span></td>
                                                    <td><span class="value">9</span></td>
                                                    <td><span class="value">₹ 2,00,000</span></td>
                                                    <td><span class="value">₹ 25.00</span></td>
                                                    <td><span class="value">₹ 0</span></td>
                                                    <td><span class="value">₹ 28.00</span></td>
                                                    <td><span class="value">15/01/2026</span></td>
                                                    <td><span class="value">14/04/2026</span></td>
                                                    <td class="text-center">
                                                        <a href="#" class="btn btn-sm-custom">View Details</a>
                                                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#remarks" class="ms-2 cmnt-icon"><i class="uil uil-info-circle"></i></a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!--sr_dashboard0_table-->
                      </div>

                      <div class="tab-pane fade" id="pills-maintenance" role="tabpanel" aria-labelledby="pills-maintenance-tab">
                          <div class="mtn-subtab-wrap">
                              <ul class="nav nav-pills mtn-subtabs" id="mtnSubTab" role="tablist">
                                  <li class="nav-item" role="presentation">
                                    <button class="nav-link mtn-subtab active" id="mtn-repair-tab" data-bs-toggle="pill" data-bs-target="#mtn-repair" type="button" role="tab" aria-controls="mtn-repair" aria-selected="true"><span class="icon"><i class="uil uil-wrench"></i></span>Repair</button>
                                  </li>
                                  <li class="nav-item" role="presentation">
                                    <button class="nav-link mtn-subtab" id="mtn-completed-tab" data-bs-toggle="pill" data-bs-target="#mtn-completed" type="button" role="tab" aria-controls="mtn-completed" aria-selected="false"><span class="icon"><i class="uil uil-check-circle"></i></span>Completed Scheduled Maintenance</button>
                                  </li>
                                  <li class="nav-item" role="presentation">
                                    <button class="nav-link mtn-subtab" id="mtn-upcoming-tab" data-bs-toggle="pill" data-bs-target="#mtn-upcoming" type="button" role="tab" aria-controls="mtn-upcoming" aria-selected="false"><span class="icon"><i class="uil uil-calendar-alt"></i></span>Upcoming Scheduled Maintenance</button>
                                  </li>
                                  <li class="nav-item" role="presentation">
                                    <button class="nav-link mtn-subtab" id="mtn-accidental-tab" data-bs-toggle="pill" data-bs-target="#mtn-accidental" type="button" role="tab" aria-controls="mtn-accidental" aria-selected="false"><span class="icon"><i class="uil uil-exclamation-triangle"></i></span>Accidental repair</button>
                                  </li>
                                  <li class="nav-item" role="presentation">
                                    <button class="nav-link mtn-subtab" id="mtn-def-tab" data-bs-toggle="pill" data-bs-target="#mtn-def" type="button" role="tab" aria-controls="mtn-def" aria-selected="false"><span class="icon"><i class="uil uil-tear"></i></span>DEF</button>
                                  </li>
                                  <li class="nav-item" role="presentation">
                                    <button class="nav-link mtn-subtab" id="mtn-tirpal-tab" data-bs-toggle="pill" data-bs-target="#mtn-tirpal" type="button" role="tab" aria-controls="mtn-tirpal" aria-selected="false"><span class="icon"><i class="uil uil-link-h"></i></span>Tirpal &amp; Rope</button>
                                  </li>
                                  <li class="nav-item" role="presentation">
                                    <button class="nav-link mtn-subtab" id="mtn-tagged-tab" data-bs-toggle="pill" data-bs-target="#mtn-tagged" type="button" role="tab" aria-controls="mtn-tagged" aria-selected="false"><span class="icon"><i class="uil uil-tag-alt"></i></span>Tagged Assets</button>
                                  </li>
                              </ul>

                              <div class="tab-content" id="mtnSubTabContent">

                              <div class="tab-pane fade show active" id="mtn-repair" role="tabpanel" aria-labelledby="mtn-repair-tab">
                                  <!-- Repair · mini-dashboard -->
                                  <div class="mtn-mini-row">
                                      <div class="mtn-mini-card mtn-mini-own">
                                          <span class="mtn-mini-icon"><i class="uil uil-store-alt"></i></span>
                                          <p class="mtn-mini-title">Own Workshop</p>
                                          <p class="mtn-mini-amt">&#8377;4,85,200</p>
                                          <span class="mtn-mini-qty">38 jobs</span>
                                      </div>
                                      <div class="mtn-mini-card mtn-mini-out">
                                          <span class="mtn-mini-icon"><i class="uil uil-map-marker"></i></span>
                                          <p class="mtn-mini-title">Outside Workshop</p>
                                          <p class="mtn-mini-amt">&#8377;7,12,450</p>
                                          <span class="mtn-mini-qty">52 jobs</span>
                                      </div>
                                      <div class="mtn-mini-card mtn-mini-elec">
                                          <span class="mtn-mini-icon"><i class="uil uil-bolt-alt"></i></span>
                                          <p class="mtn-mini-title">Electrical</p>
                                          <p class="mtn-mini-amt">&#8377;1,96,300</p>
                                          <span class="mtn-mini-qty">24 jobs</span>
                                      </div>
                                      <div class="mtn-mini-card mtn-mini-mech">
                                          <span class="mtn-mini-icon"><i class="uil uil-wrench"></i></span>
                                          <p class="mtn-mini-title">Mechanical</p>
                                          <p class="mtn-mini-amt">&#8377;8,40,150</p>
                                          <span class="mtn-mini-qty">47 jobs</span>
                                      </div>
                                      <div class="mtn-mini-card mtn-mini-body">
                                          <span class="mtn-mini-icon"><i class="uil uil-truck"></i></span>
                                          <p class="mtn-mini-title">Body Work</p>
                                          <p class="mtn-mini-amt">&#8377;1,61,200</p>
                                          <span class="mtn-mini-qty">19 jobs</span>
                                      </div>
                                  </div>

                                  <!-- Repair · filter card -->
                                  <div class="accordion" id="mtnRepairAccordion">
                                      <div class="accordion-item">
                                          <h2 class="accordion-header" id="mtnRepairHeading">
                                              <button class="accordion-button filter-options" type="button" data-bs-toggle="collapse" data-bs-target="#mtnRepairCollapse" aria-expanded="true" aria-controls="mtnRepairCollapse">
                                                  <div class="item-filter">
                                                      <div class="filter">
                                                          <span class="filter-icon">
                                                              <img src="{{ asset('images/icons/filter-01icon.png') }}" alt="icon">
                                                          </span>
                                                      </div>
                                                      <p class="mb-0">Filter Options</p>
                                                  </div>
                                              </button>
                                          </h2>
                                          <div id="mtnRepairCollapse" class="accordion-collapse collapse show" aria-labelledby="mtnRepairHeading" data-bs-parent="#mtnRepairAccordion">
                                              <div class="accordion-body">
                                                  <form action="{{ route('fleetdashboard.index') }}" id="mtnRepairFilterForm">

                                                      <div class="filtersearch-bd mtn-filter-search">
                                                          <div class="input-group">
                                                              <input type="text" name="mtn_rep_q" id="mtnRepSearch" class="form-control" placeholder="Search anything — spare part, invoice number, repair work, vendor, driver…">
                                                              <span class="input-group-text"><i class="uil uil-search"></i></span>
                                                          </div>
                                                      </div>

                                                      <div class="filtersearch-bd mtn-filter-grid mt-3">
                                                  <div class="vehicletype">
                                                      <label for="mtnRepDateRange">Date Range</label>
                                                      <div id="mtnRepDateRange" class="form-control mtn-daterange">
                                                          <i class="fa fa-calendar"></i>
                                                          <span>01/06/2026 - 08/07/2026</span>
                                                          <i class="fa fa-caret-down ms-auto"></i>
                                                      </div>
                                                  </div>

                                                  <div class="vehicletype">
                                                      <label for="mtnRepVehicle">Vehicle</label>
                                                      <select class="form-select" id="mtnRepVehicle">
                                                          <option value="">Choose..</option>

                                                          @foreach($vehicles as $rv)
                                                          <option value="{{ $rv->vehicle_no }}">{{ $rv->vehicle_no }}</option>
                                                          @endforeach
                                                      </select>
                                                  </div>

                                                  <div class="vehicletype">
                                                      <label for="mtnRepBrand">Brand &amp; Model</label>
                                                      <select class="form-select" id="mtnRepBrand">
                                                          <option value="">Choose..</option>
                                                          <option value="Tata Signa 4825.TK">Tata Signa 4825.TK</option>
                                                          <option value="Ashok Leyland 3520">Ashok Leyland 3520</option>
                                                          <option value="BharatBenz 4823">BharatBenz 4823</option>
                                                          <option value="Eicher Pro 5040">Eicher Pro 5040</option>
                                                      </select>
                                                  </div>

                                                  <div class="vehicletype">
                                                      <label for="mtnRepGroup">Tracking Group</label>
                                                      <select class="form-select" id="mtnRepGroup">
                                                          <option value="">Choose..</option>

                                                          @foreach($vehiclegroup as $rg)
                                                          <option value="{{ $rg->id }}">{{ $rg->name }}</option>
                                                          @endforeach
                                                      </select>
                                                  </div>

                                                  <div class="vehicletype">
                                                      <label for="mtnRepDriver">Driver Name</label>
                                                      <select class="form-select" id="mtnRepDriver">
                                                          <option value="">Choose..</option>
                                                          <option value="Sujoy Ghosh (DRV-1042)">Sujoy Ghosh (DRV-1042)</option>
                                                          <option value="Ramen Singh (DRV-1078)">Ramen Singh (DRV-1078)</option>
                                                          <option value="Suresh Nayak (DRV-1103)">Suresh Nayak (DRV-1103)</option>
                                                      </select>
                                                  </div>

                                                  <div class="vehicletype">
                                                      <label for="mtnRepWork">Work</label>
                                                      <select class="form-select" id="mtnRepWork">
                                                          <option value="">Choose..</option>
                                                          <option value="Major">Major</option>
                                                          <option value="Minor">Minor</option>
                                                      </select>
                                                  </div>

                                                  <div class="vehicletype">
                                                      <label for="mtnRepWorkshop">Workshop</label>
                                                      <select class="form-select" id="mtnRepWorkshop">
                                                          <option value="">Choose..</option>
                                                          <option value="Own">Own</option>
                                                          <option value="Outside">Outside</option>
                                                      </select>
                                                  </div>

                                                  <div class="vehicletype">
                                                      <label for="mtnRepCategory">Repair Category</label>
                                                      <select class="form-select" id="mtnRepCategory">
                                                          <option value="">Choose..</option>
                                                          <option value="Electrical">Electrical</option>
                                                          <option value="Mechanical">Mechanical</option>
                                                          <option value="Body Work">Body Work</option>
                                                      </select>
                                                  </div>

                                                  <div class="vehicletype">
                                                      <label for="mtnRepVendor">Vendor Name</label>
                                                      <select class="form-select" id="mtnRepVendor">
                                                          <option value="">Choose..</option>
                                                          <option value="Tata Motors Service">Tata Motors Service</option>
                                                          <option value="Maruti Auto Care">Maruti Auto Care</option>
                                                          <option value="SR Own Workshop — Delhi">SR Own Workshop — Delhi</option>
                                                          <option value="Sri Balaji Body Works">Sri Balaji Body Works</option>
                                                      </select>
                                                  </div>

                                                  <div class="vehicletype">
                                                      <label for="mtnRepGst">GST Bill Received</label>
                                                      <select class="form-select" id="mtnRepGst">
                                                          <option value="">Choose..</option>
                                                          <option value="Yes">Yes</option>
                                                          <option value="No">No</option>
                                                      </select>
                                                  </div>
                                                      </div>

                                                      <div class="filtersearch-bd mtn-filter-actions mt-3">
                                                          <a href="{{ route('fleetdashboard.index') }}" class="btn btn-primary"><i class="uil uil-sync me-1"></i>Reset</a>
                                                          <div class="dropdown ms-1">
                                                              <button class="btn btn-primary dropdown-toggle" type="button" id="mtnRepExportBtn" data-bs-toggle="dropdown" aria-expanded="false">
                                                                  Export <i class="uil uil-upload ms-1"></i>
                                                              </button>
                                                              <ul class="dropdown-menu" aria-labelledby="mtnRepExportBtn">
                                                                  <li><a class="dropdown-item" href="javascript:void(0)">Excel</a></li>
                                                                  <li><a class="dropdown-item" href="javascript:void(0)">PDF</a></li>
                                                              </ul>
                                                          </div>
                                                      </div>

                                                  </form>
                                              </div>
                                          </div>
                                      </div>
                                  </div>

                                  <!-- Repair · table list -->
                                  <div class="sr_dashboard0_table">
                                      <div class="container-fluid">
                                          <div class="table-responsive mtn-table-scroll">
                                              <table class="table custom-driver-table mtn-wide-table mtn-repair-table">
                                                  <thead>
                                                      <tr>
                                                          <th class="mtn-col-icon"></th>
                                                          <th class="mtn-col-veh">Vehicle Number</th>
                                                          <th>Brand &amp; Model</th>
                                                          <th>Emission Norms</th>
                                                          <th>Tracking Group</th>
                                                          <th>Driver Name &amp; Code</th>
                                                          <th>Date</th>
                                                          <th>Odometer Reading</th>
                                                          <th>Workshop</th>
                                                          <th>Work</th>
                                                          <th>Repair Category</th>
                                                          <th>Repair Work</th>
                                                          <th>Repair Start</th>
                                                          <th>Repair End</th>
                                                          <th>Mode of Payment</th>
                                                          <th>GST Bill Applicable</th>
                                                          <th>GST Bill Received</th>
                                                          <th>Invoice Number</th>
                                                          <th>Total Invoice</th>
                                                          <th>Spare Parts</th>
                                                          <th>Labour</th>
                                                          <th>Workshop Name &amp; Contact</th>
                                                          <th>Workshop Location</th>
                                                          <th class="text-center">Attachment</th>
                                                          <th>Work Full Details</th>
                                                          <th>Comment / Note</th>
                                                          <th class="text-center mtn-col-act">Actions</th>
                                                      </tr>
                                                  </thead>
                                                  <tbody id="mtnRepairTableBody">
                                                      <tr>
                                                          <td class="mtn-col-icon"><img src="{{ asset('images/icons/vehiche01.png') }}" alt="icon" class="driver-img-sm"></td>
                                                          <td class="mtn-col-veh"><span class="value">WB-12-AB-1234</span></td>
                                                          <td><span class="value">Tata Signa 4825.TK</span></td>
                                                          <td><span class="mtn-tag mtn-tag-norm">BS6</span><span class="mtn-tag mtn-tag-obd">OBD 2</span></td>
                                                          <td><span class="value">Tracking A</span></td>
                                                          <td><span class="value">Sujoy Ghosh</span><br><span class="value mtn-sub">DRV-1042</span></td>
                                                          <td><span class="value">10/01/2026</span></td>
                                                          <td><span class="value">2,84,530 km</span></td>
                                                          <td><span class="mtn-tag mtn-tag-own">Own</span><br><a href="{{ route('ws.workshop.job-details', 1) }}" class="mtn-link">Job Card</a></td>
                                                          <td><span class="mtn-tag mtn-tag-major">Major</span></td>
                                                          <td><span class="mtn-tag mtn-tag-mech">Mechanical</span></td>
                                                          <td><span class="value mtn-wrap">Gearbox overhaul &amp; clutch plate replacement</span></td>
                                                          <td><span class="value">10/01/2026 09:30 AM</span></td>
                                                          <td><span class="value">12/01/2026 06:15 PM</span></td>
                                                          <td><span class="value">Net Banking</span></td>
                                                          <td><span class="mtn-tag mtn-tag-yes">Yes</span></td>
                                                          <td><span class="mtn-tag mtn-tag-yes">Yes</span></td>
                                                          <td><span class="value">INV-2026-00841</span></td>
                                                          <td><span class="mtn-amt"><span class="mtn-amt-row"><em>Taxable</em>&#8377;1,42,000</span><span class="mtn-amt-row"><em>GST</em>&#8377;25,560</span><span class="mtn-amt-row mtn-amt-total"><em>Total</em>&#8377;1,67,560</span></span></td>
                                                          <td><span class="mtn-amt"><span class="mtn-amt-row"><em>Taxable</em>&#8377;98,000</span><span class="mtn-amt-row"><em>GST</em>&#8377;17,640</span><span class="mtn-amt-row mtn-amt-total"><em>Total</em>&#8377;1,15,640</span></span></td>
                                                          <td><span class="mtn-amt"><span class="mtn-amt-row"><em>Taxable</em>&#8377;44,000</span><span class="mtn-amt-row"><em>GST</em>&#8377;7,920</span><span class="mtn-amt-row mtn-amt-total"><em>Total</em>&#8377;51,920</span></span></td>
                                                          <td><span class="value">SR Own Workshop — Delhi</span><br><span class="value mtn-sub">+91 9087654321</span></td>
                                                          <td><span class="value mtn-wrap">Sector 18, Naraina, New Delhi</span></td>
                                                          <td class="text-center"><a href="javascript:void(0)" class="mtn-attach" data-attach-title="WB-12-AB-1234 — Bill" data-attach-files="[{&quot;name&quot;: &quot;invoice-WB12AB1234.pdf&quot;, &quot;type&quot;: &quot;pdf&quot;, &quot;size&quot;: &quot;412 KB&quot;}, {&quot;name&quot;: &quot;workshop-bill-WB12AB1234.jpg&quot;, &quot;type&quot;: &quot;jpg&quot;, &quot;size&quot;: &quot;1.8 MB&quot;}]"><i class="uil uil-paperclip"></i>Bill</a></td>
                                                          <td><span class="value mtn-wrap mtn-clamp" title="Complete gearbox teardown. Replaced clutch plate, pressure plate, release bearing and both layshaft bearings. Gear oil flushed and refilled (GL-5 80W-90, 12 L). 3 technicians x 2 days.">Complete gearbox teardown. Replaced clutch plate, pressure plate, release bearing and both layshaft bearings. Gear oil flushed and refilled (GL-5 80W-90, 12 L). 3 technicians x 2 days.</span></td>
                                                          <td><span class="value mtn-wrap mtn-clamp" title="Vehicle released after road test. Next inspection at 3,00,000 km.">Vehicle released after road test. Next inspection at 3,00,000 km.</span></td>
                                                          <td class="text-center mtn-col-act">
                                                              <a href="javascript:void(0)" class="btn btn-sm-custom">View</a>
                                                              <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#remarks" class="ms-2 cmnt-icon"><i class="uil uil-info-circle"></i></a>
                                                          </td>
                                                      </tr>
                                                      <tr>
                                                          <td class="mtn-col-icon"><img src="{{ asset('images/icons/vehiche03.png') }}" alt="icon" class="driver-img-sm"></td>
                                                          <td class="mtn-col-veh"><span class="value">WB-12-AB-1236</span></td>
                                                          <td><span class="value">Ashok Leyland 3520</span></td>
                                                          <td><span class="mtn-tag mtn-tag-norm">BS6</span><span class="mtn-tag mtn-tag-obd">OBD 1</span></td>
                                                          <td><span class="value">Tracking B</span></td>
                                                          <td><span class="value">Ramen Singh</span><br><span class="value mtn-sub">DRV-1078</span></td>
                                                          <td><span class="value">18/02/2026</span></td>
                                                          <td><span class="value">1,96,210 km</span></td>
                                                          <td><span class="mtn-tag mtn-tag-ext">External</span></td>
                                                          <td><span class="mtn-tag mtn-tag-minor">Minor</span></td>
                                                          <td><span class="mtn-tag mtn-tag-elec">Electrical</span></td>
                                                          <td><span class="value mtn-wrap">Alternator rewinding &amp; battery terminal replacement</span></td>
                                                          <td><span class="value">18/02/2026 11:00 AM</span></td>
                                                          <td><span class="value">18/02/2026 04:40 PM</span></td>
                                                          <td><span class="value">UPI</span></td>
                                                          <td><span class="mtn-tag mtn-tag-yes">Yes</span></td>
                                                          <td><span class="mtn-tag mtn-tag-no">No</span></td>
                                                          <td><span class="value">INV-2026-00902</span></td>
                                                          <td><span class="mtn-amt"><span class="mtn-amt-row"><em>Taxable</em>&#8377;18,400</span><span class="mtn-amt-row"><em>GST</em>&#8377;3,312</span><span class="mtn-amt-row mtn-amt-total"><em>Total</em>&#8377;21,712</span></span></td>
                                                          <td><span class="mtn-amt"><span class="mtn-amt-row"><em>Taxable</em>&#8377;12,900</span><span class="mtn-amt-row"><em>GST</em>&#8377;2,322</span><span class="mtn-amt-row mtn-amt-total"><em>Total</em>&#8377;15,222</span></span></td>
                                                          <td><span class="mtn-amt"><span class="mtn-amt-row"><em>Taxable</em>&#8377;5,500</span><span class="mtn-amt-row"><em>GST</em>&#8377;990</span><span class="mtn-amt-row mtn-amt-total"><em>Total</em>&#8377;6,490</span></span></td>
                                                          <td><span class="value">Maruti Auto Care</span><br><span class="value mtn-sub">+91 9087654320</span></td>
                                                          <td><span class="value mtn-wrap">Kukatpally, Hyderabad</span></td>
                                                          <td class="text-center"><a href="javascript:void(0)" class="mtn-attach" data-attach-title="WB-12-AB-1236 — Bill" data-attach-files="[{&quot;name&quot;: &quot;invoice-WB12AB1236.pdf&quot;, &quot;type&quot;: &quot;pdf&quot;, &quot;size&quot;: &quot;412 KB&quot;}, {&quot;name&quot;: &quot;workshop-bill-WB12AB1236.jpg&quot;, &quot;type&quot;: &quot;jpg&quot;, &quot;size&quot;: &quot;1.8 MB&quot;}]"><i class="uil uil-paperclip"></i>Bill</a></td>
                                                          <td><span class="value mtn-wrap mtn-clamp" title="Alternator removed, stator rewound, diode plate replaced. Both battery terminals and the earth strap renewed. Charging output verified at 28.2 V.">Alternator removed, stator rewound, diode plate replaced. Both battery terminals and the earth strap renewed. Charging output verified at 28.2 V.</span></td>
                                                          <td><span class="value mtn-wrap mtn-clamp" title="GST bill pending from vendor — follow up before 28 Feb.">GST bill pending from vendor — follow up before 28 Feb.</span></td>
                                                          <td class="text-center mtn-col-act">
                                                              <a href="javascript:void(0)" class="btn btn-sm-custom">View</a>
                                                              <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#remarks" class="ms-2 cmnt-icon"><i class="uil uil-info-circle"></i></a>
                                                          </td>
                                                      </tr>
                                                      <tr>
                                                          <td class="mtn-col-icon"><img src="{{ asset('images/icons/vehiche01.png') }}" alt="icon" class="driver-img-sm"></td>
                                                          <td class="mtn-col-veh"><span class="value">TS09QA3962</span></td>
                                                          <td><span class="value">BharatBenz 4823</span></td>
                                                          <td><span class="mtn-tag mtn-tag-norm">BS4</span></td>
                                                          <td><span class="value">Tracking A</span></td>
                                                          <td><span class="value">Suresh Nayak</span><br><span class="value mtn-sub">DRV-1103</span></td>
                                                          <td><span class="value">03/03/2026</span></td>
                                                          <td><span class="value">3,41,875 km</span></td>
                                                          <td><span class="mtn-tag mtn-tag-ext">External</span></td>
                                                          <td><span class="mtn-tag mtn-tag-major">Major</span></td>
                                                          <td><span class="mtn-tag mtn-tag-body">Body Work</span></td>
                                                          <td><span class="value mtn-wrap">Cabin panel straightening &amp; full repaint</span></td>
                                                          <td><span class="value">03/03/2026 08:00 AM</span></td>
                                                          <td><span class="value">07/03/2026 05:30 PM</span></td>
                                                          <td><span class="value">Market-pe</span></td>
                                                          <td><span class="mtn-tag mtn-tag-no">No</span></td>
                                                          <td><span class="mtn-tag mtn-tag-no">No</span></td>
                                                          <td><span class="value">—</span></td>
                                                          <td><span class="mtn-amt"><span class="mtn-amt-row"><em>Taxable</em>&#8377;76,500</span><span class="mtn-amt-row"><em>GST</em>&#8377;0</span><span class="mtn-amt-row mtn-amt-total"><em>Total</em>&#8377;76,500</span></span></td>
                                                          <td><span class="mtn-amt"><span class="mtn-amt-row"><em>Taxable</em>&#8377;41,000</span><span class="mtn-amt-row"><em>GST</em>&#8377;0</span><span class="mtn-amt-row mtn-amt-total"><em>Total</em>&#8377;41,000</span></span></td>
                                                          <td><span class="mtn-amt"><span class="mtn-amt-row"><em>Taxable</em>&#8377;35,500</span><span class="mtn-amt-row"><em>GST</em>&#8377;0</span><span class="mtn-amt-row mtn-amt-total"><em>Total</em>&#8377;35,500</span></span></td>
                                                          <td><span class="value">Sri Balaji Body Works</span><br><span class="value mtn-sub">+91 9012345678</span></td>
                                                          <td><span class="value mtn-wrap">Medchal Road, Hyderabad</span></td>
                                                          <td class="text-center"><a href="javascript:void(0)" class="mtn-attach" data-attach-title="TS09QA3962 — Bill" data-attach-files="[{&quot;name&quot;: &quot;invoice-TS09QA3962.pdf&quot;, &quot;type&quot;: &quot;pdf&quot;, &quot;size&quot;: &quot;412 KB&quot;}, {&quot;name&quot;: &quot;workshop-bill-TS09QA3962.jpg&quot;, &quot;type&quot;: &quot;jpg&quot;, &quot;size&quot;: &quot;1.8 MB&quot;}]"><i class="uil uil-paperclip"></i>Bill</a></td>
                                                          <td><span class="value mtn-wrap mtn-clamp" title="Left cabin door skin and rear quarter panel dent-pulled, filler applied, primed and repainted in fleet livery. Windscreen rubber beading replaced.">Left cabin door skin and rear quarter panel dent-pulled, filler applied, primed and repainted in fleet livery. Windscreen rubber beading replaced.</span></td>
                                                          <td><span class="value mtn-wrap mtn-clamp" title="Cash job, no GST invoice. Photos attached.">Cash job, no GST invoice. Photos attached.</span></td>
                                                          <td class="text-center mtn-col-act">
                                                              <a href="javascript:void(0)" class="btn btn-sm-custom">View</a>
                                                              <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#remarks" class="ms-2 cmnt-icon"><i class="uil uil-info-circle"></i></a>
                                                          </td>
                                                      </tr>
                                                  </tbody>
                                              </table>
                                          </div>
                                      </div>
                                  </div>
                              </div>

                              <div class="tab-pane fade" id="mtn-completed" role="tabpanel" aria-labelledby="mtn-completed-tab">
                                  <!-- Completed Scheduled Maintenance · mini-dashboard -->
                                  <div class="mtn-mini-row">
                                      <div class="mtn-mini-card mtn-mini-cost">
                                          <span class="mtn-mini-icon"><i class="uil uil-invoice"></i></span>
                                          <p class="mtn-mini-title">Maintenance Cost</p>
                                          <p class="mtn-mini-amt">&#8377;12,64,900</p>
                                          <span class="mtn-mini-qty">62 services</span>
                                      </div>
                                      <div class="mtn-mini-card mtn-mini-total">
                                          <span class="mtn-mini-icon"><i class="uil uil-clipboard-notes"></i></span>
                                          <p class="mtn-mini-title">Total Scheduled Service</p>
                                          <p class="mtn-mini-amt">78</p>
                                          <span class="mtn-mini-qty">services</span>
                                      </div>
                                      <div class="mtn-mini-card mtn-mini-done">
                                          <span class="mtn-mini-icon"><i class="uil uil-check-circle"></i></span>
                                          <p class="mtn-mini-title">Completed Scheduled Service</p>
                                          <p class="mtn-mini-amt">62</p>
                                          <span class="mtn-mini-qty">services</span>
                                      </div>
                                      <div class="mtn-mini-card mtn-mini-missed">
                                          <span class="mtn-mini-icon"><i class="uil uil-times-circle"></i></span>
                                          <p class="mtn-mini-title">Missed Scheduled Service</p>
                                          <p class="mtn-mini-amt">5</p>
                                          <span class="mtn-mini-qty">services</span>
                                      </div>
                                      <div class="mtn-mini-card mtn-mini-pending">
                                          <span class="mtn-mini-icon"><i class="uil uil-clock"></i></span>
                                          <p class="mtn-mini-title">Pending Scheduled Service</p>
                                          <p class="mtn-mini-amt">11</p>
                                          <span class="mtn-mini-qty">services</span>
                                      </div>
                                  </div>

                                  <!-- Completed Scheduled Maintenance · filter card -->
                                  <div class="accordion" id="csmAccordion">
                                      <div class="accordion-item">
                                          <h2 class="accordion-header" id="csmHeading">
                                              <button class="accordion-button filter-options" type="button" data-bs-toggle="collapse" data-bs-target="#csmCollapse" aria-expanded="true" aria-controls="csmCollapse">
                                                  <div class="item-filter">
                                                      <div class="filter">
                                                          <span class="filter-icon">
                                                              <img src="{{ asset('images/icons/filter-01icon.png') }}" alt="icon">
                                                          </span>
                                                      </div>
                                                      <p class="mb-0">Filter Options</p>
                                                  </div>
                                              </button>
                                          </h2>
                                          <div id="csmCollapse" class="accordion-collapse collapse show" aria-labelledby="csmHeading" data-bs-parent="#csmAccordion">
                                              <div class="accordion-body">
                                                  <form action="{{ route('fleetdashboard.index') }}" id="csmFilterForm">

                                                      <div class="filtersearch-bd mtn-filter-search">
                                                          <div class="input-group">
                                                              <input type="text" name="csm_q" id="csmSearch" class="form-control" placeholder="Search anything — spare part, invoice number, service name, vendor, driver…">
                                                              <span class="input-group-text"><i class="uil uil-search"></i></span>
                                                          </div>
                                                      </div>

                                                      <div class="filtersearch-bd mtn-filter-grid mt-3">
                                                  <div class="vehicletype">
                                                      <label for="csmDateRange">Date Range</label>
                                                      <div id="csmDateRange" class="form-control mtn-daterange">
                                                          <i class="fa fa-calendar"></i>
                                                          <span>01/06/2026 - 08/07/2026</span>
                                                          <i class="fa fa-caret-down ms-auto"></i>
                                                      </div>
                                                  </div>

                                                  <div class="vehicletype">
                                                      <label for="csmVehicle">Vehicle</label>
                                                      <select class="form-select" id="csmVehicle">
                                                          <option value="">Choose..</option>
                                                          @foreach($vehicles as $cv)
                                                          <option value="{{ $cv->vehicle_no }}">{{ $cv->vehicle_no }}</option>
                                                          @endforeach
                                                      </select>
                                                  </div>

                                                  <div class="vehicletype">
                                                      <label for="csmBrand">Brand &amp; Model</label>
                                                      <select class="form-select" id="csmBrand">
                                                          <option value="">Choose..</option>
                                                          <option value="Tata Signa 4825.TK">Tata Signa 4825.TK</option>
                                                          <option value="Ashok Leyland 3520">Ashok Leyland 3520</option>
                                                          <option value="BharatBenz 4823">BharatBenz 4823</option>
                                                          <option value="Eicher Pro 5040">Eicher Pro 5040</option>
                                                      </select>
                                                  </div>

                                                  <div class="vehicletype">
                                                      <label for="csmGroup">Tracking Group</label>
                                                      <select class="form-select" id="csmGroup">
                                                          <option value="">Choose..</option>
                                                          @foreach($vehiclegroup as $cg)
                                                          <option value="{{ $cg->id }}">{{ $cg->name }}</option>
                                                          @endforeach
                                                      </select>
                                                  </div>

                                                  <div class="vehicletype">
                                                      <label for="csmDriver">Driver Name</label>
                                                      <select class="form-select" id="csmDriver">
                                                          <option value="">Choose..</option>
                                                          <option value="Sujoy Ghosh (DRV-1042)">Sujoy Ghosh (DRV-1042)</option>
                                                          <option value="Ramen Singh (DRV-1078)">Ramen Singh (DRV-1078)</option>
                                                          <option value="Suresh Nayak (DRV-1103)">Suresh Nayak (DRV-1103)</option>
                                                      </select>
                                                  </div>

                                                  <div class="vehicletype">
                                                      <label for="csmStatus">Maintenance Status</label>
                                                      <select class="form-select" id="csmStatus">
                                                          <option value="">Choose..</option>
                                                          <option value="On Time">On Time</option>
                                                          <option value="Delay">Delay</option>
                                                          <option value="Missed">Missed</option>
                                                          <option value="Pending">Pending</option>
                                                      </select>
                                                  </div>

                                                  <div class="vehicletype">
                                                      <label for="csmWorkshop">Workshop</label>
                                                      <select class="form-select" id="csmWorkshop">
                                                          <option value="">Choose..</option>
                                                          <option value="Own">Own</option>
                                                          <option value="External">External</option>
                                                      </select>
                                                  </div>

                                                  <div class="vehicletype">
                                                      <label for="csmVendor">Vendor Name</label>
                                                      <select class="form-select" id="csmVendor">
                                                          <option value="">Choose..</option>
                                                          <option value="Tata Motors Service">Tata Motors Service</option>
                                                          <option value="Maruti Auto Care">Maruti Auto Care</option>
                                                          <option value="SR Own Workshop — Delhi">SR Own Workshop — Delhi</option>
                                                          <option value="BharatBenz Authorised Service">BharatBenz Authorised Service</option>
                                                      </select>
                                                  </div>

                                                  <div class="vehicletype">
                                                      <label for="csmGst">GST Bill Received</label>
                                                      <select class="form-select" id="csmGst">
                                                          <option value="">Choose..</option>
                                                          <option value="Yes">Yes</option>
                                                          <option value="No">No</option>
                                                      </select>
                                                  </div>
                                                      </div>

                                                      <div class="filtersearch-bd mtn-filter-actions mt-3">
                                                          <a href="{{ route('fleetdashboard.index') }}" class="btn btn-primary"><i class="uil uil-sync me-1"></i>Reset</a>
                                                          <div class="dropdown ms-1">
                                                              <button class="btn btn-primary dropdown-toggle" type="button" id="csmExportBtn" data-bs-toggle="dropdown" aria-expanded="false">
                                                                  Export <i class="uil uil-upload ms-1"></i>
                                                              </button>
                                                              <ul class="dropdown-menu" aria-labelledby="csmExportBtn">
                                                                  <li><a class="dropdown-item" href="javascript:void(0)">Excel</a></li>
                                                                  <li><a class="dropdown-item" href="javascript:void(0)">PDF</a></li>
                                                              </ul>
                                                          </div>
                                                      </div>

                                                  </form>
                                              </div>
                                          </div>
                                      </div>
                                  </div>

                                  <!-- Completed Scheduled Maintenance · table list -->
                                  <div class="sr_dashboard0_table">
                                      <div class="container-fluid">
                                          <div class="table-responsive mtn-table-scroll">
                                              <table class="table custom-driver-table mtn-wide-table mtn-csm-table">
                                                  <thead>
                                                      <tr>
                                                          <th class="mtn-col-icon"></th>
                                                          <th class="mtn-col-veh">Vehicle Number</th>
                                                          <th>Brand &amp; Model</th>
                                                          <th>Emission Norms</th>
                                                          <th>Tracking Group</th>
                                                          <th>Driver Name &amp; Code</th>
                                                          <th>Date</th>
                                                          <th>Odometer Reading</th>
                                                          <th>Workshop</th>
                                                          <th>Maintenance Service Name</th>
                                                          <th>Maintenance</th>
                                                          <th>Schedule Maintenance Status</th>
                                                          <th>Scheduled Service KM &amp; Months</th>
                                                          <th>Actual Service KM &amp; Months</th>
                                                          <th>Maintenance Cost</th>
                                                          <th>Vendor Name &amp; Contact</th>
                                                          <th>Workshop Location</th>
                                                          <th>Invoice Number</th>
                                                          <th>GST Bill Applicable</th>
                                                          <th>GST Bill Received</th>
                                                          <th class="text-center">Attachments</th>
                                                          <th class="text-center mtn-col-act">Full Work Done Details</th>
                                                      </tr>
                                                  </thead>
                                                  <tbody id="mtnCsmTableBody">
                                                      <tr>
                                                          <td class="mtn-col-icon"><img src="{{ asset('images/icons/vehiche01.png') }}" alt="icon" class="driver-img-sm"></td>
                                                          <td class="mtn-col-veh"><span class="value">WB-12-AB-1234</span></td>
                                                          <td><span class="value">Tata Signa 4825.TK</span></td>
                                                          <td><span class="mtn-tag mtn-tag-norm">BS6</span><span class="mtn-tag mtn-tag-obd">OBD 2</span></td>
                                                          <td><span class="value">Tracking A</span></td>
                                                          <td><span class="value">Sujoy Ghosh</span><br><span class="value mtn-sub">DRV-1042</span></td>
                                                          <td><span class="value">14/01/2026</span></td>
                                                          <td><span class="value">2,85,120 km</span></td>
                                                          <td><span class="mtn-tag mtn-tag-own">Own</span><br><a href="{{ route('ws.workshop.job-details', 1) }}" class="mtn-link">Job Card</a></td>
                                                          <td><span class="value">3rd Service</span></td>
                                                          <td><span class="mtn-tag mtn-tag-day">Day</span></td>
                                                          <td><span class="mtn-tag mtn-tag-ontime">On Time</span></td>
                                                          <td><span class="value mtn-nowrap">40,000 km / 12 months</span></td>
                                                          <td><span class="value mtn-nowrap">39,400 km / 11 months</span></td>
                                                          <td><span class="mtn-amt"><span class="mtn-amt-row"><em>Taxable</em>&#8377;26,500</span><span class="mtn-amt-row"><em>GST</em>&#8377;4,770</span><span class="mtn-amt-row mtn-amt-total"><em>Total</em>&#8377;31,270</span></span></td>
                                                          <td><span class="value">SR Own Workshop — Delhi</span><br><span class="value mtn-sub">+91 9087654321</span></td>
                                                          <td><span class="value mtn-wrap">Sector 18, Naraina, New Delhi</span></td>
                                                          <td><span class="value">INV-2026-00858</span></td>
                                                          <td><span class="mtn-tag mtn-tag-yes">Yes</span></td>
                                                          <td><span class="mtn-tag mtn-tag-yes">Yes</span></td>
                                                          <td class="text-center"><a href="javascript:void(0)" class="mtn-attach" data-attach-title="WB-12-AB-1234 — Bill" data-attach-files="[{&quot;name&quot;: &quot;invoice-WB12AB1234.pdf&quot;, &quot;type&quot;: &quot;pdf&quot;, &quot;size&quot;: &quot;412 KB&quot;}, {&quot;name&quot;: &quot;workshop-bill-WB12AB1234.jpg&quot;, &quot;type&quot;: &quot;jpg&quot;, &quot;size&quot;: &quot;1.8 MB&quot;}]"><i class="uil uil-paperclip"></i>Bill</a></td>
                                                          <td class="text-center mtn-col-act"><a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#remarks" class="mtn-attach" title="Engine oil + filter, fuel filter, air filter, cabin filter replaced. Brake pads inspected (68% remaining). Coolant topped up. Wheel alignment and balancing done. Chassis greased at 14 points."><i class="uil uil-eye"></i>View Details</a></td>
                                                      </tr>
                                                      <tr>
                                                          <td class="mtn-col-icon"><img src="{{ asset('images/icons/vehiche03.png') }}" alt="icon" class="driver-img-sm"></td>
                                                          <td class="mtn-col-veh"><span class="value">WB-12-AB-1236</span></td>
                                                          <td><span class="value">Ashok Leyland 3520</span></td>
                                                          <td><span class="mtn-tag mtn-tag-norm">BS6</span><span class="mtn-tag mtn-tag-obd">OBD 1</span></td>
                                                          <td><span class="value">Tracking B</span></td>
                                                          <td><span class="value">Ramen Singh</span><br><span class="value mtn-sub">DRV-1078</span></td>
                                                          <td><span class="value">22/02/2026</span></td>
                                                          <td><span class="value">1,97,640 km</span></td>
                                                          <td><span class="mtn-tag mtn-tag-ext">External</span></td>
                                                          <td><span class="value">2nd Service</span></td>
                                                          <td><span class="mtn-tag mtn-tag-hours">Hours</span></td>
                                                          <td><span class="mtn-tag mtn-tag-delay">Delay</span></td>
                                                          <td><span class="value mtn-nowrap">30,000 km / 09 months</span></td>
                                                          <td><span class="value mtn-nowrap">31,850 km / 10 months</span></td>
                                                          <td><span class="mtn-amt"><span class="mtn-amt-row"><em>Taxable</em>&#8377;19,200</span><span class="mtn-amt-row"><em>GST</em>&#8377;3,456</span><span class="mtn-amt-row mtn-amt-total"><em>Total</em>&#8377;22,656</span></span></td>
                                                          <td><span class="value">Maruti Auto Care</span><br><span class="value mtn-sub">+91 9087654320</span></td>
                                                          <td><span class="value mtn-wrap">Kukatpally, Hyderabad</span></td>
                                                          <td><span class="value">INV-2026-00915</span></td>
                                                          <td><span class="mtn-tag mtn-tag-yes">Yes</span></td>
                                                          <td><span class="mtn-tag mtn-tag-no">No</span></td>
                                                          <td class="text-center"><a href="javascript:void(0)" class="mtn-attach" data-attach-title="WB-12-AB-1236 — Bill" data-attach-files="[{&quot;name&quot;: &quot;invoice-WB12AB1236.pdf&quot;, &quot;type&quot;: &quot;pdf&quot;, &quot;size&quot;: &quot;412 KB&quot;}, {&quot;name&quot;: &quot;workshop-bill-WB12AB1236.jpg&quot;, &quot;type&quot;: &quot;jpg&quot;, &quot;size&quot;: &quot;1.8 MB&quot;}]"><i class="uil uil-paperclip"></i>Bill</a></td>
                                                          <td class="text-center mtn-col-act"><a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#remarks" class="mtn-attach" title="Scheduled 250-hour service. Engine oil and all four filters replaced. AdBlue dosing module cleaned. Turbo hoses inspected, one clamp renewed. Battery electrolyte topped up."><i class="uil uil-eye"></i>View Details</a></td>
                                                      </tr>
                                                      <tr>
                                                          <td class="mtn-col-icon"><img src="{{ asset('images/icons/vehiche01.png') }}" alt="icon" class="driver-img-sm"></td>
                                                          <td class="mtn-col-veh"><span class="value">TS09QA3962</span></td>
                                                          <td><span class="value">BharatBenz 4823</span></td>
                                                          <td><span class="mtn-tag mtn-tag-norm">BS4</span></td>
                                                          <td><span class="value">Tracking A</span></td>
                                                          <td><span class="value">Suresh Nayak</span><br><span class="value mtn-sub">DRV-1103</span></td>
                                                          <td><span class="value">11/03/2026</span></td>
                                                          <td><span class="value">3,42,410 km</span></td>
                                                          <td><span class="mtn-tag mtn-tag-ext">External</span></td>
                                                          <td><span class="value">5th Service</span></td>
                                                          <td><span class="mtn-tag mtn-tag-day">Day</span></td>
                                                          <td><span class="mtn-tag mtn-tag-ontime">On Time</span></td>
                                                          <td><span class="value mtn-nowrap">60,000 km / 18 months</span></td>
                                                          <td><span class="value mtn-nowrap">59,300 km / 17 months</span></td>
                                                          <td><span class="mtn-amt"><span class="mtn-amt-row"><em>Taxable</em>&#8377;34,800</span><span class="mtn-amt-row"><em>GST</em>&#8377;6,264</span><span class="mtn-amt-row mtn-amt-total"><em>Total</em>&#8377;41,064</span></span></td>
                                                          <td><span class="value">BharatBenz Authorised Service</span><br><span class="value mtn-sub">+91 9012345678</span></td>
                                                          <td><span class="value mtn-wrap">Medchal Road, Hyderabad</span></td>
                                                          <td><span class="value">INV-2026-00961</span></td>
                                                          <td><span class="mtn-tag mtn-tag-yes">Yes</span></td>
                                                          <td><span class="mtn-tag mtn-tag-yes">Yes</span></td>
                                                          <td class="text-center"><a href="javascript:void(0)" class="mtn-attach" data-attach-title="TS09QA3962 — Bill" data-attach-files="[{&quot;name&quot;: &quot;invoice-TS09QA3962.pdf&quot;, &quot;type&quot;: &quot;pdf&quot;, &quot;size&quot;: &quot;412 KB&quot;}, {&quot;name&quot;: &quot;workshop-bill-TS09QA3962.jpg&quot;, &quot;type&quot;: &quot;jpg&quot;, &quot;size&quot;: &quot;1.8 MB&quot;}]"><i class="uil uil-paperclip"></i>Bill</a></td>
                                                          <td class="text-center mtn-col-act"><a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#remarks" class="mtn-attach" title="Major scheduled service. Engine oil, oil filter, fuel filters (primary + secondary), air filter and coolant fully replaced. Propeller shaft UJ crosses renewed. Brake liners changed on rear axle. Injector spray pattern tested."><i class="uil uil-eye"></i>View Details</a></td>
                                                      </tr>
                                                  </tbody>
                                              </table>
                                          </div>
                                      </div>
                                  </div>
                              </div>

                              <div class="tab-pane fade" id="mtn-upcoming" role="tabpanel" aria-labelledby="mtn-upcoming-tab">
                                  <!-- Upcoming Scheduled Maintenance · mini-dashboard -->
                                  <div class="mtn-mini-row">
                                      <div class="mtn-mini-card mtn-mini-total">
                                          <span class="mtn-mini-icon"><i class="uil uil-clipboard-notes"></i></span>
                                          <p class="mtn-mini-title">Total Upcoming</p>
                                          <p class="mtn-mini-amt">34</p>
                                          <span class="mtn-mini-qty">services</span>
                                      </div>
                                      <div class="mtn-mini-card mtn-mini-duekm">
                                          <span class="mtn-mini-icon"><i class="uil uil-tachometer-fast"></i></span>
                                          <p class="mtn-mini-title">Due Within 5,000 KM</p>
                                          <p class="mtn-mini-amt">12</p>
                                          <span class="mtn-mini-qty">services</span>
                                      </div>
                                      <div class="mtn-mini-card mtn-mini-duedays">
                                          <span class="mtn-mini-icon"><i class="uil uil-calendar-alt"></i></span>
                                          <p class="mtn-mini-title">Due Within 30 Days</p>
                                          <p class="mtn-mini-amt">17</p>
                                          <span class="mtn-mini-qty">services</span>
                                      </div>
                                      <div class="mtn-mini-card mtn-mini-missed">
                                          <span class="mtn-mini-icon"><i class="uil uil-times-circle"></i></span>
                                          <p class="mtn-mini-title">Missed</p>
                                          <p class="mtn-mini-amt">5</p>
                                          <span class="mtn-mini-qty">services</span>
                                      </div>
                                      <div class="mtn-mini-card mtn-mini-pending">
                                          <span class="mtn-mini-icon"><i class="uil uil-clock"></i></span>
                                          <p class="mtn-mini-title">Pending</p>
                                          <p class="mtn-mini-amt">29</p>
                                          <span class="mtn-mini-qty">services</span>
                                      </div>
                                  </div>

                                  <!-- Upcoming Scheduled Maintenance · filter card -->
                                  <div class="accordion" id="usmAccordion">
                                      <div class="accordion-item">
                                          <h2 class="accordion-header" id="usmHeading">
                                              <button class="accordion-button filter-options" type="button" data-bs-toggle="collapse" data-bs-target="#usmCollapse" aria-expanded="true" aria-controls="usmCollapse">
                                                  <div class="item-filter">
                                                      <div class="filter">
                                                          <span class="filter-icon">
                                                              <img src="{{ asset('images/icons/filter-01icon.png') }}" alt="icon">
                                                          </span>
                                                      </div>
                                                      <p class="mb-0">Filter Options</p>
                                                  </div>
                                              </button>
                                          </h2>
                                          <div id="usmCollapse" class="accordion-collapse collapse show" aria-labelledby="usmHeading" data-bs-parent="#usmAccordion">
                                              <div class="accordion-body">
                                                  <form action="{{ route('fleetdashboard.index') }}" id="usmFilterForm">

                                                      <div class="filtersearch-bd mtn-filter-grid">
                                                  <div class="vehicletype">
                                                      <label for="usmDateRange">Date Range</label>
                                                      <div id="usmDateRange" class="form-control mtn-daterange">
                                                          <i class="fa fa-calendar"></i>
                                                          <span>01/06/2026 - 08/07/2026</span>
                                                          <i class="fa fa-caret-down ms-auto"></i>
                                                      </div>
                                                  </div>

                                                  <div class="vehicletype">
                                                      <label for="usmVehicle">Vehicle Number</label>
                                                      <select class="form-select" id="usmVehicle">
                                                          <option value="">Choose..</option>
                                                          @foreach($vehicles as $uv)
                                                          <option value="{{ $uv->vehicle_no }}">{{ $uv->vehicle_no }}</option>
                                                          @endforeach
                                                      </select>
                                                  </div>

                                                  <div class="vehicletype">
                                                      <label for="usmGroup">Tracking Group</label>
                                                      <select class="form-select" id="usmGroup">
                                                          <option value="">Choose..</option>
                                                          @foreach($vehiclegroup as $ug)
                                                          <option value="{{ $ug->id }}">{{ $ug->name }}</option>
                                                          @endforeach
                                                      </select>
                                                  </div>

                                                  <div class="vehicletype">
                                                      <label for="usmService">Maintenance Name</label>
                                                      <select class="form-select" id="usmService">
                                                          <option value="">Choose..</option>
                                                          <option value="1st Service">1st Service</option>
                                                          <option value="2nd Service">2nd Service</option>
                                                          <option value="3rd Service">3rd Service</option>
                                                          <option value="5th Service">5th Service</option>
                                                          <option value="2,00,000 KM Service">2,00,000 KM Service</option>
                                                          <option value="3,00,000 KM Service">3,00,000 KM Service</option>
                                                      </select>
                                                  </div>

                                                  <div class="vehicletype">
                                                      <label for="usmBrand">Brand</label>
                                                      <select class="form-select" id="usmBrand">
                                                          <option value="">Choose..</option>
                                                          <option value="Tata">Tata</option>
                                                          <option value="Ashok Leyland">Ashok Leyland</option>
                                                          <option value="BharatBenz">BharatBenz</option>
                                                          <option value="Eicher">Eicher</option>
                                                      </select>
                                                  </div>

                                                  <div class="vehicletype">
                                                      <label for="usmModel">Model</label>
                                                      <select class="form-select" id="usmModel">
                                                          <option value="">Choose..</option>
                                                          <option value="Signa 4825.TK">Signa 4825.TK</option>
                                                          <option value="3520">3520</option>
                                                          <option value="4823">4823</option>
                                                          <option value="Pro 5040">Pro 5040</option>
                                                      </select>
                                                  </div>

                                                  <div class="vehicletype">
                                                      <label for="usmNorms">Emission Norms</label>
                                                      <select class="form-select" id="usmNorms">
                                                          <option value="">Choose..</option>
                                                          <option value="BS4">BS4</option>
                                                          <option value="BS6">BS6</option>
                                                      </select>
                                                  </div>

                                                  <div class="vehicletype">
                                                      <label for="usmObd">BS6 Norms</label>
                                                      <select class="form-select" id="usmObd">
                                                          <option value="">Choose..</option>
                                                          <option value="OBD 1">OBD 1</option>
                                                          <option value="OBD 2">OBD 2</option>
                                                      </select>
                                                  </div>
                                                      </div>

                                                      <div class="filtersearch-bd mtn-filter-actions mt-3">
                                                          <a href="{{ route('fleetdashboard.index') }}" class="btn btn-primary"><i class="uil uil-sync me-1"></i>Reset</a>
                                                          <div class="dropdown ms-1">
                                                              <button class="btn btn-primary dropdown-toggle" type="button" id="usmExportBtn" data-bs-toggle="dropdown" aria-expanded="false">
                                                                  Export <i class="uil uil-upload ms-1"></i>
                                                              </button>
                                                              <ul class="dropdown-menu" aria-labelledby="usmExportBtn">
                                                                  <li><a class="dropdown-item" href="javascript:void(0)">Excel</a></li>
                                                                  <li><a class="dropdown-item" href="javascript:void(0)">PDF</a></li>
                                                              </ul>
                                                          </div>
                                                      </div>

                                                  </form>
                                              </div>
                                          </div>
                                      </div>
                                  </div>

                                  <!-- Upcoming Scheduled Maintenance · table list -->
                                  <div class="sr_dashboard0_table">
                                      <div class="container-fluid">
                                          <div class="table-responsive mtn-table-scroll">
                                              <table class="table custom-driver-table mtn-wide-table mtn-usm-table">
                                                  <thead>
                                                      <tr>
                                                          <th class="mtn-col-icon"></th>
                                                          <th class="mtn-col-veh">Vehicle Number</th>
                                                          <th>Brand &amp; Model</th>
                                                          <th>Emission Norms</th>
                                                          <th>BS6 Phase Norms</th>
                                                          <th>Tracking Group</th>
                                                          <th>Driver Name &amp; Code</th>
                                                          <th>Workshop</th>
                                                          <th>Maintenance Service Name</th>
                                                          <th>Maintenance</th>
                                                          <th>Scheduled Service Status</th>
                                                          <th>Scheduled Service KM &amp; Months</th>
                                                          <th>KM &amp; Months Remaining</th>
                                                          <th class="text-center">Attachments</th>
                                                      </tr>
                                                  </thead>
                                                  <tbody id="mtnUsmTableBody">
                                                      <tr>
                                                          <td class="mtn-col-icon"><img src="{{ asset('images/icons/vehiche01.png') }}" alt="icon" class="driver-img-sm"></td>
                                                          <td class="mtn-col-veh"><span class="value">WB-12-AB-1234</span></td>
                                                          <td><span class="value">Tata Signa 4825.TK</span></td>
                                                          <td><span class="mtn-tag mtn-tag-norm">BS6</span></td>
                                                          <td><span class="mtn-tag mtn-tag-obd">OBD 2</span></td>
                                                          <td><span class="value">Tracking A</span></td>
                                                          <td><span class="value">Sujoy Ghosh</span><br><span class="value mtn-sub">DRV-1042</span></td>
                                                          <td><span class="mtn-tag mtn-tag-own">Own</span><br><a href="{{ route('ws.workshop.job-details', 1) }}" class="mtn-link">Job Card</a></td>
                                                          <td><span class="value">4th Service</span></td>
                                                          <td><span class="mtn-tag mtn-tag-major">Major</span></td>
                                                          <td><span class="mtn-tag mtn-tag-pending">Pending</span></td>
                                                          <td><span class="value mtn-nowrap">50,000 km / 15 months</span></td>
                                                          <td><span class="value mtn-nowrap">3,880 km / 2 months</span></td>
                                                          <td class="text-center"><a href="javascript:void(0)" class="mtn-attach" data-attach-title="WB-12-AB-1234 — Files" data-attach-files="[{&quot;name&quot;: &quot;service-schedule-WB12AB1234.pdf&quot;, &quot;type&quot;: &quot;pdf&quot;, &quot;size&quot;: &quot;198 KB&quot;}, {&quot;name&quot;: &quot;inspection-checklist-WB12AB1234.jpg&quot;, &quot;type&quot;: &quot;jpg&quot;, &quot;size&quot;: &quot;1.4 MB&quot;}]"><i class="uil uil-paperclip"></i>Files</a></td>
                                                      </tr>
                                                      <tr>
                                                          <td class="mtn-col-icon"><img src="{{ asset('images/icons/vehiche03.png') }}" alt="icon" class="driver-img-sm"></td>
                                                          <td class="mtn-col-veh"><span class="value">WB-12-AB-1236</span></td>
                                                          <td><span class="value">Ashok Leyland 3520</span></td>
                                                          <td><span class="mtn-tag mtn-tag-norm">BS6</span></td>
                                                          <td><span class="mtn-tag mtn-tag-obd">OBD 1</span></td>
                                                          <td><span class="value">Tracking B</span></td>
                                                          <td><span class="value">Ramen Singh</span><br><span class="value mtn-sub">DRV-1078</span></td>
                                                          <td><span class="mtn-tag mtn-tag-ext">External</span></td>
                                                          <td><span class="value">3rd Service</span></td>
                                                          <td><span class="mtn-tag mtn-tag-minor">Minor</span></td>
                                                          <td><span class="mtn-tag mtn-tag-missed">Missed</span></td>
                                                          <td><span class="value mtn-nowrap">40,000 km / 12 months</span></td>
                                                          <td><span class="value mtn-nowrap mtn-overdue">Overdue 1,240 km / 1 month</span></td>
                                                          <td class="text-center"><a href="javascript:void(0)" class="mtn-attach" data-attach-title="WB-12-AB-1236 — Files" data-attach-files="[{&quot;name&quot;: &quot;service-schedule-WB12AB1236.pdf&quot;, &quot;type&quot;: &quot;pdf&quot;, &quot;size&quot;: &quot;198 KB&quot;}, {&quot;name&quot;: &quot;inspection-checklist-WB12AB1236.jpg&quot;, &quot;type&quot;: &quot;jpg&quot;, &quot;size&quot;: &quot;1.4 MB&quot;}]"><i class="uil uil-paperclip"></i>Files</a></td>
                                                      </tr>
                                                      <tr>
                                                          <td class="mtn-col-icon"><img src="{{ asset('images/icons/vehiche01.png') }}" alt="icon" class="driver-img-sm"></td>
                                                          <td class="mtn-col-veh"><span class="value">TS09QA3962</span></td>
                                                          <td><span class="value">BharatBenz 4823</span></td>
                                                          <td><span class="mtn-tag mtn-tag-norm">BS4</span></td>
                                                          <td><span class="value mtn-sub">—</span></td>
                                                          <td><span class="value">Tracking A</span></td>
                                                          <td><span class="value">Suresh Nayak</span><br><span class="value mtn-sub">DRV-1103</span></td>
                                                          <td><span class="mtn-tag mtn-tag-ext">External</span></td>
                                                          <td><span class="value">2,00,000 KM Service</span></td>
                                                          <td><span class="mtn-tag mtn-tag-major">Major</span></td>
                                                          <td><span class="mtn-tag mtn-tag-pending">Pending</span></td>
                                                          <td><span class="value mtn-nowrap">2,00,000 km / 36 months</span></td>
                                                          <td><span class="value mtn-nowrap">7,590 km / 4 months</span></td>
                                                          <td class="text-center"><a href="javascript:void(0)" class="mtn-attach" data-attach-title="TS09QA3962 — Files" data-attach-files="[{&quot;name&quot;: &quot;service-schedule-TS09QA3962.pdf&quot;, &quot;type&quot;: &quot;pdf&quot;, &quot;size&quot;: &quot;198 KB&quot;}, {&quot;name&quot;: &quot;inspection-checklist-TS09QA3962.jpg&quot;, &quot;type&quot;: &quot;jpg&quot;, &quot;size&quot;: &quot;1.4 MB&quot;}]"><i class="uil uil-paperclip"></i>Files</a></td>
                                                      </tr>
                                                  </tbody>
                                              </table>
                                          </div>
                                      </div>
                                  </div>
                              </div>

                              <div class="tab-pane fade" id="mtn-accidental" role="tabpanel" aria-labelledby="mtn-accidental-tab">
                                  <!-- Accidental repair · mini-dashboard -->
                                  <div class="mtn-acc-dash">

                                      <div class="mtn-acc-stats">
                                          <div class="mtn-mini-card mtn-mini-cost">
                                              <span class="mtn-mini-icon"><i class="uil uil-invoice"></i></span>
                                              <p class="mtn-mini-title">Total Repair Cost</p>
                                              <p class="mtn-mini-amt">&#8377;9,84,600</p>
                                              <span class="mtn-mini-qty">17 accidents</span>
                                          </div>
                                          <div class="mtn-mini-card mtn-mini-missed">
                                              <span class="mtn-mini-icon"><i class="uil uil-shield-slash"></i></span>
                                              <p class="mtn-mini-title">Non-Claim Repair Cost</p>
                                              <p class="mtn-mini-amt">&#8377;2,41,300</p>
                                              <span class="mtn-mini-qty">6 accidents</span>
                                          </div>
                                          <div class="mtn-mini-card mtn-mini-pending">
                                              <span class="mtn-mini-icon"><i class="uil uil-balance-scale"></i></span>
                                              <p class="mtn-mini-title">Insurance Excess / Short Amount</p>
                                              <p class="mtn-mini-amt">&#8377;1,12,450</p>
                                              <span class="mtn-mini-qty">short recovery</span>
                                          </div>
                                      </div>

                                      <div class="mtn-rank-grid">
                                          <div class="mtn-rank-card">
                                              <p class="mtn-rank-head"><i class="uil uil-truck"></i>Highest 5 Vehicles — Accidents</p>
                                              <ul class="mtn-rank-list">
                                                  <li class="mtn-rank-row">
                                                      <span class="mtn-rank-pos">1</span>
                                                      <span class="mtn-rank-name">KA51AM 1020</span>
                                                      <span class="mtn-rank-times">5 times</span>
                                                      <span class="mtn-rank-amt">&#8377;2,84,500</span>
                                                  </li>
                                                  <li class="mtn-rank-row">
                                                      <span class="mtn-rank-pos">2</span>
                                                      <span class="mtn-rank-name">KA51AM 3040</span>
                                                      <span class="mtn-rank-times">4 times</span>
                                                      <span class="mtn-rank-amt">&#8377;1,96,200</span>
                                                  </li>
                                                  <li class="mtn-rank-row">
                                                      <span class="mtn-rank-pos">3</span>
                                                      <span class="mtn-rank-name">WB-12-AB-1234</span>
                                                      <span class="mtn-rank-times">3 times</span>
                                                      <span class="mtn-rank-amt">&#8377;1,42,900</span>
                                                  </li>
                                                  <li class="mtn-rank-row">
                                                      <span class="mtn-rank-pos">4</span>
                                                      <span class="mtn-rank-name">TS09QA3962</span>
                                                      <span class="mtn-rank-times">3 times</span>
                                                      <span class="mtn-rank-amt">&#8377;1,08,400</span>
                                                  </li>
                                                  <li class="mtn-rank-row">
                                                      <span class="mtn-rank-pos">5</span>
                                                      <span class="mtn-rank-name">WB-12-AB-1236</span>
                                                      <span class="mtn-rank-times">2 times</span>
                                                      <span class="mtn-rank-amt">&#8377;76,300</span>
                                                  </li>
                                              </ul>
                                          </div>
                                          <div class="mtn-rank-card">
                                              <p class="mtn-rank-head"><i class="uil uil-user"></i>Highest 5 Drivers — Accidents</p>
                                              <ul class="mtn-rank-list">
                                                  <li class="mtn-rank-row">
                                                      <span class="mtn-rank-pos">1</span>
                                                      <span class="mtn-rank-name">Ramesh Yadav<em>DRV-1011</em></span>
                                                      <span class="mtn-rank-times">4 times</span>
                                                      <span class="mtn-rank-amt">&#8377;2,10,600</span>
                                                  </li>
                                                  <li class="mtn-rank-row">
                                                      <span class="mtn-rank-pos">2</span>
                                                      <span class="mtn-rank-name">Parth Mehta<em>DRV-1029</em></span>
                                                      <span class="mtn-rank-times">3 times</span>
                                                      <span class="mtn-rank-amt">&#8377;1,54,200</span>
                                                  </li>
                                                  <li class="mtn-rank-row">
                                                      <span class="mtn-rank-pos">3</span>
                                                      <span class="mtn-rank-name">Sujoy Ghosh<em>DRV-1042</em></span>
                                                      <span class="mtn-rank-times">3 times</span>
                                                      <span class="mtn-rank-amt">&#8377;1,21,800</span>
                                                  </li>
                                                  <li class="mtn-rank-row">
                                                      <span class="mtn-rank-pos">4</span>
                                                      <span class="mtn-rank-name">Ramen Singh<em>DRV-1078</em></span>
                                                      <span class="mtn-rank-times">2 times</span>
                                                      <span class="mtn-rank-amt">&#8377;88,500</span>
                                                  </li>
                                                  <li class="mtn-rank-row">
                                                      <span class="mtn-rank-pos">5</span>
                                                      <span class="mtn-rank-name">Suresh Nayak<em>DRV-1103</em></span>
                                                      <span class="mtn-rank-times">2 times</span>
                                                      <span class="mtn-rank-amt">&#8377;61,700</span>
                                                  </li>
                                              </ul>
                                          </div>
                                      </div>

                                  </div>

                                  <!-- Accidental repair · filter card -->
                                  <div class="accordion" id="accAccordion">
                                      <div class="accordion-item">
                                          <h2 class="accordion-header" id="accHeading">
                                              <button class="accordion-button filter-options" type="button" data-bs-toggle="collapse" data-bs-target="#accCollapse" aria-expanded="true" aria-controls="accCollapse">
                                                  <div class="item-filter">
                                                      <div class="filter">
                                                          <span class="filter-icon">
                                                              <img src="{{ asset('images/icons/filter-01icon.png') }}" alt="icon">
                                                          </span>
                                                      </div>
                                                      <p class="mb-0">Filter Options</p>
                                                  </div>
                                              </button>
                                          </h2>
                                          <div id="accCollapse" class="accordion-collapse collapse show" aria-labelledby="accHeading" data-bs-parent="#accAccordion">
                                              <div class="accordion-body">
                                                  <form action="{{ route('fleetdashboard.index') }}" id="accFilterForm">

                                                      <div class="filtersearch-bd mtn-filter-grid">
                                                  <div class="vehicletype">
                                                      <label for="accVehicle">Vehicle Number</label>
                                                      <select class="form-select" id="accVehicle">
                                                          <option value="">Choose..</option>
                                                          @foreach($vehicles as $av)
                                                          <option value="{{ $av->vehicle_no }}">{{ $av->vehicle_no }}</option>
                                                          @endforeach
                                                      </select>
                                                  </div>

                                                  <div class="vehicletype">
                                                      <label for="accGroup">Tracking Group</label>
                                                      <select class="form-select" id="accGroup">
                                                          <option value="">Choose..</option>
                                                          @foreach($vehiclegroup as $ag)
                                                          <option value="{{ $ag->id }}">{{ $ag->name }}</option>
                                                          @endforeach
                                                      </select>
                                                  </div>

                                                  <div class="vehicletype">
                                                      <label for="accDriver">Driver Name</label>
                                                      <select class="form-select" id="accDriver">
                                                          <option value="">Choose..</option>
                                                          <option value="Ramesh Yadav (DRV-1011)">Ramesh Yadav (DRV-1011)</option>
                                                          <option value="Parth Mehta (DRV-1029)">Parth Mehta (DRV-1029)</option>
                                                          <option value="Sujoy Ghosh (DRV-1042)">Sujoy Ghosh (DRV-1042)</option>
                                                          <option value="Ramen Singh (DRV-1078)">Ramen Singh (DRV-1078)</option>
                                                          <option value="Suresh Nayak (DRV-1103)">Suresh Nayak (DRV-1103)</option>
                                                      </select>
                                                  </div>

                                                  <div class="vehicletype">
                                                      <label for="accMistake">Driver Mistake</label>
                                                      <select class="form-select" id="accMistake">
                                                          <option value="">Choose..</option>
                                                          <option value="Yes">Yes</option>
                                                          <option value="No">No</option>
                                                      </select>
                                                  </div>

                                                  <div class="vehicletype">
                                                      <label for="accSeverity">Accident</label>
                                                      <select class="form-select" id="accSeverity">
                                                          <option value="">Choose..</option>
                                                          <option value="Major">Major</option>
                                                          <option value="Minor">Minor</option>
                                                      </select>
                                                  </div>

                                                  <div class="vehicletype">
                                                      <label for="accLocation">Accident Location</label>
                                                      <select class="form-select" id="accLocation">
                                                          <option value="">Choose..</option>
                                                          <option value="Delhi">Delhi</option>
                                                          <option value="Hyderabad">Hyderabad</option>
                                                          <option value="Bengaluru">Bengaluru</option>
                                                          <option value="Pune">Pune</option>
                                                          <option value="Nagpur">Nagpur</option>
                                                      </select>
                                                  </div>

                                                  <div class="vehicletype">
                                                      <label for="accClaim">Insurance Claim</label>
                                                      <select class="form-select" id="accClaim">
                                                          <option value="">Choose..</option>
                                                          <option value="Yes">Yes</option>
                                                          <option value="No">No</option>
                                                      </select>
                                                  </div>
                                                      </div>

                                                      <div class="filtersearch-bd mtn-filter-actions mt-3">
                                                          <a href="{{ route('fleetdashboard.index') }}" class="btn btn-primary"><i class="uil uil-sync me-1"></i>Reset</a>
                                                          <div class="dropdown ms-1">
                                                              <button class="btn btn-primary dropdown-toggle" type="button" id="accExportBtn" data-bs-toggle="dropdown" aria-expanded="false">
                                                                  Export <i class="uil uil-upload ms-1"></i>
                                                              </button>
                                                              <ul class="dropdown-menu" aria-labelledby="accExportBtn">
                                                                  <li><a class="dropdown-item" href="javascript:void(0)">Excel</a></li>
                                                                  <li><a class="dropdown-item" href="javascript:void(0)">PDF</a></li>
                                                              </ul>
                                                          </div>
                                                      </div>

                                                  </form>
                                              </div>
                                          </div>
                                      </div>
                                  </div>

                                  <!-- Accidental repair · table list -->
                                  <div class="sr_dashboard0_table">
                                      <div class="container-fluid">
                                          <div class="table-responsive mtn-table-scroll">
                                              <table class="table custom-driver-table mtn-wide-table mtn-acc-table">
                                                  <thead>
                                                      <tr>
                                                          <th class="mtn-col-icon"></th>
                                                          <th class="mtn-col-veh">Vehicle Number</th>
                                                          <th>Tracking Group</th>
                                                          <th>Driver Name &amp; Code</th>
                                                          <th>Driver RAG Status</th>
                                                          <th>Accident</th>
                                                          <th>Accident Date &amp; Time</th>
                                                          <th>Accident Location</th>
                                                          <th>Accident State</th>
                                                          <th>Accident Pin-code</th>
                                                          <th>Driver Injury</th>
                                                          <th>Driver Mistake</th>
                                                          <th>Accident Description</th>
                                                          <th>Total Repair Cost</th>
                                                          <th>Insurance Claim</th>
                                                          <th>Insurance Excess / Short</th>
                                                          <th class="text-center mtn-col-act">Attachment</th>
                                                      </tr>
                                                  </thead>
                                                  <tbody id="mtnAccTableBody">
                                                      <tr>
                                                          <td class="mtn-col-icon"><img src="{{ asset('images/icons/vehiche01.png') }}" alt="icon" class="driver-img-sm"></td>
                                                          <td class="mtn-col-veh"><span class="value">KA51AM 1020</span></td>
                                                          <td><span class="value">Tracking A</span></td>
                                                          <td><span class="value">Ramesh Yadav</span><br><span class="value mtn-sub">DRV-1011</span></td>
                                                          <td><span class="mtn-rag rag-red">Red</span></td>
                                                          <td><span class="mtn-tag mtn-tag-major">Major</span></td>
                                                          <td><span class="value mtn-nowrap">04/01/2026 07:20 PM</span></td>
                                                          <td><span class="value mtn-wrap">NH-44, Outer Ring Road</span></td>
                                                          <td><span class="value">Karnataka</span></td>
                                                          <td><span class="value">560045</span></td>
                                                          <td><span class="mtn-tag mtn-tag-yes-warn">Yes</span><br><span class="value mtn-wrap mtn-clamp" title="Fracture to left forearm. Admitted at Manipal Hospital for 2 days, discharged 06/01.">Fracture to left forearm. Admitted at Manipal Hospital for 2 days, discharged 06/01.</span></td>
                                                          <td><span class="mtn-tag mtn-tag-yes-warn">Yes</span><br><span class="value mtn-sub mtn-nowrap">Deduction &#8377;8,000</span></td>
                                                          <td><span class="value mtn-wrap mtn-clamp" title="Rear-ended a stationary tipper while overtaking on a wet carriageway. Front bumper, radiator and left headlamp assembly destroyed.">Rear-ended a stationary tipper while overtaking on a wet carriageway. Front bumper, radiator and left headlamp assembly destroyed.</span></td>
                                                          <td><span class="mtn-amt"><span class="mtn-amt-row"><em>Taxable</em>&#8377;1,42,000</span><span class="mtn-amt-row"><em>GST</em>&#8377;25,560</span><span class="mtn-amt-row mtn-amt-total"><em>Total</em>&#8377;1,67,560</span></span></td>
                                                          <td><span class="mtn-tag mtn-tag-yes">Yes</span><br><a href="{{ route('fleet.insurance.detail', 1) }}" class="mtn-link">Claim Details</a></td>
                                                          <td><span class="mtn-diff mtn-diff-short">Short &#8377;18,400</span></td>
                                                          <td class="text-center mtn-col-act"><a href="javascript:void(0)" class="mtn-attach" data-attach-title="KA51AM 1020 — Photos" data-attach-files="[{&quot;name&quot;: &quot;KA51AM1020-front.jpg&quot;, &quot;type&quot;: &quot;jpg&quot;, &quot;size&quot;: &quot;2.4 MB&quot;}, {&quot;name&quot;: &quot;KA51AM1020-side.jpg&quot;, &quot;type&quot;: &quot;jpg&quot;, &quot;size&quot;: &quot;2.1 MB&quot;}, {&quot;name&quot;: &quot;KA51AM1020-damage-closeup.jpg&quot;, &quot;type&quot;: &quot;jpg&quot;, &quot;size&quot;: &quot;1.9 MB&quot;}]"><i class="uil uil-image"></i>Photos</a></td>
                                                      </tr>
                                                      <tr>
                                                          <td class="mtn-col-icon"><img src="{{ asset('images/icons/vehiche03.png') }}" alt="icon" class="driver-img-sm"></td>
                                                          <td class="mtn-col-veh"><span class="value">KA51AM 3040</span></td>
                                                          <td><span class="value">Tracking B</span></td>
                                                          <td><span class="value">Parth Mehta</span><br><span class="value mtn-sub">DRV-1029</span></td>
                                                          <td><span class="mtn-rag rag-amber">Amber</span></td>
                                                          <td><span class="mtn-tag mtn-tag-minor">Minor</span></td>
                                                          <td><span class="value mtn-nowrap">19/02/2026 11:05 AM</span></td>
                                                          <td><span class="value mtn-wrap">Kukatpally Main Road</span></td>
                                                          <td><span class="value">Telangana</span></td>
                                                          <td><span class="value">500072</span></td>
                                                          <td><span class="mtn-tag mtn-tag-no-ok">No</span></td>
                                                          <td><span class="mtn-tag mtn-tag-no-ok">No</span></td>
                                                          <td><span class="value mtn-wrap mtn-clamp" title="Side-swiped by a two-wheeler changing lanes. Right cabin door skin dented, mirror housing cracked.">Side-swiped by a two-wheeler changing lanes. Right cabin door skin dented, mirror housing cracked.</span></td>
                                                          <td><span class="mtn-amt"><span class="mtn-amt-row"><em>Taxable</em>&#8377;34,000</span><span class="mtn-amt-row"><em>GST</em>&#8377;6,120</span><span class="mtn-amt-row mtn-amt-total"><em>Total</em>&#8377;40,120</span></span></td>
                                                          <td><span class="mtn-tag mtn-tag-yes">Yes</span><br><a href="{{ route('fleet.insurance.detail', 2) }}" class="mtn-link">Claim Details</a></td>
                                                          <td><span class="mtn-diff mtn-diff-excess">Excess &#8377;4,880</span></td>
                                                          <td class="text-center mtn-col-act"><a href="javascript:void(0)" class="mtn-attach" data-attach-title="KA51AM 3040 — Photos" data-attach-files="[{&quot;name&quot;: &quot;KA51AM3040-front.jpg&quot;, &quot;type&quot;: &quot;jpg&quot;, &quot;size&quot;: &quot;2.4 MB&quot;}, {&quot;name&quot;: &quot;KA51AM3040-side.jpg&quot;, &quot;type&quot;: &quot;jpg&quot;, &quot;size&quot;: &quot;2.1 MB&quot;}, {&quot;name&quot;: &quot;KA51AM3040-damage-closeup.jpg&quot;, &quot;type&quot;: &quot;jpg&quot;, &quot;size&quot;: &quot;1.9 MB&quot;}]"><i class="uil uil-image"></i>Photos</a></td>
                                                      </tr>
                                                      <tr>
                                                          <td class="mtn-col-icon"><img src="{{ asset('images/icons/vehiche01.png') }}" alt="icon" class="driver-img-sm"></td>
                                                          <td class="mtn-col-veh"><span class="value">WB-12-AB-1234</span></td>
                                                          <td><span class="value">Tracking A</span></td>
                                                          <td><span class="value">Sujoy Ghosh</span><br><span class="value mtn-sub">DRV-1042</span></td>
                                                          <td><span class="mtn-rag rag-green">Green</span></td>
                                                          <td><span class="mtn-tag mtn-tag-minor">Minor</span></td>
                                                          <td><span class="value mtn-nowrap">08/03/2026 06:45 AM</span></td>
                                                          <td><span class="value mtn-wrap">Naraina Industrial Area</span></td>
                                                          <td><span class="value">Delhi</span></td>
                                                          <td><span class="value">110028</span></td>
                                                          <td><span class="mtn-tag mtn-tag-no-ok">No</span></td>
                                                          <td><span class="mtn-tag mtn-tag-yes-warn">Yes</span><br><span class="value mtn-sub mtn-nowrap">Deduction &#8377;2,500</span></td>
                                                          <td><span class="value mtn-wrap mtn-clamp" title="Reversed into a loading dock bollard inside the yard. Rear crossmember bent, tail lamp cluster broken.">Reversed into a loading dock bollard inside the yard. Rear crossmember bent, tail lamp cluster broken.</span></td>
                                                          <td><span class="mtn-amt"><span class="mtn-amt-row"><em>Taxable</em>&#8377;21,500</span><span class="mtn-amt-row"><em>GST</em>&#8377;3,870</span><span class="mtn-amt-row mtn-amt-total"><em>Total</em>&#8377;25,370</span></span></td>
                                                          <td><span class="mtn-tag mtn-tag-no">No</span></td>
                                                          <td><span class="mtn-diff mtn-diff-short">Non-claim &#8377;25,370</span></td>
                                                          <td class="text-center mtn-col-act"><a href="javascript:void(0)" class="mtn-attach" data-attach-title="WB-12-AB-1234 — Photos" data-attach-files="[{&quot;name&quot;: &quot;WB12AB1234-front.jpg&quot;, &quot;type&quot;: &quot;jpg&quot;, &quot;size&quot;: &quot;2.4 MB&quot;}, {&quot;name&quot;: &quot;WB12AB1234-side.jpg&quot;, &quot;type&quot;: &quot;jpg&quot;, &quot;size&quot;: &quot;2.1 MB&quot;}, {&quot;name&quot;: &quot;WB12AB1234-damage-closeup.jpg&quot;, &quot;type&quot;: &quot;jpg&quot;, &quot;size&quot;: &quot;1.9 MB&quot;}]"><i class="uil uil-image"></i>Photos</a></td>
                                                      </tr>
                                                  </tbody>
                                              </table>
                                          </div>
                                      </div>
                                  </div>
                              </div>

                              <div class="tab-pane fade" id="mtn-def" role="tabpanel" aria-labelledby="mtn-def-tab">
                                  <!-- DEF · mini-dashboard -->
                                  <div class="mtn-mini-row">
                                      <div class="mtn-mini-card mtn-mini-cost">
                                          <span class="mtn-mini-icon"><i class="uil uil-tear"></i></span>
                                          <p class="mtn-mini-title">Total DEF</p>
                                          <p class="mtn-mini-amt">4,820 L</p>
                                          <span class="mtn-mini-qty">&#8377;3,42,220</span>
                                      </div>
                                      <div class="mtn-mini-card mtn-mini-own">
                                          <span class="mtn-mini-icon"><i class="uil uil-store-alt"></i></span>
                                          <p class="mtn-mini-title">SR Garage</p>
                                          <p class="mtn-mini-amt">2,960 L</p>
                                          <span class="mtn-mini-qty">&#8377;2,04,240</span>
                                      </div>
                                      <div class="mtn-mini-card mtn-mini-out">
                                          <span class="mtn-mini-icon"><i class="uil uil-map-marker"></i></span>
                                          <p class="mtn-mini-title">External Vendor</p>
                                          <p class="mtn-mini-amt">1,860 L</p>
                                          <span class="mtn-mini-qty">&#8377;1,37,980</span>
                                      </div>
                                      <div class="mtn-mini-card mtn-mini-missed">
                                          <span class="mtn-mini-icon"><i class="uil uil-exclamation-triangle"></i></span>
                                          <p class="mtn-mini-title">Vehicles in DEF Alert</p>
                                          <p class="mtn-mini-amt">7</p>
                                          <span class="mtn-mini-qty">&#8805; 80% run</span>
                                      </div>
                                      <div class="mtn-mini-card mtn-mini-pending">
                                          <span class="mtn-mini-icon"><i class="uil uil-user-check"></i></span>
                                          <p class="mtn-mini-title">Pending Admin Approvals</p>
                                          <p class="mtn-mini-amt">3</p>
                                          <span class="mtn-mini-qty">early refill</span>
                                      </div>
                                  </div>

                                  <!-- DEF · filter card -->
                                  <div class="accordion" id="defAccordion">
                                      <div class="accordion-item">
                                          <h2 class="accordion-header" id="defHeading">
                                              <button class="accordion-button filter-options" type="button" data-bs-toggle="collapse" data-bs-target="#defCollapse" aria-expanded="true" aria-controls="defCollapse">
                                                  <div class="item-filter">
                                                      <div class="filter">
                                                          <span class="filter-icon">
                                                              <img src="{{ asset('images/icons/filter-01icon.png') }}" alt="icon">
                                                          </span>
                                                      </div>
                                                      <p class="mb-0">Filter Options</p>
                                                  </div>
                                              </button>
                                          </h2>
                                          <div id="defCollapse" class="accordion-collapse collapse show" aria-labelledby="defHeading" data-bs-parent="#defAccordion">
                                              <div class="accordion-body">
                                                  <form action="{{ route('fleetdashboard.index') }}" id="defFilterForm">

                                                      <div class="filtersearch-bd mtn-filter-grid">
                                                  <div class="vehicletype">
                                                      <label for="defDateRange">Date Range</label>
                                                      <div id="defDateRange" class="form-control mtn-daterange">
                                                          <i class="fa fa-calendar"></i>
                                                          <span>01/06/2026 - 08/07/2026</span>
                                                          <i class="fa fa-caret-down ms-auto"></i>
                                                      </div>
                                                  </div>

                                                  <div class="vehicletype">
                                                      <label for="defVehicle">Vehicle Number</label>
                                                      <select class="form-select" id="defVehicle">
                                                          <option value="">Choose..</option>
                                                          @foreach($vehicles as $dv)
                                                          <option value="{{ $dv->vehicle_no }}">{{ $dv->vehicle_no }}</option>
                                                          @endforeach
                                                      </select>
                                                  </div>

                                                  <div class="vehicletype">
                                                      <label for="defDriver">Driver Name</label>
                                                      <select class="form-select" id="defDriver">
                                                          <option value="">Choose..</option>
                                                          <option value="Sujoy Ghosh (DRV-1042)">Sujoy Ghosh (DRV-1042)</option>
                                                          <option value="Ramen Singh (DRV-1078)">Ramen Singh (DRV-1078)</option>
                                                          <option value="Suresh Nayak (DRV-1103)">Suresh Nayak (DRV-1103)</option>
                                                      </select>
                                                  </div>

                                                  <div class="vehicletype">
                                                      <label for="defGroup">Tracking Group</label>
                                                      <select class="form-select" id="defGroup">
                                                          <option value="">Choose..</option>
                                                          @foreach($vehiclegroup as $dg)
                                                          <option value="{{ $dg->id }}">{{ $dg->name }}</option>
                                                          @endforeach
                                                      </select>
                                                  </div>

                                                  <div class="vehicletype">
                                                      <label for="defSource">DEF Source</label>
                                                      <select class="form-select" id="defSource">
                                                          <option value="">Choose..</option>
                                                          <option value="SR Garage">SR Garage</option>
                                                          <option value="External Vendor">External Vendor</option>
                                                      </select>
                                                  </div>

                                                  <div class="vehicletype">
                                                      <label for="defGst">GST Bill Received</label>
                                                      <select class="form-select" id="defGst">
                                                          <option value="">Choose..</option>
                                                          <option value="Yes">Yes</option>
                                                          <option value="No">No</option>
                                                      </select>
                                                  </div>
                                                      </div>

                                                      <div class="filtersearch-bd mtn-filter-actions mt-3">
                                                          <a href="{{ route('fleetdashboard.index') }}" class="btn btn-primary"><i class="uil uil-sync me-1"></i>Reset</a>
                                                          <div class="dropdown ms-1">
                                                              <button class="btn btn-primary dropdown-toggle" type="button" id="defExportBtn" data-bs-toggle="dropdown" aria-expanded="false">
                                                                  Export <i class="uil uil-upload ms-1"></i>
                                                              </button>
                                                              <ul class="dropdown-menu" aria-labelledby="defExportBtn">
                                                                  <li><a class="dropdown-item" href="javascript:void(0)">Excel</a></li>
                                                                  <li><a class="dropdown-item" href="javascript:void(0)">PDF</a></li>
                                                              </ul>
                                                          </div>
                                                      </div>

                                                  </form>
                                              </div>
                                          </div>
                                      </div>
                                  </div>

                                  <!-- DEF · table list -->
                                  <div class="sr_dashboard0_table">
                                      <div class="container-fluid">
                                          <div class="table-responsive mtn-table-scroll">
                                              <table class="table custom-driver-table mtn-wide-table mtn-def-table">
                                                  <thead>
                                                      <tr>
                                                          <th class="mtn-col-icon"></th>
                                                          <th class="mtn-col-veh">Vehicle Number</th>
                                                          <th>Driver Name &amp; Code</th>
                                                          <th>Tracking Group</th>
                                                          <th>DEF Source</th>
                                                          <th>Date</th>
                                                          <th>Odometer Reading</th>
                                                          <th>DEF Qty (Litre)</th>
                                                          <th>DEF Amount</th>
                                                          <th>DEF in Tank (Litre)</th>
                                                          <th>DEF Run KM</th>
                                                          <th>DEF Run KM Remaining</th>
                                                          <th>DEF Alert Remaining KM</th>
                                                          <th>Vendor Name &amp; Contact</th>
                                                          <th>Vendor Location</th>
                                                          <th>GST Bill Applicable</th>
                                                          <th>GST Bill Received</th>
                                                          <th>Invoice Number</th>
                                                          <th>Note</th>
                                                          <th class="text-center mtn-col-act">Attachment</th>
                                                      </tr>
                                                  </thead>
                                                  <tbody id="mtnDefTableBody">
                                                      <tr>
                                                          <td class="mtn-col-icon"><img src="{{ asset('images/icons/vehiche01.png') }}" alt="icon" class="driver-img-sm"></td>
                                                          <td class="mtn-col-veh"><a href="{{ route('fleetdashboard.getVehicleDetails', 1) }}#pills-def" class="mtn-link mtn-veh-link">WB-12-AB-1234</a></td>
                                                          <td><span class="value">Sujoy Ghosh</span><br><span class="value mtn-sub">DRV-1042</span></td>
                                                          <td><span class="value">Tracking A</span></td>
                                                          <td><span class="mtn-tag mtn-tag-own">SR Garage</span></td>
                                                          <td><span class="value">02/07/2026</span></td>
                                                          <td><span class="value">2,85,120 km</span></td>
                                                          <td><span class="value">10 L</span></td>
                                                          <td><span class="value">&#8377;710</span></td>
                                                          <td><span class="value">10 L</span></td>
                                                          <td><span class="value">2,000 km</span></td>
                                                          <td><span class="value">400 km</span></td>
                                                          <td><span class="value mtn-nowrap mtn-overdue">Alert due · 200 km over</span></td>
                                                          <td><span class="value">SR Own Garage — Delhi</span><br><span class="value mtn-sub">+91 9087654321</span></td>
                                                          <td><span class="value mtn-wrap">Sector 18, Naraina, New Delhi</span></td>
                                                          <td><span class="mtn-tag mtn-tag-yes">Yes</span></td>
                                                          <td><span class="mtn-tag mtn-tag-yes">Yes</span></td>
                                                          <td><span class="value">DEF-2026-0412</span></td>
                                                          <td><span class="value mtn-wrap mtn-clamp" title="Refill at 80% alert. Odometer cross-checked against GPS.">Refill at 80% alert. Odometer cross-checked against GPS.</span></td>
                                                          <td class="text-center mtn-col-act"><a href="javascript:void(0)" class="mtn-attach" data-attach-title="WB-12-AB-1234 — DEF Bill" data-attach-files="[{&quot;name&quot;: &quot;def-invoice-WB12AB1234.pdf&quot;, &quot;type&quot;: &quot;pdf&quot;, &quot;size&quot;: &quot;286 KB&quot;}, {&quot;name&quot;: &quot;def-meter-reading-WB12AB1234.jpg&quot;, &quot;type&quot;: &quot;jpg&quot;, &quot;size&quot;: &quot;1.2 MB&quot;}]"><i class="uil uil-paperclip"></i>DEF Bill</a></td>
                                                      </tr>
                                                      <tr>
                                                          <td class="mtn-col-icon"><img src="{{ asset('images/icons/vehiche03.png') }}" alt="icon" class="driver-img-sm"></td>
                                                          <td class="mtn-col-veh"><a href="{{ route('fleetdashboard.getVehicleDetails', 2) }}#pills-def" class="mtn-link mtn-veh-link">WB-12-AB-1236</a></td>
                                                          <td><span class="value">Ramen Singh</span><br><span class="value mtn-sub">DRV-1078</span></td>
                                                          <td><span class="value">Tracking B</span></td>
                                                          <td><span class="mtn-tag mtn-tag-ext">External Vendor</span></td>
                                                          <td><span class="value">28/06/2026</span></td>
                                                          <td><span class="value">1,97,640 km</span></td>
                                                          <td><span class="value">15 L</span></td>
                                                          <td><span class="value">&#8377;1,140</span></td>
                                                          <td><span class="value">15 L</span></td>
                                                          <td><span class="value">2,700 km</span></td>
                                                          <td><span class="value">1,340 km</span></td>
                                                          <td><span class="value mtn-nowrap">820 km</span></td>
                                                          <td><span class="value">Kukatpally Fuel Point</span><br><span class="value mtn-sub">+91 9087654320</span></td>
                                                          <td><span class="value mtn-wrap">Kukatpally, Hyderabad</span></td>
                                                          <td><span class="mtn-tag mtn-tag-yes">Yes</span></td>
                                                          <td><span class="mtn-tag mtn-tag-no">No</span></td>
                                                          <td><span class="value">DEF-2026-0398</span></td>
                                                          <td><span class="value mtn-wrap mtn-clamp" title="GST bill pending from vendor.">GST bill pending from vendor.</span></td>
                                                          <td class="text-center mtn-col-act"><a href="javascript:void(0)" class="mtn-attach" data-attach-title="WB-12-AB-1236 — DEF Bill" data-attach-files="[{&quot;name&quot;: &quot;def-invoice-WB12AB1236.pdf&quot;, &quot;type&quot;: &quot;pdf&quot;, &quot;size&quot;: &quot;286 KB&quot;}, {&quot;name&quot;: &quot;def-meter-reading-WB12AB1236.jpg&quot;, &quot;type&quot;: &quot;jpg&quot;, &quot;size&quot;: &quot;1.2 MB&quot;}]"><i class="uil uil-paperclip"></i>DEF Bill</a></td>
                                                      </tr>
                                                      <tr>
                                                          <td class="mtn-col-icon"><img src="{{ asset('images/icons/vehiche01.png') }}" alt="icon" class="driver-img-sm"></td>
                                                          <td class="mtn-col-veh"><a href="{{ route('fleetdashboard.getVehicleDetails', 3) }}#pills-def" class="mtn-link mtn-veh-link">TS09QA3962</a></td>
                                                          <td><span class="value">Suresh Nayak</span><br><span class="value mtn-sub">DRV-1103</span></td>
                                                          <td><span class="value">Tracking A</span></td>
                                                          <td><span class="mtn-tag mtn-tag-ext">External Vendor</span></td>
                                                          <td><span class="value">21/06/2026</span></td>
                                                          <td><span class="value">3,42,410 km</span></td>
                                                          <td><span class="value">8 L</span></td>
                                                          <td><span class="value">&#8377;624</span></td>
                                                          <td><span class="value">8 L</span></td>
                                                          <td><span class="value">1,600 km</span></td>
                                                          <td><span class="value">260 km</span></td>
                                                          <td><span class="value mtn-nowrap mtn-overdue">Alert due · 20 km over</span></td>
                                                          <td><span class="value">Medchal Highway Services</span><br><span class="value mtn-sub">+91 9012345678</span></td>
                                                          <td><span class="value mtn-wrap">Medchal Road, Hyderabad</span></td>
                                                          <td><span class="mtn-tag mtn-tag-no">No</span></td>
                                                          <td><span class="mtn-tag mtn-tag-no">No</span></td>
                                                          <td><span class="value">—</span></td>
                                                          <td><span class="value mtn-wrap mtn-clamp" title="Early refill — admin approval recorded (ran 1,020 km of 1,600 km).">Early refill — admin approval recorded (ran 1,020 km of 1,600 km).</span></td>
                                                          <td class="text-center mtn-col-act"><a href="javascript:void(0)" class="mtn-attach" data-attach-title="TS09QA3962 — DEF Bill" data-attach-files="[{&quot;name&quot;: &quot;def-invoice-TS09QA3962.pdf&quot;, &quot;type&quot;: &quot;pdf&quot;, &quot;size&quot;: &quot;286 KB&quot;}, {&quot;name&quot;: &quot;def-meter-reading-TS09QA3962.jpg&quot;, &quot;type&quot;: &quot;jpg&quot;, &quot;size&quot;: &quot;1.2 MB&quot;}]"><i class="uil uil-paperclip"></i>DEF Bill</a></td>
                                                      </tr>
                                                  </tbody>
                                              </table>
                                          </div>
                                      </div>
                                  </div>
                              </div>

                              <div class="tab-pane fade" id="mtn-tirpal" role="tabpanel" aria-labelledby="mtn-tirpal-tab">
                                  <!-- Tirpal &amp; Rope · mini-dashboard -->
                                  <div class="mtn-mini-row">
                                      <div class="mtn-mini-card mtn-mini-cost">
                                          <span class="mtn-mini-icon"><i class="uil uil-layers-alt"></i></span>
                                          <p class="mtn-mini-title">Total Issued</p>
                                          <p class="mtn-mini-amt">148 pcs</p>
                                          <span class="mtn-mini-qty">&#8377;6,42,300</span>
                                      </div>
                                      <div class="mtn-mini-card mtn-mini-own">
                                          <span class="mtn-mini-icon"><i class="uil uil-home"></i></span>
                                          <p class="mtn-mini-title">Roof Tirpal</p>
                                          <p class="mtn-mini-amt">54 pcs</p>
                                          <span class="mtn-mini-qty">&#8377;3,18,600</span>
                                      </div>
                                      <div class="mtn-mini-card mtn-mini-out">
                                          <span class="mtn-mini-icon"><i class="uil uil-layer-group"></i></span>
                                          <p class="mtn-mini-title">Floor Tirpal</p>
                                          <p class="mtn-mini-amt">41 pcs</p>
                                          <span class="mtn-mini-qty">&#8377;1,96,400</span>
                                      </div>
                                      <div class="mtn-mini-card mtn-mini-duedays">
                                          <span class="mtn-mini-icon"><i class="uil uil-link-h"></i></span>
                                          <p class="mtn-mini-title">Rope</p>
                                          <p class="mtn-mini-amt">53 pcs</p>
                                          <span class="mtn-mini-qty">&#8377;1,27,300</span>
                                      </div>
                                      <div class="mtn-mini-card mtn-mini-missed">
                                          <span class="mtn-mini-icon"><i class="uil uil-exclamation-triangle"></i></span>
                                          <p class="mtn-mini-title">Old Tirpal Not Returned</p>
                                          <p class="mtn-mini-amt">9 pcs</p>
                                          <span class="mtn-mini-qty">&#8377;74,500 deducted</span>
                                      </div>
                                  </div>

                                  <!-- Tirpal &amp; Rope · filter card -->
                                  <div class="accordion" id="tirAccordion">
                                      <div class="accordion-item">
                                          <h2 class="accordion-header" id="tirHeading">
                                              <button class="accordion-button filter-options" type="button" data-bs-toggle="collapse" data-bs-target="#tirCollapse" aria-expanded="true" aria-controls="tirCollapse">
                                                  <div class="item-filter">
                                                      <div class="filter">
                                                          <span class="filter-icon">
                                                              <img src="{{ asset('images/icons/filter-01icon.png') }}" alt="icon">
                                                          </span>
                                                      </div>
                                                      <p class="mb-0">Filter Options</p>
                                                  </div>
                                              </button>
                                          </h2>
                                          <div id="tirCollapse" class="accordion-collapse collapse show" aria-labelledby="tirHeading" data-bs-parent="#tirAccordion">
                                              <div class="accordion-body">
                                                  <form action="{{ route('fleetdashboard.index') }}" id="tirFilterForm">

                                                      <div class="filtersearch-bd mtn-filter-grid">
                                                  <div class="vehicletype">
                                                      <label for="tirVehicle">Vehicle Number</label>
                                                      <select class="form-select" id="tirVehicle">
                                                          <option value="">Choose..</option>
                                                          @foreach($vehicles as $tv)
                                                          <option value="{{ $tv->vehicle_no }}">{{ $tv->vehicle_no }}</option>
                                                          @endforeach
                                                      </select>
                                                  </div>

                                                  <div class="vehicletype">
                                                      <label for="tirDriver">Driver Name &amp; Code</label>
                                                      <select class="form-select" id="tirDriver">
                                                          <option value="">Choose..</option>
                                                          <option value="Sujoy Ghosh (DRV-1042)">Sujoy Ghosh (DRV-1042)</option>
                                                          <option value="Ramen Singh (DRV-1078)">Ramen Singh (DRV-1078)</option>
                                                          <option value="Suresh Nayak (DRV-1103)">Suresh Nayak (DRV-1103)</option>
                                                      </select>
                                                  </div>

                                                  <div class="vehicletype">
                                                      <label for="tirGroup">Tracking Group</label>
                                                      <select class="form-select" id="tirGroup">
                                                          <option value="">Choose..</option>
                                                          @foreach($vehiclegroup as $tg)
                                                          <option value="{{ $tg->id }}">{{ $tg->name }}</option>
                                                          @endforeach
                                                      </select>
                                                  </div>

                                                  <div class="vehicletype">
                                                      <label for="tirSource">Source</label>
                                                      <select class="form-select" id="tirSource">
                                                          <option value="">Choose..</option>
                                                          <option value="SR Garage">SR Garage</option>
                                                          <option value="Direct Vendor">Direct Vendor</option>
                                                      </select>
                                                  </div>

                                                  <div class="vehicletype">
                                                      <label for="tirReturn">Old Tirpal Return</label>
                                                      <select class="form-select" id="tirReturn">
                                                          <option value="">Choose..</option>
                                                          <option value="Yes">Yes</option>
                                                          <option value="No">No</option>
                                                      </select>
                                                  </div>
                                                      </div>

                                                      <div class="filtersearch-bd mtn-filter-actions mt-3">
                                                          <a href="{{ route('fleetdashboard.index') }}" class="btn btn-primary"><i class="uil uil-sync me-1"></i>Reset</a>
                                                          <div class="dropdown ms-1">
                                                              <button class="btn btn-primary dropdown-toggle" type="button" id="tirExportBtn" data-bs-toggle="dropdown" aria-expanded="false">
                                                                  Export <i class="uil uil-upload ms-1"></i>
                                                              </button>
                                                              <ul class="dropdown-menu" aria-labelledby="tirExportBtn">
                                                                  <li><a class="dropdown-item" href="javascript:void(0)">Excel</a></li>
                                                                  <li><a class="dropdown-item" href="javascript:void(0)">PDF</a></li>
                                                              </ul>
                                                          </div>
                                                      </div>

                                                  </form>
                                              </div>
                                          </div>
                                      </div>
                                  </div>

                                  <!-- Tirpal &amp; Rope · table list -->
                                  <div class="sr_dashboard0_table">
                                      <div class="container-fluid">
                                          <div class="table-responsive mtn-table-scroll">
                                              <table class="table custom-driver-table mtn-wide-table mtn-tir-table">
                                                  <thead>
                                                      <tr>
                                                          <th class="mtn-col-icon"></th>
                                                          <th class="mtn-col-veh">Vehicle Number</th>
                                                          <th>Driver Name &amp; Code</th>
                                                          <th>Tracking Group</th>
                                                          <th>Source</th>
                                                          <th>Issue Date</th>
                                                          <th>Issue Days</th>
                                                          <th>Choose</th>
                                                          <th>Amount</th>
                                                          <th>Tirpal Return</th>
                                                          <th>Old Tirpal Driver Deduction</th>
                                                          <th class="text-center mtn-col-act">Attachment</th>
                                                      </tr>
                                                  </thead>
                                                  <tbody id="mtnTirTableBody">
                                                      <tr>
                                                          <td class="mtn-col-icon"><img src="{{ asset('images/icons/vehiche01.png') }}" alt="icon" class="driver-img-sm"></td>
                                                          <td class="mtn-col-veh"><span class="value">WB-12-AB-1234</span></td>
                                                          <td><span class="value">Sujoy Ghosh</span><br><span class="value mtn-sub">DRV-1042</span></td>
                                                          <td><span class="value">Tracking A</span></td>
                                                          <td><span class="mtn-tag mtn-tag-own">SR Garage</span></td>
                                                          <td><span class="value">12/06/2026</span></td>
                                                          <td><span class="value">26 days</span></td>
                                                          <td><span class="mtn-tag mtn-tag-own">Roof Tirpal</span></td>
                                                          <td><span class="value">&#8377;8,400</span></td>
                                                          <td><span class="mtn-return mtn-return-yes"><i class="uil uil-check"></i>Roof Tirpal</span></td>
                                                          <td><span class="value mtn-sub">&#8212;</span></td>
                                                          <td class="text-center mtn-col-act"><a href="javascript:void(0)" class="mtn-attach" data-attach-title="WB-12-AB-1234 — Photos" data-attach-files="[{&quot;name&quot;: &quot;WB12AB1234-front.jpg&quot;, &quot;type&quot;: &quot;jpg&quot;, &quot;size&quot;: &quot;2.4 MB&quot;}, {&quot;name&quot;: &quot;WB12AB1234-side.jpg&quot;, &quot;type&quot;: &quot;jpg&quot;, &quot;size&quot;: &quot;2.1 MB&quot;}, {&quot;name&quot;: &quot;WB12AB1234-damage-closeup.jpg&quot;, &quot;type&quot;: &quot;jpg&quot;, &quot;size&quot;: &quot;1.9 MB&quot;}]"><i class="uil uil-image"></i>Photos</a></td>
                                                      </tr>
                                                      <tr>
                                                          <td class="mtn-col-icon"><img src="{{ asset('images/icons/vehiche03.png') }}" alt="icon" class="driver-img-sm"></td>
                                                          <td class="mtn-col-veh"><span class="value">WB-12-AB-1236</span></td>
                                                          <td><span class="value">Ramen Singh</span><br><span class="value mtn-sub">DRV-1078</span></td>
                                                          <td><span class="value">Tracking B</span></td>
                                                          <td><span class="mtn-tag mtn-tag-ext">Direct Vendor</span></td>
                                                          <td><span class="value">28/05/2026</span></td>
                                                          <td><span class="value">41 days</span></td>
                                                          <td><span class="mtn-tag mtn-tag-ext">Floor Tirpal</span></td>
                                                          <td><span class="value">&#8377;5,600</span></td>
                                                          <td><span class="mtn-return mtn-return-no"><i class="uil uil-times"></i>Floor Tirpal not returned</span></td>
                                                          <td><span class="mtn-diff mtn-diff-short">&#8377;4,200</span></td>
                                                          <td class="text-center mtn-col-act"><a href="javascript:void(0)" class="mtn-attach" data-attach-title="WB-12-AB-1236 — Photos" data-attach-files="[{&quot;name&quot;: &quot;WB12AB1236-front.jpg&quot;, &quot;type&quot;: &quot;jpg&quot;, &quot;size&quot;: &quot;2.4 MB&quot;}, {&quot;name&quot;: &quot;WB12AB1236-side.jpg&quot;, &quot;type&quot;: &quot;jpg&quot;, &quot;size&quot;: &quot;2.1 MB&quot;}, {&quot;name&quot;: &quot;WB12AB1236-damage-closeup.jpg&quot;, &quot;type&quot;: &quot;jpg&quot;, &quot;size&quot;: &quot;1.9 MB&quot;}]"><i class="uil uil-image"></i>Photos</a></td>
                                                      </tr>
                                                      <tr>
                                                          <td class="mtn-col-icon"><img src="{{ asset('images/icons/vehiche01.png') }}" alt="icon" class="driver-img-sm"></td>
                                                          <td class="mtn-col-veh"><span class="value">TS09QA3962</span></td>
                                                          <td><span class="value">Suresh Nayak</span><br><span class="value mtn-sub">DRV-1103</span></td>
                                                          <td><span class="value">Tracking A</span></td>
                                                          <td><span class="mtn-tag mtn-tag-own">SR Garage</span></td>
                                                          <td><span class="value">02/07/2026</span></td>
                                                          <td><span class="value">6 days</span></td>
                                                          <td><span class="mtn-tag mtn-tag-day">Rope</span></td>
                                                          <td><span class="value">&#8377;2,400</span></td>
                                                          <td><span class="value mtn-sub">Not applicable</span></td>
                                                          <td><span class="value mtn-sub">&#8212;</span></td>
                                                          <td class="text-center mtn-col-act"><a href="javascript:void(0)" class="mtn-attach" data-attach-title="TS09QA3962 — Photos" data-attach-files="[{&quot;name&quot;: &quot;TS09QA3962-front.jpg&quot;, &quot;type&quot;: &quot;jpg&quot;, &quot;size&quot;: &quot;2.4 MB&quot;}, {&quot;name&quot;: &quot;TS09QA3962-side.jpg&quot;, &quot;type&quot;: &quot;jpg&quot;, &quot;size&quot;: &quot;2.1 MB&quot;}, {&quot;name&quot;: &quot;TS09QA3962-damage-closeup.jpg&quot;, &quot;type&quot;: &quot;jpg&quot;, &quot;size&quot;: &quot;1.9 MB&quot;}]"><i class="uil uil-image"></i>Photos</a></td>
                                                      </tr>
                                                  </tbody>
                                              </table>
                                          </div>
                                      </div>
                                  </div>
                              </div>

                              <div class="tab-pane fade" id="mtn-tagged" role="tabpanel" aria-labelledby="mtn-tagged-tab">
                                  <!-- Tagged Assets · mini-dashboard -->
                                  <div class="mtn-mini-row">
                                      <div class="mtn-mini-card mtn-mini-cost">
                                          <span class="mtn-mini-icon"><i class="uil uil-tag-alt"></i></span>
                                          <p class="mtn-mini-title">Total Assets Issued</p>
                                          <p class="mtn-mini-amt">212 pcs</p>
                                          <span class="mtn-mini-qty">&#8377;8,96,400</span>
                                      </div>
                                      <div class="mtn-mini-card mtn-mini-own">
                                          <span class="mtn-mini-icon"><i class="uil uil-store-alt"></i></span>
                                          <p class="mtn-mini-title">SR Garage</p>
                                          <p class="mtn-mini-amt">134 pcs</p>
                                          <span class="mtn-mini-qty">&#8377;5,42,900</span>
                                      </div>
                                      <div class="mtn-mini-card mtn-mini-out">
                                          <span class="mtn-mini-icon"><i class="uil uil-map-marker"></i></span>
                                          <p class="mtn-mini-title">Direct Vendor</p>
                                          <p class="mtn-mini-amt">78 pcs</p>
                                          <span class="mtn-mini-qty">&#8377;3,53,500</span>
                                      </div>
                                      <div class="mtn-mini-card mtn-mini-done">
                                          <span class="mtn-mini-icon"><i class="uil uil-archive"></i></span>
                                          <p class="mtn-mini-title">Returned &#8594; Waste Stock</p>
                                          <p class="mtn-mini-amt">167 pcs</p>
                                          <span class="mtn-mini-qty">returned</span>
                                      </div>
                                      <div class="mtn-mini-card mtn-mini-missed">
                                          <span class="mtn-mini-icon"><i class="uil uil-exclamation-triangle"></i></span>
                                          <p class="mtn-mini-title">Not Returned &#8594; Deduction</p>
                                          <p class="mtn-mini-amt">14 pcs</p>
                                          <span class="mtn-mini-qty">&#8377;1,12,800 deducted</span>
                                      </div>
                                  </div>

                                  <!-- Tagged Assets · filter card -->
                                  <div class="accordion" id="tagAccordion">
                                      <div class="accordion-item">
                                          <h2 class="accordion-header" id="tagHeading">
                                              <button class="accordion-button filter-options" type="button" data-bs-toggle="collapse" data-bs-target="#tagCollapse" aria-expanded="true" aria-controls="tagCollapse">
                                                  <div class="item-filter">
                                                      <div class="filter">
                                                          <span class="filter-icon">
                                                              <img src="{{ asset('images/icons/filter-01icon.png') }}" alt="icon">
                                                          </span>
                                                      </div>
                                                      <p class="mb-0">Filter Options</p>
                                                  </div>
                                              </button>
                                          </h2>
                                          <div id="tagCollapse" class="accordion-collapse collapse show" aria-labelledby="tagHeading" data-bs-parent="#tagAccordion">
                                              <div class="accordion-body">
                                                  <form action="{{ route('fleetdashboard.index') }}" id="tagFilterForm">

                                                      <div class="filtersearch-bd mtn-filter-grid">
                                                  <div class="vehicletype">
                                                      <label for="tagVehicle">Vehicle Number</label>
                                                      <select class="form-select" id="tagVehicle">
                                                          <option value="">Choose..</option>
                                                          @foreach($vehicles as $gv)
                                                          <option value="{{ $gv->vehicle_no }}">{{ $gv->vehicle_no }}</option>
                                                          @endforeach
                                                      </select>
                                                  </div>

                                                  <div class="vehicletype">
                                                      <label for="tagDriver">Driver Name &amp; Code</label>
                                                      <select class="form-select" id="tagDriver">
                                                          <option value="">Choose..</option>
                                                          <option value="Sujoy Ghosh (DRV-1042)">Sujoy Ghosh (DRV-1042)</option>
                                                          <option value="Ramen Singh (DRV-1078)">Ramen Singh (DRV-1078)</option>
                                                          <option value="Suresh Nayak (DRV-1103)">Suresh Nayak (DRV-1103)</option>
                                                      </select>
                                                  </div>

                                                  <div class="vehicletype">
                                                      <label for="tagGroup">Tracking Group</label>
                                                      <select class="form-select" id="tagGroup">
                                                          <option value="">Choose..</option>
                                                          @foreach($vehiclegroup as $gg)
                                                          <option value="{{ $gg->id }}">{{ $gg->name }}</option>
                                                          @endforeach
                                                      </select>
                                                  </div>

                                                  <div class="vehicletype">
                                                      <label for="tagAsset">Asset Name &amp; Code</label>
                                                      <select class="form-select" id="tagAsset">
                                                          <option value="">Choose..</option>
                                                          <option value="Jack — AST-0031">Jack — AST-0031</option>
                                                          <option value="Wheel Spanner — AST-0044">Wheel Spanner — AST-0044</option>
                                                          <option value="Fire Extinguisher — AST-0058">Fire Extinguisher — AST-0058</option>
                                                          <option value="Tool Kit — AST-0072">Tool Kit — AST-0072</option>
                                                          <option value="First Aid Box — AST-0090">First Aid Box — AST-0090</option>
                                                      </select>
                                                  </div>

                                                  <div class="vehicletype">
                                                      <label for="tagSource">Issue Source</label>
                                                      <select class="form-select" id="tagSource">
                                                          <option value="">Choose..</option>
                                                          <option value="SR Garage">SR Garage</option>
                                                          <option value="Direct Vendor">Direct Vendor</option>
                                                      </select>
                                                  </div>
                                                      </div>

                                                      <div class="filtersearch-bd mtn-filter-actions mt-3">
                                                          <a href="{{ route('fleetdashboard.index') }}" class="btn btn-primary"><i class="uil uil-sync me-1"></i>Reset</a>
                                                          <div class="dropdown ms-1">
                                                              <button class="btn btn-primary dropdown-toggle" type="button" id="tagExportBtn" data-bs-toggle="dropdown" aria-expanded="false">
                                                                  Export <i class="uil uil-upload ms-1"></i>
                                                              </button>
                                                              <ul class="dropdown-menu" aria-labelledby="tagExportBtn">
                                                                  <li><a class="dropdown-item" href="javascript:void(0)">Excel</a></li>
                                                                  <li><a class="dropdown-item" href="javascript:void(0)">PDF</a></li>
                                                              </ul>
                                                          </div>
                                                      </div>

                                                  </form>
                                              </div>
                                          </div>
                                      </div>
                                  </div>

                                  <!-- Tagged Assets · table list -->
                                  <div class="sr_dashboard0_table">
                                      <div class="container-fluid">
                                          <div class="table-responsive mtn-table-scroll">
                                              <table class="table custom-driver-table mtn-wide-table mtn-tag-table">
                                                  <thead>
                                                      <tr>
                                                          <th class="mtn-col-icon"></th>
                                                          <th class="mtn-col-veh">Vehicle Number</th>
                                                          <th>Driver Name &amp; Code</th>
                                                          <th>Tracking Group</th>
                                                          <th>Asset Name &amp; Code</th>
                                                          <th>Issue Source</th>
                                                          <th>Issue Date</th>
                                                          <th>Issue Days</th>
                                                          <th>Old Tagged Asset Return</th>
                                                          <th>Driver Deduction</th>
                                                          <th class="text-center mtn-col-act">Attachment</th>
                                                      </tr>
                                                  </thead>
                                                  <tbody id="mtnTagTableBody">
                                                      <tr>
                                                          <td class="mtn-col-icon"><img src="{{ asset('images/icons/vehiche01.png') }}" alt="icon" class="driver-img-sm"></td>
                                                          <td class="mtn-col-veh"><span class="value">WB-12-AB-1234</span></td>
                                                          <td><span class="value">Sujoy Ghosh</span><br><span class="value mtn-sub">DRV-1042</span></td>
                                                          <td><span class="value">Tracking A</span></td>
                                                          <td><span class="value">Hydraulic Jack</span><br><span class="value mtn-sub">AST-0031</span></td>
                                                          <td><span class="mtn-tag mtn-tag-own">SR Garage</span></td>
                                                          <td><span class="value">12/06/2026</span></td>
                                                          <td><span class="value">26 days</span></td>
                                                          <td><span class="mtn-return mtn-return-yes"><i class="uil uil-check"></i>Yes</span><br><span class="value mtn-sub mtn-nowrap">Moved to Waste Stock</span></td>
                                                          <td><span class="value mtn-sub">&#8212;</span></td>
                                                          <td class="text-center mtn-col-act"><a href="javascript:void(0)" class="mtn-attach" data-attach-title="WB-12-AB-1234 — Photos" data-attach-files="[{&quot;name&quot;: &quot;WB12AB1234-front.jpg&quot;, &quot;type&quot;: &quot;jpg&quot;, &quot;size&quot;: &quot;2.4 MB&quot;}, {&quot;name&quot;: &quot;WB12AB1234-side.jpg&quot;, &quot;type&quot;: &quot;jpg&quot;, &quot;size&quot;: &quot;2.1 MB&quot;}, {&quot;name&quot;: &quot;WB12AB1234-damage-closeup.jpg&quot;, &quot;type&quot;: &quot;jpg&quot;, &quot;size&quot;: &quot;1.9 MB&quot;}]"><i class="uil uil-image"></i>Photos</a></td>
                                                      </tr>
                                                      <tr>
                                                          <td class="mtn-col-icon"><img src="{{ asset('images/icons/vehiche03.png') }}" alt="icon" class="driver-img-sm"></td>
                                                          <td class="mtn-col-veh"><span class="value">WB-12-AB-1236</span></td>
                                                          <td><span class="value">Ramen Singh</span><br><span class="value mtn-sub">DRV-1078</span></td>
                                                          <td><span class="value">Tracking B</span></td>
                                                          <td><span class="value">Fire Extinguisher</span><br><span class="value mtn-sub">AST-0058</span></td>
                                                          <td><span class="mtn-tag mtn-tag-ext">Direct Vendor</span></td>
                                                          <td><span class="value">28/05/2026</span></td>
                                                          <td><span class="value">41 days</span></td>
                                                          <td><span class="mtn-return mtn-return-no"><i class="uil uil-times"></i>No</span><br><span class="value mtn-sub mtn-nowrap">Driver deduction raised</span></td>
                                                          <td><span class="mtn-diff mtn-diff-short">&#8377;3,600</span></td>
                                                          <td class="text-center mtn-col-act"><a href="javascript:void(0)" class="mtn-attach" data-attach-title="WB-12-AB-1236 — Photos" data-attach-files="[{&quot;name&quot;: &quot;WB12AB1236-front.jpg&quot;, &quot;type&quot;: &quot;jpg&quot;, &quot;size&quot;: &quot;2.4 MB&quot;}, {&quot;name&quot;: &quot;WB12AB1236-side.jpg&quot;, &quot;type&quot;: &quot;jpg&quot;, &quot;size&quot;: &quot;2.1 MB&quot;}, {&quot;name&quot;: &quot;WB12AB1236-damage-closeup.jpg&quot;, &quot;type&quot;: &quot;jpg&quot;, &quot;size&quot;: &quot;1.9 MB&quot;}]"><i class="uil uil-image"></i>Photos</a></td>
                                                      </tr>
                                                      <tr>
                                                          <td class="mtn-col-icon"><img src="{{ asset('images/icons/vehiche01.png') }}" alt="icon" class="driver-img-sm"></td>
                                                          <td class="mtn-col-veh"><span class="value">TS09QA3962</span></td>
                                                          <td><span class="value">Suresh Nayak</span><br><span class="value mtn-sub">DRV-1103</span></td>
                                                          <td><span class="value">Tracking A</span></td>
                                                          <td><span class="value">Tool Kit</span><br><span class="value mtn-sub">AST-0072</span></td>
                                                          <td><span class="mtn-tag mtn-tag-own">SR Garage</span></td>
                                                          <td><span class="value">02/07/2026</span></td>
                                                          <td><span class="value">6 days</span></td>
                                                          <td><span class="mtn-return mtn-return-yes"><i class="uil uil-check"></i>Yes</span><br><span class="value mtn-sub mtn-nowrap">Moved to Waste Stock</span></td>
                                                          <td><span class="value mtn-sub">&#8212;</span></td>
                                                          <td class="text-center mtn-col-act"><a href="javascript:void(0)" class="mtn-attach" data-attach-title="TS09QA3962 — Photos" data-attach-files="[{&quot;name&quot;: &quot;TS09QA3962-front.jpg&quot;, &quot;type&quot;: &quot;jpg&quot;, &quot;size&quot;: &quot;2.4 MB&quot;}, {&quot;name&quot;: &quot;TS09QA3962-side.jpg&quot;, &quot;type&quot;: &quot;jpg&quot;, &quot;size&quot;: &quot;2.1 MB&quot;}, {&quot;name&quot;: &quot;TS09QA3962-damage-closeup.jpg&quot;, &quot;type&quot;: &quot;jpg&quot;, &quot;size&quot;: &quot;1.9 MB&quot;}]"><i class="uil uil-image"></i>Photos</a></td>
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
                      
                      
                    </div>
                </div>
            </div>
        </div>  
        
    </div>
    
</div>




<!-- Attachments Modal — shared by every Maintenance sub-tab -->
<div class="modal fade mtn-attach-modal" id="mtnAttachments" tabindex="-1" aria-labelledby="mtnAttachmentsLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="mtnAttachmentsLabel">Attachments</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="uil uil-times-circle"></i></button>
      </div>
      <div class="modal-body">
        <p class="mtn-attach-count mb-3" id="mtnAttachmentsCount"></p>
        <div class="mtn-attach-grid" id="mtnAttachmentsGrid"></div>
        <p class="mtn-attach-empty d-none" id="mtnAttachmentsEmpty">
          <i class="uil uil-file-slash"></i>No attachments uploaded for this record.
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="remarks" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Comments</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="uil uil-times-circle"></i></button>
      </div>
      <div class="modal-body vdtl_comment1sec">
        <div class="note-box">
            <label for="noteInput" class="form-label">Comments<i class="bi bi-info-circle"></i></label>

            <div class="note-input-wrapper">
                <div class="note-avatar">P</div>

                <div class="note-input-area">
                    <input type="text" id="noteInput" class="form-control" placeholder="Comments">
                </div>

                <button type="submit" class="note-send-btn">
                    <i class="bi bi-send"></i>
                </button>
            </div>

            <div class="text_bdwrapper">
                <div class="item_row">
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
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="uploadBulk" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Bulk Upload</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        
        <form action="{{route('import.file')}}" method="POST" id="bulkUploadForm">
            
            @csrf
            
            <!-- Hidden type -->
            <!--<input type="hidden" name="import_type" id="import_type">-->
            
            <label> Type <span class="text-danger">*</span></label>
            <div class="form-check form-check-inline radio-chip">
              <input class="form-check-input bulk-type" type="radio" name="import_type" id="upload_type_gps" value="gps">
              <label class="form-check-label" for="upload_type_gps"><i class="uil uil-check-circle me-1"></i>GPS Info</label>
            </div>
            
            <div class="form-check form-check-inline radio-chip">
              <input class="form-check-input bulk-type" type="radio" name="import_type" id="upload_type_fastag" value="fastag">
              <label class="form-check-label" for="upload_type_fastag"><i class="uil uil-check-circle me-1"></i>Fastag Info</label>
            </div>
            
            <div class="form-check form-check-inline radio-chip">
              <input class="form-check-input bulk-type" type="radio" name="import_type" id="upload_type_battery" value="battery">
              <label class="form-check-label" for="upload_type_battery"><i class="uil uil-check-circle me-1"></i>Battery Info</label>
            </div>
            <small class="error text-danger" id="add_import_type_error"></small>
            
            
                            
            <div id="upload_file_div" style="display:none;">
                
                <!-- Upload -->
                <div class="form-group">
                    <!--<h6>Upload File</h6>-->
                    
                    <input id="file_upload" type="file" name="import_file" accept=".xls,.xlsx" hidden>
                    
                    <label for="file_upload" class="btn btn-secondary">Upload <i class="uil uil-plus ms-1"></i></label>
                    <small class="error text-danger" id="add_import_file_error"></small>
                    
                    <div class="prev-wrap" style="display: none;" id="preview">
                        <span class="d-block"><i class="uil uil-file-info-alt" style="font-size: 24px;"></i></span>
                        <span id="fileName" class="d-block"></span>
                    </div>
                </div>
                
                <!-- Sample download -->
                <div class="form-group mt-3">
                    <h6>Download Sample <span class="fileTypeName"></span> File</h6>
                    <a href="#" id="sampleFileLink" class="btn btn-outline-primary" download>
                        Download <span class="fileTypeName"></span> Sample
                    </a>
                </div>
            
            </div>
            
            
                    
        </form>
      </div>
      
      <div class="modal-footer">
          <button type="button" id="bulkUploadBtn" class="btn btn-primary">Upload</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
      
    </div>
  </div>
</div>


@endsection

@section('js')

<script>
let FASTAG_EXCEL = "{{ asset('sample_excels/Fasttag.xlsx') }}";
let GPS_EXCEL    = "{{ asset('sample_excels/Gps.xlsx') }}";
let TYRE_EXCEL   = "{{ asset('sample_excels/Tyre.xlsx') }}";
let BATTERY_EXCEL   = "{{ asset('sample_excels/Battery.xlsx') }}";
</script>


<script type="text/javascript" src="{{ asset('js/Fleet/index.js?v=1.3') }}"></script>
<script type="text/javascript" src="{{ asset('js/Fleet/dashboard.js?v=1.0') }}"></script>
<script type="text/javascript" src="{{ asset('js/Fleet/maintenance-attachments.js?v=1.0') }}"></script>


@endsection





