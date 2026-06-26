@extends('layouts.app')
@section('css')<link href="{{ asset('css/V2/tyrevendor.css?v=1.0') }}" rel="stylesheet">@endsection
@section('content')
@php
    use Carbon\Carbon;
    $primaryBankSet = $contact->bankDetails->firstWhere('is_primary','Yes');
@endphp
<div class="layout-wrapper">
    @include('includes.header')
    <div class="cv2-wrap"><div class="cv2-container">
        <div class="cv2-phead">
            <div class="cv2-crumb"><a href="{{ route('contact.v2.tyrevendor.index') }}">Tyre Vendors</a> · {{ $v['company'] }} · Edit Info</div>
        </div>
        @include('V2.tyrevendor.partials.workspace-head')

        <form id="cv2EditForm" action="{{ route('contact.v2.tyrevendor.update', $v['id']) }}" method="POST" enctype="multipart/form-data" class="cv2-mt">
        @csrf
        <input type="hidden" name="phone_code" value="{{ $contact->ph_prefix ?: '+91' }}">
        <input type="hidden" name="whatsapp_code" value="{{ $contact->whatsapp_prefix ?: '+91' }}">
        <div class="cv2-grid cv2-grid-2-1">
            <div style="display:flex;flex-direction:column;gap:16px;">

                {{-- Company info --}}
                <div class="cv2-card">
                    <div class="cv2-card-h"><h3>Company Information</h3></div>
                    <div class="cv2-card-b"><div class="cv2-form-grid">
                        <div class="cv2-field"><label class="cv2-label">Company Name <span class="req">*</span></label><input type="text" name="company_name" value="{{ $contact->company_name }}" maxlength="100"></div>
                        <div class="cv2-field"><label class="cv2-label">Full Company Name</label><input type="text" name="full_company_name" value="{{ $contact->full_company_name }}" maxlength="100"></div>
                        <div class="cv2-field"><label class="cv2-label">Contact Name <span class="req">*</span></label><input type="text" name="contact_name" value="{{ $contact->contact_name }}" maxlength="100"></div>
                        <div class="cv2-field"><label class="cv2-label">Contact Code <span class="req">*</span></label><input type="text" name="contact_code" value="{{ $contact->contact_code }}" maxlength="100" readonly style="background:#f1f3f5;cursor:not-allowed;"></div>
                        <div class="cv2-field"><label class="cv2-label">Company Owner</label><input type="text" name="company_owner" value="{{ $contact->company_owner }}" maxlength="100"></div>
                        <div class="cv2-field"><label class="cv2-label">Working Since</label><input type="date" name="working_since" value="{{ $contact->working_since ? Carbon::parse($contact->working_since)->format('Y-m-d') : '' }}" max="{{ date('Y-m-d') }}"></div>
                        <div class="cv2-field"><label class="cv2-label">Company Registration No</label><input type="text" name="company_registration_no" value="{{ $contact->company_registration_no }}" maxlength="100"></div>
                        <div class="cv2-field"><label class="cv2-label">Company Registration Date</label><input type="date" name="company_registration_date" value="{{ $contact->company_registration_date ? Carbon::parse($contact->company_registration_date)->format('Y-m-d') : '' }}" max="{{ date('Y-m-d') }}"></div>
                        {{-- E7: NO size field --}}
                        <div class="cv2-field is-full"><label class="cv2-label">Comment</label><input type="text" name="contact_comment" value="{{ $contact->comment }}" maxlength="255"></div>
                    </div></div>
                </div>

                {{-- Contact details --}}
                <div class="cv2-card">
                    <div class="cv2-card-h"><h3>Contact Details</h3></div>
                    <div class="cv2-card-b"><div class="cv2-form-grid">
                        <div class="cv2-field"><label class="cv2-label">Phone <span class="req">*</span></label><input type="tel" name="phone" data-intl-phone="1" value="{{ $contact->phone }}"></div>
                        <div class="cv2-field"><label class="cv2-label">WhatsApp</label><input type="tel" name="whatsapp" data-intl-phone="1" value="{{ $contact->whatsapp }}"></div>
                    </div></div>
                </div>

                {{-- Tax & compliance --}}
                <div class="cv2-card">
                    <div class="cv2-card-h"><h3>Tax &amp; Compliance</h3></div>
                    <div class="cv2-card-b"><div class="cv2-form-grid">
                        <div class="cv2-field"><label class="cv2-label">PAN No</label><input type="text" name="pan_no" value="{{ $contact->pan_no }}" maxlength="100"></div>
                        <div class="cv2-field"><label class="cv2-label">PAN Status</label>
                            <select class="cv2-select" name="pan_status_id" style="width:100%;">
                                <option value="">Choose…</option>
                                @foreach($pan_statuses as $ps)<option value="{{ $ps->id }}" {{ (string)$contact->pan_status_id === (string)$ps->id ? 'selected' : '' }}>{{ $ps->name }}</option>@endforeach
                            </select>
                        </div>
                        <div class="cv2-field"><label class="cv2-label">GST Treatment</label>
                            <select class="cv2-select" name="gst_treatment" id="cv2GstTreatment" style="width:100%;">
                                <option value="">Choose…</option>
                                <option value="Registered" {{ $contact->gst_treatment === 'Registered' ? 'selected' : '' }}>Registered</option>
                                <option value="Unregistered" {{ $contact->gst_treatment === 'Unregistered' ? 'selected' : '' }}>Unregistered</option>
                            </select>
                        </div>
                        <div class="cv2-field cv2-cond" data-gst="Registered"><label class="cv2-label">GST Number <span class="req">*</span></label><input type="text" name="gst_number" value="{{ $contact->gst_number }}" maxlength="100"></div>
                        <div class="cv2-field"><label class="cv2-label">TDS Percentage</label><input type="number" step="0.01" min="0" max="100" name="tds_percentage" id="cv2TdsPct" value="{{ $contact->tds_percentage }}"></div>
                        <div class="cv2-field" id="cv2TdsDeclWrap" style="display:none;">
                            <label class="cv2-label">TDS Declaration <span class="req">*</span></label>
                            <input type="file" name="tds_declaration" accept=".jpg,.jpeg,.png,.pdf">
                            <span class="cv2-help">Required because TDS % is 0 or 1. Skip if already uploaded on the Documents page.</span>
                        </div>
                    </div></div>
                </div>

                {{-- Address --}}
                <div class="cv2-card">
                    <div class="cv2-card-h"><h3>Address</h3></div>
                    <div class="cv2-card-b"><div class="cv2-form-grid">
                        <div class="cv2-field is-full"><label class="cv2-label">Address <span class="req">*</span></label><textarea name="address" rows="2" maxlength="1000">{{ $contact->address1 }}</textarea></div>
                        <div class="cv2-field"><label class="cv2-label">State <span class="req">*</span></label>
                            <select class="cv2-select cv2-state" name="state_id" data-city-target="#cv2City" style="width:100%;">
                                <option value="">Choose state…</option>
                                @foreach($states as $state)
                                    <option value="{{ $state->id }}" data-cities='@json($state->cities->map(fn($c)=>["id"=>$c->id,"name"=>$c->name])->values())' {{ (string)$contact->state_id === (string)$state->id ? 'selected' : '' }}>{{ $state->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="cv2-field"><label class="cv2-label">City <span class="req">*</span></label>
                            <select class="cv2-select" name="city_id" id="cv2City" data-old="{{ $contact->city_id }}" style="width:100%;">
                                <option value="">Choose city…</option>
                                @if($contact->state)
                                    @foreach($contact->state->cities as $city)
                                        <option value="{{ $city->id }}" {{ (string)$contact->city_id === (string)$city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="cv2-field"><label class="cv2-label">Postal Code <span class="req">*</span></label><input type="text" name="post_code" value="{{ $contact->zipcode }}" maxlength="6"></div>
                        <div class="cv2-field is-full"><label class="cv2-label">Additional Info</label><textarea name="additional_info" rows="2" maxlength="10000">{{ $contact->additional_info }}</textarea></div>
                    </div></div>
                </div>

                {{-- E3: Bank details repeater (prefilled) --}}
                <div class="cv2-card">
                    <div class="cv2-card-h"><h3>Bank Details <span class="cv2-pill" style="font-weight:600;">At least 1 · one Primary</span></h3>
                        <a href="javascript:void(0)" class="cv2-link" id="cv2AddBank"><i class="bi bi-plus-lg"></i> Add another</a></div>
                    <div class="cv2-card-b" id="cv2BankWrap">
                        @forelse($contact->bankDetails as $i => $bd)
                        <div class="cv2-bank-row">
                            @if(!$loop->first)<button type="button" class="cv2-remove" title="Remove"><i class="bi bi-x-lg"></i></button>@endif
                            <input type="hidden" name="contact_bank_id[]" value="{{ $bd->id }}">
                            <div class="cv2-bank-head">
                                <label class="cv2-primary-pick"><input type="radio" name="primary_bank" value="{{ $i }}" {{ $bd->is_primary === 'Yes' ? 'checked' : '' }}> Set as primary account</label>
                            </div>
                            <div class="cv2-form-grid is-3">
                                <div class="cv2-field"><label class="cv2-label">Bank <span class="req">*</span></label>
                                    <select class="cv2-select cv2-plain" name="bank_id[]" style="width:100%;">
                                        <option value="">Choose bank</option>
                                        @foreach($banks as $bank)<option value="{{ $bank->id }}" {{ (string)$bd->bank_id === (string)$bank->id ? 'selected' : '' }}>{{ $bank->name }}</option>@endforeach
                                    </select>
                                </div>
                                <div class="cv2-field"><label class="cv2-label">Beneficiary Name</label><input type="text" name="beneficiary_name[]" value="{{ $bd->beneficiary_name }}"></div>
                                <div class="cv2-field"><label class="cv2-label">Account Number <span class="req">*</span></label><input type="text" name="account_number[]" value="{{ $bd->account_number }}"></div>
                                <div class="cv2-field"><label class="cv2-label">IFSC Code <span class="req">*</span></label><input type="text" name="ifsc_code[]" value="{{ $bd->ifsc_code }}"></div>
                                <div class="cv2-field"><label class="cv2-label">UPI ID</label><input type="text" name="upi_id[]" value="{{ $bd->upi_id }}"></div>
                            </div>
                        </div>
                        @empty
                        <div class="cv2-bank-row">
                            <input type="hidden" name="contact_bank_id[]" value="">
                            <div class="cv2-bank-head"><label class="cv2-primary-pick"><input type="radio" name="primary_bank" value="0" checked> Set as primary account</label></div>
                            <div class="cv2-form-grid is-3">
                                <div class="cv2-field"><label class="cv2-label">Bank <span class="req">*</span></label>
                                    <select class="cv2-select cv2-plain" name="bank_id[]" style="width:100%;"><option value="">Choose bank</option>@foreach($banks as $bank)<option value="{{ $bank->id }}">{{ $bank->name }}</option>@endforeach</select>
                                </div>
                                <div class="cv2-field"><label class="cv2-label">Beneficiary Name</label><input type="text" name="beneficiary_name[]"></div>
                                <div class="cv2-field"><label class="cv2-label">Account Number <span class="req">*</span></label><input type="text" name="account_number[]"></div>
                                <div class="cv2-field"><label class="cv2-label">IFSC Code <span class="req">*</span></label><input type="text" name="ifsc_code[]"></div>
                                <div class="cv2-field"><label class="cv2-label">UPI ID</label><input type="text" name="upi_id[]"></div>
                            </div>
                        </div>
                        @endforelse
                    </div>
                </div>

                {{-- Contact persons (prefilled) --}}
                <div class="cv2-card">
                    <div class="cv2-card-h"><h3>Contact Persons <span class="cv2-pill" style="font-weight:600;">At least 1</span></h3>
                        <a href="javascript:void(0)" class="cv2-link" id="cv2AddPerson"><i class="bi bi-plus-lg"></i> Add another</a></div>
                    <div class="cv2-card-b" id="cv2PersonWrap">
                        @forelse($contact->relcontacts as $rel)
                        <div class="cv2-repeat-row">
                            @if(!$loop->first)<button type="button" class="cv2-remove" title="Remove"><i class="bi bi-x-lg"></i></button>@endif
                            <input type="hidden" name="contact_person_id[]" value="{{ $rel->id }}">
                            <div class="cv2-form-grid is-3">
                                <div class="cv2-field"><label class="cv2-label">Name <span class="req">*</span></label><input type="text" name="contact_person_name[]" value="{{ $rel->name }}"></div>
                                <div class="cv2-field"><label class="cv2-label">Designation</label><input type="text" name="contact_person_designation[]" value="{{ $rel->position }}"></div>
                                <div class="cv2-field"><label class="cv2-label">Phone <span class="req">*</span></label><input type="tel" name="contact_person_phone[]" data-intl-phone="1" value="{{ $rel->phone }}"></div>
                                <div class="cv2-field"><label class="cv2-label">WhatsApp</label><input type="tel" name="contact_person_whatsapp[]" data-intl-phone="1" value="{{ $rel->whatsapp }}"></div>
                                <div class="cv2-field"><label class="cv2-label">Email</label><input type="email" name="contact_person_email[]" value="{{ $rel->email }}"></div>
                                <div class="cv2-field"><label class="cv2-label">Comment</label><input type="text" name="contact_person_comment[]" value="{{ $rel->comment }}"></div>
                            </div>
                        </div>
                        @empty
                        <div class="cv2-repeat-row">
                            <input type="hidden" name="contact_person_id[]" value="">
                            <div class="cv2-form-grid is-3">
                                <div class="cv2-field"><label class="cv2-label">Name <span class="req">*</span></label><input type="text" name="contact_person_name[]"></div>
                                <div class="cv2-field"><label class="cv2-label">Designation</label><input type="text" name="contact_person_designation[]"></div>
                                <div class="cv2-field"><label class="cv2-label">Phone <span class="req">*</span></label><input type="tel" name="contact_person_phone[]" data-intl-phone="1"></div>
                                <div class="cv2-field"><label class="cv2-label">WhatsApp</label><input type="tel" name="contact_person_whatsapp[]" data-intl-phone="1"></div>
                                <div class="cv2-field"><label class="cv2-label">Email</label><input type="email" name="contact_person_email[]"></div>
                                <div class="cv2-field"><label class="cv2-label">Comment</label><input type="text" name="contact_person_comment[]"></div>
                            </div>
                        </div>
                        @endforelse
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
                                <option value="Active" {{ $contact->status === 'Active' ? 'selected' : '' }}>Active</option>
                                <option value="Inactive" {{ $contact->status === 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="Blacklisted" {{ $contact->status === 'Blacklisted' ? 'selected' : '' }}>Blacklisted</option>
                            </select>
                        </div>
                        <div class="cv2-field cv2-mt" id="cv2BlacklistWrap" style="{{ $contact->status === 'Blacklisted' ? '' : 'display:none;' }}">
                            <label class="cv2-label">Blacklist Reason <span class="req">*</span></label>
                            <textarea name="blacklist_reason" rows="3" placeholder="Why is this vendor being blacklisted?">{{ $contact->blacklist_reason }}</textarea>
                            <span class="cv2-hint">A blacklist note is logged to the activity trail.</span>
                        </div>
                    </div>
                </div>
                <div class="cv2-card cv2-mt">
                    <div class="cv2-card-h"><h3>Documents</h3></div>
                    <div class="cv2-card-b">
                        <div class="cv2-locked"><i class="bi bi-paperclip"></i><div><b>{{ $counts['documents'] }} documents</b><div class="cv2-hint">Managed on the Documents page</div></div></div>
                        <a href="{{ route('contact.v2.tyrevendor.documents', $v['id']) }}" class="cv2-btn cv2-btn-ghost cv2-mt" style="width:100%;justify-content:center;"><i class="bi bi-folder2-open"></i>Open Documents</a>
                    </div>
                </div>
                <div class="cv2-card cv2-mt"><div class="cv2-card-b" style="display:flex;flex-direction:column;gap:10px;">
                    <button type="submit" form="cv2EditForm" class="cv2-btn cv2-btn-primary" style="justify-content:center;"><i class="bi bi-check2"></i>Save Changes</button>
                    <a href="{{ route('contact.v2.tyrevendor.show', $v['id']) }}" class="cv2-btn cv2-btn-ghost" style="justify-content:center;">Cancel</a>
                </div></div>
            </div>
        </div>
        </form>
    </div></div>
</div>
@endsection
@section('js')
<script src="{{ asset('js/V2/tyrevendor.js?v=2.1') }}"></script>
@endsection
