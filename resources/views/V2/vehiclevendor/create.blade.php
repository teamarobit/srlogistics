@extends('layouts.app')

@section('css')
<link href="{{ asset('css/V2/vehiclevendor.css?v=2.0') }}" rel="stylesheet">
@endsection

@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="cv2-wrap">
        <div class="cv2-container">

            <div class="cv2-phead">
                <div>
                    <div class="cv2-crumb"><a href="{{ route('contact.v2.vehiclevendor.index') }}">Vehicle Vendors</a> · New</div>
                    <h1>Add Vehicle Vendor</h1>
                    <div class="cv2-sub">Create the vendor record. Documents &amp; Activity open once it is saved. Vehicle &amp; Route are view-only for now.</div>
                </div>
                <div class="cv2-phead-actions">
                    <a href="{{ route('contact.v2.vehiclevendor.index') }}" class="cv2-btn cv2-btn-soft">Cancel</a>
                    <button type="submit" form="cv2CustomerForm" class="cv2-btn cv2-btn-primary"><i class="bi bi-check2"></i>Save Vendor</button>
                </div>
            </div>

            <form id="cv2CustomerForm" action="{{ route('contact.v2.vehiclevendor.save') }}" method="POST" enctype="multipart/form-data" data-create="1" data-index-url="{{ route('contact.v2.vehiclevendor.index') }}" data-person-wrapper-url="{{ route('contact.v2.vehiclevendor.contactpersonwrapper') }}">
            @csrf
            <div class="cv2-grid cv2-grid-2-1">
                <div style="display:flex;flex-direction:column;gap:16px;">

                    {{-- Basic info --}}
                    <div class="cv2-card">
                        <div class="cv2-card-h"><h3>Basic Information</h3></div>
                        <div class="cv2-card-b">
                            <div class="cv2-form-grid">
                                <div class="cv2-field"><label class="cv2-label">Company Name <span class="req">*</span></label><input type="text" name="company_name" value="{{ old('company_name') }}" placeholder="e.g. Brahmaputra Carriers" maxlength="100"></div>
                                <div class="cv2-field"><label class="cv2-label">Contact Name <span class="req">*</span></label><input type="text" name="contact_name" value="{{ old('contact_name') }}" placeholder="Primary contact" maxlength="100"></div>
                                <div class="cv2-field"><label class="cv2-label">Contact Code <span class="req">*</span></label><input type="text" name="contact_code" value="{{ old('contact_code') }}" placeholder="e.g. VV-BC-01" maxlength="100"></div>
                                <div class="cv2-field"><label class="cv2-label">No. of Vehicles</label><input type="number" name="no_of_vehicles" value="{{ old('no_of_vehicles') }}" placeholder="0" min="0"></div>
                                <div class="cv2-field"><label class="cv2-label">Size</label>
                                    <select class="cv2-select" name="size" style="width:100%;">
                                        <option value="">Choose…</option>
                                        @foreach(['Small','Medium','Large'] as $sz)
                                            <option value="{{ $sz }}" {{ old('size') === $sz ? 'selected' : '' }}>{{ $sz }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="cv2-field"><label class="cv2-label">RAG Status</label>
                                    <select class="cv2-select" name="rag_status" style="width:100%;">
                                        <option value="">Choose…</option>
                                        @foreach(['Green','Yellow','Red'] as $rg)
                                            <option value="{{ $rg }}" {{ old('rag_status') === $rg ? 'selected' : '' }}>{{ $rg }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="cv2-field is-full"><label class="cv2-label">Comment</label><input type="text" name="contact_comment" value="{{ old('contact_comment') }}" placeholder="Optional note" maxlength="255"></div>
                            </div>
                        </div>
                    </div>

                    {{-- Contact details --}}
                    <div class="cv2-card">
                        <div class="cv2-card-h"><h3>Contact Details</h3></div>
                        <div class="cv2-card-b">
                            <div class="cv2-form-grid">
                                <div class="cv2-field"><label class="cv2-label">Phone <span class="req">*</span></label><input type="tel" name="phone" value="{{ old('phone') }}" data-intl-phone="1" placeholder="98640 22114"></div>
                                <div class="cv2-field"><label class="cv2-label">WhatsApp</label><input type="tel" name="whatsapp" value="{{ old('whatsapp') }}" data-intl-phone="1" placeholder="98640 22114"></div>
                            </div>
                        </div>
                    </div>

                    {{-- Company & tax --}}
                    <div class="cv2-card">
                        <div class="cv2-card-h"><h3>Company &amp; Tax Details <span class="cv2-pill" style="font-weight:600;">Optional</span></h3></div>
                        <div class="cv2-card-b">
                            <div class="cv2-form-grid">
                                <div class="cv2-field"><label class="cv2-label">Full Company Name</label><input type="text" name="full_company_name" value="{{ old('full_company_name') }}" placeholder="Registered legal name" maxlength="100"></div>
                                <div class="cv2-field"><label class="cv2-label">Vehicle Ownership Type</label>
                                    <select class="cv2-select" name="vehicle_ownership_type_id" style="width:100%;">
                                        <option value="">Choose…</option>
                                        @foreach($vehicle_ownership_type as $vot)
                                            <option value="{{ $vot->id }}" {{ old('vehicle_ownership_type_id') == $vot->id ? 'selected' : '' }}>{{ $vot->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="cv2-field"><label class="cv2-label">Company Owner</label><input type="text" name="company_owner" value="{{ old('company_owner') }}" placeholder="Owner name" maxlength="100"></div>
                                <div class="cv2-field"><label class="cv2-label">Company Registration No</label><input type="text" name="company_registration_no" value="{{ old('company_registration_no') }}" maxlength="100"></div>
                                <div class="cv2-field"><label class="cv2-label">Company Registration Date</label><input type="date" name="company_registration_date" value="{{ old('company_registration_date') }}"></div>
                                <div class="cv2-field"><label class="cv2-label">Working Since</label><input type="date" name="working_since" value="{{ old('working_since') }}"></div>
                                <div class="cv2-field"><label class="cv2-label">PAN No</label><input type="text" name="pan_no" value="{{ old('pan_no') }}" placeholder="ABCDE1234F" maxlength="100"></div>
                                <div class="cv2-field"><label class="cv2-label">PAN Status</label>
                                    <select class="cv2-select" name="pan_status_id" style="width:100%;">
                                        <option value="">Choose…</option>
                                        @foreach($pan_statuses as $ps)
                                            <option value="{{ $ps->id }}" {{ old('pan_status_id') == $ps->id ? 'selected' : '' }}>{{ $ps->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="cv2-field"><label class="cv2-label">GST Treatment</label>
                                    <select class="cv2-select" name="gst_treatment" id="cv2GstTreatment" style="width:100%;">
                                        <option value="">Choose…</option>
                                        @foreach(['Registered','Unregistered'] as $gt)
                                            <option value="{{ $gt }}" {{ old('gst_treatment') === $gt ? 'selected' : '' }}>{{ $gt }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="cv2-field" data-when="gst-registered" style="display:none;"><label class="cv2-label">GST Number <span class="req">*</span></label><input type="text" name="gst_number" value="{{ old('gst_number') }}" placeholder="18AAACB7711P1Z4" maxlength="100"></div>
                                <div class="cv2-field"><label class="cv2-label">TDS Percentage</label><input type="number" name="tds_percentage" id="cv2Tds" value="{{ old('tds_percentage') }}" placeholder="0" min="0" max="100" step="0.01"><span class="cv2-help">If set to <b>0</b> or <b>1</b>, a TDS Declaration upload becomes mandatory.</span></div>
                            </div>
                            <div class="cv2-note is-warn cv2-mt" id="cv2TdsNotice" style="display:none;">
                                <i class="bi bi-exclamation-triangle"></i>
                                <div><b>TDS Declaration required.</b> Because TDS percentage is 0 or 1, upload the TDS Declaration document (type 7) below before saving.</div>
                            </div>
                        </div>
                    </div>

                    {{-- Address --}}
                    <div class="cv2-card">
                        <div class="cv2-card-h"><h3>Address</h3></div>
                        <div class="cv2-card-b">
                            <div class="cv2-form-grid">
                                <div class="cv2-field is-full"><label class="cv2-label">Address <span class="req">*</span></label><textarea name="address" rows="2" placeholder="Street, area" maxlength="1000">{{ old('address') }}</textarea></div>
                                <div class="cv2-field"><label class="cv2-label">State <span class="req">*</span></label>
                                    <select class="cv2-select cv2-state" name="state_id" data-city-target="#cv2VehicleCity" style="width:100%;">
                                        <option value="">Choose state…</option>
                                        @foreach($states as $st)
                                            <option value="{{ $st->id }}" data-cities='@json($st->cities->map(fn($ci)=>["id"=>$ci->id,"name"=>$ci->name]))' {{ old('state_id') == $st->id ? 'selected' : '' }}>{{ $st->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="cv2-field"><label class="cv2-label">City <span class="req">*</span></label>
                                    <select class="cv2-select" id="cv2VehicleCity" name="city_id" data-old="{{ old('city_id') }}" style="width:100%;"><option value="">Choose city…</option></select>
                                </div>
                                <div class="cv2-field"><label class="cv2-label">Postal Code <span class="req">*</span></label><input type="text" name="post_code" value="{{ old('post_code') }}" placeholder="781001" maxlength="6"></div>
                                <div class="cv2-field is-full"><label class="cv2-label">Additional Info</label><textarea name="additional_info" rows="2" placeholder="Landmark, directions, etc." maxlength="10000">{{ old('additional_info') }}</textarea></div>
                            </div>
                        </div>
                    </div>

                    {{-- Bank details (E3) --}}
                    <div class="cv2-card">
                        <div class="cv2-card-h"><h3>Bank Details <span class="cv2-pill" style="font-weight:600;">At least 1 · exactly 1 primary</span></h3>
                            <a href="javascript:void(0)" class="cv2-link" id="cv2AddBank"><i class="bi bi-plus-lg"></i> Add bank</a></div>
                        <div class="cv2-card-b" id="cv2BankWrap">
                            <div class="cv2-repeat-row">
                                <div class="cv2-form-grid is-3">
                                    <div class="cv2-field"><label class="cv2-label">Bank <span class="req">*</span></label>
                                        <select class="cv2-select cv2-plain" name="bank_id[]" style="width:100%;">
                                            <option value="">Choose bank</option>
                                            @foreach($banks as $bank)
                                                <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="cv2-field"><label class="cv2-label">Account Number <span class="req">*</span></label><input type="text" name="account_number[]" placeholder="Account number"></div>
                                    <div class="cv2-field"><label class="cv2-label">IFSC Code <span class="req">*</span></label><input type="text" name="ifsc_code[]" placeholder="SBIN0001234"></div>
                                    <div class="cv2-field"><label class="cv2-label">UPI ID</label><input type="text" name="upi_id[]" placeholder="name@bank"></div>
                                    <div class="cv2-field"><label class="cv2-label">Primary</label>
                                        <div class="cv2-radio-group"><span class="cv2-radio"><input type="radio" name="primary_bank" value="0" checked><label>Primary</label></span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Contact persons --}}
                    <div class="cv2-card">
                        <div class="cv2-card-h"><h3>Contact Persons <span class="cv2-pill" style="font-weight:600;">At least 1</span></h3>
                            <a href="javascript:void(0)" class="cv2-link" id="cv2AddPerson"><i class="bi bi-plus-lg"></i> Add another</a></div>
                        <div class="cv2-card-b" id="cv2PersonWrap">
                            <div class="cv2-repeat-row" data-index="0">
                                <input type="hidden" name="contact_person_id[0]" value="">
                                <input type="hidden" name="contact_person_ph_code[]" class="cv2-cp-phcode">
                                <input type="hidden" name="contact_person_whatsapp_code[]" class="cv2-cp-wacode">
                                <div class="cv2-form-grid is-3">
                                    <div class="cv2-field"><label class="cv2-label">Name <span class="req">*</span></label><input type="text" name="contact_person_name[0]" placeholder="Person name"></div>
                                    <div class="cv2-field"><label class="cv2-label">Designation <span class="req">*</span></label><input type="text" name="contact_person_designation[0]" placeholder="e.g. Fleet Manager"></div>
                                    <div class="cv2-field"><label class="cv2-label">Phone <span class="req">*</span></label><input type="tel" name="contact_person_phone[0]" data-intl-phone="1" placeholder="98640 22114"></div>
                                    <div class="cv2-field"><label class="cv2-label">Email</label><input type="email" name="contact_person_email[0]" placeholder="person@vendor.in"></div>
                                    <div class="cv2-field"><label class="cv2-label">Comment</label><input type="text" name="contact_person_comment[0]" placeholder="Optional"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Documents (E6 — single upload; TDS Declaration mandatory when TDS 0/1) --}}
                    <div class="cv2-card">
                        <div class="cv2-card-h"><h3>Documents</h3></div>
                        <div class="cv2-card-b">
                            <div class="cv2-form-grid">
                                <div class="cv2-field"><label class="cv2-label">Document Type</label>
                                    <select class="cv2-select cv2-plain" name="coattachtype_id" style="width:100%;">
                                        <option value="">Select type…</option>
                                        @foreach($coattachtypes as $ct)
                                            <option value="{{ $ct->id }}" {{ old('coattachtype_id') == $ct->id ? 'selected' : '' }}>{{ $ct->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="cv2-field"><label class="cv2-label">File</label><input type="file" name="attachment_file" accept=".jpg,.jpeg,.png,.pdf"></div>
                                <div class="cv2-field is-full"><span class="cv2-hint">JPG, PNG or PDF · max 2 MB. Add more documents on the Documents page after saving.</span></div>
                                <div class="cv2-field is-full cv2-note" id="cv2TdsDocNotice" style="display:none;">
                                    <i class="bi bi-paperclip"></i><div><b>TDS Declaration</b> is mandatory for this vendor (TDS % is 0 or 1). Select type <b>TDS Declaration</b> and attach the file.</div>
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
                                <select class="cv2-select" id="cv2Status" name="status" style="width:100%;">
                                    <option value="Active" {{ old('status','Active')==='Active'?'selected':'' }}>Active</option>
                                    <option value="Inactive" {{ old('status')==='Inactive'?'selected':'' }}>Inactive</option>
                                    <option value="Blacklisted" {{ old('status')==='Blacklisted'?'selected':'' }}>Blacklisted</option>
                                </select>
                            </div>
                            <div class="cv2-field cv2-mt" id="cv2BlacklistWrap" style="{{ old('status')==='Blacklisted'?'':'display:none;' }}">
                                <label class="cv2-label">Blacklist Reason <span class="req">*</span></label>
                                <textarea name="blacklist_reason" rows="3" placeholder="Why is this vendor being blacklisted?">{{ old('blacklist_reason') }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="cv2-card cv2-mt">
                        <div class="cv2-card-h"><h3>Available after saving</h3></div>
                        <div class="cv2-card-b" style="display:flex;flex-direction:column;gap:10px;">
                            <div class="cv2-locked"><i class="bi bi-truck"></i><div><b>Vehicle</b><div class="cv2-hint">Fleet this vendor supplies (view-only)</div></div></div>
                            <div class="cv2-locked"><i class="bi bi-signpost-split"></i><div><b>Route</b><div class="cv2-hint">Routes the vendor covers (view-only)</div></div></div>
                            <div class="cv2-locked"><i class="bi bi-paperclip"></i><div><b>Documents</b><div class="cv2-hint">GST, PAN, TDS declaration</div></div></div>
                            <div class="cv2-locked"><i class="bi bi-clock-history"></i><div><b>Activity</b><div class="cv2-hint">Notes &amp; audit trail</div></div></div>
                            <span class="cv2-hint" style="margin-top:4px;">These submodules each open as their own page once the vendor exists.</span>
                        </div>
                    </div>
                    <div class="cv2-card cv2-mt">
                        <div class="cv2-card-b" style="display:flex;flex-direction:column;gap:10px;">
                            <button type="submit" form="cv2CustomerForm" class="cv2-btn cv2-btn-primary cv2-btn-lg" style="justify-content:center;"><i class="bi bi-check2"></i>Save Vendor</button>
                            <a href="{{ route('contact.v2.vehiclevendor.index') }}" class="cv2-btn cv2-btn-ghost" style="justify-content:center;">Cancel</a>
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
<script src="{{ asset('js/V2/customer.js?v=1.4') }}"></script>
<script src="{{ asset('js/V2/vehiclevendor.js?v=2.0') }}"></script>
@endsection
