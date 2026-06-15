@extends('layouts.app')
@section('css')<link href="{{ asset('css/V2/customer.css?v=1.3') }}" rel="stylesheet">@endsection
@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="cv2-wrap"><div class="cv2-container">
        <div class="cv2-phead"><div class="cv2-crumb"><a href="{{ route('contact.v2.sparevendor.index') }}">Spare Vendors</a> · {{ $v['company'] }} · Activity</div></div>
        @include('V2.sparevendor.partials.workspace-head')
        <div class="cv2-grid cv2-grid-2-1 cv2-mt">
            <div class="cv2-card">
                <div class="cv2-card-h"><h3>Activity Log</h3></div>
                <div class="cv2-card-b">
                    <ul class="cv2-mini">
                        <li><span class="cv2-mini-ic"><i class="bi bi-gear-wide-connected"></i></span><div class="cv2-mini-body"><b>3 spare parts added to catalogue</b><span>Superadmin · 12 Jun 26, 3:42 PM</span></div></li>
                        <li><span class="cv2-mini-ic"><i class="bi bi-paperclip"></i></span><div class="cv2-mini-body"><b>TDS Declaration uploaded</b><span>Superadmin · 10 Jun 26, 11:20 AM</span></div></li>
                        <li><span class="cv2-mini-ic"><i class="bi bi-bank"></i></span><div class="cv2-mini-body"><b>HDFC bank account added</b><span>Accounts · 06 Jun 26, 5:01 PM</span></div></li>
                        <li><span class="cv2-mini-ic"><i class="bi bi-pencil"></i></span><div class="cv2-mini-body"><b>Specialisation updated (added Electricals)</b><span>Superadmin · 02 Jun 26, 9:30 AM</span></div></li>
                        <li><span class="cv2-mini-ic"><i class="bi bi-person-plus"></i></span><div class="cv2-mini-body"><b>Vendor record created</b><span>Superadmin · 28 May 26, 4:15 PM</span></div></li>
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
