@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/Contacts/InsuranceProvider/index.css?v=1.1') }}">
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
                    <h6 class="mb-0"><i class="uil uil-building me-2"></i>Insurance Providers</h6>
                    <p class="text-muted mb-0 ip-subtitle">Master list of insurance companies</p>
                </div>
                <div class="col-auto">
                    <button class="btn btn-theme btn-sm" data-bs-toggle="modal" data-bs-target="#addProviderModal">
                        <i class="uil uil-plus me-1"></i>Add Provider
                    </button>
                </div>
            </div>
        </div>

        {{-- Filter Bar --}}
        <form action="{{ route('contact.insuranceprovider.index') }}" method="GET" id="ipFilterForm">
        <div class="ip-filter">
            <span style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.4px;white-space:nowrap;">
                <i class="uil uil-filter me-1"></i>Filter
            </span>
            <input type="text" name="name" value="{{ request('name') }}"
                   class="form-control ip-filter-search" placeholder="Search company or contact…">
            <select name="city" class="form-select ip-filter-city" onchange="this.form.submit()">
                <option value="">All Cities</option>
                @foreach($cities as $city)
                <option value="{{ $city->id }}" {{ request('city') == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-sm btn-primary ip-filter-btn">
                <i class="uil uil-search me-1"></i>Search
            </button>
            <a href="{{ route('contact.insuranceprovider.index') }}" class="btn btn-sm ip-filter-reset">
                <i class="uil uil-sync me-1"></i>Reset
            </a>
        </div>
        </form>

        {{-- Content --}}
        <div class="ip-body">

            {{-- Meta row --}}
            <div class="ip-meta-row">
                <span class="ip-count-label">
                    <strong>{{ $contacts->total() }}</strong> provider{{ $contacts->total() !== 1 ? 's' : '' }}
                    @if(request()->hasAny(['name','city']))
                        &nbsp;·&nbsp;<a href="{{ route('contact.insuranceprovider.index') }}" class="ip-clear-link"><i class="uil uil-times-circle me-1"></i>Clear filters</a>
                    @endif
                </span>
                <div class="ip-legend">
                    <span class="ip-legend-dot active"></span>Active
                    <span class="ip-legend-dot inactive ms-2"></span>Inactive
                </div>
            </div>

            @if($contacts->count())
            <div class="ip-card-grid">
                @foreach($contacts as $contact)
                <div class="ip-card" id="ip-row-{{ $contact->id }}">

                    {{-- Logo --}}
                    <div class="ip-card-logo">
                        @if($contact->contact_image)
                            <img src="{{ asset('media/contact/' . $contact->contact_image) }}"
                                 alt="{{ $contact->company_name }}" class="ip-card-logo-img">
                        @else
                            <span class="ip-card-logo-placeholder"><i class="uil uil-building"></i></span>
                        @endif
                        <span class="ip-card-status-dot {{ strtolower($contact->status) }}"
                              id="ip-badge-{{ $contact->id }}" title="{{ $contact->status }}"></span>
                    </div>

                    {{-- Body --}}
                    <div class="ip-card-body">
                        <div class="ip-card-name">{{ $contact->company_name }}</div>
                        <div class="ip-card-meta">
                            <span class="ip-card-code">{{ $contact->contact_code }}</span>
                            @if($contact->gst_number)
                            <span class="ip-card-gst">GST: {{ $contact->gst_number }}</span>
                            @endif
                        </div>
                        <div class="ip-card-details">
                            <span class="ip-card-detail-item">
                                <i class="uil uil-user-circle"></i>{{ $contact->contact_name }}
                            </span>
                            <span class="ip-card-detail-item">
                                <i class="uil uil-phone"></i>{{ $contact->phone }}
                            </span>
                            @if($contact->email)
                            <span class="ip-card-detail-item ip-card-detail-email">
                                <i class="uil uil-envelope-alt"></i>{{ $contact->email }}
                            </span>
                            @endif
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="ip-card-actions">
                        <button type="button" class="ip-act-btn" title="Edit"
                                onclick="openEditModal({{ $contact->id }})">
                            <i class="uil uil-pen"></i>
                        </button>
                        <button type="button"
                            class="ip-act-btn {{ $contact->status === 'Inactive' ? 'on' : '' }}"
                            title="{{ $contact->status === 'Active' ? 'Deactivate' : 'Activate' }}"
                            onclick="toggleStatus({{ $contact->id }}, '{{ $contact->status }}')">
                            <i class="uil {{ $contact->status === 'Active' ? 'uil-toggle-off' : 'uil-toggle-on' }}"></i>
                        </button>
                        <button type="button" class="ip-act-btn danger" title="Delete"
                                onclick="deleteProvider({{ $contact->id }}, @json($contact->company_name))">
                            <i class="uil uil-trash-alt"></i>
                        </button>
                    </div>

                </div>
                @endforeach
            </div>

            @else
            <div class="ip-empty">
                <i class="uil uil-building"></i>
                <p class="ip-empty-title">No insurance providers found</p>
                <span class="ip-empty-sub">
                    @if(request()->hasAny(['name','city']))
                        No providers match the filters.
                        <a href="{{ route('contact.insuranceprovider.index') }}" class="ip-clear-link">Clear filters</a>
                    @else
                        Click <strong>Add Provider</strong> to get started.
                    @endif
                </span>
            </div>
            @endif

            @if($contacts->total() > $contacts->perPage())
            <div class="mt-3">
                {{ $contacts->appends(request()->only(['name','city']))->links('pagination::bootstrap-5') }}
            </div>
            @endif

        </div>{{-- /ip-table-wrap --}}

            </div>{{-- /main-wrap --}}
        </div>{{-- /side-wrap --}}
    </div>{{-- /wrapper --}}
</div>{{-- /layout-wrapper --}}


{{-- ══════════ ADD MODAL ══════════ --}}
<div class="modal fade ip-modal" id="addProviderModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered ip-modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="uil uil-plus me-2"></i>Add Insurance Provider</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addProviderForm" novalidate enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="ip-logo-upload-row">
                                <div class="ip-logo-preview" id="add_logo_preview">
                                    <i class="uil uil-building ip-logo-placeholder-icon"></i>
                                </div>
                                <div class="ip-logo-upload-info">
                                    <label class="form-label mb-1">Company Logo</label>
                                    <input type="file" class="form-control ip-logo-input" name="contact_image" id="add_contact_image"
                                           accept="image/jpeg,image/png,image/webp">
                                    <div class="ip-logo-hint">JPG, PNG or WebP — max 2 MB</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Company Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="company_name" id="add_company_name"
                                   placeholder="e.g. New India Assurance" required maxlength="100">
                            <div class="text-danger mt-1" style="font-size:11px;" id="add_company_name_error"></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Contact Person <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="contact_name" id="add_contact_name"
                                   placeholder="Representative name" required maxlength="100">
                            <div class="text-danger mt-1" style="font-size:11px;" id="add_contact_name_error"></div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Contact Code <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="contact_code" id="add_contact_code"
                                   placeholder="e.g. INS-001" required maxlength="100">
                            <div class="text-danger mt-1" style="font-size:11px;" id="add_contact_code_error"></div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Phone <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="phone" id="add_phone"
                                   placeholder="10-digit number" required maxlength="10">
                            <div class="text-danger mt-1" style="font-size:11px;" id="add_phone_error"></div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" maxlength="100">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">GST Number</label>
                            <input type="text" class="form-control" name="gst_number" maxlength="20">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">State</label>
                            <select class="form-select select2" name="state_id" id="add_state_id" style="width:100%;">
                                <option value="">— Select State —</option>
                                @foreach($states as $state)
                                <option value="{{ $state->id }}">{{ $state->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Status</label>
                            <div class="d-flex gap-3 mt-1">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" value="Active" id="add_status_active" checked>
                                    <label class="form-check-label" for="add_status_active">Active</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" value="Inactive" id="add_status_inactive">
                                    <label class="form-check-label" for="add_status_inactive">Inactive</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm" id="addProviderBtn">
                        <span class="spinner-border spinner-border-sm d-none me-1" id="addSpinner"></span>
                        <i class="uil uil-save me-1"></i>Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ══════════ EDIT MODAL ══════════ --}}
<div class="modal fade ip-modal" id="editProviderModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered ip-modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="uil uil-pen me-2"></i>Edit Insurance Provider</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editProviderForm" novalidate enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="edit_id">
                <div class="modal-body" id="editModalBody">
                    {{-- Filled via JS --}}
                    <div class="text-center py-4" id="editLoadingSpinner">
                        <div class="spinner-border text-primary" role="status"></div>
                    </div>
                    <div id="editFormFields" class="d-none">
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="ip-logo-upload-row">
                                <div class="ip-logo-preview" id="edit_logo_preview">
                                    <i class="uil uil-building ip-logo-placeholder-icon" id="edit_logo_placeholder"></i>
                                    <img src="" alt="Logo" id="edit_logo_img" class="ip-logo-img d-none">
                                </div>
                                <div class="ip-logo-upload-info">
                                    <label class="form-label mb-1">Company Logo</label>
                                    <input type="file" class="form-control ip-logo-input" name="contact_image" id="edit_contact_image"
                                           accept="image/jpeg,image/png,image/webp">
                                    <div class="ip-logo-hint">Upload new image to replace current. JPG, PNG or WebP — max 2 MB</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Company Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="company_name" id="edit_company_name" required maxlength="100">
                            <div class="text-danger mt-1" style="font-size:11px;" id="edit_company_name_error"></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Contact Person <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="contact_name" id="edit_contact_name" required maxlength="100">
                            <div class="text-danger mt-1" style="font-size:11px;" id="edit_contact_name_error"></div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Contact Code <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="contact_code" id="edit_contact_code" required maxlength="100">
                            <div class="text-danger mt-1" style="font-size:11px;" id="edit_contact_code_error"></div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Phone <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="phone" id="edit_phone" required maxlength="10">
                            <div class="text-danger mt-1" style="font-size:11px;" id="edit_phone_error"></div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" id="edit_email" maxlength="100">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">GST Number</label>
                            <input type="text" class="form-control" name="gst_number" id="edit_gst_number" maxlength="20">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">State</label>
                            <select class="form-select select2" name="state_id" id="edit_state_id" style="width:100%;">
                                <option value="">— Select State —</option>
                                @foreach($states as $state)
                                <option value="{{ $state->id }}">{{ $state->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Status</label>
                            <div class="d-flex gap-3 mt-1">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" value="Active" id="edit_status_active">
                                    <label class="form-check-label" for="edit_status_active">Active</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" value="Inactive" id="edit_status_inactive">
                                    <label class="form-check-label" for="edit_status_inactive">Inactive</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>{{-- /editFormFields --}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm" id="editProviderBtn">
                        <span class="spinner-border spinner-border-sm d-none me-1" id="editSpinner"></span>
                        <i class="uil uil-save me-1"></i>Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Toast --}}
<div id="ipToast" class="toast align-items-center border-0" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
        <div class="toast-body fw-semibold" id="ipToastMsg"></div>
        <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"></button>
    </div>
</div>
@endsection

@section('js')
<script>
window.IP_SAVE     = '{{ route("contact.insuranceprovider.save") }}';
window.IP_JSON_URL = '{{ url("contacts/insurance-provider") }}';
</script>
<script src="{{ asset('js/Contacts/InsuranceProvider/index.js?v=1.1') }}"></script>
@endsection
