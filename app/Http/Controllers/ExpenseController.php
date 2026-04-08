<?php
  
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use App\Models\Expense;


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

class ExpenseController extends Controller
{
    use Useractivity;
    
    public function index(Request $request): View
    {   
        
        $search_name = $request->get('name');
        $search_status = $request->get('status');
        
        $datas = Expense::when($search_name, function ($q) use ($search_name) {
                            $q->where('name', 'like', '%' . $search_name . '%');
                        })
                        ->when($search_status !== null && $search_status !== '', function ($q) use ($search_status) {
                            $q->where('status', $search_status);
                        })
                        ->orderBy('id', 'desc')
                        ->paginate(10)
                        ->withQueryString();
        
        //dd($datas->toArray());
        
        return view('expense.index', compact('datas','search_name','search_status'));
        
    }
    
    
    public function create(): View
    {   
        return view('expense.create');
    }
    
    
    public function store(Request $request)
    {
        // Step 1: Validate main fields and dynamic rows
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:expenses,name',
            'terms_of_expense' => 'nullable',
            'status' => 'required|in:Active,Inactive',
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
            
            $record = null;
            
            DB::transaction(function () use ($request, &$record) {
                
                $record = new Expense(); 
                $record->organisation_id = optional(Auth::user()->organisation)->id;
                $record->name = $request->name;
                $record->terms_of_expense = $request->terms_of_expense;
                $record->status = $request->status;
                $record->created_by = Auth::user()->id;
                $record->save();
                
                
                // Log user activity
                $this->storeUseractivity(34, 3, Auth::user()->id, $record->id, 'Added new expense type.');
            
            }); 
            
            $success = true;
            $respmessage = 'Expense type saved successfully.';
    
        } catch (\Exception $exp) {
            
            \Log::error('Expense type save error', [
                'message' => $exp->getMessage(),
                'trace' => $exp->getTraceAsString()
            ]);
    
            DB::rollBack();
            $success = false;
            $respmessage = $exp->getMessage();
        }
        
        return response()->json(['success' => $success, 'data' => $record, 'message' => $respmessage]);
    }
    
    
    
    public function edit($id)
    {
        if($id == ''){
            return response()->json(['success' => false, 'data' => [], 'message' => 'Woops! id not found.']);
        }
        
        $record = Expense::find($id);
        
        if($record == NULL){
            return response()->json(['success' => false, 'data' => [], 'message' => 'Woops! Data not found.']);
        }
        
        // Log activity
        $description = 'Retrieve a expense type named '.$record->name.' to edit.';
        $useractivity = $this->storeUseractivity(34, 5, Auth::user()->id, $record->id, $description);
        
        return response()->json(['success' => true, 'data' => $record, 'message' => 'Show the edit form.']);
    }
    
    
    
    
    public function update(Request $request)
    {   
        $record = Expense::find($request->get('id'));
        
        if($record == NULL){
            return response()->json(['success' => false, 'data' => [], 'message' => 'Woops ! Vehicle type not found!'], 422);
        }
        
        $validator = Validator::make($request->all(), [
                        // Vehicle Group
                        'name' => [
                            'required',
                            'max:100',
                            Rule::unique('expenses', 'name')->ignore($record->id, 'id'),
                        ],
                        'terms_of_expense' => 'nullable',
                        'status'           => 'required|in:Active,Inactive',
                        
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
            
            
            DB::transaction(function () use($request, &$record){
                
                $record->name             = $request->name;
                $record->terms_of_expense = $request->terms_of_expense;
                $record->status           = $request->status;
                $record->updated_by       = Auth::user()->id;
                $record->save();
                
    
                $description = 'Updated a expense type.';
                $useractivity = $this->storeUseractivity(34, 4, Auth::user()->id, $record->id, $description);
                
            });
            
            $success = true;
            $respmessage = 'Expense type updated successfully.';
            
        } catch (\Exception $exp){
            \Log::error('Expense type update error', [
                'message' => $exp->getMessage(),
                'trace' => $exp->getTraceAsString()
            ]);
            
            
            DB::rollBack();
            $success = false;
            $respmessage = $exp->getMessage();
            
        }
        
        return response()->json(['success' => $success, 'data' => $record, 'message' => $respmessage]);
    }
    
    
    
    
    
    
    
    
    
}








