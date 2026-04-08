<?php
  
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use App\Models\Skillset;

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

class SkillsetController extends Controller
{
    use Useractivity;
    
    public function index(Request $request): View
    {
        $search_skillset_name = $request->get('skillset');
        
        $skillsets = Skillset::query()
                                    ->when($search_skillset_name, function ($query, $search_skillset_name) {
                                        $query->where('name', 'like', '%' . $search_skillset_name . '%');
                                    })
                                    ->orderBy('id', 'DESC')
                                    ->paginate(10)
                                    ->withQueryString(); // preserves search query in pagination links
        
        
        
        //dd($skillsets);
        
        return view('skillset.index', compact('skillsets','search_skillset_name'));
    }
    
    
    public function create(): View
    {
        return view('skillset.create');
    }
    
    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'skillset_name'   => 'required|max:100|unique:skillsets,name', // <--- added unique
            'pre_requisite_notes'  => 'nullable|string|max:10000', 
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
            
            $skillset = null;
    
            DB::transaction(function () use ($request, &$skillset) {
                
                $skillset = new Skillset();
                $skillset->organisation_id = optional(Auth::user()->organisation)->id;
                $skillset->name = $request->skillset_name;
                $skillset->pre_requisite_notes = $request->pre_requisite_notes;
                $skillset->status = $request->status;
                $skillset->created_by = Auth::user()->id;
                $skillset->save();
    
                
                // Log user activity
                $this->storeUseractivity(49, 3, Auth::user()->id, $skillset->id, 'Added new Skill Set.');
            });
    
            $success = true;
            $respmessage = 'Skill Set saved successfully.';
    
        } catch (\Exception $exp) {
            
            // \Log::error('Process save error', [
            //     'message' => $exp->getMessage(),
            //     'trace' => $exp->getTraceAsString()
            // ]);
    
            DB::rollBack();
            $success = false;
            $respmessage = $exp->getMessage();
        }
        
        return response()->json(['success' => $success, 'data' => $skillset, 'message' => $respmessage]);
    }
    
    
    
    public function edit($id)
    {
        if($id == ''){
            return response()->json(['success' => false, 'data' => [], 'message' => 'Woops! id not found.']);
        }
        
        $skillset = Skillset::with(['createdBy'])->find($id);
        
        if($skillset == NULL){
            return response()->json(['success' => false, 'data' => [], 'message' => 'Woops! skillset not found.']);
        }
        
        // Log activity
        $description = 'Retrieve a skillset named '.$skillset->station_name.' to edit.';
        $useractivity = $this->storeUseractivity(49, 5, Auth::user()->id, $skillset->id, $description);
        
        return view('skillset.edit', compact('skillset'));
    }
    
    
    public function update(Request $request)
    {   
        $id = $request->get('skillsetid');

        if (!$id) {
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => 'skillset ID is missing.'
            ], 422);
        }
        
        // Step 1: Validate main fields and dynamic rows
        $validator = Validator::make($request->all(), [
            'skillset_name' => [
                'required',
                'max:100',
                Rule::unique('skillsets', 'name')->ignore($id, 'id'),
            ],
            'pre_requisite_notes'  => 'nullable|string|max:10000', 
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
        

        
        $skillset = Skillset::find($request->get('skillsetid'));
        
        if($skillset == NULL){
            return response()->json(['success' => false, 'data' => [], 'message' => 'Woops ! Skillset not found.'], 422);
        }
        
        
        
        try{
            
            
            DB::transaction(function () use($request, &$skillset){
                
                $skillset->name = $request->skillset_name;
                $skillset->pre_requisite_notes = $request->pre_requisite_notes;
                $skillset->status = $request->status;
                $skillset->updated_by = Auth::user()->id;
                $skillset->save();
        
                
                $description = 'Updated a skillset.';
                $useractivity = $this->storeUseractivity(49, 4, Auth::user()->id, $skillset->id, $description);
                
            });
            
            $success = true;
            $respmessage = 'Skill set updated successfully.';
            
        } catch (\Exception $exp){
                                    
            DB::rollBack();
            $success = false;
            $respmessage = $exp->getMessage();
            
        }
        
        return response()->json(['success' => $success, 'data' => $skillset, 'message' => $respmessage]);
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
    
        $skillset = Skillset::find($id);
        if (!$skillset) {
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => 'Woops! Skillset not found.'
            ]);
        }
        
        
        
        try{
            
            DB::transaction(function () use($request, $id, &$skillset){
                
                $skillset = Skillset::find($id);
                $skillset->delete(); // Perform delete operation
        
                $description = 'Deleted a skillset.';
                $useractivity = $this->storeUseractivity(49, 6, Auth::user()->id, $id, $description);
            });
            
            $success = true;
            $respmessage = 'Skillset deleted successfully.';
            
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