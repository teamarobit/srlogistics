<?php
  
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use App\Models\Vehicleownership;
use App\Models\Vehiclegroup;
use App\Models\Vehicletype;
use App\Models\Vehicletypesize;
use App\Models\Vehicle;

use App\Models\Vehiclebasicinfo;


use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Hash;
use Auth;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;
use Closure;
use Illuminate\Support\Fluent;
use Illuminate\Database\Eloquent\Builder;

use App\Traits\Useractivity;


class VehiclemanagementController extends Controller
{
    use Useractivity;
    
    public function index(Request $request): View
    {   
        
        $search_number = $request->get('number');
        $search_type = $request->get('type');
        
        
        $query = Vehicle::with([
                            'ownership',
                            'group',
                            'type',
                            'size'
                        ]);
    
        // Filter by vehicle number
        if(!empty($search_number)){
            $query->where('vehicle_no', $search_number);
        }
    
        // Filter by vehicle type
        if(!empty($search_type)){
            $query->where('vehicletype_id', $search_type);
        }
    
        $datas = $query->orderBy('id','desc')
                       ->paginate(10)
                       ->withQueryString();
                       
                        
        $vehicletype = Vehicletype::orderBy('name')->get();
        
        //dd($datas->toArray());
        
        return view('vehicle.management.index', compact('datas','vehicletype','search_number','search_type'));
        
    }
    
    
    public function fetchVehicleInfo(Request $request)
    {
        $request->validate([
            'vc_no' => 'nullable'
        ]);
    
        $vehicle = [
            "vehicle_number" => $request->vc_no ?? 'WB21AB1234',
            
            "owner_name" => "Mohammad Hafiz",
            "owner_address" => "H.NO.62, Vill Hathipur Chittu, PS Kundarki, Teh. Bilari, Moradabad",
            "owner_phone" => "9588416786",
            
            "registration_date" => date('d/m/Y', strtotime('2016-03-11')),
            "registration_status" => "Active",
            //"rto" => "Moradabad RTO",
            
            "manufacturer" => "Tata Motors Ltd.",
            "model" => "LPT1613/62TCBSII",
            
            "vehicle_class" => "Goods Carrier (HGV)",
            "vehicle_category" => "HGV",
            "body_type" => "Truck (Closed Body)",
            "fuel_type" => "Diesel",
            "emission_norms" => "EURO 2",
            
            "engine_no" => "41L84194947",
            "chassis_no" => "MAT388062E5P14305",
            
            "gross_vehicle_weight" => 18500,
            "unladen_weight" => 8850,
            "wheelbase" => 6200,
            
            "permit_type" => "National Permit (Heavy Goods Vehicle)",
            "permit_no" => "UP/21/112/GOOD/2017/26595",
            "permit_expiry" => date('d/m/Y', strtotime('2025-03-11')),
            "national_permit_expiry" => date('d/m/Y', strtotime('2025-03-15')),
            
            "fitness_expiry" => date('d/m/Y', strtotime('2029-04-10')),
        
            "insurer" => "The New India Assurance Company Ltd.",
            "insurance_no" => "34040131240100004570",
            "insurance_expiry" => date('d/m/Y', strtotime('2026-04-10')),
            
            "pucc_no" => "UP02101060016371",
            "pucc_expiry" => date('d/m/Y', strtotime('2010-03-19')),
            
            "tax_expiry" => date('d/m/Y', strtotime('2026-02-28')),
            
            "commercial_fastag" => 'Yes',
            "fastagId" => "34161FA820328EE831791140",
            "tid" => "E200341201360400001A47AA8",
            "fastag_issue_date" => date('d/m/Y', strtotime('2024-04-02')),
            
            'maker_model' => 'TATA LPT 1613',
            "financer" => "Kogta Financial (I) Ltd.",
            
            'class' => 'Goods Carrier (HGV)',
            
            'norms_type' => 'EURO 2',
        ];
        
        
        // Vehiclebasicinfo
        $vehicleBasicInfo = Vehiclebasicinfo::where('vehicle_number', $vehicle['vehicle_number'])->first();

        if (!$vehicleBasicInfo) {
            $vehicleBasicInfo = new Vehiclebasicinfo();
        }

        // Now common assignment (for both insert & update)
        $vehicleBasicInfo->vehicle_number = $vehicle['vehicle_number'];
        $vehicleBasicInfo->owner_name = $vehicle['owner_name'];
        $vehicleBasicInfo->owner_address = $vehicle['owner_address'];
        $vehicleBasicInfo->owner_phone = $vehicle['owner_phone'];
        
        $vehicleBasicInfo->registration_date = $vehicle['registration_date'] ? \Carbon\Carbon::createFromFormat('d/m/Y', $vehicle['registration_date'])->format('Y-m-d') : null;
        $vehicleBasicInfo->registration_status = $vehicle['registration_status'];
        
        $vehicleBasicInfo->manufacturer = $vehicle['manufacturer'];
        $vehicleBasicInfo->model = $vehicle['model'];
        
        $vehicleBasicInfo->vehicle_class = $vehicle['vehicle_class'];
        $vehicleBasicInfo->vehicle_category = $vehicle['vehicle_category'];
        $vehicleBasicInfo->body_type = $vehicle['body_type'];
        $vehicleBasicInfo->fuel_type = $vehicle['fuel_type'];
        $vehicleBasicInfo->emission_norms = $vehicle['emission_norms'];
        
        $vehicleBasicInfo->engine_no = $vehicle['engine_no'];
        $vehicleBasicInfo->chassis_no = $vehicle['chassis_no'];
        
        $vehicleBasicInfo->gross_vehicle_weight = $vehicle['gross_vehicle_weight'];
        $vehicleBasicInfo->unladen_weight = $vehicle['unladen_weight'];
        $vehicleBasicInfo->wheelbase = $vehicle['wheelbase'];
        
        $vehicleBasicInfo->permit_type = $vehicle['permit_type'];
        $vehicleBasicInfo->permit_no = $vehicle['permit_no'];
        $vehicleBasicInfo->permit_expiry = $vehicleBasicInfo->permit_expiry = $vehicle['permit_expiry'] ? \Carbon\Carbon::createFromFormat('d/m/Y', $vehicle['permit_expiry'])->format('Y-m-d') : null;
        $vehicleBasicInfo->national_permit_expiry = $vehicleBasicInfo->national_permit_expiry = $vehicle['national_permit_expiry'] ? \Carbon\Carbon::createFromFormat('d/m/Y', $vehicle['national_permit_expiry'])->format('Y-m-d') : null;
        
        $vehicleBasicInfo->fitness_expiry = $vehicleBasicInfo->fitness_expiry = $vehicle['fitness_expiry'] ? \Carbon\Carbon::createFromFormat('d/m/Y', $vehicle['fitness_expiry'])->format('Y-m-d') : null;
        
        $vehicleBasicInfo->insurer = $vehicle['insurer'];
        $vehicleBasicInfo->insurance_no = $vehicle['insurance_no'];
        $vehicleBasicInfo->insurance_expiry = $vehicleBasicInfo->insurance_expiry = $vehicle['insurance_expiry'] ? \Carbon\Carbon::createFromFormat('d/m/Y', $vehicle['insurance_expiry'])->format('Y-m-d') : null;
        
        $vehicleBasicInfo->pucc_no = $vehicle['pucc_no'];
        $vehicleBasicInfo->pucc_expiry = $vehicleBasicInfo->pucc_expiry = $vehicle['pucc_expiry'] ? \Carbon\Carbon::createFromFormat('d/m/Y', $vehicle['pucc_expiry'])->format('Y-m-d') : null;
        
        $vehicleBasicInfo->tax_expiry = $vehicleBasicInfo->tax_expiry = $vehicle['tax_expiry'] ? \Carbon\Carbon::createFromFormat('d/m/Y', $vehicle['tax_expiry'])->format('Y-m-d') : null;
        
        $vehicleBasicInfo->commercial_fastag = $vehicle['commercial_fastag'];
        $vehicleBasicInfo->fastagId = $vehicle['fastagId'];
        $vehicleBasicInfo->tid = $vehicle['tid'];
        $vehicleBasicInfo->fastag_issue_date = $vehicleBasicInfo->fastag_issue_date = $vehicle['fastag_issue_date'] ? \Carbon\Carbon::createFromFormat('d/m/Y', $vehicle['fastag_issue_date'])->format('Y-m-d') : null;

        $vehicleBasicInfo->maker_model = $vehicle['maker_model'];
        $vehicleBasicInfo->financer = $vehicle['financer'];
        
        $vehicleBasicInfo->class = $vehicle['class'];
        $vehicleBasicInfo->norms_type = $vehicle['norms_type'];
        
        $vehicleBasicInfo->save();
        
        

        
        // return response()->json([
        //     "status" => true,
        //     "message" => "Vehicle details fetched successfully",
        //     "timestamp" => now()->toISOString(),
        //     "data" => $vehicle
        // ]);
    
        return view('vehicle.management.partials.vehicle-data', compact('vehicle'));
    }

    
    
    public function create()
    {   
        $vehicleownership = Vehicleownership::orderBy('name')->get(); 
        $vehiclegroup = Vehiclegroup::where('status', 'Active')->orderBy('name')->get();
        $vehicletype = Vehicletype::where('status', 'Active')->orderBy('name')->get();
        $vehiclesize = Vehicletypesize::orderBy('name')->get();
        
        return view('vehicle.management.create',compact('vehicleownership','vehiclegroup','vehicletype','vehiclesize'));
    }
    
    
    public function store(Request $request)
    {
        // Step 1: Validate main fields and dynamic rows
        $validator = Validator::make($request->all(), [
            'vc_no'         => 'required|unique:vehicles,vehicle_no',
            'ownership_type' => 'required|in:Own,Rental',
            //'ownership'     => 'required|exists:vehicleownerships,id',
            'vehicle_group' => 'required|exists:vehiclegroups,id', 
            'vehicle_type'  => 'required|exists:vehicletypes,id',
            'vehicle_size'  => 'required|exists:vehicletypesizes,id',
            'category'      => 'required|in:Local,Line',
            'status'        => 'required|in:Active,Inactive',
            'mounted_tyre_count' => 'required|in:6,10',
        ], [
            'required' => 'This field is required.',
            'max'      => 'Maximum 100 characters allowed.',
            'unique'   => 'This value already exists.',
            'numeric'  => 'Only numeric values are allowed.',
            'min'      => 'Value must be at least :min.',
            'max'      => 'Maximum allowed value is :max.',
            'in'       => 'Invalid selection.',
        ]);
    
    
        if ($validator->fails()) {
            // \Log::error('Validation failed', [
            //     'errors' => $validator->errors()->toArray(),
            //     //'input' => request()->all(), // optional: log the input data for context
            // ]);
    
            return response()->json([
                'success' => false,
                'data' => $validator->errors(),
                'message' => 'Please check validation errors.'
            ], 422);
        }
        
    
        try {
            
            $vehicle = null;
            
            DB::transaction(function () use ($request, &$vehicle) {
                
                $vehicle = new Vehicle(); 
                $vehicle->organisation_id = optional(Auth::user()->organisation)->id;
                $vehicle->vehicle_no = $request->vc_no;
                $vehicle->ownership_type = $request->ownership_type;
                //$vehicle->vehicleownership_id = $request->ownership;
                $vehicle->vehiclegroup_id = $request->vehicle_group;
                $vehicle->vehicletype_id = $request->vehicle_type;
                $vehicle->vehicletypesize_id = $request->vehicle_size;
                $vehicle->category = $request->category;
                $vehicle->status = $request->status;
                $vehicle->mounted_tyre_count = $request->mounted_tyre_count;
                $vehicle->created_by = Auth::user()->id;
                $vehicle->save();
                
                
                // Check in VehicleBasicInfo and update
                $basicInfo = VehicleBasicInfo::where('vehicle_number', $request->vc_no)->first();
                if ($basicInfo) {
                    $basicInfo->vehicle_id = $vehicle->id;
                    $basicInfo->save();
                }
                
                
                // Log user activity
                $this->storeUseractivity(12, 3, Auth::user()->id, $vehicle->id, 'Added new vehicle.');
            
            }); 
            
            $success = true;
            $respmessage = 'Vehicle saved successfully.';
    
        } catch (\Exception $exp) {
            
            \Log::error('Vehicle save error', [
                'message' => $exp->getMessage(),
                'trace' => $exp->getTraceAsString()
            ]);
    
            DB::rollBack();
            $success = false;
            $respmessage = $exp->getMessage();
        }
        
        return response()->json(['success' => $success, 'data' => $vehicle, 'message' => $respmessage]);
    }
    
    
    
    public function edit($id)
    {
        if($id == ''){
            return response()->json(['success' => false, 'data' => [], 'message' => 'Woops! id not found.']);
        }
        
        $record = Vehicle::find($id); 
        
        if($record == NULL){
            return response()->json(['success' => false, 'data' => [], 'message' => 'Woops! Data not found.']);
        }
        
        $vehicleownership = Vehicleownership::orderBy('name')->get(); 
        $vehiclegroup = Vehiclegroup::where('status', 'Active')->orderBy('name')->get();
        $vehicletype = Vehicletype::where('status', 'Active')->orderBy('name')->get();
        $vehiclesize = Vehicletypesize::orderBy('name')->get();
        
        // Log activity
        $description = 'Retrieve a vehicle no '.$record->vehicle_no.' to edit.';
        $useractivity = $this->storeUseractivity(12, 5, Auth::user()->id, $record->id, $description);
        
        return view('vehicle.management.edit',compact('record','vehicleownership','vehiclegroup','vehicletype','vehiclesize'));
    }
    
    
    
    
    public function update(Request $request)
    {   
        $record = Vehicle::find($request->get('id'));
        
        if($record == NULL){
            return response()->json(['success' => false, 'data' => [], 'message' => 'Woops ! Vehicle not found!'], 422);
        }
        
        $validator = Validator::make($request->all(), [
                        'vc_no' => 'required|unique:vehicles,vehicle_no,' . $request->id,
                        'ownership_type' => 'required|in:Own,Rental',
                        //'ownership'     => 'required|exists:vehicleownerships,id',
                        'vehicle_group' => 'required|exists:vehiclegroups,id', 
                        'vehicle_type'  => 'required|exists:vehicletypes,id',
                        'vehicle_size'  => 'required|exists:vehicletypesizes,id',
                        'category'      => 'required|in:Local,Line',
                        'status'        => 'required|in:Active,Inactive',
                        'mounted_tyre_count' => 'required|in:6,10',
                    ], [
                        'required' => 'This field is required.',
                        'max'      => 'Maximum 100 characters allowed.',
                        'unique'   => 'This value already exists.',
                        'numeric'  => 'Only numeric values are allowed.',
                        'min'      => 'Value must be at least :min.',
                        'max'      => 'Maximum allowed value is :max.',
                        'in'       => 'Invalid selection.',
                    ]);
    
        
        if ($validator->fails()) {
            \Log::error('Validation failed', [
                'errors' => $validator->errors()->toArray(),
            ]);
    
            return response()->json([
                'success' => false,
                'data' => $validator->errors(),
                'message' => 'Please check validation errors.'
            ], 422);
        }
        
        
        try{
            
            
            DB::transaction(function () use($request, &$record){
                
                $record->vehicle_no = $request->vc_no;
                $record->ownership_type = $request->ownership_type;
                //$record->vehicleownership_id = $request->ownership;
                $record->vehiclegroup_id = $request->vehicle_group;
                $record->vehicletype_id = $request->vehicle_type;
                $record->vehicletypesize_id = $request->vehicle_size;
                $record->category = $request->category;
                $record->status = $request->status;
                $record->mounted_tyre_count = $request->mounted_tyre_count;
                $record->updated_by = Auth::user()->id;
                $record->save();
                
                
                // Check in VehicleBasicInfo and update
                $basicInfo = VehicleBasicInfo::where('vehicle_number', $request->vc_no)->first();
                if ($basicInfo) {
                    $basicInfo->vehicle_id = $record->id;
                    $basicInfo->save();
                }
                
    
                $description = 'Updated a vehicle.';
                $useractivity = $this->storeUseractivity(12, 4, Auth::user()->id, $record->id, $description);
                
            });
            
            $success = true;
            $respmessage = 'Vehicle updated successfully.';
            
        } catch (\Exception $exp){
            \Log::error('Vehicle update error', [
                'message' => $exp->getMessage(),
                'trace' => $exp->getTraceAsString()
            ]);
            
            
            DB::rollBack();
            $success = false;
            $respmessage = $exp->getMessage();
            
        }
        
        return response()->json(['success' => $success, 'data' => $record, 'message' => $respmessage]);
    }
    
    
    
    
    public function destroy(Request $request)
    {
        $id = $request->input('id');
        $actmodelid = $request->input('actmodelid');  
    
        if (empty($id)) {
            return response()->json(['success' => false, 'data' => [], 'message' => 'Woops! id not found.']);
        }
    
        $record = Vehiclegroup::find($id);
    
        if (!$record) {
            return response()->json(['success' => false, 'data' => [], 'message' => 'Woops! Vehicle group not found.']);
        }
    
        // Check if this contact is associated with any SalesOrder
        // $hasSO = SalesOrder::where('customer_id', $id)->exists();
        // if ($hasSO) {
        //     return response()->json([
        //         'success' => false, 
        //         'data' => [], 
        //         'message' => 'This contact is associated with a Sales Order and cannot be deleted.'
        //     ]);
        // }
        
    
        // Proceed with delete inside transaction
        DB::transaction(function () use ($record, $actmodelid) {
            $record->delete(); // delete contact
    
            // Log activity
            $description = 'Deleted a Vehicle group.';
            $this->storeUseractivity($actmodelid, 6, Auth::user()->id, $record->id, $description);
        });
    
        return response()->json(['success' => true, 'data' => [], 'message' => 'Record deleted successfully.']);
    }
    
    
    
    
    
    
    
    
}








