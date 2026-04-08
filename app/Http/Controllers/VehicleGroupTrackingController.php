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

use App\Models\Vehiclegrouptracking;
use App\Models\Trackingvehicle;


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

class VehicleGroupTrackingController extends Controller
{
    use Useractivity;
    
    public function index(Request $request): View
    {   
        
        $datas = Vehiclegrouptracking::with([
                                            'vehicleGroup',
                                            'vehicles.vehicle'
                                        ])
                                        ->orderBy('id', 'desc')
                                        ->paginate(10)
                                        ->withQueryString();
        
        //dd($datas->toArray());
        
        return view('vehicle.tracking.index', compact('datas'));
        
    }
    
    
    public function create(): View
    {   
        $vehiclegroup = Vehiclegroup::where('status','Active')->orderBy('name')->get();
        $vehicles = Vehicle::where('status','Active')->orderBy('vehicle_no')->get();
        
        return view('vehicle.tracking.create',compact('vehiclegroup','vehicles'));
    }
    
    
    public function store(Request $request)
    {
        // Step 1: Validate main fields and dynamic rows
        $validator = Validator::make($request->all(), [
            'vehicle_group_id'      => 'required|exists:vehiclegroups,id',
            'managed_by_employee'   => 'required|string|max:255',
            'no_of_vehicles'        => 'required|integer|min:1',
            'vehicle_ids'           => 'required|array|min:1',
            'vehicle_ids.*'         => 'exists:vehicles,id',
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
            //     'input' => request()->all(), // optional: log the input data for context
            // ]);
    
            return response()->json([
                'success' => false,
                'data' => $validator->errors(),
                'message' => 'Please check validation errors.'
            ], 422);
        }
        
    
        try {
            
            $tracking = null;
            
            DB::transaction(function () use ($request, &$tracking) {
                
                $tracking = new Vehiclegrouptracking(); 
                $tracking->organisation_id = optional(Auth::user()->organisation)->id;
                $tracking->vehicle_group_id = $request->vehicle_group_id;
                $tracking->managed_by_employee = $request->managed_by_employee;
                $tracking->no_of_vehicles = $request->no_of_vehicles;
                $tracking->created_by = Auth::user()->id;
                $tracking->save();
                
                foreach($request->vehicle_ids as $vehicle){
                    $vehicles = new Trackingvehicle(); 
                    $vehicles->vehiclegrouptracking_id = $tracking->id;
                    $vehicles->vehicle_id = $vehicle;
                    $vehicles->save();
                }
                
                // Log user activity
                $this->storeUseractivity(16, 3, Auth::user()->id, $tracking->id, 'Added new vehicle group tracking.');
            
            }); 
            
            $success = true;
            $respmessage = 'Vehicle group tracking saved successfully.';
    
        } catch (\Exception $exp) {
            
            \Log::error('Vehicle group tracking save error', [
                'message' => $exp->getMessage(),
                'trace' => $exp->getTraceAsString()
            ]);
    
            DB::rollBack();
            $success = false;
            $respmessage = $exp->getMessage();
        }
        
        return response()->json(['success' => $success, 'data' => $tracking, 'message' => $respmessage]);
    }
    
    
    
    public function edit($id)
    {
        if($id == ''){
            return response()->json(['success' => false, 'data' => [], 'message' => 'Woops! id not found.']);
        }
        
        $record = Vehiclegrouptracking::with([
                         'vehicleGroup',
                         'vehicles',
                     ])
                     ->where('id',$id)
                     ->first();
        
        if($record == NULL){
            return response()->json(['success' => false, 'data' => [], 'message' => 'Woops! Data not found.']);
        }
        
        $vehiclegroup = Vehiclegroup::where('status','Active')->orderBy('name')->get();
        $vehicles = Vehicle::where('status','Active')->orderBy('vehicle_no')->get();
        
        // Log activity
        $description = 'Retrieve a vehicle group tracking named '.$record->name.' to edit.';
        $useractivity = $this->storeUseractivity(16, 5, Auth::user()->id, $record->id, $description);
        
        return view('vehicle.tracking.edit',compact('record','vehiclegroup','vehicles'));
        
    }
    
    
    
    public function update(Request $request)
    {   
        $record = Vehiclegrouptracking::find($request->get('id'));
        
        if($record == NULL){
            return response()->json(['success' => false, 'data' => [], 'message' => 'Woops ! Vehicle group tracking data not found!'], 422);
        }
        
        $validator = Validator::make($request->all(), [
            'vehicle_group_id'      => 'required|exists:vehiclegroups,id',
            'managed_by_employee'   => 'required|string|max:255',
            'no_of_vehicles'        => 'required|integer|min:1',
            'vehicle_ids'           => 'required|array|min:1',
            'vehicle_ids.*'         => 'exists:vehicles,id',
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
                
                $record->vehicle_group_id = $request->vehicle_group_id;
                $record->managed_by_employee = $request->managed_by_employee;
                $record->no_of_vehicles = $request->no_of_vehicles;
                $record->updated_by = Auth::id();
                $record->save();
                
                // Delete old vehicles
                Trackingvehicle::where('vehiclegrouptracking_id', $record->id)->delete();
    
                // Insert new vehicles
                foreach ($request->vehicle_ids as $vehicle) {
                    
                    $vehicles = new Trackingvehicle(); 
                    $vehicles->vehiclegrouptracking_id = $record->id;
                    $vehicles->vehicle_id = $vehicle;
                    $vehicles->save();
                }
                
    
                $description = 'Updated a vehicle group tracking.';
                $useractivity = $this->storeUseractivity(16, 4, Auth::user()->id, $record->id, $description);
                
            });
            
            $success = true;
            $respmessage = 'Vehicle group tracking updated successfully.';
            
        } catch (\Exception $exp){
            \Log::error('Vehicle group update error', [
                'message' => $exp->getMessage(),
                'trace' => $exp->getTraceAsString()
            ]);
            
            
            DB::rollBack();
            $success = false;
            $respmessage = $exp->getMessage();
            
        }
        
        return response()->json(['success' => $success, 'data' => $record, 'message' => $respmessage]);
    }
    
    
    
    
    
    
    
    
    
    
    
}








