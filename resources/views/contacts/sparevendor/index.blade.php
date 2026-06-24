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
                            <h6 class="mb-0">Spare Part Vendor</h6>

                            @if(Route::has('contact.sparevendor.create'))
                            <a href="{{ route('contact.sparevendor.create') }}" class="btn btn-theme btn-sm">
                                <i class="uil uil-plus me-1"></i>Spare Part Vendor
                            </a>
                            @endif

                            <button type="button" id="bulkDeleteBtn" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal" style="display:none;">
                                <i class="uil uil-trash-alt me-1"></i>Delete
                            </button>

                            <form action="{{ route('contact.sparevendor.index') }}" method="GET" class="d-flex align-items-center ms-1" id="filterForm">
                                <div class="search-wrap d-inline-block ms-1" style="width:160px;">
                                    <input type="text" name="name" value="{{ $search_name ?? '' }}"
                                        class="form-control" placeholder="Search by Name">
                                </div>
                                <div class="search-wrap d-inline-block ms-1" style="width:140px;">
                                    <select name="city" id="spvCityFilter" class="form-select select2">
                                        <option value="">Filter by City</option>
                                        @foreach($cities as $city)
                                        <option value="{{ $city->id }}" {{ ($search_city ?? '') == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <a href="{{ route('contact.sparevendor.index') }}" style="text-transform: capitalize;" class="btn btn-primary reset-btn ms-1">Reset</a>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="table-responsive mt-3">
                    <table class="table table-hover sc-table mb-0" id="spvTable">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="selectAll"></th>
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
                                <td><input type="checkbox" class="rowCheckbox" value="{{ $contact->id }}"></td>
                                <td class="fw-semibold"><a href="{{ route('contact.sparevendor.edit', $contact->id) }}" class="text-dark text-decoration-none hover-link">{{ $contact->contact_name ?? '—' }}</a></td>
                                <td style="font-size:12px;color:#555;">{{ $contact->company_name ?? '—' }}</td>
                                <td>
                                    @if($contact->specialisation)
                                        @foreach(explode(',', $contact->specialisation) as $spec)
                                            @php $specId = trim($spec); $specName = $specMap[$specId] ?? null; @endphp
                                            @if($specName)
                                                <span class="badge bg-primary m-1" style="font-size:10px;">{{ $specName }}</span>
                                            @endif
                                        @endforeach
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>
                                    {{ $contact->relcontacts->first()?->name ?? '—' }}<br>
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
                                <td colspan="9" class="text-center text-muted py-4">No spare part vendors found.</td>
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

<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Option</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="form-check form-check-inline radio-chip">
                    <input class="form-check-input" type="radio" name="deleteType" id="delete_selected" value="selected" checked>
                    <label class="form-check-label" for="delete_selected">
                        <i class="uil uil-check-circle me-1"></i>Delete Selected
                    </label>
                </div>
                <div class="form-check form-check-inline radio-chip">
                    <input class="form-check-input" type="radio" name="deleteType" id="delete_all" value="all">
                    <label class="form-check-label" for="delete_all">
                        <i class="uil uil-check-circle me-1"></i>Delete All
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
            </div>
        </div>
    </div>
</div>

@section('js')
<script>
var CSRF        = $('meta[name="csrf-token"]').attr('content');
var CO_TYPE     = "{{ $cotype->slug }}";
var TOGGLE_BASE = '/contacts/sparevendor/';
var DELETE_BASE = '/contacts/sparevendor/';
var DELETE_SELECTED_CONTACT = "{{ route('contact.delete.selected') }}";
var DELETE_ALL  = "{{ route('contact.delete.all') }}";
</script>
<script src="{{ asset('customjs/contact/sparevendor/index.js?v=1.3') }}"></script>
@endsection
