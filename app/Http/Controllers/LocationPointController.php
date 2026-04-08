<?php
  
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use App\Models\Rto;
use App\Models\State;
use App\Models\City;
use App\Models\Customerlocation;
use App\Models\Loadvendorlocation;


use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Hash;
use Auth;
use Illuminate\Support\Arr;

use Illuminate\View\View;
use Illuminate\Pagination\LengthAwarePaginator;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;
use Closure;
use Illuminate\Support\Fluent;
use Illuminate\Database\Eloquent\Builder;

use App\Traits\Useractivity;


class LocationPointController extends Controller
{
    use Useractivity;
    
    public function index(Request $request): View
    {
        
        // ================= SEARCH PARAMETERS =================
        $search_location = $request->get('location');
        $search_location_type = $request->get('locationtype');
        $search_contact_type = $request->get('contacttype');
        $search_city = $request->get('city_id');
        
        $perPage = 10;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
    
        
        // ================= STATES & CITIES =================
        $states = State::whereHas('country', function ($q) {
                            $q->where('iso2', 'IN');
                        })
                        ->orderBy('name')
                        ->get();
        
        $cities = City::whereHas('state.country', function ($q) {
                            $q->where('iso2', 'IN');
                        })
                        ->orderBy('name')
                        ->get();
                        
                        
                        
        // ================= CUSTOMER LOCATIONS =================
        $customerLocations = Customerlocation::with([
                                'sourceCity.state',
                                'destinationCity.state',
                                'midpointCity.state'
                            ])
                            ->when($search_location, fn($q) =>
                                $q->where('location_name', 'like', "%$search_location%"))
                            ->when($search_location_type, fn($q) =>
                                $q->where('location_type', $search_location_type))
                            ->get()
                            ->map(function ($item) {
                    
                                $city = $item->sourceCity 
                                    ?? $item->destinationCity 
                                    ?? $item->midpointCity;
                    
                                return [
                                    'id'        => $item->id,
                                    'location'  => $item->location_name,
                                    'location_type' => $item->location_type,
                                    'onsite_contact_person' => $item->onsite_contact_person,
                                    'phone'     => $item->onsite_contact_person_phone,
                                    'whatsapp'  => $item->onsite_contact_person_whatsapp,
                                    'contact_type' => 'Customer',
                                    'city_id'   => optional($city)->id,
                                    'city_name' => optional($city)->name,
                                    'state_name'=> optional(optional($city)->state)->name,
                                ];
                            });
            
            
        // ================= LOAD VENDOR LOCATIONS =================
        $vendorLocations = Loadvendorlocation::with([
                                'sourceCity.state',
                                'destinationCity.state',
                                'midpointCity.state'
                            ])
                            ->when($search_location, fn($q) =>
                                $q->where('location_name', 'like', "%$search_location%"))
                            ->when($search_location_type, fn($q) =>
                                $q->where('location_type', $search_location_type))
                            ->get()
                            ->map(function ($item) {
                    
                                $city = $item->sourceCity 
                                    ?? $item->destinationCity 
                                    ?? $item->midpointCity;
                    
                                return [
                                    'id'        => $item->id,
                                    'location'  => $item->location_name,
                                    'location_type' => $item->location_type,
                                    'onsite_contact_person' => $item->onsite_contact_person,
                                    'phone'     => $item->onsite_contact_person_phone,
                                    'whatsapp'  => $item->onsite_contact_person_whatsapp,
                                    'contact_type' => 'Load Vendor',
                                    'city_id'   => optional($city)->id,
                                    'city_name' => optional($city)->name,
                                    'state_name'=> optional(optional($city)->state)->name,
                                ];
                            });
            
        // ================= MERGE =================
        $merged = $customerLocations->merge($vendorLocations);
    
        // ================= FILTER AFTER MERGE =================
        $filtered = $merged
            ->when($search_contact_type, fn($c) =>
                $c->where('contact_type', $search_contact_type))
            ->when($search_city, fn($c) =>
                $c->where('city_id', (int)$search_city))
            ->sortByDesc('id')
            ->values();
    
        // ================= PAGINATION =================
        $locations = new LengthAwarePaginator(
            $filtered->slice(($currentPage - 1) * $perPage, $perPage)->values(),
            $filtered->count(),
            $perPage,
            $currentPage,
            [
                'path' => $request->url(),
                'query' => $request->query()
            ]
        );
        
        // ================= RETURN VIEW =================
        return view('locationpoint.index', compact(
            'locations',
            'states',
            'cities',
            'search_location',
            'search_location_type',
            'search_contact_type',
            'search_city'
        ));
        
    }
    
    
    
    
}