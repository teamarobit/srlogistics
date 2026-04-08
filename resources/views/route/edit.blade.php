@extends('layouts.app')

@section('css')

<link rel="stylesheet" href="{{ asset('public/css/add-routes.css') }}">

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
                                <h5>Edit Routes</h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="addroute-bd">
                    <div class="container-fluid">

                        <form action="{{route('route.update')}}" method="POST" id="editForm">
                            @csrf
                        
                            <input type="hidden" name="routeid" id="edit_routeid_input" value="{{ $route->id }}">
    
                          <div class="form-group row pb-2">
                            <div class="col-12 col-md-3">
                                <label>Route Name <span class="text-danger">*</span></label> 
                            </div>
                            <div class="col-12 col-md-6">
                                <span class="form-control bg-light route-name-span">{{ $route->name ?? '' }}</span>
                                <input type="hidden" name="route_name" value="{{ $route->name ?? '' }}" class="route-name" />
                                <small class="error text-danger" id="edit_route_name_error"></small>
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
                                                    {{ (isset($route) && $route->source_state_id == $state->id) ? 'selected' : '' }}>
                                                    {{ $state->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <small class="error text-danger" id="edit_source_state_id_error"></small>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <select class="form-select select2-tags" name="source_city_id" id="sourceCity">
                                            <option value="">Choose..</option>
                                        </select>
                                        <small class="error text-danger" id="edit_source_city_id_error"></small>
                                    </div>
                                </div>
                            </div>
                            
                          </div>
                          
                          
                          
                          
                          
                          
                          
                          
                            <div class="row form-group">
                                <div class="col-12">
                                    <div class="add-stop-container">
                            
                                        @if($route->midpoints->count())
                                            @foreach($route->midpoints as $midpoint)
                                                
                                                <div class="add-stop mt-2">
                                                    <input type="hidden" name="midpoint_id[]" value="{{ $midpoint->id ?? '' }}">
                                                    
                                                    <div class="row align-items-center">
                            
                                                        <div class="col-12 col-md-3">
                                                            <label class="mb-md-0">Midpoint</label>
                                                        </div>
                            
                                                        {{-- State Dropdown --}}
                                                        <div class="col-12 col-md-3">
                                                            <select class="form-select select2 midpointState"
                                                                    name="midpoint_state_id[]">
                                                                <option value="">Choose..</option>
                                                                @foreach ($states as $state)
                                                                    <option value="{{ $state->id }}"
                                                                        {{ $midpoint->state_id == $state->id ? 'selected' : '' }}>
                                                                        {{ $state->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                            
                                                        {{-- City Dropdown --}}
                                                        <div class="col-12 col-md-3">
                                                            <select class="form-select select2 midpointCity"
                                                                    name="midpoint_city_id[]">
                                                                <option value="">Choose..</option>
                            
                                                                @if($midpoint->state)
                                                                    @foreach($midpoint->state->cities as $city)
                                                                        <option value="{{ $city->id }}"
                                                                            {{ $midpoint->city_id == $city->id ? 'selected' : '' }}>
                                                                            {{ $city->name }}
                                                                        </option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                            
                                                        <div class="col-12 col-md-1 text-center">
                                                            <i class="uil uil-trash-alt text-danger removeMidpoint"
                                                               style="cursor:pointer;"></i>
                                                        </div>
                            
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            {{-- If no midpoints exist --}}
                                            <div class="add-stop">
                                                <div class="row align-items-center">
                            
                                                    <div class="col-12 col-md-3">
                                                        <label class="mb-md-0">Midpoint</label>
                                                    </div>
                            
                                                    <div class="col-12 col-md-3">
                                                        <select class="form-select select2 midpointState"
                                                                name="midpoint_state_id[]">
                                                            <option value="">Choose..</option>
                                                            @foreach ($states as $state)
                                                                <option value="{{ $state->id }}">
                                                                    {{ $state->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                            
                                                    <div class="col-12 col-md-3">
                                                        <select class="form-select select2 midpointCity"
                                                                name="midpoint_city_id[]">
                                                            <option value="">Choose..</option>
                                                        </select>
                                                    </div>
                            
                                                    <div class="col-12 col-md-1 text-center">
                                                        <i class="uil uil-trash-alt text-danger removeMidpoint"
                                                           style="cursor:pointer;"></i>
                                                    </div>
                            
                                                </div>
                                            </div>
                                        @endif
                            
                                    </div>
                            
                                    <a href="javascript:void(0)" class="btn btn-secondary add-stop-btn">
                                        <i class="uil uil-plus me-1"></i>Midpoint
                                    </a>
                            
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
                                                    {{ (isset($route) && $route->destination_state_id == $state->id) ? 'selected' : '' }}>
                                                    {{ $state->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <small class="error text-danger" id="edit_destination_state_id_error"></small>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <select class="form-select select2-tags" name="destination_city_id" id="destinationCity">
                                            <option value="">Choose..</option>
                                        </select>
                                        <small class="error text-danger" id="edit_destination_city_id_error"></small>
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
                                      <input type="text" name="fixed_km" value="{{ old('fixed_km', $route->fixed_km) }}" class="form-control decimalonly" aria-describedby="distance">
                                      <span class="input-group-text" id="distance">KM</span>
                                  </div>
                                  <small class="error text-danger" id="edit_fixed_km_error"></small>
                              </div>
                          </div>
                          
                          <div class="form-group row pb-2">
                            <div class="col-12 col-md-3">
                                <label>Transit Time <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="row">
                                    <div class="form-floating col-6">
                                        <input type="text" name="transit_time_days" value="{{ old('transit_time_days', $route->transit_time_days) }}" class="form-control numericonly" id="transitTimeDaysInput" >
                                        <label for="transitTimeDaysInput">Days</label>
                                        <small class="error text-danger" id="edit_transit_time_days_error"></small>
                                    </div>
                                    
                                    
                                    <div class="form-floating col-6">
                                        <input type="text" name="transit_time_hrs" value="{{ old('transit_time_hrs', $route->transit_time_hrs) }}" class="form-control numericonly" id="transitTimeHrsInput" >
                                        <label for="transitTimeHrsInput">Hrs</label>
                                        
                                    </div>
                                </div>
                                <small class="error text-danger" id="edit_transit_time_hrs_error"></small>
                            </div>
                          </div>
                          
                          
                          <div class="form-group row pb-2">
                            <div class="col-12 col-md-3">
                                <label>Fixed Diesel BS-3 & BS-4 <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="input-group">
                                    <input type="text" name="fixed_diesel_bs3_bs4" value="{{ old('fixed_diesel_bs3_bs4', $route->fixed_diesel_bs3_bs4) }}" class="form-control decimalonly" aria-describedby="distance">
                                    <span class="input-group-text" id="distance">LTR</span>
                                </div>
                                <small class="error text-danger" id="edit_fixed_diesel_bs3_bs4_error"></small>
                            </div>
                          </div>
                          
                          
                          
                          <div class="form-group row pb-2">
                            <div class="col-12 col-md-3">
                                <label>Fixed Diesel BS-6 <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="input-group">
                                    <input type="text" name="fixed_diesel_bs6" value="{{ old('fixed_diesel_bs6', $route->fixed_diesel_bs6) }}" class="form-control decimalonly" aria-describedby="bs6">
                                    <span class="input-group-text" id="bs6">LTR</span>
                                </div>
                                <small class="error text-danger" id="edit_fixed_diesel_bs6_error"></small>
                            </div>
                          </div>
    
                          
    
                          <div class="form-group row pb-1">
                              <div class="col-12 col-md-3">
                                <label>Fixed Driver Advance <span class="text-danger">*</span></label>
                              </div>
                              <div class="col-12 col-md-6">
                                  <!--<input type="text" class="form-control">-->
                                  <div class="input-group">
                                      <span class="input-group-text" id="driver">₹</span>
                                      <input type="text" name="fixed_driver_advance" value="{{ old('fixed_driver_advance', $route->fixed_driver_advance) }}" class="form-control text-end decimalonly" placeholder="0.00" aria-describedby="driver">
                                      
                                  </div>
                                  <small class="error text-danger" id="edit_fixed_driver_advance_error"></small>
                              </div>
                          </div>
                        
                          
                        
                        
                        <div class="form-group row pb-1">
                              
                            <div class="col-12 col-md-3">
                                <label>Toll Stations <span class="text-danger">*</span></label>
                            </div>
                            
                            <div class="col-12 col-md-9 toll-wrapper">

                                @forelse($route->tollstations as $key => $toll)
                                <div class="row toll-row mb-2 d-flex position-relative">
                            
                                    <!-- Toll Select -->
                                    <div class="col-12 col-md-3">
                                        <div class="form-floating mb-3">
                                            <select name="tollstation_id[]" class="form-select toll-select">
                                                <option value="">Choose..</option>
                                                @foreach ($tollstations as $station)
                                                    <option value="{{ $station->id }}"
                                                        {{ $station->id == $toll->tollstation_id ? 'selected' : '' }}>
                                                        {{ $station->station_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <label>Toll Stations</label>
                                        </div>
                                    </div>
                            
                                    <!-- Charges -->
                                    <div class="col-12 col-md-3 px-1">
                                        <div class="form-floating mb-3">
                                            <input type="text" name="toll_large[]" class="form-control toll-large"
                                                   value="{{ $toll->tollstation->large_vehicle_charge }}" disabled>
                                            <label>Large Vehicle Charge</label>
                                        </div>
                                    </div>
                            
                                    <div class="col-12 col-md-3 px-1">
                                        <div class="form-floating mb-3">
                                            <input type="text" name="toll_medium[]" class="form-control toll-medium"
                                                   value="{{ $toll->tollstation->medium_vehicle_charge }}" disabled>
                                            <label>Medium Vehicle Charge</label>
                                        </div>
                                    </div>
                            
                                    <div class="col-12 col-md-3 px-1">
                                        <div class="form-floating mb-3">
                                            <input type="text" name="toll_small[]" class="form-control toll-small"
                                                   value="{{ $toll->tollstation->small_vehicle_charge }}" disabled>
                                            <label>Small Vehicle Charge</label>
                                        </div>
                                    </div>
                            
                                    <!-- Delete -->
                                    <div class="add-remove01btn del-row">
                                        <span class="removefield removeTollField text-danger" style="cursor:pointer; font-size: 20px;">
                                            <i class="uil uil-trash-alt"></i>
                                        </span>
                                    </div>
                                    
                                    <!--<div class="col-12 col-md-1 text-center">-->
                                    <!--    <span class="removeTollField text-danger" style="cursor:pointer; font-size: 20px;">-->
                                    <!--        <i class="uil uil-trash-alt"></i>-->
                                    <!--    </span>-->
                                    <!--</div>-->
                            
                                </div>
                                @empty
                                    {{-- fallback empty row (for create OR no tolls yet) --}}
                                    <div class="row toll-row mb-2 d-flex">
                                        @include('route.empty-toll-row')
                                    </div>
                                @endforelse
                                <small class="error text-danger tollstation-error"></small>
                                
                                <div class="add-remove01btn mt-2">
                                    <span class="addTollField btn-success" style="cursor:pointer;">Add</span>
                                </div>
                            </div>
                            
                              
                        </div>
                            
                        
                        
                        <div class="form-group row pb-1">
                              
                            <div class="col-12 col-md-3">
                                <label>RTO Checkpoint & Expenses <span class="text-danger">*</span></label>
                            </div>
                            
                            <div class="col-12 col-md-9 rto-wrapper">
                                
                                @forelse($route->rtos as $key => $routeRto)
                                <div class="row rto-row mb-2 position-relative"> 
                            
                                    <!-- RTO Select -->
                                    <div class="col-12 col-md-3">
                                        <div class="form-floating mb-3">
                                            <select name="rto_id[]" class="form-select rto-select">
                                                <option value="">Choose..</option>
                                                @foreach ($rtos as $rto)
                                                    <option value="{{ $rto->id }}"
                                                        {{ $rto->id == $routeRto->rto_id ? 'selected' : '' }}>
                                                        {{ $rto->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <label>RTO</label>
                                        </div>
                                    </div>
                            
                                    <!-- Charges -->
                                    <div class="col-12 col-md-3 px-1">
                                        <div class="form-floating mb-3">
                                            <input type="text"
                                                   name="rto_large[]"
                                                   class="form-control rto-large"
                                                   value="{{ $routeRto->rto->charge_for_large_truck }}" disabled>
                                            <label>Large Vehicle Charge</label>
                                        </div>
                                    </div>
                            
                                    <div class="col-12 col-md-3 px-1">
                                        <div class="form-floating mb-3">
                                            <input type="text"
                                                   name="rto_medium[]"
                                                   class="form-control rto-medium"
                                                   value="{{ $routeRto->rto->charge_for_medium_truck }}" disabled>
                                            <label>Medium Vehicle Charge</label>
                                        </div>
                                    </div>
                            
                                    <div class="col-12 col-md-3 px-1">
                                        <div class="form-floating mb-3">
                                            <input type="text"
                                                   name="rto_small[]"
                                                   class="form-control rto-small"
                                                   value="{{ $routeRto->rto->charge_for_small_truck }}" disabled>
                                            <label>Small Vehicle Charge</label>
                                        </div>
                                    </div>
                            
                                    <!-- Delete -->
                                    <div class="add-remove01btn del-row">
                                        <span class="removefield removeRtoField text-danger" style="cursor:pointer;font-size:20px;">
                                            <i class="uil uil-trash-alt"></i>
                                        </span>
                                    </div>
                            
                                </div>
                                @empty
                                    {{-- fallback empty row --}}
                                    <div class="row rto-row mb-2">
                                        @include('route.empty-rto-row')
                                    </div>
                                @endforelse
                                
                                <small class="error text-danger rto-error"></small>
                                
                                <div class="add-remove01btn mt-2">
                                  <span class="addRtoField btn-success" style="cursor:pointer;">Add</span>
                                </div>
                                
                            </div>
                            
                              
                        </div>
                        
                        
                        <div class="form-group row pb-1">
    
                              <div class="col-12 col-md-3">
                                  <label>Route Type <span class="text-danger">*</span></label>
                              </div>
    
                              <div class="col-12 col-md-6">
                                  <div class="d-flex flex-wrap">
                                      <div class="form-check d-flex me-2">
                                          <input class="form-check-input" type="radio" name="route_type" id="line" value="Line" {{ (isset($route) && $route->route_type == 'Line') ? 'checked' : '' }}>
                                          <label class="form-check-label" for="line">
                                              Line
                                          </label>
                                      </div>
        
                                      <div class="form-check d-flex">
                                          <input class="form-check-input" type="radio" name="route_type" id="local" value="Local" {{ (isset($route) && $route->route_type == 'Local') ? 'checked' : '' }}>
                                          <label class="form-check-label" for="local">
                                              Local
                                          </label>
                                      </div>  
                                  </div>
                                  
                                  <small class="error text-danger" id="edit_route_type_error"></small>
                              </div>
                              
                        </div>
                            
                            
                            
                        <div class="form-group row pb-1">
    
                              <div class="col-12 col-md-3">
                                  <label>Status <span class="text-danger">*</span></label>
                              </div>
    
                              <div class="col-12 col-md-6 d-flex">
                                  <div class="form-check d-flex me-2">
                                      <input class="form-check-input" type="radio" name="status" id="exampleRadios1" value="Active" {{ (isset($route) && $route->status == 'Active') ? 'checked' : '' }}>
                                      <label class="form-check-label" for="exampleRadios1">
                                          Active
                                      </label>
                                  </div>
    
                                  <div class="form-check d-flex">
                                      <input class="form-check-input" type="radio" name="status" id="exampleRadios2" value="Inactive" {{ (isset($route) && $route->status == 'Inactive') ? 'checked' : '' }}>
                                      <label class="form-check-label" for="exampleRadios2">
                                          Inactive
                                      </label>
                                  </div>    
                              </div>
                              <small class="error text-danger" id="edit_status_error"></small>
                        </div>
    
                        <div class="form-group row pb-1">
                              <div class="col-12 col-md-3">
                                <label>Remarks</label>
                            </div>
                            <div class="col-12 col-md-6">
                                <textarea name="remarks" class="form-control" rows="3" placeholder="">{{ old('remarks', $route->remarks) }}</textarea>
                                <small class="error text-danger" id="edit_remarks_error"></small>
                            </div>
                        </div>                         
                          
                        <div class="text-right">
                            <button class="btn btn-dark mb-4" id="editBtn">Save</button>
                              
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

window.editSourceCityId = "{{ $route->source_city_id ?? '' }}";
window.editDestinationCityId = "{{ $route->destination_city_id ?? '' }}";

</script>

<script type="text/javascript" src="{{asset('public/customjs/route/edit.js')}}"></script>

<script type="text/javascript" src="{{asset('public/js/add-routes.js')}}"></script>

@endsection





