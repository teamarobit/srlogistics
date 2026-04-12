@extends('layouts.app')

@section('css')
<link href="{{ asset('css/Workshop/Master/spare-part-categories.css?v=1.0') }}" rel="stylesheet">
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
                    <h6 class="mb-0"><i class="uil uil-tag-alt me-2"></i>Spare Part Categories</h6>
                    <p class="text-muted mb-0" style="font-size:12px;">Manage categories used for spare parts and vendor specialisation</p>
                </div>
                <div class="col-auto d-flex gap-2">
                    <button class="btn btn-theme btn-sm" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                        <i class="uil uil-plus me-1"></i>Add Category
                    </button>
                </div>
            </div>
        </div>

        <div class="container-fluid mt-3">

        {{-- Filter Bar --}}
        <form action="{{ route('ws.master.spare-part-categories') }}" method="GET" id="spFilterForm">
        <div class="sp-filter">
            <span style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.4px;white-space:nowrap;">
                <i class="uil uil-filter me-1"></i>Filter
            </span>
            <input type="text" name="search" value="{{ request('search') }}"
                   class="form-control" style="width:260px;" placeholder="Search name, code, description…">
            <select name="status" class="form-select" style="width:120px;" onchange="this.form.submit()">
                <option value="">All Status</option>
                <option value="Active"   {{ request('status') === 'Active'   ? 'selected' : '' }}>Active</option>
                <option value="Inactive" {{ request('status') === 'Inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
            <button type="submit" class="btn btn-sm btn-primary" style="font-size:12px;height:34px;padding:0 14px;">
                <i class="uil uil-search me-1"></i>Search
            </button>
            <a href="{{ route('ws.master.spare-part-categories') }}"
               class="btn btn-sm" style="font-size:12px;height:34px;padding:0 12px;background:#f1f5f9;color:#475569;border:1px solid #e2e8f0;">
                <i class="uil uil-sync me-1"></i>Reset
            </a>
        </div>
        </form>

        {{-- Table --}}
        <div class="sp-table-wrap">

            <div style="font-size:12px;color:#94a3b8;margin-bottom:10px;">
                Showing <strong style="color:#1e293b;">{{ $categories->total() }}</strong>
                categor{{ $categories->total() !== 1 ? 'ies' : 'y' }}
                @if(request()->hasAny(['search','status']))
                    — <a href="{{ route('ws.master.spare-part-categories') }}" style="color:#032671;font-weight:600;">Clear filters</a>
                @endif
            </div>

            <div class="sp-table-card">
                @if($categories->count())
                <div class="table-responsive">
                    <table class="sp-table">
                        <thead>
                            <tr>
                                <th style="width:60px;">#</th>
                                <th>Category Name</th>
                                <th style="width:140px;">Code</th>
                                <th>Description</th>
                                <th style="width:90px;">Status</th>
                                <th style="width:110px;text-align:right;padding-right:14px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $index => $cat)
                            <tr id="cat-row-{{ $cat->id }}">
                                <td style="color:#94a3b8;font-size:11px;">{{ $categories->firstItem() + $index }}</td>
                                <td><span class="sp-cat-name">{{ $cat->name }}</span></td>
                                <td>
                                    @if($cat->code)
                                        <span class="sp-cat-code">{{ $cat->code }}</span>
                                    @else
                                        <span style="color:#cbd5e1;">—</span>
                                    @endif
                                </td>
                                <td>
                                    @if($cat->description)
                                        <span class="sp-cat-desc">{{ Str::limit($cat->description, 80) }}</span>
                                    @else
                                        <span style="color:#cbd5e1;">—</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="sp-badge {{ strtolower($cat->status) }}" id="badge-{{ $cat->id }}">
                                        {{ $cat->status }}
                                    </span>
                                </td>
                                <td>
                                    <div class="sp-actions">
                                        <button type="button" class="sp-action-btn" title="Edit"
                                            onclick="openEditModal(
                                                {{ $cat->id }},
                                                @json($cat->name),
                                                @json($cat->code ?? ''),
                                                @json($cat->description ?? '')
                                            )">
                                            <i class="uil uil-pen"></i>
                                        </button>
                                        <button type="button"
                                            class="sp-action-btn {{ $cat->status === 'Inactive' ? 'activate' : '' }}"
                                            title="{{ $cat->status === 'Active' ? 'Deactivate' : 'Activate' }}"
                                            onclick="toggleStatus({{ $cat->id }}, '{{ $cat->status }}')">
                                            <i class="uil {{ $cat->status === 'Active' ? 'uil-toggle-off' : 'uil-toggle-on' }}"></i>
                                        </button>
                                        <button type="button" class="sp-action-btn danger" title="Remove"
                                            onclick="deleteCategory({{ $cat->id }}, @json($cat->name))">
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
                    <i class="uil uil-tag-alt"></i>
                    <p style="font-size:13px;font-weight:600;margin:0 0 4px;">No categories found</p>
                    <span style="font-size:12px;">
                        @if(request()->hasAny(['search','status']))
                            No categories match the current filters.
                            <a href="{{ route('ws.master.spare-part-categories') }}" style="color:#032671;font-weight:600;">Clear filters</a>
                        @else
                            Click <strong>Add Category</strong> to get started.
                        @endif
                    </span>
                </div>
                @endif
            </div>

            @if($categories->total() > $categories->perPage())
            <div class="mt-3">
                {{ $categories->appends(request()->only(['search','status']))->links('pagination::bootstrap-5') }}
            </div>
            @endif

        </div>{{-- /sp-table-wrap --}}

        </div>{{-- /container-fluid --}}

            </div>{{-- /main-wrap --}}
        </div>{{-- /side-wrap --}}
    </div>{{-- /wrapper --}}
</div>{{-- /layout-wrapper --}}


{{-- ══════════ ADD MODAL ══════════ --}}
<div class="modal fade sp-modal" id="addCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:480px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="uil uil-plus me-2"></i>Add Spare Part Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addCategoryForm" novalidate>
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Category Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" id="add_name"
                                   placeholder="e.g. Engine Parts" required maxlength="100">
                            <div class="text-danger mt-1" style="font-size:11px;" id="add_name_error"></div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Code <span style="color:#94a3b8;font-weight:400;">(optional, unique)</span></label>
                            <input type="text" class="form-control" name="code" id="add_code"
                                   placeholder="e.g. ENG" maxlength="30">
                            <div class="text-danger mt-1" style="font-size:11px;" id="add_code_error"></div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" id="add_description"
                                      rows="2" maxlength="500" placeholder="Optional description…"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm" id="addCategoryBtn">
                        <span class="spinner-border spinner-border-sm d-none me-1" id="addSpinner"></span>
                        <i class="uil uil-save me-1"></i>Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ══════════ EDIT MODAL ══════════ --}}
<div class="modal fade sp-modal" id="editCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:480px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="uil uil-pen me-2"></i>Edit Spare Part Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editCategoryForm" novalidate>
                @csrf
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" id="edit_id">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Category Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" id="edit_name"
                                   required maxlength="100">
                            <div class="text-danger mt-1" style="font-size:11px;" id="edit_name_error"></div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Code <span style="color:#94a3b8;font-weight:400;">(optional, unique)</span></label>
                            <input type="text" class="form-control" name="code" id="edit_code" maxlength="30">
                            <div class="text-danger mt-1" style="font-size:11px;" id="edit_code_error"></div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" id="edit_description"
                                      rows="2" maxlength="500"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm" id="editCategoryBtn">
                        <span class="spinner-border spinner-border-sm d-none me-1" id="editSpinner"></span>
                        <i class="uil uil-save me-1"></i>Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Toast --}}
<div id="spToast" class="toast align-items-center border-0" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
        <div class="toast-body fw-semibold" id="spToastMsg"></div>
        <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"></button>
    </div>
</div>
@endsection

@section('js')
<script>
(function () {
    'use strict';

    const CSRF = document.querySelector('meta[name="csrf-token"]')?.content ?? '';
    const BASE = '{{ route("ws.master.spare-part-categories") }}';

    /* ── Toast ── */
    function showToast(msg, ok = true) {
        const el = document.getElementById('spToast');
        document.getElementById('spToastMsg').textContent = msg;
        el.classList.remove('bg-success', 'bg-danger', 'text-white');
        el.classList.add(ok ? 'bg-success' : 'bg-danger', 'text-white');
        bootstrap.Toast.getOrCreateInstance(el, { delay: 3500 }).show();
    }

    /* ── Clear / show errors ── */
    function clearErrors(prefix) {
        document.querySelectorAll(`[id^="${prefix}_"][id$="_error"]`).forEach(el => el.textContent = '');
        document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    }

    function showErrors(prefix, errors) {
        Object.entries(errors).forEach(([field, msgs]) => {
            const errEl   = document.getElementById(`${prefix}_${field}_error`);
            const inputEl = document.getElementById(`${prefix}_${field}`);
            if (errEl)   errEl.textContent = Array.isArray(msgs) ? msgs[0] : msgs;
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

    /* ── ADD ── */
    document.getElementById('addCategoryForm').addEventListener('submit', function (e) {
        e.preventDefault();
        clearErrors('add');
        const btn = document.getElementById('addCategoryBtn');
        const sp  = document.getElementById('addSpinner');
        btn.disabled = true; sp.classList.remove('d-none');

        apiFetch(BASE, 'POST', this)
            .then(d => {
                if (d.success) {
                    bootstrap.Modal.getInstance(document.getElementById('addCategoryModal')).hide();
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
    window.openEditModal = function (id, name, code, description) {
        clearErrors('edit');
        document.getElementById('edit_id').value          = id;
        document.getElementById('edit_name').value        = name;
        document.getElementById('edit_code').value        = code;
        document.getElementById('edit_description').value = description;
        bootstrap.Modal.getOrCreateInstance(document.getElementById('editCategoryModal')).show();
    };

    /* ── EDIT ── */
    document.getElementById('editCategoryForm').addEventListener('submit', function (e) {
        e.preventDefault();
        clearErrors('edit');
        const id  = document.getElementById('edit_id').value;
        const btn = document.getElementById('editCategoryBtn');
        const sp  = document.getElementById('editSpinner');
        btn.disabled = true; sp.classList.remove('d-none');

        apiFetch(`${BASE}/${id}`, 'PUT', this)
            .then(d => {
                if (d.success) {
                    bootstrap.Modal.getInstance(document.getElementById('editCategoryModal')).hide();
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
        if (!confirm(`Are you sure you want to ${action} this category?`)) return;

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

    /* ── Delete ── */
    window.deleteCategory = function (id, name) {
        if (!confirm(`Remove "${name}"?\n\nThis can be restored by an administrator.`)) return;

        const body = new URLSearchParams({ _method: 'DELETE' });
        apiFetch(`${BASE}/${id}`, 'DELETE', body)
            .then(d => {
                if (d.success) {
                    showToast(d.message);
                    const row = document.getElementById(`cat-row-${id}`);
                    if (row) {
                        row.style.transition = 'opacity .35s';
                        row.style.opacity    = '0';
                        setTimeout(() => row.remove(), 350);
                    }
                } else {
                    showToast(d.message ?? 'Could not delete category.', false);
                }
            })
            .catch(() => showToast('Server error.', false));
    };

    /* ── Enter on search ── */
    document.querySelector('input[name="search"]')
        ?.addEventListener('keypress', e => {
            if (e.key === 'Enter') { e.preventDefault(); document.getElementById('spFilterForm').submit(); }
        });

}());
</script>
@endsection
