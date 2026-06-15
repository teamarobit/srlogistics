@extends('layouts.app')

@section('css')
<link href="{{ asset('css/V2/employee.css?v=1.0') }}" rel="stylesheet">
@endsection

@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="cv2-wrap">
        <div class="cv2-container">

            <div class="cv2-phead">
                <div>
                    <div class="cv2-crumb"><a href="{{ route('contact.v2.employee.index') }}">Employees</a> · New</div>
                    <h1>Add Employee</h1>
                    <div class="cv2-sub">Create the employee record. Joining, assets, salary, leave &amp; exit open as their own pages once saved.</div>
                </div>
                <div class="cv2-phead-actions">
                    <a href="{{ route('contact.v2.employee.index') }}" class="cv2-btn cv2-btn-soft">Cancel</a>
                    <button type="submit" form="cv2EmployeeForm" class="cv2-btn cv2-btn-primary"><i class="bi bi-check2"></i>Save Employee</button>
                </div>
            </div>

            <form id="cv2EmployeeForm" action="javascript:void(0)" data-create="1">
            <div class="cv2-grid cv2-grid-2-1">
                <div style="display:flex;flex-direction:column;gap:16px;">

                    {{-- Personal info --}}
                    <div class="cv2-card">
                        <div class="cv2-card-h"><h3>Personal Information</h3></div>
                        <div class="cv2-card-b">
                            <div class="cv2-form-grid">
                                <div class="cv2-field"><label class="cv2-label">Employee Name <span class="req">*</span></label><input type="text" name="contact_name" placeholder="Full name" maxlength="100"></div>
                                <div class="cv2-field"><label class="cv2-label">Gender <span class="req">*</span></label><select class="cv2-select" name="gender" style="width:100%;"><option value="">Choose…</option><option>Male</option><option>Female</option><option>Other</option></select></div>
                                <div class="cv2-field"><label class="cv2-label">Date of Birth <span class="req">*</span></label><input type="date" name="dob"></div>
                                <div class="cv2-field"><label class="cv2-label">Date of Joining <span class="req">*</span></label><input type="date" name="doj"></div>
                                <div class="cv2-field"><label class="cv2-label">Blood Group <span class="req">*</span></label><select class="cv2-select" name="blood_group" style="width:100%;"><option value="">Choose…</option><option>A+</option><option>A-</option><option>B+</option><option>B-</option><option>AB+</option><option>AB-</option><option>O+</option><option>O-</option></select></div>
                                <div class="cv2-field"><label class="cv2-label">Religion <span class="req">*</span></label><select class="cv2-select" name="religion_id" style="width:100%;"><option value="">Choose…</option><option>Hindu</option><option>Muslim</option><option>Christian</option><option>Other</option></select></div>
                                <div class="cv2-field"><label class="cv2-label">Reference By <span class="req">*</span></label><input type="text" name="reference_by" placeholder="Referred by" maxlength="100"></div>
                                <div class="cv2-field"><label class="cv2-label">Photo</label><input type="file" name="contact_image" accept=".jpg,.jpeg,.png,.webp"></div>
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
                                <div class="cv2-field is-full"><label class="cv2-label">Email</label><input type="email" name="email" placeholder="name@srlogistics.com"></div>
                            </div>
                        </div>
                    </div>

                    {{-- Work type (E-specific conditional block) --}}
                    <div class="cv2-card">
                        <div class="cv2-card-h"><h3>Work Assignment</h3></div>
                        <div class="cv2-card-b">
                            <div class="cv2-field" style="margin-bottom:12px;"><label class="cv2-label">Work Type <span class="req">*</span></label>
                                <div class="cv2-radio-group">
                                    <span class="cv2-radio"><input type="radio" name="workType" id="wt_office" value="Office Work"><label for="wt_office">Office Work</label></span>
                                    <span class="cv2-radio"><input type="radio" name="workType" id="wt_sc" value="Service Center"><label for="wt_sc">Service Center</label></span>
                                </div>
                            </div>

                            {{-- Office Work fields --}}
                            <div class="cv2-cond" data-wt="Office Work">
                                <div class="cv2-form-grid">
                                    <div class="cv2-field"><label class="cv2-label">Office Branch <span class="req">*</span></label><select class="cv2-select" name="office_branch_id" style="width:100%;"><option value="">Choose branch…</option><option>Guwahati HO</option><option>Tinsukia Branch</option></select></div>
                                    <div class="cv2-field"><label class="cv2-label">Department <span class="req">*</span></label><select class="cv2-select" name="office_department_id" style="width:100%;"><option value="">Choose…</option><option>Operations</option><option>Accounts</option><option>HR</option></select></div>
                                    <div class="cv2-field"><label class="cv2-label">Designation <span class="req">*</span></label><select class="cv2-select" name="office_designation_id" style="width:100%;"><option value="">Choose…</option><option>Dispatch Manager</option><option>Accounts Executive</option><option>HR Officer</option></select></div>
                                    <div class="cv2-field"><label class="cv2-label">Job Rank <span class="req">*</span></label><select class="cv2-select" name="office_job_rank_id" style="width:100%;"><option value="">Choose…</option><option>Junior</option><option>Senior</option><option>Lead</option></select></div>
                                    <div class="cv2-field is-full"><label class="cv2-label">Roles <span class="req">*</span></label><select class="cv2-select" name="office_role_ids[]" multiple style="width:100%;"><option>Operations</option><option>Accounts</option><option>HR</option><option>Reports</option></select></div>
                                </div>
                            </div>

                            {{-- Service Center fields --}}
                            <div class="cv2-cond" data-wt="Service Center">
                                <div class="cv2-form-grid">
                                    <div class="cv2-field"><label class="cv2-label">Service Center Branch <span class="req">*</span></label><select class="cv2-select" name="service_center_branch_id" style="width:100%;"><option value="">Choose…</option><option>Dibrugarh SC</option><option>Silchar SC</option></select></div>
                                    <div class="cv2-field"><label class="cv2-label">Department <span class="req">*</span></label><select class="cv2-select" name="service_center_department_id" style="width:100%;"><option value="">Choose…</option><option>Maintenance</option></select></div>
                                    <div class="cv2-field"><label class="cv2-label">Designation <span class="req">*</span></label><select class="cv2-select" name="service_center_designation_id" style="width:100%;"><option value="">Choose…</option><option>Senior Technician</option><option>Service Coordinator</option></select></div>
                                    <div class="cv2-field"><label class="cv2-label">Job Rank <span class="req">*</span></label><select class="cv2-select" name="service_center_jobrank_id" style="width:100%;"><option value="">Choose…</option><option>Junior</option><option>Senior</option></select></div>
                                    <div class="cv2-field"><label class="cv2-label">Service Type <span class="req">*</span></label>
                                        <div class="cv2-radio-group">
                                            <span class="cv2-radio"><input type="radio" name="service_type" id="st_adm" value="Administrative"><label for="st_adm">Administrative</label></span>
                                            <span class="cv2-radio"><input type="radio" name="service_type" id="st_tech" value="Technical"><label for="st_tech">Technical</label></span>
                                        </div>
                                    </div>
                                    <div class="cv2-field cv2-cond" data-st="Technical"><label class="cv2-label">Skillsets <span class="req">*</span></label><select class="cv2-select" name="servicecenter_technical_skillset_ids[]" multiple style="width:100%;"><option>Engine</option><option>Electrical</option><option>Tyre</option><option>Body</option></select></div>
                                    <div class="cv2-field is-full"><label class="cv2-label">Roles <span class="req">*</span></label><select class="cv2-select" name="service_center_role_ids[]" multiple style="width:100%;"><option>Technician</option><option>Coordinator</option></select></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- E5 Permanent Address --}}
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

                    {{-- E5 Present Address + same-as-permanent toggle --}}
                    <div class="cv2-card">
                        <div class="cv2-card-h"><h3>Present Address</h3></div>
                        <div class="cv2-card-b">
                            <label class="cv2-addr-toggle" style="margin-bottom:12px;"><input type="checkbox" id="cv2SameAddr" name="same_as_permanent"> Same as permanent address</label>
                            <div id="cv2PresentWrap">
                                <div class="cv2-form-grid">
                                    <div class="cv2-field is-full"><label class="cv2-label">Address <span class="req">*</span></label><textarea name="present_address" rows="2" placeholder="House, street, area" maxlength="255"></textarea></div>
                                    <div class="cv2-field"><label class="cv2-label">State <span class="req">*</span></label><select class="cv2-select" name="present_addr_state_id" style="width:100%;"><option value="">Choose state…</option><option>Assam</option><option>West Bengal</option></select></div>
                                    <div class="cv2-field"><label class="cv2-label">City</label><select class="cv2-select" name="present_addr_city_id" style="width:100%;"><option value="">Choose city…</option><option>Guwahati</option><option>Dibrugarh</option></select></div>
                                    <div class="cv2-field"><label class="cv2-label">Postal Code <span class="req">*</span></label><input type="text" name="present_addr_postal_code" placeholder="781001" maxlength="6"></div>
                                </div>
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
                                    <div class="cv2-field"><label class="cv2-label">Relation</label><input type="text" placeholder="e.g. Father"></div>
                                    <div class="cv2-field"><label class="cv2-label">Blood Group</label><input type="text" placeholder="O+"></div>
                                    <div class="cv2-field"><label class="cv2-label">Phone <span class="req">*</span></label><input type="tel" data-intl-phone="1" placeholder="98640 11223"></div>
                                    <div class="cv2-field"><label class="cv2-label">WhatsApp</label><input type="tel" data-intl-phone="1" placeholder="98640 11223"></div>
                                    <div class="cv2-field"><label class="cv2-label">Email</label><input type="email" placeholder="person@email.com"></div>
                                    <div class="cv2-field is-full"><label class="cv2-label">Address</label><input type="text" placeholder="Optional"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Bank detail (single) --}}
                    <div class="cv2-card">
                        <div class="cv2-card-h"><h3>Bank Detail <span class="cv2-pill" style="font-weight:600;">Optional</span></h3></div>
                        <div class="cv2-card-b">
                            <div class="cv2-form-grid">
                                <div class="cv2-field"><label class="cv2-label">Bank</label><select class="cv2-select" name="bank_id" style="width:100%;"><option value="">Choose bank…</option><option>SBI</option><option>HDFC</option><option>ICICI</option></select></div>
                                <div class="cv2-field"><label class="cv2-label">Account Number</label><input type="text" name="account_number" placeholder="Account no"></div>
                                <div class="cv2-field"><label class="cv2-label">Beneficiary Name</label><input type="text" name="beneficiary_name" placeholder="As per bank"></div>
                                <div class="cv2-field"><label class="cv2-label">IFSC Code</label><input type="text" name="ifsc_code" placeholder="SBIN0001234"></div>
                                <div class="cv2-field"><label class="cv2-label">UPI ID</label><input type="text" name="upi_id" placeholder="name@upi"></div>
                            </div>
                        </div>
                    </div>

                    {{-- Documents --}}
                    <div class="cv2-card">
                        <div class="cv2-card-h"><h3>Documents</h3></div>
                        <div class="cv2-card-b">
                            <div class="cv2-form-grid">
                                <div class="cv2-field"><label class="cv2-label">Document Type</label><select class="cv2-select" style="width:100%;"><option value="">Select type…</option><option>Aadhaar</option><option>PAN</option><option>Resume</option></select></div>
                                <div class="cv2-field"><label class="cv2-label">&nbsp;</label><span class="cv2-hint">JPG, PNG or PDF · max 2 MB · up to 2 files per type</span></div>
                                <div class="cv2-field is-full"><div class="cv2-dropzone"><i class="bi bi-cloud-arrow-up"></i>Drop files here or click to upload</div></div>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Right rail --}}
                <div>
                    <div class="cv2-card">
                        <div class="cv2-card-h"><h3>Employment Settings</h3></div>
                        <div class="cv2-card-b">
                            <div class="cv2-field"><label class="cv2-label">Tracking Group <span class="req">*</span></label><select class="cv2-select" name="tracking_group" style="width:100%;"><option value="">Choose…</option><option>Tracking A</option><option>Tracking B</option></select></div>
                            <div class="cv2-field cv2-mt"><label class="cv2-label">Provident Fund</label>
                                <div class="cv2-radio-group">
                                    <span class="cv2-radio"><input type="radio" name="providentFund" id="pf_yes" value="yes"><label for="pf_yes">Yes</label></span>
                                    <span class="cv2-radio"><input type="radio" name="providentFund" id="pf_no" value="no" checked><label for="pf_no">No</label></span>
                                </div>
                            </div>
                            <div class="cv2-field cv2-mt" id="cv2PfNoWrap" style="display:none;"><label class="cv2-label">Provident Fund No</label><input type="text" name="provident_fund_no" placeholder="PF account no" maxlength="25"></div>
                            <div class="cv2-field cv2-mt"><label class="cv2-label">Comment</label><textarea name="comment" rows="3" placeholder="Optional note"></textarea></div>
                        </div>
                    </div>
                    <div class="cv2-card cv2-mt">
                        <div class="cv2-card-h"><h3>Available after saving</h3></div>
                        <div class="cv2-card-b" style="display:flex;flex-direction:column;gap:10px;">
                            <div class="cv2-locked"><i class="bi bi-lock"></i><div><b>Joining &amp; Letter</b><div class="cv2-hint">Work experience + joining letter</div></div></div>
                            <div class="cv2-locked"><i class="bi bi-lock"></i><div><b>Assets</b><div class="cv2-hint">Issue / revoke company assets</div></div></div>
                            <div class="cv2-locked"><i class="bi bi-lock"></i><div><b>Salary</b><div class="cv2-hint">Salary structure &amp; revisions</div></div></div>
                            <div class="cv2-locked"><i class="bi bi-lock"></i><div><b>Leave &amp; Exit</b><div class="cv2-hint">Leave tracker + exit letter</div></div></div>
                            <span class="cv2-hint" style="margin-top:4px;">Each submodule opens as its own page once the employee exists.</span>
                        </div>
                    </div>
                    <div class="cv2-card cv2-mt">
                        <div class="cv2-card-b" style="display:flex;flex-direction:column;gap:10px;">
                            <button type="submit" form="cv2EmployeeForm" class="cv2-btn cv2-btn-primary cv2-btn-lg" style="justify-content:center;"><i class="bi bi-check2"></i>Save Employee</button>
                            <a href="{{ route('contact.v2.employee.index') }}" class="cv2-btn cv2-btn-ghost" style="justify-content:center;">Cancel</a>
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
<script src="{{ asset('js/V2/employee.js?v=1.0') }}"></script>
@endsection
