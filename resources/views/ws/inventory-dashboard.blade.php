@extends('layouts.app')

@section('css')
<link href="{{ asset('css/Workshop/inventory-dashboard.css?v=1.0') }}" rel="stylesheet">
<link href="{{ asset('css/Workshop/inventory-dashboard.css?v=1.0') }}" rel="stylesheet">
@endsection

@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="wrapper srlog-bdwrapper">
        <div class="main-wrap sc-no-sidebar">

            <nav aria-label="breadcrumb" class="mb-2">
                <ol class="breadcrumb sc-breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Inventory</li>
                </ol>
            </nav>

            <div class="sc-page-head d-flex align-items-center justify-content-between mb-3">
                <div>
                    <h5 class="mb-0">Inventory</h5>
                    <span class="text-muted" style="font-size:12px;">Warehouses &amp; Workshops — stock, procurement, and transfers</span>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('inventory.stock-transfer') }}" class="btn btn-outline-secondary btn-sm"><i class="uil uil-exchange-alt me-1"></i>Stock Transfer</a>
                    <a href="{{ route('inventory.purchase-orders') }}" class="btn btn-outline-secondary btn-sm"><i class="uil uil-shopping-cart-alt me-1"></i>New PO</a>
                    <a href="{{ route('inventory.spare-parts') }}" class="btn sc-btn-navy btn-sm"><i class="uil uil-plus me-1"></i>Add Stock</a>
                </div>
            </div>

            {{-- Location context bar --}}
            <div class="loc-ctx-bar">
                <div class="loc-ctx-left">
                    <i class="uil uil-map-marker loc-ctx-icon"></i>
                    <span class="loc-ctx-label">View:</span>
                    <div class="loc-ctx-pills" id="locPills">
                        <span class="loc-ctx-pill all active" data-loc="all">All Locations</span>
                        <span class="loc-ctx-pill wh"  data-loc="WH-BLR"><i class="uil uil-warehouse"></i> WH — Bangalore</span>
                        <span class="loc-ctx-pill wh"  data-loc="WH-HYD"><i class="uil uil-warehouse"></i> WH — Hyderabad</span>
                        <span class="loc-ctx-pill wh"  data-loc="WH-PNE"><i class="uil uil-warehouse"></i> WH — Pune</span>
                        <span class="loc-ctx-pill sc"  data-loc="WS-HYD"><i class="uil uil-wrench"></i> WS — Hyderabad</span>
                    </div>
                </div>
                <div style="font-size:11px;color:#adb5bd;">3 Warehouses · 1 Workshop</div>
            </div>

            {{-- Aggregate Stats --}}
            <div class="row g-3 mb-3">
                <div class="col-6 col-md-3">
                    <div class="sc-stat-card sc-stat-navy">
                        <div class="sc-stat-icon"><i class="uil uil-box"></i></div>
                        <div class="sc-stat-body"><div class="sc-stat-val">1,842</div><div class="sc-stat-label">Total SKUs (All)</div></div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="sc-stat-card sc-stat-amber">
                        <div class="sc-stat-icon"><i class="uil uil-exclamation-triangle"></i></div>
                        <div class="sc-stat-body"><div class="sc-stat-val">23</div><div class="sc-stat-label">Low / Out of Stock</div></div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="sc-stat-card sc-stat-green">
                        <div class="sc-stat-icon"><i class="uil uil-rupee-sign"></i></div>
                        <div class="sc-stat-body"><div class="sc-stat-val">₹18.4L</div><div class="sc-stat-label">Total Stock Value</div></div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="sc-stat-card sc-stat-grey">
                        <div class="sc-stat-icon"><i class="uil uil-exchange-alt"></i></div>
                        <div class="sc-stat-body"><div class="sc-stat-val">3</div><div class="sc-stat-label">Transfers In Transit</div></div>
                    </div>
                </div>
            </div>

            {{-- Per-Location Cards --}}
            <div class="sc-ins-detail-label mb-2">Stock by Location</div>
            <div class="loc-stat-grid mb-4">
                @php
                $locations = [
                    ['WH','WH-BLR','Warehouse — Bangalore','784','₹8.2L','4','0'],
                    ['WH','WH-HYD','Warehouse — Hyderabad','612','₹6.1L','11','2'],
                    ['WH','WH-PNE','Warehouse — Pune','288','₹2.4L','3','1'],
                    ['SC','WS-HYD','Workshop — Hyderabad','56','₹0.5L','2','1'],
                ];
                @endphp
                @foreach($locations as $loc)
                <div class="loc-stat-card loc-{{ strtolower($loc[0]) }}">
                    <div class="loc-stat-type">{{ $loc[0] === 'WH' ? 'Warehouse' : 'Workshop' }}</div>
                    <div class="loc-stat-name">{{ $loc[2] }}</div>
                    <div class="loc-stat-row">
                        <span class="loc-stat-row-label">SKUs</span>
                        <span class="loc-stat-row-val">{{ $loc[3] }}</span>
                    </div>
                    <div class="loc-stat-row">
                        <span class="loc-stat-row-label">Stock Value</span>
                        <span class="loc-stat-row-val">{{ $loc[4] }}</span>
                    </div>
                    <div class="loc-stat-row">
                        <span class="loc-stat-row-label">Low Stock</span>
                        <span class="loc-stat-row-val {{ $loc[5] > 0 ? 'loc-stat-alert' : '' }}">{{ $loc[5] }}</span>
                    </div>
                    <div class="loc-stat-row">
                        <span class="loc-stat-row-label">Out of Stock</span>
                        <span class="loc-stat-row-val {{ $loc[6] > 0 ? 'loc-stat-alert' : '' }}">{{ $loc[6] }}</span>
                    </div>
                    <div class="mt-2 pt-2" style="border-top:1px solid #e4e7ef;">
                        <a href="{{ route('inventory.spare-parts') }}?location={{ $loc[1] }}" style="font-size:11px;color:#032671;">View Stock →</a>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Module Quick Links --}}
            <div class="sc-ins-detail-label mb-2">Modules</div>
            <div class="row g-3 mb-4">
                @php
                $modules = [
                    ['Spare Parts',      'uil-cog',              'inventory.spare-parts',     '1,204 items · 18 low stock',   'sc-stat-navy'],
                    ['Tyre Inventory',   'uil-circle',           'inventory.tyres',            '638 items · 3 low stock',      'sc-stat-grey'],
                    ['Battery Inventory','uil-battery-bolt',     'inventory.batteries',        '—',                            'sc-stat-amber'],
                    ['Stock Transfer',   'uil-exchange-alt',     'inventory.stock-transfer',   '3 in transit',                 'sc-stat-green'],
                    ['Purchase Orders',  'uil-shopping-cart-alt','inventory.purchase-orders',  '4 open · 2 awaiting GRN',      'sc-stat-navy'],
                    ['Goods Receipt',    'uil-file-check-alt',   'inventory.goods-receipt',    '2 pending verification',       'sc-stat-grey'],
                ];
                @endphp
                @foreach($modules as $m)
                <div class="col-6 col-md-4 col-lg-2">
                    <a href="{{ route($m[2]) }}" class="sc-inv-module-card {{ $m[4] }}">
                        <div class="sc-inv-module-icon"><i class="uil {{ $m[1] }}"></i></div>
                        <div class="sc-inv-module-name">{{ $m[0] }}</div>
                        <div class="sc-inv-module-meta">{{ $m[3] }}</div>
                    </a>
                </div>
                @endforeach
            </div>

            {{-- Two-column: Low Stock + Recent Transfers --}}
            <div class="row g-3 mb-3">

                {{-- Low Stock Alerts --}}
                <div class="col-lg-6">
                    <div class="sc-table-card h-100">
                        <div class="d-flex align-items-center justify-content-between p-3" style="border-bottom:1px solid #e4e7ef;">
                            <span style="font-size:13px;font-weight:700;color:#1a1a2e;">Low Stock Alerts</span>
                            <a href="{{ route('inventory.spare-parts') }}" style="font-size:12px;color:#032671;">View All</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table sc-table mb-0">
                                <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th>Location</th>
                                        <th class="text-center">Stock</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $lowStock = [
                                        ['Engine Oil 15W-40 (1L)','WH-HYD','Warehouse — Hyderabad','wh',2,'critical'],
                                        ['Air Filter — Tata Prima','WH-BLR','Warehouse — Bangalore','wh',1,'critical'],
                                        ['Fan Belt — AL 1916','WH-PNE','Warehouse — Pune','wh',3,'warning'],
                                        ['Injector Nozzle Set','WS-HYD','Workshop — Hyderabad','sc',0,'out'],
                                    ];
                                    $stMap = ['critical'=>'sc-stock-critical','warning'=>'sc-stock-warning','out'=>'sc-stock-out'];
                                    $stLabel = ['critical'=>'Low','warning'=>'Low','out'=>'Out of Stock'];
                                    @endphp
                                    @foreach($lowStock as $s)
                                    <tr>
                                        <td style="font-size:12px;font-weight:500;">{{ $s[0] }}</td>
                                        <td><span class="loc-badge loc-badge-{{ $s[3] }}"><i class="uil {{ $s[3]==='wh' ? 'uil-warehouse' : 'uil-wrench' }}"></i>{{ $s[1] }}</span></td>
                                        <td class="text-center" style="font-size:12px;font-weight:700;color:{{ $s[5]==='out' ? '#EA0027' : '#E65100' }};">{{ $s[4] }}</td>
                                        <td><span class="{{ $stMap[$s[5]] }}">{{ $stLabel[$s[5]] }}</span></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Recent Stock Transfers --}}
                <div class="col-lg-6">
                    <div class="sc-table-card h-100">
                        <div class="d-flex align-items-center justify-content-between p-3" style="border-bottom:1px solid #e4e7ef;">
                            <span style="font-size:13px;font-weight:700;color:#1a1a2e;">Recent Stock Transfers</span>
                            <a href="{{ route('inventory.stock-transfer') }}" style="font-size:12px;color:#032671;">View All</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table sc-table mb-0">
                                <thead>
                                    <tr>
                                        <th>Transfer #</th>
                                        <th>From → To</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $transfers = [
                                        ['TRF-2026-0008','WH-BLR','WS-HYD','10-Apr-2026','transit'],
                                        ['TRF-2026-0007','WH-HYD','WS-HYD','10-Apr-2026','transit'],
                                        ['TRF-2026-0006','WH-PNE','WH-HYD','09-Apr-2026','transit'],
                                        ['TRF-2026-0005','WH-BLR','WS-HYD','07-Apr-2026','received'],
                                        ['TRF-2026-0004','WH-HYD','WS-HYD','05-Apr-2026','received'],
                                    ];
                                    $trMap = ['transit'=>'sc-tr-transit','received'=>'sc-tr-received','pending'=>'sc-tr-pending'];
                                    $trLabel = ['transit'=>'In Transit','received'=>'Received','pending'=>'Pending'];
                                    @endphp
                                    @foreach($transfers as $t)
                                    <tr>
                                        <td><a href="{{ route('inventory.stock-transfer') }}" style="font-size:12px;color:#032671;font-weight:600;">{{ $t[0] }}</a></td>
                                        <td style="font-size:11px;">
                                            <span class="loc-badge loc-badge-{{ str_starts_with($t[1],'WH') ? 'wh' : 'sc' }}">{{ $t[1] }}</span>
                                            <span style="color:#adb5bd;margin:0 3px;">→</span>
                                            <span class="loc-badge loc-badge-{{ str_starts_with($t[2],'WH') ? 'wh' : 'sc' }}">{{ $t[2] }}</span>
                                        </td>
                                        <td class="text-nowrap" style="font-size:12px;">{{ $t[3] }}</td>
                                        <td><span class="{{ $trMap[$t[4]] }}">{{ $trLabel[$t[4]] }}</span></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Recent POs --}}
            <div class="sc-table-card">
                <div class="d-flex align-items-center justify-content-between p-3" style="border-bottom:1px solid #e4e7ef;">
                    <span style="font-size:13px;font-weight:700;color:#1a1a2e;">Recent Purchase Orders</span>
                    <a href="{{ route('inventory.purchase-orders') }}" style="font-size:12px;color:#032671;">View All</a>
                </div>
                <div class="table-responsive">
                    <table class="table sc-table mb-0">
                        <thead>
                            <tr>
                                <th>PO #</th>
                                <th>Vendor</th>
                                <th>Deliver To</th>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $recentPOs = [
                                ['PO-2026-0017','Bosch Auto Parts','WH-BLR','wh','09-Apr-2026',48500,'sc-po-approved'],
                                ['PO-2026-0016','Tata Motors Parts','WS-HYD','sc','08-Apr-2026',82000,'sc-po-pending'],
                                ['PO-2026-0015','National Tyres Co.','WH-HYD','wh','05-Apr-2026',114000,'sc-po-grn'],
                                ['PO-2026-0014','Royal Lubricants','WH-PNE','wh','02-Apr-2026',22000,'sc-po-closed'],
                                ['PO-2026-0013','BMS Batteries','WS-HYD','sc','28-Mar-2026',35000,'sc-po-closed'],
                            ];
                            $poLabel = ['sc-po-approved'=>'Approved','sc-po-pending'=>'Pending','sc-po-grn'=>'GRN Pending','sc-po-closed'=>'Closed'];
                            @endphp
                            @foreach($recentPOs as $po)
                            <tr>
                                <td><a href="{{ route('inventory.purchase-orders') }}" style="font-size:12px;color:#032671;font-weight:600;">{{ $po[0] }}</a></td>
                                <td style="font-size:12px;">{{ $po[1] }}</td>
                                <td><span class="loc-badge loc-badge-{{ $po[3] }}"><i class="uil {{ $po[3]==='wh' ? 'uil-warehouse' : 'uil-wrench' }}"></i>{{ $po[2] }}</span></td>
                                <td class="text-nowrap" style="font-size:12px;">{{ $po[4] }}</td>
                                <td style="font-size:12px;font-weight:600;">₹{{ number_format($po[5]) }}</td>
                                <td><span class="{{ $po[6] }}">{{ $poLabel[$po[6]] }}</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section('js')
<script>
$(function() {
    $('#locPills .loc-ctx-pill').on('click', function() {
        $('#locPills .loc-ctx-pill').removeClass('active');
        $(this).addClass('active');
        // In backend phase this will filter all sections via AJAX or URL param
    });
});
</script>
@endsection
