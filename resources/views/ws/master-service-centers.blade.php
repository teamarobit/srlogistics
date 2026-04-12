@extends('layouts.app')

@section('css')
<link href="{{ asset('css/Workshop/Master/service-centers.css?v=1.0') }}" rel="stylesheet">
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
                            <h5 class="mb-0 me-1">Workshops</h5>
                            <select class="form-select form-select-sm" id="filterScType" style="width:130px;">
                                <option value="">All Types</option>
                                <option>Workshop</option>
                                <option>Mobile Unit</option>
                                <option>Hybrid</option>
                            </select>
                            <select class="form-select form-select-sm" id="filterScStatus" style="width:120px;">
                                <option value="">All Status</option>
                                <option>Active</option>
                                <option>Inactive</option>
                            </select>
                            <input type="text" class="form-control form-control-sm" id="filterScSearch" placeholder="Search name / city…" style="width:170px;">
                            <button class="btn btn-primary btn-sm" id="btnClearSc">
                                <i class="uil uil-history me-1"></i> Reset
                            </button>
                        </div>
                    </div>
                </div>

                <div class="table-responsive mt-3">
                    <table class="table table-hover invoice-table mb-0" id="scTable">
                        <thead>
                            <tr>
                                <th>SC Code</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>City</th>
                                <th>Manager / Head</th>
                                <th>Contact</th>
                                <th>Technicians</th>
                                <th>Active Job Cards</th>
                                <th>Status</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $scs = [
                                ['WS-HYD', 'SR Logistics WS — Hyderabad',  'Workshop',    'Hyderabad', 'Venkat Rao',     '+91 98400 22001', 4,  5, 'Active'],
                            ];
                            @endphp
                            @foreach($scs as $sc)
                            <tr data-type="{{ strtolower($sc[2]) }}" data-status="{{ strtolower($sc[8]) }}" data-name="{{ strtolower($sc[1]) }}" data-city="{{ strtolower($sc[3]) }}">
                                <td><span class="fw-bold" style="color:#032671;font-size:12px;">{{ $sc[0] }}</span></td>
                                <td class="fw-semibold">{{ $sc[1] }}</td>
                                <td>
                                    <span class="badge {{ $sc[2]==='Workshop' ? 'bg-primary' : ($sc[2]==='Mobile Unit' ? 'bg-warning text-dark' : 'bg-info text-dark') }}">
                                        {{ $sc[2] }}
                                    </span>
                                </td>
                                <td>{{ $sc[3] }}</td>
                                <td>{{ $sc[4] }}</td>
                                <td style="font-size:12px;">{{ $sc[5] }}</td>
                                <td class="text-center">{{ $sc[6] }}</td>
                                <td class="text-center">
                                    @if($sc[7] > 0)
                                        <a href="{{ route('ws.workshop.job-list') }}" class="text-primary fw-semibold text-decoration-none">{{ $sc[7] }}</a>
                                    @else <span class="text-muted">0</span>
                                    @endif
                                </td>
                                <td><span class="badge bg-{{ $sc[8]==='Active' ? 'success' : 'secondary' }}">{{ $sc[8] }}</span></td>
                                <td class="text-end">
                                    <div class="dropdown dot-dd">
                                        <span class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="uil uil-ellipsis-h"></i></span>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a class="dropdown-item btn-edit-sc" href="javascript:void(0)"
                                                data-code="{{ $sc[0] }}" data-name="{{ $sc[1] }}" data-type="{{ $sc[2] }}"
                                                data-city="{{ $sc[3] }}" data-manager="{{ $sc[4] }}" data-phone="{{ $sc[5] }}"
                                                data-status="{{ $sc[8] }}"
                                                data-bs-toggle="modal" data-bs-target="#editScModal">
                                                <i class="uil uil-pen me-2"></i>Edit
                                            </a></li>
                                            <li><a class="dropdown-item" href="{{ route('ws.workshop.job-list') }}">
                                                <i class="uil uil-clipboard-alt me-2"></i>View Job Cards
                                            </a></li>
                                            <li><a class="dropdown-item btn-toggle-sc text-{{ $sc[8]==='Active' ? 'danger' : 'success' }}"
                                                href="javascript:void(0)" data-name="{{ $sc[1] }}" data-current="{{ $sc[8] }}">
                                                <i class="uil uil-{{ $sc[8]==='Active' ? 'ban' : 'check-circle' }} me-2"></i>
                                                {{ $sc[8]==='Active' ? 'Deactivate' : 'Activate' }}
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
                    <small class="text-muted" id="scCount">Showing {{ count($scs) }} service centres</small>
                </div>

            </div>
        </div>
    </div>
</div>

{{-- Add Modal --}}
<div class="modal fade" id="addScModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fw-semibold"><i class="uil uil-building me-2"></i>Add Workshop</h6>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">SC Code <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" placeholder="e.g. SC-MUM">
                        <div class="form-text">Short unique code for this centre.</div>
                    </div>
                    <div class="col-md-8">
                        <label class="form-label fw-semibold">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" placeholder="e.g. SR Logistics WS — Mumbai">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Type <span class="text-danger">*</span></label>
                        <select class="form-select">
                            <option value="">— Select —</option>
                            <option>Workshop</option>
                            <option>Mobile Unit</option>
                            <option>Hybrid</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">City <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" placeholder="e.g. Mumbai">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Address</label>
                        <input type="text" class="form-control" placeholder="Full address">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Manager / Head</label>
                        <input type="text" class="form-control" placeholder="Name">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Contact Number</label>
                        <input type="text" class="form-control" placeholder="+91 XXXXX XXXXX">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" class="form-control" placeholder="sc@srlogistics.co.in">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Bay Count</label>
                        <input type="number" class="form-control" placeholder="e.g. 8" min="1">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Status</label>
                        <select class="form-select"><option>Active</option><option>Inactive</option></select>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Notes</label>
                        <textarea class="form-control" rows="2" placeholder="Any special notes about this SC…"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-theme btn-sm" id="btnSaveSc"><i class="uil uil-save me-1"></i> Save</button>
            </div>
        </div>
    </div>
</div>

{{-- Edit Modal --}}
<div class="modal fade" id="editScModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fw-semibold"><i class="uil uil-pen me-2"></i>Edit Workshop</h6>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">SC Code</label>
                        <input type="text" class="form-control" id="editScCode" readonly>
                    </div>
                    <div class="col-md-8">
                        <label class="form-label fw-semibold">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="editScName">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Type</label>
                        <select class="form-select" id="editScType">
                            <option>Workshop</option><option>Mobile Unit</option><option>Hybrid</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">City</label>
                        <input type="text" class="form-control" id="editScCity">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Manager</label>
                        <input type="text" class="form-control" id="editScManager">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Contact</label>
                        <input type="text" class="form-control" id="editScPhone">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Status</label>
                        <select class="form-select" id="editScStatus"><option>Active</option><option>Inactive</option></select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-theme btn-sm" id="btnUpdateSc"><i class="uil uil-save me-1"></i> Update</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
$(function () {
    $(document).on('click', '.btn-edit-sc', function () {
        var b = $(this);
        $('#editScCode').val(b.data('code')); $('#editScName').val(b.data('name'));
        $('#editScType').val(b.data('type')); $('#editScCity').val(b.data('city'));
        $('#editScManager').val(b.data('manager')); $('#editScPhone').val(b.data('phone'));
        $('#editScStatus').val(b.data('status'));
    });
    $('#btnSaveSc').on('click', function () {
        Swal.fire({ icon:'success', title:'Workshop Saved', timer:1500, showConfirmButton:false });
        $('#addScModal').modal('hide');
    });
    $('#btnUpdateSc').on('click', function () {
        Swal.fire({ icon:'success', title:'Updated', timer:1500, showConfirmButton:false });
        $('#editScModal').modal('hide');
    });
    $(document).on('click', '.btn-toggle-sc', function () {
        var name = $(this).data('name'), current = $(this).data('current');
        var action = current === 'Active' ? 'Deactivate' : 'Activate';
        Swal.fire({ title: action + '?', text: '"' + name + '"', icon:'warning',
            showCancelButton:true, confirmButtonColor: current==='Active'?'#ea0027':'#10863f',
            confirmButtonText: action })
            .then(r => { if(r.isConfirmed) Swal.fire({ icon:'success', title:'Done', timer:1400, showConfirmButton:false }); });
    });
    /* ── Client-side filter ── */
    function filterSc() {
        var type   = $('#filterScType').val().toLowerCase();
        var status = $('#filterScStatus').val().toLowerCase();
        var search = $('#filterScSearch').val().toLowerCase();
        var count  = 0;
        $('#scTable tbody tr').each(function () {
            var $tr = $(this);
            var match = true;
            if (type   && $tr.data('type').indexOf(type)     === -1) match = false;
            if (status && $tr.data('status').indexOf(status) === -1) match = false;
            if (search && $tr.data('name').indexOf(search)   === -1 && $tr.data('city').indexOf(search) === -1) match = false;
            $tr.toggle(match);
            if (match) count++;
        });
        $('#scCount').text('Showing ' + count + ' service centres');
    }

    $('#filterScType,#filterScStatus').on('change', filterSc);
    $('#filterScSearch').on('keyup', filterSc);

    $('#btnClearSc').on('click', function () {
        $('#filterScType,#filterScStatus').val('');
        $('#filterScSearch').val('');
        filterSc();
    });
});
</script>
@endsection
