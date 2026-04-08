@extends('layouts.app')

@section('css')

<link rel="stylesheet" href="{{ asset('css/add-vehicle-type.css') }}">

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
                                <h5>Edit Fasttag Provider</h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="addroute-bd">
                  <div class="container-fluid">

                    <form action="{{route('fasttagprovider.update')}}" method="POST" id="editForm">
                        @csrf
                        
                        <input type="hidden" name="recordid" id="edit_id_input" value="{{ $record->id }}">

                      <div class="form-group row pb-1">
                        <div class="col-12 col-md-3">
                            <label>Name <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-12 col-md-6">
                            <input type="text" name="provider_name" value="{{ $record->name ?? '' }}" class="form-control">
                            <small class="error text-danger" id="edit_provider_name_error"></small>
                        </div>
                      </div>
                      
                        
                        
                      <div class="form-group row pb-">

                          <div class="col-12 col-md-3">
                              <label>Status <span class="text-danger">*</span></label>
                          </div>

                          <div class="col-12 col-md-6 d-flex">
                              <div class="form-check d-flex me-2">
                                  <input class="form-check-input" type="radio" name="status" id="exampleRadios1" value="Active" {{ $record->status == 'Active' ? 'checked' : '' }} >
                                  <label class="form-check-label" for="exampleRadios1">
                                      Active
                                  </label>
                              </div>

                              <div class="form-check d-flex">
                                  <input class="form-check-input" type="radio" name="status" id="exampleRadios2" value="Inactive" {{ $record->status == 'Inactive' ? 'checked' : '' }} >
                                  <label class="form-check-label" for="exampleRadios2">
                                      Inactive
                                  </label>
                              </div>     
                          </div>
                          <small class="error text-danger" id="edit_status_error"></small>
                      </div>

                                             
                      
                      <div class="text-right">
                          <button class="btn btn-dark mb-4" id="editBtn">Save</button>
                          
                          <a href="{{ route('fasttagprovider.index') }}" class="btn btn-danger mb-4"> Close </a>
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
var LISTING = "{{ route('fasttagprovider.index') }}";
</script>

<script type="text/javascript" src="{{asset('customjs/provider/fasttag/edit.js')}}"></script>

@endsection