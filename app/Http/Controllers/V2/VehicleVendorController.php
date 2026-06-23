<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use App\Http\Requests\V2\VehicleVendorRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Auth;

use App\Models\Contact;
use App\Models\Relcontact;
use App\Models\Contactbank;
use App\Models\Coattachment;
use App\Models\Coattachtype;
use App\Models\Contactactivity;
use App\Models\Bank;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Panstatus;
use App\Models\Vehicleownership;

use App\Traits\Useractivity;

/**
 * Vehicle Vendor Module V2 — Controller (Gate 2: live backend wiring).
 *
 * Mirrors the live V1 logic from App\Http\Controllers\ContactController
 * vehiclevendor* methods into the isolated V2 module. cotype_id = 5. Reuses the
 * existing `contacts` (+ relcontacts, contactbanks, coattachments,
 * contactactivities) tables via Eloquent only — NO schema changes. V1 routes /
 * controller / views are never touched.
 *
 * Vehicle-vendor specifics (docs/logics/contact/vehiclevendor.md + V2 extensions):
 *   E3 — bank repeater, exactly one Primary (update = delete-and-reinsert).
 *   E6 — TDS Declaration (coattachtype_id = 7) mandatory when tds_percentage 0/1.
 *
 * BLOCKER (Amit decision 2026-06-17): the Vehicle and Route submodules have NO
 * backing table under the no-schema-change rule. They are rendered READ-ONLY for
 * this Gate 2 (empty-state, no write endpoints) until a schema decision is made.
 */
class VehicleVendorController extends Controller
{
    use Useractivity;

    /** cotype_id for Vehicle Vendor. */
    private const COTYPE_ID = 5;

    /* ===============================================================
     | View-data helpers
     | =============================================================== */

    /** Shape a Contact (cotype 5) into the $v[...] array the blades read. */
    private function shapeVendor(Contact $contact): array
    {
        return [
            'id'            => $contact->id,
            'contactno'     => $contact->contactno,
            'company'       => $contact->company_name ?? '—',
            'code'          => $contact->contact_code ?? '—',
            'name'          => $contact->contact_name ?? '—',
            'gst'           => $contact->gst_number ?? '—',
            'gst_treatment' => $contact->gst_treatment ?? '—',
            'owner'         => $contact->company_owner ?? '—',
            'size'          => $contact->size ?? '—',
            'rag'           => $contact->rag_status ?? 'Green',
            'vehicles'      => $contact->no_of_vehicles ?? 0,
            'phone'         => trim(($contact->ph_prefix ? '+' . ltrim($contact->ph_prefix, '+') . ' ' : '') . $contact->phone),
            'whatsapp'      => $contact->whatsapp ? trim(($contact->whatsapp_prefix ? '+' . ltrim($contact->whatsapp_prefix, '+') . ' ' : '') . $contact->whatsapp) : '',
            'email'         => optional($contact->relcontacts->first())->email ?? ($contact->email ?? '—'),
            'city'          => optional($contact->city)->name ?? '—',
            'state'         => optional($contact->state)->name ?? '—',
            'tds'           => is_null($contact->tds_percentage) ? null : (float) $contact->tds_percentage,
            'status'        => $contact->status ?? 'Active',
        ];
    }

    /** Per-page counts for the workspace subnav. Vehicle/Route are read-only (0). */
    private function tabCounts(Contact $contact): array
    {
        return [
            'documents' => $contact->coattachments()->count(),
            'vehicles'  => 0, // read-only — no backing table (Amit decision 2026-06-17)
            'routes'    => 0, // read-only — no backing table (Amit decision 2026-06-17)
            'activity'  => $contact->activities()->count(),
        ];
    }

    private function findVendorOrFail($id): Contact
    {
        return Contact::where('cotype_id', self::COTYPE_ID)->findOrFail($id);
    }

    /**
     * B9 — server-side write-lock. A Blacklisted vendor is locked for all writes
     * (main record + every sub-entity). Inactive remains writable; reads are never
     * blocked. Returns a 422 JSON response to short-circuit the caller, or null.
     */
    private function blockIfWriteLocked(?Contact $contact)
    {
        if ($contact && $contact->status === 'Blacklisted') {
            return response()->json([
                'success' => false,
                'data'    => [],
                'message' => 'This vendor is Blacklisted and is locked for edits.',
            ], 422);
        }
        return null;
    }

    /* ===============================================================
     | Screens (public GET)
     | =============================================================== */

    public function dashboard()
    {
        $base      = Contact::where('cotype_id', self::COTYPE_ID);
        $contacts  = (clone $base)->with(['city', 'relcontacts'])->orderBy('id', 'desc')->take(8)->get();
        $vendors   = $contacts->map(fn ($c) => $this->shapeVendor($c))->values()->all();

        $total = (clone $base)->count();
        $kpis  = [
            'total'             => $total,
            'active'            => (clone $base)->where('status', 'Active')->count(),
            'inactive'          => (clone $base)->where('status', 'Inactive')->count(),
            'blacklisted'       => (clone $base)->where('status', 'Blacklisted')->count(),
            'vehicles_supplied' => (int) (clone $base)->sum('no_of_vehicles'),
            'routes'            => 0, // read-only submodule
        ];

        $ragRaw = (clone $base)->select('rag_status', DB::raw('COUNT(*) as total'))
                    ->groupBy('rag_status')->pluck('total', 'rag_status');
        $ragBreakdown = collect(['Green', 'Yellow', 'Red'])->map(function ($rag) use ($ragRaw, $total) {
            $count = (int) ($ragRaw[$rag] ?? 0);
            return [
                'rag'   => $rag,
                'total' => $count,
                'pct'   => $total > 0 ? round($count / $total * 100) : 0,
            ];
        });

        return view('V2.vehiclevendor.dashboard', [
            'vendors'      => $vendors,
            'kpis'         => $kpis,
            'ragBreakdown' => $ragBreakdown,
        ]);
    }

    public function index(Request $request)
    {
        $search_name   = $request->name;
        $search_city   = $request->city;
        $search_size   = $request->size;
        $search_rag    = $request->rag;
        $search_status = $request->status;

        $query = Contact::where('cotype_id', self::COTYPE_ID)
                    ->with(['cotype', 'relcontacts', 'city']);

        if ($request->filled('name')) {
            $query->where(function ($q) use ($request) {
                $q->where('contact_name', 'like', '%' . $request->name . '%')
                  ->orWhere('company_name', 'like', '%' . $request->name . '%')
                  ->orWhere('contactno', 'like', '%' . $request->name . '%');
            });
        }
        if ($request->filled('city')) {
            $query->where('city_id', $request->city);
        }
        if ($request->filled('size')) {
            $query->where('size', $request->size);
        }
        if ($request->filled('rag')) {
            $query->where('rag_status', $request->rag);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $contacts = $query->orderBy('id', 'desc')->paginate(10)->withQueryString();
        $contacts->getCollection()->transform(fn ($c) => $this->shapeVendor($c));

        $cities = City::whereHas('state.country', fn ($q) => $q->where('iso2', 'IN'))
                    ->orderBy('name')->get();

        $this->storeUseractivity(7, 5, Auth::user()->id, 0, 'Retrieve a vehicle vendor list (V2)');

        return view('V2.vehiclevendor.index', [
            'vendors'       => $contacts,
            'cities'        => $cities,
            'search_name'   => $search_name,
            'search_city'   => $search_city,
            'search_size'   => $search_size,
            'search_rag'    => $search_rag,
            'search_status' => $search_status,
        ]);
    }

    public function create()
    {
        $organisation_id = optional(Auth::user()->organisation)->id;

        return view('V2.vehiclevendor.create', [
            'countries'              => Country::all(),
            'states'                 => State::with(['cities' => fn ($q) => $q->orderBy('name')])
                                        ->whereHas('country', fn ($q) => $q->where('iso2', 'IN'))
                                        ->orderBy('name')->get(),
            'pan_statuses'           => Panstatus::where('organisation_id', $organisation_id)->orderBy('name')->get(),
            'banks'                  => Bank::orderBy('name')->get(),
            'coattachtypes'          => Coattachtype::orderBy('name')->get(),
            'vehicle_ownership_type' => Vehicleownership::where('organisation_id', $organisation_id)
                                        ->where('status', 'Active')->orderBy('name')->get(),
        ]);
    }

    public function show($id)
    {
        $contact = Contact::where('cotype_id', self::COTYPE_ID)
                    ->with(['city', 'state', 'relcontacts', 'bankDetails.bank', 'activities.createdBy'])
                    ->findOrFail($id);

        return view('V2.vehiclevendor.show', [
            'v'          => $this->shapeVendor($contact),
            'counts'     => $this->tabCounts($contact),
            'active'     => 'overview',
            'activities' => $contact->activities()->with('createdBy')->latest()->take(5)->get(),
        ]);
    }

    public function edit($id)
    {
        $contact = Contact::with([
                        'country.states', 'state.cities', 'relcontacts',
                        'bankDetails.bank', 'coattachments.coattachtype',
                        'activities', 'activities.createdBy',
                    ])
                    ->where('cotype_id', self::COTYPE_ID)
                    ->findOrFail($id);

        $organisation_id = optional(Auth::user()->organisation)->id;

        $this->storeUseractivity(7, 5, Auth::user()->id, $contact->id, 'Retrieve vehicle vendor ' . $contact->contact_name . ' to edit.');

        return view('V2.vehiclevendor.edit', [
            'v'                      => $this->shapeVendor($contact),
            'contact'                => $contact,
            'counts'                 => $this->tabCounts($contact),
            'active'                 => 'edit',
            'countries'              => Country::all(),
            'states'                 => State::whereHas('country', fn ($q) => $q->where('iso2', 'IN'))
                                        ->orderBy('name')->get(),
            'pan_statuses'           => Panstatus::where('organisation_id', $organisation_id)->orderBy('name')->get(),
            'banks'                  => Bank::orderBy('name')->get(),
            'vehicle_ownership_type' => Vehicleownership::where('organisation_id', $organisation_id)
                                        ->where('status', 'Active')->orderBy('name')->get(),
        ]);
    }

    /* ---- E4 (read-only): Vehicle + Route supplied-items sub-pages.
     | No backing table under the no-schema-change rule — rendered read-only.
     | (Amit decision 2026-06-17.) -------------------------------------------- */

    public function vehicle($id)
    {
        $contact = $this->findVendorOrFail($id);

        return view('V2.vehiclevendor.vehicle', [
            'v'        => $this->shapeVendor($contact),
            'counts'   => $this->tabCounts($contact),
            'active'   => 'vehicle',
            'readonly' => true,
        ]);
    }

    public function route($id)
    {
        $contact = $this->findVendorOrFail($id);

        return view('V2.vehiclevendor.route', [
            'v'        => $this->shapeVendor($contact),
            'counts'   => $this->tabCounts($contact),
            'active'   => 'route',
            'readonly' => true,
        ]);
    }

    public function documents($id)
    {
        $contact = $this->findVendorOrFail($id);

        return view('V2.vehiclevendor.documents', [
            'v'             => $this->shapeVendor($contact),
            'counts'        => $this->tabCounts($contact),
            'active'        => 'documents',
            'coattachments' => Coattachment::with('coattachtype')->where('contact_id', $contact->id)->latest()->get(),
            'coattachtypes' => Coattachtype::orderBy('name')->get(),
            'hasTds'        => Coattachment::where('contact_id', $contact->id)->where('coattachtype_id', 7)->exists(),
        ]);
    }

    public function activity($id)
    {
        $contact = $this->findVendorOrFail($id);

        return view('V2.vehiclevendor.activity', [
            'v'          => $this->shapeVendor($contact),
            'counts'     => $this->tabCounts($contact),
            'active'     => 'activity',
            'activities' => Contactactivity::with('createdBy')
                                ->where('contact_id', $contact->id)
                                ->orderByDesc('created_at')->get(),
        ]);
    }

    /* ===============================================================
     | Store / Update (← storeVehiclevendor / updateVehiclevendor)
     | =============================================================== */

    public function store(VehicleVendorRequest $request)
    {
        try {
            $contact = DB::transaction(function () use ($request) {
                $last      = Contact::withTrashed()->orderBy('id', 'DESC')->first();
                $n         = $last ? (int) $last->contactno + 1 : 1;
                $contactno = str_pad($n, 6, '0', STR_PAD_LEFT);

                $phoneCode = getPhoneCode();

                $contact = new Contact;
                $contact->contactno                 = $contactno;
                $contact->cotype_id                 = self::COTYPE_ID;
                $contact->organisation_id           = Auth::user()->organisation_id ?? 1;
                $contact->contact_name              = $request->contact_name;
                $contact->company_name              = $request->company_name;
                $contact->contact_code              = $request->contact_code;
                $contact->no_of_vehicles            = $request->no_of_vehicles;
                $contact->ph_prefix                 = $request->phone_code ?? $phoneCode;
                $contact->phone                     = $request->phone;
                $contact->whatsapp_prefix           = $request->whatsapp_code ?? $phoneCode;
                $contact->whatsapp                  = $request->whatsapp;
                $contact->size                      = $request->size;
                $contact->status                    = $request->status ?? 'Active';
                $contact->blacklist_reason          = $request->blacklist_reason;
                $contact->rag_status                = $request->rag_status;
                $contact->comment                   = $request->contact_comment;
                $contact->full_company_name         = $request->full_company_name;
                $contact->vehicle_ownership_type_id = $request->vehicle_ownership_type_id;
                $contact->company_owner             = $request->company_owner;
                $contact->company_registration_no   = $request->company_registration_no;
                $contact->company_registration_date = $request->company_registration_date;
                $contact->working_since             = $request->working_since;
                $contact->pan_no                    = $request->pan_no;
                $contact->pan_status_id             = $request->pan_status_id;
                $contact->gst_treatment             = $request->gst_treatment;
                $contact->gst_number                = $request->gst_number;
                $contact->tds_percentage            = $request->tds_percentage;
                $contact->address1                  = $request->address;
                $contact->state_id                  = $request->state_id;
                $contact->city_id                   = $request->city_id;
                $contact->zipcode                   = $request->post_code;
                $contact->additional_info           = $request->additional_info;
                if ($request->status === 'Blacklisted') {
                    $contact->blacklisted_at = now();
                }
                $contact->created_by = Auth::id();
                $contact->save();

                $this->syncContactPersons($contact, $request, $phoneCode, false);
                $this->syncBanks($contact, $request);
                $this->saveCreateAttachment($contact, $request);

                $this->storeUseractivity(7, 3, Auth::id(), $contact->id, 'Added new vehicle vendor [ID: ' . $contact->id . '].');

                return $contact;
            });

            return response()->json([
                'success'  => true,
                'data'     => $contact,
                'message'  => 'Vehicle vendor saved successfully.',
                'redirect' => route('contact.v2.vehiclevendor.index'),
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'data' => [], 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function update(VehicleVendorRequest $request, $id)
    {
        $contact = Contact::where('cotype_id', self::COTYPE_ID)->find($id);
        if (! $contact) {
            return response()->json(['success' => false, 'data' => [], 'message' => 'Vehicle vendor not found.'], 422);
        }
        if ($locked = $this->blockIfWriteLocked($contact)) {
            return $locked;
        }

        try {
            $result = DB::transaction(function () use ($request, $contact) {
                $phoneCode = getPhoneCode();

                $contact->contact_name              = $request->contact_name;
                $contact->company_name              = $request->company_name;
                $contact->contact_code              = $request->contact_code;
                $contact->no_of_vehicles            = $request->no_of_vehicles;
                $contact->ph_prefix                 = $request->phone_code ?? $phoneCode;
                $contact->phone                     = $request->phone;
                $contact->whatsapp_prefix           = $request->whatsapp_code ?? $phoneCode;
                $contact->whatsapp                  = $request->whatsapp;
                $contact->size                      = $request->size;
                $contact->status                    = $request->status ?? 'Active';
                $contact->blacklist_reason          = $request->blacklist_reason;
                $contact->rag_status                = $request->rag_status;
                $contact->comment                   = $request->contact_comment;
                $contact->full_company_name         = $request->full_company_name;
                $contact->vehicle_ownership_type_id = $request->vehicle_ownership_type_id;
                $contact->company_owner             = $request->company_owner;
                $contact->company_registration_no   = $request->company_registration_no;
                $contact->company_registration_date = $request->company_registration_date;
                $contact->working_since             = $request->working_since;
                $contact->pan_no                    = $request->pan_no;
                $contact->pan_status_id             = $request->pan_status_id;
                $contact->gst_treatment             = $request->gst_treatment;
                $contact->gst_number                = $request->gst_number;
                $contact->tds_percentage            = $request->tds_percentage;
                $contact->address1                  = $request->address;
                $contact->state_id                  = $request->state_id;
                $contact->city_id                   = $request->city_id;
                $contact->zipcode                   = $request->post_code;
                $contact->additional_info           = $request->additional_info;
                $contact->blacklisted_at            = $request->status === 'Blacklisted' ? now() : null;
                $contact->updated_by                = Auth::id();
                $contact->save();

                if ($request->get('status') === 'Blacklisted' && $request->filled('blacklist_reason')) {
                    $activity = new Contactactivity();
                    $activity->contact_id     = $contact->id;
                    $activity->notes          = $request->blacklist_reason;
                    $activity->is_blacklisted = 'Yes';
                    $activity->created_by     = Auth::id();
                    $activity->save();
                }

                $this->syncContactPersons($contact, $request, $phoneCode, true);
                $this->syncBanks($contact, $request);

                $this->storeUseractivity(7, 4, Auth::id(), $contact->id, 'Vehicle vendor updated [ID: ' . $contact->id . '].');

                return $contact;
            });

            return response()->json([
                'success'  => true,
                'data'     => $result,
                'message'  => 'Vehicle vendor updated successfully.',
                'redirect' => route('contact.v2.vehiclevendor.index'),
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'data' => [], 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    /** Upsert contact persons (relcontacts); soft-delete removed on update. */
    private function syncContactPersons(Contact $contact, $request, $phoneCode, bool $isUpdate): void
    {
        $names    = $request->contact_person_name        ?? [];
        $desigs   = $request->contact_person_designation ?? [];
        $phones   = $request->contact_person_phone       ?? [];
        $emails   = $request->contact_person_email       ?? [];
        $comments = $request->contact_person_comment     ?? [];
        $phcodes  = $request->contact_person_ph_code     ?? [];
        $existing = $request->contact_person_id          ?? [];

        $kept = [];
        foreach ($names as $idx => $name) {
            if (! $name) {
                continue;
            }
            $personId = $existing[$idx] ?? null;
            $cp = ($isUpdate && $personId) ? Relcontact::find($personId) : null;
            if (! $cp) {
                $cp = new Relcontact;
                $cp->contact_id = $contact->id;
                $cp->created_by = Auth::id();
            }
            $cp->name      = $name;
            $cp->position  = $desigs[$idx]   ?? null;
            $cp->ph_prefix = ($phcodes[$idx] ?? null) ?: $phoneCode;
            $cp->phone     = $this->nationalDigits($phones[$idx] ?? null);
            $cp->email     = $emails[$idx]   ?? null;
            $cp->comment   = $comments[$idx] ?? null;
            if ($isUpdate) {
                $cp->updated_by = Auth::id();
            }
            $cp->save();
            $kept[] = $cp->id;
        }

        if ($isUpdate) {
            Relcontact::where('contact_id', $contact->id)->whereNotIn('id', $kept)->delete();
        }
    }

    /** Banks (E3): delete-and-reinsert; exactly one Primary by index. */
    private function syncBanks(Contact $contact, $request): void
    {
        Contactbank::where('contact_id', $contact->id)->delete();

        $bankIds    = $request->bank_id          ?? [];
        $benefNames = $request->beneficiary_name ?? [];
        $accNos     = $request->account_number   ?? [];
        $ifscCodes  = $request->ifsc_code        ?? [];
        $upiIds     = $request->upi_id           ?? [];
        $primaryIdx = $request->primary_bank;

        foreach ($bankIds as $idx => $bankId) {
            if (! $bankId) {
                continue;
            }
            Contactbank::create([
                'contact_id'       => $contact->id,
                'bank_id'          => $bankId,
                'beneficiary_name' => $benefNames[$idx] ?? null,
                'account_number'   => $accNos[$idx]     ?? null,
                'ifsc_code'        => $ifscCodes[$idx]  ?? null,
                'upi_id'           => $upiIds[$idx]     ?? null,
                'is_primary'       => ((string) $idx === (string) $primaryIdx) ? 'Yes' : 'No',
            ]);
        }
    }

    /** Persist the single optional document from the create form (incl. E6 TDS). */
    private function saveCreateAttachment(Contact $contact, $request): void
    {
        if (! $request->hasFile('attachment_file') || ! $request->filled('coattachtype_id')) {
            return;
        }
        $file = $request->file('attachment_file');
        $sizeMb = $file->getSize() / (1024 * 1024);
        $originalName = $file->getClientOriginalName();
        $filename = 'contact-attachment-' . Str::random(4) . '_' . time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('media' . DIRECTORY_SEPARATOR . 'contact' . DIRECTORY_SEPARATOR), $filename);

        $att = new Coattachment;
        $att->name            = $filename;
        $att->original_name   = $originalName;
        $att->file_size       = $sizeMb;
        $att->coattachtype_id = $request->coattachtype_id;
        $att->created_by      = Auth::id();
        $att->contact_id      = $contact->id;
        $att->save();
    }

    private function nationalDigits($value): ?string
    {
        $digits = preg_replace('/\D+/', '', (string) $value);
        if ($digits === '') {
            return null;
        }
        return strlen($digits) > 10 ? substr($digits, -10) : $digits;
    }

    /* ===============================================================
     | Toggle status / Destroy
     | =============================================================== */

    public function toggleStatus(Request $request, $id)
    {
        $contact = Contact::where('cotype_id', self::COTYPE_ID)->find($id);
        if (! $contact) {
            return response()->json(['success' => false, 'message' => 'Vehicle vendor not found.'], 422);
        }

        try {
            $contact->status     = $contact->status === 'Active' ? 'Inactive' : 'Active';
            $contact->updated_by = Auth::id();
            $contact->save();

            return response()->json([
                'success'    => true,
                'new_status' => $contact->status,
                'message'    => 'Status updated to ' . $contact->status . '.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        $contact = Contact::where('cotype_id', self::COTYPE_ID)->find($id);
        if (! $contact) {
            return response()->json(['success' => false, 'message' => 'Vehicle vendor not found.'], 422);
        }

        try {
            $contact->deleted_by = Auth::id();
            $contact->save();
            $contact->delete();

            return response()->json(['success' => true, 'message' => 'Vehicle vendor deleted.'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /* ===============================================================
     | Contact person wrapper (HTML row for the repeater)
     | =============================================================== */

    public function contactPersonWrapper(Request $request)
    {
        $rowindex = $request->get('rowindex', 0);
        $html = view('V2.vehiclevendor.partials.contact-person', compact('rowindex'))->render();

        return response()->json(['success' => true, 'data' => $html, 'message' => 'Vehicle vendor contact person wrapper fetched.'], 200);
    }

    /* ===============================================================
     | Documents page — upload + delete
     | =============================================================== */

    public function storeAttachment(Request $request)
    {
        $contact = Contact::where('cotype_id', self::COTYPE_ID)->find($request->contact_id);
        if (! $contact) {
            return response()->json(['success' => false, 'data' => [], 'message' => 'Vehicle vendor not found!'], 422);
        }
        if ($locked = $this->blockIfWriteLocked($contact)) {
            return $locked;
        }

        $validator = Validator::make($request->all(), [
            'coattachtype_id' => 'required|exists:coattachtypes,id',
            'attachment_file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ], [
            'required' => 'This field is required.',
            'mimes'    => 'File type must be jpg, jpeg, png or pdf.',
            'max'      => 'File size must not exceed 2 MB.',
            'uploaded' => 'File size must not exceed 2 MB.',
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
                $sizeMb = $file->getSize() / (1024 * 1024);
                $originalName = $file->getClientOriginalName();
                $filename = 'contact-attachment-' . Str::random(4) . '_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('media' . DIRECTORY_SEPARATOR . 'contact' . DIRECTORY_SEPARATOR), $filename);

                $attachment = new Coattachment;
                $attachment->name            = $filename;
                $attachment->original_name   = $originalName;
                $attachment->file_size       = $sizeMb;
                $attachment->coattachtype_id = $request->coattachtype_id;
                $attachment->created_by      = Auth::id();
                $attachment->contact_id      = $contact->id;
                $attachment->save();

                return $attachment;
            });

            return response()->json(['success' => true, 'data' => $attachment, 'message' => 'Document uploaded successfully.'], 200);

        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'data' => [], 'message' => $e->getMessage()], 500);
        }
    }

    public function deleteAttachment(Request $request)
    {
        $id = $request->input('id') ?? $request->input('attachment_id');
        if (! $id) {
            return response()->json(['success' => false, 'data' => [], 'message' => 'Attachment id not found.'], 422);
        }

        $attachment = Coattachment::find($id);
        if (! $attachment) {
            return response()->json(['success' => false, 'data' => [], 'message' => 'Attachment not found.'], 422);
        }
        $contact = Contact::where('cotype_id', self::COTYPE_ID)->find($attachment->contact_id);
        if ($locked = $this->blockIfWriteLocked($contact)) {
            return $locked;
        }

        try {
            DB::transaction(fn () => $attachment->delete());
            return response()->json(['success' => true, 'data' => [], 'message' => 'Document deleted successfully.'], 200);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'data' => [], 'message' => $e->getMessage()], 500);
        }
    }

    /* ===============================================================
     | Activity page — add note
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

        $contact = Contact::where('cotype_id', self::COTYPE_ID)->find($request->contact_id);
        if ($locked = $this->blockIfWriteLocked($contact)) {
            return $locked;
        }

        try {
            $activity = DB::transaction(function () use ($request) {
                $activity = new Contactactivity();
                $activity->contact_id = $request->contact_id;
                $activity->notes      = $request->activity_notes;
                $activity->created_by = Auth::id();
                $activity->save();

                return $activity;
            });

            return response()->json(['success' => true, 'data' => $activity, 'message' => 'Activity note saved successfully.'], 200);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'data' => [], 'message' => $e->getMessage()], 500);
        }
    }
}
