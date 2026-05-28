{{-- Tab 6: Allocated Batteries --}}
<div class="table-responsive">
<table class="table custom-driver-table bat-sortable-table" data-tab="6">
    <thead>
        <tr>
            <th class="sortable" data-col="battery_serial">Serial Number <span class="sort-icon">⇅</span></th>
            <th>Vehicle & Tracking Group</th>
            <th>Position</th>
            <th class="sortable" data-col="battery_capacity">Capacity <span class="sort-icon">⇅</span></th>
            <th class="sortable" data-col="battery_voltage">Voltage <span class="sort-icon">⇅</span></th>
            <th class="sortable" data-col="battery_condition">Condition <span class="sort-icon">⇅</span></th>
            <th>KM at Fitment</th>
            <th class="sortable" data-col="installation_date">Fitment Date <span class="sort-icon">⇅</span></th>
            <th>RAG / Life %</th>
            <th>Life Remaining</th>
            <th>Warranty Remaining</th>
            <th class="sortable" data-col="battery_brand">Brand <span class="sort-icon">⇅</span></th>
            <th class="sortable" data-col="battery_model">Model <span class="sort-icon">⇅</span></th>
            <th>Vendor</th>
            <th class="sortable" data-col="battery_purchase_cost">Price <span class="sort-icon">⇅</span></th>
            <th class="text-center">Image</th>
        </tr>
    </thead>
    <tbody>
        @forelse($allocated_batteries as $bat)
            @php
                $lifeRemMonths = $bat->life_remaining_months;
                $lifeRemPct    = $bat->life_remaining_pct;
                $ragEmoji      = match($bat->rag_status ?? 'Green') { 'Red' => '🔴', 'Yellow' => '🟡', default => '🟢' };
                $warrantyLabel = 'N/A';
                if ($bat->battery_warranty_expiry_date) {
                    $wDays = (int) now()->diffInDays($bat->battery_warranty_expiry_date, false);
                    if ($wDays > 0) {
                        $warrantyLabel = $wDays > 30 ? round($wDays / 30) . ' mo' : $wDays . ' d';
                    } else {
                        $warrantyLabel = '<span class="badge bg-danger">Expired</span>';
                    }
                }
                $vehicleNumber = $bat->allocatedVehicle?->basicinfo?->vehicle_number ?? '—';
                $groupName     = $bat->allocatedVehicle?->group?->name ?? ($bat->trackingGroup?->name ?? '—');
                $firstImage    = $bat->images->first();
            @endphp
            <tr>
                <td><a href="{{ route('inventory.battery.details', $bat->id) }}" class="fw-semibold text-primary-custom">{{ $bat->battery_serial }}</a></td>
                <td>
                    <span class="fw-semibold">{{ $vehicleNumber }}</span>
                    @if($groupName !== '—')
                        <br><small class="text-muted">{{ $groupName }}</small>
                    @endif
                </td>
                <td>
                    @if($bat->battery_position)
                        <span class="badge bat-badge-allocated">{{ $bat->battery_position }}</span>
                    @else
                        <span class="text-muted">—</span>
                    @endif
                </td>
                <td>{{ $bat->battery_capacity ? number_format($bat->battery_capacity, 0) . ' Ah' : '—' }}</td>
                <td>{{ $bat->battery_voltage ?? '—' }}</td>
                <td>{{ $bat->battery_condition ?? '—' }}</td>
                <td>{{ $bat->current_odometer_km !== null ? number_format($bat->current_odometer_km) . ' km' : '—' }}</td>
                <td>{{ $bat->installation_date ? $bat->installation_date->format('d M Y') : '—' }}</td>
                <td>
                    @if($lifeRemPct !== null)
                        <span class="rag-badge rag-{{ strtolower($bat->rag_status ?? 'green') }}">{{ $ragEmoji }} {{ $lifeRemPct }}%</span>
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
                <td class="text-center">
                    @if($firstImage)
                        <a href="{{ asset('medias/' . $firstImage->file_path) }}" target="_blank" class="btn-img-view" title="View Image"><i class="uil uil-image"></i></a>
                    @else
                        <span class="text-muted">—</span>
                    @endif
                </td>
            </tr>
        @empty
            <tr><td colspan="16" class="text-center text-muted py-4">No allocated batteries found.</td></tr>
        @endforelse
    </tbody>
</table>
</div>
<div class="d-flex align-items-center justify-content-between px-2 py-2 border-top">
    <small class="text-muted">Showing {{ $allocated_batteries->firstItem() ?? 0 }}–{{ $allocated_batteries->lastItem() ?? 0 }} of {{ $allocated_batteries->total() }}</small>
    {{ $allocated_batteries->appends(request()->except('tab6_page'))->links('pagination::bootstrap-5') }}
</div>
