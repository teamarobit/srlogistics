<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Joining Letter — {{ $e['name'] }}</title>
    {{-- Standalone page: links its own CSS in its own <head> (does NOT extend layouts.app) --}}
    <link rel="stylesheet" href="{{ asset('css/V2/employee/joining-letter.css?v=1.0') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
@php $latestSalary = optional($contact->salaries)->first(); @endphp
<body data-letter-seen="1" data-letter-type="joining-letter" data-contact-id="{{ $contact->id }}" data-seen-url="{{ route('contact.v2.employee.letter.seen') }}">
    <button class="print-btn" onclick="window.print()">🖨 Print</button>
    <div class="jl-sheet">
        <div class="jl-head">
            <div class="jl-brand">{{ $contact->organisation->name ?? 'SR Logistics' }}<small>Fleet &amp; Transport Services</small></div>
            <div class="jl-meta">
                Ref: SRL/HR/JL/{{ str_pad($e['id'], 4, '0', STR_PAD_LEFT) }}<br>
                Date: {{ \Carbon\Carbon::parse($e['doj'])->format('d M Y') }}
            </div>
        </div>

        <div class="jl-title">Letter of Appointment / Joining</div>

        <div class="jl-row">Dear <b>{{ $e['name'] }}</b>,</div>
        <div class="jl-row">
            With reference to your application and the subsequent interview, we are pleased to appoint you
            in the position of <b>{{ $e['designation'] }}</b> in the <b>{{ $e['department'] }}</b> department
            at our <b>{{ $e['branch'] }}</b> office under the <b>{{ $e['work_type'] }}</b> category, effective
            <b>{{ \Carbon\Carbon::parse($e['doj'])->format('d M Y') }}</b>.
        </div>

        <table class="jl-table">
            <tr><th style="width:38%;">Employee Code</th><td>{{ $e['contactno'] }}</td></tr>
            <tr><th>Designation</th><td>{{ $e['designation'] }}</td></tr>
            <tr><th>Department</th><td>{{ $e['department'] }}</td></tr>
            <tr><th>Work Type</th><td>{{ $e['work_type'] }}</td></tr>
            <tr><th>Branch / Posting</th><td>{{ $e['branch'] }}</td></tr>
            <tr><th>Date of Joining</th><td>{{ \Carbon\Carbon::parse($e['doj'])->format('d M Y') }}</td></tr>
            <tr><th>Gross Salary (per month)</th><td>{{ $latestSalary ? '₹'.number_format((float)$latestSalary->basic_pay).' (Basic) + applicable allowances' : 'As per offer' }}</td></tr>
        </table>

        <div class="jl-row">
            Your appointment is governed by the company's terms of service, code of conduct and the policies
            in force. We look forward to a long and mutually rewarding association.
        </div>

        <div class="jl-sign">
            <div class="line">Authorised Signatory<br><span style="font-size:11px;">{{ $contact->organisation->name ?? 'SR Logistics' }}</span></div>
            <div class="line">Employee Signature<br><span style="font-size:11px;">{{ $e['name'] }}</span></div>
        </div>

        <div class="jl-foot">This is a system-generated letter from {{ $contact->organisation->name ?? 'SR Logistics' }} HR.</div>
    </div>
    <script src="{{ asset('js/V2/employee.js?v=2.0') }}"></script>
</body>
</html>
