
<table class="table">
    <thead>
        <tr>
            <th>Vehicle No</th>
            <th>KM Allowed</th>
            <th>Fixed Amount</th>
            <th>Extra Amount/Km</th>
            <th>Created On</th>
            <th>Created By</th>
        </tr>
    </thead>
    
    <tbody>
        
        @forelse($vehicles as $allocation)
        <tr>
            <td>{{ $allocation->vehicle->vehicle_no ?? 'N/A' }}</td>
            <td>{{ number_format($allocation->km_allowed, 2) }}</td>
            <td>₹{{ number_format($allocation->fixed_amount, 2) }}</td>
            <td>₹{{ number_format($allocation->extra_amount_per_km, 2) }}</td>
            <td>{{ $allocation->created_at->format('d-m-Y') }}</td>
            <td>{{ $allocation->createdby->name ?? 'N/A' }}</td>
        </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center">No vehicles allocated yet.</td>
            </tr>
        @endforelse
        
        
    </tbody>

</table>
    