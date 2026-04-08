@extends('layouts.app')

@section('css')

<link rel="stylesheet" href="{{ asset('public/css/add-vehicle-type.css') }}">

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
                                <h5>Add Vehicle Type</h5>
                            </div>
                        </div>
                    </div>
                  </div>

                    <div class="addroute-bd">
                      <div class="container-fluid">

                        <form action="{{route('vehicletype.save')}}" method="POST" id="addForm">
                            @csrf

                          <div class="form-group row pb-1">
                            <div class="col-12 col-md-3">
                                <label>Name <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-12 col-md-6">
                                <input type="text" name="vehicletype_name" value="{{ old('vehicletype_name') }}" class="form-control">
                                <small class="error text-danger" id="add_vehicletype_name_error"></small>
                            </div>
                          </div>
                          
                          
                         <div class="form-group pb-1">
                            <div class="vehicle-size-wrapper">
                        
                                <!-- FIRST (DEFAULT) ROW -->
                                <div class="card p-3 vehicle-size-row" data-index="0">
                                    <div class="row">
                                        <div class="col-12 col-md-3">
                                            <label>Vehicle Size <span class="text-danger">*</span></label>
                                        </div>
                        
                                        <div class="col-12 col-md-6">
                                            <input type="text" name="vehiclesize_name[]" class="form-control">
                                            <small class="error text-danger" id="vehiclesize_name_0_error"></small>
                        
                                            <div class="mt-3">
                                                <div class="row">
                        
                                                    <div class="col-md-4">
                                                        <div class="form-floating">
                                                            <input type="text" name="vehiclesize_height[]" class="form-control decimalonly">
                                                            <label>Height (ft)</label>
                                                        </div>
                                                        <small class="error text-danger" id="vehiclesize_height_0_error"></small>
                                                    </div>
                        
                                                    <div class="col-md-4">
                                                        <div class="form-floating">
                                                            <input type="text" name="vehiclesize_width[]" class="form-control decimalonly">
                                                            <label>Width (ft)</label>
                                                        </div>
                                                        <small class="error text-danger" id="vehiclesize_width_0_error"></small>
                                                    </div>
                        
                                                    <div class="col-md-4">
                                                        <div class="form-floating">
                                                            <input type="text" name="vehiclesize_length[]" class="form-control decimalonly">
                                                            <label>Length (ft)</label>
                                                        </div>
                                                        <small class="error text-danger" id="vehiclesize_length_0_error"></small>
                                                    </div>
                        
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        
                            </div>
                        
                            <div class="mt-3">
                                <a href="javascript:void(0)" class="btn btn-secondary mt-2 add-vs">
                                    <i class="uil uil-plus-circle me-1"></i> Add Vehicle Size
                                </a>
                            </div>
                         </div>
                         
                         
                         <div class="form-group row pb-1">
                              <div class="col-12 col-md-3">
                                <label>Description</label>
                            </div>
                            <div class="col-12 col-md-6">
                                <textarea class="form-control" name="description" rows="3" placeholder=""></textarea>
                                <small class="error text-danger" id="add_description_error"></small>
                            </div>
                          </div>  
                    

                          <div class="form-group row">

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

                                                 
                          
                          <div class="text-right">
                              <button class="btn btn-dark mb-4" id="addBtn">Save</button>
                              
                              <a href="{{ route('vehicletype.index') }}" class="btn btn-danger mb-4"> Close </a>
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
var VEHILE_TYPES = "{{ route('vehicletype.index') }}";

$(document).ready(function(){
    $('.add-vs').click(function(){
        $('.added-vs-sec').show();
    })
    $('.dell-vs').click(function(){
        $('.added-vs-sec').hide();
    })
});
</script>

<script type="text/javascript" src="{{asset('public/customjs/vehicle/type/create.js')}}"></script>

@endsection





