{{-- Tab 4: Re-threading Tyres — 11 columns --}}
<div class="table-responsive">
<table class="table custom-driver-table tyre-sortable-table" data-tab="4">
    <thead>
        <tr>
            <th class="sortable" data-col="tyre_serial_number">Serial Number <span class="sort-icon">⇅</span></th>
            <th class="sortable" data-col="tyre_type">Type <span class="sort-icon">⇅</span></th>
            <th>Tyre Location</th>
            <th>Re-threading Vendor</th>
            <th class="sortable" data-col="rethreading_sent_date">Sent Date <span class="sort-icon">⇅</span></th>
            <th class="sortable" data-col="rethreading_expected_date">Expected Return <span class="sort-icon">⇅</span></th>
            <th>Re-threading Cost</th>
            <th class="sortable" data-col="tyre_brand">Brand <span class="sort-icon">⇅</span></th>
            <th class="sortable" data-col="tyre_model">Model <span class="sort-icon">⇅</span></th>
            <th>Comment</th>
            <th class="text-center">Image</th>
        </tr>
    </thead>
    <tbody>
        @forelse($rethreading_tyres as $tyre)
            @php
                $today       = now()->toDateString();
                $expDate     = $tyre->rethreading_expected_date;
                $expOverdue  = $expDate && $expDate < $today;
                $firstImage  = $tyre->images->first();
                $comment     = $tyre->comments->first()?->comment ?? '—';
            @endphp
            <tr>
                <td><a href="{{ route('tyre.show', $tyre->id) }}" class="fw-semibold text-primary-custom">{{ $tyre->tyre_serial_number }}</a></td>
                <td>{{ $tyre->tyre_type ?? '—' }}</td>
                <td>
                    @if($tyre->rethreading_location)
                        <span class="badge {{ $tyre->rethreading_location === 'SR Garage' ? 'tyre-badge-ready' : 'tyre-badge-rethread' }}">{{ $tyre->rethreading_location }}</span>
                    @else
                        <span class="text-muted">—</span>
                    @endif
                </td>
                <td>{{ $tyre->rethreadingVendor?->contact_name ?? '—' }}</td>
                <td>{{ $tyre->rethreading_sent_date ? \Carbon\Carbon::parse($tyre->rethreading_sent_date)->format('d M Y') : '—' }}</td>
                <td>
                    @if($expOverdue)
                        <span class="badge bg-danger closure-alert" title="Overdue!">
                            <i class="uil uil-exclamation-triangle me-1"></i>{{ \Carbon\Carbon::parse($expDate)->format('d M Y') }}
                        </span>
                    @elseif($expDate)
                        {{ \Carbon\Carbon::parse($expDate)->format('d M Y') }}
                    @else
                        —
                    @endif
                </td>
                <td>{{ $tyre->rethreading_cost !== null ? '₹' . number_format($tyre->rethreading_cost, 2) : '—' }}</td>
                <td>{{ $tyre->tyre_brand ?? '—' }}</td>
                <td>{{ $tyre->tyre_model ?? '—' }}</td>
                <td class="text-truncate" style="max-width:140px;" title="{{ $comment }}">{{ Str::limit($comment, 40) }}</td>
                <td class="text-center">
                    @if($firstImage)
                        <a href="{{ asset('medias/' . $firstImage->file_path) }}" target="_blank" class="btn-img-view" title="View Image"><i class="uil uil-image"></i></a>
                    @else
                        <span class="text-muted">—</span>
                    @endif
                </td>
            </tr>
        @empty
            <tr><td colspan="11" class="text-center text-muted py-4">No records found</td></tr>
        @endforelse
    </tbody>
</table>
</div>
{{ $rethreading_tyres->appends(request()->query())->links('pagination::bootstrap-5') }}
