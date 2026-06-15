@extends('layouts.app')
@section('css')<link href="{{ asset('css/V2/customer.css?v=1.3') }}" rel="stylesheet">@endsection
@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="cv2-wrap"><div class="cv2-container">
        <div class="cv2-phead"><div class="cv2-crumb"><a href="{{ route('contact.v2.loadvendor.index') }}">Load Vendors</a> · {{ $v['company'] }} · Activity</div></div>
        @include('V2.loadvendor.partials.workspace-head')
        <div class="cv2-grid cv2-grid-2-1 cv2-mt">
            <div class="cv2-card">
                <div class="cv2-card-h"><h3>Activity Log</h3></div>
                <div class="cv2-card-b">
                    <ul class="cv2-mini">
                        <li><span class="cv2-mini-ic"><i class="bi bi-geo-alt"></i></span><div class="cv2-mini-body"><b>Loading point “Guwahati Yard” added</b><span>Superadmin · 11 Jun 26, 3:42 PM</span></div></li>
                        <li><span class="cv2-mini-ic"><i class="bi bi-people"></i></span><div class="cv2-mini-body"><b>Contact person “Pranab Kalita” added</b><span>Operations · 08 Jun 26, 10:15 AM</span></div></li>
                        <li><span class="cv2-mini-ic"><i class="bi bi-paperclip"></i></span><div class="cv2-mini-body"><b>Broker agreement uploaded</b><span>Superadmin · 28 Apr 26, 5:01 PM</span></div></li>
                        <li><span class="cv2-mini-ic"><i class="bi bi-person-plus"></i></span><div class="cv2-mini-body"><b>Load vendor record created</b><span>Superadmin · 10 Apr 26, 9:30 AM</span></div></li>
                    </ul>
                </div>
            </div>
            <div class="cv2-card">
                <div class="cv2-card-h"><h3>Add Note</h3></div>
                <div class="cv2-card-b">
                    <div class="cv2-field"><label class="cv2-label">Note</label><textarea rows="4" placeholder="Add an activity note…"></textarea></div>
                    <button class="cv2-btn cv2-btn-primary cv2-mt" style="width:100%;justify-content:center;"><i class="bi bi-plus-lg"></i>Save Note</button>
                    <div class="cv2-locked cv2-mt"><i class="bi bi-exclamation-octagon"></i><div><b>Blacklist</b><div class="cv2-hint">Set status to Blacklisted from Edit Info to log a blacklist note.</div></div></div>
                </div>
            </div>
        </div>
    </div></div>
</div>
@endsection
@section('js')<script src="{{ asset('js/V2/customer.js?v=1.3') }}"></script>@endsection
