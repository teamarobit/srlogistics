@extends('layouts.app')

@section('css')
<link href="{{ asset('css/V2/driver.css?v=1.0') }}" rel="stylesheet">
@endsection

@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="cv2-wrap">
        <div class="cv2-container">

            <div class="cv2-phead">
                <div>
                    <div class="cv2-crumb"><a href="{{ route('contact.v2.driver.dashboard') }}">Driver Dashboard</a> · All Drivers</div>
                    <h1>Drivers</h1>
                    <div class="cv2-sub">86 drivers · 71 active</div>
                </div>
                <div class="cv2-phead-actions">
                    <a href="{{ route('contact.v2.driver.dashboard') }}" class="cv2-btn cv2-btn-ghost"><i class="bi bi-speedometer2"></i>Dashboard</a>
                    <a href="{{ route('contact.v2.driver.create') }}" class="cv2-btn cv2-btn-primary"><i class="bi bi-plus-lg"></i>Add Driver</a>
                </div>
            </div>

            <div class="cv2-card">
                <div class="cv2-filters">
                    <div class="cv2-search"><i class="bi bi-search"></i><input type="text" placeholder="Search by name, code or phone…"></div>
                    <select class="cv2-select"><option>All Categories</option><option>Local</option><option>Line</option></select>
                    <select class="cv2-select"><option>All RAG</option><option>Red</option><option>Yellow</option><option>Green</option></select>
                    <select class="cv2-select"><option>All Status</option><option>Active</option><option>Inactive</option><option>Blacklisted</option></select>
                    <button class="cv2-btn cv2-btn-soft"><i class="bi bi-arrow-counterclockwise"></i>Reset</button>
                </div>

                <div class="cv2-card-b is-flush">
                    <table class="cv2-table">
                        <thead>
                            <tr>
                                <th style="width:34px;"><input type="checkbox"></th>
                                <th>Contact No</th><th>Driver Code</th><th>Driver</th><th>Category</th>
                                <th>Phone</th><th>RAG</th><th>Allocated Vehicle</th><th>Status</th>
                                <th style="text-align:right;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($drivers as $d)
                            <tr>
                                <td><input type="checkbox"></td>
                                <td class="cv2-t-mono">{{ $d['contactno'] }}</td>
                                <td class="cv2-t-mono">{{ $d['driver_code'] }}</td>
                                <td>
                                    <div style="display:flex;align-items:center;gap:11px;">
                                        <span class="cv2-avatar" style="width:34px;height:34px;font-size:12px;border-radius:9px;">{{ strtoupper(mb_substr($d['name'],0,1)) }}</span>
                                        <div><span class="cv2-t-name">{{ $d['name'] }}</span><div class="cv2-t-sub">DOJ {{ $d['doj'] }}</div></div>
                                    </div>
                                </td>
                                <td><span class="cv2-pill">{{ $d['category'] }}</span></td>
                                <td class="cv2-t-mono">{{ $d['phone'] }}</td>
                                <td>@php $rc=['Red'=>'is-red','Yellow'=>'is-yellow','Green'=>'is-green'][$d['rag']]??'is-green'; @endphp<span class="cv2-rag {{ $rc }}"><span class="dot"></span>{{ $d['rag'] }}</span></td>
                                <td class="cv2-t-mono">{{ $d['vehicle'] }}</td>
                                <td>
                                    @php $sc=['Active'=>'is-active','Inactive'=>'is-inactive','Blacklisted'=>'is-black'][$d['status']]??'is-inactive'; @endphp
                                    <span class="cv2-badge {{ $sc }}"><span class="cv2-badge-dot"></span>{{ $d['status'] }}</span>
                                </td>
                                <td class="cv2-actions">
                                    <a href="{{ route('contact.v2.driver.show', $d['id']) }}" class="cv2-ic-btn" title="View"><i class="bi bi-eye"></i></a>
                                    <a href="{{ route('contact.v2.driver.edit', $d['id']) }}" class="cv2-ic-btn" title="Edit"><i class="bi bi-pencil"></i></a>
                                    <a href="javascript:void(0)" class="cv2-ic-btn is-danger cv2-del-driver" data-id="{{ $d['id'] }}" data-url="{{ route('contact.v2.driver.delete') }}" title="Delete"><i class="bi bi-trash3"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="cv2-pager">
                    <span>Showing 1–5 of 86</span>
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

@section('js')<script src="{{ asset('js/V2/driver.js?v=2.0') }}"></script>@endsection
