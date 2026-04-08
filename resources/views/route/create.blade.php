@extends('layouts.app')

@section('css')

<link rel="stylesheet" href="{{ asset('css/add-routes.css') }}">

<style>
.add-remove01btn.del-row{
    position: absolute;
    right: -45px;
    top: 14px;
}

.select2-selection.is-invalid {
    border-color: #dc3545 !important;
}
</style>

@endsection

@section('content')

<div class="layout-wrapper">
    @include('includes.header')

    <div class="wrapper srlog-bdwrapper">
        <div class="side-wrap">
            @include('includes.leftbar')
            
            <div class="main-wrap">

                <div class="topbar">
                    <div class="container-fluid page-head">
                        <div class="row align-items-end">
                            <div class="col-12 col-md-6">
                                <h5>Add Routes</h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="addroute-bd">
                    <div class="container-fluid">

                        <form action="{{route('route.save')}}" method="POST" id="addForm">
                            @csrf
    
                          <div class="form-group row pb-2">
                            <div class="col-12 col-md-3">
                                <label>Route Name <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-12 col-md-6">
                                <span class="form-control bg-light route-name-span"></span>
                                <input type="hidden" name="route_name" class="route-name" value="" />
                                <small class="error text-danger" id="add_route_name_error"></small>
                            </div>
                          </div>
    
                          <div class="form-group row pb-1 align-items-center">
                            <div class="col-12 col-md-3">
                                <label>Source <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <select class="form-select select2 dependent-select" name="source_state_id" id="sourceState" data-target="sourceCity">
                                            <option value="">Choose..</option>
                                            @foreach ($states as $state)
                                                <option value="{{ $state->id }}" data-url="{{ route('getcities', $state->id) }}"
                                                    {{ old('state_id') == $state->id ? 'selected' : '' }}>
                                                    {{ $state->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <small class="error text-danger" id="add_source_state_id_error"></small>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <select class="form-select select2-tags" name="source_city_id" id="sourceCity">
                                            <option value="">Choose..</option>
                                        </select>
                                        <small class="error text-danger" id="add_source_city_id_error"></small>
                                    </div>
                                </div>
                            </div>
                            
                          </div>
                          
                          
                          
                          
                          
                          
                          <div class="row form-group">
                            <div class="col-12">
                                <div class="add-stop-container">
                                    
                                    <div class="add-stop"></div>
                                  
                                </div>
                                <a href="javascript:void(0)" class="btn btn-secondary add-stop-btn"><i class="uil uil-plus me-1"></i>Midpoint</a>
                            </div>
                          </div>
                          
                          
                          
                          
                          
                          
                          
                          
                          
    
                          <div class="form-group row pb-1 align-items-center">
                              <div class="col-12 col-md-3">
                                <label>Destination <span class="text-danger">*</span></label>
                              </div>
                              <div class="col-12 col-md-6">
                                  <div class="row">
                                    <div class="col-12 col-md-6">
                                        <select class="form-select select2 dependent-select" name="destination_state_id" id="destinationState" data-target="destinationCity">
                                            <option value="">Choose..</option>
                                            @foreach ($states as $state)
                                                <option value="{{ $state->id }}" data-url="{{ route('getcities', $state->id) }}"
                                                    {{ old('state_id') == $state->id ? 'selected' : '' }}>
                                                    {{ $state->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <small class="error text-danger" id="add_destination_state_id_error"></small>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <select class="form-select select2-tags" name="destination_city_id" id="destinationCity">
                                            <option value="">Choose..</option>
                                        </select>
                                        <small class="error text-danger" id="add_destination_city_id_error"></small>
                                    </div>
                                </div>
                              </div>
                              
                          </div>
    
                          <div class="form-group row pb-1">
                              <div class="col-12 col-md-3">
                                <label>Fixed KM <span class="text-danger">*</span></label>
                              </div>
                              <div class="col-12 col-md-6">
                                  <div class="input-group">
                                      <input type="text" name="fixed_km" class="form-control decimalonly" aria-describedby="distance">
                                      <span class="input-group-text" id="distance">KM</span>
                                  </div>
                                  <small class="error text-danger" id="add_fixed_km_error"></small>
                              </div>
                              
                          </div>
                          
                          <div class="form-group row pb-2">
                            <div class="col-12 col-md-3">
                                <label>Transit Time <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="row">
                                    <div class="form-floating col-6">
                                        <input type="text" name="transit_time_days" class="form-control numericonly" id="transitTimeDaysInput" >
                                        <label for="transitTimeDaysInput">Days</label>
                                        <small class="error text-danger" id="add_transit_time_days_error"></small>
                                    </div>
                                    
                                    <div class="form-floating col-6">
                                        <input type="text" name="transit_time_hrs" class="form-control numericonly" id="transitTimeHrsInput" >
                                        <label for="transitTimeHrsInput">Hrs</label>
                                        <small class="error text-danger" id="add_transit_time_hrs_error"></small>
                                    </div> 
                                    
                                </div>
                            </div>
                          </div>
                          
                          <div class="form-group row pb-2">
                            <div class="col-12 col-md-3">
                                <label>Fixed Diesel BS-3 & BS-4 <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="input-group">
                                    <input type="text" name="fixed_diesel_bs3_bs4" class="form-control decimalonly" aria-describedby="distance">
                                    <span class="input-group-text" id="distance">LTR</span>
                                </div>
                                <small class="error text-danger" id="add_fixed_diesel_bs3_bs4_error"></small>
                            </div>
                          </div>
                          
                          <div class="form-group row pb-2">
                            <div class="col-12 col-md-3">
                                <label>Fixed Diesel BS-6 <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="input-group">
                                    <input type="text" name="fixed_diesel_bs6" class="form-control decimalonly" aria-describedby="bs6">
                                    <span class="input-group-text" id="bs6">LTR</span>
                                </div>
                                <small class="error text-danger" id="add_fixed_diesel_bs6_error"></small>
                            </div>
                          </div>
    
                          
    
                          <div class="form-group row pb-1">
                              <div class="col-12 col-md-3">
                                <label>Fixed Driver Advance <span class="text-danger">*</span></label>
                              </div>
                              <div class="col-12 col-md-6">
                                  <!--<input type="text" class="form-control">-->
                                  <div class="input-group mb-3">
                                      <span class="input-group-text" id="driver">₹</span>
                                      <input type="text" name="fixed_driver_advance" class="form-control text-end decimalonly" placeholder="0.00" aria-describedby="driver">
                                  </div>
                                  <small class="error text-danger" id="add_fixed_driver_advance_error"></small>
                              </div>
                          </div>
                        
                          
                        
                        
                        <div class="form-group row pb-1">
                              
                            <div class="col-12 col-md-3">
                                <label>Toll Stations <span class="text-danger">*</span></label>
                            </div>
                            
                            <div class="col-12 col-md-9 toll-wrapper">
                                <div class="row toll-row mb-2 d-flex position-relative">
                                    
                                    <div class="col-12 col-md-3">
                                        <div class="form-floating mb-3">
                                            <select name="tollstation_id[]" id="floatingSelect" class="form-select toll-select">
                                                <option value="">Choose..</option>

                                                @foreach ($tollstations as $station)
                                                    <option value="{{ $station->id }}">
                                                        {{ $station->station_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <label for="floatingSelect">Toll Stations</label>
                                        </div>
                                    </div>
                                          
                                    <div class="col-12 col-md-3 px-1">
                                     <div class="form-floating mb-3">
                                        <input type="text" class="form-control toll-large" id="tollLarge" disabled>
                                        <label for="tollLarge">Large Vehicle Charge</label>
                                      </div>
                                    </div>
                                    
                                    <div class="col-12 col-md-3 px-1">
                                     <div class="form-floating mb-3">
                                        <input type="text" class="form-control toll-medium" id="tollMedium" disabled>
                                        <label for="tollMedium">Medium Vehicle Charge</label>
                                      </div>
                                    </div>
                                    
                                    <div class="col-12 col-md-3 px-1">
                                     <div class="form-floating mb-3">
                                        <input type="text" class="form-control toll-small" id="tollSmall" disabled>
                                        <label for="tollSmall">Small Vehicle Charge</label>
                                      </div>
                                    </div>
                                    
                                    <div class="add-remove01btn del-row">
                                        <span class="removefield removeTollField text-danger" style="cursor:pointer;font-size:20px;">
                                            <i class="uil uil-trash-alt"></i>
                                        </span>
                                    </div>
                                      
                                </div>
                                <!-- Error placeholder for tollstation array -->
                                <small class="error text-danger tollstation-error"></small>
                            </div>
                            
                            
                            <div class="add-remove01btn mt-2">
                                <span class="addTollField btn-success" style="cursor:pointer;">Add</span>
                            </div>
                              
                        </div>
                            
                        
                        
                        <div class="form-group row pb-1">
                              
                            <div class="col-12 col-md-3">
                                <label>RTO Checkpoint & Expenses <span class="text-danger">*</span></label>
                            </div>
                            
                            <div class="col-12 col-md-9 rto-wrapper">
                                
                                <div class="row rto-row mb-2 position-relative"> 
                                    
                                    <div class="col-12 col-md-3">
                                        <div class="form-floating mb-3">
                                            <select name="rto_id[]" id="floatingSelect" class="form-select rto-select">
                                                <option value="">Choose..</option>
                                                @foreach ($rtos as $rto)
                                                    <option value="{{ $rto->id }}">
                                                        {{ $rto->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <label for="floatingSelect">RTO</label>
                                        </div>
                                    </div>
                                    
                                    <div class="col-12 col-md-3 px-1">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control rto-large" id="rtoLarge" disabled>
                                            <label for="rtoLarge">Large Vehicle Charge</label>
                                        </div>
                                    </div>
                                    
                                    <div class="col-12 col-md-3 px-1">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control rto-medium" id="rtoMedium" disabled>
                                            <label for="rtoMedium">Medium Vehicle Charge</label>
                                        </div>
                                    </div>
                                    
                                    <div class="col-12 col-md-3 px-1">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control rto-small" id="rtoSmall" disabled>
                                            <label for="rtoSmall">Small Vehicle Charge</label>
                                        </div>
                                    </div>
                                    
                                    <div class="add-remove01btn del-row">
                                        <span class="removefield removeRtoField text-danger" style="cursor:pointer;font-size:20px;">
                                            <i class="uil uil-trash-alt"></i>
                                        </span>
                                    </div>
                                  
                                </div>
                                <!-- Error placeholder for rto array -->
                                <small class="error text-danger rto-error"></small>
                            </div>
                            
                            
                            <div class="add-remove01btn mt-2">
                              <span class="addRtoField btn-success" style="cursor:pointer;">Add</span>
                            </div>
                              
                        </div>
                        
                            
                        <div class="form-group row pb-1">
                              <div class="col-12 col-md-3">
                                  <label>Route Type <span class="text-danger">*</span></label>
                              </div>
    
                              <div class="col-12 col-md-6">
                                  <div class="d-flex flex-wrap">
                                      <div class="form-check d-flex me-2">
                                          <input class="form-check-input" type="radio" name="route_type" id="route_type1" value="Line" />
                                          <label class="form-check-label" for="route_type1">
                                              Line
                                          </label>
                                      </div>
        
                                      <div class="form-check d-flex">
                                          <input class="form-check-input" type="radio" name="route_type" id="route_type2" value="Local" />
                                          <label class="form-check-label" for="route_type2">
                                              Local
                                          </label>
                                      </div> 
                                  </div>
                                  <small class="error text-danger" id="add_route_type_error"></small>
                              </div>
                              
                        </div>  
                        
                            
                        <div class="form-group row pb-1">
                              <div class="col-12 col-md-3">
                                  <label>Status <span class="text-danger">*</span></label>
                              </div>
    
                              <div class="col-12 col-md-6">
                                  <div class="d-flex flex-wrap">
                                      <div class="form-check d-flex me-2">
                                          <input class="form-check-input" type="radio" name="status" id="exampleRadios1" value="Active" autocompleted="">
                                          <label class="form-check-label" for="exampleRadios1">
                                              Active
                                          </label>
                                      </div>
        
                                      <div class="form-check d-flex">
                                          <input class="form-check-input" type="radio" name="status" id="exampleRadios2" value="Inactive" autocompleted="">
                                          <label class="form-check-label" for="exampleRadios2">
                                              Inactive
                                          </label>
                                      </div> 
                                  </div>
                                  <small class="error text-danger" id="add_status_error"></small>
                              </div>
                              
                        </div>
                        
    
                        <div class="form-group row pb-1">
                              <div class="col-12 col-md-3">
                                <label>Remarks</label>
                            </div>
                            <div class="col-12 col-md-6">
                                <textarea name="remarks" class="form-control" rows="3" placeholder=""></textarea>
                                <small class="error text-danger" id="add_remarks_error"></small>
                            </div>
                        </div>                         
                          
                        <div class="text-right">
                            <button class="btn btn-dark mb-4" id="addBtn">Save</button>
                              
                            <a href="{{ route('route.index') }}" class="btn btn-danger mb-4"> Close </a>
                        </div>
    
                      </form>

                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
    

@endsection

@section('js')

<script>
var ROUTES = "{{ route('route.index') }}";

let states = @json($states);
let getCitiesUrlTemplate = "{{ route('getcities', ':id') }}";

</script>

<script type="text/javascript" src="{{asset('customjs/route/create.js')}}"></script>

<script type="text/javascript" src="{{asset('js/add-routes.js')}}"></script>

@endsection





