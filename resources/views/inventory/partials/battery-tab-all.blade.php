{{-- Tab 1: All Batteries --}}
<div class="table-responsive">
<table class="table custom-driver-table bat-sortable-table" data-tab="1">
    <thead>
        <tr>
            <th class="sortable" data-col="battery_serial">Serial Number <span class="sort-icon">⇅</span></th>
            <th>Location</th>
            <th>Status</th>
            <th class="sortable" data-col="battery_condition">Condition <span class="sort-icon">⇅</span></th>
            <th class="sortable" data-col="battery_capacity">Capacity <span class="sort-icon">⇅</span></th>
            <th class="sortable" data-col="battery_voltage">Voltage <span class="sort-icon">⇅</span></th>
            <th>RAG / Life %</th>
            <th>Months Remaining</th>
            <th>Warranty Remaining</th>
            <th class="sortable" data-col="battery_brand">Brand <span class="sort-icon">⇅</span></th>
            <th class="sortable" data-col="battery_model">Model <span class="sort-icon">⇅</span></th>
            <th>Vendor</th>
            <th class="sortable" data-col="battery_purchase_cost">Price <span class="sort-icon">⇅</span></th>
            <th>Status Since</th>
            <th>Tracking Group</th>
            <th class="text-center">Image</th>
        </tr>
    </thead>
    <tbody>
        @forelse($all_batteries as $bat)
            @php
                $lifeRemMonths = $bat->life_remaining_months;
                $lifeRemPct    = $bat->life_remaining_pct;
                $ragColor      = match($bat->rag_status ?? 'Green') {
                    'Red'    => 'danger',
                    'Yellow' => 'warning',
                    default  => 'success',
                };
                $ragEmoji = match($bat->rag_status ?? 'Green') {
                    'Red'    => '🔴',
                    'Yellow' => '🟡',
                    default  => '🟢',
                };
                // Warranty remaining
                $warrantyLabel = 'N/A';
                if ($bat->battery_warranty_expiry_date) {
                    $wDays = (int) now()->diffInDays($bat->battery_warranty_expiry_date, false);
                    if ($wDays > 0) {
                        $warrantyLabel = $wDays > 30 ? round($wDays / 30) . ' mo' : $wDays . ' d';
                    } else {
                        $warrantyLabel = '<span class="badge bg-danger">Expired</span>';
                    }
                }
                // Status since
                $sinceDate = null;
                if ($bat->battery_status === 'Warranty Claim' && $bat->warranty_claim_date)  { $sinceDate = $bat->warranty_claim_date; }
                elseif ($bat->battery_status === 'Repair' && $bat->repair_sent_date)         { $sinceDate = $bat->repair_sent_date; }
                elseif ($bat->battery_status === 'Scrap' && $bat->scrap_sent_date)           { $sinceDate = $bat->scrap_sent_date; }
                elseif ($bat->battery_status === 'Allocated' && $bat->installation_date)     { $sinceDate = $bat->installation_date; }
                $sinceLabel = '—';
                if ($sinceDate) {
                    $cs = \Carbon\Carbon::parse($sinceDate);
                    $ty = (int) $cs->diffInYears(now());
                    $tm = (int) $cs->diffInMonths(now());
                    $td = (int) $cs->diffInDays(now());
                    $rm = $tm - ($ty * 12);
                    if ($ty > 0)      { $sinceLabel = $rm > 0 ? "{$ty}y {$rm}m" : "{$ty}y"; }
                    elseif ($tm > 0)  { $sinceLabel = "{$tm}m"; }
                    else              { $sinceLabel = "{$td}d"; }
                }
                // Battery status display
                $statusBadge = match($bat->battery_status) {
                    'Ready to Use'   => '<span class="badge bat-badge-ready">Ready to Use</span>',
                    'Warranty Claim' => '<span class="badge bat-badge-warranty">Warranty Claim</span>',
                    'Repair'         => '<span class="badge bat-badge-repair">Repair</span>',
                    'Scrap'          => '<span class="badge bat-badge-scrap">Scrap</span>',
                    'Allocated'      => '<span class="badge bat-badge-allocated">' . ($bat->allocatedVehicle?->basicinfo?->vehicle_number ?? 'Allocated') . '</span>',
                    'Direct Fitment' => '<span class="badge bat-badge-fitment">Direct Fitment</span>',
                    'Yet to Decide'  => '<span class="badge bat-badge-ytd">Yet to Decide</span>',
                    default          => '<span class="badge bg-secondary">' . ($bat->battery_status ?? '—') . '</span>',
                };
                $trackingGroup = $bat->trackingGroup?->name ?? ($bat->allocatedVehicle?->group?->name ?? '—');
                $firstImage    = $bat->images->first();
            @endphp
            <tr>
                <td><a href="{{ route('inventory.battery.details', $bat->id) }}" class="fw-semibold text-primary-custom">{{ $bat->battery_serial }}</a></td>
                <td>
                    <span class="badge {{ $bat->battery_location === 'Vehicle' ? 'bat-badge-allocated' : 'bat-badge-ready' }}">
                        {{ $bat->battery_location ?? 'SR Garage' }}
                    </span>
                </td>
                <td>{!! $statusBadge !!}</td>
                <td>{{ $bat->battery_condition ?? '—' }}</td>
                <td>{{ $bat->battery_capacity ? number_format($bat->battery_capacity, 0) . ' Ah' : '—' }}</td>
                <td>{{ $bat->battery_voltage ?? '—' }}</td>
                <td>
                    @if($lifeRemPct !== null)
                        <span class="rag-badge rag-{{ strtolower($bat->rag_status ?? 'green') }}">
                            {{ $ragEmoji }} {{ $lifeRemPct }}%
                        </span>
                    @else
                        <span class="text-muted">N/A</span>
                    @endif
                </td>
                <td>{{ $lifeRemMonths !== null ? $lifeRemMonths . ' mo' : '—' }}</td>
                <td>{!! $warrantyLabel !!}</td>
                <td>{{ $bat->battery_brand ?? '—' }}</td>
                <td>{{ $bat->battery_model ?? '—' }}</td>
                <td>{{ $bat->vendor?->contact_name ?? '—' }}</td>
                <td>{{ $bat->battery_purchase_cost ? '₹' . number_format($bat->battery_purchase_cost, 2) : '—' }}</td>
                <td>{{ $sinceLabel }}</td>
                <td>{{ $trackingGroup }}</td>
                <td class="text-center">
                    @if($firstImage)
                        <a href="{{ asset('medias/' . $firstImage->file_path) }}" target="_blank" class="btn-img-view" title="View Image"><i class="uil uil-image"></i></a>
                    @else
                        <span class="text-muted">—</span>
                    @endif
                </td>
            </tr>
        @empty
            <tr><td colspan="16" class="text-center text-muted py-4">No batteries found.</td></tr>
        @endforelse
    </tbody>
</table>
</div>
<div class="d-flex align-items-center justify-content-between px-2 py-2 border-top">
    <small class="text-muted">Showing {{ $all_batteries->firstItem() ?? 0 }}–{{ $all_batteries->lastItem() ?? 0 }} of {{ $all_batteries->total() }}</small>
    {{ $all_batteries->appends(request()->except('tab1_page'))->links('pagination::bootstrap-5') }}
</div>
