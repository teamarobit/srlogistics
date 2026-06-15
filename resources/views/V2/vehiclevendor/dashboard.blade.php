@extends('layouts.app')

@section('css')
<link href="{{ asset('css/V2/vehiclevendor.css?v=1.0') }}" rel="stylesheet">
@endsection

@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="cv2-wrap">
        <div class="cv2-container">

            {{-- Page header --}}
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

            {{-- KPI row --}}
            <div class="cv2-kpis">
                <div class="cv2-kpi">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic"><i class="bi bi-buildings"></i></span><span class="cv2-kpi-trend cv2-up">+4%</span></div>
                    <div class="cv2-kpi-val">118</div><div class="cv2-kpi-lbl">Total Vendors</div>
                </div>
                <div class="cv2-kpi">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic is-ok"><i class="bi bi-check2-circle"></i></span><span class="cv2-kpi-trend cv2-up">+6</span></div>
                    <div class="cv2-kpi-val">103</div><div class="cv2-kpi-lbl">Active</div>
                </div>
                <div class="cv2-kpi">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic is-slate"><i class="bi bi-pause-circle"></i></span><span class="cv2-kpi-trend cv2-flat">0</span></div>
                    <div class="cv2-kpi-val">12</div><div class="cv2-kpi-lbl">Inactive</div>
                </div>
                <div class="cv2-kpi">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic is-bad"><i class="bi bi-slash-circle"></i></span><span class="cv2-kpi-trend cv2-down">+1</span></div>
                    <div class="cv2-kpi-val">3</div><div class="cv2-kpi-lbl">Blacklisted</div>
                </div>
                <div class="cv2-kpi">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic"><i class="bi bi-truck"></i></span><span class="cv2-kpi-trend cv2-up">+18</span></div>
                    <div class="cv2-kpi-val">642</div><div class="cv2-kpi-lbl">Vehicles Supplied</div>
                </div>
                <div class="cv2-kpi">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic"><i class="bi bi-signpost-split"></i></span><span class="cv2-kpi-trend cv2-up">+9</span></div>
                    <div class="cv2-kpi-val">87</div><div class="cv2-kpi-lbl">Routes Covered</div>
                </div>
            </div>

            {{-- Recent + side --}}
            <div class="cv2-grid cv2-grid-2-1 cv2-mt">
                <div class="cv2-card">
                    <div class="cv2-card-h"><h3>Recent Vendors</h3><a class="cv2-link" href="{{ route('contact.v2.vehiclevendor.index') }}">View all →</a></div>
                    <div class="cv2-card-b is-flush">
                        <table class="cv2-table">
                            <thead><tr><th>Vendor</th><th>Vehicles</th><th>City</th><th>RAG</th><th>Status</th><th></th></tr></thead>
                            <tbody>
                                @foreach($vendors as $v)
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
                                @endforeach
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
                            <a href="{{ route('contact.v2.vehiclevendor.vehicle', 1) }}" class="cv2-btn cv2-btn-ghost" style="justify-content:flex-start;"><i class="bi bi-truck"></i>Add Supplied Vehicle</a>
                            <a href="{{ route('contact.v2.vehiclevendor.route', 1) }}" class="cv2-btn cv2-btn-ghost" style="justify-content:flex-start;"><i class="bi bi-signpost-split"></i>Add Route</a>
                        </div>
                    </div>
                    <div class="cv2-card cv2-mt">
                        <div class="cv2-card-h"><h3>By RAG Status</h3></div>
                        <div class="cv2-card-b">
                            <ul class="cv2-mini">
                                <li><span class="cv2-mini-ic" style="background:var(--cv2-ok-bg);color:var(--cv2-ok);"><i class="bi bi-circle-fill"></i></span><div class="cv2-mini-body"><b>Green</b><span>74 vendors</span></div><span class="cv2-t-mono">63%</span></li>
                                <li><span class="cv2-mini-ic" style="background:var(--cv2-warn-bg);color:var(--cv2-warn);"><i class="bi bi-circle-fill"></i></span><div class="cv2-mini-body"><b>Yellow</b><span>31 vendors</span></div><span class="cv2-t-mono">26%</span></li>
                                <li><span class="cv2-mini-ic" style="background:var(--cv2-bad-bg);color:var(--cv2-bad);"><i class="bi bi-circle-fill"></i></span><div class="cv2-mini-body"><b>Red</b><span>13 vendors</span></div><span class="cv2-t-mono">11%</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
