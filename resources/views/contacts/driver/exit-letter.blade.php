<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Exit & Clearance Form - SR Logistics</title>
</head>
<body>
    
    <div class="print-btn">
        <button onclick="printPage()" class="btn btn-success">Print</button>
    </div>

    <div class="container">
    
        <div class="header">
            <h1>{{ $contact->organisation?->name ?? '' }}</h1> 
            <p>{{ $contact->organisation?->address ?? '' }}</p> 
            <h2 style="background: none; border: none; margin-top: 10px;">EMPLOYEE EXIT & CLEARANCE FORM</h2> 
        </div>

        <h2>1. Employee Details</h2> 
        <div class="grid-container">
            <div class="field">
                <span class="label">Name:</span> <span class="underline">{{ $contact->contact_name ?? '' }}</span>
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
            <div class="field">
                <span class="label">Designation:</span> <span class="underline">{{ $designation->name ?? '-' }}</span>
            </div> 
            <div class="field">
                <span class="label">Employee ID:</span> <span class="underline">#EMP{{ $contact->contactno ?? '' }}</span>
            </div> 
            <div class="field">
                <span class="label">Department:</span> <span class="underline">{{ $department->name ?? '-' }}</span>
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
        
        
        

        <h2>4. Finance/Salary Settlement</h2> 
        <div class="field">[ ] Full & Final Settlement Done</div> 
        <div class="field"><span class="label">Pending Recovery Amount:</span> Rs. __________</div> 
        <div class="field">[ ] Notice Period Salary Deducted (if applicable)</div> 
        <div class="field">[ ] Advance/Fuel / Asset Recovery Adjusted</div> 
        <div class="page-break"></div> 
        <h2>5. HR/Admin Clearance</h2> 
        
        
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
                @foreach ($departments as $department)
                <tr>
                    <td>{{ $department->name }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                @endforeach
                
            </tbody>
        </table>

        <div class="footer-section">
            <p><strong>A. Confidentiality Survival Clause:</strong> Confidentiality obligations shall continue even after exit from the company.</p> 
            <p><strong>B. Handover Confirmation:</strong> Data / passwords handed over: Yes / No</p> 
            <p>I confirm that I have returned all company vehicles, assets, documents, and have no further claims except as mentioned above. [cite: 26]</p>
            <p>I confirm that after the above settlement, I have no further claims against SR LOGISTICS. [cite: 27]</p>
        </div>

        <div class="signature-grid">
            <div><div class="sig-line">Employee Signature</div> <p>Date: </p> </div>
            <div><div class="sig-line">Authorized Signatory</div> <p style="text-align: center;">For SR LOGISTICS (Signature & Seal)</p> </div>
        </div>
        
    </div>

</body>
</html>







