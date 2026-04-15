@extends('layouts.app')

@section('css')
<link href="{{ asset('css/Workshop/Master/maintenance-items.css?v=1.0') }}" rel="stylesheet">
@endsection

@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="wrapper srlog-bdwrapper">
        <div class="side-wrap">
            @include('includes.leftbar')
            <div class="main-wrap">

                <div class="container-fluid page-head">
                    <div class="row align-items-center">
                        <div class="col-12 d-flex flex-wrap align-items-center gap-2">
                            <h5 class="mb-0 me-1">Maintenance Items</h5>
                            <button class="btn btn-theme btn-sm" data-bs-toggle="modal" data-bs-target="#addMiModal">
                                <i class="uil uil-plus me-1"></i> Add Item
                            </button>
                            <select class="form-select form-select-sm" id="filterMiCategory" style="width:140px;">
                                <option value="">All Categories</option>
                                <option>Engine</option>
                                <option>Brakes</option>
                                <option>Filters</option>
                                <option>Tyres</option>
                                <option>Electrical</option>
                                <option>Transmission</option>
                                <option>Cooling System</option>
                                <option>Suspension</option>
                            </select>
                            <select class="form-select form-select-sm" id="filterMiInterval" style="width:120px;">
                                <option value="">All Intervals</option>
                                <option>KM</option>
                                <option>Days</option>
                                <option>KM + Days</option>
                            </select>
                            <select class="form-select form-select-sm" id="filterMiStatus" style="width:120px;">
                                <option value="">All Status</option>
                                <option>Active</option>
                                <option>Inactive</option>
                            </select>
                            <input type="text" class="form-control form-control-sm" id="filterMiSearch" placeholder="Search item…" style="width:160px;">
                            <button class="btn btn-primary btn-sm" id="btnClearMi">
                                <i class="uil uil-history me-1"></i> Reset
                            </button>
                        </div>
                    </div>
                </div>

                <div class="table-responsive mt-3">
                    <table class="table table-hover invoice-table mb-0" id="miTable">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Maintenance Item</th>
                                <th>Category</th>
                                <th>Interval Type</th>
                                <th>Default Interval</th>
                                <th>Early Warning</th>
                                <th>Linked Service</th>
                                <th>Status</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $items = [
                                // [Code, Name, Category, Interval Type, Default Interval, Early Warning, Linked Service, Status]
                                ['MI-001', 'Engine Oil Change',           'Engine',         'KM + Days', '10,000 KM / 90 Days',  '500 KM / 7 Days',   'SVC-001', 'Active'],
                                ['MI-002', 'Oil Filter Replacement',      'Filters',        'KM + Days', '10,000 KM / 90 Days',  '500 KM / 7 Days',   'SVC-002', 'Active'],
                                ['MI-003', 'Air Filter Replacement',      'Filters',        'KM',        '20,000 KM',            '1,000 KM',          'SVC-003', 'Active'],
                                ['MI-004', 'Fuel Filter Replacement',     'Filters',        'KM',        '40,000 KM',            '2,000 KM',          'SVC-004', 'Active'],
                                ['MI-005', 'Brake Pad Check & Replace',   'Brakes',         'KM',        '30,000 KM',            '2,000 KM',          'SVC-005', 'Active'],
                                ['MI-006', 'Tyre Rotation',               'Tyres',          'KM',        '10,000 KM',            '500 KM',            'SVC-004', 'Active'],
                                ['MI-007', 'Wheel Alignment & Balancing', 'Tyres',          'KM + Days', '20,000 KM / 180 Days', '1,000 KM / 10 Days','SVC-010', 'Active'],
                                ['MI-008', 'Battery Check',               'Electrical',     'Days',      '180 Days',             '14 Days',           'SVC-006', 'Active'],
                                ['MI-009', 'Coolant Flush & Refill',      'Cooling System', 'KM + Days', '40,000 KM / 365 Days', '2,000 KM / 15 Days','SVC-001', 'Active'],
                                ['MI-010', 'Gear Oil Change',             'Transmission',   'KM',        '40,000 KM',            '2,000 KM',          '—',       'Active'],
                                ['MI-011', 'Clutch Adjustment Check',     'Transmission',   'KM',        '15,000 KM',            '1,000 KM',          '—',       'Active'],
                                ['MI-012', 'Full Vehicle Inspection',     'Engine',         'Days',      '90 Days',              '7 Days',            'SVC-008', 'Active'],
                                ['MI-013', 'AC Gas & Filter Service',     'Cooling System', 'Days',      '365 Days',             '30 Days',           'SVC-007', 'Active'],
                                ['MI-014', 'Shock Absorber Inspection',   'Suspension',     'KM',        '50,000 KM',            '3,000 KM',          '—',       'Active'],
                            ];
                            $intervalColors = [
                                'KM'         => 'bg-primary',
                                'Days'       => 'bg-warning text-dark',
                                'KM + Days'  => 'bg-info text-dark',
                            ];
                            @endphp
                            @foreach($items as $mi)
                            <tr
                                data-category="{{ strtolower($mi[2]) }}"
                                data-interval="{{ strtolower($mi[3]) }}"
                                data-status="{{ strtolower($mi[7]) }}"
                                data-name="{{ strtolower($mi[1]) }}">
                                <td><span class="fw-bold" style="color:#032671;font-size:12px;">{{ $mi[0] }}</span></td>
                                <td class="fw-semibold">{{ $mi[1] }}</td>
                                <td style="font-size:13px;">{{ $mi[2] }}</td>
                                <td>
                                    <span class="badge {{ $intervalColors[$mi[3]] ?? 'bg-secondary' }}">{{ $mi[3] }}</span>
                                </td>
                                <td style="font-size:12px;">{{ $mi[4] }}</td>
                                <td style="font-size:12px;color:#777;">{{ $mi[5] }}</td>
                                <td style="font-size:12px;color:#032671;">{{ $mi[6] }}</td>
                                <td><span class="badge bg-{{ $mi[7]==='Active' ? 'success' : 'secondary' }}">{{ $mi[7] }}</span></td>
                                <td class="text-end">
                                    <div class="dropdown dot-dd">
                                        <span class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="uil uil-ellipsis-h"></i></span>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a class="dropdown-item btn-edit-mi" href="javascript:void(0)"
                                                data-code="{{ $mi[0] }}" data-name="{{ $mi[1] }}" data-category="{{ $mi[2] }}"
                                                data-intervaltype="{{ $mi[3] }}" data-interval="{{ $mi[4] }}"
                                                data-warning="{{ $mi[5] }}" data-linked="{{ $mi[6] }}" data-status="{{ $mi[7] }}"
                                                data-bs-toggle="modal" data-bs-target="#editMiModal">
                                                <i class="uil uil-pen me-2"></i>Edit
                                            </a></li>
                                            <li><a class="dropdown-item btn-toggle-mi text-{{ $mi[7]==='Active' ? 'danger' : 'success' }}"
                                                href="javascript:void(0)" data-name="{{ $mi[1] }}" data-current="{{ $mi[7] }}">
                                                <i class="uil uil-{{ $mi[7]==='Active' ? 'ban' : 'check-circle' }} me-2"></i>
                                                {{ $mi[7]==='Active' ? 'Deactivate' : 'Activate' }}
                                            </a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="px-3 py-2 border-top mt-2">
                    <small class="text-muted" id="miCount">Showing {{ count($items) }} maintenance items</small>
                </div>

            </div>
        </div>
    </div>
</div>

{{-- Add Modal --}}
<div class="modal fade" id="addMiModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fw-semibold"><i class="uil uil-tools me-2"></i>Add Maintenance Item</h6>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Item Code <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="addMiCode" placeholder="e.g. MI-015">
                    </div>
                    <div class="col-md-8">
                        <label class="form-label fw-semibold">Maintenance Item Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="addMiName" placeholder="e.g. Power Steering Fluid Change">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
                        <select class="form-select" id="addMiCategory">
                            <option value="">— Select —</option>
                            <option>Engine</option>
                            <option>Brakes</option>
                            <option>Filters</option>
                            <option>Tyres</option>
                            <option>Electrical</option>
                            <option>Transmission</option>
                            <option>Cooling System</option>
                            <option>Suspension</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Interval Type <span class="text-danger">*</span></label>
                        <select class="form-select" id="addMiIntervalType">
                            <option>KM</option>
                            <option>Days</option>
                            <option>KM + Days</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Default Interval</label>
                        <input type="text" class="form-control" id="addMiInterval" placeholder="e.g. 10,000 KM / 90 Days">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Early Warning Threshold</label>
                        <input type="text" class="form-control" id="addMiWarning" placeholder="e.g. 500 KM / 7 Days">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Linked Service Code</label>
                        <input type="text" class="form-control" id="addMiLinked" placeholder="e.g. SVC-001">
                        <div class="form-text">Optional — link to Services master.</div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Status</label>
                        <select class="form-select" id="addMiStatus">
                            <option>Active</option>
                            <option>Inactive</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Notes</label>
                        <textarea class="form-control" rows="2" placeholder="Additional notes for this maintenance item…"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-theme btn-sm" id="btnSaveMi"><i class="uil uil-save me-1"></i> Save</button>
            </div>
        </div>
    </div>
</div>

{{-- Edit Modal --}}
<div class="modal fade" id="editMiModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fw-semibold"><i class="uil uil-pen me-2"></i>Edit Maintenance Item</h6>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Item Code</label>
                        <input type="text" class="form-control" id="editMiCode" readonly>
                    </div>
                    <div class="col-md-8">
                        <label class="form-label fw-semibold">Item Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="editMiName">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Category</label>
                        <select class="form-select" id="editMiCategory">
                            <option>Engine</option><option>Brakes</option><option>Filters</option>
                            <option>Tyres</option><option>Electrical</option><option>Transmission</option>
                            <option>Cooling System</option><option>Suspension</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Interval Type</label>
                        <select class="form-select" id="editMiIntervalType">
                            <option>KM</option><option>Days</option><option>KM + Days</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Default Interval</label>
                        <input type="text" class="form-control" id="editMiInterval">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Early Warning</label>
                        <input type="text" class="form-control" id="editMiWarning">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Linked Service</label>
                        <input type="text" class="form-control" id="editMiLinked">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Status</label>
                        <select class="form-select" id="editMiStatus">
                            <option>Active</option><option>Inactive</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-theme btn-sm" id="btnUpdateMi"><i class="uil uil-save me-1"></i> Update</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
$(function () {

    /* ── Populate Edit modal ── */
    $(document).on('click', '.btn-edit-mi', function () {
        var b = $(this);
        $('#editMiCode').val(b.data('code'));
        $('#editMiName').val(b.data('name'));
        $('#editMiCategory').val(b.data('category'));
        $('#editMiIntervalType').val(b.data('intervaltype'));
        $('#editMiInterval').val(b.data('interval'));
        $('#editMiWarning').val(b.data('warning'));
        $('#editMiLinked').val(b.data('linked'));
        $('#editMiStatus').val(b.data('status'));
    });

    /* ── Save / Update ── */
    $('#btnSaveMi').on('click', function () {
        if (!$('#addMiCode').val().trim() || !$('#addMiName').val().trim() || !$('#addMiCategory').val()) {
            Swal.fire({ icon:'warning', title:'Required Fields', text:'Please fill in Code, Name and Category.', confirmButtonColor:'#032671' });
            return;
        }
        Swal.fire({ icon:'success', title:'Item Saved', timer:1500, showConfirmButton:false });
        $('#addMiModal').modal('hide');
    });

    $('#btnUpdateMi').on('click', function () {
        Swal.fire({ icon:'success', title:'Updated', timer:1500, showConfirmButton:false });
        $('#editMiModal').modal('hide');
    });

    /* ── Toggle Status ── */
    $(document).on('click', '.btn-toggle-mi', function () {
        var name = $(this).data('name'), current = $(this).data('current');
        var action = current === 'Active' ? 'Deactivate' : 'Activate';
        Swal.fire({ title: action + ' Item?', text: '"' + name + '"', icon:'warning',
            showCancelButton:true,
            confirmButtonColor: current === 'Active' ? '#ea0027' : '#10863f',
            confirmButtonText: action })
            .then(r => { if (r.isConfirmed) Swal.fire({ icon:'success', title:'Done', timer:1400, showConfirmButton:false }); });
    });

    /* ── Client-side filter ── */
    function filterMi() {
        var cat      = $('#filterMiCategory').val().toLowerCase();
        var interval = $('#filterMiInterval').val().toLowerCase();
        var status   = $('#filterMiStatus').val().toLowerCase();
        var search   = $('#filterMiSearch').val().toLowerCase();
        var count = 0;
        $('#miTable tbody tr').each(function () {
            var $tr = $(this);
            var match = true;
            if (cat      && $tr.data('category').indexOf(cat)      === -1) match = false;
            if (interval && $tr.data('interval').indexOf(interval) === -1) match = false;
            if (status   && $tr.data('status').indexOf(status)     === -1) match = false;
            if (search   && $tr.data('name').indexOf(search)       === -1) match = false;
            $tr.toggle(match);
            if (match) count++;
        });
        $('#miCount').text('Showing ' + count + ' maintenance items');
    }

    $('#filterMiCategory,#filterMiInterval,#filterMiStatus').on('change', filterMi);
    $('#filterMiSearch').on('keyup', filterMi);

    $('#btnClearMi').on('click', function () {
        $('#filterMiCategory,#filterMiInterval,#filterMiStatus').val('');
        $('#filterMiSearch').val('');
        filterMi();
    });
});
</script>
@endsection
