@extends('layouts.app')
@section('css')<link href="{{ asset('css/V2/vehiclevendor.css?v=1.0') }}" rel="stylesheet">@endsection
@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="cv2-wrap"><div class="cv2-container">
        <div class="cv2-phead"><div class="cv2-crumb"><a href="{{ route('contact.v2.vehiclevendor.index') }}">Vehicle Vendors</a> · {{ $v['company'] }} · Activity</div></div>
        @include('V2.vehiclevendor.partials.workspace-head')
        <div class="cv2-grid cv2-grid-2-1 cv2-mt">
            <div class="cv2-card">
                <div class="cv2-card-h"><h3>Activity Log</h3></div>
                <div class="cv2-card-b">
                    <ul class="cv2-mini">
                        <li><span class="cv2-mini-ic"><i class="bi bi-truck"></i></span><div class="cv2-mini-body"><b>Vehicle AS01GC7741 added to supplied fleet</b><span>Superadmin · 12 Jun 26, 3:42 PM</span></div></li>
                        <li><span class="cv2-mini-ic"><i class="bi bi-signpost-split"></i></span><div class="cv2-mini-body"><b>Route Guwahati → Dibrugarh added</b><span>Operations · 09 Jun 26, 10:15 AM</span></div></li>
                        <li><span class="cv2-mini-ic"><i class="bi bi-bank"></i></span><div class="cv2-mini-body"><b>Primary bank account updated (HDFC ••2201)</b><span>Superadmin · 05 Jun 26, 5:01 PM</span></div></li>
                        <li><span class="cv2-mini-ic"><i class="bi bi-file-earmark-text"></i></span><div class="cv2-mini-body"><b>TDS Declaration uploaded</b><span>Superadmin · 14 Apr 26, 9:30 AM</span></div></li>
                        <li><span class="cv2-mini-ic"><i class="bi bi-plus-circle"></i></span><div class="cv2-mini-body"><b>Vendor record created</b><span>Superadmin · 12 Apr 26, 11:20 AM</span></div></li>
                    </ul>
                </div>
            </div>
            <div class="cv2-card">
                <div class="cv2-card-h"><h3>Add Note</h3></div>
                <div class="cv2-card-b">
                    <form id="cv2NoteForm" action="javascript:void(0)">
                        <div class="cv2-field"><label class="cv2-label">Note</label><textarea rows="4" placeholder="Add an activity note…"></textarea></div>
                        <button type="submit" class="cv2-btn cv2-btn-primary cv2-mt" style="width:100%;justify-content:center;"><i class="bi bi-plus-lg"></i>Save Note</button>
                    </form>
                    <div class="cv2-locked cv2-mt"><i class="bi bi-exclamation-octagon"></i><div><b>Blacklist</b><div class="cv2-hint">Set status to Blacklisted from Edit Info to log a blacklist note.</div></div></div>
                </div>
            </div>
        </div>
    </div></div>
</div>
@endsection
@section('js')<script src="{{ asset('js/V2/vehiclevendor.js?v=1.0') }}"></script>@endsection
