<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Gsttreat;
use App\Models\Cotype;
use App\Models\Contact;
use App\Models\Coattachtype;
use App\Models\Coattachment;
use App\Models\Relcontact;
use App\Models\Contactbank;
use App\Models\Contactactivity;
use App\Models\Bank;
use App\Models\Panstatus;
use App\Models\Tyre;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Str;
use Closure;

use App\Traits\Useractivity;

/**
 * Tyre Vendor Module V2 - Controller (Gate 2: live Eloquent wiring).
 *
 * Wires the approved Gate-1 design to the EXISTING tables via Eloquent - NO schema change.
 * Mirrors the V1 ContactController tyre-vendor methods (tyreVendorList / createTyreVendor /
 * storeTyreVendor / editTyreVendor / updateTyreVendor / tyrevendor_* wrappers) and the
 * Tyre listing (Tyre where contact_id). cotype_id = 6. Activity audit actmodel = 59.
 *
 * Extensions (V2-redesign-pattern.md):
 *   E3 bank-details repeater | E4 "Tyre" supplied-items sub-page |
 *   E6 TDS Declaration (coattachtype_id = 7) mandatory when tds_percentage is 0 or 1 |
 *   E7 NO size field anywhere.
 *
 * SD-1..13 enforced: Eloquent only, find() (not findOrFail) in JSON, status codes on every
 * json(), DB::transaction with try/catch + return, organisation_id always set.
 */
class TyreVendorController extends Controller
{
    use Useractivity;

    private const COTYPE   = 6;  // CONTACT_TYPE_TYRE_VENDOR
    private const ACTMODEL = 59; // tyre vendor activity model id
    private const TDS_DECLARATION_TYPE = 7; // coattachtypes.id - TDS Declaration

    /* ===============================================================
     | Helpers - shape + counts + lookups
     | =============================================================== */

    /** Primary bank summary e.g. "State Bank of India | ****8842". */
    private function primaryBankLabel(Contact $c): string
    {
        $rows = $c->relationLoaded('bankDetails') ? $c->bankDetails : $c->bankDetails()->with('bank')->get();
        $primary = $rows->firstWhere('is_primary', 'Yes') ?? $rows->first();
        if (! $primary) {
            return '-';
        }
        $bankName = optional($primary->bank)->name ?? 'Bank';
        $acc      = $primary->account_number ? '****' . substr($primary->account_number, -4) : '';
        return trim($bankName . ($acc ? ' | ' . $acc : ''));
    }

    /** Map a tyre-vendor Contact into the Gate-1 array shape the blades consume ($v). */
    private function shapeVendor(Contact $c): array
    {
        return [
            'id'             => $c->id,
            'contactno'      => $c->contactno,
            'company'        => $c->company_name ?: ($c->contact_name ?: '-'),
            'name'           => $c->contact_name ?: '-',
            'code'           => $c->contact_code ?: '-',
            'phone'          => trim(($c->ph_prefix ? $c->ph_prefix . ' ' : '') . $c->phone),
            'whatsapp'       => trim(($c->whatsapp_prefix ? $c->whatsapp_prefix . ' ' : '') . $c->whatsapp),
            'email'          => optional($c->relcontacts->first())->email ?? '-',
            'city'           => optional($c->city)->name ?? '-',
            'gst'            => $c->gst_number ?: '-',
            'gst_treatment'  => $c->gst_treatment ?: '-',
            'tds'            => is_null($c->tds_percentage) ? 0 : (float) $c->tds_percentage,
            'tyres'          => Tyre::where('contact_id', $c->id)->count(),
            'status'         => $c->status ?? 'Active',
            'primary_bank'   => $this->primaryBankLabel($c),
        ];
    }

    /** Per-tab counts (real Eloquent counts). */
    private function tabCounts(Contact $c): array
    {
        return [
            'documents' => $c->coattachments()->count(),
            'tyres'     => Tyre::where('contact_id', $c->id)->count(),
            'activity'  => $c->activities()->count(),
        ];
    }

    /** Resolve a tyre-vendor Contact or abort 404 (GET screens only). */
    private function findVendorOrFail($id): Contact
    {
        return Contact::where('cotype_id', self::COTYPE)->findOrFail($id);
    }

    /**
     * B9 - server-side write-lock. A Blacklisted vendor is locked for all writes.
     * Inactive stays writable; reads are never blocked. Passing $newStatus allows
     * the un-blacklist transition (existing Blacklisted -> a non-Blacklisted status).
     * Returns a 422 JSON response to short-circuit the caller, or null.
     */
    private function blockIfWriteLocked(?Contact $contact, ?string $newStatus = null)
    {
        if ($contact && $contact->status === 'Blacklisted') {
            if ($newStatus !== null && $newStatus !== 'Blacklisted') {
                return null; // allow un-blacklisting
            }
            return response()->json([
                'success' => false,
                'data'    => [],
                'message' => 'This vendor is Blacklisted and cannot be modified.',
            ], 422);
        }
        return null;
    }

    /** Dropdown lookups shared by create + edit. */
    private function formLookups(): array
    {
        $organisationId = Auth::user()->organisation_id ?? 1;

        return [
            'countries'     => Country::all(),
            'states'        => State::with(['cities' => fn ($q) => $q->orderBy('name')])
                                    ->whereHas('country', fn ($q) => $q->where('iso2', 'IN'))
                                    ->orderBy('name')->get(),
            'cities'        => City::whereHas('state.country', fn ($q) => $q->where('iso2', 'IN'))->orderBy('name')->get(),
            'gsttreats'     => Gsttreat::all(),
            'coattachtypes' => Coattachtype::all(),
            'banks'         => Bank::orderBy('name')->get(),
            'pan_statuses'  => Panstatus::where('organisation_id', $organisationId)->orderBy('name')->get(),
        ];
    }

    /* ===============================================================
     | Screens (public GET)
     | =============================================================== */

    public function dashboard()
    {
        $base = Contact::where('cotype_id', self::COTYPE);

        $total       = (clone $base)->count();
        $active      = (clone $base)->where('status', 'Active')->count();
        $inactive    = (clone $base)->where('status', 'Inactive')->count();
        $blacklisted = (clone $base)->where('status', 'Blacklisted')->count();

        $vendorIds     = (clone $base)->pluck('id');
        $tyresSupplied = Tyre::whereIn('contact_id', $vendorIds)->count();
        $tdsDue        = (clone $base)->whereIn('tds_percentage', [0, 1])->count();

        $recent = Contact::where('cotype_id', self::COTYPE)
                    ->with(['city', 'relcontacts', 'bankDetails.bank'])
                    ->orderByDesc('id')->limit(8)->get()
                    ->map(fn ($c) => $this->shapeVendor($c))->all();

        return view('V2.tyrevendor.dashboard', [
            'vendors' => $recent,
            'kpi'     => compact('total', 'active', 'inactive', 'blacklisted', 'tyresSupplied', 'tdsDue'),
        ]);
    }

    public function index(Request $request)
    {
        $search_name   = $request->name;
        $search_city   = $request->city;
        $search_status = $request->status;

        $query = Contact::where('cotype_id', self::COTYPE)
                    ->with(['cotype', 'city', 'relcontacts', 'bankDetails.bank']);

        if ($request->filled('name')) {
            $query->where(function ($q) use ($request) {
                $q->where('company_name', 'like', '%' . $request->name . '%')
                  ->orWhere('contact_name', 'like', '%' . $request->name . '%')
                  ->orWhere('contactno', 'like', '%' . $request->name . '%')
                  ->orWhere('gst_number', 'like', '%' . $request->name . '%');
            });
        }
        if ($request->filled('city')) {
            $query->where('city_id', $request->city);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        // E7 - NO size filter.

        $contacts = $query->orderByDesc('id')->paginate(10)->withQueryString();
        $contacts->getCollection()->transform(fn ($c) => $this->shapeVendor($c));

        $cities = City::whereHas('state.country', fn ($q) => $q->where('iso2', 'IN'))->orderBy('name')->get();

        $this->storeUseractivity(self::ACTMODEL, 5, Auth::user()->id, 0, 'Retrieve a tyre vendor list (V2).');

        return view('V2.tyrevendor.index', [
            'vendors'       => $contacts,
            'cities'        => $cities,
            'search_name'   => $search_name,
            'search_city'   => $search_city,
            'search_status' => $search_status,
        ]);
    }

    public function create()
    {
        $last     = Contact::where('cotype_id', self::COTYPE)->orderByDesc('id')->first();
        $tyreCode = 'TV-' . (($last ? $last->id : 0) + 1);

        return view('V2.tyrevendor.create', array_merge($this->formLookups(), [
            'tyreCode' => $tyreCode,
        ]));
    }

    public function show($id)
    {
        $contact = Contact::where('cotype_id', self::COTYPE)
                    ->with(['city', 'relcontacts', 'bankDetails.bank'])
                    ->findOrFail($id);

        $recentActivities = Contactactivity::with('createdBy')
                                ->where('contact_id', $contact->id)
                                ->orderByDesc('created_at')->take(5)->get();

        return view('V2.tyrevendor.show', [
            'v'                => $this->shapeVendor($contact),
            'counts'           => $this->tabCounts($contact),
            'active'           => 'overview',
            'contact'          => $contact,
            'recentActivities' => $recentActivities,
        ]);
    }

    public function edit($id)
    {
        $contact = Contact::with([
                        'country.states',
                        'state.cities',
                        'relcontacts' => fn ($q) => $q->orderBy('id', 'asc'),
                        'bankDetails.bank',
                        'coattachments.coattachtype',
                        'city',
                    ])
                    ->where('cotype_id', self::COTYPE)
                    ->findOrFail($id);

        $this->storeUseractivity(self::ACTMODEL, 5, Auth::user()->id, $contact->id, 'Retrieve a tyre vendor named ' . $contact->contact_name . ' to edit.');

        return view('V2.tyrevendor.edit', array_merge($this->formLookups(), [
            'v'        => $this->shapeVendor($contact),
            'counts'   => $this->tabCounts($contact),
            'active'   => 'edit',
            'contact'  => $contact,
        ]));
    }

    public function documents($id)
    {
        $contact = Contact::where('cotype_id', self::COTYPE)->with('city', 'relcontacts')->findOrFail($id);

        return view('V2.tyrevendor.documents', [
            'v'             => $this->shapeVendor($contact),
            'counts'        => $this->tabCounts($contact),
            'active'        => 'documents',
            'contact'       => $contact,
            'coattachments' => Coattachment::with('coattachtype')->where('contact_id', $contact->id)->latest()->get(),
            'coattachtypes' => Coattachtype::orderBy('name')->get(),
        ]);
    }

    public function tyre($id)
    {
        $contact = Contact::where('cotype_id', self::COTYPE)->with('city', 'relcontacts')->findOrFail($id);

        $tyres = Tyre::where('contact_id', $contact->id)->orderByDesc('id')->paginate(10, ['*'], 'tyre_page');

        return view('V2.tyrevendor.tyre', [
            'v'        => $this->shapeVendor($contact),
            'counts'   => $this->tabCounts($contact),
            'active'   => 'tyre',
            'contact'  => $contact,
            'tyres'    => $tyres,
        ]);
    }

    public function activity($id)
    {
        $contact = Contact::where('cotype_id', self::COTYPE)->with('city', 'relcontacts')->findOrFail($id);

        return view('V2.tyrevendor.activity', [
            'v'          => $this->shapeVendor($contact),
            'counts'     => $this->tabCounts($contact),
            'active'     => 'activity',
            'contact'    => $contact,
            'activities' => Contactactivity::with('createdBy')->where('contact_id', $contact->id)->orderByDesc('created_at')->get(),
        ]);
    }

    /* ===============================================================
     | Repeater wrappers (AJAX HTML fragments) - mirror V1 tyrevendor_*
     | =============================================================== */

    public function contactPersonWrapper(Request $request)
    {
        $rowindex = $request->get('rowindex');
        $html = view('contacts.contact-person-wrapper.tyrevendor-contact-person', compact('rowindex'))->render();

        return response()->json(['success' => true, 'data' => $html, 'message' => 'Tyre vendor contact person wrapper fetched.'], 200);
    }

    public function bankWrapper(Request $request)
    {
        $rowindex = $request->get('rowindex');
        $banks = Bank::orderBy('name')->get();
        $html = view('contacts.contact-bank-detail-wrapper.tyrevendor-bank-detail', compact('rowindex', 'banks'))->render();

        return response()->json(['success' => true, 'data' => $html, 'message' => 'Tyre vendor bank detail wrapper fetched.'], 200);
    }

    /* ===============================================================
     | Store  (mirrors storeTyreVendor)
     | =============================================================== */
    public function store(Request $request)
    {
        $request->merge([
            'phone'    => preg_replace('/\s+/', '', (string) $request->phone),
            'whatsapp' => preg_replace('/\s+/', '', (string) $request->whatsapp),
        ]);
        if ($request->has('contact_person_phone')) {
            $request->merge([
                'contact_person_phone' => array_map(fn ($p) => preg_replace('/\D/', '', (string) $p), $request->contact_person_phone ?? []),
            ]);
        }

        $validate_phone = function ($attribute, $value, $fail) {
            // B8 — match on the 10 digits regardless of prefix (blocks 91 vs +91 duplicates).
            if (Contact::where('phone', $value)->exists()) {
                $fail('This phone number already exists.');
            }
        };

        $validator = Validator::make($request->all(), $this->rules($validate_phone), $this->messages(), $this->attributes());

        $validator->after(function ($validator) use ($request) {
            $this->validatePrimaryBank($validator, $request);
            $this->validateTdsDeclarationOnCreate($validator, $request);
        });

        if ($validator->fails()) {
            return response()->json(['success' => false, 'data' => $validator->errors(), 'message' => 'Please check validation error.'], 422);
        }

        try {
            $contact = DB::transaction(function () use ($request) {

                $phoneCode = getPhoneCode();

                $lastcontact = Contact::withTrashed()->orderBy('id', 'DESC')->first();
                if ($lastcontact) {
                    $incr = $lastcontact->contactno + 1;
                    $contactno = strlen($incr) < 5 ? str_pad($incr, 6, '0', STR_PAD_LEFT) : $incr;
                } else {
                    $contactno = '000001';
                }

                $contact = new Contact;
                $contact->contactno       = $contactno;
                $contact->cotype_id       = self::COTYPE;
                $contact->organisation_id = Auth::user()->organisation_id ?? 1; // SD-11
                $contact->contact_name    = $request->get('contact_name');
                $contact->company_name    = $request->get('company_name');
                $contact->contact_code    = $request->get('contact_code');

                $contact->ph_prefix       = $request->phone_code ?? $phoneCode;
                $contact->phone           = $request->get('phone');
                $contact->whatsapp_prefix = $request->whatsapp_code ?? $phoneCode;
                $contact->whatsapp        = $request->get('whatsapp');

                // E7 - NO size field.
                $contact->status   = $request->get('status') ?? 'Active';
                $contact->comment  = $request->get('contact_comment');

                $contact->full_company_name         = $request->get('full_company_name');
                $contact->company_owner             = $request->get('company_owner');
                $contact->company_registration_no   = $request->get('company_registration_no');
                $contact->company_registration_date = $request->get('company_registration_date');
                $contact->working_since             = $request->get('working_since');
                $contact->pan_no                    = $request->get('pan_no');
                $contact->pan_status_id             = $request->get('pan_status_id');
                $contact->gst_treatment             = $request->get('gst_treatment');
                $contact->gst_number                = $request->get('gst_number');
                $contact->tds_percentage            = $request->get('tds_percentage');
                $contact->address1                  = $request->get('address');
                $contact->state_id                  = $request->get('state_id');
                $contact->city_id                   = $request->get('city_id');
                $contact->zipcode                   = $request->get('post_code');
                $contact->additional_info           = $request->get('additional_info');

                if (($request->get('status') ?? 'Active') === 'Blacklisted') {
                    $contact->blacklisted_at   = now();
                    $contact->blacklist_reason = $request->get('blacklist_reason');
                }

                $contact->created_by = Auth::user()->id;
                $contact->save();

                $this->syncContactPersons($request, $contact, $phoneCode, true);
                $this->syncBanks($request, $contact, true);
                $this->storeTdsDeclaration($request, $contact);

                if ($request->filled('blacklist_reason')) {
                    $activity = new Contactactivity();
                    $activity->contact_id     = $contact->id;
                    $activity->notes          = $request->get('blacklist_reason');
                    $activity->is_blacklisted = 'Yes';
                    $activity->created_by     = Auth::user()->id;
                    $activity->save();
                }

                $this->storeUseractivity(self::ACTMODEL, 3, Auth::user()->id, $contact->id, 'Added new tyre vendor contact with ID ' . $contact->id);

                return $contact;
            });

            return response()->json([
                'success'  => true,
                'data'     => $contact,
                'message'  => 'Tyre Vendor saved successfully.',
                'redirect' => route('contact.v2.tyrevendor.show', $contact->id),
            ], 200);

        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'data' => [], 'message' => $e->getMessage()], 500);
        }
    }

    /* ===============================================================
     | Update  (mirrors updateTyreVendor)
     | =============================================================== */
    public function update(Request $request, $id)
    {
        $request->merge([
            'phone'    => preg_replace('/\s+/', '', (string) $request->phone),
            'whatsapp' => preg_replace('/\s+/', '', (string) $request->whatsapp),
        ]);
        if ($request->has('contact_person_phone')) {
            $request->merge([
                'contact_person_phone' => array_map(fn ($p) => preg_replace('/\s+/', '', (string) $p), $request->contact_person_phone ?? []),
            ]);
        }

        $contact = Contact::where('cotype_id', self::COTYPE)->find($id); // SD-8 find() not findOrFail()
        if (! $contact) {
            return response()->json(['success' => false, 'data' => [], 'message' => 'Tyre vendor not found!'], 422);
        }
        if ($locked = $this->blockIfWriteLocked($contact, $request->status ?? 'Active')) {
            return $locked;
        }

        $validate_phone = function ($attribute, $value, $fail) use ($id) {
            // B8 — match on the 10 digits regardless of prefix (blocks 91 vs +91 duplicates).
            if (Contact::where('phone', $value)->where('id', '!=', $id)->exists()) {
                $fail('This phone number already exists.');
            }
        };

        $validator = Validator::make($request->all(), $this->rules($validate_phone, $contact->id), $this->messages(), $this->attributes());

        $validator->after(function ($validator) use ($request, $contact) {
            $this->validatePrimaryBank($validator, $request);
            $this->validateTdsDeclarationOnUpdate($validator, $request, $contact);
        });

        if ($validator->fails()) {
            return response()->json(['success' => false, 'data' => $validator->errors(), 'message' => 'Please check validation error.'], 422);
        }

        try {
            DB::transaction(function () use ($request, $contact) {

                $phoneCode = getPhoneCode();

                $contact->contact_name    = $request->get('contact_name');
                $contact->company_name    = $request->get('company_name');
                $contact->contact_code    = $request->get('contact_code');

                $contact->ph_prefix       = $request->phone_code ?? $phoneCode;
                $contact->phone           = $request->get('phone');
                $contact->whatsapp_prefix = $request->whatsapp_code ?? $phoneCode;
                $contact->whatsapp        = $request->get('whatsapp');

                $contact->status   = $request->get('status') ?? 'Active';
                $contact->comment  = $request->get('contact_comment');

                $contact->full_company_name         = $request->get('full_company_name');
                $contact->company_owner             = $request->get('company_owner');
                $contact->company_registration_no   = $request->get('company_registration_no');
                $contact->company_registration_date = $request->get('company_registration_date');
                $contact->working_since             = $request->get('working_since');
                $contact->pan_no                    = $request->get('pan_no');
                $contact->pan_status_id             = $request->get('pan_status_id');
                $contact->gst_treatment             = $request->get('gst_treatment');
                $contact->gst_number                = $request->get('gst_number');
                $contact->tds_percentage            = $request->get('tds_percentage');
                $contact->address1                  = $request->get('address');
                $contact->state_id                  = $request->get('state_id');
                $contact->city_id                   = $request->get('city_id');
                $contact->zipcode                   = $request->get('post_code');
                $contact->additional_info           = $request->get('additional_info');

                if ($request->get('status') === 'Blacklisted') {
                    $contact->blacklisted_at = now();
                } else {
                    $contact->blacklisted_at = null;
                }
                $contact->blacklist_reason = $request->get('blacklist_reason');
                $contact->updated_by       = Auth::user()->id;
                $contact->save();

                $this->syncContactPersons($request, $contact, $phoneCode, false);
                $this->syncBanks($request, $contact, false);
                $this->storeTdsDeclaration($request, $contact);

                if ($request->filled('blacklist_reason')) {
                    $activity = new Contactactivity();
                    $activity->contact_id     = $contact->id;
                    $activity->notes          = $request->get('blacklist_reason');
                    $activity->is_blacklisted = 'Yes';
                    $activity->created_by     = Auth::user()->id;
                    $activity->save();
                }

                $this->storeUseractivity(self::ACTMODEL, 4, Auth::user()->id, $contact->id, 'Tyre Vendor Updated [ID: ' . $contact->id . '].');
            });

            return response()->json([
                'success'  => true,
                'data'     => $contact,
                'message'  => 'Tyre Vendor updated successfully.',
                'redirect' => route('contact.v2.tyrevendor.show', $contact->id),
            ], 200);

        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'data' => [], 'message' => $e->getMessage()], 500);
        }
    }

    /* ===============================================================
     | Shared validation + write helpers
     | =============================================================== */

    private function rules(Closure $validate_phone, $ignoreId = null): array
    {
        return [
            'company_name'               => 'required|max:100',
            'contact_name'               => 'required|max:100',
            'contact_code'               => 'required|max:100',
            'phone'                      => ['required', 'digits:10', $validate_phone],
            'whatsapp'                   => ['nullable', 'digits:10'],
            'status'                     => 'nullable|in:Active,Inactive,Blacklisted',
            'blacklist_reason'           => 'required_if:status,Blacklisted',
            'contact_comment'            => 'nullable|string|max:255',
            'full_company_name'          => 'nullable|max:100',
            'company_owner'              => 'nullable|max:100',
            'company_registration_no'    => 'nullable|max:100',
            'company_registration_date'  => 'nullable|date|before_or_equal:today',
            'working_since'              => 'nullable|date|before_or_equal:today',
            'pan_no'                     => 'nullable|max:100',
            'pan_status_id'              => 'nullable|integer|exists:panstatuses,id',
            'gst_treatment'             => 'nullable|in:Registered,Unregistered',
            'gst_number'                => [
                'nullable', 'required_if:gst_treatment,Registered', 'max:100',
                Rule::unique('contacts', 'gst_number')
                    ->where(fn ($q) => $q->where('cotype_id', self::COTYPE)->whereNull('deleted_at'))
                    ->ignore($ignoreId),
            ],
            'tds_percentage'            => 'nullable|numeric|min:0|max:100',
            'address'                   => 'required|string|max:1000',
            'state_id'                  => 'required|exists:states,id',
            'city_id'                   => 'required|exists:cities,id',
            'post_code'                 => 'required|digits:6',
            'additional_info'           => 'nullable|string|max:10000',

            'bank_id'                   => 'required|array|min:1',
            'bank_id.*'                 => 'required|exists:banks,id',
            'beneficiary_name'          => 'nullable|array',
            'beneficiary_name.*'        => 'nullable|string|max:255',
            'account_number'            => 'required|array|min:1',
            'account_number.*'          => 'required|string|max:50',
            'ifsc_code'                 => 'required|array|min:1',
            'ifsc_code.*'               => 'required|string|max:20',
            'upi_id'                    => 'nullable|array',
            'upi_id.*'                  => 'nullable|string|max:100',
            'contact_bank_id'           => 'nullable|array',

            'contact_person_name'           => 'required|array|min:1',
            'contact_person_name.*'         => 'required|string|distinct|min:1',
            'contact_person_designation'    => 'nullable|array',
            'contact_person_designation.*'  => 'nullable|string',
            'contact_person_phone'          => 'required|array|min:1',
            'contact_person_phone.*'        => ['required', 'string', 'distinct', 'digits:10'],
            'contact_person_whatsapp'       => 'nullable|array',
            'contact_person_whatsapp.*'     => 'nullable|string',
            'contact_person_email'          => 'nullable|array',
            'contact_person_email.*'        => 'nullable|email:rfc|distinct',
            'contact_person_comment'        => 'nullable|array',
            'contact_person_comment.*'      => 'nullable|string',
            'contact_person_id'             => 'nullable|array',

            'tds_declaration'           => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ];
    }

    private function messages(): array
    {
        return [
            'required'        => 'This field is required.',
            'max'             => 'Maximum :max characters allowed.',
            'exists'          => "This field's value is invalid.",
            'distinct'        => 'Duplicate value.',
            'email'           => 'This email is invalid.',
            'phone.digits'    => 'This field must contain 10 digits.',
            'whatsapp.digits' => 'This field must contain 10 digits.',
            'post_code.digits'=> 'Postal code must be 6 digits.',
            'contact_person_phone.*.digits' => 'Contact person phone must contain 10 digits.',
            'tds_percentage.max'     => 'TDS % may not be greater than 100.',
            'tds_percentage.numeric' => 'TDS % must be a number.',
            'gst_number.unique'      => 'This GST number is already registered to another tyre vendor.',
            'tds_declaration.mimes'    => 'File type must be jpg, jpeg, png or pdf.',
            'tds_declaration.max'      => 'File size must not exceed 2MB.',
            'tds_declaration.uploaded' => 'File size must not exceed 2MB.',
        ];
    }

    /** Friendly attribute names for validation messages (TV-D2). */
    private function attributes(): array
    {
        return [
            'company_registration_date' => 'company registration date',
            'working_since'             => 'working since date',
            'gst_number'                => 'GST number',
            'tds_percentage'            => 'TDS %',
        ];
    }

    /** Exactly one primary bank (radio holds the row index - E3). */
    private function validatePrimaryBank($validator, Request $request): void
    {
        $banks = $request->get('bank_id', []);
        $primary = $request->get('primary_bank', null);
        if (count($banks) === 0) {
            return;
        }
        if ($primary === null || $primary === '' || ! array_key_exists((int) $primary, $banks)) {
            $validator->errors()->add('primary_bank', 'Please mark exactly one bank as Primary.');
        }
    }

    /** E6 - on CREATE, TDS Declaration mandatory when tds_percentage is 0 or 1. */
    private function validateTdsDeclarationOnCreate($validator, Request $request): void
    {
        $tds = $request->get('tds_percentage');
        if ($tds === null || $tds === '') {
            return;
        }
        if (in_array((float) $tds, [0.0, 1.0], true) && ! $request->hasFile('tds_declaration')) {
            $validator->errors()->add('tds_declaration', 'TDS Declaration document is mandatory when TDS % is 0 or 1.');
        }
    }

    /** E6 - on UPDATE, TDS Declaration mandatory when tds is 0 or 1 (unless one already on file). */
    private function validateTdsDeclarationOnUpdate($validator, Request $request, Contact $contact): void
    {
        $tds = $request->get('tds_percentage');
        if ($tds === null || $tds === '') {
            return;
        }
        if (! in_array((float) $tds, [0.0, 1.0], true)) {
            return;
        }
        $hasExisting = Coattachment::where('contact_id', $contact->id)
                        ->where('coattachtype_id', self::TDS_DECLARATION_TYPE)->exists();
        if (! $hasExisting && ! $request->hasFile('tds_declaration')) {
            $validator->errors()->add('tds_declaration', 'TDS Declaration document is mandatory when TDS % is 0 or 1.');
        }
    }

    /** Save the optional TDS Declaration upload as a coattachtype_id=7 attachment. */
    private function storeTdsDeclaration(Request $request, Contact $contact): void
    {
        if (! $request->hasFile('tds_declaration')) {
            return;
        }
        $file = $request->file('tds_declaration');
        $filename = 'contact-attachment-' . Str::random(4) . '_' . time() . '.' . $file->getClientOriginalExtension();
        $origName = $file->getClientOriginalName();
        $fileSize = $file->getSize();
        $file->move(public_path('media' . DIRECTORY_SEPARATOR . 'contact' . DIRECTORY_SEPARATOR), $filename);

        $att = new Coattachment;
        $att->name            = $filename;
        $att->original_name   = $origName;
        $att->file_size       = ($fileSize / (1024 * 1024));
        $att->coattachtype_id = self::TDS_DECLARATION_TYPE;
        $att->created_by      = Auth::id();
        $att->contact_id      = $contact->id;
        $att->save();
    }

    /** Contact persons - create: insert; update: upsert by contact_person_id[] + delete removed. */
    private function syncContactPersons(Request $request, Contact $contact, $phoneCode, bool $isCreate): void
    {
        $names = $request->get('contact_person_name', []);
        $kept = [];

        foreach ($names as $i => $name) {
            $phone = $request->get('contact_person_phone')[$i] ?? null;
            $email = $request->get('contact_person_email')[$i] ?? null;
            if (empty($name) && empty($email) && empty($phone)) {
                continue;
            }

            $rel = null;
            if (! $isCreate) {
                $rowId = $request->get('contact_person_id')[$i] ?? null;
                $rel = $rowId ? Relcontact::where('id', $rowId)->where('contact_id', $contact->id)->first() : null;
            }
            if (! $rel) {
                $rel = new Relcontact();
                $rel->contact_id = $contact->id;
                $rel->created_by = Auth::user()->id;
            }

            $rel->name            = $name;
            $rel->position        = $request->get('contact_person_designation')[$i] ?? null;
            $rel->ph_prefix       = $request->get('contact_person_ph_code')[$i] ?? $phoneCode;
            $rel->phone           = $phone;
            $rel->whatsapp_prefix = $request->get('contact_person_whatsapp_code')[$i] ?? $phoneCode;
            $rel->whatsapp        = $request->get('contact_person_whatsapp')[$i] ?? null;
            $rel->email           = $email;
            $rel->comment         = $request->get('contact_person_comment')[$i] ?? null;
            if (! $isCreate) {
                $rel->updated_by = Auth::user()->id;
            }
            $rel->save();
            $kept[] = $rel->id;
        }

        if (! $isCreate) {
            Relcontact::where('contact_id', $contact->id)->whereNotIn('id', $kept)->delete();
        }
    }

    /** Banks (E3) - create: insert; update: upsert by contact_bank_id[] + delete removed. One primary. */
    private function syncBanks(Request $request, Contact $contact, bool $isCreate): void
    {
        $bankIds       = $request->get('bank_id', []);
        $bankRowIds    = $request->get('contact_bank_id', []);
        $beneficiaries = $request->get('beneficiary_name', []);
        $accounts      = $request->get('account_number', []);
        $ifscs         = $request->get('ifsc_code', []);
        $upis          = $request->get('upi_id', []);
        $primaryIdx    = $request->get('primary_bank', 0);
        $kept = [];

        foreach ($bankIds as $i => $bankId) {
            $bank = null;
            if (! $isCreate) {
                $rowId = $bankRowIds[$i] ?? null;
                $bank = $rowId ? Contactbank::where('id', $rowId)->where('contact_id', $contact->id)->first() : null;
            }
            if (! $bank) {
                $bank = new Contactbank();
                $bank->contact_id = $contact->id;
            }

            $bank->bank_id          = $bankId;
            $bank->is_primary       = ((string) $i === (string) $primaryIdx) ? 'Yes' : 'No';
            $bank->beneficiary_name = $beneficiaries[$i] ?? null;
            $bank->account_number   = $accounts[$i] ?? null;
            $bank->ifsc_code        = $ifscs[$i] ?? null;
            $bank->upi_id           = $upis[$i] ?? null;
            $bank->save();
            $kept[] = $bank->id;
        }

        if (! $isCreate) {
            Contactbank::where('contact_id', $contact->id)->whereNotIn('id', $kept)->delete();
        }
    }

    /* ===============================================================
     | Documents submodule - upload / delete (AJAX JSON)
     | =============================================================== */

    public function storeAttachment(Request $request)
    {
        $contact = Contact::where('cotype_id', self::COTYPE)->find($request->contact_id);
        if (! $contact) {
            return response()->json(['success' => false, 'data' => [], 'message' => 'Tyre vendor not found!'], 422);
        }
        if ($locked = $this->blockIfWriteLocked($contact)) {
            return $locked;
        }

        $validator = Validator::make($request->all(), [
            'coattachtype_id' => 'required|exists:coattachtypes,id',
            'attachment_file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ], [
            'required'                 => 'This field is required.',
            'mimes'                    => 'File type must be jpg, jpeg, png or pdf.',
            'max'                      => 'File size must not exceed 2MB.',
            'attachment_file.max'      => 'File size must not exceed 2MB.',
            'attachment_file.uploaded' => 'File size must not exceed 2MB.',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'data' => $validator->errors(), 'message' => 'Please check validation errors.'], 422);
        }

        $existingOfType = Coattachment::where('contact_id', $contact->id)
                            ->where('coattachtype_id', $request->coattachtype_id)->count();
        if ($existingOfType >= 2) {
            return response()->json(['success' => false, 'data' => [], 'message' => 'You cannot upload more than 2 files for this document type.'], 422);
        }

        try {
            $attachment = DB::transaction(function () use ($request, $contact) {
                $file = $request->file('attachment_file');
                $filename = 'contact-attachment-' . Str::random(4) . '_' . time() . '.' . $file->getClientOriginalExtension();
                $origName = $file->getClientOriginalName();
                $fileSize = $file->getSize();
                $file->move(public_path('media' . DIRECTORY_SEPARATOR . 'contact' . DIRECTORY_SEPARATOR), $filename);

                $att = new Coattachment;
                $att->name            = $filename;
                $att->original_name   = $origName;
                $att->file_size       = ($fileSize / (1024 * 1024));
                $att->coattachtype_id = $request->coattachtype_id;
                $att->created_by      = Auth::id();
                $att->contact_id      = $contact->id;
                $att->save();

                $this->storeUseractivity(self::ACTMODEL, 3, Auth::user()->id, $contact->id, 'Uploaded a document for tyre vendor [ID: ' . $contact->id . '].');

                return $att;
            });

            return response()->json(['success' => true, 'data' => $attachment, 'message' => 'Attachment saved successfully.'], 200);

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

        $attachment = Coattachment::find($id);
        if ($attachment == null) {
            return response()->json(['success' => false, 'data' => [], 'message' => 'Woops! attachment not found.'], 422);
        }

        $vendor = Contact::where('cotype_id', self::COTYPE)->find($attachment->contact_id);
        if ($locked = $this->blockIfWriteLocked($vendor)) {
            return $locked;
        }

        // E6 - do not allow removing the only TDS Declaration while tds is 0 or 1.
        if ((int) $attachment->coattachtype_id === self::TDS_DECLARATION_TYPE) {
            $contact = Contact::find($attachment->contact_id);
            $tds = $contact ? $contact->tds_percentage : null;
            $remaining = Coattachment::where('contact_id', $attachment->contact_id)
                            ->where('coattachtype_id', self::TDS_DECLARATION_TYPE)
                            ->where('id', '!=', $attachment->id)->count();
            if ($contact && $tds !== null && $tds !== '' && in_array((float) $tds, [0.0, 1.0], true) && $remaining === 0) {
                return response()->json(['success' => false, 'data' => [], 'message' => 'TDS Declaration is mandatory while TDS % is 0 or 1 - cannot delete the only copy.'], 422);
            }
        }

        try {
            DB::transaction(function () use ($attachment) {
                $attachment->delete();
                return $attachment;
            });

            return response()->json(['success' => true, 'data' => [], 'message' => 'Attachment deleted successfully.'], 200);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'data' => [], 'message' => $e->getMessage()], 500);
        }
    }

    /* ===============================================================
     | Tyre submodule (E4) - modal add / edit / delete (AJAX JSON)
     | Uses the existing `tyres` table (contact_id = vendor). NO schema change.
     | =============================================================== */

    private function tyreRules(): array
    {
        return [
            'contact_id'         => 'required|exists:contacts,id',
            'tyre_model'         => 'required|string|max:255',
            'tyre_brand'         => 'nullable|string|max:255',
            'tyre_size'          => 'nullable|string|max:50',
            'tyre_serial_number' => 'nullable|string|max:255',
            'tyre_condition'     => 'required|in:New,Re-thread,Discard',
            'tyre_purchase_date' => 'nullable|date|before_or_equal:today',
            'tyre_price'         => 'nullable|numeric|min:0',
        ];
    }

    public function storeTyre(Request $request)
    {
        $contact = Contact::where('cotype_id', self::COTYPE)->find($request->contact_id);
        if (! $contact) {
            return response()->json(['success' => false, 'data' => [], 'message' => 'Tyre vendor not found!'], 422);
        }
        if ($locked = $this->blockIfWriteLocked($contact)) {
            return $locked;
        }

        $validator = Validator::make($request->all(), $this->tyreRules(), $this->messages());
        if ($validator->fails()) {
            return response()->json(['success' => false, 'data' => $validator->errors(), 'message' => 'Please check validation errors.'], 422);
        }

        try {
            $tyre = DB::transaction(function () use ($request, $contact) {
                $tyre = new Tyre;
                $tyre->organisation_id    = Auth::user()->organisation_id ?? 1; // SD-11
                $tyre->location           = 'Warehouse';
                $tyre->contact_id         = $contact->id;
                $tyre->tyre_condition     = $request->get('tyre_condition');
                $tyre->tyre_model         = $request->get('tyre_model');
                $tyre->tyre_brand         = $request->get('tyre_brand');
                $tyre->tyre_size          = $request->get('tyre_size');
                $tyre->tyre_serial_number = $request->get('tyre_serial_number');
                $tyre->tyre_purchase_date = $request->get('tyre_purchase_date');
                $tyre->tyre_price         = $request->get('tyre_price') ?? 0;
                $tyre->created_by         = Auth::user()->id;
                $tyre->save();

                $this->storeUseractivity(self::ACTMODEL, 3, Auth::user()->id, $contact->id, 'Added a tyre for tyre vendor [ID: ' . $contact->id . '].');

                return $tyre;
            });

            return response()->json(['success' => true, 'data' => $tyre, 'message' => 'Tyre saved successfully.'], 200);

        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'data' => [], 'message' => $e->getMessage()], 500);
        }
    }

    public function updateTyre(Request $request, $tyreId)
    {
        $contact = Contact::where('cotype_id', self::COTYPE)->find($request->contact_id);
        if (! $contact) {
            return response()->json(['success' => false, 'data' => [], 'message' => 'Tyre vendor not found!'], 422);
        }
        if ($locked = $this->blockIfWriteLocked($contact)) {
            return $locked;
        }

        $tyre = Tyre::where('id', $tyreId)->where('contact_id', $contact->id)->first();
        if (! $tyre) {
            return response()->json(['success' => false, 'data' => [], 'message' => 'Tyre not found!'], 422);
        }

        $validator = Validator::make($request->all(), $this->tyreRules(), $this->messages());
        if ($validator->fails()) {
            return response()->json(['success' => false, 'data' => $validator->errors(), 'message' => 'Please check validation errors.'], 422);
        }

        try {
            $tyre = DB::transaction(function () use ($request, $contact, $tyre) {
                $tyre->tyre_condition     = $request->get('tyre_condition');
                $tyre->tyre_model         = $request->get('tyre_model');
                $tyre->tyre_brand         = $request->get('tyre_brand');
                $tyre->tyre_size          = $request->get('tyre_size');
                $tyre->tyre_serial_number = $request->get('tyre_serial_number');
                $tyre->tyre_purchase_date = $request->get('tyre_purchase_date');
                $tyre->tyre_price         = $request->get('tyre_price') ?? 0;
                $tyre->updated_by         = Auth::user()->id;
                $tyre->save();

                $this->storeUseractivity(self::ACTMODEL, 4, Auth::user()->id, $contact->id, 'Updated a tyre [ID: ' . $tyre->id . '] for tyre vendor [ID: ' . $contact->id . '].');

                return $tyre;
            });

            return response()->json(['success' => true, 'data' => $tyre, 'message' => 'Tyre updated successfully.'], 200);

        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'data' => [], 'message' => $e->getMessage()], 500);
        }
    }

    public function deleteTyre(Request $request)
    {
        $tyre = Tyre::find($request->input('id'));
        if (! $tyre) {
            return response()->json(['success' => false, 'data' => [], 'message' => 'Tyre not found!'], 422);
        }

        $vendor = Contact::where('cotype_id', self::COTYPE)->find($tyre->contact_id);
        if ($locked = $this->blockIfWriteLocked($vendor)) {
            return $locked;
        }

        try {
            DB::transaction(function () use ($tyre) {
                $vendorId = $tyre->contact_id;
                $tyreId   = $tyre->id;
                $tyre->deleted_by = Auth::user()->id;
                $tyre->save();
                $tyre->delete();
                $this->storeUseractivity(self::ACTMODEL, 6, Auth::user()->id, $vendorId, 'Deleted a tyre [ID: ' . $tyreId . '].');
                return $tyre;
            });

            return response()->json(['success' => true, 'data' => [], 'message' => 'Tyre deleted successfully.'], 200);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'data' => [], 'message' => $e->getMessage()], 500);
        }
    }

    /* ===============================================================
     | Activity submodule - add note (AJAX JSON)
     | =============================================================== */

    public function storeActivityNote(Request $request)
    {
        $contact = Contact::where('cotype_id', self::COTYPE)->find($request->contact_id);
        if (! $contact) {
            return response()->json(['success' => false, 'data' => [], 'message' => 'Tyre vendor not found!'], 422);
        }
        if ($locked = $this->blockIfWriteLocked($contact)) {
            return $locked;
        }

        $validator = Validator::make($request->all(), [
            'activity_notes' => 'required|string',
            'contact_id'     => 'required|exists:contacts,id',
        ], $this->messages());

        if ($validator->fails()) {
            return response()->json(['success' => false, 'data' => $validator->errors(), 'message' => 'Please check validation errors.'], 422);
        }

        try {
            $activity = DB::transaction(function () use ($request, $contact) {
                $activity = new Contactactivity();
                $activity->contact_id = $contact->id;
                $activity->notes      = $request->activity_notes;
                $activity->created_by = Auth::user()->id;
                $activity->save();
                return $activity;
            });

            return response()->json(['success' => true, 'data' => $activity, 'message' => 'Activity note saved successfully.'], 200);

        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'data' => [], 'message' => $e->getMessage()], 500);
        }
    }

    /* ===============================================================
     | List delete (index) - soft-delete the vendor Contact
     | =============================================================== */

    public function destroy(Request $request)
    {
        $contact = Contact::where('cotype_id', self::COTYPE)->find($request->input('id'));
        if (! $contact) {
            return response()->json(['success' => false, 'data' => [], 'message' => 'Tyre vendor not found!'], 422);
        }

        try {
            DB::transaction(function () use ($contact) {
                $contact->deleted_by = Auth::user()->id;
                $contact->save();
                $contact->delete();
                $this->storeUseractivity(self::ACTMODEL, 6, Auth::user()->id, $contact->id, 'Deleted tyre vendor [ID: ' . $contact->id . '].');
                return $contact;
            });

            return response()->json(['success' => true, 'data' => [], 'message' => 'Tyre vendor deleted successfully.'], 200);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'data' => [], 'message' => $e->getMessage()], 500);
        }
    }
}
