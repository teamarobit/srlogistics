<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finalise Bill — Invoice</title>
    <link href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans:400,500,600,700&amp;display=swap" rel="stylesheet">
    <link href="{{ asset('css/trip/bill-finalise.css?v=1.2') }}" rel="stylesheet">
</head>
<body class="bf-body">

    {{-- ── Top action bar ── --}}
    <div class="bf-topbar">
        <a href="{{ route('trip.details', $trip) }}" id="bfBack" class="bf-back"
           data-fallback="{{ route('trip.details', $trip) }}">Back</a>
        <a href="#" id="bfPrint" class="bf-print-btn">Print</a>
    </div>

    {{-- ── Invoice sheet ── --}}
    <div class="bf-sheet">

        {{-- Company / customer header --}}
        <div class="bf-head">
            <div class="bf-head-left">
                <p class="bf-logo">LOGO</p>
                <p class="bf-company">SR Logistics</p>
                <div class="bf-meta">
                    <div>Plot No.: 83</div>
                    <div>Block No.:36/A, 1sr Floor, Autonagar, Hydrabad, Telengana - 500070</div>
                    <div>Phone No.: +91 8907654321</div>
                    <div>Email: sr.logistics@gmail.com</div>
                </div>
            </div>
            <div class="bf-head-right">
                <p class="bf-cust-name">M/s Dhanlaxmi Packaging</p>
                <div class="bf-meta">
                    <div>SY No.: 219.250-A.E.U.AA</div>
                    <div>Channa 36/A, 1sr Floor, Autonagar, Hydrabad, Telengana - 500070</div>
                    <div>GST No.: 36AAGCD3505J1</div>
                </div>
            </div>
        </div>

        {{-- PAN / GST / Bill No / Bill Date --}}
        <table class="bf-table bf-info-table">
            <thead>
                <tr>
                    <th>PAN Number</th>
                    <th>GST Number</th>
                    <th>Bill Number</th>
                    <th>Bill Date</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>ALHPC012987</td>
                    <td>36AAGCD3505J1</td>
                    <td>#0010234</td>
                    <td>12/11/2025</td>
                </tr>
            </tbody>
        </table>

        {{-- Transportation movement --}}
        <table class="bf-table bf-trans-table">
            <thead>
                <tr>
                    <th>CN No.</th>
                    <th>Date</th>
                    <th>Details of Transportation Movement</th>
                    <th>Invoice No.</th>
                    <th>Rpt Date</th>
                    <th>Dly Date</th>
                    <th>Truck No.</th>
                    <th>Vehicle Type</th>
                    <th>Pkgs</th>
                    <th>Wt/MT</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>5622</td>
                    <td>12/11/2025</td>
                    <td>Hydrabad - Bangalore</td>
                    <td>#INV001</td>
                    <td>12/11/2025</td>
                    <td>20/11/2025</td>
                    <td>WB-12-VX1234</td>
                    <td>Large</td>
                    <td>6</td>
                    <td>9</td>
                </tr>
            </tbody>
        </table>

        {{-- Totals --}}
        <table class="bf-totals">
            <tbody>
                <tr>
                    <td class="bf-totals-label">SGST</td>
                    <td class="bf-totals-val">100.00</td>
                </tr>
                <tr>
                    <td class="bf-totals-label">CSGST</td>
                    <td class="bf-totals-val">262.60</td>
                </tr>
                <tr>
                    <td class="bf-totals-label">IGST</td>
                    <td class="bf-totals-val">10.00</td>
                </tr>
                <tr class="bf-grand">
                    <td class="bf-totals-label bf-grand-label">Total Amount</td>
                    <td class="bf-totals-val bf-grand-val">10,000.00</td>
                </tr>
            </tbody>
        </table>

    </div>

    <script src="{{ asset('js/trip/bill-finalise.js?v=1.0') }}"></script>
</body>
</html>
