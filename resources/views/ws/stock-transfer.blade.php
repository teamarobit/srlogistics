@extends('layouts.app')

@section('css')
<link href="{{ asset('css/Workshop/stock-transfer.css?v=1.0') }}" rel="stylesheet">
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
                    <li class="breadcrumb-item active">Stock Transfers</li>
                </ol>
            </nav>

            <div class="sc-page-head d-flex align-items-center justify-content-between mb-3">
                <div>
                    <h5 class="mb-0">Stock Transfers</h5>
                    <span class="text-muted" style="font-size:12px;">Move stock between warehouses and service centres</span>
                </div>
                <button class="btn sc-btn-navy btn-sm" data-bs-toggle="modal" data-bs-target="#newTransferModal">
                    <i class="uil uil-exchange-alt me-1"></i> New Transfer
                </button>
            </div>

            {{-- Stats --}}
            <div class="row g-3 mb-3">
                <div class="col-6 col-md-3">
                    <div class="sc-stat-card sc-stat-navy">
                        <div class="sc-stat-icon"><i class="uil uil-truck-loading"></i></div>
                        <div class="sc-stat-body"><div class="sc-stat-val">3</div><div class="sc-stat-label">In Transit</div></div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="sc-stat-card sc-stat-amber">
                        <div class="sc-stat-icon"><i class="uil uil-clock"></i></div>
                        <div class="sc-stat-body"><div class="sc-stat-val">1</div><div class="sc-stat-label">Pending Dispatch</div></div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="sc-stat-card sc-stat-green">
                        <div class="sc-stat-icon"><i class="uil uil-check-circle"></i></div>
                        <div class="sc-stat-body"><div class="sc-stat-val">18</div><div class="sc-stat-label">Completed This Month</div></div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="sc-stat-card sc-stat-grey">
                        <div class="sc-stat-icon"><i class="uil uil-box"></i></div>
                        <div class="sc-stat-body"><div class="sc-stat-val">284</div><div class="sc-stat-label">Units Transferred (MTD)</div></div>
                    </div>
                </div>
            </div>

            {{-- Filters --}}
            <div class="sc-card mb-3">
                <div class="row g-2 align-items-end p-1">
                    <div class="col-lg-2 col-md-4">
                        <label class="sc-form-label">Status</label>
                        <select class="form-select form-select-sm">
                            <option value="">All</option>
                            <option>Pending</option>
                            <option>In Transit</option>
                            <option>Received</option>
                            <option>Cancelled</option>
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-4">
                        <label class="sc-form-label">From Location</label>
                        <select class="form-select form-select-sm">
                            <option value="">All</option>
                            <optgroup label="Warehouses">
                                <option>WH-BLR</option><option>WH-HYD</option><option>WH-PNE</option>
                            </optgroup>
                            <optgroup label="Workshops">
                                <option>WS-HYD</option><option>WS-HYD</option>
                            </optgroup>
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-4">
                        <label class="sc-form-label">To Location</label>
                        <select class="form-select form-select-sm">
                            <option value="">All</option>
                            <optgroup label="Warehouses">
                                <option>WH-BLR</option><option>WH-HYD</option><option>WH-PNE</option>
                            </optgroup>
                            <optgroup label="Workshops">
                                <option>WS-HYD</option><option>WS-HYD</option>
                            </optgroup>
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-4">
                        <label class="sc-form-label">From Date</label>
                        <input type="date" class="form-control form-control-sm">
                    </div>
                    <div class="col-lg-1 col-md-2">
                        <button class="btn btn-outline-secondary btn-sm w-100 mt-1"><i class="uil uil-times"></i></button>
                    </div>
                </div>
            </div>

            {{-- Transfer Table --}}
            <div class="sc-table-card">
                <div class="table-responsive">
                    <table class="table sc-table mb-0">
                        <thead>
                            <tr>
                                <th>Transfer #</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Items</th>
                                <th>Qty (Total)</th>
                                <th>Initiated</th>
                                <th>Dispatched</th>
                                <th>Received</th>
                                <th>Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $transfers = [
                                ['TRF-2026-0009','WH-BLR','wh','WS-HYD','sc','10-Apr-2026','10-Apr-2026',null,'pending',3,15],
                                ['TRF-2026-0008','WH-BLR','wh','WS-HYD','sc','10-Apr-2026','10-Apr-2026',null,'transit',4,22],
                                ['TRF-2026-0007','WH-HYD','wh','WS-HYD','sc','09-Apr-2026','09-Apr-2026',null,'transit',2,8],
                                ['TRF-2026-0006','WH-PNE','wh','WH-HYD','wh','08-Apr-2026','08-Apr-2026',null,'transit',6,50],
                                ['TRF-2026-0005','WH-BLR','wh','WS-HYD','sc','07-Apr-2026','07-Apr-2026','09-Apr-2026','received',5,34],
                                ['TRF-2026-0004','WH-HYD','wh','WS-HYD','sc','05-Apr-2026','05-Apr-2026','07-Apr-2026','received',3,18],
                                ['TRF-2026-0003','WH-BLR','wh','WS-HYD','sc','02-Apr-2026','02-Apr-2026','04-Apr-2026','received',7,42],
                            ];
                            $trMap   = ['pending'=>'sc-tr-pending','transit'=>'sc-tr-transit','received'=>'sc-tr-received','cancelled'=>'sc-tr-cancelled'];
                            $trLabel = ['pending'=>'Pending Dispatch','transit'=>'In Transit','received'=>'Received','cancelled'=>'Cancelled'];
                            @endphp
                            @foreach($transfers as $t)
                            <tr>
                                <td class="fw-semibold" style="font-size:12px;color:#032671;">{{ $t[0] }}</td>
                                <td><span class="loc-badge loc-badge-{{ $t[2] }}"><i class="uil {{ $t[2]==='wh' ? 'uil-warehouse' : 'uil-wrench' }}"></i> {{ $t[1] }}</span></td>
                                <td><span class="loc-badge loc-badge-{{ $t[4] }}"><i class="uil {{ $t[4]==='wh' ? 'uil-warehouse' : 'uil-wrench' }}"></i> {{ $t[3] }}</span></td>
                                <td style="font-size:12px;">{{ $t[9] }} items</td>
                                <td style="font-size:12px;font-weight:600;">{{ $t[10] }} units</td>
                                <td class="text-nowrap" style="font-size:12px;">{{ $t[5] }}</td>
                                <td class="text-nowrap" style="font-size:12px;">{{ $t[6] ?? '—' }}</td>
                                <td class="text-nowrap" style="font-size:12px;">{{ $t[7] ?? '<span class="text-muted">—</span>' }}</td>
                                <td><span class="{{ $trMap[$t[8]] }}">{{ $trLabel[$t[8]] }}</span></td>
                                <td class="text-center">
                                    <div class="sc-row-actions">
                                        <button class="sc-action-btn" title="View Details" data-bs-toggle="modal" data-bs-target="#viewTransferModal"><i class="uil uil-eye"></i></button>
                                        @if($t[8] === 'pending')
                                        <button class="sc-action-btn" title="Dispatch Now" style="color:#032671;border-color:#032671;"><i class="uil uil-truck"></i></button>
                                        <button class="sc-action-btn sc-action-btn-danger" title="Cancel"><i class="uil uil-times-circle"></i></button>
                                        @endif
                                        @if($t[8] === 'transit')
                                        <button class="sc-action-btn" title="Confirm Receipt" data-bs-toggle="modal" data-bs-target="#receiveTransferModal" style="color:#10863f;border-color:#10863f;"><i class="uil uil-check-circle"></i></button>
                                        @endif
                                        <button class="sc-action-btn" title="Print Challan"><i class="uil uil-print"></i></button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- New Transfer Modal --}}
<div class="modal fade" id="newTransferModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title"><i class="uil uil-exchange-alt me-2"></i>Create Stock Transfer</h6>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="sc-form-label">Transfer From <span class="text-danger">*</span></label>
                        <select class="form-select form-select-sm" id="trFrom">
                            <option value="">— Select source location —</option>
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
                    <div class="col-md-6">
                        <label class="sc-form-label">Transfer To <span class="text-danger">*</span></label>
                        <select class="form-select form-select-sm" id="trTo">
                            <option value="">— Select destination location —</option>
                            <optgroup label="Workshops">
                                <option value="WS-HYD">WS-HYD — SC Bangalore</option>
                                <option value="WS-HYD">WS-HYD — SC Hyderabad</option>
                            </optgroup>
                            <optgroup label="Warehouses">
                                <option value="WH-BLR">WH-BLR — Warehouse Bangalore</option>
                                <option value="WH-HYD">WH-HYD — Warehouse Hyderabad</option>
                                <option value="WH-PNE">WH-PNE — Warehouse Pune</option>
                            </optgroup>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="sc-form-label">Transfer Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-6">
                        <label class="sc-form-label">Reference / Notes</label>
                        <input type="text" class="form-control form-control-sm" placeholder="Job Card ref, reason, etc.">
                    </div>
                </div>

                {{-- Items --}}
                <div class="sc-ins-detail-label mb-2">Items to Transfer</div>
                <table class="table sc-table table-sm mb-2" id="trItemsTable">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th style="width:80px;" class="text-center">Available</th>
                            <th style="width:100px;">Transfer Qty</th>
                            <th style="width:80px;">Unit</th>
                            <th style="width:36px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="tr-item-row">
                            <td>
                                <select class="form-select form-select-sm select2-tr-item">
                                    <option value="">— Select item —</option>
                                    <option>Engine Oil 20W-50 (Castrol)</option>
                                    <option>Brake Pads — Tata Prima</option>
                                    <option>Oil Filter — Tata Prima 4928</option>
                                    <option>Air Filter — Bharat Benz 2523</option>
                                </select>
                            </td>
                            <td class="text-center" style="font-size:12px;color:#6c757d;">—</td>
                            <td><input type="number" class="form-control form-control-sm text-end" min="1" placeholder="0"></td>
                            <td style="font-size:12px;color:#6c757d;">pcs</td>
                            <td><button type="button" class="btn btn-link text-danger btn-sm p-0 tr-remove-row"><i class="uil uil-trash-alt"></i></button></td>
                        </tr>
                    </tbody>
                </table>
                <button type="button" class="btn btn-outline-secondary btn-sm" id="trAddRow"><i class="uil uil-plus me-1"></i>Add Item</button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn sc-btn-navy btn-sm">Create Transfer</button>
            </div>
        </div>
    </div>
</div>

{{-- Receive Transfer Modal --}}
<div class="modal fade" id="receiveTransferModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title"><i class="uil uil-check-circle me-2"></i>Confirm Receipt — TRF-2026-0008</h6>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="sc-ext-return-summary mb-3" style="background:#f8f9fc;border:1px solid #e4e7ef;border-radius:6px;padding:10px 14px;">
                    <div class="d-flex gap-4">
                        <div>
                            <div style="font-size:10px;color:#adb5bd;font-weight:700;text-transform:uppercase;">From</div>
                            <span class="loc-badge loc-badge-wh mt-1 d-inline-block"><i class="uil uil-warehouse"></i> WH-BLR</span>
                        </div>
                        <div style="align-self:center;color:#adb5bd;">→</div>
                        <div>
                            <div style="font-size:10px;color:#adb5bd;font-weight:700;text-transform:uppercase;">To</div>
                            <span class="loc-badge loc-badge-sc mt-1 d-inline-block"><i class="uil uil-wrench"></i> WS-HYD</span>
                        </div>
                    </div>
                </div>
                <table class="table sc-table table-sm mb-3">
                    <thead><tr><th>Item</th><th class="text-center">Expected Qty</th><th class="text-center">Received Qty</th></tr></thead>
                    <tbody>
                        <tr>
                            <td style="font-size:12px;">Engine Oil 20W-50 (Castrol)</td>
                            <td class="text-center" style="font-size:12px;">12 ltr</td>
                            <td class="text-center"><input type="number" class="form-control form-control-sm text-center" style="width:70px;margin:auto;" value="12"></td>
                        </tr>
                        <tr>
                            <td style="font-size:12px;">Brake Pads — Front</td>
                            <td class="text-center" style="font-size:12px;">4 set</td>
                            <td class="text-center"><input type="number" class="form-control form-control-sm text-center" style="width:70px;margin:auto;" value="4"></td>
                        </tr>
                    </tbody>
                </table>
                <div class="row g-2">
                    <div class="col-12">
                        <label class="sc-form-label">Received By</label>
                        <input type="text" class="form-control form-control-sm" placeholder="Name of staff receiving">
                    </div>
                    <div class="col-12">
                        <label class="sc-form-label">Remarks</label>
                        <textarea class="form-control form-control-sm" rows="2" placeholder="Any shortage or damage notes..."></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-sm" style="background:#10863f;border-color:#10863f;color:#fff;">Confirm Receipt</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script>
$(function() {
    $('.select2-tr-item').select2({ width: '100%', dropdownParent: $('#newTransferModal') });

    $('#trAddRow').on('click', function() {
        var row = $('.tr-item-row:first').clone();
        row.find('select').val('').trigger('change');
        row.find('input[type=number]').val('');
        row.find('.select2-tr-item').select2({ width: '100%', dropdownParent: $('#newTransferModal') });
        $('#trItemsTable tbody').append(row);
    });

    $(document).on('click', '.tr-remove-row', function() {
        if ($('.tr-item-row').length > 1) $(this).closest('tr').remove();
    });

    // Prevent same location from/to
    $('#trTo').on('change', function() {
        var from = $('#trFrom').val();
        if ($(this).val() === from && from !== '') {
            Swal.fire({ icon: 'warning', title: 'Same Location', text: 'Transfer From and Transfer To cannot be the same location.', timer: 2500, showConfirmButton: false });
            $(this).val('');
        }
    });
});
</script>
@endsection
