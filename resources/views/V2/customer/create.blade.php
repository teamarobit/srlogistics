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
                    <div class="cv2-crumb"><a href="{{ route('contact.v2.customer.index') }}">Customers</a> · New</div>
                    <h1>Add Customer</h1>
                    <div class="cv2-sub">Create the customer record. Contracts, locations, rate charts &amp; vehicles open once it is saved.</div>
                </div>
                <div class="cv2-phead-actions">
                    <a href="{{ route('contact.v2.customer.index') }}" class="cv2-btn cv2-btn-soft">Cancel</a>
                    <button type="submit" form="cv2CustomerForm" class="cv2-btn cv2-btn-primary"><i class="bi bi-check2"></i>Save Customer</button>
                </div>
            </div>

            <form id="cv2CustomerForm" action="javascript:void(0)" data-create="1">
            <div class="cv2-grid cv2-grid-2-1">
                <div style="display:flex;flex-direction:column;gap:16px;">

                    {{-- Basic info --}}
                    <div class="cv2-card">
                        <div class="cv2-card-h"><h3>Basic Information</h3></div>
                        <div class="cv2-card-b">
                            <div class="cv2-form-grid">
                                <div class="cv2-field is-full">
                                    <label class="cv2-label">GST Number <span class="req">*</span></label>
                                    <input type="text" name="gst_number" placeholder="18AAACT2727Q1ZW" maxlength="100">
                                    <span class="cv2-help">Format: 18AAACT2727Q1ZW</span>
                                </div>
                                <div class="cv2-field">
                                    <label class="cv2-label">Customer Name <span class="req">*</span></label>
                                    <input type="text" name="contact_name" placeholder="Enter customer name" maxlength="100">
                                </div>
                                <div class="cv2-field">
                                    <label class="cv2-label">About Type <span class="req">*</span></label>
                                    <select class="cv2-select" name="about_type_id" style="width:100%;"><option value="">Choose type…</option><option>FMCG</option><option>Cement</option><option>Steel</option><option>Retail</option></select>
                                </div>
                                <div class="cv2-field">
                                    <label class="cv2-label">Size</label>
                                    <select class="cv2-select" name="size" style="width:100%;"><option value="">Choose…</option><option>Small</option><option>Medium</option><option>Large</option></select>
                                </div>
                                <div class="cv2-field">
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
                                    <input type="email" name="email" placeholder="accounts@company.in">
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
                                <div class="cv2-field is-full" style="background:var(--cv2-soft);border:1px solid var(--cv2-line);border-radius:10px;padding:12px 14px;">
                                    <label class="cv2-label" style="display:flex;align-items:center;gap:8px;"><input type="checkbox" name="is_deduction_chargeable" style="width:auto;"> Halting deduction chargeable</label>
                                    <input type="number" name="halting_charges_per_day" placeholder="Halting charges / day (₹)" style="margin-top:8px;">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Billing address --}}
                    <div class="cv2-card">
                        <div class="cv2-card-h"><h3>Billing Address <span class="cv2-pill" style="font-weight:600;">Optional</span></h3></div>
                        <div class="cv2-card-b">
                            <div class="cv2-form-grid">
                                <div class="cv2-field"><label class="cv2-label">Country</label><select class="cv2-select" style="width:100%;"><option>India</option></select></div>
                                <div class="cv2-field"><label class="cv2-label">State</label><select class="cv2-select" style="width:100%;"><option value="">Choose state…</option></select></div>
                                <div class="cv2-field"><label class="cv2-label">City</label><select class="cv2-select" style="width:100%;"><option value="">Choose city…</option></select></div>
                                <div class="cv2-field"><label class="cv2-label">Postal Code</label><input type="text" placeholder="781001"></div>
                                <div class="cv2-field is-full"><label class="cv2-label">Billing Address</label><textarea rows="2" placeholder="Billing address"></textarea></div>
                                <div class="cv2-field is-full"><label class="cv2-label">Additional Info</label><input type="text" placeholder="GSTIN note, attention, etc."></div>
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
                                    <div class="cv2-field"><label class="cv2-label">Designation</label><input type="text" placeholder="e.g. Purchase Head"></div>
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
                            <div class="cv2-locked"><i class="bi bi-lock"></i><div><b>Contract</b><div class="cv2-hint">Add agreements &amp; routes</div></div></div>
                            <div class="cv2-locked"><i class="bi bi-lock"></i><div><b>Location</b><div class="cv2-hint">Loading / unloading points</div></div></div>
                            <div class="cv2-locked"><i class="bi bi-lock"></i><div><b>Rate Chart</b><div class="cv2-hint">Per-route freight pricing</div></div></div>
                            <div class="cv2-locked"><i class="bi bi-lock"></i><div><b>Vehicle Allocation</b><div class="cv2-hint">Assign company vehicles</div></div></div>
                            <span class="cv2-hint" style="margin-top:4px;">These submodules each open as their own page once the customer exists.</span>
                        </div>
                    </div>
                    <div class="cv2-card cv2-mt">
                        <div class="cv2-card-b" style="display:flex;flex-direction:column;gap:10px;">
                            <button type="submit" form="cv2CustomerForm" class="cv2-btn cv2-btn-primary cv2-btn-lg" style="justify-content:center;"><i class="bi bi-check2"></i>Save Customer</button>
                            <a href="{{ route('contact.v2.customer.index') }}" class="cv2-btn cv2-btn-ghost" style="justify-content:center;">Cancel</a>
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
