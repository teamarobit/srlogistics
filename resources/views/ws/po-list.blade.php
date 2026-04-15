@extends('layouts.app')

@section('css')
<link href="{{ asset('css/Workshop/po-list.css?v=1.0') }}" rel="stylesheet">
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
                    <li class="breadcrumb-item active">Purchase Orders</li>
                </ol>
            </nav>

            {{-- Location Context Bar --}}
            <div class="loc-ctx-bar">
                <div class="loc-ctx-left">
                    <i class="uil uil-map-marker loc-ctx-icon"></i>
                    <span class="loc-ctx-label">Deliver To:</span>
                    <select class="loc-ctx-select">
                        <option value="">All Locations</option>
                        <optgroup label="Warehouses">
                            <option>WH-BLR — Warehouse Bangalore</option>
                            <option>WH-HYD — Warehouse Hyderabad</option>
                            <option>WH-PNE — Warehouse Pune</option>
                        </optgroup>
                        <optgroup label="Workshops">
                            <option>WS-HYD — SC Bangalore</option>
                            <option>WS-HYD — SC Hyderabad</option>
                        </optgroup>
                    </select>
                </div>
                <div style="font-size:11px;color:#adb5bd;">POs are raised for a specific delivery location</div>
            </div>

            <div class="sc-page-head d-flex align-items-center justify-content-between mb-3">
                <div>
                    <h5 class="mb-0">Purchase Orders</h5>
                    <span class="text-muted" style="font-size:12px;">Raise and track procurement across warehouses and service centres</span>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-secondary btn-sm"><i class="uil uil-export me-1"></i>Export</button>
                    <button class="btn sc-btn-navy btn-sm" data-bs-toggle="modal" data-bs-target="#newPOModal">
                        <i class="uil uil-plus me-1"></i> New PO
                    </button>
                </div>
            </div>

            {{-- Summary --}}
            <div class="row g-3 mb-3">
                <div class="col-lg-3 col-md-6">
                    <div class="sc-stat-card sc-stat-navy">
                        <div class="sc-stat-icon"><i class="uil uil-file-alt"></i></div>
                        <div class="sc-stat-body"><div class="sc-stat-val">7</div><div class="sc-stat-label">Open POs</div></div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="sc-stat-card sc-stat-amber">
                        <div class="sc-stat-icon"><i class="uil uil-clock"></i></div>
                        <div class="sc-stat-body"><div class="sc-stat-val">3</div><div class="sc-stat-label">Pending Approval</div></div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="sc-stat-card sc-stat-green">
                        <div class="sc-stat-icon"><i class="uil uil-check-circle"></i></div>
                        <div class="sc-stat-body"><div class="sc-stat-val">₹ 82,400</div><div class="sc-stat-label">PO Value This Month</div></div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="sc-stat-card sc-stat-grey">
                        <div class="sc-stat-icon"><i class="uil uil-truck"></i></div>
                        <div class="sc-stat-body"><div class="sc-stat-val">2</div><div class="sc-stat-label">Awaiting Delivery</div></div>
                    </div>
                </div>
            </div>

            {{-- Filters --}}
            <div class="sc-card mb-3">
                <div class="row g-2 align-items-end">
                    <div class="col-lg-2 col-md-4">
                        <label class="sc-form-label">Status</label>
                        <select class="form-select form-select-sm">
                            <option>All</option><option>Draft</option><option>Pending Approval</option>
                            <option>Approved</option><option>Ordered</option><option>Received</option><option>Cancelled</option>
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-4">
                        <label class="sc-form-label">From Date</label>
                        <input type="date" class="form-control form-control-sm">
                    </div>
                    <div class="col-lg-2 col-md-4">
                        <label class="sc-form-label">To Date</label>
                        <input type="date" class="form-control form-control-sm">
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <label class="sc-form-label">Search</label>
                        <input type="text" class="form-control form-control-sm" placeholder="PO number or vendor name…">
                    </div>
                    <div class="col-lg-2 d-flex align-items-end">
                        <button class="btn btn-outline-secondary btn-sm w-100"><i class="uil uil-times me-1"></i>Clear</button>
                    </div>
                </div>
            </div>

            {{-- PO Table --}}
            <div class="sc-table-card">
                <div class="table-responsive">
                    <table class="table sc-table mb-0">
                        <thead>
                            <tr>
                                <th>PO Number</th>
                                <th>Vendor</th>
                                <th>Deliver To</th>
                                <th>Items</th>
                                <th>PO Date</th>
                                <th>Expected Delivery</th>
                                <th class="text-end">PO Value (₹)</th>
                                <th>Raised By</th>
                                <th>Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><a href="{{ route('inventory.po-detail', 'PO-2026-0018') }}" class="fw-semibold sc-doc-link">PO-2026-0018</a></td>
                                <td>
                                    <div style="font-size:13px;">Bosch Auto Parts</div>
                                    <small class="text-muted">Mumbai</small>
                                </td>
                                <td><span class="loc-badge loc-badge-wh"><i class="uil uil-warehouse"></i> WH-BLR</span></td>
                                <td><span class="sc-cat-badge">3 items</span></td>
                                <td class="text-nowrap">08-Apr-2026</td>
                                <td class="text-nowrap">15-Apr-2026</td>
                                <td class="text-end fw-bold text-navy">₹ 18,400</td>
                                <td>SC Manager</td>
                                <td><span class="badge sc-po-ordered">Ordered</span></td>
                                <td class="text-center">
                                    <div class="sc-row-actions">
                                        <button class="sc-action-btn" title="View PO"><i class="uil uil-eye"></i></button>
                                        <button class="sc-action-btn" title="Print PO"><i class="uil uil-print"></i></button>
                                        <a href="{{ route('inventory.goods-receipt') }}" class="sc-action-btn" title="Create GRN"><i class="uil uil-file-check-alt"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><a href="{{ route('inventory.po-detail', 'PO-2026-0017') }}" class="fw-semibold sc-doc-link">PO-2026-0017</a></td>
                                <td>
                                    <div style="font-size:13px;">Castrol Lubricants</div>
                                    <small class="text-muted">Pune</small>
                                </td>
                                <td><span class="loc-badge loc-badge-sc"><i class="uil uil-wrench"></i> WS-HYD</span></td>
                                <td><span class="sc-cat-badge">1 item</span></td>
                                <td class="text-nowrap">05-Apr-2026</td>
                                <td class="text-nowrap">10-Apr-2026</td>
                                <td class="text-end fw-bold text-navy">₹ 8,400</td>
                                <td>SC Manager</td>
                                <td><span class="badge sc-po-received">Received</span></td>
                                <td class="text-center">
                                    <div class="sc-row-actions">
                                        <button class="sc-action-btn" title="View PO"><i class="uil uil-eye"></i></button>
                                        <button class="sc-action-btn" title="Print PO"><i class="uil uil-print"></i></button>
                                        <button class="sc-action-btn" title="View GRN"><i class="uil uil-file-check-alt"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><a href="{{ route('inventory.po-detail', 'PO-2026-0016') }}" class="fw-semibold sc-doc-link">PO-2026-0016</a></td>
                                <td>
                                    <div style="font-size:13px;">Tata Genuine Parts</div>
                                    <small class="text-muted">Jamshedpur</small>
                                </td>
                                <td><span class="loc-badge loc-badge-wh"><i class="uil uil-warehouse"></i> WH-HYD</span></td>
                                <td><span class="sc-cat-badge">5 items</span></td>
                                <td class="text-nowrap">03-Apr-2026</td>
                                <td class="text-nowrap">—</td>
                                <td class="text-end fw-bold text-navy">₹ 24,500</td>
                                <td>SC Manager</td>
                                <td><span class="badge sc-po-pending">Pending Approval</span></td>
                                <td class="text-center">
                                    <div class="sc-row-actions">
                                        <button class="sc-action-btn" title="View PO"><i class="uil uil-eye"></i></button>
                                        <button class="sc-action-btn" title="Approve"><i class="uil uil-check-circle"></i></button>
                                        <button class="sc-action-btn sc-action-btn-danger" title="Cancel"><i class="uil uil-times-circle"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><a href="{{ route('inventory.po-detail', 'PO-2026-0015') }}" class="fw-semibold sc-doc-link">PO-2026-0015</a></td>
                                <td>
                                    <div style="font-size:13px;">Apollo Tyres</div>
                                    <small class="text-muted">Chennai</small>
                                </td>
                                <td><span class="loc-badge loc-badge-wh"><i class="uil uil-warehouse"></i> WH-BLR</span></td>
                                <td><span class="sc-cat-badge">4 items</span></td>
                                <td class="text-nowrap">01-Apr-2026</td>
                                <td class="text-nowrap">—</td>
                                <td class="text-end fw-bold text-muted">₹ 31,100</td>
                                <td>SC Manager</td>
                                <td><span class="badge sc-po-draft">Draft</span></td>
                                <td class="text-center">
                                    <div class="sc-row-actions">
                                        <button class="sc-action-btn" title="Edit PO"><i class="uil uil-pen"></i></button>
                                        <button class="sc-action-btn" title="Submit for Approval"><i class="uil uil-upload-alt"></i></button>
                                        <button class="sc-action-btn sc-action-btn-danger" title="Delete"><i class="uil uil-trash-alt"></i></button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="d-flex align-items-center justify-content-between px-3 py-2 border-top">
                    <small class="text-muted">Showing 4 of 18 purchase orders</small>
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

{{-- New PO Modal --}}
<div class="modal fade" id="newPOModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header"><h6 class="modal-title"><i class="uil uil-file-plus-alt me-2"></i>New Purchase Order</h6><button type="button" class="btn-close btn-sm" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6"><label class="sc-form-label">Vendor <span class="text-danger">*</span></label><select class="form-select form-select-sm select2-vendor"><option>Bosch Auto Parts</option><option>Castrol Lubricants</option><option>Tata Genuine Parts</option><option>Apollo Tyres</option></select></div>
                    <div class="col-md-6">
                        <label class="sc-form-label">Deliver To (Location) <span class="text-danger">*</span></label>
                        <select class="form-select form-select-sm">
                            <option value="">— Select Location —</option>
                            <optgroup label="Warehouses">
                                <option>WH-BLR — Warehouse Bangalore</option>
                                <option>WH-HYD — Warehouse Hyderabad</option>
                                <option>WH-PNE — Warehouse Pune</option>
                            </optgroup>
                            <optgroup label="Workshops">
                                <option>WS-HYD — SC Bangalore</option>
                                <option>WS-HYD — SC Hyderabad</option>
                            </optgroup>
                        </select>
                    </div>
                    <div class="col-md-6"><label class="sc-form-label">PO Date <span class="text-danger">*</span></label><input type="date" class="form-control form-control-sm"></div>
                    <div class="col-md-6"><label class="sc-form-label">Expected Delivery</label><input type="date" class="form-control form-control-sm"></div>
                    <div class="col-12"><label class="sc-form-label">Notes</label><textarea class="form-control form-control-sm" rows="2" placeholder="Additional instructions for vendor…"></textarea></div>

                    <div class="col-12">
                        <label class="sc-form-label">Items <span class="text-danger">*</span></label>
                        <table class="table sc-table table-sm mb-2" id="poItemsTable">
                            <thead><tr><th>Category</th><th>Item</th><th class="text-end" style="width:70px;">Qty</th><th style="width:70px;">Unit</th><th class="text-end" style="width:90px;">Rate (₹)</th><th class="text-end" style="width:90px;">Amount</th><th style="width:40px;"></th></tr></thead>
                            <tbody>
                                <tr>
                                    <td style="width:120px;"><select class="form-select form-select-sm po-cat"><option>Spare Part</option><option>Tyre</option><option>Battery</option><option>Consumable</option></select></td>
                                    <td><select class="form-select form-select-sm"><option>Engine Oil 20W-50 (Castrol)</option><option>Brake Pads Front (Bosch)</option><option>Oil Filter (Tata Genuine)</option><option>Apollo Tyre 10.00 R20</option><option>Amaron Battery 150AH</option></select></td>
                                    <td><input type="number" class="form-control form-control-sm text-end po-qty" min="1" value="30"></td>
                                    <td><select class="form-select form-select-sm"><option>ltr</option><option>pcs</option><option>set</option><option>nos</option></select></td>
                                    <td><input type="number" class="form-control form-control-sm text-end po-rate" min="0" step="0.01" value="280"></td>
                                    <td class="text-end fw-semibold po-amount" style="vertical-align:middle;">₹ 8,400</td>
                                    <td><button class="sc-action-btn sc-action-btn-danger btn-remove-row" title="Remove"><i class="uil uil-trash-alt"></i></button></td>
                                </tr>
                            </tbody>
                        </table>
                        <button class="btn btn-outline-secondary btn-sm" id="addPoRow"><i class="uil uil-plus me-1"></i>Add Item</button>
                    </div>
                    <div class="col-12 text-end">
                        <strong>PO Total: <span id="poTotal" class="text-navy">₹ 8,400.00</span></strong>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-outline-secondary btn-sm">Save as Draft</button>
                <button type="button" class="btn sc-btn-navy btn-sm">Submit for Approval</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
$(function() {
    $('.select2-vendor').select2({ width: '100%', dropdownParent: $('#newPOModal') });

    function recalcPO() {
        var total = 0;
        $('#poItemsTable tbody tr').each(function() {
            var qty = parseFloat($(this).find('.po-qty').val()) || 0;
            var rate = parseFloat($(this).find('.po-rate').val()) || 0;
            var amt = qty * rate;
            $(this).find('.po-amount').text('₹ ' + amt.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ','));
            total += amt;
        });
        $('#poTotal').text('₹ ' + total.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ','));
    }

    $(document).on('input', '.po-qty, .po-rate', recalcPO);

    $('#addPoRow').on('click', function() {
        var newRow = $('#poItemsTable tbody tr:first').clone();
        newRow.find('input').val('');
        newRow.find('.po-amount').text('₹ 0.00');
        $('#poItemsTable tbody').append(newRow);
    });

    $(document).on('click', '.btn-remove-row', function() {
        if ($('#poItemsTable tbody tr').length > 1) {
            $(this).closest('tr').remove();
            recalcPO();
        }
    });
});
</script>
@endsection
