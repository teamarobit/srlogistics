@extends('layouts.app')

@section('css')
<link href="{{ asset('css/Workshop/tyre-inventory.css?v=1.0') }}" rel="stylesheet">
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
                    <li class="breadcrumb-item active">Tyre Inventory</li>
                </ol>
            </nav>

            {{-- Location Context Bar --}}
            <div class="loc-ctx-bar">
                <div class="loc-ctx-left">
                    <i class="uil uil-map-marker loc-ctx-icon"></i>
                    <span class="loc-ctx-label">Location:</span>
                    <select class="loc-ctx-select" id="tyrLocCtx">
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
                <div style="font-size:11px;color:#adb5bd;">Tyre stock across all locations</div>
            </div>

            <div class="sc-page-head d-flex align-items-center justify-content-between mb-3">
                <div>
                    <h5 class="mb-0">Tyre Inventory</h5>
                    <span class="text-muted" style="font-size:12px;">Stock levels, KM life tracking and vehicle assignment</span>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('tyre.dashboard') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="uil uil-tachometer-fast me-1"></i>Tyre Dashboard
                    </a>
                    <a href="{{ route('inventory.purchase-orders') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="uil uil-shopping-cart me-1"></i>Raise PO
                    </a>
                    <button class="btn sc-btn-navy btn-sm" data-bs-toggle="modal" data-bs-target="#addTyreStockModal">
                        <i class="uil uil-plus me-1"></i>Add Stock
                    </button>
                </div>
            </div>

            {{-- Summary --}}
            <div class="row g-3 mb-3">
                <div class="col-lg-3 col-md-6">
                    <div class="sc-stat-card sc-stat-navy">
                        <div class="sc-stat-icon"><i class="uil uil-circle"></i></div>
                        <div class="sc-stat-body"><div class="sc-stat-val">38</div><div class="sc-stat-label">Total Tyres in Stock</div></div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="sc-stat-card sc-stat-green">
                        <div class="sc-stat-icon"><i class="uil uil-check-circle"></i></div>
                        <div class="sc-stat-body"><div class="sc-stat-val">24</div><div class="sc-stat-label">New / Good Condition</div></div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="sc-stat-card sc-stat-amber">
                        <div class="sc-stat-icon"><i class="uil uil-exclamation-triangle"></i></div>
                        <div class="sc-stat-body"><div class="sc-stat-val">10</div><div class="sc-stat-label">Retreaded / Average</div></div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="sc-stat-card sc-stat-red">
                        <div class="sc-stat-icon"><i class="uil uil-times-circle"></i></div>
                        <div class="sc-stat-body"><div class="sc-stat-val">4</div><div class="sc-stat-label">For Replacement</div></div>
                    </div>
                </div>
            </div>

            {{-- Filters --}}
            <div class="sc-card mb-3">
                <div class="row g-2 align-items-end">
                    <div class="col-lg-2 col-md-4">
                        <label class="sc-form-label">Location</label>
                        <select class="form-select form-select-sm">
                            <option>All</option>
                            <optgroup label="Warehouses">
                                <option>WH-BLR</option><option>WH-HYD</option><option>WH-PNE</option>
                            </optgroup>
                            <optgroup label="Workshops">
                                <option>WS-HYD</option><option>WS-HYD</option>
                            </optgroup>
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-4">
                        <label class="sc-form-label">Condition</label>
                        <select class="form-select form-select-sm"><option>All</option><option>New</option><option>Good</option><option>Average</option><option>Replace</option></select>
                    </div>
                    <div class="col-lg-2 col-md-4">
                        <label class="sc-form-label">Status</label>
                        <select class="form-select form-select-sm"><option>All</option><option>In Stock</option><option>Fitted</option><option>Stepney</option><option>Scrap</option></select>
                    </div>
                    <div class="col-lg-2 col-md-4">
                        <label class="sc-form-label">Size</label>
                        <select class="form-select form-select-sm"><option>All Sizes</option><option>10.00 R20</option><option>11.00 R20</option><option>295/80 R22.5</option></select>
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <label class="sc-form-label">Search</label>
                        <input type="text" class="form-control form-control-sm" placeholder="Serial, Make, Size…">
                    </div>
                    <div class="col-lg-2 col-md-6 d-flex align-items-end">
                        <button class="btn btn-outline-secondary btn-sm w-100"><i class="uil uil-times me-1"></i>Clear</button>
                    </div>
                </div>
            </div>

            {{-- Tyre Stock Table --}}
            <div class="sc-table-card">
                <div class="table-responsive">
                    <table class="table sc-table mb-0">
                        <thead>
                            <tr>
                                <th>Serial No.</th>
                                <th>Make</th>
                                <th>Size</th>
                                <th>Type</th>
                                <th>Location</th>
                                <th>PO Ref</th>
                                <th class="text-end">KM Life</th>
                                <th class="text-end">KM Run</th>
                                <th class="text-end">KM Balance</th>
                                <th>Condition</th>
                                <th>Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="fw-semibold" style="font-size:12px;">TYR-2026-00412</td>
                                <td>Apollo</td>
                                <td>10.00 R20</td>
                                <td>Radial</td>
                                <td><span class="loc-badge loc-badge-wh"><i class="uil uil-warehouse"></i> WH-BLR</span></td>
                                <td><a href="{{ route('inventory.po-detail', 'PO-2026-0015') }}" class="sc-doc-link" style="font-size:11px;">PO-2026-0015</a></td>
                                <td class="text-end">1,20,000 KM</td>
                                <td class="text-end">0 KM</td>
                                <td class="text-end fw-semibold text-success">1,20,000 KM</td>
                                <td><span class="badge sc-tyre-new">New</span></td>
                                <td><span class="badge bg-secondary" style="font-size:11px;">In Stock</span></td>
                                <td class="text-center">
                                    <div class="sc-row-actions">
                                        <button class="sc-action-btn" title="View Details"><i class="uil uil-eye"></i></button>
                                        <button class="sc-action-btn btn-fit-tyre" title="Fit to Vehicle"
                                            data-serial="TYR-2026-00412" data-make="Apollo" data-size="10.00 R20"
                                            data-bs-toggle="modal" data-bs-target="#fitTyreModal">
                                            <i class="uil uil-truck"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold" style="font-size:12px;">TYR-2024-00281</td>
                                <td>MRF</td>
                                <td>11.00 R20</td>
                                <td>Radial</td>
                                <td><span class="loc-badge loc-badge-sc"><i class="uil uil-wrench"></i> WS-HYD</span></td>
                                <td><span class="text-muted" style="font-size:11px;">—</span></td>
                                <td class="text-end">1,00,000 KM</td>
                                <td class="text-end">72,400 KM</td>
                                <td class="text-end fw-semibold text-warning">27,600 KM</td>
                                <td><span class="badge sc-tyre-avg">Average</span></td>
                                <td><span class="badge bg-secondary" style="font-size:11px;">Stepney</span></td>
                                <td class="text-center">
                                    <div class="sc-row-actions">
                                        <button class="sc-action-btn" title="View Details"><i class="uil uil-eye"></i></button>
                                        <button class="sc-action-btn btn-fit-tyre" title="Fit to Vehicle"
                                            data-serial="TYR-2024-00281" data-make="MRF" data-size="11.00 R20"
                                            data-bs-toggle="modal" data-bs-target="#fitTyreModal">
                                            <i class="uil uil-truck"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr class="sc-row-oos">
                                <td class="fw-semibold" style="font-size:12px;">TYR-2023-00145</td>
                                <td>CEAT</td>
                                <td>295/80 R22.5</td>
                                <td>Radial</td>
                                <td><span class="loc-badge loc-badge-wh"><i class="uil uil-warehouse"></i> WH-BLR</span></td>
                                <td><span class="text-muted" style="font-size:11px;">—</span></td>
                                <td class="text-end">80,000 KM</td>
                                <td class="text-end">79,200 KM</td>
                                <td class="text-end fw-semibold text-danger">800 KM</td>
                                <td><span class="badge sc-tyre-replace">Replace</span></td>
                                <td><span class="badge sc-inv-oos">Scrap</span></td>
                                <td class="text-center">
                                    <div class="sc-row-actions">
                                        <button class="sc-action-btn" title="View Details"><i class="uil uil-eye"></i></button>
                                        <a href="{{ route('inventory.purchase-orders') }}" class="sc-action-btn sc-action-btn-danger" title="Raise Replacement PO"><i class="uil uil-shopping-cart"></i></a>
                                        <button class="sc-action-btn" title="Mark as Discarded"><i class="uil uil-trash-alt"></i></button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="d-flex align-items-center justify-content-between px-3 py-2 border-top">
                    <small class="text-muted">Showing 3 of 38 tyres</small>
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

{{-- Add Tyre Stock Modal --}}
<div class="modal fade" id="addTyreStockModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header"><h6 class="modal-title">Add Tyre to Stock</h6><button type="button" class="btn-close btn-sm" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-6"><label class="sc-form-label">Make <span class="text-danger">*</span></label><input type="text" class="form-control form-control-sm" placeholder="e.g. Apollo, MRF, CEAT"></div>
                    <div class="col-6"><label class="sc-form-label">Serial No. <span class="text-danger">*</span></label><input type="text" class="form-control form-control-sm"></div>
                    <div class="col-6"><label class="sc-form-label">Size <span class="text-danger">*</span></label><input type="text" class="form-control form-control-sm" placeholder="e.g. 10.00 R20"></div>
                    <div class="col-6"><label class="sc-form-label">Type</label><select class="form-select form-select-sm"><option>Radial</option><option>Bias</option></select></div>
                    <div class="col-6"><label class="sc-form-label">KM Life <span class="text-danger">*</span></label><input type="number" class="form-control form-control-sm" placeholder="e.g. 120000"></div>
                    <div class="col-6"><label class="sc-form-label">Location <span class="text-danger">*</span></label>
                        <select class="form-select form-select-sm">
                            <option value="">— Select —</option>
                            <optgroup label="Warehouses"><option>WH-BLR</option><option>WH-HYD</option><option>WH-PNE</option></optgroup>
                            <optgroup label="Workshops"><option>WS-HYD</option><option>WS-HYD</option></optgroup>
                        </select>
                    </div>
                    <div class="col-6"><label class="sc-form-label">Purchase Date</label><input type="date" class="form-control form-control-sm"></div>
                    <div class="col-6"><label class="sc-form-label">Purchase Cost (₹)</label><input type="number" class="form-control form-control-sm" min="0" step="0.01"></div>
                    <div class="col-12">
                        <label class="sc-form-label">PO Reference <span class="text-muted">(optional)</span></label>
                        <select class="form-select form-select-sm select2-tyr-po">
                            <option value="">— Link to PO —</option>
                            <option value="PO-2026-0015">PO-2026-0015 — Apollo Tyres</option>
                            <option value="PO-2026-0016">PO-2026-0016 — Tata Genuine Parts</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer"><button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button><button type="button" class="btn sc-btn-navy btn-sm">Add Tyre</button></div>
        </div>
    </div>
</div>

{{-- Fit Tyre to Vehicle Modal --}}
<div class="modal fade" id="fitTyreModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title"><i class="uil uil-truck me-2"></i>Fit Tyre to Vehicle</h6>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                {{-- Tyre summary --}}
                <div class="sc-card mb-3" style="background:#f5f7fb;border:1px solid #e4e7ef;">
                    <div class="p-2 px-3 d-flex align-items-center gap-3">
                        <i class="uil uil-circle text-navy" style="font-size:22px;"></i>
                        <div>
                            <div class="fw-bold" id="ftTyreSerial" style="font-size:13px;">TYR-2026-00412</div>
                            <div class="text-muted" id="ftTyreDesc" style="font-size:11px;">Apollo · 10.00 R20</div>
                        </div>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-12">
                        <label class="sc-form-label">Select Vehicle <span class="text-danger">*</span></label>
                        <select class="form-select form-select-sm select2-fit-veh" id="fitTyreVeh">
                            <option value="">Search vehicle number…</option>
                            <option value="v1" data-reg="TN01 AB1234">TN01 AB1234 — Tata Prima 4928</option>
                            <option value="v2" data-reg="TN02 CD5678">TN02 CD5678 — Ashok Leyland 1916</option>
                            <option value="v3" data-reg="TN03 EF9012">TN03 EF9012 — Bharat Benz 2523</option>
                            <option value="v4" data-reg="TN04 GH3456">TN04 GH3456 — Tata LPT 3118</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="sc-form-label">Wheel Position <span class="text-danger">*</span></label>
                        <select class="form-select form-select-sm">
                            <option value="">— Select Position —</option>
                            <option>Front-Left (F1)</option>
                            <option>Front-Right (F2)</option>
                            <option>Rear-Left Outer (R1O)</option>
                            <option>Rear-Left Inner (R1I)</option>
                            <option>Rear-Right Inner (R2I)</option>
                            <option>Rear-Right Outer (R2O)</option>
                            <option>Stepney</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="sc-form-label">Fitting Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control form-control-sm" value="{{ now()->format('Y-m-d') }}">
                    </div>
                    <div class="col-6">
                        <label class="sc-form-label">Vehicle KM at Fitting</label>
                        <input type="number" class="form-control form-control-sm" placeholder="Current odometer KM">
                    </div>
                    <div class="col-6">
                        <label class="sc-form-label">Fitted By (Technician)</label>
                        <input type="text" class="form-control form-control-sm" placeholder="Technician name">
                    </div>
                    <div class="col-12">
                        <div class="alert alert-info py-2" style="font-size:12px;">
                            <i class="uil uil-info-circle me-1"></i>
                            Fitting this tyre will update its status to <strong>Fitted</strong> and remove it from available stock. The vehicle's tyre record will be updated in Fleet.
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn sc-btn-navy btn-sm" id="btnConfirmFitTyre">Confirm Fitting</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script>
$(function () {
    $('.select2-tyr-po').select2({ width: '100%', dropdownParent: $('#addTyreStockModal') });
    $('.select2-fit-veh').select2({ width: '100%', placeholder: 'Search vehicle number…', dropdownParent: $('#fitTyreModal') });

    // Populate Fit to Vehicle modal with tyre details
    $(document).on('click', '.btn-fit-tyre', function () {
        var serial = $(this).data('serial');
        var make   = $(this).data('make');
        var size   = $(this).data('size');
        $('#ftTyreSerial').text(serial);
        $('#ftTyreDesc').text(make + ' · ' + size);
    });

    // Confirm fitting — show SweetAlert confirmation
    $('#btnConfirmFitTyre').on('click', function () {
        var veh = $('#fitTyreVeh').val();
        if (!veh) {
            Swal.fire({ icon: 'warning', title: 'Select Vehicle', text: 'Please select the vehicle to fit this tyre to.', confirmButtonColor: '#032671' });
            return;
        }
        Swal.fire({
            icon: 'question',
            title: 'Confirm Tyre Fitting?',
            text: 'This will mark the tyre as Fitted and update the vehicle fleet record.',
            showCancelButton: true,
            confirmButtonColor: '#10863f',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, Fit Tyre'
        }).then(function (result) {
            if (result.isConfirmed) {
                $('#fitTyreModal').modal('hide');
                Swal.fire({ icon: 'success', title: 'Tyre Fitted', text: 'Tyre has been fitted to the selected vehicle and fleet record updated.', confirmButtonColor: '#032671' });
            }
        });
    });
});
</script>
@endsection
