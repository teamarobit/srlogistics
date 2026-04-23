<?php
  
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Support\Str;

use App\Models\Attachmenttype;
use App\Models\Contact;
use App\Models\Media;
use App\Models\Mediadocument;
use App\Models\Tyre;
use App\Models\TyreMaintenanceSchedule;
use App\Models\Tyrelog;

use Auth;

use Carbon\Carbon;

use App\Traits\Useractivity;

use App\Services\MediaDocumentService;

class TyreController extends Controller
{
    use Useractivity;
    
    public function dashboard(){
        $tyres_query = Tyre::query();
        $all_count = (clone $tyres_query)->count();
        $warehouse_count = (clone $tyres_query)->where('location', 'Warehouse')->count();
        $service_center_count = (clone $tyres_query)->where('location', 'Service Center')->count();
        $vehicle_count = (clone $tyres_query)->where('location', 'Vehicle')->count();
        $discarded_count = (clone $tyres_query)->where('tyre_condition', 'Discard')->count();
        
        $all_tyres = Tyre::latest()->paginate(10, ['*'], 'all_tyre_page');
        $warehouse_tyres = Tyre::where('location', 'Warehouse')->latest()->paginate(10, ['*'], 'warehouse_tyre_page');
        $service_center_tyres = Tyre::where('location', 'Service Center')->latest()->paginate(10, ['*'], 'service_center_tyre_page');
        $vehicle_tyres = Tyre::where('location', 'Vehicle')->latest()->paginate(10, ['*'], 'vehicle_tyre_page');
        $discarded_tyres = Tyre::where('tyre_condition', 'Discard')->latest()->paginate(10, ['*'], 'discarded_tyre_page');
        
        $this->storeUseractivity(66, 5, Auth::id(), 0, 'Tyre list retrieved.');
        
        return view('tyre.dashboard', compact('all_count', 'warehouse_count', 'service_center_count', 'vehicle_count', 'discarded_count', 'all_tyres', 'warehouse_tyres', 'service_center_tyres', 'vehicle_tyres', 'discarded_tyres'));
    }
    
    public function index(Request $request): View
    {   
        
        $tyres = Tyre::latest()->paginate(10);
        
        $this->storeUseractivity(66, 5, Auth::id(), 0, 'Tyre list retrieved.');
        return view('tyre.index', compact('tyres'));
    }
    
    public function create()
    {   
        $tyrevendors = Contact::where('cotype_id', 6)->where('status','Active')->get();
        
        return view('tyre.create',compact('tyrevendors'));
    }
    
    public function store(Request $request)
    {
        $rules = [
            'vendor'                => [
                                            'required',
                                            function($attribute, $value, $fail){
                                                if(!Contact::where('cotype_id', 6)->where('id', $value)->where('status', 'Active')->exists()){
                                                    $fail('Vendor is invalid or not active.');
                                                }
                                            }
                                        ],
            'condition'             => 'required|in:New,Re-thread',
            'tyre_model_name'       => 'required',
            'tyre_type'             => 'required|in:Radial,Nylon',
            'tyre_brand'            => 'required',
            'tyre_price'            => 'required|numeric|min:0',
            'tyre_serial_number'    => 'required',
            'tyre_purchase_date'    => 'required|date',
            'tyre_issue_date'       => 'required|date|after_or_equal:tyre_purchase_date',
            'tyre_warranty_months'  => 'required',
    
            'alignment_interval_km' => 'nullable|numeric|min:0',
            'rotation_interval_km'  => 'nullable|numeric|min:0',
    
            'fixed_run_km'          => 'nullable|numeric|min:0',
            'fixed_life_months'     => 'nullable|numeric|min:0',
            'actual_run_km'         => 'nullable|numeric|min:0',
            'actual_run_month'      => 'nullable|numeric|min:0',
            'last_alignment_km'     => 'nullable|numeric|min:0',
            'last_rotation_km'      => 'nullable|numeric|min:0',
            
            'files' => 'required|array|min:1',
            'files.*' => [
                'required',
                'file',
                'max:2048', // 2MB
                'mimes:jpg,jpeg,png,webp'
            ],
        ];
    
        $validator = Validator::make($request->all(), $rules, [
            'required' => 'This field is required.',
            'numeric'  => 'Only numeric values are allowed.',
            'min'      => 'Value must be at least :min.',
            'in'       => 'Invalid selection.',
        ]);
    
        if ($validator->fails()) {
            $errors = [];
    
            foreach ($validator->errors()->toArray() as $field => $messages) {
                $errors[$field] = $messages;
            }
    
            return response()->json([
                'data' => $errors,
                'message' => 'Please fill with valid data.'
            ], 422);
        }
    
        try {
            DB::transaction(function () use ($request) {
                $userId = Auth::id();
                $mediaData = [];
        
                foreach ($request->file('files') as $file) {
        
                    // unique file name
                    $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                    
                    $file_mime_type = $file->getClientMimeType();
                    $file_size = $file->getSize();
                    
                    $file->move(public_path('medias'.DIRECTORY_SEPARATOR.'tyre'.DIRECTORY_SEPARATOR),  $fileName );
        
                    $mediaData[] = [
                        'type'  => 'Image',
                        'file_name'  => $file->getClientOriginalName(),
                        'file_path'  => 'tyre/' . $fileName,
                        'file_type'  => $file_mime_type,
                        'file_size'  => $file_size,
                        'created_by'   => $userId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
    
                $data = [
                    'contact_id' => $request->vendor,
                    'location' => 'Warehouse',
                    'warehouse_id' => 1,
                    'tyre_condition' => $request->condition,
    
                    'tyre_model' => $request->tyre_model_name,
                    'tyre_type'  => $request->tyre_type,
                    'tyre_brand' => $request->tyre_brand,
                    'tyre_price' => $request->tyre_price,
                    'tyre_serial_number' => $request->tyre_serial_number,
    
                    'tyre_purchase_date' => date('Y-m-d', strtotime($request->tyre_purchase_date)),
                    'tyre_issue_date'    => date('Y-m-d', strtotime($request->tyre_issue_date)),
                    'tyre_warranty_months' => $request->tyre_warranty_months,
                    'tyre_warrenty_end_date'    => date('Y-m-d', strtotime('+' . $request->tyre_warranty_months . ' months', strtotime($request->tyre_purchase_date))),
    
                    'fixed_run_km' => $request->fixed_run_km,
                    'fixed_life_months' => $request->fixed_life_months,
                    'actual_run_km' => $request->actual_run_km,
                    'actual_run_month' => $request->actual_run_month,
    
                    'alignment_interval_km' => $request->alignment_interval_km,
                    'set_reminder_for_alignment' => $request->has('set_reminder_for_alignment') ? 'Yes' : 'No',
    
                    'rotation_interval_km' => $request->rotation_interval_km,
                    'set_reminder_for_rotation' => $request->has('set_reminder_for_rotation') ? 'Yes' : 'No',
    
                    'last_alignment_km' => $request->last_alignment_km,
                    'last_rotation_km' => $request->last_rotation_km,
    
                    'created_by' => $userId,
                ];
    
                $tyre = Tyre::create($data);
                if(count($mediaData) > 0){
                    $tyre->medias()->createMany($mediaData);
                }
    
                Tyrelog::create($data + [
                    'tyre_id' => $tyre->id
                ]);
    
                $this->storeUseractivity(66, 3, $userId, $tyre->id, 'Added tyre details.');
            });
    
            return response()->json([
                'success' => true,
                'message' => 'Tyre detail saved successfully.',
                'redirect_url' => route('tyre.dashboard')
            ]);
    
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }
    
    public function show(Tyre $tyre){
        $today = Carbon::today();
        $tenDaysLater = Carbon::today()->addDays(10);

        $comments = $tyre->comments()->latest()->get();
        $attachmenttypes = Attachmenttype::get();
        $mediaDocumentIds = $tyre->documents()->pluck('mediadocument_id')->toArray();
        $mediadocuments = Mediadocument::whereIn('id', $mediaDocumentIds)->get();
        $total_doc_count = $mediadocuments->count();
        $expired_doc_count = $mediadocuments->where('expiry_date', '<', $today)->count();
        $expiring_doc_count = $mediadocuments->where('expiry_date', '>=', $today)->where('expiry_date', '<=', $tenDaysLater)->count();

        $maintenanceSchedules = $tyre->maintenanceSchedules()
            ->orderByRaw("FIELD(status,'Overdue','Pending','Scheduled','Done')")
            ->orderBy('next_due_date')
            ->get();

        $this->storeUseractivity(66, 5, Auth::id(), $tyre->id, 'Tyre details retrieved');

        return view('tyre.show', compact(
            'tyre', 'comments', 'attachmenttypes',
            'mediadocuments', 'total_doc_count', 'expired_doc_count', 'expiring_doc_count',
            'maintenanceSchedules'
        ));
    }

    // ── Maintenance Schedule CRUD ──────────────────────────────────────────────

    public function storeMaintenance(Request $request, Tyre $tyre)
    {
        $request->validate([
            'maintenance_item' => 'required|string|max:255',
            'last_done_date'   => 'nullable|date',
            'next_due_date'    => 'nullable|date',
            'odometer_km'      => 'nullable|integer|min:0',
            'status'           => 'required|in:Scheduled,Pending,Done,Overdue',
            'notes'            => 'nullable|string|max:1000',
        ]);

        try {
            DB::transaction(function () use ($request, $tyre) {
                $tyre->maintenanceSchedules()->create([
                    'maintenance_item' => $request->maintenance_item,
                    'last_done_date'   => $request->last_done_date,
                    'next_due_date'    => $request->next_due_date,
                    'odometer_km'      => $request->odometer_km,
                    'status'           => $request->status,
                    'notes'            => $request->notes,
                    'created_by'       => Auth::id(),
                    'updated_by'       => Auth::id(),
                ]);
            });

            return response()->json(['message' => 'Maintenance schedule added successfully.']);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Something went wrong.', 'error' => $e->getMessage()], 500);
        }
    }

    public function updateMaintenance(Request $request, Tyre $tyre, TyreMaintenanceSchedule $schedule)
    {
        $request->validate([
            'maintenance_item' => 'required|string|max:255',
            'last_done_date'   => 'nullable|date',
            'next_due_date'    => 'nullable|date',
            'odometer_km'      => 'nullable|integer|min:0',
            'status'           => 'required|in:Scheduled,Pending,Done,Overdue',
            'notes'            => 'nullable|string|max:1000',
        ]);

        try {
            $schedule->update([
                'maintenance_item' => $request->maintenance_item,
                'last_done_date'   => $request->last_done_date,
                'next_due_date'    => $request->next_due_date,
                'odometer_km'      => $request->odometer_km,
                'status'           => $request->status,
                'notes'            => $request->notes,
                'updated_by'       => Auth::id(),
            ]);

            return response()->json(['message' => 'Maintenance schedule updated successfully.']);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Something went wrong.', 'error' => $e->getMessage()], 500);
        }
    }

    public function destroyMaintenance(Tyre $tyre, TyreMaintenanceSchedule $schedule)
    {
        try {
            $schedule->delete();
            return response()->json(['message' => 'Maintenance schedule deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Something went wrong.', 'error' => $e->getMessage()], 500);
        }
    }
    
    public function edit(Tyre $tyre)
    {   
        $tyrevendors = Contact::where('cotype_id', 6)->where('status','Active')->get();
        
        $this->storeUseractivity(66, 5, Auth::id(), $tyre->id, 'Tyre details retrieved.');
        
        return view('tyre.edit',compact('tyre', 'tyrevendors'));
    }
    
    public function update(Request $request, Tyre $tyre)
    {
        $rules = [
            'vendor' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!Contact::where('cotype_id', 6)->where('id', $value)->where('status', 'Active')->exists()) {
                        $fail('Vendor is invalid or not active.');
                    }
                }
            ],
            'condition'             => 'required|in:New,Re-thread',
            'tyre_model_name'       => 'required',
            'tyre_type'             => 'required|in:Radial,Nylon',
            'tyre_brand'            => 'required',
            'tyre_price'            => 'required|numeric|min:0',
            'tyre_serial_number'    => 'required',
            'tyre_purchase_date'    => 'required|date',
            'tyre_issue_date'       => 'required|date|after_or_equal:tyre_purchase_date',
            'tyre_warranty_months'  => 'required',
    
            'alignment_interval_km' => 'nullable|numeric|min:0',
            'rotation_interval_km'  => 'nullable|numeric|min:0',
    
            'fixed_run_km'          => 'nullable|numeric|min:0',
            'fixed_life_months'     => 'nullable|numeric|min:0',
            'actual_run_km'         => 'nullable|numeric|min:0',
            'actual_run_month'      => 'nullable|numeric|min:0',
            'last_alignment_km'     => 'nullable|numeric|min:0',
            'last_rotation_km'      => 'nullable|numeric|min:0',
            
            
            'files' => 'nullable|array',
            'files.*' => [
                'file',
                'max:2048', // 2MB
                'mimes:jpg,jpeg,png,webp'
            ],
        ];
        
        if(!$tyre->images()->count()){
            $rules['files'] = 'required|array|min:1';
            $rules['files.*'] = [
                'required',
                'file',
                'max:2048', // 2MB
                'mimes:jpg,jpeg,png,webp'
            ];
        }
    
        $validator = Validator::make($request->all(), $rules, [
            'required' => 'This field is required.',
            'numeric'  => 'Only numeric values are allowed.',
            'min'      => 'Value must be at least :min.',
            'in'       => 'Invalid selection.',
        ]);
    
        if ($validator->fails()) {
            $errors = [];
    
            foreach ($validator->errors()->toArray() as $field => $messages) {
                $errors[$field] = $messages;
            }
    
            return response()->json([
                'data' => $errors,
                'message' => 'Please fill with valid data.'
            ], 422);
        }
    
        try {
            DB::transaction(function () use ($request, $tyre) {
                $userId = Auth::id();
    
                $mediaData = [];
                if($request->file('files')){
                    foreach ($request->file('files') as $file) {
            
                        // unique file name
                        $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                        
                        $file_mime_type = $file->getClientMimeType();
                        $file_size = $file->getSize();
                        
                        $file->move(public_path('medias'.DIRECTORY_SEPARATOR.'tyre'.DIRECTORY_SEPARATOR),  $fileName );
            
                        $mediaData[] = [
                            'type'  => 'Image',
                            'file_name'  => $file->getClientOriginalName(),
                            'file_path'  => 'tyre/' . $fileName,
                            'file_type'  => $file_mime_type,
                            'file_size'  => $file_size,
                            'created_by'   => $userId,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }
                }
    
                $data = [
                    'contact_id' => $request->vendor,
                    'tyre_condition' => $request->condition,
    
                    'tyre_model' => $request->tyre_model_name,
                    'tyre_type'  => $request->tyre_type,
                    'tyre_brand' => $request->tyre_brand,
                    'tyre_price' => $request->tyre_price,
                    'tyre_serial_number' => $request->tyre_serial_number,
    
                    'tyre_purchase_date' => date('Y-m-d', strtotime($request->tyre_purchase_date)),
                    'tyre_issue_date'    => date('Y-m-d', strtotime($request->tyre_issue_date)),
                    'tyre_warranty_months' => $request->tyre_warranty_months,
                    'tyre_warrenty_end_date' => date('Y-m-d', strtotime('+' . $request->tyre_warranty_months . ' months', strtotime($request->tyre_purchase_date))),
    
                    'fixed_run_km' => $request->fixed_run_km,
                    'fixed_life_months' => $request->fixed_life_months,
                    'actual_run_km' => $request->actual_run_km,
                    'actual_run_month' => $request->actual_run_month,
    
                    'alignment_interval_km' => $request->alignment_interval_km,
                    'set_reminder_for_alignment' => $request->has('set_reminder_for_alignment') ? 'Yes' : 'No',
    
                    'rotation_interval_km' => $request->rotation_interval_km,
                    'set_reminder_for_rotation' => $request->has('set_reminder_for_rotation') ? 'Yes' : 'No',
    
                    'last_alignment_km' => $request->last_alignment_km,
                    'last_rotation_km' => $request->last_rotation_km,
    
                    'updated_by' => $userId,
                ];
    
                $tyre->update($data);
                
                if(count($mediaData) > 0){
                    $tyre->medias()->createMany($mediaData);
                }
                
                unset($data['updated_by']);
                $data['created_by'] = $userId;
    
                Tyrelog::create($data + [
                    'tyre_id' => $tyre->id
                ]);
    
                $this->storeUseractivity(66, 4, $userId, $tyre->id, 'Updated tyre details.');
            });
    
            return response()->json([
                'success' => true,
                'message' => 'Tyre detail updated successfully.',
                'redirect_url' => route('tyre.dashboard')
            ]);
    
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }
    
    public function markAsDiscard(Request $request, Tyre $tyre){
        if($tyre->tyre_condition == 'Discard'){
            return response()->json(['message' => 'Tyre has already been discarded.'], 422);
        }
        
        $request->validate([
                'note' => 'required|max:255'
            ]);
            
        try {
            DB::transaction(function () use ($request, $tyre) {
    
                $userId = Auth::id();
    
                $tyre->update([
                    'tyre_condition' => 'Discard',
                    'discard_note'   => $request->note,
                    'discard_date'   => now(),
                    'updated_by'     => $userId,
                ]);
    
                Tyrelog::create([
                    'tyre_id'        => $tyre->id,
                    'contact_id' => $tyre->contact_id,
                    'tyre_condition' => 'Discard',
    
                    'tyre_model' => $tyre->tyre_model,
                    'tyre_type'  => $tyre->tyre_type,
                    'tyre_brand' => $tyre->tyre_brand,
                    'tyre_price' => $tyre->tyre_price,
                    'tyre_serial_number' => $tyre->tyre_serial_number,
    
                    'tyre_purchase_date' => $tyre->tyre_purchase_date,
                    'tyre_issue_date'    => $tyre->tyre_issue_date,
                    'tyre_warranty_months' => $tyre->tyre_warranty_months,
                    'tyre_warrenty_end_date' => $tyre->tyre_warrenty_end_date,
    
                    'fixed_run_km' => $tyre->fixed_run_km,
                    'fixed_life_months' => $tyre->fixed_life_months,
                    'actual_run_km' => $tyre->actual_run_km,
                    'actual_run_month' => $tyre->actual_run_month,
    
                    'alignment_interval_km' => $tyre->alignment_interval_km,
                    'set_reminder_for_alignment' => $tyre->set_reminder_for_alignment,
    
                    'rotation_interval_km' => $tyre->rotation_interval_km,
                    'set_reminder_for_rotation' => $tyre->set_reminder_for_rotation,
    
                    'last_alignment_km' => $tyre->last_alignment_km,
                    'last_rotation_km' => $tyre->last_rotation_km,
                    
                    'discard_note'   => $request->note,
                    'discard_date'   => now(),
                    'created_by'     => $userId,
                ]);
    
                $this->storeUseractivity(66, 4, $userId, $tyre->id, 'Tyre marked as discard.');
            });
    
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
        
        return response()->json(['message' => 'Tyre has been discarded successfully.']);
    }
    
    public function storeComment(Request $request, Tyre $tyre)
    {
        $request->validate([
            'comment' => 'required|string|max:1000',
        ]);
    
        try {
            DB::transaction(function () use ($request, $tyre) {
                $userId = Auth::id();
                
                $tyre->comments()->create([
                    'comment'      => $request->comment,
                    'created_by'   => $userId,
                ]);
    
            });
    
            return response()->json([
                'message' => 'Comment added successfully'
            ]);
    
        } catch (\Exception $e) {
    
            return response()->json([
                'message' => 'Something went wrong',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
    
    public function storeDocument(Request $request, Tyre $tyre, MediaDocumentService $service){
        $rules = [
                    'files' => 'required|array|min:1',
                    'files.*' => 'required|file|max:2048|mimes:jpg,jpeg,png,webp,pdf',
                
                    'attachment_type' => 'required',
                
                    'document_number' => 'required|string|max:100',
                    'issue_date' => 'nullable|date',
                    'expiry_date' => 'nullable|date|after:issue_date',
                
                    'set_reminder' => 'nullable',
                    'reminder_days' => 'required_if:set_reminder,1|nullable|integer|min:1',
                
                    'notes' => 'nullable|string|max:500',
                ];
        
        $validator = Validator::make($request->all(), $rules, [
            'required' => 'This field is required.',
            'numeric'  => 'Only numeric values are allowed.',
            'min'      => 'Value must be at least :min.',
            'in'       => 'Invalid selection.',
        ]);
    
        if ($validator->fails()) {
            $errors = [];
    
            foreach ($validator->errors()->toArray() as $field => $messages) {
                $errors[$field] = $messages;
            }
    
            return response()->json([
                'data' => $errors,
                'message' => 'Please fill with valid data.'
            ], 422);
        }
        
        try{
            $document = $service->storeDocument($tyre, $request->all());
        }catch(\Exception $e){
            return response()->json(['message' => $e->getMessage()], 422);
        }

        return response()->json([
            'message' => 'Document uploaded successfully',
            'data' => $document
        ]);
    }
    
    public function updateDocument(Request $request, Mediadocument $mediadocument, MediaDocumentService $service){
        $request->merge([
                            'issue_date' => $request->issue_date 
                                ? \Carbon\Carbon::createFromFormat('d/m/Y', $request->issue_date)->format('Y-m-d')
                                : null,
                        
                            'expiry_date' => $request->expiry_date 
                                ? \Carbon\Carbon::createFromFormat('d/m/Y', $request->expiry_date)->format('Y-m-d')
                                : null,
                        ]);
        $rules = [
                    'files' => 'nullable|array',
                    'files.*' => 'file|max:2048|mimes:jpg,jpeg,png,webp,pdf',
                
                    'attachment_type' => 'required',
                
                    'document_number' => 'required|string|max:100',
                    'issue_date' => 'required|date',
                    'expiry_date' => 'nullable|date|after:issue_date',
                
                    'set_reminder' => 'nullable',
                    'reminder_days' => 'required_if:set_reminder,1|nullable|integer|min:1',
                
                    'notes' => 'nullable|string|max:500',
                ];
        
        $validator = Validator::make($request->all(), $rules, [
            'required' => 'This field is required.',
            'numeric'  => 'Only numeric values are allowed.',
            'min'      => 'Value must be at least :min.',
            'in'       => 'Invalid selection.',
        ]);
    
        if ($validator->fails()) {
            $errors = [];
    
            foreach ($validator->errors()->toArray() as $field => $messages) {
                $errors[$field] = $messages;
            }
    
            return response()->json([
                'data' => $errors,
                'message' => 'Please fill with valid data.'
            ], 422);
        }
        
        try{
            $tyre = $mediadocument->medias()->first()?->mediable;
            $document = $service->updateDocument($tyre, $mediadocument, $request->all());
        }catch(\Exception $e){
            return response()->json(['message' => $e->getMessage()], 422);
        }

        return response()->json([
            'message' => 'Document updated successfully',
            'data' => $document
        ]);
    }
    
    public function destroyDocument(Media $media){
        $mediadocument = $media->mediadocument;
        if($mediadocument->medias()->count() < 2){
            return response()->json(['message' => 'You cannot delete this as atleast one document should be there.'], 422);
        }

        try{
            DB::transaction(function() use ($media){
                $media->delete();
                $this->storeUseractivity(71, 6, Auth::id(), $media->id, 'Media deleted.');
            });
        }catch(\Exception $e){
            return response()->json(['message' => $e->getMessage()], 422);
        }

        return response()->json(['message' => 'Document deleted successfully.']);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Redesigned Create Page (Battery-add style)
    // Route: GET  tyres/create-new     → createNew()
    // Route: POST tyres/save-new       → storeNew()
    // NOTE: Must not affect existing create()/store() — separate endpoints only.
    // ─────────────────────────────────────────────────────────────────────────

    public function createNew()
    {
        $tyrevendors = Contact::where('cotype_id', 6)->where('status', 'Active')->get();
        $warehouses  = \App\Models\Warehouse::where('status', 'Active')
            ->orderBy('warehouse_type')
            ->orderBy('name')
            ->get(['id', 'name', 'warehouse_type']);

        $workshops   = \App\Models\Workshop::active()
            ->orderBy('ownership')
            ->orderBy('name')
            ->get(['id', 'name', 'workshop_code', 'ownership']);

        return view('tyre.create-new', compact('tyrevendors', 'warehouses', 'workshops'));
    }

    public function storeNew(Request $request)
    {
        $rules = [
            // Source
            'tyre_source_mode'           => 'required|in:Existing,New PO,Fitment',
            'source_origin_note'         => 'nullable|string|max:500|required_unless:tyre_source_mode,Fitment',
            'fitment_source_origin_note' => 'nullable|string|max:500|required_if:tyre_source_mode,Fitment',
            'purchase_order_reference'   => 'nullable|string|max:100|required_if:tyre_source_mode,New PO',
            'invoice_reference'          => 'nullable|string|max:100',
            'invoice_file'               => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'fitment_invoice_file'       => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',

            // Identity
            'tyre_serial_number'      => 'required|string|max:100|unique:tyres,tyre_serial_number,NULL,id,deleted_at,NULL',
            'vendor'                  => [
                'required',
                function ($attribute, $value, $fail) {
                    if (! Contact::where('cotype_id', 6)->where('id', $value)->where('status', 'Active')->exists()) {
                        $fail('Vendor is invalid or not active.');
                    }
                },
            ],
            'tyre_brand'              => 'required|string|max:100',
            'tyre_model_name'         => 'required|string|max:100',
            'tyre_type'               => 'required|in:Radial,Nylon',
            'tyre_size'               => 'required|string|max:50',

            // Classification
            'condition'               => 'required|in:New,Used,Retread',
            'tyre_category'           => 'required|in:Drive,Steer,Trailer',

            // Stock Location — single radio group value:
            //   ''              → not assigned
            //   'wh:<id>'       → warehouse
            //   'ws:<id>'       → workshop
            //   'fitment'       → direct fitment to vehicle
            'stock_location'          => ['nullable', 'string', 'regex:/^(wh:\d+|ws:\d+|fitment)?$/'],

            // Purchase & Cost
            'tyre_price'              => 'required|numeric|min:0',
            'tyre_purchase_date'      => 'required|date|before_or_equal:today',
            'tyre_warranty_months'    => 'required|integer|min:0|max:120',

            // Lifecycle & Usage
            'tyre_issue_date'         => 'nullable|date|after_or_equal:tyre_purchase_date',
            'fixed_run_km'            => 'required|integer|min:0',
            'fixed_life_months'       => 'required|integer|min:0|max:240',
            'actual_run_km'           => 'nullable|integer|min:0',
            'actual_run_month'        => 'nullable|integer|min:0',

            // Maintenance & Reminders
            'last_alignment_km'         => 'nullable|integer|min:0',
            'last_rotation_km'          => 'nullable|integer|min:0',
            'alignment_interval_km'     => 'nullable|integer|min:1|required_if:set_reminder_for_alignment,1',
            'rotation_interval_km'      => 'nullable|integer|min:1|required_if:set_reminder_for_rotation,1',
            'set_reminder_for_alignment'=> 'nullable|in:0,1',
            'set_reminder_for_rotation' => 'nullable|in:0,1',

            // Allocation (optional on create)
            'allocated_vehicle_id'    => 'nullable|integer',
            'installation_date'       => 'nullable|date|required_with:allocated_vehicle_id',

            // Technical
            'ply_rating'              => 'required|integer|min:4|max:24',
            'load_index'              => 'nullable|integer|min:0|max:300',
            'speed_rating'            => 'nullable|string|max:2',
            'tread_depth_mm'          => 'nullable|numeric|min:0|max:50',
            'tube_type'               => 'required|in:Tube,Tubeless',

            // Initial Condition
            'initial_condition'       => 'required|in:New,Retreaded,Used Good,Scrap',

            // Notes
            'notes'                   => 'nullable|string|max:2000',

            // Images
            'files'                   => 'required|array|min:1|max:4',
            'files.*'                 => 'required|file|mimes:jpg,jpeg,png,webp|max:3072',
        ];

        $validator = Validator::make($request->all(), $rules, [
            'required'    => 'This field is required.',
            'numeric'     => 'Only numeric values are allowed.',
            'integer'     => 'Only whole numbers are allowed.',
            'min'         => 'Value must be at least :min.',
            'max'         => 'Value must not exceed :max.',
            'in'          => 'Invalid selection.',
            'date'        => 'Invalid date.',
            'before_or_equal' => 'Date cannot be in the future.',
            'after_or_equal'  => 'Date must be on or after the Purchase Date.',
            'unique'      => 'This serial number is already taken.',
            'required_if' => 'This field is required.',
            'required_with' => 'This field is required.',
            'mimes'       => 'Invalid file type.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data'    => $validator->errors()->toArray(),
                'errors'  => $validator->errors()->toArray(), // also expose as .errors for shared JS helpers
                'message' => 'Please fill the form with valid data.',
            ], 422);
        }

        try {
            $tyre = DB::transaction(function () use ($request) {
                $userId = Auth::id();
                $orgId  = Auth::user()->organisation_id ?? 1; // SD-12

                // Ensure target upload directories exist (safe in tests + first-run prod)
                $tyreDir         = public_path('medias' . DIRECTORY_SEPARATOR . 'tyre');
                $tyreInvoicesDir = $tyreDir . DIRECTORY_SEPARATOR . 'invoices';
                if (! is_dir($tyreDir))         { @mkdir($tyreDir, 0775, true); }
                if (! is_dir($tyreInvoicesDir)) { @mkdir($tyreInvoicesDir, 0775, true); }

                // 1) Move invoice file if provided (fitment mode uses fitment_invoice_file)
                $invoiceFilePath = null;
                $invoiceFileKey  = $request->tyre_source_mode === 'Fitment' ? 'fitment_invoice_file' : 'invoice_file';
                if ($request->hasFile($invoiceFileKey)) {
                    $file = $request->file($invoiceFileKey);
                    $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                    $file->move($tyreInvoicesDir, $fileName);
                    $invoiceFilePath = 'tyre/invoices/' . $fileName;
                }

                // 2) Image media records (same pattern as existing store())
                $mediaData = [];
                foreach ($request->file('files') as $file) {
                    $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                    $mime     = $file->getClientMimeType();
                    $size     = $file->getSize();
                    $file->move($tyreDir, $fileName);
                    $mediaData[] = [
                        'type'       => 'Image',
                        'file_name'  => $file->getClientOriginalName(),
                        'file_path'  => 'tyre/' . $fileName,
                        'file_type'  => $mime,
                        'file_size'  => $size,
                        'created_by' => $userId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }

                // 3) Auto-calculations
                $purchaseDate = date('Y-m-d', strtotime($request->tyre_purchase_date));
                $warrantyEnd  = date('Y-m-d', strtotime('+' . (int)$request->tyre_warranty_months . ' months', strtotime($purchaseDate)));
                $endOfLife    = date('Y-m-d', strtotime('+' . (int)$request->fixed_life_months . ' months', strtotime($purchaseDate)));

                // 4) Serial trim + uppercase for consistency (BR-4)
                $serial = strtoupper(trim((string)$request->tyre_serial_number));

                // 5) Parse Stock Location single-value radio group (wh:<id> | ws:<id> | 'fitment' | '')
                $warehouseId  = null;
                $workshopId   = null;
                $locationTag  = 'Warehouse';      // high-level location label
                $stockStatus  = 'Warehouse';      // stock_status ENUM: Warehouse|Mounted|In Transit
                $currentStatus = 'Warehouse';     // current_status ENUM: Warehouse|Allocated|Workshop|Discarded
                $stockLoc     = (string) $request->stock_location;
                if ($stockLoc === 'fitment') {
                    // Tyre being directly fitted to a vehicle
                    $locationTag   = 'Vehicle';
                    $stockStatus   = 'Mounted';
                    $currentStatus = 'Allocated';
                } elseif ($stockLoc !== '' && preg_match('/^(wh|ws):(\d+)$/', $stockLoc, $m)) {
                    if ($m[1] === 'wh') {
                        $warehouseId   = (int) $m[2];
                        $locationTag   = 'Warehouse';
                        $stockStatus   = 'Warehouse';
                        $currentStatus = 'Warehouse';
                    } else { // 'ws'
                        $workshopId    = (int) $m[2];
                        $locationTag   = 'Workshop';
                        // stock_status ENUM lacks 'Workshop' — mark as In Transit until further action
                        $stockStatus   = 'In Transit';
                        $currentStatus = 'Workshop';
                    }
                }

                $data = [
                    'organisation_id'           => $orgId,                              // SD-12
                    'location'                  => $locationTag,
                    'warehouse_id'              => $warehouseId,
                    'workshop_id'               => $workshopId,
                    'stock_status'              => $stockStatus,
                    'current_status'            => $currentStatus,
                    'allocated_vehicle_id'      => $request->allocated_vehicle_id,
                    'installation_date'         => $request->installation_date ? date('Y-m-d', strtotime($request->installation_date)) : null,

                    'contact_id'                => $request->vendor,
                    'tyre_condition'            => $request->condition,                 // New|Used|Retread
                    'initial_condition'         => $request->initial_condition,         // New|Retreaded|Used Good|Scrap

                    'tyre_source_mode'          => $request->tyre_source_mode,
                    'source_origin_note'        => $request->tyre_source_mode === 'Fitment'
                                                        ? $request->fitment_source_origin_note
                                                        : $request->source_origin_note,
                    'purchase_order_reference'  => $request->purchase_order_reference,
                    'invoice_reference'         => $request->invoice_reference,
                    'invoice_file_path'         => $invoiceFilePath,

                    'tyre_brand'                => $request->tyre_brand,
                    'tyre_model'                => $request->tyre_model_name,
                    'tyre_type'                 => $request->tyre_type,
                    'tyre_size'                 => $request->tyre_size,
                    'tyre_category'             => $request->tyre_category,
                    'tyre_serial_number'        => $serial,
                    'tyre_price'                => $request->tyre_price,

                    'tyre_purchase_date'        => $purchaseDate,
                    'tyre_issue_date'           => $request->tyre_issue_date ? date('Y-m-d', strtotime($request->tyre_issue_date)) : null,
                    'tyre_warranty_months'      => $request->tyre_warranty_months,
                    'tyre_warrenty_end_date'    => $warrantyEnd,
                    'end_of_life_date'          => $endOfLife,

                    'fixed_run_km'              => $request->fixed_run_km,
                    'fixed_life_months'         => $request->fixed_life_months,
                    'actual_run_km'             => $request->actual_run_km,
                    'actual_run_month'          => $request->actual_run_month,

                    'alignment_interval_km'     => $request->alignment_interval_km,
                    'set_reminder_for_alignment'=> $request->input('set_reminder_for_alignment') ? 'Yes' : 'No',
                    'rotation_interval_km'      => $request->rotation_interval_km,
                    'set_reminder_for_rotation' => $request->input('set_reminder_for_rotation') ? 'Yes' : 'No',
                    'last_alignment_km'         => $request->last_alignment_km,
                    'last_rotation_km'          => $request->last_rotation_km,

                    'ply_rating'                => $request->ply_rating,
                    'load_index'                => $request->load_index,
                    'speed_rating'              => $request->speed_rating,
                    'tread_depth_mm'            => $request->tread_depth_mm,
                    'tube_type'                 => $request->tube_type,

                    'notes'                     => $request->notes,

                    'created_by'                => $userId,
                ];

                $tyre = Tyre::create($data);
                if (count($mediaData) > 0) {
                    $tyre->medias()->createMany($mediaData);
                }

                // Log (SD-6 — multi-table writes inside one transaction).
                // tyrelogs has a narrower schema than tyres — pick only columns that exist
                // on the log table so this never blows up on a missing column.
                $logColumns = [
                    'location',
                    'warehouse_id',
                    'contact_id',
                    'tyre_condition',
                    'tyre_model',
                    'tyre_type',
                    'tyre_brand',
                    'tyre_price',
                    'tyre_serial_number',
                    'tyre_purchase_date',
                    'tyre_issue_date',
                    'tyre_warranty_months',
                    'tyre_warrenty_end_date',
                    'fixed_run_km',
                    'fixed_life_months',
                    'actual_run_km',
                    'actual_run_month',
                    'alignment_interval_km',
                    'set_reminder_for_alignment',
                    'rotation_interval_km',
                    'set_reminder_for_rotation',
                    'last_alignment_km',
                    'last_rotation_km',
                    'discard_note',
                    'discard_date',
                    'created_by',
                ];
                $logData = array_intersect_key($data, array_flip($logColumns));
                $logData['tyre_id'] = $tyre->id;
                Tyrelog::create($logData);

                $this->storeUseractivity(66, 3, $userId, $tyre->id, 'Added tyre via create-new.');

                return $tyre; // SD-5 — return from transaction closure
            });

            return response()->json([
                'success'      => true,
                'message'      => 'Tyre added to inventory successfully.',
                'redirect_url' => route('tyre.dashboard'),
                'tyre_id'      => $tyre->id,
            ], 200); // SD-9

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong: ' . $e->getMessage(),
            ], 500); // SD-9
        }
    }


}








