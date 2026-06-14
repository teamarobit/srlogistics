@extends('layouts.app')

@section('css')
<link href="{{ asset('css/V2/customer.css?v=1.3') }}" rel="stylesheet">
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
                    <div class="cv2-sub">124 customers · 112 active</div>
                </div>
                <div class="cv2-phead-actions">
                    <a href="{{ route('contact.v2.customer.dashboard') }}" class="cv2-btn cv2-btn-ghost"><i class="bi bi-speedometer2"></i>Dashboard</a>
                    <a href="{{ route('contact.v2.customer.create') }}" class="cv2-btn cv2-btn-primary"><i class="bi bi-plus-lg"></i>Add Customer</a>
                </div>
            </div>

            <div class="cv2-card">
                <div class="cv2-filters">
                    <div class="cv2-search"><i class="bi bi-search"></i><input type="text" placeholder="Search by name, contact no or GST…"></div>
                    <select class="cv2-select"><option>All Cities</option><option>Guwahati</option><option>Dibrugarh</option><option>Silchar</option></select>
                    <select class="cv2-select"><option>All Sizes</option><option>Large</option><option>Medium</option><option>Small</option></select>
                    <select class="cv2-select"><option>All Status</option><option>Active</option><option>Inactive</option><option>Blacklisted</option></select>
                    <select class="cv2-select"><option>All Types</option><option>FMCG</option><option>Cement</option><option>Steel</option><option>Retail</option></select>
                    <button class="cv2-btn cv2-btn-soft"><i class="bi bi-arrow-counterclockwise"></i>Reset</button>
                </div>

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
                            @foreach($customers as $c)
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
                                    <a href="javascript:void(0)" class="cv2-ic-btn is-danger" title="Delete"><i class="bi bi-trash3"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="cv2-pager">
                    <span>Showing 1–5 of 124</span>
                    <div class="cv2-pages">
                        <a href="javascript:void(0)"><i class="bi bi-chevron-left"></i></a>
                        <a href="javascript:void(0)" class="is-active">1</a>
                        <a href="javascript:void(0)">2</a>
                        <a href="javascript:void(0)">3</a>
                        <a href="javascript:void(0)"><i class="bi bi-chevron-right"></i></a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
