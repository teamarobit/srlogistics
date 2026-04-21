@extends('layouts.app')

@section('css')

<link rel="stylesheet" href="{{ asset('css/Vehicle/Type/create.css') }}">

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
                                <h5>Edit Vehicle Type</h5>
                            </div>
                        </div>
                    </div>
                  </div>

                    <div class="addroute-bd">
                      <div class="container-fluid">

                        <form action="{{route('vehicletype.update')}}" method="POST" id="editForm">
                            @csrf
                            
                            <input type="hidden" name="vehicletypeid" id="edit_vehicletypeid_input" value="{{ $vehicletype->id }}">
                            
                            <div class="form-group row pb-1">
                                <div class="col-12 col-md-3">
                                    <label>Name <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-12 col-md-6">
                                    <input type="text" name="vehicletype_name" value="{{ old('vehicletype_name', $vehicletype->name) }}" class="form-control">
                                    <small class="error text-danger" id="edit_vehicletype_name_error"></small>
                                </div>
                            </div>
                          
                            <div class="form-group pb-1">
                                <div class="vehicle-size-wrapper">
                            
                                    @forelse($vehicletype->sizes as $index => $size)
                                        <div class="card p-3 mb-3 vehicle-size-row">
                                            <div class="row">
                                                <div class="col-12 col-md-3">
                                                    <label>
                                                        Vehicle Size
                                                        @if($index == 0)
                                                            <span class="text-danger">*</span>
                                                        @endif
                                                    </label>
                                                </div>
                            
                                                <div class="col-12 col-md-6">
                                                    <input type="text"
                                                           name="vehiclesize_name[]"
                                                           class="form-control"
                                                           value="{{ $size->name ?? '' }}">
                            
                                                    <small class="error text-danger"
                                                           id="vehiclesize_name_{{ $index }}_error"></small>
                            
                                                    <div class="mt-3">
                                                        <div class="row form-group">

                                                            <div class="col-12 col-md-4">
                                                                <div class="form-floating">
                                                                    <input type="text"
                                                                           name="vehiclesize_length[]"
                                                                           class="form-control decimalonly"
                                                                           value="{{ $size->length ?? '' }}">
                                                                    <label>Length (ft)</label>
                                                                </div>
                                                                <small class="error text-danger"
                                                                       id="vehiclesize_length_{{ $index }}_error"></small>
                                                            </div>

                            
                                                            <div class="col-12 col-md-4">
                                                                <div class="form-floating">
                                                                    <input type="text"
                                                                           name="vehiclesize_height[]"
                                                                           class="form-control decimalonly"
                                                                           value="{{ $size->height ?? '' }}">
                                                                    <label>Height (ft)</label>
                                                                </div>
                                                                <small class="error text-danger"
                                                                       id="vehiclesize_height_{{ $index }}_error"></small>
                                                            </div>

                                                            
                            
                                                            <div class="col-12 col-md-4">
                                                                <div class="form-floating">
                                                                    <input type="text"
                                                                           name="vehiclesize_width[]"
                                                                           class="form-control decimalonly"
                                                                           value="{{ $size->width ?? '' }}">
                                                                    <label>Width (ft)</label>
                                                                </div>
                                                                <small class="error text-danger"
                                                                       id="vehiclesize_width_{{ $index }}_error"></small>
                                                            </div>
                            
                                                            
                            
                                                        </div>
                                                    </div>
                                                </div>
                            
                                                {{-- Remove button (except first row) --}}
                                                <div class="col-md-3 dell-vs text-end">
                                                    @if($index > 0)
                                                        <i class="uil uil-times-circle"></i>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        {{-- fallback if no sizes exist --}}
                                        @include('vehicletypes.partials.vehicle-size-empty')
                                    @endforelse
                            
                                </div>
                            
                                <div class="mt-3">
                                    <a href="javascript:void(0)" class="btn btn-secondary mt-2 add-vs"><i class="uil uil-plus-circle me-1"></i>
                                        Add Vehicle Size
                                    </a>
                                </div>
                            </div>
                            
                            
                            <div class="form-group row pb-1">
                                <div class="col-12 col-md-3">
                                    <label>Description</label>
                                </div>
                                <div class="col-12 col-md-6">
                                    <textarea class="form-control" name="description" rows="3" placeholder="">{{ old('description', $vehicletype->description) }}</textarea>
                                    <small class="error text-danger" id="edit_description_error"></small>
                                </div>
                            </div> 
                          

                            <div class="form-group row">
                              <div class="col-12 col-md-3">
                                  <label>Status <span class="text-danger">*</span></label>
                              </div>

                              <div class="col-12 col-md-6">
                                  <div class="d-flex flex-wrap">
                                      <div class="form-check d-flex me-2">
                                          <input class="form-check-input" type="radio" name="status" id="exampleRadios1" value="Active" @checked(old('status', $vehicletype->status) == 'Active')>
                                          <label class="form-check-label" for="exampleRadios1">
                                              Active
                                          </label>
                                      </div>
    
                                      <div class="form-check d-flex">
                                          <input class="form-check-input" type="radio" name="status" id="exampleRadios2" value="Inactive" @checked(old('status', $vehicletype->status) == 'Inactive')>
                                          <label class="form-check-label" for="exampleRadios2">
                                              Inactive
                                          </label>
                                      </div>
                                  </div>
                                  
                                  <small class="error text-danger" id="edit_status_error"></small>
                              </div>
                              
                            </div>

                                                    
                          
                            <div class="text-right">
                              <button class="btn btn-dark mb-4" id="editBtn">Save</button>
                              
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

<script type="text/javascript" src="{{asset('js/Vehicle/Type/edit.js')}}"></script>

@endsection

