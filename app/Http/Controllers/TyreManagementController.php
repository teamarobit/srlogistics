<?php
  
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Support\Str;

use App\Models\Media;
use App\Models\Tyre;
use App\Models\Tyreposition;
use App\Models\Tyrelog;
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

        // Fetch last recorded odometer reading for this vehicle (used by JS KM validation)
        $lastMappingWithKm = Vehicletyremapping::where('vehicle_id', $vehicle->id)
            ->whereNotNull('km_at_fitment')
            ->whereNotNull('fitment_date')
            ->orderBy('km_at_fitment', 'desc')
            ->first(['km_at_fitment', 'fitment_date']);

        $lastKnownKm   = $lastMappingWithKm ? (int) $lastMappingWithKm->km_at_fitment : null;
        $lastKnownDate = $lastMappingWithKm ? $lastMappingWithKm->fitment_date          : null;

        return view('tyremanagement.vehicletyretagging', compact('tyrepositions', 'vehicle', 'lastKnownKm', 'lastKnownDate'));
    }

    public function tyreFitment(Vehicle $vehicle)
    {
        $vehicle->load('vehicletyremappings.tyre', 'vehicletyremappings.tyreposition');
        return view('tyremanagement.tyre-fitment', compact('vehicle'));
    }

    public function vehicleTyreTaggingV2(Vehicle $vehicle)
    {
        // Same initialisation logic as vehicleTyreTagging — creates mappings if none exist
        $mounted_tyrepositions = Tyreposition::where('status', 'Active')->take($vehicle->mounted_tyre_count)->get();
        if (!$vehicle->vehicletyremappings()->count()) {
            if ($mounted_tyrepositions->count()) {
                foreach ($mounted_tyrepositions as $mounted_tyreposition) {
                    $data = [
                        'vehicle_id'        => $vehicle->id,
                        'tyre_id'           => null,
                        'tyreposition_id'   => $mounted_tyreposition->id,
                        'status'            => 'Inactive',
                        'created_by'        => Auth::id(),
                        'created_at'        => now(),
                    ];
                    $vehicletyremapping = Vehicletyremapping::create($data);
                    $data['vehicletyremapping_id'] = $vehicletyremapping->id;
                    Vehicletyremappinglog::create($data);
                }
            } else {
                return redirect()->back();
            }
        }

        // Eager-load relations
        $vehicle->load([
            'vehicletyremappings.tyreposition',
            'vehicletyremappings.tyre.medias',
            'vehicletyremappings.tyre.maintenanceSchedules',
        ]);

        // Compute derived metrics (identical to v1)
        foreach ($vehicle->vehicletyremappings as $mapping) {
            $tyre = $mapping->tyre;
            if (!$tyre) {
                $mapping->rag_status                = 'untagged';
                $mapping->life_remaining_pct        = null;
                $mapping->remaining_run_km          = null;
                $mapping->remaining_life_months     = null;
                $mapping->warranty_remaining_months = null;
                continue;
            }

            $lifeRemainingPct = null;
            if ($tyre->fixed_run_km > 0) {
                $lifeRemainingPct = max(0, round((($tyre->fixed_run_km - ($tyre->actual_run_km ?? 0)) / $tyre->fixed_run_km) * 100, 1));
            }

            if ($lifeRemainingPct === null) {
                $ragStatus = 'grey';
            } elseif ($lifeRemainingPct >= 50) {
                $ragStatus = 'green';
            } elseif ($lifeRemainingPct >= 20) {
                $ragStatus = 'amber';
            } else {
                $ragStatus = 'red';
            }

            $remainingRunKm      = $tyre->fixed_run_km > 0 ? max(0, $tyre->fixed_run_km - ($tyre->actual_run_km ?? 0)) : null;
            $remainingLifeMonths = null;
            if ($tyre->fixed_life_months > 0 && $mapping->fitment_date) {
                $monthsRun = (int) Carbon::parse($mapping->fitment_date)->diffInMonths(now());
                $remainingLifeMonths = max(0, $tyre->fixed_life_months - $monthsRun);
            }
            $warrantyRemainingMonths = null;
            if ($tyre->tyre_warrenty_end_date) {
                $warrantyRemainingMonths = max(0, (int) now()->diffInMonths(Carbon::parse($tyre->tyre_warrenty_end_date), false));
            }

            $mapping->rag_status                = $ragStatus;
            $mapping->life_remaining_pct        = $lifeRemainingPct;
            $mapping->remaining_run_km          = $remainingRunKm;
            $mapping->remaining_life_months     = $remainingLifeMonths;
            $mapping->warranty_remaining_months = $warrantyRemainingMonths;
        }

        $tyrepositions = Tyreposition::where('status', 'Active')->get();

        $lastMappingWithKm = Vehicletyremapping::where('vehicle_id', $vehicle->id)
            ->whereNotNull('km_at_fitment')
            ->whereNotNull('fitment_date')
            ->orderBy('km_at_fitment', 'desc')
            ->first(['km_at_fitment', 'fitment_date']);

        $lastKnownKm   = $lastMappingWithKm ? (int) $lastMappingWithKm->km_at_fitment : null;
        $lastKnownDate = $lastMappingWithKm ? $lastMappingWithKm->fitment_date          : null;

        return view('tyremanagement.vehicletyretagging-v2', compact('tyrepositions', 'vehicle', 'lastKnownKm', 'lastKnownDate'));
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
    
    /**
     * AJAX — Return warehouse tyres filtered by condition + type.
     * Each tyre includes serial number + computed health % for display in dropdown.
     */
    public function getTyreList(Request $request)
    {
        $condition = $request->condition;
        $type      = $request->type;
        $tyres     = [];

        if (!empty($condition) && !empty($type)) {
            $rawTyres = Tyre::where('location', 'Warehouse')
                ->where('tyre_type', $type)
                ->where('tyre_condition', $condition)
                ->get(['id', 'tyre_serial_number', 'tyre_brand', 'tyre_model',
                        'fixed_run_km', 'actual_run_km']);

            foreach ($rawTyres as $tyre) {
                // Compute life remaining %
                $healthPct = null;
                $ragStatus = 'grey';
                if ($tyre->fixed_run_km > 0) {
                    $healthPct = max(0, round(
                        (($tyre->fixed_run_km - ($tyre->actual_run_km ?? 0)) / $tyre->fixed_run_km) * 100,
                        1
                    ));
                    if ($healthPct >= 50)      $ragStatus = 'green';
                    elseif ($healthPct >= 20)  $ragStatus = 'amber';
                    else                       $ragStatus = 'red';
                }

                $tyres[] = [
                    'id'                => $tyre->id,
                    'tyre_serial_number'=> $tyre->tyre_serial_number,
                    'tyre_brand'        => $tyre->tyre_brand,
                    'tyre_model'        => $tyre->tyre_model,
                    'health_pct'        => $healthPct,
                    'rag_status'        => $ragStatus,
                    'label'             => ($tyre->tyre_serial_number ?? 'N/A')
                                          . ($tyre->tyre_brand  ? ' — ' . $tyre->tyre_brand  : '')
                                          . ($healthPct !== null ? ' [' . $healthPct . '% health]' : ''),
                ];
            }
        }

        return response()->json(['tyres' => $tyres, 'message' => 'Tyre fetched successfully']);
    }

    /**
     * POST — Allocate a tyre to a vehicle position.
     * Supports two sources:
     *   SR Warehouse  — pick an existing warehouse tyre (tyre_id required)
     *   Direct Fitment — brand + serial entered manually; a new Tyre record is created
     *
     * Updates vehicletyremappings (tyre_id, status, fitment_date, km_at_fitment).
     * Inserts a fresh row into vehicletyremappinglogs.
     * Accepts up to 3 optional photo attachments (photo_serial, photo_fitment, photo_odometer).
     * Validates KM reading against last recorded odometer reading for the vehicle.
     */
    public function addTyreToPosition(Request $request, Vehicle $vehicle, Vehicletyremapping $mapping)
    {
        $source = $request->tyre_source;

        // ── Validation rules ──────────────────────────────────────────────────
        $rules = [
            'tyre_source'    => 'required|in:SR Warehouse,Direct Fitment',
            'tyre_condition' => 'required|in:New,Used,Re-thread',
            'tyre_type'      => 'required|in:Radial,Nylon',
            'fitment_date'   => 'required|date',
            'km_at_fitment'  => 'nullable|numeric|min:0',
            'photo_serial'   => 'nullable|file|mimes:jpg,jpeg,png,webp|max:5120',
            'photo_fitment'  => 'nullable|file|mimes:jpg,jpeg,png,webp|max:5120',
            'photo_odometer' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:5120',
        ];

        if ($source === 'SR Warehouse') {
            $rules['tyre_id'] = [
                'required',
                'integer',
                function ($attr, $value, $fail) {
                    if (!Tyre::where('id', $value)->where('location', 'Warehouse')->exists()) {
                        $fail('Selected tyre is not available in Warehouse.');
                    }
                },
            ];
        } else {
            $rules['tyre_brand']         = 'required|string|max:100';
            $rules['tyre_serial_number'] = 'required|string|max:100';
        }

        $validator = Validator::make($request->all(), $rules, [
            'required' => 'This field is required.',
            'numeric'  => 'Only numeric values are allowed.',
            'min'      => 'Value must be at least :min.',
            'in'       => 'Invalid selection.',
            'mimes'    => 'Only JPG, PNG, or WEBP images are allowed.',
            'max'      => 'File size must not exceed 5 MB.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
                'message' => 'Please fill all required fields.',
            ], 422);
        }

        // ── Verify mapping belongs to this vehicle ────────────────────────────
        if ($mapping->vehicle_id != $vehicle->id) {
            return response()->json([
                'success' => false,
                'message' => 'Mapping does not belong to this vehicle.',
            ], 403);
        }

        // ── KM Odometer validation ────────────────────────────────────────────
        // Rule: if fitment_date >= last recorded odometer date,
        //       the entered KM must be >= the last recorded KM.
        if ($request->km_at_fitment !== null && $request->km_at_fitment !== '') {
            $lastRef = Vehicletyremapping::where('vehicle_id', $vehicle->id)
                ->whereNotNull('km_at_fitment')
                ->whereNotNull('fitment_date')
                ->orderBy('km_at_fitment', 'desc')
                ->first(['km_at_fitment', 'fitment_date']);

            if ($lastRef) {
                $fitmentDate = Carbon::parse($request->fitment_date);
                $lastDate    = Carbon::parse($lastRef->fitment_date);
                $lastKm      = (int) $lastRef->km_at_fitment;
                $enteredKm   = (int) $request->km_at_fitment;

                if ($fitmentDate->gte($lastDate) && $enteredKm < $lastKm) {
                    return response()->json([
                        'success' => false,
                        'errors'  => [
                            'km_at_fitment' => [
                                "KM reading cannot be lower than {$lastKm} KM (last recorded on "
                                . $lastDate->format('d M Y') . ').'
                            ],
                        ],
                        'message' => 'Invalid KM reading.',
                    ], 422);
                }
            }
        }

        // ── Transaction ───────────────────────────────────────────────────────
        try {
            DB::transaction(function () use ($request, $vehicle, $mapping, $source) {
                $userId      = Auth::id();
                $fitmentDate = date('Y-m-d', strtotime($request->fitment_date));
                $kmAtFitment = $request->km_at_fitment ?? null;

                // 1. Resolve / create the Tyre record
                if ($source === 'SR Warehouse') {
                    $tyreId = (int) $request->tyre_id;
                    $tyreForMedia = Tyre::find($tyreId);
                    // Move tyre out of Warehouse
                    Tyre::where('id', $tyreId)->update(['location' => 'Vehicle']);
                } else {
                    // Direct Fitment — create a minimal Tyre record (no vendor/warehouse)
                    $tyreForMedia = Tyre::create([
                        'contact_id'         => null,
                        'location'           => 'Vehicle',
                        'tyre_condition'     => $request->tyre_condition,
                        'tyre_type'          => $request->tyre_type,
                        'tyre_brand'         => $request->tyre_brand,
                        'tyre_model'         => $request->tyre_brand,   // model = brand as placeholder
                        'tyre_serial_number' => $request->tyre_serial_number,
                        'created_by'         => $userId,
                    ]);
                    $tyreId = $tyreForMedia->id;
                }

                // 2. Attach photo files to the tyre record (common for both sources)
                $photoSlots = [
                    'photo_serial'   => 'Serial Number Photo',
                    'photo_fitment'  => 'Fitment Photo',
                    'photo_odometer' => 'Odometer Photo',
                ];
                $mediaData = [];
                foreach ($photoSlots as $inputName => $label) {
                    if ($request->hasFile($inputName)) {
                        $file     = $request->file($inputName);
                        $file_type = $file->getClientMimeType();
                        $file_size = $file->getSize();
                        $fileName = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
                        $file->move(public_path('medias' . DIRECTORY_SEPARATOR . 'tyre' . DIRECTORY_SEPARATOR), $fileName);
                        $mediaData[] = [
                            'type'       => 'Image',
                            'file_name'  => '[' . $label . '] ' . $file->getClientOriginalName(),
                            'file_path'  => 'tyre/' . $fileName,
                            'file_type'  => $file_type,
                            'file_size'  => $file_size,
                            'created_by' => $userId,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }
                }
                if (!empty($mediaData) && $tyreForMedia) {
                    $tyreForMedia->medias()->createMany($mediaData);
                }

                // 3. Update the mapping row
                $notes = $source === 'Direct Fitment'
                    ? 'Direct Fitment | Brand: ' . $request->tyre_brand . ' | Serial: ' . $request->tyre_serial_number
                    : null;

                $mapping->update([
                    'tyre_id'       => $tyreId,
                    'status'        => 'Active',
                    'fitment_date'  => $fitmentDate,
                    'km_at_fitment' => $kmAtFitment,
                    'notes'         => $notes,
                ]);

                // 4. Insert history log row (never update — insert only)
                Vehicletyremappinglog::create([
                    'vehicletyremapping_id' => $mapping->id,
                    'vehicle_id'            => $vehicle->id,
                    'tyre_id'               => $tyreId,
                    'tyreposition_id'       => $mapping->tyreposition_id,
                    'fitment_date'          => $fitmentDate,
                    'km_at_fitment'         => $kmAtFitment,
                    'status'                => 'Active',
                    'notes'                 => $source,
                    'created_by'            => $userId,
                ]);
            });

            return response()->json([
                'success'      => true,
                'message'      => 'Tyre allocated successfully.',
                'redirect_url' => route('tyremanage.vehicle.tyre.tagging', $vehicle->id),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong: ' . $e->getMessage(),
            ], 500);
        }
    }
    
    /**
     * POST — Add a spare tyre to the vehicle.
     * Inserts a NEW row into vehicletyremappings (status = 'Spare').
     * Auto-assigns the next free spare position (S1, S2, …).
     * Never updates an existing mapping row.
     */
    public function addSpareTyre(Request $request, Vehicle $vehicle)
    {
        $rules = [
            'tyre_id'      => [
                'required',
                'integer',
                function ($attr, $value, $fail) {
                    if (!Tyre::where('id', $value)->where('location', 'Warehouse')->exists()) {
                        $fail('Selected tyre is not available in Warehouse.');
                    }
                },
            ],
            'fitment_date' => 'required|date',
            'km_at_fitment'=> 'nullable|numeric|min:0',
        ];

        $validator = Validator::make($request->all(), $rules, [
            'required' => 'This field is required.',
            'numeric'  => 'Only numeric values are allowed.',
            'min'      => 'Value must be at least :min.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
                'message' => 'Please fill all required fields.',
            ], 422);
        }

        // Fetch all spare positions (codes starting with 'S'), ordered alphabetically
        $allSparePositions = Tyreposition::where('code', 'like', 'S%')
            ->where('status', 'Active')
            ->orderBy('code')
            ->get();

        if ($allSparePositions->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No spare tyre positions are configured in the system.',
            ], 422);
        }

        // Find S-positions already occupied by a spare tyre on this vehicle
        $occupiedPositionIds = Vehicletyremapping::where('vehicle_id', $vehicle->id)
            ->whereNotNull('tyre_id')
            ->whereIn('tyreposition_id', $allSparePositions->pluck('id'))
            ->pluck('tyreposition_id')
            ->toArray();

        // Pick the first S-position not yet occupied
        $availablePosition = $allSparePositions->first(
            fn($pos) => !in_array($pos->id, $occupiedPositionIds)
        );

        if (!$availablePosition) {
            return response()->json([
                'success' => false,
                'message' => 'All spare tyre positions are already occupied for this vehicle.',
            ], 422);
        }

        try {
            DB::transaction(function () use ($request, $vehicle, $availablePosition) {
                $userId      = Auth::id();
                $fitmentDate = date('Y-m-d', strtotime($request->fitment_date));
                $kmAtFitment = $request->km_at_fitment ?? null;

                // 1. INSERT new mapping row for the spare
                $mapping = Vehicletyremapping::create([
                    'vehicle_id'      => $vehicle->id,
                    'tyre_id'         => $request->tyre_id,
                    'tyreposition_id' => $availablePosition->id,
                    'status'          => 'Spare',
                    'fitment_date'    => $fitmentDate,
                    'km_at_fitment'   => $kmAtFitment,
                    'created_by'      => $userId,
                ]);

                // 2. INSERT log row (history — never update)
                Vehicletyremappinglog::create([
                    'vehicletyremapping_id' => $mapping->id,
                    'vehicle_id'            => $vehicle->id,
                    'tyre_id'               => $request->tyre_id,
                    'tyreposition_id'       => $availablePosition->id,
                    'fitment_date'          => $fitmentDate,
                    'km_at_fitment'         => $kmAtFitment,
                    'status'                => 'Spare',
                    'created_by'            => $userId,
                ]);

                // 3. Move tyre out of Warehouse → Vehicle
                Tyre::where('id', $request->tyre_id)->update(['location' => 'Vehicle']);
            });

            return response()->json([
                'success'      => true,
                'message'      => 'Spare tyre added successfully.',
                'redirect_url' => route('tyremanage.vehicle.tyre.tagging', $vehicle->id),
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong: ' . $e->getMessage(),
            ], 500);
        }
    }

    /* ══════════════════════════════════════════════════════════════════════
     * POST  tyremanage/vehicle/{vehicle}/log-alignment
     * Take Action Modal — Alignment tab submit
     *
     * Writes a tyrelog row with action_type = 'Alignment', updates
     * tyre.last_alignment_km, and stores the invoice attachment to medias.
     * ══════════════════════════════════════════════════════════════════════ */
    public function logAlignment(Request $request, Vehicle $vehicle)
    {
        // ── 1. Validate ───────────────────────────────────────────────────────
        $validator = Validator::make($request->all(), [
            'mapping_id'      => 'required|integer',
            'alignment_date'  => 'required|date',
            'alignment_km'    => 'required|numeric|min:0',
            'alignment_invoice' => 'nullable|file|mimes:jpg,jpeg,png,webp,pdf|max:5120',
        ], [
            'required'   => 'This field is required.',
            'numeric'    => 'Must be a number.',
            'min'        => 'Must be at least :min.',
            'mimes'      => 'Only JPG, PNG, WEBP, or PDF files are allowed.',
            'max'        => 'File size must not exceed 5 MB.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
                'message' => 'Please fill all required fields.',
            ], 422);
        }

        // ── 2. Resolve mapping (must belong to this vehicle) ─────────────────
        $mapping = Vehicletyremapping::find($request->mapping_id);
        if (!$mapping || $mapping->vehicle_id != $vehicle->id) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid tyre position mapping.',
            ], 422);
        }

        $tyre = Tyre::find($mapping->tyre_id);
        if (!$tyre) {
            return response()->json([
                'success' => false,
                'message' => 'No tyre found at this position.',
            ], 422);
        }

        // ── 3. Transaction ────────────────────────────────────────────────────
        try {
            $result = DB::transaction(function () use ($request, $vehicle, $mapping, $tyre) {
                $userId       = Auth::id();
                $alignDate    = date('Y-m-d', strtotime($request->alignment_date));
                $alignKm      = (float) $request->alignment_km;

                // 3a. Insert tyrelog row
                $log = Tyrelog::create([
                    'action_type'   => 'Alignment',
                    'action_date'   => $alignDate,
                    'action_km'     => $alignKm,
                    'vehicle_id'    => $vehicle->id,
                    'mapping_id'    => $mapping->id,
                    'tyre_id'       => $tyre->id,
                    'contact_id'    => $tyre->contact_id ?? 0,
                    'tyre_condition'=> $tyre->tyre_condition ?? 'Used',
                    'tyre_model'    => $tyre->tyre_model ?? '',
                    'tyre_type'     => $tyre->tyre_type,
                    'tyre_brand'    => $tyre->tyre_brand,
                    'tyre_price'    => $tyre->tyre_price ?? 0,
                    'tyre_serial_number' => $tyre->tyre_serial_number,
                    'action_notes'  => 'Wheel Alignment logged via Take Action modal.',
                    'created_by'    => $userId,
                ]);

                // 3b. Update tyre.last_alignment_km
                $tyre->update(['last_alignment_km' => $alignKm]);

                // 3c. Store invoice attachment to medias (morphable on Tyrelog)
                if ($request->hasFile('alignment_invoice')) {
                    $file     = $request->file('alignment_invoice');
                    $fileType = $file->getClientMimeType();
                    $fileSize = $file->getSize();
                    $fileName = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('medias' . DIRECTORY_SEPARATOR . 'tyre' . DIRECTORY_SEPARATOR), $fileName);

                    Media::create([
                        'type'          => 'Image',
                        'file_name'     => '[Alignment Invoice] ' . $file->getClientOriginalName(),
                        'file_path'     => 'tyre/' . $fileName,
                        'file_type'     => $fileType,
                        'file_size'     => $fileSize,
                        'mediable_id'   => $log->id,
                        'mediable_type' => Tyrelog::class,
                        'created_by'    => $userId,
                    ]);
                }

                return $log;
            });

            return response()->json([
                'success' => true,
                'message' => 'Alignment logged successfully.',
                'log_id'  => $result->id,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong: ' . $e->getMessage(),
            ], 500);
        }
    }

    /* ══════════════════════════════════════════════════════════════════════
     * POST  tyremanage/vehicle/{vehicle}/log-replace
     * Take Action Modal — Replace Tyre tab submit
     *
     * Supports four replacement sources:
     *   SR Garage        — manual brand/serial; new Tyre record created
     *   Direct Fitment   — manual brand/serial; new Tyre record created
     *   Same Vehicle Spare — spare mapping's tyre moved to mounted position
     *   Another Vehicle  — donor vehicle's tyre transferred here
     *
     * Writes:
     *   1. Tyrelog row (action_type = 'Replacement') — audit trail
     *   2. Photo attachments → medias (mediable on Tyrelog, type = 'Image')
     *   3. Vehicletyremapping updated (new tyre_id, fitment_date, km)
     *   4. Vehicletyremappinglog inserted for the position history
     *   5. Old tyre location updated per old_tyre_destination choice
     *
     * Validation enforces donor vehicle ≠ current vehicle when source is
     * "Another Vehicle" (SD-8: find(), not findOrFail(), in JSON method).
     * ══════════════════════════════════════════════════════════════════════ */
    public function logReplace(Request $request, Vehicle $vehicle)
    {
        $source = $request->replacement_source;

        // ── 1. Base validation rules ───────────────────────────────────────
        $rules = [
            'mapping_id'           => 'required|integer',
            'replacement_reason'   => 'required|string',
            'damage_reason'        => 'required|string',
            'driver_fine_amount'   => 'nullable|numeric|min:0',
            'replacement_source'   => 'required|in:SR Garage,Direct Fitment,Same Vehicle Spare,Another Vehicle',
            'old_tyre_destination' => 'required|string',
            'old_tyre_action'      => 'required|string',
            'damage_photo_1'       => 'nullable|file|mimes:jpg,jpeg,png,webp|max:5120',
            'damage_photo_2'       => 'nullable|file|mimes:jpg,jpeg,png,webp|max:5120',
            'damage_photo_3'       => 'nullable|file|mimes:jpg,jpeg,png,webp|max:5120',
        ];

        // Source-specific validation
        if ($source === 'SR Garage') {
            $rules['new_tyre_brand_garage']     = 'required|string|max:100';
            $rules['new_tyre_serial_garage']    = 'required|string|max:100';
            $rules['new_tyre_condition_garage'] = 'required|in:New,Used,Re-thread';
            $rules['new_tyre_type_garage']      = 'required|in:Radial,Nylon';
            $rules['replacement_date_garage']   = 'required|date';
            $rules['replacement_km_garage']     = 'nullable|numeric|min:0';
            $rules['garage_serial_photo']       = 'nullable|file|mimes:jpg,jpeg,png,webp|max:5120';
            $rules['garage_fitment_photo']      = 'nullable|file|mimes:jpg,jpeg,png,webp|max:5120';
            $rules['garage_odometer_photo']     = 'nullable|file|mimes:jpg,jpeg,png,webp|max:5120';
        } elseif ($source === 'Direct Fitment') {
            $rules['new_tyre_brand_direct']     = 'required|string|max:100';
            $rules['new_tyre_serial_direct']    = 'required|string|max:100';
            $rules['new_tyre_condition_direct'] = 'required|in:New,Used,Re-thread';
            $rules['new_tyre_type_direct']      = 'required|in:Radial,Nylon';
            $rules['replacement_date_direct']   = 'required|date';
            $rules['replacement_km_direct']     = 'nullable|numeric|min:0';
            $rules['direct_serial_photo']       = 'nullable|file|mimes:jpg,jpeg,png,webp|max:5120';
            $rules['direct_fitment_photo']      = 'nullable|file|mimes:jpg,jpeg,png,webp|max:5120';
            $rules['direct_odometer_photo']     = 'nullable|file|mimes:jpg,jpeg,png,webp|max:5120';
        } elseif ($source === 'Same Vehicle Spare') {
            $rules['spare_tyre_mapping_id']     = 'required|integer';
            $rules['replacement_date_spare']    = 'required|date';
            $rules['replacement_km_spare']      = 'nullable|numeric|min:0';
            $rules['spare_serial_photo']        = 'nullable|file|mimes:jpg,jpeg,png,webp|max:5120';
            $rules['spare_fitment_photo']       = 'nullable|file|mimes:jpg,jpeg,png,webp|max:5120';
            $rules['spare_odometer_photo']      = 'nullable|file|mimes:jpg,jpeg,png,webp|max:5120';
        } elseif ($source === 'Another Vehicle') {
            $rules['donor_mapping_id']          = 'required|integer';
            $rules['replacement_date_other']    = 'required|date';
            $rules['replacement_km_other']      = 'nullable|numeric|min:0';
            $rules['other_serial_photo']        = 'nullable|file|mimes:jpg,jpeg,png,webp|max:5120';
            $rules['other_fitment_photo']       = 'nullable|file|mimes:jpg,jpeg,png,webp|max:5120';
            $rules['other_odometer_photo']      = 'nullable|file|mimes:jpg,jpeg,png,webp|max:5120';
        }

        $validator = Validator::make($request->all(), $rules, [
            'required' => 'This field is required.',
            'numeric'  => 'Must be a number.',
            'min'      => 'Must be at least :min.',
            'in'       => 'Invalid selection.',
            'mimes'    => 'Only JPG, PNG, or WEBP images are allowed.',
            'max'      => 'File size must not exceed 5 MB.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
                'message' => 'Please fill all required fields.',
            ], 422);
        }

        // ── 2. Driver fine required when damage_reason = Driver ────────────
        if ($request->damage_reason === 'Driver' && empty($request->driver_fine_amount)) {
            return response()->json([
                'success' => false,
                'errors'  => ['driver_fine_amount' => ['Driver fine amount is required when Driver is responsible.']],
                'message' => 'Driver fine amount is required.',
            ], 422);
        }

        // ── 3. Resolve current mapping (SD-8: find() not findOrFail()) ─────
        $mapping = Vehicletyremapping::find($request->mapping_id);
        if (!$mapping || $mapping->vehicle_id != $vehicle->id) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid tyre position mapping.',
            ], 422);
        }

        $oldTyre = Tyre::find($mapping->tyre_id);
        if (!$oldTyre) {
            return response()->json([
                'success' => false,
                'message' => 'No tyre found at this position.',
            ], 422);
        }

        // ── 4. Source-specific pre-checks ─────────────────────────────────
        $spareMapping = null;
        $donorMapping = null;

        if ($source === 'Same Vehicle Spare') {
            $spareMapping = Vehicletyremapping::find($request->spare_tyre_mapping_id);
            if (!$spareMapping || $spareMapping->vehicle_id != $vehicle->id || !$spareMapping->tyre_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Selected spare tyre is not valid or does not belong to this vehicle.',
                ], 422);
            }
        }

        if ($source === 'Another Vehicle') {
            $donorMapping = Vehicletyremapping::find($request->donor_mapping_id);
            if (!$donorMapping || !$donorMapping->tyre_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Selected donor tyre position is invalid.',
                ], 422);
            }

            // ── CRITICAL: donor vehicle must NOT be the current vehicle ────
            if ($donorMapping->vehicle_id == $vehicle->id) {
                return response()->json([
                    'success' => false,
                    'errors'  => [
                        'donor_vehicle_number' => [
                            'Donor vehicle cannot be the same as the current vehicle. Use "Same Vehicle Spare" instead.'
                        ],
                    ],
                    'message' => 'Donor vehicle cannot be the same as the current vehicle.',
                ], 422);
            }
        }

        // ── 4b. Spare capacity guard ──────────────────────────────────────
        // A vehicle may hold at most 2 spare tyres. If the old tyre is being
        // kept on this vehicle as a spare, confirm the limit is not already met.
        if (in_array($request->old_tyre_destination, ['Own Vehicle', 'Spare Tyre'])) {
            $currentSpareCount = Vehicletyremapping::where('vehicle_id', $vehicle->id)
                ->where('status', 'Spare')
                ->whereNotNull('tyre_id')
                ->count();

            if ($currentSpareCount >= 2) {
                return response()->json([
                    'success' => false,
                    'errors'  => [
                        'old_tyre_destination' => [
                            'This vehicle already has ' . $currentSpareCount . ' spare tyre(s). Maximum 2 spare tyres are allowed per vehicle. Please choose a different destination for the old tyre.',
                        ],
                    ],
                    'message' => 'Maximum spare tyre limit (2) reached for this vehicle.',
                ], 422);
            }
        }

        // ── 5. Resolve replacement date and KM per source ─────────────────
        $replacementDate = match ($source) {
            'SR Garage'          => date('Y-m-d', strtotime($request->replacement_date_garage)),
            'Direct Fitment'     => date('Y-m-d', strtotime($request->replacement_date_direct)),
            'Same Vehicle Spare' => date('Y-m-d', strtotime($request->replacement_date_spare)),
            'Another Vehicle'    => date('Y-m-d', strtotime($request->replacement_date_other)),
            default              => date('Y-m-d'),
        };

        $replacementKm = match ($source) {
            'SR Garage'          => $request->replacement_km_garage    ?? null,
            'Direct Fitment'     => $request->replacement_km_direct    ?? null,
            'Same Vehicle Spare' => $request->replacement_km_spare     ?? null,
            'Another Vehicle'    => $request->replacement_km_other     ?? null,
            default              => null,
        };

        // ── 6. Transaction ─────────────────────────────────────────────────
        try {
            $result = DB::transaction(function () use (
                $request, $vehicle, $mapping, $oldTyre, $source,
                $spareMapping, $donorMapping, $replacementDate, $replacementKm
            ) {
                $userId = Auth::id();

                // 6a. Resolve / create the replacement tyre record
                $newTyre = null;

                $orgId = Auth::user()->organisation_id ?? 1;

                if ($source === 'SR Garage') {
                    $newTyre = Tyre::create([
                        'organisation_id'    => $orgId,
                        'contact_id'         => null,
                        'location'           => 'Vehicle',
                        'tyre_condition'     => $request->new_tyre_condition_garage,
                        'tyre_type'          => $request->new_tyre_type_garage,
                        'tyre_brand'         => $request->new_tyre_brand_garage,
                        'tyre_model'         => $request->new_tyre_brand_garage,
                        'tyre_serial_number' => $request->new_tyre_serial_garage,
                        'created_by'         => $userId,
                    ]);
                } elseif ($source === 'Direct Fitment') {
                    $newTyre = Tyre::create([
                        'organisation_id'    => $orgId,
                        'contact_id'         => null,
                        'location'           => 'Vehicle',
                        'tyre_condition'     => $request->new_tyre_condition_direct,
                        'tyre_type'          => $request->new_tyre_type_direct,
                        'tyre_brand'         => $request->new_tyre_brand_direct,
                        'tyre_model'         => $request->new_tyre_brand_direct,
                        'tyre_serial_number' => $request->new_tyre_serial_direct,
                        'created_by'         => $userId,
                    ]);
                } elseif ($source === 'Same Vehicle Spare') {
                    $newTyre = Tyre::find($spareMapping->tyre_id);
                    $spareMapping->update(['tyre_id' => null, 'status' => 'Inactive']);
                    Vehicletyremappinglog::create([
                        'vehicletyremapping_id' => $spareMapping->id,
                        'vehicle_id'            => $vehicle->id,
                        'tyre_id'               => null,
                        'tyreposition_id'       => $spareMapping->tyreposition_id,
                        'status'                => 'Inactive',
                        'notes'                 => 'Spare tyre moved to mounted position during tyre replacement.',
                        'created_by'            => $userId,
                    ]);
                } elseif ($source === 'Another Vehicle') {
                    $newTyre = Tyre::find($donorMapping->tyre_id);
                    $donorMapping->update(['tyre_id' => null, 'status' => 'Inactive']);
                    Vehicletyremappinglog::create([
                        'vehicletyremapping_id' => $donorMapping->id,
                        'vehicle_id'            => $donorMapping->vehicle_id,
                        'tyre_id'               => null,
                        'tyreposition_id'       => $donorMapping->tyreposition_id,
                        'status'                => 'Inactive',
                        'notes'                 => 'Tyre transferred to vehicle #' . $vehicle->vehicle_no . ' as replacement.',
                        'created_by'            => $userId,
                    ]);
                }

                if (!$newTyre) {
                    throw new \Exception('Could not resolve replacement tyre.');
                }

                // Update new tyre allocation fields so the Tyre record reflects
                // it is now fitted to this vehicle (SD-11: always set organisation_id).
                $newTyre->update([
                    'allocated_vehicle_id' => $vehicle->id,
                    'current_status'       => 'Allocated',
                    'location'             => 'Vehicle',
                ]);

                // 6b. Handle old tyre disposal — clear its allocation, set status.
                $oldTyreNewLocation = match ($request->old_tyre_destination) {
                    'SR Garage'                 => 'Warehouse',
                    'Tyre Vendor'               => 'Service Center',
                    'Own Vehicle', 'Spare Tyre' => 'Vehicle',
                    default                     => 'Warehouse',
                };
                $oldTyreCurrentStatus = match ($request->old_tyre_destination) {
                    'Own Vehicle', 'Spare Tyre' => 'Allocated',
                    'Tyre Vendor'               => 'Workshop',
                    default                     => 'Warehouse',
                };
                $oldTyre->update([
                    'location'             => $oldTyreNewLocation,
                    'current_status'       => $oldTyreCurrentStatus,
                    'allocated_vehicle_id' => in_array($request->old_tyre_destination, ['Own Vehicle', 'Spare Tyre'])
                                                 ? $vehicle->id
                                                 : null,
                ]);

                // 6c. Keep old tyre as spare on this vehicle if requested
                if (in_array($request->old_tyre_destination, ['Own Vehicle', 'Spare Tyre'])) {
                    $allSparePositions = Tyreposition::where('code', 'like', 'S%')
                        ->where('status', 'Active')->orderBy('code')->get();
                    $occupiedSpareIds = Vehicletyremapping::where('vehicle_id', $vehicle->id)
                        ->whereNotNull('tyre_id')
                        ->whereIn('tyreposition_id', $allSparePositions->pluck('id'))
                        ->pluck('tyreposition_id')->toArray();
                    $availableSparePos = $allSparePositions->first(
                        fn($p) => !in_array($p->id, $occupiedSpareIds)
                    );
                    if ($availableSparePos) {
                        $newSpareMapping = Vehicletyremapping::create([
                            'vehicle_id'      => $vehicle->id,
                            'tyre_id'         => $oldTyre->id,
                            'tyreposition_id' => $availableSparePos->id,
                            'status'          => 'Spare',
                            'fitment_date'    => $replacementDate,
                            'km_at_fitment'   => $replacementKm,
                            'notes'           => 'Kept as spare after tyre replacement.',
                            'created_by'      => $userId,
                        ]);
                        Vehicletyremappinglog::create([
                            'vehicletyremapping_id' => $newSpareMapping->id,
                            'vehicle_id'            => $vehicle->id,
                            'tyre_id'               => $oldTyre->id,
                            'tyreposition_id'       => $availableSparePos->id,
                            'status'                => 'Spare',
                            'notes'                 => 'Moved to spare after tyre replacement.',
                            'created_by'            => $userId,
                        ]);
                    }
                }

                // 6d. Swap the mapping to the new tyre
                $mapping->update([
                    'tyre_id'       => $newTyre->id,
                    'status'        => 'Active',
                    'fitment_date'  => $replacementDate,
                    'km_at_fitment' => $replacementKm,
                    'notes'         => 'Replaced via Take Action modal. Source: ' . $source,
                ]);

                // 6e. History log for the position (never update — insert only)
                Vehicletyremappinglog::create([
                    'vehicletyremapping_id' => $mapping->id,
                    'vehicle_id'            => $vehicle->id,
                    'tyre_id'               => $newTyre->id,
                    'tyreposition_id'       => $mapping->tyreposition_id,
                    'fitment_date'          => $replacementDate,
                    'km_at_fitment'         => $replacementKm,
                    'status'                => 'Active',
                    'notes'                 => 'Replacement | Source: ' . $source,
                    'created_by'            => $userId,
                ]);

                // 6f. Tyrelog audit row for the removed tyre
                $actionNotes = json_encode([
                    'source'             => $source,
                    'replacement_reason' => $request->replacement_reason,
                    'damage_reason'      => $request->damage_reason,
                    'driver_fine'        => $request->driver_fine_amount,
                    'old_destination'    => $request->old_tyre_destination,
                    'old_action'         => $request->old_tyre_action,
                    'new_tyre_id'        => $newTyre->id,
                ]);

                $log = Tyrelog::create([
                    'action_type'        => 'Replacement',
                    'action_date'        => $replacementDate,
                    'action_km'          => $replacementKm ?? 0,
                    'vehicle_id'         => $vehicle->id,
                    'mapping_id'         => $mapping->id,
                    'tyre_id'            => $oldTyre->id,
                    'contact_id'         => $oldTyre->contact_id ?? 0,
                    'tyre_condition'     => $oldTyre->tyre_condition ?? 'Used',
                    'tyre_model'         => $oldTyre->tyre_model ?? '',
                    'tyre_type'          => $oldTyre->tyre_type,
                    'tyre_brand'         => $oldTyre->tyre_brand,
                    'tyre_price'         => $oldTyre->tyre_price ?? 0,
                    'tyre_serial_number' => $oldTyre->tyre_serial_number,
                    'action_notes'       => $actionNotes,
                    'created_by'         => $userId,
                ]);

                // 6g. Tyrelog audit row for the newly fitted tyre (Fitment)
                $newTyreLog = Tyrelog::create([
                    'action_type'        => 'Fitment',
                    'action_date'        => $replacementDate,
                    'action_km'          => $replacementKm ?? 0,
                    'vehicle_id'         => $vehicle->id,
                    'mapping_id'         => $mapping->id,
                    'tyre_id'            => $newTyre->id,
                    'contact_id'         => $newTyre->contact_id ?? 0,
                    'tyre_condition'     => $newTyre->tyre_condition ?? 'New',
                    'tyre_model'         => $newTyre->tyre_model ?? '',
                    'tyre_type'          => $newTyre->tyre_type ?? '',
                    'tyre_brand'         => $newTyre->tyre_brand ?? '',
                    'tyre_price'         => $newTyre->tyre_price ?? 0,
                    'tyre_serial_number' => $newTyre->tyre_serial_number,
                    'action_notes'       => json_encode([
                        'source'          => $source,
                        'replaced_tyre_id' => $oldTyre->id,
                    ]),
                    'created_by'         => $userId,
                ]);

                // 6h. Photo attachments → medias table (type = Image, mediable = Tyrelog)
                // Damage photos → old tyre's Replacement log ($log)
                $damagePhotos = [
                    'damage_photo_1' => 'Damage Photo 1',
                    'damage_photo_2' => 'Damage Photo 2',
                    'damage_photo_3' => 'Damage Photo 3',
                ];

                foreach ($damagePhotos as $inputName => $label) {
                    if (!$request->hasFile($inputName)) {
                        continue;
                    }
                    $file     = $request->file($inputName);
                    $fileName = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('medias' . DIRECTORY_SEPARATOR . 'tyre' . DIRECTORY_SEPARATOR), $fileName);
                    Media::create([
                        'type'          => 'Image',
                        'file_name'     => '[' . $label . '] ' . $file->getClientOriginalName(),
                        'file_path'     => 'tyre/' . $fileName,
                        'file_type'     => $file->getClientMimeType(),
                        'file_size'     => $file->getSize(),
                        'mediable_id'   => $log->id,
                        'mediable_type' => Tyrelog::class,
                        'created_by'    => $userId,
                    ]);
                }

                // Fitment photos → new tyre's Fitment log ($newTyreLog)
                $fitmentPhotos = match ($source) {
                    'SR Garage'          => [
                        'garage_serial_photo'   => 'Serial Number Photo',
                        'garage_fitment_photo'  => 'Fitment Photo',
                        'garage_odometer_photo' => 'Odometer Photo',
                    ],
                    'Direct Fitment'     => [
                        'direct_serial_photo'   => 'Serial Number Photo',
                        'direct_fitment_photo'  => 'Fitment Photo',
                        'direct_odometer_photo' => 'Odometer Photo',
                    ],
                    'Same Vehicle Spare' => [
                        'spare_serial_photo'    => 'Serial Number Photo',
                        'spare_fitment_photo'   => 'Fitment Photo',
                        'spare_odometer_photo'  => 'Odometer Photo',
                    ],
                    'Another Vehicle'    => [
                        'other_serial_photo'    => 'Serial Number Photo',
                        'other_fitment_photo'   => 'Fitment Photo',
                        'other_odometer_photo'  => 'Odometer Photo',
                    ],
                    default => [],
                };

                foreach ($fitmentPhotos as $inputName => $label) {
                    if (!$request->hasFile($inputName)) {
                        continue;
                    }
                    $file     = $request->file($inputName);
                    $fileName = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('medias' . DIRECTORY_SEPARATOR . 'tyre' . DIRECTORY_SEPARATOR), $fileName);
                    Media::create([
                        'type'          => 'Image',
                        'file_name'     => '[' . $label . '] ' . $file->getClientOriginalName(),
                        'file_path'     => 'tyre/' . $fileName,
                        'file_type'     => $file->getClientMimeType(),
                        'file_size'     => $file->getSize(),
                        'mediable_id'   => $newTyreLog->id,
                        'mediable_type' => Tyrelog::class,
                        'created_by'    => $userId,
                    ]);
                }

                return $log;
            });

            return response()->json([
                'success'      => true,
                'message'      => 'Tyre replacement logged successfully.',
                'log_id'       => $result->id,
                'redirect_url' => route('tyremanage.vehicle.tyre.tagging.v2', $vehicle->id),
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong: ' . $e->getMessage(),
            ], 500);
        }
    }

    /* ══════════════════════════════════════════════════════════════════════
     * GET  tyremanage/lookup-vehicle?vehicle_number=TS09QA3963
     * Take Action Modal — "Another Vehicle" source: look up a donor vehicle
     * by registration number. Returns the vehicle details and all of its
     * mounted tyre positions with tyre data (for the position dropdown).
     * ══════════════════════════════════════════════════════════════════════ */
    public function lookupVehicleByNumber(Request $request)
    {
        $regNumber = trim($request->input('vehicle_number', ''));

        if (!$regNumber) {
            return response()->json([
                'success' => false,
                'message' => 'Vehicle number is required.',
            ], 422);
        }

        $vehicle = Vehicle::where('vehicle_no', 'like', '%' . $regNumber . '%')->first();

        if (!$vehicle) {
            return response()->json([
                'success' => false,
                'message' => 'No vehicle found matching "' . $regNumber . '".',
            ], 422);
        }

        $mappings = Vehicletyremapping::with(['tyre', 'tyreposition'])
            ->where('vehicle_id', $vehicle->id)
            ->get();

        foreach ($mappings as $mapping) {
            $tyre = $mapping->tyre;
            if (!$tyre) {
                $mapping->rag_status         = 'grey';
                $mapping->life_remaining_pct = null;
                $mapping->remaining_run_km   = null;
                continue;
            }

            $lifeRemainingPct = null;
            if ($tyre->fixed_run_km > 0) {
                $lifeRemainingPct = max(0, round(
                    (($tyre->fixed_run_km - ($tyre->actual_run_km ?? 0)) / $tyre->fixed_run_km) * 100, 1
                ));
            }

            if ($lifeRemainingPct === null)      { $ragStatus = 'grey'; }
            elseif ($lifeRemainingPct >= 50)     { $ragStatus = 'green'; }
            elseif ($lifeRemainingPct >= 20)     { $ragStatus = 'amber'; }
            else                                 { $ragStatus = 'red'; }

            $mapping->rag_status         = $ragStatus;
            $mapping->life_remaining_pct = $lifeRemainingPct;
            $mapping->remaining_run_km   = $tyre->fixed_run_km > 0
                ? max(0, $tyre->fixed_run_km - ($tyre->actual_run_km ?? 0))
                : null;
        }

        $positions = $mappings->map(function ($m) {
            $tyre = $m->tyre;
            return [
                'mapping_id'    => $m->id,
                'position_code' => $m->tyreposition?->code ?? '?',
                'status'        => $m->status,
                'has_tyre'      => $tyre !== null,
                'tyre_id'       => $tyre?->id,
                'serial'        => $tyre?->tyre_serial_number ?? '',
                'brand'         => $tyre?->tyre_brand ?? '',
                'condition'     => $tyre?->tyre_condition ?? '',
                'type'          => $tyre?->tyre_type ?? '',
                'life_pct'      => $m->life_remaining_pct,
                'rag'           => $m->rag_status ?? 'grey',
                'remaining_km'  => $m->remaining_run_km,
            ];
        })->values();

        return response()->json([
            'success'         => true,
            'vehicle'         => [
                'id'         => $vehicle->id,
                'reg_number' => $vehicle->vehicle_no,
            ],
            'positions'       => $positions,
            'total_with_tyre' => $positions->where('has_tyre', true)->count(),
        ], 200);
    }
}
