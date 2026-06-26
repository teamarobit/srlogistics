@extends('layouts.app')
@section('css')<link href="{{ asset('css/V2/employee.css?v=2.0') }}" rel="stylesheet">@endsection
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
                @if($canGenerateLetter)
                    <a href="{{ route('contact.v2.employee.joining.letter', $contact->id) }}" target="_blank" class="cv2-btn cv2-btn-primary"><i class="bi bi-file-earmark-text"></i>Generate Joining Letter</a>
                @else
                    <button class="cv2-btn cv2-btn-soft" disabled><i class="bi bi-lock"></i>Add work experience &amp; salary first</button>
                @endif
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
                    <thead><tr><th>Company</th><th>Designation</th><th>Duration</th><th>Salary</th><th>Legal Case</th><th>Exit Reason</th><th>Notes</th><th style="text-align:right;">Actions</th></tr></thead>
                    <tbody>
                        @forelse($workExperiences as $w)
                        <tr>
                            <td><span class="cv2-t-name">{{ $w->previous_company_name }}</span></td>
                            <td>{{ $w->designation }}</td>
                            <td>{{ $w->employment_start_date ? \Carbon\Carbon::parse($w->employment_start_date)->format('M Y') : '' }} – {{ $w->employment_end_date ? \Carbon\Carbon::parse($w->employment_end_date)->format('M Y') : '' }}</td>
                            <td class="cv2-t-mono">₹{{ number_format((float)$w->salary) }}</td>
                            <td><span class="cv2-badge {{ $w->any_legal_case=='Yes'?'is-black':'is-active' }}"><span class="cv2-badge-dot"></span>{{ $w->any_legal_case }}</span></td>
                            <td>{{ $w->exit_reason }}</td>
                            <td>{{ $w->notes ?? '—' }}</td>
                            <td class="cv2-actions"><span class="cv2-hint">—</span></td>
                        </tr>
                        @empty
                        <tr><td colspan="8" class="text-center cv2-empty" style="padding:24px;">No work experience recorded yet.</td></tr>
                        @endforelse
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
        <form id="cv2WorkExpForm" action="{{ route('contact.v2.employee.workexp.save') }}">
          <input type="hidden" name="contact_id" value="{{ $contact->id }}">
          <div class="cv2-form-grid">
            <div class="cv2-field"><label class="cv2-label">Previous Company <span class="req">*</span></label><input type="text" name="previous_company_name"></div>
            <div class="cv2-field"><label class="cv2-label">Designation <span class="req">*</span></label><input type="text" name="previous_designation"></div>
            <div class="cv2-field is-full"><label class="cv2-label">Duration <span class="req">*</span></label><input type="text" name="previous_employment_duration" class="cv2-daterange-hyphen" placeholder="dd/mm/yyyy - dd/mm/yyyy"></div>
            <div class="cv2-field"><label class="cv2-label">Salary <span class="req">*</span></label><input type="number" name="previous_salary" placeholder="₹"></div>
            <div class="cv2-field"><label class="cv2-label">Any Legal Case <span class="req">*</span></label>
                <div class="cv2-radio-group">
                    <span class="cv2-radio"><input type="radio" name="previous_legal_case" id="lc_y" value="Yes"><label for="lc_y">Yes</label></span>
                    <span class="cv2-radio"><input type="radio" name="previous_legal_case" id="lc_n" value="No" checked><label for="lc_n">No</label></span>
                </div>
            </div>
            <div class="cv2-field is-full"><label class="cv2-label">Legal Case Comment</label><textarea name="previous_legal_case_comment" rows="2"></textarea></div>
            <div class="cv2-field"><label class="cv2-label">City</label><select class="cv2-select cv2-modal-select" name="previous_city_id" style="width:100%;"><option value="">Choose city…</option>@foreach($cities as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach</select></div>
            <div class="cv2-field"><label class="cv2-label">Police Station</label><input type="text" name="previous_police_station"></div>
            <div class="cv2-field is-full"><label class="cv2-label">Exit Reason <span class="req">*</span></label><input type="text" name="previous_exit_reason"></div>
            <div class="cv2-field is-full"><label class="cv2-label">Notes</label><textarea name="previous_notes" rows="2"></textarea></div>
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
@section('js')<script src="{{ asset('js/V2/employee.js?v=2.2') }}"></script>@endsection
