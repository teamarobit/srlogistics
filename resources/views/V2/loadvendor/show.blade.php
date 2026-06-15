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
                                @forelse($persons as $p)
                                <tr><td><span class="cv2-t-name">{{ $p->name ?? '—' }}</span></td><td>{{ $p->position ?? '—' }}</td><td class="cv2-t-mono">{{ $p->phone ? '+'.ltrim($p->ph_prefix,'+').' '.$p->phone : '—' }}</td></tr>
                                @empty
                                <tr><td colspan="3" class="text-center cv2-empty">No contact persons yet.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="cv2-card">
                    <div class="cv2-card-h"><h3>Recent Activity</h3><a class="cv2-link" href="{{ route('contact.v2.loadvendor.activity', $v['id']) }}">View all →</a></div>
                    <div class="cv2-card-b">
                        <ul class="cv2-mini">
                            @forelse($recentActivities as $act)
                            <li><span class="cv2-mini-ic"><i class="bi {{ $act->is_blacklisted === 'Yes' ? 'bi-exclamation-octagon' : 'bi-chat-left-text' }}"></i></span><div class="cv2-mini-body"><b>{{ $act->notes }}</b><span>by {{ optional($act->createdBy)->name ?? 'System' }} · {{ $act->created_at ? $act->created_at->diffForHumans() : '' }}</span></div></li>
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
