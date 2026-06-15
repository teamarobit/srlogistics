@extends('layouts.app')
@section('css')<link href="{{ asset('css/V2/vehiclevendor.css?v=1.0') }}" rel="stylesheet">@endsection
@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="cv2-wrap"><div class="cv2-container">
        <div class="cv2-phead">
            <div class="cv2-crumb"><a href="{{ route('contact.v2.vehiclevendor.index') }}">Vehicle Vendors</a> · {{ $v['company'] }} · Edit Info</div>
        </div>
        @include('V2.vehiclevendor.partials.workspace-head')

        <form id="cv2EditForm" action="javascript:void(0)" class="cv2-mt">
        <div class="cv2-grid cv2-grid-2-1">
            <div style="display:flex;flex-direction:column;gap:16px;">

                {{-- Basic --}}
                <div class="cv2-card">
                    <div class="cv2-card-h"><h3>Basic Information</h3></div>
                    <div class="cv2-card-b"><div class="cv2-form-grid">
                        <div class="cv2-field"><label class="cv2-label">Company Name <span class="req">*</span></label><input type="text" value="{{ $v['company'] }}"></div>
                        <div class="cv2-field"><label class="cv2-label">Contact Name <span class="req">*</span></label><input type="text" value="{{ $v['name'] }}"></div>
                        <div class="cv2-field"><label class="cv2-label">Contact Code <span class="req">*</span></label><input type="text" value="{{ $v['code'] }}"></div>
                        <div class="cv2-field"><label class="cv2-label">No. of Vehicles</label><input type="number" value="{{ $v['vehicles'] }}" min="0"></div>
                        <div class="cv2-field"><label class="cv2-label">Size</label><select class="cv2-select" style="width:100%;"><option>{{ $v['size'] }}</option><option>Small</option><option>Medium</option><option>Large</option></select></div>
                        <div class="cv2-field"><label class="cv2-label">RAG Status</label><select class="cv2-select" style="width:100%;"><option>{{ $v['rag'] }}</option><option>Green</option><option>Yellow</option><option>Red</option></select></div>
                        <div class="cv2-field is-full"><label class="cv2-label">Comment</label><input type="text" placeholder="Optional note"></div>
                    </div></div>
                </div>

                {{-- Contact details --}}
                <div class="cv2-card">
                    <div class="cv2-card-h"><h3>Contact Details</h3></div>
                    <div class="cv2-card-b"><div class="cv2-form-grid">
                        <div class="cv2-field"><label class="cv2-label">Phone <span class="req">*</span></label><input type="tel" data-intl-phone="1" value="{{ $v['phone'] }}"></div>
                        <div class="cv2-field"><label class="cv2-label">WhatsApp</label><input type="tel" data-intl-phone="1" value="{{ $v['phone'] }}"></div>
                    </div></div>
                </div>

                {{-- Company & tax --}}
                <div class="cv2-card">
                    <div class="cv2-card-h"><h3>Company &amp; Tax Details</h3></div>
                    <div class="cv2-card-b"><div class="cv2-form-grid">
                        <div class="cv2-field"><label class="cv2-label">Full Company Name</label><input type="text" value="{{ $v['company'] }} Pvt Ltd"></div>
                        <div class="cv2-field"><label class="cv2-label">Vehicle Ownership Type</label><select class="cv2-select" style="width:100%;"><option>Owned</option><option>Leased</option><option>Mixed</option></select></div>
                        <div class="cv2-field"><label class="cv2-label">Company Owner</label><input type="text" value="{{ $v['owner'] }}"></div>
                        <div class="cv2-field"><label class="cv2-label">Company Registration No</label><input type="text" value="CIN-U60230AS2014PTC0{{ $v['id'] }}221"></div>
                        <div class="cv2-field"><label class="cv2-label">Company Registration Date</label><input type="date" value="2014-06-12"></div>
                        <div class="cv2-field"><label class="cv2-label">Working Since</label><input type="date" value="2018-04-01"></div>
                        <div class="cv2-field"><label class="cv2-label">PAN No</label><input type="text" value="AABCB7711P"></div>
                        <div class="cv2-field"><label class="cv2-label">PAN Status</label><select class="cv2-select" style="width:100%;"><option>Verified</option><option>Pending</option></select></div>
                        <div class="cv2-field"><label class="cv2-label">GST Treatment</label><select class="cv2-select" id="cv2GstTreatment" style="width:100%;"><option {{ $v['gst_treatment']=='Registered'?'selected':'' }}>Registered</option><option {{ $v['gst_treatment']=='Unregistered'?'selected':'' }}>Unregistered</option></select></div>
                        <div class="cv2-field" data-when="gst-registered" style="{{ $v['gst_treatment']=='Registered'?'':'display:none;' }}"><label class="cv2-label">GST Number <span class="req">*</span></label><input type="text" value="{{ $v['gst'] }}"></div>
                        <div class="cv2-field"><label class="cv2-label">TDS Percentage</label><input type="number" id="cv2Tds" value="{{ $v['tds'] }}" min="0" max="100" step="0.01"></div>
                    </div>
                    <div class="cv2-note is-warn cv2-mt" id="cv2TdsNote" style="{{ ($v['tds']===0||$v['tds']===1)?'':'display:none;' }}">
                        <i class="bi bi-exclamation-triangle"></i>
                        <div>Because TDS percentage is <b>0 or 1</b>, a <b>TDS Declaration</b> document (type 7) is mandatory. Manage it on the
                            <a href="{{ route('contact.v2.vehiclevendor.documents', $v['id']) }}" style="color:#7a5106;text-decoration:underline;">Documents</a> page.</div>
                    </div>
                    </div>
                </div>

                {{-- Address --}}
                <div class="cv2-card">
                    <div class="cv2-card-h"><h3>Address</h3></div>
                    <div class="cv2-card-b"><div class="cv2-form-grid">
                        <div class="cv2-field is-full"><label class="cv2-label">Address <span class="req">*</span></label><textarea rows="2" maxlength="1000">NH-37 Transport Nagar, Plot 22</textarea></div>
                        <div class="cv2-field"><label class="cv2-label">State <span class="req">*</span></label><select class="cv2-select" style="width:100%;"><option>Assam</option><option>West Bengal</option></select></div>
                        <div class="cv2-field"><label class="cv2-label">City <span class="req">*</span></label><select class="cv2-select" style="width:100%;"><option>{{ $v['city'] }}</option><option>Guwahati</option><option>Dibrugarh</option></select></div>
                        <div class="cv2-field"><label class="cv2-label">Postal Code <span class="req">*</span></label><input type="text" value="781001" maxlength="6"></div>
                        <div class="cv2-field is-full"><label class="cv2-label">Additional Info</label><textarea rows="2" maxlength="10000">Gate entry from bypass road</textarea></div>
                    </div></div>
                </div>

                {{-- Bank details (E3) --}}
                <div class="cv2-card">
                    <div class="cv2-card-h"><h3>Bank Details <span class="cv2-pill" style="font-weight:600;">Exactly 1 primary</span></h3>
                        <a href="javascript:void(0)" class="cv2-link" id="cv2AddBank"><i class="bi bi-plus-lg"></i> Add bank</a></div>
                    <div class="cv2-card-b" id="cv2BankWrap">
                        <div class="cv2-repeat-row cv2-bank-row is-primary">
                            <div class="cv2-form-grid is-3">
                                <div class="cv2-field"><label class="cv2-label">Bank <span class="req">*</span></label><select class="cv2-select" name="bank_id[]" style="width:100%;"><option>HDFC Bank</option><option>State Bank of India</option><option>ICICI Bank</option><option>Axis Bank</option></select></div>
                                <div class="cv2-field"><label class="cv2-label">Beneficiary Name</label><input type="text" name="beneficiary_name[]" value="{{ $v['company'] }}"></div>
                                <div class="cv2-field"><label class="cv2-label">Account Number <span class="req">*</span></label><input type="text" name="account_number[]" value="50100244112201"></div>
                                <div class="cv2-field"><label class="cv2-label">IFSC Code <span class="req">*</span></label><input type="text" name="ifsc_code[]" value="HDFC0001234"></div>
                                <div class="cv2-field"><label class="cv2-label">UPI ID</label><input type="text" name="upi_id[]" value="bccarriers@hdfc"></div>
                                <div class="cv2-field"><label class="cv2-label">Primary</label><label class="cv2-primary-flag"><input type="radio" name="is_primary[]" value="Yes" checked> Set as primary <span class="cv2-bank-badge">Primary</span></label></div>
                            </div>
                        </div>
                        <div class="cv2-repeat-row cv2-bank-row">
                            <button type="button" class="cv2-remove" title="Remove"><i class="bi bi-x-lg"></i></button>
                            <div class="cv2-form-grid is-3">
                                <div class="cv2-field"><label class="cv2-label">Bank <span class="req">*</span></label><select class="cv2-select" name="bank_id[]" style="width:100%;"><option>State Bank of India</option><option>HDFC Bank</option><option>ICICI Bank</option><option>Axis Bank</option></select></div>
                                <div class="cv2-field"><label class="cv2-label">Beneficiary Name</label><input type="text" name="beneficiary_name[]" value="{{ $v['owner'] }}"></div>
                                <div class="cv2-field"><label class="cv2-label">Account Number <span class="req">*</span></label><input type="text" name="account_number[]" value="33124577890"></div>
                                <div class="cv2-field"><label class="cv2-label">IFSC Code <span class="req">*</span></label><input type="text" name="ifsc_code[]" value="SBIN0007712"></div>
                                <div class="cv2-field"><label class="cv2-label">UPI ID</label><input type="text" name="upi_id[]" placeholder="name@bank"></div>
                                <div class="cv2-field"><label class="cv2-label">Primary</label><label class="cv2-primary-flag"><input type="radio" name="is_primary[]" value="Yes"> Set as primary <span class="cv2-bank-badge" style="display:none;">Primary</span></label></div>
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
                                <div class="cv2-field"><label class="cv2-label">Name <span class="req">*</span></label><input type="text" value="{{ $v['name'] }}"></div>
                                <div class="cv2-field"><label class="cv2-label">Designation <span class="req">*</span></label><input type="text" value="Fleet Manager"></div>
                                <div class="cv2-field"><label class="cv2-label">Phone <span class="req">*</span></label><input type="tel" data-intl-phone="1" value="{{ $v['phone'] }}"></div>
                                <div class="cv2-field"><label class="cv2-label">WhatsApp</label><input type="tel" data-intl-phone="1" value="{{ $v['phone'] }}"></div>
                                <div class="cv2-field"><label class="cv2-label">Email</label><input type="email" value="ops@vendor.in"></div>
                                <div class="cv2-field"><label class="cv2-label">Comment</label><input type="text" placeholder="Optional"></div>
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
                            <select class="cv2-select" id="cv2Status" style="width:100%;">
                                <option {{ $v['status']=='Active'?'selected':'' }}>Active</option>
                                <option {{ $v['status']=='Inactive'?'selected':'' }}>Inactive</option>
                                <option {{ $v['status']=='Blacklisted'?'selected':'' }}>Blacklisted</option>
                            </select>
                        </div>
                        <div class="cv2-field cv2-mt" id="cv2BlacklistWrap" style="{{ $v['status']=='Blacklisted'?'':'display:none;' }}">
                            <label class="cv2-label">Blacklist Reason <span class="req">*</span></label>
                            <textarea rows="3" placeholder="Why is this vendor being blacklisted?"></textarea>
                            <span class="cv2-hint">A blacklist note is logged to the activity trail.</span>
                        </div>
                    </div>
                </div>
                <div class="cv2-card cv2-mt">
                    <div class="cv2-card-h"><h3>Documents</h3></div>
                    <div class="cv2-card-b">
                        <div class="cv2-locked"><i class="bi bi-paperclip"></i><div><b>{{ $counts['documents'] }} documents</b><div class="cv2-hint">Managed on the Documents page</div></div></div>
                        <a href="{{ route('contact.v2.vehiclevendor.documents', $v['id']) }}" class="cv2-btn cv2-btn-ghost cv2-mt" style="width:100%;justify-content:center;"><i class="bi bi-folder2-open"></i>Open Documents</a>
                    </div>
                </div>
                <div class="cv2-card cv2-mt"><div class="cv2-card-b" style="display:flex;flex-direction:column;gap:10px;">
                    <button type="submit" class="cv2-btn cv2-btn-primary" style="justify-content:center;"><i class="bi bi-check2"></i>Save Changes</button>
                    <a href="{{ route('contact.v2.vehiclevendor.show', $v['id']) }}" class="cv2-btn cv2-btn-ghost" style="justify-content:center;">Cancel</a>
                </div></div>
            </div>
        </div>
        </form>
    </div></div>
</div>
@endsection
@section('js')<script src="{{ asset('js/V2/vehiclevendor.js?v=1.0') }}"></script>@endsection
