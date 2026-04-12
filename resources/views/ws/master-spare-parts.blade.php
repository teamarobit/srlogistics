@extends('layouts.app')

@section('css')
<link href="{{ asset('css/Workshop/Master/spare-parts.css?v=1.0') }}" rel="stylesheet">
@endsection

@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="wrapper srlog-bdwrapper">
        <div class="side-wrap">
            @include('includes.leftbar')
            <div class="main-wrap">

        {{-- Page Header --}}
        <div class="container-fluid page-head">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="mb-0"><i class="uil uil-cog me-2"></i>Spare Parts Master</h6>
                    <p class="text-muted mb-0" style="font-size:12px;">Workshop spare parts catalogue &amp; stock overview</p>
                </div>
                <div class="col-auto d-flex gap-2">
                <button class="btn btn-theme btn-sm" data-bs-toggle="modal" data-bs-target="#addPartModal">
                    <i class="uil uil-plus me-1"></i>Add Spare Part
                </button>
            </div>
            </div>{{-- /row --}}
        </div>{{-- /page-head --}}

        <div class="container-fluid mt-3">

        {{-- Filter Bar --}}
        <form action="{{ route('ws.master.spare-parts') }}" method="GET" id="spFilterForm">
        <div class="sp-filter">
            <span style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.4px;white-space:nowrap;">
                <i class="uil uil-filter me-1"></i>Filter
            </span>
            <input type="text" name="search" value="{{ request('search') }}"
                   class="form-control" style="width:220px;" placeholder="Search part no. or name…">
            <select name="category" class="form-select" style="width:180px;" onchange="this.form.submit()">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
            <select name="status" class="form-select" style="width:120px;" onchange="this.form.submit()">
                <option value="">All Status</option>
                <option value="Active"   {{ request('status') === 'Active'   ? 'selected' : '' }}>Active</option>
                <option value="Inactive" {{ request('status') === 'Inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
            <button type="submit" class="btn btn-sm btn-primary" style="font-size:12px;height:34px;padding:0 14px;">
                <i class="uil uil-search me-1"></i>Search
            </button>
            <a href="{{ route('ws.master.spare-parts') }}"
               class="btn btn-sm" style="font-size:12px;height:34px;padding:0 12px;background:#f1f5f9;color:#475569;border:1px solid #e2e8f0;">
                <i class="uil uil-sync me-1"></i>Reset
            </a>
        </div>
        </form>

        {{-- Table --}}
        <div class="sp-table-wrap">

            <div style="font-size:12px;color:#94a3b8;margin-bottom:10px;">
                Showing <strong style="color:#1e293b;">{{ $parts->total() }}</strong> part{{ $parts->total() !== 1 ? 's' : '' }}
                @if(request()->hasAny(['search','category','status']))
                    — <a href="{{ route('ws.master.spare-parts') }}" style="color:#032671;font-weight:600;">Clear filters</a>
                @endif
            </div>

            <div class="sp-table-card">
                @if($parts->count())
                <div class="table-responsive">
                    <table class="sp-table">
                        <thead>
                            <tr>
                                <th style="width:110px;">Part No.</th>
                                <th>Part Name</th>
                                <th style="width:140px;">Category</th>
                                <th style="width:170px;">Compatible Makes</th>
                                <th style="width:70px;">Unit</th>
                                <th style="width:110px;text-align:right;padding-right:18px;">Std Cost</th>
                                <th style="width:80px;text-align:center;">Reorder Lvl</th>
                                <th style="width:90px;">Status</th>
                                <th style="width:110px;text-align:right;padding-right:14px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($parts as $part)
                            <tr id="part-row-{{ $part->id }}">
                                <td><span class="sp-part-no">{{ $part->part_no }}</span></td>
                                <td>
                                    <div class="sp-part-name">{{ $part->name }}</div>
                                    @if($part->notes)
                                        <div class="sp-notes-sub">{{ Str::limit($part->notes, 60) }}</div>
                                    @endif
                                </td>
                                <td>
                                    @if($part->partCategory)
                                        <span class="sp-cat">{{ $part->partCategory->name }}</span>
                                    @else
                                        <span style="color:#cbd5e1;">—</span>
                                    @endif
                                </td>
                                <td style="font-size:11px;">{{ $part->compatible_makes ?: '—' }}</td>
                                <td>{{ $part->unit }}</td>
                                <td style="text-align:right;padding-right:18px;font-weight:600;color:#1e293b;">
                                    ₹{{ number_format($part->standard_cost, 2) }}
                                </td>
                                <td style="text-align:center;">{{ $part->reorder_level }}</td>
                                <td>
                                    <span class="sp-badge {{ strtolower($part->status) }}" id="badge-{{ $part->id }}">
                                        {{ $part->status }}
                                    </span>
                                </td>
                                <td>
                                    <div class="sp-actions">
                                        <button type="button" class="sp-action-btn" title="Edit"
                                            onclick="openEditModal(
                                                {{ $part->id }},
                                                @json($part->part_no),
                                                @json($part->name),
                                                {{ $part->wssparepartscategory_id ?? 'null' }},
                                                @json($part->compatible_makes ?? ''),
                                                @json($part->unit),
                                                @json($part->standard_cost),
                                                {{ $part->reorder_level }},
                                                @json($part->notes ?? '')
                                            )">
                                            <i class="uil uil-pen"></i>
                                        </button>
                                        <button type="button"
                                            class="sp-action-btn {{ $part->status === 'Inactive' ? 'activate' : '' }}"
                                            title="{{ $part->status === 'Active' ? 'Deactivate' : 'Activate' }}"
                                            onclick="toggleStatus({{ $part->id }}, '{{ $part->status }}')">
                                            <i class="uil {{ $part->status === 'Active' ? 'uil-toggle-off' : 'uil-toggle-on' }}"></i>
                                        </button>
                                        <button type="button" class="sp-action-btn danger" title="Remove"
                                            onclick="deletePart({{ $part->id }}, @json($part->name))">
                                            <i class="uil uil-trash-alt"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="sp-empty">
                    <i class="uil uil-cog"></i>
                    <p style="font-size:13px;font-weight:600;margin:0 0 4px;">No spare parts found</p>
                    <span style="font-size:12px;">
                        @if(request()->hasAny(['search','category','status']))
                            No parts match the current filters. <a href="{{ route('ws.master.spare-parts') }}" style="color:#032671;font-weight:600;">Clear filters</a>
                        @else
                            Click <strong>Add Spare Part</strong> to get started.
                        @endif
                    </span>
                </div>
                @endif
            </div>

            @if($parts->total() > $parts->perPage())
            <div class="mt-3">
                {{ $parts->appends(request()->only(['search','category','status']))->links('pagination::bootstrap-5') }}
            </div>
            @endif

        </div>{{-- /pagination --}}

        </div>{{-- /container-fluid --}}

            </div>{{-- /main-wrap --}}
        </div>{{-- /side-wrap --}}
    </div>{{-- /wrapper --}}
</div>{{-- /layout-wrapper --}}

{{-- ══════════ ADD MODAL ══════════ --}}
<div class="modal fade sp-modal" id="addPartModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="uil uil-plus me-2"></i>Add Spare Part</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addPartForm" novalidate>
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Part No. <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="part_no" id="add_part_no"
                                       placeholder="SP-0001" required maxlength="50">
                                <button type="button" class="btn btn-outline-secondary" style="font-size:12px;"
                                        onclick="autoFillPartNo()" title="Auto-generate">
                                    <i class="uil uil-sync"></i>
                                </button>
                            </div>
                            <div class="text-danger mt-1" style="font-size:11px;" id="add_part_no_error"></div>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label">Part Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" id="add_name"
                                   placeholder="e.g. Engine Oil Filter" required maxlength="255">
                            <div class="text-danger mt-1" style="font-size:11px;" id="add_name_error"></div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Category</label>
                            <select class="form-select select2" name="wssparepartscategory_id" id="add_category_id" style="width:100%;">
                                <option value="">— Select Category —</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Compatible Makes</label>
                            <input type="text" class="form-control" name="compatible_makes"
                                   placeholder="e.g. Tata, Eicher, Ashok" maxlength="500">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Unit <span class="text-danger">*</span></label>
                            <select class="form-select" name="unit" required>
                                <option value="Piece">Piece</option><option value="Set">Set</option>
                                <option value="Litre">Litre</option><option value="Kg">Kg</option>
                                <option value="Metre">Metre</option><option value="Box">Box</option>
                                <option value="Pair">Pair</option><option value="Bottle">Bottle</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Standard Cost (₹) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">₹</span>
                                <input type="number" class="form-control" name="standard_cost"
                                       min="0" step="0.01" value="0" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Reorder Level <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="reorder_level"
                                   min="0" value="5" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Notes</label>
                            <textarea class="form-control" name="notes" rows="2" maxlength="1000"
                                      placeholder="Optional notes…"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm" id="addPartBtn">
                        <span class="spinner-border spinner-border-sm d-none me-1" id="addSpinner"></span>
                        <i class="uil uil-save me-1"></i>Save Part
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ══════════ EDIT MODAL ══════════ --}}
<div class="modal fade sp-modal" id="editPartModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="uil uil-pen me-2"></i>Edit Spare Part</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editPartForm" novalidate>
                @csrf
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" id="edit_id">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Part No. <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="part_no" id="edit_part_no"
                                   required maxlength="50">
                            <div class="text-danger mt-1" style="font-size:11px;" id="edit_part_no_error"></div>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label">Part Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" id="edit_name"
                                   required maxlength="255">
                            <div class="text-danger mt-1" style="font-size:11px;" id="edit_name_error"></div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Category</label>
                            <select class="form-select select2" name="wssparepartscategory_id" id="edit_category_id" style="width:100%;">
                                <option value="">— Select Category —</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Compatible Makes</label>
                            <input type="text" class="form-control" name="compatible_makes" id="edit_compatible_makes"
                                   maxlength="500">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Unit <span class="text-danger">*</span></label>
                            <select class="form-select" name="unit" id="edit_unit" required>
                                <option value="Piece">Piece</option><option value="Set">Set</option>
                                <option value="Litre">Litre</option><option value="Kg">Kg</option>
                                <option value="Metre">Metre</option><option value="Box">Box</option>
                                <option value="Pair">Pair</option><option value="Bottle">Bottle</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Standard Cost (₹) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">₹</span>
                                <input type="number" class="form-control" name="standard_cost" id="edit_standard_cost"
                                       min="0" step="0.01" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Reorder Level <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="reorder_level" id="edit_reorder_level"
                                   min="0" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Notes</label>
                            <textarea class="form-control" name="notes" id="edit_notes" rows="2" maxlength="1000"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm" id="editPartBtn">
                        <span class="spinner-border spinner-border-sm d-none me-1" id="editSpinner"></span>
                        <i class="uil uil-save me-1"></i>Update Part
                    </button>
                </div>
            </form>
        </div>{{-- /modal-content --}}
    </div>{{-- /modal-dialog --}}
</div>{{-- /editPartModal --}}

{{-- Toast --}}
<div id="spToast" class="toast align-items-center border-0" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
        <div class="toast-body fw-semibold" id="spToastMsg"></div>
        <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"></button>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('js/Workshop/Master/spare-parts.js?v=1.0') }}"></script>

<script>
(function () {
    'use strict';

    const CSRF  = document.querySelector('meta[name="csrf-token"]')?.content ?? '';
    const BASE  = '{{ route("ws.master.spare-parts") }}';

    /* ── Toast ── */
    function showToast(msg, ok = true) {
        const el = document.getElementById('spToast');
        document.getElementById('spToastMsg').textContent = msg;
        el.classList.remove('bg-success', 'bg-danger', 'text-white');
        el.classList.add(ok ? 'bg-success' : 'bg-danger', 'text-white');
        bootstrap.Toast.getOrCreateInstance(el, { delay: 3500 }).show();
    }

    /* ── Clear / show field errors ── */
    function clearErrors(prefix) {
        document.querySelectorAll(`[id^="${prefix}_"][id$="_error"]`).forEach(el => {
            el.textContent = '';
        });
        document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    }

    function showErrors(prefix, errors) {
        Object.entries(errors).forEach(([field, msgs]) => {
            const errEl   = document.getElementById(`${prefix}_${field}_error`);
            const inputEl = document.getElementById(`${prefix}_${field}`) ??
                            document.querySelector(`#${prefix}PartForm [name="${field}"]`);
            if (errEl)   errEl.textContent = msgs[0];
            if (inputEl) inputEl.classList.add('is-invalid');
        });
    }

    /* ── AJAX helper ── */
    function apiFetch(url, method, formOrBody) {
        const body = formOrBody instanceof HTMLFormElement
            ? new URLSearchParams(new FormData(formOrBody))
            : formOrBody;
        if (method !== 'GET' && method !== 'POST') {
            if (body instanceof URLSearchParams) body.set('_method', method);
        }
        return fetch(url, {
            method : method === 'GET' ? 'GET' : 'POST',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json',
                       'Content-Type': 'application/x-www-form-urlencoded' },
            body   : method === 'GET' ? undefined : body,
        }).then(r => r.json());
    }

    /* ── Auto-fill part no ── */
    window.autoFillPartNo = function () {
        apiFetch(`${BASE}?_auto_no=1`, 'GET')
            .then(d => { if (d.part_no) document.getElementById('add_part_no').value = d.part_no; })
            .catch(() => {});
    };

    /* ── ADD ── */
    document.getElementById('addPartForm').addEventListener('submit', function (e) {
        e.preventDefault();
        clearErrors('add');
        const btn = document.getElementById('addPartBtn');
        const sp  = document.getElementById('addSpinner');
        btn.disabled = true; sp.classList.remove('d-none');

        apiFetch(BASE, 'POST', this)
            .then(d => {
                if (d.success) {
                    bootstrap.Modal.getInstance(document.getElementById('addPartModal')).hide();
                    this.reset();
                    showToast(d.message);
                    setTimeout(() => location.reload(), 900);
                } else if (d.errors) {
                    showErrors('add', d.errors);
                } else {
                    showToast(d.message ?? 'An error occurred.', false);
                }
            })
            .catch(() => showToast('Server error. Please try again.', false))
            .finally(() => { btn.disabled = false; sp.classList.add('d-none'); });
    });

    /* ── Open edit modal ── */
    window.openEditModal = function (id, part_no, name, category_id, compatible_makes, unit, standard_cost, reorder_level, notes) {
        clearErrors('edit');
        document.getElementById('edit_id').value               = id;
        document.getElementById('edit_part_no').value          = part_no;
        document.getElementById('edit_name').value             = name;
        $('#edit_category_id').val(category_id).trigger('change');
        document.getElementById('edit_compatible_makes').value = compatible_makes;
        document.getElementById('edit_unit').value             = unit;
        document.getElementById('edit_standard_cost').value    = standard_cost;
        document.getElementById('edit_reorder_level').value    = reorder_level;
        document.getElementById('edit_notes').value            = notes;
        bootstrap.Modal.getOrCreateInstance(document.getElementById('editPartModal')).show();
    };

    /* ── EDIT ── */
    document.getElementById('editPartForm').addEventListener('submit', function (e) {
        e.preventDefault();
        clearErrors('edit');
        const id  = document.getElementById('edit_id').value;
        const btn = document.getElementById('editPartBtn');
        const sp  = document.getElementById('editSpinner');
        btn.disabled = true; sp.classList.remove('d-none');

        apiFetch(`${BASE}/${id}`, 'PUT', this)
            .then(d => {
                if (d.success) {
                    bootstrap.Modal.getInstance(document.getElementById('editPartModal')).hide();
                    showToast(d.message);
                    setTimeout(() => location.reload(), 900);
                } else if (d.errors) {
                    showErrors('edit', d.errors);
                } else {
                    showToast(d.message ?? 'An error occurred.', false);
                }
            })
            .catch(() => showToast('Server error. Please try again.', false))
            .finally(() => { btn.disabled = false; sp.classList.add('d-none'); });
    });

    /* ── Toggle status ── */
    window.toggleStatus = function (id, currentStatus) {
        const action = currentStatus === 'Active' ? 'deactivate' : 'activate';
        if (!confirm(`Are you sure you want to ${action} this part?`)) return;

        const body = new URLSearchParams({ _method: 'PATCH' });
        apiFetch(`${BASE}/${id}/status`, 'PATCH', body)
            .then(d => {
                if (d.success) {
                    showToast(d.message);
                    setTimeout(() => location.reload(), 700);
                } else {
                    showToast(d.message ?? 'Could not update status.', false);
                }
            })
            .catch(() => showToast('Server error.', false));
    };

    /* ── Soft delete ── */
    window.deletePart = function (id, name) {
        if (!confirm(`Remove "${name}" from spare parts master?\n\nThis can be restored by an administrator.`)) return;

        const body = new URLSearchParams({ _method: 'DELETE' });
        apiFetch(`${BASE}/${id}`, 'DELETE', body)
            .then(d => {
                if (d.success) {
                    showToast(d.message);
                    const row = document.getElementById(`part-row-${id}`);
                    if (row) {
                        row.style.transition = 'opacity .35s';
                        row.style.opacity    = '0';
                        setTimeout(() => row.remove(), 350);
                    }
                } else {
                    showToast(d.message ?? 'Could not delete part.', false);
                }
            })
            .catch(() => showToast('Server error.', false));
    };

    /* ── Enter on search input ── */
    document.querySelector('input[name="search"]')
        ?.addEventListener('keypress', e => {
            if (e.key === 'Enter') { e.preventDefault(); document.getElementById('spFilterForm').submit(); }
        });

    /* ── Select2 init ── */
    $(document).ready(function () {
        $('#add_category_id').select2({ dropdownParent: $('#addPartModal'), width: '100%', placeholder: '— Select Category —', allowClear: true });
        $('#edit_category_id').select2({ dropdownParent: $('#editPartModal'), width: '100%', placeholder: '— Select Category —', allowClear: true });
    });

}());
</script>
@endsection
