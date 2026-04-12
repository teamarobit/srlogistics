@extends('layouts.app')

@section('css')

<link rel="stylesheet" href="{{ asset('css/Vehicle/Tracking/create.css') }}">

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
                                <h5>Edit Vehicle Group Tracking</h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="addroute-bd">
                    <div class="container-fluid">
                        
                        <form action="{{route('vehicletracking.update')}}" method="POST" id="editForm">
                          @csrf
                          
                          <input type="hidden" name="id" id="edit_id_input" value="{{ $record->id }}">
                        
                          <div class="form-group row">
                            <div class="col-12 col-md-3">
                                <label>Vehicle Group <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-12 col-md-6">
                                <select class="form-select select2" name="vehicle_group_id">
                                    <option value="">Choose..</option>
                                    @foreach($vehiclegroup as $group)
                                        <option value="{{ $group->id }}" {{ $record->vehicle_group_id == $group->id ? 'selected' : '' }}>{{ $group->name }}</option>
                                    @endforeach
                                </select> 
                                <small class="error text-danger" id="edit_vehicle_group_id_error"></small>
                            </div>
                          </div>
                          
                          <div class="form-group row">
                            <div class="col-12 col-md-3">
                                <label>Employee Name <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-12 col-md-6">
                                <input type="text" name="managed_by_employee" value="{{ $record->managed_by_employee ?? '' }}" class="form-control"> 
                                <small class="error text-danger" id="edit_managed_by_employee_error"></small>
                            </div>
                          </div>
                          
                          <div class="form-group row">
                            <div class="col-12 col-md-3">
                                <label>No. of Vehicles <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-12 col-md-6">
                                <input type="number" name="no_of_vehicles" value="{{ $record->no_of_vehicles ?? '' }}" class="form-control">
                                <small class="error text-danger" id="edit_no_of_vehicles_error"></small>
                            </div>
                          </div>
                          
                          <div class="form-group row">
                              <div class="col-12 col-md-3">
                                  <label>Vehicle Enlisted<span class="text-danger">*</span></label>
                              </div>
                              
                                @php
                                    $selectedVehicles = $record->vehicles->pluck('vehicle_id')->toArray();
                                @endphp
                              <div class="col-12 col-md-6">
                                <select class="form-select select2" name="vehicle_ids[]" multiple="multiple">
                                    <option value="">Choose..</option>
                                
                                    @foreach($vehicles as $vehicle)
                                        <option value="{{ $vehicle->id }}" {{ in_array($vehicle->id, $selectedVehicles) ? 'selected' : '' }}>
                                            {{ $vehicle->vehicle_no }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="error text-danger d-block" id="edit_vehicle_ids_error"></small>
                              </div>
                          </div>
                          
                          <div class="text-right">
                            <button class="btn btn-dark mb-4" id="editBtn">Save</button>
                          
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

<script type="text/javascript" src="{{asset('js/Vehicle/Tracking/edit.js')}}"></script>

@endsection

