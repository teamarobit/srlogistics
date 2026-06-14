@extends('layouts.app')
@section('css')<link href="{{ asset('css/V2/customer.css?v=1.3') }}" rel="stylesheet">@endsection
@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="cv2-wrap"><div class="cv2-container">
        <div class="cv2-phead"><div class="cv2-crumb"><a href="{{ route('contact.v2.customer.index') }}">Customers</a> · {{ $c['name'] }} · Contract</div></div>
        @include('V2.customer.partials.workspace-head')
        <div class="cv2-card cv2-mt">
            <div class="cv2-card-h"><h3>Contracts</h3>
                <a href="{{ route('contact.v2.customer.contract.create', $c['id']) }}" class="cv2-btn cv2-btn-primary cv2-btn-sm"><i class="bi bi-plus-lg"></i>Add Contract</a></div>
            <div class="cv2-card-b is-flush">
                <table class="cv2-table">
                    <thead><tr><th>Contract No</th><th>Type</th><th>Routes</th><th>Advance</th><th>Payment Within</th><th>Validity</th><th>Status</th><th style="text-align:right;">Actions</th></tr></thead>
                    <tbody>
                        <tr><td class="cv2-t-mono">CTR-2026-014</td><td><span class="cv2-pill">Monthly</span></td><td>3 routes</td><td class="cv2-t-mono">₹50,000</td><td>30 days</td><td>01 Apr 26 – 31 Mar 27</td><td><span class="cv2-badge is-active"><span class="cv2-badge-dot"></span>Active</span></td>
                            <td class="cv2-actions"><a href="javascript:void(0)" class="cv2-ic-btn"><i class="bi bi-pencil"></i></a><a href="{{ route('contact.v2.customer.ratechart', $c['id']) }}" class="cv2-ic-btn" title="Rate chart"><i class="bi bi-cash-stack"></i></a><a href="javascript:void(0)" class="cv2-ic-btn is-danger"><i class="bi bi-trash3"></i></a></td></tr>
                        <tr><td class="cv2-t-mono">CTR-2025-188</td><td><span class="cv2-pill">Lifetime</span></td><td>1 route</td><td class="cv2-t-mono">₹0</td><td>15 days</td><td>No expiry</td><td><span class="cv2-badge is-active"><span class="cv2-badge-dot"></span>Active</span></td>
                            <td class="cv2-actions"><a href="javascript:void(0)" class="cv2-ic-btn"><i class="bi bi-pencil"></i></a><a href="{{ route('contact.v2.customer.ratechart', $c['id']) }}" class="cv2-ic-btn" title="Rate chart"><i class="bi bi-cash-stack"></i></a><a href="javascript:void(0)" class="cv2-ic-btn is-danger"><i class="bi bi-trash3"></i></a></td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div></div>
</div>
@endsection
