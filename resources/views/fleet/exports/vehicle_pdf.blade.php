<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Fleet Vehicles</title>

    <style>
        body{
            font-family: DejaVu Sans, sans-serif;
            font-size:12px;
        }

        table{
            width:100%;
            border-collapse:collapse;
        }

        th, td{
            border:1px solid #ccc;
            padding:6px;
            text-align:left;
        }

        th{
            background:#f2f2f2;
        }
    </style>
</head>

<body>

<h2>Fleet Vehicles</h2>

<table>
<thead>
<tr>
    <th>Vehicle Number</th>
    <th>Driver</th>
    <th>Phone</th>
    <th>Vehicle Group</th>
    <th>Managed By</th>
</tr>
</thead>

<tbody>

@foreach($vehicles as $vehicle)

<tr>
<td>{{ $vehicle->vehicle_no }}</td>

<td>
{{ optional(optional($vehicle->driverAllocation)->contact)->contact_name ?? '-' }}
</td>

<td>
{{ optional(optional($vehicle->driverAllocation)->contact)->phone ?? '-' }}
</td>

<td>
{{ $vehicle->group->name ?? '-' }}
</td>

<td>
{{ $vehicle->groupTracking->managed_by_employee ?? '-' }}
</td>

</tr>

@endforeach

</tbody>
</table>

</body>
</html>