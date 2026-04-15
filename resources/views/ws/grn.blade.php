@extends('layouts.app')

@section('css')
<link href="{{ asset('css/Workshop/grn.css?v=1.0') }}" rel="stylesheet">
@endsection

@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="wrapper srlog-bdwrapper">
        <div class="main-wrap sc-no-sidebar">

            <nav aria-label="breadcrumb" class="mb-2">
                <ol class="breadcrumb sc-breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('inventory.dashboard') }}">Inventory</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('inventory.purchase-orders') }}">Purchase Orders</a></li>
                    <li class="breadcrumb-item active">Goods Receipt</li>
                </ol>
            </nav>

            <div class="sc-page-head d-flex align-items-center justify-content-between mb-3">
                <div>
                    <h5 class="mb-0">Goods Receipt (GRN)</h5>
                    <span class="text-muted" style="font-size:12px;">Receive and verify goods against purchase orders</span>
                </div>
                <button class="btn sc-btn-navy btn-sm" data-bs-toggle="modal" data-bs-target="#newGRNModal">
                    <i class="uil uil-plus me-1"></i> New GRN
                </button>
            </div>

            {{-- Summary --}}
            <div class="row g-3 mb-3">
                <div class="col-lg-3 col-md-6">
                    <div class="sc-stat-card sc-stat-navy">
                        <div class="sc-stat-icon"><i class="uil uil-box"></i></div>
                        <div class="sc-stat-body"><div class="sc-stat-val">14</div><div class="sc-stat-label">GRNs This Month</div></div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="sc-stat-card sc-stat-amber">
                        <div class="sc-stat-icon"><i class="uil uil-clock"></i></div>
                        <div class="sc-stat-body"><div class="sc-stat-val">2</div><div class="sc-stat-label">Partial Receipts</div></div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="sc-stat-card sc-stat-green">
                        <div class="sc-stat-icon"><i class="uil uil-check-circle"></i></div>
                        <div class="sc-stat-body"><div class="sc-stat-val">12</div><div class="sc-stat-label">Fully Received</div></div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="sc-stat-card sc-stat-grey">
                        <div class="sc-stat-icon"><i class="uil uil-rupee-sign"></i></div>
                        <div class="sc-stat-body"><div class="sc-stat-val">₹ 64,800</div><div class="sc-stat-label">Received Value</div></div>
                    </div>
                </div>
            </div>

            {{-- GRN Table --}}
            <div class="sc-table-card">
                <div class="sc-table-head d-flex align-items-center justify-content-between px-3 py-2 border-bottom">
                    <span class="fw-semibold" style="font-size:13px;">Goods Receipts</span>
                    <div class="d-flex gap-2">
                        <select class="form-select form-select-sm" style="width:130px;">
                            <option>All</option><option>Partial</option><option>Full</option>
                        </select>
                        <input type="text" class="form-control form-control-sm" placeholder="Search GRN or PO#…" style="width:200px;">
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table sc-table mb-0">
                        <thead>
                            <tr>
                                <th>GRN Number</th>
                                <th>PO Number</th>
                                <th>Vendor</th>
                                <th>Received Date</th>
                                <th>Items Ordered</th>
                                <th>Items Received</th>
                                <th class="text-end">Received Value (₹)</th>
                                <th>Received By</th>
                                <th>Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><a href="{{ route('inventory.grn-detail', 'GRN-2026-0014') }}" class="fw-semibold sc-doc-link">GRN-2026-0014</a></td>
                                <td><a href="{{ route('inventory.po-detail', 'PO-2026-0017') }}" class="sc-doc-link">PO-2026-0017</a></td>
                                <td>Castrol Lubricants</td>
                                <td class="text-nowrap">10-Apr-2026</td>
                                <td class="text-center">1 item / 30 ltr</td>
                                <td class="text-center">1 item / 30 ltr</td>
                                <td class="text-end fw-bold text-navy">₹ 8,400</td>
                                <td>SC Manager</td>
                                <td><span class="badge sc-grn-full">Full Receipt</span></td>
                                <td class="text-center">
                                    <div class="sc-row-actions">
                                        <a href="{{ route('inventory.grn-detail', 'GRN-2026-0014') }}" class="sc-action-btn" title="View GRN"><i class="uil uil-eye"></i></a>
                                        <button class="sc-action-btn" title="Print GRN"><i class="uil uil-print"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><a href="{{ route('inventory.grn-detail', 'GRN-2026-0013') }}" class="fw-semibold sc-doc-link">GRN-2026-0013</a></td>
                                <td><a href="{{ route('inventory.po-detail', 'PO-2026-0015') }}" class="sc-doc-link">PO-2026-0015</a></td>
                                <td>Apollo Tyres</td>
                                <td class="text-nowrap">08-Apr-2026</td>
                                <td class="text-center">4 items</td>
                                <td class="text-center text-warning fw-semibold">2 items</td>
                                <td class="text-end fw-bold text-navy">₹ 15,400</td>
                                <td>SC Manager</td>
                                <td><span class="badge sc-grn-partial">Partial Receipt</span></td>
                                <td class="text-center">
                                    <div class="sc-row-actions">
                                        <a href="{{ route('inventory.grn-detail', 'GRN-2026-0013') }}" class="sc-action-btn" title="View GRN"><i class="uil uil-eye"></i></a>
                                        <button class="sc-action-btn" title="Receive Remaining" data-bs-toggle="modal" data-bs-target="#newGRNModal"><i class="uil uil-plus"></i></button>
                                        <button class="sc-action-btn" title="Print GRN"><i class="uil uil-print"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><a href="{{ route('inventory.grn-detail', 'GRN-2026-0012') }}" class="fw-semibold sc-doc-link">GRN-2026-0012</a></td>
                                <td><a href="{{ route('inventory.po-detail', 'PO-2026-0014') }}" class="sc-doc-link">PO-2026-0014</a></td>
                                <td>Bosch Auto Parts</td>
                                <td class="text-nowrap">03-Apr-2026</td>
                                <td class="text-center">3 items</td>
                                <td class="text-center">3 items</td>
                                <td class="text-end fw-bold text-navy">₹ 18,400</td>
                                <td>SC Manager</td>
                                <td><span class="badge sc-grn-full">Full Receipt</span></td>
                                <td class="text-center">
                                    <div class="sc-row-actions">
                                        <a href="{{ route('inventory.grn-detail', 'GRN-2026-0012') }}" class="sc-action-btn" title="View GRN"><i class="uil uil-eye"></i></a>
                                        <button class="sc-action-btn" title="Print GRN"><i class="uil uil-print"></i></button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="d-flex align-items-center justify-content-between px-3 py-2 border-top">
                    <small class="text-muted">Showing 3 of 14 GRNs</small>
                    <nav><ul class="pagination pagination-sm mb-0">
                        <li class="page-item disabled"><a class="page-link" href="#">&laquo;</a></li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                    </ul></nav>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- New GRN Modal --}}
<div class="modal fade" id="newGRNModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header"><h6 class="modal-title"><i class="uil uil-box me-2"></i>Record Goods Receipt</h6><button type="button" class="btn-close btn-sm" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6"><label class="sc-form-label">Against PO <span class="text-danger">*</span></label><select class="form-select form-select-sm select2-po"><option>PO-2026-0018 — Bosch Auto Parts</option><option>PO-2026-0015 — Apollo Tyres (Partial)</option></select></div>
                    <div class="col-md-3"><label class="sc-form-label">Received Date <span class="text-danger">*</span></label><input type="date" class="form-control form-control-sm"></div>
                    <div class="col-md-3"><label class="sc-form-label">Invoice / DC Number</label><input type="text" class="form-control form-control-sm" placeholder="Delivery Challan #"></div>
                    <div class="col-12">
                        <label class="sc-form-label">Items Received <span class="text-danger">*</span></label>
                        <table class="table sc-table table-sm mb-0">
                            <thead><tr><th>Item</th><th class="text-center">PO Qty</th><th class="text-center">Prev. Rcvd</th><th class="text-center">Now Receiving</th><th>Unit</th><th>Condition</th></tr></thead>
                            <tbody>
                                <tr>
                                    <td style="font-size:12px;">Brake Pads Front (Bosch)</td>
                                    <td class="text-center">5 set</td>
                                    <td class="text-center text-muted">0</td>
                                    <td><input type="number" class="form-control form-control-sm text-center" min="0" max="5" value="5" style="width:70px;margin:auto;"></td>
                                    <td>set</td>
                                    <td><select class="form-select form-select-sm"><option>Good</option><option>Damaged</option></select></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-12"><label class="sc-form-label">Notes</label><textarea class="form-control form-control-sm" rows="2" placeholder="Any discrepancies or remarks…"></textarea></div>
                </div>
            </div>
            <div class="modal-footer"><button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button><button type="button" class="btn sc-btn-navy btn-sm">Save GRN</button></div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
$(function() {
    $('.select2-po').select2({ width: '100%', dropdownParent: $('#newGRNModal') });
});
</script>
@endsection
