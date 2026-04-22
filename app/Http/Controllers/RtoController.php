<?php
  
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use App\Models\Rto;
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

class RtoController extends Controller
{
    use Useractivity;
    
    public function index(Request $request): View
    {
        $search_rto_name = $request->get('rto');
        $search_state = $request->get('state_id');
        $search_city = $request->get('city_id');
        
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
        
        $rtos = Rto::query()
                        ->when($search_rto_name, function ($query, $search_rto_name) {
                            $query->where('name', 'like', '%' . $search_rto_name . '%');
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
        
        
        return view('rto.index', compact('rtos','states','cities','search_rto_name','search_state','search_city'));
    }
    
    
    public function create(): View
    {
        $states = State::whereHas('country', function ($q) {
                            $q->where('iso2', 'IN');
                        })
                        ->orderBy('name')
                        ->get();
        
        return view('rto.create',compact('states'));
    }
    
    public function store(Request $request)
    {
        // Step 1: Validate main fields and dynamic rows
        $validator = Validator::make($request->all(), [
            'rto_name'   => 'required|max:100|unique:rtos,name', // <--- added unique
            'state_id'                 => 'required|exists:states,id',
            'city_id'                  => 'required|exists:cities,id',
            'embed_map_location'       => 'required',
            'charge_for_large_truck'   => 'nullable|numeric|min:1|max:999999999999999.99999',
            'charge_for_medium_truck'  => 'nullable|numeric|min:1|max:999999999999999.99999',
            'charge_for_small_truck'  => 'nullable|numeric|min:1|max:999999999999999.99999',
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
            $Rto = null;
    
            DB::transaction(function () use ($request, &$Rto) {
                // Step 3: Generate Rto number
                $lastRto = Rto::withTrashed()->orderBy('id', 'DESC')->first();
                $Rtono = $lastRto 
                    ? str_pad($lastRto->rtono + 1, 6, '0', STR_PAD_LEFT)
                    : '000001';
    
                // Step 4: Save Rto
                $Rto = new Rto();
                
                $Rto->rtono = $Rtono;
                $Rto->organisation_id = optional(Auth::user()->organisation)->id;
                $Rto->name = $request->rto_name;
                
                $Rto->state_id = $request->state_id;
                $Rto->city_id = $request->city_id;
                $Rto->embed_map_location = $request->embed_map_location ?? null;
                
                $Rto->currency_id = 1;
                $Rto->charge_for_large_truck = $request->charge_for_large_truck ?? 0;
                $Rto->charge_for_medium_truck = $request->charge_for_medium_truck ?? 0;
                $Rto->charge_for_small_truck = $request->charge_for_small_truck ?? 0;
                $Rto->status = $request->status;
                
                $Rto->created_by = Auth::user()->id;
                $Rto->save();
    
                
                // Log user activity
                $this->storeUseractivity(17, 3, Auth::user()->id, $Rto->id, 'Added new RTO Checkpoint.');
            });
    
            $success = true;
            $respmessage = 'RTO Checkpoint saved successfully.';
    
        } catch (\Exception $exp) {
            
            // \Log::error('Process save error', [
            //     'message' => $exp->getMessage(),
            //     'trace' => $exp->getTraceAsString()
            // ]);
    
            DB::rollBack();
            $success = false;
            $respmessage = $exp->getMessage();
        }
        
        return response()->json(['success' => $success, 'data' => $Rto, 'message' => $respmessage]);
    }
    
    
    
    public function edit($id)
    {
        if($id == ''){
            return response()->json(['success' => false, 'data' => [], 'message' => 'Woops! id not found.']);
        }
        
        $rto = Rto::with(['currency', 'createdBy'])->find($id);
        
        if($rto == NULL){
            return response()->json(['success' => false, 'data' => [], 'message' => 'Woops! RTO not found.']);
        }

        $hasRoutes = $rto->routertos()->exists();
        
        $states = State::whereHas('country', function ($q) {
                            $q->where('iso2', 'IN');
                        })
                        ->orderBy('name')
                        ->get();
        
        // Log activity
        $description = 'Retrieve a RTO named '.$rto->name.' to edit.';
        $useractivity = $this->storeUseractivity(17, 5, Auth::user()->id, $rto->id, $description);
        
        return view('rto.edit', compact('rto','states','hasRoutes'));
    }
    
    
    public function update(Request $request)
    {   
        $id = $request->get('rtoid');

        if (!$id) {
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => 'RTO ID is missing.'
            ], 422);
        }
        
        // Step 1: Validate main fields and dynamic rows
        $validator = Validator::make($request->all(), [
            'rto_name' => [
                'required',
                'max:100',
                Rule::unique('rtos', 'name')->ignore($id),
            ],
            'state_id'                => 'required|exists:states,id',
            'city_id'                 => 'required|exists:cities,id',
            'embed_map_location'      => 'required',
            'charge_for_large_truck'  => 'nullable|numeric|min:1|max:999999999999999.99999',
            'charge_for_medium_truck' => 'nullable|numeric|min:1|max:999999999999999.99999',
            'charge_for_small_truck'  => 'nullable|numeric|min:1|max:999999999999999.99999',
            'status'                  => 'required|in:Active,Inactive', 

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
        

        
        $rto = Rto::find($request->get('rtoid'));
        
        if($rto == NULL){
            return response()->json(['success' => false, 'data' => [], 'message' => 'Woops ! RTO not found.'], 422);
        }
            
        $hasRoutes = $rto->routertos()->exists();
        if($hasRoutes && $request->status == 'Inactive'){
            return response()->json(['success' => false, 'data' => [], 'message' => 'This RTO Checkpoint is tagged with route hence you cannot inactive it.'], 422);

        }
        
        try{
            
            
            DB::transaction(function () use($request, &$rto){
                
                $rto->name = $request->rto_name;
                $rto->state_id = $request->state_id;
                $rto->city_id = $request->city_id;
                $rto->embed_map_location = $request->embed_map_location ?? null;
                
                $rto->currency_id = 1;
                $rto->charge_for_large_truck = $request->charge_for_large_truck ?? 0;
                $rto->charge_for_medium_truck = $request->charge_for_medium_truck ?? 0;
                $rto->charge_for_small_truck = $request->charge_for_small_truck ?? 0;
                $rto->status = $request->status;
                $rto->updated_by = Auth::user()->id;
                $rto->save();
        
                
                $description = 'Updated a Rto.';
                $useractivity = $this->storeUseractivity(17, 4, Auth::user()->id, $rto->id, $description);
                
            });
            
            $success = true;
            $respmessage = 'Rto updated successfully.';
            
        } catch (\Exception $exp){
                                    
            DB::rollBack();
            $success = false;
            $respmessage = $exp->getMessage();
            
            \Log::error('RTO update failed', [
                'error_message' => $e->getMessage(),
                'rto_id'        => $request->rtoid ?? null,
            ]);
            
        }
        
        return response()->json(['success' => $success, 'data' => $rto, 'message' => $respmessage]);
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
    
        $Rto = Rto::find($id);
        if (!$Rto) {
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => 'Woops! RTO not found.'
            ]);
        }
        
        // Check if Rto is used in BOP Items
        // $existsInBOP = Bopitem::where('process_id', $id)->exists();
        // if ($existsInBOP) {
        //     return response()->json([
        //         'success' => false,
        //         'data' => [],
        //         'message' => 'This process is used in a Bill of Process (BOP) and cannot be deleted.'
        //     ]);
        // }
    
    
        
        try{
            
            DB::transaction(function () use($request, $id, &$Rto){
                
                $Rto = Rto::find($id);
                $Rto->delete(); // Perform delete operation
        
                $description = 'Deleted a RTO.';
                $useractivity = $this->storeUseractivity(17, 6, Auth::user()->id, $id, $description);
            });
            
            $success = true;
            $respmessage = 'RTO Checkpoint deleted successfully.';
            
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
