@extends('layouts.app')

@section('css')
<link href="{{ asset('css/V2/customer.css?v=1.3') }}" rel="stylesheet">
@endsection

@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="cv2-wrap">
        <div class="cv2-container">

            {{-- Page header --}}
            <div class="cv2-phead">
                <div>
                    <div class="cv2-crumb"><a href="{{ route('home') }}">Master Data</a> · Contacts · Spare Part Vendor</div>
                    <h1>Spare Part Vendor Dashboard</h1>
                    <div class="cv2-sub">Overview of spare-part suppliers, their specialisations and supplied items.</div>
                </div>
                <div class="cv2-phead-actions">
                    <a href="{{ route('contact.v2.sparevendor.index') }}" class="cv2-btn cv2-btn-ghost"><i class="bi bi-list-ul"></i>View All</a>
                    <a href="{{ route('contact.v2.sparevendor.create') }}" class="cv2-btn cv2-btn-primary"><i class="bi bi-plus-lg"></i>Add Spare Vendor</a>
                </div>
            </div>

            {{-- KPI row --}}
            <div class="cv2-kpis">
                <div class="cv2-kpi">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic"><i class="bi bi-shop"></i></span></div>
                    <div class="cv2-kpi-val">{{ $kpis['total'] }}</div><div class="cv2-kpi-lbl">Total Spare Vendors</div>
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
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic"><i class="bi bi-tags"></i></span></div>
                    <div class="cv2-kpi-val">{{ $kpis['categories'] }}</div><div class="cv2-kpi-lbl">Spare Categories</div>
                </div>
                <div class="cv2-kpi">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic"><i class="bi bi-gear-wide-connected"></i></span></div>
                    <div class="cv2-kpi-val">{{ $kpis['items'] }}</div><div class="cv2-kpi-lbl">Catalogue Items</div>
                </div>
            </div>

            {{-- Recent + side --}}
            <div class="cv2-grid cv2-grid-2-1 cv2-mt">
                <div class="cv2-card">
                    <div class="cv2-card-h"><h3>Recent Spare Vendors</h3><a class="cv2-link" href="{{ route('contact.v2.sparevendor.index') }}">View all →</a></div>
                    <div class="cv2-card-b is-flush">
                        <table class="cv2-table">
                            <thead><tr><th>Spare Vendor</th><th>Specialisation</th><th>City</th><th>Items</th><th>Status</th><th></th></tr></thead>
                            <tbody>
                                @foreach($vendors as $v)
                                <tr>
                                    <td>
                                        <div style="display:flex;align-items:center;gap:11px;">
                                            <span class="cv2-avatar" style="width:36px;height:36px;font-size:13px;border-radius:10px;">{{ strtoupper(mb_substr($v['company'],0,1)) }}</span>
                                            <div><span class="cv2-t-name">{{ $v['company'] }}</span><div class="cv2-t-sub">{{ $v['name'] }} · {{ $v['contactno'] }}</div></div>
                                        </div>
                                    </td>
                                    <td>@foreach(array_slice($v['spec'],0,2) as $s)<span class="cv2-pill">{{ $s }}</span>@endforeach @if(count($v['spec'])>2)<span class="cv2-t-sub">+{{ count($v['spec'])-2 }}</span>@endif</td>
                                    <td>{{ $v['city'] }}</td>
                                    <td class="cv2-t-mono">{{ $v['items'] }}</td>
                                    <td>
                                        @php $sc=['Active'=>'is-active','Inactive'=>'is-inactive','Blacklisted'=>'is-black'][$v['status']]??'is-inactive'; @endphp
                                        <span class="cv2-badge {{ $sc }}"><span class="cv2-badge-dot"></span>{{ $v['status'] }}</span>
                                    </td>
                                    <td class="cv2-actions"><a href="{{ route('contact.v2.sparevendor.show', $v['id']) }}" class="cv2-ic-btn" title="Open"><i class="bi bi-arrow-right"></i></a></td>
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
                            <a href="{{ route('contact.v2.sparevendor.create') }}" class="cv2-btn cv2-btn-primary" style="justify-content:flex-start;"><i class="bi bi-person-plus"></i>New Spare Vendor</a>
                            <a href="{{ route('contact.v2.sparevendor.index') }}" class="cv2-btn cv2-btn-ghost" style="justify-content:flex-start;"><i class="bi bi-search"></i>Find a Spare Vendor</a>
                            <a href="{{ route('contact.v2.sparevendor.index') }}" class="cv2-btn cv2-btn-ghost" style="justify-content:flex-start;"><i class="bi bi-gear-wide-connected"></i>Browse Spare Parts</a>
                            <a href="{{ route('contact.v2.sparevendor.index') }}" class="cv2-btn cv2-btn-ghost" style="justify-content:flex-start;"><i class="bi bi-paperclip"></i>Manage Documents</a>
                        </div>
                    </div>
                    <div class="cv2-card cv2-mt">
                        <div class="cv2-card-h"><h3>By Specialisation</h3></div>
                        <div class="cv2-card-b">
                            <ul class="cv2-mini">
                                <li><span class="cv2-mini-ic"><i class="bi bi-circle-fill"></i></span><div class="cv2-mini-body"><b>Engine Parts</b><span>16 vendors</span></div><span class="cv2-t-mono">38%</span></li>
                                <li><span class="cv2-mini-ic"><i class="bi bi-circle-fill"></i></span><div class="cv2-mini-body"><b>Filters &amp; Lubricants</b><span>12 vendors</span></div><span class="cv2-t-mono">29%</span></li>
                                <li><span class="cv2-mini-ic"><i class="bi bi-circle-fill"></i></span><div class="cv2-mini-body"><b>Electricals</b><span>8 vendors</span></div><span class="cv2-t-mono">19%</span></li>
                                <li><span class="cv2-mini-ic"><i class="bi bi-circle-fill"></i></span><div class="cv2-mini-body"><b>Body &amp; Suspension</b><span>6 vendors</span></div><span class="cv2-t-mono">14%</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
