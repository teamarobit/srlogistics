@extends('layouts.app')
@section('css')<link href="{{ asset('css/V2/customer.css?v=1.3') }}" rel="stylesheet">@endsection
@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="cv2-wrap"><div class="cv2-container">
        <div class="cv2-phead">
            <div class="cv2-crumb"><a href="{{ route('contact.v2.loadvendor.index') }}">Load Vendors</a> · {{ $v['company'] }} · Edit Info</div>
        </div>
        @include('V2.loadvendor.partials.workspace-head')

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
                        <div class="cv2-field"><label class="cv2-label">Alias</label><input type="text" value="{{ $v['alias'] }}"></div>
                        <div class="cv2-field"><label class="cv2-label">Size</label><select class="cv2-select" style="width:100%;"><option>{{ $v['size'] }}</option><option>Small</option><option>Medium</option><option>Large</option></select></div>
                        <div class="cv2-field"><label class="cv2-label">RAG Status</label><select class="cv2-select" style="width:100%;"><option>{{ $v['rag'] }}</option><option>Green</option><option>Yellow</option><option>Red</option></select></div>
                        <div class="cv2-field is-full"><label class="cv2-label">Comment</label><input type="text" value="Priority broker" placeholder="Optional note"></div>
                    </div></div>
                </div>

                {{-- Contact details --}}
                <div class="cv2-card">
                    <div class="cv2-card-h"><h3>Contact Details</h3></div>
                    <div class="cv2-card-b"><div class="cv2-form-grid">
                        <div class="cv2-field"><label class="cv2-label">Phone <span class="req">*</span></label><input type="tel" data-intl-phone="1" value="{{ $v['phone'] }}"></div>
                        <div class="cv2-field"><label class="cv2-label">WhatsApp</label><input type="tel" data-intl-phone="1" value="{{ $v['phone'] }}"></div>
                        <div class="cv2-field is-full"><label class="cv2-label">Email</label><input type="email" value="{{ $v['email'] }}"></div>
                    </div></div>
                </div>

                {{-- Head office address --}}
                <div class="cv2-card">
                    <div class="cv2-card-h"><h3>Head Office Address</h3></div>
                    <div class="cv2-card-b"><div class="cv2-form-grid">
                        <div class="cv2-field is-full"><label class="cv2-label">Address</label><textarea rows="2" maxlength="100">G.S. Road, Christian Basti</textarea></div>
                        <div class="cv2-field"><label class="cv2-label">State</label><select class="cv2-select" style="width:100%;"><option>Assam</option><option>West Bengal</option></select></div>
                        <div class="cv2-field"><label class="cv2-label">City</label><select class="cv2-select" style="width:100%;"><option>{{ $v['city'] }}</option><option>Guwahati</option><option>Dibrugarh</option></select></div>
                        <div class="cv2-field"><label class="cv2-label">Postal Code</label><input type="text" value="781005" maxlength="6"></div>
                        <div class="cv2-field"><label class="cv2-label">Map Location</label><input type="text" value="https://maps.app/lv123" placeholder="Paste map link"></div>
                    </div></div>
                </div>

                {{-- Contact persons --}}
                <div class="cv2-card">
                    <div class="cv2-card-h"><h3>Contact Persons <span class="cv2-pill" style="font-weight:600;">At least 1</span></h3>
                        <a href="javascript:void(0)" class="cv2-link" id="cv2AddPerson"><i class="bi bi-plus-lg"></i> Add another</a></div>
                    <div class="cv2-card-b" id="cv2PersonWrap">
                        <div class="cv2-repeat-row">
                            <div class="cv2-form-grid is-3">
                                <div class="cv2-field"><label class="cv2-label">Name <span class="req">*</span></label><input type="text" value="{{ $v['name'] }}"></div>
                                <div class="cv2-field"><label class="cv2-label">Designation <span class="req">*</span></label><input type="text" value="Owner / Broker"></div>
                                <div class="cv2-field"><label class="cv2-label">Phone <span class="req">*</span></label><input type="tel" data-intl-phone="1" value="{{ $v['phone'] }}"></div>
                                <div class="cv2-field"><label class="cv2-label">WhatsApp</label><input type="tel" data-intl-phone="1" value="{{ $v['phone'] }}"></div>
                                <div class="cv2-field"><label class="cv2-label">Email</label><input type="email" value="{{ $v['email'] }}"></div>
                                <div class="cv2-field"><label class="cv2-label">Comment</label><input type="text" placeholder="Optional"></div>
                            </div>
                        </div>
                        <div class="cv2-repeat-row">
                            <button type="button" class="cv2-remove" title="Remove"><i class="bi bi-x-lg"></i></button>
                            <div class="cv2-form-grid is-3">
                                <div class="cv2-field"><label class="cv2-label">Name <span class="req">*</span></label><input type="text" value="Pranab Kalita"></div>
                                <div class="cv2-field"><label class="cv2-label">Designation <span class="req">*</span></label><input type="text" value="Operations Manager"></div>
                                <div class="cv2-field"><label class="cv2-label">Phone <span class="req">*</span></label><input type="tel" data-intl-phone="1" value="+91 90853 44120"></div>
                                <div class="cv2-field"><label class="cv2-label">WhatsApp</label><input type="tel" data-intl-phone="1" value="+91 90853 44120"></div>
                                <div class="cv2-field"><label class="cv2-label">Email</label><input type="email" value="pranab@brahmaputracarriers.in"></div>
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
                        <div class="cv2-field"><label class="cv2-label">Load Vendor Status</label>
                            <select class="cv2-select" id="cv2Status" style="width:100%;">
                                <option {{ $v['status']=='Active'?'selected':'' }}>Active</option>
                                <option {{ $v['status']=='Inactive'?'selected':'' }}>Inactive</option>
                                <option {{ $v['status']=='Blacklisted'?'selected':'' }}>Blacklisted</option>
                            </select>
                        </div>
                        <div class="cv2-field cv2-mt" id="cv2BlacklistWrap" style="{{ $v['status']=='Blacklisted'?'':'display:none;' }}">
                            <label class="cv2-label">Blacklist Reason <span class="req">*</span></label>
                            <textarea rows="3" placeholder="Why is this load vendor being blacklisted?"></textarea>
                            <span class="cv2-hint">A blacklist note is logged to the activity trail.</span>
                        </div>
                    </div>
                </div>
                <div class="cv2-card cv2-mt">
                    <div class="cv2-card-h"><h3>Documents</h3></div>
                    <div class="cv2-card-b">
                        <div class="cv2-locked"><i class="bi bi-paperclip"></i><div><b>{{ $counts['documents'] }} documents</b><div class="cv2-hint">Managed on the Documents page</div></div></div>
                        <a href="{{ route('contact.v2.loadvendor.documents', $v['id']) }}" class="cv2-btn cv2-btn-ghost cv2-mt" style="width:100%;justify-content:center;"><i class="bi bi-folder2-open"></i>Open Documents</a>
                    </div>
                </div>
                <div class="cv2-card cv2-mt"><div class="cv2-card-b" style="display:flex;flex-direction:column;gap:10px;">
                    <button type="submit" class="cv2-btn cv2-btn-primary" style="justify-content:center;"><i class="bi bi-check2"></i>Save Changes</button>
                    <a href="{{ route('contact.v2.loadvendor.show', $v['id']) }}" class="cv2-btn cv2-btn-ghost" style="justify-content:center;">Cancel</a>
                </div></div>
            </div>
        </div>
        </form>
    </div></div>
</div>
@endsection
@section('js')<script src="{{ asset('js/V2/customer.js?v=1.3') }}"></script>@endsection
