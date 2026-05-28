@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/fleet/dashboard.css?v=1.0') }}">
<link href="{{ asset('css/Battery/owner-dashboard.css?v=1.0') }}" rel="stylesheet">
@endsection

@section('content')
<div class="layout-wrapper">

    @include('includes.header')

    <div class="dashboard-bd srlog-bdwrapper">

        {{-- ── Page Title Bar ─────────────────────────────────────────────── --}}
        <div class="top-text">
           <div class="container-fluid">
               <div class="row">
                   <div class="col-12 col-md-6">
                       <h1>Battery Owner Dashboard</h1>
                   </div>
                   <div class="col-12 col-md-6 text-end">
                       <a href="{{ route('inventory.battery-dashboard') }}" class="btn btn-primary mt-2 mb-2">
                           <i class="fa fa-battery-three-quarters me-1"></i>Battery Dashboard
                       </a>
                   </div>
               </div>
           </div>
        </div>

        <div class="itemvehicles-bd">
        <div class="container-fluid">

        {{-- ── Filter Bar ───────────────────────────────────────────────── --}}
        <div class="bod-filter-section-label">
            <i class="fa fa-sliders-h"></i> Filter Options
        </div>
        <div class="bod-filter-bar">
            <form id="bod-filter-form" method="GET" action="{{ route('battery.owner-dashboard') }}">
                <div class="row g-3 align-items-end">
                    <div class="col-md-2">
                        <span class="bod-filter-label">Date From</span>
                        <input type="date" id="filter_date_from" name="date_from"
                               class="form-control" value="{{ $dateFrom }}">
                    </div>
                    <div class="col-md-2">
                        <span class="bod-filter-label">Date To</span>
                        <input type="date" id="filter_date_to" name="date_to"
                               class="form-control" value="{{ $dateTo }}">
                    </div>
                    <div class="col-md-auto">
                        <button type="submit" class="btn-filter-apply">
                            <i class="fa fa-filter me-1"></i>Apply
                        </button>
                        &nbsp;
                        <button type="button" id="bod-filter-reset" class="btn-filter-reset">
                            <i class="fa fa-times me-1"></i>Reset
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- ══════════════════════════════════════════════════════════════════
             SECTION 1 — BATTERY ACTIVITY SUMMARY
        ══════════════════════════════════════════════════════════════════ --}}
        <h2 class="bod-section-heading">
            <span class="bod-section-icon" style="background:#eff6ff;">🔋</span>
            Battery Activity Summary
        </h2>

        <div class="bod-kpi-grid">

            {{-- All Batteries --}}
            <div class="bod-kpi-card card-all">
                <div class="bod-kpi-label"><i class="fa fa-battery-full"></i> All Batteries</div>
                <div class="bod-kpi-row">
                    <div class="bod-kpi-qty">
                        <div class="qty-number bod-count-animate" data-target="0">0</div>
                        <div class="qty-sub">Qty</div>
                    </div>
                    <div class="bod-kpi-divider"></div>
                    <div class="bod-kpi-amount">
                        <div class="amt-number bod-count-animate" data-target="0" data-float="true" data-prefix="₹">₹0</div>
                        <div class="amt-sub">Cost</div>
                    </div>
                </div>
            </div>

            {{-- New Batteries --}}
            <div class="bod-kpi-card card-new">
                <div class="bod-kpi-label"><i class="fa fa-plus-circle"></i> New Batteries</div>
                <div class="bod-kpi-row">
                    <div class="bod-kpi-qty">
                        <div class="qty-number bod-count-animate" data-target="0">0</div>
                        <div class="qty-sub">Qty</div>
                    </div>
                    <div class="bod-kpi-divider"></div>
                    <div class="bod-kpi-amount">
                        <div class="amt-number bod-count-animate" data-target="0" data-float="true" data-prefix="₹">₹0</div>
                        <div class="amt-sub">Cost</div>
                    </div>
                </div>
            </div>

            {{-- Repair Batteries --}}
            <div class="bod-kpi-card card-repair">
                <div class="bod-kpi-label"><i class="fa fa-wrench"></i> Repair Batteries</div>
                <div class="bod-kpi-row">
                    <div class="bod-kpi-qty">
                        <div class="qty-number bod-count-animate" data-target="0">0</div>
                        <div class="qty-sub">Qty</div>
                    </div>
                    <div class="bod-kpi-divider"></div>
                    <div class="bod-kpi-amount">
                        <div class="amt-number bod-count-animate" data-target="0" data-float="true" data-prefix="₹">₹0</div>
                        <div class="amt-sub">Cost</div>
                    </div>
                </div>
            </div>

            {{-- Replaced Under Warranty --}}
            <div class="bod-kpi-card card-warranty">
                <div class="bod-kpi-label"><i class="fa fa-shield-alt"></i> Replaced Under Warranty</div>
                <div class="bod-kpi-row">
                    <div class="bod-kpi-qty">
                        <div class="qty-number bod-count-animate" data-target="0">0</div>
                        <div class="qty-sub">Qty</div>
                    </div>
                    <div class="bod-kpi-divider" style="opacity:0;"></div>
                    <div class="bod-kpi-amount" style="visibility:hidden;">
                        <div class="amt-number">—</div>
                        <div class="amt-sub">&nbsp;</div>
                    </div>
                </div>
            </div>

            {{-- Scrap Batteries --}}
            <div class="bod-kpi-card card-income">
                <div class="bod-kpi-label"><i class="fa fa-trash-alt"></i> Scrap Batteries</div>
                <div class="bod-kpi-row">
                    <div class="bod-kpi-qty">
                        <div class="qty-number bod-count-animate" data-target="0">0</div>
                        <div class="qty-sub">Qty</div>
                    </div>
                    <div class="bod-kpi-divider"></div>
                    <div class="bod-kpi-amount">
                        <div class="amt-number amt-income bod-count-animate" data-target="0" data-float="true" data-prefix="₹">₹0</div>
                        <div class="amt-sub">Income</div>
                    </div>
                </div>
            </div>

        </div>{{-- /.bod-kpi-grid --}}

        {{-- ══════════════════════════════════════════════════════════════════
             SECTION 2 — RAG STATUS OVERVIEW
        ══════════════════════════════════════════════════════════════════ --}}
        <h2 class="bod-section-heading">
            <span class="bod-section-icon" style="background:#f0fdf4;">🟢</span>
            Battery Health — RAG Status
        </h2>
        <div class="bod-info-note">
            <i class="fa fa-info-circle"></i>
            RAG status is calculated from remaining life as a percentage of rated battery life (months).
            Only batteries with a fixed life set are included.
            Green &gt; 50% remaining · Yellow 10–50% · Red &lt; 10%.
        </div>

        <div class="bod-rag-grid">
            <div class="bod-rag-card rag-green">
                <div class="rag-dot">✅</div>
                <div class="rag-info">
                    <div class="rag-count bod-count-animate" data-target="0">0</div>
                    <div class="rag-label">Green Batteries</div>
                    <div class="rag-sublabel">&gt; 50% life remaining</div>
                </div>
            </div>
            <div class="bod-rag-card rag-yellow">
                <div class="rag-dot">⚠️</div>
                <div class="rag-info">
                    <div class="rag-count bod-count-animate" data-target="0">0</div>
                    <div class="rag-label">Yellow Batteries</div>
                    <div class="rag-sublabel">10%–50% life remaining</div>
                </div>
            </div>
            <div class="bod-rag-card rag-red">
                <div class="rag-dot">🚨</div>
                <div class="rag-info">
                    <div class="rag-count bod-count-animate" data-target="0">0</div>
                    <div class="rag-label">Red Batteries</div>
                    <div class="rag-sublabel">&lt; 10% life remaining</div>
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════════════════════════════════
             SECTION 3 — ANALYTICS & INSIGHTS
        ══════════════════════════════════════════════════════════════════ --}}
        <h2 class="bod-section-heading">
            <span class="bod-section-icon" style="background:#faf5ff;">📊</span>
            Analytics &amp; Insights
        </h2>

        <div class="bod-analytics-wrap">

            {{-- Vehicle with Highest Battery Maintenance Cost --}}
            <div class="bod-analytics-card">
                <div class="bod-section-heading" style="font-size:13px; border-bottom-color:#f3f4f6;">
                    🚛 Vehicles — Highest Battery Maintenance Cost
                </div>
                <table class="bod-analytics-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Vehicle</th>
                            <th>Repairs</th>
                            <th>Total Cost</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $dummyVehicles = [
                            ['reg' => '—', 'make' => '—', 'repairs' => 0, 'total' => 0],
                            ['reg' => '—', 'make' => '—', 'repairs' => 0, 'total' => 0],
                            ['reg' => '—', 'make' => '—', 'repairs' => 0, 'total' => 0],
                            ['reg' => '—', 'make' => '—', 'repairs' => 0, 'total' => 0],
                            ['reg' => '—', 'make' => '—', 'repairs' => 0, 'total' => 0],
                        ];
                        @endphp
                        @foreach($dummyVehicles as $di => $dv)
                        <tr style="opacity:0.55;">
                            <td>
                                <span class="rank-badge {{ $di < 3 ? 'rank-'.($di+1) : '' }}">{{ $di+1 }}</span>
                            </td>
                            <td>
                                <strong>{{ $dv['reg'] }}</strong><br>
                                <small class="text-muted">{{ $dv['make'] }}</small>
                            </td>
                            <td class="text-center">{{ $dv['repairs'] }}</td>
                            <td>
                                <span class="cost-chip">₹{{ number_format($dv['total'], 2) }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="bod-placeholder-note">
                    <i class="fa fa-info-circle me-1"></i>Data will be wired in a future release.
                </div>
            </div>

            {{-- Battery with Highest Maintenance Cost --}}
            <div class="bod-analytics-card">
                <div class="bod-section-heading" style="font-size:13px; border-bottom-color:#f3f4f6;">
                    🔋 Batteries — Highest Maintenance Cost
                </div>
                <table class="bod-analytics-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Battery</th>
                            <th>Status</th>
                            <th>Total Cost</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $dummyBatteries = [
                            ['serial' => '—', 'brand' => '—', 'status' => '—', 'total' => 0],
                            ['serial' => '—', 'brand' => '—', 'status' => '—', 'total' => 0],
                            ['serial' => '—', 'brand' => '—', 'status' => '—', 'total' => 0],
                            ['serial' => '—', 'brand' => '—', 'status' => '—', 'total' => 0],
                            ['serial' => '—', 'brand' => '—', 'status' => '—', 'total' => 0],
                        ];
                        @endphp
                        @foreach($dummyBatteries as $di => $db)
                        <tr style="opacity:0.55;">
                            <td>
                                <span class="rank-badge {{ $di < 3 ? 'rank-'.($di+1) : '' }}">{{ $di+1 }}</span>
                            </td>
                            <td>
                                <strong>{{ $db['serial'] }}</strong><br>
                                <small class="text-muted">{{ $db['brand'] }}</small>
                            </td>
                            <td>
                                <span class="badge" style="font-size:9px; background:#f3f4f6; color:#374151;">
                                    {{ $db['status'] }}
                                </span>
                            </td>
                            <td>
                                <span class="cost-chip">₹{{ number_format($db['total'], 2) }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="bod-placeholder-note">
                    <i class="fa fa-info-circle me-1"></i>Data will be wired in a future release.
                </div>
            </div>

        </div>{{-- /.bod-analytics-wrap --}}

        {{-- ══════════════════════════════════════════════════════════════════
             SECTION 4 — BUDGET SECTION
        ══════════════════════════════════════════════════════════════════ --}}
        <h2 class="bod-section-heading">
            <span class="bod-section-icon" style="background:#fff7ed;">💰</span>
            Budget Planning
        </h2>

        <div class="bod-budget-grid">

            {{-- Red Battery Replacement Budget --}}
            <div class="bod-budget-card">
                <div class="bud-title">
                    <i class="fa fa-exclamation-triangle" style="color:#ef4444;"></i>
                    Red Batteries — Replacement Budget Estimate
                </div>
                <div class="bud-row">
                    <span class="bud-key">Red Batteries (Critical — &lt;10% life)</span>
                    <span class="bud-val bud-ok">0 batteries</span>
                </div>
                <div class="bud-row">
                    <span class="bud-key">Avg Price of New Battery</span>
                    <span class="bud-val">₹0.00</span>
                </div>
                <div class="bud-row">
                    <span class="bud-key">Estimated Replacement Budget</span>
                    <span class="bud-val bud-ok">₹0.00</span>
                </div>
                <div class="bod-info-note mt-2" style="background:#f0fdf4; border-color:#6ee7b7; color:#065f46;">
                    <i class="fa fa-check-circle"></i>
                    No critical red batteries at this time.
                </div>
                <div class="bod-placeholder-note">
                    <i class="fa fa-clock me-1"></i>
                    The system will calculate remaining KM life and predict when each battery reaches its limit —
                    triggering a replacement recommendation. This section will be wired in a future release.
                </div>
            </div>

            {{-- KM Life Prediction Note --}}
            <div class="bod-budget-card">
                <div class="bud-title">
                    <i class="fa fa-road" style="color:#8b5cf6;"></i>
                    Predictive Replacement — KM Life Forecast
                </div>
                <div class="bud-row">
                    <span class="bud-key">Batteries Fitted to Vehicles</span>
                    <span class="bud-val">0</span>
                </div>
                <div class="bud-row">
                    <span class="bud-key">Batteries with KM Life Set</span>
                    <span class="bud-val">0</span>
                </div>
                <div class="bud-row">
                    <span class="bud-key">Avg Daily KM Usage (Fleet)</span>
                    <span class="bud-val">— km/day</span>
                </div>
                <div class="bud-row">
                    <span class="bud-key">Replacement Due Within 30 Days</span>
                    <span class="bud-val bud-ok">0 batteries</span>
                </div>
                <div class="bod-info-note mt-2">
                    <i class="fa fa-info-circle"></i>
                    Predicted replacement date is calculated from remaining KM ÷ average daily KM usage
                    (derived from vehicle assignment history).
                    <strong>Red</strong> = replacement within 30 days &nbsp;|&nbsp;
                    <strong>Amber</strong> = within 90 days &nbsp;|&nbsp;
                    <strong>Green</strong> = &gt; 90 days.
                </div>
                <div class="bod-placeholder-note">
                    <i class="fa fa-clock me-1"></i>Data will be wired in a future release.
                </div>
            </div>

        </div>{{-- /.bod-budget-grid --}}

        </div>{{-- /.container-fluid --}}
        </div>{{-- /.itemvehicles-bd --}}

    </div>{{-- /.dashboard-bd --}}
</div>{{-- /.layout-wrapper --}}
@endsection

@section('js')
<script src="{{ asset('js/Battery/owner-dashboard.js?v=1.0') }}"></script>
@endsection
