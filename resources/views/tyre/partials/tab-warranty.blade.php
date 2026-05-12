{{-- Tab 3: Warranty Claim Tyres — 15 columns --}}
<div class="table-responsive">
<table class="table custom-driver-table tyre-sortable-table" data-tab="3">
    <thead>
        <tr>
            <th class="sortable" data-col="tyre_serial_number">Serial Number <span class="sort-icon">⇅</span></th>
            <th class="sortable" data-col="tyre_type">Type <span class="sort-icon">⇅</span></th>
            <th>Tyre Location</th>
            <th>Vendor</th>
            <th class="sortable" data-col="warranty_claim_date">Claim Raised Date <span class="sort-icon">⇅</span></th>
            <th class="sortable" data-col="warranty_expected_closure_date">Expected Closure <span class="sort-icon">⇅</span></th>
            <th>Claim Number</th>
            <th>Claim Reason</th>
            <th>Claim Amount</th>
            <th class="sortable" data-col="tyre_brand">Brand <span class="sort-icon">⇅</span></th>
            <th class="sortable" data-col="tyre_model">Model <span class="sort-icon">⇅</span></th>
            <th class="sortable" data-col="tyre_price">Price <span class="sort-icon">⇅</span></th>
            <th>Comment</th>
            <th>Refund UTR</th>
            <th class="text-center">Image</th>
        </tr>
    </thead>
    <tbody>
        @forelse($warranty_tyres as $tyre)
            @php
                $today = now()->toDateString();
                $closureDate = $tyre->warranty_expected_closure_date;
                $closureOverdue = $closureDate && $closureDate < $today;
                $closureLabel = $closureDate
                    ? \Carbon\Carbon::parse($closureDate)->format('d M Y')
                    : '—';
                $isClosed = ! empty($tyre->warranty_utr);
                $firstImage = $tyre->images->first();
                $comment = $tyre->comments->first()?->comment ?? '—';
            @endphp
            <tr class="{{ $isClosed ? 'row-closed' : '' }}">
                <td>
                    <a href="{{ route('tyre.show', $tyre->id) }}" class="fw-semibold text-primary-custom">{{ $tyre->tyre_serial_number }}</a>
                    @if($isClosed)
                        <span class="badge tyre-badge-closed ms-1">Closed</span>
                    @endif
                </td>
                <td>{{ $tyre->tyre_type ?? '—' }}</td>
                <td>
                    @if($tyre->warranty_location)
                        <span class="badge {{ $tyre->warranty_location === 'SR Garage' ? 'tyre-badge-ready' : 'tyre-badge-warranty' }}">{{ $tyre->warranty_location }}</span>
                    @else
                        <span class="text-muted">—</span>
                    @endif
                </td>
                <td>{{ $tyre->tyrevendor?->contact_name ?? '—' }}</td>
                <td>{{ $tyre->warranty_claim_date ? \Carbon\Carbon::parse($tyre->warranty_claim_date)->format('d M Y') : '—' }}</td>
                <td>
                    @if($closureOverdue && !$isClosed)
                        <span class="badge bg-danger closure-alert" title="Overdue!">
                            <i class="uil uil-exclamation-triangle me-1"></i>{{ $closureLabel }}
                        </span>
                    @else
                        {{ $closureLabel }}
                    @endif
                </td>
                <td>{{ $tyre->warranty_claim_number ?? '—' }}</td>
                <td class="text-truncate" style="max-width:150px;" title="{{ $tyre->warranty_claim_reason }}">{{ $tyre->warranty_claim_reason ?? '—' }}</td>
                <td>{{ $tyre->warranty_claim_amount !== null ? '₹' . number_format($tyre->warranty_claim_amount, 2) : '—' }}</td>
                <td>{{ $tyre->tyre_brand ?? '—' }}</td>
                <td>{{ $tyre->tyre_model ?? '—' }}</td>
                <td>₹{{ number_format($tyre->tyre_price, 2) }}</td>
                <td class="text-truncate" style="max-width:120px;" title="{{ $comment }}">{{ Str::limit($comment, 40) }}</td>
                <td>
                    @if($tyre->warranty_utr)
                        <span class="badge tyre-badge-closed">{{ $tyre->warranty_utr }}</span>
                    @else
                        <span class="text-muted fst-italic">Pending</span>
                    @endif
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
            <tr><td colspan="15" class="text-center text-muted py-4">No records found</td></tr>
        @endforelse
    </tbody>
</table>
</div>
{{ $warranty_tyres->appends(request()->query())->links('pagination::bootstrap-5') }}
