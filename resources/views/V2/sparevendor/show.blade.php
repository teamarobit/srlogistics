@extends('layouts.app')

@section('css')
<link href="{{ asset('css/V2/customer.css?v=1.3') }}" rel="stylesheet">
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
                                <tr><td class="cv2-t-name">State Bank of India</td><td class="cv2-t-mono">3021456789012</td><td class="cv2-t-mono">SBIN0001234</td><td><span class="cv2-badge is-active"><span class="cv2-badge-dot"></span>Primary</span></td></tr>
                                <tr><td class="cv2-t-name">HDFC Bank</td><td class="cv2-t-mono">5010019988776</td><td class="cv2-t-mono">HDFC0000456</td><td><span class="cv2-pill">—</span></td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="cv2-card">
                    <div class="cv2-card-h"><h3>Recent Activity</h3><a class="cv2-link" href="{{ route('contact.v2.sparevendor.activity', $v['id']) }}">View all →</a></div>
                    <div class="cv2-card-b">
                        <ul class="cv2-mini">
                            <li><span class="cv2-mini-ic"><i class="bi bi-gear-wide-connected"></i></span><div class="cv2-mini-body"><b>3 spare parts added to catalogue</b><span>by Superadmin · 2 days ago</span></div></li>
                            <li><span class="cv2-mini-ic"><i class="bi bi-paperclip"></i></span><div class="cv2-mini-body"><b>TDS Declaration uploaded</b><span>by Superadmin · 4 days ago</span></div></li>
                            <li><span class="cv2-mini-ic"><i class="bi bi-bank"></i></span><div class="cv2-mini-body"><b>HDFC bank account added</b><span>by Accounts · 1 week ago</span></div></li>
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
                            <tr><td class="cv2-t-name">Oil Filter — Element</td><td><span class="cv2-pill">Filters</span></td><td class="cv2-t-mono">OF-2290</td><td class="cv2-t-mono">₹340</td><td><span class="cv2-badge is-active"><span class="cv2-badge-dot"></span>Available</span></td></tr>
                            <tr><td class="cv2-t-name">Brake Pad Set (Front)</td><td><span class="cv2-pill">Brake System</span></td><td class="cv2-t-mono">BP-1180</td><td class="cv2-t-mono">₹1,250</td><td><span class="cv2-badge is-active"><span class="cv2-badge-dot"></span>Available</span></td></tr>
                            <tr><td class="cv2-t-name">Clutch Plate</td><td><span class="cv2-pill">Transmission</span></td><td class="cv2-t-mono">CP-4471</td><td class="cv2-t-mono">₹2,890</td><td><span class="cv2-badge is-inactive"><span class="cv2-badge-dot"></span>On Order</span></td></tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
