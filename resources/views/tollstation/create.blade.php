@extends('layouts.app')

@section('css')

<link rel="stylesheet" href="{{ asset('css/add-toll-master.css') }}">

<style>

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
                            <h5>Add Toll Station</h5>
                        </div>
                    </div>
                </div>
              </div>

                <div class="addroute-bd">
                  <div class="container-fluid">

                    <form action="{{route('tollstation.save')}}" method="POST" id="addForm">
                        @csrf
                        
                        <div class="form-group row pb-1">
                            <div class="col-12 col-md-3">
                                <label>Toll Station Name <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-12 col-md-6">
                                <input type="text" name="station_name" value="{{ old('station_name') }}" class="form-control">
                                <small class="error text-danger" id="add_station_name_error"></small>
                            </div>
                        </div>
                      
                        <div class="form-group row pb-1">
                            <div class="col-12 col-md-3">
                                <label>Toll Company <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-12 col-md-6">
                                <input type="text" name="toll_company" value="{{ old('toll_company') }}" class="form-control">
                                <small class="error text-danger" id="add_toll_company_error"></small>
                            </div>
                        </div>
                      
                        <!--<div class="form-group row pb-1">-->
                        <!--    <div class="col-12 col-md-3">-->
                        <!--        <label>Location <span class="text-danger">*</span></label>-->
                        <!--    </div>-->
                        <!--    <div class="col-12 col-md-6">-->
                        <!--        <input type="text" name="location" value="{{ old('location') }}" class="form-control">-->
                        <!--        <small class="error text-danger" id="add_location_error"></small>-->
                        <!--    </div>-->
                        <!--</div>-->
                        
                        
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
                                            {{ old('state_id') == $state->id ? 'selected' : '' }}>
                                            {{ $state->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="error text-danger" id="add_state_id_error"></small>
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
                              </select>
                              <small class="error text-danger" id="add_city_id_error"></small>
                            </div>
                        </div>
                        
                      
                        <div class="form-group row pb-1">
                            <div class="col-12 col-md-3">
                                <label>Embed Map Location <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-12 col-md-6">
                                <input type="text" name="embed_map_location" value="{{ old('embed_map_location') }}" class="form-control">
                                <small class="error text-danger" id="add_embed_map_location_error"></small>
                            </div>
                        </div>
                      
                        <div class="form-group row pb-1">
                            <div class="col-12 col-md-3">
                                <label>Address</label>
                            </div>
                            <div class="col-12 col-md-6">
                                <textarea name="address" class="form-control" rows="3" placeholder="">{{ old('address') }}</textarea>
                                <small class="error text-danger" id="add_address_error"></small>
                            </div>
                        </div> 
                      
                        <div class="form-group row pb-1">
                          <div class="col-12 col-md-3">
                            <label>Large Vehicle Charge </label>
                          </div>
                          <div class="col-12 col-md-6">
                              <!--<input type="text" class="form-control">-->
                              <div class="input-group mb-3">
                                  <span class="input-group-text" id="rate">₹</span>
                                  <input type="text" name="large_vehicle_charge" value="{{ old('large_vehicle_charge') }}" class="form-control decimalonly text-end" placeholder="0.00" aria-describedby="rate">
                                  <small class="error text-danger" id="add_large_vehicle_charge_error"></small>
                              </div>
                          </div>
                        </div>
                      
                        <div class="form-group row pb-1">
                          <div class="col-12 col-md-3">
                            <label>Medium Vehicle Charge</label>
                          </div>
                          <div class="col-12 col-md-6">
                              <!--<input type="text" class="form-control">-->
                              <div class="input-group mb-3">
                                  <span class="input-group-text" id="rate">₹</span>
                                  <input type="text" name="medium_vehicle_charge" value="{{ old('medium_vehicle_charge') }}" class="form-control decimalonly text-end" placeholder="0.00" aria-describedby="rate">
                                  <small class="error text-danger" id="add_medium_vehicle_charge_error"></small>
                              </div>
                          </div>
                        </div>
                      
                        <div class="form-group row pb-1">
                          <div class="col-12 col-md-3">
                            <label>Small Vehicle Charge</label>
                          </div>
                          <div class="col-12 col-md-6">
                              <!--<input type="text" class="form-control">-->
                              <div class="input-group mb-3">
                                  <span class="input-group-text" id="rate">₹</span>
                                  <input type="text" name="small_vehicle_charge" value="{{ old('small_vehicle_charge') }}" class="form-control decimalonly text-end" placeholder="0.00" aria-describedby="rate">
                                  <small class="error text-danger" id="add_small_vehicle_charge_error"></small>
                              </div>
                          </div>
                        </div>
                      
                        <div class="form-group row pb-">
                          <div class="col-12 col-md-3"><label>Status <span class="text-danger">*</span></label></div>

                          <div class="col-12 col-md-6">
                              <div class="d-flex flex-wrap">
                                  <div class="form-check d-flex me-2">
                                      <input class="form-check-input" type="radio" name="status" id="exampleRadios1" value="Active" {{ old('status') == 'Active' ? 'checked' : '' }} >
                                      <label class="form-check-label" for="exampleRadios1">
                                          Active
                                      </label>
                                  </div>
    
                                  <div class="form-check d-flex">
                                      <input class="form-check-input" type="radio" name="status" id="exampleRadios2" value="Inactive" {{ old('status') == 'Inactive' ? 'checked' : '' }} >
                                      <label class="form-check-label" for="exampleRadios2">
                                          Inactive
                                      </label>
                                  </div>    
                              </div>
                              <small class="error text-danger" id="add_status_error"></small>
                          </div>
                        </div>
                      
                      
                        <div class="text-right">
                          <button class="btn btn-dark mb-4" id="addBtn">Save</button>
                          
                          <a href="{{ route('tollstation.index') }}" class="btn btn-danger mb-4"> Close </a>
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
var TOLLSTATIONS = "{{ route('tollstation.index') }}";
</script>

<script type="text/javascript" src="{{asset('customjs/tollstation/create.js')}}"></script>

@endsection





