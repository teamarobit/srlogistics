@extends('layouts.app')

@section('css')
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
                        <div class="col-12 d-flex align-items-center flex-wrap gap-2">
                            <h6 class="mb-0">Spare Part Vendors</h6>

                            @if(Route::has('contact.sparevendor.create'))
                            <a href="{{ route('contact.sparevendor.create') }}" class="btn btn-theme btn-sm">
                                <i class="uil uil-plus me-1"></i>Add Vendor
                            </a>
                            @endif

                            <form action="{{ route('contact.sparevendor.index') }}" method="GET" class="d-flex align-items-center gap-2 flex-wrap ms-1" id="filterForm">
                                <input type="text" name="name" value="{{ $search_name ?? '' }}"
                                    class="form-control form-control-sm" placeholder="Search by name…" style="width:170px;">
                                <select name="city" class="form-select form-select-sm" style="width:140px;" onchange="this.form.submit()">
                                    <option value="">Filter by City</option>
                                    @foreach($cities as $city)
                                    <option value="{{ $city->id }}" {{ ($search_city ?? '') == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                                    @endforeach
                                </select>
                                <a href="{{ route('contact.sparevendor.index') }}" class="btn btn-outline-secondary btn-sm">Reset</a>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="table-responsive mt-3">
                    <table class="table table-hover sc-table mb-0" id="spvTable">
                        <thead>
                            <tr>
                                <th>Vendor Name</th>
                                <th>Company Name</th>
                                <th>Specialisation</th>
                                <th>Contact Person<br><span class="text-secondary fw-normal" style="font-size:10px;">Phone</span></th>
                                <th>City</th>
                                <th>Status</th>
                                <th>Created by</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($contacts as $contact)
                            <tr id="row-{{ $contact->id }}">
                                <td class="fw-semibold">{{ $contact->contact_name ?? '—' }}</td>
                                <td style="font-size:12px;color:#555;">{{ $contact->company_name ?? '—' }}</td>
                                <td>
                                    @if($contact->specialisation)
                                        @foreach(explode(',', $contact->specialisation) as $spec)
                                        <span class="badge bg-primary me-1" style="font-size:10px;">{{ trim($spec) }}</span>
                                        @endforeach
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>
                                    {{ $contact->relcontacts->first()?->contact_name ?? '—' }}<br>
                                    <span class="text-secondary" style="font-size:11px;">
                                        {{ $contact->relcontacts->first()?->phone ? '+91 '.$contact->relcontacts->first()->phone : '' }}
                                    </span>
                                </td>
                                <td>{{ $contact->city?->name ?? '—' }}</td>
                                <td>
                                    @php
                                    $sc = ['Active'=>'badge-success','Inactive'=>'badge-secondary','Blacklisted'=>'badge bg-danger'];
                                    @endphp
                                    <span class="badge {{ $sc[$contact->status] ?? 'badge-secondary' }}">{{ $contact->status }}</span>
                                </td>
                                <td style="font-size:12px;">
                                    {{ $contact->createdby?->name ?? '—' }}<br>
                                    <span class="text-secondary" style="font-size:11px;">{{ $contact->created_at?->format('d-m-Y') }}</span>
                                </td>
                                <td class="text-end">
                                    <div class="dropdown dot-dd">
                                        <span class="dropdown-toggle" data-bs-toggle="dropdown"><i class="uil uil-ellipsis-h"></i></span>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('contact.sparevendor.edit', $contact->id) }}">
                                                    <i class="uil uil-pen me-2"></i>Edit
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item spv-toggle" href="javascript:void(0)"
                                                    data-id="{{ $contact->id }}"
                                                    data-name="{{ $contact->contact_name }}"
                                                    data-status="{{ $contact->status }}">
                                                    <i class="uil {{ $contact->status === 'Active' ? 'uil-pause-circle' : 'uil-play-circle' }} me-2"></i>
                                                    {{ $contact->status === 'Active' ? 'Deactivate' : 'Activate' }}
                                                </a>
                                            </li>
                                            <li><hr class="dropdown-divider my-1"></li>
                                            <li>
                                                <a class="dropdown-item text-danger spv-delete" href="javascript:void(0)"
                                                    data-id="{{ $contact->id }}"
                                                    data-name="{{ $contact->contact_name }}">
                                                    <i class="uil uil-trash-alt me-2"></i>Delete
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">No spare part vendors found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($contacts->count())
                <div class="d-flex justify-content-between align-items-center mt-3 px-3">
                    <small class="text-muted">{{ $contacts->total() }} vendor{{ $contacts->total() !== 1 ? 's' : '' }}</small>
                    <div>{{ $contacts->appends(array_filter(['name'=>$search_name,'city'=>$search_city]))->links('pagination::bootstrap-5') }}</div>
                </div>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
(function () {
    var CSRF        = $('meta[name="csrf-token"]').attr('content');
    var TOGGLE_BASE = '/contacts/sparevendor/';   // + id + '/toggle-status'
    var DELETE_BASE = '/contacts/sparevendor/';   // + id  (DELETE)

    // ── Toggle Status ─────────────────────────────────────────────────────
    $(document).on('click', '.spv-toggle', function () {
        var id      = $(this).data('id');
        var name    = $(this).data('name');
        var current = $(this).data('status');
        var action  = current === 'Active' ? 'Deactivate' : 'Activate';
        var color   = current === 'Active' ? '#ea0027' : '#10863f';

        Swal.fire({
            title: action + ' Vendor?', text: '"' + name + '"', icon: 'warning',
            showCancelButton: true, confirmButtonColor: color, confirmButtonText: action
        }).then(function (r) {
            if (!r.isConfirmed) return;
            $.ajax({
                method: 'POST',
                url: TOGGLE_BASE + id + '/toggle-status',
                data: { _token: CSRF },
                dataType: 'json',
                success: function (res) {
                    if (res.success) {
                        Swal.fire({ icon: 'success', title: 'Status updated to ' + res.new_status, timer: 1400, showConfirmButton: false,
                            didClose: () => location.reload() });
                    }
                }
            });
        });
    });

    // ── Soft Delete ───────────────────────────────────────────────────────
    $(document).on('click', '.spv-delete', function () {
        var id   = $(this).data('id');
        var name = $(this).data('name');
        Swal.fire({
            title: 'Delete "' + name + '"?',
            text: 'This vendor will be soft-deleted and can be restored later.',
            icon: 'warning', showCancelButton: true,
            confirmButtonColor: '#ea0027', confirmButtonText: 'Delete'
        }).then(function (r) {
            if (!r.isConfirmed) return;
            $.ajax({
                method: 'POST',
                url: DELETE_BASE + id,
                data: { _token: CSRF, _method: 'DELETE' },
                dataType: 'json',
                success: function (res) {
                    if (res.success) {
                        $('#row-' + id).fadeOut(300, function () { $(this).remove(); });
                        Swal.fire({ icon: 'success', title: 'Deleted', timer: 1200, showConfirmButton: false });
                    }
                }
            });
        });
    });

    // ── Enter key search ─────────────────────────────────────────────────
    $('input[name=name]').on('keydown', function (e) {
        if (e.key === 'Enter') $('#filterForm').submit();
    });
})();
</script>
@endsection
