@extends('layouts.app')
@section('css')<link href="{{ asset('css/V2/driver.css?v=1.0') }}" rel="stylesheet">@endsection
@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="cv2-wrap"><div class="cv2-container">
        <div class="cv2-phead"><div class="cv2-crumb"><a href="{{ route('contact.v2.driver.index') }}">Drivers</a> · {{ $d['name'] }} · Edit Info</div></div>
        @include('V2.driver.partials.workspace-head')

        <form id="cv2EditForm" action="javascript:void(0)" class="cv2-mt">
        <div class="cv2-grid cv2-grid-2-1">
            <div style="display:flex;flex-direction:column;gap:16px;">

                {{-- Basic --}}
                <div class="cv2-card">
                    <div class="cv2-card-h"><h3>Basic Information</h3></div>
                    <div class="cv2-card-b"><div class="cv2-form-grid">
                        <div class="cv2-field"><label class="cv2-label">Driver Code <span class="req">*</span></label><input type="text" value="{{ $d['driver_code'] }}" readonly></div>
                        <div class="cv2-field"><label class="cv2-label">Driver Name <span class="req">*</span></label><input type="text" value="{{ $d['name'] }}"></div>
                        <div class="cv2-field"><label class="cv2-label">Driver Category <span class="req">*</span></label><select class="cv2-select" style="width:100%;"><option>{{ $d['category'] }}</option><option>Local</option><option>Line</option></select></div>
                        <div class="cv2-field"><label class="cv2-label">Allocate Vehicle</label><select class="cv2-select" style="width:100%;"><option>{{ $d['vehicle'] }}</option><option>AS01GC4471</option><option>AS01HC2210</option></select><span class="cv2-hint">Change vehicle logs a reason + re-allocates.</span></div>
                        <div class="cv2-field"><label class="cv2-label">Blood Group</label><select class="cv2-select" style="width:100%;"><option>{{ $d['blood_group'] }}</option><option>A+</option><option>O+</option><option>B+</option></select></div>
                        <div class="cv2-field"><label class="cv2-label">Date of Joining <span class="req">*</span></label><input type="text" value="{{ $d['doj'] }}"></div>
                    </div></div>
                </div>

                {{-- Contact --}}
                <div class="cv2-card">
                    <div class="cv2-card-h"><h3>Contact Details</h3></div>
                    <div class="cv2-card-b"><div class="cv2-form-grid">
                        <div class="cv2-field"><label class="cv2-label">Phone <span class="req">*</span></label><input type="tel" data-intl-phone="1" value="{{ $d['phone'] }}"></div>
                        <div class="cv2-field"><label class="cv2-label">WhatsApp</label><input type="tel" data-intl-phone="1" value="{{ $d['whatsapp'] }}"></div>
                    </div></div>
                </div>

                {{-- Licence & Identity --}}
                <div class="cv2-card">
                    <div class="cv2-card-h"><h3>Licence &amp; Identity</h3></div>
                    <div class="cv2-card-b"><div class="cv2-form-grid">
                        <div class="cv2-field"><label class="cv2-label">Driving Licence No <span class="req">*</span></label><input type="text" value="{{ $d['licence_no'] }}"></div>
                        <div class="cv2-field"><label class="cv2-label">Licence Expiry Date <span class="req">*</span></label><input type="text" value="{{ $d['licence_expiry'] }}"></div>
                        <div class="cv2-field"><label class="cv2-label">Aadhaar No <span class="req">*</span></label><input type="text" value="{{ $d['aadhaar'] }}"></div>
                        <div class="cv2-field"><label class="cv2-label">Re-upload Proofs</label><div class="cv2-dropzone" style="padding:16px;"><i class="bi bi-cloud-arrow-up"></i>Optional — only if replacing</div></div>
                    </div></div>
                </div>

                {{-- Permanent + Present (E5) --}}
                <div class="cv2-card">
                    <div class="cv2-card-h"><h3>Permanent Address</h3></div>
                    <div class="cv2-card-b"><div class="cv2-form-grid">
                        <div class="cv2-field is-full"><label class="cv2-label">Address <span class="req">*</span></label><textarea rows="2" maxlength="255">Village Rangia, Ward 4</textarea></div>
                        <div class="cv2-field"><label class="cv2-label">State <span class="req">*</span></label><select class="cv2-select" style="width:100%;"><option>Assam</option></select></div>
                        <div class="cv2-field"><label class="cv2-label">City</label><select class="cv2-select" style="width:100%;"><option>Guwahati</option></select></div>
                        <div class="cv2-field"><label class="cv2-label">Postal Code <span class="req">*</span></label><input type="text" value="781354" maxlength="6"></div>
                    </div></div>
                </div>
                <div class="cv2-card">
                    <div class="cv2-card-h"><h3>Present Address</h3>
                        <label class="cv2-primary-pick"><input type="checkbox" id="cv2SameAsPermanent"> Same as permanent</label></div>
                    <div class="cv2-card-b" id="cv2PresentWrap"><div class="cv2-form-grid">
                        <div class="cv2-field is-full"><label class="cv2-label">Address <span class="req">*</span></label><textarea rows="2" maxlength="255">Hatigaon, Guwahati</textarea></div>
                        <div class="cv2-field"><label class="cv2-label">State <span class="req">*</span></label><select class="cv2-select" style="width:100%;"><option>Assam</option></select></div>
                        <div class="cv2-field"><label class="cv2-label">City</label><select class="cv2-select" style="width:100%;"><option>Guwahati</option></select></div>
                        <div class="cv2-field"><label class="cv2-label">Postal Code <span class="req">*</span></label><input type="text" value="781038" maxlength="6"></div>
                    </div></div>
                </div>

                {{-- Bank (E3) --}}
                <div class="cv2-card">
                    <div class="cv2-card-h"><h3>Bank Details <span class="cv2-pill" style="font-weight:600;">Exactly one primary</span></h3>
                        <a href="javascript:void(0)" class="cv2-link" id="cv2AddBank"><i class="bi bi-plus-lg"></i> Add bank</a></div>
                    <div class="cv2-card-b" id="cv2BankWrap">
                        <div class="cv2-bank-row">
                            <div class="cv2-bank-head">
                                <label class="cv2-primary-pick"><input type="radio" name="is_primary_pick" checked> Set as primary account</label>
                                <span class="cv2-primary-tag">Primary</span>
                            </div>
                            <div class="cv2-form-grid is-3">
                                <div class="cv2-field"><label class="cv2-label">Bank <span class="req">*</span></label><select class="cv2-select" style="width:100%;"><option>SBI</option><option>HDFC</option><option>ICICI</option><option>Axis</option></select></div>
                                <div class="cv2-field"><label class="cv2-label">Beneficiary Name</label><input type="text" value="{{ $d['name'] }}"></div>
                                <div class="cv2-field"><label class="cv2-label">Account Number <span class="req">*</span></label><input type="text" value="003301004471"></div>
                                <div class="cv2-field"><label class="cv2-label">IFSC Code <span class="req">*</span></label><input type="text" value="SBIN0003301"></div>
                                <div class="cv2-field"><label class="cv2-label">UPI ID</label><input type="text" value="ramesh@sbi"></div>
                            </div>
                        </div>
                        <div class="cv2-bank-row">
                            <button type="button" class="cv2-remove" title="Remove bank"><i class="bi bi-x-lg"></i></button>
                            <div class="cv2-bank-head">
                                <label class="cv2-primary-pick"><input type="radio" name="is_primary_pick"> Set as primary account</label>
                            </div>
                            <div class="cv2-form-grid is-3">
                                <div class="cv2-field"><label class="cv2-label">Bank <span class="req">*</span></label><select class="cv2-select" style="width:100%;"><option>HDFC</option><option>SBI</option><option>ICICI</option></select></div>
                                <div class="cv2-field"><label class="cv2-label">Beneficiary Name</label><input type="text" value="{{ $d['name'] }}"></div>
                                <div class="cv2-field"><label class="cv2-label">Account Number <span class="req">*</span></label><input type="text" value="501000228890"></div>
                                <div class="cv2-field"><label class="cv2-label">IFSC Code <span class="req">*</span></label><input type="text" value="HDFC0000456"></div>
                                <div class="cv2-field"><label class="cv2-label">UPI ID</label><input type="text" value=""></div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Bhatta + Guarantor --}}
                <div class="cv2-card">
                    <div class="cv2-card-h"><h3>Bhatta, Hisab &amp; Guarantor</h3></div>
                    <div class="cv2-card-b"><div class="cv2-form-grid">
                        <div class="cv2-field"><label class="cv2-label">Hisab Category</label>
                            <div class="cv2-radio-group">
                                <span class="cv2-radio"><input type="radio" name="hisab_category" id="ehc_fixed" value="Fixed" {{ $d['hisab']=='Fixed'?'checked':'' }}><label for="ehc_fixed">Fixed</label></span>
                                <span class="cv2-radio"><input type="radio" name="hisab_category" id="ehc_fuel" value="Fuel" {{ $d['hisab']=='Fuel'?'checked':'' }}><label for="ehc_fuel">Fuel</label></span>
                            </div>
                        </div>
                        <div class="cv2-field"><label class="cv2-label">Opening Balance (₹)</label><input type="number" value="0"><span class="cv2-hint">Opening balance is immutable after first bhatta entry.</span></div>
                        <div class="cv2-field"><label class="cv2-label">Guarantor Name <span class="req">*</span></label><input type="text" value="{{ $d['guarantor'] }}"></div>
                        <div class="cv2-field"><label class="cv2-label">Guarantor Phone <span class="req">*</span></label><input type="tel" data-intl-phone="1" value="{{ $d['guarantor_phone'] }}"></div>
                    </div></div>
                </div>

            </div>

            {{-- Right rail --}}
            <div>
                <div class="cv2-card">
                    <div class="cv2-card-h"><h3>Status</h3></div>
                    <div class="cv2-card-b">
                        <div class="cv2-field"><label class="cv2-label">Driver Status</label>
                            <select class="cv2-select" id="cv2Status" style="width:100%;">
                                <option {{ $d['status']=='Active'?'selected':'' }}>Active</option>
                                <option {{ $d['status']=='Inactive'?'selected':'' }}>Inactive</option>
                                <option {{ $d['status']=='Blacklisted'?'selected':'' }}>Blacklisted</option>
                            </select>
                        </div>
                        <div class="cv2-field cv2-mt"><label class="cv2-label">RAG Status</label>
                            <select class="cv2-select" style="width:100%;">
                                <option {{ $d['rag']=='Green'?'selected':'' }}>Green</option>
                                <option {{ $d['rag']=='Yellow'?'selected':'' }}>Yellow</option>
                                <option {{ $d['rag']=='Red'?'selected':'' }}>Red</option>
                            </select>
                        </div>
                        <div id="cv2StatusTypeWrap" style="display:none;">
                            <div class="cv2-field cv2-mt"><label class="cv2-label">Status Type <span class="req">*</span></label>
                                <div class="cv2-radio-group">
                                    <span class="cv2-radio"><input type="radio" name="status_type" id="est_leave" value="On Leave"><label for="est_leave">On Leave</label></span>
                                    <span class="cv2-radio"><input type="radio" name="status_type" id="est_vexit" value="Voluntary Exit"><label for="est_vexit">Voluntary Exit</label></span>
                                </div>
                            </div>
                            <div class="cv2-field cv2-mt cv2-cond" data-st="On Leave" style="display:none;"><label class="cv2-label">Expected Return Date</label><input type="date"></div>
                            <div class="cv2-field cv2-mt cv2-cond" data-st="Voluntary Exit" style="display:none;"><label class="cv2-label">Voluntary Exit Reason</label><textarea rows="2"></textarea></div>
                        </div>
                        <div class="cv2-field cv2-mt" id="cv2BlacklistWrap" style="display:none;"><label class="cv2-label">Blacklist Reason <span class="req">*</span></label><textarea rows="3" placeholder="Reason"></textarea></div>
                    </div>
                </div>
                <div class="cv2-card cv2-mt">
                    <div class="cv2-card-h"><h3>Emergency Contacts</h3></div>
                    <div class="cv2-card-b">
                        <div class="cv2-locked"><i class="bi bi-people"></i><div><b>2 contacts on file</b><div class="cv2-hint">Edit in the full form section</div></div></div>
                    </div>
                </div>
                <div class="cv2-card cv2-mt"><div class="cv2-card-b" style="display:flex;flex-direction:column;gap:10px;">
                    <button type="submit" class="cv2-btn cv2-btn-primary" style="justify-content:center;"><i class="bi bi-check2"></i>Save Changes</button>
                    <a href="{{ route('contact.v2.driver.show', $d['id']) }}" class="cv2-btn cv2-btn-ghost" style="justify-content:center;">Cancel</a>
                </div></div>
            </div>
        </div>
        </form>
    </div></div>
</div>
@endsection
@section('js')<script src="{{ asset('js/V2/driver.js?v=1.0') }}"></script>@endsection
