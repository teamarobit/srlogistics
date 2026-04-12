@extends('layouts.app')

@section('css')
<link href="{{ asset('css/Workshop/Master/service-key-points.css?v=1.0') }}" rel="stylesheet">
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
                            <h5 class="mb-0 me-1">Service Key Points</h5>
                            <button class="btn btn-theme btn-sm" data-bs-toggle="modal" data-bs-target="#addSkpModal">
                                <i class="uil uil-plus me-1"></i> Add Key Point
                            </button>
                            <select class="form-select form-select-sm" id="filterSkpPhase" style="width:140px;">
                                <option value="">All Phases</option>
                                <option>Pre-Service</option>
                                <option>During Service</option>
                                <option>Post-Service</option>
                                <option>Delivery Check</option>
                            </select>
                            <select class="form-select form-select-sm" id="filterSkpCategory" style="width:140px;">
                                <option value="">All Categories</option>
                                <option>Engine</option>
                                <option>Brakes</option>
                                <option>Electrical</option>
                                <option>Tyres</option>
                                <option>Body</option>
                                <option>Fluid Levels</option>
                                <option>Safety</option>
                            </select>
                            <select class="form-select form-select-sm" id="filterSkpType" style="width:120px;">
                                <option value="">All Types</option>
                                <option>Mandatory</option>
                                <option>Optional</option>
                            </select>
                            <input type="text" class="form-control form-control-sm" id="filterSkpSearch" placeholder="Search…" style="width:160px;">
                            <button class="btn btn-primary btn-sm" id="btnClearSkp">
                                <i class="uil uil-history me-1"></i> Reset
                            </button>
                        </div>
                    </div>
                </div>

                <div class="table-responsive mt-3">
                    <table class="table table-hover invoice-table mb-0" id="skpTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Key Point</th>
                                <th>Phase</th>
                                <th>Category</th>
                                <th>Type</th>
                                <th>Input Method</th>
                                <th>Status</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $keypoints = [
                                ['SKP-001', 'Check Engine Oil Level',            'Pre-Service',    'Fluid Levels', 'Mandatory', 'Pass/Fail + Reading'],
                                ['SKP-002', 'Inspect Air Filter Condition',       'Pre-Service',    'Engine',       'Mandatory', 'Pass/Fail'],
                                ['SKP-003', 'Brake Fluid Level Check',            'Pre-Service',    'Brakes',       'Mandatory', 'Pass/Fail + Reading'],
                                ['SKP-004', 'Tyre Tread Depth Measurement',       'Pre-Service',    'Tyres',        'Mandatory', 'Numeric (mm)'],
                                ['SKP-005', 'Battery Voltage Test',               'Pre-Service',    'Electrical',   'Mandatory', 'Numeric (V)'],
                                ['SKP-006', 'Coolant Level Check',                'During Service', 'Fluid Levels', 'Mandatory', 'Pass/Fail + Reading'],
                                ['SKP-007', 'Brake Pad Thickness (Front/Rear)',   'During Service', 'Brakes',       'Mandatory', 'Numeric (mm)'],
                                ['SKP-008', 'Oil Drain & Fill Verification',      'During Service', 'Engine',       'Mandatory', 'Pass/Fail'],
                                ['SKP-009', 'Torque Check — Wheel Nuts',          'During Service', 'Tyres',        'Mandatory', 'Numeric (Nm)'],
                                ['SKP-010', 'Windshield & Wiper Check',           'Post-Service',   'Safety',       'Optional',  'Pass/Fail'],
                                ['SKP-011', 'Road Test — Braking Performance',    'Post-Service',   'Brakes',       'Mandatory', 'Pass/Fail'],
                                ['SKP-012', 'Exterior Walk-Around Inspection',    'Delivery Check', 'Body',         'Mandatory', 'Pass/Fail + Remarks'],
                                ['SKP-013', 'All Fluids Topped Off Confirmation', 'Delivery Check', 'Fluid Levels', 'Mandatory', 'Pass/Fail'],
                                ['SKP-014', 'Customer Signature on Job Card',     'Delivery Check', 'Safety',       'Mandatory', 'Signature'],
                            ];
                            $phaseColors = [
                                'Pre-Service'    => 'bg-secondary',
                                'During Service' => 'bg-primary',
                                'Post-Service'   => 'bg-info text-dark',
                                'Delivery Check' => 'bg-success',
                            ];
                            @endphp
                            @foreach($keypoints as $kp)
                            <tr data-phase="{{ strtolower($kp[2]) }}" data-category="{{ strtolower($kp[3]) }}" data-type="{{ strtolower($kp[4]) }}" data-status="active" data-name="{{ strtolower($kp[1]) }}">
                                <td><span class="fw-bold" style="color:#032671;font-size:12px;">{{ $kp[0] }}</span></td>
                                <td class="fw-semibold">{{ $kp[1] }}</td>
                                <td>
                                    <span class="badge {{ $phaseColors[$kp[2]] ?? 'bg-secondary' }}">{{ $kp[2] }}</span>
                                </td>
                                <td style="font-size:13px;">{{ $kp[3] }}</td>
                                <td>
                                    <span class="badge {{ $kp[4]==='Mandatory' ? 'bg-danger' : 'bg-light text-dark border' }}">{{ $kp[4] }}</span>
                                </td>
                                <td style="font-size:12px;color:#555;">{{ $kp[5] }}</td>
                                <td><span class="badge bg-success">Active</span></td>
                                <td class="text-end">
                                    <div class="dropdown dot-dd">
                                        <span class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="uil uil-ellipsis-h"></i></span>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a class="dropdown-item btn-edit-skp" href="javascript:void(0)"
                                                data-code="{{ $kp[0] }}" data-name="{{ $kp[1] }}" data-phase="{{ $kp[2] }}"
                                                data-category="{{ $kp[3] }}" data-type="{{ $kp[4] }}" data-input="{{ $kp[5] }}"
                                                data-status="Active"
                                                data-bs-toggle="modal" data-bs-target="#editSkpModal">
                                                <i class="uil uil-pen me-2"></i>Edit
                                            </a></li>
                                            <li><a class="dropdown-item btn-toggle-skp text-danger" href="javascript:void(0)"
                                                data-name="{{ $kp[1] }}" data-current="Active">
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
                    <small class="text-muted" id="skpCount">Showing {{ count($keypoints) }} key points</small>
                </div>

            </div>
        </div>
    </div>
</div>

{{-- Add Modal --}}
<div class="modal fade" id="addSkpModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fw-semibold"><i class="uil uil-clipboard-alt me-2"></i>Add Service Key Point</h6>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Key Point Code <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="addSkpCode" placeholder="e.g. SKP-015">
                    </div>
                    <div class="col-md-8">
                        <label class="form-label fw-semibold">Key Point Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="addSkpName" placeholder="e.g. Transmission Fluid Check">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Phase <span class="text-danger">*</span></label>
                        <select class="form-select" id="addSkpPhase">
                            <option value="">— Select —</option>
                            <option>Pre-Service</option>
                            <option>During Service</option>
                            <option>Post-Service</option>
                            <option>Delivery Check</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
                        <select class="form-select" id="addSkpCategory">
                            <option value="">— Select —</option>
                            <option>Engine</option>
                            <option>Brakes</option>
                            <option>Electrical</option>
                            <option>Tyres</option>
                            <option>Body</option>
                            <option>Fluid Levels</option>
                            <option>Safety</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Type</label>
                        <select class="form-select" id="addSkpType">
                            <option>Mandatory</option>
                            <option>Optional</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Input Method</label>
                        <select class="form-select" id="addSkpInput">
                            <option>Pass/Fail</option>
                            <option>Pass/Fail + Reading</option>
                            <option>Pass/Fail + Remarks</option>
                            <option>Numeric (mm)</option>
                            <option>Numeric (V)</option>
                            <option>Numeric (Nm)</option>
                            <option>Signature</option>
                            <option>Text / Remarks</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Status</label>
                        <select class="form-select" id="addSkpStatus">
                            <option>Active</option>
                            <option>Inactive</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Notes / Guidance</label>
                        <textarea class="form-control" rows="2" placeholder="Guidance for the technician performing this check…"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-theme btn-sm" id="btnSaveSkp"><i class="uil uil-save me-1"></i> Save</button>
            </div>
        </div>
    </div>
</div>

{{-- Edit Modal --}}
<div class="modal fade" id="editSkpModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fw-semibold"><i class="uil uil-pen me-2"></i>Edit Key Point</h6>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Code</label>
                        <input type="text" class="form-control" id="editSkpCode" readonly>
                    </div>
                    <div class="col-md-8">
                        <label class="form-label fw-semibold">Key Point Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="editSkpName">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Phase</label>
                        <select class="form-select" id="editSkpPhase">
                            <option>Pre-Service</option>
                            <option>During Service</option>
                            <option>Post-Service</option>
                            <option>Delivery Check</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Category</label>
                        <select class="form-select" id="editSkpCategory">
                            <option>Engine</option>
                            <option>Brakes</option>
                            <option>Electrical</option>
                            <option>Tyres</option>
                            <option>Body</option>
                            <option>Fluid Levels</option>
                            <option>Safety</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Type</label>
                        <select class="form-select" id="editSkpType">
                            <option>Mandatory</option>
                            <option>Optional</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Input Method</label>
                        <select class="form-select" id="editSkpInput">
                            <option>Pass/Fail</option>
                            <option>Pass/Fail + Reading</option>
                            <option>Pass/Fail + Remarks</option>
                            <option>Numeric (mm)</option>
                            <option>Numeric (V)</option>
                            <option>Numeric (Nm)</option>
                            <option>Signature</option>
                            <option>Text / Remarks</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Status</label>
                        <select class="form-select" id="editSkpStatus">
                            <option>Active</option>
                            <option>Inactive</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-theme btn-sm" id="btnUpdateSkp"><i class="uil uil-save me-1"></i> Update</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
$(function () {
    $(document).on('click', '.btn-edit-skp', function () {
        var b = $(this);
        $('#editSkpCode').val(b.data('code'));
        $('#editSkpName').val(b.data('name'));
        $('#editSkpPhase').val(b.data('phase'));
        $('#editSkpCategory').val(b.data('category'));
        $('#editSkpType').val(b.data('type'));
        $('#editSkpInput').val(b.data('input'));
        $('#editSkpStatus').val(b.data('status'));
    });

    $('#btnSaveSkp').on('click', function () {
        if (!$('#addSkpCode').val().trim() || !$('#addSkpName').val().trim() || !$('#addSkpPhase').val() || !$('#addSkpCategory').val()) {
            Swal.fire({ icon:'warning', title:'Required Fields', text:'Please fill in Code, Name, Phase and Category.', confirmButtonColor:'#032671' });
            return;
        }
        Swal.fire({ icon:'success', title:'Key Point Saved', timer:1500, showConfirmButton:false });
        $('#addSkpModal').modal('hide');
    });

    $('#btnUpdateSkp').on('click', function () {
        Swal.fire({ icon:'success', title:'Updated', timer:1500, showConfirmButton:false });
        $('#editSkpModal').modal('hide');
    });

    $(document).on('click', '.btn-toggle-skp', function () {
        var name = $(this).data('name'), current = $(this).data('current');
        var action = current === 'Active' ? 'Deactivate' : 'Activate';
        Swal.fire({ title: action + ' Key Point?', text: '"' + name + '"', icon:'warning',
            showCancelButton:true,
            confirmButtonColor: current === 'Active' ? '#ea0027' : '#10863f',
            confirmButtonText: action })
            .then(r => { if (r.isConfirmed) Swal.fire({ icon:'success', title:'Done', timer:1400, showConfirmButton:false }); });
    });

    /* ── Client-side filter ── */
    function filterSkp() {
        var phase    = $('#filterSkpPhase').val().toLowerCase();
        var category = $('#filterSkpCategory').val().toLowerCase();
        var type     = $('#filterSkpType').val().toLowerCase();
        var search   = $('#filterSkpSearch').val().toLowerCase();
        var count    = 0;
        $('#skpTable tbody tr').each(function () {
            var $tr = $(this);
            var match = true;
            if (phase    && $tr.data('phase').indexOf(phase)       === -1) match = false;
            if (category && $tr.data('category').indexOf(category) === -1) match = false;
            if (type     && $tr.data('type').indexOf(type)         === -1) match = false;
            if (search   && $tr.data('name').indexOf(search)       === -1) match = false;
            $tr.toggle(match);
            if (match) count++;
        });
        $('#skpCount').text('Showing ' + count + ' key points');
    }

    $('#filterSkpPhase,#filterSkpCategory,#filterSkpType').on('change', filterSkp);
    $('#filterSkpSearch').on('keyup', filterSkp);

    $('#btnClearSkp').on('click', function () {
        $('#filterSkpPhase,#filterSkpCategory,#filterSkpType').val('');
        $('#filterSkpSearch').val('');
        filterSkp();
    });
});
</script>
@endsection
