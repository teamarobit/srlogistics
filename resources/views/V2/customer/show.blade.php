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
                                @forelse($recentContracts as $contract)
                                    @php
                                        $today  = \Carbon\Carbon::today();
                                        $status = 'Inactive';
                                        if ($contract->contract_type_id == 6) { $status = 'Life Time'; }
                                        elseif ($contract->start_date && $contract->end_date && $contract->start_date <= $today && $contract->end_date >= $today) { $status = 'Active'; }
                                        $statusClass = ['Active'=>'is-active','Life Time'=>'is-active','Inactive'=>'is-inactive'][$status] ?? 'is-inactive';
                                    @endphp
                                    <tr>
                                        <td class="cv2-t-mono">{{ $contract->contract_no }}</td>
                                        <td>{{ optional($contract->contracttype)->name ?? '—' }}</td>
                                        <td>
                                            @if($contract->contract_type_id == 6) No expiry
                                            @else {{ $contract->start_date ? \Carbon\Carbon::parse($contract->start_date)->format('d M y') : '—' }} – {{ $contract->end_date ? \Carbon\Carbon::parse($contract->end_date)->format('d M y') : '—' }} @endif
                                        </td>
                                        <td><span class="cv2-badge {{ $statusClass }}"><span class="cv2-badge-dot"></span>{{ $status }}</span></td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="text-center cv2-empty">No contracts yet.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="cv2-card">
                    <div class="cv2-card-h"><h3>Recent Activity</h3><a class="cv2-link" href="{{ route('contact.v2.customer.activity', $c['id']) }}">View all →</a></div>
                    <div class="cv2-card-b">
                        <ul class="cv2-mini">
                            @forelse($recentActivities as $act)
                                <li>
                                    <span class="cv2-mini-ic"><i class="bi {{ $act->is_blacklisted === 'Yes' ? 'bi-exclamation-octagon' : 'bi-chat-left-text' }}"></i></span>
                                    <div class="cv2-mini-body">
                                        <b>{{ \Illuminate\Support\Str::limit($act->notes, 60) }}</b>
                                        <span>by {{ optional($act->createdBy)->name ?? 'System' }} · {{ $act->created_at ? $act->created_at->diffForHumans() : '' }}</span>
                                    </div>
                                </li>
                            @empty
                                <li><div class="cv2-mini-body"><span class="cv2-empty">No recent activity.</span></div></li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
