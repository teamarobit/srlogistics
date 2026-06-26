@extends('layouts.app')

@section('css')
<link href="{{ asset('css/V2/customer.css?v=1.4') }}" rel="stylesheet">
@endsection

@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="cv2-wrap">
        <div class="cv2-container">

            <div class="cv2-phead">
                <div>
                    <div class="cv2-crumb"><a href="{{ route('contact.v2.customer.dashboard') }}">Customer Dashboard</a> · All Customers</div>
                    <h1>Customers</h1>
                    <div class="cv2-sub">{{ $customers->total() }} customers</div>
                </div>
                <div class="cv2-phead-actions">
                    <a href="{{ route('contact.v2.customer.dashboard') }}" class="cv2-btn cv2-btn-ghost"><i class="bi bi-speedometer2"></i>Dashboard</a>
                    <a href="{{ route('contact.v2.customer.create') }}" class="cv2-btn cv2-btn-primary"><i class="bi bi-plus-lg"></i>Add Customer</a>
                </div>
            </div>

            <div class="cv2-card">
                <form method="GET" action="{{ route('contact.v2.customer.index') }}" id="cv2FilterForm" class="cv2-filters">
                    <div class="cv2-search"><i class="bi bi-search"></i><input type="text" name="name" value="{{ $search_name }}" placeholder="Search by customer name…"></div>
                    <select class="cv2-select" name="city">
                        <option value="">All Cities</option>
                        @foreach($cities as $city)
                            <option value="{{ $city->id }}" {{ (string) $search_city === (string) $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                        @endforeach
                    </select>
                    <select class="cv2-select" name="size">
                        <option value="">All Sizes</option>
                        @foreach(['Large','Medium','Small'] as $sz)
                            <option value="{{ $sz }}" {{ $search_size === $sz ? 'selected' : '' }}>{{ $sz }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="cv2-btn cv2-btn-primary"><i class="bi bi-funnel"></i>Filter</button>
                    <a href="{{ route('contact.v2.customer.index') }}" class="cv2-btn cv2-btn-soft"><i class="bi bi-arrow-counterclockwise"></i>Reset</a>
                </form>

                <div class="cv2-card-b is-flush">
                    <table class="cv2-table">
                        <thead>
                            <tr>
                                <th style="width:34px;"><input type="checkbox"></th>
                                <th>Contact No</th><th>Customer</th><th>Type</th><th>Size</th>
                                <th>Phone</th><th>City</th><th>Locations</th><th>Contracts</th><th>Status</th>
                                <th style="text-align:right;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($customers as $c)
                            <tr>
                                <td><input type="checkbox"></td>
                                <td class="cv2-t-mono">{{ $c['contactno'] }}</td>
                                <td>
                                    <div style="display:flex;align-items:center;gap:11px;">
                                        <span class="cv2-avatar" style="width:34px;height:34px;font-size:12px;border-radius:9px;">{{ strtoupper(mb_substr($c['name'],0,1)) }}</span>
                                        <div><span class="cv2-t-name">{{ $c['name'] }}</span><div class="cv2-t-sub">{{ $c['email'] }}</div></div>
                                    </div>
                                </td>
                                <td><span class="cv2-pill">{{ $c['type'] }}</span></td>
                                <td>{{ $c['size'] }}</td>
                                <td class="cv2-t-mono">{{ $c['phone'] }}</td>
                                <td>{{ $c['city'] }}</td>
                                <td class="cv2-t-mono">{{ $c['locations'] }}</td>
                                <td class="cv2-t-mono">{{ $c['contracts'] }}</td>
                                <td>
                                    @php $sc=['Active'=>'is-active','Inactive'=>'is-inactive','Blacklisted'=>'is-black'][$c['status']]??'is-inactive'; @endphp
                                    <span class="cv2-badge {{ $sc }}"><span class="cv2-badge-dot"></span>{{ $c['status'] }}</span>
                                </td>
                                <td class="cv2-actions">
                                    <a href="{{ route('contact.v2.customer.show', $c['id']) }}" class="cv2-ic-btn" title="View"><i class="bi bi-eye"></i></a>
                                    <a href="{{ route('contact.v2.customer.edit', $c['id']) }}" class="cv2-ic-btn" title="Edit"><i class="bi bi-pencil"></i></a>
                                    <a href="javascript:void(0)" class="cv2-ic-btn is-danger cv2-del-customer" data-id="{{ $c['id'] }}" title="Delete"><i class="bi bi-trash3"></i></a>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="11" class="text-center cv2-empty">No customers found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="cv2-pager">
                    <span>Showing {{ $customers->firstItem() ?? 0 }}–{{ $customers->lastItem() ?? 0 }} of {{ $customers->total() }}</span>
                    {{ $customers->onEachSide(1)->links('pagination::bootstrap-5') }}
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('js/V2/customer.js?v=1.8') }}"></script>
@endsection
