@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/fleet/dashboard.css?v=1.0') }}">
<link href="{{ asset('css/tyre/owner-dashboard.css?v=1.3') }}" rel="stylesheet">
@endsection

@section('content')
<div class="layout-wrapper">

    @include('includes.header')

    <div class="dashboard-bd srlog-bdwrapper">

        {{-- ── Page Title Bar (matches fleet-dashboard reference) ────────── --}}
        <div class="top-text">
           <div class="container-fluid">
               <div class="row">
                   <div class="col-12 col-md-6">
                       <h1>Tyre Owner Dashboard</h1>
                   </div>
                   <div class="col-12 col-md-6 text-end">
                       <a href="{{ route('tyre.dashboard') }}" class="btn btn-primary mt-2 mb-2">
                           <i class="fa fa-tachometer-alt me-1"></i>Tyre Dashboard
                       </a>
                   </div>
               </div>
           </div>
        </div>

        <div class="itemvehicles-bd">
        <div class="container-fluid">

        {{-- ── Filter Bar ───────────────────────────────────────────────── --}}
        <div class="tod-filter-bar">
            <form id="tod-filter-form" method="GET" action="{{ route('tyre.owner-dashboard') }}">
                <div class="row g-3 align-items-end">
                    <div class="col-md-2">
                        <span class="tod-filter-label">Date From</span>
                        <input type="date" id="filter_date_from" name="date_from"
                               class="form-control" value="{{ $dateFrom }}">
                    </div>
                    <div class="col-md-2">
                        <span class="tod-filter-label">Date To</span>
                        <input type="date" id="filter_date_to" name="date_to"
                               class="form-control" value="{{ $dateTo }}">
                    </div>
                    <div class="col-md-auto">
                        <button type="submit" class="btn-filter-apply">
                            <i class="fa fa-filter me-1"></i>Apply
                        </button>
                        &nbsp;
                        <button type="button" id="tod-filter-reset" class="btn-filter-reset">
                            <i class="fa fa-times me-1"></i>Reset
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- ══════════════════════════════════════════════════════════════════
             SECTION 1 — TYRE ACTIVITY SUMMARY
        ══════════════════════════════════════════════════════════════════ --}}
        <h2 class="tod-section-heading">
            <span class="tod-section-icon" style="background:#eff6ff;">📦</span>
            Tyre Activity Summary
        </h2>

        <div class="tod-kpi-grid">

            {{-- New Tyres --}}
            <div class="tod-kpi-card card-cost">
                <div class="tod-kpi-label"><i class="fa fa-plus-circle"></i> New Tyres</div>
                <div class="tod-kpi-row">
                    <div class="tod-kpi-qty">
                        <div class="qty-number tod-count-animate" data-target="{{ $newTyresQty }}">0</div>
                        <div class="qty-sub">Qty</div>
                    </div>
                    <div class="tod-kpi-divider"></div>
                    <div class="tod-kpi-amount">
                        <div class="amt-number tod-count-animate" data-target="{{ $newTyresCost }}" data-float="true" data-prefix="₹">₹0</div>
                        <div class="amt-sub">Cost</div>
                    </div>
                </div>
            </div>

            {{-- Old / Used Tyres --}}
            <div class="tod-kpi-card card-cost">
                <div class="tod-kpi-label"><i class="fa fa-recycle"></i> Old Tyres</div>
                <div class="tod-kpi-row">
                    <div class="tod-kpi-qty">
                        <div class="qty-number tod-count-animate" data-target="{{ $oldTyresQty }}">0</div>
                        <div class="qty-sub">Qty</div>
                    </div>
                    <div class="tod-kpi-divider"></div>
                    <div class="tod-kpi-amount">
                        <div class="amt-number tod-count-animate" data-target="{{ $oldTyresCost }}" data-float="true" data-prefix="₹">₹0</div>
                        <div class="amt-sub">Cost</div>
                    </div>
                </div>
            </div>

            {{-- Re-thread Tyres --}}
            <div class="tod-kpi-card card-rethread">
                <div class="tod-kpi-label"><i class="fa fa-sync-alt"></i> Re-thread Tyres</div>
                <div class="tod-kpi-row">
                    <div class="tod-kpi-qty">
                        <div class="qty-number tod-count-animate" data-target="{{ $rethreadQty }}">0</div>
                        <div class="qty-sub">Qty</div>
                    </div>
                    <div class="tod-kpi-divider"></div>
                    <div class="tod-kpi-amount">
                        <div class="amt-number tod-count-animate" data-target="{{ $rethreadCost }}" data-float="true" data-prefix="₹">₹0</div>
                        <div class="amt-sub">Cost</div>
                    </div>
                </div>
            </div>

            {{-- Warranty Claims --}}
            <div class="tod-kpi-card card-income">
                <div class="tod-kpi-label"><i class="fa fa-shield-alt"></i> Warranty Claims</div>
                <div class="tod-kpi-row">
                    <div class="tod-kpi-qty">
                        <div class="qty-number tod-count-animate" data-target="{{ $warrantyQty }}">0</div>
                        <div class="qty-sub">Qty</div>
                    </div>
                    <div class="tod-kpi-divider"></div>
                    <div class="tod-kpi-amount">
                        <div class="amt-number amt-income tod-count-animate" data-target="{{ $warrantyIncome }}" data-float="true" data-prefix="₹">₹0</div>
                        <div class="amt-sub">Income</div>
                    </div>
                </div>
            </div>

            {{-- Scrap Tyres --}}
            <div class="tod-kpi-card card-income">
                <div class="tod-kpi-label"><i class="fa fa-trash-alt"></i> Scrap Tyres</div>
                <div class="tod-kpi-row">
                    <div class="tod-kpi-qty">
                        <div class="qty-number tod-count-animate" data-target="{{ $scrapQty }}">0</div>
                        <div class="qty-sub">Qty</div>
                    </div>
                    <div class="tod-kpi-divider"></div>
                    <div class="tod-kpi-amount">
                        <div class="amt-number amt-income tod-count-animate" data-target="{{ $scrapIncome }}" data-float="true" data-prefix="₹">₹0</div>
                        <div class="amt-sub">Income</div>
                    </div>
                </div>
            </div>

            {{-- Scheduled Maintenance --}}
            <div class="tod-kpi-card card-maint">
                <div class="tod-kpi-label"><i class="fa fa-calendar-check"></i> Scheduled Maintenance</div>
                <div class="tod-kpi-row">
                    <div class="tod-kpi-qty">
                        <div class="qty-number tod-count-animate" data-target="{{ $maintQty }}">0</div>
                        <div class="qty-sub">Qty</div>
                    </div>
                    <div class="tod-kpi-divider"></div>
                    <div class="tod-kpi-amount">
                        <div class="amt-number tod-count-animate" data-target="{{ $maintCost }}" data-float="true" data-prefix="₹">₹0</div>
                        <div class="amt-sub">Cost</div>
                    </div>
                </div>
            </div>

            {{-- Repair Tyres --}}
            <div class="tod-kpi-card card-repair">
                <div class="tod-kpi-label"><i class="fa fa-wrench"></i> Repair Tyres</div>
                <div class="tod-kpi-row">
                    <div class="tod-kpi-qty">
                        <div class="qty-number tod-count-animate" data-target="{{ $repairQty }}">0</div>
                        <div class="qty-sub">Qty</div>
                    </div>
                    <div class="tod-kpi-divider"></div>
                    <div class="tod-kpi-amount">
                        <div class="amt-number tod-count-animate" data-target="{{ $repairCost }}" data-float="true" data-prefix="₹">₹0</div>
                        <div class="amt-sub">Cost</div>
                    </div>
                </div>
            </div>

        </div>{{-- /.tod-kpi-grid --}}

        {{-- ══════════════════════════════════════════════════════════════════
             SECTION 2 — RAG STATUS OVERVIEW
        ══════════════════════════════════════════════════════════════════ --}}
        <h2 class="tod-section-heading">
            <span class="tod-section-icon" style="background:#f0fdf4;">🟢</span>
            Tyre Health — RAG Status
        </h2>
        <div class="tod-info-note">
            <i class="fa fa-info-circle"></i>
            RAG status is calculated from remaining KM life as a percentage of rated KM life.
            Only tyres with a rated KM life set are included.
            Green &gt; 50% remaining · Yellow 10–50% · Red &lt; 10%.
        </div>

        <div class="tod-rag-grid">
            <div class="tod-rag-card rag-green">
                <div class="rag-dot">✅</div>
                <div class="rag-info">
                    <div class="rag-count tod-count-animate" data-target="{{ $ragGreen }}">0</div>
                    <div class="rag-label">Green Tyres</div>
                    <div class="rag-sublabel">&gt; 50% life remaining</div>
                </div>
            </div>
            <div class="tod-rag-card rag-yellow">
                <div class="rag-dot">⚠️</div>
                <div class="rag-info">
                    <div class="rag-count tod-count-animate" data-target="{{ $ragYellow }}">0</div>
                    <div class="rag-label">Yellow Tyres</div>
                    <div class="rag-sublabel">10%–50% life remaining</div>
                </div>
            </div>
            <div class="tod-rag-card rag-red">
                <div class="rag-dot">🚨</div>
                <div class="rag-info">
                    <div class="rag-count tod-count-animate" data-target="{{ $ragRed }}">0</div>
                    <div class="rag-label">Red Tyres</div>
                    <div class="rag-sublabel">&lt; 10% life remaining</div>
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════════════════════════════════
             SECTION 3 — ANALYTICS & INSIGHTS
        ══════════════════════════════════════════════════════════════════ --}}
        <h2 class="tod-section-heading">
            <span class="tod-section-icon" style="background:#faf5ff;">📊</span>
            Analytics &amp; Insights
        </h2>

        <div class="tod-analytics-wrap">

            {{-- Vehicle with Highest Maintenance Cost --}}
            <div class="tod-analytics-card">
                <div class="tod-section-heading" style="font-size:13px; border-bottom-color:#f3f4f6;">
                    🚛 Vehicles — Highest Tyre Maintenance Cost
                </div>
                @if(count($vehicleCostMap) > 0)
                <table class="tod-analytics-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Vehicle</th>
                            <th>Repairs</th>
                            <th>Maint.</th>
                            <th>Total Cost</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($vehicleCostMap as $idx => $row)
                        <tr>
                            <td>
                                <span class="rank-badge {{ $idx < 3 ? 'rank-'.($idx+1) : '' }}">{{ $idx+1 }}</span>
                            </td>
                            <td>
                                @if(isset($row['vehicle']) && $row['vehicle'])
                                    <strong>{{ $row['vehicle']->basicinfo->registration_number ?? '—' }}</strong><br>
                                    <small class="text-muted">{{ $row['vehicle']->basicinfo->vehicle_make ?? '' }}</small>
                                @else
                                    <span class="text-muted">Unknown</span>
                                @endif
                            </td>
                            <td class="text-center">{{ $row['repair_count'] }}</td>
                            <td class="text-center">{{ $row['maint_count'] }}</td>
                            <td>
                                <span class="cost-chip">₹{{ number_format($row['total_cost'], 2) }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="text-center text-muted py-4" style="font-size:13px;">
                    <i class="fa fa-inbox fa-2x mb-2 d-block" style="color:#d1d5db;"></i>
                    No vehicle maintenance data for this period.
                </div>
                @endif
            </div>

            {{-- Tyre with Highest Lifetime Spend --}}
            <div class="tod-analytics-card">
                <div class="tod-section-heading" style="font-size:13px; border-bottom-color:#f3f4f6;">
                    🔧 Tyres — Highest Total Spend (Lifetime)
                </div>
                @if($tyreSpendList->count() > 0)
                <table class="tod-analytics-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tyre</th>
                            <th>Status</th>
                            <th>Lifetime Cost</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tyreSpendList as $idx => $row)
                        <tr>
                            <td>
                                <span class="rank-badge {{ $idx < 3 ? 'rank-'.($idx+1) : '' }}">{{ $idx+1 }}</span>
                            </td>
                            <td>
                                <strong>{{ $row['tyre']->tyre_serial_number ?? '—' }}</strong><br>
                                <small class="text-muted">
                                    {{ $row['tyre']->tyre_brand ?? '' }}
                                    {{ $row['tyre']->tyre_model ? '· '.$row['tyre']->tyre_model : '' }}
                                </small>
                            </td>
                            <td>
                                <span class="badge"
                                    style="font-size:9px; background:{{ $row['tyre']->tyre_status === 'Scrap' ? '#fee2e2; color:#991b1b' : ($row['tyre']->tyre_status === 'Warranty Claim' ? '#eff6ff; color:#1d4ed8' : '#f3f4f6; color:#374151') }}">
                                    {{ $row['tyre']->tyre_status ?? $row['tyre']->tyre_condition ?? '—' }}
                                </span>
                            </td>
                            <td>
                                <span class="cost-chip">₹{{ number_format($row['total_lifetime'], 2) }}</span>
                                <div style="font-size:9px; color:#9ca3af; margin-top:2px;">
                                    P:{{ number_format($row['purchase_cost'],0) }}
                                    R:{{ number_format($row['repair_cost'],0) }}
                                    M:{{ number_format($row['maint_cost'],0) }}
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="text-center text-muted py-4" style="font-size:13px;">
                    <i class="fa fa-inbox fa-2x mb-2 d-block" style="color:#d1d5db;"></i>
                    No tyre spend data available.
                </div>
                @endif
            </div>

        </div>{{-- /.tod-analytics-wrap --}}

        {{-- ══════════════════════════════════════════════════════════════════
             SECTION 4 — BUDGET SECTION
        ══════════════════════════════════════════════════════════════════ --}}
        <h2 class="tod-section-heading">
            <span class="tod-section-icon" style="background:#fff7ed;">💰</span>
            Budget Planning
        </h2>

        <div class="tod-budget-grid">

            {{-- Scheduled Maintenance Budget --}}
            <div class="tod-budget-card">
                <div class="bud-title">
                    <i class="fa fa-calendar-alt" style="color:#8b5cf6;"></i>
                    Scheduled Maintenance — Upcoming Budget Estimate
                </div>
                <div class="bud-row">
                    <span class="bud-key">Upcoming Scheduled Items</span>
                    <span class="bud-val">{{ number_format($budgetMaintQty) }} jobs</span>
                </div>
                <div class="bud-row">
                    <span class="bud-key">Avg Cost per Maintenance</span>
                    <span class="bud-val">
                        @if($avgMaintCost > 0)
                            ₹{{ number_format($avgMaintCost, 2) }}
                        @else —
                        @endif
                    </span>
                </div>
                <div class="bud-row">
                    <span class="bud-key">Estimated Budget Required</span>
                    <span class="bud-val {{ $budgetMaintEst > 0 ? 'bud-warning' : '' }}">
                        ₹{{ number_format($budgetMaintEst, 2) }}
                    </span>
                </div>
                @if($budgetMaintQty > 0)
                <div class="tod-info-note mt-2">
                    <i class="fa fa-clock"></i>
                    {{ $budgetMaintQty }} maintenance jobs are scheduled/pending/overdue.
                    Budget estimate is based on average cost of completed jobs.
                </div>
                @endif
            </div>

            {{-- Red Tyre Replacement Budget --}}
            <div class="tod-budget-card">
                <div class="bud-title">
                    <i class="fa fa-exclamation-triangle" style="color:#ef4444;"></i>
                    Red Tyres — Replacement Budget Estimate
                </div>
                <div class="bud-row">
                    <span class="bud-key">Red Tyres (Critical — &lt;10% life)</span>
                    <span class="bud-val {{ $ragRed > 0 ? 'bud-warning' : 'bud-ok' }}">{{ $ragRed }} tyres</span>
                </div>
                <div class="bud-row">
                    <span class="bud-key">Avg Price of New Tyre</span>
                    <span class="bud-val">₹{{ number_format($avgNewTyrePrice, 2) }}</span>
                </div>
                <div class="bud-row">
                    <span class="bud-key">Estimated Replacement Budget</span>
                    <span class="bud-val {{ $ragRed > 0 ? 'bud-warning' : 'bud-ok' }}">
                        ₹{{ number_format($redTyreReplBudget, 2) }}
                    </span>
                </div>
                @if($ragRed > 0)
                <div class="tod-info-note mt-2" style="background:#fff1f2; border-color:#fca5a5; color:#991b1b;">
                    <i class="fa fa-exclamation-circle"></i>
                    {{ $ragRed }} tyre(s) are critically low on life. Replacement recommended immediately.
                </div>
                @else
                <div class="tod-info-note mt-2" style="background:#f0fdf4; border-color:#6ee7b7; color:#065f46;">
                    <i class="fa fa-check-circle"></i>
                    No critical red tyres at this time.
                </div>
                @endif
            </div>

        </div>{{-- /.tod-budget-grid --}}

        {{-- SECTION 5 — PREDICTIVE PLANNING — commented out, re-enable when ready --}}
        @if(false){{-- PREDICTIVE PLANNING START --}}
        <h2 class="tod-section-heading">
            <span class="tod-section-icon" style="background:#fefce8;">🔮</span>
            Predictive Planning — Replacement Forecast
        </h2>
        <div class="tod-info-note">
            <i class="fa fa-info-circle"></i>
            Predicted replacement date is calculated from remaining KM ÷ average daily KM usage (from vehicle assignment history).
            Rows without KM history use a 300 km/day estimate.
            <strong>Red</strong> = replacement within 30 days &nbsp;|&nbsp;
            <strong>Amber</strong> = within 90 days &nbsp;|&nbsp;
            <strong>Green</strong> = &gt; 90 days.
        </div>

        <div class="tod-predict-wrap">
            @if($paginatedPredictions->count() > 0)
            <table class="tod-predict-table">
                <thead>
                    <tr>
                        <th>Status</th>
                        <th>Tyre Serial</th>
                        <th>Brand / Model</th>
                        <th>Vehicle</th>
                        <th>Remaining KM</th>
                        <th>Life Remaining %</th>
                        <th>Avg KM/Day</th>
                        <th>Days to Limit</th>
                        <th>Predicted Date</th>
                        <th>Data Source</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($paginatedPredictions as $pred)
                    @php
                        $rowClass = '';
                        $dotClass = '';
                        if ($pred['pred_rag'] === 'red')   { $rowClass = 'replace-soon';  $dotClass = 'dot-red'; }
                        if ($pred['pred_rag'] === 'amber') { $rowClass = 'replace-amber'; $dotClass = 'dot-amber'; }
                        if ($pred['pred_rag'] === 'green') { $dotClass = 'dot-green'; }

                        $barClass = 'bar-green';
                        if ($pred['remaining_pct'] < 10)  { $barClass = 'bar-red'; }
                        elseif ($pred['remaining_pct'] < 50) { $barClass = 'bar-yellow'; }
                    @endphp
                    <tr class="{{ $rowClass }}">
                        <td>
                            <span class="pred-rag-dot {{ $dotClass }}"></span>
                            <span style="font-size:11px; font-weight:600; text-transform:uppercase; color:#374151;">
                                {{ strtoupper($pred['pred_rag']) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('tyre.show', $pred['tyre']->id) }}"
                               style="color:#032671; font-weight:600; font-size:12px;">
                                {{ $pred['tyre']->tyre_serial_number ?? '—' }}
                            </a>
                        </td>
                        <td style="font-size:11px;">
                            {{ $pred['tyre']->tyre_brand ?? '—' }}
                            {{ $pred['tyre']->tyre_model ? ' / '.$pred['tyre']->tyre_model : '' }}
                        </td>
                        <td style="font-size:11px;">
                            {{ optional(optional($pred['tyre']->allocatedVehicle)->basicinfo)->registration_number ?? '—' }}
                        </td>
                        <td>
                            <strong>{{ number_format($pred['remaining_km']) }}</strong>
                            <span style="font-size:10px; color:#9ca3af;"> km</span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <span style="font-size:12px; font-weight:700; min-width:38px;">
                                    {{ $pred['remaining_pct'] }}%
                                </span>
                                <div class="km-bar-wrap" style="flex:1;">
                                    <div class="km-bar-fill {{ $barClass }}"
                                         data-pct="{{ $pred['remaining_pct'] }}"
                                         style="width:0%;">
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td style="font-size:12px;">
                            {{ number_format($pred['avg_daily_km'], 1) }} km/day
                        </td>
                        <td>
                            @if($pred['days_to_limit'] !== null)
                                <strong>{{ number_format($pred['days_to_limit']) }}</strong>
                                <span style="font-size:10px; color:#9ca3af;"> days</span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>
                            @if($pred['predicted_date'])
                                <span style="font-size:12px; font-weight:600;
                                    color:{{ $pred['pred_rag'] === 'red' ? '#dc2626' : ($pred['pred_rag'] === 'amber' ? '#d97706' : '#059669') }}">
                                    {{ \Carbon\Carbon::parse($pred['predicted_date'])->format('d M Y') }}
                                </span>
                            @else
                                <span class="text-muted" style="font-size:11px;">Insufficient data</span>
                            @endif
                        </td>
                        <td>
                            @if($pred['has_history'])
                                <span class="badge" style="background:#dcfce7; color:#166534; font-size:9px; padding:4px 7px;">
                                    <i class="fa fa-check-circle me-1"></i>Actual
                                </span>
                            @else
                                <span class="badge" style="background:#fef3c7; color:#92400e; font-size:9px; padding:4px 7px;"
                                      data-bs-toggle="tooltip" title="No assignment history — using 300 km/day estimate">
                                    <i class="fa fa-exclamation-triangle me-1"></i>Estimate
                                </span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Bootstrap Pagination --}}
            <div class="d-flex justify-content-between align-items-center mt-3 px-1">
                <small class="text-muted">
                    Showing {{ $paginatedPredictions->firstItem() }}–{{ $paginatedPredictions->lastItem() }}
                    of {{ $paginatedPredictions->total() }} tyre{{ $paginatedPredictions->total() !== 1 ? 's' : '' }}
                </small>
                <div>
                    {!! $paginatedPredictions->appends(request()->except('pred_page'))->links('pagination::bootstrap-5') !!}
                </div>
            </div>

            @else
            <div class="text-center text-muted py-5" style="font-size:13px;">
                <i class="fa fa-truck fa-2x mb-3 d-block" style="color:#d1d5db;"></i>
                No tyres currently fitted to vehicles with a rated KM life set.<br>
                <small>Set <strong>Fixed Run KM</strong> on tyres to enable predictive planning.</small>
            </div>
            @endif
        </div>
        @endif{{-- PREDICTIVE PLANNING END --}}

        </div>{{-- /.container-fluid --}}
        </div>{{-- /.itemvehicles-bd --}}

    </div>{{-- /.dashboard-bd --}}
</div>{{-- /.layout-wrapper --}}
@endsection

@section('js')
<script src="{{ asset('js/tyre/owner-dashboard.js?v=1.0') }}"></script>
@endsection
