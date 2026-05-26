@extends('layouts.app')

@section('css')

<link rel="stylesheet" href="{{ asset('css/Provider/digilock-index.css?v=1.2') }}">


@endsection

@section('content')

<div class="layout-wrapper">
    @include('includes.header')
    <div class="wrapper srlog-bdwrapper">
        <div class="side-wrap">
            @include('includes.leftbar')

            <div class="main-wrap">
                <div class="container-fluid page-head">
                    <div class="row align-items-end">
                        <div class="col-12">

                            {{-- BUG-008 — breadcrumb --}}
                            <div class="dl-breadcrumb">
                                <a href="{{ route('adminconsole.index') }}">Admin Console</a>
                                <span class="sep">›</span>
                                <span>Provider Master</span>
                                <span class="sep">›</span>
                                Digital Lock Provider
                            </div>

                            <h5 class="d-inline-block mb-0">Digital Lock Provider</h5>
                            {{-- BUG-006 — CTA label distinct from heading --}}
                            <a href="{{ route('digilockprovider.create') }}" class="btn btn-theme mb-0 ms-2"><i class="uil uil-plus me-1"></i>Add Digital Lock Provider</a>

                            <form action="{{ route('digilockprovider.index') }}" id="searchform" class="d-inline-block">
                                <div class="search-wrap d-inline-block ms-2" style="width: 230px;">
                                    <input type="text" name="name" id="search_name" value="{{ old('name', $search_name) }}" class="form-control" placeholder="Search by Name">
                                </div>
                                <div class="search-wrap d-inline-block ms-2" style="width: 180px;">
                                      <select name="status" id="search_status" class="form-select">
                                          <option value="">Filter by Status</option>
                                          <option value="Active" {{ old('status', $search_status) == 'Active' ? 'selected' : '' }}>Active</option>
                                          <option value="Inactive" {{ old('status', $search_status) == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                      </select>
                                </div>
                                {{-- BUG-009 — visible Search submit button --}}
                                <button type="submit" class="btn btn-primary ms-2" id="searchBtn" title="Search">
                                    <i class="uil uil-search me-1"></i>Search
                                </button>
                            </form>

                            <a href="{{ route('digilockprovider.index') }}" class="btn btn-primary reset-btn"><i class="uil uil-history me-1"></i>Reset</a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive mt-3">
                    <table class="table table-hover invoice-table mb-0">
                        <thead>
                            @php
                                // Build sortable header link — toggles dir, preserves other filters
                                $buildSortUrl = function ($col) use ($current_sort, $current_dir, $search_name, $search_status) {
                                    $nextDir = ($current_sort === $col && $current_dir === 'asc') ? 'desc' : 'asc';
                                    return route('digilockprovider.index', array_filter([
                                        'name'   => $search_name,
                                        'status' => $search_status,
                                        'sort'   => $col,
                                        'dir'    => $nextDir,
                                    ], fn($v) => !is_null($v) && $v !== ''));
                                };
                                $sortIcon = function ($col) use ($current_sort, $current_dir) {
                                    if ($current_sort !== $col) {
                                        return '<i class="uil uil-sort ms-1 text-muted small"></i>';
                                    }
                                    return $current_dir === 'asc'
                                        ? '<i class="uil uil-sort-amount-up ms-1 small"></i>'
                                        : '<i class="uil uil-sort-amount-down ms-1 small"></i>';
                                };
                            @endphp
                            <tr>
                                <th><a class="dl-sort" href="{{ $buildSortUrl('name') }}">Name {!! $sortIcon('name') !!}</a></th>
                                <th><a class="dl-sort" href="{{ $buildSortUrl('code') }}">Code {!! $sortIcon('code') !!}</a></th>
                                <th><a class="dl-sort" href="{{ $buildSortUrl('status') }}">Status {!! $sortIcon('status') !!}</a></th>
                                <th><a class="dl-sort" href="{{ $buildSortUrl('created_by') }}">Created By {!! $sortIcon('created_by') !!}</a></th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse($datas as $key => $value)
                            <tr>

                                <td>{{ $value->name ?? '' }}</td>
                                <td>{{ $value->code ?? '' }}</td>
                                <td>
                                    <span class="badge bg-{{ $value->status == 'Active' ? 'success' : 'danger' }}">
                                        {{ $value->status }}
                                    </span>
                                </td>
                                <td>
                                    {{$value->createdBy?->name}}
                                    <span class="text-secondary d-block">{{$value->createdBy?->email}}</span>
                                </td>
                                <td class="text-end">
                                    <div class="dropdown dot-dd">
                                      <span class="dropdown-toggle" id="moreTable" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="uil uil-ellipsis-h"></i>
                                      </span>
                                      <ul class="dropdown-menu" aria-labelledby="moreTable">
                                        {{-- BUG-002 — View action --}}
                                        <li>
                                            <a class="dropdown-item viewRecord" href="javascript:void(0)"
                                               data-id="{{ $value->id }}"
                                               data-name="{{ $value->name }}"
                                               data-code="{{ $value->code }}"
                                               data-status="{{ $value->status }}"
                                               data-createdby="{{ $value->createdBy?->name }}"
                                               data-createdemail="{{ $value->createdBy?->email }}"
                                               data-created="{{ $value->created_at ? $value->created_at->format('d-M-Y H:i') : '' }}"
                                               data-updated="{{ $value->updated_at ? $value->updated_at->format('d-M-Y H:i') : '' }}">
                                                <i class="uil uil-eye me-2"></i>View
                                            </a>
                                        </li>
                                        <li><a class="dropdown-item" href="{{ route('digilockprovider.edit', $value->id) }}"><i class="uil uil-pen me-2"></i>Edit</a></li>
                                        {{-- BUG-001 / BUG-010 — Delete action --}}
                                        {{--<li><a class="dropdown-item text-danger deleteRecord" data-id="{{ $value->id }}" href="javascript:void(0)"><i class="uil uil-trash-alt me-2"></i>Delete</a></li>--}}
                                      </ul>
                                    </div>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">
                                        No data found.
                                    </td>
                                </tr>
                            @endforelse


                        </tbody>
                    </table>
                </div>


                @if ($datas->hasPages())
                <nav aria-label="Page navigation" class="mt-4">
                    <ul class="pagination justify-content-end">

                        {{-- Previous --}}
                        <li class="page-item {{ $datas->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $datas->previousPageUrl() }}">Previous</a>
                        </li>

                        {{-- Page Numbers --}}
                        @foreach ($datas->getUrlRange(1, $datas->lastPage()) as $page => $url)
                            <li class="page-item {{ $datas->currentPage() == $page ? 'active' : '' }}">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endforeach

                        {{-- Next --}}
                        <li class="page-item {{ $datas->hasMorePages() ? '' : 'disabled' }}">
                            <a class="page-link" href="{{ $datas->nextPageUrl() }}">Next</a>
                        </li>

                    </ul>
                </nav>
                @endif

            </div>
        </div>
    </div>
</div>

{{-- BUG-002 — read-only View modal --}}
<div class="modal fade" id="viewProviderModal" tabindex="-1" aria-labelledby="viewProviderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewProviderModalLabel">Digital Lock Provider</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-borderless mb-0">
                    <tbody>
                        <tr>
                            <th style="width: 35%;">Name</th>
                            <td id="view_name">—</td>
                        </tr>
                        <tr>
                            <th>Code</th>
                            <td id="view_code">—</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td id="view_status">—</td>
                        </tr>
                        <tr>
                            <th>Created By</th>
                            <td id="view_createdby">—</td>
                        </tr>
                        <tr>
                            <th>Created On</th>
                            <td id="view_created">—</td>
                        </tr>
                        <tr>
                            <th>Last Updated</th>
                            <td id="view_updated">—</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')

{{-- SD-1 — config variables only, no business logic --}}
<script>
    var LISTING       = "{{ route('digilockprovider.index') }}";
    var DELETE_DATA   = "{{ route('digilockprovider.delete') }}";
    var FLASH_SUCCESS = @json(session('success'));
    var FLASH_ERROR   = @json(session('error'));
</script>
<script type="text/javascript" src="{{ asset('customjs/provider/digilock/index.js?v=1.2') }}"></script>
@endsection
