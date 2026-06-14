@extends('layouts.app')
@section('css')<link href="{{ asset('css/V2/customer.css?v=1.3') }}" rel="stylesheet">@endsection
@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="cv2-wrap"><div class="cv2-container">
        <div class="cv2-phead">
            <div class="cv2-crumb"><a href="{{ route('contact.v2.customer.index') }}">Customers</a> · {{ $c['name'] }} · Edit Info</div>
        </div>
        @include('V2.customer.partials.workspace-head')

        <form id="cv2EditForm" action="javascript:void(0)" class="cv2-mt">
        <div class="cv2-grid cv2-grid-2-1">
            <div style="display:flex;flex-direction:column;gap:16px;">

                {{-- Basic --}}
                <div class="cv2-card">
                    <div class="cv2-card-h"><h3>Basic Information</h3></div>
                    <div class="cv2-card-b"><div class="cv2-form-grid">
                        <div class="cv2-field is-full"><label class="cv2-label">GST Number <span class="req">*</span></label><input type="text" value="{{ $c['gst'] }}"></div>
                        <div class="cv2-field"><label class="cv2-label">Customer Name <span class="req">*</span></label><input type="text" value="{{ $c['name'] }}"></div>
                        <div class="cv2-field"><label class="cv2-label">About Type <span class="req">*</span></label><select class="cv2-select" style="width:100%;"><option>{{ $c['type'] }}</option><option>FMCG</option><option>Cement</option><option>Steel</option><option>Retail</option></select></div>
                        <div class="cv2-field"><label class="cv2-label">Size</label><select class="cv2-select" style="width:100%;"><option>{{ $c['size'] }}</option><option>Small</option><option>Medium</option><option>Large</option></select></div>
                        <div class="cv2-field"><label class="cv2-label">Comment</label><input type="text" value="Priority account" placeholder="Optional note"></div>
                    </div></div>
                </div>

                {{-- Contact details --}}
                <div class="cv2-card">
                    <div class="cv2-card-h"><h3>Contact Details</h3></div>
                    <div class="cv2-card-b"><div class="cv2-form-grid">
                        <div class="cv2-field"><label class="cv2-label">Phone <span class="req">*</span></label><input type="tel" data-intl-phone="1" value="{{ $c['phone'] }}"></div>
                        <div class="cv2-field"><label class="cv2-label">WhatsApp</label><input type="tel" data-intl-phone="1" value="{{ $c['phone'] }}"></div>
                        <div class="cv2-field is-full"><label class="cv2-label">Email</label><input type="email" value="{{ $c['email'] }}"></div>
                    </div></div>
                </div>

                {{-- Head office address --}}
                <div class="cv2-card">
                    <div class="cv2-card-h"><h3>Head Office Address</h3></div>
                    <div class="cv2-card-b"><div class="cv2-form-grid">
                        <div class="cv2-field is-full"><label class="cv2-label">Address</label><textarea rows="2" maxlength="100">Beltola Industrial Area, Plot 14</textarea></div>
                        <div class="cv2-field"><label class="cv2-label">State</label><select class="cv2-select" style="width:100%;"><option>Assam</option><option>West Bengal</option></select></div>
                        <div class="cv2-field"><label class="cv2-label">City</label><select class="cv2-select" style="width:100%;"><option>{{ $c['city'] }}</option><option>Guwahati</option><option>Dibrugarh</option></select></div>
                        <div class="cv2-field"><label class="cv2-label">Postal Code</label><input type="text" value="781028" maxlength="6"></div>
                        <div class="cv2-field"><label class="cv2-label">Map Location</label><input type="text" value="https://maps.app/abc123" placeholder="Paste map link"></div>
                        <div class="cv2-field is-full" style="background:var(--cv2-soft);border:1px solid var(--cv2-line);border-radius:10px;padding:12px 14px;">
                            <label class="cv2-label" style="display:flex;align-items:center;gap:8px;"><input type="checkbox" checked style="width:auto;"> Halting deduction chargeable</label>
                            <input type="number" value="1500" placeholder="Halting charges / day (₹)" style="margin-top:8px;">
                        </div>
                    </div></div>
                </div>

                {{-- Billing address --}}
                <div class="cv2-card">
                    <div class="cv2-card-h"><h3>Billing Address <span class="cv2-pill" style="font-weight:600;">Optional</span></h3></div>
                    <div class="cv2-card-b"><div class="cv2-form-grid">
                        <div class="cv2-field"><label class="cv2-label">Country</label><select class="cv2-select" style="width:100%;"><option>India</option></select></div>
                        <div class="cv2-field"><label class="cv2-label">State</label><select class="cv2-select" style="width:100%;"><option>Assam</option></select></div>
                        <div class="cv2-field"><label class="cv2-label">City</label><select class="cv2-select" style="width:100%;"><option>{{ $c['city'] }}</option></select></div>
                        <div class="cv2-field"><label class="cv2-label">Postal Code</label><input type="text" value="781028"></div>
                        <div class="cv2-field is-full"><label class="cv2-label">Billing Address</label><textarea rows="2">Same as head office</textarea></div>
                        <div class="cv2-field is-full"><label class="cv2-label">Additional Info</label><input type="text" value="GSTIN on invoice" placeholder="GSTIN note, attention, etc."></div>
                    </div></div>
                </div>

                {{-- Contact persons --}}
                <div class="cv2-card">
                    <div class="cv2-card-h"><h3>Contact Persons <span class="cv2-pill" style="font-weight:600;">At least 1</span></h3>
                        <a href="javascript:void(0)" class="cv2-link" id="cv2AddPerson"><i class="bi bi-plus-lg"></i> Add another</a></div>
                    <div class="cv2-card-b" id="cv2PersonWrap">
                        <div class="cv2-repeat-row">
                            <div class="cv2-form-grid is-3">
                                <div class="cv2-field"><label class="cv2-label">Name <span class="req">*</span></label><input type="text" value="Rakesh Sharma"></div>
                                <div class="cv2-field"><label class="cv2-label">Designation</label><input type="text" value="Purchase Head"></div>
                                <div class="cv2-field"><label class="cv2-label">Phone <span class="req">*</span></label><input type="tel" data-intl-phone="1" value="+91 98640 11223"></div>
                                <div class="cv2-field"><label class="cv2-label">WhatsApp</label><input type="tel" data-intl-phone="1" value="+91 98640 11223"></div>
                                <div class="cv2-field"><label class="cv2-label">Email</label><input type="email" value="rakesh@sudhirsen.in"></div>
                                <div class="cv2-field"><label class="cv2-label">Comment</label><input type="text" placeholder="Optional"></div>
                            </div>
                        </div>
                        <div class="cv2-repeat-row">
                            <button type="button" class="cv2-remove" title="Remove"><i class="bi bi-x-lg"></i></button>
                            <div class="cv2-form-grid is-3">
                                <div class="cv2-field"><label class="cv2-label">Name <span class="req">*</span></label><input type="text" value="Anita Das"></div>
                                <div class="cv2-field"><label class="cv2-label">Designation</label><input type="text" value="Accounts"></div>
                                <div class="cv2-field"><label class="cv2-label">Phone <span class="req">*</span></label><input type="tel" data-intl-phone="1" value="+91 90853 44120"></div>
                                <div class="cv2-field"><label class="cv2-label">WhatsApp</label><input type="tel" data-intl-phone="1" value="+91 90853 44120"></div>
                                <div class="cv2-field"><label class="cv2-label">Email</label><input type="email" value="anita@sudhirsen.in"></div>
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
                        <div class="cv2-field"><label class="cv2-label">Customer Status</label>
                            <select class="cv2-select" id="cv2Status" style="width:100%;">
                                <option {{ $c['status']=='Active'?'selected':'' }}>Active</option>
                                <option {{ $c['status']=='Inactive'?'selected':'' }}>Inactive</option>
                                <option {{ $c['status']=='Blacklisted'?'selected':'' }}>Blacklisted</option>
                            </select>
                        </div>
                        <div class="cv2-field cv2-mt" id="cv2BlacklistWrap" style="{{ $c['status']=='Blacklisted'?'':'display:none;' }}">
                            <label class="cv2-label">Blacklist Reason <span class="req">*</span></label>
                            <textarea rows="3" placeholder="Why is this customer being blacklisted?"></textarea>
                            <span class="cv2-hint">A blacklist note is logged to the activity trail.</span>
                        </div>
                    </div>
                </div>
                <div class="cv2-card cv2-mt">
                    <div class="cv2-card-h"><h3>Documents</h3></div>
                    <div class="cv2-card-b">
                        <div class="cv2-locked"><i class="bi bi-paperclip"></i><div><b>{{ $counts['documents'] }} documents</b><div class="cv2-hint">Managed on the Documents page</div></div></div>
                        <a href="{{ route('contact.v2.customer.documents', $c['id']) }}" class="cv2-btn cv2-btn-ghost cv2-mt" style="width:100%;justify-content:center;"><i class="bi bi-folder2-open"></i>Open Documents</a>
                    </div>
                </div>
                <div class="cv2-card cv2-mt"><div class="cv2-card-b" style="display:flex;flex-direction:column;gap:10px;">
                    <button type="submit" class="cv2-btn cv2-btn-primary" style="justify-content:center;"><i class="bi bi-check2"></i>Save Changes</button>
                    <a href="{{ route('contact.v2.customer.show', $c['id']) }}" class="cv2-btn cv2-btn-ghost" style="justify-content:center;">Cancel</a>
                </div></div>
            </div>
        </div>
        </form>
    </div></div>
</div>
@endsection
@section('js')<script src="{{ asset('js/V2/customer.js?v=1.3') }}"></script>@endsection
