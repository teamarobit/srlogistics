@extends('layouts.app')

@section('css')
<link href="{{ asset('css/trip/show.css?v=1.0') }}" rel="stylesheet">
@endsection

@section('content')
<div class="layout-wrapper">

    @include('includes.header')

    <div class="vehicledtl-bd srlog-bdwrapper">
        <div class="topbar-bd">
            <div class="item1">
                <div class="container-fluid">
                    <h1>Trip Details</h1>
                </div>
            </div>
    
            <div class="item2">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <div class="col-lg-5">
                            <div class="ltblock">
                                <div class="icon_car">
                                    <img src="images/icons/car-icon04.png" />
                                </div>
    
                                <div class="text">
                                    <div class="topsec mb-1">
                                        <p>Kolkata - Mumbai</p>
                                    </div>
                                    <div style="font-size: 12px;">
                                        <span>Status:</span>
                                        <span class="text-success">Initiated</span>
                                    </div>
                                    <div style="font-size: 12px;">
                                        <span class="">Created On:</span>
                                        <span>25/10/2025</span>
                                    </div>
                                    <div style="font-size: 12px;">
                                        <span class="">Created By:</span>
                                        <span>Anmol Kaur</span>
                                    </div>
                                </div>
    
                                <div class="liveloc_sec">
                                    <span>Vehicle Allocated</span>
                                    <p class="text-warning">Pending</p>
                                </div>
                            </div>
                        </div>
    
                        <div class="col-lg-7 text-end">
                            <button class="btn btn-primary attachment-click"><i class="uil uil-paperclip me-1"></i>Attachments</button>
                            <!--<button class="btn btn-secondary"><i class="uil uil-hourglass me-1"></i>Start Tracking</button>-->
                            <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#closeTrip"><i class="uil uil-check-circle me-1"></i>Settle Trip</button>
                            <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#cancelTrip"><i class="uil uil-times-circle me-1"></i>Cancel Trip</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="vehicleinfo-wrap">
            
            <div class="vehicleinfo-sec">
                <div class="container-fluid">
                    <div class="timeline-wrap">
                        <div class="row">
                            <div class="col-12 col-md-3">
                                <div class="nav flex-column nav-pills ms-3 ps-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                    <button class="nav-link timeline-active active" id="v-pills-tripInit-tab" data-bs-toggle="pill" data-bs-target="#v-pills-tripInit" type="button" role="tab" aria-controls="v-pills-tripInit" aria-selected="true">Trip Initiation</button>
                                    <button class="nav-link" id="v-pills-vehAllocation-tab" data-bs-toggle="pill" data-bs-target="#v-pills-vehAllocation" type="button" role="tab" aria-controls="v-pills-vehAllocation" aria-selected="false" tabindex="-1">Vehicle Allocation</button>
                                    <button class="nav-link" id="v-pills-vehStatus-tab" data-bs-toggle="pill" data-bs-target="#v-pills-vehStatus" type="button" role="tab" aria-controls="v-pills-vehStatus" aria-selected="false" tabindex="-1">Vehicle Status</button>
                                    <button class="nav-link" id="v-pills-ewayLr-tab" data-bs-toggle="pill" data-bs-target="#v-pills-ewayLr" type="button" role="tab" aria-controls="v-pills-ewayLr" aria-selected="false" tabindex="-1">Eway + LR </button>
                                    <button class="nav-link" id="v-pills-pod-tab" data-bs-toggle="pill" data-bs-target="#v-pills-pod" type="button" role="tab" aria-controls="v-pills-pod" aria-selected="false" tabindex="-1">POD</button>
                                    <hr>
                                    <button class="nav-link transaction-tab mb-0 ms-0" id="v-pills-driver_payout-tab" data-bs-toggle="pill" data-bs-target="#v-pills-driver_payout" type="button" role="tab" aria-controls="v-pills-driver_payout" aria-selected="false" tabindex="-1">Trip Payout</button>
                                    <button class="nav-link transaction-tab mb-0 ms-0" id="v-pills-transaction-tab" data-bs-toggle="pill" data-bs-target="#v-pills-transaction" type="button" role="tab" aria-controls="v-pills-transaction" aria-selected="false" tabindex="-1">Expenses</button>
                                    <button class="nav-link transaction-tab mb-0 ms-0" id="v-pills-summary-tab" data-bs-toggle="pill" data-bs-target="#v-pills-summary" type="button" role="tab" aria-controls="v-pills-summary" aria-selected="false" tabindex="-1">Billing Summary</button>
                                    <button class="nav-link transaction-tab mb-0 ms-0" id="v-pills-memo-tab" data-bs-toggle="pill" data-bs-target="#v-pills-memo" type="button" role="tab" aria-controls="v-pills-memo-tab" aria-selected="false" tabindex="-1">Memo</button>

                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="tab-content" id="v-pills-tabContent">
                                    <div class="tab-pane fade active show" id="v-pills-tripInit" role="tabpanel" aria-labelledby="v-pills-tripInit-tab">
                                        <div class="row">
                                            <div class="col-12">
                                                <div>
                                                    <div class="row">
                                                        <div class="col-12 col-md-8">
                                                            <h5 class="mb-3">Trip Initiations</h5>
                                                        </div>
                                                        <div class="col-12 col-md-4 text-end">
                                                            <a href="javascript:void(0)" data-bs-target="#editTrip" data-bs-toggle="modal"><i class="uil uil-pen"></i></a>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row right-det-wrap">
                                                        <div class="col-12 col-md-3">
                                                            <p class="label-text mb-0">Trip ID</p>
                                                            <p>#001</p>
                                                        </div>
                                                        <div class="col-12 col-md-3">
                                                            <p class="label-text mb-0">Trip Type</p>
                                                            <p>Outside Booking</p>
                                                        </div>
                                                        <div class="col-12 col-md-3">
                                                            <p class="label-text mb-0">Trip Category</p>
                                                            <p>Line</p>
                                                        </div>
                                                        <div class="col-12 col-md-3">
                                                            <p class="label-text mb-0">Internal Trip ID</p>
                                                            <p>#001001765</p>
                                                        </div>
                                                        <div class="col-12 col-md-3">
                                                            <p class="label-text mb-0">Trip Date</p>
                                                            <p>25/10/2025</p>
                                                        </div>
                                                        <div class="col-12 col-md-3">
                                                            <p class="label-text mb-0">Consigner</p>
                                                            <p>Britania Kolkata</p>
                                                        </div>
                                                        <div class="col-12 col-md-3">
                                                            <p class="label-text mb-0">Consignee</p>
                                                            <p>Samsung Hydrabad</p>
                                                        </div>
                                                        
                                                        <div class="col-12 col-md-3">
                                                            <p class="label-text mb-0">Load Vendor</p>
                                                            <p>Blue Dart</p>
                                                        </div>
                                                        <div class="col-12 col-md-3">
                                                            <p class="label-text mb-0">RAG Status</p>
                                                            <p><span class="badge bg-danger">Red</span></p>
                                                        </div>
                                                        <div class="col-12 col-md-3">
                                                            <p class="label-text mb-0">Customer</p>
                                                            <p>Nestle</p>
                                                        </div>
                                                        <div class="col-12 col-md-3">
                                                            <p class="label-text mb-0">Vehicle Type</p>
                                                            <p>Large Truck</p>
                                                        </div>
                                                        <div class="col-12 col-md-3">
                                                            <p class="label-text mb-0">Vehicle Size</p>
                                                            <p>14 FT - XXM 14M * 9M * 12M</p>
                                                        </div>
                                                        <div class="col-12 col-md-3">
                                                            <p class="label-text mb-0">Route</p>
                                                            <p>Kolkata - Mumbai</p>
                                                        </div>
                                                        <div class="col-12 col-md-3">
                                                            <p class="label-text mb-0">Source</p>
                                                            <p>Kolkata</p>
                                                        </div>
                                                        <div class="col-12 col-md-3">
                                                            <p class="label-text mb-0">Stop 1</p>
                                                            <p>Kolaghat</p>
                                                        </div>
                                                        <div class="col-12 col-md-3">
                                                            <p class="label-text mb-0">Stop 2</p>
                                                            <p>Patna</p>
                                                        </div>
                                                        <div class="col-12 col-md-3">
                                                            <p class="label-text mb-0">Destination</p>
                                                            <p>Mumbai</p>
                                                        </div>
                                                        <div class="col-12 col-md-3">
                                                            <p class="label-text mb-0">Distance</p>
                                                            <p>150KM</p>
                                                        </div>
                                                        
                                                        <div class="col-12 col-md-3">
                                                            <p class="label-text mb-0">Priority</p>
                                                            <p>High</p>
                                                        </div>
                                                        <div class="col-12 col-md-3">
                                                            <p class="label-text mb-0">Tarpaulin</p>
                                                            <p>Yes</p>
                                                        </div>

                                                        <div class="col-12">
                                                            <p class="label-text mb-0">Comment</p>
                                                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                                                            Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
                                                            when an unknown printer took a galley of type and scrambled it to make a type
                                                            specimen book.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="tab-pane fade" id="v-pills-vehAllocation" role="tabpanel" aria-labelledby="v-pills-vehAllocation-tab">
                                        <div class="row align-items-center">
                                            <div class="col-12">
                                                <h5 class="d-inline-block mb-3">Vehicles Allocations</h5>
                                                <div class="accordion" id="accordionVehicle">
                                                    <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingOne">
                                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                        <span class="sec-title">Select from Suggested Vehicles
                                                            <span class="badge rounded-pill bg-danger ms-2">
                                                                3
                                                            </span>
                                                        </span>
                                                        </button>
                                                    </h2>
                                                    
                                                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionVehicle">
                                                        <div class="accordion-body p-2">
                                                            <div class="vehiclestable vehicle-allocation">
                                                            <form>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="checkVehAlo" id="check1">
                                                                    <label class="form-check-label" for="check1">
                                                                    <div class="vehicle-card color-left01 d-block">
                                                                        <div class="row info-grid">
                                                                            <div class="col-12 col-md-4 info-item mb-3">
                                                                            <div class="label">Vehicle Number</div>
                                                                            <div class="value">WB-12-AB-1237</div>
                                                                            </div> 
                                                                            
                                                                            <div class="col-12 col-md-4 info-item mb-3">
                                                                            <div class="label">Vehicle Type</div>
                                                                            <div class="value">Large Container</div>
                                                                            </div> 
                                                                            
                                                                            <div class="col-12 col-md-4 info-item mb-3">
                                                                            <div class="label">Vehicle Size</div>
                                                                            <div class="value">14 FT - XXM 14M * 9M * 12M</div>
                                                                            </div> 
                                                                            
                                                                            <div class="col-12 col-md-4 info-item mb-3">
                                                                            <div class="label">Current Status</div>
                                                                            <div class="value">In Trip</div>
                                                                            </div> 
                                                                            
                                                                            <div class="col-12 col-md-4 info-item mb-3">
                                                                            <div class="label">Live Location</div>
                                                                            <div class="value">Kolkata</div>
                                                                            </div> 
                                                                            
                                                                            <div class="col-12 col-md-4 info-item mb-3">
                                                                            <div class="label">Empty Since</div>
                                                                            <div class="value">12/09/2025</div>
                                                                            </div>
                                                                            
                                                                            <div class="col-12 col-md-4 info-item mb-3">
                                                                            <div class="label">Driver Name & Number</div>
                                                                            <div class="value" >Ashok Ray <br/>+91 8879402641</div>
                                                                            </div>
                                                                            
                                                                            <div class="col-12 col-md-4 info-item mb-3">
                                                                                <div class="label">RAG Status</div>
                                                                            <div class="value"><span class="badge bg-danger">Red</span></div>
                                                                            </div> 
                                                                            <div class="col-12 col-md-4 info-item mb-3">
                                                                                <div class="label">Associated Since</div>
                                                                            <div class="value">10 Years 5 Months 10 Days</div>
                                                                            </div> 
                                                                        </div>
                                                                    </div>
                                                                    </label>
                                                                </div>
                                                                
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="checkVehAlo" id="check2">
                                                                    <label class="form-check-label" for="check2">
                                                                    <div class="vehicle-card color-left02 d-block">
                                                                        <div class="row info-grid">
                                                                            <div class="col-12 col-md-4 info-item mb-3">
                                                                            <div class="label">Vehicle Number</div>
                                                                            <div class="value">WB-12-AB-1237</div>
                                                                            </div> 
                                                                            
                                                                            <div class="col-12 col-md-4 info-item mb-3">
                                                                            <div class="label">Vehicle Type</div>
                                                                            <div class="value">Large Container</div>
                                                                            </div> 
                                                                            
                                                                            <div class="col-12 col-md-4 info-item mb-3">
                                                                            <div class="label">Vehicle Size</div>
                                                                            <div class="value">14 FT - XXM 14M * 9M * 12M</div>
                                                                            </div> 
                                                                            
                                                                            <div class="col-12 col-md-4 info-item mb-3">
                                                                            <div class="label">Current Status</div>
                                                                            <div class="value">Maintenance</div>
                                                                            </div>
                                                                            
                                                                            <div class="col-12 col-md-4 info-item mb-3">
                                                                            <div class="label">Live Location</div>
                                                                            <div class="value">Kolkata</div>
                                                                            </div>
                                                                            
                                                                            <div class="col-12 col-md-4 info-item mb-3">
                                                                            <div class="label">Empty Since</div>
                                                                            <div class="value">12/09/2025</div>
                                                                            </div>
                                                                            
                                                                            <div class="col-12 col-md-4 info-item mb-3">
                                                                            <div class="label">Driver Name & Number</div>
                                                                            <div class="value" >Ashok Ray <br/>+91 8879402641</div>
                                                                            </div>
                                                                            
                                                                            <div class="col-12 col-md-4 info-item mb-3">
                                                                                <div class="label">RAG Status</div>
                                                                            <div class="value"><span class="badge bg-danger">Red</span></div>
                                                                            </div> 
                                                                            <div class="col-12 col-md-4 info-item mb-3">
                                                                                <div class="label">Associated Since</div>
                                                                            <div class="value">10 Years 5 Months 10 Days</div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    </label>
                                                                </div>
                                                                
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="checkVehAlo" id="check3">
                                                                    <label class="form-check-label" for="check3">
                                                                    <div class="vehicle-card color-left03 d-block">
                                                                        <div class="row info-grid">
                                                                            <div class="col-12 col-md-4 info-item mb-3">
                                                                            <div class="label">Vehicle Number</div>
                                                                            <div class="value">WB-12-AB-1237</div>
                                                                            </div> 
                                                                            
                                                                            <div class="col-12 col-md-4 info-item mb-3">
                                                                            <div class="label">Vehicle Type</div>
                                                                            <div class="value">Large Container</div>
                                                                            </div> 
                                                                            
                                                                            <div class="col-12 col-md-4 info-item mb-3">
                                                                            <div class="label">Vehicle Size</div>
                                                                            <div class="value">14 FT - XXM 14M * 9M * 12M</div>
                                                                            </div> 
                                                                            
                                                                            <div class="col-12 col-md-4 info-item mb-3">
                                                                            <div class="label">Current Status</div>
                                                                            <div class="value">Empty</div>
                                                                            </div>
                                                                            
                                                                            <div class="col-12 col-md-4 info-item mb-3">
                                                                            <div class="label">Live Location</div>
                                                                            <div class="value">Kolkata</div>
                                                                            </div> 
                                                                            
                                                                            <div class="col-12 col-md-4 info-item mb-3">
                                                                            <div class="label">Empty Since</div>
                                                                            <div class="value">12/09/2025</div>
                                                                            </div>
                                                                            
                                                                            <div class="col-12 col-md-4 info-item mb-3">
                                                                            <div class="label">Driver Name & Number</div>
                                                                            <div class="value" >Ashok Ray <br/>+91 8879402641</div>
                                                                            </div>
                                                                            
                                                                            <div class="col-12 col-md-4 info-item mb-3">
                                                                                <div class="label">RAG Status</div>
                                                                            <div class="value"><span class="badge bg-danger">Red</span></div>
                                                                            </div> 
                                                                            <div class="col-12 col-md-4 info-item mb-3">
                                                                                <div class="label">Associated Since</div>
                                                                            <div class="value">10 Years 5 Months 10 Days</div>
                                                                            </div> 
                                                                        </div>    
                                                                    </div>
                                                                    </label>
                                                                </div>
                                                        
                                                                <!--<div class="vehicle-card color-left01 d-block">-->
                                                                <!--    <div class="row info-grid">-->
                                                                <!--      <div class="col-12 col-md-4 info-item mb-3">-->
                                                                <!--        <div class="label">Vehicle Number</div>-->
                                                                <!--        <div class="value">WB-12-AB-1237</div>-->
                                                                <!--      </div> -->
                                                                        
                                                                <!--      <div class="col-12 col-md-4 info-item mb-3">-->
                                                                <!--        <div class="label">Current Status</div>-->
                                                                <!--        <div class="value">In Trip</div>-->
                                                                <!--      </div> -->
                                                                        
                                                                <!--      <div class="col-12 col-md-4 info-item mb-3">-->
                                                                <!--        <div class="label">Live Location</div>-->
                                                                <!--        <div class="value">Kolkata</div>-->
                                                                <!--      </div> -->
                                                                        
                                                                <!--      <div class="col-12 col-md-4 info-item mb-3">-->
                                                                <!--        <div class="label">Empty Since</div>-->
                                                                <!--        <div class="value">12/09/2025</div>-->
                                                                <!--      </div>-->
                                                                        
                                                                <!--      <div class="col-12 col-md-4 info-item mb-3">-->
                                                                <!--        <div class="label">Driver Name</div>-->
                                                                <!--        <div class="value">Ashok Ray</div>-->
                                                                <!--      </div>-->
                                                                        
                                                                <!--       <div class="col-12 col-md-4 info-item mb-3">-->
                                                                <!--          <div class="label">Driver Number</div>-->
                                                                <!--        <div class="value">+91 8879402641</div>-->
                                                                <!--      </div> -->
                                                                <!--    </div>-->
                                                                <!--</div>-->
                                                                
                                                                <!--<div class="vehicle-card color-left02 d-block">-->
                                                                <!--    <div class="row info-grid">-->
                                                                <!--      <div class="col-12 col-md-4 info-item mb-3">-->
                                                                <!--        <div class="label">Vehicle Number</div>-->
                                                                <!--        <div class="value">WB-12-AB-1237</div>-->
                                                                <!--      </div> -->
                                                                        
                                                                <!--      <div class="col-12 col-md-4 info-item mb-3">-->
                                                                <!--        <div class="label">Current Status</div>-->
                                                                <!--        <div class="value">Maintenance</div>-->
                                                                <!--      </div>-->
                                                                        
                                                                <!--      <div class="col-12 col-md-4 info-item mb-3">-->
                                                                <!--        <div class="label">Live Location</div>-->
                                                                <!--        <div class="value">Kolkata</div>-->
                                                                <!--      </div>-->
                                                                        
                                                                <!--      <div class="col-12 col-md-4 info-item mb-3">-->
                                                                <!--        <div class="label">Empty Since</div>-->
                                                                <!--        <div class="value">12/09/2025</div>-->
                                                                <!--      </div>-->
                                                                        
                                                                <!--      <div class="col-12 col-md-4 info-item mb-3">-->
                                                                <!--        <div class="label">Driver Name</div>-->
                                                                <!--        <div class="value">--</div>-->
                                                                <!--      </div>-->
                                                                        
                                                                <!--       <div class="col-12 col-md-4 info-item mb-3">-->
                                                                <!--          <div class="label">Driver Number</div>-->
                                                                <!--        <div class="value">--</div>-->
                                                                <!--      </div> -->
                                                                <!--    </div>-->
                                                                <!--</div>-->
                                                                    
                                                                <!--<div class="vehicle-card color-left03 d-block">-->
                                                                <!--    <div class="row info-grid">-->
                                                                <!--      <div class="col-12 col-md-4 info-item mb-3">-->
                                                                <!--        <div class="label">Vehicle Number</div>-->
                                                                <!--        <div class="value">WB-12-AB-1237</div>-->
                                                                <!--      </div> -->
                                                                        
                                                                <!--      <div class="col-12 col-md-4 info-item mb-3">-->
                                                                <!--        <div class="label">Current Status</div>-->
                                                                <!--        <div class="value">Empty</div>-->
                                                                <!--      </div>-->
                                                                        
                                                                <!--      <div class="col-12 col-md-4 info-item mb-3">-->
                                                                <!--        <div class="label">Live Location</div>-->
                                                                <!--        <div class="value">Kolkata</div>-->
                                                                <!--      </div> -->
                                                                        
                                                                <!--      <div class="col-12 col-md-4 info-item mb-3">-->
                                                                <!--        <div class="label">Empty Since</div>-->
                                                                <!--        <div class="value">12/09/2025</div>-->
                                                                <!--      </div>-->
                                                                        
                                                                <!--      <div class="col-12 col-md-4 info-item mb-3">-->
                                                                <!--        <div class="label">Driver Name</div>-->
                                                                <!--        <div class="value">--</div>-->
                                                                <!--      </div>-->
                                                                        
                                                                <!--       <div class="col-12 col-md-4 info-item mb-3">-->
                                                                <!--          <div class="label">Driver Number</div>-->
                                                                <!--        <div class="value">--</div>-->
                                                                <!--      </div> -->
                                                                <!--    </div>    -->
                                                                <!--</div>-->
                                                            </form>
                                                        </div>
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="separator">
                                                    <hr>
                                                    <span>OR</span>
                                                </div>
                                                
                                                <form class="allocation-form">
                                                    <div class="mt-5">
                                                        <div class="row form-group">
                                                            <div class="col-12">
                                                                <h6 class="text-center">Select any of these below</h6>
                                                                <div class="text-center veh-type-wrap mt-3">
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input own-veh" type="radio" name="newVehicle" id="ownVeh" value="Own Vehicle">
                                                                        <label class="form-check-label" for="ownVeh">Own Vehicle</label>
                                                                    </div>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input external-veh" type="radio" name="newVehicle" id="external" value="External">
                                                                        <label class="form-check-label" for="external">External / Vendor</label>
                                                                    </div>
                                                                </div>
                                                                <!--/////////////////////////////////////////////////////////////////////////////////////////////-->
                                                                
                                                                <div class="if-own mt-2">
                                                                    <div class="card-body">
                                                                        <!--<div class="row form-group">-->
                                                                        <!--   <div class="col-12 col-md-6">-->
                                                                        <!--        <label>Expected Start Date</label>-->
                                                                        <!--        <input class="form-control" type="date" />-->
                                                                        <!--    </div>-->
                                                                            
                                                                        <!--    <div class="col-12 col-md-6">-->
                                                                        <!--        <label>Expected Start Time</label>-->
                                                                        <!--        <input class="form-control" type="time" />-->
                                                                        <!--    </div>-->
                                                                        <!--</div>-->
                                                                        <!--<div class="row form-group">-->
                                                                            
                                                                        <!--    <div class="col-12 col-md-6">-->
                                                                        <!--        <label>Loading Point</label>-->
                                                                        <!--        <select class="form-select select2">-->
                                                                        <!--            <option>Choose..</option>-->
                                                                        <!--            <option>Webel Gate</option>-->
                                                                        <!--            <option>SDF</option>-->
                                                                        <!--            <option>DLF 1</option>-->
                                                                        <!--            <option>DLF 2</option>-->
                                                                        <!--            <option>Laketown</option>-->
                                                                        <!--        </select>-->
                                                                        <!--    </div>-->
                                                                            
                                                                        <!--    <div class="col-12 col-md-6">-->
                                                                        <!--        <label>Unloading Point</label>-->
                                                                        <!--        <select class="form-select select2">-->
                                                                        <!--            <option>Choose..</option>-->
                                                                        <!--            <option>Webel Gate</option>-->
                                                                        <!--            <option>SDF</option>-->
                                                                        <!--            <option>DLF 1</option>-->
                                                                        <!--            <option>DLF 2</option>-->
                                                                        <!--            <option>Laketown</option>-->
                                                                        <!--        </select>-->
                                                                        <!--    </div>-->
                                                                            
                                                                        <!--</div>-->
                                                                        <div class="form-group">
                                                                            <label>Select Vehicle from Below List</label>
                                                                            <select class="form-select select2">
                                                                                <option>Choose..</option>
                                                                                <option>WB-12-AB-1237</option>
                                                                                <optin>WB-13-XZ-1450</optin>
                                                                                <option>WB-12-LC-0090</option>
                                                                                <optin>WB-13-PL-6789</optin>
                                                                                <option>WB-12-AB-1237</option>
                                                                                <optin>WB-13-XZ-1450</optin>
                                                                                <option>WB-12-LC-0090</option>
                                                                                <optin>WB-13-PL-6789</optin>
                                                                                <option>WB-12-AB-1237</option>
                                                                                <optin>WB-13-XZ-1450</optin>
                                                                                <option>WB-12-LC-0090</option>
                                                                                <optin>WB-13-PL-6789</optin>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <div class="card-body mt-3" style="border-left: 3px solid #032671;">
                                                                        <div class="view-booking-det d-block">
                                                                            <div class="row info-grid">
                                                                                <div class="col-12 col-md-4 info-item mb-3">
                                                                                <div class="label">Driver Name &amp; Number</div>
                                                                                <div class="value">Ashok Ray <br>+91 8879402641</div>
                                                                                </div>
                                                                                
                                                                                <div class="col-12 col-md-4 info-item mb-3">
                                                                                    <div class="label">Driver Experience</div>
                                                                                <div class="value">5 Years 10 Months</div>
                                                                                </div> 
                                                                                
                                                                                <div class="col-12 col-md-4 info-item mb-3">
                                                                                    <div class="label">RAG Status</div>
                                                                                <div class="value"><span class="badge bg-danger">Red</span></div>
                                                                                </div> 
                                                                                
                                                                                <div class="col-12 col-md-4 info-item mb-3">
                                                                                    <div class="label">Vehicle Status</div>
                                                                                <div class="value">Empty</div>
                                                                                </div>
                                                                                
                                                                                <div class="col-12 col-md-4 info-item mb-3">
                                                                                    <div class="label">Availability</div>
                                                                                <div class="value">Available</div>
                                                                                </div>
                                                                                
                                                                                <div class="col-12 col-md-4 info-item mb-3">
                                                                                    <div class="label">Live Location</div>
                                                                                <div class="value">Kolkata</div>
                                                                                </div>
                                                                                
                                                                                <div class="col-12 col-md-4 info-item mb-3">
                                                                                    <div class="label">Vehicle Rank</div>
                                                                                <div class="value">Empty</div>
                                                                                </div>
                                                                                
                                                                                <div class="col-12 col-md-4 info-item mb-3">
                                                                                    <div class="label">Line Trip</div>
                                                                                <div class="value">5</div>
                                                                                </div>
                                                                                
                                                                                <div class="col-12 col-md-4 info-item mb-3">
                                                                                    <div class="label">Local Trip</div>
                                                                                <div class="value">7</div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <div class="vahan-det-wrap mt-3">
                                                                        <a class="d-block mb-2 mt-2" data-bs-toggle="collapse" href="#vahanDetails" role="button" aria-expanded="false" aria-controls="vahanDetails">
                                                                            Vahan Details <i class="uil uil-angle-down"></i>
                                                                        </a>
                                                                        <div class="collapse mb-4" id="vahanDetails">
                                                                            <div class="card card-body">
                                                                            <div class="row">
                                                                                <div class="col-12">
                                                                                    <div class="table-responsive">
                                                                                    <table class="table table-hover veh-det-table invoice-table mb-0">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Owner Name</th>
                                                                                                <td class="pt-1 pb-1 ps-2 pe-2">Mohammad Hafiz</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Address</th>
                                                                                                <td class="pt-1 pb-1 ps-2 pe-2">H.NO.62, Vill Hathipur Chittu, PS Kundarki, Teh. Bilari, Moradabad — Ph: 9588416786, 999999</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Status</th>
                                                                                                <td class="pt-1 pb-1 ps-2 pe-2">Active</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Registration Date</th>
                                                                                                <td class="pt-1 pb-1 ps-2 pe-2">19/03/2015</td>
                                                                                            </tr>
                                                                                            
                                                                                            <tr>
                                                                                                <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Fitness Certificate Expiry</th>
                                                                                                <td class="pt-1 pb-1 ps-2 pe-2">10/04/2026</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Insurance Expiry</th>
                                                                                                <td class="pt-1 pb-1 ps-2 pe-2">H.NO.62, Vill Hathipur Chittu, PS Kundarki, Teh. Bilari, Moradabad — Ph: 9588416786, 999999</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-info-circle text-danger me-4" aria-hidden="true"></i>Tax Expiry</th>
                                                                                                <td class="pt-1 pb-1 ps-2 pe-2">28/02/2026</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Permit Expiry</th>
                                                                                                <td class="pt-1 pb-1 ps-2 pe-2">19/03/2015</td>
                                                                                            </tr>
                                                                                            
                                                                                            <tr>
                                                                                                <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>PUCC Expiry</th>
                                                                                                <td class="pt-1 pb-1 ps-2 pe-2">19/03/2015</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>National Permit Expiry</th>
                                                                                                <td class="pt-1 pb-1 ps-2 pe-2">19/03/2015</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Permit Type</th>
                                                                                                <td class="pt-1 pb-1 ps-2 pe-2">National Permit (Heavy Goods Vehicle)</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>PUCC Number</th>
                                                                                                <td class="pt-1 pb-1 ps-2 pe-2">UP02101060016371</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Permit Number</th>
                                                                                                <td class="pt-1 pb-1 ps-2 pe-2">UP/21/112/GOOD/2017/26595</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Insurer</th>
                                                                                                <td class="pt-1 pb-1 ps-2 pe-2">The New India Assurance Company Ltd.</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Insurance Number</th>
                                                                                                <td class="pt-1 pb-1 ps-2 pe-2">34040131240100004570</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Financier</th>
                                                                                                <td class="pt-1 pb-1 ps-2 pe-2">Kogta Financial (I) Ltd.</td>
                                                                                            </tr>

                                                                                            <tr>
                                                                                                <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Class</th>
                                                                                                <td class="pt-1 pb-1 ps-2 pe-2">Goods Carrier (HGV)</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Body Type</th>
                                                                                                <td class="pt-1 pb-1 ps-2 pe-2">Truck (Closed Body)</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Fuel Type</th>
                                                                                                <td class="pt-1 pb-1 ps-2 pe-2">Diesel</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Chassis Number Date</th>
                                                                                                <td class="pt-1 pb-1 ps-2 pe-2">MAT388062E5P14305</td>
                                                                                            </tr>
                                                                                            
                                                                                            <tr>
                                                                                                <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Engine Number</th>
                                                                                                <td class="pt-1 pb-1 ps-2 pe-2">41L84194947</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Manufacturer</th>
                                                                                                <td class="pt-1 pb-1 ps-2 pe-2">Tata Motors Ltd.</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Model</th>
                                                                                                <td class="pt-1 pb-1 ps-2 pe-2">LPT1613/62TCBSII</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Norms Type</th>
                                                                                                <td class="pt-1 pb-1 ps-2 pe-2">EURO 2</td>
                                                                                            </tr>
                                                                                            
                                                                                            <tr>
                                                                                                <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Gross Vehicle Weight</th>
                                                                                                <td class="pt-1 pb-1 ps-2 pe-2">18500</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Unladen Weight</th>
                                                                                                <td class="pt-1 pb-1 ps-2 pe-2">8850</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Vehicle Category</th>
                                                                                                <td class="pt-1 pb-1 ps-2 pe-2">HGV</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Wheelbase</th>
                                                                                                <td class="pt-1 pb-1 ps-2 pe-2">6200</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Commercial FASTag</th>
                                                                                                <td class="pt-1 pb-1 ps-2 pe-2">Yes</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>FASTag ID</th>
                                                                                                <td class="pt-1 pb-1 ps-2 pe-2">34161FA820328EE831791140</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>TID</th>
                                                                                                <td class="pt-1 pb-1 ps-2 pe-2">E200341201360400001A47AA8</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>FASTag Issue Date</th>
                                                                                                <td class="pt-1 pb-1 ps-2 pe-2">2024-04-02</td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                    </div>
                                                                                </div>
                                                                                
                                                                                <div class="col-12">
                                                                                    <div class="table-responsive">
                                                                                    <table class="table table-hover invoice-table mb-0">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Class</th>
                                                                                                <td class="pt-1 pb-1 ps-2 pe-2">Goods Carrier (HGV)</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Body Type</th>
                                                                                                <td class="pt-1 pb-1 ps-2 pe-2">Truck (Closed Body)</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Fuel Type</th>
                                                                                                <td class="pt-1 pb-1 ps-2 pe-2">Diesel</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Chassis Number Date</th>
                                                                                                <td class="pt-1 pb-1 ps-2 pe-2">MAT388062E5P14305</td>
                                                                                            </tr>
                                                                                            
                                                                                            <tr>
                                                                                                <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Engine Number</th>
                                                                                                <td class="pt-1 pb-1 ps-2 pe-2">41L84194947</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Manufacturer</th>
                                                                                                <td class="pt-1 pb-1 ps-2 pe-2">Tata Motors Ltd.</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Model</th>
                                                                                                <td class="pt-1 pb-1 ps-2 pe-2">LPT1613/62TCBSII</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Norms Type</th>
                                                                                                <td class="pt-1 pb-1 ps-2 pe-2">EURO 2</td>
                                                                                            </tr>
                                                                                            
                                                                                            <tr>
                                                                                                <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Gross Vehicle Weight</th>
                                                                                                <td class="pt-1 pb-1 ps-2 pe-2">18500</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Unladen Weight</th>
                                                                                                <td class="pt-1 pb-1 ps-2 pe-2">8850</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Vehicle Category</th>
                                                                                                <td class="pt-1 pb-1 ps-2 pe-2">HGV</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Wheelbase</th>
                                                                                                <td class="pt-1 pb-1 ps-2 pe-2">6200</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Commercial FASTag</th>
                                                                                                <td class="pt-1 pb-1 ps-2 pe-2">Yes</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>FASTag ID</th>
                                                                                                <td class="pt-1 pb-1 ps-2 pe-2">34161FA820328EE831791140</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>TID</th>
                                                                                                <td class="pt-1 pb-1 ps-2 pe-2">E200341201360400001A47AA8</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>FASTag Issue Date</th>
                                                                                                <td class="pt-1 pb-1 ps-2 pe-2">2024-04-02</td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            
                                                                            <div class="text-end">
                                                                                <a class="d-block mb-2 mt-2" data-bs-toggle="collapse" href="#vahanDetails" role="button" aria-expanded="false" aria-controls="vahanDetails">
                                                                                    Show Less <i class="uil uil-angle-up"></i>
                                                                                </a>
                                                                            </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                
                                                                <!--/////////////////////////////////////////////////////////////////////////////////////////////-->
                                                                    
                                                                <div class="if-external mt-2">
                                                                    <div class="card-body">
                                                                        <div class="form-group">
                                                                            <div class="row">
                                                                                <div class="col-12 col-md-6">
                                                                                    <label>Vendor Name</label>
                                                                                </div>
                                                                                <div class="col-12 col-md-6 text-end">
                                                                                    <a href="add-vehicle-vendor.php" style="font-size: 13px;" class="text-success"><i class="uil uil-plus-circle me-1"></i>Add Vendor</a>
                                                                                </div>
                                                                            </div>
                                                                            
                                                                            <select class="form-select select2">
                                                                                <option>Choose</option>
                                                                                <option>ABC Logistics | +91 9876543210</option>
                                                                                <option>XYZ Logistics | +91 9876543210</option>
                                                                                <option>MNC Logistics | +91 9876543210</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <div class="row">
                                                                                <div class="col-12 col-md-8">
                                                                                    <label>Select Vehicle from Below List</label>
                                                                                </div>
                                                                                <div class="col-12 col-md-4 text-end">
                                                                                    <a href="javascript:void(0)" data-bs-target="#addVeh" data-bs-toggle="modal" style="font-size: 13px;" class="text-success"><i class="uil uil-plus-circle me-1"></i>Add Vehicle</a>
                                                                                </div>
                                                                            </div>
                                                                            
                                                                            <select class="form-select select2">
                                                                                <option>Choose..</option>
                                                                                <option>WB-12-AB-1237</option>
                                                                                <option>WB-13-XZ-1450</option>
                                                                                <option>WB-12-LC-0090</option>
                                                                                <option>WB-13-PL-6789</option>
                                                                                <option>WB-12-AB-1237</option>
                                                                                <option>WB-13-XZ-1450</option>
                                                                                <option>WB-12-LC-0090</option>
                                                                                <option>WB-13-PL-6789</option>
                                                                                <option>WB-12-AB-1237</option>
                                                                                <option>WB-13-XZ-1450</option>
                                                                                <option>WB-12-LC-0090</option>
                                                                                <option>WB-13-PL-6789</option>
                                                                            </select>
                                                                            
                                                                        </div>
                                                                        
                                                                        <div class="vahan-det-wrap">
                                                                            <a class="d-block mb-2 mt-2" data-bs-toggle="collapse" href="#vahanDetails" role="button" aria-expanded="false" aria-controls="vahanDetails">
                                                                                Vahan Details <i class="uil uil-angle-down"></i>
                                                                            </a>
                                                                            <div class="collapse mb-4" id="vahanDetails">
                                                                                <div class="card card-body">
                                                                                <div class="row">
                                                                                    <div class="col-12">
                                                                                        <div class="table-responsive">
                                                                                        <table class="table table-hover veh-det-table invoice-table mb-0">
                                                                                            <tbody>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Owner Name</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">Mohammad Hafiz</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Address</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">H.NO.62, Vill Hathipur Chittu, PS Kundarki, Teh. Bilari, Moradabad — Ph: 9588416786, 999999</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Status</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">Active</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Registration Date</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">19/03/2015</td>
                                                                                                </tr>
                                                                                                
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Fitness Certificate Expiry</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">10/04/2026</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Insurance Expiry</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">H.NO.62, Vill Hathipur Chittu, PS Kundarki, Teh. Bilari, Moradabad — Ph: 9588416786, 999999</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-info-circle text-danger me-4" aria-hidden="true"></i>Tax Expiry</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">28/02/2026</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Permit Expiry</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">19/03/2015</td>
                                                                                                </tr>
                                                                                                
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>PUCC Expiry</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">19/03/2015</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>National Permit Expiry</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">19/03/2015</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Permit Type</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">National Permit (Heavy Goods Vehicle)</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>PUCC Number</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">UP02101060016371</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Permit Number</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">UP/21/112/GOOD/2017/26595</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Insurer</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">The New India Assurance Company Ltd.</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Insurance Number</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">34040131240100004570</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Financier</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">Kogta Financial (I) Ltd.</td>
                                                                                                </tr>

                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Class</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">Goods Carrier (HGV)</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Body Type</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">Truck (Closed Body)</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Fuel Type</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">Diesel</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Chassis Number Date</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">MAT388062E5P14305</td>
                                                                                                </tr>
                                                                                                
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Engine Number</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">41L84194947</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Manufacturer</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">Tata Motors Ltd.</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Model</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">LPT1613/62TCBSII</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Norms Type</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">EURO 2</td>
                                                                                                </tr>
                                                                                                
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Gross Vehicle Weight</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">18500</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Unladen Weight</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">8850</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Vehicle Category</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">HGV</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Wheelbase</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">6200</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Commercial FASTag</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">Yes</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>FASTag ID</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">34161FA820328EE831791140</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>TID</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">E200341201360400001A47AA8</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>FASTag Issue Date</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">2024-04-02</td>
                                                                                                </tr>
                                                                                            </tbody>
                                                                                        </table>
                                                                                        </div>
                                                                                    </div>
                                                                                    
                                                                                    <div class="col-12">
                                                                                        <div class="table-responsive">
                                                                                        <table class="table table-hover invoice-table mb-0">
                                                                                            <tbody>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Class</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">Goods Carrier (HGV)</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Body Type</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">Truck (Closed Body)</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Fuel Type</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">Diesel</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Chassis Number Date</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">MAT388062E5P14305</td>
                                                                                                </tr>
                                                                                                
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Engine Number</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">41L84194947</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Manufacturer</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">Tata Motors Ltd.</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Model</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">LPT1613/62TCBSII</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Norms Type</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">EURO 2</td>
                                                                                                </tr>
                                                                                                
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Gross Vehicle Weight</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">18500</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Unladen Weight</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">8850</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Vehicle Category</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">HGV</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Wheelbase</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">6200</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Commercial FASTag</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">Yes</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>FASTag ID</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">34161FA820328EE831791140</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>TID</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">E200341201360400001A47AA8</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>FASTag Issue Date</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">2024-04-02</td>
                                                                                                </tr>
                                                                                            </tbody>
                                                                                        </table>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        <div class="row form-group">
                                                                            <div class="col-12 col-md-6">
                                                                                <label>Expected Start Date</label>
                                                                                <input class="form-control" type="date" />
                                                                            </div>
                                                                            <div class="col-12 col-md-6">
                                                                                <label>Expected Start Time</label>
                                                                                <input class="form-control" type="time" />
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        <div class="row form-group">
                                                                            <div class="col-12 col-md-6">
                                                                                <label>Loading Point</label>
                                                                                <select class="form-select select2">
                                                                                    <option>Choose..</option>
                                                                                    <option>Webel Gate</option>
                                                                                    <option>SDF</option>
                                                                                    <option>DLF 1</option>
                                                                                    <option>DLF 2</option>
                                                                                    <option>Laketown</option>
                                                                                </select>
                                                                            </div>
                                                                            <div class="col-12 col-md-6">
                                                                                <label>Unloading Point</label>
                                                                                <select class="form-select select2">
                                                                                    <option>Choose..</option>
                                                                                    <option>Webel Gate</option>
                                                                                    <option>SDF</option>
                                                                                    <option>DLF 1</option>
                                                                                    <option>DLF 2</option>
                                                                                    <option>Laketown</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-12 text-end mt-3">
                                                                <button class="btn btn-primary">Save</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="tab-pane fade" id="v-pills-vehStatus" role="tabpanel" aria-labelledby="v-pills-vehStatus-tab">
                                        <div class="row align-items-center">
                                            <div class="col-12">
                                                <h5 class="d-inline-block mb-3">Vehicles Status</h5>
                                                <div class="row mt-3">
                                                    <div class="col-12 col-md-9">
                                                        Status: <span class="badge badge-success ms-2">Reported at Loading Point</span> <span class="badge badge-success ms-2">Date & Time: 12/01/2026 | 12:00 PM</span>
                                                    </div>
                                                    <div class="col-12 col-md-3 text-end">
                                                        <a href="javascript:void(0)" style="font-size: 14px;" data-bs-toggle="modal" data-bs-target="#changeStatus"><i class="uil uil-pen me-1"></i>Change</a>
                                                    </div>
                                                </div>
                                                
                                                <form class="row mt-3">
                                                    <div class="col-12 col-md-4">
                                                        <label>Haulting</label>
                                                        <div class="input-group mb-3">
                                                            <input type="number" class="form-control" aria-describedby="basic-addon2">
                                                            <span class="input-group-text" id="basic-addon2">Day</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-8">
                                                        <label>Manual Entry</label>
                                                        <input type="text" class="form-control" />
                                                    </div>
                                                    <div class="col-12">
                                                        <iframe src="https://www.google.com/maps/embed?pb=!1m28!1m12!1m3!1d939846.3792652059!2d87.18564370509674!3d23.05038048140725!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m13!3e0!4m5!1s0x39f882db4908f667%3A0x43e330e68f6c2cbc!2sKolkata%2C%20West%20Bengal!3m2!1d22.5743545!2d88.3628734!4m5!1s0x39f7710b47a89171%3A0x429e1bdb57e009dd!2sDurgapur%2C%20West%20Bengal!3m2!1d23.520444299999998!2d87.3119227!5e0!3m2!1sen!2sin!4v1763121789776!5m2!1sen!2sin" width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                                    </div>
                                                </form>
                                            </div>
                                            
                                            <hr>
                                            
                                            <div class="col-12">
                                                <div class="row mt-3">
                                                    <div class="col-12 col-md-9">
                                                        Status: <span class="badge badge-success ms-2">On the Way</span> <span class="badge badge-success ms-2">Date & Time: 12/01/2026 | 12:00 PM</span>
                                                    </div>
                                                </div>
                                                
                                                <form class="row mt-3">
                                                    <div class="col-12 col-md-4">
                                                        <label>Haulting</label>
                                                        <div class="input-group mb-3">
                                                            <input type="number" class="form-control" aria-describedby="basic-addon2">
                                                            <span class="input-group-text" id="basic-addon2">Day</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-8">
                                                        <label>Manual Entry</label>
                                                        <input type="text" class="form-control" />
                                                    </div>
                                                    <div class="col-12">
                                                        <iframe src="https://www.google.com/maps/embed?pb=!1m28!1m12!1m3!1d939846.3792652059!2d87.18564370509674!3d23.05038048140725!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m13!3e0!4m5!1s0x39f882db4908f667%3A0x43e330e68f6c2cbc!2sKolkata%2C%20West%20Bengal!3m2!1d22.5743545!2d88.3628734!4m5!1s0x39f7710b47a89171%3A0x429e1bdb57e009dd!2sDurgapur%2C%20West%20Bengal!3m2!1d23.520444299999998!2d87.3119227!5e0!3m2!1sen!2sin!4v1763121789776!5m2!1sen!2sin" width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                                    </div>
                                                </form>
                                            </div>
                                            
                                            <hr>
                                            
                                            <div class="col-12">
                                                <div class="row mt-3">
                                                    <div class="col-12">
                                                        Status: <span class="badge badge-success ms-2">Reported at Unloading Point</span> <span class="badge badge-success ms-2">Date & Time: 12/01/2026 | 12:00 PM</span>
                                                    </div>
                                                </div>
                                                
                                                <form class="row mt-3">
                                                    <div class="col-12 col-md-4">
                                                        <label>Haulting</label>
                                                        <div class="input-group mb-3">
                                                            <input type="number" class="form-control" aria-describedby="basic-addon2">
                                                            <span class="input-group-text" id="basic-addon2">Day</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-8">
                                                        <label>Manual Entry</label>
                                                        <input type="text" class="form-control" />
                                                    </div>
                                                    <div class="col-12">
                                                        <iframe src="https://www.google.com/maps/embed?pb=!1m28!1m12!1m3!1d939846.3792652059!2d87.18564370509674!3d23.05038048140725!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m13!3e0!4m5!1s0x39f882db4908f667%3A0x43e330e68f6c2cbc!2sKolkata%2C%20West%20Bengal!3m2!1d22.5743545!2d88.3628734!4m5!1s0x39f7710b47a89171%3A0x429e1bdb57e009dd!2sDurgapur%2C%20West%20Bengal!3m2!1d23.520444299999998!2d87.3119227!5e0!3m2!1sen!2sin!4v1763121789776!5m2!1sen!2sin" width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                                    </div>
                                                </form>
                                            </div>
                                            
                                            <hr>
                                            
                                            <div class="col-12">
                                                <div class="row mt-3">
                                                    <div class="col-12 col-md-9">
                                                        Status: <span class="badge badge-success ms-2">Empty</span> <span class="badge badge-success ms-2">Date & Time: 12/01/2026 | 12:00 PM</span>
                                                    </div>
                                                </div>
                                                
                                                <form class="row mt-3">
                                                    <div class="col-12 col-md-4">
                                                        <label>Haulting</label>
                                                        <div class="input-group mb-3">
                                                            <input type="number" class="form-control" aria-describedby="basic-addon2">
                                                            <span class="input-group-text" id="basic-addon2">Day</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-8">
                                                        <label>Manual Entry</label>
                                                        <input type="text" class="form-control" />
                                                    </div>
                                                    <div class="col-12">
                                                        <iframe src="https://www.google.com/maps/embed?pb=!1m28!1m12!1m3!1d939846.3792652059!2d87.18564370509674!3d23.05038048140725!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m13!3e0!4m5!1s0x39f882db4908f667%3A0x43e330e68f6c2cbc!2sKolkata%2C%20West%20Bengal!3m2!1d22.5743545!2d88.3628734!4m5!1s0x39f7710b47a89171%3A0x429e1bdb57e009dd!2sDurgapur%2C%20West%20Bengal!3m2!1d23.520444299999998!2d87.3119227!5e0!3m2!1sen!2sin!4v1763121789776!5m2!1sen!2sin" width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                                    </div>
                                                </form>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    
                                    <div class="tab-pane fade" id="v-pills-ewayLr" role="tabpanel" aria-labelledby="v-pills-ewayLr-tab">
                                        <div class="row">
                                            <div class="col-12">
                                                <h5 class="d-inline-block mb-0">Eway + LR</h5>
                                                
                                                <div class="row mt-3 mb-2">
                                                    <div class="col-12 col-md-6">
                                                        <h6>Eway</h6>
                                                    </div>
                                                    <div class="col-12 col-md-6 text-end">
                                                        <a href="javascript:void(0)" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEwayTable"><i class="uil uil-plus me-1"></i>Add Eway</a>   
                                                    </div>
                                                </div>
                                                
                                                <div class="vehiclestable">
                                                    <div>
                                                        <div class="vehicle-card color-left01 d-block">
                                                            <div class="dropdown dot-dd">
                                                                <span class="dropdown-toggle" id="moreTable" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="uil uil-ellipsis-v"></i>
                                                                </span>
                                                                <ul class="dropdown-menu" aria-labelledby="moreTable" style="">
                                                                <li><a class="dropdown-item" href="{{ route('trip.lr.print') }}" target="_blank"><i class="uil uil-eye me-1"></i>View Details & Print</a></li>
                                                                </ul>
                                                            </div>
                                                            <div class="row info-grid mb-3">
                                                                <div class="col-12 col-md-3 info-item">
                                                                <div class="label">Invoice Number</div>
                                                                <div class="value">#INV001</div>
                                                                </div> 
                                                                
                                                                <div class="col-12 col-md-3 info-item">
                                                                <div class="label">Invoice Date</div>
                                                                <div class="value">02/11/2025</div>
                                                                </div> 
                                                                
                                                                <div class="col-12 col-md-3 info-item">
                                                                <div class="label">LR Number</div>
                                                                <div class="value">#LR001</div>
                                                                </div>
                                                                
                                                                <div class="col-12 col-md-3 info-item">
                                                                    <div class="label">LR Date</div>
                                                                <div class="value">10/11/2025</div>
                                                                </div> 
                                                            </div>
                                                            
                                                            <div class="row info-grid">
                                                                <div class="col-12 col-md-3 info-item">
                                                                    <div class="label">Quantity</div>
                                                                <div class="value">40</div>
                                                                </div>
                                                                
                                                                <div class="col-12 col-md-3 info-item">
                                                                    <div class="label">Value (With Tax)</div>
                                                                <div class="value">1000</div>
                                                                </div> 
                                                                
                                                                <div class="col-12 col-md-3 info-item">
                                                                    <div class="label">Gross Weight</div>
                                                                <div class="value">10KG</div>
                                                                </div>
                                                                
                                                                <div class="col-12 col-md-3 info-item">
                                                                    <div class="label">Charged Weight</div>
                                                                <div class="value">4KG</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="vehicle-card color-left02 d-block">
                                                            <div class="dropdown dot-dd">
                                                                <span class="dropdown-toggle" id="moreTable" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="uil uil-ellipsis-v"></i>
                                                                </span>
                                                                <ul class="dropdown-menu" aria-labelledby="moreTable" style="">
                                                                <li><a class="dropdown-item" href="{{ route('trip.lr.print') }}" target="_blank"><i class="uil uil-eye me-1"></i>View Details & Print</a></li>
                                                                </ul>
                                                            </div>
                                                            <div class="row info-grid mb-3">
                                                                <div class="col-12 col-md-3 info-item">
                                                                <div class="label">Invoice Number</div>
                                                                <div class="value">#INV001</div>
                                                                </div> 
                                                                
                                                                <div class="col-12 col-md-3 info-item">
                                                                <div class="label">Invoice Date</div>
                                                                <div class="value">02/11/2025</div>
                                                                </div> 
                                                                
                                                                <div class="col-12 col-md-3 info-item">
                                                                <div class="label">LR Number</div>
                                                                <div class="value">#LR001</div>
                                                                </div>
                                                                
                                                                <div class="col-12 col-md-3 info-item">
                                                                    <div class="label">LR Date</div>
                                                                <div class="value">10/11/2025</div>
                                                                </div> 
                                                            </div>
                                                            
                                                            <div class="row info-grid">
                                                                <div class="col-12 col-md-3 info-item">
                                                                    <div class="label">Quantity</div>
                                                                <div class="value">40</div>
                                                                </div>
                                                                
                                                                <div class="col-12 col-md-3 info-item">
                                                                    <div class="label">Value (With Tax)</div>
                                                                <div class="value">1000</div>
                                                                </div> 
                                                                
                                                                <div class="col-12 col-md-3 info-item">
                                                                    <div class="label">Gross Weight</div>
                                                                <div class="value">10KG</div>
                                                                </div>
                                                                
                                                                <div class="col-12 col-md-3 info-item">
                                                                    <div class="label">Charged Weight</div>
                                                                <div class="value">4KG</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row mt-3 mb-2">
                                                    <div class="col-12 col-md-6">
                                                        <h6>LR</h6>
                                                    </div>
                                                    <div class="col-12 col-md-6 text-end">
                                                        <a href="{{ route('trip.lr.create') }}" class="btn btn-primary"><i class="uil uil-plus me-1"></i>Add LR</a>   
                                                    </div>
                                                </div>
                                                
                                                <div class="vehiclestable">
                                                    <div>
                                                        <div class="vehicle-card color-left01 d-block">
                                                            <div class="dropdown dot-dd">
                                                                <span class="dropdown-toggle" id="moreTable" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="uil uil-ellipsis-v"></i>
                                                                </span>
                                                                <ul class="dropdown-menu" aria-labelledby="moreTable" style="">
                                                                <li><a class="dropdown-item" href="{{ route('trip.lr.print') }}" target="_blank"><i class="uil uil-eye me-1"></i>View Details & Print</a></li>
                                                                </ul>
                                                            </div>
                                                            <div class="row info-grid mb-3">
                                                                <div class="col-12 col-md-4 info-item">
                                                                <div class="label">LR Number</div>
                                                                <div class="value">#LR001</div>
                                                                </div>
                                                                
                                                                <div class="col-12 col-md-4 info-item">
                                                                <div class="label">LR Party Number</div>
                                                                <div class="value">#LR001</div>
                                                                </div>
                                                                
                                                                <div class="col-12 col-md-4 info-item">
                                                                    <div class="label">LR Date</div>
                                                                <div class="value">10/11/2025</div>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="row info-grid mb-3">
                                                                <div class="col-12 col-md-4 info-item">
                                                                    <div class="label">Gross Weight</div>
                                                                <div class="value">10KG</div>
                                                                </div>
                                                                
                                                                <div class="col-12 col-md-4 info-item">
                                                                    <div class="label">Seal Number</div>
                                                                <div class="value">1234</div>
                                                                </div>
                                                                
                                                                <div class="col-12 col-md-4 info-item">
                                                                <div class="label">Transport Mode</div>
                                                                <div class="value">Road</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="tab-pane fade" id="v-pills-pod" role="tabpanel" aria-labelledby="v-pills-pod-tab">
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <h5 class="d-inline-block mb-3">LR-POD</h5>
                                            </div>
                                            <div class="col-12 col-md-6 text-end">
                                                <a href="javascript:void(0)" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPOD"><i class="uil uil-plus me-1"></i>Add POD</a> 
                                            </div>
                                            
                                            <div class="col-12 mt-3">
                                                <!--<div class="vehiclestable">-->
                                                <!--    <div>-->
                                                <!--        <div class="vehicle-card color-left01">-->
                                                <!--            <div class="info-grid">-->
                                                <!--              <div class="info-item">-->
                                                <!--                <div class="label">Material Description</div>-->
                                                <!--                <div class="value">Hydrabad - Kolkata</div>-->
                                                <!--              </div> -->
                                                                
                                                <!--              <div class="info-item">-->
                                                <!--                <div class="label">Invoice Number & Date</div>-->
                                                <!--                <div class="value">#INV001 | 02/11/2025</div>-->
                                                <!--              </div> -->
                                                                
                                                <!--              <div class="info-item">-->
                                                <!--                <div class="label">LR Number & Date</div>-->
                                                <!--                <div class="value">#LR001 | 20/10/2025</div>-->
                                                <!--              </div>-->
                                                                
                                                <!--               <div class="info-item">-->
                                                <!--                  <div class="label">Net Quantity</div>-->
                                                <!--                <div class="value">40</div>-->
                                                <!--              </div> -->
                                                                
                                                <!--              <div class="info-item">-->
                                                <!--                  <div class="label">Value (with tax)</div>-->
                                                <!--                <div class="value">100</div>-->
                                                <!--              </div>-->
                                                                
                                                <!--              <div class="info-item">-->
                                                <!--                  <div class="label">Gross Weight</div>-->
                                                <!--                <div class="value">10Kg</div>-->
                                                <!--              </div>-->
                                                                
                                                <!--              <div class="info-item">-->
                                                <!--                  <div class="label">Charged Weight</div>-->
                                                <!--                <div class="value">4KG</div>-->
                                                <!--              </div>-->
                                                <!--            </div>-->
                                                <!--        </div>-->
                                                <!--    </div>-->
                                                <!--</div>-->
                                                
                                                <!--<div class="row right-det-wrap">-->
                                                <!--    <div class="col-12 col-md-3">-->
                                                <!--        <p class="label-text mb-0">Material Description</p>-->
                                                <!--        <p>Hydrabad - Kolkata</p>-->
                                                <!--    </div>-->
                                                <!--    <div class="col-12 col-md-3">-->
                                                <!--        <p class="label-text mb-0">Invoice Number & Date</p>-->
                                                <!--        <p>#INV001 | 02/11/2025</p>-->
                                                <!--    </div>-->
                                                <!--    <div class="col-12 col-md-3">-->
                                                <!--        <p class="label-text mb-0">LR Number & Date</p>-->
                                                <!--        <p>#LR001 | 20/10/2025</p>-->
                                                <!--    </div>-->
                                                <!--    <div class="col-12 col-md-3">-->
                                                <!--        <p class="label-text mb-0">Net Quantity</p>-->
                                                <!--        <p>40</p>-->
                                                <!--    </div>-->
                                                <!--    <div class="col-12 col-md-3">-->
                                                <!--        <p class="label-text mb-0">Value (with tax)</p>-->
                                                <!--        <p>1000</p>-->
                                                <!--    </div>-->
                                                <!--    <div class="col-12 col-md-3">-->
                                                <!--        <p class="label-text mb-0">Gross Weight</p>-->
                                                <!--        <p>10KG</p>-->
                                                <!--    </div>-->
                                                <!--    <div class="col-12 col-md-3">-->
                                                <!--        <p class="label-text mb-0">Charged Weight</p>-->
                                                <!--        <p>20KG.</p>-->
                                                <!--    </div>-->
                                                <!--</div>-->
                                                
                                                <div class="row right-det-wrap">
                                                    <div class="col-12 col-md-3">
                                                        <p class="label-text mb-0">Vehicle Number</p>
                                                        <p>MH12AB1234</p>
                                                    </div>
                                                    <div class="col-12 col-md-3">
                                                        <p class="label-text mb-0">LR Number & Date</p>
                                                        <p>LR-4589 | 10/12/2025</p>
                                                    </div>
                                                    <div class="col-12 col-md-3">
                                                        <p class="label-text mb-0">Invoice Number & Date</p>
                                                        <p>INV-1025 | 10/12/2025</p>
                                                    </div>
                                                    <!--<div class="col-12 col-md-3">-->
                                                    <!--    <p class="label-text mb-0">Billing Customer</p>-->
                                                    <!--    <p>Traders Pvt Ltd</p>-->
                                                    <!--</div>-->
                                                    <div class="col-12 col-md-3">
                                                        <p class="label-text mb-0">Source</p>
                                                        <p>Mumbai</p>
                                                    </div>
                                                    <div class="col-12 col-md-3">
                                                        <p class="label-text mb-0">Destination</p>
                                                        <p>Hyderabad</p>
                                                    </div>
                                                    
                                                    <div class="col-12 col-md-3">
                                                        <p class="label-text mb-0">Product Type</p>
                                                        <p>Steel Rods</p>
                                                    </div>
                                                    
                                                    <div class="col-12 col-md-3">
                                                        <p class="label-text mb-0">Quantity</p>
                                                        <p>2000KG</p>
                                                    </div>
                                                    
                                                    <!--<div class="col-12 col-md-3">-->
                                                    <!--    <p class="label-text mb-0">Consignor</p>-->
                                                    <!--    <p>Arun Singh</p>-->
                                                    <!--</div>-->
                                                    
                                                    <!--<div class="col-12 col-md-3">-->
                                                    <!--    <p class="label-text mb-0">Consignee</p>-->
                                                    <!--    <p>Trishul Traders</p>-->
                                                    <!--</div>-->
                                                </div>
                                                
                                                <div class="row form-group">
                                                    <div class="col-12 col-md-6">
                                                        <p class="text-dark mb-1">Consigner Name &amp; Address </p>
                                                        <p class="mb-1 text-dark" style="font-size: 14px;">Britania Kolkata</p>
                                                        <p class="mb-0 text-secondary" style="font-size: 13px;">13946 Desiree Burgs Suite 113</p>
                                                        <p class="mb-0 text-secondary" style="font-size: 13px;">Port Clintonborough</p>
                                                        <p class="mb-0 text-secondary" style="font-size: 13px;">Georgia 974-395</p>
                                                        <p class="mb-0 text-secondary" style="font-size: 13px;">Phone: (006)-336-077</p>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <p class="text-dark mb-1">Consignee Name &amp; Address </p>
                                                        <p class="mb-1 text-dark" style="font-size: 14px;">Samsung Hydrabad</p>
                                                        <p class="mb-0 text-secondary" style="font-size: 13px;">13946 Desiree Burgs Suite 113</p>
                                                        <p class="mb-0 text-secondary" style="font-size: 13px;">Port Clintonborough</p>
                                                        <p class="mb-0 text-secondary" style="font-size: 13px;">Georgia 974-395</p>
                                                        <p class="mb-0 text-secondary" style="font-size: 13px;">Phone: (006)-336-077</p>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="tab-pane fade" id="v-pills-summary" role="tabpanel" aria-labelledby="v-pills-summary-tab">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="row mt-2">
                                                    
                                                    <div class="co-12 col-md-6">
                                                        <h5 class="d-inline-block mb-0">Billing Summary</h5>
                                                    </div>
                                                    
                                                    <div class="co-12 col-md-6 text-end">
                                                        <a href="javascript:void(0)" class="btn btn-primary bill-click">Bill Entry</a>
                                                        <a href="bill-finalise.php" target="_blank" class="btn btn-secondary">Finalise Bill</a>
                                                    </div>
                                                </div>
                                                <ul class="list-group mt-3">
                                                    <li class="list-group-item">
                                                        <div class="d-flex justify-content-between">
                                                            <p class="mb-0">Total Addition</p>
                                                            <p class="mb-0"><strong>5000.00</strong></p>
                                                        </div>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <div class="d-flex justify-content-between">
                                                            <p class="mb-0">Total Deduction</p>
                                                            <p class="mb-0"><strong>10000.00</strong></p>
                                                        </div>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <div class="d-flex justify-content-between">
                                                            <p class="mb-0">Net Payable</p>
                                                            <p class="mb-0"><strong>15000.00</strong></p>
                                                        </div>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <div class="d-flex justify-content-between">
                                                            <p class="mb-0">Net Amount Paid</p>
                                                            <p class="mb-0"><strong>3000.00</strong></p>
                                                        </div>
                                                    </li>
                                                    <li class="list-group-item bg-light">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <p class="mb-0">
                                                                <span class="d-block">Due Balance</span>
                                                            </p>
                                                            <p class="mb-0"><strong>9000.00</strong></p>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        
                                        <div class="row mt-4">
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-12 col-md-6">
                                                        <h6>Addition</h6>
                                                    </div>
                                                    <div class="col-12 col-md-6 text-end">
                                                        <button type="submit" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#addAddition"><i class="uil uil-plus me-1"></i>Add Addition</button>
                                                    </div>
                                                </div>
                                                <div class="table-responsive mt-4">
                                                    <table class="table table-hover invoice-table mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th>Addition Head</th>
                                                                <th>Amount</th>
                                                                <th>Recorded By</th>
                                                                <th>Date</th>
                                                                <th>Notes</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    Fixed Fee
                                                                </td>
                                                                <td>7000</td>
                                                                <td>Vinay Goyel</td>
                                                                <td>
                                                                    12/11/2025
                                                                </td>
                                                                <td>Lorem ipsum doller sit amet.</td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    Loading/Unloading Charge
                                                                </td>
                                                                <td>1000</td>
                                                                <td>Abhishek Nayak</td>
                                                                <td>
                                                                    13/11/2025
                                                                </td>
                                                                <td>Lorem ipsum doller sit amet.</td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    Extra KM
                                                                </td>
                                                                <td>400</td>
                                                                <td>Nandan Biswas</td>
                                                                <td>
                                                                    14/11/2025
                                                                </td>
                                                                <td>Lorem ipsum doller sit amet.</td>
                                                            </tr>
                                                            
                                                            <tr>
                                                                <td>
                                                                    Tax
                                                                </td>
                                                                <td>200</td>
                                                                <td>Nilay Ray</td>
                                                                <td>
                                                                    15/11/2025
                                                                </td>
                                                                <td>Lorem ipsum doller sit amet.</td>
                                                            </tr>
                                                            
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        
                                        <div class="row mt-4">
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-12 col-md-6">
                                                        <h6>Deduction</h6>
                                                    </div>
                                                    <div class="col-12 col-md-6 text-end">
                                                        <button type="submit" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#addDeduction"><i class="uil uil-plus me-1"></i>Add Deduction</button>
                                                    </div>
                                                </div>
                                                <div class="table-responsive mt-4">
                                                    <table class="table table-hover invoice-table mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th>Deduction Head</th>
                                                                <th>Amount</th>
                                                                <th>Recorded By</th>
                                                                <th>Date</th>
                                                                <th>Notes</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    TDS
                                                                </td>
                                                                <td>7000</td>
                                                                <td>Vinay Goyel</td>
                                                                <td>
                                                                    12/11/2025
                                                                </td>
                                                                <td>Lorem ipsum doller sit amet.</td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    Mamul
                                                                </td>
                                                                <td>3000</td>
                                                                <td>Vinay Goyel</td>
                                                                <td>
                                                                    12/11/2025
                                                                </td>
                                                                <td>Lorem ipsum doller sit amet.</td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    P/R
                                                                </td>
                                                                <td>700</td>
                                                                <td>Vinay Goyel</td>
                                                                <td>
                                                                    12/11/2025
                                                                </td>
                                                                <td>Lorem ipsum doller sit amet.</td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    Prev. Adjustments
                                                                </td>
                                                                <td>1000</td>
                                                                <td>Vinay Goyel</td>
                                                                <td>
                                                                    12/11/2025
                                                                </td>
                                                                <td>Lorem ipsum doller sit amet.</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row mt-4">
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-12 col-md-6">
                                                        <h6>Transaction</h6>
                                                    </div>
                                                    <div class="col-12 col-md-6 text-end">
                                                        <button type="submit" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#addTransaction"><i class="uil uil-plus me-1"></i>Add Transaction</button>
                                                    </div>
                                                </div>
                                                <div class="table-responsive mt-4">
                                                    <table class="table table-hover invoice-table mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th>Date</th>
                                                                <th>Type</th>
                                                                <th>Mode of Payment</th>
                                                                <th>Amount</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    12/11/2025
                                                                </td>
                                                                <td>Advance</td>
                                                                <td>Cash</td>
                                                                <td>
                                                                    1200
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    13/11/2025
                                                                </td>
                                                                <td>Advance</td>
                                                                <td>Cash</td>
                                                                <td>
                                                                    1000
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    14/11/2025
                                                                </td>
                                                                <td>Advance</td>
                                                                <td>Cash</td>
                                                                <td>
                                                                    1100
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    15/11/2025
                                                                </td>
                                                                <td>Advance</td>
                                                                <td>Cash</td>
                                                                <td>
                                                                    1000
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="tab-pane fade" id="v-pills-transaction" role="tabpanel" aria-labelledby="v-pills-transaction-tab">
                                        <div class="row">
                                            <div class="col-12">
                                                <h5 class="d-inline-block mb-3">Expenses</h5>
                                                <!--<div class="mt-2">-->
                                                <!--    <div class="dropdown d-inline-block">-->
                                                <!--      <button class="btn btn-secondary dropdown-toggle" type="button" id="creditEntry" data-bs-toggle="dropdown" aria-expanded="false">-->
                                                <!--        Credit Entry (+)-->
                                                <!--      </button>-->
                                                <!--      <ul class="dropdown-menu" aria-labelledby="creditEntry">-->
                                                <!--        <li><a class="dropdown-item" href="javascript:void(0)">Unloading Detention</a></li>-->
                                                <!--        <li><a class="dropdown-item" href="javascript:void(0)">Unloading Charges</a></li>-->
                                                <!--        <li><a class="dropdown-item" href="javascript:void(0)">Other</a></li>-->
                                                <!--      </ul>-->
                                                <!--    </div>-->
                                                    
                                                <!--    <div class="dropdown d-inline-block">-->
                                                <!--      <button class="btn btn-secondary dropdown-toggle" type="button" id="creditEntry" data-bs-toggle="dropdown" aria-expanded="false">-->
                                                <!--        Debit Entry (-)-->
                                                <!--      </button>-->
                                                <!--      <ul class="dropdown-menu" aria-labelledby="creditEntry">-->
                                                <!--        <li><a class="dropdown-item" href="javascript:void(0)">Late Delivery Fine</a></li>-->
                                                <!--        <li><a class="dropdown-item" href="javascript:void(0)">Deduction from Shortages / Damages</a></li>-->
                                                <!--        <li><a class="dropdown-item" href="javascript:void(0)">Payment Cut</a></li>-->
                                                <!--        <li><a class="dropdown-item" href="javascript:void(0)">Claim</a></li>-->
                                                <!--      </ul>-->
                                                <!--    </div>-->
                                                    
                                                <!--    <div class="dropdown d-inline-block">-->
                                                <!--      <button class="btn btn-secondary dropdown-toggle" type="button" id="creditEntry" data-bs-toggle="dropdown" aria-expanded="false">-->
                                                <!--        Payment Request-->
                                                <!--      </button>-->
                                                <!--      <ul class="dropdown-menu" aria-labelledby="creditEntry">-->
                                                <!--        <li><a class="dropdown-item" href="javascript:void(0)">Advance Payment</a></li>-->
                                                <!--        <li><a class="dropdown-item" href="javascript:void(0)">Balance Payment</a></li>-->
                                                <!--      </ul>-->
                                                <!--    </div>-->
                                                <!--</div>-->
                                                <div class="mt-2">
                                                    <button type="submit" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#addExpense"><i class="uil uil-plus me-1"></i>Add Expense</button>
                                                </div>
                                                <ul class="list-group mt-3">
                                                    <li class="list-group-item">
                                                        <div class="d-flex justify-content-between">
                                                            <p class="mb-0">Fuel</p>
                                                            <p class="mb-0"><strong>₹ 15,000.00</strong></p>
                                                        </div>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <div class="d-flex justify-content-between">
                                                            <p class="mb-0">Toll Charges</p>
                                                            <p class="mb-0"><strong>₹ 10,000.00</strong></p>
                                                        </div>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <div class="d-flex justify-content-between">
                                                            <p class="mb-0">Driver Advance</p>
                                                            <p class="mb-0"><strong>₹ 50,000.00</strong></p>
                                                        </div>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <div class="d-flex justify-content-between">
                                                            <p class="mb-0">Maintenance</p>
                                                            <p class="mb-0"><strong>₹ 3,000.00</strong></p>
                                                        </div>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <div class="d-flex justify-content-between">
                                                            <p class="mb-0">Fooding</p>
                                                            <p class="mb-0"><strong>₹ 5,000.00</strong></p>
                                                        </div>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <div class="d-flex justify-content-between">
                                                            <p class="mb-0">Misc. Exp</p>
                                                            <p class="mb-0"><strong>₹ 2,000.00</strong></p>
                                                        </div>
                                                    </li>
                                                    <li class="list-group-item bg-light">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <p class="mb-0">
                                                                <span class="d-block">Total</span>
                                                            </p>
                                                            <p class="mb-0"><strong>₹ 90,000.00</strong></p>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="table-responsive mt-4">
                                                    <table class="table table-hover invoice-table mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th>Expense Head</th>
                                                                <th>Date & Time</th>
                                                                <th>Recorded By</th>
                                                                <th>Description</th>
                                                                <th>Type</th>
                                                                <th>Amount</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    Driver Advance
                                                                </td>
                                                                <td>12/11/2025 | 12:00 PM</td>
                                                                <td>Litesh Singh</td>
                                                                <td>
                                                                    Lorem ipsum doller sit amet.
                                                                </td>
                                                                <td>Debit</td>
                                                                <td>10,000.00</td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    Toll Charges
                                                                </td>
                                                                <td>12/11/2025 | 12:00 PM</td>
                                                                <td>Litesh Singh</td>
                                                                <td>
                                                                    Lorem ipsum doller sit amet.
                                                                </td>
                                                                <td>Debit</td>
                                                                <td>10,000.00</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="tab-pane fade" id="v-pills-driver_payout" role="tabpanel" aria-labelledby="v-pills-driver_payout-tab">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="row mt-2">
                                                    <div class="co-12 col-md-6">
                                                        <h5 class="d-inline-block mb-0">Trip Payout</h5>
                                                    </div>
                                                </div>
                                                
                                                <div class="mt-2">
                                                    <h6 class="d-inline-block tag">Trip ID: #TRIP001 | Vehicle: XY-55-TY6788 | Driver: Ramesh Singh</h6>
                                                    
                                                    <h6 class="mt-3"><strong>Fuel</strong></h6>
                                                    
                                                    <div class="table-responsive mt-3">
                                                        <table class="table table-hover invoice-table mb-0">
                                                            <tbody>
                                                                <tr>
                                                                    <th class="pt-1 pb-1 ps-2 pe-2">Fixed Fuel</th>
                                                                    <td class="pt-1 pb-1 ps-2 pe-2" style="width: 250px;">200 L</td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="pt-1 pb-1 ps-2 pe-2">Issued Fuel</th>
                                                                    <td class="pt-1 pb-1 ps-2 pe-2" style="width: 250px;">150 L</td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="pt-1 pb-1 ps-2 pe-2">Pending Fuel</th>
                                                                    <td class="pt-1 pb-1 ps-2 pe-2" style="width: 250px;">50 L</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    
                                                    <h6 class="mt-3"><strong>Advance</strong></h6>
                                                    
                                                    <div class="table-responsive mt-3">
                                                        <table class="table table-hover invoice-table mb-0">
                                                            <tbody>
                                                                <tr>
                                                                    <th class="pt-1 pb-1 ps-2 pe-2">Fixed Advance</th>
                                                                    <td class="pt-1 pb-1 ps-2 pe-2" style="width: 250px;">₹ 10,000</td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="pt-1 pb-1 ps-2 pe-2">Issued Advance</th>
                                                                    <td class="pt-1 pb-1 ps-2 pe-2" style="width: 250px;">₹ 6000</td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="pt-1 pb-1 ps-2 pe-2">Pending Advance</th>
                                                                    <td class="pt-1 pb-1 ps-2 pe-2" style="width: 250px;">₹ 4000</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    
                                                    <h6 class="mt-3"><strong>Margin</strong></h6>
                                                    
                                                    <div class="table-responsive mt-3">
                                                        <table class="table table-hover invoice-table mb-0">
                                                            <tbody>
                                                                <tr>
                                                                    <th class="pt-1 pb-1 ps-2 pe-2">Fuel Rate</th>
                                                                    <td class="pt-1 pb-1 ps-2 pe-2" style="width: 250px;">90/L</td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="pt-1 pb-1 ps-2 pe-2">Fuel Margin</th>
                                                                    <td class="pt-1 pb-1 ps-2 pe-2" style="width: 250px;">70 L * 90/L = ₹ 6300</td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="pt-1 pb-1 ps-2 pe-2">Advance Margin</th>
                                                                    <td class="pt-1 pb-1 ps-2 pe-2" style="width: 250px;">₹ 4000</td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><strong>Total</strong></th>
                                                                    <td class="pt-1 pb-1 ps-2 pe-2" style="width: 250px;"><strong>₹ 10,300</strong></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                
                                                <!--<div class="mt-4">-->
                                                <!--    <h6 class="d-inline-block tag">Vehicle - WB-58-FC6770 | Ashoke Dubey</h6>-->
                                                <!--    <div class="table-responsive mt-3">-->
                                                <!--        <table class="table table-hover invoice-table mb-0">-->
                                                <!--            <tbody>-->
                                                <!--                <tr>-->
                                                <!--                    <th class="pt-1 pb-1 ps-2 pe-2">Route Fixed Cost</th>-->
                                                <!--                    <td class="pt-1 pb-1 ps-2 pe-2" style="width: 250px;">₹ 11000</td>-->
                                                <!--                </tr>-->
                                                <!--                <tr>-->
                                                <!--                    <th class="pt-1 pb-1 ps-2 pe-2">Advanced Paid</th>-->
                                                <!--                    <td class="pt-1 pb-1 ps-2 pe-2" style="width: 250px;">₹ 5000</td>-->
                                                <!--                </tr>-->
                                                <!--                <tr>-->
                                                <!--                    <th class="pt-1 pb-1 ps-2 pe-2">Estimated Fuel</th>-->
                                                <!--                    <td class="pt-1 pb-1 ps-2 pe-2" style="width: 250px;">500L</td>-->
                                                <!--                </tr>-->
                                                <!--                <tr>-->
                                                <!--                    <th class="pt-1 pb-1 ps-2 pe-2">Actual Fuel</th>-->
                                                <!--                    <td class="pt-1 pb-1 ps-2 pe-2" style="width: 250px;">400L</td>-->
                                                <!--                </tr>-->
                                                <!--                <tr>-->
                                                <!--                    <th class="pt-1 pb-1 ps-2 pe-2">Fuel Rate</th>-->
                                                <!--                    <td class="pt-1 pb-1 ps-2 pe-2" style="width: 250px;">₹ 90/L</td>-->
                                                <!--                </tr>-->
                                                <!--                <tr>-->
                                                <!--                    <th class="pt-1 pb-1 ps-2 pe-2">Actual Trip Payout</th>-->
                                                <!--                    <td class="pt-1 pb-1 ps-2 pe-2" style="width: 250px;">₹ 20000</td>-->
                                                <!--                </tr>-->
                                                <!--                <tr>-->
                                                <!--                    <th class="pt-1 pb-1 ps-2 pe-2">Balance</th>-->
                                                <!--                    <td class="pt-1 pb-1 ps-2 pe-2" style="width: 250px;">₹ 15000</td>-->
                                                <!--                </tr>-->
                                                <!--                <tr>-->
                                                <!--                    <th class="pt-1 pb-1 ps-2 pe-2">Remarks</th>-->
                                                <!--                    <td class="pt-1 pb-1 ps-2 pe-2" style="width: 250px;">Efficient Trip</td>-->
                                                <!--                </tr>-->
                                                <!--            </tbody>-->
                                                <!--        </table>-->
                                                <!--    </div>-->
                                                <!--</div>-->
                                                
                                                <div class="row mt-4">
                                                    <div class="col-12">
                                                        <div class="row">
                                                            <div class="col-12 col-md-6">
                                                                <h6>Driver Expense</h6>
                                                            </div>
                                                            <div class="col-12 col-md-6 text-end">
                                                                <button type="submit" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#driverExpense"><i class="uil uil-plus me-1"></i>Add Expense</button>
                                                            </div>
                                                        </div>
                                                        <div class="table-responsive mt-4">
                                                            <table class="table table-hover invoice-table mb-0">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Expense Head</th>
                                                                        <th>Expense Type</th>
                                                                        <th>Debit Amount</th>
                                                                        <th>Credit Amount</th>
                                                                        <th>Notes</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>
                                                                            Vehicle Challan
                                                                        </td>
                                                                        <td>Credit</td>
                                                                        <td><span class="text-danger">--</span></td>
                                                                        <td>
                                                                            <span class="text-success">+ ₹200</span>
                                                                        </td>
                                                                        <td>Lorem ipsum doller sit amet.</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            Material Shortage
                                                                        </td>
                                                                        <td>Debit</td>
                                                                        <td><span class="text-danger">- ₹100</span></td>
                                                                        <td>
                                                                            <span class="text-success">--</span>
                                                                        </td>
                                                                        <td>Lorem ipsum doller sit amet.</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="tab-pane fade" id="v-pills-memo" role="tabpanel" aria-labelledby="v-pills-memo-tab">
                                        <div class="row align-items-center">
                                            <div class="col-12">
                                                <h5 class="d-inline-block mb-3">Memo</h5>
                                            </div>
                                            
                                            <form>
                                                <div class="card-body">
                                                    <div class="row form-group">
                                                        <div class="col-12 col-md-6">
                                                            <label>Memo Number</label>
                                                            <input type="text" class="form-control bg-light" value="Memo00120" readonly />
                                                        </div>
                                                        <div class="col-12 col-md-6">
                                                            <label>Load Vendor Name</label>
                                                            <input type="text" class="form-control bg-light" value="Samsung" readonly />
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row form-group">
                                                        <div class="col-12 col-md-6">
                                                            <label>Date</label>
                                                            <input type="date" class="form-control" />
                                                        </div>
                                                        <div class="col-12 col-md-6">
                                                            <label>Vehicle Number</label>
                                                            <input type="text" class="form-control bg-light" value="WB-12-VH-1234" readonly />
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row form-group">
                                                        <div class="col-12 col-md-6">
                                                            <label>Source</label>
                                                            <select class="form-select">
                                                                <option>Choose</option>
                                                                <option>Kolkata</option>
                                                                <option>Chennai</option>
                                                                <option>Delhi</option>
                                                                <option>Mumbai</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-12 col-md-6">
                                                            <label>Destination</label>
                                                            <select class="form-select">
                                                                <option>Choose</option>
                                                                <option>Kolkata</option>
                                                                <option>Chennai</option>
                                                                <option>Delhi</option>
                                                                <option>Mumbai</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row form-group">
                                                        <div class="col-12 col-md-6">
                                                            <label>Weight</label>
                                                            <input type="text" class="form-control bg-light" value="7mt/9mt" readonly />
                                                        </div>
                                                        <div class="col-12 col-md-6">
                                                            <label>Freight</label>
                                                            <!--<input type="text" class="form-control" />-->
                                                            <div class="input-group mb-3">
                                                                <span class="input-group-text" id="driver">₹</span>
                                                                <input type="text" class="form-control" aria-describedby="driver">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row form-group">
                                                        <div class="col-12 col-md-6">
                                                            <label>Advance</label>
                                                            <!--<input type="text" class="form-control" />-->
                                                            <div class="input-group mb-3">
                                                                <span class="input-group-text" id="driver">₹</span>
                                                                <input type="text" class="form-control" aria-describedby="driver">
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-6">
                                                            <label>Balance</label>
                                                            <!--<input type="text" class="form-control" />-->
                                                            <div class="input-group mb-3">
                                                                <span class="input-group-text" id="driver">₹</span>
                                                                <input type="text" class="form-control" aria-describedby="driver">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    
                                                    <div class="row form-group">
                                                        <div class="col-12 col-md-6">
                                                            <label>Halting</label>
                                                            <input type="text" class="form-control" />
                                                        </div>
                                                        <div class="col-12 col-md-6">
                                                            <label>Multi Points</label>
                                                            <input type="text" class="form-control" placeholder="Point 1, Point 2" />
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row form-group">
                                                        <div class="col-12 col-md-6">
                                                            <label>Loading Charges</label>
                                                            <!--<input type="text" class="form-control" />-->
                                                            <div class="input-group mb-3">
                                                                <span class="input-group-text" id="driver">₹</span>
                                                                <input type="text" class="form-control" aria-describedby="driver">
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-6">
                                                            <label>Unloading Charges</label>
                                                            <!--<input type="text" class="form-control" />-->
                                                            <div class="input-group mb-3">
                                                                <span class="input-group-text" id="driver">₹</span>
                                                                <input type="text" class="form-control" aria-describedby="driver">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row form-group">
                                                        <div class="col-12">
                                                            <label>Remarks</label>
                                                            <textarea type="text" class="form-control" rows="3"></textarea>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="text-end">
                                                        <button class="btn btn-primary">Save</button>
                                                    </div>
                                                </div>
                                            </form>
                                            
                                            <!--<div class="table-responsive">-->
                                            <!--    <table class="table custom-driver-table">-->
                                            <!--        <thead>-->
                                            <!--            <tr>-->
                                            <!--                <th>S.No.</th>-->
                                            <!--                <th>Date</th>-->
                                            <!--                <th>Load Vendor <br><span class="text-secondary">Rank</span></th>-->
                                            <!--                <th>Memo Number</th>-->
                                            <!--                <th>Vehicle Number</th>-->
                                            <!--                <th>Route</th>-->
                                            <!--                <th>Freight</th>-->
                                            <!--                <th>Advance Balace</th>-->
                                            <!--                <th>Trip Status</th>-->
                                            <!--                <th>Payment Status</th>-->
                                                            <!--<th class="text-center">Actions</th>-->
                                            <!--            </tr>-->
                                            <!--        </thead>-->
                                            <!--        <tbody>-->
                                                        
                                            <!--            <tr>-->
                                            <!--                <td>-->
                                            <!--                    <span class="value">1</span>-->
                                            <!--                </td>-->
                                            <!--                <td><span class="value">12/11/2027</span></td>-->
                                            <!--                <td><span class="value">ABC Logistics</span><br> <span class="badge bg-success text-white">Green</span></td>-->
                                            <!--                <td><span class="value">MEMO-1420110012345</span></td>-->
                                            <!--                <td><span class="value">WB-12-AB-1234</span></td>-->
                                            <!--                <td><span class="value">KOL-DEL</span></td>-->
                                            <!--                <td><span class="value">120</span></td>-->
                                            <!--                <td><span class="value">50,000</span></td>-->
                                            <!--                <td><span class="value">Initated</span></td>-->
                                            <!--                <td><span class="value">Paid</span></td>-->
                                                            <!--<td class="text-center">-->
                                                            <!--    <a href="driver-details.php" class="btn btn-sm-custom">View Details</a>-->
                                                            <!--</td>-->
                                            <!--            </tr>-->
                                                        
                                            <!--        </tbody>-->
                                            <!--    </table>-->
                                            <!--</div>-->
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-12 col-md-3">
                                <div class="bg-light p-3">
                                    <div class="d-flex mb-3">
                                        <label class="me-4">Status</label>
                                        <select class="form-select select2">
                                            <option>Choose..</option>
                                            <option>New</option>
                                            <option>Vehicle Not Assigned</option>
                                            <option>Vehicle Assigned</option>
                                            <option>Loading</option>
                                            <option>In-transit</option>
                                            <option>Reported</option>
                                            <option>Delayed</option>
                                            <option>Detailned</option>
                                            <option>Unloaded</option>
                                            <option>Breakdown</option>
                                            <option>In Repair</option>
                                            <option>Accident</option>
                                        </select>
                                    </div>
                                    
                                    <div class="d-flex">
                                        <label class="me-4">Reviews</label>
                                        <a href="javascript:void(0)" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addReview"><i class="uil uil-plus me-1"></i>Review</a>
                                    </div>
                                    
                                    <!--<ul class="list-group mt-2">-->
                                    <!--  <li class="list-group-item p-1">-->
                                    <!--      <div class="d-flex justify-content-between" style="font-size:12px;">-->
                                    <!--          <span><i class="fa fa-check-circle me-1 text-success" aria-hidden="true"></i> Ashok Murthy</span>-->
                                    <!--          <span>25/10/2025 | 12:00 PM</span>-->
                                    <!--      </div>-->
                                    <!--  </li>-->
                                    <!--</ul>-->
                                    
                                    <p style="font-size: 14px;" class="mb-2 mt-2">Compliance Check</p>
                                    <div class="table-responsive mt-3">
                                        <table class="table table-hover invoice-table mb-0">
                                            <tbody>
                                                <tr>
                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-1 text-success" aria-hidden="true"></i>Broker PAN</th>
                                                    <td class="pt-1 pb-1 ps-2 pe-2" style="width: 90px;">Valid</td>
                                                </tr>
                                                <tr>
                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-1 text-success" aria-hidden="true"></i>Broker Bank Account</th>
                                                    <td class="pt-1 pb-1 ps-2 pe-2" style="width: 90px;">Active</td>
                                                </tr>
                                                <tr>
                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-1 text-success" aria-hidden="true"></i>Broker Name match PAN</th>
                                                    <td class="pt-1 pb-1 ps-2 pe-2" style="width: 90px;">High</td>
                                                </tr>
                                                <tr>
                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-1 text-success" aria-hidden="true"></i>Vehicle Valid</th>
                                                    <td class="pt-1 pb-1 ps-2 pe-2" style="width: 90px;">Lorem Ipsum is dummy text.</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                    <p style="font-size: 14px;" class="mb-2 mt-2">History</p>
                                    <ul class="list-group mt-2">
                                        <li class="text-center list-group-item p-1">
                                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#viewHistory" style="font-size: 12px;">View Full History (10)</a>
                                        </li>
                                        <li class="list-group-item p-1">
                                            <div class="d-flex justify-content-between pt-1" style="font-size:12px; line-height: 12px;">
                                                <span>ASOKE</span>
                                                <span>25/10/2025 | 12:00 PM</span>
                                            </div>
                                            <small style="font-size: 10px;">Lorem ipsum is a simply dummy text</small>
                                        </li>
                                        <li class="list-group-item p-1">
                                            <div class="d-flex justify-content-between pt-1" style="font-size:12px; line-height: 12px;">
                                                <span>ASOKE</span>
                                                <span>25/10/2025 | 12:00 PM</span>
                                            </div>
                                            <small style="font-size: 10px;">Lorem ipsum is a simply dummy text</small>
                                        </li>
                                        <li class="list-group-item p-1">
                                            <div class="d-flex justify-content-between pt-1" style="font-size:12px; line-height: 12px;">
                                                <span>ASOKE</span>
                                                <span>25/10/2025 | 12:00 PM</span>
                                            </div>
                                            <small style="font-size: 10px;">Lorem ipsum is a simply dummy text</small>
                                        </li>
                                        <li class="list-group-item p-1">
                                            <div class="d-flex justify-content-between pt-1" style="font-size:12px; line-height: 12px;">
                                                <span>ASOKE</span>
                                                <span>25/10/2025 | 12:00 PM</span>
                                            </div>
                                            <small style="font-size: 10px;">Lorem ipsum is a simply dummy text</small>
                                        </li>
                                        <li class="list-group-item p-1">
                                            <div class="d-flex justify-content-between pt-1" style="font-size:12px; line-height: 12px;">
                                                <span>ASOKE</span>
                                                <span>25/10/2025 | 12:00 PM</span>
                                            </div>
                                            <small style="font-size: 10px;">Lorem ipsum is a simply dummy text</small>
                                        </li>
                                        <li class="list-group-item p-1">
                                            <div class="d-flex justify-content-between pt-1" style="font-size:12px; line-height: 12px;">
                                                <span>ASOKE</span>
                                                <span>25/10/2025 | 12:00 PM</span>
                                            </div>
                                            <small style="font-size: 10px;">Lorem ipsum is a simply dummy text</small>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>{{-- /layout-wrapper --}}

<div class="vehicledtl-bd srlog-bdwrapper">
    <div class="topbar-bd">
        <div class="item1">
            <div class="container-fluid">
                <h1>Trip Details</h1>
            </div>
        </div>
        <div class="item2">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-lg-5">
                        <div class="ltblock">
                            <div class="icon_car">
                                <img src="images/icons/car-icon04.png" />
                            </div>
                            <div class="text">
                                <div class="topsec mb-1">
                                    <p>Kolkata - Mumbai</p>
                                </div>
                                <div style="font-size: 12px;">
                                    <span>Status:</span>
                                    <span class="text-success">Initiated</span>
                                </div>
                                <div style="font-size: 12px;">
                                    <span class="">Created On:</span>
                                    <span>25/10/2025</span>
                                </div>
                                <div style="font-size: 12px;">
                                    <span class="">Created By:</span>
                                    <span>Anmol Kaur</span>
                                </div>
                            </div>
                            <div class="liveloc_sec">
                                <span>Vehicle Allocated</span>
                                <p class="text-warning">Pending</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7 text-end">
                        <button class="btn btn-primary attachment-click"><i class="uil uil-paperclip me-1"></i>Attachments</button>
                        <!--<button class="btn btn-secondary"><i class="uil uil-hourglass me-1"></i>Start Tracking</button>-->
                        <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#closeTrip"><i class="uil uil-check-circle me-1"></i>Settle Trip</button>
                        <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#cancelTrip"><i class="uil uil-times-circle me-1"></i>Cancel Trip</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="vehicleinfo-wrap">
        <div class="vehicleinfo-sec">
            <div class="container-fluid">
                <div class="timeline-wrap">
                    <div class="row">
                        <div class="col-12 col-md-3">
                            <div class="nav flex-column nav-pills ms-3 ps-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <button class="nav-link timeline-active active" id="v-pills-tripInit-tab" data-bs-toggle="pill" data-bs-target="#v-pills-tripInit" type="button" role="tab" aria-controls="v-pills-tripInit" aria-selected="true">Trip Initiation</button>
                                <button class="nav-link" id="v-pills-vehAllocation-tab" data-bs-toggle="pill" data-bs-target="#v-pills-vehAllocation" type="button" role="tab" aria-controls="v-pills-vehAllocation" aria-selected="false" tabindex="-1">Vehicle Allocation</button>
                                <button class="nav-link" id="v-pills-vehStatus-tab" data-bs-toggle="pill" data-bs-target="#v-pills-vehStatus" type="button" role="tab" aria-controls="v-pills-vehStatus" aria-selected="false" tabindex="-1">Vehicle Status</button>
                                <button class="nav-link" id="v-pills-ewayLr-tab" data-bs-toggle="pill" data-bs-target="#v-pills-ewayLr" type="button" role="tab" aria-controls="v-pills-ewayLr" aria-selected="false" tabindex="-1">Eway + LR </button>
                                <button class="nav-link" id="v-pills-pod-tab" data-bs-toggle="pill" data-bs-target="#v-pills-pod" type="button" role="tab" aria-controls="v-pills-pod" aria-selected="false" tabindex="-1">POD</button>
                                <hr>
                                <button class="nav-link transaction-tab mb-0 ms-0" id="v-pills-driver_payout-tab" data-bs-toggle="pill" data-bs-target="#v-pills-driver_payout" type="button" role="tab" aria-controls="v-pills-driver_payout" aria-selected="false" tabindex="-1">Trip Payout</button>
                                <button class="nav-link transaction-tab mb-0 ms-0" id="v-pills-transaction-tab" data-bs-toggle="pill" data-bs-target="#v-pills-transaction" type="button" role="tab" aria-controls="v-pills-transaction" aria-selected="false" tabindex="-1">Expenses</button>
                                <button class="nav-link transaction-tab mb-0 ms-0" id="v-pills-summary-tab" data-bs-toggle="pill" data-bs-target="#v-pills-summary" type="button" role="tab" aria-controls="v-pills-summary" aria-selected="false" tabindex="-1">Billing Summary</button>
                                <button class="nav-link transaction-tab mb-0 ms-0" id="v-pills-memo-tab" data-bs-toggle="pill" data-bs-target="#v-pills-memo" type="button" role="tab" aria-controls="v-pills-memo-tab" aria-selected="false" tabindex="-1">Memo</button>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="tab-content" id="v-pills-tabContent">
                                <div class="tab-pane fade active show" id="v-pills-tripInit" role="tabpanel" aria-labelledby="v-pills-tripInit-tab">
                                    <div class="row">
                                        <div class="col-12">
                                            <div>
                                                <div class="row">
                                                    <div class="col-12 col-md-8">
                                                        <h5 class="mb-3">Trip Initiations</h5>
                                                    </div>
                                                    <div class="col-12 col-md-4 text-end">
                                                        <a href="javascript:void(0)" data-bs-target="#editTrip" data-bs-toggle="modal"><i class="uil uil-pen"></i></a>
                                                    </div>
                                                </div>
                                                <div class="row right-det-wrap">
                                                    <div class="col-12 col-md-3">
                                                        <p class="label-text mb-0">Trip ID</p>
                                                        <p>#001</p>
                                                    </div>
                                                    <div class="col-12 col-md-3">
                                                        <p class="label-text mb-0">Trip Type</p>
                                                        <p>Outside Booking</p>
                                                    </div>
                                                    <div class="col-12 col-md-3">
                                                        <p class="label-text mb-0">Trip Category</p>
                                                        <p>Line</p>
                                                    </div>
                                                    <div class="col-12 col-md-3">
                                                        <p class="label-text mb-0">Internal Trip ID</p>
                                                        <p>#001001765</p>
                                                    </div>
                                                    <div class="col-12 col-md-3">
                                                        <p class="label-text mb-0">Trip Date</p>
                                                        <p>25/10/2025</p>
                                                    </div>
                                                    <div class="col-12 col-md-3">
                                                        <p class="label-text mb-0">Consigner</p>
                                                        <p>Britania Kolkata</p>
                                                    </div>
                                                    <div class="col-12 col-md-3">
                                                        <p class="label-text mb-0">Consignee</p>
                                                        <p>Samsung Hydrabad</p>
                                                    </div>
                                                    <div class="col-12 col-md-3">
                                                        <p class="label-text mb-0">Load Vendor</p>
                                                        <p>Blue Dart</p>
                                                    </div>
                                                    <div class="col-12 col-md-3">
                                                        <p class="label-text mb-0">RAG Status</p>
                                                        <p><span class="badge bg-danger">Red</span></p>
                                                    </div>
                                                    <div class="col-12 col-md-3">
                                                        <p class="label-text mb-0">Customer</p>
                                                        <p>Nestle</p>
                                                    </div>
                                                    <div class="col-12 col-md-3">
                                                        <p class="label-text mb-0">Vehicle Type</p>
                                                        <p>Large Truck</p>
                                                    </div>
                                                    <div class="col-12 col-md-3">
                                                        <p class="label-text mb-0">Vehicle Size</p>
                                                        <p>14 FT - XXM 14M * 9M * 12M</p>
                                                    </div>
                                                    <div class="col-12 col-md-3">
                                                        <p class="label-text mb-0">Route</p>
                                                        <p>Kolkata - Mumbai</p>
                                                    </div>
                                                    <div class="col-12 col-md-3">
                                                        <p class="label-text mb-0">Source</p>
                                                        <p>Kolkata</p>
                                                    </div>
                                                    <div class="col-12 col-md-3">
                                                        <p class="label-text mb-0">Stop 1</p>
                                                        <p>Kolaghat</p>
                                                    </div>
                                                    <div class="col-12 col-md-3">
                                                        <p class="label-text mb-0">Stop 2</p>
                                                        <p>Patna</p>
                                                    </div>
                                                    <div class="col-12 col-md-3">
                                                        <p class="label-text mb-0">Destination</p>
                                                        <p>Mumbai</p>
                                                    </div>
                                                    <div class="col-12 col-md-3">
                                                        <p class="label-text mb-0">Distance</p>
                                                        <p>150KM</p>
                                                    </div>
                                                    <div class="col-12 col-md-3">
                                                        <p class="label-text mb-0">Priority</p>
                                                        <p>High</p>
                                                    </div>
                                                    <div class="col-12 col-md-3">
                                                        <p class="label-text mb-0">Tarpaulin</p>
                                                        <p>Yes</p>
                                                    </div>
                                                    <div class="col-12">
                                                        <p class="label-text mb-0">Comment</p>
                                                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                                                            Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
                                                            when an unknown printer took a galley of type and scrambled it to make a type
                                                            specimen book.
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="v-pills-vehAllocation" role="tabpanel" aria-labelledby="v-pills-vehAllocation-tab">
                                    <div class="row align-items-center">
                                        <div class="col-12">
                                            <h5 class="d-inline-block mb-3">Vehicles Allocations</h5>
                                            <div class="accordion" id="accordionVehicle">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingOne">
                                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                        <span class="sec-title">Select from Suggested Vehicles
                                                        <span class="badge rounded-pill bg-danger ms-2">
                                                        3
                                                        </span>
                                                        </span>
                                                        </button>
                                                    </h2>
                                                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionVehicle">
                                                        <div class="accordion-body p-2">
                                                            <div class="vehiclestable vehicle-allocation">
                                                                <form>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="checkVehAlo" id="check1">
                                                                        <label class="form-check-label" for="check1">
                                                                            <div class="vehicle-card color-left01 d-block">
                                                                                <div class="row info-grid">
                                                                                    <div class="col-12 col-md-4 info-item mb-3">
                                                                                        <div class="label">Vehicle Number</div>
                                                                                        <div class="value">WB-12-AB-1237</div>
                                                                                    </div>
                                                                                    <div class="col-12 col-md-4 info-item mb-3">
                                                                                        <div class="label">Vehicle Type</div>
                                                                                        <div class="value">Large Container</div>
                                                                                    </div>
                                                                                    <div class="col-12 col-md-4 info-item mb-3">
                                                                                        <div class="label">Vehicle Size</div>
                                                                                        <div class="value">14 FT - XXM 14M * 9M * 12M</div>
                                                                                    </div>
                                                                                    <div class="col-12 col-md-4 info-item mb-3">
                                                                                        <div class="label">Current Status</div>
                                                                                        <div class="value">In Trip</div>
                                                                                    </div>
                                                                                    <div class="col-12 col-md-4 info-item mb-3">
                                                                                        <div class="label">Live Location</div>
                                                                                        <div class="value">Kolkata</div>
                                                                                    </div>
                                                                                    <div class="col-12 col-md-4 info-item mb-3">
                                                                                        <div class="label">Empty Since</div>
                                                                                        <div class="value">12/09/2025</div>
                                                                                    </div>
                                                                                    <div class="col-12 col-md-4 info-item mb-3">
                                                                                        <div class="label">Driver Name & Number</div>
                                                                                        <div class="value" >Ashok Ray <br/>+91 8879402641</div>
                                                                                    </div>
                                                                                    <div class="col-12 col-md-4 info-item mb-3">
                                                                                        <div class="label">RAG Status</div>
                                                                                        <div class="value"><span class="badge bg-danger">Red</span></div>
                                                                                    </div>
                                                                                    <div class="col-12 col-md-4 info-item mb-3">
                                                                                        <div class="label">Associated Since</div>
                                                                                        <div class="value">10 Years 5 Months 10 Days</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="checkVehAlo" id="check2">
                                                                        <label class="form-check-label" for="check2">
                                                                            <div class="vehicle-card color-left02 d-block">
                                                                                <div class="row info-grid">
                                                                                    <div class="col-12 col-md-4 info-item mb-3">
                                                                                        <div class="label">Vehicle Number</div>
                                                                                        <div class="value">WB-12-AB-1237</div>
                                                                                    </div>
                                                                                    <div class="col-12 col-md-4 info-item mb-3">
                                                                                        <div class="label">Vehicle Type</div>
                                                                                        <div class="value">Large Container</div>
                                                                                    </div>
                                                                                    <div class="col-12 col-md-4 info-item mb-3">
                                                                                        <div class="label">Vehicle Size</div>
                                                                                        <div class="value">14 FT - XXM 14M * 9M * 12M</div>
                                                                                    </div>
                                                                                    <div class="col-12 col-md-4 info-item mb-3">
                                                                                        <div class="label">Current Status</div>
                                                                                        <div class="value">Maintenance</div>
                                                                                    </div>
                                                                                    <div class="col-12 col-md-4 info-item mb-3">
                                                                                        <div class="label">Live Location</div>
                                                                                        <div class="value">Kolkata</div>
                                                                                    </div>
                                                                                    <div class="col-12 col-md-4 info-item mb-3">
                                                                                        <div class="label">Empty Since</div>
                                                                                        <div class="value">12/09/2025</div>
                                                                                    </div>
                                                                                    <div class="col-12 col-md-4 info-item mb-3">
                                                                                        <div class="label">Driver Name & Number</div>
                                                                                        <div class="value" >Ashok Ray <br/>+91 8879402641</div>
                                                                                    </div>
                                                                                    <div class="col-12 col-md-4 info-item mb-3">
                                                                                        <div class="label">RAG Status</div>
                                                                                        <div class="value"><span class="badge bg-danger">Red</span></div>
                                                                                    </div>
                                                                                    <div class="col-12 col-md-4 info-item mb-3">
                                                                                        <div class="label">Associated Since</div>
                                                                                        <div class="value">10 Years 5 Months 10 Days</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="checkVehAlo" id="check3">
                                                                        <label class="form-check-label" for="check3">
                                                                            <div class="vehicle-card color-left03 d-block">
                                                                                <div class="row info-grid">
                                                                                    <div class="col-12 col-md-4 info-item mb-3">
                                                                                        <div class="label">Vehicle Number</div>
                                                                                        <div class="value">WB-12-AB-1237</div>
                                                                                    </div>
                                                                                    <div class="col-12 col-md-4 info-item mb-3">
                                                                                        <div class="label">Vehicle Type</div>
                                                                                        <div class="value">Large Container</div>
                                                                                    </div>
                                                                                    <div class="col-12 col-md-4 info-item mb-3">
                                                                                        <div class="label">Vehicle Size</div>
                                                                                        <div class="value">14 FT - XXM 14M * 9M * 12M</div>
                                                                                    </div>
                                                                                    <div class="col-12 col-md-4 info-item mb-3">
                                                                                        <div class="label">Current Status</div>
                                                                                        <div class="value">Empty</div>
                                                                                    </div>
                                                                                    <div class="col-12 col-md-4 info-item mb-3">
                                                                                        <div class="label">Live Location</div>
                                                                                        <div class="value">Kolkata</div>
                                                                                    </div>
                                                                                    <div class="col-12 col-md-4 info-item mb-3">
                                                                                        <div class="label">Empty Since</div>
                                                                                        <div class="value">12/09/2025</div>
                                                                                    </div>
                                                                                    <div class="col-12 col-md-4 info-item mb-3">
                                                                                        <div class="label">Driver Name & Number</div>
                                                                                        <div class="value" >Ashok Ray <br/>+91 8879402641</div>
                                                                                    </div>
                                                                                    <div class="col-12 col-md-4 info-item mb-3">
                                                                                        <div class="label">RAG Status</div>
                                                                                        <div class="value"><span class="badge bg-danger">Red</span></div>
                                                                                    </div>
                                                                                    <div class="col-12 col-md-4 info-item mb-3">
                                                                                        <div class="label">Associated Since</div>
                                                                                        <div class="value">10 Years 5 Months 10 Days</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </label>
                                                                    </div>
                                                                    <!--<div class="vehicle-card color-left01 d-block">-->
                                                                    <!--    <div class="row info-grid">-->
                                                                    <!--      <div class="col-12 col-md-4 info-item mb-3">-->
                                                                    <!--        <div class="label">Vehicle Number</div>-->
                                                                    <!--        <div class="value">WB-12-AB-1237</div>-->
                                                                    <!--      </div> -->
                                                                    <!--      <div class="col-12 col-md-4 info-item mb-3">-->
                                                                    <!--        <div class="label">Current Status</div>-->
                                                                    <!--        <div class="value">In Trip</div>-->
                                                                    <!--      </div> -->
                                                                    <!--      <div class="col-12 col-md-4 info-item mb-3">-->
                                                                    <!--        <div class="label">Live Location</div>-->
                                                                    <!--        <div class="value">Kolkata</div>-->
                                                                    <!--      </div> -->
                                                                    <!--      <div class="col-12 col-md-4 info-item mb-3">-->
                                                                    <!--        <div class="label">Empty Since</div>-->
                                                                    <!--        <div class="value">12/09/2025</div>-->
                                                                    <!--      </div>-->
                                                                    <!--      <div class="col-12 col-md-4 info-item mb-3">-->
                                                                    <!--        <div class="label">Driver Name</div>-->
                                                                    <!--        <div class="value">Ashok Ray</div>-->
                                                                    <!--      </div>-->
                                                                    <!--       <div class="col-12 col-md-4 info-item mb-3">-->
                                                                    <!--          <div class="label">Driver Number</div>-->
                                                                    <!--        <div class="value">+91 8879402641</div>-->
                                                                    <!--      </div> -->
                                                                    <!--    </div>-->
                                                                    <!--</div>-->
                                                                    <!--<div class="vehicle-card color-left02 d-block">-->
                                                                    <!--    <div class="row info-grid">-->
                                                                    <!--      <div class="col-12 col-md-4 info-item mb-3">-->
                                                                    <!--        <div class="label">Vehicle Number</div>-->
                                                                    <!--        <div class="value">WB-12-AB-1237</div>-->
                                                                    <!--      </div> -->
                                                                    <!--      <div class="col-12 col-md-4 info-item mb-3">-->
                                                                    <!--        <div class="label">Current Status</div>-->
                                                                    <!--        <div class="value">Maintenance</div>-->
                                                                    <!--      </div>-->
                                                                    <!--      <div class="col-12 col-md-4 info-item mb-3">-->
                                                                    <!--        <div class="label">Live Location</div>-->
                                                                    <!--        <div class="value">Kolkata</div>-->
                                                                    <!--      </div>-->
                                                                    <!--      <div class="col-12 col-md-4 info-item mb-3">-->
                                                                    <!--        <div class="label">Empty Since</div>-->
                                                                    <!--        <div class="value">12/09/2025</div>-->
                                                                    <!--      </div>-->
                                                                    <!--      <div class="col-12 col-md-4 info-item mb-3">-->
                                                                    <!--        <div class="label">Driver Name</div>-->
                                                                    <!--        <div class="value">--</div>-->
                                                                    <!--      </div>-->
                                                                    <!--       <div class="col-12 col-md-4 info-item mb-3">-->
                                                                    <!--          <div class="label">Driver Number</div>-->
                                                                    <!--        <div class="value">--</div>-->
                                                                    <!--      </div> -->
                                                                    <!--    </div>-->
                                                                    <!--</div>-->
                                                                    <!--<div class="vehicle-card color-left03 d-block">-->
                                                                    <!--    <div class="row info-grid">-->
                                                                    <!--      <div class="col-12 col-md-4 info-item mb-3">-->
                                                                    <!--        <div class="label">Vehicle Number</div>-->
                                                                    <!--        <div class="value">WB-12-AB-1237</div>-->
                                                                    <!--      </div> -->
                                                                    <!--      <div class="col-12 col-md-4 info-item mb-3">-->
                                                                    <!--        <div class="label">Current Status</div>-->
                                                                    <!--        <div class="value">Empty</div>-->
                                                                    <!--      </div>-->
                                                                    <!--      <div class="col-12 col-md-4 info-item mb-3">-->
                                                                    <!--        <div class="label">Live Location</div>-->
                                                                    <!--        <div class="value">Kolkata</div>-->
                                                                    <!--      </div> -->
                                                                    <!--      <div class="col-12 col-md-4 info-item mb-3">-->
                                                                    <!--        <div class="label">Empty Since</div>-->
                                                                    <!--        <div class="value">12/09/2025</div>-->
                                                                    <!--      </div>-->
                                                                    <!--      <div class="col-12 col-md-4 info-item mb-3">-->
                                                                    <!--        <div class="label">Driver Name</div>-->
                                                                    <!--        <div class="value">--</div>-->
                                                                    <!--      </div>-->
                                                                    <!--       <div class="col-12 col-md-4 info-item mb-3">-->
                                                                    <!--          <div class="label">Driver Number</div>-->
                                                                    <!--        <div class="value">--</div>-->
                                                                    <!--      </div> -->
                                                                    <!--    </div>    -->
                                                                    <!--</div>-->
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="separator">
                                                <hr>
                                                <span>OR</span>
                                            </div>
                                            <form class="allocation-form">
                                                <div class="mt-5">
                                                    <div class="row form-group">
                                                        <div class="col-12">
                                                            <h6 class="text-center">Select any of these below</h6>
                                                            <div class="text-center veh-type-wrap mt-3">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input own-veh" type="radio" name="newVehicle" id="ownVeh" value="Own Vehicle">
                                                                    <label class="form-check-label" for="ownVeh">Own Vehicle</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input external-veh" type="radio" name="newVehicle" id="external" value="External">
                                                                    <label class="form-check-label" for="external">External / Vendor</label>
                                                                </div>
                                                            </div>
                                                            <!--/////////////////////////////////////////////////////////////////////////////////////////////-->
                                                            <div class="if-own mt-2">
                                                                <div class="card-body">
                                                                    <!--<div class="row form-group">-->
                                                                    <!--   <div class="col-12 col-md-6">-->
                                                                    <!--        <label>Expected Start Date</label>-->
                                                                    <!--        <input class="form-control" type="date" />-->
                                                                    <!--    </div>-->
                                                                    <!--    <div class="col-12 col-md-6">-->
                                                                    <!--        <label>Expected Start Time</label>-->
                                                                    <!--        <input class="form-control" type="time" />-->
                                                                    <!--    </div>-->
                                                                    <!--</div>-->
                                                                    <!--<div class="row form-group">-->
                                                                    <!--    <div class="col-12 col-md-6">-->
                                                                    <!--        <label>Loading Point</label>-->
                                                                    <!--        <select class="form-select select2">-->
                                                                    <!--            <option>Choose..</option>-->
                                                                    <!--            <option>Webel Gate</option>-->
                                                                    <!--            <option>SDF</option>-->
                                                                    <!--            <option>DLF 1</option>-->
                                                                    <!--            <option>DLF 2</option>-->
                                                                    <!--            <option>Laketown</option>-->
                                                                    <!--        </select>-->
                                                                    <!--    </div>-->
                                                                    <!--    <div class="col-12 col-md-6">-->
                                                                    <!--        <label>Unloading Point</label>-->
                                                                    <!--        <select class="form-select select2">-->
                                                                    <!--            <option>Choose..</option>-->
                                                                    <!--            <option>Webel Gate</option>-->
                                                                    <!--            <option>SDF</option>-->
                                                                    <!--            <option>DLF 1</option>-->
                                                                    <!--            <option>DLF 2</option>-->
                                                                    <!--            <option>Laketown</option>-->
                                                                    <!--        </select>-->
                                                                    <!--    </div>-->
                                                                    <!--</div>-->
                                                                    <div class="form-group">
                                                                        <label>Select Vehicle from Below List</label>
                                                                        <select class="form-select select2">
                                                                            <option>Choose..</option>
                                                                            <option>WB-12-AB-1237</option>
                                                                            <optin>WB-13-XZ-1450</optin>
                                                                            <option>WB-12-LC-0090</option>
                                                                            <optin>WB-13-PL-6789</optin>
                                                                            <option>WB-12-AB-1237</option>
                                                                            <optin>WB-13-XZ-1450</optin>
                                                                            <option>WB-12-LC-0090</option>
                                                                            <optin>WB-13-PL-6789</optin>
                                                                            <option>WB-12-AB-1237</option>
                                                                            <optin>WB-13-XZ-1450</optin>
                                                                            <option>WB-12-LC-0090</option>
                                                                            <optin>WB-13-PL-6789</optin>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="card-body mt-3" style="border-left: 3px solid #032671;">
                                                                    <div class="view-booking-det d-block">
                                                                        <div class="row info-grid">
                                                                            <div class="col-12 col-md-4 info-item mb-3">
                                                                                <div class="label">Driver Name &amp; Number</div>
                                                                                <div class="value">Ashok Ray <br>+91 8879402641</div>
                                                                            </div>
                                                                            <div class="col-12 col-md-4 info-item mb-3">
                                                                                <div class="label">Driver Experience</div>
                                                                                <div class="value">5 Years 10 Months</div>
                                                                            </div>
                                                                            <div class="col-12 col-md-4 info-item mb-3">
                                                                                <div class="label">RAG Status</div>
                                                                                <div class="value"><span class="badge bg-danger">Red</span></div>
                                                                            </div>
                                                                            <div class="col-12 col-md-4 info-item mb-3">
                                                                                <div class="label">Vehicle Status</div>
                                                                                <div class="value">Empty</div>
                                                                            </div>
                                                                            <div class="col-12 col-md-4 info-item mb-3">
                                                                                <div class="label">Availability</div>
                                                                                <div class="value">Available</div>
                                                                            </div>
                                                                            <div class="col-12 col-md-4 info-item mb-3">
                                                                                <div class="label">Live Location</div>
                                                                                <div class="value">Kolkata</div>
                                                                            </div>
                                                                            <div class="col-12 col-md-4 info-item mb-3">
                                                                                <div class="label">Vehicle Rank</div>
                                                                                <div class="value">Empty</div>
                                                                            </div>
                                                                            <div class="col-12 col-md-4 info-item mb-3">
                                                                                <div class="label">Line Trip</div>
                                                                                <div class="value">5</div>
                                                                            </div>
                                                                            <div class="col-12 col-md-4 info-item mb-3">
                                                                                <div class="label">Local Trip</div>
                                                                                <div class="value">7</div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="vahan-det-wrap mt-3">
                                                                    <a class="d-block mb-2 mt-2" data-bs-toggle="collapse" href="#vahanDetails" role="button" aria-expanded="false" aria-controls="vahanDetails">
                                                                    Vahan Details <i class="uil uil-angle-down"></i>
                                                                    </a>
                                                                    <div class="collapse mb-4" id="vahanDetails">
                                                                        <div class="card card-body">
                                                                            <div class="row">
                                                                                <div class="col-12">
                                                                                    <div class="table-responsive">
                                                                                        <table class="table table-hover veh-det-table invoice-table mb-0">
                                                                                            <tbody>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Owner Name</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">Mohammad Hafiz</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Address</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">H.NO.62, Vill Hathipur Chittu, PS Kundarki, Teh. Bilari, Moradabad — Ph: 9588416786, 999999</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Status</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">Active</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Registration Date</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">19/03/2015</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Fitness Certificate Expiry</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">10/04/2026</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Insurance Expiry</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">H.NO.62, Vill Hathipur Chittu, PS Kundarki, Teh. Bilari, Moradabad — Ph: 9588416786, 999999</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-info-circle text-danger me-4" aria-hidden="true"></i>Tax Expiry</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">28/02/2026</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Permit Expiry</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">19/03/2015</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>PUCC Expiry</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">19/03/2015</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>National Permit Expiry</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">19/03/2015</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Permit Type</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">National Permit (Heavy Goods Vehicle)</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>PUCC Number</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">UP02101060016371</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Permit Number</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">UP/21/112/GOOD/2017/26595</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Insurer</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">The New India Assurance Company Ltd.</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Insurance Number</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">34040131240100004570</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Financier</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">Kogta Financial (I) Ltd.</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Class</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">Goods Carrier (HGV)</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Body Type</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">Truck (Closed Body)</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Fuel Type</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">Diesel</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Chassis Number Date</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">MAT388062E5P14305</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Engine Number</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">41L84194947</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Manufacturer</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">Tata Motors Ltd.</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Model</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">LPT1613/62TCBSII</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Norms Type</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">EURO 2</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Gross Vehicle Weight</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">18500</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Unladen Weight</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">8850</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Vehicle Category</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">HGV</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Wheelbase</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">6200</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Commercial FASTag</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">Yes</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>FASTag ID</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">34161FA820328EE831791140</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>TID</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">E200341201360400001A47AA8</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>FASTag Issue Date</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">2024-04-02</td>
                                                                                                </tr>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-12">
                                                                                    <div class="table-responsive">
                                                                                        <table class="table table-hover invoice-table mb-0">
                                                                                            <tbody>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Class</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">Goods Carrier (HGV)</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Body Type</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">Truck (Closed Body)</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Fuel Type</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">Diesel</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Chassis Number Date</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">MAT388062E5P14305</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Engine Number</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">41L84194947</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Manufacturer</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">Tata Motors Ltd.</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Model</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">LPT1613/62TCBSII</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Norms Type</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">EURO 2</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Gross Vehicle Weight</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">18500</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Unladen Weight</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">8850</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Vehicle Category</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">HGV</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Wheelbase</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">6200</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Commercial FASTag</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">Yes</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>FASTag ID</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">34161FA820328EE831791140</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>TID</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">E200341201360400001A47AA8</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>FASTag Issue Date</th>
                                                                                                    <td class="pt-1 pb-1 ps-2 pe-2">2024-04-02</td>
                                                                                                </tr>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="text-end">
                                                                                <a class="d-block mb-2 mt-2" data-bs-toggle="collapse" href="#vahanDetails" role="button" aria-expanded="false" aria-controls="vahanDetails">
                                                                                Show Less <i class="uil uil-angle-up"></i>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!--/////////////////////////////////////////////////////////////////////////////////////////////-->
                                                            <div class="if-external mt-2">
                                                                <div class="card-body">
                                                                    <div class="form-group">
                                                                        <div class="row">
                                                                            <div class="col-12 col-md-6">
                                                                                <label>Vendor Name</label>
                                                                            </div>
                                                                            <div class="col-12 col-md-6 text-end">
                                                                                <a href="add-vehicle-vendor.php" style="font-size: 13px;" class="text-success"><i class="uil uil-plus-circle me-1"></i>Add Vendor</a>
                                                                            </div>
                                                                        </div>
                                                                        <select class="form-select select2">
                                                                            <option>Choose</option>
                                                                            <option>ABC Logistics | +91 9876543210</option>
                                                                            <option>XYZ Logistics | +91 9876543210</option>
                                                                            <option>MNC Logistics | +91 9876543210</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <div class="row">
                                                                            <div class="col-12 col-md-8">
                                                                                <label>Select Vehicle from Below List</label>
                                                                            </div>
                                                                            <div class="col-12 col-md-4 text-end">
                                                                                <a href="javascript:void(0)" data-bs-target="#addVeh" data-bs-toggle="modal" style="font-size: 13px;" class="text-success"><i class="uil uil-plus-circle me-1"></i>Add Vehicle</a>
                                                                            </div>
                                                                        </div>
                                                                        <select class="form-select select2">
                                                                            <option>Choose..</option>
                                                                            <option>WB-12-AB-1237</option>
                                                                            <option>WB-13-XZ-1450</option>
                                                                            <option>WB-12-LC-0090</option>
                                                                            <option>WB-13-PL-6789</option>
                                                                            <option>WB-12-AB-1237</option>
                                                                            <option>WB-13-XZ-1450</option>
                                                                            <option>WB-12-LC-0090</option>
                                                                            <option>WB-13-PL-6789</option>
                                                                            <option>WB-12-AB-1237</option>
                                                                            <option>WB-13-XZ-1450</option>
                                                                            <option>WB-12-LC-0090</option>
                                                                            <option>WB-13-PL-6789</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="vahan-det-wrap">
                                                                        <a class="d-block mb-2 mt-2" data-bs-toggle="collapse" href="#vahanDetails" role="button" aria-expanded="false" aria-controls="vahanDetails">
                                                                        Vahan Details <i class="uil uil-angle-down"></i>
                                                                        </a>
                                                                        <div class="collapse mb-4" id="vahanDetails">
                                                                            <div class="card card-body">
                                                                                <div class="row">
                                                                                    <div class="col-12">
                                                                                        <div class="table-responsive">
                                                                                            <table class="table table-hover veh-det-table invoice-table mb-0">
                                                                                                <tbody>
                                                                                                    <tr>
                                                                                                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Owner Name</th>
                                                                                                        <td class="pt-1 pb-1 ps-2 pe-2">Mohammad Hafiz</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Address</th>
                                                                                                        <td class="pt-1 pb-1 ps-2 pe-2">H.NO.62, Vill Hathipur Chittu, PS Kundarki, Teh. Bilari, Moradabad — Ph: 9588416786, 999999</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Status</th>
                                                                                                        <td class="pt-1 pb-1 ps-2 pe-2">Active</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Registration Date</th>
                                                                                                        <td class="pt-1 pb-1 ps-2 pe-2">19/03/2015</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Fitness Certificate Expiry</th>
                                                                                                        <td class="pt-1 pb-1 ps-2 pe-2">10/04/2026</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Insurance Expiry</th>
                                                                                                        <td class="pt-1 pb-1 ps-2 pe-2">H.NO.62, Vill Hathipur Chittu, PS Kundarki, Teh. Bilari, Moradabad — Ph: 9588416786, 999999</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-info-circle text-danger me-4" aria-hidden="true"></i>Tax Expiry</th>
                                                                                                        <td class="pt-1 pb-1 ps-2 pe-2">28/02/2026</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Permit Expiry</th>
                                                                                                        <td class="pt-1 pb-1 ps-2 pe-2">19/03/2015</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>PUCC Expiry</th>
                                                                                                        <td class="pt-1 pb-1 ps-2 pe-2">19/03/2015</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>National Permit Expiry</th>
                                                                                                        <td class="pt-1 pb-1 ps-2 pe-2">19/03/2015</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Permit Type</th>
                                                                                                        <td class="pt-1 pb-1 ps-2 pe-2">National Permit (Heavy Goods Vehicle)</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>PUCC Number</th>
                                                                                                        <td class="pt-1 pb-1 ps-2 pe-2">UP02101060016371</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Permit Number</th>
                                                                                                        <td class="pt-1 pb-1 ps-2 pe-2">UP/21/112/GOOD/2017/26595</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Insurer</th>
                                                                                                        <td class="pt-1 pb-1 ps-2 pe-2">The New India Assurance Company Ltd.</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Insurance Number</th>
                                                                                                        <td class="pt-1 pb-1 ps-2 pe-2">34040131240100004570</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Financier</th>
                                                                                                        <td class="pt-1 pb-1 ps-2 pe-2">Kogta Financial (I) Ltd.</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Class</th>
                                                                                                        <td class="pt-1 pb-1 ps-2 pe-2">Goods Carrier (HGV)</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Body Type</th>
                                                                                                        <td class="pt-1 pb-1 ps-2 pe-2">Truck (Closed Body)</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Fuel Type</th>
                                                                                                        <td class="pt-1 pb-1 ps-2 pe-2">Diesel</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Chassis Number Date</th>
                                                                                                        <td class="pt-1 pb-1 ps-2 pe-2">MAT388062E5P14305</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Engine Number</th>
                                                                                                        <td class="pt-1 pb-1 ps-2 pe-2">41L84194947</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Manufacturer</th>
                                                                                                        <td class="pt-1 pb-1 ps-2 pe-2">Tata Motors Ltd.</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Model</th>
                                                                                                        <td class="pt-1 pb-1 ps-2 pe-2">LPT1613/62TCBSII</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Norms Type</th>
                                                                                                        <td class="pt-1 pb-1 ps-2 pe-2">EURO 2</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Gross Vehicle Weight</th>
                                                                                                        <td class="pt-1 pb-1 ps-2 pe-2">18500</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Unladen Weight</th>
                                                                                                        <td class="pt-1 pb-1 ps-2 pe-2">8850</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Vehicle Category</th>
                                                                                                        <td class="pt-1 pb-1 ps-2 pe-2">HGV</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Wheelbase</th>
                                                                                                        <td class="pt-1 pb-1 ps-2 pe-2">6200</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Commercial FASTag</th>
                                                                                                        <td class="pt-1 pb-1 ps-2 pe-2">Yes</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>FASTag ID</th>
                                                                                                        <td class="pt-1 pb-1 ps-2 pe-2">34161FA820328EE831791140</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>TID</th>
                                                                                                        <td class="pt-1 pb-1 ps-2 pe-2">E200341201360400001A47AA8</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>FASTag Issue Date</th>
                                                                                                        <td class="pt-1 pb-1 ps-2 pe-2">2024-04-02</td>
                                                                                                    </tr>
                                                                                                </tbody>
                                                                                            </table>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-12">
                                                                                        <div class="table-responsive">
                                                                                            <table class="table table-hover invoice-table mb-0">
                                                                                                <tbody>
                                                                                                    <tr>
                                                                                                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Class</th>
                                                                                                        <td class="pt-1 pb-1 ps-2 pe-2">Goods Carrier (HGV)</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Body Type</th>
                                                                                                        <td class="pt-1 pb-1 ps-2 pe-2">Truck (Closed Body)</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Fuel Type</th>
                                                                                                        <td class="pt-1 pb-1 ps-2 pe-2">Diesel</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Chassis Number Date</th>
                                                                                                        <td class="pt-1 pb-1 ps-2 pe-2">MAT388062E5P14305</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Engine Number</th>
                                                                                                        <td class="pt-1 pb-1 ps-2 pe-2">41L84194947</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Manufacturer</th>
                                                                                                        <td class="pt-1 pb-1 ps-2 pe-2">Tata Motors Ltd.</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Model</th>
                                                                                                        <td class="pt-1 pb-1 ps-2 pe-2">LPT1613/62TCBSII</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Norms Type</th>
                                                                                                        <td class="pt-1 pb-1 ps-2 pe-2">EURO 2</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Gross Vehicle Weight</th>
                                                                                                        <td class="pt-1 pb-1 ps-2 pe-2">18500</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Unladen Weight</th>
                                                                                                        <td class="pt-1 pb-1 ps-2 pe-2">8850</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Vehicle Category</th>
                                                                                                        <td class="pt-1 pb-1 ps-2 pe-2">HGV</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Wheelbase</th>
                                                                                                        <td class="pt-1 pb-1 ps-2 pe-2">6200</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Commercial FASTag</th>
                                                                                                        <td class="pt-1 pb-1 ps-2 pe-2">Yes</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>FASTag ID</th>
                                                                                                        <td class="pt-1 pb-1 ps-2 pe-2">34161FA820328EE831791140</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>TID</th>
                                                                                                        <td class="pt-1 pb-1 ps-2 pe-2">E200341201360400001A47AA8</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>FASTag Issue Date</th>
                                                                                                        <td class="pt-1 pb-1 ps-2 pe-2">2024-04-02</td>
                                                                                                    </tr>
                                                                                                </tbody>
                                                                                            </table>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row form-group">
                                                                        <div class="col-12 col-md-6">
                                                                            <label>Expected Start Date</label>
                                                                            <input class="form-control" type="date" />
                                                                        </div>
                                                                        <div class="col-12 col-md-6">
                                                                            <label>Expected Start Time</label>
                                                                            <input class="form-control" type="time" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="row form-group">
                                                                        <div class="col-12 col-md-6">
                                                                            <label>Loading Point</label>
                                                                            <select class="form-select select2">
                                                                                <option>Choose..</option>
                                                                                <option>Webel Gate</option>
                                                                                <option>SDF</option>
                                                                                <option>DLF 1</option>
                                                                                <option>DLF 2</option>
                                                                                <option>Laketown</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-12 col-md-6">
                                                                            <label>Unloading Point</label>
                                                                            <select class="form-select select2">
                                                                                <option>Choose..</option>
                                                                                <option>Webel Gate</option>
                                                                                <option>SDF</option>
                                                                                <option>DLF 1</option>
                                                                                <option>DLF 2</option>
                                                                                <option>Laketown</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 text-end mt-3">
                                                            <button class="btn btn-primary">Save</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="v-pills-vehStatus" role="tabpanel" aria-labelledby="v-pills-vehStatus-tab">
                                    <div class="row align-items-center">
                                        <div class="col-12">
                                            <h5 class="d-inline-block mb-3">Vehicles Status</h5>
                                            <div class="row mt-3">
                                                <div class="col-12 col-md-9">
                                                    Status: <span class="badge badge-success ms-2">Reported at Loading Point</span> <span class="badge badge-success ms-2">Date & Time: 12/01/2026 | 12:00 PM</span>
                                                </div>
                                                <div class="col-12 col-md-3 text-end">
                                                    <a href="javascript:void(0)" style="font-size: 14px;" data-bs-toggle="modal" data-bs-target="#changeStatus"><i class="uil uil-pen me-1"></i>Change</a>
                                                </div>
                                            </div>
                                            <form class="row mt-3">
                                                <div class="col-12 col-md-4">
                                                    <label>Haulting</label>
                                                    <div class="input-group mb-3">
                                                        <input type="number" class="form-control" aria-describedby="basic-addon2">
                                                        <span class="input-group-text" id="basic-addon2">Day</span>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-8">
                                                    <label>Manual Entry</label>
                                                    <input type="text" class="form-control" />
                                                </div>
                                                <div class="col-12">
                                                    <iframe src="https://www.google.com/maps/embed?pb=!1m28!1m12!1m3!1d939846.3792652059!2d87.18564370509674!3d23.05038048140725!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m13!3e0!4m5!1s0x39f882db4908f667%3A0x43e330e68f6c2cbc!2sKolkata%2C%20West%20Bengal!3m2!1d22.5743545!2d88.3628734!4m5!1s0x39f7710b47a89171%3A0x429e1bdb57e009dd!2sDurgapur%2C%20West%20Bengal!3m2!1d23.520444299999998!2d87.3119227!5e0!3m2!1sen!2sin!4v1763121789776!5m2!1sen!2sin" width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                                </div>
                                            </form>
                                        </div>
                                        <hr>
                                        <div class="col-12">
                                            <div class="row mt-3">
                                                <div class="col-12 col-md-9">
                                                    Status: <span class="badge badge-success ms-2">On the Way</span> <span class="badge badge-success ms-2">Date & Time: 12/01/2026 | 12:00 PM</span>
                                                </div>
                                            </div>
                                            <form class="row mt-3">
                                                <div class="col-12 col-md-4">
                                                    <label>Haulting</label>
                                                    <div class="input-group mb-3">
                                                        <input type="number" class="form-control" aria-describedby="basic-addon2">
                                                        <span class="input-group-text" id="basic-addon2">Day</span>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-8">
                                                    <label>Manual Entry</label>
                                                    <input type="text" class="form-control" />
                                                </div>
                                                <div class="col-12">
                                                    <iframe src="https://www.google.com/maps/embed?pb=!1m28!1m12!1m3!1d939846.3792652059!2d87.18564370509674!3d23.05038048140725!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m13!3e0!4m5!1s0x39f882db4908f667%3A0x43e330e68f6c2cbc!2sKolkata%2C%20West%20Bengal!3m2!1d22.5743545!2d88.3628734!4m5!1s0x39f7710b47a89171%3A0x429e1bdb57e009dd!2sDurgapur%2C%20West%20Bengal!3m2!1d23.520444299999998!2d87.3119227!5e0!3m2!1sen!2sin!4v1763121789776!5m2!1sen!2sin" width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                                </div>
                                            </form>
                                        </div>
                                        <hr>
                                        <div class="col-12">
                                            <div class="row mt-3">
                                                <div class="col-12">
                                                    Status: <span class="badge badge-success ms-2">Reported at Unloading Point</span> <span class="badge badge-success ms-2">Date & Time: 12/01/2026 | 12:00 PM</span>
                                                </div>
                                            </div>
                                            <form class="row mt-3">
                                                <div class="col-12 col-md-4">
                                                    <label>Haulting</label>
                                                    <div class="input-group mb-3">
                                                        <input type="number" class="form-control" aria-describedby="basic-addon2">
                                                        <span class="input-group-text" id="basic-addon2">Day</span>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-8">
                                                    <label>Manual Entry</label>
                                                    <input type="text" class="form-control" />
                                                </div>
                                                <div class="col-12">
                                                    <iframe src="https://www.google.com/maps/embed?pb=!1m28!1m12!1m3!1d939846.3792652059!2d87.18564370509674!3d23.05038048140725!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m13!3e0!4m5!1s0x39f882db4908f667%3A0x43e330e68f6c2cbc!2sKolkata%2C%20West%20Bengal!3m2!1d22.5743545!2d88.3628734!4m5!1s0x39f7710b47a89171%3A0x429e1bdb57e009dd!2sDurgapur%2C%20West%20Bengal!3m2!1d23.520444299999998!2d87.3119227!5e0!3m2!1sen!2sin!4v1763121789776!5m2!1sen!2sin" width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                                </div>
                                            </form>
                                        </div>
                                        <hr>
                                        <div class="col-12">
                                            <div class="row mt-3">
                                                <div class="col-12 col-md-9">
                                                    Status: <span class="badge badge-success ms-2">Empty</span> <span class="badge badge-success ms-2">Date & Time: 12/01/2026 | 12:00 PM</span>
                                                </div>
                                            </div>
                                            <form class="row mt-3">
                                                <div class="col-12 col-md-4">
                                                    <label>Haulting</label>
                                                    <div class="input-group mb-3">
                                                        <input type="number" class="form-control" aria-describedby="basic-addon2">
                                                        <span class="input-group-text" id="basic-addon2">Day</span>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-8">
                                                    <label>Manual Entry</label>
                                                    <input type="text" class="form-control" />
                                                </div>
                                                <div class="col-12">
                                                    <iframe src="https://www.google.com/maps/embed?pb=!1m28!1m12!1m3!1d939846.3792652059!2d87.18564370509674!3d23.05038048140725!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m13!3e0!4m5!1s0x39f882db4908f667%3A0x43e330e68f6c2cbc!2sKolkata%2C%20West%20Bengal!3m2!1d22.5743545!2d88.3628734!4m5!1s0x39f7710b47a89171%3A0x429e1bdb57e009dd!2sDurgapur%2C%20West%20Bengal!3m2!1d23.520444299999998!2d87.3119227!5e0!3m2!1sen!2sin!4v1763121789776!5m2!1sen!2sin" width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="v-pills-ewayLr" role="tabpanel" aria-labelledby="v-pills-ewayLr-tab">
                                    <div class="row">
                                        <div class="col-12">
                                            <h5 class="d-inline-block mb-0">Eway + LR</h5>
                                            <div class="row mt-3 mb-2">
                                                <div class="col-12 col-md-6">
                                                    <h6>Eway</h6>
                                                </div>
                                                <div class="col-12 col-md-6 text-end">
                                                    <a href="javascript:void(0)" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEwayTable"><i class="uil uil-plus me-1"></i>Add Eway</a>   
                                                </div>
                                            </div>
                                            <div class="vehiclestable">
                                                <div>
                                                    <div class="vehicle-card color-left01 d-block">
                                                        <div class="dropdown dot-dd">
                                                            <span class="dropdown-toggle" id="moreTable" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="uil uil-ellipsis-v"></i>
                                                            </span>
                                                            <ul class="dropdown-menu" aria-labelledby="moreTable" style="">
                                                                <li><a class="dropdown-item" href="{{ route('trip.lr.print') }}" target="_blank"><i class="uil uil-eye me-1"></i>View Details & Print</a></li>
                                                            </ul>
                                                        </div>
                                                        <div class="row info-grid mb-3">
                                                            <div class="col-12 col-md-3 info-item">
                                                                <div class="label">Invoice Number</div>
                                                                <div class="value">#INV001</div>
                                                            </div>
                                                            <div class="col-12 col-md-3 info-item">
                                                                <div class="label">Invoice Date</div>
                                                                <div class="value">02/11/2025</div>
                                                            </div>
                                                            <div class="col-12 col-md-3 info-item">
                                                                <div class="label">LR Number</div>
                                                                <div class="value">#LR001</div>
                                                            </div>
                                                            <div class="col-12 col-md-3 info-item">
                                                                <div class="label">LR Date</div>
                                                                <div class="value">10/11/2025</div>
                                                            </div>
                                                        </div>
                                                        <div class="row info-grid">
                                                            <div class="col-12 col-md-3 info-item">
                                                                <div class="label">Quantity</div>
                                                                <div class="value">40</div>
                                                            </div>
                                                            <div class="col-12 col-md-3 info-item">
                                                                <div class="label">Value (With Tax)</div>
                                                                <div class="value">1000</div>
                                                            </div>
                                                            <div class="col-12 col-md-3 info-item">
                                                                <div class="label">Gross Weight</div>
                                                                <div class="value">10KG</div>
                                                            </div>
                                                            <div class="col-12 col-md-3 info-item">
                                                                <div class="label">Charged Weight</div>
                                                                <div class="value">4KG</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="vehicle-card color-left02 d-block">
                                                        <div class="dropdown dot-dd">
                                                            <span class="dropdown-toggle" id="moreTable" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="uil uil-ellipsis-v"></i>
                                                            </span>
                                                            <ul class="dropdown-menu" aria-labelledby="moreTable" style="">
                                                                <li><a class="dropdown-item" href="{{ route('trip.lr.print') }}" target="_blank"><i class="uil uil-eye me-1"></i>View Details & Print</a></li>
                                                            </ul>
                                                        </div>
                                                        <div class="row info-grid mb-3">
                                                            <div class="col-12 col-md-3 info-item">
                                                                <div class="label">Invoice Number</div>
                                                                <div class="value">#INV001</div>
                                                            </div>
                                                            <div class="col-12 col-md-3 info-item">
                                                                <div class="label">Invoice Date</div>
                                                                <div class="value">02/11/2025</div>
                                                            </div>
                                                            <div class="col-12 col-md-3 info-item">
                                                                <div class="label">LR Number</div>
                                                                <div class="value">#LR001</div>
                                                            </div>
                                                            <div class="col-12 col-md-3 info-item">
                                                                <div class="label">LR Date</div>
                                                                <div class="value">10/11/2025</div>
                                                            </div>
                                                        </div>
                                                        <div class="row info-grid">
                                                            <div class="col-12 col-md-3 info-item">
                                                                <div class="label">Quantity</div>
                                                                <div class="value">40</div>
                                                            </div>
                                                            <div class="col-12 col-md-3 info-item">
                                                                <div class="label">Value (With Tax)</div>
                                                                <div class="value">1000</div>
                                                            </div>
                                                            <div class="col-12 col-md-3 info-item">
                                                                <div class="label">Gross Weight</div>
                                                                <div class="value">10KG</div>
                                                            </div>
                                                            <div class="col-12 col-md-3 info-item">
                                                                <div class="label">Charged Weight</div>
                                                                <div class="value">4KG</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-3 mb-2">
                                                <div class="col-12 col-md-6">
                                                    <h6>LR</h6>
                                                </div>
                                                <div class="col-12 col-md-6 text-end">
                                                    <a href="{{ route('trip.lr.create') }}" class="btn btn-primary"><i class="uil uil-plus me-1"></i>Add LR</a>   
                                                </div>
                                            </div>
                                            <div class="vehiclestable">
                                                <div>
                                                    <div class="vehicle-card color-left01 d-block">
                                                        <div class="dropdown dot-dd">
                                                            <span class="dropdown-toggle" id="moreTable" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="uil uil-ellipsis-v"></i>
                                                            </span>
                                                            <ul class="dropdown-menu" aria-labelledby="moreTable" style="">
                                                                <li><a class="dropdown-item" href="{{ route('trip.lr.print') }}" target="_blank"><i class="uil uil-eye me-1"></i>View Details & Print</a></li>
                                                            </ul>
                                                        </div>
                                                        <div class="row info-grid mb-3">
                                                            <div class="col-12 col-md-4 info-item">
                                                                <div class="label">LR Number</div>
                                                                <div class="value">#LR001</div>
                                                            </div>
                                                            <div class="col-12 col-md-4 info-item">
                                                                <div class="label">LR Party Number</div>
                                                                <div class="value">#LR001</div>
                                                            </div>
                                                            <div class="col-12 col-md-4 info-item">
                                                                <div class="label">LR Date</div>
                                                                <div class="value">10/11/2025</div>
                                                            </div>
                                                        </div>
                                                        <div class="row info-grid mb-3">
                                                            <div class="col-12 col-md-4 info-item">
                                                                <div class="label">Gross Weight</div>
                                                                <div class="value">10KG</div>
                                                            </div>
                                                            <div class="col-12 col-md-4 info-item">
                                                                <div class="label">Seal Number</div>
                                                                <div class="value">1234</div>
                                                            </div>
                                                            <div class="col-12 col-md-4 info-item">
                                                                <div class="label">Transport Mode</div>
                                                                <div class="value">Road</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="v-pills-pod" role="tabpanel" aria-labelledby="v-pills-pod-tab">
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <h5 class="d-inline-block mb-3">LR-POD</h5>
                                        </div>
                                        <div class="col-12 col-md-6 text-end">
                                            <a href="javascript:void(0)" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPOD"><i class="uil uil-plus me-1"></i>Add POD</a> 
                                        </div>
                                        <div class="col-12 mt-3">
                                            <!--<div class="vehiclestable">-->
                                            <!--    <div>-->
                                            <!--        <div class="vehicle-card color-left01">-->
                                            <!--            <div class="info-grid">-->
                                            <!--              <div class="info-item">-->
                                            <!--                <div class="label">Material Description</div>-->
                                            <!--                <div class="value">Hydrabad - Kolkata</div>-->
                                            <!--              </div> -->
                                            <!--              <div class="info-item">-->
                                            <!--                <div class="label">Invoice Number & Date</div>-->
                                            <!--                <div class="value">#INV001 | 02/11/2025</div>-->
                                            <!--              </div> -->
                                            <!--              <div class="info-item">-->
                                            <!--                <div class="label">LR Number & Date</div>-->
                                            <!--                <div class="value">#LR001 | 20/10/2025</div>-->
                                            <!--              </div>-->
                                            <!--               <div class="info-item">-->
                                            <!--                  <div class="label">Net Quantity</div>-->
                                            <!--                <div class="value">40</div>-->
                                            <!--              </div> -->
                                            <!--              <div class="info-item">-->
                                            <!--                  <div class="label">Value (with tax)</div>-->
                                            <!--                <div class="value">100</div>-->
                                            <!--              </div>-->
                                            <!--              <div class="info-item">-->
                                            <!--                  <div class="label">Gross Weight</div>-->
                                            <!--                <div class="value">10Kg</div>-->
                                            <!--              </div>-->
                                            <!--              <div class="info-item">-->
                                            <!--                  <div class="label">Charged Weight</div>-->
                                            <!--                <div class="value">4KG</div>-->
                                            <!--              </div>-->
                                            <!--            </div>-->
                                            <!--        </div>-->
                                            <!--    </div>-->
                                            <!--</div>-->
                                            <!--<div class="row right-det-wrap">-->
                                            <!--    <div class="col-12 col-md-3">-->
                                            <!--        <p class="label-text mb-0">Material Description</p>-->
                                            <!--        <p>Hydrabad - Kolkata</p>-->
                                            <!--    </div>-->
                                            <!--    <div class="col-12 col-md-3">-->
                                            <!--        <p class="label-text mb-0">Invoice Number & Date</p>-->
                                            <!--        <p>#INV001 | 02/11/2025</p>-->
                                            <!--    </div>-->
                                            <!--    <div class="col-12 col-md-3">-->
                                            <!--        <p class="label-text mb-0">LR Number & Date</p>-->
                                            <!--        <p>#LR001 | 20/10/2025</p>-->
                                            <!--    </div>-->
                                            <!--    <div class="col-12 col-md-3">-->
                                            <!--        <p class="label-text mb-0">Net Quantity</p>-->
                                            <!--        <p>40</p>-->
                                            <!--    </div>-->
                                            <!--    <div class="col-12 col-md-3">-->
                                            <!--        <p class="label-text mb-0">Value (with tax)</p>-->
                                            <!--        <p>1000</p>-->
                                            <!--    </div>-->
                                            <!--    <div class="col-12 col-md-3">-->
                                            <!--        <p class="label-text mb-0">Gross Weight</p>-->
                                            <!--        <p>10KG</p>-->
                                            <!--    </div>-->
                                            <!--    <div class="col-12 col-md-3">-->
                                            <!--        <p class="label-text mb-0">Charged Weight</p>-->
                                            <!--        <p>20KG.</p>-->
                                            <!--    </div>-->
                                            <!--</div>-->
                                            <div class="row right-det-wrap">
                                                <div class="col-12 col-md-3">
                                                    <p class="label-text mb-0">Vehicle Number</p>
                                                    <p>MH12AB1234</p>
                                                </div>
                                                <div class="col-12 col-md-3">
                                                    <p class="label-text mb-0">LR Number & Date</p>
                                                    <p>LR-4589 | 10/12/2025</p>
                                                </div>
                                                <div class="col-12 col-md-3">
                                                    <p class="label-text mb-0">Invoice Number & Date</p>
                                                    <p>INV-1025 | 10/12/2025</p>
                                                </div>
                                                <!--<div class="col-12 col-md-3">-->
                                                <!--    <p class="label-text mb-0">Billing Customer</p>-->
                                                <!--    <p>Traders Pvt Ltd</p>-->
                                                <!--</div>-->
                                                <div class="col-12 col-md-3">
                                                    <p class="label-text mb-0">Source</p>
                                                    <p>Mumbai</p>
                                                </div>
                                                <div class="col-12 col-md-3">
                                                    <p class="label-text mb-0">Destination</p>
                                                    <p>Hyderabad</p>
                                                </div>
                                                <div class="col-12 col-md-3">
                                                    <p class="label-text mb-0">Product Type</p>
                                                    <p>Steel Rods</p>
                                                </div>
                                                <div class="col-12 col-md-3">
                                                    <p class="label-text mb-0">Quantity</p>
                                                    <p>2000KG</p>
                                                </div>
                                                <!--<div class="col-12 col-md-3">-->
                                                <!--    <p class="label-text mb-0">Consignor</p>-->
                                                <!--    <p>Arun Singh</p>-->
                                                <!--</div>-->
                                                <!--<div class="col-12 col-md-3">-->
                                                <!--    <p class="label-text mb-0">Consignee</p>-->
                                                <!--    <p>Trishul Traders</p>-->
                                                <!--</div>-->
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-12 col-md-6">
                                                    <p class="text-dark mb-1">Consigner Name &amp; Address </p>
                                                    <p class="mb-1 text-dark" style="font-size: 14px;">Britania Kolkata</p>
                                                    <p class="mb-0 text-secondary" style="font-size: 13px;">13946 Desiree Burgs Suite 113</p>
                                                    <p class="mb-0 text-secondary" style="font-size: 13px;">Port Clintonborough</p>
                                                    <p class="mb-0 text-secondary" style="font-size: 13px;">Georgia 974-395</p>
                                                    <p class="mb-0 text-secondary" style="font-size: 13px;">Phone: (006)-336-077</p>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <p class="text-dark mb-1">Consignee Name &amp; Address </p>
                                                    <p class="mb-1 text-dark" style="font-size: 14px;">Samsung Hydrabad</p>
                                                    <p class="mb-0 text-secondary" style="font-size: 13px;">13946 Desiree Burgs Suite 113</p>
                                                    <p class="mb-0 text-secondary" style="font-size: 13px;">Port Clintonborough</p>
                                                    <p class="mb-0 text-secondary" style="font-size: 13px;">Georgia 974-395</p>
                                                    <p class="mb-0 text-secondary" style="font-size: 13px;">Phone: (006)-336-077</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="v-pills-summary" role="tabpanel" aria-labelledby="v-pills-summary-tab">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="row mt-2">
                                                <div class="co-12 col-md-6">
                                                    <h5 class="d-inline-block mb-0">Billing Summary</h5>
                                                </div>
                                                <div class="co-12 col-md-6 text-end">
                                                    <a href="javascript:void(0)" class="btn btn-primary bill-click">Bill Entry</a>
                                                    <a href="bill-finalise.php" target="_blank" class="btn btn-secondary">Finalise Bill</a>
                                                </div>
                                            </div>
                                            <ul class="list-group mt-3">
                                                <li class="list-group-item">
                                                    <div class="d-flex justify-content-between">
                                                        <p class="mb-0">Total Addition</p>
                                                        <p class="mb-0"><strong>5000.00</strong></p>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="d-flex justify-content-between">
                                                        <p class="mb-0">Total Deduction</p>
                                                        <p class="mb-0"><strong>10000.00</strong></p>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="d-flex justify-content-between">
                                                        <p class="mb-0">Net Payable</p>
                                                        <p class="mb-0"><strong>15000.00</strong></p>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="d-flex justify-content-between">
                                                        <p class="mb-0">Net Amount Paid</p>
                                                        <p class="mb-0"><strong>3000.00</strong></p>
                                                    </div>
                                                </li>
                                                <li class="list-group-item bg-light">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <p class="mb-0">
                                                            <span class="d-block">Due Balance</span>
                                                        </p>
                                                        <p class="mb-0"><strong>9000.00</strong></p>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-12 col-md-6">
                                                    <h6>Addition</h6>
                                                </div>
                                                <div class="col-12 col-md-6 text-end">
                                                    <button type="submit" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#addAddition"><i class="uil uil-plus me-1"></i>Add Addition</button>
                                                </div>
                                            </div>
                                            <div class="table-responsive mt-4">
                                                <table class="table table-hover invoice-table mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th>Addition Head</th>
                                                            <th>Amount</th>
                                                            <th>Recorded By</th>
                                                            <th>Date</th>
                                                            <th>Notes</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                Fixed Fee
                                                            </td>
                                                            <td>7000</td>
                                                            <td>Vinay Goyel</td>
                                                            <td>
                                                                12/11/2025
                                                            </td>
                                                            <td>Lorem ipsum doller sit amet.</td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                Loading/Unloading Charge
                                                            </td>
                                                            <td>1000</td>
                                                            <td>Abhishek Nayak</td>
                                                            <td>
                                                                13/11/2025
                                                            </td>
                                                            <td>Lorem ipsum doller sit amet.</td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                Extra KM
                                                            </td>
                                                            <td>400</td>
                                                            <td>Nandan Biswas</td>
                                                            <td>
                                                                14/11/2025
                                                            </td>
                                                            <td>Lorem ipsum doller sit amet.</td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                Tax
                                                            </td>
                                                            <td>200</td>
                                                            <td>Nilay Ray</td>
                                                            <td>
                                                                15/11/2025
                                                            </td>
                                                            <td>Lorem ipsum doller sit amet.</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row mt-4">
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-12 col-md-6">
                                                    <h6>Deduction</h6>
                                                </div>
                                                <div class="col-12 col-md-6 text-end">
                                                    <button type="submit" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#addDeduction"><i class="uil uil-plus me-1"></i>Add Deduction</button>
                                                </div>
                                            </div>
                                            <div class="table-responsive mt-4">
                                                <table class="table table-hover invoice-table mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th>Deduction Head</th>
                                                            <th>Amount</th>
                                                            <th>Recorded By</th>
                                                            <th>Date</th>
                                                            <th>Notes</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                TDS
                                                            </td>
                                                            <td>7000</td>
                                                            <td>Vinay Goyel</td>
                                                            <td>
                                                                12/11/2025
                                                            </td>
                                                            <td>Lorem ipsum doller sit amet.</td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                Mamul
                                                            </td>
                                                            <td>3000</td>
                                                            <td>Vinay Goyel</td>
                                                            <td>
                                                                12/11/2025
                                                            </td>
                                                            <td>Lorem ipsum doller sit amet.</td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                P/R
                                                            </td>
                                                            <td>700</td>
                                                            <td>Vinay Goyel</td>
                                                            <td>
                                                                12/11/2025
                                                            </td>
                                                            <td>Lorem ipsum doller sit amet.</td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                Prev. Adjustments
                                                            </td>
                                                            <td>1000</td>
                                                            <td>Vinay Goyel</td>
                                                            <td>
                                                                12/11/2025
                                                            </td>
                                                            <td>Lorem ipsum doller sit amet.</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row mt-4">
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-12 col-md-6">
                                                    <h6>Transaction</h6>
                                                </div>
                                                <div class="col-12 col-md-6 text-end">
                                                    <button type="submit" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#addTransaction"><i class="uil uil-plus me-1"></i>Add Transaction</button>
                                                </div>
                                            </div>
                                            <div class="table-responsive mt-4">
                                                <table class="table table-hover invoice-table mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th>Date</th>
                                                            <th>Type</th>
                                                            <th>Mode of Payment</th>
                                                            <th>Amount</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                12/11/2025
                                                            </td>
                                                            <td>Advance</td>
                                                            <td>Cash</td>
                                                            <td>
                                                                1200
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                13/11/2025
                                                            </td>
                                                            <td>Advance</td>
                                                            <td>Cash</td>
                                                            <td>
                                                                1000
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                14/11/2025
                                                            </td>
                                                            <td>Advance</td>
                                                            <td>Cash</td>
                                                            <td>
                                                                1100
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                15/11/2025
                                                            </td>
                                                            <td>Advance</td>
                                                            <td>Cash</td>
                                                            <td>
                                                                1000
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="v-pills-transaction" role="tabpanel" aria-labelledby="v-pills-transaction-tab">
                                    <div class="row">
                                        <div class="col-12">
                                            <h5 class="d-inline-block mb-3">Expenses</h5>
                                            <!--<div class="mt-2">-->
                                            <!--    <div class="dropdown d-inline-block">-->
                                            <!--      <button class="btn btn-secondary dropdown-toggle" type="button" id="creditEntry" data-bs-toggle="dropdown" aria-expanded="false">-->
                                            <!--        Credit Entry (+)-->
                                            <!--      </button>-->
                                            <!--      <ul class="dropdown-menu" aria-labelledby="creditEntry">-->
                                            <!--        <li><a class="dropdown-item" href="javascript:void(0)">Unloading Detention</a></li>-->
                                            <!--        <li><a class="dropdown-item" href="javascript:void(0)">Unloading Charges</a></li>-->
                                            <!--        <li><a class="dropdown-item" href="javascript:void(0)">Other</a></li>-->
                                            <!--      </ul>-->
                                            <!--    </div>-->
                                            <!--    <div class="dropdown d-inline-block">-->
                                            <!--      <button class="btn btn-secondary dropdown-toggle" type="button" id="creditEntry" data-bs-toggle="dropdown" aria-expanded="false">-->
                                            <!--        Debit Entry (-)-->
                                            <!--      </button>-->
                                            <!--      <ul class="dropdown-menu" aria-labelledby="creditEntry">-->
                                            <!--        <li><a class="dropdown-item" href="javascript:void(0)">Late Delivery Fine</a></li>-->
                                            <!--        <li><a class="dropdown-item" href="javascript:void(0)">Deduction from Shortages / Damages</a></li>-->
                                            <!--        <li><a class="dropdown-item" href="javascript:void(0)">Payment Cut</a></li>-->
                                            <!--        <li><a class="dropdown-item" href="javascript:void(0)">Claim</a></li>-->
                                            <!--      </ul>-->
                                            <!--    </div>-->
                                            <!--    <div class="dropdown d-inline-block">-->
                                            <!--      <button class="btn btn-secondary dropdown-toggle" type="button" id="creditEntry" data-bs-toggle="dropdown" aria-expanded="false">-->
                                            <!--        Payment Request-->
                                            <!--      </button>-->
                                            <!--      <ul class="dropdown-menu" aria-labelledby="creditEntry">-->
                                            <!--        <li><a class="dropdown-item" href="javascript:void(0)">Advance Payment</a></li>-->
                                            <!--        <li><a class="dropdown-item" href="javascript:void(0)">Balance Payment</a></li>-->
                                            <!--      </ul>-->
                                            <!--    </div>-->
                                            <!--</div>-->
                                            <div class="mt-2">
                                                <button type="submit" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#addExpense"><i class="uil uil-plus me-1"></i>Add Expense</button>
                                            </div>
                                            <ul class="list-group mt-3">
                                                <li class="list-group-item">
                                                    <div class="d-flex justify-content-between">
                                                        <p class="mb-0">Fuel</p>
                                                        <p class="mb-0"><strong>₹ 15,000.00</strong></p>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="d-flex justify-content-between">
                                                        <p class="mb-0">Toll Charges</p>
                                                        <p class="mb-0"><strong>₹ 10,000.00</strong></p>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="d-flex justify-content-between">
                                                        <p class="mb-0">Driver Advance</p>
                                                        <p class="mb-0"><strong>₹ 50,000.00</strong></p>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="d-flex justify-content-between">
                                                        <p class="mb-0">Maintenance</p>
                                                        <p class="mb-0"><strong>₹ 3,000.00</strong></p>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="d-flex justify-content-between">
                                                        <p class="mb-0">Fooding</p>
                                                        <p class="mb-0"><strong>₹ 5,000.00</strong></p>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="d-flex justify-content-between">
                                                        <p class="mb-0">Misc. Exp</p>
                                                        <p class="mb-0"><strong>₹ 2,000.00</strong></p>
                                                    </div>
                                                </li>
                                                <li class="list-group-item bg-light">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <p class="mb-0">
                                                            <span class="d-block">Total</span>
                                                        </p>
                                                        <p class="mb-0"><strong>₹ 90,000.00</strong></p>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="table-responsive mt-4">
                                                <table class="table table-hover invoice-table mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th>Expense Head</th>
                                                            <th>Date & Time</th>
                                                            <th>Recorded By</th>
                                                            <th>Description</th>
                                                            <th>Type</th>
                                                            <th>Amount</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                Driver Advance
                                                            </td>
                                                            <td>12/11/2025 | 12:00 PM</td>
                                                            <td>Litesh Singh</td>
                                                            <td>
                                                                Lorem ipsum doller sit amet.
                                                            </td>
                                                            <td>Debit</td>
                                                            <td>10,000.00</td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                Toll Charges
                                                            </td>
                                                            <td>12/11/2025 | 12:00 PM</td>
                                                            <td>Litesh Singh</td>
                                                            <td>
                                                                Lorem ipsum doller sit amet.
                                                            </td>
                                                            <td>Debit</td>
                                                            <td>10,000.00</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="v-pills-driver_payout" role="tabpanel" aria-labelledby="v-pills-driver_payout-tab">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="row mt-2">
                                                <div class="co-12 col-md-6">
                                                    <h5 class="d-inline-block mb-0">Trip Payout</h5>
                                                </div>
                                            </div>
                                            <div class="mt-2">
                                                <h6 class="d-inline-block tag">Trip ID: #TRIP001 | Vehicle: XY-55-TY6788 | Driver: Ramesh Singh</h6>
                                                <h6 class="mt-3"><strong>Fuel</strong></h6>
                                                <div class="table-responsive mt-3">
                                                    <table class="table table-hover invoice-table mb-0">
                                                        <tbody>
                                                            <tr>
                                                                <th class="pt-1 pb-1 ps-2 pe-2">Fixed Fuel</th>
                                                                <td class="pt-1 pb-1 ps-2 pe-2" style="width: 250px;">200 L</td>
                                                            </tr>
                                                            <tr>
                                                                <th class="pt-1 pb-1 ps-2 pe-2">Issued Fuel</th>
                                                                <td class="pt-1 pb-1 ps-2 pe-2" style="width: 250px;">150 L</td>
                                                            </tr>
                                                            <tr>
                                                                <th class="pt-1 pb-1 ps-2 pe-2">Pending Fuel</th>
                                                                <td class="pt-1 pb-1 ps-2 pe-2" style="width: 250px;">50 L</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <h6 class="mt-3"><strong>Advance</strong></h6>
                                                <div class="table-responsive mt-3">
                                                    <table class="table table-hover invoice-table mb-0">
                                                        <tbody>
                                                            <tr>
                                                                <th class="pt-1 pb-1 ps-2 pe-2">Fixed Advance</th>
                                                                <td class="pt-1 pb-1 ps-2 pe-2" style="width: 250px;">₹ 10,000</td>
                                                            </tr>
                                                            <tr>
                                                                <th class="pt-1 pb-1 ps-2 pe-2">Issued Advance</th>
                                                                <td class="pt-1 pb-1 ps-2 pe-2" style="width: 250px;">₹ 6000</td>
                                                            </tr>
                                                            <tr>
                                                                <th class="pt-1 pb-1 ps-2 pe-2">Pending Advance</th>
                                                                <td class="pt-1 pb-1 ps-2 pe-2" style="width: 250px;">₹ 4000</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <h6 class="mt-3"><strong>Margin</strong></h6>
                                                <div class="table-responsive mt-3">
                                                    <table class="table table-hover invoice-table mb-0">
                                                        <tbody>
                                                            <tr>
                                                                <th class="pt-1 pb-1 ps-2 pe-2">Fuel Rate</th>
                                                                <td class="pt-1 pb-1 ps-2 pe-2" style="width: 250px;">90/L</td>
                                                            </tr>
                                                            <tr>
                                                                <th class="pt-1 pb-1 ps-2 pe-2">Fuel Margin</th>
                                                                <td class="pt-1 pb-1 ps-2 pe-2" style="width: 250px;">70 L * 90/L = ₹ 6300</td>
                                                            </tr>
                                                            <tr>
                                                                <th class="pt-1 pb-1 ps-2 pe-2">Advance Margin</th>
                                                                <td class="pt-1 pb-1 ps-2 pe-2" style="width: 250px;">₹ 4000</td>
                                                            </tr>
                                                            <tr>
                                                                <th class="pt-1 pb-1 ps-2 pe-2"><strong>Total</strong></th>
                                                                <td class="pt-1 pb-1 ps-2 pe-2" style="width: 250px;"><strong>₹ 10,300</strong></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <!--<div class="mt-4">-->
                                            <!--    <h6 class="d-inline-block tag">Vehicle - WB-58-FC6770 | Ashoke Dubey</h6>-->
                                            <!--    <div class="table-responsive mt-3">-->
                                            <!--        <table class="table table-hover invoice-table mb-0">-->
                                            <!--            <tbody>-->
                                            <!--                <tr>-->
                                            <!--                    <th class="pt-1 pb-1 ps-2 pe-2">Route Fixed Cost</th>-->
                                            <!--                    <td class="pt-1 pb-1 ps-2 pe-2" style="width: 250px;">₹ 11000</td>-->
                                            <!--                </tr>-->
                                            <!--                <tr>-->
                                            <!--                    <th class="pt-1 pb-1 ps-2 pe-2">Advanced Paid</th>-->
                                            <!--                    <td class="pt-1 pb-1 ps-2 pe-2" style="width: 250px;">₹ 5000</td>-->
                                            <!--                </tr>-->
                                            <!--                <tr>-->
                                            <!--                    <th class="pt-1 pb-1 ps-2 pe-2">Estimated Fuel</th>-->
                                            <!--                    <td class="pt-1 pb-1 ps-2 pe-2" style="width: 250px;">500L</td>-->
                                            <!--                </tr>-->
                                            <!--                <tr>-->
                                            <!--                    <th class="pt-1 pb-1 ps-2 pe-2">Actual Fuel</th>-->
                                            <!--                    <td class="pt-1 pb-1 ps-2 pe-2" style="width: 250px;">400L</td>-->
                                            <!--                </tr>-->
                                            <!--                <tr>-->
                                            <!--                    <th class="pt-1 pb-1 ps-2 pe-2">Fuel Rate</th>-->
                                            <!--                    <td class="pt-1 pb-1 ps-2 pe-2" style="width: 250px;">₹ 90/L</td>-->
                                            <!--                </tr>-->
                                            <!--                <tr>-->
                                            <!--                    <th class="pt-1 pb-1 ps-2 pe-2">Actual Trip Payout</th>-->
                                            <!--                    <td class="pt-1 pb-1 ps-2 pe-2" style="width: 250px;">₹ 20000</td>-->
                                            <!--                </tr>-->
                                            <!--                <tr>-->
                                            <!--                    <th class="pt-1 pb-1 ps-2 pe-2">Balance</th>-->
                                            <!--                    <td class="pt-1 pb-1 ps-2 pe-2" style="width: 250px;">₹ 15000</td>-->
                                            <!--                </tr>-->
                                            <!--                <tr>-->
                                            <!--                    <th class="pt-1 pb-1 ps-2 pe-2">Remarks</th>-->
                                            <!--                    <td class="pt-1 pb-1 ps-2 pe-2" style="width: 250px;">Efficient Trip</td>-->
                                            <!--                </tr>-->
                                            <!--            </tbody>-->
                                            <!--        </table>-->
                                            <!--    </div>-->
                                            <!--</div>-->
                                            <div class="row mt-4">
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-12 col-md-6">
                                                            <h6>Driver Expense</h6>
                                                        </div>
                                                        <div class="col-12 col-md-6 text-end">
                                                            <button type="submit" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#driverExpense"><i class="uil uil-plus me-1"></i>Add Expense</button>
                                                        </div>
                                                    </div>
                                                    <div class="table-responsive mt-4">
                                                        <table class="table table-hover invoice-table mb-0">
                                                            <thead>
                                                                <tr>
                                                                    <th>Expense Head</th>
                                                                    <th>Expense Type</th>
                                                                    <th>Debit Amount</th>
                                                                    <th>Credit Amount</th>
                                                                    <th>Notes</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>
                                                                        Vehicle Challan
                                                                    </td>
                                                                    <td>Credit</td>
                                                                    <td><span class="text-danger">--</span></td>
                                                                    <td>
                                                                        <span class="text-success">+ ₹200</span>
                                                                    </td>
                                                                    <td>Lorem ipsum doller sit amet.</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        Material Shortage
                                                                    </td>
                                                                    <td>Debit</td>
                                                                    <td><span class="text-danger">- ₹100</span></td>
                                                                    <td>
                                                                        <span class="text-success">--</span>
                                                                    </td>
                                                                    <td>Lorem ipsum doller sit amet.</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="v-pills-memo" role="tabpanel" aria-labelledby="v-pills-memo-tab">
                                    <div class="row align-items-center">
                                        <div class="col-12">
                                            <h5 class="d-inline-block mb-3">Memo</h5>
                                        </div>
                                        <form>
                                            <div class="card-body">
                                                <div class="row form-group">
                                                    <div class="col-12 col-md-6">
                                                        <label>Memo Number</label>
                                                        <input type="text" class="form-control bg-light" value="Memo00120" readonly />
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <label>Load Vendor Name</label>
                                                        <input type="text" class="form-control bg-light" value="Samsung" readonly />
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-12 col-md-6">
                                                        <label>Date</label>
                                                        <input type="date" class="form-control" />
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <label>Vehicle Number</label>
                                                        <input type="text" class="form-control bg-light" value="WB-12-VH-1234" readonly />
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-12 col-md-6">
                                                        <label>Source</label>
                                                        <select class="form-select">
                                                            <option>Choose</option>
                                                            <option>Kolkata</option>
                                                            <option>Chennai</option>
                                                            <option>Delhi</option>
                                                            <option>Mumbai</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <label>Destination</label>
                                                        <select class="form-select">
                                                            <option>Choose</option>
                                                            <option>Kolkata</option>
                                                            <option>Chennai</option>
                                                            <option>Delhi</option>
                                                            <option>Mumbai</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-12 col-md-6">
                                                        <label>Weight</label>
                                                        <input type="text" class="form-control bg-light" value="7mt/9mt" readonly />
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <label>Freight</label>
                                                        <!--<input type="text" class="form-control" />-->
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text" id="driver">₹</span>
                                                            <input type="text" class="form-control" aria-describedby="driver">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-12 col-md-6">
                                                        <label>Advance</label>
                                                        <!--<input type="text" class="form-control" />-->
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text" id="driver">₹</span>
                                                            <input type="text" class="form-control" aria-describedby="driver">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <label>Balance</label>
                                                        <!--<input type="text" class="form-control" />-->
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text" id="driver">₹</span>
                                                            <input type="text" class="form-control" aria-describedby="driver">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-12 col-md-6">
                                                        <label>Halting</label>
                                                        <input type="text" class="form-control" />
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <label>Multi Points</label>
                                                        <input type="text" class="form-control" placeholder="Point 1, Point 2" />
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-12 col-md-6">
                                                        <label>Loading Charges</label>
                                                        <!--<input type="text" class="form-control" />-->
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text" id="driver">₹</span>
                                                            <input type="text" class="form-control" aria-describedby="driver">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <label>Unloading Charges</label>
                                                        <!--<input type="text" class="form-control" />-->
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text" id="driver">₹</span>
                                                            <input type="text" class="form-control" aria-describedby="driver">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-12">
                                                        <label>Remarks</label>
                                                        <textarea type="text" class="form-control" rows="3"></textarea>
                                                    </div>
                                                </div>
                                                <div class="text-end">
                                                    <button class="btn btn-primary">Save</button>
                                                </div>
                                            </div>
                                        </form>
                                        <!--<div class="table-responsive">-->
                                        <!--    <table class="table custom-driver-table">-->
                                        <!--        <thead>-->
                                        <!--            <tr>-->
                                        <!--                <th>S.No.</th>-->
                                        <!--                <th>Date</th>-->
                                        <!--                <th>Load Vendor <br><span class="text-secondary">Rank</span></th>-->
                                        <!--                <th>Memo Number</th>-->
                                        <!--                <th>Vehicle Number</th>-->
                                        <!--                <th>Route</th>-->
                                        <!--                <th>Freight</th>-->
                                        <!--                <th>Advance Balace</th>-->
                                        <!--                <th>Trip Status</th>-->
                                        <!--                <th>Payment Status</th>-->
                                        <!--<th class="text-center">Actions</th>-->
                                        <!--            </tr>-->
                                        <!--        </thead>-->
                                        <!--        <tbody>-->
                                        <!--            <tr>-->
                                        <!--                <td>-->
                                        <!--                    <span class="value">1</span>-->
                                        <!--                </td>-->
                                        <!--                <td><span class="value">12/11/2027</span></td>-->
                                        <!--                <td><span class="value">ABC Logistics</span><br> <span class="badge bg-success text-white">Green</span></td>-->
                                        <!--                <td><span class="value">MEMO-1420110012345</span></td>-->
                                        <!--                <td><span class="value">WB-12-AB-1234</span></td>-->
                                        <!--                <td><span class="value">KOL-DEL</span></td>-->
                                        <!--                <td><span class="value">120</span></td>-->
                                        <!--                <td><span class="value">50,000</span></td>-->
                                        <!--                <td><span class="value">Initated</span></td>-->
                                        <!--                <td><span class="value">Paid</span></td>-->
                                        <!--<td class="text-center">-->
                                        <!--    <a href="driver-details.php" class="btn btn-sm-custom">View Details</a>-->
                                        <!--</td>-->
                                        <!--            </tr>-->
                                        <!--        </tbody>-->
                                        <!--    </table>-->
                                        <!--</div>-->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="bg-light p-3">
                                <div class="d-flex mb-3">
                                    <label class="me-4">Status</label>
                                    <select class="form-select select2">
                                        <option>Choose..</option>
                                        <option>New</option>
                                        <option>Vehicle Not Assigned</option>
                                        <option>Vehicle Assigned</option>
                                        <option>Loading</option>
                                        <option>In-transit</option>
                                        <option>Reported</option>
                                        <option>Delayed</option>
                                        <option>Detailned</option>
                                        <option>Unloaded</option>
                                        <option>Breakdown</option>
                                        <option>In Repair</option>
                                        <option>Accident</option>
                                    </select>
                                </div>
                                <div class="d-flex">
                                    <label class="me-4">Reviews</label>
                                    <a href="javascript:void(0)" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addReview"><i class="uil uil-plus me-1"></i>Review</a>
                                </div>
                                <!--<ul class="list-group mt-2">-->
                                <!--  <li class="list-group-item p-1">-->
                                <!--      <div class="d-flex justify-content-between" style="font-size:12px;">-->
                                <!--          <span><i class="fa fa-check-circle me-1 text-success" aria-hidden="true"></i> Ashok Murthy</span>-->
                                <!--          <span>25/10/2025 | 12:00 PM</span>-->
                                <!--      </div>-->
                                <!--  </li>-->
                                <!--</ul>-->
                                <p style="font-size: 14px;" class="mb-2 mt-2">Compliance Check</p>
                                <div class="table-responsive mt-3">
                                    <table class="table table-hover invoice-table mb-0">
                                        <tbody>
                                            <tr>
                                                <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-1 text-success" aria-hidden="true"></i>Broker PAN</th>
                                                <td class="pt-1 pb-1 ps-2 pe-2" style="width: 90px;">Valid</td>
                                            </tr>
                                            <tr>
                                                <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-1 text-success" aria-hidden="true"></i>Broker Bank Account</th>
                                                <td class="pt-1 pb-1 ps-2 pe-2" style="width: 90px;">Active</td>
                                            </tr>
                                            <tr>
                                                <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-1 text-success" aria-hidden="true"></i>Broker Name match PAN</th>
                                                <td class="pt-1 pb-1 ps-2 pe-2" style="width: 90px;">High</td>
                                            </tr>
                                            <tr>
                                                <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-1 text-success" aria-hidden="true"></i>Vehicle Valid</th>
                                                <td class="pt-1 pb-1 ps-2 pe-2" style="width: 90px;">Lorem Ipsum is dummy text.</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <p style="font-size: 14px;" class="mb-2 mt-2">History</p>
                                <ul class="list-group mt-2">
                                    <li class="text-center list-group-item p-1">
                                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#viewHistory" style="font-size: 12px;">View Full History (10)</a>
                                    </li>
                                    <li class="list-group-item p-1">
                                        <div class="d-flex justify-content-between pt-1" style="font-size:12px; line-height: 12px;">
                                            <span>ASOKE</span>
                                            <span>25/10/2025 | 12:00 PM</span>
                                        </div>
                                        <small style="font-size: 10px;">Lorem ipsum is a simply dummy text</small>
                                    </li>
                                    <li class="list-group-item p-1">
                                        <div class="d-flex justify-content-between pt-1" style="font-size:12px; line-height: 12px;">
                                            <span>ASOKE</span>
                                            <span>25/10/2025 | 12:00 PM</span>
                                        </div>
                                        <small style="font-size: 10px;">Lorem ipsum is a simply dummy text</small>
                                    </li>
                                    <li class="list-group-item p-1">
                                        <div class="d-flex justify-content-between pt-1" style="font-size:12px; line-height: 12px;">
                                            <span>ASOKE</span>
                                            <span>25/10/2025 | 12:00 PM</span>
                                        </div>
                                        <small style="font-size: 10px;">Lorem ipsum is a simply dummy text</small>
                                    </li>
                                    <li class="list-group-item p-1">
                                        <div class="d-flex justify-content-between pt-1" style="font-size:12px; line-height: 12px;">
                                            <span>ASOKE</span>
                                            <span>25/10/2025 | 12:00 PM</span>
                                        </div>
                                        <small style="font-size: 10px;">Lorem ipsum is a simply dummy text</small>
                                    </li>
                                    <li class="list-group-item p-1">
                                        <div class="d-flex justify-content-between pt-1" style="font-size:12px; line-height: 12px;">
                                            <span>ASOKE</span>
                                            <span>25/10/2025 | 12:00 PM</span>
                                        </div>
                                        <small style="font-size: 10px;">Lorem ipsum is a simply dummy text</small>
                                    </li>
                                    <li class="list-group-item p-1">
                                        <div class="d-flex justify-content-between pt-1" style="font-size:12px; line-height: 12px;">
                                            <span>ASOKE</span>
                                            <span>25/10/2025 | 12:00 PM</span>
                                        </div>
                                        <small style="font-size: 10px;">Lorem ipsum is a simply dummy text</small>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="addReview" tabindex="-1">
    <div class="modal-dialog dialog-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Trip Review</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="uil uil-times"></i></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <small>Update your review for this Trip. This will OVERWRITE your previous review, if any.</small>
                        <ul class="list-group mt-2">
                            <li class="list-group-item">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="review" id="approve">
                                    <label class="form-check-label" for="approve">
                                    Approve
                                    </label>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="review" id="req_chg">
                                    <label class="form-check-label" for="req_chg">
                                    Request Change
                                    </label>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="form-group">
                        <label>Comment</label>
                        <textarea class="form-control" rows="3"></textarea>
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
<div class="modal fade" id="editTrip" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Trip</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="uil uil-times"></i></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row form-group">
                        <div class="col-12 col-md-3">
                            <label>Trip ID</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text" class="form-control bg-light" readonly placeholder="Will be auto generated" value="#001" />
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-12 col-md-3">
                            <label>Trip Date</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text" id="daterange" class="form-control" placeholder="DD/MM/YYYY">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-12 col-md-3">
                            <label>Trip Type</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <select class="form-select">
                                <option>Choose..</option>
                                <option selected>Own Booking</option>
                                <option>Outside Booking</option>
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-12 col-md-3">
                            <label>Trip Category</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <div class="d-flex">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="tripCategory" id="opt1" value="Line">
                                    <label class="form-check-label" for="opt1">
                                    Line
                                    </label>
                                </div>
                                <div class="form-check mx-2">
                                    <input class="form-check-input" type="radio" name="tripCategory" id="opt2" value="Local">
                                    <label class="form-check-label" for="opt2">
                                    Local
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-12 col-md-3">
                            <label>Load Vendor</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <select class="form-select">
                                <option>Choose..</option>
                                <option>DHL</option>
                                <option>Blue Dart</option>
                                <option>Fed Ex</option>
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-12 col-md-3">
                            <label>RAG Status</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <!--<input type="text" class="form-control bg-light" readonly />-->
                            <span class="badge bg-danger">Red</span>
                            <span class="badge bg-warning">Yellow</span>
                            <span class="badge bg-success">Green</span>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-12 col-md-3">
                            <label>Customer</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <select class="form-select">
                                <option>Choose..</option>
                                <option>Nestle</option>
                                <option>Britania</option>
                                <option>Samsung</option>
                            </select>
                        </div>
                    </div>
                    <div class="text-end mb-4">
                        <a href="add-customer.php" style="font-size: 13px;"><i class="uil uil-plus me-2"></i> Add Customer</a>
                    </div>
                    <div class="row form-group">
                        <div class="col-12 col-md-3">
                            <label>Vehicle Type</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <select class="form-select">
                                <option>Choose..</option>
                                <option>Large Container</option>
                                <option>Truck</option>
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-12 col-md-3">
                            <label>Vehicle Size</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <select class="form-select">
                                <option>Choose..</option>
                                <option>14 FT - XXM 14M * 9M * 12M</option>
                                <option>28 FT - XXL 28M * 12M * 17M</option>
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-12 col-md-3">
                            <label>Internal Trip ID</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text" class="form-control" value="#001006754" />
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-12 col-md-3">
                            <label>Route</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <select class="form-select select2-modal">
                                <option>Choose..</option>
                                <option selected>Chennai - Kolkata</option>
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
                                        <label>Midpoint 1</label>
                                    </div>
                                    <div class="col-10 col-md-8">
                                        <select class="form-select select2">
                                            <option>Choose...</option>
                                            <option>Kolkata</option>
                                            <option>Bihar</option>
                                        </select>
                                    </div>
                                    <div class="col-2 col-md-1">
                                        <i class="uil uil-trash-alt text-danger removeStop"></i>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-md-6 form-group">
                                        <label>Midpoint Type</label>
                                        <div class="form-check form-check-inline radio-chip">
                                            <input class="form-check-input" type="radio" name="midpoint_type" id="loading" value="Loading">
                                            <label class="form-check-label if-loading" for="loading"><i class="uil uil-check-circle me-1"></i>Loading</label>
                                        </div>
                                        <div class="form-check form-check-inline radio-chip">
                                            <input class="form-check-input" type="radio" name="midpoint_type" id="unloading" value="Unloading">
                                            <label class="form-check-label if-unloading" for="unloading"><i class="uil uil-check-circle me-1"></i>Unloading</label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 form-group loading-wrap">
                                        <label>Loading Midpoint</label>
                                        <select class="form-select select2">
                                            <option>Choose...</option>
                                            <option>Kolkata</option>
                                            <option>Bihar</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-6 form-group unloading-wrap">
                                        <label>Unloading Midpoint</label>
                                        <select class="form-select select2">
                                            <option>Choose...</option>
                                            <option>Kolkata</option>
                                            <option>Bihar</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <a href="javascript:void(0)" class="btn btn-secondary add-stop-btn"><i class="uil uil-plus me-1"></i>Midpoint</a>
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
                            <label>Distance</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text" class="form-control bg-light" readonly value="10 KM" />
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-12 col-md-3">
                            <label>Priority</label>
                        </div>
                        <div class="col-12 col-md-9">
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
                    <div class="row form-group">
                        <div class="col-12 col-md-3">
                            <label>Tarpaulin</label>
                        </div>
                        <div class="col-12 col-md-9">
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
                    <div class="row form-group">
                        <div class="col-12 col-md-3">
                            <label>Comment</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <textarea class="form-control" rows="4">orem ipsum doller sit amet. Lorem ipsum is a dummy text.</textarea>
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
<div class="modal fade" id="addEwayTable" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="uil uil-arrow-left"></i></button>
                    Unassigned E-Ways
                </h5>
                <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#addEway"><i class="uil uil-plus me-1"></i>Add Eway</button>
            </div>
            <div class="modal-body">
                <form class="d-flex justify-content-between">
                    <div class="form-group d-inline-block" style="width:160px;">
                        <input type="text" class="form-control" placeholder="Search By Eway Bill No." />
                    </div>
                    <!--<div class="form-group d-inline-block" style="width:200px;">-->
                    <!--    <input type="date" class="form-control" />-->
                    <!--</div>-->
                    <div class="form-group d-inline-block" style="width:160px;">
                        <input type="text" class="form-control" placeholder="Search By Vehicle No." />
                    </div>
                    <div class="form-group d-inline-block" style="width:150px;">
                        <select class="form-select">
                            <option>Search By Status</option>
                            <option>Active</option>
                            <option>Inactive</option>
                        </select>
                    </div>
                    <div class="form-group d-inline-block" style="width:150px;">
                        <input type="text" class="form-control" placeholder="Search By Quantity" />
                    </div>
                    <div class="form-group d-inline-block" style="width:180px;">
                        <input type="text" class="form-control" placeholder="Search By Quantity Units" />
                    </div>
                    <div class="form-group d-inline-block" style="width:160px;">
                        <input type="text" class="form-control" placeholder="Search By LR Number" />
                    </div>
                    <div class="form-group d-inline-block">
                        <button class="btn btn-primary"><i class="uil uil-redo"></i></button>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table table-hover invoice-table mb-0">
                        <thead>
                            <tr>
                                <th>
                                    <input type="checkbox">
                                </th>
                                <th style="min-width: 150px;">Eway Bill Number</th>
                                <th style="min-width: 150px;">Eway Date</th>
                                <th style="min-width: 150px;">Vehicle Number</th>
                                <th>Status</th>
                                <th>Quantity</th>
                                <th style="min-width: 150px;">Quantity Units</th>
                                <th>Consigner</th>
                                <th>Source</th>
                                <th>Consignee</th>
                                <th>Destination</th>
                                <th>GSTIN</th>
                                <th>Valid Upto</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input type="checkbox"></td>
                                <td>
                                    #001
                                </td>
                                <td>
                                    05/11/2025
                                </td>
                                <td>WB-12-AB-1237</td>
                                <td><span class="badge bg-success">Active</span></td>
                                <td>10</td>
                                <td>
                                    KG
                                </td>
                                <td>Britania Kolkata</td>
                                <td>Chennai</td>
                                <td>Kolkata-Gen</td>
                                <td>Kolkata</td>
                                <td>GST00912267g6</td>
                                <td>30/11/2025</td>
                            </tr>
                            <tr>
                                <td><input type="checkbox"></td>
                                <td>
                                    #001
                                </td>
                                <td>
                                    05/11/2025
                                </td>
                                <td>WB-12-AB-1237</td>
                                <td><span class="badge bg-success">Active</span></td>
                                <td>10</td>
                                <td>
                                    KG
                                </td>
                                <td>Britania Kolkata</td>
                                <td>Chennai</td>
                                <td>Kolkata-Gen</td>
                                <td>Kolkata</td>
                                <td>GST00912267g6</td>
                                <td>30/11/2025</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="text-end">
                    <span style="font-size: 13px;">Total: 2</span>
                    <span style="font-size: 13px;" class="ms-3">Selected: 2</span>
                    <span style="font-size: 13px;" class="ms-3 me-4">Selected Quantity: 882.00</span>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Add to Trip</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="addEway" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Eway</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="uil uil-times"></i></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row form-group">
                        <div class="col-12 col-md-3">
                            <label>GSTIN <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text" class="form-control" />
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-12 col-md-3">
                            <label>Eway Bill Number (s) <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text" class="form-control" />
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

<div class="modal fade" id="addPOD" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header pb-0">
                <h5 class="modal-title">LR-POD</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="uil uil-times"></i></button>
            </div>
            <div class="modal-body pt-0">
                <p class="mb-2 ms-1 text-theme" style="font-size:14px;">Details</p>
                <div class="table-responsive">
                    <table class="table table-hover invoice-table mb-0">
                        <tbody>
                            <tr>
                                <th>Material Description</th>
                                <th>Invoice Number & Date</th>
                                <th>LR Number & Date</th>
                            </tr>
                            <tr>
                                <td>
                                    Hydrabad - Kolkata
                                </td>
                                <td>
                                    #INV001 | 12/10/2025
                                </td>
                                <td>#LR001 | 25/10/2025</td>
                            </tr>
                            </tr>
                            <tr>
                                <th>
                                    Net Quantity
                                </th>
                                <th>Value (with tax)</th>
                                <th>Gross Weight</th>
                            </tr>
                            <tr>
                                <td>
                                    50
                                </td>
                                <td>
                                    1000
                                </td>
                                <td>10Kg</td>
                            </tr>
                            <tr>
                                <th>Charged Weight</th>
                                <th>LR Comments</th>
                                <th>Estimated Date of Delivery</th>
                            </tr>
                            <tr>
                                <td>5Kg</td>
                                <td>Lorem ipsum doller sit amet.</td>
                                <td>5Kg</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!--<div class="mt-2">-->
                <!--    <div class="dropdown d-inline-block">-->
                <!--      <button class="btn btn-secondary dropdown-toggle" type="button" id="creditEntry" data-bs-toggle="dropdown" aria-expanded="false">-->
                <!--        Credit Entry (+)-->
                <!--      </button>-->
                <!--      <ul class="dropdown-menu" aria-labelledby="creditEntry">-->
                <!--        <li><a class="dropdown-item" href="javascript:void(0)">Unloading Detention</a></li>-->
                <!--        <li><a class="dropdown-item" href="javascript:void(0)">Unloading Charges</a></li>-->
                <!--        <li><a class="dropdown-item" href="javascript:void(0)">Other</a></li>-->
                <!--      </ul>-->
                <!--    </div>-->
                <!--    <div class="dropdown d-inline-block">-->
                <!--      <button class="btn btn-secondary dropdown-toggle" type="button" id="creditEntry" data-bs-toggle="dropdown" aria-expanded="false">-->
                <!--        Debit Entry (-)-->
                <!--      </button>-->
                <!--      <ul class="dropdown-menu" aria-labelledby="creditEntry">-->
                <!--        <li><a class="dropdown-item" href="javascript:void(0)">Late Delivery Fine</a></li>-->
                <!--        <li><a class="dropdown-item" href="javascript:void(0)">Deduction from Shortages / Damages</a></li>-->
                <!--        <li><a class="dropdown-item" href="javascript:void(0)">Payment Cut</a></li>-->
                <!--        <li><a class="dropdown-item" href="javascript:void(0)">Claim</a></li>-->
                <!--      </ul>-->
                <!--    </div>-->
                <!--</div>-->
                <form class="mt-2">
                    <div class="row form-group">
                        <div class="col-12 col-md-3">
                            <label>Acknowledgement <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-12 col-md-9">
                            <select class="form-select">
                                <option>Choose..</option>
                                <option>Good</option>
                                <option>Damaged</option>
                                <option>Short</option>
                                <option>Claimed</option>
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-12 col-md-3">
                            <label>Reporting Date <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="date" class="form-control" />
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-12 col-md-3">
                            <label>Unloading Date <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="date" class="form-control"/>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-12 col-md-3">
                            <label>Detention Days <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text" class="form-control" />
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-12 col-md-3">
                            <label>Late Delivery Days <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text" class="form-control" />
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-12 col-md-3">
                            <label>Shortage <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text" class="form-control" />
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-12 col-md-3">
                            <label>PoD Comments <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text" class="form-control" />
                        </div>
                    </div>
                    <div>
                        <label>Attachments</label>
                        <div class="upload_file field" align="left">
                            <input type="file" id="files" name="files[]" multiple />
                            <span class="pip">
                                <img class="imageThumb" src="data:image/png;base64,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" title="undefined">
                                <div class="file-name-wrap">
                                    <p>Test.pdf</p>
                                    <small>15MB.</small>
                                </div>
                                <span class="remove"><i class="uil uil-trash-alt"></i></span>
                            </span>
                            <div>
                                <label class="btn btn-secondary mt-2" for="files"><i class="uil uil-paperclip me-1"></i>Add POD</label>
                            </div>
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
<div class="modal fade" id="viewHistory" tabindex="-1">
    <div class="modal-dialog dialog-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">View Full History</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="uil uil-times"></i></button>
            </div>
            <div class="modal-body">
                <ul class="list-group history-wrap">
                    <li class="list-group-item">
                        <div class="d-flex justify-content-between">
                            <span><i class="fa fa-check-circle me-1 text-success" aria-hidden="true"></i> Jaideep</span>
                            <span>25/10/2025 | 12:00 PM</span>
                        </div>
                        <small>Lorem ipsum is a simply dummy text</small>
                    </li>
                    <li class="list-group-item">
                        <div class="d-flex justify-content-between">
                            <span><i class="fa fa-check-circle me-1 text-success" aria-hidden="true"></i> Rahul</span>
                            <span>25/10/2025 | 12:00 PM</span>
                        </div>
                        <small>Lorem ipsum is a simply dummy text</small>
                    </li>
                    <li class="list-group-item">
                        <div class="d-flex justify-content-between">
                            <span><i class="fa fa-check-circle me-1 text-success" aria-hidden="true"></i> Ashish</span>
                            <span>25/10/2025 | 12:00 PM</span>
                        </div>
                        <small>Lorem ipsum is a simply dummy text</small>
                    </li>
                    <li class="list-group-item">
                        <div class="d-flex justify-content-between">
                            <span><i class="fa fa-check-circle me-1 text-success" aria-hidden="true"></i> Ramesh</span>
                            <span>25/10/2025 | 12:00 PM</span>
                        </div>
                        <small>Lorem ipsum is a simply dummy text</small>
                    </li>
                    <li class="list-group-item">
                        <div class="d-flex justify-content-between">
                            <span><i class="fa fa-check-circle me-1 text-success" aria-hidden="true"></i> Abinash</span>
                            <span>25/10/2025 | 12:00 PM</span>
                        </div>
                        <small>Lorem ipsum is a simply dummy text</small>
                    </li>
                    <li class="list-group-item">
                        <div class="d-flex justify-content-between">
                            <span><i class="fa fa-check-circle me-1 text-success" aria-hidden="true"></i> Suresh</span>
                            <span>25/10/2025 | 12:00 PM</span>
                        </div>
                        <small>Lorem ipsum is a simply dummy text</small>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="right-overlay attachment-popup">
    <div class="overlay-header">
        <div class="row align-items-center">
            <div class="col-12 col-md-6">
                <h6 class="mb-0">Attachments</h6>
            </div>
            <div class="col-12 col-md-6 text-end">
                <button class="btn btn-secondary"><i class="uil uil-import me-1"></i>Download All</button>
                <a href="javascript:void(0)" class="close-overlay close-map ms-2"><i class="uil uil-arrow-to-right text-secondary" style="font-size: 20px;"></i></a>
            </div>
        </div>
    </div>
    <div class="overlay-body">
        <h6>Attachments (4)</h6>
        <div class="upload_file field" align="left">
            <input type="file" id="files" name="files[]" multiple />
            <span class="pip">
                <img class="imageThumb" src="data:image/png;base64,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" title="undefined">
                <div class="file-name-wrap">
                    <p>Test.pdf</p>
                    <small>15MB.</small>
                </div>
                <span class="remove"><i class="uil uil-trash-alt"></i></span>
            </span>
            <div>
                <label class="btn btn-secondary mt-2" for="files"><i class="uil uil-paperclip me-1"></i>Hire Letter</label>
                <label class="btn btn-secondary mt-2" for="files"><i class="uil uil-paperclip me-1"></i>Challan</label>
                <label class="btn btn-secondary mt-2" for="files"><i class="uil uil-paperclip me-1"></i>Loading Slip</label>
                <label class="btn btn-secondary mt-2" for="files"><i class="uil uil-paperclip me-1"></i>Other</label>
            </div>
        </div>
        <hr>
        <h6>Broker Attachments (1)</h6>
        <div class="upload_file field" align="left">
            <input type="file" id="files" name="files[]" multiple />
            <span class="pip">
                <img class="imageThumb" src="data:image/png;base64,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" title="undefined">
                <div class="file-name-wrap">
                    <p>Test.pdf</p>
                    <small>15MB.</small>
                </div>
                <span class="remove"><i class="uil uil-trash-alt"></i></span>
            </span>
            <div>
                <label class="btn btn-secondary mt-2" for="files"><i class="uil uil-paperclip me-1"></i>Add File</label>
            </div>
        </div>
        <hr>
        <h6>Vehicle Attachments (1)</h6>
        <div class="upload_file field" align="left">
            <input type="file" id="files" name="files[]" multiple />
            <span class="pip">
                <img class="imageThumb" src="data:image/png;base64,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" title="undefined">
                <div class="file-name-wrap">
                    <p>Test.pdf</p>
                    <small>15MB.</small>
                </div>
                <span class="remove"><i class="uil uil-trash-alt"></i></span>
            </span>
            <div>
                <label class="btn btn-secondary mt-2" for="files"><i class="uil uil-paperclip me-1"></i>Add File</label>
            </div>
        </div>
        <hr>
        <h6>LR/POD Attachments (1)</h6>
        <div class="upload_file field" align="left">
            <input type="file" id="files" name="files[]" multiple />
            <span class="pip">
                <img class="imageThumb" src="data:image/png;base64,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" title="undefined">
                <div class="file-name-wrap">
                    <p>Test.pdf</p>
                    <small>15MB.</small>
                </div>
                <span class="remove"><i class="uil uil-trash-alt"></i></span>
            </span>
            <div>
                <label class="btn btn-secondary mt-2" for="files"><i class="uil uil-paperclip me-1"></i>Add File</label>
            </div>
        </div>
    </div>
</div>
<div class="right-overlay map-popup">
    <div class="overlay-header">
        <div class="row align-items-center">
            <div class="col-12 col-md-6">
                <h6 class="mb-0">View Details</h6>
            </div>
            <div class="col-12 col-md-6 text-end">
                <button class="btn btn-success"  data-bs-toggle="modal" data-bs-target="#assignModal"><i class="uil uil-check-circle me-1"></i>Assign</button>
                <a href="javascript:void(0)" class="close-overlay close-map ms-2"><i class="uil uil-arrow-to-right text-secondary" style="font-size: 20px;"></i></a>
            </div>
        </div>
    </div>
    <div class="overlay-body">
        <div>
            <iframe src="https://www.google.com/maps/embed?pb=!1m28!1m12!1m3!1d939846.3792652059!2d87.18564370509674!3d23.05038048140725!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m13!3e0!4m5!1s0x39f882db4908f667%3A0x43e330e68f6c2cbc!2sKolkata%2C%20West%20Bengal!3m2!1d22.5743545!2d88.3628734!4m5!1s0x39f7710b47a89171%3A0x429e1bdb57e009dd!2sDurgapur%2C%20West%20Bengal!3m2!1d23.520444299999998!2d87.3119227!5e0!3m2!1sen!2sin!4v1763121789776!5m2!1sen!2sin" width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        <div class="">
            <div class="row">
                <div class="col-12 col-md-4">
                    <!--<label class="text-secondary">Truck Model</label>-->
                    <!--<p>ABVP</p>-->
                    <label class="text-secondary">Vehicle Age</label>
                    <p>10 Year 5 month</p>
                </div>
                <div class="col-12 col-md-4">
                    <!--<label class="text-secondary">Truck Type</label>-->
                    <!--<p>Large</p>-->
                    <label class="text-secondary">Vehicle Size </label>
                    <p>32Ft</p>
                </div>
                <div class="col-12 col-md-4">
                    <label class="text-secondary">Vehicle Capacity</label>
                    <p>1000 KG</p>
                </div>
                <div class="col-12 col-md-6">
                    <p>Live Location:</p>
                </div>
                <div class="col-12 col-md-6">
                    <p class="badge bg-primary">Saltlake</p>
                </div>
                <div class="col-12 col-md-6">
                    <p>Availability:</p>
                </div>
                <div class="col-12 col-md-6">
                    <p class="badge bg-success">Free</p>
                </div>
                <hr>
                <div class="col-12 col-md-6">
                    <h6>Vehicle Rank:</h6>
                </div>
                <div class="col-12 col-md-6">
                    <p class="badge bg-info">5th</p>
                </div>
                <div class="row">
                    <div class="col-12 col-md-3">
                        <small class="text-secondary">Total Trip:</small>
                    </div>
                    <div class="col-12 col-md-1">
                        <small class="mb-2">12</small>
                    </div>
                    <div class="col-12 col-md-2">
                        <small class="text-secondary">Line:</small>
                    </div>
                    <div class="col-12 col-md-2">
                        <small class="mb-2">5</small>
                    </div>
                    <div class="col-12 col-md-2">
                        <small class="text-secondary">Local:</small>
                    </div>
                    <div class="col-12 col-md-2">
                        <small class="mb-2">7</small>
                    </div>
                </div>
                <hr class="mt-4">
                <div class="col-12 col-md-6">
                    <p>Estimated Time of Arrival:</p>
                </div>
                <div class="col-12 col-md-6">
                    <p class="badge bg-info">12/11/2025 | 12:00 PM</p>
                </div>
                <hr>
                <div class="col-12">
                    <h6>Last Trip Details</h6>
                </div>
                <div class="row">
                    <div class="col-12 col-md-3">
                        <small class="text-secondary">Trip Type</small>
                    </div>
                    <div class="col-12 col-md-3">
                        <small class="mb-2">Outside Booking</small>
                    </div>
                    <div class="col-12 col-md-3">
                        <small class="text-secondary" style="line-height: 16px; display: inline-block;">Customer</small>
                    </div>
                    <div class="col-12 col-md-3">
                        <small class="mb-2">John Doe</small>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-3">
                        <small class="text-secondary">Source</small>
                    </div>
                    <div class="col-12 col-md-3">
                        <small class="mb-2">Kolkata</small>
                    </div>
                    <div class="col-12 col-md-3"> 
                        <small class="text-secondary">Destination</small>
                    </div>
                    <div class="col-12 col-md-3">
                        <small class="mb-2">Mumbai</small>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-3">
                        <small class="text-secondary">Stop 1</small>
                    </div>
                    <div class="col-12 col-md-3">
                        <small class="mb-2">Kolaghat</small>
                    </div>
                    <div class="col-12 col-md-3">
                        <small class="text-secondary">Stop 2</small>
                    </div>
                    <div class="col-12 col-md-3">
                        <small class="mb-2">Patna</small>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-3">
                        <small class="text-secondary">Stop 3</small>
                    </div>
                    <div class="col-12 col-md-3">
                        <small class="mb-2">Pune</small>
                    </div>
                    <div class="col-12 col-md-3"> 
                        <small class="text-secondary">Duration</small>
                    </div>
                    <div class="col-12 col-md-3">
                        <small class="mb-2s">15 Hours</small>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-6 mt-3"> 
                        <small class="text-secondary" style="line-height: 16px; display: inline-block;">Delivery Status</small>
                    </div>
                    <div class="col-12 col-md-6 mt-3">
                        <small class="mb-2">On Time</small>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-6 mt-3">
                        <p>Route:</p>
                    </div>
                    <div class="col-12 col-md-6 mt-3">
                        <p class="badge bg-warning">Kolkata - Mumbai</p>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <p>Trip Date & Time :</p>
                </div>
                <div class="col-12 col-md-6">
                    <p class="badge bg-info">12/11/2025 | 12:00 PM</p>
                </div>
                <hr>
                <div class="col-12">
                    <h6>Assigned Driver Details</h6>
                    <div class="table-responsive mt-3">
                        <table class="table table-hover invoice-table mb-0">
                            <tbody>
                                <tr>
                                    <th class="pt-1 pb-1 ps-2 pe-2">Driver Name:</th>
                                    <td class="pt-1 pb-1 ps-2 pe-2" style="width: 200px;">Ashoke Pandey</td>
                                </tr>
                                <tr>
                                    <th class="pt-1 pb-1 ps-2 pe-2">Driver Number:</th>
                                    <td class="pt-1 pb-1 ps-2 pe-2" style="width: 200px;">+91 9876543210</td>
                                </tr>
                                <tr>
                                    <th class="pt-1 pb-1 ps-2 pe-2">Associated Since:</th>
                                    <td class="pt-1 pb-1 ps-2 pe-2" style="width: 200px;">10 Years 11 Months</td>
                                </tr>
                                <tr>
                                    <th class="pt-1 pb-1 ps-2 pe-2">Driver Experience:</th>
                                    <td class="pt-1 pb-1 ps-2 pe-2" style="width: 200px;">2 Years 4 Months</td>
                                </tr>
                                <tr>
                                    <th class="pt-1 pb-1 ps-2 pe-2">Driver RAG Status:</th>
                                    <td class="pt-1 pb-1 ps-2 pe-2" style="width: 200px;">
                                        <div class="value">
                                            <span class="badge bg-success">Green</span>
                                            <!--<span class="badge bg-danger">Red</span>-->
                                            <!--<span class="badge bg-warning">Yellow</span>-->
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <hr>
                    <ul class="list-group mt-2 mb-5">
                        <li class="list-group-item p-2">
                            <strong>Driver History</strong>
                        </li>
                        <li class="list-group-item p-2">
                            <div class="d-flex justify-content-between pt-1" style="font-size:12px; line-height: 12px;">
                                <span>Mohit Singh</span>
                                <span>25/10/2025 - 28/10/2025</span>
                            </div>
                            <div class="d-flex justify-content-between pt-1" style="font-size:12px; line-height: 12px;">
                                <span>Kolkata - Durgapur</span>
                                <span>10 Years 2 Month 6 Days</span>
                            </div>
                        </li>
                        <li class="list-group-item p-2">
                            <div class="d-flex justify-content-between pt-1" style="font-size:12px; line-height: 12px;">
                                <span>Litesh Kumar</span>
                                <span>25/10/2025 - 28/10/2025</span>
                            </div>
                            <div class="d-flex justify-content-between pt-1" style="font-size:12px; line-height: 12px;">
                                <span>Durgapur - Katoya</span>
                                <span>12 Years 3 Month 4 Days</span>
                            </div>
                        </li>
                        <li class="list-group-item p-2">
                            <div class="d-flex justify-content-between pt-1" style="font-size:12px; line-height: 12px;">
                                <span>Anjan Murthy</span>
                                <span>25/10/2025 - 28/10/2025</span>
                            </div>
                            <div class="d-flex justify-content-between pt-1" style="font-size:12px; line-height: 12px;">
                                <span>Bardhaman - Murshidabad</span>
                                <span>8 Years 1 Month 25 Days</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="closeTrip" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center p-5">
                <h5>Are you sure you want to close this trip?</h5>
                <button class="btn btn-success mt-3" data-bs-dismiss="modal">Yes</button>
                <button class="btn btn-danger mt-3" data-bs-dismiss="modal">No</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="cancelTrip" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center p-5">
                <h5>Are you sure you want to cancel this trip?</h5>
                <button class="btn btn-success mt-3" data-bs-dismiss="modal">Yes</button>
                <button class="btn btn-danger mt-3" data-bs-dismiss="modal">No</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="addEway" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Eway</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="uil uil-times"></i></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row form-group">
                        <div class="col-12 col-md-3">
                            <label>GSTIN <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text" class="form-control" />
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-12 col-md-3">
                            <label>Eway Bill Number (s) <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text" class="form-control" />
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
<div class="modal fade" id="assignModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Assign Vehicle to This Trip</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="uil uil-times"></i></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row form-group">
                        <div class="col-12 col-md-6">
                            <label>Expected Start Date</label>
                            <input class="form-control" type="date">
                        </div>
                        <div class="col-12 col-md-6">
                            <label>Expected Start Time</label>
                            <input class="form-control" type="time">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-12 col-md-6">
                            <label>Loading Point</label>
                            <select class="form-select select2-modal">
                                <option>Choose..</option>
                                <option>Webel Gate</option>
                                <option>SDF</option>
                                <option>DLF 1</option>
                                <option>DLF 2</option>
                                <option>Laketown</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-6">
                            <label>Unloading Point</label>
                            <select class="form-select select2-modal">
                                <option>Choose..</option>
                                <option>Webel Gate</option>
                                <option>SDF</option>
                                <option>DLF 1</option>
                                <option>DLF 2</option>
                                <option>Laketown</option>
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-12 col-md-6">
                            <label>Midpoint 1</label>
                            <input type="text" class="form-control bg-light" value="Bihar" readonly />
                        </div>
                        <div class="col-12 col-md-6">
                            <label>Midpoint 1 Type</label>
                            <span class="badge badge-success">Loading</span>
                        </div>
                        <div class="col-12 mt-2">
                            <label>Loading Location</label>
                            <select class="form-select">
                                <option>Choose..</option>
                                <option>Webel Gate</option>
                                <option>SDF</option>
                                <option>DLF 1</option>
                                <option>DLF 2</option>
                                <option>Laketown</option>
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-12 col-md-6">
                            <label>Midpoint 2</label>
                            <input type="text" class="form-control bg-light" value="Odisha" readonly />
                        </div>
                        <div class="col-12 col-md-6">
                            <label>Midpoint 2 Type</label>
                            <span class="badge badge-danger">Unloading</span>
                        </div>
                        <div class="col-12 mt-2">
                            <label>Unloading Location</label>
                            <select class="form-select">
                                <option>Choose..</option>
                                <option>Webel Gate</option>
                                <option>SDF</option>
                                <option>DLF 1</option>
                                <option>DLF 2</option>
                                <option>Laketown</option>
                            </select>
                        </div>
                    </div>
                    <div class="text-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <a href="assign-veh.php" type="button" class="btn btn-primary">Assign</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="addExpense" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Expense</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="uil uil-times"></i></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row form-group">
                        <div class="col-12">
                            <label>Expense Head</label>
                            <select class="form-select">
                                <option>Choose</option>
                                <option>Fuel</option>
                                <option>Toll Charges</option>
                                <option>Driver Advance</option>
                                <option>Maintenance</option>
                                <option>Fooding</option>
                                <option>Miscl. Exp</option>
                            </select>
                            <a href="javascript:void(0)" class="mt-1" style="font-size: 13px;"><i class="uil uil-plus me-1"></i>Add Expense Head</a>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-12 col-md-6">
                            <label>Expense Type</label>
                            <div class="d-flex">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="expenseType2" id="debited" value="debit" autocompleted="">
                                    <label class="form-check-label if-debit" for="debited">
                                    Debit
                                    </label>
                                </div>
                                <div class="form-check mx-2">
                                    <input class="form-check-input" type="radio" name="expenseType2" id="credited" value="credit">
                                    <label class="form-check-label if-credit" for="credited">
                                    Credit
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 debit-wrap">
                            <label>Debit Amount</label>
                            <!--<input class="form-control" type="text">-->
                            <div class="input-group">
                                <button class="btn btn-primary" type="button" id="rupee">₹</button>
                                <input type="text" class="form-control" aria-describedby="rupee">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 credit-wrap">
                            <label>Credit Amount</label>
                            <!--<input class="form-control" type="text">-->
                            <div class="input-group">
                                <button class="btn btn-primary" type="button" id="rupee">₹</button>
                                <input type="text" class="form-control" aria-describedby="rupee">
                            </div>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-12">
                            <label>Payment Method</label>
                            <select class="form-select">
                                <option>Choose</option>
                                <option>Cash</option>
                                <option>Online</option>
                                <option>UPI</option>
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-12 col-md-6">
                            <label>Expense Date</label>
                            <input class="form-control" type="date">
                        </div>
                        <div class="col-12 col-md-6">
                            <label>Expense Time</label>
                            <input class="form-control" type="time">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-12">
                            <label>Notes</label>
                            <textarea class="form-control" type="text" rows="3"></textarea>
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
<div class="modal fade" id="driverExpense" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Expense</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="uil uil-times"></i></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row form-group">
                        <div class="col-12">
                            <label>Expense Head</label>
                            <select class="form-select">
                                <option>Choose</option>
                                <option>Vehicle Challan</option>
                                <option>Accident Charges Paid to Car</option>
                                <option>Material Shortage</option>
                                <option>Late Delivery</option>
                            </select>
                            <a href="javascript:void(0)" class="mt-1" style="font-size: 13px;"><i class="uil uil-plus me-1"></i>Add Expense Head</a>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-12 col-md-6">
                            <label>Expense Type</label>
                            <div class="d-flex">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="expenseType1" id="debit1" value="debit">
                                    <label class="form-check-label if-debit" for="debit1">
                                    Debit
                                    </label>
                                </div>
                                <div class="form-check mx-2">
                                    <input class="form-check-input" type="radio" name="expenseType1" id="credit1" value="credit">
                                    <label class="form-check-label if-credit" for="credit1">
                                    Credit
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 debit-wrap">
                            <label>Debit Amount</label>
                            <div class="input-group">
                                <button class="btn btn-primary" type="button" id="rupee">₹</button>
                                <input type="text" class="form-control" aria-describedby="rupee">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 credit-wrap">
                            <label>Credit Amount</label>
                            <div class="input-group">
                                <button class="btn btn-primary" type="button" id="rupee">₹</button>
                                <input type="text" class="form-control" aria-describedby="rupee">
                            </div>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-12">
                            <label>Payment Method</label>
                            <select class="form-select">
                                <option>Choose</option>
                                <option>Cash</option>
                                <option>Online</option>
                                <option>UPI</option>
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-12 col-md-6">
                            <label>Expense Date</label>
                            <input class="form-control" type="date">
                        </div>
                        <div class="col-12 col-md-6">
                            <label>Expense Time</label>
                            <input class="form-control" type="time">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-12">
                            <label>Notes</label>
                            <textarea class="form-control" type="text" rows="3"></textarea>
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
<div class="modal fade" id="addAddition" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Addition</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="uil uil-times"></i></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row form-group">
                        <div class="col-12 col-md-6">
                            <label>Addition Head</label>
                            <select class="form-select">
                                <option>Choose</option>
                                <option>Fixed Fee</option>
                                <option>Loading/Unloading Charge</option>
                                <option>Extra KM</option>
                                <option>Tax</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-6">
                            <label>Amount</label>
                            <input class="form-control" type="text">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-12">
                            <label>Other</label>
                            <input class="form-control" type="text">
                        </div>
                        <div class="col-12">
                            <label>Notes</label>
                            <textarea class="form-control" type="text" rows="3"></textarea>
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
<div class="modal fade" id="addDeduction" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Deduction</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="uil uil-times"></i></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row form-group">
                        <div class="col-12 col-md-6">
                            <label>Deduction Head</label>
                            <select class="form-select">
                                <option>Choose</option>
                                <option>TDS</option>
                                <option>Mamul</option>
                                <option>P/R</option>
                                <option>Previous Adjustments</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-6">
                            <label>Amount</label>
                            <input class="form-control" type="text">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-12">
                            <label>Other</label>
                            <input class="form-control" type="text">
                        </div>
                        <div class="col-12">
                            <label>Notes</label>
                            <textarea class="form-control" type="text" rows="3"></textarea>
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
<div class="modal fade" id="addTransaction" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Transaction</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="uil uil-times"></i></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row form-group">
                        <div class="col-12 col-md-6">
                            <label>Date</label>
                            <input class="form-control" type="date">
                        </div>
                        <div class="col-12 col-md-6">
                            <label>Typw</label>
                            <select class="form-select">
                                <option>Choose</option>
                                <option>Advance</option>
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-12">
                            <label>Mode of Payment</label>
                            <select class="form-select">
                                <option>Choose</option>
                                <option>Cash</option>
                                <option>Online</option>
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-12">
                            <label>Amount</label>
                            <input class="form-control" type="text">
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
<div class="right-overlay bill-popup">
    <div class="overlay-header">
        <div class="row align-items-center">
            <div class="col-12 col-md-6">
                <h6 class="mb-0">Bill Entry</h6>
            </div>
            <div class="col-12 col-md-6 text-end">
                <button class="btn btn-secondary"><i class="uil uil-import me-1"></i>All Okay!</button>
                <a href="javascript:void(0)" class="close-overlay close-map ms-2"><i class="uil uil-arrow-to-right text-secondary" style="font-size: 20px;"></i></a>
            </div>
        </div>
    </div>
    <div class="overlay-body">
        <div class="">
            <div class="row">
                <div class="col-12 col-md-4">
                    <label class="text-secondary">Billing Party:</label>
                    <p>Gitanjali LLP.</p>
                </div>
                <div class="col-12 col-md-4">
                    <label class="text-secondary">Select Station/State:</label>
                    <p>Hydrabad</p>
                </div>
                <div class="col-12 col-md-4">
                    <label class="text-secondary">Station Code:</label>
                    <p>HYD</p>
                </div>
                <div class="col-12 col-md-3">
                    <p>Bill No</p>
                </div>
                <div class="col-12 col-md-3">
                    <p class="badge bg-primary">#BILL45678</p>
                </div>
                <div class="col-12 col-md-3">
                    <p>Own Vehicle Number:</p>
                </div>
                <div class="col-12 col-md-3">
                    <p class="badge bg-success">WB-45-TY8900</p>
                </div>
                <div class="col-12 col-md-3">
                    <p>Source:</p>
                </div>
                <div class="col-12 col-md-3">
                    <p class="badge bg-info">Hydrabad</p>
                </div>
                <div class="col-12 col-md-3">
                    <p>Destination:</p>
                </div>
                <div class="col-12 col-md-3">
                    <p class="badge bg-warning">Kolkata</p>
                </div>
                <hr>
                <form>
                    <div>
                        <h6>Loading</h6>
                        <div class="row form-group">
                            <div class="col-12 col-md-6">
                                <label>Arival Date/Time for Loading</label>
                                <input type="date" class="form-control">
                            </div>
                            <div class="col-12 col-md-6">
                                <label>Actual Date/Time of Loading</label>
                                <input type="date" class="form-control">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-12 col-md-4">
                                <label>Loading Charges</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="col-12 col-md-4">
                                <label>Loading Detention time</label>
                                <input type="date" class="form-control">
                            </div>
                            <div class="col-12 col-md-4">
                                <label>Charges</label>
                                <input type="text" class="form-control">
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div>
                        <h6>Unloading</h6>
                        <div class="row form-group">
                            <div class="col-12 col-md-6">
                                <label>Arival Date/Time for Reporting</label>
                                <input type="date" class="form-control">
                            </div>
                            <div class="col-12 col-md-6">
                                <label>Actual Date/Time of Unloading</label>
                                <input type="date" class="form-control">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-12 col-md-4">
                                <label>Unloading Charges</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="col-12 col-md-4">
                                <label>Unloading Detention time</label>
                                <input type="date" class="form-control">
                            </div>
                            <div class="col-12 col-md-4">
                                <label>Unloading Detention Charges</label>
                                <input type="text" class="form-control">
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="mt-2">
                        <h6>Other Charges</h6>
                        <div>
                            <p>Addition</p>
                            <div class="table-responsive mt-4">
                                <table class="table table-hover invoice-table mb-0">
                                    <thead>
                                        <tr>
                                            <th>Addition Head</th>
                                            <th>Amount</th>
                                            <th>Recorded By</th>
                                            <th>Date</th>
                                            <th>Notes</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                Fixed Fee
                                            </td>
                                            <td>7000</td>
                                            <td>Vinay Goyel</td>
                                            <td>
                                                12/11/2025
                                            </td>
                                            <td>Lorem ipsum doller sit amet.</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Loading/Unloading Charge
                                            </td>
                                            <td>1000</td>
                                            <td>Abhishek Nayak</td>
                                            <td>
                                                13/11/2025
                                            </td>
                                            <td>Lorem ipsum doller sit amet.</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Extra KM
                                            </td>
                                            <td>400</td>
                                            <td>Nandan Biswas</td>
                                            <td>
                                                14/11/2025
                                            </td>
                                            <td>Lorem ipsum doller sit amet.</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Tax
                                            </td>
                                            <td>200</td>
                                            <td>Nilay Ray</td>
                                            <td>
                                                15/11/2025
                                            </td>
                                            <td>Lorem ipsum doller sit amet.</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="mt-2">
                            <p>Deduction</p>
                            <div class="table-responsive mt-4">
                                <table class="table table-hover invoice-table mb-0">
                                    <thead>
                                        <tr>
                                            <th>Deduction Head</th>
                                            <th>Amount</th>
                                            <th>Recorded By</th>
                                            <th>Date</th>
                                            <th>Notes</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                TDS
                                            </td>
                                            <td>7000</td>
                                            <td>Vinay Goyel</td>
                                            <td>
                                                12/11/2025
                                            </td>
                                            <td>Lorem ipsum doller sit amet.</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Mamul
                                            </td>
                                            <td>3000</td>
                                            <td>Vinay Goyel</td>
                                            <td>
                                                12/11/2025
                                            </td>
                                            <td>Lorem ipsum doller sit amet.</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                P/R
                                            </td>
                                            <td>700</td>
                                            <td>Vinay Goyel</td>
                                            <td>
                                                12/11/2025
                                            </td>
                                            <td>Lorem ipsum doller sit amet.</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Prev. Adjustments
                                            </td>
                                            <td>1000</td>
                                            <td>Vinay Goyel</td>
                                            <td>
                                                12/11/2025
                                            </td>
                                            <td>Lorem ipsum doller sit amet.</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="mt-2">
                        <ul class="list-group mt-3">
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between">
                                    <p class="mb-0">Total Addition</p>
                                    <p class="mb-0"><strong>5000.00</strong></p>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between">
                                    <p class="mb-0">Total Deduction</p>
                                    <p class="mb-0"><strong>10000.00</strong></p>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between">
                                    <p class="mb-0">Net Payable</p>
                                    <p class="mb-0"><strong>15000.00</strong></p>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between">
                                    <p class="mb-0">Net Amount Paid</p>
                                    <p class="mb-0"><strong>3000.00</strong></p>
                                </div>
                            </li>
                            <li class="list-group-item bg-light">
                                <div class="d-flex justify-content-between align-items-center">
                                    <p class="mb-0">
                                        <span class="d-block">Due Balance</span>
                                    </p>
                                    <p class="mb-0"><strong>9000.00</strong></p>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="row mt-2">
                        <div class="col-12">
                            <label>Remarks</label>
                            <textarea class="form-control" rows="4"></textarea>
                        </div>
                    </div>
                    <div class="text-end mt-2">
                        <a href="bill-finalise.php" target="_blank" class="btn btn-primary">Submit</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--add vehicle modal-->
<div class="modal fade" id="addVeh" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Vehicle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="uil uil-times"></i></button>
            </div>
            <div class="modal-body">
                <div class="form-group row pb-2">
                    <div class="col-12 col-md-3">
                        <label>Vehicle Number (VC)</label>
                    </div>
                    <div class="col-12 col-md-9">
                        <div class="input-group">
                            <input type="text" class="form-control" id="vc_no" placeholder="27AAACT2727Q1ZW" aria-describedby="fetchData">
                            <!--<span class="input-group-text" id="vc"><i class="uil uil-search me-1"></i>Fetch Info</span>-->
                            <button class="btn btn-primary" style="text-transform: capitalize;" type="button" id="fetchData"><i class="uil uil-search me-1"></i>Fetch Info</button>
                        </div>
                        <small class="text-primary">Format : 27AAACT2727Q1ZW</small>
                        <!---->
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-12 col-md-6">
                        <h6 class="mb-0">Vahan Details</h6>
                    </div>
                    <div class="col-12 col-md-6 text-end">
                        <button class="btn btn-primary" data-bs-dismiss="modal">Save</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="table-responsive">
                            <table class="table table-hover veh-det-table invoice-table mb-0">
                                <tbody>
                                    <tr>
                                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Owner Name</th>
                                        <td class="pt-1 pb-1 ps-2 pe-2">Mohammad Hafiz</td>
                                    </tr>
                                    <tr>
                                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Address</th>
                                        <td class="pt-1 pb-1 ps-2 pe-2">H.NO.62, Vill Hathipur Chittu, PS Kundarki, Teh. Bilari, Moradabad — Ph: 9588416786, 999999</td>
                                    </tr>
                                    <tr>
                                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Status</th>
                                        <td class="pt-1 pb-1 ps-2 pe-2">Active</td>
                                    </tr>
                                    <tr>
                                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Registration Date</th>
                                        <td class="pt-1 pb-1 ps-2 pe-2">19/03/2015</td>
                                    </tr>
                                    <tr>
                                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Fitness Certificate Expiry</th>
                                        <td class="pt-1 pb-1 ps-2 pe-2">10/04/2026</td>
                                    </tr>
                                    <tr>
                                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Insurance Expiry</th>
                                        <td class="pt-1 pb-1 ps-2 pe-2">H.NO.62, Vill Hathipur Chittu, PS Kundarki, Teh. Bilari, Moradabad — Ph: 9588416786, 999999</td>
                                    </tr>
                                    <tr>
                                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-info-circle text-danger me-4" aria-hidden="true"></i>Tax Expiry</th>
                                        <td class="pt-1 pb-1 ps-2 pe-2">28/02/2026</td>
                                    </tr>
                                    <tr>
                                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Permit Expiry</th>
                                        <td class="pt-1 pb-1 ps-2 pe-2">19/03/2015</td>
                                    </tr>
                                    <tr>
                                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>PUCC Expiry</th>
                                        <td class="pt-1 pb-1 ps-2 pe-2">19/03/2015</td>
                                    </tr>
                                    <tr>
                                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>National Permit Expiry</th>
                                        <td class="pt-1 pb-1 ps-2 pe-2">19/03/2015</td>
                                    </tr>
                                    <tr>
                                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Permit Type</th>
                                        <td class="pt-1 pb-1 ps-2 pe-2">National Permit (Heavy Goods Vehicle)</td>
                                    </tr>
                                    <tr>
                                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>PUCC Number</th>
                                        <td class="pt-1 pb-1 ps-2 pe-2">UP02101060016371</td>
                                    </tr>
                                    <tr>
                                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Permit Number</th>
                                        <td class="pt-1 pb-1 ps-2 pe-2">UP/21/112/GOOD/2017/26595</td>
                                    </tr>
                                    <tr>
                                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Insurer</th>
                                        <td class="pt-1 pb-1 ps-2 pe-2">The New India Assurance Company Ltd.</td>
                                    </tr>
                                    <tr>
                                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Insurance Number</th>
                                        <td class="pt-1 pb-1 ps-2 pe-2">34040131240100004570</td>
                                    </tr>
                                    <tr>
                                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Financier</th>
                                        <td class="pt-1 pb-1 ps-2 pe-2">Kogta Financial (I) Ltd.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="table-responsive">
                            <table class="table table-hover invoice-table mb-0">
                                <tbody>
                                    <tr>
                                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Class</th>
                                        <td class="pt-1 pb-1 ps-2 pe-2">Goods Carrier (HGV)</td>
                                    </tr>
                                    <tr>
                                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Body Type</th>
                                        <td class="pt-1 pb-1 ps-2 pe-2">Truck (Closed Body)</td>
                                    </tr>
                                    <tr>
                                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Fuel Type</th>
                                        <td class="pt-1 pb-1 ps-2 pe-2">Diesel</td>
                                    </tr>
                                    <tr>
                                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Chassis Number Date</th>
                                        <td class="pt-1 pb-1 ps-2 pe-2">MAT388062E5P14305</td>
                                    </tr>
                                    <tr>
                                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Engine Number</th>
                                        <td class="pt-1 pb-1 ps-2 pe-2">41L84194947</td>
                                    </tr>
                                    <tr>
                                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Manufacturer</th>
                                        <td class="pt-1 pb-1 ps-2 pe-2">Tata Motors Ltd.</td>
                                    </tr>
                                    <tr>
                                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Model</th>
                                        <td class="pt-1 pb-1 ps-2 pe-2">LPT1613/62TCBSII</td>
                                    </tr>
                                    <tr>
                                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Norms Type</th>
                                        <td class="pt-1 pb-1 ps-2 pe-2">EURO 2</td>
                                    </tr>
                                    <tr>
                                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Gross Vehicle Weight</th>
                                        <td class="pt-1 pb-1 ps-2 pe-2">18500</td>
                                    </tr>
                                    <tr>
                                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Unladen Weight</th>
                                        <td class="pt-1 pb-1 ps-2 pe-2">8850</td>
                                    </tr>
                                    <tr>
                                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Vehicle Category</th>
                                        <td class="pt-1 pb-1 ps-2 pe-2">HGV</td>
                                    </tr>
                                    <tr>
                                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Wheelbase</th>
                                        <td class="pt-1 pb-1 ps-2 pe-2">6200</td>
                                    </tr>
                                    <tr>
                                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>Commercial FASTag</th>
                                        <td class="pt-1 pb-1 ps-2 pe-2">Yes</td>
                                    </tr>
                                    <tr>
                                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>FASTag ID</th>
                                        <td class="pt-1 pb-1 ps-2 pe-2">34161FA820328EE831791140</td>
                                    </tr>
                                    <tr>
                                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>TID</th>
                                        <td class="pt-1 pb-1 ps-2 pe-2">E200341201360400001A47AA8</td>
                                    </tr>
                                    <tr>
                                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-4 text-success" aria-hidden="true"></i>FASTag Issue Date</th>
                                        <td class="pt-1 pb-1 ps-2 pe-2">2024-04-02</td>
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
<div class="modal fade" id="changeStatus" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Change Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="uil uil-times"></i></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row form-group">
                        <div class="col-12 col-md-3">
                            <label>Status <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-12 col-md-9">
                            <select class="form-select">
                                <option>Choose</option>
                                <option>Reported at Loading Point</option>
                                <option>On the Way</option>
                                <option>Reported at Unloading Point</option>
                                <option>Empty</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script src="{{ asset('customjs/trip/show.js?v=1.0') }}"></script>
@endsection
