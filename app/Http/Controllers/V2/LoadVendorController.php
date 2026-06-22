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
use App\Models\Customerabouttype;
use App\Models\Gsttreat;
use App\Models\Coattachtype;
use App\Models\Coattachment;
use App\Models\Relcontact;
use App\Models\Loadvendorlocation;
use App\Models\Contactactivity;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Closure;
use Illuminate\View\View;

use App\Traits\Useractivity;

/**
 * Load Vendor (Broker) Module V2 — Controller (Gate 2: live backend wiring)
 *
 * Ports the live V1 logic from App\Http\Controllers\ContactController (Load Vendor
 * methods, cotype_id = 2) into the isolated V2 Load Vendor module. Reuses the
 * existing `contacts`, `relcontacts`, `loadvendorlocations`, `coattachments` and
 * `contactactivities` tables via Eloquent only — NO schema changes. The GET screen
 * methods keep the exact $v[...] / $counts[...] array-key shape the Gate-1 V2 blades
 * already consume, but populate every value from real Eloquent records.
 *
 * Load Vendor specifics preserved: company_name, contact_code, contact_alias->alias,
 * rag_status; contact-person designation REQUIRED; NO billing section; Location
 * "Charges Paid By" = Load Vendor / SRL / Mixed (loadvendor/srl/mixed).
 */
class LoadVendorController extends Controller
{
    use Useractivity;

    const CONTACT_TYPE_LOAD_VENDOR = 2;

    /* ===============================================================
     | View-data helpers — map a Contact (cotype_id = 2) + relations
     | onto the EXACT array shape the Gate-1 V2 blades consume.
     | =============================================================== */

    private function shapeVendor(Contact $contact): array
    {
        return [
            'id'        => $contact->id,
            'contactno' => $contact->contactno,
            'company'   => $contact->company_name ?? '—',
            'name'      => $contact->contact_name ?? '—',
            'code'      => $contact->contact_code ?? '—',
            'alias'     => $contact->alias ?? '',
            'size'      => $contact->size ?? '—',
            'rag'       => $contact->rag_status ?? '—',
            'phone'     => trim(($contact->ph_prefix ? '+' . ltrim($contact->ph_prefix, '+') . ' ' : '') . $contact->phone),
            'city'      => optional($contact->city)->name ?? '—',
            'locations' => $contact->loadvendorlocations()->count(),
            'status'    => $contact->status ?? 'Active',
            'email'     => $contact->email ?? '—',
        ];
    }

    private function tabCounts(Contact $contact): array
    {
        return [
            'customers'  => $contact->relcontacts()->count(),
            'locations'  => $contact->loadvendorlocations()->count(),
            'documents'  => $contact->coattachments()->count(),
            'activity'   => $contact->activities()->count(),
        ];
    }

    private function findVendorOrFail($id): Contact
    {
        return Contact::where('cotype_id', self::CONTACT_TYPE_LOAD_VENDOR)->findOrFail($id);
    }

    /** B9 — sub-entity writes are blocked when the vendor is not Active. */
    private function vendorWriteLocked(Contact $contact): bool
    {
        return in_array($contact->status, ['Inactive', 'Blacklisted'], true);
    }

    /* ===============================================================
     | Screens (public GET) — real Eloquent, Gate-1 array-key shape
     | =============================================================== */

    public function dashboard()
    {
        $base    = Contact::where('cotype_id', self::CONTACT_TYPE_LOAD_VENDOR);
        $total   = (clone $base)->count();
        $active  = (clone $base)->where('status', 'Active')->count();
        $inactive= (clone $base)->where('status', 'Inactive')->count();
        $black   = (clone $base)->where('status', 'Blacklisted')->count();
        $ragGreen= (clone $base)->where('rag_status', 'Green')->count();
        $ragRed  = (clone $base)->where('rag_status', 'Red')->count();

        $contacts = (clone $base)->with(['city'])->orderBy('id', 'desc')->take(8)->get();
        $vendors  = $contacts->map(fn ($c) => $this->shapeVendor($c))->values()->all();

        $sizeLarge  = (clone $base)->where('size', 'Large')->count();
        $sizeMedium = (clone $base)->where('size', 'Medium')->count();
        $sizeSmall  = (clone $base)->where('size', 'Small')->count();

        return view('V2.loadvendor.dashboard', [
            'vendors'  => $vendors,
            'kpi'      => compact('total', 'active', 'inactive', 'black', 'ragGreen', 'ragRed'),
            'sizes'    => compact('sizeLarge', 'sizeMedium', 'sizeSmall'),
        ]);
    }

    public function index(Request $request)
    {
        $search_name     = $request->name;
        $search_city     = $request->city;
        $search_size     = $request->size;
        $search_rag      = $request->rag;
        $search_location = $request->location;

        $query = Contact::where('cotype_id', self::CONTACT_TYPE_LOAD_VENDOR)
                        ->with(['cotype', 'relcontacts', 'loadvendorlocations', 'city']);

        if ($request->filled('name')) {
            $query->where('contact_name', 'like', '%' . $request->name . '%');
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
        if ($request->filled('location')) {
            $query->whereHas('loadvendorlocations', function ($q) use ($request) {
                $q->where('id', $request->location);
            });
        }

        $contacts = $query->orderBy('id', 'desc')->paginate(10)->withQueryString();
        $contacts->getCollection()->transform(fn ($c) => $this->shapeVendor($c));

        $cities = City::whereHas('state.country', function ($q) {
                        $q->where('iso2', 'IN');
                    })->orderBy('name')->get();

        $locationNames = Loadvendorlocation::query()
                            ->whereNull('deleted_at')
                            ->whereNotNull('location_name')
                            ->distinct()
                            ->orderBy('location_name')
                            ->pluck('location_name', 'id');

        return view('V2.loadvendor.index', [
            'vendors'         => $contacts,
            'cities'          => $cities,
            'locationNames'   => $locationNames,
            'search_name'     => $search_name,
            'search_city'     => $search_city,
            'search_size'     => $search_size,
            'search_rag'      => $search_rag,
            'search_location' => $search_location,
        ]);
    }

    public function create()
    {
        $countries     = Country::all();
        $states        = State::with(['cities' => fn ($q) => $q->orderBy('name')])
                            ->whereHas('country', fn ($q) => $q->where('iso2', 'IN'))
                            ->orderBy('name')->get();
        $coattachtypes = Coattachtype::all();

        return view('V2.loadvendor.create', compact('countries', 'states', 'coattachtypes'));
    }

    public function show($id)
    {
        $contact = $this->findVendorOrFail($id);
        $v       = $this->shapeVendor($contact);

        $persons          = $contact->relcontacts()->orderBy('id', 'asc')->take(5)->get();
        $recentActivities = Contactactivity::with('createdBy')
                                ->where('contact_id', $contact->id)
                                ->orderByDesc('created_at')->take(5)->get();

        return view('V2.loadvendor.show', [
            'v'                => $v,
            'counts'           => $this->tabCounts($contact),
            'active'           => 'overview',
            'persons'          => $persons,
            'recentActivities' => $recentActivities,
        ]);
    }

    public function edit($id)
    {
        $contact = Contact::with([
                        'state.cities',
                        'relcontacts' => fn ($q) => $q->orderBy('id', 'asc'),
                        'coattachments.coattachtype',
                        'city',
                    ])
                    ->where('cotype_id', self::CONTACT_TYPE_LOAD_VENDOR)
                    ->findOrFail($id);

        $v             = $this->shapeVendor($contact);
        $states        = State::with(['cities' => fn ($q) => $q->orderBy('name')])
                            ->whereHas('country', fn ($q) => $q->where('iso2', 'IN'))
                            ->orderBy('name')->get();
        $coattachtypes = Coattachtype::all();

        return view('V2.loadvendor.edit', [
            'v'             => $v,
            'contact'       => $contact,
            'counts'        => $this->tabCounts($contact),
            'active'        => 'edit',
            'states'        => $states,
            'coattachtypes' => $coattachtypes,
        ]);
    }

    public function customers($id)
    {
        $contact = $this->findVendorOrFail($id);
        $v       = $this->shapeVendor($contact);

        $persons = $contact->relcontacts()->orderBy('id', 'asc')->get();

        return view('V2.loadvendor.customers', [
            'v'       => $v,
            'counts'  => $this->tabCounts($contact),
            'active'  => 'customers',
            'persons' => $persons,
        ]);
    }

    public function locations($id)
    {
        $contact = $this->findVendorOrFail($id);
        $v       = $this->shapeVendor($contact);

        // Distinct cities used across this vendor's existing locations feed the modal selects.
        $cities = City::whereHas('state.country', fn ($q) => $q->where('iso2', 'IN'))
                        ->orderBy('name')->get();

        return view('V2.loadvendor.locations', [
            'v'      => $v,
            'counts' => $this->tabCounts($contact),
            'active' => 'locations',
            'cities' => $cities,
        ]);
    }

    public function documents($id)
    {
        $contact = $this->findVendorOrFail($id);
        $v       = $this->shapeVendor($contact);

        $coattachments = Coattachment::with('coattachtype')
                            ->where('contact_id', $contact->id)->latest()->get();
        $coattachtypes = Coattachtype::orderBy('name')->get();

        return view('V2.loadvendor.documents', [
            'v'             => $v,
            'counts'        => $this->tabCounts($contact),
            'active'        => 'documents',
            'coattachments' => $coattachments,
            'coattachtypes' => $coattachtypes,
        ]);
    }

    public function activity($id)
    {
        $contact = $this->findVendorOrFail($id);
        $v       = $this->shapeVendor($contact);

        $activities = Contactactivity::with('createdBy')
                        ->where('contact_id', $contact->id)
                        ->orderByDesc('created_at')->get();

        return view('V2.loadvendor.activity', [
            'v'          => $v,
            'counts'     => $this->tabCounts($contact),
            'active'     => 'activity',
            'activities' => $activities,
        ]);
    }

    /* ===============================================================
     | Load Vendor create / update (← storeLoadvendor / updateLoadvendor)
     | NO billing section. company_name / contact_code / alias / rag_status.
     | =============================================================== */

    public function store(Request $request)
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

        // BV-D2 / B8 — normalise every dial-code prefix to '+<code>' so an edit-save never
        // flips '+91'->'91' and the duplicate-phone guard always compares a consistent format.
        $request->merge([
            'phone_code'    => $request->filled('phone_code')    ? '+' . ltrim($request->phone_code, '+')    : $request->phone_code,
            'whatsapp_code' => $request->filled('whatsapp_code') ? '+' . ltrim($request->whatsapp_code, '+') : $request->whatsapp_code,
        ]);
        if ($request->has('contact_person_ph_code')) {
            $request->merge(['contact_person_ph_code' => array_map(fn ($c) => $c ? '+' . ltrim($c, '+') : $c, (array) $request->contact_person_ph_code)]);
        }
        if ($request->has('contact_person_whatsapp_code')) {
            $request->merge(['contact_person_whatsapp_code' => array_map(fn ($c) => $c ? '+' . ltrim($c, '+') : $c, (array) $request->contact_person_whatsapp_code)]);
        }

        $validate_phone = function ($attribute, $value, $fail) use ($request) {
            $code = ltrim($request->phone_code ?? getPhoneCode(), '+');
            if (Contact::where('phone', $value)->whereIn('ph_prefix', ['+' . $code, $code])->exists()) {
                $fail('This phone number already exists.');
            }
        };

        $validator = Validator::make($request->all(), [
            'company_name'        => 'required|max:100',
            'contact_name'        => 'required|max:100',
            'contact_code'        => 'required|max:100',
            'contact_alias'       => 'nullable|max:100',
            'email'               => 'nullable|email|unique:contacts,email',
            'phone'               => ['required', 'digits:10', $validate_phone],
            'whatsapp'            => ['nullable', 'digits:10'],
            'size'                => 'nullable|in:Small,Medium,Large',
            'status'              => 'nullable|in:Active,Inactive,Blacklisted',
            'blacklist_reason'    => 'required_if:status,Blacklisted',
            'rag_status'          => 'nullable|in:Red,Yellow,Green',
            'contact_comment'     => 'nullable|string|max:255',
            // Head Office Address removed for V1 parity (V1 Load Vendor had no head-office address):
            // 'address'             => 'nullable|max:100',
            // 'state_id'            => 'nullable|exists:states,id',
            // 'city_id'             => 'nullable|exists:cities,id',
            // 'post_code'           => 'nullable|digits:6',
            // 'head_office_map_location' => 'nullable|string|max:255',

            'contact_person_name'          => 'required|array|min:1',
            'contact_person_name.*'        => 'required|string|distinct|min:1',
            'contact_person_designation'   => 'required|array|min:1',
            'contact_person_designation.*' => 'required|string|min:1',
            'contact_person_ph_code'       => 'nullable|array|min:1',
            'contact_person_phone'         => 'required|array|min:1',
            'contact_person_phone.*'       => ['required', 'distinct', 'digits:10'],
            'contact_person_whatsapp'      => 'nullable|array|min:1',
            'contact_person_whatsapp.*'    => ['nullable', 'distinct', 'digits:10'],
            'contact_person_email'         => 'nullable|array|min:1',
            'contact_person_email.*'       => 'nullable|email|distinct',
            'contact_person_comment'       => 'nullable|array|min:1',
            'contact_person_comment.*'     => 'nullable|string|min:1',

            'attachtypes'   => 'nullable|array',
            'attachtypes.*' => 'nullable|exists:coattachtypes,id',
            'files'         => 'nullable|array',
            'files.*'       => 'nullable|array|max:2',
            'files.*.*'     => 'file|mimes:jpg,jpeg,png,pdf|max:2048',
        ], [
            'required'                => 'This field is required.',
            'max'                     => 'Maximum 100 characters allowed.',
            'contact_comment.max'     => 'Maximum 255 characters allowed.',
            'exists'                  => "This field's value is invalid.",
            'distinct'                => 'Duplicate value.',
            'email'                   => 'This email is invalid.',
            'email.unique'            => 'This email is already in use.',
            'phone.digits'            => 'This field must contain 10 digits.',
            'whatsapp.digits'         => 'This field must contain 10 digits.',
            'contact_person_phone.*.digits'    => 'This field must contain 10 digits.',
            'contact_person_whatsapp.*.digits' => 'This field must contain 10 digits.',
            'contact_name.required'   => 'This field is required.',
            'contact_person_designation.*.required' => 'Designation is required.',
            'blacklist_reason.required_if' => 'Blacklist reason is required when status is Blacklisted.',
            'files.*.max'             => 'You cannot upload more than 2 files.',
            'files.*.*.mimes'         => 'File type must be jpg, jpeg, png or pdf.',
            'files.*.*.max'           => 'File size must not exceed 2MB.',
        ]);

        $errorcount = 0;
        $errors = [];

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
                $errorcount++; $errors['coattachtype_' . $key] = ['Document type is required.']; continue;
            }
            if (!empty($attachtype) && empty($files)) {
                $errorcount++; $errors['coattachments_' . $key] = ['Please upload file.']; continue;
            }
            if (in_array($attachtype, $attachtype_ids)) {
                $errorcount++; $errors['coattachtype_' . $key] = ['You have already added this attachment type.']; continue;
            }
            $attachtype_ids[] = $attachtype;

            if (!empty($files)) {
                if (count($files) > 2) {
                    $errorcount++; $errors['coattachments_' . $key] = ['You cannot upload more than 2 files.'];
                }
                foreach ($files as $file) {
                    $extension = strtolower($file->getClientOriginalExtension());
                    $size      = $file->getSize();
                    if (!in_array($extension, ['jpg', 'jpeg', 'png', 'pdf'])) {
                        $errorcount++; $errors['coattachments_' . $key] = ['File type must be jpg, jpeg, png or pdf.'];
                    }
                    if ($size > 2097152) {
                        $errorcount++; $errors['coattachments_' . $key] = ['File size must not exceed 2MB.'];
                    }
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
                    $incr_lastcontact = ((int) $lastcontact->contactno) + 1;
                    if (strlen($incr_lastcontact) < 5) {
                        $contactno = '0';
                        for ($i = 0; $i < (5 - strlen($incr_lastcontact)); $i++) { $contactno .= '0'; }
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
                $contact->cotype_id       = self::CONTACT_TYPE_LOAD_VENDOR;
                $contact->organisation_id = Auth::user()->organisation_id ?? 1;
                $contact->contact_name    = $request->get('contact_name');
                $contact->company_name    = $request->get('company_name');
                $contact->contact_code    = $request->get('contact_code');
                $contact->alias           = $request->get('contact_alias');
                $contact->email           = $request->get('email');
                $contact->ph_prefix       = $request->phone_code ?? $phoneCode;
                $contact->phone           = $request->get('phone');
                $contact->whatsapp_prefix = $request->whatsapp_code ?? $phoneCode;
                $contact->whatsapp        = $request->get('whatsapp');
                $contact->size            = $request->get('size');
                $contact->status          = $request->get('status') ?? 'Active';
                $contact->blacklist_reason = $request->get('blacklist_reason') ?? null;
                $contact->rag_status      = $request->get('rag_status') ?? null;
                $contact->comment         = $request->get('contact_comment');
                // Head Office Address NOT persisted — V1 Load Vendor never had one
                // (storeLoadvendor saved no address/state/city/zip/map). Kept out for V1 parity.
                // $contact->address1        = $request->get('address');
                // $contact->state_id        = $request->get('state_id');
                // $contact->city_id         = $request->get('city_id');
                // $contact->zipcode         = $request->get('post_code');
                // $contact->head_office_map_location = $request->get('head_office_map_location');
                $contact->created_by      = Auth::user()->id;
                $contact->save();

                // Contact Persons (designation required for Load Vendor)
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
                                $filename = 'contact-attachment-' . Str::random(4) . '_' . time() . '.' . $extension;
                                $file->move(public_path('media' . DIRECTORY_SEPARATOR . 'contact' . DIRECTORY_SEPARATOR), $filename);

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

                $this->storeUseractivity(4, 3, Auth::user()->id, $contact->id, 'Added new load vendor contact with ID ' . $contact->id);

                return $contact;
            });

            return response()->json(['success' => true, 'data' => $contact, 'message' => 'Load Vendor (Broker) saved successfully.'], 200);

        } catch (\Exception $exp) {
            return response()->json(['success' => false, 'data' => [], 'message' => $exp->getMessage()], 500);
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

        // BV-D2 / B8 — normalise every dial-code prefix to '+<code>' so an edit-save never
        // flips '+91'->'91' and the duplicate-phone guard always compares a consistent format.
        $request->merge([
            'phone_code'    => $request->filled('phone_code')    ? '+' . ltrim($request->phone_code, '+')    : $request->phone_code,
            'whatsapp_code' => $request->filled('whatsapp_code') ? '+' . ltrim($request->whatsapp_code, '+') : $request->whatsapp_code,
        ]);
        if ($request->has('contact_person_ph_code')) {
            $request->merge(['contact_person_ph_code' => array_map(fn ($c) => $c ? '+' . ltrim($c, '+') : $c, (array) $request->contact_person_ph_code)]);
        }
        if ($request->has('contact_person_whatsapp_code')) {
            $request->merge(['contact_person_whatsapp_code' => array_map(fn ($c) => $c ? '+' . ltrim($c, '+') : $c, (array) $request->contact_person_whatsapp_code)]);
        }

        $validate_phone = function (string $attribute, mixed $value, Closure $fail) use ($id) {
            $code = ltrim(getPhoneCode(), '+');
            if (Contact::where('phone', $value)->whereIn('ph_prefix', ['+' . $code, $code])->where('id', '!=', $id)->exists()) {
                $fail('This phone number already exists.');
            }
        };

        $contact = Contact::where('cotype_id', self::CONTACT_TYPE_LOAD_VENDOR)->find($id);
        if (!$contact) {
            return response()->json(['success' => false, 'data' => [], 'message' => 'Load Vendor not found.'], 422);
        }

        $validator = Validator::make($request->all(), [
            'company_name'        => 'required|max:100',
            'contact_name'        => 'required|max:100',
            'contact_code'        => 'required|max:100',
            'contact_alias'       => 'nullable|max:100',
            'email'               => ['nullable', 'email', Rule::unique('contacts', 'email')->ignore($id)],
            'phone'               => ['required', 'digits:10', $validate_phone],
            'whatsapp'            => ['nullable', 'digits:10'],
            'size'                => 'nullable|in:Small,Medium,Large',
            'status'              => 'nullable|in:Active,Inactive,Blacklisted',
            'blacklist_reason'    => 'required_if:status,Blacklisted',
            'rag_status'          => 'nullable|in:Red,Yellow,Green',
            'contact_comment'     => 'nullable|string|max:255',
            // Head Office Address removed for V1 parity (V1 Load Vendor had no head-office address):
            // 'address'             => 'nullable|max:100',
            // 'state_id'            => 'nullable|exists:states,id',
            // 'city_id'             => 'nullable|exists:cities,id',
            // 'post_code'           => 'nullable|digits:6',
            // 'head_office_map_location' => 'nullable|string|max:255',

            'contact_person_name'          => 'required|array|min:1',
            'contact_person_name.*'        => 'required|string|distinct|min:1',
            'contact_person_designation'   => 'required|array|min:1',
            'contact_person_designation.*' => 'required|string|min:1',
            'contact_person_ph_code'       => 'nullable|array|min:1',
            'contact_person_phone'         => 'required|array|min:1',
            'contact_person_phone.*'       => ['required', 'distinct', 'digits:10'],
            'contact_person_whatsapp'      => 'nullable|array|min:1',
            'contact_person_whatsapp.*'    => ['nullable', 'distinct', 'digits:10'],
            'contact_person_email'         => 'nullable|array|min:1',
            'contact_person_email.*'       => 'nullable|email|distinct',
            'contact_person_comment'       => 'nullable|array|min:1',
            'contact_person_comment.*'     => 'nullable|string|min:1',
        ], [
            'required'                => 'This field is required.',
            'max'                     => 'Maximum 100 characters allowed.',
            'contact_comment.max'     => 'Maximum 255 characters allowed.',
            'exists'                  => "This field's value is invalid.",
            'distinct'                => 'Duplicate value.',
            'email'                   => 'This email is invalid.',
            'email.unique'            => 'This email is already in use.',
            'phone.digits'            => 'This field must contain 10 digits.',
            'whatsapp.digits'         => 'This field must contain 10 digits.',
            'contact_person_phone.*.digits'    => 'This field must contain 10 digits.',
            'contact_person_whatsapp.*.digits' => 'This field must contain 10 digits.',
            'contact_name.required'   => 'This field is required.',
            'contact_person_designation.*.required' => 'Designation is required.',
            'blacklist_reason.required_if' => 'Blacklist reason is required when status is Blacklisted.',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'data' => $validator->getMessageBag()->toArray(), 'message' => 'Please check validation error.'], 422);
        }

        try {
            $result = DB::transaction(function () use ($request, $contact) {

                $phoneCode = getPhoneCode();

                $contact->contact_name    = $request->get('contact_name');
                $contact->company_name    = $request->get('company_name');
                $contact->contact_code    = $request->get('contact_code');
                $contact->alias           = $request->get('contact_alias');
                $contact->email           = $request->get('email');
                $contact->ph_prefix       = $request->phone_code ?? $phoneCode;
                $contact->phone           = $request->get('phone');
                $contact->whatsapp_prefix = $request->whatsapp_code ?? $phoneCode;
                $contact->whatsapp        = $request->get('whatsapp');
                $contact->size            = $request->get('size');
                $contact->status          = $request->get('status') ?? 'Active';
                if ($request->get('status') === 'Blacklisted') {
                    $contact->blacklisted_at = now();
                } else {
                    $contact->blacklisted_at = null;
                }
                $contact->blacklist_reason = $request->get('blacklist_reason') ?? null;
                $contact->rag_status       = $request->get('rag_status') ?? null;
                $contact->comment          = $request->get('contact_comment');
                // Head Office Address NOT persisted — V1 Load Vendor never had one. Kept out for V1 parity.
                // $contact->address1         = $request->get('address');
                // $contact->state_id         = $request->get('state_id');
                // $contact->city_id          = $request->get('city_id');
                // $contact->zipcode          = $request->get('post_code');
                // $contact->head_office_map_location = $request->get('head_office_map_location');
                $contact->updated_by       = Auth::user()->id;
                $contact->save();

                if ($request->get('status') === 'Blacklisted' && $request->filled('blacklist_reason')) {
                    $activity = new Contactactivity();
                    $activity->contact_id = $contact->id;
                    $activity->notes = $request->blacklist_reason;
                    $activity->is_blacklisted = 'Yes';
                    $activity->created_by = Auth::user()->id;
                    $activity->save();
                }

                // Sync Relcontacts (upsert by contact_person_id, delete missing)
                $relcontact_ids = [];
                foreach ($request->contact_person_name ?? [] as $i => $name) {
                    $rel = Relcontact::find($request->contact_person_id[$i] ?? 0);
                    if (!$rel) {
                        $rel = new Relcontact();
                        $rel->contact_id = $contact->id;
                    }
                    $ph_code = $request->contact_person_ph_code[$i] ?? $phoneCode;
                    $whatsapp_code = $request->contact_person_whatsapp_code[$i] ?? $phoneCode;

                    $rel->name      = $name;
                    $rel->position  = $request->contact_person_designation[$i] ?? null;
                    $rel->ph_prefix = $ph_code ?? $phoneCode;
                    $rel->phone     = $request->contact_person_phone[$i] ?? null;
                    $rel->whatsapp_prefix = $whatsapp_code ?? $phoneCode;
                    $rel->whatsapp  = $request->contact_person_whatsapp[$i] ?? null;
                    $rel->email     = $request->contact_person_email[$i] ?? null;
                    $rel->comment   = $request->contact_person_comment[$i] ?? null;
                    $rel->save();
                    $relcontact_ids[] = $rel->id;
                }
                Relcontact::where('contact_id', $contact->id)->whereNotIn('id', $relcontact_ids)->delete();

                $this->storeUseractivity(4, 4, Auth::user()->id, $contact->id, 'Load Vendor Updated [ID: ' . $contact->id . '].');

                return $contact;
            });

            return response()->json(['success' => true, 'data' => $result, 'message' => 'Load Vendor updated successfully.'], 200);

        } catch (\Exception $exp) {
            return response()->json(['success' => false, 'data' => [], 'message' => $exp->getMessage()], 500);
        }
    }

    /* ===============================================================
     | Contact person wrapper (← loadvendor_contactPersonWrapper)
     | Renders a V2 contact-person row partial (designation REQUIRED).
     | =============================================================== */

    public function contactPersonWrapper(Request $request)
    {
        $rowindex = $request->get('rowindex');
        $html = view('V2.loadvendor.partials.contact-person', compact('rowindex'))->render();

        return response()->json(['success' => true, 'data' => $html, 'message' => 'Load vendor contact person wrapper fetched.'], 200);
    }

    /* ===============================================================
     | Standalone contact-person CRUD (Customers submodule page modal)
     | =============================================================== */

    public function storeContactPerson(Request $request)
    {
        $contact = Contact::where('cotype_id', self::CONTACT_TYPE_LOAD_VENDOR)->find($request->contact_id);
        if (!$contact) {
            return response()->json(['success' => false, 'data' => [], 'message' => 'Load Vendor not found!'], 422);
        }

        $request->merge([
            'contact_person_phone'    => preg_replace('/\s+/', '', $request->contact_person_phone),
            'contact_person_whatsapp' => preg_replace('/\s+/', '', $request->contact_person_whatsapp),
        ]);

        $validator = Validator::make($request->all(), [
            'contact_person_name'        => 'required|string|max:100',
            'contact_person_designation' => 'required|string|max:100',
            'contact_person_phone'       => 'required|digits:10',
            'contact_person_whatsapp'    => 'nullable|digits:10',
            'contact_person_email'       => 'nullable|email',
            'contact_person_comment'     => 'nullable|string|max:255',
        ], [
            'required'      => 'This field is required.',
            'digits'        => 'This field must contain 10 digits.',
            'email'         => 'This email is invalid.',
            'contact_person_designation.required' => 'Designation is required.',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'data' => $validator->errors(), 'message' => 'Please check validation errors.'], 422);
        }

        try {
            $rel = DB::transaction(function () use ($request, $contact) {
                $phoneCode = getPhoneCode();

                $rel = Relcontact::find($request->contact_person_id);
                if (!$rel) {
                    $rel = new Relcontact();
                    $rel->contact_id = $contact->id;
                    $rel->created_by = Auth::user()->id;
                }
                $rel->name      = $request->contact_person_name;
                $rel->position  = $request->contact_person_designation;
                $rel->ph_prefix = $request->contact_person_ph_code ?? $phoneCode;
                $rel->phone     = $request->contact_person_phone;
                $rel->whatsapp_prefix = $request->contact_person_whatsapp_code ?? $phoneCode;
                $rel->whatsapp  = $request->contact_person_whatsapp;
                $rel->email     = $request->contact_person_email;
                $rel->comment   = $request->contact_person_comment;
                $rel->save();

                $this->storeUseractivity(4, 4, Auth::user()->id, $contact->id, 'Load Vendor contact person saved [ID: ' . $rel->id . '].');

                return $rel;
            });

            return response()->json(['success' => true, 'data' => $rel, 'message' => 'Contact person saved successfully.'], 200);

        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'data' => [], 'message' => $e->getMessage()], 500);
        }
    }

    public function deleteContactPerson(Request $request)
    {
        $rel = Relcontact::find($request->id);
        if (!$rel) {
            return response()->json(['success' => false, 'message' => 'Contact person not found.'], 422);
        }

        try {
            DB::transaction(function () use ($rel) {
                $rel->delete();
                return $rel;
            });

            return response()->json(['success' => true, 'message' => 'Contact person deleted successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    /* ===============================================================
     | Load Vendor Locations (← filter/store/delete/getLoadvendorMidpoints)
     | Charges Paid By = Load Vendor / SRL / Mixed -> loadvendorlocations.
     | =============================================================== */

    public function filterLocations(Request $request, $id)
    {
        $query = Loadvendorlocation::with(['sourceCity', 'destinationCity', 'midpointCity'])
                    ->where('contact_id', $id);

        if ($request->location_type) {
            $query->where('location_type', $request->location_type);
        }

        $locations = $query->latest()->get();

        return view('V2.loadvendor.partials.locations-list', compact('locations'))->render();
    }

    public function storeLocation(Request $request)
    {
        $contact = Contact::where('cotype_id', self::CONTACT_TYPE_LOAD_VENDOR)->find($request->contact_id);
        if (!$contact) {
            return response()->json(['success' => false, 'data' => [], 'message' => 'Load Vendor not found!'], 422);
        }

        if ($this->vendorWriteLocked($contact)) {
            return response()->json(['success' => false, 'data' => [], 'message' => 'This load vendor is not Active — records cannot be added.'], 422);
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
            'source_city_id'      => ['nullable', 'exists:cities,id', Rule::requiredIf($request->route_type === 'source')],
            'destination_city_id' => ['nullable', 'exists:cities,id', Rule::requiredIf($request->route_type === 'destination')],
            'midpoint_city_id'    => ['nullable', 'exists:cities,id', Rule::requiredIf($request->route_type === 'midpoint')],
            'loading_charge_type' => ['nullable', Rule::requiredIf(in_array($request->location_type, ['Loading', 'Both']))],
            'loading_charge'      => array_merge($decimalRule, [Rule::requiredIf(in_array($request->location_type, ['Loading', 'Both']))]),
            'unloading_charge_type' => ['nullable', Rule::requiredIf(in_array($request->location_type, ['Unloading', 'Both']))],
            'unloading_charge'      => array_merge($decimalRule, [Rule::requiredIf(in_array($request->location_type, ['Unloading', 'Both']))]),
            'address'             => 'required|max:100',
            'post_code'           => 'required|digits:6',
            'brone_by'            => 'nullable|in:loadvendor,srl,mixed',
            'capping_amount'      => array_merge($decimalRule, [Rule::requiredIf($request->brone_by === 'mixed')]),
            'onsite_contact_person' => 'nullable|max:100',
            'onsite_contact_person_phone' => ['nullable', 'digits:10'],
            'onsite_contact_person_whatsapp' => ['nullable', 'digits:10'],
            'map_location'        => 'required|string|max:255',
            'additional_info'     => 'nullable|string|max:5000',
        ], [
            'required' => 'This field is required.',
            'max'      => 'Maximum 100 characters allowed.',
            'exists'   => "This field's value is invalid.",
            'digits'   => 'Invalid format.',
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

        try {
            DB::transaction(function () use ($request, $contact) {
                $phoneCode = getPhoneCode();

                $loadvendorlocation = new Loadvendorlocation;
                $loadvendorlocation->contact_id   = $request->contact_id;
                $loadvendorlocation->company_name = $request->company_name;
                $loadvendorlocation->company_role = $request->company_role;

                $types = ['source' => 'Source', 'destination' => 'Destination', 'midpoint' => 'Midpoint'];
                $loadvendorlocation->route_type = $types[$request->route_type] ?? null;

                $loadvendorlocation->source_city_id      = $request->source_city_id;
                $loadvendorlocation->destination_city_id = $request->destination_city_id;
                $loadvendorlocation->midpoint_city_id    = $request->midpoint_city_id;
                $loadvendorlocation->location_name       = $request->location_name;
                $loadvendorlocation->location_type       = $request->location_type;
                $loadvendorlocation->loading_charge_type = in_array($request->location_type, ['Loading', 'Both']) ? $request->loading_charge_type : null;
                $loadvendorlocation->loading_charge      = in_array($request->location_type, ['Loading', 'Both']) ? $request->loading_charge : 0;
                $loadvendorlocation->unloading_charge_type = in_array($request->location_type, ['Unloading', 'Both']) ? $request->unloading_charge_type : null;
                $loadvendorlocation->unloading_charge    = in_array($request->location_type, ['Unloading', 'Both']) ? $request->unloading_charge : 0;
                $loadvendorlocation->address = $request->address;
                $loadvendorlocation->zipcode = $request->post_code;

                $broneBy = ['loadvendor' => 'Load Vendor', 'srl' => 'SRL', 'mixed' => 'Mixed'];
                $loadvendorlocation->charges_paid_by = $broneBy[$request->brone_by] ?? null;
                $loadvendorlocation->capping_amount  = $request->capping_amount ?? 0;

                $loadvendorlocation->onsite_contact_person = $request->onsite_contact_person;
                $loadvendorlocation->onsite_contact_person_phone_code    = $request->onsite_contact_person_phone_code ?? $phoneCode;
                $loadvendorlocation->onsite_contact_person_phone         = $request->onsite_contact_person_phone;
                $loadvendorlocation->onsite_contact_person_whatsapp_code = $request->onsite_contact_person_whatsapp_code ?? $phoneCode;
                $loadvendorlocation->onsite_contact_person_whatsapp      = $request->onsite_contact_person_whatsapp;
                $loadvendorlocation->map_location    = $request->map_location;
                $loadvendorlocation->additional_info = $request->additional_info;
                $loadvendorlocation->created_by      = Auth::user()->id;
                $loadvendorlocation->save();

                $this->storeUseractivity(53, 3, Auth::user()->id, $contact->id, 'Load vendor location added [ID: ' . $loadvendorlocation->id . '].');
            });

            return response()->json(['success' => true, 'data' => $contact, 'message' => 'Load vendor location saved successfully.'], 200);

        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'data' => [], 'message' => $e->getMessage()], 500);
        }
    }

    public function deleteLocation(Request $request)
    {
        $location = Loadvendorlocation::find($request->location_id);
        if (!$location) {
            return response()->json(['success' => false, 'message' => 'Location not found.'], 422);
        }

        try {
            DB::transaction(function () use ($request, $location) {
                $location->delete();
                $this->storeUseractivity(53, 6, Auth::user()->id, $request->location_id, 'Deleted a Load vendor location.');
                return $location;
            });

            return response()->json(['success' => true, 'message' => 'Load vendor location deleted successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function getLocationMidpoints(Request $request)
    {
        try {
            $midpoints = Loadvendorlocation::where('route_type', 'Midpoint')
                            ->where('contact_id', $request->contact_id)
                            ->whereIn('location_type', [$request->type, 'Both'])
                            ->get();

            return response()->json(['success' => true, 'message' => 'Midpoints fetched successfully.', 'data' => $midpoints], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Something went wrong while fetching midpoints.'], 500);
        }
    }

    /* ===============================================================
     | Documents (attachment upload / delete)
     | =============================================================== */

    public function storeAttachment(Request $request)
    {
        $contact = Contact::where('cotype_id', self::CONTACT_TYPE_LOAD_VENDOR)->find($request->contact_id);
        if (!$contact) {
            return response()->json(['success' => false, 'data' => [], 'message' => 'Load Vendor not found!'], 422);
        }

        if ($this->vendorWriteLocked($contact)) {
            return response()->json(['success' => false, 'data' => [], 'message' => 'This load vendor is not Active — documents cannot be added.'], 422);
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
                $fileoriginalname = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $filesize  = $file->getSize();

                $filename = 'contact-attachment-' . Str::random(4) . '_' . time() . '.' . $extension;
                $file->move(public_path('media' . DIRECTORY_SEPARATOR . 'contact' . DIRECTORY_SEPARATOR), $filename);

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
     | Activity note
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

    /* ===============================================================
     | Destroy (LV-D2: V2 soft-delete — index delete no longer hits V1)
     | =============================================================== */

    public function destroy(Request $request)
    {
        $contact = Contact::where('cotype_id', self::CONTACT_TYPE_LOAD_VENDOR)->find($request->id);
        if (!$contact) {
            return response()->json(['success' => false, 'message' => 'Load Vendor not found.'], 422);
        }

        try {
            DB::transaction(function () use ($contact) {
                $contact->delete();
                $this->storeUseractivity(4, 6, Auth::user()->id, $contact->id, 'Load Vendor deleted [ID: ' . $contact->id . '].');
                return $contact;
            });

            return response()->json(['success' => true, 'message' => 'Load Vendor deleted successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
