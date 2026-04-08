@extends('layouts.app')

@section('css')

<link rel="stylesheet" href="{{ asset('css/add-ownership.css') }}">

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
                                <h5>Add Ownership</h5>
                            </div>
                        </div>
                    </div>
                  </div>

                    <div class="addroute-bd">
                      <div class="container-fluid">

                        <form action="{{route('vehicleownership.save')}}" method="POST" id="addForm">
                            @csrf

                          <div class="form-group row pb-1">
                            <div class="col-12 col-md-3">
                                <label>Name <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-12 col-md-6">
                                <input type="text" name="ownership_name" class="form-control">
                                <small class="error text-danger" id="add_ownership_name_error"></small>
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
                                  <div class="d-flex">
                                      <div class="form-check d-flex me-2 if-owned">
                                          <input class="form-check-input" type="radio" name="status" id="exampleRadios1" value="Active" >
                                          <label class="form-check-label" for="exampleRadios1">
                                              Active
                                          </label>
                                      </div>
                                      <div class="form-check d-flex if-rental">
                                          <input class="form-check-input" type="radio" name="status" id="exampleRadios2" value="Inactive" >
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
                              
                              <a href="{{ route('vehicleownership.index') }}" class="btn btn-danger mb-4"> Close </a>
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
var LISTING = "{{ route('vehicleownership.index') }}";

$(document).ready(function(){
    $('.add-vs').click(function(){
        $('.added-vs-sec').show();
    })
    $('.dell-vs').click(function(){
        $('.added-vs-sec').hide();
    })
});
</script>

<script type="text/javascript" src="{{asset('customjs/vehicle/ownership/create.js')}}"></script>

@endsection





