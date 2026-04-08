<?php
  
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use App\Models\Vehicletype;
use App\Models\Vehicletypesize;

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

class VehicletypeController extends Controller
{
    use Useractivity;
    
    public function index(Request $request): View
    {   
        
        $search_name = $request->get('name');
        $search_status = $request->get('status');
        
        $datas = Vehicletype::with([
                            'sizes',
                        ])
                        ->when($search_name, function ($q) use ($search_name) {
                            $q->where('name', 'like', '%' . $search_name . '%');
                        })
                        ->when($search_status !== null && $search_status !== '', function ($q) use ($search_status) {
                            $q->where('status', $search_status);
                        })
                        ->orderBy('id', 'desc')
                        ->paginate(10)
                        ->withQueryString();
        
        //dd($datas->toArray());
        
        return view('vehicle.type.index', compact('datas','search_name','search_status'));
        
    }
    
    
    public function create(): View
    {   
        return view('vehicle.type.create');
    }
    
    
    
    
    public function store(Request $request)
    {   
        // \Log::info('Vehicle Size Names:', [
        //     'vehiclesize_name' => $request->vehiclesize_name
        // ]);
        
        // Clean & sync dynamic arrays (remove null rows safely)
        $names   = $request->vehiclesize_name ?? [];
        $heights = $request->vehiclesize_height ?? [];
        $widths  = $request->vehiclesize_width ?? [];
        $lengths = $request->vehiclesize_length ?? [];
    
        $filtered = [
            'vehiclesize_name'   => [],
            'vehiclesize_height' => [],
            'vehiclesize_width'  => [],
            'vehiclesize_length' => [],
        ];
    
        foreach ($names as $i => $name) {
            if (!empty($name)) {
                $filtered['vehiclesize_name'][]   = $name;
                $filtered['vehiclesize_height'][] = $heights[$i] ?? null;
                $filtered['vehiclesize_width'][]  = $widths[$i] ?? null;
                $filtered['vehiclesize_length'][] = $lengths[$i] ?? null;
            }
        }
        // Merge cleaned data back
        $request->merge($filtered);
    

        // Step 1: Validate main fields and dynamic rows
        $validator = Validator::make($request->all(), [
            // Vehicle Type
            'vehicletype_name' => 'required|unique:vehicletypes,name',
            'description'      => 'nullable|string',
            'status'           => 'required|in:Active,Inactive',
            
            // Vehicle Size Name
            'vehiclesize_name'   => 'required|array|min:1',
            'vehiclesize_name.*' => 'required|string|max:255',
            
            // Height / Width / Length (DECIMAL 5,2)
            'vehiclesize_height'   => 'required|array',
            'vehiclesize_height.*' => 'required|string|max:255',
            // 'vehiclesize_height.*' => 'required|numeric|min:0|max:999.99',
        
            'vehiclesize_width'   => 'required|array',
            'vehiclesize_width.*' => 'required|string|max:255',
            //'vehiclesize_width.*' => 'required|numeric|min:0|max:999.99',
        
            'vehiclesize_length'   => 'required|array',
            'vehiclesize_length.*' => 'required|string|max:255',
            //'vehiclesize_length.*' => 'required|numeric|min:0|max:999.99',
            
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
                //'input' => request()->all(), // optional: log the input data for context
            ]);
    
            return response()->json([
                'success' => false,
                'data' => $validator->errors(),
                'message' => 'Please check validation errors.'
            ], 422);
        }
        
    
        try {
            
            $vehicletype = null;
            
            DB::transaction(function () use ($request, &$vehicletype) {
                
                $vehicletype = new Vehicletype();
                $vehicletype->organisation_id = optional(Auth::user()->organisation)->id;
                $vehicletype->name = $request->vehicletype_name;
                $vehicletype->description = $request->description;
                $vehicletype->status = $request->status;
                $vehicletype->created_by = Auth::user()->id;
                $vehicletype->save();
                
                
                $names   = $request->vehiclesize_name ?? [];
                $heights = $request->vehiclesize_height ?? [];
                $widths  = $request->vehiclesize_width ?? [];
                $lengths = $request->vehiclesize_length ?? [];
                
                foreach ($names as $index => $name) {

                    // skip empty rows (safety)
                    if (empty($name) && empty($heights[$index]) && empty($widths[$index]) && empty($lengths[$index])) {
                        continue;
                    }
                    
                    $vehicletypesizes = new Vehicletypesize();
                    $vehicletypesizes->vehicletype_id = $vehicletype->id;
                    $vehicletypesizes->name = $name;
                    $vehicletypesizes->height = $heights[$index] ?? 0;
                    $vehicletypesizes->width = $widths[$index] ?? 0;
                    $vehicletypesizes->length = $lengths[$index] ?? 0;
                    $vehicletypesizes->save();
        
                }
                
                // Log user activity
                $this->storeUseractivity(13, 3, Auth::user()->id, $vehicletype->id, 'Added new vehicle type.');
            
            }); 
            
            $success = true;
            $respmessage = 'Vehicle type saved successfully.';
    
        } catch (\Exception $exp) {
            
            \Log::error('Vehicle type save error', [
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
        
        $vehicletype = Vehicletype::with([
                            'sizes'
                        ])->find($id);
        
        if($vehicletype == NULL){
            return response()->json(['success' => false, 'data' => [], 'message' => 'Woops! Vehicle type not found!']);
        }
        
        //dd($vehicletype);
        
        // $countries = Country::all();
        
        // $states = State::whereHas('country', function ($q) {
        //                     $q->where('iso2', 'IN');
        //                 })
        //                 ->orderBy('name')
        //                 ->get();
                        
        // $rtos = Rto::where('status', 'Active')->orderBy('name')->get();
        // $tollstations = Tollstation::where('status', 'Active')->orderBy('station_name')->get();
        
        // //dd($route->tollstations);
        
        // // Log activity
        // $description = 'Retrieve a route named '.$route->name.' to edit.';
        // $useractivity = $this->storeUseractivity(13, 5, Auth::user()->id, $route->id, $description);
        
        return view('vehicle.type.edit', compact('vehicletype'));
    }
    
    
    
    
    public function update(Request $request)
    {   
        $vehicletype = Vehicletype::find($request->get('vehicletypeid'));
        
        if($vehicletype == NULL){
            return response()->json(['success' => false, 'data' => [], 'message' => 'Woops ! Vehicle type not found!'], 422);
        }
        
        $validator = Validator::make($request->all(), [
                        // Vehicle Type
                        'vehicletype_name' => [
                            'required',
                            'max:100',
                            Rule::unique('vehicletypes', 'name')->ignore($vehicletype->id, 'id'),
                        ],
                        //'vehicletype_name' => 'required|unique:vehicletypes,name',
                        'description'      => 'nullable|string',
                        'status'           => 'required|in:Active,Inactive',
                        
                        // Vehicle Size Name
                        'vehiclesize_name'   => 'required|array|min:1',
                        'vehiclesize_name.*' => 'required|string|max:255',
                        
                        // Height / Width / Length (DECIMAL 5,2)
                        'vehiclesize_height'   => 'required|array',
                        'vehiclesize_height.*' => 'required|string|max:255',
                        // 'vehiclesize_height.*' => 'required|numeric|min:0|max:999.99',
                    
                        'vehiclesize_width'   => 'required|array',
                        'vehiclesize_width.*' => 'required|string|max:255',
                        //'vehiclesize_width.*' => 'required|numeric|min:0|max:999.99',
                    
                        'vehiclesize_length'   => 'required|array',
                        'vehiclesize_length.*' => 'required|string|max:255',
                        //'vehiclesize_length.*' => 'required|numeric|min:0|max:999.99',
                        
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
            
            
            DB::transaction(function () use($request, &$vehicletype){
                
                $vehicletype->name             = $request->vehicletype_name;
                $vehicletype->description      = $request->description;
                $vehicletype->status           = $request->status;
                $vehicletype->updated_by       = Auth::user()->id;
                $vehicletype->save();
                
                $names   = $request->vehiclesize_name ?? [];
                $heights = $request->vehiclesize_height ?? [];
                $widths  = $request->vehiclesize_width ?? [];
                $lengths = $request->vehiclesize_length ?? [];
                
                Vehicletypesize::where('vehicletype_id', $vehicletype->id)->delete();
                
                foreach ($names as $index => $name) {

                    // skip empty rows (safety)
                    if (empty($name) && empty($heights[$index]) && empty($widths[$index]) && empty($lengths[$index])) {
                        continue;
                    }
                    
                    $vehicletypesizes = new Vehicletypesize();
                    $vehicletypesizes->vehicletype_id = $vehicletype->id;
                    $vehicletypesizes->name = $name;
                    $vehicletypesizes->height = $heights[$index] ?? 0;
                    $vehicletypesizes->width = $widths[$index] ?? 0;
                    $vehicletypesizes->length = $lengths[$index] ?? 0;
                    $vehicletypesizes->save();
            
                }
    
                $description = 'Updated a vehicle type.';
                $useractivity = $this->storeUseractivity(13, 4, Auth::user()->id, $vehicletype->id, $description);
                
            });
            
            $success = true;
            $respmessage = 'Vehicle type updated successfully.';
            
        } catch (\Exception $exp){
            \Log::error('Vehicle type update error', [
                'message' => $exp->getMessage(),
                'trace' => $exp->getTraceAsString()
            ]);
            
            
            DB::rollBack();
            $success = false;
            $respmessage = $exp->getMessage();
            
        }
        
        return response()->json(['success' => $success, 'data' => $vehicletype, 'message' => $respmessage]);
    }
    
    
    
    
    public function destroy(Request $request)
    {
        $id = $request->get('id'); 
        
        if (empty($id)) {
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => 'Woops! ID not found.'
            ]);
        }
    
        $vehicletype = Vehicletype::find($id);
        if (!$vehicletype) {
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => 'Woops! Vehicle type not found.'
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
            
            DB::transaction(function () use($request, $id, &$vehicletype){
                
                $vehicletype = Vehicletype::find($id);
                $vehicletype->delete(); // Perform delete operation
        
                $description = 'Deleted a vehicle type.';
                $useractivity = $this->storeUseractivity(13, 6, Auth::user()->id, $id, $description);
            });
            
            $success = true;
            $respmessage = 'Vehicle type deleted successfully.';
            
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
    
    
    
    public function getSizes($id)
    {
        try {
    
            $vehicletype = Vehicletype::with('sizes')->where('id', $id)->where('status', 'Active')->first();
                                
            if (!$vehicletype) {
                return response()->json([
                    'success' => false,
                    'sizes' => []
                ]);
            }
    
            return response()->json([
                'success' => true,
                'sizes' => $vehicletype->sizes
            ]);
    
        } catch (\Throwable $e) {
    
            \Log::error('Vehicle type size fetch failed', [
                'vehicletype_id' => $id,
                'error' => $e->getMessage()
            ]);
    
            return response()->json([
                'success' => false,
                'sizes'   => []
            ], 500);
        }
    }
    
    
    
    
    
    
    
    

    
    
    
}









