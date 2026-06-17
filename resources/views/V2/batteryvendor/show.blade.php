@extends('layouts.app')

@section('css')
<link href="{{ asset('css/V2/customer.css?v=1.4') }}" rel="stylesheet">
@endsection

@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="cv2-wrap">
        <div class="cv2-container">

            <div class="cv2-phead">
                <div class="cv2-crumb"><a href="{{ route('contact.v2.batteryvendor.index') }}">Battery Vendors</a> · {{ $v['company'] }} · Overview</div>
            </div>

            @include('V2.batteryvendor.partials.workspace-head')

            {{-- Overview summary --}}
            <div class="cv2-kpis cv2-mt" style="grid-template-columns:repeat(4,1fr);">
                <a class="cv2-kpi" href="{{ route('contact.v2.batteryvendor.documents', $v['id']) }}" style="text-decoration:none;color:inherit;">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic is-slate"><i class="bi bi-paperclip"></i></span></div>
                    <div class="cv2-kpi-val">{{ $counts['documents'] }}</div><div class="cv2-kpi-lbl">Documents</div>
                </a>
                <a class="cv2-kpi" href="{{ route('contact.v2.batteryvendor.battery', $v['id']) }}" style="text-decoration:none;color:inherit;">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic"><i class="bi bi-battery-charging"></i></span></div>
                    <div class="cv2-kpi-val">{{ $counts['battery'] }}</div><div class="cv2-kpi-lbl">Batteries Supplied</div>
                </a>
                <div class="cv2-kpi">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic"><i class="bi bi-bank"></i></span></div>
                    <div class="cv2-kpi-val">{{ $counts['banks'] }}</div><div class="cv2-kpi-lbl">Bank Accounts</div>
                </div>
                <a class="cv2-kpi" href="{{ route('contact.v2.batteryvendor.activity', $v['id']) }}" style="text-decoration:none;color:inherit;">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic is-slate"><i class="bi bi-clock-history"></i></span></div>
                    <div class="cv2-kpi-val">{{ $counts['activity'] }}</div><div class="cv2-kpi-lbl">Activities</div>
                </a>
            </div>

            <div class="cv2-grid cv2-grid-2 cv2-mt">
                <div class="cv2-card">
                    <div class="cv2-card-h"><h3>Vendor Snapshot</h3><a class="cv2-link" href="{{ route('contact.v2.batteryvendor.edit', $v['id']) }}">Edit →</a></div>
                    <div class="cv2-card-b is-flush">
                        <table class="cv2-table">
                            <tbody>
                                <tr><td class="cv2-t-sub">GST Number</td><td class="cv2-t-mono">{{ $v['gst'] }}</td></tr>
                                <tr><td class="cv2-t-sub">GST Treatment</td><td><span class="cv2-pill">Registered</span></td></tr>
                                <tr><td class="cv2-t-sub">Contact Code</td><td class="cv2-t-mono">{{ $v['code'] }}</td></tr>
                                <tr><td class="cv2-t-sub">No. of Vehicles</td><td class="cv2-t-mono">{{ $v['vehicles'] }}</td></tr>
                                <tr><td class="cv2-t-sub">TDS Percentage</td><td class="cv2-t-mono">{{ is_null($v['tds']) ? '—' : $v['tds'].'%' }}
                                    @if(!is_null($v['tds']) && $v['tds'] <= 1)<span class="cv2-badge is-warn" style="margin-left:6px;"><span class="cv2-badge-dot"></span>TDS Declaration required</span>@endif
                                </td></tr>
                                <tr><td class="cv2-t-sub">City</td><td>{{ $v['city'] }}</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="cv2-card">
                    <div class="cv2-card-h"><h3>Recent Activity</h3><a class="cv2-link" href="{{ route('contact.v2.batteryvendor.activity', $v['id']) }}">View all →</a></div>
                    <div class="cv2-card-b">
                        <ul class="cv2-mini">
                            @forelse($activities as $act)
                                <li>
                                    <span class="cv2-mini-ic"><i class="bi {{ $act->is_blacklisted === 'Yes' ? 'bi-exclamation-octagon' : 'bi-chat-left-text' }}"></i></span>
                                    <div class="cv2-mini-body"><b>{{ $act->notes }}</b><span>by {{ optional($act->createdBy)->name ?? 'System' }} · {{ $act->created_at ? $act->created_at->diffForHumans() : '' }}</span></div>
                                </li>
                            @empty
                                <li><div class="cv2-mini-body"><span class="cv2-empty">No activity yet.</span></div></li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('js/V2/customer.js?v=1.4') }}"></script>
@endsection
