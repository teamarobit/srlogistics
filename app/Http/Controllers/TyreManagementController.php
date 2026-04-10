<?php
  
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Support\Str;

use App\Models\Tyreposition;
use App\Models\Vehicle;
use App\Models\Vehicletyremapping;
use App\Models\Vehicletyremappinglog;

use Auth;

use Carbon\Carbon;

use App\Traits\Useractivity;

class TyreManagementController extends Controller
{
    use Useractivity;
    
    public function vehicleTyreTagging(Vehicle $vehicle){
        $mounted_tyrepositions = Tyreposition::where('status', 'Active')->take($vehicle->mounted_tyre_count)->get();
        if(!$vehicle->vehicletyremappings()->count()){
            if($mounted_tyrepositions->count()){
                foreach($mounted_tyrepositions as $mounted_tyreposition){
                    $data = [
                                    'vehicle_id' => $vehicle->id,
                                    'tyre_id' => NULL,
                                    'tyreposition_id' => $mounted_tyreposition->id,
                                    'status' => 'Inactive',
                                    'created_by' => Auth::id(),
                                    'created_at' => now(),
                                ];
                    $vehicletyremapping = Vehicletyremapping::create($data);
                    $data['vehicletyremapping_id'] = $vehicletyremapping->id;
                    Vehicletyremappinglog::create($data);
                }
            }else{
                return redirect()->back();
            }
        }
        
        $vehicle->load('vehicletyremappings');
        // $this->storeUseractivity(66, 5, Auth::id(), 0, 'Tyre list retrieved.');
        $tyrepositions = Tyreposition::where('status', 'Active')->get();
        
        return view('tyremanagement.vehicletyretagging', compact('tyrepositions', 'vehicle'));
    }
    
    public function tagTyreToVehicle(Request $request, Vehicle $vehicle){
        $rules = [];
        
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
    }
    
    public function getTyreList(Request $request){
        $condition = $request->condition;
        $type = $request->type;
        $tyres = [];
        if(!empty($condition) && !empty($type)){
            $tyres = Tyre::where('location', 'Warehouse')->where('tyre_type', $type)->where('tyre_condition', $condition)->get();
        }
        
        return response()->json(['tyres' => $tyres, 'message' => 'Tyre fetched successfully']);
    }
    
    // public function store(Request $request)
    // {
    //     $rules = [
    //         'vendor'                => [
    //                                         'required',
    //                                         function($attribute, $value, $fail){
    //                                             if(!Contact::where('cotype_id', 6)->where('id', $value)->where('status', 'Active')->exists()){
    //                                                 $fail('Vendor is invalid or not active.');
    //                                             }
    //                                         }
    //                                     ],
    //         'condition'             => 'required|in:New,Re-thread',
    //         'tyre_model_name'       => 'required',
    //         'tyre_type'             => 'required|in:Radial,Nylon',
    //         'tyre_brand'            => 'required',
    //         'tyre_price'            => 'required|numeric|min:0',
    //         'tyre_serial_number'    => 'required',
    //         'tyre_purchase_date'    => 'required|date',
    //         'tyre_issue_date'       => 'required|date|after_or_equal:tyre_purchase_date',
    //         'tyre_warranty_months'  => 'required',
    
    //         'alignment_interval_km' => 'nullable|numeric|min:0',
    //         'rotation_interval_km'  => 'nullable|numeric|min:0',
    
    //         'fixed_run_km'          => 'nullable|numeric|min:0',
    //         'fixed_life_months'     => 'nullable|numeric|min:0',
    //         'actual_run_km'         => 'nullable|numeric|min:0',
    //         'actual_run_month'      => 'nullable|numeric|min:0',
    //         'last_alignment_km'     => 'nullable|numeric|min:0',
    //         'last_rotation_km'      => 'nullable|numeric|min:0',
            
    //         'files' => 'required|array|min:1',
    //         'files.*' => [
    //             'required',
    //             'file',
    //             'max:2048', // 2MB
    //             'mimes:jpg,jpeg,png,webp'
    //         ],
    //     ];
    
    //     $validator = Validator::make($request->all(), $rules, [
    //         'required' => 'This field is required.',
    //         'numeric'  => 'Only numeric values are allowed.',
    //         'min'      => 'Value must be at least :min.',
    //         'in'       => 'Invalid selection.',
    //     ]);
    
    //     if ($validator->fails()) {
    //         $errors = [];
    
    //         foreach ($validator->errors()->toArray() as $field => $messages) {
    //             $errors[$field] = $messages;
    //         }
    
    //         return response()->json([
    //             'data' => $errors,
    //             'message' => 'Please fill with valid data.'
    //         ], 422);
    //     }
    
    //     try {
    //         DB::transaction(function () use ($request) {
    //             $userId = Auth::id();
    //             $mediaData = [];
        
    //             foreach ($request->file('files') as $file) {
        
    //                 // unique file name
    //                 $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                    
    //                 $file_mime_type = $file->getClientMimeType();
    //                 $file_size = $file->getSize();
                    
    //                 $file->move(public_path('medias'.DIRECTORY_SEPARATOR.'tyre'.DIRECTORY_SEPARATOR),  $fileName );
        
    //                 $mediaData[] = [
    //                     'type'  => 'Image',
    //                     'file_name'  => $file->getClientOriginalName(),
    //                     'file_path'  => 'tyre/' . $fileName,
    //                     'file_type'  => $file_mime_type,
    //                     'file_size'  => $file_size,
    //                     'created_by'   => $userId,
    //                     'created_at' => now(),
    //                     'updated_at' => now(),
    //                 ];
    //             }
    
    //             $data = [
    //                 'contact_id' => $request->vendor,
    //                 'location' => 'Warehouse',
    //                 'warehouse_id' => 1,
    //                 'tyre_condition' => $request->condition,
    
    //                 'tyre_model' => $request->tyre_model_name,
    //                 'tyre_type'  => $request->tyre_type,
    //                 'tyre_brand' => $request->tyre_brand,
    //                 'tyre_price' => $request->tyre_price,
    //                 'tyre_serial_number' => $request->tyre_serial_number,
    
    //                 'tyre_purchase_date' => date('Y-m-d', strtotime($request->tyre_purchase_date)),
    //                 'tyre_issue_date'    => date('Y-m-d', strtotime($request->tyre_issue_date)),
    //                 'tyre_warranty_months' => $request->tyre_warranty_months,
    //                 'tyre_warrenty_end_date'    => date('Y-m-d', strtotime('+' . $request->tyre_warranty_months . ' months', strtotime($request->tyre_purchase_date))),
    
    //                 'fixed_run_km' => $request->fixed_run_km,
    //                 'fixed_life_months' => $request->fixed_life_months,
    //                 'actual_run_km' => $request->actual_run_km,
    //                 'actual_run_month' => $request->actual_run_month,
    
    //                 'alignment_interval_km' => $request->alignment_interval_km,
    //                 'set_reminder_for_alignment' => $request->has('set_reminder_for_alignment') ? 'Yes' : 'No',
    
    //                 'rotation_interval_km' => $request->rotation_interval_km,
    //                 'set_reminder_for_rotation' => $request->has('set_reminder_for_rotation') ? 'Yes' : 'No',
    
    //                 'last_alignment_km' => $request->last_alignment_km,
    //                 'last_rotation_km' => $request->last_rotation_km,
    
    //                 'created_by' => $userId,
    //             ];
    
    //             $tyre = Tyre::create($data);
    //             if(count($mediaData) > 0){
    //                 $tyre->medias()->createMany($mediaData);
    //             }
    
    //             Tyrelog::create($data + [
    //                 'tyre_id' => $tyre->id
    //             ]);
    
    //             $this->storeUseractivity(66, 3, $userId, $tyre->id, 'Added tyre details.');
    //         });
    
    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Tyre detail saved successfully.',
    //             'redirect_url' => route('tyre.dashboard')
    //         ]);
    
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => $e->getMessage()
    //         ], 422);
    //     }
    // }
    
    
    
}








