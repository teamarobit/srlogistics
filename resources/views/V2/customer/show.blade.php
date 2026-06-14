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
                <div class="cv2-crumb"><a href="{{ route('contact.v2.customer.index') }}">Customers</a> · {{ $c['name'] }} · Overview</div>
            </div>

            @include('V2.customer.partials.workspace-head')

            {{-- Overview summary --}}
            <div class="cv2-kpis cv2-mt" style="grid-template-columns:repeat(6,1fr);">
                <a class="cv2-kpi" href="{{ route('contact.v2.customer.contracts', $c['id']) }}" style="text-decoration:none;color:inherit;">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic"><i class="bi bi-file-earmark-text"></i></span></div>
                    <div class="cv2-kpi-val">{{ $counts['contracts'] }}</div><div class="cv2-kpi-lbl">Contracts</div>
                </a>
                <a class="cv2-kpi" href="{{ route('contact.v2.customer.locations', $c['id']) }}" style="text-decoration:none;color:inherit;">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic"><i class="bi bi-geo-alt"></i></span></div>
                    <div class="cv2-kpi-val">{{ $counts['locations'] }}</div><div class="cv2-kpi-lbl">Locations</div>
                </a>
                <a class="cv2-kpi" href="{{ route('contact.v2.customer.ratechart', $c['id']) }}" style="text-decoration:none;color:inherit;">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic"><i class="bi bi-cash-stack"></i></span></div>
                    <div class="cv2-kpi-val">{{ $counts['ratecharts'] }}</div><div class="cv2-kpi-lbl">Rate Charts</div>
                </a>
                <a class="cv2-kpi" href="{{ route('contact.v2.customer.vehicles', $c['id']) }}" style="text-decoration:none;color:inherit;">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic"><i class="bi bi-truck"></i></span></div>
                    <div class="cv2-kpi-val">{{ $counts['vehicles'] }}</div><div class="cv2-kpi-lbl">Vehicles</div>
                </a>
                <a class="cv2-kpi" href="{{ route('contact.v2.customer.documents', $c['id']) }}" style="text-decoration:none;color:inherit;">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic is-slate"><i class="bi bi-paperclip"></i></span></div>
                    <div class="cv2-kpi-val">{{ $counts['documents'] }}</div><div class="cv2-kpi-lbl">Documents</div>
                </a>
                <a class="cv2-kpi" href="{{ route('contact.v2.customer.activity', $c['id']) }}" style="text-decoration:none;color:inherit;">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic is-slate"><i class="bi bi-clock-history"></i></span></div>
                    <div class="cv2-kpi-val">{{ $counts['activity'] }}</div><div class="cv2-kpi-lbl">Activities</div>
                </a>
            </div>

            <div class="cv2-grid cv2-grid-2 cv2-mt">
                <div class="cv2-card">
                    <div class="cv2-card-h"><h3>Active Contracts</h3><a class="cv2-link" href="{{ route('contact.v2.customer.contracts', $c['id']) }}">Manage →</a></div>
                    <div class="cv2-card-b is-flush">
                        <table class="cv2-table">
                            <thead><tr><th>Contract No</th><th>Type</th><th>Validity</th><th>Status</th></tr></thead>
                            <tbody>
                                <tr><td class="cv2-t-mono">CTR-2026-014</td><td>Monthly</td><td>01 Apr 26 – 31 Mar 27</td><td><span class="cv2-badge is-active"><span class="cv2-badge-dot"></span>Active</span></td></tr>
                                <tr><td class="cv2-t-mono">CTR-2025-188</td><td>Lifetime</td><td>No expiry</td><td><span class="cv2-badge is-active"><span class="cv2-badge-dot"></span>Active</span></td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="cv2-card">
                    <div class="cv2-card-h"><h3>Recent Activity</h3><a class="cv2-link" href="{{ route('contact.v2.customer.activity', $c['id']) }}">View all →</a></div>
                    <div class="cv2-card-b">
                        <ul class="cv2-mini">
                            <li><span class="cv2-mini-ic"><i class="bi bi-pencil"></i></span><div class="cv2-mini-body"><b>Rate chart updated</b><span>by Superadmin · 2 days ago</span></div></li>
                            <li><span class="cv2-mini-ic"><i class="bi bi-truck"></i></span><div class="cv2-mini-body"><b>Vehicle AS01GC4471 allocated</b><span>by Superadmin · 5 days ago</span></div></li>
                            <li><span class="cv2-mini-ic"><i class="bi bi-geo-alt"></i></span><div class="cv2-mini-body"><b>New unloading point added</b><span>by Operations · 1 week ago</span></div></li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
