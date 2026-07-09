@extends('layouts.app')

@section('css')
<link href="{{ asset('css/DocumentDashboard/document-dashboard.css?v=1.4') }}" rel="stylesheet">
@endsection

@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="wrapper srlog-bdwrapper">
        <div class="main-wrap docd-no-sidebar">

            {{-- Breadcrumb --}}
            <nav aria-label="breadcrumb" class="mb-2">
                <ol class="breadcrumb docd-breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('fleetdashboard.index') }}">Fleet</a></li>
                    <li class="breadcrumb-item active">Document Dashboard</li>
                </ol>
            </nav>

            {{-- Page Header --}}
            <div class="docd-page-head d-flex align-items-center justify-content-between mb-3">
                <div>
                    <h5 class="mb-0">Document Dashboard</h5>
                    <span class="text-muted" style="font-size:12px;">
                        Invoice · RC · Speed Governor · Insurance · Fitness · Tax · Permit · PUCC · VLTD
                    </span>
                </div>
            </div>

            {{-- ══════════════════════════════════════════════════
                 Tab Card — pills + AJAX-loaded panes
            ══════════════════════════════════════════════════ --}}
            @php
                $docdTabs = [
                    ['invoice',        'Invoice – Chassis & Body'],
                    ['rc',             'RC'],
                    ['speed-governor', 'Speed Governor'],
                    ['insurance',      'Insurance'],
                    ['fitness',        'Fitness'],
                    ['tax',            'Tax'],
                    ['permit-1-year',  '1 Year Permit'],
                    ['permit-5-year',  '5 Year Permit'],
                    ['pucc',           'PUCC'],
                    ['vltd',           'VLTD Certificate'],
                ];
            @endphp

            <div class="docd-tab-card">

                {{-- Tab nav (pills) --}}
                <ul class="nav docd-tabs" id="docdTab" role="tablist">
                    @foreach($docdTabs as $i => $tab)
                    <li class="nav-item" role="presentation">
                        <button class="docd-tab-link {{ $i === 0 ? 'active' : '' }}"
                                id="docd-tab-{{ $tab[0] }}"
                                data-bs-toggle="pill"
                                data-bs-target="#docd-pane-{{ $tab[0] }}"
                                type="button" role="tab"
                                aria-controls="docd-pane-{{ $tab[0] }}"
                                aria-selected="{{ $i === 0 ? 'true' : 'false' }}">
                            {{ $tab[1] }}
                        </button>
                    </li>
                    @endforeach
                </ul>

                {{-- Tab panes — empty shells, filled via AJAX --}}
                <div class="tab-content docd-tab-content" id="docdTabContent">
                    @foreach($docdTabs as $i => $tab)
                    <div class="tab-pane fade {{ $i === 0 ? 'show active' : '' }}"
                         id="docd-pane-{{ $tab[0] }}"
                         role="tabpanel"
                         aria-labelledby="docd-tab-{{ $tab[0] }}"
                         data-tab-key="{{ $tab[0] }}"
                         data-tab-url="{{ route('documentdashboard.tab', $tab[0]) }}">
                        @include('documentdashboard.tabs._loading')
                    </div>
                    @endforeach
                </div>

            </div>{{-- /docd-tab-card --}}

        </div>{{-- /main-wrap --}}
    </div>{{-- /wrapper --}}
</div>{{-- /layout-wrapper --}}
@endsection

@section('js')
<script src="{{ asset('js/DocumentDashboard/document-dashboard.js?v=1.0') }}"></script>
@endsection
