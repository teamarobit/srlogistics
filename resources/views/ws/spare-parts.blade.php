@extends('layouts.app')

@section('css')
<link href="{{ asset('css/Workshop/spare-parts.css?v=1.0') }}" rel="stylesheet">
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
                    <li class="breadcrumb-item active">Spare Parts</li>
                </ol>
            </nav>

            {{-- Page Header --}}
            <div class="sc-page-head d-flex align-items-center justify-content-between mb-3">
                <div>
                    <h5 class="mb-0">Spare Parts Inventory</h5>
                    <span class="text-muted" style="font-size:12px;">Stock levels, consumption and reorder management</span>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#adjustStockModal">
                        <i class="uil uil-exchange me-1"></i> Adjust Stock
                    </button>
                    <button class="btn sc-btn-navy btn-sm" data-bs-toggle="modal" data-bs-target="#addItemModal">
                        <i class="uil uil-plus me-1"></i> Add Item
                    </button>
                </div>
            </div>

            {{-- Location Context Bar --}}
            <div class="loc-ctx-bar">
                <div class="loc-ctx-left">
                    <i class="uil uil-map-marker loc-ctx-icon"></i>
                    <span class="loc-ctx-label">Location:</span>
                    <select class="loc-ctx-select" id="spLocCtx">
                        <option value="">All Locations</option>
                        <optgroup label="Warehouses">
                            <option value="WH-BLR">WH-BLR — Warehouse Bangalore</option>
                            <option value="WH-HYD">WH-HYD — Warehouse Hyderabad</option>
                            <option value="WH-PNE">WH-PNE — Warehouse Pune</option>
                        </optgroup>
                        <optgroup label="Workshops">
                            <option value="WS-HYD">WS-HYD — SC Bangalore</option>
                            <option value="WS-HYD">WS-HYD — SC Hyderabad</option>
                        </optgroup>
                    </select>
                </div>
                <div style="font-size:11px;color:#adb5bd;">Showing all locations · Switch to filter stock by location</div>
            </div>

            {{-- Summary Cards --}}
            <div class="row g-3 mb-3">
                <div class="col-lg-3 col-md-6">
                    <div class="sc-stat-card sc-stat-navy">
                        <div class="sc-stat-icon"><i class="uil uil-box"></i></div>
                        <div class="sc-stat-body"><div class="sc-stat-val">142</div><div class="sc-stat-label">Total Part Types</div></div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="sc-stat-card sc-stat-amber">
                        <div class="sc-stat-icon"><i class="uil uil-exclamation-triangle"></i></div>
                        <div class="sc-stat-body"><div class="sc-stat-val">12</div><div class="sc-stat-label">Low Stock Alerts</div></div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="sc-stat-card sc-stat-red">
                        <div class="sc-stat-icon"><i class="uil uil-times-circle"></i></div>
                        <div class="sc-stat-body"><div class="sc-stat-val">3</div><div class="sc-stat-label">Out of Stock</div></div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="sc-stat-card sc-stat-green">
                        <div class="sc-stat-icon"><i class="uil uil-rupee-sign"></i></div>
                        <div class="sc-stat-body"><div class="sc-stat-val">₹ 4.2L</div><div class="sc-stat-label">Stock Value</div></div>
                    </div>
                </div>
            </div>

            {{-- Location Filter + Search --}}
            <div class="sc-card mb-3">
                <div class="row g-2 align-items-end">
                    <div class="col-lg-2 col-md-4">
                        <label class="sc-form-label">Location</label>
                        <select class="form-select form-select-sm">
                            <option value="">All Locations</option>
                            <optgroup label="Warehouses">
                                <option>WH-BLR — Bangalore</option>
                                <option>WH-HYD — Hyderabad</option>
                                <option>WH-PNE — Pune</option>
                            </optgroup>
                            <optgroup label="Workshops">
                                <option>WS-HYD — Bangalore</option>
                                <option>WS-HYD — Hyderabad</option>
                            </optgroup>
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-4">
                        <label class="sc-form-label">Category</label>
                        <select class="form-select form-select-sm">
                            <option>All Categories</option>
                            <option>Engine Parts</option>
                            <option>Brake System</option>
                            <option>Electrical</option>
                            <option>Tyres &amp; Wheels</option>
                            <option>Filters</option>
                            <option>Consumables</option>
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-4">
                        <label class="sc-form-label">Stock Status</label>
                        <select class="form-select form-select-sm">
                            <option>All</option>
                            <option>In Stock</option>
                            <option>Low Stock</option>
                            <option>Out of Stock</option>
                        </select>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <label class="sc-form-label">Search</label>
                        <input type="text" class="form-control form-control-sm" placeholder="Part name, code, or brand…">
                    </div>
                    <div class="col-lg-2 col-md-6 d-flex align-items-end">
                        <button class="btn btn-outline-secondary btn-sm w-100"><i class="uil uil-times me-1"></i>Clear</button>
                    </div>
                </div>
            </div>

            {{-- Parts Table --}}
            <div class="sc-table-card">
                <div class="table-responsive">
                    <table class="table sc-table mb-0">
                        <thead>
                            <tr>
                                <th>Item Code</th>
                                <th>Part Name</th>
                                <th>Brand</th>
                                <th>Category</th>
                                <th>Location</th>
                                <th class="text-end">Stock Qty</th>
                                <th>Unit</th>
                                <th class="text-end">Reorder Level</th>
                                <th class="text-end">Unit Cost (₹)</th>
                                <th>Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-muted" style="font-size:12px;">SP-0001</td>
                                <td class="fw-semibold" style="font-size:13px;">Engine Oil 20W-50</td>
                                <td>Castrol</td>
                                <td><span class="sc-cat-badge">Consumable</span></td>
                                <td><span class="loc-badge loc-badge-sc"><i class="uil uil-wrench"></i> WS-HYD</span></td>
                                <td class="text-end fw-semibold text-success">48 ltr</td>
                                <td>ltr</td>
                                <td class="text-end">20</td>
                                <td class="text-end">₹ 280</td>
                                <td><span class="badge sc-inv-good">In Stock</span></td>
                                <td class="text-center">
                                    <div class="sc-row-actions">
                                        <button class="sc-action-btn" title="View History"><i class="uil uil-history"></i></button>
                                        <button class="sc-action-btn" title="Adjust Stock"><i class="uil uil-exchange"></i></button>
                                        <button class="sc-action-btn" title="Transfer Stock" data-bs-toggle="modal" data-bs-target="#transferStockModal"><i class="uil uil-truck-loading"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted" style="font-size:12px;">SP-0002</td>
                                <td class="fw-semibold" style="font-size:13px;">Brake Pads (Front) — Tata Prima</td>
                                <td>Bosch</td>
                                <td><span class="sc-cat-badge sc-cat-brake">Brake System</span></td>
                                <td><span class="loc-badge loc-badge-wh"><i class="uil uil-warehouse"></i> WH-BLR</span></td>
                                <td class="text-end fw-semibold text-warning">4 set</td>
                                <td>set</td>
                                <td class="text-end">5</td>
                                <td class="text-end">₹ 1,200</td>
                                <td><span class="badge sc-inv-low">Low Stock</span></td>
                                <td class="text-center">
                                    <div class="sc-row-actions">
                                        <button class="sc-action-btn" title="View History"><i class="uil uil-history"></i></button>
                                        <button class="sc-action-btn" title="Adjust Stock"><i class="uil uil-exchange"></i></button>
                                        <button class="sc-action-btn" title="Raise PO"><i class="uil uil-shopping-cart"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted" style="font-size:12px;">SP-0003</td>
                                <td class="fw-semibold" style="font-size:13px;">Oil Filter — Tata Prima 4928</td>
                                <td>Tata Genuine</td>
                                <td><span class="sc-cat-badge sc-cat-filter">Filter</span></td>
                                <td><span class="loc-badge loc-badge-sc"><i class="uil uil-wrench"></i> WS-HYD</span></td>
                                <td class="text-end fw-semibold text-success">18 pcs</td>
                                <td>pcs</td>
                                <td class="text-end">10</td>
                                <td class="text-end">₹ 220</td>
                                <td><span class="badge sc-inv-good">In Stock</span></td>
                                <td class="text-center">
                                    <div class="sc-row-actions">
                                        <button class="sc-action-btn" title="View History"><i class="uil uil-history"></i></button>
                                        <button class="sc-action-btn" title="Adjust Stock"><i class="uil uil-exchange"></i></button>
                                        <button class="sc-action-btn" title="Raise PO"><i class="uil uil-shopping-cart"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <tr class="sc-row-oos">
                                <td class="text-muted" style="font-size:12px;">SP-0004</td>
                                <td class="fw-semibold" style="font-size:13px;">Alternator Belt — Ashok Leyland 1916</td>
                                <td>Gates</td>
                                <td><span class="sc-cat-badge sc-cat-engine">Engine</span></td>
                                <td><span class="loc-badge loc-badge-wh"><i class="uil uil-warehouse"></i> WH-HYD</span></td>
                                <td class="text-end fw-semibold text-danger">0 pcs</td>
                                <td>pcs</td>
                                <td class="text-end">2</td>
                                <td class="text-end">₹ 480</td>
                                <td><span class="badge sc-inv-oos">Out of Stock</span></td>
                                <td class="text-center">
                                    <div class="sc-row-actions">
                                        <button class="sc-action-btn" title="View History"><i class="uil uil-history"></i></button>
                                        <button class="sc-action-btn sc-action-btn-danger" title="Raise PO Urgent"><i class="uil uil-shopping-cart"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted" style="font-size:12px;">SP-0005</td>
                                <td class="fw-semibold" style="font-size:13px;">Air Filter — Bharat Benz 2523</td>
                                <td>Mahle</td>
                                <td><span class="sc-cat-badge sc-cat-filter">Filter</span></td>
                                <td><span class="loc-badge loc-badge-wh"><i class="uil uil-warehouse"></i> WH-PNE</span></td>
                                <td class="text-end fw-semibold text-success">12 pcs</td>
                                <td>pcs</td>
                                <td class="text-end">5</td>
                                <td class="text-end">₹ 650</td>
                                <td><span class="badge sc-inv-good">In Stock</span></td>
                                <td class="text-center">
                                    <div class="sc-row-actions">
                                        <button class="sc-action-btn" title="View History"><i class="uil uil-history"></i></button>
                                        <button class="sc-action-btn" title="Adjust Stock"><i class="uil uil-exchange"></i></button>
                                        <button class="sc-action-btn" title="Raise PO"><i class="uil uil-shopping-cart"></i></button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                {{-- Pagination --}}
                <div class="d-flex align-items-center justify-content-between px-3 py-2 border-top">
                    <small class="text-muted">Showing 5 of 142 items</small>
                    <nav><ul class="pagination pagination-sm mb-0">
                        <li class="page-item disabled"><a class="page-link" href="#">&laquo;</a></li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                    </ul></nav>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- Add Item Modal --}}
<div class="modal fade" id="addItemModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header"><h6 class="modal-title">Add Spare Part</h6><button type="button" class="btn-close btn-sm" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-8"><label class="sc-form-label">Part Name <span class="text-danger">*</span></label><input type="text" class="form-control form-control-sm"></div>
                    <div class="col-4"><label class="sc-form-label">Item Code</label><input type="text" class="form-control form-control-sm" placeholder="Auto"></div>
                    <div class="col-6"><label class="sc-form-label">Brand <span class="text-danger">*</span></label><input type="text" class="form-control form-control-sm"></div>
                    <div class="col-6"><label class="sc-form-label">Category <span class="text-danger">*</span></label><select class="form-select form-select-sm"><option>Engine Parts</option><option>Brake System</option><option>Electrical</option><option>Filters</option><option>Consumables</option></select></div>
                    <div class="col-4"><label class="sc-form-label">Opening Stock <span class="text-danger">*</span></label><input type="number" class="form-control form-control-sm" min="0"></div>
                    <div class="col-4"><label class="sc-form-label">Unit <span class="text-danger">*</span></label><select class="form-select form-select-sm"><option>pcs</option><option>ltr</option><option>set</option><option>pair</option><option>kg</option></select></div>
                    <div class="col-4"><label class="sc-form-label">Reorder Level <span class="text-danger">*</span></label><input type="number" class="form-control form-control-sm" min="0"></div>
                    <div class="col-6"><label class="sc-form-label">Unit Cost (₹) <span class="text-danger">*</span></label><input type="number" class="form-control form-control-sm" min="0" step="0.01"></div>
                    <div class="col-6">
                        <label class="sc-form-label">Location <span class="text-danger">*</span></label>
                        <select class="form-select form-select-sm">
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
                </div>
            </div>
            <div class="modal-footer"><button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button><button type="button" class="btn sc-btn-navy btn-sm">Add Part</button></div>
        </div>
    </div>
</div>

{{-- Adjust Stock Modal --}}
<div class="modal fade" id="adjustStockModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header"><h6 class="modal-title"><i class="uil uil-exchange me-2"></i>Adjust Stock</h6><button type="button" class="btn-close btn-sm" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-12"><label class="sc-form-label">Item <span class="text-danger">*</span></label><select class="form-select form-select-sm select2-inv-item"><option>Engine Oil 20W-50 (Castrol)</option></select></div>
                    <div class="col-6"><label class="sc-form-label">Current Stock</label><input type="text" class="form-control form-control-sm bg-light" readonly value="48 ltr"></div>
                    <div class="col-6"><label class="sc-form-label">Adjustment Type <span class="text-danger">*</span></label><select class="form-select form-select-sm"><option>Add (Received)</option><option>Reduce (Usage)</option><option>Write-Off</option></select></div>
                    <div class="col-6"><label class="sc-form-label">Quantity <span class="text-danger">*</span></label><input type="number" class="form-control form-control-sm" min="0.01" step="0.01"></div>
                    <div class="col-12"><label class="sc-form-label">Reason / Notes</label><textarea class="form-control form-control-sm" rows="2"></textarea></div>
                </div>
            </div>
            <div class="modal-footer"><button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button><button type="button" class="btn sc-btn-navy btn-sm">Save Adjustment</button></div>
        </div>
    </div>
</div>
@endsection

{{-- Transfer Stock Modal (quick entry — full page at inventory.stock-transfer) --}}
<div class="modal fade" id="transferStockModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title"><i class="uil uil-truck-loading me-2"></i>Transfer Stock</h6>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="sc-form-label">Item <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm bg-light" readonly value="Brake Pads (Front) — Tata Prima">
                    </div>
                    <div class="col-md-6">
                        <label class="sc-form-label">Transfer From <span class="text-danger">*</span></label>
                        <select class="form-select form-select-sm">
                            <optgroup label="Warehouses">
                                <option selected>WH-BLR — Warehouse Bangalore</option>
                                <option>WH-HYD — Warehouse Hyderabad</option>
                                <option>WH-PNE — Warehouse Pune</option>
                            </optgroup>
                            <optgroup label="Workshops">
                                <option>WS-HYD — SC Bangalore</option>
                                <option>WS-HYD — SC Hyderabad</option>
                            </optgroup>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="sc-form-label">Transfer To <span class="text-danger">*</span></label>
                        <select class="form-select form-select-sm">
                            <optgroup label="Workshops">
                                <option>WS-HYD — SC Bangalore</option>
                                <option>WS-HYD — SC Hyderabad</option>
                            </optgroup>
                            <optgroup label="Warehouses">
                                <option>WH-BLR — Warehouse Bangalore</option>
                                <option>WH-HYD — Warehouse Hyderabad</option>
                                <option>WH-PNE — Warehouse Pune</option>
                            </optgroup>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="sc-form-label">Quantity <span class="text-danger">*</span></label>
                        <input type="number" class="form-control form-control-sm" min="1" placeholder="0">
                        <div class="form-text" style="font-size:10px;">Available at source: 4 set</div>
                    </div>
                    <div class="col-md-6">
                        <label class="sc-form-label">Transfer Date</label>
                        <input type="date" class="form-control form-control-sm">
                    </div>
                    <div class="col-12">
                        <label class="sc-form-label">Notes</label>
                        <textarea class="form-control form-control-sm" rows="2" placeholder="Reason or reference..."></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <a href="{{ route('inventory.stock-transfer') }}" class="btn btn-outline-secondary btn-sm">Full Transfer Page</a>
                <button type="button" class="btn sc-btn-navy btn-sm">Create Transfer</button>
            </div>
        </div>
    </div>
</div>

@section('js')
<script>
$(function() {
    $('.select2-inv-item').select2({ width: '100%', dropdownParent: $('#adjustStockModal') });
    $('#spLocCtx').on('change', function() {
        // In backend phase: reload table rows filtered by location
    });
});
</script>
@endsection
