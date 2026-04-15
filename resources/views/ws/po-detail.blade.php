@extends('layouts.app')

@section('css')
<link href="{{ asset('css/Workshop/po-detail.css?v=1.0') }}" rel="stylesheet">
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
                    <li class="breadcrumb-item"><a href="{{ route('inventory.purchase-orders') }}">Purchase Orders</a></li>
                    <li class="breadcrumb-item active">{{ $id }}</li>
                </ol>
            </nav>

            {{-- Page Header --}}
            <div class="sc-page-head d-flex align-items-center justify-content-between mb-3">
                <div class="d-flex align-items-center gap-3">
                    <a href="{{ route('inventory.purchase-orders') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="uil uil-arrow-left me-1"></i>Back
                    </a>
                    <div>
                        <h5 class="mb-0">{{ $id }}</h5>
                        <span class="text-muted" style="font-size:12px;">Purchase Order Detail</span>
                    </div>
                    <span class="badge sc-po-ordered" style="font-size:12px;">Ordered</span>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-secondary btn-sm"><i class="uil uil-print me-1"></i>Print PO</button>
                    <a href="{{ route('inventory.goods-receipt') }}" class="btn sc-btn-navy btn-sm"><i class="uil uil-file-check-alt me-1"></i>Create GRN</a>
                </div>
            </div>

            <div class="row g-3 mb-3">

                {{-- PO Header Card --}}
                <div class="col-lg-8">
                    <div class="sc-card h-100">
                        <div class="sc-card-head"><span class="sc-card-title">PO Information</span></div>
                        <div class="p-3">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="sc-form-label text-muted">PO Number</div>
                                    <div class="fw-bold" style="font-size:15px;color:#032671;">{{ $id }}</div>
                                </div>
                                <div class="col-md-4">
                                    <div class="sc-form-label text-muted">Vendor</div>
                                    <div class="fw-semibold">Bosch Auto Parts</div>
                                    <small class="text-muted">Mumbai</small>
                                </div>
                                <div class="col-md-4">
                                    <div class="sc-form-label text-muted">Deliver To</div>
                                    <span class="loc-badge loc-badge-wh"><i class="uil uil-warehouse"></i> WH-BLR — Warehouse Bangalore</span>
                                </div>
                                <div class="col-md-4">
                                    <div class="sc-form-label text-muted">PO Date</div>
                                    <div>08-Apr-2026</div>
                                </div>
                                <div class="col-md-4">
                                    <div class="sc-form-label text-muted">Expected Delivery</div>
                                    <div>15-Apr-2026</div>
                                </div>
                                <div class="col-md-4">
                                    <div class="sc-form-label text-muted">Raised By</div>
                                    <div>SC Manager</div>
                                </div>
                                <div class="col-12">
                                    <div class="sc-form-label text-muted">Notes / Instructions</div>
                                    <div class="text-muted" style="font-size:12px;">Please ensure all items are bubble-wrapped. Include test certificate for brake pads batch.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- PO Summary Card --}}
                <div class="col-lg-4">
                    <div class="sc-card h-100">
                        <div class="sc-card-head"><span class="sc-card-title">Order Summary</span></div>
                        <div class="p-3">
                            <div class="d-flex justify-content-between mb-2" style="font-size:13px;">
                                <span class="text-muted">Items</span>
                                <span class="fw-semibold">3 line items</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2" style="font-size:13px;">
                                <span class="text-muted">Subtotal</span>
                                <span class="fw-semibold">₹ 18,400.00</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2" style="font-size:13px;">
                                <span class="text-muted">GST (18%)</span>
                                <span class="fw-semibold">₹ 3,312.00</span>
                            </div>
                            <div class="border-top pt-2 d-flex justify-content-between" style="font-size:14px;">
                                <span class="fw-bold">PO Total</span>
                                <span class="fw-bold text-navy">₹ 21,712.00</span>
                            </div>
                            <div class="mt-3 pt-2 border-top">
                                <div class="d-flex justify-content-between mb-1" style="font-size:12px;">
                                    <span class="text-muted">Received (GRNs)</span>
                                    <span class="text-success fw-semibold">₹ 0.00</span>
                                </div>
                                <div class="d-flex justify-content-between" style="font-size:12px;">
                                    <span class="text-muted">Balance Pending</span>
                                    <span class="text-warning fw-semibold">₹ 21,712.00</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Approval Timeline --}}
            <div class="sc-card mb-3">
                <div class="sc-card-head"><span class="sc-card-title">Approval &amp; Order Status</span></div>
                <div class="p-3">
                    <div class="po-timeline">
                        <div class="po-tl-step done">
                            <div class="po-tl-dot"></div>
                            <div class="po-tl-label">Draft</div>
                            <div class="po-tl-date text-muted">08-Apr-2026</div>
                        </div>
                        <div class="po-tl-line done"></div>
                        <div class="po-tl-step done">
                            <div class="po-tl-dot"></div>
                            <div class="po-tl-label">Approved</div>
                            <div class="po-tl-date text-muted">08-Apr-2026</div>
                        </div>
                        <div class="po-tl-line done"></div>
                        <div class="po-tl-step active">
                            <div class="po-tl-dot"></div>
                            <div class="po-tl-label">Ordered</div>
                            <div class="po-tl-date text-muted">08-Apr-2026</div>
                        </div>
                        <div class="po-tl-line"></div>
                        <div class="po-tl-step">
                            <div class="po-tl-dot"></div>
                            <div class="po-tl-label">Partially Received</div>
                            <div class="po-tl-date text-muted">—</div>
                        </div>
                        <div class="po-tl-line"></div>
                        <div class="po-tl-step">
                            <div class="po-tl-dot"></div>
                            <div class="po-tl-label">Fully Received</div>
                            <div class="po-tl-date text-muted">—</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Items Table --}}
            <div class="sc-card mb-3">
                <div class="sc-card-head"><span class="sc-card-title">Line Items</span></div>
                <div class="table-responsive">
                    <table class="table sc-table mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Category</th>
                                <th>Item</th>
                                <th>Brand</th>
                                <th class="text-end">Qty</th>
                                <th>Unit</th>
                                <th class="text-end">Rate (₹)</th>
                                <th class="text-end">Amount (₹)</th>
                                <th class="text-end">Rcvd Qty</th>
                                <th>Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-muted">1</td>
                                <td><span class="sc-cat-badge sc-cat-brake">Spare Part</span></td>
                                <td class="fw-semibold">Brake Pads (Front) — Tata Prima</td>
                                <td>Bosch</td>
                                <td class="text-end">5</td>
                                <td>set</td>
                                <td class="text-end">₹ 1,200</td>
                                <td class="text-end fw-semibold">₹ 6,000</td>
                                <td class="text-end text-muted">0</td>
                                <td><span class="badge bg-warning text-dark" style="font-size:10px;">5 set pending</span></td>
                            </tr>
                            <tr>
                                <td class="text-muted">2</td>
                                <td><span class="sc-cat-badge sc-cat-filter">Spare Part</span></td>
                                <td class="fw-semibold">Oil Filter — Tata Prima 4928</td>
                                <td>Bosch</td>
                                <td class="text-end">10</td>
                                <td>pcs</td>
                                <td class="text-end">₹ 220</td>
                                <td class="text-end fw-semibold">₹ 2,200</td>
                                <td class="text-end text-muted">0</td>
                                <td><span class="badge bg-warning text-dark" style="font-size:10px;">10 pcs pending</span></td>
                            </tr>
                            <tr>
                                <td class="text-muted">3</td>
                                <td><span class="sc-cat-badge">Consumable</span></td>
                                <td class="fw-semibold">Engine Oil 20W-50</td>
                                <td>Castrol</td>
                                <td class="text-end">30</td>
                                <td>ltr</td>
                                <td class="text-end">₹ 340</td>
                                <td class="text-end fw-semibold">₹ 10,200</td>
                                <td class="text-end text-muted">0</td>
                                <td><span class="badge bg-warning text-dark" style="font-size:10px;">30 ltr pending</span></td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr class="table-light">
                                <td colspan="7" class="text-end fw-bold">Subtotal</td>
                                <td class="text-end fw-bold">₹ 18,400</td>
                                <td colspan="2"></td>
                            </tr>
                            <tr class="table-light">
                                <td colspan="7" class="text-end text-muted">GST (18%)</td>
                                <td class="text-end text-muted">₹ 3,312</td>
                                <td colspan="2"></td>
                            </tr>
                            <tr class="table-light">
                                <td colspan="7" class="text-end fw-bold" style="font-size:14px;">Total</td>
                                <td class="text-end fw-bold text-navy" style="font-size:14px;">₹ 21,712</td>
                                <td colspan="2"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            {{-- GRN History --}}
            <div class="sc-card mb-3">
                <div class="sc-card-head d-flex align-items-center justify-content-between">
                    <span class="sc-card-title">Goods Receipt History</span>
                    <a href="{{ route('inventory.goods-receipt') }}" class="btn sc-btn-navy btn-sm"><i class="uil uil-plus me-1"></i>New GRN Against This PO</a>
                </div>
                <div class="p-3">
                    <div class="text-center text-muted py-4" style="font-size:13px;">
                        <i class="uil uil-box" style="font-size:28px;opacity:.4;display:block;margin-bottom:6px;"></i>
                        No goods received yet against this PO.
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

