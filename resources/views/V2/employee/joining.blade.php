@extends('layouts.app')
@section('css')<link href="{{ asset('css/V2/employee.css?v=1.0') }}" rel="stylesheet">@endsection
@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="cv2-wrap"><div class="cv2-container">
        <div class="cv2-phead"><div class="cv2-crumb"><a href="{{ route('contact.v2.employee.index') }}">Employees</a> · {{ $e['name'] }} · Joining</div></div>
        @include('V2.employee.partials.workspace-head')

        {{-- Joining letter strip (E1) — requires work-experience + salary --}}
        <div class="cv2-card cv2-mt">
            <div class="cv2-card-b" style="display:flex;align-items:center;justify-content:space-between;gap:14px;flex-wrap:wrap;">
                <div>
                    <h3 style="margin:0 0 3px;font-size:15px;font-weight:700;">Joining Letter</h3>
                    <span class="cv2-hint">Available once work experience &amp; salary structure are recorded. Opens a printable letter.</span>
                </div>
                <a href="{{ route('contact.v2.employee.joining.letter', $e['id']) }}" target="_blank" class="cv2-btn cv2-btn-primary"><i class="bi bi-file-earmark-text"></i>Generate Joining Letter</a>
            </div>
        </div>

        <div class="cv2-card cv2-mt">
            <div class="cv2-filters" style="border-bottom:1px solid var(--cv2-line);">
                <h3 style="font-size:15px;font-weight:700;margin:0;flex:1;">Work Experience</h3>
                @if($isExited)
                    <button class="cv2-btn cv2-btn-primary cv2-btn-sm is-locked" disabled><i class="bi bi-lock"></i>Locked (Exited)</button>
                @else
                    <button class="cv2-btn cv2-btn-primary cv2-btn-sm" data-bs-toggle="modal" data-bs-target="#cv2WorkExpModal"><i class="bi bi-plus-lg"></i>Add Work Experience</button>
                @endif
            </div>
            <div class="cv2-card-b is-flush">
                <table class="cv2-table">
                    <thead><tr><th>Company</th><th>Designation</th><th>Duration</th><th>Salary</th><th>Legal Case</th><th>Exit Reason</th><th style="text-align:right;">Actions</th></tr></thead>
                    <tbody>
                        <tr><td><span class="cv2-t-name">TransNorth Carriers</span></td><td>Dispatch Supervisor</td><td>Jan 2019 – Dec 2022</td><td class="cv2-t-mono">₹26,000</td><td><span class="cv2-badge is-active"><span class="cv2-badge-dot"></span>No</span></td><td>Career growth</td>
                            <td class="cv2-actions"><a href="javascript:void(0)" class="cv2-ic-btn"><i class="bi bi-pencil"></i></a><a href="javascript:void(0)" class="cv2-ic-btn is-danger cv2-del"><i class="bi bi-trash3"></i></a></td></tr>
                        <tr><td><span class="cv2-t-name">Assam Roadlines</span></td><td>Loading Clerk</td><td>Mar 2016 – Dec 2018</td><td class="cv2-t-mono">₹18,500</td><td><span class="cv2-badge is-active"><span class="cv2-badge-dot"></span>No</span></td><td>Relocation</td>
                            <td class="cv2-actions"><a href="javascript:void(0)" class="cv2-ic-btn"><i class="bi bi-pencil"></i></a><a href="javascript:void(0)" class="cv2-ic-btn is-danger cv2-del"><i class="bi bi-trash3"></i></a></td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div></div>
</div>

{{-- Add Work Experience modal --}}
<div class="modal fade cv2-modal" id="cv2WorkExpModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Add Work Experience</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
      <div class="modal-body">
        <form id="cv2WorkExpForm" action="javascript:void(0)">
          <div class="cv2-form-grid">
            <div class="cv2-field"><label class="cv2-label">Previous Company <span class="req">*</span></label><input type="text" name="previous_company_name"></div>
            <div class="cv2-field"><label class="cv2-label">Designation <span class="req">*</span></label><input type="text" name="previous_designation"></div>
            <div class="cv2-field is-full"><label class="cv2-label">Duration <span class="req">*</span></label><input type="text" name="previous_employment_duration" class="cv2-daterange" placeholder="Start – End"></div>
            <div class="cv2-field"><label class="cv2-label">Salary <span class="req">*</span></label><input type="number" name="previous_salary" placeholder="₹"></div>
            <div class="cv2-field"><label class="cv2-label">Any Legal Case <span class="req">*</span></label>
                <div class="cv2-radio-group">
                    <span class="cv2-radio"><input type="radio" name="previous_legal_case" id="lc_y" value="Yes"><label for="lc_y">Yes</label></span>
                    <span class="cv2-radio"><input type="radio" name="previous_legal_case" id="lc_n" value="No" checked><label for="lc_n">No</label></span>
                </div>
            </div>
            <div class="cv2-field is-full"><label class="cv2-label">Exit Reason <span class="req">*</span></label><input type="text" name="previous_exit_reason"></div>
            <div class="cv2-field is-full"><label class="cv2-label">Notes <span class="req">*</span></label><textarea name="previous_notes" rows="2"></textarea></div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="cv2-btn cv2-btn-soft" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" form="cv2WorkExpForm" class="cv2-btn cv2-btn-primary"><i class="bi bi-check2"></i>Save</button>
      </div>
    </div>
  </div>
</div>
@endsection
@section('js')<script src="{{ asset('js/V2/employee.js?v=1.0') }}"></script>@endsection
