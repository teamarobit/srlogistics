@extends('layouts.app')

@section('css')
<link href="{{ asset('css/Workshop/Master/spare-parts.css?v=1.2') }}" rel="stylesheet">
<meta name="sp-base-url" content="{{ route('ws.master.spare-parts') }}">
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
            <a href="{{ route('ws.master.spare-parts') }}" class="btn btn-primary reset-btn">
                <i class="uil uil-history me-1"></i>Reset
            </a>
        </div>
        </form>

        {{-- Table --}}
        <div class="sp-table-wrap">

            <div style="font-size:12px;color:#94a3b8;margin-bottom:10px;">
                @if($parts->total() > 0)
                    Showing <strong style="color:#1e293b;">{{ $parts->firstItem() }}</strong> to
                    <strong style="color:#1e293b;">{{ $parts->lastItem() }}</strong> of
                    <strong style="color:#1e293b;">{{ $parts->total() }}</strong> part{{ $parts->total() !== 1 ? 's' : '' }}
                @else
                    Showing <strong style="color:#1e293b;">0</strong> parts
                @endif
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
                            <tr id="part-row-{{ $part->id }}"
                                data-id="{{ $part->id }}"
                                data-part-no="{{ $part->part_no }}"
                                data-name="{{ $part->name }}"
                                data-category-id="{{ $part->wssparepartscategory_id ?? '' }}"
                                data-compatible-makes="{{ $part->compatible_makes ?? '' }}"
                                data-unit="{{ $part->unit }}"
                                data-standard-cost="{{ $part->standard_cost }}"
                                data-reorder-level="{{ $part->reorder_level }}"
                                data-notes="{{ $part->notes ?? '' }}"
                                data-status="{{ $part->status }}">
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
                                        <button type="button" class="sp-action-btn sp-edit" title="Edit">
                                            <i class="uil uil-pen"></i>
                                        </button>
                                        <button type="button"
                                            class="sp-action-btn sp-toggle {{ $part->status === 'Inactive' ? 'activate' : '' }}"
                                            title="{{ $part->status === 'Active' ? 'Deactivate' : 'Activate' }}">
                                            <i class="uil {{ $part->status === 'Active' ? 'uil-toggle-off' : 'uil-toggle-on' }}"></i>
                                        </button>
                                        <button type="button" class="sp-action-btn danger sp-remove" title="Remove">
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
            <form id="addPartForm" method="POST" action="{{ route('ws.master.spare-parts.store') }}" novalidate>
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Part No. <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="part_no" id="add_part_no"
                                       placeholder="SP-0001" required maxlength="50">
                                <button type="button" class="btn btn-outline-secondary" style="font-size:12px;"
                                        id="autoFillPartNoBtn" title="Auto-generate">
                                    <i class="uil uil-sync"></i>
                                </button>
                            </div>
                            <span class="text-danger small d-block mt-1" id="add_part_no_error"></span>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label">Part Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" id="add_name"
                                   placeholder="e.g. Engine Oil Filter" required maxlength="255">
                            <span class="text-danger small d-block mt-1" id="add_name_error"></span>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Category <span class="text-danger">*</span></label>
                            <select class="form-select select2" name="wssparepartscategory_id" id="add_category_id" style="width:100%;">
                                <option value="">— Select Category —</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger small d-block mt-1" id="add_wssparepartscategory_id_error"></span>
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
                                <input type="number" class="form-control" name="standard_cost" id="add_standard_cost"
                                       min="0" step="0.01" value="0" required>
                            </div>
                            <span class="text-danger small d-block mt-1" id="add_standard_cost_error"></span>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Reorder Level <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="reorder_level" id="add_reorder_level"
                                   min="0" value="5" required>
                            <span class="text-danger small d-block mt-1" id="add_reorder_level_error"></span>
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
            <form id="editPartForm" method="POST" action="#" novalidate>
                @csrf
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" id="edit_id">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Part No. <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="part_no" id="edit_part_no"
                                   required maxlength="50">
                            <span class="text-danger small d-block mt-1" id="edit_part_no_error"></span>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label">Part Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" id="edit_name"
                                   required maxlength="255">
                            <span class="text-danger small d-block mt-1" id="edit_name_error"></span>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Category <span class="text-danger">*</span></label>
                            <select class="form-select select2" name="wssparepartscategory_id" id="edit_category_id" style="width:100%;">
                                <option value="">— Select Category —</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger small d-block mt-1" id="edit_wssparepartscategory_id_error"></span>
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
                            <span class="text-danger small d-block mt-1" id="edit_standard_cost_error"></span>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Reorder Level <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="reorder_level" id="edit_reorder_level"
                                   min="0" required>
                            <span class="text-danger small d-block mt-1" id="edit_reorder_level_error"></span>
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
<script src="{{ asset('js/Workshop/Master/spare-parts.js?v=1.4') }}"></script>
@endsection
