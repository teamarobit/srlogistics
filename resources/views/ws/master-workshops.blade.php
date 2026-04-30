@extends('layouts.app')

@section('css')
<link href="{{ asset('css/Workshop/Master/workshops.css?v=1.1') }}" rel="stylesheet">
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
                    <table class="table table-hover invoice-table mb-0" id="wsTable"
                           data-destroy-url="{{ route('ws.master.workshops.destroy', ['id' => '__ID__']) }}">
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
                            @php
                                $cityName  = $ws->city?->name  ?? '';
                                $stateName = $ws->state?->name ?? '';
                            @endphp
                            <tr
                                data-ownership="{{ strtolower($ws->ownership) }}"
                                data-type="{{ strtolower($ws->workshop_type) }}"
                                data-status="{{ strtolower($ws->status) }}"
                                data-name="{{ strtolower($ws->name) }}"
                                data-city="{{ strtolower($cityName) }}"
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
                                    {{ $cityName }}{{ $cityName && $stateName ? ', ' : '' }}{{ $stateName }}
                                    @if(!$cityName && !$stateName) <span class="text-muted">—</span> @endif
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
                                                    data-state-id="{{ $ws->state_id }}"
                                                    data-city="{{ $cityName }}"
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
            <div class="modal-body">
                {{-- SD-1: all JS in external file. data-* passes config to workshops.js --}}
                <form id="addWsForm" method="POST" action="{{ route('ws.master.workshops.store') }}"
                      data-cities-url="{{ route('ws.master.workshops.cities') }}">
                    @csrf
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

                        {{-- State — Select2, India states (country_id=101) --}}
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">State</label>
                            <select class="form-select" name="state_id" id="addWsState">
                                <option value="">— Select State —</option>
                                @foreach($states as $state)
                                    <option value="{{ $state->id }}">{{ $state->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- City — Select2 tags:true, AJAX-loaded per state --}}
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">City</label>
                            <select class="form-select" name="city" id="addWsCity">
                                <option value="">— Select State first —</option>
                            </select>
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
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-theme btn-sm" id="btnSaveWs" form="addWsForm">
                    <i class="uil uil-save me-1"></i> Save Workshop
                </button>
            </div>
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
                {{-- data-update-url: named route with __ID__ placeholder replaced by JS --}}
                <form id="editWsForm"
                      data-update-url="{{ route('ws.master.workshops.update', ['id' => '__ID__']) }}"
                      data-cities-url="{{ route('ws.master.workshops.cities') }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="editWsId">
                    {{-- hidden ownership field: carries value for controller validation --}}
                    <input type="hidden" name="ownership" id="editWsOwnershipHidden">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Code</label>
                            <input type="text" class="form-control" id="editWsCode" readonly>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label fw-semibold">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" id="editWsName">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Ownership</label>
                            {{-- display-only; actual value sent via hidden #editWsOwnershipHidden --}}
                            <input type="text" class="form-control" id="editWsOwnership" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Workshop Type</label>
                            <select class="form-select" name="workshop_type" id="editWsType">
                                <option>Workshop</option><option>Mobile Unit</option><option>Hybrid</option>
                                <option>Brand ASC</option><option>Third Party</option><option>Warranty</option><option>Multi-Brand</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Brand</label>
                            <input type="text" class="form-control" name="brand" id="editWsBrand">
                        </div>

                        {{-- State — Select2, India states (country_id=101) --}}
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">State</label>
                            <select class="form-select" name="state_id" id="editWsState">
                                <option value="">— Select State —</option>
                                @foreach($states as $state)
                                    <option value="{{ $state->id }}">{{ $state->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- City — Select2 tags:true, AJAX-loaded per state --}}
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">City</label>
                            <select class="form-select" name="city" id="editWsCity">
                                <option value="">— Select State first —</option>
                            </select>
                        </div>

                        <div class="col-8">
                            <label class="form-label fw-semibold">Address</label>
                            <input type="text" class="form-control" name="address" id="editWsAddress" placeholder="Full address">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Pincode</label>
                            <input type="text" class="form-control" name="pincode" id="editWsPincode" placeholder="500001" maxlength="10">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Manager / Contact</label>
                            <input type="text" class="form-control" name="manager_name" id="editWsManager">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Phone</label>
                            <input type="text" class="form-control" name="contact_phone" id="editWsPhone">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" class="form-control" name="contact_email" id="editWsEmail">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Technicians</label>
                            <input type="number" class="form-control" name="technician_count" id="editWsTechs" min="0">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Status</label>
                            <select class="form-select" name="status" id="editWsStatus"><option>Active</option><option>Inactive</option></select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Notes</label>
                            <textarea class="form-control" name="notes" id="editWsNotes" rows="2"></textarea>
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
    <script src="{{ asset('js/Workshop/Master/workshops.js?v=1.2') }}"></script>
@endsection
