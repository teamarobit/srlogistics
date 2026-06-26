@extends('layouts.app')
@section('css')<link href="{{ asset('css/V2/customer.css?v=1.4') }}" rel="stylesheet">@endsection
@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="cv2-wrap"><div class="cv2-container">
        <div class="cv2-phead"><div class="cv2-crumb"><a href="{{ route('contact.v2.batteryvendor.index') }}">Battery Vendors</a> · {{ $v['company'] }} · Activity</div></div>
        @include('V2.batteryvendor.partials.workspace-head')
        <div class="cv2-grid cv2-grid-2-1 cv2-mt">
            <div class="cv2-card">
                <div class="cv2-card-h"><h3>Activity Log</h3></div>
                <div class="cv2-card-b" id="cv2ActivityList">
                    <ul class="cv2-mini">
                        @forelse($activities as $act)
                            <li>
                                <span class="cv2-mini-ic"><i class="bi {{ $act->is_blacklisted === 'Yes' ? 'bi-exclamation-octagon' : 'bi-chat-left-text' }}"></i></span>
                                <div class="cv2-mini-body">
                                    <b>{{ $act->notes }}</b>
                                    <span>{{ optional($act->createdBy)->name ?? 'System' }} · {{ $act->created_at ? $act->created_at->format('d M y, g:i A') : '' }}</span>
                                </div>
                            </li>
                        @empty
                            <li><div class="cv2-mini-body"><span class="cv2-empty">No activity notes yet.</span></div></li>
                        @endforelse
                    </ul>
                </div>
            </div>
            <div class="cv2-card">
                <div class="cv2-card-h"><h3>Add Note</h3></div>
                <div class="cv2-card-b">
                    <form id="cv2ActivityForm" action="{{ route('contact.v2.batteryvendor.activitynotes.save') }}" method="POST" data-list-url="{{ route('contact.v2.batteryvendor.activity', $v['id']) }}">
                        @csrf
                        <input type="hidden" name="contact_id" value="{{ $v['id'] }}">
                        <div class="cv2-field"><label class="cv2-label">Note</label><textarea name="activity_notes" rows="4" placeholder="Add an activity note…"></textarea></div>
                        <button type="submit" class="cv2-btn cv2-btn-primary cv2-mt" style="width:100%;justify-content:center;"><i class="bi bi-plus-lg"></i>Save Note</button>
                    </form>
                    <div class="cv2-locked cv2-mt"><i class="bi bi-exclamation-octagon"></i><div><b>Blacklist</b><div class="cv2-hint">Set status to Blacklisted from Edit Info to log a blacklist note.</div></div></div>
                </div>
            </div>
        </div>
    </div></div>
</div>
@endsection
@section('js')
<script src="{{ asset('js/V2/customer.js?v=1.7') }}"></script>
<script src="{{ asset('js/V2/batteryvendor.js?v=2.0') }}"></script>
@endsection
