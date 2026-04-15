<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Insuranceclaim;
use App\Models\Insuranceclaimfollowup;
use App\Models\Vehicle;
use App\Models\Vehiclebasicinfo;
use App\Models\Workshop;
use App\Models\SparePart;
use App\Models\WsSparePartCategory;
use Illuminate\Support\Facades\Auth;

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
        $query = Workshop::whereNull('deleted_at')->orderBy('workshop_code');

        if ($ownership = $request->ownership) {
            $query->where('ownership', $ownership);
        }

        $workshops = $query->get();

        $ownCount      = Workshop::whereNull('deleted_at')->where('ownership', 'Own')->count();
        $externalCount = Workshop::whereNull('deleted_at')->where('ownership', 'External')->count();

        return view('ws.master-workshops', compact('workshops', 'ownCount', 'externalCount'));
    }

    public function masterWorkshopStore(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'ownership'     => 'required|in:Own,External',
            'workshop_type' => 'required|in:Workshop,Mobile Unit,Hybrid,Brand ASC,Third Party,Warranty,Multi-Brand',
            'brand'         => 'nullable|string|max:100',
            'city'          => 'nullable|string|max:100',
            'state'         => 'nullable|string|max:100',
            'contact_phone' => 'nullable|string|max:20',
        ]);

        $ws = Workshop::create([
            'workshop_code'    => Workshop::nextWorkshopCode($request->ownership, $request->city ?? 'GEN'),
            'name'             => $request->name,
            'ownership'        => $request->ownership,
            'workshop_type'    => $request->workshop_type,
            'brand'            => $request->brand,
            'city'             => $request->city,
            'state'            => $request->state,
            'address'          => $request->address,
            'pincode'          => $request->pincode,
            'manager_name'     => $request->manager_name,
            'contact_phone'    => $request->contact_phone,
            'contact_email'    => $request->contact_email,
            'technician_count' => $request->technician_count ?? 0,
            'notes'            => $request->notes,
            'status'           => 'Active',
            'created_by'       => auth()->id(),
        ]);

        return response()->json(['success' => true, 'workshop' => $ws, 'message' => $ws->name . ' added successfully.']);
    }

    public function masterWorkshopUpdate(Request $request, int $id)
    {
        $ws = Workshop::findOrFail($id);

        $request->validate([
            'name'          => 'required|string|max:255',
            'ownership'     => 'required|in:Own,External',
            'workshop_type' => 'required|in:Workshop,Mobile Unit,Hybrid,Brand ASC,Third Party,Warranty,Multi-Brand',
            'brand'         => 'nullable|string|max:100',
            'city'          => 'nullable|string|max:100',
            'state'         => 'nullable|string|max:100',
            'contact_phone' => 'nullable|string|max:20',
            'status'        => 'nullable|in:Active,Inactive',
        ]);

        $ws->update([
            'name'             => $request->name,
            'ownership'        => $request->ownership,
            'workshop_type'    => $request->workshop_type,
            'brand'            => $request->brand,
            'city'             => $request->city,
            'state'            => $request->state,
            'address'          => $request->address,
            'pincode'          => $request->pincode,
            'manager_name'     => $request->manager_name,
            'contact_phone'    => $request->contact_phone,
            'contact_email'    => $request->contact_email,
            'technician_count' => $request->technician_count ?? $ws->technician_count,
            'notes'            => $request->notes,
            'status'           => $request->status ?? $ws->status,
            'updated_by'       => auth()->id(),
        ]);

        return response()->json(['success' => true, 'workshop' => $ws->fresh(), 'message' => $ws->name . ' updated successfully.']);
    }

    public function masterWorkshopDestroy(int $id)
    {
        $ws = Workshop::findOrFail($id);
        $ws->delete(); // soft delete

        return response()->json(['success' => true, 'message' => $ws->name . ' removed from workshop master.']);
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

    public function batteryDashboard()
    {
        return view('inventory.battery-dashboard');
    }

    public function createBattery()
    {
        return view('inventory.battery-add');
    }

    public function batteryDetails($id)
    {
        return view('inventory.battery-details', compact('id'));
    }

    public function batteryFit($id)
    {
        return view('inventory.battery-fit', compact('id'));
    }

    public function batteryReplace($id)
    {
        return view('inventory.battery-replace', compact('id'));
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
