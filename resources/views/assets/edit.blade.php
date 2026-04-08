@extends('layouts.app')

@section('css')

<link rel="stylesheet" href="{{ asset('css/add-asset.css') }}">

<style>
/*body { background-color: #fff; }*/
/*.table thead tr th { padding: 8px 10px; }*/
/*.table tbody td { padding: 8px 10px; }*/
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
                                <h5>Edit Asset</h5>
                            </div>
                        </div>
                    </div>
                </div>
                  

                <div class="add-assetbd"> 
                    
                    <form action="{{route('asset.update')}}" method="POST" id="editForm">
                        @csrf
                        
                        <input type="hidden" name="assetid" id="edit_assetid_input" value="{{ $data->id }}">
                        
                        <div class="form-group row pb-1">
                           
                            <div class="col-12 col-md-3 ms-3">
                                <label>Asset Type <span class="text-danger">*</span></label>
                            </div>
                            
                            <div class="col-12 col-md-8 d-flex">
                              
                                <div class="form-check me-3"> 
                                    <input class="form-check-input status-radio" type="radio" name="asset_type" id="motor" value="Motor Vehicle" {{ $data->type == 'Motor Vehicle' ? 'checked' : '' }} />
                                    <label class="form-check-label" for="motor"> Motor Vehicle </label>
                                </div>
                        
                                <div class="form-check me-3">
                                    <input class="form-check-input status-radio" type="radio" name="asset_type" id="electronics" value="Electronics" {{ $data->type == 'Electronics' ? 'checked' : '' }} />
                                    <label class="form-check-label" for="electronics"> Electronics </label>
                                </div>
                                
                                <div class="form-check me-3">
                                    <input class="form-check-input status-radio" type="radio" name="asset_type" id="others" value="Others" {{ $data->type == 'Others' ? 'checked' : '' }} />
                                    <label class="form-check-label" for="others"> Others </label>
                                </div>
                                    
                            </div>
                            <small class="error text-danger" id="edit_asset_type_error"></small>
                        </div>
                     
                        <div class="motor_vehicle">
                              
                              
                              <div class="form-group row pb-1 AssetTypeName">
                                <div class="col-12 col-md-3">
                                    <label>Asset Type Name</label>
                                </div>
                                <div class="col-12 col-md-6">
                                    <input type="text" name="asset_type_name" value="{{ $data->asset_type_name ?? '' }}" class="form-control">
                                    <small class="error text-danger" id="edit_asset_type_name_error"></small>
                                </div>
                              </div>
                              
                              
                              <div class="form-group row pb-1">
                                <div class="col-12 col-md-3">
                                    <label>Asset Name</label>
                                </div>
                                <div class="col-12 col-md-6">
                                    <input type="text" name="asset_name" value="{{ $data->name ?? '' }}" class="form-control">
                                    <small class="error text-danger" id="edit_asset_name_error"></small>
                                </div>
                              </div>
                              
                              <div class="form-group row pb-1">
                                <div class="col-12 col-md-3">
                                    <label>Asset ID <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-12 col-md-6">
                                    <input type="text" name="asset_id" value="{{ $data->asset_no ?? '' }}" class="form-control">
                                    <small class="error text-danger" id="edit_asset_id_error"></small>
                                </div>
                              </div>
                              
                              <div class="form-group row pb-1 MotorVehicleNumber">
                                <div class="col-12 col-md-3"> 
                                    <label>Vehicle Number <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-12 col-md-6">
                                    <input type="text" name="vehicle_no" value="{{ $data->vehicle_no ?? '' }}" class="form-control">
                                    <small class="error text-danger" id="edit_vehicle_no_error"></small>
                                </div>
                              </div>
                              
                              <div class="form-group row pb-1 MakeDiv">
                                <div class="col-12 col-md-3">
                                    <label>Make <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-12 col-md-6">
                                    <input type="text" name="make" value="{{ $data->make ?? '' }}" class="form-control">
                                    <small class="error text-danger" id="edit_make_error"></small>
                                </div>
                              </div>
                              
                              <div class="form-group row pb-1 ModelDiv">
                                <div class="col-12 col-md-3">
                                    <label>Model <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-12 col-md-6">
                                    <input type="text" name="model" value="{{ $data->model ?? '' }}" class="form-control">
                                    <small class="error text-danger" id="edit_model_error"></small>
                                </div>
                              </div>
                              
                              <div class="form-group row pb-1 MotorVehicleNumberRCDate">
                                <div class="col-12 col-md-3">
                                    <label>RC Date <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-12 col-md-6">
                                    <input name="rc_date" value="{{ $data->rc_date ?? '' }}" class="form-control bg-light text-uppercase common_date" type="date" placeholder="DD/MM/YY">
                                    <small class="error text-danger" id="edit_rc_date_error"></small>
                                </div>
                              </div>
                              
                              <div class="form-group row pb-1 MotorVehicleAge">
                                <div class="col-12 col-md-3">
                                    <label>Vehicle Age <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-12 col-md-6">
                                    <input type="text" name="vehicle_age" value="{{ $data->age ?? '' }}" class="form-control">
                                    <small class="error text-danger" id="edit_vehicle_age_error"></small>
                                </div>
                              </div>
                              
                              
                              <div class="ElectronicsDiv">
                                  <div class="form-group row pb-1 WarrantyStartDiv">
                                    <div class="col-12 col-md-3">
                                        <label>Warranty Start Date <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <input name="warranty_start_date" value="{{ $data->warranty_start_date ?? '' }}" class="form-control bg-light text-uppercase" type="date" placeholder="DD/MM/YY">
                                        <small class="error text-danger" id="edit_warranty_start_date_error"></small>
                                    </div>
                                  </div>
                                  <div class="form-group row pb-1 WarrantyEndDiv">
                                    <div class="col-12 col-md-3">
                                        <label>Warranty End Date <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <input name="warranty_end_date" value="{{ $data->warranty_end_date ?? '' }}" class="form-control bg-light text-uppercase" type="date" placeholder="DD/MM/YY">
                                        <small class="error text-danger" id="edit_warranty_end_date_error"></small>
                                    </div>
                                  </div>
                                  <div class="form-group row pb-1 AgeDiv">
                                    <div class="col-12 col-md-3">
                                        <label>Age <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <input type="text" name="electronic_age" value="{{ $data->age ?? '' }}" class="form-control">
                                        <small class="error text-danger" id="edit_electronic_age_error"></small>
                                    </div>
                                  </div>
                              </div>
                              
                              
                              
                              
                              
                              <div class="form-group row pb-1 IssueDateDiv">
                                <div class="col-12 col-md-3">
                                    <label>Issue Date <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-12 col-md-6">
                                    <input name="issue_date" value="{{ $data->issue_date ?? '' }}" class="form-control bg-light text-uppercase common_date" type="date" placeholder="DD/MM/YY">
                                    <small class="error text-danger" id="edit_issue_date_error"></small>
                                </div>
                              </div>
                              
                              <div class="form-group row pb-1 AssignedOnDiv">
                                <div class="col-12 col-md-3">
                                    <label>Assigned On <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-12 col-md-6">
                                    <input name="assigned_on" value="{{ $data->assigned_on ?? '' }}" class="form-control bg-light text-uppercase common_date" type="date" placeholder="DD/MM/YY">
                                    <small class="error text-danger" id="edit_assigned_on_error"></small>
                                </div>
                              </div>
                              
                              <div class="form-group row pb-1 AssignedByDiv">
                                <div class="col-12 col-md-3">
                                    <label>Assigned By <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-12 col-md-6">
                                    <select name="assigned_by" class="form-select select2">
                                        <option value="">Choose..</option>
                                        @foreach ($contacts as $contact)
                                            <option value="{{ $contact->id }}" {{ $contact->id == $data->assigned_by ? 'selected' : '' }}>
                                                {{ $contact->contact_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="error text-danger" id="edit_assigned_by_error"></small>
                                </div>
                              </div>
                              
                                <div class="form-group row">
                                    <div class="col-12 col-md-3">
                                        <label>Photos</label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="upload__box">
                                          <div class="upload__btn-box">
                                            <label class="upload__btn">
                                              <p class="btn btn-theme mb-0"><i class="uil uil-upload me-1"></i>Upload Photos</p>
                                              <input type="file" name="documents[]" multiple data-max_length="20" class="upload__inputfile">
                                            </label>
                                          </div>
                                          <small class="error text-danger" id="edit_documents_error"></small>
                                          <div class="upload__img-wrap">
                                            @forelse($data->files as $file)
                                                @php
                                                    $path = asset('media/asset/' . $file->file_name);
                                                    $ext = strtolower(pathinfo($file->file_name, PATHINFO_EXTENSION));
                                                @endphp
                                                
                                                {{-- Hidden input for controller --}}
                                                <input type="hidden" name="remove_files[]" value="" class="remove-input">
                                            
                                                @if(in_array($ext, ['jpg','jpeg','png','gif','webp']))
                                                    <div class="upload__img-box existing-file" data-id="{{ $file->id }}">
                                                        <div class="img-bg"
                                                             style="background-image: url('{{ $path }}')">
                                            
                                                            <div class="upload__img-close remove-existing-btn"
                                                                 data-id="{{ $file->id }}"></div>
                                            
                                                            <input type="hidden" name="existing_files[]" value="{{ $file->id }}">
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="upload__img-box">
                                                        <a href="{{ $path }}" target="_blank">
                                                            📄 {{ $file->file_name }}
                                                        </a>
                                                    </div>
                                                @endif
                                            
                                            @empty
                                                <span class="text-muted small">No files uploaded!</span>
                                            @endforelse
                                          </div>
                                          
                                        </div>
                                    </div>
                                </div>
    
                               <div class="form-group row pb-1">
                                  <div class="col-12 col-md-3">
                                    <label>Comment</label>
                                </div>
                                <div class="col-12 col-md-6">
                                    <textarea name="comment" class="form-control" rows="3" placeholder="">{{ $data->comment ?? '' }}</textarea>
                                    <small class="error text-danger" id="edit_comment_error"></small>
                                </div>
                              </div> 
                              
                           
    
                              <div class="text-right">
                                  <button id="editBtn" class="btn btn-dark mb-4">Save</button>
                                  
                                  <a href="{{ route('asset.index') }}" class="btn btn-danger mb-4"> Close </a>
                              </div>
    
                          
                        </div>
                        
                    </form>
                            
                </div>
                    

            </div>

        </div>
    </div>
            
</div>

@endsection

@section('js')

<script>
var ASSETS = "{{ route('asset.index') }}";
</script>

<script type="text/javascript" src="{{asset('customjs/asset/edit.js')}}"></script>

@endsection