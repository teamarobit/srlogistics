<?php
  
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBranchRequest;
use App\Http\Requests\UpdateBranchRequest;

use App\Models\State;
use App\Models\City;
use App\Models\Skillset;
use App\Models\Branch;
use App\Models\Branchfile;

use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Hash;
use Auth;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Closure;
use Illuminate\Support\Fluent;
use Illuminate\Database\Eloquent\Builder;

use App\Traits\Useractivity;


class BranchController extends Controller
{
    use Useractivity;
    
    public function index(Request $request): View
    {
        $search_branch_type = $request->get('type');
        $search_branch_city = $request->get('city');
        $search_status = $request->get('status');
        
        $cities = City::whereHas('state.country', function ($q) {
                            $q->where('iso2', 'IN');
                        })
                        ->orderBy('name')
                        ->get();
        
        $branches = Branch::query()
                                    // Filter by Branch Type
                                    ->when($search_branch_type, function ($query) use ($search_branch_type) {
                                        $query->whereJsonContains('type', $search_branch_type);
                                    })
                                
                                    // Filter by City
                                    ->when($search_branch_city, function ($query) use ($search_branch_city) {
                                        $query->where('city_id', $search_branch_city);
                                    })
                                    
                                    ->when($search_status !== null && $search_status !== '', function ($q) use ($search_status) {
                                        $q->where('status', $search_status);
                                    })
                                    ->orderBy('id', 'DESC')
                                    ->paginate(10)
                                    ->withQueryString(); // preserves search query in pagination links
        
        
        
        //dd($branches);
        
        return view('branch.index', compact('branches','search_branch_type','search_branch_city','cities','search_status'));
    }
    
    
    public function create(): View
    {
        $states = State::whereHas('country', function ($q) {
                            $q->where('iso2', 'IN');
                        })
                        ->orderBy('name')
                        ->get();
                        
        return view('branch.create',compact('states'));
    }
    
    
    public function store(StoreBranchRequest $request)
    {
        $request->merge([
            'phone'              => preg_replace('/\s+/', '', $request->phone),
            'branch_owner_phone' => preg_replace('/\s+/', '', $request->branch_owner_phone),
        ]);

        if (in_array('Head Office', (array) $request->branch_type)) {
            $headOfficeExists = Branch::where('city_id', $request->city_id)
                ->whereJsonContains('type', 'Head Office')
                ->exists();

            if ($headOfficeExists) {
                return response()->json([
                    'success' => false,
                    'data' => ['city_id' => ['This city already have head office.']],
                    'message' => 'This city already have head office.'
                ], 422);
            }
        }

        try {
            
            $branch = null;
    
            DB::transaction(function () use ($request, &$branch) {
                
                $branch = new Branch();
                
                $branch->organisation_id = optional(Auth::user()->organisation)->id;
                $branch->location = $request->branch_location;
                
                //$branch->type = $request->branch_type;
                $branch->type = json_encode($request->branch_type);
                
                $branch->start_date = $request->start_date ?? null;
                $branch->code = $request->branch_code;
                $branch->head_name = $request->branch_head_name;
                $branch->ph_prefix = $request->phone_code;
                $branch->phone = $request->phone;
                $branch->no_of_employee = $request->no_of_employee;
                $branch->address = $request->address ?? null;
                $branch->state_id = $request->state_id;
                $branch->city_id = $request->city_id;
                $branch->postal_code = $request->post_code ?? null;
                $branch->branch_ownership = $request->branch_ownership ?? null;
                $branch->branch_owner_name = $request->branch_owner_name ?? null;
                $branch->branch_owner_phone_code = $request->branch_owner_phone_code ?? null;
                $branch->branch_owner_phone = $request->branch_owner_phone ?? null;
                $branch->rent_amount = $request->rent_amount ?? 0.00;
                $branch->rent_due_count = $request->rent_due_count ?? null;
                $branch->electricity_service_provider = $request->electricity_service_provider ?? null;
                $branch->electricity_consumer_number = $request->electricity_consumer_number ?? null;
                $branch->notes = $request->notes ?? null;
                $branch->status = $request->status;

                $branch->created_by = Auth::user()->id;
                $branch->save();
                
                
                if ($request->hasFile('documents')) {
                
                    $uploadPath = public_path('media' . DIRECTORY_SEPARATOR . 'branch');
                
                    // Create folder if not exists
                    if (!File::exists($uploadPath)) {
                        File::makeDirectory($uploadPath, 0755, true);
                    }
                    
                    foreach ($request->file('documents') as $file) {

                        $extension = $file->getClientOriginalExtension();
                
                        $filename = 'branch_' . time() . '_' . Str::random(6) . '.' . $extension;
                
                        // Move file
                        $file->move($uploadPath, $filename);
                
                        
                        $branchfile = new Branchfile();
                        $branchfile->branch_id = $branch->id;
                        $branchfile->file_name = $filename;
                        $branchfile->save();
                
                    }
                } 
    
                
                // Log user activity
                $this->storeUseractivity(21, 3, Auth::user()->id, $branch->id, 'Added new branch.');
            });
    
            $success = true;
            $respmessage = 'Branch saved successfully.';
    
        } catch (\Exception $exp) {
            
            \Log::error('Save error', [
                'message' => $exp->getMessage(),
                'trace' => $exp->getTraceAsString()
            ]);
    
            DB::rollBack();
            $success = false;
            $respmessage = $exp->getMessage();
        }
        
        return response()->json(['success' => $success, 'data' => $branch, 'message' => $respmessage]);
    }
    
    
    
    
    public function edit($id)
    {
        if($id == ''){
            return response()->json(['success' => false, 'data' => [], 'message' => 'Woops! id not found.']);
        }
        
        $branch = Branch::with(['files','state','city'])->find($id);
        
        if($branch == NULL){
            return response()->json(['success' => false, 'data' => [], 'message' => 'Branch not found.'], 422);
        }
        
        $states = State::whereHas('country', function ($q) {
                            $q->where('iso2', 'IN');
                        })
                        ->orderBy('name')
                        ->get();
        
        // Log activity
        $description = 'Retrieve a branch location named '.$branch->location.' to edit.';
        $useractivity = $this->storeUseractivity(21, 5, Auth::user()->id, $branch->id, $description);
        
        return view('branch.edit', compact('branch','states'));
    }
    
    
    public function update(UpdateBranchRequest $request)
    {
        $id = $request->get('branchid');

        if (!$id) {
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => 'Branch ID is missing.'
            ], 422);
        }

        $request->merge([
            'phone'              => preg_replace('/\s+/', '', $request->phone),
            'branch_owner_phone' => preg_replace('/\s+/', '', $request->branch_owner_phone),
        ]);

        if (in_array('Head Office', (array) $request->branch_type)) {
            $headOfficeExists = Branch::where('city_id', $request->city_id)
                ->whereJsonContains('type', 'Head Office')
                ->where('id', '!=', $id)
                ->exists();

            if ($headOfficeExists) {
                return response()->json([
                    'success' => false,
                    'data' => ['city_id' => ['This city already have head office.']],
                    'message' => 'This city already have head office.'
                ], 422);
            }
        }

        $branch = Branch::find($request->get('branchid'));
        
        if($branch == NULL){
            return response()->json(['success' => false, 'data' => [], 'message' => 'Woops ! Branch not found.'], 422);
        }
        
        
        
        try{
            
            
            DB::transaction(function () use($request, &$branch){
                
                $branch->location = $request->branch_location;
                $branch->type = json_encode($request->branch_type);
                $branch->start_date = $request->start_date ?? null;
                $branch->code = $request->branch_code;
                $branch->head_name = $request->branch_head_name;
                $branch->ph_prefix = $request->phone_code;
                $branch->phone = $request->phone;
                $branch->no_of_employee = $request->no_of_employee;
                $branch->address = $request->address ?? null;
                $branch->state_id = $request->state_id;
                $branch->city_id = $request->city_id;
                $branch->postal_code = $request->post_code ?? null;
                $branch->branch_ownership = $request->branch_ownership ?? null;
                $branch->branch_owner_name = $request->branch_owner_name ?? null;
                $branch->branch_owner_phone_code = $request->branch_owner_phone_code ?? null;
                $branch->branch_owner_phone = $request->branch_owner_phone ?? null;
                $branch->rent_amount = $request->rent_amount ?? 0.00;
                $branch->rent_due_count = $request->rent_due_count ?? null;
                $branch->electricity_service_provider = $request->electricity_service_provider ?? null;
                $branch->electricity_consumer_number = $request->electricity_consumer_number ?? null;
                $branch->notes = $request->notes ?? null;
                $branch->status = $request->status;
                $branch->updated_by = Auth::user()->id;
                $branch->save();
                
                // ================= DELETE FILES =================
                if ($request->filled('remove_files')) {
                
                    foreach ($request->remove_files as $fileId) {
                
                        if (!$fileId) continue;
                
                        $file = Branchfile::find($fileId);
                
                        if ($file) {
                
                            $path = public_path('media/branch/' . $file->file_name);
                
                            // Delete from disk
                            if (File::exists($path)) {
                                File::delete($path);
                            }
                
                            // Delete DB record
                            $file->delete();
                        }
                    }
                }

                
                
                // =========================
                // UPLOAD NEW FILES
                // =========================
                if ($request->hasFile('documents')) {
        
                    $uploadPath = public_path('media/branch');
        
                    if (!File::exists($uploadPath)) {
                        File::makeDirectory($uploadPath, 0755, true);
                    }
        
                    foreach ($request->file('documents') as $file) {
        
                        $filename = 'branch_' . time() . '_' . Str::random(6) . '.' .$file->getClientOriginalExtension();
        
                        $file->move($uploadPath, $filename);
                        
                        $branchfile = new Branchfile();
                        $branchfile->branch_id = $branch->id;
                        $branchfile->file_name = $filename;
                        $branchfile->save();
        
                    }
                }

        
                // =========================
                // ACTIVITY LOG
                // =========================
                $description = 'Updated a Branch.';
                $useractivity = $this->storeUseractivity(21, 4, Auth::user()->id, $branch->id, $description);
                
            });
            
            $success = true;
            $respmessage = 'Branch updated successfully.';
            
        } catch (\Exception $exp){
                                    
            DB::rollBack();
            $success = false;
            $respmessage = $exp->getMessage();
            
        }
        
        return response()->json(['success' => $success, 'data' => $branch, 'message' => $respmessage]);
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
    
        $branch = Branch::find($id);
        if (!$branch) {
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => 'Woops! Branch not found.'
            ]);
        }
        
        
        try{
            
            DB::transaction(function () use($request, $id, &$branch){
                
                $branch = Branch::find($id);
                $branch->delete(); // Perform delete operation
        
                $description = 'Deleted a Branch.';
                $useractivity = $this->storeUseractivity(21, 6, Auth::user()->id, $id, $description);
            });
            
            $success = true;
            $respmessage = 'Branch deleted successfully.';
            
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



