@extends('layouts.app')

@section('css')

<link rel="stylesheet" href="{{ asset('css/Contacts/Customer/create.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css" />


@endsection

@section('content')

<div class="layout-wrapper">
    @include('includes.header')
    
    <form class="wrapper srlog-bdwrapper" action="{{route('contact.'.str($cotype->slug)->lower().'.save')}}" id="addContactForm">   
        @csrf

        <div class="itemtop-secwrap">
            <div class="container-fluid">
                <div class="item1-cbdhed">
                    <h5>Add Customer</h5>
                    <!--<h6 class="d-block">We will be fetching details from GST Number</h6>-->

                    <div class="row align-items-end">

                        <div class="col-12 col-md-4">
                            <div class="gst-wrapper">
                                <label>GST Number <span class="text-danger">*</span></label>
                                <div class="row align-items-center">
                                    <div class="col-11 pe-0">                       
                                        <div class="gst-inputbd" id="gstForm">
                                            <input type="text" name="gst_number" placeholder="27AAACT2727Q1ZW" class="gstinput form-control" 
                                            id="gstNumber" />
                                            <small class="error text-danger" id="add_gst_number_error"></small>
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
                                              <input type="text" name="contact_name" id="gstName" class="form-control"/>
                                              <small class="error text-danger" id="add_contact_name_error"></small>
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
                                                        {{ request('about_type_id') == $value->id ? 'selected' : '' }}>
                                                        {{ $value->name }}
                                                    </option>
                                                    @empty
                                                        <option value="" disabled>No types available!</option>
                                                    @endforelse
                                              </select> 
                                              <small class="error text-danger" id="add_about_type_id_error"></small>
                                            </div>
                                          </div>
                                          
                                          <div class="row form-group">

                                            <div class="col-12 col-md-5">
                                                <label>Size</label>
                                            </div>

                                            <div class="col-12 col-md-7 d-flex">

                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="size" id="exampleRadios1" value="Large" />
                                                    <label class="form-check-label" for="exampleRadios1">
                                                        Large
                                                    </label>
                                                </div>

                                                <div class="form-check mx-2">
                                                    <input class="form-check-input" type="radio" name="size" id="exampleRadios2" value="Medium" />
                                                    <label class="form-check-label" for="exampleRadios2">
                                                        Medium
                                                    </label>
                                                </div>

                                                <div class="form-check m">
                                                    <input class="form-check-input" type="radio" name="size" id="exampleRadios3" value="Small" />
                                                    <label class="form-check-label" for="exampleRadios3">
                                                        Small
                                                    </label>
                                                </div>
                                                
                                            </div>
                                            <small class="error text-danger" id="add_size_error"></small>
                                        </div>
                                        
                                        <div class="row form-group">
                                            <div class="col-12 col-md-5">
                                                <label>Phone <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <div class="row">
                                                    <input type="hidden" name="phone_code" class="phone_code"> 
                                                    <div class="col-12 col-md-12">
                                                        <input type="text" name="phone" class="form-control telinput "/>
                                                        <small class="error text-danger" id="add_phone_error"></small>
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
                                                        <input type="text" name="whatsapp" class="form-control telinput " name="whatsapp" />
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

                                          <!-- Address Line 1 -->
                                          <div class="row form-group mb-3">
                                            <div class="col-12 col-md-5">
                                              <label>Address</label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                              <textarea name="address" class="form-control" rows="2" id="gstAddr1"></textarea>
                                              <small class="error text-danger" id="add_address_error"></small>
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
                                                        {{ old('state_id') == $state->id ? 'selected' : '' }}>
                                                        {{ $state->name }}
                                                    </option>
                                                @endforeach
                                              </select>
                                              <small class="error text-danger" id="add_state_id_error"></small>
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
                                              </select>
                                              <small class="error text-danger" id="add_city_id_error"></small>
                                            </div>
                                          </div>

                                          

                                          <!-- Postal Code -->
                                          <div class="row form-group mb-3">
                                            <div class="col-12 col-md-5">
                                              <label>Postal Code</label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                              <input type="text" class="form-control numericonly" name="post_code" id="gstPin" />
                                              <small class="error text-danger" id="add_post_code_error"></small>
                                            </div>
                                          </div>
                                        
                                        <div class="row form-group">
                                            <div class="col-12 col-md-5">
                                                <label>Head Office Map Location</label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <input type="text" class="form-control" name="head_office_map_location" />
                                            </div>
                                        </div>
                                        
                                        
                                        <div class="form-group row">
                                            <div class="col-12 col-md-5">
                                                <label>Halting Charge?</label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <input type="hidden" name="is_deduction_chargeable" value="0">
                                                <input type="checkbox" name="is_deduction_chargeable" value="1" class="form-check-input charge-checked">
                                            </div>
                                        </div>
                                        
                                        <div class="if-checked form-group">
                                            <div class="row">
                                                <div class="col-12 col-md-5">
                                                    <label>Halting Charges/Day<span class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-12 col-md-7">
                                                    <div class="input-group mb-1">
                                                        <span class="input-group-text bg-light text-dark">₹</span>
                                                        <input type="text" name="halting_charges_per_day" value="{{ old('halting_charges_per_day' ?? '') }}" class="form-control decimalonly" style="min-height: 30px !important; height: 20px;">
                                                        
                                                    </div>
                                                    <small class="error text-danger" id="add_halting_charges_per_day_error"></small>
                                                </div>
                                            </div>
                                        </div>
                                          
                                        

                                        <div class="row form-group">
                                            <div class="col-12 col-md-5">
                                                <label>Comment About Contact</label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <textarea class="form-control" name="contact_comment" id="contactComment" rows="3" placeholder="">{{ old('contact_comment' ?? '') }}</textarea>
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
                                            <div class="row form-group">
                                                <div class="col-12 col-md-5">
                                                    <label>Name <span class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-12 col-md-7">
                                                    <input type="text" name="contact_person_name[0]" class="form-control" />
                                                    <small class="error text-danger" id="add_contact_person_name_0_error"></small>
                                                </div>
                                            </div>
                                            
                                            <div class="row form-group">
                                                <div class="col-12 col-md-5">
                                                    <label>Position <!--<span class="text-danger">*</span>--></label>
                                                </div>
                                                <div class="col-12 col-md-7">
                                                    <input type="text" name="contact_person_designation[]" class="form-control" />
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
                                                            <input type="text" class="form-control telinput" name="contact_person_phone[0]" />
                                                            <small class="error text-danger" id="add_contact_person_phone_0_error"></small>
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
                                                            <input type="text" class="form-control telinput" name="contact_person_whatsapp[0]" />
                                                            <small class="error text-danger" id="add_contact_person_whatsapp_0_error"></small>
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
                                                            <input type="text" class="form-control" name="contact_person_email[]" />
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
                                                    <textarea name="contact_person_comment[]" class="form-control" rows="3" placeholder=""></textarea>
                                                </div>
                                            </div>
    
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
                                        <h6>Billing Address</h6>
                                        <div class="form-check mb-3">
                                            <input class="form-check-input same-as-GST-address" type="checkbox" value="" id="flexCheckDefault" />
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
                                            <textarea class="form-control" name="billing_address" id="billingAddress"  rows="3" placeholder=""></textarea>
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
                                                        {{ old('state_id') == $state->id ? 'selected' : '' }}>
                                                        {{ $state->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="row form-group">
                                        <div class="col-12 col-md-5">
                                            <label>City </label>
                                        </div>
                                        <div class="col-12 col-md-7">
                                            <select class="form-select select2" name="billing_city_id" id="billingCity">
                                                <option value="">Choose..</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-12 col-md-5">
                                            <label>Postal Code </label>
                                        </div>
                                        <div class="col-12 col-md-7">
                                            <input type="text" class="form-control numericonly" name="billing_postalcode" id="billingPostalCode">
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-12 col-md-5">
                                            <label>Additional Info</label>
                                        </div>
                                        <div class="col-12 col-md-7">
                                            <textarea type="textarea" class="form-control" name="billing_additionalinfo" id="billingAdditionalInfo" rows="3" placeholder="Additional Info"></textarea>
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
                                    <button class="nav-link disabled" data-bs-toggle="tab" data-bs-target="#contract" type="button" role="tab">
                                        Contract 
                                    </button>
                                </li> 
                                
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#document" type="button" role="tab">
                                        Document
                                    </button>
                                </li>

                                <li class="nav-item" role="presentation">
                                    <button class="nav-link disabled" data-bs-toggle="tab" data-bs-target="#locations" type="button" role="tab">
                                        Locations
                                    </button>
                                </li>
                                
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link disabled" data-bs-toggle="tab" data-bs-target="#contract-ricing" type="button" role="tab">
                                        Rate Chart
                                    </button>
                                </li>
                                
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link disabled" data-bs-toggle="tab" data-bs-target="#activity" type="button" role="tab">
                                        Activity
                                    </button>
                                </li>
                                
                            </ul>

                            <div class="tab-content" id="pills-tabContent">
                                
                                
                                <div class="tab-pane fade " id="contract" role="tabpanel">
                                    <div class="documentdtl-bd">


                                        <div class="row form-group">

                                            <div class="col-12 col-md-3">
                                                <label>Contract Copy </label>
                                            </div>

                                            <div class="col-12 col-md-5">
                                                <label for="formFile" class="form-label">Upload File</label>
                                                <input class="form-control bg-light text-black" type="file" id="formFile">
                                            </div>

                                        </div>
                                        
                                        <div class="row form-group">

                                            <div class="col-12 col-md-3">
                                                <label>Payment Within Day</label>
                                            </div>

                                            <div class="col-12 col-md-5">
                                                <input class="form-control" type="number">
                                            </div>

                                        </div>
                                        

                                        <div class="row form-group">

                                            <div class="col-12 col-md-3">
                                                <label>Contract Expiry</label>
                                            </div>

                                            <div class="col-12 col-md-5">
                                                <input class="form-control bg-light text-uppercase" 
                                                type="date" placeholder="DD/MM/YY">

                                            </div>

                                        </div>

                                        
                                       
                                        <div class="row form-group">
                                            <div class="col-12 col-md-3">
                                                <div class="d-flex">

                                                    <label>Set Reminder </label>

                                                    <div class="sec-tooltip">
                                                    <i class="uil uil-info-circle"></i>
                                                    <p>Check this box to receive a reminder.</p>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="col-12 col-md-5">
                                                <div class="form-check mb-3">
                                                    <input class="form-check-input clickto-adclass" type="checkbox" id="setReminder">                                                     
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Hidden by default -->
                                        <div class="days-beforeexpiry" style="display: none;">
                                            <div class="row form-group">
                                                <div class="col-12 col-md-3">
                                                    <label>Days Before Expiry <span class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-12 col-md-5">
                                                    <input class="form-control" type="number">
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    
                                    
                                    
                                    <div class="row mb-2 align-items-center">

                                        <div class="col-12 col-md-12 text-end">
                                            <a href="add-contract.php" class="btn btn-theme"><i class="uil uil-plus me-1"></i> Contract</a>
                                        </div>
                                    </div>
                                    
                                    
                                    <table class="table">
                                        <thead>
                                            <tr>
                                            <th>Contract Number </th>
                                            <th>Contract Type</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Payment Base</th>
                                            </tr>
                                        </thead>
                                       
                                      <tbody>
                                          
                                        <tr>
                                            <td>895465</td>
                                            <td>Yearly</td>
                                            <td>04-05-2025</td>
                                            <td>01-06-2025</td>
                                            <td>UPI</td>
                                        </tr>
                                        
                                        <tr>
                                            <td>890665</td>
                                            <td>Yearly</td>
                                            <td>02-05-2025</td>
                                            <td>03-06-2025</td>
                                            <td>Cash</td>
                                        </tr>
                                        
                                        <tr>
                                            <td>894565</td>
                                            <td>Yearly</td>
                                            <td>02-06-2025</td>
                                            <td>03-06-2025</td>
                                            <td>Cheque</td>
                                        </tr>
                                        
                                        <tr>
                                            <td>895465</td>
                                            <td>Yearly</td>
                                            <td>04-06-2025</td>
                                            <td>01-06-2025</td>
                                            <td>UPI</td>
                                        </tr>
                                        
                                       
                                      </tbody>  
                                       
                                 </table>
                                 
                                    <div class="no-data">
                                        <p class="text-dark mb-0">No Data Found</p>
                                    </div>
                                    
                                </div>
                                
                                
                                <div class="tab-pane fade show active" id="document" role="tabpanel">
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
                                
                                

                                <div class="tab-pane fade" id="locations" role="tabpanel">

                                    <div class="row mb-3 align-items-center">
                                        <div class="col-12 col-md-12">
                                            <!--<h5 class="d-inline-block">Location</h5>-->
                                            <a href="javascript:void(0)" class="btn btn-theme" data-bs-toggle="modal" data-bs-target="#addLocation"><i class="uil uil-plus me-1"></i>Location</a>
                                            <div class="form-group d-inline-block mb-0 ms-2" style="width: 250px;">
                                                <select class="form-select select2">
                                                    <option>Filter by Location Type</option>
                                                    <option>Loading Points</option>
                                                    <option>Unloading Points</option>
                                                    <option>Loading & Unloading Points</option>
                                                </select>
                                            </div>
                                            <button class="btn btn-primary reset-btn ms-2"><i class="uil uil-history me-1"></i>Reset</button>
                                        </div>
                                    </div>
                                    
                                    <div class="accordion" id="locationCollapse">
                                      <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingOne">
                                          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            <h6 class="text-dark mb-0 d-flex align-items-center justify-content-between w-100"><div><span style="font-size: 15px;">Location Name: Webel Gate</span> <span class="badge badge-success ms-2">Loading Point</span></div>
                                            <div class="d-flex align-items-center me-3">
                                                <a href="javascript:void(0)" class="btn btn-success me-3"><i class="uil uil-whatsapp me-2"></i>Share</a>
                                                <a href="javascript:void(0)" class="text-danger"><i class="uil uil-trash-alt me-2"></i></a>
                                            </div>
                                            </h6>
                                          </button>
                                        </h2>
                                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#locationCollapse">
                                          <div class="accordion-body">
                                                <div class="item-rowsec">
                                                    <div class="row form-group mb-0">
                                                        <div class="col-12 col-lg-5">
                                                            <div class="row form-group">
                                                                <div class="col-12 col-lg-5 col-md-3">
                                                                    <label>Address:</label>
                                                                </div>

                                                               <div class="col-12 col-lg-7 col-md-9">
                                                                    <p>13th Floor, Arch Square X2,</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row form-group mb-0">
                                                        <div class="col-12 col-lg-5">

                                                            <div class="row form-group ">
                                                                <div class="col-12 col-lg-5 col-md-3">
                                                                    <label>City:</label>
                                                                </div>

                                                               <div class="col-12 col-lg-7 col-md-9">
                                                                    <p>Kolkata</p>
                                                                </div>
                                                            </div>

                                                        </div>

                                                        <div class="col-12 col-lg-5">

                                                            <div class="row form-group">
                                                                <div class="col-12 col-lg-5 col-md-3">
                                                                    <label>State:</label>
                                                                </div>

                                                                <div class="col-12 col-lg-7 col-md-9">
                                                                    <p>West Bengal</p>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row form-group mb-0">
                                                        <div class="col-12 col-lg-5">
                                                            <div class="row form-group">
                                                                <div class="col-12 col-lg-5 col-md-3">
                                                                    <label>Postal Code:</label>
                                                                </div>

                                                                <div class="col-12 col-lg-7 col-md-9">
                                                                    <p>700025</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-12 col-lg-5">
                                                            <div class="row form-group">
                                                                <div class="col-12 col-lg-5 col-md-3">
                                                                    <label>Brone By:</label>
                                                                </div>

                                                                <div class="col-12 col-lg-7 col-md-9">
                                                                    <p>SRL</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row form-group mb-0">
                                                        <div class="col-12 col-lg-5">
                                                            <div class="row form-group">
                                                                <div class="col-12 col-lg-5 col-md-3">
                                                                    <label>Average Loading Time:</label>
                                                                </div>

                                                                <div class="col-12 col-lg-7 col-md-9">
                                                                    <p>2  Hrs 30 Mins</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-12 col-lg-5">
                                                            <div class="row form-group">
                                                                <div class="col-12 col-lg-5 col-md-3">
                                                                    <label>Loading Charge:</label>
                                                                </div>

                                                                <div class="col-12 col-lg-7 col-md-9">
                                                                    <p>₹ 500.00</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row form-group">
                                                        <div class="col-12 col-md-2">
                                                            <label>Onsite Contact Person:</label>
                                                        </div>

                                                        <div class="col-12 col-md-2">
                                                            <p>Nikhil Sharma</p>
                                                        </div>
                                                        
                                                        <div class="col-12 col-md-2">
                                                            <label>Onsite Contact Number:</label>
                                                        </div>

                                                        <div class="col-12 col-md-2">
                                                            <p>+91 9876543210</p>
                                                        </div>
                                                        <div class="col-12 col-md-2">
                                                            <label>Onsite WhatsApp Number:</label>
                                                        </div>

                                                        <div class="col-12 col-md-2">
                                                            <p>+91 9879087210</p>
                                                        </div>
                                                    </div>
                                                
                                                    <div class="row form-group">
                                                        <div class="col-12 col-lg-2 col-md-3">
                                                            <label>Additional Info:</label>
                                                        </div>

                                                        <div class="col-12 col-lg-10 col-md-9">
                                                            <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration.</p>
                                                        </div>
                                                    </div>
                                                
                                                    <div class="row form-group">
                                                        <div class="col-12 col-lg-2 col-md-3">
                                                            <label>Embeded Map:</label>
                                                        </div>

                                                        <div class="col-12 col-lg-10 col-md-9">
                                                            <a href="#" style="font-size: 12px; line-height: 20px;">
                                                                https://www.google.com/maps?client=firefox-b-d&sca_esv=7550878c098e0420&output=search&q=...
                                                            </a>
                                                        </div>
                                                    </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingTwo">
                                          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            <h6 class="text-dark mb-0 d-flex align-items-center justify-content-between w-100"><div>Location Name:  DLF 1 <span class="badge badge-success ms-2">Unloading Point</span></div>
                                            <div class="d-flex align-items-center me-3">
                                                <a href="javascript:void(0)" class="btn btn-success me-3"><i class="uil uil-whatsapp me-2"></i>Share</a>
                                                <a href="javascript:void(0)" class="text-danger"><i class="uil uil-trash-alt me-2"></i></a>
                                            </div>
                                            </h6>
                                          </button>
                                        </h2>
                                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#locationCollapse">
                                          <div class="accordion-body">
                                                <div class="item-rowsec">
                                                    <div class="row form-group mb-0">
                                                        <div class="col-12 col-lg-6">
                                                            <div class="row form-group">
                                                                <div class="col-12 col-lg-5 col-md-3">
                                                                    <label>Address:</label>
                                                                </div>

                                                               <div class="col-12 col-lg-7 col-md-9">
                                                                    <p>13th Floor, Arch Square X2,</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row form-group mb-0">
                                                        <div class="col-12 col-lg-6">

                                                            <div class="row form-group ">
                                                                <div class="col-12 col-lg-5 col-md-3">
                                                                    <label>City:</label>
                                                                </div>

                                                               <div class="col-12 col-lg-7 col-md-9">
                                                                    <p>Kolkata</p>
                                                                </div>
                                                            </div>

                                                        </div>

                                                        <div class="col-12 col-lg-6">

                                                            <div class="row form-group">
                                                                <div class="col-12 col-lg-5 col-md-3">
                                                                    <label>State:</label>
                                                                </div>

                                                                <div class="col-12 col-lg-7 col-md-9">
                                                                    <p>West Bengal</p>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row form-group mb-0">
                                                        <div class="col-12 col-lg-6">
                                                            <div class="row form-group">
                                                                <div class="col-12 col-lg-5 col-md-3">
                                                                    <label>Postal Code:</label>
                                                                </div>

                                                                <div class="col-12 col-lg-7 col-md-9">
                                                                    <p>700025</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-12 col-lg-6">
                                                            <div class="row form-group">
                                                                <div class="col-12 col-lg-5 col-md-3">
                                                                    <label>Brone By:</label>
                                                                </div>

                                                                <div class="col-12 col-lg-7 col-md-9">
                                                                    <p>SRL</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row form-group">
                                                        <div class="col-12 col-md-3">
                                                            <label>Average Unloading Time:</label>
                                                        </div>
                                                        <div class="col-12 col-md-3">
                                                            <label>2  Hrs 30 Mins</label>
                                                        </div>
                                                        <div class="col-12 col-md-3">
                                                            <label>Unloading Charge:</label>
                                                        </div>
                                                        <div class="col-12 col-md-3">
                                                            <label>₹ 500.00</label>
                                                        </div>
                                                        
                                                    </div>
                                                    
                                                    <div class="row form-group">
                                                        <div class="col-12 col-md-2">
                                                            <label>Onsite Contact Person:</label>
                                                        </div>

                                                        <div class="col-12 col-md-2">
                                                            <p>Nikhil Sharma</p>
                                                        </div>
                                                        
                                                        <div class="col-12 col-md-2">
                                                            <label>Onsite Contact Number:</label>
                                                        </div>

                                                        <div class="col-12 col-md-2">
                                                            <p>+91 9876543210</p>
                                                        </div>
                                                        
                                                        <div class="col-12 col-md-2">
                                                            <label>Onsite WhatsApp Number:</label>
                                                        </div>

                                                        <div class="col-12 col-md-2">
                                                            <p>+91 9879087210</p>
                                                        </div>
                                                    </div>
                                                
                                                    <div class="row form-group">
                                                        <div class="col-12 col-lg-2 col-md-3">
                                                            <label>Additional Info:</label>
                                                        </div>

                                                        <div class="col-12 col-lg-10 col-md-9">
                                                            <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration.</p>
                                                        </div>
                                                    </div>
                                                
                                                    <div class="row form-group">
                                                        <div class="col-12 col-lg-2 col-md-3">
                                                            <label>Embeded Map:</label>
                                                        </div>

                                                        <div class="col-12 col-lg-10 col-md-9">
                                                            <a href="#" style="font-size: 12px; line-height: 20px;">
                                                                https://www.google.com/maps?client=firefox-b-d&sca_esv=7550878c098e0420&output=search&q=...
                                                            </a>
                                                        </div>
                                                    </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingThree">
                                          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                              <h6 class="text-dark mb-0 d-flex align-items-center justify-content-between w-100"><div>Location Name: SDF <span class="badge badge-success ms-2">Loading & Unloading Point</span></div>
                                              <div class="d-flex align-items-center me-3">
                                                <a href="javascript:void(0)" class="btn btn-success me-3"><i class="uil uil-whatsapp me-2"></i>Share</a>
                                                <a href="javascript:void(0)" class="text-danger"><i class="uil uil-trash-alt me-2"></i></a>
                                              </div>
                                            </h6>
                                          </button>
                                        </h2>
                                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#locationCollapse">
                                          <div class="accordion-body">
                                                 <div class="item-rowsec">
                                                    <div class="row form-group mb-0">
                                                        <div class="col-12 col-lg-6">
                                                            <div class="row form-group">
                                                                <div class="col-12 col-lg-5 col-md-3">
                                                                    <label>Address:</label>
                                                                </div>

                                                               <div class="col-12 col-lg-7 col-md-9">
                                                                    <p>13th Floor, Arch Square X2,</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row form-group mb-0">
                                                        <div class="col-12 col-lg-6">

                                                            <div class="row form-group ">
                                                                <div class="col-12 col-lg-5 col-md-3">
                                                                    <label>City:</label>
                                                                </div>

                                                               <div class="col-12 col-lg-7 col-md-9">
                                                                    <p>Kolkata</p>
                                                                </div>
                                                            </div>

                                                        </div>

                                                        <div class="col-12 col-lg-6">

                                                            <div class="row form-group">
                                                                <div class="col-12 col-lg-5 col-md-3">
                                                                    <label>State:</label>
                                                                </div>

                                                                <div class="col-12 col-lg-7 col-md-9">
                                                                    <p>West Bengal</p>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row form-group mb-0">
                                                        <div class="col-12 col-lg-6">
                                                            <div class="row form-group">
                                                                <div class="col-12 col-lg-5 col-md-3">
                                                                    <label>Postal Code:</label>
                                                                </div>

                                                                <div class="col-12 col-lg-7 col-md-9">
                                                                    <p>700025</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-12 col-lg-6">
                                                            <div class="row form-group">
                                                                <div class="col-12 col-lg-5 col-md-3">
                                                                    <label>Brone By:</label>
                                                                </div>

                                                                <div class="col-12 col-lg-7 col-md-9">
                                                                    <p>SRL</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row form-group">
                                                        <div class="col-12 col-md-3">
                                                            <label>Average Loading Time:</label>
                                                        </div>
                                                        <div class="col-12 col-md-3">
                                                            <label>2  Hrs 30 Mins</label>
                                                        </div>
                                                        <div class="col-12 col-md-3">
                                                            <label>Loading Charge:</label>
                                                        </div>
                                                        <div class="col-12 col-md-3">
                                                            <label>₹ 500.00</label>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row form-group">
                                                        <div class="col-12 col-md-3">
                                                            <label>Average Unloading Time:</label>
                                                        </div>
                                                        <div class="col-12 col-md-3">
                                                            <label>2  Hrs 30 Mins</label>
                                                        </div>
                                                        <div class="col-12 col-md-3">
                                                            <label>Unloading Charge:</label>
                                                        </div>
                                                        <div class="col-12 col-md-3">
                                                            <label>₹ 500.00</label>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row form-group">
                                                        <div class="col-12 col-md-2">
                                                            <label>Onsite Contact Person:</label>
                                                        </div>

                                                        <div class="col-12 col-md-2">
                                                            <p>Nikhil Sharma</p>
                                                        </div>
                                                        
                                                        <div class="col-12 col-md-2">
                                                            <label>Onsite Contact Number:</label>
                                                        </div>

                                                        <div class="col-12 col-md-2">
                                                            <p>+91 9876543210</p>
                                                        </div>
                                                        
                                                        <div class="col-12 col-md-2">
                                                            <label>Onsite WhatsApp Number:</label>
                                                        </div>

                                                        <div class="col-12 col-md-2">
                                                            <p>+91 9879087210</p>
                                                        </div>
                                                    </div>
                                                
                                                    <div class="row form-group">
                                                        <div class="col-12 col-lg-2 col-md-3">
                                                            <label>Additional Info:</label>
                                                        </div>

                                                        <div class="col-12 col-lg-10 col-md-9">
                                                            <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration.</p>
                                                        </div>
                                                    </div>
                                                
                                                    <div class="row form-group">
                                                        <div class="col-12 col-lg-2 col-md-3">
                                                            <label>Embeded Map:</label>
                                                        </div>

                                                        <div class="col-12 col-lg-10 col-md-9">
                                                            <a href="#" style="font-size: 12px; line-height: 20px;">
                                                                https://www.google.com/maps?client=firefox-b-d&sca_esv=7550878c098e0420&output=search&q=...
                                                            </a>
                                                        </div>
                                                    </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
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
                                      <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingOne">
                                          <button class="accordion-button p-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            <h6 class="text-dark mb-0 d-flex align-items-center justify-content-between w-100"><div><span style="font-size: 15px;">Route: KOL-DEL</span> <span class="badge badge-success ms-2">20th JAN - 25th JAN, 2026</span></div>
                                            </h6>
                                          </button>
                                        </h2>
                                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#pricingCollapse">
                                            <div class="accordion-body">
                                                <div class="table-responsive01">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>Vehicle Size</th>
                                                                <th>Current Freight</th>
                                                                <th class="text-end">Action</th>
                                                            </tr>
                                                        </thead>
                                                   
                                                      <tbody>
                                                          
                                                        <tr>
                                                            <td>32-FT SXL</td>
                                                            <td>50,000</td>
                                                            <td class="text-end">
                                                                <a class="btn btn-primary" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#pricing_history"><i class="uil uil-history me-1"></i>History</a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>16-FT SXL</td>
                                                            <td>20,000</td>
                                                            <td class="text-end">
                                                                <a class="btn btn-primary" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#pricing_history"><i class="uil uil-history me-1"></i>History</a>
                                                            </td>
                                                        </tr>
                                                       
                                                      </tbody>  
                                                   
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                      </div>
                                    </div>
                                </div>
                                
                                <div class="tab-pane fade" id="activity" role="tabpanel">

                                    <div class="e-activitywrapper">

                                        <div class="note-wrap">
                                            <div class="form-group">
                                                <label>Note</label>
                                                <textarea class="form-control" rows="4" placeholder="Write your message here"></textarea>
                                            </div>
                                        </div>

                                        <div class="cmnt-wrap mt-4">
                                            <div class="d-flex mb-4">
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

                                    
                                </div>
                                
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </form>
            
</div>

@endsection

@section('js')

<script>

    var CONTACTS = "{{ route('contact.' . $cotype->slug . '.index') }}";
    var CONTACTPERSON_WRAPPER = "{{ route('contact.' . $cotype->slug . '.contactpersonwrapper') }}";
    var ATTACHMENT_WRAPPER    = "{{ route('contact.attachmentwrapper') }}";
    
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

<script type="text/javascript" src="{{ asset('customjs/contact/' . $cotype->slug . '/create.js') }}"></script>

@endsection





