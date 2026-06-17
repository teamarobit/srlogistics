@extends('layouts.app')
@section('css')<link href="{{ asset('css/V2/vehiclevendor.css?v=2.0') }}" rel="stylesheet">@endsection
@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="cv2-wrap"><div class="cv2-container">
        <div class="cv2-phead"><div class="cv2-crumb"><a href="{{ route('contact.v2.vehiclevendor.index') }}">Vehicle Vendors</a> · {{ $v['company'] }} · Vehicle</div></div>
        @include('V2.vehiclevendor.partials.workspace-head')

        <div class="cv2-note is-warn cv2-mt">
            <i class="bi bi-info-circle"></i>
            <div><b>View-only.</b> Supplied-vehicle records have no backing table yet, so this page is read-only for now. Persisting vendor-supplied vehicles is pending a schema decision (Amit). The declared fleet count for this vendor is <b>{{ $v['vehicles'] }}</b> (set on Edit Info → No. of Vehicles).</div>
        </div>

        <div class="cv2-card cv2-mt">
            <div class="cv2-filters" style="border-bottom:1px solid var(--cv2-line);">
                <h3 style="font-size:15px;font-weight:700;margin:0;flex:1;">Supplied Vehicles</h3>
                <span class="cv2-pill" style="font-weight:600;">Read-only</span>
            </div>
            <div class="cv2-card-b is-flush">
                <table class="cv2-table">
                    <thead><tr><th>Vehicle No</th><th>Type</th><th>Capacity</th><th>Ownership</th><th>Model Year</th><th>Status</th></tr></thead>
                    <tbody>
                        <tr><td colspan="6" class="text-center cv2-empty">No supplied-vehicle records — this submodule is view-only pending a schema decision.</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div></div>
</div>
@endsection
@section('js')
<script src="{{ asset('js/V2/customer.js?v=1.4') }}"></script>
<script src="{{ asset('js/V2/vehiclevendor.js?v=2.0') }}"></script>
@endsection
