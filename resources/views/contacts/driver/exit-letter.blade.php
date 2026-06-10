<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Exit & Clearance Form - {{ $contact->organisation?->name ?? 'SR Logistics' }}</title>
    <link rel="stylesheet" href="{{ asset('css/Contacts/Driver/exit-letter.css?v=1.0') }}">
</head>
<body>

    <div class="print-btn">
        <button type="button" id="printExitLetterBtn" class="btn btn-success">Print</button>
    </div>

    <div class="container">

        <div class="header">
            <h1>{{ $contact->organisation?->name ?? '' }}</h1>
            <p>{{ $contact->organisation?->address ?? '' }}</p>
            <h2 style="background: none; border: none; margin-top: 10px;">DRIVER EXIT & CLEARANCE FORM</h2>
        </div>

        <h2>1. Driver Details</h2>
        <div class="grid-container">
            <div class="field">
                <span class="label">Name:</span> <span class="underline">{{ $contact->contact_name ?? '' }}</span>
            </div>
            <div class="field">
                <span class="label">Driver Code:</span> <span class="underline">{{ $contact->contact_code ?? '' }}</span>
            </div>
            <div class="field">
                <span class="label">DL No.:</span> <span class="underline">{{ optional($contact->driverinfo)->driving_licence_no ?? '' }}</span>
            </div>
            <div class="field">
                <span class="label">Mobile No.:</span> <span class="underline">{{ $contact->phone ?? '' }}</span>
            </div>
            <div class="field">
                <span class="label">Date of Joining:</span> <span class="underline">{{ $contact->doj ? \Carbon\Carbon::parse($contact->doj)->format('d/m/Y') : '-' }}</span>
            </div>
            <div class="field">
                <span class="label">Last Working Date:</span> <span class="underline">
                    {{ $contact->employeeExitDetail?->exit_date
                        ? \Carbon\Carbon::parse($contact->employeeExitDetail->exit_date)->format('d/m/Y')
                        : '' }}
                </span>
            </div>
        </div>

        <div class="field">
            <span class="label">Reason for Exit:</span> {{ $contact->employeeExitDetail?->exit_reason ?? '' }}
        </div>

        <h2>2. Notice Period</h2>
        <div class="checkbox-group">
        [ ] 30 Days' Notice Served &nbsp;&nbsp;&nbsp; [ ] Notice Not Served (Salary to be deducted)
        </div>

        <h2>3. Asset Return & Clearance Checklist</h2>

        @if($contact->employeeAssets->isNotEmpty())
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Asset Details / Number</th>
                    <th>Returned (Yes/No)</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
                @foreach($contact->employeeAssets as $asset)
                    <tr>
                        <td>{{ $asset->asset->name ?? '' }}</td>
                        <td>{{ $asset->asset->asset_no ?? '' }}</td>
                        <td>{{ $asset->revoke_date ? 'Yes' : 'No' }}</td>
                        <td>{{ $asset->comment ?? '' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @endif

        <h2>4. Finance / Settlement</h2>
        <div class="field">[ ] Full & Final Settlement Done</div>
        <div class="field"><span class="label">Pending Recovery Amount:</span> Rs. __________</div>
        <div class="field">[ ] Advance / Fuel / Asset Recovery Adjusted</div>

        <div class="page-break"></div>

        <h2>5. HR / Admin Clearance</h2>
        <table>
            <thead>
                <tr>
                    <th>Department</th>
                    <th>Cleared (Yes/No)</th>
                    <th>Signature</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($departments as $dept)
                <tr>
                    <td>{{ $dept->name }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="footer-section">
            <p><strong>A. Confidentiality Survival Clause:</strong> Confidentiality obligations shall continue even after exit from the company.</p>
            <p><strong>B. Vehicle / Asset Handover:</strong> All company vehicles, tyres, fuel cards, FASTag, and documents returned: Yes / No</p>
            <p>I confirm that I have returned all company vehicles, assets, and documents and have no further claims except as mentioned above.</p>
            <p>I confirm that after the above settlement, I have no further claims against {{ $contact->organisation?->name ?? 'SR LOGISTICS' }}.</p>
        </div>

        <div class="signature-grid">
            <div><div class="sig-line">Driver Signature</div> <p>Date: </p></div>
            <div><div class="sig-line">Authorized Signatory</div> <p style="text-align: center;">For {{ $contact->organisation?->name ?? 'SR LOGISTICS' }} (Signature & Seal)</p></div>
        </div>

    </div>

    <script src="{{ asset('js/Contacts/Driver/exit-letter.js?v=1.0') }}"></script>
</body>
</html>
