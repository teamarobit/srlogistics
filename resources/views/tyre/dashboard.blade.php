@extends('layouts.app')

@section('css')
    
<link rel="stylesheet" href="{{ asset('public/css/tyre/dashboard.css') }}">
<link rel="stylesheet" href="{{ asset('public/css/tyre/dashboard-table.css') }}">

<style>
    .bg-empty{
        background-color: #bccb2d;
    }
    .prev-wrap{
        width: 120px;
        height: 130px;
        display: flex !important;
        border: 1px solid #ddd;
        border-radius: 5px;
        align-items: center;
        justify-content: center;
    }
</style>

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
                       <h1>Tyre Dashboard</h1>
                   </div>
                   <div class="col-12 col-md-6 text-end">
                       <div class="dropdown mt-2 mb-2">
                            <a class="btn btn-primary" href="{{ route('tyre.create') }}">
                                <i class="uil uil-plus me-1"></i>Add Tyre
                            </a>               
                           
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
                                    <p class="number">{{ $all_count }}</p>
                                    <p>All Tyres</p>
                                </div>
                        
                                <div class="bottom">
                                    <div class="item1"><img src="{{ asset('public/images/up-right-arrow 1.png') }}" /> 100%</div>
                        
                                    <div class="item3">
                                        <img src="{{ asset('public/images/icons/tyre-default.png') }}" />
                                    </div>
                                </div>
                        
                                <div class="item-icon">
                                    <span>
                                        <img src="{{ asset('public/images/images01.png') }}" />
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="itemcol">
                            <div class="itembd">
                                <div class="top">
                                    <p class="number">{{ $warehouse_count }}</p>
                                    <p>Warehouse </p>
                                </div>
                        
                                <div class="bottom">
                                    <div class="item1"><img src="{{ asset('public/images/up-right-arrow 1.png') }}" /> {{ round($warehouse_count * 100 / $all_count) }}%</div>
                        
                                    <div class="item3">
                                        <img src="{{ asset('public/images/icons/tyre-default.png') }}" />
                                    </div>
                                </div>
                        
                                <div class="item-icon">
                                    <span>
                                        <img src="{{ asset('public/images/images01.png') }}" />
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="itemcol">
                            <div class="itembd">
                                <div class="top">
                                    <p class="number">{{ $service_center_count }}</p>
                                    <p>Service Center</p>
                                </div>
                        
                                <div class="bottom">
                                    <div class="item1"><img src="{{ asset('public/images/up-right-arrow 1.png') }}" /> {{ round($service_center_count * 100 / $all_count) }}%</div>
                        
                                    <!--<div class="item2">Inactive Vehicles</div>-->
                        
                                    <div class="item3">
                                        <img src="{{ asset('public/images/icons/tyre-default.png') }}" />
                                    </div>
                                </div>
                        
                                <div class="item-icon">
                                    <span>
                                        <img src="{{ asset('public/images/images01.png') }}" />
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="itemcol">
                            <div class="itembd">
                                <div class="top">
                                    <p class="number">{{ $vehicle_count }}</p>
                                    <p>Allocated Vehicle</p>
                                </div>
                        
                                <div class="bottom">
                                    <div class="item1"><img src="{{ asset('public/images/up-right-arrow 1.png') }}" /> {{ round($vehicle_count * 100 / $all_count) }}%</div>
                        
                                    <!--<div class="item2">Without Driver</div>-->
                        
                                    <div class="item3">
                                        <img src="{{ asset('public/images/icons/tyre-default.png') }}" />
                                    </div>
                                </div>
                        
                                <div class="item-icon">
                                    <span>
                                        <img src="{{ asset('public/images/images01.png') }}" />
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="itemcol">
                            <div class="itembd">
                                <div class="top">
                                    <p class="number">{{ $discarded_count }}</p>
                                    <p>Discarded</p>
                                </div>
                        
                                <div class="bottom">
                                    <div class="item1"><img src="{{ asset('public/images/up-right-arrow 1.png') }}" /> {{ round($discarded_count * 100 / $all_count) }}%</div>
                                    <div class="item3">
                                        <img src="{{ asset('public/images/icons/tyre-default.png') }}" />
                                    </div>
                                </div>
                        
                                <div class="item-icon">
                                    <span>
                                        <img src="{{ asset('public/images/images01.png') }}" />
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="right-side-wrap mt-0">
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                      <li class="nav-item" role="presentation">
                        <button class="nav-link nav_click fleetTab active" data-status="" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">All Tyres</button>
                      </li>
                      <li class="nav-item" role="presentation">
                        <button class="nav-link nav_click fleetTab" data-status="7" id="pills-empty-tab" data-bs-toggle="pill" data-bs-target="#pills-empty" type="button" role="tab" aria-controls="pills-empty" aria-selected="false">Warehouse</button>
                      </li>
                      <li class="nav-item" role="presentation">
                        <button class="nav-link nav_click fleetTab" data-status="3" id="pills-loading-tab" data-bs-toggle="pill" data-bs-target="#pills-loading" type="button" role="tab" aria-controls="pills-loading" aria-selected="false">Service Center</button>
                      </li>
                      <li class="nav-item" role="presentation">
                        <button class="nav-link nav_click fleetTab" data-status="5" id="pills-unloading-tab" data-bs-toggle="pill" data-bs-target="#pills-unloading" type="button" role="tab" aria-controls="pills-unloading" aria-selected="false">Allocated Vehicle</button>
                      </li>
                      <li class="nav-item" role="presentation">
                        <button class="nav-link nav_click fleetTab" data-status="1" id="pills-on_the_way-tab" data-bs-toggle="pill" data-bs-target="#pills-on_the_way" type="button" role="tab" aria-controls="pills-on_the_way" aria-selected="false">Discarded</button>
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
                                                <img src="{{ asset('public/images/icons/filter-01icon.png') }}" alt="icon">
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
                                            
                                            <!--<div class="vehicletype ms-1">-->
                                            <!--    <label>Fleet Status</label>-->
                                            <!--    <select class="form-select" name="v_fleet_status" id="v_fleet_status">-->
                                            <!--        <option value="">Choose..</option>-->
                                                    
                                            <!--    </select>-->
                                            <!--</div>-->
                                            
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
                                                <label>Type</label>
                                                <select class="form-select" name="v_ownership" id="v_ownership_id">
                                                    <option value="">Choose..</option>
                                                    <option value="Own">Nylon</option>
                                                    <option value="Rental">Radial</option>
                                                </select>
                                            </div>
                                            
                                            <div class="vehicletype ms-1">
                                                <label>Status</label>
                                                <select class="form-select">
                                                    <option>Choose..</option>
                                                    <option>New</option>
                                                    <option>Re-Thread</option>
                                                    <option>Discard</option>
                                                </select>
                                            </div>
                                            
                                            
                                            <div class="vehicletype ms-1">
                                                <label>Document Expiry Date</label>
                                                <div id="reportrange" class="form-control expiry_date" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                                    <i class="fa fa-calendar"></i>&nbsp;
                                                    <span></span> <i class="fa fa-caret-down"></i>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="filtersearch-bd justify-content-start mt-3">
                                            
                                            <div class="ms-1" style="width: 200px;">
                                                <div class="input-group">
                                                  <input type="text" name="v_driver" id="v_driver" class="form-control" placeholder="Search by Serial Number">
                                                  <span class="input-group-text"><i class="uil uil-search"></i></span>
                                                  <!--<span class="input-group-text"><i class="uil uil-sync me-1"></i></span>-->
                                                </div>
                                            </div>
                                            
                                            <!--<div class="ms-1" style="width: 225px;">-->
                                            <!--    <div class="input-group">-->
                                            <!--      <input type="text" name="v_managed_by" id="v_managed_by" class="form-control" placeholder="Search by Manager">-->
                                            <!--      <span class="input-group-text"><i class="uil uil-search"></i></span>-->
                                                  <!--<span class="input-group-text"><i class="uil uil-sync me-1"></i></span>-->
                                            <!--    </div>-->
                                            <!--</div>-->
                                            
                                            <!--<div class="ms-1" style="width: 220px;">-->
                                            <!--    <div class="input-group">-->
                                            <!--      <input type="text" class="form-control" placeholder="Search by Location">-->
                                            <!--      <span class="input-group-text"><i class="uil uil-search"></i></span>-->
                                                  <!--<span class="input-group-text"><i class="uil uil-sync me-1"></i></span>-->
                                            <!--    </div>-->
                                            <!--</div>-->
                                            
                                            <!--<div class="ms-1" style="width: 220px;">-->
                                            <!--    <div class="input-group">-->
                                            <!--      <input type="text" name="v_vehicle_no" id="v_vehicle_no" class="form-control" placeholder="Search by Vehicle #">-->
                                            <!--      <span class="input-group-text"><i class="uil uil-search"></i></span>-->
                                                  <!--<span class="input-group-text"><i class="uil uil-sync me-1"></i></span>-->
                                            <!--    </div>-->
                                            <!--</div>-->
                                            
                                            
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
                                        @include('tyre.partials.list', ['tyres' => $all_tyres])
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
                                                <img src="{{ asset('public/images/icons/filter-01icon.png') }}" alt="icon">
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
                                            
                                            <!--<div class="vehicletype ms-1">-->
                                            <!--    <label>Fleet Status</label>-->
                                            <!--    <select class="form-select" name="v_fleet_status" id="v_fleet_status">-->
                                            <!--        <option value="">Choose..</option>-->
                                                    
                                            <!--    </select>-->
                                            <!--</div>-->
                                            
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
                                                <label>Type</label>
                                                <select class="form-select" name="v_ownership" id="v_ownership_id">
                                                    <option value="">Choose..</option>
                                                    <option value="Own">Nylon</option>
                                                    <option value="Rental">Radial</option>
                                                </select>
                                            </div>
                                            
                                            <div class="vehicletype ms-1">
                                                <label>Status</label>
                                                <select class="form-select">
                                                    <option>Choose..</option>
                                                    <option>New</option>
                                                    <option>Re-Thread</option>
                                                    <option>Discard</option>
                                                </select>
                                            </div>
                                            
                                            
                                            <div class="vehicletype ms-1">
                                                <label>Document Expiry Date</label>
                                                <div id="reportrange" class="form-control expiry_date" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                                    <i class="fa fa-calendar"></i>&nbsp;
                                                    <span></span> <i class="fa fa-caret-down"></i>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="filtersearch-bd justify-content-start mt-3">
                                            
                                            <div class="ms-1" style="width: 200px;">
                                                <div class="input-group">
                                                  <input type="text" name="v_driver" id="v_driver" class="form-control" placeholder="Search by Serial Number">
                                                  <span class="input-group-text"><i class="uil uil-search"></i></span>
                                                  <!--<span class="input-group-text"><i class="uil uil-sync me-1"></i></span>-->
                                                </div>
                                            </div>
                                            
                                            <!--<div class="ms-1" style="width: 225px;">-->
                                            <!--    <div class="input-group">-->
                                            <!--      <input type="text" name="v_managed_by" id="v_managed_by" class="form-control" placeholder="Search by Manager">-->
                                            <!--      <span class="input-group-text"><i class="uil uil-search"></i></span>-->
                                                  <!--<span class="input-group-text"><i class="uil uil-sync me-1"></i></span>-->
                                            <!--    </div>-->
                                            <!--</div>-->
                                            
                                            <!--<div class="ms-1" style="width: 220px;">-->
                                            <!--    <div class="input-group">-->
                                            <!--      <input type="text" class="form-control" placeholder="Search by Location">-->
                                            <!--      <span class="input-group-text"><i class="uil uil-search"></i></span>-->
                                                  <!--<span class="input-group-text"><i class="uil uil-sync me-1"></i></span>-->
                                            <!--    </div>-->
                                            <!--</div>-->
                                            
                                            <!--<div class="ms-1" style="width: 220px;">-->
                                            <!--    <div class="input-group">-->
                                            <!--      <input type="text" name="v_vehicle_no" id="v_vehicle_no" class="form-control" placeholder="Search by Vehicle #">-->
                                            <!--      <span class="input-group-text"><i class="uil uil-search"></i></span>-->
                                                  <!--<span class="input-group-text"><i class="uil uil-sync me-1"></i></span>-->
                                            <!--    </div>-->
                                            <!--</div>-->
                                            
                                            
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
                                        @include('tyre.partials.list', ['tyres' => $warehouse_tyres])
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
                                                <img src="{{ asset('public/images/icons/filter-01icon.png') }}" alt="icon">
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
                                            
                                            <!--<div class="vehicletype ms-1">-->
                                            <!--    <label>Fleet Status</label>-->
                                            <!--    <select class="form-select" name="v_fleet_status" id="v_fleet_status">-->
                                            <!--        <option value="">Choose..</option>-->
                                                    
                                            <!--    </select>-->
                                            <!--</div>-->
                                            
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
                                                <label>Type</label>
                                                <select class="form-select" name="v_ownership" id="v_ownership_id">
                                                    <option value="">Choose..</option>
                                                    <option value="Own">Nylon</option>
                                                    <option value="Rental">Radial</option>
                                                </select>
                                            </div>
                                            
                                            <div class="vehicletype ms-1">
                                                <label>Status</label>
                                                <select class="form-select">
                                                    <option>Choose..</option>
                                                    <option>New</option>
                                                    <option>Re-Thread</option>
                                                    <option>Discard</option>
                                                </select>
                                            </div>
                                            
                                            
                                            <div class="vehicletype ms-1">
                                                <label>Document Expiry Date</label>
                                                <div id="reportrange" class="form-control expiry_date" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                                    <i class="fa fa-calendar"></i>&nbsp;
                                                    <span></span> <i class="fa fa-caret-down"></i>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="filtersearch-bd justify-content-start mt-3">
                                            
                                            <div class="ms-1" style="width: 200px;">
                                                <div class="input-group">
                                                  <input type="text" name="v_driver" id="v_driver" class="form-control" placeholder="Search by Serial Number">
                                                  <span class="input-group-text"><i class="uil uil-search"></i></span>
                                                  <!--<span class="input-group-text"><i class="uil uil-sync me-1"></i></span>-->
                                                </div>
                                            </div>
                                            
                                            <!--<div class="ms-1" style="width: 225px;">-->
                                            <!--    <div class="input-group">-->
                                            <!--      <input type="text" name="v_managed_by" id="v_managed_by" class="form-control" placeholder="Search by Manager">-->
                                            <!--      <span class="input-group-text"><i class="uil uil-search"></i></span>-->
                                                  <!--<span class="input-group-text"><i class="uil uil-sync me-1"></i></span>-->
                                            <!--    </div>-->
                                            <!--</div>-->
                                            
                                            <!--<div class="ms-1" style="width: 220px;">-->
                                            <!--    <div class="input-group">-->
                                            <!--      <input type="text" class="form-control" placeholder="Search by Location">-->
                                            <!--      <span class="input-group-text"><i class="uil uil-search"></i></span>-->
                                                  <!--<span class="input-group-text"><i class="uil uil-sync me-1"></i></span>-->
                                            <!--    </div>-->
                                            <!--</div>-->
                                            
                                            <!--<div class="ms-1" style="width: 220px;">-->
                                            <!--    <div class="input-group">-->
                                            <!--      <input type="text" name="v_vehicle_no" id="v_vehicle_no" class="form-control" placeholder="Search by Vehicle #">-->
                                            <!--      <span class="input-group-text"><i class="uil uil-search"></i></span>-->
                                                  <!--<span class="input-group-text"><i class="uil uil-sync me-1"></i></span>-->
                                            <!--    </div>-->
                                            <!--</div>-->
                                            
                                            
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
                                        @include('tyre.partials.list', ['tyres' => $service_center_tyres])
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
                                                <img src="{{ asset('public/images/icons/filter-01icon.png') }}" alt="icon">
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
                                            
                                            <!--<div class="vehicletype ms-1">-->
                                            <!--    <label>Fleet Status</label>-->
                                            <!--    <select class="form-select" name="v_fleet_status" id="v_fleet_status">-->
                                            <!--        <option value="">Choose..</option>-->
                                                    
                                            <!--    </select>-->
                                            <!--</div>-->
                                            
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
                                                <label>Type</label>
                                                <select class="form-select" name="v_ownership" id="v_ownership_id">
                                                    <option value="">Choose..</option>
                                                    <option value="Own">Nylon</option>
                                                    <option value="Rental">Radial</option>
                                                </select>
                                            </div>
                                            
                                            <div class="vehicletype ms-1">
                                                <label>Status</label>
                                                <select class="form-select">
                                                    <option>Choose..</option>
                                                    <option>New</option>
                                                    <option>Re-Thread</option>
                                                    <option>Discard</option>
                                                </select>
                                            </div>
                                            
                                            
                                            <div class="vehicletype ms-1">
                                                <label>Document Expiry Date</label>
                                                <div id="reportrange" class="form-control expiry_date" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                                    <i class="fa fa-calendar"></i>&nbsp;
                                                    <span></span> <i class="fa fa-caret-down"></i>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="filtersearch-bd justify-content-start mt-3">
                                            
                                            <div class="ms-1" style="width: 200px;">
                                                <div class="input-group">
                                                  <input type="text" name="v_driver" id="v_driver" class="form-control" placeholder="Search by Serial Number">
                                                  <span class="input-group-text"><i class="uil uil-search"></i></span>
                                                  <!--<span class="input-group-text"><i class="uil uil-sync me-1"></i></span>-->
                                                </div>
                                            </div>
                                            
                                            <!--<div class="ms-1" style="width: 225px;">-->
                                            <!--    <div class="input-group">-->
                                            <!--      <input type="text" name="v_managed_by" id="v_managed_by" class="form-control" placeholder="Search by Manager">-->
                                            <!--      <span class="input-group-text"><i class="uil uil-search"></i></span>-->
                                                  <!--<span class="input-group-text"><i class="uil uil-sync me-1"></i></span>-->
                                            <!--    </div>-->
                                            <!--</div>-->
                                            
                                            <!--<div class="ms-1" style="width: 220px;">-->
                                            <!--    <div class="input-group">-->
                                            <!--      <input type="text" class="form-control" placeholder="Search by Location">-->
                                            <!--      <span class="input-group-text"><i class="uil uil-search"></i></span>-->
                                                  <!--<span class="input-group-text"><i class="uil uil-sync me-1"></i></span>-->
                                            <!--    </div>-->
                                            <!--</div>-->
                                            
                                            <!--<div class="ms-1" style="width: 220px;">-->
                                            <!--    <div class="input-group">-->
                                            <!--      <input type="text" name="v_vehicle_no" id="v_vehicle_no" class="form-control" placeholder="Search by Vehicle #">-->
                                            <!--      <span class="input-group-text"><i class="uil uil-search"></i></span>-->
                                                  <!--<span class="input-group-text"><i class="uil uil-sync me-1"></i></span>-->
                                            <!--    </div>-->
                                            <!--</div>-->
                                            
                                            
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
                                        @include('tyre.partials.list', ['tyres' => $vehicle_tyres])
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
                                                <img src="{{ asset('public/images/icons/filter-01icon.png') }}" alt="icon">
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
                                            
                                            <!--<div class="vehicletype ms-1">-->
                                            <!--    <label>Fleet Status</label>-->
                                            <!--    <select class="form-select" name="v_fleet_status" id="v_fleet_status">-->
                                            <!--        <option value="">Choose..</option>-->
                                                    
                                            <!--    </select>-->
                                            <!--</div>-->
                                            
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
                                                <label>Type</label>
                                                <select class="form-select" name="v_ownership" id="v_ownership_id">
                                                    <option value="">Choose..</option>
                                                    <option value="Own">Nylon</option>
                                                    <option value="Rental">Radial</option>
                                                </select>
                                            </div>
                                            
                                            <div class="vehicletype ms-1">
                                                <label>Status</label>
                                                <select class="form-select">
                                                    <option>Choose..</option>
                                                    <option>New</option>
                                                    <option>Re-Thread</option>
                                                </select>
                                            </div>
                                            
                                            
                                            <div class="vehicletype ms-1">
                                                <label>Document Expiry Date</label>
                                                <div id="reportrange" class="form-control expiry_date" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                                    <i class="fa fa-calendar"></i>&nbsp;
                                                    <span></span> <i class="fa fa-caret-down"></i>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="filtersearch-bd justify-content-start mt-3">
                                            
                                            <div class="ms-1" style="width: 200px;">
                                                <div class="input-group">
                                                  <input type="text" name="v_driver" id="v_driver" class="form-control" placeholder="Search by Serial Number">
                                                  <span class="input-group-text"><i class="uil uil-search"></i></span>
                                                  <!--<span class="input-group-text"><i class="uil uil-sync me-1"></i></span>-->
                                                </div>
                                            </div>
                                            
                                            <!--<div class="ms-1" style="width: 225px;">-->
                                            <!--    <div class="input-group">-->
                                            <!--      <input type="text" name="v_managed_by" id="v_managed_by" class="form-control" placeholder="Search by Manager">-->
                                            <!--      <span class="input-group-text"><i class="uil uil-search"></i></span>-->
                                                  <!--<span class="input-group-text"><i class="uil uil-sync me-1"></i></span>-->
                                            <!--    </div>-->
                                            <!--</div>-->
                                            
                                            <!--<div class="ms-1" style="width: 220px;">-->
                                            <!--    <div class="input-group">-->
                                            <!--      <input type="text" class="form-control" placeholder="Search by Location">-->
                                            <!--      <span class="input-group-text"><i class="uil uil-search"></i></span>-->
                                                  <!--<span class="input-group-text"><i class="uil uil-sync me-1"></i></span>-->
                                            <!--    </div>-->
                                            <!--</div>-->
                                            
                                            <!--<div class="ms-1" style="width: 220px;">-->
                                            <!--    <div class="input-group">-->
                                            <!--      <input type="text" name="v_vehicle_no" id="v_vehicle_no" class="form-control" placeholder="Search by Vehicle #">-->
                                            <!--      <span class="input-group-text"><i class="uil uil-search"></i></span>-->
                                                  <!--<span class="input-group-text"><i class="uil uil-sync me-1"></i></span>-->
                                            <!--    </div>-->
                                            <!--</div>-->
                                            
                                            
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
                                        @include('tyre.partials.list', ['tyres' => $discarded_tyres])
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


@endsection

@section('js')

<script type="text/javascript" src="{{ asset('public/customjs/tyre/dashboard.js') }}?v={{ uniqid() }}"></script>


@endsection





