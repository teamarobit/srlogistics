<table class="table custom-driver-table">
    <thead>
        <tr>
            <th></th>
            <th>Serial Number</th>
            <th style="min-width: 150px;">Vendor</th>
            <th>Condition</th>
            <th>Brand Name</th>
            <th>Model</th>
            <th>Type</th>
            <th>Price</th>
            <th>Created By</th>
            <th class="text-end">Action</th> 
        </tr>
    </thead>
    <tbody>
        @forelse($tyres as $key => $tyre)
            @php
                $tyreLifeInfo = getTyreLifeInfo($tyre->id);
                
            @endphp
            <tr>
                <td>
                    <img src="{{ $tyreLifeInfo['icon'] }}" class="driver-img-sm">
                </td>
                <td>{{ $tyre->tyre_serial_number }}</td>
                <td>{{ $tyre->tyrevendor->contact_name }}</td>
                <td>{{ $tyre->tyre_condition }}</td>
                <td>{{ $tyre->tyre_brand }}</td>
                <td>{{ $tyre->tyre_model }}</td>
                <td>{{ $tyre->tyre_type }}</td>
                <td>₹{{ number_format($tyre->tyre_price, 2) }}</td>
                <td>
                    {{$tyre->createdby?->name}}
                    <span class="text-secondary d-block">{{$tyre->createdby?->email}}</span>
                </td>
                <td class="text-center">
                    <a href="{{ route('tyre.show', $tyre->id) }}" class="btn btn-sm-custom">View Details</a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="10" class="text-center text-muted">No records found</td>
            </tr>
        @endforelse


    </tbody>
</table>

{{ $tyres->appends(request()->query())->links('pagination::bootstrap-5') }}