<?php
  
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use App\Models\Vehiclestatus;

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

class VehiclestatusController extends Controller
{
    use Useractivity;
    
    public function index(Request $request): View
    {   
        
        $search_name = $request->get('name');
        
        $datas = Vehiclestatus::with([
                            'createdBy',
                        ])
                        ->when($search_name, function ($q) use ($search_name) {
                            $q->where('name', 'like', '%' . $search_name . '%');
                        })
                        ->orderBy('id', 'desc')
                        ->paginate(10)
                        ->withQueryString();
        
        //dd($datas->toArray());
        
        return view('vehicle.status.index', compact('datas','search_name'));
        
    }
    
    
    public function create(): View
    {   
        return view('vehicle.status.create');
    }
    
    
    public function store(Request $request)
    {
        // Step 1: Validate main fields and dynamic rows
        $validator = Validator::make($request->all(), [
            'vehiclestatus_name' => 'required|unique:vehiclestatuses,name',
            'description'      => 'nullable|string',
            'status'        => 'required|in:Active,Inactive',
            
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
            
            $vehiclestatus = null;
            
            DB::transaction(function () use ($request, &$vehiclestatus) {
                
                $vehiclestatus = new Vehiclestatus();
                $vehiclestatus->organisation_id = optional(Auth::user()->organisation)->id;
                $vehiclestatus->name = $request->vehiclestatus_name;
                $vehiclestatus->description = $request->description;
                $vehiclestatus->status = $request->status;
                $vehiclestatus->created_by = Auth::user()->id;
                $vehiclestatus->save();
                
                // Log user activity
                $this->storeUseractivity(15, 3, Auth::user()->id, $vehiclestatus->id, 'Added new vehicle status.');
            
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
        
        return response()->json(['success' => $success, 'data' => $vehiclestatus, 'message' => $respmessage]);
    }
    
    
    
    public function edit($id)
    {
        if($id == ''){
            return response()->json(['success' => false, 'data' => [], 'message' => 'Woops! id not found.']);
        }
        
        $editData = Vehiclestatus::with([
                            'createdBy'
                        ])->find($id);
        
        if($editData == NULL){
            return response()->json(['success' => false, 'data' => [], 'message' => 'Woops! Vehicle status not found!']);
        }
        
        //dd($editData);
        
        return view('vehicle.status.edit', compact('editData'));
    }
    
    
    
    
    public function update(Request $request)
    {   
        $vehiclestatus = Vehiclestatus::find($request->id);
        
        if($vehiclestatus == NULL){
            return response()->json(['success' => false, 'data' => [], 'message' => 'Woops ! Vehicle status not found!'], 422);
        }
        
        $validator = Validator::make($request->all(), [
                        'vehiclestatus_name' => [
                            'required',
                            'max:100',
                            Rule::unique('vehiclestatuses', 'name')->ignore($vehiclestatus->id, 'id'),
                        ],
                        'description'      => 'nullable|string',
                        'status'        => 'required|in:Active,Inactive',
                        
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
            
            
            DB::transaction(function () use($request, &$vehiclestatus){
                
                $vehiclestatus->name             = $request->vehiclestatus_name;
                $vehiclestatus->description      = $request->description;
                $vehiclestatus->status           = $request->status;
                $vehiclestatus->updated_by       = Auth::user()->id;
                $vehiclestatus->save();
                
                $description = 'Updated a vehicle status.';
                $useractivity = $this->storeUseractivity(15, 4, Auth::user()->id, $vehiclestatus->id, $description);
                
            });
            
            $success = true;
            $respmessage = 'Vehicle status updated successfully.';
            
        } catch (\Exception $exp){
            \Log::error('Vehicle status update error', [
                'message' => $exp->getMessage(),
                'trace' => $exp->getTraceAsString()
            ]);
            
            
            DB::rollBack();
            $success = false;
            $respmessage = $exp->getMessage();
            
        }
        
        return response()->json(['success' => $success, 'data' => $vehiclestatus, 'message' => $respmessage]);
    }
    
    
    
    
    
    
    
}



