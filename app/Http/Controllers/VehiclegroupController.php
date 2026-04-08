<?php
  
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use App\Models\Vehiclegroup;


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

class VehiclegroupController extends Controller
{
    use Useractivity;
    
    public function index(Request $request): View
    {   
        
        $search_name = $request->get('name');
        $search_status = $request->get('status');
        
        $datas = Vehiclegroup::when($search_name, function ($q) use ($search_name) {
                            $q->where('name', 'like', '%' . $search_name . '%');
                        })
                        ->when($search_status !== null && $search_status !== '', function ($q) use ($search_status) {
                            $q->where('status', $search_status);
                        })
                        ->orderBy('id', 'desc')
                        ->paginate(10)
                        ->withQueryString();
        
        //dd($datas->toArray());
        
        return view('vehicle.group.index', compact('datas','search_name','search_status'));
        
    }
    
    
    public function create(): View
    {   
        return view('vehicle.group.create');
    }
    
    
    public function store(Request $request)
    {
        // Step 1: Validate main fields and dynamic rows
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:vehiclegroups,name',
            'status'           => 'required|in:Active,Inactive',
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
            
            $vehicletype = null;
            
            DB::transaction(function () use ($request, &$vehicletype) {
                
                $vehicletype = new Vehiclegroup(); 
                $vehicletype->organisation_id = optional(Auth::user()->organisation)->id;
                $vehicletype->name = $request->name;
                $vehicletype->status = $request->status;
                $vehicletype->created_by = Auth::user()->id;
                $vehicletype->save();
                
                
                // Log user activity
                $this->storeUseractivity(14, 3, Auth::user()->id, $vehicletype->id, 'Added new vehicle type.');
            
            }); 
            
            $success = true;
            $respmessage = 'Vehicle group saved successfully.';
    
        } catch (\Exception $exp) {
            
            \Log::error('Vehicle group save error', [
                'message' => $exp->getMessage(),
                'trace' => $exp->getTraceAsString()
            ]);
    
            DB::rollBack();
            $success = false;
            $respmessage = $exp->getMessage();
        }
        
        return response()->json(['success' => $success, 'data' => $vehicletype, 'message' => $respmessage]);
    }
    
    
    
    public function edit($id)
    {
        if($id == ''){
            return response()->json(['success' => false, 'data' => [], 'message' => 'Woops! id not found.']);
        }
        
        $record = Vehiclegroup::find($id);
        
        if($record == NULL){
            return response()->json(['success' => false, 'data' => [], 'message' => 'Woops! Data not found.']);
        }
        
        // Log activity
        $description = 'Retrieve a vehicle group named '.$record->name.' to edit.';
        $useractivity = $this->storeUseractivity(14, 5, Auth::user()->id, $record->id, $description);
        
        return response()->json(['success' => true, 'data' => $record, 'message' => 'Show the edit form.']);
    }
    
    
    
    
    public function update(Request $request)
    {   
        $record = Vehiclegroup::find($request->get('id'));
        
        if($record == NULL){
            return response()->json(['success' => false, 'data' => [], 'message' => 'Woops ! Vehicle type not found!'], 422);
        }
        
        $validator = Validator::make($request->all(), [
                        // Vehicle Group
                        'name' => [
                            'required',
                            'max:100',
                            Rule::unique('vehiclegroups', 'name')->ignore($record->id, 'id'),
                        ],
                        'status'           => 'required|in:Active,Inactive',
                        
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
                
                $record->name             = $request->name;
                $record->status           = $request->status;
                $record->updated_by       = Auth::user()->id;
                $record->save();
                
    
                $description = 'Updated a vehicle group.';
                $useractivity = $this->storeUseractivity(14, 4, Auth::user()->id, $record->id, $description);
                
            });
            
            $success = true;
            $respmessage = 'Vehicle group updated successfully.';
            
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








