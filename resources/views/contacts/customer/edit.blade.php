@extends('layouts.app')

@section('css')

<link rel="stylesheet" href="{{ asset('css/Contacts/Customer/edit.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css" />


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
                <div class="item1-cbdhed">
                    <h5>Edit Customer</h5>
                    
                    <div class="row align-items-end">

                        <div class="col-12 col-md-4">
                            <div class="gst-wrapper">
                                <label>GST Number <span class="text-danger">*</span></label>
                                <div class="row align-items-center">
                                    <div class="col-11 pe-0">                       
                                        <div class="gst-inputbd" id="gstForm">
                                            <input type="text" name="gst_number" value="{{ $contact->gstin ?? '' }}" id="gstNumber" placeholder="27AAACT2727Q1ZW" class="gstinput form-control"/>
                                            <small class="error text-danger" id="edit_gst_number_error"></small>
                                            <!--<button class="submit-btn" type="submit">-->
                                            <!--    <i class="uil uil-search"></i>Fetch Info-->
                                            <!--</button>-->
                                        </div>
                                    </div>
                                    
                                    <div class="col-1">
                                        <div class="sec-tooltip">
                                            <i class="uil uil-info-circle"></i>
                                            <p>We will be fetching details from GST Number.</p>
                                        </div>
                                    </div>
                                </div>
                                <span class="gst-format">Format: 27AAACT2727Q1ZW</span>
                            </div>
                        </div>

                        <!--<div class="col-12 col-md-8 text-end">-->
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

                                        <div class="row form-group mb-3">
                                            <div class="col-12 col-md-5">
                                              <label>Name <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                              <input type="text" name="contact_name" id="gstName" value="{{ $contact->contact_name ?? '' }}" class="form-control"/>
                                              <small class="error text-danger" id="edit_contact_name_error"></small>
                                            </div>
                                          </div>
                                          
                                          <div class="row form-group mb-3">
                                            <div class="col-12 col-md-5">
                                              <label>Type <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                
                                              <select class="form-select select2" name="about_type_id">
                                                    <option value="">Choose</option>
                                                    @forelse ($customerabouttype as $value)
                                                    <option value="{{ $value->id }}"
                                                        {{ (isset($contact) && $contact->about_type_id == $value->id) ? 'selected' : '' }}>
                                                        {{ $value->name }}
                                                    </option>
                                                    @empty
                                                        <option value="" disabled>No types available!</option>
                                                    @endforelse
                                              </select> 
                                              <small class="error text-danger" id="edit_about_type_id_error"></small>
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
                                                <label>Status</label>
                                            </div>

                                            <div class="col-12 col-md-7 d-flex">

                                                <div class="form-check">
                                                    <input class="form-check-input contact-status" type="radio" name="status" id="active" value="Active" {{ $contact->status == 'Active' ? 'checked' : '' }} />
                                                    <label class="form-check-label" for="active">
                                                        Active
                                                    </label>
                                                </div>

                                                <div class="form-check mx-2">
                                                    <input class="form-check-input contact-status" type="radio" name="status" id="inactive" value="Inactive" {{ $contact->status == 'Inactive' ? 'checked' : '' }} />
                                                    <label class="form-check-label" for="inactive">
                                                        Inactive
                                                    </label>
                                                </div>

                                                <div class="form-check m">
                                                    <input class="form-check-input contact-status" type="radio" name="status" id="blacklist" value="Blacklisted" {{ $contact->status == 'Blacklisted' ? 'checked' : '' }} />
                                                    <label class="form-check-label" for="blacklist">
                                                        Blacklist
                                                    </label>
                                                </div>
                                                
                                            </div>
                                            <small class="error text-danger" id="edit_status_error"></small>
                                        </div>
                                        
                                        <!--///////////////////////////////-->
                                        <div class="status-content statusblacklist {{ ($contact->status == 'Blacklisted' && !empty($contact->blacklist_reason)) ? 'd-block' : 'd-none' }}">
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
                                                <label>Phone <span class="text-danger">*</span></label>
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
                                                    <input type="hidden" name="whatsapp_code" class="phone_code"> 
                                                    <div class="col-12 col-md-12">
                                                        <input type="text" name="whatsapp" value="{{ $contact->whatsapp ?? '' }}" class="form-control telinput " name="whatsapp" />
                                                        <small class="error text-danger" id="edit_whatsapp_error"></small>
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
                                                        <input type="text" name="email" value="{{ $contact->email ?? '' }}" class="form-control" />
                                                        <small class="error text-danger" id="edit_email_error"></small>
                                                    </div>
                                                    <div class="col-3">
                                                        <span class="badge bg-secondary"><i class="uil uil-envelope-alt"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                          <!-- Address Line 1 -->
                                          <div class="row form-group mb-3">
                                            <div class="col-12 col-md-5">
                                              <label>Address</label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                              <textarea name="address" class="form-control" rows="2" id="gstAddr1">{{ $contact->address1 ?? '' }}</textarea>
                                              <small class="error text-danger" id="edit_address_error"></small>
                                            </div>
                                          </div>
                                          
                                          
                                          <!-- State -->
                                          <div class="row form-group mb-3">
                                            <div class="col-12 col-md-5">
                                              <label>State</label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                              <select class="form-select select2 dependent-select" name="state_id" id="gstState" data-target="gstCity">
                                                <option value="">Choose..</option>
                                                @foreach ($states as $state)
                                                    <option value="{{ $state->id }}" data-url="{{ route('getcities', $state->id) }}"
                                                        {{ $state->id == $contact->state_id ? 'selected' : '' }}>
                                                        {{ $state->name }}
                                                    </option>
                                                @endforeach
                                              </select>
                                              <small class="error text-danger" id="edit_state_id_error"></small>
                                            </div>
                                          </div>
                                          

                                          <!-- City -->
                                          <div class="row form-group mb-3">
                                            <div class="col-12 col-md-5">
                                              <label>City</label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                              <select class="form-select select2" name="city_id" id="gstCity">
                                                <option value="">Choose..</option>
                                                @php
                                                    $cities = optional($contact->state)->cities;
                                                @endphp
                                                
                                                @if($cities && $cities->count())
                                                    @foreach($cities as $city)
                                                        <option value="{{$city->id}}" @selected($city->id === $contact->city_id)>{{$city->name}}</option>
                                                    @endforeach
                                                @endif
                                              </select>
                                              <small class="error text-danger" id="edit_city_id_error"></small>
                                            </div>
                                          </div>

                                          

                                          <!-- Postal Code -->
                                          <div class="row form-group mb-3">
                                            <div class="col-12 col-md-5">
                                              <label>Postal Code</label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                              <input type="text" class="form-control numericonly" name="post_code" id="gstPin" value="{{ $contact->zipcode ?? '' }}" />
                                              <small class="error text-danger" id="edit_post_code_error"></small>
                                            </div>
                                          </div>
                                        
                                        <div class="row form-group">
                                            <div class="col-12 col-md-5">
                                                <label>Head Office Map Location</label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <input type="text" class="form-control" name="head_office_map_location" value="{{ $contact->head_office_map_location ?? '' }}" />
                                                <small class="error text-danger" id="edit_head_office_map_location"></small>
                                            </div>
                                        </div>
                                        
                                        
                                        <div class="form-group row">
                                            <div class="col-12 col-md-5">
                                                <label>Halting Charge?</label> 
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <input type="checkbox" class="form-check-input charge-checked"
                                                   name="is_deduction_chargeable" value="1"
                                                   {{ $contact->is_deduction_chargeable == 1 ? 'checked' : '' }}>
                                            </div>
                                        </div>
                                        
                                        
                                        <div class="form-group if-checked" style="{{ ($contact->is_deduction_chargeable ?? 0) == 1 ? '' : 'display:none;' }}">
                                            <div class="row">
                                                <div class="col-12 col-md-5">
                                                    <label>Halting Charges/Day<span class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-12 col-md-7">
                                                    <div class="input-group mb-2"> 
                                                        <span class="input-group-text bg-light text-dark">₹</span> 
                                                        <input type="text" name="halting_charges_per_day" value="{{ $contact->halting_charges_per_day ?? '' }}" class="form-control decimalonly" style="min-height: 30px !important; height: 20px;">
                                                        
                                                    </div>
                                                    <small class="error text-danger" id="edit_halting_charges_per_day_error"></small>
                                                </div>
                                            </div>
                                        </div>
                                          
                            
                                        <div class="row form-group">
                                            <div class="col-12 col-md-5">
                                                <label>Comment About Contact</label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <textarea class="form-control" name="contact_comment" id="contactComment" rows="3" placeholder="">{{ old('contact_comment', $contact->comment ?? '') }}</textarea>
                                                <small class="error text-danger" id="edit_contact_comment"></small>
                                            </div>
                                        </div>

                                    </div>
                                    <!---->                                    
                                </div>
                            </div>
                            

                            <div class="form-bg">

                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <h6>Contact Persons</h6>
                                    </div>
                                    <div class="col-12 col-md-6 text-end">
                                        <i data-bs-toggle="collapse" href="#collapse02" aria-expanded="true" aria-controls="collapse02" class="uil uil-angle-down"></i>
                                    </div>
                                </div>

                                <div class="collapse show" id="collapse02">
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
                                                    <input type="text" name="contact_person_name[{{ $index }}]" value="{{ $relcontact->name }}" class="form-control" />
                                                    <small class="error text-danger" id="edit_contact_person_name_{{ $index }}_error"></small>
                                                </div>
                                            </div>
                                            
                                            <div class="row form-group">
                                                <div class="col-12 col-md-5">
                                                    <label>Position <!--<span class="text-danger">*</span>--></label>
                                                </div>
                                                <div class="col-12 col-md-7">
                                                    <input type="text" name="contact_person_designation[{{ $index }}]" value="{{ $relcontact->position }}" class="form-control" />
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
                                                            <input type="text" class="form-control telinput " name="contact_person_phone[{{ $index }}]" value="{{ $relcontact->phone }}" />
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
                                                            <input type="text" class="form-control telinput " name="contact_person_whatsapp[{{ $index }}]" value="{{ $relcontact->whatsapp }}" />
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
                                            @endforeach
    
                                        </div>
                                    </div>

                                    <div class="mt-3">
                                        <a href="javascript:void(0)" class="btn btn-theme add-person"><i class="uil uil-plus me-1"></i>Contact Person</a>
                                    </div>
                                </div>
                            </div>

                            <div class="form-bg">
                                @php
                                    $isSameAddress = 
                                        ($contact->address1 ?? '') == (optional($contact->cobilling)->address1 ?? '') &&
                                        ($contact->state_id ?? '') == (optional($contact->cobilling)->state_id ?? '') &&
                                        ($contact->city_id ?? '') == (optional($contact->cobilling)->city_id ?? '') &&
                                        ($contact->zipcode ?? '') == (optional($contact->cobilling)->zipcode ?? '');
                                @endphp
                                <div class="row">
                                    <div class="col-12 col-md-9">
                                        <h6>Billing Address</h6>
                                        <div class="form-check mb-3">
                                            <input class="form-check-input same-as-GST-address" type="checkbox" value="" id="flexCheckDefault" {{ $isSameAddress ? 'checked' : '' }} />
                                            <label class="form-check-label shsalb" for="flexCheckDefault">
                                                Same as GST Address?
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
                                            <label>Address</label>
                                        </div>
                                        <div class="col-12 col-md-7">
                                            <textarea class="form-control" name="billing_address" id="billingAddress"  rows="3" placeholder="">{{ optional($contact->cobilling)->address1 ?? '' }}</textarea>
                                            <small class="error text-danger" id="edit_billing_address"></small>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-12 col-md-5">
                                            <label>State</label>
                                        </div>
                                        <div class="col-12 col-md-7">
                                            <select class="form-select select2 dependent-select" name="billing_state_id" id="billingState" data-target="billingCity">
                                                <option value="">Choose..</option>
                                                @foreach ($states as $state)
                                                    <option value="{{ $state->id }}" data-url="{{ route('getcities', $state->id) }}"
                                                        {{ old('state_id', optional($contact->cobilling)->state_id ?? '') == $state->id ? 'selected' : '' }}>
                                                        {{ $state->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <small class="error text-danger" id="edit_billing_state_id"></small>
                                        </div>
                                    </div>
                                    
                                    <div class="row form-group">
                                        <div class="col-12 col-md-5">
                                            <label>City </label>
                                        </div>
                                        <div class="col-12 col-md-7">
                                            <select class="form-select select2" name="billing_city_id" id="billingCity">
                                                <option value="">Choose..</option>
                                                @php
                                                    $cities = optional(optional($contact->cobilling)->state)->cities ?? [];
                                                @endphp
                                            
                                                @if(count($cities))
                                                    @foreach($cities as $city)
                                                        <option 
                                                            value="{{ $city->id }}" 
                                                            @selected(optional($contact->cobilling)->city_id === $city->id)
                                                        >
                                                            {{ $city->name }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <small class="error text-danger" id="edit_billing_city_id"></small>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-12 col-md-5">
                                            <label>Postal Code </label>
                                        </div>
                                        <div class="col-12 col-md-7">
                                            <input type="text" class="form-control numericonly" name="billing_postalcode" id="billingPostalCode" value="{{ optional($contact->cobilling)->zipcode ?? '' }}">
                                            <small class="error text-danger" id="edit_billing_postalcode"></small>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-12 col-md-5">
                                            <label>Additional Info</label>
                                        </div>
                                        <div class="col-12 col-md-7">
                                            <textarea type="textarea" class="form-control" name="billing_additionalinfo" id="billingAdditionalInfo" rows="3" placeholder="Additional Info">{{ optional($contact->cobilling)->add_info ?? '' }}</textarea>
                                            <small class="error text-danger" id="edit_billing_additionalinfo"></small>
                                        </div>
                                    </div>                                       

                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-12 col-md-8 mt-4">
                        <div class="right-side-wrap">
                            <ul class="nav nav-pills" id="pills-tab" role="tablist">
                                
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link " data-bs-toggle="tab" data-bs-target="#contract" type="button" role="tab">
                                        Contract 
                                    </button>
                                </li> 
                                
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#document" type="button" role="tab">
                                        Document
                                    </button>
                                </li>

                                <li class="nav-item" role="presentation">
                                    <button class="nav-link " data-bs-toggle="tab" data-bs-target="#locations" type="button" role="tab">
                                        Location
                                    </button>
                                </li>
                                
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link " data-bs-toggle="tab" data-bs-target="#contract-ricing" type="button" role="tab">
                                        Rate Chart
                                    </button>
                                </li>
                                
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link " data-bs-toggle="tab" data-bs-target="#vehicle" type="button" role="tab">
                                        Vehicle Allocation
                                    </button>
                                </li>
                                
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link " data-bs-toggle="tab" data-bs-target="#activity" type="button" role="tab">
                                        Activity
                                    </button>
                                </li>
                                
                            </ul>

                            <div class="tab-content" id="pills-tabContent">
                                
                                
                                <div class="tab-pane fade " id="contract" role="tabpanel">
                                    <div class="documentdtl-bd">


                                        <div class="row form-group">
                                            
                                        </div>
                                        

                                    </div>
                                    
                                    
                                    
                                    <div class="row mb-2 align-items-center">
                                        <div class="col-12 col-md-12 text-end">
                                            <a href="javascript:void(0)"
                                               class="btn btn-theme"
                                               id="addNewContractBtn"
                                               data-has-contract="{{ $hasContract ? 1 : 0 }}"
                                               data-customer-id="{{ $contact->id }}"
                                               data-create-url="{{ route('contact.customer.contract', ['customerid' => $contact->id]) }}"
                                               data-delete-url="{{ route('contact.customer.contract.delete') }}">
                                                <i class="uil uil-plus me-1"></i> Contract
                                            </a>
                                            
                                        </div>
                                    </div>
                                    
                                    
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Contract No</th>
                                                <th>Contract Type</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>
                                                <th>Payment within Day</th>
                                                <th>Contract File</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                            @forelse ($contact->customercontracts as $contract)
                                                <tr>
                                                    <td>{{ $contract->contract_no }}</td>
                                    
                                                    <td>{{ $contract->contracttype->name ?? '-' }}</td>
                                    
                                                    <td>{{ $contract->start_date ? \Carbon\Carbon::parse($contract->start_date)->format('d-m-Y') : '-' }}</td>
                                                    
                                                    <td>{{ $contract->end_date ? \Carbon\Carbon::parse($contract->end_date)->format('d-m-Y') : '-' }}</td>
                                                    
                                                    <td>{{ $contract->payment_within_day }} Days</td>
                                                    
                                                    <td>
                                                        @if(optional($contract->detail)->contract_file)
                                                            <a href="{{ asset('media/customer-contract/' . $contract->detail->contract_file) }}" 
                                                               target="_blank" >
                                                                View Contract
                                                            </a>
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                     
                                                    <td class="text-center"> 
                                                        
                                                        <div class="dropdown dot-dd">
                                                          <span class="dropdown-toggle" id="moreTable" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="uil uil-ellipsis-h"></i>
                                                          </span>
                                                          <ul class="dropdown-menu" aria-labelledby="moreTable" style="">
                                                            <li><a class="dropdown-item" href="{{ route('contact.customer.contract.edit', $contract->id) }}"><i class="uil uil-pen me-2"></i>Edit</a></li>
                                                            {{--<li><a class="dropdown-item text-danger deleteRecord" data-id="{{ $contract->id }}" data-actmodelid="2" href="javascript:void(0)"><i class="uil uil-trash-alt me-2"></i>Delete</a></li>--}}
                                                          </ul>
                                                        </div>
                                        
                                                    </td>
                                                    
                                                    
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="10" class="text-center text-muted">No contracts found</td>
                                                </tr>
                                            @endforelse
                                        </tbody>

                                 </table>
                                 
                                    
                                </div>
                                
                                <div class="tab-pane fade show active" id="document" role="tabpanel">
                                    <div class="employee-dwrapper">
                                        <div class="form-section">
                                            <!-- First Item Row -->

                                            <div class="item-row">
                                                <div class="row form-group align-items-center">
                                                    <div class="col-12 col-md-2">
                                                        <label>Document Type: </label>
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

                                                            @php
                                                                $fileUrl = asset('media/contact/'.$coattachment->name);
                                                                $extension = strtolower(pathinfo($coattachment->name, PATHINFO_EXTENSION));

                                                                $imageExtensions = ['jpg','jpeg','png','gif','webp','bmp'];
                                                            @endphp
                                                           <div class="col-12 col-md-4 attachment-box">
                                                              <div class="preview-img d-block w-100">
                                                                  <div class="d-flex justify-content-between">
                                                                      <div>
                                                                            <a href="{{ $fileUrl }}" download="{{ $coattachment->original_name }}">
                                
                                                                                @if(in_array($extension, $imageExtensions))
                                                                                    <!-- Image Preview -->
                                                                                    <img src="{{ $fileUrl }}" class="me-3" width="60">

                                                                                @elseif($extension == 'pdf')
                                                                                    <i class="uil-file-alt me-3" style="font-size:40px;"></i>

                                                                                @elseif(in_array($extension, ['doc','docx']))
                                                                                    <i class="uil-file-word me-3" style="font-size:40px;"></i>

                                                                                @elseif(in_array($extension, ['xls','xlsx']))
                                                                                    <i class="uil-file-exclamation-alt me-3" style="font-size:40px;"></i>

                                                                                @elseif(in_array($extension, ['zip','rar']))
                                                                                    <i class="uil-file-archive me-3" style="font-size:40px;"></i>

                                                                                @else
                                                                                    <i class="uil-file me-3" style="font-size:40px;"></i>
                                                                                @endif

                                                                            </a>
                                                                          <div style="font-size: 14px;">
                                                                              <a href="{{ $fileUrl }}" download="{{ $coattachment->original_name }}">
                                                                                <p class="mb-0 file-name">{{ $coattachment->original_name }}</p>
                                                                              </a>
                                                                              <p class="mb-0">Size: <span class="text-secondary">{{round((float)$coattachment->file_size,2)}} MB</span></p>
                                                                          </div>
                                                                      </div>
                                                                      <div class="float-end">
                                                                        <i class="uil-pen text-success edit-attachment-btn" data-id="{{ $coattachment->id }}" style="cursor:pointer;"></i>
                                                                        <i class="uil-trash-alt text-danger delete-attachment-btn" data-url="{{ route('contact.deleteattachment', $coattachment->id) }}" style="cursor:pointer;"></i>
                                                                      </div>
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
                                </div>
                                
                                <div class="tab-pane fade" id="locations" role="tabpanel">

                                    <div class="row mb-3 align-items-center">
                                        <div class="col-12 col-md-12">
                                            <!--<h5 class="d-inline-block">Location</h5>-->
                                            <a href="javascript:void(0)" class="btn btn-theme" data-bs-toggle="modal" data-bs-target="#addLocation"><i class="uil uil-plus me-1"></i>Location</a>
                                            <div class="form-group d-inline-block mb-0 ms-2" style="width: 250px;">
                                                
                                                <select name="customer_location_type" id="customer_location_type" class="form-select select2">
                                                    <option value="">Filter by Location Type</option>
                                                    <option value="Loading">Loading Points</option>
                                                    <option value="Unloading">Unloading Points</option>
                                                    <option value="Both">Loading & Unloading Points</option>
                                                </select>
                                            </div>
                                            <button class="btn btn-primary reset-btn ms-2"><i class="uil uil-history me-1"></i>Reset</button>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="accordion" id="locationCollapse">
                                        @include('contacts.customer.locations', ['locations' => $contact->customerlocations])
                                    </div>
                                    
                                    
                                </div>
                                
                                <div class="tab-pane fade" id="contract-ricing" role="tabpanel">

                                    <div class="row mb-2 align-items-center">
                                        <div class="col-12 col-md-12 text-end">
                                            <a href="javascript:void(0)" class="btn btn-theme" data-bs-toggle="modal" data-bs-target="#contract-pricing">
                                                <i class="uil uil-plus me-1"></i> Rate Chart </a>
                                        </div>
                                    </div>
                                    
                                    <div class="accordion" id="pricingCollapse">

                                        @forelse($contractPricings as $contractId => $pricings)
                                        
                                            @php
                                                $firstPricing = $pricings->first();
                                                $contract = $firstPricing->customerContract;
                                            @endphp
                                        
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="heading{{ $contractId }}">
                                                    
                                                    <button class="accordion-button {{ !$loop->first ? 'collapsed' : '' }} p-3"
                                                            type="button"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#collapse{{ $contractId }}"
                                                            aria-expanded="{{ $loop->first ? 'true' : 'false' }}"
                                                            aria-controls="collapse{{ $contractId }}">
                                                        
                                                        <h6 class="text-dark mb-0 d-flex align-items-center justify-content-between w-100">
                                                            <div>
                                                                <span style="font-size: 14px;">
                                                                    <span class="textbold pe-4">
                                                                        <b>CON#{{ $firstPricing->customerContract->contract_no ?? '-' }}</b>
                                                                    </span>
                                                
                                                                    <span class="badge badge-success ms-4">
                                                                        {{ $firstPricing->applicable_start_date
                                                                            ? \Carbon\Carbon::parse($firstPricing->applicable_start_date)->format('d/m/Y')
                                                                            : ''
                                                                        }}
                                                
                                                                        {{ $firstPricing->applicable_end_date
                                                                            ? \Carbon\Carbon::parse($firstPricing->applicable_end_date)->format('d/m/Y')
                                                                            : ''
                                                                        }}
                                                                    </span>
                                                                </span>
                                                            </div>
                                                        </h6>
                                                        
                                                    </button>
                                                </h2>
                                        
                                                <div id="collapse{{ $contractId }}"
                                                     class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}"
                                                     data-bs-parent="#pricingCollapse">
                                        
                                                    <div class="accordion-body">
                                        
                                                        {{-- LOOP ROUTES UNDER SAME CONTRACT --}}
                                                        @foreach($pricings as $pricing)
                                                        
                                                            @php
                                                                // LOADING (Source + Loading)
                                                                $loadingPoint = $pricing->locationPoints->where('point_type', 'Source')->where('location_type', 'Loading')->first();
                                                            
                                                                // UNLOADING (Destination + Unloading)
                                                                $unloadingPoint = $pricing->locationPoints->where('point_type', 'Destination')->where('location_type', 'Unloading')->first();
                                                                
                                                                
                                                                $midpoints = $pricing->locationPoints->where('point_type', 'Midpoint');
        
                                                                // FIRST VEHICLE
                                                                $vehicle = $pricing->vehicles->first();
                                                            @endphp
                                        
                                                            <h6 class="mt-3">
                                                                <strong>Route: {{ $pricing->contractroute?->route?->name ?? '-' }}</strong>
                                                            </h6>
                                                            {{--<span class="badge bg-success ms-2">
                                                                {{ \Carbon\Carbon::parse($pricing->applicable_start_date)->format('d/m/Y') }}
                                                                -
                                                                {{ \Carbon\Carbon::parse($pricing->applicable_end_date)->format('d/m/Y') }}
                                                            </span>--}}
                                        
                                                            <div class="table-responsive mt-2">
                                                                <table class="table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Loading Point</th>
                                                                            <th>Unloading Point</th>
                                                                            <th>Vehicle Type</th>
                                                                            <th style="width:160px;">Vehicle Size</th>
                                                                            <th>Current Freight (₹)</th>
                                                                            <th>Labour Charge</th>
                                                                            <th class="text-end">Action</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        
                                                                        <tr>
                                                                            
                                                                            {{-- Loading Point --}}
                                                                            <td> 
                                                                                <p class="mb-1">
                                                                                    <span class="rounded-circle badge bg-primary me-2"
                                                                                          style="width: 20px; height: 20px;">1</span>
                                                                                    {{ $loadingPoint?->location?->location_name ?? '-' }}
                                                                                </p>
                                                                            </td>
                                                                        
                                                                            {{-- Unloading Point --}}
                                                                            <td>
                                                                                {{ $unloadingPoint?->location?->location_name ?? '-' }}
                                                                            </td>
                                                                        
                                                                            {{-- Vehicle Type --}}
                                                                            <td>
                                                                                {{ $vehicle?->vehicleType?->name ?? '-' }}
                                                                            </td>
                                                                        
                                                                            {{-- Vehicle Size --}}
                                                                            <td> 
                                                                                @if($pricing->vehicles->isNotEmpty())
                                                                            
                                                                                    @php
                                                                                        $vehicle = $pricing->vehicles->first();
                                                                                    @endphp
                                                                            
                                                                                    <span class="tag">
                                                                                        {{ $vehicle->vehicleTypeSize?->name ?? '-' }}
                                                                                        {{ $vehicle->vehicleTypeSize?->length ?? '' }} *
                                                                                        {{ $vehicle->vehicleTypeSize?->width ?? '' }} *
                                                                                        {{ $vehicle->vehicleTypeSize?->height ?? '' }}
                                                                                    </span>
                                                                            
                                                                                    {{-- Show "More" only if more than 1 vehicle --}}
                                                                                    @if($pricing->vehicles->count() > 1)
                                                                                        <a class="vehicle-detail-btn"
                                                                                           data-id="{{ $pricing->id }}"
                                                                                           href="javascript:void(0)"
                                                                                           data-bs-toggle="modal"
                                                                                           data-bs-target="#moreSize">
                                                                                           More
                                                                                        </a>
                                                                                    @endif
                                                                            
                                                                                @else
                                                                                    -
                                                                                @endif
                                                                            </td>
                                                                        
                                                                            {{-- Freight --}}
                                                                            <td>
                                                                                ₹{{ number_format($vehicle?->price ?? 0, 2) }}
                                                                            </td>
                                                                        
                                                                            {{-- Labour Charge --}}
                                                                            <td>
                                                                                @php
                                                                                    $sourceCharge = 0;
                                                                                    $destinationCharge = 0;
                                                                                    $midpointCharge = 0;
                                                                                
                                                                                    // SOURCE
                                                                                    if ($loadingPoint) {
                                                                                        $chargesPaidBy = $loadingPoint?->location?->charges_paid_by;
                                                                                
                                                                                        if ($chargesPaidBy == 'SRL') {
                                                                                            $sourceCharge += $loadingPoint?->location?->loading_charge ?? 0;
                                                                                        }
                                                                                
                                                                                        if ($chargesPaidBy == 'Mixed') {
                                                                                            $sourceCharge += $loadingPoint?->location?->loading_charge ?? 0;
                                                                                        }
                                                                                    }
                                                                                
                                                                                    // DESTINATION
                                                                                    if ($unloadingPoint) {
                                                                                        $chargesPaidBy = $unloadingPoint?->location?->charges_paid_by;
                                                                                
                                                                                        if ($chargesPaidBy == 'SRL') {
                                                                                            $destinationCharge += $unloadingPoint?->location?->unloading_charge ?? 0;
                                                                                        }
                                                                                
                                                                                        if ($chargesPaidBy == 'Mixed') {
                                                                                            $destinationCharge += $unloadingPoint?->location?->unloading_charge ?? 0;
                                                                                        }
                                                                                    }
                                                                                
                                                                                    // MIDPOINTS (ALL)
                                                                                    foreach ($midpoints as $midpoint) {
                                                                                
                                                                                        $chargesPaidBy = $midpoint?->location?->charges_paid_by;
                                                                                
                                                                                        if ($midpoint->location_type == 'Loading') {
                                                                                
                                                                                            if ($chargesPaidBy == 'SRL') {
                                                                                                $midpointCharge += $midpoint?->location?->loading_charge ?? 0;
                                                                                            }
                                                                                
                                                                                            if ($chargesPaidBy == 'Mixed') {
                                                                                                $midpointCharge += $midpoint?->location?->loading_charge ?? 0;
                                                                                            }
                                                                                        }
                                                                                
                                                                                        if ($midpoint->location_type == 'Unloading') {
                                                                                
                                                                                            if ($chargesPaidBy == 'SRL') {
                                                                                                $midpointCharge += $midpoint?->location?->unloading_charge ?? 0;
                                                                                            }
                                                                                
                                                                                            if ($chargesPaidBy == 'Mixed') {
                                                                                                $midpointCharge += $midpoint?->location?->unloading_charge ?? 0;
                                                                                            }
                                                                                        }
                                                                                    }
                                                                                
                                                                                    $labourCharge = $sourceCharge + $destinationCharge + $midpointCharge;
                                                                                @endphp
                                                                        
                                                                                <a href="javascript:void(0)"
                                                                                   class="labour-charge-btn"
                                                                                   data-id="{{ $pricing->id }}"
                                                                                   data-bs-toggle="modal"
                                                                                   data-bs-target="#labourChargeModal">
                                                                                    ₹{{ number_format($labourCharge, 2) }}
                                                                                </a>
                                                                            </td>
                                                                        
                                                                            {{-- Action --}}
                                                                            <td class="text-end">
                                                                                <a href="javascript:void(0)"
                                                                                   class="pricing-history-btn"
                                                                                   data-id="{{ $pricing->id }}"
                                                                                   data-bs-toggle="modal"
                                                                                   data-bs-target="#pricingHistoryModal">
                                                                                    History
                                                                                </a>
                                                                                
                                                                                <!--<br><a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#pricing_history">-->
                                                                                <!--    HTML-->
                                                                                <!--</a>-->
                                                                            </td>
                                                                        
                                                                        </tr>


                                                                        
                                                                        
                                                                        
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                        
                                                        @endforeach
                                        
                                                    </div>
                                                </div>
                                            </div>
                                        
                                        @empty
                                            <div class="no-data text-center py-4">
                                                <p class="text-dark mb-0">No Rate Chart Found!</p>
                                            </div>
                                        @endforelse
                                    
                                    </div>
                                    
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
                                
                                <div class="tab-pane fade " id="vehicle" role="tabpanel">
                                    <div class="row mb-2 align-items-center">
                                        <div class="col-12 col-md-12 text-end">
                                            <a href="javascript:void(0)" class="btn btn-theme" data-bs-toggle="modal" data-bs-target="#vehAllocation">
                                                <i class="uil uil-plus me-1"></i> Vehicle Allocation
                                            </a>
                                        </div>
                                    </div>
                                    @include('contacts.customer.vehicles', ['vehicles' => $contact->vehicleAllocations])
                                </div>
                                
                            </div>
                    </div>

                </div>
            </div>
        </div>

    </form>
            
</div>






<!-- Modal -->
<div class="modal fade" id="addLocation" tabindex="-1" aria-labelledby="addLocationLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addLocationLabel">Add Location</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="uil uil-times"></i></button>
            </div>
            <div class="modal-body">
                <form action="{{route('contact.customer.location.save')}}" id="addContactLocationForm">
                    @csrf
                    <input type="hidden" name="contact_id" value="{{ $contact->id ?? '' }}" />
                    <div class="row">
                        <div class="col-12 col-md-6 form-group">
                            <label>Company Name <span class="text-danger">*</span></label>
                            <input type="text" name="company_name" class="form-control" />
                            <small class="error text-danger" id="add_company_name_error"></small>
                        </div>
                        <div class="col-12 col-md-6 form-group">
                            <label>Company Role <span class="text-danger">*</span></label>
                            <div class="form-check form-check-inline radio-chip">
                              <input class="form-check-input" type="radio" name="company_role" id="company_role_consignor" value="Consignor">
                              <label class="form-check-label" for="company_role_consignor"><i class="uil uil-check-circle me-1"></i>Consignor</label>
                            </div>
                            <div class="form-check form-check-inline radio-chip">
                              <input class="form-check-input" type="radio" name="company_role" id="company_role_consignee" value="Consignee">
                              <label class="form-check-label" for="company_role_consignee"><i class="uil uil-check-circle me-1"></i>Consignee</label>
                            </div>    
                            <small class="error text-danger" id="add_company_role_error"></small>
                        </div>
                        
                        <div class="col-12 col-md-6 form-group">
                            <label>Route Type <span class="text-danger">*</span></label>
                            <div class="form-check form-check-inline radio-chip">
                              <input class="form-check-input" type="radio" name="route_type" id="source" value="source">
                              <label class="form-check-label if-source" for="source"><i class="uil uil-check-circle me-1"></i>Source</label>
                            </div>
                            <div class="form-check form-check-inline radio-chip">
                              <input class="form-check-input" type="radio" name="route_type" id="destination" value="destination">
                              <label class="form-check-label if-destination" for="destination"><i class="uil uil-check-circle me-1"></i>Destination</label>
                            </div>
                            <div class="form-check form-check-inline radio-chip">
                              <input class="form-check-input" type="radio" name="route_type" id="midpoint" value="midpoint">
                              <label class="form-check-label if-midpoint" for="midpoint"><i class="uil uil-check-circle me-1"></i>Midpoint</label>
                            </div>
                            <small class="error text-danger" id="add_route_type_error"></small>
                        </div>
                        
                        <div class="col-12 col-md-6 form-group source-wrap">
                            <label>Source</label>
                            <select name="source_city_id" id="source_city_id" class="form-select select2">
                                <option value="">Choose source city</option>
                                @foreach ($routeSourceCities as $city)
                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                @endforeach
                            </select>
                            <small class="error text-danger" id="add_source_city_id_error"></small>
                        </div>
                        <div class="col-12 col-md-6 form-group destination-wrap">
                            <label>Destination</label>
                            <select name="destination_city_id" id="destination_city_id" class="form-select select2">
                                <option value="">Choose destination city</option>
                                @foreach ($routeDestCities as $city)
                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                @endforeach
                            </select>
                            <small class="error text-danger" id="add_destination_city_id_error"></small>
                        </div>
                        <div class="col-12 col-md-6 form-group midpoint-wrap">
                            <label>Midpoint</label>
                            <select name="midpoint_city_id" id="midpoint_city_id" class="form-select select2">
                                <option value="">Choose midpoint</option>
                                @foreach ($routeMidpointCities as $city)
                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                @endforeach
                            </select>
                            <small class="error text-danger" id="add_midpoint_city_id_error"></small>
                        </div>
                        
                        
                        <div class="col-12 col-md-6 form-group">
                            <label>Location Name <span class="text-danger">*</span></label>
                            <input type="text" name="location_name" class="form-control" />
                            <small class="error text-danger" id="add_location_name_error"></small>
                        </div>
                        <div class="col-12 col-md-6 form-group">
                            <label>Address <span class="text-danger">*</span></label>
                            <input type="text" name="address" class="form-control" />
                            <small class="error text-danger" id="add_address_error"></small>
                        </div>
                        <div class="col-12 col-md-6 form-group">
                            <label>Postal Code <span class="text-danger">*</span></label>
                            <input type="text" name="post_code" class="form-control" />
                            <small class="error text-danger" id="add_post_code_error"></small>
                        </div>
                        
                        
                        <div class="col-12 col-md-6 form-group">
                            <label>Location Type <span class="text-danger">*</span></label>
                            <div class="form-check form-check-inline radio-chip">
                              <input class="form-check-input" type="radio" name="location_type" id="loading" value="Loading">
                              <label class="form-check-label" for="loading"><i class="uil uil-check-circle me-1"></i>Loading</label>
                            </div>
                            <div class="form-check form-check-inline radio-chip">
                              <input class="form-check-input" type="radio" name="location_type" id="unloading" value="Unloading">
                              <label class="form-check-label" for="unloading"><i class="uil uil-check-circle me-1"></i>Unloading</label>
                            </div>
                            <div class="form-check form-check-inline radio-chip LocationTypeBoth">
                              <input class="form-check-input" type="radio" name="location_type" id="both" value="Both">
                              <label class="form-check-label" for="both"><i class="uil uil-check-circle me-1"></i>Loading & Unloading</label>
                            </div>
                            <small class="error text-danger" id="add_location_type_error"></small>
                        </div>
                        
                        <div class="row">
                            <div class="col-12 col-md-6 form-group LoadingChargeDiv" style="display:none;">
                                <label>Loading Charge</label>
                                <div class="form-check form-check-inline radio-chip">
                                  <input class="form-check-input" type="radio" name="loading_charge_type" id="loading_charge_fixed" value="Fixed">
                                  <label class="form-check-label" for="loading_charge_fixed"><i class="uil uil-check-circle me-1"></i>Fixed</label>
                                </div>
                                <div class="form-check form-check-inline radio-chip">
                                  <input class="form-check-input" type="radio" name="loading_charge_type" id="loading_charge_variable" value="Variable">
                                  <label class="form-check-label" for="loading_charge_variable"><i class="uil uil-check-circle me-1"></i>Variable</label>
                                </div>
                                <small class="error text-danger" id="add_loading_charge_type_error"></small>
                                
                                <div class="input-group mb-3">
                                  <span class="input-group-text bg-light text-dark">₹</span>
                                  <input type="text" name="loading_charge" class="form-control locationLoadingCharge" style="min-height: 30px !important; height: 20px;"/>
                                </div>
                                <small class="error text-danger" id="add_loading_charge_error"></small>
                            </div>
                            <div class="col-12 col-md-6 form-group UnloadingChargeDiv" style="display:none;">
                                <label>Unloading Charge</label>
                                <div class="form-check form-check-inline radio-chip">
                                  <input class="form-check-input" type="radio" name="unloading_charge_type" id="fixed" value="Fixed">
                                  <label class="form-check-label" for="fixed"><i class="uil uil-check-circle me-1"></i>Fixed</label>
                                </div>
                                <div class="form-check form-check-inline radio-chip">
                                  <input class="form-check-input" type="radio" name="unloading_charge_type" id="variable" value="Variable">
                                  <label class="form-check-label" for="variable"><i class="uil uil-check-circle me-1"></i>Variable</label>
                                </div>
                                <small class="error text-danger" id="add_unloading_charge_type_error"></small>
                                
                                <div class="input-group mb-3">
                                  <span class="input-group-text bg-light text-dark">₹</span>
                                  <input type="text" name="unloading_charge" class="form-control locationUnloadingCharge" style="min-height: 30px !important; height: 20px;"/>
                                </div>
                                <small class="error text-danger" id="add_unloading_charge_error"></small>
                            </div>
                        </div>
                        
                        <div class="col-12 col-md-6 form-group">
                            <label>Charges Paid By</label>
                            <div class="form-check form-check-inline radio-chip">
                              <input class="form-check-input" type="radio" name="brone_by" id="brone_by_customer" value="customer">
                              <label class="form-check-label" for="brone_by_customer"><i class="uil uil-check-circle me-1"></i>Customer</label>
                            </div>
                            <div class="form-check form-check-inline radio-chip">
                              <input class="form-check-input" type="radio" name="brone_by" id="brone_by_srl" value="srl">
                              <label class="form-check-label" for="brone_by_srl"><i class="uil uil-check-circle me-1"></i>SRL</label>
                            </div>
                            <div class="form-check form-check-inline radio-chip">
                              <input class="form-check-input" type="radio" name="brone_by" id="brone_by_mixed" value="mixed">
                              <label class="form-check-label" for="brone_by_mixed"><i class="uil uil-check-circle me-1"></i>Mixed</label>
                            </div>
                            
                            <div class="mb-3 CappingAmountDiv" style="display:none;">
                              <label>Capping Amount</label>
                              <div class="input-group">
                                <span class="input-group-text bg-light text-dark">₹</span>
                                <input type="text" name="capping_amount" class="form-control locationCappingAmount" placeholder="Capping amount" style="min-height: 30px !important; height: 20px;"/>
                              </div>
                              <small class="error text-danger" id="add_capping_amount_error"></small>
                            </div>
                            <small class="error text-danger" id="add_brone_by_error"></small>
                        </div>
                        <div class="col-12 col-md-6 form-group">
                            <label>Onsite Contact Person</label>
                            <input type="text" name="onsite_contact_person" class="form-control"/>
                            <small class="error text-danger" id="add_onsite_contact_person_error"></small>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12 col-md-6 form-group">
                            <label>Onsite Contact Number</label>
                            <div class="row">
                                <div class="col-12">
                                    <input type="hidden" name="onsite_contact_person_phone_code" class="phone_code"> 
                                    <input type="text" name="onsite_contact_person_phone" class="form-control telinput"/>
                                    <small class="error text-danger" id="add_onsite_contact_person_phone_error"></small>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 form-group">
                            <label>Onsite Whatsapp Number</label>
                            <div class="row">
                                <div class="col-12">
                                    <input type="hidden" name="onsite_contact_person_whatsapp_code" class="phone_code"> 
                                    <input type="text" name="onsite_contact_person_whatsapp" class="form-control telinput"/>
                                    <small class="error text-danger" id="add_onsite_contact_person_whatsapp_error"></small>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12 form-group">
                            <label>Map Location <span class="text-danger">*</span></label>
                            <textarea name="map_location" class="form-control" rows="2"></textarea>
                            <small class="error text-danger" id="add_map_location_error"></small>
                        </div>
                        <div class="col-12 form-group">                                
                            <label>Additional Info</label>
                            <textarea name="additional_info" class="form-control" rows="2"></textarea>
                            <small class="error text-danger" id="add_additional_Info_error"></small>
                        </div>
                    </div>
                    
                    <div class="text-end">
                        <button type="button" id="addContactLocationBtn" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> 


<!-- Modal -->
<div class="modal fade contract_wrapperModal" id="contract-pricing" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
                
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Rate Chart</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="uil uil-times"></i></button>
            </div>
              
            <div class="modal-body">
                <form action="{{route('contact.customer.contract.pricing.save')}}" id="addContractPricingForm">
                    @csrf
                    
                    <input type="hidden" name="contact_id" value="{{ $contact->id ?? '' }}" />
                    
                    <div class="row">
                        @php
                            $today = \Carbon\Carbon::today();
                        @endphp
                        
                        <div class="col-12 col-md-6 form-group">
                            <label>Contract <span class="text-danger">*</span></label>
                            <select name="customercontract_id" id="customercontract_id" class="form-select select2">
                                <option value="">Choose...</option>
                                @forelse($activeContracts as $contract)
                                    @php
                                        $status = 'Inactive';
                            
                                        if ($contract->contract_type_id == 6) {
                                            $status = 'Life Time';
                                        } elseif ($contract->start_date <= $today && $contract->end_date >= $today) {
                                            $status = 'Active';
                                        }
                                    @endphp
                                    <option value="{{ $contract->id }}" data-status="{{ $status }}">
                                        {{ $contract->contract_no }} ({{ $status }})
                                    </option>
                                @empty
                                    <option disabled>No Active Contracts</option>
                                @endforelse
                            </select>
                            <span class="error text-danger" id="add_customercontract_id_error"></span>
                        </div>
                        
                        <div class="col-12 col-md-6 form-group">
                            <label>Route Type <span class="text-danger">*</span></label>
                            <select name="customercontract_route_id" id="customercontract_route_id" class="form-select select2">
                                <option value="">Choose...</option>
                            </select>
                            <span class="error text-danger" id="add_customercontract_route_id_error"></span>
                        </div>
                            
                        <div class="source_sec">
                            <div class="row">
                                
                                <div class="col-12 col-md-6 form-group">
                                    <label>Source Loading Point <span class="text-danger">*</span></label>
                                    <select name="contract_source_city_id" id="contract_source_city_id" class="form-select select2">
                                        <option value="">Choose...</option>
                                        @foreach($sourceLoadingPoints as $location)
                                            <option value="{{ $location->id }}">{{ $location->location_name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="error text-danger" id="add_contract_source_city_id_error"></span>
                                </div>
                                
                                <div class="col-12 col-md-6 form-group">
                                    <label>Destination Unloading Point <span class="text-danger">*</span></label>
                                    <select name="contract_destination_city_id" id="contract_destination_city_id" class="form-select select2">
                                        <option value="">Choose...</option>
                                        @foreach($destinationUnloadingPoints as $location)
                                            <option value="{{ $location->id }}">{{ $location->location_name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="error text-danger" id="add_contract_destination_city_id_error"></span>
                                </div>
                                
                            </div>
                        </div>
                        
                        
                        
                        <div class="source_sec" id="MidpointDiv">
                            <input type="hidden" name="midpoint_count" id="midpoint_count" value="" />
                            
                            <div id="midpointContainer"></div>
                            
                        </div>
                        
                        
                        
                        <div class="col-12 col-md-6 form-group">
                            <label>Applicable Date Range <span class="text-danger">*</span></label>
                            <input type="text" name="applicable_date_range" class="daterange form-control" placeholder="Select date range" readonly />
                            
                            
                            <!-- Hidden inputs to store start and end dates -->
                            <input type="hidden" name="applicable_start_date" class="applicable_start_date">
                            <input type="hidden" name="applicable_end_date" class="applicable_end_date">
                            
                            <span class="error text-danger" id="add_applicable_start_date_error"></span>
                            <span class="error text-danger" id="add_applicable_end_date_error"></span>
                        </div>
                        
                        <div class="col-12 col-md-6 form-group">
                            <label>Retrospective Date Range <span class="text-danger">*</span></label>
                            <input type="text" name="retrospective_date_range" class="daterange form-control" placeholder="Select date range" readonly />
                            
                            <!-- Hidden inputs to store start and end dates -->
                            <input type="hidden" name="retrospective_start_date" class="retrospective_start_date">
                            <input type="hidden" name="retrospective_end_date" class="retrospective_end_date">
                            
                            <span class="error text-danger" id="add_retrospective_start_date_error"></span>
                            <span class="error text-danger" id="add_retrospective_end_date_error"></span>
                        </div>
                        
                        
                            
                        <!--////////////////////////////////////////////////////////////////////////-->
                        
                        <div class="routes-wrap">
                            <div class="row">
                                
                                <label>Vehicle Pricing <span class="text-danger">*</span></label>
                               
                                <div class="col-12 col-md-11">
                                    <div class="vehicleRows">
                                
                                        <div class="vehicleRow row form-group">
                                            <div class="col-12 col-md-3">
                                                <div class="form-floating">
                                                    <select name="vehicle_type_id[]" class="form-select vehicleTypeId">
                                                        <option value="">Choose</option>
                                                        @foreach($vehicletypes as $type)
                                                            <option value="{{ $type->id }}">
                                                                {{ $type->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <label>Vehicle Type</label>
                                                </div>
                                                <span class="error text-danger vehicle_type_id_error"></span>
                                            </div>
                                
                                            <div class="col-12 col-md-3">
                                                <div class="form-floating">
                                                    <select name="vehicletype_size_id[]" class="form-select vehicleTypeSizeId">
                                                        <option value="">Choose</option>
                                                    </select>
                                                    <label>Vehicle Size</label>
                                                </div>
                                                <span class="error text-danger vehicletype_size_id_error"></span>
                                            </div>

                                            <div class="col-12 col-md-2">
                                                <div class="form-floating">
                                                    <input type="text" name="vehicletype_weight[]" class="form-control priceInput">
                                                    <label>Weight</label>
                                                </div>
                                                <span class="error text-danger vehicletype_weight_error"></span>
                                            </div>
                                
                                            <div class="col-12 col-md-3">
                                                <div class="form-floating">
                                                    <input type="text" name="vehicletype_price[]" class="form-control priceInput">
                                                    <label>Price(₹)</label>
                                                </div>
                                                <span class="error text-danger vehicletype_price_error"></span>
                                            </div>
                                
                                            <div class="col-12 col-md-1 d-flex align-items-center">
                                                <button type="button" class="btn btn-outline-danger btn-sm removeVehicleRow" title="Remove">
                                                    <i class="uil uil-trash-alt"></i>
                                                </button>
                                            </div>
                                        </div>
                                
                                    </div>
                                </div>

                                
                                <div class="col-12 col-md-11 text-end ">
                                    <button class="btn btn-primary mt-2 addNewVehicle"><i class="uil uil-plus-circle me-1"></i>Add</button>
                                </div>
                                
                            </div>
                        </div>
                        
                        <!--////////////////////////////////////////////////////////////////////////-->
                        
                        
                        
                    </div>
                </form>
            </div>
              
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" id="addContractPricingBtn" class="btn btn-primary">Save</button>
            </div>
              
        </div>
    </div>
</div>


<div class="modal fade" id="labourChargeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Labour Charge</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="uil uil-times"></i></button>
          </div>
          <div class="modal-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th colspan="5">
                                <span style="font-size: 14px;">
                                    <strong>Updated By:</strong> 
                                    <span id="modalUpdatedBy">-</span>
                                </span>
                            
                                <span style="font-size: 14px;" class="ms-5">
                                    <strong>Updated On:</strong> 
                                    <span id="modalUpdatedOn">-</span>
                                </span>
                            </th>
                        </tr>
                        <tr>
                            <th>Loading Point</th>
                            <th>Unloading Point</th>
                            <th>Charges Paid By</th>
                            <th>Labour Charge</th>
                        </tr>
                    </thead>
                    <tbody id="labourChargeTableBody">
                        <tr>
                            <td colspan="4" class="text-center">Loading...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
          </div>
        </div>
    </div>
</div>


<div class="modal fade" id="moreSize" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Vehicle Freight</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="uil uil-times"></i></button>
          </div>
          <div class="modal-body">
              <div class="table-responsive">
                  <table class="table w-100">
                      <thead>
                          <tr>
                              <th>Vehicle Size</th>
                              <th class="text-end">Current Freight</th>
                          </tr>
                      </thead>
                      <tbody id="vehicleFreightBody">
                        <tr>
                            <td colspan="2" class="text-center">Loading...</td>
                        </tr>
                      </tbody>

                  </table>
              </div>
          </div>
        </div>
    </div>
</div>


<div class="modal fade" id="pricingHistoryModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            
            <div id="pricingHistoryBody">
                <div class="text-center">Loading...</div>
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


<div class="modal fade" id="vehAllocation" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Vehicle Allocation</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="uil uil-times"></i></button>
          </div>
          <div class="modal-body">
            <form action="{{route('contact.customer.vehicle.save')}}" id="addVehicleAllocationForm">
                @csrf
                    
                <input type="hidden" name="contact_id" value="{{ $contact->id ?? '' }}" />
                
                <div class="form-group">
                    <label>Vehicle Number <span class="text-danger">*</span></label>
                    <select name="vehicle_id" class="form-control select2-modal">
                        <option value="">Select Vehicle</option>
                    
                        @foreach($vehicles as $vehicle)
                            <option value="{{ $vehicle->id }}">
                                {{ $vehicle->vehicle_no }}
                            </option>
                        @endforeach
                    </select>
                    <small class="error text-danger" id="add_vehicle_id_error"></small>
                </div>
                
                <div class="row form-group">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label>Start Date <span class="text-danger">*</span></label>
                            <input type="date" name="v_start_date" class="form-control" />
                            <small class="error text-danger" id="add_v_start_date_error"></small>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label>End Date <span class="text-danger">*</span></label>
                            <input type="date" name="v_end_date" class="form-control" />
                            <small class="error text-danger" id="add_v_end_date_error"></small>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>KM Allowed <span class="text-danger">*</span></label>
                    <input type="text" name="v_allowed_km" class="form-control">
                    <small class="error text-danger" id="add_v_allowed_km_error"></small>
                </div>
                <div class="form-group">
                    <label>Fixed Amount <span class="text-danger">*</span></label>
                    <div class="input-group mb-3">
                      <span class="input-group-text" id="inr">₹</span>
                      <input type="text" name="v_fixed_amount" class="form-control" aria-describedby="inr">
                      <small class="error text-danger" id="add_v_fixed_amount_error"></small>
                    </div>
                </div>
                <div class="form-group">
                    <label>Extra Amount/Km <span class="text-danger">*</span></label>
                    <div class="input-group mb-3">
                      <span class="input-group-text" id="inr">₹</span>
                      <input type="text" name="v_extra_amount_per_km" class="form-control" aria-describedby="inr">
                      <small class="error text-danger" id="add_v_extra_amount_per_km_error"></small>
                    </div>
                </div>
                <div class="text-end">
                    <button type="button" id="addVehicleBtn" class="btn btn-primary">Save</button>
                </div>
            </form>
          </div>
        </div>
    </div>
</div>














<!-- HTML Modal -->

<div class="modal fade" id="pricinghistory_second" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Rate Chart History</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="uil uil-times"></i></button>
          </div>
          <div class="modal-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th colspan="5">
                                <span style="font-size: 14px;"><span class="textbold pe-4"><b>CON#010226</b></span><strong>Route:</strong> Kolkata - Delhi</span>
                                <span style="font-size: 14px;" class="badge badge-success ms-5">20/01/2026 - 25/01/2026</span>
                                <span style="font-size: 14px;" class="ms-5"><strong>Updated By:</strong> John Doe</span>
                                <span style="font-size: 14px;" class="ms-5"><strong>Updated On:</strong> 12/01/2026</span>
                            </th>
                        </tr>
                        <tr>
                            <th>Location</th>
                            <th>Vehicle Type</th>
                            <th>Vehicle Size</th>
                            <th>Current Freight (₹)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Webel Gate 1</td>
                            <td>Large Truck</td>
                            <td><span class="tag">28 FT - XXL   28M * 12M * 17M</span></td>
                            <td>50000</td>
                        </tr>
                        <tr>
                            <td>Webel Gate 1</td>
                            <td>Mini Truck</td>
                            <td><span class="tag">28 FT - XXL   28M * 12M * 17M</span></td>
                            <td>30000</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <hr>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th colspan="5">
                                <span style="font-size: 14px;"><span class="textbold pe-4"><b>CON#010226</b></span><strong>Route:</strong> Kolkata - Delhi</span>
                                <span style="font-size: 14px;" class="badge badge-success ms-5">20/01/2026 - 25/01/2026</span>
                                <span style="font-size: 14px;" class="ms-5"><strong>Updated By:</strong> John Doe</span>
                                <span style="font-size: 14px;" class="ms-5"><strong>Updated On:</strong> 12/01/2026</span>
                            </th>
                        </tr>
                        <tr>
                            <th>Location</th>
                            <th>Vehicle Type</th>
                            <th>Vehicle Size</th>
                            <th>Current Freight (₹)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Webel Gate 1</td>
                            <td>Large Truck</td>
                            <td><span class="tag">28 FT - XXL   28M * 12M * 17M</span></td>
                            <td>50000</td>
                        </tr>
                        <tr>
                            <td>Webel Gate 1</td>
                            <td>Mini Truck</td>
                            <td><span class="tag">28 FT - XXL   28M * 12M * 17M</span></td>
                            <td>30000</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <hr>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th colspan="5">
                                <span style="font-size: 14px;"><span class="textbold pe-4"><b>CON#010226</b></span><strong>Route:</strong> Kolkata - Delhi</span>
                                <span style="font-size: 14px;" class="badge badge-success ms-5">20/01/2026 - 25/01/2026</span>
                                <span style="font-size: 14px;" class="ms-5"><strong>Updated By:</strong> John Doe</span>
                                <span style="font-size: 14px;" class="ms-5"><strong>Updated On:</strong> 12/01/2026</span>
                            </th>
                        </tr>
                        <tr>
                            <th>Location</th>
                            <th>Vehicle Type</th>
                            <th>Vehicle Size</th>
                            <th>Current Freight (₹)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Webel Gate 1</td>
                            <td>Large Truck</td>
                            <td><span class="tag">28 FT - XXL   28M * 12M * 17M</span></td>
                            <td>50000</td>
                        </tr>
                        <tr>
                            <td>Webel Gate 1</td>
                            <td>Mini Truck</td>
                            <td><span class="tag">28 FT - XXL   28M * 12M * 17M</span></td>
                            <td>30000</td>
                        </tr>
                    </tbody>
                </table>
            </div>
          </div>
        </div>
    </div>
</div>

<div class="modal fade" id="pricing_history" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Rate Chart History <span style="font-size: 14px;"><span class="textbold pe-4"><b>CON#010226</b></span><strong>Route:</strong> Kolkata - Delhi</span>
            <span style="font-size: 14px;" class="badge badge-success ms-5">20/01/2026 - 25/01/2026</span></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="uil uil-times"></i></button>
          </div>
          <div class="modal-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th colspan="5">
                                <span style="font-size: 14px;"><strong>Updated By:</strong> John Doe</span>
                                <span style="font-size: 14px;" class="ms-5"><strong>Updated On:</strong> 12/01/2026</span>
                            </th>
                        </tr>
                        <tr>
                            <th>Loading Point</th>
                            <th>Unloading Point</th>
                            <th>Vehicle Type</th>
                            <th>Vehicle Size</th>
                            <th>Current Freight (₹)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>New Town Bus Stand</td>
                            <td>Gate 2</td>
                            <td>Large Truck</td>
                            <td><span class="tag">28 FT - XXL   28M * 12M * 17M</span></td>
                            <td>50000</td>
                        </tr>
                        <tr>
                            <td>New Town Bus Stand</td>
                            <td>Gate 2</td>
                            <td>Mini Truck</td>
                            <td><span class="tag">28 FT - XXL   28M * 12M * 17M</span></td>
                            <td>30000</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <hr>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th colspan="5">
                                <!--<span style="font-size: 14px;"><span class="textbold pe-4"><b>CON#010226</b></span><strong>Route:</strong> Kolkata - Delhi</span>-->
                                <!--<span style="font-size: 14px;" class="badge badge-success ms-5">20/01/2026 - 25/01/2026</span>-->
                                <span style="font-size: 14px;"><strong>Updated By:</strong> John Doe</span>
                                <span style="font-size: 14px;" class="ms-5"><strong>Updated On:</strong> 12/01/2026</span>
                            </th>
                        </tr>
                        <tr>
                            <th>Loading Point</th>
                            <th>Unloading Point</th>
                            <th>Vehicle Type</th>
                            <th>Vehicle Size</th>
                            <th>Current Freight (₹)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>New Town Bus Stand</td>
                            <td>Gate 1</td>
                            <td>Large Truck</td>
                            <td><span class="tag">28 FT - XXL   28M * 12M * 17M</span></td>
                            <td>50000</td>
                        </tr>
                        <tr>
                            <td>New Town Bus Stand</td>
                            <td>Gate 2</td>
                            <td>Mini Truck</td>
                            <td><span class="tag">28 FT - XXL   28M * 12M * 17M</span></td>
                            <td>30000</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <hr>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th colspan="5">
                                <!--<span style="font-size: 14px;"><span class="textbold pe-4"><b>CON#010226</b></span><strong>Route:</strong> Kolkata - Delhi</span>-->
                                <!--<span style="font-size: 14px;" class="badge badge-success ms-5">20/01/2026 - 25/01/2026</span>-->
                                <span style="font-size: 14px;"><strong>Updated By:</strong> John Doe</span>
                                <span style="font-size: 14px;" class="ms-5"><strong>Updated On:</strong> 12/01/2026</span>
                            </th>
                        </tr>
                        <tr>
                            <th>Loading Point</th>
                            <th>Unloading Point</th>
                            <th>Vehicle Type</th>
                            <th>Vehicle Size</th>
                            <th>Current Freight (₹)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>New Town Bus Stand</td>
                            <td>Gate 2</td>
                            <td>Large Truck</td>
                            <td><span class="tag">28 FT - XXL   28M * 12M * 17M</span></td>
                            <td>50000</td>
                        </tr>
                        <tr>
                            <td>New Town Bus Stand</td>
                            <td>Gate 2</td>
                            <td>Mini Truck</td>
                            <td><span class="tag">28 FT - XXL   28M * 12M * 17M</span></td>
                            <td>30000</td>
                        </tr>
                    </tbody>
                </table>
            </div>
          </div>
        </div>
    </div>
</div>




@endsection

@section('js')

<script>

    var CONTACTS = "{{ route('contact.' . $cotype->slug . '.index') }}";
    var CONTACTPERSON_WRAPPER = "{{ route('contact.' . $cotype->slug . '.contactpersonwrapper') }}";
    var ATTACHMENT_WRAPPER    = "{{ route('contact.attachmentwrapper') }}";
    
    var DELETE_LOCATION_URL = "{{ route('contact.customer.location.delete') }}";
    var FILTER_LOCATION_URL = "{{ route('contact.' . $cotype->slug . '.filter.locations', ':id') }}";
    
    var ACTIVITY_NOTE_URL = "{{ route('contact.activitynotes.save') }}";
    var DELETE_CONTRACT_URL = "{{ route('contact.customer.contract.delete') }}";
    
    var CONTRACT_ROUTES = "{{ route('contact.customer.contract.routes', ':id') }}";
    
    var VEHICLETYPE_SIZES = "{{ route('vehicletype.sizes', ':id') }}";
    
    var FETCH_MIDPOINTS_URL = "{{ route('contact.customer.get.location.midpoints', ':id') }}";
    
    var LABOUR_CHARGE_URL = "{{ route('contact.customer.contract.pricing.labour.charges', ':id') }}";
    var VEHICLE_DETAIL_URL = "{{ route('contact.customer.contract.pricing.vehicles', ':id') }}";
    var PRICING_HISTORY_URL = "{{ route('contact.customer.contract.pricing.history', ':id') }}";

    
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

<script type="text/javascript" src="{{ asset('customjs/contact/' . $cotype->slug . '/edit.js') }}"></script>

<script type="text/javascript" src="{{ asset('customjs/contact/activity.js') }}"></script>


@endsection



