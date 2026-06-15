@extends('layouts.app')
@section('css')<link href="{{ asset('css/V2/employee.css?v=1.0') }}" rel="stylesheet">@endsection
@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="cv2-wrap"><div class="cv2-container">
        <div class="cv2-phead"><div class="cv2-crumb"><a href="{{ route('contact.v2.employee.index') }}">Employees</a> · {{ $e['name'] }} · Exit</div></div>
        @include('V2.employee.partials.workspace-head')

        @if($isExited)
            {{-- Exit recorded — show details + exit letter (E1) --}}
            <div class="cv2-grid cv2-grid-2-1 cv2-mt">
                <div class="cv2-card">
                    <div class="cv2-card-h"><h3>Exit Details</h3></div>
                    <div class="cv2-card-b">
                        <ul class="cv2-mini">
                            <li><span class="cv2-mini-ic"><i class="bi bi-calendar-x"></i></span><div class="cv2-mini-body"><b>18 Apr 2026</b><span>Exit date</span></div></li>
                            <li><span class="cv2-mini-ic"><i class="bi bi-box-arrow-right"></i></span><div class="cv2-mini-body"><b>Resignation — better opportunity</b><span>Exit reason</span></div></li>
                            <li><span class="cv2-mini-ic"><i class="bi bi-chat-left-text"></i></span><div class="cv2-mini-body"><b>Positive — smooth handover</b><span>Exit feedback</span></div></li>
                        </ul>
                    </div>
                </div>
                <div class="cv2-card">
                    <div class="cv2-card-h"><h3>Exit Letter</h3></div>
                    <div class="cv2-card-b">
                        <span class="cv2-hint" style="display:block;margin-bottom:12px;">The exit/relieving letter is available because exit details are recorded.</span>
                        <a href="{{ route('contact.v2.employee.exit.letter', $e['id']) }}" target="_blank" class="cv2-btn cv2-btn-primary" style="width:100%;justify-content:center;"><i class="bi bi-file-earmark-text"></i>Generate Exit Letter</a>
                    </div>
                </div>
            </div>
        @else
            {{-- No exit yet — show record-exit form --}}
            <div class="cv2-card cv2-mt">
                <div class="cv2-card-h"><h3>Record Exit</h3></div>
                <div class="cv2-card-b">
                    <span class="cv2-hint" style="display:block;margin-bottom:14px;">Recording an exit locks further Add actions on Assets, Salary, Work Experience &amp; Joining. The exit letter becomes available afterwards. Only one exit record is allowed per employee.</span>
                    <form id="cv2ExitForm" action="javascript:void(0)">
                        <div class="cv2-form-grid">
                            <div class="cv2-field"><label class="cv2-label">Exit Date <span class="req">*</span></label><input type="date" name="exit_date"></div>
                            <div class="cv2-field"><label class="cv2-label">Exit Reason <span class="req">*</span></label><input type="text" name="exit_reason" placeholder="e.g. Resignation"></div>
                            <div class="cv2-field is-full"><label class="cv2-label">Exit Feedback <span class="req">*</span></label><textarea name="exit_feedback" rows="3" placeholder="Handover notes, feedback…"></textarea></div>
                        </div>
                        <button type="submit" class="cv2-btn cv2-btn-primary cv2-mt"><i class="bi bi-box-arrow-right"></i>Record Exit</button>
                    </form>
                </div>
            </div>
        @endif
    </div></div>
</div>
@endsection
@section('js')<script src="{{ asset('js/V2/employee.js?v=1.0') }}"></script>@endsection
