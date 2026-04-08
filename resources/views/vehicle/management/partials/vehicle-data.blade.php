<div class="card" style="background: #fff; border-radius: 10px;">
    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
                <table class="table table-hover invoice-table mb-0">
                <tbody>
                    <tr>
                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-2 text-success" aria-hidden="true"></i>Owner Name</th>
                        <td class="pt-1 pb-1 ps-2 pe-2">{{ $vehicle['owner_name'] }}</td> 
                    </tr>
                    <tr>
                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-2 text-success" aria-hidden="true"></i>Address</th> 
                        <td class="pt-1 pb-1 ps-2 pe-2">{{ $vehicle['owner_address'] }}</td>
                    </tr>
                    <tr>
                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-2 text-success" aria-hidden="true"></i>Status</th>
                        <td class="pt-1 pb-1 ps-2 pe-2">{{ $vehicle['registration_status'] }}</td>
                    </tr>
                    <tr>
                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-2 text-success" aria-hidden="true"></i>Registration Date</th>
                        <td class="pt-1 pb-1 ps-2 pe-2">{{ $vehicle['registration_date'] }}</td>
                    </tr>
                    
                    <tr>
                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-2 text-success" aria-hidden="true"></i>Fitness Certificate Expiry</th>
                        <td class="pt-1 pb-1 ps-2 pe-2">{{ $vehicle['fitness_expiry'] }}</td>
                    </tr>
                    <tr>
                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-2 text-success" aria-hidden="true"></i>Insurance Expiry</th>
                        <td class="pt-1 pb-1 ps-2 pe-2">{{ $vehicle['insurance_expiry'] }}</td>
                    </tr>
                    <tr>
                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-info-circle text-danger me-2" aria-hidden="true"></i>Tax Expiry</th>
                        <td class="pt-1 pb-1 ps-2 pe-2">{{ $vehicle['tax_expiry'] }}</td>
                    </tr>
                    <tr>
                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-2 text-success" aria-hidden="true"></i>Permit Expiry</th>
                        <td class="pt-1 pb-1 ps-2 pe-2">{{ $vehicle['permit_expiry'] }}</td>
                    </tr>
                    
                    <tr>
                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-2 text-success" aria-hidden="true"></i>PUCC Expiry</th>
                        <td class="pt-1 pb-1 ps-2 pe-2">{{ $vehicle['pucc_expiry'] }}</td>
                    </tr>
                    <tr>
                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-2 text-success" aria-hidden="true"></i>National Permit Expiry</th>
                        <td class="pt-1 pb-1 ps-2 pe-2">{{ $vehicle['national_permit_expiry'] }}</td>
                    </tr>
                    <tr>
                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-2 text-success" aria-hidden="true"></i>Permit Type</th>
                        <td class="pt-1 pb-1 ps-2 pe-2">{{ $vehicle['permit_type'] }}</td> 
                    </tr>
                    <tr>
                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-2 text-success" aria-hidden="true"></i>PUCC Number</th>
                        <td class="pt-1 pb-1 ps-2 pe-2">{{ $vehicle['pucc_no'] }}</td> 
                    </tr>
                    <tr>
                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-2 text-success" aria-hidden="true"></i>Permit Number</th>
                        <td class="pt-1 pb-1 ps-2 pe-2">{{ $vehicle['permit_no'] }}</td>  
                    </tr>
                    <tr>
                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-2 text-success" aria-hidden="true"></i>Insurer</th>
                        <td class="pt-1 pb-1 ps-2 pe-2">{{ $vehicle['insurer'] }}</td>  
                    </tr>
                    <tr>
                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-2 text-success" aria-hidden="true"></i>Insurance Number</th>
                        <td class="pt-1 pb-1 ps-2 pe-2">{{ $vehicle['insurance_no'] }}</td>  
                    </tr>
                    <tr>
                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-2 text-success" aria-hidden="true"></i>Financer</th>
                        <td class="pt-1 pb-1 ps-2 pe-2">{{ $vehicle['financer'] }}</td>  
                    </tr>
                </tbody>
            </table>
            </div>
        </div>
  
        <div class="col-12">
          <div class="table-responsive">
            <table class="table table-hover invoice-table mb-0">
                <tbody>
                    <tr>
                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-2 text-success" aria-hidden="true"></i>Class</th>
                        <td class="pt-1 pb-1 ps-2 pe-2">{{ $vehicle['class'] }}</td>  
                    </tr>
                    <tr>
                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-2 text-success" aria-hidden="true"></i>Body Type</th>
                        <td class="pt-1 pb-1 ps-2 pe-2">{{ $vehicle['body_type'] }}</td>  
                    </tr>
                    <tr>
                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-2 text-success" aria-hidden="true"></i>Fuel Type</th>
                        <td class="pt-1 pb-1 ps-2 pe-2">{{ $vehicle['fuel_type'] }}</td>  
                    </tr>
                    <tr>
                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-2 text-success" aria-hidden="true"></i>Chassis Number Date</th>
                        <td class="pt-1 pb-1 ps-2 pe-2">{{ $vehicle['chassis_no'] }}</td>   
                    </tr>
                    
                    <tr>
                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-2 text-success" aria-hidden="true"></i>Engine Number</th>
                        <td class="pt-1 pb-1 ps-2 pe-2">{{ $vehicle['engine_no'] }}</td>   
                    </tr>
                    <tr>
                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-2 text-success" aria-hidden="true"></i>Manufacturer</th>
                        <td class="pt-1 pb-1 ps-2 pe-2">{{ $vehicle['manufacturer'] }}</td>   
                    </tr>
                    <tr>
                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-2 text-success" aria-hidden="true"></i>Model</th>
                        <td class="pt-1 pb-1 ps-2 pe-2">{{ $vehicle['model'] }}</td>  
                    </tr>
                    <tr>
                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-2 text-success" aria-hidden="true"></i>Norms Type</th>
                        <td class="pt-1 pb-1 ps-2 pe-2">{{ $vehicle['norms_type'] }}</td>
                    </tr>
                    
                    <tr>
                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-2 text-success" aria-hidden="true"></i>Gross Vehicle Weight</th>
                        <td class="pt-1 pb-1 ps-2 pe-2">{{ $vehicle['gross_vehicle_weight'] }}</td>
                    </tr>
                    <tr>
                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-2 text-success" aria-hidden="true"></i>Unladen Weight</th>
                        <td class="pt-1 pb-1 ps-2 pe-2">{{ $vehicle['unladen_weight'] }}</td>
                    </tr>
                    <tr>
                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-2 text-success" aria-hidden="true"></i>Vehicle Category</th>
                        <td class="pt-1 pb-1 ps-2 pe-2">{{ $vehicle['vehicle_category'] }}</td>
                    </tr>
                    <tr>
                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-2 text-success" aria-hidden="true"></i>Wheelbase</th>
                        <td class="pt-1 pb-1 ps-2 pe-2">{{ $vehicle['wheelbase'] }}</td>
                    </tr>
                    <tr>
                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-2 text-success" aria-hidden="true"></i>Commercial FASTag</th>
                        <td class="pt-1 pb-1 ps-2 pe-2">{{ $vehicle['commercial_fastag'] }}</td>
                    </tr>
                    <tr>
                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-2 text-success" aria-hidden="true"></i>FASTag ID</th>
                        <td class="pt-1 pb-1 ps-2 pe-2">{{ $vehicle['fastagId'] }}</td>
                    </tr>
                    <tr>
                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-2 text-success" aria-hidden="true"></i>TID</th>
                        <td class="pt-1 pb-1 ps-2 pe-2">{{ $vehicle['tid'] }}</td>
                    </tr>
                    <tr>
                        <th class="pt-1 pb-1 ps-2 pe-2"><i class="fa fa-check-circle me-2 text-success" aria-hidden="true"></i>FASTag Issue Date</th>
                        <td class="pt-1 pb-1 ps-2 pe-2">{{ $vehicle['fastag_issue_date'] }}</td>
                    </tr>
                </tbody>
            </table>
         </div>
      </div>
    </div>
</div>


