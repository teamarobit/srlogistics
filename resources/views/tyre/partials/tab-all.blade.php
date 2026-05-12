{{-- Tab 1: All Tyres — 17 columns --}}
<div class="table-responsive">
<table class="table custom-driver-table tyre-sortable-table" data-tab="1">
    <thead>
        <tr>
            <th class="sortable" data-col="tyre_serial_number">Serial Number <span class="sort-icon">⇅</span></th>
            <th class="sortable" data-col="location">Tyre Location <span class="sort-icon">⇅</span></th>
            <th>Tyre Status</th>
            <th class="sortable" data-col="tyre_type">Type <span class="sort-icon">⇅</span></th>
            <th class="sortable" data-col="tyre_condition">Condition <span class="sort-icon">⇅</span></th>
            <th>RAG / Life %</th>
            <th>KM Remaining</th>
            <th>Warranty Remaining</th>
            <th class="sortable" data-col="tyre_brand">Brand <span class="sort-icon">⇅</span></th>
            <th class="sortable" data-col="tyre_model">Model <span class="sort-icon">⇅</span></th>
            <th>Vendor</th>
            <th class="sortable" data-col="tyre_price">Price <span class="sort-icon">⇅</span></th>
            <th>Status Since</th>
            <th>Maint. Type</th>
            <th>Maint. Status</th>
            <th>Tracking Group</th>
            <th class="text-center">Image</th>
        </tr>
    </thead>
    <tbody>
        @forelse($all_tyres as $tyre)
            @php
                $li          = getTyreLifeInfo($tyre->id);
                $kmRemaining = ($tyre->fixed_run_km && $tyre->actual_run_km !== null)
                                ? max(0, $tyre->fixed_run_km - $tyre->actual_run_km) : null;
                $warrantyDays = null;
                $warrantyLabel = 'N/A';
                if ($tyre->tyre_warrenty_end_date) {
                    $wDays = (int) now()->diffInDays($tyre->tyre_warrenty_end_date, false);
                    if ($wDays > 0) {
                        $warrantyLabel = $wDays > 30
                            ? round($wDays / 30) . ' mo'
                            : $wDays . ' d';
                    } else {
                        $warrantyLabel = '<span class="badge bg-danger">Expired</span>';
                    }
                }
                // Status Since
                $sinceDate  = null;
                $sinceLabel = '—';
                if ($tyre->tyre_status === 'Warranty Claim' && $tyre->warranty_claim_date) { $sinceDate = $tyre->warranty_claim_date; }
                elseif ($tyre->tyre_status === 'Re-threading' && $tyre->rethreading_sent_date) { $sinceDate = $tyre->rethreading_sent_date; }
                elseif (in_array($tyre->tyre_status, ['Scrap']) && $tyre->scrap_sent_date) { $sinceDate = $tyre->scrap_sent_date; }
                elseif ($tyre->location === 'Vehicle' && $tyre->installation_date) { $sinceDate = $tyre->installation_date; }
                if ($sinceDate) {
                    $cs = \Carbon\Carbon::parse($sinceDate);
                    $ty = (int) $cs->diffInYears(now());
                    $tm = (int) $cs->diffInMonths(now());
                    $td = (int) $cs->diffInDays(now());
                    $rm = $tm - ($ty * 12);
                    if ($ty > 0) {
                        $sinceLabel = $rm > 0 ? "{$ty}y {$rm}m" : "{$ty}y";
                    } elseif ($tm > 0) {
                        $sinceLabel = "{$tm}m";
                    } else {
                        $sinceLabel = "{$td}d";
                    }
                }
                // Maintenance
                $latestMaint  = $tyre->maintenanceSchedules->first();
                $maintType    = $latestMaint ? $latestMaint->maintenance_item : '—';
                $maintStatus  = $latestMaint ? $latestMaint->status : '—';
                $maintBadge   = match($maintStatus) {
                    'Done'      => 'bg-success',
                    'Pending'   => 'bg-warning text-dark',
                    'Overdue'   => 'bg-danger',
                    'Scheduled' => 'bg-info',
                    default     => 'bg-secondary',
                };
                // Tracking group via vehicle mapping
                $trackingGroup = '—';
                if ($tyre->activeVehicleMapping) {
                    $vehicle = \App\Models\Vehicle::with('group')->find($tyre->allocated_vehicle_id);
                    if ($vehicle?->group) { $trackingGroup = $vehicle->group->name ?? '—'; }
                }
                // Tyre Status label
                $statusBadge = match($tyre->tyre_status) {
                    'Ready to Use'  => '<span class="badge tyre-badge-ready">Ready to Use</span>',
                    'Warranty Claim'=> '<span class="badge tyre-badge-warranty">Warranty</span>',
                    'Re-threading'  => '<span class="badge tyre-badge-rethread">Re-threading</span>',
                    'Scrap'         => '<span class="badge tyre-badge-scrap">Scrap</span>',
                    'Allocated'     => '<span class="badge tyre-badge-allocated">On Vehicle</span>',
                    'Direct Fitment'=> '<span class="badge tyre-badge-fitment">Direct Fit</span>',
                    'Yet to Decide' => '<span class="badge tyre-badge-ytd">Yet to Decide</span>',
                    default         => '<span class="badge bg-secondary">' . ($tyre->tyre_status ?? $tyre->location) . '</span>',
                };
                // Location display
                $locationDisplay = $tyre->location === 'Vehicle'
                    ? ($tyre->activeVehicleMapping?->tyre?->tyre_serial_number ? 'Vehicle' : 'Vehicle')
                    : ($tyre->location ?? 'SR Garage');
                // First image
                $firstImage = $tyre->images->first();
            @endphp
            <tr>
                <td>
                    <a href="{{ route('tyre.show', $tyre->id) }}" class="fw-semibold text-primary-custom">{{ $tyre->tyre_serial_number }}</a>
                </td>
                <td>
                    @if($tyre->location === 'Vehicle')
                        <span class="badge tyre-badge-allocated">Vehicle</span>
                    @else
                        <span class="badge tyre-badge-ready">SR Garage</span>
                    @endif
                </td>
                <td>{!! $statusBadge !!}</td>
                <td>{{ $tyre->tyre_type ?? '—' }}</td>
                <td>{{ $tyre->tyre_condition ?? '—' }}</td>
                <td>
                    @if($li['life_percent'] !== '-')
                        <div class="d-flex align-items-center gap-1">
                            <img src="{{ $li['icon'] }}" style="width:20px;height:20px;">
                            <span class="rag-badge rag-{{ $li['life_color'] }}">{{ $li['life_percent'] }}%</span>
                        </div>
                    @else
                        <span class="text-muted">N/A</span>
                    @endif
                </td>
                <td>{{ $kmRemaining !== null ? number_format($kmRemaining) . ' km' : '—' }}</td>
                <td>{!! $warrantyLabel !!}</td>
                <td>{{ $tyre->tyre_brand ?? '—' }}</td>
                <td>{{ $tyre->tyre_model ?? '—' }}</td>
                <td>{{ $tyre->tyrevendor?->contact_name ?? '—' }}</td>
                <td>₹{{ number_format($tyre->tyre_price, 2) }}</td>
                <td>{{ $sinceLabel }}</td>
                <td>{{ $maintType }}</td>
                <td>
                    @if($latestMaint)
                        <span class="badge {{ $maintBadge }}">{{ $maintStatus }}</span>
                    @else
                        <span class="text-muted">—</span>
                    @endif
                </td>
                <td>{{ $trackingGroup }}</td>
                <td class="text-center">
                    @if($firstImage)
                        <a href="{{ asset('medias/' . $firstImage->file_path) }}" target="_blank" class="btn-img-view" title="View Image">
                            <i class="uil uil-image"></i>
                        </a>
                    @else
                        <span class="text-muted">—</span>
                    @endif
                </td>
            </tr>
        @empty
            <tr><td colspan="17" class="text-center text-muted py-4">No records found</td></tr>
        @endforelse
    </tbody>
</table>
</div>
{{ $all_tyres->appends(request()->query())->links('pagination::bootstrap-5') }}
