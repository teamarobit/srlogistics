<?php
  
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use App\Models\Vehicleownership;

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

class VehicleownershipController extends Controller
{
    use Useractivity;
    
    const ACT_MODEL     = 18;
    const ACT_OP_CREATE = 3;
    const ACT_OP_READ   = 5;
    const ACT_OP_UPDATE = 4;
    const ACT_OP_DELETE = 6;
    const ACT_OP_EXPORT = 7;
    
    public function index(Request $request): View
    {   
        
        $search_name = $request->get('name');
        
        $datas = Vehicleownership::with([
                            'createdBy',
                        ])
                        ->when($search_name, function ($q) use ($search_name) {
                            $q->where('name', 'like', '%' . $search_name . '%');
                        })
                        ->orderBy('id', 'desc')
                        ->paginate(10)
                        ->withQueryString();
        
        //dd($datas->toArray());
        
        return view('vehicle.ownership.index', compact('datas','search_name'));
        
    }
    
    
    public function create(): View
    {   
        return view('vehicle.ownership.create');
    }
    
    
    
    public function store(Request $request)
    {
        // Step 1: Validate main fields and dynamic rows
        $validator = Validator::make($request->all(), [
            'ownership_name' => 'required|unique:vehicleownerships,name',
            'description'    => 'nullable|string',
            'status'         => 'required|in:Active,Inactive',
            
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
            
            $Vehicleownership = null;
            
            DB::transaction(function () use ($request, &$Vehicleownership) {
                
                $Vehicleownership = new Vehicleownership();
                $Vehicleownership->organisation_id = optional(Auth::user()->organisation)->id;
                $Vehicleownership->name = $request->ownership_name;
                $Vehicleownership->description = $request->description;
                $Vehicleownership->status = $request->status;
                $Vehicleownership->created_by = Auth::user()->id;
                $Vehicleownership->save();
                
                // Log user activity
                $this->storeUseractivity(self::ACT_MODEL, self::ACT_OP_CREATE, Auth::user()->id, $Vehicleownership->id, 'Added new vehicle status.');
            
            }); 
            
            $success = true;
            $respmessage = 'Vehicle status saved successfully.';
    
        } catch (\Exception $exp) {
            
            \Log::error('Vehicle status save error', [
                'message' => $exp->getMessage(),
                'trace' => $exp->getTraceAsString()
            ]);
    
            DB::rollBack();
            $success = false;
            $respmessage = $exp->getMessage();
        }
        
        return response()->json(['success' => $success, 'data' => $Vehicleownership, 'message' => $respmessage]);
    }
    
    
    
    public function edit($id)
    {
        if($id == ''){
            return response()->json(['success' => false, 'data' => [], 'message' => 'Woops! id not found.']);
        }
        
        $editData = Vehicleownership::with([
                            'createdBy'
                        ])->find($id);
        
        if($editData == NULL){
            return response()->json(['success' => false, 'data' => [], 'message' => 'Woops! Vehicle status not found!']);
        }
        
        //dd($editData);
        
        // Log activity
        $description = 'Retrieve a vehicle ownership named '.$editData->name.' to edit.';
        $useractivity = $this->storeUseractivity(self::ACT_MODEL, self::ACT_OP_READ, Auth::user()->id, $editData->id, $description);
        
        return view('vehicle.ownership.edit', compact('editData'));
    }
    
    
    
    
    public function update(Request $request)
    {   
        $Vehicleownership = Vehicleownership::find($request->id);
        
        if($Vehicleownership == NULL){
            return response()->json(['success' => false, 'data' => [], 'message' => 'Woops ! Vehicle ownership not found!'], 422);
        }
        
        $validator = Validator::make($request->all(), [
                        'ownership_name' => [
                            'required',
                            'max:100',
                            Rule::unique('vehicleownerships', 'name')->ignore($Vehicleownership->id, 'id'),
                        ],
                        'description'    => 'nullable|string',
                        'status'         => 'required|in:Active,Inactive',
                        
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
            
            
            DB::transaction(function () use($request, &$Vehicleownership){
                
                $Vehicleownership->name             = $request->ownership_name;
                $Vehicleownership->description      = $request->description;
                $Vehicleownership->status           = $request->status;
                $Vehicleownership->updated_by       = Auth::user()->id;
                $Vehicleownership->save();
                
                $description = 'Updated a vehicle ownership.';
                $useractivity = $this->storeUseractivity(self::ACT_MODEL, self::ACT_OP_UPDATE, Auth::user()->id, $Vehicleownership->id, $description);
                
            });
            
            $success = true;
            $respmessage = 'Vehicle ownership updated successfully.';
            
        } catch (\Exception $exp){
            \Log::error('Vehicle ownership update error', [
                'message' => $exp->getMessage(),
                'trace' => $exp->getTraceAsString()
            ]);
            
            
            DB::rollBack();
            $success = false;
            $respmessage = $exp->getMessage();
            
        }
        
        return response()->json(['success' => $success, 'data' => $Vehicleownership, 'message' => $respmessage]);
    }
    
    
    
    public function destroy($id)
    {
        $Vehicleownership = Vehicleownership::find($id);
        if (!$Vehicleownership) {
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => 'Woops! Vehicle status not found.'
            ]);
        }
        
        // Check if Tollstation is used in BOP Items
        // $existsInBOP = Bopitem::where('process_id', $id)->exists();
        // if ($existsInBOP) {
        //     return response()->json([
        //         'success' => false,
        //         'data' => [],
        //         'message' => 'This process is used in a Bill of Process (BOP) and cannot be deleted.'
        //     ]);
        // }
    
    
        
        try{
            
            DB::transaction(function () use($id, &$Vehicleownership){
                //$Vehicleownership->isDeletable();
                
                $Vehicleownership->delete(); // Perform delete operation
        
                $description = 'Deleted a vehicle ownership.';
                $useractivity = $this->storeUseractivity(self::ACT_MODEL, self::ACT_OP_DELETE, Auth::user()->id, $id, $description);
            });
            
            $success = true;
            $respmessage = 'Vehicle ownership deleted successfully.';
            
        } catch (\Exception $exp){
                                    
            DB::rollBack();
            $success = false;
            $respmessage = $exp->getMessage();
            
        }
        
        return response()->json([
            'success' => $success,
            'data' => [],
            'message' => $respmessage
        ]);
    }
    
    
    
    
    
    
    
}


