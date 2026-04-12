@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/Fleet/compliance-permit-fitness.css') }}">
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
                            <h6 class="mb-0">Permit & Fitness Tracker</h6>
                            <p class="text-muted mb-0" style="font-size:12px;">Route Permit · National Permit · Fitness Certificate (FC)</p>
                        </div>
                        <div class="col-auto d-flex gap-2 flex-wrap">
                            <input type="text" id="searchInput" value="{{ request('search') }}"
                                class="form-control form-control-sm" placeholder="Vehicle / Permit No…" style="width:200px;">
                            @if($permitTypes->isNotEmpty())
                            <select id="permitTypeFilter" class="form-select form-select-sm" style="width:160px;">
                                <option value="">All Permit Types</option>
                                @foreach($permitTypes as $pt)
                                <option value="{{ $pt }}" {{ request('permit_type')==$pt ? 'selected':'' }}>{{ $pt }}</option>
                                @endforeach
                            </select>
                            @endif
                            <select id="statusFilter" class="form-select form-select-sm" style="width:160px;">
                                <option value="">All Statuses</option>
                                <option value="expired"  {{ request('status_filter')=='expired'  ? 'selected':'' }}>Has Expired</option>
                                <option value="expiring" {{ request('status_filter')=='expiring' ? 'selected':'' }}>Expiring (30d)</option>
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
                            <div class="stat-card red shadow-sm">
                                <div class="num" style="color:#c0392b">{{ $stats['permit_expired'] }}</div>
                                <div class="lbl">Permit Expired</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="stat-card amber shadow-sm">
                                <div class="num" style="color:#e67e22">{{ $stats['permit_expiring'] }}</div>
                                <div class="lbl">Permit Expiring (30d)</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="stat-card red shadow-sm">
                                <div class="num" style="color:#c0392b">{{ $stats['fitness_expired'] }}</div>
                                <div class="lbl">FC Expired</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="stat-card amber shadow-sm">
                                <div class="num" style="color:#e67e22">{{ $stats['fitness_expiring'] }}</div>
                                <div class="lbl">FC Expiring (30d)</div>
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
                                    <th>Permit Type</th>
                                    <th>Permit No.</th>
                                    <th>Permit Expiry</th>
                                    <th>Nat. Permit Expiry</th>
                                    <th>Fitness (FC) Expiry</th>
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
                                    <td style="font-size:12px;color:#555;">{{ $r['vehicle']->vehicletype?->name ?? '—' }}</td>
                                    <td>
                                        @if($r['permit_type'])
                                            <span class="badge bg-light text-dark border" style="font-size:11px;">{{ $r['permit_type'] }}</span>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td style="font-family:monospace;font-size:12px;color:#555;">
                                        {{ $r['permit_no'] ?? '—' }}
                                    </td>

                                    {{-- Permit Expiry --}}
                                    <td>
                                        @if($r['permit'])
                                            <span class="exp-chip chip-{{ $r['permit']['chip'] }}">{{ $r['permit']['date'] }}</span>
                                            @if($r['permit']['days'] < 0)
                                                <br><span style="font-size:10px;color:#c0392b;">{{ abs($r['permit']['days']) }}d overdue</span>
                                            @elseif($r['permit']['days'] <= 90)
                                                <br><span style="font-size:10px;color:#888;">{{ $r['permit']['days'] }}d left</span>
                                            @endif
                                        @else
                                            <span class="exp-chip chip-grey">—</span>
                                        @endif
                                    </td>

                                    {{-- National Permit Expiry --}}
                                    <td>
                                        @if($r['nat_permit'])
                                            <span class="exp-chip chip-{{ $r['nat_permit']['chip'] }}">{{ $r['nat_permit']['date'] }}</span>
                                            @if($r['nat_permit']['days'] < 0)
                                                <br><span style="font-size:10px;color:#c0392b;">{{ abs($r['nat_permit']['days']) }}d overdue</span>
                                            @elseif($r['nat_permit']['days'] <= 90)
                                                <br><span style="font-size:10px;color:#888;">{{ $r['nat_permit']['days'] }}d left</span>
                                            @endif
                                        @else
                                            <span class="exp-chip chip-grey">—</span>
                                        @endif
                                    </td>

                                    {{-- Fitness Expiry --}}
                                    <td>
                                        @if($r['fitness'])
                                            <span class="exp-chip chip-{{ $r['fitness']['chip'] }}">{{ $r['fitness']['date'] }}</span>
                                            @if($r['fitness']['days'] < 0)
                                                <br><span style="font-size:10px;color:#c0392b;">{{ abs($r['fitness']['days']) }}d overdue</span>
                                            @elseif($r['fitness']['days'] <= 90)
                                                <br><span style="font-size:10px;color:#888;">{{ $r['fitness']['days'] }}d left</span>
                                            @endif
                                        @else
                                            <span class="exp-chip chip-grey">—</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4 text-muted">No permit/fitness records found.</td>
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
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
(function () {
    var baseUrl = '{{ route('fleet.compliance.permit-fitness') }}';

    function applyFilters() {
        var params = new URLSearchParams();
        var s  = document.getElementById('searchInput').value.trim();
        var sf = document.getElementById('statusFilter').value;
        var ptEl = document.getElementById('permitTypeFilter');
        if (s)  params.set('search', s);
        if (sf) params.set('status_filter', sf);
        if (ptEl && ptEl.value) params.set('permit_type', ptEl.value);
        window.location = baseUrl + (params.toString() ? '?' + params.toString() : '');
    }

    window.resetFilters = function () { window.location = baseUrl; };

    document.getElementById('statusFilter').addEventListener('change', applyFilters);
    var ptEl = document.getElementById('permitTypeFilter');
    if (ptEl) ptEl.addEventListener('change', applyFilters);
    document.getElementById('searchInput').addEventListener('keydown', function (e) {
        if (e.key === 'Enter') applyFilters();
    });
})();
</script>
@endsection
