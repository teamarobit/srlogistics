<?php
    
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Validator;

use App\Models\Digitallockprovider;


use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Auth;

use App\Traits\Useractivity;
    
    
class DigitalLockProviderController extends Controller
{
    
    use Useractivity;
    
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): View
    {
        $search_name = $request->get('name');
        $search_status = $request->get('status');
        
        
        $datas = Digitallockprovider::query()
                                ->when(!empty($search_name), function ($query) use ($search_name) {
                                    $query->where('name', 'like', '%' . trim($search_name) . '%');
                                })
                                ->when(!is_null($search_status) && $search_status !== '', function ($query) use ($search_status) {
                                    $query->where('status', $search_status); // 1 = active, 0 = inactive
                                })
                                ->orderByDesc('id')
                                ->paginate(10)
                                ->withQueryString();

        //dd($supervisors);
        
        return view('provider.digilock.index', compact('datas','search_name','search_status'));
    }
    
    
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        return view('provider.digilock.create');
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
            'provider_name' => 'required|max:100|unique:digitallockproviders,name',
            'status'          => 'required|in:Active,Inactive', 
            
        ], [
                'required' => 'This field is required.',
                'max'      => 'Maximum 100 characters allowed.',
                'unique'   => 'This value already exists.',
                'numeric'  => 'Only numeric values are allowed.',
                'min'      => 'Value must be at least :min.',
                'max'      => 'Maximum allowed value is :max.',
                'in'       => 'Invalid selection.',
            ]
        );
        
        $errorcount = 0;
        $errors = [];
        
        $errormessages = array_merge($validator->getMessageBag()->toArray(), $errors);
        
        if($validator->fails() || $errorcount > 0){
            return response()->json(['success' => false, 'data' => $errormessages, 'message' => 'Please check validation error.'], 422);
        }
        
        try{
            
            $provider = [];
            
            DB::transaction(function () use($request, &$provider){
                
                $lastCode = Digitallockprovider::withTrashed()->orderBy('id', 'DESC')->first();
                $provider_code = $lastCode ? str_pad($lastCode->code + 1, 6, '0', STR_PAD_LEFT) : '000001';
                   
        
                $provider = new Digitallockprovider;
                $provider->name = $request->provider_name;
                $provider->code = $provider_code;
                $provider->status = $request->status;
                $provider->created_by = Auth::user()->id;
                $provider->save();
                
                $description = 'Added new gps provider.';
                $useractivity = $this->storeUseractivity(56, 3, Auth::user()->id, $provider->id, $description);
            });
            
            $success = true;
            $respmessage = 'Digital Lock provider saved successfully.';
            
        } catch (\Exception $exp){
                                    
            DB::rollBack();
            $success = false;
            $respmessage = $exp->getMessage();
            
        }
        
        
        return response()->json(['success' => $success, 'data' => $provider, 'message' => $respmessage]);
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
        
        $record = Digitallockprovider::find($id);
        
        if($record == NULL){
            return response()->json(['success' => false, 'data' => [], 'message' => 'Woops! Data not found.']);
        }
    
        
        // Log activity
        $description = 'Retrieve a record named '.$record->name.' to edit.';
        $useractivity = $this->storeUseractivity(56, 5, Auth::user()->id, $record->id, $description);
        
        return view('provider.digilock.edit', compact('record'));
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
                Rule::unique('digitallockproviders', 'name')->ignore($request->get('recordid'), 'id'),
            ],
            'status'          => 'required|in:Active,Inactive', 
            
        ], [
                'required' => 'This field is required.',
                'max'      => 'Maximum 100 characters allowed.',
                'unique'   => 'This value already exists.',
                'numeric'  => 'Only numeric values are allowed.',
                'min'      => 'Value must be at least :min.',
                'max'      => 'Maximum allowed value is :max.',
                'in'       => 'Invalid selection.',
            ]
        );
        
        $errorcount = 0;
        $errors = [];
        
        $record = Digitallockprovider::find($request->get('recordid'));
        
        if($record == NULL){
            return response()->json(['success' => false, 'data' => [], 'message' => 'Woops ! Data not found.'], 422);
        }
        
        
        $errormessages = array_merge($validator->getMessageBag()->toArray(), $errors);
        
        if($validator->fails() || $errorcount > 0){
            return response()->json(['success' => false, 'data' => $errormessages, 'message' => 'Please check validation error.'], 422);
        }
        
        try{
            
            
            DB::transaction(function () use($request, &$record){
                
                $record->name = $request->get('provider_name');
                $record->status = $request->get('status');
                
                $record->updated_by = Auth::user()->id;
                $record->save();
                
                $description = 'Updated a department.';
                $useractivity = $this->storeUseractivity(56, 4, Auth::user()->id, $record->id, $description);
                
            });
            
            $success = true;
            $respmessage = 'Digital Lock provider updated successfully.';
            
        } catch (\Exception $exp){
                                    
            DB::rollBack();
            $success = false;
            $respmessage = $exp->getMessage();
            
        }
        
        
        return response()->json(['success' => $success, 'data' => $record, 'message' => $respmessage]);
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
