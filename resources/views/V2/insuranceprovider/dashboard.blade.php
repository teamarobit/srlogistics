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
                    <div class="cv2-crumb"><a href="{{ route('home') }}">Master Data</a> · Contacts · Insurance Vendor</div>
                    <h1>Insurance Vendor Dashboard</h1>
                    <div class="cv2-sub">Overview of your insurance companies, contacts and GST status.</div>
                </div>
                <div class="cv2-phead-actions">
                    <a href="{{ route('contact.v2.insuranceprovider.index') }}" class="cv2-btn cv2-btn-ghost"><i class="bi bi-list-ul"></i>View All</a>
                    <a href="{{ route('contact.v2.insuranceprovider.index') }}" class="cv2-btn cv2-btn-primary"><i class="bi bi-plus-lg"></i>Add Insurance Vendor</a>
                </div>
            </div>

            {{-- KPI row --}}
            <div class="cv2-kpis">
                <div class="cv2-kpi">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic"><i class="bi bi-shield-check"></i></span><span class="cv2-kpi-trend cv2-up">+3%</span></div>
                    <div class="cv2-kpi-val">{{ $stats['total'] }}</div><div class="cv2-kpi-lbl">Total Vendors</div>
                </div>
                <div class="cv2-kpi">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic is-ok"><i class="bi bi-check2-circle"></i></span><span class="cv2-kpi-trend cv2-up">+2</span></div>
                    <div class="cv2-kpi-val">{{ $stats['active'] }}</div><div class="cv2-kpi-lbl">Active</div>
                </div>
                <div class="cv2-kpi">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic is-slate"><i class="bi bi-pause-circle"></i></span><span class="cv2-kpi-trend cv2-flat">0</span></div>
                    <div class="cv2-kpi-val">{{ $stats['inactive'] }}</div><div class="cv2-kpi-lbl">Inactive</div>
                </div>
                <div class="cv2-kpi">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic is-bad"><i class="bi bi-slash-circle"></i></span><span class="cv2-kpi-trend cv2-down">0</span></div>
                    <div class="cv2-kpi-val">{{ $stats['blacklisted'] }}</div><div class="cv2-kpi-lbl">Blacklisted</div>
                </div>
                <div class="cv2-kpi">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic"><i class="bi bi-receipt"></i></span><span class="cv2-kpi-trend cv2-up">+4</span></div>
                    <div class="cv2-kpi-val">{{ $stats['gst'] }}</div><div class="cv2-kpi-lbl">GST Registered</div>
                </div>
                <div class="cv2-kpi">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic"><i class="bi bi-geo-alt"></i></span><span class="cv2-kpi-trend cv2-flat">0</span></div>
                    <div class="cv2-kpi-val">{{ $stats['cities'] }}</div><div class="cv2-kpi-lbl">States Covered</div>
                </div>
            </div>

            {{-- Recent + side --}}
            <div class="cv2-grid cv2-grid-2-1 cv2-mt">
                <div class="cv2-card">
                    <div class="cv2-card-h"><h3>Recent Insurance Vendors</h3><a class="cv2-link" href="{{ route('contact.v2.insuranceprovider.index') }}">View all →</a></div>
                    <div class="cv2-card-b is-flush">
                        <table class="cv2-table">
                            <thead><tr><th>Company</th><th>Contact</th><th>State</th><th>GST Number</th><th>Status</th><th></th></tr></thead>
                            <tbody>
                                @forelse($providers as $p)
                                <tr>
                                    <td>
                                        <div style="display:flex;align-items:center;gap:11px;">
                                            @if($p->contact_image)
                                                <img src="{{ asset('media/contact/'.$p->contact_image) }}" alt="logo" class="cv2-avatar" style="width:36px;height:36px;border-radius:10px;object-fit:cover;">
                                            @else
                                                <span class="cv2-avatar" style="width:36px;height:36px;font-size:13px;border-radius:10px;">{{ strtoupper(mb_substr($p->company_name ?? '?',0,1)) }}</span>
                                            @endif
                                            <div><span class="cv2-t-name">{{ $p->company_name }}</span><div class="cv2-t-sub">{{ $p->contactno }}</div></div>
                                        </div>
                                    </td>
                                    <td>{{ $p->contact_name }}<div class="cv2-t-sub">{{ trim(($p->ph_prefix ? $p->ph_prefix.' ' : '').$p->phone) }}</div></td>
                                    <td>{{ $p->state?->name ?? '—' }}</td>
                                    <td class="cv2-t-mono">{{ $p->gst_number ?: '—' }}</td>
                                    <td>
                                        @php $sc=['Active'=>'is-active','Inactive'=>'is-inactive','Blacklisted'=>'is-black'][$p->status]??'is-inactive'; @endphp
                                        <span class="cv2-badge {{ $sc }}"><span class="cv2-badge-dot"></span>{{ $p->status }}</span>
                                    </td>
                                    <td class="cv2-actions"><a href="{{ route('contact.v2.insuranceprovider.index') }}" class="cv2-ic-btn" title="Open"><i class="bi bi-arrow-right"></i></a></td>
                                </tr>
                                @empty
                                <tr><td colspan="6" style="text-align:center;padding:24px;color:#94a3b8;">No insurance vendors yet.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div>
                    <div class="cv2-card">
                        <div class="cv2-card-h"><h3>Quick Actions</h3></div>
                        <div class="cv2-card-b" style="display:flex;flex-direction:column;gap:10px;">
                            <a href="{{ route('contact.v2.insuranceprovider.index') }}" class="cv2-btn cv2-btn-primary" style="justify-content:flex-start;"><i class="bi bi-plus-circle"></i>New Insurance Vendor</a>
                            <a href="{{ route('contact.v2.insuranceprovider.index') }}" class="cv2-btn cv2-btn-ghost" style="justify-content:flex-start;"><i class="bi bi-search"></i>Find a Vendor</a>
                        </div>
                    </div>
                    <div class="cv2-card cv2-mt">
                        <div class="cv2-card-h"><h3>By Status</h3></div>
                        <div class="cv2-card-b">
                            <ul class="cv2-mini">
                                <li><span class="cv2-mini-ic"><i class="bi bi-circle-fill"></i></span><div class="cv2-mini-body"><b>Active</b><span>{{ $stats['active'] }} vendors</span></div><span class="cv2-t-mono">89%</span></li>
                                <li><span class="cv2-mini-ic"><i class="bi bi-circle-fill"></i></span><div class="cv2-mini-body"><b>Inactive</b><span>{{ $stats['inactive'] }} vendors</span></div><span class="cv2-t-mono">8%</span></li>
                                <li><span class="cv2-mini-ic"><i class="bi bi-circle-fill"></i></span><div class="cv2-mini-body"><b>Blacklisted</b><span>{{ $stats['blacklisted'] }} vendors</span></div><span class="cv2-t-mono">3%</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('js/V2/insuranceprovider.js?v=1.0') }}"></script>
@endsection
