@extends('layouts.app')

@section('css')
<link href="{{ asset('css/Warehouse/master.css?v=2.0') }}" rel="stylesheet">
@endsection

@section('content')
<div class="layout-wrapper">

    @include('includes.header')

    <div class="wrapper srlog-bdwrapper">
        <div class="side-wrap">

            @include('includes.leftbar')

            <div class="main-wrap">

                {{-- Session flash --}}
                @if(session('success'))
                    <div class="d-none" id="flashSuccess">{!! session('success') !!}</div>
                @endif

                {{-- Page Header --}}
                <div class="container-fluid page-head">
                    <div class="row align-items-center gy-2">
                        <div class="col-md-6 d-flex flex-wrap align-items-center gap-2">
                            <h5 class="mb-0 me-2">Warehouse Master</h5>
                            <ul class="nav filter-tabs border-0 gap-1 mb-0" id="whTypeTabs">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#" data-type="">All <span class="badge bg-secondary ms-1">{{ $warehouses->count() }}</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#" data-type="central">Central <span class="badge ms-1" style="background:#e8f0fe;color:#032671;">{{ $warehouses->where('warehouse_type','Central')->count() }}</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#" data-type="regional">Regional <span class="badge ms-1" style="background:#fff4e5;color:#b35c00;">{{ $warehouses->where('warehouse_type','Regional')->count() }}</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#" data-type="site/yard">Site/Yard <span class="badge ms-1" style="background:#f0fdf4;color:#166534;">{{ $warehouses->where('warehouse_type','Site/Yard')->count() }}</span></a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6 d-flex flex-wrap align-items-center justify-content-md-end gap-2">
                            <input type="text" class="form-control form-control-sm" id="whSearch" placeholder="Search name / code / city…" style="width:200px;">
                            <select class="form-select form-select-sm" id="whStatusFilter" style="width:120px;">
                                <option value="">All Status</option>
                                <option>Active</option>
                                <option>Inactive</option>
                            </select>
                            <a href="{{ route('warehouse.master.create') }}" class="btn btn-primary btn-sm">
                                <i class="uil uil-plus me-1"></i> Add Warehouse
                            </a>
                        </div>
                    </div>

                    <div class="wh-stats-strip mt-3">
                        <div class="wh-stat-pill">Total <strong>{{ $warehouses->count() }}</strong></div>
                        <div class="wh-stat-pill">Active <strong>{{ $warehouses->where('status','Active')->count() }}</strong></div>
                        <div class="wh-stat-pill">Inactive <strong>{{ $warehouses->where('status','Inactive')->count() }}</strong></div>
                    </div>
                </div>

                {{-- Table --}}
                <div class="table-responsive mt-2">
                    <table class="table table-hover invoice-table mb-0" id="whTable">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>City / State</th>
                                <th>Manager</th>
                                <th>Contact</th>
                                <th>Storage</th>
                                <th>Status</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($warehouses as $wh)
                            <tr
                                data-type="{{ strtolower($wh->warehouse_type ?? '') }}"
                                data-status="{{ strtolower($wh->status) }}"
                                data-name="{{ strtolower($wh->name) }}"
                                data-city="{{ strtolower($wh->city_name ?? '') }}"
                                data-code="{{ strtolower($wh->warehouse_code ?? '') }}"
                            >
                                <td><span class="wh-code">{{ $wh->warehouse_code ?? '—' }}</span></td>
                                <td class="fw-semibold">{{ $wh->name }}</td>
                                <td>
                                    @if($wh->warehouse_type === 'Central')
                                        <span class="wh-type-badge wh-type-central">Central</span>
                                    @elseif($wh->warehouse_type === 'Regional')
                                        <span class="wh-type-badge wh-type-regional">Regional</span>
                                    @elseif($wh->warehouse_type === 'Site/Yard')
                                        <span class="wh-type-badge wh-type-site">Site/Yard</span>
                                    @else
                                        <span class="text-muted" style="font-size:12px;">—</span>
                                    @endif
                                </td>
                                <td>
                                    {{ $wh->city_name ?? '—' }}
                                    @if($wh->state)
                                        <br><small class="text-muted">{{ $wh->state->name }}</small>
                                    @endif
                                </td>
                                <td>
                                    {{ $wh->manager?->contact_name ?? '—' }}
                                </td>
                                <td>{{ $wh->contact_number ?? '—' }}</td>
                                <td>
                                    @if($wh->storage_type)
                                        <span class="wh-storage-badge">{{ $wh->storage_type }}</span>
                                    @else
                                        <span class="text-muted" style="font-size:12px;">—</span>
                                    @endif
                                </td>
                                <td>
                                    @if($wh->status === 'Active')
                                        <span class="wh-status-active">Active</span>
                                    @else
                                        <span class="wh-status-inactive">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="wh-action-wrap">
                                        <a href="{{ route('warehouse.master.edit', $wh->id) }}" class="wh-btn-edit" title="Edit">
                                            <i class="uil uil-pen"></i>
                                        </a>
                                        <a href="javascript:void(0)" class="wh-btn-delete btn-delete-wh" title="Delete"
                                           data-id="{{ $wh->id }}" data-name="{{ $wh->name }}">
                                            <i class="uil uil-trash-alt"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9">
                                    <div class="wh-empty-state">
                                        <i class="uil uil-warehouse"></i>
                                        <p>No warehouses added yet.<br>Click <strong>+ Add Warehouse</strong> to get started.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>{{-- /main-wrap --}}
        </div>{{-- /side-wrap --}}
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('js/Warehouse/index.js?v=1.0') }}"></script>
@endsection
