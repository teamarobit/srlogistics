@extends('layouts.app')
@section('css')<link href="{{ asset('css/V2/employee.css?v=1.0') }}" rel="stylesheet">@endsection
@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="cv2-wrap"><div class="cv2-container">
        <div class="cv2-phead"><div class="cv2-crumb"><a href="{{ route('contact.v2.employee.index') }}">Employees</a> · {{ $e['name'] }} · Salary</div></div>
        @include('V2.employee.partials.workspace-head')

        {{-- Current structure --}}
        <div class="cv2-kpis cv2-mt" style="grid-template-columns:repeat(4,1fr);">
            <div class="cv2-kpi"><div class="cv2-kpi-top"><span class="cv2-kpi-ic"><i class="bi bi-cash"></i></span></div><div class="cv2-kpi-val">₹38,000</div><div class="cv2-kpi-lbl">Basic Pay</div></div>
            <div class="cv2-kpi"><div class="cv2-kpi-top"><span class="cv2-kpi-ic"><i class="bi bi-wrench-adjustable"></i></span></div><div class="cv2-kpi-val">₹250</div><div class="cv2-kpi-lbl">Per Service (Technical)</div></div>
            <div class="cv2-kpi"><div class="cv2-kpi-top"><span class="cv2-kpi-ic is-ok"><i class="bi bi-calendar-check"></i></span></div><div class="cv2-kpi-val">01 Apr 26</div><div class="cv2-kpi-lbl">Effective From</div></div>
            <div class="cv2-kpi"><div class="cv2-kpi-top"><span class="cv2-kpi-ic is-slate"><i class="bi bi-arrow-repeat"></i></span></div><div class="cv2-kpi-val">2</div><div class="cv2-kpi-lbl">Revisions</div></div>
        </div>

        <div class="cv2-card cv2-mt">
            <div class="cv2-filters" style="border-bottom:1px solid var(--cv2-line);">
                <h3 style="font-size:15px;font-weight:700;margin:0;flex:1;">Salary History</h3>
                @if($isExited)
                    <button class="cv2-btn cv2-btn-primary cv2-btn-sm is-locked" disabled><i class="bi bi-lock"></i>Locked (Exited)</button>
                @else
                    <button class="cv2-btn cv2-btn-primary cv2-btn-sm" data-bs-toggle="modal" data-bs-target="#cv2SalaryModal"><i class="bi bi-plus-lg"></i>Add Salary</button>
                @endif
            </div>
            <div class="cv2-card-b is-flush">
                <table class="cv2-table">
                    <thead><tr><th>Effective From</th><th>Basic Pay</th><th>Per Service</th><th>Recorded By</th></tr></thead>
                    <tbody>
                        <tr><td>01 Apr 26</td><td class="cv2-t-mono">₹38,000</td><td class="cv2-t-mono">₹250</td><td>Superadmin</td></tr>
                        <tr><td>01 Apr 25</td><td class="cv2-t-mono">₹32,000</td><td class="cv2-t-mono">₹200</td><td>Superadmin</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div></div>
</div>

{{-- Add Salary modal --}}
<div class="modal fade cv2-modal" id="cv2SalaryModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Add Salary</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
      <div class="modal-body">
        <form id="cv2SalaryForm" action="javascript:void(0)">
          <div class="cv2-form-grid">
            <div class="cv2-field is-full"><label class="cv2-label">Basic Pay <span class="req">*</span></label><input type="number" name="basic_pay" placeholder="₹"></div>
            <div class="cv2-field is-full"><label class="cv2-label">Salary Per Service <span class="cv2-pill" style="font-weight:600;">Technical only</span></label><input type="number" name="salary_per_work" placeholder="₹"></div>
            <div class="cv2-field is-full"><label class="cv2-label">Effective From <span class="req">*</span></label><input type="date" name="effective_from"></div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="cv2-btn cv2-btn-soft" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" form="cv2SalaryForm" class="cv2-btn cv2-btn-primary"><i class="bi bi-check2"></i>Save</button>
      </div>
    </div>
  </div>
</div>
@endsection
@section('js')<script src="{{ asset('js/V2/employee.js?v=1.0') }}"></script>@endsection
