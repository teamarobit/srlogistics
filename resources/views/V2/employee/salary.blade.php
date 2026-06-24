@extends('layouts.app')
@section('css')<link href="{{ asset('css/V2/employee.css?v=2.0') }}" rel="stylesheet">@endsection
@php $latestSalary = $salaries->first(); $isTechnical = ($contact->service_type ?? '') === 'Technical'; @endphp
@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="cv2-wrap"><div class="cv2-container">
        <div class="cv2-phead"><div class="cv2-crumb"><a href="{{ route('contact.v2.employee.index') }}">Employees</a> · {{ $e['name'] }} · Salary</div></div>
        @include('V2.employee.partials.workspace-head')

        {{-- Current structure --}}
        <div class="cv2-kpis cv2-mt" style="grid-template-columns:repeat(4,1fr);">
            <div class="cv2-kpi"><div class="cv2-kpi-top"><span class="cv2-kpi-ic"><i class="bi bi-cash"></i></span></div><div class="cv2-kpi-val">{{ $latestSalary ? '₹'.number_format((float)$latestSalary->basic_pay) : '—' }}</div><div class="cv2-kpi-lbl">Basic Pay</div></div>
            <div class="cv2-kpi"><div class="cv2-kpi-top"><span class="cv2-kpi-ic"><i class="bi bi-wrench-adjustable"></i></span></div><div class="cv2-kpi-val">{{ ($latestSalary && $latestSalary->salary_per_work) ? '₹'.number_format((float)$latestSalary->salary_per_work) : '—' }}</div><div class="cv2-kpi-lbl">Per Service (Technical)</div></div>
            <div class="cv2-kpi"><div class="cv2-kpi-top"><span class="cv2-kpi-ic is-ok"><i class="bi bi-calendar-check"></i></span></div><div class="cv2-kpi-val">{{ ($latestSalary && $latestSalary->effective_from) ? \Carbon\Carbon::parse($latestSalary->effective_from)->format('d M y') : '—' }}</div><div class="cv2-kpi-lbl">Effective From</div></div>
            <div class="cv2-kpi"><div class="cv2-kpi-top"><span class="cv2-kpi-ic is-slate"><i class="bi bi-arrow-repeat"></i></span></div><div class="cv2-kpi-val">{{ $salaries->count() }}</div><div class="cv2-kpi-lbl">Revisions</div></div>
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
                    <thead><tr><th>Effective From</th><th>Basic Pay</th><th>Per Service</th></tr></thead>
                    <tbody>
                        @forelse($salaries as $sal)
                        <tr>
                            <td>{{ $sal->effective_from ? \Carbon\Carbon::parse($sal->effective_from)->format('d M y') : '' }}</td>
                            <td class="cv2-t-mono">₹{{ number_format((float)$sal->basic_pay) }}</td>
                            <td class="cv2-t-mono">{{ $sal->salary_per_work ? '₹'.number_format((float)$sal->salary_per_work) : '—' }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="text-center cv2-empty" style="padding:24px;">No salary records yet.</td></tr>
                        @endforelse
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
        <form id="cv2SalaryForm" action="{{ route('contact.v2.employee.salary.save') }}">
          <input type="hidden" name="contact_id" value="{{ $contact->id }}">
          <input type="hidden" name="service_type" value="{{ $contact->service_type }}">
          <div class="cv2-form-grid">
            <div class="cv2-field is-full"><label class="cv2-label">Basic Pay <span class="req">*</span></label><input type="number" name="basic_pay" placeholder="₹"></div>
            @if($isTechnical)
            <div class="cv2-field is-full"><label class="cv2-label">Salary Per Service <span class="req">*</span> <span class="cv2-pill" style="font-weight:600;">Technical</span></label><input type="number" name="salary_per_work" placeholder="₹"></div>
            @endif
            <div class="cv2-field is-full"><label class="cv2-label">Effective From <span class="req">*</span></label><input type="date" name="effective_from" max="{{ \Carbon\Carbon::today()->format('Y-m-d') }}"></div>
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
@section('js')<script src="{{ asset('js/V2/employee.js?v=2.1') }}"></script>@endsection
