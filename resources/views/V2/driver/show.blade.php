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
                <div class="cv2-crumb"><a href="{{ route('contact.v2.driver.index') }}">Drivers</a> · {{ $d['name'] }} · Overview</div>
            </div>

            @include('V2.driver.partials.workspace-head')

            <div class="cv2-kpis cv2-mt" style="grid-template-columns:repeat(6,1fr);">
                <a class="cv2-kpi" href="{{ route('contact.v2.driver.joining', $d['id']) }}" style="text-decoration:none;color:inherit;">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic"><i class="bi bi-box-arrow-in-right"></i></span></div>
                    <div class="cv2-kpi-val">{{ $counts['joining'] }}</div><div class="cv2-kpi-lbl">Joining</div>
                </a>
                <a class="cv2-kpi" href="{{ route('contact.v2.driver.documents', $d['id']) }}" style="text-decoration:none;color:inherit;">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic is-slate"><i class="bi bi-paperclip"></i></span></div>
                    <div class="cv2-kpi-val">{{ $counts['documents'] }}</div><div class="cv2-kpi-lbl">Documents</div>
                </a>
                <a class="cv2-kpi" href="{{ route('contact.v2.driver.assets', $d['id']) }}" style="text-decoration:none;color:inherit;">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic"><i class="bi bi-box-seam"></i></span></div>
                    <div class="cv2-kpi-val">{{ $counts['assets'] }}</div><div class="cv2-kpi-lbl">Assets</div>
                </a>
                <a class="cv2-kpi" href="{{ route('contact.v2.driver.bhatta', $d['id']) }}" style="text-decoration:none;color:inherit;">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic"><i class="bi bi-cash-coin"></i></span></div>
                    <div class="cv2-kpi-val">{{ $counts['bhatta'] }}</div><div class="cv2-kpi-lbl">Bhatta Entries</div>
                </a>
                <a class="cv2-kpi" href="{{ route('contact.v2.driver.exit', $d['id']) }}" style="text-decoration:none;color:inherit;">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic is-bad"><i class="bi bi-box-arrow-right"></i></span></div>
                    <div class="cv2-kpi-val">{{ $counts['exit'] }}</div><div class="cv2-kpi-lbl">Exit</div>
                </a>
                <a class="cv2-kpi" href="{{ route('contact.v2.driver.activity', $d['id']) }}" style="text-decoration:none;color:inherit;">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic is-slate"><i class="bi bi-clock-history"></i></span></div>
                    <div class="cv2-kpi-val">{{ $counts['activity'] }}</div><div class="cv2-kpi-lbl">Activities</div>
                </a>
            </div>

            <div class="cv2-grid cv2-grid-2 cv2-mt">
                <div class="cv2-card">
                    <div class="cv2-card-h"><h3>Driver Profile</h3><a class="cv2-link" href="{{ route('contact.v2.driver.edit', $d['id']) }}">Edit →</a></div>
                    <div class="cv2-card-b is-flush">
                        <table class="cv2-table">
                            <tbody>
                                <tr><td class="cv2-t-name">Category</td><td>{{ $d['category'] }}</td></tr>
                                <tr><td class="cv2-t-name">Date of Birth</td><td>{{ $d['dob'] }}</td></tr>
                                <tr><td class="cv2-t-name">Date of Joining</td><td>{{ $d['doj'] }}</td></tr>
                                <tr><td class="cv2-t-name">Blood Group</td><td>{{ $d['blood_group'] }}</td></tr>
                                <tr><td class="cv2-t-name">Driving Licence</td><td class="cv2-t-mono">{{ $d['licence_no'] }} · exp {{ $d['licence_expiry'] }}</td></tr>
                                <tr><td class="cv2-t-name">Aadhaar</td><td class="cv2-t-mono">{{ $d['aadhaar'] }}</td></tr>
                                <tr><td class="cv2-t-name">Hisab Category</td><td>{{ $d['hisab'] }}</td></tr>
                                <tr><td class="cv2-t-name">Primary Bank</td><td class="cv2-t-mono">{{ $d['bank'] }}</td></tr>
                                <tr><td class="cv2-t-name">Guarantor</td><td>{{ $d['guarantor'] }} · {{ $d['guarantor_phone'] }}</td></tr>
                                <tr><td class="cv2-t-name">Allocated Vehicle</td><td class="cv2-t-mono">{{ $d['vehicle'] }}</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="cv2-card">
                    <div class="cv2-card-h"><h3>Recent Activity</h3><a class="cv2-link" href="{{ route('contact.v2.driver.activity', $d['id']) }}">View all →</a></div>
                    <div class="cv2-card-b">
                        <ul class="cv2-mini">
                            <li><span class="cv2-mini-ic"><i class="bi bi-cash-coin"></i></span><div class="cv2-mini-body"><b>Bhatta ₹2,400 credited (Trip GHY→DBR)</b><span>Superadmin · 2 days ago</span></div></li>
                            <li><span class="cv2-mini-ic"><i class="bi bi-truck"></i></span><div class="cv2-mini-body"><b>Vehicle {{ $d['vehicle'] }} allocated</b><span>Operations · 1 week ago</span></div></li>
                            <li><span class="cv2-mini-ic"><i class="bi bi-box-seam"></i></span><div class="cv2-mini-body"><b>Asset issued: Smartphone</b><span>Superadmin · 2 weeks ago</span></div></li>
                            <li><span class="cv2-mini-ic"><i class="bi bi-box-arrow-in-right"></i></span><div class="cv2-mini-body"><b>Joining letter generated</b><span>Superadmin · {{ $d['doj'] }}</span></div></li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section('js')<script src="{{ asset('js/V2/driver.js?v=1.0') }}"></script>@endsection
