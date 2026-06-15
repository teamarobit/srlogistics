<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relieving Letter — {{ $e['name'] }}</title>
    {{-- Standalone page: links its own CSS in its own <head> (does NOT extend layouts.app) --}}
    <link rel="stylesheet" href="{{ asset('css/V2/employee/exit-letter.css?v=1.0') }}">
</head>
<body>
    <button class="print-btn" onclick="window.print()">🖨 Print</button>
    <div class="jl-sheet">
        <div class="jl-head">
            <div class="jl-brand">SR Logistics<small>Fleet &amp; Transport Services</small></div>
            <div class="jl-meta">
                Ref: SRL/HR/RL/{{ str_pad($e['id'], 4, '0', STR_PAD_LEFT) }}<br>
                Date: 18 Apr 2026
            </div>
        </div>

        <div class="jl-title">Relieving / Experience Letter</div>

        <div class="jl-row">To Whomsoever It May Concern,</div>
        <div class="jl-row">
            This is to certify that <b>{{ $e['name'] }}</b> (Employee Code <b>{{ $e['contactno'] }}</b>) was
            employed with SR Logistics as <b>{{ $e['designation'] }}</b> in the <b>{{ $e['department'] }}</b>
            department at our <b>{{ $e['branch'] }}</b> office from
            <b>{{ \Carbon\Carbon::parse($e['doj'])->format('d M Y') }}</b> to <b>18 Apr 2026</b>.
        </div>

        <table class="jl-table">
            <tr><th style="width:38%;">Employee Code</th><td>{{ $e['contactno'] }}</td></tr>
            <tr><th>Last Designation</th><td>{{ $e['designation'] }}</td></tr>
            <tr><th>Department</th><td>{{ $e['department'] }}</td></tr>
            <tr><th>Date of Joining</th><td>{{ \Carbon\Carbon::parse($e['doj'])->format('d M Y') }}</td></tr>
            <tr><th>Date of Relieving</th><td>18 Apr 2026</td></tr>
            <tr><th>Reason for Exit</th><td>Resignation — better opportunity</td></tr>
        </table>

        <div class="jl-row">
            During the tenure, the employee's conduct and performance were found to be satisfactory. We wish
            {{ $e['name'] }} success in all future endeavours.
        </div>

        <div class="jl-sign">
            <div class="line">Authorised Signatory<br><span style="font-size:11px;">SR Logistics — HR</span></div>
            <div class="line">Company Seal</div>
        </div>

        <div class="jl-foot">This is a system-generated letter from SR Logistics HR. · Gate 1 design preview — sample data.</div>
    </div>
</body>
</html>
