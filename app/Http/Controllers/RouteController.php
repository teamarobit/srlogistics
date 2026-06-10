<?php
  
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRouteRequest;
use App\Http\Requests\UpdateRouteRequest;

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
                        ->withCount(['customercontracts as active_contracts_count' => function ($q) {
                            $q->where(function ($w) {
                                $w->whereNull('customercontracts.end_date')
                                  ->orWhereDate('customercontracts.end_date', '>=', now()->toDateString());
                            });
                        }])
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
        
        return view('route.index', compact('routes','search_route_name','search_source','search_destination','search_status', 'search_route_type'));
        
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
    
    
    
    public function store(StoreRouteRequest $request)
    {

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

        // Lock: a route bound to a non-expired customer contract cannot be edited
        // until every linked contract has expired (end_date in the past).
        if ($route->isLockedByContract()) {
            return redirect()
                ->route('route.index')
                ->with('error', 'This route is linked to an active contract and cannot be edited until the contract expires.');
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
    
    
    
    public function update(UpdateRouteRequest $request)
    {
        $route = Route::find($request->get('routeid'));

        if ($route == NULL) {
            return response()->json(['success' => false, 'data' => [], 'message' => 'Woops! Route not found.'], 422);
        }

        // Lock: block the save if the route is still bound to a non-expired contract.
        if ($route->isLockedByContract()) {
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => 'This route is linked to an active contract and cannot be edited until the contract expires.'
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
            ], 422);
        }

        $route = Route::find($id);
        if (!$route) {
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => 'Route not found.'
            ], 422);
        }

        // Check if Route is used elsewhere before deleting (uncomment when needed)
        // $existsInUsage = SomeRelatedModel::where('route_id', $id)->exists();
        // if ($existsInUsage) {
        //     return response()->json([
        //         'success' => false,
        //         'data' => [],
        //         'message' => 'This route is in use and cannot be deleted.'
        //     ], 422);
        // }

        try {

            DB::transaction(function () use ($id, &$route) {

                $route = Route::find($id);
                $route->delete();

                $description = 'Deleted a Route.';
                $this->storeUseractivity(20, 6, Auth::user()->id, $id, $description);
            });

            $success = true;
            $respmessage = 'Route deleted successfully.';

        } catch (\Exception $exp) {

            DB::rollBack();
            $success = false;
            $respmessage = $exp->getMessage();

        }

        return response()->json([
            'success' => $success,
            'data' => [],
            'message' => $respmessage
        ], $success ? 200 : 500);
    }
    
    
    
    
    
    
    
}