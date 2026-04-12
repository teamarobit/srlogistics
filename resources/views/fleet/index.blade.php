@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/Fleet/dashboard.css?v=1.0') }}">
<link rel="stylesheet" href="{{ asset('css/Fleet/index.css?v=1.0') }}">
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
                        <button class="nav-link fleetTab active" data-status="" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">All Vehicles</button>
                      </li>
                      <li class="nav-item" role="presentation">
                        <button class="nav-link fleetTab" data-status="7" id="pills-empty-tab" data-bs-toggle="pill" data-bs-target="#pills-empty" type="button" role="tab" aria-controls="pills-empty" aria-selected="false">Empty</button>
                      </li>
                      <li class="nav-item" role="presentation">
                        <button class="nav-link fleetTab" data-status="3" id="pills-loading-tab" data-bs-toggle="pill" data-bs-target="#pills-loading" type="button" role="tab" aria-controls="pills-loading" aria-selected="false">Loading</button>
                      </li>
                      <li class="nav-item" role="presentation">
                        <button class="nav-link fleetTab" data-status="5" id="pills-unloading-tab" data-bs-toggle="pill" data-bs-target="#pills-unloading" type="button" role="tab" aria-controls="pills-unloading" aria-selected="false">Unloading</button>
                      </li>
                      <li class="nav-item" role="presentation">
                        <button class="nav-link fleetTab" data-status="1" id="pills-on_the_way-tab" data-bs-toggle="pill" data-bs-target="#pills-on_the_way" type="button" role="tab" aria-controls="pills-on_the_way" aria-selected="false">On The Way</button>
                      </li>
                      <li class="nav-item" role="presentation">
                        <button class="nav-link fleetTab" data-status="6" id="pills-maintenance-tab" data-bs-toggle="pill" data-bs-target="#pills-maintenance" type="button" role="tab" aria-controls="pills-maintenance" aria-selected="false">Maintenance</button>
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
                                                <select class="form-select">
                                                    <option>Choose..</option>
                                                    <option>Initiated</option>
                                                    <option>On Going</option>
                                                    <option>Completed</option>
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
                                                  <input type="text" class="form-control" placeholder="Search by Location">
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
                      
                      <div class="tab-pane fade" id="pills-maintenance" role="tabpanel" aria-labelledby="pills-maintenance-tab">
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
                                                <label>Work Load</label>
                                                <select class="form-select">
                                                    <option>Choose</option>
                                                    <option>Major</option>
                                                    <option>Minor</option>
                                                </select>
                                            </div>
                                            
                                            <div class="vehicletype ms-1">
                                                <label>Work Type</label>
                                                <select class="form-select">
                                                    <option>Choose</option>
                                                    <option>Repair</option>
                                                    <option>Maintenance</option>
                                                </select>
                                            </div>
                                            
                                            <div class="vehicletype ms-1">
                                                <label>Maintenance Since</label>
                                                <div id="reportrange" class="form-control" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                                    <i class="fa fa-calendar"></i>&nbsp;
                                                    <span></span> <i class="fa fa-caret-down"></i>
                                                </div>
                                            </div>
                                            
                                            <div class="vehicletype ms-1">
                                                <label>Expected Closure Date</label>
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
                                                    <th>Work Load</th>
                                                    <th>Work Type</th>
                                                    <th>Maintenance<br/>Since</th>
                                                    <th>Expected<br/>Closure</th>
                                                    <th>Workshop Name<br/>Location</th>
                                                    <th>Contact</th>
                                                    <th>Managed By</th>
                                                    <th class="text-center">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody id="fleetTableBody_6">
                                                <tr>
                                                    <td><img src="{{ asset('images/icons/vehiche01.png') }}" alt="icon" class="driver-img-sm"></td>
                                                    <td>
                                                        <span class="value">WB-12-AB-1234</span>
                                                    </td>
                                                    <td><span class="value">Sujoy Ghosh</span><br/><span class="value">+91 9087654321</span></td>
                                                    <td><span class="tag">Major</span></td> 
                                                    <td><span class="tag ms-1">Repair</span></td> 
                                                    <td><span class="value">10/01/2026</span></td>
                                                    <td><span class="value">12/01/2026</span></td>
                                                    
                                                    <td><span class="value">Tata Motors<br/>Delhi</span></td>
                                                    
                                                    <td><span class="value">Vinay Ghosh</span><br/><span class="value">+91 9087654321</span></td>
                                                    
                                                    <td><span class="value">Anuj Maheta</span></td>
            
                                                    <td class="text-center">
                                                        <a href="#" class="btn btn-sm-custom">View Details</a>
                                                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#remarks" class="ms-2 cmnt-icon"><i class="uil uil-info-circle"></i></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><img src="{{ asset('images/icons/vehiche01.png') }}" alt="icon" class="driver-img-sm"></td>
                                                    <td>
                                                        <span class="value">WB-12-AB-1236</span>
                                                    </td>
                                                    <td><span class="value">Sujoy Ghosh</span><br/><span class="value">+91 9087654321</span></td>
                                                    <td><span class="tag">Minor</span></td>
                                                    <td><span class="tag ms-1">Maintenance</span></td>
                                                    <td><span class="value">10/01/2026</span></td>
                                                    <td><span class="value">13/01/2026</span></td>
                                                    
                                                    <td><span class="value">Maruti<br/>Hydrabad</span></td>
                                                    
                                                    <td><span class="value">Rajesh Ghosh</span><br/><span class="value">+91 9087654320</span></td>
                                                    
                                                    <td><span class="value">Ankur Maheta</span></td>
            
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
                      
                      
                    </div>
                </div>
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


<script type="text/javascript" src="{{ asset('js/Fleet/index.js?v=1.0') }}"></script>
<script type="text/javascript" src="{{ asset('js/Fleet/dashboard.js?v=1.0') }}"></script>


@endsection





