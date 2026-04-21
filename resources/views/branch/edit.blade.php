@extends('layouts.app')

@section('css')

<link rel="stylesheet" href="{{ asset('css/Branch/edit.css') }}">

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
                                <h5>Edit Branch</h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="addroute-bd">
                  <div class="container-fluid">
                    
                    <form action="{{route('branch.update')}}" method="POST" id="editForm">
                        @csrf
                        
                      <input type="hidden" name="branchid" id="edit_branchid_input" value="{{ $branch->id }}">

                      <div class="form-group row">
                        <div class="col-12 col-md-3">
                            <label>Branch Location <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-12 col-md-6">
                            <input type="text" name="branch_location" value="{{ $branch->location ?? '' }}" class="form-control">
                            <small class="error text-danger" id="edit_branch_location_error"></small>
                        </div>
                      </div>
                      
                        @php
                            $types = old('branch_type');
                        
                            if (!$types) {
                                $types = $branch->type ?? [];
                        
                                // Convert JSON string â†’ array if needed
                                if (!is_array($types)) {
                                    $types = json_decode($types, true) ?? [];
                                }
                            }
                        @endphp
                      <div class="form-group row">
                          <div class="col-12 col-md-3">
                              <label>Branch Type <span class="text-danger">*</span></label>
                          </div>
                          <div class="col-12 col-md-6 d-flex">
                              <div class="form-check d-flex me-2">
                                  <input class="form-check-input" type="radio" name="branch_type[]" id="headOffice" value="Head Office" {{ in_array('Head Office', $types) ? 'checked' : '' }}>
                                  <label class="form-check-label" for="headOffice">
                                      Head Office
                                  </label>
                              </div>
                              <div class="form-check d-flex">
                                  <input class="form-check-input" type="radio" name="branch_type[]" id="branchOffice" value="Branch Office" {{ in_array('Branch Office', $types) ? 'checked' : '' }}>
                                  <label class="form-check-label" for="branchOffice">
                                      Branch Office
                                  </label>
                              </div>                                    
                              
                          </div>
                          <small class="error text-danger" id="edit_branch_type_error"></small>
                      </div>
                      
                      <div class="form-group row">
                        <div class="col-12 col-md-3">
                            <label>Branch Start Date <!--<span class="text-danger">*</span>--></label>
                        </div>
                        <div class="col-12 col-md-6">
                            <input type="date" name="start_date" value="{{ $branch->start_date ?? '' }}" class="form-control general_date">
                            <small class="error text-danger" id="edit_start_date_error"></small>
                        </div>
                      </div>
                      
                      <div class="form-group row">
                        <div class="col-12 col-md-3">
                            <label>Branch Code <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-12 col-md-6">
                            <input type="text" name="branch_code" value="{{ $branch->code ?? '' }}" class="form-control">
                            <small class="error text-danger" id="edit_branch_code_error"></small>
                        </div>
                      </div>
                      
                      <div class="form-group row">
                        <div class="col-12 col-md-3">
                            <label>Branch Head Name <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-12 col-md-6">
                            <input type="text" name="branch_head_name" value="{{ $branch->head_name ?? '' }}" class="form-control">
                            <small class="error text-danger" id="edit_branch_head_name_error"></small>
                        </div>
                      </div>
                      
                      <div class="row form-group">
                        <div class="col-12 col-md-3">
                            <label>Phone Number <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="row">
                                <input type="hidden" name="phone_code" class="phone_code"> 
                                <div class="col-12 col-md-12">
                                    <input type="text" name="phone" value="{{ $branch->phone ?? '' }}" class="form-control telinput"/>
                                    <small class="error text-danger" id="edit_phone_error"></small>
                                </div>
                            </div>
                        </div>
                      </div>
                      
                      <div class="form-group row">
                        <div class="col-12 col-md-3">
                            <label>Number of Employee <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-12 col-md-6">
                            <input type="text" name="no_of_employee" value="{{ $branch->no_of_employee ?? '' }}" class="form-control numericonly">
                            <small class="error text-danger" id="edit_no_of_employee_error"></small>
                        </div>
                      </div>
                      
                      
                      <div class="form-group row">
                        <div class="col-12 col-md-3">
                            <label>Address <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-12 col-md-6">
                            <input type="text" name="address" value="{{ $branch->address ?? '' }}" class="form-control">
                            <small class="error text-danger" id="edit_address_error"></small>
                        </div>
                      </div>
                      
                      
                      
                      <!-- State -->
                      <div class="form-group row">
                        <div class="col-12 col-md-3">
                            <label>State <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-12 col-md-6">
                            <select class="form-select select2 dependent-select" name="state_id" id="gstState" data-target="gstCity">
                                <option value="">Choose..</option>
                                @foreach ($states as $state)
                                    <option value="{{ $state->id }}" data-url="{{ route('getcities', $state->id) }}"
                                        {{ $state->id == $branch->state_id ? 'selected' : '' }}>
                                        {{ $state->name }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="error text-danger" id="edit_state_id_error"></small>
                        </div>
                      </div>
                      
                      <!-- City -->
                      <div class="form-group row">
                        <div class="col-12 col-md-3">
                          <label>City <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-12 col-md-6">
                          <select class="form-select select2" name="city_id" id="gstCity">
                            <option value="">Choose..</option>
                            @php
                                $cities = optional($branch->state)->cities;
                            @endphp
                            
                            @if($cities && $cities->count())
                                @foreach($cities as $city)
                                    <option value="{{$city->id}}" @selected($city->id === $branch->city_id)>{{$city->name}}</option>
                                @endforeach
                            @endif
                          </select>
                          <small class="error text-danger" id="edit_city_id_error"></small>
                        </div>
                      </div>
                      
                      
                      <div class="form-group row">
                        <div class="col-12 col-md-3">
                            <label>Postal Code <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-12 col-md-6">
                            <input type="text" name="post_code" value="{{ $branch->postal_code ?? '' }}" class="form-control">
                            <small class="error text-danger" id="edit_post_code_error"></small>
                        </div>
                      </div>
                      
                        @php
                            $ownership = $branch->branch_ownership ?? '';
                        @endphp
                      <div class="form-group row">
                          <div class="col-12 col-md-3">
                              <label>Branch Ownership <span class="text-danger">*</span></label>
                          </div>
                          <div class="col-12 col-md-6 d-flex">
                              <div class="form-check d-flex me-2 if-owned">
                                  <input class="form-check-input" type="radio" name="branch_ownership" id="own" value="Owned" {{ $ownership === 'Owned' ? 'checked' : '' }}>
                                  <label class="form-check-label" for="own">
                                      Owned
                                  </label>
                              </div>
                              <div class="form-check d-flex if-rental">
                                  <input class="form-check-input" type="radio" name="branch_ownership" id="rental" value="Rental" {{ $ownership === 'Rental' ? 'checked' : '' }}>
                                  <label class="form-check-label" for="rental">
                                      Rental
                                  </label>
                              </div>  
                              
                          </div>
                          <small class="error text-danger" id="edit_branch_ownership_error"></small>
                      </div>
                      
                      <div class="own-wrap">
                          
                      </div>
                      
                      <div class="rental-wrap" style="{{ $ownership === 'Rental' ? 'display:block;' : 'display:none;' }}">
                          <div class="form-group row">
                            <div class="col-12 col-md-3">
                                <label>Owner Name <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-12 col-md-6">
                                <input type="text" name="branch_owner_name" value="{{ $branch->branch_owner_name ?? '' }}" class="form-control" />
                                <small class="error text-danger" id="edit_branch_owner_name_error"></small>
                            </div>
                          </div>
                          
                          <div class="form-group row">
                            <div class="col-12 col-md-3">
                                <label>Owner Phone Number <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="row">
                                    <div class="col-12">
                                        <input type="hidden" name="branch_owner_phone_code" class="phone_code"> 
                                        <input type="text" name="branch_owner_phone" value="{{ $branch->branch_owner_phone ?? '' }}" class="form-control telinput">
                                        <small class="error text-danger" id="edit_branch_owner_phone_error"></small>
                                    </div>
                                </div>
                            </div>
                          </div>
                          
                          <div class="form-group row">
                            <div class="col-12 col-md-3">
                                <label>Rent Amount <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="input-group">
                                  <span class="input-group-text bg-light text-dark" id="">₹</span>
                                  <input type="text" name="rent_amount" value="{{ $branch->rent_amount ?? '' }}" class="form-control" style="min-height: 30px !important;height: 20px;">
                                </div>
                                <small class="error text-danger" id="edit_rent_amount_error"></small>
                            </div>
                          </div>
                          
                          <div class="form-group row">
                            <div class="col-12 col-md-3">
                                <label>Rent Due Date <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-12 col-md-6">
                                <input type="date" name="rent_due_date" value="{{ $branch->rent_due_date ?? '' }}" class="form-control " />
                                <small class="error text-danger" id="edit_rent_due_date_error"></small>
                            </div>
                          </div>
                      </div>
                      
                      
                      
                      <div class="form-group row">
                        <div class="col-12 col-md-3">
                            <label>Electricity Service Provider</label>
                        </div>
                        <div class="col-12 col-md-6">
                            <input type="text" name="electricity_service_provider" value="{{ $branch->electricity_service_provider ?? '' }}" class="form-control">
                            <small class="error text-danger" id="edit_electricity_service_provider_error"></small>
                        </div>
                      </div>
                      
                      <div class="form-group row">
                        <div class="col-12 col-md-3">
                            <label>Electricity Consumer Number</label>
                        </div>
                        <div class="col-12 col-md-6">
                            <input type="text" name="electricity_consumer_number" value="{{ $branch->electricity_consumer_number ?? '' }}" class="form-control">
                            <small class="error text-danger" id="edit_electricity_consumer_number_error"></small>
                        </div>
                      </div>
                      
                      
                      <div class="form-group row">
                        <div class="col-12 col-md-3">
                            <label>Documents</label>
                        </div>
                        <div class="col-12 col-md-6">
                            <input type="file" name="documents[]" id="branch_documents" multiple class="form-control">
                            
                            <div id="previewContainer" style="margin-top:10px; display:flex; flex-wrap:wrap; gap:10px;"></div>
                            
                            <div id="existingFilesContainer" style="margin-top:10px; display:flex; flex-wrap:wrap; gap:10px;">

                                @forelse($branch->files as $file)
                                    @php
                                        $path = asset('media/branch/' . $file->file_name);
                                        $ext = strtolower(pathinfo($file->file_name, PATHINFO_EXTENSION));
                                    @endphp
                                
                                    <div class="border p-2 position-relative file-box" data-id="{{ $file->id }}">
                                
                                        {{-- Delete Button --}}
                                        <button type="button" class="remove-existing-btn remove-file-btn">
                                            <i class="fa fa-times"></i>
                                        </button>
                                
                                        {{-- Hidden input for controller --}}
                                        <input type="hidden" name="remove_files[]" value="" class="remove-input">
                                
                                        {{-- Image Preview --}}
                                        @if(in_array($ext, ['jpg','jpeg','png','gif','webp']))
                                            <img src="{{ $path }}" width="80" height="80" style="object-fit:cover;">
                                        @else
                                            <a href="{{ $path }}" target="_blank">
                                                {{ $file->file_name }}
                                            </a>
                                        @endif
                                
                                    </div>
                                
                                @empty
                                    <span class="text-muted small">No files uploaded!</span>
                                @endforelse
                                
                            </div>

                            <small class="error text-danger" id="edit_documents_error"></small>
                        </div>
                      </div>
                      
                      <div class="form-group row">
                        <div class="col-12 col-md-3">
                            <label>Notes</label>
                        </div>
                        <div class="col-12 col-md-6">
                            <textarea type="textarea" name="notes" class="form-control" rows="4">{{ $branch->notes ?? '' }}</textarea>
                        </div>
                      </div>
                      
                        <div class="form-group row pb-">
                          <div class="col-12 col-md-3"><label>Status</label></div>

                          <div class="col-12 col-md-6 d-flex">
                              <div class="form-check d-flex me-2">
                                  <input class="form-check-input" type="radio" name="status" id="exampleRadios1" value="Active" {{ $branch->status == 'Active' ? 'checked' : '' }} >
                                  <label class="form-check-label" for="exampleRadios1">
                                      Active
                                  </label>
                              </div>

                              <div class="form-check d-flex">
                                  <input class="form-check-input" type="radio" name="status" id="exampleRadios2" value="Inactive" {{ $branch->status == 'Inactive' ? 'checked' : '' }} >
                                  <label class="form-check-label" for="exampleRadios2">
                                      Inactive
                                  </label>
                              </div>     
                          </div>
                          <small class="error text-danger" id="edit_status_error"></small>
                          
                        </div>
                      
                      <div class="text-right">
                          <button class="btn btn-dark mb-4" id="editBtn">Save</button>
                          
                          <a href="{{ route('branch.index') }}" class="btn btn-danger mb-4"> Close </a>
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
var BRANCHES = "{{ route('branch.index') }}";

</script>

<script type="text/javascript" src="{{asset('customjs/branch/edit.js')}}"></script>

@endsection




