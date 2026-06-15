@extends('layouts.app')
@section('css')<link href="{{ asset('css/V2/employee.css?v=1.0') }}" rel="stylesheet">@endsection
@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="cv2-wrap"><div class="cv2-container">
        <div class="cv2-phead"><div class="cv2-crumb"><a href="{{ route('contact.v2.employee.index') }}">Employees</a> · {{ $e['name'] }} · Activity</div></div>
        @include('V2.employee.partials.workspace-head')
        <div class="cv2-grid cv2-grid-2-1 cv2-mt">
            <div class="cv2-card">
                <div class="cv2-card-h"><h3>Activity Log</h3></div>
                <div class="cv2-card-b">
                    <ul class="cv2-mini">
                        <li><span class="cv2-mini-ic"><i class="bi bi-cash-stack"></i></span><div class="cv2-mini-body"><b>Salary revised to ₹38,000</b><span>Superadmin · 12 Jun 26, 3:42 PM</span></div></li>
                        <li><span class="cv2-mini-ic"><i class="bi bi-pc-display"></i></span><div class="cv2-mini-body"><b>Laptop DELL-4471 issued</b><span>HR · 08 Jun 26, 10:15 AM</span></div></li>
                        <li><span class="cv2-mini-ic"><i class="bi bi-calendar2-week"></i></span><div class="cv2-mini-body"><b>2 days casual leave approved</b><span>Operations · 02 Jun 26, 9:00 AM</span></div></li>
                        <li><span class="cv2-mini-ic"><i class="bi bi-box-arrow-in-right"></i></span><div class="cv2-mini-body"><b>Work experience added</b><span>Superadmin · 14 Feb 23, 11:20 AM</span></div></li>
                        <li><span class="cv2-mini-ic"><i class="bi bi-person-plus"></i></span><div class="cv2-mini-body"><b>Employee record created</b><span>Superadmin · 14 Feb 23, 11:00 AM</span></div></li>
                    </ul>
                </div>
            </div>
            <div class="cv2-card">
                <div class="cv2-card-h"><h3>Add Note</h3></div>
                <div class="cv2-card-b">
                    <div class="cv2-field"><label class="cv2-label">Note</label><textarea rows="4" placeholder="Add an activity note…"></textarea></div>
                    <button class="cv2-btn cv2-btn-primary cv2-mt" style="width:100%;justify-content:center;"><i class="bi bi-plus-lg"></i>Save Note</button>
                </div>
            </div>
        </div>
    </div></div>
</div>
@endsection
@section('js')<script src="{{ asset('js/V2/employee.js?v=1.0') }}"></script>@endsection
