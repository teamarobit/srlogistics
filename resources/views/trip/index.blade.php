@extends('layouts.app')

@section('css')
<link href="{{ asset('css/trip/trip.css?v=2.0') }}" rel="stylesheet">
@endsection

@section('content')
<div class="layout-wrapper">

    @include('includes.header')

    <div class="trip-bd srlog-bdwrapper">
           
        <div class="top-text">
            <div class="container-fluid">
                <h1>Trips</h1>
            </div>               
        </div>
        
        <div class="itemvehicles-bd">
            <div class="container-fluid">
                
                <div class="itemv-box">
                    <div class="itemrow">
                        
                        <div class="itemcol">
                            <div class="itembd">
                                <div class="top">
                                    <p class="number">50</p>
                                    <!--<p>All Vehicles</p>-->
                                    
                                </div>
                        
                                <div class="bottom">
                                    <div class="item1"><img src="images/up-right-arrow 1.png" /> 99%</div>
                        
                                    <div class="item2">Active Vehicles</div>
                        
                                    <div class="item3">
                                        <img src="images/vehicles.png" />
                                    </div>
                                    
                                </div>
                        
                                <div class="item-icon">
                                    <span>
                                        <img src="images/images01.png" />
                                    </span>
                                </div>
                                
                            </div>
                        </div>
                        <div class="itemcol">
                            <div class="itembd">
                                <div class="top">
                                    <p class="number">40</p>
                                    <!--<p>Empty Vehicle</p>-->
                                </div>
                        
                                <div class="bottom">
                                    <div class="item1"><img src="images/up-right-arrow 1.png" /> 99%</div>
                        
                                    <div class="item2">Active Vehicles</div>
                        
                                    <div class="item3">
                                        <img src="images/vehicles.png" />
                                    </div>
                                </div>
                        
                                <div class="item-icon">
                                    <span>
                                        <img src="images/images01.png" />
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="itemcol">
                            <div class="itembd">
                                <div class="top">
                                    <p class="number">80</p>
                                    <!--<p>Unloading</p>-->
                                </div>
                        
                                <div class="bottom">
                                    <div class="item1"><img src="images/up-right-arrow 1.png" /> 99%</div>
                        
                                    <div class="item2">Active Vehicles</div>
                        
                                    <div class="item3">
                                        <img src="images/vehicles.png" />
                                    </div>
                                </div>
                        
                                <div class="item-icon">
                                    <span>
                                        <img src="images/images01.png" />
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="itemcol">
                            <div class="itembd">
                                <div class="top">
                                    <p class="number">20</p>
                                    <!--<p>On the Way</p>-->
                                </div>
                        
                                <div class="bottom">
                                    <div class="item1"><img src="images/up-right-arrow 1.png" /> 99%</div>
                        
                                    <div class="item2">Active Vehicles</div>
                        
                                    <div class="item3">
                                        <img src="images/vehicles.png" />
                                    </div>
                                </div>
                        
                                <div class="item-icon">
                                    <span>
                                        <img src="images/images01.png" />
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="itemcol">
                            <div class="itembd">
                                <div class="top">
                                    <p class="number">45</p>
                                    <!--<p>Loading</p>-->
                                </div>
                        
                                <div class="bottom">
                                    <div class="item1"><img src="images/up-right-arrow 1.png" /> 99%</div>
                        
                                    <div class="item2">Active Vehicles</div>
                        
                                    <div class="item3">
                                        <img src="images/vehicles.png" />
                                    </div>
                                </div>
                        
                                <div class="item-icon">
                                    <span>
                                        <img src="images/images01.png" />
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
                
                <!--tabs starts-->
                <div class="right-side-wrap mt-4">
                
                    <ul class="nav nav-pills" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-own_veh-tab" data-bs-toggle="pill" data-bs-target="#pills-own_veh" type="button" role="tab" aria-controls="pills-own_veh" aria-selected="true">Own Vehicle</button>
                        </li>
                        <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-ext_veh-tab" data-bs-toggle="pill" data-bs-target="#pills-ext_veh" type="button" role="tab" aria-controls="pills-ext_veh" aria-selected="false">External Vehicle</button>
                        </li>
                    </ul>
                    
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-own_veh" role="tabpanel" aria-labelledby="pills-own_veh-tab" tabindex="0">
                            <div class="accordion" id="accordionExample">
                                <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button filter-options" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    <div class="item-filter">
                                        <span class="filter-icon">
                                            <img src="images/icons/filter-01icon.png" alt="icon" />
                                        </span>
                                        <p>Filter Options</p>
                                    </div>
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                    <form class="filterbd">
                                        
                                        <!--<div class="row item-row01">-->
                                            
                                        <!--    <div class="col-lg-4 form-group">-->
                                        <!--        <label for="vehicleType">Vehicle</label>-->
                                        <!--        <div class="input-group mb-3">-->
                                        <!--          <input type="text" class="form-control" placeholder="Vehicle Type">-->
                                        <!--          <span class="input-group-text" id="vehicleType"><i class="uil uil-times-circle"></i></span>-->
                                        <!--        </div>-->
                                        <!--    </div>-->
                                
                                        <!--    <div class="col-lg-4 form-group">-->
                                        <!--        <label for="vehicleType">Party</label>-->
                                        <!--        <div class="input-group mb-3">-->
                                        <!--          <input type="text" class="form-control" placeholder="Search party..">-->
                                        <!--          <span class="input-group-text" id="vehicleType"><i class="uil uil-times-circle"></i></span>-->
                                        <!--        </div>-->
                                        <!--    </div>-->
                                
                                        <!--    <div class="col-lg-4 form-group">-->
                                        <!--        <label for="vehicleType">Date Range</label>-->
                                        <!--        <div class="input-group mb-3">-->
                                        <!--          <input type="text" class="form-control" name="daterange" placeholder="Select date range..." />-->
                                        <!--          <span class="input-group-text" id="vehicleType"><i class="uil uil-times-circle"></i></span>-->
                                        <!--        </div>-->
                                        <!--    </div>-->
                                            
                                        <!--</div>-->
                                
                                        <!--<div class="row item-row02">-->
                                        <!--    <div class="col-lg-5 form-group">-->
                                        <!--        <label for="vehicleType">Date Status</label>-->
                                        <!--        <div class="input-group mb-3">-->
                                        <!--          <input type="text" class="form-control" placeholder="Select Status...">-->
                                        <!--          <span class="input-group-text" id="vehicleType"><i class="uil uil-sync me-1"></i></span>-->
                                        <!--        </div>-->
                                        <!--    </div>-->
                                
                                        <!--    <div class="col-lg-5 form-group">-->
                                        <!--        <label for="search">Search</label>-->
                                        <!--        <div class="input-group">-->
                                        <!--          <input type="text" class="form-control" placeholder="Search by LR number, Ref LR number, route, material...">-->
                                        <!--          <span class="input-group-text"><i class="uil uil-search"></i></span>-->
                                        <!--          <span class="input-group-text"><i class="uil uil-sync me-1"></i></span>-->
                                        <!--        </div>-->
                                        <!--    </div>-->
                                            
                                        <!--    <div class="col-lg-2 form-group">-->
                                        <!--        <button class="btn btn-primary fxportbtn" type="button" style="margin-top: 30px;">Export <i class="uil uil-export"></i></button>-->
                                        <!--    </div>-->
                                        <!--</div>-->
                                        
                                        <!--/////////////////////////////////////////////////////////////////////////////////////////////////////-->
                                        
                                                <div class="filtersearch-bd justify-content-between">
                                                    
                                                    <div class="vehicletype">
                                                        <label>Start Date</label>
                                                        
                                                        <input type="text" class="form-control" name="daterange" placeholder="Select date range..." />
                                                            
                                                    </div>
                                                    
                                                    <div class="vehicletype ms-1">
                                                        <label>End Date</label>
                                                        
                                                            <input type="text" class="form-control" name="daterange" placeholder="Select date range..." />
                                                            
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
                                                            <option>Own</option>
                                                            <option>Rental</option>
                                                        </select>
                                                    </div>
                                                    
                                                    <div class="vehicletype ms-1">
                                                        <label>Priority</label>
                                                        <select class="form-select">
                                                            <option>Choose..</option>
                                                            <option>Normal</option>
                                                            <option>Urgent</option>
                                                        </select>
                                                    </div>
                                                    
                                                </div>
                                                
                                                <div class="filtersearch-bd searchfield justify-content-start mt-3">
                                                    
                                                    <div class="ms-1" style="width: 300px;">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" placeholder="Search by Trip Number">
                                                            <span class="input-group-text"><i class="uil uil-search"></i></span>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="ms-1" style="width: 300px;">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" placeholder="Search by Customer ID">
                                                            <span class="input-group-text"><i class="uil uil-search"></i></span>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="ms-1" style="width: 300px;">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" placeholder="Search by Driver">
                                                            <span class="input-group-text"><i class="uil uil-search"></i></span>
                                                        </div>
                                                    </div>
                                                    
                                                    <button class="btn btn-primary ms-1" type="button"><i class="uil uil-sync me-1"></i>Reset</button>
                                                    
                                                    <div class="dropdown ms-1">
                                                        <button class="btn btn-primary dropdown-toggle d-flex" type="button" id="exportBtn" data-bs-toggle="dropdown" aria-expanded="false">
                                                        Export <i class="uil uil-upload ms-1"></i>
                                                        </button>
                                                        <ul class="dropdown-menu" aria-labelledby="exportBtn">
                                                        <li><a class="dropdown-item" href="javascript:void(0)">Excel</a></li>
                                                        <li><a class="dropdown-item" href="javascript:void(0)">PDF</a></li>
                                                        </ul>
                                                    </div>
                                                    </div>
                                            <!---->
                                    </form>
                                    </div>
                                </div>
                                </div>
                            </div>
                            
                            <!---->
                            <div class="totalrevenue">
                                <div class="item-row">
                                    
                                    <div class="itemcol">
                                        <p>Total Revenue</p>
                                        <span class="number c-01">₹0</span>
                                    </div>
                            
                                    <div class="itemcol">
                                        <p>Total Deductions</p>
                                        <span class="number c-02">₹0</span>
                                    </div>
                            
                                    <div class="itemcol">
                                        <p>Total Received</p>
                                        <span class="number c-03">₹0</span>
                                    </div>
                            
                                    <div class="itemcol">
                                        <p>Total Balance</p>
                                        <span class="number c-04">₹0</span>
                                    </div>
                            
                                    <div class="itemcol">
                                        <p>Total Expenses</p>
                                        <span class="number c-05">₹0</span>
                                    </div>
                            
                                    <div class="itemcol">
                                        <p>Total Profit/Loss</p>
                                        <span class="number c-06">₹0</span>
                                    </div>
                                    
                                </div>
                            </div>
                            <!---->
                            
                            <div class="vehiclestable bg-light" style="display:block;">
                            <div class="container-fluid">
                                
                                <div class="itemtop">
                                    <span class="sec-title">Trips List</span>
                                    <a href="javascript:void(0)" class="addtripbtn" data-bs-toggle="modal" data-bs-target="#createTripModal"><i class="uil uil-plus me-1"></i>Add Trip</a>
                                </div>
                            
                                <!-- Card 1 -->
                                
                                <div class="sr_dashboard0_table table-responsive bg-transparent p-0">
                                    <table class="table custom-driver-table">
                                        <thead>
                                            <tr>
                                                <th>SL No.</th>
                                                <th>Trip ID</th>
                                                <th>Truck Vendor Name</th>
                                                <th>LR Date</th>
                                                <th>LR Number</th>
                                                <th>Vehicle Number</th>
                                                <th>Customer</th>
                                                <th>Source - Destination</th>
                                                <th>Trip Status</th>
                                                <th>POD Remarks</th>
                                                <th>Payment Status</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                            <tr>
                                                <td>1</td>
                                                <td>
                                                    <span class="value">#TRIP001</span>
                                                </td>
                                                
                                                <td><span class="value">Sujoy Ghosh</span><br><span class="value">+91 9087654321</span></td>
                                                
                                                <td><span class="value">12/01/2026</span></td>
                                                
                                                <td><span class="value">#LR110010</span></td>
                                                
                                                <td><span class="value">WB-01-VH1011</span></td>
                                                
                                                <td><span class="value">Anuj Maheta</span></td>
                                                
                                                <td><span class="value">HYD - PNE</span></td>
                                                
                                                <td><span class="badge bg-success">Initiated</span></td>
                                                
                                                <td><span class="value">This vehicle is ready for operation</span></td>
                                                
                                                <td><span class="badge bg-primary">Completed</span></td>
                                                <td>
                                                    <div class="actions">
                                                        <ul class="edti-delet">
                                                            <li><a class="item-edit text-success" href="trip-details.php"><i class="uil uil-eye me-2"></i></a></li>
                                                            <li><a class="item-delete text-danger"><i class="uil uil-trash-alt "></i></a></li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            
                                            <tr>
                                                <td>2</td>
                                                <td>
                                                    <span class="value">#TRIP002</span>
                                                </td>
                                                
                                                <td><span class="value">Sanjay Mitra</span><br><span class="value">+91 9087654301</span></td>
                                                
                                                <td><span class="value">13/01/2026</span></td>
                                                
                                                <td><span class="value">#LR110011</span></td>
                                                
                                                <td><span class="value">WB-01-VH1012</span></td>
                                                
                                                <td><span class="value">Amit Maheta</span></td>
                                                
                                                <td><span class="value">HYD - BGL</span></td>
                                                
                                                <td><span class="badge bg-warning">Ongoing</span></td>
                                                
                                                <td><span class="value">This vehicle is ready for operation</span></td>
                                                
                                                <td><span class="badge bg-danger">Pending</span></td>
                                                
                                                <td>
                                                    <div class="actions">
                                                        <ul class="edti-delet">
                                                            <li><a href="trip-details.php" class="item-edit text-success"><i class="uil uil-eye me-2"></i></a></li>
                                                            <li><a class="item-delete text-danger"><i class="uil uil-trash-alt "></i></a></li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <!--<div class="vehicle-card color-left01">-->
                                                
                                <!--    <a href="trip-details.php" class="info-grid" style="color: #000;">-->
                                <!--      <div class="info-item">-->
                                <!--        <div class="label">Trip Number</div>-->
                                <!--        <div class="value"><b>56667</b></div>-->
                                <!--      </div> -->
                                        
                                <!--      <div class="info-item">-->
                                <!--        <div class="label">Start Date</div>-->
                                <!--        <div class="value"><b>19-09-2025</b></div>-->
                                <!--      </div> -->
                                        
                                <!--      <div class="info-item">-->
                                <!--        <div class="label">End Date</div>-->
                                <!--        <div class="value"><b>25-09-2025</b></div>-->
                                <!--      </div>-->
                                        
                                <!--       <div class="info-item">-->
                                <!--          <div class="label">Vehicle Number</div>-->
                                <!--        <div class="value"><b>WB-12-AB-1237</b></div>-->
                                <!--      </div> -->
                                
                                <!--      <div class="info-item">-->
                                <!--        <div class="label">Driver</div>-->
                                <!--        <div class="value">Sujit Paul</div>-->
                                <!--      </div>-->
                                
                                <!--      <div class="info-item">-->
                                <!--        <div class="label">Customer</div>-->
                                <!--        <div class="value">John Doe</div>-->
                                <!--      </div>-->
                                
                                <!--      <div class="info-item">-->
                                <!--        <div class="label">LR#</div>-->
                                <!--        <div class="value">LR#2897</div>-->
                                <!--      </div>-->
                                
                                <!--      <div class="info-item">-->
                                <!--        <div class="label">Route</div>-->
                                <!--        <div class="value">HYD - KOL</div>-->
                                <!--      </div>-->
                                        
                                <!--      <div class="info-item">-->
                                <!--        <div class="label">Priority</div>-->
                                <!--        <div class="value"><span class="badge bg-success">Normal</span></div>-->
                                <!--      </div>-->
                                
                                <!--      <div class="info-item">-->
                                <!--        <div class="label">Status</div>-->
                                <!--        <div class="value">Trip initiated</div>-->
                                <!--      </div>-->
                                
                                <!--      <div class="actions">-->
                                <!--        ////-->
                                <!--            <ul class="edti-delet">-->
                                <!--                <li><a class="item-edit text-success"><i class="uil uil-eye me-2"></i></a></li>-->
                                <!--                <li><a class="item-delete text-danger"><i class="uil uil-trash-alt "></i></a></li>-->
                                <!--            </ul>-->
                                <!--        ////-->
                                <!--      </div>-->
                                <!--    </a>-->
                                <!--</div>-->
                                
                                <!--<div class="vehicle-card color-left02">-->
                                                
                                <!--    <a href="trip-details2.php" style="color: #000;" class="info-grid">-->
                                <!--      <div class="info-item">-->
                                <!--        <div class="label">Trip Number</div>-->
                                <!--        <div class="value"><b>55867</b></div>-->
                                <!--      </div> -->
                                        
                                <!--      <div class="info-item">-->
                                <!--        <div class="label">Start Date</div>-->
                                <!--        <div class="value"><b>10-09-2025</b></div>-->
                                <!--      </div> -->
                                        
                                <!--      <div class="info-item">-->
                                <!--        <div class="label">End Date</div>-->
                                <!--        <div class="value"><b>25-09-2025</b></div>-->
                                <!--      </div>-->
                                        
                                <!--       <div class="info-item">-->
                                <!--          <div class="label">Vehicle Number</div>-->
                                <!--        <div class="value"><b>UP-12-AB-1237</b></div>-->
                                <!--      </div> -->
                                
                                <!--      <div class="info-item">-->
                                <!--        <div class="label">Driver</div>-->
                                <!--        <div class="value">Asis Das</div>-->
                                <!--      </div>-->
                                
                                <!--      <div class="info-item">-->
                                <!--        <div class="label">Customer</div>-->
                                <!--        <div class="value">John Doe</div>-->
                                <!--      </div>-->
                                
                                <!--      <div class="info-item">-->
                                <!--        <div class="label">LR#</div>-->
                                <!--        <div class="value">LR#2587</div>-->
                                <!--      </div>-->
                                
                                <!--      <div class="info-item">-->
                                <!--        <div class="label">Route</div>-->
                                <!--        <div class="value">HYD - KOL</div>-->
                                <!--      </div>-->
                                        
                                <!--      <div class="info-item">-->
                                <!--        <div class="label">Priority</div>-->
                                <!--        <div class="value"><span class="badge bg-danger">Urgent</span></div>-->
                                <!--      </div>-->
                                
                                <!--      <div class="info-item">-->
                                <!--        <div class="label">Status</div>-->
                                <!--        <div class="value">Trip initiated</div>-->
                                <!--      </div>-->
                                
                                <!--      <div class="actions">-->
                                <!--        ////-->
                                <!--            <ul class="edti-delet">-->
                                <!--                <li><a class="item-edit text-success"><i class="uil uil-eye me-2"></i></a></li>-->
                                <!--                <li><a class="item-delete text-danger"><i class="uil uil-trash-alt "></i></a></li>-->
                                <!--            </ul>-->
                                <!--        ////-->
                                <!--      </div>-->
                                        
                                <!--    </a>-->
                                
                                <!--</div>-->
                                
                                <!--    <div class="vehicle-card color-left03">-->
                                                
                                <!--    <a href="trip-details.php" style="color: #000;" class="info-grid">-->
                                <!--      <div class="info-item">-->
                                <!--        <div class="label">Trip Number</div>-->
                                <!--        <div class="value"><b>56667</b></div>-->
                                <!--      </div> -->
                                        
                                <!--      <div class="info-item">-->
                                <!--        <div class="label">Start Date</div>-->
                                <!--        <div class="value"><b>19-09-2025</b></div>-->
                                <!--      </div> -->
                                        
                                <!--      <div class="info-item">-->
                                <!--        <div class="label">End Date</div>-->
                                <!--        <div class="value"><b>25-09-2025</b></div>-->
                                <!--      </div>-->
                                        
                                <!--       <div class="info-item">-->
                                <!--          <div class="label">Vehicle Number</div>-->
                                <!--        <div class="value"><b>WB-12-AB-1237</b></div>-->
                                <!--      </div> -->
                                
                                <!--      <div class="info-item">-->
                                <!--        <div class="label">Driver</div>-->
                                <!--        <div class="value">Sujit Paul</div>-->
                                <!--      </div>-->
                                
                                <!--      <div class="info-item">-->
                                <!--        <div class="label">Customer</div>-->
                                <!--        <div class="value">John Doe</div>-->
                                <!--      </div>-->
                                
                                <!--      <div class="info-item">-->
                                <!--        <div class="label">LR#</div>-->
                                <!--        <div class="value">LR#2897</div>-->
                                <!--      </div>-->
                                
                                <!--      <div class="info-item">-->
                                <!--        <div class="label">Route</div>-->
                                <!--        <div class="value">HYD - KOL</div>-->
                                <!--      </div>-->
                                        
                                <!--      <div class="info-item">-->
                                <!--        <div class="label">Priority</div>-->
                                <!--        <div class="value"><span class="badge bg-success">Normal</span></div>-->
                                <!--      </div>-->
                                
                                <!--      <div class="info-item">-->
                                <!--        <div class="label">Status</div>-->
                                <!--        <div class="value">Trip initiated</div>-->
                                <!--      </div>-->
                                
                                <!--      <div class="actions">-->
                                <!--        ////-->
                                <!--            <ul class="edti-delet">-->
                                <!--                <li><a class="item-edit text-success"><i class="uil uil-eye me-2"></i></a></li>-->
                                <!--                <li><a class="item-delete text-danger"><i class="uil uil-trash-alt "></i></a></li>-->
                                <!--            </ul>-->
                                <!--        ////-->
                                <!--      </div>-->
                                        
                                <!--    </a>-->
                                
                                <!--  </div>-->
                                    
                                <!--    <div class="vehicle-card color-left01">-->
                                                    
                                <!--        <a href="trip-details.php" style="color: #000;" class="info-grid">-->
                                <!--          <div class="info-item">-->
                                <!--            <div class="label">Trip Number</div>-->
                                <!--            <div class="value"><b>56667</b></div>-->
                                <!--          </div> -->
                                            
                                <!--          <div class="info-item">-->
                                <!--            <div class="label">Start Date</div>-->
                                <!--            <div class="value"><b>19-09-2025</b></div>-->
                                <!--          </div> -->
                                            
                                <!--          <div class="info-item">-->
                                <!--            <div class="label">End Date</div>-->
                                <!--            <div class="value"><b>25-09-2025</b></div>-->
                                <!--          </div>-->
                                            
                                <!--           <div class="info-item">-->
                                <!--              <div class="label">Vehicle Number</div>-->
                                <!--            <div class="value"><b>WB-12-AB-1237</b></div>-->
                                <!--          </div> -->
                                    
                                <!--          <div class="info-item">-->
                                <!--            <div class="label">Driver</div>-->
                                <!--            <div class="value">Sujit Paul</div>-->
                                <!--          </div>-->
                                    
                                <!--          <div class="info-item">-->
                                <!--            <div class="label">Customer</div>-->
                                <!--            <div class="value">John Doe</div>-->
                                <!--          </div>-->
                                    
                                <!--          <div class="info-item">-->
                                <!--            <div class="label">LR#</div>-->
                                <!--            <div class="value">LR#2897</div>-->
                                <!--          </div>-->
                                    
                                <!--          <div class="info-item">-->
                                <!--            <div class="label">Route</div>-->
                                <!--            <div class="value">HYD - KOL</div>-->
                                <!--          </div>-->
                                            
                                <!--          <div class="info-item">-->
                                <!--            <div class="label">Priority</div>-->
                                <!--            <div class="value"><span class="badge bg-danger">Urgent</span></div>-->
                                <!--          </div>-->
                                    
                                <!--          <div class="info-item">-->
                                <!--            <div class="label">Status</div>-->
                                <!--            <div class="value">Trip initiated</div>-->
                                <!--          </div>-->
                                    
                                <!--          <div class="actions">-->
                                <!--            ////-->
                                <!--                <ul class="edti-delet">-->
                                <!--                    <li><a class="item-edit text-success"><i class="uil uil-eye me-2"></i></a></li>-->
                                <!--                    <li><a class="item-delete text-danger"><i class="uil uil-trash-alt "></i></a></li>-->
                                <!--                </ul>-->
                                <!--            ////-->
                                <!--          </div>-->
                                            
                                <!--        </a>-->
                                    
                                <!--      </div>-->
                                <!--    <div class="vehicle-card color-left02">-->
                                                    
                                <!--        <a href="trip-details.php" style="color: #000;" class="info-grid">-->
                                <!--          <div class="info-item">-->
                                <!--            <div class="label">Trip Number</div>-->
                                <!--            <div class="value"><b>56667</b></div>-->
                                <!--          </div> -->
                                            
                                <!--          <div class="info-item">-->
                                <!--            <div class="label">Start Date</div>-->
                                <!--            <div class="value"><b>19-09-2025</b></div>-->
                                <!--          </div> -->
                                            
                                <!--          <div class="info-item">-->
                                <!--            <div class="label">End Date</div>-->
                                <!--            <div class="value"><b>25-09-2025</b></div>-->
                                <!--          </div>-->
                                            
                                <!--           <div class="info-item">-->
                                <!--              <div class="label">Vehicle Number</div>-->
                                <!--            <div class="value"><b>WB-12-AB-1237</b></div>-->
                                <!--          </div> -->
                                    
                                <!--          <div class="info-item">-->
                                <!--            <div class="label">Driver</div>-->
                                <!--            <div class="value">Sujit Paul</div>-->
                                <!--          </div>-->
                                    
                                <!--          <div class="info-item">-->
                                <!--            <div class="label">Customer</div>-->
                                <!--            <div class="value">John Doe</div>-->
                                <!--          </div>-->
                                    
                                <!--          <div class="info-item">-->
                                <!--            <div class="label">LR#</div>-->
                                <!--            <div class="value">LR#2897</div>-->
                                <!--          </div>-->
                                    
                                <!--          <div class="info-item">-->
                                <!--            <div class="label">Route</div>-->
                                <!--            <div class="value">HYD - KOL</div>-->
                                <!--          </div>-->
                                            
                                <!--          <div class="info-item">-->
                                <!--            <div class="label">Priority</div>-->
                                <!--            <div class="value"><span class="badge bg-success">Normal</span></div>-->
                                <!--          </div>-->
                                    
                                <!--          <div class="info-item">-->
                                <!--            <div class="label">Status</div>-->
                                <!--            <div class="value">Trip initiated</div>-->
                                <!--          </div>-->
                                    
                                <!--          <div class="actions">-->
                                <!--            ////-->
                                <!--                <ul class="edti-delet">-->
                                <!--                    <li><a class="item-edit text-success"><i class="uil uil-eye me-2"></i></a></li>-->
                                <!--                    <li><a class="item-delete text-danger"><i class="uil uil-trash-alt "></i></a></li>-->
                                <!--                </ul>-->
                                <!--            ////-->
                                <!--          </div>-->
                                            
                                <!--        </a>-->
                                    
                                <!--    </div>-->
                                </div>
                            </div>
                            
                            <!--/////////////////////////////////////////////////////////////////////////////////////////////-->
                            
                                <!--sr_dashboard0_table-->
                                    <div class="sr_dashboard0_table" style="display:none;">
                                        <div class="container-fluid">
                                            <div class="itemtop">
                                                <span class="sec-title">Trips List</span>
                                                <a href="javascript:void(0)" class="addtripbtn" data-bs-toggle="modal" data-bs-target="#createTripModal"><i class="uil uil-plus me-1"></i>Add Trip</a>
                                            </div>
                                    
                                            <div class="table-responsive">
                                                <table class="table custom-driver-table">
                                                    <thead>
                                                        <tr>
                                                            <th>Trip Number</th>
                                                            <th>Start Date</th>
                                                            <th>End Date</th>
                                                            <th>Vehicle Number</th>
                                                            <th>Driver</th>
                                                            <th>Customer</th>
                                                            <th>LR#</th>
                                                            <th>Route</th>
                                                            <th>Priority</th>
                                                            <th>Status</th>
                                                            <th class="text-center">Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        
                                                        <tr onclick="window.location.href='trip-details.php'" style="cursor:pointer;">
                                                            
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <span class="value">56667</span>
                                                                </div>
                                                            </td>
                                                            
                                                            <td><span class="value">08-09-2025</span></td>
                                                            
                                                            <td><span class="value">25-09-2025</span></td>
                                                            
                                                            <td><span class="value">WB-12-AB-1237</span></td>
                                                            
                                                            <td><span class="value">Sujit Paul</span></td>
                                                            
                                                            <td><span class="value">John Doe</span></td>
                                                            
                                                            <td><span class="value">LR#2897</span></td>
                                                            
                                                            <td><span class="value">HYD - KOL</span></td>
                                                            
                                                            <td>
                                                                <span class="value badge bg-success">Normal</span>
                                                            </td>
                                                            
                                                            <td><span class="value">Trip initiated</span></td>
                    
                                                            <td class="text-center">
                                                                <div class="btn_bd mt-2">
                                                                    <ul class="edti-delet">
                                                                        <li>
                                                                            <a href="trip-details.php" class="info-grid" style="color: #000;"></a>
                                                                            <a class="item-edit text-success"><i class="uil uil-eye me-2"></i></a>
                                                                        </li>
                                                                    
                                                                        <li>
                                                                            <a class="item-delete text-danger"><i class="uil uil-trash-alt "></i></a>
                                                                        </li>
                                                                    
                                                                    </ul>
                                                                </div>
                                                                
                                                            </td>
                                                        </tr>
                                                        
                                                        
                                                        
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                <!--sr_dashboard0_table-->
                                    
                            <!--/////////////////////////////////////////////////////////////////////////////////////////////-->
                            
                        </div>
                        
                        <div class="tab-pane fade" id="pills-ext_veh" role="tabpanel" aria-labelledby="pills-ext_veh-tab" tabindex="0">
                            <div class="accordion" id="accordionExample">
                                <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button filter-options" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    <div class="item-filter">
                                        <span class="filter-icon">
                                            <img src="images/icons/filter-01icon.png" alt="icon" />
                                        </span>
                                        <p>Filter Options</p>
                                    </div>
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                    <form class="filterbd">
                                        <div class="filtersearch-bd justify-content-between">
                                            
                                            <div class="vehicletype">
                                                <label>Start Date</label>
                                                
                                                <input type="text" class="form-control" name="daterange" placeholder="Select date range..." />
                                                    
                                            </div>
                                            
                                            <div class="vehicletype ms-1">
                                                <label>End Date</label>
                                                
                                                    <input type="text" class="form-control" name="daterange" placeholder="Select date range..." />
                                                    
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
                                                    <option>Own</option>
                                                    <option>Rental</option>
                                                </select>
                                            </div>
                                            
                                            <div class="vehicletype ms-1">
                                                <label>Priority</label>
                                                <select class="form-select">
                                                    <option>Choose..</option>
                                                    <option>Normal</option>
                                                    <option>Urgent</option>
                                                </select>
                                            </div>
                                            
                                        </div>
                                        
                                        <div class="filtersearch-bd searchfield justify-content-start mt-3">
                                            
                                            <div class="ms-1" style="width: 300px;">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" placeholder="Search by Trip Number">
                                                    <span class="input-group-text"><i class="uil uil-search"></i></span>
                                                </div>
                                            </div>
                                            
                                            <div class="ms-1" style="width: 300px;">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" placeholder="Search by Customer ID">
                                                    <span class="input-group-text"><i class="uil uil-search"></i></span>
                                                </div>
                                            </div>
                                            
                                            <div class="ms-1" style="width: 300px;">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" placeholder="Search by Driver">
                                                    <span class="input-group-text"><i class="uil uil-search"></i></span>
                                                </div>
                                            </div>
                                            
                                            <button class="btn btn-primary ms-1" type="button"><i class="uil uil-sync me-1"></i>Reset</button>
                                            
                                            <div class="dropdown ms-1">
                                                <button class="btn btn-primary dropdown-toggle d-flex" type="button" id="exportBtn" data-bs-toggle="dropdown" aria-expanded="false">
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
                            
                            <!---------------------------------------------------->
                            <div class="totalrevenue">
                                
                                <div class="item-row">
                                    
                                    <div class="itemcol">
                                        <p>Total Revenue</p>
                                        <span class="number c-01">₹0</span>
                                    </div>
                            
                                    <div class="itemcol">
                                        <p>Total Deductions</p>
                                        <span class="number c-02">₹0</span>
                                    </div>
                            
                                    <div class="itemcol">
                                        <p>Total Received</p>
                                        <span class="number c-03">₹0</span>
                                    </div>
                            
                                    <div class="itemcol">
                                        <p>Total Balance</p>
                                        <span class="number c-04">₹0</span>
                                    </div>
                            
                                    <div class="itemcol">
                                        <p>Total Expenses</p>
                                        <span class="number c-05">₹0</span>
                                    </div>
                            
                                    <div class="itemcol">
                                        <p>Total Profit/Loss</p>
                                        <span class="number c-06">₹0</span>
                                    </div>
                                </div>
                            </div>
                            <!---->
                            
                            <div class="vehiclestable bg-light">
                            <div class="container-fluid">
                                
                                <div class="itemtop">
                                    <span class="sec-title">Trips List</span>
                                    <a href="javascript:void(0)" class="addtripbtn" data-bs-toggle="modal" data-bs-target="#createTripModal"><i class="uil uil-plus me-1"></i>Add Trip</a>
                                </div>
                            
                                <!-- Card 1 -->
                                
                                <div class="vehicle-card color-left01">
                                                
                                    <a href="trip-details.php" class="info-grid" style="color: #000;">
                                        <div class="info-item">
                                            <div class="label">Vehicle Number</div>
                                        <div class="value"><b>WB-12-AB-1237</b></div>
                                        </div> 
                                
                                        <div class="info-item">
                                        <div class="label">Owner Name</div>
                                        <div class="value">Sujit Paul</div>
                                        </div>
                                
                                        <div class="info-item">
                                        <div class="label">Owner Number</div>
                                        <div class="value">+91 9876543210</div>
                                        </div>
                                
                                        <div class="info-item">
                                        <div class="label">Ongoing Trip #</div>
                                        <div class="value">#TRIP00678</div>
                                        </div>
                                
                                        <div class="info-item">
                                        <div class="label">Current Driver</div>
                                        <div class="value">Ashoke Singh</div>
                                        </div>
                                
                                        <div class="info-item">
                                        <div class="label">Live Location</div>
                                        <div class="value">Kolkata</div>
                                        </div>
                                        
                                        <div class="info-item">
                                        <div class="label">Priority</div>
                                        <div class="value"><span class="badge bg-success">Normal</span></div>
                                        </div>
                                
                                        <div class="actions">
                                        <!--////-->
                                            <ul class="edti-delet">
                                                <li><a class="item-edit text-success" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#viewDet"><i class="uil uil-eye me-2"></i></a></li>
                                                <li><a class="item-delete text-danger"><i class="uil uil-trash-alt "></i></a></li>
                                            </ul>
                                        <!--////-->
                                        </div>
                                    </a>
                                </div>
                                
                                <div class="vehicle-card color-left02">
                                                
                                    <a href="trip-details.php" class="info-grid" style="color: #000;">
                                        <div class="info-item">
                                            <div class="label">Vehicle Number</div>
                                        <div class="value"><b>WB-12-AB-1237</b></div>
                                        </div> 
                                
                                        <div class="info-item">
                                        <div class="label">Owner Name</div>
                                        <div class="value">Sujit Paul</div>
                                        </div>
                                
                                        <div class="info-item">
                                        <div class="label">Owner Number</div>
                                        <div class="value">+91 9876543210</div>
                                        </div>
                                
                                        <div class="info-item">
                                        <div class="label">Ongoing Trip #</div>
                                        <div class="value">#TRIP00678</div>
                                        </div>
                                
                                        <div class="info-item">
                                        <div class="label">Current Driver</div>
                                        <div class="value">Ashoke Singh</div>
                                        </div>
                                
                                        <div class="info-item">
                                        <div class="label">Live Location</div>
                                        <div class="value">Kolkata</div>
                                        </div>
                                        
                                        <div class="info-item">
                                        <div class="label">Priority</div>
                                        <div class="value"><span class="badge bg-danger">Urgent</span></div>
                                        </div>
                                
                                        <div class="actions">
                                        <!--////-->
                                            <ul class="edti-delet">
                                                <li><a class="item-edit text-success" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#viewDet"><i class="uil uil-eye me-2"></i></a></li>
                                                <li><a class="item-delete text-danger"><i class="uil uil-trash-alt "></i></a></li>
                                            </ul>
                                        <!--////-->
                                        </div>
                                    </a>
                                
                                </div>
                                    <div class="vehicle-card color-left03">
                                                
                                    <a href="trip-details.php" class="info-grid" style="color: #000;">
                                        <div class="info-item">
                                            <div class="label">Vehicle Number</div>
                                        <div class="value"><b>WB-12-AB-1237</b></div>
                                        </div> 
                                
                                        <div class="info-item">
                                        <div class="label">Owner Name</div>
                                        <div class="value">Sujit Paul</div>
                                        </div>
                                
                                        <div class="info-item">
                                        <div class="label">Owner Number</div>
                                        <div class="value">+91 9876543210</div>
                                        </div>
                                
                                        <div class="info-item">
                                        <div class="label">Ongoing Trip #</div>
                                        <div class="value">#TRIP00678</div>
                                        </div>
                                
                                        <div class="info-item">
                                        <div class="label">Current Driver</div>
                                        <div class="value">Ashoke Singh</div>
                                        </div>
                                
                                        <div class="info-item">
                                        <div class="label">Live Location</div>
                                        <div class="value">Kolkata</div>
                                        </div>
                                        
                                        <div class="info-item">
                                        <div class="label">Priority</div>
                                        <div class="value"><span class="badge bg-success">Normal</span></div>
                                        </div>
                                
                                        <div class="actions">
                                        <!--////-->
                                            <ul class="edti-delet">
                                                <li><a class="item-edit text-success" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#viewDet"><i class="uil uil-eye me-2"></i></a></li>
                                                <li><a class="item-delete text-danger"><i class="uil uil-trash-alt "></i></a></li>
                                            </ul>
                                        <!--////-->
                                        </div>
                                    </a>
                                
                                    </div>
                                    
                                    <div class="vehicle-card color-left01">
                                                    
                                        <a href="trip-details.php" class="info-grid" style="color: #000;">
                                        <div class="info-item">
                                            <div class="label">Vehicle Number</div>
                                        <div class="value"><b>WB-12-AB-1237</b></div>
                                        </div> 
                                
                                        <div class="info-item">
                                        <div class="label">Owner Name</div>
                                        <div class="value">Sujit Paul</div>
                                        </div>
                                
                                        <div class="info-item">
                                        <div class="label">Owner Number</div>
                                        <div class="value">+91 9876543210</div>
                                        </div>
                                
                                        <div class="info-item">
                                        <div class="label">Ongoing Trip #</div>
                                        <div class="value">#TRIP00678</div>
                                        </div>
                                
                                        <div class="info-item">
                                        <div class="label">Current Driver</div>
                                        <div class="value">Ashoke Singh</div>
                                        </div>
                                
                                        <div class="info-item">
                                        <div class="label">Live Location</div>
                                        <div class="value">Kolkata</div>
                                        </div>
                                        
                                        <div class="info-item">
                                        <div class="label">Priority</div>
                                        <div class="value"><span class="badge bg-danger">Urgent</span></div>
                                        </div>
                                
                                        <div class="actions">
                                        <!--////-->
                                            <ul class="edti-delet">
                                                <li><a class="item-edit text-success" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#viewDet"><i class="uil uil-eye me-2"></i></a></li>
                                                <li><a class="item-delete text-danger"><i class="uil uil-trash-alt "></i></a></li>
                                            </ul>
                                        <!--////-->
                                        </div>
                                    </a> 
                                    
                                        </div>
                                    <div class="vehicle-card color-left02">
                                                    
                                        <a href="trip-details.php" class="info-grid" style="color: #000;">
                                        <div class="info-item">
                                            <div class="label">Vehicle Number</div>
                                        <div class="value"><b>WB-12-AB-1237</b></div>
                                        </div> 
                                
                                        <div class="info-item">
                                        <div class="label">Owner Name</div>
                                        <div class="value">Sujit Paul</div>
                                        </div>
                                
                                        <div class="info-item">
                                        <div class="label">Owner Number</div>
                                        <div class="value">+91 9876543210</div>
                                        </div>
                                
                                        <div class="info-item">
                                        <div class="label">Ongoing Trip #</div>
                                        <div class="value">#TRIP00678</div>
                                        </div>
                                
                                        <div class="info-item">
                                        <div class="label">Current Driver</div>
                                        <div class="value">Ashoke Singh</div>
                                        </div>
                                
                                        <div class="info-item">
                                        <div class="label">Live Location</div>
                                        <div class="value">Kolkata</div>
                                        </div>
                                        
                                        <div class="info-item">
                                        <div class="label">Priority</div>
                                        <div class="value"><span class="badge bg-success">Normal</span></div>
                                        </div>
                                
                                        <div class="actions">
                                        <!--////-->
                                            <ul class="edti-delet">
                                                <li><a class="item-edit text-success" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#viewDet"><i class="uil uil-eye me-2"></i></a></li>
                                                <li><a class="item-delete text-danger"><i class="uil uil-trash-alt "></i></a></li>
                                            </ul>
                                        <!--////-->
                                        </div>
                                    </a>
                                    
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <!--tab ends-->
            </div>
        </div> 
    </div>
</div>{{-- /layout-wrapper --}}

{{-- ═══════════════════════════════════════════════════════════════
     CREATE TRIP MODAL — modal-xl, two fields per row
═══════════════════════════════════════════════════════════════ --}}
<div class="modal fade" id="createTripModal" tabindex="-1" aria-labelledby="createTripModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Trip</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="uil uil-times"></i></button>
            </div>
            <div class="modal-body">
                <form id="createTripForm">

                    {{-- Row 1: Trip ID | Trip Date --}}
                    <div class="row mb-3">
                        <div class="col-md-6 form-group">
                            <label class="form-label">Trip ID</label>
                            <input type="text" class="form-control bg-light" readonly placeholder="Will be auto generated"/>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="form-label">Trip Date</label>
                            <input type="text" id="daterange" class="form-control" placeholder="DD/MM/YYYY">
                        </div>
                    </div>

                    {{-- Row 2: Trip Type | Trip Category --}}
                    <div class="row mb-3">
                        <div class="col-md-6 form-group">
                            <label class="form-label">Trip Type</label>
                            <select class="form-select">
                                <option>Choose..</option>
                                <option>Own Booking</option>
                                <option>Outside Booking</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="form-label">Trip Category</label>
                            <div class="d-flex align-items-center" style="min-height:38px;">
                                <div class="form-check me-3">
                                    <input class="form-check-input" type="radio" name="tripCategory" id="line" value="Line">
                                    <label class="form-check-label" for="line">Line</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="tripCategory" id="local" value="Local">
                                    <label class="form-check-label" for="local">Local</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Row 3: Load Vendor | RAG Status --}}
                    <div class="row mb-3">
                        <div class="col-md-6 form-group">
                            <label class="form-label">Load Vendor</label>
                            <select class="form-select">
                                <option>Choose..</option>
                                <option>DHL</option>
                                <option>Blue Dart</option>
                                <option>Fed Ex</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="form-label">RAG Status</label>
                            <div class="d-flex align-items-center gap-2" style="min-height:38px;">
                                <span class="badge bg-danger">Red</span>
                                <span class="badge bg-warning">Yellow</span>
                                <span class="badge bg-success">Green</span>
                            </div>
                        </div>
                    </div>

                    {{-- Row 4: Customer | Vehicle Type --}}
                    <div class="row mb-3">
                        <div class="col-md-6 form-group">
                            <label class="form-label">Customer</label>
                            <select class="form-select">
                                <option>Choose..</option>
                                <option>Nestle</option>
                                <option>Britania</option>
                                <option>Samsung</option>
                            </select>
                            <div class="text-end mt-1">
                                <a href="add-customer.php" style="font-size: 13px;"><i class="uil uil-plus me-1"></i> Add Customer</a>
                            </div>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="form-label">Vehicle Type</label>
                            <select class="form-select">
                                <option>Choose..</option>
                                <option>Large Container</option>
                                <option>Truck</option>
                            </select>
                        </div>
                    </div>

                    {{-- Row 5: Vehicle Size | Internal Trip ID --}}
                    <div class="row mb-3">
                        <div class="col-md-6 form-group">
                            <label class="form-label">Vehicle Size</label>
                            <select class="form-select">
                                <option>Choose..</option>
                                <option>14 FT - XXM 14M * 9M * 12M</option>
                                <option>28 FT - XXL 28M * 12M * 17M</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="form-label">Internal Trip ID</label>
                            <input type="text" class="form-control"/>
                        </div>
                    </div>

                    {{-- Row 6: Route | Source --}}
                    <div class="row mb-3">
                        <div class="col-md-6 form-group">
                            <label class="form-label">Route</label>
                            <select class="form-select">
                                <option>Choose..</option>
                                <option>Chennai - Kolkata</option>
                                <option>Chennai - Hydrabad</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="form-label">Source</label>
                            <input type="text" class="form-control bg-light" value="Chennai" />
                        </div>
                    </div>

                    {{-- Midpoint section — full width (complex) --}}
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="add-stop">
                                <div class="row form-group">
                                    <div class="col-12 col-md-3">
                                        <label>Midpoint 1</label>
                                    </div>
                                    <div class="col-10 col-md-8">
                                        <select class="form-select">
                                            <option>Choose...</option>
                                            <option>Kolkata</option>
                                            <option>Bihar</option>
                                        </select>
                                    </div>
                                    <div class="col-2 col-md-1">
                                        <i class="uil uil-trash-alt text-danger removeStop"></i>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-12 col-md-3">
                                        <label>Midpoint Type</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <div class="form-check form-check-inline radio-chip">
                                            <input class="form-check-input" type="radio" name="midpoint_type" id="loading" value="Loading">
                                            <label class="form-check-label if-loading" for="loading"><i class="uil uil-check-circle me-1"></i>Loading</label>
                                        </div>
                                        <div class="form-check form-check-inline radio-chip">
                                            <input class="form-check-input" type="radio" name="midpoint_type" id="unloading" value="Unloading">
                                            <label class="form-check-label if-unloading" for="unloading"><i class="uil uil-check-circle me-1"></i>Unloading</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a href="javascript:void(0)" class="btn btn-secondary add-stop-btn"><i class="uil uil-plus me-1"></i>Midpoint</a>
                        </div>
                    </div>

                    {{-- Row 7: Destination | Distance --}}
                    <div class="row mb-3">
                        <div class="col-md-6 form-group">
                            <label class="form-label">Destination</label>
                            <input type="text" class="form-control bg-light" readonly value="Kolkata" />
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="form-label">Distance</label>
                            <input type="text" class="form-control bg-light" readonly value="10 KM" />
                        </div>
                    </div>

                    {{-- Row 8: Priority | Tarpaulin --}}
                    <div class="row mb-3">
                        <div class="col-md-6 form-group">
                            <label class="form-label">Priority</label>
                            <div class="d-flex align-items-center" style="min-height:38px;">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="priority" id="priority_normal" value="Normal">
                                    <label class="form-check-label" for="priority_normal">Normal</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="priority" id="priority_urgent" value="Urgent">
                                    <label class="form-check-label" for="priority_urgent">Urgent</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="form-label">Tarpaulin</label>
                            <div class="d-flex align-items-center" style="min-height:38px;">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="tirpal" id="tirpal_yes" value="Yes">
                                    <label class="form-check-label" for="tirpal_yes">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="tirpal" id="tirpal_no" value="No">
                                    <label class="form-check-label" for="tirpal_no">No</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Comment — full width --}}
                    <div class="row mb-3">
                        <div class="col-12 form-group">
                            <label class="form-label">Comment</label>
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

@endsection

@section('js')
<script src="{{ asset('customjs/trip/trip.js?v=1.1') }}"></script>
@endsection
