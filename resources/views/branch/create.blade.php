@extends('layouts.app')

@section('css')

<link rel="stylesheet" href="{{ asset('css/Branch/create.css') }}">


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
                                <h5>Add Branch</h5>
                            </div>
                        </div>
                    </div>
                  </div>

                    <div class="addroute-bd">
                      <div class="container-fluid">

                        <form action="{{route('branch.save')}}" method="POST" id="addForm">
                            @csrf

                          <div class="form-group row">
                            <div class="col-12 col-md-3">
                                <label>Branch Location <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-12 col-md-6">
                                <input type="text" name="branch_location" class="form-control">
                                <small class="error text-danger" id="add_branch_location_error"></small>
                            </div>
                          </div>
                          
                          <div class="form-group row">
                              <div class="col-12 col-md-3">
                                  <label>Branch Type <span class="text-danger">*</span></label>
                              </div>
                              <div class="col-12 col-md-6">
                                  <div class="d-flex">
                                      <div class="form-check d-flex me-2">
                                          <input class="form-check-input" type="radio" name="branch_type[]" id="headOffice" value="Head Office">
                                          <label class="form-check-label" for="headOffice">
                                              Head Office
                                          </label>
                                      </div>
                                      <div class="form-check d-flex">
                                          <input class="form-check-input" type="radio" name="branch_type[]" id="branchOffice" value="Branch Office">
                                          <label class="form-check-label" for="branchOffice">
                                              Branch Office
                                          </label>
                                      </div>                                    
                                  </div>
                                  <small class="error text-danger" id="add_branch_type_error"></small>
                              </div>
                              
                          </div>
                          
                          <div class="form-group row">
                            <div class="col-12 col-md-3">
                                <label>Branch Start Date <!--<span class="text-danger">*</span>--></label>
                            </div>
                            <div class="col-12 col-md-6">
                                <input type="date" name="start_date" class="form-control general_date">
                                <small class="error text-danger" id="add_start_date_error"></small>
                            </div>
                          </div>
                          
                          <div class="form-group row">
                            <div class="col-12 col-md-3">
                                <label>Branch Code <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-12 col-md-6">
                                <input type="text" name="branch_code" class="form-control">
                                <small class="error text-danger" id="add_branch_code_error"></small>
                            </div>
                          </div>
                          
                          <div class="form-group row">
                            <div class="col-12 col-md-3">
                                <label>Branch Head Name <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-12 col-md-6">
                                <input type="text" name="branch_head_name" class="form-control">
                                <small class="error text-danger" id="add_branch_head_name_error"></small>
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
                                        <input type="text" name="phone" class="form-control telinput"/>
                                        <small class="error text-danger" id="add_phone_error"></small>
                                    </div>
                                </div>
                            </div>
                          </div>
                          
                          <div class="form-group row">
                            <div class="col-12 col-md-3">
                                <label>Number of Employee <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-12 col-md-6">
                                <input type="text" name="no_of_employee" class="form-control numericonly">
                                <small class="error text-danger" id="add_no_of_employee_error"></small>
                            </div>
                          </div>
                          
                          
                          <div class="form-group row">
                            <div class="col-12 col-md-3">
                                <label>Address <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-12 col-md-6">
                                <input type="text" name="address" class="form-control">
                                <small class="error text-danger" id="add_address_error"></small>
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
                                            {{ old('state_id') == $state->id ? 'selected' : '' }}>
                                            {{ $state->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="error text-danger" id="add_state_id_error"></small>
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
                              </select>
                              <small class="error text-danger" id="add_city_id_error"></small>
                            </div>
                          </div>
                          
                          
                          <div class="form-group row">
                            <div class="col-12 col-md-3">
                                <label>Postal Code <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-12 col-md-6">
                                <input type="text" name="post_code" class="form-control">
                                <small class="error text-danger" id="add_post_code_error"></small>
                            </div>
                          </div>
                          
                          <div class="form-group row">
                              <div class="col-12 col-md-3">
                                  <label>Branch Ownership <span class="text-danger">*</span></label>
                              </div>
                              <div class="col-12 col-md-6">
                                  <div class="d-flex">
                                      <div class="form-check d-flex me-2 if-owned">
                                          <input class="form-check-input" type="radio" name="branch_ownership" id="own" value="Owned">
                                          <label class="form-check-label" for="own">
                                              Owned
                                          </label>
                                      </div>
                                      <div class="form-check d-flex if-rental">
                                          <input class="form-check-input" type="radio" name="branch_ownership" id="rental" value="Rental">
                                          <label class="form-check-label" for="rental">
                                              Rental
                                          </label>
                                      </div>  
                                  </div>
                                  <small class="error text-danger" id="add_branch_ownership_error"></small>
                              </div>
                              
                          </div>
                          
                          <div class="own-wrap">
                              
                          </div>
                          
                          <div class="rental-wrap">
                              <div class="form-group row">
                                <div class="col-12 col-md-3">
                                    <label>Owner Name <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-12 col-md-6">
                                    <input type="text" name="branch_owner_name" class="form-control" />
                                    <small class="error text-danger" id="add_branch_owner_name_error"></small>
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
                                            <input type="text" name="branch_owner_phone" class="form-control telinput">
                                            <small class="error text-danger" id="add_branch_owner_phone_error"></small>
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
                                      <input type="text" name="rent_amount" class="form-control" style="min-height: 30px !important;height: 20px;">
                                    </div>
                                    <small class="error text-danger" id="add_rent_amount_error"></small>
                                </div>
                              </div>
                              
                              <div class="form-group row">
                                <div class="col-12 col-md-3">
                                    <label>Rent Due Date <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-12 col-md-6">
                                    <input type="date" name="rent_due_date" class="form-control " />
                                    <small class="error text-danger" id="add_rent_due_date_error"></small>
                                </div>
                              </div>
                          </div>
                          
                          
                          
                          <div class="form-group row">
                            <div class="col-12 col-md-3">
                                <label>Electricity Service Provider</label>
                            </div>
                            <div class="col-12 col-md-6">
                                <input type="text" name="electricity_service_provider" class="form-control">
                                <small class="error text-danger" id="add_electricity_service_provider_error"></small>
                            </div>
                          </div>
                          
                          <div class="form-group row">
                            <div class="col-12 col-md-3">
                                <label>Electricity Consumer Number</label>
                            </div>
                            <div class="col-12 col-md-6">
                                <input type="text" name="electricity_consumer_number" class="form-control">
                                <small class="error text-danger" id="add_electricity_consumer_number_error"></small>
                            </div>
                          </div>
                          
                          
                          <div class="form-group row">
                            <div class="col-12 col-md-3">
                                <label>Documents</label>
                            </div>
                            <div class="col-12 col-md-6">
                                <input type="file" name="documents[]" id="branch_documents" multiple class="form-control">
                                
                                <div id="previewContainer"
                                     style="margin-top:10px; display:flex; flex-wrap:wrap; gap:10px;">
                                </div>
                                <small class="error text-danger" id="add_documents_error"></small>
                            </div>
                          </div>
                          
                          <div class="form-group row">
                            <div class="col-12 col-md-3">
                                <label>Notes</label>
                            </div>
                            <div class="col-12 col-md-6">
                                <textarea type="textarea" name="notes" class="form-control" rows="4"></textarea>
                            </div>
                          </div>
                          
                          <div class="form-group row pb-">
                              <div class="col-12 col-md-3"><label>Status <span class="text-danger">*</span></label></div>
    
                              <div class="col-12 col-md-6">
                                  <div class="d-flex">
                                      <div class="form-check d-flex me-2">
                                          <input class="form-check-input" type="radio" name="status" id="exampleRadios1" value="Active" {{ old('status') == 'Active' ? 'checked' : '' }} >
                                          <label class="form-check-label" for="exampleRadios1">
                                              Active
                                          </label>
                                      </div>
        
                                      <div class="form-check d-flex">
                                          <input class="form-check-input" type="radio" name="status" id="exampleRadios2" value="Inactive" {{ old('status') == 'Inactive' ? 'checked' : '' }} >
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


<script type="text/javascript" src="{{asset('customjs/branch/create.js')}}"></script>

@endsection




