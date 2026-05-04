@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/fleet/dashboard.css') }}">
<link rel="stylesheet" href="{{ asset('css/tyre/dashboard.css?v=2.3') }}">
@endsection

@section('content')

<div class="layout-wrapper">

    @include('includes.header')

    <div class="dashboard-bd srlog-bdwrapper">

        {{-- ── Page Title ── --}}
        <div class="top-text">
           <div class="container-fluid">
               <div class="row">
                   <div class="col-12 col-md-6">
                       <h1>Tyre Dashboard</h1>
                   </div>
                   <div class="col-12 col-md-6 text-end">
                       <a class="btn btn-primary mt-2" href="{{ route('tyre.createNew') }}">
                           <i class="uil uil-plus me-1"></i>Add Tyre
                       </a>
                   </div>
               </div>
           </div>
        </div>

        {{-- ── Summary Cards ── --}}
        <div class="itemvehicles-bd">
            <div class="container-fluid">
                <div class="itemv-box">
                    <div class="itemrow justify-content-around tyre-cards-row">

                        @php
                            $cards = [
                                ['count' => $all_count,            'label' => 'All Tyres',             'pct' => 100],
                                ['count' => $garage_ready_count,   'label' => 'SR Garage - Ready to use', 'pct' => $all_count > 0 ? round($garage_ready_count * 100 / $all_count) : 0],
                                ['count' => $warranty_claim_count, 'label' => 'Warranty Claim Tyres',  'pct' => $all_count > 0 ? round($warranty_claim_count * 100 / $all_count) : 0],
                                ['count' => $rethreading_count,    'label' => 'Re-Threading Tyres',    'pct' => $all_count > 0 ? round($rethreading_count * 100 / $all_count) : 0],
                                ['count' => $scrap_count,          'label' => 'Scrap Tyres',           'pct' => $all_count > 0 ? round($scrap_count * 100 / $all_count) : 0],
                                ['count' => $allocated_count,      'label' => 'Allocate Tyres',        'pct' => $all_count > 0 ? round($allocated_count * 100 / $all_count) : 0],
                                ['count' => $direct_fitment_count, 'label' => 'Direct Fitment Tyres', 'pct' => $all_count > 0 ? round($direct_fitment_count * 100 / $all_count) : 0],
                                ['count' => $yet_to_decide_count,  'label' => 'Yet to Decide Tyres',  'pct' => $all_count > 0 ? round($yet_to_decide_count * 100 / $all_count) : 0],
                                ['count' => $extra_on_vehicle_count,'label'=> 'Extra Tyres On Vehicle','pct' => $all_count > 0 ? round($extra_on_vehicle_count * 100 / $all_count) : 0],
                            ];
                        @endphp

                        @foreach($cards as $card)
                        <div class="itemcol tyre-itemcol">
                            <div class="itembd">
                                <div class="top">
                                    <p class="number">{{ $card['count'] }}</p>
                                    <p>{{ $card['label'] }}</p>
                                </div>
                                <div class="bottom">
                                    <div class="item1"><img src="{{ asset('images/up-right-arrow 1.png') }}" /> {{ $card['pct'] }}%</div>
                                    <div class="item3"><img src="{{ asset('images/icons/tyre-default.png') }}" /></div>
                                </div>
                                <div class="item-icon"><span><img src="{{ asset('images/images01.png') }}" /></span></div>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>

                {{-- ── 8-Tab Navigation ── --}}
                <div class="right-side-wrap mt-0">
                    <ul class="nav nav-pills mb-3 tyre-tab-nav" id="pills-tab" role="tablist">
                        @php
                            $tabs = [
                                ['id' => 'tab-all',           'label' => 'All Tyres'],
                                ['id' => 'tab-ready',         'label' => 'Ready to Use'],
                                ['id' => 'tab-warranty',      'label' => 'Warranty Claim'],
                                ['id' => 'tab-rethreading',   'label' => 'Re-threading'],
                                ['id' => 'tab-scrap',         'label' => 'Scrap Tyres'],
                                ['id' => 'tab-allocated',     'label' => 'Allocate Tyres'],
                                ['id' => 'tab-direct',        'label' => 'Direct Fitment'],
                                ['id' => 'tab-ytd',           'label' => 'Yet To Decide'],
                            ];
                        @endphp
                        @foreach($tabs as $i => $tab)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link nav_click fleetTab {{ $i === 0 ? 'active' : '' }}"
                                    id="{{ $tab['id'] }}-tab"
                                    data-bs-toggle="pill"
                                    data-bs-target="#{{ $tab['id'] }}"
                                    type="button" role="tab"
                                    aria-controls="{{ $tab['id'] }}"
                                    aria-selected="{{ $i === 0 ? 'true' : 'false' }}">
                                {{ $tab['label'] }}
                            </button>
                        </li>
                        @endforeach
                    </ul>

                    <div class="tab-content" id="pills-tabContent">

                        {{-- ══════════════════════════════════════════════════
                             TAB 1: ALL TYRES
                        ══════════════════════════════════════════════════ --}}
                        <div class="tab-pane fade show active" id="tab-all" role="tabpanel">
                            <div class="accordion mt-2" id="acc-tab1">
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button filter-options" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-tab1">
                                            <div class="item-filter"><div class="filter"><span class="filter-icon"><img src="{{ asset('images/icons/filter-01icon.png') }}" alt="icon"></span></div><p class="mb-0">Filter Options</p></div>
                                        </button>
                                    </h2>
                                    <div id="collapse-tab1" class="accordion-collapse collapse show">
                                        <div class="accordion-body">
                                            <form method="GET" action="{{ route('tyre.dashboard') }}" id="filter-form-1">
                                                <input type="hidden" name="sort" value="{{ $sort }}">
                                                <input type="hidden" name="direction" value="{{ $direction }}">
                                                <div class="filtersearch-bd flex-wrap">
                                                    <div class="vehicletype ms-1">
                                                        <label>Tyre Location</label>
                                                        <select class="form-select" name="f_location">
                                                            <option value="">All</option>
                                                            <option value="Warehouse" {{ request('f_location') == 'Warehouse' ? 'selected' : '' }}>SR Garage</option>
                                                            <option value="Vehicle" {{ request('f_location') == 'Vehicle' ? 'selected' : '' }}>Vehicle</option>
                                                        </select>
                                                    </div>
                                                    <div class="vehicletype ms-1">
                                                        <label>Tyre Status</label>
                                                        <select class="form-select" name="f_status">
                                                            <option value="">All</option>
                                                            @foreach(['Ready to Use','Warranty Claim','Re-threading','Scrap','Allocated','Direct Fitment','Yet to Decide'] as $s)
                                                                <option value="{{ $s }}" {{ request('f_status') == $s ? 'selected' : '' }}>{{ $s }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="vehicletype ms-1">
                                                        <label>Tyre Type</label>
                                                        <select class="form-select" name="f_type">
                                                            <option value="">All</option>
                                                            <option value="Nylon" {{ request('f_type') == 'Nylon' ? 'selected' : '' }}>Nylon</option>
                                                            <option value="Radial" {{ request('f_type') == 'Radial' ? 'selected' : '' }}>Radial</option>
                                                        </select>
                                                    </div>
                                                    <div class="vehicletype ms-1">
                                                        <label>Tyre Condition</label>
                                                        <select class="form-select" name="f_condition">
                                                            <option value="">All</option>
                                                            <option value="New" {{ request('f_condition') == 'New' ? 'selected' : '' }}>New</option>
                                                            <option value="Used" {{ request('f_condition') == 'Used' ? 'selected' : '' }}>Used</option>
                                                            <option value="Re-thread" {{ request('f_condition') == 'Re-thread' ? 'selected' : '' }}>Re-thread</option>
                                                        </select>
                                                    </div>
                                                    <div class="vehicletype ms-1">
                                                        <label>Brand</label>
                                                        <select class="form-select" name="f_brand">
                                                            <option value="">All</option>
                                                            @foreach($tyreBrands as $brand)
                                                                <option value="{{ $brand }}" {{ request('f_brand') == $brand ? 'selected' : '' }}>{{ $brand }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="vehicletype ms-1">
                                                        <label>Vendor</label>
                                                        <select class="form-select" name="f_vendor">
                                                            <option value="">All</option>
                                                            @foreach($tyrevendors as $v)
                                                                <option value="{{ $v->id }}" {{ request('f_vendor') == $v->id ? 'selected' : '' }}>{{ $v->contact_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="vehicletype ms-1">
                                                        <label>Sched. Maint. Type</label>
                                                        <select class="form-select" name="f_maintenance_type">
                                                            <option value="">All</option>
                                                            <option value="Alignment" {{ request('f_maintenance_type') == 'Alignment' ? 'selected' : '' }}>Alignment</option>
                                                            <option value="Rotation" {{ request('f_maintenance_type') == 'Rotation' ? 'selected' : '' }}>Rotation</option>
                                                        </select>
                                                    </div>
                                                    <div class="vehicletype ms-1">
                                                        <label>Maint. Status</label>
                                                        <select class="form-select" name="f_maintenance_status">
                                                            <option value="">All</option>
                                                            <option value="Done" {{ request('f_maintenance_status') == 'Done' ? 'selected' : '' }}>Completed</option>
                                                            <option value="Overdue" {{ request('f_maintenance_status') == 'Overdue' ? 'selected' : '' }}>Missed</option>
                                                            <option value="Pending" {{ request('f_maintenance_status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                                                            <option value="Scheduled" {{ request('f_maintenance_status') == 'Scheduled' ? 'selected' : '' }}>Upcoming</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="filtersearch-bd justify-content-start mt-2">
                                                    <div class="ms-1" style="width:220px;">
                                                        <div class="input-group">
                                                            <input type="text" name="f_serial" class="form-control" placeholder="Search by Serial Number" value="{{ request('f_serial') }}">
                                                            <span class="input-group-text"><i class="uil uil-search"></i></span>
                                                        </div>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary ms-1"><i class="uil uil-filter me-1"></i>Filter</button>
                                                    <a href="{{ route('tyre.dashboard') }}" class="btn btn-primary ms-1"><i class="uil uil-sync me-1"></i>Reset</a>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="sr_dashboard0_table">
                                <div class="container-fluid">
                                    @include('tyre.partials.tab-all')
                                </div>
                            </div>
                        </div>

                        {{-- ══════════════════════════════════════════════════
                             TAB 2: READY TO USE
                        ══════════════════════════════════════════════════ --}}
                        <div class="tab-pane fade" id="tab-ready" role="tabpanel">
                            <div class="accordion mt-2" id="acc-tab2">
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button filter-options" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-tab2">
                                            <div class="item-filter"><div class="filter"><span class="filter-icon"><img src="{{ asset('images/icons/filter-01icon.png') }}" alt="icon"></span></div><p class="mb-0">Filter Options</p></div>
                                        </button>
                                    </h2>
                                    <div id="collapse-tab2" class="accordion-collapse collapse show">
                                        <div class="accordion-body">
                                            <form method="GET" action="{{ route('tyre.dashboard') }}" id="filter-form-2">
                                                <input type="hidden" name="active_tab" value="tab-ready">
                                                <input type="hidden" name="sort" value="{{ $sort }}">
                                                <input type="hidden" name="direction" value="{{ $direction }}">
                                                <div class="filtersearch-bd flex-wrap">
                                                    <div class="vehicletype ms-1">
                                                        <label>Tyre Type</label>
                                                        <select class="form-select" name="f2_type">
                                                            <option value="">All</option>
                                                            <option value="Nylon" {{ request('f2_type') == 'Nylon' ? 'selected' : '' }}>Nylon</option>
                                                            <option value="Radial" {{ request('f2_type') == 'Radial' ? 'selected' : '' }}>Radial</option>
                                                        </select>
                                                    </div>
                                                    <div class="vehicletype ms-1">
                                                        <label>Tyre Condition</label>
                                                        <select class="form-select" name="f2_condition">
                                                            <option value="">All</option>
                                                            <option value="New" {{ request('f2_condition') == 'New' ? 'selected' : '' }}>New</option>
                                                            <option value="Used" {{ request('f2_condition') == 'Used' ? 'selected' : '' }}>Used</option>
                                                            <option value="Re-thread" {{ request('f2_condition') == 'Re-thread' ? 'selected' : '' }}>Re-thread</option>
                                                        </select>
                                                    </div>
                                                    <div class="vehicletype ms-1">
                                                        <label>Warranty</label>
                                                        <select class="form-select" name="f2_warranty">
                                                            <option value="">All</option>
                                                            <option value="In Warranty" {{ request('f2_warranty') == 'In Warranty' ? 'selected' : '' }}>In Warranty</option>
                                                            <option value="Out of Warranty" {{ request('f2_warranty') == 'Out of Warranty' ? 'selected' : '' }}>Out of Warranty</option>
                                                        </select>
                                                    </div>
                                                    <div class="vehicletype ms-1">
                                                        <label>Brand</label>
                                                        <select class="form-select" name="f2_brand">
                                                            <option value="">All</option>
                                                            @foreach($tyreBrands as $brand)
                                                                <option value="{{ $brand }}" {{ request('f2_brand') == $brand ? 'selected' : '' }}>{{ $brand }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="vehicletype ms-1">
                                                        <label>Vendor</label>
                                                        <select class="form-select" name="f2_vendor">
                                                            <option value="">All</option>
                                                            @foreach($tyrevendors as $v)
                                                                <option value="{{ $v->id }}" {{ request('f2_vendor') == $v->id ? 'selected' : '' }}>{{ $v->contact_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="filtersearch-bd justify-content-start mt-2">
                                                    <div class="ms-1" style="width:220px;">
                                                        <div class="input-group">
                                                            <input type="text" name="f2_serial" class="form-control" placeholder="Search by Serial Number" value="{{ request('f2_serial') }}">
                                                            <span class="input-group-text"><i class="uil uil-search"></i></span>
                                                        </div>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary ms-1"><i class="uil uil-filter me-1"></i>Filter</button>
                                                    <a href="{{ route('tyre.dashboard') }}?active_tab=tab-ready" class="btn btn-primary ms-1"><i class="uil uil-sync me-1"></i>Reset</a>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="sr_dashboard0_table">
                                <div class="container-fluid">
                                    @include('tyre.partials.tab-ready-to-use')
                                </div>
                            </div>
                        </div>

                        {{-- ══════════════════════════════════════════════════
                             TAB 3: WARRANTY CLAIM
                        ══════════════════════════════════════════════════ --}}
                        <div class="tab-pane fade" id="tab-warranty" role="tabpanel">
                            <div class="accordion mt-2" id="acc-tab3">
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button filter-options" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-tab3">
                                            <div class="item-filter"><div class="filter"><span class="filter-icon"><img src="{{ asset('images/icons/filter-01icon.png') }}" alt="icon"></span></div><p class="mb-0">Filter Options</p></div>
                                        </button>
                                    </h2>
                                    <div id="collapse-tab3" class="accordion-collapse collapse show">
                                        <div class="accordion-body">
                                            <form method="GET" action="{{ route('tyre.dashboard') }}" id="filter-form-3">
                                                <input type="hidden" name="active_tab" value="tab-warranty">
                                                <input type="hidden" name="sort" value="{{ $sort }}">
                                                <input type="hidden" name="direction" value="{{ $direction }}">
                                                <div class="filtersearch-bd flex-wrap">
                                                    <div class="vehicletype ms-1">
                                                        <label>Tyre Type</label>
                                                        <select class="form-select" name="f3_type">
                                                            <option value="">All</option>
                                                            <option value="Nylon" {{ request('f3_type') == 'Nylon' ? 'selected' : '' }}>Nylon</option>
                                                            <option value="Radial" {{ request('f3_type') == 'Radial' ? 'selected' : '' }}>Radial</option>
                                                        </select>
                                                    </div>
                                                    <div class="vehicletype ms-1">
                                                        <label>Tyre Location</label>
                                                        <select class="form-select" name="f3_location">
                                                            <option value="">All</option>
                                                            <option value="SR Garage" {{ request('f3_location') == 'SR Garage' ? 'selected' : '' }}>SR Garage</option>
                                                            <option value="Sent for Warranty" {{ request('f3_location') == 'Sent for Warranty' ? 'selected' : '' }}>Sent for Warranty</option>
                                                        </select>
                                                    </div>
                                                    <div class="vehicletype ms-1">
                                                        <label>Brand</label>
                                                        <select class="form-select" name="f3_brand">
                                                            <option value="">All</option>
                                                            @foreach($tyreBrands as $brand)
                                                                <option value="{{ $brand }}" {{ request('f3_brand') == $brand ? 'selected' : '' }}>{{ $brand }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="vehicletype ms-1">
                                                        <label>Vendor</label>
                                                        <select class="form-select" name="f3_vendor">
                                                            <option value="">All</option>
                                                            @foreach($tyrevendors as $v)
                                                                <option value="{{ $v->id }}" {{ request('f3_vendor') == $v->id ? 'selected' : '' }}>{{ $v->contact_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="vehicletype ms-1">
                                                        <label>UTR Number</label>
                                                        <select class="form-select" name="f3_utr">
                                                            <option value="">All</option>
                                                            <option value="Filled" {{ request('f3_utr') == 'Filled' ? 'selected' : '' }}>Filled (Closed)</option>
                                                            <option value="Blank" {{ request('f3_utr') == 'Blank' ? 'selected' : '' }}>Blank (Open)</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="filtersearch-bd justify-content-start mt-2">
                                                    <div class="ms-1" style="width:220px;">
                                                        <div class="input-group">
                                                            <input type="text" name="f3_serial" class="form-control" placeholder="Search by Serial Number" value="{{ request('f3_serial') }}">
                                                            <span class="input-group-text"><i class="uil uil-search"></i></span>
                                                        </div>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary ms-1"><i class="uil uil-filter me-1"></i>Filter</button>
                                                    <a href="{{ route('tyre.dashboard') }}?active_tab=tab-warranty" class="btn btn-primary ms-1"><i class="uil uil-sync me-1"></i>Reset</a>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="sr_dashboard0_table">
                                <div class="container-fluid">
                                    @include('tyre.partials.tab-warranty')
                                </div>
                            </div>
                        </div>

                        {{-- ══════════════════════════════════════════════════
                             TAB 4: RE-THREADING
                        ══════════════════════════════════════════════════ --}}
                        <div class="tab-pane fade" id="tab-rethreading" role="tabpanel">
                            <div class="accordion mt-2" id="acc-tab4">
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button filter-options" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-tab4">
                                            <div class="item-filter"><div class="filter"><span class="filter-icon"><img src="{{ asset('images/icons/filter-01icon.png') }}" alt="icon"></span></div><p class="mb-0">Filter Options</p></div>
                                        </button>
                                    </h2>
                                    <div id="collapse-tab4" class="accordion-collapse collapse show">
                                        <div class="accordion-body">
                                            <form method="GET" action="{{ route('tyre.dashboard') }}" id="filter-form-4">
                                                <input type="hidden" name="active_tab" value="tab-rethreading">
                                                <input type="hidden" name="sort" value="{{ $sort }}">
                                                <input type="hidden" name="direction" value="{{ $direction }}">
                                                <div class="filtersearch-bd flex-wrap">
                                                    <div class="vehicletype ms-1">
                                                        <label>Tyre Type</label>
                                                        <select class="form-select" name="f4_type">
                                                            <option value="">All</option>
                                                            <option value="Nylon" {{ request('f4_type') == 'Nylon' ? 'selected' : '' }}>Nylon</option>
                                                            <option value="Radial" {{ request('f4_type') == 'Radial' ? 'selected' : '' }}>Radial</option>
                                                        </select>
                                                    </div>
                                                    <div class="vehicletype ms-1">
                                                        <label>Tyre Location</label>
                                                        <select class="form-select" name="f4_location">
                                                            <option value="">All</option>
                                                            <option value="SR Garage" {{ request('f4_location') == 'SR Garage' ? 'selected' : '' }}>SR Garage</option>
                                                            <option value="Sent for Re-threading" {{ request('f4_location') == 'Sent for Re-threading' ? 'selected' : '' }}>Sent for Re-threading</option>
                                                        </select>
                                                    </div>
                                                    <div class="vehicletype ms-1">
                                                        <label>Brand</label>
                                                        <select class="form-select" name="f4_brand">
                                                            <option value="">All</option>
                                                            @foreach($tyreBrands as $brand)
                                                                <option value="{{ $brand }}" {{ request('f4_brand') == $brand ? 'selected' : '' }}>{{ $brand }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="vehicletype ms-1">
                                                        <label>Re-threading Vendor</label>
                                                        <select class="form-select" name="f4_vendor">
                                                            <option value="">All</option>
                                                            @foreach($tyrevendors as $v)
                                                                <option value="{{ $v->id }}" {{ request('f4_vendor') == $v->id ? 'selected' : '' }}>{{ $v->contact_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="filtersearch-bd justify-content-start mt-2">
                                                    <div class="ms-1" style="width:220px;">
                                                        <div class="input-group">
                                                            <input type="text" name="f4_serial" class="form-control" placeholder="Search by Serial Number" value="{{ request('f4_serial') }}">
                                                            <span class="input-group-text"><i class="uil uil-search"></i></span>
                                                        </div>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary ms-1"><i class="uil uil-filter me-1"></i>Filter</button>
                                                    <a href="{{ route('tyre.dashboard') }}?active_tab=tab-rethreading" class="btn btn-primary ms-1"><i class="uil uil-sync me-1"></i>Reset</a>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="sr_dashboard0_table">
                                <div class="container-fluid">
                                    @include('tyre.partials.tab-rethreading')
                                </div>
                            </div>
                        </div>

                        {{-- ══════════════════════════════════════════════════
                             TAB 5: SCRAP TYRES
                        ══════════════════════════════════════════════════ --}}
                        <div class="tab-pane fade" id="tab-scrap" role="tabpanel">
                            <div class="accordion mt-2" id="acc-tab5">
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button filter-options" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-tab5">
                                            <div class="item-filter"><div class="filter"><span class="filter-icon"><img src="{{ asset('images/icons/filter-01icon.png') }}" alt="icon"></span></div><p class="mb-0">Filter Options</p></div>
                                        </button>
                                    </h2>
                                    <div id="collapse-tab5" class="accordion-collapse collapse show">
                                        <div class="accordion-body">
                                            <form method="GET" action="{{ route('tyre.dashboard') }}" id="filter-form-5">
                                                <input type="hidden" name="active_tab" value="tab-scrap">
                                                <input type="hidden" name="sort" value="{{ $sort }}">
                                                <input type="hidden" name="direction" value="{{ $direction }}">
                                                <div class="filtersearch-bd flex-wrap">
                                                    <div class="vehicletype ms-1">
                                                        <label>Tyre Type</label>
                                                        <select class="form-select" name="f5_type">
                                                            <option value="">All</option>
                                                            <option value="Nylon" {{ request('f5_type') == 'Nylon' ? 'selected' : '' }}>Nylon</option>
                                                            <option value="Radial" {{ request('f5_type') == 'Radial' ? 'selected' : '' }}>Radial</option>
                                                        </select>
                                                    </div>
                                                    <div class="vehicletype ms-1">
                                                        <label>Tyre Location</label>
                                                        <select class="form-select" name="f5_location">
                                                            <option value="">All</option>
                                                            <option value="SR Garage" {{ request('f5_location') == 'SR Garage' ? 'selected' : '' }}>SR Garage</option>
                                                            <option value="Sent for Scrap" {{ request('f5_location') == 'Sent for Scrap' ? 'selected' : '' }}>Sent for Scrap</option>
                                                        </select>
                                                    </div>
                                                    <div class="vehicletype ms-1">
                                                        <label>Brand</label>
                                                        <select class="form-select" name="f5_brand">
                                                            <option value="">All</option>
                                                            @foreach($tyreBrands as $brand)
                                                                <option value="{{ $brand }}" {{ request('f5_brand') == $brand ? 'selected' : '' }}>{{ $brand }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="vehicletype ms-1">
                                                        <label>Scrap Vendor</label>
                                                        <select class="form-select" name="f5_vendor">
                                                            <option value="">All</option>
                                                            @foreach($tyrevendors as $v)
                                                                <option value="{{ $v->id }}" {{ request('f5_vendor') == $v->id ? 'selected' : '' }}>{{ $v->contact_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="vehicletype ms-1">
                                                        <label>Income Received</label>
                                                        <select class="form-select" name="f5_income">
                                                            <option value="">All</option>
                                                            <option value="Yes" {{ request('f5_income') == 'Yes' ? 'selected' : '' }}>Yes (UTR filled)</option>
                                                            <option value="No" {{ request('f5_income') == 'No' ? 'selected' : '' }}>No (Pending)</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="filtersearch-bd justify-content-start mt-2">
                                                    <div class="ms-1" style="width:220px;">
                                                        <div class="input-group">
                                                            <input type="text" name="f5_serial" class="form-control" placeholder="Search by Serial Number" value="{{ request('f5_serial') }}">
                                                            <span class="input-group-text"><i class="uil uil-search"></i></span>
                                                        </div>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary ms-1"><i class="uil uil-filter me-1"></i>Filter</button>
                                                    <a href="{{ route('tyre.dashboard') }}?active_tab=tab-scrap" class="btn btn-primary ms-1"><i class="uil uil-sync me-1"></i>Reset</a>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="sr_dashboard0_table">
                                <div class="container-fluid">
                                    @include('tyre.partials.tab-scrap')
                                </div>
                            </div>
                        </div>

                        {{-- ══════════════════════════════════════════════════
                             TAB 6: ALLOCATE TYRES
                        ══════════════════════════════════════════════════ --}}
                        <div class="tab-pane fade" id="tab-allocated" role="tabpanel">
                            <div class="accordion mt-2" id="acc-tab6">
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button filter-options" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-tab6">
                                            <div class="item-filter"><div class="filter"><span class="filter-icon"><img src="{{ asset('images/icons/filter-01icon.png') }}" alt="icon"></span></div><p class="mb-0">Filter Options</p></div>
                                        </button>
                                    </h2>
                                    <div id="collapse-tab6" class="accordion-collapse collapse show">
                                        <div class="accordion-body">
                                            <form method="GET" action="{{ route('tyre.dashboard') }}" id="filter-form-6">
                                                <input type="hidden" name="active_tab" value="tab-allocated">
                                                <input type="hidden" name="sort" value="{{ $sort }}">
                                                <input type="hidden" name="direction" value="{{ $direction }}">
                                                <div class="filtersearch-bd flex-wrap">
                                                    <div class="vehicletype ms-1">
                                                        <label>Tyre Type</label>
                                                        <select class="form-select" name="f6_type">
                                                            <option value="">All</option>
                                                            <option value="Nylon" {{ request('f6_type') == 'Nylon' ? 'selected' : '' }}>Nylon</option>
                                                            <option value="Radial" {{ request('f6_type') == 'Radial' ? 'selected' : '' }}>Radial</option>
                                                        </select>
                                                    </div>
                                                    <div class="vehicletype ms-1">
                                                        <label>Tyre Condition</label>
                                                        <select class="form-select" name="f6_condition">
                                                            <option value="">All</option>
                                                            <option value="New" {{ request('f6_condition') == 'New' ? 'selected' : '' }}>New</option>
                                                            <option value="Used" {{ request('f6_condition') == 'Used' ? 'selected' : '' }}>Used</option>
                                                            <option value="Re-thread" {{ request('f6_condition') == 'Re-thread' ? 'selected' : '' }}>Re-thread</option>
                                                        </select>
                                                    </div>
                                                    <div class="vehicletype ms-1">
                                                        <label>Warranty</label>
                                                        <select class="form-select" name="f6_warranty">
                                                            <option value="">All</option>
                                                            <option value="Active" {{ request('f6_warranty') == 'Active' ? 'selected' : '' }}>Active</option>
                                                            <option value="Expired" {{ request('f6_warranty') == 'Expired' ? 'selected' : '' }}>Expired</option>
                                                        </select>
                                                    </div>
                                                    <div class="vehicletype ms-1">
                                                        <label>Brand</label>
                                                        <select class="form-select" name="f6_brand">
                                                            <option value="">All</option>
                                                            @foreach($tyreBrands as $brand)
                                                                <option value="{{ $brand }}" {{ request('f6_brand') == $brand ? 'selected' : '' }}>{{ $brand }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="vehicletype ms-1">
                                                        <label>Vendor</label>
                                                        <select class="form-select" name="f6_vendor">
                                                            <option value="">All</option>
                                                            @foreach($tyrevendors as $v)
                                                                <option value="{{ $v->id }}" {{ request('f6_vendor') == $v->id ? 'selected' : '' }}>{{ $v->contact_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="filtersearch-bd justify-content-start mt-2">
                                                    <div class="ms-1" style="width:220px;">
                                                        <div class="input-group">
                                                            <input type="text" name="f6_serial" class="form-control" placeholder="Search by Serial Number" value="{{ request('f6_serial') }}">
                                                            <span class="input-group-text"><i class="uil uil-search"></i></span>
                                                        </div>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary ms-1"><i class="uil uil-filter me-1"></i>Filter</button>
                                                    <a href="{{ route('tyre.dashboard') }}?active_tab=tab-allocated" class="btn btn-primary ms-1"><i class="uil uil-sync me-1"></i>Reset</a>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="sr_dashboard0_table">
                                <div class="container-fluid">
                                    @include('tyre.partials.tab-allocated')
                                </div>
                            </div>
                        </div>

                        {{-- ══════════════════════════════════════════════════
                             TAB 7: DIRECT FITMENT
                        ══════════════════════════════════════════════════ --}}
                        <div class="tab-pane fade" id="tab-direct" role="tabpanel">
                            <div class="accordion mt-2" id="acc-tab7">
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button filter-options" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-tab7">
                                            <div class="item-filter"><div class="filter"><span class="filter-icon"><img src="{{ asset('images/icons/filter-01icon.png') }}" alt="icon"></span></div><p class="mb-0">Filter Options</p></div>
                                        </button>
                                    </h2>
                                    <div id="collapse-tab7" class="accordion-collapse collapse show">
                                        <div class="accordion-body">
                                            <form method="GET" action="{{ route('tyre.dashboard') }}" id="filter-form-7">
                                                <input type="hidden" name="active_tab" value="tab-direct">
                                                <input type="hidden" name="sort" value="{{ $sort }}">
                                                <input type="hidden" name="direction" value="{{ $direction }}">
                                                <div class="filtersearch-bd flex-wrap">
                                                    <div class="vehicletype ms-1">
                                                        <label>Tyre Type</label>
                                                        <select class="form-select" name="f7_type">
                                                            <option value="">All</option>
                                                            <option value="Nylon" {{ request('f7_type') == 'Nylon' ? 'selected' : '' }}>Nylon</option>
                                                            <option value="Radial" {{ request('f7_type') == 'Radial' ? 'selected' : '' }}>Radial</option>
                                                        </select>
                                                    </div>
                                                    <div class="vehicletype ms-1">
                                                        <label>Tyre Condition</label>
                                                        <select class="form-select" name="f7_condition">
                                                            <option value="">All</option>
                                                            <option value="New" {{ request('f7_condition') == 'New' ? 'selected' : '' }}>New</option>
                                                            <option value="Used" {{ request('f7_condition') == 'Used' ? 'selected' : '' }}>Used</option>
                                                            <option value="Re-thread" {{ request('f7_condition') == 'Re-thread' ? 'selected' : '' }}>Re-thread</option>
                                                        </select>
                                                    </div>
                                                    <div class="vehicletype ms-1">
                                                        <label>Brand</label>
                                                        <select class="form-select" name="f7_brand">
                                                            <option value="">All</option>
                                                            @foreach($tyreBrands as $brand)
                                                                <option value="{{ $brand }}" {{ request('f7_brand') == $brand ? 'selected' : '' }}>{{ $brand }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="vehicletype ms-1">
                                                        <label>Vendor</label>
                                                        <select class="form-select" name="f7_vendor">
                                                            <option value="">All</option>
                                                            @foreach($tyrevendors as $v)
                                                                <option value="{{ $v->id }}" {{ request('f7_vendor') == $v->id ? 'selected' : '' }}>{{ $v->contact_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="filtersearch-bd justify-content-start mt-2">
                                                    <div class="ms-1" style="width:220px;">
                                                        <div class="input-group">
                                                            <input type="text" name="f7_serial" class="form-control" placeholder="Search by Serial Number" value="{{ request('f7_serial') }}">
                                                            <span class="input-group-text"><i class="uil uil-search"></i></span>
                                                        </div>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary ms-1"><i class="uil uil-filter me-1"></i>Filter</button>
                                                    <a href="{{ route('tyre.dashboard') }}?active_tab=tab-direct" class="btn btn-primary ms-1"><i class="uil uil-sync me-1"></i>Reset</a>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="sr_dashboard0_table">
                                <div class="container-fluid">
                                    @include('tyre.partials.tab-direct-fitment')
                                </div>
                            </div>
                        </div>

                        {{-- ══════════════════════════════════════════════════
                             TAB 8: YET TO DECIDE
                        ══════════════════════════════════════════════════ --}}
                        <div class="tab-pane fade" id="tab-ytd" role="tabpanel">
                            <div class="accordion mt-2" id="acc-tab8">
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button filter-options" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-tab8">
                                            <div class="item-filter"><div class="filter"><span class="filter-icon"><img src="{{ asset('images/icons/filter-01icon.png') }}" alt="icon"></span></div><p class="mb-0">Filter Options</p></div>
                                        </button>
                                    </h2>
                                    <div id="collapse-tab8" class="accordion-collapse collapse show">
                                        <div class="accordion-body">
                                            <form method="GET" action="{{ route('tyre.dashboard') }}" id="filter-form-8">
                                                <input type="hidden" name="active_tab" value="tab-ytd">
                                                <input type="hidden" name="sort" value="{{ $sort }}">
                                                <input type="hidden" name="direction" value="{{ $direction }}">
                                                <div class="filtersearch-bd flex-wrap">
                                                    <div class="vehicletype ms-1">
                                                        <label>Tyre Type</label>
                                                        <select class="form-select" name="f8_type">
                                                            <option value="">All</option>
                                                            <option value="Nylon" {{ request('f8_type') == 'Nylon' ? 'selected' : '' }}>Nylon</option>
                                                            <option value="Radial" {{ request('f8_type') == 'Radial' ? 'selected' : '' }}>Radial</option>
                                                        </select>
                                                    </div>
                                                    <div class="vehicletype ms-1">
                                                        <label>Tyre Condition</label>
                                                        <select class="form-select" name="f8_condition">
                                                            <option value="">All</option>
                                                            <option value="New" {{ request('f8_condition') == 'New' ? 'selected' : '' }}>New</option>
                                                            <option value="Used" {{ request('f8_condition') == 'Used' ? 'selected' : '' }}>Used</option>
                                                            <option value="Re-thread" {{ request('f8_condition') == 'Re-thread' ? 'selected' : '' }}>Re-thread</option>
                                                        </select>
                                                    </div>
                                                    <div class="vehicletype ms-1">
                                                        <label>Tyre Location</label>
                                                        <select class="form-select" name="f8_location">
                                                            <option value="">All</option>
                                                            <option value="Warehouse" {{ request('f8_location') == 'Warehouse' ? 'selected' : '' }}>SR Garage</option>
                                                            <option value="Vehicle" {{ request('f8_location') == 'Vehicle' ? 'selected' : '' }}>Vehicle</option>
                                                        </select>
                                                    </div>
                                                    <div class="vehicletype ms-1">
                                                        <label>Brand</label>
                                                        <select class="form-select" name="f8_brand">
                                                            <option value="">All</option>
                                                            @foreach($tyreBrands as $brand)
                                                                <option value="{{ $brand }}" {{ request('f8_brand') == $brand ? 'selected' : '' }}>{{ $brand }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="vehicletype ms-1">
                                                        <label>Vendor</label>
                                                        <select class="form-select" name="f8_vendor">
                                                            <option value="">All</option>
                                                            @foreach($tyrevendors as $v)
                                                                <option value="{{ $v->id }}" {{ request('f8_vendor') == $v->id ? 'selected' : '' }}>{{ $v->contact_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="filtersearch-bd justify-content-start mt-2">
                                                    <div class="ms-1" style="width:220px;">
                                                        <div class="input-group">
                                                            <input type="text" name="f8_serial" class="form-control" placeholder="Search by Serial Number" value="{{ request('f8_serial') }}">
                                                            <span class="input-group-text"><i class="uil uil-search"></i></span>
                                                        </div>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary ms-1"><i class="uil uil-filter me-1"></i>Filter</button>
                                                    <a href="{{ route('tyre.dashboard') }}?active_tab=tab-ytd" class="btn btn-primary ms-1"><i class="uil uil-sync me-1"></i>Reset</a>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="sr_dashboard0_table">
                                <div class="container-fluid">
                                    @include('tyre.partials.tab-yet-to-decide')
                                </div>
                            </div>
                        </div>

                    </div>{{-- /tab-content --}}
                </div>{{-- /right-side-wrap --}}
            </div>{{-- /container-fluid --}}
        </div>{{-- /itemvehicles-bd --}}

    </div>

</div>

@endsection

@section('js')
<script type="text/javascript" src="{{ asset('customjs/tyre/dashboard.js?v=2.2') }}"></script>
@endsection
