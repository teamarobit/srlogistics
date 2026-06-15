@extends('layouts.app')

@section('css')
<link href="{{ asset('css/V2/vehiclevendor.css?v=1.0') }}" rel="stylesheet">
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
                    <div class="cv2-sub">118 vendors · 103 active</div>
                </div>
                <div class="cv2-phead-actions">
                    <a href="{{ route('contact.v2.vehiclevendor.dashboard') }}" class="cv2-btn cv2-btn-ghost"><i class="bi bi-speedometer2"></i>Dashboard</a>
                    <a href="{{ route('contact.v2.vehiclevendor.create') }}" class="cv2-btn cv2-btn-primary"><i class="bi bi-plus-lg"></i>Add Vendor</a>
                </div>
            </div>

            <div class="cv2-card">
                <div class="cv2-filters">
                    <div class="cv2-search"><i class="bi bi-search"></i><input type="text" placeholder="Search by company, contact name or code…"></div>
                    <select class="cv2-select"><option>All Cities</option><option>Guwahati</option><option>Dibrugarh</option><option>Silchar</option><option>Tinsukia</option><option>Nagaon</option></select>
                    <select class="cv2-select"><option>All Sizes</option><option>Large</option><option>Medium</option><option>Small</option></select>
                    <select class="cv2-select"><option>All RAG</option><option>Green</option><option>Yellow</option><option>Red</option></select>
                    <select class="cv2-select"><option>All Status</option><option>Active</option><option>Inactive</option><option>Blacklisted</option></select>
                    <button class="cv2-btn cv2-btn-soft"><i class="bi bi-arrow-counterclockwise"></i>Reset</button>
                </div>

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
                            @foreach($vendors as $v)
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
                                    <a href="javascript:void(0)" class="cv2-ic-btn is-danger cv2-del" title="Delete"><i class="bi bi-trash3"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="cv2-pager">
                    <span>Showing 1–5 of 118</span>
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

@section('js')
<script src="{{ asset('js/V2/vehiclevendor.js?v=1.0') }}"></script>
@endsection
