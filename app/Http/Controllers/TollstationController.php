<?php
  
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use App\Models\Tollstation;
use App\Models\State;
use App\Models\City;


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

class TollstationController extends Controller
{
    use Useractivity;
    
    public function index(Request $request): View
    {
        $search_tollstation_name = $request->get('tollstation');
        $search_state = $request->get('state_id');
        $search_city = $request->get('city_id');
        
        $tollstations = Tollstation::query()
                                    ->when($search_tollstation_name, function ($query, $search_tollstation_name) {
                                        $query->where('station_name', 'like', '%' . $search_tollstation_name . '%');
                                    })
                                    ->when($search_state, function ($query, $search_state) {
                                        $query->where('state_id', $search_state);
                                    })
                                    ->when($search_city, function ($query, $search_city) {
                                        $query->where('city_id', $search_city);
                                    })
                                    ->orderBy('id', 'DESC')
                                    ->paginate(10)
                                    ->withQueryString(); // preserves search query in pagination links
        
        
        $states = State::whereHas('country', function ($q) {
                            $q->where('iso2', 'IN');
                        })
                        ->orderBy('name')
                        ->get();
                        
                        
        $cities = City::whereHas('state.country', function ($q) {
                            $q->where('iso2', 'IN');
                        })
                        ->orderBy('name')
                        ->get();
                        
        
        return view('tollstation.index', compact('tollstations','states','cities','search_tollstation_name','search_state','search_city'));
    }
    
    
    public function create(): View
    {   
        $states = State::whereHas('country', function ($q) {
                            $q->where('iso2', 'IN');
                        })
                        ->orderBy('name')
                        ->get();
                        
        return view('tollstation.create',compact('states'));
    }
    
    public function store(Request $request)
    {
        // Step 1: Validate main fields and dynamic rows
        $validator = Validator::make($request->all(), [
            'station_name'   => 'required|max:100|unique:tollstations,station_name', // <--- added unique
            'toll_company'   => 'required|max:100', 
            //'location'       => 'required|max:100',
            'state_id'           => 'required|exists:states,id',
            'city_id'            => 'required|exists:cities,id',
            'embed_map_location' => 'required',
            'address'       => 'nullable',
            'large_vehicle_charge'   => 'nullable|numeric|min:1|max:999999999999999.99999',
            'medium_vehicle_charge'  => 'nullable|numeric|min:1|max:999999999999999.99999',
            'small_vehicle_charge'  => 'nullable|numeric|min:1|max:999999999999999.99999',
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
            //\Log::error('Validation failed', [
                //'errors' => $validator->errors()->toArray(),
                //'input' => request()->all(), // optional: log the input data for context
            //]);
    
            return response()->json([
                'success' => false,
                'data' => $validator->errors(),
                'message' => 'Please check validation errors.'
            ], 422);
        }
        
        
    
        try {
            $tollstation = null;
    
            DB::transaction(function () use ($request, &$tollstation) {
                // Step 3: Generate tollstation number
                $lastTollstation = Tollstation::withTrashed()->orderBy('id', 'DESC')->first();
                $tollstationno = $lastTollstation 
                    ? str_pad($lastTollstation->tollstationno + 1, 6, '0', STR_PAD_LEFT)
                    : '000001';
    
                // Step 4: Save Tollstation
                $tollstation = new Tollstation();
                $tollstation->tollstationno = $tollstationno;
                $tollstation->organisation_id = optional(Auth::user()->organisation)->id;
                $tollstation->station_name = $request->station_name;
                $tollstation->toll_company = $request->toll_company ?? null;
                $tollstation->state_id = $request->state_id ?? null;
                $tollstation->city_id = $request->city_id ?? null;
                $tollstation->embed_map_location = $request->embed_map_location ?? null;
                $tollstation->address = $request->address ?? null;
                $tollstation->currency_id = 1;
                $tollstation->large_vehicle_charge = $request->large_vehicle_charge ?? 0;
                $tollstation->medium_vehicle_charge = $request->medium_vehicle_charge ?? 0;
                $tollstation->small_vehicle_charge = $request->small_vehicle_charge ?? 0;
                $tollstation->status = $request->status;
                
                $tollstation->created_by = Auth::user()->id;
                $tollstation->save();
    
                
                // Log user activity
                $this->storeUseractivity(42, 3, Auth::user()->id, $tollstation->id, 'Added new Toll Station.');
            });
    
            $success = true;
            $respmessage = 'Toll Station saved successfully.';
    
        } catch (\Exception $exp) {
            
            // \Log::error('Process save error', [
            //     'message' => $exp->getMessage(),
            //     'trace' => $exp->getTraceAsString()
            // ]);
    
            DB::rollBack();
            $success = false;
            $respmessage = $exp->getMessage();
        }
        
        return response()->json(['success' => $success, 'data' => $tollstation, 'message' => $respmessage]);
    }
    
    
    
    public function edit($id)
    {
        if($id == ''){
            return response()->json(['success' => false, 'data' => [], 'message' => 'Woops! id not found.']);
        }
        
        $tollstation = TollStation::with(['currency', 'createdBy'])->find($id);
        
        if($tollstation == NULL){
            return response()->json(['success' => false, 'data' => [], 'message' => 'Woops! Tollstation not found.']);
        }

        // if ($tollstation->routetollstations()->exists()) {

        //     return redirect()->back()->with('error', 'This Toll Station is linked with routes. You cannot edit it.');
        // }

        $hasRoutes = $tollstation->routetollstations()->exists();
        
        
        $states = State::whereHas('country', function ($q) {
                            $q->where('iso2', 'IN');
                        })
                        ->orderBy('name')
                        ->get();
        
        // Log activity
        $description = 'Retrieve a tollstation named '.$tollstation->station_name.' to edit.';
        $useractivity = $this->storeUseractivity(42, 5, Auth::user()->id, $tollstation->id, $description);
        
        return view('tollstation.edit', compact('tollstation','states','hasRoutes'));
    }
    
    
    public function update(Request $request)
    {   
        $id = $request->get('tollstationid');

        if (!$id) {
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => 'Tollstation ID is missing.'
            ], 422);
        }
        
        // Step 1: Validate main fields and dynamic rows
        $validator = Validator::make($request->all(), [
            'station_name' => [
                'required',
                'max:100',
                Rule::unique('tollstations', 'station_name')->ignore($id, 'id'),
            ],
            'toll_company'   => 'required|max:100', 
            //'location'       => 'required|max:100',
            'state_id'           => 'required|exists:states,id',
            'city_id'            => 'required|exists:cities,id',
            'embed_map_location'       => 'required',
            'address'       => 'nullable',
            'large_vehicle_charge'   => 'nullable|numeric|min:1|max:999999999999999.99999',
            'medium_vehicle_charge'  => 'nullable|numeric|min:1|max:999999999999999.99999',
            'small_vehicle_charge'  => 'nullable|numeric|min:1|max:999999999999999.99999',
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
            // ]);
    
            return response()->json([
                'success' => false,
                'data' => $validator->errors(),
                'message' => 'Please check validation errors.'
            ], 422);
        }
        

        
        $tollstation = Tollstation::find($request->get('tollstationid'));
        
        if($tollstation == NULL){
            return response()->json(['success' => false, 'data' => [], 'message' => 'Woops ! Tollstation not found.'], 422);
        }
            
        $hasRoutes = $tollstation->routetollstations()->exists();
        if($hasRoutes && $request->status == 'Inactive'){
            return response()->json(['success' => false, 'data' => [], 'message' => 'This toll is tagged with route hence you cannot inactive it.'], 422);
        }
        
        try{
            
            
            DB::transaction(function () use($request, &$tollstation){
                
                $tollstation->station_name = $request->station_name;
                $tollstation->toll_company = $request->toll_company;
                $tollstation->state_id = $request->state_id ?? null;
                $tollstation->city_id = $request->city_id ?? null;
                $tollstation->embed_map_location = $request->embed_map_location;
                $tollstation->address = $request->address;
                $tollstation->currency_id = 1;
                $tollstation->large_vehicle_charge = $request->large_vehicle_charge ?? 0;
                $tollstation->medium_vehicle_charge = $request->medium_vehicle_charge ?? 0;
                $tollstation->small_vehicle_charge = $request->small_vehicle_charge ?? 0;
                $tollstation->status = $request->status;
                $tollstation->updated_by = Auth::user()->id;
                $tollstation->save();
        
                
                $description = 'Updated a Tollstation.';
                $useractivity = $this->storeUseractivity(42, 4, Auth::user()->id, $tollstation->id, $description);
                
            });
            
            $success = true;
            $respmessage = 'Tollstation updated successfully.';
            
        } catch (\Exception $exp){
                                    
            DB::rollBack();
            $success = false;
            $respmessage = $exp->getMessage();
            
        }
        
        return response()->json(['success' => $success, 'data' => $tollstation, 'message' => $respmessage]);
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
    
        $tollstation = Tollstation::find($id);
        if (!$tollstation) {
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => 'Woops! Tollstation not found.'
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
            
            DB::transaction(function () use($request, $id, &$tollstation){
                
                $tollstation = Tollstation::find($id);
                $tollstation->delete(); // Perform delete operation
        
                $description = 'Deleted a tollstation.';
                $useractivity = $this->storeUseractivity(42, 6, Auth::user()->id, $id, $description);
            });
            
            $success = true;
            $respmessage = 'Tollstation deleted successfully.';
            
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

