<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Letter - SR Logistics</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.5;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .page {
            width: 210mm;
            min-height: 297mm;
            padding: 20mm;
            margin: 10mm auto;
            border: 1px solid #ddd;
            background: #fff;
            box-sizing: border-box;
            page-break-after: always;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 24pt;
            text-transform: uppercase;
        }
        .header h2 {
            margin: 0;
            font-size: 18pt;
        }
        .address {
            text-align: center;
            font-size: 10pt;
            margin-bottom: 30px;
        }
        .title {
            text-align: center;
            text-decoration: underline;
            font-weight: bold;
            font-size: 14pt;
            margin-bottom: 30px;
        }
        .date-section {
            text-align: right;
            margin-bottom: 20px;
        }
        .content-section {
            margin-bottom: 15px;
        }
        .terms-list {
            list-style-type: none;
            padding: 0;
        }
        .terms-list li {
            margin-bottom: 10px;
            text-align: justify;
        }
        .underline {
            display: inline-block;
            border-bottom: 1px solid #000;
            min-width: 200px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
            font-size: 10pt;
        }
        .signature-section {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
        }
        .thumb-box {
            width: 100px;
            height: 100px;
            border: 1px solid #000;
            margin-top: 10px;
        }
        
        
        .print-btn {
            position: fixed;
            top: 20px;
            right: 30px;
            z-index: 999;
        }
        
        .print-btn button {
            padding: 8px 16px;
            font-size: 14px;
            cursor: pointer;
        }
        
        @media print {
            .print-btn {
                display: none;
            }
            .page {
                border: none;
                margin: 0;
            }
        }
    </style>
</head>
<body>
    
    <div class="print-btn">
        <button onclick="printPage()" class="btn btn-success">Print</button>
    </div>

    <div class="page">
                                    
        <div class="header">
            <h1>{{ $contact->organisation?->name ?? '' }}</h1> 
            <h2>{{ $contact->organisation?->short_name ?? '' }}</h2>  
        </div>
        
        <div class="address">{{ $contact->organisation?->address ?? '' }}</div>

        <div class="title">APPOINTMENT CUM JOINING LETTER </div>

        <div class="date-section">Date: {{ $contact->doj ? \Carbon\Carbon::parse($contact->doj)->format('d/m/Y') : '-' }} </div>

        <div class="content-section">
            To, <br>
            Mr./Ms. <span class="underline">{{ $contact->contact_name ?? '' }}</span> 
        </div>
        
        @php
                                    
            $branch = $contact->work_type === 'Office Work'
                    ? $contact->officeBranch
                    : $contact->serviceCenterBranch;

            $department = $contact->work_type === 'Office Work'
                        ? $contact->officeDepartment
                        : $contact->serviceCenterDepartment;

            $designation = $contact->work_type === 'Office Work'
                        ? $contact->officeDesignation
                        : $contact->serviceCenterDesignation;
            
            
        @endphp

        <p>
            This is to confirm that you are appointed as <span class="underline">{{ $designation->name ?? '-' }}</span> 
            with {{ $contact->organisation?->name ?? '' }}, and your employment shall commence from 
            {{ $contact->doj ? \Carbon\Carbon::parse($contact->doj)->format('d/m/Y') : '-' }} 
        </p>

        <strong>Terms & Conditions:</strong> <ul class="terms-list">
            <li>1. <strong>Initial Trial Period (30 Days):</strong> On joining, you will be under a 30-day trial period. [cite: 11] During this period, your performance, discipline, and suitability will be evaluated. [cite: 12] The company may decide to continue or discontinue your services based on this evaluation. [cite: 13]</li>
            <li>2. <strong>Nature of Employment:</strong> This is full-time employment, and you shall work exclusively for SR LOGISTICS. [cite: 14]</li>
            <li>3. <strong>Salary:</strong> Your monthly salary shall be Rs. <span class="underline">{{ $contact->salaries->isNotEmpty() ? $contact->salaries->first()->basic_pay : '' }}</span> subject to statutory deductions as per Indian laws. [cite: 15]</li>
            <li>4. <strong>Work Location & Hours:</strong> Your place of work and working hours shall be as per company and transport operational requirements. [cite: 16]</li>
            <li>5. <strong>Background Verification Clause:</strong> This employment is subject to verification of documents and background. Any discrepancy may lead to termination. [cite: 17]</li>
            <li>6. <strong>Duties & Discipline:</strong> You must perform your duties honestly and follow company rules and instructions. [cite: 18]</li>
            <li>7. <strong>Company Property & Responsibility:</strong> You are responsible for company vehicles, fuel, documents, and any property assigned. [cite: 19] Loss or damage due to negligence may be recovered as per law. [cite: 20]</li>
            <li>8. <strong>Leave Policy:</strong> Any planned leave must be informed and approved at least 15 days in advance. [cite: 21] Unauthorized absence may lead to salary deduction or disciplinary action. [cite: 22]</li>
            <li>9. <strong>Transferability Clause:</strong> The employee may be transferred to any branch, location, or role based on business requirements. [cite: 23]</li>
            <li>10. <strong>Confidentiality:</strong> You shall not disclose any company or customer information during or after employment. [cite: 24]</li>
            <li>11. <strong>Non-Solicitation / Poaching Clause:</strong> The employee shall not solicit company drivers, customers, or vendors for competing business during employment and for <span class="underline" style="min-width: 50px;"></span> months after exit. [cite: 25]</li>
            <li>12. <strong>Notice Period:</strong> You must give 30 days prior written notice before leaving the company. [cite: 26] If the notice period is not served, salary equivalent to the unserved notice period shall be deducted from the final settlement, as permitted by law. [cite: 27]</li>
            <li>13. <strong>Termination:</strong> The company may terminate services without notice in case of misconduct, Negligence, or breach of company rules. [cite: 28, 29]</li>
        </ul>
    </div>

    <div class="page">
        <ul class="terms-list">
            <li>14. <strong>Governing Law:</strong> This appointment shall be governed by the laws of India and subject to jurisdiction of local courts. [cite: 30]</li>
        </ul>

        <p><strong>Asset Allocation / Tagging (If Applicable):</strong> [cite: 31]</p>
        
        @if($contact->employeeAssets->isNotEmpty())
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Asset Type</th> 
                    <th>Asset Details / Number</th>
                    <th>Condition</th>
                    <th>Date Issued</th>
                    <th>Employee Signature</th>
                </tr>
            </thead>
            <tbody>
                @foreach($contact->employeeAssets as $asset)
                    <tr>
                        <td>{{ $asset->asset->type ?? '' }}</td>
                        <td>{{ $asset->asset->name ?? '' }} / {{ $asset->asset->asset_no ?? '' }}</td>
                        <td>{{ $asset->comment ?? '' }}</td>
                        <td>{{ $asset->created_at ? \Carbon\Carbon::parse($asset->created_at)->format('d/m/Y') : '-' }}</td>
                        <td>&nbsp;</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @endif
        

        <p style="text-align: justify;">
            The above assets are provided for official use only. The employee shall take proper care of the assets and return them in good condition at the time of resignation, termination, or as demanded by the company. [cite: 33] Any loss or damage due to negligence may be recovered from the employee as permitted by law. [cite: 34]
        </p>

        <table>
            <thead>
                <tr>
                    <th>Employee Signature</th> <th>Left Thumb Impression</th>
                    <th>Right Thumb Impression</th>
                </tr>
            </thead>
            <tbody>
                <tr style="height: 100px;">
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>

        <div style="margin-top: 50px; text-align: right;">
            <p><strong>For {{ $contact->organisation?->name ?? '' }} {{-- strtoupper($contact->organisation?->name ?? '') --}}</strong></p> <br><br>
            <p>Authorized Signatory & Seal Date: <span class="underline"></span></p> 
        </div>
    </div>

</body>

<script>
    function printPage() {
        window.print();
    }
</script>

</html>