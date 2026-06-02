<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
    body { font-family: sans-serif; font-size: 11px; }
    h2 { text-align: center; margin-bottom: 10px; }
    table { width: 100%; border-collapse: collapse; }
    th { background: #032671; color: #fff; padding: 6px 8px; text-align: left; }
    td { padding: 5px 8px; border-bottom: 1px solid #ddd; }
    tr:nth-child(even) td { background: #f5f7fa; }
</style>
</head>
<body>
<h2>Fleet Vehicle Report</h2>
<p style="text-align:center; font-size:10px; color:#666;">Generated: {{ now()->format('d M Y, H:i') }}</p>
<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Vehicle No</th>
            <th>Driver Name</th>
            <th>Driver Phone</th>
            <th>Vehicle Group</th>
            <th>Managed By</th>
        </tr>
    </thead>
    <tbody>
        @foreach($vehicles as $i => $vehicle)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $vehicle->vehicle_no ?? '' }}</td>
            <td>{{ $vehicle->driverAllocation->contact->contact_name ?? '—' }}</td>
            <td>{{ $vehicle->driverAllocation->contact->phone ?? '—' }}</td>
            <td>{{ $vehicle->group->name ?? '—' }}</td>
            <td>{{ $vehicle->groupTracking->managed_by_employee ?? '—' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
</body>
</html>
