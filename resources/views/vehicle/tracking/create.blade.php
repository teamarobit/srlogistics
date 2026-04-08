@extends('layouts.app')

@section('css')

<link rel="stylesheet" href="{{ asset('public/css/add-srlbranch-master.css') }}">

<style>
    .loading-wrap{
        display: none;
        background: #fff;
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 15px;
    }
    .unloading-wrap{
        display: none;
        background: #fff;
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 15px;
    }
    .rate-wrap{
        display: none;
        background: #fff;
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 15px;
    }
    .toll-wrap{
        display: none;
        background: #fff;
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 15px;
    }
    .tax-wrap{
        display: none;
        background: #fff;
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 15px;
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
                                <h5>Add Vehicle Group Tracking</h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="addroute-bd">
                    <div class="container-fluid">
                        
                        <form action="{{route('vehicletracking.save')}}" method="POST" id="addForm">
                          @csrf
                        
                          <div class="form-group row">
                            <div class="col-12 col-md-3">
                                <label>Vehicle Group <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-12 col-md-6">
                                <select class="form-select select2" name="vehicle_group_id">
                                    <option value="">Choose..</option>
                                    @foreach($vehiclegroup as $group)
                                        <option value="{{ $group->id }}">{{ $group->name }}</option>
                                    @endforeach
                                </select> 
                                <small class="error text-danger" id="add_vehicle_group_id_error"></small>
                            </div>
                          </div>
                          
                          <div class="form-group row">
                            <div class="col-12 col-md-3">
                                <label>Employee Name <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-12 col-md-6">
                                <input type="text" name="managed_by_employee" class="form-control"> 
                                <small class="error text-danger" id="add_managed_by_employee_error"></small>
                            </div>
                          </div>
                          
                          <div class="form-group row">
                            <div class="col-12 col-md-3">
                                <label>No. of Vehicles <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-12 col-md-6">
                                <input type="number" name="no_of_vehicles" class="form-control">
                                <small class="error text-danger" id="add_no_of_vehicles_error"></small>
                            </div>
                          </div>
                          
                          <div class="form-group row">
                              <div class="col-12 col-md-3">
                                  <label>Vehicle Enlisted<span class="text-danger">*</span></label>
                              </div>
                              
                              <div class="col-12 col-md-6">
                                <select class="form-select select2" name="vehicle_ids[]" multiple="multiple">
                                    <option value="">Choose..</option>
                                
                                    @foreach($vehicles as $vehicle)
                                        <option value="{{ $vehicle->id }}">
                                            {{ $vehicle->vehicle_no }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="error text-danger d-block" id="add_vehicle_ids_error"></small>
                              </div>
                          </div>
                          
                          <div class="text-right">
                            <button class="btn btn-dark mb-4" id="addBtn">Save</button>
                          
                            <a href="{{ route('vehicletracking.index') }}" class="btn btn-danger mb-4"> Close </a>
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
var LISTING = "{{ route('vehicletracking.index') }}";


$(function() {
  $('input[name="time_hr_from"]').daterangepicker({
    singleDatePicker: true,
    showDropdowns: true,
    minYear: 1901,
    maxYear: parseInt(moment().format('YYYY'),10)
  }, function(start, end, label) {
    var years = moment().diff(start, 'years');
    alert("You are " + years + " years old!");
  });
});

$(document).ready(function(){
    
    
});

</script>

<script type="text/javascript" src="{{asset('public/customjs/vehicle/tracking/create.js')}}"></script>

@endsection





