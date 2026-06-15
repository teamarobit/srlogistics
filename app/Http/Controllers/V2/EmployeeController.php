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
use App\Models\Coaddress;
use App\Models\Cobilling;
use App\Models\Contactbank;
use App\Models\Contactactivity;
use App\Models\Religion;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Role;
use App\Models\Branch;
use App\Models\Jobrank;
use App\Models\Skillset;
use App\Models\Bank;
use App\Models\Asset;
use App\Models\Employeeasset;
use App\Models\Employeeallotedassetlog;
use App\Models\Employeeworkexperience;
use App\Models\Employeesalary;
use App\Models\Employeeexitdetail;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Auth;
use Closure;

use App\Traits\Useractivity;

/**
 * Employee Module V2 — Controller (Gate 2: live backend wiring)  ·  cotype_id = 3
 *
 * Ports the live V1 logic from App\Http\Controllers\ContactController employee*
 * methods into the isolated V2 Employee module. Reuses the existing `contacts`
 * tables + relations via Eloquent only — NO schema changes. The public GET
 * screen methods keep the same view-data array-key shape the Gate-1 blades
 * already consume, but populate every value from real Eloquent records.
 *
 * Extensions: E1 standalone letters · E2 read-only-after-exit ($isExited) ·
 * E5 Permanent/Present addresses. SD-1..13 enforced.
 */
class EmployeeController extends Controller
{
    use Useractivity;

    private const COTYPE = 3; // CONTACT_TYPE_EMPLOYEE

    /* ---------------------------------------------------------------
     | Helpers — shape + counts + lookups (mirror Customer V2 pattern)
     | --------------------------------------------------------------- */

    /** Resolve branch/department/designation names by work type. */
    private function workNames(Contact $c): array
    {
        if ($c->work_type === 'Service Center') {
            return [
                'branch'      => optional($c->serviceCenterBranch)->location ?? '—',
                'department'  => optional($c->serviceCenterDepartment)->name ?? '—',
                'designation' => optional($c->serviceCenterDesignation)->name ?? '—',
            ];
        }
        return [
            'branch'      => optional($c->officeBranch)->location ?? '—',
            'department'  => optional($c->officeDepartment)->name ?? '—',
            'designation' => optional($c->officeDesignation)->name ?? '—',
        ];
    }

    /** Map a Contact into the Gate-1 array shape the blades consume. */
    private function shapeEmployee(Contact $c): array
    {
        $w = $this->workNames($c);
        return [
            'id'          => $c->id,
            'contactno'   => $c->contactno,
            'name'        => $c->contact_name,
            'work_type'   => $c->work_type ?? '—',
            'branch'      => $w['branch'],
            'department'  => $w['department'],
            'designation' => $w['designation'],
            'phone'       => trim(($c->ph_prefix ? $c->ph_prefix . ' ' : '') . $c->phone),
            'email'       => $c->email ?? '—',
            'gender'      => $c->gender ?? '—',
            'blood_group' => $c->blood_group ?? '—',
            'doj'         => $c->doj,
            'dob'         => $c->dob,
            'status'      => $c->status ?? 'Active',
            'exited'      => (bool) $c->employeeExitDetail,
            'exit_date'   => optional($c->employeeExitDetail)->exit_date,
        ];
    }

    /** Per-tab counts (real Eloquent counts). */
    private function tabCounts(Contact $c): array
    {
        return [
            'joining'   => $c->workExperiences()->count(),
            'documents' => $c->coattachments()->count(),
            'assets'    => $c->employeeAssets()->count(),
            'leave'     => 0, // No Leave Tracker source table at Gate 2 (flagged in HumanAttention).
            'salary'    => $c->salaries()->count(),
            'exit'      => $c->employeeExitDetail ? 1 : 0,
            'activity'  => $c->activities()->count(),
        ];
    }

    /** Resolve an employee Contact or abort 404 (GET screens only). */
    private function findEmployeeOrFail($id): Contact
    {
        return Contact::where('cotype_id', self::COTYPE)->findOrFail($id);
    }

    /** Common payload for hub/submodule pages. */
    private function payload(Contact $c, string $active): array
    {
        return [
            'e'        => $this->shapeEmployee($c),
            'counts'   => $this->tabCounts($c),
            'active'   => $active,
            'isExited' => (bool) $c->employeeExitDetail,
        ];
    }

    /** Dropdown lookups shared by create + edit. */
    private function formLookups(): array
    {
        return [
            'countries'         => Country::all(),
            'states'            => State::whereHas('country', fn ($q) => $q->where('iso2', 'IN'))->orderBy('name')->get(),
            'cities'            => City::whereHas('state.country', fn ($q) => $q->where('iso2', 'IN'))->orderBy('name')->get(),
            'cotypes'           => Cotype::all(),
            'customerabouttype' => Customerabouttype::orderBy('name')->get(),
            'religions'         => Religion::orderBy('name')->get(),
            'departments'       => Department::where('status', 'Active')->orderBy('name')->get(),
            'designations'      => Designation::where('status', 'Active')->orderBy('name')->get(),
            'roles'             => Role::whereNotIn('slug', ['superadmin', 'admin', 'employee'])->orderBy('name')->get(),
            'branches'          => Branch::where('status', 'Active')->orderBy('location')->get(),
            'jobranks'          => Jobrank::where('status', 'Active')->orderBy('name')->get(),
            'skillsets'         => Skillset::where('status', 'Active')->orderBy('name')->get(),
            'banks'             => Bank::orderBy('name')->get(),
            'gsttreats'         => Gsttreat::all(),
            'coattachtypes'     => Coattachtype::all(),
        ];
    }

    /* ---------------------------------------------------------------
     | Screens (public GET) — real Eloquent, Gate-1 array-key shape
     | --------------------------------------------------------------- */

    public function dashboard()
    {
        $base = Contact::where('cotype_id', self::COTYPE);

        $total       = (clone $base)->count();
        $active      = (clone $base)->where('status', 'Active')->count();
        $inactive    = (clone $base)->where('status', 'Inactive')->count();
        $blacklisted = (clone $base)->where('status', 'Blacklisted')->count();
        $office      = (clone $base)->where('work_type', 'Office Work')->count();
        $serviceCtr  = (clone $base)->where('work_type', 'Service Center')->count();

        $recent = Contact::where('cotype_id', self::COTYPE)
                    ->with('officeBranch', 'serviceCenterBranch', 'officeDepartment', 'serviceCenterDepartment', 'officeDesignation', 'serviceCenterDesignation', 'employeeExitDetail')
                    ->orderByDesc('id')->limit(8)->get()
                    ->map(fn ($c) => $this->shapeEmployee($c))->all();

        return view('V2.employee.dashboard', [
            'employees' => $recent,
            'kpi'       => compact('total', 'active', 'inactive', 'blacklisted', 'office', 'serviceCtr'),
        ]);
    }

    public function index(Request $request)
    {
        $search_name     = $request->name;
        $search_branch   = $request->branch;
        $search_worktype = $request->worktype;
        $search_status   = $request->status;

        $query = Contact::where('cotype_id', self::COTYPE)
                    ->with('cotype', 'officeBranch', 'serviceCenterBranch', 'officeDepartment', 'serviceCenterDepartment', 'officeDesignation', 'serviceCenterDesignation', 'employeeExitDetail');

        if ($request->filled('name')) {
            $query->where('contact_name', 'like', '%' . $request->name . '%');
        }
        if ($request->filled('branch')) {
            $query->where(function ($q) use ($request) {
                $q->where('office_branch_id', $request->branch)
                  ->orWhere('service_center_branch_id', $request->branch);
            });
        }
        if ($request->filled('worktype')) {
            $query->where('work_type', $request->worktype);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $contacts = $query->orderByDesc('id')->paginate(10)->withQueryString();
        $contacts->getCollection()->transform(fn ($c) => $this->shapeEmployee($c));

        $branches = Branch::where('status', 'Active')->orderBy('location')->get();

        return view('V2.employee.index', [
            'employees'       => $contacts,
            'branches'        => $branches,
            'search_name'     => $search_name,
            'search_branch'   => $search_branch,
            'search_worktype' => $search_worktype,
            'search_status'   => $search_status,
        ]);
    }

    public function create()
    {
        return view('V2.employee.create', $this->formLookups());
    }

    public function show($id)
    {
        $contact = Contact::where('cotype_id', self::COTYPE)
                    ->with('officeBranch', 'serviceCenterBranch', 'officeDepartment', 'serviceCenterDepartment', 'officeDesignation', 'serviceCenterDesignation', 'employeeExitDetail', 'relcontacts', 'coaddresses', 'bank')
                    ->findOrFail($id);

        $permanentAddress = $contact->coaddresses->firstWhere('type', 'Permanent');
        $presentAddress   = $contact->coaddresses->firstWhere('type', 'Present');

        return view('V2.employee.show', array_merge($this->payload($contact, 'overview'), [
            'contact'          => $contact,
            'permanentAddress' => $permanentAddress,
            'presentAddress'   => $presentAddress,
        ]));
    }

    public function edit($id)
    {
        $contact = Contact::with([
            'country.states', 'state.cities', 'relcontacts', 'coaddresses', 'bank',
            'employeeAssets', 'assetLogs', 'workExperiences', 'salaries',
            'employeeExitDetail', 'coattachments.coattachtype', 'activities', 'activities.createdBy',
            'officeBranch', 'serviceCenterBranch', 'officeDepartment', 'serviceCenterDepartment',
            'officeDesignation', 'serviceCenterDesignation',
        ])->where('cotype_id', self::COTYPE)->findOrFail($id);

        $contactroles     = Contactrole::where('contact_id', $contact->id)->pluck('role_id')->toArray();
        $assets           = Asset::where('status', 'Active')->orderBy('name')->get();
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

        $this->storeUseractivity(3, 5, Auth::user()->id, $contact->id, 'Retrieve a employee named ' . $contact->contact_name . ' to edit.');

        return view('V2.employee.edit', array_merge($this->formLookups(), $this->payload($contact, 'edit'), [
            'contact'          => $contact,
            'contactroles'     => $contactroles,
            'assets'           => $assets,
            'permanentAddress' => $permanentAddress,
            'presentAddress'   => $presentAddress,
            'totalYears'       => $totalYears,
            'remainingMonths'  => $remainingMonths,
        ]));
    }

    public function joining($id)
    {
        $contact = $this->findEmployeeOrFail($id);
        $workExperiences = Employeeworkexperience::where('contact_id', $contact->id)->orderByDesc('id')->get();
        $hasSalary       = Employeesalary::where('contact_id', $contact->id)->exists();

        return view('V2.employee.joining', array_merge($this->payload($contact, 'joining'), [
            'contact'         => $contact,
            'workExperiences' => $workExperiences,
            'cities'          => City::whereHas('state.country', fn ($q) => $q->where('iso2', 'IN'))->orderBy('name')->get(),
            'canGenerateLetter' => $workExperiences->isNotEmpty() && $hasSalary,
        ]));
    }

    public function documents($id)
    {
        $contact = $this->findEmployeeOrFail($id);

        return view('V2.employee.documents', array_merge($this->payload($contact, 'documents'), [
            'contact'       => $contact,
            'coattachments' => Coattachment::with('coattachtype')->where('contact_id', $contact->id)->latest()->get(),
            'coattachtypes' => Coattachtype::orderBy('name')->get(),
        ]));
    }

    public function assets($id)
    {
        $contact = $this->findEmployeeOrFail($id);

        return view('V2.employee.assets', array_merge($this->payload($contact, 'assets'), [
            'contact'        => $contact,
            'employeeAssets' => Employeeasset::with('asset')->where('contact_id', $contact->id)->orderByDesc('id')->get(),
            'assets'         => Asset::where('status', 'Active')->orderBy('name')->get(),
        ]));
    }

    public function leave($id)
    {
        // Leave Tracker: no V1 source / table at Gate 2 — present read-only (flagged in HumanAttention).
        $contact = $this->findEmployeeOrFail($id);

        return view('V2.employee.leave', array_merge($this->payload($contact, 'leave'), [
            'contact' => $contact,
            'leaves'  => collect(),
        ]));
    }

    public function salary($id)
    {
        $contact = $this->findEmployeeOrFail($id);

        return view('V2.employee.salary', array_merge($this->payload($contact, 'salary'), [
            'contact'  => $contact,
            'salaries' => Employeesalary::where('contact_id', $contact->id)->orderByDesc('effective_from')->get(),
        ]));
    }

    public function exit($id)
    {
        $contact     = $this->findEmployeeOrFail($id);
        $exitDetail  = Employeeexitdetail::where('contact_id', $contact->id)->first();

        return view('V2.employee.exit', array_merge($this->payload($contact, 'exit'), [
            'contact'    => $contact,
            'exitDetail' => $exitDetail,
        ]));
    }

    public function activity($id)
    {
        $contact = $this->findEmployeeOrFail($id);

        return view('V2.employee.activity', array_merge($this->payload($contact, 'activity'), [
            'contact'    => $contact,
            'activities' => Contactactivity::with('createdBy')->where('contact_id', $contact->id)->orderByDesc('created_at')->get(),
        ]));
    }

    /* ---------------------------------------------------------------
     | E1 — Standalone print letters (do NOT extend layouts.app)
     | --------------------------------------------------------------- */

    public function joiningLetter($id)
    {
        $contact = Contact::with([
            'organisation', 'country.states', 'state.cities', 'relcontacts', 'coaddresses', 'bank',
            'employeeAssets', 'assetLogs', 'workExperiences', 'salaries', 'employeeExitDetail',
            'officeBranch', 'serviceCenterBranch', 'officeDepartment', 'serviceCenterDepartment',
            'officeDesignation', 'serviceCenterDesignation', 'activities', 'activities.createdBy',
        ])->where('cotype_id', self::COTYPE)->findOrFail($id);

        $departments = Department::orderBy('name')->get();

        return view('V2.employee.joining-letter', [
            'contact'     => $contact,
            'e'           => $this->shapeEmployee($contact),
            'departments' => $departments,
        ]);
    }

    public function exitLetter($id)
    {
        $contact = Contact::with([
            'organisation', 'country.states', 'state.cities', 'relcontacts', 'coaddresses', 'bank',
            'employeeAssets', 'assetLogs', 'workExperiences', 'salaries', 'employeeExitDetail',
            'officeBranch', 'serviceCenterBranch', 'officeDepartment', 'serviceCenterDepartment',
            'officeDesignation', 'serviceCenterDesignation', 'activities', 'activities.createdBy',
        ])->where('cotype_id', self::COTYPE)->findOrFail($id);

        $departments = Department::orderBy('name')->get();

        return view('V2.employee.exit-letter', [
            'contact'     => $contact,
            'e'           => $this->shapeEmployee($contact),
            'departments' => $departments,
        ]);
    }

    /* ---------------------------------------------------------------
     | Emergency-contact repeater wrapper (AJAX HTML fragment)
     | --------------------------------------------------------------- */
    public function contactPersonWrapper(Request $request)
    {
        $rowindex = $request->get('rowindex');
        $html = view('contacts.contact-person-wrapper.employee-emergency-contact', compact('rowindex'))->render();

        return response()->json(['success' => true, 'data' => $html, 'message' => 'Employee emergency contact wrapper fetched'], 200);
    }

    /* ---------------------------------------------------------------
     | Create / Store  (← storeEmployee)
     | --------------------------------------------------------------- */
    public function store(Request $request)
    {
        $request->merge([
            'phone'    => preg_replace('/\s+/', '', $request->phone),
            'whatsapp' => preg_replace('/\s+/', '', $request->whatsapp),
        ]);

        $validate_phone = function ($attribute, $value, $fail) use ($request) {
            $code = $request->phone_code ?? getPhoneCode();
            if (Contact::where('phone', $value)->where('ph_prefix', $code)->exists()) {
                $fail('This phone number already exists.');
            }
        };
        $validate_cp_phone = function (string $attribute, mixed $value, Closure $fail) use ($request) {
            $index = explode('.', $attribute)[1] ?? null;
            $code  = $request->get('contact_person_ph_code')[$index] ?? null;
        };

        $validator = Validator::make($request->all(), [
            'contact_name'        => 'required|max:100',
            'contact_image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'phone'               => ['required', 'digits:10', $validate_phone],
            'whatsapp'            => ['nullable', 'digits:10'],
            'email'               => 'nullable|email|unique:contacts,email',
            'gender'              => 'required|in:Male,Female,Other',
            'religion_id'         => 'required|exists:religions,id',
            'dob'                 => 'required|date_format:Y-m-d',
            'doj'                 => 'required|date|after:dob|before_or_equal:today',
            'blood_group'         => 'required|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'reference_by'        => 'required|max:100',

            'workType'              => 'required|in:Office Work,Service Center',
            'office_branch_id'      => 'nullable|required_if:workType,Office Work|exists:branches,id',
            'office_department_id'  => 'nullable|required_if:workType,Office Work|exists:departments,id',
            'office_designation_id' => 'nullable|required_if:workType,Office Work|exists:designations,id',
            'office_job_rank_id'    => 'nullable|required_if:workType,Office Work|exists:jobranks,id',
            'office_role_ids'       => 'nullable|required_if:workType,Office Work|array|min:1',
            'office_role_ids.*'     => 'exists:roles,id',

            'service_type'                  => 'nullable|required_if:workType,Service Center|in:Administrative,Technical',
            'service_center_branch_id'      => 'nullable|required_if:workType,Service Center|exists:branches,id',
            'service_center_department_id'  => 'nullable|required_if:workType,Service Center|exists:departments,id',
            'service_center_designation_id' => 'nullable|required_if:workType,Service Center|exists:designations,id',
            'service_center_jobrank_id'     => 'nullable|required_if:workType,Service Center|exists:jobranks,id',
            'service_center_role_ids'       => 'nullable|required_if:workType,Service Center|array|min:1',
            'service_center_role_ids.*'     => 'exists:roles,id',

            'servicecenter_technical_skillset_ids'   => ['nullable', 'array', 'min:1'],
            'servicecenter_technical_skillset_ids.*' => 'exists:skillsets,id',

            'tracking_group'    => 'required|in:Tracking A,Tracking B',
            'providentFund'     => 'nullable|in:yes,no',
            'provident_fund_no' => 'nullable|required_if:providentFund,yes|alpha_num|max:25',
            'comment'           => 'nullable|string|max:100000',

            'contact_person_name'          => 'required|array|min:1',
            'contact_person_name.*'        => 'required|string|distinct|min:1',
            'contact_person_relation'      => 'nullable|array|min:1',
            'contact_person_relation.*'    => 'nullable|string|min:1',
            'contact_person_blood_group'   => 'nullable|array|min:1',
            'contact_person_blood_group.*' => 'nullable|string|min:1',
            'contact_person_address'       => 'nullable|array|min:1',
            'contact_person_address.*'     => 'nullable|string|min:1',
            'contact_person_ph_code'       => 'nullable|array|min:1',
            'contact_person_phone'         => 'required|array|min:1',
            'contact_person_phone.*'       => ['required', 'string', 'distinct', $validate_cp_phone],
            'contact_person_whatsapp_code' => 'nullable|array|min:1',
            'contact_person_whatsapp'      => 'nullable|array|min:1',
            'contact_person_whatsapp.*'    => ['nullable', 'string', 'distinct', $validate_cp_phone],
            'contact_person_email'         => 'nullable|array|min:1',
            'contact_person_email.*'       => 'nullable|email:rfc,dns|distinct',
            'contact_person_comment'       => 'nullable|array|min:1',
            'contact_person_comment.*'     => 'nullable|string|distinct|min:1',

            'permanent_address'          => 'required|string|max:255',
            'permanent_addr_state_id'    => 'required|exists:states,id',
            'permanent_addr_city_id'     => 'nullable|exists:cities,id',
            'permanent_addr_postal_code' => 'required|digits:6',

            'present_address'            => 'required|string|max:255',
            'present_addr_state_id'      => 'required|exists:states,id',
            'present_addr_city_id'       => 'nullable|exists:cities,id',
            'present_addr_postal_code'   => 'required|digits:6',
        ], [
            'required'    => 'This field is required.',
            'max'         => 'Maximum 100 characters allowed.',
            'exists'      => "This field's value is invalid.",
            'distinct'    => 'Duplicate value.',
            'email'       => 'This email is invalid.',
            'phone.digits'    => 'This field must contain 10 digits.',
            'whatsapp.digits' => 'This field must contain 10 digits.',
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

        // Skill Set mandatory for Service Center (Technical)
        $validator->after(function ($v) use ($request) {
            if ($request->workType === 'Service Center' && $request->service_type === 'Technical') {
                $skillIds = array_filter((array) $request->input('servicecenter_technical_skillset_ids', []));
                if (empty($skillIds)) {
                    $v->errors()->add('servicecenter_technical_skillset_ids', 'Skill Set is required for Service Center (Technical).');
                }
            }
        });

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

                $phoneCode = getPhoneCode();

                $filename = null;
                if ($request->hasFile('contact_image')) {
                    $uploadPath = public_path('media' . DIRECTORY_SEPARATOR . 'contact');
                    if (!File::exists($uploadPath)) { File::makeDirectory($uploadPath, 0755, true); }
                    $file = $request->file('contact_image');
                    $filename = 'employee_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
                    $file->move($uploadPath, $filename);
                }

                $contact = new Contact;
                $contact->contactno       = $contactno;
                $contact->cotype_id       = self::COTYPE;
                $contact->organisation_id = optional(Auth::user()?->organisation)->id ?? 1; // SD-11
                $contact->contact_name    = $request->contact_name;
                $contact->ph_prefix       = $request->phone_code ?? $phoneCode;
                $contact->phone           = $request->phone;
                $contact->whatsapp_prefix = $request->whatsapp_code ?? $phoneCode;
                $contact->whatsapp        = $request->whatsapp;
                $contact->contact_image   = $filename;
                $contact->email           = $request->email;
                $contact->gender          = $request->gender;
                $contact->religion_id     = $request->religion_id;
                $contact->dob             = $request->dob;
                $contact->doj             = $request->doj;
                $contact->blood_group     = $request->blood_group;
                $contact->reference_by    = $request->reference_by;
                $contact->work_type       = $request->workType;

                $contact->office_branch_id      = $request->office_branch_id;
                $contact->office_department_id  = $request->office_department_id;
                $contact->office_designation_id = $request->office_designation_id;
                $contact->office_jobrank_id     = $request->office_job_rank_id;

                $contact->service_type                  = $request->service_type;
                $contact->service_center_branch_id      = $request->service_center_branch_id;
                $contact->service_center_department_id  = $request->service_center_department_id;
                $contact->service_center_designation_id = $request->service_center_designation_id;
                $contact->service_center_jobrank_id     = $request->service_center_jobrank_id;

                $contact->skillset_ids = ($request->workType === 'Service Center' && $request->service_type === 'Technical' && !empty($request->servicecenter_technical_skillset_ids))
                    ? json_encode($request->servicecenter_technical_skillset_ids) : null;

                $contact->tracking_group            = $request->tracking_group;
                $contact->provident_fund_registered = $request->providentFund == 'yes' ? 'Yes' : 'No';
                $contact->provident_fund_no         = $request->provident_fund_no;
                $contact->comment                   = strip_tags($request->comment);
                $contact->created_by                = Auth::user()->id;
                $contact->save();

                $newRoleIds = $request->workType === 'Office Work' ? ($request->office_role_ids ?? []) : ($request->service_center_role_ids ?? []);
                foreach ($newRoleIds as $roleId) {
                    $cr = new Contactrole;
                    $cr->contact_id = $contact->id;
                    $cr->role_id    = $roleId;
                    $cr->save();
                }

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
                    $rc->email           = $request->get('contact_person_email')[$i] ?? null;
                    $rc->comment         = $request->get('contact_person_comment')[$i] ?? null;
                    $rc->created_by      = Auth::user()->id;
                    $rc->save();
                }

                if (!empty($request->get('permanent_address')) || !empty($request->get('permanent_addr_state_id')) || !empty($request->get('permanent_addr_postal_code'))) {
                    $a = new Coaddress;
                    $a->contact_id      = $contact->id;
                    $a->type            = 'Permanent';
                    $a->address         = $request->get('permanent_address');
                    $a->state_id        = $request->get('permanent_addr_state_id');
                    $a->city_id         = $request->get('permanent_addr_city_id');
                    $a->zipcode         = $request->get('permanent_addr_postal_code');
                    $a->additional_info = $request->get('permanent_addr_additional_info');
                    $a->save();
                }

                if (!empty($request->get('present_address')) || !empty($request->get('present_addr_state_id')) || !empty($request->get('present_addr_postal_code'))) {
                    $a = new Coaddress;
                    $a->contact_id      = $contact->id;
                    $a->type            = 'Present';
                    $a->address         = $request->get('present_address');
                    $a->state_id        = $request->get('present_addr_state_id');
                    $a->city_id         = $request->get('present_addr_city_id');
                    $a->zipcode         = $request->get('present_addr_postal_code');
                    $a->additional_info = $request->get('present_addr_additional_info');
                    $a->save();
                }

                if (!empty($request->get('bank_id'))) {
                    $b = new Contactbank;
                    $b->contact_id       = $contact->id;
                    $b->bank_id          = $request->bank_id;
                    $b->account_number   = $request->account_number;
                    $b->beneficiary_name = $request->beneficiary_name;
                    $b->ifsc_code        = $request->ifsc_code;
                    $b->upi_id           = $request->upi_id;
                    $b->save();
                }

                $attachtypes = $request->attachtypes;
                if (!empty($attachtypes)) {
                    foreach ($attachtypes as $key => $attachtype) {
                        if (isset($request->file('files')[$key])) {
                            foreach ($request->file('files')[$key] as $file) {
                                $extension = $file->getClientOriginalExtension();
                                $fname = 'contact-attachment-' . Str::random(4) . '_' . time() . '.' . $extension;
                                $__fsize = $file->getSize(); $__foname = $file->getClientOriginalName(); $file->move(public_path('media' . DIRECTORY_SEPARATOR . 'contact' . DIRECTORY_SEPARATOR), $fname);
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

                $this->storeUseractivity(3, 3, Auth::user()->id, $contact->id, 'Added new employee contact with ID ' . $contact->id);

                return $contact;
            });

            return response()->json(['success' => true, 'data' => $contact, 'message' => 'Employee saved successfully.', 'redirect' => route('contact.v2.employee.show', $contact->id)], 200);
        } catch (\Exception $exp) {
            return response()->json(['success' => false, 'data' => [], 'message' => $exp->getMessage()], 500);
        }
    }

    /* ---------------------------------------------------------------
     | Edit / Update  (← updateEmployee)
     | --------------------------------------------------------------- */
    public function update(Request $request, $id)
    {
        $request->merge([
            'phone'    => preg_replace('/\s+/', '', $request->phone),
            'whatsapp' => preg_replace('/\s+/', '', $request->whatsapp),
            'email'    => $request->email !== null ? trim($request->email) : null,
        ]);

        $contact = Contact::where('cotype_id', self::COTYPE)->find($id);
        if (!$contact) {
            return response()->json(['success' => false, 'data' => [], 'message' => 'Employee not found.'], 422);
        }

        $validate_phone = function ($attribute, $value, $fail) use ($request, $id) {
            $code = $request->phone_code;
            if (!$code) { $fail('Phone number required country code to be selected.'); return; }
            if (Contact::where('phone', $value)->where('ph_prefix', $code)->where('id', '!=', $id)->exists()) {
                $fail('This phone number already exists.');
            }
        };
        $validate_cp_phone = function (string $attribute, mixed $value, Closure $fail) use ($request) {};

        $validator = Validator::make($request->all(), [
            'contact_name'        => 'required|max:100',
            'contact_image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'phone'               => ['required', 'digits:10', $validate_phone],
            'whatsapp'            => ['nullable', 'digits:10'],
            'email'               => 'nullable|email|unique:contacts,email,' . $id,
            'gender'              => 'required|in:Male,Female,Other',
            'religion_id'         => 'required|exists:religions,id',
            'dob'                 => 'required|date_format:Y-m-d',
            'doj'                 => 'required|date|after:dob|before_or_equal:today',
            'blood_group'         => 'required|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'reference_by'        => 'required|max:100',

            'workType'              => 'required|in:Office Work,Service Center',
            'office_branch_id'      => 'nullable|required_if:workType,Office Work|exists:branches,id',
            'office_department_id'  => 'nullable|required_if:workType,Office Work|exists:departments,id',
            'office_designation_id' => 'nullable|required_if:workType,Office Work|exists:designations,id',
            'office_job_rank_id'    => 'nullable|required_if:workType,Office Work|exists:jobranks,id',
            'office_role_ids'       => 'nullable|required_if:workType,Office Work|array|min:1',
            'office_role_ids.*'     => 'exists:roles,id',

            'service_type'                  => 'nullable|required_if:workType,Service Center|in:Administrative,Technical',
            'service_center_branch_id'      => 'nullable|required_if:workType,Service Center|exists:branches,id',
            'service_center_department_id'  => 'nullable|required_if:workType,Service Center|exists:departments,id',
            'service_center_designation_id' => 'nullable|required_if:workType,Service Center|exists:designations,id',
            'service_center_jobrank_id'     => 'nullable|required_if:workType,Service Center|exists:jobranks,id',
            'service_center_role_ids'       => 'nullable|required_if:workType,Service Center|array|min:1',
            'service_center_role_ids.*'     => 'exists:roles,id',

            'servicecenter_technical_skillset_ids'   => ['nullable', 'array', 'min:1'],
            'servicecenter_technical_skillset_ids.*' => 'exists:skillsets,id',

            'tracking_group'    => 'required|in:Tracking A,Tracking B',
            'providentFund'     => 'nullable|in:yes,no',
            'provident_fund_no' => 'nullable|required_if:providentFund,yes|alpha_num|max:25',
            'comment'           => 'nullable|string|max:100000',
            'status'            => 'nullable|in:Active,Inactive,Blacklisted',
            'blacklist_reason'  => 'required_if:status,Blacklisted',

            'contact_person_name'          => 'required|array|min:1',
            'contact_person_name.*'        => 'required|string|distinct|min:1',
            'contact_person_relation'      => 'nullable|array|min:1',
            'contact_person_relation.*'    => 'nullable|string|min:1',
            'contact_person_blood_group'   => 'nullable|array|min:1',
            'contact_person_blood_group.*' => 'nullable|string|min:1',
            'contact_person_address'       => 'nullable|array|min:1',
            'contact_person_address.*'     => 'nullable|string|min:1',
            'contact_person_ph_code'       => 'nullable|array|min:1',
            'contact_person_phone'         => 'required|array|min:1',
            'contact_person_phone.*'       => ['required', 'string', 'distinct', $validate_cp_phone],
            'contact_person_whatsapp_code' => 'nullable|array|min:1',
            'contact_person_whatsapp'      => 'nullable|array|min:1',
            'contact_person_whatsapp.*'    => ['nullable', 'string', 'distinct', $validate_cp_phone],
            'contact_person_email'         => 'nullable|array|min:1',
            'contact_person_email.*'       => 'nullable|email:rfc,dns|distinct',
            'contact_person_comment'       => 'nullable|array|min:1',
            'contact_person_comment.*'     => 'nullable|string|distinct|min:1',

            'permanent_address'          => 'required|string|max:255',
            'permanent_addr_state_id'    => 'required|exists:states,id',
            'permanent_addr_city_id'     => 'nullable|exists:cities,id',
            'permanent_addr_postal_code' => 'required|digits:6',

            'present_address'            => 'required|string|max:255',
            'present_addr_state_id'      => 'required|exists:states,id',
            'present_addr_city_id'       => 'nullable|exists:cities,id',
            'present_addr_postal_code'   => 'required|digits:6',
        ], [
            'required'    => 'This field is required.',
            'max'         => 'Maximum 100 characters allowed.',
            'exists'      => "This field's value is invalid.",
            'distinct'    => 'Duplicate value.',
            'email'       => 'This email is invalid.',
            'phone.digits'    => 'This field must contain 10 digits.',
            'whatsapp.digits' => 'This field must contain 10 digits.',
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

        $validator->after(function ($v) use ($request) {
            if ($request->workType === 'Service Center' && $request->service_type === 'Technical') {
                $skillIds = array_filter((array) $request->input('servicecenter_technical_skillset_ids', []));
                if (empty($skillIds)) {
                    $v->errors()->add('servicecenter_technical_skillset_ids', 'Skill Set is required for Service Center (Technical).');
                }
            }
        });

        $errormessages = array_merge($validator->getMessageBag()->toArray(), $errors);
        if ($validator->fails() || $errorcount > 0) {
            return response()->json(['success' => false, 'data' => $errormessages, 'message' => 'Please check validation error.'], 422);
        }

        try {
            DB::transaction(function () use ($request, $contact) {
                $phoneCode = getPhoneCode();

                $filename = $contact->contact_image;
                if ($request->hasFile('contact_image')) {
                    $uploadPath = public_path('media' . DIRECTORY_SEPARATOR . 'contact');
                    if (!File::exists($uploadPath)) { File::makeDirectory($uploadPath, 0755, true); }
                    $file = $request->file('contact_image');
                    $filename = 'employee_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
                    $file->move($uploadPath, $filename);
                } elseif ($request->input('remove_contact_image') == '1') {
                    if (!empty($contact->contact_image)) {
                        $oldPath = public_path('media' . DIRECTORY_SEPARATOR . 'contact' . DIRECTORY_SEPARATOR . $contact->contact_image);
                        if (File::exists($oldPath)) { File::delete($oldPath); }
                    }
                    $filename = null;
                }

                $contact->contact_name    = $request->contact_name;
                $contact->ph_prefix       = $request->phone_code ?? $phoneCode;
                $contact->phone           = $request->phone;
                $contact->whatsapp_prefix = $request->whatsapp_code ?? $phoneCode;
                $contact->whatsapp        = $request->whatsapp;
                $contact->contact_image   = $filename;
                $contact->email           = $request->email;
                $contact->gender          = $request->gender;
                $contact->religion_id     = $request->religion_id;
                $contact->dob             = $request->dob;
                $contact->doj             = $request->doj;
                $contact->blood_group     = $request->blood_group;
                $contact->reference_by    = $request->reference_by;
                $contact->work_type       = $request->workType;

                $contact->office_branch_id      = $request->office_branch_id;
                $contact->office_department_id  = $request->office_department_id;
                $contact->office_designation_id = $request->office_designation_id;
                $contact->office_jobrank_id     = $request->office_job_rank_id;

                $contact->service_type                  = $request->service_type;
                $contact->service_center_branch_id      = $request->service_center_branch_id;
                $contact->service_center_department_id  = $request->service_center_department_id;
                $contact->service_center_designation_id = $request->service_center_designation_id;
                $contact->service_center_jobrank_id     = $request->service_center_jobrank_id;

                $contact->skillset_ids = ($request->workType === 'Service Center' && $request->service_type === 'Technical' && !empty($request->servicecenter_technical_skillset_ids))
                    ? json_encode($request->servicecenter_technical_skillset_ids) : null;

                $contact->tracking_group            = $request->tracking_group;
                $contact->provident_fund_registered = $request->providentFund == 'yes' ? 'Yes' : 'No';
                $contact->provident_fund_no         = $request->provident_fund_no;
                $contact->comment                   = $request->comment;
                $contact->status                    = $request->get('status') ?? 'Active';
                $contact->blacklist_reason          = $request->get('blacklist_reason') ?? null;
                $contact->blacklisted_at            = $request->get('status') === 'Blacklisted' ? now() : null;
                $contact->updated_by                = Auth::user()->id;
                $contact->save();

                if ($request->filled('blacklist_reason')) {
                    $activity = new Contactactivity();
                    $activity->contact_id     = $contact->id;
                    $activity->notes          = $request->blacklist_reason;
                    $activity->is_blacklisted = 'Yes';
                    $activity->created_by     = Auth::user()->id;
                    $activity->save();
                }

                $newRoleIds = $request->workType === 'Office Work' ? ($request->office_role_ids ?? []) : ($request->service_center_role_ids ?? []);
                Contactrole::where('contact_id', $contact->id)->whereNotIn('role_id', $newRoleIds)->delete();
                foreach ($newRoleIds as $roleId) {
                    $role = Contactrole::withTrashed()->where('contact_id', $contact->id)->where('role_id', $roleId)->first();
                    if ($role) {
                        $role->restore();
                    } else {
                        $cr = new Contactrole;
                        $cr->contact_id = $contact->id;
                        $cr->role_id    = $roleId;
                        $cr->save();
                    }
                }

                $relcontact_ids = [];
                foreach ($request->contact_person_name as $i => $name) {
                    $rc = Relcontact::where('id', $request->contact_person_id[$i] ?? 0)->where('contact_id', $contact->id)->first();
                    if (!$rc) { $rc = new Relcontact(); $rc->contact_id = $contact->id; }
                    $rc->name            = $name;
                    $rc->relationship    = $request->contact_person_relation[$i] ?? null;
                    $rc->blood_group     = $request->contact_person_blood_group[$i] ?? null;
                    $rc->address         = $request->contact_person_address[$i] ?? null;
                    $rc->ph_prefix       = $request->contact_person_ph_code[$i] ?? $phoneCode;
                    $rc->phone           = $request->contact_person_phone[$i] ?? null;
                    $rc->whatsapp_prefix = $request->contact_person_whatsapp_code[$i] ?? $phoneCode;
                    $rc->whatsapp        = $request->contact_person_whatsapp[$i] ?? null;
                    $rc->email           = $request->contact_person_email[$i] ?? null;
                    $rc->comment         = $request->contact_person_comment[$i] ?? null;
                    $rc->save();
                    $relcontact_ids[] = $rc->id;
                }
                Relcontact::where('contact_id', $contact->id)->whereNotIn('id', $relcontact_ids)->delete();

                // Addresses (E5) — Permanent + Present: delete + re-create from form
                Coaddress::where('contact_id', $contact->id)->whereIn('type', ['Permanent', 'Present'])->delete();
                if (!empty($request->get('permanent_address')) || !empty($request->get('permanent_addr_state_id')) || !empty($request->get('permanent_addr_postal_code'))) {
                    $a = new Coaddress;
                    $a->contact_id      = $contact->id;
                    $a->type            = 'Permanent';
                    $a->address         = $request->get('permanent_address');
                    $a->state_id        = $request->get('permanent_addr_state_id');
                    $a->city_id         = $request->get('permanent_addr_city_id');
                    $a->zipcode         = $request->get('permanent_addr_postal_code');
                    $a->additional_info = $request->get('permanent_addr_additional_info');
                    $a->save();
                }
                if (!empty($request->get('present_address')) || !empty($request->get('present_addr_state_id')) || !empty($request->get('present_addr_postal_code'))) {
                    $a = new Coaddress;
                    $a->contact_id      = $contact->id;
                    $a->type            = 'Present';
                    $a->address         = $request->get('present_address');
                    $a->state_id        = $request->get('present_addr_state_id');
                    $a->city_id         = $request->get('present_addr_city_id');
                    $a->zipcode         = $request->get('present_addr_postal_code');
                    $a->additional_info = $request->get('present_addr_additional_info');
                    $a->save();
                }

                $attachtypes = $request->attachtypes;
                if (!empty($attachtypes)) {
                    foreach ($attachtypes as $key => $attachtype) {
                        if (isset($request->file('files')[$key])) {
                            foreach ($request->file('files')[$key] as $file) {
                                $extension = $file->getClientOriginalExtension();
                                $fname = 'contact-attachment-' . Str::random(4) . '_' . time() . '.' . $extension;
                                $__fsize = $file->getSize(); $__foname = $file->getClientOriginalName(); $file->move(public_path('media' . DIRECTORY_SEPARATOR . 'contact' . DIRECTORY_SEPARATOR), $fname);
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

                // Contactbank single hasOne — upsert/soft-delete
                $existingBank = Contactbank::where('contact_id', $contact->id)->first();
                if (!empty($request->get('bank_id'))) {
                    $b = $existingBank ?: new Contactbank;
                    $b->contact_id       = $contact->id;
                    $b->bank_id          = $request->bank_id;
                    $b->account_number   = $request->account_number;
                    $b->beneficiary_name = $request->beneficiary_name;
                    $b->ifsc_code        = $request->ifsc_code;
                    $b->upi_id           = $request->upi_id;
                    $b->save();
                } elseif ($existingBank) {
                    $existingBank->delete();
                }

                $this->storeUseractivity(3, 4, Auth::user()->id, $contact->id, 'Employee Updated [ID: ' . $contact->id . '].');

                return $contact;
            });

            return response()->json(['success' => true, 'data' => $contact, 'message' => 'Employee updated successfully.', 'redirect' => route('contact.v2.employee.show', $contact->id)], 200);
        } catch (\Exception $exp) {
            return response()->json(['success' => false, 'data' => [], 'message' => $exp->getMessage()], 500);
        }
    }

    /* ---------------------------------------------------------------
     | Assets — issue / revoke  (← storeEmployeeAsset / revokeEmployeeAsset)
     | --------------------------------------------------------------- */
    public function storeAsset(Request $request)
    {
        $contact = Contact::find($request->contact_id);
        if (!$contact) {
            return response()->json(['success' => false, 'data' => [], 'message' => 'Employee not found!'], 422);
        }

        $validator = Validator::make($request->all(), [
            'asset_type' => 'required|in:Motor Vehicle,Electronics,Others',
            'asset_id'   => 'required|exists:assets,id',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'data' => $validator->errors(), 'message' => 'Please check validation errors.'], 422);
        }

        $alreadyAssigned = Employeeasset::where('contact_id', $request->contact_id)->where('asset_id', $request->asset_id)->where('status', 'Assigned')->exists();
        if ($alreadyAssigned) {
            return response()->json(['success' => false, 'message' => 'This asset is already assigned to this employee.'], 422);
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
                $this->storeUseractivity(51, 3, Auth::user()->id, $empasset->id, 'Asset [ID: ' . $request->asset_id . '] assigned to Employee [ID: ' . $request->contact_id . ']');
                return $empasset;
            });

            return response()->json(['success' => true, 'data' => $empasset, 'message' => 'Asset assigned successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Something went wrong'], 500);
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

        $employeeAsset = Employeeasset::find($request->employeeasset_id);
        if (!$employeeAsset || $employeeAsset->status !== 'Assigned') {
            return response()->json(['success' => false, 'message' => 'Asset is already revoked or not found.'], 422);
        }

        try {
            $result = DB::transaction(function () use ($request, $employeeAsset) {
                $employeeAsset->status      = 'Unassigned';
                $employeeAsset->revoke_date = $request->revoke_date;
                $employeeAsset->comment     = $request->revoke_reason;
                $employeeAsset->save();

                $log = new Employeeallotedassetlog;
                $log->employeeasset_id = $employeeAsset->id;
                $log->contact_id       = $employeeAsset->contact_id;
                $log->asset_id         = $employeeAsset->asset_id;
                $log->status           = 'Unassigned';
                $log->revoke_date      = $request->revoke_date;
                $log->comment          = $request->revoke_reason;
                $log->created_by       = Auth::user()->id;
                $log->save();

                $this->storeUseractivity(51, 3, Auth::user()->id, $employeeAsset->id, 'Asset [ID: ' . $employeeAsset->asset_id . '] revoked from Employee [ID: ' . $employeeAsset->contact_id . ']');
                return $employeeAsset;
            });

            return response()->json(['success' => true, 'data' => $result, 'message' => 'Asset revoked successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Something went wrong'], 500);
        }
    }

    /* ---------------------------------------------------------------
     | Joining / Work Experience  (← storeEmployeeWorkExperience)
     | --------------------------------------------------------------- */
    public function storeWorkExperience(Request $request)
    {
        $contact = Contact::where('cotype_id', self::COTYPE)->find($request->contact_id);
        if (!$contact) {
            return response()->json(['success' => false, 'data' => [], 'message' => 'Employee not found!'], 422);
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
            'previous_legal_case'         => 'required|in:Yes,No',
            'previous_legal_case_comment' => 'required_if:previous_legal_case,Yes',
            'previous_city_id'            => 'required_if:previous_legal_case,Yes|nullable|exists:cities,id',
            'previous_police_station'     => 'required_if:previous_legal_case,Yes|nullable|string|max:255',
            'previous_notes'              => 'nullable|string',
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
            $empWorkExp = DB::transaction(function () use ($request) {
                $startDate = null; $endDate = null;
                $dates = explode(' - ', $request->previous_employment_duration);
                if (count($dates) === 2) {
                    $startDate = Carbon::createFromFormat('d/m/Y', trim($dates[0]))->format('Y-m-d');
                    $endDate   = Carbon::createFromFormat('d/m/Y', trim($dates[1]))->format('Y-m-d');
                }
                $w = new Employeeworkexperience;
                $w->contact_id            = $request->contact_id;
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
                $this->storeUseractivity(52, 3, Auth::user()->id, $w->id, 'Employee [ID: ' . $request->contact_id . '] work experience added.');
                return $w;
            });

            return response()->json(['success' => true, 'data' => $empWorkExp, 'message' => 'Work experience added successfully.'], 200);
        } catch (\Exception $exp) {
            return response()->json(['success' => false, 'data' => [], 'message' => $exp->getMessage()], 500);
        }
    }

    /* ---------------------------------------------------------------
     | Salary  (← storeEmployeeSalary)
     | --------------------------------------------------------------- */
    public function storeSalary(Request $request)
    {
        $contact = Contact::where('cotype_id', self::COTYPE)->find($request->contact_id);
        if (!$contact) {
            return response()->json(['success' => false, 'data' => [], 'message' => 'Employee not found!'], 422);
        }

        $validator = Validator::make($request->all(), [
            'contact_id'      => 'required|exists:contacts,id',
            'basic_pay'       => 'required|numeric|min:1',
            'salary_per_work' => 'required_if:service_type,Technical|numeric|min:1',
            'effective_from'  => 'required|date|before_or_equal:today|date_format:Y-m-d',
        ], [
            'required' => 'This field is required.',
            'numeric'  => 'Only numeric values are allowed.',
            'min'      => 'Value must be at least :min.',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'data' => $validator->errors(), 'message' => 'Please check validation errors.'], 422);
        }

        try {
            $empSalary = DB::transaction(function () use ($request) {
                $s = new Employeesalary;
                $s->contact_id      = $request->contact_id;
                $s->basic_pay       = $request->basic_pay ?? 0;
                $s->salary_per_work = $request->salary_per_work ?? 0;
                $s->effective_from  = $request->effective_from;
                $s->created_by      = Auth::user()->id;
                $s->save();
                $this->storeUseractivity(52, 3, Auth::user()->id, $s->id, 'Employee [ID: ' . $request->contact_id . '] salary added.');
                return $s;
            });

            return response()->json(['success' => true, 'data' => $empSalary, 'message' => 'Employee salary added successfully.'], 200);
        } catch (\Exception $exp) {
            return response()->json(['success' => false, 'data' => [], 'message' => $exp->getMessage()], 500);
        }
    }

    /* ---------------------------------------------------------------
     | Exit  (← storeEmployeeExitDetails)  — sets E2 $isExited
     | --------------------------------------------------------------- */
    public function storeExitDetails(Request $request)
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
            'exit_date.after_or_equal' => 'Exit date cannot be before the joining date.',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'data' => $validator->errors(), 'message' => 'Please check validation errors.'], 422);
        }

        if (Employeeexitdetail::where('contact_id', $request->contact_id)->exists()) {
            return response()->json(['success' => false, 'message' => 'Exit details already exist for this employee.'], 422);
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
                $this->storeUseractivity(3, 3, Auth::user()->id, $request->contact_id, 'Employee [ID: ' . $request->contact_id . '] exit details recorded.');
                return $x;
            });

            return response()->json(['success' => true, 'data' => $exitDetails, 'message' => 'Exit detail saved successfully.'], 200);
        } catch (\Exception $exp) {
            return response()->json(['success' => false, 'data' => [], 'message' => $exp->getMessage()], 500);
        }
    }

    /* ---------------------------------------------------------------
     | E1 letter seen-status  (← updateLetterSeenStatus)
     | --------------------------------------------------------------- */
    public function updateLetterSeenStatus(Request $request)
    {
        $contact = Contact::find($request->contact_id);
        if (!$contact) {
            return response()->json(['status' => false, 'message' => 'Employee not found.'], 422);
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

    /* ---------------------------------------------------------------
     | Documents — attachment store / delete
     | --------------------------------------------------------------- */
    public function storeAttachment(Request $request)
    {
        $contact = Contact::where('cotype_id', self::COTYPE)->find($request->contact_id);
        if (!$contact) {
            return response()->json(['success' => false, 'message' => 'Employee not found.'], 422);
        }

        $validator = Validator::make($request->all(), [
            'contact_id'      => 'required|exists:contacts,id',
            'coattachtype_id' => 'required|exists:coattachtypes,id',
            'files'           => 'required|array|min:1|max:2',
            'files.*'         => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ], [
            'required' => 'This field is required.',
            'files.max' => 'You cannot upload more than 2 files.',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'data' => $validator->errors(), 'message' => 'Please check validation errors.'], 422);
        }

        try {
            $saved = DB::transaction(function () use ($request, $contact) {
                $records = [];
                foreach ($request->file('files') as $file) {
                    $extension = $file->getClientOriginalExtension();
                    $fname = 'contact-attachment-' . Str::random(4) . '_' . time() . '.' . $extension;
                    $__fsize = $file->getSize(); $__foname = $file->getClientOriginalName(); $file->move(public_path('media' . DIRECTORY_SEPARATOR . 'contact' . DIRECTORY_SEPARATOR), $fname);
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
                $this->storeUseractivity(3, 3, Auth::user()->id, $contact->id, 'Employee [ID: ' . $contact->id . '] document uploaded.');
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

    /* ---------------------------------------------------------------
     | Activity — note store
     | --------------------------------------------------------------- */
    public function storeActivityNote(Request $request)
    {
        $contact = Contact::where('cotype_id', self::COTYPE)->find($request->contact_id);
        if (!$contact) {
            return response()->json(['success' => false, 'message' => 'Employee not found.'], 422);
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
}
