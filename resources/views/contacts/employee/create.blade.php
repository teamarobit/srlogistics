@extends('layouts.app')

@section('css')

<link rel="stylesheet" href="{{ asset('css/Contacts/Employee/create.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css" />


@endsection

@section('content')

<div class="layout-wrapper">
    @include('includes.header')
    
    
    <form class="wrapper srlog-bdwrapper" action="{{route('contact.'.str($cotype->slug)->lower().'.save')}}" id="addContactForm">   
        @csrf
        <div class="wrapper srlog-bdwrapper pt-0">
    
            <div class="itemtop-secwrap">
                <div class="container-fluid">
                    
                    <h5 class="d-inline-block">Add Employee </h5>

                    <div class="item1-cbdhed mb-4">
                        <div class="row align-items-end">
                            <div class="col-12 col-md-4">
                                <div class="gst-wrapper">
                                    <label>Name <span class="text-danger">*</span></label>
                                    <input type="text" name="contact_name" placeholder="Name" class="form-control" />
                                    <small class="error text-danger" id="add_contact_name_error"></small>
                                </div>
                            </div>

                            <div class="col-12 col-md-8 text-end">
                                <a href="javascript:void(0)" class="btn btn-dark me-2" id="addContactBtn">Save</a>
                                <a href="{{ route('contact.'.str($cotype->slug)->lower().'.index') }}" class="btn btn-danger me-2">Close</a>
                            </div>

                        </div>
                    </div>

                </div>

            </div>

            <div class="item2-cbdwrap">            
                <div class="container-fluid">
                    <div class="row">

                        <div class="col-12 col-md-4">
                            
                                
                                <div class="form-bg">
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <h6>About</h6>
                                        </div>
                                        <div class="col-12 col-md-6 text-end">
                                            <i data-bs-toggle="collapse" href="#collapse01" aria-expanded="true" aria-controls="collapse01" class="uil uil-angle-down"></i>
                                        </div>
                                    </div>

                                    <div class="collapse show" id="collapse01">
                                        <div class="contact-wrap">
                                            
                                            <div class="row form-group">
                                                <div class="col-12 col-md-5">
                                                    <label>Photo</label>
                                                </div>
                                                <div class="col-12 col-md-7">
                                                    <div class="upload__box">
                                                      <div class="upload__btn-box">
                                                        <label class="upload__btn">
                                                          <p class="btn btn-theme mb-0"><i class="uil uil-plus me-1"></i>Images</p>
                                                          <input type="file" name="contact_image" data-max_length="20" class="upload__inputfile">
                                                        </label>
                                                      </div>
                                                      <div class="upload__img-wrap"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row form-group">
                                                <div class="col-12 col-md-5">
                                                    <label>Phone <span class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-12 col-md-7">
                                                    <input type="hidden" name="phone_code" class="phone_code"> 
                                                    <input type="text" name="phone" class="form-control telinput"/>
                                                    <small class="error text-danger" id="add_phone_error"></small>
                                                </div>
                                            </div>
                                            
                                            <div class="row form-group">
                                                <div class="col-12 col-md-5">
                                                    <label>WhatsApp</label>
                                                </div>
                                                <div class="col-12 col-md-7">
                                                    <div class="row">
                                                        <input type="hidden" name="whatsapp_code" class="phone_code"> 
                                                        <div class="col-12 col-md-12">
                                                            <input type="text" name="whatsapp" class="form-control telinput" name="whatsapp" />
                                                            <small class="error text-danger" id="add_whatsapp_error"></small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row form-group">
                                                <div class="col-12 col-md-5">
                                                    <label>Email</label>
                                                </div>
                                                <div class="col-12 col-md-7">
                                                    <div class="row">
                                                        <div class="col-9 pe-0">
                                                            <input type="text" name="email" class="form-control" />
                                                            <small class="error text-danger" id="add_email_error"></small>
                                                        </div>
                                                        <div class="col-3">
                                                            <span class="badge bg-secondary"><i class="uil uil-envelope-alt"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row form-group">
                                                <div class="col-12 col-md-5">
                                                    <label>Gender <span class="text-danger">*</span></label>
                                                </div>

                                                <div class="col-12 col-md-7">
                                                    <div class="d-flex flex-wrap">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="gender" id="exampleRadios1" value="Male" />
                                                            <label class="form-check-label" for="exampleRadios1">
                                                                Male
                                                            </label>
                                                        </div>
                                                        <div class="form-check mx-2">
                                                            <input class="form-check-input" type="radio" name="gender" id="exampleRadios2" value="Female" />
                                                            <label class="form-check-label" for="exampleRadios2">
                                                                Female
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="gender" id="exampleRadios3" value="Others" />
                                                            <label class="form-check-label" for="exampleRadios3">
                                                                Others
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <small class="error text-danger" id="add_gender_error"></small>
                                                </div>
                                                
                                            </div>
                                            
                                            <div class="row form-group">
                                                <div class="col-12 col-md-5">
                                                    <label>Religion <span class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-12 col-md-7">
                                                    <select class="form-select select2" name="religion_id">
                                                        <option value="">Choose</option>
                                                    
                                                        @foreach($religions as $religion)
                                                            <option value="{{ $religion->id }}"
                                                                {{ old('religion_id', $user->religion_id ?? '') == $religion->id ? 'selected' : '' }}>
                                                                {{ $religion->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <small class="error text-danger" id="add_religion_id_error"></small>
                                                </div>
                                            </div>

                                            <div class="row form-group">
                                                <div class="col-12 col-md-5">
                                                    <label>Date of Birth <span class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-12 col-md-7">
                                                    <input type="date" class="form-control dob" name="dob" id="dob" max="{{ date('Y-m-d') }}" />
                                                    <small class="error text-danger" id="add_dob_error"></small>
                                                </div>
                                            </div>
                                            
                                            <div class="row form-group">
                                                <div class="col-12 col-md-5">
                                                    <label>Age</label>
                                                </div>
                                                <div class="col-12 col-md-7">
                                                    <input type="text" name="age" id="age" readonly class="form-control bg-light" />
                                                </div>
                                            </div>
                                            
                                            <div class="row form-group">
                                                <div class="col-12 col-md-5">
                                                    <label>Date of Joining <span class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-12 col-md-7">
                                                    <input type="date" name="doj" id="doj" class="form-control" max="{{ date('Y-m-d') }}" />
                                                    <small class="error text-danger" id="add_doj_error"></small>
                                                </div>
                                            </div>
                                            
                                            <div class="row form-group">
                                                <div class="col-12 col-md-5">
                                                    <label>Associated Since</label>
                                                </div>
                                                <div class="col-12 col-md-7">
                                                    <input type="text" name="associated_since" id="associated_since" class="form-control bg-light" value="" readonly />
                                                </div>
                                            </div>
                                            
                                            <div class="row form-group">
                                                <div class="col-12 col-md-5">
                                                    <label>Blood Group <span class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-12 col-md-7">  
                                                    <select name="blood_group" class="form-select select2">
                                                        <option value="">Choose</option>
                                                        @foreach (['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $group)
                                                            <option value="{{ $group }}" {{ old('blood_group') == $group ? 'selected' : '' }}>
                                                                {{ $group }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <small class="error text-danger" id="add_blood_group_error"></small>
                                                </div>
                                            </div>

                                            <div class="row form-group">
                                                <div class="col-12 col-md-5">
                                                    <label>Reference By <span class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-12 col-md-7">
                                                    <input type="text" name="reference_by" class="form-control" />
                                                    <small class="error text-danger" id="add_reference_by_error"></small>
                                                </div>
                                            </div>
                                            
                                            <div class="row form-group">
                                                
                                                <div class="col-12 col-md-5">
                                                    <label>Work Type <span class="text-danger">*</span></label>
                                                </div>

                                                <div class="col-12 col-md-7 d-flex">
                                                    <!--<div class="d-flex flex-wrap">-->
                                                        <div class="form-check office-work"> 
                                                            <input class="form-check-input WorkTypeRadio" type="radio" name="workType" id="officeWork" value="Office Work" />
                                                            <label class="form-check-label" for="officeWork">
                                                                Office Work
                                                            </label>
                                                        </div>
                                                        
                                                        <div class="form-check mx-2 service-center">
                                                            <input class="form-check-input WorkTypeRadio" type="radio" name="workType" id="serviceCenter" value="Service Center" />
                                                            <label class="form-check-label" for="serviceCenter">
                                                                Service Center
                                                            </label>
                                                        </div>
                                                    <!--</div>-->
                                                    <small class="error text-danger" id="add_workType_error"></small>
                                                </div>
                                                
                                            </div>
                                            
                                            
                                            <div class="office-work-wrap p-3 mb-2">
                                                
                                                <div class="row form-group">
                                                    <div class="col-12 col-md-5">
                                                        <label>Branch <span class="text-danger">*</span></label>
                                                    </div>
                                                    <div class="col-12 col-md-7">
                                                        <select name="office_branch_id" class="form-select select2">
                                                            <option value="">Select Branch</option>
                                                            @foreach ($branches as $branch)
                                                                <option value="{{ $branch->id }}">
                                                                    {{ $branch->location }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <small class="error text-danger" id="add_office_branch_id_error"></small>
                                                    </div>
                                                </div>
                                                
                                                <div class="row form-group">
                                                    <div class="col-12 col-md-5">
                                                        <label>Department <span class="text-danger">*</span></label>
                                                    </div>
                                                    <div class="col-12 col-md-7">
                                                        <select name="office_department_id" id="office_department_id" class="form-select select2">
                                                            <option value="">Select Department</option>
                                                        
                                                            @foreach ($departments as $department)
                                                                <option value="{{ $department->id }}">
                                                                    {{ $department->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <small class="error text-danger" id="add_office_department_id_error"></small>
                                                    </div>
                                                </div>
                                                
                                                <div class="row form-group">
                                                    <div class="col-12 col-md-5">
                                                        <label>Designation <span class="text-danger">*</span></label>
                                                    </div>
                                                    <div class="col-12 col-md-7">
                                                        <select name="office_designation_id" id="office_designation_id" class="form-select select2">
                                                            <option value="">Select Designation</option>
                                                            @foreach ($designations as $designation)
                                                                <option value="{{ $designation->id }}">
                                                                    {{ $designation->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <small class="error text-danger" id="add_office_designation_id_error"></small>
                                                    </div>
                                                </div>
                                                
                                                <div class="row form-group">
                                                    <div class="col-12 col-md-5">
                                                            <label>Job Rank <span class="text-danger">*</span></label>
                                                        </div>
                                                        <div class="col-12 col-md-7">
                                                        <select name="office_job_rank_id" id="office_job_rank_id" class="form-select select2">
                                                            <option value="">Select Job Rank</option>
                                                        
                                                            @foreach ($jobranks as $jobrank)
                                                                <option value="{{ $jobrank->id }}">
                                                                    {{ $jobrank->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <small class="error text-danger" id="add_office_job_rank_id_error"></small>
                                                    </div>
                                                </div>
                                                
                                                
                                                <div class="row form-group">
                                                    <div class="col-12 col-md-5">
                                                        <label>User Roles <span class="text-danger">*</span></label>
                                                    </div>
                                                    <div class="col-12 col-md-7">
                                                        <select name="office_role_ids[]" class="form-select select2" multiple>
                                                            <option value="">Select Roles</option>
                                                            @foreach ($roles as $role)
                                                                <option value="{{ $role->id }}">
                                                                    {{ $role->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <small class="error text-danger" id="add_role_id_error"></small>
                                                    </div>
                                                </div>
                                                
                                            </div>

                                            <div class="service-center-wrap">
                                                
                                                <div class="row form-group">
                                                    <div class="col-12">
                                                        <div class="row form-group">
                                                            
                                                            <div class="col-12 col-md-5">
                                                                <label>Service Type <span class="text-danger">*</span></label>
                                                            </div>
                                                            
                                                            <div class="col-12 col-md-7">
                                                                <div class="d-flex flex-wrap">
                                                                    <div class="form-check d-inline-block if-yes">
                                                                      <input class="form-check-input servicetTypeRadio" type="radio" name="service_type" id="administrative" value="Administrative" />
                                                                      <label class="form-check-label me-1" for="Administrative">Administrative</label>
                                                                    </div>
                                                                    
                                                                    <div class="form-check d-inline-block if-no">
                                                                      <input class="form-check-input servicetTypeRadio" type="radio" name="service_type" id="technical" value="Technical" />
                                                                      <label class="form-check-label" for="technical">Technical</label>
                                                                    </div>
                                                                </div>
                                                                <small class="error text-danger" id="add_service_type_error"></small>
                                                            </div> 
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                                
                                                
                                                <div class="admintech_wrapper">
                                                    
                                                    <div class="p-3 mb-2">
                                                        
                                                        <div class="row form-group">
                                                            <div class="col-12 col-md-5">
                                                                <label>Branch <span class="text-danger">*</span></label>
                                                            </div>
                                                            <div class="col-12 col-md-7">
                                                                <select name="service_center_branch_id" class="form-select select2">
                                                                    <option value="">Select Branch</option>

                                                                    @foreach($branches as $branch)
                                                                        <option value="{{ $branch->id }}">
                                                                            {{ $branch->location }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                <small class="error text-danger" id="add_service_center_branch_id_error"></small>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="row form-group">
                                                            <div class="col-12 col-md-5">
                                                                <label>Department <span class="text-danger">*</span></label>
                                                            </div>
                                                            <div class="col-12 col-md-7">
                                                                <select name="service_center_department_id" id="service_center_department_id" class="form-select select2">
                                                                    <option value="">Select Department</option>
                                                                    @foreach ($departments as $department)
                                                                        <option value="{{ $department->id }}">
                                                                            {{ $department->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                <small class="error text-danger" id="add_service_center_department_id_error"></small>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="row form-group">
                                                            <div class="col-12 col-md-5">
                                                                <label>Designation <span class="text-danger">*</span></label>
                                                            </div>
                                                            <div class="col-12 col-md-7">
                                                                <select name="service_center_designation_id" id="service_center_designation_id" class="form-select select2">
                                                                    <option value="">Select Designation</option>
                                                                    @foreach ($designations as $designation)
                                                                        <option value="{{ $designation->id }}">
                                                                            {{ $designation->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                <small class="error text-danger" id="add_service_center_designation_id_error"></small>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="row form-group">
                                                            <div class="col-12 col-md-5">
                                                                <label>Job Rank <span class="text-danger">*</span></label>
                                                            </div>
                                                            <div class="col-12 col-md-7">
                                                                <select name="service_center_jobrank_id" id="service_center_jobrank_id" class="form-select select2">
                                                                    <option value="">Select Job Rank</option>
            
                                                                    @foreach ($jobranks as $jobrank)
                                                                        <option value="{{ $jobrank->id }}">
                                                                            {{ $jobrank->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                <small class="error text-danger" id="add_service_center_jobrank_id_error"></small>
                                                            </div>
                                                        </div>
                                                        
                                                        
                                                        
                                                        <div class="row form-group">
                                                            <div class="col-12 col-md-5">
                                                                <label>User Roles <span class="text-danger">*</span></label>
                                                            </div>
                                                            <div class="col-12 col-md-7">
                                                                <select name="service_center_role_ids[]" class="form-select select2" multiple>
                                                                    <option value="">Select Roles</option>
                                                                    @foreach ($roles as $role)
                                                                        <option value="{{ $role->id }}">
                                                                            {{ $role->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                <small class="error text-danger" id="add_service_center_role_id_error"></small>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="row form-group SkillSetDiv">
                                                            <div class="col-12 col-md-5">
                                                                <label>Skill Set <span class="text-danger">*</span></label>
                                                            </div>
                                                            <div class="col-12 col-md-7">
                                                                <select name="servicecenter_technical_skillset_ids[]"
                                                                        id="servicecenter_technical_skillset_id"
                                                                        class="form-select select2"
                                                                        multiple>
                                                                    <option value="">Select Skill Set</option>
                                                                
                                                                    @foreach ($skillsets as $skillset)
                                                                        <option value="{{ $skillset->id }}">
                                                                            {{ $skillset->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                <small class="error text-danger" id="add_servicecenter_technical_skillset_ids_error"></small>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>

                                                </div>
                                                
                                                
                                            </div>
                                            
                                            
                                            
                                            <!--/////////////////////////////////////////////-->
                                            
                                            <div class="row form-group mt-4">
                                                <div class="col-12 col-md-5">
                                                    <label>Tracking Group <span class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-12 col-md-7">
                                                    <div class="d-flex flex-wrap">
                                                        <div class="form-check d-inline-block if-yes">
                                                          <input class="form-check-input" type="radio" name="tracking_group" id="trackingA" value="Tracking A" />
                                                          <label class="form-check-label" for="trackingA">Tracking A</label>
                                                        </div>
                                                        <div class="form-check d-inline-block if-no">
                                                          <input class="form-check-input" type="radio" name="tracking_group" id="trackingB" value="Tracking B" />
                                                          <label class="form-check-label" for="trackingB">Tracking B</label>
                                                        </div>
                                                    </div>
                                                    <small class="error text-danger" id="add_tracking_group_error"></small>
                                                </div>
                                            </div>
                                            
                                            <div class="row form-group mt-4">
                                              <div class="col-12 col-md-5">
                                                <label>Provident Fund Registered?</label>
                                              </div>
                                              <div class="col-12 col-md-7">
                                                <div class="d-flex flex-wrap">
                                                    <div class="form-check d-inline-block if-yes">
                                                      <input class="form-check-input" type="radio" name="providentFund" id="pf_yes" value="yes"/>
                                                      <label class="form-check-label" for="pf_yes">Yes</label>
                                                    </div>
                                                    <div class="form-check d-inline-block if-no">
                                                      <input class="form-check-input" type="radio" name="providentFund" id="pf_no" value="no"/>
                                                      <label class="form-check-label" for="pf_no">No</label>
                                                    </div>
                                                </div>
                                                <small class="error text-danger" id="add_providentFund_error"></small>
                                              </div>
                                              
                                            </div>
                                            
                                            
                                            <!-- Provident Fund Number (Initially hidden) -->
                                            <div class="row form-group mt-4" id="pf_number_field" style="display: none;">
                                              <div class="col-12 col-md-5">
                                                <label>Provident Fund Number</label>
                                              </div>
                                              <div class="col-12 col-md-7">
                                                <input type="text" name="provident_fund_no" value="" class="form-control" />
                                                <small class="error text-danger" id="add_provident_fund_no_error"></small>
                                              </div>
                                            </div>
                                            
                                            <!--//////////////////////////////////////////////////////-->

                                            <div class="row form-group">
                                                <div class="col-12 col-md-5">
                                                    <label>Comment About Contact</label>
                                                </div>
                                                <div class="col-12 col-md-7">
                                                    <textarea name="comment" class="form-control" rows="3" placeholder=""></textarea>
                                                    <small class="error text-danger" id="add_comment_error"></small>
                                                </div>
                                            </div>
                                        </div>
                                        <!---->
                                    </div>
                                </div>

                                <div class="form-bg">
                                    <div class="row">
                                        <div class="col-12 col-md-9">
                                            <h6>Emergency Contact Details</h6>
                                        </div>
                                        <div class="col-12 col-md-3 text-end">
                                            <i data-bs-toggle="collapse" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo" class="uil uil-angle-down"></i>
                                        </div>
                                    </div>

                                    <div class="collapse show" id="collapseTwo">
                                        <div class="contact-wrap">
                                            <div id="contactPersonContainer">
                                                
                                                <div class="row form-group">
                                                    <div class="col-12 col-md-5">
                                                        <label>Name <span class="text-danger">*</span></label>
                                                    </div>
                                                    <div class="col-12 col-md-7">
                                                        <input type="text" class="form-control" name="contact_person_name[]">
                                                        <div class="error text-danger cpnameerr" id="add_contact_person_name_0_error"></div>
                                                    </div>
                                                </div>
                                              
                                                <div class="row form-group">
                                                    <div class="col-12 col-md-5">
                                                        <label><span class="cpdglbl">Relation </span></label>
                                                    </div>
                                                    <div class="col-12 col-md-7">
                                                        <input type="text" class="form-control" name="contact_person_relation[]">
                                                        <div class="error text-danger cpdgerr" id="add_contact_person_relation_0_error"></div>
                                                    </div>
                                                </div>
  
                                                <div class="row form-group">
                                                    <div class="col-12 col-md-5">
                                                        <label><span class="cpdglbl">Blood Group </span></label>
                                                    </div>
                                                    <div class="col-12 col-md-7">
                                                        <select name="contact_person_blood_group[]" class="form-select select2">
                                                            <option value="">Choose</option>
                                                            @foreach (['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $group)
                                                                <option value="{{ $group }}" {{ old('blood_group') == $group ? 'selected' : '' }}>
                                                                    {{ $group }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <div class="error text-danger cpdgerr" id="add_contact_person_blood_group_0_error"></div>
                                                    </div>
                                                </div>
  
                                                <div class="row form-group">
                                                    <div class="col-12 col-md-5">
                                                        <label><span class="cpdglbl">Address </span></label>
                                                    </div>
                                                    <div class="col-12 col-md-7">
                                                        <input type="text" class="form-control" name="contact_person_address[]">
                                                        <div class="error text-danger cpdgerr" id="add_contact_person_address_0_error"></div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row form-group">
                                                    <div class="col-12 col-md-5">
                                                          <label>Phone <span class="text-danger">*</span></label>
                                                    </div>
                                                    <div class="col-12 col-md-7">
                                                        <div class="row">
                                                            <input type="hidden" name="contact_person_ph_code[]" class="phone_code">
                                                            <div class="col-12 col-md-12">
                                                                <input type="text" class="form-control telinput " name="contact_person_phone[]">
                                                                <div class="error text-danger cpph" id="add_contact_person_phone_0_error"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row form-group">
                                                    <div class="col-12 col-md-5">
                                                        <label>WhatsApp</label>
                                                    </div>
                                                    <div class="col-12 col-md-7">
                                                        <div class="row">
                                                            <input type="hidden" name="contact_person_whatsapp_code[]" class="phone_code">
                                                            <div class="col-12 col-md-12">
                                                                <input type="text" class="form-control telinput " name="contact_person_whatsapp[]" />
                                                                <div class="error text-danger cpph" id="add_contact_person_whatsapp_0_error"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row form-group">
                                                  <div class="col-12 col-md-5">
                                                      <label>Email</label>
                                                  </div>
                                                  <div class="col-12 col-md-7">
                                                      <div class="row">
                                                          <div class="col-9 pe-0">
                                                              <input type="text" class="form-control" name="contact_person_email[]">
                                                              <div class="error text-danger cpeml" id="add_contact_person_email_0_error"></div>
                                                          </div>
                                                          <div class="col-3">
                                                              <span class="badge bg-secondary"><i class="uil uil-envelope-alt"></i></span>
                                                          </div>
                                                      </div>
                                                  </div>
                                                </div>
                                                
                                                <div class="row form-group">
                                                  <div class="col-12 col-md-5">
                                                      <label>Comment</label>
                                                  </div>
                                                  <div class="col-12 col-md-7">
                                                      <textarea class="form-control" rows="3" placeholder="" name="contact_person_comment[]"></textarea>
                                                      <div class="error text-danger cpcmt" id="add_contact_person_comment_0_error"></div>
                                                  </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-3">
                                            <a href="javascript:void(0)" class="btn btn-theme add-person"><i class="uil uil-plus me-1"></i>Emergency Contact</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-bg">
                                    <div class="row">
                                        <div class="col-12 col-md-9">
                                            <h6>Permanent Address</h6>
                                        </div>
                                        <div class="col-12 col-md-3 text-end">
                                            <i data-bs-toggle="collapse" href="#collapse03" aria-expanded="true" aria-controls="collapse03" class="uil uil-angle-down"></i>
                                        </div>
                                    </div>
                                    
                                    <div class="collapse show" id="collapse03">
                                        <div class="row form-group">
                                            <div class="col-12 col-md-5">
                                                <label>Address <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <textarea name="permanent_address" id="permanentAddr" class="form-control" rows="3" placeholder=""></textarea>
                                                <small class="error text-danger" id="add_permanent_address_error"></small>
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-12 col-md-5">
                                                <label>State <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <select class="form-select select2 dependent-select" name="permanent_addr_state_id" id="permanentAddrState" data-target="permanentAddrCity">
                                                    <option value="">Choose..</option>
                                                    @foreach ($states as $state)
                                                        <option value="{{ $state->id }}" data-url="{{ route('getcities', $state->id) }}"
                                                            {{ old('state_id') == $state->id ? 'selected' : '' }}>
                                                            {{ $state->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <small class="error text-danger" id="add_permanent_addr_state_id_error"></small>
                                            </div>
                                        </div>
                                        
                                        <div class="row form-group">
                                            <div class="col-12 col-md-5">
                                                <label>City </label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <select class="form-select select2" name="permanent_addr_city_id" id="permanentAddrCity">
                                                    <option value="">Choose..</option>
                                                </select>
                                                <small class="error text-danger" id="add_permanent_addr_city_id_error"></small>
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-12 col-md-5">
                                                <label>Postal Code  <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <input type="text" name="permanent_addr_postal_code" id="permanentAddrPostalCode" class="form-control" />
                                                <small class="error text-danger" id="add_permanent_addr_postal_code_error"></small>
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-12 col-md-5">
                                                <label>Additional Info</label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <textarea type="textarea" name="permanent_addr_additional_info" id="permanentAddrAdditionalInfo" class="form-control" rows="3" placeholder="Additional Info"></textarea>
                                                <small class="error text-danger" id="add_permanent_addr_additional_info_error"></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-bg">
                                    <div class="row">
                                        <div class="col-12 col-md-9">
                                            <h6>Present Address</h6>
                                            <div class="form-check mb-3">
                                                <input class="form-check-input same-as-permanent-address" type="checkbox" value="" id="flexCheckDefault" />
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    Same as Permanent Address
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-3 text-end">
                                            <i data-bs-toggle="collapse" href="#collapse03" aria-expanded="true" aria-controls="collapse03" class="uil uil-angle-down"></i>
                                        </div>
                                    </div>
                                    <div class="collapse show" id="collapse03">
                                        <div class="row form-group">
                                            <div class="col-12 col-md-5">
                                                <label>Address <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <textarea name="present_address" id="presentAddr" class="form-control" rows="3" placeholder=""></textarea>
                                                <small class="error text-danger" id="add_present_address_error"></small>
                                            </div>
                                        </div>

                                        

                                        <div class="row form-group">
                                            <div class="col-12 col-md-5">
                                                <label>State <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <select class="form-select select2 dependent-select" name="present_addr_state_id" id="presentAddrState" data-target="presentAddrCity">
                                                    <option value="">Choose..</option>
                                                    @foreach ($states as $state)
                                                        <option value="{{ $state->id }}" data-url="{{ route('getcities', $state->id) }}"
                                                            {{ old('state_id') == $state->id ? 'selected' : '' }}>
                                                            {{ $state->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <small class="error text-danger" id="add_present_addr_state_id_error"></small>
                                            </div>
                                        </div>
                                        
                                        <div class="row form-group">
                                            <div class="col-12 col-md-5">
                                                <label>City </label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <select class="form-select select2" name="present_addr_city_id" id="presentAddrCity">
                                                    <option value="">Choose..</option>
                                                </select>
                                                <small class="error text-danger" id="add_present_addr_city_id_error"></small>
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-12 col-md-5">
                                                <label>Postal Code  <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <input type="text" name="present_addr_postal_code" id="presentAddrPostalCode" class="form-control" />
                                                <small class="error text-danger" id="add_present_addr_postal_code_error"></small>
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-12 col-md-5">
                                                <label>Additional Info</label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <textarea type="textarea" name="present_addr_additional_info" id="presentAddrAdditionalInfo" class="form-control" rows="3" placeholder="Additional Info"></textarea>
                                                <small class="error text-danger" id="add_present_addr_additional_info_error"></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                 <div class="form-bg">
                                    <div class="row">
                                        <div class="col-12 col-md-9">
                                            <h6>Bank Details</h6>
                                        </div>
                                        <div class="col-12 col-md-3 text-end">
                                            <i data-bs-toggle="collapse" href="#collapse05" aria-expanded="true" aria-controls="collapse05" class="uil uil-angle-down"></i>
                                        </div>
                                    </div>

                                    <div class="collapse show" id="collapse05">

                                        <div class="row form-group">
                                            <div class="col-12 col-md-5">
                                                <label>Bank Name</label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <select name="bank_id" class="form-select select2">
                                                    <option value="">Choose..</option>
                                                    @foreach ($banks as $bank)
                                                    <option value="{{ $bank->id }}">
                                                        {{ $bank->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                <small class="error text-danger" id="add_bank_id_error"></small>
                                            </div>
                                        </div>
                                        
                                        <div class="row form-group">
                                            <div class="col-12 col-md-5">
                                                <label>Beneficiary Name</label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <input type="text" name="beneficiary_name" class="form-control" />
                                                <small class="error text-danger" id="add_beneficiary_name_error"></small>
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-12 col-md-5">
                                                <label>Account Number</label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <input type="text" name="account_number" class="form-control" />
                                                <small class="error text-danger" id="add_account_number_error"></small>
                                            </div>
                                        </div>
                                        
                                        <div class="row form-group">
                                            <div class="col-12 col-md-5">
                                                <label>IFSC Code</label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <input type="text" name="ifsc_code" class="form-control" />
                                                <small class="error text-danger" id="add_ifsc_code_error"></small>
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-12 col-md-5">
                                                <label>UPI ID</label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <input type="text" name="upi_id" class="form-control" />
                                                <small class="error text-danger" id="add_upi_id_error"></small>
                                            </div>
                                        </div>                                      

                                    </div>
                                </div>
                            
                        </div>

                        <div class="col-12 col-md-8 mt-4">
                            <div class="right-side-wrap">

                                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link disabled" data-bs-toggle="tab" data-bs-target="#joining" type="button" role="tab">
                                            Joining
                                        </button>
                                    </li>
                                    
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="e-document-tab" data-bs-toggle="pill" data-bs-target="#e-document-contact" type="button" role="tab" aria-controls="e-document-contact" aria-selected="true">Document</button>
                                    </li>
                                    
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link disabled" id="e-asset-tab" data-bs-toggle="pill" data-bs-target="#e-asset-attachments" type="button" role="tab" aria-controls="e-asset-attachments" aria-selected="false">
                                            Assets
                                        </button>
                                    </li>
                                    
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link disabled" id="e-leave-tab" data-bs-toggle="pill" data-bs-target="#e-leave-attachments" type="button" role="tab" aria-controls="e-leave-attachments" aria-selected="false">
                                            Leave Tracker
                                        </button>
                                    </li>

                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link disabled" id="e-salary-tab" data-bs-toggle="pill" data-bs-target="#e-salary-attachments" type="button" role="tab" aria-controls="e-salary-attachments" aria-selected="false">
                                            Salary
                                        </button>
                                    </li>
                                    
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link disabled" data-bs-toggle="tab" data-bs-target="#exit" type="button" role="tab">
                                            Exit
                                        </button>
                                    </li>

                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link disabled" id="e-activity-tab" data-bs-toggle="pill" data-bs-target="#e-activity-management" type="button" role="tab" aria-controls="e-activity-management" aria-selected="false">Activity</button>
                                    </li>
                                    
                                </ul>

                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade " id="joining" role="tabpanel">
                                        <div class="no-data">
                                            <p class="text-dark mb-0">No Data Found</p>
                                        </div>

                                        <div class="dm-documentwrapper">

                                           <div class="doc-wrap">
                                            <h5 class="mt-3">Joining Details</h5>
                                            
                                                <div class="row form-group">
                                                    <div class="col-12 col-md-12">
                                                        
                                                        <div class="row">
                                                            
                                                            <div class="col-12 col-md-3 d-flex align-items-center">
                                                                <label>Total Work Experience <span class="text-danger">*</span></label>    
                                                            </div>
                                                            
                                                            <div class="col-12 col-md-3 d-flex align-items-center">
                                                                
                                                                <input type="number" class="form-control" value="0">
                                                                <label class="ms-2">Years</label>
                                                            </div>
                                                            
                                                            <div class="col-12 col-md-3 d-flex align-items-center">
                                                                <input type="number" class="form-control" value="0">
                                                                <label class="ms-2">Month</label>
                                                            </div>
                                                                <div class="col-12 col-md-3 d-flex align-items-center">
                                                                <div class="row">
                                                                    <div class="col-12 d-flex justify-content-end">
                                                                        <button type="button" class=" btn btn-theme mb-0 ms-2" data-bs-toggle="modal" data-bs-target="#experience01_btn" style="color: #261f35; font-size: 13px;">
                                                                            <i class="uil uil-plus me-1"></i> Experience</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                                
                                                   
                                            
                                            <!--//////////////////////////////////////////////////////////-->
                                            <table class="table">
                                            <thead>
                                                <tr>
                                                <th>Company Name</th>
                                                <th>Designation </th>
                                                <th>Employment Duration </th>
                                                <th>Legal / Police Case </th>
                                                <th>Police Station</th>
                                                
                                                <th>Exit Reason</th>
                                                </tr>
                                            </thead>
                                           
                                          <tbody>
                                              
                                            <tr>
                                                <td>895465</td>
                                                <td>Khalasi</td>
                                                <td>27/01/2026 - 27/01/20265</td>
                                                <td><span class="tag">Yes</span></td>
                                                <td>Kolkata</td>
                                                <td>Work Pressure</td>
                                            </tr>
                                            
                                            <tr>
                                                <td>890665</td>
                                                <td>Driver</td>
                                                <td>27/01/2026 - 27/01/2026</td>
                                                <td><span class="tag">No</span></td>
                                                <td></td>
                                                <td>Salary Issue</td>
                                            </tr>
                                           
                                            
                                           
                                          </tbody>  
                                           
                                     </table>
                                            
                                            <!--//////////////////////////////////////////////////////////-->
                                            
                                            
                                            
                                        </div>
                                               
                                        </div>
                                    </div>
                                    
                                    <div class="tab-pane fade show active" id="e-document-contact" role="tabpanel" aria-labelledby="e-document-tab">
                                        <div class="employee-dwrapper">
                                            <div class="form-section">
                                                <!-- First Item Row -->
    
                                                <div class="item-row">
                                                    <div class="row form-group align-items-center">
                                                        <div class="col-12 col-md-2">
                                                            <label>Document Type: <!--<span class="text-danger">*</span>--></label>
                                                        </div>
                                                        <div class="col-12 col-md-6">
                                                            <select class="form-select select2 atypin" name="coattachtypes[]" id="coattachtypes_0">
                                                                <option value="">Select ID</option>
                                                                @if( $coattachtypes->count())
                                                                    @foreach( $coattachtypes as $type)
                                                                       <option value="{{$type->id}}">{{$type->name}}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                            <small class="error text-danger atyperr" id="add_coattachtype_0_error"></small>
                                                        </div>
                                                    </div>
    
                                                    <hr />
                                                    
                                                    <!--dropzone-->
                                                    <div class="dropzone" id="dropzone0">
                                                        <div class="dz-message needsclick">
                                                            <i class="uil uil-upload me-2"></i>
                                                            Drop files here or click to upload (Max 2 files)
                                                        </div>
                                                    </div>
                                                    <small class="error text-danger atterr" id="add_coattachments_0_error"></small>
    
                                                    
                                                    <div class="d-flex justify-content-between mt-2">
                                                        <button type="button" class="add-item btn btn-success btn-sm" id="add_attachment_btn"><i class="uil uil-plus"></i> Add New</button>
                                                    </div>
                                                    
                                                    
                                                </div>
                                                <div id="uploadContainer"></div>
    
                                                <!-- Add New -->
                                            </div>
                                            <!---->
                                        </div>
                                    </div>
                                    
                                    <div class="tab-pane fade" id="e-asset-attachments" role="tabpanel" aria-labelledby="e-asset-tab">
                                        <!--////////////////////////////-->
                                        
                                        <div class="row mt-0 align-items-center">
                                            <div class="col-12 col-md-9">
                                                <h6>Alloted Asset</h6>
                                            </div>
                                            <div class="col-12 col-md-3 text-end">
                                                <a href="javascript:void(0)" class="btn btn-theme" data-bs-toggle="modal" data-bs-target="#assettypeModal"><i class="uil uil-plus me-1"></i> Assign Asset</a>
                                            </div>
                                        </div>
                                        
                                        <div class="table-responsive mt-3">
                                            <table class="table table-hover invoice-table mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            Asset ID
                                                        </th>
                                                        <th>Category</th>
                                                        <th>Name</th>
                                                        <th>Make</th>
                                                        <th>Model</th>
                                                        <th>Issue Date</th>
                                                        <th>Assigned On</th>
                                                        <th>Assigned By</th>
                                                        <th>Comments</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    
                                                    <tr>
                                                        <td>
                                                            #001
                                                        </td>
                                                        <td>Electronic</td>
                                                        <td>Dell Inspiron Laptop</td>
                                                        <td>
                                                            1120
                                                        </td>
                                                        <td>
                                                            1120
                                                        </td>
                                                        <td>Dell</td>
                                                        <td>22/10/2025</td>
                                                        <td>Nitesh Sharma</td>
                                                        <!--<td>--</td>-->
                                                        <!--<td>02/10/2025</td>-->
                                                        <td>Condition is okay.</td>
                                                    </tr>
                                                    
                                                    <tr>
                                                        <td>#002</td>
                                                        <td>Product</td>
                                                        <td>Dell Inspiron Laptop</td>
                                                        <td>1122</td>
                                                        <td>1120</td>
                                                        <td>Dell</td>
                                                        <td>25/09/2025</td>
                                                        <td>Nikhil Shetty</td>
                                                        <td>Condition is okay.</td>
                                                    </tr>
                                                    
                                                    <tr>
                                                        <td>#003</td>
                                                        <td>Product</td>
                                                        <td>Dell Inspiron Laptop</td>
                                                        <td>1123</td>
                                                        <td>1130</td>
                                                        <td>Dell</td>
                                                        <td>20/10/2025</td>
                                                        <td>Paresh Goenka</td>
                                                        <td>Condition is okay.</td>
                                                    </tr>
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                        
                                        <div class="mt-3">
                                            <h6>History</h6>
                                            
                                            <div class="table-responsive mt-3">
                                            <table class="table table-hover invoice-table mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            Asset ID
                                                        </th>
                                                        <th>Category</th>
                                                        <th>Name</th>
                                                        <th>Make</th>
                                                        <th>Model</th>
                                                        <th>Assigned On <br> Assigned By</th>
                                                        <th>Revoked On <br>Revoked By</th>
                                                        <th>Comments</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    
                                                    <tr>
                                                        <td>
                                                            #001
                                                        </td>
                                                        <td>Electronic</td>
                                                        <td>Dell Inspiron Laptop</td>
                                                        <td>
                                                            1120
                                                        </td>
                                                        <td>
                                                            1120
                                                        </td>
                                                        <td>22/10/2025<span class="d-block">Nitesh Sharma</span></td>
                                                        <td>22/10/2025</td>
                                                        <td>Condition is okay.</td>
                                                    </tr>
                                                    
                                                    <tr>
                                                        <td>#002</td>
                                                        <td>Product</td>
                                                        <td>Dell Inspiron Laptop</td>
                                                        <td>1122</td>
                                                        <td>1120</td>
                                                        <td>12/11/2025<span class="d-block">Paresh Goenka</span></td>
                                                        <td>25/09/2025</td>
                                                        <td>Condition is okay.</td>
                                                    </tr>
                                                    
                                                    <tr>
                                                        <td>#003</td>
                                                        <td>Product</td>
                                                        <td>Dell Inspiron Laptop</td>
                                                        <td>1123</td>
                                                        <td>1130</td>
                                                        <td>10/09/2025<span class="d-block">Suman Das</span></td>
                                                        <td>20/10/2025</td>
                                                        <td>Condition is okay.</td>
                                                    </tr>
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                            
                                                        
                                            
                                        </div>
                                    </div>
                                    
                                    <div class="tab-pane fade" id="e-leave-attachments" role="tabpanel" aria-labelledby="e-leave-tab">
                                        <!--////////////////////////////-->

                                        <div class="row mt-0 align-items-center">
                                            <div class="col-12">
                                                <h6>Attendance Status</h6>
                                                <div class="row leave-tracker-wrap">
                                    			    <div class="col-12 col-md-4">
                                    			        <div class="row">
                                    			            <div class="col-md-9">
                                            			        <p>Present:</p>
                                            			    </div> 
                                            			    <div class="col-md-3">
                                            			        <div class="attendance-status present">P</div>
                                            			    </div> 
                                    			        </div>
                                    			    </div>
                                    			    
                                    			    <div class="col-12 col-md-4">
                                    			        <div class="row">
                                    			            <div class="col-md-9">
                                            			        <p>Holiday</p>
                                            			    </div>
                                            			    <div class="col-md-3">
                                            			        <div class="attendance-status holiday">H</div>
                                            			    </div>
                                    			        </div>
                                    			    </div>
                                    			    
                                    			    <div class="col-12 col-md-4">
                                    			        <div class="row">
                                    			            <div class="col-md-9">
                                            			        <p>Weekoff</p>
                                            			    </div>
                                            			    <div class="col-md-3">
                                            			        <div class="attendance-status weekoff">W</div>
                                            			    </div>
                                    			        </div>
                                    			    </div>
                                    			    
                                    			    <div class="col-12 col-md-4">
                                    			        <div class="row">
                                    			            <div class="col-md-9">
                                            			        <p>Casual Leave:</p>
                                            			    </div>
                                            			    <div class="col-md-3">
                                            			        <div class="attendance-status halfday">CL</div>
                                            			    </div>
                                    			        </div>
                                    			    </div>
                                    			    
                                    			    <div class="col-12 col-md-4">
                                    			        <div class="row">
                                    			            <div class="col-md-9">
                                            			        <p>Sick Leave:</p>
                                            			    </div>
                                            			    <div class="col-md-3">
                                            			        <div class="attendance-status leave">SL</div>
                                            			    </div>
                                    			        </div>
                                    			    </div>
                                    			    
                                    			    <div class="col-12 col-md-4">
                                    			        <div class="row">
                                    			            <div class="col-md-9">
                                            			        <p>Unpaid Leave:</p>
                                            			    </div>
                                            			    <div class="col-md-3">
                                            			        <div class="attendance-status absent">UL</div>
                                            			    </div>
                                    			        </div>
                                    			    </div>
                                    			</div>
                                            </div>
                                        </div>
                                        <article class="mt-2">
                                          <h6>August 2022</h6>
                                		  <ul class="days">
                                		    <li>Sun</li>
                                		    <li>Mon</li>
                                		    <li>Tues</li>
                                		    <li>Wed</li>
                                		    <li>Thurs</li>
                                		    <li>Fri</li>
                                		    <li>Sat</li>
                                		  </ul>
                                			<ul class="dates">
                                                <li class="fade">
                                                    <span class="date">29</span>
                                                    <div class="multidayHolder"><a href="javascript:void(0)" class="attendance-status weekoff">W</a></div>
                                                </li>
                                                <li class="fade">
                                                    <span class="date">30</span>
                                                    <div class="multidayHolder"><a href="javascript:void(0)" class="attendance-status present">P</a></div>
                                                </li>
                                        				<li>
                                        				    <span class="date">1</span>
                                        				    <div class="multidayHolder"><a href="javascript:void(0)" class="attendance-status halfday">H1</a></div>
                                        				</li>
                                        				<li>
                                                  <section class="dateWrapper">
                                        					<span class="date">2</span>
                                        					<div class="multidayHolder"><a href="javascript:void(0)" class="attendance-status present">P</a></div>
                                                  </section>
                                        				</li>
                                        				<li class="current today">
                                                    <section class="dateWrapper">
                                                      <span class="date">3</span>
                                                      <div class="multidayHolder"><a href="javascript:void(0)" class="attendance-status present">P</a></div>
                                                     </section>
                                        		    	</li>
                                        				<li>
                                        				    <span class="date">4</span>
                                        				    <div class="multidayHolder"><a href="javascript:void(0)" class="attendance-status present">P</a></div>
                                        		        </li>
                                        				<li><span class="date">5</span><div class="multidayHolder"><a href="javascript:void(0)" class="attendance-status weekoff">W</a></div></li>
                                        				<li><span class="date">6</span><div class="multidayHolder"><a href="javascript:void(0)" class="attendance-status weekoff">W</a></div></li>
                                        				<li><span class="date">7</span><div class="multidayHolder"><a href="javascript:void(0)" class="attendance-status present">P</a></div></li>
                                        				<li><span class="date">8</span><div class="multidayHolder"><a href="javascript:void(0)" class="attendance-status present">P</a></div></li>
                                        				<li><span class="date">9</span><div class="multidayHolder"><a href="javascript:void(0)" class="attendance-status leave">S</a></div></li>
                                        				<li><span class="date">10</span><div class="multidayHolder"><a href="javascript:void(0)" class="attendance-status present">P</a></div></li>
                                        				<li><span class="date">11</span><div class="multidayHolder"><a href="javascript:void(0)" class="attendance-status present">P</a></div></li>
                                        				<li><span class="date">12</span><div class="multidayHolder"><a href="javascript:void(0)" class="attendance-status weekoff">W</a></div></li>
                                        				<li><span class="date">13</span><div class="multidayHolder"><a href="javascript:void(0)" class="attendance-status weekoff">W</a></div></li>
                                        				<li><span class="date">14</span><div class="multidayHolder"><a href="javascript:void(0)" class="attendance-status present">P</a></div></li>
                                        				<li><span class="date">15</span><div class="multidayHolder"><a href="javascript:void(0)" class="attendance-status holiday">H</a></div></li>
                                        				<li>
                                        					<span class="date">16</span>
                                        					<div class="multidayHolder"><a href="javascript:void(0)" class="attendance-status leave">L</a></div>
                                        				</li>
                                        				<li>
                                        					<span class="date">17</span>
                                        					<div class="multidayHolder"><a href="javascript:void(0)" class="attendance-status leave">L</a></div>
                                        				</li>
                                        				<li>
                                        					<span class="date">18</span>
                                        					<div class="multidayHolder"><a href="javascript:void(0)" class="attendance-status present">P</a></div>
                                        				</li>
                                        				<li>
                                        					<span class="date">19</span>
                                        					<div class="multidayHolder"><a href="javascript:void(0)" class="attendance-status weekoff">W</a></div>
                                        				</li>
                                        				<li><span class="date">20</span><div class="multidayHolder"><a href="javascript:void(0)" class="attendance-status weekoff">W</a></div></li>
                                        				<li><span class="date">21</span> <div class="multidayHolder"><a href="javascript:void(0)" class="attendance-status present">P</a></div></li>
                                        				<li><span class="date">22</span><div class="multidayHolder"><a href="javascript:void(0)" class="attendance-status present">P</a></div></li>
                                        				<li><span class="date">23</span><div class="multidayHolder"><a href="javascript:void(0)" class="attendance-status present">P</a></div></li>
                                        				<li><span class="date">24</span><div class="multidayHolder"><a href="javascript:void(0)" class="attendance-status present">P</a></div></li>
                                        				<li><span class="date">25</span><div class="multidayHolder"><a href="javascript:void(0)" class="attendance-status present">P</a></div></li>
                                        				<li><span class="date">26</span><div class="multidayHolder"><a href="javascript:void(0)" class="attendance-status weekoff">W</a></div></li>
                                        				<li><span class="date">27</span><div class="multidayHolder"><a href="javascript:void(0)" class="attendance-status weekoff">W</a></div></li>
                                        				<li><span class="date">28</span><div class="multidayHolder"><a href="javascript:void(0)" class="attendance-status present">P</a></div></li>
                                        				<li><span class="date">29</span><div class="multidayHolder"><a href="javascript:void(0)" class="attendance-status present">P</a></div></li>
                                        				<li><span class="date">30</span><div class="multidayHolder"><a href="javascript:void(0)" class="attendance-status present">P</a></div></li>
                                        		     	<li><span class="date">31</span><div class="multidayHolder"><a href="javascript:void(0)" class="attendance-status absent">A</a></div></li>
                                        				<li class="fade"><span class="date">1</span><div class="multidayHolder"><a href="javascript:void(0)" class="attendance-status present">P</a></div></li>
                                        				<li class="fade"><span class="date">2</span><div class="multidayHolder"><a href="javascript:void(0)" class="attendance-status weekoff">W</a></div></li>
                                        			</ul>
                                        		</article>
                                    </div>
                                    
                                    <div class="tab-pane fade" id="e-salary-attachments" role="tabpanel" aria-labelledby="e-salary-tab">
                                        <!--////////////////////////////-->

                                        <div class="row mt-0 align-items-center">
                                            <div class="col-12 col-md-9">
                                                <h6>Salary Information</h6>
                                            </div>
                                            <div class="col-12 col-md-3 text-end">
                                                <a href="javascript:void(0)" class="btn btn-theme" data-bs-toggle="modal" data-bs-target="#reviseSalary"><i class="uil uil-plus me-1"></i> Revise Salary</a>
                                            </div>
                                        </div>
                                        
                                        <div class="table-responsive mt-3">
                                            <table class="table table-hover invoice-table mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            Basic Salary
                                                        </th>
                                                        <th>Salary/Day</th>
                                                        <th>Salary/Hour</th>
                                                        <th>Effective Date</th>
                                                        <th>Last Revision Done On</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            Rs. 20,000
                                                        </td>
                                                        <td>Rs. 2000</td>
                                                        <td>Rs. 200</td>
                                                        <td>
                                                            20/03/2024
                                                        </td>
                                                        <td>
                                                            22/03/2024
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <!-- <div class="no-data">
                                        <p class="text-dark mb-0">No Data Found</p>
                                        </div> -->

                                        <!--////////////////////////////-->
                                    </div>
                                    
                                    <div class="tab-pane" id="exit" role="tabpanel">
                                        <!--////-->
                                        
                                        <div class="no-data">
                                            <p class="text-dark mb-0">No Data Found</p>
                                        </div>

                                        <!--///////////////////////ssssssssssssss//////////////////ssssssssswwww///////////wwwwwwwww/////////////-->
                                        
                                        <div class="doc-wrap">
                                                 

                                                <div class="row form-group">
                                                    
                                                    <div class="col-12 col-md-6 mb-4">
                                                        <label class="mb-2">Reason for Exit <span class="text-danger">*</span></label>
                                                        <textarea class="form-control" rows="3" placeholder=""></textarea>
                                                    </div>
                                                    
                                                    <div class="col-12 col-md-6 mb-4">
                                                        <label class="mb-2">Exit Date <span class="text-danger">*</span></label>
                                                        <input class="form-control bg-light text-uppercase" type="date" placeholder="DD/MM/YY">
                                                    </div>
                                                    
                                                    <div class="col-12 col-md-6 mb-4">
                                                        <label class="mb-2">Feedback <span class="text-danger">*</span></label>
                                                        <textarea class="form-control" rows="3" placeholder=""></textarea>
                                                    </div>
                                                    
                                                </div>
                                                
                                            </div>
                                        
                                        <!--///////////////////////ssssssssssssss//////////////////ssssssssswwww///////////wwwwwwwww/////////////-->
                                        

                                        <!-- <div class="no-data">
                                        <p class="text-dark mb-0">No Data Found</p>
                                        </div> -->

                                        <!--////////////////////////////-->
                                    </div>
                                    
                                    <div class="tab-pane fade" id="e-activity-management" role="tabpanel" aria-labelledby="e-activity-tab">

                                        <!--  <div class="no-data">
                                            <p class="text-dark mb-0">No Data Found</p>
                                        </div> -->

                                        <!----------------------------------------------------->

                                        <div class="e-activitywrapper">
                                            <!-- <div class="no-data">
                                                                        <p class="text-dark mb-0">No Data Found</p>
                                                                    </div>  -->

                                            <div class="note-wrap">
                                                <div class="form-group">
                                                    <label>Note</label>
                                                    <textarea class="form-control" rows="4" placeholder="Write your message here"></textarea>
                                                </div>
                                            </div>

                                            <div class="cmnt-wrap mt-4">
                                                <div class="d-flex">
                                                    <span class="avatar bg-avatar-primary me-3">JD</span>
                                                    <div>
                                                        <h6 class="mb-0">John Doe</h6>
                                                        <small class="d-block text-secondary">12th Jan | 12:00 PM</small>
                                                        <p class="text-secondary">Lorem ipsum doller sit amet.</p>
                                                    </div>
                                                </div>

                                                <div class="d-flex">
                                                    <span class="avatar bg-avatar-primary me-3">AJ</span>
                                                    <div>
                                                        <h6 class="mb-0">Andrew Jackson</h6>
                                                        <small class="d-block text-secondary">12th Jan | 12:00 PM</small>
                                                        <p class="text-secondary">Lorem ipsum doller sit amet.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!---->
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
            
        </div>
    
    
            
</div>
                    
                    </div>
                </div>
            </div>
        </div>
    </form>
    
</div>


<!--modal-->
<div class="modal fade" id="reviseSalary" tabindex="-1" aria-labelledby="reviseSalaryLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reviseSalaryLabel">Setup Salary</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="uil uil-times"></i></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row form-group mb-2">
                        <div class="col-12 col-md-6">
                            <label>Basic Pay <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" />
                        </div>
                        <div class="col-12 col-md-6">
                            <label>Salary/Day <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" />
                        </div>
                    </div>
                    <div class="row form-group mb-2">
                        <div class="col-12 col-md-6 form-group mb-2">
                            <label>Salary/Hour <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" />
                        </div>
                        <div class="col-12 col-md-6">
                            <label>Provident Fund</label>
                            <input type="text" class="form-control" />
                        </div>
                    </div>
                    <div class="row form-group mb-2">
                        <div class="col-12 col-md-6 form-group mb-2">
                            <label>Effective Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" />
                        </div>
                        <div class="col-12 col-md-6 form-group mb-2">
                            <label>Overtime Pay/Hour <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" />
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Save</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="assettypeModal" tabindex="-1" aria-labelledby="assettypeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reviseSalaryLabel">Assign Asset</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="uil uil-times"></i></button>
            </div>
            <div class="modal-body">
                <form>
                    
                    <div class="row form-group mb-2">
                        
                        <div class="col-12 col-md-12">
                            <label>Asset Type <span class="text-danger">*</span></label>
                            
                                <div class="d-flex">
                                    <div class="form-check me-3">
                                        <input class="form-check-input status-radio" type="radio" name="status" id="motor" value="motor" checked />
                                        <label class="form-check-label" for="motor"> Motor Vehicle </label>
                                    </div>
                            
                                    <div class="form-check">
                                        <input class="form-check-input status-radio" type="radio" name="status" id="electronics" value="electronics"/>
                                        <label class="form-check-label" for="electronics"> Electronics </label>
                                    </div>
                                </div>

                        </div>
                       
                    </div>
                    
                    <div class="row form-group mb-2">
                        <div class="col-12 col-md-6">
                            <label>Asset Id <span class="text-danger">*</span></label>
                            <select class="form-select select2">
                                <option>485547</option>
                                <option>565224</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-6">
                            <label>Asset Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control bg-light" readonly />
                        </div>
                    </div>
                    
                    <div class="row form-group mb-2">
                        <div class="col-12 col-md-6">
                            <label>Model</label>
                            <input type="text" class="form-control bg-light" readonly />
                        </div>
                        <div class="col-12 col-md-6">
                            <label>Make</label>
                            <input type="text" class="form-control bg-light" readonly />
                        </div>
                    </div>
                    
                    
                    
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Save</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="experience01_btn" tabindex="-1" aria-labelledby="experience01_btnLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reviseSalaryLabel">Experience Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="uil uil-times"></i></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row form-group">
                                                                    
                            <div class="col-12 col-md-6">
                                <label>Previous Company Name <span class="text-danger">*</span></label>
                                <input type="text" name="company[]" class="form-control" required>
                            </div>
                        
                            <div class="col-12 col-md-6">
                                <label>Designation <span class="text-danger">*</span></label>
                                <input type="text" name="designation[]" class="form-control" required>
                            </div>
                            
                        </div>
                        
                        <div class="row form-group">
                            
                            <div class="col-12 col-md-6">
                                <label>Employment Duration <span class="text-danger">*</span></label>
                               <input type="text" id="daterange" name="daterange" class="form-control"  />
                            </div>
                            
                            <div class="col-12 col-md-6">
                                <label>Exit Reason <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" >
                            </div>
                            
                        </div>
                        
                        <div class="row form-group">
                            <div class="col-12 col-md-6">
                                <label>Salary (₹) <span class="text-danger">*</span></label>
                                <input type="text" class="form-control">
                            </div>
                            
                            <div class="col-12 col-md-6">
                                    <label>Any Police / Legal Case <span class="text-danger">*</span></label>
                                    
                                    <div class="item_check d-flex">
                                        
                                        <div class="form-check">
                                            <input class="form-check-input" class="legalcase_yes" type="radio" name="legal_case" id="legalcase_yes" value="Yes" />
                                            <label class="form-check-label" for="legalcase_yes">
                                                Yes
                                            </label>
                                        </div>
                                        
                                        <div class="form-check mx-2">
                                            <input class="form-check-input" type="radio" class="legalcase_yes" name="legal_case" id="legalcase_no" value="No" />
                                            <label class="form-check-label" for="legalcase_no">
                                                No
                                            </label>
                                        </div>
                                        
                                    </div>
                                </div>
                                
                                <div class="opencase_01desc" style="display:none;">
                                                            
                                <div class="row form-group">
                                    
                                    <div class="col-12 col-md-12 my-2">
                                        <div class="note-wrap">
                                            <div class="form-group">
                                                <label>About Case</label>
                                                <textarea class="form-control" rows="4" placeholder="Write your message here"></textarea>
                                            </div>
                                        </div>    
                                    </div>
                                    
                                    <div class="col-12 col-md-6">
                                        <label>State <span class="text-danger">*</span></label>
                                        <select class="form-select select2" name="district">
                                            <option value="">Select District</option>
                                            <option>Alipurduar</option>
                                            <option>Bankura</option>
                                            <option>Birbhum</option>
                                            <option>Cooch Behar</option>
                                            <option>Dakshin Dinajpur (South Dinajpur)</option>
                                            <option>Darjeeling</option>
                                            <option>Hooghly (Hugli)</option>
                                            <option>Howrah</option>
                                            <option>Jalpaiguri</option>
                                            <option>Jhargram</option>
                                            <option>Kalimpong</option>
                                            <option>Kolkata (Calcutta)</option>
                                            <option>Malda</option>
                                            <option>Murshidabad</option>
                                            <option>Nadia</option>
                                            <option>North 24 Parganas (Uttar 24 Parganas)</option>
                                            <option>Paschim Bardhaman (West Bardhaman)</option>
                                            <option>Paschim Medinipur (West Medinipur)</option>
                                            <option>Purba Bardhaman (East Bardhaman)</option>
                                            <option>Purba Medinipur (East Medinipur)</option>
                                            <option>Purulia</option>
                                            <option>South 24 Parganas (Dakshin 24 Parganas)</option>
                                            <option>Uttar Dinajpur (North Dinajpur)</option>
                                        </select>

                                    </div>
                                    
                                    <div class="col-12 col-md-6">
                                        <label>Police Station <span class="text-danger">*</span></label>
                                        <select class="form-select select2" name="district">
                                            <option value="">Select District</option>
                                            <option>Haringhata</option>
                                            <option>Habra</option>
                                            <option>Ashoknagar</option>
                                            <option>Kachua</option>
                                            <option>Purulia</option>
                                            <option>Uttar Dinajpur</option>
                                        </select>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        
                        <div class="row form-group">
                             <div class="col-12 col-md-12">
                                <label>Notes <span class="text-danger">*</span></label>
                                <textarea class="form-control" rows="3" placeholder=""></textarea>
                            </div>
                        </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Save</button>
            </div>
        </div>
    </div>
</div>



@endsection

@section('js')

<script>

    var CONTACTS = "{{ route('contact.' . $cotype->slug . '.index') }}";
    var EMPERGENY_CONTACT_WRAPPER = "{{ route('contact.' . $cotype->slug . '.emergencycontactwrapper') }}";
    var ATTACHMENT_WRAPPER    = "{{ route('contact.attachmentwrapper') }}";
    var DESIGNATION_URL = "{{ route('designation.getDepartmentWiseDesignations', '__ID__') }}";
    
    window.UPLOAD_URL = "{{ route('contact.upload.images') }}";
    
    //console.log("UPLOAD_URL:", window.UPLOAD_URL); 
    

    
    $(document).ready(function(){
        
        $('.table .form-control').each(function(index, value) {
            if($(this).val().length){
                $(this).addClass('has-val');
            }
        });
        
        $('.select2').select2();
        
    });

</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>

<script type="text/javascript" src="{{ asset('customjs/contact/' . $cotype->slug . '/create.js') }}"></script>

<script type="text/javascript" src="{{ asset('js/Contacts/Employee/index.js') }}"></script>

@endsection





