@extends('layouts.app')

@section('css')
<link href="{{ asset('css/V2/customer.css?v=1.3') }}" rel="stylesheet">
@endsection

@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="cv2-wrap">
        <div class="cv2-container">

            <div class="cv2-phead">
                <div class="cv2-crumb"><a href="{{ route('contact.v2.loadvendor.index') }}">Load Vendors</a> · {{ $v['company'] }} · Overview</div>
            </div>

            @include('V2.loadvendor.partials.workspace-head')

            {{-- Overview summary --}}
            <div class="cv2-kpis cv2-mt" style="grid-template-columns:repeat(4,1fr);">
                <a class="cv2-kpi" href="{{ route('contact.v2.loadvendor.customers', $v['id']) }}" style="text-decoration:none;color:inherit;">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic"><i class="bi bi-people"></i></span></div>
                    <div class="cv2-kpi-val">{{ $counts['customers'] }}</div><div class="cv2-kpi-lbl">Customers</div>
                </a>
                <a class="cv2-kpi" href="{{ route('contact.v2.loadvendor.locations', $v['id']) }}" style="text-decoration:none;color:inherit;">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic"><i class="bi bi-geo-alt"></i></span></div>
                    <div class="cv2-kpi-val">{{ $counts['locations'] }}</div><div class="cv2-kpi-lbl">Locations</div>
                </a>
                <a class="cv2-kpi" href="{{ route('contact.v2.loadvendor.documents', $v['id']) }}" style="text-decoration:none;color:inherit;">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic is-slate"><i class="bi bi-paperclip"></i></span></div>
                    <div class="cv2-kpi-val">{{ $counts['documents'] }}</div><div class="cv2-kpi-lbl">Documents</div>
                </a>
                <a class="cv2-kpi" href="{{ route('contact.v2.loadvendor.activity', $v['id']) }}" style="text-decoration:none;color:inherit;">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic is-slate"><i class="bi bi-clock-history"></i></span></div>
                    <div class="cv2-kpi-val">{{ $counts['activity'] }}</div><div class="cv2-kpi-lbl">Activities</div>
                </a>
            </div>

            <div class="cv2-grid cv2-grid-2 cv2-mt">
                <div class="cv2-card">
                    <div class="cv2-card-h"><h3>Contact Persons</h3><a class="cv2-link" href="{{ route('contact.v2.loadvendor.customers', $v['id']) }}">Manage →</a></div>
                    <div class="cv2-card-b is-flush">
                        <table class="cv2-table">
                            <thead><tr><th>Name</th><th>Designation</th><th>Phone</th></tr></thead>
                            <tbody>
                                <tr><td><span class="cv2-t-name">{{ $v['name'] }}</span></td><td>Owner / Broker</td><td class="cv2-t-mono">{{ $v['phone'] }}</td></tr>
                                <tr><td><span class="cv2-t-name">Pranab Kalita</span></td><td>Operations Manager</td><td class="cv2-t-mono">+91 90853 44120</td></tr>
                                <tr><td><span class="cv2-t-name">Jyoti Bora</span></td><td>Accounts</td><td class="cv2-t-mono">+91 99540 77310</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="cv2-card">
                    <div class="cv2-card-h"><h3>Recent Activity</h3><a class="cv2-link" href="{{ route('contact.v2.loadvendor.activity', $v['id']) }}">View all →</a></div>
                    <div class="cv2-card-b">
                        <ul class="cv2-mini">
                            <li><span class="cv2-mini-ic"><i class="bi bi-geo-alt"></i></span><div class="cv2-mini-body"><b>New loading point added</b><span>by Superadmin · 2 days ago</span></div></li>
                            <li><span class="cv2-mini-ic"><i class="bi bi-people"></i></span><div class="cv2-mini-body"><b>Contact person “Pranab Kalita” added</b><span>by Operations · 5 days ago</span></div></li>
                            <li><span class="cv2-mini-ic"><i class="bi bi-paperclip"></i></span><div class="cv2-mini-body"><b>Agreement document uploaded</b><span>by Superadmin · 1 week ago</span></div></li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
