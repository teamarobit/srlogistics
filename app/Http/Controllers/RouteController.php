<?php
  
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Rto;
use App\Models\Tollstation;
use App\Models\Route;
use App\Models\Routerto;
use App\Models\Routetollstation;
use App\Models\Routemidpoint;

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

class RouteController extends Controller
{
    use Useractivity;
    
    public function index(Request $request): View
    {   
        
        $search_route_name = $request->get('route');
        $search_source = $request->get('source');
        $search_destination = $request->get('destination');
        $search_status = $request->get('status');
        $search_route_type = $request->get('route_type');
        
        $routes = Route::with([
                            'tollstations.tollstation',
                            'rtos.rto',
                            'sourceState',
                            'sourceCity',
                            'destinationState',
                            'destinationCity',
                            'currency'
                        ])
                        ->when($search_route_name, function ($q) use ($search_route_name) {
                            $q->where('name', 'like', '%' . $search_route_name . '%');
                        })
                        ->when($search_source, function ($q) use ($search_source) {
                            $q->where(function ($sub) use ($search_source) {
                                $sub->whereHas('sourceCity', function ($c) use ($search_source) {
                                    $c->where('name', 'like', '%' . $search_source . '%');
                                })
                                ->orWhereHas('sourceState', function ($s) use ($search_source) {
                                    $s->where('name', 'like', '%' . $search_source . '%');
                                });
                            });
                        })
                        ->when($search_destination, function ($q) use ($search_destination) {
                            $q->where(function ($sub) use ($search_destination) {
                                $sub->whereHas('destinationCity', function ($c) use ($search_destination) {
                                    $c->where('name', 'like', '%' . $search_destination . '%');
                                })
                                ->orWhereHas('destinationState', function ($s) use ($search_destination) {
                                    $s->where('name', 'like', '%' . $search_destination . '%');
                                });
                            });
                        })
                        ->when($search_route_type, function ($q) use ($search_route_type) {
                            $q->where('route_type', $search_route_type);
                        })
                        ->when($search_status !== null && $search_status !== '', function ($q) use ($search_status) {
                            $q->where('status', $search_status);
                        })
                        ->orderBy('id', 'desc')
                        ->paginate(10)
                        ->withQueryString();
        
        //dd($routes->toArray());
        
        return view('route.index', compact('routes','search_route_name','search_source','search_destination','search_status'));
        
    }
    
    
    
    public function create(): View
    {   
        $countries = Country::all();
        
        $states = State::whereHas('country', function ($q) {
                            $q->where('iso2', 'IN');
                        })
                        ->orderBy('name')
                        ->get();
                        
        $rtos = Rto::where('status', 'Active')->orderBy('name')->get();
        $tollstations = Tollstation::where('status', 'Active')->orderBy('station_name')->get();
                        
        return view('route.create',compact('countries','states','tollstations','rtos'));
    }
    
    
    
    public function store(Request $request)
    {
        // Step 1: Validate main fields and dynamic rows
        $validator = Validator::make($request->all(), [
            'route_name'              => 'required|unique:routes,name',
            'source_state_id'         => 'required|integer|exists:states,id',
            'source_city_id'          => 'required',
            'destination_state_id'    => 'required|integer|exists:states,id',
            'destination_city_id'     => 'required',
            'fixed_km'                => 'required|numeric|min:1|max:999999999999999.99999',
            'transit_time_days'       => 'required|integer|min:1|max:365',
            'transit_time_hrs'        => 'required|numeric|min:0|max:999.99',
            'fixed_diesel_bs3_bs4'    => 'required|numeric|min:0|max:9999.99',
            'fixed_diesel_bs6'        => 'required|numeric|min:0|max:9999.99',
            'fixed_driver_advance'    => 'required|numeric|min:0|max:999999999999999.99999',
            'remarks'                 => 'nullable',
            'route_type'              => 'required|in:Line,Local',
            'status'                  => 'required|in:Active,Inactive',
            
            'rto_id' => ['required', 'array', 'min:1'],
            'rto_id.*' => ['required', 'integer', 'exists:rtos,id'],
            
            'tollstation_id' => ['required', 'array', 'min:1'],
            'tollstation_id.*' => ['required', 'integer', 'exists:tollstations,id'],
            
        
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
            
            $route = null;
            
            DB::transaction(function () use ($request, &$route) {
                
                // Handle Source City
                $sourceCityInput = $request->source_city_id;
                if (is_numeric($sourceCityInput)) {
                    $sourceCityId = $sourceCityInput;
                } else {
                    $city = new City();
                    $city->state_id = $request->source_state_id;
                    $city->name = $sourceCityInput;
                    $city->save();
                    
                    $sourceCityId = $city->id;
                    
                    // \Log::info('Order created', [
                    //     'New city created : ' => $sourceCityId,
                    // ]);
                }
                
                
                // Handle Destination City
                $destinationCityInput = $request->destination_city_id;
                if (is_numeric($destinationCityInput)) {
                    $destinationCityId = $destinationCityInput;
                } else {
                    $city = new City();
                    $city->state_id = $request->destination_state_id;
                    $city->name = $destinationCityInput;
                    $city->save();
                    
                    $destinationCityId = $city->id;
                    
                    // \Log::info('Order created', [
                    //     'New city created : ' => $destinationCityId,
                    // ]);
                }
                
                /** ---------------- Route ---------------- */
                $route = new Route();
                $route->organisation_id = optional(Auth::user()->organisation)->id;
                $route->name = $request->route_name;
                $route->source_state_id = $request->source_state_id;
                $route->source_city_id = $sourceCityId;
                $route->destination_state_id = $request->destination_state_id;
                $route->destination_city_id = $destinationCityId;
                $route->fixed_km = $request->fixed_km;
                $route->transit_time_days = $request->transit_time_days;
                $route->transit_time_hrs = $request->transit_time_hrs;
                $route->fixed_diesel_bs3_bs4 = $request->fixed_diesel_bs3_bs4;
                $route->fixed_diesel_bs6 = $request->fixed_diesel_bs6;
                $route->fixed_driver_advance = $request->fixed_driver_advance;
                $route->remarks = $request->remarks;
                $route->route_type = $request->route_type;
                $route->status = $request->status;
                $route->created_by = Auth::user()->id;
                $route->save();
            
                /** ---------------- Route RTOs ---------------- */
                if ($request->filled('rto_id')) {
                    foreach (array_unique($request->rto_id) as $rtoId) {
                        $rto = new Routerto();
                        $rto->route_id = $route->id;
                        $rto->rto_id = $rtoId;
                        $rto->save();
                    }
                }
                
                /** ---------------- Route Toll Stations ---------------- */
                if ($request->filled('tollstation_id')) {
                    foreach (array_unique($request->tollstation_id) as $tollId) {
                        $toll = new Routetollstation();
                        $toll->route_id = $route->id;
                        $toll->tollstation_id = $tollId;
                        $toll->save();
                    }
                }
                
                
                /** ---------------- Route Midpoint --------------------- */
                if ($request->has('midpoint_state_id') && $request->has('midpoint_city_id')) {
                
                    $states = $request->midpoint_state_id;
                    $cities = $request->midpoint_city_id;
                
                    foreach ($states as $index => $stateId) {
                
                        $cityId = $cities[$index] ?? null;
                        $cityInput = $request->midpoint_city_id[$index] ?? null;
                
                        if (!$stateId || !$cityInput) {
                            continue;
                        }
                        
                        if (is_numeric($cityInput)) {
                            $cityId = $cityInput;
                        } else {
                            $city = new City();
                            $city->state_id = $stateId;
                            $city->name = ucfirst(strtolower($cityInput));
                            $city->save();
                
                            $cityId = $city->id;
                        }
                        
                        $midpoint = new Routemidpoint();
                        $midpoint->route_id = $route->id;
                        $midpoint->state_id = $stateId;
                        $midpoint->city_id = $cityId;
                        $midpoint->save();
                    }
                }

                
                // Log user activity
                $this->storeUseractivity(20, 3, Auth::user()->id, $route->id, 'Added new Route.');
            
            }); 
            
            $success = true;
            $respmessage = 'Route saved successfully.';
    
        } catch (\Exception $exp) {
            
            \Log::error('Route save error', [
                'message' => $exp->getMessage(),
                'trace' => $exp->getTraceAsString()
            ]);
    
            DB::rollBack();
            $success = false;
            $respmessage = $exp->getMessage();
        }
        
        return response()->json(['success' => $success, 'data' => $route, 'message' => $respmessage]);
    }
    
    
    
    
    public function edit($id)
    {
        if($id == ''){
            return response()->json(['success' => false, 'data' => [], 'message' => 'Woops! id not found.']);
        }
        
        $route = Route::with([
                            'tollstations.tollstation',
                            'rtos.rto',
                            'sourceState',
                            'sourceCity',
                            'destinationState',
                            'destinationCity',
                            'midpoints',
                            'midpoints.state',
                            'midpoints.city',
                            'currency'
                        ])->find($id);
        
        if($route == NULL){
            return response()->json(['success' => false, 'data' => [], 'message' => 'Woops! Route not found!']);
        }
        
        $countries = Country::all();
        
        $states = State::whereHas('country', function ($q) {
                            $q->where('iso2', 'IN');
                        })
                        ->orderBy('name')
                        ->get();
                        
        $rtos = Rto::where('status', 'Active')->orderBy('name')->get();
        $tollstations = Tollstation::where('status', 'Active')->orderBy('station_name')->get();
        
        //dd($route->tollstations);
        
        // Log activity
        $description = 'Retrieve a route named '.$route->name.' to edit.';
        $useractivity = $this->storeUseractivity(20, 5, Auth::user()->id, $route->id, $description);
        
        return view('route.edit', compact('route','countries','states','tollstations','rtos'));
    }
    
    
    
    public function update(Request $request)
    {   
        $route = Route::find($request->get('routeid'));
        
        if($route == NULL){
            return response()->json(['success' => false, 'data' => [], 'message' => 'Woops ! Route not found!'], 422);
        }
        
        // Step 1: Validate main fields and dynamic rows
        $validator = Validator::make($request->all(), [
                        'route_name'              => 'required|unique:routes,name,' . $route->id,
                        'source_state_id'         => 'required|integer|exists:states,id',
                        'source_city_id'          => 'required',
                        'destination_state_id'    => 'required|integer|exists:states,id',
                        'destination_city_id'     => 'required',
                        'fixed_km'                => 'required|numeric|min:1|max:999999999999999.99999',
                        'transit_time_days'       => 'required|integer|min:1|max:365',
                        'transit_time_hrs'        => 'required|numeric|min:0|max:999.99',
                        'fixed_diesel_bs3_bs4'    => 'required|numeric|min:0|max:9999.99',
                        'fixed_diesel_bs6'        => 'required|numeric|min:0|max:9999.99',
                        'fixed_driver_advance'    => 'required|numeric|min:0|max:999999999999999.99999',
                        'remarks'                 => 'nullable',
                        'route_type'              => 'required|in:Line,Local',
                        'status'                  => 'required|in:Active,Inactive',
                
                        'rto_id'                 => 'required|array',
                        'rto_id.*'               => 'integer|exists:rtos,id',
                
                        'tollstation_id'         => 'required|array',
                        'tollstation_id.*'       => 'integer|exists:tollstations,id',
            
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
            
            
            DB::transaction(function () use($request, &$route){
                
                
                /** -------- Source City -------- */
                $sourceCityInput = $request->source_city_id;
    
                if (is_numeric($sourceCityInput)) {
                    $sourceCityId = $sourceCityInput;
                } else {
                    $city = new City();
                    $city->state_id = $request->source_state_id;
                    $city->name     = $sourceCityInput;
                    $city->save();
    
                    $sourceCityId = $city->id;
                }

                /** -------- Destination City -------- */
                $destinationCityInput = $request->destination_city_id;
    
                if (is_numeric($destinationCityInput)) {
                    $destinationCityId = $destinationCityInput;
                } else {
                    $city = new City();
                    $city->state_id = $request->destination_state_id;
                    $city->name     = $destinationCityInput;
                    $city->save();
    
                    $destinationCityId = $city->id;
                }
                
                
                /** -------- Update Route -------- */
                
                $route->name                   = $request->route_name;
                $route->source_state_id        = $request->source_state_id;
                $route->source_city_id         = $sourceCityId;
                $route->destination_state_id   = $request->destination_state_id;
                $route->destination_city_id    = $destinationCityId;
                $route->fixed_km               = $request->fixed_km;
                $route->transit_time_days      = $request->transit_time_days;
                $route->transit_time_hrs       = $request->transit_time_hrs;
                $route->fixed_diesel_bs3_bs4   = $request->fixed_diesel_bs3_bs4;
                $route->fixed_diesel_bs6       = $request->fixed_diesel_bs6;
                $route->fixed_driver_advance   = $request->fixed_driver_advance;
                $route->remarks                = $request->remarks;
                $route->route_type             = $request->route_type;
                $route->status                 = $request->status;
                $route->updated_by             = Auth::user()->id;
                $route->save();
                
                /** -------- Update RTOs -------- */
                Routerto::where('route_id', $route->id)->delete();
    
                if ($request->filled('rto_id')) {
                    foreach ($request->rto_id as $rtoId) {
                        $rto = new Routerto();
                        $rto->route_id = $route->id;
                        $rto->rto_id   = $rtoId;
                        $rto->save();
                    }
                }
                
                /** -------- Update Toll Stations -------- */
                Routetollstation::where('route_id', $route->id)->delete();
    
                if ($request->filled('tollstation_id')) {
                    foreach ($request->tollstation_id as $tollId) {
                        $toll = new Routetollstation();
                        $toll->route_id       = $route->id;
                        $toll->tollstation_id = $tollId;
                        $toll->save();
                    }
                }
                
                
                
                /** ---------------- Route Midpoint --------------------- */
                $newIds = []; // to track newly created midpoint IDs

                foreach ($request->midpoint_state_id as $index => $stateId) {
                    
                    $cityInput  = $request->midpoint_city_id[$index] ?? null;
                    $midpointId = $request->midpoint_id[$index] ?? null;
                
                    if (!$stateId || !$cityInput) continue;
                
                    // Handle new city
                    if (is_numeric($cityInput)) {
                        $cityId = $cityInput;
                    } else {
                        $city = new City();
                        $city->state_id = $stateId;
                        $city->name = ucfirst(strtolower($cityInput));
                        $city->save();
                        $cityId = $city->id;
                    }
                
                    if ($midpointId) {
                        // Update existing
                        $midpoint = Routemidpoint::find($midpointId);
                        if ($midpoint) {
                            $midpoint->state_id = $stateId;
                            $midpoint->city_id  = $cityId;
                            $midpoint->save();
                        }
                    } else {
                        // Insert new
                        $midpoint = new Routemidpoint();
                        $midpoint->route_id = $route->id;
                        $midpoint->state_id = $stateId;
                        $midpoint->city_id  = $cityId;
                        $midpoint->save();
                
                        $midpointId = $midpoint->id; // track new ID
                    }
                
                    $newIds[] = $midpointId; // collect all IDs
                }
                
                // Delete removed midpoints
                Routemidpoint::where('route_id', $route->id)
                    ->whereNotIn('id', $newIds) // use all IDs including new ones
                    ->delete();



                
        
                /** -------- User Activity -------- */
                $description = 'Updated a Route.';
                $useractivity = $this->storeUseractivity(20, 4, Auth::user()->id, $route->id, $description);
                
            });
            
            $success = true;
            $respmessage = 'Route updated successfully.';
            
        } catch (\Exception $exp){
            \Log::error('Route save error', [
                'message' => $exp->getMessage(),
                'trace' => $exp->getTraceAsString()
            ]);
            
            
            DB::rollBack();
            $success = false;
            $respmessage = $exp->getMessage();
            
        }
        
        return response()->json(['success' => $success, 'data' => $route, 'message' => $respmessage]);
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