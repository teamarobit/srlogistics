{{-- Load Vendor V2 — Locations table body (returned by filterLocations). --}}
<table class="cv2-table">
    <thead>
        <tr>
            <th>Company / Point</th><th>Type</th><th>Role</th><th>Route</th>
            <th>City</th><th>Charges Paid By</th><th>Charge</th>
            <th style="text-align:right;">Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($locations as $location)
            @php
                $city = $location->route_type === 'Source'
                            ? optional($location->sourceCity)->name
                            : ($location->route_type === 'Destination'
                                ? optional($location->destinationCity)->name
                                : optional($location->midpointCity)->name);
                $charge = $location->location_type === 'Unloading'
                            ? $location->unloading_charge
                            : $location->loading_charge;
            @endphp
            <tr>
                <td>
                    <span class="cv2-t-name">{{ $location->location_name ?? '—' }}</span>
                    <div class="cv2-t-sub">{{ $location->company_name ?? '' }}</div>
                </td>
                <td><span class="cv2-pill">{{ $location->location_type }}</span></td>
                <td>{{ $location->company_role ?? '—' }}</td>
                <td>{{ $location->route_type ?? '—' }}</td>
                <td>{{ $city ?? '—' }}</td>
                <td>{{ $location->charges_paid_by ?? '—' }}</td>
                <td class="cv2-t-mono">₹{{ number_format($charge ?? 0, 2) }}</td>
                <td class="cv2-actions">
                    @if(!empty($location->map_location))
                        <a href="{{ $location->map_location }}" target="_blank" class="cv2-ic-btn" title="Map"><i class="bi bi-geo-alt"></i></a>
                    @endif
                    <a href="javascript:void(0)" class="cv2-ic-btn is-danger cv2-del-location" data-location-id="{{ $location->id }}" title="Delete"><i class="bi bi-trash3"></i></a>
                </td>
            </tr>
        @empty
            <tr><td colspan="8" class="text-center cv2-empty">No locations added yet.</td></tr>
        @endforelse
    </tbody>
</table>
