@extends('layouts.app')

@section('css')
<link href="{{ asset('css/fleet/driver-dashboard.css') }}?v={{ uniqid() }}" rel="stylesheet">
@endsection

@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="srlog-bdwrapper fdr-wrap">

        {{-- ── Page Header ─────────────────────────────── --}}
        <div class="fdr-page-head">
            <div>
                <span class="fdr-page-title"><i class="uil uil-user-square me-2"></i>Drivers</span>
                <span class="fdr-page-sub">Fleet driver management &amp; tracking</span>
            </div>
            <div style="display:flex;gap:8px;">
                <a href="{{ route('contact.driver.create') }}"
                   class="btn btn-sm"
                   style="font-size:12px;font-weight:600;background:#032671;color:#fff;border:none;padding:6px 16px;border-radius:6px;">
                    <i class="uil uil-plus me-1"></i>Add Driver
                </a>
                <a href="{{ route('contact.driver.index') }}"
                   class="btn btn-sm"
                   style="font-size:12px;font-weight:600;background:#f1f5f9;color:#475569;border:1px solid #e2e8f0;padding:6px 16px;border-radius:6px;">
                    <i class="uil uil-list-ul me-1"></i>Master List
                </a>
            </div>
        </div>

        {{-- ── Stats Cards ─────────────────────────────── --}}
        <div class="fdr-stats">
            @php
                $allCount         = $stats['all']         ?? 0;
                $activeCount      = $stats['active']      ?? 0;
                $inactiveCount    = $stats['inactive']    ?? 0;
                $blacklistedCount = $stats['blacklisted'] ?? 0;
                $onLeaveCount     = $stats['on_leave']    ?? 0;
            @endphp

            <a href="{{ route('fleetdashboard.drivers') }}" class="fdr-stat-card all">
                <div class="fdr-stat-lbl">All Drivers</div>
                <div class="fdr-stat-num">{{ $allCount }}</div>
            </a>
            <a href="{{ route('fleetdashboard.drivers', ['status' => 'Active']) }}" class="fdr-stat-card active">
                <div class="fdr-stat-lbl">Active</div>
                <div class="fdr-stat-num">{{ $activeCount }}</div>
            </a>
            <a href="{{ route('fleetdashboard.drivers', ['status' => 'Inactive']) }}" class="fdr-stat-card inactive">
                <div class="fdr-stat-lbl">Inactive</div>
                <div class="fdr-stat-num">{{ $inactiveCount }}</div>
            </a>
            <a href="{{ route('fleetdashboard.drivers', ['status' => 'Blacklisted']) }}" class="fdr-stat-card blacklisted">
                <div class="fdr-stat-lbl">Blacklisted</div>
                <div class="fdr-stat-num">{{ $blacklistedCount }}</div>
            </a>
            <a href="{{ route('fleetdashboard.drivers', ['status' => 'On Leave']) }}" class="fdr-stat-card onleave">
                <div class="fdr-stat-lbl">On Leave</div>
                <div class="fdr-stat-num">{{ $onLeaveCount }}</div>
            </a>
        </div>

        {{-- ── Filter Bar ───────────────────────────────── --}}
        <form action="{{ route('fleetdashboard.drivers') }}" method="GET" id="driverFilterForm">
        <div class="fdr-filter">
            <span class="fdr-filter-label"><i class="uil uil-filter me-1"></i>Filter</span>

            <input type="text" name="name" value="{{ request('name') }}"
                   class="form-control" style="width:150px;"
                   placeholder="Search by Name">

            <input type="text" name="licence_no" value="{{ request('licence_no') }}"
                   class="form-control" style="width:170px;"
                   placeholder="Search by DL Number">

            <select name="status" class="form-select" style="width:130px;" onchange="document.getElementById('driverFilterForm').submit()">
                <option value="">All Status</option>
                <option value="Active"      {{ request('status') === 'Active'      ? 'selected' : '' }}>Active</option>
                <option value="Inactive"    {{ request('status') === 'Inactive'    ? 'selected' : '' }}>Inactive</option>
                <option value="Blacklisted" {{ request('status') === 'Blacklisted' ? 'selected' : '' }}>Blacklisted</option>
                <option value="On Leave"    {{ request('status') === 'On Leave'    ? 'selected' : '' }}>On Leave</option>
            </select>

            <select name="rag" class="form-select" style="width:130px;" onchange="document.getElementById('driverFilterForm').submit()">
                <option value="">RAG Status</option>
                <option value="Green"  {{ request('rag') === 'Green'  ? 'selected' : '' }}>Green</option>
                <option value="Yellow" {{ request('rag') === 'Yellow' ? 'selected' : '' }}>Yellow</option>
                <option value="Red"    {{ request('rag') === 'Red'    ? 'selected' : '' }}>Red</option>
            </select>

            <select name="category" class="form-select" style="width:130px;" onchange="document.getElementById('driverFilterForm').submit()">
                <option value="">Category</option>
                <option value="Line"  {{ request('category') === 'Line'  ? 'selected' : '' }}>Line</option>
                <option value="Local" {{ request('category') === 'Local' ? 'selected' : '' }}>Local</option>
            </select>

            <select name="lic_expiry" class="form-select" style="width:160px;" onchange="document.getElementById('driverFilterForm').submit()">
                <option value="">Licence Expiry</option>
                <option value="expired"  {{ request('lic_expiry') === 'expired'  ? 'selected' : '' }}>Expired</option>
                <option value="expiring" {{ request('lic_expiry') === 'expiring' ? 'selected' : '' }}>Expiring in 30 days</option>
                <option value="ok"       {{ request('lic_expiry') === 'ok'       ? 'selected' : '' }}>Valid (>30 days)</option>
            </select>

            <button type="submit" class="btn btn-sm btn-primary" style="font-size:12px;height:34px;padding:0 14px;">
                <i class="uil uil-search me-1"></i>Search
            </button>
            <a href="{{ route('fleetdashboard.drivers') }}"
               class="btn btn-sm" style="font-size:12px;height:34px;padding:0 12px;background:#f1f5f9;color:#475569;border:1px solid #e2e8f0;">
                <i class="uil uil-sync me-1"></i>Reset
            </a>
            <div class="dropdown ms-1">
                <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        style="font-size:12px;height:34px;padding:0 12px;">
                    Export <i class="uil uil-upload ms-1"></i>
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="javascript:void(0)"><i class="uil uil-file-alt me-1"></i>Excel</a></li>
                    <li><a class="dropdown-item" href="javascript:void(0)"><i class="uil uil-file-pdf-alt me-1"></i>PDF</a></li>
                </ul>
            </div>
        </div>
        </form>

        {{-- ── Driver Table ─────────────────────────────── --}}
        <div class="fdr-table-wrap">

            {{-- Result count --}}
            <div style="font-size:12px;color:#94a3b8;margin-bottom:10px;">
                Showing <strong style="color:#1e293b;">{{ $drivers->total() }}</strong> driver{{ $drivers->total() !== 1 ? 's' : '' }}
                @if(request()->hasAny(['name','licence_no','status','rag','category','lic_expiry']))
                    — <a href="{{ route('fleetdashboard.drivers') }}" style="color:#032671;font-weight:600;">Clear filters</a>
                @endif
            </div>

            <div class="fdr-table-card">
                @if($drivers->count())
                <div class="table-responsive">
                    <table class="fdr-table">
                        <thead>
                            <tr>
                                <th>Driver</th>
                                <th>Current Vehicle</th>
                                <th>Category</th>
                                <th>Licence No.</th>
                                <th>Licence Expiry</th>
                                <th>Blood Group</th>
                                <th>RAG</th>
                                <th>Status</th>
                                <th>Associated Since</th>
                                <th style="text-align:center;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($drivers as $contact)
                            @php
                                /* ── Licence expiry health ── */
                                $licExp   = optional($contact->driverinfo)->licence_expiry_date;
                                $licDays  = $licExp ? (int) now()->diffInDays(\Carbon\Carbon::parse($licExp), false) : null;
                                $licClass = $licDays === null ? 'lic-none'
                                          : ($licDays < 0    ? 'lic-danger'
                                          : ($licDays <= 30  ? 'lic-danger'
                                          : ($licDays <= 90  ? 'lic-warn' : 'lic-ok')));

                                /* ── Associated since ── */
                                $assocSince = '';
                                if (!empty($contact->doj)) {
                                    $doj   = new DateTime($contact->doj);
                                    $today = new DateTime();
                                    if ($doj <= $today) {
                                        $diff = $today->diff($doj);
                                        $assocSince = $diff->y . 'y ' . $diff->m . 'm ' . $diff->d . 'd';
                                    }
                                }

                                /* ── Status CSS class ── */
                                $statusClass = match($contact->status ?? '') {
                                    'Active'      => 'active',
                                    'Inactive'    => 'inactive',
                                    'Blacklisted' => 'blacklisted',
                                    'On Leave'    => 'on-leave',
                                    default       => 'inactive',
                                };

                                /* ── RAG badge class ── */
                                $ragClass = match($contact->rag_status ?? '') {
                                    'Green'  => 'rag-green',
                                    'Yellow' => 'rag-yellow',
                                    'Red'    => 'rag-red',
                                    default  => 'rag-grey',
                                };

                                /* ── Driver initials ── */
                                $nameParts = explode(' ', $contact->contact_name ?? 'D');
                                $initials  = strtoupper(substr($nameParts[0], 0, 1) . (isset($nameParts[1]) ? substr($nameParts[1], 0, 1) : ''));

                                /* ── Photo ── */
                                $photo = $contact->photo ?? null;
                            @endphp
                            <tr>
                                {{-- Driver name + phone --}}
                                <td>
                                    <div class="fdr-name-wrap">
                                        <div class="fdr-avatar">
                                            @if($photo)
                                                <img src="{{ asset('medias/contacts/' . $photo) }}" alt="{{ $contact->contact_name }}">
                                            @else
                                                <span class="fdr-avatar-initials">{{ $initials }}</span>
                                            @endif
                                        </div>
                                        <div>
                                            <a href="{{ route('fleetdashboard.getDriverDetails', $contact->id) }}" class="fdr-name">
                                                {{ $contact->contact_name ?? '—' }}
                                            </a>
                                            <div class="fdr-phone">+{{ $contact->ph_prefix ?? '91' }} {{ $contact->phone ?? '' }}</div>
                                        </div>
                                    </div>
                                </td>

                                {{-- Current vehicle --}}
                                <td>
                                    @php $alloc = $contact->currentVehicleAllocation; @endphp
                                    @if($alloc && $alloc->vehicle)
                                        <a href="{{ route('fleetdashboard.getVehicleDetailsV2', $alloc->vehicle->id) }}"
                                           style="font-size:12px;font-weight:700;color:#032671;font-family:monospace;text-decoration:none;">
                                            {{ $alloc->vehicle->vehicle_no }}
                                        </a>
                                        <div style="font-size:10px;color:#94a3b8;">{{ $alloc->vehicle->vehicletype->name ?? '' }}</div>
                                    @else
                                        <span style="color:#94a3b8;font-size:12px;">—</span>
                                    @endif
                                </td>

                                {{-- Category --}}
                                <td>
                                    @php $cat = optional($contact->driverinfo)->category; @endphp
                                    @if($cat)
                                        <span class="cat-chip {{ strtolower($cat) }}">{{ $cat }}</span>
                                    @else
                                        <span style="color:#94a3b8;font-size:12px;">—</span>
                                    @endif
                                </td>

                                {{-- Licence No --}}
                                <td style="font-size:11px;font-family:monospace;color:#475569;">
                                    {{ optional($contact->driverinfo)->driving_licence_no ?? '—' }}
                                </td>

                                {{-- Licence expiry --}}
                                <td>
                                    @if($licExp)
                                        <span class="{{ $licClass }}">
                                            {{ \Carbon\Carbon::parse($licExp)->format('d M Y') }}
                                        </span>
                                        @if($licDays !== null && $licDays >= 0 && $licDays <= 90)
                                            <div style="font-size:10px;color:#b45309;">{{ $licDays }} days left</div>
                                        @elseif($licDays !== null && $licDays < 0)
                                            <div style="font-size:10px;color:#dc2626;">{{ abs($licDays) }} days overdue</div>
                                        @endif
                                    @else
                                        <span class="lic-none">—</span>
                                    @endif
                                </td>

                                {{-- Blood Group --}}
                                <td style="font-size:12px;color:#475569;">
                                    {{ $contact->blood_group ?? '—' }}
                                </td>

                                {{-- RAG --}}
                                <td>
                                    <span class="rag-badge {{ $ragClass }}">
                                        {{ $contact->rag_status ?? '—' }}
                                    </span>
                                </td>

                                {{-- Status --}}
                                <td>
                                    <span class="drv-status {{ $statusClass }}">{{ $contact->status ?? 'Unknown' }}</span>
                                </td>

                                {{-- Associated since --}}
                                <td style="font-size:12px;color:#64748b;">
                                    {{ $assocSince ?: '—' }}
                                </td>

                                {{-- Actions --}}
                                <td>
                                    <div class="fdr-actions">
                                        <a href="{{ route('fleetdashboard.getDriverDetails', $contact->id) }}"
                                           class="fdr-action-btn" title="View Details">
                                            <i class="uil uil-eye"></i>
                                        </a>
                                        <a href="{{ route('contact.driver.edit', $contact->id) }}"
                                           class="fdr-action-btn" title="Edit Driver">
                                            <i class="uil uil-pen"></i>
                                        </a>
                                        <a href="{{ route('contact.driver.joining.letter', $contact->id) }}"
                                           class="fdr-action-btn" title="Joining Letter" target="_blank">
                                            <i class="uil uil-file-check-alt"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="fdr-empty">
                    <i class="uil uil-user-square"></i>
                    <p>No drivers found</p>
                    <span>
                        @if(request()->hasAny(['name','licence_no','status','rag','category','lic_expiry']))
                            No drivers match the current filters.
                            <a href="{{ route('fleetdashboard.drivers') }}" style="color:#032671;font-weight:600;">Clear filters</a>
                        @else
                            Add your first driver from the master data console.
                        @endif
                    </span>
                </div>
                @endif
            </div>

            {{-- Pagination --}}
            @if($drivers->total() > $drivers->perPage())
            <div class="mt-3">
                {{ $drivers->appends(request()->only(['name','licence_no','status','rag','category','lic_expiry']))->links('pagination::bootstrap-5') }}
            </div>
            @endif

        </div>

    </div>
</div>
@endsection

@section('js')
<script>
/* ── Auto-submit filter form on Enter in text inputs ── */
['name', 'licence_no'].forEach(function(fieldName) {
    document.getElementById('driverFilterForm').querySelector('input[name="' + fieldName + '"]')
        ?.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                document.getElementById('driverFilterForm').submit();
            }
        });
});
</script>
@endsection
