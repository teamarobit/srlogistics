<?php
    
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Validator;

use App\Models\Jobrank;
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
    
    
class JobrankController extends Controller
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
        $search_designation_id = $request->get('designation');
        
        
        $departments = Department::where('status', 'Active')->orderBy('name')->get();
        $designations = Designation::orderBy('name')->get();
        
        $datas = Jobrank::with(['department', 'designation'])
                            ->when($search_name, function ($query) use ($search_name) {
                                $query->where('name', 'like', '%' . $search_name . '%');
                            })
                            ->when($search_department_id, function ($query) use ($search_department_id) {
                                $query->where('department_id', $search_department_id);
                            })
                            ->when($search_designation_id, function ($query) use ($search_designation_id) {
                                $query->where('designation_id', $search_designation_id);
                            })
                            ->latest()
                            ->paginate(10)
                            ->withQueryString();

        //dd($designations);
        
        return view('jobrank.index', compact('datas', 'designations','departments','search_name','search_department_id','search_designation_id'));
    }
    
    
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $departments = Department::where('status', 'Active')->orderBy('name')->get();
        $designations = Designation::orderBy('name')->get();
                        
        return view('jobrank.create', compact('departments','designations'));
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
            'jobrank_name'     => 'required|max:100|unique:jobranks,name',
            'department_id'    => 'required|exists:departments,id',
            'designation_id'   => 'required|exists:designations,id',
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
            
            $jobrank = [];
            
            DB::transaction(function () use($request, &$jobrank){
        
                $jobrank = new Jobrank;
                $jobrank->organisation_id = optional(Auth::user()->organisation)->id;
                $jobrank->name = $request->get('jobrank_name');
                $jobrank->department_id = $request->get('department_id');
                $jobrank->designation_id = $request->get('designation_id');
                $jobrank->status = $request->get('status');
                $jobrank->created_by = Auth::user()->id;
                $jobrank->save();
                
                $description = 'Added new jobrank.';
                $useractivity = $this->storeUseractivity(50, 3, Auth::user()->id, $jobrank->id, $description);
            });
            
            $success = true;
            $respmessage = 'Jobrank saved successfully.';
            
        } catch (\Exception $exp){
                                    
            DB::rollBack();
            $success = false;
            $respmessage = $exp->getMessage();
            
        }
        
        
        return response()->json(['success' => $success, 'data' => $jobrank, 'message' => $respmessage]);
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
        
        $data = Jobrank::with(['department', 'designation', 'createdBy'])->find($id);
        
        if($data == NULL){
            return response()->json(['success' => false, 'data' => [], 'message' => 'Woops! Department not found.']);
        }

        if ($data->officeContacts()->exists() || $data->serviceCenterContacts()->exists()) {
            // \Log::warning('Edit blocked - jobrank tagged with contacts', [
            //     'jobrank_id' => $jobrank->id
            // ]);

            return redirect()->back()->with('error', 'This Job Rank is linked with contacts. You cannot edit it.');
        }
        
        $departments = Department::where('status', 'Active')->orderBy('name')->get();
        $designations = Designation::orderBy('name')->get();
         
         
        // Log activity
        $description = 'Retrieve a jobrank named '.$data->name.' to edit.';
        $useractivity = $this->storeUseractivity(50, 5, Auth::user()->id, $data->id, $description);
        
        return view('jobrank.edit', compact('data','departments','designations'));
    }
    
    
    
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'jobrank_name' => [
                'required',
                'max:100',
                Rule::unique('jobranks', 'name')->ignore($request->get('jobrankid'), 'id'),
            ],
            'department_id'    => 'required|exists:departments,id',
            'designation_id'   => 'required|exists:designations,id',
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
        
        $record = Jobrank::find($request->get('jobrankid'));
        
        if($record == NULL){
            \Log::error('Validation failed', [
                'errors' => $validator->errors()->toArray(),
                //'input' => request()->all(), // optional: log the input data for context
            ]);
            return response()->json(['success' => false, 'data' => [], 'message' => 'Woops ! Data not found.'], 422);
        }
        
        
        $errormessages = array_merge($validator->getMessageBag()->toArray(), $errors);
        
        if($validator->fails() || $errorcount > 0){
            return response()->json(['success' => false, 'data' => $errormessages, 'message' => 'Please check validation error.'], 422);
        }
        
        try{
            
            
            DB::transaction(function () use($request, &$record){
                
                $record->name = $request->get('jobrank_name');
                $record->department_id = $request->get('department_id');
                $record->designation_id = $request->get('designation_id');
                $record->status = $request->get('status');
                $record->updated_by = Auth::user()->id;
                $record->save();
                
                $description = 'Updated a jobrank.';
                $useractivity = $this->storeUseractivity(50, 4, Auth::user()->id, $record->id, $description);
                
            });
            
            $success = true;
            $respmessage = 'Jobrank updated successfully.';
            
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
        $id = $request->input('id');
        $actmodelid = $request->input('actmodelid');  
    
        if (empty($id)) {
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => 'Woops! ID not found.'
            ]);
        }
    
        $record = Jobrank::find($id);
    
        if (!$record) {
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => 'Woops! Jobrank not found.'
            ]);
        }
    
        try {
    
            DB::transaction(function () use ($record, $actmodelid, $id) {
    
                $record->delete(); // delete Jobrank
    
                // Log activity
                $description = 'Deleted a jobrank.';
                $this->storeUseractivity($actmodelid, 6, Auth::user()->id, $id, $description);
            });
    
            return response()->json([
                'success' => true,
                'data' => [],
                'message' => 'Jobrank deleted successfully.'
            ]);
    
        } catch (\Exception $exp) {
    
            \Log::error('Jobrank Delete Error: '.$exp->getMessage());
    
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => 'Something went wrong.'
            ]);
        }
    }

    
    // public function getDesignationsByDepartment($departmentId)
    // {
    //     $designations = Designation::where('department_id', $departmentId)
    //                                 ->where('status', 'Active')
    //                                 ->orderBy('name')
    //                                 ->get(['id', 'name']);
    
    //     return response()->json($designations);
    // }
    
    
}

