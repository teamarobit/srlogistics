<?php
    
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Validator;

use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Department;
use App\Models\Departmentwisebranch;
use App\Models\Branch;
use App\Models\Contact;

use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Auth;

use App\Traits\Useractivity;
    
    
class DepartmentController extends Controller
{
    use Useractivity;
    
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): View
    {
        $search_department_name = $request->get('name');
        $search_location_id = $request->get('branch');
        $search_branch_ids = $request->get('branch');
        
        $cities = City::whereHas('state.country', function ($q) {
                            $q->where('iso2', 'IN');   
                        })->orderBy('name')->get();
                        
        $branches = Branch::where('status', 'Active')->orderBy('location')->get();
        
        
        $departments = Department::with(['branches', 'createdby'])
                                    ->when($search_department_name, function ($query, $search_department_name) {
                                        $query->where('name', 'like', '%' . $search_department_name . '%');
                                    })
                                    ->when($search_branch_ids, function ($query, $search_branch_ids) {
                                        $query->whereHas('branches', function ($q) use ($search_branch_ids) {
                                            $q->whereIn('branches.id', (array) $search_branch_ids);
                                        });
                                    })
                                    ->orderBy('id', 'DESC')
                                    ->paginate(10);

        //dd($supervisors);
        
        
        return view('department.index', compact('departments','branches','cities','search_department_name','search_location_id'));
    }
    
    
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $cities = City::whereHas('state.country', function ($q) {
                            $q->where('iso2', 'IN');   
                        })->orderBy('name')->get();
                        
        $branches = Branch::where('status', 'Active')->orderBy('location')->get();                
                        
        return view('department.create', compact('branches','cities'));
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
            'department_name' => 'required|max:100|unique:departments,name',
            'department_head_name' => 'nullable|max:100',
            'number_of_employees' => 'nullable|integer|min:1|max:100',
            
            'branch_id' => 'required|array',
            'branch_id.*' => 'exists:branches,id',
    
            //'branch_id'         => 'nullable|exists:branches,id',
            //'city_id'         => 'nullable|exists:cities,id',
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
            
            $department = [];
            
            DB::transaction(function () use($request, &$department){
        
                $department = new Department;
                $department->organisation_id = optional(Auth::user()->organisation)->id;
                $department->name = $request->get('department_name');
                $department->department_head_name = $request->get('department_head_name');
                $department->no_of_employees = $request->get('number_of_employees');
                $department->status = $request->get('status');
                $department->created_by = Auth::user()->id;
                $department->save();
                
                // Save multiple branches (pivot table)
                $branchIds = array_filter((array) $request->branch_id);
                if (!empty($branchIds)) {
                    $department->branches()->attach($branchIds);
                }
                
                
                $description = 'Added new department.';
                $useractivity = $this->storeUseractivity(9, 3, Auth::user()->id, $department->id, $description);
            });
            
            $success = true;
            $respmessage = 'Department saved successfully.';
            
        } catch (\Exception $exp){
            
            \Log::error('Department Store Error', [
                'message' => $exp->getMessage(),
                'file' => $exp->getFile(),
                'line' => $exp->getLine(),
                'trace' => $exp->getTraceAsString(),
                // 'request_data' => $request->all(),
                // 'user_id' => Auth::id()
            ]);
    
    
            DB::rollBack();
            $success = false;
            $respmessage = $exp->getMessage();
            
        }
        
        
        return response()->json(['success' => $success, 'data' => $department, 'message' => $respmessage]);
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
        
        $department = Department::with(['city', 'createdBy', 'designations'])->find($id);
        
        if($department == NULL){
            return response()->json(['success' => false, 'data' => [], 'message' => 'Woops! Department not found.']);
        }

        
        if ($department->designations()->exists()) {

            // \Log::warning('Edit blocked - department has designations', [
            //     'department_id' => $department->id
            // ]);

            return redirect()->back()->with('error', 'This department has designations. You cannot edit it.');
        }

        if ($department->officeContacts()->exists() || $department->serviceCenterContacts()->exists()) {
            // \Log::warning('Edit blocked - department tagged with contacts', [
            //     'department_id' => $department->id
            // ]);

            return redirect()->back()->with('error', 'This department is linked with contacts. You cannot edit it.');
        }

        
        $cities = City::whereHas('state.country', function ($q) {
                            $q->where('iso2', 'IN');   
                        })->orderBy('name')->get();
                        
        $branches = Branch::where('status', 'Active')->orderBy('location')->get();         
        
        // Log activity
        $description = 'Retrieve a department named '.$department->name.' to edit.';
        $useractivity = $this->storeUseractivity(9, 5, Auth::user()->id, $department->id, $description);
        
        return view('department.edit', compact('department','branches','cities'));
    }
    
    
    
    
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'department_name' => [
                'required',
                'max:100',
                Rule::unique('departments', 'name')->ignore($request->get('departmentid'), 'id'),
            ],
            'department_head_name' => 'nullable|max:100',
            'number_of_employees' => 'nullable|integer|min:1|max:100',
            'branch_id' => 'required|array',
            'branch_id.*' => 'exists:branches,id',
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
        
        $department = Department::find($request->get('departmentid'));
        
        if($department == NULL){
            return response()->json(['success' => false, 'data' => [], 'message' => 'Woops ! Department not found.'], 422);
        }
        
        
        $errormessages = array_merge($validator->getMessageBag()->toArray(), $errors);
        
        if($validator->fails() || $errorcount > 0){
            return response()->json(['success' => false, 'data' => $errormessages, 'message' => 'Please check validation error.'], 422);
        }
        
        try{
            
            
            DB::transaction(function () use($request, &$department){
                
                $department->name = $request->get('department_name');
                $department->department_head_name = $request->get('department_head_name');
                $department->no_of_employees = $request->get('number_of_employees');
                $department->status = $request->get('status');
                
                $department->updated_by = Auth::user()->id;
                $department->save();
                
                
                $branchIds = array_filter((array) $request->branch_id);
                $department->branches()->sync($branchIds);
                
                
                $description = 'Updated a department.';
                $useractivity = $this->storeUseractivity(9, 4, Auth::user()->id, $department->id, $description);
                
            });
            
            $success = true;
            $respmessage = 'Department updated successfully.';
            
        } catch (\Exception $exp){
            
            \Log::error('Department Store Error', [
                'message' => $exp->getMessage(),
                'file' => $exp->getFile(),
                'line' => $exp->getLine(),
                'trace' => $exp->getTraceAsString(),
                // 'request_data' => $request->all(),
                // 'user_id' => Auth::id()
            ]);
            
                                    
            DB::rollBack();
            $success = false;
            $respmessage = $exp->getMessage();
            
        }
        
        
        return response()->json(['success' => $success, 'data' => $department, 'message' => $respmessage]);
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
                $useractivity = $this->storeUseractivity(9, 6, Auth::user()->id, $id, $description);
            
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



