@extends('layouts.app')

@section('css')

<link rel="stylesheet" href="{{ asset('css/Tollstation/create.css') }}">

@endsection

@section('content')

<div class="layout-wrapper">
    @include('includes.header')

    <div class="wrapper srlog-bdwrapper">
        <div class="side-wrap">
            @include('includes.leftbar')

            <div class="main-wrap">

                <div class="topbar">
                    <div class="container-fluid page-head">
                        <div class="row align-items-end">
                            <div class="col-12 col-md-6 d-flex align-items-center">
                                <h5 class="d-inline-block mb-0">Toll Station Details</h5>
                            </div>
                            <div class="col-12 col-md-6 text-end">
                                <a href="{{ route('tollstation.edit', $tollstation->id) }}" class="btn btn-theme mb-0">
                                    <i class="uil uil-pen me-1"></i> Edit
                                </a>
                                <a href="{{ route('tollstation.index') }}" class="btn btn-danger mb-0">Close</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="addroute-bd">
                    <div class="container-fluid">

                        <div class="form-group row pb-1">
                            <div class="col-12 col-md-3"><label class="fw-bold">Toll Station No</label></div>
                            <div class="col-12 col-md-6">{{ $tollstation->tollstationno ?? '—' }}</div>
                        </div>

                        <div class="form-group row pb-1">
                            <div class="col-12 col-md-3"><label class="fw-bold">Toll Station Name</label></div>
                            <div class="col-12 col-md-6">{{ $tollstation->station_name ?? '—' }}</div>
                        </div>

                        <div class="form-group row pb-1">
                            <div class="col-12 col-md-3"><label class="fw-bold">Toll Company</label></div>
                            <div class="col-12 col-md-6">{{ $tollstation->toll_company ?? '—' }}</div>
                        </div>

                        <div class="form-group row pb-1">
                            <div class="col-12 col-md-3"><label class="fw-bold">State</label></div>
                            <div class="col-12 col-md-6">{{ $tollstation->state?->name ?? '—' }}</div>
                        </div>

                        <div class="form-group row pb-1">
                            <div class="col-12 col-md-3"><label class="fw-bold">City</label></div>
                            <div class="col-12 col-md-6">{{ $tollstation->city?->name ?? '—' }}</div>
                        </div>

                        <div class="form-group row pb-1">
                            <div class="col-12 col-md-3"><label class="fw-bold">Embed Map Location</label></div>
                            <div class="col-12 col-md-6 text-break">{{ $tollstation->embed_map_location ?? '—' }}</div>
                        </div>

                        <div class="form-group row pb-1">
                            <div class="col-12 col-md-3"><label class="fw-bold">Address</label></div>
                            <div class="col-12 col-md-6">{{ $tollstation->address ?? '—' }}</div>
                        </div>

                        <div class="form-group row pb-1">
                            <div class="col-12 col-md-3"><label class="fw-bold">Large Vehicle Charge</label></div>
                            <div class="col-12 col-md-6">
                                {{ optional($tollstation->currency)->sign ?? '' }}{{ $tollstation->large_vehicle_charge ?? '0' }}
                            </div>
                        </div>

                        <div class="form-group row pb-1">
                            <div class="col-12 col-md-3"><label class="fw-bold">Medium Vehicle Charge</label></div>
                            <div class="col-12 col-md-6">
                                {{ optional($tollstation->currency)->sign ?? '' }}{{ $tollstation->medium_vehicle_charge ?? '0' }}
                            </div>
                        </div>

                        <div class="form-group row pb-1">
                            <div class="col-12 col-md-3"><label class="fw-bold">Small Vehicle Charge</label></div>
                            <div class="col-12 col-md-6">
                                {{ optional($tollstation->currency)->sign ?? '' }}{{ $tollstation->small_vehicle_charge ?? '0' }}
                            </div>
                        </div>

                        <div class="form-group row pb-1">
                            <div class="col-12 col-md-3"><label class="fw-bold">Status</label></div>
                            <div class="col-12 col-md-6">
                                <span class="badge bg-{{ $tollstation->status == 'Active' ? 'success' : 'danger' }}">
                                    {{ $tollstation->status ?? '—' }}
                                </span>
                            </div>
                        </div>

                        <div class="form-group row pb-1">
                            <div class="col-12 col-md-3"><label class="fw-bold">Created By</label></div>
                            <div class="col-12 col-md-6">
                                {{ $tollstation->createdBy?->name ?? '—' }}
                                @if($tollstation->createdBy?->email)
                                    <span class="text-secondary d-block">{{ $tollstation->createdBy->email }}</span>
                                @endif
                            </div>
                        </div>

                        @if($tollstation->updatedBy)
                        <div class="form-group row pb-1">
                            <div class="col-12 col-md-3"><label class="fw-bold">Updated By</label></div>
                            <div class="col-12 col-md-6">
                                {{ $tollstation->updatedBy?->name }}
                                <span class="text-secondary d-block">{{ $tollstation->updatedBy?->email }}</span>
                            </div>
                        </div>
                        @endif

                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

@endsection
