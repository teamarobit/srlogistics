{{-- Tab 5: Scrap Batteries --}}
<div class="table-responsive">
<table class="table custom-driver-table bat-sortable-table" data-tab="5">
    <thead>
        <tr>
            <th class="sortable" data-col="battery_serial">Serial Number <span class="sort-icon">⇅</span></th>
            <th class="sortable" data-col="battery_capacity">Capacity <span class="sort-icon">⇅</span></th>
            <th class="sortable" data-col="battery_voltage">Voltage <span class="sort-icon">⇅</span></th>
            <th>Battery Location</th>
            <th>Last Fitted Vehicle</th>
            <th class="sortable" data-col="scrap_sent_date">Scrap Sent Date <span class="sort-icon">⇅</span></th>
            <th>Scrap Reason</th>
            <th>Scrap Vendor</th>
            <th>Scrap Income</th>
            <th>Income UTR</th>
            <th>Run Months</th>
            <th>Run KM</th>
            <th class="sortable" data-col="battery_brand">Brand <span class="sort-icon">⇅</span></th>
            <th class="sortable" data-col="battery_model">Model <span class="sort-icon">⇅</span></th>
            <th>Comment</th>
            <th class="text-center">Image</th>
        </tr>
    </thead>
    <tbody>
        @forelse($scrap_batteries as $bat)
            @php
                $lastVehicle = $bat->scrapLastVehicle?->basicinfo?->vehicle_number ?? '—';
                $firstImage  = $bat->images->first();
            @endphp
            <tr>
                <td><a href="{{ route('inventory.battery.details', $bat->id) }}" class="fw-semibold text-primary-custom">{{ $bat->battery_serial }}</a></td>
                <td>{{ $bat->battery_capacity ? number_format($bat->battery_capacity, 0) . ' Ah' : '—' }}</td>
                <td>{{ $bat->battery_voltage ?? '—' }}</td>
                <td>
                    @if($bat->scrap_location)
                        <span class="badge {{ $bat->scrap_location === 'SR Garage' ? 'bat-badge-ready' : 'bat-badge-scrap' }}">
                            {{ $bat->scrap_location }}
                        </span>
                    @else
                        <span class="text-muted">—</span>
                    @endif
                </td>
                <td>{{ $lastVehicle }}</td>
                <td>{{ $bat->scrap_sent_date ? $bat->scrap_sent_date->format('d M Y') : '—' }}</td>
                <td class="text-truncate" style="max-width:130px;" title="{{ $bat->scrap_reason }}">
                    {{ $bat->scrap_reason ? \Illuminate\Support\Str::limit($bat->scrap_reason, 35) : '—' }}
                </td>
                <td>{{ $bat->scrapVendor?->contact_name ?? '—' }}</td>
                <td>{{ $bat->scrap_income ? '₹' . number_format($bat->scrap_income, 2) : '—' }}</td>
                <td>
                    @if($bat->scrap_income_utr)
                        <span class="badge bat-badge-ready">{{ $bat->scrap_income_utr }}</span>
                    @else
                        <span class="text-muted fst-italic">Pending</span>
                    @endif
                </td>
                <td>{{ $bat->scrap_run_months !== null ? $bat->scrap_run_months . ' mo' : '—' }}</td>
                <td>{{ $bat->scrap_run_km !== null ? number_format($bat->scrap_run_km) . ' km' : '—' }}</td>
                <td>{{ $bat->battery_brand ?? '—' }}</td>
                <td>{{ $bat->battery_model ?? '—' }}</td>
                <td class="text-truncate" style="max-width:110px;" title="{{ $bat->scrap_comment }}">
                    {{ $bat->scrap_comment ? \Illuminate\Support\Str::limit($bat->scrap_comment, 30) : '—' }}
                </td>
                <td class="text-center">
                    @if($firstImage)
                        <a href="{{ asset('medias/' . $firstImage->file_path) }}" target="_blank" class="btn-img-view" title="View Image"><i class="uil uil-image"></i></a>
                    @else
                        <span class="text-muted">—</span>
                    @endif
                </td>
            </tr>
        @empty
            <tr><td colspan="16" class="text-center text-muted py-4">No scrap batteries found.</td></tr>
        @endforelse
    </tbody>
</table>
</div>
<div class="d-flex align-items-center justify-content-between px-2 py-2 border-top">
    <small class="text-muted">Showing {{ $scrap_batteries->firstItem() ?? 0 }}–{{ $scrap_batteries->lastItem() ?? 0 }} of {{ $scrap_batteries->total() }}</small>
    {{ $scrap_batteries->appends(request()->except('tab5_page'))->links('pagination::bootstrap-5') }}
</div>
