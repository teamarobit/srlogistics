@extends('layouts.app')

@section('css')

<link rel="stylesheet" href="{{ asset('css/employee-management.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css" />

<style>
.item_016btn {    display: flex;    align-items: center;    justify-content: end;}
.item_blacklisted {    margin: 0 10px 0 150px;    padding: 11px 12px 5px 12px;    display: inline-block;    text-align: center;
background: #fff;    box-shadow: 0px 0px 8px 0px rgb(143 143 143 / 50%);    border-radius: 4px;    margin-right: auto;
position: relative;    top:-43px; }

.item_blacklisted p { margin: 0;padding: 0;font-size: 20px;line-height: 14px;color: #ea0027;display: block;border: 0;font-weight: bold;}
.item_blacklisted span {    margin: 0;    padding: 3px 0 0 0;    font-size: 13px;    line-height: 21px;    color: #f9526e;    display: block;
font-weight: 600; }


.w-90 { width: 90%; }
.e-activitywrapper .bg-circlesec {    width: 30px;    height: 30px;    border-radius: 100%;    display: inline-flex;
align-items: center;    justify-content: center;    color: #fff;    font-size: 10px;    font-weight: 600;    padding: 0 !important; }
.blacklist_color .c_red {    color: #ea0027 !important;}



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
    
    <form class="wrapper srlog-bdwrapper" action="{{ Route::has('contact.'.str($cotype->slug)->lower().'.update')? 
                    route('contact.'.str($cotype->slug)->lower().'.update', $contact->id): '#' }}" id="editContactForm">   
                    
        @csrf
        
        <input type="hidden" name="contactid" id="edit_contactid_input" value="{{ $contact->id }}">

        <div class="itemtop-secwrap">
            <div class="container-fluid">
                <h5 class="d-inline-block">Edit Vehicle Vendor</h5>

                <div class="item1-cbdhed">
                    <div class="row align-items-end">
                        <div class="col-12 col-md-4">
                            <div class="gst-wrapper">
                                <label>Company Name <span class="text-danger">*</span></label>
                                <div>
                                    <input type="text" name="company_name" value="{{ $contact->company_name ?? '' }}" placeholder="" class="gstinput form-control" />
                                    <small class="error text-danger" id="edit_company_name_error"></small>
                                </div>
                            </div>
                        </div>
                      <div class="col-12 col-md-8 item_016btn">        
                        
                            @if($contact->status === 'Blacklisted' && $contact->blacklisted_at)
                            <div class="item_blacklisted">
                                <p>Blacklisted</p>
                                <span>
                                    Blacklisted on - {{ \Carbon\Carbon::parse($contact->blacklisted_at)->format('d/m/y') }}
                                </span>
                            </div>
                            @endif


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
                        <div class="mt-4">

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
                                            <label>Vehicle Vendor Name <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-12 col-md-7">
                                            <input type="text" name="contact_name" value="{{ $contact->contact_name ?? '' }}" class="form-control"/>
                                            <small class="error text-danger" id="edit_contact_name_error"></small>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-12 col-md-5">
                                            <label>Phone Number <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-12 col-md-7">
                                            <div class="row">
                                                <input type="hidden" name="phone_code" value="{{ $contact->ph_prefix ?? '' }}" class="phone_code"> 
                                                <div class="col-12 col-md-12">
                                                    <input type="text" name="phone" value="{{ $contact->phone ?? '' }}" class="form-control telinput "/>
                                                    <small class="error text-danger" id="edit_phone_error"></small>
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
                                                <input type="hidden" name="whatsapp_code" value="{{ $contact->whatsapp_prefix ?? '' }}" class="phone_code"> 
                                                <div class="col-12 col-md-12">
                                                    <input type="text" name="whatsapp" value="{{ $contact->whatsapp ?? '' }}" class="form-control telinput " name="whatsapp" />
                                                    <small class="error text-danger" id="edit_whatsapp_error"></small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row form-group">
                                        <div class="col-12 col-md-5">
                                            <label>Vehicle Vendor Code <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-12 col-md-7">
                                            <input type="text" name="contact_code" value="{{ $contact->contact_code ?? '' }}" class="form-control"/>
                                            <small class="error text-danger" id="edit_contact_code_error"></small>
                                        </div>
                                    </div>
                                    
                                    <div class="row form-group">
                                        <div class="col-12 col-md-5">
                                            <label>Number of Vehicles</label> 
                                        </div>
                                        <div class="col-12 col-md-7">
                                            <input type="number" name="no_of_vehicles" value="{{ $contact->no_of_vehicles ?? '' }}" class="form-control">
                                            <small class="error text-danger" id="edit_no_of_vehicles_error"></small>
                                        </div>
                                    </div>
                                    
                                    <div class="row form-group">
                                        <div class="col-12 col-md-5">
                                            <label>Size</label>
                                        </div>

                                        <div class="col-12 col-md-7 d-flex">

                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="size" id="exampleRadios1" value="Large" {{ $contact->size == 'Large' ? 'checked' : '' }} />
                                                <label class="form-check-label" for="exampleRadios1">
                                                    Large
                                                </label>
                                            </div>

                                            <div class="form-check mx-2">
                                                <input class="form-check-input" type="radio" name="size" id="exampleRadios2" value="Medium" {{ $contact->size == 'Medium' ? 'checked' : '' }} />
                                                <label class="form-check-label" for="exampleRadios2">
                                                    Medium
                                                </label>
                                            </div>

                                            <div class="form-check m">
                                                <input class="form-check-input" type="radio" name="size" id="exampleRadios3" value="Small" {{ $contact->size == 'Small' ? 'checked' : '' }} />
                                                <label class="form-check-label" for="exampleRadios3">
                                                    Small
                                                </label>
                                            </div>
                                            
                                        </div>
                                        <small class="error text-danger" id="edit_size_error"></small>
                                    </div>
                                    
                                    <div class="row form-group">
                                        <div class="col-12 col-md-5">
                                            <label>RAG Status</label>
                                        </div>

                                        <div class="col-12 col-md-7 d-flex rag-status-wrap">
                                            <div class="form-check red-wrap">
                                                <input class="form-check-input" type="radio" name="rag_status" id="red" value="Red" {{ $contact->rag_status == 'Red' ? 'checked' : '' }} >
                                                <label class="form-check-label" for="red">
                                                   Red  
                                                </label>
                                            </div>

                                            <div class="form-check mx-1 yellow-wrap">
                                                <input class="form-check-input" type="radio" name="rag_status" id="yellow" value="Yellow" {{ $contact->rag_status == 'Yellow' ? 'checked' : '' }} >
                                                <label class="form-check-label" for="yellow">
                                                    Yellow 
                                                </label>
                                            </div>

                                            <div class="form-check green-wrap">
                                                <input class="form-check-input" type="radio" name="rag_status" id="green" value="Green" {{ $contact->rag_status == 'Green' ? 'checked' : '' }} >
                                                <label class="form-check-label" for="green">
                                                    Green
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                        
                                    <div class="row form-group">
                                        <div class="col-12 col-md-5">
                                            <label>Status</label>
                                        </div>

                                        <div class="col-12 col-md-7 d-flex flex-wrap status-wrap">
                                            
                                            <div class="form-check me-2 active">
                                                <input class="form-check-input contact-status" type="radio" name="status" id="active" value="Active" {{ $contact->status == 'Active' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="active">
                                                   Active  
                                                </label>
                                            </div>

                                            <div class="form-check mx-1 inactive">
                                                <input class="form-check-input contact-status" type="radio" name="status" id="inactive" value="Inactive" {{ $contact->status == 'Inactive' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="inactive">
                                                    Inactive 
                                                </label>
                                            </div>
                                            
                                            <div class="form-check mx-0">
                                                <input class="form-check-input status-trigger contact-status" type="radio" name="status" id="blacklist" value="Blacklisted" {{ $contact->status == 'Blacklisted' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="blacklist">
                                                    Blacklist
                                                </label>
                                            </div>
                                            
                                        </div>
                                        <small class="error text-danger" id="edit_status_error"></small>
                                    </div> 
                                    
                                    <!--///////////////////////////////-->
                                    <div class="status-content statusblacklist" style="display: {{ $contact->blacklist_reason != '' ? 'block' : 'none' }};">
                                        <div class="row form-group">
                                          <div class="col-12 col-md-5">
                                              <label>Blacklist Reason <span class="text-danger">*</span></label>
                                          </div>
                                          <div class="col-12 col-md-7">
                                              <textarea class="form-control" name="blacklist_reason" rows="3" placeholder="">{{ $contact->blacklist_reason ?? '' }}</textarea>
                                          </div>
                                        </div>
                                    </div>
                                    <!--///////////////////////////////-->
                                    
                                    

                                    <div class="row form-group">
                                      <div class="col-12 col-md-5">
                                          <label>Comment</label>
                                      </div>
                                      <div class="col-12 col-md-7">
                                          <textarea class="form-control" name="contact_comment" id="contactComment" rows="3" placeholder="">{{ $contact->comment ?? '' }}</textarea>
                                      </div>
                                    </div>


                                    </div>
                                    <!---->                                    
                                </div>
                            </div>


                            <div class="form-bg">
                                <div class="row">
                                    <div class="col-12 col-md-9">
                                        <h6>Contact Persons</h6>
                                    </div>
                                    <div class="col-12 col-md-3 text-end">
                                        <i data-bs-toggle="collapse" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo" class="uil uil-angle-down"></i>
                                    </div>
                                </div>

                                <div class="collapse show" id="collapseTwo">
                                    <div class="contact-wrap">
                                        <div id="contactPersonContainer">
                                            
                                            @foreach($contact->relcontacts as $index => $relcontact)
                                            <div class="contact-person border p-3 mb-3 position-relative">
                                                
                                                @if( $index > 0)
                                                  <a href="javascript:void(0)" class="text-end text-secondary d-block mb-0 close-sec"><i class="uil uil-times-circle"></i></a>
                                                @endif
                                                <input type="hidden" name="contact_person_id[{{ $index }}]" value="{{ $relcontact->id }}">
                                                
                                                <div class="row form-group">
                                                    <div class="col-12 col-md-5">
                                                        <label>Name <span class="text-danger">*</span></label>
                                                    </div>
                                                    <div class="col-12 col-md-7">
                                                        <input type="text" name="contact_person_name[{{ $index }}]" value="{{ $relcontact->name }}" class="form-control" />
                                                        <small class="error text-danger" id="edit_contact_person_name_{{ $index }}_error"></small>
                                                    </div>
                                                </div>
                                                
                                                <div class="row form-group">
                                                    <div class="col-12 col-md-5">
                                                        <label>Designation <span class="text-danger">*</span></label>
                                                    </div>
                                                    <div class="col-12 col-md-7">
                                                        <input type="text" name="contact_person_designation[{{ $index }}]" value="{{ $relcontact->name }}" class="form-control" />
                                                        <small class="error text-danger" id="edit_contact_person_designation_{{ $index }}_error"></small>
                                                    </div>
                                                </div>
        
                                                <div class="row form-group">
                                                    <div class="col-12 col-md-5">
                                                        <label>Phone <span class="text-danger">*</span></label>
                                                    </div>
                                                    <div class="col-12 col-md-7">
                                                        <div class="row">
                                                            <input type="hidden" name="contact_person_ph_code[{{ $index }}]" class="phone_code">
                                                            <div class="col-12 col-md-12">
                                                                <input type="text" class="form-control telinput" name="contact_person_phone[{{ $index }}]" value="{{ $relcontact->phone }}" />
                                                                <small class="error text-danger" id="edit_contact_person_phone_{{ $index }}_error"></small>
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
                                                            <input type="hidden" name="contact_person_whatsapp_code[{{ $index }}]" class="phone_code">
                                                            <div class="col-12 col-md-12">
                                                                <input type="text" class="form-control telinput" name="contact_person_whatsapp[{{ $index }}]" value="{{ $relcontact->whatsapp }}" />
                                                                <small class="error text-danger" id="edit_contact_person_whatsapp_{{ $index }}_error"></small>
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
                                                                <input type="text" class="form-control" name="contact_person_email[{{ $index }}]" value="{{ $relcontact->email }}" />
                                                                <small class="error text-danger" id="edit_contact_person_email_{{ $index }}_error"></small>
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
                                                        <textarea name="contact_person_comment[{{ $index }}]" class="form-control" rows="3" placeholder="">{{ $relcontact->comment }}</textarea>
                                                        <small class="error text-danger" id="edit_contact_person_comment_{{ $index }}_error"></small>
                                                    </div>
                                                </div>
                                            
                                            </div>
                                            @endforeach
    
                                        </div>
                                    </div>

                                    <div class="mt-3">
                                        <a href="javascript:void(0)" class="btn btn-theme add-person"><i class="uil uil-plus me-1"></i>Contact Person</a>
                                    </div>
                                </div>
                            </div>



                            <div class="form-bg">
                                <div class="row">
                                    <div class="col-12 col-md-9">
                                        <h6>Company & Tax Details</h6>                                            
                                    </div>
                                    <div class="col-12 col-md-3 text-end">
                                        <i data-bs-toggle="collapse" href="#collapse03" aria-expanded="true" aria-controls="collapse03" class="uil uil-angle-down"></i>
                                    </div>
                                </div>
                                <div class="collapse show" id="collapse03">

                                    <div class="row form-group">
                                        <div class="col-12 col-md-5">
                                            <label>Full Company Name</label>
                                        </div>
                                        <div class="col-12 col-md-7">
                                            <input type="text" name="full_company_name" value="{{ $contact->full_company_name ?? '' }}" placeholder="" class="gstinput form-control" />
                                            <small class="error text-danger" id="edit_full_company_name_error"></small>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-12 col-md-5">
                                            <label>Ownership Type</label>
                                        </div>
                                        <div class="col-12 col-md-7">
                                            <select name="vehicle_ownership_type_id" class="form-select select2">
                                                <option value="">Choose..</option>
                                                @foreach($vehicle_ownership_type as $type) 
                                                    <option value="{{ $type->id }}" {{ $contact->vehicle_ownership_type_id == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                                                @endforeach
                                            </select>
                                            <small class="error text-danger" id="edit_vehicle_ownership_type_id_error"></small>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-12 col-md-5">
                                            <label>Company Owner</label>
                                        </div>
                                        <div class="col-12 col-md-7">
                                            <input type="text" name="company_owner" value="{{ $contact->company_owner ?? '' }}" class="form-control">
                                            <small class="error text-danger" id="edit_company_owner_error"></small>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-12 col-md-5">
                                            <label>Registration Number</label>
                                        </div>
                                        <div class="col-12 col-md-7">
                                            <input type="text" name="company_registration_no" value="{{ $contact->company_registration_no ?? '' }}" class="form-control">
                                            <small class="error text-danger" id="edit_company_registration_no_error"></small>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-12 col-md-5">
                                            <label>Registration Date</label>
                                        </div>
                                        <div class="col-12 col-md-7">
                                            <input name="company_registration_date" value="{{ $contact->company_registration_date ?? '' }}" class="form-control bg-light text-uppercase general_date" type="date" placeholder="DD/MM/YY">
                                            <small class="error text-danger" id="edit_company_registration_date_error"></small>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-12 col-md-5">
                                            <label>Working with {{optional(Auth::user()->organisation)->short_name}} Since</label>
                                        </div>
                                        <div class="col-12 col-md-7">
                                            <input name="working_since" value="{{ $contact->working_since ?? '' }}" class="form-control bg-light text-uppercase general_date" type="date" placeholder="DD/MM/YY">
                                            <small class="error text-danger" id="edit_working_since_error"></small>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-12 col-md-5">
                                            <label>PAN</label>
                                        </div>
                                        <div class="col-12 col-md-7">
                                            <input name="pan_no" value="{{ $contact->pan_no ?? '' }}" type="text" class="form-control">
                                            <small class="error text-danger" id="edit_pan_no_error"></small>
                                        </div>
                                    </div>                                        

                                     <div class="row form-group">
                                        <div class="col-12 col-md-5">
                                            <label>PAN Status</label>
                                        </div>
                                        <div class="col-12 col-md-7">
                                            <select name="pan_status_id" class="form-select select2">
                                                <option value="">Choose..</option>
                                                @foreach($pan_statuses as $status)
                                                    <option value="{{ $status->id }}" @selected($status->id === $contact->pan_status_id)>{{ $status->name }}</option>
                                                @endforeach
                                            </select>
                                            <small class="error text-danger" id="edit_pan_status_id_error"></small>
                                        </div>
                                    </div>

                                    <div class="row form-group">

                                        <div class="col-12 col-md-5">
                                            <label>GST Treatment</label>
                                        </div>

                                        <div class="col-12 col-md-7 d-flex">
                                            <div class="form-check me-2">
                                                <input class="form-check-input" type="radio" name="gst_treatment" id="register1" value="Registered" {{ $contact->gst_treatment == 'Registered' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="register1">
                                                    Registered 
                                                </label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="gst_treatment" id="unregistered2" value="Unregistered" {{ $contact->gst_treatment == 'Unregistered' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="unregistered2">
                                                    Unregistered 
                                                </label>
                                            </div>    
                                        </div>
                                        <small class="error text-danger" id="edit_gst_treatment_error"></small>
                                    </div>
                                    

                                    <div class="row form-group">
                                        <div class="col-12 col-md-5">
                                            <label>GSTIN</label>
                                        </div>
                                        <div class="col-12 col-md-7">
                                            <input type="text" name="gst_number" value="{{ $contact->gst_number ?? '' }}" class="form-control">
                                            <small class="error text-danger" id="edit_gst_number_error"></small>
                                        </div>
                                    </div>  

                                    <div class="row form-group">
                                        <div class="col-12 col-md-5">
                                            <label>TDS %</label>
                                        </div>
                                        <div class="col-12 col-md-7">
                                            <input type="number" name="tds_percentage" value="{{ $contact->tds_percentage ?? '' }}" class="form-control" min="0" max="100" step="0.01">
                                            <small class="error text-danger" id="edit_tds_percentage_error"></small>
                                        </div>
                                    </div> 


                                    <div class="row form-group">
                                        <div class="col-12 col-md-5">
                                            <label>State <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-12 col-md-7">
                                            <select class="form-select select2 dependent-select" name="state_id" id="gstState" data-target="gstCity">
                                                <option value="">Choose..</option>
                                                @foreach ($states as $state)
                                                    <option value="{{ $state->id }}" data-url="{{ route('getcities', $state->id) }}"
                                                        {{ $contact->state_id == $state->id ? 'selected' : '' }} >
                                                        {{ $state->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <small class="error text-danger" id="edit_state_id_error"></small>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-12 col-md-5">
                                            <label>City <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-12 col-md-7">
                                            <select class="form-select select2" name="city_id" id="gstCity">
                                                <option value="">Choose..</option>
                                                @if(isset($contact) && $contact->state)
                                                    @foreach($contact->state->cities as $city)
                                                        <option value="{{ $city->id }}"
                                                            {{ $contact->city_id == $city->id ? 'selected' : '' }}>
                                                            {{ $city->name }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <small class="error text-danger" id="edit_city_id_error"></small>
                                        </div>
                                    </div>


                                    <div class="row form-group">
                                        <div class="col-12 col-md-5">
                                            <label>Address <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-12 col-md-7">
                                            <textarea name="address" class="form-control" rows="3" placeholder="">{{ $contact->address1 ?? '' }}</textarea>
                                            <small class="error text-danger" id="edit_address_error"></small>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-12 col-md-5">
                                            <label>Postal Code <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-12 col-md-7">
                                            <input type="text" name="post_code" value="{{ $contact->zipcode ?? '' }}" class="form-control">
                                            <small class="error text-danger" id="edit_post_code_error"></small>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-12 col-md-5">
                                            <label>Additional Info</label>
                                        </div>
                                        <div class="col-12 col-md-7">
                                            <textarea type="textarea" name="additional_info" class="form-control" rows="3" placeholder="Additional Info">{{ $contact->additional_info ?? '' }}</textarea>
                                            <small class="error text-danger" id="edit_additional_info_error"></small>
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
                    </div>


                    <div class="col-12 col-md-8 mt-4">
                        <div class="right-side-wrap">
                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                

                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#document" type="button" role="tab">
                                        Document
                                    </button>
                                </li>
                                
                                <li class="nav-item" role="presentation">
                                   <button class="nav-link " data-bs-toggle="tab" data-bs-target="#vehicle" type="button" role="tab">
                                        Vehicle
                                    </button>
                                </li>
                                
                                <li class="nav-item" role="presentation">
                                   <button class="nav-link " data-bs-toggle="tab" data-bs-target="#route" type="button" role="tab">
                                        Route
                                    </button>
                                </li>

                                <li class="nav-item" role="presentation">
                                    <button class="nav-link " data-bs-toggle="tab" data-bs-target="#activity" type="button" role="tab">
                                        Activity
                                    </button>
                                </li>
                                
                            </ul>

                            <div class="tab-content" id="pills-tabContent">
                                
                                <div class="tab-pane fade show active" id="document" role="tabpanel">
                                    
                                    <div>
                                        <div class="row form-group align-items-center">
                                            <div class="col-12 col-md-2">
                                                <label>Document Type: <span class="text-danger">*</span></label>
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
                                        
                                        <hr>
                                        
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
                                        <!-------->
                                        
                                        
                                      </div>
                                      
                                      <div id="uploadContainer"></div>
                                      
                                    {{-- Hidden field (ADD HERE) --}}
                                    <input type="hidden" id="existing_attachtypes" value='@json($contact->coattachments->pluck("coattachtype_id"))'>
                                      
                                    @foreach($coattachtypes->whereIn('id',$contact->coattachments->pluck('coattachtype.id')->toArray()) as $coattachtype)
                                        <div class="row mt-4  attachment-container">
                                              <div class="col-12">
                                                  <h6>{{$coattachtype->name}}</h6>
                                              </div>
                                              @foreach($contact->coattachments->where('coattachtype.id',$coattachtype->id) as $coattachment)
                                                   <div class="col-12 col-md-4 attachment-box">
                                                      <div class="preview-img d-block w-100">
                                                          <div class="d-flex justify-content-between">
                                                              <a href="{{asset('media/contact/'.$coattachment->name)}}" download="{{$coattachment->original_name}}">
                                                                  <img src="{{asset('media/contact/'.$coattachment->name)}}" class="me-3">
                                                              </a>
                                                              <div style="font-size: 14px;">
                                                                  <a href="{{asset('media/contact/'.$coattachment->name)}}" download="{{$coattachment->original_name}}">
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
                                      
                                </div>  
                                
                                <div class="tab-pane fade" id="vehicle" role="tabpanel">
                                   <div class="table-responsive mt-3">
                                    <table class="table table-hover invoice-table mb-0">
                                        <thead>
                                            <tr>
                                                <th style="min-width: 150px;">Vehicle No.</th>
                                                <th>No. of Trips</th>
                                                <th>Last Trip ID</th>
                                                <th>Last Trip Date</th>
                                                <th>Last Location</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>WB-12-VH1234</td>
                                                <td>
                                                    12
                                                </td>
                                                <td>
                                                    #TRIP001
                                                </td>
                                                <td>12/01/2026</td>
                                                <td>
                                                    Delhi
                                                </td>
                                                <td>
                                                    <span class="badge badge-success">Active</span>
                                                </td>
                                            </tr>
                                            
                                            <tr>
                                                <td>WB-12-VH1235</td>
                                                <td>
                                                    15
                                                </td>
                                                <td>
                                                    #TRIP002
                                                </td>
                                                <td>13/01/2026</td>
                                                <td>
                                                    Kolkata
                                                </td>
                                                <td>
                                                    <span class="badge badge-danger">Inactive</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                </div>
                                
                                <div class="tab-pane fade" id="route" role="tabpanel">
                                   <div class="table-responsive mt-3">
                                    <table class="table table-hover invoice-table mb-0">
                                        <thead>
                                            <tr>
                                                <th>Route</th>
                                                <th>Number of Trip</th>
                                                <th>Last Trip Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    KOL-DEL
                                                </td>
                                                <td>10</td>
                                                <td>12/01/2026</td>
                                            </tr>
                                            
                                            <tr>
                                                <td>
                                                    HYD-BNG
                                                </td>
                                                <td>20</td>
                                                <td>25/01/2026</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                </div>

                                <div class="tab-pane fade" id="activity" role="tabpanel">

                                    <div class="e-activitywrapper">

                                        <div class="note-wrap">
                                            <div class="form-group">
                                                <label>Note</label>
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
                               
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            
        </div>
        

    </form>
            
</div>


<!--modal-->

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



@endsection

@section('js')

<script>

    var CONTACTS = "{{ route('contact.' . $cotype->slug . '.index') }}";
    var CONTACTPERSON_WRAPPER = "{{ route('contact.' . $cotype->slug . '.contactpersonwrapper') }}";
    var BANK_WRAPPER = "{{ route('contact.' . $cotype->slug . '.bankwrapper') }}";
    var ATTACHMENT_WRAPPER    = "{{ route('contact.attachmentwrapper') }}";
    
    var ACTIVITY_NOTE_URL = "{{ route('contact.activitynotes.save') }}";
    
    window.UPLOAD_URL = "{{ route('contact.upload.images') }}";
    
    console.log("UPLOAD_URL:", window.UPLOAD_URL); 
    
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

<script type="text/javascript" src="{{ asset('customjs/contact/' . $cotype->slug . '/edit.js') }}"></script>

<script type="text/javascript" src="{{ asset('customjs/contact/activity.js') }}"></script>

@endsection