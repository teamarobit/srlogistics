{{-- Tab 8: Yet To Decide — 15 columns --}}
<div class="table-responsive">
<table class="table custom-driver-table tyre-sortable-table" data-tab="8">
    <thead>
        <tr>
            <th class="sortable" data-col="tyre_serial_number">Serial Number <span class="sort-icon">⇅</span></th>
            <th class="sortable" data-col="tyre_type">Type <span class="sort-icon">⇅</span></th>
            <th>Tyre Location</th>
            <th class="sortable" data-col="tyre_condition">Condition <span class="sort-icon">⇅</span></th>
            <th>RAG / Life %</th>
            <th>KM Remaining</th>
            <th>Warranty Remaining</th>
            <th>Damage Reason</th>
            <th>Last Fitted Vehicle</th>
            <th class="sortable" data-col="tyre_brand">Brand <span class="sort-icon">⇅</span></th>
            <th class="sortable" data-col="tyre_model">Model <span class="sort-icon">⇅</span></th>
            <th>Vendor</th>
            <th class="sortable" data-col="tyre_price">Price <span class="sort-icon">⇅</span></th>
            <th class="text-center">Image</th>
            <th class="text-center">Change Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse($yet_to_decide_tyres as $tyre)
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
                $lastVehicleNo = $tyre->lastFittedVehicle?->basicinfo?->vehicle_number ?? '—';
                $firstImage = $tyre->images->first();
            @endphp
            <tr>
                <td><a href="{{ route('tyre.show', $tyre->id) }}" class="fw-semibold text-primary-custom">{{ $tyre->tyre_serial_number }}</a></td>
                <td>{{ $tyre->tyre_type ?? '—' }}</td>
                <td>
                    <span class="badge {{ $tyre->location === 'Vehicle' ? 'tyre-badge-allocated' : 'tyre-badge-ready' }}">{{ $tyre->location === 'Vehicle' ? 'Vehicle' : 'SR Garage' }}</span>
                </td>
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
                <td class="text-truncate" style="max-width:130px;" title="{{ $tyre->damage_reason }}">{{ $tyre->damage_reason ?? '—' }}</td>
                <td>{{ $lastVehicleNo }}</td>
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
                <td class="text-center">
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            Move To
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item ytd-change-status" href="javascript:void(0)"
                                   data-id="{{ $tyre->id }}" data-status="Warranty Claim"
                                   data-url="{{ route('tyre.changeStatus', $tyre->id) }}">
                                   <i class="uil uil-shield-check me-1 text-warning"></i> Warranty Claim
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item ytd-change-status" href="javascript:void(0)"
                                   data-id="{{ $tyre->id }}" data-status="Re-threading"
                                   data-url="{{ route('tyre.changeStatus', $tyre->id) }}">
                                   <i class="uil uil-redo me-1 text-info"></i> Re-threading
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item ytd-change-status" href="javascript:void(0)"
                                   data-id="{{ $tyre->id }}" data-status="Scrap"
                                   data-url="{{ route('tyre.changeStatus', $tyre->id) }}">
                                   <i class="uil uil-trash me-1 text-danger"></i> Scrap
                                </a>
                            </li>
                        </ul>
                    </div>
                </td>
            </tr>
        @empty
            <tr><td colspan="15" class="text-center text-muted py-4">No records found</td></tr>
        @endforelse
    </tbody>
</table>
</div>
{{ $yet_to_decide_tyres->appends(request()->query())->links('pagination::bootstrap-5') }}
