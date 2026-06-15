@extends('layouts.app')

@section('css')
<link href="{{ asset('css/V2/driver.css?v=1.0') }}" rel="stylesheet">
@endsection

@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="cv2-wrap">
        <div class="cv2-container">

            <div class="cv2-phead">
                <div>
                    <div class="cv2-crumb"><a href="{{ route('contact.v2.driver.index') }}">Drivers</a> · New</div>
                    <h1>Add Driver</h1>
                    <div class="cv2-sub">Create the driver record. Joining, Documents, Assets, Bhatta &amp; Exit open once it is saved.</div>
                </div>
                <div class="cv2-phead-actions">
                    <a href="{{ route('contact.v2.driver.index') }}" class="cv2-btn cv2-btn-soft">Cancel</a>
                    <button type="submit" form="cv2DriverForm" class="cv2-btn cv2-btn-primary"><i class="bi bi-check2"></i>Save Driver</button>
                </div>
            </div>

            <form id="cv2DriverForm" action="javascript:void(0)" data-create="1">
            <div class="cv2-grid cv2-grid-2-1">
                <div style="display:flex;flex-direction:column;gap:16px;">

                    {{-- Basic info --}}
                    <div class="cv2-card">
                        <div class="cv2-card-h"><h3>Basic Information</h3></div>
                        <div class="cv2-card-b">
                            <div class="cv2-form-grid">
                                <div class="cv2-field">
                                    <label class="cv2-label">Driver Code <span class="req">*</span></label>
                                    <input type="text" name="contact_code" value="DR-133" maxlength="100">
                                    <span class="cv2-help">Auto-generated preview: DR-133</span>
                                </div>
                                <div class="cv2-field">
                                    <label class="cv2-label">Driver Name <span class="req">*</span></label>
                                    <input type="text" name="contact_name" placeholder="Enter driver name" maxlength="100">
                                </div>
                                <div class="cv2-field">
                                    <label class="cv2-label">Driver Category <span class="req">*</span></label>
                                    <select class="cv2-select" name="driver_category" style="width:100%;"><option value="">Choose…</option><option>Local</option><option>Line</option></select>
                                </div>
                                <div class="cv2-field">
                                    <label class="cv2-label">Allocate Vehicle <span class="req">*</span></label>
                                    <select class="cv2-select" name="vehicle_id" style="width:100%;"><option value="">Choose vehicle…</option><option>AS01GC4471</option><option>AS01HC2210</option><option>AS02GC8890</option></select>
                                    <span class="cv2-hint">Only vehicles not already allocated to a driver are listed.</span>
                                </div>
                                <div class="cv2-field">
                                    <label class="cv2-label">Date of Birth</label>
                                    <input type="date" name="dob">
                                </div>
                                <div class="cv2-field">
                                    <label class="cv2-label">Date of Joining <span class="req">*</span></label>
                                    <input type="date" name="doj">
                                </div>
                                <div class="cv2-field">
                                    <label class="cv2-label">Blood Group</label>
                                    <select class="cv2-select" name="blood_group" style="width:100%;"><option value="">Choose…</option><option>A+</option><option>A-</option><option>B+</option><option>B-</option><option>AB+</option><option>AB-</option><option>O+</option><option>O-</option></select>
                                </div>
                                <div class="cv2-field">
                                    <label class="cv2-label">Religion</label>
                                    <select class="cv2-select" name="religion_id" style="width:100%;"><option value="">Choose…</option><option>Hindu</option><option>Muslim</option><option>Christian</option><option>Other</option></select>
                                </div>
                                <div class="cv2-field is-full">
                                    <label class="cv2-label">Driver Photo</label>
                                    <div class="cv2-dropzone"><i class="bi bi-person-square"></i>Drop a profile photo or click to upload (JPG/PNG/WEBP · max 2 MB)</div>
                                </div>
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

                    {{-- Licence & Aadhaar (driverinfo) --}}
                    <div class="cv2-card">
                        <div class="cv2-card-h"><h3>Licence &amp; Identity</h3></div>
                        <div class="cv2-card-b">
                            <div class="cv2-form-grid">
                                <div class="cv2-field"><label class="cv2-label">Driving Licence No <span class="req">*</span></label><input type="text" name="driving_licence_no" placeholder="AS-0120190001234"></div>
                                <div class="cv2-field"><label class="cv2-label">Original Licence Location <span class="req">*</span></label><input type="text" name="original_licence_location" placeholder="RTO / office held at"></div>
                                <div class="cv2-field"><label class="cv2-label">Licence Issue Date <span class="req">*</span></label><input type="date" name="licence_issue_date"></div>
                                <div class="cv2-field"><label class="cv2-label">Licence Expiry Date <span class="req">*</span></label><input type="date" name="licence_expiry_date"></div>
                                <div class="cv2-field"><label class="cv2-label">Driving Licence Proof <span class="req">*</span></label><div class="cv2-dropzone" style="padding:18px;"><i class="bi bi-cloud-arrow-up"></i>Upload licence (PDF/JPG/PNG)</div></div>
                                <div class="cv2-field"><label class="cv2-label">Aadhaar No <span class="req">*</span></label><input type="text" name="aadhaar_no" placeholder="4821 7740 9921"></div>
                                <div class="cv2-field"><label class="cv2-label">Aadhaar Card Proof <span class="req">*</span></label><div class="cv2-dropzone" style="padding:18px;"><i class="bi bi-cloud-arrow-up"></i>Upload Aadhaar (PDF/JPG/PNG)</div></div>
                                <div class="cv2-field"><label class="cv2-label">Signed Driver Form <span class="req">*</span></label><div class="cv2-dropzone" style="padding:18px;"><i class="bi bi-cloud-arrow-up"></i>Upload signed form (PDF/JPG/PNG)</div></div>
                            </div>
                        </div>
                    </div>

                    {{-- Permanent address (E5) --}}
                    <div class="cv2-card">
                        <div class="cv2-card-h"><h3>Permanent Address</h3></div>
                        <div class="cv2-card-b">
                            <div class="cv2-form-grid">
                                <div class="cv2-field is-full"><label class="cv2-label">Address <span class="req">*</span></label><textarea name="permanent_address" rows="2" placeholder="House, street, area" maxlength="255"></textarea></div>
                                <div class="cv2-field"><label class="cv2-label">State <span class="req">*</span></label><select class="cv2-select" name="permanent_addr_state_id" style="width:100%;"><option value="">Choose state…</option><option>Assam</option><option>West Bengal</option></select></div>
                                <div class="cv2-field"><label class="cv2-label">City</label><select class="cv2-select" name="permanent_addr_city_id" style="width:100%;"><option value="">Choose city…</option><option>Guwahati</option><option>Dibrugarh</option></select></div>
                                <div class="cv2-field"><label class="cv2-label">Postal Code <span class="req">*</span></label><input type="text" name="permanent_addr_postal_code" placeholder="781001" maxlength="6"></div>
                            </div>
                        </div>
                    </div>

                    {{-- Present address (E5) --}}
                    <div class="cv2-card">
                        <div class="cv2-card-h"><h3>Present Address</h3>
                            <label class="cv2-primary-pick"><input type="checkbox" id="cv2SameAsPermanent"> Same as permanent</label></div>
                        <div class="cv2-card-b" id="cv2PresentWrap">
                            <div class="cv2-form-grid">
                                <div class="cv2-field is-full"><label class="cv2-label">Address <span class="req">*</span></label><textarea name="present_address" rows="2" placeholder="House, street, area" maxlength="255"></textarea></div>
                                <div class="cv2-field"><label class="cv2-label">State <span class="req">*</span></label><select class="cv2-select" name="present_addr_state_id" style="width:100%;"><option value="">Choose state…</option><option>Assam</option><option>West Bengal</option></select></div>
                                <div class="cv2-field"><label class="cv2-label">City</label><select class="cv2-select" name="present_addr_city_id" style="width:100%;"><option value="">Choose city…</option><option>Guwahati</option><option>Dibrugarh</option></select></div>
                                <div class="cv2-field"><label class="cv2-label">Postal Code <span class="req">*</span></label><input type="text" name="present_addr_postal_code" placeholder="781001" maxlength="6"></div>
                            </div>
                        </div>
                    </div>

                    {{-- Bank details (E3) --}}
                    <div class="cv2-card">
                        <div class="cv2-card-h"><h3>Bank Details <span class="cv2-pill" style="font-weight:600;">At least 1 · exactly one primary</span></h3>
                            <a href="javascript:void(0)" class="cv2-link" id="cv2AddBank"><i class="bi bi-plus-lg"></i> Add bank</a></div>
                        <div class="cv2-card-b" id="cv2BankWrap">
                            <div class="cv2-bank-row">
                                <div class="cv2-bank-head">
                                    <label class="cv2-primary-pick"><input type="radio" name="is_primary_pick" checked> Set as primary account</label>
                                    <span class="cv2-primary-tag">Primary</span>
                                </div>
                                <div class="cv2-form-grid is-3">
                                    <div class="cv2-field"><label class="cv2-label">Bank <span class="req">*</span></label><select class="cv2-select" name="bank_id[]" style="width:100%;"><option value="">Choose bank</option><option>SBI</option><option>HDFC</option><option>ICICI</option><option>Axis</option></select></div>
                                    <div class="cv2-field"><label class="cv2-label">Beneficiary Name</label><input type="text" name="beneficiary_name[]"></div>
                                    <div class="cv2-field"><label class="cv2-label">Account Number <span class="req">*</span></label><input type="text" name="account_number[]"></div>
                                    <div class="cv2-field"><label class="cv2-label">IFSC Code <span class="req">*</span></label><input type="text" name="ifsc_code[]"></div>
                                    <div class="cv2-field"><label class="cv2-label">UPI ID</label><input type="text" name="upi_id[]"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Bhatta opening balance --}}
                    <div class="cv2-card">
                        <div class="cv2-card-h"><h3>Bhatta &amp; Hisab</h3></div>
                        <div class="cv2-card-b">
                            <div class="cv2-form-grid">
                                <div class="cv2-field"><label class="cv2-label">Hisab Category <span class="req">*</span></label>
                                    <div class="cv2-radio-group">
                                        <span class="cv2-radio"><input type="radio" name="hisab_category" id="hc_fixed" value="Fixed"><label for="hc_fixed">Fixed</label></span>
                                        <span class="cv2-radio"><input type="radio" name="hisab_category" id="hc_fuel" value="Fuel"><label for="hc_fuel">Fuel</label></span>
                                    </div>
                                </div>
                                <div class="cv2-field"><label class="cv2-label">Opening Balance Date <span class="req">*</span></label><input type="date" name="opening_balance_date"></div>
                                <div class="cv2-field"><label class="cv2-label">Opening Balance Type <span class="req">*</span></label>
                                    <div class="cv2-radio-group">
                                        <span class="cv2-radio"><input type="radio" name="opening_balance_type" id="ob_cr" value="Credit"><label for="ob_cr">Credit</label></span>
                                        <span class="cv2-radio"><input type="radio" name="opening_balance_type" id="ob_dr" value="Debit"><label for="ob_dr">Debit</label></span>
                                    </div>
                                </div>
                                <div class="cv2-field"><label class="cv2-label">Opening Balance (₹) <span class="req">*</span></label><input type="number" name="opening_balance" placeholder="0" min="0"></div>
                            </div>
                        </div>
                    </div>

                    {{-- Guarantor --}}
                    <div class="cv2-card">
                        <div class="cv2-card-h"><h3>Guarantor</h3></div>
                        <div class="cv2-card-b">
                            <div class="cv2-form-grid">
                                <div class="cv2-field"><label class="cv2-label">Guarantor Name <span class="req">*</span></label><input type="text" name="guarantor_name" placeholder="Guarantor full name"></div>
                                <div class="cv2-field"><label class="cv2-label">Guarantor Phone <span class="req">*</span></label><input type="tel" name="guarantor_phone" data-intl-phone="1" placeholder="98640 11223"></div>
                            </div>
                        </div>
                    </div>

                    {{-- Emergency contacts --}}
                    <div class="cv2-card">
                        <div class="cv2-card-h"><h3>Emergency Contacts <span class="cv2-pill" style="font-weight:600;">At least 1</span></h3>
                            <a href="javascript:void(0)" class="cv2-link" id="cv2AddPerson"><i class="bi bi-plus-lg"></i> Add another</a></div>
                        <div class="cv2-card-b" id="cv2PersonWrap">
                            <div class="cv2-repeat-row">
                                <div class="cv2-form-grid is-3">
                                    <div class="cv2-field"><label class="cv2-label">Name <span class="req">*</span></label><input type="text" placeholder="Person name"></div>
                                    <div class="cv2-field"><label class="cv2-label">Relation <span class="req">*</span></label><input type="text" placeholder="e.g. Brother"></div>
                                    <div class="cv2-field"><label class="cv2-label">Blood Group</label><input type="text" placeholder="O+"></div>
                                    <div class="cv2-field"><label class="cv2-label">Phone <span class="req">*</span></label><input type="tel" data-intl-phone="1" placeholder="98640 11223"></div>
                                    <div class="cv2-field"><label class="cv2-label">WhatsApp</label><input type="tel" data-intl-phone="1" placeholder="98640 11223"></div>
                                    <div class="cv2-field"><label class="cv2-label">Address</label><input type="text" placeholder="Optional"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Comment --}}
                    <div class="cv2-card">
                        <div class="cv2-card-h"><h3>Comment</h3></div>
                        <div class="cv2-card-b">
                            <div class="cv2-field"><label class="cv2-label">Note</label><input type="text" name="contact_comment" placeholder="Optional note" maxlength="255"></div>
                        </div>
                    </div>

                </div>

                {{-- Right rail --}}
                <div>
                    <div class="cv2-card">
                        <div class="cv2-card-h"><h3>Status</h3></div>
                        <div class="cv2-card-b">
                            <div class="cv2-field"><label class="cv2-label">Driver Status</label>
                                <select class="cv2-select" id="cv2Status" name="status" style="width:100%;"><option>Active</option><option>Inactive</option><option>Blacklisted</option></select>
                            </div>
                            <div class="cv2-field cv2-mt"><label class="cv2-label">RAG Status</label>
                                <select class="cv2-select" name="rag_status" style="width:100%;"><option value="">Choose…</option><option>Green</option><option>Yellow</option><option>Red</option></select>
                            </div>

                            {{-- status_type conditional (when Inactive) --}}
                            <div id="cv2StatusTypeWrap" style="display:none;">
                                <div class="cv2-field cv2-mt"><label class="cv2-label">Status Type <span class="req">*</span></label>
                                    <div class="cv2-radio-group">
                                        <span class="cv2-radio"><input type="radio" name="status_type" id="st_leave" value="On Leave"><label for="st_leave">On Leave</label></span>
                                        <span class="cv2-radio"><input type="radio" name="status_type" id="st_vexit" value="Voluntary Exit"><label for="st_vexit">Voluntary Exit</label></span>
                                    </div>
                                </div>
                                <div class="cv2-field cv2-mt cv2-cond" data-st="On Leave" style="display:none;"><label class="cv2-label">Expected Return Date <span class="req">*</span></label><input type="date" name="expected_return_date"></div>
                                <div class="cv2-field cv2-mt cv2-cond" data-st="On Leave" style="display:none;"><label class="cv2-label">Set Reminder</label>
                                    <div class="cv2-radio-group">
                                        <span class="cv2-radio"><input type="radio" name="set_reminder" id="sr_yes" value="Yes"><label for="sr_yes">Yes</label></span>
                                        <span class="cv2-radio"><input type="radio" name="set_reminder" id="sr_no" value="No"><label for="sr_no">No</label></span>
                                    </div>
                                </div>
                                <div class="cv2-field cv2-mt cv2-cond" data-st="Voluntary Exit" style="display:none;"><label class="cv2-label">Voluntary Exit Reason <span class="req">*</span></label><textarea name="voluntary_exit_reason" rows="2"></textarea></div>
                                <div class="cv2-field cv2-mt cv2-cond" data-st="Voluntary Exit" style="display:none;"><label class="cv2-label">Vehicle Photos <span class="req">*</span></label><div class="cv2-dropzone" style="padding:16px;"><i class="bi bi-images"></i>Upload vehicle handover photos</div></div>
                            </div>

                            {{-- blacklist conditional --}}
                            <div class="cv2-field cv2-mt" id="cv2BlacklistWrap" style="display:none;"><label class="cv2-label">Blacklist Reason <span class="req">*</span></label><textarea name="blacklist_reason" rows="3" placeholder="Why is this driver being blacklisted?"></textarea></div>
                        </div>
                    </div>

                    <div class="cv2-card cv2-mt">
                        <div class="cv2-card-h"><h3>Available after saving</h3></div>
                        <div class="cv2-card-b" style="display:flex;flex-direction:column;gap:10px;">
                            <div class="cv2-locked"><i class="bi bi-lock"></i><div><b>Joining</b><div class="cv2-hint">Work experience &amp; joining letter</div></div></div>
                            <div class="cv2-locked"><i class="bi bi-lock"></i><div><b>Documents</b><div class="cv2-hint">Additional attachments</div></div></div>
                            <div class="cv2-locked"><i class="bi bi-lock"></i><div><b>Assets</b><div class="cv2-hint">Issued equipment</div></div></div>
                            <div class="cv2-locked"><i class="bi bi-lock"></i><div><b>Driver Bhatta</b><div class="cv2-hint">Trip allowance ledger</div></div></div>
                            <div class="cv2-locked"><i class="bi bi-lock"></i><div><b>Exit</b><div class="cv2-hint">Exit details &amp; relieving letter</div></div></div>
                        </div>
                    </div>

                    <div class="cv2-card cv2-mt">
                        <div class="cv2-card-b" style="display:flex;flex-direction:column;gap:10px;">
                            <button type="submit" form="cv2DriverForm" class="cv2-btn cv2-btn-primary cv2-btn-lg" style="justify-content:center;"><i class="bi bi-check2"></i>Save Driver</button>
                            <a href="{{ route('contact.v2.driver.index') }}" class="cv2-btn cv2-btn-ghost" style="justify-content:center;">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
            </form>

        </div>
    </div>
</div>
@endsection

@section('js')<script src="{{ asset('js/V2/driver.js?v=1.0') }}"></script>@endsection
