@extends('layouts.app')

@section('css')
<link href="{{ asset('css/Workshop/battery-inventory.css?v=1.0') }}" rel="stylesheet">
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
                    <li class="breadcrumb-item active">Battery Inventory</li>
                </ol>
            </nav>

            {{-- Location Context Bar --}}
            <div class="loc-ctx-bar">
                <div class="loc-ctx-left">
                    <i class="uil uil-map-marker loc-ctx-icon"></i>
                    <span class="loc-ctx-label">Location:</span>
                    <select class="loc-ctx-select" id="batLocCtx">
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
                <div style="font-size:11px;color:#adb5bd;">Battery stock across all locations</div>
            </div>

            <div class="sc-page-head d-flex align-items-center justify-content-between mb-3">
                <div>
                    <h5 class="mb-0">Battery Inventory</h5>
                    <span class="text-muted" style="font-size:12px;">Battery stock, condition tracking and vehicle assignment</span>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('inventory.purchase-orders') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="uil uil-shopping-cart me-1"></i>Raise PO
                    </a>
                    <button class="btn sc-btn-navy btn-sm" data-bs-toggle="modal" data-bs-target="#addBatteryModal">
                        <i class="uil uil-plus me-1"></i>Add Battery
                    </button>
                </div>
            </div>

            {{-- Summary --}}
            <div class="row g-3 mb-3">
                <div class="col-lg-3 col-md-6">
                    <div class="sc-stat-card sc-stat-navy">
                        <div class="sc-stat-icon"><i class="uil uil-bolt-alt"></i></div>
                        <div class="sc-stat-body"><div class="sc-stat-val">22</div><div class="sc-stat-label">Total Batteries in Stock</div></div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="sc-stat-card sc-stat-green">
                        <div class="sc-stat-icon"><i class="uil uil-check-circle"></i></div>
                        <div class="sc-stat-body"><div class="sc-stat-val">16</div><div class="sc-stat-label">Good Condition</div></div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="sc-stat-card sc-stat-amber">
                        <div class="sc-stat-icon"><i class="uil uil-exclamation-triangle"></i></div>
                        <div class="sc-stat-body"><div class="sc-stat-val">4</div><div class="sc-stat-label">Monitor / Weak</div></div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="sc-stat-card sc-stat-red">
                        <div class="sc-stat-icon"><i class="uil uil-times-circle"></i></div>
                        <div class="sc-stat-body"><div class="sc-stat-val">2</div><div class="sc-stat-label">For Replacement</div></div>
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
                        <select class="form-select form-select-sm"><option>All</option><option>Good</option><option>Monitor</option><option>Replace</option></select>
                    </div>
                    <div class="col-lg-2 col-md-4">
                        <label class="sc-form-label">Status</label>
                        <select class="form-select form-select-sm"><option>All</option><option>In Stock</option><option>Fitted</option><option>Scrap</option></select>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <label class="sc-form-label">Search</label>
                        <input type="text" class="form-control form-control-sm" placeholder="Serial No., Make, Capacity…">
                    </div>
                    <div class="col-lg-2 d-flex align-items-end">
                        <button class="btn btn-outline-secondary btn-sm w-100"><i class="uil uil-times me-1"></i>Clear</button>
                    </div>
                </div>
            </div>

            {{-- Battery Table --}}
            <div class="sc-table-card">
                <div class="table-responsive">
                    <table class="table sc-table mb-0">
                        <thead>
                            <tr>
                                <th>Serial No.</th>
                                <th>Make</th>
                                <th>Capacity</th>
                                <th>Voltage</th>
                                <th>Location</th>
                                <th>PO Ref</th>
                                <th>Purchase Date</th>
                                <th>Warranty Until</th>
                                <th>Month Life</th>
                                <th>Months Used</th>
                                <th>Condition</th>
                                <th>Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="fw-semibold" style="font-size:12px;">BAT-2026-00081</td>
                                <td>Amaron</td>
                                <td class="text-center">150 AH</td>
                                <td class="text-center">12V</td>
                                <td><span class="loc-badge loc-badge-wh"><i class="uil uil-warehouse"></i> WH-BLR</span></td>
                                <td><a href="{{ route('inventory.po-detail', 'PO-2026-0016') }}" class="sc-doc-link" style="font-size:11px;">PO-2026-0016</a></td>
                                <td>Jan-2026</td>
                                <td>Jan-2028</td>
                                <td class="text-center">24</td>
                                <td class="text-center">3</td>
                                <td><span class="badge sc-bat-good">Good</span></td>
                                <td><span class="badge bg-secondary" style="font-size:11px;">In Stock</span></td>
                                <td class="text-center">
                                    <div class="sc-row-actions">
                                        <button class="sc-action-btn" title="View"><i class="uil uil-eye"></i></button>
                                        <button class="sc-action-btn btn-fit-battery" title="Fit to Vehicle"
                                            data-serial="BAT-2026-00081" data-make="Amaron" data-cap="150 AH / 12V"
                                            data-bs-toggle="modal" data-bs-target="#fitBatteryModal">
                                            <i class="uil uil-truck"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold" style="font-size:12px;">BAT-2024-00044</td>
                                <td>Exide</td>
                                <td class="text-center">180 AH</td>
                                <td class="text-center">12V</td>
                                <td><span class="loc-badge loc-badge-sc"><i class="uil uil-wrench"></i> WS-HYD</span></td>
                                <td><span class="text-muted" style="font-size:11px;">—</span></td>
                                <td>Apr-2024</td>
                                <td>Apr-2026</td>
                                <td class="text-center">24</td>
                                <td class="text-center">24</td>
                                <td><span class="badge sc-bat-monitor">Monitor</span></td>
                                <td><span class="badge bg-secondary" style="font-size:11px;">In Stock</span></td>
                                <td class="text-center">
                                    <div class="sc-row-actions">
                                        <button class="sc-action-btn" title="View"><i class="uil uil-eye"></i></button>
                                        <button class="sc-action-btn btn-fit-battery" title="Fit to Vehicle"
                                            data-serial="BAT-2024-00044" data-make="Exide" data-cap="180 AH / 12V"
                                            data-bs-toggle="modal" data-bs-target="#fitBatteryModal">
                                            <i class="uil uil-truck"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr class="sc-row-oos">
                                <td class="fw-semibold" style="font-size:12px;">BAT-2022-00019</td>
                                <td>Amaron</td>
                                <td class="text-center">150 AH</td>
                                <td class="text-center">12V</td>
                                <td><span class="loc-badge loc-badge-wh"><i class="uil uil-warehouse"></i> WH-BLR</span></td>
                                <td><span class="text-muted" style="font-size:11px;">—</span></td>
                                <td>Mar-2022</td>
                                <td>Mar-2024 <span class="badge bg-danger ms-1" style="font-size:10px;">Expired</span></td>
                                <td class="text-center">24</td>
                                <td class="text-center">48</td>
                                <td><span class="badge sc-bat-replace">Replace</span></td>
                                <td><span class="badge sc-inv-oos">Scrap</span></td>
                                <td class="text-center">
                                    <div class="sc-row-actions">
                                        <button class="sc-action-btn" title="View"><i class="uil uil-eye"></i></button>
                                        <a href="{{ route('inventory.purchase-orders') }}" class="sc-action-btn sc-action-btn-danger" title="Raise Replacement PO"><i class="uil uil-shopping-cart"></i></a>
                                        <button class="sc-action-btn" title="Mark Discarded"><i class="uil uil-trash-alt"></i></button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="d-flex align-items-center justify-content-between px-3 py-2 border-top">
                    <small class="text-muted">Showing 3 of 22 batteries</small>
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

{{-- Add Battery Modal --}}
<div class="modal fade" id="addBatteryModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header"><h6 class="modal-title">Add Battery to Stock</h6><button type="button" class="btn-close btn-sm" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-6"><label class="sc-form-label">Make <span class="text-danger">*</span></label><input type="text" class="form-control form-control-sm"></div>
                    <div class="col-6"><label class="sc-form-label">Serial No. <span class="text-danger">*</span></label><input type="text" class="form-control form-control-sm"></div>
                    <div class="col-4"><label class="sc-form-label">Capacity (AH) <span class="text-danger">*</span></label><input type="number" class="form-control form-control-sm"></div>
                    <div class="col-4"><label class="sc-form-label">Voltage (V) <span class="text-danger">*</span></label><select class="form-select form-select-sm"><option>12V</option><option>24V</option></select></div>
                    <div class="col-4"><label class="sc-form-label">Month Life <span class="text-danger">*</span></label><input type="number" class="form-control form-control-sm" placeholder="24"></div>
                    <div class="col-6"><label class="sc-form-label">Purchase Date</label><input type="date" class="form-control form-control-sm"></div>
                    <div class="col-6"><label class="sc-form-label">Warranty Until</label><input type="date" class="form-control form-control-sm"></div>
                    <div class="col-6"><label class="sc-form-label">Purchase Cost (₹)</label><input type="number" class="form-control form-control-sm" min="0" step="0.01"></div>
                    <div class="col-6"><label class="sc-form-label">Location <span class="text-danger">*</span></label>
                        <select class="form-select form-select-sm">
                            <option value="">— Select —</option>
                            <optgroup label="Warehouses"><option>WH-BLR</option><option>WH-HYD</option><option>WH-PNE</option></optgroup>
                            <optgroup label="Workshops"><option>WS-HYD</option><option>WS-HYD</option></optgroup>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="sc-form-label">PO Reference <span class="text-muted">(optional)</span></label>
                        <select class="form-select form-select-sm select2-bat-po">
                            <option value="">— Link to PO —</option>
                            <option value="PO-2026-0016">PO-2026-0016 — Tata Genuine Parts</option>
                            <option value="PO-2026-0018">PO-2026-0018 — Bosch Auto Parts</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer"><button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button><button type="button" class="btn sc-btn-navy btn-sm">Add Battery</button></div>
        </div>
    </div>
</div>

{{-- Fit Battery to Vehicle Modal --}}
<div class="modal fade" id="fitBatteryModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title"><i class="uil uil-bolt-alt me-2"></i>Fit Battery to Vehicle</h6>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                {{-- Battery summary --}}
                <div class="sc-card mb-3" style="background:#f5f7fb;border:1px solid #e4e7ef;">
                    <div class="p-2 px-3 d-flex align-items-center gap-3">
                        <i class="uil uil-bolt-alt text-navy" style="font-size:22px;"></i>
                        <div>
                            <div class="fw-bold" id="ftBatSerial" style="font-size:13px;">BAT-2026-00081</div>
                            <div class="text-muted" id="ftBatDesc" style="font-size:11px;">Amaron · 150 AH / 12V</div>
                        </div>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-12">
                        <label class="sc-form-label">Select Vehicle <span class="text-danger">*</span></label>
                        <select class="form-select form-select-sm select2-fit-bat-veh" id="fitBatVeh">
                            <option value="">Search vehicle number…</option>
                            <option value="v1">TN01 AB1234 — Tata Prima 4928</option>
                            <option value="v2">TN02 CD5678 — Ashok Leyland 1916</option>
                            <option value="v3">TN03 EF9012 — Bharat Benz 2523</option>
                            <option value="v4">TN04 GH3456 — Tata LPT 3118</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="sc-form-label">Battery Position</label>
                        <select class="form-select form-select-sm">
                            <option>Primary</option>
                            <option>Auxiliary</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="sc-form-label">Fitting Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control form-control-sm" value="{{ now()->format('Y-m-d') }}">
                    </div>
                    <div class="col-12">
                        <label class="sc-form-label">Fitted By (Technician)</label>
                        <input type="text" class="form-control form-control-sm" placeholder="Technician name">
                    </div>
                    <div class="col-12">
                        <div class="alert alert-info py-2" style="font-size:12px;">
                            <i class="uil uil-info-circle me-1"></i>
                            Fitting this battery will update its status to <strong>Fitted</strong> and remove it from available stock. The vehicle's battery record will be updated in Fleet.
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn sc-btn-navy btn-sm" id="btnConfirmFitBattery">Confirm Fitting</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script>
$(function () {
    $('.select2-bat-po').select2({ width: '100%', dropdownParent: $('#addBatteryModal') });
    $('.select2-fit-bat-veh').select2({ width: '100%', placeholder: 'Search vehicle number…', dropdownParent: $('#fitBatteryModal') });

    // Populate Fit Battery modal
    $(document).on('click', '.btn-fit-battery', function () {
        $('#ftBatSerial').text($(this).data('serial'));
        $('#ftBatDesc').text($(this).data('make') + ' · ' + $(this).data('cap'));
    });

    // Confirm fitting
    $('#btnConfirmFitBattery').on('click', function () {
        if (!$('#fitBatVeh').val()) {
            Swal.fire({ icon: 'warning', title: 'Select Vehicle', text: 'Please select the vehicle to fit this battery to.', confirmButtonColor: '#032671' });
            return;
        }
        Swal.fire({
            icon: 'question',
            title: 'Confirm Battery Fitting?',
            text: 'This will mark the battery as Fitted and update the vehicle fleet record.',
            showCancelButton: true,
            confirmButtonColor: '#10863f',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, Fit Battery'
        }).then(function (result) {
            if (result.isConfirmed) {
                $('#fitBatteryModal').modal('hide');
                Swal.fire({ icon: 'success', title: 'Battery Fitted', text: 'Battery has been fitted to the selected vehicle and fleet record updated.', confirmButtonColor: '#032671' });
            }
        });
    });
});
</script>
@endsection
