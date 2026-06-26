@extends('layouts.app')

@section('css')
<link href="{{ asset('css/V2/customer.css?v=1.4') }}" rel="stylesheet">
@endsection

@section('content')
@php
    $specIds = $contact->specialisation ? array_map('trim', explode(',', $contact->specialisation)) : [];
    $bankRows = $contact->bankDetails->count() ? $contact->bankDetails : collect([null]);
    $primaryIndex = 0;
    foreach ($bankRows as $bi => $br) { if ($br && $br->is_primary === 'Yes') { $primaryIndex = $bi; } }
    $persons = $contact->relcontacts->count() ? $contact->relcontacts : collect([null]);
@endphp
<div class="layout-wrapper">
    @include('includes.header')
    <div class="cv2-wrap">
        <div class="cv2-container">

            <div class="cv2-phead">
                <div class="cv2-crumb"><a href="{{ route('contact.v2.sparevendor.index') }}">Spare Vendors</a> · {{ $v['company'] }} · Edit Info</div>
            </div>
            @include('V2.sparevendor.partials.workspace-head')

            <form id="cv2EditForm" action="{{ route('contact.v2.sparevendor.update', $v['id']) }}" method="POST" enctype="multipart/form-data" class="cv2-mt" data-show-url="{{ route('contact.v2.sparevendor.index') }}" data-person-wrapper-url="{{ route('contact.v2.sparevendor.contactpersonwrapper') }}">
            @csrf
            <input type="hidden" name="contact_id" value="{{ $v['id'] }}">
            <div class="cv2-grid cv2-grid-2-1">
                <div style="display:flex;flex-direction:column;gap:16px;">

                    {{-- Basic --}}
                    <div class="cv2-card">
                        <div class="cv2-card-h"><h3>Basic Information</h3></div>
                        <div class="cv2-card-b"><div class="cv2-form-grid">
                            <div class="cv2-field"><label class="cv2-label">GST Number</label><input type="text" name="gst_number" value="{{ old('gst_number', $contact->gstin) }}" maxlength="100"></div>
                            <div class="cv2-field"><label class="cv2-label">Company Name <span class="req">*</span></label><input type="text" name="company_name" value="{{ old('company_name', $contact->company_name) }}" maxlength="100"></div>
                            <div class="cv2-field"><label class="cv2-label">Contact Name <span class="req">*</span></label><input type="text" name="contact_name" value="{{ old('contact_name', $contact->contact_name) }}" maxlength="100"></div>
                            <div class="cv2-field"><label class="cv2-label">Contact Code <span class="req">*</span></label><input type="text" name="contact_code" value="{{ old('contact_code', $contact->contact_code) }}" maxlength="100"></div>
                            <div class="cv2-field is-full"><label class="cv2-label">Specialisation</label>
                                <select class="cv2-select" name="specialisation[]" multiple style="width:100%;">
                                    @foreach($spareCategories as $cat)
                                        <option value="{{ $cat->id }}" {{ in_array((string) $cat->id, $specIds, true) ? 'selected' : '' }}>{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                                <span class="cv2-help">Stored as comma-joined tags.</span>
                            </div>
                            <div class="cv2-field is-full"><label class="cv2-label">Comment</label><input type="text" name="contact_comment" value="{{ old('contact_comment', $contact->comment) }}" placeholder="Optional note" maxlength="255"></div>
                        </div></div>
                    </div>

                    {{-- Contact details --}}
                    <div class="cv2-card">
                        <div class="cv2-card-h"><h3>Contact Details</h3></div>
                        <div class="cv2-card-b"><div class="cv2-form-grid">
                            <div class="cv2-field"><label class="cv2-label">Phone <span class="req">*</span></label><input type="tel" name="phone" data-intl-phone="1" value="{{ old('phone', trim(($contact->ph_prefix ? '+'.ltrim($contact->ph_prefix,'+').' ' : '').$contact->phone)) }}"></div>
                            <div class="cv2-field"><label class="cv2-label">WhatsApp</label><input type="tel" name="whatsapp" data-intl-phone="1" value="{{ old('whatsapp', $contact->whatsapp ? trim(($contact->whatsapp_prefix ? '+'.ltrim($contact->whatsapp_prefix,'+').' ' : '').$contact->whatsapp) : '') }}"></div>
                            <div class="cv2-field is-full"><label class="cv2-label">Email</label><input type="email" name="email" value="{{ old('email', $contact->email) }}"></div>
                        </div></div>
                    </div>

                    {{-- Company details --}}
                    <div class="cv2-card">
                        <div class="cv2-card-h"><h3>Company Details</h3></div>
                        <div class="cv2-card-b"><div class="cv2-form-grid">
                            <div class="cv2-field"><label class="cv2-label">Full Company Name</label><input type="text" name="full_company_name" value="{{ old('full_company_name', $contact->full_company_name) }}" maxlength="100"></div>
                            <div class="cv2-field"><label class="cv2-label">Company Owner</label><input type="text" name="company_owner" value="{{ old('company_owner', $contact->company_owner) }}" maxlength="100"></div>
                            <div class="cv2-field"><label class="cv2-label">Registration No</label><input type="text" name="company_registration_no" value="{{ old('company_registration_no', $contact->company_registration_no) }}" maxlength="100"></div>
                            <div class="cv2-field"><label class="cv2-label">Registration Date</label><input type="date" name="company_registration_date" value="{{ old('company_registration_date', optional($contact->company_registration_date)->format('Y-m-d') ?? $contact->company_registration_date) }}"></div>
                            <div class="cv2-field"><label class="cv2-label">Working Since</label><input type="date" name="working_since" value="{{ old('working_since', optional($contact->working_since)->format('Y-m-d') ?? $contact->working_since) }}"></div>
                            <div class="cv2-field"><label class="cv2-label">PAN No</label><input type="text" name="pan_no" value="{{ old('pan_no', $contact->pan_no) }}" maxlength="100"></div>
                            <div class="cv2-field"><label class="cv2-label">PAN Status</label>
                                <select class="cv2-select" name="pan_status_id" style="width:100%;">
                                    <option value="">Choose…</option>
                                    @foreach($pan_statuses as $ps)
                                        <option value="{{ $ps->id }}" {{ old('pan_status_id', $contact->pan_status_id) == $ps->id ? 'selected' : '' }}>{{ $ps->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="cv2-field"><label class="cv2-label">TDS Percentage</label><input type="number" name="tds_percentage" min="0" max="100" step="0.01" value="{{ old('tds_percentage', $contact->tds_percentage) }}">
                                <span class="cv2-help">Advisory: if 0% or 1%, add a TDS Declaration on the Documents page.</span>
                            </div>
                        </div></div>
                    </div>

                    {{-- Address --}}
                    <div class="cv2-card">
                        <div class="cv2-card-h"><h3>Address</h3></div>
                        <div class="cv2-card-b"><div class="cv2-form-grid">
                            <div class="cv2-field is-full"><label class="cv2-label">Address <span class="req">*</span></label><textarea name="address" rows="2" maxlength="1000">{{ old('address', $contact->address1) }}</textarea></div>
                            <div class="cv2-field"><label class="cv2-label">State <span class="req">*</span></label>
                                <select class="cv2-select cv2-state" name="state_id" data-city-target="#cv2SpareCity" style="width:100%;">
                                    <option value="">Choose state…</option>
                                    @foreach($states as $st)
                                        <option value="{{ $st->id }}" data-cities='@json($st->cities->map(fn($ci)=>["id"=>$ci->id,"name"=>$ci->name]))' {{ old('state_id', $contact->state_id) == $st->id ? 'selected' : '' }}>{{ $st->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="cv2-field"><label class="cv2-label">City <span class="req">*</span></label>
                                <select class="cv2-select" id="cv2SpareCity" name="city_id" data-old="{{ old('city_id', $contact->city_id) }}" style="width:100%;">
                                    <option value="">Choose city…</option>
                                    @if($contact->state)
                                        @foreach($contact->state->cities as $ci)
                                            <option value="{{ $ci->id }}" {{ old('city_id', $contact->city_id) == $ci->id ? 'selected' : '' }}>{{ $ci->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="cv2-field"><label class="cv2-label">Postal Code</label><input type="text" name="post_code" value="{{ old('post_code', $contact->zipcode) }}" maxlength="6"></div>
                            <div class="cv2-field is-full"><label class="cv2-label">Additional Info</label><textarea name="additional_info" rows="2" maxlength="10000">{{ old('additional_info', $contact->additional_info) }}</textarea></div>
                        </div></div>
                    </div>

                    {{-- Bank details (E3 repeater, prefilled) --}}
                    <div class="cv2-card">
                        <div class="cv2-card-h"><h3>Bank Details <span class="cv2-pill" style="font-weight:600;">At least 1 · exactly 1 Primary</span></h3>
                            <a href="javascript:void(0)" class="cv2-link" id="cv2AddBank"><i class="bi bi-plus-lg"></i> Add bank</a></div>
                        <div class="cv2-card-b" id="cv2BankWrap">
                            @foreach($bankRows as $bi => $br)
                            <div class="cv2-repeat-row">
                                @if($bi > 0)<button type="button" class="cv2-remove" title="Remove"><i class="bi bi-x-lg"></i></button>@endif
                                <div class="cv2-form-grid is-3">
                                    <div class="cv2-field"><label class="cv2-label">Bank <span class="req">*</span></label>
                                        <select class="cv2-select cv2-plain" name="bank_id[]" style="width:100%;">
                                            <option value="">Choose bank</option>
                                            @foreach($banks as $bank)
                                                <option value="{{ $bank->id }}" {{ optional($br)->bank_id == $bank->id ? 'selected' : '' }}>{{ $bank->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="cv2-field"><label class="cv2-label">Account Number <span class="req">*</span></label><input type="text" name="account_number[]" value="{{ optional($br)->account_number }}"></div>
                                    <div class="cv2-field"><label class="cv2-label">IFSC Code <span class="req">*</span></label><input type="text" name="ifsc_code[]" value="{{ optional($br)->ifsc_code }}"></div>
                                    <div class="cv2-field"><label class="cv2-label">UPI ID</label><input type="text" name="upi_id[]" value="{{ optional($br)->upi_id }}"></div>
                                    <div class="cv2-field"><label class="cv2-label">Primary</label>
                                        <div class="cv2-radio-group"><span class="cv2-radio"><input type="radio" name="primary_bank" value="{{ $bi }}" {{ $bi === $primaryIndex ? 'checked' : '' }}><label>Primary</label></span></div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Contact persons --}}
                    <div class="cv2-card">
                        <div class="cv2-card-h"><h3>Contact Persons <span class="cv2-pill" style="font-weight:600;">At least 1</span></h3>
                            <a href="javascript:void(0)" class="cv2-link" id="cv2AddPerson"><i class="bi bi-plus-lg"></i> Add another</a></div>
                        <div class="cv2-card-b" id="cv2PersonWrap">
                            @foreach($persons as $i => $rel)
                            <div class="cv2-repeat-row" data-index="{{ $i }}">
                                @if($i > 0)<button type="button" class="cv2-remove" title="Remove"><i class="bi bi-x-lg"></i></button>@endif
                                <input type="hidden" name="contact_person_id[{{ $i }}]" value="{{ optional($rel)->id }}">
                                <input type="hidden" name="contact_person_ph_code[]" class="cv2-cp-phcode" value="{{ optional($rel)->ph_prefix }}">
                                <input type="hidden" name="contact_person_whatsapp_code[]" class="cv2-cp-wacode" value="{{ optional($rel)->whatsapp_prefix }}">
                                <div class="cv2-form-grid is-3">
                                    <div class="cv2-field"><label class="cv2-label">Name <span class="req">*</span></label><input type="text" name="contact_person_name[{{ $i }}]" value="{{ optional($rel)->name }}"></div>
                                    <div class="cv2-field"><label class="cv2-label">Designation <span class="req">*</span></label><input type="text" name="contact_person_designation[{{ $i }}]" value="{{ optional($rel)->position }}"></div>
                                    <div class="cv2-field"><label class="cv2-label">Phone <span class="req">*</span></label><input type="tel" name="contact_person_phone[{{ $i }}]" data-intl-phone="1" value="{{ optional($rel)->phone ? '+'.ltrim(optional($rel)->ph_prefix ?: '91', '+').' '.optional($rel)->phone : '' }}"></div>
                                    <div class="cv2-field"><label class="cv2-label">Email</label><input type="email" name="contact_person_email[{{ $i }}]" value="{{ optional($rel)->email }}"></div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                </div>

                {{-- Right rail --}}
                <div>
                    <div class="cv2-card">
                        <div class="cv2-card-h"><h3>Status</h3></div>
                        <div class="cv2-card-b">
                            <div class="cv2-field"><label class="cv2-label">Vendor Status</label>
                                <select class="cv2-select" id="cv2Status" name="status" style="width:100%;">
                                    <option value="Active" {{ old('status', $contact->status)=='Active'?'selected':'' }}>Active</option>
                                    <option value="Inactive" {{ old('status', $contact->status)=='Inactive'?'selected':'' }}>Inactive</option>
                                    <option value="Blacklisted" {{ old('status', $contact->status)=='Blacklisted'?'selected':'' }}>Blacklisted</option>
                                </select>
                            </div>
                            <div class="cv2-field cv2-mt" id="cv2BlacklistWrap" style="{{ old('status', $contact->status)=='Blacklisted'?'':'display:none;' }}">
                                <label class="cv2-label">Blacklist Reason <span class="req">*</span></label>
                                <textarea name="blacklist_reason" rows="3" placeholder="Why is this vendor being blacklisted?">{{ old('blacklist_reason', $contact->blacklist_reason) }}</textarea>
                                <span class="cv2-hint">A blacklist note is logged to the activity trail.</span>
                            </div>
                        </div>
                    </div>
                    <div class="cv2-card cv2-mt">
                        <div class="cv2-card-h"><h3>Documents</h3></div>
                        <div class="cv2-card-b">
                            <div class="cv2-locked"><i class="bi bi-paperclip"></i><div><b>{{ $counts['documents'] }} documents</b><div class="cv2-hint">Managed on the Documents page</div></div></div>
                            <a href="{{ route('contact.v2.sparevendor.documents', $v['id']) }}" class="cv2-btn cv2-btn-ghost cv2-mt" style="width:100%;justify-content:center;"><i class="bi bi-folder2-open"></i>Open Documents</a>
                        </div>
                    </div>
                    <div class="cv2-card cv2-mt"><div class="cv2-card-b" style="display:flex;flex-direction:column;gap:10px;">
                        <button type="submit" class="cv2-btn cv2-btn-primary" style="justify-content:center;"><i class="bi bi-check2"></i>Save Changes</button>
                        <a href="{{ route('contact.v2.sparevendor.show', $v['id']) }}" class="cv2-btn cv2-btn-ghost" style="justify-content:center;">Cancel</a>
                    </div></div>
                </div>
            </div>
            </form>

        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('js/V2/customer.js?v=1.7') }}"></script>
<script src="{{ asset('js/V2/sparevendor.js?v=2.0') }}"></script>
@endsection
