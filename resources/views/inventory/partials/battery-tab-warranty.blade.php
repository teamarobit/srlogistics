{{-- Tab 3: Warranty Claim Batteries --}}
<div class="table-responsive">
<table class="table custom-driver-table bat-sortable-table" data-tab="3">
    <thead>
        <tr>
            <th class="sortable" data-col="battery_serial">Serial Number <span class="sort-icon">⇅</span></th>
            <th class="sortable" data-col="battery_capacity">Capacity <span class="sort-icon">⇅</span></th>
            <th class="sortable" data-col="battery_voltage">Voltage <span class="sort-icon">⇅</span></th>
            <th>Battery Location</th>
            <th>Vendor</th>
            <th class="sortable" data-col="warranty_claim_date">Claim Raised Date <span class="sort-icon">⇅</span></th>
            <th class="sortable" data-col="warranty_expected_closure_date">Expected Closure <span class="sort-icon">⇅</span></th>
            <th>Claim Number</th>
            <th>Claim Reason</th>
            <th>New Battery Serial</th>
            <th>New Battery Received</th>
            <th class="sortable" data-col="battery_brand">Brand <span class="sort-icon">⇅</span></th>
            <th class="sortable" data-col="battery_model">Model <span class="sort-icon">⇅</span></th>
            <th class="sortable" data-col="battery_purchase_cost">Price <span class="sort-icon">⇅</span></th>
            <th>Comment</th>
            <th class="text-center">Image</th>
        </tr>
    </thead>
    <tbody>
        @forelse($warranty_batteries as $bat)
            @php
                $today        = now()->toDateString();
                $closureDate  = $bat->warranty_expected_closure_date;
                $closureOverdue = $closureDate && $closureDate->toDateString() < $today;
                $closureLabel   = $closureDate ? $closureDate->format('d M Y') : '—';
                $isClosed       = ! empty($bat->warranty_new_battery_received_date);
                $firstImage     = $bat->images->first();
            @endphp
            <tr class="{{ $isClosed ? 'row-closed' : '' }}">
                <td>
                    <a href="{{ route('inventory.battery.details', $bat->id) }}" class="fw-semibold text-primary-custom">{{ $bat->battery_serial }}</a>
                    @if($isClosed)<span class="badge bat-badge-ready ms-1">Resolved</span>@endif
                </td>
                <td>{{ $bat->battery_capacity ? number_format($bat->battery_capacity, 0) . ' Ah' : '—' }}</td>
                <td>{{ $bat->battery_voltage ?? '—' }}</td>
                <td>
                    @if($bat->warranty_claim_location)
                        <span class="badge {{ $bat->warranty_claim_location === 'SR Garage' ? 'bat-badge-ready' : 'bat-badge-warranty' }}">
                            {{ $bat->warranty_claim_location }}
                        </span>
                    @else
                        <span class="text-muted">—</span>
                    @endif
                </td>
                <td>{{ $bat->vendor?->contact_name ?? '—' }}</td>
                <td>{{ $bat->warranty_claim_date ? $bat->warranty_claim_date->format('d M Y') : '—' }}</td>
                <td>
                    @if($closureOverdue && !$isClosed)
                        <span class="badge bg-danger closure-alert" title="Overdue!">
                            <i class="uil uil-exclamation-triangle me-1"></i>{{ $closureLabel }}
                        </span>
                    @else
                        {{ $closureLabel }}
                    @endif
                </td>
                <td>{{ $bat->warranty_claim_number ?? '—' }}</td>
                <td class="text-truncate" style="max-width:140px;" title="{{ $bat->warranty_claim_reason }}">
                    {{ $bat->warranty_claim_reason ? \Illuminate\Support\Str::limit($bat->warranty_claim_reason, 40) : '—' }}
                </td>
                <td>{{ $bat->warranty_new_battery_serial ?? '—' }}</td>
                <td>{{ $bat->warranty_new_battery_received_date ? $bat->warranty_new_battery_received_date->format('d M Y') : '—' }}</td>
                <td>{{ $bat->battery_brand ?? '—' }}</td>
                <td>{{ $bat->battery_model ?? '—' }}</td>
                <td>{{ $bat->battery_purchase_cost ? '₹' . number_format($bat->battery_purchase_cost, 2) : '—' }}</td>
                <td class="text-truncate" style="max-width:120px;" title="{{ $bat->warranty_comment }}">
                    {{ $bat->warranty_comment ? \Illuminate\Support\Str::limit($bat->warranty_comment, 35) : '—' }}
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
            <tr><td colspan="16" class="text-center text-muted py-4">No warranty claim batteries found.</td></tr>
        @endforelse
    </tbody>
</table>
</div>
<div class="d-flex align-items-center justify-content-between px-2 py-2 border-top">
    <small class="text-muted">Showing {{ $warranty_batteries->firstItem() ?? 0 }}–{{ $warranty_batteries->lastItem() ?? 0 }} of {{ $warranty_batteries->total() }}</small>
    {{ $warranty_batteries->appends(request()->except('tab3_page'))->links('pagination::bootstrap-5') }}
</div>
