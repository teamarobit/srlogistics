<?php
    
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Validator;

use App\Models\Asset;
use App\Models\Assetfile;


use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Department;
use App\Models\Contact;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Auth;

use App\Traits\Useractivity;
    
    
class AssetController extends Controller
{
    use Useractivity;
    
    const CONTACT_TYPE_CUSTOMER     = 1;
    const CONTACT_TYPE_LOAD_VENDOR  = 2; 
    const CONTACT_TYPE_EMPLOYEE     = 3;
    const CONTACT_TYPE_DRIVER       = 4;
    const CONTACT_TYPE_VENDOR       = 5;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): View
    {
        $search_status = $request->get('status');
        
        $datas = Asset::query()
                                ->withExists(['employeeAssets as is_assigned' => function ($q) {
                                    $q->where('status','Assigned')->whereNull('revoke_date');
                                }])
                                ->latest()
                                ->paginate(10)
                                ->withQueryString();

        //dd($supervisors);
        
        return view('assets.index', compact('datas','search_status'));
    }
    
    
    
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {   
        $contacts = Contact::query()->where('cotype_id', self::CONTACT_TYPE_EMPLOYEE)->orderBy('contact_name')->get();
        
        return view('assets.create',compact('contacts'));
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
            'asset_id'         => 'required|max:100|unique:assets,asset_no',
            'asset_type_name'  => 'required_if:asset_type,Others|max:100',
            'asset_name'       => 'nullable|max:100', 
            'asset_type'       => 'required|in:Motor Vehicle,Electronics,Others', 
            'make'          => 'required_if:asset_type,Motor Vehicle,Electronics|max:100',
            'model'         => 'required_if:asset_type,Motor Vehicle,Electronics|max:100',
            
            'vehicle_age' => 'required_if:asset_type,Motor Vehicle|nullable|integer|min:1',
            'vehicle_no'  => 'required_if:asset_type,Motor Vehicle|nullable|max:100', 
            'rc_date'     => 'required_if:asset_type,Motor Vehicle|nullable|date|date_format:Y-m-d',
            
            'warranty_start_date' => 'required_if:asset_type,Electronics|nullable|date|date_format:Y-m-d',
            'warranty_end_date'   => 'required_if:asset_type,Electronics|nullable|date|date_format:Y-m-d',
            'electronic_age'      => 'required_if:asset_type,Electronics|nullable|integer|min:1',
            
            
            'issue_date'  => 'required_if:asset_type,Motor Vehicle,Electronics|nullable|date|date_format:Y-m-d',
            'assigned_on' => 'required_if:asset_type,Motor Vehicle,Electronics|nullable|date|date_format:Y-m-d',
            'assigned_by' => 'required_if:asset_type,Motor Vehicle,Electronics|nullable|exists:contacts,id',
            
            'comment'     => 'nullable|string|max:2000',
            'documents'   => 'nullable|array',
            'documents.*' => 'file|mimes:pdf,jpg,jpeg,png|max:10240',
            
            //'status'          => 'required|in:Active,Inactive', 
            
        ], [
                'required' => 'This field is required.',
                'max'      => 'Maximum allowed value is :max.',
                'unique'   => 'This value already exists.',
                'numeric'  => 'Only numeric values are allowed.',
                'integer'  => 'Only whole numbers are allowed.',
                'min'      => 'Value must be at least :min.',
                'max'      => 'Maximum allowed value is :max.',
                'in'       => 'Invalid selection.',
            ]
        );
        
        $errorcount = 0;
        $errors = [];
        
        $errormessages = array_merge($validator->getMessageBag()->toArray(), $errors);
        
        if($validator->fails() || $errorcount > 0){
            \Log::error('Validation failed', [
                'errors' => $validator->errors()->toArray(),
                //'input' => request()->all(), // optional: log the input data for context
            ]);
            
            return response()->json(['success' => false, 'data' => $errormessages, 'message' => 'Please check validation error.'], 422);
        }
        
        try{
            
            $asset = [];
            
            DB::transaction(function () use($request, &$asset){
        
                $asset = new Asset;
                $asset->organisation_id = optional(Auth::user()->organisation)->id;
                $asset->type = $request->get('asset_type');
                $asset->asset_type_name = $request->get('asset_type_name') ?? null;
                $asset->name = $request->get('asset_name');
                $asset->asset_no = $request->get('asset_id');
                $asset->vehicle_no = $request->get('vehicle_no');
                $asset->make = $request->get('make');
                $asset->model = $request->get('model');
                $asset->rc_date = $request->get('rc_date');
                
                $asset->age = null;
                $asset->warranty_start_date = null;
                $asset->warranty_end_date = null;
                if ($request->asset_type === 'Motor Vehicle') {
                    $asset->age = $request->vehicle_age;
                }
                if ($request->asset_type === 'Electronics') {
                    $asset->age = $request->electronic_age;
                    $asset->warranty_start_date = $request->warranty_start_date;
                    $asset->warranty_end_date = $request->warranty_end_date;
                }
                if ($request->asset_type === 'Others') {
                    $asset->warranty_start_date = $request->warranty_start_date ?? null;
                    $asset->warranty_end_date = $request->warranty_end_date ?? null;
                }
                
                $asset->issue_date = $request->get('issue_date') ?? null;
                $asset->assigned_on = $request->get('assigned_on') ?? null;
                $asset->assigned_by = $request->get('assigned_by') ?? null;
                $asset->comment = $request->get('comment') ?? null;
                $asset->status = 'Active';
                
                $asset->created_by = Auth::user()->id;
                $asset->save();
                
                if ($request->hasFile('documents')) {
                
                    $uploadPath = public_path('media' . DIRECTORY_SEPARATOR . 'asset');
                
                    // Create folder if not exists
                    if (!File::exists($uploadPath)) {
                        File::makeDirectory($uploadPath, 0755, true);
                    }
                    
                    foreach ($request->file('documents') as $file) {

                        $extension = $file->getClientOriginalExtension();
                
                        $filename = 'asset_' . time() . '_' . Str::random(6) . '.' . $extension;
                
                        // Move file
                        $file->move($uploadPath, $filename);
                
                        
                        $assetfile = new Assetfile();
                        $assetfile->asset_id = $asset->id;
                        $assetfile->file_name = $filename;
                        $assetfile->save();
                
                    }
                } 
                
                $description = 'Added new asset.';
                $useractivity = $this->storeUseractivity(37, 3, Auth::user()->id, $asset->id, $description);
            });
            
            $success = true;
            $respmessage = 'Asset saved successfully.';
            
        } catch (\Exception $exp){
            
            \Log::error('Save error', [
                'message' => $exp->getMessage(),
                'trace' => $exp->getTraceAsString()
            ]);
            
            
            DB::rollBack();
            $success = false;
            $respmessage = $exp->getMessage();
            
        }
        
        
        return response()->json(['success' => $success, 'data' => $asset, 'message' => $respmessage]);
    }
    
    
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     */
    public function show(Request $request)
    {
        //
    }
    
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if($id == ''){
            return response()->json(['success' => false, 'data' => [], 'message' => 'Woops! id not found.']);
        }
        
        $data = Asset::with(['files', 'createdBy'])->find($id);
        
        if($data == NULL){
            return response()->json(['success' => false, 'data' => [], 'message' => 'Woops! Department not found.']);
        }
        
        $contacts = Contact::query()->where('cotype_id', self::CONTACT_TYPE_EMPLOYEE)->orderBy('contact_name')->get();
        //dd($data);
        // Log activity
        $description = 'Retrieve an asset named '.$data->name.' to edit.';
        $useractivity = $this->storeUseractivity(9, 5, Auth::user()->id, $data->id, $description);
        
        //dd($data->id);
        
        return view('assets.edit', compact('data','contacts'));
    }
    
    
    
    
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function update(Request $request)
    {   
        $validator = Validator::make($request->all(), [
            'asset_id'    => [
                'required',
                'max:100',
                Rule::unique('assets', 'asset_no')->ignore($request->get('assetid'), 'id'),
            ],
            'asset_type_name'  => 'required_if:asset_type,Others|max:100',
            'asset_name'    => 'nullable|max:100',
            'asset_type'    => 'required|in:Motor Vehicle,Electronics,Others', 
            'make'          => 'required_if:asset_type,Motor Vehicle,Electronics|max:100',
            'model'         => 'required_if:asset_type,Motor Vehicle,Electronics|max:100',
    
            'vehicle_age' => 'required_if:asset_type,Motor Vehicle|nullable|integer|min:1',
            'vehicle_no'  => 'required_if:asset_type,Motor Vehicle|nullable|max:100', 
            'rc_date'     => 'required_if:asset_type,Motor Vehicle|nullable|date|date_format:Y-m-d',
    
            'warranty_start_date' => 'required_if:asset_type,Electronics|nullable|date|date_format:Y-m-d',
            'warranty_end_date'   => 'required_if:asset_type,Electronics|nullable|date|date_format:Y-m-d',
            'electronic_age'      => 'required_if:asset_type,Electronics|nullable|integer|min:1',
    
            'issue_date'  => 'required_if:asset_type,Motor Vehicle,Electronics|nullable|date|date_format:Y-m-d',
            'assigned_on' => 'required_if:asset_type,Motor Vehicle,Electronics|nullable|date|date_format:Y-m-d',
            'assigned_by' => 'required_if:asset_type,Motor Vehicle,Electronics|nullable|exists:contacts,id',
            
            'comment'     => 'nullable|string|max:2000',
            'documents'   => 'nullable|array',
            'documents.*' => 'file|mimes:pdf,jpg,jpeg,png|max:10240',
    
        ], [
            'required' => 'This field is required.',
            'max'      => 'Maximum allowed value is :max.',
            'unique'   => 'This value already exists.',
            'integer'  => 'Only whole numbers are allowed.',
            'min'      => 'Value must be at least :min.',
            'in'       => 'Invalid selection.',
        ]);
        
        $errorcount = 0;
        $errors = [];
        
        $errormessages = array_merge($validator->getMessageBag()->toArray(), $errors);
        
        if($validator->fails() || $errorcount > 0){
            \Log::error('Edit Validation failed', [
                'errors' => $validator->errors()->toArray(),
                //'input' => request()->all(), // optional: log the input data for context
            ]);
            
            return response()->json(['success' => false, 'data' => $errormessages, 'message' => 'Please check validation error.'], 422);
        }
    
        $asset = Asset::find($request->get('assetid'));
        if($asset == NULL){
            return response()->json(['success' => false, 'data' => [], 'message' => 'Woops ! Asset not found.'], 422);
        }
    

        try {
    
            DB::transaction(function () use ($request, &$asset) {
    
                $asset->type = $request->asset_type;
                $asset->asset_type_name = $request->get('asset_type_name') ?? null;
                $asset->name = $request->asset_name;
                $asset->asset_no = $request->asset_id;
                $asset->make = $request->make;
                $asset->model = $request->model;
                $asset->vehicle_no = $request->vehicle_no;
                $asset->rc_date = $request->rc_date;
    
                // Reset conditional fields
                $asset->age = null;
                $asset->warranty_start_date = null;
                $asset->warranty_end_date = null;
    
                if ($request->asset_type === 'Motor Vehicle') {
                    $asset->age = $request->vehicle_age;
                }
    
                if ($request->asset_type === 'Electronics') {
                    $asset->age = $request->electronic_age;
                    $asset->warranty_start_date = $request->warranty_start_date;
                    $asset->warranty_end_date = $request->warranty_end_date;
                }
                
                if ($request->asset_type === 'Others') {
                    $asset->warranty_start_date = $request->warranty_start_date ?? null;
                    $asset->warranty_end_date = $request->warranty_end_date ?? null;
                }
    
                $asset->issue_date = $request->get('issue_date') ?? null;
                $asset->assigned_on = $request->get('assigned_on') ?? null;
                $asset->assigned_by = $request->get('assigned_by') ?? null;
                $asset->comment = $request->get('comment') ?? null;
    
                $asset->updated_by = Auth::user()->id;
                $asset->save();
                
                // ================= DELETE FILES =================
                if ($request->filled('remove_files')) {
                
                    foreach ($request->remove_files as $fileId) {
                
                        if (!$fileId) continue;
                
                        $file = Assetfile::find($fileId);
                
                        if ($file) {
                
                            $path = public_path('media/asset/' . $file->file_name);
                
                            // Delete from disk
                            if (File::exists($path)) {
                                File::delete($path);
                            }
                
                            // Delete DB record
                            $file->delete();
                        }
                    }
                }
                
    
                // Upload new documents if any
                if ($request->hasFile('documents')) {
    
                    $uploadPath = public_path('media' . DIRECTORY_SEPARATOR . 'asset');
    
                    if (!File::exists($uploadPath)) {
                        File::makeDirectory($uploadPath, 0755, true);
                    }
    
                    foreach ($request->file('documents') as $file) {
    
                        $extension = $file->getClientOriginalExtension();
                        $filename = 'asset_' . time() . '_' . Str::random(6) . '.' . $extension;
    
                        $file->move($uploadPath, $filename);
    
                        $assetfile = new Assetfile();
                        $assetfile->asset_id = $asset->id;
                        $assetfile->file_name = $filename;
                        $assetfile->save();
                    }
                }
                
    
                $description = 'Updated an asset.';
                $this->storeUseractivity(37, 4, Auth::user()->id, $asset->id, $description);
            });
    
            return response()->json([
                'success' => true,
                'data' => $asset,
                'message' => 'Asset updated successfully.'
            ]);
    
        } catch (\Exception $exp) {
            
            \Log::error('Save error', [
                'message' => $exp->getMessage(),
                'trace' => $exp->getTraceAsString()
            ]);
    
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => $exp->getMessage()
            ], 500);
        }
    }
    
    
    
    
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->input('id');
        $actmodelid = $request->input('actmodelid');  
    
        if (empty($id)) {
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => 'Woops! ID not found.'
            ]);
        }
    
        $record = Asset::find($id);
    
        if (!$record) {
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => 'Woops! Asset not found.'
            ]);
        }
    
        try {
    
            DB::transaction(function () use ($record, $actmodelid, $id) {
    
                $record->delete(); // delete asset
    
                // Log activity
                $description = 'Deleted an asset.';
                $this->storeUseractivity($actmodelid, 6, Auth::user()->id, $id, $description);
            });
    
            return response()->json([
                'success' => true,
                'data' => [],
                'message' => 'Asset deleted successfully.'
            ]);
    
        } catch (\Exception $exp) {
    
            \Log::error('Asset Delete Error: '.$exp->getMessage());
    
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => 'Something went wrong.'
            ]);
        }
    }
    
    
    
    
    
    public function getAssetsByType(Request $request)
    {
        try {
    
            $request->validate([
                'asset_type' => 'required|in:Motor Vehicle,Electronics,Others'
            ]);
    
            $assets = Asset::where('type', $request->asset_type)->orderBy('name')->get();
    
            return response()->json([
                'status' => true,
                'message' => 'Assets found.',
                'data'   => $assets
            ]);
    
        } catch (\Exception $e) {
    
            \Log::error('Asset Fetch Error: '.$e->getMessage());
    
            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong. Please try again.'
            ], 500);
        }
    }
    
    
    
    public function getAssetDetails($id)
    {
        try {
    
            $asset = Asset::select('id','name','model','make')->findOrFail($id);
    
            return response()->json([
                'status' => true,
                'message' => 'Asset data found.',
                'data'   => $asset
            ]);
    
        } catch (\Exception $e) {
    
            return response()->json([
                'status' => false,
                'message' => 'Asset not found'
            ], 404);
        }
    }
    
    
    
    
    
    public function changeStatus($id, $status)
    {
        try {
    
            $allowed = ['Assigned', 'Unassigned'];
    
            if (!in_array($status, $allowed)) {
                return redirect()->back()->with('error', 'Invalid status value.');
            }
    
            $asset = Asset::findOrFail($id);
            $asset->status = $status;
            $asset->save();
    
            return redirect()->back()->with('success', 'Status updated successfully.');
    
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
    
            return redirect()->back()->with('error', 'Asset not found.');
    
        } catch (\Exception $e) {
    
            \Log::error('Asset Status Update Error: '.$e->getMessage());
    
            return redirect()->back()->with('error', 'Something went wrong. Please try again.');
        }
    }

    
    
    
    
    
    
    
    
}


