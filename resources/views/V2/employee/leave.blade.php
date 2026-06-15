@extends('layouts.app')
@section('css')<link href="{{ asset('css/V2/employee.css?v=1.0') }}" rel="stylesheet">@endsection
@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="cv2-wrap"><div class="cv2-container">
        <div class="cv2-phead"><div class="cv2-crumb"><a href="{{ route('contact.v2.employee.index') }}">Employees</a> · {{ $e['name'] }} · Leave Tracker</div></div>
        @include('V2.employee.partials.workspace-head')

        {{-- Leave balance cards --}}
        <div class="cv2-kpis cv2-mt" style="grid-template-columns:repeat(4,1fr);">
            <div class="cv2-kpi"><div class="cv2-kpi-top"><span class="cv2-kpi-ic"><i class="bi bi-sun"></i></span></div><div class="cv2-kpi-val">8 / 12</div><div class="cv2-kpi-lbl">Casual Leave</div><div class="cv2-leave-bar" style="margin-top:8px;"><span style="width:67%;"></span></div></div>
            <div class="cv2-kpi"><div class="cv2-kpi-top"><span class="cv2-kpi-ic"><i class="bi bi-thermometer-half"></i></span></div><div class="cv2-kpi-val">3 / 10</div><div class="cv2-kpi-lbl">Sick Leave</div><div class="cv2-leave-bar" style="margin-top:8px;"><span style="width:30%;"></span></div></div>
            <div class="cv2-kpi"><div class="cv2-kpi-top"><span class="cv2-kpi-ic"><i class="bi bi-airplane"></i></span></div><div class="cv2-kpi-val">5 / 15</div><div class="cv2-kpi-lbl">Earned Leave</div><div class="cv2-leave-bar" style="margin-top:8px;"><span style="width:33%;"></span></div></div>
            <div class="cv2-kpi"><div class="cv2-kpi-top"><span class="cv2-kpi-ic is-bad"><i class="bi bi-x-circle"></i></span></div><div class="cv2-kpi-val">2</div><div class="cv2-kpi-lbl">LOP (Unpaid)</div></div>
        </div>

        <div class="cv2-card cv2-mt">
            <div class="cv2-filters" style="border-bottom:1px solid var(--cv2-line);">
                <h3 style="font-size:15px;font-weight:700;margin:0;flex:1;">Leave History</h3>
                <select class="cv2-select"><option>All Types</option><option>Casual</option><option>Sick</option><option>Earned</option></select>
                <button class="cv2-btn cv2-btn-primary cv2-btn-sm" data-bs-toggle="modal" data-bs-target="#cv2LeaveModal"><i class="bi bi-plus-lg"></i>Add Leave</button>
            </div>
            <div class="cv2-card-b is-flush">
                <table class="cv2-table">
                    <thead><tr><th>Type</th><th>From</th><th>To</th><th>Days</th><th>Reason</th><th>Status</th></tr></thead>
                    <tbody>
                        <tr><td><span class="cv2-pill">Casual</span></td><td>02 Jun 26</td><td>03 Jun 26</td><td class="cv2-t-mono">2</td><td>Personal work</td><td><span class="cv2-badge is-active"><span class="cv2-badge-dot"></span>Approved</span></td></tr>
                        <tr><td><span class="cv2-pill">Sick</span></td><td>18 May 26</td><td>18 May 26</td><td class="cv2-t-mono">1</td><td>Fever</td><td><span class="cv2-badge is-active"><span class="cv2-badge-dot"></span>Approved</span></td></tr>
                        <tr><td><span class="cv2-pill">Earned</span></td><td>10 Apr 26</td><td>12 Apr 26</td><td class="cv2-t-mono">3</td><td>Family function</td><td><span class="cv2-badge is-active"><span class="cv2-badge-dot"></span>Approved</span></td></tr>
                        <tr><td><span class="cv2-pill">Casual</span></td><td>28 Mar 26</td><td>28 Mar 26</td><td class="cv2-t-mono">1</td><td>—</td><td><span class="cv2-badge is-inactive"><span class="cv2-badge-dot"></span>Pending</span></td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div></div>
</div>

{{-- Add Leave modal --}}
<div class="modal fade cv2-modal" id="cv2LeaveModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Add Leave</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
      <div class="modal-body">
        <form id="cv2LeaveForm" action="javascript:void(0)">
          <div class="cv2-form-grid">
            <div class="cv2-field is-full"><label class="cv2-label">Leave Type <span class="req">*</span></label><select class="cv2-select cv2-modal-select" name="leave_type" style="width:100%;"><option value="">Choose…</option><option>Casual</option><option>Sick</option><option>Earned</option><option>LOP</option></select></div>
            <div class="cv2-field is-full"><label class="cv2-label">Duration <span class="req">*</span></label><input type="text" name="leave_duration" class="cv2-daterange" placeholder="From – To"></div>
            <div class="cv2-field is-full"><label class="cv2-label">Reason</label><textarea name="leave_reason" rows="2"></textarea></div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="cv2-btn cv2-btn-soft" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" form="cv2LeaveForm" class="cv2-btn cv2-btn-primary"><i class="bi bi-check2"></i>Save</button>
      </div>
    </div>
  </div>
</div>
@endsection
@section('js')<script src="{{ asset('js/V2/employee.js?v=1.0') }}"></script>@endsection
