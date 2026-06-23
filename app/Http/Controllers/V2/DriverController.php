<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Cotype;
use App\Models\Contact;
use App\Models\Coattachtype;
use App\Models\Coattachment;
use App\Models\Relcontact;
use App\Models\Coaddress;
use App\Models\Contactbank;
use App\Models\Contactactivity;
use App\Models\Religion;
use App\Models\Bank;
use App\Models\Vehicle;
use App\Models\Vehicleallocation;
use App\Models\Driverinfo;
use App\Models\Drivervehiclephoto;
use App\Models\Asset;
use App\Models\Employeeasset;
use App\Models\Employeeallotedassetlog;
use App\Models\Employeeworkexperience;
use App\Models\Employeeexitdetail;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Auth;
use Closure;

use App\Traits\Useractivity;

/**
 * Driver Module V2 — Controller (Gate 2: live backend wiring)  ·  cotype_id = 4
 *
 * Ports the live V1 logic from App\Http\Controllers\ContactController driver*
 * methods into the isolated V2 Driver module. Reuses the existing `contacts`
 * tables + relations via Eloquent only — NO schema changes. The public GET
 * screen methods keep the same view-data array-key shape the Gate-1 blades
 * already consume, but populate every value from real Eloquent records.
 *
 * Mirrors EmployeeController V2 (closest sibling) for E1 standalone letters,
 * E2 read-only-after-exit ($isExited), E5 Permanent/Present addresses; adds the
 * driver-specific E3 bank repeater (exactly one primary), driverinfo, vehicle
 * allocation (type='Driver') and vehicle handover photos. SD-1..13 enforced.
 *
 * NOTE: "Driver Bhatta" has no backing table/model in the current schema, so its
 * Add path is NOT wired at Gate 2 (no-schema-change rule). See
 * docs/HumanAttention/2026-06-15-driver-bhatta-no-schema.md.
 */
class DriverController extends Controller
{
    use Useractivity;

    private const COTYPE = 4; // CONTACT_TYPE_DRIVER

    /* ===============================================================
     | Helpers — shape + counts + lookups
     | =============================================================== */

    /** Primary bank summary string e.g. "SBI · ****4471". */
    private function primaryBankLabel(Contact $c): string
    {
        $rows = $c->relationLoaded('bankDetails') ? $c->bankDetails : $c->bankDetails()->with('bank')->get();
        $primary = $rows->firstWhere('is_primary', 'Yes') ?? $rows->first();
        if (!$primary) {
            return '—';
        }
        $bankName = optional($primary->bank)->name ?? 'Bank';
        $acc      = $primary->account_number ? '****' . substr($primary->account_number, -4) : '';
        return trim($bankName . ($acc ? ' · ' . $acc : ''));
    }

    /** Map a driver Contact into the Gate-1 array shape the blades consume. */
    private function shapeDriver(Contact $c): array
    {
        $info    = $c->driverinfo;
        $vehicle = optional(optional($c->currentVehicleAllocation)->vehicle)->vehicle_no;

        return [
            'id'              => $c->id,
            'contactno'       => $c->contactno,
            'driver_code'     => $c->contact_code ?: ('DR-' . $c->id),
            'name'            => $c->contact_name,
            'category'        => optional($info)->category ?? '—',
            'phone'           => trim(($c->ph_prefix ? $c->ph_prefix . ' ' : '') . $c->phone),
            'whatsapp'        => trim(($c->whatsapp_prefix ? $c->whatsapp_prefix . ' ' : '') . $c->whatsapp),
            'rag'             => $c->rag_status ?? '—',
            'vehicle'         => $vehicle ?: '—',
            'status'          => $c->status ?? 'Active',
            'licence_no'      => optional($info)->driving_licence_no ?? '—',
            'licence_expiry'  => optional($info)->licence_expiry_date ? Carbon::parse($info->licence_expiry_date)->format('d M Y') : '—',
            'aadhaar'         => optional($info)->aadhaar_no ?? '—',
            'dob'             => $c->dob ? Carbon::parse($c->dob)->format('d M Y') : '—',
            'doj'             => $c->doj ? Carbon::parse($c->doj)->format('d M Y') : '—',
            'blood_group'     => $c->blood_group ?? '—',
            'hisab'           => optional($info)->hisab_category ?? '—',
            'bank'            => $this->primaryBankLabel($c),
            'guarantor'       => optional($info)->guarantor_name ?? '—',
            'guarantor_phone' => optional($info)->guarantor_phone
                                    ? trim((optional($info)->guarantor_phone_code ? $info->guarantor_phone_code . ' ' : '') . $info->guarantor_phone)
                                    : '—',
            'exited'          => (bool) $c->employeeExitDetail,
            'exit_date'       => optional($c->employeeExitDetail)->exit_date
                                    ? Carbon::parse($c->employeeExitDetail->exit_date)->format('d M Y') : null,
        ];
    }

    /** Per-tab counts (real Eloquent counts). */
    private function tabCounts(Contact $c): array
    {
        return [
            'joining'   => $c->workExperiences()->count(),
            'documents' => $c->coattachments()->count(),
            'assets'    => $c->employeeAssets()->count(),
            'bhatta'    => 0, // No Bhatta ledger table at Gate 2 (flagged in HumanAttention).
            'exit'      => $c->employeeExitDetail ? 1 : 0,
            'activity'  => $c->activities()->count(),
        ];
    }

    /** Resolve a driver Contact or abort 404 (GET screens only). */
    private function findDriverOrFail($id): Contact
    {
        return Contact::where('cotype_id', self::COTYPE)->findOrFail($id);
    }

    /** Common payload for hub/submodule pages — blades read $d. */
    private function payload(Contact $c, string $active): array
    {
        return [
            'd'        => $this->shapeDriver($c),
            'counts'   => $this->tabCounts($c),
            'active'   => $active,
            'isExited' => (bool) $c->employeeExitDetail,
        ];
    }

    /** E2 — true once the driver has an exit record; used to block sub-entity writes. */
    private function driverExited(Contact $contact): bool
    {
        return (bool) $contact->employeeExitDetail;
    }

    /** Dropdown lookups shared by create + edit. */
    private function formLookups(): array
    {
        return [
            'countries'     => Country::all(),
            'states'        => State::with(['cities' => fn ($q) => $q->orderBy('name')])
                                    ->whereHas('country', fn ($q) => $q->where('iso2', 'IN'))
                                    ->orderBy('name')->get(),
            'cities'        => City::whereHas('state.country', fn ($q) => $q->where('iso2', 'IN'))->orderBy('name')->get(),
            'cotypes'       => Cotype::all(),
            'religions'     => Religion::orderBy('name')->get(),
            'banks'         => Bank::orderBy('name')->get(),
            'vehicles'      => Vehicle::where('status', 'Active')->orderBy('vehicle_no')->get(),
            'coattachtypes' => Coattachtype::all(),
        ];
    }

    /* ===============================================================
     | Screens (public GET) — real Eloquent, Gate-1 array-key shape
     | =============================================================== */

    public function dashboard()
    {
        $base = Contact::where('cotype_id', self::COTYPE);

        $total       = (clone $base)->count();
        $active      = (clone $base)->where('status', 'Active')->count();
        $inactive    = (clone $base)->where('status', 'Inactive')->count();
        $blacklisted = (clone $base)->where('status', 'Blacklisted')->count();
        $line        = (clone $base)->whereHas('driverinfo', fn ($q) => $q->where('category', 'Line'))->count();
        $local       = (clone $base)->whereHas('driverinfo', fn ($q) => $q->where('category', 'Local'))->count();

        $recent = Contact::where('cotype_id', self::COTYPE)
                    ->with(['driverinfo', 'currentVehicleAllocation.vehicle', 'bankDetails.bank', 'employeeExitDetail'])
                    ->orderByDesc('id')->limit(8)->get()
                    ->map(fn ($c) => $this->shapeDriver($c))->all();

        return view('V2.driver.dashboard', [
            'drivers' => $recent,
            'kpi'     => compact('total', 'active', 'inactive', 'blacklisted', 'line', 'local'),
        ]);
    }

    public function index(Request $request)
    {
        $search_name     = $request->name;
        $search_category = $request->category;
        $search_rag      = $request->rag;
        $search_vehicle  = $request->vehicle;

        $query = Contact::where('cotype_id', self::COTYPE)
                    ->with(['cotype', 'driverinfo', 'currentVehicleAllocation.vehicle', 'bankDetails.bank', 'employeeExitDetail']);

        if ($request->filled('name')) {
            $query->where('contact_name', 'like', '%' . $request->name . '%');
        }
        if ($request->filled('rag')) {
            $query->where('rag_status', $request->rag);
        }
        if ($request->filled('category')) {
            $query->whereHas('driverinfo', fn ($q) => $q->where('category', $request->category));
        }
        if ($request->filled('vehicle')) {
            $query->whereHas('currentVehicleAllocation', fn ($q) => $q->where('vehicle_id', $request->vehicle));
        }

        $contacts = $query->orderByDesc('id')->paginate(10)->withQueryString();
        $contacts->getCollection()->transform(fn ($c) => $this->shapeDriver($c));

        $vehicles = Vehicle::where('status', 'Active')->orderBy('vehicle_no')->get();

        return view('V2.driver.index', [
            'drivers'         => $contacts,
            'vehicles'        => $vehicles,
            'search_name'     => $search_name,
            'search_category' => $search_category,
            'search_rag'      => $search_rag,
            'search_vehicle'  => $search_vehicle,
        ]);
    }

    public function create()
    {
        $last = Contact::where('cotype_id', self::COTYPE)->orderByDesc('id')->first();
        $driverCode = 'DR-' . (($last ? $last->id : 0) + 1);

        return view('V2.driver.create', array_merge($this->formLookups(), [
            'driverCode' => $driverCode,
        ]));
    }

    public function show($id)
    {
        $contact = Contact::where('cotype_id', self::COTYPE)
                    ->with(['driverinfo', 'currentVehicleAllocation.vehicle', 'bankDetails.bank', 'coaddresses', 'relcontacts', 'employeeExitDetail'])
                    ->findOrFail($id);

        $permanentAddress = $contact->coaddresses->firstWhere('type', 'Permanent');
        $presentAddress   = $contact->coaddresses->firstWhere('type', 'Present');

        return view('V2.driver.show', array_merge($this->payload($contact, 'overview'), [
            'contact'          => $contact,
            'permanentAddress' => $permanentAddress,
            'presentAddress'   => $presentAddress,
        ]));
    }

    public function edit($id)
    {
        $contact = Contact::with([
            'country.states', 'state.cities', 'relcontacts', 'coaddresses', 'bankDetails.bank',
            'driverinfo', 'vehicleAllocations', 'currentVehicleAllocation.vehicle',
            'employeeAssets', 'workExperiences', 'employeeExitDetail',
            'coattachments.coattachtype', 'activities', 'activities.createdBy', 'driverVehiclePhotos',
        ])->where('cotype_id', self::COTYPE)->findOrFail($id);

        $permanentAddress = $contact->coaddresses->firstWhere('type', 'Permanent');
        $presentAddress   = $contact->coaddresses->firstWhere('type', 'Present');

        // totalYears / remainingMonths from work-experience ranges
        $totalMonths = 0;
        foreach ($contact->workExperiences as $exp) {
            if ($exp->employment_start_date && $exp->employment_end_date) {
                $start = Carbon::parse($exp->employment_start_date);
                $end   = Carbon::parse($exp->employment_end_date);
                if ($end >= $start) {
                    $totalMonths += $start->diffInMonths($end);
                }
            }
        }
        $totalYears      = $totalMonths > 0 ? floor($totalMonths / 12) : 0;
        $remainingMonths = $totalMonths > 0 ? $totalMonths % 12 : 0;

        // On edit, the generic attachment dropzone excludes Driving License + Aadhaar Card.
        $coattachtypes = Coattachtype::whereNotIn('name', ['Driving License', 'Aadhaar Card'])->get();

        $this->storeUseractivity(3, 5, Auth::user()->id, $contact->id, 'Retrieve a driver named ' . $contact->contact_name . ' to edit.');

        return view('V2.driver.edit', array_merge($this->formLookups(), $this->payload($contact, 'edit'), [
            'contact'          => $contact,
            'coattachtypes'    => $coattachtypes,
            'permanentAddress' => $permanentAddress,
            'presentAddress'   => $presentAddress,
            'totalYears'       => $totalYears,
            'remainingMonths'  => $remainingMonths,
        ]));
    }

    public function joining($id)
    {
        $contact = $this->findDriverOrFail($id);
        $workExperiences = Employeeworkexperience::where('contact_id', $contact->id)->orderByDesc('id')->get();

        return view('V2.driver.joining', array_merge($this->payload($contact, 'joining'), [
            'contact'           => $contact,
            'workExperiences'   => $workExperiences,
            'cities'            => City::whereHas('state.country', fn ($q) => $q->where('iso2', 'IN'))->orderBy('name')->get(),
            'canGenerateLetter' => $workExperiences->isNotEmpty(),
        ]));
    }

    public function documents($id)
    {
        $contact = $this->findDriverOrFail($id);

        return view('V2.driver.documents', array_merge($this->payload($contact, 'documents'), [
            'contact'       => $contact,
            'coattachments' => Coattachment::with('coattachtype')->where('contact_id', $contact->id)->latest()->get(),
            'coattachtypes' => Coattachtype::whereNotIn('name', ['Driving License', 'Aadhaar Card'])->orderBy('name')->get(),
        ]));
    }

    public function assets($id)
    {
        $contact = $this->findDriverOrFail($id);

        return view('V2.driver.assets', array_merge($this->payload($contact, 'assets'), [
            'contact'        => $contact,
            'employeeAssets' => Employeeasset::with('asset')->where('contact_id', $contact->id)->orderByDesc('id')->get(),
            'assets'         => Asset::where('status', 'Active')->orderBy('name')->get(),
        ]));
    }

    public function bhatta($id)
    {
        // Driver Bhatta ledger has no backing table at Gate 2 — present read-only
        // zero-state. Add path intentionally not wired (no-schema-change rule).
        $contact = $this->findDriverOrFail($id);

        return view('V2.driver.bhatta', array_merge($this->payload($contact, 'bhatta'), [
            'contact' => $contact,
            'entries' => collect(),
        ]));
    }

    public function exit($id)
    {
        $contact    = $this->findDriverOrFail($id);
        $exitDetail = Employeeexitdetail::where('contact_id', $contact->id)->first();

        return view('V2.driver.exit', array_merge($this->payload($contact, 'exit'), [
            'contact'    => $contact,
            'exitDetail' => $exitDetail,
        ]));
    }

    public function activity($id)
    {
        $contact = $this->findDriverOrFail($id);

        return view('V2.driver.activity', array_merge($this->payload($contact, 'activity'), [
            'contact'    => $contact,
            'activities' => Contactactivity::with('createdBy')->where('contact_id', $contact->id)->orderByDesc('created_at')->get(),
        ]));
    }

    /* ===============================================================
     | E1 — Standalone print letters (do NOT extend layouts.app)
     | =============================================================== */

    public function joiningLetter($id)
    {
        $contact = Contact::with([
            'organisation', 'country.states', 'state.cities', 'relcontacts', 'coaddresses', 'bankDetails.bank',
            'driverinfo', 'currentVehicleAllocation.vehicle', 'workExperiences', 'employeeExitDetail',
            'activities', 'activities.createdBy',
        ])->where('cotype_id', self::COTYPE)->findOrFail($id);

        return view('V2.driver.joining-letter', [
            'contact' => $contact,
            'd'       => $this->shapeDriver($contact),
        ]);
    }

    public function exitLetter($id)
    {
        $contact = Contact::with([
            'organisation', 'country.states', 'state.cities', 'relcontacts', 'coaddresses', 'bankDetails.bank',
            'driverinfo', 'currentVehicleAllocation.vehicle', 'workExperiences', 'employeeExitDetail',
            'activities', 'activities.createdBy',
        ])->where('cotype_id', self::COTYPE)->findOrFail($id);

        return view('V2.driver.exit-letter', [
            'contact' => $contact,
            'd'       => $this->shapeDriver($contact),
        ]);
    }

    /* ===============================================================
     | Repeater wrappers (AJAX HTML fragments) — mirror V1 driver_*
     | =============================================================== */

    public function emergencyContactWrapper(Request $request)
    {
        $rowindex = $request->get('rowindex');
        $html = view('contacts.contact-person-wrapper.driver-emergency-contact', compact('rowindex'))->render();

        return response()->json(['success' => true, 'data' => $html, 'message' => 'Driver emergency contact person wrapper fetched.'], 200);
    }

    public function bankWrapper(Request $request)
    {
        $rowindex = $request->get('rowindex');
        $banks = Bank::orderBy('name')->get();
        $html = view('contacts.contact-bank-detail-wrapper.driver-bank-detail', compact('rowindex', 'banks'))->render();

        return response()->json(['success' => true, 'data' => $html, 'message' => 'Driver bank detail wrapper fetched.'], 200);
    }

    /* ===============================================================
     | Create / Store  (← storeDriver)
     | =============================================================== */
    public function store(Request $request)
    {
        $request->merge([
            'phone'           => preg_replace('/\s+/', '', $request->phone),
            'whatsapp'        => preg_replace('/\s+/', '', $request->whatsapp),
            'guarantor_phone' => preg_replace('/\s+/', '', $request->guarantor_phone),
        ]);

        $validate_phone = function ($attribute, $value, $fail) use ($request) {
            $code = ltrim($request->phone_code ?? getPhoneCode(), '+');
            if (Contact::where('phone', $value)->whereIn('ph_prefix', ['+' . $code, $code])->exists()) {
                $fail('This phone number already exists.');
            }
        };

        $validate_vehicle = function ($attribute, $value, $fail) {
            if (!$value) {
                return;
            }
            $taken = Vehicleallocation::where('vehicle_id', $value)->where('type', 'Driver')->exists();
            if ($taken) {
                $fail('This vehicle is already allocated to another driver.');
            }
        };

        $validate_cp_phone = function (string $attribute, mixed $value, Closure $fail) use ($request) {};

        $validator = Validator::make($request->all(), [
            'contact_name'              => 'required|max:100',
            'contact_image'             => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'contact_code'              => 'required|max:100',
            'driver_category'           => 'required|in:Local,Line',
            'vehicle_id'                => ['required', 'exists:vehicles,id', $validate_vehicle],
            'phone'                     => ['required', 'digits:10', $validate_phone],
            'whatsapp'                  => ['nullable', 'digits:10'],
            'dob'                       => 'nullable|date_format:Y-m-d',
            'doj'                       => 'required|date|before_or_equal:today',
            'blood_group'               => 'nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'religion_id'               => 'nullable|exists:religions,id',

            'driving_licence_no'        => ['required', 'string', 'max:255', Rule::unique('driverinfos', 'driving_licence_no')->whereNull('deleted_at')],
            'licence_issue_date'        => 'required|date_format:Y-m-d',
            'licence_expiry_date'       => 'required|date_format:Y-m-d',
            'original_licence_location' => 'required|string|max:255',
            'driving_license_proof_file'=> 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'aadhaar_no'                => 'required|string|max:255',
            'aadhaar_card_proof_file'   => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'signed_driver_form_file'   => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',

            'status'                    => 'nullable|in:Active,Inactive,Blacklisted',
            'blacklist_reason'          => 'required_if:status,Blacklisted',
            'status_type'               => ['nullable', 'required_if:status,Inactive', 'in:On Leave,Voluntary Exit'],
            'expected_return_date'      => ['nullable', 'date_format:Y-m-d', 'required_if:status_type,On Leave'],
            'set_reminder'              => ['nullable', 'in:Yes,No', Rule::requiredIf($request->status === 'Inactive' && $request->status_type === 'On Leave')],
            'voluntary_exit_reason'     => ['nullable', Rule::requiredIf($request->status === 'Inactive' && $request->status_type === 'Voluntary Exit')],
            'vehicle_photos'            => ['nullable', 'array', Rule::requiredIf($request->status === 'Inactive' && $request->status_type === 'Voluntary Exit')],
            'vehicle_photos.*'          => 'image|mimes:jpg,jpeg,png|max:2048',
            'rag_status'                => 'nullable|in:Red,Yellow,Green',

            'hisab_category'            => 'required|in:Fixed,Fuel',
            'opening_balance_date'      => 'required|date_format:Y-m-d',
            'opening_balance_type'      => 'required|in:Credit,Debit',
            'opening_balance'           => 'required|numeric|min:0',
            'guarantor_name'            => 'required|string|max:255',
            'guarantor_phone'           => 'required|digits:10',
            'contact_comment'           => 'nullable|string|max:255',

            'primary_bank'              => 'required',
            'bank_id'                   => 'required|array|min:1',
            'bank_id.*'                 => 'required|exists:banks,id',
            'beneficiary_name.*'        => 'nullable|string|max:255',
            'account_number'            => 'required|array|min:1',
            'account_number.*'          => 'required|string|max:50',
            'ifsc_code'                 => 'required|array|min:1',
            'ifsc_code.*'               => 'required|string|max:20',
            'upi_id.*'                  => 'nullable|string|max:100',

            'contact_person_name'       => 'required|array|min:1',
            'contact_person_name.*'     => 'required|string|distinct|min:1',
            'contact_person_relation'   => 'required|array|min:1',
            'contact_person_relation.*' => 'required|string|min:1',
            'contact_person_blood_group.*' => 'nullable|string|min:1',
            'contact_person_address.*'  => 'nullable|string|min:1',
            'contact_person_ph_code'    => 'nullable|array|min:1',
            'contact_person_phone'      => 'required|array|min:1',
            'contact_person_phone.*'    => ['required', 'string', 'distinct', $validate_cp_phone],
            'contact_person_whatsapp'   => 'nullable|array|min:1',
            'contact_person_whatsapp.*' => ['nullable', 'string', 'distinct', $validate_cp_phone],
            'contact_person_comment.*'  => 'nullable|string|min:1',

            'permanent_address'          => 'required|string|max:255',
            'permanent_addr_state_id'    => 'required|exists:states,id',
            'permanent_addr_city_id'     => 'nullable|exists:cities,id',
            'permanent_addr_postal_code' => 'required|digits:6',
            'present_address'            => 'required|string|max:255',
            'present_addr_state_id'      => 'required|exists:states,id',
            'present_addr_city_id'       => 'nullable|exists:cities,id',
            'present_addr_postal_code'   => 'required|digits:6',
        ], [
            'required'        => 'This field is required.',
            'max'             => 'Maximum :max characters allowed.',
            'exists'          => "This field's value is invalid.",
            'distinct'        => 'Duplicate value.',
            'phone.digits'    => 'This field must contain 10 digits.',
            'whatsapp.digits' => 'This field must contain 10 digits.',
            'primary_bank.required'                   => 'At least one bank must be marked as Primary.',
            'doj.required'                            => 'Date of Joining is required.',
            'doj.before_or_equal'                     => 'Date of Joining cannot be a future date.',
            'dob.date_format'                         => 'Date of Birth must be in YYYY-MM-DD format.',
            'permanent_addr_postal_code.required'     => 'Permanent Address Postal Code is required.',
            'permanent_addr_postal_code.digits'       => 'Permanent Address Postal Code must be 6 digits.',
            'present_addr_postal_code.required'       => 'Present Address Postal Code is required.',
            'present_addr_postal_code.digits'         => 'Present Address Postal Code must be 6 digits.',
            'driving_licence_no.unique'               => 'This driving licence number is already registered.',
        ]);

        // Attachment row validation (type/file pairing, dup type, size, mime)
        $errorcount = 0;
        $errors = [];
        $attachtype_ids = [];
        $attachtypes = $request->attachtypes ?? [];
        $filesInput  = $request->file('files') ?? [];
        $max = max(count($attachtypes), count($filesInput));
        for ($key = 0; $key < $max; $key++) {
            $attachtype = $attachtypes[$key] ?? null;
            $files      = $filesInput[$key] ?? null;
            if (empty($attachtype) && empty($files)) { continue; }
            if (!empty($files) && empty($attachtype)) { $errorcount++; $errors['coattachtype_' . $key] = ['Document type is required.']; continue; }
            if (!empty($attachtype) && empty($files)) { $errorcount++; $errors['coattachments_' . $key] = ['Please upload file.']; continue; }
            if (in_array($attachtype, $attachtype_ids)) { $errorcount++; $errors['coattachtype_' . $key] = ['You have already added this attachment type.']; continue; }
            $attachtype_ids[] = $attachtype;
            if (!empty($files)) {
                if (count($files) > 2) { $errorcount++; $errors['coattachments_' . $key] = ['You cannot upload more than 2 files.']; }
                foreach ($files as $file) {
                    $extension = strtolower($file->getClientOriginalExtension());
                    if (!in_array($extension, ['jpg', 'jpeg', 'png', 'pdf'])) { $errorcount++; $errors['coattachments_' . $key] = ['File type must be jpg, jpeg, png or pdf.']; }
                    if ($file->getSize() > 2097152) { $errorcount++; $errors['coattachments_' . $key] = ['File size must not exceed 2MB.']; }
                }
            }
        }

        $errormessages = array_merge($validator->getMessageBag()->toArray(), $errors);
        if ($validator->fails() || $errorcount > 0) {
            return response()->json(['success' => false, 'data' => $errormessages, 'message' => 'Please check validation error.'], 422);
        }

        try {
            $contact = DB::transaction(function () use ($request) {
                $lastcontact = Contact::withTrashed()->orderBy('id', 'DESC')->first();
                if ($lastcontact) {
                    $incr = ((int) $lastcontact->contactno) + 1;
                    $contactno = strlen($incr) < 5 ? str_pad($incr, 6, '0', STR_PAD_LEFT) : $incr;
                } else {
                    $contactno = '000001';
                }

                $phoneCode  = getPhoneCode();
                $uploadPath = public_path('media' . DIRECTORY_SEPARATOR . 'contact');
                if (!File::exists($uploadPath)) { File::makeDirectory($uploadPath, 0755, true); }

                // contact image
                $imageName = null;
                if ($request->hasFile('contact_image')) {
                    $f = $request->file('contact_image');
                    $imageName = 'driver_' . time() . '_' . Str::random(6) . '.' . $f->getClientOriginalExtension();
                    $f->move($uploadPath, $imageName);
                }

                $contact = new Contact;
                $contact->contactno       = $contactno;
                $contact->cotype_id       = self::COTYPE;
                $contact->organisation_id = optional(Auth::user()?->organisation)->id ?? 1; // SD-11
                $contact->contact_name    = $request->contact_name;
                $contact->contact_code    = $request->contact_code;
                $contact->ph_prefix       = $request->phone_code ?? $phoneCode;
                $contact->phone           = $request->phone;
                $contact->whatsapp_prefix = $request->whatsapp_code ?? $phoneCode;
                $contact->whatsapp        = $request->whatsapp;
                $contact->contact_image   = $imageName;
                $contact->dob             = $request->dob;
                $contact->blood_group     = $request->blood_group;
                $contact->religion_id     = $request->religion_id;
                $contact->doj             = $request->doj;
                $contact->status          = $request->status ?? 'Active';
                $contact->blacklist_reason = $request->blacklist_reason ?? null;
                $contact->blacklisted_at   = $request->status === 'Blacklisted' ? now() : null;
                $contact->rag_status      = $request->rag_status;
                $contact->comment         = $request->contact_comment;
                $contact->created_by      = Auth::user()->id;
                $contact->save();

                // Vehicle allocation (type=Driver)
                $alloc = new Vehicleallocation;
                $alloc->contact_id            = $contact->id;
                $alloc->type                  = 'Driver';
                $alloc->vehicle_id            = $request->vehicle_id;
                $alloc->change_vehicle        = null;
                $alloc->vehicle_change_reason = null;
                $alloc->km_allowed            = 0;
                $alloc->fixed_amount          = 0;
                $alloc->extra_amount_per_km   = 0;
                $alloc->start_date            = null;
                $alloc->end_date              = null;
                $alloc->created_by            = Auth::user()->id;
                $alloc->save();

                // Emergency contacts
                $names = $request->get('contact_person_name', []);
                for ($i = 0; $i < count($names); $i++) {
                    $name  = $names[$i] ?? null;
                    $phone = $request->get('contact_person_phone')[$i] ?? null;
                    if (empty($name) && empty($phone)) { continue; }
                    $rc = new Relcontact;
                    $rc->contact_id      = $contact->id;
                    $rc->name            = $name;
                    $rc->relationship    = $request->get('contact_person_relation')[$i] ?? null;
                    $rc->blood_group     = $request->get('contact_person_blood_group')[$i] ?? null;
                    $rc->address         = $request->get('contact_person_address')[$i] ?? null;
                    $rc->ph_prefix       = $request->get('contact_person_ph_code')[$i] ?? $phoneCode;
                    $rc->phone           = $phone;
                    $rc->whatsapp_prefix = $request->get('contact_person_whatsapp_code')[$i] ?? $phoneCode;
                    $rc->whatsapp        = $request->get('contact_person_whatsapp')[$i] ?? null;
                    $rc->comment         = $request->get('contact_person_comment')[$i] ?? null;
                    $rc->created_by      = Auth::user()->id;
                    $rc->save();
                }

                // Addresses (E5)
                if (!empty($request->permanent_address) || !empty($request->permanent_addr_state_id) || !empty($request->permanent_addr_postal_code)) {
                    $a = new Coaddress;
                    $a->contact_id = $contact->id; $a->type = 'Permanent';
                    $a->address = $request->permanent_address; $a->state_id = $request->permanent_addr_state_id;
                    $a->city_id = $request->permanent_addr_city_id; $a->zipcode = $request->permanent_addr_postal_code;
                    $a->additional_info = $request->permanent_addr_additional_info;
                    $a->save();
                }
                if (!empty($request->present_address) || !empty($request->present_addr_state_id) || !empty($request->present_addr_postal_code)) {
                    $a = new Coaddress;
                    $a->contact_id = $contact->id; $a->type = 'Present';
                    $a->address = $request->present_address; $a->state_id = $request->present_addr_state_id;
                    $a->city_id = $request->present_addr_city_id; $a->zipcode = $request->present_addr_postal_code;
                    $a->additional_info = $request->present_addr_additional_info;
                    $a->save();
                }

                // driverinfo proof uploads
                $dlName = $aaName = $sfName = null;
                if ($request->hasFile('driving_license_proof_file')) {
                    $f = $request->file('driving_license_proof_file');
                    $dlName = 'driving_license_' . time() . '_' . Str::random(6) . '.' . $f->getClientOriginalExtension();
                    $f->move($uploadPath, $dlName);
                }
                if ($request->hasFile('aadhaar_card_proof_file')) {
                    $f = $request->file('aadhaar_card_proof_file');
                    $aaName = 'aadhaar_card_' . time() . '_' . Str::random(6) . '.' . $f->getClientOriginalExtension();
                    $f->move($uploadPath, $aaName);
                }
                if ($request->hasFile('signed_driver_form_file')) {
                    $f = $request->file('signed_driver_form_file');
                    $sfName = 'signed_driver_form_' . time() . '_' . Str::random(6) . '.' . $f->getClientOriginalExtension();
                    $f->move($uploadPath, $sfName);
                }

                $info = new Driverinfo;
                $info->contact_id                 = $contact->id;
                $info->category                   = $request->driver_category;
                $info->driving_licence_no         = $request->driving_licence_no;
                $info->licence_issue_date         = $request->licence_issue_date;
                $info->licence_expiry_date        = $request->licence_expiry_date;
                $info->original_licence_location   = $request->original_licence_location;
                $info->driving_license_proof_file = $dlName;
                $info->aadhaar_no                 = $request->aadhaar_no;
                $info->aadhaar_card_proof_file    = $aaName;
                $info->signed_driver_form_file    = $sfName;
                $info->status_type                = $request->status_type;
                $info->expected_return_date       = $request->expected_return_date;
                $info->set_reminder               = $request->set_reminder;
                $info->voluntary_exit_reason      = $request->voluntary_exit_reason;
                $info->hisab_category             = $request->hisab_category;
                $info->opening_balance_date       = $request->opening_balance_date;
                $info->opening_balance_type       = $request->opening_balance_type;
                $info->opening_balance            = $request->opening_balance;
                $info->guarantor_name             = $request->guarantor_name;
                $info->guarantor_phone_code       = $request->guarantor_phone_code ?? $phoneCode;
                $info->guarantor_phone            = $request->guarantor_phone;
                $info->save();

                // Vehicle handover photos
                if ($request->hasFile('vehicle_photos')) {
                    foreach ($request->file('vehicle_photos') as $photo) {
                        $pName = 'vehicle_photo_' . time() . '_' . Str::random(6) . '.' . $photo->getClientOriginalExtension();
                        $photo->move($uploadPath, $pName);
                        $vp = new Drivervehiclephoto;
                        $vp->contact_id = $contact->id;
                        $vp->file_name  = $pName;
                        $vp->save();
                    }
                }

                // Bank details (E3 — exactly one primary by primary_bank index)
                $bankIds    = $request->get('bank_id', []);
                $primaryIdx = $request->get('primary_bank');
                foreach ($bankIds as $i => $bankId) {
                    if (empty($bankId)) { continue; }
                    $b = new Contactbank;
                    $b->contact_id       = $contact->id;
                    $b->bank_id          = $bankId;
                    $b->is_primary       = ((string) $i === (string) $primaryIdx) ? 'Yes' : 'No';
                    $b->beneficiary_name = $request->get('beneficiary_name')[$i] ?? null;
                    $b->account_number   = $request->get('account_number')[$i] ?? null;
                    $b->ifsc_code        = $request->get('ifsc_code')[$i] ?? null;
                    $b->upi_id           = $request->get('upi_id')[$i] ?? null;
                    $b->save();
                }

                // Attachments
                $attachtypes = $request->attachtypes;
                if (!empty($attachtypes)) {
                    foreach ($attachtypes as $key => $attachtype) {
                        if (isset($request->file('files')[$key])) {
                            foreach ($request->file('files')[$key] as $file) {
                                $extension = $file->getClientOriginalExtension();
                                $fname = 'contact-attachment-' . Str::random(4) . '_' . time() . '.' . $extension;
                                $__fsize = $file->getSize(); $__foname = $file->getClientOriginalName();
                                $file->move($uploadPath, $fname);
                                $att = new Coattachment;
                                $att->name            = $fname;
                                $att->original_name   = $__foname;
                                $att->file_size       = ($__fsize / (1024 * 1024));
                                $att->coattachtype_id = $attachtype;
                                $att->created_by      = Auth::id();
                                $att->contact_id      = $contact->id;
                                $att->save();
                            }
                        }
                    }
                }

                $this->storeUseractivity(3, 3, Auth::user()->id, $contact->id, 'Added new driver contact with ID ' . $contact->id);

                return $contact;
            });

            return response()->json(['success' => true, 'data' => $contact, 'message' => 'Driver saved successfully.', 'redirect' => route('contact.v2.driver.show', $contact->id)], 200);
        } catch (\Exception $exp) {
            return response()->json(['success' => false, 'data' => [], 'message' => $exp->getMessage()], 500);
        }
    }

    /* ===============================================================
     | Edit / Update  (← updateDriver)
     | =============================================================== */
    public function update(Request $request, $id)
    {
        $request->merge([
            'phone'           => preg_replace('/\s+/', '', $request->phone),
            'whatsapp'        => preg_replace('/\s+/', '', $request->whatsapp),
            'guarantor_phone' => preg_replace('/\s+/', '', $request->guarantor_phone),
            'change_vehicle'  => $request->change_vehicle ? 'Yes' : 'No',
        ]);

        $contact = Contact::where('cotype_id', self::COTYPE)->find($id);
        if (!$contact) {
            return response()->json(['success' => false, 'data' => [], 'message' => 'Driver not found.'], 422);
        }
        if ($this->driverExited($contact)) {
            return response()->json(['success' => false, 'message' => 'This driver has exited — the profile cannot be edited.'], 422);
        }
        $driverinfo = Driverinfo::where('contact_id', $contact->id)->first();

        $validate_phone = function ($attribute, $value, $fail) use ($request, $id) {
            $code = ltrim($request->phone_code ?? getPhoneCode(), '+');
            if (Contact::where('phone', $value)->whereIn('ph_prefix', ['+' . $code, $code])->where('id', '!=', $id)->exists()) {
                $fail('This phone number already exists.');
            }
        };
        $validate_vehicle = function ($attribute, $value, $fail) use ($request, $contact) {
            if ($request->change_vehicle !== 'Yes' || !$value) { return; }
            $taken = Vehicleallocation::where('vehicle_id', $value)->where('type', 'Driver')
                        ->where('contact_id', '!=', $contact->id)->exists();
            if ($taken) { $fail('This vehicle is already allocated to another driver.'); }
        };
        $validate_cp_phone = function (string $attribute, mixed $value, Closure $fail) {};

        $validator = Validator::make($request->all(), [
            'contact_name'              => 'required|max:100',
            'contact_image'             => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'contact_code'              => 'required|max:100',
            'driver_category'           => 'required|in:Local,Line',
            'change_vehicle'            => 'required|in:Yes,No',
            'vehicle_id'                => ['nullable', 'exists:vehicles,id', Rule::requiredIf($request->change_vehicle === 'Yes'), $validate_vehicle],
            'vehicle_change_reason'     => ['nullable', 'string', 'max:255', Rule::requiredIf($request->change_vehicle === 'Yes')],
            'phone'                     => ['required', 'digits:10', $validate_phone],
            'whatsapp'                  => ['nullable', 'digits:10'],
            'dob'                       => 'nullable|date_format:Y-m-d',
            'doj'                       => 'required|date|before_or_equal:today',
            'blood_group'               => 'nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'religion_id'               => 'nullable|exists:religions,id',

            'driving_licence_no'        => ['required', 'string', 'max:255', Rule::unique('driverinfos', 'driving_licence_no')->ignore(optional($driverinfo)->id)->whereNull('deleted_at')],
            'licence_issue_date'        => 'required|date_format:Y-m-d',
            'licence_expiry_date'       => 'required|date_format:Y-m-d',
            'original_licence_location' => 'required|string|max:255',
            'driving_license_proof_file'=> 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'aadhaar_no'                => 'required|string|max:255',
            'aadhaar_card_proof_file'   => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'signed_driver_form_file'   => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',

            'status'                    => 'nullable|in:Active,Inactive,Blacklisted',
            'blacklist_reason'          => 'required_if:status,Blacklisted',
            'status_type'               => ['nullable', 'required_if:status,Inactive', 'in:On Leave,Voluntary Exit'],
            'expected_return_date'      => ['nullable', 'date_format:Y-m-d', 'required_if:status_type,On Leave'],
            'set_reminder'              => ['nullable', 'in:Yes,No'],
            'voluntary_exit_reason'     => ['nullable', Rule::requiredIf($request->status === 'Inactive' && $request->status_type === 'Voluntary Exit')],
            'vehicle_photos'            => ['nullable', 'array'],
            'vehicle_photos.*'          => 'image|mimes:jpg,jpeg,png|max:2048',
            'rag_status'                => 'nullable|in:Red,Yellow,Green',

            'hisab_category'            => 'nullable|in:Fixed,Fuel',
            'opening_balance_date'      => 'nullable|date_format:Y-m-d',
            'opening_balance_type'      => 'nullable|in:Credit,Debit',
            'opening_balance'           => 'nullable|numeric|min:0',
            'guarantor_name'            => 'nullable|string|max:255',
            'guarantor_phone'           => 'nullable|digits:10',
            'contact_comment'           => 'nullable|string|max:255',

            'primary_bank'              => 'required',
            'bank_id'                   => 'required|array|min:1',
            'bank_id.*'                 => 'required|exists:banks,id',
            'beneficiary_name.*'        => 'nullable|string|max:255',
            'account_number'            => 'required|array|min:1',
            'account_number.*'          => 'required|string|max:50',
            'ifsc_code'                 => 'required|array|min:1',
            'ifsc_code.*'               => 'required|string|max:20',
            'upi_id.*'                  => 'nullable|string|max:100',

            'contact_person_name'       => 'required|array|min:1',
            'contact_person_name.*'     => 'required|string|distinct|min:1',
            'contact_person_relation'   => 'required|array|min:1',
            'contact_person_relation.*' => 'required|string|min:1',
            'contact_person_blood_group.*' => 'nullable|string|min:1',
            'contact_person_address.*'  => 'nullable|string|min:1',
            'contact_person_phone'      => 'required|array|min:1',
            'contact_person_phone.*'    => ['required', 'string', 'distinct', $validate_cp_phone],
            'contact_person_whatsapp.*' => ['nullable', 'string', 'distinct', $validate_cp_phone],
            'contact_person_comment.*'  => 'nullable|string|min:1',

            'permanent_address'          => 'required|string|max:255',
            'permanent_addr_state_id'    => 'required|exists:states,id',
            'permanent_addr_city_id'     => 'nullable|exists:cities,id',
            'permanent_addr_postal_code' => 'required|digits:6',
            'present_address'            => 'required|string|max:255',
            'present_addr_state_id'      => 'required|exists:states,id',
            'present_addr_city_id'       => 'nullable|exists:cities,id',
            'present_addr_postal_code'   => 'required|digits:6',
        ], [
            'required'        => 'This field is required.',
            'max'             => 'Maximum :max characters allowed.',
            'exists'          => "This field's value is invalid.",
            'distinct'        => 'Duplicate value.',
            'phone.digits'    => 'This field must contain 10 digits.',
            'whatsapp.digits' => 'This field must contain 10 digits.',
            'primary_bank.required'                   => 'At least one bank must be marked as Primary.',
            'doj.required'                            => 'Date of Joining is required.',
            'doj.before_or_equal'                     => 'Date of Joining cannot be a future date.',
            'dob.date_format'                         => 'Date of Birth must be in YYYY-MM-DD format.',
            'permanent_addr_postal_code.required'     => 'Permanent Address Postal Code is required.',
            'permanent_addr_postal_code.digits'       => 'Permanent Address Postal Code must be 6 digits.',
            'present_addr_postal_code.required'       => 'Present Address Postal Code is required.',
            'present_addr_postal_code.digits'         => 'Present Address Postal Code must be 6 digits.',
            'driving_licence_no.unique'               => 'This driving licence number is already registered.',
        ]);

        $errorcount = 0;
        $errors = [];
        $attachtype_ids = $contact->coattachments->pluck('coattachtype_id')->toArray();
        $attachtypes = $request->attachtypes ?? [];
        $filesInput  = $request->file('files') ?? [];
        $max = max(count($attachtypes), count($filesInput));
        for ($key = 0; $key < $max; $key++) {
            $attachtype = $attachtypes[$key] ?? null;
            $files      = $filesInput[$key] ?? null;
            if (empty($attachtype) && empty($files)) { continue; }
            if (!empty($files) && empty($attachtype)) { $errorcount++; $errors['coattachtype_' . $key] = ['Document type is required.']; continue; }
            if (!empty($attachtype) && empty($files)) { $errorcount++; $errors['coattachments_' . $key] = ['Please upload file.']; continue; }
            if (!empty($attachtype_ids) && in_array($attachtype, $attachtype_ids)) { $errorcount++; $errors['coattachtype_' . $key] = ['You have already added this attachment type.']; continue; }
            $attachtype_ids[] = $attachtype;
            if (!empty($files)) {
                if (count($files) > 2) { $errorcount++; $errors['coattachments_' . $key] = ['You cannot upload more than 2 files.']; }
                foreach ($files as $file) {
                    $extension = strtolower($file->getClientOriginalExtension());
                    if (!in_array($extension, ['jpg', 'jpeg', 'png', 'pdf'])) { $errorcount++; $errors['coattachments_' . $key] = ['File type must be jpg, jpeg, png or pdf.']; }
                    if ($file->getSize() > 2097152) { $errorcount++; $errors['coattachments_' . $key] = ['File size must not exceed 2MB.']; }
                }
            }
        }

        $errormessages = array_merge($validator->getMessageBag()->toArray(), $errors);
        if ($validator->fails() || $errorcount > 0) {
            return response()->json(['success' => false, 'data' => $errormessages, 'message' => 'Please check validation error.'], 422);
        }

        try {
            DB::transaction(function () use ($request, $contact, $driverinfo) {
                $phoneCode  = getPhoneCode();
                $uploadPath = public_path('media' . DIRECTORY_SEPARATOR . 'contact');
                if (!File::exists($uploadPath)) { File::makeDirectory($uploadPath, 0755, true); }

                $imageName = $contact->contact_image;
                if ($request->hasFile('contact_image')) {
                    if (!empty($contact->contact_image)) {
                        $old = $uploadPath . DIRECTORY_SEPARATOR . $contact->contact_image;
                        if (File::exists($old)) { File::delete($old); }
                    }
                    $f = $request->file('contact_image');
                    $imageName = 'driver_' . time() . '_' . Str::random(6) . '.' . $f->getClientOriginalExtension();
                    $f->move($uploadPath, $imageName);
                }

                $contact->contact_name    = $request->contact_name;
                $contact->contact_code    = $request->contact_code;
                $contact->ph_prefix       = $request->phone_code ?? $phoneCode;
                $contact->phone           = $request->phone;
                $contact->whatsapp_prefix = $request->whatsapp_code ?? $phoneCode;
                $contact->whatsapp        = $request->whatsapp;
                $contact->contact_image   = $imageName;
                $contact->dob             = $request->dob;
                $contact->blood_group     = $request->blood_group;
                $contact->religion_id     = $request->religion_id;
                $contact->doj             = $request->doj;
                $contact->status          = $request->status ?? 'Active';
                $contact->blacklist_reason = $request->blacklist_reason ?? null;
                $contact->blacklisted_at   = $request->status === 'Blacklisted' ? now() : null;
                $contact->rag_status      = $request->rag_status;
                $contact->comment         = $request->contact_comment;
                $contact->updated_by      = Auth::user()->id;
                $contact->save();

                if ($request->status === 'Blacklisted' && $request->filled('blacklist_reason')) {
                    $activity = new Contactactivity();
                    $activity->contact_id     = $contact->id;
                    $activity->notes          = $request->blacklist_reason;
                    $activity->is_blacklisted = 'Yes';
                    $activity->created_by     = Auth::user()->id;
                    $activity->save();
                }

                // Vehicle change
                if ($request->change_vehicle === 'Yes') {
                    Vehicleallocation::where('contact_id', $contact->id)->where('type', 'Driver')->delete();
                    $alloc = new Vehicleallocation;
                    $alloc->contact_id            = $contact->id;
                    $alloc->type                  = 'Driver';
                    $alloc->vehicle_id            = $request->vehicle_id;
                    $alloc->change_vehicle        = 'Yes';
                    $alloc->vehicle_change_reason = $request->vehicle_change_reason;
                    $alloc->km_allowed            = 0;
                    $alloc->fixed_amount          = 0;
                    $alloc->extra_amount_per_km   = 0;
                    $alloc->start_date            = null;
                    $alloc->end_date              = null;
                    $alloc->created_by            = Auth::user()->id;
                    $alloc->save();
                }

                // driverinfo upsert
                $info = $driverinfo ?: new Driverinfo;
                $info->contact_id = $contact->id;
                $info->category                 = $request->driver_category;
                $info->driving_licence_no       = $request->driving_licence_no;
                $info->licence_issue_date       = $request->licence_issue_date;
                $info->licence_expiry_date      = $request->licence_expiry_date;
                $info->original_licence_location = $request->original_licence_location;
                if ($request->hasFile('driving_license_proof_file')) {
                    if (!empty($info->driving_license_proof_file)) {
                        $old = $uploadPath . DIRECTORY_SEPARATOR . $info->driving_license_proof_file;
                        if (File::exists($old)) { File::delete($old); }
                    }
                    $f = $request->file('driving_license_proof_file');
                    $n = 'driving_license_' . time() . '_' . Str::random(6) . '.' . $f->getClientOriginalExtension();
                    $f->move($uploadPath, $n);
                    $info->driving_license_proof_file = $n;
                }
                if ($request->hasFile('aadhaar_card_proof_file')) {
                    if (!empty($info->aadhaar_card_proof_file)) {
                        $old = $uploadPath . DIRECTORY_SEPARATOR . $info->aadhaar_card_proof_file;
                        if (File::exists($old)) { File::delete($old); }
                    }
                    $f = $request->file('aadhaar_card_proof_file');
                    $n = 'aadhaar_card_' . time() . '_' . Str::random(6) . '.' . $f->getClientOriginalExtension();
                    $f->move($uploadPath, $n);
                    $info->aadhaar_card_proof_file = $n;
                }
                if ($request->hasFile('signed_driver_form_file')) {
                    if (!empty($info->signed_driver_form_file)) {
                        $old = $uploadPath . DIRECTORY_SEPARATOR . $info->signed_driver_form_file;
                        if (File::exists($old)) { File::delete($old); }
                    }
                    $f = $request->file('signed_driver_form_file');
                    $n = 'signed_driver_form_' . time() . '_' . Str::random(6) . '.' . $f->getClientOriginalExtension();
                    $f->move($uploadPath, $n);
                    $info->signed_driver_form_file = $n;
                }
                $info->aadhaar_no            = $request->aadhaar_no;
                $info->status_type           = $request->status_type;
                $info->expected_return_date  = $request->expected_return_date;
                $info->set_reminder          = $request->set_reminder;
                $info->voluntary_exit_reason = $request->voluntary_exit_reason;
                $info->hisab_category        = $request->hisab_category;
                $info->opening_balance_date  = $request->opening_balance_date;
                $info->opening_balance_type  = $request->opening_balance_type;
                $info->opening_balance       = $request->opening_balance;
                $info->guarantor_name        = $request->guarantor_name;
                $info->guarantor_phone_code  = $request->guarantor_phone_code ?? $phoneCode;
                $info->guarantor_phone       = $request->guarantor_phone;
                $info->save();

                // New vehicle handover photos
                if ($request->hasFile('vehicle_photos')) {
                    foreach ($request->file('vehicle_photos') as $photo) {
                        $pName = 'vehicle_photo_' . time() . '_' . Str::random(6) . '.' . $photo->getClientOriginalExtension();
                        $photo->move($uploadPath, $pName);
                        $vp = new Drivervehiclephoto;
                        $vp->contact_id = $contact->id;
                        $vp->file_name  = $pName;
                        $vp->save();
                    }
                }

                // Emergency contacts — delete + re-create
                Relcontact::where('contact_id', $contact->id)->delete();
                $names = $request->get('contact_person_name', []);
                for ($i = 0; $i < count($names); $i++) {
                    $name  = $names[$i] ?? null;
                    $phone = $request->get('contact_person_phone')[$i] ?? null;
                    if (empty($name) && empty($phone)) { continue; }
                    $rc = new Relcontact;
                    $rc->contact_id      = $contact->id;
                    $rc->name            = $name;
                    $rc->relationship    = $request->get('contact_person_relation')[$i] ?? null;
                    $rc->blood_group     = $request->get('contact_person_blood_group')[$i] ?? null;
                    $rc->address         = $request->get('contact_person_address')[$i] ?? null;
                    $rc->ph_prefix       = $request->get('contact_person_ph_code')[$i] ?? $phoneCode;
                    $rc->phone           = $phone;
                    $rc->whatsapp_prefix = $request->get('contact_person_whatsapp_code')[$i] ?? $phoneCode;
                    $rc->whatsapp        = $request->get('contact_person_whatsapp')[$i] ?? null;
                    $rc->comment         = $request->get('contact_person_comment')[$i] ?? null;
                    $rc->created_by      = Auth::user()->id;
                    $rc->save();
                }

                // Addresses (E5) — delete + re-create
                Coaddress::where('contact_id', $contact->id)->whereIn('type', ['Permanent', 'Present'])->delete();
                if (!empty($request->permanent_address) || !empty($request->permanent_addr_state_id) || !empty($request->permanent_addr_postal_code)) {
                    $a = new Coaddress;
                    $a->contact_id = $contact->id; $a->type = 'Permanent';
                    $a->address = $request->permanent_address; $a->state_id = $request->permanent_addr_state_id;
                    $a->city_id = $request->permanent_addr_city_id; $a->zipcode = $request->permanent_addr_postal_code;
                    $a->additional_info = $request->permanent_addr_additional_info;
                    $a->save();
                }
                if (!empty($request->present_address) || !empty($request->present_addr_state_id) || !empty($request->present_addr_postal_code)) {
                    $a = new Coaddress;
                    $a->contact_id = $contact->id; $a->type = 'Present';
                    $a->address = $request->present_address; $a->state_id = $request->present_addr_state_id;
                    $a->city_id = $request->present_addr_city_id; $a->zipcode = $request->present_addr_postal_code;
                    $a->additional_info = $request->present_addr_additional_info;
                    $a->save();
                }

                // Bank details (E3) — upsert by contact_bank_id[], delete removed, one primary
                $bankIds       = $request->get('bank_id', []);
                $bankRowIds    = $request->get('contact_bank_id', []);
                $primaryIdx    = $request->get('primary_bank');
                $keptBankIds   = [];
                foreach ($bankIds as $i => $bankId) {
                    if (empty($bankId)) { continue; }
                    $rowId = $bankRowIds[$i] ?? null;
                    $b = $rowId ? Contactbank::where('id', $rowId)->where('contact_id', $contact->id)->first() : null;
                    if (!$b) { $b = new Contactbank; $b->contact_id = $contact->id; }
                    $b->bank_id          = $bankId;
                    $b->is_primary       = ((string) $i === (string) $primaryIdx) ? 'Yes' : 'No';
                    $b->beneficiary_name = $request->get('beneficiary_name')[$i] ?? null;
                    $b->account_number   = $request->get('account_number')[$i] ?? null;
                    $b->ifsc_code        = $request->get('ifsc_code')[$i] ?? null;
                    $b->upi_id           = $request->get('upi_id')[$i] ?? null;
                    $b->save();
                    $keptBankIds[] = $b->id;
                }
                Contactbank::where('contact_id', $contact->id)->whereNotIn('id', $keptBankIds)->delete();

                // Attachments (append new)
                $attachtypes = $request->attachtypes;
                if (!empty($attachtypes)) {
                    foreach ($attachtypes as $key => $attachtype) {
                        if (isset($request->file('files')[$key])) {
                            foreach ($request->file('files')[$key] as $file) {
                                $extension = $file->getClientOriginalExtension();
                                $fname = 'contact-attachment-' . Str::random(4) . '_' . time() . '.' . $extension;
                                $__fsize = $file->getSize(); $__foname = $file->getClientOriginalName();
                                $file->move($uploadPath, $fname);
                                $att = new Coattachment;
                                $att->name            = $fname;
                                $att->original_name   = $__foname;
                                $att->file_size       = ($__fsize / (1024 * 1024));
                                $att->coattachtype_id = $attachtype;
                                $att->created_by      = Auth::id();
                                $att->contact_id      = $contact->id;
                                $att->save();
                            }
                        }
                    }
                }

                $this->storeUseractivity(3, 4, Auth::user()->id, $contact->id, 'Driver Updated [ID: ' . $contact->id . '].');

                return $contact;
            });

            return response()->json(['success' => true, 'data' => $contact, 'message' => 'Driver updated successfully.', 'redirect' => route('contact.v2.driver.show', $contact->id)], 200);
        } catch (\Exception $exp) {
            return response()->json(['success' => false, 'data' => [], 'message' => $exp->getMessage()], 500);
        }
    }

    /* ===============================================================
     | Joining / Work Experience  (← storeDriverWorkExperience)
     | =============================================================== */
    public function storeWorkExperience(Request $request)
    {
        $contact = Contact::where('cotype_id', self::COTYPE)->find($request->contact_id);
        if (!$contact) {
            return response()->json(['success' => false, 'data' => [], 'message' => 'Driver not found!'], 422);
        }
        if ($this->driverExited($contact)) {
            return response()->json(['success' => false, 'message' => 'This driver has exited — work experience records cannot be added.'], 422);
        }

        $validator = Validator::make($request->all(), [
            'contact_id'            => 'required|exists:contacts,id',
            'previous_company_name' => 'required|max:255',
            'previous_designation'  => 'required|max:255',
            'previous_employment_duration' => ['required', function ($attribute, $value, $fail) use ($request) {
                $dates = explode(' - ', $value);
                if (count($dates) !== 2) { $fail('The employment duration format is invalid.'); return; }
                try {
                    $start = Carbon::createFromFormat('d/m/Y', trim($dates[0]))->format('Y-m-d');
                    $end   = Carbon::createFromFormat('d/m/Y', trim($dates[1]))->format('Y-m-d');
                } catch (\Exception $e) {
                    $fail('The employment duration contains invalid dates.'); return;
                }
                if ($end > date('Y-m-d')) { $fail('The end date cannot be a future date.'); }
                if ($start > $end) { $fail('The start date cannot be after the end date.'); }
                $exists = Employeeworkexperience::where('contact_id', $request->contact_id)
                            ->where('employment_start_date', '<=', $end)
                            ->where('employment_end_date', '>=', $start)
                            ->exists();
                if ($exists) { $fail('This employment period overlaps with an existing experience.'); }
            }],
            'previous_exit_reason'        => 'required|max:500',
            'previous_salary'             => 'required|numeric|min:1',
            'experience_category'         => 'required|in:Line,Local',
            'previous_legal_case'         => 'required|in:Yes,No',
            'previous_legal_case_comment' => 'required_if:previous_legal_case,Yes',
            'previous_city_id'            => 'required_if:previous_legal_case,Yes|nullable|exists:cities,id',
            'previous_police_station'     => 'required_if:previous_legal_case,Yes|nullable|string|max:255',
            'previous_notes'              => 'required',
        ], [
            'required' => 'This field is required.',
            'numeric'  => 'Only numeric values are allowed.',
            'min'      => 'Value must be at least :min.',
            'in'       => 'Invalid selection.',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'data' => $validator->errors(), 'message' => 'Please check validation errors.'], 422);
        }

        try {
            $exp = DB::transaction(function () use ($request) {
                $dates = explode(' - ', $request->previous_employment_duration);
                $startDate = Carbon::createFromFormat('d/m/Y', trim($dates[0]))->format('Y-m-d');
                $endDate   = Carbon::createFromFormat('d/m/Y', trim($dates[1]))->format('Y-m-d');

                $w = new Employeeworkexperience;
                $w->contact_id            = $request->contact_id;
                $w->experience_category   = $request->experience_category;
                $w->previous_company_name = $request->previous_company_name;
                $w->designation           = $request->previous_designation;
                $w->employment_start_date = $startDate;
                $w->employment_end_date   = $endDate;
                $w->exit_reason           = $request->previous_exit_reason;
                $w->salary                = $request->previous_salary;
                $w->any_legal_case        = $request->previous_legal_case;
                $w->comment_about_case    = $request->previous_legal_case_comment;
                $w->city_id               = $request->previous_city_id;
                $w->police_station        = $request->previous_police_station;
                $w->notes                 = $request->previous_notes;
                $w->created_by            = Auth::user()->id;
                $w->save();
                $this->storeUseractivity(52, 3, Auth::user()->id, $w->id, 'Driver [ID: ' . $request->contact_id . '] work experience added.');
                return $w;
            });

            return response()->json(['success' => true, 'data' => $exp, 'message' => 'Work experience added successfully.'], 200);
        } catch (\Exception $exp) {
            return response()->json(['success' => false, 'data' => [], 'message' => $exp->getMessage()], 500);
        }
    }

    /* ===============================================================
     | Assets — issue / revoke  (mirror Employee V2 storeAsset/revokeAsset)
     | =============================================================== */
    public function storeAsset(Request $request)
    {
        $contact = Contact::where('cotype_id', self::COTYPE)->find($request->contact_id);
        if (!$contact) {
            return response()->json(['success' => false, 'data' => [], 'message' => 'Driver not found!'], 422);
        }
        if ($this->driverExited($contact)) {
            return response()->json(['success' => false, 'message' => 'This driver has exited — assets cannot be assigned.'], 422);
        }

        $validator = Validator::make($request->all(), [
            'contact_id' => 'required|exists:contacts,id',
            'asset_id'   => 'required|exists:assets,id',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'data' => $validator->errors(), 'message' => 'Please check validation errors.'], 422);
        }

        $already = Employeeasset::where('contact_id', $request->contact_id)->where('asset_id', $request->asset_id)->where('status', 'Assigned')->exists();
        if ($already) {
            return response()->json(['success' => false, 'message' => 'This asset is already assigned to this driver.'], 422);
        }

        try {
            $empasset = DB::transaction(function () use ($request) {
                $existing = Employeeasset::where('contact_id', $request->contact_id)->where('asset_id', $request->asset_id)->where('status', 'Unassigned')->first();
                if ($existing) {
                    $existing->status      = 'Assigned';
                    $existing->revoke_date = null;
                    $existing->comment     = 'Reassigned asset.';
                    $existing->created_by  = Auth::user()->id;
                    $existing->save();
                    $empasset = $existing;
                } else {
                    $empasset = new Employeeasset;
                    $empasset->contact_id = $request->contact_id;
                    $empasset->asset_id   = $request->asset_id;
                    $empasset->status     = 'Assigned';
                    $empasset->comment    = 'Condition is okay.';
                    $empasset->created_by = Auth::user()->id;
                    $empasset->save();
                }
                $this->storeUseractivity(51, 3, Auth::user()->id, $empasset->id, 'Asset [ID: ' . $request->asset_id . '] assigned to Driver [ID: ' . $request->contact_id . ']');
                return $empasset;
            });

            return response()->json(['success' => true, 'data' => $empasset, 'message' => 'Asset assigned successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function revokeAsset(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'employeeasset_id' => 'required|exists:employeeassets,id',
            'revoke_date'      => 'required|date',
            'revoke_reason'    => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'data' => $validator->errors(), 'message' => 'Please check validation errors.'], 422);
        }

        $asset = Employeeasset::find($request->employeeasset_id);
        if (!$asset || $asset->status !== 'Assigned') {
            return response()->json(['success' => false, 'message' => 'Asset is already revoked or not found.'], 422);
        }

        try {
            $result = DB::transaction(function () use ($request, $asset) {
                $asset->status      = 'Unassigned';
                $asset->revoke_date = $request->revoke_date;
                $asset->comment     = $request->revoke_reason;
                $asset->save();

                $log = new Employeeallotedassetlog;
                $log->employeeasset_id = $asset->id;
                $log->contact_id       = $asset->contact_id;
                $log->asset_id         = $asset->asset_id;
                $log->status           = 'Unassigned';
                $log->revoke_date      = $request->revoke_date;
                $log->comment          = $request->revoke_reason;
                $log->created_by       = Auth::user()->id;
                $log->save();

                $this->storeUseractivity(51, 3, Auth::user()->id, $asset->id, 'Asset [ID: ' . $asset->asset_id . '] revoked from Driver [ID: ' . $asset->contact_id . ']');
                return $asset;
            });

            return response()->json(['success' => true, 'data' => $result, 'message' => 'Asset revoked successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /* ===============================================================
     | Exit  (← storeDriverExitDetails)  — sets E2 $isExited
     | =============================================================== */
    public function storeExit(Request $request)
    {
        $doj = Contact::where('id', $request->contact_id)->value('doj');
        $exitDateRules = ['required', 'date', 'before_or_equal:today'];
        if ($doj) {
            $exitDateRules[] = 'after_or_equal:' . Carbon::parse($doj)->format('Y-m-d');
        }

        $validator = Validator::make($request->all(), [
            'contact_id'    => 'required|exists:contacts,id',
            'exit_reason'   => 'required|string',
            'exit_date'     => $exitDateRules,
            'exit_feedback' => 'required|string',
        ], [
            'required' => 'This field is required.',
            'exit_date.after_or_equal' => 'Exit date cannot be before the joining date.',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'data' => $validator->errors(), 'message' => 'Please check validation errors.'], 422);
        }

        if (Employeeexitdetail::where('contact_id', $request->contact_id)->exists()) {
            return response()->json(['success' => false, 'message' => 'Exit details already exist for this driver.'], 422);
        }

        try {
            $exitDetails = DB::transaction(function () use ($request) {
                $x = new Employeeexitdetail();
                $x->contact_id  = $request->contact_id;
                $x->exit_reason = $request->exit_reason;
                $x->exit_date   = $request->exit_date;
                $x->feedback    = $request->exit_feedback;
                $x->created_by  = Auth::user()->id;
                $x->save();
                $this->storeUseractivity(3, 3, Auth::user()->id, $request->contact_id, 'Driver [ID: ' . $request->contact_id . '] exit details recorded.');
                return $x;
            });

            return response()->json(['success' => true, 'data' => $exitDetails, 'message' => 'Exit detail saved successfully.'], 200);
        } catch (\Exception $exp) {
            return response()->json(['success' => false, 'data' => [], 'message' => $exp->getMessage()], 500);
        }
    }

    /* ===============================================================
     | E1 letter seen-status  (← updateDriverLetterSeenStatus)
     | =============================================================== */
    public function updateLetterSeenStatus(Request $request)
    {
        $contact = Contact::find($request->contact_id);
        if (!$contact) {
            return response()->json(['status' => false, 'message' => 'Driver not found.'], 422);
        }

        try {
            if ($request->type === 'joining-letter') {
                $contact->joining_letter_seen_status = $request->seen_status;
            }
            if ($request->type === 'exit-letter') {
                $contact->exit_letter_seen_status = $request->seen_status;
            }
            $contact->save();

            return response()->json(['status' => true, 'message' => 'Seen status updated successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Something went wrong.', 'error' => $e->getMessage()], 500);
        }
    }

    /* ===============================================================
     | Documents — attachment store / delete
     | =============================================================== */
    public function storeAttachment(Request $request)
    {
        $contact = Contact::where('cotype_id', self::COTYPE)->find($request->contact_id);
        if (!$contact) {
            return response()->json(['success' => false, 'message' => 'Driver not found.'], 422);
        }
        if ($this->driverExited($contact)) {
            return response()->json(['success' => false, 'message' => 'This driver has exited — documents cannot be uploaded.'], 422);
        }

        $validator = Validator::make($request->all(), [
            'contact_id'      => 'required|exists:contacts,id',
            'coattachtype_id' => 'required|exists:coattachtypes,id',
            'files'           => 'required|array|min:1|max:2',
            'files.*'         => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ], [
            'required'         => 'This field is required.',
            'files.max'        => 'You cannot upload more than 2 files.',
            'files.*.mimes'    => 'Document must be a jpg, jpeg, png, or pdf file.',
            'files.*.max'      => 'Document must not exceed 2 MB.',
            'files.*.uploaded' => 'Document upload failed — file may exceed the 2 MB server limit.',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'data' => $validator->errors(), 'message' => 'Please check validation errors.'], 422);
        }

        try {
            $saved = DB::transaction(function () use ($request, $contact) {
                $uploadPath = public_path('media' . DIRECTORY_SEPARATOR . 'contact');
                if (!File::exists($uploadPath)) { File::makeDirectory($uploadPath, 0755, true); }
                $records = [];
                foreach ($request->file('files') as $file) {
                    $extension = $file->getClientOriginalExtension();
                    $fname = 'contact-attachment-' . Str::random(4) . '_' . time() . '.' . $extension;
                    $__fsize = $file->getSize(); $__foname = $file->getClientOriginalName();
                    $file->move($uploadPath, $fname);
                    $att = new Coattachment;
                    $att->name            = $fname;
                    $att->original_name   = $__foname;
                    $att->file_size       = ($__fsize / (1024 * 1024));
                    $att->coattachtype_id = $request->coattachtype_id;
                    $att->created_by      = Auth::id();
                    $att->contact_id      = $contact->id;
                    $att->save();
                    $records[] = $att;
                }
                $this->storeUseractivity(3, 3, Auth::user()->id, $contact->id, 'Driver [ID: ' . $contact->id . '] document uploaded.');
                return $records;
            });

            return response()->json(['success' => true, 'data' => $saved, 'message' => 'Document uploaded successfully.'], 200);
        } catch (\Exception $exp) {
            return response()->json(['success' => false, 'data' => [], 'message' => $exp->getMessage()], 500);
        }
    }

    public function deleteAttachment(Request $request)
    {
        $attachment = Coattachment::find($request->id);
        if (!$attachment) {
            return response()->json(['success' => false, 'message' => 'Document not found.'], 422);
        }

        $contact = Contact::where('cotype_id', self::COTYPE)->find($attachment->contact_id);
        if ($contact && $this->driverExited($contact)) {
            return response()->json(['success' => false, 'message' => 'This driver has exited — documents cannot be deleted.'], 422);
        }

        try {
            DB::transaction(function () use ($attachment) {
                $path = public_path('media' . DIRECTORY_SEPARATOR . 'contact' . DIRECTORY_SEPARATOR . $attachment->name);
                if ($attachment->name && File::exists($path)) { File::delete($path); }
                $attachment->delete();
                return $attachment;
            });

            return response()->json(['success' => true, 'message' => 'Document deleted successfully.'], 200);
        } catch (\Exception $exp) {
            return response()->json(['success' => false, 'message' => $exp->getMessage()], 500);
        }
    }

    /* ===============================================================
     | Activity — note store
     | =============================================================== */
    public function storeActivityNote(Request $request)
    {
        $contact = Contact::where('cotype_id', self::COTYPE)->find($request->contact_id);
        if (!$contact) {
            return response()->json(['success' => false, 'message' => 'Driver not found.'], 422);
        }

        $validator = Validator::make($request->all(), [
            'contact_id' => 'required|exists:contacts,id',
            'notes'      => 'required|string|max:5000',
        ], [
            'required' => 'This field is required.',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'data' => $validator->errors(), 'message' => 'Please check validation errors.'], 422);
        }

        try {
            $activity = DB::transaction(function () use ($request, $contact) {
                $a = new Contactactivity();
                $a->contact_id = $contact->id;
                $a->notes      = $request->notes;
                $a->created_by = Auth::user()->id;
                $a->save();
                return $a;
            });

            return response()->json(['success' => true, 'data' => $activity, 'message' => 'Activity note added successfully.'], 200);
        } catch (\Exception $exp) {
            return response()->json(['success' => false, 'data' => [], 'message' => $exp->getMessage()], 500);
        }
    }

    /* ===============================================================
     | List delete (soft) — single
     | =============================================================== */
    public function destroy(Request $request)
    {
        $contact = Contact::where('cotype_id', self::COTYPE)->find($request->id);
        if (!$contact) {
            return response()->json(['success' => false, 'message' => 'Driver not found.'], 422);
        }

        try {
            DB::transaction(function () use ($contact) {
                $contact->delete();
                $this->storeUseractivity(3, 6, Auth::user()->id, $contact->id, 'Driver [ID: ' . $contact->id . '] deleted.');
                return $contact;
            });

            return response()->json(['success' => true, 'message' => 'Driver deleted successfully.'], 200);
        } catch (\Exception $exp) {
            return response()->json(['success' => false, 'message' => $exp->getMessage()], 500);
        }
    }
}
