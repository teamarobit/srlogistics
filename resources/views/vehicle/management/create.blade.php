@extends('layouts.app')

@section('css')

<link rel="stylesheet" href="{{ asset('css/Vehicle/Management/create.css') }}">
<link rel="stylesheet" href="{{ asset('css/fleet/vehicle-details.css?v=1.0') }}">

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
                                <h5>Add Vehicle</h5>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="addroute-bd">
                      <div class="container-fluid">
                          <div class="row">
                              <div class="col-12 col-md-7">
                                  
                                <form action="{{route('vehiclemanagement.save')}}" method="POST" id="addForm">
                                    @csrf
                                    
                                    <div class="form-group row pb-2">
                                        <div class="col-12 col-md-4">
                                            <label>Vehicle Number (VC) <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-12 col-md-8">
                                            <div class="input-group">
                                              <input type="text" name="vc_no" id="vc_no" class="form-control" placeholder="27AAACT2727Q1ZW">
                                              <button class="btn btn-primary fetch-data-btn" style="text-transform: capitalize;" type="button" id="fetchData"><i class="uil uil-search me-1"></i>Fetch Info</button>
                                            </div>
                                            <small class="text-primary">Format : 27AAACT2727Q1ZW</small>
                                            <small class="error text-danger d-block" id="add_vc_no_error"></small>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="form-group row">
                                          <div class="col-12 col-md-4">
                                              <label>Ownership Type <span class="text-danger">*</span></label>
                                          </div>
                                          <div class="col-12 col-md-8">
                                              <div class="d-flex">
                                                  <div class="form-check d-flex me-2 if-owned">
                                                      <input class="form-check-input" type="radio" name="ownership_type" id="oRadios1" value="Own" >
                                                      <label class="form-check-label" for="oRadios1">
                                                          Own  
                                                      </label>
                                                  </div>
                                                  <div class="form-check d-flex if-rental">
                                                      <input class="form-check-input" type="radio" name="ownership_type" id="oRadios2" value="Rental" >
                                                      <label class="form-check-label" for="oRadios2">
                                                          Rental
                                                      </label>
                                                  </div>  
                                              </div>
                                              <small class="error text-danger" id="add_ownership_type_error"></small>
                                          </div>
                                    </div>
                                    
                                      
                                    {{--<div class="form-group row pb-1">
                                        <div class="col-12 col-md-4">
                                            <label>Ownership Type <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-12 col-md-8 d-flex flex-wrap">

                                            @foreach($vehicleownership as $index => $ownership)
                                        
                                                @php
                                                    $radioId = 'ownership_' . $ownership->id;
                                                @endphp
                                        
                                                <div class="form-check d-flex me-3">
                                                    <input 
                                                        class="form-check-input" 
                                                        type="radio" 
                                                        name="ownership" 
                                                        id="{{ $radioId }}" 
                                                        value="{{ $ownership->id }}"
                                                    >
                                                    
                                                    <label class="form-check-label" for="{{ $radioId }}">
                                                        {{ $ownership->name }}
                                                    </label>
                                                </div>
                                        
                                            @endforeach
                                            <small class="error text-danger d-block" id="add_ownership_error"></small>
                                        </div>
                                        
                                        
                                    </div>--}}
                                    
                                    <div class="form-group row pb-1">
                                        <div class="col-12 col-md-4">
                                            <label>Vehicle Group <span class="text-danger">*</span></label>
                                        </div>
                                      
                                        <div class="col-12 col-md-8">
                                            <div class="d-flex flex-wrap">
                                            @foreach($vehiclegroup as $group)
                                    
                                                @php
                                                    $radioId = 'vehiclegroup_'.$group->id;
                                                @endphp
                                    
                                                <div class="form-check d-flex me-2">
                                                    <input 
                                                        class="form-check-input"
                                                        type="radio"
                                                        name="vehicle_group"
                                                        id="{{ $radioId }}"
                                                        value="{{ $group->id }}"
                                                    >
                                    
                                                    <label class="form-check-label" for="{{ $radioId }}">
                                                        {{ $group->name }}
                                                    </label>
                                                </div>
                                    
                                            @endforeach
                                            </div>
                                            <small class="error text-danger d-block" id="add_vehicle_group_error"></small>
                                        </div>
                                    </div>
            
                                    <div class="form-group row pb-1">
                                        <div class="col-12 col-md-4">
                                            <label>Vehicle Type <span class="text-danger">*</span></label>
                                        </div>
                                          
                                        <div class="col-12 col-md-8">
                                            <div class="d-flex flex-wrap">
                                            @foreach($vehicletype as $type)
                                    
                                                @php
                                                    $radioId = 'vehicletype_'.$type->id;
                                                @endphp
                                    
                                                <div class="form-check d-flex me-2">
                                                    <input 
                                                        class="form-check-input vehicleTypeId"
                                                        type="radio"
                                                        name="vehicle_type"
                                                        id="{{ $radioId }}"
                                                        value="{{ $type->id }}"
                                                    >
                                    
                                                    <label class="form-check-label" for="{{ $radioId }}">
                                                        {{ $type->name }}
                                                    </label>
                                                </div>
                                    
                                            @endforeach
                                            </div>
                                            <small class="error text-danger d-block" id="add_vehicle_type_error"></small>
                                        </div>
                                        
                                    </div>
                                      
                                    <div class="form-group row pb-1">
                                        <div class="col-12 col-md-4">
                                            <label>Vehicle Size <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-12 col-md-8">
                                            <select class="form-select" name="vehicle_size" id="vehicle_size">
                                                <option value="">Choose</option>
                                            </select>
                                            <small class="error text-danger" id="add_vehicle_size_error"></small>
                                        </div>
                                    </div>
            
                                    <div class="form-group row pb-1">
                                        <div class="col-12 col-md-4">
                                            <label>Category <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-12 col-md-8">
                                            <div class="d-flex flex-wrap">
                                                <div class="form-check d-flex me-2">
                                                  <input class="form-check-input" type="radio" name="category" id="line1" value="Line">
                                                  <label class="form-check-label" for="line1">
                                                    Line
                                                  </label>
                                                </div>
                                                <div class="form-check d-flex">
                                                  <input class="form-check-input" type="radio" name="category" id="local2" value="Local">
                                                  <label class="form-check-label" for="local2">
                                                    Local
                                                  </label>
                                                </div>
                                            </div>
                                            <small class="error text-danger d-block" id="add_category_error"></small>
                                        </div>
                                        
                                    </div>
                                    
                                    
                                    <div class="form-group row">

                                        <div class="col-12 col-md-4">
                                          <label>Status <span class="text-danger">*</span></label>
                                        </div>
        
                                        <div class="col-12 col-md-8">
                                            <div class="d-flex">
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
                                            <small class="error text-danger d-block" id="add_status_error"></small>
                                        </div>
                                      
                                    </div>
                                    
                                    <div class="form-group row">

                                        <div class="col-12 col-md-4">
                                          <label>Mounted Tyre Count <span class="text-danger">*</span></label>
                                        </div>
        
                                        <div class="col-12 col-md-8">
                                            <select class="form-select" name="mounted_tyre_count" id="mounted_tyre_count">
                                                <option value="">Select Mounted Tyre Count</option>
                                                <option value="6">6 Wheeler</option>
                                                <option value="10">10 Wheeler</option>
                                            </select>
                                            <small class="error text-danger d-block" id="add_mounted_tyre_count_error"></small>
                                        </div>
                                    </div>
            
                                     
                                    <div class="text-right">
                                        <button class="btn btn-dark mb-4" id="addBtn">Save</button>
                          
                                        <a href="{{ route('vehiclemanagement.index') }}" class="btn btn-danger mb-4"> Close </a>
                                    </div>
            
                                  </form>
                              </div>
                              
                                <div class="col-12 col-md-5">
                                    <div class="container-fluid mb-4 p-0 fetched-data"></div>
                                </div>
                              
                              
                          </div>
                      </div>
                </div>
  
                
            </div>

        </div>
    </div>
</div>
    

@endsection

@section('js')
<script>
    var LISTING = "{{ route('vehiclemanagement.index') }}";
    var VEHICLETYPE_SIZES = "{{ route('vehicletype.sizes', ':id') }}";

    var FETCH_VEHICLE_INFO = "{{ route('vehiclemanagement.fetchInfo') }}";
</script>
<script type="text/javascript" src="{{ asset('customjs/vehicle/management/create.js') }}"></script>

@endsection





