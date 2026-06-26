@extends('layouts.app')
@section('css')<link href="{{ asset('css/V2/tyrevendor.css?v=1.0') }}" rel="stylesheet">@endsection
@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="cv2-wrap"><div class="cv2-container">
        <div class="cv2-phead"><div class="cv2-crumb"><a href="{{ route('contact.v2.tyrevendor.index') }}">Tyre Vendors</a> · {{ $v['company'] }} · Activity</div></div>
        @include('V2.tyrevendor.partials.workspace-head')
        <div class="cv2-grid cv2-grid-2-1 cv2-mt">
            <div class="cv2-card">
                <div class="cv2-card-h"><h3>Activity Log</h3></div>
                <div class="cv2-card-b">
                    <ul class="cv2-mini">
                        @forelse($activities as $act)
                        <li><span class="cv2-mini-ic"><i class="bi {{ $act->is_blacklisted === 'Yes' ? 'bi-slash-circle' : 'bi-chat-left-text' }}"></i></span>
                            <div class="cv2-mini-body"><b>{{ $act->notes }}</b>
                            <span>{{ optional($act->createdBy)->name ?? 'System' }} · {{ \Carbon\Carbon::parse($act->created_at)->format('d M y, h:i A') }}</span></div></li>
                        @empty
                        <li><span class="cv2-mini-ic"><i class="bi bi-info-circle"></i></span><div class="cv2-mini-body"><b>No activity yet</b><span>Notes and changes will appear here.</span></div></li>
                        @endforelse
                    </ul>
                </div>
            </div>
            <div class="cv2-card">
                <div class="cv2-card-h"><h3>Add Note</h3></div>
                <div class="cv2-card-b">
                    <form id="cv2ActivityForm" action="{{ route('contact.v2.tyrevendor.activitynotes.save') }}" method="POST">
                        @csrf
                        <input type="hidden" name="contact_id" value="{{ $v['id'] }}">
                        <div class="cv2-field"><label class="cv2-label">Note <span class="req">*</span></label><textarea name="activity_notes" rows="4" placeholder="Add an activity note…"></textarea></div>
                        <button type="submit" class="cv2-btn cv2-btn-primary cv2-mt" style="width:100%;justify-content:center;"><i class="bi bi-plus-lg"></i>Save Note</button>
                    </form>
                    <div class="cv2-locked cv2-mt"><i class="bi bi-exclamation-octagon"></i><div><b>Blacklist</b><div class="cv2-hint">Set status to Blacklisted from Edit Info to log a blacklist note.</div></div></div>
                </div>
            </div>
        </div>
    </div></div>
</div>
@endsection
@section('js')<script src="{{ asset('js/V2/tyrevendor.js?v=2.1') }}"></script>@endsection
