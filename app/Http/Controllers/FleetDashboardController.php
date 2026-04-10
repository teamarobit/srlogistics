<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use App\Models\Vehicleownership;
use App\Models\Vehiclegroup;
use App\Models\Vehicletype;
use App\Models\Vehicletypesize;
use App\Models\Vehicle;

use App\Models\Vehiclegrouptracking;
use App\Models\Trackingvehicle;

use App\Models\Fleetstatus;
use App\Models\Contact;
use App\Models\Vehicleallocation;

use App\Models\Gpsprovider;
use App\Models\Fasttagprovider;
use App\Models\Digitallockprovider;

use App\Models\Tyreposition;
use App\Models\Vehiclegps;
use App\Models\Vehiclegpslog;
use App\Models\Vehiclefasttags;
use App\Models\Vehiclefasttaglog;
// use App\Models\Vehicletyre;
// use App\Models\Vehicletyrelog;
use App\Models\Vehiclebattery;
use App\Models\Vehiclebatterylog;
use App\Models\Vehicledigitallock;
use App\Models\Vehicledigitallocklog;

use App\Models\Financeprovider;
use App\Models\Loanaccount;
use App\Models\Loanaccountlog;
use App\Models\Loanaccountcrongivenemi;


use App\Models\Attachmenttype;
use App\Models\Media;
use App\Models\Mediadocument;


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

use Carbon\Carbon;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\FleetVehicleExport;

use Barryvdh\DomPDF\Facade\Pdf;


use App\Services\MediaDocumentService;

use App\Traits\Useractivity;


class FleetDashboardController extends Controller
{
    use Useractivity;
    
    const CONTACT_TYPE_DRIVER = 4;
    
    
    public function index(Request $request)
    {   
        
        $query = Vehicle::with([
                            'group',
                            'groupTracking',
                            'driverAllocation.contact',
                            'customerAllocation.contact',
                            'gps'
                        ]);
        
        if($request->v_vehiclegroup_id){
            $query->where('vehiclegroup_id',$request->v_vehiclegroup_id);
        }
        if($request->v_ownership){
            $query->where('ownership_type',$request->v_ownership);
        }
        
        
        if($request->v_driver){
            $query->whereHas('driverAllocation.contact', function($q) use ($request){
                $q->where('contact_name','like','%'.$request->v_driver.'%');
            });
        }
        if($request->v_managed_by){
            $query->whereHas('groupTracking', function($q) use ($request){
                $q->where('managed_by_employee','like','%'.$request->v_managed_by.'%');
            });
        }
        if($request->v_vehicle_no){
            $query->where('vehicle_no','like','%'.$request->v_vehicle_no.'%');
        }
       
        
        $vehicles = $query->paginate(10)->withQueryString();
        
        if($request->ajax()){

            if($request->status == 7){
                return view('fleet.partials.vehicle_table_empty', compact('vehicles'));
            }
        
            if($request->status == 3){
                return view('fleet.partials.vehicle_table_loading', compact('vehicles'));
            }
        
            if($request->status == 5){
                return view('fleet.partials.vehicle_table_unloading', compact('vehicles'));
            }
        
            if($request->status == 1){
                return view('fleet.partials.vehicle_table_trip', compact('vehicles'));
            }
        
            if($request->status == 6){
                return view('fleet.partials.vehicle_table_maintenance', compact('vehicles'));
            }
        
            return view('fleet.partials.vehicle_table_all', compact('vehicles'));
        }
        
        // ---------------------------------------------------------------------
        if($request->export == 'excel'){

            $filename = 'FleetVehicles-'.date('Y-m-d').'-'.time().'.xlsx';
        
            return Excel::download(
                new FleetVehicleExport(
                    $request->v_driver,
                    $request->v_managed_by,
                    $request->v_vehicle_no,
                    $request->status,
                    $request->v_vehiclegroup_id,
                    $request->v_ownership
                ),
                $filename
            );
        }
        
        if($request->export == 'pdf'){

            $vehicles = $query->get();
        
            $pdf = Pdf::loadView('fleet.exports.vehicle_pdf', compact('vehicles'))->setPaper('A4','landscape');
        
            return $pdf->download('fleet-vehicles.pdf');
        }
        
        // ---------------------------------------------------------------------
        
        $vehicleCount = Vehicle::count();
        

        $fleetstatuses = Fleetstatus::all();
        $vehiclegroup = Vehiclegroup::orderBy('name')->get();
        
        //dd($vehicles->toArray());
        
        //dd($vehicles);
        
        return view('fleet.index', compact('vehicles','vehicleCount','fleetstatuses','vehiclegroup'));
        
    }
    
    
    
    
    public function getVehicleDetails($id)
    {
        $vehicle = Vehicle::with([
            'basicinfo',
            'group',
            'groupTracking',
            'driverAllocation.contact',
            'customerAllocation.contact',
            'gps',
            'fasttag',
            'batteries',
            'digitalLocks',
            'loanaccounts',
            'chassisEmis.loanaccount',
            'bodyEmis.loanaccount',
            'cronGivenEMIs',
            'comments',
            //'cronGivenEMIs.financeNotes'
        ])->find($id);
    
        if (!$vehicle) {
            abort(404);
        }
        
        //dd($vehicle);
        //dd($id);
        //dd($vehicle->basicinfo);
        //dd($vehicle->loanaccounts);
        //dd($vehicle->cronGivenEMIs);
        //dd($vehicle->cronGivenEMIs->financeNotes);
        //dd($vehicle->comments);
        
        
        $gpsproviders = Gpsprovider::where('status', 'Active')->orderBy('name')->get();
        $fasttagproviders = Fasttagprovider::where('status', 'Active')->orderBy('name')->get();
        $digitallockproviders = Digitallockprovider::where('status', 'Active')->orderBy('name')->get();
        
        $financeproviders = Financeprovider::where('status', 'Active')->orderBy('name')->get();
        
        $hasChassisLoan = $vehicle->loanaccounts->where('type', 'Chassis')->isNotEmpty();
        $chassisLoan = [];
        if($hasChassisLoan){
            $chassisLoan = $vehicle->loanaccounts->firstWhere('type', 'Chassis');
        }
        
        $hasBodyLoan = $vehicle->loanaccounts->where('type', 'Body')->isNotEmpty();
        $bodyLoan = [];
        if($hasBodyLoan){
            $bodyLoan = $vehicle->loanaccounts->firstWhere('type', 'Body');
        }
        
        $totalEmi = 0;
        if ($vehicle->loanaccounts->isNotEmpty()) {
            $totalEmi = $vehicle->loanaccounts->sum('emi_amount');
        } 
        
        
        $chassisEmis = $vehicle->cronGivenEMIs->where('loanaccount.type', 'Chassis');
        $bodyEmis    = $vehicle->cronGivenEMIs->where('loanaccount.type', 'Body');
        
        $attachmenttypes = Attachmenttype::get(); //dd($attachmenttypes);
        
        $today = Carbon::today();
        $tenDaysLater = Carbon::today()->addDays(10);
        
        $mediaDocumentIds = $vehicle->documents()->pluck('mediadocument_id')->toArray(); //dd($mediaDocumentIds);
        $mediadocuments = Mediadocument::whereIn('id', $mediaDocumentIds)->get();
        $total_doc_count = $mediadocuments->count();
        $expired_doc_count = $mediadocuments->where('expiry_date', '<', $today)->count();
        $expiring_doc_count = $mediadocuments->where('expiry_date', '>=', $today)->where('expiry_date', '<=', $tenDaysLater)->count();

    
        return view('fleet.vehicle-details', compact('vehicle','gpsproviders','fasttagproviders','digitallockproviders','financeproviders','chassisLoan','bodyLoan','totalEmi','chassisEmis','bodyEmis','attachmenttypes','mediadocuments', 'total_doc_count', 'expired_doc_count', 'expiring_doc_count'));
    }
    
    public function getDriverData($id)
    {
        $vehicle = Vehicle::with([
            'group',
            'groupTracking',
            'driverAllocation.contact',
            'customerAllocation.contact'
        ])->find($id);
    
        if (!$vehicle) {
            return response()->json([
                'success' => false,
                'message' => 'Vehicle not found'
            ], 404);
        }
        
        // Current driver
        $currentDriverId = optional(optional($vehicle->driverAllocation)->contact)->id;
        
        // Other drivers
        $drivers = Contact::where('cotype_id', self::CONTACT_TYPE_DRIVER)
                            ->when($currentDriverId, function ($q) use ($currentDriverId) {
                                $q->where('id', '!=', $currentDriverId);
                            })
                            ->whereNull('deleted_at')
                            ->get(['id', 'contact_name', 'phone']);
        
    
        return response()->json([
            'success' => true,
            'data' => [
                'vehicle' => $vehicle,
                'current_driver_id' => $currentDriverId,
                'drivers' => $drivers
            ]
        ]);
        
    }
    
    public function updateVehicleDriver(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'modal_vehicle_id'   => 'required|exists:vehicles,id',
            'driver_id'          => 'required|exists:contacts,id',
            
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
            \Log::error('Validation failed', [
                'errors' => $validator->errors()->toArray(),
                //'input' => request()->all(), // optional: log the input data for context
            ]);
            
            return response()->json(['success' => false, 'data' => $errormessages, 'message' => 'Please check validation error.'], 422);
        }
        
        try{
            
            
            DB::transaction(function () use($request, &$vehicleAllocation){
                
                // Remove old vehicle
                Vehicleallocation::where('contact_id', $request->modal_current_driver_id)->where('vehicle_id', $request->modal_vehicle_id)->delete();  
                
                $assignDate = $request->assign_date ? \Carbon\Carbon::parse($request->assign_date)->format('Y-m-d') : null;
                 
                // Add new vehicle
                $vehicleAllocation  = new Vehicleallocation;
                $vehicleAllocation->contact_id  = $request->driver_id;
                $vehicleAllocation->type  = 'Driver';
                $vehicleAllocation->vehicle_id  = $request->modal_vehicle_id;
                $vehicleAllocation->change_vehicle  = null;
                $vehicleAllocation->vehicle_change_reason = null;
                
                $vehicleAllocation->km_allowed  = 0;
                $vehicleAllocation->fixed_amount  = 0;
                $vehicleAllocation->extra_amount_per_km  = 0;
                $vehicleAllocation->start_date  = $assignDate;
                $vehicleAllocation->end_date  = null;
            
                $vehicleAllocation->created_by  = Auth::user()->id;
                $vehicleAllocation->save();
                
            });
            
            $success = true;
            $respmessage = 'Vehicle allocation updated successfully.';
            
        } catch (\Exception $exp){
                                    
            DB::rollBack();
            $success = false;
            $respmessage = $exp->getMessage();
            
        }
        
        
        return response()->json(['success' => $success, 'data' => $vehicleAllocation, 'message' => $respmessage]);
    }
    
    
    // GPS ---------------------------------------------------------------------
    
    public function storeGpsDetails(Request $request,$id)
    {
        // Step 1: Validate main fields and dynamic rows
        $validator = Validator::make($request->all(), [
            'gps_provider_id' => 'required|exists:gpsproviders,id',
            'gps_type' => 'required|in:New,Renewal,Replacement',
            'device_issue_date' => 'required|date|date_format:Y-m-d',
            'device_warranty'   => 'required|integer|min:0|max:99999999999',
            //'device_remaining_warranty' => 'required|integer|min:0|max:99999999999',
            'gps_plan_start_date' => 'required|date|date_format:Y-m-d',
            'gps_plan_renew_date' => 'required|date|date_format:Y-m-d',
            'gps_device_cost' => 'required|numeric|between:0,9999999999999999.9999',
            'gps_plan_cost' => 'required|numeric|between:0,9999999999999999.9999',
            'gps_plan_validity' => 'required|integer|min:0|max:99999999999',
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
                //'input' => request()->all(), // optional: log the input data for context
            ]);
    
            return response()->json([
                'success' => false,
                'data' => $validator->errors(),
                'message' => 'Please check validation errors.'
            ], 422);
        }
        
    
        try {
            
            $gpsData = null;
            
            DB::transaction(function () use ($request, &$gpsData, $id) {
                
                // Calculate remaining warranty
                $issueDate = Carbon::parse($request->device_issue_date);
                $today = Carbon::today();
                
                $warrantyMonths = (int) $request->device_warranty;
                
                // Warranty end date
                $warrantyEndDate = $issueDate->copy()->addMonths($warrantyMonths);
                
                // Remaining months
                if ($today->greaterThan($warrantyEndDate)) {
                    $remainingWarranty = 0;
                } else {
                    $remainingWarranty = $today->diffInMonths($warrantyEndDate);
                }

                
                $gpsData = new Vehiclegps(); 
                $gpsData->vehicle_id = $id;
                $gpsData->parent_id = null;
                $gpsData->gpsprovider_id = $request->gps_provider_id;
                $gpsData->gps_type = $request->gps_type;
                $gpsData->device_issue_date = $request->device_issue_date;
                $gpsData->device_warranty = $request->device_warranty;
                $gpsData->device_remaining_warranty = $remainingWarranty;
                $gpsData->gps_plan_validity = $request->gps_plan_validity;
                $gpsData->gps_plan_start_date = $request->gps_plan_start_date;
                $gpsData->gps_plan_renew_date = $request->gps_plan_renew_date;
                $gpsData->gps_device_cost = $request->gps_device_cost;
                $gpsData->gps_plan_cost = $request->gps_plan_cost;
                //$gpsData->purchase_date = date('Y-m-d');
                $gpsData->created_by = Auth::user()->id;
                $gpsData->save();
                
                // Log
                $gpsLog = new Vehiclegpslog(); 
                $gpsLog->vehiclegps_id = $gpsData->id;
                $gpsLog->vehicle_id = $id;
                $gpsLog->parent_id = null;
                $gpsLog->gpsprovider_id = $request->gps_provider_id;
                $gpsLog->gps_type = $request->gps_type;
                $gpsLog->device_issue_date = $request->device_issue_date;
                $gpsLog->device_warranty = $request->device_warranty;
                $gpsLog->device_remaining_warranty = $remainingWarranty;
                $gpsLog->gps_plan_validity = $request->gps_plan_validity;
                $gpsLog->gps_plan_start_date = $request->gps_plan_start_date;
                $gpsLog->gps_plan_renew_date = $request->gps_plan_renew_date;
                $gpsLog->gps_device_cost = $request->gps_device_cost;
                $gpsLog->gps_plan_cost = $request->gps_plan_cost;
                $gpsLog->created_by = Auth::user()->id;
                $gpsLog->save();
                
                
                // Log user activity
                $this->storeUseractivity(54, 3, Auth::user()->id, $gpsData->id, 'Added new vehicle GPS details.');
            
            }); 
            
            $success = true;
            $respmessage = 'Gps detail saved successfully.';
    
        } catch (\Exception $exp) {
            
            \Log::error('Gps detail save error', [
                'message' => $exp->getMessage(),
                'trace' => $exp->getTraceAsString()
            ]);
    
            DB::rollBack();
            $success = false;
            $respmessage = $exp->getMessage();
        }
        
        return response()->json(['success' => $success, 'data' => $gpsData, 'message' => $respmessage]);
    }
    
    public function editGpsDetail($id)
    {
        if($id == ''){
            return response()->json(['success' => false, 'data' => [], 'message' => 'Woops! id not found.']);
        }
        
        $record = Vehiclegps::find($id);
    
        if($record == NULL){
            return response()->json(['success' => false, 'data' => [], 'message' => 'Woops! Data not found.']);
        }
        
        return response()->json(['success' => true, 'data' => $record, 'message' => 'Show the edit form.']);

    }
    
    public function updateGpsDetail(Request $request)
    {   
        $record = Vehiclegps::find($request->get('id'));
        
        if($record == NULL){
            return response()->json(['success' => false, 'data' => [], 'message' => 'Woops ! Vehicle GPS data not found!'], 422);
        }
        
        $validator = Validator::make($request->all(), [
                        'gps_provider_id' => 'required|exists:gpsproviders,id',
                        'gps_type' => 'required|in:New,Renewal,Replacement',
                        'device_issue_date' => 'required|date|date_format:Y-m-d',
                        'device_warranty'   => 'required|integer|min:0|max:99999999999',
                        //'device_remaining_warranty' => 'required|integer|min:0|max:99999999999',
                        'gps_plan_start_date' => 'required|date|date_format:Y-m-d',
                        'gps_plan_renew_date' => 'required|date|date_format:Y-m-d',
                        'gps_device_cost' => 'required|numeric|between:0,9999999999999999.9999',
                        'gps_plan_cost' => 'required|numeric|between:0,9999999999999999.9999',
                        'gps_plan_validity' => 'required|integer|min:0|max:99999999999',
                        
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
                
                // Calculate remaining warranty
                $issueDate = Carbon::parse($request->device_issue_date);
                $today = Carbon::today();
                
                $warrantyMonths = (int) $request->device_warranty;
                
                // Warranty end date
                $warrantyEndDate = $issueDate->copy()->addMonths($warrantyMonths);
                
                // Remaining months
                if ($today->greaterThan($warrantyEndDate)) {
                    $remainingWarranty = 0;
                } else {
                    $remainingWarranty = $today->diffInMonths($warrantyEndDate);
                }
                
                
                $record->gpsprovider_id = $request->gps_provider_id;
                $record->gps_type = $request->gps_type;
                $record->device_issue_date = $request->device_issue_date;
                $record->device_warranty = $request->device_warranty;
                $record->device_remaining_warranty = $remainingWarranty;
                $record->gps_plan_validity = $request->gps_plan_validity;
                $record->gps_plan_start_date = $request->gps_plan_start_date;
                $record->gps_plan_renew_date = $request->gps_plan_renew_date;
                $record->gps_device_cost = $request->gps_device_cost;
                $record->gps_plan_cost = $request->gps_plan_cost;
                $record->save();
                
                // Log
                $gpsLog = new Vehiclegpslog(); 
                $gpsLog->vehiclegps_id = $record->id;
                $gpsLog->vehicle_id = $record->vehicle_id;
                $gpsLog->parent_id = null;
                $gpsLog->gpsprovider_id = $request->gps_provider_id;
                $gpsLog->gps_type = $request->gps_type;
                $gpsLog->device_issue_date = $request->device_issue_date;
                $gpsLog->device_warranty = $request->device_warranty;
                $gpsLog->device_remaining_warranty = $remainingWarranty;
                $gpsLog->gps_plan_validity = $request->gps_plan_validity;
                $gpsLog->gps_plan_start_date = $request->gps_plan_start_date;
                $gpsLog->gps_plan_renew_date = $request->gps_plan_renew_date;
                $gpsLog->gps_device_cost = $request->gps_device_cost;
                $gpsLog->gps_plan_cost = $request->gps_plan_cost;
                $gpsLog->created_by = Auth::user()->id;
                $gpsLog->updated_by = Auth::user()->id;
                $gpsLog->save();
                
    
                $description = 'Updated a vehicle GPS.';
                $useractivity = $this->storeUseractivity(54, 4, Auth::user()->id, $record->id, $description);
                
            });
            
            $success = true;
            $respmessage = 'Vehicle GPS updated successfully.';
            
        } catch (\Exception $exp){
            \Log::error('Vehicle GPS update error', [
                'message' => $exp->getMessage(),
                'trace' => $exp->getTraceAsString()
            ]);
            
            
            DB::rollBack();
            $success = false;
            $respmessage = $exp->getMessage();
            
        }
        
        return response()->json(['success' => $success, 'data' => $record, 'message' => $respmessage]);
    }
    
    
    
    // Fasttag -----------------------------------------------------------------
    
    public function storeFasttagDetails(Request $request,$id)
    {
        // Step 1: Validate main fields and dynamic rows
        $validator = Validator::make($request->all(), [
            'fasttag_provider_id'  => 'required|exists:fasttagproviders,id',
            'fasttag_bank_name' => 'required',
            'fasttag_id'        => 'required',
            'fasttag_issue_date'=> 'required|date',
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
                //'input' => request()->all(), // optional: log the input data for context
            ]);
    
            return response()->json([
                'success' => false,
                'data' => $validator->errors(),
                'message' => 'Please check validation errors.'
            ], 422);
        }
        
    
        try {
            
            $fasttagData = null;
            
            DB::transaction(function () use ($request, &$fasttagData, $id) {
                
                $fasttagData = new Vehiclefasttags(); 
                $fasttagData->vehicle_id = $id;
                $fasttagData->fasttagprovider_id = $request->fasttag_provider_id;
                $fasttagData->fasttag_bank_name = $request->fasttag_bank_name;
                $fasttagData->fasttagId = $request->fasttag_id;
                $fasttagData->fasttag_issue_date = $request->fasttag_issue_date;
                $fasttagData->created_by = Auth::user()->id;
                $fasttagData->save();
                
                // Log
                $fasttagLog = new Vehiclefasttaglog(); 
                $fasttagLog->vehiclefasttag_id = $fasttagData->id;
                $fasttagLog->vehicle_id = $id;
                $fasttagLog->fasttagprovider_id = $request->fasttag_provider_id;
                $fasttagLog->fasttag_bank_name = $request->fasttag_bank_name;
                $fasttagLog->fasttagId = $request->fasttag_id;
                $fasttagLog->fasttag_issue_date = $request->fasttag_issue_date;
                $fasttagLog->created_by = Auth::user()->id;
                $fasttagLog->save();
                
                
                // Log user activity
                $this->storeUseractivity(54, 3, Auth::user()->id, $fasttagData->id, 'Added vehicle Fasttag details.');
            
            }); 
            
            $success = true;
            $respmessage = 'Fasttag detail saved successfully.';
    
        } catch (\Exception $exp) {
            
            \Log::error('Fasttag detail save error', [
                'message' => $exp->getMessage(),
                'trace' => $exp->getTraceAsString()
            ]);
    
            DB::rollBack();
            $success = false;
            $respmessage = $exp->getMessage();
        }
        
        return response()->json(['success' => $success, 'data' => $fasttagData, 'message' => $respmessage]);
    }
    
    
    public function editFasttagDetail($id)
    {
        if($id == ''){
            return response()->json(['success' => false, 'data' => [], 'message' => 'Woops! id not found.']);
        }
        
        $record = Vehiclefasttags::find($id);
    
        if($record == NULL){
            return response()->json(['success' => false, 'data' => [], 'message' => 'Woops! Data not found.']);
        }
        
        return response()->json(['success' => true, 'data' => $record, 'message' => 'Show the edit form.']);

    }
    
    
    public function updateFasttagDetail(Request $request)
    {   
        $record = Vehiclefasttags::find($request->get('id'));
        
        if($record == NULL){
            return response()->json(['success' => false, 'data' => [], 'message' => 'Woops ! Vehicle fasttag data not found!'], 422);
        }
        
        $validator = Validator::make($request->all(), [
                        'fasttag_provider_id'  => 'required|exists:fasttagproviders,id',
                        'fasttag_bank_name' => 'required',
                        'fasttag_id'        => 'required',
                        'fasttag_issue_date'=> 'required|date',
                        
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
                
                $record->fasttagprovider_id = $request->fasttag_provider_id;
                $record->fasttag_bank_name = $request->fasttag_bank_name;
                $record->fasttagId = $request->fasttag_id;
                $record->fasttag_issue_date = $request->fasttag_issue_date;
                $record->updated_by = Auth::user()->id;
                $record->save();
                
                // Log
                $fasttagLog = new Vehiclefasttaglog(); 
                $fasttagLog->vehiclefasttag_id = $record->id;
                $fasttagLog->vehicle_id = $record->vehicle_id;
                $fasttagLog->fasttagprovider_id = $request->fasttag_provider_id;
                $fasttagLog->fasttag_bank_name = $request->fasttag_bank_name;
                $fasttagLog->fasttagId = $request->fasttag_id;
                $fasttagLog->fasttag_issue_date = $request->fasttag_issue_date;
                $fasttagLog->created_by = Auth::user()->id;
                $fasttagLog->updated_by = Auth::user()->id;
                $fasttagLog->save();
                
    
                $description = 'Updated a vehicle fasttag.';
                $useractivity = $this->storeUseractivity(54, 4, Auth::user()->id, $record->id, $description);
                
            });
            
            $success = true;
            $respmessage = 'Vehicle fasttag updated successfully.';
            
        } catch (\Exception $exp){
            \Log::error('Vehicle fasttag update error', [
                'message' => $exp->getMessage(),
                'trace' => $exp->getTraceAsString()
            ]);
            
            
            DB::rollBack();
            $success = false;
            $respmessage = $exp->getMessage();
            
        }
        
        return response()->json(['success' => $success, 'data' => $record, 'message' => $respmessage]);
    }
    
    
    // Tyre --------------------------------------------------------------------
    public function manageTyreDetails(Vehicle $vehicle){
        $tyrepositions = Tyreposition::where('status', 'Active')->get();
        
        // if($vehicle->vehicletyres()->count()){
        //     $vehicletyers = $vehicle->vehicletyres->keyBy('tyreposition_id');
            
        //     return view('fleet.tyre.edit', compact('vehicle', 'tyrepositions', 'vehicletyers'));
        // }else{
        // }
        return view('fleet.tyre.create', compact('vehicle', 'tyrepositions'));
    }
    
    /*public function storeTyreDetails(Request $request, Vehicle $vehicle)
    {
        if($vehicle->vehicletyres()->count()){
            return response()->json(['message' => 'Tyre has already been setup for this vehicle.'], 422);
        }
        
        $requiredTyres = collect($request->tyre_model_name)->keys()->take($request->wheel_count);
        
        $rules = [
            'wheel_count'  => 'required|in:6,10',
        
            'tyre_model_name'  => 'required|array',
            'tyre_type'        => 'required|array',
            'tyre_brand'       => 'required|array',
            'tyre_price'       => 'required|array',
            'tyre_serial_number' => 'required|array',
            'tyre_purchase_date' => 'required|array',
            'tyre_issue_date'    => 'required|array',
            'tyre_warranty_months' => 'required|array',
            'fixed_run_km' => 'nullable|array',
            'fixed_life_months' => 'nullable|array',
            'actual_run_km' => 'nullable|array',
            'actual_run_month' => 'nullable|array',
            'remaining_run_km' => 'nullable|array',
            'remaining_life_month' => 'nullable|array',
            'last_alignment_km' => 'nullable|array',
            'last_rotation_km' => 'nullable|array',
            'alignment_interval_km' => 'nullable|array',
            'rotation_interval_km' => 'nullable|array',
            
            'stepney_tyre_model_name'  => 'nullable|required_with:stepney_tyre_brand',
            'stepney_tyre_type'        => 'nullable|in:Radial,Nylon',
            'stepney_tyre_brand'       => 'nullable',
            'stepney_tyre_price'       => 'nullable|numeric|min:0',
            'stepney_tyre_serial_number' => 'nullable',
            'stepney_tyre_purchase_date' => 'nullable|date',
            'stepney_tyre_issue_date'    => 'nullable|date',
            'stepney_tyre_warranty_months' => 'nullable',
            'stepney_fixed_run_km' => 'nullable|numeric|min:0',
            'stepney_fixed_life_months' => 'nullable|numeric|min:0',
            'stepney_actual_run_km' => 'nullable|numeric|min:0',
            'stepney_actual_run_month' => 'nullable|numeric|min:0',
            'stepney_remaining_run_km' => 'nullable|numeric|min:0',
            'stepney_remaining_life_month' => 'nullable|numeric|min:0',
            'stepney_last_alignment_km' => 'nullable|numeric|min:0',
            'stepney_last_rotation_km' => 'nullable|numeric|min:0',
            'stepney_alignment_interval_km' => 'nullable|numeric|min:0',
            'stepney_rotation_interval_km' => 'nullable|numeric|min:0',
        ];
        
        foreach ($requiredTyres as $id) {
            $rules["tyre_model_name.$id"] = 'required';
            $rules["tyre_type.$id"] = 'required|in:Radial,Nylon';
            $rules["tyre_brand.$id"] = 'required';
            $rules["tyre_price.$id"] = 'required|numeric|min:0';
            $rules["tyre_serial_number.$id"] = 'required';
            $rules["tyre_purchase_date.$id"] = 'required|date';
            $rules["tyre_issue_date.$id"] = 'required|date';
            $rules["tyre_warranty_months.$id"] = 'required';
            $rules["fixed_run_km.$id"] = 'nullable|numeric|min:0';
            $rules["fixed_life_months.$id"] = 'nullable|numeric|min:0';
            $rules["actual_run_km.$id"] = 'nullable|numeric|min:0';
            $rules["actual_run_month.$id"] = 'nullable|numeric|min:0';
            $rules["remaining_run_km.$id"] = 'nullable|numeric|min:0';
            $rules["remaining_life_month.$id"] = 'nullable|numeric|min:0';
            $rules["last_alignment_km.$id"] = 'nullable|numeric|min:0';
            $rules["last_rotation_km.$id"] = 'nullable|numeric|min:0';
            $rules["alignment_interval_km.$id"] = 'nullable|numeric|min:0';
            $rules["rotation_interval_km.$id"] = 'nullable|numeric|min:0';
        }
        
        // Step 1: Validate main fields and dynamic rows
        $validator = Validator::make($request->all(), $rules, [
            'required' => 'This field is required.',
            // 'max'      => 'Maximum 100 characters allowed.',
            'unique'   => 'This value already exists.',
            'numeric'  => 'Only numeric values are allowed.',
            'min'      => 'Value must be at least :min.',
            'max'      => 'Maximum allowed value is :max.',
            'in'       => 'Invalid selection.',
        ]);
    
    
        if ($validator->fails()) {
            $validator_error_msg = $validator->getMessageBag()->toArray();
            $errors = [];
            foreach ($validator_error_msg as $attribute => $validator_error) {
                $attribute = str_replace('.', '_', $attribute);
                $errors[$attribute] = $validator_error;
            }
            
            return response()->json(['data' => $errors, 'message' => 'Please fill with valid data.'], 422);
        }
        
    
        try {
            
            $tyreData = null;
            
            DB::transaction(function () use ($request, $requiredTyres , $vehicle) {
                $userId = Auth::id();
                
                foreach ($requiredTyres as $tyreId) {
                    $data = [
                        'vehicle_id' => $vehicle->id,
            
                        'tyre_model' => $request->tyre_model_name[$tyreId] ?? null,
                        'tyre_type'  => $request->tyre_type[$tyreId] ?? null,
                        'tyre_brand' => $request->tyre_brand[$tyreId] ?? null,
                        'tyre_price' => $request->tyre_price[$tyreId] ?? 0,
                        'tyre_serial_number' => $request->tyre_serial_number[$tyreId] ?? null,
            
                        'tyreposition_id' => $tyreId,
            
                        'tyre_purchase_date' => $request->tyre_purchase_date[$tyreId] ?? null,
                        'tyre_issue_date'    => $request->tyre_issue_date[$tyreId] ?? null,
                        'tyre_warranty_months' => $request->tyre_warranty_months[$tyreId] ?? null,
            
                        'fixed_run_km' => $request->fixed_run_km[$tyreId] ?? 0,
                        'fixed_life_months' => $request->fixed_life_months[$tyreId] ?? null,
                        'actual_run_km' => $request->actual_run_km[$tyreId] ?? 0,
                        'actual_run_month' => $request->actual_run_month[$tyreId] ?? null,
            
                        'remaining_run_km' => $request->remaining_run_km[$tyreId] ?? 0,
                        'remaining_life_month' => $request->remaining_life_month[$tyreId] ?? null,
            
                        'alignment_interval_km' => $request->alignment_interval_km[$tyreId] ?? 0,
                        'set_reminder_for_alignment' => isset($request->set_reminder_for_alignment[$tyreId]) ? 'Yes' : 'No',
            
                        'rotation_interval_km' => $request->rotation_interval_km[$tyreId] ?? 0,
                        'set_reminder_for_rotation' => isset($request->set_reminder_for_rotation[$tyreId]) ? 'Yes' : 'No',
            
                        'last_alignment_km' => $request->last_alignment_km[$tyreId] ?? 0,
                        'last_rotation_km' => $request->last_rotation_km[$tyreId] ?? 0,
            
                        'created_by' => $userId,
                    ];
                    
                    $tyre = Vehicletyre::create($data);

                    $data = $data + ['vehicletyre_id' => $tyre->id];
                    Vehicletyrelog::create($data);
            
                    $this->storeUseractivity(54, 3, $userId, $tyre->id, 'Added vehicle tyre details.');
                }
                
                if ($request->filled('stepney_tyre_model_name')) {
                    $tyreposition = Tyreposition::where('code', 'S1')->first();
                    $stepneyData = [
                        'vehicle_id' => $vehicle->id,
            
                        'tyre_model' => $request->stepney_tyre_model_name,
                        'tyre_type'  => $request->stepney_tyre_type,
                        'tyre_brand' => $request->stepney_tyre_brand,
                        'tyre_price' => $request->stepney_tyre_price ?? 0,
                        'tyre_serial_number' => $request->stepney_tyre_serial_number,
            
                        'tyreposition_id' => $tyreposition->id,
            
                        'tyre_purchase_date' => $request->stepney_tyre_purchase_date,
                        'tyre_issue_date'    => $request->stepney_tyre_issue_date,
                        'tyre_warranty_months' => $request->stepney_tyre_warranty_months,
            
                        'fixed_run_km' => $request->stepney_fixed_run_km ?? 0,
                        'fixed_life_months' => $request->stepney_fixed_life_months,
                        'actual_run_km' => $request->stepney_actual_run_km ?? 0,
                        'actual_run_month' => $request->stepney_actual_run_month,
            
                        'remaining_run_km' => $request->stepney_remaining_run_km ?? 0,
                        'remaining_life_month' => $request->stepney_remaining_life_month,
            
                        'alignment_interval_km' => $request->stepney_alignment_interval_km ?? 0,
                        'set_reminder_for_alignment' => $request->has('stepney_set_reminder_for_alignment') ? 'Yes' : 'No',
            
                        'rotation_interval_km' => $request->stepney_rotation_interval_km ?? 0,
                        'set_reminder_for_rotation' => $request->has('stepney_set_reminder_for_rotation') ? 'Yes' : 'No',
            
                        'last_alignment_km' => $request->stepney_last_alignment_km ?? 0,
                        'last_rotation_km' => $request->stepney_last_rotation_km ?? 0,
            
                        'created_by' => $userId,
                    ];
            
                    $stepney = Vehicletyre::create($stepneyData);
            
                    Vehicletyrelog::create(array_merge($stepneyData, [
                        'vehicletyre_id' => $stepney->id,
                    ]));
            
                    $this->storeUseractivity(54, 3, $userId, $stepney->id, 'Added stepney tyre.');
                }
            
            }); 
            
            $success = true;
            $respmessage = 'Tyre detail saved successfully.';
    
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
        
        return response()->json(['success' => $success, 'message' => $respmessage, 'redirect_url' => route('fleetdashboard.getVehicleDetails', $vehicle->id)]);
    }*/
    
    /*public function storeTyreDetails(Request $request,$id)
    {
        // Step 1: Validate main fields and dynamic rows
        $validator = Validator::make($request->all(), [
            'tyre_model_name'  => 'required',
            'tyre_type'  => 'required|in:Radial,Nylon',
            'tyre_brand' => 'required',
            'tyre_price' => 'required|numeric|min:0',
            'tyre_serial_number' => 'required',
            'tyre_position' => 'required',
            'tyre_purchase_date' => 'required|date',
            'tyre_issue_date' => 'required|date',
            'tyre_warranty_months' => 'required',
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
                //'input' => request()->all(), // optional: log the input data for context
            ]);
    
            return response()->json([
                'success' => false,
                'data' => $validator->errors(),
                'message' => 'Please check validation errors.'
            ], 422);
        }
        
    
        try {
            
            $tyreData = null;
            
            DB::transaction(function () use ($request, &$tyreData, $id) {
                
                $tyreData = new Vehicletyre(); 
                $tyreData->vehicle_id = $id;
                $tyreData->tyre_model = $request->tyre_model_name;
                $tyreData->tyre_type = $request->tyre_type;
                $tyreData->tyre_brand = $request->tyre_brand;
                $tyreData->tyre_price = $request->tyre_price ?? 0;
                $tyreData->tyre_serial_number = $request->tyre_serial_number;
                $tyreData->tyre_position = $request->tyre_position;
                $tyreData->tyre_purchase_date = $request->tyre_purchase_date;
                $tyreData->tyre_issue_date = $request->tyre_issue_date;
                $tyreData->tyre_warranty_months = $request->tyre_warranty_months ?? null;
                $tyreData->fixed_run_km = $request->fixed_run_km ?? 0;
                $tyreData->fixed_life_months = $request->fixed_life_months ?? null;
                $tyreData->actual_run_km = $request->actual_run_km ?? 0;
                $tyreData->actual_run_month = $request->actual_run_month ?? null;
                $tyreData->remaining_run_km = $request->remaining_run_km ?? 0;
                $tyreData->remaining_life_month = $request->remaining_life_month ?? null;
                $tyreData->alignment_interval_km = $request->alignment_interval_km ?? 0;
                $tyreData->set_reminder_for_alignment = $request->has('set_reminder_for_alignment') ? 1 : 0;
                $tyreData->rotation_interval_km = $request->rotation_interval_km ?? 0;
                $tyreData->set_reminder_for_rotation = $request->has('set_reminder_for_rotation') ? 1 : 0;
                $tyreData->last_alignment_km = $request->last_alignment_km ?? 0;
                $tyreData->last_rotation_km = $request->last_rotation_km ?? 0;
                $tyreData->created_by = Auth::user()->id;
                $tyreData->save();
                
                // Log
                $tyreLog = new Vehicletyrelog(); 
                $tyreLog->vehicletyre_id = $tyreData->id;
                $tyreLog->vehicle_id = $id;
                $tyreLog->tyre_model = $request->tyre_model_name;
                $tyreLog->tyre_type = $request->tyre_type;
                $tyreLog->tyre_brand = $request->tyre_brand;
                $tyreLog->tyre_price = $request->tyre_price ?? 0;
                $tyreLog->tyre_serial_number = $request->tyre_serial_number;
                $tyreLog->tyre_position = $request->tyre_position;
                $tyreLog->tyre_purchase_date = $request->tyre_purchase_date;
                $tyreLog->tyre_issue_date = $request->tyre_issue_date;
                $tyreLog->tyre_warranty_months = $request->tyre_warranty_months ?? null;
                $tyreLog->fixed_run_km = $request->fixed_run_km ?? 0;
                $tyreLog->fixed_life_months = $request->fixed_life_months ?? null;
                $tyreLog->actual_run_km = $request->actual_run_km ?? 0;
                $tyreLog->actual_run_month = $request->actual_run_month ?? null;
                $tyreLog->remaining_run_km = $request->remaining_run_km ?? 0;
                $tyreLog->remaining_life_month = $request->remaining_life_month ?? null;
                $tyreLog->alignment_interval_km = $request->alignment_interval_km ?? 0;
                $tyreLog->set_reminder_for_alignment = $request->has('set_reminder_for_alignment') ? 1 : 0;
                $tyreLog->rotation_interval_km = $request->rotation_interval_km ?? 0;
                $tyreLog->set_reminder_for_rotation = $request->has('set_reminder_for_rotation') ? 1 : 0;
                $tyreLog->last_alignment_km = $request->last_alignment_km ?? 0;
                $tyreLog->last_rotation_km = $request->last_rotation_km ?? 0;
                $tyreLog->created_by = Auth::user()->id;
                $tyreLog->save();
                
                
                
                // Log user activity
                $this->storeUseractivity(54, 3, Auth::user()->id, $tyreData->id, 'Added vehicle tyre details.');
            
            }); 
            
            $success = true;
            $respmessage = 'Tyre detail saved successfully.';
    
        } catch (\Exception $exp) {
            
            \Log::error('Tyre detail save error', [
                'message' => $exp->getMessage(),
                'trace' => $exp->getTraceAsString()
            ]);
    
            DB::rollBack();
            $success = false;
            $respmessage = $exp->getMessage();
        }
        
        return response()->json(['success' => $success, 'data' => $tyreData, 'message' => $respmessage]);
    }*/
    
    
    /*public function editTyreDetail($id)
    {
        if($id == ''){
            return response()->json(['success' => false, 'data' => [], 'message' => 'Woops! id not found.']);
        }
        
        $record = Vehicletyre::find($id);
    
        if($record == NULL){
            return response()->json(['success' => false, 'data' => [], 'message' => 'Woops! Data not found.']);
        }
        
        return response()->json(['success' => true, 'data' => $record, 'message' => 'Show the edit form.']);

    }*/
    
    
    /*public function updateTyreDetail(Request $request)
    {   
        $record = Vehicletyre::find($request->get('id'));
        
        if($record == NULL){
            return response()->json(['success' => false, 'data' => [], 'message' => 'Woops ! Vehicle tyre data not found!'], 422);
        }
        
        $validator = Validator::make($request->all(), [
                        'tyre_model_name'  => 'required',
                        'tyre_type'  => 'required|in:Radial,Nylon',
                        'tyre_brand' => 'required',
                        'tyre_price' => 'required|numeric|min:0',
                        'tyre_serial_number' => 'required',
                        'tyre_position' => 'required',
                        'tyre_purchase_date' => 'required|date',
                        'tyre_issue_date' => 'required|date',
                        'tyre_warranty_months' => 'required',
                        
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
                
                $record->tyre_model = $request->tyre_model_name;
                $record->tyre_type = $request->tyre_type;
                $record->tyre_brand = $request->tyre_brand;
                $record->tyre_price = $request->tyre_price ?? 0;
                $record->tyre_serial_number = $request->tyre_serial_number;
                $record->tyre_position = $request->tyre_position;
                $record->tyre_purchase_date = $request->tyre_purchase_date;
                $record->tyre_issue_date = $request->tyre_issue_date;
                $record->tyre_warranty_months = $request->tyre_warranty_months ?? null;
                $record->fixed_run_km = $request->fixed_run_km ?? 0;
                $record->fixed_life_months = $request->fixed_life_months ?? null;
                $record->actual_run_km = $request->actual_run_km ?? 0;
                $record->actual_run_month = $request->actual_run_month ?? null;
                $record->remaining_run_km = $request->remaining_run_km ?? 0;
                $record->remaining_life_month = $request->remaining_life_month ?? null;
                $record->alignment_interval_km = $request->alignment_interval_km ?? 0;
                $record->set_reminder_for_alignment = $request->has('set_reminder_for_alignment') ? 1 : 0;
                $record->rotation_interval_km = $request->rotation_interval_km ?? 0;
                $record->set_reminder_for_rotation = $request->has('set_reminder_for_rotation') ? 1 : 0;
                $record->last_alignment_km = $request->last_alignment_km ?? 0;
                $record->last_rotation_km = $request->last_rotation_km ?? 0;
                $record->updated_by = Auth::user()->id;
                $record->save();
                
                
                // Log
                $tyreLog = new Vehicletyrelog(); 
                $tyreLog->vehicletyre_id = $record->id;
                $tyreLog->vehicle_id = $record->vehicle_id;
                $tyreLog->tyre_model = $request->tyre_model_name;
                $tyreLog->tyre_type = $request->tyre_type;
                $tyreLog->tyre_brand = $request->tyre_brand;
                $tyreLog->tyre_price = $request->tyre_price ?? 0;
                $tyreLog->tyre_serial_number = $request->tyre_serial_number;
                $tyreLog->tyre_position = $request->tyre_position;
                $tyreLog->tyre_purchase_date = $request->tyre_purchase_date;
                $tyreLog->tyre_issue_date = $request->tyre_issue_date;
                $tyreLog->tyre_warranty_months = $request->tyre_warranty_months ?? null;
                $tyreLog->fixed_run_km = $request->fixed_run_km ?? 0;
                $tyreLog->fixed_life_months = $request->fixed_life_months ?? null;
                $tyreLog->actual_run_km = $request->actual_run_km ?? 0;
                $tyreLog->actual_run_month = $request->actual_run_month ?? null;
                $tyreLog->remaining_run_km = $request->remaining_run_km ?? 0;
                $tyreLog->remaining_life_month = $request->remaining_life_month ?? null;
                $tyreLog->alignment_interval_km = $request->alignment_interval_km ?? 0;
                $tyreLog->set_reminder_for_alignment = $request->has('set_reminder_for_alignment') ? 1 : 0;
                $tyreLog->rotation_interval_km = $request->rotation_interval_km ?? 0;
                $tyreLog->set_reminder_for_rotation = $request->has('set_reminder_for_rotation') ? 1 : 0;
                $tyreLog->last_alignment_km = $request->last_alignment_km ?? 0;
                $tyreLog->last_rotation_km = $request->last_rotation_km ?? 0;
                $tyreLog->created_by = Auth::user()->id;
                $tyreLog->updated_by = Auth::user()->id;
                $tyreLog->save();
                
    
                $description = 'Updated a vehicle tyre.';
                $useractivity = $this->storeUseractivity(54, 4, Auth::user()->id, $record->id, $description);
                
            });
            
            $success = true;
            $respmessage = 'Vehicle tyre updated successfully.';
            
        } catch (\Exception $exp){
            \Log::error('Vehicle tyre update error', [
                'message' => $exp->getMessage(),
                'trace' => $exp->getTraceAsString()
            ]);
            
            
            DB::rollBack();
            $success = false;
            $respmessage = $exp->getMessage();
            
        }
        
        return response()->json(['success' => $success, 'data' => $record, 'message' => $respmessage]);
    }*/
    
    
    /*public function destroyTyre(Request $request)
    {
        $id = $request->get('id'); 
        
        if (empty($id)) {
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => 'Woops! ID not found.'
            ]);
        }
    
        $record = Vehicletyre::find($id);
    
        if (!$record) {
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => 'Woops! Vehicle tyre not found.'
            ]);
        }
        
        try{
            
            DB::transaction(function () use($request, $id, &$record){
                
                // Log
                $tyreLog = new Vehicletyrelog(); 
                $tyreLog->vehicletyre_id = $record->id;
                $tyreLog->vehicle_id = $record->vehicle_id;
                $tyreLog->tyre_model = $record->tyre_model;
                $tyreLog->tyre_type = $record->tyre_type;
                $tyreLog->tyre_brand = $record->tyre_brand;
                $tyreLog->tyre_price = $record->tyre_price ?? 0;
                $tyreLog->tyre_serial_number = $record->tyre_serial_number;
                $tyreLog->tyre_position = $record->tyre_position;
                $tyreLog->tyre_purchase_date = $record->tyre_purchase_date;
                $tyreLog->tyre_issue_date = $record->tyre_issue_date;
                $tyreLog->tyre_warranty_months = $record->tyre_warranty_months ?? null;
                $tyreLog->fixed_run_km = $record->fixed_run_km ?? 0;
                $tyreLog->fixed_life_months = $record->fixed_life_months ?? null;
                $tyreLog->actual_run_km = $record->actual_run_km ?? 0;
                $tyreLog->actual_run_month = $record->actual_run_month ?? null;
                $tyreLog->remaining_run_km = $record->remaining_run_km ?? 0;
                $tyreLog->remaining_life_month = $record->remaining_life_month ?? null;
                $tyreLog->alignment_interval_km = $record->alignment_interval_km ?? 0;
                $tyreLog->set_reminder_for_alignment = $record->set_reminder_for_alignment;
                $tyreLog->rotation_interval_km = $record->rotation_interval_km ?? 0;
                $tyreLog->set_reminder_for_rotation = $record->set_reminder_for_rotation;
                $tyreLog->last_alignment_km = $record->last_alignment_km ?? 0;
                $tyreLog->last_rotation_km = $record->last_rotation_km ?? 0;
                $tyreLog->created_by = Auth::user()->id;
                $tyreLog->deleted_by = Auth::user()->id;
                $tyreLog->save();
                
                

                $record->deleted_by = Auth::user()->id;
                $record->delete(); // Perform delete operation
                
                
                // Log activity
                $description = 'Deleted a vehicle tyre.';
                //$useractivity = $this->storeUseractivity(9, 6, Auth::user()->id, $id, $description);
            
            });
            
            $success = true;
            $respmessage = 'Vehicle tyre deleted successfully.';
            
        } catch (\Exception $exp){
            
            \Log::error('Error in function', [
                'message' => $exp->getMessage(),
                'file' => $exp->getFile(),
                'line' => $exp->getLine(),
            ]);
                                    
            DB::rollBack();
            $success = false;
            $respmessage = $exp->getMessage();
            
        }
        
        return response()->json([
            'success' => $success,
            'data' => [],
            'message' => $respmessage
        ]);
    }*/
    
    
    // Battery -----------------------------------------------------------------
    
    public function storeBatteryDetails(Request $request,$id)
    {
        // Step 1: Validate main fields and dynamic rows
        $validator = Validator::make($request->all(), [
            'battery_model_name'  => 'required',
            'battery_capacity'  => 'required',
            'battery_brand' => 'required',
            'battery_price' => 'required|numeric|min:0',
            'battery_serial_number' => 'required',
            'battery_purchase_date' => 'required|date',
            'battery_issue_date' => 'required|date',
            'battery_warranty_months' => 'required|numeric|min:0',
            'battery_fixed_life_months' => 'required|numeric|min:0',
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
                //'input' => request()->all(), // optional: log the input data for context
            ]);
    
            return response()->json([
                'success' => false,
                'data' => $validator->errors(),
                'message' => 'Please check validation errors.'
            ], 422);
        }
        
    
        try {
            
            $batteryData = null;
            
            DB::transaction(function () use ($request, &$batteryData, $id) {
                
                $batteryData = new Vehiclebattery(); 
                $batteryData->vehicle_id = $id;
                $batteryData->battery_model_name = $request->battery_model_name;
                $batteryData->battery_capacity = $request->battery_capacity;
                $batteryData->battery_brand = $request->battery_brand;
                $batteryData->battery_price = $request->battery_price ?? 0;
                $batteryData->battery_serial_number = $request->battery_serial_number;
                $batteryData->purchase_date = $request->battery_purchase_date;
                $batteryData->issue_date = $request->battery_issue_date;
                $batteryData->warranty_months = $request->battery_warranty_months ?? null;
                $batteryData->fixed_life_months = $request->battery_fixed_life_months ?? null;
                $batteryData->created_by = Auth::user()->id;
                $batteryData->save();
                
                // Log
                $batteryLog = new Vehiclebatterylog(); 
                $batteryLog->vehiclebattery_id = $batteryData->id;
                $batteryLog->vehicle_id = $id;
                $batteryLog->battery_model_name = $request->battery_model_name;
                $batteryLog->battery_capacity = $request->battery_capacity;
                $batteryLog->battery_brand = $request->battery_brand;
                $batteryLog->battery_price = $request->battery_price ?? 0;
                $batteryLog->battery_serial_number = $request->battery_serial_number;
                $batteryLog->purchase_date = $request->battery_purchase_date;
                $batteryLog->issue_date = $request->battery_issue_date;
                $batteryLog->warranty_months = $request->battery_warranty_months ?? null;
                $batteryLog->fixed_life_months = $request->battery_fixed_life_months ?? null;
                $batteryLog->created_by = Auth::user()->id;
                //$batteryLog->updated_by = Auth::user()->id;
                $batteryLog->save();
                
                
                // Log user activity
                $this->storeUseractivity(64, 3, Auth::user()->id, $batteryData->id, 'Added vehicle battery details.');
            
            }); 
            
            $success = true;
            $respmessage = 'Battery detail saved successfully.';
    
        } catch (\Exception $exp) {
            
            \Log::error('Battery detail save error', [
                'message' => $exp->getMessage(),
                'trace' => $exp->getTraceAsString()
            ]);
    
            DB::rollBack();
            $success = false;
            $respmessage = $exp->getMessage();
        }
        
        return response()->json(['success' => $success, 'data' => $batteryData, 'message' => $respmessage]);
    }
    
    public function editBatteryDetail($id)
    {
        if($id == ''){
            return response()->json(['success' => false, 'data' => [], 'message' => 'Woops! id not found.']);
        }
        
        $record = Vehiclebattery::find($id);
    
        if($record == NULL){
            return response()->json(['success' => false, 'data' => [], 'message' => 'Woops! Data not found.']);
        }
        
        return response()->json(['success' => true, 'data' => $record, 'message' => 'Show the edit form.']);

    }
    
    
    public function updateBatteryDetail(Request $request)
    {   
        $record = Vehiclebattery::find($request->get('id'));
        
        if($record == NULL){
            return response()->json(['success' => false, 'data' => [], 'message' => 'Woops ! Vehicle battery data not found!'], 422);
        }
        
        $validator = Validator::make($request->all(), [
                        'battery_model_name'  => 'required',
                        'battery_capacity'  => 'required',
                        'battery_brand' => 'required',
                        'battery_price' => 'required|numeric|min:0',
                        'battery_serial_number' => 'required',
                        'battery_purchase_date' => 'required|date',
                        'battery_issue_date' => 'required|date',
                        'battery_warranty_months' => 'required|numeric|min:0',
                        'battery_remaining_warranty_months' => 'required|numeric|min:0',
                        'battery_fixed_life_months' => 'required|numeric|min:0',
                        'battery_remaining_life_months' => 'required|numeric|min:0',
                        
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
                
                $record->battery_model_name = $request->battery_model_name;
                $record->battery_capacity = $request->battery_capacity;
                $record->battery_brand = $request->battery_brand;
                $record->battery_price = $request->battery_price ?? 0;
                $record->battery_serial_number = $request->battery_serial_number;
                $record->purchase_date = $request->battery_purchase_date;
                $record->issue_date = $request->battery_issue_date;
                $record->warranty_months = $request->battery_warranty_months ?? null;
                $record->remaining_warranty_months = $request->battery_remaining_warranty_months ?? null;
                $record->fixed_life_months = $request->battery_fixed_life_months ?? null;
                $record->remaining_life_months = $request->battery_remaining_life_months ?? null;
                $record->updated_by = Auth::user()->id;
                $record->save();
                
                // Log
                $batteryLog = new Vehiclebatterylog(); 
                $batteryLog->vehiclebattery_id = $record->id;
                $batteryLog->vehicle_id = $record->vehicle_id;
                $batteryLog->battery_model_name = $request->battery_model_name;
                $batteryLog->battery_capacity = $request->battery_capacity;
                $batteryLog->battery_brand = $request->battery_brand;
                $batteryLog->battery_price = $request->battery_price ?? 0;
                $batteryLog->battery_serial_number = $request->battery_serial_number;
                $batteryLog->purchase_date = $request->battery_purchase_date;
                $batteryLog->issue_date = $request->battery_issue_date;
                $batteryLog->warranty_months = $request->battery_warranty_months ?? null;
                $batteryLog->remaining_warranty_months = $request->battery_remaining_warranty_months ?? null;
                $batteryLog->fixed_life_months = $request->battery_fixed_life_months ?? null;
                $batteryLog->remaining_life_months = $request->battery_remaining_life_months ?? null;
                $batteryLog->created_by = Auth::user()->id;
                $batteryLog->updated_by = Auth::user()->id;
                $batteryLog->save();
                
    
                $description = 'Updated a vehicle battery.';
                $useractivity = $this->storeUseractivity(64, 4, Auth::user()->id, $record->id, $description);
                
            });
            
            $success = true;
            $respmessage = 'Vehicle battery updated successfully.';
            
        } catch (\Exception $exp){
            \Log::error('Vehicle battery update error', [
                'message' => $exp->getMessage(),
                'trace' => $exp->getTraceAsString()
            ]);
            
            
            DB::rollBack();
            $success = false;
            $respmessage = $exp->getMessage();
            
        }
        
        return response()->json(['success' => $success, 'data' => $record, 'message' => $respmessage]);
    }
    
    
    public function destroyBattery(Request $request)
    {
        $id = $request->get('id'); 
        
        if (empty($id)) {
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => 'Woops! ID not found.'
            ]);
        }
    
        $record = Vehiclebattery::find($id);
    
        if (!$record) {
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => 'Woops! Vehicle battery not found.'
            ]);
        }
        
        try{
            
            
            DB::transaction(function () use($request, $id, &$record){
                
                // Log
                $batteryLog = new Vehiclebatterylog(); 
                $batteryLog->vehiclebattery_id = $record->id;
                $batteryLog->vehicle_id = $record->vehicle_id;
                $batteryLog->battery_model_name = $record->battery_model_name;
                $batteryLog->battery_capacity = $record->battery_capacity;
                $batteryLog->battery_brand = $record->battery_brand;
                $batteryLog->battery_price = $record->battery_price ?? 0;
                $batteryLog->battery_serial_number = $record->battery_serial_number;
                $batteryLog->purchase_date = $record->battery_purchase_date;
                $batteryLog->issue_date = $record->battery_issue_date;
                $batteryLog->warranty_months = $record->battery_warranty_months ?? null;
                $batteryLog->remaining_warranty_months = $record->battery_remaining_warranty_months ?? null;
                $batteryLog->fixed_life_months = $record->battery_fixed_life_months ?? null;
                $batteryLog->remaining_life_months = $record->battery_remaining_life_months ?? null;
                $batteryLog->created_by = Auth::user()->id;
                $batteryLog->deleted_by = Auth::user()->id;
                $batteryLog->save();
                
                
                $record = Vehiclebattery::find($id);
                $record->deleted_by = Auth::user()->id;
                $record->delete(); // Perform delete operation
                
                
                
                // Log activity
                $description = 'Deleted a vehicle battery.';
                $useractivity = $this->storeUseractivity(64, 6, Auth::user()->id, $id, $description);
            
            });
            
            $success = true;
            $respmessage = 'Vehicle battery deleted successfully.';
            
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
    
    
    
    // Digital-Lock ------------------------------------------------------------
    
    
    public function storeDigiLockDetails(Request $request,$id)
    {
        // Step 1: Validate main fields and dynamic rows
        $validator = Validator::make($request->all(), [
            'digitallock_provider_id'  => 'required|exists:digitallockproviders,id',
            'lock_id'                  => 'required',
            'lock_issue_date'          => 'required|date',
            'lock_warranty_months'     => 'required|numeric|min:0',
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
                //'input' => request()->all(), // optional: log the input data for context
            ]);
    
            return response()->json([
                'success' => false,
                'data' => $validator->errors(),
                'message' => 'Please check validation errors.'
            ], 422);
        }
        
    
        try {
            
            $digitallockData = null;
            
            DB::transaction(function () use ($request, &$digitallockData, $id) {
                
                $digitallockData = new Vehicledigitallock(); 
                $digitallockData->vehicle_id = $id;
                $digitallockData->digitallockprovider_id = $request->digitallock_provider_id;
                $digitallockData->lockId = $request->lock_id;
                $digitallockData->lock_issue_date = $request->lock_issue_date;
                $digitallockData->lock_warranty_months = $request->lock_warranty_months;
                $digitallockData->created_by = Auth::user()->id;
                $digitallockData->save();
                
                // Log
                $digitallockLog = new Vehicledigitallocklog(); 
                $digitallockLog->vehicledigitallock_id = $digitallockData->id;
                $digitallockLog->vehicle_id = $id;
                $digitallockLog->digitallockprovider_id = $request->digitallock_provider_id;
                $digitallockLog->lockId = $request->lock_id;
                $digitallockLog->lock_issue_date = $request->lock_issue_date;
                $digitallockLog->lock_warranty_months = $request->lock_warranty_months;
                $digitallockLog->created_by = Auth::user()->id;
                $digitallockLog->save();
                
                
                // Log user activity
                $this->storeUseractivity(65, 3, Auth::user()->id, $digitallockData->id, 'Added vehicle Digital Lock details.');
            
            }); 
            
            $success = true;
            $respmessage = 'Digital Lock detail saved successfully.';
    
        } catch (\Exception $exp) {
            
            \Log::error('Digital Lock detail save error', [
                'message' => $exp->getMessage(),
                'trace' => $exp->getTraceAsString()
            ]);
    
            DB::rollBack();
            $success = false;
            $respmessage = $exp->getMessage();
        }
        
        return response()->json(['success' => $success, 'data' => $digitallockData, 'message' => $respmessage]);
    }
    
    
    
    public function editDigiLockDetail($id)
    {
        if($id == ''){
            return response()->json(['success' => false, 'data' => [], 'message' => 'Woops! id not found.']);
        }
        
        $record = Vehicledigitallock::find($id);
    
        if($record == NULL){
            return response()->json(['success' => false, 'data' => [], 'message' => 'Woops! Data not found.']);
        }
        
        return response()->json(['success' => true, 'data' => $record, 'message' => 'Show the edit form.']);

    }
    
    
    public function updateDigiLockDetail(Request $request)
    {   
        $record = Vehicledigitallock::find($request->get('id'));
        
        if($record == NULL){
            return response()->json(['success' => false, 'data' => [], 'message' => 'Woops ! Vehicle digital lock data not found!'], 422);
        }
        
        $validator = Validator::make($request->all(), [
                        'digitallock_provider_id'  => 'required|exists:digitallockproviders,id',
                        'lock_id'                  => 'required',
                        'lock_issue_date'          => 'required|date',
                        'lock_warranty_months'     => 'required|numeric|min:0',
                        
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
                
                $record->digitallockprovider_id = $request->digitallock_provider_id;
                $record->lockId = $request->lock_id;
                $record->lock_issue_date = $request->lock_issue_date;
                $record->lock_warranty_months = $request->lock_warranty_months;
                $record->updated_by = Auth::user()->id;
                $record->save();
                
                // Log
                $digitallockLog = new Vehicledigitallocklog(); 
                $digitallockLog->vehicledigitallock_id = $record->id;
                $digitallockLog->vehicle_id = $record->vehicle_id;
                $digitallockLog->digitallockprovider_id = $request->digitallock_provider_id;
                $digitallockLog->lockId = $request->lock_id;
                $digitallockLog->lock_issue_date = $request->lock_issue_date;
                $digitallockLog->lock_warranty_months = $request->lock_warranty_months;
                $digitallockLog->created_by = Auth::user()->id;
                $digitallockLog->updated_by = Auth::user()->id;
                $digitallockLog->save();
                
    
                $description = 'Updated a vehicle digital lock.';
                $useractivity = $this->storeUseractivity(64, 4, Auth::user()->id, $record->id, $description);
                
            });
            
            $success = true;
            $respmessage = 'Vehicle digital lock updated successfully.';
            
        } catch (\Exception $exp){
            \Log::error('Vehicle digital lock update error', [
                'message' => $exp->getMessage(),
                'trace' => $exp->getTraceAsString()
            ]);
            
            
            DB::rollBack();
            $success = false;
            $respmessage = $exp->getMessage();
            
        }
        
        return response()->json(['success' => $success, 'data' => $record, 'message' => $respmessage]);
    }
    
    
    public function destroyDigiLock(Request $request)
    {
        $id = $request->get('id'); 
        
        if (empty($id)) {
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => 'Woops! ID not found.'
            ]);
        }
    
        $record = Vehicledigitallock::find($id);
    
        if (!$record) {
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => 'Woops! Vehicle digital lock not found.'
            ]);
        }
        
        try{
            
            
            DB::transaction(function () use($request, $id, &$record){
                
                // Log
                $digitallockLog = new Vehicledigitallocklog(); 
                $digitallockLog->vehicledigitallock_id = $record->id;
                $digitallockLog->vehicle_id = $record->vehicle_id;
                $digitallockLog->digitallockprovider_id = $record->digitallockprovider_id;
                $digitallockLog->lockId = $record->lock_id;
                $digitallockLog->lock_issue_date = $record->lock_issue_date;
                $digitallockLog->lock_warranty_months = $record->lock_warranty_months;
                $digitallockLog->created_by = Auth::user()->id;
                $digitallockLog->deleted_by = Auth::user()->id;
                $digitallockLog->save();
                
                $record = Vehicledigitallock::find($id);
                $record->deleted_by = Auth::user()->id;
                $record->delete(); // Perform delete operation
                
                
                
                // Log activity
                $description = 'Deleted a vehicle digital lock.';
                $useractivity = $this->storeUseractivity(64, 6, Auth::user()->id, $id, $description);
            
            });
            
            $success = true;
            $respmessage = 'Vehicle digital lock deleted successfully.';
            
        } catch (\Exception $exp){
            
            \Log::error('Digital Lock detail save error', [
                'message' => $exp->getMessage(),
                'trace' => $exp->getTraceAsString()
            ]);
                                    
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
    
    
    
    
    
    
    
    
    public function storeComment(Request $request, Vehicle $vehicle)
    {
        $request->validate([
            'comment' => 'required|string|max:1000',
        ]);
    
        try {
            DB::transaction(function () use ($request, $vehicle) {
                $userId = Auth::id();
                
                $vehicle->comments()->create([
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
    
    
    
    
    
    
    
    
    // Document
    public function storeDocument(Request $request, Vehicle $vehicle, MediaDocumentService $service){
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
            $document = $service->storeDocument($vehicle, $request->all());
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
            $vehicle = $mediadocument->medias()->first()?->mediable;
            $document = $service->updateDocument($vehicle, $mediadocument, $request->all());
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






