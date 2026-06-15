@extends('layouts.app')
@section('css')<link href="{{ asset('css/V2/customer.css?v=1.3') }}" rel="stylesheet">@endsection
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
                        <li><span class="cv2-mini-ic"><i class="bi bi-record-circle"></i></span><div class="cv2-mini-body"><b>6 tyres received (MRF Steel Muscle)</b><span>Superadmin · 12 Jun 26, 11:20 AM</span></div></li>
                        <li><span class="cv2-mini-ic"><i class="bi bi-paperclip"></i></span><div class="cv2-mini-body"><b>GST certificate uploaded</b><span>Accounts · 09 Jun 26, 4:05 PM</span></div></li>
                        <li><span class="cv2-mini-ic"><i class="bi bi-bank"></i></span><div class="cv2-mini-body"><b>Bank details updated (HDFC added)</b><span>Superadmin · 05 Jun 26, 10:40 AM</span></div></li>
                        <li><span class="cv2-mini-ic"><i class="bi bi-person-plus"></i></span><div class="cv2-mini-body"><b>Vendor record created</b><span>Superadmin · 02 Apr 26, 9:30 AM</span></div></li>
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
