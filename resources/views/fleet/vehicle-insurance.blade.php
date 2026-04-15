@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/fleet/vehicle-insurance.css') }}">
@endsection

@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="wrapper srlog-bdwrapper">
        <div class="main-wrap sc-no-sidebar">

        {{-- Page Header --}}
        <div class="container-fluid page-head">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="mb-0"><i class="uil uil-shield-check me-2"></i>Vehicle Insurance Policies</h6>
                    <p class="text-muted mb-0" style="font-size:12px;">Manage insurance policy records per vehicle</p>
                </div>
                <div class="col-auto">
                    <button class="btn btn-theme btn-sm" data-bs-toggle="modal" data-bs-target="#addPolicyModal">
                        <i class="uil uil-plus me-1"></i>Add Policy
                    </button>
                </div>
            </div>
        </div>

        {{-- Stat Cards --}}
        <div class="vip-stats">
            <div class="vip-stat-card">
                <div class="vip-stat-label">Total Policies</div>
                <div class="vip-stat-value">{{ $stats['total'] }}</div>
            </div>
            <div class="vip-stat-card success">
                <div class="vip-stat-label">Active</div>
                <div class="vip-stat-value">{{ $stats['active'] }}</div>
            </div>
            <div class="vip-stat-card warning">
                <div class="vip-stat-label">Expiring (30 days)</div>
                <div class="vip-stat-value">{{ $stats['expiring'] }}</div>
            </div>
            <div class="vip-stat-card danger">
                <div class="vip-stat-label">Expired</div>
                <div class="vip-stat-value">{{ $stats['expired'] }}</div>
            </div>
        </div>

        {{-- Filter Bar --}}
        <form action="{{ route('fleet.vehicle-insurance.index') }}" method="GET" id="vipFilterForm">
        <div class="vip-filter">
            <span style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.4px;white-space:nowrap;">
                <i class="uil uil-filter me-1"></i>Filter
            </span>
            <input type="text" name="search" value="{{ request('search') }}"
                   class="form-control" style="width:200px;" placeholder="Reg. no. or policy no…">
            <select name="status" class="form-select" style="width:120px;" onchange="this.form.submit()">
                <option value="">All Status</option>
                <option value="Active"    {{ request('status') === 'Active'    ? 'selected' : '' }}>Active</option>
                <option value="Expired"   {{ request('status') === 'Expired'   ? 'selected' : '' }}>Expired</option>
                <option value="Cancelled" {{ request('status') === 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
            <select name="type" class="form-select" style="width:150px;" onchange="this.form.submit()">
                <option value="">All Types</option>
                @foreach(['Comprehensive','Third Party','Zero Dep','Commercial'] as $t)
                <option value="{{ $t }}" {{ request('type') === $t ? 'selected' : '' }}>{{ $t }}</option>
                @endforeach
            </select>
            <select name="expiry" class="form-select" style="width:160px;" onchange="this.form.submit()">
                <option value="">All Expiry</option>
                <option value="soon"    {{ request('expiry') === 'soon'    ? 'selected' : '' }}>Expiring in 30 days</option>
                <option value="expired" {{ request('expiry') === 'expired' ? 'selected' : '' }}>Already expired</option>
            </select>
            <button type="submit" class="btn btn-sm btn-primary" style="font-size:12px;height:34px;padding:0 14px;">
                <i class="uil uil-search me-1"></i>Search
            </button>
            <a href="{{ route('fleet.vehicle-insurance.index') }}"
               class="btn btn-sm" style="font-size:12px;height:34px;padding:0 12px;background:#f1f5f9;color:#475569;border:1px solid #e2e8f0;">
                <i class="uil uil-sync me-1"></i>Reset
            </a>
        </div>
        </form>

        {{-- Table --}}
        <div class="vip-table-wrap">

            <div style="font-size:12px;color:#94a3b8;margin-bottom:10px;">
                Showing <strong style="color:#1e293b;">{{ $policies->total() }}</strong> polic{{ $policies->total() !== 1 ? 'ies' : 'y' }}
                @if(request()->hasAny(['search','status','type','expiry']))
                    — <a href="{{ route('fleet.vehicle-insurance.index') }}" style="color:#032671;font-weight:600;">Clear filters</a>
                @endif
            </div>

            <div class="vip-table-card">
                @if($policies->count())
                <div class="table-responsive">
                    <table class="vip-table">
                        <thead>
                            <tr>
                                <th style="width:130px;">Vehicle</th>
                                <th>Policy Number</th>
                                <th style="width:130px;">Type</th>
                                <th>Insurer</th>
                                <th style="width:110px;text-align:right;padding-right:16px;">Premium</th>
                                <th style="width:130px;">Valid Until</th>
                                <th style="width:90px;">Status</th>
                                <th style="width:100px;text-align:right;padding-right:14px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($policies as $policy)
                            @php
                                $days     = $policy->daysToExpiry();
                                $expClass = $policy->isExpired() ? 'expired' : ($days !== null && $days <= 30 ? 'expiring' : '');
                            @endphp
                            <tr id="policy-row-{{ $policy->id }}">
                                <td>
                                    <span class="vip-reg">{{ $policy->vehicle?->vehicle_number ?? '—' }}</span>
                                    @if($policy->vehicle?->model)
                                    <div style="font-size:11px;color:#94a3b8;margin-top:2px;">{{ $policy->vehicle->manufacturer }} {{ $policy->vehicle->model }}</div>
                                    @endif
                                </td>
                                <td>{{ $policy->policy_number ?: '—' }}</td>
                                <td>{{ $policy->policy_type }}</td>
                                <td>{{ $policy->insurer?->name ?? '—' }}</td>
                                <td style="text-align:right;padding-right:16px;font-weight:600;color:#1e293b;">
                                    @if($policy->premium_amount)
                                        ₹{{ number_format($policy->premium_amount, 0) }}
                                    @else
                                        <span style="color:#cbd5e1;">—</span>
                                    @endif
                                </td>
                                <td>
                                    @if($policy->policy_end_date)
                                    <div class="vip-exp-date {{ $expClass }}">
                                        {{ $policy->policy_end_date->format('d M Y') }}
                                    </div>
                                    @if($days !== null)
                                    <div class="vip-exp-days">
                                        @if($days < 0) {{ abs($days) }} days ago
                                        @elseif($days === 0) Today
                                        @else {{ $days }} days left
                                        @endif
                                    </div>
                                    @endif
                                    @else
                                    <span style="color:#cbd5e1;">—</span>
                                    @endif
                                </td>
                                <td>
                                    @php $badgeClass = match($policy->status) { 'Active' => $expClass ?: 'active', 'Expired' => 'expired', default => 'cancelled' }; @endphp
                                    <span class="vip-badge {{ $badgeClass }}" id="vip-badge-{{ $policy->id }}">{{ $policy->status }}</span>
                                </td>
                                <td>
                                    <div class="vip-actions">
                                        @if($policy->policy_document)
                                        <a href="{{ asset('media/insurance_policies/' . $policy->policy_document) }}"
                                           target="_blank" class="vip-action-btn" title="{{ $policy->policy_document_name ?? 'Policy Document' }}"
                                           style="text-decoration:none;">
                                            <i class="uil uil-file-alt"></i>
                                        </a>
                                        @endif
                                        <button type="button" class="vip-action-btn" title="Edit"
                                            onclick="openEditModal({{ $policy->id }},
                                                {{ $policy->vehicle_id ?? 'null' }},
                                                {{ $policy->insurancecompany_id ?? 'null' }},
                                                @json($policy->policy_number ?? ''),
                                                @json($policy->policy_type),
                                                @json($policy->insured_value ?? ''),
                                                @json($policy->premium_amount ?? ''),
                                                @json($policy->policy_start_date?->format('Y-m-d') ?? ''),
                                                @json($policy->policy_end_date?->format('Y-m-d') ?? ''),
                                                @json($policy->notes ?? '')
                                            )">
                                            <i class="uil uil-pen"></i>
                                        </button>
                                        <button type="button" class="vip-action-btn danger" title="Delete"
                                            onclick="deletePolicy({{ $policy->id }})">
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
                <div class="vip-empty">
                    <i class="uil uil-shield-check"></i>
                    <p style="font-size:13px;font-weight:600;margin:0 0 4px;">No policies found</p>
                    <span style="font-size:12px;">
                        @if(request()->hasAny(['search','status','type','expiry']))
                            No policies match the current filters.
                            <a href="{{ route('fleet.vehicle-insurance.index') }}" style="color:#032671;font-weight:600;">Clear filters</a>
                        @else
                            Click <strong>Add Policy</strong> to get started.
                        @endif
                    </span>
                </div>
                @endif
            </div>

            @if($policies->total() > $policies->perPage())
            <div class="mt-3">
                {{ $policies->appends(request()->only(['search','status','type','expiry']))->links('pagination::bootstrap-5') }}
            </div>
            @endif

        </div>{{-- /vip-table-wrap --}}

        </div>{{-- /main-wrap --}}
    </div>{{-- /wrapper --}}
</div>{{-- /layout-wrapper --}}


{{-- ══════════ ADD MODAL ══════════ --}}
<div class="modal fade vip-modal" id="addPolicyModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="uil uil-plus me-2"></i>Add Insurance Policy</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addPolicyForm" novalidate enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Vehicle <span class="text-danger">*</span></label>
                            <select class="form-select select2" name="vehicle_id" id="add_vehicle_id" style="width:100%;" required>
                                <option value="">— Select Vehicle —</option>
                                @foreach($vehicles as $v)
                                <option value="{{ $v->id }}">{{ $v->vehicle_number }}{{ $v->manufacturer ? ' — ' . $v->manufacturer . ' ' . $v->model : '' }}</option>
                                @endforeach
                            </select>
                            <div class="text-danger mt-1" style="font-size:11px;" id="add_vehicle_id_error"></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Insurer</label>
                            <select class="form-select select2" name="insurancecompany_id" id="add_insurancecompany_id" style="width:100%;">
                                <option value="">— Select Insurer —</option>
                                @foreach($insurers as $ins)
                                <option value="{{ $ins->id }}">{{ $ins->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Policy Number</label>
                            <input type="text" class="form-control" name="policy_number" maxlength="100">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Policy Type <span class="text-danger">*</span></label>
                            <select class="form-select" name="policy_type" required>
                                @foreach(['Comprehensive','Third Party','Zero Dep','Commercial'] as $t)
                                <option value="{{ $t }}">{{ $t }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Insured Value (IDV) ₹</label>
                            <input type="number" class="form-control" name="insured_value" min="0" step="0.01">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Annual Premium ₹</label>
                            <input type="number" class="form-control" name="premium_amount" min="0" step="0.01">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Start Date</label>
                            <input type="date" class="form-control" name="policy_start_date">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">End Date (Expiry)</label>
                            <input type="date" class="form-control" name="policy_end_date">
                        </div>
                        <div class="col-md-8">
                            <label class="form-label">Notes</label>
                            <textarea class="form-control" name="notes" rows="2" maxlength="1000"></textarea>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label"><i class="uil uil-paperclip me-1"></i>Policy Document</label>
                            <input type="file" class="form-control" name="policy_document" accept=".pdf,.jpg,.jpeg,.png">
                            <div class="mt-1" style="font-size:10px;color:#94a3b8;">PDF, JPG or PNG · max 5 MB</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm" id="addPolicyBtn">
                        <span class="spinner-border spinner-border-sm d-none me-1" id="addSpinner"></span>
                        <i class="uil uil-save me-1"></i>Save Policy
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ══════════ EDIT MODAL ══════════ --}}
<div class="modal fade vip-modal" id="editPolicyModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="uil uil-pen me-2"></i>Edit Insurance Policy</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editPolicyForm" novalidate enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" id="edit_id">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Vehicle <span class="text-danger">*</span></label>
                            <select class="form-select select2" name="vehicle_id" id="edit_vehicle_id" style="width:100%;" required>
                                <option value="">— Select Vehicle —</option>
                                @foreach($vehicles as $v)
                                <option value="{{ $v->id }}">{{ $v->vehicle_number }}{{ $v->manufacturer ? ' — ' . $v->manufacturer . ' ' . $v->model : '' }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Insurer</label>
                            <select class="form-select select2" name="insurancecompany_id" id="edit_insurancecompany_id" style="width:100%;">
                                <option value="">— Select Insurer —</option>
                                @foreach($insurers as $ins)
                                <option value="{{ $ins->id }}">{{ $ins->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Policy Number</label>
                            <input type="text" class="form-control" name="policy_number" id="edit_policy_number" maxlength="100">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Policy Type <span class="text-danger">*</span></label>
                            <select class="form-select" name="policy_type" id="edit_policy_type" required>
                                @foreach(['Comprehensive','Third Party','Zero Dep','Commercial'] as $t)
                                <option value="{{ $t }}">{{ $t }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Insured Value (IDV) ₹</label>
                            <input type="number" class="form-control" name="insured_value" id="edit_insured_value" min="0" step="0.01">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Annual Premium ₹</label>
                            <input type="number" class="form-control" name="premium_amount" id="edit_premium_amount" min="0" step="0.01">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Start Date</label>
                            <input type="date" class="form-control" name="policy_start_date" id="edit_policy_start_date">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">End Date (Expiry)</label>
                            <input type="date" class="form-control" name="policy_end_date" id="edit_policy_end_date">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Notes</label>
                            <textarea class="form-control" name="notes" id="edit_notes" rows="2" maxlength="1000"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm" id="editPolicyBtn">
                        <span class="spinner-border spinner-border-sm d-none me-1" id="editSpinner"></span>
                        <i class="uil uil-save me-1"></i>Update Policy
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Toast --}}
<div id="vipToast" class="toast align-items-center border-0" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
        <div class="toast-body fw-semibold" id="vipToastMsg"></div>
        <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"></button>
    </div>
</div>
@endsection

@section('js')
<script>
(function () {
    'use strict';

    const CSRF = document.querySelector('meta[name="csrf-token"]')?.content ?? '';
    const BASE = '{{ route("fleet.vehicle-insurance.index") }}';

    function showToast(msg, ok = true) {
        const el = document.getElementById('vipToast');
        document.getElementById('vipToastMsg').textContent = msg;
        el.classList.remove('bg-success', 'bg-danger', 'text-white');
        el.classList.add(ok ? 'bg-success' : 'bg-danger', 'text-white');
        bootstrap.Toast.getOrCreateInstance(el, { delay: 3500 }).show();
    }

    function clearErrors(prefix) {
        document.querySelectorAll(`[id^="${prefix}_"][id$="_error"]`).forEach(el => el.textContent = '');
        document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    }

    function showErrors(prefix, errors) {
        Object.entries(errors).forEach(([field, msgs]) => {
            const err = document.getElementById(`${prefix}_${field}_error`);
            if (err) err.textContent = Array.isArray(msgs) ? msgs[0] : msgs;
        });
    }

    function apiFetch(url, method, formOrBody) {
        const fd = formOrBody instanceof HTMLFormElement
            ? new FormData(formOrBody)
            : formOrBody;
        if (method !== 'GET' && method !== 'POST') {
            if (fd instanceof FormData) fd.set('_method', method);
        }
        return fetch(url, {
            method : method === 'GET' ? 'GET' : 'POST',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
            body   : method === 'GET' ? undefined : fd,
        }).then(r => r.json());
    }

    /* ── ADD ── */
    document.getElementById('addPolicyForm').addEventListener('submit', function (e) {
        e.preventDefault();
        clearErrors('add');
        const btn = document.getElementById('addPolicyBtn');
        const sp  = document.getElementById('addSpinner');
        btn.disabled = true; sp.classList.remove('d-none');

        apiFetch(BASE, 'POST', this)
            .then(d => {
                if (d.success) {
                    bootstrap.Modal.getInstance(document.getElementById('addPolicyModal')).hide();
                    this.reset();
                    showToast(d.message);
                    setTimeout(() => location.reload(), 900);
                } else if (d.errors) {
                    showErrors('add', d.errors);
                } else {
                    showToast(d.message ?? 'An error occurred.', false);
                }
            })
            .catch(() => showToast('Server error.', false))
            .finally(() => { btn.disabled = false; sp.classList.add('d-none'); });
    });

    /* ── Open edit ── */
    window.openEditModal = function (id, vehicle_id, insurancecompany_id, policy_number, policy_type,
                                     insured_value, premium_amount, start_date, end_date, notes) {
        clearErrors('edit');
        document.getElementById('edit_id').value                   = id;
        document.getElementById('edit_policy_number').value        = policy_number;
        document.getElementById('edit_policy_type').value          = policy_type;
        document.getElementById('edit_insured_value').value        = insured_value;
        document.getElementById('edit_premium_amount').value       = premium_amount;
        document.getElementById('edit_policy_start_date').value    = start_date;
        document.getElementById('edit_policy_end_date').value      = end_date;
        document.getElementById('edit_notes').value                = notes;
        $('#edit_vehicle_id').val(vehicle_id).trigger('change');
        $('#edit_insurancecompany_id').val(insurancecompany_id).trigger('change');
        bootstrap.Modal.getOrCreateInstance(document.getElementById('editPolicyModal')).show();
    };

    /* ── EDIT ── */
    document.getElementById('editPolicyForm').addEventListener('submit', function (e) {
        e.preventDefault();
        clearErrors('edit');
        const id  = document.getElementById('edit_id').value;
        const btn = document.getElementById('editPolicyBtn');
        const sp  = document.getElementById('editSpinner');
        btn.disabled = true; sp.classList.remove('d-none');

        apiFetch(`${BASE}/${id}`, 'PUT', this)
            .then(d => {
                if (d.success) {
                    bootstrap.Modal.getInstance(document.getElementById('editPolicyModal')).hide();
                    showToast(d.message);
                    setTimeout(() => location.reload(), 900);
                } else if (d.errors) {
                    showErrors('edit', d.errors);
                } else {
                    showToast(d.message ?? 'An error occurred.', false);
                }
            })
            .catch(() => showToast('Server error.', false))
            .finally(() => { btn.disabled = false; sp.classList.add('d-none'); });
    });

    /* ── Delete ── */
    window.deletePolicy = function (id) {
        if (!confirm('Remove this insurance policy?\n\nThis can be restored by an administrator.')) return;

        const body = new URLSearchParams({ _method: 'DELETE' });
        apiFetch(`${BASE}/${id}`, 'DELETE', body)
            .then(d => {
                if (d.success) {
                    showToast(d.message);
                    const row = document.getElementById(`policy-row-${id}`);
                    if (row) {
                        row.style.transition = 'opacity .35s';
                        row.style.opacity    = '0';
                        setTimeout(() => row.remove(), 350);
                    }
                } else {
                    showToast(d.message ?? 'Could not delete policy.', false);
                }
            })
            .catch(() => showToast('Server error.', false));
    };

    /* ── Select2 init ── */
    $(document).ready(function () {
        $('#add_vehicle_id').select2({ dropdownParent: $('#addPolicyModal'), width: '100%', placeholder: '— Select Vehicle —' });
        $('#add_insurancecompany_id').select2({ dropdownParent: $('#addPolicyModal'), width: '100%', placeholder: '— Select Insurer —', allowClear: true });
        $('#edit_vehicle_id').select2({ dropdownParent: $('#editPolicyModal'), width: '100%', placeholder: '— Select Vehicle —' });
        $('#edit_insurancecompany_id').select2({ dropdownParent: $('#editPolicyModal'), width: '100%', placeholder: '— Select Insurer —', allowClear: true });
    });

    /* ── Enter on search ── */
    document.querySelector('input[name="search"]')
        ?.addEventListener('keypress', e => {
            if (e.key === 'Enter') { e.preventDefault(); document.getElementById('vipFilterForm').submit(); }
        });

}());
</script>
@endsection
