@extends('layouts.app')
@section('css')<link href="{{ asset('css/V2/customer.css?v=1.4') }}" rel="stylesheet">@endsection
@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="cv2-wrap"><div class="cv2-container">
        <div class="cv2-phead">
            <div class="cv2-crumb"><a href="{{ route('contact.v2.batteryvendor.index') }}">Battery Vendors</a> · {{ $v['company'] }} · Edit Info</div>
        </div>
        @include('V2.batteryvendor.partials.workspace-head')

        <form id="cv2EditForm" action="javascript:void(0)" class="cv2-mt">
        <div class="cv2-grid cv2-grid-2-1">
            <div style="display:flex;flex-direction:column;gap:16px;">

                {{-- Basic --}}
                <div class="cv2-card">
                    <div class="cv2-card-h"><h3>Basic Information</h3></div>
                    <div class="cv2-card-b"><div class="cv2-form-grid">
                        <div class="cv2-field"><label class="cv2-label">GST Number <span class="req">*</span></label><input type="text" value="{{ $v['gst'] }}"><span class="cv2-help">Required for battery vendors.</span></div>
                        <div class="cv2-field"><label class="cv2-label">GST Treatment</label><input type="text" value="Registered" readonly><span class="cv2-help">Not editable for battery vendors.</span></div>
                        <div class="cv2-field"><label class="cv2-label">Company Name <span class="req">*</span></label><input type="text" value="{{ $v['company'] }}"></div>
                        <div class="cv2-field"><label class="cv2-label">Contact Name <span class="req">*</span></label><input type="text" value="{{ $v['name'] }}"></div>
                        <div class="cv2-field"><label class="cv2-label">Contact Code <span class="req">*</span></label><input type="text" value="{{ $v['code'] }}"></div>
                        <div class="cv2-field"><label class="cv2-label">No. of Vehicles</label><input type="number" value="{{ $v['vehicles'] }}" min="0"></div>
                        <div class="cv2-field is-full"><label class="cv2-label">Comment</label><input type="text" value="Priority supplier" placeholder="Optional note"></div>
                    </div></div>
                </div>

                {{-- Contact details --}}
                <div class="cv2-card">
                    <div class="cv2-card-h"><h3>Contact Details</h3></div>
                    <div class="cv2-card-b"><div class="cv2-form-grid">
                        <div class="cv2-field"><label class="cv2-label">Phone <span class="req">*</span></label><input type="tel" data-intl-phone="1" value="{{ $v['phone'] }}"></div>
                        <div class="cv2-field"><label class="cv2-label">WhatsApp</label><input type="tel" data-intl-phone="1" value="{{ $v['whatsapp'] }}"></div>
                    </div></div>
                </div>

                {{-- Company details --}}
                <div class="cv2-card">
                    <div class="cv2-card-h"><h3>Company Details <span class="cv2-pill" style="font-weight:600;">Optional</span></h3></div>
                    <div class="cv2-card-b"><div class="cv2-form-grid">
                        <div class="cv2-field"><label class="cv2-label">Full Company Name</label><input type="text" value="{{ $v['company'] }} Pvt Ltd"></div>
                        <div class="cv2-field"><label class="cv2-label">Company Owner</label><input type="text" value="{{ $v['name'] }}"></div>
                        <div class="cv2-field"><label class="cv2-label">Company Registration No</label><input type="text" value="REG-2019-0042"></div>
                        <div class="cv2-field"><label class="cv2-label">Company Registration Date</label><input type="date" value="2019-04-12"></div>
                        <div class="cv2-field"><label class="cv2-label">Working Since</label><input type="date" value="2020-06-01"></div>
                        <div class="cv2-field"><label class="cv2-label">PAN No</label><input type="text" value="ABCDE1234F"></div>
                        <div class="cv2-field"><label class="cv2-label">PAN Status</label><select class="cv2-select" style="width:100%;"><option>Linked</option><option>Not Linked</option><option>Pending</option></select></div>
                        <div class="cv2-field"><label class="cv2-label">TDS Percentage</label><input type="number" id="cv2Tds" step="0.01" min="0" max="100" value="{{ $v['tds'] }}"><span class="cv2-help">If 0 or 1, TDS Declaration upload is mandatory.</span></div>
                    </div>
                    <div class="cv2-note is-warn cv2-mt" id="cv2TdsNotice" style="{{ $v['tds'] <= 1 ? '' : 'display:none;' }}">
                        <i class="bi bi-exclamation-triangle"></i>
                        <div><b>TDS Declaration required.</b> TDS Percentage is 0 or 1 — ensure the TDS Declaration document is uploaded on the Documents page.</div>
                    </div>
                    </div>
                </div>

                {{-- Address --}}
                <div class="cv2-card">
                    <div class="cv2-card-h"><h3>Address</h3></div>
                    <div class="cv2-card-b"><div class="cv2-form-grid">
                        <div class="cv2-field is-full"><label class="cv2-label">Address <span class="req">*</span></label><textarea rows="2" maxlength="1000">GS Road, Industrial Estate, Plot 22</textarea></div>
                        <div class="cv2-field"><label class="cv2-label">State <span class="req">*</span></label><select class="cv2-select" style="width:100%;"><option>Assam</option><option>West Bengal</option></select></div>
                        <div class="cv2-field"><label class="cv2-label">City <span class="req">*</span></label><select class="cv2-select" style="width:100%;"><option>{{ $v['city'] }}</option><option>Guwahati</option><option>Dibrugarh</option></select></div>
                        <div class="cv2-field"><label class="cv2-label">Postal Code <span class="req">*</span></label><input type="text" value="781005" maxlength="6"></div>
                        <div class="cv2-field is-full"><label class="cv2-label">Additional Info</label><textarea rows="2">Supplies tubular &amp; SMF batteries.</textarea></div>
                    </div></div>
                </div>

                {{-- Bank details (E3) --}}
                <div class="cv2-card">
                    <div class="cv2-card-h"><h3>Bank Details <span class="cv2-pill" style="font-weight:600;">At least 1 · exactly 1 primary</span></h3>
                        <a href="javascript:void(0)" class="cv2-link" id="cv2AddBank"><i class="bi bi-plus-lg"></i> Add bank</a></div>
                    <div class="cv2-card-b" id="cv2BankWrap">
                        <div class="cv2-repeat-row">
                            <div class="cv2-form-grid is-3">
                                <div class="cv2-field"><label class="cv2-label">Bank <span class="req">*</span></label><select class="cv2-select" name="bank_id[]" style="width:100%;"><option>HDFC Bank</option><option>SBI</option><option>ICICI Bank</option><option>Axis Bank</option></select></div>
                                <div class="cv2-field"><label class="cv2-label">Account Number <span class="req">*</span></label><input type="text" value="50100234567890"></div>
                                <div class="cv2-field"><label class="cv2-label">IFSC Code <span class="req">*</span></label><input type="text" value="HDFC0001234"></div>
                                <div class="cv2-field"><label class="cv2-label">UPI ID</label><input type="text" value="amaron@hdfcbank"></div>
                                <div class="cv2-field"><label class="cv2-label">Primary</label><div class="cv2-radio-group"><span class="cv2-radio"><input type="radio" name="bank_primary" value="0" checked><label>Primary</label></span></div></div>
                            </div>
                        </div>
                        <div class="cv2-repeat-row">
                            <button type="button" class="cv2-remove" title="Remove"><i class="bi bi-x-lg"></i></button>
                            <div class="cv2-form-grid is-3">
                                <div class="cv2-field"><label class="cv2-label">Bank <span class="req">*</span></label><select class="cv2-select" name="bank_id[]" style="width:100%;"><option>SBI</option><option>HDFC Bank</option><option>ICICI Bank</option><option>Axis Bank</option></select></div>
                                <div class="cv2-field"><label class="cv2-label">Account Number <span class="req">*</span></label><input type="text" value="38291100456712"></div>
                                <div class="cv2-field"><label class="cv2-label">IFSC Code <span class="req">*</span></label><input type="text" value="SBIN0007788"></div>
                                <div class="cv2-field"><label class="cv2-label">UPI ID</label><input type="text" value="amaron@sbi"></div>
                                <div class="cv2-field"><label class="cv2-label">Primary</label><div class="cv2-radio-group"><span class="cv2-radio"><input type="radio" name="bank_primary" value="1"><label>Primary</label></span></div></div>
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
                                <div class="cv2-field"><label class="cv2-label">Designation</label><input type="text" value="Sales Head"></div>
                                <div class="cv2-field"><label class="cv2-label">Phone <span class="req">*</span></label><input type="tel" data-intl-phone="1" value="{{ $v['phone'] }}"></div>
                                <div class="cv2-field"><label class="cv2-label">WhatsApp</label><input type="tel" data-intl-phone="1" value="{{ $v['whatsapp'] }}"></div>
                                <div class="cv2-field"><label class="cv2-label">Email</label><input type="email" value="{{ $v['email'] }}"></div>
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
                        <a href="{{ route('contact.v2.batteryvendor.documents', $v['id']) }}" class="cv2-btn cv2-btn-ghost cv2-mt" style="width:100%;justify-content:center;"><i class="bi bi-folder2-open"></i>Open Documents</a>
                    </div>
                </div>
                <div class="cv2-card cv2-mt"><div class="cv2-card-b" style="display:flex;flex-direction:column;gap:10px;">
                    <button type="submit" class="cv2-btn cv2-btn-primary" style="justify-content:center;"><i class="bi bi-check2"></i>Save Changes</button>
                    <a href="{{ route('contact.v2.batteryvendor.show', $v['id']) }}" class="cv2-btn cv2-btn-ghost" style="justify-content:center;">Cancel</a>
                </div></div>
            </div>
        </div>
        </form>
    </div></div>
</div>
@endsection
@section('js')
<script src="{{ asset('js/V2/customer.js?v=1.3') }}"></script>
<script src="{{ asset('js/V2/batteryvendor.js?v=1.0') }}"></script>
@endsection
