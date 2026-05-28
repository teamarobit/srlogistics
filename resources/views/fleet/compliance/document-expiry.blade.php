@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/fleet/compliance-document-expiry.css?v=1.1') }}">
@endsection

@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="wrapper srlog-bdwrapper">


        <div class="main-wrap" style="margin-left:0;width:100%;">

                {{-- Page Head --}}
                <div class="container-fluid page-head">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="mb-0">Vehicle Document Expiry</h6>
                            <p class="text-muted mb-0" style="font-size:12px;">Insurance · Fitness · Permit · PUCC · Road Tax</p>
                        </div>
                        <div class="col-auto d-flex gap-2 flex-wrap">
                            <div class="input-group input-group-sm" style="width:220px;">
                                <input type="text" id="searchInput" value="{{ request('search') }}"
                                    class="form-control form-control-sm" placeholder="Search vehicle (Enter)…">
                                <button type="button" id="searchBtn" class="btn btn-outline-secondary" title="Search">
                                    <i class="uil uil-search"></i>
                                </button>
                            </div>
                            <select id="docTypeFilter" class="form-select form-select-sm" style="width:150px;">
                                <option value="">All Doc Types</option>
                                <option value="insurance" {{ request('doc_type')=='insurance' ? 'selected':'' }}>Insurance</option>
                                <option value="fitness"   {{ request('doc_type')=='fitness'   ? 'selected':'' }}>Fitness (FC)</option>
                                <option value="permit"    {{ request('doc_type')=='permit'     ? 'selected':'' }}>Permit</option>
                                <option value="pucc"      {{ request('doc_type')=='pucc'       ? 'selected':'' }}>PUCC</option>
                                <option value="tax"       {{ request('doc_type')=='tax'        ? 'selected':'' }}>Road Tax</option>
                            </select>
                            <select id="expiryFilter" class="form-select form-select-sm" style="width:155px;">
                                <option value="">All Expiry</option>
                                <option value="expired"  {{ request('expiry_filter')=='expired'  ? 'selected':'' }}>Has Expired Doc</option>
                                <option value="expiring" {{ request('expiry_filter')=='expiring' ? 'selected':'' }}>Expiring in 30d</option>
                            </select>
                            <button type="button" id="resetBtn" class="btn btn-outline-secondary btn-sm">
                                <i class="uil uil-history"></i> Reset
                            </button>
                        </div>
                    </div>
                </div>

                <div class="container-fluid mt-3">

                    {{-- Stat Cards --}}
                    <div class="row g-3 mb-4">
                        <div class="col-6 col-md-4">
                            <div class="stat-card blue shadow-sm">
                                <div class="num text-primary">{{ $stats['total'] }}</div>
                                <div class="lbl">Active Vehicles</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="stat-card red shadow-sm">
                                <div class="num" style="color:#c0392b">{{ $stats['expired'] }}</div>
                                <div class="lbl">Expired Document(s)</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="stat-card amber shadow-sm">
                                <div class="num" style="color:#e67e22">{{ $stats['expiring'] }}</div>
                                <div class="lbl">Expiring in 30 days</div>
                            </div>
                        </div>
                    </div>

                    {{-- Legend (visual key only — not interactive) --}}
                    <div class="legend-row d-flex align-items-center gap-2 mb-3 flex-wrap" style="font-size:12px;">
                        <span class="legend-label text-muted">Legend:</span>
                        <span class="exp-chip chip-expired legend-chip">Expired</span>
                        <span class="exp-chip chip-expiring legend-chip">Expiring ≤ 30d</span>
                        <span class="exp-chip chip-warning legend-chip">Due ≤ 90d</span>
                        <span class="exp-chip chip-ok legend-chip">Valid</span>
                        <span class="exp-chip chip-grey legend-chip">No Data</span>
                    </div>

                    {{-- Table --}}
                    <div class="table-responsive">
                        <table class="table table-hover sc-table mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Vehicle No.</th>
                                    <th>Type</th>
                                    <th class="doc-cell">Insurance</th>
                                    <th class="doc-cell">Fitness (FC)</th>
                                    <th class="doc-cell">Permit</th>
                                    <th class="doc-cell">PUCC</th>
                                    <th class="doc-cell">Road Tax</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($rows as $r)
                                <tr>
                                    <td class="text-muted" style="font-size:11px;">{{ ($vehicles->currentPage()-1)*$vehicles->perPage() + $loop->iteration }}</td>
                                    <td class="fw-semibold">
                                        <a href="{{ route('fleetdashboard.getVehicleDetailsV2', $r['vehicle']->id) }}" class="text-decoration-none">
                                            {{ $r['vehicle']->vehicle_no }}
                                        </a>
                                    </td>
                                    <td style="color:#555;">{{ $r['vehicle']->vehicletype?->name ?? '—' }}</td>

                                    @foreach(['insurance','fitness','permit','pucc','tax'] as $doc)
                                    @php $d = $r[$doc]; @endphp
                                    <td class="doc-cell">
                                        @if($d)
                                            <span class="exp-chip chip-{{ $d['chip'] }}">{{ $d['date'] }}</span>
                                            @if($d['days'] < 0)
                                                <br><span style="font-size:10px;color:#c0392b;">{{ abs($d['days']) }}d overdue</span>
                                            @elseif($d['days'] <= 90)
                                                <br><span style="font-size:10px;color:#888;">{{ $d['days'] }}d left</span>
                                            @endif
                                        @else
                                            <span class="exp-chip chip-grey">—</span>
                                        @endif
                                    </td>
                                    @endforeach
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4 text-muted">No vehicles found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="d-flex justify-content-between align-items-center mt-3 px-1">
                        <small class="text-muted">{{ $vehicles->total() }} vehicle{{ $vehicles->total() !== 1 ? 's' : '' }}</small>
                        <div>{{ $vehicles->links() }}</div>
                    </div>

                    {{-- Data attrs for external JS (SD-1) --}}
                    <div id="deUrls" data-base-url="{{ route('fleet.compliance.document-expiry') }}" hidden></div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('js/Fleet/compliance-document-expiry.js?v=1.1') }}"></script>
@endsection
