@extends('layouts.app')
@section('css')<link href="{{ asset('css/V2/customer.css?v=1.4') }}" rel="stylesheet">@endsection
@section('content')
@php
    $today = \Carbon\Carbon::today();
    if ($contract->contract_type_id == 6) {
        $contractStatus = 'Life Time';
    } elseif (empty($contract->end_date)) {
        $contractStatus = 'Active';
    } elseif (\Carbon\Carbon::parse($contract->start_date)->startOfDay() <= $today && \Carbon\Carbon::parse($contract->end_date)->endOfDay() >= $today) {
        $contractStatus = 'Active';
    } else {
        $contractStatus = 'Inactive';
    }
    $selectedRoutes = $contract->routes->pluck('id')->toArray();
    $reminderOn     = optional($contract->detail)->set_reminder == 'Yes';
@endphp
<div class="layout-wrapper">
    @include('includes.header')
    <div class="cv2-wrap"><div class="cv2-container">
        <div class="cv2-phead">
            <div>
                <div class="cv2-crumb"><a href="{{ route('contact.v2.customer.contracts', $c['id']) }}">{{ $c['name'] }} · Contract</a> · Edit</div>
                <h1>Edit Contract</h1>
                <div class="cv2-sub">For {{ $c['name'] }} ({{ $c['contactno'] }})</div>
            </div>
            <div class="cv2-phead-actions">
                <a href="{{ route('contact.v2.customer.contracts', $c['id']) }}" class="cv2-btn cv2-btn-soft">Cancel</a>
                <button type="submit" form="cv2ContractForm" class="cv2-btn cv2-btn-primary"><i class="bi bi-check2"></i>Update Contract</button>
            </div>
        </div>

        <form id="cv2ContractForm" action="{{ route('contact.v2.customer.contract.update', $contract->id) }}" method="POST" enctype="multipart/form-data" data-contracts-url="{{ route('contact.v2.customer.contracts', $c['id']) }}">
        @csrf
        <input type="hidden" name="contract_id" value="{{ $contract->id }}">
        <input type="hidden" name="contact_id" value="{{ $c['id'] }}">
        <div class="cv2-card">
            <div class="cv2-card-b">
                <div class="cv2-form-grid is-3">
                    <div class="cv2-field"><label class="cv2-label">Customer</label><input type="text" value="{{ $c['name'] }}" disabled></div>
                    <div class="cv2-field"><label class="cv2-label">Contract No</label><input type="text" value="{{ $contract->contract_no }}" disabled></div>
                    <div class="cv2-field"><label class="cv2-label">Status</label><input type="text" value="{{ $contractStatus }}" readonly></div>
                    <div class="cv2-field"><label class="cv2-label">Contract Type</label>
                        <select class="cv2-select" id="cv2ContractType" disabled style="width:100%;">
                            @foreach($contracttypes as $ct)
                                <option value="{{ $ct->id }}" {{ $contract->contract_type_id == $ct->id ? 'selected' : '' }}>{{ $ct->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="cv2-field"><label class="cv2-label">Advance Payment <span class="req">*</span></label><input type="number" step="0.01" name="advance_payment" value="{{ old('advance_payment', $contract->advance_payment) }}" placeholder="0.00"></div>
                    <div class="cv2-field"><label class="cv2-label">Payment Within (days) <span class="req">*</span></label><input type="number" name="payment_within_day" value="{{ old('payment_within_day', $contract->payment_within_day) }}" placeholder="30"></div>
                    <div class="cv2-field" data-when="dated"><label class="cv2-label">Start Date</label><input type="text" name="start_date_display" value="{{ $contract->start_date ? \Carbon\Carbon::parse($contract->start_date)->format('d-m-Y') : '' }}" disabled></div>
                    <div class="cv2-field" data-when="dated"><label class="cv2-label">End Date</label><input type="text" name="end_date_display" value="{{ $contract->end_date ? \Carbon\Carbon::parse($contract->end_date)->format('d-m-Y') : '' }}" disabled></div>
                    <div class="cv2-field" data-when="monthly"><label class="cv2-label">Monthly Total Allowed KM <span class="req">*</span></label><input type="number" name="total_allowed_kilometer" value="{{ old('total_allowed_kilometer', $contract->monthly_total_allowed_kilometer) }}" placeholder="e.g. 8000"></div>
                    <div class="cv2-field" data-when="monthly"><label class="cv2-label">Monthly Total Price <span class="req">*</span></label><input type="number" step="0.01" name="monthly_total_price" value="{{ old('monthly_total_price', $contract->monthly_total_price) }}" placeholder="₹"></div>
                    <div class="cv2-field is-full"><label class="cv2-label">Routes <span class="req">*</span></label>
                        <select class="cv2-select" name="route_id[]" multiple style="width:100%;">
                            @foreach($routes as $route)
                                <option value="{{ $route->id }}" {{ in_array($route->id, $selectedRoutes) ? 'selected' : '' }}>{{ $route->name ?? ('Route #'.$route->id) }}</option>
                            @endforeach
                        </select>
                        <span class="cv2-hint">Select one or more routes covered by this contract.</span>
                    </div>
                    <div class="cv2-field"><label class="cv2-label">Set Reminder</label><select class="cv2-select" id="cv2Reminder" name="set_reminder" style="width:100%;"><option value="No" {{ !$reminderOn ? 'selected' : '' }}>No</option><option value="Yes" {{ $reminderOn ? 'selected' : '' }}>Yes</option></select></div>
                    <div class="cv2-field" id="cv2ReminderDays" style="{{ $reminderOn ? '' : 'display:none;' }}"><label class="cv2-label">Days before expiry <span class="req">*</span></label><input type="number" name="reminder_days_before_expiry" value="{{ old('reminder_days_before_expiry', optional($contract->detail)->reminder_days_before_expiry) }}" placeholder="15"></div>
                    <div class="cv2-field"><label class="cv2-label">Contract File</label><input type="file" name="upload_file" accept=".jpg,.jpeg,.png,.pdf">
                        @if(optional($contract->detail)->contract_file)
                            <span class="cv2-hint"><i class="bi bi-paperclip"></i> {{ $contract->detail->contract_file }} — <a href="{{ route('customer.contract.media.serve', $contract->detail->id) }}" target="_blank">View existing file</a>. Leave empty to keep current.</span>
                        @endif
                    </div>
                    <div class="cv2-field is-full"><label class="cv2-label">Remark</label><textarea name="remarks" rows="4" placeholder="Notes about this contract…">{{ old('remarks', $contract->remarks) }}</textarea></div>
                </div>
            </div>
        </div>
        </form>
    </div></div>
</div>
@endsection
@section('js')<script src="{{ asset('js/V2/customer.js?v=2.3') }}"></script>@endsection
