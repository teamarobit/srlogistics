@extends('layouts.app')

@section('css')
<link href="{{ asset('css/V2/customer.css?v=1.3') }}" rel="stylesheet">
@endsection

@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="cv2-wrap">
        <div class="cv2-container">

            <div class="cv2-phead">
                <div>
                    <div class="cv2-crumb"><a href="{{ route('contact.v2.loadvendor.index') }}">Load Vendors</a> · New</div>
                    <h1>Add Load Vendor</h1>
                    <div class="cv2-sub">Create the load vendor record. Contact persons, locations &amp; documents open once it is saved.</div>
                </div>
                <div class="cv2-phead-actions">
                    <a href="{{ route('contact.v2.loadvendor.index') }}" class="cv2-btn cv2-btn-soft">Cancel</a>
                    <button type="submit" form="cv2LoadVendorForm" class="cv2-btn cv2-btn-primary"><i class="bi bi-check2"></i>Save Load Vendor</button>
                </div>
            </div>

            <form id="cv2LoadVendorForm" action="javascript:void(0)" data-create="1">
            <div class="cv2-grid cv2-grid-2-1">
                <div style="display:flex;flex-direction:column;gap:16px;">

                    {{-- Basic info --}}
                    <div class="cv2-card">
                        <div class="cv2-card-h"><h3>Basic Information</h3></div>
                        <div class="cv2-card-b">
                            <div class="cv2-form-grid">
                                <div class="cv2-field">
                                    <label class="cv2-label">Company Name <span class="req">*</span></label>
                                    <input type="text" name="company_name" placeholder="Enter company name" maxlength="100">
                                </div>
                                <div class="cv2-field">
                                    <label class="cv2-label">Contact Name <span class="req">*</span></label>
                                    <input type="text" name="contact_name" placeholder="Primary contact name" maxlength="100">
                                </div>
                                <div class="cv2-field">
                                    <label class="cv2-label">Contact Code <span class="req">*</span></label>
                                    <input type="text" name="contact_code" placeholder="e.g. BRC-01" maxlength="100">
                                </div>
                                <div class="cv2-field">
                                    <label class="cv2-label">Alias</label>
                                    <input type="text" name="contact_alias" placeholder="Short name" maxlength="100">
                                </div>
                                <div class="cv2-field">
                                    <label class="cv2-label">Size</label>
                                    <select class="cv2-select" name="size" style="width:100%;"><option value="">Choose…</option><option>Small</option><option>Medium</option><option>Large</option></select>
                                </div>
                                <div class="cv2-field">
                                    <label class="cv2-label">RAG Status</label>
                                    <select class="cv2-select" name="rag_status" style="width:100%;"><option value="">Choose…</option><option>Green</option><option>Yellow</option><option>Red</option></select>
                                </div>
                                <div class="cv2-field is-full">
                                    <label class="cv2-label">Comment</label>
                                    <input type="text" name="contact_comment" placeholder="Optional note" maxlength="255">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Contact details --}}
                    <div class="cv2-card">
                        <div class="cv2-card-h"><h3>Contact Details</h3></div>
                        <div class="cv2-card-b">
                            <div class="cv2-form-grid">
                                <div class="cv2-field">
                                    <label class="cv2-label">Phone <span class="req">*</span></label>
                                    <input type="tel" name="phone" data-intl-phone="1" placeholder="98640 11223">
                                </div>
                                <div class="cv2-field">
                                    <label class="cv2-label">WhatsApp</label>
                                    <input type="tel" name="whatsapp" data-intl-phone="1" placeholder="98640 11223">
                                </div>
                                <div class="cv2-field is-full">
                                    <label class="cv2-label">Email</label>
                                    <input type="email" name="email" placeholder="ops@company.in">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Head office address --}}
                    <div class="cv2-card">
                        <div class="cv2-card-h"><h3>Head Office Address</h3></div>
                        <div class="cv2-card-b">
                            <div class="cv2-form-grid">
                                <div class="cv2-field is-full">
                                    <label class="cv2-label">Address</label>
                                    <textarea name="address" rows="2" placeholder="Street, area" maxlength="100"></textarea>
                                </div>
                                <div class="cv2-field">
                                    <label class="cv2-label">State</label>
                                    <select class="cv2-select" name="state_id" style="width:100%;"><option value="">Choose state…</option><option>Assam</option><option>West Bengal</option></select>
                                </div>
                                <div class="cv2-field">
                                    <label class="cv2-label">City</label>
                                    <select class="cv2-select" name="city_id" style="width:100%;"><option value="">Choose city…</option><option>Guwahati</option><option>Dibrugarh</option></select>
                                </div>
                                <div class="cv2-field">
                                    <label class="cv2-label">Postal Code</label>
                                    <input type="text" name="post_code" placeholder="781001" maxlength="6">
                                </div>
                                <div class="cv2-field">
                                    <label class="cv2-label">Map Location</label>
                                    <input type="text" name="head_office_map_location" placeholder="Paste map link">
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
                                    <div class="cv2-field"><label class="cv2-label">Name <span class="req">*</span></label><input type="text" placeholder="Person name"></div>
                                    <div class="cv2-field"><label class="cv2-label">Designation <span class="req">*</span></label><input type="text" placeholder="e.g. Broker / Manager"></div>
                                    <div class="cv2-field"><label class="cv2-label">Phone <span class="req">*</span></label><input type="tel" data-intl-phone="1" placeholder="98640 11223"></div>
                                    <div class="cv2-field"><label class="cv2-label">WhatsApp</label><input type="tel" data-intl-phone="1" placeholder="98640 11223"></div>
                                    <div class="cv2-field"><label class="cv2-label">Email</label><input type="email" placeholder="person@company.in"></div>
                                    <div class="cv2-field"><label class="cv2-label">Comment</label><input type="text" placeholder="Optional"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Documents --}}
                    <div class="cv2-card">
                        <div class="cv2-card-h"><h3>Documents</h3></div>
                        <div class="cv2-card-b">
                            <div class="cv2-form-grid">
                                <div class="cv2-field"><label class="cv2-label">Document Type</label><select class="cv2-select" style="width:100%;"><option value="">Select type…</option><option>GST Certificate</option><option>PAN</option><option>Agreement</option></select></div>
                                <div class="cv2-field"><label class="cv2-label">&nbsp;</label><span class="cv2-hint">JPG, PNG or PDF · max 2 MB · up to 2 files per type</span></div>
                                <div class="cv2-field is-full">
                                    <div class="cv2-dropzone" id="cv2Drop"><i class="bi bi-cloud-arrow-up"></i>Drop files here or click to upload</div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Right rail --}}
                <div>
                    <div class="cv2-card">
                        <div class="cv2-card-h"><h3>Available after saving</h3></div>
                        <div class="cv2-card-b" style="display:flex;flex-direction:column;gap:10px;">
                            <div class="cv2-locked"><i class="bi bi-lock"></i><div><b>Customers</b><div class="cv2-hint">Contact persons</div></div></div>
                            <div class="cv2-locked"><i class="bi bi-lock"></i><div><b>Location</b><div class="cv2-hint">Loading / unloading points</div></div></div>
                            <div class="cv2-locked"><i class="bi bi-lock"></i><div><b>Documents</b><div class="cv2-hint">Attachments &amp; agreements</div></div></div>
                            <div class="cv2-locked"><i class="bi bi-lock"></i><div><b>Activity</b><div class="cv2-hint">Notes &amp; audit trail</div></div></div>
                            <span class="cv2-hint" style="margin-top:4px;">These submodules each open as their own page once the load vendor exists.</span>
                        </div>
                    </div>
                    <div class="cv2-card cv2-mt">
                        <div class="cv2-card-b" style="display:flex;flex-direction:column;gap:10px;">
                            <button type="submit" form="cv2LoadVendorForm" class="cv2-btn cv2-btn-primary cv2-btn-lg" style="justify-content:center;"><i class="bi bi-check2"></i>Save Load Vendor</button>
                            <a href="{{ route('contact.v2.loadvendor.index') }}" class="cv2-btn cv2-btn-ghost" style="justify-content:center;">Cancel</a>
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
<script src="{{ asset('js/V2/customer.js?v=1.3') }}"></script>
@endsection
