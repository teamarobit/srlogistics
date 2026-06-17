<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use App\Http\Requests\V2\BatteryVendorRequest;
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
use App\Models\Battery;

use App\Traits\Useractivity;

/**
 * Battery Vendor Module V2 — Controller (Gate 2: live backend wiring).
 *
 * Mirrors the live V1 logic from App\Http\Controllers\ContactController battery*
 * methods into the isolated V2 module. cotype_id = 7. Reuses the existing
 * `contacts` (+ relcontacts, contactbanks, coattachments, contactactivities) and
 * `batteries` tables via Eloquent only — NO schema changes.
 *
 * Battery-vendor specifics (docs/logics/contact/batteryvendor.md + V2 extensions):
 *   E3 — bank repeater, exactly one Primary (update = delete-and-reinsert).
 *   E4 — "Battery" supplied-items sub-page: real CRUD on `batteries` by vendor_id.
 *   E6 — TDS Declaration (coattachtype_id = 7) mandatory when tds_percentage 0/1.
 *   E7 — gst_number required (contacts.gst_number); gst_treatment forced
 *        'Registered' on store, never changed on update.
 */
class BatteryVendorController extends Controller
{
    use Useractivity;

    /** cotype_id for Battery Vendor. */
    private const COTYPE_ID = 7;

    /** current_status values valid for the `batteries` table enum. */
    private const BATTERY_STATUSES = ['In Stock', 'Installed', 'In Repair', 'Condemned', 'Disposed'];

    /* ===============================================================
     | View-data helpers
     | =============================================================== */

    /** Shape a Contact (cotype 7) into the $v[...] array the blades read. */
    private function shapeVendor(Contact $contact): array
    {
        return [
            'id'        => $contact->id,
            'contactno' => $contact->contactno,
            'company'   => $contact->company_name ?? '—',
            'code'      => $contact->contact_code ?? '—',
            'name'      => $contact->contact_name ?? '—',
            'gst'       => $contact->gst_number ?? '—',
            'vehicles'  => $contact->no_of_vehicles ?? 0,
            'phone'     => trim(($contact->ph_prefix ? '+' . ltrim($contact->ph_prefix, '+') . ' ' : '') . $contact->phone),
            'whatsapp'  => $contact->whatsapp ? trim(($contact->whatsapp_prefix ? '+' . ltrim($contact->whatsapp_prefix, '+') . ' ' : '') . $contact->whatsapp) : '',
            'email'     => optional($contact->relcontacts->first())->email ?? ($contact->email ?? '—'),
            'city'      => optional($contact->city)->name ?? '—',
            'state'     => optional($contact->state)->name ?? '—',
            'tds'       => is_null($contact->tds_percentage) ? null : (float) $contact->tds_percentage,
            'batteries' => Battery::where('vendor_id', $contact->id)->count(),
            'status'    => $contact->status ?? 'Active',
        ];
    }

    /** Per-page counts for the workspace subnav. */
    private function tabCounts(Contact $contact): array
    {
        return [
            'documents' => $contact->coattachments()->count(),
            'battery'   => Battery::where('vendor_id', $contact->id)->count(),
            'activity'  => $contact->activities()->count(),
            'banks'     => $contact->bankDetails()->count(),
        ];
    }

    private function findVendorOrFail($id): Contact
    {
        return Contact::where('cotype_id', self::COTYPE_ID)->findOrFail($id);
    }

    /* ===============================================================
     | Screens (public GET)
     | =============================================================== */

    public function dashboard()
    {
        $base    = Contact::where('cotype_id', self::COTYPE_ID);
        $vendorIds = (clone $base)->pluck('id');

        $contacts = (clone $base)->with(['city', 'relcontacts'])
                        ->orderBy('id', 'desc')->take(8)->get();
        $vendors  = $contacts->map(fn ($c) => $this->shapeVendor($c))->values()->all();

        $kpis = [
            'total'       => (clone $base)->count(),
            'active'      => (clone $base)->where('status', 'Active')->count(),
            'inactive'    => (clone $base)->where('status', 'Inactive')->count(),
            'blacklisted' => (clone $base)->where('status', 'Blacklisted')->count(),
            'batteries'   => Battery::whereIn('vendor_id', $vendorIds)->count(),
            'tds_due'     => (clone $base)->whereNotNull('tds_percentage')
                                ->whereRaw('CAST(tds_percentage AS DECIMAL(6,2)) <= 1')->count(),
        ];

        $cityBreakdown = (clone $base)->select('city_id', DB::raw('COUNT(*) as total'))
                            ->whereNotNull('city_id')
                            ->groupBy('city_id')->orderByDesc('total')->take(4)
                            ->with('city')->get()
                            ->map(fn ($r) => ['name' => optional($r->city)->name ?? '—', 'total' => $r->total]);

        return view('V2.batteryvendor.dashboard', [
            'vendors'       => $vendors,
            'kpis'          => $kpis,
            'cityBreakdown' => $cityBreakdown,
        ]);
    }

    public function index(Request $request)
    {
        $search_name = $request->name;
        $search_city = $request->city;
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
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $contacts = $query->orderBy('id', 'desc')->paginate(10)->withQueryString();
        $contacts->getCollection()->transform(fn ($c) => $this->shapeVendor($c));

        $cities = City::whereHas('state.country', fn ($q) => $q->where('iso2', 'IN'))
                    ->orderBy('name')->get();

        // Log activity (mirrors V1 batteryVendorList).
        $this->storeUseractivity(69, 5, Auth::user()->id, 0, 'Retrieve a battery vendor list (V2)');

        return view('V2.batteryvendor.index', [
            'vendors'       => $contacts,
            'cities'        => $cities,
            'search_name'   => $search_name,
            'search_city'   => $search_city,
            'search_status' => $search_status,
        ]);
    }

    public function create()
    {
        $organisation_id = optional(Auth::user()->organisation)->id;

        return view('V2.batteryvendor.create', [
            'countries'     => Country::all(),
            'states'        => State::with(['cities' => fn ($q) => $q->orderBy('name')])
                                ->whereHas('country', fn ($q) => $q->where('iso2', 'IN'))
                                ->orderBy('name')->get(),
            'pan_statuses'  => Panstatus::where('organisation_id', $organisation_id)->orderBy('name')->get(),
            'banks'         => Bank::orderBy('name')->get(),
            'coattachtypes' => Coattachtype::orderBy('name')->get(),
        ]);
    }

    public function show($id)
    {
        $contact = Contact::where('cotype_id', self::COTYPE_ID)
                    ->with(['city', 'state', 'relcontacts', 'bankDetails.bank', 'activities.createdBy'])
                    ->findOrFail($id);

        return view('V2.batteryvendor.show', [
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

        $this->storeUseractivity(69, 5, Auth::user()->id, $contact->id, 'Retrieve battery vendor ' . $contact->contact_name . ' to edit.');

        return view('V2.batteryvendor.edit', [
            'v'             => $this->shapeVendor($contact),
            'contact'       => $contact,
            'counts'        => $this->tabCounts($contact),
            'active'        => 'edit',
            'countries'     => Country::all(),
            'states'        => State::whereHas('country', fn ($q) => $q->where('iso2', 'IN'))
                                ->orderBy('name')->get(),
            'pan_statuses'  => Panstatus::where('organisation_id', $organisation_id)->orderBy('name')->get(),
            'banks'         => Bank::orderBy('name')->get(),
        ]);
    }

    public function battery(Request $request, $id)
    {
        $contact = $this->findVendorOrFail($id);

        $query = Battery::where('vendor_id', $contact->id);
        if ($request->filled('brand')) {
            $query->where('battery_brand', $request->brand);
        }
        if ($request->filled('bstatus')) {
            $query->where('current_status', $request->bstatus);
        }
        $batteries = $query->orderBy('id', 'desc')->paginate(10, ['*'], 'battery_page')->withQueryString();

        $brands = Battery::where('vendor_id', $contact->id)
                    ->whereNotNull('battery_brand')->distinct()->orderBy('battery_brand')
                    ->pluck('battery_brand');

        return view('V2.batteryvendor.battery', [
            'v'          => $this->shapeVendor($contact),
            'counts'     => $this->tabCounts($contact),
            'active'     => 'battery',
            'batteries'  => $batteries,
            'brands'     => $brands,
            'statuses'   => self::BATTERY_STATUSES,
            'search_brand'  => $request->brand,
            'search_status' => $request->bstatus,
        ]);
    }

    public function documents($id)
    {
        $contact = $this->findVendorOrFail($id);

        return view('V2.batteryvendor.documents', [
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

        return view('V2.batteryvendor.activity', [
            'v'          => $this->shapeVendor($contact),
            'counts'     => $this->tabCounts($contact),
            'active'     => 'activity',
            'activities' => Contactactivity::with('createdBy')
                                ->where('contact_id', $contact->id)
                                ->orderByDesc('created_at')->get(),
        ]);
    }

    /* ===============================================================
     | Store / Update (← storeBatteryVendor / updateBatteryVendor)
     | =============================================================== */

    public function store(BatteryVendorRequest $request)
    {
        try {
            $contact = DB::transaction(function () use ($request) {
                $last      = Contact::withTrashed()->orderBy('id', 'DESC')->first();
                $n         = $last ? (int) $last->contactno + 1 : 1;
                $contactno = str_pad($n, 6, '0', STR_PAD_LEFT);

                $phoneCode = getPhoneCode();

                $contact = new Contact;
                $contact->contactno       = $contactno;
                $contact->cotype_id       = self::COTYPE_ID;
                $contact->organisation_id = Auth::user()->organisation_id ?? 1;
                $contact->contact_name    = $request->contact_name;
                $contact->company_name    = $request->company_name;
                $contact->contact_code    = $request->contact_code;
                $contact->no_of_vehicles  = $request->no_of_vehicles;
                $contact->ph_prefix       = $request->phone_code ?? $phoneCode;
                $contact->phone           = $request->phone;
                $contact->whatsapp_prefix = $request->whatsapp_code ?? $phoneCode;
                $contact->whatsapp        = $request->whatsapp;
                $contact->status          = $request->status ?? 'Active';
                $contact->blacklist_reason = $request->blacklist_reason;
                $contact->comment         = $request->contact_comment;
                $contact->full_company_name = $request->full_company_name;
                $contact->company_owner   = $request->company_owner;
                $contact->company_registration_no   = $request->company_registration_no;
                $contact->company_registration_date = $request->company_registration_date;
                $contact->working_since   = $request->working_since;
                $contact->pan_no          = $request->pan_no;
                $contact->pan_status_id   = $request->pan_status_id;
                // E7 — gst_treatment hard-coded; gst_number required.
                $contact->gst_treatment   = 'Registered';
                $contact->gst_number      = $request->gst_number;
                $contact->tds_percentage  = $request->tds_percentage;
                $contact->address1        = $request->address;
                $contact->state_id        = $request->state_id;
                $contact->city_id         = $request->city_id;
                $contact->zipcode         = $request->post_code;
                $contact->additional_info = $request->additional_info;
                if ($request->status === 'Blacklisted') {
                    $contact->blacklisted_at = now();
                }
                $contact->created_by      = Auth::id();
                $contact->save();

                $this->syncContactPersons($contact, $request, $phoneCode, false);
                $this->syncBanks($contact, $request);
                $this->saveCreateAttachment($contact, $request);

                $this->storeUseractivity(69, 3, Auth::id(), $contact->id, 'Added new battery vendor [ID: ' . $contact->id . '].');

                return $contact;
            });

            return response()->json([
                'success'  => true,
                'data'     => $contact,
                'message'  => 'Battery vendor saved successfully.',
                'redirect' => route('contact.v2.batteryvendor.index'),
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'data' => [], 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function update(BatteryVendorRequest $request, $id)
    {
        $contact = Contact::where('cotype_id', self::COTYPE_ID)->find($id);
        if (! $contact) {
            return response()->json(['success' => false, 'data' => [], 'message' => 'Battery vendor not found.'], 422);
        }

        try {
            $result = DB::transaction(function () use ($request, $contact) {
                $phoneCode = getPhoneCode();

                $contact->contact_name    = $request->contact_name;
                $contact->company_name    = $request->company_name;
                $contact->contact_code    = $request->contact_code;
                $contact->no_of_vehicles  = $request->no_of_vehicles;
                $contact->ph_prefix       = $request->phone_code ?? $phoneCode;
                $contact->phone           = $request->phone;
                $contact->whatsapp_prefix = $request->whatsapp_code ?? $phoneCode;
                $contact->whatsapp        = $request->whatsapp;
                $contact->status          = $request->status ?? 'Active';
                $contact->blacklist_reason = $request->blacklist_reason;
                $contact->comment         = $request->contact_comment;
                $contact->full_company_name = $request->full_company_name;
                $contact->company_owner   = $request->company_owner;
                $contact->company_registration_no   = $request->company_registration_no;
                $contact->company_registration_date = $request->company_registration_date;
                $contact->working_since   = $request->working_since;
                $contact->pan_no          = $request->pan_no;
                $contact->pan_status_id   = $request->pan_status_id;
                // E7 — gst_treatment is NOT updated; gst_number required.
                $contact->gst_number      = $request->gst_number;
                $contact->tds_percentage  = $request->tds_percentage;
                $contact->address1        = $request->address;
                $contact->state_id        = $request->state_id;
                $contact->city_id         = $request->city_id;
                $contact->zipcode         = $request->post_code;
                $contact->additional_info = $request->additional_info;
                $contact->blacklisted_at  = $request->status === 'Blacklisted' ? now() : null;
                $contact->updated_by      = Auth::id();
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

                $this->storeUseractivity(69, 4, Auth::id(), $contact->id, 'Battery vendor updated [ID: ' . $contact->id . '].');

                return $contact;
            });

            return response()->json([
                'success'  => true,
                'data'     => $result,
                'message'  => 'Battery vendor updated successfully.',
                'redirect' => route('contact.v2.batteryvendor.index'),
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
            return response()->json(['success' => false, 'message' => 'Battery vendor not found.'], 422);
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
            return response()->json(['success' => false, 'message' => 'Battery vendor not found.'], 422);
        }

        try {
            $contact->deleted_by = Auth::id();
            $contact->save();
            $contact->delete();

            return response()->json(['success' => true, 'message' => 'Battery vendor deleted.'], 200);
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
        $html = view('V2.batteryvendor.partials.contact-person', compact('rowindex'))->render();

        return response()->json(['success' => true, 'data' => $html, 'message' => 'Battery vendor contact person wrapper fetched.'], 200);
    }

    /* ===============================================================
     | Documents page — upload + delete
     | =============================================================== */

    public function storeAttachment(Request $request)
    {
        $contact = Contact::where('cotype_id', self::COTYPE_ID)->find($request->contact_id);
        if (! $contact) {
            return response()->json(['success' => false, 'data' => [], 'message' => 'Battery vendor not found!'], 422);
        }

        $validator = Validator::make($request->all(), [
            'coattachtype_id' => 'required|exists:coattachtypes,id',
            'attachment_file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ], [
            'required' => 'This field is required.',
            'mimes'    => 'File type must be jpg, jpeg, png or pdf.',
            'max'      => 'File size must not exceed 2MB.',
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

    /* ===============================================================
     | E4 — Battery supplied-items sub-page CRUD (by vendor_id)
     | =============================================================== */

    private function batteryRules(): array
    {
        return [
            'battery_serial'          => 'required|string|max:100',
            'battery_brand'           => 'required|string|max:100',
            'battery_model'           => 'nullable|string|max:100',
            'battery_capacity'        => 'required|numeric|min:0',
            'battery_voltage'         => 'required|string|max:10',
            'battery_warranty_months' => 'nullable|integer|min:0',
            'battery_purchase_date'   => 'nullable|date',
            'battery_purchase_cost'   => 'nullable|numeric|min:0',
            'current_status'          => 'nullable|in:In Stock,Installed,In Repair,Condemned,Disposed',
            'battery_notes'           => 'nullable|string|max:1000',
        ];
    }

    /** Map request fields onto a Battery model. */
    private function fillBattery(Battery $battery, Request $request): void
    {
        $battery->battery_serial          = $request->battery_serial;
        $battery->battery_brand           = $request->battery_brand;
        $battery->battery_model           = $request->battery_model;
        $battery->battery_capacity        = $request->battery_capacity;
        $battery->battery_voltage         = $request->battery_voltage;
        $battery->battery_warranty_months = $request->battery_warranty_months ?? 0;
        $battery->battery_purchase_date   = $request->battery_purchase_date;
        $battery->battery_purchase_cost   = $request->battery_purchase_cost;
        $battery->current_status          = $request->current_status ?: 'In Stock';
        $battery->battery_notes           = $request->battery_notes;
    }

    public function batterySave(Request $request)
    {
        $contact = Contact::where('cotype_id', self::COTYPE_ID)->find($request->vendor_id);
        if (! $contact) {
            return response()->json(['success' => false, 'data' => [], 'message' => 'Battery vendor not found.'], 422);
        }

        $validator = Validator::make($request->all(), $this->batteryRules(), [
            'required' => 'This field is required.',
            'numeric'  => 'Enter a valid number.',
            'in'       => 'Invalid status.',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'data' => $validator->errors(), 'message' => 'Please check validation errors.'], 422);
        }

        try {
            $battery = DB::transaction(function () use ($request, $contact) {
                $battery = new Battery;
                $battery->vendor_id       = $contact->id;
                $battery->organisation_id = Auth::user()->organisation_id ?? 1;
                $this->fillBattery($battery, $request);
                $battery->created_by      = Auth::id();
                $battery->save();

                $this->storeUseractivity(69, 3, Auth::id(), $contact->id, 'Added battery ' . $battery->battery_serial . ' to vendor [ID: ' . $contact->id . '].');

                return $battery;
            });

            return response()->json(['success' => true, 'data' => $battery, 'message' => 'Battery added successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'data' => [], 'message' => $e->getMessage()], 500);
        }
    }

    public function batteryGet($batteryId)
    {
        $battery = Battery::find($batteryId);
        if (! $battery) {
            return response()->json(['success' => false, 'data' => [], 'message' => 'Battery not found.'], 422);
        }
        return response()->json([
            'success' => true,
            'data'    => [
                'id'                      => $battery->id,
                'battery_serial'          => $battery->battery_serial,
                'battery_brand'           => $battery->battery_brand,
                'battery_model'           => $battery->battery_model,
                'battery_capacity'        => $battery->battery_capacity,
                'battery_voltage'         => $battery->battery_voltage,
                'battery_warranty_months' => $battery->battery_warranty_months,
                'battery_purchase_date'   => optional($battery->battery_purchase_date)->format('Y-m-d'),
                'battery_purchase_cost'   => $battery->battery_purchase_cost,
                'current_status'          => $battery->current_status,
                'battery_notes'           => $battery->battery_notes,
            ],
            'message' => 'Battery fetched.',
        ], 200);
    }

    public function batteryUpdate(Request $request, $batteryId)
    {
        $battery = Battery::find($batteryId);
        if (! $battery) {
            return response()->json(['success' => false, 'data' => [], 'message' => 'Battery not found.'], 422);
        }

        $validator = Validator::make($request->all(), $this->batteryRules(), [
            'required' => 'This field is required.',
            'numeric'  => 'Enter a valid number.',
            'in'       => 'Invalid status.',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'data' => $validator->errors(), 'message' => 'Please check validation errors.'], 422);
        }

        try {
            $result = DB::transaction(function () use ($request, $battery) {
                $this->fillBattery($battery, $request);
                $battery->updated_by = Auth::id();
                $battery->save();

                $this->storeUseractivity(69, 4, Auth::id(), $battery->vendor_id, 'Updated battery ' . $battery->battery_serial . ' [ID: ' . $battery->id . '].');

                return $battery;
            });

            return response()->json(['success' => true, 'data' => $result, 'message' => 'Battery updated successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'data' => [], 'message' => $e->getMessage()], 500);
        }
    }

    public function batteryDelete(Request $request)
    {
        $id = $request->input('id') ?? $request->input('battery_id');
        $battery = Battery::find($id);
        if (! $battery) {
            return response()->json(['success' => false, 'data' => [], 'message' => 'Battery not found.'], 422);
        }

        try {
            DB::transaction(function () use ($battery) {
                $battery->deleted_by = Auth::id();
                $battery->save();
                $battery->delete();
            });

            return response()->json(['success' => true, 'data' => [], 'message' => 'Battery deleted.'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'data' => [], 'message' => $e->getMessage()], 500);
        }
    }
}
