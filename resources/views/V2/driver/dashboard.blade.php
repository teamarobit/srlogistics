@extends('layouts.app')

@section('css')
<link href="{{ asset('css/V2/driver.css?v=1.0') }}" rel="stylesheet">
@endsection

@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="cv2-wrap">
        <div class="cv2-container">

            <div class="cv2-phead">
                <div>
                    <div class="cv2-crumb"><a href="{{ route('home') }}">Master Data</a> · Contacts · Driver</div>
                    <h1>Driver Dashboard</h1>
                    <div class="cv2-sub">Overview of your driver workforce, licences, vehicle allocations and bhatta.</div>
                </div>
                <div class="cv2-phead-actions">
                    <a href="{{ route('contact.v2.driver.index') }}" class="cv2-btn cv2-btn-ghost"><i class="bi bi-list-ul"></i>View All</a>
                    <a href="{{ route('contact.v2.driver.create') }}" class="cv2-btn cv2-btn-primary"><i class="bi bi-plus-lg"></i>Add Driver</a>
                </div>
            </div>

            <div class="cv2-kpis">
                <div class="cv2-kpi">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic"><i class="bi bi-person-badge"></i></span><span class="cv2-kpi-trend cv2-up">+6</span></div>
                    <div class="cv2-kpi-val">86</div><div class="cv2-kpi-lbl">Total Drivers</div>
                </div>
                <div class="cv2-kpi">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic is-ok"><i class="bi bi-check2-circle"></i></span><span class="cv2-kpi-trend cv2-up">+4</span></div>
                    <div class="cv2-kpi-val">71</div><div class="cv2-kpi-lbl">Active</div>
                </div>
                <div class="cv2-kpi">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic is-slate"><i class="bi bi-pause-circle"></i></span><span class="cv2-kpi-trend cv2-flat">0</span></div>
                    <div class="cv2-kpi-val">11</div><div class="cv2-kpi-lbl">Inactive</div>
                </div>
                <div class="cv2-kpi">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic is-bad"><i class="bi bi-slash-circle"></i></span><span class="cv2-kpi-trend cv2-down">+1</span></div>
                    <div class="cv2-kpi-val">4</div><div class="cv2-kpi-lbl">Blacklisted</div>
                </div>
                <div class="cv2-kpi">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic is-warn"><i class="bi bi-airplane"></i></span><span class="cv2-kpi-trend cv2-flat">3</span></div>
                    <div class="cv2-kpi-val">7</div><div class="cv2-kpi-lbl">On Leave</div>
                </div>
                <div class="cv2-kpi">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic"><i class="bi bi-truck"></i></span><span class="cv2-kpi-trend cv2-up">+2</span></div>
                    <div class="cv2-kpi-val">64</div><div class="cv2-kpi-lbl">Vehicles Allocated</div>
                </div>
            </div>

            <div class="cv2-grid cv2-grid-2-1 cv2-mt">
                <div class="cv2-card">
                    <div class="cv2-card-h"><h3>Recent Drivers</h3><a class="cv2-link" href="{{ route('contact.v2.driver.index') }}">View all →</a></div>
                    <div class="cv2-card-b is-flush">
                        <table class="cv2-table">
                            <thead><tr><th>Driver</th><th>Category</th><th>Vehicle</th><th>RAG</th><th>Status</th><th></th></tr></thead>
                            <tbody>
                                @foreach($drivers as $d)
                                <tr>
                                    <td>
                                        <div style="display:flex;align-items:center;gap:11px;">
                                            <span class="cv2-avatar" style="width:36px;height:36px;font-size:13px;border-radius:10px;">{{ strtoupper(mb_substr($d['name'],0,1)) }}</span>
                                            <div><span class="cv2-t-name">{{ $d['name'] }}</span><div class="cv2-t-sub">{{ $d['driver_code'] }}</div></div>
                                        </div>
                                    </td>
                                    <td><span class="cv2-pill">{{ $d['category'] }}</span></td>
                                    <td class="cv2-t-mono">{{ $d['vehicle'] }}</td>
                                    <td>@php $rc=['Red'=>'is-red','Yellow'=>'is-yellow','Green'=>'is-green'][$d['rag']]??'is-green'; @endphp<span class="cv2-rag {{ $rc }}"><span class="dot"></span>{{ $d['rag'] }}</span></td>
                                    <td>
                                        @php $sc=['Active'=>'is-active','Inactive'=>'is-inactive','Blacklisted'=>'is-black'][$d['status']]??'is-inactive'; @endphp
                                        <span class="cv2-badge {{ $sc }}"><span class="cv2-badge-dot"></span>{{ $d['status'] }}</span>
                                    </td>
                                    <td class="cv2-actions"><a href="{{ route('contact.v2.driver.show', $d['id']) }}" class="cv2-ic-btn" title="Open"><i class="bi bi-arrow-right"></i></a></td>
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
                            <a href="{{ route('contact.v2.driver.create') }}" class="cv2-btn cv2-btn-primary" style="justify-content:flex-start;"><i class="bi bi-person-plus"></i>New Driver</a>
                            <a href="{{ route('contact.v2.driver.index') }}" class="cv2-btn cv2-btn-ghost" style="justify-content:flex-start;"><i class="bi bi-search"></i>Find a Driver</a>
                            <a href="{{ route('contact.v2.driver.bhatta', 1) }}" class="cv2-btn cv2-btn-ghost" style="justify-content:flex-start;"><i class="bi bi-cash-coin"></i>Record Bhatta</a>
                            <a href="{{ route('contact.v2.driver.joining', 1) }}" class="cv2-btn cv2-btn-ghost" style="justify-content:flex-start;"><i class="bi bi-file-earmark-text"></i>Joining Letter</a>
                        </div>
                    </div>
                    <div class="cv2-card cv2-mt">
                        <div class="cv2-card-h"><h3>By Category</h3></div>
                        <div class="cv2-card-b">
                            <ul class="cv2-mini">
                                <li><span class="cv2-mini-ic"><i class="bi bi-signpost-2"></i></span><div class="cv2-mini-body"><b>Line</b><span>52 drivers</span></div><span class="cv2-t-mono">60%</span></li>
                                <li><span class="cv2-mini-ic"><i class="bi bi-geo"></i></span><div class="cv2-mini-body"><b>Local</b><span>34 drivers</span></div><span class="cv2-t-mono">40%</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="cv2-card cv2-mt">
                        <div class="cv2-card-h"><h3>Licence Expiry</h3></div>
                        <div class="cv2-card-b">
                            <ul class="cv2-mini">
                                <li><span class="cv2-mini-ic" style="background:#fde8ec;color:#ea0027;"><i class="bi bi-exclamation-octagon"></i></span><div class="cv2-mini-body"><b>Expired</b><span>2 licences</span></div><span class="cv2-t-mono">2</span></li>
                                <li><span class="cv2-mini-ic" style="background:#fbf1dd;color:#b8770a;"><i class="bi bi-hourglass-split"></i></span><div class="cv2-mini-body"><b>Expiring ≤ 60 days</b><span>5 licences</span></div><span class="cv2-t-mono">5</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
