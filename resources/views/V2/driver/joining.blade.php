@extends('layouts.app')
@section('css')<link href="{{ asset('css/V2/driver.css?v=1.0') }}" rel="stylesheet">@endsection
@section('content')
@php $lock = !empty($isExited) ? 'is-locked' : ''; @endphp
<div class="layout-wrapper">
    @include('includes.header')
    <div class="cv2-wrap"><div class="cv2-container">
        <div class="cv2-phead"><div class="cv2-crumb"><a href="{{ route('contact.v2.driver.index') }}">Drivers</a> · {{ $d['name'] }} · Joining</div></div>
        @include('V2.driver.partials.workspace-head')

        <div class="cv2-grid cv2-grid-2-1 cv2-mt">
            <div class="cv2-card">
                <div class="cv2-filters" style="border-bottom:1px solid var(--cv2-line);">
                    <h3 style="font-size:15px;font-weight:700;margin:0;flex:1;">Work Experience</h3>
                    <span class="cv2-pill">{{ $workExperiences->count() }} record(s)</span>
                    @if(empty($isExited))
                    <button class="cv2-btn cv2-btn-primary cv2-btn-sm" data-bs-toggle="modal" data-bs-target="#cv2WorkExpModal"><i class="bi bi-plus-lg"></i>Add Experience</button>
                    @endif
                </div>
                <div class="cv2-card-b is-flush">
                    <table class="cv2-table">
                        <thead><tr><th>Company</th><th>Designation</th><th>Duration</th><th>Category</th><th>Salary</th><th>Legal</th></tr></thead>
                        <tbody>
                            @forelse($workExperiences as $w)
                            <tr>
                                <td><span class="cv2-t-name">{{ $w->previous_company_name }}</span></td>
                                <td>{{ $w->designation }}</td>
                                <td>{{ $w->employment_start_date ? \Carbon\Carbon::parse($w->employment_start_date)->format('M Y') : '—' }} – {{ $w->employment_end_date ? \Carbon\Carbon::parse($w->employment_end_date)->format('M Y') : '—' }}</td>
                                <td><span class="cv2-pill">{{ $w->experience_category ?? '—' }}</span></td>
                                <td class="cv2-t-mono">₹{{ number_format((float) $w->salary) }}</td>
                                <td>@if($w->any_legal_case === 'Yes')<span class="cv2-badge is-warn"><span class="cv2-badge-dot"></span>Case</span>@else<span class="cv2-badge is-active"><span class="cv2-badge-dot"></span>None</span>@endif</td>
                            </tr>
                            @empty
                            <tr><td colspan="6" class="text-center cv2-empty" style="padding:24px;">No work experience recorded yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="cv2-card">
                <div class="cv2-card-h"><h3>Joining Letter</h3></div>
                <div class="cv2-card-b">
                    <div class="cv2-mini" style="margin-bottom:14px;">
                        <li><span class="cv2-mini-ic"><i class="bi bi-{{ $workExperiences->isNotEmpty() ? 'check2-circle' : 'circle' }}"></i></span><div class="cv2-mini-body"><b>Work experience present</b><span>Required for letter</span></div></li>
                    </div>
                    <a href="{{ route('contact.v2.driver.joining.letter', $d['id']) }}" target="_blank"
                       class="cv2-btn cv2-btn-primary cv2-letter-link" style="width:100%;justify-content:center;"
                       data-seen-url="{{ route('contact.v2.driver.letter.seen') }}" data-contact-id="{{ $d['id'] }}" data-letter-type="joining-letter">
                       <i class="bi bi-file-earmark-text"></i>Generate / View Joining Letter</a>
                    <span class="cv2-hint" style="display:block;margin-top:10px;">Opens a printable standalone letter in a new tab.</span>
                </div>
            </div>
        </div>
    </div></div>
</div>

{{-- Add Work Experience modal --}}
<div class="modal fade cv2-modal" id="cv2WorkExpModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Work Experience</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
      <div class="modal-body">
        <form id="cv2WorkExpForm" action="{{ route('contact.v2.driver.workexp.save') }}" method="POST">
          @csrf
          <input type="hidden" name="contact_id" value="{{ $d['id'] }}">
          <div class="cv2-form-grid">
            <div class="cv2-field"><label class="cv2-label">Previous Company <span class="req">*</span></label><input type="text" name="previous_company_name"></div>
            <div class="cv2-field"><label class="cv2-label">Designation <span class="req">*</span></label><input type="text" name="previous_designation"></div>
            <div class="cv2-field"><label class="cv2-label">Duration <span class="req">*</span></label><input type="text" class="cv2-daterange" name="previous_employment_duration" placeholder="Select date range" readonly></div>
            <div class="cv2-field"><label class="cv2-label">Salary (₹) <span class="req">*</span></label><input type="number" name="previous_salary" min="1"></div>
            <div class="cv2-field"><label class="cv2-label">Experience Category <span class="req">*</span></label>
              <div class="cv2-radio-group">
                <span class="cv2-radio"><input type="radio" name="experience_category" id="ec_line" value="Line"><label for="ec_line">Line</label></span>
                <span class="cv2-radio"><input type="radio" name="experience_category" id="ec_local" value="Local"><label for="ec_local">Local</label></span>
              </div>
            </div>
            <div class="cv2-field"><label class="cv2-label">Any Legal Case <span class="req">*</span></label>
              <div class="cv2-radio-group">
                <span class="cv2-radio"><input type="radio" name="previous_legal_case" id="lc_yes" value="Yes"><label for="lc_yes">Yes</label></span>
                <span class="cv2-radio"><input type="radio" name="previous_legal_case" id="lc_no" value="No"><label for="lc_no">No</label></span>
              </div>
            </div>
            <div class="cv2-field is-full"><label class="cv2-label">Exit Reason <span class="req">*</span></label><input type="text" name="previous_exit_reason"></div>
            <div class="cv2-field cv2-cond" data-legal="Yes" style="display:none;"><label class="cv2-label">City <span class="req">*</span></label>
              <select class="cv2-select cv2-modal-select" name="previous_city_id" style="width:100%;"><option value="">Choose city</option>@foreach($cities as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach</select></div>
            <div class="cv2-field cv2-cond" data-legal="Yes" style="display:none;"><label class="cv2-label">Police Station <span class="req">*</span></label><input type="text" name="previous_police_station"></div>
            <div class="cv2-field is-full cv2-cond" data-legal="Yes" style="display:none;"><label class="cv2-label">Legal Case Comment <span class="req">*</span></label><textarea name="previous_legal_case_comment" rows="2"></textarea></div>
            <div class="cv2-field is-full"><label class="cv2-label">Notes <span class="req">*</span></label><textarea name="previous_notes" rows="2"></textarea></div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="cv2-btn cv2-btn-soft" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" form="cv2WorkExpForm" class="cv2-btn cv2-btn-primary"><i class="bi bi-check2"></i>Save Experience</button>
      </div>
    </div>
  </div>
</div>
@endsection
@section('js')<script src="{{ asset('js/V2/driver.js?v=2.1') }}"></script>@endsection
