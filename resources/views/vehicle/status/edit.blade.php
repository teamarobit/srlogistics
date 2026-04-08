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
                                <h5>Edit Vehicle Status</h5>
                            </div>
                        </div>
                    </div>
                  </div>

                    <div class="addroute-bd">
                      <div class="container-fluid">

                        <form action="{{route('vehiclestatus.update')}}" method="POST" id="editForm">
                            @csrf
                            
                            <input type="hidden" name="id" id="edit_id_input" value="{{ $editData->id }}">
                            
                            <div class="form-group row pb-1">
                                <div class="col-12 col-md-3">
                                    <label>Name <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-12 col-md-6">
                                    <input type="text" name="vehiclestatus_name" value="{{ old('vehiclestatus_name', $editData->name) }}" class="form-control">
                                    <small class="error text-danger" id="edit_vehicletype_name_error"></small>
                                </div>
                            </div>
                          
                            <div class="form-group row pb-1">
                                <div class="col-12 col-md-3">
                                    <label>Description</label>
                                </div>
                                <div class="col-12 col-md-6">
                                    <textarea class="form-control" name="description" rows="3" placeholder="">{{ old('description', $editData->description) }}</textarea>
                                    <small class="error text-danger" id="edit_description_error"></small>
                                </div>
                            </div>  
                            
                            <div class="form-group row">

                                <div class="col-12 col-md-3">
                                  <label>Status <span class="text-danger">*</span></label>
                                </div>

                                <div class="col-12 col-md-6">
                                      <div class="d-flex flex-wrap">
                                          <div class="form-check d-flex me-2 if-owned">
                                              <input class="form-check-input" type="radio" name="status" id="exampleRadios1" value="Active" @checked($editData->status == 'Active')>
                                              <label class="form-check-label" for="exampleRadios1">
                                                  Active
                                              </label>
                                          </div>
                                          <div class="form-check d-flex if-rental">
                                              <input class="form-check-input" type="radio" name="status" id="exampleRadios2" value="Inactive" @checked($editData->status == 'Inactive')>
                                              <label class="form-check-label" for="exampleRadios2">
                                                  Inactive
                                              </label>
                                          </div>  
                                      </div>
                                      <small class="error text-danger d-block" id="edit_status_error"></small>
                                </div>
                            </div>
                                    
                          
                            <div class="text-right">
                              <button class="btn btn-dark mb-4" id="editBtn">Save</button>
                              
                              <a href="{{ route('vehiclestatus.index') }}" class="btn btn-danger mb-4"> Close </a>
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
var VEHILE_STATUS = "{{ route('vehiclestatus.index') }}";

$(document).ready(function(){

});
</script>

<script type="text/javascript" src="{{asset('customjs/vehicle/status/edit.js')}}"></script>

@endsection

