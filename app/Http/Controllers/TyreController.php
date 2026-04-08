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
        
        $this->storeUseractivity(66, 5, Auth::id(), $tyre->id, 'Tyre details retrieved');
        
        return view('tyre.show', compact('tyre', 'comments', 'attachmenttypes', 'mediadocuments', 'total_doc_count', 'expired_doc_count', 'expiring_doc_count'));
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
    
    
}








