<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Contact;
use App\Models\Cotype;
use App\Models\State;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

/**
 * Insurance Vendor Module V2 — Controller (Gate 2: live backend wiring).
 *
 * The lightest contact type (cotype_id = 9). It is a FLAT record — there is no
 * workspace-hub and there are no submodule pages (extension E8). All CRUD happens
 * through a single Add/Edit Bootstrap modal on the List page.
 *
 * Mirrors the V1 ContactController insurance-provider methods (insuranceProviderList,
 * getInsuranceProvider, storeInsuranceProvider, updateInsuranceProvider,
 * toggleInsuranceProviderStatus, destroyInsuranceProvider) — reusing the existing
 * `contacts` table (cotype_id = 9, SoftDeletes) + State/City/Country/Cotype lookups.
 * NO schema change. The live V1 form uses a FREE-TEXT company_name (not the
 * insurancecompanies lookup), so no seeder is required.
 *
 * V1 SD gaps fixed here (do NOT copy the bugs):
 *   SD-11 organisation_id always set · SD-5/6 store AND update wrapped in
 *   DB::transaction try/catch that returns · SD-8 find()+422 in JSON methods
 *   (no findOrFail) · SD-9 status code on every json().
 */
class InsuranceProviderController extends Controller
{
    /** cotype_id for Insurance Vendor. */
    private const COTYPE_ID = 9;

    /* ---------------------------------------------------------------
     | KPI counts derived from Contact (cotype_id = 9)
     | --------------------------------------------------------------- */
    private function stats(): array
    {
        $base = Contact::where('cotype_id', self::COTYPE_ID);

        return [
            'total'       => (clone $base)->count(),
            'active'      => (clone $base)->where('status', 'Active')->count(),
            'inactive'    => (clone $base)->where('status', 'Inactive')->count(),
            'blacklisted' => (clone $base)->where('status', 'Blacklisted')->count(),
            'gst'         => (clone $base)->whereNotNull('gst_number')->where('gst_number', '!=', '')->count(),
            'cities'      => (clone $base)->whereNotNull('state_id')->distinct('state_id')->count('state_id'),
        ];
    }

    private function indianStates()
    {
        return State::whereHas('country', fn($q) => $q->where('iso2', 'IN'))
            ->orderBy('name')->get();
    }

    /** B5 — human-readable attribute names so validator messages read "GST Number", not "gst number". */
    private function attributeNames(): array
    {
        return [
            'company_name'    => 'company name',
            'contact_name'    => 'contact name',
            'contact_code'    => 'contact code',
            'phone'           => 'phone',
            'whatsapp'        => 'WhatsApp number',
            'email'           => 'email',
            'gst_number'      => 'GST number',
            'contact_comment' => 'comment',
            'country_id'      => 'country',
            'state_id'        => 'state',
            'city_id'         => 'city',
            'contact_image'   => 'logo',
        ];
    }

    /**
     * B9 — server-side write-lock. A Blacklisted vendor is locked for edits.
     * The 2-arg form allows un-blacklisting via the edit form: when the incoming
     * status is anything other than Blacklisted, the write is permitted.
     * toggleStatus + reads are never blocked. Returns a 422 JSON response, or null.
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

    /* ---------------------------------------------------------------
     | Screens (Dashboard + List with modal CRUD only — E8 flat record)
     | --------------------------------------------------------------- */
    public function dashboard()
    {
        $providers = Contact::where('cotype_id', self::COTYPE_ID)
            ->with('state')
            ->orderBy('id', 'desc')
            ->take(6)
            ->get();

        return view('V2.insuranceprovider.dashboard', [
            'providers' => $providers,
            'stats'     => $this->stats(),
        ]);
    }

    public function index(Request $request)
    {
        $search_name  = $request->name;
        $search_state = $request->state;

        $contacts = Contact::query()
            ->where('cotype_id', self::COTYPE_ID)
            ->with(['cotype', 'state', 'relcontacts']);

        if ($request->filled('name')) {
            $contacts->where(function ($q) use ($request) {
                $q->where('company_name', 'like', '%' . $request->name . '%')
                  ->orWhere('contact_name', 'like', '%' . $request->name . '%');
            });
        }
        if ($request->filled('state')) {
            $contacts->where('state_id', $request->state);
        }

        $contacts = $contacts->orderBy('id', 'desc')->paginate(15)->withQueryString();

        return view('V2.insuranceprovider.index', [
            'contacts'     => $contacts,
            'states'       => $this->indianStates(),
            'stats'        => $this->stats(),
            'search_name'  => $search_name,
            'search_state' => $search_state,
        ]);
    }

    /** GET — used by the edit modal to prefill. SD-8: find()+422, no findOrFail. */
    public function getProvider($id)
    {
        $contact = Contact::where('cotype_id', self::COTYPE_ID)->find($id);
        if (! $contact) {
            return response()->json(['success' => false, 'message' => 'Insurance vendor not found.'], 422);
        }

        return response()->json(['success' => true, 'contact' => $contact], 200);
    }

    public function store(Request $request)
    {
        $request->merge([
            'phone'      => preg_replace('/\s+/', '', $request->phone ?? ''),
            'whatsapp'   => preg_replace('/\s+/', '', $request->whatsapp ?? ''),
            'gst_number' => trim((string) $request->gst_number) ?: null,   // B2 — blank → null so empty GSTs don't collide
        ]);

        // B8 — match on the national phone digits irrespective of ph_prefix so a
        // legacy "91"-prefixed duplicate is caught the same as a "+91" one.
        // (Code-level guard only; stored data is not altered here.)
        $validate_phone = function ($attribute, $value, $fail) {
            if (Contact::where('phone', $value)->exists()) {
                $fail('This phone number already exists.');
            }
        };

        $validator = Validator::make($request->all(), [
            'company_name'    => 'required|max:100',
            'contact_name'    => 'required|max:100',
            'contact_code'    => 'required|max:100',
            'phone'           => ['required', 'digits:10', $validate_phone],
            'whatsapp'        => ['nullable', 'digits:10'],
            'status'          => 'nullable|in:Active,Inactive,Blacklisted',
            'contact_comment' => 'nullable|string|max:255',
            'email'           => 'nullable|email|max:100',
            'country_id'      => 'nullable|exists:countries,id',
            'state_id'        => 'nullable|exists:states,id',
            'city_id'         => 'nullable|exists:cities,id',
            'gst_number'      => [
                'nullable', 'string', 'max:20',
                Rule::unique('contacts', 'gst_number')   // B2 — scoped to cotype 9, soft-deletes ignored
                    ->where('cotype_id', self::COTYPE_ID)
                    ->whereNull('deleted_at'),
            ],
            'contact_image'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'gst_number.unique' => 'This GST number is already registered to another insurance vendor.',
        ], $this->attributeNames());

        if ($validator->fails()) {
            return response()->json(['success' => false, 'data' => $validator->errors()], 422);
        }

        try {
            $contact = DB::transaction(function () use ($request) {
                $lastcontact = Contact::withTrashed()->orderBy('id', 'DESC')->first();
                if ($lastcontact) {
                    $incr_lastcontact = $lastcontact->contactno + 1;
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

                $contact = new Contact();
                $contact->contactno       = $contactno;
                $contact->cotype_id       = self::COTYPE_ID;
                $contact->organisation_id = Auth::user()->organisation_id ?? 1;   // SD-11
                $contact->company_name    = $request->company_name;
                $contact->contact_name    = $request->contact_name;
                $contact->contact_code    = $request->contact_code;
                $contact->phone           = $request->phone;
                $contact->ph_prefix       = $request->phone_code ?? getPhoneCode();
                $contact->whatsapp        = $request->whatsapp;
                $contact->email           = $request->email;
                $contact->address1        = $request->address;
                $contact->country_id      = $request->country_id;
                $contact->state_id        = $request->state_id;
                $contact->city_id         = $request->city_id;
                $contact->zipcode         = $request->pincode;
                $contact->gst_number      = $request->gst_number;
                $contact->pan_no          = $request->pan_number;
                $contact->tds_percentage  = $request->tds_percentage ?? 0;
                $contact->status          = $request->status ?? 'Active';
                $contact->comment         = $request->contact_comment;
                $contact->created_by      = Auth::id();

                if ($request->hasFile('contact_image') && $request->file('contact_image')->isValid()) {
                    $uploadPath = public_path('media/contact');
                    if (! File::exists($uploadPath)) {
                        File::makeDirectory($uploadPath, 0755, true);
                    }
                    $filename = 'ip_' . time() . '_' . uniqid() . '.' . $request->file('contact_image')->getClientOriginalExtension();
                    $request->file('contact_image')->move($uploadPath, $filename);
                    $contact->contact_image = $filename;
                }

                $contact->save();

                return $contact;
            });
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }

        return response()->json([
            'success' => true,
            'message' => $contact->company_name . ' added successfully.',
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $request->merge([
            'phone'      => preg_replace('/\s+/', '', $request->phone ?? ''),
            'whatsapp'   => preg_replace('/\s+/', '', $request->whatsapp ?? ''),
            'gst_number' => trim((string) $request->gst_number) ?: null,   // B2 — blank → null so empty GSTs don't collide
        ]);

        $contact = Contact::where('cotype_id', self::COTYPE_ID)->find($id);
        if (! $contact) {
            return response()->json(['success' => false, 'message' => 'Insurance vendor not found.'], 422);
        }

        // B9 — Blacklisted write-lock (un-blacklist via edit allowed; Tyre variant).
        if ($locked = $this->blockIfWriteLocked($contact, $request->status ?? 'Active')) {
            return $locked;
        }

        // B8 — match on the national phone digits irrespective of ph_prefix; keep
        // the self-ignore so editing a record with its own number still passes.
        $validate_phone = function (string $attribute, mixed $value, Closure $fail) use ($id) {
            if (Contact::where('phone', $value)->where('id', '!=', $id)->exists()) {
                $fail('This phone number already exists.');
            }
        };

        $validator = Validator::make($request->all(), [
            'company_name'    => 'required|max:100',
            'contact_name'    => 'required|max:100',
            'contact_code'    => 'required|max:100',
            'phone'           => ['required', 'digits:10', $validate_phone],
            'whatsapp'        => ['nullable', 'digits:10'],
            'status'          => 'nullable|in:Active,Inactive,Blacklisted',
            'contact_comment' => 'nullable|string|max:255',
            'email'           => 'nullable|email|max:100',
            'country_id'      => 'nullable|exists:countries,id',
            'state_id'        => 'nullable|exists:states,id',
            'city_id'         => 'nullable|exists:cities,id',
            'gst_number'      => [
                'nullable', 'string', 'max:20',
                Rule::unique('contacts', 'gst_number')   // B2 — scoped to cotype 9, soft-deletes ignored, self ignored
                    ->where('cotype_id', self::COTYPE_ID)
                    ->whereNull('deleted_at')
                    ->ignore($id),
            ],
            'contact_image'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'gst_number.unique' => 'This GST number is already registered to another insurance vendor.',
        ], $this->attributeNames());

        if ($validator->fails()) {
            return response()->json(['success' => false, 'data' => $validator->errors()], 422);
        }

        try {
            $contact = DB::transaction(function () use ($request, $contact) {
                $contact->company_name    = $request->company_name;
                $contact->contact_name    = $request->contact_name;
                $contact->contact_code    = $request->contact_code;
                $contact->phone           = $request->phone;
                $contact->ph_prefix       = $request->phone_code ?? getPhoneCode();
                $contact->whatsapp        = $request->whatsapp;
                $contact->email           = $request->email;
                $contact->country_id      = $request->country_id;
                $contact->state_id        = $request->state_id;
                $contact->city_id         = $request->city_id;
                $contact->zipcode         = $request->pincode;
                $contact->gst_number      = $request->gst_number;
                $contact->pan_no          = $request->pan_number;
                $contact->tds_percentage  = $request->tds_percentage ?? 0;
                $contact->status          = $request->status ?? 'Active';
                $contact->comment         = $request->contact_comment;
                $contact->organisation_id = $contact->organisation_id ?: (Auth::user()->organisation_id ?? 1); // SD-11
                $contact->updated_by      = Auth::id();

                if ($request->hasFile('contact_image') && $request->file('contact_image')->isValid()) {
                    if ($contact->contact_image) {
                        $old = public_path('media/contact/' . $contact->contact_image);
                        if (File::exists($old)) {
                            File::delete($old);
                        }
                    }
                    $uploadPath = public_path('media/contact');
                    if (! File::exists($uploadPath)) {
                        File::makeDirectory($uploadPath, 0755, true);
                    }
                    $filename = 'ip_' . time() . '_' . uniqid() . '.' . $request->file('contact_image')->getClientOriginalExtension();
                    $request->file('contact_image')->move($uploadPath, $filename);
                    $contact->contact_image = $filename;
                }

                $contact->save();

                return $contact;
            });
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }

        return response()->json([
            'success' => true,
            'message' => $contact->company_name . ' updated successfully.',
        ], 200);
    }

    public function toggleStatus(Request $request, $id)
    {
        $contact = Contact::where('cotype_id', self::COTYPE_ID)->find($id);
        if (! $contact) {
            return response()->json(['success' => false, 'message' => 'Insurance vendor not found.'], 422);
        }

        // IV-D1 — never silently un-blacklist via the toggle; status must be changed through the edit form.
        if ($contact->status === 'Blacklisted') {
            return response()->json([
                'success' => false,
                'message' => 'Blacklisted vendors cannot be toggled. Edit the vendor to change its status.',
            ], 422);
        }

        $newStatus = $contact->status === 'Active' ? 'Inactive' : 'Active';
        $contact->update(['status' => $newStatus, 'updated_by' => Auth::id()]);

        return response()->json([
            'success'    => true,
            'new_status' => $newStatus,
            'message'    => $contact->company_name . ' marked as ' . $newStatus . '.',
        ], 200);
    }

    public function destroy($id)
    {
        $contact = Contact::where('cotype_id', self::COTYPE_ID)->find($id);
        if (! $contact) {
            return response()->json(['success' => false, 'message' => 'Insurance vendor not found.'], 422);
        }

        try {
            DB::transaction(function () use ($contact) {
                $contact->update(['deleted_by' => Auth::id()]);
                $contact->delete();
            });
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }

        return response()->json([
            'success' => true,
            'message' => $contact->company_name . ' removed.',
        ], 200);
    }
}
