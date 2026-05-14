{{-- Tab 4: Repair Batteries --}}
<div class="table-responsive">
<table class="table custom-driver-table bat-sortable-table" data-tab="4">
    <thead>
        <tr>
            <th class="sortable" data-col="battery_serial">Serial Number <span class="sort-icon">⇅</span></th>
            <th class="sortable" data-col="battery_capacity">Capacity <span class="sort-icon">⇅</span></th>
            <th class="sortable" data-col="battery_voltage">Voltage <span class="sort-icon">⇅</span></th>
            <th>Battery Location</th>
            <th>Repair Type</th>
            <th>Repair Vendor</th>
            <th class="sortable" data-col="repair_sent_date">Sent for Repair <span class="sort-icon">⇅</span></th>
            <th class="sortable" data-col="repair_expected_closure_date">Expected Return <span class="sort-icon">⇅</span></th>
            <th>Repair Cost</th>
            <th class="sortable" data-col="battery_brand">Brand <span class="sort-icon">⇅</span></th>
            <th class="sortable" data-col="battery_model">Model <span class="sort-icon">⇅</span></th>
            <th>Comment</th>
            <th class="text-center">Image</th>
        </tr>
    </thead>
    <tbody>
        @forelse($repair_batteries as $bat)
            @php
                $today        = now()->toDateString();
                $closureDate  = $bat->repair_expected_closure_date;
                $closureOverdue = $closureDate && $closureDate->toDateString() < $today;
                $closureLabel   = $closureDate ? $closureDate->format('d M Y') : '—';
                $firstImage     = $bat->images->first();
            @endphp
            <tr>
                <td><a href="{{ route('inventory.battery.details', $bat->id) }}" class="fw-semibold text-primary-custom">{{ $bat->battery_serial }}</a></td>
                <td>{{ $bat->battery_capacity ? number_format($bat->battery_capacity, 0) . ' Ah' : '—' }}</td>
                <td>{{ $bat->battery_voltage ?? '—' }}</td>
                <td>
                    @if($bat->repair_location)
                        <span class="badge {{ $bat->repair_location === 'SR Garage' ? 'bat-badge-ready' : 'bat-badge-repair' }}">
                            {{ $bat->repair_location }}
                        </span>
                    @else
                        <span class="text-muted">—</span>
                    @endif
                </td>
                <td>{{ $bat->repair_type ?? '—' }}</td>
                <td>{{ $bat->repairVendor?->contact_name ?? '—' }}</td>
                <td>{{ $bat->repair_sent_date ? $bat->repair_sent_date->format('d M Y') : '—' }}</td>
                <td>
                    @if($closureOverdue)
                        <span class="badge bg-danger closure-alert" title="Overdue!">
                            <i class="uil uil-exclamation-triangle me-1"></i>{{ $closureLabel }}
                        </span>
                    @else
                        {{ $closureLabel }}
                    @endif
                </td>
                <td>{{ $bat->repair_cost ? '₹' . number_format($bat->repair_cost, 2) : '—' }}</td>
                <td>{{ $bat->battery_brand ?? '—' }}</td>
                <td>{{ $bat->battery_model ?? '—' }}</td>
                <td class="text-truncate" style="max-width:120px;" title="{{ $bat->repair_comment }}">
                    {{ $bat->repair_comment ? \Illuminate\Support\Str::limit($bat->repair_comment, 35) : '—' }}
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
            <tr><td colspan="13" class="text-center text-muted py-4">No repair batteries found.</td></tr>
        @endforelse
    </tbody>
</table>
</div>
<div class="d-flex align-items-center justify-content-between px-2 py-2 border-top">
    <small class="text-muted">Showing {{ $repair_batteries->firstItem() ?? 0 }}–{{ $repair_batteries->lastItem() ?? 0 }} of {{ $repair_batteries->total() }}</small>
    {{ $repair_batteries->appends(request()->except('tab4_page'))->links('pagination::bootstrap-5') }}
</div>
