@extends('layouts.app')

@section('css')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css" />
<link rel="stylesheet" href="{{ asset('css/Tyre/create.css') }}">
<!--<link rel="stylesheet" href="{{ asset('css/Tyre/create.css') }}">-->

@endsection

@section('content')

<div class="layout-wrapper">
    @include('includes.header')

    <div class="wrapper srlog-bdwrapper">
        <div class="topbar mt-4">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-12 col-md-6">
                        <h5>Add Tyre</h5>
                    </div>
                    <div class="col-12 col-md-6 text-end">
                        <button class="btn btn-dark mb-4 submitBtn">Save</button>
          
                        <a href="{{ route('tyre.dashboard') }}" class="btn btn-danger mb-4"> Close </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="addroute-bd">
              <div class="container">
                  <div class="row">
                      <div class="col-12 col-md-11">
                        <form action="{{route('tyre.save')}}" method="POST" id="addTyreForm">
                            @csrf
                            
                            <!-- Tyre Vendor -->
                            <div class="form-group row pb-1">
                                <div class="col-12 col-md-4">
                                    <label>Vendor <span class="text-danger">*</span></label>
                                    <select class="form-select vendor_select" name="vendor">
                                        <option value="">Select Vendor</option>
                                        @forelse($tyrevendors as $tyrevendor)
                                            <option value="{{ $tyrevendor->id }}">{{ $tyrevendor->contact_name }} ({{ $tyrevendor->company_name }})</option>
                                        @empty
                                        @endforelse
                                    </select>
                                    <small class="error text-danger" id="add_vendor_error"></small>
                                </div>
                                
                                 <div class="col-12 col-md-4">
                                      <label>Tyre Condition <span class="text-danger">*</span></label>
                                        <div class="form-check d-inline-flex me-2 if-owned">
                                              <input class="form-check-input" type="radio" name="condition" id="oRadios1" value="New" >
                                              <label class="form-check-label" for="oRadios1">
                                                  New  
                                              </label>
                                          </div>
                                          <div class="form-check d-inline-flex if-rental">
                                              <input class="form-check-input" type="radio" name="condition" id="oRadios2" value="Re-thread" >
                                              <label class="form-check-label" for="oRadios2">
                                                  Re-thread
                                              </label>
                                          </div>
                                          <small class="error text-danger" id="add_condition_error"></small>
                                  </div>
                                  
                                  <div class="col-12 col-md-4">
                                    <label>Tyre Brand <span class="text-danger">*</span></label>
                                    <input type="text" name="tyre_brand" class="form-control">
                                    <small class="error text-danger" id="add_tyre_brand_error"></small>
                                </div>
                            </div>
                        
                            <!-- Tyre Model -->
                            <div class="form-group row pb-1">
                                <div class="col-12 col-md-4">
                                    <label>Tyre Model <span class="text-danger">*</span></label>
                                    <input type="text" name="tyre_model_name" class="form-control">
                                    <small class="error text-danger" id="add_tyre_model_name_error"></small>
                                </div>
                                
                                <div class="col-12 col-md-4">
                                    <label>Tyre Type <span class="text-danger">*</span></label>
                                    <div class="d-flex">
                                        <div class="form-check d-flex me-2 if-owned">
                                              <input class="form-check-input" type="radio" name="tyre_type" id="oRadiosTyreTypeRadial" value="Radial" >
                                              <label class="form-check-label" for="oRadiosTyreTypeRadial">
                                                  Radial  
                                              </label>
                                        </div>
                                        <div class="form-check d-flex if-rental">
                                              <input class="form-check-input" type="radio" name="tyre_type" id="oRadiosTyreTypeNylon" value="Nylon" >
                                              <label class="form-check-label" for="oRadiosTyreTypeNylon">
                                                  Nylon
                                              </label>
                                        </div>  
                                    </div>
                                    <small class="error text-danger" id="add_tyre_type_error"></small>
                                </div>
                                
                                <div class="col-12 col-md-4">
                                    <label>Tyre Price <span class="text-danger">*</span></label>
                                    <input type="text" name="tyre_price" class="form-control">
                                    <small class="error text-danger" id="add_tyre_price_error"></small>
                                </div>
                                
                            </div>
                        
                            <!-- Purchase Date -->
                            <div class="form-group row pb-1">
                                <div class="col-12 col-md-4">
                                    <label>Tyre Serial Number <span class="text-danger">*</span></label>
                                    <input type="text" name="tyre_serial_number" class="form-control">
                                    <small class="error text-danger" id="add_tyre_serial_number_error"></small>
                                </div>
                                
                                <div class="col-12 col-md-4">
                                    <label>Tyre Purchase Date <span class="text-danger">*</span></label>
                                    <input type="date" name="tyre_purchase_date" class="form-control general_date">
                                    <small class="error text-danger" id="add_tyre_purchase_date_error"></small>
                                </div>
                                
                                <div class="col-12 col-md-4">
                                    <label>Tyre Issue Date <span class="text-danger">*</span></label>
                                    <input type="date" name="tyre_issue_date" class="form-control general_date">
                                    <small class="error text-danger" id="add_tyre_issue_date_error"></small>
                                </div>
                            </div>
                        
                            <!-- Warranty -->
                            <div class="form-group row pb-1">
                                <div class="col-12 col-md-4">
                                    <label>Warranty Period (Months) <span class="text-danger">*</span></label>
                                    <input type="text" name="tyre_warranty_months" class="form-control">
                                    <small class="error text-danger" id="add_tyre_warranty_months_error"></small>
                                </div>
                                
                                <div class="col-12 col-md-4">
                                    <label>Tyre Fixed Run KM</label>
                                    <input type="text" name="fixed_run_km" class="form-control">
                                    <small class="error text-danger" id="add_fixed_run_km_error"></small>
                                </div>
                                
                                <div class="col-12 col-md-4">
                                    <label>Tyre Fixed Life (Months)</label>
                                    <input type="text" name="fixed_life_months" class="form-control">
                                    <small class="error text-danger" id="add_fixed_life_months_error"></small>
                                </div>
                            </div>
                            
                            <!-- Actual Run KM -->
                            <div class="form-group row pb-1">
                                <div class="col-12 col-md-4">
                                    <label>Tyre Actual Run KM</label>
                                    <input type="text" name="actual_run_km" class="form-control">
                                    <small class="error text-danger" id="add_actual_run_km_error"></small>
                                </div>
                                
                                <div class="col-12 col-md-4">
                                    <label>Tyre Actual Run Month</label>
                                    <input type="text" name="actual_run_month" class="form-control">
                                    <small class="error text-danger" id="add_actual_run_month_error"></small>
                                </div>
                                
                                <div class="col-12 col-md-4">
                                    <label>Last Wheel Alignment KM</label>
                                    <input type="text" name="last_alignment_km" class="form-control">
                                    <small class="error text-danger" id="add_last_alignment_km_error"></small>
                                </div>
                            </div>
                            
                            <!-- Last Rotation KM -->
                            <div class="form-group row pb-1">
                                <div class="col-12 col-md-4">
                                    <label>Last Wheel Rotation KM</label>
                                    <input type="text" name="last_rotation_km" class="form-control">
                                    <small class="error text-danger" id="add_last_rotation_km_error"></small>
                                </div>
                                
                                <div class="col-12 col-md-4">
                                    <label>Wheel Alignment Interval KM</label>
                                    <div class="row">
                                        <div class="col-8 col-md-8">
                                            <input type="text" name="alignment_interval_km" class="form-control">
                                            <small class="error text-danger" id="add_alignment_interval_km_error"></small>
                                        </div>
                                        <div class="col-4 col-md-4 d-flex align-items-center ps-0">
                                            <input type="checkbox" name="set_reminder_for_alignment"> &nbsp; <label class="mt-2">Set Reminder?</label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-12 col-md-4">
                                    <label>Tyre Rotation Interval KM</label>
                                    <div class="row">
                                        <div class="col-8 col-md-8">
                                            <input type="text" name="rotation_interval_km" class="form-control">
                                            <small class="error text-danger" id="add_rotation_interval_km_error"></small>
                                        </div>
                                        <div class="col-4 col-md-4 d-flex align-items-center ps-0">
                                            <input type="checkbox" name="set_reminder_for_rotation"> &nbsp; <label class="mt-2">Set Reminder?</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group row pb-1">
                                <div class="col-12">
                                    <label>Tyre Images <span class="text-danger">*</span></label>
                                    <div class="dropzone" id="myDropzone">
                                        <div class="dz-message needsclick">
                                            <i class="uil uil-upload me-2"></i>
                                            Drop files here or click to upload (Max 4 files)
                                        </div>
                                    </div>
                                    <small class="error text-danger" id="add_files_error"></small>
                                </div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>
<script type="text/javascript" src="{{asset('customjs/tyre/create.js')}}"></script>

@endsection





