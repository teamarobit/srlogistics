{{-- E1 — Standalone Driver Joining Letter. Does NOT @extends layouts.app.
     Links its own CSS in <head> (frontend-design: standalone pages). --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Joining Letter — {{ $d['name'] }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link href="{{ asset('css/V2/driver/joining-letter.css?v=1.0') }}" rel="stylesheet">
</head>
<body>
    <button class="cv2-print" onclick="window.print()">🖨 Print</button>
    <div class="dl-sheet">
        <div class="dl-head">
            <div class="dl-brand">SR Logistics<span>FLEET &amp; FREIGHT</span></div>
            <div class="dl-meta">
                Ref: SRL/DRV/JL/{{ $d['driver_code'] }}<br>
                Date: {{ now()->format('d M Y') }}<br>
                Guwahati, Assam
            </div>
        </div>

        <div class="dl-title">Driver Joining Letter</div>

        <div class="dl-body">
            <p>Dear <strong>{{ $d['name'] }}</strong>,</p>
            <p>We are pleased to confirm your engagement as a <strong>{{ $d['category'] }} Driver</strong> with SR Logistics, effective <strong>{{ $d['doj'] }}</strong>. Your appointment is governed by the terms communicated at the time of selection and the company's driver policy.</p>

            <table class="dl-tbl">
                <tr><td>Driver Name</td><td>{{ $d['name'] }}</td></tr>
                <tr><td>Driver Code</td><td>{{ $d['driver_code'] }}</td></tr>
                <tr><td>Contact No</td><td>{{ $d['contactno'] }}</td></tr>
                <tr><td>Category</td><td>{{ $d['category'] }}</td></tr>
                <tr><td>Date of Joining</td><td>{{ $d['doj'] }}</td></tr>
                <tr><td>Driving Licence</td><td>{{ $d['licence_no'] }} (valid to {{ $d['licence_expiry'] }})</td></tr>
                <tr><td>Allocated Vehicle</td><td>{{ $d['vehicle'] }}</td></tr>
                <tr><td>Hisab Category</td><td>{{ $d['hisab'] }}</td></tr>
            </table>

            <p>You are required to operate the allocated vehicle responsibly, maintain valid documentation at all times, and comply with all transport regulations. Trip allowances (bhatta) will be settled per the company hisab schedule.</p>
            <p>We welcome you to the team and look forward to a safe and productive association.</p>
        </div>

        <div class="dl-sign">
            <div><div class="line"></div>Authorised Signatory<br>SR Logistics</div>
            <div><div class="line"></div>Received &amp; Accepted<br>{{ $d['name'] }}</div>
        </div>

        <div class="dl-foot">SR Logistics · Guwahati, Assam · This is a system-generated letter from the Driver V2 module.</div>
    </div>
</body>
</html>
