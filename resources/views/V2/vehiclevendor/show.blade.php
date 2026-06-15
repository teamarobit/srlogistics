@extends('layouts.app')

@section('css')
<link href="{{ asset('css/V2/vehiclevendor.css?v=1.0') }}" rel="stylesheet">
@endsection

@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="cv2-wrap">
        <div class="cv2-container">

            <div class="cv2-phead">
                <div class="cv2-crumb"><a href="{{ route('contact.v2.vehiclevendor.index') }}">Vehicle Vendors</a> · {{ $v['company'] }} · Overview</div>
            </div>

            @include('V2.vehiclevendor.partials.workspace-head')

            {{-- Overview summary --}}
            <div class="cv2-kpis cv2-mt" style="grid-template-columns:repeat(4,1fr);">
                <a class="cv2-kpi" href="{{ route('contact.v2.vehiclevendor.vehicle', $v['id']) }}" style="text-decoration:none;color:inherit;">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic"><i class="bi bi-truck"></i></span></div>
                    <div class="cv2-kpi-val">{{ $counts['vehicles'] }}</div><div class="cv2-kpi-lbl">Vehicles Supplied</div>
                </a>
                <a class="cv2-kpi" href="{{ route('contact.v2.vehiclevendor.route', $v['id']) }}" style="text-decoration:none;color:inherit;">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic"><i class="bi bi-signpost-split"></i></span></div>
                    <div class="cv2-kpi-val">{{ $counts['routes'] }}</div><div class="cv2-kpi-lbl">Routes Covered</div>
                </a>
                <a class="cv2-kpi" href="{{ route('contact.v2.vehiclevendor.documents', $v['id']) }}" style="text-decoration:none;color:inherit;">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic is-slate"><i class="bi bi-paperclip"></i></span></div>
                    <div class="cv2-kpi-val">{{ $counts['documents'] }}</div><div class="cv2-kpi-lbl">Documents</div>
                </a>
                <a class="cv2-kpi" href="{{ route('contact.v2.vehiclevendor.activity', $v['id']) }}" style="text-decoration:none;color:inherit;">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic is-slate"><i class="bi bi-clock-history"></i></span></div>
                    <div class="cv2-kpi-val">{{ $counts['activity'] }}</div><div class="cv2-kpi-lbl">Activities</div>
                </a>
            </div>

            {{-- E6 TDS reminder when tds_percentage is 0 or 1 --}}
            @if($v['tds'] === 0 || $v['tds'] === 1)
            <div class="cv2-note is-warn cv2-mt">
                <i class="bi bi-exclamation-triangle"></i>
                <div>TDS percentage is <b>{{ $v['tds'] }}</b> for this vendor — a <b>TDS Declaration</b> document is mandatory.
                    Upload it on the <a href="{{ route('contact.v2.vehiclevendor.documents', $v['id']) }}" style="color:#7a5106;text-decoration:underline;">Documents</a> page.</div>
            </div>
            @endif

            <div class="cv2-grid cv2-grid-2 cv2-mt">
                <div class="cv2-card">
                    <div class="cv2-card-h"><h3>Company &amp; Tax</h3><a class="cv2-link" href="{{ route('contact.v2.vehiclevendor.edit', $v['id']) }}">Edit →</a></div>
                    <div class="cv2-card-b is-flush">
                        <table class="cv2-table">
                            <tbody>
                                <tr><td class="cv2-t-sub">Company Owner</td><td class="cv2-t-name">{{ $v['owner'] }}</td></tr>
                                <tr><td class="cv2-t-sub">GST Treatment</td><td>{{ $v['gst_treatment'] }}</td></tr>
                                <tr><td class="cv2-t-sub">GST Number</td><td class="cv2-t-mono">{{ $v['gst'] }}</td></tr>
                                <tr><td class="cv2-t-sub">TDS Percentage</td><td class="cv2-t-mono">{{ $v['tds'] }}%</td></tr>
                                <tr><td class="cv2-t-sub">Vendor Size</td><td>{{ $v['size'] }}</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="cv2-card">
                    <div class="cv2-card-h"><h3>Recent Activity</h3><a class="cv2-link" href="{{ route('contact.v2.vehiclevendor.activity', $v['id']) }}">View all →</a></div>
                    <div class="cv2-card-b">
                        <ul class="cv2-mini">
                            <li><span class="cv2-mini-ic"><i class="bi bi-truck"></i></span><div class="cv2-mini-body"><b>Vehicle AS01GC7741 added to supplied fleet</b><span>by Superadmin · 2 days ago</span></div></li>
                            <li><span class="cv2-mini-ic"><i class="bi bi-signpost-split"></i></span><div class="cv2-mini-body"><b>Route Guwahati → Dibrugarh added</b><span>by Operations · 5 days ago</span></div></li>
                            <li><span class="cv2-mini-ic"><i class="bi bi-bank"></i></span><div class="cv2-mini-body"><b>Primary bank account updated</b><span>by Superadmin · 1 week ago</span></div></li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
