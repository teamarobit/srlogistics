<?php
    
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Validator;


use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Contact;

use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Auth;

use App\Traits\Useractivity;
    
    
class DesignationController extends Controller
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
        $search_department_id = $request->get('department');
        
        $departments = Department::where('status', 'Active')->orderBy('name')->get();
        
        $designations = Designation::with('department')
                                ->when($search_name, function ($query, $search_name) {
                                    $query->where('name', 'like', '%' . $search_name . '%');
                                })
                                ->when($search_department_id, function ($query, $search_department_id) {
                                    $query->where('department_id', $search_department_id);
                                })
                                ->orderBy('id', 'DESC')
                                ->paginate(10)
                                ->withQueryString();

        //dd($designations);
        
        return view('designation.index', compact('designations','departments','search_name','search_department_id'));
    }
    
    
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $departments = Department::where('status', 'Active')->orderBy('name')->get();
                        
        return view('designation.create', compact('departments'));
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
            'designation_name' => 'required|max:100|unique:designations,name',
            'department_id'    => 'required|exists:departments,id',
            'status'           => 'required|in:Active,Inactive', 
            
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
            // \Log::error('Validation failed', [
            //     'errors' => $validator->errors()->toArray(),
            //     //'input' => request()->all(), // optional: log the input data for context
            // ]);
            
            return response()->json(['success' => false, 'data' => $errormessages, 'message' => 'Please check validation error.'], 422);
        }
        
        try{
            
            $designation = [];
            
            DB::transaction(function () use($request, &$designation){
        
                $designation = new Designation;
                $designation->organisation_id = optional(Auth::user()->organisation)->id;
                $designation->name = $request->get('designation_name');
                $designation->department_id = $request->get('department_id');
                $designation->status = $request->get('status');
                $designation->created_by = Auth::user()->id;
                $designation->save();
                
                $description = 'Added new designation.';
                $useractivity = $this->storeUseractivity(10, 3, Auth::user()->id, $designation->id, $description);
            });
            
            $success = true;
            $respmessage = 'Designation saved successfully.';
            
        } catch (\Exception $exp){
                                    
            DB::rollBack();
            $success = false;
            $respmessage = $exp->getMessage();
            
        }
        
        
        return response()->json(['success' => $success, 'data' => $designation, 'message' => $respmessage]);
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
        
        $designation = Designation::with(['department', 'createdBy'])->find($id);
        
        if($designation == NULL){
            return response()->json(['success' => false, 'data' => [], 'message' => 'Woops! Department not found.']);
        }
        
        $departments = Department::where('status', 'Active')->orderBy('name')->get();
        
        // Log activity
        $description = 'Retrieve a designation named '.$designation->name.' to edit.';
        $useractivity = $this->storeUseractivity(10, 5, Auth::user()->id, $designation->id, $description);
        
        return view('designation.edit', compact('designation','departments'));
    }
    
    
    
    
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'designation_name' => [
                'required',
                'max:100',
                Rule::unique('designations', 'name')->ignore($request->get('designationid'), 'id'),
            ],
            'department_id'   => 'nullable|exists:departments,id',
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
        
        $designation = Designation::find($request->get('designationid'));
        
        if($designation == NULL){
            \Log::error('Validation failed', [
                'errors' => $validator->errors()->toArray(),
                //'input' => request()->all(), // optional: log the input data for context
            ]);
            return response()->json(['success' => false, 'data' => [], 'message' => 'Woops ! Designation not found.'], 422);
        }
        
        
        $errormessages = array_merge($validator->getMessageBag()->toArray(), $errors);
        
        if($validator->fails() || $errorcount > 0){
            return response()->json(['success' => false, 'data' => $errormessages, 'message' => 'Please check validation error.'], 422);
        }
        
        try{
            
            
            DB::transaction(function () use($request, &$designation){
                
                $designation->name = $request->get('designation_name');
                $designation->department_id = $request->get('department_id');
                $designation->status = $request->get('status');
                $designation->updated_by = Auth::user()->id;
                $designation->save();
                
                $description = 'Updated a designation.';
                $useractivity = $this->storeUseractivity(10, 4, Auth::user()->id, $designation->id, $description);
                
            });
            
            $success = true;
            $respmessage = 'Designation updated successfully.';
            
        } catch (\Exception $exp){
                                    
            DB::rollBack();
            $success = false;
            $respmessage = $exp->getMessage();
            
        }
        
        
        return response()->json(['success' => $success, 'data' => $designation, 'message' => $respmessage]);
    }
    
    
    
    
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->get('designationid'); 
        
        if (empty($id)) {
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => 'Woops! ID not found.'
            ]);
        }
    
        $designation = Designation::find($id);
    
        if (!$designation) {
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => 'Woops! Designation not found.'
            ]);
        }
        
        try{
            
            $designation = [];
            
            DB::transaction(function () use($request, $id, &$designation){
                
                $designation = Designation::find($id);
                $designation->delete(); // Perform delete operation
                
                
                // Log activity
                $description = 'Deleted a designation.';
                $useractivity = $this->storeUseractivity(10, 6, Auth::user()->id, $id, $description);
            
            });
            
            $success = true;
            $respmessage = 'Designation deleted successfully.';
            
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

    
    public function getDesignationsByDepartment($departmentId)
    {
        $designations = Designation::where('department_id', $departmentId)
                                    ->where('status', 'Active')
                                    ->orderBy('name')
                                    ->get(['id', 'name']);
    
        return response()->json($designations);
    }
    
    
}


