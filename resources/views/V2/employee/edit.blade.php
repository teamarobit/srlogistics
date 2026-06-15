@extends('layouts.app')
@section('css')<link href="{{ asset('css/V2/employee.css?v=1.0') }}" rel="stylesheet">@endsection
@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="cv2-wrap"><div class="cv2-container">
        <div class="cv2-phead">
            <div class="cv2-crumb"><a href="{{ route('contact.v2.employee.index') }}">Employees</a> · {{ $e['name'] }} · Edit Info</div>
        </div>
        @include('V2.employee.partials.workspace-head')

        <form id="cv2EditForm" action="javascript:void(0)" class="cv2-mt">
        <div class="cv2-grid cv2-grid-2-1">
            <div style="display:flex;flex-direction:column;gap:16px;">

                {{-- Personal --}}
                <div class="cv2-card">
                    <div class="cv2-card-h"><h3>Personal Information</h3></div>
                    <div class="cv2-card-b"><div class="cv2-form-grid">
                        <div class="cv2-field"><label class="cv2-label">Employee Name <span class="req">*</span></label><input type="text" value="{{ $e['name'] }}"></div>
                        <div class="cv2-field"><label class="cv2-label">Gender <span class="req">*</span></label><select class="cv2-select" style="width:100%;"><option>{{ $e['gender'] }}</option><option>Male</option><option>Female</option><option>Other</option></select></div>
                        <div class="cv2-field"><label class="cv2-label">Date of Birth <span class="req">*</span></label><input type="date" value="1992-05-12"></div>
                        <div class="cv2-field"><label class="cv2-label">Date of Joining <span class="req">*</span></label><input type="date" value="{{ $e['doj'] }}"></div>
                        <div class="cv2-field"><label class="cv2-label">Blood Group <span class="req">*</span></label><select class="cv2-select" style="width:100%;"><option>{{ $e['blood_group'] }}</option><option>A+</option><option>O+</option><option>B+</option></select></div>
                        <div class="cv2-field"><label class="cv2-label">Religion <span class="req">*</span></label><select class="cv2-select" style="width:100%;"><option>Hindu</option><option>Muslim</option><option>Christian</option></select></div>
                        <div class="cv2-field"><label class="cv2-label">Reference By <span class="req">*</span></label><input type="text" value="Internal referral"></div>
                    </div></div>
                </div>

                {{-- Contact --}}
                <div class="cv2-card">
                    <div class="cv2-card-h"><h3>Contact Details</h3></div>
                    <div class="cv2-card-b"><div class="cv2-form-grid">
                        <div class="cv2-field"><label class="cv2-label">Phone <span class="req">*</span></label><input type="tel" data-intl-phone="1" value="{{ $e['phone'] }}"></div>
                        <div class="cv2-field"><label class="cv2-label">WhatsApp</label><input type="tel" data-intl-phone="1" value="{{ $e['phone'] }}"></div>
                        <div class="cv2-field is-full"><label class="cv2-label">Email</label><input type="email" value="{{ $e['email'] }}"></div>
                    </div></div>
                </div>

                {{-- Work assignment --}}
                <div class="cv2-card">
                    <div class="cv2-card-h"><h3>Work Assignment</h3></div>
                    <div class="cv2-card-b">
                        <div class="cv2-field" style="margin-bottom:12px;"><label class="cv2-label">Work Type <span class="req">*</span></label>
                            <div class="cv2-radio-group">
                                <span class="cv2-radio"><input type="radio" name="workType" id="ewt_office" value="Office Work" {{ $e['work_type']=='Office Work'?'checked':'' }}><label for="ewt_office">Office Work</label></span>
                                <span class="cv2-radio"><input type="radio" name="workType" id="ewt_sc" value="Service Center" {{ $e['work_type']=='Service Center'?'checked':'' }}><label for="ewt_sc">Service Center</label></span>
                            </div>
                        </div>
                        <div class="cv2-cond" data-wt="Office Work">
                            <div class="cv2-form-grid">
                                <div class="cv2-field"><label class="cv2-label">Office Branch <span class="req">*</span></label><select class="cv2-select" style="width:100%;"><option>{{ $e['branch'] }}</option><option>Guwahati HO</option></select></div>
                                <div class="cv2-field"><label class="cv2-label">Department <span class="req">*</span></label><select class="cv2-select" style="width:100%;"><option>{{ $e['department'] }}</option><option>Operations</option></select></div>
                                <div class="cv2-field"><label class="cv2-label">Designation <span class="req">*</span></label><select class="cv2-select" style="width:100%;"><option>{{ $e['designation'] }}</option></select></div>
                                <div class="cv2-field"><label class="cv2-label">Job Rank <span class="req">*</span></label><select class="cv2-select" style="width:100%;"><option>Senior</option><option>Junior</option></select></div>
                                <div class="cv2-field is-full"><label class="cv2-label">Roles <span class="req">*</span></label><select class="cv2-select" multiple style="width:100%;"><option selected>{{ $e['department'] }}</option><option>Reports</option></select></div>
                            </div>
                        </div>
                        <div class="cv2-cond" data-wt="Service Center">
                            <div class="cv2-form-grid">
                                <div class="cv2-field"><label class="cv2-label">Service Center Branch <span class="req">*</span></label><select class="cv2-select" style="width:100%;"><option>{{ $e['branch'] }}</option></select></div>
                                <div class="cv2-field"><label class="cv2-label">Department <span class="req">*</span></label><select class="cv2-select" style="width:100%;"><option>{{ $e['department'] }}</option></select></div>
                                <div class="cv2-field"><label class="cv2-label">Designation <span class="req">*</span></label><select class="cv2-select" style="width:100%;"><option>{{ $e['designation'] }}</option></select></div>
                                <div class="cv2-field"><label class="cv2-label">Service Type <span class="req">*</span></label>
                                    <div class="cv2-radio-group">
                                        <span class="cv2-radio"><input type="radio" name="service_type" id="est_adm" value="Administrative"><label for="est_adm">Administrative</label></span>
                                        <span class="cv2-radio"><input type="radio" name="service_type" id="est_tech" value="Technical" checked><label for="est_tech">Technical</label></span>
                                    </div>
                                </div>
                                <div class="cv2-field cv2-cond" data-st="Technical"><label class="cv2-label">Skillsets <span class="req">*</span></label><select class="cv2-select" multiple style="width:100%;"><option selected>Engine</option><option>Electrical</option></select></div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- E5 Permanent + Present --}}
                <div class="cv2-card">
                    <div class="cv2-card-h"><h3>Permanent Address</h3></div>
                    <div class="cv2-card-b"><div class="cv2-form-grid">
                        <div class="cv2-field is-full"><label class="cv2-label">Address <span class="req">*</span></label><textarea rows="2" maxlength="255">Vill. Beltola, Ward 14</textarea></div>
                        <div class="cv2-field"><label class="cv2-label">State <span class="req">*</span></label><select class="cv2-select" style="width:100%;"><option>Assam</option></select></div>
                        <div class="cv2-field"><label class="cv2-label">City</label><select class="cv2-select" style="width:100%;"><option>Guwahati</option></select></div>
                        <div class="cv2-field"><label class="cv2-label">Postal Code <span class="req">*</span></label><input type="text" value="781028" maxlength="6"></div>
                    </div></div>
                </div>
                <div class="cv2-card">
                    <div class="cv2-card-h"><h3>Present Address</h3></div>
                    <div class="cv2-card-b">
                        <label class="cv2-addr-toggle" style="margin-bottom:12px;"><input type="checkbox" id="cv2SameAddr"> Same as permanent address</label>
                        <div id="cv2PresentWrap"><div class="cv2-form-grid">
                            <div class="cv2-field is-full"><label class="cv2-label">Address <span class="req">*</span></label><textarea rows="2" maxlength="255">Six Mile, Near IT Park</textarea></div>
                            <div class="cv2-field"><label class="cv2-label">State <span class="req">*</span></label><select class="cv2-select" style="width:100%;"><option>Assam</option></select></div>
                            <div class="cv2-field"><label class="cv2-label">City</label><select class="cv2-select" style="width:100%;"><option>Guwahati</option></select></div>
                            <div class="cv2-field"><label class="cv2-label">Postal Code <span class="req">*</span></label><input type="text" value="781022" maxlength="6"></div>
                        </div></div>
                    </div>
                </div>

                {{-- Emergency contacts --}}
                <div class="cv2-card">
                    <div class="cv2-card-h"><h3>Emergency Contacts <span class="cv2-pill" style="font-weight:600;">At least 1</span></h3>
                        <a href="javascript:void(0)" class="cv2-link" id="cv2AddPerson"><i class="bi bi-plus-lg"></i> Add another</a></div>
                    <div class="cv2-card-b" id="cv2PersonWrap">
                        <div class="cv2-repeat-row">
                            <div class="cv2-form-grid is-3">
                                <div class="cv2-field"><label class="cv2-label">Name <span class="req">*</span></label><input type="text" value="Dibya Bordoloi"></div>
                                <div class="cv2-field"><label class="cv2-label">Relation</label><input type="text" value="Spouse"></div>
                                <div class="cv2-field"><label class="cv2-label">Blood Group</label><input type="text" value="O+"></div>
                                <div class="cv2-field"><label class="cv2-label">Phone <span class="req">*</span></label><input type="tel" data-intl-phone="1" value="+91 98640 11223"></div>
                                <div class="cv2-field"><label class="cv2-label">WhatsApp</label><input type="tel" data-intl-phone="1" value="+91 98640 11223"></div>
                                <div class="cv2-field"><label class="cv2-label">Email</label><input type="email" value="dibya@email.com"></div>
                                <div class="cv2-field is-full"><label class="cv2-label">Address</label><input type="text" value="Same as permanent"></div>
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
                        <div class="cv2-field"><label class="cv2-label">Employee Status</label>
                            <select class="cv2-select" id="cv2Status" style="width:100%;">
                                <option {{ $e['status']=='Active'?'selected':'' }}>Active</option>
                                <option {{ $e['status']=='Inactive'?'selected':'' }}>Inactive</option>
                                <option {{ $e['status']=='Blacklisted'?'selected':'' }}>Blacklisted</option>
                            </select>
                        </div>
                        <div class="cv2-field cv2-mt" id="cv2BlacklistWrap" style="{{ $e['status']=='Blacklisted'?'':'display:none;' }}">
                            <label class="cv2-label">Blacklist Reason <span class="req">*</span></label>
                            <textarea rows="3" placeholder="Why is this employee being blacklisted?"></textarea>
                            <span class="cv2-hint">A blacklist note is logged to the activity trail.</span>
                        </div>
                    </div>
                </div>
                <div class="cv2-card cv2-mt">
                    <div class="cv2-card-h"><h3>Employment Settings</h3></div>
                    <div class="cv2-card-b">
                        <div class="cv2-field"><label class="cv2-label">Tracking Group</label><select class="cv2-select" style="width:100%;"><option>Tracking A</option><option>Tracking B</option></select></div>
                        <div class="cv2-field cv2-mt"><label class="cv2-label">Provident Fund</label>
                            <div class="cv2-radio-group">
                                <span class="cv2-radio"><input type="radio" name="providentFund" id="epf_yes" value="yes" checked><label for="epf_yes">Yes</label></span>
                                <span class="cv2-radio"><input type="radio" name="providentFund" id="epf_no" value="no"><label for="epf_no">No</label></span>
                            </div>
                        </div>
                        <div class="cv2-field cv2-mt" id="cv2PfNoWrap"><label class="cv2-label">Provident Fund No</label><input type="text" value="PF00123456" maxlength="25"></div>
                    </div>
                </div>
                <div class="cv2-card cv2-mt">
                    <div class="cv2-card-h"><h3>Documents</h3></div>
                    <div class="cv2-card-b">
                        <div class="cv2-locked"><i class="bi bi-paperclip"></i><div><b>{{ $counts['documents'] }} documents</b><div class="cv2-hint">Managed on the Documents page</div></div></div>
                        <a href="{{ route('contact.v2.employee.documents', $e['id']) }}" class="cv2-btn cv2-btn-ghost cv2-mt" style="width:100%;justify-content:center;"><i class="bi bi-folder2-open"></i>Open Documents</a>
                    </div>
                </div>
                <div class="cv2-card cv2-mt"><div class="cv2-card-b" style="display:flex;flex-direction:column;gap:10px;">
                    <button type="submit" class="cv2-btn cv2-btn-primary" style="justify-content:center;"><i class="bi bi-check2"></i>Save Changes</button>
                    <a href="{{ route('contact.v2.employee.show', $e['id']) }}" class="cv2-btn cv2-btn-ghost" style="justify-content:center;">Cancel</a>
                </div></div>
            </div>
        </div>
        </form>
    </div></div>
</div>
@endsection
@section('js')<script src="{{ asset('js/V2/employee.js?v=1.0') }}"></script>@endsection
