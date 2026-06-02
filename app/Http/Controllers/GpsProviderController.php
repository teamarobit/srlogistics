<?php
    
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Validator;

use App\Models\Gpsprovider;


use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Auth;

use App\Traits\Useractivity;
    
    
class GpsProviderController extends Controller
{
    use Useractivity;
    
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): View
    {
        $search_name   = $request->get('name');
        $search_status = $request->get('status');

        $sort_by  = in_array($request->get('sort_by'), ['name','code','status','created_at','updated_at']) ? $request->get('sort_by') : 'created_at';
        $sort_dir = $request->get('sort_dir') === 'asc' ? 'asc' : 'desc';

        $datas = Gpsprovider::with(['createdBy','updatedBy'])
                                ->when(!empty($search_name), function ($query) use ($search_name) {
                                    // Escape LIKE wildcards so '%' and '_' inside the search term are treated literally.
                                    $term = str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], trim($search_name));
                                    $query->where('name', 'like', '%' . $term . '%');
                                })
                                ->when(!is_null($search_status) && $search_status !== '', function ($query) use ($search_status) {
                                    $query->where('status', $search_status);
                                })
                                ->orderBy($sort_by, $sort_dir)
                                ->paginate(10)
                                ->withQueryString();

        return view('provider.gps.index', compact('datas','search_name','search_status','sort_by','sort_dir'));
    }
    
    
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        return view('provider.gps.create');
    }
    
    
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'provider_name' => ['required', 'max:100', 'regex:/^[^<>]+$/', 'unique:gpsproviders,name'],
            'status'        => 'required|in:Active,Inactive',
        ], [
                'provider_name.required' => 'This field is required.',
                'provider_name.max'      => 'Maximum allowed length is 100 characters.',
                'provider_name.regex'    => 'HTML tags are not allowed in the name.',
                'provider_name.unique'   => 'This value already exists.',
                'status.required'        => 'This field is required.',
                'status.in'              => 'Invalid selection.',
            ]
        );

        $errorcount = 0;
        $errors = [];

        $errormessages = array_merge($validator->getMessageBag()->toArray(), $errors);

        if($validator->fails() || $errorcount > 0){
            return response()->json(['success' => false, 'data' => $errormessages, 'message' => 'Please check validation error.'], 422);
        }

        try{

            $provider = DB::transaction(function () use($request){

                // Sequential numeric code based on the highest existing numeric code (legacy alphabetic codes ignored).
                $maxNumeric = (int) Gpsprovider::withTrashed()
                    ->whereRaw("code REGEXP '^[0-9]+$'")
                    ->max(DB::raw('CAST(code AS UNSIGNED)'));
                $provider_code = (string) ($maxNumeric + 1);

                $p = new Gpsprovider;
                $p->organisation_id = Auth::user()->organisation_id ?? 1;
                $p->name            = $request->provider_name;
                $p->code            = $provider_code;
                $p->status          = $request->status;
                $p->created_by      = Auth::user()->id;
                $p->save();

                $this->storeUseractivity(56, 3, Auth::user()->id, $p->id, 'Added new gps provider.');

                return $p;
            });

            return response()->json([
                'success' => true,
                'data'    => $provider,
                'message' => 'GPS provider saved successfully.',
            ], 200);

        } catch (\Exception $exp){
            return response()->json([
                'success' => false,
                'data'    => [],
                'message' => $exp->getMessage(),
            ], 500);
        }
    }
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $record = Gpsprovider::find($id);

        if (! $record) {
            return redirect()->route('gpsprovider.index')
                             ->with('error', 'GPS provider not found.');
        }

        // Log activity
        $description = 'Retrieve a record named ' . $record->name . ' to edit.';
        $this->storeUseractivity(56, 5, Auth::user()->id, $record->id, $description);

        return view('provider.gps.edit', compact('record'));
    }
    
    
    
    
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'provider_name' => [
                'required',
                'max:100',
                'regex:/^[^<>]+$/',
                Rule::unique('gpsproviders', 'name')->ignore($request->get('recordid'), 'id'),
            ],
            'status'        => 'required|in:Active,Inactive',
        ], [
                'provider_name.required' => 'This field is required.',
                'provider_name.max'      => 'Maximum allowed length is 100 characters.',
                'provider_name.regex'    => 'HTML tags are not allowed in the name.',
                'provider_name.unique'   => 'This value already exists.',
                'status.required'        => 'This field is required.',
                'status.in'              => 'Invalid selection.',
            ]
        );
        
        $errorcount = 0;
        $errors = [];
        
        $record = Gpsprovider::find($request->get('recordid'));
        
        if($record == NULL){
            return response()->json(['success' => false, 'data' => [], 'message' => 'Woops ! Data not found.'], 422);
        }
        
        
        $errormessages = array_merge($validator->getMessageBag()->toArray(), $errors);
        
        if($validator->fails() || $errorcount > 0){
            return response()->json(['success' => false, 'data' => $errormessages, 'message' => 'Please check validation error.'], 422);
        }
        
        try{

            $record = DB::transaction(function () use($request, $record){

                $record->name       = $request->get('provider_name');
                $record->status     = $request->get('status');
                $record->updated_by = Auth::user()->id;
                $record->save();

                $this->storeUseractivity(56, 4, Auth::user()->id, $record->id, 'Updated a gps provider.');

                return $record;
            });

            return response()->json([
                'success' => true,
                'data'    => $record,
                'message' => 'GPS provider updated successfully.',
            ], 200);

        } catch (\Exception $exp){
            return response()->json([
                'success' => false,
                'data'    => [],
                'message' => $exp->getMessage(),
            ], 500);
        }
    }
    
    
    
    
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->get('departmentid'); 
        
        if (empty($id)) {
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => 'Woops! ID not found.'
            ]);
        }
    
        $department = Department::find($id);
    
        if (!$department) {
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => 'Woops! Department not found.'
            ]);
        }
        
        try{
            
            $department = [];
            
            DB::transaction(function () use($request, $id, &$department){
                
                $department = Department::find($id);
                $department->delete(); // Perform delete operation
                
                
                // Log activity
                $description = 'Deleted a department.';
                $useractivity = $this->storeUseractivity(56, 6, Auth::user()->id, $id, $description);
            
            });
            
            $success = true;
            $respmessage = 'Department deleted successfully.';
            
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
