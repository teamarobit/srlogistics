@extends('layouts.app')
@section('css')<link href="{{ asset('css/V2/customer.css?v=1.3') }}" rel="stylesheet">@endsection
@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="cv2-wrap"><div class="cv2-container">
        <div class="cv2-phead">
            <div>
                <div class="cv2-crumb"><a href="{{ route('contact.v2.customer.contracts', $c['id']) }}">{{ $c['name'] }} · Contract</a> · New</div>
                <h1>Add Contract</h1>
                <div class="cv2-sub">For {{ $c['name'] }} ({{ $c['contactno'] }})</div>
            </div>
            <div class="cv2-phead-actions">
                <a href="{{ route('contact.v2.customer.contracts', $c['id']) }}" class="cv2-btn cv2-btn-soft">Cancel</a>
                <button type="submit" form="cv2ContractForm" class="cv2-btn cv2-btn-primary"><i class="bi bi-check2"></i>Save Contract</button>
            </div>
        </div>

        <form id="cv2ContractForm" action="javascript:void(0)">
        <div class="cv2-card">
            <div class="cv2-card-b">
                <div class="cv2-form-grid is-3">
                    <div class="cv2-field"><label class="cv2-label">Customer</label><input type="text" value="{{ $c['name'] }}" disabled></div>
                    <div class="cv2-field"><label class="cv2-label">Contract No <span class="req">*</span></label><input type="text" placeholder="CTR-2026-015"></div>
                    <div class="cv2-field"><label class="cv2-label">Status</label><input type="text" value="Active" disabled></div>
                    <div class="cv2-field"><label class="cv2-label">Contract Type <span class="req">*</span></label><select class="cv2-select" id="cv2ContractType" style="width:100%;"><option value="">Choose…</option><option value="1">Monthly</option><option value="6">Lifetime</option><option>Trip-wise</option></select></div>
                    <div class="cv2-field"><label class="cv2-label">Advance Payment <span class="req">*</span></label><input type="number" placeholder="0.00"></div>
                    <div class="cv2-field"><label class="cv2-label">Payment Within (days) <span class="req">*</span></label><input type="number" placeholder="30"></div>
                    <div class="cv2-field" data-when="dated"><label class="cv2-label">Start Date <span class="req">*</span></label><input type="date"></div>
                    <div class="cv2-field" data-when="dated"><label class="cv2-label">End Date <span class="req">*</span></label><input type="date"></div>
                    <div class="cv2-field" data-when="monthly"><label class="cv2-label">Monthly Total Allowed KM <span class="req">*</span></label><input type="number" placeholder="e.g. 8000"></div>
                    <div class="cv2-field" data-when="monthly"><label class="cv2-label">Monthly Total Price <span class="req">*</span></label><input type="number" placeholder="₹"></div>
                    <div class="cv2-field is-full"><label class="cv2-label">Routes <span class="req">*</span></label>
                        <select class="cv2-select" multiple style="width:100%;"><option>Guwahati → Dibrugarh</option><option>Guwahati → Silchar</option><option>Guwahati → Tinsukia</option></select>
                        <span class="cv2-hint">Select one or more routes covered by this contract.</span>
                    </div>
                    <div class="cv2-field"><label class="cv2-label">Set Reminder</label><select class="cv2-select" id="cv2Reminder" style="width:100%;"><option>No</option><option>Yes</option></select></div>
                    <div class="cv2-field" id="cv2ReminderDays" style="display:none;"><label class="cv2-label">Days before expiry <span class="req">*</span></label><input type="number" placeholder="15"></div>
                    <div class="cv2-field"><label class="cv2-label">Contract File</label><input type="file"></div>
                    <div class="cv2-field is-full"><label class="cv2-label">Remark</label><textarea rows="4" placeholder="Notes about this contract…"></textarea></div>
                </div>
            </div>
        </div>
        </form>
    </div></div>
</div>
@endsection
@section('js')<script src="{{ asset('js/V2/customer.js?v=1.3') }}"></script>@endsection
