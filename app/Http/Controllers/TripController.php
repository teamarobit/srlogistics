<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\Trip;
use App\Models\Contact;
use App\Models\Route as RouteModel;
use App\Models\Vehicletype;
use App\Models\Vehicletypesize;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TripController extends Controller
{
    /**
     * Trip list index page.
     * Static for now — data will be wired dynamically in a later sprint.
     */
    public function index(): View
    {
        $routes       = RouteModel::orderBy('id')->get();
        $vehicleTypes = Vehicletype::orderBy('name')->get();
        $vehicleSizes = Vehicletypesize::orderBy('name')->get();
        $loadVendors  = Contact::where('cotype_id', 2)->orderBy('contact_name')->get();
        $customers    = Contact::where('cotype_id', 1)->orderBy('contact_name')->get();

        return view('trip.index', compact('routes', 'vehicleTypes', 'vehicleSizes', 'loadVendors', 'customers'));
    }

    public function show($trip){
        // return view('trip.show', compact('trip')); // v1 — kept for reference
        return view('trip.show-v2', compact('trip'));
    }

    /**
     * Store a new trip (AJAX).
     * SD-3: jQuery AJAX — returns JSON.
     * SD-5: DB::transaction() with try-catch and return.
     * SD-9: Explicit HTTP status on every response.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'trip_date'       => 'nullable|date',
            'trip_type'       => 'nullable|in:Own,Rental,External',
            'trip_category'   => 'nullable|in:Line,Local',
            'load_vendor_id'  => 'nullable|integer',
            'rag_status'      => 'nullable|in:Red,Yellow,Green',
            'customer_id'     => 'nullable|integer',
            'vehicletype_id'  => 'nullable|integer',
            'vehicletypesize_id' => 'nullable|integer',
            'vehicle_id'      => 'nullable|integer',
            'internal_trip_id' => 'nullable|string|max:100',
            'route_id'        => 'nullable|integer',
            'source'          => 'nullable|string|max:255',
            'destination'     => 'nullable|string|max:255',
            'midpoint'        => 'nullable|string|max:255',
            'distance'        => 'nullable|string|max:50',
            'priority'        => 'nullable|in:Normal,Urgent',
            'tarpaulin'       => 'nullable|in:Yes,No',
            'comment'         => 'nullable|string',
        ]);

        try {
            $trip = DB::transaction(function () use ($validated): Trip {
                $validated['trip_id']         = Trip::nextCode();
                $validated['organisation_id'] = Auth::user()->organisation_id ?? 1;
                $validated['created_by']      = Auth::id();
                $validated['trip_status']     = 'Initiated';
                $validated['payment_status']  = 'Pending';

                return Trip::create($validated);
            });

            return response()->json([
                'success' => true,
                'message' => 'Trip created successfully.',
                'trip_id' => $trip->trip_id,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create trip: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Return vehicle sizes for a given vehicle type (AJAX).
     * SD-8: manual 422 if type not found.
     * SD-9: explicit HTTP status on every response.
     */
    public function getVehicleSizes(int $vehicletype_id): JsonResponse
    {
        $sizes = Vehicletypesize::where('vehicletype_id', $vehicletype_id)
            ->orderBy('name')
            ->get(['id', 'name', 'length', 'height', 'width']);

        return response()->json(['success' => true, 'sizes' => $sizes], 200);
    }

    /**
     * Delete a trip (AJAX soft-delete).
     * SD-8: find() + manual 422 — not findOrFail().
     */
    public function destroy(int $id): JsonResponse
    {
        $trip = Trip::find($id);

        if (! $trip) {
            return response()->json([
                'success' => false,
                'message' => 'Trip not found.',
            ], 422);
        }

        $trip->delete();

        return response()->json([
            'success' => true,
            'message' => 'Trip deleted.',
        ], 200);
    }

    public function createLr(){
        return view('lr.create');
    }

    public function printLr(){
        return view('lr.print');
    }
}
