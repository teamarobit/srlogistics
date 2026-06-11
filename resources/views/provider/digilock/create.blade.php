@extends('layouts.app')

@section('css')

<link rel="stylesheet" href="{{ asset('css/Provider/digilock-create.css?v=1.1') }}">
<link rel="stylesheet" href="{{ asset('css/Provider/digilock-index.css?v=1.1') }}">


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
                            <div class="col-12 col-md-12">
                                {{-- BUG-008 — breadcrumb --}}
                                <div class="dl-breadcrumb">
                                    <a href="{{ route('adminconsole.index') }}">Admin Console</a>
                                    <span class="sep">›</span>
                                    <span>Provider Master</span>
                                    <span class="sep">›</span>
                                    <a href="{{ route('digilockprovider.index') }}">Digital Lock Provider</a>
                                    <span class="sep">›</span>
                                    Add Digital Lock Provider
                                </div>
                                <h5>Add Digital Lock Provider</h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="addroute-bd">
                  <div class="container-fluid">

                    <form action="{{route('digilockprovider.save')}}" method="POST" id="addForm">
                        @csrf

                      <div class="form-group row pb-1">
                        <div class="col-12 col-md-3">
                            <label>Name <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-12 col-md-6">
                            <input type="text" name="provider_name" value="" class="form-control">
                            <small class="error text-danger" id="add_provider_name_error"></small>
                        </div>
                      </div>
                      
                      
                      <div class="form-group row">

                          <div class="col-12 col-md-3">
                              <label>Status <span class="text-danger">*</span></label>
                          </div>

                          <div class="col-12 col-md-6">
                              <div class="d-flex flex-wrap">
                                  {{-- Issue 16 — no default selection; match GPS Provider add --}}
                                  <div class="form-check d-flex me-2">
                                      <input class="form-check-input" type="radio" name="status" id="exampleRadios1" value="Active" {{ old('status') === 'Active' ? 'checked' : '' }}>
                                      <label class="form-check-label" for="exampleRadios1">
                                          Active
                                      </label>
                                  </div>

                                  <div class="form-check d-flex">
                                      <input class="form-check-input" type="radio" name="status" id="exampleRadios2" value="Inactive" {{ old('status') === 'Inactive' ? 'checked' : '' }}>
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
                          
                          <a href="{{ route('digilockprovider.index') }}" class="btn btn-danger mb-4"> Close </a>
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
var LISTING      = "{{route('digilockprovider.index')}}";
</script>

<script type="text/javascript" src="{{asset('customjs/provider/digilock/create.js?v=1.2')}}"></script>

@endsection




