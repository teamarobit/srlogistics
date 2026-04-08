@if($vehicles->count())

    @foreach($vehicles as $vehicle)
    <tr>
        <td>
            <img src="{{ asset('public/images/icons/vehiche03.png') }}" class="driver-img-sm">
        </td>

        <td>
            <span class="value">{{ $vehicle->vehicle_no ?? '' }}</span>
        </td>

        <td>
            <span class="value">{{ $vehicle->driverAllocation->contact->contact_name ?? '-' }}</span><br>
            <span class="value">{{ $vehicle->driverAllocation->contact->phone ?? '' }}</span>
        </td>

        <td>
            <span class="value">{{ $vehicle->group->name ?? '-' }}</span>
        </td>

        <td><span class="value">-</span></td>

        <td><span class="value">-</span></td>

        <td>
            <span class="value">{{ $vehicle->groupTracking->managed_by_employee ?? '-' }}</span>
        </td>

        <td class="text-center">
            <a href="{{ route('fleetdashboard.getVehicleDetails', $vehicle->id) }}" class="btn btn-sm-custom">View Details</a>
        </td>
    </tr>
    @endforeach

    <tr>
        <td colspan="8">
            <div class="d-flex justify-content-end mt-2">
                {!! $vehicles->links() !!}
            </div>
        </td>
    </tr>

@else

<tr>
    <td colspan="8" class="text-center text-muted">
        No vehicles found
    </td>
</tr>

@endif