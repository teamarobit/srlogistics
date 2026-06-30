@extends('layouts.app')
@section('css')<link href="{{ asset('css/V2/driver.css?v=1.0') }}" rel="stylesheet">@endsection
@section('content')
@php
    $info = $contact->driverinfo;
    $alloc = $contact->currentVehicleAllocation;
    $contactBanks = $contact->bankDetails;
@endphp
<div class="layout-wrapper">
    @include('includes.header')
    <div class="cv2-wrap"><div class="cv2-container">
        <div class="cv2-phead"><div class="cv2-crumb"><a href="{{ route('contact.v2.driver.index') }}">Drivers</a> · {{ $d['name'] }} · Edit</div></div>
        @include('V2.driver.partials.workspace-head')

        <form id="cv2EditForm" action="{{ route('contact.v2.driver.update', $contact->id) }}" method="POST" enctype="multipart/form-data" class="cv2-mt">
        @csrf
        <input type="hidden" name="phone_code" value="{{ $contact->ph_prefix ?? '+91' }}">
        <input type="hidden" name="whatsapp_code" value="{{ $contact->whatsapp_prefix ?? '+91' }}">
        <input type="hidden" name="guarantor_phone_code" value="{{ optional($info)->guarantor_phone_code ?? '+91' }}">
        <div class="cv2-grid cv2-grid-2-1">
            <div style="display:flex;flex-direction:column;gap:16px;">

                <div class="cv2-card">
                    <div class="cv2-card-h"><h3>Basic Information</h3></div>
                    <div class="cv2-card-b"><div class="cv2-form-grid">
                        <div class="cv2-field"><label class="cv2-label">Driver Code <span class="req">*</span></label><input type="text" name="contact_code" value="{{ $contact->contact_code }}" maxlength="100"></div>
                        <div class="cv2-field"><label class="cv2-label">Driver Name <span class="req">*</span></label><input type="text" name="contact_name" value="{{ $contact->contact_name }}" maxlength="100"></div>
                        <div class="cv2-field"><label class="cv2-label">Driver Category <span class="req">*</span></label>
                            <select class="cv2-select" name="driver_category" style="width:100%;">
                                <option value="">Choose…</option>
                                <option value="Local" @selected(optional($info)->category==='Local')>Local</option>
                                <option value="Line" @selected(optional($info)->category==='Line')>Line</option>
                            </select></div>
                        <div class="cv2-field"><label class="cv2-label">Date of Birth</label><input type="date" name="dob" value="{{ $contact->dob }}"></div>
                        <div class="cv2-field"><label class="cv2-label">Date of Joining <span class="req">*</span></label><input type="date" name="doj" value="{{ $contact->doj }}"></div>
                        <div class="cv2-field"><label class="cv2-label">Blood Group</label>
                            <select name="blood_group" style="width:100%;"><option value="">Choose…</option>
                            @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $bg)<option @selected($contact->blood_group===$bg)>{{ $bg }}</option>@endforeach
                            </select></div>
                        <div class="cv2-field"><label class="cv2-label">Religion</label>
                            <select class="cv2-select" name="religion_id" style="width:100%;"><option value="">Choose…</option>
                            @foreach($religions as $r)<option value="{{ $r->id }}" @selected($contact->religion_id==$r->id)>{{ $r->name }}</option>@endforeach
                            </select></div>
                        <div class="cv2-field is-full"><label class="cv2-label">Driver Photo</label>
                            @if($contact->contact_image)<div class="cv2-hint" style="margin-bottom:6px;">Current: <a href="{{ asset('media/contact/'.$contact->contact_image) }}" target="_blank">view</a></div>@endif
                            <input type="file" name="contact_image" accept=".jpg,.jpeg,.png,.webp" class="cv2-file"></div>
                    </div></div>
                </div>

                <div class="cv2-card">
                    <div class="cv2-card-h"><h3>Vehicle Allocation</h3></div>
                    <div class="cv2-card-b">
                        <div class="cv2-field"><label class="cv2-label">Current Vehicle</label>
                            <input type="text" value="{{ optional(optional($alloc)->vehicle)->vehicle_no ?? 'Not allocated' }}" readonly></div>
                        <div class="cv2-field cv2-mt"><label class="cv2-primary-pick"><input type="checkbox" id="cv2ChangeVehicle" name="change_vehicle" value="1"> Change allocated vehicle</label></div>
                        <div id="cv2VehicleChangeWrap" style="display:none;">
                            <div class="cv2-field cv2-mt"><label class="cv2-label">New Vehicle <span class="req">*</span></label>
                                <select class="cv2-select" name="vehicle_id" style="width:100%;"><option value="">Choose vehicle…</option>
                                @foreach($vehicles as $v)<option value="{{ $v->id }}">{{ $v->vehicle_no }}</option>@endforeach
                                </select></div>
                            <div class="cv2-field cv2-mt"><label class="cv2-label">Change Reason <span class="req">*</span></label><textarea name="vehicle_change_reason" rows="2"></textarea></div>
                        </div>
                    </div>
                </div>

                <div class="cv2-card">
                    <div class="cv2-card-h"><h3>Contact Details</h3></div>
                    <div class="cv2-card-b"><div class="cv2-form-grid">
                        <div class="cv2-field"><label class="cv2-label">Phone <span class="req">*</span></label><input type="tel" name="phone" value="{{ $contact->phone }}" data-intl-phone="1"></div>
                        <div class="cv2-field"><label class="cv2-label">WhatsApp</label><input type="tel" name="whatsapp" value="{{ $contact->whatsapp }}" data-intl-phone="1"></div>
                    </div></div>
                </div>

                <div class="cv2-card">
                    <div class="cv2-card-h"><h3>Licence &amp; Identity</h3></div>
                    <div class="cv2-card-b"><div class="cv2-form-grid">
                        <div class="cv2-field"><label class="cv2-label">Driving Licence No <span class="req">*</span></label><input type="text" name="driving_licence_no" value="{{ optional($info)->driving_licence_no }}"></div>
                        <div class="cv2-field"><label class="cv2-label">Original Licence Location <span class="req">*</span></label><input type="text" name="original_licence_location" value="{{ optional($info)->original_licence_location }}"></div>
                        <div class="cv2-field"><label class="cv2-label">Licence Issue Date <span class="req">*</span></label><input type="date" name="licence_issue_date" value="{{ optional($info)->licence_issue_date }}"></div>
                        <div class="cv2-field"><label class="cv2-label">Licence Expiry Date <span class="req">*</span></label><input type="date" name="licence_expiry_date" value="{{ optional($info)->licence_expiry_date }}"></div>
                        <div class="cv2-field"><label class="cv2-label">Driving Licence Proof</label><input type="file" name="driving_license_proof_file" accept=".jpg,.jpeg,.png,.pdf" class="cv2-file"><span class="cv2-hint">Leave blank to keep current.</span></div>
                        <div class="cv2-field"><label class="cv2-label">Aadhaar No <span class="req">*</span></label><input type="text" name="aadhaar_no" value="{{ optional($info)->aadhaar_no }}"></div>
                        <div class="cv2-field"><label class="cv2-label">Aadhaar Card Proof</label><input type="file" name="aadhaar_card_proof_file" accept=".jpg,.jpeg,.png,.pdf" class="cv2-file"></div>
                        <div class="cv2-field"><label class="cv2-label">Signed Driver Form</label><input type="file" name="signed_driver_form_file" accept=".jpg,.jpeg,.png,.pdf" class="cv2-file"></div>
                    </div></div>
                </div>

                <div class="cv2-card">
                    <div class="cv2-card-h"><h3>Permanent Address</h3></div>
                    <div class="cv2-card-b"><div class="cv2-form-grid">
                        <div class="cv2-field is-full"><label class="cv2-label">Address <span class="req">*</span></label><textarea name="permanent_address" rows="2" maxlength="255">{{ optional($permanentAddress)->address }}</textarea></div>
                        <div class="cv2-field"><label class="cv2-label">State <span class="req">*</span></label>
                            <select class="cv2-select cv2-state" name="permanent_addr_state_id" data-city-target="#permCity" style="width:100%;"><option value="">Choose state…</option>
                            @foreach($states as $s)<option value="{{ $s->id }}" @selected(optional($permanentAddress)->state_id==$s->id) data-cities='@json($s->cities->map(fn($c)=>["id"=>$c->id,"name"=>$c->name]))'>{{ $s->name }}</option>@endforeach
                            </select></div>
                        <div class="cv2-field"><label class="cv2-label">City</label><select class="cv2-select" id="permCity" name="permanent_addr_city_id" data-old="{{ optional($permanentAddress)->city_id }}" style="width:100%;"><option value="">Choose city…</option>
                            @if($permanentAddress && $permanentAddress->city)<option value="{{ $permanentAddress->city_id }}" selected>{{ optional($permanentAddress->city)->name }}</option>@endif
                            </select></div>
                        <div class="cv2-field"><label class="cv2-label">Postal Code <span class="req">*</span></label><input type="text" name="permanent_addr_postal_code" value="{{ optional($permanentAddress)->zipcode }}" maxlength="6"></div>
                    </div></div>
                </div>

                <div class="cv2-card">
                    <div class="cv2-card-h"><h3>Present Address</h3></div>
                    <div class="cv2-card-b"><div class="cv2-form-grid">
                        <div class="cv2-field is-full"><label class="cv2-label">Address <span class="req">*</span></label><textarea name="present_address" rows="2" maxlength="255">{{ optional($presentAddress)->address }}</textarea></div>
                        <div class="cv2-field"><label class="cv2-label">State <span class="req">*</span></label>
                            <select class="cv2-select cv2-state" name="present_addr_state_id" data-city-target="#presCity" style="width:100%;"><option value="">Choose state…</option>
                            @foreach($states as $s)<option value="{{ $s->id }}" @selected(optional($presentAddress)->state_id==$s->id) data-cities='@json($s->cities->map(fn($c)=>["id"=>$c->id,"name"=>$c->name]))'>{{ $s->name }}</option>@endforeach
                            </select></div>
                        <div class="cv2-field"><label class="cv2-label">City</label><select class="cv2-select" id="presCity" name="present_addr_city_id" data-old="{{ optional($presentAddress)->city_id }}" style="width:100%;"><option value="">Choose city…</option>
                            @if($presentAddress && $presentAddress->city)<option value="{{ $presentAddress->city_id }}" selected>{{ optional($presentAddress->city)->name }}</option>@endif
                            </select></div>
                        <div class="cv2-field"><label class="cv2-label">Postal Code <span class="req">*</span></label><input type="text" name="present_addr_postal_code" value="{{ optional($presentAddress)->zipcode }}" maxlength="6"></div>
                    </div></div>
                </div>

                <div class="cv2-card">
                    <div class="cv2-card-h"><h3>Bank Details <span class="cv2-pill" style="font-weight:600;">Exactly one primary</span></h3>
                        <a href="javascript:void(0)" class="cv2-link" id="cv2AddBank"><i class="bi bi-plus-lg"></i> Add bank</a></div>
                    <div class="cv2-card-b" id="cv2BankWrap">
                        @php $hasPrimary = $contactBanks->contains('is_primary', 'Yes'); @endphp
                        @forelse($contactBanks as $i => $bank)
                        <div class="cv2-bank-row">
                            <button type="button" class="cv2-remove" title="Remove bank"><i class="bi bi-x-lg"></i></button>
                            <input type="hidden" name="contact_bank_id[]" value="{{ $bank->id }}">
                            <div class="cv2-bank-head"><label class="cv2-primary-pick"><input type="radio" name="primary_bank" value="{{ $i }}" @checked($bank->is_primary==='Yes' || (!$hasPrimary && $i===0))> Set as primary account</label></div>
                            <div class="cv2-form-grid is-3">
                                <div class="cv2-field"><label class="cv2-label">Bank <span class="req">*</span></label><select class="cv2-select cv2-plain" name="bank_id[]" style="width:100%;"><option value="">Choose bank</option>@foreach($banks as $bk)<option value="{{ $bk->id }}" @selected($bank->bank_id==$bk->id)>{{ $bk->name }}</option>@endforeach</select></div>
                                <div class="cv2-field"><label class="cv2-label">Beneficiary Name</label><input type="text" name="beneficiary_name[]" value="{{ $bank->beneficiary_name }}"></div>
                                <div class="cv2-field"><label class="cv2-label">Account Number <span class="req">*</span></label><input type="text" name="account_number[]" value="{{ $bank->account_number }}"></div>
                                <div class="cv2-field"><label class="cv2-label">IFSC Code <span class="req">*</span></label><input type="text" name="ifsc_code[]" value="{{ $bank->ifsc_code }}"></div>
                                <div class="cv2-field"><label class="cv2-label">UPI ID</label><input type="text" name="upi_id[]" value="{{ $bank->upi_id }}"></div>
                            </div>
                        </div>
                        @empty
                        <div class="cv2-bank-row">
                            <input type="hidden" name="contact_bank_id[]" value="">
                            <div class="cv2-bank-head"><label class="cv2-primary-pick"><input type="radio" name="primary_bank" value="0" checked> Set as primary account</label></div>
                            <div class="cv2-form-grid is-3">
                                <div class="cv2-field"><label class="cv2-label">Bank <span class="req">*</span></label><select class="cv2-select cv2-plain" name="bank_id[]" style="width:100%;"><option value="">Choose bank</option>@foreach($banks as $bk)<option value="{{ $bk->id }}">{{ $bk->name }}</option>@endforeach</select></div>
                                <div class="cv2-field"><label class="cv2-label">Beneficiary Name</label><input type="text" name="beneficiary_name[]"></div>
                                <div class="cv2-field"><label class="cv2-label">Account Number <span class="req">*</span></label><input type="text" name="account_number[]"></div>
                                <div class="cv2-field"><label class="cv2-label">IFSC Code <span class="req">*</span></label><input type="text" name="ifsc_code[]"></div>
                                <div class="cv2-field"><label class="cv2-label">UPI ID</label><input type="text" name="upi_id[]"></div>
                            </div>
                        </div>
                        @endforelse
                    </div>
                </div>

                <div class="cv2-card">
                    <div class="cv2-card-h"><h3>Bhatta &amp; Hisab</h3></div>
                    <div class="cv2-card-b"><div class="cv2-form-grid">
                        <div class="cv2-field"><label class="cv2-label">Hisab Category</label>
                            <div class="cv2-radio-group">
                                <span class="cv2-radio"><input type="radio" name="hisab_category" id="hc_fixed" value="Fixed" @checked(optional($info)->hisab_category==='Fixed')><label for="hc_fixed">Fixed</label></span>
                                <span class="cv2-radio"><input type="radio" name="hisab_category" id="hc_fuel" value="Fuel" @checked(optional($info)->hisab_category==='Fuel')><label for="hc_fuel">Fuel</label></span>
                            </div></div>
                        <div class="cv2-field"><label class="cv2-label">Opening Balance Date</label><input type="date" name="opening_balance_date" value="{{ optional($info)->opening_balance_date }}"></div>
                        <div class="cv2-field"><label class="cv2-label">Opening Balance Type</label>
                            <div class="cv2-radio-group">
                                <span class="cv2-radio"><input type="radio" name="opening_balance_type" id="ob_cr" value="Credit" @checked(optional($info)->opening_balance_type==='Credit')><label for="ob_cr">Credit</label></span>
                                <span class="cv2-radio"><input type="radio" name="opening_balance_type" id="ob_dr" value="Debit" @checked(optional($info)->opening_balance_type==='Debit')><label for="ob_dr">Debit</label></span>
                            </div></div>
                        <div class="cv2-field"><label class="cv2-label">Opening Balance (₹)</label><input type="number" name="opening_balance" value="{{ optional($info)->opening_balance }}" min="0"></div>
                    </div></div>
                </div>

                <div class="cv2-card">
                    <div class="cv2-card-h"><h3>Guarantor</h3></div>
                    <div class="cv2-card-b"><div class="cv2-form-grid">
                        <div class="cv2-field"><label class="cv2-label">Guarantor Name</label><input type="text" name="guarantor_name" value="{{ optional($info)->guarantor_name }}"></div>
                        <div class="cv2-field"><label class="cv2-label">Guarantor Phone</label><input type="tel" name="guarantor_phone" value="{{ optional($info)->guarantor_phone }}" data-intl-phone="1"></div>
                    </div></div>
                </div>

                <div class="cv2-card">
                    <div class="cv2-card-h"><h3>Emergency Contacts</h3>
                        <a href="javascript:void(0)" class="cv2-link" id="cv2AddPerson"><i class="bi bi-plus-lg"></i> Add another</a></div>
                    <div class="cv2-card-b" id="cv2PersonWrap">
                        @forelse($contact->relcontacts as $rc)
                        <div class="cv2-repeat-row">
                            <button type="button" class="cv2-remove" title="Remove"><i class="bi bi-x-lg"></i></button>
                            <div class="cv2-form-grid is-3">
                                <div class="cv2-field"><label class="cv2-label">Name <span class="req">*</span></label><input type="text" name="contact_person_name[]" value="{{ $rc->name }}"></div>
                                <div class="cv2-field"><label class="cv2-label">Relation <span class="req">*</span></label><input type="text" name="contact_person_relation[]" value="{{ $rc->relationship }}"></div>
                                <div class="cv2-field"><label class="cv2-label">Blood Group</label><select name="contact_person_blood_group[]"><option value="">Choose…</option>@foreach (['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $bg)<option value="{{ $bg }}" @selected($rc->blood_group === $bg)>{{ $bg }}</option>@endforeach</select></div>
                                <div class="cv2-field"><label class="cv2-label">Phone <span class="req">*</span></label><input type="tel" name="contact_person_phone[]" value="{{ $rc->phone }}" data-intl-phone="1"></div>
                                <div class="cv2-field"><label class="cv2-label">WhatsApp</label><input type="tel" name="contact_person_whatsapp[]" value="{{ $rc->whatsapp }}" data-intl-phone="1"></div>
                                <div class="cv2-field"><label class="cv2-label">Address</label><input type="text" name="contact_person_address[]" value="{{ $rc->address }}"></div>
                            </div>
                        </div>
                        @empty
                        <div class="cv2-repeat-row">
                            <div class="cv2-form-grid is-3">
                                <div class="cv2-field"><label class="cv2-label">Name <span class="req">*</span></label><input type="text" name="contact_person_name[]"></div>
                                <div class="cv2-field"><label class="cv2-label">Relation <span class="req">*</span></label><input type="text" name="contact_person_relation[]"></div>
                                <div class="cv2-field"><label class="cv2-label">Blood Group</label><select name="contact_person_blood_group[]"><option value="">Choose…</option><option>A+</option><option>A-</option><option>B+</option><option>B-</option><option>AB+</option><option>AB-</option><option>O+</option><option>O-</option></select></div>
                                <div class="cv2-field"><label class="cv2-label">Phone <span class="req">*</span></label><input type="tel" name="contact_person_phone[]" data-intl-phone="1"></div>
                                <div class="cv2-field"><label class="cv2-label">WhatsApp</label><input type="tel" name="contact_person_whatsapp[]" data-intl-phone="1"></div>
                                <div class="cv2-field"><label class="cv2-label">Address</label><input type="text" name="contact_person_address[]"></div>
                            </div>
                        </div>
                        @endforelse
                    </div>
                </div>

                <div class="cv2-card">
                    <div class="cv2-card-h"><h3>Comment</h3></div>
                    <div class="cv2-card-b"><div class="cv2-field"><label class="cv2-label">Note</label><input type="text" name="contact_comment" value="{{ $contact->comment }}" maxlength="255"></div></div>
                </div>

            </div>

            <div>
                <div class="cv2-card">
                    <div class="cv2-card-h"><h3>Status</h3></div>
                    <div class="cv2-card-b">
                        <div class="cv2-field"><label class="cv2-label">Driver Status</label>
                            <select class="cv2-select" id="cv2Status" name="status" style="width:100%;">
                                @foreach(['Active','Inactive','Blacklisted'] as $st)<option @selected($contact->status===$st)>{{ $st }}</option>@endforeach
                            </select></div>
                        <div class="cv2-field cv2-mt"><label class="cv2-label">RAG Status</label>
                            <select class="cv2-select" name="rag_status" style="width:100%;"><option value="">Choose…</option>
                            @foreach(['Green','Yellow','Red'] as $rg)<option @selected($contact->rag_status===$rg)>{{ $rg }}</option>@endforeach
                            </select></div>

                        <div id="cv2StatusTypeWrap" style="display:none;">
                            <div class="cv2-field cv2-mt"><label class="cv2-label">Status Type <span class="req">*</span></label>
                                <div class="cv2-radio-group">
                                    <span class="cv2-radio"><input type="radio" name="status_type" id="st_leave" value="On Leave" @checked(optional($info)->status_type==='On Leave')><label for="st_leave">On Leave</label></span>
                                    <span class="cv2-radio"><input type="radio" name="status_type" id="st_vexit" value="Voluntary Exit" @checked(optional($info)->status_type==='Voluntary Exit')><label for="st_vexit">Voluntary Exit</label></span>
                                </div></div>
                            <div class="cv2-field cv2-mt cv2-cond" data-st="On Leave" style="display:none;"><label class="cv2-label">Expected Return Date <span class="req">*</span></label><input type="date" name="expected_return_date" value="{{ optional($info)->expected_return_date }}"></div>
                            <div class="cv2-field cv2-mt cv2-cond" data-st="On Leave" style="display:none;"><label class="cv2-label">Set Reminder</label>
                                <div class="cv2-radio-group">
                                    <span class="cv2-radio"><input type="radio" name="set_reminder" id="sr_yes" value="Yes" @checked(optional($info)->set_reminder==='Yes')><label for="sr_yes">Yes</label></span>
                                    <span class="cv2-radio"><input type="radio" name="set_reminder" id="sr_no" value="No" @checked(optional($info)->set_reminder==='No')><label for="sr_no">No</label></span>
                                </div></div>
                            <div class="cv2-field cv2-mt cv2-cond" data-st="Voluntary Exit" style="display:none;"><label class="cv2-label">Voluntary Exit Reason <span class="req">*</span></label><textarea name="voluntary_exit_reason" rows="2">{{ optional($info)->voluntary_exit_reason }}</textarea></div>
                            <div class="cv2-field cv2-mt cv2-cond" data-st="Voluntary Exit" style="display:none;"><label class="cv2-label">Vehicle Handover Photos</label>
                                @if($contact->driverVehiclePhotos && $contact->driverVehiclePhotos->count())
                                    <div class="cv2-hint" style="margin-bottom:6px;">Current:
                                        @foreach($contact->driverVehiclePhotos as $vp)<a href="{{ asset('media/contact/'.$vp->file_name) }}" target="_blank">photo {{ $loop->iteration }}</a>@if(!$loop->last), @endif @endforeach
                                    </div>
                                @endif
                                <input type="file" name="vehicle_photos[]" accept=".jpg,.jpeg,.png" multiple class="cv2-file">
                                <span class="cv2-hint">Upload to add more · existing photos are kept</span></div>
                        </div>

                        <div class="cv2-field cv2-mt" id="cv2BlacklistWrap" style="display:none;"><label class="cv2-label">Blacklist Reason <span class="req">*</span></label><textarea name="blacklist_reason" rows="3">{{ $contact->blacklist_reason }}</textarea></div>
                    </div>
                </div>

                <div class="cv2-card cv2-mt">
                    <div class="cv2-card-b" style="display:flex;flex-direction:column;gap:10px;">
                        <button type="submit" class="cv2-btn cv2-btn-primary cv2-btn-lg" style="justify-content:center;"><i class="bi bi-check2"></i>Update Driver</button>
                        <a href="{{ route('contact.v2.driver.show', $contact->id) }}" class="cv2-btn cv2-btn-ghost" style="justify-content:center;">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div></div>
</div>
@endsection
@section('js')<script src="{{ asset('js/V2/driver.js?v=2.4') }}"></script>@endsection
