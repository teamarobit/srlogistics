<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

use App\Models\Vehicle;
use App\Models\Battery;
use App\Models\Vehiclebattery;
use App\Models\Vehiclebatterylog;
use App\Models\Media;

class BatteryManagementController extends Controller
{
    // ─────────────────────────────────────────────────────────────────────────
    // GET  /batterymanage/vehicle/{vehicle}/battery/tagging
    // ─────────────────────────────────────────────────────────────────────────

    public function vehicleBatteryTagging(Vehicle $vehicle): View
    {
        $vehicle->load([
            'vehiclebatteries' => function ($q) {
                $q->whereNull('deleted_at')->orderBy('id');
            },
            'vehiclebatteries.medias',
            'vehiclebatteries.logs',
        ]);

        foreach ($vehicle->vehiclebatteries as $battery) {
            // Warranty remaining months
            $warrantyRemaining = null;
            if ($battery->purchase_date && $battery->warranty_months) {
                $expiry            = Carbon::parse($battery->purchase_date)->addMonths($battery->warranty_months);
                $warrantyRemaining = max(0, (int) now()->diffInMonths($expiry, false));
            }

            // Life remaining months
            $lifeFixed       = (int) ($battery->battery_life_fixed ?? 0);
            $actualRunMonths = (int) ($battery->battery_actual_run_months ?? 0);
            $lifeRemaining   = $lifeFixed > 0 ? max(0, $lifeFixed - $actualRunMonths) : null;

            // Life remaining %
            $lifeRemainingPct = null;
            if ($lifeFixed > 0) {
                $lifeRemainingPct = max(0, round((($lifeFixed - $actualRunMonths) / $lifeFixed) * 100, 1));
            }

            $battery->warranty_remaining_months = $warrantyRemaining;
            $battery->life_remaining_months     = $lifeRemaining;
            $battery->life_remaining_pct        = $lifeRemainingPct;
        }

        return view('batterymanagement.vehiclebatterytagging', compact('vehicle'));
    }

    // ─────────────────────────────────────────────────────────────────────────
    // GET  /batterymanage/batteries/available  (AJAX)
    // Returns all batteries from inventory (batteries table) that are In Stock.
    // ─────────────────────────────────────────────────────────────────────────

    public function getAvailableWarehouseBatteries(Request $request): JsonResponse
    {
        $condition = $request->get('condition');

        $query = Battery::where('current_status', 'In Stock');

        if ($condition) {
            $query->where('battery_condition', $condition);
        }

        $batteries = $query->orderBy('battery_brand')
                           ->orderBy('battery_serial')
                           ->get(['id', 'battery_serial', 'battery_brand', 'battery_model',
                                  'battery_capacity', 'battery_voltage', 'battery_condition']);

        $result = $batteries->map(function ($b) {
            return [
                'id'        => $b->id,
                'label'     => trim(($b->battery_brand ?? '') . ' — ' . ($b->battery_serial ?? '')),
                'brand'     => $b->battery_brand ?? '',
                'serial'    => $b->battery_serial ?? '',
                'model'     => $b->battery_model ?? '',
                'capacity'  => $b->battery_capacity ?? '',
                'voltage'   => $b->battery_voltage ?? '',
                'condition' => $b->battery_condition ?? '',
            ];
        });

        return response()->json(['success' => true, 'batteries' => $result], 200);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // POST  /batterymanage/vehicle/{vehicle}/battery/tag
    //
    // Two source modes:
    //   SR Warehouse  — use an existing Battery from inventory (batteries table)
    //   Direct Fitment — create a new Battery record, then tag it
    //
    // Attachments stored in medias table (type = 'Image') via mediable polymorphic.
    // Max 2 Active batteries per vehicle enforced.
    // ─────────────────────────────────────────────────────────────────────────

    public function storeBatteryTag(Request $request, Vehicle $vehicle): JsonResponse
    {
        $source = $request->input('battery_source');

        // ── Common validation rules ───────────────────────────────────────
        $rules = [
            'battery_source'    => 'required|in:SR Warehouse,Direct Fitment',
            'battery_condition' => 'required|in:New,Used,Replaced Under Warranty',
            'fitment_date'      => 'required|date',
            'km_at_fitment'     => 'nullable|integer|min:0',
            'photo_serial'      => 'nullable|file|mimes:jpg,jpeg,png,webp|max:5120',
            'photo_fitment'     => 'nullable|file|mimes:jpg,jpeg,png,webp|max:5120',
            'photo_odometer'    => 'nullable|file|mimes:jpg,jpeg,png,webp|max:5120',
        ];

        // ── Source-specific validation rules ──────────────────────────────
        if ($source === 'SR Warehouse') {
            $rules['warehouse_battery_id'] = 'required|integer';
        } else {
            // Direct Fitment — must supply brand + serial
            $rules['battery_brand']         = 'required|string|max:100';
            $rules['battery_serial_number'] = 'required|string|max:100';
            $rules['battery_model']         = 'nullable|string|max:100';
            $rules['battery_capacity']      = 'nullable|string|max:50';
            $rules['battery_voltage']       = 'nullable|in:6V,12V,24V,48V';
            $rules['purchase_date']         = 'nullable|date';
            $rules['warranty_months']       = 'nullable|integer|min:0';
        }

        $validator = Validator::make($request->all(), $rules, [
            'required'            => 'This field is required.',
            'in'                  => 'Invalid selection.',
            'warehouse_battery_id.required' => 'Please select a battery from the warehouse.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Please fill all required fields correctly.',
                'errors'  => $validator->errors(),
            ], 422);
        }

        // ── Resolve battery details by source ─────────────────────────────
        $warehouseBattery   = null;
        $batteryBrand       = null;
        $batterySerial      = null;
        $batteryModel       = null;
        $batteryCapacity    = null;
        $batteryVoltage     = null;
        $batteryCondition   = $request->battery_condition;
        $purchaseDate       = null;
        $warrantyMonths     = 0;
        $warehouseBatteryId = null;

        if ($source === 'SR Warehouse') {
            $warehouseBattery = Battery::find($request->warehouse_battery_id);
            if (! $warehouseBattery || $warehouseBattery->current_status !== 'In Stock') {
                return response()->json([
                    'success' => false,
                    'message' => 'Selected battery is not available in warehouse. It may have already been allocated.',
                ], 422);
            }
            $batteryBrand       = $warehouseBattery->battery_brand;
            $batterySerial      = $warehouseBattery->battery_serial;
            $batteryModel       = $warehouseBattery->battery_model;
            $batteryCapacity    = $warehouseBattery->battery_capacity;
            $batteryVoltage     = $warehouseBattery->battery_voltage;
            $purchaseDate       = $warehouseBattery->battery_purchase_date?->toDateString();
            $warrantyMonths     = $warehouseBattery->battery_warranty_months ?? 0;
            $warehouseBatteryId = $warehouseBattery->id;
        } else {
            // Direct Fitment
            $batteryBrand    = $request->battery_brand;
            $batterySerial   = $request->battery_serial_number;
            $batteryModel    = $request->battery_model;
            $batteryCapacity = $request->battery_capacity;
            $batteryVoltage  = $request->battery_voltage;
            $purchaseDate    = $request->purchase_date;
            $warrantyMonths  = (int) ($request->warranty_months ?? 0);
        }

        // ── Write to DB in transaction ────────────────────────────────────
        try {
            // ── Max 2 active batteries per vehicle (inside try so missing status column is caught) ──
            $activeCount = Vehiclebattery::where('vehicle_id', $vehicle->id)
                ->where('status', 'Active')
                ->whereNull('deleted_at')
                ->count();

            if ($activeCount >= 2) {
                return response()->json([
                    'success' => false,
                    'message' => 'Maximum 2 batteries can be tagged to a single vehicle. Remove an existing battery first.',
                ], 422);
            }

            $vehicleBattery = DB::transaction(function () use (
                $request, $vehicle, $source,
                $batteryBrand, $batterySerial, $batteryModel,
                $batteryCapacity, $batteryVoltage, $batteryCondition,
                $purchaseDate, $warrantyMonths, $warehouseBattery, $warehouseBatteryId
            ): Vehiclebattery {

                // ── If SR Warehouse: create a Battery record in batteries table as 'Installed' ──
                // ── If Direct Fitment: create a new Battery record first ──────────────────────
                if ($source === 'SR Warehouse') {
                    // Mark warehouse battery as installed
                    $warehouseBattery->update([
                        'current_status'      => 'Installed',
                        'allocated_vehicle_id'=> $vehicle->id,
                        'installation_date'   => $request->fitment_date,
                        'current_odometer_km' => $request->km_at_fitment ?? 0,
                        'updated_by'          => Auth::id(),
                    ]);
                } else {
                    // Direct Fitment — create a Battery record in batteries inventory
                    $warehouseBattery = Battery::create([
                        'organisation_id'      => Auth::user()->organisation_id ?? 1,
                        'battery_source_mode'  => 'Fitment',
                        'battery_serial'       => $batterySerial,
                        'battery_brand'        => $batteryBrand,
                        'battery_model'        => $batteryModel,
                        'battery_capacity'     => $batteryCapacity ?? 0,
                        'battery_voltage'      => $batteryVoltage ?? '12V',
                        'battery_condition'    => $batteryCondition,
                        'battery_purchase_date'=> $purchaseDate,
                        'battery_warranty_months' => $warrantyMonths,
                        'current_status'       => 'Installed',
                        'allocated_vehicle_id' => $vehicle->id,
                        'installation_date'    => $request->fitment_date,
                        'current_odometer_km'  => $request->km_at_fitment ?? 0,
                        'fitment_source_origin_note' => 'Tagged via Battery Management',
                        'created_by'           => Auth::id(),
                    ]);
                    $warehouseBatteryId = $warehouseBattery->id;
                }

                // ── Create vehiclebatteries record ────────────────────────
                $vehicleBattery = Vehiclebattery::create([
                    'vehicle_id'               => $vehicle->id,
                    'battery_source'           => $source,
                    'battery_serial_number'    => $batterySerial,
                    'battery_brand'            => $batteryBrand,
                    'battery_model_name'       => $batteryBrand . ($batteryModel ? ' ' . $batteryModel : ''),
                    'battery_model'            => $batteryModel,
                    'battery_capacity'         => $batteryCapacity,
                    'battery_voltage'          => $batteryVoltage,
                    'battery_condition'        => $batteryCondition,
                    'battery_price'            => 0,
                    'purchase_date'            => $purchaseDate,
                    'warranty_months'          => $warrantyMonths,
                    'fitment_date'             => $request->fitment_date,
                    'issue_date'               => $request->fitment_date,
                    'km_at_fitment'            => $request->km_at_fitment ?? 0,
                    'battery_actual_km'        => $request->km_at_fitment ?? 0,
                    'battery_life_fixed'       => null,
                    'battery_actual_run_months'=> 0,
                    'warehouse_battery_id'     => $warehouseBatteryId,
                    'status'                   => 'Active',
                    'organisation_id'          => Auth::user()->organisation_id ?? 1,
                    'created_by'               => Auth::id(),
                ]);

                // ── Create log entry ──────────────────────────────────────
                Vehiclebatterylog::create([
                    'vehiclebattery_id'        => $vehicleBattery->id,
                    'vehicle_id'               => $vehicle->id,
                    'battery_serial_number'    => $batterySerial,
                    'battery_brand'            => $batteryBrand,
                    'battery_model_name'       => $vehicleBattery->battery_model_name,
                    'battery_model'            => $batteryModel,
                    'battery_capacity'         => $batteryCapacity,
                    'battery_voltage'          => $batteryVoltage,
                    'battery_condition'        => $batteryCondition,
                    'battery_price'            => 0,
                    'fitment_date'             => $request->fitment_date,
                    'issue_date'               => $request->fitment_date,
                    'km_at_fitment'            => $request->km_at_fitment ?? 0,
                    'battery_actual_km'        => $request->km_at_fitment ?? 0,
                    'battery_life_fixed'       => null,
                    'battery_actual_run_months'=> 0,
                    'purchase_date'            => $purchaseDate,
                    'warranty_months'          => $warrantyMonths,
                    'fixed_life_months'        => null,
                    'battery_source'           => $source,
                    'warehouse_battery_id'     => $warehouseBatteryId,
                    'action'                   => 'Tagged',
                    'notes'                    => 'Battery tagged to vehicle via ' . $source . '.',
                    'organisation_id'          => Auth::user()->organisation_id ?? 1,
                    'created_by'               => Auth::id(),
                ]);

                // ── Handle photo attachments (medias table, type = 'Image') ─
                $photoFields = [
                    'photo_serial'   => 'Battery Serial Number',
                    'photo_fitment'  => 'Battery Fitment',
                    'photo_odometer' => 'Odometer',
                ];

                foreach ($photoFields as $field => $label) {
                    if (request()->hasFile($field)) {
                        $file     = request()->file($field);
                        $filename = time() . '_' . $field . '_' . $file->getClientOriginalName();
                        $file->move(public_path('medias/battery'), $filename);

                        Media::create([
                            'mediable_type' => Vehiclebattery::class,
                            'mediable_id'   => $vehicleBattery->id,
                            'type'          => 'Image',
                            'file_name'     => $label . ' — ' . $file->getClientOriginalName(),
                            'file_path'     => 'battery/' . $filename,
                            'created_by'    => Auth::id(),
                        ]);
                    }
                }

                return $vehicleBattery;
            });

            return response()->json([
                'success'  => true,
                'message'  => 'Battery tagged successfully.',
                'redirect' => route('batterymanage.vehicle.battery.tagging', $vehicle->id),
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to tag battery: ' . $e->getMessage(),
            ], 500);
        }
    }

    // ─────────────────────────────────────────────────────────────────────────
    // POST  /batterymanage/vehicle/{vehicle}/battery/{battery}/remove
    // ─────────────────────────────────────────────────────────────────────────

    public function removeBatteryTag(Request $request, Vehicle $vehicle, int $batteryId): JsonResponse
    {
        $battery = Vehiclebattery::where('id', $batteryId)
            ->where('vehicle_id', $vehicle->id)
            ->first();

        if (! $battery) {
            return response()->json([
                'success' => false,
                'message' => 'Battery record not found for this vehicle.',
            ], 422);
        }

        try {
            DB::transaction(function () use ($battery, $request, $vehicle): void {
                // Log the removal
                Vehiclebatterylog::create([
                    'vehiclebattery_id'        => $battery->id,
                    'vehicle_id'               => $vehicle->id,
                    'battery_model_name'       => $battery->battery_model_name,
                    'battery_model'            => $battery->battery_model,
                    'battery_serial_number'    => $battery->battery_serial_number,
                    'battery_brand'            => $battery->battery_brand,
                    'battery_capacity'         => $battery->battery_capacity,
                    'battery_voltage'          => $battery->battery_voltage,
                    'battery_condition'        => $battery->battery_condition,
                    'battery_price'            => $battery->battery_price ?? 0,
                    'purchase_date'            => $battery->purchase_date,
                    'warranty_months'          => $battery->warranty_months,
                    'fitment_date'             => $battery->fitment_date,
                    'battery_actual_km'        => $battery->battery_actual_km,
                    'battery_life_fixed'       => $battery->battery_life_fixed,
                    'battery_actual_run_months'=> $battery->battery_actual_run_months,
                    'battery_source'           => $battery->battery_source,
                    'warehouse_battery_id'     => $battery->warehouse_battery_id,
                    'km_at_fitment'            => $battery->km_at_fitment ?? 0,
                    'action'                   => 'Removed',
                    'notes'                    => $request->notes ?? 'Battery removed from vehicle.',
                    'organisation_id'          => Auth::user()->organisation_id ?? 1,
                    'created_by'               => Auth::id(),
                ]);

                // If sourced from warehouse, mark battery back to In Stock
                if ($battery->warehouse_battery_id) {
                    Battery::where('id', $battery->warehouse_battery_id)->update([
                        'current_status'       => 'In Stock',
                        'allocated_vehicle_id' => null,
                        'installation_date'    => null,
                        'updated_by'           => Auth::id(),
                    ]);
                }

                // Soft-delete and deactivate
                $battery->update([
                    'status'     => 'Inactive',
                    'updated_by' => Auth::id(),
                ]);
                $battery->delete();
            });

            return response()->json([
                'success'  => true,
                'message'  => 'Battery removed successfully.',
                'redirect' => route('batterymanage.vehicle.battery.tagging', $vehicle->id),
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove battery: ' . $e->getMessage(),
            ], 500);
        }
    }

    // ─────────────────────────────────────────────────────────────────────────
    // GET  /batterymanage/vehicle/{vehicle}/battery/{battery}/logs  (AJAX)
    // ─────────────────────────────────────────────────────────────────────────

    public function getBatteryLogs(Vehicle $vehicle, int $batteryId): JsonResponse
    {
        $battery = Vehiclebattery::find($batteryId);
        if (! $battery || $battery->vehicle_id !== $vehicle->id) {
            return response()->json(['success' => false, 'message' => 'Battery not found.'], 422);
        }

        $logs = Vehiclebatterylog::where('vehiclebattery_id', $batteryId)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($log) {
                return [
                    'id'           => $log->id,
                    'action'       => $log->action,
                    'notes'        => $log->notes,
                    'source'       => $log->battery_source ?? '—',
                    'fitment_date' => $log->fitment_date
                                        ? Carbon::parse($log->fitment_date)->format('d M Y')
                                        : '—',
                    'actual_km'    => $log->battery_actual_km
                                        ? number_format($log->battery_actual_km) . ' KM'
                                        : '—',
                    'rag_status'   => $log->rag_status ?? '—',
                    'created_at'   => Carbon::parse($log->created_at)->format('d M Y, h:i A'),
                ];
            });

        return response()->json(['success' => true, 'logs' => $logs], 200);
    }
}
