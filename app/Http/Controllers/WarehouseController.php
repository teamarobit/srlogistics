<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use App\Http\Requests\WarehouseRequest;
use App\Models\Warehouse;
use App\Models\State;
use App\Models\City;
use App\Models\Contact;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WarehouseController extends Controller
{
    /**
     * LIST — Warehouse Master index page.
     */
    public function index(): View
    {
        $warehouses = Warehouse::with(['state', 'manager'])
            ->orderBy('warehouse_code')
            ->get();

        return view('warehouse.index', compact('warehouses'));
    }

    /**
     * CREATE — Show add form page.
     */
    public function create(): View
    {
        $states   = State::orderBy('name')->get(['id', 'name']);
        $managers = Contact::whereHas('cotype', fn($q) => $q->where('slug', 'employee'))
            ->where('status', 'Active')
            ->orderBy('contact_name')
            ->get(['id', 'contact_name']);

        return view('warehouse.create', compact('states', 'managers'));
    }

    /**
     * STORE — Save a new warehouse.
     * SD-3: Returns JSON (AJAX form submit).
     * SD-5: DB::transaction() with try-catch and return.
     * SD-6: Multiple tables (warehouses + cities) inside one transaction.
     * SD-9: Explicit HTTP status on every response.
     */
    public function store(WarehouseRequest $request): JsonResponse
    {
        try {
            DB::transaction(function () use ($request): Warehouse {
                $this->resolveCity($request->state_id, $request->city_name);

                $data                   = $request->validated();
                $data['warehouse_code'] = Warehouse::nextCode();
                $data['created_by']     = Auth::id();

                return Warehouse::create($data);
            });

            return response()->json([
                'success'  => true,
                'message'  => 'Warehouse saved successfully.',
                'redirect' => route('warehouse.master.index'),
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save warehouse: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * EDIT — Show edit form page.
     * findOrFail() is correct here — this is a non-AJAX View method.
     */
    public function edit(int $warehouse): View
    {
        $wh = Warehouse::with('state')->findOrFail($warehouse);

        $states   = State::orderBy('name')->get(['id', 'name']);
        $managers = Contact::whereHas('cotype', fn($q) => $q->where('slug', 'employee'))
            ->where('status', 'Active')
            ->orderBy('contact_name')
            ->get(['id', 'contact_name']);

        $cities = $wh->state_id
            ? City::where('state_id', $wh->state_id)->orderBy('name')->get(['id', 'name'])
            : collect();

        return view('warehouse.edit', compact('wh', 'states', 'managers', 'cities'));
    }

    /**
     * UPDATE — Save edits to an existing warehouse.
     * SD-3: Returns JSON (AJAX form submit).
     * SD-5: DB::transaction() with try-catch and return.
     * SD-6: Multiple tables (warehouses + cities) inside one transaction.
     * SD-8: No findOrFail() — use find() + manual 422 for the AJAX lookup.
     * SD-9: Explicit HTTP status on every response.
     */
    public function update(WarehouseRequest $request, int $warehouse): JsonResponse
    {
        try {
            $wh = Warehouse::find($warehouse);
            if (! $wh) {
                return response()->json([
                    'success' => false,
                    'message' => 'Warehouse not found.',
                ], 422);
            }

            DB::transaction(function () use ($request, $wh): Warehouse {
                $this->resolveCity($request->state_id, $request->city_name);

                $data               = $request->validated();
                $data['updated_by'] = Auth::id();

                $wh->update($data);
                return $wh;
            });

            return response()->json([
                'success'  => true,
                'message'  => 'Warehouse updated successfully.',
                'redirect' => route('warehouse.master.index'),
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update warehouse: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * DESTROY — Soft-delete a warehouse (AJAX).
     * SD-8: No findOrFail() — use find() + manual 422.
     * SD-9: Explicit HTTP status on every response.
     */
    public function destroy(int $warehouse): JsonResponse
    {
        try {
            $wh = Warehouse::find($warehouse);
            if (! $wh) {
                return response()->json([
                    'success' => false,
                    'message' => 'Warehouse not found.',
                ], 422);
            }

            $wh->deleted_by = Auth::id();
            $wh->save();
            $wh->delete();

            return response()->json([
                'success' => true,
                'message' => 'Warehouse deleted successfully.',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete warehouse: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * AJAX — Return cities for a given state_id.
     * SD-9: Explicit HTTP status code.
     */
    public function getCitiesByState(int $stateId): JsonResponse
    {
        $cities = City::where('state_id', $stateId)
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json($cities, 200);
    }

    // ─── Private Helpers ──────────────────────────────────────────────────────

    /**
     * Auto-create city if it doesn't exist for this state.
     * Called inside DB::transaction() — safe for multi-table writes.
     */
    private function resolveCity(int $stateId, string $cityName): void
    {
        $cityName = trim($cityName);
        if (! $cityName) {
            return;
        }

        City::firstOrCreate(
            ['state_id' => $stateId, 'name' => $cityName]
        );
    }
}
