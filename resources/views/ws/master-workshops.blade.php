@extends('layouts.app')

@section('css')
<link href="{{ asset('css/Workshop/Master/workshops.css?v=1.0') }}" rel="stylesheet">
@endsection

@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="wrapper srlog-bdwrapper">
        <div class="side-wrap">
            @include('includes.leftbar')
            <div class="main-wrap">

                <div class="container-fluid page-head">
                    <div class="row align-items-center gy-2">
                        <div class="col-md-6 d-flex flex-wrap align-items-center gap-2">
                            <h5 class="mb-0 me-2">Workshops</h5>
                            {{-- Ownership tab-filter --}}
                            <ul class="nav filter-tabs border-0 gap-1" id="ownershipTabs">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#" data-ownership="">
                                        All
                                        <span class="badge bg-secondary ms-1">{{ $ownCount + $externalCount }}</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#" data-ownership="Own">
                                        Own
                                        <span class="badge" style="background:#e8f0fe;color:#032671;">{{ $ownCount }}</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#" data-ownership="External">
                                        External
                                        <span class="badge" style="background:#fff4e5;color:#b35c00;">{{ $externalCount }}</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6 d-flex flex-wrap align-items-center justify-content-md-end gap-2">
                            <input type="text" class="form-control form-control-sm" id="wsSearch" placeholder="Search name / city / code…" style="width:200px;">
                            <select class="form-select form-select-sm" id="wsTypeFilter" style="width:150px;">
                                <option value="">All Types</option>
                                <option>Workshop</option>
                                <option>Mobile Unit</option>
                                <option>Hybrid</option>
                                <option>Brand ASC</option>
                                <option>Third Party</option>
                                <option>Warranty</option>
                                <option>Multi-Brand</option>
                            </select>
                            <select class="form-select form-select-sm" id="wsStatusFilter" style="width:110px;">
                                <option value="">All Status</option>
                                <option>Active</option>
                                <option>Inactive</option>
                            </select>
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addWsModal">
                                <i class="uil uil-plus me-1"></i> Add Workshop
                            </button>
                        </div>
                    </div>
                </div>

                <div class="table-responsive mt-3">
                    <table class="table table-hover invoice-table mb-0" id="wsTable">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Ownership</th>
                                <th>Type</th>
                                <th>Brand</th>
                                <th>City / State</th>
                                <th>Contact</th>
                                <th>Techs</th>
                                <th>Status</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($workshops as $ws)
                            <tr
                                data-ownership="{{ strtolower($ws->ownership) }}"
                                data-type="{{ strtolower($ws->workshop_type) }}"
                                data-status="{{ strtolower($ws->status) }}"
                                data-name="{{ strtolower($ws->name) }}"
                                data-city="{{ strtolower($ws->city ?? '') }}"
                                data-code="{{ strtolower($ws->workshop_code) }}"
                            >
                                <td><span class="fw-bold" style="color:#032671;font-size:12px;">{{ $ws->workshop_code }}</span></td>
                                <td class="fw-semibold">{{ $ws->name }}</td>
                                <td>
                                    @if($ws->ownership === 'Own')
                                        <span class="ownership-badge-own"><i class="uil uil-building me-1"></i>Own</span>
                                    @else
                                        <span class="ownership-badge-external"><i class="uil uil-store-alt me-1"></i>External</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $typeColors = [
                                            'Workshop'    => 'bg-primary',
                                            'Mobile Unit' => 'bg-warning text-dark',
                                            'Hybrid'      => 'bg-info text-dark',
                                            'Brand ASC'   => 'bg-success',
                                            'Third Party' => 'bg-secondary',
                                            'Warranty'    => 'bg-purple text-white',
                                            'Multi-Brand' => 'bg-dark',
                                        ];
                                    @endphp
                                    <span class="badge ws-type-badge {{ $typeColors[$ws->workshop_type] ?? 'bg-secondary' }}">
                                        {{ $ws->workshop_type }}
                                    </span>
                                </td>
                                <td class="text-muted" style="font-size:12px;">{{ $ws->brand ?? '—' }}</td>
                                <td style="font-size:12px;">
                                    {{ $ws->city ?? '' }}{{ $ws->city && $ws->state ? ', ' : '' }}{{ $ws->state ?? '' }}
                                    @if(!$ws->city && !$ws->state) <span class="text-muted">—</span> @endif
                                </td>
                                <td style="font-size:12px;">
                                    {{ $ws->manager_name ?? '' }}<br>
                                    <span class="text-muted">{{ $ws->contact_phone ?? '—' }}</span>
                                </td>
                                <td class="text-center text-muted" style="font-size:12px;">
                                    {{ $ws->ownership === 'Own' ? $ws->technician_count : '—' }}
                                </td>
                                <td>
                                    <span class="badge bg-{{ $ws->status === 'Active' ? 'success' : 'secondary' }}">
                                        {{ $ws->status }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <div class="dropdown dot-dd">
                                        <span class="dropdown-toggle" data-bs-toggle="dropdown"><i class="uil uil-ellipsis-h"></i></span>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a class="dropdown-item btn-edit-ws" href="javascript:void(0)"
                                                    data-bs-toggle="modal" data-bs-target="#editWsModal"
                                                    data-id="{{ $ws->id }}"
                                                    data-code="{{ $ws->workshop_code }}"
                                                    data-name="{{ $ws->name }}"
                                                    data-ownership="{{ $ws->ownership }}"
                                                    data-type="{{ $ws->workshop_type }}"
                                                    data-brand="{{ $ws->brand }}"
                                                    data-city="{{ $ws->city }}"
                                                    data-state="{{ $ws->state }}"
                                                    data-address="{{ $ws->address }}"
                                                    data-pincode="{{ $ws->pincode }}"
                                                    data-manager="{{ $ws->manager_name }}"
                                                    data-phone="{{ $ws->contact_phone }}"
                                                    data-email="{{ $ws->contact_email }}"
                                                    data-techs="{{ $ws->technician_count }}"
                                                    data-notes="{{ $ws->notes }}"
                                                    data-status="{{ $ws->status }}">
                                                    <i class="uil uil-pen me-2"></i>Edit
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item text-{{ $ws->status === 'Active' ? 'danger' : 'success' }} btn-toggle-ws"
                                                    href="javascript:void(0)"
                                                    data-id="{{ $ws->id }}"
                                                    data-name="{{ $ws->name }}"
                                                    data-current="{{ $ws->status }}">
                                                    <i class="uil uil-{{ $ws->status === 'Active' ? 'ban' : 'check-circle' }} me-2"></i>
                                                    {{ $ws->status === 'Active' ? 'Deactivate' : 'Activate' }}
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="text-center text-muted py-5">
                                    <i class="uil uil-store-slash" style="font-size:32px;opacity:.4;"></i>
                                    <p class="mt-2 mb-0">No workshops added yet.</p>
                                    <button class="btn btn-sm btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#addWsModal">
                                        <i class="uil uil-plus me-1"></i>Add First Workshop
                                    </button>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="px-3 py-2 border-top mt-2">
                    <small class="text-muted" id="wsCount">Showing {{ $workshops->count() }} workshop(s)</small>
                </div>

            </div>
        </div>
    </div>
</div>

{{-- ── Add Workshop Modal ───────────────────────────────────────────────── --}}
<div class="modal fade" id="addWsModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fw-semibold"><i class="uil uil-store-alt me-2"></i>Add Workshop</h6>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal"></button>
            </div>
            <form id="addWsForm" method="POST" action="{{ route('ws.master.workshops.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">

                        {{-- Ownership toggle --}}
                        <div class="col-12">
                            <label class="form-label fw-semibold">Ownership <span class="text-danger">*</span></label>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="ownership" id="addOwn" value="Own" checked>
                                    <label class="form-check-label" for="addOwn">
                                        <span class="ownership-badge-own">Own Workshop</span>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="ownership" id="addExternal" value="External">
                                    <label class="form-check-label" for="addExternal">
                                        <span class="ownership-badge-external">External Workshop / ASC</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <label class="form-label fw-semibold">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" placeholder="e.g. SR Logistics Workshop — Hyderabad" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Workshop Type <span class="text-danger">*</span></label>
                            <select class="form-select" name="workshop_type" id="addWsType" required>
                                <option value="">— Select —</option>
                                <optgroup label="Own" class="opt-own">
                                    <option>Workshop</option>
                                    <option>Mobile Unit</option>
                                    <option>Hybrid</option>
                                </optgroup>
                                <optgroup label="External" class="opt-external">
                                    <option>Brand ASC</option>
                                    <option>Third Party</option>
                                    <option>Warranty</option>
                                    <option>Multi-Brand</option>
                                </optgroup>
                            </select>
                        </div>

                        {{-- Brand — only visible for external --}}
                        <div class="col-md-4 ws-external-only" style="display:none;">
                            <label class="form-label fw-semibold">Brand</label>
                            <input type="text" class="form-control" name="brand" placeholder="e.g. Tata Motors, Leyland">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">City</label>
                            <input type="text" class="form-control" name="city" placeholder="e.g. Hyderabad">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">State</label>
                            <input type="text" class="form-control" name="state" placeholder="e.g. Telangana">
                        </div>
                        <div class="col-8">
                            <label class="form-label fw-semibold">Address</label>
                            <input type="text" class="form-control" name="address" placeholder="Full address">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Pincode</label>
                            <input type="text" class="form-control" name="pincode" placeholder="500001" maxlength="10">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Manager / Contact Person</label>
                            <input type="text" class="form-control" name="manager_name" placeholder="Name">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Phone</label>
                            <input type="text" class="form-control" name="contact_phone" placeholder="+91 XXXXX XXXXX">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" class="form-control" name="contact_email" placeholder="workshop@example.com">
                        </div>

                        {{-- Technician count — only for Own --}}
                        <div class="col-md-3 ws-own-only">
                            <label class="form-label fw-semibold">Technicians</label>
                            <input type="number" class="form-control" name="technician_count" placeholder="0" min="0">
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">Notes</label>
                            <textarea class="form-control" name="notes" rows="2" placeholder="Any notes…"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-theme btn-sm" id="btnSaveWs">
                        <i class="uil uil-save me-1"></i> Save Workshop
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ── Edit Workshop Modal ──────────────────────────────────────────────── --}}
<div class="modal fade" id="editWsModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fw-semibold"><i class="uil uil-pen me-2"></i>Edit Workshop</h6>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editWsForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="editWsId">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Code</label>
                            <input type="text" class="form-control" id="editWsCode" readonly>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label fw-semibold">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="editWsName">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Ownership</label>
                            <input type="text" class="form-control" id="editWsOwnership" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Workshop Type</label>
                            <select class="form-select" id="editWsType">
                                <option>Workshop</option><option>Mobile Unit</option><option>Hybrid</option>
                                <option>Brand ASC</option><option>Third Party</option><option>Warranty</option><option>Multi-Brand</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Brand</label>
                            <input type="text" class="form-control" id="editWsBrand">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">City</label>
                            <input type="text" class="form-control" id="editWsCity">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">State</label>
                            <input type="text" class="form-control" id="editWsState">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Manager / Contact</label>
                            <input type="text" class="form-control" id="editWsManager">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Phone</label>
                            <input type="text" class="form-control" id="editWsPhone">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" class="form-control" id="editWsEmail">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Technicians</label>
                            <input type="number" class="form-control" id="editWsTechs" min="0">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Status</label>
                            <select class="form-select" id="editWsStatus"><option>Active</option><option>Inactive</option></select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Notes</label>
                            <textarea class="form-control" id="editWsNotes" rows="2"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-theme btn-sm" id="btnUpdateWs">
                    <i class="uil uil-save me-1"></i> Update
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
$(function () {

    // ── Ownership tab filter ──────────────────────────────────────────────────
    $('#ownershipTabs .nav-link').on('click', function (e) {
        e.preventDefault();
        $('#ownershipTabs .nav-link').removeClass('active');
        $(this).addClass('active');
        applyWsFilters();
    });

    // ── Add modal: toggle fields by ownership ─────────────────────────────────
    $('input[name="ownership"]').on('change', function () {
        var own = $(this).val() === 'Own';
        $('.ws-own-only').toggle(own);
        $('.ws-external-only').toggle(!own);
        // reset type select
        $('#addWsType').val('');
        // show/hide relevant optgroups
        $('.opt-own').toggle(own);
        $('.opt-external').toggle(!own);
    });
    // init
    $('.ws-external-only').hide();
    $('.opt-external').hide();

    // ── Unified client-side filter ────────────────────────────────────────────
    function applyWsFilters() {
        var ownership = $('#ownershipTabs .nav-link.active').data('ownership') || '';
        var type      = $('#wsTypeFilter').val().toLowerCase();
        var status    = $('#wsStatusFilter').val().toLowerCase();
        var search    = $('#wsSearch').val().toLowerCase();
        var count     = 0;

        $('#wsTable tbody tr[data-ownership]').each(function () {
            var $tr  = $(this);
            var match = true;
            if (ownership && $tr.data('ownership') !== ownership.toLowerCase()) match = false;
            if (type   && $tr.data('type').indexOf(type)     === -1) match = false;
            if (status && $tr.data('status').indexOf(status) === -1) match = false;
            if (search) {
                var haystack = $tr.data('name') + ' ' + $tr.data('city') + ' ' + $tr.data('code');
                if (haystack.indexOf(search) === -1) match = false;
            }
            $tr.toggle(match);
            if (match) count++;
        });
        $('#wsCount').text('Showing ' + count + ' workshop(s)');
    }

    $('#wsTypeFilter, #wsStatusFilter').on('change', applyWsFilters);
    $('#wsSearch').on('keyup', applyWsFilters);

    // ── Add form submission ───────────────────────────────────────────────────
    $('#addWsForm').on('submit', function (e) {
        e.preventDefault();
        var form = $(this);
        $.ajax({
            url:  form.attr('action'),
            type: 'POST',
            data: form.serialize(),
            success: function (res) {
                if (res.success) {
                    Swal.fire({ icon:'success', title:'Workshop Added', text: res.message, timer:1600, showConfirmButton:false })
                        .then(() => location.reload());
                }
            },
            error: function (xhr) {
                var errors = xhr.responseJSON?.errors || {};
                var msg = Object.values(errors).flat().join('\n') || 'Something went wrong.';
                Swal.fire({ icon:'error', title:'Error', text: msg });
            }
        });
    });

    // ── Edit modal populate ───────────────────────────────────────────────────
    $(document).on('click', '.btn-edit-ws', function () {
        var b = $(this);
        $('#editWsId').val(b.data('id'));
        $('#editWsCode').val(b.data('code'));
        $('#editWsName').val(b.data('name'));
        $('#editWsOwnership').val(b.data('ownership'));
        $('#editWsType').val(b.data('type'));
        $('#editWsBrand').val(b.data('brand'));
        $('#editWsCity').val(b.data('city'));
        $('#editWsState').val(b.data('state'));
        $('#editWsManager').val(b.data('manager'));
        $('#editWsPhone').val(b.data('phone'));
        $('#editWsEmail').val(b.data('email'));
        $('#editWsTechs').val(b.data('techs'));
        $('#editWsNotes').val(b.data('notes'));
        $('#editWsStatus').val(b.data('status'));
    });

    $('#btnUpdateWs').on('click', function () {
        var id = $('#editWsId').val();
        $.ajax({
            url:  '{{ url("service-centre/master/workshops") }}/' + id,
            type: 'POST',
            data: $('#editWsForm').serialize() + '&_method=PUT',
            success: function (res) {
                if (res.success) {
                    Swal.fire({ icon:'success', title:'Updated', timer:1500, showConfirmButton:false })
                        .then(() => location.reload());
                }
            },
            error: function () {
                Swal.fire({ icon:'error', title:'Update failed' });
            }
        });
    });

    // ── Toggle active/inactive ────────────────────────────────────────────────
    $(document).on('click', '.btn-toggle-ws', function () {
        var name    = $(this).data('name');
        var current = $(this).data('current');
        var action  = current === 'Active' ? 'Deactivate' : 'Activate';
        Swal.fire({
            title: action + ' workshop?',
            text:  '"' + name + '"',
            icon:  'warning',
            showCancelButton: true,
            confirmButtonColor: current === 'Active' ? '#ea0027' : '#10863f',
            confirmButtonText: action
        }).then(r => {
            if (r.isConfirmed) {
                Swal.fire({ icon:'success', title:'Done', timer:1400, showConfirmButton:false })
                    .then(() => location.reload());
            }
        });
    });

});
</script>
@endsection
