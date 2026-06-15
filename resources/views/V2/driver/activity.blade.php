@extends('layouts.app')
@section('css')<link href="{{ asset('css/V2/driver.css?v=1.0') }}" rel="stylesheet">@endsection
@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="cv2-wrap"><div class="cv2-container">
        <div class="cv2-phead"><div class="cv2-crumb"><a href="{{ route('contact.v2.driver.index') }}">Drivers</a> · {{ $d['name'] }} · Activity</div></div>
        @include('V2.driver.partials.workspace-head')
        <div class="cv2-grid cv2-grid-2-1 cv2-mt">
            <div class="cv2-card">
                <div class="cv2-card-h"><h3>Activity Log</h3></div>
                <div class="cv2-card-b">
                    <ul class="cv2-mini">
                        <li><span class="cv2-mini-ic"><i class="bi bi-cash-coin"></i></span><div class="cv2-mini-body"><b>Bhatta ₹2,400 credited (TRIP-4471-118)</b><span>Superadmin · 12 Jun 26, 6:10 PM</span></div></li>
                        <li><span class="cv2-mini-ic"><i class="bi bi-truck"></i></span><div class="cv2-mini-body"><b>Vehicle {{ $d['vehicle'] }} allocated</b><span>Operations · 02 Jan 22, 10:15 AM</span></div></li>
                        <li><span class="cv2-mini-ic"><i class="bi bi-box-seam"></i></span><div class="cv2-mini-body"><b>Asset issued: Fuel Card</b><span>Superadmin · 12 Jan 22, 11:00 AM</span></div></li>
                        <li><span class="cv2-mini-ic"><i class="bi bi-box-arrow-in-right"></i></span><div class="cv2-mini-body"><b>Joining letter generated</b><span>Superadmin · {{ $d['doj'] }}</span></div></li>
                        <li><span class="cv2-mini-ic"><i class="bi bi-person-plus"></i></span><div class="cv2-mini-body"><b>Driver record created</b><span>Superadmin · {{ $d['doj'] }}</span></div></li>
                    </ul>
                </div>
            </div>
            <div class="cv2-card">
                <div class="cv2-card-h"><h3>Add Note</h3></div>
                <div class="cv2-card-b">
                    <form action="javascript:void(0)">
                        <div class="cv2-field"><label class="cv2-label">Note</label><textarea rows="4" placeholder="Add an activity note…"></textarea></div>
                        <button type="submit" class="cv2-btn cv2-btn-primary cv2-mt" style="width:100%;justify-content:center;"><i class="bi bi-plus-lg"></i>Save Note</button>
                    </form>
                </div>
            </div>
        </div>
    </div></div>
</div>
@endsection
@section('js')<script src="{{ asset('js/V2/driver.js?v=1.0') }}"></script>@endsection
