@extends('layouts.app')
@section('css')<link href="{{ asset('css/V2/driver.css?v=1.0') }}" rel="stylesheet">@endsection
@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="cv2-wrap"><div class="cv2-container">
        <div class="cv2-phead"><div class="cv2-crumb"><a href="{{ route('contact.v2.driver.index') }}">Drivers</a> · {{ $d['name'] }} · Exit</div></div>
        @include('V2.driver.partials.workspace-head')

        <div class="cv2-grid cv2-grid-2-1 cv2-mt">
            @if(!empty($isExited) && $exitDetail)
            <div class="cv2-card">
                <div class="cv2-card-h"><h3>Exit Details</h3><span class="cv2-badge is-black"><span class="cv2-badge-dot"></span>Exited</span></div>
                <div class="cv2-card-b is-flush">
                    <table class="cv2-table"><tbody>
                        <tr><td class="cv2-t-name">Exit Date</td><td>{{ $exitDetail->exit_date ? \Carbon\Carbon::parse($exitDetail->exit_date)->format('d M Y') : '—' }}</td></tr>
                        <tr><td class="cv2-t-name">Exit Reason</td><td>{{ $exitDetail->exit_reason }}</td></tr>
                        <tr><td class="cv2-t-name">Feedback</td><td>{{ $exitDetail->feedback }}</td></tr>
                    </tbody></table>
                </div>
            </div>
            <div class="cv2-card">
                <div class="cv2-card-h"><h3>Relieving Letter</h3></div>
                <div class="cv2-card-b">
                    <a href="{{ route('contact.v2.driver.exit.letter', $d['id']) }}" target="_blank"
                       class="cv2-btn cv2-btn-primary cv2-letter-link" style="width:100%;justify-content:center;"
                       data-seen-url="{{ route('contact.v2.driver.letter.seen') }}" data-contact-id="{{ $d['id'] }}" data-letter-type="exit-letter">
                       <i class="bi bi-file-earmark-text"></i>Generate / View Relieving Letter</a>
                </div>
            </div>
            @else
            <div class="cv2-card">
                <div class="cv2-card-h"><h3>Record Driver Exit</h3></div>
                <div class="cv2-card-b">
                    <form id="cv2ExitForm" action="{{ route('contact.v2.driver.exit.save') }}" method="POST">
                        @csrf
                        <input type="hidden" name="contact_id" value="{{ $d['id'] }}">
                        <div class="cv2-form-grid">
                            <div class="cv2-field"><label class="cv2-label">Exit Date <span class="req">*</span></label><input type="date" name="exit_date"></div>
                            <div class="cv2-field"><label class="cv2-label">Exit Reason <span class="req">*</span></label><input type="text" name="exit_reason" placeholder="Reason for exit"></div>
                            <div class="cv2-field is-full"><label class="cv2-label">Exit Feedback <span class="req">*</span></label><textarea name="exit_feedback" rows="3" placeholder="Performance, conduct, dues, vehicle handover…"></textarea></div>
                        </div>
                        <button type="submit" class="cv2-btn cv2-btn-danger cv2-mt" style="justify-content:center;"><i class="bi bi-box-arrow-right"></i>Record Exit &amp; Lock Record</button>
                        <span class="cv2-hint" style="display:block;margin-top:10px;">Recording an exit locks the record (read-only) and enables the relieving letter. Only one exit per driver.</span>
                    </form>
                </div>
            </div>
            <div class="cv2-card">
                <div class="cv2-card-h"><h3>Relieving Letter</h3></div>
                <div class="cv2-card-b">
                    <div class="cv2-locked"><i class="bi bi-lock"></i><div><b>Available after exit</b><div class="cv2-hint">Record exit details first to enable the letter.</div></div></div>
                </div>
            </div>
            @endif
        </div>
    </div></div>
</div>
@endsection
@section('js')<script src="{{ asset('js/V2/driver.js?v=2.0') }}"></script>@endsection
