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
                <div class="cv2-crumb"><a href="{{ route('contact.v2.sparevendor.index') }}">Spare Vendors</a> · {{ $v['company'] }} · Overview</div>
            </div>

            @include('V2.sparevendor.partials.workspace-head')

            {{-- Overview summary --}}
            <div class="cv2-kpis cv2-mt" style="grid-template-columns:repeat(4,1fr);">
                <a class="cv2-kpi" href="{{ route('contact.v2.sparevendor.spareparts', $v['id']) }}" style="text-decoration:none;color:inherit;">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic"><i class="bi bi-gear-wide-connected"></i></span></div>
                    <div class="cv2-kpi-val">{{ $counts['spareparts'] }}</div><div class="cv2-kpi-lbl">Spare Parts</div>
                </a>
                <div class="cv2-kpi">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic is-slate"><i class="bi bi-bank"></i></span></div>
                    <div class="cv2-kpi-val">{{ $counts['banks'] }}</div><div class="cv2-kpi-lbl">Bank Accounts</div>
                </div>
                <a class="cv2-kpi" href="{{ route('contact.v2.sparevendor.documents', $v['id']) }}" style="text-decoration:none;color:inherit;">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic is-slate"><i class="bi bi-paperclip"></i></span></div>
                    <div class="cv2-kpi-val">{{ $counts['documents'] }}</div><div class="cv2-kpi-lbl">Documents</div>
                </a>
                <a class="cv2-kpi" href="{{ route('contact.v2.sparevendor.activity', $v['id']) }}" style="text-decoration:none;color:inherit;">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic is-slate"><i class="bi bi-clock-history"></i></span></div>
                    <div class="cv2-kpi-val">{{ $counts['activity'] }}</div><div class="cv2-kpi-lbl">Activities</div>
                </a>
            </div>

            <div class="cv2-grid cv2-grid-2 cv2-mt">
                <div class="cv2-card">
                    <div class="cv2-card-h"><h3>Bank Details</h3><a class="cv2-link" href="{{ route('contact.v2.sparevendor.edit', $v['id']) }}">Manage →</a></div>
                    <div class="cv2-card-b is-flush">
                        <table class="cv2-table">
                            <thead><tr><th>Bank</th><th>Account No</th><th>IFSC</th><th>Primary</th></tr></thead>
                            <tbody>
                                @forelse($banks as $bd)
                                <tr>
                                    <td class="cv2-t-name">{{ optional($bd->bank)->name ?? '—' }}</td>
                                    <td class="cv2-t-mono">{{ $bd->account_number }}</td>
                                    <td class="cv2-t-mono">{{ $bd->ifsc_code }}</td>
                                    <td>@if($bd->is_primary === 'Yes')<span class="cv2-badge is-active"><span class="cv2-badge-dot"></span>Primary</span>@else<span class="cv2-pill">—</span>@endif</td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="text-center cv2-empty">No bank accounts.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="cv2-card">
                    <div class="cv2-card-h"><h3>Recent Activity</h3><a class="cv2-link" href="{{ route('contact.v2.sparevendor.activity', $v['id']) }}">View all →</a></div>
                    <div class="cv2-card-b">
                        <ul class="cv2-mini">
                            @forelse($activities as $act)
                            <li><span class="cv2-mini-ic"><i class="bi {{ $act->is_blacklisted === 'Yes' ? 'bi-exclamation-octagon' : 'bi-chat-left-text' }}"></i></span><div class="cv2-mini-body"><b>{{ $act->notes }}</b><span>by {{ optional($act->createdBy)->name ?? 'System' }} · {{ $act->created_at ? $act->created_at->diffForHumans() : '' }}</span></div></li>
                            @empty
                            <li><div class="cv2-mini-body"><span class="cv2-empty">No activity yet.</span></div></li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>

            <div class="cv2-card cv2-mt">
                <div class="cv2-card-h"><h3>Top Supplied Items</h3><a class="cv2-link" href="{{ route('contact.v2.sparevendor.spareparts', $v['id']) }}">All spare parts →</a></div>
                <div class="cv2-card-b is-flush">
                    <table class="cv2-table">
                        <thead><tr><th>Part</th><th>Category</th><th>Part No</th><th>Unit Price</th><th>Status</th></tr></thead>
                        <tbody>
                            @forelse($topParts as $part)
                                @php $st = ($part->status === 'Active') ? 'is-active' : 'is-inactive'; @endphp
                                <tr>
                                    <td class="cv2-t-name">{{ $part->name }}</td>
                                    <td><span class="cv2-pill">{{ optional($part->partCategory)->name ?? '—' }}</span></td>
                                    <td class="cv2-t-mono">{{ $part->part_no }}</td>
                                    <td class="cv2-t-mono">₹{{ number_format((float) $part->standard_cost, 2) }}</td>
                                    <td><span class="cv2-badge {{ $st }}"><span class="cv2-badge-dot"></span>{{ $part->status ?? '—' }}</span></td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center cv2-empty">No catalogue parts in this vendor's specialisation.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
