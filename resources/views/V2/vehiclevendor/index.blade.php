@extends('layouts.app')

@section('css')
<link href="{{ asset('css/V2/vehiclevendor.css?v=2.0') }}" rel="stylesheet">
@endsection

@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="cv2-wrap">
        <div class="cv2-container">

            <div class="cv2-phead">
                <div>
                    <div class="cv2-crumb"><a href="{{ route('contact.v2.vehiclevendor.dashboard') }}">Vehicle Vendor Dashboard</a> · All Vendors</div>
                    <h1>Vehicle Vendors</h1>
                    <div class="cv2-sub">{{ $vendors->total() }} vendors</div>
                </div>
                <div class="cv2-phead-actions">
                    <a href="{{ route('contact.v2.vehiclevendor.dashboard') }}" class="cv2-btn cv2-btn-ghost"><i class="bi bi-speedometer2"></i>Dashboard</a>
                    <a href="{{ route('contact.v2.vehiclevendor.create') }}" class="cv2-btn cv2-btn-primary"><i class="bi bi-plus-lg"></i>Add Vendor</a>
                </div>
            </div>

            <div class="cv2-card">
                <form method="GET" action="{{ route('contact.v2.vehiclevendor.index') }}" id="cv2FilterForm" class="cv2-filters">
                    <div class="cv2-search"><i class="bi bi-search"></i><input type="text" name="name" value="{{ $search_name }}" placeholder="Search by company, contact name or contact no…"></div>
                    <select class="cv2-select" name="city">
                        <option value="">All Cities</option>
                        @foreach($cities as $city)
                            <option value="{{ $city->id }}" {{ (string) $search_city === (string) $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                        @endforeach
                    </select>
                    <select class="cv2-select" name="size">
                        <option value="">All Sizes</option>
                        @foreach(['Small','Medium','Large'] as $sz)
                            <option value="{{ $sz }}" {{ $search_size === $sz ? 'selected' : '' }}>{{ $sz }}</option>
                        @endforeach
                    </select>
                    <select class="cv2-select" name="rag">
                        <option value="">All RAG</option>
                        @foreach(['Green','Yellow','Red'] as $rg)
                            <option value="{{ $rg }}" {{ $search_rag === $rg ? 'selected' : '' }}>{{ $rg }}</option>
                        @endforeach
                    </select>
                    <select class="cv2-select" name="status">
                        <option value="">All Status</option>
                        @foreach(['Active','Inactive','Blacklisted'] as $st)
                            <option value="{{ $st }}" {{ $search_status === $st ? 'selected' : '' }}>{{ $st }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="cv2-btn cv2-btn-primary"><i class="bi bi-funnel"></i>Filter</button>
                    <a href="{{ route('contact.v2.vehiclevendor.index') }}" class="cv2-btn cv2-btn-soft"><i class="bi bi-arrow-counterclockwise"></i>Reset</a>
                </form>

                <div class="cv2-card-b is-flush">
                    <table class="cv2-table">
                        <thead>
                            <tr>
                                <th style="width:34px;"><input type="checkbox"></th>
                                <th>Contact No</th><th>Company / Contact</th><th>Code</th><th>Vehicles</th><th>Size</th>
                                <th>Phone</th><th>City</th><th>RAG</th><th>Status</th>
                                <th style="text-align:right;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($vendors as $v)
                            <tr>
                                <td><input type="checkbox"></td>
                                <td class="cv2-t-mono">{{ $v['contactno'] }}</td>
                                <td>
                                    <div style="display:flex;align-items:center;gap:11px;">
                                        <span class="cv2-avatar" style="width:34px;height:34px;font-size:12px;border-radius:9px;">{{ strtoupper(mb_substr($v['company'],0,1)) }}</span>
                                        <div><span class="cv2-t-name">{{ $v['company'] }}</span><div class="cv2-t-sub">{{ $v['name'] }}</div></div>
                                    </div>
                                </td>
                                <td class="cv2-t-mono">{{ $v['code'] }}</td>
                                <td class="cv2-t-mono">{{ $v['vehicles'] }}</td>
                                <td>{{ $v['size'] }}</td>
                                <td class="cv2-t-mono">{{ $v['phone'] }}</td>
                                <td>{{ $v['city'] }}</td>
                                <td>@php $rc=['Green'=>'is-green','Yellow'=>'is-yellow','Red'=>'is-red'][$v['rag']]??'is-green'; @endphp<span class="cv2-rag {{ $rc }}">{{ $v['rag'] }}</span></td>
                                <td>
                                    @php $sc=['Active'=>'is-active','Inactive'=>'is-inactive','Blacklisted'=>'is-black'][$v['status']]??'is-inactive'; @endphp
                                    <span class="cv2-badge {{ $sc }}"><span class="cv2-badge-dot"></span>{{ $v['status'] }}</span>
                                </td>
                                <td class="cv2-actions">
                                    <a href="{{ route('contact.v2.vehiclevendor.show', $v['id']) }}" class="cv2-ic-btn" title="View"><i class="bi bi-eye"></i></a>
                                    <a href="{{ route('contact.v2.vehiclevendor.edit', $v['id']) }}" class="cv2-ic-btn" title="Edit"><i class="bi bi-pencil"></i></a>
                                    <a href="javascript:void(0)" class="cv2-ic-btn cv2-toggle-vehicle" data-id="{{ $v['id'] }}" title="Toggle status"><i class="bi bi-toggle-on"></i></a>
                                    <a href="javascript:void(0)" class="cv2-ic-btn is-danger cv2-del-vehicle" data-id="{{ $v['id'] }}" title="Delete"><i class="bi bi-trash3"></i></a>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="11" class="text-center cv2-empty">No vehicle vendors found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="cv2-pager">
                    <span>Showing {{ $vendors->firstItem() ?? 0 }}–{{ $vendors->lastItem() ?? 0 }} of {{ $vendors->total() }}</span>
                    {{ $vendors->onEachSide(1)->links('pagination::bootstrap-5') }}
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('js/V2/customer.js?v=2.2') }}"></script>
<script src="{{ asset('js/V2/vehiclevendor.js?v=2.0') }}"></script>
@endsection
