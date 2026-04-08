@extends('layouts.app')

@section('css')

<link rel="stylesheet" href="{{ asset('public/css/driver-management.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css" />

<style>
/**/
.table thead tr th {padding: 8px 15px; }
.table tbody td {  padding: 8px 20px;  font-size: 13px; }

/**/


/*dropzone*/
.dropzone {
    border: 2px dashed #dbdee0;
    padding: 20px;
    background: #fff;
    min-height: 120px;
}
/*dropzone*/

</style>

@endsection

@section('content')

<div class="layout-wrapper">
    
    @include('includes.header')
    
    
    <form class="wrapper srlog-bdwrapper pt-0" action="{{ Route::has('contact.'.str($cotype->slug)->lower().'.update')? 
                    route('contact.'.str($cotype->slug)->lower().'.update', $contact->id): '#' }}" id="editContactForm">   
        @csrf
        
        <input type="hidden" name="contactid" id="edit_contactid_input" value="{{ $contact->id }}">
        
        <div class="wrapper srlog-bdwrapper">
    
            <div class="itemtop-secwrap">
                <div class="container-fluid">
                    
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <h5 class="d-inline-block">Edit Driver</h5>
                        </div>
                        <div class="col-12 col-md-4 text-center">
                            @if($contact->status === 'Blacklisted' && $contact->blacklisted_at)
                            <div class="item_blacklisted">
                                <p>Blacklisted</p>
                                <span>
                                    Blacklisted on - {{ \Carbon\Carbon::parse($contact->blacklisted_at)->format('d/m/y') }}
                                </span>
                            </div>
                            @endif
                        </div>
                    </div>
                    

                    <div class="item1-cbdhed mb-4">
                        <div class="row align-items-end">
                            
                            <div class="col-12 col-md-4">
                                <div class="gst-wrapper">
                                    <label>Driver Licence Number </label>
                                    <div class="row align-items-center">
                                        <div class="col-11 pe-0">
                                            <div class="input-group">
                                              <input type="text" class="form-control" id="" placeholder="MH-14-2011-0062821">
                                              <small class="error text-danger" id="edit_d_licence_no_error"></small>
                                              <button class="btn btn-primary" type="button" id="fetchData"><i class="uil uil-search me-1"></i>Fetch Info</button>
                                            </div>
                                        </div>
                                        <div class="col-1">
                                            <div class="sec-tooltip">
                                                <i class="uil uil-info-circle"></i>
                                                <p>We are fetching all past history and from driving licence number.</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <small class="text-primary">Format : MH-14-2011-0062821</small>
                                    
                                </div>
                            </div>
                            

                            <div class="col-12 col-md-8 text-end">
                                @php
                                    $canGenerate = !empty($contact->contact_name) 
                                                   && $contact->workExperiences->isNotEmpty()
                                                   && $contact->vehicleAllocations->isNotEmpty();
                                                   
                                    $joiningSeen = $contact->joining_letter_seen_status == 'Yes';
                                @endphp
                                
                                <span 
                                    data-toggle="tooltip"
                                    data-placement="top"
                                    title="{{ $canGenerate 
                                        ? ($joiningSeen ? 'View joining letter again' : 'Click to generate joining letter') 
                                        : 'Joining letter can be generated only after adding Work Experience and Salary details' }}">
                                
                                    <a href="{{ $canGenerate 
                                            ? route('contact.'.str($cotype->slug)->lower().'.joining.letter', $contact->id) 
                                            : 'javascript:void(0);' }}"
                                       class="btn {{ $joiningSeen ? 'btn-success' : 'btn-success' }} me-2 updateLetterSeenStatus {{ $canGenerate ? '' : 'disabled' }}"
                                       data-id="{{ $contact->id }}"
                                       data-type="joining-letter"
                                       {{ $canGenerate ? '' : 'onclick=return false;' }}>
                                       
                                       {{ $canGenerate ? ($joiningSeen ? 'View Joining Letter' : 'Generate Joining Letter') : 'Generate Joining Letter' }}
                                
                                    </a>
                                
                                </span>
                                
                                

                                
                                @php
                                    $canExit = !empty($contact->employeeExitDetail);
                                    
                                    $exitSeen = $contact->exit_letter_seen_status == 'Yes';
                                @endphp
                                
                                <span 
                                    data-toggle="tooltip"
                                    data-placement="top"
                                    title="{{ $canExit 
                                        ? ($exitSeen ? 'View exit letter again' : 'Click to generate exit letter') 
                                        : 'Exit letter can be generated only after adding employee exit details' }}">
                                
                                    <a href="{{ $canExit 
                                            ? route('contact.'.str($cotype->slug)->lower().'.exit.letter', $contact->id) 
                                            : 'javascript:void(0);' }}"
                                       class="btn {{ $exitSeen ? 'btn-danger' : 'btn-danger' }} me-2 updateLetterSeenStatus {{ $canExit ? '' : 'disabled' }}"
                                       data-id="{{ $contact->id }}"
                                       data-type="exit-letter"
                                       {{ $canExit ? '' : 'onclick=return false;' }}>
                                       
                                       {{ $canExit ? ($exitSeen ? 'View Exit Letter' : 'Generate Exit') : 'Exit' }}
                                
                                    </a>
                                
                                </span>


                                

                                
                                
                                @if( Route::has('contact.'.str($cotype->slug)->lower().'.update') )
                                <a href="javascript:void(0)" class="btn btn-dark me-2" id="editContactBtn">Save</a>
                                @endif
                                
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
                                                  <div class="upload__img-wrap">
                                                    @if(!empty($contact->contact_image))
                                                        <div class="upload__img-box">
                                                            <img 
                                                                src="{{ asset('public/media/contact/'.$contact->contact_image) }}" 
                                                                class="img-thumbnail"
                                                                style="max-width:150px; max-height:150px;"
                                                                alt="Contact Photo"
                                                            >
                                                        </div>
                                                    @endif
                                                  </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        
                                        <div class="row form-group">
                                            <div class="col-12 col-md-5">
                                                <label>Name <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <input type="text" name="contact_name" value="{{ $contact->contact_name ?? '' }}" class="form-control" />
                                                <small class="error text-danger" id="edit_contact_name_error"></small>
                                            </div>
                                        </div>
                                        
                                        <div class="current_allocvehic">
                                            
                                            @php
                                                $currentVehicle = $contact->vehicleAllocations->first();
                                            @endphp
                                        
                                            <div class="row form-group">
                                                <div class="col-12 col-md-5">
                                                    <label>Do You Want to Change Vehicle? <span class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-12 col-md-7">
                                                    <div class="form-check me-2 change-vehicle">
                                                       <input class="form-check-input" type="checkbox" name="change_vehicle" id="change_vehicle" value="Yes" {{ optional($currentVehicle)->change_vehicle == 'Yes' ? 'checked' : '' }} />
                                                       <small class="error text-danger" id="edit_change_vehicle_error"></small>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row form-group">
                                                <div class="col-12 col-md-5">
                                                    <label>Current Allocated Vehicle <span class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-12 col-md-7">
                                                    
                                                    <select class="form-select select2" disabled>
                                                        <option value="">Choose</option>
                                                
                                                        @foreach($vehicles as $vehicle)
                                                        <option value="{{ $vehicle->id }}" {{ optional($currentVehicle)->vehicle_id == $vehicle->id ? 'selected' : '' }}>{{ $vehicle->vehicle_no }}</option>
                                                        @endforeach
                                                    </select>
                                                    
                                                </div>
                                            </div>
                                            
                                            <div class="row form-group reason_wrap" style="display: none;">
                                                <div class="col-12 col-md-5"></div>
                                                <div class="col-12 col-md-7">
                                                    <select class="form-select select2" name="vehicle_id">
                                                        <option value="">Choose</option>
                                                
                                                        @foreach($vehicles as $vehicle)
                                                        <option value="{{ $vehicle->id }}">{{ $vehicle->vehicle_no }}</option>
                                                        @endforeach
                                                    </select>
                                                    <small class="error text-danger" id="edit_vehicle_id_error"></small>
                                                </div>
                                            </div>
                                            
                                            <div class="row form-group reason_wrap" style="{{ !empty(optional($currentVehicle)->vehicle_change_reason) ? '' : 'display:none;' }}">
                                                <div class="col-12 col-md-5">
                                                    <label>Vehicle Change Reason <span class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-12 col-md-7">
                                                    <textarea class="form-control" name="vehicle_change_reason" rows="3" placeholder="">{{ optional($currentVehicle)->vehicle_change_reason }}
                                                    </textarea>
                                                    <small class="error text-danger" id="edit_vehicle_change_reason_error"></small>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        
                                        
                                        <div class="row form-group">
                                            <div class="col-12 col-md-5">
                                                <label>Driver Code <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <input type="text" name="contact_code" value="{{ $contact->contact_code ?? '' }}" class="form-control" />
                                                <small class="error text-danger" id="edit_contact_code_error"></small>
                                            </div>
                                        </div>
                                        
                                        <div class="row form-group">
                                            <div class="col-12 col-md-5">
                                                <label>Driver Category <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <select name="driver_category" class="form-select">
                                                    <option value="">Choose</option>
                                                    <option value="Local" {{ optional($contact->driverinfo)->category == 'Local' ? 'selected' : '' }}>Local</option>
                                                    <option value="Line" {{ optional($contact->driverinfo)->category == 'Line' ? 'selected' : '' }}>Line</option>
                                                </select>
                                                <small class="error text-danger" id="edit_driver_category_error"></small>
                                            </div>
                                        </div>
                                        
                                        
                                        <div class="row form-group">
                                            <div class="col-12 col-md-5">
                                                <label>Phone <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <input type="hidden" name="phone_code" value="{{ $contact->ph_prefix ?? '' }}" class="phone_code"> 
                                                <input type="text" name="phone" value="{{ $contact->phone ?? '' }}" class="form-control telinput"/>
                                                <small class="error text-danger" id="edit_phone_error"></small>
                                            </div>
                                        </div>
                                        
                                        <div class="row form-group">
                                            <div class="col-12 col-md-5">
                                                <label>WhatsApp</label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <div class="row">
                                                    <input type="hidden" name="whatsapp_code" value="{{ $contact->whatsapp_prefix ?? '' }}" class="phone_code"> 
                                                    <div class="col-12 col-md-12">
                                                        <input type="text" name="whatsapp" value="{{ $contact->whatsapp ?? '' }}" class="form-control telinput" name="whatsapp" />
                                                        <small class="error text-danger" id="edit_whatsapp_error"></small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row form-group">
                                            <div class="col-12 col-md-5">
                                                <label>Date of Birth <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <input type="date" class="form-control dob" name="dob" id="dob" value="{{ $contact->dob ?? '' }}" max="{{ date('Y-m-d') }}" />
                                                <small class="error text-danger" id="edit_dob_error"></small>
                                            </div>
                                        </div>
                                        
                                        <div class="row form-group">
                                            <div class="col-12 col-md-5">
                                                <label>Age</label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <input type="text" name="age" id="age" value="{{ $contact->dob ? \Carbon\Carbon::parse($contact->dob)->age.' years' : '' }}" readonly class="form-control bg-light" />
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
                                                        <option value="{{ $group }}" {{ $contact->blood_group == $group ? 'selected' : '' }}>
                                                            {{ $group }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <small class="error text-danger" id="edit_blood_group_error"></small>
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
                                                            @selected($religion->id === $contact->religion_id)>
                                                            {{ $religion->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <small class="error text-danger" id="edit_religion_id_error"></small>
                                            </div>
                                        </div>
                                        
                                        
                                        <div class="row form-group">
                                            <div class="col-12 col-md-5">
                                                <label>Date of Joining <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <input type="date" name="doj" id="doj" value="{{ $contact->doj ?? '' }}" class="form-control" max="{{ date('Y-m-d') }}" />
                                                <small class="error text-danger" id="edit_doj_error"></small>
                                            </div>
                                        </div>
                                        
                                        <div class="row form-group">
                                            <div class="col-12 col-md-5">
                                                <label>Associated Since</label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <input type="text" class="form-control bg-light"
                                                   value="{{ $contact->doj ? \Carbon\Carbon::parse($contact->doj)->diffForHumans(null, true) : '' }}"
                                                   readonly>
                                            </div>
                                        </div>
                                        
                                        <div class="row form-group">
                                            <div class="col-12 col-md-5">
                                                <label>Status</label>
                                            </div>

                                            <div class="col-12 col-md-7 d-flex">

                                                <div class="form-check">
                                                    <input class="form-check-input driver-status" type="radio" name="status" id="active" value="Active" {{ $contact->status == 'Active' ? 'checked' : '' }} />
                                                    <label class="form-check-label" for="active">
                                                        Active
                                                    </label>
                                                </div>

                                                <div class="form-check mx-2">
                                                    <input class="form-check-input driver-status" type="radio" name="status" id="inactive" value="Inactive" {{ $contact->status == 'Inactive' ? 'checked' : '' }} />
                                                    <label class="form-check-label" for="inactive">
                                                        Inactive
                                                    </label>
                                                </div>

                                                <div class="form-check m">
                                                    <input class="form-check-input driver-status" type="radio" name="status" id="blacklist" value="Blacklisted" {{ $contact->status == 'Blacklisted' ? 'checked' : '' }} />
                                                    <label class="form-check-label" for="blacklist">
                                                        Blacklist
                                                    </label>
                                                </div>
                                                
                                            </div>
                                            <small class="error text-danger" id="edit_status_error"></small>
                                        </div>
                                        
                                        
                                        <!--///////////////////////////////-->
                                        <div class="status-content statusinactive" style="display:none;">
                                            <div class="row form-group">
                                              <div class="col-12 col-md-5"></div>
                                              
                                              <div class="col-12 col-md-7 flex-wrap d-flex voluntaryexe-wrap" style="display:none;">

                                                    <div class="form-check me-2 onLeaveDiv">
                                                        <input class="form-check-input status-type" type="radio" name="status_type" id="onLeave" value="On Leave">
                                                        <label class="form-check-label" for="onLeave">
                                                           On Leave  
                                                        </label>
                                                    </div>
                                                    
                                                    <div class="form-check mx-0 voluntaryExitDiv">
                                                        <input class="form-check-input status-type" type="radio" name="status_type" id="voluntaryExit" value="Voluntary Exit">
                                                        <label class="form-check-label" for="voluntaryExit">
                                                           Voluntary Exit 
                                                        </label>
                                                    </div>
                                                    
                                              </div>
                                              <small class="error text-danger" id="edit_status_type_error"></small>
                                            </div>

                                            <div class="leavevoluntary_wrap" style="display:none;">
                                                
                                                <div class="onleave_wrap" style="display:none;">
                                                    
                                                    <div class="row form-group">
                                                      <div class="col-12 col-md-5">
                                                          <label>Expected Return Date<span class="text-danger">*</span></label>
                                                      </div>
                                                      <div class="col-12 col-md-7">
                                                          <input name="expected_return_date" class="form-control bg-light text-uppercase" type="date" placeholder="DD/MM/YY">
                                                          <small class="error text-danger" id="edit_expected_return_date_error"></small>
                                                      </div>
                                                    </div>
                                                    
                                                    <div class="row form-group">
                                                      <div class="col-12 col-md-5">
                                                          <label>Set Reminder<span class="text-danger">*</span></label>
                                                      </div>
                                                      <div class="col-12 col-md-7">
                                                          <input type="hidden" name="set_reminder" value="No">
                                                          <input class="form-check-input" type="checkbox" name="set_reminder" id="set-reminder" value="Yes" {{ ($driverinfo->set_reminder ?? 'No') == 'Yes' ? 'checked' : '' }}>
                                                          <small class="error text-danger" id="edit_set_reminder_error"></small>
                                                      </div>
                                                    </div>
                                                    
                                                </div>
                                                
                                                <div class="voluntary_wrap" style="display:none;">
                                                    
                                                    <div class="row form-group">
                                                      <div class="col-12 col-md-5">
                                                          <label>Exit Reason <span class="text-danger">*</span></label>
                                                      </div>
                                                      <div class="col-12 col-md-7">
                                                         <textarea class="form-control" name="voluntary_exit_reason" rows="3" placeholder=""></textarea>
                                                         <small class="error text-danger" id="edit_voluntary_exit_reason_error"></small>
                                                      </div>
                                                    </div>
                                                    
                                                    
                                                    <div class="row">
                                                        <div class="col-12 col-md-6">
                                                            <label>Vehicle Photos <span class="text-danger">*</span></label>
                                                        </div>
                                                        <div class="col-12 col-md-6 text-end">
                                                            <div class="collapse show" id="collapseImage">
                                                                <div class="upload__box">
                                                                  <div class="upload__btn-box">
                                                                    <label class="upload__btn">
                                                                        <p class="btn btn-theme mb-0"><i class="uil uil-plus me-1"></i>Upload Photos</p>
                                                                        <input type="file" name="vehicle_photos[]" multiple data-max_length="20" class="upload__inputfile">
                                                                        <small class="error text-danger" id="edit_vehicle_photos_error"></small>
                                                                    </label>
                                                                  </div>
                                                                  <div class="upload__img-wrap"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!---->
                                                    
                                                </div>
                                                
                                            </div>
                                            
                                        </div>
                                        <!--///////////////////////////////-->
                                        
                                        
                                        <!--///////////////////////////////-->
                                        <div class="status-content statusblacklist" style="display: {{ $contact->blacklist_reason != '' ? 'block' : 'none' }};">
                                            <div class="row form-group">
                                              <div class="col-12 col-md-5">
                                                  <label>Blacklist Reason <span class="text-danger">*</span></label>
                                              </div>
                                              <div class="col-12 col-md-7">
                                                  <textarea class="form-control" name="blacklist_reason" rows="3" placeholder="">{{ $contact->blacklist_reason ?? '' }}</textarea>
                                                  <small class="error text-danger" id="edit_blacklist_reason_error"></small>
                                              </div>
                                            </div>
                                        </div>
                                        <!--///////////////////////////////-->
                                        
                                        
                                        <div class="row form-group">
                                            <div class="col-12 col-md-5">
                                                <label>RAG Status</label>
                                            </div>

                                            <div class="col-12 col-md-7 d-flex rag-status-wrap">
                                                <div class="form-check red-wrap">
                                                    <input class="form-check-input" type="radio" name="rag_status" id="red" value="Red" {{ $contact->rag_status == 'Red' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="red">
                                                       Red  
                                                    </label>
                                                </div>

                                                <div class="form-check mx-1 yellow-wrap">
                                                    <input class="form-check-input" type="radio" name="rag_status" id="yellow" value="Yellow" {{ $contact->rag_status == 'Yellow' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="yellow">
                                                        Yellow 
                                                    </label>
                                                </div>

                                                <div class="form-check green-wrap">
                                                    <input class="form-check-input" type="radio" name="rag_status" id="green" value="Green" {{ $contact->rag_status == 'Green' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="green">
                                                        Green
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        
                                        <div class="row form-group">
                                            <div class="col-12 col-md-5">
                                                <label>Hisab Category <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <select name="hisab_category" class="form-select">
                                                    <option value="">Choose</option>
                                                    <option value="Fixed" {{ optional($contact->driverinfo)->hisab_category == 'Fixed' ? 'selected' : '' }}>Fixed</option>
                                                    <option value="Fuel" {{ optional($contact->driverinfo)->hisab_category == 'Fuel' ? 'selected' : '' }}>Fuel</option>
                                                </select>
                                                <small class="error text-danger" id="edit_hisab_category_error"></small>
                                            </div>
                                        </div>
                                        
                                        <div class="row form-group">
                                            <div class="col-12 col-md-5">
                                                <label>Opening Balance Date <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <input name="opening_balance_date" value="{{ optional($contact->driverinfo)->opening_balance_date ?? '' }}" class="form-control bg-light text-uppercase" type="date" placeholder="DD/MM/YY">
                                                <small class="error text-danger" id="edit_opening_balance_date_error"></small>
                                            </div>
                                        </div>
                                        
                                        <div class="row form-group">
                                            <div class="col-12 col-md-5"> 
                                                <label>Opening Balance Type <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <select name="opening_balance_type" class="form-select ">
                                                    <option value="">Select</option>
                                                    <option value="Credit"
                                                        {{ optional($contact->driverinfo)->opening_balance_type == 'Credit' ? 'selected' : '' }}>
                                                        Credit - Receivable
                                                    </option>
                                            
                                                    <option value="Debit"
                                                        {{ optional($contact->driverinfo)->opening_balance_type == 'Debit' ? 'selected' : '' }}>
                                                        Debit - Payable
                                                    </option>
                                                </select>
                                                <small class="error text-danger" id="edit_opening_balance_type_error"></small>
                                            </div>
                                        </div>
                                        
                                        <div class="row form-group">
                                            <div class="col-12 col-md-5">
                                                <label>Opening Balance <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <input type="text" name="opening_balance" value="{{ optional($contact->driverinfo)->opening_balance ?? '' }}" class="form-control">
                                                <small class="error text-danger" id="edit_opening_balance_error"></small>
                                            </div>
                                        </div>
                                        
                                        <div class="row form-group">
                                            <div class="col-12 col-md-5">
                                                <label>Guarantor Name <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <input type="text" name="guarantor_name" value="{{ optional($contact->driverinfo)->guarantor_name ?? '' }}" class="form-control">
                                                <small class="error text-danger" id="edit_guarantor_name_error"></small>
                                            </div> 
                                        </div>
                                        
                                        <div class="row form-group">
                                            <div class="col-12 col-md-5">
                                                <label>Guarantor Number <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <input type="hidden" name="guarantor_phone_code" value="{{ optional($contact->driverinfo)->guarantor_phone_code ?? '' }}" class="phone_code"> 
                                                <input type="text" name="guarantor_phone" value="{{ optional($contact->driverinfo)->guarantor_phone ?? '' }}" class="form-control telinput"/>
                                                <small class="error text-danger" id="edit_guarantor_phone_error"></small>
                                            </div>
                                        </div>
                                        
                                        <div class="row form-group">
                                          <div class="col-12 col-md-5">
                                              <label>Comment</label>
                                          </div>
                                          <div class="col-12 col-md-7">
                                              <textarea name="contact_comment" class="form-control" rows="3" placeholder="">{{ $contact->comment ?? '' }}</textarea>
                                              <small class="error text-danger" id="edit_contact_comment_error"></small>
                                          </div>
                                        </div>
                                        
                                        
                                        
                                        <!-------------------------------------------------------------------->
                                        <!-------------------------------------------------------------------->

                                        
                                        
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
                                            @foreach($contact->relcontacts as $index => $relcontact)
                                        
                                            @if( $index > 0)
                                              <a href="javascript:void(0)" class="text-end text-secondary d-block mb-0 close-address"><i class="uil uil-times-circle"></i></a>
                                            @endif
                                            <input type="hidden" name="contact_person_id[{{ $index }}]" value="{{ $relcontact->id }}">
                                            
                                            <div class="row form-group">
                                                <div class="col-12 col-md-5">
                                                    <label>Name <span class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-12 col-md-7">
                                                    <input type="text" name="contact_person_name[{{ $index }}]" value="{{ $relcontact->name ?? '' }}" class="form-control" >
                                                    <small class="error text-danger" id="edit_contact_person_name_{{ $index }}_error"></small>
                                                </div>
                                            </div>
                                            
                                            <div class="row form-group">
                                                <div class="col-12 col-md-5">
                                                    <label><span class="cpdglbl">Relation </span></label>
                                                </div>
                                                <div class="col-12 col-md-7">
                                                    <input type="text" class="form-control" name="contact_person_relation[{{ $index }}]" value="{{ $relcontact->relationship ?? '' }}">
                                                    <div class="error text-danger cpdgerr" id="edit_contact_person_relation_{{ $index }}_error"></div>
                                                </div>
                                            </div>
                                            
                                            <div class="row form-group">
                                                <div class="col-12 col-md-5">
                                                      <label>Phone <span class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-12 col-md-7">
                                                    <div class="row">
                                                        <input type="hidden" name="contact_person_ph_code[{{ $index }}]" value="{{ $relcontact->ph_prefix ?? '' }}" class="phone_code">
                                                        <div class="col-12 col-md-12">
                                                            <input type="text" class="form-control telinput " name="contact_person_phone[{{ $index }}]" value="{{ $relcontact->phone ?? '' }}">
                                                            <div class="error text-danger cpph" id="edit_contact_person_phone_{{ $index }}_error"></div>
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
                                                        <input type="hidden" name="contact_person_whatsapp_code[{{ $index }}]" value="{{ $relcontact->whatsapp_prefix ?? '' }}" class="phone_code">
                                                        <div class="col-12 col-md-12">
                                                            <input type="text" class="form-control telinput " name="contact_person_whatsapp[{{ $index }}]" value="{{ $relcontact->whatsapp ?? '' }}"/>
                                                            <div class="error text-danger cpph" id="edit_contact_person_whatsapp_{{ $index }}_error"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row form-group">
                                                <div class="col-12 col-md-5">
                                                    <label><span class="cpdglbl">Address </span></label>
                                                </div>
                                                <div class="col-12 col-md-7">
                                                    <input type="text" class="form-control" name="contact_person_address[{{ $index }}]" value="{{ $relcontact->address ?? '' }}">
                                                    <div class="error text-danger cpdgerr" id="edit_contact_person_address_{{ $index }}_error"></div>
                                                </div>
                                            </div>
                                            
                                            <div class="row form-group">
                                                <div class="col-12 col-md-5">
                                                    <label><span class="cpdglbl">Blood Group </span></label>
                                                </div>
                                                <div class="col-12 col-md-7">
                                                    <select name="contact_person_blood_group[{{ $index }}]" class="form-select ">
                                                        <option value="">Choose</option>
                                                        @foreach (['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $group)
                                                            <option value="{{ $group }}" {{ $relcontact->blood_group == $group ? 'selected' : '' }}>
                                                                {{ $group }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <div class="error text-danger cpdgerr" id="edit_contact_person_blood_group_{{ $index }}_error"></div>
                                                </div>
                                            </div>
                                            
                                            <div class="row form-group">
                                              <div class="col-12 col-md-5">
                                                  <label>Comment</label>
                                              </div>
                                              <div class="col-12 col-md-7">
                                                  <textarea class="form-control" rows="3" placeholder="" name="contact_person_comment[{{ $index }}]">{{ $relcontact->comment ?? '' }}</textarea>
                                                  <div class="error text-danger cpcmt" id="edit_contact_person_comment_{{ $index }}_error"></div>
                                              </div>
                                            </div>
                                            
                                            @endforeach
                                            
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
                                            <textarea name="permanent_address" id="permanentAddr" class="form-control" rows="3" placeholder="">{{ $permanentAddress->address ?? '' }}</textarea>
                                            <small class="error text-danger" id="edit_permanent_address_error"></small>
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
                                                        {{ $permanentAddress->state_id == $state->id ? 'selected' : '' }}>
                                                        {{ $state->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <small class="error text-danger" id="edit_permanent_addr_state_id_error"></small>
                                        </div>
                                    </div>
                                    
                                    <div class="row form-group">
                                        <div class="col-12 col-md-5">
                                            <label>City </label>
                                        </div>
                                        <div class="col-12 col-md-7">
                                            <select class="form-select select2" name="permanent_addr_city_id" id="permanentAddrCity">
                                                <option value="">Choose..</option>
                                                @if(isset($permanentAddress) && $permanentAddress->state)
                                                    @foreach($permanentAddress->state->cities as $city)
                                                        <option value="{{ $city->id }}"
                                                            {{ $permanentAddress->city_id == $city->id ? 'selected' : '' }}>
                                                            {{ $city->name }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <small class="error text-danger" id="edit_permanent_addr_city_id_error"></small>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-12 col-md-5">
                                            <label>Postal Code  <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-12 col-md-7">
                                            <input type="text" name="permanent_addr_postal_code" id="permanentAddrPostalCode" value="{{ $permanentAddress->zipcode ?? '' }}" class="form-control" />
                                            <small class="error text-danger" id="edit_permanent_addr_postal_code_error"></small>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-12 col-md-5">
                                            <label>Additional Info</label>
                                        </div>
                                        <div class="col-12 col-md-7">
                                            <textarea type="textarea" name="permanent_addr_additional_info" id="permanentAddrAdditionalInfo" class="form-control" rows="3" placeholder="Additional Info">{{ $permanentAddress->additional_info ?? '' }}</textarea>
                                            <small class="error text-danger" id="edit_permanent_addr_additional_info_error"></small>
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
                                            <textarea name="present_address" id="presentAddr" class="form-control" rows="3" placeholder="">{{ $presentAddress->address ?? '' }}</textarea>
                                            <small class="error text-danger" id="edit_present_address_error"></small>
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
                                                        {{ ($presentAddress->state_id ?? '') == $state->id ? 'selected' : '' }}>
                                                        {{ $state->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <small class="error text-danger" id="edit_present_addr_state_id_error"></small>
                                        </div>
                                    </div>
                                    
                                    <div class="row form-group">
                                        <div class="col-12 col-md-5">
                                            <label>City </label>
                                        </div>
                                        <div class="col-12 col-md-7">
                                            <select class="form-select select2" name="present_addr_city_id" id="presentAddrCity">
                                                <option value="">Choose..</option>
                                                @if(isset($presentAddress) && $presentAddress->state)
                                                    @foreach($presentAddress->state->cities as $city)
                                                        <option value="{{ $city->id }}"
                                                            {{ $presentAddress->city_id == $city->id ? 'selected' : '' }}>
                                                            {{ $city->name }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <small class="error text-danger" id="edit_present_addr_city_id_error"></small>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-12 col-md-5">
                                            <label>Postal Code  <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-12 col-md-7">
                                            <input type="text" name="present_addr_postal_code" id="presentAddrPostalCode" value="{{ $presentAddress->zipcode ?? '' }}" class="form-control" />
                                            <small class="error text-danger" id="edit_present_addr_postal_code_error"></small>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-12 col-md-5">
                                            <label>Additional Info</label>
                                        </div>
                                        <div class="col-12 col-md-7">
                                            <textarea type="textarea" name="present_addr_additional_info" id="presentAddrAdditionalInfo" class="form-control" rows="3" placeholder="Additional Info">{{ $presentAddress->additional_info ?? '' }}</textarea>
                                            <small class="error text-danger" id="edit_present_addr_additional_info_error"></small>
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
                                    
                                    <div class="bank-details-wrap">
                                        
                                        <div id="bankDetailsContainer">
                                            
                                            @foreach($contact->bankDetails as $index => $contactBank)
                                            <div class="bank-data border p-3 mb-3 position-relative">
                                                
                                                @if( $index > 0)
                                                  <a href="javascript:void(0)" class="text-end text-secondary d-block mb-0 close-bank"><i class="uil uil-times-circle"></i></a>
                                                @endif
                                                <input type="hidden" name="contact_bank_id[{{ $index }}]" value="{{ $contactBank->id }}">
                                                
                                                <div class="row form-group">
                                                    <div class="col-12 col-md-5">
                                                        <label>Is Primary ? <span class="text-danger">*</span></label>
                                                    </div>
            
                                                    <div class="col-12 col-md-7 d-flex">
            
                                                        <div class="form-check">
                                                            <input class="form-check-input bank-status" type="radio" name="is_primary[{{ $index }}]" id="is_primary_yes" value="Yes" {{ $contactBank->is_primary == 'Yes' ? 'checked' : '' }} />
                                                            <label class="form-check-label" for="is_primary_yes">
                                                                Yes
                                                            </label>
                                                        </div>
            
                                                        <div class="form-check mx-2">
                                                            <input class="form-check-input bank-status" type="radio" name="is_primary[{{ $index }}]" id="is_primary_no" value="No" {{ $contactBank->is_primary == 'No' ? 'checked' : '' }} />
                                                            <label class="form-check-label" for="is_primary_no">
                                                                No
                                                            </label>
                                                        </div>
                                                        
                                                    </div>
                                                    <small class="error text-danger" id="edit_is_primary_error"></small>
                                                    <small class="error text-danger" id="edit_is_primary_0_error"></small>
                                                </div>
            
                                                <div class="row form-group">
                                                    <div class="col-12 col-md-5">
                                                        <label>Bank Name <span class="text-danger">*</span></label>
                                                    </div>
                                                    <div class="col-12 col-md-7">
                                                        <select name="bank_id[{{ $index }}]" class="form-select select2">
                                                            <option value="">Choose..</option>
                                                            @foreach ($banks as $bank)
                                                            <option value="{{ $bank->id }}" {{ $contactBank->bank_id == $bank->id ? 'selected' : '' }}>
                                                                {{ $bank->name }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                        <small class="error text-danger" id="edit_bank_id_0_error"></small>
                                                    </div>
                                                </div>
                                                
                                                <div class="row form-group">
                                                    <div class="col-12 col-md-5">
                                                        <label>Beneficiary Name</label>
                                                    </div>
                                                    <div class="col-12 col-md-7">
                                                        <input type="text" name="beneficiary_name[{{ $index }}]" value="{{ $contactBank->beneficiary_name ?? '' }}" class="form-control" />
                                                        <small class="error text-danger" id="edit_beneficiary_name_0_error"></small>
                                                    </div>
                                                </div>
            
                                                <div class="row form-group">
                                                    <div class="col-12 col-md-5">
                                                        <label>Account Number <span class="text-danger">*</span></label>
                                                    </div>
                                                    <div class="col-12 col-md-7">
                                                        <input type="text" name="account_number[{{ $index }}]" value="{{ $contactBank->account_number ?? '' }}" class="form-control" />
                                                        <small class="error text-danger" id="edit_account_number_0_error"></small>
                                                    </div>
                                                </div>
                                                
                                                <div class="row form-group">
                                                    <div class="col-12 col-md-5">
                                                        <label>IFSC Code <span class="text-danger">*</span></label>
                                                    </div>
                                                    <div class="col-12 col-md-7">
                                                        <input type="text" name="ifsc_code[{{ $index }}]"  value="{{ $contactBank->ifsc_code ?? '' }}" class="form-control" />
                                                        <small class="error text-danger" id="edit_ifsc_code_0_error"></small>
                                                    </div>
                                                </div>
            
                                                <div class="row form-group">
                                                    <div class="col-12 col-md-5">
                                                        <label>UPI ID</label>
                                                    </div>
                                                    <div class="col-12 col-md-7">
                                                        <input type="text" name="upi_id[{{ $index }}]" value="{{ $contactBank->upi_id ?? '' }}" class="form-control" />
                                                        <small class="error text-danger" id="edit_upi_id_0_error"></small>
                                                    </div>
                                                </div> 
                                            
                                            </div>
                                            @endforeach
                                        
                                        </div>
                                    
                                    </div>
                                    
                                    <div class="mt-3">
                                        <a href="javascript:void(0)" class="btn btn-theme add-bank"><i class="uil uil-plus me-1"></i>Bank</a>
                                    </div>

                                </div>
                            </div>
                              
                        </div>

                        <div class="col-12 col-md-8 mt-4">
                            <div class="right-side-wrap">

                                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link " data-bs-toggle="tab" data-bs-target="#joining" type="button" role="tab">
                                            Joining
                                        </button>
                                    </li>
                                    
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="e-document-tab" data-bs-toggle="pill" data-bs-target="#e-document-contact" type="button" role="tab" aria-controls="e-document-contact" aria-selected="true">Document</button>
                                    </li>
                                    
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link " id="e-asset-tab" data-bs-toggle="pill" data-bs-target="#e-asset-attachments" type="button" role="tab" aria-controls="e-asset-attachments" aria-selected="false">
                                            Assets
                                        </button>
                                    </li>
                                    
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link " data-bs-toggle="tab" data-bs-target="#salary" type="button" role="tab">
                                            Driver Bhatta
                                        </button>
                                    </li>
                                    
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link " data-bs-toggle="tab" data-bs-target="#exit" type="button" role="tab">
                                            Exit
                                        </button>
                                    </li>

                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link " data-bs-toggle="tab" data-bs-target="#activity" type="button" role="tab">
                                            Activity
                                        </button>
                                    </li>
                                    
                                </ul>
                                
                                <!-- ------------------------------------------------------ -->
                                <div class="tab-content" id="pills-tabContent">
                                    
                                    <div class="tab-pane fade " id="joining" role="tabpanel">
                                        
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
                                                                <input type="number" class="form-control" value="{{ $totalYears ?? 0 }}" disabled>
                                                                <label class="ms-2">Years</label>
                                                            </div>
                                                            <div class="col-12 col-md-3 d-flex align-items-center">
                                                                <input type="number" class="form-control" value="{{ $remainingMonths ?? 0 }}" disabled>
                                                                <label class="ms-2">Month</label>
                                                            </div>
                                                            <div class="col-12 col-md-3 d-flex align-items-center">
                                                                <div class="row">
                                                                    <div class="col-12 d-flex justify-content-end">
                                                                        <button type="button" data-id="{{ $contact->id }}" class="btn btn-theme mb-0 ms-2 add-emp-experience" 
                                                                        data-bs-toggle="modal" data-bs-target="#workExperienceModal" style="color: #261f35; font-size: 13px;">
                                                                            <i class="uil uil-plus me-1"></i> Experience</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                        
                                                    </div>
                                                </div>
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
                                                        
                                                        @forelse($contact->workExperiences as $experience)
                                                            <tr>
                                                                <td>{{ $experience->previous_company_name }}</td>
                                                                <td>{{ $experience->designation }}</td>
                                                                <td>
                                                                    @if($experience->employment_start_date && $experience->employment_end_date)
                                                                        {{ \Carbon\Carbon::parse($experience->employment_start_date)->format('d/m/Y') }}
                                                                        -
                                                                        {{ \Carbon\Carbon::parse($experience->employment_end_date)->format('d/m/Y') }}
                                                                    @else
                                                                        {{ $experience->previous_employment_duration }}
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <span class="tag">{{ $experience->any_legal_case }}</span><br>
                                                                    @if($experience->any_legal_case == 'Yes' && $experience->comment_about_case)
                                                                        ({{ $experience->comment_about_case }})
                                                                    @endif
                                                                </td>
                                                                <td>{{ $experience->police_station }}</td>
                                                                <td>{{ $experience->exit_reason }}</td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="6" class="text-center">No previous employment found!</td>
                                                            </tr>
                                                        @endforelse
                                                  
                                               
                                                    </tbody>  
                                           
                                                </table>
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
                                                            <small class="error text-danger atyperr" id="edit_coattachtype_0_error"></small>
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
                                                    <small class="error text-danger atterr" id="edit_coattachments_0_error"></small>
    
                                                    
                                                    <div class="d-flex justify-content-between mt-2">
                                                        <button type="button" class="add-item btn btn-success btn-sm" id="add_attachment_btn"><i class="uil uil-plus"></i> Add New</button>
                                                    </div>
                                                    
                                                    
                                                </div>
                                                <div id="uploadContainer"></div>
                                                
                                                @foreach($coattachtypes->whereIn('id',$contact->coattachments->pluck('coattachtype.id')->toArray()) as $coattachtype)
                                                    <div class="row mt-4  attachment-container">
                                                          <div class="col-12">
                                                              <h6>{{$coattachtype->name}}</h6>
                                                          </div>
                                                          @foreach($contact->coattachments->where('coattachtype.id',$coattachtype->id) as $coattachment)
                                                               <div class="col-12 col-md-4 attachment-box">
                                                                  <div class="preview-img d-block w-100">
                                                                      <div class="d-flex justify-content-between">
                                                                          <a href="{{asset('public/media/contact/'.$coattachment->name)}}" download="{{$coattachment->original_name}}">
                                                                              <img src="{{asset('public/media/contact/'.$coattachment->name)}}" class="me-3">
                                                                          </a>
                                                                          <div style="font-size: 14px;">
                                                                              <a href="{{asset('public/media/contact/'.$coattachment->name)}}" download="{{$coattachment->original_name}}">
                                                                                  <p class="mb-0 file-name">{{$coattachment->original_name}} </p>
                                                                              </a>
                                                                              <p class="mb-0">Size: <span class="text-secondary">{{round((float)$coattachment->file_size,2)}} MB</span></p>
                                                                          </div>
                                                                          <i class="uil-edit text-success ms-4 edit-attachment-btn" data-id="{{ $coattachment->id }}" style="cursor:pointer;"></i>
                                                                          <i class="uil-trash-alt text-danger ms-4 delete-attachment-btn" data-url="{{ route('contact.deleteattachment', $coattachment->id) }}" style="cursor:pointer;"></i>
                                                                      </div>
                                                                      <small class="text-secondary d-block mt-2">Attached by <span class="text-theme">{{$coattachment->createdby?->name}}</span> on {{$coattachment->created_at->format('d/m/y [h:i A]')}}</small>
                                                                  </div>
                                                              </div>
                                                          @endforeach
                                                    </div>
                                                @endforeach
                                                
                                                <!-- Add New -->
                                            </div>
                                            <!---->
                                        </div>
                                        
                                        <div class="doc-wrap">
                                            <h5 class="mt-3">Driving License Details</h5>
                                            <div class="row form-group">
                                                <div class="col-12 col-md-6">
                                                    <label class="mb-1">Driving License Number <span class="text-danger">*</span></label>
                                                    <input type="text" name="driving_licence_no" value="{{ optional($contact->driverinfo)->driving_licence_no }}" class="form-control">
                                                    <small class="error text-danger" id="add_driving_licence_no_error"></small>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label class="mb-1">License Issue Date <span class="text-danger">*</span></label>
                                                    <input type="date" name="licence_issue_date" value="{{ optional($contact->driverinfo)->licence_issue_date }}" class="form-control" >
                                                    <small class="error text-danger" id="add_licence_issue_date_error"></small>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-12 col-md-6">
                                                    <label class="mb-1">License Expiry Date <span class="text-danger">*</span></label>
                                                    <input type="date" name="licence_expiry_date" value="{{ optional($contact->driverinfo)->licence_expiry_date }}" class="form-control">
                                                    <small class="error text-danger" id="add_licence_expiry_date_error"></small>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label class="mb-1">Original License Location <span class="text-danger">*</span></label>
                                                    <input type="text" name="original_licence_location" value="{{ optional($contact->driverinfo)->original_licence_location }}" class="form-control">
                                                    <small class="error text-danger" id="add_original_licence_location_error"></small>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-12 col-md-6">
                                                    <label class="mb-1">Driving License Proof <span class="text-danger">*</span></label>
                                                    <input type="file" name="driving_license_proof_file" class="form-control" >
                                                    @if(optional($contact->driverinfo)->driving_license_proof_file)
                                                        <div class="mt-1">
                                                            <a href="{{ asset('public/media/contact/'.optional($contact->driverinfo)->driving_license_proof_file) }}" target="_blank">
                                                                View File
                                                            </a>
                                                        </div>
                                                    @endif
                                                    <small class="error text-danger" id="add_driving_license_proof_file_error"></small>
                                                </div>
                                            </div>
                                            
                                            <h5 class="mt-5">ID & Proof Details</h5>
                                            <div class="row form-group">
                                                <div class="col-12 col-md-6">
                                                    <label class="mb-1">Aadhaar Number <span class="text-danger">*</span></label>
                                                    <input type="text" name="aadhaar_no" value="{{ optional($contact->driverinfo)->aadhaar_no }}" class="form-control">
                                                    <small class="error text-danger" id="add_aadhaar_no_error"></small>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label class="mb-1">Aadhaar Card Proof<span class="text-danger">*</span></label>
                                                    <input type="file" name="aadhaar_card_proof_file" class="form-control">
                                                    @if(optional($contact->driverinfo)->aadhaar_card_proof_file)
                                                        <div class="mt-1">
                                                            <a href="{{ asset('public/media/contact/'.optional($contact->driverinfo)->aadhaar_card_proof_file) }}" target="_blank">
                                                                View File
                                                            </a>
                                                        </div>
                                                    @endif
                                                    <small class="error text-danger" id="add_aadhaar_card_proof_file_error"></small>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-12 col-md-6">
                                                    <label class="mb-1">Signed Driver Form<span class="text-danger">*</span></label>
                                                    <input type="file" name="signed_driver_form_file" class="form-control">
                                                    @if(optional($contact->driverinfo)->signed_driver_form_file)
                                                        <div class="mt-1">
                                                            <a href="{{ asset('public/media/contact/'.optional($contact->driverinfo)->signed_driver_form_file) }}" target="_blank">
                                                                View File
                                                            </a>
                                                        </div>
                                                    @endif
                                                    <small class="error text-danger" id="add_signed_driver_form_file_error"></small>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    
                                    
                                    <div class="tab-pane fade" id="e-asset-attachments" role="tabpanel" aria-labelledby="e-asset-tab">
                                        <!--////////////////////////////-->
                                        
                                        <div class="row mt-0 align-items-center">
                                            <div class="col-12 col-md-9">
                                                <h6>Alloted Asset</h6>
                                            </div>
                                            <div class="col-12 col-md-3 text-end">
                                                <a href="javascript:void(0)"
                                                   class="btn btn-theme {{ $contact->employeeExitDetail ? 'disabled' : '' }}"
                                                   data-bs-toggle="{{ $contact->employeeExitDetail ? '' : 'modal' }}"
                                                   data-bs-target="{{ $contact->employeeExitDetail ? '' : '#assettypeModal' }}">
                                                    <i class="uil uil-plus me-1"></i> Assign Asset
                                                </a>
                                                <!--<a href="javascript:void(0)" class="btn btn-theme" data-bs-toggle="modal" data-bs-target="#assettypeModal"><i class="uil uil-plus me-1"></i> Assign Asset</a>-->
                                            </div>
                                        </div>
                                        
                                        <div class="table-responsive mt-3">
                                            <table class="table table-hover invoice-table mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>Asset ID</th>
                                                        <th>Category</th>
                                                        <th>Name</th>
                                                        <th>Make</th>
                                                        <th>Model</th>
                                                        <th>Assigned On</th>
                                                        <th>Assigned By</th>
                                                        <th>Comments</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    
                                                    @if($contact->employeeAssets->count() > 0)
                                                    
                                                        @foreach($contact->employeeAssets as $empAsset)
                                                        <tr>
                                                            <td>{{ $empAsset->asset->asset_no ?? '-' }}</td>
                                                            <td>{{ $empAsset->asset->type ?? '-' }}</td>
                                                            <td>{{ $empAsset->asset->name ?? '-' }}</td>
                                                            <td>{{ $empAsset->asset->make ?? '-' }}</td>
                                                            <td>{{ $empAsset->asset->model ?? '-' }}</td>
                                                            <td>{{ $empAsset->created_at->format('d/m/Y') }}</td>
                                                            <td>{{ $empAsset->createdby->name ?? '-' }}</td>
                                                            <td>{{ $empAsset->comment ?? '-' }}</td>
                                                            <td>
                                                                @if($empAsset->status === 'Assigned')
                                                                    <a class="btn btn-secondary revoke-btn"
                                                                       data-id="{{ $empAsset->id }}" data-asset="{{ $empAsset->asset->name ?? '' }}"
                                                                       href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#revoke">
                                                                        Revoke
                                                                    </a>
                                                                @else
                                                                    <span class="badge bg-success">Revoked</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    
                                                    @else
                                                        <tr>
                                                            <td colspan="9" class="text-center">No assets assigned!</td>
                                                        </tr>
                                                    @endif
                                                    
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                        
                                        <div class="mt-3">
                                            <h6>History</h6>
                                            
                                            <div class="table-responsive mt-3">
                                            <table class="table table-hover invoice-table mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>Asset ID</th>
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
                                                    
                                                    @if($contact->assetLogs->count() > 0)
                                                    
                                                        @foreach($contact->assetLogs as $log)
                                                        <tr>
                                                            <td>{{ $log->asset->asset_no ?? '-' }}</td>
                                                            <td>{{ $log->asset->type ?? '-' }}</td>
                                                            <td>{{ $log->asset->name ?? '-' }}</td>
                                                            <td>{{ $log->asset->make ?? '-' }}</td>
                                                            <td>{{ $log->asset->model ?? '-' }}</td>
                                                    
                                                            <td>
                                                                {{ $log->created_at ? $log->created_at->format('d/m/Y') : '-' }}
                                                                <br>
                                                                {{ $log->employeeAsset->createdby->name ?? '-' }}
                                                            </td>
                                                    
                                                            <td>
                                                                {{ $log->revoke_date ? \Carbon\Carbon::parse($log->revoke_date)->format('d/m/Y') : '-' }}
                                                                <br>
                                                                {{ $log->revoke_date ? ($log->createdby->name ?? '-') : '-' }}
                                                            </td>
                                                    
                                                            <td>{{ $log->comment ?? '-' }}</td>
                                                        </tr>
                                                        @endforeach
                                                    
                                                    @else
                                                        <tr>
                                                            <td colspan="8" class="text-center">No asset history found!</td>
                                                        </tr>
                                                    @endif
                                                
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                            
                                                        
                                            
                                        </div>
                                    </div>
                                    
                                    <div class="tab-pane" id="salary" role="tabpanel">
                                        <!--////////////////////////////-->
                                        
                                        <div class="no-data">
                                            <p class="text-dark mb-0">No Data Found</p>
                                        </div>

                                        <div class="row mt-0 align-items-center">
                                            <div class="col-12 col-md-9">
                                                <h6>Bhatta Information</h6>
                                            </div>
                                            <div class="col-12 col-md-3 text-end">
                                                <a href="javascript:void(0)" class="btn btn-theme" data-bs-toggle="modal" data-bs-target="#reviseSalary"><i class="uil uil-plus me-1"></i> Revise Bhatta</a>
                                            </div>
                                        </div>
                                        <div class="table-responsive mt-3">
                                            <table class="table table-hover invoice-table mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>Basic Bhatta</th>
                                                        <th>Bhatta/Day</th>
                                                        <th>Bhatta/Hour</th>
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


                                        <!--////////////////////////////-->
                                    </div>
                                    
                                    <div class="tab-pane" id="exit" role="tabpanel">
                                        
                                        <!--///////////////////////////////////-->
                                        
                                        <div class="doc-wrap">
                                            
                                            <div class="row form-group">
                                                
                                                <div class="col-12 col-md-6 mb-3">
                                                    <label class="mb-2">Reason for Exit <span class="text-danger">*</span></label>
                                                    <textarea name="exit_reason" id="exit_reason" class="form-control" rows="3" placeholder=""></textarea>
                                                    <small class="error text-danger" id="edit_exit_reason_error"></small>
                                                </div>
                                                
                                                <div class="col-12 col-md-6 mb-3">
                                                    <label class="mb-2">Exit Date <span class="text-danger">*</span></label>
                                                    <input name="exit_date" id="exit_date" class="form-control bg-light text-uppercase general_date" type="date" placeholder="DD/MM/YY">
                                                    <small class="error text-danger" id="edit_exit_date_error"></small>
                                                </div>
                                                
                                                <div class="col-12 col-md-6 mb-3">
                                                    <label class="mb-2">Feedback <span class="text-danger">*</span></label>
                                                    <textarea name="exit_feedback" id="exit_feedback" class="form-control" rows="3" placeholder=""></textarea>
                                                    <small class="error text-danger" id="edit_exit_feedback_error"></small>
                                                </div>
                                                
                                                <div class="col-12 col-md-6 mb-3">
                                                    <button id="exitDetailBtn" class="btn btn-primary" {{ $contact->employeeExitDetail ? 'disabled' : '' }}> Save </button>
                                                </div>
                                                
                                            </div>
                                                
                                        </div>
                                        
                                        <!--////////////////////////////-->
                                    </div>
                                    
                                    
                                    <div class="tab-pane fade" id="activity" role="tabpanel">

                                        <div class="e-activitywrapper">
                                    
                                            <div class="note-wrap">
                                                <div class="form-group">
                                                    <label class="mb-2">Note</label>
                                                    <textarea name="activity_notes" id="activity_notes" class="form-control" rows="4" placeholder="Write your message here"></textarea>
                                                    <small class="error text-danger" id="err_activity_notes"></small>
                                                </div>
                                                <div class="text-end">
                                                    <button id="activityBtn" class="btn btn-primary">Submit <i class="uil uil-message ms-1"></i></button>
                                                </div>
                                            </div>
                                            
                                            
                                            <div class="cmnt-wrap mt-4">
                                    
                                                @forelse($contact->activities as $activity)
                                            
                                                    <div class="d-flex {{ ($activity->is_blacklisted === 'Yes') ? 'blacklist_color' : '' }}">
                                                        <span class="avatar {{ ($activity->is_blacklisted === 'Yes') ? 'bg-circlesec btn-danger' : 'bg-avatar-primary' }} me-3">
                                                            {{ strtoupper(substr(optional($activity->createdBy)->name, 0, 1)) }}
                                                        </span>
                                            
                                                        <div class="w-90">
                                                            <h6 class="mb-0 {{ ($activity->is_blacklisted === 'Yes') ? 'c_red' : '' }}">
                                                                {{ optional($activity->createdBy)->name ?? 'User' }}
                                                            </h6>
                                            
                                                            <small class="d-block text-secondary {{ ($activity->is_blacklisted === 'Yes') ? 'c_red' : '' }}">
                                                                {{ $activity->created_at->format('d M | h:i A') }}
                                                            </small>
                                            
                                                            <p class="text-secondary mb-2 {{ ($activity->is_blacklisted === 'Yes') ? 'c_red' : '' }}">
                                                                {{ $activity->notes }}
                                                            </p>
                                                        </div>
                                                    </div>
                                            
                                                @empty
                                                    <p class="text-muted">No activities found.</p>
                                                @endforelse
                                            
                                            </div>
                                    
                                    
                                        </div>
                                    
                                    </div>
                                <!-- ------------------------------------------------------ -->

                            </div>
                        </div>
                    </div>
            
                </div>
            </div>

        </div>
    </form>
</div>



<!--modal-->
<div class="modal fade" id="workExperienceModal" tabindex="-1" aria-labelledby="workExperienceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reviseSalaryLabel">Experience Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="uil uil-times"></i></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('contact.driver.work.experience.store') }}" id="addDriverWorkExperienceForm">
                    @csrf
                    
                    <input type="hidden" name="contact_id" value="{{ $contact->id ?? '' }}" />
                    
                        <div class="row form-group">
                                                                    
                            <div class="col-12 col-md-6">
                                <label>Previous Company Name <span class="text-danger">*</span></label>
                                <input type="text" name="previous_company_name" class="form-control">
                                <small class="error text-danger" id="add_previous_company_name_error"></small>
                            </div>
                        
                            <div class="col-12 col-md-6">
                                <label>Designation <span class="text-danger">*</span></label>
                                <input type="text" name="previous_designation" class="form-control">
                                <small class="error text-danger" id="add_previous_designation_error"></small>
                            </div>
                            
                        </div>
                        
                        <div class="row form-group">
                            
                            <div class="col-12 col-md-6">
                                <label>Employment Duration <span class="text-danger">*</span></label>
                                <input type="text" name="previous_employment_duration" class="form-control daterange"  readonly/>
                                <small class="error text-danger" id="add_previous_employment_duration_error"></small>
                            </div>
                            
                            <div class="col-12 col-md-6">
                                <label>Exit Reason <span class="text-danger">*</span></label>
                                <input type="text" name="previous_exit_reason" class="form-control" >
                                <small class="error text-danger" id="add_previous_exit_reason_error"></small>
                            </div>
                            
                        </div>
                        
                        <div class="row form-group">
                            <div class="col-12 col-md-6">
                                <label>Salary (₹) <span class="text-danger">*</span></label>
                                <input type="text" name="previous_salary" class="form-control">
                                <small class="error text-danger" id="add_previous_salary_error"></small>
                            </div>
                            
                            <div class="col-12 col-md-6">
                                <label>Experience Category <span class="text-danger">*</span></label>
                                    
                                <div class="item_check d-flex">
                                    
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="experience_category" id="cat_line" value="Line">
                                        <label class="form-check-label" for="cat_line">
                                            Line
                                        </label>
                                    </div>
                                    
                                    <div class="form-check mx-2">
                                        <input class="form-check-input" type="radio" name="experience_category" id="cat_local" value="Local">
                                        <label class="form-check-label" for="cat_local">
                                            Local
                                        </label>
                                    </div>
                                    
                                </div>
                                <small class="error text-danger" id="add_experience_category_error"></small>
                            </div>
                            
                            
                            <div class="col-12 col-md-6">
                                <label>Any Police / Legal Case <span class="text-danger">*</span></label>
                                
                                <div class="item_check d-flex">
                                    
                                    <div class="form-check">
                                        <input class="form-check-input" class="legalcase_yes" type="radio" name="previous_legal_case" id="legalcase_yes" value="Yes" />
                                        <label class="form-check-label" for="legalcase_yes">
                                            Yes
                                        </label>
                                    </div>
                                    
                                    <div class="form-check mx-2">
                                        <input class="form-check-input" type="radio" class="legalcase_yes" name="previous_legal_case" id="legalcase_no" value="No" />
                                        <label class="form-check-label" for="legalcase_no">
                                            No
                                        </label>
                                    </div>
                                    
                                </div>
                                <small class="error text-danger" id="add_previous_legal_case_error"></small>
                            </div>
                                
                            <div class="opencase_01desc" style="display:none;">
                                <div class="row form-group">
                                    
                                    <div class="col-12 col-md-12 my-2">
                                        <div class="note-wrap">
                                            <div class="form-group">
                                                <label>About Case</label>
                                                <textarea name="previous_legal_case_comment" class="form-control" rows="4" placeholder="Write your message here"></textarea>
                                                <small class="error text-danger" id="add_previous_legal_case_comment_error"></small>
                                            </div>
                                        </div>    
                                    </div>
                                    
                                    <div class="col-12 col-md-6">
                                        <label>City <span class="text-danger">*</span></label>
                                        <select name="previous_city_id" class="form-select select2" name="district">
                                            <option value="">Select City</option>
                                            @foreach($cities as $city)
                                            <option value="{{ $city->id }}">{{ $city->name }}</option>
                                            @endforeach
                                        </select>
                                        <small class="error text-danger" id="add_previous_city_id_error"></small>
                                    </div>
                                    
                                    <div class="col-12 col-md-6">
                                        <label>Police Station <span class="text-danger">*</span></label>
                                        <input type="text" name="previous_police_station" class="form-control" />
                                        <small class="error text-danger" id="add_previous_police_station_error"></small>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        
                        <div class="row form-group">
                            <div class="col-12 col-md-12">
                                <label>Notes <span class="text-danger">*</span></label>
                                <textarea class="form-control" name="previous_notes" rows="3" placeholder=""></textarea>
                                <small class="error text-danger" id="add_previous_notes_error"></small>
                            </div>
                        </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="addDriverWorkExperienceBtn" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="reviseSalary" tabindex="-1" aria-labelledby="reviseSalaryLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reviseSalaryLabel">Setup Bhatta</h5>
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
                            <label>Bhatta/Day <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" />
                        </div>
                    </div>
                    <div class="row form-group mb-2">
                        <div class="col-12 col-md-6 form-group mb-2">
                            <label>Bhatta/Hour <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" />
                        </div>
                        <div class="col-12 col-md-6 form-group mb-2">
                            <label>Effective Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" />
                        </div>
                    </div>
                    <div class="row form-group mb-2">
                        <div class="col-12 form-group mb-2">
                            <label>Overtime Bhatta/Hour <span class="text-danger">*</span></label>
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


<div class="modal fade" id="editAttachmentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            
            <div class="modal-header">
                <h5 class="modal-title">Edit Attachment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="editAttachmentForm" action="{{ route('contact.updateattachment') }}">
                @csrf
                <div class="modal-body">

                    <input type="hidden" id="attachment_id" name="attachment_id">

                    <div class="mb-3">
                        <label class="form-label">Upload File <span class="text-danger">*</span></label>
                        <input type="file" name="attachment_file" class="form-control">
                        <small class="error text-danger atyperr" id="edit_attachment_file_error"></small>
                    </div>

                </div>

                <div class="modal-footer">
                    <button id="editAttachmentBtn" class="btn btn-primary">
                        Update
                    </button>
                </div>
            </form>

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
                <form action="{{ route('contact.employee.asset.store') }}" id="addEmployeeAssetForm">
                    @csrf
                    
                    <input type="hidden" name="contact_id" value="{{ $contact->id ?? '' }}" />
                    
                    <div class="row form-group mb-2">
                        <div class="col-12 col-md-12">
                            <label>Asset Type <span class="text-danger">*</span></label>
                            
                            <div class="d-flex">
                                <div class="form-check me-3">
                                    <input class="form-check-input status-radio asset_type_radio" type="radio" name="asset_type" id="motor" value="Motor Vehicle"  />
                                    <label class="form-check-label" for="motor"> Motor Vehicle </label>
                                </div>
                        
                                <div class="form-check me-3">
                                    <input class="form-check-input status-radio asset_type_radio" type="radio" name="asset_type" id="electronics" value="Electronics"/>
                                    <label class="form-check-label" for="electronics"> Electronics </label>
                                </div>
                                
                                <div class="form-check me-3">
                                    <input class="form-check-input status-radio asset_type_radio" type="radio" name="asset_type" id="others" value="Others"/>
                                    <label class="form-check-label" for="others"> Others </label>
                                </div>
                            </div>
                            <small class="error text-danger" id="add_asset_type_error"></small>

                        </div>
                    </div>
                    
                    <div class="row form-group mb-2">
                        <div class="col-12 col-md-6">
                            <label>Asset Id <span class="text-danger">*</span></label>
                            <select name="asset_id" id="asset_id" class="form-select select2">
                                <option value="">Select Asset</option>
                            </select>
                            <small class="error text-danger" id="add_asset_id_error"></small>
                        </div>
                        <div class="col-12 col-md-6">
                            <label>Asset Name <span class="text-danger">*</span></label>
                            <input type="text" name="asset_name" id="asset_name" class="form-control bg-light" readonly />
                            <small class="error text-danger" id="add_asset_name_error"></small>
                        </div>
                    </div>
                    
                    <div class="row form-group mb-2">
                        <div class="col-12 col-md-6">
                            <label>Model</label>
                            <input type="text" id="asset_model" class="form-control bg-light" readonly />
                        </div>
                        <div class="col-12 col-md-6">
                            <label>Make</label>
                            <input type="text" id="asset_make" class="form-control bg-light" readonly />
                        </div>
                    </div>
                    
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="addEmployeeAssetBtn" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="revoke" tabindex="-1" aria-labelledby="reviseSalaryLabel" aria-hidden="true"> 
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reviseSalaryLabel">Revoke Asset</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="uil uil-times"></i></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('contact.employee.asset.revoke') }}" id="addEmployeeAssetRevokeForm"> 
                    @csrf
                    <input type="hidden" name="employeeasset_id" id="employeeasset_id">

                    <input type="hidden" id="emp_asset_name" value="" class="form-control" readonly>
                    
                    <div class="form-group mb-2">
                        <label>Revoke From<span class="text-danger">*</span></label>
                        <input type="date" name="revoke_date" class="form-control general_date" />
                        <small class="error text-danger" id="add_revoke_date_error"></small>
                    </div>
                    
                    <div class="form-group mb-2">
                        <label>Revoke Reason<span class="text-danger">*</span></label>
                        <textarea type="textarea" name="revoke_reason" class="form-control" rows="4"></textarea>
                        <small class="error text-danger" id="add_revoke_reason_error"></small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="addEmployeeAssetRevokeBtn" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>


<!--HTML modal-->





@endsection

@section('js')

<script>

    var CONTACTS = "{{ route('contact.' . $cotype->slug . '.index') }}";
    var EMPERGENY_CONTACT_WRAPPER = "{{ route('contact.' . $cotype->slug . '.emergencycontactwrapper') }}";
    var ATTACHMENT_WRAPPER    = "{{ route('contact.attachmentwrapper') }}";
    var DESIGNATION_URL = "{{ route('designation.getDepartmentWiseDesignations', '__ID__') }}";
    
    var TYPE_WISE_ASSETS = "{{ route('asset.getAssetsByType') }}";
    var ASSET_DETAILS_URL = "{{ route('asset.getAssetDetails', ':id') }}";
    
    var BANK_WRAPPER = "{{ route('contact.' . $cotype->slug . '.bankwrapper') }}";
    
    var EXIT_DETAIL_URL = "{{ route('contact.driver.exit.details.store') }}";
    
    var LETTER_SEEN_URL = "{{ route('contact.driver.update.letter.seen.status') }}";
    
    var ACTIVITY_NOTE_URL = "{{ route('contact.activitynotes.save') }}";
    
    window.UPLOAD_URL = "{{ route('contact.upload.images') }}";
    
    
    
    $(document).ready(function(){
        
        $('.table .form-control').each(function(index, value) {
            if($(this).val().length){
                $(this).addClass('has-val');
            }
        });
        
        $('.select2').select2();
        
        $('[data-toggle="tooltip"]').tooltip();
        
    });
    

</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>

<script type="text/javascript" src="{{ asset('public/customjs/contact/' . $cotype->slug . '/edit.js') }}"></script>

<script type="text/javascript" src="{{ asset('public/customjs/contact/activity.js') }}"></script>

<script type="text/javascript" src="{{ asset('public/js/employee-management.js') }}"></script>

@endsection





