@extends('layouts.app')

@section('css')

<link rel="stylesheet" href="{{ asset('css/RTO/create.css') }}">



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
                            <h5>Edit RTO Checkpoint</h5>
                        </div>
                    </div>
                </div>
              </div>

                <div class="addroute-bd">
                  <div class="container-fluid">

                    @if($hasRoutes)
                        <div class="alert alert-warning">
                            This RTO is linked with routes. Charges fields are locked!
                        </div>
                    @endif

                    <form action="{{route('rto.update')}}" method="POST" id="editForm">
                        @csrf
                        
                        <input type="hidden" name="rtoid" id="edit_rtoid_input" value="{{ $rto->id }}">
                        
                        <div class="form-group row pb-1">
                            <div class="col-12 col-md-3">
                                <label>RTO Checkpoint Name <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-12 col-md-6">
                                <input type="text" name="rto_name" value="{{ old('rto_name', $rto->name) }}" class="form-control">
                                <small class="error text-danger" id="edit_rto_name_error"></small>
                            </div>
                        </div>
                        
                        <!-- State -->
                        <div class="form-group row">
                            <div class="col-12 col-md-3">
                                <label>State <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-12 col-md-6">
                                <select class="form-select select2 dependent-select" name="state_id" id="gstState" data-target="gstCity">
                                    <option value="">Choose..</option>
                                    @foreach ($states as $state)
                                        <option value="{{ $state->id }}" data-url="{{ route('getcities', $state->id) }}"
                                            {{ $state->id == $rto->state_id ? 'selected' : '' }}>
                                            {{ $state->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="error text-danger" id="edit_state_id_error"></small>
                            </div>
                        </div>
                        
                        
                        <!-- City -->
                        <div class="form-group row">
                            <div class="col-12 col-md-3">
                              <label>City <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-12 col-md-6">
                              <select class="form-select select2" name="city_id" id="gstCity">
                                <option value="">Choose..</option>
                                @php
                                    $cities = optional($rto->state)->cities;
                                @endphp
                                
                                @if($cities && $cities->count())
                                    @foreach($cities as $city)
                                        <option value="{{$city->id}}" @selected($city->id === $rto->city_id)>{{$city->name}}</option>
                                    @endforeach
                                @endif
                              </select>
                              <small class="error text-danger" id="edit_city_id_error"></small>
                            </div>
                        </div>
                        
                        
                        <div class="form-group row pb-1">
                            <div class="col-12 col-md-3">
                                <label>Embed Map Location <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-12 col-md-6">
                                <input type="text" name="embed_map_location" value="{{ old('embed_map_location', $rto->embed_map_location) }}" class="form-control">
                                <small class="error text-danger" id="edit_embed_map_location_error"></small>
                            </div>
                        </div>
                        
                        
                        <div class="form-group row pb-1">
                          <div class="col-12 col-md-3">
                            <label>Charge For Large Truck </label>
                          </div>
                          <div class="col-12 col-md-6">
                              <!--<input type="text" class="form-control">-->
                              <div class="input-group mb-3">
                                  <span class="input-group-text" id="rate">₹</span>
                                  <input type="text" name="charge_for_large_truck" value="{{ old('charge_for_large_truck', $rto->charge_for_large_truck) }}" class="form-control decimalonly text-end" placeholder="0.00" aria-describedby="rate" {{ $hasRoutes ? 'disabled' : '' }}>
                                  <small class="error text-danger" id="edit_large_vehicle_charge_error"></small>
                              </div>
                          </div>
                        </div>
                      
                        <div class="form-group row pb-1">
                          <div class="col-12 col-md-3">
                            <label>Charge For Medium Truck</label>
                          </div>
                          <div class="col-12 col-md-6">
                              <!--<input type="text" class="form-control">-->
                              <div class="input-group mb-3">
                                  <span class="input-group-text" id="rate">₹</span>
                                  <input type="text" name="charge_for_medium_truck" value="{{ old('charge_for_medium_truck', $rto->charge_for_medium_truck) }}" class="form-control decimalonly text-end" placeholder="0.00" aria-describedby="rate" {{ $hasRoutes ? 'disabled' : '' }}>
                                  <small class="error text-danger" id="edit_charge_for_medium_truck_error"></small>
                              </div>
                          </div>
                        </div>
                      
                        <div class="form-group row pb-1">
                          <div class="col-12 col-md-3">
                            <label>Charge For Small Truck</label>
                          </div>
                          <div class="col-12 col-md-6">
                              <!--<input type="text" class="form-control">-->
                              <div class="input-group mb-3">
                                  <span class="input-group-text" id="rate">₹</span>
                                  <input type="text" name="charge_for_small_truck" value="{{ old('charge_for_small_truck', $rto->charge_for_small_truck) }}" class="form-control decimalonly text-end" placeholder="0.00" aria-describedby="rate" {{ $hasRoutes ? 'disabled' : '' }}>
                                  <small class="error text-danger" id="edit_charge_for_small_truck_error"></small>
                              </div>
                          </div>
                        </div>
                      
                        <div class="form-group row pb-">
                          <div class="col-12 col-md-3"><label>Status <span class="text-danger">*</span></label></div>

                          <div class="col-12 col-md-6 d-flex">
                              <div class="form-check d-flex me-2">
                                  <input class="form-check-input" type="radio" name="status" id="exampleRadios1" value="Active" {{ old('status', $rto->status) == 'Active' ? 'checked' : '' }} >
                                  <label class="form-check-label" for="exampleRadios1">
                                      Active
                                  </label>
                              </div>

                              <div class="form-check d-flex">
                                  <input class="form-check-input" type="radio" name="status" id="exampleRadios2" value="Inactive" {{ old('status', $rto->status) == 'Inactive' ? 'checked' : '' }} >
                                  <label class="form-check-label" for="exampleRadios2">
                                      Inactive
                                  </label>
                              </div>     
                          </div>
                          <small class="error text-danger" id="edit_status_error"></small>
                          
                        </div>
                      
                      
                        <div class="text-right">
                          <button class="btn btn-dark mb-4" id="editBtn">Save</button>
                          
                          <a href="{{ route('rto.index') }}" class="btn btn-danger mb-4"> Close </a>
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
var RTOS = "{{ route('rto.index') }}";
</script>

<script type="text/javascript" src="{{asset('customjs/rto/edit.js')}}"></script>

@endsection





