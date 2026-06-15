@extends('layouts.app')

@section('css')
<link href="{{ asset('css/V2/customer.css?v=1.4') }}" rel="stylesheet">
@endsection

@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="cv2-wrap">
        <div class="cv2-container">

            {{-- Page header --}}
            <div class="cv2-phead">
                <div>
                    <div class="cv2-crumb"><a href="{{ route('home') }}">Master Data</a> · Contacts · Battery Vendor</div>
                    <h1>Battery Vendor Dashboard</h1>
                    <div class="cv2-sub">Overview of battery vendors (GST-registered), their banks, supplied batteries and documents.</div>
                </div>
                <div class="cv2-phead-actions">
                    <a href="{{ route('contact.v2.batteryvendor.index') }}" class="cv2-btn cv2-btn-ghost"><i class="bi bi-list-ul"></i>View All</a>
                    <a href="{{ route('contact.v2.batteryvendor.create') }}" class="cv2-btn cv2-btn-primary"><i class="bi bi-plus-lg"></i>Add Battery Vendor</a>
                </div>
            </div>

            {{-- KPI row --}}
            <div class="cv2-kpis">
                <div class="cv2-kpi">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic"><i class="bi bi-battery-charging"></i></span><span class="cv2-kpi-trend cv2-up">+3%</span></div>
                    <div class="cv2-kpi-val">42</div><div class="cv2-kpi-lbl">Total Battery Vendors</div>
                </div>
                <div class="cv2-kpi">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic is-ok"><i class="bi bi-check2-circle"></i></span><span class="cv2-kpi-trend cv2-up">+2</span></div>
                    <div class="cv2-kpi-val">37</div><div class="cv2-kpi-lbl">Active</div>
                </div>
                <div class="cv2-kpi">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic is-slate"><i class="bi bi-pause-circle"></i></span><span class="cv2-kpi-trend cv2-flat">0</span></div>
                    <div class="cv2-kpi-val">4</div><div class="cv2-kpi-lbl">Inactive</div>
                </div>
                <div class="cv2-kpi">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic is-bad"><i class="bi bi-slash-circle"></i></span><span class="cv2-kpi-trend cv2-flat">+1</span></div>
                    <div class="cv2-kpi-val">1</div><div class="cv2-kpi-lbl">Blacklisted</div>
                </div>
                <div class="cv2-kpi">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic"><i class="bi bi-stack"></i></span><span class="cv2-kpi-trend cv2-up">+8</span></div>
                    <div class="cv2-kpi-val">218</div><div class="cv2-kpi-lbl">Batteries Supplied</div>
                </div>
                <div class="cv2-kpi">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic is-warn"><i class="bi bi-exclamation-triangle"></i></span><span class="cv2-kpi-trend cv2-flat">3</span></div>
                    <div class="cv2-kpi-val">3</div><div class="cv2-kpi-lbl">TDS Declaration Due</div>
                </div>
            </div>

            {{-- Recent + side --}}
            <div class="cv2-grid cv2-grid-2-1 cv2-mt">
                <div class="cv2-card">
                    <div class="cv2-card-h"><h3>Recent Battery Vendors</h3><a class="cv2-link" href="{{ route('contact.v2.batteryvendor.index') }}">View all →</a></div>
                    <div class="cv2-card-b is-flush">
                        <table class="cv2-table">
                            <thead><tr><th>Battery Vendor</th><th>Code</th><th>City</th><th>Batteries</th><th>Status</th><th></th></tr></thead>
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
                                    <td class="cv2-t-mono">{{ $v['batteries'] }}</td>
                                    <td>
                                        @php $sc=['Active'=>'is-active','Inactive'=>'is-inactive','Blacklisted'=>'is-black'][$v['status']]??'is-inactive'; @endphp
                                        <span class="cv2-badge {{ $sc }}"><span class="cv2-badge-dot"></span>{{ $v['status'] }}</span>
                                    </td>
                                    <td class="cv2-actions"><a href="{{ route('contact.v2.batteryvendor.show', $v['id']) }}" class="cv2-ic-btn" title="Open"><i class="bi bi-arrow-right"></i></a></td>
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
                            <a href="{{ route('contact.v2.batteryvendor.create') }}" class="cv2-btn cv2-btn-primary" style="justify-content:flex-start;"><i class="bi bi-person-plus"></i>New Battery Vendor</a>
                            <a href="{{ route('contact.v2.batteryvendor.index') }}" class="cv2-btn cv2-btn-ghost" style="justify-content:flex-start;"><i class="bi bi-search"></i>Find a Battery Vendor</a>
                            <a href="{{ route('contact.v2.batteryvendor.battery', 1) }}" class="cv2-btn cv2-btn-ghost" style="justify-content:flex-start;"><i class="bi bi-battery-charging"></i>Add Supplied Battery</a>
                            <a href="{{ route('contact.v2.batteryvendor.documents', 1) }}" class="cv2-btn cv2-btn-ghost" style="justify-content:flex-start;"><i class="bi bi-paperclip"></i>Upload Document</a>
                        </div>
                    </div>
                    <div class="cv2-card cv2-mt">
                        <div class="cv2-card-h"><h3>By City</h3></div>
                        <div class="cv2-card-b">
                            <ul class="cv2-mini">
                                <li><span class="cv2-mini-ic"><i class="bi bi-circle-fill"></i></span><div class="cv2-mini-body"><b>Guwahati</b><span>15 vendors</span></div><span class="cv2-t-mono">36%</span></li>
                                <li><span class="cv2-mini-ic"><i class="bi bi-circle-fill"></i></span><div class="cv2-mini-body"><b>Dibrugarh</b><span>11 vendors</span></div><span class="cv2-t-mono">26%</span></li>
                                <li><span class="cv2-mini-ic"><i class="bi bi-circle-fill"></i></span><div class="cv2-mini-body"><b>Silchar</b><span>9 vendors</span></div><span class="cv2-t-mono">21%</span></li>
                                <li><span class="cv2-mini-ic"><i class="bi bi-circle-fill"></i></span><div class="cv2-mini-body"><b>Others</b><span>7 vendors</span></div><span class="cv2-t-mono">17%</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
