@extends('layouts.app')

@section('css')
<link href="{{ asset('css/Workshop/Master/services.css?v=1.0') }}" rel="stylesheet">
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
                            <h5 class="mb-0 me-1">Services</h5>
                            <button class="btn btn-theme btn-sm" data-bs-toggle="modal" data-bs-target="#addServiceModal">
                                <i class="uil uil-plus me-1"></i> Add Service
                            </button>
                            <select class="form-select form-select-sm" id="filterSvcCategory" style="width:160px;">
                                <option value="">All Categories</option>
                                <option>Preventive Maintenance</option>
                                <option>Corrective Repair</option>
                                <option>Electrical</option>
                                <option>Body & Paint</option>
                                <option>Tyres & Wheels</option>
                                <option>Inspection</option>
                            </select>
                            <select class="form-select form-select-sm" id="filterSvcStatus" style="width:120px;">
                                <option value="">All Status</option>
                                <option>Active</option>
                                <option>Inactive</option>
                            </select>
                            <input type="text" class="form-control form-control-sm" id="filterSvcSearch" placeholder="Search service name…" style="width:180px;">
                            <button class="btn btn-primary btn-sm" id="btnClearSvc">
                                <i class="uil uil-history me-1"></i> Reset
                            </button>
                        </div>
                    </div>
                </div>

                <div class="table-responsive mt-3">
                    <table class="table table-hover invoice-table mb-0" id="svcTable">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Service Name</th>
                                <th>Category</th>
                                <th>Est. Time</th>
                                <th>Labour Rate (₹/hr)</th>
                                <th>Applicable To</th>
                                <th>Status</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $services = [
                                ['SVC-001', 'Engine Oil Change',             'Preventive Maintenance', '1.0 hr',  '450',  'All Vehicles'],
                                ['SVC-002', 'Oil Filter Replacement',        'Preventive Maintenance', '0.5 hr',  '450',  'All Vehicles'],
                                ['SVC-003', 'Air Filter Cleaning/Replace',   'Preventive Maintenance', '0.5 hr',  '400',  'All Vehicles'],
                                ['SVC-004', 'Tyre Rotation & Balancing',     'Tyres & Wheels',         '1.5 hr',  '380',  'All Vehicles'],
                                ['SVC-005', 'Brake Pad Replacement (Front)', 'Corrective Repair',      '2.0 hr',  '500',  'HCV / LCV'],
                                ['SVC-006', 'Battery Check & Replacement',   'Electrical',             '0.5 hr',  '420',  'All Vehicles'],
                                ['SVC-007', 'AC Service & Gas Recharge',     'Electrical',             '2.5 hr',  '480',  'All Vehicles'],
                                ['SVC-008', 'Full Vehicle Inspection',       'Inspection',             '2.0 hr',  '350',  'All Vehicles'],
                                ['SVC-009', 'Denting & Painting (Panel)',    'Body & Paint',           '4.0 hr',  '600',  'All Vehicles'],
                                ['SVC-010', 'Wheel Alignment',               'Tyres & Wheels',         '1.0 hr',  '380',  'All Vehicles'],
                            ];
                            $catColors = [
                                'Preventive Maintenance' => 'bg-primary',
                                'Corrective Repair'      => 'bg-danger',
                                'Electrical'             => 'bg-warning text-dark',
                                'Body & Paint'           => 'bg-info text-dark',
                                'Tyres & Wheels'         => 'bg-secondary',
                                'Inspection'             => 'bg-success',
                            ];
                            @endphp
                            @foreach($services as $svc)
                            <tr data-category="{{ strtolower($svc[2]) }}" data-status="active" data-name="{{ strtolower($svc[1]) }}">
                                <td><span class="fw-bold" style="color:#032671;font-size:12px;">{{ $svc[0] }}</span></td>
                                <td class="fw-semibold">{{ $svc[1] }}</td>
                                <td>
                                    <span class="badge {{ $catColors[$svc[2]] ?? 'bg-secondary' }}">{{ $svc[2] }}</span>
                                </td>
                                <td>{{ $svc[3] }}</td>
                                <td>₹ {{ $svc[4] }}</td>
                                <td style="font-size:12px;color:#555;">{{ $svc[5] }}</td>
                                <td><span class="badge bg-success">Active</span></td>
                                <td class="text-end">
                                    <div class="dropdown dot-dd">
                                        <span class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="uil uil-ellipsis-h"></i></span>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a class="dropdown-item btn-edit-svc" href="javascript:void(0)"
                                                data-code="{{ $svc[0] }}" data-name="{{ $svc[1] }}" data-category="{{ $svc[2] }}"
                                                data-time="{{ $svc[3] }}" data-rate="{{ $svc[4] }}" data-applicable="{{ $svc[5] }}"
                                                data-status="Active"
                                                data-bs-toggle="modal" data-bs-target="#editServiceModal">
                                                <i class="uil uil-pen me-2"></i>Edit
                                            </a></li>
                                            <li><a class="dropdown-item btn-toggle-svc text-danger" href="javascript:void(0)"
                                                data-name="{{ $svc[1] }}" data-current="Active">
                                                <i class="uil uil-ban me-2"></i>Deactivate
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
                    <small class="text-muted" id="svcCount">Showing {{ count($services) }} services</small>
                </div>

            </div>
        </div>
    </div>
</div>

{{-- Add Modal --}}
<div class="modal fade" id="addServiceModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fw-semibold"><i class="uil uil-wrench me-2"></i>Add Service</h6>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Service Code <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="addSvcCode" placeholder="e.g. SVC-011">
                        <div class="form-text">Short unique code.</div>
                    </div>
                    <div class="col-md-8">
                        <label class="form-label fw-semibold">Service Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="addSvcName" placeholder="e.g. Gear Box Oil Change">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
                        <select class="form-select" id="addSvcCategory">
                            <option value="">— Select —</option>
                            <option>Preventive Maintenance</option>
                            <option>Corrective Repair</option>
                            <option>Electrical</option>
                            <option>Body & Paint</option>
                            <option>Tyres & Wheels</option>
                            <option>Inspection</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Applicable To</label>
                        <select class="form-select" id="addSvcApplicable">
                            <option>All Vehicles</option>
                            <option>HCV / LCV</option>
                            <option>HCV Only</option>
                            <option>LCV Only</option>
                            <option>Trailer Only</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Estimated Time (hrs)</label>
                        <input type="text" class="form-control" id="addSvcTime" placeholder="e.g. 1.5">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Labour Rate (₹/hr)</label>
                        <input type="number" class="form-control" id="addSvcRate" placeholder="e.g. 450" min="0">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Status</label>
                        <select class="form-select" id="addSvcStatus">
                            <option>Active</option>
                            <option>Inactive</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Description / Notes</label>
                        <textarea class="form-control" rows="2" placeholder="Describe what this service includes…"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-theme btn-sm" id="btnSaveSvc"><i class="uil uil-save me-1"></i> Save</button>
            </div>
        </div>
    </div>
</div>

{{-- Edit Modal --}}
<div class="modal fade" id="editServiceModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fw-semibold"><i class="uil uil-pen me-2"></i>Edit Service</h6>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Service Code</label>
                        <input type="text" class="form-control" id="editSvcCode" readonly>
                    </div>
                    <div class="col-md-8">
                        <label class="form-label fw-semibold">Service Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="editSvcName">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Category</label>
                        <select class="form-select" id="editSvcCategory">
                            <option>Preventive Maintenance</option>
                            <option>Corrective Repair</option>
                            <option>Electrical</option>
                            <option>Body & Paint</option>
                            <option>Tyres & Wheels</option>
                            <option>Inspection</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Applicable To</label>
                        <select class="form-select" id="editSvcApplicable">
                            <option>All Vehicles</option>
                            <option>HCV / LCV</option>
                            <option>HCV Only</option>
                            <option>LCV Only</option>
                            <option>Trailer Only</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Estimated Time</label>
                        <input type="text" class="form-control" id="editSvcTime">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Labour Rate (₹/hr)</label>
                        <input type="number" class="form-control" id="editSvcRate" min="0">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Status</label>
                        <select class="form-select" id="editSvcStatus">
                            <option>Active</option>
                            <option>Inactive</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-theme btn-sm" id="btnUpdateSvc"><i class="uil uil-save me-1"></i> Update</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
$(function () {
    $(document).on('click', '.btn-edit-svc', function () {
        var b = $(this);
        $('#editSvcCode').val(b.data('code'));
        $('#editSvcName').val(b.data('name'));
        $('#editSvcCategory').val(b.data('category'));
        $('#editSvcTime').val(b.data('time'));
        $('#editSvcRate').val(b.data('rate'));
        $('#editSvcApplicable').val(b.data('applicable'));
        $('#editSvcStatus').val(b.data('status'));
    });

    $('#btnSaveSvc').on('click', function () {
        if (!$('#addSvcCode').val().trim() || !$('#addSvcName').val().trim() || !$('#addSvcCategory').val()) {
            Swal.fire({ icon:'warning', title:'Required Fields', text:'Please fill in Code, Name and Category.', confirmButtonColor:'#032671' });
            return;
        }
        Swal.fire({ icon:'success', title:'Service Saved', timer:1500, showConfirmButton:false });
        $('#addServiceModal').modal('hide');
    });

    $('#btnUpdateSvc').on('click', function () {
        Swal.fire({ icon:'success', title:'Updated', timer:1500, showConfirmButton:false });
        $('#editServiceModal').modal('hide');
    });

    $(document).on('click', '.btn-toggle-svc', function () {
        var name = $(this).data('name'), current = $(this).data('current');
        var action = current === 'Active' ? 'Deactivate' : 'Activate';
        Swal.fire({ title: action + ' Service?', text: '"' + name + '"', icon:'warning',
            showCancelButton:true,
            confirmButtonColor: current === 'Active' ? '#ea0027' : '#10863f',
            confirmButtonText: action })
            .then(r => { if (r.isConfirmed) Swal.fire({ icon:'success', title:'Done', timer:1400, showConfirmButton:false }); });
    });

    /* ── Client-side filter ── */
    function filterSvc() {
        var cat    = $('#filterSvcCategory').val().toLowerCase();
        var status = $('#filterSvcStatus').val().toLowerCase();
        var search = $('#filterSvcSearch').val().toLowerCase();
        var count  = 0;
        $('#svcTable tbody tr').each(function () {
            var $tr = $(this);
            var match = true;
            if (cat    && $tr.data('category').indexOf(cat)    === -1) match = false;
            if (status && $tr.data('status').indexOf(status)   === -1) match = false;
            if (search && $tr.data('name').indexOf(search)     === -1) match = false;
            $tr.toggle(match);
            if (match) count++;
        });
        $('#svcCount').text('Showing ' + count + ' services');
    }

    $('#filterSvcCategory,#filterSvcStatus').on('change', filterSvc);
    $('#filterSvcSearch').on('keyup', filterSvc);

    $('#btnClearSvc').on('click', function () {
        $('#filterSvcCategory,#filterSvcStatus').val('');
        $('#filterSvcSearch').val('');
        filterSvc();
    });
});
</script>
@endsection
