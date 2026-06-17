<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use App\Http\Requests\V2\SpareVendorRequest;
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
use App\Models\WsSparePartCategory;
use App\Models\SparePart;

use App\Traits\Useractivity;

/**
 * Spare Part Vendor Module V2 — Controller (Gate 2: live backend wiring)
 *
 * Mirrors the live V1 logic from App\Http\Controllers\ContactController spare*
 * methods into the isolated V2 module. cotype_id = 8. Reuses the existing
 * `contacts` + related tables via Eloquent only — NO schema changes.
 *
 * Spare-vendor specifics (docs/logics/contact/sparevendor.md):
 *   - specialisation = comma-joined WsSparePartCategory IDs (contacts.specialisation)
 *   - banks: DELETE-and-REINSERT on update; exactly one Primary
 *   - NO attachment save in store/update (documents added on the Documents page)
 *   - toggle-status + dedicated destroy
 *   - "Spare Parts" page is DERIVED (read-only): parts whose category is in the
 *     vendor's specialisation — no pivot table, no schema change
 *   - NO TDS Declaration enforcement (tds_percentage is an optional number)
 */
class SpareVendorController extends Controller
{
    use Useractivity;

    /** cotype_id for Spare Part Vendor. */
    private const COTYPE_ID = 8;

    /* ===============================================================
     | View-data helpers — map a Contact (cotype_id = 8) + relations
     | onto the array shape the Gate-1 V2 blades consume.
     | =============================================================== */

    /** Comma-joined specialisation IDs -> array of category names. */
    private function specNames($contact, $specMap): array
    {
        if (empty($contact->specialisation)) {
            return [];
        }
        return collect(explode(',', $contact->specialisation))
            ->map(fn ($id) => $specMap[trim($id)] ?? null)
            ->filter()
            ->values()
            ->all();
    }

    /** Spare-part category IDs from the vendor specialisation string. */
    private function specIds($contact): array
    {
        if (empty($contact->specialisation)) {
            return [];
        }
        return collect(explode(',', $contact->specialisation))
            ->map(fn ($id) => (int) trim($id))
            ->filter()
            ->values()
            ->all();
    }

    /** Derived count of catalogue parts in this vendor's specialisation categories. */
    private function suppliedItemsCount($contact): int
    {
        $ids = $this->specIds($contact);
        if (empty($ids)) {
            return 0;
        }
        return SparePart::whereIn('wssparepartscategory_id', $ids)->count();
    }

    /** Shape a single Contact into the $v[...] array the blades read. */
    private function shapeVendor(Contact $contact, $specMap): array
    {
        return [
            'id'        => $contact->id,
            'contactno' => $contact->contactno,
            'company'   => $contact->company_name ?? '—',
            'code'      => $contact->contact_code ?? '—',
            'name'      => $contact->contact_name ?? '—',
            'gst'       => $contact->gstin ?? ($contact->gst_number ?? '—'),
            'phone'     => trim(($contact->ph_prefix ? '+' . $contact->ph_prefix . ' ' : '') . $contact->phone),
            'whatsapp'  => $contact->whatsapp ? trim(($contact->whatsapp_prefix ? '+' . $contact->whatsapp_prefix . ' ' : '') . $contact->whatsapp) : '',
            'email'     => $contact->email ?? '—',
            'city'      => optional($contact->city)->name ?? '—',
            'state'     => optional($contact->state)->name ?? '—',
            'spec'      => $this->specNames($contact, $specMap),
            'tds'       => $contact->tds_percentage ?? 0,
            'banks'     => $contact->bankDetails()->count(),
            'items'     => $this->suppliedItemsCount($contact),
            'status'    => $contact->status ?? 'Active',
        ];
    }

    /** Per-page counts for the workspace subnav. */
    private function tabCounts(Contact $contact): array
    {
        return [
            'spareparts' => $this->suppliedItemsCount($contact),
            'documents'  => $contact->coattachments()->count(),
            'activity'   => $contact->activities()->count(),
            'banks'      => $contact->bankDetails()->count(),
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
        $specMap   = WsSparePartCategory::pluck('name', 'id');
        $contacts  = Contact::where('cotype_id', self::COTYPE_ID)
                        ->with(['city', 'bankDetails'])
                        ->orderBy('id', 'desc')->take(8)->get();
        $vendors   = $contacts->map(fn ($c) => $this->shapeVendor($c, $specMap))->values()->all();

        $base = Contact::where('cotype_id', self::COTYPE_ID);
        $kpis = [
            'total'       => (clone $base)->count(),
            'active'      => (clone $base)->where('status', 'Active')->count(),
            'inactive'    => (clone $base)->where('status', 'Inactive')->count(),
            'blacklisted' => (clone $base)->where('status', 'Blacklisted')->count(),
            'categories'  => WsSparePartCategory::active()->count(),
            'items'       => SparePart::count(),
        ];

        return view('V2.sparevendor.dashboard', ['vendors' => $vendors, 'kpis' => $kpis]);
    }

    public function index(Request $request)
    {
        $specMap = WsSparePartCategory::pluck('name', 'id');

        $search_name   = $request->name;
        $search_city   = $request->city;
        $search_status = $request->status;

        $query = Contact::where('cotype_id', self::COTYPE_ID)
                    ->with(['cotype', 'relcontacts', 'createdby', 'city']);

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

        $contacts = $query->orderBy('id', 'desc')->paginate(15)->withQueryString();
        $contacts->getCollection()->transform(fn ($c) => $this->shapeVendor($c, $specMap));

        $cities = City::whereHas('state.country', fn ($q) => $q->where('iso2', 'IN'))
                    ->orderBy('name')->get();

        return view('V2.sparevendor.index', [
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

        return view('V2.sparevendor.create', [
            'countries'       => Country::all(),
            'states'          => State::with(['cities' => fn ($q) => $q->orderBy('name')])
                                    ->whereHas('country', fn ($q) => $q->where('iso2', 'IN'))
                                    ->orderBy('name')->get(),
            'pan_statuses'    => Panstatus::where('organisation_id', $organisation_id)->orderBy('name')->get(),
            'banks'           => Bank::orderBy('name')->get(),
            'spareCategories' => WsSparePartCategory::active()->orderBy('name')->get(),
        ]);
    }

    public function show($id)
    {
        $specMap = WsSparePartCategory::pluck('name', 'id');
        $contact = Contact::where('cotype_id', self::COTYPE_ID)
                    ->with(['city', 'state', 'bankDetails.bank', 'activities.createdBy'])
                    ->findOrFail($id);

        $v = $this->shapeVendor($contact, $specMap);

        return view('V2.sparevendor.show', [
            'v'        => $v,
            'counts'   => $this->tabCounts($contact),
            'active'   => 'overview',
            'banks'    => $contact->bankDetails,
            'activities' => $contact->activities()->with('createdBy')->take(5)->get(),
            'topParts' => $this->vendorParts($contact)->take(5),
        ]);
    }

    public function edit($id)
    {
        $specMap = WsSparePartCategory::pluck('name', 'id');
        $contact = Contact::with([
                        'country.states', 'state.cities', 'relcontacts',
                        'bankDetails.bank', 'coattachments.coattachtype',
                        'activities', 'activities.createdBy',
                    ])
                    ->where('cotype_id', self::COTYPE_ID)
                    ->findOrFail($id);

        $organisation_id = optional(Auth::user()->organisation)->id;

        $description = 'Retrieve spare vendor ' . $contact->contact_name . ' to edit.';
        $this->storeUseractivity(69, 5, Auth::user()->id, $contact->id, $description);

        return view('V2.sparevendor.edit', [
            'v'               => $this->shapeVendor($contact, $specMap),
            'contact'         => $contact,
            'counts'          => $this->tabCounts($contact),
            'active'          => 'edit',
            'countries'       => Country::all(),
            'states'          => State::whereHas('country', fn ($q) => $q->where('iso2', 'IN'))
                                    ->orderBy('name')->get(),
            'pan_statuses'    => Panstatus::where('organisation_id', $organisation_id)->orderBy('name')->get(),
            'banks'           => Bank::orderBy('name')->get(),
            'spareCategories' => WsSparePartCategory::active()->orderBy('name')->get(),
        ]);
    }

    /** Derived catalogue parts in the vendor's specialisation categories. */
    private function vendorParts(Contact $contact)
    {
        $ids = $this->specIds($contact);
        if (empty($ids)) {
            return collect();
        }
        return SparePart::with('partCategory')
                ->whereIn('wssparepartscategory_id', $ids)
                ->orderBy('name')->get();
    }

    public function spareparts($id)
    {
        $specMap = WsSparePartCategory::pluck('name', 'id');
        $contact = $this->findVendorOrFail($id);

        return view('V2.sparevendor.spareparts', [
            'v'      => $this->shapeVendor($contact, $specMap),
            'counts' => $this->tabCounts($contact),
            'active' => 'spareparts',
            'parts'  => $this->vendorParts($contact),
        ]);
    }

    public function documents($id)
    {
        $specMap = WsSparePartCategory::pluck('name', 'id');
        $contact = $this->findVendorOrFail($id);

        return view('V2.sparevendor.documents', [
            'v'             => $this->shapeVendor($contact, $specMap),
            'counts'        => $this->tabCounts($contact),
            'active'        => 'documents',
            'coattachments' => Coattachment::with('coattachtype')->where('contact_id', $contact->id)->latest()->get(),
            'coattachtypes' => Coattachtype::orderBy('name')->get(),
        ]);
    }

    public function activity($id)
    {
        $specMap = WsSparePartCategory::pluck('name', 'id');
        $contact = $this->findVendorOrFail($id);

        return view('V2.sparevendor.activity', [
            'v'          => $this->shapeVendor($contact, $specMap),
            'counts'     => $this->tabCounts($contact),
            'active'     => 'activity',
            'activities' => Contactactivity::with('createdBy')
                                ->where('contact_id', $contact->id)
                                ->orderByDesc('created_at')->get(),
        ]);
    }

    /* ===============================================================
     | Store / Update (← storeSpareVendor / updateSpareVendor)
     | =============================================================== */

    public function store(SpareVendorRequest $request)
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
                $contact->gstin           = $request->gst_number;
                $contact->ph_prefix       = $request->phone_code ?? $phoneCode;
                $contact->phone           = $request->phone;
                $contact->whatsapp_prefix = $request->whatsapp_code ?? $phoneCode;
                $contact->whatsapp        = $request->whatsapp;
                $contact->email           = $request->email;
                $contact->status          = $request->status ?? 'Active';
                $contact->blacklist_reason = $request->blacklist_reason;
                $contact->comment         = $request->contact_comment;
                $contact->specialisation  = $request->specialisation ? implode(',', (array) $request->specialisation) : null;
                $contact->full_company_name = $request->full_company_name;
                $contact->company_owner   = $request->company_owner;
                $contact->company_registration_no   = $request->company_registration_no;
                $contact->company_registration_date = $request->company_registration_date;
                $contact->working_since   = $request->working_since;
                $contact->pan_no          = $request->pan_no;
                $contact->pan_status_id   = $request->pan_status_id;
                $contact->tds_percentage  = $request->tds_percentage;
                $contact->address1        = $request->address;
                $contact->state_id        = $request->state_id;
                $contact->city_id         = $request->city_id;
                $contact->zipcode         = $request->post_code;
                $contact->additional_info = $request->additional_info;
                $contact->created_by      = Auth::id();
                $contact->save();

                $this->syncContactPersons($contact, $request, $phoneCode, false);
                $this->syncBanks($contact, $request, false);

                $this->storeUseractivity(69, 3, Auth::id(), $contact->id, 'Added new spare vendor [ID: ' . $contact->id . '].');

                return $contact;
            });

            return response()->json([
                'success'  => true,
                'data'     => $contact,
                'message'  => 'Spare vendor added successfully.',
                'redirect' => route('contact.v2.sparevendor.index'),
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'data' => [], 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function update(SpareVendorRequest $request, $id)
    {
        $contact = Contact::where('cotype_id', self::COTYPE_ID)->find($id);
        if (! $contact) {
            return response()->json(['success' => false, 'data' => [], 'message' => 'Spare vendor not found.'], 422);
        }

        try {
            $result = DB::transaction(function () use ($request, $contact) {
                $phoneCode = getPhoneCode();

                $contact->contact_name    = $request->contact_name;
                $contact->company_name    = $request->company_name;
                $contact->contact_code    = $request->contact_code;
                $contact->gstin           = $request->gst_number;
                $contact->ph_prefix       = $request->phone_code ?? $phoneCode;
                $contact->phone           = $request->phone;
                $contact->whatsapp_prefix = $request->whatsapp_code ?? $phoneCode;
                $contact->whatsapp        = $request->whatsapp;
                $contact->email           = $request->email;
                $contact->status          = $request->status ?? 'Active';
                $contact->blacklist_reason = $request->blacklist_reason;
                $contact->comment         = $request->contact_comment;
                $contact->specialisation  = $request->specialisation ? implode(',', (array) $request->specialisation) : null;
                $contact->full_company_name = $request->full_company_name;
                $contact->company_owner   = $request->company_owner;
                $contact->company_registration_no   = $request->company_registration_no;
                $contact->company_registration_date = $request->company_registration_date;
                $contact->working_since   = $request->working_since;
                $contact->pan_no          = $request->pan_no;
                $contact->pan_status_id   = $request->pan_status_id;
                $contact->tds_percentage  = $request->tds_percentage;
                $contact->address1        = $request->address;
                $contact->state_id        = $request->state_id;
                $contact->city_id         = $request->city_id;
                $contact->zipcode         = $request->post_code;
                $contact->additional_info = $request->additional_info;
                $contact->updated_by      = Auth::id();
                $contact->save();

                if ($request->get('status') === 'Blacklisted' && $request->filled('blacklist_reason')) {
                    $activity = new Contactactivity();
                    $activity->contact_id    = $contact->id;
                    $activity->notes         = $request->blacklist_reason;
                    $activity->is_blacklisted = 'Yes';
                    $activity->created_by    = Auth::id();
                    $activity->save();
                }

                $this->syncContactPersons($contact, $request, $phoneCode, true);
                $this->syncBanks($contact, $request, true);

                $this->storeUseractivity(69, 4, Auth::id(), $contact->id, 'Spare vendor updated [ID: ' . $contact->id . '].');

                return $contact;
            });

            return response()->json([
                'success'  => true,
                'data'     => $result,
                'message'  => 'Spare vendor updated successfully.',
                'redirect' => route('contact.v2.sparevendor.index'),
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
            $cp->ph_prefix = $phoneCode;
            $cp->phone     = $phones[$idx]   ?? null;
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

    /** Banks: store = insert; update = DELETE-and-REINSERT (sparevendor.md rule). */
    private function syncBanks(Contact $contact, $request, bool $isUpdate): void
    {
        if ($isUpdate) {
            Contactbank::where('contact_id', $contact->id)->delete();
        }

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

    /* ===============================================================
     | Toggle status / Destroy (← toggle/destroySpareVendor)
     | =============================================================== */

    public function toggleStatus(Request $request, $id)
    {
        $contact = Contact::where('cotype_id', self::COTYPE_ID)->find($id);
        if (! $contact) {
            return response()->json(['success' => false, 'message' => 'Spare vendor not found.'], 422);
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
            return response()->json(['success' => false, 'message' => 'Spare vendor not found.'], 422);
        }

        try {
            $contact->deleted_by = Auth::id();
            $contact->save();
            $contact->delete();

            return response()->json(['success' => true, 'message' => 'Spare vendor deleted.'], 200);
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
        $html = view('V2.sparevendor.partials.contact-person', compact('rowindex'))->render();

        return response()->json(['success' => true, 'data' => $html, 'message' => 'Spare vendor contact person wrapper fetched.'], 200);
    }

    /* ===============================================================
     | Documents page — upload + delete (mirrors customer V2)
     | =============================================================== */

    public function storeAttachment(Request $request)
    {
        $contact = Contact::where('cotype_id', self::COTYPE_ID)->find($request->contact_id);
        if (! $contact) {
            return response()->json(['success' => false, 'data' => [], 'message' => 'Spare vendor not found!'], 422);
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
                $filename = 'contact-attachment-' . Str::random(4) . '_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('media' . DIRECTORY_SEPARATOR . 'contact' . DIRECTORY_SEPARATOR), $filename);

                $attachment = new Coattachment;
                $attachment->name            = $filename;
                $attachment->original_name   = $file->getClientOriginalName();
                $attachment->file_size       = ($request->file('attachment_file')->getSize() / (1024 * 1024));
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
     | Activity page — add note (mirrors customer V2)
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
}
