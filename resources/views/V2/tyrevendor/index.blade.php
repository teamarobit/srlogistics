@extends('layouts.app')

@section('css')
<link href="{{ asset('css/V2/tyrevendor.css?v=1.0') }}" rel="stylesheet">
@endsection

@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="cv2-wrap">
        <div class="cv2-container">

            <div class="cv2-phead">
                <div>
                    <div class="cv2-crumb"><a href="{{ route('contact.v2.tyrevendor.dashboard') }}">Tyre Vendor Dashboard</a> · All Tyre Vendors</div>
                    <h1>Tyre Vendors</h1>
                    <div class="cv2-sub">{{ $vendors->total() }} vendor(s)</div>
                </div>
                <div class="cv2-phead-actions">
                    <a href="{{ route('contact.v2.tyrevendor.dashboard') }}" class="cv2-btn cv2-btn-ghost"><i class="bi bi-speedometer2"></i>Dashboard</a>
                    <a href="{{ route('contact.v2.tyrevendor.create') }}" class="cv2-btn cv2-btn-primary"><i class="bi bi-plus-lg"></i>Add Tyre Vendor</a>
                </div>
            </div>

            <div class="cv2-card">
                {{-- E7: NO size filter for Tyre Vendor --}}
                <form method="GET" action="{{ route('contact.v2.tyrevendor.index') }}" class="cv2-filters">
                    <div class="cv2-search"><i class="bi bi-search"></i><input type="text" name="name" value="{{ $search_name }}" placeholder="Search by company, contact no or GST…"></div>
                    <select class="cv2-select" name="city" onchange="this.form.submit()">
                        <option value="">All Cities</option>
                        @foreach($cities as $city)
                            <option value="{{ $city->id }}" {{ (string)$search_city === (string)$city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                        @endforeach
                    </select>
                    <select class="cv2-select" name="status" onchange="this.form.submit()">
                        <option value="">All Status</option>
                        @foreach(['Active','Inactive','Blacklisted'] as $st)
                            <option value="{{ $st }}" {{ $search_status === $st ? 'selected' : '' }}>{{ $st }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="cv2-btn cv2-btn-soft"><i class="bi bi-funnel"></i>Filter</button>
                    <a href="{{ route('contact.v2.tyrevendor.index') }}" class="cv2-btn cv2-btn-soft"><i class="bi bi-arrow-counterclockwise"></i>Reset</a>
                </form>

                <div class="cv2-card-b is-flush">
                    <table class="cv2-table">
                        <thead>
                            <tr>
                                <th>Contact No</th><th>Company</th><th>Contact Name</th><th>Code</th>
                                <th>Phone</th><th>City</th><th>Tyres</th><th>TDS %</th><th>Status</th>
                                <th style="text-align:right;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($vendors as $v)
                            <tr>
                                <td class="cv2-t-mono">{{ $v['contactno'] }}</td>
                                <td>
                                    <div style="display:flex;align-items:center;gap:11px;">
                                        <span class="cv2-avatar" style="width:34px;height:34px;font-size:12px;border-radius:9px;">{{ strtoupper(mb_substr($v['company'],0,1)) }}</span>
                                        <div><span class="cv2-t-name">{{ $v['company'] }}</span><div class="cv2-t-sub">{{ $v['email'] }}</div></div>
                                    </div>
                                </td>
                                <td>{{ $v['name'] }}</td>
                                <td><span class="cv2-pill">{{ $v['code'] }}</span></td>
                                <td class="cv2-t-mono">{{ $v['phone'] }}</td>
                                <td>{{ $v['city'] }}</td>
                                <td class="cv2-t-mono">{{ $v['tyres'] }}</td>
                                <td class="cv2-t-mono">{{ rtrim(rtrim(number_format($v['tds'],2),'0'),'.') }}%</td>
                                <td>
                                    @php $sc=['Active'=>'is-active','Inactive'=>'is-inactive','Blacklisted'=>'is-black'][$v['status']]??'is-inactive'; @endphp
                                    <span class="cv2-badge {{ $sc }}"><span class="cv2-badge-dot"></span>{{ $v['status'] }}</span>
                                </td>
                                <td class="cv2-actions">
                                    <a href="{{ route('contact.v2.tyrevendor.show', $v['id']) }}" class="cv2-ic-btn" title="View"><i class="bi bi-eye"></i></a>
                                    <a href="{{ route('contact.v2.tyrevendor.edit', $v['id']) }}" class="cv2-ic-btn" title="Edit"><i class="bi bi-pencil"></i></a>
                                    <a href="javascript:void(0)" class="cv2-ic-btn is-danger cv2-del-vendor" title="Delete" data-id="{{ $v['id'] }}" data-url="{{ route('contact.v2.tyrevendor.delete') }}"><i class="bi bi-trash3"></i></a>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="10"><div class="cv2-empty"><i class="bi bi-shop"></i><h4>No tyre vendors found</h4><p>Try adjusting filters or add a new vendor.</p></div></td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="cv2-pager">
                    <span>Showing {{ $vendors->firstItem() ?? 0 }}–{{ $vendors->lastItem() ?? 0 }} of {{ $vendors->total() }}</span>
                    <div class="cv2-pages">{{ $vendors->links() }}</div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
@section('js')<script src="{{ asset('js/V2/tyrevendor.js?v=2.0') }}"></script>@endsection
