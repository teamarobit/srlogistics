@extends('layouts.app')

@section('css')
<link href="{{ asset('css/Workshop/Master/external-sc.css?v=1.0') }}" rel="stylesheet">
@endsection

@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="wrapper srlog-bdwrapper">
        <div class="side-wrap">
            @include('includes.leftbar')

            <div class="main-wrap">

                {{-- Page Head --}}
                <div class="container-fluid page-head">
                    <div class="row align-items-end">
                        <div class="col-12">
                            <h5 class="d-inline-block mb-0">External Workshops</h5>

                            <button class="btn btn-theme mb-0 ms-2" data-bs-toggle="modal" data-bs-target="#addExtScModal">
                                <i class="uil uil-plus me-1"></i> Add External SC
                            </button>

                            {{-- Inline filters --}}
                            <div class="search-wrap d-inline-block ms-2" style="width:150px;">
                                <select class="form-select" id="filterType">
                                    <option value="">All Types</option>
                                    <option>Brand ASC</option>
                                    <option>Third Party</option>
                                    <option>Warranty</option>
                                </select>
                            </div>

                            <div class="search-wrap d-inline-block ms-2" style="width:160px;">
                                <select class="form-select" id="filterBrand">
                                    <option value="">All Brands</option>
                                    <option>Tata Motors</option>
                                    <option>Ashok Leyland</option>
                                    <option>Bharat Benz</option>
                                    <option>Eicher</option>
                                    <option>Volvo</option>
                                    <option>Mahindra</option>
                                    <option>Others / N/A</option>
                                </select>
                            </div>

                            <div class="search-wrap d-inline-block ms-2" style="width:140px;">
                                <input type="text" class="form-control" id="filterSearch" placeholder="Search SC name…">
                            </div>

                            <button class="btn btn-primary reset-btn ms-1" id="btnClearFilter">
                                <i class="uil uil-history me-1"></i> Reset
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Table --}}
                <div class="table-responsive mt-3">
                    <table class="table table-hover invoice-table mb-0" id="extScTable">
                        <thead>
                            <tr>
                                <th>SC Name</th>
                                <th>Type</th>
                                <th>Brand / Manufacturer</th>
                                <th>City</th>
                                <th>Contact Person</th>
                                <th>Phone</th>
                                <th>Total Dispatches</th>
                                <th>Status</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $extScs = [
                                [1,  'Tata Motors ASC, Hebbal',       'Brand ASC',   'Tata Motors',   'Bangalore',  'Ravi Sharma',  '+91 98001 11001', 4, 'Active'],
                                [2,  'Tata Motors ASC, Hosur Road',   'Brand ASC',   'Tata Motors',   'Bangalore',  'Suresh Nair',  '+91 98001 11002', 2, 'Active'],
                                [3,  'AL Authorized SC, Pune',        'Brand ASC',   'Ashok Leyland', 'Pune',       'Pravin Patil', '+91 98001 22001', 3, 'Active'],
                                [4,  'AL Auth SC, Hsr',               'Brand ASC',   'Ashok Leyland', 'Hassan',     'Mohan R.',     '+91 98001 22002', 1, 'Active'],
                                [5,  'Benz ASC, Delhi',               'Warranty',    'Bharat Benz',   'New Delhi',  'Arvind Mehta', '+91 98001 33001', 2, 'Active'],
                                [6,  'Bharat Benz ASC, Pune',         'Brand ASC',   'Bharat Benz',   'Pune',       'Kiran More',   '+91 98001 33002', 1, 'Active'],
                                [7,  'Eicher ASC, Jaipur',            'Brand ASC',   'Eicher',        'Jaipur',     'Deepak Yadav', '+91 98001 44001', 2, 'Active'],
                                [8,  'Volvo ASC, Noida',              'Warranty',    'Volvo',         'Noida',      'Anand Kumar',  '+91 98001 55001', 3, 'Active'],
                                [9,  'Volvo ASC',                     'Brand ASC',   'Volvo',         'Bangalore',  'Raj Malhotra', '+91 98001 55002', 1, 'Active'],
                                [10, 'Ram Auto Works, Ahmedabad',     'Third Party', 'Others / N/A',  'Ahmedabad',  'Ramesh Patel', '+91 98001 66001', 2, 'Active'],
                                [11, 'Royal Road Services',           'Third Party', 'Others / N/A',  'Mumbai',     'Ajay Soni',    '+91 98001 66002', 1, 'Inactive'],
                                [12, 'City Auto Works',               'Third Party', 'Others / N/A',  'Chennai',    'Vijay Rajan',  '+91 98001 66003', 0, 'Inactive'],
                            ];
                            $typeMap = [
                                'Brand ASC'   => 'badge bg-primary',
                                'Third Party' => 'badge bg-warning text-dark',
                                'Warranty'    => 'badge bg-success',
                            ];
                            @endphp

                            @foreach($extScs as $sc)
                            <tr>
                                <td>
                                    <span class="fw-semibold" style="font-size:13px;">{{ $sc[1] }}</span>
                                </td>
                                <td>
                                    <span class="{{ $typeMap[$sc[2]] }}">{{ $sc[2] }}</span>
                                </td>
                                <td>
                                    @if($sc[3] !== 'Others / N/A')
                                        {{ $sc[3] }}
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>{{ $sc[4] }}</td>
                                <td>{{ $sc[5] }}</td>
                                <td>{{ $sc[6] }}</td>
                                <td class="text-center">
                                    @if($sc[7] > 0)
                                        <a href="{{ route('ws.external.dispatch') }}" class="text-primary fw-semibold text-decoration-none">{{ $sc[7] }}</a>
                                    @else
                                        <span class="text-muted">0</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-{{ $sc[8] === 'Active' ? 'success' : 'secondary' }}">
                                        {{ $sc[8] }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <div class="dropdown dot-dd">
                                        <span class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="uil uil-ellipsis-h"></i>
                                        </span>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a class="dropdown-item btn-edit-ext-sc"
                                                    href="javascript:void(0)"
                                                    data-id="{{ $sc[0] }}"
                                                    data-name="{{ $sc[1] }}"
                                                    data-type="{{ $sc[2] }}"
                                                    data-brand="{{ $sc[3] }}"
                                                    data-city="{{ $sc[4] }}"
                                                    data-contact="{{ $sc[5] }}"
                                                    data-phone="{{ $sc[6] }}"
                                                    data-status="{{ $sc[8] }}"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editExtScModal">
                                                    <i class="uil uil-pen me-2"></i>Edit
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{ route('ws.external.dispatch') }}">
                                                    <i class="uil uil-truck me-2"></i>View Dispatches
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item btn-toggle-status {{ $sc[8] === 'Active' ? 'text-danger' : 'text-success' }}"
                                                    href="javascript:void(0)"
                                                    data-id="{{ $sc[0] }}"
                                                    data-name="{{ $sc[1] }}"
                                                    data-current="{{ $sc[8] }}">
                                                    <i class="uil uil-{{ $sc[8] === 'Active' ? 'ban' : 'check-circle' }} me-2"></i>
                                                    {{ $sc[8] === 'Active' ? 'Deactivate' : 'Activate' }}
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex align-items-center justify-content-between px-3 py-2 border-top mt-2">
                    <small class="text-muted">Showing {{ count($extScs) }} External SCs</small>
                </div>

            </div>{{-- /main-wrap --}}
        </div>{{-- /side-wrap --}}
    </div>
</div>

{{-- ═══════════════ Add External SC Modal ═══════════════ --}}
<div class="modal fade" id="addExtScModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fw-semibold"><i class="uil uil-building me-2"></i>Add External Workshop</h6>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label fw-semibold">SC Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="addScName" placeholder="e.g. Tata Motors ASC, Whitefield">
                        <div class="form-text">Include the city/area in the name for easy identification.</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">SC Type <span class="text-danger">*</span></label>
                        <select class="form-select" id="addScType">
                            <option value="">— Select —</option>
                            <option value="Brand ASC">Brand ASC</option>
                            <option value="Third Party">Third Party</option>
                            <option value="Warranty">Warranty</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Brand / Manufacturer</label>
                        <select class="form-select" id="addScBrand">
                            <option value="">— Select Brand —</option>
                            <option>Tata Motors</option>
                            <option>Ashok Leyland</option>
                            <option>Bharat Benz</option>
                            <option>Eicher</option>
                            <option>Volvo</option>
                            <option>Mahindra</option>
                            <option>Force Motors</option>
                            <option>SML Isuzu</option>
                            <option>Others / N/A</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">City / Location <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="addScCity" placeholder="e.g. Bangalore">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Full Address</label>
                        <input type="text" class="form-control" id="addScAddress" placeholder="Street / Area (optional)">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Contact Person</label>
                        <input type="text" class="form-control" id="addScContact" placeholder="Service manager name">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Phone Number</label>
                        <input type="text" class="form-control" id="addScPhone" placeholder="+91 XXXXX XXXXX">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" class="form-control" id="addScEmail" placeholder="service@workshop.com (optional)">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Avg. TAT (Days)</label>
                        <input type="number" class="form-control" id="addScTat" placeholder="e.g. 5" min="1" max="30">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Notes / Specialisations</label>
                        <textarea class="form-control" id="addScNotes" rows="2" placeholder="Any remarks, specialisations, or terms…"></textarea>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Status</label>
                        <select class="form-select" id="addScStatus">
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-theme btn-sm" id="btnSaveExtSc">
                    <i class="uil uil-save me-1"></i> Save
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ═══════════════ Edit External SC Modal ═══════════════ --}}
<div class="modal fade" id="editExtScModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fw-semibold"><i class="uil uil-pen me-2"></i>Edit External Workshop</h6>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="editScId">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label fw-semibold">SC Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="editScName">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">SC Type <span class="text-danger">*</span></label>
                        <select class="form-select" id="editScType">
                            <option value="Brand ASC">Brand ASC</option>
                            <option value="Third Party">Third Party</option>
                            <option value="Warranty">Warranty</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Brand / Manufacturer</label>
                        <select class="form-select" id="editScBrand">
                            <option value="">— Select Brand —</option>
                            <option>Tata Motors</option>
                            <option>Ashok Leyland</option>
                            <option>Bharat Benz</option>
                            <option>Eicher</option>
                            <option>Volvo</option>
                            <option>Mahindra</option>
                            <option>Force Motors</option>
                            <option>SML Isuzu</option>
                            <option>Others / N/A</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">City / Location <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="editScCity">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Contact Person</label>
                        <input type="text" class="form-control" id="editScContact">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Phone Number</label>
                        <input type="text" class="form-control" id="editScPhone">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Status</label>
                        <select class="form-select" id="editScStatus">
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-theme btn-sm" id="btnUpdateExtSc">
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

    // ── Type selection → auto-set brand ─────────────────────────────────
    $('#addScType').on('change', function () {
        if ($(this).val() === 'Third Party') {
            $('#addScBrand').val('Others / N/A');
        } else {
            if ($('#addScBrand').val() === 'Others / N/A') {
                $('#addScBrand').val('');
            }
        }
    });

    // ── Save new ────────────────────────────────────────────────────────
    $('#btnSaveExtSc').on('click', function () {
        var name = $('#addScName').val().trim();
        var type = $('#addScType').val();
        var city = $('#addScCity').val().trim();

        if (!name || !type || !city) {
            Swal.fire({ icon: 'warning', title: 'Missing Fields', text: 'SC Name, Type and City are required.', confirmButtonColor: '#032671' });
            return;
        }
        $('#addExtScModal').modal('hide');
        Swal.fire({ icon: 'success', title: 'External SC Added', html: '<strong>' + name + '</strong> (' + type + ') has been saved.', confirmButtonColor: '#10863f' });
    });

    // ── Edit — populate modal ────────────────────────────────────────────
    $(document).on('click', '.btn-edit-ext-sc', function () {
        var $btn = $(this);
        $('#editScId').val($btn.data('id'));
        $('#editScName').val($btn.data('name'));
        $('#editScType').val($btn.data('type'));
        $('#editScBrand').val($btn.data('brand'));
        $('#editScCity').val($btn.data('city'));
        $('#editScContact').val($btn.data('contact'));
        $('#editScPhone').val($btn.data('phone'));
        $('#editScStatus').val($btn.data('status'));
    });

    // ── Update ──────────────────────────────────────────────────────────
    $('#btnUpdateExtSc').on('click', function () {
        var name = $('#editScName').val().trim();
        var type = $('#editScType').val();
        var city = $('#editScCity').val().trim();

        if (!name || !type || !city) {
            Swal.fire({ icon: 'warning', title: 'Missing Fields', text: 'SC Name, Type and City are required.', confirmButtonColor: '#032671' });
            return;
        }
        $('#editExtScModal').modal('hide');
        Swal.fire({ icon: 'success', title: 'Updated', html: '<strong>' + name + '</strong> has been updated.', timer: 1500, showConfirmButton: false });
    });

    // ── Activate / Deactivate ───────────────────────────────────────────
    $(document).on('click', '.btn-toggle-status', function () {
        var name    = $(this).data('name');
        var current = $(this).data('current');
        var action  = current === 'Active' ? 'Deactivate' : 'Activate';
        var color   = current === 'Active' ? '#ea0027'    : '#10863f';

        Swal.fire({
            icon: current === 'Active' ? 'warning' : 'question',
            title: action + '?',
            text: action + ' "' + name + '"?',
            showCancelButton: true,
            confirmButtonColor: color,
            cancelButtonColor: '#6c757d',
            confirmButtonText: action
        }).then(function (r) {
            if (r.isConfirmed) {
                Swal.fire({ icon: 'success', title: 'Done', text: '"' + name + '" is now ' + (current === 'Active' ? 'inactive' : 'active') + '.', timer: 1400, showConfirmButton: false });
            }
        });
    });

    // ── Clear filters ───────────────────────────────────────────────────
    $('#btnClearFilter').on('click', function () {
        $('#filterType, #filterBrand').val('');
        $('#filterSearch').val('');
    });

});
</script>
@endsection
