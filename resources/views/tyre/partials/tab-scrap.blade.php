{{-- Tab 5: Scrap Tyres — 15 columns --}}
<div class="table-responsive">
<table class="table custom-driver-table tyre-sortable-table" data-tab="5">
    <thead>
        <tr>
            <th class="sortable" data-col="tyre_serial_number">Serial Number <span class="sort-icon">⇅</span></th>
            <th class="sortable" data-col="tyre_type">Type <span class="sort-icon">⇅</span></th>
            <th>Tyre Location</th>
            <th>Last Fitted Vehicle</th>
            <th class="sortable" data-col="scrap_sent_date">Scrap Sent Date <span class="sort-icon">⇅</span></th>
            <th>Scrap Reason</th>
            <th>Scrap Vendor</th>
            <th>Scrap Income</th>
            <th>Income UTR</th>
            <th>Run KM</th>
            <th>Life Remaining %</th>
            <th class="sortable" data-col="tyre_brand">Brand <span class="sort-icon">⇅</span></th>
            <th class="sortable" data-col="tyre_model">Model <span class="sort-icon">⇅</span></th>
            <th>Comment</th>
            <th class="text-center">Image</th>
        </tr>
    </thead>
    <tbody>
        @forelse($scrap_tyres as $tyre)
            @php
                $li         = getTyreLifeInfo($tyre->id);
                $firstImage = $tyre->images->first();
                $comment    = $tyre->comments->first()?->comment ?? '—';
                $lastVehicleNo = $tyre->lastFittedVehicle?->basicinfo?->vehicle_number ?? '—';
            @endphp
            <tr>
                <td><a href="{{ route('tyre.show', $tyre->id) }}" class="fw-semibold text-primary-custom">{{ $tyre->tyre_serial_number }}</a></td>
                <td>{{ $tyre->tyre_type ?? '—' }}</td>
                <td>
                    @if($tyre->scrap_location)
                        <span class="badge {{ $tyre->scrap_location === 'SR Garage' ? 'tyre-badge-ready' : 'tyre-badge-scrap' }}">{{ $tyre->scrap_location }}</span>
                    @else
                        <span class="text-muted">—</span>
                    @endif
                </td>
                <td>{{ $lastVehicleNo }}</td>
                <td>{{ $tyre->scrap_sent_date ? \Carbon\Carbon::parse($tyre->scrap_sent_date)->format('d M Y') : '—' }}</td>
                <td class="text-truncate" style="max-width:130px;" title="{{ $tyre->scrap_reason }}">{{ $tyre->scrap_reason ?? '—' }}</td>
                <td>{{ $tyre->scrapVendor?->contact_name ?? '—' }}</td>
                <td>{{ $tyre->scrap_income !== null ? '₹' . number_format($tyre->scrap_income, 2) : '—' }}</td>
                <td>
                    @if($tyre->scrap_utr)
                        <span class="badge tyre-badge-closed">{{ $tyre->scrap_utr }}</span>
                    @else
                        <span class="text-muted fst-italic">Pending</span>
                    @endif
                </td>
                <td>{{ $tyre->actual_run_km !== null ? number_format($tyre->actual_run_km) . ' km' : '—' }}</td>
                <td>
                    @if($li['life_percent'] !== '-')
                        <span class="rag-badge rag-{{ $li['life_color'] }}">{{ $li['life_percent'] }}%</span>
                    @else
                        <span class="text-muted">N/A</span>
                    @endif
                </td>
                <td>{{ $tyre->tyre_brand ?? '—' }}</td>
                <td>{{ $tyre->tyre_model ?? '—' }}</td>
                <td class="text-truncate" style="max-width:120px;" title="{{ $comment }}">{{ Str::limit($comment, 40) }}</td>
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
{{ $scrap_tyres->appends(request()->query())->links('pagination::bootstrap-5') }}
