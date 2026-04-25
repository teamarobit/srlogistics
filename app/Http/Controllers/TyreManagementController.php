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

        // Eager-load all tyre relations needed for the enhanced card layout
        $vehicle->load([
            'vehicletyremappings.tyreposition',
            'vehicletyremappings.tyre.medias',
            'vehicletyremappings.tyre.maintenanceSchedules',
        ]);

        // Compute derived metrics per mapping and inject RAG status
        foreach ($vehicle->vehicletyremappings as $mapping) {
            $tyre = $mapping->tyre;
            if (!$tyre) {
                $mapping->rag_status        = 'untagged';
                $mapping->life_remaining_pct = null;
                $mapping->remaining_run_km   = null;
                $mapping->remaining_life_months = null;
                $mapping->warranty_remaining_months = null;
                continue;
            }

            // Life remaining %
            $lifeRemainingPct = null;
            if ($tyre->fixed_run_km > 0) {
                $lifeRemainingPct = max(0, round((($tyre->fixed_run_km - ($tyre->actual_run_km ?? 0)) / $tyre->fixed_run_km) * 100, 1));
            }

            // RAG status
            if ($lifeRemainingPct === null) {
                $ragStatus = 'grey';
            } elseif ($lifeRemainingPct >= 50) {
                $ragStatus = 'green';
            } elseif ($lifeRemainingPct >= 20) {
                $ragStatus = 'amber';
            } else {
                $ragStatus = 'red';
            }

            // Remaining run KM
            $remainingRunKm = null;
            if ($tyre->fixed_run_km !== null && $tyre->actual_run_km !== null) {
                $remainingRunKm = max(0, $tyre->fixed_run_km - $tyre->actual_run_km);
            }

            // Remaining life months
            $remainingLifeMonths = null;
            if ($tyre->fixed_life_months !== null && $tyre->actual_run_month !== null) {
                $remainingLifeMonths = max(0, $tyre->fixed_life_months - $tyre->actual_run_month);
            }

            // Warranty remaining months
            $warrantyRemainingMonths = null;
            if ($tyre->tyre_warrenty_end_date) {
                $warrantyRemainingMonths = max(0, (int) now()->diffInMonths(Carbon::parse($tyre->tyre_warrenty_end_date), false));
            }

            // Inject computed values directly onto the mapping (not persisted)
            $mapping->rag_status                = $ragStatus;
            $mapping->life_remaining_pct        = $lifeRemainingPct;
            $mapping->remaining_run_km          = $remainingRunKm;
            $mapping->remaining_life_months     = $remainingLifeMonths;
            $mapping->warranty_remaining_months = $warrantyRemainingMonths;
        }

        // $this->storeUseractivity(66, 5, Auth::id(), 0, 'Tyre list retrieved.');
        $tyrepositions = Tyreposition::where('status', 'Active')->get();

        return view('tyremanagement.vehicletyretagging', compact('tyrepositions', 'vehicle'));
    }

    public function tyreFitment(Vehicle $vehicle)
    {
        $vehicle->load('vehicletyremappings.tyre', 'vehicletyremappings.tyreposition');
        return view('tyremanagement.tyre-fitment', compact('vehicle'));
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








