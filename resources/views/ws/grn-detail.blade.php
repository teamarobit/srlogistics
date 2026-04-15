@extends('layouts.app')

@section('css')
<link href="{{ asset('css/Workshop/grn-detail.css?v=1.0') }}" rel="stylesheet">
@endsection

@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="wrapper srlog-bdwrapper">
        <div class="main-wrap sc-no-sidebar">

            {{-- Breadcrumb --}}
            <nav aria-label="breadcrumb" class="mb-2">
                <ol class="breadcrumb sc-breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('inventory.dashboard') }}">Inventory</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('inventory.goods-receipt') }}">Goods Receipt</a></li>
                    <li class="breadcrumb-item active">{{ $id }}</li>
                </ol>
            </nav>

            {{-- Page Header --}}
            <div class="sc-page-head d-flex align-items-center justify-content-between mb-3">
                <div class="d-flex align-items-center gap-3">
                    <a href="{{ route('inventory.goods-receipt') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="uil uil-arrow-left me-1"></i>Back
                    </a>
                    <div>
                        <h5 class="mb-0">{{ $id }}</h5>
                        <span class="text-muted" style="font-size:12px;">Goods Receipt Note</span>
                    </div>
                    <span class="badge sc-grn-full" style="font-size:12px;">Full Receipt</span>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-secondary btn-sm"><i class="uil uil-print me-1"></i>Print GRN</button>
                </div>
            </div>

            <div class="row g-3 mb-3">

                {{-- GRN Header Card --}}
                <div class="col-lg-8">
                    <div class="sc-card h-100">
                        <div class="sc-card-head"><span class="sc-card-title">GRN Information</span></div>
                        <div class="p-3">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="sc-form-label text-muted">GRN Number</div>
                                    <div class="fw-bold" style="font-size:15px;color:#032671;">{{ $id }}</div>
                                </div>
                                <div class="col-md-4">
                                    <div class="sc-form-label text-muted">Against PO</div>
                                    <a href="{{ route('inventory.po-detail', 'PO-2026-0017') }}" class="sc-doc-link fw-semibold">PO-2026-0017</a>
                                    <div style="font-size:11px;color:#6c757d;">Castrol Lubricants</div>
                                </div>
                                <div class="col-md-4">
                                    <div class="sc-form-label text-muted">Received At</div>
                                    <span class="loc-badge loc-badge-sc"><i class="uil uil-wrench"></i> WS-HYD — Bangalore</span>
                                </div>
                                <div class="col-md-4">
                                    <div class="sc-form-label text-muted">Received Date</div>
                                    <div>10-Apr-2026</div>
                                </div>
                                <div class="col-md-4">
                                    <div class="sc-form-label text-muted">DC / Invoice No.</div>
                                    <div>DC-CAS-20260410-081</div>
                                </div>
                                <div class="col-md-4">
                                    <div class="sc-form-label text-muted">Received By</div>
                                    <div>SC Manager</div>
                                </div>
                                <div class="col-12">
                                    <div class="sc-form-label text-muted">Remarks</div>
                                    <div class="text-muted" style="font-size:12px;">All items received in good condition. Delivery made on schedule.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- GRN Summary Card --}}
                <div class="col-lg-4">
                    <div class="sc-card h-100">
                        <div class="sc-card-head"><span class="sc-card-title">Receipt Summary</span></div>
                        <div class="p-3">
                            <div class="d-flex justify-content-between mb-2" style="font-size:13px;">
                                <span class="text-muted">Items on PO</span>
                                <span class="fw-semibold">1 line item</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2" style="font-size:13px;">
                                <span class="text-muted">Items Received</span>
                                <span class="fw-semibold text-success">1 line item</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2" style="font-size:13px;">
                                <span class="text-muted">Receipt Status</span>
                                <span class="badge sc-grn-full">Full Receipt</span>
                            </div>
                            <div class="border-top pt-2 mt-1 d-flex justify-content-between" style="font-size:14px;">
                                <span class="fw-bold">Received Value</span>
                                <span class="fw-bold text-navy">₹ 8,400.00</span>
                            </div>
                            <div class="mt-3 pt-2 border-top">
                                <div class="sc-form-label text-muted mb-1">Stock Updated</div>
                                <div class="d-flex align-items-center gap-2">
                                    <i class="uil uil-check-circle text-success" style="font-size:16px;"></i>
                                    <span style="font-size:12px;">30 ltr added to <span class="loc-badge loc-badge-sc" style="font-size:10px;"><i class="uil uil-wrench"></i> WS-HYD</span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Items Received Table --}}
            <div class="sc-card mb-3">
                <div class="sc-card-head"><span class="sc-card-title">Items Received</span></div>
                <div class="table-responsive">
                    <table class="table sc-table mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Category</th>
                                <th>Item</th>
                                <th class="text-end">PO Qty</th>
                                <th class="text-end">Prev. Rcvd</th>
                                <th class="text-end">This GRN</th>
                                <th>Unit</th>
                                <th class="text-end">Unit Rate (₹)</th>
                                <th class="text-end">Line Value (₹)</th>
                                <th>Condition</th>
                                <th>Stock Location</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-muted">1</td>
                                <td><span class="sc-cat-badge">Consumable</span></td>
                                <td class="fw-semibold">Engine Oil 20W-50 (Castrol)</td>
                                <td class="text-end">30</td>
                                <td class="text-end text-muted">0</td>
                                <td class="text-end fw-semibold text-success">30</td>
                                <td>ltr</td>
                                <td class="text-end">₹ 280</td>
                                <td class="text-end fw-bold text-navy">₹ 8,400</td>
                                <td><span class="badge bg-success" style="font-size:10px;">Good</span></td>
                                <td><span class="loc-badge loc-badge-sc"><i class="uil uil-wrench"></i> WS-HYD</span></td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr class="table-light">
                                <td colspan="8" class="text-end fw-bold">Total Received Value</td>
                                <td class="text-end fw-bold text-navy">₹ 8,400</td>
                                <td colspan="2"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            {{-- Stock Impact --}}
            <div class="sc-card mb-3">
                <div class="sc-card-head"><span class="sc-card-title"><i class="uil uil-box me-2 text-navy"></i>Stock Impact</span></div>
                <div class="p-3">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="sc-card" style="border:1px solid #b8e3c3;background:#f4fbf6;">
                                <div class="p-3">
                                    <div class="d-flex align-items-start gap-2">
                                        <i class="uil uil-arrow-up-right text-success" style="font-size:20px;margin-top:1px;"></i>
                                        <div>
                                            <div class="fw-bold" style="font-size:13px;">Engine Oil 20W-50</div>
                                            <div style="font-size:11px;color:#10863f;">+30 ltr added to stock</div>
                                            <div class="mt-1">
                                                <span class="loc-badge loc-badge-sc"><i class="uil uil-wrench"></i> WS-HYD</span>
                                            </div>
                                            <div style="font-size:10px;color:#6c757d;margin-top:4px;">
                                                Previous: 18 ltr &nbsp;→&nbsp; <strong class="text-success">New: 48 ltr</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
