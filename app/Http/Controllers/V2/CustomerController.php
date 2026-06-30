<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Gsttreat;
use App\Models\Cotype;
use App\Models\Contact;
use App\Models\Contactrole;
use App\Models\Customerabouttype;
use App\Models\Coattachtype;
use App\Models\Coattachment;
use App\Models\Relcontact;
use App\Models\Cobilling;
use App\Models\Customerlocation;
use App\Models\Contracttype;
use App\Models\Customercontract;
use App\Models\Customercontractdetail;
use App\Models\Contractroute;
use App\Models\Vehicleallocation;
use App\Models\Contractpricing;
use App\Models\Contractpricinglocationpoint;
use App\Models\Contractpricingvehicle;
use App\Models\Contractpricinglog;
use App\Models\Contractpricinglocationpointlog;
use App\Models\Contractpricingvehiclelog;
use App\Models\Route;
use App\Models\Vehicletype;
use App\Models\Vehicle;
use App\Models\Contactactivity;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;
use Closure;
use Illuminate\View\View;

use App\Traits\Useractivity;

/**
 * Customer Module V2 — Controller (Gate 2: live backend wiring)
 *
 * Ports the live V1 logic from App\Http\Controllers\ContactController into the
 * isolated V2 Customer module. Reuses the existing `contacts` tables via
 * Eloquent only — NO schema changes. The 12 public GET screen methods keep the
 * same view-data array-key shape the V2 blades already consume (Gate 1 dummy
 * shape) but populate every value from real Eloquent records.
 */
class CustomerController extends Controller
{
    use Useractivity;

    const CONTACT_TYPE_CUSTOMER = 1;

    /* ===============================================================
     | View-data helpers — map a Contact (cotype_id = 1) + its relations
     | onto the EXACT array shape the Gate-1 V2 blades consume.
     | =============================================================== */

    /**
     * Shape a single Contact model into the $c[...] array the blades read.
     */
    private function shapeCustomer(Contact $contact): array
    {
        return [
            'id'        => $contact->id,
            'contactno' => $contact->contactno,
            'name'      => $contact->contact_name,
            'type'      => optional($contact->abouttype)->name ?? '—',
            'size'      => $contact->size ?? '—',
            'phone'     => trim(($contact->ph_prefix ? $contact->ph_prefix . ' ' : '') . $contact->phone),
            'city'      => optional($contact->city)->name ?? '—',
            'locations' => $contact->customerlocations()->count(),
            'contracts' => $contact->customercontracts()->count(),
            'status'    => $contact->status ?? 'Active',
            'gst'       => $contact->gstin ?? '—',
            'email'     => $contact->email ?? '—',
        ];
    }

    /**
     * Per-tab counts for a given customer (real Eloquent counts).
     */
    private function tabCounts(Contact $contact): array
    {
        return [
            'contracts'  => $contact->customercontracts()->count(),
            'locations'  => $contact->customerlocations()->count(),
            'ratecharts' => Contractpricing::where('contact_id', $contact->id)->count(),
            'vehicles'   => Vehicleallocation::where('contact_id', $contact->id)->where('type', 'Customer')->count(),
            'documents'  => $contact->coattachments()->count(),
            'activity'   => $contact->activities()->count(),
        ];
    }

    /**
     * Resolve a customer Contact or abort with a 404 view (GET screens only).
     */
    private function findCustomerOrFail($id): Contact
    {
        return Contact::where('cotype_id', self::CONTACT_TYPE_CUSTOMER)->findOrFail($id);
    }

    /* ===============================================================
     | Screens (public GET) — real Eloquent, Gate-1 array-key shape
     | =============================================================== */

    public function dashboard()
    {
        $contacts  = Contact::where('cotype_id', self::CONTACT_TYPE_CUSTOMER)->orderBy('id', 'desc')->get();
        $customers = $contacts->map(fn ($c) => $this->shapeCustomer($c))->values()->all();

        $base = Contact::where('cotype_id', self::CONTACT_TYPE_CUSTOMER);

        $activeContractFilter = function ($q) {
            $q->whereNull('end_date')->orWhereDate('end_date', '>=', today());
        };

        $stats = [
            'total'       => (clone $base)->count(),
            'active'      => (clone $base)->where('status', 'Active')->count(),
            'inactive'    => (clone $base)->where('status', 'Inactive')->count(),
            'blacklisted' => (clone $base)->where('status', 'Blacklisted')->count(),
            'contracts'   => Customercontract::where($activeContractFilter)->count(),
            'vehicles'    => Vehicleallocation::where('type', 'Customer')
                                ->where($activeContractFilter)
                                ->count(),
        ];

        return view('V2.customer.dashboard', [
            'customers' => $customers,
            'stats'     => $stats,
        ]);
    }

    public function index(Request $request)
    {
        $search_name = $request->name;
        $search_city = $request->city;
        $search_size = $request->size;

        $query = Contact::where('cotype_id', self::CONTACT_TYPE_CUSTOMER)
                        ->with(['cotype', 'customerlocations', 'abouttype', 'city']);

        if ($request->filled('name')) {
            $query->where('contact_name', 'like', '%' . $request->name . '%');
        }
        if ($request->filled('city')) {
            $query->where('city_id', $request->city);
        }
        if ($request->filled('size')) {
            $query->where('size', $request->size);
        }

        $contacts = $query->orderBy('id', 'desc')->paginate(10)->withQueryString();

        // Map paginator items to the Gate-1 array shape while keeping the paginator
        // intact so the blade can still call ->links() / ->total() etc.
        $contacts->getCollection()->transform(fn ($c) => $this->shapeCustomer($c));

        // Distinct customer cities for the filter bar.
        $cities = City::whereHas('state.country', function ($q) {
                        $q->where('iso2', 'IN');
                    })->orderBy('name')->get();

        return view('V2.customer.index', [
            'customers'   => $contacts,   // paginator (items are shaped arrays)
            'cities'      => $cities,
            'search_name' => $search_name,
            'search_city' => $search_city,
            'search_size' => $search_size,
        ]);
    }

    public function create()
    {
        $customerabouttype = Customerabouttype::orderBy('name')->get();
        $countries         = Country::all();
        $states            = State::with(['cities' => fn ($q) => $q->orderBy('name')])
                                ->whereHas('country', fn ($q) => $q->where('iso2', 'IN'))
                                ->orderBy('name')->get();
        $cotypes           = Cotype::all();
        $cotype            = $cotypes->firstWhere('id', self::CONTACT_TYPE_CUSTOMER);
        $gsttreats         = Gsttreat::all();
        $coattachtypes     = Coattachtype::all();

        return view('V2.customer.create', compact(
            'customerabouttype', 'countries', 'states', 'cotype', 'cotypes', 'gsttreats', 'coattachtypes'
        ));
    }

    public function show($id)
    {
        $contact = $this->findCustomerOrFail($id);
        $c       = $this->shapeCustomer($contact);

        // Recent contracts + recent activities for the overview hub.
        $recentContracts = Customercontract::with('contracttype')
                                ->where('contact_id', $contact->id)
                                ->orderByDesc('created_at')
                                ->take(5)->get();

        $recentActivities = Contactactivity::with('createdBy')
                                ->where('contact_id', $contact->id)
                                ->orderByDesc('created_at')
                                ->take(5)->get();

        return view('V2.customer.show', [
            'c'                => $c,
            'counts'           => $this->tabCounts($contact),
            'active'           => 'overview',
            'recentContracts'  => $recentContracts,
            'recentActivities' => $recentActivities,
        ]);
    }

    public function edit($id)
    {
        $contact = Contact::with([
                        'country.states',
                        'state.cities',
                        'relcontacts' => fn ($q) => $q->orderBy('id', 'asc'),
                        'cobilling',
                        'cobilling.state.cities',
                        'cobilling.country.states',
                        'coattachments.coattachtype',
                        'abouttype',
                        'city',
                    ])
                    ->where('cotype_id', self::CONTACT_TYPE_CUSTOMER)
                    ->findOrFail($id);

        $c = $this->shapeCustomer($contact);

        $customerabouttype = Customerabouttype::orderBy('name')->get();
        $countries         = Country::all();
        $states            = State::whereHas('country', fn ($q) => $q->where('iso2', 'IN'))
                                ->orderBy('name')->get();
        $gsttreats         = Gsttreat::all();
        $coattachtypes     = Coattachtype::all();

        return view('V2.customer.edit', [
            'c'                 => $c,
            'contact'           => $contact,
            'counts'            => $this->tabCounts($contact),
            'active'            => 'edit',
            'customerabouttype' => $customerabouttype,
            'countries'         => $countries,
            'states'            => $states,
            'gsttreats'         => $gsttreats,
            'coattachtypes'     => $coattachtypes,
        ]);
    }

    /**
     * The union of route source/destination/midpoint cities across ALL of this
     * customer's contracts — used by the Location & Rate Chart city dropdowns.
     * Mirrors editCustomer() in ContactController.
     */
    private function routeCityLists(Contact $contact): array
    {
        $allRoutes = $contact->customercontracts
                        ->flatMap(fn ($contract) => $contract->routes)
                        ->unique('id')->values()
                        ->map(fn ($route) => $route->load([
                            'sourceState', 'sourceCity', 'destinationState',
                            'destinationCity', 'midpoints', 'midpoints.city',
                        ]));

        $routeMidpoints = $allRoutes->flatMap(fn ($r) => $r->midpoints)->unique('id')->values();

        return [
            'routeSourceCities'   => $allRoutes->pluck('sourceCity')->filter()->unique('id')->values(),
            'routeDestCities'     => $allRoutes->pluck('destinationCity')->filter()->unique('id')->values(),
            'routeMidpointCities' => $routeMidpoints->pluck('city')->filter()->unique('id')->values(),
        ];
    }

    public function contracts($id)
    {
        $contact = $this->findCustomerOrFail($id);
        $c       = $this->shapeCustomer($contact);

        $contracts = Customercontract::with(['contracttype', 'detail', 'routes'])
                        ->where('contact_id', $contact->id)
                        ->orderByDesc('created_at')->get();

        return view('V2.customer.contracts', [
            'c'         => $c,
            'counts'    => $this->tabCounts($contact),
            'active'    => 'contracts',
            'contracts' => $contracts,
        ]);
    }

    public function contractForm($id)
    {
        $contact = $this->findCustomerOrFail($id);
        $c       = $this->shapeCustomer($contact);

        $contracttypes = Contracttype::orderBy('id')->get();
        $routes        = Route::where('status', 'Active')->orderBy('name')->get();

        return view('V2.customer.contract-form', [
            'c'             => $c,
            'counts'        => $this->tabCounts($contact),
            'active'        => 'contracts',
            'contracttypes' => $contracttypes,
            'routes'        => $routes,
        ]);
    }

    public function locations($id)
    {
        $contact = $this->findCustomerOrFail($id);
        $c       = $this->shapeCustomer($contact);

        $locations = Customerlocation::with(['sourceCity', 'destinationCity', 'midpointCity'])
                        ->where('contact_id', $contact->id)->latest()->get();

        return view('V2.customer.locations', array_merge([
            'c'         => $c,
            'counts'    => $this->tabCounts($contact),
            'active'    => 'locations',
            'locations' => $locations,
        ], $this->routeCityLists($contact)));
    }

    public function rateChart($id)
    {
        $contact = $this->findCustomerOrFail($id);
        $c       = $this->shapeCustomer($contact);

        $contracts = Customercontract::with(['contracttype', 'routes'])
                        ->where('contact_id', $contact->id)
                        ->orderByDesc('created_at')->get();

        $contractPricings = Contractpricing::with([
                                'customerContract',
                                'contractroute.route',
                                'locationPoints.location',
                                'vehicles.vehicleType',
                                'vehicles.vehicleTypeSize',
                            ])->where('contact_id', $contact->id)
                              ->latest()->get()
                              ->groupBy('customercontract_id');

        $vehicletypes        = Vehicletype::with(['sizes' => fn ($q) => $q->orderBy('name')])
                                    ->where('status', 'Active')->orderBy('name')->get();
        $sourceLoadingPoints = Customerlocation::where('contact_id', $contact->id)
                                    ->where('route_type', 'Source')
                                    ->whereIn('location_type', ['Loading', 'Both'])->get();
        $destinationUnloadingPoints = Customerlocation::where('contact_id', $contact->id)
                                    ->where('route_type', 'Destination')
                                    ->whereIn('location_type', ['Unloading', 'Both'])->get();
        $midPoints = Customerlocation::where('contact_id', $contact->id)
                                    ->where('route_type', 'Midpoint')->get();

        return view('V2.customer.rate-chart', array_merge([
            'c'                          => $c,
            'counts'                     => $this->tabCounts($contact),
            'active'                     => 'ratechart',
            'contracts'                  => $contracts,
            'contractPricings'           => $contractPricings,
            'vehicletypes'               => $vehicletypes,
            'sourceLoadingPoints'        => $sourceLoadingPoints,
            'destinationUnloadingPoints' => $destinationUnloadingPoints,
            'midPoints'                  => $midPoints,
        ], $this->routeCityLists($contact)));
    }

    public function vehicles($id)
    {
        $contact = $this->findCustomerOrFail($id);
        $c       = $this->shapeCustomer($contact);

        $vehicleAllocations = Vehicleallocation::with(['vehicle', 'createdby'])
                                ->where('contact_id', $contact->id)
                                ->where('type', 'Customer')
                                ->orderByDesc('created_at')->get();

        $vehicles = Vehicle::where('status', 'Active')->orderBy('vehicle_no')->get();

        return view('V2.customer.vehicles', [
            'c'                  => $c,
            'counts'             => $this->tabCounts($contact),
            'active'             => 'vehicles',
            'vehicleAllocations' => $vehicleAllocations,
            'vehicles'           => $vehicles,
        ]);
    }

    public function documents($id)
    {
        $contact = $this->findCustomerOrFail($id);
        $c       = $this->shapeCustomer($contact);

        $coattachments = Coattachment::with('coattachtype')
                            ->where('contact_id', $contact->id)->latest()->get();
        $coattachtypes = Coattachtype::orderBy('name')->get();

        return view('V2.customer.documents', [
            'c'             => $c,
            'counts'        => $this->tabCounts($contact),
            'active'        => 'documents',
            'coattachments' => $coattachments,
            'coattachtypes' => $coattachtypes,
        ]);
    }

    public function activity($id)
    {
        $contact = $this->findCustomerOrFail($id);
        $c       = $this->shapeCustomer($contact);

        $activities = Contactactivity::with('createdBy')
                        ->where('contact_id', $contact->id)
                        ->orderByDesc('created_at')->get();

        return view('V2.customer.activity', [
            'c'          => $c,
            'counts'     => $this->tabCounts($contact),
            'active'     => 'activity',
            'activities' => $activities,
        ]);
    }

    /* ===============================================================
     | Customer create / update (← storeCustomer / updateCustomer)
     | =============================================================== */

    public function store(Request $request)
    {
        $request->merge([
            'phone'    => preg_replace('/\s+/', '', $request->phone),
            'whatsapp' => preg_replace('/\s+/', '', $request->whatsapp),
            'is_deduction_chargeable' => $request->is_deduction_chargeable == 1 ? 1 : 0,

            'contact_person_name'        => array_values($request->contact_person_name ?? []),
            'contact_person_phone'       => array_values($request->contact_person_phone ?? []),
            'contact_person_whatsapp'    => array_values($request->contact_person_whatsapp ?? []),
            'contact_person_email'       => array_values($request->contact_person_email ?? []),
            'contact_person_designation' => array_values($request->contact_person_designation ?? []),
            'contact_person_comment'     => array_values($request->contact_person_comment ?? []),
        ]);

        if ($request->has('contact_person_phone')) {
            $phones = $request->contact_person_phone;
            foreach ($phones as $k => $p) {
                $phones[$k] = preg_replace('/\s+/', '', $p);
            }
            $request->merge(['contact_person_phone' => $phones]);
        }

        if ($request->has('contact_person_whatsapp')) {
            $whatsapps = $request->contact_person_whatsapp;
            foreach ($whatsapps as $k => $w) {
                $whatsapps[$k] = preg_replace('/\s+/', '', $w);
            }
            $request->merge(['contact_person_whatsapp' => $whatsapps]);
        }

        $validate_phone = function ($attribute, $value, $fail) use ($request) {
            $code = $request->phone_code ?? getPhoneCode();
            if (Contact::where('phone', $value)->where('ph_prefix', $code)->exists()) {
                $fail('This phone number already exists.');
            }
        };

        $validate_whatsapp = function ($attribute, $value, $fail) use ($request) {
            if (!$value) return;
            $code = $request->whatsapp_code ?? getPhoneCode();
            if (Contact::where('whatsapp', $value)->where('whatsapp_prefix', $code)->exists()) {
                $fail('This whatsapp number already exists.');
            }
        };

        $validate_cp_phone = function (string $attribute, mixed $value, Closure $fail) use ($request) {
            $index = explode('.', $attribute)[1] ?? null;
            $code  = $request->get('contact_person_ph_code')[$index] ?? null;
        };

        $validator = Validator::make($request->all(), [
            'gst_number'          => ['required','max:100','regex:/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/', Rule::unique('contacts','gstin')->whereNull('deleted_at')],
            'contact_name'        => 'required|max:100',
            'about_type_id'       => 'required|exists:customerabouttypes,id',
            'size'                => 'nullable|in:Small,Medium,Large',
            'phone'               => ['required','digits:10',$validate_phone],
            'whatsapp'            => ['nullable','digits:10',$validate_phone],
            'email'               => 'nullable|email|unique:contacts,email',
            'address'             => 'nullable|max:100',
            'state_id'            => 'nullable|exists:states,id',
            'city_id'             => 'nullable|exists:cities,id',
            'post_code'           => 'nullable|digits:6',
            'head_office_map_location'=> 'nullable|string|max:255',
            'is_deduction_chargeable' => 'nullable|boolean',
            'halting_charges_per_day' => 'required_if:is_deduction_chargeable,1|nullable',
            'contact_comment'         => 'nullable|string|max:255',

            'contact_person_name'         => 'required|array|min:1',
            'contact_person_name.*'       => 'required|string|min:1',
            'contact_person_designation'  => 'nullable|array|min:1',
            'contact_person_designation.*'=> 'nullable|string|min:1',
            'contact_person_ph_code'      => 'nullable|array|min:1',
            'contact_person_phone'        => 'required|array|min:1',
            'contact_person_phone.*'      => ['required','digits:10',$validate_cp_phone],
            'contact_person_whatsapp'     => 'nullable|array|min:1',
            'contact_person_whatsapp.*'   => ['nullable','digits:10',$validate_whatsapp],
            'contact_person_email'        => 'nullable|array|min:1',
            'contact_person_email.*'      => 'nullable|email|unique:relcontacts,email',
            'contact_person_comment'      => 'nullable|array|min:1',
            'contact_person_comment.*'    => 'nullable|string|min:1',
        ], [
            'required'              => 'This field is required.',
            'gstin.required_if'     => 'This field is required.',
            'email.unique'          => 'This email has already been taken.',
            'gst_number.unique'     => 'This GST number is already registered.',
            'max'                   => 'Maximum 100 characters allowed.',
            'contact_comment.max'   => 'Maximum 255 characters allowed.',
            'exists'                => "This field's value is invalid.",
            'distinct'              => 'Duplicate value.',
            'email'                 => 'This email is invalid.',
            'gst_number.regex'      => 'Invalid GST format. Example: 27AAACT2727Q1ZW.',
            'halting_charges_per_day.required_if' => 'Please enter halting charges per day when halting charge is checked.',
            'phone.digits'                     => 'This field must contain 10 digits.',
            'whatsapp.digits'                  => 'This field must contain 10 digits.',
            'contact_person_phone.*.digits'    => 'This field must contain 10 digits.',
            'contact_person_whatsapp.*.digits' => 'This field must contain 10 digits.',
            'contact_name.required'            => 'This field is required.',
            'contact_name.max'                 => 'This cannot exceed 100 characters.',
        ]);

        $errorcount = 0;
        $errors = [];

        $cpPhones = $request->contact_person_phone ?? [];
        $cpNames  = $request->contact_person_name ?? [];
        $cpWhats  = $request->contact_person_whatsapp ?? [];

        $seenPhones = [];
        $seenNames  = [];
        $seenWhats  = [];

        foreach ($cpPhones as $key => $phone) {
            if (!$phone) continue;
            if (in_array($phone, $seenPhones)) {
                $errors["contact_person_phone.$key"][] = 'Duplicate phone number.';
                $errorcount++;
            } else { $seenPhones[] = $phone; }
        }
        foreach ($cpNames as $key => $name) {
            if (!$name) continue;
            if (in_array($name, $seenNames)) {
                $errors["contact_person_name.$key"][] = 'Duplicate name.';
                $errorcount++;
            } else { $seenNames[] = $name; }
        }
        foreach ($cpWhats as $key => $wa) {
            if (!$wa) continue;
            if (in_array($wa, $seenWhats)) {
                $errors["contact_person_whatsapp.$key"][] = 'Duplicate WhatsApp number.';
                $errorcount++;
            } else { $seenWhats[] = $wa; }
        }

        // Attachment validation (no previous attachments on ADD)
        $attachtype_ids = [];
        $attachtypes = $request->attachtypes ?? [];
        $filesInput  = $request->file('files') ?? [];
        $max = max(count($attachtypes), count($filesInput));

        for ($key = 0; $key < $max; $key++) {
            $attachtype = $attachtypes[$key] ?? null;
            $files      = $filesInput[$key] ?? null;

            if (empty($attachtype) && empty($files)) continue;

            if (!empty($files) && empty($attachtype)) {
                $errorcount++; $errors['coattachtype_'.$key] = ['Document type is required.']; continue;
            }
            if (!empty($attachtype) && empty($files)) {
                $errorcount++; $errors['coattachments_'.$key] = ['Please upload file.']; continue;
            }
            if (in_array($attachtype, $attachtype_ids)) {
                $errorcount++; $errors['coattachtype_'.$key] = ['You have already added this attachment type.']; continue;
            }
            $attachtype_ids[] = $attachtype;

            if (!empty($files)) {
                if (count($files) > 2) {
                    $errorcount++; $errors['coattachments_'.$key] = ['You cannot upload more than 2 files.'];
                }
                foreach ($files as $file) {
                    $extension = strtolower($file->getClientOriginalExtension());
                    $size      = $file->getSize();
                    if (!in_array($extension, ['jpg','jpeg','png','pdf'])) {
                        $errorcount++; $errors['coattachments_'.$key] = ['File type must be jpg, jpeg, png or pdf.'];
                    }
                    if ($size > 2097152) {
                        $errorcount++; $errors['coattachments_'.$key] = ['File size must not exceed 2MB.'];
                    }
                }
            }
        }

        $errormessages = $validator->errors()->toArray();
        foreach ($errors as $key => $value) {
            if (isset($errormessages[$key])) {
                $errormessages[$key] = array_merge($errormessages[$key], $value);
            } else {
                $errormessages[$key] = $value;
            }
        }

        if ($validator->fails() || $errorcount > 0) {
            return response()->json([
                'success' => false,
                'data' => $errormessages,
                'message' => 'Please check validation error.'
            ], 422);
        }

        try {
            $contact = DB::transaction(function () use ($request) {

                $lastcontact = Contact::withTrashed()->orderBy('id', 'DESC')->first();
                if ($lastcontact) {
                    $lastcontactno = (int) $lastcontact->contactno;
                    $incr_lastcontact = $lastcontactno + 1;
                    if (strlen($incr_lastcontact) < 5) {
                        $contactno = '0';
                        for ($i = 0; $i < (5 - strlen($incr_lastcontact)); $i++) {
                            $contactno .= '0';
                        }
                        $contactno .= $incr_lastcontact;
                    } else {
                        $contactno = $incr_lastcontact;
                    }
                } else {
                    $contactno = '000001';
                }

                $phoneCode = getPhoneCode();

                $contact  = new Contact;
                $contact->contactno       = $contactno;
                $contact->cotype_id       = self::CONTACT_TYPE_CUSTOMER;
                $contact->organisation_id = Auth::user()->organisation_id ?? 1;
                $contact->contact_name    = $request->get('contact_name');
                $contact->about_type_id   = $request->get('about_type_id');
                $contact->size            = $request->get('size');
                $contact->ph_prefix       = $request->phone_code ?? $phoneCode;
                $contact->phone           = $request->get('phone');
                $contact->whatsapp_prefix = $request->whatsapp_code ?? $phoneCode;
                $contact->whatsapp        = $request->get('whatsapp');
                $contact->email           = $request->get('email');
                $contact->address1        = $request->get('address');
                $contact->country_id      = $request->get('country');
                $contact->state_id        = $request->get('state_id');
                $contact->city_id         = $request->get('city_id');
                $contact->zipcode         = $request->get('post_code');
                $contact->head_office_map_location = $request->get('head_office_map_location');
                $contact->is_deduction_chargeable  = $request->get('is_deduction_chargeable') ?? 0;
                $contact->halting_charges_per_day  = $request->get('halting_charges_per_day') ?? 0;
                $contact->comment  = $request->get('contact_comment');
                $contact->gstin  = $request->get('gst_number');
                $contact->created_by = Auth::user()->id;
                $contact->save();

                // Contact Persons
                $names = $request->get('contact_person_name', []);
                for ($i = 0; $i < count($names); $i++) {
                    $name        = $names[$i] ?? null;
                    $designation = $request->contact_person_designation[$i] ?? null;
                    $ph_code     = $request->contact_person_ph_code[$i] ?? $phoneCode;
                    $phone       = $request->get('contact_person_phone')[$i] ?? null;
                    $whatsapp_code = $request->contact_person_whatsapp_code[$i] ?? $phoneCode;
                    $whatsapp    = $request->get('contact_person_whatsapp')[$i] ?? null;
                    $email       = $request->get('contact_person_email')[$i] ?? null;
                    $comment     = $request->get('contact_person_comment')[$i] ?? null;

                    if (empty($name) && empty($email) && empty($phone)) continue;

                    $relatedContact = new Relcontact;
                    $relatedContact->contact_id = $contact->id;
                    $relatedContact->name       = $name;
                    $relatedContact->position   = $designation;
                    $relatedContact->ph_prefix  = $ph_code ?? $phoneCode;
                    $relatedContact->phone      = $phone;
                    $relatedContact->whatsapp_prefix = $whatsapp_code ?? $phoneCode;
                    $relatedContact->whatsapp   = $whatsapp;
                    $relatedContact->email      = $email;
                    $relatedContact->comment    = $comment;
                    $relatedContact->created_by = Auth::user()->id;
                    $relatedContact->save();
                }

                // Billing Address
                if (
                    !empty($request->get('billing_state_id')) ||
                    !empty($request->get('billing_city_id')) ||
                    !empty($request->get('billing_postalcode')) ||
                    !empty($request->get('billing_address')) ||
                    !empty($request->get('billing_additionalinfo'))
                ) {
                    $billing_address = new Cobilling;
                    $billing_address->country_id = $request->get('billing_country');
                    $billing_address->state_id   = $request->get('billing_state_id');
                    $billing_address->city_id    = $request->get('billing_city_id');
                    $billing_address->address1   = $request->get('billing_address');
                    $billing_address->zipcode    = $request->get('billing_postalcode');
                    $billing_address->add_info   = $request->get('billing_additionalinfo');
                    $billing_address->contact_id = $contact->id;
                    $billing_address->created_by = Auth::user()->id;
                    $billing_address->save();
                }

                // Attachments
                $attachtypes = $request->attachtypes;
                if (!empty($attachtypes)) {
                    foreach ($attachtypes as $key => $attachtype) {
                        if (isset($request->file('files')[$key])) {
                            $files = $request->file('files')[$key];
                            foreach ($files as $file) {
                                $fileoriginalname = $file->getClientOriginalName();
                                $extension = $file->getClientOriginalExtension();
                                $filesize  = $file->getSize();

                                $filename = 'contact-attachment-'.Str::random(4).'_'.time().'.'.$extension;
                                $file->move(public_path('media'.DIRECTORY_SEPARATOR.'contact'.DIRECTORY_SEPARATOR), $filename);

                                $contact_attachment = new Coattachment;
                                $contact_attachment->name            = $filename;
                                $contact_attachment->original_name   = $fileoriginalname;
                                $contact_attachment->file_size       = ($filesize / (1024 * 1024));
                                $contact_attachment->coattachtype_id = $attachtype;
                                $contact_attachment->created_by      = Auth::id();
                                $contact_attachment->contact_id      = $contact->id;
                                $contact_attachment->save();
                            }
                        }
                    }
                }

                $description = 'Added new customer contact with ID ' . $contact->id;
                $this->storeUseractivity(1, 3, Auth::user()->id, $contact->id, $description);

                return $contact;
            });

            return response()->json([
                'success' => true,
                'data'    => $contact,
                'message' => 'Customer saved successfully.'
            ], 200);

        } catch (\Exception $exp) {
            return response()->json([
                'success' => false,
                'data'    => [],
                'message' => $exp->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $request->merge([
            'phone'    => preg_replace('/\s+/', '', $request->phone),
            'whatsapp' => preg_replace('/\s+/', '', $request->whatsapp),
        ]);

        if ($request->has('contact_person_phone')) {
            $phones = $request->contact_person_phone;
            foreach ($phones as $k => $p) { $phones[$k] = preg_replace('/\s+/', '', $p); }
            $request->merge(['contact_person_phone' => $phones]);
        }
        if ($request->has('contact_person_whatsapp')) {
            $whatsapps = $request->contact_person_whatsapp;
            foreach ($whatsapps as $k => $w) { $whatsapps[$k] = preg_replace('/\s+/', '', $w); }
            $request->merge(['contact_person_whatsapp' => $whatsapps]);
        }

        $validate_phone = function (string $attribute, mixed $value, Closure $fail) use ($id) {
            $code = getPhoneCode();
            if (Contact::where('phone', $value)->where('ph_prefix', $code)->where('id', '!=', $id)->exists()) {
                $fail('This phone number already exists.');
            }
        };

        $validate_cp_email = function (string $attribute, mixed $value, Closure $fail) use ($request) {
            $index = explode('.', $attribute)[1] ?? null;
            $email = $value;
            $person_id = $request->input("contact_person_id.$index");
            if ($email && $email !== null) {
                $query = Contact::where('email', $email);
                if ($person_id) { $query->where('id', '!=', $person_id); }
                if ($query->exists()) { $fail("The email $email is already taken."); }
            }
        };

        $validate_cp_phone = function (string $attribute, mixed $value, Closure $fail) {
            $code = getPhoneCode();
        };

        $contact = Contact::where('cotype_id', self::CONTACT_TYPE_CUSTOMER)->find($id);
        if (!$contact) {
            return response()->json([
                'success' => false,
                'data'    => [],
                'message' => 'Customer not found.'
            ], 422);
        }

        $validator = Validator::make($request->all(), [
            'gst_number'          => ['required','max:100','regex:/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/', Rule::unique('contacts','gstin')->ignore($id)->whereNull('deleted_at')],
            'contact_name'        => 'required|max:100',
            'about_type_id'       => 'required|exists:customerabouttypes,id',
            'size'                => 'nullable|in:Small,Medium,Large',
            'email'               => ['nullable','email', Rule::unique('contacts', 'email')->ignore($id)],
            'phone'               => ['required','digits:10',$validate_phone],
            'whatsapp'            => ['nullable','digits:10',$validate_phone],
            'address'             => 'nullable|max:100',
            'state_id'            => 'nullable|exists:states,id',
            'city_id'             => 'nullable|exists:cities,id',
            'post_code'           => 'nullable|digits:6',
            'head_office_map_location'=> 'nullable|string|max:255',
            'is_deduction_chargeable' => 'nullable|boolean',
            'halting_charges_per_day' => 'required_if:is_deduction_chargeable,1|nullable',
            'contact_comment'         => 'nullable|string|max:255',
            'status'                  => 'nullable|in:Active,Inactive,Blacklisted',
            'blacklist_reason'        => 'required_if:status,Blacklisted',

            'contact_person_name'         => 'required|array|min:1',
            'contact_person_name.*'       => 'required|string|distinct|min:1',
            'contact_person_designation'  => 'nullable|array|min:1',
            'contact_person_designation.*'=> 'nullable|string|min:1',
            'contact_person_ph_code'      => 'nullable|array|min:1',
            'contact_person_phone'        => 'required|array|min:1',
            'contact_person_phone.*'      => ['required','digits:10','distinct',$validate_cp_phone],
            'contact_person_whatsapp'     => 'nullable|array|min:1',
            'contact_person_whatsapp.*'   => ['nullable','digits:10','distinct',$validate_cp_phone],
            'contact_person_email'        => 'nullable|array|min:1',
            'contact_person_email.*'      => ['nullable','email','distinct',$validate_cp_email],
            'contact_person_comment'      => 'nullable|array|min:1',
            'contact_person_comment.*'    => 'nullable|string|distinct|min:1',
        ], [
            'required'              => 'This field is required.',
            'gstin.required_if'     => 'This field is required.',
            'email.unique'          => 'This email has already been taken.',
            'gst_number.unique'     => 'This GST number is already registered.',
            'max'                   => 'Maximum 100 characters allowed.',
            'contact_comment.max'   => 'Maximum 255 characters allowed.',
            'exists'                => "This field's value is invalid.",
            'distinct'              => 'Duplicate value.',
            'email'                 => 'This email is invalid.',
            'gst_number.regex'      => 'Invalid GST format. Example: 27AAACT2727Q1ZW.',
            'halting_charges_per_day.required_if' => 'Please enter halting charges per day when halting charge is checked.',
            'phone.digits'                     => 'This field must contain 10 digits.',
            'whatsapp.digits'                  => 'This field must contain 10 digits.',
            'contact_person_phone.*.digits'    => 'This field must contain 10 digits.',
            'contact_person_whatsapp.*.digits' => 'This field must contain 10 digits.',
            'contact_name.required'            => 'This field is required.',
            'contact_name.max'                 => 'This cannot exceed 100 characters.',
        ]);

        $errorcount = 0;
        $errors = [];

        $attachtype_ids = [];
        if (isset($contact)) {
            $attachtype_ids = $contact->coattachments->pluck('coattachtype_id')->toArray();
        }

        $attachtypes = $request->attachtypes ?? [];
        $filesInput  = $request->file('files') ?? [];

        $allKeys = array_unique(array_merge(array_keys($attachtypes), array_keys($filesInput)));

        foreach ($allKeys as $key) {
            $attachtype = $attachtypes[$key] ?? null;
            $files      = $filesInput[$key] ?? null;

            if (empty($attachtype) && empty($files)) continue;

            if (!empty($files) && empty($attachtype)) {
                $errorcount++; $errors['coattachtype_'.$key] = ['Document type is required.']; continue;
            }
            if (!empty($attachtype) && empty($files)) {
                $errorcount++; $errors['coattachments_'.$key] = ['Please upload file.']; continue;
            }
            if (!empty($attachtype_ids) && in_array($attachtype, $attachtype_ids, true)) {
                $errorcount++; $errors['coattachtype_'.$key] = ['You have already added this attachment type.']; continue;
            }
            $attachtype_ids[] = $attachtype;

            if (!empty($files)) {
                if (count($files) > 2) {
                    $errorcount++; $errors['coattachments_'.$key] = ['You cannot upload more than 2 files.'];
                }
                foreach ($files as $file) {
                    $extension = strtolower($file->getClientOriginalExtension());
                    $size      = $file->getSize();
                    if (!in_array($extension, ['jpg','jpeg','png','pdf'])) {
                        $errorcount++; $errors['coattachments_'.$key] = ['File type must be jpg, jpeg, png or pdf.'];
                    }
                    if ($size > 2097152) {
                        $errorcount++; $errors['coattachments_'.$key] = ['File size must not exceed 2MB.'];
                    }
                }
            }
        }

        $errormessages = array_merge($validator->getMessageBag()->toArray(), $errors);

        if ($validator->fails() || $errorcount > 0) {
            return response()->json(['success' => false, 'data' => $errormessages, 'message' => 'Please check validation error.'], 422);
        }

        try {
            $result = DB::transaction(function () use ($request, $contact) {

                $phoneCode = getPhoneCode();

                $contact->contact_name    = $request->contact_name;
                $contact->about_type_id   = $request->about_type_id;
                $contact->size            = $request->size;
                $contact->ph_prefix       = $phoneCode;
                $contact->phone           = $request->phone;
                $contact->whatsapp_prefix = $phoneCode;
                $contact->whatsapp        = $request->whatsapp;
                $contact->email           = $request->email;
                $contact->address1        = $request->address;
                $contact->country_id      = $request->country;
                $contact->state_id        = $request->state_id;
                $contact->city_id         = $request->city_id;
                $contact->zipcode         = $request->get('post_code');
                $contact->head_office_map_location = $request->head_office_map_location;
                $contact->is_deduction_chargeable  = $request->get('is_deduction_chargeable') ?? 0;
                $contact->halting_charges_per_day  = $contact->is_deduction_chargeable ? ($request->get('halting_charges_per_day') ?? 0) : 0;
                $contact->comment  = $request->contact_comment;
                $contact->gstin    = $request->gst_number;
                $contact->status   = $request->get('status') ?? 'Active';
                $contact->blacklist_reason = $request->get('blacklist_reason') ?? null;
                if ($request->get('status') === 'Blacklisted') {
                    $contact->blacklisted_at = now();
                } else {
                    $contact->blacklisted_at = null;
                }
                $contact->updated_by = Auth::user()->id;
                $contact->save();

                if ($request->get('status') === 'Blacklisted' && $request->filled('blacklist_reason')) {
                    $activity = new Contactactivity();
                    $activity->contact_id = $contact->id;
                    $activity->notes = $request->blacklist_reason;
                    $activity->is_blacklisted = 'Yes';
                    $activity->created_by = Auth::user()->id;
                    $activity->save();
                }

                // Update Relcontacts
                $relcontact_ids = [];
                foreach ($request->contact_person_name ?? [] as $i => $name) {
                    $rel = Relcontact::find($request->contact_person_id[$i] ?? 0);
                    if (!$rel) {
                        $rel = new Relcontact();
                        $rel->contact_id = $contact->id;
                    }
                    $rel->name      = $name;
                    $rel->position  = $request->contact_person_designation[$i] ?? null;
                    $rel->ph_prefix = $phoneCode;
                    $rel->phone     = $request->contact_person_phone[$i] ?? null;
                    $rel->whatsapp_prefix = $phoneCode;
                    $rel->whatsapp  = $request->contact_person_whatsapp[$i] ?? null;
                    $rel->email     = $request->contact_person_email[$i] ?? null;
                    $rel->comment   = $request->contact_person_comment[$i] ?? null;
                    $rel->save();
                    $relcontact_ids[] = $rel->id;
                }
                Relcontact::where('contact_id', $contact->id)->whereNotIn('id', $relcontact_ids)->delete();

                // Update Billing Addresses
                Cobilling::where('contact_id', $contact->id)->delete();
                if (
                    !empty($request->get('billing_state_id')) ||
                    !empty($request->get('billing_city_id')) ||
                    !empty($request->get('billing_postalcode')) ||
                    !empty($request->get('billing_address')) ||
                    !empty($request->get('billing_additionalinfo'))
                ) {
                    $billing_address = new Cobilling;
                    $billing_address->country_id = $request->billing_country;
                    $billing_address->state_id   = $request->billing_state_id;
                    $billing_address->city_id    = $request->billing_city_id;
                    $billing_address->address1   = $request->billing_address;
                    $billing_address->zipcode    = $request->billing_postalcode;
                    $billing_address->add_info   = $request->billing_additionalinfo;
                    $billing_address->contact_id = $contact->id;
                    $billing_address->created_by = Auth::user()->id;
                    $billing_address->save();
                }

                // Attachments
                $attachtypes = $request->attachtypes;
                if (!empty($attachtypes)) {
                    foreach ($attachtypes as $key => $attachtype) {
                        if (isset($request->file('files')[$key])) {
                            $files = $request->file('files')[$key];
                            foreach ($files as $file) {
                                $fileoriginalname = $file->getClientOriginalName();
                                $extension = $file->getClientOriginalExtension();
                                $filesize  = $file->getSize();
                                $filename = 'contact-attachment-'.Str::random(4).'_'.time().'.'.$extension;
                                $file->move(public_path('media'.DIRECTORY_SEPARATOR.'contact'.DIRECTORY_SEPARATOR), $filename);

                                $contact_attachment = new Coattachment;
                                $contact_attachment->name            = $filename;
                                $contact_attachment->original_name   = $fileoriginalname;
                                $contact_attachment->file_size       = ($filesize / (1024 * 1024));
                                $contact_attachment->coattachtype_id = $attachtype;
                                $contact_attachment->created_by      = Auth::id();
                                $contact_attachment->contact_id      = $contact->id;
                                $contact_attachment->save();
                            }
                        }
                    }
                }

                $this->storeUseractivity(1, 4, Auth::user()->id, $contact->id, 'Customer Updated [ID: ' . $contact->id . '].');

                return $contact;
            });

            return response()->json([
                'success' => true,
                'data'    => $result,
                'message' => 'Customer updated successfully.'
            ], 200);

        } catch (\Exception $exp) {
            return response()->json([
                'success' => false,
                'data'    => [],
                'message' => $exp->getMessage()
            ], 500);
        }
    }

    /* ===============================================================
     | Contact person wrapper (← customer_contactPersonWrapper)
     | Renders a V2 contact-person row partial (HTML).
     | =============================================================== */

    public function contactPersonWrapper(Request $request)
    {
        $rowindex = $request->get('rowindex');

        $html = view('V2.customer.partials.contact-person', compact('rowindex'))->render();

        return response()->json(['success' => true, 'data' => $html, 'message' => 'Customer contact person wrapper fetched'], 200);
    }

    /* ===============================================================
     | Customer Locations (← filter/store/delete/getLocationMidpoints)
     | =============================================================== */

    public function filterLocations(Request $request, $id)
    {
        $query = Customerlocation::with('sourceCity')->where('contact_id', $id);

        if ($request->location_type) {
            $query->where('location_type', $request->location_type);
        }

        $locations = $query->get();

        return view('V2.customer.partials.locations-list', compact('locations'))->render();
    }

    public function storeLocation(Request $request)
    {
        $contact = Contact::where('cotype_id', self::CONTACT_TYPE_CUSTOMER)->find($request->contact_id);
        if (!$contact) {
            return response()->json(['success' => false, 'data' => [], 'message' => 'Customer not found!'], 422);
        }

        $request->merge([
            'onsite_contact_person_phone'    => str_replace(' ', '', $request->onsite_contact_person_phone),
            'onsite_contact_person_whatsapp' => str_replace(' ', '', $request->onsite_contact_person_whatsapp),
        ]);

        $decimalRule = ['nullable', 'numeric', 'min:0', 'max:999999999999999.99999', 'regex:/^\d+(\.\d{1,5})?$/'];

        $validator = Validator::make($request->all(), [
            'company_name'        => 'required|max:100',
            'location_name'       => 'required|max:100',
            'location_type'       => 'required|in:Loading,Unloading,Both',
            'company_role'        => 'required|in:Consignor,Consignee',
            'route_type'          => 'required|in:source,destination,midpoint',
            'source_city_id'      => ['nullable','exists:cities,id',Rule::requiredIf($request->route_type === 'source')],
            'destination_city_id' => ['nullable','exists:cities,id',Rule::requiredIf($request->route_type === 'destination')],
            'midpoint_city_id'    => ['nullable','exists:cities,id',Rule::requiredIf($request->route_type === 'midpoint')],
            'loading_charge_type' => ['nullable', Rule::requiredIf(in_array($request->location_type, ['Loading', 'Both']))],
            'loading_charge'      => array_merge($decimalRule, [Rule::requiredIf(in_array($request->location_type, ['Loading', 'Both']))]),
            'unloading_charge_type' => ['nullable',Rule::requiredIf(in_array($request->location_type, ['Unloading', 'Both'])),],
            'unloading_charge'      => array_merge($decimalRule, [Rule::requiredIf(in_array($request->location_type, ['Unloading', 'Both'])),]),
            'address'             => 'required|max:100',
            'post_code'           => 'required|digits:6',
            'brone_by'            => 'nullable|in:customer,srl,mixed',
            'capping_amount'      => array_merge($decimalRule, [Rule::requiredIf($request->brone_by === 'mixed')]),
            'onsite_contact_person' => 'nullable|max:100',
            'onsite_contact_person_phone' => ['nullable','digits:10'],
            'onsite_contact_person_whatsapp' => ['nullable','digits:10'],
            'map_location'        => 'required|string|max:255',
            'additional_info'     => 'nullable|string|max:5000',
        ], [
            'required' => 'This field is required.',
            'max'      => 'Maximum 100 characters allowed.',
            'exists'   => "This field's value is invalid.",
            'digits'   => 'Invalid format.',
            'distinct' => 'Duplicate value.',
            'email'    => 'This email is invalid.',
            'source_city_id.required' => 'Source city is required when Route Type is Source.',
            'destination_city_id.required' => 'Destination city is required when Route Type is Destination.',
            'midpoint_city_id.required' => 'Midpoint city is required when Route Type is Midpoint.',
            'loading_charge.required_if' => 'Loading charge is required when location type is Loading or Both.',
            'unloading_charge.required_if' => 'Unloading charge is required when location type is Unloading or Both.',
            'capping_amount.required' => 'Capping amount is required when Charges Paid By is Mixed.',
            'onsite_contact_person_phone.digits' => 'Phone number must be exactly 10 digits.',
            'onsite_contact_person_whatsapp.digits' => 'WhatsApp number must be exactly 10 digits.',
            'post_code.digits' => 'Postal code must be exactly 6 digits.',
            'location_type.required' => 'Please select a Location Type.',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'data' => $validator->errors(), 'message' => 'Please check validation errors.'], 422);
        }

        // REG-03: Capping must not exceed the loading/unloading charge it caps.
        if ($request->brone_by === 'mixed' && is_numeric($request->capping_amount)) {
            $charges = [];
            if (in_array($request->location_type, ['Loading', 'Both']) && is_numeric($request->loading_charge)) {
                $charges[] = (float) $request->loading_charge;
            }
            if (in_array($request->location_type, ['Unloading', 'Both']) && is_numeric($request->unloading_charge)) {
                $charges[] = (float) $request->unloading_charge;
            }
            if (! empty($charges) && (float) $request->capping_amount > min($charges)) {
                return response()->json([
                    'success' => false,
                    'data'    => ['capping_amount' => ['Capping amount cannot be greater than loading or unloading charge.']],
                    'message' => 'Capping amount cannot be greater than loading or unloading charge.',
                ], 422);
            }
        }

        try {
            DB::transaction(function () use ($request, $contact) {

                $phoneCode = getPhoneCode();

                $contactlocation = new Customerlocation;
                $contactlocation->contact_id   = $request->contact_id;
                $contactlocation->company_name = $request->company_name;
                $contactlocation->company_role = $request->company_role;

                $types = ['source' => 'Source', 'destination' => 'Destination', 'midpoint' => 'Midpoint'];
                $contactlocation->route_type = $types[$request->route_type] ?? null;

                $contactlocation->source_city_id      = $request->source_city_id;
                $contactlocation->destination_city_id = $request->destination_city_id;
                $contactlocation->midpoint_city_id    = $request->midpoint_city_id;
                $contactlocation->location_name       = $request->location_name;
                $contactlocation->location_type       = $request->location_type;
                $contactlocation->loading_charge_type = in_array($request->location_type, ['Loading', 'Both']) ? $request->loading_charge_type : null;
                $contactlocation->loading_charge      = in_array($request->location_type, ['Loading', 'Both']) ? $request->loading_charge : 0;
                $contactlocation->unloading_charge_type = in_array($request->location_type, ['Unloading', 'Both']) ? $request->unloading_charge_type : null;
                $contactlocation->unloading_charge    = in_array($request->location_type, ['Unloading', 'Both']) ? $request->unloading_charge : 0;
                $contactlocation->address = $request->address;
                $contactlocation->zipcode = $request->post_code;

                $broneBy = ['customer' => 'Customer', 'srl' => 'SRL', 'mixed' => 'Mixed'];
                $contactlocation->charges_paid_by = $broneBy[$request->brone_by] ?? null;
                $contactlocation->capping_amount  = $request->capping_amount ?? 0;

                $contactlocation->onsite_contact_person = $request->onsite_contact_person;
                $contactlocation->onsite_contact_person_phone_code    = $request->onsite_contact_person_phone_code ?? $phoneCode;
                $contactlocation->onsite_contact_person_phone         = $request->onsite_contact_person_phone;
                $contactlocation->onsite_contact_person_whatsapp_code = $request->onsite_contact_person_whatsapp_code ?? $phoneCode;
                $contactlocation->onsite_contact_person_whatsapp      = $request->onsite_contact_person_whatsapp;
                $contactlocation->map_location    = $request->map_location;
                $contactlocation->additional_info = $request->additional_info;
                $contactlocation->created_by      = Auth::user()->id;
                $contactlocation->save();

                $this->storeUseractivity(45, 3, Auth::user()->id, $contact->id, 'Customer Updated [ID: ' . $contact->id . '].');
            });

            return response()->json(['success' => true, 'data' => $contact, 'message' => 'Customer location saved successfully.'], 200);

        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'data' => [], 'message' => $e->getMessage()], 500);
        }
    }

    public function deleteLocation(Request $request)
    {
        $location = Customerlocation::find($request->location_id);
        if (!$location) {
            return response()->json(['success' => false, 'message' => 'Location not found.'], 422);
        }

        try {
            DB::transaction(function () use ($request, $location) {
                $location->delete();
                $this->storeUseractivity(45, 6, Auth::user()->id, $request->location_id, 'Deleted a Customer location.');
                return $location;
            });

            return response()->json(['success' => true, 'message' => 'Customer location deleted successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function getLocationMidpoints(Request $request)
    {
        try {
            $contact_id = $request->contact_id;
            $type = $request->type;

            $midpoints = Customerlocation::where('route_type', 'Midpoint')
                            ->where('contact_id', $contact_id)
                            ->whereIn('location_type', [$type, 'Both'])
                            ->get();

            return response()->json([
                'success' => true,
                'message' => 'Midpoints fetched successfully.',
                'data'    => $midpoints
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Something went wrong while fetching midpoints.'], 500);
        }
    }

    /* ===============================================================
     | Customer Contracts (← store/edit/update/delete/getContractRoutes)
     | =============================================================== */

    public function storeContract(Request $request)
    {
        $request->merge([
            'total_allowed_kilometer' => str_replace(',', '', $request->total_allowed_kilometer),
            'monthly_total_price'     => str_replace(',', '', $request->monthly_total_price),
        ]);

        $validator = Validator::make($request->all(), [
            'contact_id'        => 'required|exists:contacts,id',
            'contract_no'       => 'required|string|max:100|unique:customercontracts,contract_no',
            'contract_type_id'  => 'required|exists:contracttypes,id',
            'advance_payment'   => 'required|numeric|min:0',
            'payment_within_day'=> 'required|integer|min:0',
            'remarks'           => 'nullable|string|max:255',
            'route_id'          => 'required|array|min:1',
            'route_id.*'        => 'required|exists:routes,id',
            'start_date'        => 'nullable|date|after_or_equal:today',
            'end_date'          => 'nullable|date|after_or_equal:start_date',
            'total_allowed_kilometer' => 'required_if:contract_type_id,1|numeric|min:0',
            'monthly_total_price'     => 'required_if:contract_type_id,1|decimal:0,2|min:0',
            'set_reminder' => 'nullable|in:Yes,No',
            'reminder_days_before_expiry' => 'nullable|integer|min:1',
        ], [
            'required' => 'This field is required.',
            'required_if' => 'This field is required for Monthly contracts.',
            'decimal' => 'The :attribute must have up to 2 decimal places.',
            'max'      => 'Maximum :max characters allowed.',
            'exists'   => "This field's value is invalid.",
            'date'     => 'Please enter a valid date.',
            'after_or_equal' => 'The :attribute must be after or equal to :date.',
            'integer'  => 'The :attribute must be a number.',
            'numeric'  => 'The :attribute must be a valid number.',
            'route_id.required' => 'Please select at least one route.',
            'route_id.array'    => 'Invalid route selection.',
            'route_id.min'      => 'Please select at least one route.',
            'route_id.*.exists' => 'One of the selected routes is invalid.',
        ]);

        $validator->sometimes(['start_date', 'end_date'], 'required|date', function ($input) {
            return ! in_array((int) $input->contract_type_id, [5, 6]);
        });
        $validator->sometimes('end_date', 'after_or_equal:start_date', function ($input) {
            return ! in_array((int) $input->contract_type_id, [5, 6]);
        });
        $validator->sometimes('reminder_days_before_expiry', 'required|integer|min:1', function ($input) {
            return isset($input->set_reminder) && $input->set_reminder === 'Yes';
        });

        if ($validator->fails()) {
            return response()->json(['success' => false, 'data' => $validator->errors(), 'message' => 'Please check validation errors.'], 422);
        }

        $contactId = $request->contact_id;

        if (! in_array((int) $request->contract_type_id, [5, 6])) {
            $start = $request->start_date;
            $end   = $request->end_date;

            $overlap = Customercontract::where('contact_id', $contactId)
                ->whereNotIn('contract_type_id', [5, 6])
                ->where(function ($query) use ($start, $end) {
                    $query->whereBetween('start_date', [$start, $end])
                          ->orWhereBetween('end_date', [$start, $end])
                          ->orWhere(function ($q) use ($start, $end) {
                              $q->where('start_date', '<=', $start)->where('end_date', '>=', $end);
                          });
                })->exists();

            if ($overlap) {
                return response()->json(['success' => false, 'data' => [], 'message' => 'There is already a contract that overlaps with the selected date range.'], 422);
            }
        }

        if ((int) $request->contract_type_id === 6) {
            $lifetimeExists = Customercontract::where('contact_id', $contactId)->where('contract_type_id', 6)->exists();
            if ($lifetimeExists) {
                return response()->json(['success' => false, 'data' => [], 'message' => 'A Lifetime contract already exists for this customer.'], 422);
            }
        }

        try {
            $contractdata = DB::transaction(function () use ($request) {

                $filename = null;
                if ($request->hasFile('upload_file') && $request->file('upload_file')->isValid()) {
                    $file = $request->file('upload_file');
                    $extension = $file->getClientOriginalExtension();
                    $filename = 'contract_' . time() . '_' . uniqid() . '.' . $extension;
                    $uploadPath = public_path('medias/customer-contract');
                    if (!File::exists($uploadPath)) {
                        File::makeDirectory($uploadPath, 0755, true);
                    }
                    $file->move($uploadPath, $filename);
                }

                $monthlyKm    = $request->filled('total_allowed_kilometer') ? str_replace(',', '', $request->total_allowed_kilometer) : 0;
                $monthlyPrice = $request->filled('monthly_total_price') ? str_replace(',', '', $request->monthly_total_price) : 0;

                $contract = new Customercontract();
                $contract->organisation_id                 = Auth::user()->organisation_id ?? 1;
                $contract->contact_id                      = $request->contact_id;
                $contract->contract_no                     = $request->contract_no ?? null;
                $contract->contract_type_id                = $request->contract_type_id;
                $contract->monthly_total_allowed_kilometer = $monthlyKm;
                $contract->monthly_total_price             = $monthlyPrice;
                $contract->advance_payment                 = $request->advance_payment ?? 0;
                $contract->payment_within_day              = $request->payment_within_day ?? 0;
                $contract->start_date                      = $request->start_date ?? null;
                $contract->end_date                        = $request->end_date ?? null;
                $contract->remarks                         = $request->remarks ?? null;
                $contract->created_by                      = Auth::user()->id;
                $contract->save();

                $detail = new Customercontractdetail;
                $detail->organisation_id      = Auth::user()->organisation_id ?? 1;
                $detail->customercontract_id  = $contract->id;
                $detail->contract_file        = $filename;
                $detail->contract_expiry_date = $request->end_date ?? null;
                $detail->set_reminder         = $request->set_reminder ?? 'No';
                $detail->reminder_days_before_expiry = $request->reminder_days_before_expiry ?? null;
                $detail->created_by = Auth::user()->id;
                $detail->save();

                if ($request->has('route_id')) {
                    foreach ($request->route_id as $routeId) {
                        $route = new Contractroute;
                        $route->customercontract_id = $contract->id;
                        $route->route_id = $routeId;
                        $route->save();
                    }
                }

                return $contract;
            });

            return response()->json(['success' => true, 'data' => $contractdata, 'message' => 'Customer contract data saved successfully.'], 200);

        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'data' => [], 'message' => $e->getMessage()], 500);
        }
    }

    public function editContract($id)
    {
        $contract = Customercontract::with(['contact', 'contracttype', 'detail', 'routes'])->findOrFail($id);

        $contact = $this->findCustomerOrFail($contract->contact_id);
        $c       = $this->shapeCustomer($contact);

        $contracttypes = Contracttype::orderBy('id')->get();
        $routes        = Route::where('status', 'Active')->orderBy('name')->get();

        $this->storeUseractivity(46, 5, Auth::id(), $contract->id, 'Edit contract ' . $contract->contract_no);

        return view('V2.customer.contract-edit-form', [
            'c'             => $c,
            'counts'        => $this->tabCounts($contact),
            'active'        => 'contracts',
            'contract'      => $contract,
            'contracttypes' => $contracttypes,
            'routes'        => $routes,
        ]);
    }

    public function updateContract(Request $request, $id)
    {
        $request->merge([
            'contract_id' => $id,
            'total_allowed_kilometer' => $request->filled('total_allowed_kilometer') ? str_replace(',', '', $request->total_allowed_kilometer) : null,
            'monthly_total_price'     => $request->filled('monthly_total_price') ? str_replace(',', '', $request->monthly_total_price) : null,
        ]);

        $validator = Validator::make($request->all(), [
            'contract_id'       => 'required|exists:customercontracts,id',
            'advance_payment'   => 'required|numeric|min:0',
            'payment_within_day'=> 'required|integer|min:0',
            'remarks'           => 'nullable|string|max:255',
            'route_id'          => 'required|array|min:1',
            'route_id.*'        => 'required|exists:routes,id',
            'total_allowed_kilometer' => 'required_if:contract_type_id,1|numeric|min:0',
            'monthly_total_price'     => 'required_if:contract_type_id,1|decimal:0,2|min:0',
            'set_reminder' => 'nullable|in:Yes,No',
            'reminder_days_before_expiry' => 'nullable|integer|min:1',
        ], [
            'required' => 'This field is required.',
            'required_if' => 'This field is required for Monthly contracts.',
            'decimal' => 'The :attribute must have up to 2 decimal places.',
            'max'      => 'Maximum :max characters allowed.',
            'exists'   => "This field's value is invalid.",
            'date'     => 'Please enter a valid date.',
            'after_or_equal' => 'The :attribute must be after or equal to :date.',
            'integer'  => 'The :attribute must be a number.',
            'numeric'  => 'The :attribute must be a valid number.',
            'route_id.required' => 'Please select at least one route.',
            'route_id.array'    => 'Invalid route selection.',
            'route_id.min'      => 'Please select at least one route.',
            'route_id.*.exists' => 'One of the selected routes is invalid.',
        ]);

        $validator->sometimes('reminder_days_before_expiry', 'required|integer|min:1', fn ($i) => $i->set_reminder === 'Yes');

        if ($validator->fails()) {
            return response()->json(['success' => false, 'data' => $validator->errors(), 'message' => 'Validation failed'], 422);
        }

        $overlap = false;
        if ($request->start_date && $request->end_date) {
            $overlap = Customercontract::where('contact_id', $request->contact_id)
                ->where('id', '!=', $request->contract_id)
                ->where(function ($q) use ($request) {
                    $q->whereBetween('start_date', [$request->start_date, $request->end_date])
                      ->orWhereBetween('end_date', [$request->start_date, $request->end_date])
                      ->orWhere(function ($qq) use ($request) {
                          $qq->where('start_date', '<=', $request->start_date)->where('end_date', '>=', $request->end_date);
                      });
                })->exists();
        }

        if ($overlap) {
            return response()->json(['success' => false, 'message' => 'Overlapping contract exists for this customer.'], 422);
        }

        try {
            $contract = DB::transaction(function () use ($request) {

                $contract = Customercontract::with('detail')->find($request->contract_id);
                if (! $contract) {
                    throw new \Exception('Contract not found.');
                }

                $filename = optional($contract->detail)->contract_file;

                if ($request->hasFile('upload_file') && $request->file('upload_file')->isValid()) {
                    if ($filename && File::exists(public_path('medias/customer-contract/' . $filename))) {
                        File::delete(public_path('medias/customer-contract/' . $filename));
                    }
                    $file = $request->file('upload_file');
                    $filename = 'contract_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $path = public_path('medias/customer-contract');
                    File::ensureDirectoryExists($path);
                    $file->move($path, $filename);
                }

                if ($request->has('payment_within_day')) { $contract->payment_within_day = $request->payment_within_day; }
                if ($request->has('start_date')) { $contract->start_date = $request->start_date; }
                if ($request->has('end_date')) { $contract->end_date = $request->end_date; }
                if ($request->has('advance_payment')) { $contract->advance_payment = $request->advance_payment ?? 0; }
                if ($request->has('remarks')) { $contract->remarks = $request->remarks; }
                if ($request->has('total_allowed_kilometer')) { $contract->monthly_total_allowed_kilometer = $request->total_allowed_kilometer ?? 0; }
                if ($request->has('monthly_total_price')) { $contract->monthly_total_price = str_replace(',', '', $request->monthly_total_price); }

                $contract->updated_by = Auth::id();
                $contract->save();

                $detail = Customercontractdetail::where('customercontract_id', $contract->id)->first();
                if (!$detail) {
                    $detail = new Customercontractdetail;
                    $detail->customercontract_id = $contract->id;
                }
                if ($filename) { $detail->contract_file = $filename; }
                if ($request->has('end_date')) { $detail->contract_expiry_date = $request->end_date; }
                if ($request->has('set_reminder')) { $detail->set_reminder = $request->set_reminder; }
                if ($request->set_reminder === 'Yes') {
                    if ($request->has('reminder_days_before_expiry')) { $detail->reminder_days_before_expiry = $request->reminder_days_before_expiry; }
                } else {
                    $detail->reminder_days_before_expiry = null;
                }
                $detail->updated_by = Auth::id();
                $detail->save();

                if ($request->has('route_id') && is_array($request->route_id)) {
                    $contract->routes()->sync($request->route_id);
                }

                return $contract->load('detail', 'routes');
            });

            return response()->json(['success' => true, 'data' => $contract, 'message' => 'Customer contract updated successfully.'], 200);

        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function deleteContract(Request $request)
    {
        try {
            $actmodelid = $request->input('actmodelid');

            $deletedContract = DB::transaction(function () use ($request) {
                $contract = Customercontract::with('detail')->find($request->id);
                if (!$contract) {
                    throw new \Exception('Contract not found.');
                }
                if ($contract->delete()) {
                    return $contract;
                }
                throw new \Exception('Delete failed');
            });

            $this->storeUseractivity($actmodelid, 6, Auth::user()->id, $deletedContract->id, 'Deleted a contact.');

            return response()->json(['success' => true, 'data' => $deletedContract, 'message' => 'Customer contract deleted successfully.'], 200);

        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function getContractRoutes($id)
    {
        try {
            $contract = Customercontract::with(['routes' => function ($query) {
                            $query->withCount('midpoints');
                        }])->find($id);

            if (!$contract) {
                return response()->json(['success' => false, 'routes' => [], 'message' => 'Contract not found.'], 422);
            }

            return response()->json(['success' => true, 'routes' => $contract->routes, 'message' => 'Routes fetched successfully.'], 200);

        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'routes' => [], 'message' => 'Something went wrong while fetching routes.'], 500);
        }
    }

    /* ===============================================================
     | Customer Contract Pricing / Rate Chart
     | (← storePricing/deletePricing/getLabourCharges/getVehicleFreight/
     |    getPricingHistory/checkRoutePointsSetup + private helpers)
     | =============================================================== */

    public function storePricing(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'contact_id' => 'required|exists:contacts,id',
            'customercontract_id' => 'required|exists:customercontracts,id',
            'customercontract_route_id' => 'required|exists:contractroutes,id',
            'contract_source_city_id' => 'required|exists:cities,id',
            'contract_destination_city_id' => 'required|exists:cities,id',
            'applicable_start_date' => 'required|date',
            'applicable_end_date'   => 'required|date|after_or_equal:applicable_start_date',
            'retrospective_start_date' => 'required|date',
            'retrospective_end_date'   => 'required|date|after_or_equal:retrospective_start_date',
            'midpoint_count' => 'nullable|integer|min:0',
            'midpoint_type' => 'nullable|array',
            'midpoint_type.*' => 'nullable|in:Loading,Unloading',
            'loading_midpoint' => 'nullable|array',
            'loading_midpoint.*' => 'nullable|exists:customerlocations,id',
            'unloading_midpoint' => 'nullable|array',
            'unloading_midpoint.*' => 'nullable|exists:customerlocations,id',
            'vehicle_type_id' => 'required|array|min:1',
            'vehicle_type_id.*' => 'required|exists:vehicletypes,id',
            'vehicletype_size_id' => 'required|array|min:1',
            'vehicletype_size_id.*' => 'required|exists:vehicletypesizes,id',
            'vehicletype_weight' => 'required|array|min:1',
            'vehicletype_weight.*' => 'required|numeric|min:1',
            'vehicletype_price' => 'required|array|min:1',
            'vehicletype_price.*' => 'required|numeric|min:0',
        ], [
            'required' => 'This field is required.',
            'max'      => 'Maximum 100 characters allowed.',
            'exists'   => "This field's value is invalid.",
            'digits'   => 'Invalid format.',
            'distinct' => 'Duplicate value.',
            'email'    => 'This email is invalid.',
            'applicable_end_date.after_or_equal' => 'Applicable end date must be after or equal to start date.',
            'retrospective_end_date.after_or_equal' => 'Retrospective end date must be after or equal to start date.',
        ]);

        $validator->after(function ($validator) use ($request) {
            $vehicleTypes = $request->vehicle_type_id ?? [];
            $vehicleSizes = $request->vehicletype_size_id ?? [];
            if (count($vehicleTypes) !== count($vehicleSizes)) {
                $validator->errors()->add('vehicle_type_id', 'Vehicle type and size count mismatch.');
                return;
            }
            $combinations = [];
            foreach ($vehicleTypes as $index => $typeId) {
                $sizeId = $vehicleSizes[$index] ?? null;
                $key = $typeId . '-' . $sizeId;
                if (isset($combinations[$key])) {
                    $validator->errors()->add("vehicle_type_id.$index", 'Duplicate vehicle type and size combination.');
                }
                $combinations[$key] = true;
            }
        });

        $validator->after(function ($validator) use ($request) {
            $count = (int) $request->midpoint_count;
            if ($count > 0) {
                $midpointTypes = $request->midpoint_type ?? [];
                if (empty($midpointTypes)) {
                    $validator->errors()->add('midpoint_type', 'Midpoint type is required.');
                    return;
                }
                if (count($midpointTypes) != $count) {
                    $validator->errors()->add('midpoint_type', 'Midpoint count mismatch.');
                }
                foreach ($midpointTypes as $index => $type) {
                    if (empty($type)) {
                        $validator->errors()->add("midpoint_type.$index", "Please select midpoint type.");
                        continue;
                    }
                    if ($type === 'Loading' && empty($request->loading_midpoint[$index])) {
                        $validator->errors()->add("loading_midpoint.$index", "Please select loading midpoint.");
                    }
                    if ($type === 'Unloading' && empty($request->unloading_midpoint[$index])) {
                        $validator->errors()->add("unloading_midpoint.$index", "Please select unloading midpoint.");
                    }
                }
            }
        });

        if ($validator->fails()) {
            return response()->json(['success' => false, 'data' => $validator->errors(), 'message' => 'Please check validation errors.'], 422);
        }

        if ($request->contract_source_city_id == $request->contract_destination_city_id) {
            return response()->json(['success' => false, 'message' => 'Source and destination cannot be same.'], 422);
        }

        if (count($request->vehicle_type_id) !== count($request->vehicletype_size_id) ||
            count($request->vehicle_type_id) !== count($request->vehicletype_price)) {
            return response()->json(['success' => false, 'message' => 'Vehicle pricing arrays mismatch.'], 422);
        }

        $exists = Contractpricing::where([
            'contact_id' => $request->contact_id,
            'customercontract_id' => $request->customercontract_id,
            'customercontract_route_id' => $request->customercontract_route_id,
        ])->exists();

        if ($exists) {
            return response()->json(['success' => false, 'message' => 'Pricing already exists for this route.'], 422);
        }

        $missingPoints = $this->routePointsSetupMissing($request->contact_id, $request->customercontract_route_id);
        if (! empty($missingPoints)) {
            return response()->json([
                'success' => false,
                'message' => 'Location setup is incomplete for this route. Configure locations for: '
                             . implode(', ', $missingPoints)
                             . ' in the Location tab before creating a Rate Chart.'
            ], 422);
        }

        try {
            $contractpricing = DB::transaction(function () use ($request) {

                $contractpricing = new Contractpricing;
                $contractpricing->contact_id    = $request->contact_id;
                $contractpricing->customercontract_id = $request->customercontract_id;
                $contractpricing->customercontract_route_id = $request->customercontract_route_id;
                $contractpricing->applicable_start_date    = $request->applicable_start_date;
                $contractpricing->applicable_end_date      = $request->applicable_end_date;
                $contractpricing->retrospective_start_date = $request->retrospective_start_date;
                $contractpricing->retrospective_end_date   = $request->retrospective_end_date;
                $contractpricing->created_by = Auth::user()->id;
                $contractpricing->save();

                $contractpricinglog = new Contractpricinglog;
                $contractpricinglog->contractpricing_id    = $contractpricing->id;
                $contractpricinglog->contact_id            = $request->contact_id;
                $contractpricinglog->customercontract_id   = $request->customercontract_id;
                $contractpricinglog->customercontract_route_id = $request->customercontract_route_id;
                $contractpricinglog->applicable_start_date     = $request->applicable_start_date;
                $contractpricinglog->applicable_end_date       = $request->applicable_end_date;
                $contractpricinglog->retrospective_start_date  = $request->retrospective_start_date;
                $contractpricinglog->retrospective_end_date    = $request->retrospective_end_date;
                $contractpricinglog->created_by = Auth::user()->id;
                $contractpricinglog->save();

                // Source Loading Point
                $sl = new Contractpricinglocationpoint;
                $sl->contractpricing_id = $contractpricing->id;
                $sl->point_type = 'Source';
                $sl->location_type = 'Loading';
                $sl->customerlocation_id = $request->contract_source_city_id;
                $sl->save();

                $sllog = new Contractpricinglocationpointlog;
                $sllog->contractpricinglog_id = $contractpricinglog->id;
                $sllog->point_type = 'Source';
                $sllog->location_type = 'Loading';
                $sllog->customerlocation_id = $request->contract_source_city_id;
                $sllog->save();

                // Destination Unloading Point
                $du = new Contractpricinglocationpoint;
                $du->contractpricing_id = $contractpricing->id;
                $du->point_type = 'Destination';
                $du->location_type = 'Unloading';
                $du->customerlocation_id = $request->contract_destination_city_id;
                $du->save();

                $dulog = new Contractpricinglocationpointlog;
                $dulog->contractpricinglog_id = $contractpricinglog->id;
                $dulog->point_type = 'Destination';
                $dulog->location_type = 'Unloading';
                $dulog->customerlocation_id = $request->contract_destination_city_id;
                $dulog->save();

                // Midpoints
                if ($request->midpoint_count) {
                    for ($i = 1; $i <= $request->midpoint_count; $i++) {
                        if (!empty($request->midpoint_type[$i])) {
                            $type = $request->midpoint_type[$i];
                            $location_id = null;
                            if ($type === 'Loading')   { $location_id = $request->loading_midpoint[$i] ?? null; }
                            if ($type === 'Unloading') { $location_id = $request->unloading_midpoint[$i] ?? null; }

                            if ($location_id) {
                                $mp = new Contractpricinglocationpoint;
                                $mp->contractpricing_id = $contractpricing->id;
                                $mp->point_type = 'Midpoint';
                                $mp->location_type = $type;
                                $mp->customerlocation_id = $location_id;
                                $mp->save();

                                $mplog = new Contractpricinglocationpointlog;
                                $mplog->contractpricinglog_id = $contractpricinglog->id;
                                $mplog->point_type = 'Midpoint';
                                $mplog->location_type = $type;
                                $mplog->customerlocation_id = $location_id;
                                $mplog->save();
                            }
                        }
                    }
                }

                // Vehicle Pricing
                if ($request->vehicle_type_id) {
                    foreach ($request->vehicle_type_id as $index => $vehicleTypeId) {
                        $cpv = new Contractpricingvehicle;
                        $cpv->contractpricing_id = $contractpricing->id;
                        $cpv->vehicletype_id     = $vehicleTypeId;
                        $cpv->vehicletypesize_id = $request->vehicletype_size_id[$index];
                        $cpv->price              = $request->vehicletype_price[$index];
                        $cpv->weight             = $request->vehicletype_weight[$index];
                        $cpv->save();

                        $cpvlog = new Contractpricingvehiclelog;
                        $cpvlog->contractpricinglog_id = $contractpricinglog->id;
                        $cpvlog->vehicletype_id     = $vehicleTypeId;
                        $cpvlog->vehicletypesize_id = $request->vehicletype_size_id[$index];
                        $cpvlog->price              = $request->vehicletype_price[$index];
                        $cpvlog->weight             = $request->vehicletype_weight[$index];
                        $cpvlog->save();
                    }
                }

                return $contractpricing;
            });

            if ($contractpricing->id) {
                $this->storeUseractivity(47, 3, Auth::user()->id, $contractpricing->id, 'Added new Contract pricing.');
            }

            return response()->json(['success' => true, 'data' => $contractpricing, 'message' => 'Contract pricing saved successfully.'], 200);

        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'data' => [], 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Returns the list of route points (Source / Destination / each Midpoint) that do
     * NOT yet have a matching customer Location configured. Empty array = fully set up.
     */
    private function routePointsSetupMissing($contactId, $contractRouteId): array
    {
        $missing = [];

        $contractRoute = Contractroute::with('route.midpoints.city')->find($contractRouteId);
        if (! $contractRoute || ! $contractRoute->route) {
            return $missing;
        }
        $route = $contractRoute->route;

        if ($route->source_city_id) {
            $hasSource = Customerlocation::where('contact_id', $contactId)
                ->where('route_type', 'source')
                ->whereIn('location_type', ['Loading', 'Both'])
                ->where('source_city_id', $route->source_city_id)
                ->exists();
            if (! $hasSource) { $missing[] = 'Source'; }
        }

        if ($route->destination_city_id) {
            $hasDestination = Customerlocation::where('contact_id', $contactId)
                ->where('route_type', 'destination')
                ->whereIn('location_type', ['Unloading', 'Both'])
                ->where('destination_city_id', $route->destination_city_id)
                ->exists();
            if (! $hasDestination) { $missing[] = 'Destination'; }
        }

        foreach ($route->midpoints as $midpoint) {
            if (! $midpoint->city_id) { continue; }
            $hasMidpoint = Customerlocation::where('contact_id', $contactId)
                ->where('route_type', 'midpoint')
                ->where('midpoint_city_id', $midpoint->city_id)
                ->exists();
            if (! $hasMidpoint) {
                $cityName = optional($midpoint->city)->name ?? ('City #' . $midpoint->city_id);
                $missing[] = 'Midpoint (' . $cityName . ')';
            }
        }

        return $missing;
    }

    /**
     * Returns the customer's configured Source / Destination location options for the
     * given contract-route, so the Rate Chart form can populate those selects.
     */
    private function routePointsOptions($contactId, $contractRouteId): array
    {
        $points = ['source' => [], 'destination' => []];

        $contractRoute = Contractroute::with('route')->find($contractRouteId);
        if (! $contractRoute || ! $contractRoute->route) {
            return $points;
        }
        $route = $contractRoute->route;

        if ($route->source_city_id) {
            $points['source'] = Customerlocation::where('contact_id', $contactId)
                ->where('route_type', 'Source')
                ->whereIn('location_type', ['Loading', 'Both'])
                ->where('source_city_id', $route->source_city_id)
                ->orderBy('location_name')
                ->get(['id', 'location_name']);
        }

        if ($route->destination_city_id) {
            $points['destination'] = Customerlocation::where('contact_id', $contactId)
                ->where('route_type', 'Destination')
                ->whereIn('location_type', ['Unloading', 'Both'])
                ->where('destination_city_id', $route->destination_city_id)
                ->orderBy('location_name')
                ->get(['id', 'location_name']);
        }

        return $points;
    }

    public function checkRoutePointsSetup(Request $request, $id)
    {
        $contactId = $request->query('contact_id');

        if (! $contactId) {
            return response()->json(['success' => false, 'message' => 'Customer is required.'], 422);
        }

        $missing = $this->routePointsSetupMissing($contactId, $id);

        return response()->json([
            'success'  => true,
            'complete' => count($missing) === 0,
            'missing'  => $missing,
            'points'   => $this->routePointsOptions($contactId, $id),
        ], 200);
    }

    public function deletePricing(Request $request)
    {
        $pricing = Contractpricing::find($request->pricing_id ?? $request->id);

        if (!$pricing) {
            return response()->json(['success' => false, 'message' => 'Rate chart not found.'], 422);
        }

        try {
            DB::transaction(function () use ($request, $pricing) {
                $pricing->delete();
                $this->storeUseractivity(47, 6, Auth::user()->id, $pricing->id, 'Deleted a Contract pricing.');
                return $pricing;
            });

            return response()->json(['success' => true, 'message' => 'Contract pricing deleted successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function getLabourCharges($id)
    {
        $pricing = Contractpricing::with(['locationPoints.location', 'createdBy'])->find($id);

        if (!$pricing) {
            return response()->json(['success' => false, 'message' => 'Rate chart not found.'], 422);
        }

        try {
            $data = [];

            foreach ($pricing->locationPoints as $point) {
                if (!$point->location) { continue; }
                $location = $point->location;

                $chargesPaidBy = $location->charges_paid_by ?? null;
                $cappingAmount = $location->capping_amount ?? 0;

                $paidByText = $chargesPaidBy ?? '-';
                if ($chargesPaidBy === 'Mixed') {
                    $paidByText = 'Mixed (Cap Amt: ' . number_format($cappingAmount, 2) . ')';
                }

                $amount = 0;

                if ($point->point_type === 'Source' && $point->location_type === 'Loading') {
                    if ($chargesPaidBy === 'SRL' || $chargesPaidBy === 'Mixed') { $amount = $location->loading_charge ?? 0; }
                    $data[] = ['loading_point' => $location->location_name, 'unloading_point' => '-', 'paid_by' => $paidByText, 'amount' => number_format($amount, 2)];
                }

                if ($point->point_type === 'Destination' && $point->location_type === 'Unloading') {
                    if ($chargesPaidBy === 'SRL' || $chargesPaidBy === 'Mixed') { $amount = $location->unloading_charge ?? 0; }
                    $data[] = ['loading_point' => '-', 'unloading_point' => $location->location_name, 'paid_by' => $paidByText, 'amount' => number_format($amount, 2)];
                }

                if ($point->point_type === 'Midpoint') {
                    if ($point->location_type === 'Loading') {
                        if ($chargesPaidBy === 'SRL' || $chargesPaidBy === 'Mixed') { $amount = $location->loading_charge ?? 0; }
                        $data[] = ['loading_point' => $location->location_name, 'unloading_point' => '-', 'paid_by' => $paidByText, 'amount' => number_format($amount, 2)];
                    }
                    if ($point->location_type === 'Unloading') {
                        if ($chargesPaidBy === 'SRL' || $chargesPaidBy === 'Mixed') { $amount = $location->unloading_charge ?? 0; }
                        $data[] = ['loading_point' => '-', 'unloading_point' => $location->location_name, 'paid_by' => $paidByText, 'amount' => number_format($amount, 2)];
                    }
                }
            }

            return response()->json([
                'success'    => true,
                'message'    => 'Data fetched successfully.',
                'updated_by' => $pricing->createdBy?->name ?? '-',
                'updated_on' => $pricing->updated_at ? $pricing->updated_at->format('d/m/Y') : '-',
                'data'       => $data
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function getVehicleFreight($id)
    {
        $pricing = Contractpricing::with('vehicles.vehicleTypeSize')->find($id);

        if (!$pricing) {
            return response()->json(['success' => false, 'message' => 'Rate chart not found.'], 422);
        }

        try {
            $data = [];
            foreach ($pricing->vehicles as $vehicle) {
                $size = $vehicle->vehicleTypeSize;
                $data[] = [
                    'size' => $size
                        ? $size->name . ' ' . ($size->length ?? '') . ' * ' . ($size->width ?? '') . ' * ' . ($size->height ?? '')
                        : '-',
                    'freight' => number_format($vehicle->price ?? 0, 2)
                ];
            }

            return response()->json(['success' => true, 'data' => $data], 200);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function getPricingHistory($id)
    {
        try {
            $pricing = Contractpricing::with(['customerContract', 'contractroute.route'])->find($id);

            if (!$pricing) {
                return response()->json(['status' => false, 'html' => '<div class="text-center">Invalid Contract</div>'], 422);
            }

            $logs = Contractpricinglog::with([
                'createdBy',
                'locationLogs.location',
                'vehicleLogs.vehicleType',
                'vehicleLogs.vehicleTypeSize'
            ])->where('contractpricing_id', $id)->orderBy('created_at', 'desc')->get();

            if ($logs->isEmpty()) {
                return response()->json(['status' => false, 'html' => '<div class="text-center">No History Found</div>'], 200);
            }

            $html = '';

            $html .= '
            <div class="modal-header">
                <h5 class="modal-title">
                    Rate Chart History
                    <span style="font-size: 14px;"><span class="textbold pe-4"><b>CON#'.$pricing->customerContract?->contract_no.'</b></span>
                    <strong>Route:</strong> '.$pricing->contractroute?->route?->name.' </span>
                    <span style="font-size:14px;" class="badge badge-success ms-5">
                        '.date('d/m/Y', strtotime($pricing->applicable_start_date)).' -
                        '.date('d/m/Y', strtotime($pricing->applicable_end_date)).'
                    </span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="uil uil-times"></i></button>
            </div>

            <div class="modal-body">
            ';

            foreach ($logs as $log) {

                $loadingPoint = $log->locationLogs->where('point_type', 'Source')->where('location_type', 'Loading')->first();
                $unloadingPoint = $log->locationLogs->where('point_type', 'Destination')->where('location_type', 'Unloading')->first();

                $html .= '
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th colspan="6">
                                    <span style="font-size: 14px;"><strong>Updated By:</strong> '.$log->createdBy?->name.' </span>
                                    <span style="font-size: 14px;" class="ms-5"><strong>Updated On:</strong> '.date('d/m/Y H:i', strtotime($log->created_at)).' </span>
                                </th>
                            </tr>
                            <tr>
                                <th>Loading Point</th>
                                <th>Unloading Point</th>
                                <th>Vehicle Type</th>
                                <th>Vehicle Size</th>
                                <th>Current Freight (Rs)</th>
                                <th>Number of Trips</th>
                            </tr>
                        </thead>
                        <tbody>
                ';

                foreach ($log->vehicleLogs as $vehicle) {
                    $html .= '
                        <tr>
                            <td>'.($loadingPoint?->location?->location_name ?? '-').'</td>
                            <td>'.($unloadingPoint?->location?->location_name ?? '-').'</td>
                            <td>'.($vehicle->vehicleType?->name ?? '-').'</td>
                            <td>
                                <span class="tag">
                                    '.($vehicle->vehicleTypeSize?->name ?? '-').'
                                    '.($vehicle->vehicleTypeSize?->length ?? '').' *
                                    '.($vehicle->vehicleTypeSize?->width ?? '').' *
                                    '.($vehicle->vehicleTypeSize?->height ?? '').'
                                </span>
                            </td>
                            <td>Rs '.number_format($vehicle->price ?? 0, 2).'</td>
                            <td>-</td>
                        </tr>
                    ';
                }

                $html .= '
                        </tbody>
                    </table>
                </div>
                <hr>
                ';
            }

            $html .= '</div>';

            return response()->json(['status' => true, 'html' => $html], 200);

        } catch (\Exception $exp) {
            return response()->json(['status' => false, 'html' => '<div class="text-danger text-center">Something went wrong</div>'], 500);
        }
    }

    /* ===============================================================
     | Customer Vehicles (← filterCustomerVehicles / storeCustomerVehicle)
     | =============================================================== */

    public function filterVehicles(Request $request, $id)
    {
        $vehicles = Vehicleallocation::where('contact_id', $id)->where('type', 'Customer')->get();

        return view('V2.customer.partials.vehicles-list', compact('vehicles'))->render();
    }

    public function storeVehicle(Request $request)
    {
        $contact = Contact::where('cotype_id', self::CONTACT_TYPE_CUSTOMER)->find($request->contact_id);
        if (!$contact) {
            return response()->json(['success' => false, 'data' => [], 'message' => 'Customer not found!'], 422);
        }

        $validator = Validator::make($request->all(), [
            'contact_id' => ['required', 'exists:contacts,id'],
            'vehicle_id' => [
                'required',
                'exists:vehicles,id',
                function ($attribute, $value, $fail) use ($request) {
                    $exists = Vehicleallocation::where('contact_id', $request->contact_id)
                                ->where('vehicle_id', $value)
                                ->where('type', 'Customer')
                                ->whereNull('deleted_at')
                                ->where(function ($query) use ($request) {
                                    $query->where('start_date', '<=', $request->v_end_date)
                                          ->where('end_date', '>=', $request->v_start_date);
                                })
                                ->exists();
                    if ($exists) {
                        $fail('This customer already allocated this vehicle for the selected date range.');
                    }
                }
            ],
            'v_start_date' => ['required', 'date', 'before_or_equal:v_end_date'],
            'v_end_date'   => ['required', 'date', 'after_or_equal:v_start_date'],
            'v_allowed_km' => ['required', 'numeric', 'min:0'],
            'v_fixed_amount' => ['required', 'numeric', 'min:0'],
            'v_extra_amount_per_km' => ['required', 'numeric', 'min:0'],
        ], [
            'required'                      => 'This field is required.',
            'max'                           => 'Maximum 100 characters allowed.',
            'exists'                        => "This field's value is invalid.",
            'digits'                        => 'Invalid format.',
            'distinct'                      => 'Duplicate value.',
            'email'                         => 'This email is invalid.',
            'v_start_date.before_or_equal'  => 'Start date must be on or before the end date.',
            'v_end_date.after_or_equal'     => 'End date must be on or after the start date.',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'data' => $validator->errors(), 'message' => 'Please check validation errors.'], 422);
        }

        try {
            DB::transaction(function () use ($request, $contact) {
                $vehicleAllocation = new Vehicleallocation;
                $vehicleAllocation->contact_id           = $contact->id;
                $vehicleAllocation->type                 = 'Customer';
                $vehicleAllocation->vehicle_id           = $request->vehicle_id;
                $vehicleAllocation->change_vehicle       = null;
                $vehicleAllocation->vehicle_change_reason= null;
                $vehicleAllocation->km_allowed           = $request->v_allowed_km ?? 0;
                $vehicleAllocation->fixed_amount         = $request->v_fixed_amount ?? 0;
                $vehicleAllocation->extra_amount_per_km  = $request->v_extra_amount_per_km ?? 0;
                $vehicleAllocation->start_date           = $request->v_start_date;
                $vehicleAllocation->end_date             = $request->v_end_date;
                $vehicleAllocation->created_by           = Auth::user()->id;
                $vehicleAllocation->save();

                return $vehicleAllocation;
            });

            return response()->json(['success' => true, 'data' => $contact, 'message' => 'Vehicle has been successfully allocated to the customer.'], 200);

        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'data' => [], 'message' => $e->getMessage()], 500);
        }
    }

    /* ===============================================================
     | Attachments (V2 copies of shared logic — same path & rules as V1)
     | path: public/media/contact/ · mimes jpg,jpeg,png,pdf · max 2MB
     | =============================================================== */

    public function storeAttachment(Request $request)
    {
        $contact = Contact::where('cotype_id', self::CONTACT_TYPE_CUSTOMER)->find($request->contact_id);
        if (!$contact) {
            return response()->json(['success' => false, 'data' => [], 'message' => 'Customer not found!'], 422);
        }

        $validator = Validator::make($request->all(), [
            'coattachtype_id'   => 'required|exists:coattachtypes,id',
            'attachment_file'   => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ], [
            'required'                 => 'This field is required.',
            'mimes'                    => 'File type must be jpg, jpeg, png or pdf.',
            'attachment_file.max'      => 'File size must not exceed 2MB.',
            'attachment_file.uploaded' => 'File size must not exceed 2MB.',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'data' => $validator->errors(), 'message' => 'Please check validation errors.'], 422);
        }

        // Max 2 files per type for this customer (dedupe rule from V1)
        $existingOfType = Coattachment::where('contact_id', $contact->id)
                            ->where('coattachtype_id', $request->coattachtype_id)
                            ->count();
        if ($existingOfType >= 2) {
            return response()->json(['success' => false, 'data' => [], 'message' => 'You cannot upload more than 2 files for this document type.'], 422);
        }

        try {
            $attachment = DB::transaction(function () use ($request, $contact) {
                $file = $request->file('attachment_file');
                $fileoriginalname = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $filesize  = $file->getSize();

                $filename = 'contact-attachment-'.Str::random(4).'_'.time().'.'.$extension;
                $file->move(public_path('media'.DIRECTORY_SEPARATOR.'contact'.DIRECTORY_SEPARATOR), $filename);

                $attachment = new Coattachment;
                $attachment->name            = $filename;
                $attachment->original_name   = $fileoriginalname;
                $attachment->file_size       = ($filesize / (1024 * 1024));
                $attachment->coattachtype_id = $request->coattachtype_id;
                $attachment->created_by      = Auth::id();
                $attachment->contact_id      = $contact->id;
                $attachment->save();

                return $attachment;
            });

            return response()->json(['success' => true, 'data' => $attachment, 'message' => 'Attachment saved successfully.'], 200);

        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'data' => [], 'message' => $e->getMessage()], 500);
        }
    }

    public function updateAttachment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'attachment_id'   => 'required|exists:coattachments,id',
            'attachment_file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ], [
            'required' => 'This field is required.',
            'mimes'    => 'File type must be jpg, jpeg, png or pdf.',
            'max'      => 'File size must not exceed 2MB.',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'data' => $validator->errors(), 'message' => 'Please check validation errors.'], 422);
        }

        $attachment = Coattachment::find($request->attachment_id);
        if (!$attachment) {
            return response()->json(['success' => false, 'data' => [], 'message' => 'Attachment not found.'], 422);
        }

        try {
            $result = DB::transaction(function () use ($request, $attachment) {
                if ($request->hasFile('attachment_file')) {
                    $file = $request->file('attachment_file');
                    $fileoriginalname = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();
                    $filesize  = $file->getSize();

                    $filename = 'contact-attachment-'.Str::random(4).'_'.time().'.'.$extension;
                    $file->move(public_path('media'.DIRECTORY_SEPARATOR.'contact'.DIRECTORY_SEPARATOR), $filename);

                    $attachment->name          = $filename;
                    $attachment->original_name = $fileoriginalname;
                    $attachment->file_size     = ($filesize / (1024 * 1024));
                    $attachment->updated_by    = Auth::id();
                    $attachment->save();
                }
                return $attachment;
            });

            return response()->json(['success' => true, 'data' => $result, 'message' => 'Attachment saved successfully.'], 200);

        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'data' => [], 'message' => $e->getMessage()], 500);
        }
    }

    public function deleteAttachment(Request $request)
    {
        $id = $request->input('id') ?? $request->input('attachment_id');

        if ($id == '') {
            return response()->json(['success' => false, 'data' => [], 'message' => 'Woops! id not found.'], 422);
        }

        $contactattachment = Coattachment::find($id);
        if ($contactattachment == null) {
            return response()->json(['success' => false, 'data' => [], 'message' => 'Woops! attachment not found.'], 422);
        }

        try {
            DB::transaction(function () use ($contactattachment) {
                $contactattachment->delete();
                return $contactattachment;
            });

            return response()->json(['success' => true, 'data' => [], 'message' => 'Attachment deleted successfully.'], 200);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'data' => [], 'message' => $e->getMessage()], 500);
        }
    }

    /* ===============================================================
     | Activity note (← storeActivityNotes)
     | =============================================================== */

    public function storeActivityNote(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'activity_notes' => 'required|string',
            'contact_id'     => 'required|exists:contacts,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        try {
            $activity = DB::transaction(function () use ($request) {
                $activity = new Contactactivity();
                $activity->contact_id = $request->contact_id;
                $activity->notes      = $request->activity_notes;
                $activity->created_by = Auth::user()->id;
                $activity->save();

                return $activity;
            });

            return response()->json(['success' => true, 'data' => $activity, 'message' => 'Activity note saved successfully.'], 200);

        } catch (\Exception $exp) {
            return response()->json(['success' => false, 'data' => [], 'message' => $exp->getMessage()], 500);
        }
    }
}
