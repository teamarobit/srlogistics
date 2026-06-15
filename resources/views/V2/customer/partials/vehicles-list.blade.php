{{-- Customer V2 — Vehicle allocations table body (returned by filterVehicles).
     $vehicles = collection of Vehicleallocation (type=Customer). --}}
<table class="cv2-table">
    <thead>
        <tr>
            <th>Vehicle</th><th>Period</th><th>Allowed KM</th>
            <th>Fixed Amount</th><th>Extra / KM</th><th>Created By</th>
        </tr>
    </thead>
    <tbody>
        @forelse($vehicles as $allocation)
            <tr>
                <td><span class="cv2-t-name">{{ $allocation->vehicle->vehicle_no ?? 'N/A' }}</span></td>
                <td>
                    {{ $allocation->start_date ? \Carbon\Carbon::parse($allocation->start_date)->format('d M y') : '—' }}
                    –
                    {{ $allocation->end_date ? \Carbon\Carbon::parse($allocation->end_date)->format('d M y') : '—' }}
                </td>
                <td class="cv2-t-mono">{{ number_format($allocation->km_allowed ?? 0, 2) }}</td>
                <td class="cv2-t-mono">₹{{ number_format($allocation->fixed_amount ?? 0, 2) }}</td>
                <td class="cv2-t-mono">₹{{ number_format($allocation->extra_amount_per_km ?? 0, 2) }}</td>
                <td>{{ $allocation->createdby->name ?? 'N/A' }}</td>
            </tr>
        @empty
            <tr><td colspan="6" class="text-center cv2-empty">No vehicles allocated yet.</td></tr>
        @endforelse
    </tbody>
</table>
