@extends('layouts.app')

@section('css')
<link href="{{ asset('css/V2/tyrevendor.css?v=1.0') }}" rel="stylesheet">
@endsection

@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="cv2-wrap">
        <div class="cv2-container">

            <div class="cv2-phead">
                <div class="cv2-crumb"><a href="{{ route('contact.v2.tyrevendor.index') }}">Tyre Vendors</a> · {{ $v['company'] }} · Overview</div>
            </div>

            @include('V2.tyrevendor.partials.workspace-head')

            <div class="cv2-kpis cv2-mt" style="grid-template-columns:repeat(4,1fr);">
                <a class="cv2-kpi" href="{{ route('contact.v2.tyrevendor.tyre', $v['id']) }}" style="text-decoration:none;color:inherit;">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic"><i class="bi bi-record-circle"></i></span></div>
                    <div class="cv2-kpi-val">{{ $counts['tyres'] }}</div><div class="cv2-kpi-lbl">Tyres Supplied</div>
                </a>
                <a class="cv2-kpi" href="{{ route('contact.v2.tyrevendor.documents', $v['id']) }}" style="text-decoration:none;color:inherit;">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic is-slate"><i class="bi bi-paperclip"></i></span></div>
                    <div class="cv2-kpi-val">{{ $counts['documents'] }}</div><div class="cv2-kpi-lbl">Documents</div>
                </a>
                <div class="cv2-kpi">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic is-warn"><i class="bi bi-receipt"></i></span></div>
                    <div class="cv2-kpi-val">{{ rtrim(rtrim(number_format($v['tds'],2),'0'),'.') }}%</div><div class="cv2-kpi-lbl">TDS Percentage</div>
                </div>
                <a class="cv2-kpi" href="{{ route('contact.v2.tyrevendor.activity', $v['id']) }}" style="text-decoration:none;color:inherit;">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic is-slate"><i class="bi bi-clock-history"></i></span></div>
                    <div class="cv2-kpi-val">{{ $counts['activity'] }}</div><div class="cv2-kpi-lbl">Activities</div>
                </a>
            </div>

            <div class="cv2-grid cv2-grid-2 cv2-mt">
                <div class="cv2-card">
                    <div class="cv2-card-h"><h3>Company Snapshot</h3><a class="cv2-link" href="{{ route('contact.v2.tyrevendor.edit', $v['id']) }}">Edit →</a></div>
                    <div class="cv2-card-b is-flush">
                        <table class="cv2-table">
                            <tbody>
                                <tr><td class="cv2-t-sub">Contact No</td><td class="cv2-t-mono">{{ $v['contactno'] }}</td></tr>
                                <tr><td class="cv2-t-sub">Contact Code</td><td><span class="cv2-pill">{{ $v['code'] }}</span></td></tr>
                                <tr><td class="cv2-t-sub">Phone</td><td class="cv2-t-mono">{{ $v['phone'] }}</td></tr>
                                <tr><td class="cv2-t-sub">GST Number</td><td class="cv2-t-mono">{{ $v['gst'] }}</td></tr>
                                <tr><td class="cv2-t-sub">GST Treatment</td><td>{{ $v['gst_treatment'] }}</td></tr>
                                <tr><td class="cv2-t-sub">Primary Bank</td><td>{{ $v['primary_bank'] }}</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="cv2-card">
                    <div class="cv2-card-h"><h3>Recent Activity</h3><a class="cv2-link" href="{{ route('contact.v2.tyrevendor.activity', $v['id']) }}">View all →</a></div>
                    <div class="cv2-card-b">
                        <ul class="cv2-mini">
                            @forelse($recentActivities as $act)
                            <li><span class="cv2-mini-ic"><i class="bi {{ $act->is_blacklisted === 'Yes' ? 'bi-slash-circle' : 'bi-clock-history' }}"></i></span>
                                <div class="cv2-mini-body"><b>{{ \Illuminate\Support\Str::limit($act->notes, 60) }}</b>
                                <span>by {{ optional($act->createdBy)->name ?? 'System' }} · {{ \Carbon\Carbon::parse($act->created_at)->diffForHumans() }}</span></div></li>
                            @empty
                            <li><span class="cv2-mini-ic"><i class="bi bi-info-circle"></i></span><div class="cv2-mini-body"><b>No activity yet</b><span>Activity will appear here.</span></div></li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
@section('js')<script src="{{ asset('js/V2/tyrevendor.js?v=2.0') }}"></script>@endsection
