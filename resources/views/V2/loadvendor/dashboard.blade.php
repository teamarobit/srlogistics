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
                    <div class="cv2-crumb"><a href="{{ route('home') }}">Master Data</a> · Contacts · Load Vendor</div>
                    <h1>Load Vendor Dashboard</h1>
                    <div class="cv2-sub">Overview of brokers / load vendors, their contact persons and locations.</div>
                </div>
                <div class="cv2-phead-actions">
                    <a href="{{ route('contact.v2.loadvendor.index') }}" class="cv2-btn cv2-btn-ghost"><i class="bi bi-list-ul"></i>View All</a>
                    <a href="{{ route('contact.v2.loadvendor.create') }}" class="cv2-btn cv2-btn-primary"><i class="bi bi-plus-lg"></i>Add Load Vendor</a>
                </div>
            </div>

            {{-- KPI row --}}
            <div class="cv2-kpis">
                <div class="cv2-kpi">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic"><i class="bi bi-truck-front"></i></span><span class="cv2-kpi-trend cv2-up">+6%</span></div>
                    <div class="cv2-kpi-val">87</div><div class="cv2-kpi-lbl">Total Load Vendors</div>
                </div>
                <div class="cv2-kpi">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic is-ok"><i class="bi bi-check2-circle"></i></span><span class="cv2-kpi-trend cv2-up">+4</span></div>
                    <div class="cv2-kpi-val">79</div><div class="cv2-kpi-lbl">Active</div>
                </div>
                <div class="cv2-kpi">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic is-slate"><i class="bi bi-pause-circle"></i></span><span class="cv2-kpi-trend cv2-flat">0</span></div>
                    <div class="cv2-kpi-val">6</div><div class="cv2-kpi-lbl">Inactive</div>
                </div>
                <div class="cv2-kpi">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic is-bad"><i class="bi bi-slash-circle"></i></span><span class="cv2-kpi-trend cv2-down">+2</span></div>
                    <div class="cv2-kpi-val">2</div><div class="cv2-kpi-lbl">Blacklisted</div>
                </div>
                <div class="cv2-kpi">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic is-ok"><i class="bi bi-circle-fill"></i></span><span class="cv2-kpi-trend cv2-up">+3</span></div>
                    <div class="cv2-kpi-val">61</div><div class="cv2-kpi-lbl">RAG · Green</div>
                </div>
                <div class="cv2-kpi">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic is-bad"><i class="bi bi-circle-fill"></i></span><span class="cv2-kpi-trend cv2-flat">0</span></div>
                    <div class="cv2-kpi-val">7</div><div class="cv2-kpi-lbl">RAG · Red</div>
                </div>
            </div>

            {{-- Recent + side --}}
            <div class="cv2-grid cv2-grid-2-1 cv2-mt">
                <div class="cv2-card">
                    <div class="cv2-card-h"><h3>Recent Load Vendors</h3><a class="cv2-link" href="{{ route('contact.v2.loadvendor.index') }}">View all →</a></div>
                    <div class="cv2-card-b is-flush">
                        <table class="cv2-table">
                            <thead><tr><th>Load Vendor</th><th>Code</th><th>City</th><th>RAG</th><th>Status</th><th></th></tr></thead>
                            <tbody>
                                @foreach($vendors as $v)
                                <tr>
                                    <td>
                                        <div style="display:flex;align-items:center;gap:11px;">
                                            <span class="cv2-avatar" style="width:36px;height:36px;font-size:13px;border-radius:10px;">{{ strtoupper(mb_substr($v['company'],0,1)) }}</span>
                                            <div><span class="cv2-t-name">{{ $v['company'] }}</span><div class="cv2-t-sub">{{ $v['name'] }} · {{ $v['contactno'] }}</div></div>
                                        </div>
                                    </td>
                                    <td class="cv2-t-mono">{{ $v['code'] }}</td>
                                    <td>{{ $v['city'] }}</td>
                                    <td>
                                        @php $rc=['Green'=>'is-active','Yellow'=>'is-warn','Red'=>'is-black'][$v['rag']]??'is-inactive'; @endphp
                                        <span class="cv2-badge {{ $rc }}"><span class="cv2-badge-dot"></span>{{ $v['rag'] }}</span>
                                    </td>
                                    <td>
                                        @php $sc=['Active'=>'is-active','Inactive'=>'is-inactive','Blacklisted'=>'is-black'][$v['status']]??'is-inactive'; @endphp
                                        <span class="cv2-badge {{ $sc }}"><span class="cv2-badge-dot"></span>{{ $v['status'] }}</span>
                                    </td>
                                    <td class="cv2-actions"><a href="{{ route('contact.v2.loadvendor.show', $v['id']) }}" class="cv2-ic-btn" title="Open"><i class="bi bi-arrow-right"></i></a></td>
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
                            <a href="{{ route('contact.v2.loadvendor.create') }}" class="cv2-btn cv2-btn-primary" style="justify-content:flex-start;"><i class="bi bi-person-plus"></i>New Load Vendor</a>
                            <a href="{{ route('contact.v2.loadvendor.index') }}" class="cv2-btn cv2-btn-ghost" style="justify-content:flex-start;"><i class="bi bi-search"></i>Find a Load Vendor</a>
                            <a href="{{ route('contact.v2.loadvendor.show', 1) }}" class="cv2-btn cv2-btn-ghost" style="justify-content:flex-start;"><i class="bi bi-people"></i>Add Contact Person</a>
                            <a href="{{ route('contact.v2.loadvendor.show', 1) }}" class="cv2-btn cv2-btn-ghost" style="justify-content:flex-start;"><i class="bi bi-geo-alt"></i>Add Location</a>
                        </div>
                    </div>
                    <div class="cv2-card cv2-mt">
                        <div class="cv2-card-h"><h3>By Size</h3></div>
                        <div class="cv2-card-b">
                            <ul class="cv2-mini">
                                <li><span class="cv2-mini-ic"><i class="bi bi-circle-fill"></i></span><div class="cv2-mini-body"><b>Large</b><span>29 vendors</span></div><span class="cv2-t-mono">33%</span></li>
                                <li><span class="cv2-mini-ic"><i class="bi bi-circle-fill"></i></span><div class="cv2-mini-body"><b>Medium</b><span>41 vendors</span></div><span class="cv2-t-mono">47%</span></li>
                                <li><span class="cv2-mini-ic"><i class="bi bi-circle-fill"></i></span><div class="cv2-mini-body"><b>Small</b><span>17 vendors</span></div><span class="cv2-t-mono">20%</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
