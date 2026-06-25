@extends('layouts.app')

@section('css')
<link href="{{ asset('css/V2/tyrevendor.css?v=1.0') }}" rel="stylesheet">
@endsection

@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="cv2-wrap">
        <div class="cv2-container">

            <div class="cv2-phead">
                <div>
                    <div class="cv2-crumb"><a href="{{ route('contact.v2.tyrevendor.index') }}">Tyre Vendors</a> · New</div>
                    <h1>Add Tyre Vendor</h1>
                    <div class="cv2-sub">Create the vendor record. Documents &amp; supplied tyres open once it is saved.</div>
                </div>
                <div class="cv2-phead-actions">
                    <a href="{{ route('contact.v2.tyrevendor.index') }}" class="cv2-btn cv2-btn-soft">Cancel</a>
                    <button type="submit" form="cv2TyreVendorForm" class="cv2-btn cv2-btn-primary"><i class="bi bi-check2"></i>Save Vendor</button>
                </div>
            </div>

            <form id="cv2TyreVendorForm" action="{{ route('contact.v2.tyrevendor.save') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="phone_code" value="+91">
            <input type="hidden" name="whatsapp_code" value="+91">
            <div class="cv2-grid cv2-grid-2-1">
                <div style="display:flex;flex-direction:column;gap:16px;">

                    {{-- Company info --}}
                    <div class="cv2-card">
                        <div class="cv2-card-h"><h3>Company Information</h3></div>
                        <div class="cv2-card-b">
                            <div class="cv2-form-grid">
                                <div class="cv2-field"><label class="cv2-label">Company Name <span class="req">*</span></label><input type="text" name="company_name" placeholder="e.g. MRF Distributors" maxlength="100"></div>
                                <div class="cv2-field"><label class="cv2-label">Full Company Name</label><input type="text" name="full_company_name" placeholder="Registered legal name" maxlength="100"></div>
                                <div class="cv2-field"><label class="cv2-label">Contact Name <span class="req">*</span></label><input type="text" name="contact_name" placeholder="Primary contact" maxlength="100"></div>
                                <div class="cv2-field"><label class="cv2-label">Contact Code <span class="req">*</span></label><input type="text" name="contact_code" value="{{ $tyreCode }}" maxlength="100" readonly style="background:#f1f3f5;cursor:not-allowed;"></div>
                                <div class="cv2-field"><label class="cv2-label">Company Owner</label><input type="text" name="company_owner" placeholder="Owner / proprietor" maxlength="100"></div>
                                <div class="cv2-field"><label class="cv2-label">Working Since</label><input type="date" name="working_since" max="{{ date('Y-m-d') }}"></div>
                                <div class="cv2-field"><label class="cv2-label">Company Registration No</label><input type="text" name="company_registration_no" maxlength="100"></div>
                                <div class="cv2-field"><label class="cv2-label">Company Registration Date</label><input type="date" name="company_registration_date" max="{{ date('Y-m-d') }}"></div>
                                {{-- E7: NO size field for Tyre Vendor --}}
                                <div class="cv2-field is-full"><label class="cv2-label">Comment</label><input type="text" name="contact_comment" placeholder="Optional note" maxlength="255"></div>
                            </div>
                        </div>
                    </div>

                    {{-- Contact details --}}
                    <div class="cv2-card">
                        <div class="cv2-card-h"><h3>Contact Details</h3></div>
                        <div class="cv2-card-b">
                            <div class="cv2-form-grid">
                                <div class="cv2-field"><label class="cv2-label">Phone <span class="req">*</span></label><input type="tel" name="phone" data-intl-phone="1" placeholder="98640 11223"></div>
                                <div class="cv2-field"><label class="cv2-label">WhatsApp</label><input type="tel" name="whatsapp" data-intl-phone="1" placeholder="98640 11223"></div>
                            </div>
                        </div>
                    </div>

                    {{-- Tax & compliance --}}
                    <div class="cv2-card">
                        <div class="cv2-card-h"><h3>Tax &amp; Compliance</h3></div>
                        <div class="cv2-card-b">
                            <div class="cv2-form-grid">
                                <div class="cv2-field"><label class="cv2-label">PAN No</label><input type="text" name="pan_no" maxlength="100"></div>
                                <div class="cv2-field"><label class="cv2-label">PAN Status</label>
                                    <select class="cv2-select" name="pan_status_id" style="width:100%;">
                                        <option value="">Choose…</option>
                                        @foreach($pan_statuses as $ps)<option value="{{ $ps->id }}">{{ $ps->name }}</option>@endforeach
                                    </select>
                                </div>
                                <div class="cv2-field"><label class="cv2-label">GST Treatment</label>
                                    <select class="cv2-select" name="gst_treatment" id="cv2GstTreatment" style="width:100%;">
                                        <option value="">Choose…</option><option value="Registered">Registered</option><option value="Unregistered">Unregistered</option>
                                    </select>
                                </div>
                                <div class="cv2-field cv2-cond" data-gst="Registered"><label class="cv2-label">GST Number <span class="req">*</span></label><input type="text" name="gst_number" placeholder="18AAACT2727Q1ZW" maxlength="100"></div>
                                <div class="cv2-field"><label class="cv2-label">TDS Percentage</label><input type="number" step="0.01" min="0" max="100" name="tds_percentage" id="cv2TdsPct" placeholder="e.g. 5"></div>
                                <div class="cv2-field" id="cv2TdsDeclWrap" style="display:none;">
                                    <label class="cv2-label">TDS Declaration <span class="req">*</span></label>
                                    <input type="file" name="tds_declaration" accept=".jpg,.jpeg,.png,.pdf">
                                    <span class="cv2-help">Required because TDS % is 0 or 1. JPG, PNG or PDF · max 2 MB.</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Address --}}
                    <div class="cv2-card">
                        <div class="cv2-card-h"><h3>Address</h3></div>
                        <div class="cv2-card-b">
                            <div class="cv2-form-grid">
                                <div class="cv2-field is-full"><label class="cv2-label">Address <span class="req">*</span></label><textarea name="address" rows="2" placeholder="Street, area" maxlength="1000"></textarea></div>
                                <div class="cv2-field"><label class="cv2-label">State <span class="req">*</span></label>
                                    <select class="cv2-select cv2-state" name="state_id" data-city-target="#cv2City" style="width:100%;">
                                        <option value="">Choose state…</option>
                                        @foreach($states as $state)
                                            <option value="{{ $state->id }}" data-cities='@json($state->cities->map(fn($c)=>["id"=>$c->id,"name"=>$c->name])->values())'>{{ $state->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="cv2-field"><label class="cv2-label">City <span class="req">*</span></label>
                                    <select class="cv2-select" name="city_id" id="cv2City" style="width:100%;"><option value="">Choose city…</option></select>
                                </div>
                                <div class="cv2-field"><label class="cv2-label">Postal Code <span class="req">*</span></label><input type="text" name="post_code" placeholder="781001" maxlength="6"></div>
                                <div class="cv2-field is-full"><label class="cv2-label">Additional Info</label><textarea name="additional_info" rows="2" placeholder="Optional" maxlength="10000"></textarea></div>
                            </div>
                        </div>
                    </div>

                    {{-- E3: Bank details repeater --}}
                    <div class="cv2-card">
                        <div class="cv2-card-h"><h3>Bank Details <span class="cv2-pill" style="font-weight:600;">At least 1 · one Primary</span></h3>
                            <a href="javascript:void(0)" class="cv2-link" id="cv2AddBank"><i class="bi bi-plus-lg"></i> Add another</a></div>
                        <div class="cv2-card-b" id="cv2BankWrap">
                            <div class="cv2-bank-row">
                                <input type="hidden" name="contact_bank_id[]" value="">
                                <div class="cv2-bank-head">
                                    <label class="cv2-primary-pick"><input type="radio" name="primary_bank" value="0" checked> Set as primary account</label>
                                </div>
                                <div class="cv2-form-grid is-3">
                                    <div class="cv2-field"><label class="cv2-label">Bank <span class="req">*</span></label>
                                        <select class="cv2-select cv2-plain" name="bank_id[]" style="width:100%;">
                                            <option value="">Choose bank</option>
                                            @foreach($banks as $bank)<option value="{{ $bank->id }}">{{ $bank->name }}</option>@endforeach
                                        </select>
                                    </div>
                                    <div class="cv2-field"><label class="cv2-label">Beneficiary Name</label><input type="text" name="beneficiary_name[]"></div>
                                    <div class="cv2-field"><label class="cv2-label">Account Number <span class="req">*</span></label><input type="text" name="account_number[]" placeholder="Account no"></div>
                                    <div class="cv2-field"><label class="cv2-label">IFSC Code <span class="req">*</span></label><input type="text" name="ifsc_code[]" placeholder="IFSC"></div>
                                    <div class="cv2-field"><label class="cv2-label">UPI ID</label><input type="text" name="upi_id[]" placeholder="name@bank"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Contact persons --}}
                    <div class="cv2-card">
                        <div class="cv2-card-h"><h3>Contact Persons <span class="cv2-pill" style="font-weight:600;">At least 1</span></h3>
                            <a href="javascript:void(0)" class="cv2-link" id="cv2AddPerson"><i class="bi bi-plus-lg"></i> Add another</a></div>
                        <div class="cv2-card-b" id="cv2PersonWrap">
                            <div class="cv2-repeat-row">
                                <input type="hidden" name="contact_person_id[]" value="">
                                <div class="cv2-form-grid is-3">
                                    <div class="cv2-field"><label class="cv2-label">Name <span class="req">*</span></label><input type="text" name="contact_person_name[]" placeholder="Person name"></div>
                                    <div class="cv2-field"><label class="cv2-label">Designation</label><input type="text" name="contact_person_designation[]" placeholder="e.g. Sales Head"></div>
                                    <div class="cv2-field"><label class="cv2-label">Phone <span class="req">*</span></label><input type="tel" name="contact_person_phone[]" data-intl-phone="1" placeholder="98640 11223"></div>
                                    <div class="cv2-field"><label class="cv2-label">WhatsApp</label><input type="tel" name="contact_person_whatsapp[]" data-intl-phone="1" placeholder="98640 11223"></div>
                                    <div class="cv2-field"><label class="cv2-label">Email</label><input type="email" name="contact_person_email[]" placeholder="person@vendor.in"></div>
                                    <div class="cv2-field"><label class="cv2-label">Comment</label><input type="text" name="contact_person_comment[]" placeholder="Optional"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Right rail --}}
                <div>
                    <div class="cv2-card">
                        <div class="cv2-card-h"><h3>Status</h3></div>
                        <div class="cv2-card-b">
                            <div class="cv2-field"><label class="cv2-label">Vendor Status</label>
                                <select class="cv2-select" id="cv2Status" name="status" style="width:100%;"><option value="Active">Active</option><option value="Inactive">Inactive</option><option value="Blacklisted">Blacklisted</option></select>
                            </div>
                            <div class="cv2-field cv2-mt" id="cv2BlacklistWrap" style="display:none;">
                                <label class="cv2-label">Blacklist Reason <span class="req">*</span></label>
                                <textarea name="blacklist_reason" rows="3" placeholder="Why is this vendor being blacklisted?"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="cv2-card cv2-mt">
                        <div class="cv2-card-h"><h3>Available after saving</h3></div>
                        <div class="cv2-card-b" style="display:flex;flex-direction:column;gap:10px;">
                            <div class="cv2-locked"><i class="bi bi-paperclip"></i><div><b>Documents</b><div class="cv2-hint">GST, PAN, TDS &amp; agreements</div></div></div>
                            <div class="cv2-locked"><i class="bi bi-record-circle"></i><div><b>Tyre</b><div class="cv2-hint">Supplied tyre stock</div></div></div>
                            <span class="cv2-hint" style="margin-top:4px;">These submodules each open as their own page once the vendor exists.</span>
                        </div>
                    </div>
                    <div class="cv2-card cv2-mt">
                        <div class="cv2-card-b" style="display:flex;flex-direction:column;gap:10px;">
                            <button type="submit" form="cv2TyreVendorForm" class="cv2-btn cv2-btn-primary cv2-btn-lg" style="justify-content:center;"><i class="bi bi-check2"></i>Save Vendor</button>
                            <a href="{{ route('contact.v2.tyrevendor.index') }}" class="cv2-btn cv2-btn-ghost" style="justify-content:center;">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
            </form>

        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('js/V2/tyrevendor.js?v=2.0') }}"></script>
@endsection
