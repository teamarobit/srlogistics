{{-- Tab 7: Direct Fitment Tyres — 11 columns --}}
<div class="table-responsive">
<table class="table custom-driver-table tyre-sortable-table" data-tab="7">
    <thead>
        <tr>
            <th class="sortable" data-col="tyre_serial_number">Serial Number <span class="sort-icon">⇅</span></th>
            <th class="sortable" data-col="tyre_type">Type <span class="sort-icon">⇅</span></th>
            <th class="sortable" data-col="tyre_condition">Condition <span class="sort-icon">⇅</span></th>
            <th>RAG / Life %</th>
            <th>KM Remaining</th>
            <th>Warranty Remaining</th>
            <th class="sortable" data-col="tyre_brand">Brand <span class="sort-icon">⇅</span></th>
            <th class="sortable" data-col="tyre_model">Model <span class="sort-icon">⇅</span></th>
            <th>Vendor</th>
            <th class="sortable" data-col="tyre_price">Price <span class="sort-icon">⇅</span></th>
            <th class="text-center">Image</th>
        </tr>
    </thead>
    <tbody>
        @forelse($direct_fitment_tyres as $tyre)
            @php
                $li = getTyreLifeInfo($tyre->id);
                $kmRemaining = ($tyre->fixed_run_km && $tyre->actual_run_km !== null)
                                ? max(0, $tyre->fixed_run_km - $tyre->actual_run_km) : null;
                $warrantyLabel = 'N/A';
                if ($tyre->tyre_warrenty_end_date) {
                    $wDays = (int) now()->diffInDays($tyre->tyre_warrenty_end_date, false);
                    if ($wDays > 0) {
                        $warrantyLabel = $wDays > 30 ? round($wDays / 30) . ' mo' : $wDays . ' d';
                    } else {
                        $warrantyLabel = '<span class="badge bg-danger">Expired</span>';
                    }
                }
                $firstImage = $tyre->images->first();
            @endphp
            <tr>
                <td><a href="{{ route('tyre.show', $tyre->id) }}" class="fw-semibold text-primary-custom">{{ $tyre->tyre_serial_number }}</a></td>
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
{{ $direct_fitment_tyres->appends(request()->query())->links('pagination::bootstrap-5') }}
