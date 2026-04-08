@extends('layouts.app')

@section('css')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css" />
<link rel="stylesheet" href="{{ asset('css/tyre/edit.css') }}">
<!--<link rel="stylesheet" href="{{ asset('css/vehicle-details.css') }}">-->

@endsection

@section('content')

<div class="layout-wrapper">
    @include('includes.header')

    <div class="wrapper srlog-bdwrapper">
        <div class="topbar mt-4">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-12 col-md-6">
                        <h5>Edit Tyre</h5>
                    </div>
                    <div class="text-end col-12 col-md-6">
                        <button class="btn btn-dark mb-4 submitBtn">Save</button>
          
                        <a href="{{ route('tyre.dashboard') }}" class="btn btn-danger mb-4"> Close </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="addroute-bd">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-12">
                          
                        <form action="{{ route('tyre.update', $tyre->id) }}" method="POST" id="editTyreForm">
                            @csrf
                            
                            <!-- Tyre Vendor -->
                            <div class="form-group row pb-1">
                                <div class="col-12 col-md-4">
                                    <label>Vendor <span class="text-danger">*</span></label>
                                    <select class="form-select vendor_select" name="vendor">
                                        <option value="">Select Vendor</option>
                                        @forelse($tyrevendors as $tyrevendor)
                                            <option value="{{ $tyrevendor->id }}" @if($tyre->contact_id == $tyrevendor->id) selected @endif>{{ $tyrevendor->contact_name }} ({{ $tyrevendor->company_name }})</option>
                                        @empty
                                        @endforelse
                                    </select>
                                    <small class="error text-danger" id="add_vendor_error"></small>
                                </div>
                                
                                <div class="col-12 col-md-4">
                                      <label>Tyre Condition <span class="text-danger">*</span></label>
                                      <div class="d-flex">
                                          <div class="form-check d-flex me-2 if-owned">
                                              <input class="form-check-input" type="radio" name="condition" id="oRadios1" value="New"  @if($tyre->tyre_condition == 'New') checked @endif>
                                              <label class="form-check-label" for="oRadios1">
                                                  New  
                                              </label>
                                          </div>
                                          <div class="form-check d-flex if-rental">
                                              <input class="form-check-input" type="radio" name="condition" id="oRadios2" value="Re-thread" @if($tyre->tyre_condition == 'Re-thread') checked @endif>
                                              <label class="form-check-label" for="oRadios2">
                                                  Re-thread
                                              </label>
                                          </div>  
                                      </div>
                                      <small class="error text-danger" id="add_condition_error"></small>
                                  </div>
                                  
                                <div class="col-12 col-md-4">
                                    <label>Tyre Brand <span class="text-danger">*</span></label>
                                    <input type="text" name="tyre_brand" class="form-control" value="{{ $tyre->tyre_brand }}">
                                    <small class="error text-danger" id="add_tyre_brand_error"></small>
                                </div>
                            </div>
                        
                            <!-- Tyre Model -->
                            <div class="form-group row pb-1">
                                <div class="col-12 col-md-4">
                                    <label>Tyre Model <span class="text-danger">*</span></label>
                                    <input type="text" name="tyre_model_name" class="form-control" value="{{ $tyre->tyre_model }}">
                                    <small class="error text-danger" id="add_tyre_model_name_error"></small>
                                </div>
                                
                                <div class="col-12 col-md-4">
                                    <label>Tyre Type <span class="text-danger">*</span></label>
                                    <div class="d-flex">
                                        <div class="form-check d-flex me-2 if-owned">
                                              <input class="form-check-input" type="radio" name="tyre_type" id="oRadiosTyreTypeRadial" value="Radial" @if($tyre->tyre_type == 'Radial') checked @endif>
                                              <label class="form-check-label" for="oRadiosTyreTypeRadial">
                                                  Radial  
                                              </label>
                                        </div>
                                        <div class="form-check d-flex if-rental">
                                              <input class="form-check-input" type="radio" name="tyre_type" id="oRadiosTyreTypeNylon" value="Nylon" @if($tyre->tyre_type == 'Nylon') checked @endif>
                                              <label class="form-check-label" for="oRadiosTyreTypeNylon">
                                                  Nylon
                                              </label>
                                        </div>  
                                    </div>
                                    <small class="error text-danger" id="add_tyre_type_error"></small>
                                </div>
                                
                                <div class="col-12 col-md-4">
                                    <label>Tyre Price <span class="text-danger">*</span></label>
                                    <input type="text" name="tyre_price" class="form-control" value="{{ $tyre->tyre_price }}">
                                    <small class="error text-danger" id="add_tyre_price_error"></small>
                                </div>
                            </div>
                        
                            <!-- Serial Number -->
                            <div class="form-group row pb-1">
                                <div class="col-12 col-md-4">
                                    <label>Tyre Serial Number <span class="text-danger">*</span></label>
                                    <input type="text" name="tyre_serial_number" class="form-control" value="{{ $tyre->tyre_serial_number }}">
                                    <small class="error text-danger" id="add_tyre_serial_number_error"></small>
                                </div>
                                
                                <div class="col-12 col-md-4">
                                    <label>Tyre Purchase Date <span class="text-danger">*</span></label>
                                    <input type="date" name="tyre_purchase_date" class="form-control general_date" value="{{ date('Y-m-d', strtotime($tyre->tyre_purchase_date)) }}">
                                    <small class="error text-danger" id="add_tyre_purchase_date_error"></small>
                                </div>
                                
                                <div class="col-12 col-md-4">
                                    <label>Tyre Issue Date <span class="text-danger">*</span></label>
                                    <input type="date" name="tyre_issue_date" class="form-control general_date" value="{{ date('Y-m-d', strtotime($tyre->tyre_issue_date)) }}">
                                    <small class="error text-danger" id="add_tyre_issue_date_error"></small>
                                </div>
                            </div>
                        
                            <!-- Warranty -->
                            <div class="form-group row pb-1">
                                <div class="col-12 col-md-4">
                                    <label>Warranty Period (Months) <span class="text-danger">*</span></label>
                                    <input type="text" name="tyre_warranty_months" class="form-control" value="{{ $tyre->tyre_warranty_months }}">
                                    <small class="error text-danger" id="add_tyre_warranty_months_error"></small>
                                </div>
                                
                                <div class="col-12 col-md-4">
                                    <label>Tyre Fixed Run KM</label>
                                    <input type="text" name="fixed_run_km" class="form-control" value="{{ $tyre->fixed_run_km }}">
                                    <small class="error text-danger" id="add_fixed_run_km_error"></small>
                                </div>
                                
                                <div class="col-12 col-md-4">
                                    <label>Tyre Fixed Life (Months)</label>
                                    <input type="text" name="fixed_life_months" class="form-control" value="{{ $tyre->fixed_life_months }}">
                                    <small class="error text-danger" id="add_fixed_life_months_error"></small>
                                </div>
                            </div>
                            
                            <!-- Actual Run KM -->
                            <div class="form-group row pb-1">
                                <div class="col-12 col-md-4">
                                    <label>Tyre Actual Run KM</label>
                                    <input type="text" name="actual_run_km" class="form-control" value="{{ $tyre->actual_run_km }}">
                                    <small class="error text-danger" id="add_actual_run_km_error"></small>
                                </div>
                                <div class="col-12 col-md-4">
                                    <label>Tyre Actual Run Month</label>
                                    <input type="text" name="actual_run_month" class="form-control" value="{{ $tyre->actual_run_month }}">
                                    <small class="error text-danger" id="add_actual_run_month_error"></small>
                                </div>
                                <div class="col-12 col-md-4">
                                    <label>Last Wheel Alignment KM</label>
                                    <input type="text" name="last_alignment_km" class="form-control" value="{{ $tyre->last_alignment_km }}">
                                    <small class="error text-danger" id="add_last_alignment_km_error"></small>
                                </div>
                            </div>
                            
                            <!-- Last Rotation KM -->
                            <div class="form-group row pb-1">
                                <div class="col-12 col-md-4">
                                    <label>Last Wheel Rotation KM</label>
                                    <input type="text" name="last_rotation_km" class="form-control" value="{{ $tyre->last_rotation_km }}">
                                    <small class="error text-danger" id="add_last_rotation_km_error"></small>
                                </div>
                                
                                <div class="col-12 col-md-4">
                                    <label>Wheel Alignment Interval KM</label>
                                    <div class="row">
                                        <div class="col-8 col-md-6">
                                            <input type="text" name="alignment_interval_km" class="form-control" value="{{ $tyre->alignment_interval_km }}">
                                            <small class="error text-danger" id="add_alignment_interval_km_error"></small>
                                        </div>
                                        <div class="col-4 col-md-2 d-flex align-items-center">
                                            <input type="checkbox" name="set_reminder_for_alignment" @if($tyre->set_reminder_for_alignment == 'Yes') checked @endif> &nbsp; <label class="mt-2">Set Reminder?</label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-12 col-md-4">
                                    <label>Tyre Rotation Interval KM</label>
                                    <div class="row">
                                        <div class="col-8 col-md-6">
                                            <input type="text" name="rotation_interval_km" class="form-control" value="{{ $tyre->rotation_interval_km }}">
                                            <small class="error text-danger" id="add_rotation_interval_km_error"></small>
                                        </div>
                                        <div class="col-4 col-md-2 d-flex align-items-center">
                                            <input type="checkbox" name="set_reminder_for_rotation" @if($tyre->set_reminder_for_rotation == 'Yes') checked @endif> &nbsp; <label class="mt-2">Set Reminder?</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                
                            <div class="form-group row pb-1">
                                <div class="col-12">
                                    <label>Tyre Images <span class="text-danger"></span></label>
                                    <div class="dropzone" id="myDropzone">
                                        <div class="dz-message needsclick">
                                            <i class="uil uil-upload me-2"></i>
                                            Drop files here or click to upload (Max 4 files)
                                        </div>
                                    </div>
                                    <small class="error text-danger" id="edit_files_error"></small>
                                </div>
                            </div>
                          </form>
                    </div>
                    @forelse($tyre->images as $image)
                        <div class="col-12 col-md-4 attachment-box">
                            <div class="preview-img d-block w-100">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ asset('medias/'. $image->file_path) }}" download="{{ $image->file_name }}">
                                        <img src="{{ asset('medias/'. $image->file_path) }}" class="me-3">
                                    </a>
                                    <div style="font-size: 14px;">
                                        <a href="{{ asset('medias/'. $image->file_path) }}" download="{{ $image->file_name }}">
                                            <p class="mb-0 file-name">{{ $image->file_name }} </p>
                                        </a>
                                        <p class="mb-0">Size: <span class="text-secondary">{{ round((float) $image->file_size, 2) }} MB</span></p>
                                    </div>
                                    <!--<i class="uil-trash-alt text-danger ms-4 delete-attachment-btn" data-url="" style="cursor:pointer;"></i>-->
                                </div>
                                <small class="text-secondary d-block mt-2">Attached by <span class="text-theme">{{ $image->createdby?->name }}</span> on {{ $image->created_at->format('d/m/y [h:i A]') }}</small>
                            </div>
                        </div>
                    @empty
                    @endforelse
                </div>
            </div>
        </div>
        
    </div>
</div>
    

@endsection

@section('js')

<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>
<script type="text/javascript" src="{{asset('customjs/tyre/edit.js')}}?v={{ uniqid() }}"></script>

@endsection





