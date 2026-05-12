{{-- Tab 6: Allocate Tyres (on vehicles) — 15 columns --}}
<div class="table-responsive">
<table class="table custom-driver-table tyre-sortable-table" data-tab="6">
    <thead>
        <tr>
            <th class="sortable" data-col="tyre_serial_number">Serial Number <span class="sort-icon">⇅</span></th>
            <th>Vehicle No. / Tracking Group</th>
            <th>Tyre Position</th>
            <th class="sortable" data-col="tyre_type">Type <span class="sort-icon">⇅</span></th>
            <th class="sortable" data-col="tyre_condition">Condition <span class="sort-icon">⇅</span></th>
            <th class="sortable" data-col="installation_date">Fitment Date <span class="sort-icon">⇅</span></th>
            <th>RAG / Life %</th>
            <th>KM Remaining</th>
            <th>Life Remaining (mo)</th>
            <th>Warranty Remaining</th>
            <th class="sortable" data-col="tyre_brand">Brand <span class="sort-icon">⇅</span></th>
            <th class="sortable" data-col="tyre_model">Model <span class="sort-icon">⇅</span></th>
            <th>Vendor</th>
            <th class="sortable" data-col="tyre_price">Price <span class="sort-icon">⇅</span></th>
            <th class="text-center">Image</th>
        </tr>
    </thead>
    <tbody>
        @forelse($allocated_tyres as $tyre)
            @php
                $li = getTyreLifeInfo($tyre->id);
                $kmRemaining = ($tyre->fixed_run_km && $tyre->actual_run_km !== null)
                                ? max(0, $tyre->fixed_run_km - $tyre->actual_run_km) : null;
                // Life remaining in months
                $lifeMonths = '—';
                if ($tyre->end_of_life_date) {
                    $moRemaining = (int) now()->diffInMonths($tyre->end_of_life_date, false);
                    $lifeMonths = $moRemaining > 0 ? $moRemaining . ' mo' : '<span class="badge bg-danger">Expired</span>';
                } elseif ($tyre->fixed_life_months && $tyre->actual_run_month !== null) {
                    $moRemaining = max(0, (int)$tyre->fixed_life_months - (int)$tyre->actual_run_month);
                    $lifeMonths = $moRemaining . ' mo';
                }
                // Warranty remaining
                $warrantyLabel = 'N/A';
                if ($tyre->tyre_warrenty_end_date) {
                    $wDays = (int) now()->diffInDays($tyre->tyre_warrenty_end_date, false);
                    if ($wDays > 0) {
                        $warrantyLabel = $wDays > 30 ? round($wDays / 30) . ' mo' : $wDays . ' d';
                    } else {
                        $warrantyLabel = '<span class="badge bg-danger">Expired</span>';
                    }
                }
                // Vehicle & tracking group
                $vehicleNo = '—';
                $trackingGroup = '—';
                $tyrePosition  = '—';
                if ($mapping = $tyre->activeVehicleMapping) {
                    $vehicle = \App\Models\Vehicle::with(['basicinfo', 'group'])->find($tyre->allocated_vehicle_id);
                    $vehicleNo = $vehicle?->basicinfo?->vehicle_number ?? '—';
                    $trackingGroup = $vehicle?->group?->name ?? '—';
                    $tyrePosition  = $mapping->tyreposition?->position_name ?? $mapping->tyreposition?->name ?? '—';
                }
                $fitmentDate = $tyre->installation_date ?? $tyre->activeVehicleMapping?->fitment_date;
                $firstImage = $tyre->images->first();
            @endphp
            <tr>
                <td><a href="{{ route('tyre.show', $tyre->id) }}" class="fw-semibold text-primary-custom">{{ $tyre->tyre_serial_number }}</a></td>
                <td>
                    <span class="d-block fw-semibold">{{ $vehicleNo }}</span>
                    <span class="text-muted small">{{ $trackingGroup }}</span>
                </td>
                <td>{{ $tyrePosition }}</td>
                <td>{{ $tyre->tyre_type ?? '—' }}</td>
                <td>{{ $tyre->tyre_condition ?? '—' }}</td>
                <td>{{ $fitmentDate ? \Carbon\Carbon::parse($fitmentDate)->format('d M Y') : '—' }}</td>
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
                <td>{!! $lifeMonths !!}</td>
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
            <tr><td colspan="15" class="text-center text-muted py-4">No records found</td></tr>
        @endforelse
    </tbody>
</table>
</div>
{{ $allocated_tyres->appends(request()->query())->links('pagination::bootstrap-5') }}
