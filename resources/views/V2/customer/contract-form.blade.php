@extends('layouts.app')
@section('css')<link href="{{ asset('css/V2/customer.css?v=1.4') }}" rel="stylesheet">@endsection
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

        <form id="cv2ContractForm" action="{{ route('contact.v2.customer.contract.save') }}" method="POST" enctype="multipart/form-data" data-contracts-url="{{ route('contact.v2.customer.contracts', $c['id']) }}">
        @csrf
        <input type="hidden" name="contact_id" value="{{ $c['id'] }}">
        <div class="cv2-card">
            <div class="cv2-card-b">
                <div class="cv2-form-grid is-3">
                    <div class="cv2-field"><label class="cv2-label">Customer</label><input type="text" value="{{ $c['name'] }}" disabled></div>
                    <div class="cv2-field"><label class="cv2-label">Contract No <span class="req">*</span></label><input type="text" name="contract_no" value="{{ old('contract_no') }}" placeholder="CTR-2026-015"></div>
                    <div class="cv2-field"><label class="cv2-label">Status</label><input type="text" value="Active" disabled></div>
                    <div class="cv2-field"><label class="cv2-label">Contract Type <span class="req">*</span></label>
                        <select class="cv2-select" id="cv2ContractType" name="contract_type_id" style="width:100%;">
                            <option value="">Choose…</option>
                            @foreach($contracttypes as $ct)
                                <option value="{{ $ct->id }}" {{ old('contract_type_id') == $ct->id ? 'selected' : '' }}>{{ $ct->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="cv2-field"><label class="cv2-label">Advance Payment <span class="req">*</span></label><input type="number" step="0.01" name="advance_payment" value="{{ old('advance_payment') }}" placeholder="0.00"></div>
                    <div class="cv2-field"><label class="cv2-label">Payment Within (days) <span class="req">*</span></label><input type="number" name="payment_within_day" value="{{ old('payment_within_day') }}" placeholder="30"></div>
                    <div class="cv2-field" data-when="dated"><label class="cv2-label">Start Date <span class="req">*</span></label><input type="text" class="cv2-date" name="start_date" value="{{ old('start_date') }}" placeholder="YYYY-MM-DD" autocomplete="off" readonly></div>
                    <div class="cv2-field" data-when="dated"><label class="cv2-label">End Date <span class="req">*</span></label><input type="text" class="cv2-date" name="end_date" value="{{ old('end_date') }}" placeholder="YYYY-MM-DD" autocomplete="off" readonly></div>
                    <div class="cv2-field" data-when="monthly"><label class="cv2-label">Monthly Total Allowed KM <span class="req">*</span></label><input type="number" name="total_allowed_kilometer" value="{{ old('total_allowed_kilometer') }}" placeholder="e.g. 8000"></div>
                    <div class="cv2-field" data-when="monthly"><label class="cv2-label">Monthly Total Price <span class="req">*</span></label><input type="number" step="0.01" name="monthly_total_price" value="{{ old('monthly_total_price') }}" placeholder="₹"></div>
                    <div class="cv2-field is-full"><label class="cv2-label">Routes <span class="req">*</span></label>
                        <select class="cv2-select" name="route_id[]" multiple style="width:100%;">
                            @foreach($routes as $route)
                                <option value="{{ $route->id }}">{{ $route->name ?? ('Route #'.$route->id) }}</option>
                            @endforeach
                        </select>
                        <span class="cv2-hint">Select one or more routes covered by this contract.</span>
                    </div>
                    <div class="cv2-field"><label class="cv2-label">Set Reminder</label><select class="cv2-select" id="cv2Reminder" name="set_reminder" style="width:100%;"><option value="No">No</option><option value="Yes">Yes</option></select></div>
                    <div class="cv2-field" id="cv2ReminderDays" style="display:none;"><label class="cv2-label">Days before expiry <span class="req">*</span></label><input type="number" name="reminder_days_before_expiry" value="{{ old('reminder_days_before_expiry') }}" placeholder="15"></div>
                    <div class="cv2-field"><label class="cv2-label">Contract File</label><input type="file" name="upload_file" accept=".jpg,.jpeg,.png,.pdf"></div>
                    <div class="cv2-field is-full"><label class="cv2-label">Remark</label><textarea name="remarks" rows="4" placeholder="Notes about this contract…">{{ old('remarks') }}</textarea></div>
                </div>
            </div>
        </div>
        </form>
    </div></div>
</div>
@endsection
@section('js')<script src="{{ asset('js/V2/customer.js?v=1.7') }}"></script>@endsection
