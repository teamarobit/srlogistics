{{-- E1 — Standalone Driver Exit / Relieving Letter. Does NOT @extends layouts.app. --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relieving Letter — {{ $d['name'] }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link href="{{ asset('css/V2/driver/exit-letter.css?v=1.0') }}" rel="stylesheet">
</head>
<body>
    <button class="cv2-print" onclick="window.print()">🖨 Print</button>
    <div class="dl-sheet">
        <div class="dl-head">
            <div class="dl-brand">SR Logistics<span>FLEET &amp; FREIGHT</span></div>
            <div class="dl-meta">
                Ref: SRL/DRV/RL/{{ $d['driver_code'] }}<br>
                Date: {{ now()->format('d M Y') }}<br>
                Guwahati, Assam
            </div>
        </div>

        <div class="dl-title">Relieving / Exit Letter</div>

        <div class="dl-body">
            <p>This is to certify that <strong>{{ $d['name'] }}</strong> (Driver Code <strong>{{ $d['driver_code'] }}</strong>) was employed with SR Logistics as a <strong>{{ $d['category'] }} Driver</strong> from <strong>{{ $d['doj'] }}</strong> and has been relieved from duties effective <strong>{{ $d['exit_date'] ?? '—' }}</strong>.</p>

            <table class="dl-tbl">
                <tr><td>Driver Name</td><td>{{ $d['name'] }}</td></tr>
                <tr><td>Driver Code</td><td>{{ $d['driver_code'] }}</td></tr>
                <tr><td>Date of Joining</td><td>{{ $d['doj'] }}</td></tr>
                <tr><td>Date of Exit</td><td>{{ $d['exit_date'] ?? '—' }}</td></tr>
                <tr><td>Allocated Vehicle</td><td>{{ $d['vehicle'] }} (handed over)</td></tr>
                <tr><td>Dues Status</td><td>Settled — ₹0 outstanding</td></tr>
            </table>

            <p>During the tenure, the conduct of the driver was found to be satisfactory. All company assets and the allocated vehicle have been returned, and bhatta accounts have been settled in full.</p>
            <p>We wish {{ $d['name'] }} success in future endeavours.</p>
        </div>

        <div class="dl-sign">
            <div><div class="line"></div>Authorised Signatory<br>SR Logistics</div>
            <div><div class="line"></div>Acknowledged<br>{{ $d['name'] }}</div>
        </div>

        <div class="dl-foot">SR Logistics · Guwahati, Assam · This is a system-generated letter from the Driver V2 module.</div>
    </div>
</body>
</html>
