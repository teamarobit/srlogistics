@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/Fleet/compliance-policy-renewal.css') }}">
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
                            <h6 class="mb-0">Policy Renewal Tracker</h6>
                            <p class="text-muted mb-0" style="font-size:12px;">Insurance policy expiry for all active vehicles</p>
                        </div>
                        <div class="col-auto d-flex gap-2 flex-wrap">
                            <input type="text" id="searchInput" name="search" value="{{ request('search') }}"
                                class="form-control form-control-sm" placeholder="Vehicle / Insurer / Policy No…" style="width:220px;">
                            <select id="statusFilter" name="status_filter" class="form-select form-select-sm" style="width:160px;">
                                <option value="">All Statuses</option>
                                <option value="expired"  {{ request('status_filter')=='expired'  ? 'selected':'' }}>Expired</option>
                                <option value="expiring" {{ request('status_filter')=='expiring' ? 'selected':'' }}>Expiring (30d)</option>
                                <option value="ok"       {{ request('status_filter')=='ok'       ? 'selected':'' }}>OK</option>
                            </select>
                            <button class="btn btn-outline-secondary btn-sm" onclick="resetFilters()">
                                <i class="uil uil-history"></i> Reset
                            </button>
                        </div>
                    </div>
                </div>

                <div class="container-fluid mt-3">

                    {{-- Stat Cards --}}
                    <div class="row g-3 mb-4">
                        <div class="col-6 col-md-3">
                            <div class="stat-card blue shadow-sm">
                                <div class="num text-primary">{{ $stats['total'] }}</div>
                                <div class="lbl">Total Insured</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="stat-card red shadow-sm">
                                <div class="num" style="color:#c0392b">{{ $stats['expired'] }}</div>
                                <div class="lbl">Expired</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="stat-card amber shadow-sm">
                                <div class="num" style="color:#e67e22">{{ $stats['expiring'] }}</div>
                                <div class="lbl">Expiring in 30 days</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="stat-card green shadow-sm">
                                <div class="num" style="color:#1a7f45">{{ $stats['ok'] }}</div>
                                <div class="lbl">Valid</div>
                            </div>
                        </div>
                    </div>

                    {{-- Table --}}
                    <div class="table-responsive">
                        <table class="table table-hover sc-table mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Vehicle No.</th>
                                    <th>Type</th>
                                    <th>Insurer</th>
                                    <th>Policy No.</th>
                                    <th>Expiry Date</th>
                                    <th>Days Left</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($rows as $i => $r)
                                @php
                                    $chipClass = match($r['chip']) {
                                        'expired'  => 'chip-expired',
                                        'expiring' => 'chip-expiring',
                                        'ok'       => 'chip-ok',
                                        default    => 'chip-grey',
                                    };
                                    $chipLabel = match($r['chip']) {
                                        'expired'  => 'Expired',
                                        'expiring' => 'Expiring Soon',
                                        'ok'       => 'Valid',
                                        default    => 'No Data',
                                    };
                                @endphp
                                <tr>
                                    <td class="text-muted" style="font-size:11px;">{{ ($vehicles->currentPage()-1)*$vehicles->perPage() + $loop->iteration }}</td>
                                    <td class="fw-semibold">
                                        <a href="{{ route('fleetdashboard.getVehicleDetailsV2', $r['vehicle']->id) }}" class="text-decoration-none">
                                            {{ $r['vehicle']->vehicle_no }}
                                        </a>
                                    </td>
                                    <td style="font-size:12px;color:#555;">{{ $r['vehicle']->vehicletype?->name ?? '—' }}</td>
                                    <td>{{ $r['vehicle']->basicinfo?->insurer ?? '—' }}</td>
                                    <td style="font-family:monospace;font-size:12px;">{{ $r['vehicle']->basicinfo?->insurance_no ?? '—' }}</td>
                                    <td>{{ $r['exp'] ? $r['exp']->format('d-m-Y') : '—' }}</td>
                                    <td class="text-center">
                                        @if(!is_null($r['days_left']))
                                            @if($r['days_left'] < 0)
                                                <span style="color:#c0392b;font-weight:600;">{{ abs($r['days_left']) }}d overdue</span>
                                            @else
                                                {{ $r['days_left'] }}d
                                            @endif
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td><span class="exp-chip {{ $chipClass }}">{{ $chipLabel }}</span></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4 text-muted">No insurance records found.</td>
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
                </div>

            </div>{{-- /main-wrap --}}
    </div>
</div>
@endsection

@section('js')
<script>
(function () {
    var baseUrl = '{{ route('fleet.compliance.policy-renewal') }}';

    function applyFilters() {
        var params = new URLSearchParams();
        var s = document.getElementById('searchInput').value.trim();
        var f = document.getElementById('statusFilter').value;
        if (s) params.set('search', s);
        if (f) params.set('status_filter', f);
        window.location = baseUrl + (params.toString() ? '?' + params.toString() : '');
    }

    window.resetFilters = function () { window.location = baseUrl; };

    document.getElementById('statusFilter').addEventListener('change', applyFilters);
    document.getElementById('searchInput').addEventListener('keydown', function (e) {
        if (e.key === 'Enter') applyFilters();
    });
})();
</script>
@endsection
