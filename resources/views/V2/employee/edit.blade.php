@extends('layouts.app')

@section('css')
<link href="{{ asset('css/V2/employee.css?v=2.0') }}" rel="stylesheet">
@endsection

@section('content')
@php
    $perm = $permanentAddress ?? null;
    $pres = $presentAddress ?? null;
    $bank = $contact->bank;
    $roleIds = $contactroles ?? [];
    $skillsetIds = !empty($contact->skillset_ids) ? (json_decode($contact->skillset_ids, true) ?? []) : [];
    $skillsetIds = array_map('strval', (array) $skillsetIds);
@endphp
<div class="layout-wrapper">
    @include('includes.header')
    <div class="cv2-wrap">
        <div class="cv2-container">

            <div class="cv2-phead">
                <div>
                    <div class="cv2-crumb"><a href="{{ route('contact.v2.employee.index') }}">Employees</a> · {{ $contact->contact_name }} · Edit</div>
                    <h1>Edit Employee</h1>
                    <div class="cv2-sub">Update the employee record. Joining, assets, salary, leave &amp; exit open as their own pages.</div>
                </div>
                <div class="cv2-phead-actions">
                    <a href="{{ route('contact.v2.employee.show', $contact->id) }}" class="cv2-btn cv2-btn-soft">Cancel</a>
                    <button type="submit" form="cv2EditForm" class="cv2-btn cv2-btn-primary"><i class="bi bi-check2"></i>Update Employee</button>
                </div>
            </div>

            <form id="cv2EditForm" action="{{ route('contact.v2.employee.update', $contact->id) }}" method="POST" enctype="multipart/form-data" data-show-url="{{ route('contact.v2.employee.show', $contact->id) }}" data-index-url="{{ route('contact.v2.employee.index') }}" data-person-wrapper-url="{{ route('contact.v2.employee.emergencycontactwrapper') }}">
            @csrf
            <div class="cv2-grid cv2-grid-2-1">
                <div style="display:flex;flex-direction:column;gap:16px;">

                    {{-- Personal info --}}
                    <div class="cv2-card">
                        <div class="cv2-card-h"><h3>Personal Information</h3></div>
                        <div class="cv2-card-b">
                            <div class="cv2-form-grid">
                                <div class="cv2-field"><label class="cv2-label">Employee Name <span class="req">*</span></label><input type="text" name="contact_name" value="{{ old('contact_name', $contact->contact_name) }}" placeholder="Full name" maxlength="100"></div>
                                <div class="cv2-field"><label class="cv2-label">Gender <span class="req">*</span></label><select class="cv2-select" name="gender" style="width:100%;"><option value="">Choose…</option>@foreach(['Male','Female','Other'] as $g)<option value="{{ $g }}" {{ old('gender', $contact->gender)==$g?'selected':'' }}>{{ $g }}</option>@endforeach</select></div>
                                <div class="cv2-field"><label class="cv2-label">Date of Birth <span class="req">*</span></label><input type="date" name="dob" value="{{ old('dob', optional($contact->dob)->format('Y-m-d') ?? $contact->dob) }}"></div>
                                <div class="cv2-field"><label class="cv2-label">Date of Joining <span class="req">*</span></label><input type="date" name="doj" value="{{ old('doj', optional($contact->doj)->format('Y-m-d') ?? $contact->doj) }}"></div>
                                <div class="cv2-field"><label class="cv2-label">Blood Group <span class="req">*</span></label><select class="cv2-select" name="blood_group" style="width:100%;"><option value="">Choose…</option>@foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $bg)<option value="{{ $bg }}" {{ old('blood_group', $contact->blood_group)==$bg?'selected':'' }}>{{ $bg }}</option>@endforeach</select></div>
                                <div class="cv2-field"><label class="cv2-label">Religion <span class="req">*</span></label><select class="cv2-select" name="religion_id" style="width:100%;"><option value="">Choose…</option>@foreach($religions as $r)<option value="{{ $r->id }}" {{ old('religion_id', $contact->religion_id)==$r->id?'selected':'' }}>{{ $r->name }}</option>@endforeach</select></div>
                                <div class="cv2-field"><label class="cv2-label">Reference By <span class="req">*</span></label><input type="text" name="reference_by" value="{{ old('reference_by', $contact->reference_by) }}" placeholder="Referred by" maxlength="100"></div>
                                <div class="cv2-field"><label class="cv2-label">Photo</label><input type="file" name="contact_image" accept=".jpg,.jpeg,.png,.webp">
                                    @if(!empty($contact->contact_image))
                                    <div class="cv2-mt" style="display:flex;align-items:center;gap:10px;">
                                        <img src="{{ asset('media/contact/' . $contact->contact_image) }}" alt="Photo" style="width:48px;height:48px;object-fit:cover;border-radius:6px;border:1px solid var(--cv2-border, #e3e3e3);">
                                        <label class="cv2-addr-toggle" style="margin:0;"><input type="checkbox" name="remove_contact_image" value="1"> Remove current photo</label>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Contact details --}}
                    <div class="cv2-card">
                        <div class="cv2-card-h"><h3>Contact Details</h3></div>
                        <div class="cv2-card-b">
                            <div class="cv2-form-grid">
                                <input type="hidden" name="phone_code" id="cv2PhoneCode" value="{{ old('phone_code', $contact->ph_prefix ?: '+91') }}">
                                <input type="hidden" name="whatsapp_code" id="cv2WhatsappCode" value="{{ old('whatsapp_code', $contact->whatsapp_prefix ?: '+91') }}">
                                <div class="cv2-field"><label class="cv2-label">Phone <span class="req">*</span></label><input type="tel" name="phone" id="cv2MainPhone" data-intl-phone="1" placeholder="98640 11223" value="{{ old('phone', $contact->phone) }}"></div>
                                <div class="cv2-field"><label class="cv2-label">WhatsApp</label><input type="tel" name="whatsapp" id="cv2MainWhatsapp" data-intl-phone="1" placeholder="98640 11223" value="{{ old('whatsapp', $contact->whatsapp) }}"></div>
                                <div class="cv2-field is-full"><label class="cv2-label">Email</label><input type="email" name="email" value="{{ old('email', $contact->email) }}" placeholder="name@srlogistics.com"></div>
                            </div>
                        </div>
                    </div>

                    {{-- Work type (E-specific conditional block) --}}
                    @php
                        $wt = old('workType', $contact->work_type);
                        $stype = old('service_type', $contact->service_type);
                    @endphp
                    <div class="cv2-card">
                        <div class="cv2-card-h"><h3>Work Assignment</h3></div>
                        <div class="cv2-card-b">
                            <div class="cv2-field" style="margin-bottom:12px;"><label class="cv2-label">Work Type <span class="req">*</span></label>
                                <div class="cv2-radio-group">
                                    <span class="cv2-radio"><input type="radio" name="workType" id="wt_office" value="Office Work" {{ $wt=='Office Work'?'checked':'' }}><label for="wt_office">Office Work</label></span>
                                    <span class="cv2-radio"><input type="radio" name="workType" id="wt_sc" value="Service Center" {{ $wt=='Service Center'?'checked':'' }}><label for="wt_sc">Service Center</label></span>
                                </div>
                            </div>

                            {{-- Office Work fields --}}
                            <div class="cv2-cond" data-wt="Office Work">
                                <div class="cv2-form-grid">
                                    <div class="cv2-field"><label class="cv2-label">Office Branch <span class="req">*</span></label><select class="cv2-select" name="office_branch_id" style="width:100%;"><option value="">Choose branch…</option>@foreach($branches as $b)<option value="{{ $b->id }}" {{ old('office_branch_id', $contact->office_branch_id)==$b->id?'selected':'' }}>{{ $b->location }}</option>@endforeach</select></div>
                                    <div class="cv2-field"><label class="cv2-label">Department <span class="req">*</span></label><select class="cv2-select" name="office_department_id" style="width:100%;"><option value="">Choose…</option>@foreach($departments as $d)<option value="{{ $d->id }}" {{ old('office_department_id', $contact->office_department_id)==$d->id?'selected':'' }}>{{ $d->name }}</option>@endforeach</select></div>
                                    <div class="cv2-field"><label class="cv2-label">Designation <span class="req">*</span></label><select class="cv2-select" name="office_designation_id" style="width:100%;"><option value="">Choose…</option>@foreach($designations as $d)<option value="{{ $d->id }}" {{ old('office_designation_id', $contact->office_designation_id)==$d->id?'selected':'' }}>{{ $d->name }}</option>@endforeach</select></div>
                                    <div class="cv2-field"><label class="cv2-label">Job Rank <span class="req">*</span></label><select class="cv2-select" name="office_job_rank_id" style="width:100%;"><option value="">Choose…</option>@foreach($jobranks as $j)<option value="{{ $j->id }}" {{ old('office_job_rank_id', $contact->office_jobrank_id)==$j->id?'selected':'' }}>{{ $j->name }}</option>@endforeach</select></div>
                                    <div class="cv2-field is-full"><label class="cv2-label">Roles <span class="req">*</span></label><select class="cv2-select" name="office_role_ids[]" multiple style="width:100%;">@foreach($roles as $r)<option value="{{ $r->id }}" {{ in_array($r->id, $roleIds)?'selected':'' }}>{{ $r->name }}</option>@endforeach</select></div>
                                </div>
                            </div>

                            {{-- Service Center fields --}}
                            <div class="cv2-cond" data-wt="Service Center">
                                <div class="cv2-form-grid">
                                    <div class="cv2-field"><label class="cv2-label">Service Center Branch <span class="req">*</span></label><select class="cv2-select" name="service_center_branch_id" style="width:100%;"><option value="">Choose…</option>@foreach($branches as $b)<option value="{{ $b->id }}" {{ old('service_center_branch_id', $contact->service_center_branch_id)==$b->id?'selected':'' }}>{{ $b->location }}</option>@endforeach</select></div>
                                    <div class="cv2-field"><label class="cv2-label">Department <span class="req">*</span></label><select class="cv2-select" name="service_center_department_id" style="width:100%;"><option value="">Choose…</option>@foreach($departments as $d)<option value="{{ $d->id }}" {{ old('service_center_department_id', $contact->service_center_department_id)==$d->id?'selected':'' }}>{{ $d->name }}</option>@endforeach</select></div>
                                    <div class="cv2-field"><label class="cv2-label">Designation <span class="req">*</span></label><select class="cv2-select" name="service_center_designation_id" style="width:100%;"><option value="">Choose…</option>@foreach($designations as $d)<option value="{{ $d->id }}" {{ old('service_center_designation_id', $contact->service_center_designation_id)==$d->id?'selected':'' }}>{{ $d->name }}</option>@endforeach</select></div>
                                    <div class="cv2-field"><label class="cv2-label">Job Rank <span class="req">*</span></label><select class="cv2-select" name="service_center_jobrank_id" style="width:100%;"><option value="">Choose…</option>@foreach($jobranks as $j)<option value="{{ $j->id }}" {{ old('service_center_jobrank_id', $contact->service_center_jobrank_id)==$j->id?'selected':'' }}>{{ $j->name }}</option>@endforeach</select></div>
                                    <div class="cv2-field"><label class="cv2-label">Service Type <span class="req">*</span></label>
                                        <div class="cv2-radio-group">
                                            <span class="cv2-radio"><input type="radio" name="service_type" id="st_adm" value="Administrative" {{ $stype=='Administrative'?'checked':'' }}><label for="st_adm">Administrative</label></span>
                                            <span class="cv2-radio"><input type="radio" name="service_type" id="st_tech" value="Technical" {{ $stype=='Technical'?'checked':'' }}><label for="st_tech">Technical</label></span>
                                        </div>
                                    </div>
                                    <div class="cv2-field cv2-cond" data-st="Technical"><label class="cv2-label">Skillsets <span class="req">*</span></label><select class="cv2-select" name="servicecenter_technical_skillset_ids[]" multiple style="width:100%;">@foreach($skillsets as $s)<option value="{{ $s->id }}" {{ in_array((string)$s->id, $skillsetIds)?'selected':'' }}>{{ $s->name }}</option>@endforeach</select></div>
                                    <div class="cv2-field is-full"><label class="cv2-label">Roles <span class="req">*</span></label><select class="cv2-select" name="service_center_role_ids[]" multiple style="width:100%;">@foreach($roles as $r)<option value="{{ $r->id }}" {{ in_array($r->id, $roleIds)?'selected':'' }}>{{ $r->name }}</option>@endforeach</select></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- E5 Permanent Address --}}
                    <div class="cv2-card">
                        <div class="cv2-card-h"><h3>Permanent Address</h3></div>
                        <div class="cv2-card-b">
                            <div class="cv2-form-grid">
                                <div class="cv2-field is-full"><label class="cv2-label">Address <span class="req">*</span></label><textarea name="permanent_address" rows="2" placeholder="House, street, area" maxlength="255">{{ old('permanent_address', $perm->address ?? '') }}</textarea></div>
                                <div class="cv2-field"><label class="cv2-label">State <span class="req">*</span></label>
                                    <select class="cv2-select cv2-state" name="permanent_addr_state_id" data-city-target="#cv2PermCity" style="width:100%;"><option value="">Choose state…</option>
                                        @foreach($states as $st)<option value="{{ $st->id }}" data-cities='@json($st->cities->map(fn($ci)=>["id"=>$ci->id,"name"=>$ci->name]))' {{ old('permanent_addr_state_id', $perm->state_id ?? '')==$st->id?'selected':'' }}>{{ $st->name }}</option>@endforeach
                                    </select>
                                </div>
                                <div class="cv2-field"><label class="cv2-label">City</label><select class="cv2-select" id="cv2PermCity" name="permanent_addr_city_id" data-old="{{ old('permanent_addr_city_id', $perm->city_id ?? '') }}" style="width:100%;"><option value="">Choose city…</option></select></div>
                                <div class="cv2-field"><label class="cv2-label">Postal Code <span class="req">*</span></label><input type="text" name="permanent_addr_postal_code" value="{{ old('permanent_addr_postal_code', $perm->zipcode ?? '') }}" placeholder="781001" maxlength="6"></div>
                                <div class="cv2-field is-full"><label class="cv2-label">Additional Info</label><input type="text" name="permanent_addr_additional_info" value="{{ old('permanent_addr_additional_info', $perm->additional_info ?? '') }}" placeholder="Landmark, etc."></div>
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
                                    <div class="cv2-field is-full"><label class="cv2-label">Address <span class="req">*</span></label><textarea name="present_address" rows="2" placeholder="House, street, area" maxlength="255">{{ old('present_address', $pres->address ?? '') }}</textarea></div>
                                    <div class="cv2-field"><label class="cv2-label">State <span class="req">*</span></label>
                                        <select class="cv2-select cv2-state" name="present_addr_state_id" data-city-target="#cv2PresentCity" style="width:100%;"><option value="">Choose state…</option>
                                            @foreach($states as $st)<option value="{{ $st->id }}" data-cities='@json($st->cities->map(fn($ci)=>["id"=>$ci->id,"name"=>$ci->name]))' {{ old('present_addr_state_id', $pres->state_id ?? '')==$st->id?'selected':'' }}>{{ $st->name }}</option>@endforeach
                                        </select>
                                    </div>
                                    <div class="cv2-field"><label class="cv2-label">City</label><select class="cv2-select" id="cv2PresentCity" name="present_addr_city_id" data-old="{{ old('present_addr_city_id', $pres->city_id ?? '') }}" style="width:100%;"><option value="">Choose city…</option></select></div>
                                    <div class="cv2-field"><label class="cv2-label">Postal Code <span class="req">*</span></label><input type="text" name="present_addr_postal_code" value="{{ old('present_addr_postal_code', $pres->zipcode ?? '') }}" placeholder="781001" maxlength="6"></div>
                                    <div class="cv2-field is-full"><label class="cv2-label">Additional Info</label><input type="text" name="present_addr_additional_info" value="{{ old('present_addr_additional_info', $pres->additional_info ?? '') }}" placeholder="Landmark, etc."></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Emergency contacts --}}
                    <div class="cv2-card">
                        <div class="cv2-card-h"><h3>Emergency Contacts <span class="cv2-pill" style="font-weight:600;">At least 1</span></h3>
                            <a href="javascript:void(0)" class="cv2-link" id="cv2AddPerson"><i class="bi bi-plus-lg"></i> Add another</a></div>
                        <div class="cv2-card-b" id="cv2PersonWrap">
                            @php $rcs = $contact->relcontacts ?? collect(); @endphp
                            @forelse($rcs as $rc)
                            <div class="cv2-repeat-row">
                                <input type="hidden" name="contact_person_id[]" value="{{ $rc->id }}">
                                <input type="hidden" name="contact_person_ph_code[]" class="cv2-cp-phcode" value="{{ $rc->ph_prefix ?: '+91' }}">
                                <input type="hidden" name="contact_person_whatsapp_code[]" class="cv2-cp-wacode" value="{{ $rc->whatsapp_prefix ?: '+91' }}">
                                <div class="cv2-form-grid is-3">
                                    <div class="cv2-field"><label class="cv2-label">Name <span class="req">*</span></label><input type="text" name="contact_person_name[]" value="{{ $rc->name }}" placeholder="Person name"></div>
                                    <div class="cv2-field"><label class="cv2-label">Relation</label><input type="text" name="contact_person_relation[]" value="{{ $rc->relationship }}" placeholder="e.g. Father"></div>
                                    <div class="cv2-field"><label class="cv2-label">Blood Group</label><input type="text" name="contact_person_blood_group[]" value="{{ $rc->blood_group }}" placeholder="O+"></div>
                                    <div class="cv2-field"><label class="cv2-label">Phone <span class="req">*</span></label><input type="tel" name="contact_person_phone[]" data-intl-phone="1" value="{{ $rc->phone }}" placeholder="98640 11223"></div>
                                    <div class="cv2-field"><label class="cv2-label">WhatsApp</label><input type="tel" name="contact_person_whatsapp[]" data-intl-phone="1" value="{{ $rc->whatsapp }}" placeholder="98640 11223"></div>
                                    <div class="cv2-field"><label class="cv2-label">Email</label><input type="email" name="contact_person_email[]" value="{{ $rc->email }}" placeholder="person@email.com"></div>
                                    <div class="cv2-field is-full"><label class="cv2-label">Address</label><input type="text" name="contact_person_address[]" value="{{ $rc->address }}" placeholder="Optional"></div>
                                    <div class="cv2-field is-full"><label class="cv2-label">Comment</label><input type="text" name="contact_person_comment[]" value="{{ $rc->comment }}" placeholder="Optional"></div>
                                </div>
                                <a href="javascript:void(0)" class="cv2-link cv2-remove" style="color:var(--cv2-danger,#c0392b);"><i class="bi bi-trash"></i> Remove</a>
                            </div>
                            @empty
                            <div class="cv2-repeat-row">
                                <input type="hidden" name="contact_person_id[]" value="">
                                <input type="hidden" name="contact_person_ph_code[]" class="cv2-cp-phcode">
                                <input type="hidden" name="contact_person_whatsapp_code[]" class="cv2-cp-wacode">
                                <div class="cv2-form-grid is-3">
                                    <div class="cv2-field"><label class="cv2-label">Name <span class="req">*</span></label><input type="text" name="contact_person_name[]" placeholder="Person name"></div>
                                    <div class="cv2-field"><label class="cv2-label">Relation</label><input type="text" name="contact_person_relation[]" placeholder="e.g. Father"></div>
                                    <div class="cv2-field"><label class="cv2-label">Blood Group</label><input type="text" name="contact_person_blood_group[]" placeholder="O+"></div>
                                    <div class="cv2-field"><label class="cv2-label">Phone <span class="req">*</span></label><input type="tel" name="contact_person_phone[]" data-intl-phone="1" placeholder="98640 11223"></div>
                                    <div class="cv2-field"><label class="cv2-label">WhatsApp</label><input type="tel" name="contact_person_whatsapp[]" data-intl-phone="1" placeholder="98640 11223"></div>
                                    <div class="cv2-field"><label class="cv2-label">Email</label><input type="email" name="contact_person_email[]" placeholder="person@email.com"></div>
                                    <div class="cv2-field is-full"><label class="cv2-label">Address</label><input type="text" name="contact_person_address[]" placeholder="Optional"></div>
                                    <div class="cv2-field is-full"><label class="cv2-label">Comment</label><input type="text" name="contact_person_comment[]" placeholder="Optional"></div>
                                </div>
                            </div>
                            @endforelse
                        </div>
                    </div>

                    {{-- Bank detail (single) --}}
                    <div class="cv2-card">
                        <div class="cv2-card-h"><h3>Bank Detail <span class="cv2-pill" style="font-weight:600;">Optional</span></h3></div>
                        <div class="cv2-card-b">
                            <div class="cv2-form-grid">
                                <div class="cv2-field"><label class="cv2-label">Bank</label><select class="cv2-select" name="bank_id" style="width:100%;"><option value="">Choose bank…</option>@foreach($banks as $bk)<option value="{{ $bk->id }}" {{ old('bank_id', $bank->bank_id ?? '')==$bk->id?'selected':'' }}>{{ $bk->name }}</option>@endforeach</select></div>
                                <div class="cv2-field"><label class="cv2-label">Account Number</label><input type="text" name="account_number" value="{{ old('account_number', $bank->account_number ?? '') }}" placeholder="Account no"></div>
                                <div class="cv2-field"><label class="cv2-label">Beneficiary Name</label><input type="text" name="beneficiary_name" value="{{ old('beneficiary_name', $bank->beneficiary_name ?? '') }}" placeholder="As per bank"></div>
                                <div class="cv2-field"><label class="cv2-label">IFSC Code</label><input type="text" name="ifsc_code" value="{{ old('ifsc_code', $bank->ifsc_code ?? '') }}" placeholder="SBIN0001234"></div>
                                <div class="cv2-field"><label class="cv2-label">UPI ID</label><input type="text" name="upi_id" value="{{ old('upi_id', $bank->upi_id ?? '') }}" placeholder="name@upi"></div>
                            </div>
                        </div>
                    </div>

                    {{-- Documents (append-only on update) --}}
                    <div class="cv2-card">
                        <div class="cv2-card-h"><h3>Documents <span class="cv2-pill" style="font-weight:600;">Optional</span></h3></div>
                        <div class="cv2-card-b">
                            <div class="cv2-form-grid">
                                <div class="cv2-field"><label class="cv2-label">Document Type</label><select class="cv2-select" name="attachtypes[]" style="width:100%;"><option value="">Select type…</option>@foreach($coattachtypes as $ct)<option value="{{ $ct->id }}">{{ $ct->name }}</option>@endforeach</select></div>
                                <div class="cv2-field"><label class="cv2-label">Files</label><input type="file" name="files[0][]" accept=".jpg,.jpeg,.png,.pdf" multiple></div>
                                <div class="cv2-field is-full"><span class="cv2-hint">JPG, PNG or PDF · max 2 MB · up to 2 files per type · existing documents are kept</span></div>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Right rail --}}
                <div>
                    {{-- Status panel (edit only) --}}
                    <div class="cv2-card">
                        <div class="cv2-card-h"><h3>Status</h3></div>
                        <div class="cv2-card-b">
                            <div class="cv2-field"><label class="cv2-label">Employee Status</label><select class="cv2-select" name="status" id="cv2Status" style="width:100%;">@foreach(['Active','Inactive','Blacklisted'] as $s)<option value="{{ $s }}" {{ old('status', $contact->status)==$s?'selected':'' }}>{{ $s }}</option>@endforeach</select></div>
                            <div class="cv2-field cv2-mt" id="cv2BlacklistWrap" style="{{ old('status', $contact->status)=='Blacklisted'?'':'display:none;' }}"><label class="cv2-label">Blacklist Reason <span class="req">*</span></label><textarea name="blacklist_reason" rows="3" placeholder="Reason for blacklisting">{{ old('blacklist_reason', $contact->blacklist_reason) }}</textarea></div>
                        </div>
                    </div>

                    <div class="cv2-card cv2-mt">
                        <div class="cv2-card-h"><h3>Employment Settings</h3></div>
                        <div class="cv2-card-b">
                            <div class="cv2-field"><label class="cv2-label">Tracking Group <span class="req">*</span></label><select class="cv2-select" name="tracking_group" style="width:100%;"><option value="">Choose…</option>@foreach(['Tracking A','Tracking B'] as $tg)<option value="{{ $tg }}" {{ old('tracking_group', $contact->tracking_group)==$tg?'selected':'' }}>{{ $tg }}</option>@endforeach</select></div>
                            @php $pf = old('providentFund', $contact->provident_fund_registered=='Yes'?'yes':'no'); @endphp
                            <div class="cv2-field cv2-mt"><label class="cv2-label">Provident Fund</label>
                                <div class="cv2-radio-group">
                                    <span class="cv2-radio"><input type="radio" name="providentFund" id="pf_yes" value="yes" {{ $pf=='yes'?'checked':'' }}><label for="pf_yes">Yes</label></span>
                                    <span class="cv2-radio"><input type="radio" name="providentFund" id="pf_no" value="no" {{ $pf!='yes'?'checked':'' }}><label for="pf_no">No</label></span>
                                </div>
                            </div>
                            <div class="cv2-field cv2-mt" id="cv2PfNoWrap" style="{{ $pf=='yes'?'':'display:none;' }}"><label class="cv2-label">Provident Fund No</label><input type="text" name="provident_fund_no" value="{{ old('provident_fund_no', $contact->provident_fund_no) }}" placeholder="PF account no" maxlength="25"></div>
                            <div class="cv2-field cv2-mt"><label class="cv2-label">Comment</label><textarea name="comment" rows="3" placeholder="Optional note">{{ old('comment', $contact->comment) }}</textarea></div>
                        </div>
                    </div>
                    <div class="cv2-card cv2-mt">
                        <div class="cv2-card-h"><h3>Submodules</h3></div>
                        <div class="cv2-card-b" style="display:flex;flex-direction:column;gap:10px;">
                            <a href="{{ route('contact.v2.employee.joining', $contact->id) }}" class="cv2-locked" style="text-decoration:none;color:inherit;"><i class="bi bi-arrow-right-circle"></i><div><b>Joining &amp; Letter</b><div class="cv2-hint">Work experience + joining letter</div></div></a>
                            <a href="{{ route('contact.v2.employee.assets', $contact->id) }}" class="cv2-locked" style="text-decoration:none;color:inherit;"><i class="bi bi-arrow-right-circle"></i><div><b>Assets</b><div class="cv2-hint">Issue / revoke company assets</div></div></a>
                            <a href="{{ route('contact.v2.employee.salary', $contact->id) }}" class="cv2-locked" style="text-decoration:none;color:inherit;"><i class="bi bi-arrow-right-circle"></i><div><b>Salary</b><div class="cv2-hint">Salary structure &amp; revisions</div></div></a>
                            <a href="{{ route('contact.v2.employee.leave', $contact->id) }}" class="cv2-locked" style="text-decoration:none;color:inherit;"><i class="bi bi-arrow-right-circle"></i><div><b>Leave &amp; Exit</b><div class="cv2-hint">Leave tracker + exit letter</div></div></a>
                        </div>
                    </div>
                    <div class="cv2-card cv2-mt">
                        <div class="cv2-card-b" style="display:flex;flex-direction:column;gap:10px;">
                            <button type="submit" form="cv2EditForm" class="cv2-btn cv2-btn-primary cv2-btn-lg" style="justify-content:center;"><i class="bi bi-check2"></i>Update Employee</button>
                            <a href="{{ route('contact.v2.employee.show', $contact->id) }}" class="cv2-btn cv2-btn-ghost" style="justify-content:center;">Cancel</a>
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
<script src="{{ asset('js/V2/employee.js?v=2.2') }}"></script>
@endsection
