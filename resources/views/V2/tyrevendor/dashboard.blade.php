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
                <div>
                    <div class="cv2-crumb"><a href="{{ route('home') }}">Master Data</a> · Contacts · Tyre Vendor</div>
                    <h1>Tyre Vendor Dashboard</h1>
                    <div class="cv2-sub">Overview of your tyre suppliers, supplied stock and compliance.</div>
                </div>
                <div class="cv2-phead-actions">
                    <a href="{{ route('contact.v2.tyrevendor.index') }}" class="cv2-btn cv2-btn-ghost"><i class="bi bi-list-ul"></i>View All</a>
                    <a href="{{ route('contact.v2.tyrevendor.create') }}" class="cv2-btn cv2-btn-primary"><i class="bi bi-plus-lg"></i>Add Tyre Vendor</a>
                </div>
            </div>

            <div class="cv2-kpis">
                <div class="cv2-kpi">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic"><i class="bi bi-shop"></i></span></div>
                    <div class="cv2-kpi-val">{{ $kpi['total'] }}</div><div class="cv2-kpi-lbl">Total Vendors</div>
                </div>
                <div class="cv2-kpi">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic is-ok"><i class="bi bi-check2-circle"></i></span></div>
                    <div class="cv2-kpi-val">{{ $kpi['active'] }}</div><div class="cv2-kpi-lbl">Active</div>
                </div>
                <div class="cv2-kpi">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic is-slate"><i class="bi bi-pause-circle"></i></span></div>
                    <div class="cv2-kpi-val">{{ $kpi['inactive'] }}</div><div class="cv2-kpi-lbl">Inactive</div>
                </div>
                <div class="cv2-kpi">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic is-bad"><i class="bi bi-slash-circle"></i></span></div>
                    <div class="cv2-kpi-val">{{ $kpi['blacklisted'] }}</div><div class="cv2-kpi-lbl">Blacklisted</div>
                </div>
                <div class="cv2-kpi">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic"><i class="bi bi-record-circle"></i></span></div>
                    <div class="cv2-kpi-val">{{ $kpi['tyresSupplied'] }}</div><div class="cv2-kpi-lbl">Tyres Supplied</div>
                </div>
                <div class="cv2-kpi">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic is-warn"><i class="bi bi-receipt"></i></span></div>
                    <div class="cv2-kpi-val">{{ $kpi['tdsDue'] }}</div><div class="cv2-kpi-lbl">TDS Declaration Due</div>
                </div>
            </div>

            <div class="cv2-grid cv2-grid-2-1 cv2-mt">
                <div class="cv2-card">
                    <div class="cv2-card-h"><h3>Recent Tyre Vendors</h3><a class="cv2-link" href="{{ route('contact.v2.tyrevendor.index') }}">View all →</a></div>
                    <div class="cv2-card-b is-flush">
                        <table class="cv2-table">
                            <thead><tr><th>Vendor</th><th>Contact</th><th>City</th><th>Tyres</th><th>Status</th><th></th></tr></thead>
                            <tbody>
                                @forelse($vendors as $v)
                                <tr>
                                    <td>
                                        <div style="display:flex;align-items:center;gap:11px;">
                                            <span class="cv2-avatar" style="width:36px;height:36px;font-size:13px;border-radius:10px;">{{ strtoupper(mb_substr($v['company'],0,1)) }}</span>
                                            <div><span class="cv2-t-name">{{ $v['company'] }}</span><div class="cv2-t-sub">{{ $v['contactno'] }}</div></div>
                                        </div>
                                    </td>
                                    <td>{{ $v['name'] }}</td>
                                    <td>{{ $v['city'] }}</td>
                                    <td class="cv2-t-mono">{{ $v['tyres'] }}</td>
                                    <td>
                                        @php $sc=['Active'=>'is-active','Inactive'=>'is-inactive','Blacklisted'=>'is-black'][$v['status']]??'is-inactive'; @endphp
                                        <span class="cv2-badge {{ $sc }}"><span class="cv2-badge-dot"></span>{{ $v['status'] }}</span>
                                    </td>
                                    <td class="cv2-actions"><a href="{{ route('contact.v2.tyrevendor.show', $v['id']) }}" class="cv2-ic-btn" title="Open"><i class="bi bi-arrow-right"></i></a></td>
                                </tr>
                                @empty
                                <tr><td colspan="6"><div class="cv2-empty"><i class="bi bi-shop"></i><h4>No tyre vendors yet</h4><p>Add your first tyre vendor to get started.</p></div></td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div>
                    <div class="cv2-card">
                        <div class="cv2-card-h"><h3>Quick Actions</h3></div>
                        <div class="cv2-card-b" style="display:flex;flex-direction:column;gap:10px;">
                            <a href="{{ route('contact.v2.tyrevendor.create') }}" class="cv2-btn cv2-btn-primary" style="justify-content:flex-start;"><i class="bi bi-person-plus"></i>New Tyre Vendor</a>
                            <a href="{{ route('contact.v2.tyrevendor.index') }}" class="cv2-btn cv2-btn-ghost" style="justify-content:flex-start;"><i class="bi bi-search"></i>Find a Vendor</a>
                        </div>
                    </div>
                    <div class="cv2-card cv2-mt">
                        <div class="cv2-card-h"><h3>Compliance</h3></div>
                        <div class="cv2-card-b">
                            <ul class="cv2-mini">
                                <li><span class="cv2-mini-ic is-warn"><i class="bi bi-receipt"></i></span><div class="cv2-mini-body"><b>TDS Declaration due</b><span>{{ $kpi['tdsDue'] }} vendor(s) at TDS % 0 or 1</span></div></li>
                                <li><span class="cv2-mini-ic"><i class="bi bi-record-circle"></i></span><div class="cv2-mini-body"><b>Tyres supplied</b><span>{{ $kpi['tyresSupplied'] }} across all vendors</span></div></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
@section('js')<script src="{{ asset('js/V2/tyrevendor.js?v=2.0') }}"></script>@endsection
