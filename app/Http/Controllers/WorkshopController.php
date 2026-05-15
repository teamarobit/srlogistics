<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Insuranceclaim;
use App\Models\Insuranceclaimfollowup;
use App\Models\Vehicle;
use App\Models\Vehiclebasicinfo;
use App\Models\Workshop;
use App\Models\State;
use App\Models\City;
use App\Models\SparePart;
use App\Models\WsSparePartCategory;
use App\Models\Attachmenttype;
use App\Models\Battery;
use App\Models\Comment;
use App\Models\Media;
use App\Models\Mediadocument;
use App\Services\MediaDocumentService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class WorkshopController extends Controller
{
    // ─── Service Requests ────────────────────────────────────────────────────

    public function dashboard()
    {
        return view('ws.dashboard');
    }

    public function serviceRequest()
    {
        return view('ws.service-request');
    }

    public function appointment()
    {
        return view('ws.appointment');
    }

    public function inToken()
    {
        return view('ws.in-token');
    }

    public function onroadService()
    {
        return view('ws.onroad-service');
    }

    // ─── Workshop / SC Operations ─────────────────────────────────────────────

    public function jobCardList()
    {
        return view('ws.job-card-list');
    }

    public function jobCardDetails($id)
    {
        return view('ws.job-card-details', compact('id'));
    }

    public function technicianDashboard()
    {
        return view('ws.technician-dashboard');
    }

    public function billing()
    {
        return view('ws.billing');
    }

    public function delivery()
    {
        return view('ws.delivery');
    }

    // ─── Insurance ───────────────────────────────────────────────────────────

    public function insurance(Request $request)
    {
        $query = Insuranceclaim::with(['vehicle', 'workshop', 'createdBy'])
            ->whereNull('deleted_at')
            ->latest();

        // ── Filters ──────────────────────────────────────────────────────────
        if ($s = $request->search) {
            $query->where(function ($q) use ($s) {
                $q->where('claim_number', 'like', "%$s%")
                  ->orWhereHas('vehicle', fn($v) => $v->where('vehicle_no', 'like', "%$s%"));
            });
        }
        if ($status = $request->status) {
            $query->where('status', $status);
        }
        if ($vehicle = $request->vehicle_id) {
            $query->where('vehicle_id', $vehicle);
        }

        $claims = $query->paginate(15)->withQueryString();

        $summary = [
            'total'    => Insuranceclaim::whereNull('deleted_at')->count(),
            'open'     => Insuranceclaim::whereNull('deleted_at')->whereNotIn('status', ['Closed', 'Rejected'])->count(),
            'pending'  => Insuranceclaim::whereNull('deleted_at')->whereIn('status', ['Filed', 'Surveyor Assigned', 'Survey in Progress'])->count(),
            'approved' => Insuranceclaim::whereNull('deleted_at')->whereIn('status', ['Insurer Approved', 'Settlement Received'])->count(),
        ];

        $vehicles  = Vehicle::whereNull('deleted_at')->orderBy('vehicle_no')->get(['id', 'vehicle_no']);
        $workshops = Workshop::active()->orderBy('name')->get(['id', 'name', 'ownership', 'workshop_type']);

        // ── Policy expiry: vehicles with active claims only ─────────────────
        $claimedVehicleIds = Insuranceclaim::whereNull('deleted_at')
            ->whereNotIn('status', ['Closed', 'Rejected'])
            ->pluck('vehicle_id')
            ->unique();

        $expiringPolicies = Vehicle::with('basicinfo')
            ->whereIn('id', $claimedVehicleIds)
            ->whereHas('basicinfo', fn($q) => $q->whereNotNull('insurance_expiry'))
            ->get()
            ->map(function ($v) {
                $exp      = \Carbon\Carbon::parse($v->basicinfo->insurance_expiry);
                $daysLeft = (int) now()->diffInDays($exp, false);
                return [
                    'vehicle'     => $v,
                    'expiry'      => $exp,
                    'days_left'   => $daysLeft,
                    'chip_status' => $daysLeft < 0 ? 'expired' : ($daysLeft <= 30 ? 'expiring' : 'ok'),
                    'policy_no'   => $v->basicinfo->insurance_no ?? null,
                    'insurer'     => $v->basicinfo->insurer ?? null,
                    'note'        => $v->basicinfo->insurance_note ?? null,
                ];
            })
            ->sortBy('days_left');

        return view('ws.insurance', compact('claims', 'summary', 'vehicles', 'workshops', 'expiringPolicies'));
    }

    public function insuranceDetail($id)
    {
        $claim = Insuranceclaim::with([
            'vehicle',
            'vehicle.basicinfo',
            'workshop',
            'followups',
            'createdBy',
            'updatedBy',
        ])->findOrFail($id);

        return view('ws.insurance-claim-detail', compact('claim'));
    }

    public function insuranceAddNote(Request $request, $vehicleId)
    {
        $request->validate(['note' => 'required|string|max:1000']);

        $info = Vehiclebasicinfo::where('vehicle_id', $vehicleId)->firstOrFail();
        $info->update(['insurance_note' => $request->note]);

        return response()->json(['success' => true, 'message' => 'Note saved.']);
    }

    // ─── Master Data — Workshops (unified Own + External) ─────────────────────

    public function masterWorkshops(Request $request)
    {
        $query = Workshop::with(['state', 'city'])->whereNull('deleted_at')->orderBy('workshop_code');

        if ($ownership = $request->ownership) {
            $query->where('ownership', $ownership);
        }

        $workshops = $query->get();

        $ownCount      = Workshop::whereNull('deleted_at')->where('ownership', 'Own')->count();
        $externalCount = Workshop::whereNull('deleted_at')->where('ownership', 'External')->count();

        // India states only (country_id = 101)
        $states = State::where('country_id', 101)->orderBy('name')->get(['id', 'name', 'country_id']);

        return view('ws.master-workshops', compact('workshops', 'ownCount', 'externalCount', 'states'));
    }

    /**
     * AJAX — Return cities for a given state.
     * GET /workshop/master/workshops/cities?state_id={id}
     * SD-9: Explicit HTTP status code.
     */
    public function masterWorkshopCities(Request $request): JsonResponse
    {
        $stateId = $request->integer('state_id');

        if (! $stateId) {
            return response()->json([], 200);
        }

        $cities = City::where('state_id', $stateId)
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json($cities, 200);
    }

    /**
     * Resolve city: find by (state_id, name) — create if not found.
     * Called inside DB::transaction() — SD-6 compliant.
     */
    private function resolveCity(int $stateId, string $cityName): City
    {
        return City::firstOrCreate(
            ['state_id' => $stateId, 'name' => trim($cityName)]
        );
    }

    public function masterWorkshopStore(Request $request): JsonResponse
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'ownership'     => 'required|in:Own,External',
            'workshop_type' => 'required|in:Workshop,Mobile Unit,Hybrid,Brand ASC,Third Party,Warranty,Multi-Brand',
            'brand'         => 'nullable|string|max:100',
            'state_id'      => 'nullable|integer|exists:states,id',
            'city'          => 'nullable|string|max:100',
            'contact_phone' => 'nullable|string|max:20',
        ]);

        try {
            // SD-5: DB::transaction with try-catch and return
            // SD-6: Multiple tables (workshops + cities) inside one transaction
            $ws = DB::transaction(function () use ($request): Workshop {
                $cityId = null;
                if ($request->state_id && $request->city) {
                    $cityId = $this->resolveCity((int) $request->state_id, $request->city)->id;
                }

                return Workshop::create([
                    'workshop_code'    => Workshop::nextWorkshopCode($request->ownership, $request->city ?? 'GEN'),
                    'name'             => $request->name,
                    'ownership'        => $request->ownership,
                    'workshop_type'    => $request->workshop_type,
                    'brand'            => $request->brand,
                    'state_id'         => $request->state_id,
                    'city_id'          => $cityId,
                    'address'          => $request->address,
                    'pincode'          => $request->pincode,
                    'manager_name'     => $request->manager_name,
                    'contact_phone'    => $request->contact_phone,
                    'contact_email'    => $request->contact_email,
                    'technician_count' => $request->technician_count ?? 0,
                    'notes'            => $request->notes,
                    'status'           => 'Active',
                    'organisation_id'  => Auth::user()->organisation_id ?? 1,
                    'created_by'       => Auth::id(),
                ]);
            });

            return response()->json([
                'success'  => true,
                'workshop' => $ws,
                'message'  => $ws->name . ' added successfully.',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add workshop. Please try again.',
            ], 500);
        }
    }

    public function masterWorkshopUpdate(Request $request, int $id): JsonResponse
    {
        // SD-8: use find() + manual 422 — never findOrFail() in AJAX methods
        $ws = Workshop::find($id);
        if (! $ws) {
            return response()->json(['success' => false, 'message' => 'Workshop not found.'], 422);
        }

        $request->validate([
            'name'          => 'required|string|max:255',
            'ownership'     => 'required|in:Own,External',
            'workshop_type' => 'required|in:Workshop,Mobile Unit,Hybrid,Brand ASC,Third Party,Warranty,Multi-Brand',
            'brand'         => 'nullable|string|max:100',
            'state_id'      => 'nullable|integer|exists:states,id',
            'city'          => 'nullable|string|max:100',
            'contact_phone' => 'nullable|string|max:20',
            'status'        => 'nullable|in:Active,Inactive',
        ]);

        try {
            // SD-5 + SD-6: transaction with try-catch, return, multi-table write
            DB::transaction(function () use ($request, $ws): void {
                $cityId = null;
                if ($request->state_id && $request->city) {
                    $cityId = $this->resolveCity((int) $request->state_id, $request->city)->id;
                }

                $ws->update([
                    'name'             => $request->name,
                    'ownership'        => $request->ownership,
                    'workshop_type'    => $request->workshop_type,
                    'brand'            => $request->brand,
                    'state_id'         => $request->state_id,
                    'city_id'          => $cityId,
                    'address'          => $request->address,
                    'pincode'          => $request->pincode,
                    'manager_name'     => $request->manager_name,
                    'contact_phone'    => $request->contact_phone,
                    'contact_email'    => $request->contact_email,
                    'technician_count' => $request->technician_count ?? $ws->technician_count,
                    'notes'            => $request->notes,
                    'status'           => $request->status ?? $ws->status,
                    'updated_by'       => Auth::id(),
                ]);
            });

            return response()->json([
                'success'  => true,
                'workshop' => $ws->fresh(),
                'message'  => $ws->name . ' updated successfully.',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update workshop. Please try again.',
            ], 500);
        }
    }

    public function masterWorkshopChangeStatus(int $id)
    {
        // SD-8: use find() + manual 404 — never findOrFail() in AJAX methods
        $ws = Workshop::find($id);
        if (! $ws) {
            return response()->json(['success' => false, 'message' => 'Workshop not found.'], 422);
        }

        try {
            \DB::transaction(function () use ($ws) {
                $ws->update([
                    'status' => $ws->status == 'Active' ? 'Inactive' : 'Active'
                ]);
            });

            return response()->json(['success' => true, 'message' => $ws->name . ' status has been changed successfully..'], 200);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to change the status of workshop.'], 500);
        }
    }

    // ─── Master Data — Services ───────────────────────────────────────────────

    public function masterServices()
    {
        return view('ws.master-services');
    }

    public function masterServiceKeyPoints()
    {
        return view('ws.master-service-key-points');
    }

    // ─── Spare Parts — Master CRUD ────────────────────────────────────────────

    /** GET /workshop/master/spare-parts */
    public function masterSpareParts(Request $request)
    {
        // Auto-generate next part number if requested
        if ($request->has('_auto_no')) {
            return response()->json(['part_no' => SparePart::nextPartNo()]);
        }

        $query = SparePart::with('partCategory');

        if ($search = $request->search) {
            $query->search($search);
        }
        if ($categoryId = $request->category) {
            $query->where('wssparepartscategory_id', $categoryId);
        }
        if ($status = $request->status) {
            $query->where('status', $status);
        }

        $parts      = $query->orderBy('part_no')->paginate(25)->withQueryString();
        $categories = WsSparePartCategory::active()->orderBy('name')->get();

        return view('ws.master-spare-parts', compact('parts', 'categories'));
    }

    /** POST /workshop/master/spare-parts */
    public function masterSparePartStore(Request $request)
    {
        // Auto-number endpoint
        if ($request->has('_auto_no')) {
            return response()->json(['part_no' => SparePart::nextPartNo()]);
        }

        $validated = $request->validate([
            'part_no'          => 'required|string|max:50|unique:wsspareparts,part_no',
            'name'             => 'required|string|max:255',
            'wssparepartscategory_id' => 'nullable|exists:wssparepartscategories,id',
            'compatible_makes' => 'nullable|string|max:500',
            'unit'             => 'required|string|max:30',
            'standard_cost'    => 'required|numeric|min:0',
            'reorder_level'    => 'required|integer|min:0',
            'notes'            => 'nullable|string|max:1000',
        ]);

        $part = SparePart::create(array_merge($validated, [
            'status'     => 'Active',
            'created_by' => Auth::id(),
        ]));

        return response()->json([
            'success' => true,
            'part'    => $part,
            'message' => "{$part->name} ({$part->part_no}) added successfully.",
        ]);
    }

    /** PUT /workshop/master/spare-parts/{id} */
    public function masterSparePartUpdate(Request $request, int $id)
    {
        $part = SparePart::findOrFail($id);

        $validated = $request->validate([
            'part_no'          => "required|string|max:50|unique:wsspareparts,part_no,{$id}",
            'name'             => 'required|string|max:255',
            'wssparepartscategory_id' => 'nullable|exists:wssparepartscategories,id',
            'compatible_makes' => 'nullable|string|max:500',
            'unit'             => 'required|string|max:30',
            'standard_cost'    => 'required|numeric|min:0',
            'reorder_level'    => 'required|integer|min:0',
            'notes'            => 'nullable|string|max:1000',
        ]);

        $part->update(array_merge($validated, ['updated_by' => Auth::id()]));

        return response()->json([
            'success' => true,
            'part'    => $part->fresh(),
            'message' => "{$part->name} updated successfully.",
        ]);
    }

    /** DELETE /workshop/master/spare-parts/{id} */
    public function masterSparePartDestroy(int $id)
    {
        $part = SparePart::findOrFail($id);
        $part->update(['deleted_by' => Auth::id()]);
        $part->delete(); // soft delete

        return response()->json([
            'success' => true,
            'message' => "{$part->name} removed from spare parts master.",
        ]);
    }

    /** PATCH /workshop/master/spare-parts/{id}/status */
    public function masterSparePartToggleStatus(int $id)
    {
        $part       = SparePart::findOrFail($id);
        $newStatus  = $part->status === 'Active' ? 'Inactive' : 'Active';

        $part->update(['status' => $newStatus, 'updated_by' => Auth::id()]);

        return response()->json([
            'success'    => true,
            'new_status' => $newStatus,
            'message'    => "{$part->name} marked as {$newStatus}.",
        ]);
    }

    // ─── Spare Part Categories ────────────────────────────────────────────────

    /** GET /workshop/master/spare-part-categories */
    public function masterSparePartCategories(Request $request)
    {
        $query = WsSparePartCategory::query();

        if ($search = $request->search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        if ($status = $request->status) {
            $query->where('status', $status);
        }

        $categories = $query->orderBy('name')->paginate(25)->withQueryString();

        return view('ws.master-spare-part-categories', compact('categories'));
    }

    /** POST /workshop/master/spare-part-categories */
    public function masterSparePartCategoryStore(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:100|unique:wssparepartscategories,name',
            'code'        => 'nullable|string|max:30|unique:wssparepartscategories,code',
            'description' => 'nullable|string|max:500',
        ]);

        $category = WsSparePartCategory::create(array_merge($validated, [
            'status'     => 'Active',
            'created_by' => Auth::id(),
        ]));

        return response()->json([
            'success'  => true,
            'category' => $category,
            'message'  => "{$category->name} added successfully.",
        ]);
    }

    /** PUT /workshop/master/spare-part-categories/{id} */
    public function masterSparePartCategoryUpdate(Request $request, int $id)
    {
        $category = WsSparePartCategory::findOrFail($id);

        $validated = $request->validate([
            'name'        => "required|string|max:100|unique:wssparepartscategories,name,{$id}",
            'code'        => "nullable|string|max:30|unique:wssparepartscategories,code,{$id}",
            'description' => 'nullable|string|max:500',
        ]);

        $category->update(array_merge($validated, ['updated_by' => Auth::id()]));

        return response()->json([
            'success'  => true,
            'category' => $category->fresh(),
            'message'  => "{$category->name} updated successfully.",
        ]);
    }

    /** DELETE /workshop/master/spare-part-categories/{id} */
    public function masterSparePartCategoryDestroy(int $id)
    {
        $category = WsSparePartCategory::findOrFail($id);
        $category->update(['deleted_by' => Auth::id()]);
        $category->delete();

        return response()->json([
            'success' => true,
            'message' => "{$category->name} removed.",
        ]);
    }

    /** PATCH /workshop/master/spare-part-categories/{id}/status */
    public function masterSparePartCategoryToggleStatus(int $id)
    {
        $category  = WsSparePartCategory::findOrFail($id);
        $newStatus = $category->status === 'Active' ? 'Inactive' : 'Active';
        $category->update(['status' => $newStatus, 'updated_by' => Auth::id()]);

        return response()->json([
            'success'    => true,
            'new_status' => $newStatus,
            'message'    => "{$category->name} marked as {$newStatus}.",
        ]);
    }

    public function masterMaintenanceItems()
    {
        return view('ws.master-maintenance-items');
    }

    public function masterFaultCodes()
    {
        return view('ws.master-fault-codes');
    }

    // ─── Maintenance ──────────────────────────────────────────────────────────

    public function pmCalendar()
    {
        return view('ws.pm-calendar');
    }

    public function alerts()
    {
        return view('ws.alerts');
    }

    public function reports()
    {
        return view('ws.reports');
    }

    // ─── External Dispatch / Tracker (uses Workshop model now) ───────────────

    public function externalDispatch()
    {
        return view('ws.external-dispatch');
    }

    public function externalTracker()
    {
        return view('ws.external-tracker');
    }

    public function externalBilling()
    {
        return view('ws.external-billing');
    }

    public function externalReturn()
    {
        return view('ws.external-return');
    }

    // ─── Inventory ────────────────────────────────────────────────────────────

    public function inventoryDashboard()
    {
        return view('ws.inventory-dashboard');
    }

    public function spareParts()
    {
        return view('ws.spare-parts');
    }

    public function tyreInventory()
    {
        return view('ws.tyre-inventory');
    }

    public function batteryInventory()
    {
        return view('ws.battery-inventory');
    }

    public function batteryDashboard(\Illuminate\Http\Request $request)
    {
        $org_id = Auth::user()->organisation_id ?? 1;

        // ── Sort / direction ─────────────────────────────────────────────
        $allowedSorts = [
            'battery_serial', 'battery_brand', 'battery_model',
            'battery_capacity', 'battery_voltage', 'battery_condition',
            'battery_purchase_cost', 'battery_purchase_date',
            'warranty_claim_date', 'warranty_expected_closure_date',
            'repair_sent_date', 'repair_expected_closure_date',
            'scrap_sent_date', 'created_at',
        ];
        $sort      = $request->input('sort', 'created_at');
        $direction = $request->input('direction', 'desc');
        if (! in_array($sort, $allowedSorts)) { $sort = 'created_at'; }
        $direction = ($direction === 'asc') ? 'asc' : 'desc';

        // ── Eager-load relationships ──────────────────────────────────────
        $with = ['vendor', 'scrapVendor', 'repairVendor', 'allocatedVehicle.basicinfo', 'allocatedVehicle.group', 'images'];

        // ── Counter queries (for summary cards) ───────────────────────────
        $all_count            = \App\Models\Battery::where('organisation_id', $org_id)->count();
        $allocated_count      = \App\Models\Battery::where('organisation_id', $org_id)->where('battery_status', 'Allocated')->count();
        $direct_fitment_count = \App\Models\Battery::where('organisation_id', $org_id)->where('battery_status', 'Direct Fitment')->count();
        $yet_to_decide_count  = \App\Models\Battery::where('organisation_id', $org_id)->where('battery_status', 'Yet to Decide')->count();
        $ready_to_use_count   = \App\Models\Battery::where('organisation_id', $org_id)->where('battery_status', 'Ready to Use')->count();
        $warranty_claim_count = \App\Models\Battery::where('organisation_id', $org_id)->where('battery_status', 'Warranty Claim')->count();
        $repair_count         = \App\Models\Battery::where('organisation_id', $org_id)->where('battery_status', 'Repair')->count();
        $scrap_count          = \App\Models\Battery::where('organisation_id', $org_id)->where('battery_status', 'Scrap')->count();

        // ── Tab 1: All Batteries ──────────────────────────────────────────
        $q1 = \App\Models\Battery::with($with)->where('organisation_id', $org_id)->orderBy($sort, $direction);
        if ($request->filled('f1_location'))       { $q1->where('battery_location', $request->f1_location); }
        if ($request->filled('f1_status'))         { $q1->where('battery_status', $request->f1_status); }
        if ($request->filled('f1_capacity'))       { $q1->where('battery_capacity', $request->f1_capacity); }
        if ($request->filled('f1_voltage'))        { $q1->where('battery_voltage', $request->f1_voltage); }
        if ($request->filled('f1_condition'))      { $q1->where('battery_condition', $request->f1_condition); }
        if ($request->filled('f1_rag'))            { $q1->where('rag_status', $request->f1_rag); }
        if ($request->filled('f1_brand'))          { $q1->where('battery_brand', $request->f1_brand); }
        if ($request->filled('f1_tracking_group')) { $q1->where('tracking_group_id', $request->f1_tracking_group); }
        if ($request->filled('f1_vendor'))         { $q1->where('vendor_id', $request->f1_vendor); }
        if ($request->filled('f1_vehicle'))        { $q1->whereHas('allocatedVehicle.basicinfo', fn($q) => $q->where('vehicle_number', 'like', '%'.$request->f1_vehicle.'%')); }
        if ($request->filled('f1_serial'))         { $q1->where('battery_serial', 'like', '%'.$request->f1_serial.'%'); }
        $all_batteries = $q1->paginate(15, ['*'], 'tab1_page');

        // ── Tab 2: Ready to Use ───────────────────────────────────────────
        $q2 = \App\Models\Battery::with($with)->where('organisation_id', $org_id)
              ->where('battery_status', 'Ready to Use')->orderBy($sort, $direction);
        if ($request->filled('f2_capacity'))  { $q2->where('battery_capacity', $request->f2_capacity); }
        if ($request->filled('f2_voltage'))   { $q2->where('battery_voltage', $request->f2_voltage); }
        if ($request->filled('f2_condition')) { $q2->where('battery_condition', $request->f2_condition); }
        if ($request->filled('f2_rag'))       { $q2->where('rag_status', $request->f2_rag); }
        if ($request->filled('f2_brand'))     { $q2->where('battery_brand', $request->f2_brand); }
        if ($request->filled('f2_vendor'))    { $q2->where('vendor_id', $request->f2_vendor); }
        if ($request->filled('f2_serial'))    { $q2->where('battery_serial', 'like', '%'.$request->f2_serial.'%'); }
        if ($request->filled('f2_warranty')) {
            if ($request->f2_warranty === 'In Warranty') {
                $q2->whereNotNull('battery_warranty_expiry_date')->where('battery_warranty_expiry_date', '>=', now()->toDateString());
            } elseif ($request->f2_warranty === 'Out of Warranty') {
                $q2->where(fn($q) => $q->whereNull('battery_warranty_expiry_date')->orWhere('battery_warranty_expiry_date', '<', now()->toDateString()));
            }
        }
        $ready_batteries = $q2->paginate(15, ['*'], 'tab2_page');

        // ── Tab 3: Warranty Claim ─────────────────────────────────────────
        $q3 = \App\Models\Battery::with($with)->where('organisation_id', $org_id)
              ->where('battery_status', 'Warranty Claim')->orderBy($sort, $direction);
        if ($request->filled('f3_capacity'))         { $q3->where('battery_capacity', $request->f3_capacity); }
        if ($request->filled('f3_voltage'))          { $q3->where('battery_voltage', $request->f3_voltage); }
        if ($request->filled('f3_location'))         { $q3->where('warranty_claim_location', $request->f3_location); }
        if ($request->filled('f3_rag'))              { $q3->where('rag_status', $request->f3_rag); }
        if ($request->filled('f3_claim_reason'))     { $q3->where('warranty_claim_reason', 'like', '%'.$request->f3_claim_reason.'%'); }
        if ($request->filled('f3_brand'))            { $q3->where('battery_brand', $request->f3_brand); }
        if ($request->filled('f3_vendor'))           { $q3->where('vendor_id', $request->f3_vendor); }
        if ($request->filled('f3_serial'))           { $q3->where('battery_serial', 'like', '%'.$request->f3_serial.'%'); }
        if ($request->filled('f3_new_serial'))       { $q3->where('warranty_new_battery_serial', 'like', '%'.$request->f3_new_serial.'%'); }
        $warranty_batteries = $q3->paginate(15, ['*'], 'tab3_page');

        // ── Tab 4: Repair ─────────────────────────────────────────────────
        $q4 = \App\Models\Battery::with($with)->where('organisation_id', $org_id)
              ->where('battery_status', 'Repair')->orderBy($sort, $direction);
        if ($request->filled('f4_capacity'))      { $q4->where('battery_capacity', $request->f4_capacity); }
        if ($request->filled('f4_voltage'))       { $q4->where('battery_voltage', $request->f4_voltage); }
        if ($request->filled('f4_location'))      { $q4->where('repair_location', $request->f4_location); }
        if ($request->filled('f4_rag'))           { $q4->where('rag_status', $request->f4_rag); }
        if ($request->filled('f4_brand'))         { $q4->where('battery_brand', $request->f4_brand); }
        if ($request->filled('f4_repair_vendor')) { $q4->where('repair_vendor_id', $request->f4_repair_vendor); }
        if ($request->filled('f4_serial'))        { $q4->where('battery_serial', 'like', '%'.$request->f4_serial.'%'); }
        $repair_batteries = $q4->paginate(15, ['*'], 'tab4_page');

        // ── Tab 5: Scrap ──────────────────────────────────────────────────
        $q5 = \App\Models\Battery::with($with)->where('organisation_id', $org_id)
              ->where('battery_status', 'Scrap')->orderBy($sort, $direction);
        if ($request->filled('f5_capacity'))      { $q5->where('battery_capacity', $request->f5_capacity); }
        if ($request->filled('f5_voltage'))       { $q5->where('battery_voltage', $request->f5_voltage); }
        if ($request->filled('f5_location'))      { $q5->where('scrap_location', $request->f5_location); }
        if ($request->filled('f5_rag'))           { $q5->where('rag_status', $request->f5_rag); }
        if ($request->filled('f5_scrap_reason'))  { $q5->where('scrap_reason', 'like', '%'.$request->f5_scrap_reason.'%'); }
        if ($request->filled('f5_income_received')) {
            if ($request->f5_income_received === 'Yes') { $q5->whereNotNull('scrap_income_utr'); }
            else                                         { $q5->whereNull('scrap_income_utr'); }
        }
        if ($request->filled('f5_brand'))         { $q5->where('battery_brand', $request->f5_brand); }
        if ($request->filled('f5_scrap_vendor'))  { $q5->where('scrap_vendor_id', $request->f5_scrap_vendor); }
        if ($request->filled('f5_serial'))        { $q5->where('battery_serial', 'like', '%'.$request->f5_serial.'%'); }
        if ($request->filled('f5_vehicle'))       { $q5->whereHas('scrapLastVehicle.basicinfo', fn($q) => $q->where('vehicle_number', 'like', '%'.$request->f5_vehicle.'%')); }
        $scrap_batteries = $q5->paginate(15, ['*'], 'tab5_page');

        // ── Tab 6: Allocated ──────────────────────────────────────────────
        $q6 = \App\Models\Battery::with($with)->where('organisation_id', $org_id)
              ->where('battery_status', 'Allocated')->orderBy($sort, $direction);
        if ($request->filled('f6_capacity'))  { $q6->where('battery_capacity', $request->f6_capacity); }
        if ($request->filled('f6_voltage'))   { $q6->where('battery_voltage', $request->f6_voltage); }
        if ($request->filled('f6_condition')) { $q6->where('battery_condition', $request->f6_condition); }
        if ($request->filled('f6_rag'))       { $q6->where('rag_status', $request->f6_rag); }
        if ($request->filled('f6_brand'))     { $q6->where('battery_brand', $request->f6_brand); }
        if ($request->filled('f6_vendor'))    { $q6->where('vendor_id', $request->f6_vendor); }
        if ($request->filled('f6_serial'))    { $q6->where('battery_serial', 'like', '%'.$request->f6_serial.'%'); }
        if ($request->filled('f6_vehicle'))   { $q6->whereHas('allocatedVehicle.basicinfo', fn($q) => $q->where('vehicle_number', 'like', '%'.$request->f6_vehicle.'%')); }
        if ($request->filled('f6_warranty')) {
            if ($request->f6_warranty === 'Active') {
                $q6->whereNotNull('battery_warranty_expiry_date')->where('battery_warranty_expiry_date', '>=', now()->toDateString());
            } elseif ($request->f6_warranty === 'Expired') {
                $q6->where(fn($q) => $q->whereNull('battery_warranty_expiry_date')->orWhere('battery_warranty_expiry_date', '<', now()->toDateString()));
            }
        }
        $allocated_batteries = $q6->paginate(15, ['*'], 'tab6_page');

        // ── Tab 7: Direct Fitment ─────────────────────────────────────────
        $q7 = \App\Models\Battery::with($with)->where('organisation_id', $org_id)
              ->where('battery_status', 'Direct Fitment')->orderBy($sort, $direction);
        if ($request->filled('f7_capacity'))  { $q7->where('battery_capacity', $request->f7_capacity); }
        if ($request->filled('f7_voltage'))   { $q7->where('battery_voltage', $request->f7_voltage); }
        if ($request->filled('f7_condition')) { $q7->where('battery_condition', $request->f7_condition); }
        if ($request->filled('f7_rag'))       { $q7->where('rag_status', $request->f7_rag); }
        if ($request->filled('f7_brand'))     { $q7->where('battery_brand', $request->f7_brand); }
        if ($request->filled('f7_vendor'))    { $q7->where('vendor_id', $request->f7_vendor); }
        if ($request->filled('f7_serial'))    { $q7->where('battery_serial', 'like', '%'.$request->f7_serial.'%'); }
        $direct_fitment_batteries = $q7->paginate(15, ['*'], 'tab7_page');

        // ── Tab 8: Yet to Decide ──────────────────────────────────────────
        $q8 = \App\Models\Battery::with($with)->where('organisation_id', $org_id)
              ->where('battery_status', 'Yet to Decide')->orderBy($sort, $direction);
        if ($request->filled('f8_capacity'))      { $q8->where('battery_capacity', $request->f8_capacity); }
        if ($request->filled('f8_voltage'))       { $q8->where('battery_voltage', $request->f8_voltage); }
        if ($request->filled('f8_condition'))     { $q8->where('battery_condition', $request->f8_condition); }
        if ($request->filled('f8_rag'))           { $q8->where('rag_status', $request->f8_rag); }
        if ($request->filled('f8_location'))      { $q8->where('battery_location', $request->f8_location); }
        if ($request->filled('f8_damage_reason')) { $q8->where('damage_reason', 'like', '%'.$request->f8_damage_reason.'%'); }
        if ($request->filled('f8_brand'))         { $q8->where('battery_brand', $request->f8_brand); }
        if ($request->filled('f8_vendor'))        { $q8->where('vendor_id', $request->f8_vendor); }
        if ($request->filled('f8_serial'))        { $q8->where('battery_serial', 'like', '%'.$request->f8_serial.'%'); }
        if ($request->filled('f8_vehicle'))       { $q8->whereHas('ytdLastVehicle.basicinfo', fn($q) => $q->where('vehicle_number', 'like', '%'.$request->f8_vehicle.'%')); }
        $ytd_batteries = $q8->paginate(15, ['*'], 'tab8_page');

        // ── Filter dropdown data ──────────────────────────────────────────
        $batteryBrands   = \App\Models\Battery::where('organisation_id', $org_id)
                           ->whereNotNull('battery_brand')->distinct()->orderBy('battery_brand')
                           ->pluck('battery_brand');
        $batteryCapacities = \App\Models\Battery::where('organisation_id', $org_id)
                           ->whereNotNull('battery_capacity')->distinct()->orderBy('battery_capacity')
                           ->pluck('battery_capacity');
        $batteryVoltages = \App\Models\Battery::where('organisation_id', $org_id)
                           ->whereNotNull('battery_voltage')->distinct()->orderBy('battery_voltage')
                           ->pluck('battery_voltage');
        $batteryVendors  = \App\Models\Contact::where('cotype_id', 7)->where('status', 'Active')
                           ->orderBy('contact_name')->get(['id', 'contact_name']);
        $vehicleGroups   = \App\Models\Vehiclegroup::orderBy('name')->get(['id', 'name']);

        $active_tab = $request->input('active_tab', 'tab-all');

        return view('inventory.battery-dashboard', compact(
            'all_count', 'allocated_count', 'direct_fitment_count', 'yet_to_decide_count',
            'ready_to_use_count', 'warranty_claim_count', 'repair_count', 'scrap_count',
            'all_batteries', 'ready_batteries', 'warranty_batteries', 'repair_batteries',
            'scrap_batteries', 'allocated_batteries', 'direct_fitment_batteries', 'ytd_batteries',
            'batteryBrands', 'batteryCapacities', 'batteryVoltages', 'batteryVendors', 'vehicleGroups',
            'sort', 'direction', 'active_tab'
        ));
    }

    public function createBattery()
    {
        $batteryvendors = \App\Models\Contact::where('cotype_id', 7)->where('status', 'Active')->get();

        $warehouses = \App\Models\Warehouse::where('status', 'Active')
            ->orderBy('warehouse_type')
            ->orderBy('name')
            ->get(['id', 'name', 'warehouse_type']);

        $workshops = \App\Models\Workshop::active()
            ->orderBy('ownership')
            ->orderBy('name')
            ->get(['id', 'name', 'workshop_code', 'ownership']);

        return view('inventory.battery-add', compact('batteryvendors', 'warehouses', 'workshops'));
    }

    public function storeBattery(Request $request)
    {
        // ── Validation rules ──────────────────────────────────────────────
        $rules = [
            'battery_source_mode'  => 'required|in:Existing,New PO,Fitment',
            'battery_serial'       => 'required|string|max:100',
            'battery_brand'        => 'required|string|max:100',
            'battery_model'        => 'nullable|string|max:100',
            'battery_capacity'     => 'required|numeric|min:0.1',
            'battery_voltage'      => 'required|string|max:10',
            'battery_condition'    => 'required|in:New,Used,Replaced Under Warranty',

            // Purchase
            'vendor_id'                  => 'nullable|integer|exists:contacts,id',
            'battery_invoice_ref'        => 'nullable|string|max:100',
            'battery_purchase_cost'      => 'nullable|numeric|min:0',
            'battery_purchase_date'      => 'nullable|date',
            'battery_warranty_months'    => 'nullable|integer|min:0|max:120',
            'invoice_file'               => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:10240',
            'fitment_invoice_file'       => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:10240',

            // Lifecycle
            'battery_issue_date'         => 'nullable|date',
            'battery_fixed_life_months'  => 'nullable|integer|min:1|max:600',
            'battery_actual_usage_months'=> 'nullable|integer|min:0',

            // Maintenance
            'last_voltage_check_date'    => 'nullable|date',
            'last_charging_check_date'   => 'nullable|date',
            'battery_health_pct'         => 'nullable|integer|min:0|max:100',
            'next_inspection_due_date'   => 'nullable|date',

            // Location & notes
            'stock_location'             => 'nullable|string|max:50',
            'battery_notes'              => 'nullable|string|max:2000',

            // Attachments (Dropzone)
            'files'                      => 'nullable|array|max:4',
            'files.*'                    => 'file|mimes:pdf,jpg,jpeg,png,webp|max:3072',
        ];

        // Source-mode conditional rules
        $mode = $request->input('battery_source_mode');
        if ($mode === 'Existing') {
            $rules['source_origin_note'] = 'required|string|max:500';
        } elseif ($mode === 'New PO') {
            $rules['purchase_order_reference'] = 'required|string|max:100';
        } elseif ($mode === 'Fitment') {
            $rules['fitment_source_origin_note'] = 'required|string|max:500';
        }

        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ], 422);
        }

        // ── Stock location parsing ────────────────────────────────────────
        $stockLocation = $request->input('stock_location', '');
        $warehouseId   = null;
        $workshopId    = null;
        $locationName  = 'Unassigned';
        $locationType  = 'Unassigned';

        if ($stockLocation === 'fitment') {
            $locationType = 'Fitment';
            $locationName = 'Fitment';
        } elseif (preg_match('/^(wh|ws):(\d+)$/', $stockLocation, $m)) {
            if ($m[1] === 'wh') {
                $warehouseId  = (int) $m[2];
                $locationType = 'Warehouse';
            } else {
                $workshopId   = (int) $m[2];
                $locationType = 'Workshop';
            }
        }

        // ── Warranty expiry auto-calc ─────────────────────────────────────
        $warrantyMonths = (int) $request->input('battery_warranty_months', 0);
        $warrantyExpiry = null;
        if ($warrantyMonths > 0 && $request->input('battery_purchase_date')) {
            $warrantyExpiry = date(
                'Y-m-d',
                strtotime('+' . $warrantyMonths . ' months', strtotime($request->input('battery_purchase_date')))
            );
        }

        // ── End-of-life auto-calc ─────────────────────────────────────────
        $fixedLifeMonths = $request->input('battery_fixed_life_months');
        $endOfLife       = null;
        if ($fixedLifeMonths && $request->input('battery_issue_date')) {
            $endOfLife = date(
                'Y-m-d',
                strtotime('+' . $fixedLifeMonths . ' months', strtotime($request->input('battery_issue_date')))
            );
        }

        // ── Organisation ──────────────────────────────────────────────────
        $orgId     = auth()->user()->organisation_id ?? 1;
        $userId    = auth()->id();

        try {
            $battery = \Illuminate\Support\Facades\DB::transaction(function () use (
                $request, $mode, $warrantyMonths, $warrantyExpiry, $endOfLife,
                $warehouseId, $workshopId, $locationType, $orgId, $userId
            ) {
                // ── Create Battery record ──────────────────────────────────
                $battery = \App\Models\Battery::create([
                    'organisation_id'             => $orgId,
                    'battery_source_mode'         => $mode,
                    'source_origin_note'          => $request->input('source_origin_note'),
                    'fitment_source_origin_note'  => $request->input('fitment_source_origin_note'),
                    'purchase_order_reference'    => $request->input('purchase_order_reference'),

                    'battery_serial'              => $request->input('battery_serial'),
                    'battery_brand'               => $request->input('battery_brand'),
                    'battery_model'               => $request->input('battery_model'),
                    'battery_capacity'            => $request->input('battery_capacity'),
                    'battery_voltage'             => $request->input('battery_voltage'),
                    'battery_condition'           => $request->input('battery_condition'),

                    'vendor_id'                   => $request->input('vendor_id') ?: null,
                    'battery_invoice_ref'         => $request->input('battery_invoice_ref'),
                    'battery_purchase_cost'       => $request->input('battery_purchase_cost') ?: null,
                    'battery_purchase_date'       => $request->input('battery_purchase_date') ?: null,
                    'battery_warranty_months'     => $warrantyMonths,
                    'battery_warranty_expiry_date'=> $warrantyExpiry,

                    'battery_issue_date'          => $request->input('battery_issue_date') ?: null,
                    'battery_fixed_life_months'   => $request->input('battery_fixed_life_months') ?: null,
                    'battery_end_of_life_date'    => $endOfLife,
                    'battery_actual_usage_months' => $request->input('battery_actual_usage_months') ?: null,

                    'last_voltage_check_date'     => $request->input('last_voltage_check_date') ?: null,
                    'last_charging_check_date'    => $request->input('last_charging_check_date') ?: null,
                    'battery_health_pct'          => $request->input('battery_health_pct') ?: null,
                    'next_inspection_due_date'    => $request->input('next_inspection_due_date') ?: null,
                    'maintenance_reminder_enabled'=> $request->boolean('maintenance_reminder_enabled'),

                    'warehouse_id'                => $warehouseId,
                    'workshop_id'                 => $workshopId,
                    'stock_location_type'         => $locationType,
                    'current_status'              => 'In Stock',

                    'battery_notes'               => $request->input('battery_notes'),
                    'created_by'                  => $userId,
                    'updated_by'                  => $userId,
                ]);

                // ── Invoice file storage ───────────────────────────────────
                $invoiceFileKey = ($mode === 'Fitment') ? 'fitment_invoice_file' : 'invoice_file';
                if ($request->hasFile($invoiceFileKey) && $request->file($invoiceFileKey)->isValid()) {
                    $file     = $request->file($invoiceFileKey);
                    $invDir   = public_path('medias' . DIRECTORY_SEPARATOR . 'battery' . DIRECTORY_SEPARATOR . 'invoices');
                    if (! is_dir($invDir)) { @mkdir($invDir, 0775, true); }
                    $filename = time() . '_' . \Illuminate\Support\Str::random(10) . '.' . $file->getClientOriginalExtension();
                    $file->move($invDir, $filename);
                    $battery->update(['invoice_file_path' => 'battery/invoices/' . $filename]);
                }

                // ── Dropzone attachment images (medias table, type='Image') ──
                $mediaData = [];
                if ($request->hasFile('files')) {
                    $imgDir = public_path('medias' . DIRECTORY_SEPARATOR . 'battery');
                    if (! is_dir($imgDir)) { @mkdir($imgDir, 0775, true); }

                    foreach ($request->file('files') as $file) {
                        if (! $file->isValid()) { continue; }
                        $filename = time() . '_' . \Illuminate\Support\Str::random(10) . '.' . $file->getClientOriginalExtension();
                        $file_size = $file->getSize();
                        $file->move($imgDir, $filename);
                        $mediaData[] = [
                            'type'       => 'Image',
                            'file_name'  => $file->getClientOriginalName(),
                            'file_path'  => 'battery/' . $filename,
                            'file_type'  => $file->getClientMimeType(),
                            'file_size'  => $file_size,
                            'created_by' => $userId,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }
                }
                if (count($mediaData) > 0) {
                    $battery->medias()->createMany($mediaData);
                }

                // ── Initial battery log entry ─────────────────────────────
                \App\Models\Batterylog::create([
                    'battery_id'               => $battery->id,
                    'organisation_id'          => $orgId,
                    'action'                   => 'Added',
                    'battery_source_mode'      => $battery->battery_source_mode,
                    'battery_serial'           => $battery->battery_serial,
                    'battery_brand'            => $battery->battery_brand,
                    'battery_model'            => $battery->battery_model,
                    'battery_capacity'         => $battery->battery_capacity,
                    'battery_voltage'          => $battery->battery_voltage,
                    'battery_condition'        => $battery->battery_condition,
                    'vendor_id'                => $battery->vendor_id,
                    'battery_invoice_ref'      => $battery->battery_invoice_ref,
                    'battery_purchase_cost'    => $battery->battery_purchase_cost,
                    'battery_purchase_date'    => $battery->battery_purchase_date,
                    'battery_warranty_months'  => $battery->battery_warranty_months,
                    'battery_warranty_expiry_date' => $battery->battery_warranty_expiry_date,
                    'battery_issue_date'       => $battery->battery_issue_date,
                    'battery_fixed_life_months'=> $battery->battery_fixed_life_months,
                    'stock_location_type'      => $battery->stock_location_type,
                    'warehouse_id'             => $battery->warehouse_id,
                    'workshop_id'              => $battery->workshop_id,
                    'battery_status'           => $battery->current_status,
                    'log_notes'                => $battery->battery_notes,
                    'created_by'               => $userId,
                ]);

                return $battery;
            });

            return response()->json([
                'success'      => true,
                'message'      => 'Battery added to inventory successfully.',
                'redirect_url' => route('inventory.battery-dashboard'),
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save battery: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function batteryDetails($id)
    {
        $battery  = Battery::findOrFail($id);
        $comments = $battery->comments()->with('createdBy')->latest()->get();

        $today        = Carbon::today();
        $tenDaysLater = Carbon::today()->addDays(10);

        $attachmenttypes    = Attachmenttype::get();
        $mediaDocumentIds   = $battery->documents()->pluck('mediadocument_id')->toArray();
        $mediadocuments     = Mediadocument::whereIn('id', $mediaDocumentIds)->with('attachmenttype')->get();
        $total_doc_count    = $mediadocuments->count();
        $expired_doc_count  = $mediadocuments->where('expiry_date', '<', $today)->count();
        $expiring_doc_count = $mediadocuments->where('expiry_date', '>=', $today)->where('expiry_date', '<=', $tenDaysLater)->count();

        return view('inventory.battery-details', compact(
            'battery', 'comments',
            'attachmenttypes', 'mediadocuments',
            'total_doc_count', 'expired_doc_count', 'expiring_doc_count'
        ));
    }

    public function batteryStoreComment(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required|string|max:1000',
        ]);

        $battery = Battery::find($id);
        if (! $battery) {
            return response()->json(['success' => false, 'message' => 'Battery not found.'], 422);
        }

        try {
            DB::transaction(function () use ($request, $battery) {
                $battery->comments()->create([
                    'comment'    => $request->comment,
                    'created_by' => Auth::id(),
                ]);
            });

            return response()->json(['success' => true, 'message' => 'Comment added successfully.'], 200);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function batteryStoreDocument(Request $request, $id, MediaDocumentService $service)
    {
        $battery = Battery::find($id);
        if (! $battery) {
            return response()->json(['success' => false, 'message' => 'Battery not found.'], 422);
        }

        $request->merge([
            'issue_date'  => $request->issue_date
                ? \Carbon\Carbon::createFromFormat('d/m/Y', $request->issue_date)->format('Y-m-d')
                : null,
            'expiry_date' => $request->expiry_date
                ? \Carbon\Carbon::createFromFormat('d/m/Y', $request->expiry_date)->format('Y-m-d')
                : null,
        ]);

        $rules = [
            'files'           => 'required|array|min:1',
            'files.*'         => 'required|file|max:2048|mimes:jpg,jpeg,png,webp,pdf',
            'attachment_type' => 'required',
            'document_number' => 'required|string|max:100',
            'issue_date'      => 'nullable|date',
            'expiry_date'     => 'nullable|date|after:issue_date',
            'set_reminder'    => 'nullable',
            'reminder_days'   => 'required_if:set_reminder,1|nullable|integer|min:1',
            'notes'           => 'nullable|string|max:500',
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
            return response()->json(['data' => $errors, 'message' => 'Please fill with valid data.'], 422);
        }

        try {
            $document = $service->storeDocument($battery, $request->all());
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }

        return response()->json(['message' => 'Document uploaded successfully', 'data' => $document], 200);
    }

    public function batteryUpdateDocument(Request $request, Mediadocument $mediadocument, MediaDocumentService $service)
    {
        $request->merge([
            'issue_date'  => $request->issue_date
                ? \Carbon\Carbon::createFromFormat('d/m/Y', $request->issue_date)->format('Y-m-d')
                : null,
            'expiry_date' => $request->expiry_date
                ? \Carbon\Carbon::createFromFormat('d/m/Y', $request->expiry_date)->format('Y-m-d')
                : null,
        ]);

        $rules = [
            'files'           => 'nullable|array',
            'files.*'         => 'file|max:2048|mimes:jpg,jpeg,png,webp,pdf',
            'attachment_type' => 'required',
            'document_number' => 'required|string|max:100',
            'issue_date'      => 'required|date',
            'expiry_date'     => 'nullable|date|after:issue_date',
            'set_reminder'    => 'nullable',
            'reminder_days'   => 'required_if:set_reminder,1|nullable|integer|min:1',
            'notes'           => 'nullable|string|max:500',
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
            return response()->json(['data' => $errors, 'message' => 'Please fill with valid data.'], 422);
        }

        try {
            $battery  = $mediadocument->medias()->first()?->mediable;
            $document = $service->updateDocument($battery, $mediadocument, $request->all());
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }

        return response()->json(['message' => 'Document updated successfully', 'data' => $document], 200);
    }

    public function batteryDestroyDocument(Media $media)
    {
        $mediadocument = $media->mediadocument;
        if ($mediadocument->medias()->count() < 2) {
            return response()->json(['message' => 'You cannot delete this as at least one document must remain.'], 422);
        }

        try {
            DB::transaction(function () use ($media) {
                $media->delete();
            });
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }

        return response()->json(['message' => 'Document file deleted successfully.'], 200);
    }

    public function batteryFit($id)
    {
        return view('inventory.battery-fit', compact('id'));
    }

    public function batteryReplace($id)
    {
        return view('inventory.battery-replace', compact('id'));
    }

    public function batteryChangeStatus(\Illuminate\Http\Request $request, $id)
    {
        $request->validate([
            'new_status' => 'required|in:Warranty Claim,Repair,Scrap',
        ]);

        $battery = \App\Models\Battery::find($id);
        if (! $battery) {
            return response()->json(['success' => false, 'message' => 'Battery not found.'], 422);
        }

        if ($battery->battery_status !== 'Yet to Decide') {
            return response()->json(['success' => false, 'message' => 'Only Yet to Decide batteries can be moved.'], 422);
        }

        try {
            $result = \Illuminate\Support\Facades\DB::transaction(function () use ($battery, $request) {
                $battery->battery_status = $request->new_status;
                $battery->updated_by     = auth()->id();
                $battery->save();
                return $battery;
            });

            return response()->json([
                'success' => true,
                'message' => 'Battery moved to ' . $request->new_status . '.',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update status: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function batteryAction()
    {
        return view('inventory.battery-action');
    }

    public function poList()
    {
        return view('ws.po-list');
    }

    public function poDetail($id)
    {
        return view('ws.po-detail', compact('id'));
    }

    public function grn()
    {
        return view('ws.grn');
    }

    public function grnDetail($id)
    {
        return view('ws.grn-detail', compact('id'));
    }

    public function stockTransfer()
    {
        return view('ws.stock-transfer');
    }
}
