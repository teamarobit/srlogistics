<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Handover & Guarantor Agreement - {{ $contact->organisation?->name ?? '' }}</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.3; color: #333; margin: 0; padding: 20px; }
        .container { max-width: 850px; margin: auto; border: 1px solid #ccc; padding: 30px; }
        
        /* Header Section */
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .header h1 { margin: 0; font-size: 22px; text-transform: uppercase; }
        .header p { margin: 5px 0; font-size: 11px; }
        
        h2 { font-size: 14px; text-transform: uppercase; background: #f2f2f2; padding: 5px 10px; border: 1px solid #333; margin-top: 15px; margin-bottom: 10px; }
        
        /* Form Grids */
        .grid-container { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 10px; }
        .field { margin-bottom: 6px; font-size: 12px; }
        .label { font-weight: bold; }
        .underline { border-bottom: 1px solid #000; display: inline-block; min-width: 180px; height: 14px; vertical-align: bottom; }

        /* Terms Section */
        .terms { font-size: 11px; text-align: justify; margin: 15px 0; }
        .terms ol { padding-left: 20px; margin: 0; }
        .terms li { margin-bottom: 4px; }

        /* Tables */
        table { width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 11px; }
        table, th, td { border: 1px solid #333; }
        th, td { padding: 6px; text-align: left; }
        th { background-color: #f9f9f9; }

        /* Driver Media Box */
        .media-box { width: 100%; border-collapse: collapse; margin-top: 15px; }
        .media-box td { width: 33.33%; height: 100px; text-align: center; vertical-align: top; padding: 5px; font-size: 10px; font-weight: bold; }
        .stamp-area { border: 1px dashed #999; height: 80px; margin-top: 5px; }

        /* Signatures */
        .sig-section { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-top: 20px; font-size: 12px; }
        .sig-line { border-top: 1px solid #000; padding-top: 5px; margin-top: 35px; font-weight: bold; }

        @media print {
            .container { border: none; padding: 0; }
            .page-break { page-break-before: always; }
        }
    </style>
</head>
<body>
    
    <div class="print-btn">
        <button onclick="printPage()" class="btn btn-success">Print</button>
    </div>

    <div class="container">
        <div class="header">
            <h1>{{ $contact->organisation?->name ?? '' }} ({{ $contact->organisation?->short_name ?? '' }})</h1> 
            <p>{{ $contact->organisation?->address ?? '' }}</p> 
            <h3 style="margin: 10px 0 0 0; font-size: 16px;">DRIVER RESPONSIBILITY, VEHICLE HANDOVER & GUARANTOR AGREEMENT</h3> 
        </div>
    
        <h2>1. Driver Details</h2> 
        <div class="grid-container">
            <div class="field"><span class="label">Full Name:</span> <span class="underline">{{ $contact->contact_name ?? '' }}</span></div> 
            <!--<div class="field"><span class="label">Father's Name:</span> <span class="underline"></span></div> -->
            <div class="field"><span class="label">Mobile No.:</span> <span class="underline">{{ $contact->phone ?? '' }}</span></div> 
            <div class="field"><span class="label">Home Contact No.:</span> <span class="underline">{{ optional($contact->driverinfo)->guarantor_phone ?? '' }}</span></div> 
            <div class="field"><span class="label">Aadhaar No.:</span> <span class="underline">{{ optional($contact->driverinfo)->aadhaar_no ?? '' }}</span></div> 
            <div class="field"><span class="label">Driver Code / Area:</span> <span class="underline">{{ $contact->contact_code ?? '' }}</span></div> 
            <div class="field"><span class="label">DL No.:</span> <span class="underline">{{ optional($contact->driverinfo)->driving_licence_no ?? '' }}</span></div> 
            <div class="field"><span class="label">DL Validity:</span> <span class="underline">{{ optional($contact->driverinfo)->licence_expiry_date ?? '' }}</span></div> 
        </div>
        @php
            $presentAddress = $contact->coaddresses->where('type','Present')->first();
        @endphp
        <div class="field"><span class="label">Full Address:</span> 
            <span class="underline" style="min-width: 80%;">
                @if($presentAddress)
                    {{ $presentAddress->address ?? '' }},
                    {{ $presentAddress->city->name ?? '' }},
                    {{ $presentAddress->state->name ?? '' }},
                    {{ $presentAddress->zipcode ?? '' }}
                @endif
            </span>
        </div> 
    
        <h2>2. Vehicle Details</h2> 
        <div class="grid-container">
            <div class="field"><span class="label">Vehicle Number:</span> <span class="underline"></span></div> 
            <div class="field"><span class="label">Vehicle Type / Model:</span> <span class="underline"></span></div> 
            <div class="field"><span class="label">Odometer Reading:</span> <span class="underline"></span></div> 
            <div class="field"><span class="label">Other:</span> <span class="underline"></span></div> 
        </div>

        <div class="terms">
            <p>I acknowledge receipt of the vehicle and accessories in good working condition. I accept full responsibility under the following terms:</p>
            <ol>
                <li><strong>Compliance:</strong> Drive safely and follow all traffic rules and Motor Vehicles Act.</li>
                <li><strong>Liability:</strong> Liable for loss, damage, or legal issues due to negligence or intoxication.</li>
                <li><strong>No Unauthorized Driving:</strong> Only the assigned driver may use the vehicle.</li>
                <li><strong>Monitoring:</strong> Consent to GPS tracking and CCTV monitoring.</li>
                <li><strong>Maintenance:</strong> Safely maintain keys, FASTag, fuel cards, and documents.</li>
                <li><strong>Intimation:</strong> Report accidents, theft, or breakdowns immediately to Hyderabad office.</li>
                <li><strong>Cooperation:</strong> Cooperate with insurance surveyors and police; failure may affect claims.</li>
                <li><strong>Notice:</strong> Provide 30 days' written notice before leaving company.</li>
                <li><strong>Absconding:</strong> Consecutive absence without intimation leads to legal action and recovery.</li>
                <li><strong>Dual Work:</strong> No other transport work allowed without written permission.</li>
                <li><strong>Condition Record:</strong> Handover condition confirmed via photos/videos in my presence.</li>
            </ol>
        </div>
    
        <div class="page-break"></div>

        <table class="media-box">
            <tr>
                <td>Driver Passport Size Photo <div class="stamp-area"></div></td> 
                <td>Driver Left Thumb Impression <div class="stamp-area"></div></td>
                <td>Driver Right Thumb Impression <div class="stamp-area"></div></td>
            </tr>
        </table>
    
        <h2>3. Asset Checklist Received</h2>
        
        @if($contact->employeeAssets->isNotEmpty())
        <table>
            <thead>
                <tr>
                    <th>Asset Item</th> 
                    <th>Asset ID</th>
                    <th>Issue Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($contact->employeeAssets as $asset)
                <tr>
                    <td>{{ $asset->asset->name ?? '' }} / {{ $asset->asset->asset_no ?? '' }}</td>
                    <td>{{ $asset->asset->asset_no ?? '' }}</td>
                    <td>{{ $asset->created_at ? \Carbon\Carbon::parse($asset->created_at)->format('d/m/Y') : '-' }}</td>
                </tr> 
                @endforeach
            </tbody>
        </table>
        @endif
        
        
        <h2>4. Tyre Details</h2>
        <table>
            <thead>
                <tr>
                    <th>Tyre Category</th> 
                    <th>Tyre Type</th> 
                    <th>Tyre No./Serial No. / Details</th>
                    <th>Condition</th>
                </tr>
            </thead>
            <tbody>
                <tr><td>Mounted</td><td>Radial</td><td>ABC123</td><td>New</td></tr> 
                
            </tbody>
        </table>
        
        <p style="font-size: 12px; margin-top: 10px;">Original Driving License Submitted: [ ] Yes [ ] No</p>

        <h2>5. Guarantor Details</h2>
        <div class="grid-container">
            <div class="field"><span class="label">Full Name:</span> <span class="underline">{{ optional($contact->driverinfo)->guarantor_name ?? '' }}</span></div>
            <div class="field"><span class="label">Mobile No.:</span> <span class="underline">{{ optional($contact->driverinfo)->guarantor_phone ?? '' }}</span></div>
            <div class="field" style="grid-column: span 2;"><span class="label">Address:</span> <span class="underline" style="min-width: 80%;"></span></div>
            <div class="field"><span class="label">Relationship with Driver:</span> <span class="underline"></span></div>
        </div>
        <p style="font-size: 11px; font-style: italic;">I, the undersigned guarantor, confirm that the above driver is known to me and agree to support {{ $contact->organisation?->name ?? '' }} in recovery of dues or liabilities.</p>
    
        <div class="sig-section">
            <div>
                <div class="sig-line">Driver Signature</div>
                <p>Date: ________________</p>
            </div>
            <div>
                <div class="sig-line">Guarantor Signature</div>
                <p>Date: ________________</p>
            </div>
        </div>
    
        <div style="margin-top: 35px; border-top: 1px dashed #333; padding-top: 15px;">
            <div style="float: right; text-align: center; width: 250px;">
                <div class="sig-line">Authorized Signatory</div>
                <p style="font-size: 10px;">For {{ $contact->organisation?->name ?? '' }} (Seal)</p>
            </div>
            <div style="clear: both;"></div>
        </div>
    </div>

</body>

<script>
    function printPage() {
        window.print();
    }
</script>

</html>