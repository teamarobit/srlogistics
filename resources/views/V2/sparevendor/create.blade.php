@extends('layouts.app')

@section('css')
<link href="{{ asset('css/V2/customer.css?v=1.3') }}" rel="stylesheet">
@endsection

@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="cv2-wrap">
        <div class="cv2-container">

            <div class="cv2-phead">
                <div>
                    <div class="cv2-crumb"><a href="{{ route('contact.v2.sparevendor.index') }}">Spare Vendors</a> · New</div>
                    <h1>Add Spare Part Vendor</h1>
                    <div class="cv2-sub">Create the vendor record. Spare Parts, Documents &amp; Activity open as their own pages once it is saved.</div>
                </div>
                <div class="cv2-phead-actions">
                    <a href="{{ route('contact.v2.sparevendor.index') }}" class="cv2-btn cv2-btn-soft">Cancel</a>
                    <button type="submit" form="cv2SpareForm" class="cv2-btn cv2-btn-primary"><i class="bi bi-check2"></i>Save Vendor</button>
                </div>
            </div>

            <form id="cv2SpareForm" action="javascript:void(0)" data-create="1">
            <div class="cv2-grid cv2-grid-2-1">
                <div style="display:flex;flex-direction:column;gap:16px;">

                    {{-- Basic info --}}
                    <div class="cv2-card">
                        <div class="cv2-card-h"><h3>Basic Information</h3></div>
                        <div class="cv2-card-b">
                            <div class="cv2-form-grid">
                                <div class="cv2-field">
                                    <label class="cv2-label">GST Number</label>
                                    <input type="text" name="gst_number" placeholder="18AAACT2727Q1ZW" maxlength="100">
                                    <span class="cv2-help">Format: 18AAACT2727Q1ZW</span>
                                </div>
                                <div class="cv2-field">
                                    <label class="cv2-label">Company Name <span class="req">*</span></label>
                                    <input type="text" name="company_name" placeholder="Enter company name" maxlength="100">
                                </div>
                                <div class="cv2-field">
                                    <label class="cv2-label">Contact Name <span class="req">*</span></label>
                                    <input type="text" name="contact_name" placeholder="Primary contact" maxlength="100">
                                </div>
                                <div class="cv2-field">
                                    <label class="cv2-label">Contact Code <span class="req">*</span></label>
                                    <input type="text" name="contact_code" placeholder="e.g. AAS-01" maxlength="100">
                                </div>
                                <div class="cv2-field is-full">
                                    <label class="cv2-label">Specialisation</label>
                                    <select class="cv2-select" name="specialisation[]" multiple style="width:100%;">
                                        <option>Engine Parts</option><option>Brake System</option><option>Filters</option>
                                        <option>Electricals</option><option>Lubricants</option><option>Suspension</option>
                                        <option>Tyres &amp; Tubes</option><option>Body Parts</option><option>Transmission</option>
                                    </select>
                                    <span class="cv2-help">Select one or more spare-part categories — stored as comma-joined tags.</span>
                                </div>
                                <div class="cv2-field is-full">
                                    <label class="cv2-label">Comment</label>
                                    <input type="text" name="contact_comment" placeholder="Optional note" maxlength="255">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Contact details --}}
                    <div class="cv2-card">
                        <div class="cv2-card-h"><h3>Contact Details</h3></div>
                        <div class="cv2-card-b">
                            <div class="cv2-form-grid">
                                <div class="cv2-field">
                                    <label class="cv2-label">Phone <span class="req">*</span></label>
                                    <input type="tel" name="phone" data-intl-phone="1" placeholder="98640 22115">
                                </div>
                                <div class="cv2-field">
                                    <label class="cv2-label">WhatsApp</label>
                                    <input type="tel" name="whatsapp" data-intl-phone="1" placeholder="98640 22115">
                                </div>
                                <div class="cv2-field is-full">
                                    <label class="cv2-label">Email</label>
                                    <input type="email" name="email" placeholder="sales@company.in">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Company details --}}
                    <div class="cv2-card">
                        <div class="cv2-card-h"><h3>Company Details <span class="cv2-pill" style="font-weight:600;">Optional</span></h3></div>
                        <div class="cv2-card-b">
                            <div class="cv2-form-grid">
                                <div class="cv2-field"><label class="cv2-label">Full Company Name</label><input type="text" name="full_company_name" maxlength="100"></div>
                                <div class="cv2-field"><label class="cv2-label">Company Owner</label><input type="text" name="company_owner" maxlength="100"></div>
                                <div class="cv2-field"><label class="cv2-label">Registration No</label><input type="text" name="company_registration_no" maxlength="100"></div>
                                <div class="cv2-field"><label class="cv2-label">Registration Date</label><input type="date" name="company_registration_date"></div>
                                <div class="cv2-field"><label class="cv2-label">Working Since</label><input type="date" name="working_since"></div>
                                <div class="cv2-field"><label class="cv2-label">PAN No</label><input type="text" name="pan_no" maxlength="100"></div>
                                <div class="cv2-field"><label class="cv2-label">PAN Status</label><select class="cv2-select" name="pan_status_id" style="width:100%;"><option value="">Choose…</option><option>Individual</option><option>Company</option><option>HUF</option></select></div>
                                <div class="cv2-field">
                                    <label class="cv2-label">TDS Percentage</label>
                                    <input type="number" name="tds_percentage" min="0" max="100" step="0.01" placeholder="e.g. 2">
                                    <span class="cv2-help">If 0% or 1%, a TDS Declaration document is required (added on the Documents page).</span>
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
                                <div class="cv2-field"><label class="cv2-label">State <span class="req">*</span></label><select class="cv2-select" name="state_id" style="width:100%;"><option value="">Choose state…</option><option>Assam</option><option>West Bengal</option><option>Meghalaya</option></select></div>
                                <div class="cv2-field"><label class="cv2-label">City <span class="req">*</span></label><select class="cv2-select" name="city_id" style="width:100%;"><option value="">Choose city…</option><option>Guwahati</option><option>Dibrugarh</option><option>Silchar</option><option>Tinsukia</option><option>Nagaon</option></select></div>
                                <div class="cv2-field"><label class="cv2-label">Postal Code</label><input type="text" name="post_code" placeholder="781001" maxlength="6"></div>
                                <div class="cv2-field is-full"><label class="cv2-label">Additional Info</label><textarea name="additional_info" rows="2" placeholder="Notes, landmarks, GSTIN remarks…" maxlength="10000"></textarea></div>
                            </div>
                        </div>
                    </div>

                    {{-- Bank details (E3 repeater) --}}
                    <div class="cv2-card">
                        <div class="cv2-card-h"><h3>Bank Details <span class="cv2-pill" style="font-weight:600;">At least 1 · exactly 1 Primary</span></h3>
                            <a href="javascript:void(0)" class="cv2-link" id="cv2AddBank"><i class="bi bi-plus-lg"></i> Add bank</a></div>
                        <div class="cv2-card-b" id="cv2BankWrap">
                            <div class="cv2-repeat-row">
                                <div class="cv2-form-grid is-3">
                                    <div class="cv2-field"><label class="cv2-label">Bank <span class="req">*</span></label><input type="text" name="bank[]" placeholder="Bank name"></div>
                                    <div class="cv2-field"><label class="cv2-label">Account Number <span class="req">*</span></label><input type="text" name="account_number[]" placeholder="Account no"></div>
                                    <div class="cv2-field"><label class="cv2-label">IFSC Code <span class="req">*</span></label><input type="text" name="ifsc_code[]" placeholder="SBIN0001234"></div>
                                    <div class="cv2-field"><label class="cv2-label">UPI ID</label><input type="text" name="upi_id[]" placeholder="name@bank"></div>
                                    <div class="cv2-field"><label class="cv2-label">Primary</label>
                                        <div class="cv2-radio-group">
                                            <span class="cv2-radio"><input type="radio" name="is_primary" value="0" checked><label>Primary</label></span>
                                        </div>
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
                            <div class="cv2-repeat-row">
                                <div class="cv2-form-grid is-3">
                                    <div class="cv2-field"><label class="cv2-label">Name <span class="req">*</span></label><input type="text" placeholder="Person name"></div>
                                    <div class="cv2-field"><label class="cv2-label">Designation <span class="req">*</span></label><input type="text" placeholder="e.g. Sales Manager"></div>
                                    <div class="cv2-field"><label class="cv2-label">Phone <span class="req">*</span></label><input type="tel" data-intl-phone="1" placeholder="98640 22115"></div>
                                    <div class="cv2-field"><label class="cv2-label">Email</label><input type="email" placeholder="person@company.in"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- E7: NO document upload on create — note only --}}
                    <div class="cv2-card">
                        <div class="cv2-card-h"><h3>Documents</h3></div>
                        <div class="cv2-card-b">
                            <div class="cv2-locked"><i class="bi bi-info-circle"></i><div><b>Documents are added after saving</b><div class="cv2-hint">Spare-vendor documents (incl. the TDS Declaration) are managed on the Documents page once the vendor record exists.</div></div></div>
                        </div>
                    </div>

                </div>

                {{-- Right rail --}}
                <div>
                    <div class="cv2-card">
                        <div class="cv2-card-h"><h3>Status</h3></div>
                        <div class="cv2-card-b">
                            <div class="cv2-field"><label class="cv2-label">Vendor Status</label>
                                <select class="cv2-select" id="cv2Status" name="status" style="width:100%;"><option>Active</option><option>Inactive</option><option>Blacklisted</option></select>
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
                            <div class="cv2-locked"><i class="bi bi-lock"></i><div><b>Spare Parts</b><div class="cv2-hint">Items this vendor supplies</div></div></div>
                            <div class="cv2-locked"><i class="bi bi-lock"></i><div><b>Documents</b><div class="cv2-hint">GST, PAN, TDS Declaration</div></div></div>
                            <div class="cv2-locked"><i class="bi bi-lock"></i><div><b>Activity</b><div class="cv2-hint">Notes &amp; audit trail</div></div></div>
                            <span class="cv2-hint" style="margin-top:4px;">Each submodule opens as its own page once the vendor exists.</span>
                        </div>
                    </div>
                    <div class="cv2-card cv2-mt">
                        <div class="cv2-card-b" style="display:flex;flex-direction:column;gap:10px;">
                            <button type="submit" form="cv2SpareForm" class="cv2-btn cv2-btn-primary cv2-btn-lg" style="justify-content:center;"><i class="bi bi-check2"></i>Save Vendor</button>
                            <a href="{{ route('contact.v2.sparevendor.index') }}" class="cv2-btn cv2-btn-ghost" style="justify-content:center;">Cancel</a>
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
<script src="{{ asset('js/V2/customer.js?v=1.3') }}"></script>
<script src="{{ asset('js/V2/sparevendor.js?v=1.0') }}"></script>
@endsection
