@extends('layouts.app')

@section('css')
<link href="{{ asset('css/V2/vehiclevendor.css?v=2.0') }}" rel="stylesheet">
@endsection

@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="cv2-wrap">
        <div class="cv2-container">

            <div class="cv2-phead">
                <div>
                    <div class="cv2-crumb"><a href="{{ route('home') }}">Master Data</a> · Contacts · Vehicle Vendor</div>
                    <h1>Vehicle Vendor Dashboard</h1>
                    <div class="cv2-sub">Overview of your vehicle-supplying vendors, fleet supplied and route coverage.</div>
                </div>
                <div class="cv2-phead-actions">
                    <a href="{{ route('contact.v2.vehiclevendor.index') }}" class="cv2-btn cv2-btn-ghost"><i class="bi bi-list-ul"></i>View All</a>
                    <a href="{{ route('contact.v2.vehiclevendor.create') }}" class="cv2-btn cv2-btn-primary"><i class="bi bi-plus-lg"></i>Add Vendor</a>
                </div>
            </div>

            <div class="cv2-kpis">
                <div class="cv2-kpi">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic"><i class="bi bi-buildings"></i></span></div>
                    <div class="cv2-kpi-val">{{ $kpis['total'] }}</div><div class="cv2-kpi-lbl">Total Vendors</div>
                </div>
                <div class="cv2-kpi">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic is-ok"><i class="bi bi-check2-circle"></i></span></div>
                    <div class="cv2-kpi-val">{{ $kpis['active'] }}</div><div class="cv2-kpi-lbl">Active</div>
                </div>
                <div class="cv2-kpi">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic is-slate"><i class="bi bi-pause-circle"></i></span></div>
                    <div class="cv2-kpi-val">{{ $kpis['inactive'] }}</div><div class="cv2-kpi-lbl">Inactive</div>
                </div>
                <div class="cv2-kpi">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic is-bad"><i class="bi bi-slash-circle"></i></span></div>
                    <div class="cv2-kpi-val">{{ $kpis['blacklisted'] }}</div><div class="cv2-kpi-lbl">Blacklisted</div>
                </div>
                <div class="cv2-kpi">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic"><i class="bi bi-truck"></i></span></div>
                    <div class="cv2-kpi-val">{{ $kpis['vehicles_supplied'] }}</div><div class="cv2-kpi-lbl">Vehicles Supplied</div>
                </div>
                <div class="cv2-kpi">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic"><i class="bi bi-signpost-split"></i></span></div>
                    <div class="cv2-kpi-val">{{ $kpis['routes'] }}</div><div class="cv2-kpi-lbl">Routes Covered</div>
                </div>
            </div>

            <div class="cv2-grid cv2-grid-2-1 cv2-mt">
                <div class="cv2-card">
                    <div class="cv2-card-h"><h3>Recent Vendors</h3><a class="cv2-link" href="{{ route('contact.v2.vehiclevendor.index') }}">View all →</a></div>
                    <div class="cv2-card-b is-flush">
                        <table class="cv2-table">
                            <thead><tr><th>Vendor</th><th>Vehicles</th><th>City</th><th>RAG</th><th>Status</th><th></th></tr></thead>
                            <tbody>
                                @forelse($vendors as $v)
                                <tr>
                                    <td>
                                        <div style="display:flex;align-items:center;gap:11px;">
                                            <span class="cv2-avatar" style="width:36px;height:36px;font-size:13px;border-radius:10px;">{{ strtoupper(mb_substr($v['company'],0,1)) }}</span>
                                            <div><span class="cv2-t-name">{{ $v['company'] }}</span><div class="cv2-t-sub">{{ $v['contactno'] }} · {{ $v['name'] }}</div></div>
                                        </div>
                                    </td>
                                    <td class="cv2-t-mono">{{ $v['vehicles'] }}</td>
                                    <td>{{ $v['city'] }}</td>
                                    <td>@php $rc=['Green'=>'is-green','Yellow'=>'is-yellow','Red'=>'is-red'][$v['rag']]??'is-green'; @endphp<span class="cv2-rag {{ $rc }}">{{ $v['rag'] }}</span></td>
                                    <td>
                                        @php $sc=['Active'=>'is-active','Inactive'=>'is-inactive','Blacklisted'=>'is-black'][$v['status']]??'is-inactive'; @endphp
                                        <span class="cv2-badge {{ $sc }}"><span class="cv2-badge-dot"></span>{{ $v['status'] }}</span>
                                    </td>
                                    <td class="cv2-actions"><a href="{{ route('contact.v2.vehiclevendor.show', $v['id']) }}" class="cv2-ic-btn" title="Open"><i class="bi bi-arrow-right"></i></a></td>
                                </tr>
                                @empty
                                <tr><td colspan="6" class="text-center cv2-empty">No vendors yet.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div>
                    <div class="cv2-card">
                        <div class="cv2-card-h"><h3>Quick Actions</h3></div>
                        <div class="cv2-card-b" style="display:flex;flex-direction:column;gap:10px;">
                            <a href="{{ route('contact.v2.vehiclevendor.create') }}" class="cv2-btn cv2-btn-primary" style="justify-content:flex-start;"><i class="bi bi-building-add"></i>New Vendor</a>
                            <a href="{{ route('contact.v2.vehiclevendor.index') }}" class="cv2-btn cv2-btn-ghost" style="justify-content:flex-start;"><i class="bi bi-search"></i>Find a Vendor</a>
                        </div>
                    </div>
                    <div class="cv2-card cv2-mt">
                        <div class="cv2-card-h"><h3>By RAG Status</h3></div>
                        <div class="cv2-card-b">
                            <ul class="cv2-mini">
                                @foreach($ragBreakdown as $row)
                                @php $rmap=['Green'=>['var(--cv2-ok-bg)','var(--cv2-ok)'],'Yellow'=>['var(--cv2-warn-bg)','var(--cv2-warn)'],'Red'=>['var(--cv2-bad-bg)','var(--cv2-bad)']][$row['rag']]; @endphp
                                <li><span class="cv2-mini-ic" style="background:{{ $rmap[0] }};color:{{ $rmap[1] }};"><i class="bi bi-circle-fill"></i></span><div class="cv2-mini-body"><b>{{ $row['rag'] }}</b><span>{{ $row['total'] }} vendors</span></div><span class="cv2-t-mono">{{ $row['pct'] }}%</span></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
