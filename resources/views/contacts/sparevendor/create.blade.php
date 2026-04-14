@extends('layouts.app')

@section('css')

<link rel="stylesheet" href="{{ asset('css/Contacts/SpareVendor/create.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css" />


@endsection

@section('content')

<div class="layout-wrapper">
    @include('includes.header')

    <form class="wrapper srlog-bdwrapper" action="{{ route('contact.sparevendor.save') }}" id="addContactForm">
        @csrf

        <div class="itemtop-secwrap">
            <div class="container-fluid">
                <div class="item1-cbdhed">
                    <h5 class="d-inline-block">Add Spare Part Vendor</h5>
                    <div class="row align-items-end">
                        <div class="col-12 text-end item_016btn">
                            <a href="javascript:void(0)" class="btn btn-dark me-2" id="addContactBtn">Save</a>
                            <a href="{{ route('contact.sparevendor.index') }}" class="btn btn-danger me-2">Close</a>
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

                            {{-- ABOUT --}}
                            <div class="form-bg">
                                <div class="row">
                                    <div class="col-12 col-md-6"><h6>About</h6></div>
                                    <div class="col-12 col-md-6 text-end">
                                        <i data-bs-toggle="collapse" href="#collapse01" aria-expanded="true" aria-controls="collapse01" class="uil uil-angle-down"></i>
                                    </div>
                                </div>

                                <div class="collapse show" id="collapse01">
                                    <div class="contact-wrap">

                                        <div class="row form-group">
                                            <div class="col-12 col-md-5">
                                                <label>Spare Part Vendor Name <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <input type="text" name="contact_name" class="form-control" />
                                                <small class="error text-danger" id="add_contact_name_error"></small>
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-12 col-md-5">
                                                <label>Company Name <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <input type="text" name="company_name" class="form-control" />
                                                <small class="error text-danger" id="add_company_name_error"></small>
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-12 col-md-5">
                                                <label>Phone Number <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <div class="row">
                                                    <input type="hidden" name="phone_code" class="phone_code">
                                                    <div class="col-12 col-md-12">
                                                        <input type="text" name="phone" class="form-control telinput" />
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
                                                        <input type="text" name="whatsapp" class="form-control telinput" />
                                                        <small class="error text-danger" id="add_whatsapp_error"></small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-12 col-md-5">
                                                <label>Spare Part Vendor Code <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <input type="text" name="contact_code" class="form-control" />
                                                <small class="error text-danger" id="add_contact_code_error"></small>
                                            </div>
                                        </div>

                                        {{-- Specialisation chips --}}
                                        <div class="row form-group">
                                            <div class="col-12 col-md-5">
                                                <label>Specialisation</label>
                                                <small class="text-muted d-block" style="font-size:11px;">Optional — select one or more</small>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <div class="spec-check-group">
                                                    @forelse($spareCategories as $cat)
                                                    <label class="spec-chip">
                                                        <input type="checkbox" name="specialisation[]" value="{{ $cat->id }}">{{ $cat->name }}
                                                    </label>
                                                    @empty
                                                    <span class="text-muted" style="font-size:12px;">No categories found. Add categories under <strong>Workshop &rarr; Master &rarr; Spare Part Categories</strong>.</span>
                                                    @endforelse
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-12 col-md-5">
                                                <label>Status</label>
                                            </div>
                                            <div class="col-12 col-md-7 d-flex flex-wrap status-wrap">
                                                <div class="form-check me-2 active">
                                                    <input class="form-check-input contact-status" type="radio" name="status" id="status_active" value="Active" checked>
                                                    <label class="form-check-label" for="status_active">Active</label>
                                                </div>
                                                <div class="form-check mx-1 inactive">
                                                    <input class="form-check-input contact-status" type="radio" name="status" id="status_inactive" value="Inactive">
                                                    <label class="form-check-label" for="status_inactive">Inactive</label>
                                                </div>
                                            </div>
                                            <small class="error text-danger" id="add_status_error"></small>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-12 col-md-5">
                                                <label>Comment</label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <textarea class="form-control" name="contact_comment" rows="3" placeholder=""></textarea>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>{{-- /About --}}


                            {{-- CONTACT PERSONS --}}
                            <div class="form-bg">
                                <div class="row">
                                    <div class="col-12 col-md-9"><h6>Contact Persons</h6></div>
                                    <div class="col-12 col-md-3 text-end">
                                        <i data-bs-toggle="collapse" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo" class="uil uil-angle-down"></i>
                                    </div>
                                </div>

                                <div class="collapse show" id="collapseTwo">
                                    <div class="contact-wrap">
                                        <div id="contactPersonContainer">

                                            <div class="contact-person" data-index="0">
                                                <div class="row form-group">
                                                    <div class="col-12 col-md-5">
                                                        <label>Name <span class="text-danger">*</span></label>
                                                    </div>
                                                    <div class="col-12 col-md-7">
                                                        <input type="text" name="contact_person_name[]" class="form-control" />
                                                        <small class="error text-danger" id="add_contact_person_name_0_error"></small>
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-12 col-md-5">
                                                        <label>Designation</label>
                                                    </div>
                                                    <div class="col-12 col-md-7">
                                                        <input type="text" name="contact_person_designation[]" class="form-control" />
                                                        <small class="error text-danger" id="add_contact_person_designation_0_error"></small>
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
                                                                <input type="text" class="form-control telinput" name="contact_person_phone[]" />
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
                                                                <input type="text" class="form-control telinput" name="contact_person_whatsapp[]" />
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
                                                                <small class="error text-danger" id="add_contact_person_email_0_error"></small>
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
                                            </div>{{-- /first contact person --}}

                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <a href="javascript:void(0)" class="btn btn-theme add-person"><i class="uil uil-plus me-1"></i>Contact</a>
                                    </div>
                                </div>
                            </div>{{-- /Contact Persons --}}


                            {{-- COMPANY & TAX --}}
                            <div class="form-bg">
                                <div class="row">
                                    <div class="col-12 col-md-9"><h6>Company & Tax Details</h6></div>
                                    <div class="col-12 col-md-3 text-end">
                                        <i data-bs-toggle="collapse" href="#collapse03" aria-expanded="true" aria-controls="collapse03" class="uil uil-angle-down"></i>
                                    </div>
                                </div>
                                <div class="collapse show" id="collapse03">

                                    <div class="row form-group">
                                        <div class="col-12 col-md-5"><label>Full Company Name</label></div>
                                        <div class="col-12 col-md-7">
                                            <input type="text" name="full_company_name" class="form-control" />
                                            <small class="error text-danger" id="add_full_company_name_error"></small>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-12 col-md-5"><label>Company Owner</label></div>
                                        <div class="col-12 col-md-7">
                                            <input type="text" name="company_owner" class="form-control">
                                            <small class="error text-danger" id="add_company_owner_error"></small>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-12 col-md-5"><label>Registration Number</label></div>
                                        <div class="col-12 col-md-7">
                                            <input type="text" name="company_registration_no" class="form-control">
                                            <small class="error text-danger" id="add_company_registration_no_error"></small>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-12 col-md-5"><label>Registration Date</label></div>
                                        <div class="col-12 col-md-7">
                                            <input name="company_registration_date" class="form-control bg-light text-uppercase general_date" type="date">
                                            <small class="error text-danger" id="add_company_registration_date_error"></small>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-12 col-md-5">
                                            <label>Working with {{ optional(Auth::user()->organisation)->short_name }} Since</label>
                                        </div>
                                        <div class="col-12 col-md-7">
                                            <input name="working_since" class="form-control bg-light text-uppercase general_date" type="date">
                                            <small class="error text-danger" id="add_working_since_error"></small>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-12 col-md-5"><label>PAN</label></div>
                                        <div class="col-12 col-md-7">
                                            <input name="pan_no" type="text" class="form-control">
                                            <small class="error text-danger" id="add_pan_no_error"></small>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-12 col-md-5"><label>PAN Status</label></div>
                                        <div class="col-12 col-md-7">
                                            <select name="pan_status_id" class="form-select select2">
                                                <option value="">Choose..</option>
                                                @foreach($pan_statuses as $status)
                                                    <option value="{{ $status->id }}">{{ $status->name }}</option>
                                                @endforeach
                                            </select>
                                            <small class="error text-danger" id="add_pan_status_id_error"></small>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-12 col-md-5"><label>GST Treatment</label></div>
                                        <div class="col-12 col-md-7 d-flex">
                                            <div class="form-check me-2">
                                                <input class="form-check-input" type="radio" name="gst_treatment" id="gst_reg" value="Registered">
                                                <label class="form-check-label" for="gst_reg">Registered</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="gst_treatment" id="gst_unreg" value="Unregistered">
                                                <label class="form-check-label" for="gst_unreg">Unregistered</label>
                                            </div>
                                        </div>
                                        <small class="error text-danger" id="add_gst_treatment_error"></small>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-12 col-md-5"><label>GSTIN</label></div>
                                        <div class="col-12 col-md-7">
                                            <input type="text" name="gst_number" class="form-control">
                                            <small class="error text-danger" id="add_gst_number_error"></small>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-12 col-md-5"><label>TDS %</label></div>
                                        <div class="col-12 col-md-7">
                                            <input type="number" name="tds_percentage" class="form-control" min="0" max="100" step="0.01">
                                            <small class="error text-danger" id="add_tds_percentage_error"></small>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-12 col-md-5"><label>State <span class="text-danger">*</span></label></div>
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

                                    <div class="row form-group">
                                        <div class="col-12 col-md-5"><label>City <span class="text-danger">*</span></label></div>
                                        <div class="col-12 col-md-7">
                                            <select class="form-select select2" name="city_id" id="gstCity">
                                                <option value="">Choose..</option>
                                            </select>
                                            <small class="error text-danger" id="add_city_id_error"></small>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-12 col-md-5"><label>Address <span class="text-danger">*</span></label></div>
                                        <div class="col-12 col-md-7">
                                            <textarea name="address" class="form-control" rows="3" placeholder=""></textarea>
                                            <small class="error text-danger" id="add_address_error"></small>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-12 col-md-5"><label>Postal Code</label></div>
                                        <div class="col-12 col-md-7">
                                            <input type="text" name="post_code" class="form-control">
                                            <small class="error text-danger" id="add_post_code_error"></small>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-12 col-md-5"><label>Additional Info</label></div>
                                        <div class="col-12 col-md-7">
                                            <textarea name="additional_info" class="form-control" rows="3" placeholder=""></textarea>
                                            <small class="error text-danger" id="add_additional_info_error"></small>
                                        </div>
                                    </div>

                                </div>
                            </div>{{-- /Company & Tax --}}


                            {{-- BANK DETAILS --}}
                            <div class="form-bg">
                                <div class="row">
                                    <div class="col-12 col-md-9"><h6>Bank Details</h6></div>
                                    <div class="col-12 col-md-3 text-end">
                                        <i data-bs-toggle="collapse" href="#collapse05" aria-expanded="true" aria-controls="collapse05" class="uil uil-angle-down"></i>
                                    </div>
                                </div>

                                <div class="collapse show" id="collapse05">
                                    <div class="bank-details-wrap">
                                        <div id="bankDetailsContainer">

                                            <div class="row form-group">
                                                <div class="col-12 col-md-5">
                                                    <label>Is Primary ? <span class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-12 col-md-7 d-flex">
                                                    <div class="form-check">
                                                        <input class="form-check-input bank-status" type="radio" name="is_primary[]" id="is_primary_yes" value="Yes" />
                                                        <label class="form-check-label" for="is_primary_yes">Yes</label>
                                                    </div>
                                                    <div class="form-check mx-2">
                                                        <input class="form-check-input bank-status" type="radio" name="is_primary[]" id="is_primary_no" value="No" />
                                                        <label class="form-check-label" for="is_primary_no">No</label>
                                                    </div>
                                                </div>
                                                <small class="error text-danger" id="add_is_primary_error"></small>
                                                <small class="error text-danger" id="add_is_primary_0_error"></small>
                                            </div>

                                            <div class="row form-group">
                                                <div class="col-12 col-md-5"><label>Bank Name <span class="text-danger">*</span></label></div>
                                                <div class="col-12 col-md-7">
                                                    <select name="bank_id[]" class="form-select select2">
                                                        <option value="">Choose..</option>
                                                        @foreach ($banks as $bank)
                                                        <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <small class="error text-danger" id="add_bank_id_0_error"></small>
                                                </div>
                                            </div>

                                            <div class="row form-group">
                                                <div class="col-12 col-md-5"><label>Beneficiary Name</label></div>
                                                <div class="col-12 col-md-7">
                                                    <input type="text" name="beneficiary_name[]" class="form-control" />
                                                    <small class="error text-danger" id="add_beneficiary_name_0_error"></small>
                                                </div>
                                            </div>

                                            <div class="row form-group">
                                                <div class="col-12 col-md-5"><label>Account Number <span class="text-danger">*</span></label></div>
                                                <div class="col-12 col-md-7">
                                                    <input type="text" name="account_number[]" class="form-control" />
                                                    <small class="error text-danger" id="add_account_number_0_error"></small>
                                                </div>
                                            </div>

                                            <div class="row form-group">
                                                <div class="col-12 col-md-5"><label>IFSC Code <span class="text-danger">*</span></label></div>
                                                <div class="col-12 col-md-7">
                                                    <input type="text" name="ifsc_code[]" class="form-control" />
                                                    <small class="error text-danger" id="add_ifsc_code_0_error"></small>
                                                </div>
                                            </div>

                                            <div class="row form-group">
                                                <div class="col-12 col-md-5"><label>UPI ID</label></div>
                                                <div class="col-12 col-md-7">
                                                    <input type="text" name="upi_id[]" class="form-control" />
                                                    <small class="error text-danger" id="add_upi_id_0_error"></small>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <a href="javascript:void(0)" class="btn btn-theme add-bank"><i class="uil uil-plus me-1"></i>Bank</a>
                                    </div>
                                </div>
                            </div>{{-- /Bank Details --}}

                        </div>
                    </div>{{-- /left col --}}


                    {{-- RIGHT COL: Tabs --}}
                    <div class="col-12 col-md-8 mt-4">
                        <div class="right-side-wrap">
                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#document" type="button" role="tab">
                                        Document
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link disabled" data-bs-toggle="tab" data-bs-target="#spareparts" type="button" role="tab">
                                        Spare Parts
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link disabled" data-bs-toggle="tab" data-bs-target="#activity" type="button" role="tab">
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
                                                    @if($coattachtypes->count())
                                                        @foreach($coattachtypes as $type)
                                                           <option value="{{ $type->id }}">{{ $type->name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                <small class="error text-danger atyperr" id="add_coattachtype_0_error"></small>
                                            </div>
                                        </div>
                                        <hr>
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
                                </div>

                            </div>
                        </div>
                    </div>{{-- /right col --}}

                </div>
            </div>

        </div>{{-- /item2-cbdwrap --}}

    </form>

</div>{{-- /layout-wrapper --}}

@endsection

@section('js')

<script>
    var CONTACTS              = "{{ route('contact.sparevendor.index') }}";
    var CONTACTPERSON_WRAPPER = "{{ route('contact.sparevendor.contactpersonwrapper') }}";
    var BANK_WRAPPER          = "{{ route('contact.sparevendor.bankwrapper') }}";
    var ATTACHMENT_WRAPPER    = "{{ route('contact.attachmentwrapper') }}";

    window.UPLOAD_URL = "{{ route('contact.upload.images') }}";

</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>

<script type="text/javascript" src="{{ asset('customjs/contact/sparevendor/create.js') }}"></script>

@endsection
